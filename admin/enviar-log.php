<?php
    if((isset($_POST['usuario']))&&(isset($_POST['keyword']))){

        require('cone\conexion.php');
        $user = mysqli_real_escape_string($mysqli, $_POST['usuario']);
        $pass = mysqli_real_escape_string($mysqli, $_POST['keyword']);
        $hash = password_hash($pass, PASSWORD_DEFAULT);

        $consulta = $mysqli->prepare("SELECT * FROM login WHERE 'user' = ? and 'hash' = ?;");
        $consulta->bind_param("ss", $user, $hash);
        $consulta->execute();

    }
?>