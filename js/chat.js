$(()=>{
    const chatContainer =  $(".chatContainer");
    const chatBody = $(".chatBody");
    const supportButton = $(".supportButton");
    const emojiButton = $("#emojiBtn");
    const emojiDiv = $("#emojiPicker");
    const send = $(".send");
    const textArea = $("#textarealol");
    $(".supportButton").on("click",function(e){
        if(chatContainer.hasClass("show")){
            chatContainer.animate({
                opacity: 0,
                marginBottom: "100px"
            }, 500, function(){
                chatContainer.removeClass("show");
                chatContainer.css("margin-bottom" ,"0");
                chatContainer.css("opacity" ,"1");
            });
            
            
        }
        else{
            chatContainer.addClass("show");
        }
        
    })

    send.on('click',function(e){
        let msg = textArea.val();
        if(msg.length>0){
            $.ajax({
                url: "/api/chatHandler.php",
                type: "POST",
                data: {
                    message: msg
                },
                success: function(res){
                    if(res!="error"){
                        chatBody.append(res)
                        textArea.val("");
                    }
                }
            });
        }
    })

    emojiButton.on('click',function(e){
        emojiDiv.toggleClass("show");
    })

    emojiDiv.on('click', "span" ,function(e){
        let text = textArea.val();
        text+= $(this).text();
        textArea.val(text);
        emojiDiv.toggleClass("show");
    })
})