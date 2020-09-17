<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/jquery.js"></script>
    <script>
        function borrarParrafo(ide, ord){
            console.log(ide, ord)
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
    <title>Document</title>
</head>
<body>

    <div id="edicion">
        <?php

        if(isset($_GET['id'])){
            require('../cone/conexion.php');
            $consulta = $mysqli->prepare("SELECT * FROM entrada_blog WHERE id_ent = ?");
            $idConsulta = mysqli_real_escape_string($mysqli, $_GET['id']);
            print_r($idConsulta);
            echo "8<br>" .$mysqli->error;
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
                print_r($parrafos);
                echo "23<br>" .$mysqli->error;
                ?>
                <ul class="edit-entrada">
                <?php
                while($resFilas = $res->fetch_assoc()){ ?>
                    <li id="edit-pPal">
                        <form class="p-principal">
                            <input type="hidden" name="principal">
                            <input type="hidden" name="id" class="ppal-id" value="<?php echo $resFilas['id_ent']; ?>">
                            titulo principal <br>
                            <input type="text" name="titulo" class="ppal-ttlo" value="<?php echo $resFilas['titulo']; ?>"><br>
                            <input type="file" name="imagen" accept="image/*" class="ppal-img">
                            <p><?php echo $resFilas['imagen_central']; ?></p><!-- cambiar a imagen -->
                            <textarea name="texto" id="" cols="30" rows="10" class="ppal-texto"><?php echo $resFilas['texto']; ?></textarea><br>
                            <textarea name="foto-footer" id="" cols="30" rows="10"class="ppal-footer"><?php echo $resFilas['foto_footer']; ?></textarea><br>
                            
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

<script src="js/funciones.js"></script>

</body>
</html>
