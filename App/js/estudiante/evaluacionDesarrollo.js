/**
* @Description Aqui se alojan todas las funciones que son usadas por la pagina evaluacionDesarrollo.php
* @author Andres Geovanny Angulo Botina.
* @Email andrescabj981@gmail.com
*/
$("#containerFull").ready(function () {

    statusToast(null);
    if (document.getElementById('timer') != null) remainTime();

});

/**
 * @description Método que abre la página en el valor 1 de pg
 */
function backPrincipalPage() {location.href = location.origin + location.pathname + '?pg=2';}

/**
 *
 * @param id {int|string} Id de la evaluación ejecución
 * @param file {string} Nombre del archivo en md5
 * @description Método que abre el archivo pasado por file
 */
function openRetroalimentacion(id, file) {location.href = location.origin + location.pathname + '?pg=3&fl=' + file + '&id=' + id;}

function remainTime() {
    var time = document.getElementById('timer').value.split(":");
    var hours = time[0];
    var minutes = time[1];
    var seconds = time[2];
    if (hours == 0 && minutes == 0 && seconds == 0) $("#frmEvaluacionDesarrollo").submit();
    setInterval(function () {
        seconds--;
        if (hours == 0 && minutes == 0 && seconds == 0) $("#frmEvaluacionDesarrollo").submit();
        if (seconds < 0) {
            minutes--;
            seconds = 59;
        }
        if (minutes < 0) {
            hours--;
            minutes = 59;
        }
        var partHours = '00';
        var partMinutes = '00';
        var partSeconds = '00';
        if (hours>0) {
            if (hours<10) partHours = '0' + hours;
            else partHours = hours;
        }
        if (minutes>0) {
            if (minutes<10) partMinutes = '0' + minutes;
            else partMinutes = minutes;
        }
        if (seconds>0) {
            if (seconds<10) partSeconds = '0' + seconds;
            else partSeconds = seconds;
        }
        $('#txtTimer').text(partHours + ":" + partMinutes + ":" + partSeconds);
    }, 1000);
};