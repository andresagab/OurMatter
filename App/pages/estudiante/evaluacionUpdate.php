<?php
/**
 * @version En este archivo se procesan los datos del formulario que se encuantra en la página evaluacionUpdate.php
 * @author Andres Geovanny Angulo Botina.
 * @email andrescabj981@gmail.com
 */
include_once dirname(__FILE__) . './../../php/Scripts/session_manager.php';
if ($session) {
    if (strtolower(@$USUARIO['typeUser']) == 'estudiante') {
        date_default_timezone_set('America/Bogota');
        include_once dirname(__FILE__) .'./../../php/Scripts/general_funcitons.php';
        require_once dirname(__FILE__) . './../../php/Class/Conector.php';
        require_once dirname(__FILE__) . './../../php/Class/Estudiante.php';
        require_once dirname(__FILE__) . './../../php/Class/Evaluacion.php';
        require_once dirname(__FILE__) . './../../php/Class/Evaluacion_Ejecucion.php';
        require_once dirname(__FILE__) . './../../php/Class/Evaluacion_Pregunta.php';
        require_once dirname(__FILE__) . './../../php/Class/Evaluacion_Opcion.php';
        require_once dirname(__FILE__) . './../../php/Class/Evaluacion_Respuesta.php';

        //Cargamos los datos enviados por POST y GET
        foreach ($_GET as $item => $val) ${$item} = $val;
        foreach ($_POST as $item => $val) ${$item} = $val;
        //print_r($_POST);die();
        $tm = '7';//Error al ejecutar la acción requerida
        switch (strtolower(@$method)){
            case 'addejecucion':
                if (isset($idEv) && isset($idEs)){
                    $evaluacionEjecucion = new Evaluacion_Ejecucion(null, null, null, null);
                    $evaluacionEjecucion->setIdEvaluacion($idEv);
                    $evaluacionEjecucion->setIdEstudiante($idEs);
                    $evaluacionEjecucion->setFechaInicio(date('Y-m-d H:i:s'));
                    if ($evaluacionEjecucion->add()) $tm = "0";
                }
                break;
            case 'addrespuestas':
                if (isset($idEE) && isset($qc)) {
                    $evaluacionRespuesta = new Evaluacion_Respuesta(null, null, null, null);
                    $evaluacionRespuesta->setIdEvaluacionEjecucion($idEE);
                    //Cargamos la evaluacion_ejecucion del estudiante
                    $evaluacionEjecucion = $evaluacionRespuesta->getEvaluacionEjecucion();
                    $idEv = $evaluacionEjecucion->getIdEvaluacion();
                    //Cargamos posibles respuestas previas registradas
                    $evaluacionRespuestas = Evaluacion_Respuesta::getObjects("id_evaluacionEjecucion = {$idEE}", null);
                    if (count($evaluacionRespuestas) > 0) {
                        //Eliminamos cada respuesta previa y le evaluacion ejecucion la actualizamos a fecha fin null
                        for ($i = 0; $i < count($evaluacionRespuestas); $i++) $evaluacionRespuestas[$i]->delete();
                        $evaluacionEjecucion->setFechaFin('null');
                        $evaluacionEjecucion->update();
                    }
                    //Creamos cada respuesta
                    $savedRespuesta = false;
                    $countAnswers = 0;
                    for ($i = 0; $i < $qc; $i++) {
                        if (isset($_POST["radio_P$i"])) {
                            $countAnswers++;
                            $evaluacionRespuesta->setIdEvaluacionOpcion($_POST["radio_P$i"]);
                            $evaluacionRespuesta->setFecha(date('Y-m-d H:i:s'));
                            if ($evaluacionRespuesta->add()) $savedRespuesta = true;
                            else {
                                echo 'error al registrar';
                                $savedRespuesta = false;
                                break;
                            }
                        }
                    }
                    //Actualizamos la fecha de finalizacion de la ejecución de la evaluación
                    $evaluacionEjecucion->setFechaFin("'" . date('Y-m-d H:i:s') . "'");
                    if ($evaluacionEjecucion->update()) {
                        //Comprobamos que todas las respuestas hayan sido guardadas, en caso contrario las eliminamos y establecemos la fecha fin de la ejecución en null
                        if ($savedRespuesta) {
                            $tm = '17';
                            if ($countAnswers != (int) $qc) $tm = '19';
                        } else {
                            if ($countAnswers > 0) {
                                $tm = '18';
                                $evaluacionRespuestas = Evaluacion_Respuesta::getObjects("id_evaluacionEjecucion = {$idEE}", null);
                                for ($i = 0; $i < count($evaluacionRespuestas); $i++) $evaluacionRespuestas[$i]->delete();
                                $evaluacionEjecucion->setFechaFin('null');
                                $evaluacionEjecucion->update();
                            } else $tm = '0';
                        }
                    }
                }
                break;
        }
        //header("Location: ./home.php?pg=5&fl=". md5('preguntasEvaluacion.php') . "&idP={$pregunta->getIdEvaluacion()}&tm=$tm");
        header("Location: ./home.php?pg=3&fl=" . md5('evaluacionDesarrollo.php') . "&id=$idEv&tm=$tm");
    } else header("Location: ./../../../index.php?tm=-1");
}