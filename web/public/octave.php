<?php
require_once "../app/API/ScriptCalculation.php";
require_once "../config.php";
$script_runner=new ScriptCalculation();
$lines = file('../app/Octave/output_Y.txt', FILE_IGNORE_NEW_LINES);
if(isset($_POST['acces_token']) && !empty($_POST['r'])){        //kontrola tokenu a hodnoty r
    if($_POST['acces_token']==$acces_token){
        $r=$_POST['r'];
        $dataT=$script_runner->handleOutputT($r);
        $dataY=$script_runner->handleOutput_Y($r);
        $dataX=$script_runner->handleOutput_X($r);
        unset($_POST['r']);
        $_SESSION['t']=$dataT;
        $_SESSION['y']=$dataY;
        $_SESSION['x']=$dataX;
        header("Location:animation.php");
    }
}else{
    if($_POST['acces_token']!=$acces_token){            //ak je chyba na strane tokenu pri zadavani hodnoty r
        echo '<script type="text/javascript">';
        echo 'alert("Wrong access token");';
        echo 'window.location.href = "octave_form.php";';
        echo '</script>';
    }else{                          //ak je chybny input
        echo '<script type="text/javascript">';
        echo 'alert("Wrong input");';
        echo 'window.location.href = "octave_form.php";';
        echo '</script>';
    }
}
?>
