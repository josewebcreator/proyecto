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
            ?>

                
        <div id="carga-tabla"></div>

        <div id="menu-admin" class="container">
            <div class="row">
                <div class="menu-elem col-4">
                    <div class="link-background">
                        <a href="" class="link-menu"><i class="fas fa-pen-alt"></i></a>
                    </div>                    
                </div>
                <div class="menu-elem col-4">
                    <div class="link-background">
                        <a href="" class="link-menu"><i class="fas fa-envelope"></i></a>
                    </div>                    
                </div>
                <div class="menu-elem col-4">
                    <div class="link-background">
                        <a href="" class="link-menu"><i class="fas fa-trash-alt"></i></a>
                    </div>                    
                </div>
            </div>
        </div>

        <script src="js\jquery.js"></script>
        <script src="js\funciones.js"></script>
        <script src="js\all.min.js"></script>
    </body>
</html>
<?php  

        }else{
            header("location:../../inicio/index.php");
        }  
    }else{
        header("location:../../inicio/index.php");
    } ?>