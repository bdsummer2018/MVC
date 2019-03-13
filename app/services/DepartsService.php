<?php
/**
 * Created by PhpStorm.
 * User: mamedov
 * Date: 13.03.2019
 * Time: 19:57
 */

namespace app\services;


use app\models\Depart;

class DepartsService
{
    public function getRoots():array {
        return Depart::where("departs_departs_id",""," IS NULL",true)->get();
    }

    public function getChildren(int $id):array {
        $depart = new Depart(["departs_id"=>$id]);
        return $depart->childDeparts()->get();
    }

    public function create(string $name,int $parentId){
        $depart = new Depart(["departs_name"=>$name,"departs_departs_id"=>$parentId]);
        $depart->save();
    }
}