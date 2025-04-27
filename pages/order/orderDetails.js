$(() => {
    const chatContainer =  $(".chatContainer");
    const chatBody = $(".chatBody");
    
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

});