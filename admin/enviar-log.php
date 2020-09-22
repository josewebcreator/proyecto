<?php
    if((isset($_POST['usuario']))&&(isset($_POST['keyword']))){

        require('cone\conexion.php');
        $user = mysqli_real_escape_string($mysqli, $_POST['usuario']);
        $pass = mysqli_real_escape_string($mysqli, $_POST['keyword']);
        
        
        $consulta = $mysqli->prepare("SELECT * FROM `login` WHERE `usuario` = ?");
        $consulta->bind_param("s",$user);
        $consulta->execute();
        
        $res= $consulta->get_result();

        $consulta->close();

        if(($res->num_rows)>0){
           
            while($check=$res->fetch_assoc()){

                $hash = $check['hash'];
                if(password_verify($pass, $hash)){
                    session_start();
                    $_SESSION['usuario'] = $check['usuario'];
                    $_SESSION['token'] = $check['token'];
                }

            }
               

            


            $mysqli->close();
        }else{
            
            
            $mysqli->close();
            header("location:../inicio/index.php");
        }
    }else{
        header("location:../inicio/index.php");
    }
?>