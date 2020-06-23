<?php

require("../cone/conexion.php");

if(!empty($_POST['escrito']) || !empty($_POST['titulo']) || !empty($_FILES['imagen']['name'])){
    $uploadedFile = '';
    if(!empty($_FILES["file"]["type"])){
        $fileName = time().'_'.$_FILES['imagen']['name'];
        $valid_extensions = array("jpeg", "jpg", "png");
        $temporary = explode(".", $_FILES["imagen"]["name"]);
        $file_extension = end($temporary);
        if((($_FILES["hard_file"]["type"] == "image/png") || ($_FILES["imagen"]["type"] == "image/jpg") || ($_FILES["imagen"]["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions)){
            $sourcePath = $_FILES['imagen']['tmp_name'];
            $targetPath = "uploads/".$fileName;
            if(move_uploaded_file($sourcePath,$targetPath)){
                $uploadedFile = $fileName;
            }
        }
    }
    
    $escrito = $_POST['escrito'];
    $titulo = $_POST['titulo'];
    
    
    //insert form data in the database
    $insert = $mysqli->query("INSERT into blog (titulo,txt,img) VALUES ('".$escrito."','".$titulo."','".$uploadedFile."')");
    

}

?>