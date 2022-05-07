<?php
require_once "../config.php";
require_once "../app/API/ScriptCalculation.php";
if(isset($_POST['acces_token']) && !empty($_POST['prikaz'])){       //kontrola tokenu a ci bol prikaz zadany
    if($_POST['acces_token']==$acces_token){
        $command=$_POST['prikaz'];
        $scriptRunner=new ScriptCalculation();
        $o=$scriptRunner->runOctaveCommand($command);
        $check=implode($o[0]) ;
        if(str_contains($check,"err")){
            echo '<script type="text/javascript">alert("'.$check.'");</script>';        //ak nastane nejaky error pri zadani octave commandu pouzivatelom padne to sem a v $check
                                                                                        //je popis erroru ktory treba ulozit do DB
        }else{
            echo $check;                                                                    //ak je vsetko OK padne to sem a vypíše vysledok prikazu toto asi este prerobim nejako aby to pekne vypisalo niekde na stranku
        }
        unset($_POST['prikaz']);
    }
}else{
    if($_POST['acces_token']!=$acces_token){        //ak je chyba na strane tokenu pri zadavani hodnoty r
        echo '<script type="text/javascript">';
        echo 'alert("Wrong access token");';
    echo '</script>';
    }else{                                          //ak je problem s inputom
        echo '<script type="text/javascript">';
        echo 'alert("Wrong input");';
        echo '</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="SK">
<head>
    <meta charset="UTF-8">
    <title>Formulár</title>
</head>
<body>

<form method="post" action="octave.php">
    <input type="number" step="0.01" id="r" name="r">
    <label for="r">Zadaj výšku prekážky</label>
    <input type="hidden" id="acces_token" name="acces_token" value="kiRkR15MBEypq7Che">
    <button type="submit"> Submit</button>
</form>

<form method="post" action="octave_form.php">
    <textarea type="textarea"  id="prikaz" name="prikaz"></textarea>
    <label for="prikaz">Zadaj príkaz</label>
    <input type="hidden" id="acces_token" name="acces_token" value="kiRkR15MBEypq7Che">
    <button type="submit"> Vykonaj</button>
</form>
</body>
</html>