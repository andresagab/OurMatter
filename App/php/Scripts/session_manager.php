<?php
/**
 * @version  En este archivo se declara o recupera la sesión de usuario creada anteriormente, el proposito principal es incluir
 * este archivo en todas las paginas que hagan uso de una sesión de usuario, de tal manera que la variable $session
 * sirva como campo de evaluación para la sesión y sus correspondientes permisos de acceso.
 * @Autor: Andres Geovanny Angulo Botina
 * @Email: andrescabj981@gmail.com
 */
session_start();
$session = false;
if (isset($_SESSION['USUARIO'])) {
    $USUARIO = unserialize($_SESSION['USUARIO'])['usuario'];
    if ($USUARIO['usuario'] != null) $session = true;
}
else {
    if (isset($_GET['out'])) header("Location: ./../../../index.php");
    else header("Location: ./../../../index.php?tm=0");
}