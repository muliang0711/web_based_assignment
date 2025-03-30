$(()=>{

    function movborder(target, instant=false){
        let target_position = $(target).offset();

        //when the payment method is clicked shift the border to the location
        if(instant){
            $(".border").css("transition","none");
        }
        else{
            $(".border").css("transition","0.3s ease");
        }

        $(".border").css({
            left: target_position.left-35-15
        });
    }
    
    $(".paymentcontainer").on('click', function(e){
        //remove all selected then adding again
        $(this).children().removeClass("selected");
        $(e.target).toggleClass("selected");
        movborder(e.target);
    })

    $(window).on('resize', function(){
        let tg = $(".paymentcontainer .selected")[0];
        movborder(tg, true);
    })

})