/**
* @Description: Aqui se alojan todas las funciones que son usadas por la pagina opcionesPreguntaFrm.php
* @Autor: Andres Geovanny Angulo Botina.
* @Email: andrescabj981@gmail.com
*/
$("#containerFull").ready(function () {

    statusToast(null);
    document.getElementById('txtOpcion_1').focus();

});

/**
 * @version Con este método retornamos a la página padre de contenidos
 * @param idP Valor correspondiente a la clave del objeto padre
 * @param {String} file Nombre del archivo quie se desea abrir mas su extensión.
 */
function backPageContentParent(idP, file) {location.href = location.origin + location.pathname + '?pg=5&fl=' + file + '&idP=' + idP;};