<?php
require_once "../../../app/src/helper/Database.php";

//header('Content-Type: application/json; charset=utf-8');

    if(isset($_GET['name'])){
    try {
        $db = (new App\Helper\Database)->getConnection();
        if (!$db) {
            echo "errorConnect";
            exit();
        }
    } catch (Exception $e) {
        echo $e;
    }

        $name = $_GET['name'];
    $table = 'sync';
    if ($result = $db->query("show tables like '" . $table . "'")) {
        if ($result->rowCount() != 0) {
        } else {
            $db->query("CREATE TABLE `final`.`sync` ( `name` TEXT NOT NULL , `r` TEXT , `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ) ENGINE = InnoDB;");
        }
    }
    $stmt = $db->prepare("select count(*) from sync where name = ?");
    $stmt->execute([$name]);
    $result = $stmt->fetch();
    if ($result['count(*)'] != 0) {
        echo "alredyExists";
        exit();
    }

    $stmt = $db->prepare("insert into sync (name) values (:name)");
    $stmt->bindParam(":name", $name, PDO::PARAM_STR);
    $stmt->execute();

    $stmt = $db->prepare("select distinct name from sync where name != '" . $name . "'");
    $stmt->execute();
    $names = $stmt->fetchAll();
    $json_all = json_encode($names);
    echo $json_all;
    }

