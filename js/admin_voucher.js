$(()=>{

    const addbtn = $(".addVoucher");
    const cancelSave = $(".CancelSave");
    const cancel = $(".cancel");
    const save = $(".save");
    const infoBox = $("#info-text");
    const showMSG = function(e){
        infoBox.text(e);
        setTimeout(function(){infoBox.text("");},3000);
    };

    $("[data-code]").on('click',function(e){
        let code = this.dataset.code;
        let row = $(this).closest('tr');
        if(confirm("Are you sure to delete?")){
            //delete from database;
            $.ajax({
                url: "/api/adminAddVoucher.php",
                type: "POST",
                data: {
                    task: 5,
                    code: code
                },
                success: function(res){
                    if(res=="success"){
                        showMSG("Voucher Deleted!");
                        row.remove();
                    }
                    else{
                        showMSG("Voucher Cant Be Deleted!");
                    }
                }
            });
        }
    })

    $("[data-id]").on('change',function(e){
        let input = $(this);
        let value = $(this).val();
        let vcrCode = $(this).closest('tr').find('td').first().text();
        let limit;
        $.ajax({
            url: "/api/adminAddVoucher.php",
            type: "POST",
            data: {
                task: 3,
                code: vcrCode
            },
            success: function(res){
                limit = res;
                if(parseInt(value,10) <= parseInt(limit,10)){
                    input.val(limit);
                }

                    $.ajax({
                        url: "/api/adminAddVoucher.php",
                        type: "POST",
                        data: {
                            task: 4,
                            code: vcrCode,
                            val: input.val()
                        },
                        success: function(res){
                            if(res=="success"){
                                showMSG("Voucher Updated!");
                            }
                        }
                    });
                
            }
        });

    })


    addbtn.on('click', function(e){
        //on click we append a row below the curren table to let user fill in the details
        $.ajax({
            url: "/api/adminAddVoucher.php",
            type: "POST",
            data: {
                task: 1
            },
            success: function(res){
                if(res!="error"){
                    $("tbody").append(res);
                    addbtn.css("display","none");
                    cancelSave.css("display","block");
                }
                else{
                    console.log(res);
                }
            }
        });

    })

    cancel.on('click', function(e){
        $("tbody").children("tr").last().remove();
        addbtn.css("display","block");
        cancelSave.css("display","none");   
    })

    save.on('click', function(e){
        //getting the fields for validation
        const voucherCode = $("#code").val(),
        amount = $("#amount").val(),
        adminID = $("#adminID").text(),
        limit = $("#redeemLimit").val();
        //validate first
        if(voucherCode.length < 1 || amount.length < 1 || limit.length < 1){
            showMSG("Fields cannot be Empty!");
        }
        else if(voucherCode.includes(" ")){
            showMSG("Voucher Code cannot have Spaces!");
        }
        else if(/[^\w]/.test(voucherCode)){
            showMSG("Voucher Code cannot have Symbols!");
        }
        else if(isNaN(amount)){
            showMSG("Amount cannot contain alphabets!");
        }
        else if(parseInt(amount, 10)<1 || parseInt(amount, 10)>100){
            showMSG("Invalid Amount!");
        }
        else if(isNaN(limit)){
            showMSG("Limit cannot contain alphabets!");
        }
        else if(parseInt(limit, 10)<1){
            showMSG("Invalid Limit!");
        }
        else{
            //send ajax request to backend and add voucher
            $.ajax({
                url: "/api/adminAddVoucher.php",
                type: "POST",
                data: {
                    task: 2,
                    voucherID: voucherCode.toUpperCase(),
                    amount: parseInt(amount, 10),
                    redeemLim: parseInt(limit, 10)
                },
                success: function(res){
                    if(res=="success"){
                        location=location;
                    }
                    else if(res=="error") {
                        showMSG("Voucher Code Already Exist!");
                    }
                    else{
                        console.log(res);
                    }
                }
            });
        }
        

    })
})