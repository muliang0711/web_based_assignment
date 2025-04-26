// ============================================================================
// General Functions
// ============================================================================

// Open and close popup
function openPopup(activationTriggerElement) {
    const targetPopupId = activationTriggerElement.dataset.popupId;
    const $targetPopup = $('#' + targetPopupId);

    $targetPopup.addClass("show");

    // click event handler for closing popup
    $targetPopup.find('.close-popup').on('click', e => {
        $targetPopup.removeClass("show");
    });
}

// ============================================================================
// Page Load (jQuery)
// ============================================================================

$(() => {
    console.log("i am app.js");

    // Hamburger icon for header nav menu (only on mobile)
    $('.hamburger').on('click', () => {
        $('header > nav').toggleClass('show');
    });

    // Autofocus
    $('form:not(.no-autofocus-first) :input:not(button):not([type=hidden]):first').focus(); // can apply the class "no-autofocus-first" on a form to disable this for that form.
    $('.error:first').prev().focus();
    console.log($('.error:first'));
    $('.error:first').prev().find(':input:first').focus();
    
    // Confirmation message
    $('[data-confirm]').on('click', e => {
        // sometimes the element that triggers this event handler might not be the <button> but its child. 
        // this ensures that we get the [data-confirm] text from the <button>, even if we clicked on one of its children.
        const button = e.target.closest('button'); 
        const text = button.dataset.confirm || 'Are you sure?';

        if (!confirm(text)) {
            e.preventDefault();
            e.stopImmediatePropagation();
        }
    });

    // Initiate GET request
    $('[data-get]').on('click', e => {
        // sometimes the element that triggers this event handler might not be the <button> but its child. 
        // this ensures that we get the [data-confirm] text from the <button>, even if we clicked on one of its children.
        const button = e.target.closest('button'); 
        
        e.preventDefault();
        
        const url = button.dataset.get;
        location = url || location;
    });

    // Initiate POST request
    $('[data-post]').on('click', e => {
        e.preventDefault();
        const button = e.target.closest('button');
        const url = button?.dataset.post;
        if (!url) return;
    
        const f = $('<form>').appendTo(document.body)[0];
        f.method = 'POST';
        f.action = url;
        f.submit();
    });

    // Also initiate POST request -- except this is the real deal, no GET requests in disguise ;)
    // there's also an added functionality: you can define the id of the <form> created, so as to link to <input>s outside the <form> with the same form id
    $('[data-real-post]').on('click', e => {
        e.preventDefault();
        const button = e.target.closest('button');
        const url = button?.dataset.realPost;
        if (!url) return;
    
        const [action, queryString] = url.split('?', 2);
        const formId = button.dataset.formId;

        const $form = $("<form>", {
            method: "POST", 
            action: action ?? null,
            id: formId ?? null
        });

        if (queryString) {
            const params = new URLSearchParams(queryString);
            console.log(params);
            params.forEach((value, key) => {
                $("<input>", {
                    type: "hidden",
                    name: key,
                    value: value
                }).appendTo($form); 
            });
        }

        $form.appendTo("body");

        console.log($form);
        $form.submit();
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

    //============== DROPDOWNS ==============//

    const FADE_TIME = 200;
    const $dropdowns = $('.dropdown');

    $dropdowns.each(function() {
        const $dropdown = $(this);
        const $label = $dropdown.find('.dropdown-label');
        const $content = $dropdown.find('.dropdown-content');
        
        // Toggle functionality
        $label.on('click', function(e) {
            e.stopPropagation();

            // Store the OPPOSITE of the label's current state (of being active or not)
            const wasNotActive = !$label.hasClass('active');
            
            // Close other dropdowns first
            closeAllDropdownsExcept($dropdown);
            
            // Toggle current dropdown
            $label.toggleClass('active', wasNotActive); // If current state is not active, add the class; if current state is active, remove the class.
            // $content.toggleClass('active', wasNotActive); 
            // $content[wasNotActive ? 'fadeIn' : 'fadeOut'](FADE_TIME);
            
            if (wasNotActive) {
                $content.addClass('showing');
                // Force browser to process this change before applying the next class
                void $content[0].offsetHeight; // This triggers a reflow
                $content.addClass('fully-shown');
            }
            else {
                $content.removeClass('fully-shown').addClass('showing');
                setTimeout(() => $content.removeClass('showing'), FADE_TIME);
            }
        });
    });

    // Helper function to close all dropdowns except the one specified
    function closeAllDropdownsExcept($exceptDropdown) {
        $dropdowns.not($exceptDropdown).each(function() {
            const $dropdown = $(this);
            const $content = $dropdown.find('.dropdown-content');

            // Toggle dropdown label arrow's direction
            $dropdown.find('.dropdown-label').removeClass('active');

            // Toggle dropdown content's appearance
            $dropdown.find('.dropdown-content').removeClass('fully-shown').addClass('showing');
            setTimeout(() => $content.removeClass('showing'), FADE_TIME);
        });
    }


    // Document click handler
    $(document).on('click', function() {
        closeAllDropdownsExcept(null);
    });

    // Show dropdown when a dropdown label is clicked
    // $('.dropdown-label').on('click', function(e) {
    //     e.stopPropagation(); // Stop the click event from bubbling to the document click event handler.
    //     $(this).toggleClass("active");

    //     if ($(this).hasClass("active")) {
    //         $(this).siblings(".dropdown-content").fadeIn(FADE_TIME);
    //     }
    //     else {
    //         $(this).siblings(".dropdown-content").fadeOut(FADE_TIME);
    //     }
    //     // $(this).siblings(".dropdown-content").toggleClass("active");
    // });

    // Hide dropdown menu when anywhere other than the menu is clicked
    // $(document).on('click', e => {
    //     console.log("document click event triggered");

    //     console.log($(e.target).closest(".dropdown-content").length);
    //     if (!$(e.target).closest(".dropdown-content").length) {
    //         $(".dropdown-label").removeClass("active");
    //         $(".dropdown-content").fadeOut(FADE_TIME);
    //     }
    // });

    // Cart button's click event handler
    $('.cart-btn').on('click', e => {
        e.stopPropagation();
        console.log("cart clicked");

        $('.cart-popup').fadeIn(FADE_TIME);
        $('.cart-popup .content').addClass('slide-down');

        $('.close-popup').on('click', e => {
            $('.cart-popup').fadeOut(FADE_TIME);
            $('.cart-popup .content').removeClass('slide-down');
        });
    });

    
    function playSound() {
        const audio = document.getElementById("clickSound");
        audio.currentTime = 0; // 每次点击从头播放
        audio.play();
  }

});