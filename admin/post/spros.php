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

        if(($user==$checkUser)&&($token==$checktoken)){
            if(isset($_POST['parametro'])){
                if($_POST['parametro']=="clave"){
                    require("..\cone\conexion.php");
                    $consulta = $mysqli->prepare("UPDATE `login` SET `hash` = ? WHERE `usuario` = ?");
                    $clave = mysqli_real_escape_string($mysqli, $_POST['clave']);
                    $hash = password_hash($clave, PASSWORD_DEFAULT);
                    $consulta->bind_param("ss", $hash, $user);
                    $consulta->execute();
                    $consulta->close();
                    $mysqli->close();
                }
            }
        }
    }    

?>