<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController
{
    public static function Login(Router $r)
    {
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarLogin();
            if (empty($alertas)) {
                // Verificar que el usuario existe.
                $usuario = Usuario::where('email', $auth->email);
                unset($usuario->password2);
                if (!$usuario || !$usuario->confirmado) {
                    // $alertas = Usuario::setAlerta('error', 'El usuario y/o contraseña no son correctas');
                    $alertas = Usuario::setAlerta('error', 'No hemos podido encontrar un usuario con el correo asignado o no has confirmado tu cuenta. Por favor volve a intentarlo mas tarde.');
                } else {
                    // El usuario existe
                    if(password_verify($_POST['password'], $usuario->password)){
                        // Iniciar la sesión
                        session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre;
                        $_SESSION['apellido'] = $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;


                        // Redireccionar
                        header('Location: /proyectos');

                    }else{
                    $alertas = Usuario::setAlerta('error', 'El usuario y/o contraseña no son correctas');
                    }
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $r->render('auth/login', [
            'titulo' => 'Iniciar sesion',
            'alertas' => $alertas
        ]);
    }

    public static function Logout()
    {
        session_start();
        $_SESSION = [];
        header('Location:/');
    }

    public static function Registrarse(Router $r)
    {
        $usuario = new Usuario;
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            // debug($usuario);
            $alertas = $usuario->validarNuevaCuenta();

            if (empty($alertas)) {
                $existeUsuario = Usuario::where('email', $usuario->email);

                if ($existeUsuario) {
                    Usuario::setAlerta('error', 'El email que intentas usar para registrarte ya se encuentra en nuestro sistema');
                    $alertas = Usuario::getAlertas();
                } else {
                    // Hashear el password
                    $usuario->hashPassword();

                    // Eliminar password2
                    unset($usuario->password2);

                    // Generar token
                    $usuario->generarToken();

                    $url = $_SERVER['HTTP_ORIGIN'];

                    // Enviar el email
                    $email = new Email($usuario->nombre, $usuario->apellido, $usuario->email, $usuario->token, $url);
                    $email->enviarConfirmacion();

                    // Crear nuevo usuario
                    $resultado = $usuario->guardar();
                    if ($resultado) {
                        header('Location:/mensaje');
                    }
                }
            }
        }

        $r->render('auth/crear', [
            'titulo' => 'Crear nueva cuenta',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function Olvide(Router $r)
    {
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarEmail();
            if (empty($alertas)) {
                // Buscar el usuario
                $usuario = Usuario::where('email', $usuario->email);
                if ($usuario && $usuario->confirmado) {
                    // Generar un nuevo token
                    $usuario->generarToken();
                    unset($usuario->password2);

                    // Actualizar el usuario
                    $usuario->guardar();

                    // Enviar el email
                    $url = $_SERVER['HTTP_ORIGIN'];
                    $email = new Email($usuario->nombre, $usuario->apellido, $usuario->email, $usuario->token, $url);
                    $email->enviarInstrucciones();

                    // Imprimir la alerta
                    Usuario::setAlerta('exito', 'Se ha enviado instrucciones a tu email para cambiar la clave');
                } else {
                    Usuario::setAlerta('error', 'No se ha encontrado un usuario con ese correo');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $r->render('auth/olvide', [
            'titulo' => 'Olvide mi clave',
            'alertas' => $alertas
        ]);
    }

    public static function Recuperar(Router $r)
    {
        $alertas = [];
        $mostrar = true;
        $token = s($_GET['token']);
        if (!$token) header('Location:/');

        $usuario = Usuario::where('token', $token);
        if (empty($usuario)) {
            Usuario::setAlerta('error', 'El token enviado no es valido');
            $mostrar = false;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Añadir el nuevo password
            $usuario->sincronizar($_POST);

            // Validar el password
            $alertas = $usuario->validarPassword();
            if (empty($alertas)) {
                // Hashear el password
                $usuario->hashPassword();
                unset($usuario->password2);

                // Elimminar el token
                $usuario->token = null;

                // Guardar el usuario en la BD
                $resultado = $usuario->guardar();

                // Redireccionar
                if ($resultado) {
                    header('Location:/');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $r->render('auth/reestablecer', [
            'titulo' => 'Reestablecer contraseña',
            'alertas' => $alertas,
            'mostrar' => $mostrar
        ]);
    }

    public static function Confirmar(Router $r)
    {
        $token = s($_GET['token']);

        if (!$token) header('Location: /');

        // Encontrar el usuario con este token
        $usuario = Usuario::where('token', $token);
        if (empty($usuario)) {
            //  No se encontro ningun usuario con ese token
            Usuario::setAlerta('error', 'Token no valido');
        } else {
            // Se encontro el usuario
            $usuario->confirmado = true;
            unset($usuario->password2);
            $usuario->token = null;
            $usuario->guardar();

            Usuario::setAlerta('exito', 'Se ha verificado con éxito la cuenta, ya puedes iniciar sesión');
        }

        $alertas = Usuario::getAlertas();
        $r->render('auth/confirmar', [
            'alertas' => $alertas,
            'titulo' => 'Cuenta confirmada con éxito'
        ]);
    }

    public static function Mensaje(Router $r)
    {
        $r->render('auth/mensaje', [
            'titulo' => 'Gracias por crear su cuenta'
        ]);
    }
}
