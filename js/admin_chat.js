$(()=>{
    const emojiButton = $("#emojiBtn");
    const emojiDiv = $("#emojiPicker");
    const send = $(".send");
    const textArea = $("#textarealol");
    const chat = $(".chat");
    const chatBody = $(".chatBody");
    var userID;
    var lastMsgID=0;
    var intervalID;


    function getMaxMsgID(){
        lastMsgID = 0;
        $.ajax({
            url: "/api/chatHandler.php",
            type: "POST",
            data: {
                task: "getMaxAdmin",
                userid: userID
            },
            success: function(res){
                if(res!="error"){
                    lastMsgID = res;
                }
            }
        });
    }
    

    $("[data-id]").on("click", function(e){
        userID = this.dataset.id;
        clearInterval(intervalID);
        //remove all other selected then add to this chat
        $(".chat").removeClass("selected");
        $(this).addClass("selected");

        //getting messages
        $.ajax({
            url:"/api/chatHandler.php",
            type:"POST",
            data: {
                id: userID,
                task: "loadMessage"
            },
            success: function(res){
                    if(res!="error"){
                        chatBody.html(res);
                        chatBody.scrollTop(chatBody[0].scrollHeight);
                        getMaxMsgID();
                        intervalID = setInterval(getNewMessage, 300);
                    }
            }
        });
    })


    send.on('click',function(e){
        if(userID == null){
            return;
        }
        let msg = textArea.val();
        if(msg.length>0){
            $.ajax({
                url: "/api/chatHandler.php",
                type: "POST",
                data: {
                    userid: userID,
                    message: msg,
                    task: "adminSend"
                    
                },
                success: function(res){
                    if(res!="error"){
                        res=JSON.parse(res);
                        console.log(res);
                        lastMsgID = res.msgID;
                        chatBody.append(res.response);
                        chatBody.scrollTop(chatBody[0].scrollHeight);
                        textArea.val("");
                    }
                }
            });
        }
    })


    function getNewMessage(){
        $.ajax({
            url: "/api/chatHandler.php",
            type: "POST",
            data: {
                userid: userID,
                lastID: lastMsgID,
                task: "adminGetMessage"
            },
            success: function(res){
                if(res!="error"){
                    res=JSON.parse(res);
                    lastMsgID = res.msgID;
                    chatBody.append(res.response);
                    console.log(res);
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

})