<?php
/**
 * Created by PhpStorm.
 * User: mamedov
 * Date: 20.02.2019
 * Time: 19:01
 */

namespace core\auth\contracts;


interface PasswordEncoder
{
    function encode(string $password):string ;
    function validate(string $password,string $hash):bool ;
}