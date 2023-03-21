<?php

namespace Controllers;

use Classes\Email;
use Model\Proyecto;
use Model\Usuario;
use MVC\Router;

class DashboardController
{

    public static function Proyectos(Router $r)
    {
        $alertas = [];
        session_start();
        isAuth();
        $id = $_SESSION['id'];
        $proyectos = Proyecto::belongsTo('propietarioId', $id);

        $r->render('tablero/proyectos', [
            'titulo' => 'Proyectos',
            'alertas' => $alertas,
            'proyectos' => $proyectos,
            'nombre' => $_SESSION['nombre']
        ]);
    }

    public static function Crear_Proyecto(Router $r)
    {
        $alertas = [];
        session_start();
        isAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $proyecto = new Proyecto($_POST);
            $alertas = $proyecto->validarProyecto();
            if (empty($alertas)) {
                // Generar una URL única
                $proyecto->generarUrl();

                // Guardar el creador del proyecto
                $proyecto->propietarioId = $_SESSION['id'];

                // Guardar el proyecto
                $proyecto->guardar();

                // Redireccionar
                header('Location:/proyecto?url=' . $proyecto->url);
            }
        }
        $alertas = Proyecto::getAlertas();
        $r->render('tablero/crear-proyecto', [
            'titulo' => 'Crear Proyecto',
            'alertas' => $alertas,
            'nombre' => $_SESSION['nombre']
        ]);
    }

    public static function Proyecto(Router $r)
    {
        $alertas = [];
        session_start();
        isAuth();

        $token = $_GET['url'];
        // Revisar que la persona que visita el proyecto, es quien lo creo
        if (!$token) header('Location:/tablero');

        $proyecto = Proyecto::where('url', $token);

        if ($proyecto->propietarioId !== $_SESSION['id']) {
            header('Location:/tablero');
        }

        $r->render('tablero/proyecto', [
            'titulo' => $proyecto->proyecto,
            'alertas' => $alertas,
            'nombre' => $_SESSION['nombre']
        ]);
    }

    public static function Perfil(Router $r)
    {
        $alertas = [];
        session_start();
        isAuth();

        $usuario = Usuario::find($_SESSION['id']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);

            $alertas = $usuario->validarPerfil();

            if (empty($alertas)) {
                $existeUser = Usuario::where('email', $usuario->email);
                if ($existeUser && $existeUser->id !== $usuario->id) {
                    // Mostrar error
                    Usuario::setAlerta('error', 'Cuenta ya registrada');
                } else {
                    $usuario->guardar();
                    Usuario::setAlerta('exito', 'Se guardo con éxito');
                    $alertas = Usuario::getAlertas();
                    $_SESSION['nombre'] = $usuario->nombre;
                    $_SESSION['apellido'] = $usuario->apellido;
                    $_SESSION['email'] = $usuario->email;
                }
            }
        }
        $r->render('tablero/perfil', [
            'titulo' => 'Perfil',
            'alertas' => $alertas,
            'nombre' => $_SESSION['nombre'],
            'usuario' => $usuario
        ]);
    }

    public static function Cambiar_Clave(Router $r)
    {
        $alertas = [];
        session_start();
        isAuth();

        $usuario = Usuario::find($_SESSION['id']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = Usuario::find($_SESSION['id']);

            // Sincronizar con los datos del usuario
            $usuario->sincronizar($_POST);

            $alertas = $usuario->nuevo_password();
            if (empty($alertas)) {
                $resultado = $usuario->comprobar_password();
                if ($resultado) {
                    $usuario->password = $usuario->repassword;
                    // Eliminar propiedades no necesarias
                    unset($usuario->password2);
                    unset($usuario->oldpassword);
                    unset($usuario->repassword);
                    unset($usuario->repassword2);

                    // Hashear el nuevo password
                    $usuario->hashPassword();

                    // Actualizar datos en bd
                    $resultado = $usuario->guardar();
                    if ($resultado) {
                        Usuario::setAlerta('exito', 'Se cambio con éxito la nueva contraseña');
                    } else {
                        Usuario::setAlerta('error', 'Hubo un error al cambiar la contraseña');
                    }
                } else {
                    Usuario::setAlerta('error', 'La contraseña actual no coincide');
                }
            }
            $alertas = Usuario::getAlertas();
        }
        $r->render('tablero/cambiar-clave', [
            'titulo' => 'Cambiar contraseña',
            'alertas' => $alertas,
            'nombre' => $_SESSION['nombre'],
            'usuario' => $usuario
        ]);
    }
}
