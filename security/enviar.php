<?php
session_start(); // acceso a la variable $session
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader (created by composer, not included with PHPMailer)
require '../libraries/vendor/autoload.php';

$dominio = "http://localhost:3000/";
$administrador = $_SESSION['datos_admin'];
// unset($_SESSION['datos_admin']); // Limpiar la sesion despues de usarla

$mensaje = "Hola " . $administrador['nombre'] . ","
    . "<br><br>Hemos recibido una solicitud para restablecer la contraseña de tu cuenta en El Pilar."
    . "<br>Para crear una nueva contraseña, por favor haz clic en el siguiente enlace:\n"
    . "<br><a href='" . $dominio . "security/nueva-clave.php'>Recuperacion de su contraseña.</a>"
    . "<br><br><strong>Importante:</strong> Este enlace es válido por 10 minutos.<br>Si no lo utilizas dentro de este plazo, deberás solicitar un nuevo restablecimiento de contraseña."
    . "<br><br><strong>¿No solicitaste este cambio?</strong>"
    . "<br>Si tú no solicitaste este restablecimiento de contraseña, por favor ignora este correo electrónico.<br>Tu contraseña actual permanecerá sin cambios."
    . "<br><br>Por motivos de seguridad, te recomendamos no compartir este enlace con nadie.";

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'zetassj78@gmail.com';                  //SMTP username
    $mail->Password   = 'kssmbrclpeytftwe';                     //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('Remitente@gmail.com', 'El Pilar');
    $mail->addAddress($administrador['correo'], $administrador['nombre']);     //Add a recipient

    //Content
    $mail->isHTML(true);                                        //Set email format to HTML
    $mail->Subject = 'Recuperacion de contraseña';
    $mail->Body = $mensaje;

    $mail->send();
    $_SESSION['acceso_recuperacion'] = true; // para poder darle acceso al admin a cambiar su clave
    header('Location: /login.php?resultado=1');
    // echo 'Message has been sent';
} catch (Exception $e) {
    echo "Ocurrió un error en el envío: {$mail->ErrorInfo}";
}
