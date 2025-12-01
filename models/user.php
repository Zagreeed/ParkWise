<?php

class User extends BaseModel{ 

    protected $table = "User"; 
    protected $primaryKey = "user_id"; 
    protected $fillable = ["username", "email", "phonenumber", "address"]; 

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