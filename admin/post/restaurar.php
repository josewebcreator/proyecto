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
            $consulta = $mysqli->prepare("UPDATE `entrada_blog` SET `borrado` = '0' where `id_ent` = ?");
            $id= mysqli_real_escape_string($mysqli, $_POST['id']);
            $consulta->bind_param("i",$id);
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