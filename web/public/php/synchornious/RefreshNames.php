<?php
require_once "../../../app/src/helper/Database.php";

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
    $stmt = $db->prepare("select distinct name from sync where name != '" . $name . "'");
    $stmt->execute();
    $names = $stmt->fetchAll();
    $json_all = json_encode($names);
    echo $json_all;
}
