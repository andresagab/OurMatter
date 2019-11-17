<?php
/**
 * @Page evaluacionEstudianteRetroalimentacion
 * @Autor Anres Geovanny Angulo Botina
 * @email andrescabj981@gmail.com
 * $tm = 0 : No hay errores o informes.
 * $tm = 1 : No existe la variable correspondiente a la sesión del usuario, no se puede cargar la página solicitada.
 * */
include_once dirname(__FILE__) . './../../php/Scripts/session_manager.php';
if (isset($_GET['tm'])) $tm = $_GET['tm'];
else $tm = 0;
if ($session) {
    if (strtolower(@$USUARIO['typeUser']) == 'docente') {
        include_once dirname(__FILE__) . './../../php/Scripts/general_funcitons.php';
        require_once dirname(__FILE__) . './../../php/Class/Conector.php';
        require_once dirname(__FILE__) . './../../php/Class/Tema.php';
        require_once dirname(__FILE__) . './../../php/Class/Estudiante.php';
        require_once dirname(__FILE__) . './../../php/Class/Evaluacion.php';
        require_once dirname(__FILE__) . './../../php/Class/Evaluacion_Ejecucion.php';
        require_once dirname(__FILE__) . './../../php/Class/Evaluacion_Pregunta.php';
        require_once dirname(__FILE__) . './../../php/Class/Evaluacion_Opcion.php';

        //Comprobamos que exista el id de la ejecución de evaluación
        if (isset($_GET['id'])) {

            //Cargamos la evaluacion_ejecucion
            $evaluacionEjecucion = new Evaluacion_Ejecucion('id', $_GET['id'], null, null);
            if ($evaluacionEjecucion->getId() != null) {

                //Cargamos la evaluacion
                $evaluacion = $evaluacionEjecucion->getEvaluacion();
                //Cargamos el estudiantes
                $estudiante = $evaluacionEjecucion->getEstudiante();
                //Comprobamos que se haya cargado la evaluación y el estudiante
                if ($evaluacion->getId() != null && $estudiante->getId() != null ) {

                    //Cargamos el resumen de la evaluacion ejecutada por el estudiante
                    $list = '';
                    $totalPreguntas = $evaluacionEjecucion->getTotalPreguntas();
                    $totalRespuestasCorrectas = $evaluacionEjecucion->getTotalRespuestasCorrectas();
                    $totalRespuestasIncorrectas = Evaluacion_Ejecucion::getTotalRespuestasIncorrectas($totalPreguntas, $totalRespuestasCorrectas);
                    $calificacion = Evaluacion_Ejecucion::getCalificacion($totalPreguntas, $totalRespuestasCorrectas);
                    $colorCalificacion = Evaluacion_Ejecucion::getColorCalificacion($calificacion);
                    $resumen = "
                    <div class='card bg-white border-white h-100 align-middle'>
                        <div class='card-body align-self-center'>
                            <p class='card-text text-left'>
                                <span class='font-weight-bold'>Estudiante: </span>{$estudiante->getNombres()} {$estudiante->getApellidos()}
                            </p>
                            <p class='card-text text-left'>
                                <span class='font-weight-bold'>Preguntas: </span>$totalPreguntas
                            </p>
                            <p class='card-text text-left'>
                                <span class='font-weight-bold'>Respuestas correctas: </span>$totalRespuestasCorrectas
                            </p>
                            <p class='card-text text-left'>
                                <span class='font-weight-bold'>Respuestas incorrectas: </span>$totalRespuestasIncorrectas
                            </p>
                            <p class='card-text text-left'>
                                <span class='font-weight-bold'>Calificación: </span><span class='text-$colorCalificacion'>$calificacion</span>
                            </p>
                        </div>
                    </div>
                    ";

                    if ($evaluacion->statusEvaluacionEstudiante($estudiante->getId(), false) === 2) {

                        //Cargamos todas las preguntas de la evaluacion
                        $preguntas = Evaluacion_Pregunta::getObjects("id_evaluacion = {$evaluacion->getId()}", 'order by id asc');
                        if (count($preguntas) > 0) {

                            //Cargamos las preguntas que registraron respuesta por parte del estudiante
                            $preguntasRespuesta = Evaluacion_Pregunta::getObjects("id IN (select id_evaluacionPregunta FROM evaluacion_opcion WHERE id IN (SELECT id_evaluacionOpcion FROM evaluacion_respuesta WHERE id_evaluacionEjecucion = {$evaluacionEjecucion->getId()}))", null);

                            $list .= "
                                    <div class='col-xl-12 pb-5 bg-light'>
                                        <div class='row'>
                                            <div class='col-xl-12 text-center'>
                                                <h6 class='display-4 pt-3 text-info' id='txtTimer'>PREGUNTAS Y RESPUESTAS</h6>
                                            </div>
                                            <div class='col-md-1'></div>
                                            <div class='col-md-10'>";
                            for ($i = 0; $i < count($preguntas); $i++){

                                $pregunta = $preguntas[$i];
                                $list .= "
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

                                //Cargamos las opciones de respuesta de la pregunta que esta almacenada en $pregunta
                                $options = Evaluacion_Opcion::getObjects("id_evaluacionPregunta = {$pregunta->getId()}", null);
                                //Cargamos las opciones de respuesta que se registraron como respuesta de la evaluacion del estudiante
                                $optionsRespuesta = Evaluacion_Opcion::getObjects("id IN (SELECT id_evaluacionOpcion FROM evaluacion_respuesta WHERE id_evaluacionEjecucion = {$evaluacionEjecucion->getId()})", null);
                                //Declaramos la alerta de que la pregunta aún no tiene registradas sus opciones de respuesta
                                $alert = '<div class="mt-3 alert alert-warning">Aún no se han registrado las opciones de respuesta!</div>';
                                //Evaluamos que hayan opciones registradas
                                if (count($options) > 0 && count($options) <= 4) {
                                    $alert = '';
                                    $letters = ['A', 'B', 'C', 'D'];
                                    $correccionRespuesta = "";
                                    for ($j = 0; $j < count($options); $j++) {
                                        $option = $options[$j];

                                        //Recorremos las opciones de respuesta para separar la que el estudiante respondip
                                        $opcionEstudiante = '';
                                        for ($x = 0; $x < count($optionsRespuesta); $x++) {
                                            if ($option->getId() === $optionsRespuesta[$x]->getId()) {
                                                if ($option->getCorrecta()) {
                                                    $opcionEstudiante = '<span class="material-icons align-middle text-success font-weight-bold">thumb_up</span>';
                                                    if ($correccionRespuesta === "") $correccionRespuesta = "<div class='alert alert-success'><h6 class='align-middle'>El estudiante escogió la respuesta correcta!</h6></div>";
                                                }
                                                else {
                                                    $opcionEstudiante = '<span class="material-icons align-middle text-danger font-weight-bold">thumb_down</span>';
                                                }
                                                break;
                                            }
                                        }

                                        if ($option->getCorrecta()) {
                                            $correcta = '<span class="material-icons align-middle text-success">check</span>';
                                            if ($correccionRespuesta === "") $correccionRespuesta = "<div class='alert alert-warning'><h6 class='align-middle'>La respuesta correcta es: <span class='font-weight-bold'>{$option->getOpcion()}</span></h6></div>";
                                        }
                                        else $correcta = '<span class="material-icons align-middle text-danger">close</span>';
                                        $list .= "
                                                                    <div class='form-group'>
                                                                        <div class='custom-control custom-radio'>
                                                                            <p class='card-text text-break'><span class='font-weight-bold'>$letters[$j]). </span>{$option->getOpcion()} $correcta $opcionEstudiante</p>
                                                                        </div>
                                                                    </div>
                                                                    ";
                                    }
                                }
                                $list .= "</p>";
                                /*END OPCIONES RESPUESTA*/
                                /*--------------------------------------------------------------------------------------------*/
                                //Comprobamos que el estudiante tenga registrada la respuesta de la pregunta actual en el for
                                $sinRespuestaAlert = "<div class='alert alert-danger'><h6 class='align-middle'>El estudiante no registró respuesta para esta pregunta!</h6></div>";
                                for ($x = 0; $x < count($preguntasRespuesta); $x++) {
                                    if ($pregunta->getId() === $preguntasRespuesta[$x]->getId()) {
                                        $sinRespuestaAlert = '';
                                        break;
                                    }
                                }
                                $list .="
                                                                    $alert
                                                                    $sinRespuestaAlert
                                                                    $correccionRespuesta
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>";
                            }
                            $list .= "
                                                </div>
                                            <div class='col-md-1'></div>
                                        </div>
                                    </div>";

                        } else $list = '
                                    <div class="col-xl-12 pb-5 bg-light">
                                        <div class="alert alert-danger">La evaluación aún no tiene preguntas registradas!</div>
                                    </div>';

                    } else {
                        $list = "
                        <div class='col-xl-12 pb-5 bg-light'>
                            <div class='row'>
                                <div class='col-xl-12 text-center'>
                                    <div class='alert alert-warning'><h3>La retroalimentación estará disponible cuando el estudiante termine de desarrollar la evaluación.</h3></div>
                                </div>
                            </div>
                        </div>
                        ";
                    }

                } else header("Location: ./home.php?pg=2&tm=11");

            } else header("Location: ./home.php?pg=2&tm=11");

        } else header("Location: ./home.php?pg=2&tm=11");
        ?>
        <!--EVALUACION INFO-->
        <script src="./../../js/docente/evaluacionEstudianteRetroalimentacion.js"></script>
        <div class="col-xl-12 bg-secondary p-5 text-light">
            <div class="row">
                <div class="col-md-0 col-lg-2"></div>
                <div class="col-sm-12 col-md-12 col-lg-8 text-center">
                    <h5 class="display-4 text-uppercase text-center text-break"><?= $evaluacion->getNombre(); ?></h5>
                    <h3 class="text-uppercase text-center text-break font-weight-normal pt-3"><?= $evaluacion->getTema()->getNombre(); ?></h3>
                    <p class="text-center pt-3"><?= $evaluacion->getDescripcion(); ?></p>
                </div>
                <div class="col-md-0 col-lg-2 align-self-center text-center text-md-center text-lg-right pt-5 pt-sm-3 pt-md-3">
                    <button class="btn btn-outline-light text-center" id="btnBackParentPage" onclick="backToEvaluacionEstudiantes(<?= $evaluacion->getId() ?>, '<?= md5('evaluacionEstudiantes.php') ?>');">
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
                    <h5 class="display-4 text-uppercase text-center">RESUMEN</h5>
                    <?= $resumen; ?>
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