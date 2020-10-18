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
            require('../cone/conexion.php');

            $consulta = $mysqli->query("SELECT * from entrada_blog WHERE `borrado` = '0'");
            $cuenta =  $consulta->num_rows;
        
            if ($cuenta>0){
                ?>
                <div class="cuadro table-responsive-sm">
                  <table class="table table-dark">
                    <tr>
                        <td scope="col" style="text-align: center;">Id</td>
                        <td scope="col" style="text-align: center;">idioma</td>
                        <td scope="col" style="text-align: center;">Titulo</td>
                        <td scope="col" style="text-align: center;">Opciones</td>
                    </tr>
                    <?php
                        while ($row = $consulta->fetch_assoc()){
                            ?>
                            <tr>
                                <td style="text-align: center;"><?php echo $row['id_ent']; ?></td>
                                <td><?php echo $row['lenguaje']; ?></td>
                                <td><?php echo $row['titulo']; ?></td>
                                <td style="text-align: center;">
                                    
                                    <a href="ver-admin.php?id=<?php echo $row['id_ent']; ?>&titulo=<?php echo $row['titulo'] ?>">Ver</a>
                                    <a href="editar.php?id=<?php echo $row['id_ent']; ?>">Editar</a>
                                    <a href="#" class="btn-borrar" refe="borrar-ent.php?id=<?php echo $row['id_ent'] ?>">Borrar</a>
                                    
                                </td>
                            </tr>
                        <?php }//fin del while
                    ?>
                </table>  
                </div>
                
                <?php //fin IF
                $consulta->close();
            }else{
                
                echo "No existen publicaciones"; 
                $consulta->close();
            }

            $mysqli->close();
        }else{
            header("location:../../inicio/index.php");
        }

    }else{
        header("location:../../inicio/index.php");
    }

   
?>