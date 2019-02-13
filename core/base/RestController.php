<?php
/**
 * Created by PhpStorm.
 * User: mamedov
 * Date: 11.02.2019
 * Time: 20:16
 */

namespace core\base;


abstract class RestController extends Controller
{
    public function execAction(string $action)
    {
        return json_encode(parent::execAction($action));
    }

}