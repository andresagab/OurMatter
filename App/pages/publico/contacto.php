<?php
/**
 * @version Página contacto.php de la sección público
 * @page contacto.php
 * @author Andres Geovanny Angulo Botina
 * @email andrescabj981@gmail.com
 */
//Agregamos los recursos necesarios
require_once dirname(__FILE__) . '.\..\..\php\Scripts\general_funcitons.php';
require_once dirname(__FILE__) . '.\..\..\php\Class\Conector.php';
require_once dirname(__FILE__) . '.\..\..\php\Class\Usuario.php';
require_once dirname(__FILE__) . '.\..\..\php\Class\Sitio.php';
//Comprobamos que no exista la variable $sitio
if (!isset($sitio)) $sitio = new Sitio('id', 1, null, null);

//Comprobamos que el objeto no este vacio
$srcImgDocente = './App/img/not_image.jpg';
if ($sitio->getId() == null) {
    //Cargamos valores por defecto
    $sitio->setNameDocente('Nombres no registrados');
    $sitio->setEmailDocente('No registrado');
    $sitio->setCelDocente('No registrado');
    $btnEnviarCorreo = 'disabled';
} else {

    $btnEnviarCorreo = '';
    //Generamos la ruta de la imagen principal de la materia
    if (is_file(dirname(__FILE__) . "./../../img/docente/configuracion/{$sitio->getFotoDocente()}")) $srcImgDocente = "./App/img/docente/configuracion/{$sitio->getFotoDocente()}";

}

?>
<!--CONTACT-->
<div class="col-xl-12 text-center">
    <h1 class="display-3 text-light">CONTACTO</h1>
</div>
<div class="row m-0 p-0">
    <div class="col-xl-12 d-none d-sm-none d-md-none d-xl-block pt-4 pb-5">
        <div class="row">
            <div class="col-xl-6 text-center">
                <h4 class="font-weight-lighter text-light">INFO</h4>
            </div>
            <div class="col-xl-6 text-center">
                <h4 class="font-weight-lighter text-light">ENVIAR EMAIL</h4>
            </div>
        </div>
    </div>
    <div class="col-xl-12 h-100">
        <div class="row h-100 align-self-center">
            <div class="col-xl-1"></div>
            <div class="col-xl-4">
                <div class="d-block d-sm-block d-md-block d-xl-none text-center pt-4 pt-sm-4 pb-5 pb-sm-5">
                    <h4 class="font-weight-lighter text-light">INFO</h4>
                </div>
                <div class="card border-dark bg-light">
                    <img src="<?= $srcImgDocente; ?>" class="card-img-top" alt="Responsive image">
                    <!--<img src="App/img/profesor_perfil.jpg" class="card-img-top" alt="Responsive image">-->
                    <div class="card-body">
                        <h5 class="card-title"><?= trim($sitio->getNameDocente()); ?></h5>
                        <p class="card-text"></p>
                        <p class="card-text">Email: <small class="text-muted"><?= trim($sitio->getEmailDocente()); ?></small></p>
                        <p class="card-text">Cel: <small class="text-muted"><?= trim($sitio->getCelDocente()); ?></small></p>
                    </div>
                </div>
            </div>
            <div class="col-xl-1"></div>
            <div class="col-xl-5 text-light">
                <div class="d-block d-sm-block d-md-block d-xl-none text-center pt-5 pt-sm-5 pb-4 pb-sm-4 pb-md-5">
                    <h4 class="font-weight-lighter">ENVIAR EMAIL</h4>
                </div>
                <form name="frmEmail" method="POST" action="./App/pages/publico/sendEmail.php">
                    <div class="form-group row">
                        <label for="txtEmailRemitente" class="col-sm-2 col-form-label">Email:</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" name="txtRemitente" id="txtEmailRemitente" placeholder="Email" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="txtEmailRemitente" class="col-sm-2 col-form-label">Asunto:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="txtAsunto" name="txtAsunto" placeholder="Asunto" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="txtMensaje" class="col-sm-2 col-form-label">Mensaje:</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="txtMensaje" rows="10" maxlength="1000" placeholder="Escribre aquí tu mensaje" required></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-right">
                            <input type="submit" class="btn btn-success" name="accion" value="Enviar">
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xl-1"></div>
        </div>
    </div>
</div>
<!--END CONTACT-->