<?php

namespace app\models;
use core\base\Model;

class Depart extends Model
{
    protected static $table="departs";

    protected function getIdName(){
        return "departs_id";
    }

    public $departs_id;
    public $departs_name;
    public $departs_departs_id;

    public function childDeparts(){
        return $this->hasMany(
            Depart::class,
            "departs_departs_id",
            "departs_id"
        );
    }


}