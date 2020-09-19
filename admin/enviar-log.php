<?php
    if((isset($_POST['usuario']))&&(isset($_POST['keyword']))){

        require('cone\conexion.php');
        $user = mysqli_real_escape_string($mysqli, $_POST['usuario']);
        $pass = mysqli_real_escape_string($mysqli, $_POST['keyword']);
        $hash = password_hash($pass, PASSWORD_DEFAULT);

        $consulta = $mysqli->prepare("SELECT * FROM login WHERE 'user' = ?");
        $consulta->bind_param("s", $user);
        $consulta->execute();
        $res= $consulta->get_result();
        $consulta->close();

        if(($res->num_rows)>0){
            //iniciar secion aqui
            
            $mysqli->close();
        }else{
            //Error aqui

            $mysqli->close();
        }
    }
?>