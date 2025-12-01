<?php

class AdminController extends BaseController{
    
    protected $bookingModel;
    protected $parkingSlotModel;
    protected $paymentModel;
    protected $userModel; 


    public function __construct(){
        $this->$bookingModel = $this->loadModel("Bookings");
        $this->$parkingSlotModel = $this->loadModel("ParkingSlot");
        $this->$paymentModel = $this->loadModel("Payments");
        $this->$userModel = $this->loadModel("User");
    }


    public function getDashBoardData(){

        $totalBookings = $this->bookingModel->getTotalBookings();
        $availableSlot = $this->parkingSlotModel->getAvailableSlot();
        $totalRevenue = $this->$paymentModel->getRevenue();
        $totalUser = $this->userModel->getTotalUser();


        $datas = [
            "totalBookings" => $totalBookings,
            "availableSlot" => $availableSlot,
            "totalRevenue" => $totalRevenue,
            "totalUser" => $totalUser,
        ];


        $this->renderView("admin", "dashBoard", $datas);


        
    }


    public function getParkingSlotsPage(){
        $datas = $this->parkingSlotModel->getAll();

        $this->renderView("admin", "parkingSlotPage", $datas);
    }

    public function getBookingsPage(){
       $datas = $this->bookingModel->getBookingsDetail();

       $this->renderView("admin", "BookingsPage", $datas);
    }

    public function getPaymentsPage(){
        $datas = $this->paymentModel->getAll();

        $this->renderView("admin","PaymentsPage", $datas);
    }

    public function getUserContactPage(){
        $datas = $this->userModel->getAll();

        $this->renderView("admin", "UserDetailsPage", $datas);
    }





}
