<?php

namespace App\Helper;
use Dotenv;
use PDO;
use PDOException;
class Database {
    private $conn;
    public function getConnection(){
        $this->conn = null;
        $host="mysql";
        $db="final";
        $user="user";
        $pass="user";
        try{
            $this->conn = new PDO("mysql:host=" .  $host . ";dbname=" . $db, $user, $pass);
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $exception){
            echo "Database could not be connected: " . $exception->getMessage();
        }
        return $this->conn;
    }



}