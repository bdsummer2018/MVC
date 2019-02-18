<?php
/**
 * Created by PhpStorm.
 * User: mamedov
 * Date: 11.02.2019
 * Time: 19:35
 */

namespace app\controllers;


use app\models\Film;
use app\models\User;
use core\base\Controller;
use core\base\TemplateView;
use core\base\View;
use core\db\DBQueryBuilder;

class Main extends Controller
{
    public function actionIndex(){
        $view = new TemplateView("main","templates/def");

        $view->films = Film::get();
        $view->films2 = User::where("login","vasia")->first()->films()->get();
        $view->hh="dfgdf";
        return $view;
    }
}