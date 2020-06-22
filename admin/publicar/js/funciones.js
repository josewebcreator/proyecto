$(document).ready(
    $("enviar").click(function () {
        var titulo = $("titulo").val();
        var escrito = $("escrito").val();

        $.post("../publicar.php", {
            
        });
    })
)