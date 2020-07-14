$(document).ready(function () {
    
    //carga tabla con las entradas de blogs index.php
    $("#carga-tabla").load('tabla.php')

    //recorrido del ul #crea-blog
    $("#btn-enviar").click(function (e) {
        e.preventDefault();
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

    });
})