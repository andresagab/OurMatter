<?php
/**
 * @Page preguntasEvaluacion
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
        require_once dirname(__FILE__) . './../../php/Class/Evaluacion_Pregunta.php';
        require_once dirname(__FILE__) . './../../php/Class/Evaluacion_Opcion.php';

        //Verificamos que hemos recibido el id del tema o contenido padre
        if (isset($_GET['idP'])) {
            $objectParent = new Evaluacion('id', $_GET['idP'], null, null);
            //Verificamos que el objeto cargado sea diferente de null
            if ($objectParent->getId() != null) {
                //Cargamos y presentamos todos los subtemas o subcontenidos del contenido que se ha abierto.
                $data = Evaluacion_Pregunta::getObjects("id_evaluacion={$objectParent->getId()}", "order by id asc");
                $list = '';
                if (count($data) > 0) {
                    //Declaramos la variable que controla la desactivación del btnEliminar
                    $btnDelete = ['disabled', 'invisible'];
                    $list .= '
                    <div class="col-xl-12 pb-5 bg-light">
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">';
                    $alignItem = false;//False alineado a la derecha, True alineado a la izquierda.
                    for ($i = 0; $i < count($data); $i++){
                        $object = $data[$i];
                        //Declaramos la ruta de la imagen del objeto cargado
                        if ($object->canDelete()) $btnDelete = ['', 'visible'];
                        $list .= "
                        <div class='row'>
                            <div class='col-12'>
                                <hr class='my-4'>
                            </div>
                            <div class='col-md-12 align-self-center'>
                                <div class='card bg-light border-light h-100 align-middle'>
                                    <div class='card-body'>
                                        <h3 class='card-title text-uppercase'>{$object->getPregunta()}</h3>
                                        <h6 class='card-subtitle mb-2 text-muted'>Alternativas de respuesta</h6>";
                        /*--------------------------------------------------------------------------------------------*/
                        /*OPCIONES RESPUESTA*/

                        //Cargamos las opciones de respuesta de la pregunta que esta almacenada en $pbject
                        $options = Evaluacion_Opcion::getObjects("id_evaluacionPregunta = {$object->getId()}", null);
                        //Declaramos la alerta de que la pregunta aún no tiene registradas sus opciones de respuesta
                        $alert = '<div class="mt-3 alert alert-warning">Sin opciones de respuesta, no olvides registrarlas!</div>';
                        //Declaramos la variable que permite agregar o editar y borrar las opciones de respuesta
                        //Por defecto definimos la opción agregar.
                        $actions = "
                        <div class='d-flex justify-content-between align-items-center'>
                                <div class='btn-group'>
                                    <button type='button' class='btn btn-sm btn-outline-primary' data-toggle='tooltip' data-placement='bottom' title='Agregar' onclick='openOpcionesFrm({$objectParent->getId()}, {$object->getId()}, " . '"' . md5('opcionesPreguntaFrm.php') . '"' . ");'>
                                        <span class='material-icons align-middle'>add</span>
                                    </button>
                                </div>
                            </div>";
                        //Declaramos la variable que nos controla la acción de eliminar opciones de respuesta
                        $btnDeleteOpciones = ['disabled', 'invisible'];
                        //Evaluamos que hayan opciones registradas
                        if (count($options) > 0 && count($options) <= 4) {
                            $alert = '';
                            if (Evaluacion_Opcion::canDeleteOptions($options)) $btnDeleteOpciones = ['', 'visible'];
                            //Al tener ya las opciones registradas, remplazamos el botón agregaar por los de editar y eliminar
                            $actions = "
                            <div class='d-flex justify-content-between align-items-center'>
                                <div class='btn-group'>
                                    <button type='button' class='btn btn-sm btn-outline-info' data-toggle='tooltip' data-placement='bottom' title='Editar' onclick='openOpcionesFrm({$objectParent->getId()}, {$object->getId()}, " . '"' . md5('opcionesPreguntaFrm.php') . '"' . ");'>
                                        <span class='material-icons align-middle'>edit</span>
                                    </button>
                                    <button type='button' class='btn btn-sm btn-outline-danger <?= $btnDeleteOpciones[1] ?>' data-toggle='modal' data-target='#del_opciones_{$object->getId()}' $btnDeleteOpciones[0]>
                                        <span class='material-icons align-middle' data-toggle='tooltip' data-placement='bottom' title='Eliminar'>delete</span>
                                    </button>
                                </div>
                            </div>
                            <!--DIALOG DELETE OPCIONES PREGUNTA_ID: {$object->getPregunta()}-->
                            <div class='modal fade' id='del_opciones_{$object->getId()}' tabindex='-1' role='dialog' aria-labelledby='cardModalCenterTitle_{$object->getId()}' aria-hidden='true'>
                                <div class='modal-dialog modal-dialog-centered' role='document'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title' id='cardModalCenterTitle_{$object->getId()}'>ELIMINAR REGISTROS</h5>
                                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                <span aria-hidden='true'>&times;</span>
                                            </button>
                                        </div>
                                        <div class='modal-body'>
                                            <div class='alert alert-info'>Recuerde que si desea cambiar una o mas respuestas puede usar la opción de editar.</div>
                                            <h6 class='text-break font-weight-normal'><span class='font-weight-bold'>Pregunta: </span>{$object->getPregunta()}</h6>
                                            <hr class='my-4'>
                                            <p class='text-justify'>¿Esta seguro de eliminar la todas las opciones de respuesta de esta pregunta?</p>
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-danger' data-dismiss='modal'>Cancelar</button>
                                            <button type='button' class='btn btn-success' onclick='deleteRecordsOpciones({$objectParent->getId()}, {$object->getId()});'>Eliminar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--END DIALOG DELETE OPCIONES PREGUNTA_ID: {$object->getPregunta()}-->
                            ";
                            for ($j = 0; $j < count($options); $j++) {
                                $option = $options[$j];
                                $list .= "
                                <p class='card-text'><span class='font-weight-bold'>" . ($j + 1) . "). </span>{$option->getOpcion()}</p>
                                ";
                            }
                        }
                        /*END OPCIONES RESPUESTA*/
                        /*--------------------------------------------------------------------------------------------*/
                        $list .= $alert . "<p class='card-text'><small class='text-muted'>Acciones de respuestas:</small></p> $actions";
                        $list .="
                                    </div>
                                    <div class='card-footer border-light bg-light'>
                                        <p class='card-text'><small class='text-muted'>Acciones de pregunta:</small></p>
                                        <div class='d-flex justify-content-between align-items-center'>
                                            <div class='btn-group'>
                                                <!--<button type='button' class='btn btn-sm btn-outline-primary' data-toggle='tooltip' data-placement='bottom' title='Abrir' onclick=''>
                                                    <span class='material-icons align-middle'>open_in_new</span>
                                                </button>-->
                                                <button type='button' class='btn btn-sm btn-outline-success' data-toggle='tooltip' data-placement='bottom' title='Editar' onclick='openFrm({$objectParent->getId()}, {$object->getId()}, " . '"' . md5('preguntasEvaluacionFrm.php') . '"' . ");'>
                                                    <span class='material-icons align-middle'>edit</span>
                                                </button>
                                                <button type='button' class='btn btn-sm btn-outline-danger <?= $btnDelete[1] ?>' data-toggle='modal' data-target='#del_{$object->getId()}' $btnDelete[0]>
                                                    <span class='material-icons align-middle' data-toggle='tooltip' data-placement='bottom' title='Eliminar'>delete</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>";
                        //Agregamos el cuadro de dialogo que nos permite confirmar la eliminación de un registro
                        $list .="
                        <!--DIALOG DELETE PREGUNTA ID: {$object->getPregunta()}-->
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
                                    <p class='text-justify'>¿Esta seguro de eliminar la pregunta: <span class='text-uppercase font-weight-bold'>{$object->getPregunta()}</span>?</p>
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-danger' data-dismiss='modal'>Cancelar</button>
                                        <button type='button' class='btn btn-success' onclick='deleteRecord({$objectParent->getId()}, {$object->getId()});'>Eliminar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--END DIALOG DELETE PREGUNTA ID: {$object->getPregunta()}-->
                        ";
                        $alignItem = !$alignItem;
                    }
                    $list .= '
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                    </div>';
                } else $tm = 16;
            } else header('Location: ./home.php?pg=1&tm=11');
        } else header('Location: ./home.php?pg=1&tm=11');
        ?>
        <!--EVALUACION INFO-->
        <script src="./../../js/docente/preguntasEvaluacion.js"></script>
        <div class="col-xl-12 bg-secondary p-5 text-light">
            <div class="row">
                <div class="col-md-1 col-lg-2"></div>
                <div class="col-sm-12 col-md-10 col-lg-8 text-center">
                    <h5 class="display-4 text-uppercase text-center text-break"><?= $objectParent->getNombre(); ?></h5>
                    <h3 class="text-uppercase text-center text-break font-weight-normal pt-3"><?= $objectParent->getTema()->getNombre(); ?></h3>
                    <p class="text-center pt-3"><?= $objectParent->getDescripcion(); ?></p>
                    <p class="text-center"><span class="font-weight-bold">Inicio: </span><?= $objectParent->getFechaInicio(); ?></p>
                    <p class="text-center"><span class="font-weight-bold">Fin: </span><?= $objectParent->getFechaFin(); ?></p>
                </div>
                <div class="col-md-1 col-lg-2"></div>
            </div>
        </div>
        <!--END EVALUACION INFO-->
        <!--PREGUNTAS-->
        <div class="col-xl-12 p-5 bg-white">
            <div class="row text-center">
                <div class="col-xl-2"></div>
                <div class="col-xl-8 align-self-center">
                    <h5 class="display-4 text-uppercase text-center">PREGUNTAS</h5>
                </div>
                <div class="col-xl-2 align-self-center">
                    <button class="btn btn-outline-success text-center" id="btnAddPregunta" onclick="openFrm(<?= $objectParent->getId(); ?>, null, '<?= md5('preguntasEvaluacionFrm.php'); ?>')">
                        <span class="">Agregar <i class="material-icons align-middle">add</i></span>
                    </button>
                </div>
            </div>
        </div>
        <?= $list; ?>
        <!--END PREGUNTAS-->
        <?php
    } else header("Location: ./../../../index.php?tm=-1");
} else $tm = 10;
echo "<input type='hidden' id='toastAction' name='toastAction' value='$tm'>";