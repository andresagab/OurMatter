<?php
session_start();
if (isset($_SESSION['USUARIO'])) {
    $session = unserialize($_SESSION['USUARIO']);
    if ($session['usuario']['usuario'] != null) {
        if (strtolower($session['usuario']['typeUser']) == 'docente') header("Location: ./App/Pages/docente/home.php?pg=0");
        else header("Location: ./App/Pages/estudiante/home.php");
    }
}
$tm = 2;
if (isset($_GET['tm'])) $tm = $_GET['tm'];
$toast = "<input type='hidden' id='toastAction' name='toastAction' value='$tm'>";
?>
<!DOCTYPE html>
<html>
    <head>
        <title>OurMatter - Química</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=500, init-scale=1, maximum-scale=1">
        <link rel="stylesheet" href="App/frameworks/Bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="App/frameworks/MaterialIcons/material-icons.css">
        <link rel="stylesheet" href="App/css/ourMatter.css">
        <script src="App/js/jquery-3.4.1.min.js"></script>
        <script src="App/js/publico/DOM-functions-publico.js"></script>
        <script src="App/js/login.js"></script>
        <script src="App/frameworks/Bootstrap/js/bootstrap.min.js"></script>
        <script src="App/frameworks/Bootstrap/js/bootstrap.bundle.min.js"></script>
    </head>
    <body class="bg-dark">
    <!--MENU-->
    <nav id="navbarMenu" class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark">
        <a id="btnHome" class="navbar-brand active" data-toggle="tooltip" data-placement="bottom"
           title="Química - Inicio">
            <img src="App/img/Q.png" width="30px" height="30px" class="d-inline-block bg-dark" alt="">
            <!--Quimica-->
        </a>
        <button id="btnToggleMenu" class="navbar-toggler" type="button" data-toggle="collapse"
                data-target="#optionsNavBar" aria-controls="optionsNavBar" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="optionsNavBar">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a id="btnInformacionMain" class="nav-link" href="#">
                        Información
                    </a>
                </li>
                <li class="nav-item">
                    <a id="btnContactoMain" class="nav-link" href="#">
                        Contacto
                    </a>
                </li>
                <li class="nav-item" id="btnLogIn" data-toggle="modal" data-target="#modalLogIn">
                    <a class="nav-link" href="#">
                        Inicio de sesión
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <!--END MENU-->
    <!--CONTENT-->
    <div id="containerFull" class="pt-5"></div>
    <!--END CONTENT-->
    <!--MODAL LOGIN-->
    <div class="modal fade" id="modalLogIn" tabindex="-1" role="dialog" aria-labelledby="modalLogIn">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLogInCenterTittle">INICIO DE SESIÓN</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close" id="btnCloseModalLogin">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="needs-validation" id="frmLogin" novalidate>
                    <div class="modal-body">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label for="txtUsuario">Usuario:</label>
                                <input type="text" class="form-control" id="txtUsuario" name="txtUsuario" required>
                                <div class="invalid-feedback">Debes ingresar tu nombre de usuario.</div>
                            </div>
                            <div class="form-group">
                                <label for="txtPassword">Contraseña:</label>
                                <input type="password" class="form-control" id="txtPassword" name="txtPassword"
                                       required>
                                <div class="invalid-feedback">Debes ingresar tu contraseña</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="btnCancelModalLogin" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Ingresar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--END MODAL LOGIN-->
    <!--TOAS MJS-->
    <?= $toast ?>
    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="3000" style="position: absolute; top: 15px; left: 15px; z-index: 1100;">
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