$(function () {

        $('.hint-block').each(function () {
            var hint = $(this);
            var label = hint.parent().find('label');

            label.html('<label class="help">' + label.text() + '</span>');
            label.popover({
                html: true,
                trigger: 'hover',
                placement: 'right',
                content: hint.html()
            });
        });
});
