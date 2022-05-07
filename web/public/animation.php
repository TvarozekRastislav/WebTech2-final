<?php
session_start();
if(isset($_SESSION['x'])){
    $dataX=$_SESSION['x'];      //tieto premenne obsahuju data z ktorych sa moze robit graf alebo animacia GL HF
    $dataY=$_SESSION['y'];
    $dataT=$_SESSION['t'];
    var_dump($dataX);
    session_destroy();
}
?>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Animácia</title>
</head>
<body>
<h1>Animácia</h1>

h
</body>
</html>