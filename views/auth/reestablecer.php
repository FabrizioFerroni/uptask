<div class="contenedor reestablecer">
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Coloca tu nueva contraseña</p>
    <?php include_once __DIR__ . '/../templates/alertas.php'; 
        if($mostrar){
    ?>

        <form method="post" class="formulario">
        <div class="campo">
                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" placeholder="Ingrese su contraseña" autocomplete="off" required>
            </div>
            <div class="campo">
                <label for="password2">Repetir Contraseña</label>
                <input type="password" name="password2" id="password2" placeholder="Repeti tu contraseña" autocomplete="off" required>
            </div>
            <input type="submit" value="Cambiar clave" class="boton">
        </form>
<?php } ?>
       
    </div>
</div>

<?php 
    $script ="<script src='/build/js/error.js'></script>";
?>