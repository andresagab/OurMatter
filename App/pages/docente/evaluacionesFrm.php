<?php
/**
 * @Page evaluacionesFrm
 * @Autor Anres Geovanny Angulo Botina
 * @email andrescabj98@gmail.com
 * $tm = 0 : No hay errores o informes.
 * $tm = 1 : No existe la variable correspondiente a la sesión del usuario, no se puede cargar la página solicitada.
 * */
include_once dirname(__FILE__) . './../../php/Scripts/session_manager.php';
$tm = 0;
if ($session) {
    if (strtolower(@$USUARIO['typeUser']) == 'docente') {
        date_default_timezone_set("America/Bogota");
        include_once dirname(__FILE__) . './../../php/Scripts/general_funcitons.php';
        require_once dirname(__FILE__) . './../../php/Class/Conector.php';
        require_once dirname(__FILE__) . './../../php/Class/Tema.php';
        require_once dirname(__FILE__) . './../../php/Class/Evaluacion.php';
        //Creamos la variable que almacenara el valor de las fechas de un objeto que será editado
        $dates = '';
        //Comprobamos que el id del objeto que se desea editar exista
        if (isset($_GET['id'])) {
            $nameActionFrm = 'Editar';
            $object = new Evaluacion('id', $_GET['id'], null, null);
            $nextId = $object->getId();
            $dates = "
            <input id='prevFI' type='hidden' value='{$object->getFechaInicio()}'>;
            <input id='prevFF' type='hidden' value='{$object->getFechaFin()}'>;
            ";
        } else {
            $nameActionFrm = 'Agregar';
            $object = new Evaluacion(null, null, null, null);
        }
        ?>
        <script src="./../../js/docente/evaluacionesFrm.js"></script>
        <div class="col-xl-12 h-100">
            <div class="row h-100">
                <!--HEAD PAGE-->
                <section class="jumbotron text-center w-100 bg-secondary text-light">
                    <div class="container align-items-center">
                        <div class="row align-self-center">
                            <div class="col-xl-2"></div>
                            <div class="col-xl-8 align-self-center">
                                <h3 class="display-4 text-uppercase"><?= $nameActionFrm ?> EVALUACIÓN</h3>
                            </div>
                            <div class="col-xl-2 align-self-center">
                                <button class="btn btn-outline-light" id="btnAddContenidos" onclick="backPage();">
                                    <span class="">Regresar <i class="material-icons align-middle">add</i></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </section>
                <!--END HEAD PAGE-->
                <!--FORM-->
                <?= $dates; ?>
                <div class="col-xl-12 align-items-center">
                    <div class="row">
                        <div class="col-md-1 col-xl-3"></div>
                        <div class="col-md-10 col-xl-6 card bg-transparent border-light mb-5 mb-sm-5 mx-3 mx-sm-3 p-4 p-sm-5 text-light">
                            <form class="was-validated" name="frmContenidos" action="./evaluacionesUpdate.php" method="POST">
                                <div class="form-group">
                                    <label for="txtIdTema">Temas:</label>
                                    <?= getDataInSelectHTML('tema', 'nombre', 'id', null, 'order by nombre asc', 'txtIdTema', $object->getIdTema()); ?>
                                    <div class="invalid-feedback">Este campo no puede estar vacío.</div>
                                </div>
                                <div class="form-group">
                                    <label for="txtNombres">Nombre:</label>
                                    <input type="text" class="form-control" id="txtNombre" name="txtNombre" placeholder="Nombre de la evaluación" value="<?= $object->getNombre(); ?>" max="100" required>
                                    <div class="invalid-feedback">Este campo no puede estar vacío.</div>
                                </div>
                                <div class="form-group">
                                    <label for="txtDescripcion">Descripción:</label>
                                    <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="4" maxlength="300" placeholder="Descripcion de la evaluación" required><?= $object->getDescripcion(); ?></textarea>
                                    <div class="invalid-feedback">Este campo no puede estar vacío.</div>
                                </div>
                                <div class="form-group">
                                    <label for="txtFechaInicio">Fecha de inicio (MM/DD/AAAA HH:mm AM/PM):</label>
                                    <input type="datetime-local" class="form-control" id="txtFechaInicio" name="txtFechaInicio" value=""  required onchange="validDates();">
                                    <div class="invalid-feedback">Este campo es obligatorio.</div>
                                </div>
                                <div class="form-group">
                                    <label for="txtFechaFin">Fecha de fin (MM/DD/AAAA HH:mm AM/PM):</label>
                                    <input type="datetime-local" class="form-control" id="txtFechaFin" name="txtFechaFin" value=""  required onchange="validDates();">
                                    <div class="invalid-feedback">Este campo es obligatorio.</div>
                                </div>
                                <hr class="my-4 bg-light">
                                <div class="form-group">
                                    <input type="hidden" name="method" value="<?= $nameActionFrm; ?>">
                                    <input type="hidden" name="id" value="<?= $object->getId(); ?>">
                                    <button class="btn btn-danger" id="btnCancelFrm" type="button" name="btnCancelFrm" onclick="backPage();">Cancelar</button>
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