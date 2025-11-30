<?php

class ParkingSlot extends BaseModel{
    private $table = "ParkingSlot"; 
    private $primaryKey = "slot_id"; 
    private $fillable = ["slot_number", "location", "status"]; 
}