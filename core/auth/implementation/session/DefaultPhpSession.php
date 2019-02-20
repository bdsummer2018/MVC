<?php

namespace core\auth\implementation\session;

use core\auth\contracts\Session;

class DefaultPhpSession implements Session
{
    private static $ins=null;
    public static function instance(){
        return self::$ins===null?self::$ins=new self():self::$ins;
    }
    private function __construct()
    {
        session_start();
    }

    function set(string $key, string $value): void
    {
        $_SESSION[$key]=$value;
    }

    function get(string $key): ?string
    {
        return empty($_SESSION[$key])?null:$_SESSION[$key];
    }

    function delete(string $key): void
    {
        unset($_SESSION[$key]);
    }

    function destroy(): void
    {
        session_destroy();
    }
}