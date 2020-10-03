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

            if(isset($_POST["viejo"])&&isset($_POST["nuevo"])&&isset($_POST["idEnt"])){
 
                if($_POST["viejo"]=="provisional"){
                    //hacer insert aqui

                }else{
                    //actualizacion del orden
                    require("..\cone\conexion.php");
                    $consulta = $mysqli->prepare("UPDATE `parrafo_blog` SET `orden` = ? WHERE `orden` = ? AND `id_entrada_blog` = ?");
                    $nuevo= mysqli_real_escape_string($mysqli, $_POST["nuevo"]);
                    $viejo= mysqli_real_escape_string($mysqli, $_POST["viejo"]);
                    $idEnt= mysqli_real_escape_string($mysqli, $_POST["idEnt"]);

                    $consulta->bind_param("iii", $nuevo, $viejo, $idEnt);
                    $consulta->execute();
                    $consulta->close();
                    $mysqli->close();
                }

            }

        }else{
        header("location:../../inicio/index.php");  }
}else{
    header("location:../../inicio/index.php");
    }
?>