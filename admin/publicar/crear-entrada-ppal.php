<?php

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
    
    $escrito = $_POST['escrito'];
    $titulo = $_POST['titulo'];
    
    
    //insert form data in the database
    $insert = $mysqli->query("INSERT into `blog` (`titulo`, `img`, `text`) VALUES ('".$titulo."','".$uploadedFile."','".$escrito."')");
    

}

?>