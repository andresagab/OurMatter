<?php
/*
 * @version En este archivo se procesan todas las peticiones Http (GET - POST) correspondiente a la pagina configuracion
 * del rol Docente
 * Autor: Andres Geovanny Angulo Botina
 * Email: andrescabj981@gmail.com
 */
date_default_timezone_set("America/Bogota");
include_once dirname(__FILE__) .'./general_funcitons.php';
require_once dirname(__FILE__) . './../Class/Conector.php';
require_once dirname(__FILE__) . './../Class/Usuario.php';
require_once dirname(__FILE__) . './../Class/Sitio.php';
foreach ($_GET as $item => $val) ${$item} = $val;
foreach ($_POST as $item => $val) ${$item} = $val;
$JSON_STATUS = array();
$JSON_STATUS['status'] = false;
$JSON_STATUS['num_status'] = "7";
switch (@$method){
    case 'loadConfig-All':
        $JSON = array();
        $JSON['valid'] = true;
        $JSON['data'] = json_decode(Sitio::getDataJSON(true, 'id', 1, false, false, false));
        echo json_encode($JSON, JSON_UNESCAPED_UNICODE);
        break;
    case 'setData_General':
        if (isset($nombre_institucion) && isset($grado)){
            $object = new Sitio(null, null, null, null);
            $object->setId(1);
            $object->setNameInstitucion($nombre_institucion);
            $object->setGrado($grado);
            if ($object->update_General()) {
                $JSON_STATUS['status'] = true;
                $JSON_STATUS['num_status'] = "2";
            }
        }
        echo json_encode($JSON_STATUS, JSON_INVALID_UTF8_IGNORE);
        break;
    case 'setData_Docente':
        if (isset($name_docente) && isset($email_docente) && isset($cel_docente) && isset($files_send)){
            $object = new Sitio('id', 1, null, null);
            $object->setNameDocente($name_docente);
            $object->setEmailDocente($email_docente);
            $object->setCelDocente($cel_docente);
            (boolean) $files_send = $files_send;
            if ($files_send) {
                if (count($_FILES) > 0) {
                    //deleteFile('./../../img/docente/configuracion/', $object->getFotoDocente());
                    if (($fileName = uploadFile($_FILES, 'file_0', './../../img/docente/configuracion/', 'foto_docente')) != 'not_image') $object->setFotoDocente($fileName);
                    else $JSON_STATUS['num_status'] = '14';
                } else $JSON_STATUS['num_status'] = '14';
            }
            if ($object->update_Docente()) {
                $JSON_STATUS['status'] = true;
                if ($JSON_STATUS['num_status'] == '14') $JSON_STATUS['num_status'] = "14";
                else $JSON_STATUS['num_status'] = "2";
            }
        }
        echo json_encode($JSON_STATUS, JSON_INVALID_UTF8_IGNORE);
        break;
    case 'setData_Materia':
        if (isset($name_materia) && isset($descripcion_materia) && isset($files_send)){
            $object = new Sitio('id', 1, null, null);
            $object->setNameMateria($name_materia);
            $object->setDescripcionMateria($descripcion_materia);
            if ($files_send == '1') {
                if (count($_FILES) > 0) {
                    if (isset($_FILES['file_imgPrincipal_0'])) {
                        //deleteFile('./../../img/docente/configuracion/', $object->getImgMateria());
                        if (($img_materia = uploadFile($_FILES, 'file_imgPrincipal_0', './../../img/docente/configuracion/', 'img_materia')) != 'not_image') $object->setImgMateria($img_materia);
                        else $JSON_STATUS['num_status'] = '14';
                    }
                    if (isset($_FILES['file_imgInformacion_0'])) {
                        //deleteFile('./../../img/docente/configuracion/', $object->getImgMateriaInformacion());
                        if (($img_materiaInformacion = uploadFile($_FILES, 'file_imgInformacion_0', './../../img/docente/configuracion/', 'img_materiaInformacion')) != 'not_image') $object->setImgMateriaInformacion($img_materiaInformacion);
                        else $JSON_STATUS['num_status'] = '14';
                    }
                    //if (!isset($_FILES['file_imgInformacion_0']) && !isset($_FILES['file_imgPrincipal_0'])) $JSON_STATUS['num_status'] = '14';$JSON_STATUS['num_status'] = '14';
                } else $JSON_STATUS['num_status'] = '14';
            }
            if ($object->update_Materia()) {
                $JSON_STATUS['status'] = true;
                if ($JSON_STATUS['num_status'] == '14') $JSON_STATUS['num_status'] = "14";
                else $JSON_STATUS['num_status'] = "2";
            }
        }
        echo json_encode($JSON_STATUS, JSON_INVALID_UTF8_IGNORE);
        break;
    default:
        echo json_encode($JSON_STATUS, JSON_INVALID_UTF8_IGNORE);
        break;
}