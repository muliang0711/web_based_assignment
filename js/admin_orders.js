$(()=>{

    $(".checkbox").on('click', e=>{
        let box = $(e.target);
        if(box.hasClass("fa-square")){
            box.css("color","#007bff");
            box.removeClass("far fa-square").addClass("fas fa-square-check");
        }
        else{
            box.css("color","");
            box.removeClass("fas fa-square-check").addClass("far fa-square");
            
        }
    });

});