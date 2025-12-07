<?php

class Bookings extends BaseModel{
    protected $table = "Bookings"; 
    protected $primaryKey = "booking_id"; 
    protected $fillable = ["user_id", "vehicle_id", "slot_id", "booking_time", "start_time", "end_time", "status"]; 



    public function getTotalBookings(){
        try{

            $sql = "SELECT COUNT(*) AS total_bookings FROM {$this->table} WHERE status = 'completed'";

            $request = $this->db->query($sql);

            $data = $request->fetch(PDO::FETCH_ASSOC);

            return $data["total_bookings"] ?? 0;

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
                        b.status,
                        b.slot_id
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

    public function getAllUserBookings($userId){
        try{
            $sql =  "SELECT 
                        COUNT(*) AS total_bookings
                    FROM 
                        Bookings
                    WHERE 
                        user_id = :userId";
            $request = $this->db->prepare($sql);
            $request->execute(["userId" => $userId]);

            $data = $request->fetch(PDO::FETCH_ASSOC);


            return empty($data["total_bookings"]) ? 0 : $data["total_bookings"];
            


        }catch(PDOException $e){
            error_log($e->getMessage());
            return 0;
        }
    }

    public function getUserTotalBookingTime($userId){
        try{

            $sql = "SELECT 
                        ROUND(
                            SUM(
                                (julianday(b.end_time) - julianday(b.start_time)) * 24
                            ), 
                        0) AS total_hours_this_month
                    FROM 
                        Bookings b
                    WHERE 
                        b.user_id = :userId
                        AND b.status = 'completed'
                        AND strftime('%Y-%m', b.start_time) = strftime('%Y-%m', 'now');";

            $request = $this->db->prepare($sql);
            $request->execute(["userId" => $userId]);


            $data = $request->fetch(PDO::FETCH_ASSOC);


           return $data["total_hours_this_month"] === null ? 0 : round($data["total_hours_this_month"], 2);

        }catch(PDOException $e){
            error_log($e->getMessage());
            return 0;
        }
    }

    public function getAllUserBookingHistory($userId){
        try{

            $sql = "SELECT 
                    b.booking_id,
                    b.booking_time AS date_booked,
                    b.start_time,
                    b.end_time,
                    ps.location AS parking_location,
                    ps.slot_number,
                    p.amount AS amount_paid,
                    p.payment_date,
                    p.payment_method,
                    v.plate_number,
                    v.vehicle_type,
                    v.brand
                FROM 
                    Bookings b
                INNER JOIN 
                    ParkingSlot ps ON b.slot_id = ps.slot_id
                INNER JOIN 
                    Payments p ON b.booking_id = p.booking_id
                INNER JOIN 
                    Vehicle v ON b.vehicle_id = v.vehicle_id
                WHERE 
                    b.user_id = :userId
                    AND b.status = 'completed'
                    AND p.payment_status = 'paid'
                ORDER BY 
                    b.booking_time DESC";

            $request = $this->db->prepare($sql);
            $request->execute(["userId" => $userId]);


            $datas = $request->fetchAll(PDO::FETCH_ASSOC);


            return $datas;

            


        }catch(PDOException $e){
            error_log($e->getMessage());
            return [];
        }
    }

}