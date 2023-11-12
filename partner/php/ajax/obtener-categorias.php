<?php

    session_start();
    
    require '../../../app/php/conexion.php'; 
    

    // Obtener las categorías de la base de datos
    $managedStore = $_SESSION['managedStore'];

    // Obtener las categorías de la base de datos para la tienda especificada
    $stmt = $conn->prepare('SELECT * FROM categoriasTienda WHERE idTienda = ? ORDER BY nombre ASC');
    $stmt->bind_param('s', $managedStore);
    $stmt->execute();
    $result = $stmt->get_result();

    // Crear una lista vacía de categorías
    $categorias = array();

    // Si hay categorías en la base de datos, agregarlas a la lista
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc())
        {
            // Poner en mayúscula cada palabra del nombre de la categoría
            $row['nombre'] = ucwords($row['nombre']);
            $row['idCategoria'] = ucwords($row['idCategoria']);
            $categorias[] = $row;
        }
    }

    // Cerrar la conexión a la base de datos
    $conn->close();

    // Devolver las categorías en formato JSON
    header('Content-Type: application/json');
    echo json_encode($categorias);
