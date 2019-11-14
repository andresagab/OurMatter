<?php
/**
* @version Codigo correspondiente a la página contenidos del rol estudiante
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
        //Cargamos los temas registrados en la base de datos
        $temas = Tema::getObjects(null, 'order by id asc');
        $colorTittle = ['primary', 'success', 'warning'];
        $listTemas = '';
        if (count($temas) > 0) {
            //Declaramos la alerta de contenidos como vacia
            $alertNoContent = '';
            for ($i = 0; $i < count($temas); $i++) {
                $tema = $temas[$i];
                $srcImgTema = './../../img/not_image.jpg';
                if (file_exists(dirname(__FILE__) . "./../../img/docente/contenidos/{$tema->getImg()}")) $srcImgTema = "./../../img/docente/contenidos/{$tema->getImg()}";
                $listTemas .="
                <div class='col-md-12 text-center align-self-center'>
                    <img src='$srcImgTema' class='img-fluid'>
                </div>
                <div class='col-md-12 align-self-center'>
                    <div class='card bg-transparent border-light h-100 align-middle '>
                        <div class='card-body'>
                            <h3 class='card-title text-uppercase text-break text-{$colorTittle[rand(0, 2)]}' onclick='openContenido({$tema->getId()}, " . '"' . md5('contenido.php') . '"' . ");' style='cursor: pointer;'>{$tema->getNombre()}</h3>
                            <p class='card-text'>{$tema->getDescripcion()}</p>
                            <h5 class='card-subtitle text-uppercase text-break text-muted py-3'>subtemas: </h5>";
                //Cargamos los subtemas del tema
                $subtemas = Subtema::getObjects("id_tema = {$tema->getId()}", null);
                if (count($subtemas) > 0) {
                    $listTemas .= "<ul class='list-group list-group-flush bg-light'>";
                    for ($j = 0; $j < count($subtemas); $j++) {
                        $subtema = $subtemas[$j];
                        $listTemas .="
                        <a onclick='openSubContenido({$subtema->getId()}, " . '"' . md5('subContenido.php') . '"' . ");' style='cursor: pointer;' style='cursor: pointer;'>
                            <li class='list-group-item d-flex justify-content-between align-items-center bg-light'>
                                <span>" . ($j + 1) . ". {$subtema->getNombre()}</span>
                                <span class='material-icons text-success' style='cursor: pointer;' data-toggle='tooltip' data-placement='bottom' onclick='openSubContenido({$subtema->getId()}, " . '"' . md5('subContenido.php') . '"' . ");'>open_in_new</span>
                            </li>
                        </a>
                        ";
                    }
                    $listTemas .= "</ul>";
                } else $listTemas .= '<div class="alert alert-primary mt-3">ESTE CONTENIDO AÚN NO TIENE SUBTEMAS REGISTRADOS, COMUNICATE CON TU DOCENTE.</div>';
                $listTemas .="    
                        </div>
                        <div class='card-footer border-light bg-light'>
                            <div class='d-flex justify-content-between align-items-center'>
                                <div class='btn-group'>
                                    <button type='button' class='btn btn-sm btn-outline-primary' data-toggle='tooltip' data-placement='bottom' title='Abrir' onclick='openContenido({$tema->getId()}, " . '"' . md5('contenido.php') . '"' . ");'>
                                        <span class='material-icons align-middle'>open_in_new</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='col-xl-12'>
                    <hr class='my-4'>
                </div>
                ";
            }
        } else $alertNoContent = '<div class="alert alert-primary">AÚN NO SE HAN REGISTRADO CONTENIDOS, COMUNICATE CON TU DOCENTE.</div>';
        ?>
        <script src="./../../js/estudiante/contenidos.js"></script>
        <!--CONTENT PAGE-->
        <div class="col-xl-12 bg-light mt-2 p-0">
            <div class="col-xl-12 p-5 bg-secondary text-light">
                <div class="row text-center">
                    <div class="col-xl-2"></div>
                    <div class="col-xl-8 align-self-center">
                        <h5 class='display-4 text-uppercase text-center text-break'>CONTENIDOS</h5>
                    </div>
                    <div class="col-xl-2"></div>
                </div>
            </div>
        </div>
        <!--TEMAS-->
        <div class="col-xl-12 pb-5 bg-light">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <div class='row pt-5'>
                        <?= $alertNoContent; ?>
                        <?= $listTemas; ?>
                    </div>
                </div>
                <div class="col-md-1"></div>
            </div>
        </div>
        <!--END TEMAS-->
        <!--END CONTENT PAGE-->
        <?php
    } else header("Location: ./../../../index.php?tm=-1");
} else {
    $toast = "<input type='hidden' id='toastAction' name='toastAction' value='1'>";
    echo "no hay session hay que informar que no se ha iniciado sesión o que los datos de la sesión han caducado";
}