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
function openFrm(id) {
    if (id != null) $("#contentPage").load('./contenidosFrm.php?id=' + id);
    else $("#contentPage").load('./contenidosFrm.php');
    loadScript('./../../js/docente/contenidosFrm.js');
    exeTooltip();
};

function deleteRecord(id) {
    location.href = './contenidosUpdate.php?method=delete&id=' + id;
}