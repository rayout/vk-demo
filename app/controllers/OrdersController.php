<?php

namespace App\controllers;

use App\models\OrderModel;
use App\models\TransactionModel;
use App\models\UserModel;
use Core\Request;
use Core\Response;


class OrdersController {

    public function get(Request $request, Response $response){
        $offset_id = $request->get('offset_id') ? $request->get('offset_id') : 0;
        $limit = $request->get('limit') ? $request->get('limit') : 20;

        $orders = OrderModel::getInstance()->get($limit, $offset_id);

        if($orders){
            $response->json(['success' => true, 'orders' => $orders]);
        }else{
            $response->json(['success' => false], 404);
        }
    }

    public function add(Request $request, Response $response)
    {
        $order = [];
        $order['title'] = $request->get('title');
        $order['price'] = intval($request->get('price'));

        //TODO вынести в класс валидации
        if(empty($order['title']) and mb_strlen($order['title']) > 128){
            return $response->json(['success' => false, 'error' => 'Название не может быть пустым и больше 128 символов'], 403);
        }
        if($order['price'] == 0){
            return $response->json(['success' => false, 'error' => 'Цена не может быть равной 0'], 403);
        }

        if(!auth()->exists() || auth()->user()->role != 'customer'){
            return $response->json(['success' => false, 'error' => 'Авторизуйтесь как заказчик для доступа'], 403);
        }

        if(auth()->user()->balance < $order['price']){
            return $response->json(['success' => false, 'error' => 'На балансе не достаточно средств для размещения заказа'], 403);
        }

        $order['customer_user_id'] = auth()->user()->id;

        //TODO учитывать возможгную ошиюку на любом шаге и откат всей цепочки. (сейчас контролируется только баланс)

        // открываем транзакцию
        UserModel::getInstance()->beginTransaction();
        // получаем текущий баланс и блокируем строку
        $current_balance = UserModel::getInstance()->single("SELECT balance from users where id = ? FOR UPDATE", [auth()->user()->id]);
        // формируем транзакционную запись для истории
        $transaction = TransactionModel::getInstance()->open(auth()->user(), -$order['price']);
        // добавляем заказ
        OrderModel::getInstance()->addOrder($order);
        // закрываем транзакцию в истории
        TransactionModel::getInstance()->close($transaction);
        //  уменьшаем баланс пользователя
        $current_balance = UserModel::getInstance()->decreaseBalance(auth()->user()->id,$current_balance - $order['price']);
        // закрываем основую транзакцию
        UserModel::getInstance()->commit();

        $response->json(['success' => true, 'balance' => $current_balance]);
    }

    public function execute(Request $request, Response $response)
    {
        $order_id = $request->get('id');
        $user_id = auth()->user()->id;

        OrderModel::getInstance()->beginTransaction();
        $order = OrderModel::getInstance()->row("SELECT * from orders where id = ? FOR UPDATE", $order_id);

        if($order['completed']){
            OrderModel::getInstance()->commit();
            return $response->json(['success' => false, 'error' => 'Заказ уже выполнен'], 403);
        }
        OrderModel::getInstance()->complete($order_id, $user_id);
        OrderModel::getInstance()->commit();

        // Изменяем баланс пользователя
        UserModel::getInstance()->beginTransaction();
        // формируем транзакционную запись для истории
        $transaction = TransactionModel::getInstance()->open(auth()->user(), $order['price']);
        $current_balance = UserModel::getInstance()->single("SELECT balance from users where id = ? FOR UPDATE", [auth()->user()->id]);
        $current_balance = UserModel::getInstance()->increaseBalance(auth()->user()->id,$current_balance + $order['price']);
        // закрываем транзакцию в истории
        TransactionModel::getInstance()->close($transaction);
        UserModel::getInstance()->commit();

        $response->json(['success' => true, 'balance' => $current_balance]);
    }
}