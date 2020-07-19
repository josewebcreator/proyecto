<?php



    require("../cone/conexion.php");



    if(!empty($_POST['t_parrafo']) || !empty($_POST['parrafo_apoyo']) || !empty($_FILES['imagen']['name'])){
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


        //
        $consulta= $mysqli->prepare("SELECT id_ent FROM entrada_blog WHERE titulo = ?");
        $ent_titulo = mysqli_real_escape_string($mysqli, $_POST['t_entrada']);
        $consulta->bind_param("s", $ent_titulo);
        echo $mysqli->error;
        $consulta->execute();
        $resultado = $consulta->get_result();
        $fila = $resultado->fetch_assoc();
        //$consulta->bind_result($p_id);
        $p_id = $fila['id_ent'];
        //$p_id = $row["id"][0];
        $consulta->close();
        //echo $p_id . "<br>"; 
        
        //insert form data in the database

        $insertar = $mysqli->prepare("INSERT INTO parrafo_blog (orden, id_entrada_blog, sub_titulo, imagen_parrafo, texto) VALUES (?, ?, ?, ?, ?)");
        //echo "44<br>" .$mysqli->error;
        $titulo = mysqli_real_escape_string($mysqli, $_POST['t_parrafo']);
        $escrito = mysqli_real_escape_string($mysqli, $_POST['parrafo_apoyo']);
        $cuenta = mysqli_real_escape_string($mysqli, $_POST['cuenta']);

        $insertar->bind_param("iisss", $cuenta, $p_id, $titulo, $uploadedFile, $escrito);
        //echo "49<br>" . $mysqli->error;
        
        $insertar->execute();
        //echo "52<br>" . $mysqli->error;
        $insertar->close();
        $mysqli->close();
    }

?> 