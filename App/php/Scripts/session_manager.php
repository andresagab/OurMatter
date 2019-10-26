<?php
session_start();
$session = false;
if (isset($_SESSION['USUARIO'])) {
    $USUARIO = unserialize($_SESSION['USUARIO'])['usuario'];
    if ($USUARIO['usuario'] != null) $session = true;
}/*
else {
    if (isset($_GET['out'])) header("Location: ./../../../index.php");
    else header("Location: ./../../../index.php?tm=0");
}*/