/**
* @Description Aqui se alojan todas las funciones que son usadas por la pagina evaluacionEstudianteRetroalimentacion.php
* @author Andres Geovanny Angulo Botina.
* @Email andrescabj981@gmail.com
*/
$("#containerFull").ready(function () {

    statusToast(null);

});

/**
 * @description Esta método retornar a la página evaluaciones del rol docente
 * @param id Valor correspondiente a la llave del objeto evaluacion
 * @param {String} file Nombre del archivo quie se desea abrir mas su extensión.
 */
function backToEvaluacionEstudiantes(id, file) {
    location.href = location.origin + location.pathname + '?pg=5&fl=' + file + '&id=' + id;
};
