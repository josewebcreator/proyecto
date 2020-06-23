$(document).ready(
    $("#formulario").submit(function (e) { 
        e.preventDefault() 
        $.ajax({
            type: "POST",
            url: "../publicar.php",
            data: FormData,
            dataType: "dataType",
            success: function (response) {
                
            }
        });
    })
)