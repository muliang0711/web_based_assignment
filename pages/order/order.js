$(() => {

    function wait(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    $(".dropdown").on('click', function(e) {
        let button = $(e.target).closest(".dropdown")[0];
        let orderid = button.dataset.orderId;
        location = "orderDetails.php?id=" + orderid;

    })



    $("#pricemin").on("input", function(e) {
        $("#labelpricemin").text("Price (min) RM " + this.value);
        $("#pricemax").attr({
            min:+this.value
        });
    });


    $("#pricemax").on("input", function(e) {
        $("#labelpricemax").text("Price (max) RM " + this.value);

    });
    
    $(".resetbutton").on('click', e => {
        location = "order.php?pricemin=0&pricemax=10000&stat=&sort=desc";
    });

})