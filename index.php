
<?php

session_start();


$_SESSION["userId"] = 7;

define('BASE_URL', "/ParkWise/");

require_once("./dbConnection.php");

$controller = NULL;
$action = NULL;


if(isset($_GET["controller"]) && isset($_GET["action"])){
    $controller = $_GET["controller"];
    $action = $_GET["action"];
}else{
    $controller = "UserController";
    $action = "showDashBoard";
}

require_once("./router.php");