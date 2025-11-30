<?php

class BaseModel{
    protected $db;
    protected $table;
    protected $primareyKey;
    protected $fillable = [];

    public function __construct(){
        $this->db = DbConnection::getInstance();
    }


    public function create($datas){
        try{

            $filteredDatas = $this->filterFillable($datas);

            $coloums = implode(', ', array_keys($filteredDatas));
            $fields =  ":" . implode(", :", array_keys($filteredDatas));

            $sql = "INSERT INTO $this->table ($coloums) VALUES($fields)";
            $request = $this->db->prepare($sql);
            $request->execute($filteredDatas);

            return $this->db->lastInserted();

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
            in_array($this->fillable, $key);
        }, ARRAY_FILTER_USE_KEY);
    }


}