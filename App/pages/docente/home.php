<?php
include_once dirname(__FILE__) . './../../php/Scripts/session_manager.php';
if ($session){
    if (strtolower(@$USUARIO['typeUser']) == 'docente') {
        ?>
        <!DOCTYPE html>
        <html>
            <head>
                <title>OurMatter - Docente</title>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=500, init-scale=1, maximum-scale=1">
                <link rel="stylesheet" href="../../frameworks/Bootstrap/css/bootstrap.min.css">
                <link rel="stylesheet" href="../../frameworks/MaterialIcons/material-icons.css">
                <link rel="stylesheet" href="../../css/ourMatter.css">
                <script src="../../js/jquery-3.4.1.min.js"></script>
                <script src="../../js/DOM-functions-general.js"></script>
                <script src="../../js/docente/DOM-functions-docente.js"></script>
                <script src="../../frameworks/Bootstrap/js/bootstrap.min.js"></script>
                <script src="../../frameworks/Bootstrap/js/bootstrap.bundle.min.js"></script>
                <!--<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>-->
            </head>
            <body class="bg-dark">
            <!--MENU-->
            <nav id="navbarMenu" class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark">
                <a id="btnHome" class="navbar-brand active" data-toggle="tooltip" data-placement="bottom" title="Química - Inicio">
                    <img src="../../img/Q.png" width="30px" height="30px" class="d-inline-block bg-dark" alt="">
                </a>
                <button id="btnToggleMenu" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#optionsNavBar" aria-controls="optionsNavBar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="optionsNavBar">
                    <ul class="navbar-nav">
                        <li class="nav-item" id="btnContenidos">
                            <a class="nav-link" href="#">
                                Contenidos
                            </a>
                        </li>
                        <li class="nav-item" id="btnEvaluaciones">
                            <a class="nav-link" href="#">
                                Evaluaciones
                            </a>
                        </li>
                        <li class="nav-item" id="btnEstudiantes">
                            <a class="nav-link" href="#">
                                Estudiantes
                            </a>
                        </li>
                        <li class="nav-item" id="btnConfiguracion">
                            <a class="nav-link" href="#">
                                Configuración
                            </a>
                        </li>
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
                <!--SPINNER LOAD-->
                <div id="spinnerLoadHome">
                    <div class="d-flex justify-content-center p-3" >
                        <div class="spinner-grow text-warning" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
                <!--END SPINNER LOAD-->
                <!--PAGE CONTENT-->
                <div id="contentPage" class="align-self-center h-100"></div>
                <!--END PAGE CONTENT-->
            </div>
            <!--END CONTENT-->
            <!--TOAS MJS-->
            <div class="toast position-fixed" role="alert" aria-live="assertive" aria-atomic="true" data-delay="3000" style="position: absolute; top: 15px; left: 15px; z-index: 1100;">
                    <div class="toast-header">
                        <!--<img src="App/img/Q.png" class="rounded mr-2">-->
                        <strong class="mr-auto">OurMatter</strong>
                        <small class="text-muted">Hace un momento</small>
                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="toast-body" id="toastText">
                        <span id="textToast"></span>
                    </div>
                </div>
            <!--END TOAS MJS-->
            </body>
        </html>
        <?php
    } else header("Location: ./../../../index.php?tm=-1");
} else {
    if (isset($_GET['out'])) header("Location: ./../../../index.php");
    else header("Location: ./../../../index.php?tm=0");
}