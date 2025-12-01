<?php

class ParkingSlot extends BaseModel{
    private $table = "ParkingSlot"; 
    private $primaryKey = "slot_id"; 
    private $fillable = ["slot_number", "location", "status"]; 

    public function getAvailableSlot(){
        try{

            $sql = "SELECT COUNT(*) AS available_slot FROM {$this->table} WHERE status = 'available'";

            $request = $this->db->query($sql);

            $data = $request->fetch(PDO::FETCH_ASSOC);

            return $data;

        }catch(PDOException $e){
            error_log($e->getMessage());
            return false;
        }
    }
}