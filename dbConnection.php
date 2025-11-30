<?php

class DbConnection{

    private static $instance = NULL;


    public static function getInstance(){
        if(!isset(self::$instance)){
            try{

                $pdo = new PDO("sqlite:" . __DIR__ . "/database/parkwise.db");

                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                self::$instance = $pdo;
            }catch(PDOException $e){
                exit("SOMETHING WENT WRONG WHILE CONNECTING TO DATABASE" .  $e->getMessage());
            }
        }
        return self::$instance;
    }

}