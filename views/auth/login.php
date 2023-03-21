<div class="contenedor login">
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Iniciar sesión</p>
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

        <form action="/" method="post" class="formulario" novalidate>
            <div class="campo">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Ingrese su correo electrónico" autocomplete="off" focus >
            </div>

            <div class="campo">
                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" placeholder="Ingrese su contraseña" autocomplete="off" >
            </div>
            <input type="submit" value="Iniciar sesión" class="boton">
        </form>

        <div class="acciones">
            <span>¿Aún no tenes cuenta? <a href="/registrarse">Crear una</a></span>
            <span>¿Te olvidaste la contraseña? <a href="/olvide-clave">Recuperar clave</a></span>
        </div>
    </div>
</div>

<?php 
    $script ="<script src='/build/js/error.js'></script>";
?>