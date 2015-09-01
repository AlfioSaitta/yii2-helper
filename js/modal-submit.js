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
            alert('after');
            if ('success' == response.message) {
                $('#modal').modal('hide');

                if ($('#message-pjax').length) {
                  $.pjax.reload({container: "#message-pjax", async:false});
                }

                if ($('#container-pjax').length) {
                  $.pjax.reload({container: "#container-pjax", async:false});
                }

                return true;
            }

            if ('saveAndNew' == response.message) {
                $('#modal')
                        .find('#modalContent')
                        .load(response.saveAndNewUrl);
                return true;
            }
          }
     });
     return false;
});
