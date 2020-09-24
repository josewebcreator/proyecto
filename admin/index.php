<?php

    session_start();

    if((isset($_SESSION["usuario"]))){

        require("cone\conexion.php");
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

        if(($user==$checkUser)&&($token==$checktoken)){
            header("location:post/index.php");
        }

    }else{

?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="css\bootstrap.min.css">
            <link rel="stylesheet" href="css\estilos.css">
            <script src="..\js\jquery.js"></script>
            <title>Login</title>
        </head>
        <body id="body-log">


            <div id="login">
                    <div class="logo-banner">
                        <div class="logo"><h3>logo</h3></div>
                    </div>
                    <div id="datos" class="form-group">
                        <form action="">
                            <input type="text" placeholder="Usuario" name="usuario" id="usuario" class="datolog form-control">
                            <br>
                            <input type="password" placeholder="Contraseña" name="keyword" id="keyword" class="datolog form-control">
                            <br>
                            <input type="button" value="Enviar" name="ingresar" class="btn btn-primary" id="ingresar">
                        </form>
                    </div>
            </div>


        <script src="js\funciones.js"></script>
        </body>
        </html>
    <?php  }//fin del If?>