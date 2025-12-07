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


    public function getDashBoardData(){

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
        $datas = [
                    "status" => htmlspecialchars(strip_tags(trim($_POST['status'] ?? '')), ENT_QUOTES, 'UTF-8'),
                ];
            

            
        $request = $this->bookingModel->update($id, $datas);

        if(!$request){
            $this->renderView("error", "errorPage");
            exit();    
        }

        $this->getBookingsPage();
        exit();

    }





}
