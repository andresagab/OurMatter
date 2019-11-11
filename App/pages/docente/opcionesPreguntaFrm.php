<?php
/**
 * @Page opcionesPreguntaFrm
 * @Autor Anres Geovanny Angulo Botina
 * @email andrescabj98@gmail.com
 * $tm = 0 : No hay errores o informes.
 * $tm = 1 : No existe la variable correspondiente a la sesión del usuario, no se puede cargar la página solicitada.
 * */
include_once dirname(__FILE__) . './../../php/Scripts/session_manager.php';
$tm = 0;
if ($session) {
    if (strtolower(@$USUARIO['typeUser']) == 'docente') {
        include_once dirname(__FILE__) . './../../php/Scripts/general_funcitons.php';
        require_once dirname(__FILE__) . './../../php/Class/Conector.php';
        require_once dirname(__FILE__) . './../../php/Class/Tema.php';
        require_once dirname(__FILE__) . './../../php/Class/Evaluacion.php';
        require_once dirname(__FILE__) . './../../php/Class/Evaluacion_Pregunta.php';
        require_once dirname(__FILE__) . './../../php/Class/Evaluacion_Opcion.php';
        //Comprobamos que el id del tema y la pregunta hayan sido enviados
        if (isset($_GET['idP']) && isset($_GET['id'])) {
            //Cargamos el objeto evaluacion y pregunta
            $evaluacion = new Evaluacion('id', $_GET['idP'], null, null);
            $pregunta = new Evaluacion_Pregunta('id', $_GET['id'], null, null);
            //Cargamos todas las opciones de respuestas asignadas al objeto pregunta
            $objects = Evaluacion_Opcion::getObjects("id_evaluacionPregunta = {$pregunta->getId()}", 'order by id asc');
            //Definimos el tipo de acción que se va a ejecutar, si tenemos datos la acción es editar en caso contrario será agregar
            if (count($objects) > 0 && count($objects) <= 4) {
                $nameActionFrm = 'Editar';
                $inputsID = "<input type='hidden' name='opcionesId' value='{$objects[0]->getId()}_{$objects[1]->getId()}_{$objects[2]->getId()}_{$objects[3]->getId()}'>";
            } else {
                $nameActionFrm = 'Agregar';
                $inputsID = '';
                $objects[0] = new Evaluacion_Opcion(null, null, null, null);
                $objects[1] = new Evaluacion_Opcion(null, null, null, null);
                $objects[2] = new Evaluacion_Opcion(null, null, null, null);
                $objects[3] = new Evaluacion_Opcion(null, null, null, null);
            }
        } else header('Location: ./home.php?pg=2&tm=11');
        ?>
        <script src="./../../js/docente/opcionesPreguntaFrm.js"></script>
        <!--HEAD PAGE-->
        <div class="col-xl-12 p-5 bg-secondary text-light">
            <div class="row text-center">
                <div class="col-xl-2"></div>
                <div class="col-xl-8 align-self-center">
                    <h1 class="text-uppercase font-weight-normal text-break"><?= $nameActionFrm ?> OPCIONES DE RESPUESTA</h1>
                    <h4 class="text-uppercase font-weight-normal text-break"><?= $pregunta->getPregunta(); ?></h4>
                    <h5 class="text-uppercase font-weight-normal"><?= $evaluacion->getTema()->getNombre(); ?></h5>
                </div>
                <div class="col-xl-2 align-self-center">
                    <button class="btn btn-outline-light" id="btnAddContenidos" onclick="backPageContentParent(<?= $evaluacion->getId() ?>, '<?= md5('preguntasEvaluacion.php') ?>');">
                        <span class="">Regresar <i class="material-icons align-middle">add</i></span>
                    </button>
                </div>
            </div>
        </div>
        <!--END HEAD PAGE-->
        <div class="col-xl-12 h-100 pt-5 bg-light">
            <div class="row bg-light">
                <!--FORM-->
                <div class="col-xl-12 align-items-center">
                    <div class="row">
                        <div class="col-md-1 col-xl-3"></div>
                        <div class="col-md-10 col-xl-6 card bg-light border-light mb-5 mb-sm-5 mx-3 mx-sm-3 p-4 p-sm-5">
                            <form class="was-validated" name="frmOpcionesPregunta" action="./opcionesPreguntaUpdate.php" method="POST">
                                <?= $inputsID; ?>
                                <div class="form-group">
                                    <div class="custom-control custom-radio pb-2">
                                        <input type="radio" id="question_1" name="radioCorrecta" class="custom-control-input" value="1" <?= $objects[0]->getCheckedRadioHtml(); ?> required>
                                        <label class="custom-control-label" for="question_1">1. Opcion de respuesta: </label>
                                    </div>
                                    <textarea class="form-control" id="txtOpcion_1" name="txtOpcion_1" rows="3" maxlength="500" placeholder="Opción de respuesta 1" required><?= $objects[0]->getOpcion(); ?></textarea>
                                    <div class="invalid-feedback">Este campo no puede estar vacío.</div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-radio pb-2">
                                        <input type="radio" id="question_2" name="radioCorrecta" class="custom-control-input" value="2" <?= $objects[1]->getCheckedRadioHtml(); ?> required>
                                        <label class="custom-control-label" for="question_2">2. Opcion de respuesta: </label>
                                    </div>
                                    <textarea class="form-control" id="txtOpcion_2" name="txtOpcion_2" rows="3" maxlength="500" placeholder="Opción de respuesta 2" required><?= $objects[1]->getOpcion(); ?></textarea>
                                    <div class="invalid-feedback">Este campo no puede estar vacío.</div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-radio pb-2">
                                        <input type="radio" id="question_3" name="radioCorrecta" class="custom-control-input" value="3" <?= $objects[2]->getCheckedRadioHtml(); ?> required>
                                        <label class="custom-control-label" for="question_3">3. Opcion de respuesta: </label>
                                    </div>
                                    <textarea class="form-control" id="txtOpcion_3" name="txtOpcion_3" rows="3" maxlength="500" placeholder="Opción de respuesta 3" required><?= $objects[2]->getOpcion(); ?></textarea>
                                    <div class="invalid-feedback">Este campo no puede estar vacío.</div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-radio pb-2">
                                        <input type="radio" id="question_4" name="radioCorrecta" class="custom-control-input" value="4" <?= $objects[3]->getCheckedRadioHtml(); ?> required>
                                        <label class="custom-control-label" for="question_4">4. Opcion de respuesta: </label>
                                    </div>
                                    <textarea class="form-control" id="txtOpcion_4" name="txtOpcion_4" rows="3" maxlength="500" placeholder="Opción de respuesta 4" required><?= $objects[3]->getOpcion(); ?></textarea>
                                    <div class="invalid-feedback">Este campo no puede estar vacío.</div>
                                </div>
                                <hr class="my-4 bg-light">
                                <div class="form-group">
                                    <input type="hidden" name="method" value="<?= $nameActionFrm; ?>">
                                    <input type="hidden" name="idP" value="<?= $evaluacion->getId(); ?>">
                                    <input type="hidden" name="id" value="<?= $pregunta->getId(); ?>">
                                    <button class="btn btn-danger" id="btnCancelFrm" type="button" name="btnCancelFrm" onclick="backPageContentParent(<?= $evaluacion->getId() ?>, '<?= md5('preguntasEvaluacion.php') ?>');">Cancelar</button>
                                    <button class="btn btn-warning" id="btnCleanFrm" type="reset" name="btnLimpiarFrm">Limpiar</button>
                                    <button class="btn btn-success" id="btnAcceptFrm" type="submit" name="btnAcceptFrm">Aceptar</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-1 col-xl-3"></div>
                    </div>
                </div>
                <!--END FORM-->
            </div>
        </div>
        <?php
    } else header("Location: ./../../../index.php?tm=-1");
} else $tm = 10;
echo "<input type='hidden' id='toastAction' name='toastAction' value='$tm'>";