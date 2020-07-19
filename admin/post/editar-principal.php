<?php
    //sin subir imagen
    if(isset($_POST['principal']) && (empty($_FILES['imagen']['name']))){

        require('../cone/conexion.php');
        $consulta = $mysqli->prepare('UPDATE entrada_blog SET titulo = ?, foto_footer = ?, texto = ? WHERE id_ent = ?');
        $titulo = mysql_real_escape_string($mysqli, $_POST['titulo']);
        $foto_footer = mysql_real_escape_string($mysqli, $_POST['foto_footer']);
        $texto = mysql_real_escape_string($mysqli, $_POST['texto']);
        $id = mysql_real_escape_string($mysqli, $_POST['id']);
        $consulta->bind_param("sssi", $titulo, $foto_footer, $texto, $id);
        echo $mysqli->error;
        if($consulta->execute()){
            echo "exito";
        }else{
            echo $mysqli->error;
        }

    //subir imagen
    }elseif(!empty($_FILES['imagen']['name'])){
        
        require('../cone/conexion.php');
        $uploadedFile = '';

        if(!empty($_FILES["imagen"]["type"])){
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
        }
    }

?>