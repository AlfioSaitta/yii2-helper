$(document).on('click', '.show-modal-button', function() {
    var url = $(this).attr('value');
    var modalId = '#' + $(this).attr('data-modal-id');

    if ($(this).attr('data-gridview-id')) {
        var keys = $('#' + $(this).attr('data-gridview-id')).yiiGridView('getSelectedRows').toString();
        url = $(this).attr('value') + '&id=' + encodeURIComponent(keys);

        if (keys) {
            $.ajax({
                url: $(this).attr('value'),
                type: 'get',
                dataType: 'json',
                error: function(xhr, status, error) {
                    if(xhr.status==200) {
                        $(modalId).modal('show')
                                .find(modalId + '-content')
                                .load(url);
                        $(modalId).on('shown.bs.modal', function () {
                            $(modalId).find('textarea:visible:first').focus();
                            $(modalId).find('input:visible:first').focus();
                        })

                        return false;
                    }

                    if(xhr.status==403) {
                        swal('Invalid Permission', 'You do not have sufficient permission to carry out this action.', "error");
                        return false;
                    }

                    console.log(getErrorMessage(xhr.responseText.substring(11)));
                    return false;
                }
            });
        } else {
            swal('Invalid selection', 'Please check that you have selected at least an item an try again.', "error");
            return false;
        }
    }

    $.ajax({
        url: $(this).attr('value'),
        type: 'get',
        dataType: 'json',
        error: function(xhr, status, error) {
            if(xhr.status==200) {
                $(modalId).modal('show')
                        .find(modalId + '-content')
                        .load(url);
                $(modalId).on('shown.bs.modal', function () {
                    $(modalId).find('textarea:visible:first').focus();
                    $(modalId).find('input:visible:first').focus();
                })

                return false
            }

            if(xhr.status==403) {
                swal('Invalid Permission', 'You do not have sufficient permission to carry out this action.', "error");
                return false;
            }

            console.log(getErrorMessage(xhr.responseText.substring(11)));
            return false;
        }
    });
});
