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
                    <form>
                        titulo principal <br>
                        <input type="text" name="titulo" value="<?php echo $resFilas['titulo']; ?>">
                        <input type="file" name="imagen">
                        <p><?php echo $resFilas['imagen_central']; ?></p><!-- cambiar a imagen -->
                        <textarea name="foto-footer" id="" cols="30" rows="10" value="<?php echo $resFilas['foto_footer']; ?>"></textarea>
                    </form>
                    <h2></h2><br>
                   
                    <p></p>
                    <p><?php echo $resFilas['texto']; ?></p>
                </li>
            <?php
            } // fin while

            if(($parrafos->num_rows)>0){
                while($fParrafos = $parrafos->fetch_assoc()){
                    ?>

                    <li class="edit-pSecundario">
                        <h3><?php echo $fParrafos['sub_titulo']; ?></h3>
                        <p><?php echo $fParrafos['imagen_parrafo']; ?></p>
                        <p><?php echo $fParrafos['texto']; ?></p>
                    </li>

                    <?php
                } //fin while
            }

            ?> </ul> <?php //cierre del dif entrada
        } // fin If

        $mysqli->close();
    }

?>