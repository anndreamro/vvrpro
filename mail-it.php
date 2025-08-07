<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre  = $_POST['name'] ?? '';
    $correo  = $_POST['email'] ?? '';
    $asunto  = $_POST['subject'] ?? '';
    $mensaje = $_POST['message'] ?? '';

    if (empty($nombre) || empty($correo) || empty($asunto) || empty($mensaje)) {
        echo "Todos los campos son obligatorios";
        exit;
    }

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'mail.vvrpro.com'; // Confirma este valor en cPanel
    $mail->SMTPAuth   = true;
    $mail->Username   = 'Contact@vvrpro.com';
    $mail->Password   = 'ContactVVRPRO.'; // Reemplaza por la contraseña real
    $mail->SMTPSecure = 'ssl'; // Usa 'ssl' si optas por puerto 465
    $mail->Port       = 465; // Cambia a 465 si usas SSL

    // Remitente y destinatario
    $mail->setFrom('contact@vvrpro.com', 'Formulario Web VVR PRO');
    $mail->addAddress('soporte.vvrpro@gmail.com'); // O cualquier correo donde desees recibir
	$mail->addReplyTo($correo, $nombre);


    // Contenido
    $mail->isHTML(true);
    $mail->Subject = 'Nuevo mensaje desde vvrpro.com';
    $mail->Body    = <<<EOT
<table cellpadding="0" cellspacing="0" width="100%" height="100%" style="background-color: #2a2a2a; padding:20px;font-family:'Raleway';">
  <tr>
    <td align="center">
      <table cellpadding="0" cellspacing="0" width="600" style="background-color: #fff9f1;border-radius:0px;box-shadow:0 0 10px rgba(0,0,0,0.1);overflow:hidden;">
        <tr>
          <td style="background-color: #ca4f13;padding:30px;color: #fff9f1;text-align:center;">
            <h2 style="margin:0;">Nuevo mensaje desde el formulario de contacto</h2>
          </td>
        </tr>
        <tr>
          <td style="padding:32px;color: #2a2a2a;">
            <p><strong>Nombre:</strong> {$nombre}</p>
            <p><strong>Email:</strong> {$correo}</p>
            <p><strong>Asunto:</strong> {$asunto}</p>
            <p><strong>Mensaje:</strong></p>
            <p style="background-color: #beb3a3;padding:15px;border-left:4px solid #ca4f13;">{$mensaje}</p>
          </td>
        </tr>
        <tr>
          <td style="background-color: #beb3a3;padding:22px;text-align:center;color: #2a2a2a;;font-size:12px;">
            <p>Este correo fue generado automáticamente desde <strong>vvrpro.com</strong></p>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
EOT;


		

		$mail->send();
		echo 'Mensaje enviado correctamente';
	} catch (Exception $e) {
		echo "Error al enviar el mensaje: {$mail->ErrorInfo}";
	}
} else {
    echo "Acceso inválido al script";
}

?>