<?php
/**
 * Created by PhpStorm.
 * User: mamedov
 * Date: 20.02.2019
 * Time: 19:02
 */

namespace core\auth\contracts;


interface Session
{
    function set(string $key,string $value):void ;
    function get(string $key):?string;
    function delete(string $key):void;
    function destroy():void;
}