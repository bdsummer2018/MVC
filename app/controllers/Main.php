<?php
/**
 * Created by PhpStorm.
 * User: mamedov
 * Date: 11.02.2019
 * Time: 19:35
 */

namespace app\controllers;


use core\base\Controller;
use core\base\TemplateView;
use core\base\View;
use core\db\DBQueryBuilder;

class Main extends Controller
{
    public function actionIndex(){
        $view = new TemplateView("main","templates/def");
        $qb = new DBQueryBuilder();
        $qb2 = new DBQueryBuilder("mysql");
        echo "<pre>";
        print_r(
            $qb->from("films")
                ->where("year",">",2001)
                ->andWhere("year","<",2008)
                ->andWhereGroup(function (DBQueryBuilder $w){
                    $w->where("id",7)->orWhere("id",12);
                })
                ->all()
        );
        print_r(
            $qb->select(["User","Password"])->from("mysql..user")->all()
        );
        $view->hh="sdf";
        return $view;
    }
}