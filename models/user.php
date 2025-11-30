<?php

class User{
    private $db;

     public function __construct(){
        $this->db = DbConnection::getInstance();
    }


    public function create($datas){

        try{
            $sql = "INSERT INTO User (username, email, phonenumber, address) VALUES (:username, :email, :phonenumber, :address)";
    
            $request = $this->db->prepare($sql);
            $request->execute([
                "username" => $datas["username"],
                "email" => $datas["email"],
                "phonenumber" => $datas["phonenumber"],
                "address" => $datas["address"],
            ]);


           return $this->db->lastInsertId();

        }catch(PDOException $e){
            error_log($e->getMessage());
            return false;
        }
    }

    public function getUser($id){
        try{

            $sql = "SELECT * FROM User WHERE user_id = :id";

            $request = $this->db->prepare($sql);
            $request->execute(["id" => $id]);

            $result = $request->fetch(PDO::FETCH_ASSOC);

            return  $result;

        }catch(PDOException $e){
            error_log($e->getMessage());
            return false;
        }
    }

    public function update($id, $datas){
        try{

            $fields = []; //(username = :username, email = :email, phonenumber = :phonenumber, address = :address)
            $params = []; // ["username" =>$datas["username"]]

            foreach($datas as $key => $value){
                $fields[] = "$key = :$key";
                $params["$key"] = $value;
            }

            $params["id"] = $id;

            $sql = "UPDATE User SET " . implode(", ", $fields) .  " WHERE user_id = :id";

            $request = $this->db->prepare($sql);
            $request->execute($params);


            return $request->rowCount() > 0;



        }catch(PDOException $e){
            error_log($e->getMessage());
            return false;
        }
    }

    public function delete($id){
        try{
            $sql = "DELETE FROM User WHERE user_id = :id";

            $request = $this->db->prepare($sql);
            $request->execute(["id" => $id]);


            return $request->rowCount() > 0;


        }catch(PDOException $e){
            error_log($e->getMessage());
            return false;
        }
    }
}