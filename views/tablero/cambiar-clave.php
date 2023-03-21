<?php include_once __DIR__ . '/header-tablero.php'; ?>
<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>
    <a href="/perfil" class="enlace">Volver a perfil</a>

    <form action="/cambiar-clave" method="POST" class="formulario">
    <div class="campo">
                <label for="oldpassword">Contraseña actual:</label>
                <input type="password" id="oldpassword" name="oldpassword" placeholder="Ingresa tu nueva contraseña" autocomplete="off"/>
            </div>
    
            <div class="campo">
                <label for="password">Contraseña:</label>
                <input type="password" id="repassword" name="repassword" placeholder="Ingresa tu nueva contraseña" autocomplete="off"/>
            </div>
            <div class="campo">
                <label for="repassword">Confirmar contraseña</label>
                <input type="password" name="repassword2" id="repassword2" placeholder="Repita su contraseña" autocomplete="off"/>
            </div>

            <input type="submit" value="Cambiar contraseña" class="boton">

    </form>
</div>
<?php include_once __DIR__ . '/footer-tablero.php'; ?>
<?php
 $script .= '
 <script src="/build/js/error.js"></script>
 ';
 ?>