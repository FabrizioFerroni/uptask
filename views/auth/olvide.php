<div class="contenedor olvide">
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Recupera tu acceso a UpTask</p>
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

        <form action="/olvide-clave" method="post" class="formulario" novalidate>
            <div class="campo">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Ingrese su correo electrónico" autocomplete="off" required focus >
            </div>
            <input type="submit" value="Recuperar clave" class="boton">
        </form>

        <div class="acciones">
        <span>¿Ya te acordaste la contraseña? <a href="/">Inicia Sesion</a></span>
        </div>
    </div>
</div>


<?php 
    $script ="<script src='/build/js/error.js'></script>";
?>