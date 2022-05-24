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
        let speed = 0.01 // cyklus sa vykonáva každú stotinu
        let submited = 0;
        let nickname;
        let watch;
        let lastCommandExec;

        $(document).ready(function() {
            let lang = "sk";
            changeLanguage();

            const data = {
                datasets: [{
                        borderColor: '#FF8C00',
                        data: [],
                        label: 'Koleso',
                        pointRadius: 0,
                        backgroundColor: '#FF8C00',
                        tension: 0.4,
                    },
                    {
                        borderColor: '#1C90EA',
                        data: [],
                        label: 'Karoséria',
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

            $('.radiobtngroup').change(function (e){
                if(this.id === 'sk_lang'){
                    lang = "sk";
                } else if (this.id === "en_lang"){
                    lang = "en";
                }
                changeLanguage();
            });

            function changeLanguage(){
                $.ajax({
                    url: 'lang/'+lang+'.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(result) {
                        $(".aboutHeader").text(result.about);
                        $(".final_ass").text(result.final_ass);
                        $("#form").text(result['form']);
                        $(".track_experiments").text(result.track_experiments);
                        $("#nick").text(result.nick);
                        $("#funkcionality").text(result.funkcionality);
                        $("#form_CAS").text(result.form_CAS);
                        $("#first_placeholder").text(result.first_placeholder);
                        $("#anim_chart").text(result.anim_chart);
                        $("#second_placeholder").text(result.second_placeholder);
                        $("#send").text(result.send);
                        $("#make_chart").text(result.make_chart);
                        $("#make_animation").text(result.make_animation);
                        $("#footer_desc").text(result.footer_desc);
                        $("#cp").text(result.cp);
                        $("#addButton").text(result['add']);
                        $("#calculate").text(result.calculate);
                        $("#popover_1").text(result.popover_1);
                        $("#popover_2").text(result.popover_2);
                        $(".APIinfo").text(result.APIinfo);
                        $(".loginfo").text(result.loginfo);
                        $("#csvdown").text(result.csvdown);
                        $("#mailSend").text(result.mailSend);
                        $("#popis2").text(result.popis2);
                        $(".runoctave").text(result.runoctave);
                        $(".parameters").text(result['parameters']);
                        $(".command").text(result.command);
                        $(".description").text(result['description']);
                        $(".return").text(result['return']);
                        $(".returnbody").text(result.returnbody);
                        $(".example").text(result.example);
                        $(".response").text(result['response']);
                        $(".succes").text(result.succes);
                        $(".fail").text(result.fail);
                        $(".code").text(result['code']);
                        $(".exampleA").text(result.exampleA);
                        $(".getdata").text(result.getdata);
                        $("#doc").text(result.doc);
                        $(".height").text(result.height);

                    },
                    error: function() {
                        console.log('error');
                    }

                });
            };

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
                    "<p class = 'text-center' id='popover_1'>Výška prekážky musí byť desatinné alebo celé číslo z rosahu -0.35 až 0.35! <p>"
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
                    "<p class = 'text-center' id='popover_2'>Príkaz nie je zadaný v správnom formáte ! <p>"
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
                console.log("som tu");
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
                        console.log("error")
                        console.log(XMLHttpRequest.status);
                    }
                });
            });


            $("#submitPlotButton").click(function(e) {
                e.preventDefault();
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

            function delay(milisec){
                return new Promise(resolve => {
                    setTimeout(resolve, milisec);
                });
            }

            async function execPlot(Y_axis_wheel, Y_axis_car, obstacleHeight, shift){
                let y_time = 0;
                for (let i = 0; i < Y_axis_wheel.length; i++) {
                    if (i < shift) {
                        test(obstacleHeight, y_time, Y_axis_wheel[i], Y_axis_car[i], 0, 0);
                    } else {
                        test(obstacleHeight, y_time, Y_axis_wheel[i], Y_axis_car[i],
                            Y_axis_wheel[i - shift], Y_axis_car[i - shift]);
                    }

                    addData(myChart, y_time, Y_axis_wheel[i], Y_axis_car[i]);
                    y_time = roundToTwo(y_time + 0.01);
                    await delay(speed);
                }
            }

            function callGraph(name, r) {
                if (submited == 1) {
                    saveCommand();
                }
                let ok = false;
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
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#animationForm").offset().top
                    }, 100);
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
                            let shift = 190;
                            let X_axis = result.dataT;
                            let Y_axis_car = result.dataY;
                            let Y_axis_wheel = getCarY(Y_axis_car.length, result.dataX);

                            if ($('#checkBoxPlot').is(':checked') && $('#checkBoxAnimation').is(':checked')) {
                                $("#animationDiv").removeClass("d-none");
                                $("#chartDiv").removeClass("d-none");
                            } else if ($('#checkBoxPlot').is(':checked')) {
                                $("#animationDiv").addClass("d-none");
                                $("#chartDiv").removeClass("d-none");
                            } else if ($('#checkBoxAnimation').is(':checked')) {
                                $("#animationDiv").removeClass("d-none");
                                $("#chartDiv").addClass("d-none");

                            } else {
                                $("#animationDiv").addClass("d-none");
                                $("#chartDiv").addClass("d-none");
                            }
                            execPlot(Y_axis_wheel, Y_axis_car, obstacleHeight, shift);

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
            let fd = new FormData();
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
        <div class="float-start px-5">
            <div class="btn-group" id = "div_lang">
                <input type="radio" class="btn-check radiobtngroup" name="options" id="sk_lang" autocomplete="off" checked/>
                <label class="btn btn-secondary" for="sk_lang">SK</label>

                <input type="radio" class="btn-check radiobtngroup" name="options" id="en_lang" autocomplete="off" />
                <label class="btn btn-secondary" for="en_lang">EN</label>
            </div>
        </div>
        <div class="container">
            <a class="navbar-brand final_ass"></a>
            <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded"
                    type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                    aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-2 px-0 px-lg-3 rounded small aboutHeader" href="#about"></a></li>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-2 px-0 px-lg-3 rounded small" href="#formCasContainer" id="form" ></a></li>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-2 px-0 px-lg-3 rounded small" href="#plotContainer" id="funkcionality"></a></li>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-2 px-0 px-lg-3 rounded small track_experiments" href="#formName"></a></li>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-2 px-0 px-lg-3 rounded small loginfo" href="#logContainer"></a></li>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-2 px-0 px-lg-3 rounded small APIinfo" href="#apiDocContainer"></a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="page-section bg-primary text-white mb-0" id="about">
        <div class="container">
            <h2 class="page-section-heading text-center text-uppercase text-white pt-5 aboutHeader" id="nadpis"></h2>
            <h3 class="page-section-heading text-center text-uppercase pt-5 aboutHeader" id="hide"></h3>
            <div class="divider-custom divider-light">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon">
                    <i class="fa-solid fa-angle-down"></i>
                </div>
                <div class="divider-custom-line"></div>
            </div>
            <div class="row">
                <div class="col-lg-4 ms-auto">
                    <p class="lead">
                        Donec non arcu at turpis consequat fringilla. Cras vitae augue nulla.
                        Phasellus tellus turpis, molestie eget mi sagittis, rutrum faucibus ante. Duis malesuada ipsum dolor,
                        pharetra tristique lectus condimentum eu. Quisque rutrum ornare nibh. Curabitur iaculis cursus dui,
                        sed aliquet odio pharetra ut. Orci varius natoque penatibus et magnis dis parturient montes, nasc
                    </p>
                </div>
                <div class="col-lg-4 me-auto">
                    <p class="lead" id="popis2">
                    </p>
                </div>
            </div>

        </div>
    </section>

    <section class="page-section bg-white text-white mb-0" id="formCasContainer">
        <div class="container">
                <h2 class="page-section-heading text-center text-uppercase text-secondary" id="form_CAS"></h2>
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-7 pt-5">
                    <form id="casForm">
                        <div class="form-floating mb-3" id = "casDiv">
                            <textarea class="form-control" id="requirement" type="text"
                                      placeholder="Sem napíšte príkaz ..." style="height: 6rem"></textarea>
                                <label for="requirement" id="first_placeholder"></label>
                        </div>s
                        <button class="btn btn-primary btn-lg" id="submitCasFormButton" type="button"><span id ="calculate"></span></button>
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
            <h2 class="page-section-heading text-center text-uppercase text-secondary" id="anim_chart"></h2>
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-7 pt-5">
                    <form id="animationForm" class="text-sm">
                        <div class="form-floating mb-3">

                            <input class="form-control" id="obstacleHeight"
                                   type="text"
                                      placeholder="Sem napíšte výšku prekážky ..."/>
                            <label for="obstacleHeight" id="second_placeholder"></label>

                            <div class="d-flex flex-row justify-content-start align-items-center pt-4">
                                <div class="form-check me-5 ">
                                    <input class="form-check-input" type="checkbox" value="" id="checkBoxPlot" checked>
                                    <label class="form-check-label" for="checkBoxPlot" id="checkBoxLabel1">
                                        <small id="make_chart"></small>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="checkBoxAnimation" checked>
                                    <label class="form-check-label" for="checkBoxAnimation" id="checkBoxLabel1">
                                        <small id="make_animation"></small>
                                    </label>
                                </div>

                            </div>
                        </div>

                        <button class="btn btn-primary btn-lg" id="submitPlotButton"><span id="send"></span></button>
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

    <section class="page-section bg-white text-white mb-0" id="formName">
        <div class="container">
            <h2 class="page-section-heading text-center text-uppercase text-secondary track_experiments"></h2>
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-7 pt-5">
                    <form id="nicknameForm">
                        <div class="form-floating mb-3" id="nicknameDiv">
                            <textarea class="form-control" id="nickname" type="text" placeholder="Sem napíšte nickname ..." style="height: 6rem"></textarea>
                            <label for="requirement" id="nick"></label>
                        </div>

                        <button class="btn btn-primary btn-lg" id="submitNickameButton" type="button"><span id="addButton"></span></button>
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
            <h2 class="page-section-heading text-center text-uppercase text-secondary loginfo"></h2>
            <div class="d-flex flex-row justify-content-center pt-5">
                <div class="flex-column justify-content-between">

                    <button class="btn btn-primary btn-lg" id="downloadCsv" type="button"
                            onclick="location.href='api/export.php';"><span id="csvdown"></span>
                    </button>


                    <button class="btn btn-primary btn-lg" id="sendToMail" type="button"
                            onclick="location.href='api/email.php';"><span id="mailSend"></span>
                    </button>

                </div>
            </div>
        </div>
    </section>

    <section class="page-section bg-white  mb-0 m-5" id="apiDocContainer">
        <div class="container">
            <h2 class="page-section-heading text-center text-uppercase text-secondary APIinfo"></h2>
            <div class="d-flex flex-row justify-content-center pt-5">
                <div class="d-flex flex-column justify-content-center">
                    <div class="p-2">
                        <button type="button" class="btn btn-primary " data-bs-toggle="collapse" data-bs-target="#myCollapse">
                            <span class="runoctave"></span>
                        </button>

                        <div class="collapse hide" id="myCollapse">
                            <h3 id="hide" class="runoctave "></h3>
                            <div class="card card-body">
                                <div class="p-2">
                                    <h4 class="parameters"></h4>
                                    <div class="command"></div>
                                    <div>acces_token={token}</div>
                                </div>

                                <div class="p-2">
                                    <h4 class="description"></h4>
                                    <div class="runoctave"></div>
                                    <div class="return"></div>
                                    <span class="returnbody"></span><span>: {"ans":"string"}</span>
                                </div>

                                <div class="p-2">
                                    <h4 class="example"></h4>
                                    <div>/api/?prikaz=1+1&acces_token=kiRkR15MBEypq7Che</div>
                                </div>

                                <div class="p-2">
                                    <h4 class="response"></h4>
                                    <h6 class="succes"></h6>
                                        <span class="code"></span><span>: 200</span>
                                        <span class="exampleA"></span><span>: {"ans":"\"ans = 2\""}</span>
                                    <h6 class="fail"></h6>
                                        <span class="code"></span><span>: 404</span>
                                        <span class="exampleA"></span><span>: "err": {"\"Wrong access token!\""}</span>
                                </div>

                            </div>
                        </div>

                    </div>

                   <div class="p-2">
                       <button type="button" class="btn btn-primary " data-bs-toggle="collapse" data-bs-target="#myCollapse2">
                           <span class="getdata"></span>
                       </button>

                       <div class="collapse hide" id="myCollapse2">
                           <h3 id="hide" class="getdata"></h3>

                           <div class="card card-body">
                               <div class="p-2">
                                   <h4 class="parameters"></h4>
                                   <span>r={</span><span class="height"></span><span>}</span>
                                   <div>acces_token={token}</div>
                               </div>
                               <div class="p-2">
                                   <h4 class="description"></h4>
                                   <div class="getdata"></div>
                                   <div class="return"></div>
                                   <span class="returnbody"></span><span>: {"dataT":[],"dataX":[],"dataY":[]}</span>
                               </div>
                               <div class="p-2">
                                   <h4 class="example"></h4>
                                   <div>/api/?r=5.0&acces_token=kiRkR15MBEypq7Che</div>
                               </div>

                               <div class="p-2">
                                   <h4 class="response"></h4>
                                   <h6 class="succes"></h6>
                                   <span class="code"></span><span>: 200</span> <div></div>
                                   <span class="exampleA"></span><span>: {"dataT":[],"dataX":[],"dataY":[]}</span>
                                   <h6 class="fail"></h6>
                                   <span class="code"></span><span>: 404</span>
                                   <div></div>
                                   <span class="exampleA"></span><span>: "err": {"\"Wrong access token!\""}</span>
                               </div>
                           </div>
                       </div>
                   </div>

                    <div class="p-2">
                        <button class="btn btn-primary btn-lg" id="print" type="button"
                                onclick="window.print()"><span id="doc"></span>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <footer class="footer text-center">
        <div class="container">
            <p class="text-white" id="footer_desc"></p>
        </div>
    </footer>

    <div class="copyright py-4 text-center text-white">
        <div class="container"><small id="cp"></small></div>
    </div>
</body>

</html>