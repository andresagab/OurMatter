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

//Definimos la variable de resultado para el toast
$tm = '-3';
//Comprobamos que se hayan enviado datos via POST
if (count($_POST) > 0) {
    //Comprobamos que existan la variables necesarias
    foreach ($_POST as $item => $val) ${$item} = $val;
    if (isset($txtRemitente) && isset($txtAsunto) && isset($txtMensaje)) {

        //Cargamos el sitio
        $sitio = new Sitio('id', 1, null, null);
        if ($sitio->getEmailDocente() != null) {

            $from = $txtRemitente;
            $to = $sitio->getEmailDocente();
            $subject = $txtAsunto;
            $message = $txtMensaje;
            $headers = "From:" . $from;
            //Para enviar el correo electronico se debe contar con un servicio SMTP
            if (mail($to, $subject, $message, $headers)) $tm = -4;
        }
    }
}
header("Location: ./../../../index.php?pg=1&tm=-4");