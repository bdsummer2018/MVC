<?php
/**
 * Created by PhpStorm.
 * User: mamedov
 * Date: 20.02.2019
 * Time: 18:57
 */

namespace core\auth;
class Credential
{
    private $login;
    private $password;
    private $roles = [];

    /**
     * Credential constructor.
     * @param string $login
     * @param string $password
     * @param array $roles
     */
    public function __construct(string $login,string $password,?array $roles = [])
    {
        $this->login = $login;
        $this->password = $password;
        $this->roles=$roles;
    }

    /**
     * @return array|null
     */
    public function getRoles(): ?array
    {
        return $this->roles;
    }

    /**
     * @param array|null $roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     */
    public function setLogin(string $login)
    {
        $this->login = $login;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }




}