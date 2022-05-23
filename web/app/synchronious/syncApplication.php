<?php
require_once '../../../app/src/helper/Database.php';
echo exec("pwd");

function getDb(){
    try {
        $db = (new App\Helper\Database)->getConnection();
        if (!$db) {
            echo "errorConnect";
            exit();
        }
    } catch (Exception $e) {
        echo $e;
    }
    return $db;
}

function commandSave($name,$r){
    $db = getDb();
    $stmt = $db->prepare("insert into sync (name,r) values (:name,:r)");
    $stmt->bindParam(":name", $name, PDO::PARAM_STR);
    $stmt->bindParam(":r", $r, PDO::PARAM_STR);

    $stmt->execute();

}

function getR($name){
    $db = getDb();
    $stmt = $db->prepare("select * from sync where name = '" . $name . "'and timestamp = (select max(timestamp) from sync where name = '" . $name . "')");
    $stmt->execute();
    $names = $stmt->fetch();
    $json_all = json_encode($names);
    return $json_all;
}

function NicknameLoad($name){
    $db = getDb();
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
        return "alredyExists";
        exit();
    }

    $stmt = $db->prepare("insert into sync (name) values (:name)");
    $stmt->bindParam(":name", $name, PDO::PARAM_STR);
    $stmt->execute();

    $stmt = $db->prepare("select distinct name from sync where name != '" . $name . "'");
    $stmt->execute();
    $names = $stmt->fetchAll();
    $json_all = json_encode($names);
    return $json_all;
}

function NicknameUnload($name){
    $db = getDb();
    $stmt = $db->prepare("delete from sync where name = '" . $name . "'");
    $stmt->execute();
}

function refreshNames($name){
    $db = getDb();
    $stmt = $db->prepare("select distinct name from sync where name != '" . $name . "'");
    $stmt->execute();
    $names = $stmt->fetchAll();
    $json_all = json_encode($names);
}