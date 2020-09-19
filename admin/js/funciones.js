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
            console.log("ok")
        } else {
            alert("Falta usuario o Password")
        }
    })

});