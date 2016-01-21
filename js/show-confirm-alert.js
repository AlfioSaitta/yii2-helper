$(document).on('click', '.showConfirmAlert', function () {
    var url = $(this).attr('value');

    if ($(this).attr('confirm-text')) {
        var confirmText = $(this).attr('confirm-text');
    } else {
        var confirmText = "You will not be able to undo this!";
    }

    swal({
        title: "Are you sure?",
        text: confirmText,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes!",
        closeOnConfirm: true,
    }, function() {
        window.location.href = url;
    });
});
