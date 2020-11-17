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

            if($tipo=="admin"){
                $consulta = $mysqli->prepare("SELECT * FROM `usuario` WHERE `tipo` != 'admin' AND `activo` = 1");
                $consulta->execute();
                $resUsuarios = $consulta->get_result();
                $consulta->close();

                $consulta = $mysqli->prepare("SELECT * FROM `usuario` WHERE `tipo` != 'admin' AND `activo` = 0");
                $consulta->execute();
                $resInna = $consulta->get_result();
                $consulta->close();

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

                <div class="container" id="cambiar-datos">
                    <div class="col-12">
                        <h2>Cambiar Datos</h2>
                    </div>

                    <div class="col-12 form-cambiardatos">
                        <form action="">
                            <input type="hidden" name="parametro" value="datos">
                            <div class="form-group">
                                    
                                <input type="password" class="form-control" id="vieja" name="vieja" placeholder="Contraseña actual" required>
                            </div>
                            <div class="form-group">
                                    
                                    <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Nombres" required>
                                </div>
                                    <div class="form-group">
                                    <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="apellidos" required>
                                
                                </div>

                                <input type="submit" value="enviar" id="boton-cambiar-datos" class="btn btn-primary mb-2">
                        </form>
                    </div>
                </div> 
                    
                <div class="container" id="inhabilitar">
                    <div class="col-12">
                        <h2>Inhabilitar Usuario</h2>
                    </div>

                    <div class="col-12 form-inhabilitar">
                        <form action="">
                            <input type="hidden" name="parametro" value="inhabilitar">
                            <div class="form-group">
                                    
                                <input type="password" class="form-control" id="vieja" name="vieja" placeholder="Contraseña actual" required>
                            </div>
                            <select class="form-control" name="usuario" id="selecUsuario">
                                <?php
                                $cuenta = $resUsuarios->num_rows;
                                if($cuenta>0){
                                    while($row =  $resUsuarios->fetch_assoc()){
                                    ?>
                                        <option value="<?php echo $row['id_login'] ; ?>"><?php echo $row['nombres'] ; ?> <?php echo $row['apellidos'] ; ?></option>
                                    <?php
                                    }
                                }else{
                                    ?>
                                        <option value="">No existen usuarios habilitados</option>
                                    <?php
                                }
                                
                                ?>
                            </select>
                                <br>
                                <input type="submit" value="enviar" id="boton-inhabilitar" class="btn btn-primary mb-2">
                        </form>
                    </div>
                </div>

                <div class="container" id="habilitar">
                    <div class="col-12">
                        <h2>Habilitar Usuario</h2>
                    </div>

                    <div class="col-12 form-habilitar">
                        <form action="">
                            <input type="hidden" name="parametro" value="habilitar">
                            <div class="form-group">
                                    
                                <input type="password" class="form-control" id="vieja" name="vieja" placeholder="Contraseña actual" required>
                            </div>
                            <select class="form-control" name="usuario" id="selecUsuario">
                                <?php
                                $cuenta = $resInna->num_rows;
                                if($cuenta>0){
                                    while($row =  $resInna->fetch_assoc()){
                                    ?>
                                        <option value="<?php echo $row['id_login'] ; ?>"><?php echo $row['nombres'] ; ?> <?php echo $row['apellidos'] ; ?></option>
                                    <?php
                                    }
                                }else{
                                    ?>
                                        <option value="">No existen usuarios inhabilitados</option>
                                    <?php
                                }
                                
                                ?>
                            </select>
                                <br>
                                <input type="submit" value="enviar" id="boton-habilitar" class="btn btn-primary mb-2">
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
                                <br>
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


