<?php
/*
 * $tm = 0 : No hay errores.
 * $tm = 1 : No existe la variable correspondiente a la sesión del usuario, no se puede cargar la página solicitada.
 * */
include_once dirname(__FILE__) . './../../php/Scripts/session_manager.php';
$tm = 0;
if ($session){
    if (strtolower(@$USUARIO['typeUser']) == 'docente') {

        require_once dirname(__FILE__) . '.\..\..\php\Class\Conector.php';
        require_once dirname(__FILE__) . '.\..\..\php\Class\Evaluacion.php';
        require_once dirname(__FILE__) . '.\..\..\php\Class\Estudiante.php';
        require_once dirname(__FILE__) . '.\..\..\php\Class\Evaluacion_Ejecucion.php';

        //Generamos el mensaje de bienvenida
        $welcomeMesssaje = '
            <h1 class="display-4 text-center text-light">HOLA</h1>
            <h2 class="text-center text-break font-weight-lighter text-light">' . $sitio->getNameDocente() . '</h2>
        ';
        if (!isset($_GET['mb'])) $welcomeMesssaje = "<h1 class='text-uppercase text-center text-break font-weight-lighter text-light'>{$sitio->getNameMateria()}</h1>";

        //Cargo todas la evaluaciones cerradas
        $evaluaciones = Evaluacion::getObjects('fechaFin < now()', 'order by fechaFin desc limit 5;');

        if (count($evaluaciones) > 0) {

            //Abrimos lista
            $listEvaluaciones = '
            <div class="col-xl-12 pt-4 pb-3 align-self-center">
                <div class="table-responsive-sm">
                    <table class="table table-hover table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Evaluacion</th>
                            <th scope="col">Respuestas</th>
                        </tr>
                        </thead>
                        <tbody>
            ';

            //Rellenamos la lista
            for ($i = 0; $i < count($evaluaciones); $i++) {
                $evaluacion = $evaluaciones[$i];

                $listEvaluaciones .= "
                <tr>
                    <td scope='row'>" . ($i + 1) . "</td>
                    <td>{$evaluacion->getNombre()}</td>
                    <td>{$evaluacion->getTotalAnswers()}</td>
                </tr>";

            }

            //Cerramos lista
            $listEvaluaciones .= '
                        </tbody>
                    </table>
                </div>
            </div>
            ';

        } else $listEvaluaciones = "<div class='col-xl-12 text-center'><div class='alert alert-primary'><h5 class='font-weight-lighter'>No hay evaluaciones cerradas</h5></div></div>";

        ?>
        <!--HEAD CONTENT-->
        <div class="col-xl-12 bg-white mt-2 p-0 h-100">
            <div class="col-xl-12 p-5 bg-secondary text-light">
                <div class="row text-center">
                    <div class="col-xl-2"></div>
                    <div class="col-xl-8 align-self-center">
                        <?= $welcomeMesssaje; ?>
                    </div>
                    <div class="col-xl-2"></div>
                </div>
            </div>
            <!--CONTENT PAGE-->
            <div class="col-xl-12 pb-5 bg-white">
                <div class="row">
                    <div class="col-xl-12 align-self-center">
                        <div class="row ml-3 mr-3 h-100 pt-4">
                            <div class="col-xl-12">
                                <div class="row h-100">
                                    <h3 class="card-title col-xl-12 text-s30 text-center font-weight-light text-danger">EVALUACIONES CERRADAS</h3>
                                    <?= $listEvaluaciones; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--END CONTENT PAGE-->
        </div>
        <!--END HEAD CONTENT-->
        <?php
    } else header("Location: ./../../../index.php?tm=-1");
} else {
    $toast = "<input type='hidden' id='toastAction' name='toastAction' value='1'>";
    echo "no hay session hay que informar que no se ha iniciado sesión o que los datos de la sesión han caducado";
}