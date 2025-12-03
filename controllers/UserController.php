<?php

class UserController extends BaseController{
    protected $bookingModel;
    protected $parkingSlotModel;
    protected $paymentModel;
    protected $userModel; 
    protected $vehicleModel; 


    public function __construct(){
        $this->bookingModel = $this->loadModel("Bookings");
        $this->parkingSlotModel = $this->loadModel("ParkingSlot");
        $this->paymentModel = $this->loadModel("Payments");
        $this->userModel = $this->loadModel("User");
        $this->vehicleModel = $this->loadModel("Vehicle");
    }


    public function getLoginPage(){
        $this->renderView("user", "userDashBoard");
    }


    public function login(){
        if($_SERVER["REQUEST_METHOD"] != "POST"){
            $this->renderView("error", "errorPage");
            exit();
        }

        $datas = [
            "email" => htmlspecialchars(strip_tags(trim($_POST['email'] ?? '')), ENT_QUOTES, 'UTF-8'),
            "password" => htmlspecialchars(strip_tags(trim($_POST['passsword'] ?? '')), ENT_QUOTES, 'UTF-8'),
        ];

        if(empty($datas["email"])){
            $_SESSION["errors"] = "Email is required";
            $this->getLoginPage();
            exit();
        }

        if(empty($datas["password"])){
            $_SESSION["errors"] = "Password is required";
            $this->getLoginPage();
            exit();
        }


        $user = $this->userModel->find($datas["email"]);

        if(!$user){
            $_SESSION["errors"] = "User is not Found";
            $this->getLoginPage();
            exit();
        }


        if($user["passsword"] != $datas["password"]){
             $_SESSION["errors"] = "Password is incorrect";
            $this->getLoginPage();
            exit();
        }


        /// REDIRECT USER TO THE USE DASHBOARD WITH ITS DASHBOARD DATA
        $this->showDashBoard($user["id"]);




    }


    public function showDashBoard($userId){

    }

    public function showSignUpPage(){
        $this->renderView("user", "signUpPage");
    }


    public function signUp(){
        if($_SERVER["REQUEST_METHOD"] != "POST"){
            $this->renderView("error", "errorPage");
            exit();
        }

        $datas = [
            "username" => htmlspecialchars(strip_tags(trim($_POST['username'] ?? '')), ENT_QUOTES, 'UTF-8'),
            "address" => htmlspecialchars(strip_tags(trim($_POST['address'] ?? '')), ENT_QUOTES, 'UTF-8'),
            "phonenumber" => htmlspecialchars(strip_tags(trim($_POST['phonenumber'] ?? '')), ENT_QUOTES, 'UTF-8'),
            "role" => htmlspecialchars(strip_tags(trim($_POST['role'] ?? '')), ENT_QUOTES, 'UTF-8'),
            "email" => htmlspecialchars(strip_tags(trim($_POST['email'] ?? '')), ENT_QUOTES, 'UTF-8'),
            "password" => htmlspecialchars(strip_tags(trim($_POST['passsword'] ?? '')), ENT_QUOTES, 'UTF-8'),
        ];

        $errors = [];

        foreach($datas as $key => $value){
            if(empty($value)){
                $errors[] = "$key" . " is required";
            }
        }

        if(!empty($errors)){
            $_SESSION["errors"] = $errors;
            $this->showSignUpPage();
            exit();
        }

        $userId = $this->userModel->create($datas);
        
        if(!$userId){
            $_SESSION["errors"] = "Something went wrong while creating the user please check signUp controller -ps dev :>";
            $this->showSignUpPage();
            exit();
        }
        
        
        $_SESSION["userId"] = $userId;
        /// REDIRRECT TO SHOW THE ADD/CREATE VEHICHLE PAGE
        $this->showAddVehichelPage();
    }


    public function showAddVehichelPage(){
        $this->renderView("user", "addVechilePage");
    }


    public function addVehicle(){
        if($_SERVER["REQUEST_METHOD"] != "POST"){
            $this->renderView("error", "errorPage");
            exit();    
        }


        
        $datas = [
            "user_id" => htmlspecialchars(strip_tags(trim($_POST['user_id'] ?? '')), ENT_QUOTES, 'UTF-8'),
            "plate_number" => htmlspecialchars(strip_tags(trim($_POST['plate_number'] ?? '')), ENT_QUOTES, 'UTF-8'),
            "vehicle_type" => htmlspecialchars(strip_tags(trim($_POST['vehicle_type'] ?? '')), ENT_QUOTES, 'UTF-8'),
            "brand" => htmlspecialchars(strip_tags(trim($_POST['brand'] ?? '')), ENT_QUOTES, 'UTF-8'),
        ];


        foreach($datas as $key => $value){
            if(empty($value)){
                $errors[] = "$key" . " is required";
            }
        }

        if(!empty($errors)){
            $_SESSION["errors"] = $errors;
            $this->showAddVehichelPage();
            exit();
        }

        $data = $this->vehicleModel->create($datas);

        if(!$data){
            $_SESSION["errors"] = "Something very bad haappen while adding a vehicle!";
            $this->showAddVehichelPage();
            exit();    
        };

        $this->showDashBoard($_SESSION["userId"]);
        exit();

    }



}