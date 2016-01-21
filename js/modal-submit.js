/*
 * This javascript have to be added to the _form view via include
 * instead of assets bundle as a workaround to pjax issue
 */
$("form.modalSubmit").on('beforeSubmit.yii', function(e) {
    var modalId;
    var pjaxId = '#' + $(this).attr("pjax-id");

    $.post($(this).attr("action"), $(this).serialize())
        .done(function(result) {
            if (result.success) {
                $('#modal').modal('hide');
                $.pjax.reload({container: pjaxId, async:false});
                pjaxReloadMessage();

            } else {
                var $errors = JSON.parse(result.error);

                var $message = '';
                for(var i in $errors) {
                    $message += $errors[i][0];
                }

                alert($message);
            };
        })
        .fail(function(result) {
            console.log(result.responseText);
            swal('Error', 'Validation Error or possible duplicate entry ', 'error');
        }
    );
    return false;
});

function pjaxReloadMessage() {
    var id = "#pjax-message";
    if ($(id).length !== 0){
        $.pjax.reload({container: id, async:false});
    };
}
