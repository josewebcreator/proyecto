<?php
    session_start();
    if(isset($_SESSION["usuario"])){

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

        $mysqli->close();

        if(($user==$checkUser)&&($token==$checktoken)){

            if(isset($_POST["viejo"])&&isset($_POST["nuevo"])&&isset($_POST["id"])){
 
                if($_POST["viejo"]=="provisional"){
                    //hacer insert aqui
                    require("..\cone\conexion.php");
                    $consulta = $mysqli->prepare("INSERT INTO `parrafo_blog` (`orden`, `id_entrada_blog`, `sub_titulo`, `imagen_parrafo`, `texto`) VALUES ( 0, ?, 'Temporal', 'no asignada', 'tmporal');");
                    $nuevo= mysqli_real_escape_string($mysqli, $_POST["nuevo"]);
                    $idEnt= mysqli_real_escape_string($mysqli, $_POST["id"]);
                    $consulta->bind_param("i",  $idEnt);
                    $consulta->execute();
                    $consulta->close();
                    
                    $consulta = $mysqli->prepare("UPDATE `parrafo_blog` SET `orden` = ? WHERE `orden` = 0 AND `id_entrada_blog` = ?");
                    $consulta->bind_param("ii", $nuevo, $idEnt);
                    $consulta->execute();
                    $consulta->close();

                    
                    $consulta = $mysqli->prepare("SELECT * FROM `parrafo_blog` WHERE `id_entrada_blog` = ? ORDER BY `orden`, `tiempo` DESC");
                    $consulta->bind_param("i", $idEnt);
                    $consulta->execute();
                    $res = $consulta->get_result();
                    $consulta->close();
                    $cuenta=1;
                    while($row=$res->fetch_assoc()){
                        $consulta = $mysqli->prepare("UPDATE `parrafo_blog` SET `orden` = ? WHERE `orden` = ? AND `id_entrada_blog` = ? AND `tiempo` = (SELECT MIN(`tiempo`) FROM `parrafo_blog` WHERE `id_entrada_blog` = ? AND `orden` = ?)");
                        $viejo = $row['orden'];
                        $consulta->bind_param("iiiii", $cuenta, $viejo, $idEnt, $idEnt,$viejo);
                        $consulta->execute();
                        $consulta->close();
                        $cuenta = $cuenta +1;
                        echo "cuenta " + $cuenta+ " viejo " + $viejo + " id " + $idEnt;
                    }
                    
                    $mysqli->close();
                
                }

            }

        }else{
        header("location:../../inicio/index.php");  }
}else{
    header("location:../../inicio/index.php");
    }
?>