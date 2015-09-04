$(document).on('click', '.ajaxUpdate', function () {
    var ctl = $(this);
    var ctlParam = $(ctl.attr('data-param'));
    var ctlSuccess = $(ctl.attr('data-success'));

    $.ajax({
         url: ctl.attr('data-url'),
         type: 'GET',
         cache: false,
         data: {param: ctlParam.val()},
         dataType: 'json',
         success: function (response) {
             console.log(response.message);
             ctlSuccess.val(response.message);
         }
    });
});
