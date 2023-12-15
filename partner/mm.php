<?php

    session_start();
    require '../app/php/conexion.php';  
    require '../app/vendor/autoload.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    if (isset($_SESSION['email'], $_SESSION['managedStore']))
    {
        $email    = $_SESSION['email'];
        $idTienda = $_SESSION['managedStore'];
    }
  
    $sql = "SELECT * FROM usuarios WHERE isActive = 1";

 

function obtenerListaCorreos($conn) 
{


    if ($conn->connect_error) 
    {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $sql = "SELECT email, nombre FROM usuarios WHERE isActive = 1";
    $result = $conn->query($sql);

    $listaCorreos = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $listaCorreos[] = array(
                'email' => $row['email'],
                'nombre' => $row['nombre']
            );
        }
    }

    $conn->close();

    return $listaCorreos;
}

function enviaEmail($destinatarios, $tituloCorreo, $cuerpoCorreo) 
{
    $mail = new PHPMailer(); 
    $mail->CharSet = 'UTF-8';

    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host      = 'smtp.hostinger.com';
    // $mail->Port      = 587;
    $mail->SMTPAuth  = true;
    $mail->Username  = 'contacto@conejondigital.com';
    $mail->Password  = 'veve33A1&&';
    //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
    $mail->Port       = 465;      
    
    //Recipients
    $mail->setFrom('contacto@conejondigital.com', 'Conejón Digital');
    $mail->addReplyTo('contacto@conejondigital.com', 'Conejón Digital');
    
    // Configuración del correo
    $mail->setFrom('contacto@conejondigital.com', 'Conejón Digital');
    $mail->Subject = $tituloCorreo;
    $mail->Body = $cuerpoCorreo;
    $mail->isHTML(true);                        
    $mail->AltBody = 'Conejón Digital';
    

    // Agregar destinatarios al correo
    foreach ($destinatarios as $destinatario) {
        $mail->addBCC($destinatario['email'], $destinatario['nombre']);
    }

    
    // Enviar el correo
    if (!$mail->send()) {
        echo 'Error al enviar el correo: ' . $mail->ErrorInfo;
    } else {
        echo 'Correo enviado correctamente';
    }

    // Limpiar la lista de destinatarios para el próximo lote
    $mail->clearAddresses();
}

// Obtener la lista de correos
$listaCorreos = obtenerListaCorreos($conn);

// $listaCorreos[0]['email'] = "axelcoreos@gmail.com";
// $listaCorreos[0]['nombre'] = "Axel";

// $listaCorreos[1]['email'] = "aespinozabgx@gmail.com";
// $listaCorreos[1]['nombre'] = "Axel Espinoza";

// $listaCorreos[2]['email'] = "antbgx@gmail.com";
// $listaCorreos[2]['nombre'] = "Ant";

// Dividir la lista de correos en lotes de 99
$lotes = array_chunk($listaCorreos, 99);

echo "<pre>";
print_r($lotes);
die;
 
function construirCuerpoCorreo() 
{ 

    $html = '<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Conejon Navideno 2023</title>
    </head>
    <body style="text-align: center;">

        <a style="padding: 10px;" target="_blank" href="https://conejondigital.com/partner/assets/mailmasivo/faltan3dias/correoconejon.html">No puedo ver el correo completo</a>

        <div>
            <a href="https://conejondigital.com/" target="_blank">
                <img src="https://conejondigital.com/partner/assets/mailmasivo/faltan3dias/1.png" alt="Conejon navideno" style="max-width: 100%; height: auto; margin: 0 auto; display: block;">
            </a>

            <a href="https://conejondigital.com/" target="_blank">
                <img src="https://conejondigital.com/partner/assets/mailmasivo/faltan3dias/2.png" alt="Conejon navideno" style="max-width: 60%; height: auto; margin: 0 auto; display: block;">
            </a>

        </div>       

    </body>
    </html>';

    return $html;
}

$cuerpoCorreo = construirCuerpoCorreo();

//echo $cuerpoCorreo;
//die;


// Configurar y enviar el correo para cada lote
foreach ($lotes as $lote) 
{
    $tituloCorreo = "¡Faltan 3 días! 🎄🐇 Para el Conejón Navideño 2023 🎄";  // Puedes cambiar esto según tus necesidades
    //$cuerpoCorreo = "Cuerpo del Correo";  // Puedes cambiar esto según tus necesidades
    enviaEmail($lote, $tituloCorreo, construirCuerpoCorreo());
}


?> 