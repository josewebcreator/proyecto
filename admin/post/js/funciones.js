$(document).ready(function () {
    
    //carga tabla con las entradas de blogs index.php
    $("#carga-tabla").load('tabla.php')

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


    //Envio de formulariosde editar.php
    $("#btn-editar").click(function (e) {
        e.preventDefault();
        $("#edicion li").each(function () {
            doDelay(150);
            if (($(this).children(".p-principal")).length) {
                
                $("form", this).each(function () {
                    $.ajax({
                        type: 'POST',
                        url: 'editar-principal.php',
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false         
                    })
                })
                doDelay(1000);
                console.log("principal")
            } else {
                // $("form", this).each(function () {
                    
                //     titulo = $("#crea-blog li .p-principal #titulo_entrada").val()
                //     $(".hidden", this).val(titulo)
                //     $.ajax({
                //         type: 'POST',
                //         url: 'subir-parrafo.php',
                //         data: new FormData(this),
                //         contentType: false,
                //         cache: false,
                //         processData: false         
                //     })
                   
                // })
                console.log("Secundario")
            }
        });

    });
})