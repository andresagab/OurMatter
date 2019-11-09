/*
* Description: Aqui se alojan todas las funciones que son usadas por la pagina docente.php
* Autor: Andres Geovanny Angulo Botina.
* Email: andrescabj981@gmail.com
*/
$("#containerFull").ready(function () {

    setTimeout(function () {
        loadData();
        statusToast(null);
    }, 500);

});

var page = {
    data: {
        all: {}
    }
};

/**
 * @description : Función para cargar los datos correspondientes a la configuración general de la página
 */
function loadData(){
    $.ajax({
        url: './../../php/Scripts/data_configuracion.php',
        type: 'GET',
        data: {
            method: 'loadConfig-All'
        },
        dataType: 'json',
        cache: false
    }).done(function (response) {
        if (response.valid) {
            page.data.all = response.data;
            setGeneralFields();
            setDocenteFields();
            setMateriaFields();
            refreshImg();
        }
        else {
            setValToastAction('11');
            statusToast(null);
        }
    }).fail(function (response) {
        setValToastAction('8');
        statusToast(null);
    });
}

/**
 * @description : Función para establecer los valores de los campos del formulario General de acuerdo con los datos
 * en el objeto JSON 'page.data.all'.
 */
function setGeneralFields(){
    if (validJSON(page.data.all)) {
        $("#txtNameInstitucion").val(page.data.all.name_institucion);
        $("#txtGrado").val(page.data.all.grado);
    }
}

/**
 * @description : Función para establecer los valores de los campos del formulario Docente de acuerdo con los datos
 * en el objeto JSON 'page.data.all'.
 */
function setDocenteFields(){
    if (validJSON(page.data.all)) {
        $("#txtNameDocente").val(page.data.all.name_docente);
        $("#txtEmailDocente").val(page.data.all.email_docente);
        $("#txtCelDocente").val(page.data.all.cel_docente);
        var img = '';
        $("#foto_Docente").attr('src', null);
        if (validImg(page.data.all.foto_docente)) img = loadImage('./../../img/docente/configuracion/' + page.data.all.foto_docente);
        else img = loadImage('./../../img/not_image.jpg');
        $("#foto_Docente").attr('src', img.src);
        $("#fotoDocente").val(null);
    }
}

/**
 * @description : Función para establecer los valores de los campos del formulario Materia de acuerdo con los datos
 * en el objeto JSON 'page.data.all'.
 */
function setMateriaFields(){
    if (validJSON(page.data.all)) {
        $("#txtNameMateria").val(page.data.all.name_materia);
        $("#txtDescripcionMateria").val(page.data.all.descripcion_materia);
        var imgPrincipal = null;
        var imgInformacion = null;
        if (validImg(page.data.all.img_materia)) imgPrincipal = loadImage('./../../img/docente/configuracion/' + page.data.all.img_materia);
        else imgPrincipal = loadImage('./../../img/not_image.jpg');
        if (validImg(page.data.all.img_materiaInformacion)) imgInformacion = loadImage('./../../img/docente/configuracion/' + page.data.all.img_materiaInformacion);
        else imgInformacion = loadImage('src', './../../img/not_image.jpg');
        $("#img_principal").attr('src', imgPrincipal.src);
        $("#img_informacion").attr('src', imgInformacion.src);
    }
}
/*--------------------------------------------------------------------------------------------------------------------*/
//FORM GENERAL
/**
 * @description Esta función ejecuta el envio del formulario 'frmGeneral' via AJAX, valida si los campos tienen
 * diferencias con respecto a los registro actuales y dependiendo de dicha evaluación ejecuta la tarea.
 */
function actionFrmGeneral() {
    if (validJSON(page.data.all)) {
        if ($("#txtNameInstitucion").val() != page.data.all.name_institucion || $("#txtGrado").val() != page.data.all.grado){
            spinnerLoad('#spinnerLoadHome', true);
            jQuery.ajax({
                url: './../../php/Scripts/data_configuracion.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    method: 'setData_General',
                    nombre_institucion: $("#txtNameInstitucion").val(),
                    grado: $("#txtGrado").val()
                }
            }).done(function (response) {
                if (response.status) setValToastAction(response.num_status);
                else setValToastAction(response.num_status);
                statusToast(null);
                loadData();
                spinnerLoad('#spinnerLoadHome', false);
            }).fail(function (response) {
                setValToastAction('8');
                statusToast(null);
                spinnerLoad('#spinnerLoadHome', false);
            });
        } else {
            setValToastAction('13');
            statusToast(null);
        }
    }
}

/**
 * @description Acciones correspondientes al hacer click sobre el boton de id "btnGeneralSave".
 */
function actionGeneralSave(){
    if (validElementsForm(['txtNameInstitucion', 'txtGrado'])) actionFrmGeneral();
    else {
        setValToastAction('12');
        statusToast(null);
    }
}

function actionGeneralCancel(){setGeneralFields();}
//END FORM GENERAL
/*-------------------------------------------------------------------------------------------------------------------*/
//FORM DOCENTE
/**
 * @description Esta función ejecuta el envio del formulario 'frmDocente' via AJAX, valida si los campos tienen diferencias con
 * respecto a los registro actuales y dependiendo de dicha evaluación ejecuta la tarea.
 */
function actionFrmDocente() {
    //Validamos que los datos de la página
    if (validJSON(page.data.all)) {

        //Validamos que por lo menos un campo tenga el valor diferente al cargado en la base de datos
        if ($("#txtNameDocente").val() != page.data.all.name_docente || $("#txtEmailDocente").val() != page.data.all.email_docente || $("#txtCelDocente").val() != page.data.all.cel_docente || inputFileValid(document.getElementById('fotoDocente'))){

            //Instanciamos el formData del input fotoDocente
            var fotoDocenteInput = document.getElementById('fotoDocente').files;
            var formData = getFormDataInput('fotoDocente');
            var files_send = 0;

            //Comprobamos que el archivo cargado sea diferente al que esta regisrado en la base de datos
            if (fotoDocenteInput.length > 0)
                if ('foto_docente_' + fotoDocenteInput[0].name != page.data.all.foto_docente) files_send = 1;

            //Mostramos el spinner de carga
            spinnerLoad('#spinnerLoadHome', true);

            //Ejecutamos la petición POST con AJAX
            jQuery.ajax({
                url: './../../php/Scripts/data_configuracion.php?method=setData_Docente&name_docente=' + $("#txtNameDocente").val() + '&email_docente=' + $("#txtEmailDocente").val() + '&cel_docente=' + $("#txtCelDocente").val() + '&files_send=' + files_send,
                type: 'POST',
                dataType: 'json',
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            }).done(function (response) {
                if (response.status) setValToastAction(response.num_status);
                else setValToastAction(response.num_status);
                statusToast(null);
                loadData();
                spinnerLoad('#spinnerLoadHome', false);
            }).fail(function (response) {
                setValToastAction('8');
                statusToast(null);
                spinnerLoad('#spinnerLoadHome', false);
            });
        } else {
            setValToastAction('13');
            statusToast(null);
        }
    }
}

/**
 * @description : Acciones correspondientes al hacer click sobre el boton de id "btnDocenteSave".
 */
function actionDocenteSave(){
    if (validElementsForm(['txtNameDocente', 'txtEmailDocente', 'txtCelDocente'])) actionFrmDocente();
    else {
        setValToastAction('12');
        statusToast(null);
    }
}

function actionDocenteCancel(){setDocenteFields();}

/**
 * Cuando el input con id 'fotoDocente' cambie se carga la foto en el visualizador de imagen correspondiente.
 * @param {HTMLElement} element Input de type img
 */
function actionImgDocente(element) {
    if (inputFileValid(element)) $("#foto_Docente").attr('src', URL.createObjectURL(element.files[0]));
    else $("#foto_Docente").attr('src', './../../img/not_image.jpg');
}
/*$("#fotoDocente").change(function () {
    if (inputFileValid(this)) $("#foto_Docente").attr('src', URL.createObjectURL(this.files[0]));
    else $("#foto_Docente").attr('src', './../../img/not_image.jpg');
});*/
//END FORM DOCENTE
/*-------------------------------------------------------------------------------------------------------------------*/
//FORM MATERIA
/**
 * @description Esta función ejecuta el envio del formulario 'frmMateria' via AJAX, valida si los campos tienen diferencias con
 * respecto a los registro actuales y dependiendo de dicha evaluación ejecuta la tarea.
 */
function actionFrmMateria() {
    //Validamos que los datos de la página
    if (validJSON(page.data.all)) {

        //Validamos que por lo menos un campo tenga el valor diferente al cargado en la base de datos
        if ($("#txtNameMateria").val() != page.data.all.name_materia || $("#txtDescripcionMateria").val() != page.data.all.descripcion_materia || inputFileValid(document.getElementById('imgPrincipal')) || inputFileValid(document.getElementById('imgInformacion'))){


            //Comprobamos que el archivo cargado sea diferente al que esta regisrado en la base de datos
            var files_send = '0';
            if (inputFileValid(document.getElementById('imgPrincipal')) || inputFileValid(document.getElementById('imgInformacion'))) files_send = '1';

            //Instanciamos el formData del input fotoDocente
            var formData = getFormDataInput(['imgPrincipal', 'imgInformacion']);

            //Mostramos el spinner de carga
            spinnerLoad('#spinnerLoadHome', true);

            //Ejecutamos la petición POST con AJAX
            jQuery.ajax({
                url: './../../php/Scripts/data_configuracion.php?method=setData_Materia&files_send=' + files_send + '&name_materia=' + $("#txtNameMateria").val() + '&descripcion_materia=' + $("#txtDescripcionMateria").val(),
                type: 'POST',
                dataType: 'json',
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            }).done(function (response) {
                if (response.status) setValToastAction(response.num_status);
                else setValToastAction(response.num_status);
                statusToast(null);
                loadData();
                spinnerLoad('#spinnerLoadHome', false);
                cleanInputFilesMateria();
            }).fail(function (response) {
                setValToastAction('8');
                statusToast(null);
                spinnerLoad('#spinnerLoadHome', false);
                cleanInputFilesMateria();
            });
        } else {
            setValToastAction('13');
            statusToast(null);
            cleanInputFilesMateria();
        }
    }
}

/**
 * @description : Acciones correspondientes al hacer click sobre el boton de id "btnDocenteSave".
 */
function actionMateriaSave() {
    if (validElementsForm(['txtNameMateria', 'txtDescripcionMateria'])) actionFrmMateria();
    else {
        setValToastAction('12');
        statusToast(null);
    }
}

function actionMateriaCancel() {setMateriaFields();};

/**
 * Cuando el input con id 'imgPrincipal' cambie se carga la foto en el visualizador de imagen correspondiente.
 * @param {HTMLElement} element Input de type img
 */
function actionImgMateriaPrincipal(element){
    if (inputFileValid(element)) $("#img_principal").attr('src', URL.createObjectURL(element.files[0]));
    else $("#img_principal").attr('src', './../../img/not_image.jpg');
}

/*$("#imgPrincipal").change(function () {
    if (inputFileValid(this)) $("#img_principal").attr('src', URL.createObjectURL(this.files[0]));
    else $("#img_principal").attr('src', './../../img/not_image.jpg');
});*/

/**
 * Cuando el input con id 'imgInformacion' cambie se carga la foto en el visualizador de imagen correspondiente.
 * @param {HTMLElement} element Input de type img
 */
function actionImgMateriaInformacion(element) {
    if (inputFileValid(element)) $("#img_informacion").attr('src', URL.createObjectURL(element.files[0]));
    else $("#img_informacion").attr('src', './../../img/not_image.jpg');
}
/*$("#imgInformacion").change(function () {
    if (inputFileValid(this)) $("#img_informacion").attr('src', URL.createObjectURL(this.files[0]));
    else $("#img_informacion").attr('src', './../../img/not_image.jpg');
});*/

/**
 * @description Esta función limpia los valores de los inputs file con id 'imgPrincipal' e 'imgInformacion'
 */
function cleanInputFilesMateria() {
    document.getElementById('imgPrincipal').value = null;
    document.getElementById('imgInformacion').value = null;
}
//END FORM MATERIA