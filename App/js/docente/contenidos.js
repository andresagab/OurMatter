/*
* Description: Aqui se alojan todas las funciones que son usadas por la pagina contenidos.php
* Autor: Andres Geovanny Angulo Botina.
* Email: andrescabj981@gmail.com
*/
$("#containerFull").ready(function () {

    statusToast(null);
    exeTooltip();

});

/**
 * @description Esta método abre el formulario de registro.
 */
function openFrm(id, file) {
    if (id != null) location.href = location.origin + location.pathname + '?pg=5&fl=' + file + '&id=' + id;
    else location.href = location.origin + location.pathname + '?pg=5&fl=' + file;
};

function deleteRecord(id) {
    location.href = './contenidosUpdate.php?method=delete&id=' + id;
}