<?php

function call($controller, $action){
    require_once("./controllers/BaseController.php");
    require_once("./models/BaseModel.php");

    require_once("./controllers/$controller" . ".php");


    switch($controller){
        case "AdminController":
            $controller = new AdminController();
        break;
    }


    $controller->{$action}();

}


$routes = [
    "AdminController" => ["getDashBoard", "getParkingSlots", "getPayments", "getUsers"],
];
