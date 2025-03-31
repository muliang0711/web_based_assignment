$(() => {

    function wait(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }


    $("[data-order-id]").on("click", function(e){
        let oid = this.dataset.orderId;
        location = "orderDetails.php?id=" + oid;
    })
    
    $(".resetbutton").on('click', e => {
        location = "order.php?";
    });

    //if the check all button is clicked then we need check all other checkboxes
    $("#all").on('click', function(e){
        const checkboxes = $("input[type='checkbox']");
        if($(this).prop("checked")){
            checkboxes.not($(this)).prop("checked", true);
        }else{
            checkboxes.prop("checked", false);
        }

    })

    $("input[type='checkbox']").on('click', function(e){
        let all = $("#all");
        if($(this).prop("checked") == false){
            all.prop("checked",false);
        }
    })

})