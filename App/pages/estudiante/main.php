<?php
/**
 * @version Codigo correspondiente a la página main o principal del rol estudiante
 * @author Andres Geovanny Angulo Botina
 * @email andrescabj981@gmail.com
 * $tm = 0 : No hay errores.
 * $tm = 1 : No existe la variable correspondiente a la sesión del usuario, no se puede cargar la página solicitada.
 * */
include_once dirname(__FILE__) . './../../php/Scripts/session_manager.php';
$tm = 0;
if ($session){
    if (strtolower(@$USUARIO['typeUser']) == 'estudiante') {
        include_once dirname(__FILE__) . './../../php/Class/Conector.php';
        include_once dirname(__FILE__) . './../../php/Class/Estudiante.php';
        include_once dirname(__FILE__) . './../../php/Class/Tema.php';
        include_once dirname(__FILE__) . './../../php/Class/Subtema.php';
        include_once dirname(__FILE__) . './../../php/Class/Evaluacion.php';
        //Cargamos el estudiante que ingreso
        $autoLogout = '';
        $estudiante = new Estudiante('usuario', "'{$USUARIO['usuario']}'", null, null);
        if ($estudiante != null) {
            //Declaramos el mensaje de bienvenida
            $welcomeMesssaje = '<h5 class="display-4 text-uppercase text-center">NOVEDADES</h5>';
            //Evaluamos si existe el la variable mb, si es haci establecemos el mensaje de bienvenida
            if (isset($_GET['mb'])) $welcomeMesssaje = "
            <h5 class='display-4 text-uppercase text-center text-break'>HOLA {$estudiante->getNombres()}</h5>
            <h1 class='text-center font-weight-normal'><small>NOVEDADES</small></h1>";

            //Cargo el ultimo subtema agregado a la base de datos
            $subTema = Subtema::getObjects(null, 'order by id desc limit 1');
            $tema = new Tema(null, null, null, null);
            //Defino la sección de ultimo tema como oculta
            $srcImgSubTema = "./../../img/not_image.jpg";
            $sectionLastSubTema = 'invisible';
            if (count($subTema) > 0) {
                if ($subTema[0]->getId() != null) {
                    $subTema = $subTema[0];
                    $tema = $subTema->getTema();
                    $sectionLastSubTema = 'visible';
                    //Cargamos la imagen del subtema
                    if (file_exists(dirname(__FILE__) . "./../../img/docente/contenidos/subContenidos/{$subTema->getImg()}")) $srcImgSubTema = "./../../img/docente/contenidos/subContenidos/{$subTema->getImg()}";
                    //Cortamos el contenido del subtema
                    if (strlen($subTema->getContenido()) > 200) $subTema->setContenido(substr($subTema->getContenido(), 0, 200) . "...");
                }
            } else $subTema = new Subtema(null, null, null, null);

            //Cargamos las evaluaciones pendientes del estudiante
            $evaluaciones = $estudiante->getEvaluacionesPendientes();
            $listEvaluaciones = '';
            if (count($evaluaciones) == 0) $listEvaluaciones .= '<tr><th scope="row" colspan="6">No tienes evaluaciones pendientes.</th></tr>';
            else {
                for ($i = 0; $i < count($evaluaciones); $i++) {
                    $object = $evaluaciones[$i];
                    $listEvaluaciones .= "
                                    <tr>
                                        <th scope='row'>" . ($i + 1) . "</th>
                                        <td>{$object->getNombre()}</td>
                                        <td>{$object->getTema()->getNombre()}</td>
                                        <td>{$object->getFechaInicio()}</td>
                                        <td>{$object->getFechaFin()}</td>
                                        <td class='text-center'>
                                            <a data-toggle='tooltip' data-placement='bottom' title='Abrir' onclick=''>
                                                <span class='material-icons text-primary' style='cursor: pointer;'>open_in_new</span>
                                            </a>
                                        </td>
                                    </tr>
                    ";
                }
            }
        } else $autoLogout = '<input type="hidden" id="autoLogout" value="t">';
        ?>
        <!--CONTENT PAGE-->
        <script src="./../../js/estudiante/main.js"></script>
        <div class="col-xl-12 bg-light mt-2 p-0">
            <div class="col-xl-12 p-5 bg-secondary text-light">
                <div class="row text-center">
                    <div class="col-xl-2"></div>
                    <div class="col-xl-8 align-self-center">
                        <?= $welcomeMesssaje; ?>
                    </div>
                    <div class="col-xl-2"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-12 pb-5 bg-light">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <div class='row'>
                        <!--ULTIMO SUBTEMA-->
                        <h3 class="text-break font-weight-normal py-5 <?= $sectionLastSubTema; ?>">ULTIMO TEMA</h3>
                        <div class='col-md-12 text-center align-self-center <?= $sectionLastSubTema; ?>'>
                            <img src='<?= $srcImgSubTema; ?>' class='img-fluid'>
                        </div>
                        <div class='col-md-12 align-self-center' <?= $sectionLastSubTema; ?>>
                            <div class='card bg-transparent border-light h-100 align-middle'>
                                <div class='card-body'>
                                    <h3 class='card-title text-uppercase text-break text-<?= getRandomColorText('0', '2'); ?>' onclick='openRouteWithData(<?= $subTema->getId(); ?>, "<?= md5('subContenido.php') ?>");' style="cursor: pointer;"><?= $subTema->getNombre(); ?></h3>
                                    <h5 class='card-subtitle text-uppercase text-break text-muted py-2' onclick='openRouteWithData(<?= $tema->getId(); ?>, "<?= md5('contenido.php') ?>");' style="cursor: pointer;"><?= $tema->getNombre(); ?></h5>
                                    <p class='card-text'><?= $subTema->getContenido(); ?></p>
                                </div>
                                <div class='card-footer border-light bg-light'>
                                    <div class='d-flex justify-content-between align-items-center'>
                                        <div class='btn-group'>
                                            <button type='button' class='btn btn-sm btn-outline-primary' data-toggle='tooltip' data-placement='bottom' title='Abrir' onclick='openRouteWithData(<?= $subTema->getId(); ?>, "<?= md5('subContenido.php') ?>");'>
                                                <span class='material-icons align-middle'>open_in_new</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--END ULTIMO SUBTEMA-->
                        <!--NOTAS RAPIDAS-->
                        <div class="col-xl-12">
                            <hr class="my-4">
                        </div>
                        <h3 class="text-break font-weight-normal py-5 <?= $sectionLastSubTema; ?>">NOTAS</h3>
                        <div class="col-xl-12">
                            <!--PENDIENTE NOTAS-->
                        </div>
                        <!--END NOTAS RAPIDAS-->
                        <!--EVALUACIONES PENDIENTES-->
                        <div class="col-xl-12">
                            <hr class="my-4">
                        </div>
                        <h3 class="text-break font-weight-normal py-5 <?= $sectionLastSubTema; ?>">EVALUACIONES PENDIENTES</h3>
                        <div class="col-xl-12 table-responsive">
                            <table class='table table-hover'>
                                <thead>
                                    <tr>
                                        <th scope='col'>#</th>
                                        <th scope='col'>Evaluacion</th>
                                        <th scope='col'>Tema</th>
                                        <th scope='col'>Fecha inicio</th>
                                        <th scope='col'>Fecha fin</th>
                                        <th scope='col' class='px-5'>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?= $listEvaluaciones; ?>
                                </tbody>
                        </div>
                        <!--END EVALUACIONES PENDIENTES-->
                    </div>
                </div>
                <div class="col-md-1"></div>
            </div>
        </div>
        <!--END CONTENT PAGE-->
        <?php
    } else header("Location: ./../../../index.php?tm=-1");
} else {
    $toast = "<input type='hidden' id='toastAction' name='toastAction' value='1'>";
    echo "no hay session hay que informar que no se ha iniciado sesión o que los datos de la sesión han caducado";
}