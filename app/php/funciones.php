<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    date_default_timezone_set("America/Mexico_City");
    $fechahora = strtotime(date("Y-m-d h:i:s"));
  
    function getSucursalesTienda($conn, $idTienda)
    {
        $sucursales = array();
        $sql = "SELECT * FROM sucursalesTienda WHERE idTienda = '$idTienda' AND isActive = 1 ORDER BY isPrincipal DESC, nombreSucursal ASC";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 0)
        {
            return false;
        }
        else
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $sucursales[] = $row;
            }
            return $sucursales;
        }
    }    

    function getReputacionTienda($conn, $tienda)
    {
        $idTienda = $tienda['idTienda'];
        // Verificar la conexión
        if (!$conn)
        {
            return false;
        }

        // Preparar el query
        $sql = "SELECT
                    AVG(reputacionTienda.calificacion) AS calificacion
                FROM
                    reputacionTienda
                INNER JOIN pedidos ON reputacionTienda.idPedido = pedidos.idPedido
                WHERE
                    pedidos.isActive = 1 
                AND    
                    pedidos.idTienda = '$idTienda';";

        // Ejecutar el query
        $result = mysqli_query($conn, $sql);

        // Verificar si se obtuvo algún resultado
        if (mysqli_num_rows($result) == 0)
        {
            return false;
        }

        // Obtener el resultado como un array asociativo
        $row = mysqli_fetch_assoc($result);

        // Cerrar la conexión a la base de datos
        // mysqli_close($conn);

        // Verificar si se obtuvo una calificación nula
        if (is_null($row['calificacion']))
        {
            return false;
        }

        // Devolver el array con la información
        return $row;
    }

    function getMediosContactoVendedor($conn, $idTienda)
    {
        $sql = "SELECT
                    contactoTiendas.*,
                    CAT_mediosContacto.*
                FROM
                    contactoTiendas
                INNER JOIN
                    CAT_mediosContacto ON contactoTiendas.idMediosContacto = CAT_mediosContacto.idMediosContacto
                WHERE
                    contactoTiendas.idTienda = '$idTienda' AND contactoTiendas.isActive = 1
                ORDER BY
                    CAT_mediosContacto.alias
                DESC";


        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0)
        {
            // output data of each row
            while($row = mysqli_fetch_assoc($result))
            {

                $data[] = $row;
            }

            return $data;
        }
        else
        {
            return false;
        }
    }

    function getMetodosDePagoTienda($conn, $idTienda)
    {
        $query = "SELECT
                    metodosDePagoTienda.*,
                    CAT_metodoDePago.nombre,
                    CAT_metodoDePago.icono,
                    CAT_metodoDePago.hasOnlinePayment,
                    CAT_metodoDePago.hasDeliveryPayment
                FROM
                    metodosDePagoTienda
                INNER JOIN
                    CAT_metodoDePago
                ON
                    metodosDePagoTienda.idMetodoDePago = CAT_metodoDePago.idMetodoDePago
                WHERE
                    metodosDePagoTienda.idTienda = '$idTienda'
                ORDER BY
                    CAT_metodoDePago.nombre ASC";

        $result = $conn->query($query);
        $data = array();
        if ($result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc())
            {
                $data[] = $row;
            }
            return $data;
        }
        else
        {
            return false;
        }
    }

    function contarCarrito($idTienda)
    {
        $conteoProductos = 0;
        $requiereEnvio   = false;

        if (isset($_SESSION[$idTienda]))
        {
            foreach ($_SESSION[$idTienda] as $index => $value)
            {
                if ($_SESSION[$idTienda][$index]['unidadVenta'] == "Kilogramos")
                {
                    //echo "Kilos";
                    $conteoProductos += 1;
                }
                else
                {
                    $conteoProductos += $_SESSION[$idTienda][$index]['stock'];
                }
                if (($_SESSION[$idTienda][$index]['requiereEnvio']+0) == 1)
                {
                    //echo "Suma<br>";
                    $requiereEnvio = true;
                }
            }
        }
        return $conteoProductos;
    }
    
    function getComentariosTienda($conn, $idTienda)
    {
        $sql = "SELECT reputacionTienda.*, usuarios.*, pedidos.idPedido
                FROM reputacionTienda
                INNER JOIN usuarios ON reputacionTienda.idCliente = usuarios.email
                INNER JOIN pedidos ON reputacionTienda.idPedido = pedidos.idPedido
                WHERE reputacionTienda.idTienda = '$idTienda' AND reputacionTienda.comentario IS NOT NULL
                AND pedidos.isActive = 1
                ORDER BY RAND()
                LIMIT 5";


        $result = mysqli_query($conn, $sql);

        if (!$result)
        {
            // Si hay un error en la ejecución de la consulta, se muestra un mensaje y se detiene la ejecución del script
            die("Error al ejecutar la consulta: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($result) > 0)
        {
            $comentarios = array();
            while ($row = mysqli_fetch_assoc($result))
            {
            $comentarios[] = $row;
            }
            return $comentarios;
            // echo "ok";
        }
        else
        {
            return false;
            // echo "error";
        }
    }
    
    function validarPagoActivo($conn, $idTienda)
    {
        $query = "SELECT *
                FROM payments
                WHERE idTienda = ?
                ORDER BY fechaInicioPlan DESC
                LIMIT 1";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $idTienda);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0)
        {
            // No hay pagos para esta tienda
            return false;
        }

        $row = $result->fetch_assoc();

        $fechaInicioUltimoPago = new DateTime($row['fechaInicioPlan']);
        $fechaInicioUltimoPago->setTime(0, 0, 0);

        $fechaFinUltimoPago = new DateTime($row['fechaFinPlan']);
        $fechaFinUltimoPago->setTime(0, 0, 0);

        $fechaActual = new DateTime();
        $fechaActual->setTime(0, 0, 0);

        $existePagoActivo = false;
        if ($fechaActual >= $fechaInicioUltimoPago && $fechaActual <= $fechaFinUltimoPago)
        {
            $existePagoActivo = true;
        }

        $diasTranscurridos = $fechaInicioUltimoPago->diff($fechaActual)->format('%a');

        $diasRestantes = 0;
        if ($fechaFinUltimoPago > $fechaActual)
        {
            $diasRestantes = $fechaActual->diff($fechaFinUltimoPago)->format('%a');
        }

        $diasExpirado = 0;
        if ($fechaActual > $fechaFinUltimoPago)
        {
            $diasExpirado = $fechaFinUltimoPago->diff($fechaActual)->format('%a');
        }

        return array(
            'fechaInicioUltimoPago' => $fechaInicioUltimoPago,
            'fechaFinUltimoPago' => $fechaFinUltimoPago,
            'existePagoActivo' => $existePagoActivo,
            'diasTranscurridos' => $diasTranscurridos,
            'diasRestantes' => $diasRestantes,
            'diasExpirado' => $diasExpirado
        );
    }


    function getProductosTiendaPerfilPublico($conn, $idTienda, $limiteRegistros)
    {
        $sql = "
            SELECT
                productos.*,
                imagenProducto.url,
                categoriasTienda.nombre as nombreCategoria
            FROM
                productos
            LEFT JOIN
                imagenProducto ON productos.idProducto = imagenProducto.idProducto AND productos.idTienda = imagenProducto.idTienda AND imagenProducto.isPrincipal = 1
            LEFT JOIN
                categoriasTienda ON productos.idCategoria = categoriasTienda.idCategoria
            WHERE
                productos.idTienda = '$idTienda' AND productos.isActive = 1 AND productos.isActiveOnlineStore = 1
            ORDER BY
            categoriasTienda.nombre ASC, productos.nombre ASC;";

        if ($limiteRegistros>1)
        {
            $sql .= " LIMIT $limiteRegistros;";
        }

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0)
        {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
        else
        {
            return false;
        }
    }

    function getCategoriasConProductos($conn, $managedStore)
    {   
        $sql = "SELECT c.idCategoria, IFNULL(c.nombre, 'Sin categoria') AS nombre
                FROM categoriasTienda c
                LEFT JOIN (
                    SELECT DISTINCT idCategoria
                    FROM productos
                    WHERE idTienda = ? AND isActive = 1
                ) p ON c.idCategoria = p.idCategoria
                WHERE c.idTienda = ? AND (p.idCategoria IS NOT NULL OR c.idCategoria IS NULL)
                ORDER BY nombre ASC";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $managedStore, $managedStore);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

        return $data;
    }

    function getTiendasOwner($conn, $idUsuario)
    {
        $sql  = "SELECT * FROM tiendas WHERE administradoPor = ? AND isActive = 1";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $idUsuario);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $count  = mysqli_num_rows($result);

        if ($count === 0) 
        {
            return false;
        } 
        else 
        {
            $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $data;
        }
    }

    function cargarComprobante($conn, $idCliente, $idPedido)
    { 
       
        $salida = false;
        // if ($FILES['fileToUpload']['size'] <= 0)
        // {
        //     return true;
        //     exit;
        // }

        // Apunta a la carpeta del pedido
        $target_dir = "users/" . $idCliente . "/pedidos/" . $idPedido . "/";

        if (!is_dir($target_dir)) 
        {
            mkdir($target_dir, 0777, true);
        }

        $target_file = $target_dir . "comprobantePago." . strtolower(pathinfo($_FILES['fileToUpload']['name'], PATHINFO_EXTENSION));
        $extension = strtolower(pathinfo($_FILES['fileToUpload']['name'], PATHINFO_EXTENSION));
        // Apunta al arhivo: "verifica/usr_docs/idCliente/Pagos/idPedido.ext"

        $uploadOk = 1;

        if(!is_dir($target_dir))
        {
            mkdir($target_dir, 0777, true);
        }

        // Allow certain file formats
        $allowedExt = Array('jpg', 'png', 'jpeg', 'pdf', 'webp');

        if(!in_array($extension, $allowedExt))
        {
            $msg = "Sólo se admiten archivos 'jpg', 'png', 'jpeg', 'pdf' y 'webp'";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0)
        {
            return false;
            exit();
            // if everything is ok, try to upload file
        }
        else
        {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
            {
                // echo "The file **" . $idPedido . "." . strtolower(pathinfo($_FILES['fileToUpload']['name'], PATHINFO_EXTENSION)) . "** has been uploaded.";
                $nombre = "comprobantePago." . strtolower(pathinfo($_FILES['fileToUpload']['name'], PATHINFO_EXTENSION));
                return $nombre;
                exit();
            }
            else
            {
                // echo "Sorry, there was an error uploading your file.";
                return false;
                exit();
            }
        }

    }
    
    function obtenerGafetesComprados($conn, $idUsuario)
    {
        $registros = array();
    
        // Consulta SQL para seleccionar los registros
        $sql = "SELECT * FROM tabla_gafetes WHERE idUsuario = ? AND isPurchased = 1";
        
        // Preparar la consulta
        $stmt = $conn->prepare($sql);
        
        // Vincular el parámetro
        $stmt->bind_param("s", $idUsuario);
        
        // Ejecutar la consulta
        $stmt->execute();
        
        // Obtener el resultado
        $result = $stmt->get_result();
        
        // Recorrer los resultados y almacenarlos en un array
        while ($row = $result->fetch_assoc()) {
            $registros[] = $row;
        }
    
        // Cerrar la consulta
        $stmt->close();
    
        return $registros;
    }

    function obtenerGafetesNoComprados($conn, $idUsuario)
    {
        $registros = array();
    
        // Consulta SQL para seleccionar los registros
        $sql = "SELECT * FROM tabla_gafetes WHERE idUsuario = ? AND isPurchased = 0";
        
        // Preparar la consulta
        $stmt = $conn->prepare($sql);
        
        // Vincular el parámetro
        $stmt->bind_param("s", $idUsuario);
        
        // Ejecutar la consulta
        $stmt->execute();
        
        // Obtener el resultado
        $result = $stmt->get_result();
        
        // Recorrer los resultados y almacenarlos en un array
        while ($row = $result->fetch_assoc()) {
            $registros[] = $row;
        }
    
        // Cerrar la consulta
        $stmt->close();
    
        return $registros;
    }
    
    function subirArchivo($nombreCampo, $directorioDestino) 
    {
        // Verificar si el archivo se envió correctamente
        if (isset($_FILES[$nombreCampo]) && $_FILES[$nombreCampo]['error'] === UPLOAD_ERR_OK) 
        {
            $nombreArchivo = $_FILES[$nombreCampo]['name'];
            $rutaArchivo = $directorioDestino . $nombreArchivo;
            
            // Validar el tipo de archivo permitido (puedes ajustar esta lista según tus necesidades)
            $extensionesPermitidas = array('jpg', 'jpeg', 'png', 'gif', 'webp', 'heic');
            $extensionArchivo = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
            if (!in_array(strtolower($extensionArchivo), $extensionesPermitidas)) 
            {
                return null; // El tipo de archivo no está permitido
            }
            
            // Sanitizar el nombre de archivo para eliminar caracteres no deseados
            $nombreArchivo = preg_replace("/[^a-zA-Z0-9.-_]/", "", $nombreArchivo);
    
            // Generar un nombre de archivo único para evitar posibles conflictos
            $nombreArchivoUnico = uniqid() . '_' . $nombreArchivo;
            $rutaArchivoUnico = $directorioDestino . $nombreArchivoUnico;
    
            // Mover el archivo subido a la ubicación deseada
            if (move_uploaded_file($_FILES[$nombreCampo]['tmp_name'], $rutaArchivoUnico)) 
            {
                // Devuelve el nombre del archivo si se subió correctamente
                return $nombreArchivoUnico;
            }
        }
        return null; // Devuelve null si hubo un error al subir el archivo
    }
    
    
    function registrarAsistencia($conn, $idUsuario, $evento_id) 
    {
        // Verificar si el usuario ya tiene un registro para este evento
        $sql = "SELECT * FROM registro_asistencia WHERE usuario_id = ? AND evento_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $idUsuario, $evento_id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Si no hay un registro existente, crea uno nuevo
        if ($result->num_rows === 0) 
        {
            $fechaHoraRegistro = date("Y-m-d H:i:s");
            $sql = "INSERT INTO registro_asistencia (usuario_id, evento_id, fecha_hora_registro) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $idUsuario, $evento_id, $fechaHoraRegistro);
    
            if ($stmt->execute()) 
            {
                return true; // El registro de asistencia se creó exitosamente
            } else {
                return false; // Hubo un error al crear el registro
            }
        } 
        else 
        {
            return false; // El usuario ya tiene un registro para este evento
        }
    }
        
    function getAccesoVisitante($conn, $idUsuario, $evento_id)
    {
        // Consulta SQL para buscar un registro del usuario para el evento especificado
        $sql = "SELECT * FROM registro_asistencia WHERE usuario_id = ? AND evento_id = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $idUsuario, $evento_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Comprobar si se encontró un registro
        if ($result->num_rows > 0) 
        {
            // Si se encontró un registro, devolver un array con los datos
            //return $result->fetch_assoc();
            $array = $result->fetch_assoc();

            //var_dump($array);            
            return $array;
            
        } 
        else 
        {
            // Si no se encontró un registro, devolver false
            return false;
        }
    }

    // Función para buscar mascotas por idOwner y devolver un array con los resultados
    function buscarMascotasPorIdOwner($conn, $idOwner)
    {
        // Preparar la consulta
        $query = "SELECT * FROM `mascotas` WHERE idOwner = '$idOwner' AND isActive=1";

        // Ejecutar la consulta
        $result = mysqli_query($conn, $query);

        // Verificar si se encontraron resultados
        if (mysqli_num_rows($result) > 0) {
            // Array para almacenar los resultados
            $mascotas = array();

            // Recorrer los resultados y añadirlos al array
            while ($row = mysqli_fetch_assoc($result)) {
                $mascotas[] = $row;
            }

            // Devolver el array de mascotas
            return $mascotas;
        } else {
            // Si no se encontraron resultados, devolver un array vacío
            return false;
        }
    }

    function generarIdMascota($conn)
    {
        $sql = "SELECT idMascota FROM mascotas ORDER BY id DESC LIMIT 1";
        $result = $conn->query($sql);

        $newIdNumber = 1; // Valor predeterminado si no hay registros en la tabla

        if ($result->num_rows > 0) {
            $lastId = $result->fetch_assoc()['idMascota'];
            $lastIdParts = explode('MSP', $lastId);
            $newIdNumber = intval($lastIdParts[1]) + 1;
        }

        $newIdMascota = "MSP" . $newIdNumber;
        return $newIdMascota;
    }

    function cargarFotoMascota($conn, $idCliente, $idMascota)
    { 
       
        $salida = false;
        // if ($FILES['fileToUpload']['size'] <= 0)
        // {
        //     return true;
        //     exit;
        // }

        // Apunta a la carpeta del pedido
        $target_dir = "users/" . $idCliente . "/mascotas/" . $idMascota . "/";

        if (!is_dir($target_dir)) 
        {
            mkdir($target_dir, 0777, true);
        }

        $target_file = $target_dir . "foto." . strtolower(pathinfo($_FILES['fotoMascota']['name'], PATHINFO_EXTENSION));
        $extension = strtolower(pathinfo($_FILES['fotoMascota']['name'], PATHINFO_EXTENSION));
        // Apunta al arhivo: "verifica/usr_docs/idCliente/Pagos/idPedido.ext"

        $uploadOk = 1;

        if(!is_dir($target_dir))
        {
            mkdir($target_dir, 0777, true);
        }

        // Allow certain file formats
        $allowedExt = Array('jpg', 'png', 'jpeg', 'webp');

        if(!in_array($extension, $allowedExt))
        {
            $msg = "Sólo se admiten archivos 'jpg', 'png', 'jpeg', y 'webp'";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0)
        {
            return false;
            exit();
            // if everything is ok, try to upload file
        }
        else
        {
            if (move_uploaded_file($_FILES["fotoMascota"]["tmp_name"], $target_file))
            {
                // echo "The file **" . $idPedido . "." . strtolower(pathinfo($_FILES['fotoMascota']['name'], PATHINFO_EXTENSION)) . "** has been uploaded.";
                $nombre = "foto." . strtolower(pathinfo($_FILES['fotoMascota']['name'], PATHINFO_EXTENSION));
                return $nombre;
                exit();
            }
            else
            {
                // echo "Sorry, there was an error uploading your file.";
                return false;
                exit();
            }
        }

    }

    // REENVIO DE CORREO DE ACTIVACION
    function reenvioActivacion()
    {        
        if (isset($_POST['email']) && isset($_POST['btnEnvioActivacion']))
        {
            // Almaceno email y limpio el dato
            $email = limpiarDato($_POST['email']);

            //Genero Token para activar la cuenta
            $token = substr(str_shuffle("0123456789"), 0, 4);
            //$token = base64_encode(openssl_random_pseudo_bytes(4));

            // Genero el link que se enviará al correo, $urlActivacion en config.php
            $linkActivacion = "<a href=' " . $urlActivacion . "app/verifica/index.php?email=". $email ."&token=". encodeToken($token) ."'>Activar ahora</a>";

            // Ahora ingreso los valores previamente preparados
            $inserto_usuario = mysqli_query($conn, "UPDATE `usuarios` SET `token` = '$token' WHERE email = '$email'");

            // Verifico errores y preparo mensajes
            if($inserto_usuario === TRUE)
            {
                $emailRecipiente  = $email;
                $nombreRecipiente = $email;
                $tituloCorreo 	  = "Activa tu cuenta vendy";
                $cuerpoCorreo	  = '<!DOCTYPE html<html lang="es" dir="ltr<head><meta charset="utf-8"><title></title></head><body>';
                $cuerpoCorreo	 .= "¡Felicidades! Estás a un paso de crear tu tienda vendy, usa el siguiente código para activar tu cuenta o da click en el enlace para activar tu cuenta: <br><br><b>" . $linkActivacion . "</b><br><br>Saludos.";
                $cuerpoCorreo    .= "</body></html>";

                enviaEmail($emailRecipiente, $nombreRecipiente, $tituloCorreo, $cuerpoCorreo);
                $message = "envioActivacionExitoso";
            }
            else
            {
                $message = "errorActivacion";
            }

            exit(header('Location: index.php?msg=' . $message));

        }       
    }
    // FIN REENVIO DE CORREO DE ACTIVACION

    function getDatosUsuario($conn, $idCliente)
    {
        // Consulta previa para obtener los resultados
        $sql = "SELECT * FROM usuarios WHERE email = ?";
        if ($stmt = $conn->prepare($sql)) 
        {
            $stmt->bind_param("s", $idCliente);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) 
            {
                $row = $result->fetch_assoc();
                return $row;
            } 
            else 
            { 
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    function generarTokenActivacion() 
    {
        $token = '';
  
        for ($i = 0; $i < 4; $i++) 
        {
            $randomDigit = random_int(0, 9);
            $token .= $randomDigit;
        }
        
        return $token;
    }

    function obtenerDatosDeContacto($conn, $idMascota) 
    {
        $query = "SELECT * FROM datosDeContacto WHERE idMascota = '$idMascota' ORDER BY idMediosDeContacto DESC, fechaRegistro ASC";
        $result = mysqli_query($conn, $query);
        
        if (!$result || mysqli_num_rows($result) === 0) {
            return false;
        }
        
        $registros = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $registros[] = $row;
        }
        
        return $registros;
    }    
    
    function registraComprobante($conn, $nombreComprobante, $idPedido, $idCliente, $fechaPago)
    {

        // Registra el comprobante de pago cargado al servidor + datos del pedido
        $sql = "UPDATE pedidos SET
                    idEstatusPedido = 'EP-2',
                    fechaPago = '$fechaPago',
                    comprobantePago = '$nombreComprobante'
                WHERE
                    idPedido  = '$idPedido'
                AND
                    idCliente = '$idCliente'";

        $response = false;
        if (mysqli_query($conn, $sql))
        {
            //echo "New record created successfully";
            $response = true;
        }
        return $response;

    }

    function getProductosComprados($conn, $idPedido, $idCliente)
    {
        $sql = "SELECT
                    pedidos.*,
                    tabla_gafetes.*
                FROM
                    pedidos
                INNER JOIN tabla_gafetes ON
                    tabla_gafetes.idPedido = pedidos.idPedido
                WHERE
                    pedidos.idPedido = '$idPedido'";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0)
        {
            // output data of each row
            while($row = mysqli_fetch_assoc($result))
            {
                $data[]= $row;
            }

            return $data;
        }
        else
        {
            return false;
        }
    }

    function getDatosPedido($conn, $idPedido, $idCliente)
    {
        $sql = "SELECT
                    pedidos.*,
                    CAT_estatusPedido.nombre AS estatusEnvio
                FROM
                    pedidos
                INNER JOIN CAT_estatusPedido ON pedidos.idEstatusPedido = CAT_estatusPedido.idEstatus
                WHERE
                    pedidos.idCliente = '$idCliente' AND pedidos.idPedido = '$idPedido' AND pedidos.isActive = 1";

        $result = mysqli_query($conn, $sql);

        if (!$result)
        {
            return false;
        }

        $data = array();

        while ($row = mysqli_fetch_assoc($result))
        {
            $data = $row;
        }

        return $data;
    }
    
    function generarIdPedido($conn)
    {
        // Obtenemos el último idPedido y generamos un nuevo ID de pedido
        $sql = "SELECT idPedido FROM pedidos ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $newNumber = 0;
        
        if (mysqli_num_rows($result) > 0)
        {
            $row = mysqli_fetch_assoc($result);
            $lastIdPedido = $row["idPedido"];
            $lastIdPedido = explode("CD", $lastIdPedido);
            $lastNumber = (int) $lastIdPedido[1];
            $newNumber = $lastNumber + 1;
            $idPedido = "CD" . $newNumber;
        }
        else
        {
            $idPedido = "CD1";
        }

        return $idPedido;
    }


    function getEnviosTienda($conn)
    {
        $sql = "SELECT
        *
        FROM
            enviosTienda
        WHERE
            enviosTienda.isActive = 1
        ORDER BY
            enviosTienda.precioEnvio ASC";

        $stmt = $conn->prepare($sql);

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
            return $data;
        } else {
            return false;
        }

    }

    function getCategoriasTienda($conn, $managedStore)
    {
        $sql = "SELECT c.idCategoria, c.nombre, COUNT(p.id) AS numProductos
                FROM categoriasTienda c
                LEFT JOIN productos p ON c.idCategoria = p.idCategoria AND p.idTienda = ?
                WHERE c.idTienda = ?
                GROUP BY c.idCategoria, c.nombre
                ORDER BY c.nombre ASC, COUNT(p.id) ASC";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $managedStore, $managedStore);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

        return $data;
    }
    

    function getGeneralesMascota($conn, $idMascota)
    {
        // Preparar la consulta
        $query = "SELECT * FROM `mascotas` WHERE idMascota = '$idMascota'";

        // Ejecutar la consulta
        $result = mysqli_query($conn, $query);

        // Verificar si se encontraron resultados
        if (mysqli_num_rows($result) > 0) 
        {
            // Array para almacenar los resultados
            $mascotas = array();

            // Recorrer los resultados y añadirlos al array
            while ($row = mysqli_fetch_assoc($result)) 
            {
                $mascotas = $row;
            }

            // Devolver el array de mascotas
            return $mascotas;
        } 
        else 
        {
            // Si no se encontraron resultados, devolver un array vacío
            return false;
        }
    }



    function generarBarcode($conn, $idTienda)
    {
        $codigoInicial = "8828000000001";
        $query = "SELECT barcode FROM productos WHERE idTienda = ? ORDER BY barcode DESC LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $idTienda);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            $ultimoCodigo = $row["barcode"];
            $ultimoNumero = substr($ultimoCodigo, 4);
            $nuevoNumero = strval(intval($ultimoNumero) + 1);
            $nuevoCodigo = "8828" . str_pad($nuevoNumero, strlen($ultimoNumero), "0", STR_PAD_LEFT);
            return $nuevoCodigo;
        }
        else
        {
            return $codigoInicial;
        }
    }

    

    function generaIdDireccionEntrega($conn, $idCliente)
    {
        // Obtenemos ultimo idPedido y generamos nuevo ID de pedido
        $sql = "SELECT * FROM direccionesClientes WHERE idCliente = '$idCliente' AND isActive = 1 ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0)
        {
            // output data of each row
            while($row = mysqli_fetch_assoc($result))
            {
                //echo "Ultimo pedido: " . $row["idPedido"] . "<br>";
                $lastIdPedido    = $row["idDireccion"];
                $lastIdPedido    = explode("-", $lastIdPedido);
                $lastIdPedido[1] += 1;
                $idPedido        = $lastIdPedido[0] . "-" . $lastIdPedido[1];
            }
        }
        else
        {
            $idPedido = "DC-1";
        }

        return $idPedido;
    }

    function generaIdPedido($conn)
    {

        // Obtenemos ultimo idPedido y generamos nuevo ID de pedido
        $sql = "SELECT * FROM pedidos ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0)
        {
            // output data of each row
            while($row = mysqli_fetch_assoc($result))
            {
                //echo "Ultimo pedido: " . $row["idPedido"] . "<br>";
                $lastIdPedido    = $row["idPedido"];
                $lastIdPedido    = explode("-", $lastIdPedido);
                $lastIdPedido[1] += 1;
                $idPedido        = $lastIdPedido[0] . "-" . $lastIdPedido[1];
            }
        }
        else
        {
            $idPedido = "V-1";
        }

        return $idPedido;
    }

    function plantillaPedidoEnviado($idPedido)
    {

        $data = '<!DOCTYPE html>
        <html lang="es" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">
        <head>
        <title></title>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <!--[if mso]><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch><o:AllowPNG/></o:OfficeDocumentSettings></xml><![endif]-->
        <!--[if !mso]><!-->
        <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet" type="text/css"/>
        <link href="https://fonts.googleapis.com/css?family=Bitter" rel="stylesheet" type="text/css"/>
        <link href="https://fonts.googleapis.com/css?family=Droid+Serif" rel="stylesheet" type="text/css"/>
        <link href="https://fonts.googleapis.com/css?family=Permanent+Marker" rel="stylesheet" type="text/css"/>
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet" type="text/css"/>
        <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet" type="text/css"/>
        <link href="https://fonts.googleapis.com/css?family=Cabin" rel="stylesheet" type="text/css"/>
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css"/>
        <link href="https://fonts.googleapis.com/css?family=Oxygen" rel="stylesheet" type="text/css"/>
        <!--<![endif]-->
        <style>
                * {
                    box-sizing: border-box;
                }

                body {
                    margin: 0;
                    padding: 0;
                }

                a[x-apple-data-detectors] {
                    color: inherit !important;
                    text-decoration: inherit !important;
                }

                #MessageViewBody a {
                    color: inherit;
                    text-decoration: none;
                }

                p {
                    line-height: inherit
                }

                .desktop_hide,
                .desktop_hide table {
                    mso-hide: all;
                    display: none;
                    max-height: 0px;
                    overflow: hidden;
                }

                @media (max-width:670px) {

                    .desktop_hide table.icons-inner,
                    .row-2 .column-1 .block-5.button_block .alignment div {
                        display: inline-block !important;
                    }

                    .icons-inner {
                        text-align: center;
                    }

                    .icons-inner td {
                        margin: 0 auto;
                    }

                    .image_block img.big,
                    .row-content {
                        width: 100% !important;
                    }

                    .mobile_hide {
                        display: none;
                    }

                    .stack .column {
                        width: 100%;
                        display: block;
                    }

                    .mobile_hide {
                        min-height: 0;
                        max-height: 0;
                        max-width: 0;
                        overflow: hidden;
                        font-size: 0px;
                    }

                    .desktop_hide,
                    .desktop_hide table {
                        display: table !important;
                        max-height: none !important;
                    }

                    .row-2 .column-1 .block-5.button_block a span,
                    .row-2 .column-1 .block-5.button_block div,
                    .row-2 .column-1 .block-5.button_block div span {
                        line-height: 1.5 !important;
                    }

                    .row-2 .column-1 .block-5.button_block .alignment {
                        text-align: left !important;
                    }
                }
            </style>
        </head>
        <body style="background-color: #315d4e; margin: 0; padding: 0; -webkit-text-size-adjust: none; text-size-adjust: none;">
        <table border="0" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #315d4e;" width="100%">
        <tbody>
        <tr>
        <td>
        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-size: auto;" width="100%">
        <tbody>
        <tr>
        <td>
        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-size: auto; background-color: #ffffff; color: #000000; width: 650px;" width="650">
        <tbody>
        <tr>
        <td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-left: 10px; padding-right: 10px; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
        <table border="0" cellpadding="0" cellspacing="0" class="heading_block block-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
        <tr>
        <td class="pad" style="text-align:center;width:100%;">
        <h1 style="margin: 0; color: #754aff; direction: ltr; font-family: "Cabin", Arial, "Helvetica Neue", Helvetica, sans-serif; font-size: 33px; font-weight: 700; letter-spacing: normal; line-height: 120%; text-align: center; margin-top: 0; margin-bottom: 0;"><a href="httsp://mayoristapp.mx" rel="noopener" style="color: #754aff;" target="_blank">mayoristapp.mx</a></h1>
        </td>
        </tr>
        </table>
        <table border="0" cellpadding="0" cellspacing="0" class="divider_block block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
        <tr>
        <td class="pad" style="padding-bottom:10px;padding-left:10px;padding-right:10px;padding-top:20px;">
        <div align="center" class="alignment">
        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="10%">
        <tr>
        <td class="divider_inner" style="font-size: 1px; line-height: 1px; border-top: 5px solid #C3C3C0;"><span> </span></td>
        </tr>
        </table>
        </div>
        </td>
        </tr>
        </table>
        <table border="0" cellpadding="0" cellspacing="0" class="heading_block block-3" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
        <tr>
        <td class="pad" style="padding-bottom:20px;padding-top:20px;text-align:center;width:100%;">
        <h1 style="margin: 0; color: #414341; direction: ltr; font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Tahoma, sans-serif; font-size: 25px; font-weight: 700; letter-spacing: normal; line-height: 120%; text-align: center; margin-top: 0; margin-bottom: 0;">Tu pedido ' . $idPedido .' ha sido enviado</h1>
        </td>
        </tr>
        </table>
        <table border="0" cellpadding="0" cellspacing="0" class="image_block block-4" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
        <tr>
        <td class="pad" style="width:100%;padding-right:0px;padding-left:0px;">
        <div align="center" class="alignment" style="line-height:10px"><img alt="Pedido Enviado" class="big" src="https://mayoristapp.mx/app/assets/img/mail/pedido-enviado.png" style="display: block; height: auto; border: 0; width: 441px; max-width: 100%;" title="Pedido Enviado" width="441"/></div>
        </td>
        </tr>
        </table>
        <table border="0" cellpadding="0" cellspacing="0" class="button_block block-5" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
        <tr>
        <td class="pad" style="padding-bottom:40px;padding-top:30px;text-align:center;">
        <div align="center" class="alignment">
        <!--[if mso]><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="https://mayoristapp.mx/app/detalleCompra.php?id=';

            $data .= $idPedido;
            $data .='" style="height:56px;width:180px;v-text-anchor:middle;" arcsize="9%" stroke="false" fillcolor="#4f7eef"><w:anchorlock/><v:textbox inset="0px,0px,0px,0px"><center style="color:#ffffff; font-family:Arial, sans-serif; font-size:18px"><![endif]-->

            <a href="https://mayoristapp.mx/app/detalleCompra.php?id=';

            $data .= $idPedido;
            $data .= '" style="text-decoration:none;display:inline-block;color:#ffffff;background-color:#4f7eef;border-radius:5px;width:auto;border-top:0px solid transparent;font-weight:400;border-right:0px solid transparent;border-bottom:0px solid transparent;border-left:0px solid transparent;padding-top:10px;padding-bottom:10px;font-family:Oswald, Arial, Helvetica Neue, Helvetica, sans-serif;font-size:18px;text-align:center;mso-border-alt:none;word-break:keep-all;" target="_blank">
                    <span style="padding-left:20px;padding-right:20px;font-size:18px;display:inline-block;letter-spacing:normal;">
                            <span dir="ltr" style="word-break: break-word; line-height: 36px;">
                            Ver estado del pedido
                            </span>
                    </span>
            </a>
        <!--[if mso]></center></v:textbox></v:roundrect><![endif]-->
        </div>
        </td>
        </tr>
        </table>
        </td>
        </tr>
        </tbody>
        </table>
        </td>
        </tr>
        </tbody>
        </table>
        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-size: auto;" width="100%">
        <tbody>
        <tr>
        <td>
        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-size: auto; background-color: #26c565; color: #000000; background-repeat: no-repeat; border-radius: 0; width: 650px;" width="650">
        <tbody>
        <tr>
        <td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-left: 10px; padding-right: 10px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="50%">
        <table border="0" cellpadding="0" cellspacing="0" class="heading_block block-3" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
        <tr>
        <td class="pad" style="padding-bottom:5px;padding-left:20px;padding-right:20px;padding-top:45px;text-align:center;width:100%;">
        <h1 style="margin: 0; color: #ffffff; direction: ltr; font-family: Oswald, Arial, Helvetica Neue, Helvetica, sans-serif; font-size: 28px; font-weight: 400; letter-spacing: normal; line-height: 120%; text-align: left; margin-top: 0; margin-bottom: 0;"><span class="tinyMce-placeholder">Crea tu tienda en línea</span></h1>
        </td>
        </tr>
        </table>
        <table border="0" cellpadding="0" cellspacing="0" class="paragraph_block block-4" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
        <tr>
        <td class="pad" style="padding-bottom:20px;padding-left:20px;padding-right:10px;padding-top:10px;">
        <div style="color:#ffffff;direction:ltr;font-family:"Cabin", Arial, "Helvetica Neue", Helvetica, sans-serif;font-size:14px;font-weight:400;letter-spacing:0px;line-height:150%;text-align:left;mso-line-height-alt:21px;">
        <p style="margin: 0;">Administra tu inventario, vende en tienda física con la función punto de venta, estadísticas de tu negocio y mucho más.</p>
        </div>
        </td>
        </tr>
        </table>
        <table border="0" cellpadding="0" cellspacing="0" class="button_block block-5" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
        <tr>
        <td class="pad" style="padding-left:20px;padding-right:20px;text-align:left;padding-bottom:20px;">
        <div align="left" class="alignment">
        <!--[if mso]><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="https://mayoristapp.mx/#registro" style="height:44px;width:152px;v-text-anchor:middle;" arcsize="19%" stroke="false" fillcolor="#dbe430"><w:anchorlock/><v:textbox inset="0px,0px,0px,0px"><center style="color:#000000; font-family:Arial, sans-serif; font-size:16px"><![endif]-->
            <a href="https://mayoristapp.mx/#registro" style="text-decoration:none;display:inline-block;color:#000000;background-color:#dbe430;border-radius:8px;width:auto;border-top:0px solid transparent;font-weight:400;border-right:0px solid transparent;border-bottom:0px solid transparent;border-left:0px solid transparent;padding-top:10px;padding-bottom:10px;font-family:Oswald, Arial, Helvetica Neue, Helvetica, sans-serif;font-size:16px;text-align:center;mso-border-alt:none;word-break:keep-all;" target="_blank">
                    <span style="padding-left:25px;padding-right:25px;font-size:16px;display:inline-block;letter-spacing:normal;">
                            <span dir="ltr" style="word-break: break-word; line-height: 24px;">
                                    CREAR MI TIENDA
                            </span>
                    </span>
            </a>
        <!--[if mso]></center></v:textbox></v:roundrect><![endif]-->
        </div>
        </td>
        </tr>
        </table>
        </td>
        <td class="column column-2" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="50%">
        <table border="0" cellpadding="0" cellspacing="0" class="image_block block-3" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
        <tr>
        <td class="pad" style="width:100%;padding-right:0px;padding-left:0px;padding-top:25px;">
        <div align="center" class="alignment" style="line-height:10px"><img alt="Back to School" src="https://mayoristapp.mx/app/assets/img/mail/tienda-ejemplo.png" style="display: block; height: auto; border: 0; width: 146px; max-width: 100%;" title="Back to School" width="146"/></div>
        </td>
        </tr>
        </table>
        </td>
        </tr>
        </tbody>
        </table>
        </td>
        </tr>
        </tbody>
        </table>
        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-3" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
        <tbody>
        <tr>
        <td>
        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #26c565; border-radius: 0; color: #000000; width: 650px;" width="650">
        <tbody>
        <tr>
        <td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
        <table border="0" cellpadding="0" cellspacing="0" class="divider_block block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
        <tr>
        <td class="pad" style="padding-top:25px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
        <div align="center" class="alignment">
        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="10%">
        <tr>
        <td class="divider_inner" style="font-size: 1px; line-height: 1px; border-top: 6px solid #FFFFFF;"><span> </span></td>
        </tr>
        </table>
        </div>
        </td>
        </tr>
        </table>
        </td>
        </tr>
        </tbody>
        </table>
        </td>
        </tr>
        </tbody>
        </table>
        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-4" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
        <tbody>
        <tr>
        <td>
        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #26c565; color: #000000; width: 650px;" width="650">
        <tbody>
        <tr>
        <td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
        <table border="0" cellpadding="10" cellspacing="0" class="text_block block-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
        <tr>
        <td class="pad">
        <div style="font-family: Tahoma, Verdana, sans-serif">
        <div class="" style="font-size: 12px; font-family: "Ubuntu", Tahoma, Verdana, Segoe, sans-serif; mso-line-height-alt: 14.399999999999999px; color: #ffffff; line-height: 1.2;">
        <p style="margin: 0; font-size: 16px; text-align: center; mso-line-height-alt: 19.2px;"><span style="font-size:26px;"><strong><a href="httsp://mayoristapp.mx" rel="noopener" style="color: #ffffff;" target="_blank">mayoristapp.mx</a></strong></span><span style="font-size:18px;"><a href="httsp://mayoristapp.mx" rel="noopener" style="text-decoration: underline; color: #ffffff;" target="_blank"></a></span></p>
        </div>
        </div>
        </td>
        </tr>
        </table>
        </td>
        </tr>
        </tbody>
        </table>
        </td>
        </tr>
        </tbody>
        </table>
        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-5" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
        <tbody>
        <tr>
        <td>
        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #26c565; border-radius: 0; color: #000000; width: 650px;" width="650">
        <tbody>
        <tr>
        <td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
        <div class="spacer_block" style="height:15px;line-height:15px;font-size:1px;"> </div>
        </td>
        </tr>
        </tbody>
        </table>
        </td>
        </tr>
        </tbody>
        </table>
        </td>
        </tr>
        </tbody>
        </table><!-- End -->
        </body>
        </html>';

        return $data;

    }

    function plantillaOrdenConfirmada($idPedido, $fechaPedido, $reqEnvio, $direccionPedido, $subtotal, $descuento, $envio, $total, $getDatosContactoVendedor, $datosBancariosCorreo)
    {

    $data = '<!DOCTYPE html>
    <html lang="es" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">
    <head>
    <title></title>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <!--[if mso]><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch><o:AllowPNG/></o:OfficeDocumentSettings></xml><![endif]-->
    <!--[if !mso]><!-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css"/>
    <!--<![endif]-->
    <style>
            * {
                box-sizing: border-box;
            }

            body {
                margin: 0;
                padding: 0;
            }

            a[x-apple-data-detectors] {
                color: inherit !important;
                text-decoration: inherit !important;
            }

            #MessageViewBody a {
                color: inherit;
                text-decoration: none;
            }

            p {
                line-height: inherit
            }

            .desktop_hide,
            .desktop_hide table {
                mso-hide: all;
                display: none;
                max-height: 0px;
                overflow: hidden;
            }

            @media (max-width:700px) {

                .desktop_hide table.icons-inner,
                .row-16 .column-1 .block-6.social_block .alignment table,
                .row-4 .column-2 .block-2.button_block .alignment div,
                .row-6 .column-1 .block-3.button_block .alignment div,
                .social_block.desktop_hide .social-table {
                    display: inline-block !important;
                }

                .icons-inner {
                    text-align: center;
                }

                .icons-inner td {
                    margin: 0 auto;
                }

                .image_block img.big,
                .row-content {
                    width: 100% !important;
                }

                .mobile_hide {
                    display: none;
                }

                .stack .column {
                    width: 100%;
                    display: block;
                }

                .mobile_hide {
                    min-height: 0;
                    max-height: 0;
                    max-width: 0;
                    overflow: hidden;
                    font-size: 0px;
                }

                .desktop_hide,
                .desktop_hide table {
                    display: table !important;
                    max-height: none !important;
                }

                .row-1 .column-1 .block-2.heading_block td.pad {
                    padding: 15px !important;
                }

                .row-3 .column-1 .block-2.text_block td.pad {
                    padding: 15px 10px 10px 15px !important;
                }

                .row-4 .column-2 .block-2.button_block a span,
                .row-4 .column-2 .block-2.button_block div,
                .row-4 .column-2 .block-2.button_block div span,
                .row-6 .column-1 .block-3.button_block a span,
                .row-6 .column-1 .block-3.button_block div,
                .row-6 .column-1 .block-3.button_block div span {
                    line-height: 2 !important;
                }

                .row-16 .column-1 .block-6.social_block .alignment,
                .row-4 .column-2 .block-2.button_block .alignment,
                .row-6 .column-1 .block-3.button_block .alignment {
                    text-align: center !important;
                }

                .row-11 .column-1 .block-2.text_block td.pad {
                    padding: 10px 0 10px 25px !important;
                }

                .row-16 .column-1 .block-6.social_block td.pad {
                    padding: 0 0 0 20px !important;
                }

                .row-3 .column-1 {
                    padding: 5px 20px 0 !important;
                }
            }
        </style>
    </head>
    <body style="margin: 0; background-color: #3333d3; padding: 0; -webkit-text-size-adjust: none; text-size-adjust: none;">
    <table border="0" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #3333d3;" width="100%">
    <tbody>
    <tr>
    <td>
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
    <tbody>
    <tr>
    <td>
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #3333d3; color: #000000; border-radius: 4px; width: 680px;" width="680">
    <tbody>
    <tr>
    <td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
    <table border="0" cellpadding="0" cellspacing="0" class="heading_block block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
    <tr>
    <td class="pad" style="text-align:center;width:100%;padding-top:40px;">
    <h1 style="margin: 0; color: #ffffff; direction: ltr; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif; font-size: 38px; font-weight: 700; letter-spacing: normal; line-height: 120%; text-align: center; margin-top: 0; margin-bottom: 0;"><a href="mayoristapp.mx" rel="noopener" style="text-decoration: none; color: #ffffff;" target="_blank"><span class="tinyMce-placeholder">mayoristapp.mx</span></a></h1>
    </td>
    </tr>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" class="divider_block block-4" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
    <tr>
    <td class="pad" style="padding-bottom:10px;padding-left:10px;padding-right:10px;padding-top:30px;">
    <div align="center" class="alignment">
    <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="10%">
    <tr>
    <td class="divider_inner" style="font-size: 1px; line-height: 1px; border-top: 4px solid #FFFFFF;"><span> </span></td>
    </tr>
    </table>
    </div>
    </td>
    </tr>
    </table>
    <table border="0" cellpadding="10" cellspacing="0" class="text_block block-5" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
    <tr>
    <td class="pad">
    <div style="font-family: sans-serif">
    <div class="" style="font-size: 12px; mso-line-height-alt: 18px; color: #ffffff; line-height: 1.5; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
    <p style="margin: 0; font-size: 14px; text-align: center; mso-line-height-alt: 42px;"><span style="font-size:28px;">
        <strong>
            Confirmación de tu orden
            ' . $idPedido . '
        </strong></span></p>
    </div>
    </div>
    </td>
    </tr>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" class="text_block block-6" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
    <tr>
    <td class="pad" style="padding-bottom:35px;padding-left:10px;padding-right:10px;padding-top:10px;">
    <div style="font-family: sans-serif">
    <div class="" style="font-size: 12px; mso-line-height-alt: 21.6px; color: #ffffff; line-height: 1.8; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
    <p style="margin: 0; font-size: 14px; text-align: center; mso-line-height-alt: 32.4px;"><span style="font-size:18px;">¡Gracias por tu compra!</span></p>
    </div>
    </div>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #3333d3;" width="100%">
    <tbody>
    <tr>
    <td>
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px;" width="680">
    <tbody>
    <tr>
    <td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 0px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
    <table border="0" cellpadding="0" cellspacing="0" class="image_block block-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
    <tr>
    <td class="pad" style="width:100%;padding-right:0px;padding-left:0px;">
    <div align="center" class="alignment" style="line-height:10px"><img alt="Alternate text" class="big" src="https://mayoristapp.mx/app/assets/img/mail/plantillaOrdenConfirmada/round_corner.png" style="display: block; height: auto; border: 0; width: 680px; max-width: 100%;" title="Alternate text" width="680"/></div>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-3" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #3333d3;" width="100%">
    <tbody>
    <tr>
    <td>
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; border-radius: 0; width: 680px;" width="680">
    <tbody>
    <tr>
    <td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 0px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
    <table border="0" cellpadding="0" cellspacing="0" class="text_block block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
    <tr>
    <td class="pad" style="padding-bottom:10px;padding-left:35px;padding-right:10px;padding-top:35px;">
    <div style="font-family: sans-serif">
    <div class="" style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #030303; line-height: 1.2; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
    <p style="margin: 0; font-size: 14px; mso-line-height-alt: 16.8px;"><span style="font-size:18px;"><strong><span style="">Dirección de envío</span></strong></span></p>
    </div>
    </div>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-4" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #3333d3;" width="100%">
    <tbody>
    <tr>
    <td>
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; width: 680px;" width="680">
    <tbody>
    <tr>
    <td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="50%">
    <table border="0" cellpadding="0" cellspacing="0" class="text_block block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
    <tr>
    <td class="pad" style="padding-bottom:10px;padding-left:35px;padding-right:10px;padding-top:20px;">
    <div style="font-family: sans-serif">
    <div class="" style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #030303; line-height: 1.2; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
    <p style="margin: 0; font-size: 14px; mso-line-height-alt: 16.8px;"><span style="font-size:15px;color:#332f2f;"><strong>
            <span style="">
                    ' . $_SESSION["nombre"] . ' ' . $_SESSION["paterno"] . '
            </span>
    </strong></span></p>
    </div>
    </div>
    </td>
    </tr>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" class="text_block block-3" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
    <tr>
    <td class="pad" style="padding-left:35px;padding-right:10px;padding-top:10px;">
    <div style="font-family: sans-serif">
        <div class="" style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #626262; line-height: 1.2; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
                <p style="margin: 0; font-size: 14px; mso-line-height-alt: 16.8px;">';

                if ($reqEnvio == 0)
                {
                        $data .= $getDatosContactoVendedor['email'] . '<br>';
                }

                if (isset($direccionPedido[0]))
                {
                        $data .= $direccionPedido[0]["aliasDireccion"]  . ' <br><p> ' . $direccionPedido[0]["direccion"] . '</p>';
                }

                $data .= '
                </p>
        </div>
    </div>
    </td>
    </tr>
    </table>

    </td>
    <td class="column column-2" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="50%">
    <table border="0" cellpadding="0" cellspacing="0" class="button_block block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
    <tr>
    <td class="pad" style="padding-bottom:15px;padding-left:35px;padding-right:10px;padding-top:55px;text-align:left;">
    <div align="left" class="alignment">
    <!--[if mso]><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="https://mayoristapp.mx/app/detalleCompra.php?id='. $idPedido .'" style="height:42px;width:171px;v-text-anchor:middle;" arcsize="10%" stroke="false" fillcolor="#e17370"><w:anchorlock/><v:textbox inset="0px,0px,0px,0px"><center style="color:#ffffff; font-family:Tahoma, sans-serif; font-size:16px"><![endif]--><a href="https://mayoristapp.mx/app/detalleCompra.php?id='. $idPedido .'" style="text-decoration:none;display:inline-block;color:#ffffff;background-color:#e17370;border-radius:4px;width:auto;border-top:0px solid #E17370;font-weight:400;border-right:0px solid #E17370;border-bottom:0px solid #E17370;border-left:0px solid #E17370;padding-top:5px;padding-bottom:5px;font-family:Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;font-size:16px;text-align:center;mso-border-alt:none;word-break:keep-all;" target="_blank"><span style="padding-left:40px;padding-right:40px;font-size:16px;display:inline-block;letter-spacing:normal;"><span dir="ltr" style="word-break: break-word; line-height: 32px;">Ver Detalle </span></span></a>
    <!--[if mso]></center></v:textbox></v:roundrect><![endif]-->
    </div>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-5" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #3333d3;" width="100%">
    <tbody>
    <tr>
    <td>
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; width: 680px;" width="680">
    <tbody>
    <tr>
    <td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 0px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
    <table border="0" cellpadding="10" cellspacing="0" class="divider_block block-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
    <tr>
    <td class="pad">
    <div align="center" class="alignment">
    <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
    <tr>
    <td class="divider_inner" style="font-size: 1px; line-height: 1px; border-top: 1px solid #D6D3D3;"><span> </span></td>
    </tr>
    </table>
    </div>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-6" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
    <tbody>
    <tr>
    <td>
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; width: 680px;" width="680">
    <tbody>
    <tr>
    <td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
    <table border="0" cellpadding="0" cellspacing="0" class="text_block block-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
    <tr>
    <td class="pad" style="padding-bottom:10px;padding-left:35px;padding-right:10px;padding-top:15px;">
    <div style="font-family: sans-serif">
    <div class="" style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #030303; line-height: 1.2; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
    <p style="margin: 0; font-size: 14px; mso-line-height-alt: 16.8px;"><span style="font-size:18px;"><strong><span style="">¿Ya realizaste tu pago? 💵</span></strong></span></p>
    </div>
    </div>
    </td>
    </tr>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" class="paragraph_block block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
    <tr>
    <td class="pad" style="padding-bottom:15px;padding-left:35px;padding-right:35px;padding-top:15px;">
    <div style="color:#101112;direction:ltr;font-family:Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;font-size:15px;font-weight:400;letter-spacing:0px;line-height:120%;text-align:left;mso-line-height-alt:18px;">
    <p style="margin: 0;">Confirma tu pago al vendedor, carga tu comprobante desde tu cuenta vendy o envíaselo por whatsapp.</p>
    </div>
    </td>
    </tr>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" class="button_block block-3" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
    <tr>
    <td class="pad" style="padding-bottom:15px;padding-left:35px;padding-right:10px;padding-top:10px;text-align:left;">
    <div align="left" class="alignment">
    <!--[if mso]><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="https://mayoristapp.mx/app/detalleCompra.php?id=' . $idPedido . '" style="height:36px;width:189px;v-text-anchor:middle;" arcsize="12%" strokeweight="0.75pt" strokecolor="#E17370" fillcolor="#e17370"><w:anchorlock/><v:textbox inset="0px,0px,0px,0px"><center style="color:#ffffff; font-family:Tahoma, sans-serif; font-size:12px"><![endif]--><a href="https://mayoristapp.mx/app/detalleCompra.php?id=' . $idPedido . '" style="text-decoration:none;display:inline-block;color:#ffffff;background-color:#e17370;border-radius:4px;width:auto;border-top:1px solid #E17370;font-weight:400;border-right:1px solid #E17370;border-bottom:1px solid #E17370;border-left:1px solid #E17370;padding-top:5px;padding-bottom:5px;font-family:Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;font-size:12px;text-align:center;mso-border-alt:none;word-break:keep-all;" target="_blank"><span style="padding-left:30px;padding-right:30px;font-size:12px;display:inline-block;letter-spacing:normal;"><span dir="ltr" style="word-break: break-word; line-height: 24px;">Cargar comprobante</span></span></a>
    <!--[if mso]></center></v:textbox></v:roundrect><![endif]-->
    </div>
    </td>
    </tr>
    </table>
    <table border="0" cellpadding="10" cellspacing="0" class="divider_block block-4" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
    <tr>
    <td class="pad">
    <div align="center" class="alignment">
    <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
    <tr>
    <td class="divider_inner" style="font-size: 1px; line-height: 1px; border-top: 1px solid #D6D3D3;"><span> </span></td>
    </tr>
    </table>
    </div>
    </td>
    </tr>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" class="text_block block-5" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
    <tr>
    <td class="pad" style="padding-bottom:10px;padding-left:35px;padding-top:15px;">
    <div style="font-family: sans-serif">
    <div class="" style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #030303; line-height: 1.2; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
            <p style="margin: 0; font-size: 14px; mso-line-height-alt: 16.8px;">
                    <span style="font-size:18px;">
                            <strong>
                                    <span style="">
                                            Datos de pago
                                    </span>
                            </strong>
                    </span>
            </p>
    </div>
    </div>
    </td>
    </tr>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" class="paragraph_block block-6" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
    <tr>
    <td class="pad" style="padding-bottom:15px;padding-left:35px;padding-right:35px;padding-top:15px;">
    <div style="color:#101112;direction:ltr;font-family:Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;font-size:13px;font-weight:400;letter-spacing:0px;line-height:120%;text-align:left;mso-line-height-alt:15.6px;">
    <p style="margin: 0;">
            Vendedor: '. $getDatosContactoVendedor['nombre'] . ' ' . $getDatosContactoVendedor['paterno'] .'
    </p>
    </div>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-7" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
    <tbody>
    <tr>
    <td>
        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; width: 680px;" width="680">
        <tbody>
                <tr>';

                        foreach ($datosBancariosCorreo as $key => $value)
                        {

                    $cardS = str_split($value['numTarjeta'], 4);

                                $data .= '<td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="50%">
                                        <table border="0" cellpadding="0" cellspacing="0" class="text_block block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
                                                <tr>
                                                        <td class="pad" style="padding-bottom:15px;padding-left:35px;padding-right:30px;padding-top:15px;">
                                                                <div style="font-family: sans-serif">
                                                                        <div class="" style="font-size: 12px; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif; mso-line-height-alt: 14.399999999999999px; color: #555555; line-height: 1.2;">

                                                                                <p style="margin: 0; font-size: 14px; mso-line-height-alt: 14.399999999999999px;"> </p>
                                                                                <p style="margin: 0; font-size: 14px; mso-line-height-alt: 16.8px;"><span style="font-size:14px;">Banco: ' . $value['banco'] . '</span></p>
                                                                                <p style="margin: 0; font-size: 14px; mso-line-height-alt: 16.8px;"><span style="font-size:14px;">Tarjeta: ' . $cardS[0] . "&nbsp;" . $cardS[1] . "&nbsp;" . $cardS[2] . "&nbsp;" . $cardS[3]  . '</span></p>
                                                                                <p style="margin: 0; font-size: 14px; mso-line-height-alt: 16.8px;"><span style="font-size:14px;">Clabe: ' . $value['numClabe'] . '</span></p>

                                                                        </div>
                                                                </div>
                                                        </td>
                                                </tr>
                                        </table>
                                </td>';

                        }

                    $data .= '
                </tr>
        </tbody>
        </table>
        </td>
        </tr>
        </tbody>
        </table>

        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-8" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #3333d3;" width="100%">
            <tbody>
                <tr>
                    <td>
                        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; width: 680px;" width="680">
                            <tbody>
                                <tr>
                                    <td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 0px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">

                                        <table border="0" cellpadding="10" cellspacing="0" class="divider_block block-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                                            <tr>
                                                <td class="pad">
                                                    <div align="center" class="alignment">
                                                        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                                                            <tr>
                                                            <td class="divider_inner" style="font-size: 1px; line-height: 1px; border-top: 1px solid #D6D3D3;"><span> </span>
                                                            </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>

                                        <table border="0" cellpadding="0" cellspacing="0" class="text_block block-3" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
                                            <tr>
                                                <td class="pad" style="padding-bottom:10px;padding-left:35px;padding-right:10px;padding-top:25px;">
                                                    <div style="font-family: sans-serif">
                                                        <div class="" style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #030303; line-height: 1.2; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
                                                            <p style="margin: 0; font-size: 14px; mso-line-height-alt: 16.8px;">
                                                                <span style="font-size:18px;">
                                                                    <strong>
                                                                        <span style="">
                                                                            Total a pagar
                                                                        </span>
                                                                    </strong>
                                                                </span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>


        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-9" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
        <tbody>
        <tr>
        <td>
        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; width: 680px;" width="680">
        <tbody>
        <tr>
        <td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="33.333333333333336%">
        <table border="0" cellpadding="0" cellspacing="0" class="text_block block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
                <tr>
                        <td class="pad" style="padding-left:25px;padding-top:15px;padding-bottom:5px;">
                                <div style="font-family: sans-serif">
                                        <div class="" style="font-size: 12px; mso-line-height-alt: 18px; color: #848484; line-height: 1.5; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
                                                <p style="margin: 0; font-size: 14px; text-align: left; mso-line-height-alt: 21px;">
                                                        <span style="font-size:14px;">
                                                                Subtotal
                                                        </span>
                                                </p>
                                        </div>
                                </div>
                        </td>
                </tr>
        </table>
    </td>

    <td class="column column-2" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="33.333333333333336%">
    <div class="spacer_block" style="height:5px;line-height:5px;font-size:1px;"> </div>
    <table border="0" cellpadding="10" cellspacing="0" class="text_block mobile_hide block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
    <tr>
    <td class="pad">
    <div style="font-family: sans-serif">
    <div class="" style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #555555; line-height: 1.2; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
    <p style="margin: 0; font-size: 12px; mso-line-height-alt: 14.399999999999999px;"> </p>
    </div>
    </div>
    </td>
    </tr>
    </table>
    <div class="spacer_block" style="height:5px;line-height:5px;font-size:1px;"> </div>
    </td>

        <td class="column column-3" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="33.333333333333336%">
            <table border="0" cellpadding="0" cellspacing="0" class="text_block block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
                    <tr>
                            <td class="pad" style="padding-left:35px;padding-right:10px;padding-top:15px;padding-bottom:5px;">
                                    <div style="font-family: sans-serif">
                                            <div class="" style="font-size: 12px; mso-line-height-alt: 18px; color: #666666; line-height: 1.5; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
                                                    <p style="margin: 0; font-size: 14px; text-align: left; mso-line-height-alt: 21px;">
                                                            <span style="font-size:14px;">
                                                                    $ ' . number_format($subtotal, 2) . '
                                                            </span>
                                                    </p>
                                            </div>
                                    </div>
                            </td>
                    </tr>
            </table>
        </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>


    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-10" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
        <tbody>
            <tr>
                <td>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; width: 680px;" width="680">
                        <tbody>
                            <tr>
                                <td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="33.333333333333336%">
                                    <table border="0" cellpadding="0" cellspacing="0" class="text_block block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
                                            <tr>
                                                    <td class="pad" style="padding-left:25px;padding-top:15px;padding-bottom:5px;">
                                                            <div style="font-family: sans-serif">
                                                                    <div class="" style="font-size: 12px; mso-line-height-alt: 18px; color: #848484; line-height: 1.5; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
                                                                            <p style="margin: 0; font-size: 14px; text-align: left; mso-line-height-alt: 21px;">
                                                                                    <span style="font-size:14px;">
                                                                                            Descuentos
                                                                                    </span>
                                                                            </p>
                                                                    </div>
                                                            </div>
                                                    </td>
                                            </tr>
                                    </table>
                                </td>
                            <td class="column column-2" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="33.333333333333336%">
                            <div class="spacer_block" style="height:5px;line-height:5px;font-size:1px;"> </div>
                            <table border="0" cellpadding="10" cellspacing="0" class="text_block mobile_hide block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
                            <tr>
                            <td class="pad">
                            <div style="font-family: sans-serif">
                            <div class="" style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #555555; line-height: 1.2; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
                            <p style="margin: 0; font-size: 12px; mso-line-height-alt: 14.399999999999999px;"> </p>
                            </div>
                            </div>
                            </td>
                            </tr>
                            </table>
                            <div class="spacer_block" style="height:5px;line-height:5px;font-size:1px;"> </div>
                            </td>
                                <td class="column column-3" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="33.333333333333336%">
                                    <table border="0" cellpadding="0" cellspacing="0" class="text_block block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
                                            <tr>
                                                    <td class="pad" style="padding-left:35px;padding-right:10px;padding-top:15px;padding-bottom:5px;">
                                                            <div style="font-family: sans-serif">
                                                                    <div class="" style="font-size: 12px; mso-line-height-alt: 18px; color: #666666; line-height: 1.5; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
                                                                            <p style="margin: 0; font-size: 14px; text-align: left; mso-line-height-alt: 21px;">
                                                                                    <span style="font-size:14px; color:red;">
                                                                                            <s> $ ' . number_format($descuento, 2) . ' </s>
                                                                                    </span>
                                                                            </p>
                                                                    </div>
                                                            </div>
                                                    </td>
                                            </tr>
                                    </table>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>


    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-10" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
        <tbody>
            <tr>
                <td>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; width: 680px;" width="680">
                        <tbody>
                            <tr>
                                <td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="33.333333333333336%">
                                    <table border="0" cellpadding="0" cellspacing="0" class="text_block block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
                                            <tr>
                                                    <td class="pad" style="padding-left:25px;padding-top:15px;padding-bottom:5px;">
                                                            <div style="font-family: sans-serif">
                                                                    <div class="" style="font-size: 12px; mso-line-height-alt: 18px; color: #848484; line-height: 1.5; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
                                                                            <p style="margin: 0; font-size: 14px; text-align: left; mso-line-height-alt: 21px;">
                                                                                    <span style="font-size:14px;">
                                                                                            Envío
                                                                                    </span>
                                                                            </p>
                                                                    </div>
                                                            </div>
                                                    </td>
                                            </tr>
                                    </table>
                                </td>
                            <td class="column column-2" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="33.333333333333336%">
                            <div class="spacer_block" style="height:5px;line-height:5px;font-size:1px;"> </div>
                            <table border="0" cellpadding="10" cellspacing="0" class="text_block mobile_hide block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
                            <tr>
                            <td class="pad">
                            <div style="font-family: sans-serif">
                            <div class="" style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #555555; line-height: 1.2; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
                            <p style="margin: 0; font-size: 12px; mso-line-height-alt: 14.399999999999999px;"> </p>
                            </div>
                            </div>
                            </td>
                            </tr>
                            </table>
                            <div class="spacer_block" style="height:5px;line-height:5px;font-size:1px;"> </div>
                            </td>
                                <td class="column column-3" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="33.333333333333336%">
                                    <table border="0" cellpadding="0" cellspacing="0" class="text_block block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
                                            <tr>
                                                    <td class="pad" style="padding-left:35px;padding-right:10px;padding-top:15px;padding-bottom:5px;">
                                                            <div style="font-family: sans-serif">
                                                                    <div class="" style="font-size: 12px; mso-line-height-alt: 18px; color: #666666; line-height: 1.5; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
                                                                            <p style="margin: 0; font-size: 14px; text-align: left; mso-line-height-alt: 21px;">
                                                                                    <span style="font-size:14px;">
                                                                                            $ ' . number_format($envio, 2) . '
                                                                                    </span>
                                                                            </p>
                                                                    </div>
                                                            </div>
                                                    </td>
                                            </tr>
                                    </table>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>


    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-11" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
    <tbody>
    <tr>
    <td>
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; width: 680px;" width="680">
    <tbody>
    <tr>
    <td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="33.333333333333336%">
    <table border="0" cellpadding="0" cellspacing="0" class="text_block block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
    <tr>
    <td class="pad" style="padding-bottom:15px;padding-left:60px;padding-right:10px;padding-top:20px;">
    <div style="font-family: sans-serif">
    <div class="" style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #030303; line-height: 1.2; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
    <p style="margin: 0; font-size: 14px; mso-line-height-alt: 16.8px;"><span style="font-size:18px;"><strong><span style="">Total</span></strong></span></p>
    </div>
    </div>
    </td>
    </tr>
    </table>
    </td>
    <td class="column column-2" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="33.333333333333336%">
    <div class="spacer_block" style="height:5px;line-height:5px;font-size:1px;"> </div>
    <table border="0" cellpadding="10" cellspacing="0" class="text_block mobile_hide block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
    <tr>
    <td class="pad">
    <div style="font-family: sans-serif">
    <div class="" style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #555555; line-height: 1.2; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
    <p style="margin: 0; font-size: 12px; mso-line-height-alt: 14.399999999999999px;"> </p>
    </div>
    </div>
    </td>
    </tr>
    </table>
    <div class="spacer_block" style="height:5px;line-height:5px;font-size:1px;"> </div>
    </td>
    <td class="column column-3" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="33.333333333333336%">
    <table border="0" cellpadding="0" cellspacing="0" class="text_block block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
            <tr>
                    <td class="pad" style="padding-bottom:15px;padding-left:35px;padding-right:10px;padding-top:20px;">
                            <div style="font-family: sans-serif">
                                    <div class="" style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #030303; line-height: 1.2; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
                                            <p style="margin: 0; font-size: 14px; mso-line-height-alt: 16.8px;">
                                                    <strong>
                                                            <span style="font-size:20px;">
                                                                    <span style="">
                                                                            $ ' . number_format($total) . '
                                                                    </span>
                                                            </span>
                                                    </strong>
                                            </p>
                                    </div>
                            </div>
                    </td>
            </tr>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-12" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #3333d3;" width="100%">
    <tbody>
    <tr>
    <td>
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; width: 680px;" width="680">
    <tbody>
    <tr>
    <td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 0px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
    <table border="0" cellpadding="10" cellspacing="0" class="divider_block block-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
    <tr>
    <td class="pad">
    <div align="center" class="alignment">
    <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
    <tr>
    <td class="divider_inner" style="font-size: 1px; line-height: 1px; border-top: 1px solid #D6D3D3;"><span> </span></td>
    </tr>
    </table>
    </div>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-13" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
    <tbody>
    <tr>
    <td>
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; width: 680px;" width="680">
    <tbody>
    <tr>
    <td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
    <table border="0" cellpadding="10" cellspacing="0" class="text_block block-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
    <tr>
    <td class="pad">
    <div style="font-family: sans-serif">
        <div class="" style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #393d47; line-height: 1.2; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
            <p style="margin: 0; font-size: 14px; text-align: center; mso-line-height-alt: 16.8px;">
                Fecha de pedido:
                <strong>
                    ' . date("d-m-Y h:i", strtotime($fechaPedido)) . '
                </strong>
            </p>
        </div>
    </div>
    </td>
    </tr>
    </table>
    <table border="0" cellpadding="10" cellspacing="0" class="divider_block block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
    <tr>
    <td class="pad">
    <div align="center" class="alignment">
    <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
    <tr>
    <td class="divider_inner" style="font-size: 1px; line-height: 1px; border-top: 1px solid #D6D3D3;"><span> </span></td>
    </tr>
    </table>
    </div>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-14" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
    <tbody>
    <tr>
    <td>
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #3939ad; color: #000000; width: 680px;" width="680">
    <tbody>
    <tr>
    <td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
    <table border="0" cellpadding="10" cellspacing="0" class="divider_block block-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
    <tr>
    <td class="pad">
    <div align="center" class="alignment">
    <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
    <tr>
    <td class="divider_inner" style="font-size: 1px; line-height: 1px; border-top: 1px solid #FFFFFF;"><span> </span></td>
    </tr>
    </table>
    </div>
    </td>
    </tr>
    </table>
    <table border="0" cellpadding="10" cellspacing="0" class="text_block block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
    <tr>
    <td class="pad">
    <div style="font-family: sans-serif">
    <div class="" style="font-size: 12px; mso-line-height-alt: 18px; color: #ffffff; line-height: 1.5; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
    <p style="margin: 0; font-size: 14px; text-align: center; mso-line-height-alt: 24px;"><span style="font-size:16px;">Gracias por usar <span style="color:#ffffff;"><a href="https://mayoristapp.mx" rel="noopener" style="text-decoration: none; color: #ffffff;" target="_blank"><strong>mayoristapp.mx</strong></a></span><span style="background-color:#ffffff;"><a href="https://mayoristapp.mx" rel="noopener" style="text-decoration: none; background-color: #ffffff; color: #ffffff;" target="_blank"></a></span></span></p>
    </div>
    </div>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-15" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
    <tbody>
    <tr>
    <td>
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #3939ad; color: #000000; width: 680px;" width="680">
    <tbody>
    <tr>
    <td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
    <table border="0" cellpadding="10" cellspacing="0" class="divider_block block-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
    <tr>
    <td class="pad">
    <div align="center" class="alignment">
    <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
    <tr>
    <td class="divider_inner" style="font-size: 1px; line-height: 1px; border-top: 1px solid #FFFFFF;"><span> </span></td>
    </tr>
    </table>
    </div>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-16" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
    <tbody>
    <tr>
    <td>
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #3939ad; color: #000000; width: 680px;" width="680">
    <tbody>
    <tr>
    <td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
    <table border="0" cellpadding="0" cellspacing="0" class="text_block block-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
    <tr>
    <td class="pad" style="padding-bottom:10px;padding-left:25px;padding-right:10px;padding-top:10px;">
    <div style="font-family: sans-serif">
    <div class="" style="font-size: 12px; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif; mso-line-height-alt: 14.399999999999999px; color: #ffffff; line-height: 1.2;">
    <p style="margin: 0; font-size: 18px; text-align: left; mso-line-height-alt: 21.599999999999998px;"><strong><span style="color:#ffffff;">Comienza a vender en línea</span></strong></p>
    </div>
    </div>
    </td>
    </tr>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" class="text_block block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
    <tr>
    <td class="pad" style="padding-bottom:20px;padding-left:25px;padding-right:10px;padding-top:10px;">
    <div style="font-family: sans-serif">
    <div class="" style="font-size: 12px; mso-line-height-alt: 21.6px; color: #C0C0C0; line-height: 1.8; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
    <p style="margin: 0; mso-line-height-alt: 21.6px;"><span style="color:#ffffff;">Crea tu tienda gratis, recibe pedidos por Whatsapp, estadísticas de tus ventas o vende directo en tu sucursal, todo en un sólo lugar.</span></p>
    </div>
    </div>
    </td>
    </tr>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" class="button_block block-3" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
    <tr>
    <td class="pad" style="padding-bottom:10px;padding-left:35px;padding-right:10px;padding-top:10px;text-align:left;">
    <div align="left" class="alignment">
    <!--[if mso]><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="https://mayoristapp.mx/#registro" style="height:44px;width:188px;v-text-anchor:middle;" arcsize="10%" strokeweight="0.75pt" strokecolor="#E17370" fillcolor="#e17370"><w:anchorlock/><v:textbox inset="0px,0px,0px,0px"><center style="color:#ffffff; font-family:Tahoma, sans-serif; font-size:16px"><![endif]--><a href="https://mayoristapp.mx/#registro" style="text-decoration:none;display:inline-block;color:#ffffff;background-color:#e17370;border-radius:4px;width:auto;border-top:1px solid #E17370;font-weight:400;border-right:1px solid #E17370;border-bottom:1px solid #E17370;border-left:1px solid #E17370;padding-top:5px;padding-bottom:5px;font-family:Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;font-size:16px;text-align:center;mso-border-alt:none;word-break:keep-all;" target="_blank"><span style="padding-left:30px;padding-right:30px;font-size:16px;display:inline-block;letter-spacing:normal;"><span dir="ltr" style="word-break: break-word; line-height: 32px;">Crear mi tienda</span></span></a>
    <!--[if mso]></center></v:textbox></v:roundrect><![endif]-->
    </div>
    </td>
    </tr>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" class="text_block block-5" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
    <tr>
    <td class="pad" style="padding-bottom:10px;padding-left:25px;padding-right:10px;padding-top:31px;">
    <div style="font-family: sans-serif">
    <div class="" style="font-size: 12px; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif; mso-line-height-alt: 18px; color: #ffffff; line-height: 1.5;">
    <p style="margin: 0; text-align: center; mso-line-height-alt: 27px;"><span style="background-color:transparent;font-size:18px;"><strong>Encuéntranos</strong></span><strong style="font-family:inherit;font-family:inherit;font-size:18px;"><span style="color:#ffffff;"> en:</span></strong></p>
    </div>
    </div>
    </td>
    </tr>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" class="social_block block-6" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
    <tr>
    <td class="pad" style="padding-bottom:35px;padding-left:20px;text-align:center;padding-right:0px;">
    <div align="center" class="alignment">
    <table border="0" cellpadding="0" cellspacing="0" class="social-table" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; display: inline-block;" width="94px">
    <tr>
    <td style="padding:0 15px 0 0px;"><a href="https://instagram.com/" target="_blank"><img alt="Instagram" height="32" src="https://mayoristapp.mx/app/assets/img/mail/plantillaOrdenConfirmada/instagram2x.png" style="display: block; height: auto; border: 0;" title="Instagram" width="32"/></a></td>
    <td style="padding:0 15px 0 0px;"><a href="https://www.whatsapp.com" target="_blank"><img alt="WhatsApp" height="32" src="https://mayoristapp.mx/app/assets/img/mail/plantillaOrdenConfirmada/whatsapp2x.png" style="display: block; height: auto; border: 0;" title="WhatsApp" width="32"/></a></td>
    </tr>
    </table>
    </div>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-17" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
    <tbody>
    <tr>
    <td>
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px;" width="680">
    <tbody>
    <tr>
    <td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
    <table border="0" cellpadding="0" cellspacing="0" class="icons_block block-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
    <tr>
    <td class="pad" style="vertical-align: middle; color: #9d9d9d; font-family: inherit; font-size: 15px; padding-bottom: 5px; padding-top: 5px; text-align: center;">
    <table cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">

    </table>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table><!-- End -->
    </body>
    </html>';

    return $data;

    }

    function getDatosContactoVendedor($conn, $idTienda)
    {

        $sql = "SELECT
                    *
                FROM
                    `usuarios`
                WHERE
                    username = '$idTienda'";

        $result = mysqli_query($conn, $sql);
        $datos;
        $i = 0;
        if (mysqli_num_rows($result) > 0)
        {
            // output data of each row
            while ($row = mysqli_fetch_assoc($result))
            {

                $datos['id']        = $row['id'];
                $datos['nombre']    = $row['nombre'];
                $datos['paterno']   = $row['paterno'];
                $datos['materno']   = $row['materno'];
                $datos['telefono']  = $row['telefono'];
                $datos['email']     = $row['email'];
                $datos['username']  = $row['username'];

                $i++;
            }


            return $datos;
        }
        else
        {


            return false;
        }

    }

    function getDireccionPedido($conn, $idEnvio, $idDireccionEnvio, $idCliente, $idVendedor)
    {

        //echo $idEnvio . " * " . $idDireccionEnvio;

        $consultaDB = 0;
        $recolectarSucursal = 0;
        $msg = "";

        switch ($idEnvio)
        {

        case 'E-1': // Paquetería
            $consultaDB = 1;
            $msg = "Recibirás tu paquete en:<br><br>";
            break;

        case 'E-2': // Paquetería
            $consultaDB = 1;
            $msg = "Recibirás tu paquete en:<br><br>";
            break;

        case 'E-3': // Sucursal
            $consultaDB = 1;
            $recolectarSucursal = 1;
            $msg = "Podrás recolectar tu paquete en:<br><br>";
            break;

        case 'E-4': // Acordar c/Vendedor
            $consultaDB = 0;
            $msg = "Acordar con el vendedor.";
            break;

        case 'E-5': // No Aplica
            $consultaDB = 0;
            $msg = "No requiere entrega.";
            break;

        default:
            // code...
            break;

        }

        if ($consultaDB)
        {
            $datos;
            $i = 0;

            if ($recolectarSucursal)
            {
                $sql = "SELECT * FROM sucursalesVendedores WHERE idTienda = '$idTienda' AND idDireccion = '$idDireccionEnvio'";
            }
            else
            {
                $sql = "SELECT * FROM direccionesClientes  WHERE idCliente = '$idCliente' AND idDireccion = '$idDireccionEnvio'";
            }
            //echo $sql;
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0)
            {
                // output data of each row
                while ($row = mysqli_fetch_assoc($result))
                {
                    $datos[$i]['id']             = $row['id'];
                    $datos[$i]['direccion']      = $row['direccion'];
                    $datos[$i]['aliasDireccion'] = $row['aliasDireccion'];
                    $i++;
                }
                return $datos;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return $msg;
        }

    }

    function getDatosBancariosTienda($conn, $idTienda, $datosBancariosVendedor)
    {

        $sql = "SELECT
                    *
                FROM
                    `datosBancariosVendedores`
                WHERE
                    idTienda = '$idTienda'";

        $result = mysqli_query($conn, $sql);
        $datos;
        $i = 0;
        if (mysqli_num_rows($result) > 0)
        {
            // output data of each row
            while ($row = mysqli_fetch_assoc($result))
            {

                $datos[$i]['id']         = $row['id'];
                $datos[$i]['idOwner']    = $row['idOwner'];
                $datos[$i]['idTienda']   = $row['idTienda'];
                $datos[$i]['numTarjeta'] = $row['numTarjeta'];
                $datos[$i]['numClabe']   = $row['numClabe'];
                $datos[$i]['banco']      = $row['banco'];

                if ($datosBancariosVendedor == $row['idCuentaBancaria'])
                {
                    $datos[$i]['userSelected'] = 1;
                }
                else
                {
                    $datos[$i]['userSelected'] = 0;
                }

                $i++;
            }


            return $datos;
        }
        else
        {


            return false;
        }

    }

    function eliminarImagenesPrevias($conn, $idProducto, $idTienda)
    {
        $sqlEliminaImagenes = "DELETE FROM imagenProducto WHERE idTienda = '$idTienda' AND idProducto = '$idProducto'";
        if (mysqli_query($conn, $sqlEliminaImagenes))
        {
            //echo "Eliminado";
            return true;
        }
        else
        {
            // echo "Desactivo la carga";
            return false;
        }
    }

    function getInventarioProducto($conn, $idTienda, $idProducto)
    {
        $sql = "SELECT * FROM productos WHERE idTienda = '$idTienda' AND idProducto = '$idProducto' AND isActive = 1";
        $result = mysqli_query($conn, $sql);
        $stock = 0;
        if (mysqli_num_rows($result) > 0)
        {
            // output data of each row
            while($row = mysqli_fetch_assoc($result))
            {
                $stock = $stock + $row['inventario'];
            }
        }

        return $stock;
    }

    function getDatosTienda($conn, $idTienda)
    {
        // Creamos la consulta SQL base
        $sql = "SELECT * FROM tiendas WHERE idTienda = '$idTienda'";

        // Ejecutamos la consulta
        $result = mysqli_query($conn, $sql);

        // Si no hay resultados, retornamos null
        if (!$result || mysqli_num_rows($result) == 0)
        {
            return false;
        }
        // Si hay resultados, retornamos el primer registro
        return mysqli_fetch_assoc($result);
    }

    function agregarCarrito($conn, $datosProducto, $idProducto, $idTienda, $stock, $precio, $precioOferta)
    {

        $response      = false;
        $isAddedToCart = false;
        $idTienda      = $datosProducto['idTienda'];
        $stockCarrito  = 0;

        // Obtengo inventario del producto de la base de datos
        $inventarioDB = getInventarioProducto($conn, $idTienda, $idProducto); // editar sql
        // Valido si regresó info o viene en false
        if ($inventarioDB == 0)
        {
            $response = "stockInsuficiente";                
        }
        else
        {

            //echo "Stock limitado<br><br>";
            if (!isset($_SESSION[$idTienda]))
            {
                $_SESSION[$idTienda] = Array();
            }

            // Buscar el idProducto en el carrito de la sesión, si existe lo agrego
            if (array_key_exists($idProducto, $_SESSION[$idTienda]))
            {
                $stockCarrito = $_SESSION[$idTienda][$datosProducto['idProducto']]['stock'];
                if (($stockCarrito + $stock) <= $inventarioDB)
                {
                    // Sumar carrito actual + stock agregado por usuario
                    $stockNuevo = $stockCarrito + $stock;
                    // echo "<hr>";
                    // Actualizamos el stock en la sesión del carrito
                    $_SESSION[$idTienda][$datosProducto['idProducto']]['stock'] = $stockNuevo;
                    $response = true;
                }
                else
                {
                    $response = "inventarioInsuficiente";
                }

            }
            else // agrego al carrito por primera vez
            {
                if ($stockCarrito <= $inventarioDB && $inventarioDB > 0)
                {
                    $_SESSION[$idTienda][$idProducto] = array(
                        'nombre'     => $datosProducto['nombre'],
                        'idProducto' => $idProducto,
                        'idTienda'   => $idTienda,
                        'requiereEnvio' => $datosProducto['requiereEnvio'],
                        'unidadVenta'   => $datosProducto['unidadVenta'],
                        'stock'         => $stock,
                        'precio'        => $precio,
                        'costo'         => $datosProducto['costo'],
                        // 'precioOferta'  => $precioOferta,
                    );
                    $response = true;
                }
                else
                {
                    $response = false;
                }
            }

        }
        // echo "<pre>";
        // print_r($_SESSION[$idTienda]);

        return $response;
    }

    function decrementoCarrito($idTienda, $idProducto)
    {
        if(isset($_SESSION[$idTienda][$idProducto]))
        {
            if($_SESSION[$idTienda][$idProducto]['stock'] > 1)
            {
                $_SESSION[$idTienda][$idProducto]['stock'] -= 1;
            }
            else
            {
                unset($_SESSION[$idTienda][$idProducto]);
            }
            return true;
        }
        else
        {
            return false;
        }
    }

    function buscarProducto($conn, $idProducto, $idTienda)
    {

        $sql = "SELECT * FROM productos WHERE idTienda = '$idTienda' AND idProducto = '$idProducto' AND isActive = 1";
        $result = mysqli_query($conn, $sql);
        $resultado;

        if (mysqli_num_rows($result) > 0)
        {
            // output data of each row
            $row = mysqli_fetch_assoc($result);
            $resultado = $row;
            return $resultado;
        }
        else
        {
            return false;
        }

        // echo "<pre>";
        // print_r($resultado);

    }

    function recursiveDelete($str)
    {
        if (is_file($str)) {
            return @unlink($str);
        }
        elseif (is_dir($str)) {
            $scan = glob(rtrim($str,'/').'/*');
            foreach($scan as $index=>$path) {
                recursiveDelete($path);
            }
            return @rmdir($str);
        }
    }

    function getNewIdProducto($conn, $idTienda)
    {

        $sql = "SELECT idProducto, CAST(REPLACE(idProducto, 'P-', '') AS decimal) AS consecutivo FROM productos ORDER BY consecutivo DESC LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0)
        {
            // output data of each row
            while($row = mysqli_fetch_assoc($result))
            {
                $idProducto   = $row["consecutivo"];
            }

            $idProducto   = $idProducto + 0;
            $idProducto += 1;
            $idProducto = "P-" . $idProducto;
            return $idProducto;

        }
        else
        {
            $idProducto = "P-1";
            return $idProducto;
        }

    }

    // Valida si está verificado
    function isVerified()
    {
    if (isset($_SESSION['isVerified']))
    {
        if ($_SESSION['isVerified'] == 0)
        {
        header('Location: verifica/');
        }
    }
    }
    // Fin Valida si está verificado

    // INICIO NOTIFICAR ACCESO
    function notificacion($idAlumno)
    {
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Host      = 'smtp.hostinger.com';
        $mail->Port      = 587;
        $mail->SMTPAuth  = true;
        $mail->Username  = 'hola@mayoristapp.mx';
        $mail->Password  = 'kaka4545A1$$';
        $mail->setFrom('hola@mayoristapp.mx', 'mayoristapp.mx');
        $mail->addReplyTo('hola@mayoristapp.mx', 'mayoristapp.mx');
        $mail->addAddress('axelcoreos@gmail.com', 'Axel33');
        $mail->Subject = 'Nuevo acceso';
        //$mail->msgHTML(file_get_contents('message.html'), __DIR__);
        $hora = strtotime(date("Y-m-d h:i:s"));
        $time = date('Y-m-d h:i:s', $hora);

        $mail->Body = 'Nuevo acceso, ' . $idAlumno . ' - ' . $time;

        //$mail->addAttachment('test.txt');
        if (!$mail->send())
        {
        //echo 'Mailer Error: ' . $mail->ErrorInfo;
        return true;
        }
        else
        {
        //echo 'The email message was sent.';
        return false;
        }
    }
    // FIN NOTIFICAR ACCESO

    function redireccionaMsg($vista, $parametro)
    {

        $url = $vista . "?msg=" . $parametro;
        // index.php?msg=parametro
        header('Location: ' . $url);
        exit();
    }

    function enviaEmail($emailRecipiente, $nombreRecipiente, $tituloCorreo, $cuerpoCorreo)
    {

        $mail = new PHPMailer(true);
        $mail->CharSet = 'UTF-8';

        try
        {
            /* CUSTOM CONFIGURATION */
            /* END CUSTOM CONFIGURATION */

            //Server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host      = 'smtp.hostinger.com';
            // $mail->Port      = 587;
            $mail->SMTPAuth  = true;
            $mail->Username  = 'contacto@conejondigital.com';
            $mail->Password  = 'conej0n1128A1$';
            //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('contacto@conejondigital.com', 'Conejón Digital');
            $mail->addReplyTo('contacto@conejondigital.com', 'Conejón Digital');
            $mail->addAddress($emailRecipiente, $nombreRecipiente);

            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $tituloCorreo;
            $mail->Body    = $cuerpoCorreo;
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            $mail->send();

            return true;

        }
        catch (Exception $e)
        {
            
            //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return false;
        }

    }

    function limpiarDato($dato)
    {
        $dato = trim($dato);
        $dato = htmlspecialchars($dato);
        $dato = htmlentities($dato);
        return $dato;
    }

    function encodeToken($token)
    {
    $tam = 6;
    for ($i=0; $i < $tam; $i++)
    {
        $token = base64_encode($token);
    }
    return $token;
    }

    function decodeToken($token)
    {
    $tam = 6;
    for ($i=0; $i < $tam; $i++)
    {
        $token = base64_decode($token);
    }
    return $token;
    }

?>
