/**
* @Description Aqui se alojan todas las funciones que son usadas por la pagina preguntasEvaluacion.php
* @author Andres Geovanny Angulo Botina.
* @Email andrescabj981@gmail.com
*/
$("#containerFull").ready(function () {

    statusToast(null);

});

/**
 * @description Esta método abre el formulario de registro.
 * @param idP Valor correspondiente a la llave del objeto padre
 * @param id Valor correspondiente a la llave del objeto
 * @param {String} file Nombre del archivo quie se desea abrir mas su extensión.
 */
function openFrm(idP, id, file) {
    if (id != null) location.href = location.origin + location.pathname + '?pg=5&fl=' + file + '&idP=' + idP + '&id=' + id;
    else location.href = location.origin + location.pathname + '?pg=5&fl=' + file + '&idP=' + idP;
};

/**
 * @description Método para abrir el archivo que ejecuta el borrado de un registro pasado por el id
 * @param idP Valor correspondiente a la llave del objeto padre
 * @param id Valor de la clave correspondiente al registro que se envia.
 */
function deleteRecord(idP, id) {location.href = './preguntasEvaluacionUpdate.php?method=delete&idP=' + idP + '&id=' + id;}

/**
 * @description Método que abre el registro pasado por id en la nueva página file
 * @param id Valor del registro que se desea abrir.
 * @param {String} file Nombre del archivo quie se desea abrir mas su extensión.
 */
function openContenido(id, file) {location.href = location.origin + location.pathname + '?pg=5&fl=' + file + '&idP=' + id;}

/*--------------------------------------------------------------------------------------------------------------------*/
//ACCIONES OPCIONES RESPUESTA

/**
 * @description Esta método abre el formulario de registro.
 * @param idP Valor correspondiente a la llave del objeto padre
 * @param id Valor correspondiente a la llave del objeto
 * @param {String} file Nombre del archivo quie se desea abrir mas su extensión.
 */
function openOpcionesFrm(idP, id, file) {
    if (id != null) location.href = location.origin + location.pathname + '?pg=5&fl=' + file + '&idP=' + idP + '&id=' + id;
    else location.href = location.origin + location.pathname + '?pg=5&fl=' + file + '&idP=' + idP;
};

/**
 * @description Método para abrir el archivo que ejecuta el borrado de un registro pasado por el id
 * @param idP Valor correspondiente a la llave del objeto padre
 * @param id Valor de la clave correspondiente al registro que se envia.
 */
function deleteRecordsOpciones(idP, id) {location.href = './opcionesPreguntaUpdate.php?method=delete&idP=' + idP + '&id=' + id;}

//END ACCIONES OPCIONES RESPUESTA