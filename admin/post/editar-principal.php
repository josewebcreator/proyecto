<?php
    //sin subir imagen
    if(isset($_POST['principal']) && (empty($_FILES['imagen']['name']))){

        require('../cone/conexion.php');
        $consulta = $mysqli->prepare('UPDATE entrada_blog SET titulo = ?, foto_footer = ?, texto = ? WHERE id_ent = ?');
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
            $targetPath = "uploads/".$fileName;
            if(move_uploaded_file($sourcePath,$targetPath)){
                $uploadedFile = $fileName;
            }
        }
        
        $imagen = $mysqli->prepare('SELECT imagen_central WHERE id_ent = ?');
        $id = mysql_real_escape_string($mysqli, $_POST['id']);
        $imagen->bind_param("i", $id);
        $imagen->execute();
        $rimagen= $imagen->get_result();
        $imagen->close();

        $rimagen = $rimagen->fetch_assoc();
        $ruta = "uploads/". $rimagen['imagen_central'];  
        
        unlink($ruta);

        

        $consulta = $mysqli->prepare('UPDATE entrada_blog SET titulo = ?, foto_footer = ?, texto = ?, imagen_central = ? WHERE id_ent = ?');

        $titulo = mysql_real_escape_string($mysqli, $_POST['titulo']);
        $foto_footer = mysql_real_escape_string($mysqli, $_POST['foto_footer']);
        $texto = mysql_real_escape_string($mysqli, $_POST['texto']);       
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

?>