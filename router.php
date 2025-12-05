<?php

function call($controller, $action){
    require_once("./controllers/BaseController.php");
    require_once("./models/BaseModel.php");

    require_once("./controllers/$controller" . ".php");


    switch($controller){
        case "AdminController":
            $controllerInstance = new AdminController();
            break;
        case "UserController":
             $controllerInstance = new UserController();
             break;
        case "Home":
            $controllerInstance = new HomeController();
            break;
        
    }


    $controllerInstance->{$action}();

}


$routes = [
    "Home" => ["index"],
    "UserController" => ["showLoginPage", "login", "logout", "showDashBoard", "showSignUpPage", "signUp", "showAddVehichelPage", "addVehicle", "showMyVehiclePage", "showBookingsPage", "showActivityHistoryPage", "showProfilePage", "updateProfile"],
    "AdminController" => ["getDashBoardData", "getParkingSlotsPage", "getBookingsPage", "getPaymentsPage",  "getUserContactPage"],
];



if(array_key_exists($controller, $routes)){
    if(in_array($action, $routes[$controller])){
        call($controller, $action);
    }
}else{
    call("UserController", "showLoginPage");
}
