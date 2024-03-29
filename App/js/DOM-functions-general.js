/*
* Description: Este archivo contiene las funciones de uso común por la mayoria de la páginas
* Autor: Andres Geovanny Angulo Botina
* Email: andrescabj981@gmail.com
* */

/**
 * @description Esta función permite cargar un script js apartir de su ruta relativa
 * @param {String} url : ruta relativa del archivo que se desea cargar al DOM
 */
function loadScript(url){
    var head = document.getElementsByTagName('head')[0];
    var script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = url;
    //script.onreadystatechange = callback;
    //script.onload = callback;
    head.appendChild(script);
}

/**
 * @param {String} idElement : Valor del id del elemento
 * @return {Boolean} : True = el elemento existe, False = el elemento no existe.
 * */
function existElement(idElement) {
    if (document.getElementById(idElement) != null) return true;
    else return false;
}

/**
* @param {JSON} json: Objeto de tipo json
* @return {Boolean}: True el valor pasado como parametro es un objeto json valido - False: el objeto no es un valor json valido
* */
function validJSON(json) {
    if (json != undefined) return true;
    else return false;
}

/**
 * @param {String} img: Campo con el nombre del archivo
 * @return {Boolean}: True la imagen es valida - False la imagen esta vacia o no es valida
 */
function validImg(img) {
    if (img != null && img != 'not_image' && img != '') return true;
    else return false;
}

/**
* @param {String} id: Campo con el id que contiene al toast - Ejm: '#spinnerLoadX'
* @param {Boolean} status: Campo que representa el estado deseado - False = oculto : True = mostrar
*/
function spinnerLoad(id, status) {
    if (!status) $(id).hide('fast');
    else $(id).show('fast');
}

/**
* @param {String} extraMjs: Valor con el mensaje deseado o el número de datos que fueron cargados.
* @description este método se lanza o se oculta el toast con id 'toastAction', al ser lanzado se establece el mensaje
* de acuerdo al número de estado:
* 0 = todo esta funcionando normalmente el toast se oculta.
* 1 = Los datos fueron agregados correctamente.
* 2 = Los datos fueron modificados correctamente.
* 3 = Los datos fueron eliminados correctamente.
* 4 = Los datos fueron cargados correctamente.
* 5 = Se cargaron 'extraMjs' registros correctamente.
* 6 = El mensaje será lo contenido en extraMjs.
* 7 = Error al ejecutar la acción requerida.
* 8 = No se pudo conectar con el servidor o no se encontro el archivo deseado.
* 9 = No tiene los permisos necesarios para acceder al sitio deseado.
* 10 = Oups! Al parecer la sesión ha caducado, vuelve a ingresar e intentalo nuevamente.
* 11 = Oups! Ocurrio un error al cargar los datos, intentalo nuevamente.
* 12 = Algunos campos del formulario no son correctos, verificalos e intentalo nuevamente.
* 13 = Los datos actuales no serán modificados.
* 14 = Algunos datos se ejecutaron correctamente, sin embargo se registro una falla con otra porción de los datos.
* 15 = No se pudo conectar con la base de datos.
* 16 = Aún no se han registrado datos.
* 17 = Evaluación enviada correctamente.
* 18 = Ocurrio un error al registrar tu evaluación, intentalo nuevamente.
* 19 = Evaluación enviada correctamente, sin embargo no respondiste todas las preguntas.
* */
function statusToast(extraMjs) {
    if (document.getElementById('toastAction') != null) {
        var num_status = $('#toastAction').val();
        var mjs = "";
        if (num_status === '1') mjs = "Los datos fueron agregados correctamente.";
        else if (num_status === '2') mjs = "Los datos fueron modificados correctamente.";
        else if (num_status === '3') mjs = "Los datos fueron eliminados correctamente.";
        else if (num_status === '4') mjs = "Los datos fueron cargados correctamente.";
        else if (num_status === '5') mjs = "Se cargaron " + extraMjs + " registros correctamente.";
        else if (num_status === '6') mjs = extraMjs;
        else if (num_status === '7') mjs = "Error al ejecutar la acción requerida.";
        else if (num_status === '8') mjs = "No se pudo conectar con el servidor o no se encontro el archivo deseado.";
        else if (num_status === '9') mjs = "No tiene los permisos necesarios para acceder al sitio deseado.";
        else if (num_status === '10') mjs = "Oups! Al parecer la sesión ha caducado, vuelve a ingresar e intentalo nuevamente.";
        else if (num_status === '11') mjs = "Oups! Ocurrio un error al cargar los datos, intentalo nuevamente.";
        else if (num_status === '12') mjs = "Algunos campos del formulario no son correctos, verificalos e intentalo nuevamente.";
        else if (num_status === '13') mjs = "Los datos actuales no serán modificados.";
        else if (num_status === '14') mjs = "Algunos datos se ejecutaron correctamente, sin embargo se registro una falla con otra porción de los datos.";
        else if (num_status === '15') mjs = "No se pudo conectar con la base de datos.";
        else if (num_status === '16') mjs = "Aún no se han registrado datos.";
        else if (num_status === '17') mjs = "Evaluacion enviada correctamente.";
        else if (num_status === '18') mjs = "Ocurrio un error al registrar tu evaluación, intentalo nuevamente.";
        else if (num_status === '19') mjs = "Evaluación enviada correctamente, sin embargo no respondiste todas las preguntas.";
        $('#textToast').text(mjs);
        if (num_status != 0) $('.toast').toast('show');
        else $('.toast').toast('hide');
    }
}

/**
 * @param {String} num_status: Valor correspondiente al estado deseado.
 * @description : Aqui se establece el valor del número de estado que se desea presentar en el toast:
 *
 * 0 = todo esta funcionando normalmente el toast se oculta.
 * 1 = Los datos fueron agregados correctamente.
 * 2 = Los datos fueron modificados correctamente.
 * 3 = Los datos fueron eliminados correctamente.
 * 4 = Los datos fueron cargados correctamente.
 * 5 = Se cargaron 'extraMjs' registros correctamente.
 * 6 = El mensaje será lo contenido en extraMjs.
 * 7 = Error al ejecutar la acción requerida.
 * 8 = No se pudo conectar con el servidor o no se encontro el archivo deseado.
 * 9 = No tiene los permisos necesarios para acceder al sitio deseado.
 * 10 = Oups! Al parecer la sesión ha caducado, vuelve a ingresar e intentalo nuevamente.
 * 11 = Oups! Ocurrio un error al cargar los datos, intentalo nuevamente.
 * 12 = Algunos campos del formulario no son correctos, verificalos e intentalo nuevamente.
 * 13 = Los datos actuales no serán modificados.
 * 14 = Algunos datos se ejecutaron correctamente, sin embargo se registro una falla con otra porción de los datos.
 * 15 = No se pudo conectar con la base de datos.
 * 16 = Aún no se han registrado datos.
 * 17 = Evaluación enviada correctamente.
 * 18 = Ocurrio un error al registrar tu evaluación, intentalo nuevamente.
 * 19 = Evaluación enviada correctamente, sin embargo no respondiste todas las preguntas.
 * */
function setValToastAction(num_status) {
    if (document.getElementById('toastAction') != null) $("#toastAction").val(num_status.toString());
}

/**
 * @description Se valida que los elementos pasados como parametro via ID sean validos en el form
 * @param {Array} elements : Vector con los id de los elementos de un formulario
 * @returns {boolean} : True = los elementos tienen valores correctos, False = algún elemento no es valido.
 */
function validElementsForm(elements) {
    var valid = true;
    if (Array.isArray(elements)){
        for (var i = 0; i < elements.length; i++){
            if (existElement(elements[i])){
                if (!document.getElementById(elements[i]).validity.valid) {
                    valid = false;
                    break;
                }
            } else {
                valid = false;
                break;
            }
        }
    }
    return valid;
}

/**
 *
 * @param element {HTMLElement} : Elemento input de tipo file
 * @returns {boolean} : True El input ha cargado un archivo - False : el input no tiene archivos
 */
function inputFileValid(element) {
    var valid = false;
    if (element != null)
        if (element.files.length > 0) valid = true;
    return valid;
}

/**
 * @description : Esta función retorna el formData con los archivos de un input determinado por el id o de los inputs
 * definidos en el vector que es pasado como parametro.
 * @param {String} idElements {Array}: Id del input file o vector con los id de los input file.
 * @returns {FormData} : FormData nulo o con los archivos que el input contiene, si el parametro insertado fue un array
 * se retornara un vector con los files de cada input ingresado.
 */
function getFormDataInput(idElements) {
    var formData = new FormData();
    if (Array.isArray(idElements)) {
        for(var i = 0; i < idElements.length; i++){
            if (existElement(idElements[i])){
                var files = document.getElementById(idElements[i]).files;
                for (var j = 0; j < files.length; j++) formData.append("file_" + idElements[i] + "_" + j, files[j]);
            }
        }
    } else {
        if (existElement(idElements)){
            var files = document.getElementById(idElements).files;
            for (var i = 0; i < files.length; i++) formData.append("file_" + i, files[i]);
        }
    }
    return formData;
}

/**
 * @description Esta función refresca cada elemento img para volver a cargar su imagen sin cache
 */
function refreshImg() {
    jQuery('img').each(function(){
        jQuery(this).attr('src',jQuery(this).attr('src')+ '?' + (new Date()).getTime());
    });
}

/**
 * @version Esta función permite cargar un imagen por medio de la url e insertarlo en la memoria del DOM como elemento.
 * @param {String} url : ruta relativa del imagen que se desea cargar.
 * @returns {HTMLImageElement} : Elemento img con src de la url pasada como parametro.
 */
function loadImage(url)
{
    var image = new Image();
    image.src = url;
    return image;
}

/**
 * @description Esta función ejecuta o hace llamado al tooltip de bootstrap 4.3
 */
function exeTooltip() {
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
}

/**
 * @description Esta función carga la imagen el elemento img pasado como paramatro por su id
 * @param {String} idImgElement : Id del elemento img
 * @param {HTMLElement} inputFile : Input de type file
 * @param {String} sourceNotImage : Ruta relativa del archivo not_image.jpg
 */
function viewPhoto(idImgElement, inputFile, sourceNotImage) {
    if (inputFile != null)
        if (inputFileValid(inputFile)) $(idImgElement).attr('src', URL.createObjectURL(inputFile.files[0]));
    else $(idImgElement).attr('src', sourceNotImage);
}

/**
 * @description Método que permite ver la contraseña de un input type password
 * @param inputId {string} Valor del id del input con type password
 * @param spanBtnId {string} Valor del id del span con el icono que se desea cambiar al mostrar u ocultar la contraseña, este debe ser usado con material-icons
 */
function viewPassword(inputId, spanBtnId) {
    if (document.getElementById(inputId) != null && document.getElementById(spanBtnId) != null) {
        materialicon = $('#' + spanBtnId).text();
        console.log(materialicon);
        if (materialicon === 'visibility_off') {
            $('#' + inputId).attr('type', 'text');
            $('#' + spanBtnId).text('visibility');
        } else {
            $('#' + inputId).attr('type', 'password');
            $('#' + spanBtnId).text('visibility_off');
        }
    }
}