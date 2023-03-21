<?php

foreach ($alertas as $k => $alerta) {
    foreach ($alerta as $mensaje) {
        ?>
        <div class="alerta <?php echo $k; ?>">
            <?php echo $mensaje; ?>
            <span class="cerrar" title="Cerrar">X</span>
        </div>
        <?php
    }
}
?>