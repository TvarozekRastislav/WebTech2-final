<?php
require_once "../../../app/src/helper/Database.php";

$rawValue = file_get_contents('php://input');
$data = json_decode($rawValue);

echo "here";

$name = $_POST['ajax_data'];
try {
    $db = (new App\Helper\Database)->getConnection();
    if (!$db) {
        echo "errorConnect";
        exit();
    }
} catch (Exception $e) {
    echo $e;
}
$stmt = $db->prepare("delete from sync where name = '" . $name . "'");
$stmt->execute();
