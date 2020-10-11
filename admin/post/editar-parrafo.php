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
            if(isset($_POST['id']) && (empty($_FILES['imagen_parrafo']['name']))){

                require('../cone/conexion.php');
                $consulta = $mysqli->prepare('UPDATE parrafo_blog SET sub_titulo = ?, texto = ? WHERE id_entrada_blog = ? AND orden = ?');
                $titulo = mysqli_real_escape_string($mysqli, $_POST['subtitulo']);
                $orden = mysqli_real_escape_string($mysqli, $_POST['orden']);
                $texto = mysqli_real_escape_string($mysqli, $_POST['texto']);
                $id = mysqli_real_escape_string($mysqli, $_POST['id']);

                echo $mysqli->error;

                $consulta->bind_param("ssii", $titulo, $texto, $id, $orden);
                echo $mysqli->error . "12<br>";
                if($consulta->execute()){
                    echo "exito";
                    $consulta->close();
                }else{
                    echo $mysqli->error . "16<br>";
                    $consulta->close();
                }

            }elseif(isset($_POST['id']) && !(empty($_FILES['imagen_parrafo']['name']))){

                require('../cone/conexion.php');

                $fileName = time().'_'.$_FILES['imagen_parrafo']['name'];
                $valid_extensions = array("jpeg", "jpg", "png");
                $temporary = explode(".", $_FILES["imagen_parrafo"]["name"]);
                $file_extension = end($temporary);
                if((($_FILES["imagen_parrafo"]["type"] == "image/png") || ($_FILES["imagen_parrafo"]["type"] == "image/jpg") || ($_FILES["imagen_parrafo"]["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions)){
                    $sourcePath = $_FILES['imagen_parrafo']['tmp_name'];
                    $targetPath = "../publicar/uploads/".$fileName;
                    if(move_uploaded_file($sourcePath,$targetPath)){
                        $uploadedFile = $fileName;
                    }
                }
                
                $imagen = $mysqli->prepare('SELECT imagen_parrafo FROM parrafo_blog WHERE id_entrada_blog = ? AND orden = ?');
                $id = mysqli_real_escape_string($mysqli, $_POST['id']);
                $orden = mysqli_real_escape_string($mysqli, $_POST['orden']);

                echo $mysqli->error;
                $imagen->bind_param("ii", $id, $orden);
                $imagen->execute();
                $rimagen= $imagen->get_result();
                $imagen->close();

                $rimagen = $rimagen->fetch_assoc();
                $ruta = "../publicar/uploads/". $rimagen['imagen_parrafo'];  
                
                print_r($ruta);
                unlink($ruta);

                $consulta = $mysqli->prepare('UPDATE parrafo_blog SET sub_titulo = ?, texto = ?, imagen_parrafo = ? WHERE id_entrada_blog = ? AND orden = ?');

                $titulo = mysqli_real_escape_string($mysqli, $_POST['subtitulo']);
                $orden = mysqli_real_escape_string($mysqli, $_POST['orden']);
                $texto = mysqli_real_escape_string($mysqli, $_POST['texto']);
                $id = mysqli_real_escape_string($mysqli, $_POST['id']);     
                $consulta->bind_param("sssii", $titulo, $texto, $uploadedFile, $id, $orden);

                echo $mysqli->error . "64<br>";

                if($consulta->execute()){
                    echo "exito";
                    $consulta->close();
                }else{
                    echo $mysqli->error . "70<br>";
                    $consulta->close();
                }

            }

            $mysqli->close();
        }else{
            header("location:../../inicio/index.php");
        }
    }else{
        header("location:../../inicio/index.php");
    }
?>