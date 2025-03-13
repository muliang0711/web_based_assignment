// ============================================================================
// General Functions
// ============================================================================



// ============================================================================
// Page Load (jQuery)
// ============================================================================

$(() => {

    // Autofocus
    $('form :input:not(button):first').focus();
    $('.err:first').prev().focus();
    $('.err:first').prev().find(':input:first').focus();
    
    // Confirmation message
    // TODO
    $('[data-confirm]').on('click', e => {
        const text = e.target.dataset.confirm || 'Are you sure?';
        if (!confirm(text)) {
            e.preventDefault();
            e.stopImmediatePropagation();
        }
    });
    // Initiate GET request
    $('[data-get]').on('click', e => {
        e.preventDefault();
        const url = e.target.dataset.get;
        location = url || location;
    });

    // Initiate POST request
    $('[data-post]').on('click', e => {
        e.preventDefault();
        const url = e.target.dataset.post;
        const f = $('<form>').appendTo(document.body)[0];
        f.method = 'POST';
        f.action = url || location;
        f.submit();
    });

    // Reset form
    $('[type=reset]').on('click', e => {
        e.preventDefault();
        location = location;
    });

    // Auto uppercase
    $('[data-upper]').on('input', e => {
        const a = e.target.selectionStart;
        const b = e.target.selectionEnd;
        e.target.value = e.target.value.toUpperCase();
        e.target.setSelectionRange(a, b);
    });

    // Show dropdown when a dropdown label is clicked
    $('.dropdown-label').on('click', function(e) {
        e.stopPropagation(); // Stop the click event from bubbling to the document click event handler.
        $(this).toggleClass("active");
        $(this).siblings(".dropdown-content").toggleClass("active");
    });

    // Hide dropdown menu when anywhere other than the menu is clicked
    $(document).on('click', e => {
        console.log("document click event triggered");

        if (!$(e.target).closest(".dropdown-content").length) {
            $(".dropdown-label").removeClass("active");
            $(".dropdown-content").removeClass("active");
        }
    });

    // Cart button's click event handler
    $('.cart-btn').on('click', e => {
        e.stopPropagation();
        console.log("cart clicked");

        $('.cart-popup').fadeIn(100);
        $('.cart-popup .content').addClass('slide-down');

        $('.close-popup').on('click', e => {
            $('.cart-popup').fadeOut(200);
            $('.cart-popup .content').removeClass('slide-down');
        });
    });
    
});