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
            "controller" => "departsapi",
            "action" => "getRootDeparts"
        ]),
        new Route("api/departs/add", [
            "controller" => "departsapi",
            "action" => "addDeparts"
        ]),
        new Route("api/departs/{id}", [
            "controller" => "departsapi",
            "action" => "getChildDeparts"
        ]),
        //Rooms
        new Route("api/rooms", [
            "controller" => "roomsapi",
            "action" => "getRootRooms"
        ]),
        new Route("api/rooms/add", [
            "controller" => "roomsapi",
            "action" => "addRooms"
        ]),
        new Route("api/rooms/{id}", [
            "controller" => "roomsapi",
            "action" => "getChildRooms"
        ]),
    ]
];