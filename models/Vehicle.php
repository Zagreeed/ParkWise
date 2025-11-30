<?php


class Vehicle extends BaseModel{
    private $table = "Vehicle"; 
    private $primaryKey = "vehicle_id"; 
    private $fillable = ["user_id", "plate_number", "vehicle_type", "brand"]; 
   
}