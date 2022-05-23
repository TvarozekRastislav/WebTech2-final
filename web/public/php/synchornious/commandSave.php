<?php
require_once "../../../app/src/helper/Database.php";

$rawValue = file_get_contents('php://input');
$data = json_decode($rawValue);

$name = $_GET['name'];
$r = $_GET['obstacleHeight'];

try {
    $db = (new App\Helper\Database)->getConnection();
    if (!$db) {
        echo "errorConnect";
        exit();
    }
} catch (Exception $e) {
    echo $e;
}
$stmt = $db->prepare("insert into sync (name,r) values (:name,:r)");
$stmt->bindParam(":name", $name, PDO::PARAM_STR);
$stmt->bindParam(":r", $r, PDO::PARAM_STR);

$stmt->execute();


