$(document).ready(function () {
    
    $('#enviar-form').click(function (e) { 
        e.preventDefault();
        var check = []
        $('#cuadro-formulario').each(function () {
            $('form', this).children().each(function () {
                $(this).children().each(function () {

                    if ($(this).is('#direccioncorreo')||$(this).is('#datospersonales')||$(this).is('#mensaje')) {
                        if ($(this).val().length>0) {
                            check.push(1)
                        } else {
                            check.push(0)
                        }
                    }
                })
            })

            if (!(check.includes(0))) {
                $('form', this).each(function () {
                    $.ajax({
                        type: "post",
                        url: "enviar.php",
                        data: new FormData(this),
                        dataType: "dataType",
                        contentType: false,
                        cache: false,
                        processData: false 
                    });
                })
                alert("Su mensaje se ha enviado exitosamente")
            } else {
                alert("Por favor no dejar campos vacíos")
            }
        });
        return
    });

});