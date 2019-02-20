<?php
/**
 * Created by PhpStorm.
 * User: mamedov
 * Date: 20.02.2019
 * Time: 19:08
 */

use core\auth\implementation\authprovider\InMemoryAuthProvider;
use core\auth\implementation\encoders\Md5PasswordEncoder;
use core\auth\implementation\session\DefaultPhpSession;

return [
    "passwordEncoder"=>new Md5PasswordEncoder(),
    "session"=>DefaultPhpSession::instance(),
    "authProvider"=>new InMemoryAuthProvider([
        new \core\auth\Credential("admin",(new Md5PasswordEncoder())->encode("admin"),["ADMIN"])
    ]),
];