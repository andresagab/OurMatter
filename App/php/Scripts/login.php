<?php
require_once dirname(__FILE__) . './../Class/Conector.php';
require_once dirname(__FILE__) . './../Class/Usuario.php';
foreach ($_GET as $item => $val) ${$item} = $val;
foreach ($_POST as $item => $val) ${$item} = $val;
switch ($method){
    case 'validLogin':
        $JSON = array();
        $JSON['valid'] = false;
        $JSON['data'] = null;
        if (isset($usuario) && isset($password)){
            if (($JSON['valid'] = Usuario::validUser($usuario, $password))) {
                $JSON['data'] = json_decode(Usuario::getDataJSON(true, 'usuario', $usuario, null, 'limit 1', true));
                if (isset($_SESSION['usuario'])) clearSession();
                session_start();
                $object['usuario'] = array();
                $object['usuario']['usuario'] = $JSON['data']->usuario;
                $object['usuario']['typeUser'] = $JSON['data']->typeUser;
                $_SESSION['USUARIO'] = serialize($object);
            } else $JSON['data'] = null;
        }
        echo json_encode($JSON, JSON_UNESCAPED_UNICODE);
        break;
    case 'logOut':
        clearSession();
        $response = array();
        $response['status'] = "OK";
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        break;
}

/**
 * @version Se eliminan todos los registros existentes en la variable $_SESSION en su totalidad
 */
function clearSession(){
    if (session_status() != 2) session_start();
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
}