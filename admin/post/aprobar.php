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
            $total=$res->num_rows;
            $consulta->close();

            while($row = $res->fetch_assoc()){
                $tipo = $row['tipo'];
            }

            if($tipo=="admin"){
                $consulta = $mysqli->prepare("UPDATE `entrada_blog` SET `aprob` = '1' WHERE `id_ent` = ?");
                $id = mysqli_real_escape_string($mysqli, $_POST['id']);
                $consulta->bind_param("i",$id);
                $consulta->execute();
                $consulta->close();
                $mysqli->close();
            }else{
                $mysqli->close();
                header("location:../../inicio/index.php");
            }
        }else{
            header("location:../../inicio/index.php");
        }  
    }else{
        header("location:../../inicio/index.php");
    }

    
?>