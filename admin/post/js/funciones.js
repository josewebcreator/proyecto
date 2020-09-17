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
        var check = [];
        $("#edicion").each(function () {
           
            $("li", this).each(function () {
                $("form", this).children().each(function () {
                    if ($(this).is(".ppal-id") || $(this).is(".ppal-ttlo") || $(this).is(".ppal-texto") || $(this).is(".ppal-footer") || $(this).is(".parraf-sub") || $(this).is(".parraf-tex") ) {
                        
                        if ($(this).val().length>0) {
                            check.push(1)
                        } else {
                            check.push(0)
                        }

                    }
                })
            })
        })

        if (!check.includes(0)) {
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
                    doDelay(3000);
                } else {

                    $("form", this).each(function () {
                        
                        $.ajax({
                            type: 'POST',
                            url: 'editar-parrafo.php',
                            data: new FormData(this),
                            contentType: false,
                            cache: false,
                            processData: false         
                        })
                    
                    })

                }
            });
        } else {
            alert("existen campos vacios, por favor validar")
        }
            

    });
})