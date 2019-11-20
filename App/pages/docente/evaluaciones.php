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
        require_once dirname(__FILE__) . './../../php/Class/Tema.php';
        require_once dirname(__FILE__) . './../../php/Class/Evaluacion.php';

        //Cargamos todos los registros
        $data = Evaluacion::getObjects(null, 'order by fechafin desc');
        $list = '';
        //Comprobamos que hayan registros, de no haber ninguno establecemos el valor correspondiente a la variable toast
        if (count($data) > 0){
            $list = "
            <div class='col-xl-12 bg-light p-5 align-content-center'>
                <div class='row align-self-center'>
                    <div class='col-xl-1'></div>
                    <div class='col-xl-10 align-self-center table-responsive'>
                        <table class='table table-hover'>
                            <thead>
                                <tr>
                                    <th scope='col'>#</th>
                                    <th scope='col'>Evaluacion</th>
                                    <th scope='col'>Descripción</th>
                                    <th scope='col'>Tema</th>
                                    <th scope='col'>Fecha inicio</th>
                                    <th scope='col'>Fecha fin</th>
                                    <th scope='col' class='px-5'>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>";
            for ($i = 0; $i < count($data); $i++){
                $object = $data[$i];
                //Declaramos la variable que controla la desactivación del btnEliminar
                $btnDelete = ['disabled', 'invisible'];
                if ($object->canDelete()) $btnDelete = ['', 'visible'];
                //Generamos el botón que permite visualizar a los estudiantes que han resuelto la evaluación
                $btnEstudiantes = '';
                if ($object->studentsAnswered()) $btnEstudiantes = "<a data-toggle='tooltip' data-placement='bottom' title='Ver estudiantes' onclick='openEvaluacionEstudiantes({$object->getId()}, " . '"' . md5('evaluacionEstudiantes.php') . '"' . ");'><span class='material-icons text-warning' style='cursor: pointer;'>supervisor_account</span></a>";
                $list .= "
                                <tr>
                                    <th scope='row'>" . ($i + 1) . "</th>
                                    <td>{$object->getNombre()}</td>
                                    <td>{$object->getDescripcion()}</td>
                                    <td>{$object->getTema()->getNombre()}</td>
                                    <td>{$object->getFechaInicio()}</td>
                                    <td>{$object->getFechaFin()}</td>
                                    <td class='text-center align-middle'>
                                        <a data-toggle='tooltip' data-placement='bottom' title='Abrir' onclick='openEvaluacion({$object->getId()}, " . '"' . md5('preguntasEvaluacion.php') . '"' . ");'>
                                            <span class='material-icons text-primary' style='cursor: pointer;'>open_in_new</span>
                                        </a>
                                        <a data-toggle='tooltip' data-placement='bottom' title='Editar' onclick='openFrm({$object->getId()}, " . '"' . md5('evaluacionesFrm.php') . '"' . ");'>
                                            <span class='material-icons text-success' style='cursor: pointer;'>edit</span>
                                        </a>
                                        $btnEstudiantes
                                        <a class='{$btnDelete[1]}' data-toggle='tooltip' data-placement='bottom' title='Eliminar' {$btnDelete[0]}>
                                            <span class='material-icons text-danger {$btnDelete[1]}' style='cursor: pointer;' data-toggle='modal' data-target='#del_{$object->getId()}'>delete</span>
                                        </a>
                                    </td>
                                </tr>
                                <!--DIALOG DELETE REGISTRO ID: {$object->getNombre()}-->
                                <div class='modal fade' id='del_{$object->getId()}' tabindex='-1' role='dialog' aria-labelledby='cardModalCenterTitle_{$object->getId()}' aria-hidden='true'>
                                    <div class='modal-dialog modal-dialog-centered' role='document'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                                <h5 class='modal-title' id='cardModalCenterTitle_{$object->getId()}'>ELIMINAR REGISTRO</h5>
                                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                    <span aria-hidden='true'>&times;</span>
                                                </button>
                                            </div>
                                            <div class='modal-body'>
                                            <p class='text-justify'>¿Esta seguro de eliminar la evaluación: <span class='text-uppercase font-weight-bold'>{$object->getNombre()}</span>?</p>
                                            </div>
                                            <div class='modal-footer'>
                                                <button type='button' class='btn btn-danger' data-dismiss='modal'>Cancelar</button>
                                                <button type='button' class='btn btn-success' onclick='deleteRecord({$object->getId()});'>Eliminar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--END DIALOG DELETE REGISTRO ID: {$object->getNombre()}-->
                ";
            }
            $list .= "
                            </tbody>
                        </table>
                    </div>
                    <div class='col-xl-1'></div>
                </div>
            </div>";
        } else {
            $tm = 16;
            $list = '<div class="col-xl-12 p-5"><div class="alert alert-warning text-center text-break"><h5 class="font-weight-lighter">Aún no se han registrado evaluaciones.</h5></div></div>';
        }
        ?>
        <script src="./../../js/docente/evaluaciones.js"></script>
        <div class="col-xl-12 h-100 bg-light mt-2 p-0">
            <!--ESTUDIANTES HEADER-->
            <div class="col-xl-12 p-5 bg-secondary text-light">
                <div class="row text-center">
                    <div class="col-xl-2"></div>
                    <div class="col-xl-8 align-self-center">
                        <h5 class="display-4 text-uppercase text-center">EVALUACIONES</h5>
                    </div>
                    <div class="col-xl-2 align-self-center">
                        <button class="btn btn-outline-light text-center" id="btnAddContenidos" onclick="openFrm(null, '<?= md5('evaluacionesFrm.php') ?>');">
                            <span class="">Agregar <i class="material-icons align-middle">add</i></span>
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