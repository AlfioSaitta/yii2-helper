$(document).on('click', '.ajaxUpdate', function () {
    var ctl = $(this);
    var ctlParam = $(ctl.attr('data-param'));
    var ctlParam2 = $(ctl.attr('data-param2'));
    var ctlSuccess = $(ctl.attr('data-success'));

    $.ajax({
         url: ctl.attr('data-url'),
         type: 'GET',
         cache: false,
         data: {param: ctlParam.val(), param2: ctlParam2.val()},
         dataType: 'json',
         success: function (response) {
             console.log(response.message);
             ctlSuccess.val(response.message);
         }
    });
});
