<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 18.03.2019
 * Time: 15:15
 */
namespace app\services;
use app\models\Room;
class RoomService
{
    public function getRoots():array {
        return Room::where("rooms_rooms_id",""," IS NULL",true)->get();
    }
    public function getChildren(int $id):array {
        $room = new Room(["rooms_id"=>$id]);
        return $room->childRooms()->get();
    }
    public function create(string $name,int $parentId){
        $room = new Room(["rooms_name"=>$name,"rooms_rooms_id"=>$parentId]);
        $room->save();
    }
}