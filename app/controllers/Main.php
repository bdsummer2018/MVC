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
use core\auth\Auth;
use core\auth\Credential;
use core\base\Controller;
use core\base\TemplateView;
use core\base\View;
use core\db\DBQueryBuilder;

class Main extends Controller
{
    public function actionIndex(){
        $view = new TemplateView("main","templates/def");

       // Auth::instance();
        $view->films = Film::get();
        $view->films2 = User::where("login","vasia")->first()->films()->get();
        $view->hh="dfgdf";
        return $view;
    }


    public function actionSecure(){

        if(Auth::instance()->isAuth()){
            return "hello ".Auth::instance()->getCredentials()->getLogin();
        }
        return ":(";
    }
    public function actionLogout(){
        Auth::instance()->logout();
        return "redirect:/main/secure";
    }
    public function actionLogin(){
        $login = empty($_GET["login"])?null:$_GET["login"];
        $password = empty($_GET["pass"])?null:$_GET["pass"];
        if($login===null||$password===null)
            return "some is empty";
        if(!Auth::instance()->login(new Credential($login,$password)))
            return "invalid login or pass";
        return "redirect:/main/secure";

    }
}