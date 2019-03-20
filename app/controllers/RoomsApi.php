<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 18.03.2019
 * Time: 16:36
 */
namespace app\controllers;
use app\mappers\RoomDTOMapper;
use app\services\RoomService;
use core\base\RestController;
class RoomsApi extends RestController
{
    private $roomService;
    public function __construct(){
        parent::__construct();
        $this->roomService = new RoomService();
    }
    public function actionGetRootRooms(){
        return RoomDTOMapper::mapRoomArray2DTO(
            $this->roomService->getRoots()
        );
    }
    public function actionGetChildRooms(){
        return RoomDTOMapper::mapRoomArray2DTO(
            $this->roomService->getChildren($this->getParam("id"))
        );
    }
    public function actionAddRooms(){
        $name = $this->request()->getBodyParam("name");
        $parentId = $this->request()->getBodyParam("parentId");
        $this->roomService->create($name,$parentId);
    }
}