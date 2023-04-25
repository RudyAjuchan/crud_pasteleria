
$(document).ready(function(){
    $(".sub-btn").click(function(){                
        $(this).next(".sub-menu").slideToggle();
        if($(this).hasClass("activeI")){
            $(this).removeClass("activeI");
        }else{
            $(this).addClass("activeI")
        }
    });

});