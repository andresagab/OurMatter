<?php
/**
 * @Page estudiantesFrm
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
        require_once dirname(__FILE__) . './../../php/Class/Estudiante.php';
        //Comprobamos que el id del objeto que se desea editar exista
        $nextId = getLastID('estudiante', 'id') + 1;
        if (isset($_GET['id'])) {
            $nameActionFrm = 'Editar';
            $object = new Estudiante('id', $_GET['id'], null, null);
            $nextId = $object->getId();
        } else {
            $nameActionFrm = 'Agregar';
            $object = new Estudiante(null, null, null, null);
        }
        ?>
        <script src="./../../js/docente/estudiantesFrm.js"></script>
        <div class="col-xl-12 h-100">
            <div class="row h-100">
                <!--HEAD PAGE-->
                <section class="jumbotron text-center w-100 bg-secondary text-light">
                    <div class="container align-items-center">
                        <div class="row align-self-center">
                            <div class="col-xl-2"></div>
                            <div class="col-xl-8 align-self-center">
                                <h3 class="display-4 text-uppercase"><?= $nameActionFrm ?> ESTUDIANTE</h3>
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
                <div class="col-xl-12 align-items-center">
                    <div class="row">
                        <div class="col-md-1 col-xl-3"></div>
                        <div class="col-md-10 col-xl-6 card bg-transparent border-light mb-5 mb-sm-5 mx-3 mx-sm-3 p-4 p-sm-5 text-light">
                            <form class="was-validated" name="frmContenidos" action="./estudiantesUpdate.php" method="POST">
                                <div class="form-group">
                                    <label for="txtNombres">Nombres:</label>
                                    <input type="text" class="form-control" id="txtNombres" name="txtNombres" placeholder="Nombres del estudiante" value="<?= $object->getNombres(); ?>" max="30" required onkeyup="generateUserName(<?= $nextId; ?>);">
                                    <div class="invalid-feedback">Este campo no puede estar vacío.</div>
                                </div>
                                <div class="form-group">
                                    <label for="txtApellidos">Apellidos:</label>
                                    <input type="text" class="form-control" id="txtApellidos" name="txtApellidos" placeholder="Apellidos del estudiante" value="<?= $object->getApellidos(); ?>" max="30" min="3" required onkeyup="generateUserName(<?= $nextId; ?>);">
                                    <div class="invalid-feedback">Este campo no puede estar vacío.</div>
                                </div>
                                <div class="form-group">
                                    <label for="txtUsuario">Usuario:</label>
                                    <input type="text" class="form-control" id="txtUsuario" name="txtUsuario" placeholder="El nombre de usuario se ira generando a medida que digite los campos" value="<?= $object->getUsuario(); ?>" max="30" min="3" required disabled>
                                    <div class="valid-feedback">Este campo se autorellena.</div>
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