<?php
/**
 * Created by PhpStorm.
 * User: mamedov
 * Date: 20.02.2019
 * Time: 19:14
 */

namespace core\auth\implementation\encoders;


use core\auth\contracts\PasswordEncoder;

class Md5PasswordEncoder implements PasswordEncoder
{

    function encode(string $password): string
    {
        return md5($password);
    }

    function validate(string $password, string $hash): bool
    {
        return md5($password)===$hash;
    }
}