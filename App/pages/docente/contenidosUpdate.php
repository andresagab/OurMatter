<?php
/**
 * @version En este archivo se procesan los datos del formulario que se encuantra en la página contenidosFrm.php
 * @author Andres Geovanny Angulo Botina.
 * @email andrescabj981@gmail.com
 */
include_once dirname(__FILE__) . './../../php/Scripts/session_manager.php';
if ($session) {
    if (strtolower(@$USUARIO['typeUser']) == 'docente') {
        include_once dirname(__FILE__) .'./../../php/Scripts/general_funcitons.php';
        require_once dirname(__FILE__) . './../../php/Class/Conector.php';
        require_once dirname(__FILE__) . './../../php/Class/Tema.php';
        foreach ($_GET as $item => $val) ${$item} = $val;
        foreach ($_POST as $item => $val) ${$item} = $val;
        $tm = '7';//Error al ejecutar la acción requerida
        switch (strtolower(@$method)){
            case 'agregar':
                if (isset($txtNombre) && isset($txtDescripcion) && isset($_FILES['fileImg'])){
                    $object = new Tema(null, null, null, null);
                    $object->setNombre($txtNombre);
                    $object->setDescripcion($txtDescripcion);
                    $object->setImg($fileName = uploadFile($_FILES, 'fileImg', './../../img/docente/contenidos/', 'tema_img_' . (getLastID('tema', 'id') + 1) . '_id'));
                    if ($object->getImg() == 'not_image') $tm = '14';
                    if ($object->add())
                        if ($tm != '14') $tm = '1';
                }
                break;
            case 'editar':
                if (isset($id) && isset($txtNombre) && isset($txtDescripcion) && isset($_FILES['fileImg'])){
                    $object = new Tema('id', $id, null, null);
                    $object->setNombre($txtNombre);
                    $object->setDescripcion($txtDescripcion);
                    $pastExt = getExtFile($object->getImg());
                    $object->setImg($fileName = uploadFile($_FILES, 'fileImg', './../../img/docente/contenidos/', 'tema_img_' . $object->getId() . '_id'));
                    if ($pastExt != getExtFile($fileName)) deleteFile('./../../img/docente/contenidos/', 'tema_img_' . $object->getId() . '_id' . $pastExt);
                    if ($object->getImg() == 'not_image') $tm = '14';
                    if ($object->update())
                        if ($tm != '14') $tm = '2';
                }
                break;
            case 'delete':
                if (isset($id)){
                    $object = new Tema('id', $id, null, null);
                    deleteFile('./../../img/docente/contenidos/', $object->getImg());
                    if ($object->delete()) $tm = '3';
                }
                break;
        }
        header("Location: ./home.php?pg=1&tm=$tm");
    } else header("Location: ./../../../index.php?tm=-1");
}