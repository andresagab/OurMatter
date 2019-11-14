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
            //Cargo el subtema
            $subtema = new Subtema('id', $_GET['idP'], null, null);
            if ($subtema->getId() != null) {
                //Cargo el tema principal
                $tema = $subtema->getTema();
                //Cargo la imagen del subtema
                $srcImgParent = "./../../img/not_image.jpg";
                if (file_exists(dirname(__FILE__) . "./../../img/docente/contenidos/subcontenidos/{$subtema->getImg()}")) $srcImgParent = "./../../img/docente/contenidos/subContenidos/{$subtema->getImg()}";
            } else $tm = '11';
        } else header('Location: ./home.php?pg=1&tm=11');
        ?>
        <!--CONTENIDO INFO-->
        <script src="./../../js/estudiante/subContenido.js"></script>
        <div class="col-xl-12 bg-secondary p-5 text-light">
            <div class="row">
                <div class="col-md-0 col-lg-2"></div>
                <div class="col-sm-12 col-md-12 col-lg-8">
                    <h5 class="display-4 text-uppercase text-center text-break"><?= $subtema->getNombre(); ?></h5>
                    <h3 class="font-weight-normal text-break text-uppercase text-center text-break">(<small><?= $tema->getNombre(); ?>)</small></h3>
                </div>
                <div class="col-md-0 col-lg-2 align-self-center text-center text-md-center pt-5 pt-sm-3 pt-md-3">
                    <button class="btn btn-outline-light text-center" id="btnBackParentPage" onclick="backParentPage(<?= $tema->getId(); ?>, '<?= md5('contenido.php'); ?>')">
                        <span class="">Regresar <i class="material-icons align-middle">arrow_back</i></span>
                    </button>
                </div>
            </div>
        </div>
        <!--DESC-->
        <div class="col-xl-12 p-5 bg-white">
            <div class="row text-center">
                <div class="col-xl-2"></div>
                <div class="col-xl-8 align-self-center">
                    <p class="text-break text-justify"><?= $subtema->getContenido(); ?></p>
                </div>
                <div class="col-xl-2 align-self-center"></div>
                <div class="col-xl-12 p-5">
                    <img src="<?= $srcImgParent ?>" class="img-fluid" alt="Responsive img">
                </div>
            </div>
        </div>
        <!--END DESC-->
        <!--END CONTENIDO INFO-->
        <?php
    } else header("Location: ./../../../index.php?tm=-1");
} else $tm = 10;
echo "<input type='hidden' id='toastAction' name='toastAction' value='$tm'>";