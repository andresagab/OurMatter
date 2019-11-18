/*
* Autor: Andres Geovanny Angulo Botina
* Email: andresgeovanny@udenar.edu.co
* */
$(document).ready(function () {
    var heigth = $("body").height() - ($("#navbarMenu").height() + parseInt($("#navbarMenu").css("padding-top").toString().substring(0, $("#navbarMenu").css("padding-top").toString().indexOf("px", 0))));
    $("#containerFull").height(heigth - 9);
    /*$("#containerFull").load('./App/pages/publico/inicio.php');*/

    /*$("#btnHome").click(function () {$("#containerFull").load('./App/pages/publico/inicio.php');});

    $("#btnInformacionMain").click(function () {$("#containerFull").load('./App/pages/publico/informacion.php');});

    $("#btnContactoMain").click(function () {$("#containerFull").load('./App/pages/publico/contacto.php');});*/

    $("#btnCloseModalLogin, #btnCancelModalLogin, #btnLogIn").click(function () {clearFormLogin();});

    validMessageAlert();
    validFormForId();

});

$(window).resize(function () {$("body").height("100%");});

function clearFormLogin(){
    $("#txtUsuario").val(null);
    $("#txtPassword").val(null);
}

//BOOTSTRAP FUNCTIONS

$(function () {$('[data-toggle="tooltip"]').tooltip()});

function showToast(idToast) {$(idToast).toast('show');}

function validFormForId() {
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
}

function validMessageAlert() {
    if (document.getElementById('toastAction') != null) {
        if ($('#toastAction').val() === '0') $("#textToast").text("Haz intentado iniciar sesión incorrectamente, vuelve a ingresar e intentalo de nuevo.");
        else if ($('#toastAction').val() === '1') $("#textToast").text("El usuario o la contraseña son incorrectos, intentalo nuevamente");
        else if ($('#toastAction').val() === '-1') $("#textToast").text("Intentaste acceder a un sitio restringido, inicia sesión nuevamente.");
        else if ($('#toastAction').val() === '-2') $("#textToast").text("No se puede iniciar sesión porque no esposible establecer la conexión con el servidor o la base de datos.");
        else if ($('#toastAction').val() === '-3') $("#textToast").text("No se pudo enviar el correo electronico.");
        else if ($('#toastAction').val() === '-4') $("#textToast").text("Correo electronico enviado correctamente.");
        if ($('#toastAction').val() != '2') showToast('.toast');
        else {
            $('.toast').toast('hide');
            $("#textToast").text("");
        }
    }
}

//END BOOTSTRAP FUNCTIONS