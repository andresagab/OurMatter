/**
* @Description Aqui se alojan todas las funciones que son usadas por la pagina evaluaciones.php
* @author Andres Geovanny Angulo Botina.
* @Email andrescabj981@gmail.com
*/
$("#containerFull").ready(function () {

    statusToast(null);

});

/**
 * @description Esta método abre la retroalimentación de una evaluación
 * @param id Valor correspondiente a la llave del la evaluacion_ejecución
 * @param {String} file Nombre del archivo quie se desea abrir mas su extensión.
 */
function openRetroalimentacion(id, file) {
    location.href = location.origin + location.pathname + '?pg=5&fl=' + file + '&id=' + id;
};

/**
 * @description Esta método retornar a la página evaluaciones del rol docente
 */
function backPrincipalPage() {
    location.href = location.origin + location.pathname + '?pg=2';
};
