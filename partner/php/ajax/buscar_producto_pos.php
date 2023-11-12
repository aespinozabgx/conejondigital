<?php

    session_start();
    require '../conexion_db.php';

    // Obtener el valor ingresado en el input de búsqueda
    $busqueda = $_POST["busqueda"];

    // Verificar si la búsqueda es un valor numérico
    if (is_numeric($busqueda))
    {
        echo "Numerico";
        // Si es numérico, ejecutar la función agregarCarrito
        //$resultado = agregarCarrito($conn, $datosProducto, $idProducto, $idTienda, $stock, $precio, $precioOferta);
        // Devolver el resultado de la función como respuesta AJAX
        //echo json_encode(array("mensaje" => $resultado));
    }
    else
    {
        // Si no es numérico, mostrar la palabra "sql"
        echo "sql";
    }

?>
