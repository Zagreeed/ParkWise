<?php

class Payments extends BaseModel{
    private $table = "Payments"; 
    private $primaryKey = "slot_id"; 
    private $fillable = ["booking_id", "amount", "payment_method", "payment_status"]; 

      public function getRevenue(){
        try{

            $sql = "SELECT SUM(amount) AS total_revenue FROM {$this->table} WHERE payment_status = 'paid'";

            $request = $this->db->query($sql);

            $data = $request->fetch(PDO::FETCH_ASSOC);

            return $data["total_revenue"] ?? 0;

        }catch(PDOException $e){
            error_log($e->getMessage());
            return false;
        }
    }
}