/**
* @Description Aqui se alojan todas las funciones que son usadas por la pagina main.php del rol estudiante
* @author Andres Geovanny Angulo Botina.
* @Email andrescabj981@gmail.com
*/
$("#containerFull").ready(function () {

    statusToast(null);

});

/**
 * @description Método que abre el registro pasado por id en la nueva página file
 * @param id Valor del registro que se desea abrir.
 * @param {String} file Nombre del archivo quie se desea abrir mas su extensión.
 */
function openRouteWithData(id, file) {location.href = location.origin + location.pathname + '?pg=3&fl=' + file + '&idP=' + id;}

/**
 * @description Método que redirecciona a la página evaluaciones.
 */
function openEvaluaciones() {location.href = location.origin + location.pathname + '?pg=2';}