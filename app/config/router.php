<?php

use core\router\Route;

return [
    'routes' => [
        new Route("", [
            "controller" => "main",
            "action" => "index"
        ]),
        new Route("departs", [
            "controller" => "main",
            "action" => "departs"
        ]),


        new Route("api/departs", [
            "controller" => "api",
            "action" => "getRootDeparts"
        ]),

        new Route("api/departs/add", [
            "controller" => "api",
            "action" => "addDeparts"
        ]),

        new Route("api/departs/{id}", [
            "controller" => "api",
            "action" => "getChildDeparts"
        ]),





    ]
];