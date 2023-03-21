<div class="contenedor crear">
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>
    <div class="contenedor-sm">
        <p class="descripcion-pagina">Crear tu cuenta en UpTask</p>
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

        <form action="/registrarse" method="post" class="formulario">
            <div class="campo">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" placeholder="Ingresa tu nombre" autocomplete="off"  value="<?php echo s($usuario->nombre);?>" />
            </div>
            <div class="campo">
                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" placeholder="Ingresa tu apellido" autocomplete="off"   value="<?php echo s($usuario->apellido);?>"/>
            </div>
            <div class="campo">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Ingrese su correo electrónico" autocomplete="off"  value="<?php echo s($usuario->email);?>" />
            </div>

            <div class="campo">
                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" placeholder="Ingrese su contraseña" autocomplete="off"  />
            </div>
            <div class="campo">
                <label for="password2">Repetir Contraseña</label>
                <input type="password" name="password2" id="password2" placeholder="Repeti tu contraseña" autocomplete="off"  />
            </div>
            <input type="submit" value="Crear cuenta" class="boton">
        </form>

        <div class="acciones">
            <span>¿Ya tenes cuenta? <a href="/">Inicia Sesion</a></span>
        </div>
    </div>
</div>


<?php 
    $script ="<script src='/build/js/error.js'></script>";
?>