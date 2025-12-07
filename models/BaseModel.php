<?php

class BaseModel{
    protected $db;
    protected $table;
    protected $primaryKey;
    protected $fillable = [];

    public function __construct(){
        $this->db = DbConnection::getInstance();
    }


    public function create($datas){
        try{

            $filteredDatas = $this->filterFillable($datas);

            $coloums = implode(', ', array_keys($filteredDatas));
            $fields =  ":" . implode(", :", array_keys($filteredDatas));

            $sql = "INSERT INTO {$this->table} ($coloums) VALUES($fields)";
            $request = $this->db->prepare($sql);
            $request->execute($filteredDatas);

            return $this->db->lastInsertId();

        }catch(PDOException $e){
            error_log($e->getMessage());
            return false;
        }
    }

    public function find($id){
        try{

            $sql =  "SELECT * FROM $this->table WHERE {$this->primaryKey} = :id";

            $request = $this->db->prepare($sql);
            $request->execute(["id" => $id]);

            $result = $request->fetch(PDO::FETCH_ASSOC);

            return $result;


        }catch(PDOException $e){
            error_log($e->getMessage());
            return false;
        }
    }

    public function getAll(){
        try{

            $sql = "SELECT * FROM {$this->table}";

            $request = $this->db->query($sql);

            $result = $request->fetchAll(PDO::FETCH_ASSOC);

            return $result;

        }catch(PDOException $e){
            error_log($e->getMessage());
            return false;
        }
    }

    public function update($id, $datas){
        try{

            $filterdDatas = $this->filterFillable($datas);

            $fields = [];

            foreach($filterdDatas as $key => $value){
                $fields[] = "$key = :$key";
            }
            
            $filterdDatas["id"] = $id;

            $sql = "UPDATE {$this->table} SET " . implode(", ", $fields) .  " WHERE  {$this->primaryKey} = :id";

            $request = $this->db->prepare($sql);
            $request->execute($filterdDatas);

            return $request->rowCount() > 0;


        }catch(PDOException $e){
            error_log($e->getMessage());
            return false;
        }
    }

    public function updateOneField($id, $field, $data){
        try{
            $sql = "UPDATE {$this->table} SET {$field} = :value WHERE  {$this->primaryKey} = :id";

            $request = $this->db->prepare($sql);
            $request->execute(["value" => $data, "id" => $id]);

            return $request->rowCount() > 0;
        }catch(PDOException $e){
            error_log($e->getMessage());
            return false;
        }
    }


    public function delete($id){
        try{
            $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id";

            $request = $this->db->prepare($sql);
            $request->execute(["id" => $id]);

            return $request->rowCount() > 0;
        }catch(PDOException $e){
            error_log($e->getMessage());
            return false;
        }
    }


    public function filterFillable($datas){
        if(empty($this->fillable)){
            return $datas;
        }

        return array_filter($datas, function($key){
            return in_array($key, $this->fillable);
        }, ARRAY_FILTER_USE_KEY);
    }


}