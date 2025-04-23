$(() => {
    
    // Toggle password visibility
    $('.visibility-toggle-icon').on('click', function(e) {
        console.log("eye clicked");
        var imgSrc = $(this).prop('src'); // prop('src') returns something like "http://domain.com/assets/img/image.png"
        // console.log($(this).prop('src'));
        if (imgSrc === location.origin + '/assets/img/visibility-off.svg') {
            $(this).prop('src', '/assets/img/visibility-on.svg');
        } else if (imgSrc === location.origin + '/assets/img/visibility-on.svg') {
            $(this).prop('src', '/assets/img/visibility-off.svg');
        }
    
        console.log("e.target: " + e.target);
        var input = e.target.closest('.password-input-box').querySelectorAll('input')[0];
        console.log("input: " + input);
        input.type = (input.type === "password") ? "text" : "password";
    })


    // Password strength testing

    $passwordTesterBox = $('.password-strength-tester');

    $passwordTesterBox.css({ visibility: 'hidden', position: 'absolute', height: 'initial', display: 'block' });
    // console.log($passwordTesterBox.css('padding'));
    initialHeight = $passwordTesterBox.outerHeight();
    $passwordTesterBox.css({ visibility: '', position: '', height: '', display: '' }); // restore original styles
    console.log(initialHeight);

    // Password strength tester div
    $('input.strength-testable').one('input', e => {
        console.log("showing myself~");
        // $passwordTesterBox.css('padding-top', '10px');
        $passwordTesterBox.animate({ height: initialHeight+'px' }, 100);
    });

    $('input.strength-testable').on('input', e => {
        $inputPassword = $(e.target);
        $passwordTesterBox = $inputPassword.closest('.form-item').find('.password-strength-tester');

        const password = e.target.value;
        let passes = 0;
        const totalChecks = $passwordTesterBox.children('.checks').length;

        if (password.length >= 8) {
            $passwordTesterBox.children('#charCount').addClass('good');
            passes++;
        }
        if (/[A-Z]/.test(password) && /[a-z]/.test(password)) {
            $passwordTesterBox.children('#bothCase').addClass('good');
            passes++;
        }
        if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
            $passwordTesterBox.children('#specialSymbols').addClass('good');
            passes++;
        }

        if (passes < totalChecks) {
            $inputPassword.addClass('not-strong-enough');
        } else {
            $inputPassword.removeClass('not-strong-enough');
        }
    });
});