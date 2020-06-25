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

    $("#btn-incrustar").click(function (e) {
        e.preventDefault();
        $("#p_secundarios").append("<p>hola</p>");
    })
})