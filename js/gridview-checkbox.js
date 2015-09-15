$(function(){
      $(document).on('click', '.selectCheckboxButton', function(){

        var keys = $('#' + $(this).attr('data-id')).yiiGridView('getSelectedRows').toString();
        //console.log(keys);

        $.ajax({
             url: $(this).attr('data-url'),
             type: 'GET',
             cache    : false,
             data     : {keylist: keys, param: $(this).attr('data-param')},
             dataType: 'json',
             success: function (response) {
                 console.log(response.message);

                 if ('closeModal' == response.nextAction) {
                     $('#modal').modal('hide');

                     if ($('#message-pjax').length) {
                       $.pjax.reload({container: "#message-pjax", async:false});
                     }

                     if ($('#container-pjax').length) {
                       $.pjax.reload({container: "#container-pjax", async:false});
                     }
                 }
             }
        });

    });
});

$(document).on('click', "[data-gridview-checkbox='redirect']", function () {
    var keys = $('#' + $(this).attr('data-gridview-id')).yiiGridView('getSelectedRows').toString();
    var params = {keylist: keys, param: $(this).attr('data-param')};
    if ('' != keys) {
        window.location = $(this).attr('data-url') + '?' + $.param(params);
        return false;
    }

    return false;
});

$(document).on('click', "[data-gridview-checkbox='ajax']", function () {
    var keys = $('#' + $(this).attr('data-gridview-id')).yiiGridView('getSelectedRows').toString();
    $.ajax({
         url: $(this).attr('data-url'),
         type: 'GET',
         cache    : false,
         data     : {keylist: keys, param: $(this).attr('data-param')},
         dataType: 'json',
         success: function (response) {

             if ('closeModal' == response.nextAction) {
                 $('#modal').modal('hide');

                 if ($('#message-pjax').length) {
                   $.pjax.reload({container: "#message-pjax", async:false});
                 }

                 if ($('#container-pjax').length) {
                   $.pjax.reload({container: "#container-pjax", async:false});
                 }

                 return false;
             }

             if ($('#message-pjax').length) {
               $.pjax.reload({container: "#message-pjax", async:false});
             }

             if ($('#container-pjax').length) {
               $.pjax.reload({container: "#container-pjax", async:false});
             }

             return false;
         }
    });
});
