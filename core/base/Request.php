<?php
/**
 * Created by PhpStorm.
 * User: mamedov
 * Date: 13.03.2019
 * Time: 20:06
 */

namespace core\base;


class Request
{
    public function getQueryParam(string $name,$default = null){
        return isset($_GET[$name])?$_GET[$name]:$default;
    }

    public function getBodyParam(string $name,$default = null){
        return isset($_POST[$name])?$_POST[$name]:$default;
    }
}