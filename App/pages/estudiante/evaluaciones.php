<?php
/**
 * @Page evaluaciones.php
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
        require_once dirname(__FILE__) . './../../php/Class/Estudiante.php';
        require_once dirname(__FILE__) . './../../php/Class/Tema.php';
        require_once dirname(__FILE__) . './../../php/Class/Evaluacion.php';
        require_once dirname(__FILE__) . './../../php/Class/Evaluacion_Ejecucion.php';

        //Cargamos al estudiante por su nombre de usuario
        $estudiante = new Estudiante('usuario', "'{$USUARIO['usuario']}'", null, null);
        //Pendiente validar si el estudiante cargado es un objeto vacio

        //Cargamos todos los registros
        $data = Evaluacion::getObjects('id IN (select id_evaluacion FROM evaluacion_pregunta WHERE id IN (SELECT id_evaluacionPregunta FROM evaluacion_opcion))', 'order by fechafin asc');
        $list = '';
        //Comprobamos que hayan registros, de no haber ninguno establecemos el valor correspondiente a la variable toast
        if (count($data) > 0){
            $list = "
            <div class='col-xl-12 bg-light p-5 align-content-center'>
                <div class='row align-self-center'>
                    <div class='col-xl-0'></div>
                    <div class='col-xl-12 align-self-center table-responsive'>
                        <table class='table table-hover'>
                            <thead>
                                <tr>
                                    <th scope='col'>#</th>
                                    <th scope='col'>Evaluacion</th>
                                    <!--<th scope='col'>Descripción</th>-->
                                    <th scope='col'>Tema</th>
                                    <th scope='col'>Fecha inicio</th>
                                    <th scope='col'>Fecha fin</th>
                                    <th scope='col'>Estado</th>
                                    <th scope='col'>Calificación</th>
                                    <th scope='col' class='px-5'>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>";
            for ($i = 0; $i < count($data); $i++){
                $object = $data[$i];
                //Cargamos el estado de la evaluacion
                $statusEvaluacion = $object->statusEvaluacion();
                //Declaramos la variable que controla la desactivación del btnEliminar
                $btnEjecutarEvaluacion = "<a style='cursor: pointer;' title='Ver evaluacion' onclick='desarrollarEvaluacion({$object->getId()}, " . '"' . md5('evaluacionDesarrollo.php') . '"' . ");'><span class='material-icons text-primary'>visibility</span></a>";
                if ($object->statusEvaluacion() == 'Disponible') $btnEjecutarEvaluacion = "<a style='cursor: pointer;' title='Desarrollar evaluacion' >
                        <span class='material-icons text-success' data-toggle='modal' data-target='#del_{$object->getId()}'>play_circle_filled</span>
                    </a>";
                //Cargamos una posible evaluación terminada
                $evaluacionEjecucion = new Evaluacion_Ejecucion('id_evaluacion', $object->getId(), "AND id_estudiante = {$estudiante->getId()}", null);
                if ($evaluacionEjecucion->getId() != null) {
                    $calificacion = Evaluacion_Ejecucion::getCalificacion($evaluacionEjecucion->getTotalPreguntas(), $evaluacionEjecucion->getTotalRespuestasCorrectas());
                    $colorCalificacion = Evaluacion_Ejecucion::getColorCalificacion($calificacion);
                } else {
                    $calificacion = '-';
                    $colorCalificacion = 'warning';
                }
                $list .= "
                                <tr>
                                    <th scope='row'>" . ($i + 1) . "</th>
                                    <td>{$object->getNombre()}</td>
                                    <!--<td>{$object->getDescripcion()}</td>-->
                                    <td>{$object->getTema()->getNombre()}</td>
                                    <td>{$object->getFechaInicio()}</td>
                                    <td>{$object->getFechaFin()}</td>
                                    <td class='text-left text-{$object->getColorStatus($statusEvaluacion)}'>{$object->statusEvaluacion()} <span class='text-{$object->getColorStatusEvaluacionEstudiante($object->statusEvaluacionEstudiante($estudiante->getId(), false))}'>({$object->statusEvaluacionEstudiante($estudiante->getId(), true)})</span></td>
                                    <td class='text-center text-$colorCalificacion'>$calificacion</span></td>
                                    <td class='text-center align-middle'>
                                        $btnEjecutarEvaluacion
                                    </td>
                                </tr>
                                <!--DESARROLLAR EVALUACIÓN: {$object->getNombre()}-->
                                <div class='modal fade' id='del_{$object->getId()}' tabindex='-1' role='dialog' aria-labelledby='cardModalCenterTitle_{$object->getId()}' aria-hidden='true'>
                                    <div class='modal-dialog modal-dialog-centered' role='document'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                                <h5 class='modal-title text-primary' id='cardModalCenterTitle_{$object->getId()}'>CONFIRMAR ACCIÓN</h5>
                                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                    <span aria-hidden='true'>&times;</span>
                                                </button>
                                            </div>
                                            <div class='modal-body'>
                                            <p class='text-justify'>Estas a punto de iniciar el desarrollo de la evaluación \"{$object->getNombre()}\", recuerda que puedes salir y entrar de la evaluación las veces que lo requieras. Debes tener encuenta que la evaluación se cerrará automaticamente en la fecha: <b>{$object->getFechaFin()}</b>. Todas las respuestas sin guardar se marcarán automaticamente por una respuesta erronea.<br><br>Suerte!</p>
                                            </div>
                                            <div class='modal-footer'>
                                                <button type='button' class='btn btn-danger' data-dismiss='modal'>Cancelar</button>
                                                <button type='button' class='btn btn-success' onclick='desarrollarEvaluacion({$object->getId()}, " . '"' . md5('evaluacionDesarrollo.php') . '"' . ");'>Iniciar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--END DESARROLLAR EVALUACIÓN: {$object->getNombre()}-->
                ";
            }
            $list .= "
                            </tbody>
                        </table>
                    </div>
                    <div class='col-xl-0'></div>
                </div>
            </div>";
        } else $tm = 16;
        ?>
        <script src="./../../js/estudiante/evaluaciones.js"></script>
        <div class="col-xl-12 h-100 bg-light mt-2 p-0">
            <!--ESTUDIANTES HEADER-->
            <div class="col-xl-12 p-5 bg-secondary text-light">
                <div class="row text-center">
                    <div class="col-xl-2"></div>
                    <div class="col-xl-8 align-self-center">
                        <h5 class="display-4 text-uppercase text-center">EVALUACIONES</h5>
                    </div>
                    <div class="col-xl-2 align-self-center"></div>
                </div>
            </div>
            <!--END ESTUDIANTES HEADER-->
            <!--DATA-->
            <?= $list; ?>
            <!--END DATA-->
        </div>
        <?php
    } else header("Location: ./../../../index.php?tm=-1");
} else $tm = 10;
echo "<input type='hidden' id='toastAction' name='toastAction' value='$tm'>";