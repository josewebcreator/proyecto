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

            if(isset($_POST['id'])&&isset($_POST['orden'])){
            echo $_POST['id'];
            require('../cone/conexion.php');
            $consulta = $mysqli->prepare("DELETE FROM `parrafo_blog`WHERE `id` = ? AND `orden` = ?;");
            $id = mysqli_real_escape_string($mysqli, $_POST['id']);
            $orden = mysqli_real_escape_string($mysqli, $_POST['orden']);
            $consulta->bind_param("ii", $id, $orden);
            $consulta->execute();
            $consulta->close();
            $mysqli->close();
            
            }
        }else{
            header("location:../../inicio/index.php");
        }
    }else{ 
        header("location:../../inicio/index.php");
    }
    

?>