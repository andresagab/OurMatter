<?php
/*
 * Page: contenidos
 * Autor: Anres Geovanny Angulo Botina
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
        $data = Tema::getObjects(null, null);
        $list = '';
        if (count($data) > 0) {
            $rows = count($data) / 3;
            $element = 0;
            $colorTittle = ['primary', 'success', 'warning'];
            $imgSrc = '';
            $btnDelete = 'disabled';
            for ($i = 0 ; $i < ceil($rows); $i++){
                $list .= "<div class='col-xl-12 pl-5 pr-5'>
                            <div class='row'>";
                for ($j = 1 ; $j <= 3; $j++){
                    if ($element < count($data)){
                        $object = $data[$element];
                        //$object = new Tema($data[$i], null, null, null);
                        if ($object->canDelete()) $btnDelete = '';
                        $srcImg = "./../../img/not_image.jpg";
                        if (file_exists(dirname(__FILE__) . "./../../img/docente/contenidos/{$object->getImg()}")) $srcImg = "./../../img/docente/contenidos/{$object->getImg()}";
                        $list .= "
                                <!--CARD TEMA : {$object->getNombre()}-->
                                <div class='col-xl-4'>
                                    <div class='card mb-4 shadow-sm'>
                                        <img src='$srcImg' class='card-img-top' width='100%' height='225' alt='Responsive image'>
                                        <div class='card-body'>
                                            <h4 class='card-title text-{$colorTittle[rand(0, 2)]} text-uppercase'>{$object->getNombre()}</h4>
                                            <p class='card-text text-justify'>{$object->getDescripcion()}</p>
                                            <div class='d-flex justify-content-between align-items-center'>
                                                <div class='btn-group'>
                                                    <button type='button' class='btn btn-sm btn-outline-primary' data-toggle='tooltip' data-placement='bottom' title='Abrir'>
                                                        <span class='material-icons align-middle'>open_in_new</span>
                                                    </button>
                                                    <button type='button' class='btn btn-sm btn-outline-success' data-toggle='tooltip' data-placement='bottom' title='Editar' onclick='openFrm({$object->getId()});'>
                                                        <span class='material-icons align-middle'>edit</span>
                                                    </button>
                                                    <button type='button' class='btn btn-sm btn-outline-danger' data-toggle='modal' data-target='#del_{$object->getId()}' $btnDelete>
                                                        <span class='material-icons align-middle' data-toggle='tooltip' data-placement='bottom' title='Eliminar'>delete</span>
                                                    </button>
                                                </div>
                                                <!--<small class='text-muted'>$j</small>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--END CARD TEMA : {$object->getNombre()}-->
                                <!--DIALOG DELETE TEMA ID: {$object->getNombre()}-->
                                <div class='modal fade' id='del_{$object->getId()}' tabindex='-1' role='dialog' aria-labelledby='cardModalCenterTitle_{$object->getId()}' aria-hidden='true'>
                                    <div class='modal-dialog modal-dialog-centered' role='document'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                                <h5 class='modal-title' id='cardModalCenterTitle_{$object->getId()}'>ELIMINAR TEMA</h5>
                                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                    <span aria-hidden='true'>&times;</span>
                                                </button>
                                            </div>
                                            <div class='modal-body'>
                                            <p class='text-justify'>¿Esta seguro de eliminar el tema: <span class='text-uppercase'>{$object->getNombre()}?</p>
                                            </div>
                                            <div class='modal-footer'>
                                                <button type='button' class='btn btn-danger' data-dismiss='modal'>Cancelar</button>
                                                <button type='button' class='btn btn-success' onclick='deleteRecord({$object->getId()});'>Eliminar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--END DIALOG DELETE TEMA ID: {$object->getNombre()}-->
                                ";
                        $element++;
                    }
                }
                $list .= "</div>
                        </div>";
            }
        } else $tm = 16;
        ?>
        <div class="col-xl-12 h-100 mb-5">
            <div class="row h-100">
                <section class="jumbotron text-center w-100 bg-secondary text-light">
                    <div class="container align-items-center">
                        <div class="row align-self-center">
                            <div class="col-xl-2"></div>
                            <div class="col-xl-8 align-self-center">
                                <h3 class="display-4">CONTENIDOS</h3>
                            </div>
                            <div class="col-xl-2 align-self-center">
                                <button class="btn btn-outline-light" id="btnAddContenidos" onclick="openFrm(null)">
                                    <span class="">Agregar <i class="material-icons align-middle">add</i></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </section>
                <?= $list; ?>
            </div>
        </div>
        <?php
    } else header("Location: ./../../../index.php?tm=-1");
} else $tm = 10;
echo "<input type='hidden' id='toastAction' name='toastAction' value='$tm'>";