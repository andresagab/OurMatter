/**
* @Description Aqui se alojan todas las funciones que son usadas por la pagina evaluaciones.php
* @author Andres Geovanny Angulo Botina.
* @Email andrescabj981@gmail.com
*/
$("#containerFull").ready(function () {

    statusToast(null);

});

/**
 * @description Esta método abre el formulario de registro.
 * @param id Valor correspondiente a la llave del objeto
 * @param {String} file Nombre del archivo quie se desea abrir mas su extensión.
 */
function openRetroAlimentacion(id, file) {
    if (id != null) location.href = location.origin + location.pathname + '?pg=5&fl=' + file + '&id=' + id;
    else location.href = location.origin + location.pathname + '?pg=5&fl=' + file;
};

/**
 * @description Esta método retornar a la página evaluaciones del rol docente
 */
function backPrincipalPage() {
    location.href = location.origin + location.pathname + '?pg=2';
};
