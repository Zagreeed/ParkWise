<?php

class AdminController extends BaseController{
    
    protected $bookingModel;
    protected $parkingSlotModel;
    protected $paymentModel;
    protected $userModel; 


    public function __construct(){
        $this->bookingModel = $this->loadModel("Bookings");
        $this->parkingSlotModel = $this->loadModel("ParkingSlot");
        $this->paymentModel = $this->loadModel("Payments");
        $this->userModel = $this->loadModel("User");
    }


    public function getDashBoardData(){

        $totalBookings = $this->bookingModel->getTotalBookings();
        $availableSlot = $this->parkingSlotModel->getAvailableSlot();
        $totalRevenue = $this->paymentModel->getRevenue();
        $totalUser = $this->userModel->getTotalUser();


        $datas = [
            "totalBookings" => $totalBookings,
            "availableSlot" => $availableSlot,
            "totalRevenue" => $totalRevenue,
            "totalUser" => $totalUser,
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





}
