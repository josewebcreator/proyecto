<?php
    if((isset($_POST['usuario']))&&(isset($_POST['keyword']))){

        require('cone\conexion.php');
        $user = mysqli_real_escape_string($mysqli, $_POST['usuario']);
        $pass = mysqli_real_escape_string($mysqli, $_POST['keyword']);
        
        
        $consulta = $mysqli->prepare("SELECT * FROM `login` WHERE `user` = ?");
        $consulta->bind_param("s",$user);
        $consulta->execute();
        
        $res= $consulta->get_result();
        $consulta->close();
        echo $res->num_rows;
        if(($res->num_rows)>0){
           
            while($check=$res->fetch_assoc()){
                $hash = $check['hash'];
            }
               
            if(password_verify($pass, $hash)){
                echo "ok";
            }
            
            $mysqli->close();
        }else{
            //Error aqui

            $mysqli->close();
        }
    }
?>