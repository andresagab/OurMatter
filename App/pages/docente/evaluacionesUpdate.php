<?php
/**
 * @version En este archivo se procesan los datos del formulario que se encuantra en la página evaluacionesFrm.php
 * @author Andres Geovanny Angulo Botina.
 * @email andrescabj981@gmail.com
 */
include_once dirname(__FILE__) . './../../php/Scripts/session_manager.php';
if ($session) {
    if (strtolower(@$USUARIO['typeUser']) == 'docente') {
        include_once dirname(__FILE__) .'./../../php/Scripts/general_funcitons.php';
        require_once dirname(__FILE__) . './../../php/Class/Conector.php';
        require_once dirname(__FILE__) . './../../php/Class/Evaluacion.php';
        foreach ($_GET as $item => $val) ${$item} = $val;
        foreach ($_POST as $item => $val) ${$item} = $val;
        $tm = '7';//Error al ejecutar la acción requerida
        switch (strtolower(@$method)){
            case 'agregar':
                if (isset($txtNombre) && isset($txtDescripcion) && isset($txtIdTema) && isset($txtFechaInicio) && isset($txtFechaFin)){
                    $object = new Evaluacion(null, null, null, null);
                    $object->setIdTema($txtIdTema);
                    $object->setNombre($txtNombre);
                    $object->setDescripcion($txtDescripcion);
                    $object->setFechaInicio(getDateOfInput($txtFechaInicio));
                    $object->setFechaFin(getDateOfInput($txtFechaFin));
                    getDateOfInput($object->getFechaInicio());
                    if ($object->add()) $tm = '1';
                }
                break;
            case 'editar':
                if (isset($id) && isset($txtNombre) && isset($txtDescripcion) && isset($txtIdTema) && isset($txtFechaInicio) && isset($txtFechaFin)){
                    $object = new Evaluacion('id', $id, null, null);
                    $object->setIdTema($txtIdTema);
                    $object->setNombre($txtNombre);
                    $object->setDescripcion($txtDescripcion);
                    $object->setFechaInicio(getDateOfInput($txtFechaInicio));
                    $object->setFechaFin(getDateOfInput($txtFechaFin));
                    if ($object->update()) $tm = '2';
                }
                break;
            case 'delete':
                if (isset($id)){
                    $object = new Evaluacion('id', $id, null, null);
                    if ($object->delete()) $tm = 3;
                }
                break;
        }
        header("Location: ./home.php?pg=2&tm=$tm");
    } else header("Location: ./../../../index.php?tm=-1");
}