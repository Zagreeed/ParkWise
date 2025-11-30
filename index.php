
<?php


require_once("./dbConnection.php");

$controller = NULL;
$action = NULL;


if(isset($_GET["controller"]) && isset($_GET["action"])){
    $controller = $_GET["controller"];
    $action = $_GET["action"];
}else{
    $controller = "home";
    $action = "index";
}

require_once("./router.php");