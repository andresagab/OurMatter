/**
* @Description Aqui se alojan todas las funciones que son usadas por la pagina evaluacionRetroalimentacion.php
* @author Andres Geovanny Angulo Botina.
* @Email andrescabj981@gmail.com
*/
$("#containerFull").ready(function () {

    statusToast(null);
    if (document.getElementById('timer') != null) remainTime();

});

/**
 * @param id {int|string} Id de la evaluación
 * @param file {string} Nombre del archivo en md5
 * @description Método que abre la página en el valor file
 */
function backPrincipalPage(id, file) {location.href = location.origin + location.pathname + '?pg=3&fl=' + file + '&id=' + id;}