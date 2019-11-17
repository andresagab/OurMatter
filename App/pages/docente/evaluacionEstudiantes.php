<?php
/**
 * @Page evaluacionEstudiantes.php
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
        require_once dirname(__FILE__) . './../../php/Class/Evaluacion.php';
        require_once dirname(__FILE__) . './../../php/Class/Estudiante.php';
        require_once dirname(__FILE__) . './../../php/Class/Evaluacion_Ejecucion.php';

        //Comprobamos que se haya enviado el id de la evaluación
        if (isset($_GET['id'])) {

            //Cargamos la evaluación
            $evaluacion = new Evaluacion('id', $_GET['id'], null, null);
            if ($evaluacion->getId() != null) {

                //Cargamos todas las ejecuciones de la evaluación
                $evaluacionesEjecucion = Evaluacion_Ejecucion::getObjects("id_evaluacion = {$evaluacion->getId()}", 'order by fechafin asc');
                if (count($evaluacionesEjecucion) > 0) {
                    //Abrimos lista
                    $list = "
                    <div class='col-xl-12 bg-light p-5 align-content-center'>
                        <div class='row align-self-center'>
                            <div class='col-xl-1'></div>
                            <div class='col-xl-10 align-self-center table-responsive'>
                                <table class='table table-hover'>
                                    <thead>
                                        <tr>
                                            <th scope='col'>#</th>
                                            <th scope='col'>Estudiante</th>
                                            <th scope='col'>Fecha Finalización</th>
                                            <th scope='col'>Calificación</th>
                                            <th scope='col' class='px-5'>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>";

                    //Llenamos lista
                    for ($i = 0; $i < count($evaluacionesEjecucion); $i++){
                        $object = $evaluacionesEjecucion[$i];
                        //Cargamos el estudiante de la evaluación
                        $estudiante = $object->getEstudiante();

                        //Generamos la calificación de la evaluación realizada por el estudiante
                        $calificacion = Evaluacion_Ejecucion::getCalificacion($object->getTotalPreguntas(), $object->getTotalRespuestasCorrectas());
                        $colorCalificacion = Evaluacion_Ejecucion::getColorCalificacion($calificacion);
                        if ($object->getFechaFin() === null) {
                            $calificacion = 'Pendiente';
                            $object->setFechaFin('Pendiente');
                        }

                        //Generamos el botón que nos permite abrir la retroalimentación del estudiante
                        $btnRetroalimentacion = 'No disponible';
                        if ($object->getEvaluacion()->statusEvaluacionEstudiante($estudiante->getId(), false) === 2) {
                            $btnRetroalimentacion = "<a data-toggle='tooltip' data-placement='bottom' title='Ver retroalimentación' onclick='openRetroalimentacion({$object->getId()}, " . '"' . md5('evaluacionEstudianteRetroalimentacion.php') . '"' . ");'><span class='material-icons text-primary' style='cursor: pointer;'>styles</span></a>";
                        }

                        $list .= "
                                    <tr>
                                        <th scope='row'>" . ($i + 1) . "</th>
                                        <td>{$estudiante->getNombres()} {$estudiante->getApellidos()}</td>
                                        <td>{$object->getFechaFin()}</td>
                                        <td class='text-$colorCalificacion'>$calificacion</td>
                                        <td class='text-center align-middle'>
                                            $btnRetroalimentacion
                                        </td>
                                    </tr>
                    ";
                    }

                    //Cerramos lista
                    $list .= "
                                    </tbody>
                                </table>
                            </div>
                            <div class='col-xl-1'></div>
                        </div>
                    </div>";
                } else {
                    $list = "
                    <div class='col-xl-12 bg-light p-5 align-content-center'>
                        <div class='alert alert-warning text-center'><h5>Aún no se han registrado respuestas, intentalo mas tarde.</h5></div>
                    </div>
                    ";
                }

            } else header("Location: ./home.php?pg=2&tm=11");


        } else header("Location: ./home.php?pg=2&tm=11");
        ?>
        <script src="./../../js/docente/evaluacionEstudiantes.js"></script>
        <div class="col-xl-12 h-100 bg-light mt-2 p-0">
            <!--EVALUACION INFO-->
            <div class="col-xl-12 bg-secondary p-5 text-light">
                <div class="row">
                    <div class="col-md-0 col-lg-2"></div>
                    <div class="col-sm-12 col-md-12 col-lg-8 text-center">
                        <h5 class="display-4 text-uppercase text-center text-break"><?= $evaluacion->getNombre(); ?></h5>
                        <h3 class="text-uppercase text-center text-break font-weight-normal pt-3"><?= $evaluacion->getTema()->getNombre(); ?></h3>
                        <p class="text-center pt-3"><?= $evaluacion->getDescripcion(); ?></p>
                    </div>
                    <div class="col-md-0 col-lg-2 align-self-center text-center text-md-center text-lg-right pt-5 pt-sm-3 pt-md-3">
                        <button class="btn btn-outline-light text-center" id="btnBackParentPage" onclick="backPrincipalPage(<?= $evaluacion->getId() ?>, '<?= md5('evaluacionDesarrollo.php') ?>');">
                            <span class="">Regresar <i class="material-icons align-middle">arrow_back</i></span>
                        </button>
                    </div>
                </div>
            </div>
            <!--END EVALUACION INFO-->
            <!--DATA-->
            <?= $list; ?>
            <!--END DATA-->
        </div>
        <?php
    } else header("Location: ./../../../index.php?tm=-1");
} else $tm = 10;
echo "<input type='hidden' id='toastAction' name='toastAction' value='$tm'>";