<?php
    if(isset($_GET['id'])){
        
        require('../cone/conexion.php');
        $consulta = $mysqli->prepare("SELECT * FROM entrada_blog WHERE id = ?");
        $idConsulta = mysqli_real_escape_string($mysqli, $_GET['id']);
        $consulta->bind_param("i",$idConsulta);
        $consulta->execute();
        $res = $consulta->get_result();
        $consulta->close();

        //print_r($res);
        //print_r($res->num_rows);
        
        if(($res->num_rows)>0){
            
            $cParrafo = $mysqli->prepare("SELECT * FROM parrafo_blog WHERE id_entrada_blog = ? ORDER BY orden");
            $cParrafo->bind_param("i",$idConsulta);
            $parrafos = $cParrafo->get_result();
            
            ?>
            <div class="entrada">
            <?php
            while($resFilas = $res->fetch_assoc()){ ?>
                <div id="pPal">
                    <h2><?php echo $resFilas['titulo']; ?></h2><br>
                    <p><?php echo $resFilas['titulo']; ?></p><!-- cambiar a imagen -->
                </div>
            <?php
            } // fin while
            ?> </div> <?php //cierre del dif entrada
        }

        $mysqli->close();
    }
?>