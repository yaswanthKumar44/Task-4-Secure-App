$(document).ready(function() {
    $('#loginForm, #registerForm, #postForm').on('submit', function(e) {
        let isValid = true;
        $(this).find('input, textarea').each(function() {
            const $input = $(this);
            if ($input.attr('type') !== 'hidden' && $input.val().trim() === '') {
                $input.next('.error').addClass('show');
                isValid = false;
            } else {
                $input.next('.error').removeClass('show');
            }
        });
        if (!isValid) {
            e.preventDefault();
        }
    });

    $('input, textarea').on('input', function() {
        if ($(this).val().trim() !== '') {
            $(this).next('.error').removeClass('show');
        }
    });
});