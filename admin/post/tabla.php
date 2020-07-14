<?php

    require('../cone/conexion.php');

    $consulta = $mysqli->query("SELECT * from entrada_blog");
    $cuenta =  $consulta->num_rows;

    
 
    print_r($cuenta);
 

    if ($cuenta>0){
        ?>
        <table>
            <tr>
                <td>Id</td>
                <td>idioma</td>
                <td>Titulo</td>
                <td>Opciones</td>
            </tr>
            <?php
                while ($row = $consulta->fetch_assoc()){
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['lenguaje']; ?></td>
                        <td><?php echo $row['titulo']; ?></td>
                        <td>
                            
                            <div><a href="ver-admin.php?id=<?php echo $row['id']; ?>">Ver</a></div>
                            <div><a href="editar.php?id=<?php echo $row['id']; ?>">Editar</a></div>
                            <div><a href="#" class="btn-borrar" refe="<?php echo $row['id'] ?>">Borrar</a></div>
                            
                        </td>
                    </tr>
                <?php }//fin del while
            ?>
        </table>
        <?php //fin IF
        $consulta->close();
    }else{
        
        echo "No existen publicaciones"; 
        $consulta->close();
    }

    $mysqli->close();
?>