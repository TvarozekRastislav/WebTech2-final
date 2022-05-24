<?php
$lang=array(
    "about"=>"O projekte",
    "final_ass"=>"FINALNÉ ZADANIE",
    "form"=>"Formulár na CAS",
    "track_experiments"=>"SLEDOVANIE EXPERIMENTOV",
    "nick"=>"Zadajte svoj nickname",
    "funkcionality"=>"Animácia a graf",
    "form_CAS"=>"FORMULÁR NA CAS",
    "first_placeholder"=>"Zadajte príkaz",
    "calculate"=>"Vypočítaj",
    "anim_chart"=>"ANIMÁCIA A GRAF",
    "second_placeholder"=>"Zadajte výšku prekážky v m",
    "send"=>"Odoslať",
    "make_chart"=>"Vykreslenie grafu",
    "make_animation"=>"Vykreslenie animácie",
    "footer_desc"=>"Tento projekt vznikol ako výsledny produkt finálneho zadania z predmetu webové technológie.",
    "cp"=>"Copyright © Finálne zadanie Webte2 2022",
    "add"=>"Pridaj",
    "popover_1"=>"Výška prekážky musí byť desatinné alebo celé číslo z rosahu -0.35 až 0.35!",
    "popover_2"=>"Príkaz nie je zadaný v správnom formáte !",
    "description"=>"Popis",
    "parameters"=>"Parametre",
    "getdata"=>"GET /final/api Dostane dáta T,X,Y pre animáciu",
    "runoctave"=>"GET /final/api Spustí príkaz octave",
    "command"=>"prikaz={príkaz}",
    "returnbody"=>"Štruktúra, ktorú vracia",
    "return"=>"Vracia: JSON",
    "example"=>"Príklad použitia",
    "response"=>"Odpoveď",
    "succes"=>"Úspešná odpoveď",
    "fail"=>"Neúspešná odpoveď",
    "code"=>"Kód",
    "exampleA"=>"Príklad odpovede",
    "doc"=>"Stiahni API dokumentáciu",
    "height"=>"výška",
    "APIinfo"=>"Informácie o API",
    "loginfo"=>"Informácie o logoch",
    "csvdown"=>"Stiahni csv súbor",
    "mailSend"=>"Odošli informácie na mail",
    "h_popis2"=>"Sledovanie experimentov",
    "popis2"=>"Pre zobrazenie ostaných používateľov ktorý práve vykonávajú experminety je potrebné zadať svoje meno.
    Taktiež pokiaľ si želáš, aby ostantní používatelia mohli sledovať tvoje experimenty je potrebné zadať meno.
    Pre ukončenie sledovania experminetu druhej osoby je potrebné refreshnúť stránku.",
    "h_documentation"=>"Technická dokumentácia",
    "documentation"=>"Docker-image base: https://github.com/nanoninja/php-fpm \\n
        Docker-containers:\\n
        - php 8.1 s octave gnu\\n
        - nginx alpine\\n
        - mysql 8.0.21\\n
        - phpmyadmin\\n
        - composer: phpmailer\\n
        Vykreslenie animácie: p5.js\\n
        Vizualizácia grafu: chart.js\\n
        Dizajn: Bootstrap v5 \\n",
    "mhajek"=>"- API ku CAS zabezpečené API  tokenom \\n - dvojjazyčnosť \\n - finalizácia aplikácie \\n - používanie githubu",
    "rtvarozek"=>"- docker balíček \\n - synchrónne sledovanie experimentovania \\n - finalizácia aplikácie \\n - používanie githubu",
    "mmahelyova"=>"- animácia a graf \\n - overenie cez API formulár \\n - dizajn \\n - finalizácia aplikácie \\n - používanie githubu",
    "lhrnciarikova"=>"- logovanie a export do csv \\n - odoslanie mailu \\n - export popisu API do pdf \\n - finalizácia aplikácie \\n - používanie githubu",
);
echo json_encode($lang);