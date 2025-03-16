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


    $("#filter-button").on('click', function(e) {
        if (!$(e.target).closest("#filter-menu").length) {
            $("#filter-menu").toggleClass("show");
        }
            
    });


    $("#pricemin").on("input", function(e) {
        $("#labelpricemin").text("Price (min) RM " + this.value);
        $("#pricemax").attr({
            min:+this.value
        });
    });


    $("#pricemax").on("input", function(e) {
        $("#labelpricemax").text("Price (max) RM " + this.value);

    });
    
    $(".resetbutton").on('click', e => {
        location = "order.php?pricemin=0&pricemax=10000&stat=&sort=desc";
    });

})