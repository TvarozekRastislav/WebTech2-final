<?php

namespace App\Helper;

use Dotenv;

//neviem ako si naloadujem dotenv conf,toto este upravim
//$dotenv->load();
use PDO;
use PDOException;

class Database
{

    private $conn;


    public function getConnection()
    {
        $this->conn = null;
        //premenne pojdu z env, upravim
        $host = "mysql";
        $db = "final";
        $user = "user";
        $pass = "user";
        try {
            $this->conn = new PDO("mysql:host=" .  $host . ";dbname=" . $db, $user, $pass);
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Database could not be connected: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
