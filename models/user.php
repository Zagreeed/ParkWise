<?php

class User extends BaseModel{ 

    private $table = "User"; 
    private $primaryKey = "user_id"; 
    private $fillable = ["username", "email", "phonenumber", "address"]; 
   
}