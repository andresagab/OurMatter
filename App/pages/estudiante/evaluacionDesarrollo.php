<?php
/**
 * @Page evaluacionDesarrollo
 * @Autor Anres Geovanny Angulo Botina
 * @email andrescabj981@gmail.com
 * $tm = 0 : No hay errores o informes.
 * $tm = 1 : No existe la variable correspondiente a la sesión del usuario, no se puede cargar la página solicitada.
 * */
include_once dirname(__FILE__) . './../../php/Scripts/session_manager.php';
if (isset($_GET['tm'])) $tm = $_GET['tm'];
else $tm = 0;
if ($session) {
    if (strtolower(@$USUARIO['typeUser']) == 'estudiante') {
        include_once dirname(__FILE__) . './../../php/Scripts/general_funcitons.php';
        require_once dirname(__FILE__) . './../../php/Class/Conector.php';
        require_once dirname(__FILE__) . './../../php/Class/Tema.php';
        require_once dirname(__FILE__) . './../../php/Class/Estudiante.php';
        require_once dirname(__FILE__) . './../../php/Class/Evaluacion.php';
        require_once dirname(__FILE__) . './../../php/Class/Evaluacion_Ejecucion.php';
        require_once dirname(__FILE__) . './../../php/Class/Evaluacion_Pregunta.php';
        require_once dirname(__FILE__) . './../../php/Class/Evaluacion_Opcion.php';

        //Cargamos al estudiante
        $estudiante = new Estudiante('usuario', "'{$USUARIO['usuario']}'", null, null);
        $autoLogout = '';
        if ($estudiante->getId() != null) {
            $list = '';
            //Verificamos que se haya recibido el id de la evaluación
            if (isset($_GET['id'])) {
                //Cargamos la evaluación
                $evaluacion = new Evaluacion('id', $_GET['id'], null, null);
                //Cargamos la disponibilidad de la evaluación
                $disponibilidad = $evaluacion->statusEvaluacion();
                $tituloExamen = 'Preguntas';
                //Comprobamos si la evaluación no ha registrado la ejecución
                if ($evaluacion->getId() != null) {
                    //Cargamos el estado de la evaluacion del estudiante
                    $statusEvaluacion = $evaluacion->statusEvaluacionEstudiante($estudiante->getId(), false);
                    if ($statusEvaluacion === 0) {
                        //Enviamos el id de la evaluación y del estudiante para ser registrados a la ejecucion.
                        header("Location: ./evaluacionUpdate.php?method=addEjecucion&idEv={$evaluacion->getId()}&idEs={$estudiante->getId()}");
                        die();
                    } else if ((int) $statusEvaluacion === 1){
                        //La evaluacion aún esta incompleta
                        //Cargamos la evaluacion_ejecucion
                        $evaluacionEjecucion = new Evaluacion_Ejecucion('id_evaluacion', $evaluacion->getId(), "AND id_estudiante = {$estudiante->getId()}", null);
                        if ($evaluacion->getId() != null) {
                            //Comprovamos que el id de la evaluacion ejecución no tenga relacion con ninguna opcion de respuesta
                            if (!$evaluacionEjecucion->isComplete()) {

                                //Cargamos todas las preguntas de la evaluacion
                                $preguntas = Evaluacion_Pregunta::getObjects("id_evaluacion = {$evaluacion->getId()}", 'order by id asc');
                                if (count($preguntas) > 0) {

                                    date_default_timezone_set('America/Bogota');
                                    if ($disponibilidad === 'Disponible') $remainTime = timeDiffInHours(date('Y-m-d H:i:s'), $evaluacion->getFechaFin(), true);
                                    else $remainTime = '0:0:0';
                                    $inputTiempo = '<input type="hidden" id="timer" value="' . $remainTime . '">';

                                    $list .= "
                                    $inputTiempo
                                    <div class='col-xl-12 pb-5 bg-light'>
                                        <div class='row'>
                                            <div class='col-xl-12 text-center'>
                                                <h6 class='display-4 pt-3 text-info' id='txtTimer'>$remainTime</h6>
                                            </div>
                                            <div class='col-md-1'></div>
                                            <div class='col-md-10'>";
                                                    for ($i = 0; $i < count($preguntas); $i++){
                                                        $pregunta = $preguntas[$i];
                                                        $list .= "
                                                        <form name='frmEvaluacionDesarrollo' id='frmEvaluacionDesarrollo' method='POST' action='evaluacionUpdate.php'>
                                                            <div class='row'>
                                                                <div class='col-12'>
                                                                    <hr class='my-4'>
                                                                </div>
                                                                <div class='col-md-12 align-self-center'>
                                                                    <div class='card bg-light border-light h-100 align-middle'>
                                                                        <div class='card-body'>
                                                                            <h3 class='card-title text-uppercase text-" . getRandomColorText('0', '2') . "'>{$pregunta->getPregunta()}</h3>
                                                                            <p class='card-text pt-3'>
                                                                            ";
                                                            /*--------------------------------------------------------------------------------------------*/
                                                            /*OPCIONES RESPUESTA*/

                                                            //Cargamos las opciones de respuesta de la pregunta que esta almacenada en $pbject
                                                            $options = Evaluacion_Opcion::getObjects("id_evaluacionPregunta = {$pregunta->getId()}", null);
                                                            //Declaramos la alerta de que la pregunta aún no tiene registradas sus opciones de respuesta
                                                            $alert = '<div class="mt-3 alert alert-warning">Sin opciones de respuesta, comunícate con tú docente!</div>';
                                                            //Evaluamos que hayan opciones registradas
                                                            if (count($options) > 0 && count($options) <= 4) {
                                                                $alert = '';
                                                                $letters = ['A', 'B', 'C', 'D'];
                                                                for ($j = 0; $j < count($options); $j++) {
                                                                    $option = $options[$j];
                                                                    $list .= "
                                                                    <!--<p class='card-text'><span class='font-weight-bold'>" . ($j + 1) . "). </span>{$option->getOpcion()}</p>-->
                                                                    <div class='form-group'>
                                                                        <div class='custom-control custom-radio'>
                                                                            <input type='radio' id='question_{$j}_{$pregunta->getId()}' name='radio_P$i' class='custom-control-input' value='{$option->getId()}'>
                                                                            <label class='custom-control-label text-break' for='question_{$j}_{$pregunta->getId()}'>{$letters[$j]}. {$option->getOpcion()}</label>
                                                                        </div>
                                                                    </div>
                                                                    ";
                                                                }
                                                            }
                                                            $list .= "</p>";
                                                            /*END OPCIONES RESPUESTA*/
                                                            /*--------------------------------------------------------------------------------------------*/
                                                            $list .="
                                                                    $alert
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>";
                                                        }
                                                    $list .= "
                                                        <hr class='my-4'>
                                                        <div class='form-group'>
                                                            <input type='hidden' name='method' value='addRespuestas'>
                                                            <input type='hidden' name='idEE' value='{$evaluacionEjecucion->getId()}'>
                                                            <input type='hidden' name='qc' value='" . count($preguntas) . "'>
                                                            <button class='btn btn-success float-right' type='submit'>Enviar</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            <div class='col-md-1'></div>
                                        </div>
                                    </div>";

                                } else $list = '
                                    <div class="col-xl-12 pb-5 bg-light">
                                        <div class="alert alert-danger">La evaluación no tiene preguntas registradas, comuncate con tú docente!.</div>
                                    </div>';

                            } else {
                                $list = '
                                    <div class="col-xl-12 pb-5 bg-light">
                                        <div class="alert alert-success text-center">La evaluación ya ha sido completada.</div>
                                    </div>';
                            }
                        } else header("Location: ./home.php?pg=2&tm=11");
                        //Presentamos la evaluacion
                    } else {
                        //Cargamos la evaluacion_ejecucion
                        $evaluacionEjecucion = new Evaluacion_Ejecucion('id_evaluacion', $evaluacion->getId(), "AND id_estudiante = {$estudiante->getId()}", null);
                        $totalPreguntas = $evaluacionEjecucion->getTotalPreguntas();
                        $totalRespuestasCorrectas = $evaluacionEjecucion->getTotalRespuestasCorrectas();
                        $totalRespuestasIncorrectas = Evaluacion_Ejecucion::getTotalRespuestasIncorrectas($totalPreguntas, $totalRespuestasCorrectas);
                        $calificacion = Evaluacion_Ejecucion::getCalificacion($totalPreguntas, $totalRespuestasCorrectas);
                        $colorCalificacion = Evaluacion_Ejecucion::getColorCalificacion($calificacion);
                        //La evaluacion fue terminada
                        $tituloExamen = 'Resultado';
                        $list .= "
                                    <div class='col-xl-12 p-3 bg-light'>
                                        <div class='row'>
                                            <div class='col-md-1'></div>
                                            <div class='col-md-10 align-self-center'>
                                                <div class='card bg-light border-light h-100 align-middle'>
                                                    <div class='card-body align-self-center'>
                                                        <!--<p class='card-text'>
                                                            <span class='font-weight-bold'>Tiempo: </span>58 minutos.
                                                        </p>-->
                                                        <p class='card-text'>
                                                            <span class='font-weight-bold'>Preguntas: </span>$totalPreguntas
                                                        </p>
                                                        <p class='card-text'>
                                                            <span class='font-weight-bold'>Respuestas correctas: </span>$totalRespuestasCorrectas
                                                        </p>
                                                        <p class='card-text'>
                                                            <span class='font-weight-bold'>Respuestas incorrectas: </span>$totalRespuestasIncorrectas
                                                        </p>
                                                        <p class='card-text'>
                                                            <span class='font-weight-bold'>Calificación: </span><span class='text-$colorCalificacion'>$calificacion</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='col-md-1'></div>
                                        </div>
                                    </div>";
                    }
                } else header("Location: ./home.php?pg=2&tm=11");

            } else header("Location: ./home.php?pg=2&tm=11");

        } else $autoLogout = '<input type="hidden" id="autoLogout" value="t">';
        ?>
        <!--EVALUACION INFO-->
        <script src="./../../js/estudiante/evaluacionDesarrollo.js"></script>
        <?= $autoLogout; ?>
        <div class="col-xl-12 bg-secondary p-5 text-light">
            <div class="row">
                <div class="col-md-0 col-lg-2"></div>
                <div class="col-sm-12 col-md-12 col-lg-8 text-center">
                    <h5 class="display-4 text-uppercase text-center text-break"><?= $evaluacion->getNombre(); ?></h5>
                    <h3 class="text-uppercase text-center text-break font-weight-normal pt-3"><?= $evaluacion->getTema()->getNombre(); ?></h3>
                    <p class="text-center pt-3"><?= $evaluacion->getDescripcion(); ?></p>
                    <!--<p class="text-center"><span class="font-weight-bold">Inicio: </span><?/*= $evaluacion->getFechaInicio(); */?></p>-->
                    <p class="text-center"><span class="font-weight-bold">Fin: </span><?= $evaluacion->getFechaFin(); ?></p>
                </div>
                <div class="col-md-0 col-lg-2 align-self-center text-center text-md-center text-lg-right pt-5 pt-sm-3 pt-md-3">
                    <button class="btn btn-outline-light text-center" id="btnBackParentPage" onclick="backPrincipalPage();">
                        <span class="">Regresar <i class="material-icons align-middle">arrow_back</i></span>
                    </button>
                </div>
            </div>
        </div>
        <!--END EVALUACION INFO-->
        <!--PREGUNTAS - RESULTADO-->
        <div class="col-xl-12 p-5 bg-white">
            <div class="row text-center">
                <div class="col-xl-2"></div>
                <div class="col-xl-8 align-self-center">
                    <h5 class="display-4 text-uppercase text-center"><?= $tituloExamen; ?></h5>
                </div>
                <div class="col-xl-2 align-self-center">
                </div>
            </div>
        </div>
        <?= $list; ?>
        <!--END PREGUNTAS - RESULTADO-->
        <?php
    } else header("Location: ./../../../index.php?tm=-1");
} else $tm = 10;
echo "<input type='hidden' id='toastAction' name='toastAction' value='$tm'>";