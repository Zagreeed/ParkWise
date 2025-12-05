<?php


class HomeController extends BaseController{

    public function homePage(){
        $this->renderView("home", "gatewayPage");
    }

}