<?php
require_once "../../config.php";
require_once "../../app/api/ScriptCalculation.php";
header('Content-Type: application/json; charset=utf-8');

switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        header("HTTP/1.1 200 OK");
        if (isset($_GET['acces_token']) && !empty($_GET['r'])) {//kontrola tokenu a hodnoty r
            if ($_GET['acces_token'] == $acces_token && is_float(floatval($_GET['r']))) {
                $r = $_GET['r'];
                $script_runner = new ScriptCalculation();
                $dataT = $script_runner->handleOutputT($r);
                $dataY = $script_runner->handleOutput_Y($r);
                $dataX = $script_runner->handleOutput_X($r);
                unset($_POST['r']);
                $jsonDataT = json_encode($dataT);
                $jsonDataY = json_encode($dataY);
                $jsonDataX = json_encode($dataX);
            } else {
                if ($_GET['acces_token'] != $acces_token) {            //ak je chyba na strane tokenu pri zadavani hodnoty r
                    $err = "Wrong access token!";
                    $json_err = json_encode($err);
                } else {                          //ak je chybny input
                    $wrong_input = "Wrong input!";
                    $json_err = json_encode($wrong_input);
                }
            }
        }
        // KOD PRE HOCIJAKY PRIKAZ Z OCTAVE
        if (isset($_GET['acces_token']) && !empty($_GET['prikaz'])) {
                //kontrola tokenu a ci bol prikaz zadany
            if ($_GET['acces_token'] == $acces_token) {
                $command = urldecode($_GET['prikaz']);
                $command=str_replace(" ","+",$command);
                echo $command;
                $scriptRunner = new ScriptCalculation();
                $o = $scriptRunner->runOctaveCommand($command);
                $check = implode($o[0]);
                if (str_contains($check, "err")) {
                    $json_cmd_err = json_encode($check);        //ak nastane nejaky error pri zadani octave commandu pouzivatelom padne to sem a v $check
                    echo $json_cmd_err;                                                   //je popis erroru ktory treba ulozit do DB
                } else {
                    $json_message = json_encode($check);//ak je vsetko OK padne to sem a vypíše vysledok prikazu toto asi este prerobim nejako aby to pekne vypisalo niekde na stranku
                    echo $json_message;

                }
                unset($_GET['prikaz']);
            }
        } else {
            if (isset($_GET['acces_token']) != $acces_token) {        //ak je chyba na strane tokenu pri zadavani hodnoty r
                $err = "Wrong access token!";
                $json_err = json_encode($err);
            } else {                                          //ak je problem s inputom
                $wrong_input = "Wrong input!";
                $json_err = json_encode($wrong_input);
            }
        }
}
?>
