$(function(){

    $("#login_form").submit(function(){

        $.ajax({
            type:"post",
            url: BASE_URL + "AreaRestrita/ajax_login",
            dataType:"json",
            data: $(this).serialize(),
            beforeSend: function(){
                clearErrors();
                $("#btn_login").parent().siblings(".help-block").html(loadingImg("Verificando..."));
            },
            success: function(json){
                if (json["status"] == 1){
                    $("#btn_login").parent().siblings(".help-block").html(loadingImg("Logando..."));
                    window.location = BASE_URL + "AreaRestrita";
                }else{
                   showErrors(json["error_list"]) ;
                }
            },
            error: function(response){
                console.log(response);
            }
        })

        return false;

    })

})