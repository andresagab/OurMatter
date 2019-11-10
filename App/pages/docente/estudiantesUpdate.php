<?php
/**
 * @version En este archivo se procesan los datos del formulario que se encuantra en la página subContenidosFrm.php
 * @author Andres Geovanny Angulo Botina.
 * @email andrescabj981@gmail.com
 */
include_once dirname(__FILE__) . './../../php/Scripts/session_manager.php';
if ($session) {
    if (strtolower(@$USUARIO['typeUser']) == 'docente') {
        include_once dirname(__FILE__) .'./../../php/Scripts/general_funcitons.php';
        require_once dirname(__FILE__) . './../../php/Class/Conector.php';
        require_once dirname(__FILE__) . './../../php/Class/Usuario.php';
        require_once dirname(__FILE__) . './../../php/Class/Estudiante.php';
        foreach ($_GET as $item => $val) ${$item} = $val;
        foreach ($_POST as $item => $val) ${$item} = $val;
        $tm = '7';//Error al ejecutar la acción requerida
        switch (strtolower(@$method)){
            case 'agregar':
                if (isset($txtNombres) && isset($txtApellidos)){
                    $object = new Estudiante(null, null, null, null);
                    $object->setNombres($txtNombres);
                    $object->setApellidos($txtApellidos);
                    $object->setUsuario(substr(strtolower($txtNombres), 0, 3) . substr(strtolower($txtApellidos), 0, 3) . '_' . (getLastID('estudiante', 'id') + 1));
                    //Registramos el usuario
                    $user = new Usuario(null, null, null, null);
                    $user->setUsuario($object->getUsuario());
                    $user->setPassword('estudiante_' . substr(strtolower($txtNombres), 0, 2) . (getLastID('estudiante', 'id') + 1));
                    $user->setEstado(true);
                    if ($user->add())
                        if ($object->add()) $tm = '1';
                }
                break;
            case 'editar':
                if (isset($id) && isset($txtNombres) && isset($txtApellidos)){
                    $object = new Estudiante('id', $id, null, null);
                    $object->setNombres($txtNombres);
                    $object->setApellidos($txtApellidos);
                    $pastUser = $object->getUsuario();//Salvamos el antiguo usuario antes de cambiarlo
                    $object->setUsuario(substr(strtolower($txtNombres), 0, 3) . substr(strtolower($txtApellidos), 0, 3) . '_' . $object->getId());
                    //Modificamos el usuario
                    $user = new Usuario('usuario', $pastUser, null, null);
                    $user->setUsuario($object->getUsuario());
                    $user->setPassword('estudiante_' . substr(strtolower($txtNombres), 0, 2) . $object->getId());
                    if ($user->update($pastUser))
                        if ($object->update()) $tm = '2';
                }
                break;
            case 'delete':
                if (isset($id)){
                    $object = new Estudiante('id', $id, null, null);
                    $user = $object->getUsuarioObject();
                    if ($object->delete()) $tm = 3;
                    if (!$user->delete()) $tm = 14;
                }
                break;
        }
        header("Location: ./home.php?pg=3&tm=$tm");
    } else header("Location: ./../../../index.php?tm=-1");
}