<?php
    
    session_start();
    if(!($_SESSION["usuario"]==null)||!($_SESSION["usuario"]=="")){

        require("..\cone\conexion.php");
        $consulta = $mysqli->prepare("SELECT * FROM `login` WHERE `usuario` = ?");
        $user = mysqli_real_escape_string($mysqli, $_SESSION["usuario"]);
        $token = mysqli_real_escape_string($mysqli, $_SESSION["token"]);
        $consulta->bind_param("s",$user);
        $consulta->execute();
        $res = $consulta->get_result();
        $consulta->close();

        while($check = $res->fetch_assoc()){

            $checkUser = $check['usuario'];
            $checktoken = $check['token'];

        }



        if(($user==$checkUser)&&($token==$checktoken)){
            
            $consulta = $mysqli->prepare("SELECT * FROM `login` WHERE `usuario` = ?");
            $nick = mysqli_real_escape_string($mysqli, $_POST['nick']);
            $consulta->bind_param("s", $nick);
            $consulta->execute();
            $res = $consulta->get_result();
            $row = $res->num_rows;

                if($row==0){
                    echo 0; 
                }else if($row>0){
                    echo 1; 
                }
                    
            
            $consulta->close();
            $mysqli->close();
        }else{
            header("location:../../inicio/index.php");
        }  
    }else{
        header("location:../../inicio/index.php");
    }

?>

