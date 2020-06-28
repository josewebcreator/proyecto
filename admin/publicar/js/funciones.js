$(document).ready(function(){

    $("#formulario").submit(function (e) { 
        e.preventDefault() 
        $.ajax({
            type: 'POST',
            url: 'publicar.php',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(msg){
                $('.statusMsg').html('');
                if(msg == 'ok'){
                    $('#formulario')[0].reset();
                    //colocar mensaje de exito
                }else{
                    //colocar aqui mensaje de error
                }
            }

        });

    })

    $("#imagen").change(function () {
        var file = this.files[0];
        var imagefile = file.type;
        var match = ["image/jpeg", "image/png", "image/jpg"];
        if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
            alert('Please select a valid image file (JPEG/JPG/PNG).');
            $("#file").val('');
            return false;
        }
    });


    //incrustacion de parrado en el formulario
    let cuenta = 0;
    
    $("#btn-incrustar").click(function (e) {
        e.preventDefault();
        cuenta += 1;
        $("#f_blog ul").append("<li>Titulo parrafo " + cuenta + "<br><input type=\"text\" name=\"t_parrafo" + cuenta+"\" id=\"titulo_parrafo\"><br></li><li>parrafo " + cuenta + "<br><textarea name=\"parrafo"+ cuenta +"\" id=\"texto_parrafo\" cols=\"30\" rows=\"10\"></textarea></li><li>imagen "+ cuenta +" <br><input type=\"file\" name=\"imagen"+ cuenta +"\"></li>");

        
    })
})