<?php

$tittle= "Inicio";
require("..\activos\header.php");

?>

<?php

    require('../conexion.php');
    $consulta = $mysqli->query("SELECT * from entrada_blog WHERE `borrado` = '0' ORDER BY `id_ent` DESC");
    $cuenta = $consulta->num_rows;

    if($cuenta>0){
        $count=0;
        ?>
        <div class="container" id="entradas">
        <?php
        while($row = $consulta->fetch_assoc()){
            if($count<2){
                if($count===0){
                    ?>
                    <div class="col-12 row" id="principales">
                    
                    
                    <div class="col-6 ultimas">
                        <a href="ver.php?id=<?php echo $row['id_ent']; ?>">
                            <img src="../admin/publicar/uploads/<?php echo $row['imagen_central'];?>" alt=""width="100%" height="200px">
                            <h3><?php echo $row['titulo']; ?></h3>
                        </a>
                    </div>
                    
                    <?php
                }elseif($count===1){
                    ?>
                    
                        
                        <div class="col-6 ultimas">
                            <a href="ver.php?id=<?php echo $row['id_ent']; ?>">
                                <img src="../admin/publicar/uploads/<?php echo $row['imagen_central']; ?>" alt=""width="100%" height="200px">
                                <h3><?php echo $row['titulo']; ?></h3>
                            </a> 
                        </div>      
                                
                    </div>
                    <?php
                }
                $count+=1;
            }else{
                if($count==2){
                    ?>
                    <div class="col-12 row" id="secundarias">
                    <?php
                }
                ?>
                    
                
                <div class="col-4 antiguas">
                    <a href="ver.php?id=<?php echo $row['id_ent']; ?>">
                        <img src="../admin/publicar/uploads/<?php echo $row['imagen_central']; ?>" alt=""width="100%" height="200px">
                        <h4><?php echo $row['titulo']; ?></h4>
                    </a>
                </div>
                <?php
                if($count==$cuenta){
                    ?></div><?php //cierre del row secundarias
                }
                $count+=1;
            }
                
        }
            ?>
            
        </div>
            
        <?php
       
        
    }else{
        echo "<h2>Deben existir columnas de blog creadas para mostrar esta parte</h2>";
    }


?>