<?php include "../config.php" ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Zadanie final</title>
    <meta name="description" content="Final">
    <meta name="author" content="">

    <link href="css/styles.css" rel="stylesheet" media="all"/>
    <link href="css/apiDoc.css" rel="stylesheet" media="screen"/>
    <link href="css/printable.css" rel="stylesheet" media="print"/>
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <script src="js/script.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="js/chart.js"></script>
    <script src="js/p5.js"></script>
    <script src="js/animation.js"></script>

    <style>
        .popover-danger {
            background-color: #d9534f;
            border-color: #d43f3a;
        }

        .popover-danger p {
            color: white;
        }

        .popover-danger .popover-arrow:after {
            border-bottom-color: #d9534f;
        }
    </style>


    <script>
        let timeoutFunc;
        let y_time = 0;
        let submited = 0;
        let nickname;
        let watch;
        let lastCommandExec;

        $(document).ready(function() {
            const data = {
                datasets: [{
                        borderColor: '#FF8C00',
                        data: [],
                        label: 'Wheel',
                        pointRadius: 0,
                        backgroundColor: '#FF8C00',
                        tension: 0.4,
                    },
                    {
                        borderColor: '#1C90EA',
                        data: [],
                        label: 'Car',
                        pointRadius: 0,
                        backgroundColor: '#1C90EA',
                        tension: 0.4,
                    }
                ]
            };

            const config = {
                type: 'line',
                data: data,
                options: {
                    spanGaps: true,
                    animation: false,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: "s",
                                align: "end",

                            },
                            min: 0,
                        },
                        y: {
                            title: {
                                display: true,
                                text: "m",
                                align: "end",
                            },

                            ticks: {
                                beginAtZero: true
                            }
                        }
                    }
                }
            };

            const myChart = new Chart($("#myChart"), config);

            function clearChart() {
                myChart.clear();
            }

            function roundToTwo(num) {
                return +(Math.round(num + "e+2") + "e-2");
            }

            function addData(chart, label, data1, data2) {
                chart.data.labels.push(label);
                chart.data.datasets[0].data.push(data1);
                chart.data.datasets[1].data.push(data2);
                chart.update();
            }

            function removeData(chart) {
                chart.data.labels = [];
                chart.data.datasets[0].data = [];
                chart.data.datasets[1].data = [];
                chart.update();
            }

            function getCarY(len, dataX) {
                let result = []
                for (let i = 0; i < len; i++) {
                    result.push(dataX[i][0]);
                }
                return result;
            }

            function refreshNames() {
                $.ajax({
                    url: 'php/synchornious/refreshNames.php?name=' + nickaname,
                    type: 'GET',
                    data: {
                        name: nickaname
                    },
                    dataType: 'text',
                    success: function(result) {
                        $("#outputFormNickname").empty();
                        output = JSON.parse(result);
                        output.forEach(element => {
                            $("#outputFormNickname").append("<button class='box1'>" + element['name'] + "</button>");
                        });
                        const boxes = document.querySelectorAll('.box1');
                        boxes.forEach(box => {
                            box.addEventListener('click', function handleClick(event) {
                                setInterval(() => {
                                    watchExp(box.innerText);
                                }, 3000);
                            });
                        });
                    },
                    error: function() {
                        console.log('error');
                    }

                });
            }

            function watchExp(name) {
                let r;

                $.ajax({
                    url: 'php/synchornious/getR.php?name=' + name,
                    type: 'GET',
                    data: {
                        name: name
                    },
                    dataType: 'text',
                    success: function(result) {
                        //MATKA SEM TREBA UPRAVIT TO ODSTANOVANIE
                        $("#submitPlotButton").remove();
                        $("#removeForSync").addClass("d-none");

                        $("#checkBoxAnimation").addClass("d-none");
                        $("#checkBoxPlot").addClass("d-none");
                        $("#checkBoxLabel").addClass("d-none");
                        $("#checkBoxLabel1").addClass("d-none");
                        $("#animationDiv").removeClass("d-none");
                        $("#chartDiv").removeClass("d-none");
                        $('#checkBoxPlot').prop('checked', true);
                        $('#checkBoxAnimation').prop('checked', true);

                        output = JSON.parse(result);
                        if (lastCommandExec == output[2]|| output[1] == null) {
                            return;
                        }
                        lastCommandExec = output[2];
                        callGraph(null, output[1]);
                    },
                    error: function() {
                        console.log('error');
                    }
                });

            }

            $("#outputForm").hide();

            $("#obstacleHeight").popover({
                placement: 'bottom',
                animation: true,
                delay: {
                    "show": 300,
                    "hide": 100
                },
                html: true,
                trigger: 'manual',
                content: "<button class='close'>&times</button> " +
                    "<p class = 'text-center'>Výška prekážky musí byť desatinné alebo celé číslo z rosahu -0.35 až 0.35! <p>"
            });

            $("#casDiv").popover({
                placement: 'bottom',
                animation: true,
                delay: {
                    "show": 300,
                    "hide": 100
                },
                html: true,
                trigger: 'manual',
                content: "<button class='close'>&times</button> " +
                    "<p class = 'text-center'>Príkaz nie je zadaný v správnom formáte ! <p>"
            });

            $('#obstacleHeight').bind('input propertychange focusin', function() {
                let req = $("#obstacleHeight").val();
                if (req === "") {
                    $('#obstacleHeight').popover('hide');
                    $("#obstacleHeight").removeClass("border-danger");
                    $("#obstacleHeight").removeClass("text-danger");
                }
            });

            $('#requirement').bind('input propertychange focusin', function() {
                let req = $("#requirement").val();
                if (req === "") {
                    $('#casDiv').popover('hide');
                    $("#requirement").removeClass("border-danger");
                    $("#requirement").removeClass("text-danger");
                }
            });

            $("#submitCasFormButton").click(function() {
                let req = $("#requirement").val();
                $.ajax({
                    type: 'GET',
                    data: {
                        acces_token: "kiRkR15MBEypq7Che",
                        prikaz: req
                    },
                    url: "../api/api.php",
                    dataType: "json",
                    success: function(result) {
                        let output = null;
                        let ok = false;
                        if (result.err !== undefined) {
                            output = (result.err).replace("err = ", "").replaceAll("\"", "");
                            ok = false;
                        } else {
                            output = (result.ans).replace("ans = ", "").replaceAll("\"", "");
                            ok = true;
                        }
                        if ((ok && output === "") || !ok) {
                            $("#outputForm").hide();
                            $("#requirement").addClass("border-danger");
                            $("#requirement").addClass("text-danger");
                            $('#casDiv').popover('show');
                            $('.popover').addClass('popover-danger');
                        } else if (ok) {
                            $("#outputForm").show();
                            $('#casDiv').popover('hide');
                            $("#requirement").removeClass("border-danger");
                            $("#requirement").removeClass("text-danger");
                            $("#outputForm").html(output);
                        }


                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log(XMLHttpRequest.status);
                    }
                });
            });


            $("#submitPlotButton").click(function() {
                callGraph(null);

            });

            $("#submitNickameButton").click(function() {

                nickaname = $("#nickname").val();
                $.ajax({
                    url: 'php/synchornious/NickNameLoad.php?name=' + nickaname,
                    type: 'GET',
                    data: {
                        name: nickaname
                    },
                    dataType: 'text',
                    success: function(result) {
                        submited = 1;
                        if (result == "alredyExists") {

                        } else {
                            output = JSON.parse(result);
                            $("#outputFormNickname").show();
                            output.forEach(element => {
                                $("#outputFormNickname").append("<button class='box1'>" + element['name'] + "</button>");
                            });
                            const boxes = document.querySelectorAll('.box1');
                            boxes.forEach(box => {
                                box.addEventListener('click', function handleClick(event) {
                                    setInterval(() => {
                                        watchExp(box.innerText);
                                    }, 3000);
                                });
                            });
                            setInterval(() => {
                                refreshNames();
                            }, 5000);
                            $("#submitNickameButton").addClass("d-none");
                            $("#nicknameDiv").addClass("d-none");

                        }
                    },
                    error: function() {
                        console.log('error');
                    }

                });
            });

            function callGraph(name, r) {
                if (submited == 1) {
                    saveCommand();
                }
                let ok = false;
                let shift = 190;
                let obstacleHeight = $("#obstacleHeight").val();
                if (r != null) {
                    obstacleHeight = r;
                }
                obstacleHeight = obstacleHeight.replace(",", ".");
                let float = /^\s*(\+|-)?((\d+(\.\d+)?)|(\.\d+))\s*$/;
                if (float.test(obstacleHeight) && parseFloat(obstacleHeight) <= 0.35 && parseFloat(obstacleHeight) >= -0.35) {
                    ok = true;
                    $('#casDiv').popover('hide');
                } else {
                    ok = false;
                    $("#obstacleHeight").addClass("border-danger");
                    $("#obstacleHeight").addClass("text-danger");
                    $('#obstacleHeight').popover('show');
                    $('.popover').addClass('popover-danger');
                }

                if (ok) {
                    $.ajax({
                        type: 'GET',
                        data: {
                            acces_token: "kiRkR15MBEypq7Che",
                            r: obstacleHeight
                        },
                        url: "../api/api.php",
                        dataType: "json",
                        success: function(result) {
                            removeData(myChart);
                            clearCanvas();
                            let X_axis = result.dataT;
                            let Y_axis_car = result.dataY;
                            let Y_axis_wheel = getCarY(Y_axis_car.length, result.dataX);

                            if ($('#checkBoxPlot').is(':checked') && $('#checkBoxAnimation').is(':checked')) {
                                $("#animationDiv").removeClass("d-none");
                                $("#chartDiv").removeClass("d-none");
                                for (let i = 0; i < Y_axis_wheel.length; i++) {
                                    (function(index) {
                                        timeoutFunc = setTimeout(function() {
                                            if (i < shift) {
                                                test(obstacleHeight, y_time, Y_axis_wheel[i], Y_axis_car[i], 0, 0);
                                            } else {
                                                test(obstacleHeight, y_time, Y_axis_wheel[i], Y_axis_car[i],
                                                    Y_axis_wheel[i - shift], Y_axis_car[i - shift]);
                                            }

                                            addData(myChart, y_time, Y_axis_wheel[i], Y_axis_car[i]);
                                            y_time = roundToTwo(y_time + 0.01);
                                        }, X_axis[i] / 10);
                                        // }, X_axis[i]*10000);
                                    })(i);
                                }
                            } else if ($('#checkBoxPlot').is(':checked')) {
                                $("#animationDiv").addClass("d-none");
                                $("#chartDiv").removeClass("d-none");

                                for (let i = 0; i < Y_axis_wheel.length; i++) {
                                    (function(index) {
                                        timeoutFunc = setTimeout(function() {
                                            addData(myChart, y_time, Y_axis_wheel[i], Y_axis_car[i]);
                                            y_time = roundToTwo(y_time + 0.01);
                                        }, X_axis[i] / 10);
                                        // }, X_axis[i]*10000);
                                    })(i);
                                }
                            } else if ($('#checkBoxAnimation').is(':checked')) {
                                $("#animationDiv").removeClass("d-none");
                                $("#chartDiv").addClass("d-none");

                                for (let i = 0; i < Y_axis_wheel.length; i++) {
                                    (function(index) {
                                        timeoutFunc = setTimeout(function() {
                                            if (i < shift) {
                                                test(obstacleHeight, y_time, Y_axis_wheel[i], Y_axis_car[i], 0, 0);
                                            } else {
                                                test(obstacleHeight, y_time, Y_axis_wheel[i], Y_axis_car[i],
                                                    Y_axis_wheel[i - shift], Y_axis_car[i - shift]);
                                            }
                                            addData(myChart, y_time, Y_axis_wheel[i], Y_axis_car[i]);
                                            y_time = roundToTwo(y_time + 0.01);
                                        }, X_axis[i] / 10);
                                        // }, X_axis[i]*10000);
                                    })(i);
                                }
                            } else {
                                $("#animationDiv").addClass("d-none");
                                $("#chartDiv").addClass("d-none");
                            }
                            y_time = 0;

                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            console.log(XMLHttpRequest.status);
                        }
                    });
                }
            }

            function saveCommand() {
                $.ajax({
                    url: 'php/synchornious/commandSave.php?name=' + nickname + "&obstacleHeight=" + $("#obstacleHeight").val(),
                    type: 'GET',
                    data: {
                        name: nickaname,
                        obstacleHeight: $("#obstacleHeight").val()
                    },
                    dataType: 'text',
                    success: function(result) {
                        console.log(result);
                    },
                    error: function() {
                        console.log('error');
                    }

                });
            }
        });


        window.addEventListener("beforeunload", function(e) {
            var fd = new FormData();
            fd.append('ajax_data', nickaname);
            let data = {
                nickname: nickaname
            }
            console.log(data);
            navigator.sendBeacon('php/synchornious/NickNameUnload.php', fd);
        });
    </script>
</head>

<body id="page-top">
    <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand"><?php echo $lang['final_ass'] ?></a>
            <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded"
                    type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                    aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>
            <form method="get">
                <select id="lang" name="lang">
                    <option value="sk">Slovak</option>
                    <option value="en">English</option>
                </select>
                <button type="submit"></button>
            </form>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-2 px-0 px-lg-3 rounded" href="#about"><?php echo $lang['about'] ?>  </a></li>
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-2 px-0 px-lg-3 rounded" href="#formCasContainer"><?php echo $lang['form'] ?></a></li>
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-2 px-0 px-lg-3 rounded" href="#plotContainer"><?php echo $lang['funkcionality'] ?></a></li>
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-2 px-0 px-lg-3 rounded" href="#formName"><?php echo $lang['track_experiments'] ?></a></li>
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-2 px-0 px-lg-3 rounded" href="#logContainer">Informácie
                            o logoch</a></li>
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-2 px-0 px-lg-3 rounded" href="#apiDocContainer">Informácie
                            o API</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="page-section bg-primary text-white mb-0" id="about">
        <div class="container">
            <h2 class="page-section-heading text-center text-uppercase text-white pt-5" id="nadpis"><?php echo $lang['about'] ?></h2>
            <h3 class="page-section-heading text-center text-uppercase  pt-5"id="hide"><?php echo $lang['about'] ?></h3>
            <div class="divider-custom divider-light">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon">
                    <i class="fa-solid fa-angle-down"></i>
                </div>
                <div class="divider-custom-line"></div>
            </div>
            <div class="row">
                <div class="col-lg-4 ms-auto">
                    <p class="lead">?>
                        Donec non arcu at turpis consequat fringilla. Cras vitae augue nulla.
                        Phasellus tellus turpis, molestie eget mi sagittis, rutrum faucibus ante. Duis malesuada ipsum dolor,
                        pharetra tristique lectus condimentum eu. Quisque rutrum ornare nibh. Curabitur iaculis cursus dui,
                        sed aliquet odio pharetra ut. Orci varius natoque penatibus et magnis dis parturient montes, nasc
                    </p>
                </div>
                <div class="col-lg-4 me-auto">
                    <p class="lead">Pre zobrazenie ostaných používateľov ktorý práve vykonávajú experminety je potrebné zadať svoje meno.
                        Taktiež pokiaľ si želáš aby ostaný používatelia mohli sledovať tvoje experimenty je potrebné zadať meno.
                        Pre ukončenie sledovania experminetu druhej osoby je potrebné refreshnúť stránku.
                    </p>
                </div>
            </div>

        </div>
    </section>

    <section class="page-section bg-white text-white mb-0" id="formCasContainer">
        <div class="container">
            <h2 class="page-section-heading text-center text-uppercase text-secondary"><?php echo $lang['form_CAS']?></h2>
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-7 pt-5">
                    <form id="casForm">
                        <div class="form-floating mb-3" id = "casDiv">
                            <textarea class="form-control" id="requirement" type="text"
                                      placeholder="Sem napíšte príkaz ..." style="height: 6rem"></textarea>
                            <label for="requirement"><?php echo $lang['first_placeholder']?></label>
                        </div>
                        <button class="btn btn-primary btn-lg" id="submitCasFormButton" type="button"><?php echo $lang['calculate']?></button>
                    </form>
                </div>
                <div class="col-lg-8 col-xl-7 pt-5 lead" id="outputFormContainer">
                    <div class="border-bottom border-grey border-1 rounded-1 text-black p-3" id="outputForm">
                    </div>
                </div>
            </div>
        </div>
    </section>



    <section class="page-section bg-white text-white mb-0 m-5" id="plotContainer" >
        <div class = "container">
            <h2 class="page-section-heading text-center text-uppercase text-secondary"><?php echo $lang['anim_chart']?></h2>
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-7 pt-5">
                    <form id="animationForm" class="text-sm">
                        <div class="form-floating mb-3">

                            <input class="form-control" id="obstacleHeight"
                                   type="text"
                                      placeholder="Sem napíšte výšku prekážky ..."/>
                            <label for="obstacleHeight"><?php echo $lang['second_placeholder']?></label>

                            <div class="d-flex flex-row justify-content-start align-items-center pt-4">
                                <div class="form-check me-5 ">
                                    <input class="form-check-input" type="checkbox" value="" id="checkBoxPlot">
                                    <label class="form-check-label" for="checkBoxPlot" id="checkBoxLabel1">
                                        <small><?php echo $lang['make_chart']?></small>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="checkBoxAnimation">
                                    <label class="form-check-label" for="checkBoxAnimation" id="checkBoxLabel1">
                                        <small><?php echo $lang['make_animation']?></small>
                                    </label>
                                </div>

                            </div>
                        </div>

                        <button class="btn btn-primary btn-lg" id="submitPlotButton" type="button"><?php echo $lang['send'] ?></button>
                    </form>

                    <div class="mt-5 row justify-content-center">
                        <div class="d-none" id="chartDiv">
                            <canvas id="myChart"></canvas>
                        </div>

                        <div class="d-none" id="animationDiv">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="page-section bg-white text-white mb-0" id="formCasContainer">
        <div class="container">
            <h2 class="page-section-heading text-center text-uppercase text-secondary"><?php echo $lang['track_experiments'] ?></h2>
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-7 pt-5">
                    <form id="nicknameForm">
                        <div class="form-floating mb-3" id="nicknameDiv">
                            <textarea class="form-control" id="nickname" type="text" placeholder="Sem napíšte nickname ..." style="height: 6rem"></textarea>
                            <label for="requirement"><?php echo $lang['nick'] ?></label>
                        </div>

                        <button class="btn btn-primary btn-lg" id="submitNickameButton" type="button"><?php echo $lang['add'] ?></button>
                    </form>
                </div>
                <div class="col-lg-8 col-xl-7 pt-5 lead" id="outputFormContainerNickname">
                    <div class="border-bottom border-grey border-1 rounded-1 text-black p-3" id="outputFormNickname">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="page-section bg-white text-white mb-0 m-5" id="logContainer">
        <div class="container">
            <h2 class="page-section-heading text-center text-uppercase text-secondary">Informácie o logoch</h2>
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-7 pt-5">

                    <button class="btn btn-primary btn-lg" id="downloadCsv" type="button"
                            onclick="location.href='api/export.php';">Stiahni CSV súbor
                    </button>
                    <br><br>
                    <button class="btn btn-primary btn-lg" id="sendToMail" type="button"
                            onclick="location.href='api/email.php';">Odošli na mail
                    </button>

                </div>
            </div>
        </div>
    </section>

    <section class="page-section bg-white  mb-0 m-5" id="apiDocContainer">
        <div class="container">
            <h2 class="page-section-heading text-center text-uppercase text-secondary">Informácie o API</h2>
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-7 pt-5">

                    <button type="button" class="btn btn-primary " data-bs-toggle="collapse" data-bs-target="#myCollapse">
                        GET /final/api spustí príkaz octave
                    </button>

                    <br><br>

                    <div class="collapse hide" id="myCollapse">
                        <h3 id="hide">GET /final/api spustí príkaz octave</h3>
                        <div class="card card-body"><h4>Parametre</h4>prikaz={command}<br>acces_token={token}<br>
                            <h4>Popis</h4>Spustí príkaz octave<br>vracia : JSON<br>
                            štruktúra, ktorú vracia : {"ans":"string"}
                            <h4>Príklad použitia</h4>/api/?prikaz=1+1&acces_token=kiRkR15MBEypq7Che
                            <h4>Odpoveď</h4><h6>Úspešná odpoveď</h6>Kód : 200<br> Príklad odpovede : {"ans":"\"ans = 2\""}
                            <h6>Neúspešná odpoveď</h6>Kód : 404<br> Príklad odpovede : "err": {"\"Wrong access token!\""}
                        </div>
                    </div>

                    <button type="button" class="btn btn-primary " data-bs-toggle="collapse" data-bs-target="#myCollapse2">
                        GET /final/api dostane dáta pre animáciu
                    </button>
                    <br> <br>



                    <div class="collapse hide" id="myCollapse2">
                        <h3 id="hide">GET /final/api dostane dáta pre animáciu</h3>
                        <div class="card card-body"><h4>Parametre</h4>r={height}<br>acces_token={token}<br>
                            <h4>Popis</h4>Dostane dáta T,X,Y pre animáciu<br>vracia : JSON<br>
                            štruktúra, ktorú vracia : {"dataT":[],"dataX":[],"dataY":[]}
                            <h4>Príklad použitia</h4>/api/?r=5.0&acces_token=kiRkR15MBEypq7Che
                            <h4>Odpoveď</h4><h6>Úspešná odpoveď</h6>Kód : 200<br> Príklad odpovede :
                            {"dataT":[],"dataX":[],"dataY":[]}
                            <h6>Neúspešná odpoveď</h6>Kód : 404<br> Príklad odpovede : "err": {"\"Wrong access token!\""}
                        </div>
                    </div>

                    <button class="btn btn-primary btn-lg" id="print" type="button"
                            onclick="window.print()">Stiahni API dokumentáciu
                    </button>


                </div>
            </div>
        </div>
    </section>


    <footer class="footer text-center">
        <div class="container">
            <p class="text-white"><?php echo $lang['footer_desc']?></p>
        </div>
    </footer>

    <div class="copyright py-4 text-center text-white">
        <div class="container"><small><?php echo $lang['cp']?></small></div>
    </div>
</body>

</html>