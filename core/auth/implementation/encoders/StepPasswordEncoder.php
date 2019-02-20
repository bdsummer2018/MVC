<?php
/**
 * Created by PhpStorm.
 * User: mamedov
 * Date: 20.02.2019
 * Time: 20:14
 */

namespace core\auth\implementation\encoders;


use core\auth\contracts\PasswordEncoder;

class StepPasswordEncoder implements PasswordEncoder
{
    private function _encode($salt,$pass){
        $salt = substr($salt,0,5);
        $hash = hash("sha256",$salt.$pass.$salt.$pass);
        return substr_replace($hash,$salt,4,5);
    }


    function encode(string $password): string
    {
        $salt = md5(md5(time()).sha1(time()));
        return $this->_encode($salt,$password);
    }

    function validate(string $password, string $hash): bool
    {
        $salt = substr($hash,4,5);
        return $this->_encode($salt,$password)===$hash;
    }
}