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
            $total=$res->num_rows;
            $consulta->close();

            while($row = $res->fetch_assoc()){
                $tipo = $row['tipo'];
            }

            if($tipo=="admin"){
                $tittle = "Papelera";
            }
            ?>

        
            <?php
            
            require('../cone/conexion.php');
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
            $total=$res->num_rows;
            $consulta->close();

            while($row = $res->fetch_assoc()){
                $tipo = $row['tipo'];
            }

            if($tipo=="admin"){
                require("../activos/header.php");
                $consulta = $mysqli->query("SELECT * from entrada_blog WHERE `borrado` = '1'");
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
                                            
                                            <a href="#" refe="<?php echo $row['id_ent']; ?>" onclick="restaura(<?php echo $row['id_ent']; ?>)">Restaurar</a>
                                            <a href="#" class="btn-borrar" refe="<?php echo $row['id_ent']; ?>" onclick="borrar_final(<?php echo $row['id_ent']; ?>)">Borrar</a>
                                            
                                        </td>
                                    </tr>
                                <?php }//fin del while
                            ?>
                        </table>  
                        </div>
                    
                    <?php //fin IF
                    $consulta->close();
                    require("footer.php");
                }else{
                    
                    echo "No existen publicaciones"; 
                    require("footer.php");
                    $consulta->close();
                }
            }else{
                header("location:index.php");
            }
            

            $mysqli->close();

        }

    ?>
    
    </div>
    <script>
        function borrar_final(ide){

            $.post("borrado-real.php",
                {
                id : ide
                },
                function (){
                    location.reload()
                }
            )

        }

        function restaura(ide){

            $.post("restaurar.php",
                {
                id : ide
                },
                function (){
                    console.log(ide)
                    location.reload()
                }
            )

        }

    </script>
    <script src="js/funciones.js"></script>
    <script src="js\all.min.js"></script>
    </body>
    </html>

    <?php  
    
    }else{
    header("location:../../inicio/index.php");
    } ?>