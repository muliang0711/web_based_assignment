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


    var totalTraveled = 0;
    var numberofTimes = 0;
    // if more than 2 cards then we show butons
    if($(".card").length>2){
        $(".right").css("visibility","visible");
    }

    $(".right").on('click', e => {
        e.preventDefault();
        
        
        let slider = $(".addressSlider");
        let card = $(".card").first();
        let totravel = card.width()+30;
        let timesCanClick = $(".card").length - 2;
        

        if(numberofTimes<timesCanClick){
            slider.animate({marginLeft:totalTraveled-=totravel},400, function(){
                $(".left").css("visibility","visible");
                if(numberofTimes==timesCanClick){
                    $(".right").css("visibility","hidden");
                }
            });
            numberofTimes++;
            
        }
        else {
            return;
        }
        

        
    })

    $(".left").on('click', e => {
        e.preventDefault();
        
        let slider = $(".addressSlider");
        let card = $(".card").first();
        let totravel = card.width()+30;
        let timesCanClick = $(".card").length - 2;
        

        if(numberofTimes>0){
            slider.animate({marginLeft:totalTraveled+=totravel},400, function(){
                $(".right").css("visibility","visible");
                if(numberofTimes==0){
                    $(".left").css("visibility","hidden");
                }
            });
            numberofTimes--;
            
        }
        else {
            return;
        }


    })

    $(".card").on('click', function(e){
        $(".card").removeClass("selected");
        $(this).addClass("selected");
    })


})