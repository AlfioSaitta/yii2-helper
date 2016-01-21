$(document).on('click', '.gridviewCheckboxModalButton', function() {
    var keys = $('#' + $(this).attr('gridview-id')).yiiGridView('getSelectedRows').toString();
    var url = $(this).attr('value') + '&id=' + encodeURIComponent(keys);

    if (keys) {
        $.ajax({
            url: $(this).attr('value'),
            type: 'get',
            dataType: 'json',
            error: function(xhr, status, error) {
                if(xhr.status==200) {
                    $('#modal').modal('show')
                            .find('#modal-content')
                            .load(url);
                    $('#modal').on('shown.bs.modal', function () {
                        $('textarea:visible:first').focus();
                        $('input:visible:first').focus();
                    })

                    return true;
                }

                if(xhr.status==403) {
                    swal('Invalid Permission', 'You do not have sufficient permission to carry out this action.', "error");
                    return false;
                }

                swal('Error', getErrorMessage(xhr.responseText.substring(11)), "error");
            }
        });
    }
});
