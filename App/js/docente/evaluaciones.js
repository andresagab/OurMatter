/**
* @Description Aqui se alojan todas las funciones que son usadas por la pagina evaluaciones.php
* @author Andres Geovanny Angulo Botina.
* @Email andrescabj981@gmail.com
*/
$("#containerFull").ready(function () {

    statusToast(null);

});

/**
 * @description Esta método abre el formulario de registro.
 * @param id Valor correspondiente a la llave del objeto
 * @param {String} file Nombre del archivo quie se desea abrir mas su extensión.
 */
function openFrm(id, file) {
    if (id != null) location.href = location.origin + location.pathname + '?pg=5&fl=' + file + '&id=' + id;
    else location.href = location.origin + location.pathname + '?pg=5&fl=' + file;
};

/**
 * @description Esta método abre la página correspondiente al listado de estudiantes que desarrollaron la evaluación.
 * @param id Valor correspondiente a la llave de la evaluación
 * @param {String} file Nombre del archivo quie se desea abrir mas su extensión.
 */
function openEvaluacionEstudiantes(id, file) {
    location.href = location.origin + location.pathname + '?pg=5&fl=' + file + '&id=' + id;
};

/**
 * @description Método para abrir el archivo que ejecuta el borrado de un registro pasado por el id
 * @param id Valor de la clave correspondiente al registro que se envia.
 */
function deleteRecord(id) {location.href = './evaluacionesUpdate.php?method=delete&id=' + id;}

/**
 * @description Método que abre el registro pasado por id en la nueva página file
 * @param id Valor del registro que se desea abrir.
 * @param {String} file Nombre del archivo quie se desea abrir mas su extensión.
 */
function openEvaluacion(id, file) {location.href = location.origin + location.pathname + '?pg=5&fl=' + file + '&idP=' + id;}
