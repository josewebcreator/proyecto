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
    //sin subir imagen
            if(isset($_POST['principal']) && (empty($_FILES['imagen']['name']))){

                require('../cone/conexion.php');
                $consulta = $mysqli->prepare('UPDATE entrada_blog SET titulo = ?, foto_footer = ?, texto = ?, aprob = 0 WHERE id_ent = ?');
                $titulo = mysqli_real_escape_string($mysqli, $_POST['titulo']);
                $foto_footer = mysqli_real_escape_string($mysqli, $_POST['foto-footer']);
                $texto = mysqli_real_escape_string($mysqli, $_POST['texto']);
                $id = mysqli_real_escape_string($mysqli, $_POST['id']);
                $consulta->bind_param("sssi", $titulo, $foto_footer, $texto, $id);
                echo $mysqli->error . "12<br>";
                if($consulta->execute()){
                    echo "exito";
                    $consulta->close();
                }else{
                    echo $mysqli->error . "16<br>";
                    $consulta->close();
                }

            //subir imagen
            }elseif(isset($_POST['principal']) && !empty($_FILES['imagen']['name'])){

                require('../cone/conexion.php');
                $uploadedFile = '';

                
                $fileName = time().'_'.$_FILES['imagen']['name'];
                $valid_extensions = array("jpeg", "jpg", "png");
                $temporary = explode(".", $_FILES["imagen"]["name"]);
                $file_extension = end($temporary);
                if((($_FILES["imagen"]["type"] == "image/png") || ($_FILES["imagen"]["type"] == "image/jpg") || ($_FILES["imagen"]["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions)){
                    $sourcePath = $_FILES['imagen']['tmp_name'];
                    $targetPath = "../publicar/uploads/".$fileName;
                    if(move_uploaded_file($sourcePath,$targetPath)){
                        $uploadedFile = $fileName;
                    }
                }
                
                $imagen = $mysqli->prepare('SELECT imagen_central FROM entrada_blog WHERE id_ent = ?');
                $id = mysqli_real_escape_string($mysqli, $_POST['id']);
                echo $mysqli->error;
                $imagen->bind_param("i", $id);
                $imagen->execute();
                $rimagen= $imagen->get_result();
                $imagen->close();

                $rimagen = $rimagen->fetch_assoc();
                $ruta = "../publicar/uploads/". $rimagen['imagen_central'];  
                
                print_r($ruta) ;
                unlink($ruta);

                

                $consulta = $mysqli->prepare('UPDATE entrada_blog SET titulo = ?, foto_footer = ?, texto = ?, imagen_central = ?,  aprob = 0 WHERE id_ent = ?');

                $titulo = mysqli_real_escape_string($mysqli, $_POST['titulo']);
                $foto_footer = mysqli_real_escape_string($mysqli, $_POST['foto-footer']);
                $texto = mysqli_real_escape_string($mysqli, $_POST['texto']);       
                $consulta->bind_param("ssssi", $titulo, $foto_footer, $texto, $uploadedFile, $id);

                echo $mysqli->error . "46<br>";

                if($consulta->execute()){
                    echo "exito";
                    $consulta->close();
                }else{
                    echo $mysqli->error . "51<br>";
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