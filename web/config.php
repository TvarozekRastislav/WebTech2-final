<?php
$acces_token="kiRkR15MBEypq7Che"; //token to enable API

    session_start();
    if(!isset($_SESSION['lang']))
        $_SESSION['lang']="sk";
    else if (isset($_GET['lang'])&&$_SESSION['lang']!=$_GET['lang'] && !empty($_GET['lang'])){
        if ($_GET['lang']=="sk")
            $_SESSION['lang']="sk";
        else if ($_GET['lang']=="en")
            $_SESSION['lang']="en";
    }

//    require_once "app/lang/".$_SESSION['lang'].".php";
//    require_once "public/lang/".$_SESSION['lang'].".php";
$email="WebTech2Finall@gmail.com";
$host="mysql";
$db="final";
$user="user";
$pass="user";
?>
