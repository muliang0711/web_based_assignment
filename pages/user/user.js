const IMAGE_DIRECTORY = '/assets/img/';

$(() => {
    $('.visibility-toggle-icon').on('click', function() {
        var imgSrc = $(this).attr('src');
        if (imgSrc === IMAGE_DIRECTORY+'visibility-off.svg') {
            $(this).prop('src', IMAGE_DIRECTORY+'visibility-on.svg');
        } else if (imgSrc === IMAGE_DIRECTORY+'visibility-on.svg') {
            $(this).prop('src', IMAGE_DIRECTORY+'visibility-off.svg');
        }

        var input = document.getElementById("password");
        input.type = (input.type === "password") ? "text" : "password";
    })
});