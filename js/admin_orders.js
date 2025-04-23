$(()=>{



    var formdiv = $(".formwrapper");
    var form = formdiv.children(".updateform");
    var formOrderId = form.children("span");
    var formStatus = form.children("select");
    var formTracking  = form.children("input[type='text']");
    var formDelivered = form.children("input[type='date']");
    var orderid;

    $("tbody").on('click', "[data-update]", function(e){
         orderid = $(this)[0].dataset.update;
        let status = $(`td.stat.${orderid}`);
        let tracking = $(`td.tracking.${orderid}`);
        let date = $(`td.delivered.${orderid}`);

        //before showing the form, we fill in the columsn with the current data;
        formOrderId.text("Order #"+orderid);
        formStatus.val(status.text());

        formTracking.val(tracking.text() == "Null" ? null : tracking.text());

        if(date.text()!="Null"){
            formDelivered.val(date.text());
        }else{
            formDelivered.val("");
        }
        
        if(formStatus.val() == "Pending"){
            formTracking.prop("readonly", true);
            formDelivered.prop("readonly", true);
        }else {
            formTracking.prop("readonly", false);
            formDelivered.prop("readonly", false);

        }

        formdiv.css("display","flex");

    })

    formStatus.on('change', function(e){
        if(formStatus.val() == "Pending"){
            formTracking.prop("readonly", true).val("");
            formDelivered.prop("readonly", true).val("");

            
        }else {
            formTracking.prop("readonly", false);
            formDelivered.prop("readonly", false);

        }
    })

    $(".exitButton").on('click', function(e){
        formdiv.css("display","none");
    });

    $("#editSave").on('click', function(e){


        // if status is in transit
        //tracking cant be empty
        // delivered date must be empty or just dont submit the value
        if(formStatus.val()=="In Transit" && (formTracking.val().length < 1 || isNaN(formTracking.val()))){
            alert("Please Enter A Tracking Number");
        }

        else if(formStatus.val()=="In Transit" && formDelivered.val() != ""){
            alert("Please Clear The Date");
        }

        // if status is delivered
        //tracking cant be empty
        // delivered date cannot be empty
        else if(formStatus.val()=="Delivered"
    && ((formTracking.val().length < 1 || isNaN(formTracking.val())) || (formDelivered.val() == ""))){
            alert("Please Enter Tracking Number and Date Delivered");
        }


        else {
            //if no error we submit the data using ajax;
            let stat = formStatus.val();
            let date = (stat == "Pending" || formDelivered.val()==""? null:formDelivered.val());
            let track = (stat == "Pending" || formTracking.val()==""? null:formTracking.val());


            let datas = {
                id : orderid,
                status : stat,
                tracking : track,
                deliveredDate : date
            };

            $.ajax({
                url: "/pages/admin/admin_order_update.php",
                type: "POST",
                data: datas,
                success: function(res){
                    if(res=="success"){
                        //close the form and show success and edit the value;
                        // console.log(res);
                        formdiv.css("display","none");
                        let status = $(`td.stat.${orderid}`);
                        let tracking = $(`td.tracking.${orderid}`);
                        let dates = $(`td.delivered.${orderid}`);
                       
                        status.text(stat);
                        tracking.text(track==null?"Null":track);
                        dates.text(date==null?"Null":date);

                        $("#info-text").text("Order edited!");
                        setTimeout(function(){
                            $("#info-text").text("");
                        },3000);
                    }
                }
            });
        }

        
    })

    $("#order-search").on('input', function(e){
        let value = $(this).val();
        let tbody = $("tbody");
        let datas = {
            search : value
        };

        //use ajax to get the records and replace the tablebody datas
        $.ajax({
            url : "/api/adminGetOrder.php",
            type : "POST",
            data : datas,
            success : function(res){
                tbody.html(res);
            }
        });

    })
});