(function ($) {

    $('#toggle-memberkit').on('change', function () {
        if ($(this).is(':checked')) {
            $('#enable-memberkit').val('1');
        } else {
            $('#enable-memberkit').val('0');
        }
        $('#classrooms-wrapper').toggle();
    });

})(jQuery);