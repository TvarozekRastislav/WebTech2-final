<?php

require_once "../../app/src/helper/Database.php";

//EXPORT DO CSV
$delimiter = ",";
$db= (new App\Helper\Database)->getConnection();
date_default_timezone_set("Europe/Bratislava");
$query = "SELECT date,command,info,mistake_info FROM requirements";
header('Content-Type: text/csv');
header('Content-Disposition: form-data; filename=data.csv');
$req=[];
$df = fopen("php://output", 'w');
fputcsv($df, array( 'DATE', 'COMMAND', 'INFORMATION', 'MISTAKE INFORMATION'),$delimiter);
foreach ($db->query($query) as $row) {
    //date ide podla inej timezone, toto este vyriesim
    fputcsv($df, array( $row['date'],$row['command'],$row['info'],$row['mistake_info']),$delimiter);
}
fpassthru($df);
exit();
?>