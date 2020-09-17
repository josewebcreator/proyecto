<?php
    
    if(isset($_POST['id'])&&isset($_POST['orden'])){
        echo $_POST['id'];
        require('../cone/conexion.php');
        $consulta = $mysqli->prepare("DELETE FROM `parrafo_blog`WHERE `id` = ? AND `orden` = ?;");
        $id = mysqli_real_escape_string($mysqli, $_POST['id']);
        $orden = mysqli_real_escape_string($mysqli, $_POST['orden']);
        $consulta->bind_param("ii", $id, $orden);
        $consulta->execute();
    }

?>