<?php
/**
 * @Page preguntasEvaluacionFrm
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
        //Comprobamos que el id del objeto padre haya sido enviado
        if (isset($_GET['idP'])) {
            //Cargamos el objeto padre y comprobamos que el registro sea valido
            $objectParent = new Evaluacion('id', $_GET['idP'], null, null);
            if ($objectParent->getId() != null) {
                //Comprobamos que el id del objeto que se desea editar exista
                if (isset($_GET['id'])) {
                    $nameActionFrm = 'Editar';
                    $object = new Evaluacion_Pregunta('id', $_GET['id'], null, null);
                } else {
                    $nameActionFrm = 'Agregar';
                    $object = new Evaluacion_Pregunta(null, null, null, null);
                }
            } else header('Location: ./home.php?pg=2&tm=11');
        } else header('Location: ./home.php?pg=2&tm=11');
        ?>
        <script src="./../../js/docente/preguntasEvaluacionFrm.js"></script>
        <!--HEAD PAGE-->
        <div class="col-xl-12 p-5 bg-secondary text-light">
            <div class="row text-center">
                <div class="col-xl-2"></div>
                <div class="col-xl-8 align-self-center">
                    <h3 class="display-4 text-uppercase"><?= $nameActionFrm ?> PREGUNTA</h3>
                    <h4 class="text-uppercase font-weight-normal"><?= $objectParent->getNombre(); ?></h4>
                    <h5 class="text-uppercase font-weight-normal"><?= $objectParent->getTema()->getNombre(); ?></h5>
                </div>
                <div class="col-xl-2 align-self-center">
                    <button class="btn btn-outline-light" id="btnAddContenidos" onclick="backPageContentParent(<?= $objectParent->getId() ?>, '<?= md5('preguntasEvaluacion.php') ?>');">
                        <span class="">Regresar <i class="material-icons align-middle">add</i></span>
                    </button>
                </div>
            </div>
        </div>
        <!--END HEAD PAGE-->
        <div class="col-xl-12 h-100 pt-5">
            <div class="row h-100">
                <!--FORM-->
                <div class="col-xl-12 align-items-center">
                    <div class="row">
                        <div class="col-md-1 col-xl-3"></div>
                        <div class="col-md-10 col-xl-6 card bg-transparent border-light mb-5 mb-sm-5 mx-3 mx-sm-3 p-4 p-sm-5 text-light">
                            <form class="was-validated" name="frmContenidos" action="./preguntasEvaluacionUpdate.php" method="POST">
                                <div class="form-group">
                                    <label for="txtPregunta">Pregunta:</label>
                                    <textarea class="form-control" id="txtPregunta" name="txtPregunta" rows="6" maxlength="1000" placeholder="Pregunta para el tema: <?= $objectParent->getTema()->getNombre(); ?>" required><?= $object->getPregunta(); ?></textarea>
                                    <div class="invalid-feedback">Este campo no puede estar vacío.</div>
                                </div>
                                <hr class="my-4 bg-light">
                                <div class="form-group">
                                    <input type="hidden" name="method" value="<?= $nameActionFrm; ?>">
                                    <input type="hidden" name="idP" value="<?= $objectParent->getId(); ?>">
                                    <input type="hidden" name="id" value="<?= $object->getId(); ?>">
                                    <button class="btn btn-danger" id="btnCancelFrm" type="button" name="btnCancelFrm" onclick="backPageContentParent(<?= $objectParent->getId() ?>, '<?= md5('preguntasEvaluacion.php') ?>');">Cancelar</button>
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