<?php
/**
 * Created by PhpStorm.
 * User: mamedov
 * Date: 11.02.2019
 * Time: 19:05
 */

namespace core;


class Configurator
{
    private $data = null;
    const CONFIG_CORE_PATH = CORE_DIR."config/";
    const CONFIG_APP_PATH = APP_DIR."config/";

    /**
     * Configurator constructor.
     */
    public function __construct(string $configName){
        if(file_exists(self::CONFIG_APP_PATH.$configName.EXT)){
            $this->data = include self::CONFIG_APP_PATH.$configName.EXT;
        }elseif (file_exists(self::CONFIG_CORE_PATH.$configName.EXT)){
            $this->data = include self::CONFIG_CORE_PATH.$configName.EXT;
        }
    }

    public function __get($name)
    {
        return $this->data[$name];
    }


}