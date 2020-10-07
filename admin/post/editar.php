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
        //require('../activos/header.php');
?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../css/estilos.css">
            <link rel="stylesheet" href="..\css\bootstrap.min.css">
            <script src="js/jquery.js"></script>
            <title><?php echo $tittle;?></title>
        </head>
        <body>
            <header>
                <div class="header-content">
                    <div id="titulo">
                        <h2><?php echo $tittle;?></h2>
                    </div>

                        <nav id="menu">
                            
                        </nav>               
                </div>
            </header>



    <div id="edicion" class="container">
        <?php

        if(isset($_GET['id'])){
            require('../cone/conexion.php');
            $consulta = $mysqli->prepare("SELECT * FROM entrada_blog WHERE id_ent = ?");
            $idConsulta = mysqli_real_escape_string($mysqli, $_GET['id']);


            $consulta->bind_param("i",$idConsulta);
            $consulta->execute();
            $res = $consulta->get_result();
            $consulta->close();
            $contador=0;
            if(($res->num_rows)>0){
                
                $cParrafo = $mysqli->prepare("SELECT * FROM parrafo_blog WHERE id_entrada_blog = ? ORDER BY orden");
                $cParrafo->bind_param("i",$idConsulta);
                $cParrafo->execute();
                $parrafos = $cParrafo->get_result();
                $cParrafo->close();


                ?>
                <ul class="edit-entrada col-8">
                <?php
                while($resFilas = $res->fetch_assoc()){ ?>
                    <li id="edit-pPal" class="hijo<?php echo $contador; ?>">
                        <form class="p-principal">
                            <input type="hidden" name="principal">
                            <input type="hidden" name="id" class="ppal-id" value="<?php echo $resFilas['id_ent']; ?>">
                            <input type="file" name="imagen" accept="image/*" class="ppal-img">
                            <img src="../publicar/uploads/<?php echo $resFilas['imagen_central']; ?>" alt="" width="100%" height="300px">
                            <textarea name="foto-footer" id="" cols="30" rows="5"class="ppal-footer"><?php echo str_replace('\r\n', "\r\n", $resFilas['foto_footer']); ?></textarea><br>
                            <input type="text" name="titulo" class="ppal-ttlo" value="<?php echo $resFilas['titulo']; ?>"><br>
                            <textarea name="texto" id="" cols="30" rows="10" class="ppal-texto"><?php echo str_replace('\r\n', "\r\n", $resFilas['texto'])  ?></textarea><br>
                        </form>
                    </li>
                <?php
                } // fin while

                if(($parrafos->num_rows)>0){
                    while($fParrafos = $parrafos->fetch_assoc()){
                        $contador = $contador + 1
                        ?>

                        <li class="edit-pSecundario hijo<?php echo $contador; ?>">
                            <form>
                                <input type="hidden" name="id" class="parraf-id" value="<?php echo $fParrafos['id']; ?>"><br>
                                <input type="hidden" name="orden" class="parraf-orden" value="<?php echo $fParrafos['orden']; ?>"><br>
                                <input type="text" name="subtitulo" class="parraf-sub" value="<?php echo $fParrafos['sub_titulo']; ?>"><br>
                                <textarea name="texto" id="" cols="30" rows="10" class="parraf-tex"><?php echo str_replace('\r\n', "\r\n", $fParrafos['texto']) ; ?></textarea><br>
                                <input type="file" name="imagen_parrafo" accept="image/*" class="parraf-img"><br>
                                <img src="../publicar/uploads/<?php echo $fParrafos['imagen_parrafo']; ?>" alt="" width="100%" height="300px">
                            </form>
                            <input type="button" value="Borrar" name="borrar" onclick="borrarParrafo(<?php echo $fParrafos['id_entrada_blog']; ?>, <?php echo $fParrafos['orden']; ?>)" class="borrar btn-warning btn-lg">
                            
                        </li>

                        <?php
                    } //fin while
                }

                ?> </ul>
                <input type="button" value="Editar" class="btn btn btn-outline-primary" id="btn-editar"> 
                <br> <h6>Insertar parrafo desdpues de:</h6>
                <select name="" id="insertSelec" class="form-control col-4">
                    <option value="0">Parrafo Principal</option>
                </select> 
                <input type="button" value="agregar" class="agregar-parraf">
                <?php //cierre del dif entrada
            } // fin If

            $mysqli->close();
        }

?>
    
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