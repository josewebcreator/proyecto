$(document).ready(function () {

    $("#formulario").submit(function (e) {
        e.preventDefault()
        $.ajax({
            type: 'POST',
            url: 'publicar.php',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (msg) {
                $('.statusMsg').html('');
                if (msg == 'ok') {
                    $('#formulario')[0].reset();
                    //colocar mensaje de exito
                } else {
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


    //incrustacion de parrafo en #crea-blog
    let cuenta = 0;

    $("#btn-incrustar").click(function (e) {
        e.preventDefault();
        cuenta += 1;
        $("#crea-blog").append("<li><form class=\"p-secundario\">Titulo parrafo " + cuenta + "<br><input type=\"text\" name=\"t_parrafo \"class=\"titulo_parrafo\"><br>parrafo " + cuenta + "<br><textarea name=\"parrafo_apoyo\" id=\"texto_parrafo\" cols=\"30\" rows=\"10\"></textarea><br>imagen " + cuenta + " <br><input type=\"file\" name=\"imagen" + cuenta + "\" id=\"imagen_parrafo\"><input type=\"hidden\" name=\"t_entrada\" class=\"hidden\"></form></li>");

    })

    //recorrido del ul #crea-blog
    $("#btn-enviar").click(function (e) {
        e.preventDefault();
        $("#crea-blog li").each(function () {
            if (($(this).children(".p-principal")).length) {
                // $("form", this).each(function () {
                //     $.ajax({
                //         type: 'POST',
                //         url: 'crear-entrada-ppal.php',
                //         data: new FormData(this),
                //         contentType: false,
                //         cache: false,
                //         processData: false         
                //     })
                // })
                console.log("ok")
            } else {
                $("form", this).each(function () {
                    titulo = $("#crea-blog li .p-principal #titulo_entrada").val()
                    $(".hidden", this).val(titulo)
                    
                })

            }
        });

    });
})