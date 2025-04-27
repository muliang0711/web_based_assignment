$(() => {
    const chatContainer =  $(".chatContainer");
    const chatBody = $(".chatBody");
    const emailButton = $(".email-button");
    const unsubEmailButton = $(".unsubscribe-email-button");



    function alertSuccess(msg){
        $(".success span.info-text").text(msg);
        setTimeout(function(){
            $(".success span.info-text").text("");
        },3000);
        
    }

    $("[data-cancel]").on('click', function(e){
        //load cancel page
        let orderId = this.dataset.cancel;
        location = "orderCancel.php?id=" + orderId;
    });


    $("[data-support]").on('click', function(e){
        if(chatContainer.hasClass("show")){
            chatContainer.animate({
                opacity: 0,
                marginBottom: "100px"
            }, 500, function(){
                chatContainer.removeClass("show");
                chatContainer.css("margin-bottom" ,"0");
                chatContainer.css("opacity" ,"1");
                document.body.style.overflow = ''; //renable scrolling of background
            });
            
            
        }
        else{
            chatContainer.addClass("show");
            chatBody.scrollTop(chatBody[0].scrollHeight);
            document.body.style.overflow = 'hidden'; //disable background scrolling
        }
    });

    emailButton.on("click", function(e){
        let oid = this.dataset.id;
        
        //send ajax to update order id notify to true
        $.ajax({
            url: "/api/emailHandler.php",
            type: "POST",
            data: {
                id: oid,
                task: "setNotify"
            },
            success: function(res){
                if(res=="success"){
                        location=location;      
                }
            }
        });
    })



    unsubEmailButton.on("click", function(e){
        let oid = this.dataset.id;
        
        //send ajax to update order id notify to true
        $.ajax({
            url: "/api/emailHandler.php",
            type: "POST",
            data: {
                id: oid,
                task: "removeNotify"
            },
            success: function(res){
                if(res=="success"){
                    location=location;
                    
                }
            }
        });
    })

});