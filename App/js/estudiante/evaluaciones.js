/**
* @Description Aqui se alojan todas las funciones que son usadas por la pagina evaluaciones.php
* @author Andres Geovanny Angulo Botina.
* @Email andrescabj981@gmail.com
*/
$("#containerFull").ready(function () {

    statusToast(null);

});

/**
 * @description Método que abre la página que permite desarrollar la evaluación
 * @param id Valor de la clave de la evaluación.
 * @param {String} file Nombre del archivo quie se desea abrir mas su extensión.
 */
function desarrollarEvaluacion(id, file) {location.href = location.origin + location.pathname + '?pg=3&fl=' + file + '&id=' + id;}
