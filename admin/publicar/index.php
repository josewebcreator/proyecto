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
        $tittle="Crear Entrada";
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        $token = substr(str_shuffle($permitted_chars), 0, 6);
        require("../activos/header.php");?>

    <div class="container">
    <ul id="crea-blog">
        <li>
            <form action="" class="p-principal">
                <input type="hidden" name="token" id="token" value="<?php echo $token; ?>">
                <input type="text" name="titulo_entrada" placeholder="Título" id="titulo_entrada" ><br>

                <textarea name="parrafo" id="texto_parrafo" cols="30" rows="10" placeholder="Texto del parrafo"></textarea>

                imagen de cabecera <br>
                <input type="file" name="imagen_cabecera" id="imagen_cabecera" class="form-control-file" accept="image/*">

                
                <textarea name="foto-footer" placeholder="Footer de la foto" id="foto-footer" cols="30" rows="10"></textarea>
            </form>
        </li>
    </ul>
    <br>
    haga clic para incrustar otro parrafo
    <input type="button" value="incrustar" name="incrustar" id="btn-incrustar">
    <input type="button" value="enviar" name="enviar" id="btn-enviar">
    </div>
    <br>
    <br>
    <br>
    <br>
    <?php require("../post/footer.php"); ?>
    <script src="..\post\js\all.min.js"></script>
    <script src="js\jquery.js"></script>
    <script src="js\funciones.js"></script>
</body>

</html>

<?php }else{
            header("location:../../inicio/index.php");
        }
    }else{ 
        header("location:../../inicio/index.php");
    }
?>