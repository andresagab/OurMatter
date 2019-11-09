/*
* Description: Aqui se alojan todas las funciones que son usadas por la pagina contenidos.php
* Autor: Andres Geovanny Angulo Botina.
* Email: andrescabj981@gmail.com
*/
$("#containerFull").ready(function () {

    statusToast(null);

});

/**
 * @version Con este método retornamos a la página padre de contenidos
 */
function backPageContent() {
    location.href = location.origin + location.pathname + '?pg=1';
};