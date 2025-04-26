$(() => {

    $("[data-cancel]").on('click', function(e){
        //load cancel page
        let orderId = this.dataset.cancel;
        location = "orderCancel.php?id=" + orderId;
    });


    $("[data-support]").on('click', function(e){
        //load support page
        alert("support");
    });

});