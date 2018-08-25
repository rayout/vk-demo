<?php

namespace App\controllers;

use App\models\UserModel;
use Core\Request;
use Core\Response;

class MainController {

    public function index(Request $request, Response $response){
        echo 'it is works!';
    }

    public function notFound(Request $request, Response $response){
        $response->json(['error' => 'not_found'], 404);
    }

    public function test1(){
        UserModel::getInstance()->beginTransaction();
        $current_balance = UserModel::getInstance()->single("SELECT balance from users where id = ? FOR UPDATE", [1]);
        sleep(10);
        UserModel::getInstance()->decreaseBalance(1,900);
        UserModel::getInstance()->commit();
        dd(UserModel::getInstance()->run("SELECT balance from users where id = ? ", 1));
    }

    public function test2(){
        UserModel::getInstance()->beginTransaction();
        $current_balance = UserModel::getInstance()->single("SELECT balance from users where id = ? FOR UPDATE", [1]);
        UserModel::getInstance()->decreaseBalance(1,500);
        UserModel::getInstance()->commit();
        dd(UserModel::getInstance()->run("SELECT balance from users where id = ? ", 1));
    }
}