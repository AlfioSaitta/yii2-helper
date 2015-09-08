$(function(){
    //get the click of modal button to create / update item
    //we get the button by class not by ID because you can only have one id on a page and you can
    //have multiple classes therefore you can have multiple open modal buttons on a page all with or without
    //the same link.
//we use on so the dom element can be called again if they are nested, otherwise when we load the content once it kills the dom element and wont let you load anther modal on click without a page refresh
      $(document).on('click', '.selectCheckboxButton', function(){
        //check if the modal is open. if it's open just reload content not whole modal
        //also this allows you to nest buttons inside of modals to reload the content it is in
        //the if else are intentionally separated instead of put into a function to get the
        //button since it is using a class not an #id so there are many of them and we need
        //to ensure we get the right button and content.

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
