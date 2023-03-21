<?php include_once __DIR__ . '/header-tablero.php'; ?>
<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>
    <a href="/cambiar-clave" class="enlace">Cambiar contraseña</a>

    <form action="/perfil" method="POST" class="formulario">
    <div class="campo">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" placeholder="Ingresa tu nombre" autocomplete="off"  value="<?php echo s($usuario->nombre); ?>" />
            </div>
            <div class="campo">
                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" placeholder="Ingresa tu apellido" autocomplete="off"  value="<?php echo s($usuario->apellido); ?>" />
            </div>
            <div class="campo">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Ingrese su correo electrónico" autocomplete="off"  value="<?php echo s($usuario->email); ?>" />
            </div>

            <input type="submit" value="Guardar cambios" class="boton">

    </form>
</div>
<?php include_once __DIR__ . '/footer-tablero.php'; ?>
<?php
 $script .= '
 <script src="/build/js/error.js"></script>
 ';
 ?>