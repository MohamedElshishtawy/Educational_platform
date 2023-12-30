
$(window).on("load", function(){
    $(".loader .content").fadeOut(1000, function(){
        $(this).parent().fadeOut(500, function () { 
            $("body").css("overflow", "auto")
        })
    });

});