<?php
session_start();
if (isset($_SESSION['USUARIO'])) {
    $USUARIO = unserialize($_SESSION['USUARIO'])['usuario'];
    if (strtolower($USUARIO['typeUser']) == 'estudiante') {
        ?>
        <!DOCTYPE html>
        <html>
            <head>
                <title>OurMatter - ESTUDIANTE</title>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=500, init-scale=1, maximum-scale=1">
                <link rel="stylesheet" href="../../frameworks/Bootstrap/css/bootstrap.min.css">
                <link rel="stylesheet" href="../../frameworks/MaterialIcons/material-icons.css">
                <link rel="stylesheet" href="../../css/ourMatter.css">
                <script src="../../js/jquery-3.4.1.min.js"></script>
                <script src="../../js/estudiante/DOM-functions-estudiante.js"></script>
                <script src="../../frameworks/Bootstrap/js/bootstrap.min.js"></script>
                <script src="../../frameworks/Bootstrap/js/bootstrap.bundle.min.js"></script>
            </head>
            <body class="bg-dark">
            <!--MENU-->
            <nav id="navbarMenu" class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark">
                <a id="btnHome" class="navbar-brand active" data-toggle="tooltip" data-placement="bottom"
                   title="Química - Inicio">
                    <img src="../../img/Q.png" width="30px" height="30px" class="d-inline-block bg-dark" alt="">
                    <!--Quimica-->
                </a>
                <button id="btnToggleMenu" class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#optionsNavBar" aria-controls="optionsNavBar" aria-expanded="false"
                        aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="optionsNavBar">
                    <ul class="navbar-nav">
                        <li class="nav-item" id="btnLogOut">
                            <a class="nav-link" href="#">
                                Cerrar sesión
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <!--END MENU-->
            <!--CONTENT-->
            <div id="containerFull" class="pt-5">
                <h1 class="display-1 text-center text-light">ESTUDIANTE</h1>
                <h6 class="display-4 text-center text-light"><?= $USUARIO['usuario'] ?></h6>
            </div>
            <!--END CONTENT-->
            </body>
        </html>
        <?php
    } else header("Location: ./../../../index.php?tm=-1");
} else {
    if (isset($_GET['out'])) header("Location: ./../../../index.php");
    else header("Location: ./../../../index.php?tm=0");
}