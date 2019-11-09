/**
 * @description Archivo con las funciones generales del rol docente
 * @Autor: Andres Geovanny Angulo Botina
 * @Email: andresgeovanny@udenar.edu.co
* */

$(document).ready(function () {
    //MAIN CONF
    spinnerLoad('#spinnerLoadHome', false);
    exeTooltip();
    var heigth = $("body").height() - ($("#navbarMenu").height() + parseInt($("#navbarMenu").css("padding-top").toString().substring(0, $("#navbarMenu").css("padding-top").toString().indexOf("px", 0))));
    $("#containerFull").height(heigth - 9);

    $("#btnLogOut").click(function () {logOut();});
    //END MAIN CONF
    /*---------------------------------------------------------------------------------------------------------------*/
});

$(window).resize(function () {
    $("body").height("100%");
});

/**
 * @description Se hace el llamado al cierre de sesiones
 */
function logOut() {
    jQuery.ajax({
        url: '../../php/Scripts/login.php',
        type: 'GET',
        dataType: 'json',
        data: {method: 'logOut'}
    }).done(function (response) {
        console.log(location);
        if (response.status === 'OK') location.href = location.origin + location.pathname + "?out=true";
    }).fail(function (response) {
        console.log(response);
    }).always(function () {
        console.log("Complete.")
    });
}