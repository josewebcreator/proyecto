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
            $tittle= "Crear User";
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
            echo password_hash(123456, PASSWORD_DEFAULT);
            if($tipo=="admin"){
                ?>
                   <div class="container" id="cambiodeclave">
                    <div class="col-12">
                        <h2>Cambiar Contraseña</h2>
                    </div>

                    <div class="col-12 form-cambiarclave">
                        <form action="">
                            <input type="hidden" name="parametro" value="clave">
                            <div class="form-group">
                                    
                                <input type="password" class="form-control" id="vieja" name="vieja" placeholder="Contraseña actual" required>
                            </div>
                            <div class="form-group">
                                    
                                    <input type="password" class="form-control" id="clave" name="clave" placeholder="Contraseña" required>
                                </div>
                                    <div class="form-group">
                                    <input type="password" class="form-control" id="reclave" name="reclave" placeholder="Repita Contraseña" required>
                                
                                </div>

                                <input type="submit" value="enviar" id="boton-cambiar-clave" class="btn btn-primary mb-2">
                        </form>
                    </div>
                </div> 
                    
                
                <?php
                require("footer.php");
                ?>
                    <script src="..\post\js\all.min.js"></script>
                    <script src="js\jquery.js"></script>
                    <script src="js\funciones.js"></script>
                <?php
            }else{
                ?>
                   <div class="container" id="cambiodeclave">
                    <div class="col-12">
                        <h2>Cambiar Contraseña</h2>
                    </div>

                    <div class="col-12 form-cambiarclave">
                        <form action="">
                            <input type="hidden" name="parametro" value="clave">
                            <div class="form-group">
                                    
                                <input type="password" class="form-control" id="vieja" name="vieja" placeholder="Contraseña actual" required>
                            </div>
                            <div class="form-group">
                                    
                                <input type="password" class="form-control" id="clave" name="clave" placeholder="Contraseña" required>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="reclave" name="reclave" placeholder="Repita Contraseña" required>
                                
                            </div>

                                <input type="submit" value="enviar" id="boton-cambiar-clave" class="btn btn-primary mb-2">
                        </form>
                    </div>
                </div> 
                    
                
                <?php
                require("footer.php");
                ?>
                    <script src="..\post\js\all.min.js"></script>
                    <script src="js\jquery.js"></script>
                    <script src="js\funciones.js"></script>
                <?php
            }
        }else{
            header("location:../../inicio/index.php");
        }  
    }else{
        header("location:../../inicio/index.php");
    }
?>


