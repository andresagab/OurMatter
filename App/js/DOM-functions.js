/*
* Autor: Andres Geovanny Angulo Botina
* Email: andresgeovanny@udenar.edu.co
* */
$(document).ready(function () {
    var heigth = $("body").height() - ($("#navbarMenu").height() + parseInt($("#navbarMenu").css("padding-top").toString().substring(0, $("#navbarMenu").css("padding-top").toString().indexOf("px", 0))));
    $("#containerFull").height(heigth - 9);
    $("#containerFull").load('./App/pages/publico/inicio.html');

    $("#btnHome").click(function () {
        $("#containerFull").load('./App/pages/publico/inicio.html');
    });

    $("#btnInformacionMain").click(function () {
        $("#containerFull").load('./App/pages/publico/informacion.html');
    });

    $("#btnContactoMain").click(function () {
        $("#containerFull").load('./App/pages/publico/contacto.html');
    });

    $("#btnLogIn").click(function () {
        alert("La ventana modal del inicio de sesión será desarrollada en la siguiente iteración")
    });
});

$(window).resize(function () {
    $("body").height("100%");
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});
