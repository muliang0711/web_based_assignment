$(() => {


    $(".dropdown").on('click', function() {

        $(".rotate").not($(this)).removeClass("rotate");
        
        $(".show").not($(this).closest(".order").next("div"))
        .not($(this).closest(".order").next("div").children(".order-details-wrapper"))
        .removeClass("show");

        $(".noanimation").not($(this).closest(".order")).removeClass("noanimation");

        $(this).toggleClass('rotate');
        $(this).closest(".order").next("div").toggleClass("show");
        $(this).closest(".order").next("div").children(".order-details-wrapper").toggleClass("show");
        $(this).closest(".order").toggleClass("noanimation");

    })


})