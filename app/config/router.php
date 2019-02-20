<?php

use core\router\Route;

return [
    'routes' => [
        new Route("", [
            "controller" => "main",
            "action" => "index"
        ]),
        new Route("todo/{x}",[
            "controller"=>"api",
            "action"=>"todo"
        ]),
        new Route("{controller}/{action}")
    ]
];