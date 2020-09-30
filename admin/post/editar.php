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
        $tittle="Editar";
        require('../activos/header.php');
?>



    <div id="edicion">
        <?php

        if(isset($_GET['id'])){
            require('../cone/conexion.php');
            $consulta = $mysqli->prepare("SELECT * FROM entrada_blog WHERE id_ent = ?");
            $idConsulta = mysqli_real_escape_string($mysqli, $_GET['id']);


            $consulta->bind_param("i",$idConsulta);
            $consulta->execute();
            $res = $consulta->get_result();
            $consulta->close();

            if(($res->num_rows)>0){
                
                $cParrafo = $mysqli->prepare("SELECT * FROM parrafo_blog WHERE id_entrada_blog = ? ORDER BY orden");
                $cParrafo->bind_param("i",$idConsulta);
                $cParrafo->execute();
                $parrafos = $cParrafo->get_result();
                $cParrafo->close();


                ?>
                <ul class="edit-entrada">
                <?php
                while($resFilas = $res->fetch_assoc()){ ?>
                    <li id="edit-pPal">
                        <form class="p-principal">
                            <input type="hidden" name="principal">
                            <input type="hidden" name="id" class="ppal-id" value="<?php echo $resFilas['id_ent']; ?>">
                            <input type="file" name="imagen" accept="image/*" class="ppal-img">
                            <img src="../publicar/uploads/<?php echo $resFilas['imagen_central']; ?>" alt="" width="100%" height="300px">
                            <textarea name="foto-footer" id="" cols="30" rows="10"class="ppal-footer"><?php echo $resFilas['foto_footer']; ?></textarea><br>
                            <input type="text" name="titulo" class="ppal-ttlo" value="<?php echo $resFilas['titulo']; ?>"><br>
                            <textarea name="texto" id="" cols="30" rows="10" class="ppal-texto"><?php echo $resFilas['texto']; ?></textarea><br>
                        </form>
                    </li>
                <?php
                } // fin while

                if(($parrafos->num_rows)>0){
                    while($fParrafos = $parrafos->fetch_assoc()){
                        ?>

                        <li class="edit-pSecundario">
                            <form>
                                <input type="hidden" name="id" class="parraf-id" value="<?php echo $fParrafos['id']; ?>"><br>
                                <input type="hidden" name="orden" class="parraf-orden" value="<?php echo $fParrafos['orden']; ?>"><br>
                                <input type="text" name="subtitulo" class="parraf-sub" value="<?php echo $fParrafos['sub_titulo']; ?>"><br>
                                <input type="file" name="imagen_parrafo" accept="image/*" class="parraf-img"><br>
                                <p><?php echo $resFilas['imagen_parrafo']; ?></p><br>
                                <textarea name="texto" id="" cols="30" rows="10" class="parraf-tex"><?php echo $fParrafos['texto']; ?></textarea><br>
                                
                            </form>
                            <input type="button" value="" name="borrar" onclick="borrarParrafo(<?php echo $fParrafos['id']; ?>, <?php echo $fParrafos['orden']; ?>)" class="borrar">
                        </li>

                        <?php
                    } //fin while
                }

                ?> </ul> <?php //cierre del dif entrada
            } // fin If

            $mysqli->close();
        }

?>
    <input type="button" value="" id="btn-editar">
    </div>
    <script>
        function borrarParrafo(ide, ord){
            $.post("borrar-parrafo.php",
                {
                id : ide,
                orden: ord
                },
                function (){
                    location.reload()
                }
            )

        }
    </script>
<script src="js/funciones.js"></script>

</body>
</html>

<?php  
    }else{
        header("location:../../inicio/index.php");  }
}else{
    header("location:../../inicio/index.php");
    } ?>