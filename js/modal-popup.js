$(function(){
    //get the click of modal button to create / update item
    //we get the button by class not by ID because you can only have one id on a page and you can
    //have multiple classes therefore you can have multiple open modal buttons on a page all with or without
    //the same link.
//we use on so the dom element can be called again if they are nested, otherwise when we load the content once it kills the dom element and wont let you load anther modal on click without a page refresh
      $(document).on('click', '.showModalButton', function(){
        console.log('test');
        var modalId;

        if ($(this).attr('data-modal-id')) {
            modalId = '#' + $(this).attr('data-modal-id');
        } else {
            modalId = '#modal';
        }

        $(modalId).find('.modal-content')
            .html("<div style='text-align: center;'><img src='/images/ajax-loader.gif' /></div>");
        $(modalId).modal('show')
                .find('.modal-content')
                .load($(this).attr('value'));
        $(modalId).on('shown.bs.modal', function () {
            $('textarea:visible:first').focus();
            $('input:visible:first').focus();
        })
    });
});
