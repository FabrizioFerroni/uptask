<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\DashboardController;
use Controllers\LoginController;
use Controllers\TareaController;
use MVC\Router;

$r = new Router();

// Iniciar Sesion
$r->get('/',[LoginController::class, 'Login']);
$r->post('/',[LoginController::class, 'Login']);
$r->get('/cerrarsesion',[LoginController::class, 'Logout']);

// Recuperar password
$r->get('/olvide-clave',[LoginController::class, 'Olvide']);
$r->post('/olvide-clave',[LoginController::class, 'Olvide']);
$r->get('/recuperar-clave',[LoginController::class, 'Recuperar']);
$r->post('/recuperar-clave',[LoginController::class, 'Recuperar']);

// Crear cuenta
$r->get('/registrarse',[LoginController::class, 'Registrarse']);
$r->post('/registrarse',[LoginController::class, 'Registrarse']);

// Confirmacion de cuenta
$r->get('/confirmar-cuenta',[LoginController::class, 'Confirmar']);
$r->get('/mensaje',[LoginController::class, 'Mensaje']);

// Zona de proyectos 
$r->get('/proyectos', [DashboardController::class, 'Proyectos']);
$r->get('/proyecto', [DashboardController::class, 'Proyecto']);
$r->get('/crear-proyecto', [DashboardController::class, 'Crear_Proyecto']);
$r->post('/crear-proyecto', [DashboardController::class, 'Crear_Proyecto']);
$r->get('/perfil', [DashboardController::class, 'Perfil']);
$r->post('/perfil', [DashboardController::class, 'Perfil']);
$r->get('/cambiar-clave', [DashboardController::class, 'Cambiar_Clave']);
$r->post('/cambiar-clave', [DashboardController::class, 'Cambiar_Clave']);
// Ruta API
$r->get('/api/tareas', [TareaController::class, 'Index']);
$r->post('/api/tarea', [TareaController::class, 'Crear']);
$r->post('/api/tarea/actualizar', [TareaController::class, 'Actualizar']);
$r->post('/api/tarea/eliminar', [TareaController::class, 'Eliminar']);






// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$r->comprobarRutas();