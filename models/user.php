<?php

class User extends BaseModel{ 

    protected $table = "User"; 
    protected $primaryKey = "user_id"; 
    protected $fillable = ["username", "email", "phonenumber", "address", "password", "role"]; 

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

      public function getAllUser(){
        try{

            $sql = "SELECT * FROM {$this->table} WHERE role = 'user'";

            $request = $this->db->query($sql);

            $result = $request->fetchAll(PDO::FETCH_ASSOC);

            return $result;

        }catch(PDOException $e){
            error_log($e->getMessage());
            return false;
        }
    }

    public function findUserByEmail($email){
        try{

            $sql = "SELECT * FROM {$this->table} WHERE email = :email";

            $request = $this->db->prepare($sql);
            $request->execute(["email" => $email]);

            $data = $request->fetch(PDO::FETCH_ASSOC);

             return $data ?: null;

        }catch(PDOException $e){
            error_log($e->getMessage());
            return false;
        }
    }


    public function getUserAllActivity($userId, $limit){
        try{

            $sql = "SELECT 
                        'booking_confirmed' as activity_type,
                        b.booking_id as activity_id,
                        'Booking confirmed - ' || ps.location as description,
                        ps.slot_number as slot_number,
                        ROUND((julianday(b.end_time) - julianday(b.start_time)) * 24) as duration_hours,
                        COALESCE(p.amount, 0) as amount,
                        v.plate_number as vehicle_plate,
                        v.vehicle_type as vehicle_type,
                        v.brand as vehicle_brand,
                        NULL as payment_method,
                        b.created_at as activity_time,
                        b.status as activity_status
                    FROM Bookings b
                    JOIN ParkingSlot ps ON b.slot_id = ps.slot_id
                    JOIN Vehicle v ON b.vehicle_id = v.vehicle_id
                    LEFT JOIN Payments p ON b.booking_id = p.booking_id
                    WHERE b.user_id = :user_id

                    UNION ALL

                    SELECT 
                        'payment_completed' as activity_type,
                        p.payment_id as activity_id,
                        'Payment completed - ₱' || p.amount as description,
                        NULL as slot_number,
                        NULL as duration_hours,
                        p.amount as amount,
                        NULL as vehicle_plate,
                        NULL as vehicle_type,
                        NULL as vehicle_brand,
                        p.payment_method as payment_method,
                        p.payment_date as activity_time,
                        p.payment_status as activity_status
                    FROM Payments p
                    JOIN Bookings b ON p.booking_id = b.booking_id
                    WHERE b.user_id = :user_id AND p.payment_status = 'paid'

                    UNION ALL

                    SELECT 
                        'parking_active' as activity_type,
                        b.booking_id as activity_id,
                        'Parked at Slot ' || ps.slot_number || ' - ' || ps.location as description,
                        ps.slot_number as slot_number,
                        NULL as duration_hours,
                        NULL as amount,
                        v.plate_number as vehicle_plate,
                        v.vehicle_type as vehicle_type,
                        v.brand as vehicle_brand,
                        NULL as payment_method,
                        b.start_time as activity_time,
                        b.status as activity_status
                    FROM Bookings b
                    JOIN ParkingSlot ps ON b.slot_id = ps.slot_id
                    JOIN Vehicle v ON b.vehicle_id = v.vehicle_id
                    WHERE b.user_id = :user_id AND b.status = 'active'

                    ORDER BY activity_time DESC
                    LIMIT :limit";

            $request = $this->db->prepare($sql);
            $request->bindValue(':user_id', $userId, PDO::PARAM_INT);
            $request->bindValue(':limit', $limit, PDO::PARAM_INT);
            $request->execute();


            $datas = $request->fetchAll(PDO::FETCH_ASSOC);


            return $datas;
                

        }catch(PDOException $e){
            error_log($e->getMessage());
            return [];
        }
    }
   
}