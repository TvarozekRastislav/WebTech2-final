<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//$cmd = "octave --eval script.txt";
//$Vdata = file_get_contents("script.txt");
//var_dump($Vdata);
//$cmd='/usr/bin/octave --eval "1+5"';
$o="";
$o=exec('octave-cli --eval "pkg load control;m1 =2500;m2 = 320;k1 = 80000; k2 = 500000;b1 = 350; b2 =15020; save Octave/output_Y.txt b1"');
//exec('/usr/bin/octave /var/www/site68.webte.fei.stuba.sk/WebTech2-final/Octave/script.txt');
//$cmd = "/usr/bin/octave /var/www/site68.webte.fei.stuba.sk/WebTech2-final/Octave/script.txt > /var/www/site68.webte.fei.stuba.sk/WebTech2-final/Octave/output_Y.txt";
//$cmd="octave-cli --eval  '1+1'";
//echo $cmd;
//exec($cmd);
var_dump($o);


