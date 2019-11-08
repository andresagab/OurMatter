/*
* Description: Aqui se alojan todas las funciones que son usadas por la pagina contenidos.php
* Autor: Andres Geovanny Angulo Botina.
* Email: andrescabj981@gmail.com
*/
$("#containerFull").ready(function () {

    statusToast(null);

});

function backPageContent() {
    $("#contentPage").load('./contenidos.php');
};