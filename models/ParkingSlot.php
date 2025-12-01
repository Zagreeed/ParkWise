<?php

class ParkingSlot extends BaseModel{
    protected $table = "ParkingSlot"; 
    protected $primaryKey = "slot_id"; 
    protected $fillable = ["slot_number", "location", "status"]; 

    public function getAvailableSlot(){
        try{

            $sql = "SELECT COUNT(*) AS available_slot FROM {$this->table} WHERE status = 'available'";

            $request = $this->db->query($sql);

            $data = $request->fetch(PDO::FETCH_ASSOC);

            return $data["available_slot"] ?? 0;

        }catch(PDOException $e){
            error_log($e->getMessage());
            return false;
        }
    }
}