<?php

require '../../app/vendor/autoload.php';
require "../../config.php";
require_once "../../app/src/helper/Database.php";
header("Location: ../../index.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//PRISTUP DO DB
date_default_timezone_set("Europe/Bratislava");


$db = (new App\Helper\Database)->getConnection();
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
$req = "";

foreach ($db->query($query) as $row) {
    $arr = [$row['date'], $row['command'], $row['info'], $row['mistake_info']];
    $req .= implode("','", $arr);
    $req .= "<br>";

}

$mail = new PHPMailer(true);

//log do mailu WebTech2Finall
//heslo WebTech2Finall123

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host = "smtp.gmail.com";                   //Set the SMTP server to send through
    $mail->SMTPAuth = true;                                   //Enable SMTP authentication
    $mail->Username = 'WebTech2Finall@gmail.com';                     //SMTP username
    $mail->Password = 'WebTech2Finall123';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('WebTechFinal@gmail.com', 'Webtech Export');
    $mail->addAddress($email, 'Recipient');     //Add a recipient

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Logs from database';
    $mail->Body = 'DATE, COMMAND, INFORMATION, MISTAKE INFORMATION<br>' . $req . '<br>';
//    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";

}
