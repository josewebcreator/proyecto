<?php
    //sin subir imagen
    if(isset($_POST['principal']) && (empty($_FILES['imagen']['name']))){

        require('../cone/conexion.php');
        $consulta = $mysqli->prepare('UPDATE entrada_blog SET titulo = ? , foto_footer = ? , texto = ?');
        $titulo = mysql_real_escape_string($mysqli, $_POST['titulo']);
        $foto_footer = mysql_real_escape_string($mysqli, $_POST['foto_footer']);
        $texto = mysql_real_escape_string($mysqli, $_POST['texto']);
        $consulta->bind_param("sss", $titulo, $foto_footer, $texto);
        echo $mysqli->error;
        if($consulta->execute()){
            
        }

    //subir imagen
    }elseif(!empty($_FILES['imagen']['name'])){
        require('../cone/conexion.php');

    }

?>