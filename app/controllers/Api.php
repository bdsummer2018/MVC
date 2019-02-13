<?php
/**
 * Created by PhpStorm.
 * User: mamedov
 * Date: 11.02.2019
 * Time: 20:17
 */

namespace app\controllers;


use core\base\RestController;

class Api extends RestController
{
    public function actionTodo(){
        return [
            "name"=>"vasia",
            "surname"=>"ivanov",
            "x"=>$this->getParam("x")
        ];

    }
}