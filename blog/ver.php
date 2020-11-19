<?php

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
                    
                    $ctitulo = $mysqli->prepare("SELECT * FROM entrada_blog WHERE id_ent = ?");
                    $ctitulo->bind_param("i",$idConsulta);
                    $ctitulo->execute();
                    $resT = $ctitulo->get_result();
                    $ctitulo->close();

                    while($rowT = $resT->fetch_assoc()){
                        $tittle= $rowT['titulo'];
                    }


                    require("..\activos\header.php");   
                    ?>
                
                    <div class="container" id="entrada">
                        <div class="blog-admin col-12"> <?php
                            while($resFilas = $res->fetch_assoc()){ ?>
                                <div id="pPal">
                                    <img id="img-ppal" src="../admin/publicar/uploads/<?php echo $resFilas['imagen_central']; ?>" alt="" width="100%" height="500px">
                                    <p id="footer"><?php echo str_replace('\r\n', "<br/>", $resFilas['foto_footer']);  ?></p>
                                    <h2 id="titulo_ppal"><?php echo  $resFilas['titulo'];; ?></h2>
                                    <p class="parra-ppal"><?php echo str_replace('\r\n', "<br/>", $resFilas['texto']); ?></p>
                                    
                                </div>
                            <?php
                            } // fin while

                            if(($parrafos->num_rows)>0){
                                while($fParrafos = $parrafos->fetch_assoc()){
                                    ?>

                                    <div class="pSecundario">
                                        
                                        <h3 class="subtitulo"><?php echo $fParrafos['sub_titulo']; ?></h3>
                                        <p class="paraf-secun"><?php echo  str_replace('\r\n', "<br/>", $fParrafos['texto']) ; ?></p>
                                        <?php 
                                if(!($fParrafos['imagen_parrafo']=="nulo")){
                                    ?>
                                    <img class="img-secun" src="../publicar/uploads/<?php echo  $fParrafos['imagen_parrafo']; ?>" alt="" width="100%" height="400px"
                                    <?php
                                }
                                ?>
                                        
                                    </div>

                                    <?php
                                } //fin while
                            }?> 
                        </div>
                    </div>
                <?php //cierre del dif entrada
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