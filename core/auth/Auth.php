<?php
/**
 * Created by PhpStorm.
 * User: mamedov
 * Date: 20.02.2019
 * Time: 19:05
 */

namespace core\auth;


use core\Configurator;

class Auth
{
    const LOGIN_SESSION_KEY = "__login__";
    /***
     * @var \core\auth\contracts\AuthProvider
     */
    private $authProvider;
    /***
     * @var \core\auth\contracts\Session
     */
    private $session;
    /***
     * @var \core\auth\contracts\PasswordEncoder
     */

    private $passwordEncoder;
    private static $ins = null;

    public static function instance()
    {
        return self::$ins === null ? self::$ins = new self() : self::$ins;
    }

    /**
     * Auth constructor.
     */
    private function __construct()
    {
        $config = new Configurator("auth");
        $this->authProvider = $config->authProvider;
        $this->session = $config->session;
        $this->passwordEncoder = $config->passwordEncoder;
    }


    /**
     * @return contracts\PasswordEncoder
     */
    public function getPasswordEncoder(): contracts\PasswordEncoder
    {
        return $this->passwordEncoder;
    }

    public function login(Credential $credential): bool
    {
        $realCredential = $this->authProvider->getCredentials($credential->getLogin());
        if ($realCredential === null) return false;
        if (!$this->passwordEncoder->validate(
            $credential->getPassword(),
            $realCredential->getPassword()
        )) return false;
        $this->createSession($credential);
        return true;
    }

    private function createSession(Credential $credential){
        $this->session->set(self::LOGIN_SESSION_KEY,$credential->getLogin());
    }

    public function isAuth():bool{
        $login = $this->session->get(self::LOGIN_SESSION_KEY);
        return $login!=null;
    }

    public function getCredentials():?Credential{
        $login = $this->session->get(self::LOGIN_SESSION_KEY);
        if($login === null) return null;
        $credentials = $this->authProvider->getCredentials($login);
        return $credentials;
    }

    public function hasRole(string $role):bool{
        $cred = $this->getCredentials();
        if($cred === null) return false;
        return in_array($role,$cred->getRoles());
    }

    public function logout(){
        $this->session->delete(self::LOGIN_SESSION_KEY);
    }

}