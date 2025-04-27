$(()=>{
    const chatContainer =  $(".chatContainer");
    const chatBody = $(".chatBody");
    const supportButton = $(".supportButton");
    const emojiButton = $("#emojiBtn");
    const emojiDiv = $("#emojiPicker");
    const send = $(".send");
    const textArea = $("#textarealol");
    var lastMsgID;


    function getMaxMsgID(){
        lastMsgID = 0;
        $.ajax({
            url: "/api/chatHandler.php",
            type: "POST",
            data: {
                task: "getMaxUser"
            },
            success: function(res){
                if(res!="error"){
                    lastMsgID = res;
                }
            }
        });
    }
    getMaxMsgID();

    function sendMSG(){
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
                        res=JSON.parse(res);
                        lastMsgID = res.msgID;
                        chatBody.append(res.response);
                        chatBody.scrollTop(chatBody[0].scrollHeight);
                        textArea.val("");
                    }
                }
            });
        }
    }

    textArea.on('keydown', function(e) {
        if (e.key === "Enter" && !e.shiftKey) { // Enter without Shift
            e.preventDefault(); // prevent adding a new line
            sendMSG();          
        }
    });
    
    $(".supportButton").on("click",function(e){
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
        
    })

    send.on('click', sendMSG);

    function getNewMessage(){
        $.ajax({
            url: "/api/chatHandler.php",
            type: "POST",
            data: {
                lastID: lastMsgID,
                task: "userGetMessage"
            },
            success: function(res){
                if(res!="error"){
                    res=JSON.parse(res);
                    lastMsgID = res.msgID;
                    chatBody.append(res.response);
                    chatBody.scrollTop(chatBody[0].scrollHeight);
                }
            }
        });
    }

    emojiButton.on('click',function(e){
        emojiDiv.toggleClass("show");
    })

    emojiDiv.on('click', "span" ,function(e){
        let text = textArea.val();
        text+= $(this).text();
        textArea.val(text);
        emojiDiv.toggleClass("show");
    })

    setInterval(getNewMessage, 300);
})