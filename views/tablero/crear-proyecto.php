<?php include_once __DIR__ . '/header-tablero.php'; ?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>
    <form action="/crear-proyecto" class="formulario" method="post">
        <?php include_once __DIR__ . '/formulario-proyecto.php'; ?>

        <input type="submit" value="Crear Proyecto" class="boton">
    </form>
</div>
<?php include_once __DIR__ . '/footer-tablero.php'; ?>

<?php 
    $script .="<script src='/build/js/error.js'></script>";
?>