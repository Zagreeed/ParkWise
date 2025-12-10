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

       

        if(!isset($_SESSION["userId"])){
            $this->showLoginPage();
            exit();
        }

        $userId = $_SESSION["userId"];



        $userData = $this->userModel->find($userId);

  
        $totalSpent = $this->paymentModel->getTotalSpentForAMonth($userId);
        
        $totalBookings = $this->bookingModel->getAllUserBookings($userId);
       
        $totalHourseSpent = $this->bookingModel->getUserTotalBookingTime($userId);
       
        $availableParkingSlot = $this->parkingSlotModel->getAvailableSlotDetail();
       
        $activityHistory = $this->bookingModel->getAllUserBookingHistory($userId);

        
        $datas = [
            "userData" => $userData,
            "totalSpent" => $totalSpent,
            "totalBookings" => $totalBookings,
            "totalHourseSpent" => $totalHourseSpent,
            "availableParkingSlot" => $availableParkingSlot,
            "activityHistory" => $activityHistory,
        ];

      

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
        
        
       
        $_SESSION["userId"] = $userId;

      


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

        $this->showMyVehiclePage();
        exit();

    }


    
    public function showEditVehiclePage(){
        if(!isset($_SESSION["userId"])){
            $this->showLoginPage();
            exit();
        }

        if(!isset($_GET['vehicle_id'])){
            $this->showMyVehiclePage();
            exit();
        }

        $vehicleId = htmlspecialchars(strip_tags(trim($_GET['vehicle_id'])), ENT_QUOTES, 'UTF-8');
        
        $vehicleData = $this->vehicleModel->find($vehicleId);
        
        if(!$vehicleData || $vehicleData['user_id'] != $_SESSION["userId"]){
            $_SESSION["errors"] = "Vehicle not found or you don't have permission to edit it";
            $this->showMyVehiclePage();
            exit();
        }

        $this->renderView("user", "editVehiclePage", $vehicleData, "editVehiclePage");
    }

    public function updateVehicle(){
        if($_SERVER["REQUEST_METHOD"] != "POST"){
            $this->renderView("error", "errorPage");
            exit();    
        }

        $datas = [
            "vehicle_id" => htmlspecialchars(strip_tags(trim($_POST['vehicle_id'] ?? '')), ENT_QUOTES, 'UTF-8'),
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
            header("Location: ?controller=UserController&action=showEditVehiclePage&vehicle_id=" . $datas['vehicle_id']);
            exit();
        }

        $vehicleId = $datas['vehicle_id'];
        unset($datas['vehicle_id']);

        $data = $this->vehicleModel->update($vehicleId, $datas);

        if(!$data){
            $_SESSION["errors"] = "Something went wrong while updating the vehicle!";
            header("Location: ?controller=UserController&action=showEditVehiclePage&vehicle_id=" . $vehicleId);
            exit();    
        }

        $_SESSION["success"] = "Vehicle updated successfully!";
        $this->showMyVehiclePage();
        exit();
    }

   

    public function deleteVehicle(){
        if($_SERVER["REQUEST_METHOD"] != "POST"){
            $this->renderView("error", "errorPage");
            exit();    
        }

        $id = htmlspecialchars(strip_tags(trim($_POST['vehicle_id'] ?? '')), ENT_QUOTES, 'UTF-8');

        if(empty($id)){
            $_SESSION["errors"] = "Vehicle ID is required";
            $this->showMyVehiclePage();
            exit();
        }

    
        $vehicle = $this->vehicleModel->find($id);
        
        if(!$vehicle){
            $_SESSION["errors"] = "Vehicle not found";
            $this->showMyVehiclePage();
            exit();
        }

        if($vehicle['user_id'] != $_SESSION["userId"]){
            $_SESSION["errors"] = "You don't have permission to delete this vehicle";
            $this->showMyVehiclePage();
            exit();
        }

        $request = $this->vehicleModel->delete($id);

        if(!$request){
            $_SESSION["errors"] = "Failed to delete vehicle. Please try again.";
            $this->showMyVehiclePage();
            exit();    
        }

        $_SESSION["success"] = "Vehicle deleted successfully!";
        $this->showMyVehiclePage();
        exit();
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

    public function showBookingDetailsPage(){
        if(!isset($_SESSION["userId"])){
            $this->showLoginPage();
            exit();
        }

        if(!isset($_POST['slot_id'])){
            $this->showBookingsPage();
            exit();
        }

        $slotId = htmlspecialchars(strip_tags(trim($_POST['slot_id'])), ENT_QUOTES, 'UTF-8');
        
        // Fetch slot details
        $slotDetails = $this->parkingSlotModel->find($slotId);
        
        if(!$slotDetails || $slotDetails['status'] != 'available'){
            $_SESSION["errors"] = "Selected parking slot is not available";
            $this->showBookingsPage();
            exit();
        }

        // Fetch user details
        $userData = $this->userModel->find($_SESSION["userId"]);

        // Fetch user vehicles
        $userVehicles = $this->vehicleModel->getUserVehicles($_SESSION["userId"]);

        if(empty($userVehicles)){
            $_SESSION["errors"] = "Please add a vehicle first before booking";
            $this->showMyVehiclePage();
            exit();
        }

        $datas = [
            "slotDetails" => $slotDetails,
            "userData" => $userData,
            "userVehicles" => $userVehicles,
            "hourlyRate" => 50 // ₱50 per hour
        ];

        $this->renderView("user", "bookingDetailsPage", $datas, "bookingDetailsPage");
    }


    public function showPaymentPage(){
        if(!isset($_SESSION["userId"])){
            $this->showLoginPage();
            exit();
        }

        if($_SERVER["REQUEST_METHOD"] != "POST"){
            $this->showBookingsPage();
            exit();
        }

        // Get form data
        $slotId = htmlspecialchars(strip_tags(trim($_POST['slot_id'] ?? '')), ENT_QUOTES, 'UTF-8');
        $vehicleId = htmlspecialchars(strip_tags(trim($_POST['vehicle_id'] ?? '')), ENT_QUOTES, 'UTF-8');
        $startTime = htmlspecialchars(strip_tags(trim($_POST['start_time'] ?? '')), ENT_QUOTES, 'UTF-8');
        $endTime = htmlspecialchars(strip_tags(trim($_POST['end_time'] ?? '')), ENT_QUOTES, 'UTF-8');
        $isOpenTime = isset($_POST['open_time']) && $_POST['open_time'] == '1';

        // Validate inputs
        if(empty($slotId) || empty($vehicleId) || empty($startTime)){
            $_SESSION["errors"] = "Required fields are missing";
            header("Location: ?controller=UserController&action=showBookingDetailsPage&slot_id=" . $slotId);
            exit();
        }

        // If not open time, validate end time
        if(!$isOpenTime && empty($endTime)){
            $_SESSION["errors"] = "End time is required if not using Open Time";
            header("Location: ?controller=UserController&action=showBookingDetailsPage&slot_id=" . $slotId);
            exit();
        }

        // For open time bookings, set end_time to Dec 31 of current year
        if($isOpenTime){
            $currentYear = date('Y');
            $endTime = $currentYear . '-12-31 23:59:59';
            $amount = 50; // Placeholder amount (minimum value to satisfy DB constraint)
            $hours = 0;
        } else {
            // Calculate duration and amount for normal bookings
            $start = new DateTime($startTime);
            $end = new DateTime($endTime);
            $interval = $start->diff($end);
            $hours = $interval->h + ($interval->days * 24);
            $amount = $hours * 50; // ₱50 per hour
        }

        // Fetch details for display
        $slotDetails = $this->parkingSlotModel->find($slotId);
        $vehicleDetails = $this->vehicleModel->find($vehicleId);
        $userData = $this->userModel->find($_SESSION["userId"]);

        // Store booking data in session for payment processing
        $_SESSION["pending_booking"] = [
            "user_id" => $_SESSION["userId"],
            "vehicle_id" => $vehicleId,
            "slot_id" => $slotId,
            "start_time" => $startTime,
            "end_time" => $endTime,
            "booking_time" => date('Y-m-d H:i:s'),
            "amount" => $amount,
            "is_open_time" => $isOpenTime
        ];

        $datas = [
            "bookingData" => $_SESSION["pending_booking"],
            "slotDetails" => $slotDetails,
            "vehicleDetails" => $vehicleDetails,
            "userData" => $userData,
            "amount" => $amount,
            "hours" => $hours,
            "is_open_time" => $isOpenTime
        ];

        $this->renderView("user", "paymentPage", $datas, "paymentPage");
    }
   
    public function processPayment(){
        if(!isset($_SESSION["userId"]) || !isset($_SESSION["pending_booking"])){
            $this->showLoginPage();
            exit();
        }

        if($_SERVER["REQUEST_METHOD"] != "POST"){
            $this->showBookingsPage();
            exit();
        }

        $paymentMethod = htmlspecialchars(strip_tags(trim($_POST['payment_method'] ?? '')), ENT_QUOTES, 'UTF-8');

        if(empty($paymentMethod)){
            $_SESSION["errors"] = "Please select a payment method";
            $this->showPaymentPage();
            exit();
        }

        $bookingData = $_SESSION["pending_booking"];
        $isOpenTime = isset($bookingData['is_open_time']) && $bookingData['is_open_time'];

        // Create booking with status 'pending'
        $bookingData['status'] = 'pending';
        
        // Remove is_open_time flag before inserting into database
        unset($bookingData['is_open_time']);
        
        $bookingId = $this->bookingModel->create($bookingData);

        if(!$bookingId){
            $_SESSION["errors"] = "Failed to create booking";
            $this->showPaymentPage();
            exit();
        }

        // Update slot status to 'reserved'
        $this->parkingSlotModel->update($bookingData['slot_id'], ["status" => "reserved"]);

        // Create payment record
        // For open time bookings, payment status is ALWAYS 'pending' regardless of payment method
        // For normal bookings, cash = 'pending', others = 'paid'
        $paymentStatus = 'pending';
        if(!$isOpenTime && $paymentMethod !== "cash"){
            $paymentStatus = 'paid';
        }

        $paymentData = [
            "booking_id" => $bookingId,
            "amount" => $bookingData['amount'],
            "payment_method" => $paymentMethod,
            "payment_status" => $paymentStatus
        ];

        $paymentId = $this->paymentModel->create($paymentData);

        if(!$paymentId){
            $_SESSION["errors"] = "Payment processing failed";
            $this->showPaymentPage();
            exit();
        }

        // Clear pending booking from session
        unset($_SESSION["pending_booking"]);

        // Set success message
        if($isOpenTime){
            $_SESSION["success"] = "Open Time booking created successfully! Payment will be processed when you check out.";
        } else {
            $_SESSION["success"] = "Booking created successfully!";
        }

        // Redirect to activity history
        $this->showActivityHistoryPage();
    }



}