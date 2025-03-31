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
    
    $("#addaddr").on('click', function(e){
        location="/pages/user/address.php";
    });

    $(".paymentcontainer").on('click', function(e){
        //remove all selected then adding again
        if($(e.target).hasClass("border")){
            return
        }
        $(this).children().removeClass("selected");
        $(e.target).closest("div").toggleClass("selected");
        movborder(e.target.closest("div"));
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

    //convert to big case on input
    $(".voucher").children("input").on("input", function(e){
        $(this).val($(this).val().toUpperCase());
    });

    $("#appVcr").on('click', function(e){
        let code =  $(this).siblings("input").val();
        let button = $(".voucher").children("button");

        if($(this).hasClass("cancel")){
            return;
        }
        if(code.length <= 0){
            return;
        }else{
            var datas = {
                vcr : code
            }

            $.ajax({
                url : "/api/validateVoucher.php",
                type : "POST",
                data : datas,
                success : function(res) {
                    if(res){
                        //if voucher is valid
                        var input = $(".voucher").children("input");
                        input.prop("readonly", true).css({ pointerEvents: "none"});
                        button.text('');
                        button.append('<svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="rgb(39, 39, 39)"><path d="m336-280 144-144 144 144 56-56-144-144 144-144-56-56-144 144-144-144-56 56 144 144-144 144 56 56ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>');
                        button.addClass("cancel");
                        button.css({
                            border: "none"
                        });

                        $(".discount").children("span").eq(1).text("RM "+parseFloat(res.discount).toFixed(2));
                        $(".total").children("span").eq(1).text("RM "+parseFloat(res.total).toFixed(2));

                        $(".info-container.success").children("span").text("Voucher Applied!");
                        setTimeout(function() {
                            $(".info-container.success").children("span").text("");
                        }, 3000);

                    }else{
                        var input = $(".voucher").children("input");
                        $(".info-container.error").children("span").text("Invalid Voucher");
                        input.val("");
                        setTimeout(function() {
                            $(".info-container.error").children("span").text("");;
                        }, 3000);
                    }
                }
            });
        }
    })

    $(document).on('click', ".cancel" ,function(e){
        let button = $("#appVcr");
        var input = $(".voucher").children("input");
        input.val("").prop("readonly", false).css({pointerEvents: "auto"});

        $.ajax({
            url : "/api/validateVoucher.php",
            type : "POST",
            data : {
                vcr : "ffff1234rmvcr"
            },
            success : function(res){
                $(".discount").children("span").eq(1).text("RM "+parseFloat(res.discount).toFixed(2));
                $(".total").children("span").eq(1).text("RM "+parseFloat(res.total).toFixed(2));
            }
        });

        button.removeClass("cancel");
        button.children("svg").remove();
        button.text("Apply").css("border", "3px solid var(--lessImportant)");

        $(".info-container.warn").children("span").text("Voucher Removed!");
        setTimeout(function() {
            $(".info-container.warn").children("span").text("");
        }, 3000);
    });


})