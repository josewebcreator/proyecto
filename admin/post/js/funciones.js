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
        return
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
            var formppal
            var formsecun = []
            $("#edicion li").each(function () {
                doDelay(150);
                if (($(this).children(".p-principal")).length) {
                    
                    $("form", this).each(function () {
                        formppal = new FormData(this)
                    })

                } else {
                    $("form", this).each(function () {
                        formsecun.push(new FormData(this))  
                    })
                }
                if (($(this).children(".p-principal")).length) {
                    $("form", this).each(function () {
                        $.ajax({
                            type: 'POST',
                            url: 'editar-principal.php',
                            data: formppal,
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function () {
                                for (var con = 0; con < formsecun.length; con = con+1){
                                    $.ajax({
                                        type: 'POST',
                                        url: 'editar-parrafo.php',
                                        data: formsecun[con],
                                        contentType: false,
                                        cache: false,
                                        processData: false         
                                    })
                                }
                            }
                        })
                    })
                }

            });
        } else {
            alert("existen campos vacios, por favor validar")
        }
        
        doDelay(150)
        //location.reload()
        return
    });

    //Sustituidor de clases

    function cambioHijo() {
        var con = 0
        var hijo = "hijo"
        $("#edicion li").each(function () {
            if (!($(this).is("#edit-pPal"))) {
                //console.log("ok")
                con += 1
                hijo = "hijo"
                hijo = hijo + con
                $(this).removeClass()
                $(this).addClass('edit-pSecundario')
                $(this).addClass(hijo)
            }
        })
        return
    }

    //Selec InsertSelec para insertar parrafos

    function armarSelect() {
        var con = 0
        var o
        var name
        $("#edicion li").each(function () {
            if ($(this).is(".edit-pSecundario")) {
                //console.log("ok")
                con += 1
                $("form", this).children().each(function () {
                    
                    if ($(this).is(".parraf-sub")) {
                        name = $(this).val()
                        o = new Option(name, con);
                        $(o).html(name);
                        $("#insertSelec").append(o);
                    }
                    
                })
            }
        })
        
        return
    }

    //obtencion ID de la publicacion

    var idEnt

    idEnt = $(".ppal-id").val()

    //Obtencion y almacenamiento valor selec

    var seleccion = 0

    $("#insertSelec").change(function () {
        seleccion = $('#insertSelec').val()
        //console.log(seleccion)
        return
    })

    armarSelect()

    

    //funcion para reemplazar botones de borrado
    var aux

    function cambiarBorrado() {
        var i = 0
       $("#edicion li").each(function () {
            if ($(this).is(".edit-pSecundario")) {
                //console.log("ok")
                $( this).children().each(function () {
                    if ($(this).is(".borrar")) {
                        $(this).replaceWith("<input type=\"button\" value=\"Borrar\" name=\"borrar\"  onclick=\"borrarParrafo(" + aux[i][1] + "," + aux[i][2] + ")\" class=\"borrar btn-warning btn-lg\"></input>")
                        i += 1
                    }
                })
            }
       })
       return
    }
    
    /*reorganizacion para la insercion de un nuevo parrafo*/
    function ordenParraf(array) {
        var ordena = array
        //console.log(ordena)
        $.post("reordenar.php",
            {
                viejo : ordena[0],
                nuevo: ordena[1],
                id: ordena[2]
            },
            function (){
                console.log(ordena)
            }
        )
        return
    }

    

    function orden() {
        var actual = []
        var val
        var nuevo = []
        var nVal = 0
        aux = []

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
                        $(this).val(nVal)
                    }
                    if ($(this).is(".parraf-id")) {

                        $(this).val(idEnt)
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

    //insercion de nuevo parrafo

    $(".agregar-parraf").click(function () {
        //console.log("ok")
        var hijo = ".hijo" + seleccion
        $("<li class=\"edit-pSecundario\"><form><input type=\"hidden\" name=\"id\" class=\"parraf-id\" value=\"\"><br><input type=\"hidden\" name=\"orden\" class=\"parraf-orden\" value=\"provisional\"><br><input type=\"text\" name=\"subtitulo\" class=\"parraf-sub\" value=\"ingresar Subtitulo\"><br><textarea name=\"texto\" id=\"\" cols=\"30\" rows=\"10\" class=\"parraf-tex\"></textarea><br><input type=\"file\" name=\"imagen_parrafo\" accept=\"image/*\" class=\"parraf-img\"><br></form><input type=\"button\" value=\"Borrar\" name=\"borrar\" onclick=\"borrarParrafo("+ idEnt +","+ (seleccion + 1) +")\" class=\"borrar btn-warning btn-lg\"></li>").insertAfter(hijo)
        
        orden()
        doDelay(250)
        cambiarBorrado()
        doDelay(250)
        cambioHijo()
        $("#insertSelec").empty()
        $('#insertSelec').append('<option value="0">Parrafo Principal</option>');
        armarSelect()
        return
    })


    //crear nuevo usuario




    $("#boton-crear-user").click(function (e) {
        e.preventDefault();
        var check = []
        var clave
        var reclave
        var continuar
        $('#new-user-form').each(function () {
            $("form", this).each(function () {
                $(".form-group", this).children().each(function () {
                    if ($(this).is("#direccioncorreo") || $(this).is("#nombres") || $(this).is("#apellidos") || $(this).is("#nick") || $(this).is("#clave") || $(this).is("#reclave")) {
                        
                        if ($(this).val().length>0) {
                            check.push(1)
                        } else {
                            check.push(0)
                        }

                    }

                    if ($(this).is("#clave")) {
                        clave = $(this).val()
                    }
                    if ($(this).is("#reclave")) {
                        reclave = $(this).val()
                    }


                })
            })

            if (!check.includes(0)) {
                if (clave == reclave) {
                    
                    $("form", this).each(function () {
                        var form = new FormData(this)

                        $.ajax({
                            type: "post",
                            url: "checkusuario.php",
                            data: new FormData(this),
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (e) {
                                continuar = e
                                if (continuar==0) {
                                
                                    $.ajax({
                                        type: 'POST',
                                        url: 'enviarnuevolog.php',
                                        data: form,
                                        contentType: false,
                                        cache: false,
                                        processData: false,
                                        success: function () {
                                            $.ajax({
                                                type: 'POST',
                                                url: 'enviarnuevouser.php',
                                                data: form,
                                                contentType: false,
                                                cache: false,
                                                processData: false,
                                                success: function () {
                                                    alert('se ha creado exitosamente el usuario')
                                                }
                                            })   
                                        }
                                    })

                                } else {
                                    alert("ya existe ese nick de usuario")
                                }
                            },
                            complete: function () {
                                console.log(continuar)
                            }
                        });
                    })
                } else {
                    alert("la clave y la confirmacion no coinciden, por favor validar")
                }

            } else {
                alert("todos los campos deben ser completados")
            }
        })

        return
    })

    //cambio de clave en seguridad

    $("#boton-cambiar-clave").click(function (e) { 
        e.preventDefault();
        var check = []
        var clave
        var reclave
        $(".form-cambiarclave").each(function () {
            $("form", this).children().each(function () {
                if ($(this).is("#clave") || $(this).is("#reclave") ) {
                        
                    if ($(this).val().length>0) {
                        check.push(1)
                    } else {
                        check.push(0)
                    }

                    if ($(this).is("#clave")) {
                        clave = $(this).val()
                    }
                    if ($(this).is("#reclave")) {
                        reclave = $(this).val()
                    }

                }
            })

            $("form", this).each(function () {
                var cambio = new FormData(this)
                if (!check.includes(0)) {
                    if (clave == reclave) {

                        $.ajax({
                            type: "post",
                            url: "spros.php",
                            data: cambio,
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (response) {
                                if (response == 1) {
                                    alert("Clave actual incorrecta")
                                } else {
                                    alert("contraseña cambiada con exito")
                                }
                                
                            }
                        });
                    } else {
                        alert("la clave y la confirmacion no coinciden, por favor validar")
                    }

                } else {
                    alert("todos los campos deben ser completados")
                }    
            })

        })
        
    });


})