<?php
require "../../config.php";
require_once "../../app/src/helper/Database.php";
date_default_timezone_set("Europe/Bratislava");
//EXPORT DO CSV

$delimiter = ",";
$db = (new App\Helper\Database)->getConnection();
date_default_timezone_set("Europe/Bratislava");
$stmt0 = $db->prepare("CREATE TABLE  IF NOT EXISTS`requirements` (
                                    `id` int NOT NULL AUTO_INCREMENT,
                                    `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                    `command` varchar(535) CHARACTER SET utf8 COLLATE utf8_slovak_ci DEFAULT NULL,
                                    `info` varchar(535) CHARACTER SET utf8 COLLATE utf8_slovak_ci NOT NULL,
                                    `mistake_info` varchar(535) CHARACTER SET utf8 COLLATE utf8_slovak_ci DEFAULT NULL,
                                    primary key (id)
                                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;");
$stmt0->execute();
$query = "SELECT date,command,info,mistake_info FROM requirements";
header('Content-Type: text/csv');
header('Content-Disposition: form-data; filename=data.csv');
$req = [];
$df = fopen("php://output", 'w');
fputcsv($df, array('DATE', 'COMMAND', 'INFORMATION', 'MISTAKE INFORMATION'), $delimiter);
foreach ($db->query($query) as $row) {
    fputcsv($df, array($row['date'], $row['command'], $row['info'], $row['mistake_info']), $delimiter);
}
fpassthru($df);
exit();
?>