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
    let cuenta = 0;

    $("#btn-incrustar").click(function (e) {
        e.preventDefault();
        cuenta += 1;
        $("#crea-blog").append("<li><form class=\"p-secundario\">Titulo parrafo " + cuenta + "<br><input type=\"text\" name=\"t_parrafo\"class=\"titulo_parrafo\"><br>parrafo " + cuenta + "<br><textarea name=\"parrafo_apoyo\" class=\"texto_parrafo\" cols=\"30\" rows=\"10\"></textarea><br>imagen " + cuenta + " <br><input type=\"file\" name=\"imagen\" class=\"imagen_parrafo\" accept=\"image/*\"><input type=\"hidden\" name=\"t_entrada\" class=\"hidden\"><input type=\"hidden\" name=\"cuenta\" class=\"cuenta\" value=\""+cuenta+"\"></form></li>");

    })
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

            $("li", this).each(function () { 
                $("form", this).children().each(function () {
                    
                    if ($(this).is("#titulo_entrada") || $(this).is("#texto_parrafo") || $(this).is("#imagen_cabecera") || $(this).is("#foto-footer") || $(this).is(".p-secundario") || $(this).is(".titulo_parrafo") || $(this).is(".texto_parrafo") || $(this).is(".imagen_parrafo") ||  $(this).is(".cuenta")) {
                        
                        if ($(this).val().length>0) {
                            check.push(1)
                        } else {
                            check.push(0)
                        }

                    }
                   
                    
                })
            });
            if(!check.includes(0)){
                $("#crea-blog li").each(function () {
                    doDelay(150);
                    if (($(this).children(".p-principal")).length) {
                        
                        $("form", this).each(function () {
                            $.ajax({
                                type: 'POST',
                                url: 'crear-entrada-ppal.php',
                                data: new FormData(this),
                                contentType: false,
                                cache: false,
                                processData: false         
                            })
                        })
                        doDelay(1000);
                    } else {
                        $("form", this).each(function () {
                            
                            titulo = $("#crea-blog li .p-principal #titulo_entrada").val()
                            $(".hidden", this).val(titulo)
                            $.ajax({
                                type: 'POST',
                                url: 'subir-parrafo.php',
                                data: new FormData(this),
                                contentType: false,
                                cache: false,
                                processData: false         
                            })
                        
                        })

                    }
                });
            } else {
                alert("Existen campos vacíos, por favor validar")
            }
        });
    });
})