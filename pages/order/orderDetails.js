$(() => {

    $("[data-cancel]").on('click', function(e){
        //load cancel page
        alert("cancel");
    });


    $("[data-support]").on('click', function(e){
        //load support page
        alert("support");
    });

});