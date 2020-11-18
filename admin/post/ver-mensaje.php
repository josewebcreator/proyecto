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

        $mysqli->close();

        if(($user==$checkUser)&&($token==$checktoken)){
            require("../activos/header.php");
            require("..\cone\conexion.php");
            $consulta = $mysqli->prepare("SELECT id FROM `login` WHERE `usuario` = ?");
            $consulta->bind_param("s",$user);
            $consulta->execute();
            $res = $consulta->get_result();
                while($row = $res->fetch_assoc()){
                    $id_log = $row['id'];
                }
            $consulta->close();

            $consulta = $mysqli->prepare("SELECT * FROM `usuario` WHERE `id_login` = ?");
            $consulta->bind_param("i",$id_log);
            $consulta->execute();
            $res = $consulta->get_result();
            $consulta->close();

            while($row = $res->fetch_assoc()){
                $tipo = $row['tipo'];
            }

            if($tipo=="admin"){
                $consulta = $mysqli->prepare("SELECT * from contacto WHERE `borrado` = '0' AND `id` = ?");
                $id = mysqli_real_escape_string($mysqli, $_GET['id']);
                $consulta->bind_param("i", $id);
                $consulta->execute();
                $res=$consulta->get_result();
                $consulta->close();

                $consulta = $mysqli->prepare("UPDATE `contacto` SET `visto` = '1' WHERE `id` = ?");
                $consulta->bind_param("i", $id);
                $consulta->execute();
                $consulta->close();
                ?>
                
                    <div class="container" id="mensaje">
                        <div class="row">
                            <?php
                            while($row=$res->fetch_assoc()){
                                ?>
                                <div class="col-1"></div>
                                <div class="col-10" id="identificacion">
                                    <h2>Nombre:<?php echo $row['identificacion']; ?></h2>
                                </div>
                                <div class="col-1"></div>
                                <div class="col-1"></div>
                                <div class="col-10" id="email">
                                    <h3>Email: <?php echo $row['email']; ?></h3>
                                </div>
                                <div class="col-1"></div>
                                <div class="col-1"></div>
                                <div class="col-10" id="mensajeTexto">
                                    <p><?php echo  str_replace('\r\n', "<br/>", $row['mensaje']) ?></p>
                                </div>
                                <div class="col-1"></div>

                                <?php
                            }
                            ?>
                        </div>
                    </div>

                <?php
                require("footer.php");  
                $mysqli->close();
                ?>
                    <script src="..\post\js\all.min.js"></script>
                    <script src="js\jquery.js"></script>
                    <script src="js\funciones.js"></script>
                <?php
            }else{
                header("location:index.php");
            }

        }else{
            header("location:../../inicio/index.php");
        }  
    }else{
        header("location:../../inicio/index.php");
    }

?>