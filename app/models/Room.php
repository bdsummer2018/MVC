<?php
/**
 * Created by PhpStorm.
 * User: mamedov
 * Date: 13.03.2019
 * Time: 19:08
 */
namespace app\models;
class Room extends \core\base\Model
{
    protected static $table="rooms";

    protected function getIdName(){
        return "rooms_id";
    }


    public $rooms_id;
    public $rooms_name;
    public $rooms_rooms_id;

    public function childRooms(){
        return $this->hasMany(Room::class,"rooms_rooms_id","rooms_id");
    }

}