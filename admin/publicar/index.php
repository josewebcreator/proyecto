<?php

    session_start();
    if(!($_SESSION["usuario"]==null)||!($_SESSION["usuario"]=="")){

        require("..\cone\conexion.php");
        $consulta = $mysqli->prepare("SELECT * FROM `login` WHERE `usuario` = ?");
        $user = mysqli_real_escape_string($mysqli, $_SESSION["usuario"]);
        $token = mysqli_real_escape_string($mysqli, $_SESSION["token"]);
        $consulta->bind_param("s",$user);
        $consulta->execute();
        $res = $consulta->get_result();
        $consulta->close();

        while($check = $res->fetch_assoc()){

            $checkUser = $check['usuario'];
            $checktoken = $check['token'];

        }

        $mysqli->close();

        if(($user==$checkUser)&&($token==$checktoken)){ ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear entrada</title>
</head>

<body>
    <ul id="crea-blog">
        <li>
            <form action="" class="p-principal">
                Titulo <br><input type="text" name="titulo_entrada" id="titulo_entrada" ><br>

                parrafo Principal <br>
                <textarea name="parrafo" id="texto_parrafo" cols="30" rows="10"></textarea>

                imagen de cabecera <br>
                <input type="file" name="imagen_cabecera" id="imagen_cabecera">

                footer foto <br>
                <textarea name="foto-footer" id="foto-footer" cols="30" rows="10"></textarea>
            </form>
        </li>
    </ul>
    <br>
    haga clic para incrustar otro parrafo
    <input type="button" value="incrustar" name="incrustar" id="btn-incrustar">
    <input type="button" value="enviar" name="enviar" id="btn-enviar">

    <script src="js\jquery.js"></script>
    <script src="js\funciones.js"></script>
</body>

</html>

<?php }else{
            header("location:../../inicio/index.php");
        }
    }else{ 
        header("location:../../inicio/index.php");
    }
?>