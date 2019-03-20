<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 18.03.2019
 * Time: 16:32
 */
namespace app\controllers;
use app\mappers\DepartDTOMapper;
use app\services\DepartsService;
use core\base\RestController;
class DepartsApi extends RestController
{
    private $departService;
    public function __construct(){
        parent::__construct();
        $this->departService = new DepartsService();
    }
    public function actionGetRootDeparts(){
        return DepartDTOMapper::mapDepartArray2DTO(
            $this->departService->getRoots()
        );
    }
    public function actionGetChildDeparts(){
        return DepartDTOMapper::mapDepartArray2DTO(
            $this->departService->getChildren($this->getParam("id"))
        );
    }
    public function actionAddDeparts(){
        $name = $this->request()->getBodyParam("name");
        $parentId = $this->request()->getBodyParam("parentId");
        $this->departService->create($name,$parentId);
    }
}