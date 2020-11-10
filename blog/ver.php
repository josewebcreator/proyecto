<?php
require("..\activos\header.php");
    if(isset($_GET['id'])){
        require('../conexion.php');
        if(isset($_GET['id'])){
                $consulta = $mysqli->prepare("SELECT * FROM entrada_blog WHERE id_ent = ?");
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
                    $cParrafo->execute();
                    $parrafos = $cParrafo->get_result();
                    $cParrafo->close();

                    ?>
                    <div class="entrada ">
                    <?php
                    ?> <div class="container">
                        <div class="blog-admin col-10"> <?php
                    while($resFilas = $res->fetch_assoc()){ ?>
                        <div id="pPal">
                            <img id="img-ppal" src="../admin/publicar/uploads/<?php echo $resFilas['imagen_central']; ?>" alt="" width="100%" height="300px">
                            <p id="footer"><?php echo str_replace('\r\n', "<br/>", $resFilas['foto_footer']);  ?></p>
                            <h2><?php echo  $resFilas['titulo'];; ?></h2>
                            
                            <p class="parra-ppal"><?php echo str_replace('\r\n', "<br/>", $resFilas['texto']); ?></p>
                        </div>
                    <?php
                    } // fin while

                    if(($parrafos->num_rows)>0){
                        while($fParrafos = $parrafos->fetch_assoc()){
                            ?>

                            <div class="pSecundario">
                                <img class="img-secun" src="../admin/publicar/uploads/<?php echo  $fParrafos['imagen_parrafo']; ?>" alt="" width="100%" height="300px">
                                <h3 class="subtitulo"><?php echo $fParrafos['sub_titulo']; ?></h3>
                                <p class="paraf-secun"><?php echo  str_replace('\r\n', "<br/>", $fParrafos['texto']) ; ?></p>
                                
                                
                            </div>

                            <?php
                        } //fin while
                    }

                    ?> </div>
                    </div>
                </div><?php //cierre del dif entrada
                }else{
                    $mysqli->close();
                    header("location:../inicio/index.php"); 
                } // fin If

                $mysqli->close();
        }else{
            $mysqli->close();
        }
    }else{
        header("location:../inicio/index.php");
    }

?>