// const IMAGE_DIRECTORY = '/assets/img/';

$(() => {
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

    // close popup
    $('.close-btn').on('click', e => {
        $('.popup').addClass('closed');
    });
});