<?php

class AdminController extends BaseController{
    
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

    
    public function showAdminLoginPage(){


        $this->renderView("login", "adminLogin");
    }


    

    public function Adminlogin(){
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
            $this->showAdminLoginPage();
            exit();
        }

        if(empty($datas["password"])){
            $_SESSION["errors"] = "Password is required";
            $this->showAdminLoginPage();
            exit();
        }


        $user = $this->userModel->findUserByEmail($datas["email"]);

        if($user["role"] != "admin"){
            $_SESSION["errors"] = "Invalid Authorization";
          
            $this->showAdminLoginPage();
            exit();
        }

        if(!$user){
            $_SESSION["errors"] = "User is not Found";
            $this->showAdminLoginPage();
            exit();
        }




        if($user["password"] != $datas["password"]){
            $_SESSION["errors"] = "Password is incorrect";
            $this->showAdminLoginPage();
            exit();
        }


        /// REDIRECT USER TO THE USE DASHBOARD WITH ITS DASHBOARD DATA
        $_SESSION["adminId"] = $user["user_id"];
        $this->getDashBoardData();

    }


       public function Adminlogout(){

        if($_SERVER["REQUEST_METHOD"] != "POST"){
            $this->renderView("error", "errorPage");
            exit();
        }

        $_SESSION = [];
        session_destroy();

        $this->showAdminLoginPage();
        
    }



    public function getDashBoardData(){

           if(!isset($_SESSION["adminId"])){
            $this->showAdminLoginPage();
            exit();
        }

        $totalBookings = $this->bookingModel->getTotalBookings();
        $availableSlot = $this->parkingSlotModel->getAvailableSlot();
        $totalRevenue = $this->paymentModel->getRevenue();
        $totalUser = $this->userModel->getTotalUser();
        $slotAvailability = $this->parkingSlotModel->getSlotsAvailability();
        $allVehiclesTypesCount = $this->vehicleModel->getVehicleCountType();

        $datas = [
            "totalBookings" => $totalBookings,
            "availableSlot" => $availableSlot,
            "totalRevenue" => $totalRevenue,
            "totalUser" => $totalUser,
            "slotAvailability" => $slotAvailability,
            "vehicleCount" => $allVehiclesTypesCount,
        ];


        $this->renderView("admin", "dashBoard", $datas, "dashBoard");


        
    }


    public function getParkingSlotsPage(){
        $datas = $this->parkingSlotModel->getAll();

        $this->renderView("admin", "parkingSlotPage", $datas, "slotPage");
    }

    public function getBookingsPage(){
       $datas = $this->bookingModel->getBookingsDetail();

       $this->renderView("admin", "BookingsPage", $datas, "bookingsPages");
    }

    public function getPaymentsPage(){
        $datas = $this->paymentModel->getAll();

        $this->renderView("admin","PaymentsPage", $datas, "paymentsPage");
    }

    public function getUserContactPage(){
        $datas = $this->userModel->getAllUser();

        $this->renderView("admin", "UserDetailsPage", $datas, "userPages");
    }

   public function updateBookingStatus(){

        if($_SERVER["REQUEST_METHOD"] != "POST"){
            $this->renderView("error", "errorPage");
            exit();    
        }

        $id = htmlspecialchars(strip_tags(trim($_POST['booking_id'] ?? '')), ENT_QUOTES, 'UTF-8');
        $newStatus = htmlspecialchars(strip_tags(trim($_POST['status'] ?? '')), ENT_QUOTES, 'UTF-8');
        
      
        $booking = $this->bookingModel->find($id);
        $paymentDetails = $this->paymentModel->getPaymentByBookingId($id);
    
        
        if(!$booking){
            $this->renderView("error", "errorPage");
            exit();    
        }

       
        $datas = ["status" => $newStatus];
        $request = $this->bookingModel->update($id, $datas);

        if(!$request){
            $this->renderView("error", "errorPage");
            exit();    
        }

        
        if($newStatus === "completed" && isset($booking['slot_id'])){
            $slotData = ["status" => "available"];
            $this->parkingSlotModel->update($booking['slot_id'], $slotData);
        }

  
        if($newStatus === "active" && isset($booking['slot_id'])){
            $slotData = ["status" => "occupied"];
            $paymentData = ["payment_status" => "paid"];
            $this->parkingSlotModel->update($booking['slot_id'], $slotData);
            $this->paymentModel->update($paymentDetails["payment_id"], $paymentData);
        }

        
        if($newStatus === "pending" && isset($booking['slot_id'])){
            $slotData = ["status" => "reserved"];
            $this->parkingSlotModel->update($booking['slot_id'], $slotData);
        }

        $this->getBookingsPage();
        exit();
    }





}
