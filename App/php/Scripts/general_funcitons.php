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

/**
 * @version Este método nos retorna el nombre de la página que es pasada como parametro y esta en md5()
 * @param $pageId String Md5 : Nombre de la página encriptada con md5()
 * @return string Nombre de la página correspondiente al $pageId, si el valor retornado es nulo la página no pertenece
 * a este rol.
 */
function getPageEstudiante($pageId){
    $pageName = '';
    if (is_dir(dirname(__FILE__) . './../../pages/estudiante/')){
        $dir = opendir(dirname(__FILE__) . './../../pages/estudiante/');
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

function getColorPredominant($sourceFile){
    //$sourceFile = "imagen1.jpg";
    $i = imagecreatefromjpeg($sourceFile);
    $rTotal = 0;
    $vTotal = 0;
    $aTotal = 0;
    $total = 0;
    for ($x=0;$x<imagesx($i);$x++) {
        for ($y=0;$y<imagesy($i);$y++) {
            $rgb = imagecolorat($i,$x,$y);
            $r   = ($rgb >> 16) & 0xFF;
            $v   = ($rgb >> 8) & 0xFF;
            $a   = $rgb & 0xFF;
            $rTotal += $r;
            $vTotal += $v;
            $aTotal += $a;
            $total++;
        }
    }
    $rPromedio = round($rTotal/$total);
    $vPromedio = round($vTotal/$total);
    $aPromedio = round($aTotal/$total);
    //echo "<img src='".$sourceFile."' width='400' />";
    echo "<div style='display:block;height:50px;width:400px;background-color:rgb(".$rPromedio.",".$vPromedio.",".$aPromedio.")'>";
}

/**
 * @param $table nombre de la tabla que se desea consultar
 * @param $fieldShow nombre del campo que se presentara como option
 * @param $fieldValue valor del option
 * @param $filter filtro para la cadena sql
 * @param $order ordem para la cadena sql
 * @param $nameSelect nombre del elemento select (name, id)
 * @param $predetermined valor predeterminado
 * @return string Cadena con el select compuesto por los registros encontrados en la base de datos.
 */
function getDataInSelectHTML($table, $fieldShow, $fieldValue, $filter, $order, $nameSelect, $predetermined){
    $html = "<select class='custom-select' id='$nameSelect' name='$nameSelect' required>";
    $sql = "SELECT $fieldShow, $fieldValue FROM $table $filter $order";
    if (is_array($result = Conector::ejecutarQuery($sql, null))) {
        if (count($result) > 0) {
            for ($i = 0; $i < count($result); $i++) {
                if ($predetermined == $result[$i][$fieldValue]) $html .= "<option value='{$result[$i]["$fieldValue"]}' selected>{$result[$i]["$fieldShow"]}</option>";
                else $html .= "<option value='{$result[$i]["$fieldValue"]}'>{$result[$i]["$fieldShow"]}</option>";
            }
        }
    }
    $html .= "</select>";
    return $html;
}

/**
 * @param $valDate String Fecha y hora de tipo input datetime-local
 * @return string Fecha y hora para ser usado en objetos Date o para ser insertado en regisro SQL
 */
function getDateOfInput($valDate) {
    $date = substr($valDate, 0, 10);
    $time = substr($valDate, 11, 5);
    return "$date $time";
}

/**
 * @version Método que retorna un nombre de color aleatorio de bootstrap:
 * 0 = primary
 * 1 = success
 * 2 = warning
 * 3 = info
 * 4 = danger
 * 5 = secondary
 * 6 = dark
 * @param $min Valor minimo del color
 * @param $max Valor maximo del color
 * @return mixed|string Nombre del color para bootstrap text-{color}
 */
function getRandomColorText($min, $max) {
    $color = '';
    if ($min != null && $max != null) {
        $colors = ['primary', 'success', 'warning', 'info', 'danger', 'secondary', 'dark'];
        $color = $colors[rand((Int) $min, (Int) $max)];
    }
    return $color;
}