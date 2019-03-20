<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 18.03.2019
 * Time: 15:49
 */
namespace app\mappers;
use app\models\Room;
class RoomDTOMapper
{
    public static function mapRoom2DTO(Room $room){
        return [
            "id" => $room->rooms_id,
            "name" => $room->rooms_name,
            "parentId" => $room->rooms_rooms_id
        ];
    }
    public static function mapRoomArray2DTO(array $rooms){
        return array_map("self::mapRoom2DTO",$rooms);
    }
}