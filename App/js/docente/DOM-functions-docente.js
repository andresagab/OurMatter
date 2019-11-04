/*
* Autor: Andres Geovanny Angulo Botina
* Email: andresgeovanny@udenar.edu.co
* */
$(document).ready(function () {
    //MAIN CONF
    var heigth = $("body").height() - ($("#navbarMenu").height() + parseInt($("#navbarMenu").css("padding-top").toString().substring(0, $("#navbarMenu").css("padding-top").toString().indexOf("px", 0))));
    $("#containerFull").height(heigth - 9);
    $("#contentPage").load('./main.php');
    statusToast(null);
    spinnerLoad('#spinnerLoadHome', false);

    $("#btnHome").click(function () {$("#contentPage").load('./main.php');});
    $("#btnConfiguracion").click(function () {
        $("#contentPage").load('./configuracion.php');
        loadScript('./../../js/docente/configuracion.js');
    });

    $("#btnLogOut").click(function () {logOut();});
    //END MAIN CONF
    /*---------------------------------------------------------------------------------------------------------------*/
});

$(window).resize(function () {
    $("body").height("100%");
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});

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