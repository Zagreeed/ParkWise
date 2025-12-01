<?php

class User extends BaseModel{ 

    private $table = "User"; 
    private $primaryKey = "user_id"; 
    private $fillable = ["username", "email", "phonenumber", "address"]; 

     public function getTotalUser(){
        try{

            $sql = "SELECT COUNT(*) AS total_user FROM {$this->table}";

            $request = $this->db->query($sql);

            $data = $request->fetch(PDO::FETCH_ASSOC);

            return $data["total_user"] ?? 0;

        }catch(PDOException $e){
            error_log($e->getMessage());
            return false;
        }
    }
   
}