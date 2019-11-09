<?php
/*
 * En este archivo se alojan las funciones de uso general para la aplicación
 * Autor: Andres Geovanny Angulo Botina
 * Email: andrescabj981@gmail.com
 */

/**
 * @param $filter : String con el filtro SQL, sin incluir el WHERE
 * @return string : Filtro SQL con campo WHERE
 */
function validFilterSQL($filter){
    if ($filter != null && $filter != "") $filter = " WHERE $filter";
    return $filter;
}

/**
 * @version  Esta función carga un archivo a la ruta especificada como parametro.
 * @param $FILE_ARRAY : Arreglo $_FILES con los archivos correspondientes.
 * @param $name_column : String con el nombre de la columna o subarreglo que contiene los datos del archivo implicado.
 * @param $route : String con la ruta del directorio donde se desea cargar o subir el archivo.
 * @param $name_id_file : String con el identificador clave que será asignado al archivo.
 * @return string : Nombre del archivo que fue cargado, si retorna '' significa que no se subio el archivo.
 */
function uploadFile($FILE_ARRAY, $name_column, $route, $name_id_file) {
    $fileName = 'not_image';
    if (isset($FILE_ARRAY["$name_column"])){
        $existDir = false;
        if (!is_dir(dirname(__FILE__) . $route)) {
            if (mkdir(dirname(__FILE__) . $route, 0777)) $existDir = true;
        } else $existDir = true;
        if ($existDir && $FILE_ARRAY["$name_column"]['tmp_name'] != null) {
            $ext = getExtFile($FILE_ARRAY["$name_column"]['name']);
            $fileName = $name_id_file . $ext;
            deleteFile($route, $fileName);
            move_uploaded_file($FILE_ARRAY["$name_column"]['tmp_name'], dirname(__FILE__) . $route . "$fileName");
        }
    }
    return $fileName;
}

/**
 * @version Esta función elimina el arcvhivo en la ruta especificada como parametro
 * @param $route : String con la ruta relativa del archivo
 * @param $fileName : String con el nombre del archivo que desea eliminar
 * @return bool : True el archivo fue eliminado correctamente, False el archivo no pudo ser eliminado
 */
function deleteFile($route, $fileName){
    $deleted = false;
    if (file_exists(dirname(__FILE__) . $route . "$fileName")) {
        try {
            if (unlink(dirname(__FILE__) . $route . "$fileName")) $deleted = true;
        } catch (Exception $e) {echo $e->getMessage();}
    }
    return $deleted;
}

/**
 * @param $fileName string: String del nombre del archivo mas la extensión.
 * @return string : Valor con la extensión del archivo con el punto, si se devuelve null, el archivo no tiene extensión
 */
function getExtFile($fileName){
    $ext = '';
    for ($i = 1; $i < strlen($fileName) - 1; $i++){
        if (substr($fileName, strlen($fileName) - $i, 1) == '.') {
            $ext = substr($fileName, strlen($fileName) - $i);
            break;
        }
    }
    return $ext;
}

/**
 * @param $table String: Nombre de la tabla en la que se desea consultar
 * @param $nameId String: Nombre del campo id que se desea consultar en su maximo valor
 * @return Int Valor entero del ultimo id ingresado en la tabla.
 */
function getLastID($table, $nameId){
    $number = 0;
    if ($table != null && $nameId != null) {
        $sql = "select max($nameId) as lastId from $table";
        if (is_array($result = Conector::ejecutarQuery($sql, null))) {
            if (count($result) > 0) {
                if (isset($result[0]['lastId']))
                    if ($result[0]['lastId'] != null) $number = $result[0]['lastId'];
            }
        }
    }
    return $number;
}

/**
 * @version Este método nos retorna el nombre de la página que es pasada como parametro y esta en md5()
 * @param $pageId String Md5 : Nombre de la página encriptada con md5()
 * @return string Nombre de la página correspondiente al $pageId, si el valor retornado es nulo la página no pertenece
 * a este rol.
 */
function getPageDocente($pageId){
    $pageName = '';
    if (is_dir(dirname(__FILE__) . './../../pages/docente/')){
        $dir = opendir(dirname(__FILE__) . './../../pages/docente/');
        while ($file = readdir($dir)) {
            if (is_file($file))
            {
                if ($pageId == md5($file)){
                    $pageName = $file;
                    break;
                }
            }
        }
    }
    return $pageName;
}