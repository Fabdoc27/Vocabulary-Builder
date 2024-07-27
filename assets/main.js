// jQuery
;(function ($) {
    $(document).ready(function () {
        $('#login').on('click', function () {
            $('#formchange h3').html('Login')
            $('#action').val('login')
        })

        $('#register').on('click', function () {
            $('#formchange h3').html('Register')
            $('#action').val('register')
        })

        $('.menu_item').on('click', function () {
            $('.hitems').hide()
            var target = '#' + $(this).data('target')
            $(target).show()
        })

        $('#alphabets').on('change', function () {
            var char = $(this).val().toLowerCase()

            if ('all' == char) {
                $('.words tr').show()
                return true
            }
            $('.words tr:gt(0)').hide()

            $('.words tr')
                .filter(function () {
                    return $(this)
                        .find('th')
                        .text()
                        .toLowerCase()
                        .startsWith(char)
                })
                .show()
        })
    })
})(jQuery)
