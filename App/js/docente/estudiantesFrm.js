/**
* @Description: Aqui se alojan todas las funciones que son usadas por la pagina estudiantes.php
* @Autor: Andres Geovanny Angulo Botina.
* @Email: andrescabj981@gmail.com
*/
$("#containerFull").ready(function () {

    statusToast(null);
    document.getElementById('txtNombres').focus();

});

/**
 * @description Con este método retornamos a la página Estudiantes.php
 */
function backPage() {location.href = location.origin + location.pathname + '?pg=3'};

/**
 * @description Este método genera un nombre de usuario con la abreviación est_ más las dos primeras letras del nombre
 * y las dos primeras letras del apellido, este valor se asigna automaticamente al input de id 'txtUsuario'
 * @param nextId Valor del siguiente id
 */
function generateUserName(nextId) {
    var userName = '';
    var txtNombres = document.getElementById('txtNombres');
    var txtApellidos = document.getElementById('txtApellidos');
    if (txtNombres != null) {
        if (txtNombres.value != null) {
            if (txtNombres.value.length >= 3) userName += txtNombres.value.toLowerCase().substring(0, 3);
            else document.getElementById('txtUsuario').value = null;
        }
    }
    if (txtApellidos != null) {
        if (txtApellidos.value != null) {
            if (txtApellidos.value.length >= 3) userName += txtApellidos.value.toLowerCase().substring(0, 3) + '_' + nextId;
            else document.getElementById('txtUsuario').value = null;
        }
    }
    if (txtNombres.value.length >= 3 && txtApellidos.value.length >= 3) document.getElementById('btnAcceptFrm').disabled = false;
    else document.getElementById('btnAcceptFrm').disabled = true;
    document.getElementById('txtUsuario').value = userName;
}