/*
* Description: Aqui se alojan todas las funciones que son usadas por la pagina contenidos.php
* Autor: Andres Geovanny Angulo Botina.
* Email: andrescabj981@gmail.com
*/
$("#containerFull").ready(function () {

    statusToast(null);
    exeTooltip();

});

/**
 * @description Esta método abre el formulario de registro.
 */
function openFrm(id, file) {
    if (id != null) location.href = location.origin + location.pathname + '?pg=5&fl=' + file + '&id=' + id;
    else location.href = location.origin + location.pathname + '?pg=5&fl=' + file;
};

/**
 * @description Método para abrir el archivo que ejecuta el borrado de un registro pasado por el id
 * @param id Valor de la clave correspondiente al registro que se envia.
 */
function deleteRecord(id) {location.href = './contenidosUpdate.php?method=delete&id=' + id;}

/**
 * @description Método que abre el registro pasado por id en la nueva página file
 * @param id Valor del registro que se desea abrir.
 * @param {String} file Nombre del archivo quie se desea abrir mas su extensión.
 */
function openContenido(id, file) {location.href = location.origin + location.pathname + '?pg=5&fl=' + file + '&idP=' + id;}