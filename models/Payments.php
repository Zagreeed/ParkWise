<?php

class Payments extends BaseModel{
    private $table = "ParkingSlot"; 
    private $primaryKey = "slot_id"; 
    private $fillable = ["booking_id", "amount", "payment_method", "payment_status"]; 
}