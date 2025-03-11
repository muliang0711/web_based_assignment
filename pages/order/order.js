$(() => {

    function wait(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    $(".dropdown").on('click', function() {


        //hide detailed order and show as well
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