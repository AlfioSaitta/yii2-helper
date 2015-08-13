$('body').on('beforeSubmit', 'form.modalSubmit', function () {
     var form = $(this);
     // return false if form still have some validation errors
     if (form.find('.has-error').length) {
          return false;
     }
     // submit form
     $.ajax({
          url: form.attr('action'),
          type: 'post',
          data: form.serialize(),
          success: function (response) {
              $('#modal').modal('hide');

              // update container-pjax if it exist
              if ($('#container-pjax').length) {
                  $.pjax.reload('#container-pjax');
              }
          }
     });
     return false;
});
