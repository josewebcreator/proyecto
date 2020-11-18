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
            $tittle= "blogs";
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
            $total=$res->num_rows;
            $consulta->close();
            
            $consulta = $mysqli->prepare("SELECT * FROM `entrada_blog` WHERE `id_login` = ? AND `aprob` = '0' AND `borrado` = '0'");
            $consulta->bind_param("i",$id_log);
            $consulta->execute();
            $cuenta = $consulta->get_result();
            $proceso = $cuenta->num_rows;
            $consulta->close();

            $consulta = $mysqli->prepare("SELECT * FROM `entrada_blog` WHERE `id_login` = ? AND `aprob` = 1 AND `borrado` = 0");
            $consulta->bind_param("i",$id_log);
            $consulta->execute();
            $cuenta = $consulta->get_result();
            $aprobadas = $cuenta->num_rows;
            $consulta->close();
            $mysqli->close();
            ?>

                
            <!--<div id="carga-tabla"></div>-->

        
            <div id="menu-admin" class="container">
                <div class="row">

                    <div class="col-12 col-xl-8 col-lg-8 col-md-12 ppal-admin datos-user">
                        <div class="row user">

                            
                            <?php
                            while($row = $res->fetch_assoc()){      
                                $tipo= $row['tipo'];  
                                ?>
                                    <div id="nombre-user" class="col-12"><h3>Bienvenido <?php echo $row['nombres'] ?> <?php echo $row['apellidos'] ?></h3></div>
                                    
                                    <div class="tipo-user col-12">
                                    <h4>Usuario tipo: <?php echo $row['tipo'] ?></h4>   
                                    </div>

                                    <div class="col-12 estadisticas">
                                        <h4>Entradas Creadas: <?php echo $total; ?></h4>
                                        <h4>Entradas En proceso: <?php echo $proceso; ?></h4>
                                        <h4>Entradas Aprobadas: <?php echo $aprobadas; ?></h4>
                                    </div>
                                    
                                    <div class="col-12 opciones">
                                        <h3>Opciones</h3>
                                        <h4><a href="seguridad.php">Seguridad</a></h4>
                                        <h4><a href="cerrarsesion.php?destroy=0">Cerrar Sesion</a></h4>
                                        
                                    </div>
                                <?php
                            }
                                
                            ?>    
                            

                        </div>


                    </div>
                    
                    <div class="col-12 col-xl-4 col-lg-4 col-md-12 ppal-admin">
                        
                        <div class="menu-elem col-12 ">
                            <div class="link-background">
                                <a href="nuevouser.php" class="link-menu" title="crear usuario"><i class="fas fa-plus"></i></a>
                            </div>                    
                        </div>  
                        <div class="menu-elem col-12">
                            <div class="link-background">
                                <a href="aprob.php" class="link-menu" title="aprobar publicaciones"><i class="fas fa-check"></i></a>
                            </div>                    
                        </div>  
                        <div class="menu-elem col-12">
                            <div class="link-background">
                                <a href="tabla.php" class="link-menu" title="lista de entradas"><i class="fas fa-clipboard-list"></i></a>
                            </div>                    
                        </div>           
                        
                    </div>

                    <div class="menu-elem col-12 col-xl-4 col-lg-4 col-md-12">
                        <div class="link-background">
                            <a href="../publicar/index.php" class="link-menu" title="Crear entrada"><i class="fas fa-pen-alt"></i></a>
                        </div>                    
                    </div>                    
                                        
                    
                    <div class="menu-elem col-12 col-xl-4 col-lg-4 col-md-12">
                        <div class="link-background">
                            <a href="bandeja.php" class="link-menu" title="Bandeja"><i class="fas fa-envelope"></i></a>
                        </div>                    
                    </div>                    
                                         
                    
                    <div class="menu-elem col-12 col-xl-4 col-lg-4 col-md-12">
                        <div class="link-background">
                            <a href="papelera.php" class="link-menu" title="papelera"><i class="fas fa-trash-alt"></i></a>
                        </div>                    
                    </div>                    
                                          
                    
                </div>
            </div>

            <script src="js\jquery.js"></script>
            <script src="js\funciones.js"></script>
            <script src="js\all.min.js"></script>
            
        <?php  


        }else{
            header("location:../../inicio/index.php");
        }  
    }else{
        header("location:../../inicio/index.php");
    }
?>