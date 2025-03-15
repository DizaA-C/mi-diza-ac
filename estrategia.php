<?php
require 'vendor/autoload.php'; // Cargar PHPMailer
require 'config.php'; // Cargar configuración SMTP

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$config = require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario
    $nombre = htmlspecialchars($_POST["nombre"]);
    $email = htmlspecialchars($_POST["email"]);
    $empresa = htmlspecialchars($_POST["empresa"]);
    $mensaje = htmlspecialchars($_POST["mensaje"]);

    // Construcción del mensaje
    $contenido = "Nombre: $nombre\n";
    $contenido .= "Correo Electrónico: $email\n";
    $contenido .= "Empresa: $empresa\n";
    $contenido .= "Mensaje:\n$mensaje\n";

    // Crear instancia de PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = $config['smtp_host'];
        $mail->SMTPAuth = true;
        $mail->Username = $config['smtp_username'];
        $mail->Password = $config['smtp_password'];
        $mail->SMTPSecure = $config['smtp_secure'];
        $mail->Port = $config['smtp_port'];

        // Configurar el remitente y destinatario
        $mail->setFrom($config['smtp_from'], $config['smtp_from_name']);
        $mail->addAddress($config['smtp_destinatario'], 'Equipo Diza A & C');

        // Configurar el contenido del correo
        $mail->isHTML(true);
        $mail->Subject = "Nueva Solicitud de Estrategia - Diza A & C";
        $mail->Body = nl2br($contenido); // Convertir saltos de línea en <br>

        // Enviar correo
        if ($mail->send()) {
            echo "<script>
                    alert('Tu solicitud ha sido enviada con éxito.');
                    window.location.href = 'estrategia.html';
                  </script>";
        } else {
            echo "<script>
                    alert('Hubo un error al enviar tu solicitud.');
                    window.location.href = 'estrategia.html';
                  </script>";
        }
    } catch (Exception $e) {
        echo "<script>
                alert('Error al enviar el correo: {$mail->ErrorInfo}');
                window.location.href = 'estrategia.html';
              </script>";
    }
} else {
    echo "<script>
            alert('Acceso no autorizado.');
            window.location.href = 'estrategia.html';
          </script>";
}
