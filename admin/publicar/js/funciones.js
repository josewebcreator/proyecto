$(document).ready(
    $("#formulario").submit(function (e) { 
        e.preventDefault() 
        $.ajax({
            type: 'POST',
            url: 'submit.php',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(msg){
                $('.statusMsg').html('');
                if(msg == 'ok'){
                    $('#formulario')[0].reset();
                    $('.statusMsg').html('<span style="font-size:18px;color:#34A853">Form data submitted successfully.</span>');
                }else{
                    $('.statusMsg').html('<span style="font-size:18px;color:#EA4335">Some problem occurred, please try again.</span>');
                }
            }

        });
    })
)