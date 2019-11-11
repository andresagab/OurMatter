<?php
/*
 * $tm = 0 : No hay errores.
 * $tm = 1 : No existe la variable correspondiente a la sesión del usuario, no se puede cargar la página solicitada.
 * */
include_once dirname(__FILE__) . './../../php/Scripts/session_manager.php';
$tm = 0;
if ($session){
    if (strtolower(@$USUARIO['typeUser']) == 'estudiante') {
        ?>
        <div class="col-xl-12 h-100">
            <div class="row h-100">
                <div class="col-xl-12 align-self-center">
                    <h1 class="display-4 text-center text-light">BIENVENIDO</h1>
                </div>
                <div class="col-xl-12 align-self-center">

                </div>
            </div>
        </div>
        <?php
    } else header("Location: ./../../../index.php?tm=-1");
} else {
    $toast = "<input type='hidden' id='toastAction' name='toastAction' value='1'>";
    echo "no hay session hay que informar que no se ha iniciado sesión o que los datos de la sesión han caducado";
}