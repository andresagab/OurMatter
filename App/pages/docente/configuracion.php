<?php
/*
 * $tm = 0 : No hay errores o informes.
 * $tm = 1 : No existe la variable correspondiente a la sesión del usuario, no se puede cargar la página solicitada.
 * */
include_once dirname(__FILE__) . './../../php/Scripts/session_manager.php';
$tm = 0;
if ($session) {
    if (strtolower(@$USUARIO['typeUser']) == 'docente') {
        ?>
        <div class="col-xl-12 h-100">
            <div class="row h-100">
                <div class="col-xl-12 align-self-center pt-5 pb-5">
                    <h3 class="display-4 text-center text-light">CONFIGURACIÓN</h3>
                </div>
                <!--<div class="accordion w-100 pl-5 pr-5" id="accordionConfig">-->
                <div class="accordion w-100 pl-md-5 pl-3 pr-3 pl-sm-3 pr-sm-3 pr-md-5 pl-xl-5 pr-xl-5" id="accordionConfig">
                    <!--GENERAL-->
                    <div class="card bg-secondary border-light text-light">
                            <div class="card-header bg-secondary border-secondary" id="headingOne">
                                <a role="button" data-toggle="collapse" data-target="#cardGeneral" aria-expanded="true" aria-controls="cardGeneral">
                                    <h3 class="text-normal">GENERAL</h3>
                                </a>
                            </div>
                            <div class="collapse" id="cardGeneral" aria-label="headingOne" data-parent="#accordionConfig">
                                <form class="was-validated" id="frmGeneral">
                                    <div class="card-body pl-md-5 pr-md-5 pl-xl-5 pr-xl-5">
                                        <div class="row">
                                            <div class="col-xl-6 align-self-center">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="inputGroupNombreInstitucion">Nombre institución: </span>
                                                        </div>
                                                        <input type="text" class="form-control" id="txtNameInstitucion" aria-describedby="inputGroupNombreInstitucion" required>
                                                        <div class="invalid-tooltip">
                                                            El campo esta vacío o es invalido.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 align-self-center">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="inputGroupGrado">Grado: </span>
                                                        </div>
                                                        <input type="number" class="form-control" id="txtGrado" aria-describedby="inputGroupGrado" min="0" max="11" required>
                                                        <div class="invalid-tooltip">
                                                            El campo esta vacío o es invalido.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-secondary border-light text-right">
                                        <button class="btn btn-danger" id="btnGeneralCancel" type="button" data-toggle="collapse" data-target="#cardGeneral" aria-expanded="true" aria-controls="cardGeneral">Cancelar</button>
                                        <button class="btn btn-success" id="btnGeneralSave" type="button">Guardar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <!--END GENERAL-->
                    <!--DOCENTE-->
                    <div class="card bg-secondary border-light text-light">
                        <div class="card-header bg-secondary border-secondary" id="headingTwo">
                            <a role="button" data-toggle="collapse" data-target="#cardDocente" aria-expanded="true" aria-controls="cardDocente">
                                <h3 class="text-normal">DOCENTE</h3>
                            </a>
                        </div>
                        <div class="collapse" id="cardDocente" aria-label="headingTwo" data-parent="#accordionConfig">
                            <form class="was-validated" id="frmDocente" novalidate enctype="multipart/form-data">
                                <div class="card-body pl-md-5 pr-md-5 pl-xl-5 pr-xl-5">
                                    <div class="row">
                                        <div class="col-xl-6 align-self-center">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="inputGroupNombreDocente">nombre: </span>
                                                    </div>
                                                    <input type="text" class="form-control" id="txtNameDocente" aria-describedby="inputGroupNombreDocente" required>
                                                    <div class="invalid-tooltip">Este campo no puede estar vacío.</div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="inputGroupEmailDocente">Email: </span>
                                                    </div>
                                                    <input type="text" class="form-control" id="txtEmailDocente" aria-describedby="inputGroupEmailDocente" required>
                                                    <div class="invalid-tooltip">Este campo no puede estar vacío.</div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="inputGroupCelDocente">Celular: </span>
                                                    </div>
                                                    <input type="text" class="form-control" id="txtCelDocente" aria-describedby="inputGroupCelDocente" maxlength="15" required>
                                                    <div class="invalid-tooltip">Este campo no puede estar vacío.</div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="fotoDocente" accept="image/jpeg, .png, .gif">
                                                    <label class="custom-file-label" for="fotoDocente">Seleccionar imagen</label>
                                                </div>
                                                <div class="invalid-tooltip">Este campo no puede estar vacío.</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label for="fotoDocente">Foto: </label>
                                                <div class="card bg-transparent border-light mb-3">
                                                    <img src="" class="img-fluid p-3 border-light" id="foto_Docente">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-secondary border-light text-right">
                                    <button class="btn btn-danger" id="btnDocenteCancel" type="button" data-toggle="collapse" data-target="#cardDocente" aria-expanded="true" aria-controls="cardDocente">Cancelar</button>
                                    <button class="btn btn-success" id="btnDocenteSave" type="button">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--END DOCENTE-->
                    <!--MATERIA-->
                    <div class="card bg-secondary border-light text-light">
                        <div class="card-header bg-secondary border-secondary" id="headingThree">
                            <a role="button" data-toggle="collapse" data-target="#cardMateria" aria-expanded="true" aria-controls="cardMateria">
                                <h3 class="text-normal">MATERIA</h3>
                            </a>
                        </div>
                        <div class="collapse" id="cardMateria"aria-label="headingThree" data-parent="#accordionConfig">
                            <form id="frmMateria" novalidate enctype="multipart/form-data">
                                <div class="card-body pl-md-5 pr-md-5 pl-xl-5 pr-xl-5">
                                    <div class="row">
                                        <div class="col-xl-12 align-self-center">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="inputGroupNombreMateria">Nombre: </span>
                                                    </div>
                                                    <input type="text" class="form-control" id="txtNameMateria" aria-describedby="inputGroupNombreMateria" required>
                                                    <div class="invalid-feedback">Este campo no puede estar vacío.</div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="inputGroupDescMateria">Descripción: </span>
                                                    </div>
                                                    <textarea class="form-control" id="txtDescripcionMateria" rows="10" maxlength="1000" aria-describedby="inputGroupDescMateria"></textarea>
                                                    <div class="invalid-feedback">Este campo no puede estar vacío.</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label for="imgPrincipal">Imagen principal: </label>
                                                <div class="card bg-transparent border-light mb-3">
                                                    <img src="" class="img-fluid p-3 border-light" id="img_principal">
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="imgPrincipal" accept="image/jpeg, .png, .gif">
                                                    <label class="custom-file-label" for="imgPrincipal">Seleccionar imagen</label>
                                                </div>
                                                <div class="invalid-feedback">Este campo no puede estar vacío.</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label for="imgInformacion">Imagen información: </label>
                                                <div class="card bg-transparent border-light mb-3">
                                                    <img src="" class="img-fluid p-3 border-light" id="img_informacion">
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="imgInformacion" accept="image/jpeg, .png, .gif">
                                                    <label class="custom-file-label" for="imgInformacion">Seleccionar imagen</label>
                                                </div>
                                                <div class="invalid-feedback">Este campo no puede estar vacío.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-secondary border-light text-right">
                                    <button class="btn btn-danger" id="btnMateriaCancel" type="button" data-toggle="collapse" data-target="#cardMateria" aria-expanded="true" aria-controls="cardMateria">Cancelar</button>
                                    <button class="btn btn-success" id="btnMateriaSave" type="button">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--MATERIA-->
                </div>
            </div>
        </div>
        <?php
    } else header("Location: ./../../../index.php?tm=-1");
} else $tm = 10;
echo "<input type='hidden' id='toastAction' name='toastAction' value='$tm'>";