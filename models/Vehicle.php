<?php


class Vehicle extends BaseModel{
    protected $table = "Vehicle"; 
    protected $primaryKey = "vehicle_id"; 
    protected $fillable = ["user_id", "plate_number", "vehicle_type", "brand"]; 
   
}