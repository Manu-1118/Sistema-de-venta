<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../PHPMailer/Exception.php';
require '../../PHPMailer/PHPMailer.php';
require '../../PHPMailer/SMTP.php';

require '../app.php';

$db = conectarDB(); // obtener la conexion de la bd

$email = mysqli_real_escape_string($db, filter_var($_POST['txtEmail'], FILTER_VALIDATE_EMAIL));

// consulta para verificar si el email existe
$query = "SELECT * FROM Administrador WHERE correo = '$email';";
$resultado = mysqli_query($db, $query);
$usuario = mysqli_fetch_assoc($resultado);

if ($resultado->num_rows > 0) {


    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'zetassj78@gmail.com';
        $mail->Password   = 'ytvjtohszvmrqgqv';
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom('zetassj78@gmail.com', 'Brenda Del Pilar');
        $mail->addAddress('manutijerino1804@gmail.com', 'Manuel');     //Add a recipient
        // $mail->addAddress($usuario['correo'], $usuario['nombre']);     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Reestablecer Contraseña';
        $mail->Body    = 'Este es un correo generado automaticamente para la recuperación de su contraseña'
        . '<br><br>Para cambiar su contraseña haga click en el siguiente enlace: '
        . '<b>in bold!</b>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    $errores[] = "El correo digitado no existe";
}
