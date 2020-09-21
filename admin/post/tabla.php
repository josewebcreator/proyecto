<?php


    session_start();
    if(!($_SESSION["usuario"]==null)||!($_SESSION["usuario"]=="")){

        require("cone\conexion.php");
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

            $consulta = $mysqli->query("SELECT * from entrada_blog");
            $cuenta =  $consulta->num_rows;

            
        
            print_r($cuenta);
        

            if ($cuenta>0){
                ?>
                <table>
                    <tr>
                        <td>Id</td>
                        <td>idioma</td>
                        <td>Titulo</td>
                        <td>Opciones</td>
                    </tr>
                    <?php
                        while ($row = $consulta->fetch_assoc()){
                            ?>
                            <tr>
                                <td><?php echo $row['id_ent']; ?></td>
                                <td><?php echo $row['lenguaje']; ?></td>
                                <td><?php echo $row['titulo']; ?></td>
                                <td>
                                    
                                    <a href="ver-admin.php?id=<?php echo $row['id']; ?>">Ver</a>
                                    <a href="editar.php?id=<?php echo $row['id']; ?>">Editar</a>
                                    <a href="#" class="btn-borrar" refe="<?php echo $row['id'] ?>">Borrar</a>
                                    
                                </td>
                            </tr>
                        <?php }//fin del while
                    ?>
                </table>
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