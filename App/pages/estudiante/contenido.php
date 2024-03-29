<?php
/**
 * @Page subContenido
 * @Autor Anres Geovanny Angulo Botina
 * @email andrescabj981@gmail.com
 * $tm = 0 : No hay errores o informes.
 * $tm = 1 : No existe la variable correspondiente a la sesión del usuario, no se puede cargar la página solicitada.
 * */
include_once dirname(__FILE__) . './../../php/Scripts/session_manager.php';
if (isset($_GET['tm'])) $tm = $_GET['tm'];
else $tm = 0;
if ($session) {
    if (strtolower(@$USUARIO['typeUser']) == 'estudiante') {
        include_once dirname(__FILE__) . './../../php/Scripts/general_funcitons.php';
        require_once dirname(__FILE__) . './../../php/Class/Conector.php';
        require_once dirname(__FILE__) . './../../php/Class/Tema.php';
        require_once dirname(__FILE__) . './../../php/Class/Subtema.php';

        $colorTittle = ['primary', 'success', 'warning'];
        //Verificamos que hemos recibido el id del tema o contenido padre
        if (isset($_GET['idP'])) {
            $objectParent = new Tema('id', $_GET['idP'], null, null);
            //Verificamos que el objeto cargado sea diferente de null
            if ($objectParent->getId() != null) {
                //Declaramos la ruta de la imagen asignada al objeto
                $srcImgParent = "./../../img/not_image.jpg";
                if (file_exists(dirname(__FILE__) . "./../../img/docente/contenidos/{$objectParent->getImg()}")) $srcImgParent = "./../../img/docente/contenidos/{$objectParent->getImg()}";
                //Cargamos y presentamos todos los subtemas o subcontenidos del contenido que se ha abierto.
                $data = Subtema::getObjects("id_tema={$objectParent->getId()}", "order by id asc");
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
                        //Comprobamos que el tamañano del texto en la propiedad contenido sea menor a 1000 caracteres
                        if (strlen($object->getContenido()) >= 1000) $object->setContenido(substr($object->getContenido(), 0, 1000) . '... <a class="card-link text-primary" onclick="openSubContenido(' . $object->getId() . ', ' . "'" . md5('subContenido.php') . "'" . ');" style="cursor: pointer;">Continuar leyendo</a>');
                        //Declaramos la ruta de la imagen del objeto cargado
                        if ($object->canDelete()) $btnDelete = ['', 'visible'];
                        $srcImg = "./../../img/not_image.jpg";
                        if (file_exists(dirname(__FILE__) . "./../../img/docente/contenidos/subContenidos/{$object->getImg()}")) $srcImg = "./../../img/docente/contenidos/subContenidos/{$object->getImg()}";
                        //Comprobamos si el registro se presentara a la derecha o izquierda
                        if ($alignItem) {
                            $list .= "
                            <div class='row'>
                                <div class='col-12'>
                                    <hr class='my-4'>
                                </div>
                                <div class='col-md-5 text-center align-self-center'>
                                    <img src='$srcImg' class='img-fluid' width='500' height='500'>
                                </div>
                                <div class='col-md-7 align-self-center'>
                                    <div class='card bg-light border-light h-100 align-middle'>
                                        <div class='card-body'>
                                            <h3 class='card-title text-uppercase text-{$colorTittle[rand(0, 2)]}' onclick='openSubContenido({$object->getId()}, " . '"' . md5('subContenido.php') . '"' . ");' style='cursor: pointer;'>{$object->getNombre()}</h3>
                                            <p class='card-text text-justify'>{$object->getContenido()}</p>
                                        </div>
                                        <div class='card-footer border-light bg-light'>
                                            <div class='d-flex justify-content-between align-items-center'>
                                                <div class='btn-group'>
                                                    <button type='button' class='btn btn-sm btn-outline-primary' data-toggle='tooltip' data-placement='bottom' title='Abrir' onclick='openSubContenido({$object->getId()}, " . '"' . md5('subContenido.php') . '"' . ");'>
                                                        <span class='material-icons align-middle'>open_in_new</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>";
                        } else {
                            $list .= "
                            <div class='row'>
                                <div class='col-12'>
                                    <hr class='my-4'>
                                </div>
                                <div class='col-md-7 align-self-center'>
                                    <div class='card bg-light border-light h-100 align-middle'>
                                        <div class='card-body'>
                                            <h3 class='card-title text-uppercase text-{$colorTittle[rand(0, 2)]}' onclick='openSubContenido({$object->getId()}, " . '"' . md5('subContenido.php') . '"' . ");' style='cursor: pointer;'>{$object->getNombre()}</h3>
                                            <p class='card-text text-justify'>{$object->getContenido()}</p>
                                        </div>
                                        <div class='card-footer border-light bg-light'>
                                            <div class='d-flex justify-content-between align-items-center'>
                                                <div class='btn-group'>
                                                    <button type='button' class='btn btn-sm btn-outline-primary' data-toggle='tooltip' data-placement='bottom' title='Abrir' onclick='openSubContenido({$object->getId()}, " . '"' . md5('subContenido.php') . '"' . ");'>
                                                        <span class='material-icons align-middle'>open_in_new</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class='col-md-5 text-center align-self-center'>
                                    <img src='$srcImg' class='img-fluid' width='500' height='500'>
                                </div>
                            </div>";
                        }
                        //Agregamos el cuadro de dialogo que nos permite confirmar la eliminación de un registro
                        $list .="
                        <!--DIALOG DELETE SUBTEMA ID: {$object->getNombre()}-->
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
                                    <p class='text-justify'>¿Esta seguro de eliminar el subtema: <span class='text-uppercase font-weight-bold'>{$object->getNombre()}</span>?</p>
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-danger' data-dismiss='modal'>Cancelar</button>
                                        <button type='button' class='btn btn-success' onclick='deleteRecord({$objectParent->getId()}, {$object->getId()});'>Eliminar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--END DIALOG DELETE SUBTEMA ID: {$object->getNombre()}-->
                        ";
                        $alignItem = !$alignItem;
                    }
                    $list .= '
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                    </div>';
                } else {
                    $list ='
                        <div class="col-xl-12 pb-5 bg-light">
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-10 pt-5">
                                    <div class="alert alert-primary text-center text-break"><h5 class="font-weight-lighter align-middle">ESTE CONTENIDO AÚN NO TIENE SUBTEMAS REGISTRADOS, COMUNICATE CON TU DOCENTE.</h5></div>
                                </div>
                            </div>
                        </div>';
                }
            } else header('Location: ./home.php?pg=1&tm=11');
        } else header('Location: ./home.php?pg=1&tm=11');
        ?>
        <!--CONTENIDO INFO-->
        <script src="./../../js/estudiante/contenido.js"></script>
        <div class="col-xl-12 bg-secondary p-5 text-light">
            <div class="row">
                <div class="col-md-0 col-lg-2"></div>
                <div class="col-sm-12 col-md-12 col-lg-8">
                    <h5 class="display-4 text-uppercase text-center text-break"><?= $objectParent->getNombre(); ?></h5>
                    <p class="text-justify pt-3"><?= $objectParent->getDescripcion(); ?></p>
                </div>
                <div class="col-md-0 col-lg-2 align-self-center text-center text-md-center text-lg-right pt-5 pt-sm-3 pt-md-3">
                    <button class="btn btn-outline-light text-center" id="btnBackParentPage" onclick="backPrincipalPage();">
                        <span class="">Regresar <i class="material-icons align-middle">arrow_back</i></span>
                    </button>
                </div>
            </div>
        </div>
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="<?= $srcImgParent ?>" class="d-block w-100" alt="Responsive img">
                </div>
            </div>
        </div>
        <!--END CONTENIDO INFO-->
        <!--<div class="col-xl-12 h-100 mb-5">-->
        <!--SUBCONTENIDOS-->
        <div class="col-xl-12 p-5 bg-white">
            <div class="row text-center">
                <div class="col-xl-2"></div>
                <div class="col-xl-8 align-self-center">
                    <h5 class="display-4 text-uppercase text-center">SUBTEMAS</h5>
                </div>
                <div class="col-xl-2 align-self-center"></div>
            </div>
        </div>
        <?= $list; ?>
        <!--END SUBCONTENIDOS-->
        <?php
    } else header("Location: ./../../../index.php?tm=-1");
} else $tm = 10;
echo "<input type='hidden' id='toastAction' name='toastAction' value='$tm'>";