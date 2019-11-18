/**
* @Description Aqui se alojan todas las funciones que son usadas por la pagina evaluacionesEstudiante.php
* @author Andres Geovanny Angulo Botina.
* @Email andrescabj981@gmail.com
*/
$("#containerFull").ready(function () {

    statusToast(null);

});

/**
 * @description Esta método abre la retroalimentación de la evaluación.
 * @param id Valor correspondiente a la llave de la evaluacion
 * @param {String} file Nombre del archivo quie se desea abrir mas su extensión.
 */
function openRetroalimentacion(id, file) {
    location.href = location.origin + location.pathname + '?pg=5&fl=' + file + '&id=' + id + '&BE=1';
};

/**
 * @description Esta método retornar a la página evaluaciones del rol docente
 */
function backPrincipalPage() {
    location.href = location.origin + location.pathname + '?pg=3';
};