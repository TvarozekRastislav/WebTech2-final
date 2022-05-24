<?php
require_once "../../../app/src/helper/Database.php";

header('Content-Type: application/json; charset=utf-8');

if (isset($_GET['name'])) {
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
    $stmt = $db->prepare("select * from sync where name = '" . $name . "'and timestamp = (select max(timestamp) from sync where name = '" . $name . "')");
    $stmt->execute();
    $names = $stmt->fetch();
    $json_all = json_encode($names);
    echo $json_all;
}
