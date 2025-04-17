
$(() => {

    console.log("hello");

    // Toggle password visibility
    $('.visibility-toggle-icon').on('click', function() {
        console.log("eye clicked");
        var imgSrc = $(this).attr('src');
        if (imgSrc === '../../assets/img/visibility-off.svg') {
            $(this).prop('src', '../../assets/img/visibility-on.svg');
        } else if (imgSrc === '../../assets/img/visibility-on.svg') {
            $(this).prop('src', '../../assets/img/visibility-off.svg');
        }

        var input = document.getElementById("password");
        input.type = (input.type === "password") ? "text" : "password";
    })

    // Change nav background opacity when hovered
    $('header').hover(
        function() {
            $(this).addClass('hovered');
        },
        function() {
            $(this).removeClass('hovered');
        }
    );

    // Autofocus
    $('.form :input:not(button):first').focus();
    $('.form-item:has(.error) :input:not(button):first').focus();
    

    $passwordTesterBox = $('.password-strength-tester');

    $passwordTesterBox.css({ visibility: 'hidden', position: 'absolute', height: 'initial', display: 'block' });
    initialHeight = $passwordTesterBox.outerHeight();
    $passwordTesterBox.css({ visibility: '', position: '', height: '', display: '' }); // restore original styles
    console.log(initialHeight);

    // Password strength tester div
    $('input#password').one('input', e => {
        $passwordTesterBox.animate({ height: initialHeight+'px' }, 100);
    });

    $('input#password').on('input', e => {
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

    // Make topbar have semi-transparent bg color when div.container scrolls up to the bottom of the topbar
    window.addEventListener('scroll', () => {
        const trigger = $('div.container')[0];
        const $topbar = $('header');
        const topbarHeight = $topbar.outerHeight();
        const rect = trigger.getBoundingClientRect();
        console.log(rect.top, topbarHeight);
      
        if (rect.top <= topbarHeight) {
          $topbar.addClass('scrolled');
        } else {
          $topbar.removeClass('scrolled');
        }
      });
      
    // close popup
    // $('.close-btn').on('click', e => {
    //     $('.popup').addClass('closed');
    // });
});