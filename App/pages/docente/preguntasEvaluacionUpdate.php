<?php
/**
 * @version En este archivo se procesan los datos del formulario que se encuantra en la página preguntasEvaluacionFrm.php
 * @author Andres Geovanny Angulo Botina.
 * @email andrescabj981@gmail.com
 */
include_once dirname(__FILE__) . './../../php/Scripts/session_manager.php';
if ($session) {
    if (strtolower(@$USUARIO['typeUser']) == 'docente') {
        include_once dirname(__FILE__) .'./../../php/Scripts/general_funcitons.php';
        require_once dirname(__FILE__) . './../../php/Class/Conector.php';
        require_once dirname(__FILE__) . './../../php/Class/Evaluacion_Pregunta.php';
        foreach ($_GET as $item => $val) ${$item} = $val;
        foreach ($_POST as $item => $val) ${$item} = $val;
        $tm = '7';//Error al ejecutar la acción requerida
        //Comprobamos que el id del objeto padre haya sido enviado
        if (isset($idP)) {
            if ($idP != null) {
                switch (strtolower(@$method)){
                    case 'agregar':
                        if (isset($txtPregunta)){
                            $object = new Evaluacion_Pregunta(null, null, null, null);
                            $object->setIdEvaluacion($idP);
                            $object->setPregunta($txtPregunta);
                            if ($object->add()) $tm = '1';
                        }
                        break;
                    case 'editar':
                        if (isset($id) && isset($txtPregunta)){
                            $object = new Evaluacion_Pregunta('id', $id, null, null);
                            $object->setPregunta($txtPregunta);
                            if ($object->update()) $tm = '2';
                        }
                        break;
                    case 'delete':
                        if (isset($id)){
                            $object = new Evaluacion_Pregunta('id', $id, null, null);
                            if ($object->delete()) $tm = '3';
                        }
                        break;
                }
                header("Location: ./home.php?pg=5&fl=". md5('preguntasEvaluacion.php') . "&idP={$idP}&tm=$tm");
            } else header("Location: ./home.php?pg=2&tm=$tm");
        } else header("Location: ./home.php?pg=2&tm=$tm");
    } else header("Location: ./../../../index.php?tm=-1");
}