<?php

    if(isset($_POST['id']) && (empty($_FILES['imagen_parrafo']['name']))){

        require('../cone/conexion.php');
        $consulta = $mysqli->prepare('UPDATE parrafo_blog SET sub_titulo = ?, imagen_parrafo = ?, texto = ? WHERE id = ? AND orden = ?');
        $titulo = mysqli_real_escape_string($mysqli, $_POST['subtitulo']);
        $orden = mysqli_real_escape_string($mysqli, $_POST['orden']);
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

    }elseif(isset($_POST['id']) && !(empty($_FILES['imagen_parrafo']['name']))){



    }

?>