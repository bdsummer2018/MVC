<?php
/**
 * Created by PhpStorm.
 * User: mamedov
 * Date: 20.02.2019
 * Time: 18:56
 */
namespace core\auth\contracts;
use core\auth\Credential;

interface AuthProvider
{
    function getCredentials(string $login):?Credential;
}