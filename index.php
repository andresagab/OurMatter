<?php
session_start();
if (isset($_SESSION['USUARIO'])) {
    $session = unserialize($_SESSION['USUARIO']);
    if ($session['usuario']['usuario'] != null) {
        if (strtolower($session['usuario']['typeUser']) == 'docente') header("Location: ./App/Pages/docente/home.php?pg=0&mb=t");
        else header("Location: ./App/Pages/estudiante/home.php?pg=0&mb=t");
    }
} else {

    if (isset($_GET['pg'])) {
        switch ((Int)$_GET['pg']) {
            case 0:
                $sourcePage = './App/pages/publico/informacion.php';
                break;
            case 1:
                $sourcePage = './App/pages/publico/contacto.php';
                break;
            default:
                $sourcePage = './../404.php';
        }
    } else $sourcePage = './App/pages/publico/inicio.php';

    //Cargamos todos los archivos necesarios para presentar los datos del sitio
    require_once dirname(__FILE__) . '.\App\php\Scripts\general_funcitons.php';
    require_once dirname(__FILE__) . '.\App\php\Class\Conector.php';
    require_once dirname(__FILE__) . '.\App\php\Class\Usuario.php';
    require_once dirname(__FILE__) . '.\App\php\Class\Sitio.php';

    //Cargamos los datos del sitio
    $sitio = new Sitio('id', 1, null, null);
    //Comprobamos que el objeto cargado no este vacio
    if ($sitio->getId() == null) {
        //Llenamos algunos campos con valores por defecto
        $sitio->setNameMateria('OurMatter');
    }

}
$tm = 2;
if (isset($_GET['tm'])) $tm = $_GET['tm'];
$toast = "<input type='hidden' id='toastAction' name='toastAction' value='$tm'>";
?>
<!DOCTYPE html>
<html>
    <head>
        <title>OurMatter - <?= $sitio->getNameMateria(); ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=500, init-scale=1, maximum-scale=1">
        <link rel="stylesheet" href="App/frameworks/Bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="App/frameworks/MaterialIcons/material-icons.css">
        <link rel="stylesheet" href="App/css/ourMatter.css">
        <script src="App/js/jquery-3.4.1.min.js"></script>
        <script src="App/js/publico/DOM-functions-publico.js"></script>
        <script src="App/js/DOM-functions-general.js"></script>
        <script src="App/js/login.js"></script>
        <script src="App/frameworks/Bootstrap/js/bootstrap.min.js"></script>
        <script src="App/frameworks/Bootstrap/js/bootstrap.bundle.min.js"></script>
    </head>
    <body class="bg-dark">
    <!--MENU-->
    <nav id="navbarMenu" class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark">
        <a id="btnHome" class="navbar-brand active" style="cursor: pointer;" data-toggle="tooltip" data-placement="bottom" title="<?= $sitio->getNameMateria() ?> - Inicio" href="index.php">
            <div class="align-middle align-self-center text-uppercase text-light">
                <?= $sitio->getNameMateria(); ?>
            </div>
        </a>
        <button id="btnToggleMenu" class="navbar-toggler" type="button" data-toggle="collapse"
                data-target="#optionsNavBar" aria-controls="optionsNavBar" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="optionsNavBar">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a id="btnInformacionMain" class="nav-link" href="index.php?pg=0">
                        Información
                    </a>
                </li>
                <li class="nav-item">
                    <a id="btnContactoMain" class="nav-link" href="index.php?pg=1">
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
    <div id="containerFull" class="pt-5"><?php include $sourcePage; ?></div>
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
                                <div class="input-group mb-3">
                                    <!--<input type="text" class="form-control" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">-->
                                    <input type="password" class="form-control" id="txtPassword" name="txtPassword" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary btn-sm" type="button" id="btnViewPassword" data-toggle="tooltip" title="Ver contraseña" onclick="viewPassword('txtPassword', 'btnSpanViewPassword')"><span class="material-icons align-middle" id="btnSpanViewPassword">visibility_off</span></button>
                                    </div>
                                </div>
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
    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="3000" style="position: absolute; top: 45px; right: 15px; z-index: 1100;">
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