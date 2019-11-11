/*
* Autor: Andres Geovanny Angulo Botina
* Email: andresgeovanny@udenar.edu.co
* */
$(document).ready(function () {

    spinnerLoad('#spinnerLoadHome', false);
    exeTooltip();

    var heigth = $("body").height() - ($("#navbarMenu").height() + parseInt($("#navbarMenu").css("padding-top").toString().substring(0, $("#navbarMenu").css("padding-top").toString().indexOf("px", 0))));
    $("#containerFull").height(heigth - 9);

    $("#btnLogOut").click(function () {
        logOut();
    });
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