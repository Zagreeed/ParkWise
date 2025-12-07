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

    public function getAvailableSlotDetail(){
        try{

            $sql = "SELECT * FROM {$this->table} WHERE status = 'available'";

            $request = $this->db->prepare($sql);
            $request->execute();

            $datas = $request->fetchAll(PDO::FETCH_ASSOC);

            return $datas ?: [];

        }catch(PDOException $e){
            error_log($e->getMessage());
            return [];
        }
    }

    public function getSlotsAvailability(){
        try{

            $sql = "SELECT 
                        SUM(CASE WHEN status = 'available' THEN 1 ELSE 0 END) AS available_count,
                        SUM(CASE WHEN status = 'reserved' THEN 1 ELSE 0 END) AS reserved_count,
                        SUM(CASE WHEN status = 'occupied' THEN 1 ELSE 0 END) AS occupied_count,
                        COUNT(*) AS total_slots
                    FROM ParkingSlot;";

            $request = $this->db->prepare($sql);
            $request->execute();


            $data = $request->fetch(PDO::FETCH_ASSOC);


           return $data ?: [  
            'available_count' => 0,
            'reserved_count' => 0,
            'occupied_count' => 0,
            'total_slots' => 0
        ];

        }catch(PDOException $e){
            error_log($e->getMessage());
           return $data ?: [  
            'available_count' => 0,
            'reserved_count' => 0,
            'occupied_count' => 0,
            'total_slots' => 0
        ];

        }
    }
}