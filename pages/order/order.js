$(() => {


    $(".dropdown").on('click', function() {
        $(this).toggleClass('rotate');
        $(this).closest(".order").next("div").toggleClass("show");
        $(this).closest(".order").toggleClass("noanimation");

    })


})