<?php
    $tittle = "contacto";
    require('../activos/header.php');

?>

<div class="container" id="contacto">

    <div class="col-12" id="textoform">
        <h2>CONTACTO</h2>
        <p>Para ponerse en contacto con mi persona por favor llenar el siguiente formulario.</p>
    </div>
    
    <div class="col-12" id="cuadro-formulario">

        <form action="">
            <div class="form-group">
                <label for="direccioncorreo">Email</label>
                <input type="email" class="form-control" id="direccioncorreo" name="direccioncorreo" placeholder="name@example.com" required>
            </div>
            <div class="form-group">
                <label for="datospersonales">Nombre y apellido || Organización</label>
                <input type="text" class="form-control" id="datospersonales" name="datospersonales" placeholder="Datos Personales o Institucionales" required>
            </div>
            <div class="form-group">
                <label for="mensaje">Mensaje</label>
                <textarea class="form-control" id="mensaje" name="mensaje" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary mb-2" id="enviar-form">Enviar</button>
        </form>

    </div>

</div>

<script src="../js/jquery.js"></script>
<script src="../js/funciones.js"></script>