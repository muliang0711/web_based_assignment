
$(() => {

    console.log("hello");    

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