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
            if(isset($_GET['id'])){
                
                require('../cone/conexion.php');
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
                    $tittle = $_GET['titulo'];
                    require('../activos/header.php');
                    ?> <div class="container">
                        <div class="blog-admin col-8"> <?php
                    while($resFilas = $res->fetch_assoc()){ ?>
                        <div id="pPal">
                            <img id="img-ppal" src="../publicar/uploads/<?php echo $resFilas['imagen_central']; ?>" alt="" width="100%" height="300px">
                            <p id="footer"><?php echo str_replace('\r\n', "<br/>", $resFilas['foto_footer']);  ?></p>
                            <p class="parra-ppal"><?php echo str_replace('\r\n', "<br/>", $resFilas['texto']); ?></p>
                        </div>
                    <?php
                    } // fin while

                    if(($parrafos->num_rows)>0){
                        while($fParrafos = $parrafos->fetch_assoc()){
                            ?>

                            <div class="pSecundario">
                                <img class="img-secun" src="../publicar/uploads/<?php echo  $fParrafos['imagen_parrafo']; ?>" alt="" width="100%" height="300px">
                                <h3 class="subtitulo"><?php echo $fParrafos['sub_titulo']; ?></h3>
                                <p class="paraf-secun"><?php echo  str_replace('\r\n', "<br/>", $fParrafos['texto']) ; ?></p>
                                
                                
                            </div>

                            <?php
                        } //fin while
                    }

                    ?> </div>
                    </div>
                </div><?php //cierre del dif entrada
                } // fin If
                require("footer.php");
                $mysqli->close();
            }
        }else{
            header("location:../../inicio/index.php");
        }
    }else{ 
        header("location:../../inicio/index.php");
    }
?>
<script src="js\all.min.js"></script>