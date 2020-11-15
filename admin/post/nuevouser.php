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
                ?>
                <div id="crear" class="user-container container">
                    <div class="row">
                        <div class="col-12">
                            <h2>Crear nuevo usuario</h2>
                        </div>
                        <div class="col-12" id="new-user-form">
                            <form action="">
                                <div class="form-group">
                                    <label for="direccioncorreo">Email</label>
                                    <input type="email" class="form-control" id="direccioncorreo" name="direccioncorreo" placeholder="name@example.com" required>
                                </div>
                                <div class="form-group">
                                    <label for="nombres">Nombres</label>
                                    <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Nombres" required>
                                </div>
                                <div class="form-group">
                                    <label for="apellidos">Apellidos</label>
                                    <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos" required>
                                </div>
                                <div class="form-group">
                                    <label for="nick">Nick Name</label>
                                    <input type="text" class="form-control" id="nick" name="nick" placeholder="Nick Name" required>
                                </div>
                                <div class="form-group">
                                    <label for="clave">Contraseña</label>
                                    <input type="password" class="form-control" id="clave" name="clave" placeholder="Contraseña" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" id="reclave" name="reclave" placeholder="Repita Contraseña" required>
                                </div>
                                <select class="form-control" name="tipo" id="selec-tipo">
                                <option>admin</option>
                                <option>basico</option>
                                </select>
                                <br>
                                <input type="submit" value="enviar" id="boton-crear-user" class="btn btn-primary mb-2">
                            </form>
                        </div>
                    </div>
                </div>

                <?php   
            }else{
                ?>
                
                    <h1>Solo los administradores tienen acceso a esta transaccion</h1>
                <?php
            }

            ?>
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