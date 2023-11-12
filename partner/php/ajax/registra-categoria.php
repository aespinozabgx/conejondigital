<?php

    session_start();
    require '../../../app/php/conexion.php';
    require '../../php/funciones.php';

    // Obtener el nombre de la categoría de la petición POST
    $categoria    = mb_strtolower(limpiarDato($_POST['categoria']));
    $managedStore = $_SESSION['managedStore'];

    // Verificar si ya existe una categoría con el mismo nombre
    $stmt = $conn->prepare('SELECT * FROM categoriasTienda WHERE nombre = ? AND idTienda = ?');
    $stmt->bind_param('ss', $categoria, $managedStore);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0)
    {
        // Si ya existe una categoría con el mismo nombre, mostrar un mensaje de error
        echo 'Ya existe una categoría con ese nombre';
        return;
    }

    $idCategoria = generaIdCategoria($conn, $managedStore);

    // Si no existe una categoría con el mismo nombre, registrar la nueva categoría
    $stmt = $conn->prepare('INSERT INTO categoriasTienda (idCategoria, nombre, idTienda) VALUES (?, ?, ?)');
    $stmt->bind_param('sss', $idCategoria, $categoria, $managedStore);
    if ($stmt->execute())
    {
        // Si el registro tuvo éxito, mostrar un mensaje de éxito
        echo 'Categoría registrada con éxito';
    }
    else
    {
        // Si el registro falló, mostrar un mensaje de error
        echo 'Error al registrar la categoría';
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
