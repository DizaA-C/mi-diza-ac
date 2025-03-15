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
    $telefono = htmlspecialchars($_POST["telefono"]);
    $mensaje = htmlspecialchars($_POST["mensaje"]);
    $puesto = "Community Manager";

    // Validar campos
    if (empty($nombre) || empty($email) || empty($telefono) || empty($mensaje)) {
        echo "<script>
                alert('Todos los campos son obligatorios.');
                window.history.back();
              </script>";
        exit();
    }

    // Construcción del mensaje
    $contenido = "Nueva postulación recibida:\n\n";
    $contenido .= "Nombre: $nombre\n";
    $contenido .= "Correo Electrónico: $email\n";
    $contenido .= "Teléfono: $telefono\n";
    $contenido .= "Puesto de Interés: $puesto\n";
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

        // ❌ ELIMINAMOS CUALQUIER INTENTO DE ADJUNTAR ARCHIVOS
        // $mail->addAttachment($cv_temp, $cv_nombre); <-- BORRADO

        // Configurar el contenido del correo
        $mail->isHTML(true);
        $mail->Subject = "Nueva Postulación - $puesto";
        $mail->Body = nl2br($contenido);

        // Enviar correo
        if ($mail->send()) {
            echo "<script>
                    alert('Tu postulación ha sido enviada con éxito.');
                    window.location.href = 'postular-diseñar-web.html';
                  </script>";
        } else {
            echo "<script>
                    alert('Hubo un error al enviar tu postulación.');
                    window.history.back();
                  </script>";
        }
    } catch (Exception $e) {
        echo "<script>
                alert('Error al enviar el correo: {$mail->ErrorInfo}');
                window.history.back();
              </script>";
    }
} else {
    echo "<script>
            alert('Acceso no autorizado.');
            window.history.back();
          </script>";
}
?>
