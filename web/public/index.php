<!doctype html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Zadanie final</title>
    <meta name="description" content="The HTML5 Herald">
    <meta name="author" content="SitePoint">
    <script src="./js/script.js"></script>

    <style>
        table,
        tr,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>

</head>

<body>
    <h1>OH</h1>
    <?php
    $conn = null;
    try {
        $conn = new PDO("mysql:host=" .  "mysql" . ";dbname=" . "final", "user", "user");
        $conn->exec("set names utf8");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $exception) {
        echo "Database could not be connected: " . $exception->getMessage();
    }
    if ($conn) {
        echo "connected";
    }
    echo "<br>";
    echo (exec("pwd"));

    ?>


</body>
</html>