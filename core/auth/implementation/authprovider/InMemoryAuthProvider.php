<?php
/**
 * Created by PhpStorm.
 * User: mamedov
 * Date: 20.02.2019
 * Time: 19:11
 */

namespace core\auth\implementation\authprovider;


use core\auth\contracts\AuthProvider;
use core\auth\Credential;

class InMemoryAuthProvider implements AuthProvider
{

    private $credentials=[];

    /**
     * InMemoryAuthProvider constructor.
     * @param $credentials
     */
    public function __construct(array $credentials)
    {
        $this->credentials = $credentials;
    }


    function getCredentials(string $login): ?Credential
    {
        foreach ($this->credentials as $credential){
            if($credential->getLogin()){
                return $credential;
            }
        }
        return null;
    }
}