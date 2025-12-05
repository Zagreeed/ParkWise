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


    public function showLoginPage(){

        if(isset($_SESSION["userId"])){
            $this->showDashBoard();
            exit();
        }

        $this->renderView("login", "loginPage");
    }


    public function login(){
        if($_SERVER["REQUEST_METHOD"] != "POST"){
            $this->renderView("error", "errorPage");
            exit();
        }

        $datas = [
            "email" => htmlspecialchars(strip_tags(trim($_POST['email'] ?? '')), ENT_QUOTES, 'UTF-8'),
            "password" => htmlspecialchars(strip_tags(trim($_POST['password'] ?? '')), ENT_QUOTES, 'UTF-8'),
        ];

        if(empty($datas["email"])){
            $_SESSION["errors"] = "Email is required";
            $this->showLoginPage();
            exit();
        }

        if(empty($datas["password"])){
            $_SESSION["errors"] = "Password is required";
            $this->showLoginPage();
            exit();
        }


        $user = $this->userModel->findUserByEmail($datas["email"]);

        if(!$user){
            $_SESSION["errors"] = "User is not Found";
            $this->showLoginPage();
            exit();
        }


        if($user["password"] != $datas["password"]){
            $_SESSION["errors"] = "Password is incorrect";
            $this->showLoginPage();
            exit();
        }


        /// REDIRECT USER TO THE USE DASHBOARD WITH ITS DASHBOARD DATA
        $_SESSION["userId"] = $user["user_id"];
        $this->showDashBoard();


    }

    public function logout(){

        if($_SERVER["REQUEST_METHOD"] != "POST"){
            $this->renderView("error", "errorPage");
            exit();
        }

        $_SESSION = [];
        session_destroy();

        $this->showLoginPage();
        
    }

    public function showDashBoard(){

        ///NEED THE USERID

        if(!isset($_SESSION["userId"])){
            $this->showLoginPage();
            exit();
        }

        $userId = $_SESSION["userId"];


        /// FETCH THE USER INFOS
        $userData = $this->userModel->find($userId);

        /// FETCH THE TOTAL SPENT(MONEY) ON BOOKINGS
        $totalSpent = $this->paymentModel->getTotalSpentForAMonth($userId);
        /// FETCH THE USER TOTAL BOOKINGS
        $totalBookings = $this->bookingModel->getAllUserBookings($userId);
        /// FETCH HOURSE PARKED FOR THIS MONTH
        $totalHourseSpent = $this->bookingModel->getUserTotalBookingTime($userId);
        /// FETCH ALL "AVAILABLE" PARKING SLOTS
        $availableParkingSlot = $this->parkingSlotModel->getAvailableSlotDetail();
        /// FETCH ALL BOOKINGS THE USER MAKE FOR THE ACTIVITY SECTION
        $activityHistory = $this->bookingModel->getAllUserBookingHistory($userId);

        
        $datas = [
            "userData" => $userData,
            "totalSpent" => $totalSpent,
            "totalBookings" => $totalBookings,
            "totalHourseSpent" => $totalHourseSpent,
            "availableParkingSlot" => $availableParkingSlot,
            "activityHistory" => $activityHistory,
        ];

        /// QUERY ALL THE DATA NEEDED FOR THE DASH-BOARD

        $this->renderView("user", "dashBoard", $datas, "dashBoard");

    }

    public function showMyVehiclePage(){

        
        if(!isset($_SESSION["userId"])){
            $this->showLoginPage();
            exit();
        }

        $datas = $this->vehicleModel->getUserVehicles($_SESSION["userId"]);

        $this->renderView("user", "myVehiclePage" , $datas, "myVehiclePage");

    }

    public function showBookingsPage(){

        
        if(!isset($_SESSION["userId"])){
            $this->showLoginPage();
            exit();
        }


        $datas = $this->parkingSlotModel->getAll();

        $this->renderView("user", "bookParkingPage", $datas, "bookParkingPage");

    }

    public function showActivityHistoryPage(){{

        
        if(!isset($_SESSION["userId"])){
            $this->showLoginPage();
            exit();
        }
        
        $datas = $this->userModel->getUserAllActivity($_SESSION["userId"], 20);

        $this->renderView("user", "activityHistoryPage", $datas, "activityHistoryPage");

    }}

    public function showProfilePage(){

        
        if(!isset($_SESSION["userId"])){
            $this->showLoginPage();
            exit();
        }

        
        $data = $this->userModel->find($_SESSION["userId"]);

        $this->renderView("user", "profilePage", $data , "profilePage");

    }

    public function showSignUpPage(){
        
        if(isset($_SESSION["userId"])){
            $this->showDashBoard();
            exit();
        }

        $this->renderView("login", "signUpPage");
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
            "password" => htmlspecialchars(strip_tags(trim($_POST['password'] ?? '')), ENT_QUOTES, 'UTF-8'),
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
            $_SESSION["errors"] = "Something went wrong while creating the user please check the 'signUp' controller -ps dev GALAN :>";
            $this->showSignUpPage();
            exit();
        }
        
        
        /// REDIRRECT TO SHOW THE ADD/CREATE VEHICHLE PAGE
        $_SESSION["userId"] = $userId;

        /// LETS DO THIS WHEN THERES A UI FOR THIS TEMPORARY LETS REDIRECT THE USER TO THE DASHBOARD
        // $this->showAddVehichelPage();


        $this->showDashBoard();


        exit();

        }


    public function showAddVehichelPage(){
        if(!isset($_SESSION["userId"])){
            $_SESSION["errors"] = "Something went wrong while redirecting to addVechilePage check 'showAddVehichelPage' -ps dev GALAN";
            $this->showLoginPage();
            exit();
        }
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


        $errors = [];

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
            $_SESSION["errors"] = "Something very bad haappen while adding a vehicle! check the 'addVehicle' controller -ps dev GALAN";
            $this->showAddVehichelPage();
            exit();    
        };

        $this->showDashBoard();
        exit();

    }


    /// NOT DONE!!!
    public function createBooking(){

         if(!isset($_SESSION["userId"])){
            $this->showLoginPage();
            exit();
        }


         if($_SERVER["REQUEST_METHOD"] != "POST"){
            $this->renderView("error", "errorPage");
            exit();
        }


        $datas = [
            "user_id" => htmlspecialchars(strip_tags(trim($_POST['user_id'] ?? '')), ENT_QUOTES, 'UTF-8'),
            "vehicle_id" => htmlspecialchars(strip_tags(trim($_POST['vehicle_id'] ?? '')), ENT_QUOTES, 'UTF-8'),
            "slot_id" => htmlspecialchars(strip_tags(trim($_POST['slot_id'] ?? '')), ENT_QUOTES, 'UTF-8'),
            "booking_time" => htmlspecialchars(strip_tags(trim($_POST['booking_time'] ?? '')), ENT_QUOTES, 'UTF-8'),
            "start_time" => htmlspecialchars(strip_tags(trim($_POST['start_time'] ?? '')), ENT_QUOTES, 'UTF-8'),
            "end_time" => htmlspecialchars(strip_tags(trim($_POST['end_time'] ?? '')), ENT_QUOTES, 'UTF-8'),
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


    }


    public function updateProfile(){
         if($_SERVER["REQUEST_METHOD"] != "POST"){
            $this->renderView("error", "errorPage");
            exit();
        }

         $datas = [
            "username" => htmlspecialchars(strip_tags(trim($_POST['username'] ?? '')), ENT_QUOTES, 'UTF-8'),
            "phonenumber" => htmlspecialchars(strip_tags(trim($_POST['phonenumber'] ?? '')), ENT_QUOTES, 'UTF-8'),
            "email" => htmlspecialchars(strip_tags(trim($_POST['email'] ?? '')), ENT_QUOTES, 'UTF-8')
        ];

        $id = htmlspecialchars(strip_tags(trim($_POST['id'] ?? '')), ENT_QUOTES, 'UTF-8');

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

        $userId = $this->userModel->update($id, $datas);
        
        if(!$userId){
            $_SESSION["errors"] = "Something went wrong while creating the user please check the 'signUp' controller -ps dev GALAN :>";
            $this->showSignUpPage();
            exit();
        }


        $this->showProfilePage();




    }



}