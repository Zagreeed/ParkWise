<?php

class Bookings extends BaseModel{
    private $table = "Bookings"; 
    private $primaryKey = "booking_id"; 
    private $fillable = ["user_id", "vehicle_id", "slot_id", "booking_time", "start_time", "end_time", "status"]; 



    public function getTotalBookings(){
        try{

            $sql = "SELECT COUNT(*) AS total_bookings FROM {$this->table} WHERE status = 'completed'";

            $request = $this->db->query($sql);

            $data = $request->fetch(PDO::FETCH_ASSOC);

            return $data;

        }catch(PDOException $e){
            error_log($e->getMessage());
            return false;
        }
    }

    public function getBookingsDetail(){
        try{
            $sql = "SELECT 
                        b.booking_id,
                        u.username,
                        v.vehicle_type AS vehicle,
                        p.slot_number AS slot,
                        b.start_time,
                        b.end_time,
                        b.status
                    FROM Bookings b
                    INNER JOIN User u ON b.user_id = u.user_id
                    INNER JOIN Vehicle v ON b.vehicle_id = v.vehicle_id
                    INNER JOIN ParkingSlot p ON b.slot_id = p.slot_id
                    ORDER BY b.booking_time DESC";

            $request = $this->db->query($sql);

            $datas = $request->fetchAll(PDO::FETCH_ASSOC);

            return $datas;


        }catch(PDOException $e){
            error_log($e->getMessage());
            return [];
        }
    }
}