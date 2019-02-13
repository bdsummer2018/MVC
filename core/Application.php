<?php
/**
 * Created by PhpStorm.
 * User: mamedov
 * Date: 11.02.2019
 * Time: 19:00
 */

namespace core;


use core\router\Router;
use core\router\RouterException;

class Application
{
    public static function run(){

        $router_config = new Configurator("router");
        $routes = $router_config->routes;

        $router = new Router($routes);
        try{
            $router->route();
        }catch (RouterException $e){
            echo "404!";
        }

    }
}