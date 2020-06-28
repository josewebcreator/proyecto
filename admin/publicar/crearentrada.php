<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear entrada</title>
</head>

<body>
    <form action="" id="f_blog">

        <ul>

            <li>
                Titulo <br><input type="text" name="titulo_entrada" id="titulo_entrada"><br>
            </li>
            <li>
                parrafo Principal <br>
                <textarea name="parrafo" id="texto_parrafo" cols="30" rows="10"></textarea>
            </li>
            <li>
                imagen de cabecera <br>
                <input type="file" name="imagen_cabecera">
            </li>
        </ul>
        <div id="p_sedundarios"></div><br>
        haga clic para incrustar otro parrafo
        <input type="button" value="" name="incrustar" id="btn-incrustar">

    </form>
    <script src="js\jquery.js"></script>
    <script src="js\funciones.js"></script>
</body>

</html>