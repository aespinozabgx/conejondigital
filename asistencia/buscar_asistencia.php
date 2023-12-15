<?php
session_start();
require '../app/php/conexion.php';

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Se ha enviado el formulario por POST

    $email = $_POST['email'];

    // Verifica si el usuario ya asistió y obtiene la fecha de asistencia
    echo $sqlCheck = "SELECT * FROM registro_asistencia WHERE usuario_id = '$email'";
    $resultCheck = $conn->query($sqlCheck);

    if ($resultCheck->num_rows > 0) {
        // El usuario ya asistió, obtenemos la fecha de asistencia
        $row = $resultCheck->fetch_assoc();
        $fechaAsistencia = $row['fecha_hora_asistencia'];
        $asistio = $row['asistio'];

        if ($asistio) {
            // El usuario ya había asistido anteriormente
            $mensaje = 'El usuario <b>' . $email . '</b> se registró previamente: <b>' . $fechaAsistencia . '</b>';
        } 
        else 
        {
            // El usuario no ha asistido, se realiza la actualización
            $fechaAsistencia = date("Y-m-d H:i:s");
            $sqlUpdate = "UPDATE registro_asistencia SET asistio = 1, fecha_hora_asistencia = '$fechaAsistencia' WHERE usuario_id = '$email'";
            $resultUpdate = $conn->query($sqlUpdate);

            if ($resultUpdate) 
            {
                $mensaje = 'Asistencia registrada.';
                $emailAsistente = $row['usuario_id'];
                $mensaje .= '<br>Usuario: <b>' . $emailAsistente . '</b><br>Fecha de asistencia: <b>' . $fechaAsistencia . '</b>';
            } else {
                $mensaje = 'Error al actualizar asistencia.';
            }
        }

        
    } else {
        // El usuario no existe en la base de datos
        $mensaje = 'El usuario <b>' . $email . '</b> no existe en la base de datos.';
    }

    // Almacena el mensaje en una variable de sesión
    $_SESSION['mensaje'] = $mensaje;

    // Cierra la conexión
    $conn->close();

    // Redirige a index.php
    header("Location: index.php");
    exit;
} else {
    // Si se accede directamente a este archivo sin un envío POST, redirige a otra página o realiza alguna acción adicional.
    header("Location: otra_pagina.php");
    exit;
}
?>
