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
                //cambio de clave
                if($_POST['parametro']=="clave"){
                    require("..\cone\conexion.php");
                    $consulta = $mysqli->prepare("SELECT hash FROM `login` WHERE `usuario` = ?");
                    $consulta->bind_param("s", $user);
                    $consulta->execute();
                    $res = $consulta->get_result();
                    while($row = $res->fetch_assoc()){
                        $vhash = $row['hash'];
                    }
                    $vpass = $_POST['vieja'];

                    $consulta->close();
                    if(password_verify($vpass, $vhash)){
                        $consulta = $mysqli->prepare("UPDATE `login` SET `hash` = ? WHERE `usuario` = ?");
                        $clave = mysqli_real_escape_string($mysqli, $_POST['clave']);
                        $hash = password_hash($clave, PASSWORD_DEFAULT);
                        $consulta->bind_param("ss", $hash, $user);
                        $consulta->execute();
                        $consulta->close();
                        $mysqli->close();
                    }else{
                        echo 1;
                    }

                    
                }

                if($_POST['parametro']=="inhabilitar"){
                    require("..\cone\conexion.php");
                    $consulta = $mysqli->prepare("SELECT hash FROM `login` WHERE `usuario` = ?");
                    $consulta->bind_param("s", $user);
                    $consulta->execute();
                    $res = $consulta->get_result();
                    while($row = $res->fetch_assoc()){
                        $vhash = $row['hash'];
                    }
                    $vpass = $_POST['vieja'];

                    $consulta->close();
                    if(password_verify($vpass, $vhash)){
                        $consulta = $mysqli->prepare("UPDATE `login` SET `activo` = '0' WHERE `id` = ?");
                        $idin = $_POST['usuario'];
                        $consulta->bind_param("s", $idin);
                        $consulta->execute();
                        $consulta->close();

                        $consulta = $mysqli->prepare("UPDATE `usuario` SET `activo` = '0' WHERE `id_login` = ?");
                        $consulta->bind_param("s", $idin);
                        $consulta->execute();
                        $mysqli->close();
                        $mysqli->close();
                    }else{
                        echo 1;
                    }
                }

                if($_POST['parametro']=="habilitar"){
                    require("..\cone\conexion.php");
                    $consulta = $mysqli->prepare("SELECT hash FROM `login` WHERE `usuario` = ?");
                    $consulta->bind_param("s", $user);
                    $consulta->execute();
                    $res = $consulta->get_result();
                    while($row = $res->fetch_assoc()){
                        $vhash = $row['hash'];
                    }
                    $vpass = $_POST['vieja'];

                    $consulta->close();
                    if(password_verify($vpass, $vhash)){
                        $consulta = $mysqli->prepare("UPDATE `login` SET `activo` = '1' WHERE `id` = ?");
                        $idin = $_POST['usuario'];
                        $consulta->bind_param("s", $idin);
                        $consulta->execute();
                        $consulta->close();

                        $consulta = $mysqli->prepare("UPDATE `usuario` SET `activo` = '1' WHERE `id_login` = ?");
                        $consulta->bind_param("s", $idin);
                        $consulta->execute();
                        $mysqli->close();
                        $mysqli->close();
                    }else{
                        echo 1;
                    }
                }

                if($_POST['parametro']=="datos"){
                    require("..\cone\conexion.php");
                    $consulta = $mysqli->prepare("SELECT hash FROM `login` WHERE `usuario` = ?");
                    $consulta->bind_param("s", $user);
                    $consulta->execute();
                    $res = $consulta->get_result();
                    while($row = $res->fetch_assoc()){
                        $vhash = $row['hash'];
                    }
                    $vpass = $_POST['vieja'];

                    $consulta->close();
                    if(password_verify($vpass, $vhash)){

                        $consulta = $mysqli->prepare("SELECT id FROM `login` WHERE `usuario` = ?");
                        $consulta->bind_param("s", $user);
                        $consulta->execute();
                        $res = $consulta->get_result();
                        $consulta->close();

                        while($row = $res->fetch_assoc()){
                        $idus = $row['id'];
                        }

                        $nombres = mysqli_real_escape_string($mysqli, $_POST['nombres']);
                        $apellidos = mysqli_real_escape_string($mysqli, $_POST['apellidos']);

                        $consulta = $mysqli->prepare("UPDATE `usuario` SET `nombres` = ?, `apellidos` = ? WHERE `id_login` = ?");
                        $consulta->bind_param("ssi", $nombres, $apellidos, $idus);
                        $consulta->execute();
                        $mysqli->close();
                    }else{
                        echo 1;
                    }
                }

            }
        }
    }    

?>