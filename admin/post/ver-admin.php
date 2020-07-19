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

        //print_r($res);
        //print_r($res->num_rows);
        
        if(($res->num_rows)>0){
            
            $cParrafo = $mysqli->prepare("SELECT * FROM parrafo_blog WHERE id_entrada_blog = ? ORDER BY orden");
            $cParrafo->bind_param("i",$idConsulta);
            $cParrafo->execute();
            $parrafos = $cParrafo->get_result();
            $cParrafo->close();
            print_r($parrafos);
            echo "23<br>" .$mysqli->error;
            ?>
            <div class="entrada">
            <?php
            while($resFilas = $res->fetch_assoc()){ ?>
                <div id="pPal">
                    <h2><?php echo $resFilas['titulo']; ?></h2><br>
                    <p><?php echo $resFilas['imagen_central']; ?></p><!-- cambiar a imagen -->
                    <p><?php echo $resFilas['foto_footer']; ?></p>
                    <p><?php echo $resFilas['texto']; ?></p>
                </div>
            <?php
            } // fin while

            if(($parrafos->num_rows)>0){
                while($fParrafos = $parrafos->fetch_assoc()){
                    ?>

                    <div class="pSecundario">
                        <h3><?php echo $fParrafos['sub_titulo']; ?></h3>
                        <p><?php echo $fParrafos['imagen_parrafo']; ?></p>
                        <p><?php echo $fParrafos['texto']; ?></p>
                    </div>

                    <?php
                } //fin while
            }

            ?> </div> <?php //cierre del dif entrada
        } // fin If

        $mysqli->close();
    }
?>