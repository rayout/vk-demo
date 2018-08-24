<?php

namespace App\controllers;

use App\models\OrderModel;
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
}