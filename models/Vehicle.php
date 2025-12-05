<?php


class Vehicle extends BaseModel{
    protected $table = "Vehicle"; 
    protected $primaryKey = "vehicle_id"; 
    protected $fillable = ["user_id", "plate_number", "vehicle_type", "brand"]; 



    public function getUserVehicles($userId){
        try{

            $sql = "SELECT * FROM {$this->table} WHERE user_id = :userId";

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