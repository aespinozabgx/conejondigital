<?php

    session_start();

    require '../conexion_db.php';
    require '../funciones.php';

    $idTienda = mysqli_real_escape_string($conn, $_POST['idTienda']);

    // Realizar la consulta en la base de datos para verificar si el idTienda existe
    $sql = "SELECT COUNT(*) FROM tiendas WHERE idTienda = '$idTienda'";
    $result = mysqli_query($conn, $sql);

    // Verificar si la consulta fue exitosa
    if (!$result) {
      die("Error en la consulta: " . mysqli_error($conn));
    }

    // Obtener el número de filas afectadas por la consulta
    $row   = mysqli_fetch_array($result);
    $count = $row[0];

    // Verificar si el idTienda existe en la base de datos
    if ($count > 0)
    {
        $responseAjax = array("status"  => true);
    }
    else
    {
        $responseAjax = array("status"  => false);
    }

    echo json_encode($responseAjax);

?>
