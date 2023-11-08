<?php

    require 'php/conexion.php';
    require 'php/funciones.php';

    require __DIR__ . '/vendor/autoload.php';

    use Mpdf\QrCode\QrCode;
    use Mpdf\QrCode\Output;

    session_start();
    // Cargar comprobante
    if (isset($_POST['btnCargaComprobante']))
    {
        // echo "btnCargaComprobante";
        // die;

        $idCliente = $_POST['idCliente'];
        $idPedido  = $_POST['idPedido'];
        $cargarComprobante = cargarComprobante($conn, $idCliente, $idPedido);

        if ($cargarComprobante !== false)
        {
            $nombreComprobante = $cargarComprobante;
            $fechaPago = date("Y-m-d H:i:s");
            $hasFile   = true;

            if (registraComprobante($conn, $nombreComprobante, $idPedido, $idCliente, $fechaPago, $hasFile))
            {
                exit(header('Location: detalle-compra.php?id=' . $idPedido . '&msg=comprobanteCargado'));
            }
            else
            {
                exit(header('Location: detalle-compra.php?id=' . $idPedido . '&msg=errorComprobanteCarga'));
            }
        }
        else
        {
            exit(header('Location: detalle-compra.php?id=' . $idPedido . '&msg=errorComprobanteCarga&'));
        }
    }

    if (isset($_POST['btnCrearPedido'])) 
    {

        // Crear pedido inserta en tablas:
        // Pedidos, Plaquitas, Creditos
        $registrarPlaquitas = false;
        $registrarCreditos  = false;

        
        
        $idPedido = generarIdPedido($conn);
        $idCliente       = $_SESSION['email'];
        $fechaPedido     = date("Y-m-d H:i:s");
        //$envioDinamico   = $_POST["metodoEnvioDinamico"];
        
        //$envioDinamico   = explode(";", $envioDinamico);
        //$tipoEnvio       = $envioDinamico[2];
        $tipoEnvio       = "PIK"; // PIK PARA LANYARD

        //$direccionEnvio  = $_POST['direccion'];
        $direccionEnvio  = "Dirección de usuario 88";
        $idMetodoDePago  = $_POST['metodoPago'];
        
        $subtotal        = 90;
        $total           = 0;
        $descuentos      = 90;
        $precioEnvio = 0;    
        //$creditosPorUsar = $_POST['creditosPorUsar'];
        
        $isActive        = 1;
        $idEstatusPedido = "EP-1";

        // echo "subtotal: " . $subtotal . "<br>";
        // echo "creditosPorUsar: " . $creditosPorUsar . "<br>";
        // echo "Descontar por credito: " . $precioPlaquita * $creditosPorUsar . "<br>";
        // echo "descuentos: " . $descuentos . "<br>";
        // echo "total: " . $total . "<br>";
        

        // Iniciar una transacción
        $conn->begin_transaction();

        try {
            // Preparar la consulta SQL para insertar un nuevo pedido
            $sqlNuevoPedido = "INSERT INTO pedidos (idPedido, idCliente, fechaPedido, idTipoEnvio, direccionEnvio, idEstatusPedido, idMetodoDePago, precioEnvio, subtotal, descuentos,  total, isActive)
            VALUES ('$idPedido', '$idCliente', '$fechaPedido', '$tipoEnvio', '$direccionEnvio', '$idEstatusPedido', '$idMetodoDePago', '$precioEnvio', '$subtotal', '$descuentos', '$total', '$isActive')";

            // Ejecutar la consulta SQL para insertar el nuevo pedido
            $conn->query($sqlNuevoPedido);

            // Verificar si se insertó correctamente el pedido
            if ($conn->affected_rows === 1) 
            {
                

                 
            } else {
                throw new Exception("Error al insertar el pedido.");
            }

            // Si no se lanzó ninguna excepción, confirmamos la transacción
            $conn->commit();
            
            // Enviar email confirmación de pedido
            // $emailRecipiente = "ventas@pets.vendy.click";
            // $nombreRecipiente = "Vendy Pets";
            // $tituloCorreo = "Nuevo Pedido";
            // $cuerpoCorreo = "Nuevo pedido creado por " . $idCliente . " a las " . date("d/m/Y H:i:s");
            // enviaEmail($emailRecipiente, $nombreRecipiente, $tituloCorreo, $cuerpoCorreo);

            // unset($_SESSION['carrito']);
            
            $_SESSION['carrito'] = array(); 
            $_SESSION['carrito']['conteoTotalPlaquitas'] = 0;
            $_SESSION['carrito']['creditos']    = 0; 
            $_SESSION['carrito']['subtotal']    = 0;
            $_SESSION['carrito']['descuentos']  = 0;
            $_SESSION['carrito']['precioEnvio'] = 0;
            $_SESSION['carrito']['total']       = 0;

            header('Location: detalle-compra.php?id=' . $idPedido . '&msg=pedidoRealizado?/#pagoEnEspera');
            exit();

        } 
        catch (Exception $e) 
        {
            // En caso de error, revertimos la transacción
            $conn->rollback();            
            echo "[Rollback] Error: " . $e->getMessage();
            // header('Location: carrito.php?msg=errorCrearPedido');
            // exit();
        }
    }

    if (isset($_POST['btnGafeteCarrito'])) 
    {
        echo "btnGafeteCarrito";
        
        $disenoGafete = isset($_POST['disenoGafete']) ? $_POST['disenoGafete'] : '';
        $nombreArchivo = '';

        if (empty($disenoGafete)) 
        {
            // Redireccionar a disenaGafete.php con un mensaje de error
            header("Location: disenaGafete.php?msg=errorRegistroGafete");
            exit;
        }

        // Iniciar una transacción
        $conn->begin_transaction();

        $directorioDestino = 'gafetes/users/' . $_SESSION['email'] . '/';

        // Verificar si el directorio de destino no existe y crearlo si es necesario
        if (!file_exists($directorioDestino)) 
        {
            mkdir($directorioDestino, 0777, true);
        }

        $nombreArchivo = subirArchivo('fileToUpload', $directorioDestino);

        if ($nombreArchivo !== null) 
        {
            $idUsuario = $_SESSION['email']; // Asigna el valor del ID de usuario desde la sesión, ajusta según tu código
            $query = "INSERT INTO tabla_gafetes (idUsuario, nombre_archivo, diseno) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('sss', $idUsuario, $nombreArchivo, $disenoGafete);
        
            if ($stmt->execute()) {
                // Confirmar la transacción
                $conn->commit();
        
                // Redireccionar a disenaGafete.php con un mensaje de éxito
                header("Location: disenaGafete.php?msg=exitoRegistroGafete");
                exit;
            }
        }
        

        // En caso de error, revertir la transacción
        $conn->rollback();

        // Redireccionar a disenaGafete.php con un mensaje de error
        header("Location: disenaGafete.php?msg=errorRegistroGafete");
        exit;
    }

    if (isset($_POST['btnRegistroAsistencia'])) 
    {
        
        // Uso de la función para registrar asistencia
        $idUsuario = $_SESSION['email']; // Reemplaza con el ID del usuario
        $evento_id = "CN2023"; // Reemplaza con el ID del evento
        
        if (registrarAsistencia($conn, $idUsuario, $evento_id)) 
        {
            //echo "Asistencia registrada con éxito.";
            exit(header('Location: acceso/?msg=registrado'));
        } 
        else 
        {
            die("El usuario ya tiene un registro para este evento o hubo un error.");
        }
    
    }

    if (isset($_POST['btnEliminarMascota']))
    {
        // echo "<pre>";
        // print_r($_POST);
        // echo $_SESSION['email'];
        $idMascota = filter_input(INPUT_POST, 'idMascota', FILTER_SANITIZE_STRING);
        $email = $_SESSION['email']; // No necesitas escapar una variable de sesión.

        // Verifica si el usuario es el propietario de la mascota y elimina si es válido.
        $query = "DELETE FROM mascotas WHERE idMascota = ? AND idOwner = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $idMascota, $email);

        if ($stmt->execute()) 
        {
            $msg = "Mascota eliminada correctamente.";
            $redirectPage = "mis-conejos.php"; // Redirige a mis-conejos.php en caso de éxito.
        } 
        else 
        {
            $msg = "Error al eliminar la mascota: " . $conn->error;
            $redirectPage = "edita-mascota.php"; // Redirige a edita-mascota.php en caso de error.
        }

        $stmt->close();
        $conn->close();

        // Redireccionar a la página correspondiente con el mensaje.
        header("Location: $redirectPage?idMascota=" . $idMascota . "&msg=" . urlencode($msg));
        exit;


    }

    if (isset($_POST['btnGuardarGeneralesMascota']))
    {
        //echo "btnGuardarGeneralesMascota";
        // echo "<pre>";
        // print_r($_POST);                    

        if (isset($_POST['nombreMascota'], $_POST['fechaNacimientoMascota'], $_POST['razaMascota'], $_POST['sexoMascota'], $_POST['colorMascota'])) 
        {
            
            echo $idMascota = $_POST['idMascota'];
            echo $idOwner = $_SESSION['email'];
            
            // Obtener los datos recibidos por POST
            $nombreMascota = $_POST['nombreMascota'];
            $fechaNacimientoMascota = $_POST['fechaNacimientoMascota'];
            $razaMascota = $_POST['razaMascota'];
            $sexoMascota = $_POST['sexoMascota'];
            $colorMascota = $_POST['colorMascota']; 
             
            $query = "UPDATE mascotas SET nombre = '$nombreMascota', fechaNacimiento = '$fechaNacimientoMascota', raza = '$razaMascota', sexo = '$sexoMascota', color = '$colorMascota', isActive = 1 WHERE idMascota = '$idMascota' AND idOwner = '$idOwner'";
            
            $result = $conn->query($query);

            if ($result === false) 
            {
                //echo "Error: " . $conn->error;
                header("Location: edita-mascota.php?idMascota=$idMascota&msg=errorActualizarGenerales");
                exit();
            } 
            else 
            {                                 
                header("Location: edita-mascota.php?idMascota=$idMascota&msg=exitoActualizarGenerales");
                exit();
            }

        }      
        else
        {
            // Redirección si falta algún dato
            header("Location: edita-mascota.php?idMascota=$idMascota&msg=falta-datos");
            exit();
        }
    }
    
    if (isset($_POST['btnRegistraMascota'])) 
    {
        //var_dump($_POST);

        $idMascota = generarIdMascota($conn);
        $idCliente = $_SESSION['email'];
        
        $fotoMascota = cargarFotoMascota($conn, $idCliente, $idMascota);

        if ($fotoMascota !== false)
        {
            
            // Datos de la nueva mascota
            $nombre = $_POST['nombreMascota'];
            $fechaNacimiento = $_POST['fechaNacimiento'];
            
            $imgPerfil = $fotoMascota;

            // Consulta SQL para insertar la nueva mascota
            $sql = "INSERT INTO mascotas (nombre, idMascota, idOwner, imgPerfil, fechaNacimiento, isActive)
            VALUES ('$nombre', '$idMascota', '$idCliente', '$imgPerfil', '$fechaNacimiento', 1)";


            if ($conn->query($sql) === TRUE) 
            {
                //echo "Nueva mascota registrada exitosamente";
                exit(header('Location: mis-conejos.php?msg=exitoRegistroConejo'));
            } 
            else 
            {
                //echo "Error: " . $sql . "<br>" . $conn->error;
                exit(header('Location: mis-conejos.php?msg=errorRegistroConejo'));
            }

        }
        else
        {
            exit(header('Location: mis-conejos.php?msg=errorRegistroConejo'));
        }

    }
    
        
    if (isset($_POST['btnRegistroExpositor'])) 
    {
        // echo "Registro Expositor Pendiente";
        // echo "<pre>";
        // print_r($_POST);
        // Validar si el usuario ya está registrado por su correo electrónico

        $correo = $_POST['correo'];
        $check_query = "SELECT * FROM expositores WHERE correo = '$correo'";
        $result = $conn->query($check_query);
        
        if ($result->num_rows > 0) 
        {
            //echo "El usuario ya está registrado con este correo electrónico.";            
            exit(header('Location: ../index.php?msg=expositorYaRegistrado'));
        } 
        else 
        {
            // Si el usuario no está registrado, proceder con el registro
            $nombre = $_POST['nombre'];
            $whatsapp = $_POST['whatsapp'];
            $nombre_negocio = $_POST['nombre_negocio'];
            $giro_negocio = $_POST['giro_negocio']; // Cambio de nombre
            $contacto_negocio = $_POST['contacto_negocio']; // Cambio de nombre
            $como_te_enteraste = $_POST['como_te_enteraste']; // Cambio de nombre

            // Insertar los datos en la tabla "expositores" con los nuevos nombres de columna
            $sql = "INSERT INTO expositores (correo, nombre, whatsapp, nombre_negocio, giro_negocio, contacto_negocio, como_te_enteraste)
                    VALUES ('$correo', '$nombre', '$whatsapp', '$nombre_negocio', '$giro_negocio', '$contacto_negocio', '$como_te_enteraste')";

            if ($conn->query($sql) === TRUE) 
            {
                //echo "Registro exitoso. Gracias por registrarte como expositor.";
                exit(header('Location: ../index.php?msg=expositorRegistrado'));
            } 
            else 
            {
                //echo "Error al registrar: " . $conn->error;
                exit(header('Location: ../index.php?msg=expositorNoRegistrado'));
            }
        }

        // Cerrar la conexión
        $conn->close();

    }
    
    if (isset($_POST['btnRegistroVisitante']))
    {         
        
        $nombreCliente = $_POST['nombreCliente'];
        $idCliente     = $_POST['idCliente'];
        $emailActivacion    = $idCliente;
        $nombreRecipiente   = $idCliente;
        $flagSqlUpdateToken = false;
        $flagEnviarEmail    = false;
        $tokenActivacion = generarTokenActivacion();    
        $fechaRegistro = date("Y-m-d H:i:s");
 
        // Validamos si existe
        $datosUsuario = getDatosUsuario($conn, $idCliente);
        if ($datosUsuario != false)
        {
            // Existente
            if ($datosUsuario['isActive'] == 1)
            {
                // Cuenta activa, login
                header('Location: ../login.php?msg=cuentaExistente&correo=' . $idCliente);
                exit();
            }
            else
            {
                $flagSqlUpdateToken = true;
            }
        }        

        // No existe o inactiva, insertar en bdd
        if ($flagSqlUpdateToken == true)
        {            
            $sql = "UPDATE usuarios SET token = '$tokenActivacion' WHERE email = '$idCliente'";
        }
        else
        {
            $sql = "INSERT INTO usuarios (nombre, email, fechaRegistro, token) VALUES ('$nombreCliente', '$idCliente', '$fechaRegistro', '$tokenActivacion')";
        }
        
        // Ejecutar la consulta
        if ($conn->query($sql) === TRUE) 
        {
            $flagEnviarEmail = true;
        } 
        else 
        {
            $flagEnviarEmail = false;
        }

        // Enviar email
        $tituloCorreo = "✨ Activa tu cuenta 🐇"; 
        $cuerpoCorreo = '<!doctype html>
                <html>
                <head>
                    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                    <title>Simple Transactional Email</title>
                    <style>
                    /* -------------------------------------
                        GLOBAL RESETS
                    ------------------------------------- */
                    
                    /*All the styling goes here*/
                    
                    img {
                        border: none;
                        -ms-interpolation-mode: bicubic;
                        max-width: 100%; 
                    }
                
                    body {
                        background-color: #f6f6f6;
                        font-family: sans-serif;
                        -webkit-font-smoothing: antialiased;
                        font-size: 14px;
                        line-height: 1.4;
                        margin: 0;
                        padding: 0;
                        -ms-text-size-adjust: 100%;
                        -webkit-text-size-adjust: 100%; 
                    }
                
                    table {
                        border-collapse: separate;
                        mso-table-lspace: 0pt;
                        mso-table-rspace: 0pt;
                        width: 100%; }
                        table td {
                        font-family: sans-serif;
                        font-size: 14px;
                        vertical-align: top; 
                    }
                
                    /* -------------------------------------
                        BODY & CONTAINER
                    ------------------------------------- */
                
                    .body {
                        background-color: #f6f6f6;
                        width: 100%; 
                    }
                
                    /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
                    .container {
                        display: block;
                        margin: 0 auto !important;
                        /* makes it centered */
                        max-width: 580px;
                        padding: 10px;
                        width: 580px; 
                    }
                
                    /* This should also be a block element, so that it will fill 100% of the .container */
                    .content {
                        box-sizing: border-box;
                        display: block;
                        margin: 0 auto;
                        max-width: 580px;
                        padding: 10px; 
                    }
                
                    /* -------------------------------------
                        HEADER, FOOTER, MAIN
                    ------------------------------------- */
                    .main {
                        background: #ffffff;
                        border-radius: 3px;
                        width: 100%; 
                    }
                
                    .wrapper {
                        box-sizing: border-box;
                        padding: 20px; 
                    }
                
                    .content-block {
                        padding-bottom: 10px;
                        padding-top: 10px;
                    }
                
                    .footer {
                        clear: both;
                        margin-top: 10px;
                        text-align: center;
                        width: 100%; 
                    }
                        .footer td,
                        .footer p,
                        .footer span,
                        .footer a {
                        color: #999999;
                        font-size: 12px;
                        text-align: center; 
                    }
                
                    /* -------------------------------------
                        TYPOGRAPHY
                    ------------------------------------- */
                    h1,
                    h2,
                    h3,
                    h4 {
                        color: #000000;
                        font-family: sans-serif;
                        font-weight: 400;
                        line-height: 1.4;
                        margin: 0;
                        margin-bottom: 30px; 
                    }
                
                    h1 {
                        font-size: 35px;
                        font-weight: 300;
                        text-align: center;
                        text-transform: capitalize; 
                    }
                
                    p,
                    ul,
                    ol {
                        font-family: sans-serif;
                        font-size: 14px;
                        font-weight: normal;
                        margin: 0;
                        margin-bottom: 15px; 
                    }
                        p li,
                        ul li,
                        ol li {
                        list-style-position: inside;
                        margin-left: 5px; 
                    }
                
                    a {
                        color: #3498db;
                        text-decoration: underline; 
                    }
                
                    /* -------------------------------------
                        BUTTONS
                    ------------------------------------- */
                    .btn {
                        box-sizing: border-box;
                        width: 100%; }
                        .btn > tbody > tr > td {
                        padding-bottom: 15px; }
                        .btn table {
                        width: auto; 
                    }
                        .btn table td {
                        background-color: #ffffff;
                        border-radius: 5px;
                        text-align: center; 
                    }
                        .btn a {
                        background-color: #ffffff;
                        border: solid 1px #3498db;
                        border-radius: 5px;
                        box-sizing: border-box;
                        color: #3498db;
                        cursor: pointer;
                        display: inline-block;
                        font-size: 14px;
                        font-weight: bold;
                        margin: 0;
                        padding: 12px 25px;
                        text-decoration: none;
                        text-transform: capitalize; 
                    }
                
                    .btn-primary table td {
                        background-color: #3498db; 
                    }
                
                    .btn-primary a {
                        background-color: #3498db;
                        border-color: #3498db;
                        color: #ffffff; 
                    }
                
                    /* -------------------------------------
                        OTHER STYLES THAT MIGHT BE USEFUL
                    ------------------------------------- */
                    .last {
                        margin-bottom: 0; 
                    }
                
                    .first {
                        margin-top: 0; 
                    }
                
                    .align-center {
                        text-align: center; 
                    }
                
                    .align-right {
                        text-align: right; 
                    }
                
                    .align-left {
                        text-align: left; 
                    }
                
                    .clear {
                        clear: both; 
                    }
                
                    .mt0 {
                        margin-top: 0; 
                    }
                
                    .mb0 {
                        margin-bottom: 0; 
                    }
                
                    .preheader {
                        color: transparent;
                        display: none;
                        height: 0;
                        max-height: 0;
                        max-width: 0;
                        opacity: 0;
                        overflow: hidden;
                        mso-hide: all;
                        visibility: hidden;
                        width: 0; 
                    }
                
                    .powered-by a {
                        text-decoration: none; 
                    }
                
                    hr {
                        border: 0;
                        border-bottom: 1px solid #f6f6f6;
                        margin: 20px 0; 
                    }
                
                    /* -------------------------------------
                        RESPONSIVE AND MOBILE FRIENDLY STYLES
                    ------------------------------------- */
                    @media only screen and (max-width: 620px) {
                        table.body h1 {
                        font-size: 28px !important;
                        margin-bottom: 10px !important; 
                        }
                        table.body p,
                        table.body ul,
                        table.body ol,
                        table.body td,
                        table.body span,
                        table.body a {
                        font-size: 16px !important; 
                        }
                        table.body .wrapper,
                        table.body .article {
                        padding: 10px !important; 
                        }
                        table.body .content {
                        padding: 0 !important; 
                        }
                        table.body .container {
                        padding: 0 !important;
                        width: 100% !important; 
                        }
                        table.body .main {
                        border-left-width: 0 !important;
                        border-radius: 0 !important;
                        border-right-width: 0 !important; 
                        }
                        table.body .btn table {
                        width: 100% !important; 
                        }
                        table.body .btn a {
                        width: 100% !important; 
                        }
                        table.body .img-responsive {
                        height: auto !important;
                        max-width: 100% !important;
                        width: auto !important; 
                        }
                    }
                
                    /* -------------------------------------
                        PRESERVE THESE STYLES IN THE HEAD
                    ------------------------------------- */
                    @media all {
                        .ExternalClass {
                        width: 100%; 
                        }
                        .ExternalClass,
                        .ExternalClass p,
                        .ExternalClass span,
                        .ExternalClass font,
                        .ExternalClass td,
                        .ExternalClass div {
                        line-height: 100%; 
                        }
                        .apple-link a {
                        color: inherit !important;
                        font-family: inherit !important;
                        font-size: inherit !important;
                        font-weight: inherit !important;
                        line-height: inherit !important;
                        text-decoration: none !important; 
                        }
                        #MessageViewBody a {
                        color: inherit;
                        text-decoration: none;
                        font-size: inherit;
                        font-family: inherit;
                        font-weight: inherit;
                        line-height: inherit;
                        }
                        .btn-primary table td:hover {
                        background-color: #34495e !important; 
                        }
                        .btn-primary a:hover {
                        background-color: #34495e !important;
                        border-color: #34495e !important; 
                        } 
                    }
                
                    </style>
                </head>
                <body>
                    <span class="preheader">Aquí está tu código de activación: ' . $tokenActivacion . '.</span>
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
                    <tr>
                        <td>&nbsp;</td>
                        <td class="container">
                        <div class="content">
                
                            <!-- START CENTERED WHITE CONTAINER -->
                            <table role="presentation" class="main">
                
                            <!-- START MAIN CONTENT AREA -->
                            <tr>
                                <td class="wrapper">
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                    <td>
                                                                                       
                                        <h1>¡Hola, '. ucwords($nombreCliente) .'!</h1> <br>
                                        Aquí tienes tu código de activación del Conejón Digital</h2>
                                        <br>
                                        <h2><b>
                                        ' . implode(' ', str_split(strval($tokenActivacion))) . '
                                        </b></h2>
                                        <p>Tendrás acceso al evento y a la tienda Oficial del Conejón Digital</p>';
                                        
                                        $cuerpoCorreo .= '
                                        
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
                                        <tbody>
                                            <tr>
                                            <td align="left">
                                                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                                <tbody>
                                                    <tr>                                                                    
                                                    <td> <a href="'. $dominio . 'activa-codigo.php?token=' . $tokenActivacion . '&correo='. $emailActivacion.'" target="_blank">Activar ahora</a> </td>
                                                    </tr>
                                                </tbody>
                                                </table>
                                            </td>
                                            </tr>
                                        </tbody>
                                        </table> 
                                    </td>
                                    </tr>
                                </table>
                                </td>
                            </tr>
                
                            <!-- END MAIN CONTENT AREA -->
                            </table>
                            <!-- END CENTERED WHITE CONTAINER -->
                
                            <!-- START FOOTER -->
                            <div class="footer">
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                <td class="content-block">
                                    <span class="apple-link">Conejón <b>Digital</b></span>                                            
                                </td>
                                </tr>
                            </table>
                            </div>
                            <!-- END FOOTER -->
                
                        </div>
                        </td>
                        <td>&nbsp;</td>
                    </tr>
                    </table>
                </body>
                </html>';
            
        if (enviaEmail($emailActivacion, $nombreRecipiente, $tituloCorreo, $cuerpoCorreo))
        {
            header("Location: ../activa-codigo.php?correo=" . $emailActivacion . "&msg=solicitaCodigoActivacion");
            exit();
        }
        else
        {
            header("Location: ../registro.php?idMascota=". $idMascota ."&msg=errorRegistroVIP");
            exit();
        }     
        
    }

    if (isset($_POST['btnActivarCuenta'])) 
    {      
        if (isset($_POST['tokenActivacion']) && !empty($_POST['tokenActivacion']) && isset($_POST['password']) && !empty($_POST['password']) && isset($_POST['idCliente']) && !empty($_POST['idCliente']))
        {
            $tokenActivacion = $_POST['tokenActivacion'];
            $password  = $_POST['password'];            
            $idCliente = $_POST['idCliente'];
            $fechaActivacion = date("Y-m-d H:i:s");
            $datosUsuario = getDatosUsuario($conn, $idCliente);

            echo "<pre>";
            print_r($datosUsuario);
            echo "<br>33";

            // Validar si ya está activa la cuenta 
            if ($datosUsuario['isActive'] == 1)
            {

                $_SESSION['email']    = $datosUsuario['email'];
                $_SESSION['isActive'] = $datosUsuario['isActive'];                
                $_SESSION['nombre']   = $datosUsuario['nombre'];                
                $_SESSION['carrito'] = array();                 
                $_SESSION['carrito']['subtotal']    = 0;
                $_SESSION['carrito']['descuento']   = 0;

                echo "Agregados a la sesión <br>";
                header('Location: ../login.php?msg=cuentaExistente');
                exit();
            } 
             
            if ($datosUsuario['token'] != $tokenActivacion) 
            {                
                echo $datosUsuario['token'] . " - " . $tokenActivacion . "<br>";
                header('Location: ../activa-codigo.php?msg=tokenInvalido&correo=' . $idCliente);
                exit();
            }

            // continuacion                    
            $sql = "UPDATE usuarios SET password = ?, isActive = 1, token = 'NULL', fechaActivacion = ? WHERE email = ?";

            // Preparar y ejecutar la consulta preparada
            if ($stmt = $conn->prepare($sql)) 
            {
                $stmt->bind_param("sss", $password, $fechaActivacion, $idCliente); // Ligamos los parámetros a la consulta preparada
                $stmt->execute();
                
                if ($stmt->affected_rows > 0) 
                {

                    // Apunta a la carpeta del pedido
                    $target_dir = "usuarios/" . $idCliente;

                    if (!is_dir($target_dir)) 
                    {
                        mkdir($target_dir, 0777, true);
                    }

                    session_start();

                    $_SESSION['email']    = $idCliente;              
                    $_SESSION['isActive'] = $datosUsuario['isActive'];                
                    $_SESSION['nombre']   = $datosUsuario['nombre'];                
                    $_SESSION['carrito'] = array();                 
                    $_SESSION['carrito']['subtotal']    = 0;
                    $_SESSION['carrito']['descuento']   = 0;
                    
                    $_SESSION['carrito'] = array(); 
                    $_SESSION['carrito']['conteoTotalPlaquitas'] = 0;
                    $_SESSION['carrito']['creditos']    = 0; 
                    $_SESSION['carrito']['subtotal']    = 0;
                    $_SESSION['carrito']['descuento']   = 0;                    

                    // Recuperar el ID del usuario y del evento (asegúrate de validarlos)
                    $usuario_id = $_SESSION['email']; // Cambia esto por la forma en que obtienes el ID del usuario
                    $evento_id = "CN2023"; // Cambia esto por la forma en que obtienes el ID del evento
                    $fecha_hora_registro = date("Y-m-d H:i:s");

                    // Validaciones adicionales (puedes agregar más según tus necesidades)
                    // Validaciones de los datos antes de la inserción
                    if (empty($usuario_id) || empty($evento_id) || empty($fecha_hora_registro)) 
                    {
                        echo "<h2>Error: Todos los campos son obligatorios.</h2>";
                        die;
                    } 
                    else 
                    {
                        $sql = "INSERT INTO registro_asistencia (usuario_id, evento_id, fecha_hora_registro)
                                VALUES (?, ?, ?)";
                        $stmt = $conn->prepare($sql);

                        if (!$stmt) 
                        {
                            //echo "Error en la preparación de la consulta SQL: " . $conn->error;
                            header('Location: ../activa-codigo.php?msg=errorActivacion&correo=' . $idCliente);
                        } 
                        else 
                        {
                            $stmt->bind_param("sss", $usuario_id, $evento_id, $fecha_hora_registro);

                            if (!$stmt->execute()) 
                            {
                                //echo "Error al ejecutar la consulta SQL: " . $stmt->error;
                                header('Location: ../activa-codigo.php?msg=errorActivacion&correo=' . $idCliente);
                            } 
                            else 
                            {
                                //echo "Registro exitoso.";
                                exit(header('Location: acceso/'));
                            }
                        }   
                    }

                }
                else
                {
                    header('Location: ../activa-codigo.php?msg=errorActivacion&correo=' . $idCliente);
                    exit(); 
                }
            }
            else 
            {
                header('Location: ../activa-codigo.php?msg=errorActivacion&correo=' . $idCliente);
            }
        }
        else
        {
            header('Location: ../activa-codigo.php?msg=errorActivacion2&correo=' . $idCliente);
            exit(); 
        } 
    }

if (isset($_POST['btnLogin28'])) 
{
    
    if (isset($_POST['form_email'], $_POST['form_password'])) 
    {
        $redirect = $_POST['redirect'] ?? null;
        $vendedor = $_POST['vendedor'] ?? null;
        $error_message = null;
        
        $inputPassword = empty(trim($_POST['form_password'])) ? "#$&&(&/)##ASD3$!#$=$)?" : $_POST['form_password'];
        
        $form_email = trim($_POST['form_email']);
        
        if (!empty($form_email)) 
        {
            $form_email = mysqli_real_escape_string($conn, htmlspecialchars($form_email));
            
            $query = mysqli_query($conn, "SELECT * FROM `usuarios` WHERE email = '$form_email'");
            
            if (mysqli_num_rows($query) > 0) 
            {
                $row = mysqli_fetch_assoc($query);
                $usuario_db_pass = $row['password'];
                
                $verifico_password = ($inputPassword == $usuario_db_pass);
                
                $isActive = $row['isActive'];
                $isVerified = $row['isVerified'];
                
                $nombre = $row['nombre'];
                
                if ($isActive == 1) 
                {
                    if ($verifico_password) 
                    {
                        session_start();

                        $_SESSION['email']    = $form_email;                        
                        $_SESSION['isActive'] = $row['isActive'];                           
                        $_SESSION['isDistribuidor'] = $row['isDistribuidor'];
                        $_SESSION['nombre']   = $row['nombre'];
                        $_SESSION['paterno']  = $row['paterno'];
                        $_SESSION['materno']  = $row['materno'];
                        $_SESSION['telefono'] = $row['telefono'];
                        $_SESSION['creditos'] = $row['creditos'];

                        $_SESSION['rol']      = $row['rol'];

                        $_SESSION['carrito'] = array(); 
                        $_SESSION['carrito']['conteoTotalPlaquitas'] = 0;
                        $_SESSION['carrito']['creditos']    = 0;
                        $_SESSION['carrito']['subtotal']    = 0;
                        $_SESSION['carrito']['descuentos']  = 0;
                        $_SESSION['carrito']['precioEnvio'] = 0;
                        $_SESSION['carrito']['total']       = 0;
                        
                        // var_dump($redirect);
                        // die;

                        if (!is_null($redirect) && !empty($redirect)) 
                        {
                            header('Location: ' . $redirect . '?msg=redirected');
                            exit;
                        }
                        else
                        {
                            header('Location: index.php?msg=Welcome');
                            exit;
                        }
                        

                    } else {
                        $error_message = "errorCredencialesInvalidas";
                    }
                } else {
                    $error_message = "errorCuentaInactiva";
                }
            } else {
                $error_message = "errorCredencialesInvalidasNulo";
            }
        } else {
            $error_message = "errorDatosFaltantes";
        }
        
        header('Location: ../login.php?msg=' . $error_message . "&email=" . $form_email);
        exit();

    }
    else
    {
        echo "ax";
    }

}


?>