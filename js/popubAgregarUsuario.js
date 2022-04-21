$(function(){
    $("#open").on("click" , function(){
    $("#popup").show();
    });

    $("#close").on("click" , function(){
        $("#popup").hide();
    });
});
$(function(){
    $("#close_ac").on("click" , function(){
        $("#popup_ac").hide();
    });
})