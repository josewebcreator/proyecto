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
            require('../cone/conexion.php');
            $consulta = $mysqli->prepare("DELETE FROM `parrafo_blog` WHERE `id_entrada_blog` = ?");
            $id= mysqli_real_escape_string($mysqli, $_POST['id']);
            $consulta->bind_param("i",$id);
            $consulta->execute();
            $consulta->close();
            $consulta = $mysqli->prepare("DELETE FROM `entrada_blog` WHERE `borrado` = '1' AND (`id_ent` = ?)");
            $consulta->bind_param("s",$id);
            $consulta->execute();
            $consulta->close();
            $mysqli->close();

        }else{
            header("location:../../inicio/index.php");
        }

    }else{
        header("location:../../inicio/index.php");
    }

?>