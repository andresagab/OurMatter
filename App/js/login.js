jQuery(document).on('submit', '#frmLogin', function (event) {
    event.preventDefault();
    jQuery.ajax({
        url: 'App/php/Scripts/login.php',
        type: 'POST',
        dataType: 'json',
        data: {
            method: 'validLogin',
            usuario: $(this).serializeArray()[0].value,
            password: $(this).serializeArray()[1].value
        },
        beforeSend: function () {
            
        }
    }).done(function (response) {
        if (response.valid === true) location.reload();
        else if (response.valid === false) {
            $('#toastAction').val('1');
            validMessageAlert();
        }
    }).fail(function (response) {
        console.log(response);
    }).always(function () {
        console.log("complete")
    });
});
