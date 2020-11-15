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
            require("..\cone\conexion.php");
            $consulta = $mysqli->prepare("SELECT id FROM `login` WHERE `usuario` = ?");
            $consulta->bind_param("s",$user);
            $consulta->execute();
            $res = $consulta->get_result();
                while($row = $res->fetch_assoc()){
                    $id_log = $row['id'];
                }
            $consulta->close();

            $consulta = $mysqli->prepare("SELECT * FROM `usuario` WHERE `id_login` = ?");
            $consulta->bind_param("i",$id_log);
            $consulta->execute();
            $res = $consulta->get_result();
            $consulta->close();

            while($row = $res->fetch_assoc()){
                $tipo = $row['tipo'];
            }

            if($tipo=="admin"){
                
                $consulta= $mysqli->prepare("INSERT INTO `login` (`usuario`, `hash`, `mail`, `token`) SELECT ?, ?, ?, ?");
                $usuario= mysqli_real_escape_string($mysqli, $_POST['nick']);
                $mail= mysqli_real_escape_string($mysqli, $_POST['direccioncorreo']);
                $clave= mysqli_real_escape_string($mysqli, $_POST['clave']);
                $hash = password_hash($clave, PASSWORD_DEFAULT);
                $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
                $token = substr(str_shuffle($permitted_chars), 0, 6);
                $consulta->bind_param("ssss", $usuario, $hash, $mail, $token);
                $consulta->execute();
                $consulta->close();





            }else{
                header("location:../../inicio/index.php");
            }

        }else{
            header("location:../../inicio/index.php");
        }  
    }else{
        header("location:../../inicio/index.php");
    }
?>            