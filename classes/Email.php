<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email
{

    public $nombre;
    public $apellido;
    public $email;
    public $token;
    public $url;

    public function __construct($nombre, $apellido, $email, $token, $url)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->token = $token;
        $this->url = $url;
    }

    public function enviarConfirmacion()
    {

        // Crear el objeto de email
        $mail = new PHPMailer();
        $fullName = $this->nombre . " " . $this->apellido;
        try {
            //Configurar SMTP
            $mail->SMTPDebug = false;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            // $mail->Host       = $_ENV['MAIL_HOST'];                     //Set the SMTP server to send through
            $mail->Host       = 'sandbox.smtp.mailtrap.io';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            // $mail->Username   = $_ENV['MAIL_USER'];                     //SMTP username
            $mail->Username   = '07f19faefaeb05';                     //SMTP username
            $mail->Password   = '7145e194340fdf';                                //SMTP password
            // $mail->Password   = $_ENV['MAIL_PASS'];                               //SMTP password
            $mail->SMTPSecure = 'tls';             //Enable implicit TLS encryption
            // $mail->SMTPSecure = $_ENV['MAIL_SECURE'];            //Enable implicit TLS encryption
            $mail->Port       = 2525;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            // $mail->Port       = $_ENV['MAIL_PORT'];                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Configurar el contenido del mail
            $mail->setFrom('admin@uptask.com', 'Admin - UpTask');
            // $mail->setFrom($_ENV['MAIL_EMAIL'], $_ENV['MAIL_NAME']);
            $mail->addAddress($this->email, $fullName); //Add a recipient

            $mail->Subject = 'Gracias por registrarte en nuestro sistema, por favor confirma tu cuenta';


            //Habilitar HTML
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->CharSet = 'UTF-8';


            // Definir el contenido
            $contenido = '<html>';
            $contenido .= "<p><strong>Hola " . $fullName .  "</strong> Has Creado tu cuenta en UpTask, solo debes confirmarla presionando el siguiente enlace</p>";
            $contenido .= "<p>Presiona aquí: <a href='" . $this->url . "/confirmar-cuenta?token=" . $this->token . "'>Confirmar Cuenta</a>";
            $contenido .= "<p>Si tu no solicitaste este cambio, puedes ignorar el mensaje</p>";
            $contenido .= '</html>';

            $mail->Body = $contenido;

            $mail->AltBody = 'Esto es texto alternativo sin HTML';

            //  Enviar el email
            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function enviarInstrucciones()
    {

        // create a new object
        $mail = new PHPMailer();
        $fullName = $this->nombre . " " . $this->apellido;
        try {
            //Configurar SMTP
            $mail->SMTPDebug = false;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'sandbox.smtp.mailtrap.io';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = '07f19faefaeb05';                     //SMTP username
            $mail->Password   = '7145e194340fdf';                               //SMTP password
            $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
            $mail->Port       = 2525;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Configurar el contenido del mail
            $mail->setFrom('admin@uptask.com', 'Admin - UpTask');
            $mail->addAddress($this->email, $fullName); //Add a recipient

            $mail->Subject = 'Lo sentimos 😢, te mandamos un instructivo para desbloquear tu cuenta';


            //Habilitar HTML
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->CharSet = 'UTF-8';


            $contenido = '<html>';
            $contenido .= "<p><strong>Hola " . $fullName .  "</strong> Has solicitado reestablecer tu contraseña, sigue el siguiente enlace para hacerlo.</p>";
            $contenido .= "<p>Presiona aquí: <a href='". $this->url ."/recuperar-clave?token=" . $this->token . "'>Reestablecer Contraseña</a>";
            $contenido .= "<p>Si tu no solicitaste este cambio, puedes ignorar el mensaje</p>";
            $contenido .= '</html>';
            $mail->Body = $contenido;
            $mail->AltBody = 'Esto es texto alternativo sin HTML';

            //  Enviar el email
            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
