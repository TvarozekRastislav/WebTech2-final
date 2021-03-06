<?php
$lang=array(
    "about"=>"About project",
    "final_ass"=>"FINAL ASSIGNMENT",
    "track_experiments"=>"WATCH EXPERIMENTS",
    "nick"=>"Enter your nickname",
    "form"=>"Form for CAS",
    "funkcionality"=>"Animation and chart",
    "form_CAS"=>"FORM FOR CAS",
    "first_placeholder"=>"Enter command",
    "calculate"=>"Calculate",
    "anim_chart"=>"ANIMATION AND CHART",
    "second_placeholder"=>"Enter obstacle height in m",
    "send"=>"Send",
    "make_chart"=>"Render chart",
    "make_animation"=>"Render animation",
    "footer_desc"=>"This project was created as a result of the final assignment of the subject of web technology.",
    "cp"=>"Copyright © Final exam Webte2 2022",
    "add"=>"Add",
    "popover_1"=>"Height of the obstacle must be integer or float within values -0.35-0.35 !",
    "popover_2"=>"The command is not in the correct format!",
    "description"=>"Description",
    "parameters"=>"Parameters",
    "getdata"=>"GET /final/api Get data T,X,Y for animation",
    "runoctave"=>"GET /final/api Run octave command",
    "command"=>"command={command}",
    "returnbody"=>"Return body",
    "return"=>"Returns",
    "example"=>"Example",
    "response"=>"Response",
    "succes"=>"Successful response",
    "fail"=>"Unsuccessful response",
    "code"=>"Code",
    "exampleA"=>"Example",
    "doc"=>"Download API documentation",
    "height"=>"height",
    "APIinfo"=>"API information",
    "loginfo"=>"Log information",
    "csvdown"=>"Download CSV file",
    "mailSend"=>"Send mail with information",
    "h_popis2"=>"Watching experiments",
    "popis2"=>"If you want to watch other users experiments you need to enter your name. You can enter your name on the bottom of the page. Also, if you want other users to be able to watch your experiments, you'll need to enter a name.  To end wathcing another user is required refresh page.",
    "h_documentation"=>"Technical documentation",
    "documentation"=>"Docker-image base: https://github.com/nanoninja/php-fpm \n
        Docker-containers:\\n
        - php 8.1 s octave gnu\\n
        - nginx alpine\\n
        - mysql 8.0.21\\n
        - phpmyadmin\\n
        - composer: phpmailer\\n
        Animation: p5.js\\n
        Plot: chart.js\\n
        Design: Bootstrap v5 \\n",
    "mhajek"=>"- API for CAS with API token \\n - bilingualism  \\n - application finalization \\n - github",
    "rtvarozek"=>"- docker \\n - synchronous experiment watching \\n - application finalization \\n - github",
    "mmahelyova"=>"- animation and plot \\n - authentication via API form \\n - design \\n - application finalization \\n - github",
    "lhrnciarikova"=>"- logging a export to csv \\n - email sending \\n - export of API description to pdf \\n - application finalization \\n - github",
);
echo json_encode($lang);