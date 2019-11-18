<?php
/**
 * @version Página inicio.php de la sección público
 * @page inicio.php
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
if ($sitio->getId() == null) {
    //Cargamos valores por defecto
    $srcImgPrincipal = './App/img/materialEscolar.png';
    $sitio->setNameMateria('OurMatter');
    $sitio->setNameInstitucion('Pendiente registrar el nombre la institución');
    $sitio->setNameDocente('Pendiente registrar el nombre del docente');
    $sitio->setGrado('Pendiente');
} else {

    //Generamos la ruta de la imagen principal de la materia
    $srcImgPrincipal = './App/img/materialEscolar.png';
    if (is_file(dirname(__FILE__) . "./../../img/docente/configuracion/{$sitio->getImgMateria()}")) $srcImgPrincipal = "./App/img/docente/configuracion/{$sitio->getImgMateria()}";

}

?>
<!--CONTENT-->
<div class="col-xl-12 h-100">
    <div class="row h-100">
        <div class="col-md-12 col-xl-7 pl-5 pr-5 align-self-center">
            <img src="<?= $srcImgPrincipal; ?>" class="img-fluid float-left" alt="Responsive image">
        </div>
        <div class="col-md-12 col-xl-5 align-self-center text-light text-right d-none d-sm-none d-md-none d-xl-block pr-5">
            <h1 class="display-3 text-break text-uppercase font-weight-lighter"><?= trim($sitio->getNameMateria()); ?></h1>
            <p class="font-weight-lighter h4 text-uppercase text-break"><?= trim($sitio->getNameInstitucion()); ?></p>
            <p class="font-weight-lighter h5"><?= trim($sitio->getNameDocente()); ?></p>
            <p class="font-weight-lighter h6">Grado <?= trim($sitio->getGrado()); ?></p>
        </div>
        <div class="col-md-12 d-block d-sm-block d-md-block d-xl-none text-light text-center pt-5">
            <h1 class="display-3 text-break text-uppercase font-weight-light"><?= trim($sitio->getNameMateria()); ?></h1>
            <p class="font-weight-lighter h4 text-uppercase text-break"><?= trim($sitio->getNameInstitucion()); ?></p>
            <p class="font-weight-lighter h5"><?= trim($sitio->getNameDocente()); ?></p>
            <p class="font-weight-lighter h6">Grado <?= trim($sitio->getGrado()); ?></p>
        </div>
    </div>
</div>