<?php
/*
 * Page: contenidosFrm
 * Autor: Anres Geovanny Angulo Botina
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
        $srcImg = "./../../img/not_image.jpg";
        if (isset($_GET['id'])) {
            $nameActionFrm = 'Editar';
            $object = new Tema('id', $_GET['id'], null, null);
            if (file_exists(dirname(__FILE__) . "./../../img/docente/contenidos/{$object->getImg()}")) $srcImg = "./../../img/docente/contenidos/{$object->getImg()}";
        } else {
            $nameActionFrm = 'Agregar';
            $object = new Tema(null, null, null, null);
        }
        ?>
        <div class="col-xl-12 h-100">
            <div class="row h-100">
                <!--HEAD PAGE-->
                <section class="jumbotron text-center w-100 bg-secondary text-light">
                    <div class="container align-items-center">
                        <div class="row align-self-center">
                            <div class="col-xl-2"></div>
                            <div class="col-xl-8 align-self-center">
                                <h3 class="display-4 text-uppercase"><?= $nameActionFrm ?> CONTENIDO</h3>
                            </div>
                            <div class="col-xl-2 align-self-center">
                                <button class="btn btn-outline-light" id="btnAddContenidos" onclick="backPageContent();">
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
                            <form class="was-validated" name="frmContenidos" action="./contenidosUpdate.php" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="txtNombre">Nombre:</label>
                                    <input type="text" class="form-control" id="txtNombre" name="txtNombre" placeholder="Nombre del tema" value="<?= $object->getNombre(); ?>" max="50" required>
                                    <div class="invalid-feedback">Este campo no puede estar vacío.</div>
                                </div>
                                <div class="form-group">
                                    <label for="txtDescripcion">Descripción:</label>
                                    <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="6" maxlength="1000" placeholder="Descripcion del contenido" required><?= $object->getDescripcion(); ?></textarea>
                                    <div class="invalid-feedback">Este campo no puede estar vacío.</div>
                                </div>
                                <div class="form-group">
                                    <label for="img_view">Imagen: </label>
                                    <div class="card bg-transparent border-light mb-3">
                                        <img src="<?= $srcImg; ?>" class="img-fluid p-3 border-light" id="img_view">
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="fileImg" name="fileImg" accept="image/jpeg, .png, .gif" onchange="viewPhoto('#img_view', this, './../../img/not_image.jpg');" required>
                                        <label class="custom-file-label" for="fileImg">Seleccionar imagen</label>
                                        <div class="invalid-feedback">Este campo no puede estar vacío.</div>
                                    </div>
                                </div>
                                <hr class="my-4 bg-light">
                                <div class="form-group">
                                    <input type="hidden" name="method" value="<?= $nameActionFrm; ?>">
                                    <input type="hidden" name="id" value="<?= $object->getId(); ?>">
                                    <button class="btn btn-danger" id="btnCancelFrm" type="button" name="btnCancelFrm" onclick="backPageContent();">Cancelar</button>
                                    <!--<button class="btn btn-warning" id="btnCancelFrm" type="reset" name="btnLimpiarFrm" onclick="refreshImg();viewPhoto('#img_view', null, './../../img/not_image.jpg');">Limpiar</button>-->
                                    <button class="btn btn-warning" id="btnCleanFrm" type="reset" name="btnLimpiarFrm" onclick="viewPhoto('#img_view', null, '<?= $srcImg; ?>');">Limpiar</button>
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