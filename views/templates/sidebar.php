<aside class="sidebar">
    <div class="contenedor-sidebar">
    <h2>UpTask</h2>
    <div class="cerrar-menu">
        <img src="/build/img/cerrar.svg" alt="Icono cerrar menu" id="mobile-cerrar">
    </div>
    </div>
    <nav class="sidebar-nav">
        <a class="<?php echo ($titulo === 'Proyectos') ? 'actual' : ''; ?>" href="/proyectos">Proyectos</a>
        <a class="<?php echo ($titulo === 'Crear Proyecto') ? 'actual' : ''; ?>" href="/crear-proyecto">Crear Proyectos</a>
        <a class="<?php echo ($titulo === 'Perfil') ? 'actual' : ''; ?>" href="/perfil">Perfil</a>
    </nav>
    <div class="cerrar-sesion-mobile">
        <a href="/cerrarsesion" class="cerrar-sesion">Cerrar sesión</a>
    </div>
</aside>