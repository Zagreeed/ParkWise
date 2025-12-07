<?php

class Payments extends BaseModel{
    protected $table = "Payments"; 
    protected $primaryKey = "payment_id"; 
    protected $fillable = ["booking_id", "amount", "payment_method", "payment_status"]; 

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


    public function getTotalSpentForAMonth($userId){
        try{

            $sql = "SELECT 
                        SUM(p.amount) AS total_spent
                    FROM 
                        Payments p
                    INNER JOIN 
                        Bookings b ON p.booking_id = b.booking_id
                    WHERE 
                        b.user_id = :userId
                        AND p.payment_status = 'paid'
                        AND strftime('%Y-%m', p.payment_date) = strftime('%Y-%m', 'now')";

            $request = $this->db->prepare($sql);
            $request->execute(["userId" => $userId]);

            $data = $request->fetch(PDO::FETCH_ASSOC);

             return empty($data) || $data['total_spent'] === null ? 0 : $data['total_spent'];

        }catch(PDOException $e){
            error_log($e->getMessage());
            return false;
        }

    }


    public function getPaymentByBookingId($id){
        try{

            $sql = "SELECT * FROM {$this->table} WHERE booking_id = :id";

            $request = $this->db->prepare($sql);
            $request->execute(["id" => $id]);

            $data = $request->fetch(PDO::FETCH_ASSOC);


            return !empty($data) ? $data : false;

        }catch(PDOException $e){
            error_log($e->getMessage());
            return false;
        }
    }
}