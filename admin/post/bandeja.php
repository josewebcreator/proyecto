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
                require("../activos/header.php");
                $consulta = $mysqli->query("SELECT * from contacto WHERE `borrado` = '0'");
                $cuenta =  $consulta->num_rows;

                if ($cuenta>0){

                    ?>
                    <div class="cuadro table-responsive-sm">
                    <table class="table table-dark">
                        <tr>
                            <td scope="col" style="text-align: center;">Id</td>
                            <td scope="col" style="text-align: center;">Visto</td>
                            <td scope="col" style="text-align: center;">Email</td>
                            <td scope="col" style="text-align: center;">Nombre</td>
                            <td scope="col" style="text-align: center;">Opciones</td>
                        </tr>
                        <?php
                            while ($row = $consulta->fetch_assoc()){
                                ?>
                                <tr>
                                    <td style="text-align: center;"><?php echo $row['id']; ?></td>
                                    <td><?php 
                                        if($row['visto']==0){

                                            ?><i class="fas fa-envelope"></i><?php
                                        }else{
                                            ?><i class="fas fa-envelope-open-text"></i><?php
                                        }
                                    ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['identificacion']; ?></td>
                                    <td style="text-align: center;">
                                        
                                        <a href="#">ver</a>
                                        <a href="#" class="btn-borrar" refe="<?php echo $row['id']; ?>" onclick="borrar_ent(<?php echo $row['id']; ?>)">Borrar</a>
                                        
                                    </td>
                                </tr>
                            <?php }//fin del while
                        ?>
                    </table>  

                    </div>
                    
                    <?php //fin IF
                    require("footer.php");
                    ?>
                    <script src="..\post\js\all.min.js"></script>
                    <script src="js\jquery.js"></script>
                    <script src="js\funciones.js"></script>
                    <?php
                    $consulta->close();
                }else{
                    echo "No existen mensajes"; 
                    $consulta->close();
                }

            }else{
                //header("location:index.php");
            }

        }else{
            header("location:../../inicio/index.php");
        }  
    }else{
        header("location:../../inicio/index.php");
    }

?>