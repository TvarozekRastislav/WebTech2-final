<?php
//$conn = null;
//try {
//    $conn = new PDO("mysql:host=" .  "mysql" . ";dbname=" . "final", "user", "user");
//    $conn->exec("set names utf8");
//    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//} catch (PDOException $exception) {
//    echo "Database could not be connected: " . $exception->getMessage();
//}
//if ($conn) {
//    echo "connected";
//}
//echo "<br>";
//echo (exec("pwd"));
//
//?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Zadanie final</title>
    <meta name="description" content="Final">
    <meta name="author" content="">

    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <script src="js/script.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#submitCasFormButton").click(function(){
                console.log("wiiii");
                let req = $("#requirement").val();
                console.log(req);
                $.ajax({
                    type: 'GET',
                    data: {acces_token: "kiRkR15MBEypq7Che", prikaz: req},
                    url: "../api/api.php",
                    dataType: "json",
                    success: function(result) {
                        console.log(result);
                        let output;
                        if(result.err != undefined){
                            output = (result.err).replace("err = ", "").replaceAll("\"", "");
                            console.log(output);
                        } else{
                            output = (result.ans).replace("ans = ", "").replaceAll("\"", "");
                            console.log(output);
                        }
                        $("#outputForm").html(output);

                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log(XMLHttpRequest.status);
                    }
                });
            })

            $("#submitPlotButton").click(function(){
                console.log("wiiii2");
                let obstacleHeight = $("#obstacleHeight").val();
                console.log(obstacleHeight);
                $.ajax({
                    type: 'GET',
                    data: {acces_token: "kiRkR15MBEypq7Che", r: obstacleHeight},
                    url: "../api/api.php",
                    dataType: "json",
                    success: function(result) {
                        console.log(result);

                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log(XMLHttpRequest.status);
                    }
                });
            })
        })
    </script>
</head>

<body id="page-top">
    <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand">Finálne zadanie</a>
            <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded"
                    type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                    aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-2 px-0 px-lg-3 rounded" href="#about">O projekte</a></li>
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-2 px-0 px-lg-3 rounded" href="#formCasContainer">Formulár na CAS</a></li>
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-2 px-0 px-lg-3 rounded" href="#plotContainer">Animácia a graf</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="page-section bg-primary text-white mb-0" id="about">
        <div class="container">
            <h2 class="page-section-heading text-center text-uppercase text-white pt-5">O projekte</h2>
            <div class="divider-custom divider-light">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon">
                    <i class="fa-solid fa-angle-down"></i>
                </div>
                <div class="divider-custom-line"></div>
            </div>
            <div class="row">
                <div class="col-lg-4 ms-auto">
                    <p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla sodales, elit at maximus
                        ullamcorper, lacus nibh malesuada tellus, sit amet viverra est turpis suscipit tortor. Duis sit amet
                        dolor porttitor, ornare tortor eget, venenatis ligula. Aenean erat est, aliquam egestas nibh eget,
                        faucibus porttitor neque. Morbi in tortor nulla. Quisque volutpat felis sit amet enim bibendum,
                        ac maximus enim fermentum.
                    </p>
                </div>
                <div class="col-lg-4 me-auto">
                    <p class="lead">Donec non arcu at turpis consequat fringilla. Cras vitae augue nulla.
                        Phasellus tellus turpis, molestie eget mi sagittis, rutrum faucibus ante. Duis malesuada ipsum dolor,
                        pharetra tristique lectus condimentum eu. Quisque rutrum ornare nibh. Curabitur iaculis cursus dui,
                        sed aliquet odio pharetra ut. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
                    </p></div>
            </div>

        </div>
    </section>

    <section class="page-section bg-white text-white mb-0" id="formCasContainer">
        <div class="container">
            <h2 class="page-section-heading text-center text-uppercase text-secondary">Formulár na CAS</h2>
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-7 pt-5">
                    <form id="casForm">
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="requirement" type="text"
                                      placeholder="Sem napíšte príkaz ..." style="height: 7rem"></textarea>
                            <label for="requirement">Zadajte príkaz</label>
<!--                            <div class="invalid-feedback" data-sb-feedback="requirement:required">Toto pole je povinné</div>-->
                        </div>

                        <button class="btn btn-primary btn-lg" id="submitCasFormButton" type="button">Vypočítať</button>
                    </form>
                </div>
                <div class="col-lg-8 col-xl-7 pt-5" id="outputFormContainer">
                    <div class="border-bottom border-grey border-1 rounded-1 text-black p-3" id="outputForm">
                    </div>
                </div>
            </div>
        </div>
    </section>



    <section class="page-section bg-white text-white mb-0 m-5" id="plotContainer">
        <div class = "container">
            <h2 class="page-section-heading text-center text-uppercase text-secondary">Animácia a graf</h2>
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-7 pt-5">
                    <form id="animationForm" class="text-sm">
                        <div class="form-floating mb-3">
                            <input class="form-control" id="obstacleHeight" type="number"
                                      placeholder="Sem napíšte výšku prekážky ..."/>
                            <label for="obstacleHeight">Zadajte výšku prekážky (v cm)</label>
                            <div class="invalid-feedback" data-sb-feedback="obstacleHeight:required">Toto pole je povinné</div>
                            <div class="d-flex flex-row justify-content-start align-items-center pt-4">
                                <div class="form-check me-5">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        <small>Vykreslenie grafu</small>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                    <label class="form-check-label" for="flexCheckChecked">
                                        <small>Vykreslenie animácie</small>
                                    </label>
                                </div>

                            </div>
                        </div>

                        <button class="btn btn-primary btn-lg" id="submitPlotButton" type="button">Odoslať</button>
                    </form>
                </div>
            </div>
        </div>
    </section>


    <footer class="footer text-center">
        <div class="container">
            <p>Footer</p>
            <p class="text-white">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla sodales, elit at maximus
                ullamcorper, lacus nibh malesuada tellus, sit amet viverra est turpis suscipit tortor.</p>
        </div>
    </footer>

    <div class="copyright py-4 text-center text-white">
        <div class="container"><small>Copyright &copy; Finálne zadanie Webte2 2022</small></div>
    </div>
</body>
</html>