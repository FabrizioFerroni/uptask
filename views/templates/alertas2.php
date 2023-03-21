<?php

foreach ($alertas as $k => $alerta) {
    foreach ($alerta as $mensaje) {
        ?>
        <div class="alerta2 <?php echo $k; ?>">
            <?php echo $mensaje; ?>
        </div>
        <?php
    }
}
?>