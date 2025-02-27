
$(() => {

    // Toggle password visibility
    $('.visibility-toggle-icon').on('click', function() {
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
    

    // close popup
    // $('.close-btn').on('click', e => {
    //     $('.popup').addClass('closed');
    // });
});