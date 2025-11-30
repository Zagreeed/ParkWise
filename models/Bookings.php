<?php

class Bookings extends BaseModel{
    private $table = "Bookings"; 
    private $primaryKey = "booking_id"; 
    private $fillable = ["user_id", "vehicle_id", "slot_id", "booking_time", "start_time", "end_time", "status"]; 
}