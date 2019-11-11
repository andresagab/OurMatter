/**
* @Description: Aqui se alojan todas las funciones que son usadas por la pagina evaluacionesFrm.php
* @Autor: Andres Geovanny Angulo Botina.
* @Email: andrescabj981@gmail.com
*/
$("#containerFull").ready(function () {

    statusToast(null);
    document.getElementById('txtNombre').focus();
    setPrevDates();

});

var dates = {
    fechaInicial: null,
    fechaFin: null
};

/**
 * @description Con este método retornamos a la página Estudiantes.php
 */
function backPage() {location.href = location.origin + location.pathname + '?pg=2'};

/**
 * @description Este método valida que la fecha de inicio sea mayor que la actual e inferior que la final
 */
function validDates() {
    var fechaInicio = document.getElementById('txtFechaInicio');
    var fechaFin = document.getElementById('txtFechaFin');
    var date = new Date();
    var status = false;
    if (fechaInicio != null) {
        fechaInicio = new Date(fechaInicio.value);
        if (fechaInicio > date) {
            if (fechaFin != null) {
                fechaFin = new Date(fechaFin.value);
                if (fechaFin > fechaInicio) status = true;
            }
        }
    }
    if (status) document.getElementById('btnAcceptFrm').disabled = false;
    else document.getElementById('btnAcceptFrm').disabled = true;
}

/**
 * @description Este método asigna el valor de fecha inicio y fecha fin a los campos correspondientes cuando se vaya
 * a editar un registro
 */
function setPrevDates() {
    if (document.getElementById('prevFI') != null && document.getElementById('prevFF') != null) {
        var data = document.getElementById('prevFI').value.split(' ');
        document.getElementById('txtFechaInicio').value = data[0] + "T" + data[1].substring(0, 5);
        dates.fechaInicial = new Date(document.getElementById('txtFechaInicio').value);
        data = document.getElementById('prevFF').value.split(' ');
        document.getElementById('txtFechaFin').value = data[0] + "T" + data[1].substring(0, 5);
        dates.fechaFin = new Date(document.getElementById('txtFechaFin').value);
    }
}