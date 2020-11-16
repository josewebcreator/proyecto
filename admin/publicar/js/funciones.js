$(document).ready(function () {

    $("#imagen_cabecera").change(function () {
        var file = this.files[0];
        var imagefile = file.type;
        var match = ["image/jpeg", "image/png", "image/jpg"];
        if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
            alert('Seleccione un formato de imagen valido (JPEG/JPG/PNG).');
            $("#imagen_cabecera").val('');
            return false;
        }
    });


    //incrustacion de parrafo en #crea-blog
    var titulo
    $("#titulo_entrada").change(function () {
        titulo = $("#titulo_entrada").val()       
    });

    var token = $("#token").val()

    let cuenta = 0;

    $("#btn-incrustar").click(function (e) {
        e.preventDefault();
        cuenta += 1;
        $("#crea-blog").append("<li id=\"cuenta"+cuenta+"\"><form class=\"p-secundario\"><br><input type=\"text\"  placeholder=\" Titulo parrafo " + cuenta + " \" name=\"t_parrafo\"class=\"titulo_parrafo\"><br><textarea name=\"parrafo_apoyo\" placeholder=\"parrafo " + cuenta + "\" class=\"texto_parrafo\" cols=\"30\" rows=\"10\"></textarea><br>imagen " + cuenta + " <br><input type=\"file\" name=\"imagen\" class=\"imagen_parrafo\" accept=\"image/*\"><input type=\"hidden\" name=\"t_entrada\" class=\"hidden t_entrada \"><input type=\"hidden\" name=\"token\" class=\"hidden token \" value=\""+token+"\"><input type=\"hidden\" name=\"cuenta\" class=\"cuenta\" value=\""+cuenta+"\"></form><br><input type=\"button\" value=\"Borrar\" class=\"borrarParraf\" onclick=\" document.getElementById('cuenta"+cuenta+"').remove() \"></li>");

    })


    //funcion para que el parrafo pricipal aumente automaticamente su tamaño
    $('#texto_parrafo').on('change, keydown',function(e) {
        window.setTimeout(function() {

        $('#texto_parrafo')
        .css('height','auto') // <-- acá lo dejo scrollear por un instante
        .css('height',$('#texto_parrafo')[0].scrollHeight+'px');

        },50);
    });

    //delay del formulario
    function doDelay(wait) {
        var date = new Date();
        var startDate = date.getTime();
        var a = 1;
        var b = 0;
        while (a !== 0) {
            date = new Date();
            if ((date.getTime() - startDate) >= wait) {
                a = 0;
            }
            b++;
        }
    
    }



    //recorrido del ul #crea-blog
    $("#btn-enviar").click(function (e) {
        e.preventDefault();

        $("#crea-blog").each(function () {

            var check = []
            var formppal
            var formsecun = []

            $("li", this).each(function () { 
                $("form", this).children().each(function () {
                    
                    if ($(this).is("#titulo_entrada") || $(this).is("#texto_parrafo") || $(this).is("#imagen_cabecera") || $(this).is("#foto-footer") || $(this).is(".p-secundario") || $(this).is(".titulo_parrafo") || $(this).is(".texto_parrafo") || $(this).is(".imagen_parrafo") ||  $(this).is(".cuenta")) {
                        
                        if ($(this).val().length>0) {
                            check.push(1)
                        } else {
                            check.push(0)
                        }
                    }
                    if ($(this).is(".t_entrada")) {
                        $(this).val(titulo)
                    }
                    
                })
            });
            if (!check.includes(0)) {
                    
                $("#crea-blog li").each(function () {
                    
                    if (($(this).children(".p-principal")).length) {
                        console.log("1")
                        $("form", this).each(function () {
                            formppal = new FormData(this)
                        })
                                
                    } else {
                        console.log("2")
                        $("form", this).each(function () {
                            formsecun.push(new FormData(this))
                        })
                    }

                    
                })

                $("#crea-blog li").each(function () {
                    if (($(this).children(".p-principal")).length) {
                        console.log("3")
                        $.ajax({
                            type: 'POST',
                            url: 'crear-entrada-ppal.php',
                            data: formppal,
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function () {
                                for (var con = 0; con < formsecun.length; con = con+1){
                                    $.ajax({
                                        type: 'POST',
                                        url: 'subir-parrafo.php',
                                        data: formsecun[con],
                                        contentType: false,
                                        cache: false,
                                        processData: false         
                                    })
                                }
                            }
                        })      
                    }
                })

            } else {
                alert("Existen campos vacíos, por favor validar")
            }
        });
    });
})