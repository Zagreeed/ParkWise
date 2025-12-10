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

        // Check if this is an open-time booking
        $endDateTime = new DateTime($booking['end_time']);
        $isOpenTime = ($endDateTime->format('m-d H:i') === '12-31 23:59');

        // Update booking status
        $datas = ["status" => $newStatus];
        $request = $this->bookingModel->update($id, $datas);

        if(!$request){
            $this->renderView("error", "errorPage");
            exit();    
        }

        
        // Handle status changes based on new status
        if($newStatus === "completed"){
            // For open-time bookings that are being manually completed
            if($isOpenTime){
                // Don't allow manual completion to "completed" for open-time bookings
                // They should use the "Complete & Calculate" button instead
                $_SESSION["errors"] = "Open-time bookings must be completed using the 'Complete & Calculate' button to calculate the final amount.";
                $this->getBookingsPage();
                exit();
            }
            
            // For normal bookings - set slot to available
            if(isset($booking['slot_id'])){
                $slotData = ["status" => "available"];
                $this->parkingSlotModel->update($booking['slot_id'], $slotData);
            }
        }

  
        if($newStatus === "active" && isset($booking['slot_id'])){
            $slotData = ["status" => "occupied"];
            $this->parkingSlotModel->update($booking['slot_id'], $slotData);
            
            // Only update payment to "paid" for NON open-time bookings
            if(!$isOpenTime && $paymentDetails && is_array($paymentDetails)){
                $paymentData = ["payment_status" => "paid"];
                $this->paymentModel->update($paymentDetails["payment_id"], $paymentData);
            }
            // For open-time bookings, payment remains "pending"
        }

        
        if($newStatus === "pending" && isset($booking['slot_id'])){
            $slotData = ["status" => "reserved"];
            $this->parkingSlotModel->update($booking['slot_id'], $slotData);
        }

        $_SESSION["success"] = "Booking status updated successfully";
        $this->getBookingsPage();
        exit();
    }

    public function updateSlotStatus(){
        if($_SERVER["REQUEST_METHOD"] != "POST"){
            $this->renderView("error", "errorPage");
            exit();    
        }

        $slotId = htmlspecialchars(strip_tags(trim($_POST['slot_id'] ?? '')), ENT_QUOTES, 'UTF-8');
        $newStatus = htmlspecialchars(strip_tags(trim($_POST['status'] ?? '')), ENT_QUOTES, 'UTF-8');
        
    
        if(empty($slotId) || empty($newStatus)){
            $_SESSION["errors"] = "Slot ID and status are required";
            $this->getParkingSlotsPage();
            exit();
        }

        
        $validStatuses = ['available', 'occupied', 'reserved'];
        if(!in_array($newStatus, $validStatuses)){
            $_SESSION["errors"] = "Invalid status value";
            $this->getParkingSlotsPage();
            exit();
        }

      
        $slot = $this->parkingSlotModel->find($slotId);
        
        if(!$slot){
            $_SESSION["errors"] = "Parking slot not found";
            $this->getParkingSlotsPage();
            exit();    
        }

        
        $activeBooking = $this->bookingModel->getActiveBookingBySlot($slotId);
        
  
        if($newStatus === 'available' && $activeBooking){
            $_SESSION["errors"] = "Cannot set slot to available - there is an active booking (ID: " . $activeBooking['booking_id'] . ")";
            $this->getParkingSlotsPage();
            exit();
        }

      
        $data = ["status" => $newStatus];
        $request = $this->parkingSlotModel->update($slotId, $data);

        if(!$request){
            $_SESSION["errors"] = "Failed to update slot status";
            $this->getParkingSlotsPage();
            exit();    
        }

       
        $statusMessages = [
            'available' => "Slot {$slot['slot_number']} is now available for booking",
            'occupied' => "Slot {$slot['slot_number']} marked as occupied (maintenance/blocked)",
            'reserved' => "Slot {$slot['slot_number']} marked as reserved"
        ];

        $_SESSION["success"] = $statusMessages[$newStatus];
        $this->getParkingSlotsPage();
        exit();
    }


    public function completeOpenTimeBooking(){
    if($_SERVER["REQUEST_METHOD"] != "POST"){
        $this->renderView("error", "errorPage");
        exit();    
    }

    $bookingId = htmlspecialchars(strip_tags(trim($_POST['booking_id'] ?? '')), ENT_QUOTES, 'UTF-8');
    
    // Debug log
    error_log("CompleteOpenTimeBooking called with booking_id: " . $bookingId);
    
    if(empty($bookingId)){
        $_SESSION["errors"] = "Invalid booking ID - No ID provided";
        $this->getBookingsPage();
        exit();    
    }
    
    // Get booking
    $booking = $this->bookingModel->find($bookingId);
    error_log("Booking found: " . ($booking ? "YES" : "NO"));
    
    if(!$booking){
        $_SESSION["errors"] = "Booking not found with ID: " . $bookingId;
        $this->getBookingsPage();
        exit();    
    }
    
    // Get payment
    $paymentDetails = $this->paymentModel->getPaymentByBookingId($bookingId);
    error_log("Payment found: " . ($paymentDetails ? "YES" : "NO"));
    
    if(!$paymentDetails || !is_array($paymentDetails)){
        $_SESSION["errors"] = "Payment record not found for booking ID: " . $bookingId;
        $this->getBookingsPage();
        exit();    
    }

    // Detect open-time booking (Dec 31 23:59)
    $endDateTime = new DateTime($booking['end_time']);
    $isOpenTime = ($endDateTime->format('m-d H:i') === '12-31 23:59');
    
    error_log("Is open time: " . ($isOpenTime ? "YES" : "NO") . " - End time: " . $booking['end_time']);
    
    if(!$isOpenTime){
        $_SESSION["errors"] = "This is not an open-time booking. End time: " . $booking['end_time'];
        $this->getBookingsPage();
        exit();
    }
    
    // Must be active
    if($booking['status'] !== 'active'){
        $_SESSION["errors"] = "Booking must be in 'active' status to complete. Current status: " . $booking['status'];
        $this->getBookingsPage();
        exit();
    }

    // =============================
    //   NEW LOGIC: MINIMUM 1 HOUR
    // =============================

    $now = new DateTime(); // Actual end time (current time)
    $start = new DateTime($booking['start_time']);

    // Calculate raw hours
    $interval = $start->diff($now);
    $rawHours = $interval->h + ($interval->days * 24) + ($interval->i / 60);

    // If parked less than 1 hour → Force end time = now + 1 hour
    if ($rawHours < 1) {
        $now->modify('+1 hour');
    }

    // Final actual end time
    $actualEndTime = $now->format('Y-m-d H:i:s');

    // Recalculate actual duration
    $end = new DateTime($actualEndTime);
    $interval = $start->diff($end);
    $actualHours = $interval->h + ($interval->days * 24);

    // Always round up to nearest hour with a minimum of 1 hour
    $actualHours = max(1, ceil($actualHours));

    // ₱50 per hour
    $totalAmount = $actualHours * 50;

    error_log("Calculated hours: " . $actualHours . ", Total amount: " . $totalAmount);

    // Update booking
    $bookingUpdate = [
        "end_time" => $actualEndTime,
        "status" => "completed"
    ];
    
    $updateResult = $this->bookingModel->update($bookingId, $bookingUpdate);
    
    if(!$updateResult){
        $_SESSION["errors"] = "Failed to update booking. Please try again.";
        $this->getBookingsPage();
        exit();    
    }
    
    // Update payment
    $paymentUpdate = [
        "amount" => $totalAmount,
        "payment_status" => "paid"
    ];
    
    $paymentUpdateResult = $this->paymentModel->update($paymentDetails["payment_id"], $paymentUpdate);
    
    if(!$paymentUpdateResult){
        $_SESSION["errors"] = "Booking updated but failed to update payment. Please check manually.";
        $this->getBookingsPage();
        exit();    
    }
    
    // Set slot available
    $slotUpdateResult = $this->parkingSlotModel->update($booking['slot_id'], ["status" => "available"]);
    
    if(!$slotUpdateResult){
        error_log("Failed to update slot status for slot_id: " . $booking['slot_id']);
    }
    
    $_SESSION["success"] = "Open-time booking completed. Duration: {$actualHours} hour(s), Amount: ₱" . number_format($totalAmount, 2);
    $this->getBookingsPage();
    exit();
}



}
