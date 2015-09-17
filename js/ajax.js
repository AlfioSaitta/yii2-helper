$(document).on('click', "[data-ajax='get']", function () {
    var ctl = $(this);

    $.ajax({
         url: ctl.attr('data-url'),
         type: 'GET',
         cache: false,
         dataType: 'json',
         success: function (response) {
             if ($('#message-pjax').length) {
               $.pjax.reload({container: "#message-pjax", async:false});
             }

             if ($('#container-pjax').length) {
               $.pjax.reload({container: "#container-pjax", async:false});
             }
         }
    });

    return false;
});
