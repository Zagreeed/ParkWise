<?php

class BaseController{


    public function loadModel($filePath){
        require_once("./models/" . $filePath . ".php");

        $model = ucfirst($filePath);
        return new $model;
    }


    public function  renderView($folderPath, $fileName, $datas = NULL, $location = NULL){

        $content = $datas;


        require_once("./views/uniLayout.php");

    }
}