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

    public function getVehicleCountType(){
        try{
            $sql = "SELECT 
                        SUM(CASE WHEN vehicle_type = 'Car' THEN 1 ELSE 0 END) AS car_count,
                        SUM(CASE WHEN vehicle_type = 'Motorcycle' THEN 1 ELSE 0 END) AS motorcycle_count,
                        SUM(CASE WHEN vehicle_type = 'Truck' THEN 1 ELSE 0 END) AS truck_count,
                        COUNT(*) AS total_vehicles
                    FROM Vehicle";

            $request = $this->db->prepare($sql);
            $request->execute();

            $data = $request->fetch(PDO::FETCH_ASSOC);

                
            return $data ?: [
                'car_count' => 0,
                'motorcycle_count' => 0,
                'truck_count' => 0,
                'total_vehicles' => 0
            ];
        }catch(PDOException $e){
            error_log($e->getMessage());
           
            return [
                'car_count' => 0,
                'motorcycle_count' => 0,
                'truck_count' => 0,
                'total_vehicles' => 0
            ];
        }
    }
   
}