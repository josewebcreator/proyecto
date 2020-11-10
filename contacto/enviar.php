<?php

    if(isset($_POST['direccioncorreo'])&&isset($_POST['datospersonales'])&&isset($_POST['mensaje'])){

        require('../conexion.php');
        $mail = mysqli_real_escape_string($mysqli, $_POST['direccioncorreo']);
        $datos = mysqli_real_escape_string($mysqli, $_POST['datospersonales']);
        $mensaje = mysqli_real_escape_string($mysqli, $_POST['mensaje']);

        $consulta = $mysqli->prepare("INSERT INTO `contacto` (`email`, `identificacion`, `mensaje`) VALUES (?, ?, ?)");

        $consulta->bind_param("sss",$mail, $datos, $mensaje);
        $consulta->execute();
        $consulta->close();
        $mysqli->close();
    }

?>