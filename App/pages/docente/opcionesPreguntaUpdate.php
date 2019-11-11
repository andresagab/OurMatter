<?php
/**
 * @version En este archivo se procesan los datos del formulario que se encuantra en la página opcionesPreguntaFrm.php
 * @author Andres Geovanny Angulo Botina.
 * @email andrescabj981@gmail.com
 */
include_once dirname(__FILE__) . './../../php/Scripts/session_manager.php';
if ($session) {
    if (strtolower(@$USUARIO['typeUser']) == 'docente') {
        include_once dirname(__FILE__) .'./../../php/Scripts/general_funcitons.php';
        require_once dirname(__FILE__) . './../../php/Class/Conector.php';
        require_once dirname(__FILE__) . './../../php/Class/Evaluacion.php';
        require_once dirname(__FILE__) . './../../php/Class/Evaluacion_Pregunta.php';
        require_once dirname(__FILE__) . './../../php/Class/Evaluacion_Opcion.php';
        foreach ($_GET as $item => $val) ${$item} = $val;
        foreach ($_POST as $item => $val) ${$item} = $val;
        $tm = '7';//Error al ejecutar la acción requerida
        //Comprobamos que el de la pregunta hayan sido enviado
        if (isset($id)) {
            if ($id != null) {
                $pregunta = new Evaluacion_Pregunta('id', $id, null, null);
                switch (strtolower(@$method)){
                    case 'agregar':
                        if (isset($txtOpcion_1) && isset($txtOpcion_2) && isset($txtOpcion_3) && isset($txtOpcion_4) && isset($radioCorrecta)){
                            $object = new Evaluacion_Opcion(null, null, null, null);
                            $object->setIdEvaluacionPregunta($id);
                            for ($i = 1; $i <= 4; $i++) {
                                $object->setOpcion($_POST["txtOpcion_$i"]);
                                if ($i == $radioCorrecta) $object->setCorrecta('1');
                                else $object->setCorrecta('0');
                                if ($object->add()) $tm = '1';
                                else $tm = '14';
                            }
                        }
                        break;
                    case 'editar':
                        if (isset($txtOpcion_1) && isset($txtOpcion_2) && isset($txtOpcion_3) && isset($txtOpcion_4) && isset($radioCorrecta) && isset($opcionesId)){
                            $opcionesId = explode('_', $opcionesId);
                            for ($i = 0; $i < count($opcionesId); $i++) {
                                $object = new Evaluacion_Opcion('id', $opcionesId[$i], null, null);
                                if ($object->getId() != null) {
                                    $object->setOpcion($_POST["txtOpcion_" . ($i + 1)]);
                                    if (($i + 1) == $radioCorrecta) $object->setCorrecta('1');
                                    else $object->setCorrecta('0');
                                    if ($object->update()) $tm = '1';
                                    else $tm = '14';
                                }
                            }
                            if ($object->update()) $tm = '2';
                        }
                        break;
                    case 'delete':
                        if (isset($id)){
                            $objects = Evaluacion_Opcion::getObjects("id_evaluacionPregunta = $id", "order by id asc");
                            for ($i = 0; $i < count($objects); $i++) {
                                if ($objects[$i]->delete()) $tm = '3';
                                else $tm = '14';
                            }
                        }
                        break;
                }
                header("Location: ./home.php?pg=5&fl=". md5('preguntasEvaluacion.php') . "&idP={$pregunta->getIdEvaluacion()}&tm=$tm");
            } else header("Location: ./home.php?pg=2&tm=$tm");
        } else header("Location: ./home.php?pg=2&tm=$tm");
    } else header("Location: ./../../../index.php?tm=-1");
}