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

    /*reorganizacion para la insercion de un nuevo parrafo*/
    function ordenParraf(array) {
        var ordena = array
        console.log(ordena)
        return
    }

    var idEnt

    idEnt = $(".ppal-id").val()
    

    function orden() {
        var actual = []
        var val
        var nuevo = []
        var nVal = 0
        var aux = []

        $("#edicion li").each(function () {
            if ($(this).is(".edit-pSecundario")) {
                //console.log("ok")
                $("form", this).children().each(function () {
                    if ($(this).is(".parraf-orden")) {
                        val = $(this).val()
                        //console.log(val)
                        actual.push(val)
                    }
                })
            }
        })

        $("#edicion li").each(function () {
            if ($(this).is(".edit-pSecundario")) {
                //console.log("ok")
                $("form", this).children().each(function () {
                    if ($(this).is(".parraf-orden")) {
                        nVal += 1
                        nuevo.push(nVal)
                        //programar el cambio del val parraf orden
                    }
                })
            }
        })

        for (var con = 0; con < nVal; con = con+1){
            //console.log(con)
            aux.push([actual[con], nuevo[con], idEnt])
        }

        for (con = 0; con < nVal; con = con + 1){
            ordenParraf(aux[con])
        }

        return
    }
    
    $(".orden").click(function (e) { 
        e.preventDefault()
        orden()
        return
    });
    

})