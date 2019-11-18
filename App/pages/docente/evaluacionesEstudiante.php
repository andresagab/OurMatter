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
    if (strtolower(@$USUARIO['typeUser']) == 'docente') {
        include_once dirname(__FILE__) . './../../php/Scripts/general_funcitons.php';
        require_once dirname(__FILE__) . './../../php/Class/Conector.php';
        require_once dirname(__FILE__) . './../../php/Class/Estudiante.php';
        require_once dirname(__FILE__) . './../../php/Class/Tema.php';
        require_once dirname(__FILE__) . './../../php/Class/Evaluacion.php';
        require_once dirname(__FILE__) . './../../php/Class/Evaluacion_Ejecucion.php';

        if (isset($_GET['id'])) {

            //Cargamos al estudiante por su nombre de usuario
            $estudiante = new Estudiante('id', $_GET['id'], null, null);

            //Comprobamos que el estudiante se haya cargado correctamente
            if ($estudiante->getId() != null) {

                //Cargamos todos los registros
                $data = Evaluacion::getObjects("id IN (SELECT id_evaluacion FROM evaluacion_ejecucion WHERE id_estudiante = {$estudiante->getId()})", 'order by fechafin asc');
                //$data = Evaluacion::getObjects('id IN (select id_evaluacion FROM evaluacion_pregunta WHERE id IN (SELECT id_evaluacionPregunta FROM evaluacion_opcion))', 'order by fechafin asc');
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
                                        <th scope='col'>Tema</th>
                                        <th scope='col'>Fecha inicio</th>
                                        <th scope='col'>Fecha fin</th>
                                        <th scope='col'>Estado</th>
                                        <th scope='col'>Calificación</th>
                                        <th scope='col' class='px-5'>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>";
                $totalNotas = 0;
                for ($i = 0; $i < count($data); $i++){
                    $object = $data[$i];
                    //Cargamos el estado de la evaluacion
                    $statusEvaluacion = $object->statusEvaluacion();

                    //Cargamos una posible evaluación terminada
                    $evaluacionEjecucion = new Evaluacion_Ejecucion('id_evaluacion', $object->getId(), "AND id_estudiante = {$estudiante->getId()}", null);

                    //Habilitamos el botón de retroalimentación solo si la evaluación esta cerrada
                    $btnRetroalimentacion = '';
                    if ($object->statusEvaluacionEstudiante($estudiante->getId(), false) === 2 && $evaluacionEjecucion->getId() != null) $btnRetroalimentacion = "<a style='cursor: pointer;' title='Ver retroalimentación' ><span class='material-icons text-success' onclick='openRetroalimentacion({$evaluacionEjecucion->getId()}, " . '"' . md5('evaluacionEstudianteRetroalimentacion.php') . '"' . ");'>style</span></a>";

                    if ($evaluacionEjecucion->getId() != null) {
                        $calificacion = Evaluacion_Ejecucion::getCalificacion($evaluacionEjecucion->getTotalPreguntas(), $evaluacionEjecucion->getTotalRespuestasCorrectas());
                        $colorCalificacion = Evaluacion_Ejecucion::getColorCalificacion($calificacion);
                        $totalNotas += $calificacion;
                    } else {
                        $calificacion = '-';
                        $colorCalificacion = 'warning';
                    }
                    $list .= "
                                    <tr>
                                        <th scope='row'>" . ($i + 1) . "</th>
                                        <td>{$object->getNombre()}</td>
                                        <td>{$object->getTema()->getNombre()}</td>
                                        <td>{$object->getFechaInicio()}</td>
                                        <td>{$object->getFechaFin()}</td>
                                        <td class='text-left text-{$object->getColorStatus($statusEvaluacion)}'>{$object->statusEvaluacion()} <span class='text-{$object->getColorStatusEvaluacionEstudiante($object->statusEvaluacionEstudiante($estudiante->getId(), false))}'>({$object->statusEvaluacionEstudiante($estudiante->getId(), true)})</span></td>
                                        <td class='text-center text-$colorCalificacion'>$calificacion</span></td>
                                        <td class='text-center align-middle'>
                                            $btnRetroalimentacion
                                        </td>
                                    </tr>
                    ";
                }
                $promedio = round(($totalNotas / count($data)), 1);
                $list .= "
                                    <tr>
                                        <th colspan='6' class='text-right'>Promedio: </th>
                                        <td class='text-center text-". Evaluacion_Ejecucion::getColorCalificacion($promedio) . "'>" . $promedio . "</td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class='col-xl-0'></div>
                    </div>
                </div>";
            } else {
                    $tm = 16;
                    $list = "
                    <div class='col-xl-12 bg-light p-5 align-content-center'>
                        <div class='row align-self-center'>
                            <div class='col-xl-12 align-self-center table-responsive'>
                                <div class='alert alert-warning text-center text-break'><h5 class='font-weight-lighter'>Este estudiante aún no registra desarrollos de evaluaciones.</h5></div>
                            </div>
                        </div>
                    </div>";
                }

            } else header("Location: ./home.php?pg=3&tm=11");


        } else header("Location: ./home.php?pg=3&tm=11");

        ?>
        <script src="./../../js/docente/evaluacionesEstudiante.js"></script>
        <div class="col-xl-12 h-100 bg-light mt-2 p-0">
            <!--ESTUDIANTES HEADER-->
            <div class="col-xl-12 p-5 bg-secondary text-light">
                <div class="row text-center">
                    <div class="col-xl-2"></div>
                    <div class="col-xl-8 align-self-center">
                        <h5 class="display-4 text-uppercase text-center">EVALUACIONES</h5>
                        <h2 class="text-uppercase text-center font-weight-lighter text-break"><?= $estudiante->getNombres(); ?> <?= $estudiante->getApellidos(); ?></h2>
                    </div>
                    <div class="col-xl-2 align-self-center">
                        <button class="btn btn-outline-light text-center" id="btnBackParentPage" onclick="backPrincipalPage();">
                            <span class="">Regresar <i class="material-icons align-middle">arrow_back</i></span>
                        </button>
                    </div>
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