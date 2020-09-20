<?php

    session_start();
    if(!($_SESSION["usuario"]==null)||!($_SESSION["usuario"]=="")){

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

        if(($user==$checkUser)&&($token==$checktoken)){
            header("location:post/tabla.php");
        }

    }else{

?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <script src="..\js\jquery.js"></script>
            <title></title>
        </head>
        <body>
            <div id="login">
                    <div id="titulo">
                        <h2>Login</h2>
                    </div>
                    <div id="datos">
                        <form action="">
                            <input type="text" name="usuario" id="usuario" class="datolog">
                            <br>
                            <input type="password" name="keyword" id="keyword" class="datolog">
                            <br>
                            <input type="button" value="" name="ingresar" id="ingresar">
                        </form>
                    </div>
            </div>


        <script src="js\funciones.js"></script>
        </body>
        </html>
    <?php  }//fin del If?>