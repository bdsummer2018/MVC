<?php
namespace app\mappers;
use app\models\Depart;

/**
 * Created by PhpStorm.
 * User: mamedov
 * Date: 13.03.2019
 * Time: 19:52
 */

class DepartDTOMapper
{
    public static function mapDepart2DTO(Depart $depart){
        return [
            "id" => $depart->departs_id,
            "name" => $depart->departs_name,
            "parentId" => $depart->departs_departs_id
        ];
    }
    public static function mapDepartArray2DTO(array $departs){
        return array_map("self::mapDepart2DTO",$departs);
    }

}