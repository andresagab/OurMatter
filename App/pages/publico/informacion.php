<?php
/**
 * @version Página informacion.php de la sección público
 * @page informacion.php
 * @author Andres Geovanny Angulo Botina
 * @email andrescabj981@gmail.com
 */

//Agregamos los recursos necesarios
require_once dirname(__FILE__) . '.\..\..\php\Scripts\general_funcitons.php';
require_once dirname(__FILE__) . '.\..\..\php\Class\Conector.php';
require_once dirname(__FILE__) . '.\..\..\php\Class\Usuario.php';
require_once dirname(__FILE__) . '.\..\..\php\Class\Sitio.php';
require_once dirname(__FILE__) . '.\..\..\php\Class\Tema.php';
require_once dirname(__FILE__) . '.\..\..\php\Class\Subtema.php';
//Comprobamos que no exista la variable $sitio
if (!isset($sitio)) $sitio = new Sitio('id', 1, null, null);

//Comprobamos que el objeto no este vacio
$srcImgMateriaInformacion = './App/img/sitioWeb.jpg';
if ($sitio->getId() == null) {
    //Establecemos valores por defecto
    $sitio->setNameMateria('OurMatter');
    $sitio->setDescripcionMateria("OurMatter (Nuestra Materia) es un portal web para la presentación de información básica de temas de estudio de acuerdo a una determinada materia, aquí el docente se encarga de compartir con sus estudiantes los contenidos que va a enseñar, estos se pueden publicar de una forma dinámica (multimedial) de tal manera que se capte la atención del estudiante. A todo esto, se agrega la capacidad de ejecutar evaluaciones de selección múltiple, los estudiantes llevaran a cabo las pruebas de tal manera que sus resultados sean usados para generar una retroalimentación.");
} else {
    //Generamos la ruta de la imagen principal de la materia
    if (is_file(dirname(__FILE__) . "./../../img/docente/configuracion/{$sitio->getImgMateriaInformacion()}")) $srcImgMateriaInformacion = "./App/img/docente/configuracion/{$sitio->getImgMateriaInformacion()}";
}

//Generamos la variable que almacenara todos los contenidos del sitio, por defecto instanciamos un mensaje de alerta que informa que aún no hay contenidos registrados
$listTemas = '<div class="col-xl-12 pt-3"><div class="alert alert-warning"><h5 class="font-weight-lighter">En este momento no hay contenidos registrados.</h5></div></div>';

//Cargamos todos los temas registrados en la base de datos
$temas = Tema::getObjects(null, 'order by id asc');
//Comprobamos que la variable temas tenga datos
if (count($temas) > 0) {

    //Abrimos la lista
    $listTemas = '
    <div class="col-xl-12 py-3"></div>
    <div class="col-xl-2"></div>
        <div class="col-xl-8">
    ';

    //Lenamos la lista
    for ($i = 0; $i < count($temas); $i++) {
        $tema = $temas[$i];

        //Generamos la ruta correspondiente a la imagen del tema, por defecto instanciamos la not_image.jpg
        $srcImgTema = './App/img/not_image.jpg';
        if (is_file(dirname(__FILE__) . "./../../img/docente/contenidos/{$tema->getImg()}")) $srcImgTema = "./App/img/docente/contenidos/{$tema->getImg()}";

        //Incluimos el tema en la lista
        $listTemas .= "
        <!--<div class='card-deck pb-4'>-->
            <div class='card'>
                <img src='$srcImgTema' class='card-img-top' alt='Responsive image'>
                <div class='card-body'>
                    <h4 class='card-title text-uppercase'>{$tema->getNombre()}</h4>
                    <p class='card-text text-justify'>{$tema->getDescripcion()}</p>
        ";

        //Cargamos los subtemas del tema
        $subTemas = Subtema::getObjects("id_tema = {$tema->getId()}", 'order by id asc');
        //Comprobamos que hayan datos en $subtemas
        if (count($subTemas) > 0) {

            //Abrimos la lista de subtemas
            $listTemas .= '
                    <h5 class="card-subtitle text-left">Subtemas: </h5>
                </div>
            <ul class="list-group list-group-flush">
            ';
            //Llenamos la lista con los subtemas
            for ($j = 0; $j < count($subTemas); $j++) {
                $subTema = $subTemas[$j];
                $listTemas .= "
                    <li class='list-group-item text-left'>{$subTema->getNombre()}</li>
                ";
            }
            //Cerramos la lista de subtemas
            $listTemas .= '</ul>';

        } else {
            //Cerramos la card-body del tema e incluimos el mensaje de que el tema no tiene subtemas
            $listTemas .= "
                <h5 class='card-subtitle font-weight-light text-left text-danger'>Este tema no contiene subtemas.</h5>
                </div>
            ";
        }

        //Cerramos el tema
        $listTemas .= "
            </div>
            <hr class='my-4'>
        ";

    }

    //Cerramos la lista
    $listTemas .= '
        </div>
    </div>
    ';
}
?>
<!--CONTEAINER-->
<div class="col-xl-12 h-100 bg-white mt-2 p-0">
    <!--TITTLE HEADER-->
    <div class="col-xl-12 p-5 p-sm-5 p-md-3 bg-dark text-light">
        <div class="row text-center">
            <div class="col-lg-1 col-xl-2"></div>
            <div class="col-lg-10 col-xl-8 align-self-center">
                <h5 class="display-4 text-uppercase text-center"><?= $sitio->getNameMateria(); ?></h5>
                <p class="text-justify card-text py-3"><?= $sitio->getDescripcionMateria(); ?></p>
            </div>
            <div class="col-lg-1 col-xl-2 align-self-center"></div>
        </div>
    </div>
    <!--END TITTLE HEADER-->
    <!--IMG INFO-->
    <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="<?= $srcImgMateriaInformacion ?>" class="d-block w-100" alt="Responsive img">
            </div>
        </div>
    </div>
    <!--END IMG INFO-->
    <!--TEMAS-->
    <div class="col-xl-12 p-5 bg-light">
        <div class="row text-center">
            <div class="col-xl-2"></div>
            <div class="col-xl-8 align-self-center">
                <h5 class="display-4 text-uppercase text-center font-weight-lighter">CONTENIDOS</h5>
            </div>
            <div class="col-xl-2 align-self-center"></div>
            <?= $listTemas ?>
        </div>
    </div>
    <!--END TEMAS-->
</div>
<!--END CONTEAINER-->
<!--INFORMATION-->
<!--<div class="row m-0 p-0 mb-5">
    <div class="col-xl-12 text-center">
        <h1 class="display-3 text-light">QUÍMICA</h1>
    </div>
    <div class="col-xl-12 pt-5 text-center">
        <div class="row">
            <div class="col-1 col-sm-1 col-md-1 col-xl-2"></div>
            <div class="col-10 col-sm-10 col-md-10 col-xl-8 text-center">
                <img src="App/img/not_image.jpg" class="img-fluid" alt="Responsive image">
            </div>
            <div class="col-1 col-sm-1 col-md-1 col-xl-2"></div>
        </div>
    </div>
    <div class="col-xl-12 pt-5">
        <div class="row">
            <div class="col-md-1 col-xl-2"></div>
            <div class="col-md-10 col-xl-8">
                <p class="font-weight-light text-justify text-light">El Área de Ciencias Naturales y educación Ambiental, ofrece al estudiante la posibilidad de aprender a comprender en mundo en que vivimos, de que se aproxime al conocimiento
                    partiendo de preguntas, conjeturas o hipótesis que inicialmente surgen de su curiosidad ante la observación de su entorno y de su capacidad de analizar lo que observa. Se busca que los
                    estudiantes hallen habilidades científicas y las actitudes requeridas para explorar fenómenos y resolver problemas en forma crítica, ética, tolerante con la diversidad y comprometida con el
                    medio ambiente; se busca crear condiciones para que nuestros estudiantes sepan que son las ciencias naturales , para que puedan comprenderlas, comunicarlas, y compartir sus
                    experiencias y sus hallazgos, actuar con ellas en la vida real y hacer aportes a la construcción y al mejoramiento de su entorno.</p>
            </div>
            <div class="col-md-1 col-xl-2"></div>
        </div>
    </div>
    <div class="col-xl-12 text-center">
        <h1 class="display-4 text-light">TEMAS</h1>
    </div>
    <div class="col-xl-12 pt-5">
        <div class="row">
            <div class="col-xl-2"></div>
            <div class="col-xl-8">
                <div class="card-deck pb-4">
                    <div class="card bg-light border-dark">
                        <img src="App/img/not_image.jpg" class="card-img-top" alt="Responsive image">
                        <div class="card-body">
                            <h4 class="card-title">COMPUESTOS ORGANICOS</h4>
                            <p class="card-text text-justify">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">¿Qué es?</li>
                            <li class="list-group-item">El átomo de carbono</li>
                            <li class="list-group-item">Concepto de hibridación</li>
                            <li class="list-group-item">Estructura de los compuestos orgánicos</li>
                            <li class="list-group-item">Clasificación de los compuesto orgánicos</li>
                            <li class="list-group-item">Iones y radicales</li>
                            <li class="list-group-item">Nucleófilos y electrófilos</li>
                        </ul>
                    </div>
                    <div class="card bg-light border-dark">
                        <img src="App/img/not_image.jpg" class="card-img-top" alt="Responsive image">
                        <div class="card-body">
                            <h4 class="card-title">HIDROCARBUROS ALIFATICOS</h4>
                            <p class="card-text text-justify">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Concepto de hidrocarburos</li>
                            <li class="list-group-item">Alcanos</li>
                            <li class="list-group-item">Alquenos</li>
                            <li class="list-group-item">Cicloalcanos y Cicloalquenos</li>
                            <li class="list-group-item">Alquinos</li>
                            <li class="list-group-item">Reacciones en general</li>
                            <li class="list-group-item">Hidrocarburos aromaticos</li>
                        </ul>
                    </div>
                </div>
                <div class="card-deck">
                    <div class="card bg-light border-dark">
                        <img src="App/img/not_image.jpg" class="card-img-top" alt="Responsive image">
                        <div class="card-body">
                            <h4 class="card-title">EL PETROLEO Y GAS NATURAL</h4>
                            <p class="card-text text-justify">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Introducción</li>
                            <li class="list-group-item">Origen y estado natural</li>
                            <li class="list-group-item">Composición del crudo</li>
                            <li class="list-group-item">Destilación primaria del petroleo</li>
                            <li class="list-group-item">Indice de octano</li>
                        </ul>
                    </div>
                    <div class="card bg-light border-dark">
                        <img src="App/img/not_image.jpg" class="card-img-top" alt="Responsive image">
                        <div class="card-body">
                            <h4 class="card-title">COMPUESTOS OXIGENADOS</h4>
                            <p class="card-text text-justify">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Acoholes, Fenoles y Esteres</li>
                            <li class="list-group-item">Aldehidos y Cetonas</li>
                            <li class="list-group-item">Reacciones de los aldehidos y cetonas</li>
                            <li class="list-group-item">Nomenclatura de cetonas</li>
                            <li class="list-group-item">Nomenclatura de aldehidos</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-2"></div>
        </div>
    </div>
</div>-->
<!--END INFORMATION-->