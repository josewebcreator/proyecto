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

            require("../cone/conexion.php");
            if(!empty($_POST['titulo_entrada']) || !empty($_POST['parrafo']) || !empty($_FILES['imagen_cabecera']['name'])){
                $uploadedFile = '';
                if(!empty($_FILES["imagen_cabecera"]["type"])){
                    $fileName = time().'_'.$_FILES['imagen_cabecera']['name'];
                    $valid_extensions = array("jpeg", "jpg", "png");
                    $temporary = explode(".", $_FILES["imagen_cabecera"]["name"]);
                    $file_extension = end($temporary);
                    if((($_FILES["imagen_cabecera"]["type"] == "image/png") || ($_FILES["imagen_cabecera"]["type"] == "image/jpg") || ($_FILES["imagen_cabecera"]["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions)){
                        $sourcePath = $_FILES['imagen_cabecera']['tmp_name'];
                        $targetPath = "uploads/".$fileName;
                        if(move_uploaded_file($sourcePath,$targetPath)){
                            $uploadedFile = $fileName;
                        }
                    }
                }
            
                $escrito = mysqli_real_escape_string($mysqli, $_POST['parrafo']);
                $titulo =  mysqli_real_escape_string($mysqli, $_POST['titulo_entrada']);
                $footer = mysqli_real_escape_string($mysqli, $_POST['foto-footer']);
                $len = "es";
                
                //insert form data in the database
                $insert = $mysqli->prepare("INSERT INTO entrada_blog (lenguaje, titulo, imagen_central, foto_footer, texto) VALUES (?, ?, ?, ?, ?)");
                $insert->bind_param("sssss",$len, $titulo, $uploadedFile, $footer, $escrito);
                echo $mysqli->error;
                
                $insert->execute();
                $insert->close();
                $mysqli->close();
            }
        }else{
            header("location:../../inicio/index.php");
        }
    }else{ 
        header("location:../../inicio/index.php");
    }
?>