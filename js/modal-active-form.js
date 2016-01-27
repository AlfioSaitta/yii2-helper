$("form.modal-form").on('beforeSubmit.yii', function(e) {
    var modalId = '#' + $(this).attr("data-modal-id");
    var selectId = '#' + $(this).attr("data-select-id");

    $.post($(this).attr("action"), $(this).serialize())
        .done(function(result) {
            if (result.success) {
                $(modalId).modal('hide');
                $(selectId).append($(
                    '<option>',
                    {value: result.id, text: result.text})
                ).val(result.id).trigger('change');

                pjaxReloadMessage();
            } else {
                var errors = JSON.parse(result.error);

                var message = '';
                for(var i in errors) {
                    message += errors[i][0];
                }

                alert(message);
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
