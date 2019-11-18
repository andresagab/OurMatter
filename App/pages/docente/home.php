<?php
include_once dirname(__FILE__) . './../../php/Scripts/session_manager.php';
include_once dirname(__FILE__) . './../../php/Scripts/general_funcitons.php';
if ($session){
    if (strtolower(@$USUARIO['typeUser']) == 'docente') {
        if (isset($_GET['pg'])) {
            switch ((Int) $_GET['pg']){
                case 0:$sourcePage = './main.php';break;
                case 1:$sourcePage = './contenidos.php';break;
                case 2:$sourcePage = './evaluaciones.php';break;
                case 3:$sourcePage = './estudiantes.php';break;
                case 4:$sourcePage = './configuracion.php';break;
                case 5:
                    if (isset($_GET['fl'])) {
                        if (($route = getPageDocente($_GET['fl'])) != '') $sourcePage = "./$route";
                        else $sourcePage = './../404.php';
                    } else $sourcePage = './../404.php';
                    break;
                default: $sourcePage = './../404.php';
            }

            //Cargamos las clases necesarias
            require_once dirname(__FILE__) . '.\..\..\php\Class\Conector.php';
            require_once dirname(__FILE__) . '.\..\..\php\Class\Usuario.php';
            require_once dirname(__FILE__) . '.\..\..\php\Class\Sitio.php';
            //Cargamos las configuraciones del sitio
            $sitio = new Sitio('id', 1, null, null);
            if ($sitio->getNameMateria() == '' || $sitio->getNameMateria() == null) $sitio->setNameMateria('OurMatter');

        } else $sourcePage = './../404.php';
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
            </head>
            <body class="bg-dark">
            <!--MENU-->
            <nav id="navbarMenu" class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark" style="z-index: 1100;">
                <a id="btnHome" class="navbar-brand active" style="cursor: pointer;" data-toggle="tooltip" data-placement="bottom" title="<?= $sitio->getNameMateria() ?> - Inicio" href="home.php?pg=0">
                    <div class="align-middle align-self-center text-uppercase text-light">
                        <?= $sitio->getNameMateria(); ?>
                    </div>
                </a>
                <button id="btnToggleMenu" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#optionsNavBar" aria-controls="optionsNavBar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="optionsNavBar">
                    <ul class="navbar-nav">
                        <li class="nav-item" id="btnContenidos">
                            <a class="nav-link" href="home.php?pg=1">
                                Contenidos
                            </a>
                        </li>
                        <li class="nav-item" id="btnEvaluaciones">
                            <a class="nav-link" href="home.php?pg=2">
                                Evaluaciones
                            </a>
                        </li>
                        <li class="nav-item" id="btnEstudiantes">
                            <a class="nav-link" href="home.php?pg=3">
                                Estudiantes
                            </a>
                        </li>
                        <li class="nav-item" id="btnConfiguracion">
                            <a class="nav-link" href="home.php?pg=4">
                                Configuración
                            </a>
                        </li>
                        <!--<li class="nav-item" id="btnConfiguracionPassword" >
                            <a class="nav-link" href="home.php?pg=6" data-toggle="tooltip" data-placemente="bottom" title="Cambiar contraseña">
                                <span class="material-icons">account_circle</span>
                            </a>
                        </li>-->
                        <li class="nav-item" id="btnLogOut" data-toggle="tooltip" data-placemente="bottom" title="Cerrar sesión">
                            <a class="nav-link" href="#">
                                <span class="material-icons">exit_to_app</span>
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
                <div id="contentPage" class="align-self-center h-100">
                    <?php include $sourcePage; ?>
                </div>
                <!--END PAGE CONTENT-->
            </div>
            <!--END CONTENT-->
            <!--TOAS MJS-->
            <div class="toast position-fixed" role="alert" aria-live="assertive" aria-atomic="true" data-delay="3500" style="position: absolute; top: 45px; right: 15px; z-index: 1100;">
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