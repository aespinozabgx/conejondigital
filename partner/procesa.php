<?php

    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);

    session_start();

    require './vendor/autoload.php';

    require '../app/php/conexion.php';
    require 'php/funciones.php';
    //require 'php/config.php';

    //
    use Mpdf\QrCode\QrCode;
    use Mpdf\QrCode\Output;
    use Picqer\Barcode\BarcodeGeneratorSVG;
    // use Mpdf\Mpdf;

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
    use PhpOffice\PhpSpreadsheet\Style\Font;
    use PhpOffice\PhpSpreadsheet\Style\Alignment;

    $success_message;
    $error_message;    

    if (isset($_POST['btnCompraInvitado']) && $_SERVER['REQUEST_METHOD'] === 'POST')
    {
        // echo "<pre>";
        // print_r($_POST);
        
        $idTienda = $_POST['btnCompraInvitado'];
        
        // Define un array con los nombres de los campos que se esperan
        $camposEsperados = array(
            'correoInvitado',
            'nombreInvitado',
            'apellidoInvitado',
            'telefonoInvitado'
        );

        $datosFaltantes = array();

        // Verifica si todos los campos esperados están presentes
        foreach ($camposEsperados as $campo) 
        {
            if (!isset($_POST[$campo]) || empty($_POST[$campo])) 
            {
                $datosFaltantes[] = $campo;
            }
        }

        // Si hay datos faltantes, redirige con un mensaje en la URL
        if (!empty($datosFaltantes)) 
        {            
            header("Location: ../carrito.php?tienda=" . $idTienda . "&msg=datosFaltantesInvitado");
            exit;
        }

        // Validar si el correo ya existe en la tabla de usuarios
        $correoInvitado = $_POST['correoInvitado'];  

        // Consulta para verificar si el correo ya existe
        $sql = "SELECT id FROM usuarios WHERE email = '$correoInvitado'";
        $resultado = mysqli_query($conn, $sql);

        if (mysqli_num_rows($resultado) > 0) 
        {
            // El correo ya existe, redirige al login.php con los parámetros
            header("Location: ../app/index.php?msg=cuentaExistente&idtienda=$idTienda&redirect=pago.php&tienda=$idTienda");
            exit;
        }
        else 
        {
            // El correo no existe, puedes redirigir al registro            
            $sql = "INSERT INTO usuarios (nombre, paterno, materno, telefono, email, isActive, isVerified)
            VALUES ('$nombreInvitado', '$apellidoInvitado', '', '$telefonoInvitado', '$correoInvitado', 0, 0)";

            if (mysqli_query($conn, $sql)) 
            {                            
                // Si todos los datos están presentes, puedes procesarlos        
                $_SESSION['idCliente']  = $_POST['correoInvitado'];        
                $_SESSION['email']      = $_POST['correoInvitado'];
                $_SESSION['isVerified'] = 0;
                $_SESSION['isActive']   = 0;
                $_SESSION['nombre']     = $_POST['nombreInvitado'];
                $_SESSION['paterno']    = $_POST['apellidoInvitado']; 
                // Defino sesión invitado o en sql               
                            
                header("Location: ../pago.php?tienda=$idTienda");
                exit;
            } 
            else 
            {
                // Error en el registro
                //echo "Error al registrar el usuario invitado: " . mysqli_error($conn);
                header("Location: ../carrito.php?idtienda=$idTienda&msg=errorRegistroInvitado");
                exit;
            }                    
        }

        // Cierra la conexión a la base de datos
        mysqli_close($conn);
        
    }

    if (isset($_POST['btnDevolucion']))
    {
        // echo "<pre>";
        // print_r($_POST);
        
        if (!isset($_POST['idTienda']) || empty($_POST['idTienda']))
        {
            header('Location: detalleVenta.php?id=' . $_POST['idPedido']);
        }

        if (!isset($_POST['idPedido']) || empty($_POST['idPedido']))
        {
            header('Location: mis-ventas.php?msg=errorDatos');
        }
        
        $idPedido = $_POST['idPedido'];
        $idTienda = $_POST['idTienda'];

        $contadorRealizarDevolucion = 0;
        $arrayDevolucion = Array();
        

        foreach ($_POST as $name => $cantidad) 
        {
            if (strpos($name, 'P-') === 0)
            {
                if ($cantidad > 0) 
                {                    
                    // Es un idProducto                    
                    $arrayDevolucion[$contadorRealizarDevolucion]['idProducto'] = $name;
                    $arrayDevolucion[$contadorRealizarDevolucion]['cantidad'] = $cantidad;
                    $contadorRealizarDevolucion += 1;
                }
            }
        }

        if ($contadorRealizarDevolucion > 0) 
        {
            // Insertar en la tabla devoluciones
            $idVendedorResponsable = $_SESSION['email'];
            $fechaDevolucion = date('Y-m-d H:i:s'); // Fecha actual para la devolución
            $motivo = 'MOTIVO_DE_DEVOLUCION'; // Debes obtener el motivo de la devolución
            $observaciones = 'OBSERVACIONES'; // Opcional: Observaciones adicionales para la devolución
        
            $sqlInsertDevolucion = "INSERT INTO devoluciones (idPedido, idVendedorResponsable, fechaDevolucion, motivo, observaciones) VALUES ('$idPedido', '$idVendedorResponsable', '$fechaDevolucion', '$motivo', '$observaciones')";
            
            // Ejecutar la consulta de inserción para la tabla devoluciones
            // (Asegúrate de manejar adecuadamente la conexión a la base de datos y los errores de la consulta)
            $resultadoInsertDevolucion = mysqli_query($conn, $sqlInsertDevolucion);
        
            if ($resultadoInsertDevolucion) 
            {
        
                // Recorrer el array de productos a devolver
                $insertsDetalleDevolucion = array();

                foreach ($arrayDevolucion as $item) 
                {
                    $idProducto = $item['idProducto'];
                    $cantidadDevuelta = $item['cantidad'];

                    // Construir la parte del VALUES para cada fila
                    $insertsDetalleDevolucion[] = "('$idPedido', '$idTienda', '$idProducto', '$cantidadDevuelta')";
                }

                // Combinar las partes VALUES en un solo INSERT masivo
                $sqlInsertDetalleDevolucion = "INSERT INTO detalledevolucion (idPedido, idTienda, idProducto, cantidadDevuelta) VALUES " . implode(", ", $insertsDetalleDevolucion);

                // Ejecutar la consulta de inserción masiva para la tabla detalledevolucion
                // (Asegúrate de manejar adecuadamente la conexión a la base de datos y los errores de la consulta)
                $resultadoInsertDetalleDevolucion = mysqli_query($conn, $sqlInsertDetalleDevolucion);
        
                // Mostrar mensaje de éxito o redireccionar a otra página, si es necesario
                echo "Devolución registrada correctamente.";
            } 
            else 
            {
                // Mostrar mensaje de error o redireccionar a otra página, si es necesario
                echo "Error al registrar la devolución.";
            }
        } 
        else 
        {
            echo "No hay nada por devolver";
        }
        
        
    }

    if (isset($_POST['btnCalificaPedido']))
    {
        if (isset($_POST['rate'], $_POST['comentarios'], $_SESSION['email'], $_POST['idTienda']))
        {
            $calificacion = $_POST['rate'];
            $comentarios  = $_POST['comentarios'];
            $fechaCalificacion = date("Y-m-d H:i:s");
            $idPedido = $_POST['btnCalificaPedido'];
            $idTienda = $_POST['idTienda'];
            $idCliente = $_SESSION['email'];

            $sql = "INSERT INTO `reputacionTienda` (`id`, `idPedido`, `idTienda`, `idCliente`, `calificacion`, `comentario`, `fechaCalificacion`) VALUES (NULL, '$idPedido', '$idTienda', '$idCliente', '$calificacion', '$comentarios', '$fechaCalificacion')";

            // Ejecutar la consulta y verificar si se insertó correctamente
              if (mysqli_query($conn, $sql))
              {
                  exit(header('Location: detalleCompra.php?id='. $idPedido .'&msg=pedidoCalificado'));
              }
              else
              {
                  exit(header('Location: detalleCompra.php?id='. $idPedido .'&msg=errorPedidoCalificado'));
              }
        }
        else
        {
            exit(header('Location: detalleCompra.php?msg=errorDatosFaltantes'));
        }
    }

    if (isset($_POST['btnGuardarDireccionEntregaCliente']))
    {
        // echo "<pre>";
        // print_r($_POST);

        if (!isset($_SESSION['email']) || empty($_SESSION['email']))
        {
            header('Location: cuenta-direcciones.php?msg=errorDatosFaltantesNuevaSucursalEntrega');
        }

        $idCliente = $_SESSION['email'];

        $aliasDireccion = $_POST['nombreDireccion_Sucursal'];
        $cp_DEC         = $_POST['cp_direccionEntregaCliente'];
        $estado_DEC     = $_POST['estado_direccionEntregaCliente'];
        $mun_alc_DEC    = $_POST['mun_alc_direccionEntregaCliente'];
        $colonia_DEC    = $_POST['colonia_direccionEntregaCliente'];
        $calle_DEC      = $_POST['calle_direccionEntregaCliente'];
        $exterior_DEC   = $_POST['exterior_direccionEntregaCliente'];
        $interior_DEC   = $_POST['interior_direccionEntregaCliente'];
        $telefono_DEC   = $_POST['telefono_direccionEntregaCliente'];
        $entre_calles_DEC  = $_POST['entre_calles_direccionEntregaCliente'];
        $entre_calles2_DEC = $_POST['entre_calles2_direccionEntregaCliente'];
        $indicaciones_DEC  = $_POST['indicaciones_direccionEntregaCliente'];
        $is_principal_DEC  = $_POST['is_principal_direccionEntregaCliente'];
        $isActive = 1;
        $direccion = $calle_DEC . ' ' . 'Exterior ' . $exterior_DEC . ' ';

        if (!empty($interior_DEC))
        {
            $direccion .= 'Interior ' . $interior_DEC;
        }

        $direccion .= ', ' . $colonia_DEC . ', ' . $mun_alc_DEC . ', ' . $estado_DEC . '. CP: ' . $cp_DEC . '.';

        $direccion .= " Tel. " . $telefono_DEC;

        if (isset($_POST['indicaciones_direccionEntregaCliente'], $_POST['is_principal_direccionEntregaCliente']) && !empty($entre_calles_DEC) && !empty($entre_calles2_DEC))
        {
            $direccion .= " Entre calle " . $entre_calles_DEC . " y " . $entre_calles2_DEC;
        }


        if (isset($indicaciones_DEC) && !empty($indicaciones_DEC))
        {
            $direccion .= " Indicaciones adicionales:  " . $indicaciones_DEC;
        }


        $isPrincipal = "0";
        if ($is_principal_DEC == "1")
        {
            $isPrincipal = "1";
        }

        $fechaRegistroDireccion = date("Y-m-d H:i:s");
        $redirect = $_POST['btnGuardarDireccionEntregaCliente'];
        $idTienda = $_POST['idTienda'];

        $idDireccion = generaIdDireccionEntrega($conn, $idCliente);
        // Construir la consulta INSERT con los valores dados
        $sql = "INSERT INTO direccionesClientes (id, idDireccion, idCliente, aliasDireccion, direccion, isPrincipal, fechaRegistroDireccion, isActive)
                VALUES (NULL, '$idDireccion', '$idCliente', '$aliasDireccion', '$direccion', '$isPrincipal', '$fechaRegistroDireccion','$isActive')";

        // Ejecutar la consulta y verificar si se realizó correctamente
        if (mysqli_query($conn, $sql)) {
            $msg = "direccionClienteRegistrada";
            // echo "La consulta INSERT se realizó correctamente";
        } else {
            $msg = "direccionClienteNoRegistrada";
            // echo "Error al ejecutar la consulta: " . mysqli_error($conn);
        }

        if ($redirect == "pago.php")
        {
            header('Location: ../' . $redirect . '?tienda=' . $idTienda . '&msg=' . $msg);
        }
        else
        {
            header('Location: ' . $redirect . '?msg=' . $msg);
        }

    }

    if (isset($_POST['btnCierreTurnoCaja']))
    {
        if ((!isset($_POST['efectivoFinalCaja']) && strlen($_POST['efectivoFinalCaja'])<1) && !isset($_SESSION['managedStore']) || !isset($_SESSION['email']))
        {
            exit(header('Location: dashboard.php?msg=errorCierreCaja'));
        }

        $idTienda     = $_SESSION['managedStore'];
        $idUsuario    = $_SESSION['email'];
        $efectivoIngresadoPorCajero = $_POST['efectivoFinalCaja'];
        $diferencia   = $_POST['diferenciaCaja'];
        $turno        = isTurnoCajaActivo($conn, $idTienda, $idUsuario);
        $fechaCierre  = date("Y-m-d H:i:s");


        // Calcular total en caja
        $responseAperturaCaja = isTurnoCajaActivo($conn, $idTienda, $idUsuario); // apertura caja
        $totalCajaEfectivo    = 0;
        if ($responseAperturaCaja['estatus']  == true)
        {
            $fechaInicioTurno = date("Y-m-d H:i:s", strtotime($responseAperturaCaja['fechaApertura']));
            $fechaActual      = $fechaCierre;
            $aperturaCaja         = $responseAperturaCaja['efectivoInicial'];
            $ingresosEgresos      = obtener_ingresos_y_egresos_por_tienda($conn, $idTienda, $fechaInicioTurno, $fechaActual);
            $ventasEfectivoTurno  = consultarPedidosEfectivoTurno($conn, $idTienda, $fechaInicioTurno, $fechaActual);
            $totalCajaEfectivo    = ($ventasEfectivoTurno + $ingresosEgresos['ingresos']) - ($ingresosEgresos['egresos'] - $aperturaCaja);
        }

        if ($turno['estatus'] === false)
        {
            exit(header('Location: dashboard.php?msg=errorCierreCajaCerrada'));
        }

        // SQL para Cerrar Turno en tabla: bitacoraCaja
        $sql = "UPDATE bitacoraCaja SET fechaCierre = '$fechaCierre', efectivoFinal = '$efectivoIngresadoPorCajero', totalEfectivoEnCaja = '$totalCajaEfectivo' WHERE id = {$turno['idTurno']}";

        // Execute the SQL query
        $result = mysqli_query($conn, $sql);

        // Check if the query was executed successfully
        if (!$result)
        {
            // Error al cerrar turno
            //echo $error_message = mysqli_error($conn);
            exit(header('Location: dashboard.php?msg=errorCierreCajaSQL'));
        }

        // AJUSTE DE CAJA SI HAY EXCEDENTE O FALTANTE =======================
        if ($efectivoIngresadoPorCajero == $totalCajaEfectivo)
        {
            //echo "iguales, redirecciona<br>";
            $diferencia = abs(($totalCajaEfectivo - $efectivoIngresadoPorCajero));
            exit(header('Location: dashboard.php?msg=turnoCajaCerradoCorrectamente'));
        }
        elseif ($efectivoIngresadoPorCajero < $totalCajaEfectivo)
        {
            // echo "faltante<br>";
            $diferencia = abs(($totalCajaEfectivo - $efectivoIngresadoPorCajero));
            $tipoMovimiento = "Egreso Efectivo";
        }
        elseif ($efectivoIngresadoPorCajero > $totalCajaEfectivo)
        {
            // echo "excedente<br>";
            $diferencia = abs(($totalCajaEfectivo - $efectivoIngresadoPorCajero));
            $tipoMovimiento = "Ingreso Efectivo";
        }

        $concepto = "Ajuste Caja";

        // Construyo SQL para ajustar caja en tabla DB: ingresos_egresos_Tienda
        $sql = "INSERT INTO ingresos_egresos_Tienda (idTienda, idUsuario, idTipoMovimiento, fechaMovimiento, concepto, monto) VALUES ('$idTienda', '$idUsuario', '$tipoMovimiento', '$fechaCierre', '$concepto', '$diferencia')";
        $result = mysqli_query($conn, $sql);

        // Check if the query was executed successfully
        if ($result)
        {
            exit(header('Location: dashboard.php?msg=turnoCajaCerradoCajaAjustada'));
            // echo "<br>turnoCajaCerradoCajaAjustada";
        }
        else
        {
            exit(header('Location: dashboard.php?msg=errorAjusteCajaSQL'));
            // echo "<br>errorAjusteCajaSQL";
        }
    }

    if (isset($_POST['btnGuardarEmailTienda']))
    {
        $email = $_POST['emailTienda'];
        $idTienda = $_SESSION['managedStore'];
        // Verificar si hay un registro con los criterios de búsqueda especificados
        $resultado = mysqli_query($conn, "SELECT * FROM contactoTiendas WHERE idMediosContacto = 'MC-2' AND idTienda = '$idTienda'");
        $num_filas = mysqli_num_rows($resultado);

        if ($num_filas > 0)
        {
            // Si hay al menos un registro, actualizar el campo data
            $query = "UPDATE contactoTiendas SET data = '$email' WHERE idMediosContacto = 'MC-2' AND idTienda = '$idTienda'";
            mysqli_query($conn, $query);

            // Verificar si se realizó la actualización correctamente
            if (mysqli_affected_rows($conn) > 0)
            {
                exit(header("Location: configura-contactoTienda.php?msg=emailActualizado"));
            }
            else
            {
                exit(header("Location: configura-contactoTienda.php?msg=emailErrorActualizar"));
            }
        }
        else
        {
            // Si no hay resultados, insertar un nuevo registro
            $query = "INSERT INTO contactoTiendas (idTienda, idMediosContacto, data, isPublicOnline, isActive) VALUES ('$idTienda', 'MC-2', '$email', 1, 1)";
            mysqli_query($conn, $query);

            // Verificar si se realizó la inserción correctamente
            if (mysqli_affected_rows($conn) > 0)
            {
                exit(header("Location: configura-contactoTienda.php?msg=emailInsertado"));
            }
            else
            {
                exit(header("Location: configura-contactoTienda.php?msg=emailErrorInsertar"));
            }
        }
    }

    if (isset($_POST['btnGuardarYoutubeTienda']))
    {
        $youtube = $_POST['youtubeTienda'];
        $idTienda = $_SESSION['managedStore'];
        // Verificar si hay un registro con los criterios de búsqueda especificados
        $resultado = mysqli_query($conn, "SELECT * FROM contactoTiendas WHERE idMediosContacto = 'MC-6' AND idTienda = '$idTienda'");
        $num_filas = mysqli_num_rows($resultado);

        if ($num_filas > 0)
        {
            // Si hay al menos un registro, actualizar el campo data
            $query = "UPDATE contactoTiendas SET data = '$youtube' WHERE idMediosContacto = 'MC-6' AND idTienda = '$idTienda'";
            mysqli_query($conn, $query);

            // Verificar si se realizó la actualización correctamente
            if (mysqli_affected_rows($conn) > 0)
            {
                exit(header("Location: configura-contactoTienda.php?msg=instagramActualizado"));
            }
            else
            {
                exit(header("Location: configura-contactoTienda.php?msg=instagramErrorActualizar"));
            }
        }
        else
        {
            // Si no hay resultados, insertar un nuevo registro
            $query = "INSERT INTO contactoTiendas (idTienda, idMediosContacto, data, isPublicOnline, isActive) VALUES ('$idTienda', 'MC-6', '$youtube', 1, 1)";
            mysqli_query($conn, $query);

            // Verificar si se realizó la inserción correctamente
            if (mysqli_affected_rows($conn) > 0)
            {
                exit(header("Location: configura-contactoTienda.php?msg=instagramInsertado"));
            }
            else
            {
                exit(header("Location: configura-contactoTienda.php?msg=instagramErrorInsertar"));
            }
        }
    }

    if (isset($_POST['btnGuardarInstagramTienda']))
    {
        $instagram = $_POST['instagramTienda'];
        $idTienda = $_SESSION['managedStore'];
        // Verificar si hay un registro con los criterios de búsqueda especificados
        $resultado = mysqli_query($conn, "SELECT * FROM contactoTiendas WHERE idMediosContacto = 'MC-4' AND idTienda = '$idTienda'");
        $num_filas = mysqli_num_rows($resultado);

        if ($num_filas > 0)
        {
            // Si hay al menos un registro, actualizar el campo data
            $query = "UPDATE contactoTiendas SET data = '$instagram' WHERE idMediosContacto = 'MC-4' AND idTienda = '$idTienda'";
            mysqli_query($conn, $query);

            // Verificar si se realizó la actualización correctamente
            if (mysqli_affected_rows($conn) > 0)
            {
                exit(header("Location: configura-contactoTienda.php?msg=instagramActualizado"));
            }
            else
            {
                exit(header("Location: configura-contactoTienda.php?msg=instagramErrorActualizar"));
            }
        }
        else
        {
            // Si no hay resultados, insertar un nuevo registro
            $query = "INSERT INTO contactoTiendas (idTienda, idMediosContacto, data, isPublicOnline, isActive) VALUES ('$idTienda', 'MC-4', '$instagram', 1, 1)";
            mysqli_query($conn, $query);

            // Verificar si se realizó la inserción correctamente
            if (mysqli_affected_rows($conn) > 0)
            {
                exit(header("Location: configura-contactoTienda.php?msg=instagramInsertado"));
            }
            else
            {
                exit(header("Location: configura-contactoTienda.php?msg=instagramErrorInsertar"));
            }
        }
    }

    if (isset($_POST['btnGuardarFacebookTienda']))
    {
        $facebook = $_POST['facebookTienda'];
        $idTienda = $_SESSION['managedStore'];
        // Verificar si hay un registro con los criterios de búsqueda especificados
        $resultado = mysqli_query($conn, "SELECT * FROM contactoTiendas WHERE idMediosContacto = 'MC-3' AND idTienda = '$idTienda'");
        $num_filas = mysqli_num_rows($resultado);

        if ($num_filas > 0)
        {
            // Si hay al menos un registro, actualizar el campo data
            $query = "UPDATE contactoTiendas SET data = '$facebook' WHERE idMediosContacto = 'MC-3' AND idTienda = '$idTienda'";
            mysqli_query($conn, $query);

            // Verificar si se realizó la actualización correctamente
            if (mysqli_affected_rows($conn) > 0)
            {
                exit(header("Location: configura-contactoTienda.php?msg=facebookActualizado"));
            }
            else
            {
                exit(header("Location: configura-contactoTienda.php?msg=facebookErrorActualizar"));
            }
        }
        else
        {
            // Si no hay resultados, insertar un nuevo registro
            $query = "INSERT INTO contactoTiendas (idTienda, idMediosContacto, data, isPublicOnline, isActive) VALUES ('$idTienda', 'MC-3', '$facebook', 1, 1)";
            mysqli_query($conn, $query);

            // Verificar si se realizó la inserción correctamente
            if (mysqli_affected_rows($conn) > 0)
            {
                exit(header("Location: configura-contactoTienda.php?msg=facebookInsertado"));
            }
            else
            {
                exit(header("Location: configura-contactoTienda.php?msg=facebookErrorInsertar"));
            }
        }
    }

    if (isset($_POST['btnGuardarWhatsappTienda']))
    {
        if (strlen($_POST['whatsappTienda']) != 10)
        {
            exit(header('Location: configura-contactoTienda.php?msg=whatsappErrorLongitud'));
        }
        $whatsapp = $_POST['whatsappTienda'];
        $idTienda = $_SESSION['managedStore'];
        // Verificar si hay un registro con los criterios de búsqueda especificados
        $resultado = mysqli_query($conn, "SELECT * FROM contactoTiendas WHERE idMediosContacto = 'MC-5' AND idTienda = '$idTienda'");
        $num_filas = mysqli_num_rows($resultado);

        if ($num_filas > 0)
        {
            // Si hay al menos un registro, actualizar el campo data
            $query = "UPDATE contactoTiendas SET data = '$whatsapp' WHERE idMediosContacto = 'MC-5' AND idTienda = '$idTienda'";
            mysqli_query($conn, $query);

            // Verificar si se realizó la actualización correctamente
            if (mysqli_affected_rows($conn) > 0)
            {
                exit(header("Location: configura-contactoTienda.php?msg=whatsappActualizado"));
            }
            else
            {
                exit(header("Location: configura-contactoTienda.php?msg=whatsappErrorActualizar"));
            }
        }
        else
        {
            // Si no hay resultados, insertar un nuevo registro
            $query = "INSERT INTO contactoTiendas (idTienda, idMediosContacto, data, isPublicOnline, isActive) VALUES ('$idTienda', 'MC-5', '$whatsapp', 1, 1)";
            mysqli_query($conn, $query);

            // Verificar si se realizó la inserción correctamente
            if (mysqli_affected_rows($conn) > 0)
            {
                exit(header("Location: configura-contactoTienda.php?msg=whatsappInsertado"));
            }
            else
            {
                exit(header("Location: configura-contactoTienda.php?msg=whatsappErrorInsertar"));
            }
        }


    }

    if (isset($_POST['btnIniciarTurnoCaja']))
    {
        //echo "btnIniciarTurnoCaja<br><br>";
        echo "<pre>";
        print_r($_POST);


        // Check for required session and post variables
        if (empty($_SESSION['managedStore']) ||
            empty($_SESSION['email']) ||
            !isset($_POST['efectivoInicialCaja']) ||
            !is_numeric($_POST['efectivoInicialCaja']) || // Validate numeric input
            $_POST['efectivoInicialCaja'] < 0)            // Validate against a specific condition 
        {
            exit(header('Location: dashboard.php?msg=errorAperturaTurno'));
        }

        // var_dump(empty($_SESSION['managedStore']));
        // var_dump(empty($_SESSION['email']));
        // var_dump(!isset($_POST['efectivoInicialCaja']));
        // var_dump(!is_numeric($_POST['efectivoInicialCaja']));
        // die;

        // Assign values after ensuring they exist and are valid
        $idTienda  = $_SESSION['managedStore'];
        $idUsuario = $_SESSION['email'];
        $fechaAperturaCaja   = date("Y-m-d H:i:s");
        $efectivoInicialCaja = $_POST['efectivoInicialCaja'];

        $isTurnoCajaActivo = isTurnoCajaActivo($conn, $idTienda, $idUsuario);

        // Check if a cash register is already active
        if ($isTurnoCajaActivo['estatus'] === true) 
        {
            die("Ya hay un turno iniciado: " . $isTurnoCajaActivo['estatus']);
        } 
 
        // Ejecutar la consulta
        $sql = "INSERT INTO `bitacoraCaja` (idTienda, idUsuario, fechaApertura, efectivoInicial) VALUES ('$idTienda', '$idUsuario', '$fechaAperturaCaja', '$efectivoInicialCaja')";

        if ($conn->query($sql) === TRUE)
        {
            //echo "El registro se ha creado correctamente";
            exit(header('Location: dashboard.php?msg=aperturaTurnoCajaExitoso&montoAbonado=' . $efectivoInicialCaja . '#moduloCaja'));
        }
        else
        {
            //echo "Error al crear el registro: " . $conn->error;
            exit(header('Location: dashboard.php?msg=aperturaTurnoCajaErroneo'));
        }
    }

    if (isset($_POST['idUsuario'], $_POST['idTienda'], $_POST['btnCerrarCaja']))
    {
        //echo "btnCerrarCaja";
        echo "<br>".$idUsuario     = $_POST['idUsuario'];
        echo "<br>".$idTienda      = $_POST['idTienda'];
        echo "<br>".$btnCerrarCaja = $_POST['btnCerrarCaja'];
    }

    if (isset($_POST['btnSaveTelTienda']))
    {
        $telefono = $_POST['telTienda'];
        $idTienda = $_SESSION['managedStore'];
        // Verificar si hay un registro con los criterios de búsqueda especificados
        $resultado = mysqli_query($conn, "SELECT * FROM contactoTiendas WHERE idMediosContacto = 'MC-1' AND idTienda = '$idTienda'");
        $num_filas = mysqli_num_rows($resultado);

        if ($num_filas > 0)
        {
            // Si hay al menos un registro, actualizar el campo data
            $query = "UPDATE contactoTiendas SET data = '$telefono' WHERE idMediosContacto = 'MC-1' AND idTienda = '$idTienda'";
            mysqli_query($conn, $query);

            // Verificar si se realizó la actualización correctamente
            if (mysqli_affected_rows($conn) > 0)
            {
                exit(header("Location: configura-contactoTienda.php?msg=telefonoActualizado"));
            }
            else
            {
                exit(header("Location: configura-contactoTienda.php?msg=telefonoErrorActualizar"));
            }
        }
        else
        {
            // Si no hay resultados, insertar un nuevo registro
            $query = "INSERT INTO contactoTiendas (idTienda, idMediosContacto, data, isPublicOnline, isActive) VALUES ('$idTienda', 'MC-1', '$telefono', 1, 1)";
            mysqli_query($conn, $query);

            // Verificar si se realizó la inserción correctamente
            if (mysqli_affected_rows($conn) > 0)
            {
                exit(header("Location: configura-contactoTienda.php?msg=telefonoInsertado"));
            }
            else
            {
                exit(header("Location: configura-contactoTienda.php?msg=telefonoErrorInsertar"));
            }
        }
    }

    if (isset($_POST['btnSetupTienda']))
    {
        if (isset($_POST['idTienda'], $_POST['nombreTienda'], $_SESSION['email']))
        {
            $idTienda     = limpiarDato($_POST['idTienda']);
            $nombreTienda = limpiarDato($_POST['nombreTienda']);
            $administradoPor = $_SESSION['email'];
            $isActive = 1;

            if (!isIdTiendaAvailable($conn, $idTienda))
            {
                exit(header('Location: setup_tienda.php?msg=idTiendaNoDisponible'));
            }

            $sql = "INSERT INTO tiendas (idTienda, nombreTienda, administradoPor, isActive)
                    VALUES ('$idTienda', '$nombreTienda', '$administradoPor', $isActive)";

            if (mysqli_query($conn, $sql))
            {

                $_SESSION['managedStore'] = $idTienda;
                $_SESSION['nombreTienda'] = $nombreTienda;

                $pathUser = 'verifica/usr_docs/' . $idTienda;
                if(!is_dir($pathUser))
                {
                    if (mkdir($pathUser, 0777, true))
                    {
                        //echo "Ok";
                    }
                }

                // Si la inserción fue exitosa, redirigir al usuario a la página de éxito
                header('Location: dashboard.php?msg=welcome');
                exit;
            }
            else
            {
                // Si hubo un error en la inserción, mostrar un mensaje de error
                header('Location: setup_tienda.php?msg=errorRegistroCuenta');
                exit();
            }

        }
    }

    if (isset($_POST['btnContinuarTurno'], $_POST['idTienda'], $_POST['notificacionAperturaCaja']))
    {
        // ==== CONTINUAR TURNO =====
        //echo "btnContinuarTurno";
        $_SESSION['keepAlertaCajaAbierta'] = false;
        exit(header('Location: dashboard.php#caja'));
    }

    if (isset($_POST['btnActualizarSucursal']))
    {
        //echo "btnActualizarSucursal";
        // echo "<pre>";
        // print_r($_POST);
        // die;
        if(isset($_SESSION['managedStore']) && isset($_POST['idSucursal'], $_POST['nombre_sucursal'], $_POST['cp_sucursal'], $_POST['estado_sucursal'], $_POST['calle_sucursal'], $_POST['colonia_sucursal'], $_POST['exterior_sucursal'], $_POST['telefono_sucursal'], $_POST['mun_alc_sucursal']) &&
          !empty($_POST['idSucursal'])        &&
          !empty($_POST['nombre_sucursal'])   &&
          !empty($_POST['cp_sucursal'])       &&
          !empty($_POST['estado_sucursal'])   &&
          !empty($_POST['mun_alc_sucursal'])  &&
          !empty($_POST['calle_sucursal'])    &&
          !empty($_POST['colonia_sucursal'])  &&
          !empty($_POST['exterior_sucursal']) &&
          !empty($_POST['telefono_sucursal']))
        {

            $idTienda           = $_SESSION['managedStore'];
            $idSucursal         = $_POST['idSucursal'];
            $nombre_sucursal    = trim(htmlspecialchars($_POST['nombre_sucursal']));
            $cp_sucursal        = trim(htmlspecialchars($_POST['cp_sucursal']));
            $estado_sucursal    = trim(htmlspecialchars($_POST['estado_sucursal']));
            $mun_alc_sucursal   = trim(htmlspecialchars($_POST['mun_alc_sucursal']));
            $colonia_sucursal   = trim(htmlspecialchars($_POST['colonia_sucursal']));
            $calle_sucursal     = trim(htmlspecialchars($_POST['calle_sucursal']));
            $exterior_sucursal  = trim(htmlspecialchars($_POST['exterior_sucursal']));
            $telefono_sucursal  = trim(htmlspecialchars($_POST['telefono_sucursal']));
            $isActive = 1;

            // Validar que el código postal tenga 5 caracteres y sean solo números, almacenamos
            if(isset($_POST['cp_sucursal']) && strlen($_POST['cp_sucursal']) == 5 && is_numeric($_POST['cp_sucursal']))
            {
                $cp_sucursal = $_POST['cp_sucursal'];
            }
            else
            {
                // El código postal no es válido, mostrar un mensaje de error
                $uploadFlag    = false;
                $error_message = "El código postal debe tener 5 caracteres y ser solo numérico.";
                exit(header('Location: configura-sucursales.php?msg=' . $error_message));
            }

            // Verificar si se recibió la variable $interior_sucursal
            $interior_sucursal = NULL;
            if(isset($_POST['interior_sucursal']))
            {
                // Almacenar el valor recibido en la variable $interior_sucursal
                $interior_sucursal = $_POST['interior_sucursal'];
            }

            // Verificar si se recibió la variable $entre_calles_sucursal
            $entre_calles_sucursal = NULL;
            if(isset($_POST['entre_calles_sucursal']))
            {
                // Almacenar el valor recibido en la variable $entre_calles_sucursal
                $entre_calles_sucursal = $_POST['entre_calles_sucursal'];
            }

            // Verificar si se recibió la variable $entre_calles2_sucursal
            $entre_calles2_sucursal = NULL;
            if(isset($_POST['entre_calles2_sucursal']))
            {
                // Almacenar el valor recibido en la variable $entre_calles2_sucursal
                $entre_calles2_sucursal = $_POST['entre_calles2_sucursal'];
            }

            // Verificar si se recibió la variable $indicaciones_sucursal
            $indicaciones_sucursal = NULL;
            if(isset($_POST['indicaciones_sucursal']))
            {
                // Almacenar el valor recibido en la variable $indicaciones_sucursal
                $indicaciones_sucursal = $_POST['indicaciones_sucursal'];
            }

            // Verificar si se recibió la variable $is_principal_sucursal
            $is_principal_sucursal = 0;
            if(isset($_POST['is_principal_sucursal']))
            {
                // Almacenar el valor recibido en la variable $is_principal_sucursal
                $is_principal_sucursal = $_POST['is_principal_sucursal'];
            }

            // Consultar id, nombre, isPrincipal y hacer validaciones
            $sqlConsulta    = "SELECT idSucursal, nombreSucursal, isPrincipal FROM sucursalesTienda WHERE idTienda = '$idTienda' AND isActive = 1 AND idSucursal != '$idSucursal'";
            $resultConsulta = mysqli_query($conn, $sqlConsulta);

            if (mysqli_num_rows($resultConsulta) > 0)
            {
                // output data of each row
                while ($row = mysqli_fetch_assoc($resultConsulta))
                {
                    $sucursalesDB[] = $row;
                }
            }
            else
            {
                $sucursalesDB = false;
                $is_principal_sucursal = 1;
            }

            $eliminar_sucursal_principal = false;
            if ($sucursalesDB !== false)
            {
                foreach ($sucursalesDB as $key => $value)
                {
                    if (limpiarDato($value['nombreSucursal']) == limpiarDato($nombre_sucursal))
                    {
                        exit(header('Location: configura-sucursales.php?msg=sucursalNombreExistente'));
                    }

                    // Si hay una sucursal principal activo flag para cambiar todas las sucursales idPrincipal=0 antes de insertar
                    if ($is_principal_sucursal == 1)
                    {
                        if ($value['isPrincipal'] == 1)
                        {
                            $eliminar_sucursal_principal = true;
                        }
                    }
                }
            }

            // Actualizar todas las sucursales [isPrincipal = 0]
            if ($eliminar_sucursal_principal === true)
            {
                $sql = "UPDATE `sucursalesTienda` SET isPrincipal = 0 WHERE idTienda = '$idTienda'";
                if ($conn->query($sql) === TRUE)
                {
                    // echo "Consulta ejecutada exitosamente";
                }
            }

            // Insertamos en Base de datos
            $sql = "UPDATE sucursalesTienda
                    SET nombreSucursal = '$nombre_sucursal',
                        codigoPostal   = '$cp_sucursal',
                        estado         = '$estado_sucursal',
                        municipioAlcaldia = '$mun_alc_sucursal',
                        colonia           = '$colonia_sucursal',
                        calle             = '$calle_sucursal',
                        numeroExterior    = '$exterior_sucursal',
                        interiorDepto     = '$interior_sucursal',
                        entreCalle1       = '$entre_calles_sucursal',
                        entreCalle2       = '$entre_calles2_sucursal',
                        telefono          = '$telefono_sucursal',
                        indicacionesAdicionales = '$indicaciones_sucursal',
                        isPrincipal = '$is_principal_sucursal'
                    WHERE idTienda  = '$idTienda' AND idSucursal = '$idSucursal'";

            // Ejecutar la sentencia SQL y verificar si se ejecutó correctamente
            if (mysqli_query($conn, $sql))
            {
                // if (mysqli_affected_rows($conn) > 0)
                // {
                //     mysqli_close($conn);
                //     $success_message = "actualizacionExitosaSucursal";
                //     header('Location: configura-sucursales.php?msg=' . $success_message);
                //     exit();
                // }
                // else
                // {
                //     mysqli_close($conn);
                //     $error_message = "";
                //     header('Location: configura-sucursales.php?msg=' . $error_message);
                //     exit();
                // }
                mysqli_close($conn);
                $success_message = "actualizacionExitosaSucursal";
                header('Location: configura-sucursales.php?msg=' . $success_message);
                exit();
            }
            else
            {
                mysqli_close($conn);
                $error_message = "actualizacionErroneaSucursal";
                header('Location: configura-sucursales.php?msg=' . $error_message);
                exit();
            }
        }
        else
        {
            // echo "<pre>";
            // print_r($_POST);
            // print_r($_SESSION);
            // die;
            // Cierra la sentencia y la conexión, redirección
            mysqli_close($conn);
            $error_message = "actualizacionDatosFaltantesSucursal";
            exit(header('Location: configura-sucursales.php?msg=' . $error_message));
        }
    }

    if (isset($_POST['btnEliminarSucursal'], $_POST['idSucursal'], $_SESSION['managedStore']))
    {
        $idSucursal = $_POST['idSucursal'];
        $idTienda   = $_SESSION['managedStore'];

        // Verificar si la conexión fue exitosa
        if ($conn->connect_error)
        {
            die("La conexión a la base de datos falló: " . $conn->connect_error);
        }

        // Sentencia preparada para actualizar la base de datos
        $stmt = $conn->prepare("UPDATE sucursalesTienda SET isActive = 0 WHERE id = ? AND idTienda = ?");
        $stmt->bind_param("ss", $idSucursal, $idTienda);
        $stmt->execute();

        // Verificar si la consulta se ejecutó correctamente
        if ($stmt->affected_rows > 0)
        {
            // echo "La consulta se ejecutó correctamente";
            $stmt->close();
            $conn->close();
            $error_message = "exitoEliminarSucursal";
            exit(header('Location: configura-sucursales.php?msg=' . $error_message));
        }
        else
        {
            // echo "La consulta no se ejecutó correctamente:" . mysqli_error($conn);
            $stmt->close();
            $conn->close();
            $error_message = "errorEliminarSucursal";
            exit(header('Location: configura-sucursales.php?msg=' . $error_message));
        }
    }

    if (isset($_POST['btnRegistrarIngresoCaja']))
    {
        $idTienda  = $_SESSION['managedStore'];
        $idUsuario = $_SESSION['email'];
        $fechaMovimiento = date("Y-m-d H:i:s");
        $montoIngresadoPorCajero    = $_POST['montoIngreso'] ?? 0;
        $conceptoIngreso = $_POST['conceptoIngreso'] ?? '';
        $tipoMovimiento  = ($_POST['btnRegistrarIngresoCaja'] == "Ingreso") ? "Ingreso Efectivo" : "Egreso Efectivo";

        // Calcular total en caja
        $totalCajaEfectivo = 0;
        $responseAperturaCaja = isTurnoCajaActivo($conn, $idTienda, $idUsuario); // apertura caja
        if ($responseAperturaCaja['estatus']  == true)
        {
            $fechaInicioTurno = date("Y-m-d H:i:s", strtotime($responseAperturaCaja['fechaApertura']));
            $fechaActual      = date("Y-m-d H:i:s");
            $aperturaCaja         = $responseAperturaCaja['efectivoInicial'];
            $ingresosEgresos      = obtener_ingresos_y_egresos_por_tienda($conn, $idTienda, $fechaInicioTurno, $fechaActual);
            $ventasEfectivoTurno  = consultarPedidosEfectivoTurno($conn, $idTienda, $fechaInicioTurno, $fechaActual);

            $totalCajaEfectivo = ($ventasEfectivoTurno + $ingresosEgresos['ingresos']) - ($ingresosEgresos['egresos'] - $aperturaCaja);
        }
        // Calcular total en caja

        if (empty($montoIngresadoPorCajero) || empty($conceptoIngreso))
        {
            exit(header('Location: dashboard.php?msg=datosInsuficientesAbonoCaja'));
        }

        $montoIngresadoPorCajero = floatval($montoIngresadoPorCajero);

        if ($totalCajaEfectivo < $montoIngresadoPorCajero && $_POST['btnRegistrarIngresoCaja'] == "Egreso")
        {
            exit(header('Location: dashboard.php?msg=montoEnCajaInsuficiente'));
        }

        if ($montoIngresadoPorCajero < 0)
        {
            exit(header('Location: dashboard.php?msg=abonoInvalido'));
        }

        // Ejecutar la consulta
        $stmt = $conn->prepare("INSERT INTO ingresos_egresos_Tienda (idTienda, idUsuario, idTipoMovimiento, fechaMovimiento, concepto, monto) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $idTienda, $idUsuario, $tipoMovimiento, $fechaMovimiento, $conceptoIngreso, $montoIngresadoPorCajero);

        // echo $tipoMovimiento;
        // die;

        if ($stmt->execute())
        {
            if ($_POST['btnRegistrarIngresoCaja'] == "Ingreso")
            {
                exit(header('Location: dashboard.php?msg=ingresoCajaExitoso&monto=' . $montoIngresadoPorCajero));
            }
            else
            {
                exit(header('Location: dashboard.php?msg=egresoCajaExitoso&monto=' . $montoIngresadoPorCajero));
            }
        }
        else
        {
            echo "Error al crear el registro: " . $conn->error;
            // exit(header('Location: dashboard.php?msg=abonoCajaErroneo#caja'));
        }
    }

    if (isset($_POST['btnNuevaSucursal']))
    {
        // Verificar si se recibieron los campos requeridos
        if(isset($_SESSION['managedStore']) && isset($_POST['nombre_sucursal'], $_POST['cp_sucursal'], $_POST['estado_sucursal'], $_POST['calle_sucursal'], $_POST['colonia_sucursal'], $_POST['exterior_sucursal'], $_POST['telefono_sucursal']) && !empty($_POST['nombre_sucursal']) && !empty($_POST['cp_sucursal'])     && !empty($_POST['estado_sucursal']) && !empty($_POST['calle_sucursal'])  && !empty($_POST['colonia_sucursal'])  && !empty($_POST['exterior_sucursal']) && !empty($_POST['telefono_sucursal']))
        {

            // Almacenar los valores recibidos en variables
            $idTienda          = $_SESSION['managedStore'];
            $nombre_sucursal   = limpiarDato($_POST['nombre_sucursal']);
            $estado_sucursal   = limpiarDato($_POST['estado_sucursal']);
            $mun_alc_sucursal  = limpiarDato($_POST['mun_alc_sucursal']);
            $calle_sucursal    = limpiarDato($_POST['calle_sucursal']);
            $colonia_sucursal  = limpiarDato($_POST['colonia_sucursal']);
            $exterior_sucursal = limpiarDato($_POST['exterior_sucursal']);
            $telefono_sucursal = limpiarDato($_POST['telefono_sucursal']);
            $isActive = 1;

            // Validar que el código postal tenga 5 caracteres y sean solo números, almacenamos
            if(isset($_POST['cp_sucursal']) && strlen($_POST['cp_sucursal']) == 5 && is_numeric($_POST['cp_sucursal']))
            {
                $cp_sucursal = $_POST['cp_sucursal'];
            }
            else
            {
                // El código postal no es válido, mostrar un mensaje de error
                $uploadFlag    = false;
                $error_message = "El código postal debe tener 5 caracteres y ser solo numérico.";
                exit(header('Location: configura-sucursales.php?msg=' . $error_message));
            }

            // Verificar si se recibió la variable $interior_sucursal
            $interior_sucursal = NULL;
            if(isset($_POST['interior_sucursal']))
            {
                // Almacenar el valor recibido en la variable $interior_sucursal
                $interior_sucursal = $_POST['interior_sucursal'];
            }

            // Verificar si se recibió la variable $entre_calles_sucursal
            $entre_calles_sucursal = NULL;
            if(isset($_POST['entre_calles_sucursal']))
            {
                // Almacenar el valor recibido en la variable $entre_calles_sucursal
                $entre_calles_sucursal = $_POST['entre_calles_sucursal'];
            }

            // Verificar si se recibió la variable $entre_calles2_sucursal
            $entre_calles2_sucursal = NULL;
            if(isset($_POST['entre_calles2_sucursal']))
            {
                // Almacenar el valor recibido en la variable $entre_calles2_sucursal
                $entre_calles2_sucursal = $_POST['entre_calles2_sucursal'];
            }

            // Verificar si se recibió la variable $indicaciones_sucursal
            $indicaciones_sucursal = NULL;
            if(isset($_POST['indicaciones_sucursal']))
            {
                // Almacenar el valor recibido en la variable $indicaciones_sucursal
                $indicaciones_sucursal = $_POST['indicaciones_sucursal'];
            }

            // Verificar si se recibió la variable $is_principal_sucursal
            $is_principal_sucursal = 0;
            if(isset($_POST['is_principal_sucursal']))
            {
                // Almacenar el valor recibido en la variable $is_principal_sucursal
                $is_principal_sucursal = $_POST['is_principal_sucursal'];
            }

            // Generar Id para la sucursal
            $idSucursal = generarIDSucursal($conn);

            // Consultar id, nombre, isPrincipal y hacer validaciones
            $sqlConsulta = "SELECT idSucursal, nombreSucursal, isPrincipal FROM sucursalesTienda WHERE idTienda = '$idTienda' AND isActive = 1";
            $resultConsulta = mysqli_query($conn, $sqlConsulta);

            if (mysqli_num_rows($resultConsulta) > 0)
            {
                // output data of each row
                while ($row = mysqli_fetch_assoc($resultConsulta))
                {
                    $sucursalesDB[] = $row;
                }
            }
            else
            {
                $sucursalesDB = false;
                $is_principal_sucursal = 1;
            }

            $eliminar_sucursal_principal = false;
            if ($sucursalesDB !== false)
            {
                foreach ($sucursalesDB as $key => $value)
                {

                    if (limpiarDato($value['nombreSucursal']) == limpiarDato($nombre_sucursal))
                    {
                        exit(header('Location: configura-sucursales.php?msg=sucursalNombreExistente'));
                    }

                    // Si hay una sucursal principal activo flag para cambiar todas las sucursales idPrincipal=0 antes de insertar
                    if ($is_principal_sucursal == 1)
                    {
                        if ($value['isPrincipal'] == 1)
                        {
                            $eliminar_sucursal_principal = true;
                        }
                    }
                }
            }

            // Actualizar todas las sucursales [isPrincipal = 0]
            if ($eliminar_sucursal_principal === true)
            {
                $sql = "UPDATE `sucursalesTienda` SET isPrincipal = 0 WHERE idTienda = '$idTienda'";
                if ($conn->query($sql) === TRUE)
                {
                    // echo "Consulta ejecutada exitosamente";
                }
            }

            // Insertamos en Base de datos
            $sql = "INSERT INTO sucursalesTienda (idTienda, idSucursal, nombreSucursal, codigoPostal, estado, municipioAlcaldia, colonia, calle, numeroExterior, interiorDepto, entreCalle1, entreCalle2, telefono, indicacionesAdicionales, isPrincipal, isActive) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            // Prepara la sentencia SQL
            $stmt = $conn->prepare($sql);

            // Vincula los valores a los marcadores de posición y ejecuta la consulta
            $stmt->bind_param("sssssssssssssssi", $idTienda, $idSucursal, $nombre_sucursal, $cp_sucursal, $estado_sucursal, $mun_alc_sucursal, $colonia_sucursal, $calle_sucursal, $exterior_sucursal, $interior_sucursal, $entre_calles_sucursal, $entre_calles2_sucursal, $telefono_sucursal, $indicaciones_sucursal, $is_principal_sucursal, $isActive);

            // Ejecuta la consulta
            $stmt->execute();

            // Verifica si la inserción se realizó correctamente
            if ($conn->affected_rows > 0)
            {
                // Cierra la sentencia y la conexión, redirección
                $stmt->close();
                $success_message = "registroExitosoSucursal";
                exit(header('Location: configura-sucursales.php?msg=' . $success_message));
            }
            else
            {
                // Cierra la sentencia y la conexión, redirección
                $stmt->close();
                $error_message = "errorRegistroSucursal";
                exit(header('Location: configura-sucursales.php?msg=' . $error_message));
            }
        }
        else
        {
            // Faltan campos requeridos, mostrar un mensaje de error
            $uploadFlag    = false;
            $error_message = "camposFaltantesSucursal";
            exit(header('Location: configura-sucursales.php?msg=' . $error_message));
        }
    }

    if (isset($_POST['btnQRPago']))
    {
        $idTienda = $_SESSION['managedStore'];
        $qrCode = new QrCode('https://example.com');

        $output = new Output\Png();

        // Save black on white PNG image 100px wide to filename.png
        $data = $output->output($qrCode, 100, [255, 255, 255], [0, 0, 0]);
        file_put_contents('verifica/usr_docs/' . $idTienda . '/datosBancarios.png', $data);
    }

    if (isset($_POST['btnGenerarEtiqueta']))
    {   
        
        $idProducto = $_POST['idProducto'];
            
        // Crear una instancia del generador de códigos de barras en formato SVG
        // $generator = new BarcodeGeneratorSVG();
 
        $datos = $_POST['btnGenerarEtiqueta'];

        $datos_array = explode(";", $datos);

        $codigo_barras = $datos_array[0];
        $nombre_producto = $datos_array[1];
        $precio_producto = $datos_array[2];


        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();

        // Generar el código de barras
        $redColor = [0, 0, 0];
        $barcodeImage = '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($codigo_barras, $generator::TYPE_CODE_128, 2, 100, $redColor)) . '">';

        $nombreProducto = $nombre_producto;

        // Crear una instancia de la clase
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => [200, 58],
            'autoMarginPadding' => 0,
            'bleedMargin' => 0,
            'crossMarkMargin' => 0,
            'cropMarkMargin' => 0,
            'nonPrintMargin' => 0,
            'margBuffer' => 0,
            'collapseBlockMargins' => true,
            'orientation' => 'L',
        ]);

        // Agregar el código de barras al documento Mpdf
        $mpdf->AddPage('L', '', '', '', '', 2, 2, 2, 0, 0, 0);
        
        $mpdf->WriteHTML('
            <head>
                <link rel="preconnect" href="https://fonts.gstatic.com">
                <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
            </head>

            <div style="margin-bottom: 2mm; text-align: center;">
                ' . $barcodeImage . '
            </div>

            <div style="font-size: 18px; padding: 0mm; margin-bottom: 5mm; text-align: center; font-family: \'Poppins\', sans-serif;">
                ' . $codigo_barras . '
            </div>

            <div style="font-size: 20px; padding: 0mm; margin-bottom: 3mm; text-align: center; font-family: \'Poppins\', sans-serif;">
                <b>' . $nombreProducto . '</b>
            </div>

            <div style="font-size: 20px; padding: 0mm; margin-bottom: 10mm; text-align: center; font-family: \'Poppins\', sans-serif;">
                $ ' .  number_format($precio_producto, 2) . '
            </div>
        ');

        // Generar el documento Mpdf
        $labelName = $nombreProducto . '_'. $codigo_barras . '.pdf';
    
        $mpdf->Output($labelName, 'D');
        exit;
        // $mpdf->Output($labelName, 'F');
        // exit(header('Location: edita-producto.php?id=' . $idProducto . '&msg=print'));

    }


    if (isset($_POST['btnCambiarPasswordCliente']))
    {
        // Obtener los campos del formulario
        $currentPassword = limpiarDato($_POST['currentPassword']);
        $newPassword     = limpiarDato($_POST['newPassword']);
        $confirmPassword = limpiarDato($_POST['confirmPassword']);

        // Validar los campos
        if (!isset($currentPassword) || !isset($newPassword) || !isset($confirmPassword))
        {
            header('Location: cuenta-configuracion.php?msg=errorCamposRequeridos');
            exit;
        }

        // Verificar la contraseña actual del usuario
        $idUsuario = $_SESSION['email'];
        $sql    = "SELECT password FROM usuarios WHERE email = '$idUsuario' AND isActive = 1";
        $result = mysqli_query($conn, $sql);
        $row    = mysqli_fetch_assoc($result);
        $password_DB = $row['password'];

        if ($password_DB != $currentPassword)
        {
            header('Location: cuenta-configuracion.php?msg=errorContrasenaActual');
            exit;
        }

        // Verificar que las contraseñas nuevas coinciden y cumplen con los requisitos de seguridad
        if ($newPassword != $confirmPassword)
        {
            header('Location: cuenta-configuracion.php?msg=errorContrasenasNuevas');
            exit;
        }

        if (strlen($newPassword) < 8)
        {
            header('Location: cuenta-configuracion.php?msg=errorContrasenaCorta');
            exit;
        }

        // Actualizar la contraseña del usuario en la base de datos
        $sql = "UPDATE usuarios SET password = '$newPassword' WHERE email = '$idUsuario'";
        if (mysqli_query($conn, $sql))
        {
            if (mysqli_affected_rows($conn) > 0)
            {
                header('Location: cuenta-configuracion.php?msg=passwordActualizado');
                exit;
            }
            else
            {
                header('Location: cuenta-configuracion.php?msg=passwordYaActualizado');
                exit;
            }
        }
        else
        {
            header('Location: cuenta-configuracion.php?msg=errorCambioPassword');
            exit;
        }
    }

    if (isset($_POST['btnEliminarEnvio']) && isset($_SESSION['managedStore']))
    {
        $idTienda = $_SESSION['managedStore'];
        if (isset($_POST['idToDeleteDelivery']))
        {
            $id = $_POST['idToDeleteDelivery'];
            $sql = "DELETE FROM enviosTiendas WHERE id = '$id' AND idTienda = '$idTienda'";
            if (mysqli_query($conn, $sql))
            {
                // Cerrar conexión
                mysqli_close($conn);
                exit(header('Location: configura-envios.php?msg=envioEliminado'));
            }
            else
            {
                // Cerrar conexión
                mysqli_close($conn);
                exit(header('Location: configura-envios.php?msg=errorEnvioEliminado'));
            }
        }
        else
        {
            // Cerrar conexión
            mysqli_close($conn);
            exit(header('Location: configura-envios.php?msg=errorEnvioEliminado'));
        }
    }

    if (isset($_POST['btnAllowPickup']) && isset($_SESSION['managedStore']))
    {
        // El checkbox está marcado
        // echo "allowPickup: ". $_POST['allowPickup'];
        $idTienda = $_SESSION['managedStore'];

        if (isset($_POST['allowPickup']))
        {
            $sql = "INSERT INTO enviosTiendas (id, idTipoEnvio, idTienda, nombreEnvio, precioEnvio, hasOnlinePayment, hasDeliveryPayment, isActive) VALUES (NULL, 'PIK', '$idTienda', 'Pick Up Sucursal', '0', '1', '1', '1')";

            if ($conn->query($sql) === TRUE)
            {
                exit(header('Location: configura-envios.php?msg=pickupActivado'));
            }
            else
            {
                //echo "Error: " . $sql . "<br>" . $conn->error;
                exit(header('Location: configura-envios.php?msg=pickupErrorActivacion'));
            }
            $conn->close();
        }
        else
        {
            $sql = "DELETE FROM enviosTiendas WHERE idTienda = '$idTienda' AND idTipoEnvio = 'PIK'";

            if ($conn->query($sql) === TRUE)
            {
                exit(header('Location: configura-envios.php?msg=pickupDesactivado'));
            }
            else
            {
                exit(header('Location: configura-envios.php?msg=pickupErrorActivacion'));
                //echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();
        }
        // echo "<pre>";
        // print_r($_POST['allowPickup']);
        // echo "<hr>";
        // print_r($_POST['btnAllowPickup']);
        // die;
    }

    if (isset($_POST['btnEliminarPago'], $_SESSION['managedStore']))
    {
        $id =  $_POST['idToDelete'];
        $idTienda = $_SESSION['managedStore'];

        // Validar si existe un registro con el mismo número de tarjeta o clabe en toda la BDD
        $query = "DELETE FROM metodosDePagoTienda WHERE id = '$id' AND idTienda = '$idTienda'";

        if ($conn->query($query) === TRUE)
        {
            exit(header('Location: configura-pagos.php?msg=pagoEliminado'));
        }
        else
        {
            exit(header('Location: configura-pagos.php?msg=errorEliminarPago'));
        }

    }

    if (isset($_POST['btnActualizarDatosBancarios']))
    {
        if (isset($_POST['banco'], $_POST['numeroTarjeta'], $_POST['clabe'], $_SESSION['managedStore'], $_POST['idDB']))
        {
            $banco         = $_POST['banco'];
            $clabe         = $_POST['clabe'];
            $numeroTarjeta = $_POST['numeroTarjeta'];
            $idTienda      = $_SESSION['managedStore'];
            $id            = $_POST['idDB'];

            // Validar si existe un registro con el mismo número de tarjeta o clabe en toda la BDD
            $query = "SELECT * FROM metodosDePagoTienda WHERE (numeroTarjeta = '$numeroTarjeta' OR clabe = '$clabe') AND id != '$id'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0)
            {
                mysqli_close($conn);
                // Mostrar mensaje de error y no realizar la inserción
                exit(header('Location: configura-pagos.php?msg=datosBancariosExistentes'));
            }


            // Actualizar Pago de tienda
            $query  = "UPDATE metodosDePagoTienda SET banco = '$banco', clabe = '$clabe', numeroTarjeta = '$numeroTarjeta' WHERE id = '$id' AND idTienda = '$idTienda'";
            $result = mysqli_query($conn, $query);

            if ($conn->query($query) === TRUE)
            {
                exit(header('Location: configura-pagos.php?msg=pagoActualizado'));
            }
            else
            {
                exit(header('Location: configura-pagos.php?msg=errorActualizarPago'));
            }

        }
        else
        {
            exit(header('Location: configura-pagos.php?msg=datosFaltantesPago'));
        }
    }

    if (isset($_POST['btnGuardarPago']))
    {
        // echo "<pre>";
        // print_r($_POST);
        if (isset($_POST['nombreEnvio'], $_POST['idMetodoDePago'], $_SESSION['managedStore']))
        {
            $nombreEnvio    = $_POST['nombreEnvio'];
            $idMetodoDePago = $_POST['idMetodoDePago'];
            $idTienda       = $_SESSION['managedStore'];

            if ($idMetodoDePago === "PP" || $idMetodoDePago === "MP")
            {
                // Validar datos de pago digital (paypal/mercadopago)
                if (isset($_POST['urlPago']))
                {
                    $urlPago = $_POST['urlPago'];
                    $sql = "INSERT INTO metodosDePagoTienda (idMetodoDePago, nombreMP, idTienda, urlPago, isActive) VALUES ('$idMetodoDePago', '$nombreEnvio', '$idTienda', '$urlPago', 1)";
                }
                else
                {
                    exit(header('Location: configura-pagos.php?msg=datosFaltantesPago'));
                }
            }
            elseif ($idMetodoDePago === "TRANSFER")
            {
                // Validar datos de cuenta bancaria (4)
                if (isset($_POST['banco'], $_POST['numeroTarjeta'], $_POST['clabe'], $_POST['beneficiario']))
                {
                    $banco         = $_POST['banco'];
                    $clabe         = $_POST['clabe'];
                    $beneficiario  = $_POST['beneficiario'];
                    $numeroTarjeta = $_POST['numeroTarjeta'];

                    // Validar si existe un registro con el mismo número de tarjeta o clabe en toda la BDD
                    $query = "SELECT * FROM metodosDePagoTienda WHERE numeroTarjeta = '$numeroTarjeta' OR clabe = '$clabe'";
                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) > 0)
                    {
                        mysqli_close($conn);
                        // Mostrar mensaje de error y no realizar la inserción
                        exit(header('Location: configura-pagos.php?msg=datosBancariosExistentes'));
                    }

                    // Validar si existe un registro con el mismo nombre en los metodos de pago de la tienda
                    $query = "SELECT nombreMP FROM metodosDePagoTienda WHERE idTienda = '$idTienda' AND nombreMP = '$nombreEnvio'";
                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) > 0)
                    {
                        mysqli_close($conn);
                        // Mostrar mensaje de error y no realizar la inserción
                        exit(header('Location: configura-pagos.php?msg=mpTiendaExistente'));
                    }

                    // Construir sql
                    $sql = "INSERT INTO metodosDePagoTienda (idMetodoDePago, nombreMP, idTienda, banco, numeroTarjeta, clabe, beneficiario, isActive) VALUES ('$idMetodoDePago', '$nombreEnvio', '$idTienda', '$banco', '$numeroTarjeta', '$clabe', '$beneficiario', 1)";

                }
                else
                {
                    exit(header('Location: configura-pagos.php?msg=datosFaltantesPago'));
                }
            }
            else
            {
                // No requiere validar campos adicionales
                // Construir sql
                $sql = "INSERT INTO metodosDePagoTienda (idMetodoDePago, nombreMP, idTienda, isActive) VALUES ('$idMetodoDePago', '$nombreEnvio', '$idTienda', 1)";
            }

            // Ejecutar sql, guarda el metodo de pago de la tienda
            $result = mysqli_query($conn, $sql);
            if(mysqli_affected_rows($conn) > 0)
            {
                mysqli_close($conn);
                // Inserción exitosa
                exit(header('Location: configura-pagos.php?msg=pagoGuardado'));
            }
            else
            {
                mysqli_close($conn);
                // Error
                exit(header('Location: configura-pagos.php?msg=errorPagoGuardado'));
            }
        }
        else
        {
            exit(header('Location: configura-pagos.php?msg=datosFaltantesPago'));
        }
    }

    if (isset($_POST['btnGuardarEnvio'], $_SESSION['managedStore']))
    {

        $idTienda           = $_SESSION['managedStore'];
        $hasDeliveryPayment = 0;
        $hasOnlinePayment   = 0;

        // var_dump($_POST);
        if (isset($_POST['nombreEnvio']) && isset($_POST['precioEnvio']))
        {
            echo $nombreEnvio = $_POST['nombreEnvio'];
            echo $precioEnvio = $_POST['precioEnvio'];
        }

        // Pago en la entrega
        if (isset($_POST['hasDeliveryPayment']))
        {
            $hasDeliveryPayment = $_POST['hasDeliveryPayment'];
        }

        // Pago en línea
        if (isset($_POST['hasOnlinePayment']))
        {
            $hasOnlinePayment = $_POST['hasOnlinePayment'];
        }

        $response = guardarEnvioNuevo($conn, $idTienda, $nombreEnvio, $precioEnvio, $hasOnlinePayment, $hasDeliveryPayment);

        if ($response['resultado'] == true)
        {
            exit(header('Location: configura-envios.php?msg=envioGuardado'));
        }
        else
        {
            exit(header('Location: configura-envios.php?msg=envioNoGuardado&error=' . $response['error']));
        }
    }

    if (isset($_POST['btnRegistrarCategoria']) && isset($_SESSION['managedStore']))
    {
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
            // echo 'Ya existe una categoría con ese nombre';
            // return;
            $error_message = "categoriaExistente";
            exit(header('Location: mis-categorias.php?msg=' . $error_message));
        }

        $idCategoria = generaIdCategoria($conn, $managedStore);

        // Si no existe una categoría con el mismo nombre, registrar la nueva categoría
        $stmt = $conn->prepare('INSERT INTO categoriasTienda (idCategoria, nombre, idTienda) VALUES (?, ?, ?)');
        $stmt->bind_param('sss', $idCategoria, $categoria, $managedStore);

        if ($stmt->execute())
        {
            // Si el registro tuvo éxito, mostrar un mensaje de éxito
            $success_message = 'categoriaCreada';
            exit(header('Location: mis-categorias.php?msg=' . $success_message));
        }
        else
        {
            // Si el registro falló, mostrar un mensaje de error
            $success_message = 'errorCategoriaCreada';
            exit(header('Location: mis-categorias.php?msg=' . $success_message));
        }
    }

    if (isset($_POST['btnGeneraReporteVentas']))
    {
        $fechaInicio = $_POST['fechaInicio'];
        $fechaFin    = $_POST['fechaFin'];

        $fechaInicialSegundos = strtotime($fechaInicio);
        $fechaFinalSegundos   = strtotime($fechaFin);

        // Hacemos las operaciones para calcular los dias entre las dos fechas y mostramos el resultado
        $dias = ($fechaFinalSegundos - $fechaInicialSegundos) / 86400;
        //echo "La diferencia entre es de: " . round($dias, 0, PHP_ROUND_HALF_UP)  . " dias." ;
        //die;

        // Convertir las fechas al formato de MySQL (YYYY-MM-DD)
        $fechaInicio = date('Y-m-d', strtotime($fechaInicio));
        $fechaFin = date('Y-m-d', strtotime($fechaFin));
        $idTienda = $_SESSION['managedStore'];
        // Consulta para obtener los datos de la tabla "pedidos"
        $sql = "SELECT
                    pedidos.idPedido,
                    pedidos.idCliente,
                    pedidos.idVendedor,
                    pedidos.fechaPedido,
                    pedidos.idTipoPedido,
                    pedidos.idSucursalVenta,
                    pedidos.requiereEnvio,
                    pedidos.precioEnvio,
                    pedidos.fechaPago,
                    pedidos.fechaCierrePedido,
                    pedidos.subtotal,
                    pedidos.total,
                    sucursalesTienda.nombreSucursal,
                    pedidos.idTipoEnvio,
                    CAT_tipoEnvio.nombre AS nombreEnvio,
                    pedidos.idMetodoDePago,
                    CAT_metodoDePago.nombre AS nombreMetodoDePago,
                    pedidos.idEstatusPedido,
                    CAT_estatusPedido.nombre AS estatusPedido,
                    SUM(detallePedido.costoUnitario * detallePedido.cantidad) AS costoTotal,
                    SUM(detallePedido.precioUnitario * detallePedido.cantidad) AS precioTotal
                FROM
                    pedidos
                LEFT JOIN sucursalesTienda ON pedidos.idSucursalVenta = sucursalesTienda.idSucursal
                LEFT JOIN CAT_tipoEnvio ON pedidos.idTipoEnvio = CAT_tipoEnvio.idEnvio
                LEFT JOIN CAT_metodoDePago ON pedidos.idMetodoDePago = CAT_metodoDePago.idMetodoDePago
                LEFT JOIN CAT_estatusPedido ON pedidos.idEstatusPedido = CAT_estatusPedido.idEstatus
                LEFT JOIN detallePedido ON pedidos.idPedido = detallePedido.idPedido
                WHERE
                    DATE(pedidos.fechaPedido) BETWEEN '$fechaInicio' AND '$fechaFin' AND pedidos.idTienda = '$idTienda' AND pedidos.isActive = 1
                GROUP BY
                    pedidos.idPedido";

        $result = $conn->query($sql);

        // Crear un nuevo objeto Spreadsheet de PHPSpreadsheet
        $spreadsheet = new Spreadsheet();

        // Seleccionar la hoja de cálculo activa
        $sheet = $spreadsheet->getActiveSheet();

        // Agregar encabezados de columna
        $sheet->setCellValue('A2', 'ID Pedido');
        $sheet->setCellValue('B2', 'ID Cliente');
        $sheet->setCellValue('C2', 'ID Vendedor');
        $sheet->setCellValue('D2', 'Fecha de Pedido');
        $sheet->setCellValue('E2', 'Recibido en');
        $sheet->setCellValue('F2', 'Sucursal de Venta');
        $sheet->setCellValue('G2', 'Requiere envío');
        $sheet->setCellValue('H2', 'Envío seleccionado');
        $sheet->setCellValue('I2', 'Precio de envío');
        $sheet->setCellValue('J2', 'Subtotal Pedido');
        $sheet->setCellValue('K2', 'Total Pedido');
        $sheet->setCellValue('L2', 'Costo Total Productos');
        $sheet->setCellValue('M2', 'Precio Total Productos');
        $sheet->setCellValue('N2', 'Método de Pago');
        $sheet->setCellValue('O2', 'Fecha de Pago');
        $sheet->setCellValue('P2', 'Estatus Pedido');
        $sheet->setCellValue('Q2', 'Fecha Cierre de Pedido');

        // Obtener estilo de celda
        $style = $sheet->getStyle('A2:O2');

        // Establecer color de fondo
        $fill = $style->getFill();
        $fill->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
             ->getStartColor()->setARGB('FF0000FF'); // Color azul en formato ARGB

        // Establecer color de letra
        $font = $style->getFont();
        $font->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE); // Color blanco en formato ARGB


        // Establecer estilo a los encabezados de columna
        $style = [
            'font' => [
                'size' => 14, // Tamaño de letra
                'color' => ['rgb' => 'FFFFFF'] // Color de letra (blanco)
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => '0070C0' // Color de fondo (azul)
                ]
            ]
        ];

        $sheet->getStyle('A2:Q2')->applyFromArray($style);

        //
        $rangoFecha = "Reporte del " . date("d-m-Y", strtotime($fechaInicio)) . " al " . date("d-m-Y", strtotime($fechaFin));
        $sheet->setCellValue('A1', $rangoFecha);

        // Agregar datos de la tabla "pedidos" a la hoja de cálculo
        if ($result->num_rows > 0)
        {
            $rowNumber = 3;
            while($row = $result->fetch_assoc())
            {
                $sheet->setCellValue('A' . $rowNumber, $row["idPedido"]);
                $sheet->setCellValue('B' . $rowNumber, $row["idCliente"]);
                $sheet->setCellValue('C' . $rowNumber, $row["idVendedor"]);
                $sheet->setCellValue('D' . $rowNumber, $row["fechaPedido"] ? date("d/m/Y", strtotime($row["fechaPedido"])) : "");
                $sheet->setCellValue('E' . $rowNumber, $row["idTipoPedido"]);
                $sheet->setCellValue('F' . $rowNumber, $row["nombreSucursal"]);
                $sheet->setCellValue('G' . $rowNumber, $row["requiereEnvio"] == 0 ? "No" : "Sí");
                $sheet->setCellValue('H' . $rowNumber, $row["nombreEnvio"]);
                $sheet->setCellValue('I' . $rowNumber, $row["precioEnvio"]);
                $sheet->setCellValue('J' . $rowNumber, $row["subtotal"]);
                $sheet->setCellValue('K' . $rowNumber, $row["total"]);
                $sheet->setCellValue('L' . $rowNumber, $row["costoTotal"]);
                $sheet->setCellValue('M' . $rowNumber, $row["precioTotal"]);
                $sheet->setCellValue('N' . $rowNumber, $row["nombreMetodoDePago"]);
                $sheet->setCellValue('O' . $rowNumber, $row["fechaPago"] ? date("d/m/Y H:i", strtotime($row["fechaPago"])) : "");
                $sheet->setCellValue('P' . $rowNumber, $row["estatusPedido"]);
                $sheet->setCellValue('Q' . $rowNumber, $row["fechaCierrePedido"] ? date("d/m/Y H:i", strtotime($row["fechaCierrePedido"])) : "");
                $rowNumber++;
            }
        }

        // Autoajustar el ancho de las columnas
        $columnas = range('A', 'Q');
        foreach($columnas as $columna)
        {
            $sheet->getColumnDimension($columna)->setAutoSize(true);
        }

        // Formatear toda la columna C como moneda
        $sheet->getStyle('I')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD);
        $sheet->getStyle('J')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD);
        $sheet->getStyle('K')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD);
        $sheet->getStyle('L')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD);
        $sheet->getStyle('M')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD);

        // Establecer nombre de la hoja
        $sheet->setTitle('Vendy');

        // Guardar el archivo de Excel en el servidor
        $writer   = new Xlsx($spreadsheet);
        $filename = 'reporte_Ventas.xlsx';

        // Descargar el archivo de Excel al navegador del usuario
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($filename).'"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');

        // Cerrar la conexión a la base de datos
        $conn->close();
        exit();
    }

    if (isset($_POST['btnEliminarCategoria']) && isset($_SESSION['managedStore']))
    {

        // Obtener mensajes de éxito y error
        $success_message = "categoriaEliminada";
        $error_message = "errorEliminarCategoria";

        if (isset($_POST['idCategoriaEliminar'])) 
        {
            $idCategoria = $_POST['idCategoriaEliminar'];

            // Check if there are active products associated with this category and the current store
            $stmt_check_products = mysqli_prepare($conn, "SELECT COUNT(*) FROM productos WHERE idCategoria = ? AND idTienda = ? AND isActive = 1");
            mysqli_stmt_bind_param($stmt_check_products, "ss", $idCategoria, $_SESSION['managedStore']);
            mysqli_stmt_execute($stmt_check_products);
            mysqli_stmt_bind_result($stmt_check_products, $active_product_count);
            mysqli_stmt_fetch($stmt_check_products);
            mysqli_stmt_close($stmt_check_products);

            if ($active_product_count > 0) 
            {
                // There are active products associated with this category, so prevent deletion
                exit(header("Location: mis-categorias.php?msg=" . $error_message));
            }

            // No active products associated with this category, proceed with the deletion
            $stmt = mysqli_prepare($conn, "DELETE FROM categoriasTienda WHERE idCategoria = ? AND idTienda = ?");
            mysqli_stmt_bind_param($stmt, "ss", $idCategoria, $_SESSION['managedStore']);

            if (mysqli_stmt_execute($stmt)) 
            {
                // Redirigir a mis-categorias.php con mensaje de éxito
                // Cerrar consulta y conexión
                mysqli_stmt_close($stmt);
                mysqli_close($conn);

                exit(header("Location: mis-categorias.php?msg=" . $success_message));
            } 
            else 
            {
                // Cerrar consulta y conexión
                mysqli_stmt_close($stmt);
                mysqli_close($conn);

                // Redirigir a mis-categorias.php con mensaje de error
                exit(header("Location: mis-categorias.php?msg=" . $error_message));
            }
        } 
    }

    if (isset($_POST['btnActualizarCategoria']) && isset($_SESSION['managedStore']))
    {
        // Obtener datos del formulario
        $idCategoria = $_POST['idCategoria'];
        $categoria   = strtolower($_POST['categoria']);
        $idTienda    = $_SESSION['managedStore'];
        // Obtener mensajes de éxito y error
        $success_message = "categoriaActualizada";
        $error_message   = "errorActualizarCategoria";

        // Verificar si ya existe una categoría con el mismo nombre
        $stmt = $conn->prepare('SELECT * FROM categoriasTienda WHERE nombre = ? AND idTienda = ?');
        $stmt->bind_param('ss', $categoria, $idTienda);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0)
        {
            // Si ya existe una categoría con el mismo nombre, mostrar un mensaje de error
            // echo 'Ya existe una categoría con ese nombre';
            // return;
            $error_message = "categoriaExistente";
            exit(header('Location: mis-categorias.php?msg=' . $error_message));
        }

        if (isset($_POST['idCategoria'], $_POST['categoria']))
        {
            // Preparar consulta
            $stmt = mysqli_prepare($conn, "UPDATE categoriasTienda SET nombre = ?  WHERE idCategoria = ? AND idTienda = ?");

            // Vincular parámetros
            mysqli_stmt_bind_param($stmt, "sss", $categoria, $idCategoria, $_SESSION['managedStore']);

            // Ejecutar consulta
            if (mysqli_stmt_execute($stmt))
            {
                // Redirigir a mis-categorias.php con mensaje de éxito
                // Cerrar consulta y conexión
                mysqli_stmt_close($stmt);
                mysqli_close($conn);

                exit(header("Location: mis-categorias.php?msg=" . $success_message . "&categoria=" . $categoria));
            }
            else
            {
                // Cerrar consulta y conexión
                mysqli_stmt_close($stmt);
                mysqli_close($conn);

                // Redirigir a mis-categorias.php con mensaje de error
                exit(header("Location: mis-categorias.php?msg=" . $error_message . "&categoria=" . $categoria));
            }
        }
    }

    if (isset($_POST['btnEliminarProducto']))
    {
        if (isset($_POST['idProductDelete'], $_POST['idTienda']))
        {
            $idProductDelete = $_POST['idProductDelete'];
            $idTienda = $_SESSION['managedStore'];

            $sql = "UPDATE productos SET isActive = 0 WHERE idProducto = ? AND idTienda = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $idProductDelete, $idTienda);
            $stmt->execute();

            if ($stmt->affected_rows > 0)
            {
                // Eliminar fotos BDD
                $sql = "DELETE FROM imagenProducto WHERE idProducto = ? AND idTienda = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $idProductDelete, $idTienda);

                if ($stmt->execute())
                {
                    header('Location: mis-articulos.php?msg=productoEliminado');
                }
                else
                {
                    header('Location: mis-articulos.php?msg=errorProductoEliminado&idE=1');
                }
            }
            else
            {
                header('Location: mis-articulos.php?msg=errorProductoEliminado&idE=2');
            }
        }
        else
        {
            header('Location: mis-articulos.php?msg=errorProductoEliminado&idE=3');
        }
    }

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
            $fechaPago = NULL;
            $hasFile   = true;

            if (registraComprobante($conn, $nombreComprobante, $idPedido, $idCliente, $fechaPago, $hasFile))
            {
                exit(header('Location: detalleCompra.php?id=' . $idPedido . '&msg=comprobanteCargado'));
            }
            else
            {
                exit(header('Location: detalleCompra.php?id=' . $idPedido . '&msg=errorComprobanteCarga'));
            }
        }
        else
        {
            exit(header('Location: detalleCompra.php?id=' . $idPedido . '&msg=errorComprobanteCarga&'));
        }

    }

    if (isset($_POST['btnConfirmarCierre']))
    {
        $idPedido   = $_POST['idPedido'];

        //echo "Cierre Pedido";
        if (!isset($_POST['idPedido']))
        {
            exit(header('Location: mis-ventas.php?msg=errorCierreDatos&id=' . $idPedido));
        }

        if (!isset($_POST['idCliente'], $_POST['idTienda']))
        {
            exit(header('Location: detalleVenta.php?msg=errorCierreDatos&id=' . $idPedido));
        }

        $idCliente  = $_POST['idCliente'];
        $idTienda   = $_POST['idTienda'];

        if (cierrePedido($conn, $idPedido, $idCliente, $idTienda))
        {
            exit(header('Location: detalleVenta.php?msg=pedidoCerrado&id=' . $idPedido));
        }
        else
        {
            exit(header('Location: detalleVenta.php?msg=errorCierreSQL&id=' . $idPedido));
        }

    }

    if (isset($_POST['btnNotificarEnvio']))
    {
        //echo "Notifica Envio<br><br>";

        $guiaEnvio        = false;
        $nombrePaqueteria = false;
        $fechaEnvio       = $_POST['fechaEnvio'];
        $idPedido         = $_POST['idPedido'];
        $idCliente        = $_POST['idCliente'];

        if (isset($_POST['guiaEnvio']) || isset($_POST['nombrePaqueteria']))
        {
            if (isset($_POST['guiaEnvio'], $_POST['nombrePaqueteria']))
            {
                $guiaEnvio        = $_POST['guiaEnvio'];
                $nombrePaqueteria = $_POST['nombrePaqueteria'];
            }
        }

        $guardaEnvio = guardarEnvio($conn, $guiaEnvio, $nombrePaqueteria, $fechaEnvio, $idPedido, $idCliente);

        if ($guardaEnvio !== false)
        {

            $emailRecipiente  = $idCliente;
            $nombreRecipiente = $idCliente;
            $tituloCorreo     = "Pedido enviado";
            $cuerpoCorreo     = plantillaPedidoEnviado($idPedido);

            enviaEmail($emailRecipiente, $nombreRecipiente, $tituloCorreo, $cuerpoCorreo);
            exit(header('Location: detalleVenta.php?id=' . $idPedido . "&msg=envioRegistrado"));
        }
        else
        {
            exit(header('Location: detalleVenta.php?id=' . $idPedido . "&msg=errorEnvio"));
        }

    }

    if (isset($_POST['btnConfirmarPago']))
    {
        if (isset($_SESSION['managedStore'], $_POST['idVenta'], $_POST['fechaPago']))
        {
            //echo "Confirmar Pago";

            $idPedido     = $_POST['idVenta'];
            $fechaPago    = $_POST['fechaPago'];
            $idTienda    = $_SESSION['managedStore'];
            $usr_products = "verifica/usr_docs/" . $idTienda . "/pagos/";
            $hasFile = false;
            $idCliente = $_POST['idCliente'];

            //VALIDO DIRECTORIO, SI NO, LO CREA.
            if(!is_dir($usr_products))
            {
                mkdir($usr_products, 0777, true);
            }

            //var_dump($comprobante);
            //
            // var_dump(isset($_FILES['fileToUpload']));
            // die;

            $comprobante = "";
            if (isset($_FILES['fileToUpload']))
            {
                $hasFile = true;
                $comprobante = cargarComprobante($conn, $idCliente, $idPedido);
            }

            // echo "Insertar en DB: " . $comprobante;
            // echo $comprobante  . "<br>";
            // echo $idPedido          . "<br>";
            // echo $idCliente         . "<br>";
            // echo $fechaPago         . "<br><br>";
            // die;

            $registraComprobante = registraComprobante($conn, $comprobante, $idPedido, $idCliente, $fechaPago, $hasFile);

            if ($registraComprobante !== false)
            {
                exit(header('Location: ../app/detalleVenta.php?id=' . $_POST['idVenta'] . "&msg=pagoConfirmado"));
                // echo "pagoConfirmado";
            }
            else
            {
                exit(header('Location: ../app/detalleVenta.php?id=' . $_POST['idVenta'] . "&msg=errorPagoConfirmado"));
                // echo "errorPagoConfirmado";
            }


        }
        else
        {

            exit(header('Location: ../app/detalleVenta.php?id=' . $_POST['idVenta'] . "&msg=faltanDatos"));
            // echo "faltanDatos";
        }
    }

    if (isset($_POST['btnCrearPedido']))
    {
        //echo "Crear Pedido";
        

        $camposEsperados = array(
            'idCliente',
            'metodoEnvioDinamico',
            'direccion',
            'metodoDePago',
            'idTienda',
            'precioEnvio'
        );
        
        $datosFaltantes = array();
        
        foreach ($camposEsperados as $campo) 
        {
            if (!isset($_POST[$campo]) || empty($_POST[$campo])) 
            {
                $datosFaltantes[] = $campo;
            }
        }
        
        if (!empty($datosFaltantes)) 
        { 
            // echo "Faltan los siguientes campos: " . implode(", ", $datosFaltantes);
            exit(header('Location: ../pago.php?tienda=' . $_POST['idTienda'] . "&msg=datosFaltantesCrearPedido"));
        } 

        // Todos los campos esperados están presentes, puedes procesar los datos
        $idCliente = $_POST['idCliente'];
        $metodoEnvioDinamico = $_POST['metodoEnvioDinamico'];
        $direccion = $_POST['direccion'];
        $metodoDePago = $_POST['metodoDePago'];
        $idTienda = $_POST['idTienda'];
        $precioEnvio = $_POST['precioEnvio'];
        $btnCrearPedido = $_POST['btnCrearPedido'];
    
        // echo "<pre>";
        // print_r($_POST);
        // die;
        // Inicializo variables
        $id = NULL;

        // Asigno valores
        $idPedido     = NULL;
        $idPedido     = generaIdPedido($conn);

        // $fechaPedido ================================
        $fechaPedido  = date("Y-m-d H:i:s");

        // $idCliente, $idTipoPedido, $idSucursalVenta, $fechaPago, $idMetodoDePago, $comprobanteDePago, $fechaCierrePedido, $idEstatusPedido ================================
        $idCliente    = NULL;
        $idTipoPedido = NULL;
        $idSucursalVenta = NULL;
        $fechaPago       = NULL;
        $idMetodoDePago  = NULL;
        $comprobanteDePago = NULL;
        $fechaCierrePedido = NULL;
        $idEstatusPedido   = NULL;
        $idTienda = NULL;
        $idVendedor = NULL;

        $idTipoPedido = $_POST['btnCrearPedido'];    
        $idMetodoDePago = $_POST['metodoDePago'];

        if ($idTipoPedido == "PDV")
        {
            if (isset($_POST['idCliente']))
            {
                $idCliente = $_POST['idCliente'];
            }

            $idSucursalVenta   = $_SESSION['idSucursalVenta'];
            $fechaPago         = $fechaPedido;
            $fechaCierrePedido = $fechaPedido;
            $idEstatusPedido   = "EP-4";
            $comprobanteDePago = isset($_POST['comprobanteDePago']) ? $_POST['comprobanteDePago'] : NULL;
            if (isset($_SESSION['managedStore']))
            {
                $idTienda = $_SESSION['managedStore'];
            }
            else
            {
                die('Tienda no seleccionada');
            }

            // Para guardar el vendedor cuando sea VENTA EN PDV
            $idVendedor = $_SESSION['email'];
        }
        else
        {
            $idCliente = $_SESSION['email'];
            $idEstatusPedido   = "EP-1";
            if (isset($_POST['idTienda']))
            {
                $idTienda = $_POST['idTienda'];
            }
            else
            {
                die('Tienda no seleccionada');
            }
        }

        // $requiereEnvio, $idTipoEnvio, $idDireccionEnvio, $precioEnvio  ===================================
        $requiereEnvio    = false;
        $idTipoEnvio      = NULL;
        $idDireccionEnvio = NULL;
        $precioEnvio = 0;

        // echo "<pre>";
        // print_r($_SESSION);
        // echo "idTienda" . $idTienda . "<br> ";
        //  Iteramos el carrito para buscar si requiere envio si es que es un pedido de tienda en línea
        if ($idTipoPedido == "WEB")
        {
            foreach ($_SESSION[$idTienda] as $index => $value)
            {
                $idProducto = $_SESSION[$idTienda][$index]['idProducto'];
                $idUsuario  = $_SESSION[$idTienda][$index]['idTienda'];

                if (($_SESSION[$idTienda][$index]['requiereEnvio']+0) == 1)
                {
                    $requiereEnvio = true;
                }
            }
        }
 
        if ($requiereEnvio === true) {
            $requiereEnvio = 1;
            if (isset($_POST['metodoEnvioDinamico'])) {
                $tipoEnvio = $_POST['metodoEnvioDinamico'];
                $slicesTipoEnvio = explode(";", $tipoEnvio);
                $idTipoEnvio = $slicesTipoEnvio[1];
                $idDireccionEnvio = $_POST['direccion'];

                if (isset($_POST['precioEnvio'])) {
                    $precioEnvio = floatval($_POST['precioEnvio']);
                }
            }
        } else {
            $requiereEnvio = 0;
        }


        // $subtotal, $total ========================================
        $subtotal        = $_SESSION['subtotal'];
        $descuentoTienda = $_SESSION['descuento'];
        $total           = $_SESSION['total'] + $precioEnvio;
        $isActive        = 1;

        // INSERTO EN BASE DE DATOS

        try 
        {
            // Iniciar una transacción para asegurar operaciones atómicas
            mysqli_begin_transaction($conn);

            // Sentencia para insertar en la tabla 'pedidos'
            $sqlPedido = "INSERT INTO `pedidos`
                (
                    idPedido,
                    idCliente,
                    idVendedor,
                    fechaPedido,
                    idTipoPedido,
                    idSucursalVenta,
                    idTienda,
                    requiereEnvio,
                    precioEnvio,
                    idTipoEnvio,
                    idDireccionEnvio,
                    fechaPago,
                    idMetodoDePago,
                    comprobantePago,
                    fechaCierrePedido,
                    idEstatusPedido,
                    subtotal,
                    descuentoTienda,
                    total,
                    isActive
                )
                VALUES
                (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

            $stmtPedido = $conn->prepare($sqlPedido);

            $stmtPedido->bind_param('sssssssidsssssssdddi',
                
                $idPedido,
                $idCliente,
                $idVendedor,
                $fechaPedido,
                $idTipoPedido,
                $idSucursalVenta,
                $idTienda,
                $requiereEnvio,
                $precioEnvio,
                $idTipoEnvio,
                $idDireccionEnvio,
                $fechaPago,
                $idMetodoDePago,
                $comprobanteDePago,
                $fechaCierrePedido,
                $idEstatusPedido,
                $subtotal,
                $descuentoTienda,
                $total,
                $isActive
            );

            // Ejecutar la inserción en la tabla 'pedidos'
            if (!$stmtPedido->execute()) 
            {
                throw new Exception("Error al crear el pedido: " . $stmtPedido->error);
            }

            // Sentencia para insertar en la tabla 'detallePedido'
            $sqlDetallePedido = "INSERT INTO `detallePedido` (`idPedido`, `idCliente`, `idProducto`, `idTienda`, `cantidad`, `costoUnitario`, `precioUnitario`) VALUES ";

            // Iterar el carrito y construir la sentencia para el detalle del pedido
            foreach ($_SESSION[$idTienda] as $key => $value) 
            {
                $precio = $value['precio'];
                $cantidad = $value['stock'];
                $idProducto = $value['idProducto'];
                $costo = $value['costo'];

                if ($key === array_key_last($_SESSION[$idTienda])) {
                    $sqlDetallePedido .= "('$idPedido', '$idCliente', '$idProducto', '$idTienda', '$cantidad', '$costo', '$precio');";
                } else {
                    $sqlDetallePedido .= "('$idPedido', '$idCliente', '$idProducto', '$idTienda', '$cantidad', '$costo', '$precio'), ";
                }
            }
            // var_dump($idMetodoDePago); 
            // echo "<br>";
            // echo $sqlDetallePedido;
            // die;

            // Ejecutar la inserción en la tabla 'detallePedido'
            if (mysqli_query($conn, $sqlDetallePedido)) 
            {
                // Confirmar la transacción si no hubo errores
                mysqli_commit($conn);

                // Restar inventario de productos
                foreach ($_SESSION[$idTienda] as $key => $value) 
                {
                    $idProductoRestarStock = $value['idProducto'];
                    $cantidad = $value['stock'];
                    restaInventarioProducto($conn, $idTienda, $idProductoRestarStock, $cantidad);
                }

                // Eliminar el carrito                
                // WARNING WARNING WARNING: Quitar comentario al terminar de solucionar el crear pedido
                unset($_SESSION[$idTienda]);
                unset($_SESSION['subtotal']);
                unset($_SESSION['descuento']);
                unset($_SESSION['total']);
            } 
            else 
            {
                throw new Exception("Error al insertar en 'detallePedido': " . mysqli_error($conn));
            }

            // Pedido creado exitosamente
            $pedidoCreado = true;
        } 
        catch (Exception $e) 
        {
            // Deshacer la transacción si ocurrió un error
            mysqli_rollback($conn);

            // Manejar el error adecuadamente (puede ser loguear, mostrar un mensaje, etc.)
            echo $e->getMessage();
            $pedidoCreado = false;
        }
        // FIN INSERTAR BASE DE DATOS
        // Datos Bancarios
        $datosBancarios = false;

        // CONSTRUYO CORREO
        $enviarCorreo = false; // Activo envio

        //echo "<br><br>Datos Bancarios Vendedor<br><br>";
        $datosBancariosCorreo = Array();
        $dbC = 0;
        if ($datosBancarios != false)
        {
            foreach ($datosBancarios as $key => $value)
            {

                $datosBancariosCorreo[$dbC]['numTarjeta'] = $value['numTarjeta'];
                $datosBancariosCorreo[$dbC]['numClabe']   = $value['numClabe'];
                $datosBancariosCorreo[$dbC]['banco']      = $value['banco'];
                $dbC++;
            }
            $enviarCorreo = true;
        }

        // Direccion Pedido
        $direccionPedido = getDireccionPedido($conn, $idTipoEnvio, $idDireccionEnvio, $idCliente, $idTienda);

        // Datos Contacto Vendedor
        $getDatosContactoVendedor = getDatosContactoVendedor($conn, $idTienda);

        // Carrito (Productos)
        $carritoActual = $idTienda; // Get carrito name

        // IDEA: Validar permisos
        // Notifico pedido creado al cliente
        enviaEmail($emailRecipiente = $idCliente, $nombreRecipiente = $_SESSION["nombre"], $tituloCorreo="Pedido Confirmado", plantillaOrdenConfirmada($idPedido, $fechaPedido, $requiereEnvio, $direccionPedido, $subtotal, $descuentoTienda, $precioEnvio, $total, $getDatosContactoVendedor, $datosBancariosCorreo));

        // Notifico venta nueva al vendedor
        $tienda  = getDatosTienda($conn, $idTienda);
        $idOwner = $tienda['idOwner'];
        enviaEmail($emailRecipiente = $idOwner, $nombreRecipiente = $getDatosContactoVendedor['nombre'], $tituloCorreo="Nueva venta!", "¡Felicidades, " . ucwords($getDatosContactoVendedor['nombre']) ."!<br><br> Tienes una venta nueva en tu tienda en línea, ingresa a tu cuenta <b>vendy</b> para ver el detalle de tu nueva venta. <br><br> <a href= 'https://vendy.click/app' target='_blank'>Ir a mi cuenta</a> ");

        if ($idTipoPedido == "PDV")
        {
            exit(header('Location: detalleVenta.php?id=' . $idPedido . '&msg=pedidoPDVRealizado'.'&tienda=' . $idTienda));
        }
        else
        {
            exit(header('Location: detalleCompra.php?id=' . $idPedido . '&msg=pedidoRealizado'.'&tienda=' . $idTienda));
        }


    }
    // FIN

    if (isset($_POST['btnSeleccionarSucursal']))
    {
        // echo $sucursal = $_POST['sucursal'];
        if (isset($_POST['sucursal'], $_POST['idTienda']))
        {
            $sucursalPost = $_POST['sucursal'];
            $idTiendaPost = $_POST['idTienda'];
        }
        $flag = false;
        $sucursales = getSucursalesTienda($conn, $idTiendaPost);

        if ($_SESSION['idSucursalVenta'] == $sucursalPost)
        {
            exit(header('Location: pos.php?msg=sameBranch'));
        }

        foreach ($sucursales as $key => $branch)
        {
            if ($branch['idSucursal'] == $sucursalPost)
            {
                $_SESSION['idSucursalVenta'] = $branch['idSucursal'];
                $_SESSION['nombreSucursalVenta'] = $branch['nombreSucursal'];
                $flag = true;
            }
        }
        if ($flag)
        {
            exit(header('Location: pos.php?msg=sucursalSeleccionada'));
        }
        else
        {
            exit(header('Location: pos.php?msg=errorSucursalSeleccionada'));
        }
    }

    if (isset($_POST['btnEliminaCarrito']) && isset($_POST['idTienda']))
    {
        $tienda = $_POST['idTienda'];

        $url = "carrito.php";
        if ($_POST['btnEliminaCarrito'] !== "")
        {
            $url = "app/". $_POST['btnEliminaCarrito'];
        }
        unset($_SESSION[$tienda]);

        exit(header('Location: ../'. $url .'?tienda=' . $tienda));
    }

    if (isset($_POST['btnAgregarCarrito']))
    {
        // echo "s";
        // echo "<pre>";
        // var_dump($_POST);
        // die;
        $redirect = $_POST['btnAgregarCarrito'];
        //echo "Agregar carrito<br><br>";
        if (isset($_POST['idProducto']) && isset($_POST['idTienda']))
        {
            $idProducto    = $_POST['idProducto'];
            $idUsuario     = $_POST['idTienda'];
            $tienda        = getDatosTienda($conn, $idUsuario);
            $idOwner       = $tienda['idOwner'];
            $idTienda      = $tienda['idTienda'];
            $stock         = $_POST['stock'];
            // "<br>";
            // die;
            $datosProducto = false;
            $datosProducto = buscarProducto($conn, $idProducto, $idUsuario);

            if ($datosProducto !== false)
            {
                $precio        = $datosProducto['precio'];
                $precioOferta  = $datosProducto['precioOferta'];
                $unidadVenta   = $datosProducto['unidadVenta'];
            }
            else
            {
                exit(header('Location: ../'. $redirect .'?tienda=' . $idTienda .'&msg=errorAddedToCart#notificacion'));
            }

            if ($unidadVenta === "Kilogramos")
            {
                echo $stock = number_format($stock/1000, 2);
            }

            if(empty($redirect))
            {
                $redirect = "perfil.php";
            }

            if ($datosProducto === false)
            {
                exit(header('Location: ../'. $redirect .'?tienda=' . $tienda .'&msg=errorAddedToCart#notificacion&idProducto=' . $idProducto));
            }
            else
            {
                $response = agregarCarrito($conn, $datosProducto, $idProducto, $idTienda, $stock, $precio, $precioOferta);
                if ($response === true)
                {
                    exit(header('Location: ../'. $redirect .'?tienda=' . $idTienda .'&idProducto=' . $idProducto . '&msg=addedToCart&blessed=28#notificacion'));
                }
                elseif ($response == "inventarioInsuficiente")
                {
                    exit(header('Location: ../'. $redirect .'?tienda=' . $idTienda .'&idProducto=' . $idProducto . '&msg=errorInventarioInsuficiente#notificacion'));
                }
                else
                {
                    exit(header('Location: ../'. $redirect .'?tienda=' . $idTienda .'&idProducto=' . $idProducto . '&msg=errorAddedToCart#notificacion'));
                }
            }
        }
        else
        {
            exit(header('Location: ../'. $redirect .'?tienda=' . $_POST['idTienda'] .'&msg=errorAddedToCart#notificacion'));
        }
    }

    // ACTUALIZAR DATOS PRODUCTO INICIO
    if (isset($_POST['btnActualizaProducto']) && isset($_SESSION['email']))
    {
        // Define la matriz de formatos de imagen permitidos
        define('FORMATOS_IMAGEN_PERMITIDOS', ['jpg', 'png', 'jpeg', 'webp']);

        // Inicializamos variables
        $barcode = "";
        $nombreProducto = "";
        $idCategoria = "";
        $descripcionProducto = NULL;

        $costoProducto  = 0.0;
        $precioVenta = 0.0;

        $unidadVenta = "";
        $inventarioInicial = 0.0;
        $inventarioMinimo  = 0.0;

        $requiereEnvio = 1;
        $managedStore  = "";
        $tienda = "";

        $isActiveOnlineStore = 0;

        // Variables POST & SESSION
        $idProducto          = $_POST['idProducto'];
        $nombreProducto      = isset($_POST['nombreProducto']) ? ucwords(limpiarDato($_POST['nombreProducto'])) : '';
        $idCategoria         = isset($_POST['categoriaSeleccionada']) ? $_POST['categoriaSeleccionada'] : '';
        $descripcionProducto = isset($_POST['descripcionProducto']) ? mb_strtolower(limpiarDato($_POST['descripcionProducto'])) : '';

        $costoProducto       = $_POST['costoProducto'];
        $precioVenta         = $_POST['precioVenta'];

        // Obtengo unidades de venta
        if (isset($_POST['unidadVenta']))
        {
            $unidadVenta = $_POST['unidadVenta'];

            switch ($unidadVenta)
            {
                case 'Kilogramos':
                    $inventarioInicial = $_POST['inventarioInicialKgs'];
                    $inventarioMinimo  = $_POST['inventarioMinimoKgs'];
                break;

                case 'Piezas':
                    $inventarioInicial = $_POST['inventarioInicialPzs'];
                    $inventarioMinimo  = $_POST['inventarioMinimoPzs'];
                break;

              default:
                // code...
                break;
            }
        }

        // Producto digital, onlinestore, isActive
        $requiereEnvio = (isset($_POST['requiereEnvio'])) ? 0 : 1;
        $isActiveOnlineStore = $_POST['isActiveOnlineStore'];
        $isActive = 1;

        // Obtengo datos de la tienda
        $managedStore = $_SESSION['managedStore'];
        $tienda       = getDatosTienda($conn, $managedStore);

        // Inicializa la bandera de carga de imagen en 1 (OK)
        $uploadOk = 1;

        // Creo directorio del producto si no existe
        $usr_products = "verifica/usr_docs/" . $managedStore . "/productos/" . $idProducto . "/";

        if(!is_dir($usr_products))
        {
            mkdir($usr_products, 0777, true);
        }

        // Validar si debe conservar imagenes o subir nuevas al servidor
        $conservaImagenes = false;
        if (isset($_POST['conservarImagenes']))
        {
            $conservaImagenes = true;
        }

        // Activo la carga
        $uploadOk = 1;

        if ($conservaImagenes == true)
        {
            //echo "conserva";
        }
        else
        {
            //echo "elimina imag";
            eliminarImagenesPrevias($conn, $idProducto, $managedStore);
            // Elimina las imágenes previas si existen en Directorio
            // Obtiene una lista de todos los archivos del directorio
            $archivos = scandir($usr_products);

            // Elimina los archivos del directorio utilizando array_map y unlink
            foreach($archivos as $archivo)
            {
                // construir el camino completo del archivo
                $rutaCompleta = $usr_products . $archivo;
                // verificar si es un archivo normal
                if(is_file($rutaCompleta))
                {
                    // eliminar el archivo
                    unlink($rutaCompleta);
                }
            }
        }

        // Loop para validar formatos permitidos
        if (!$conservaImagenes)
        {
            // Obtiene el número de archivos de imagen subidos
            $numArchivosImagen = count($_FILES['imagenProducto']['name']);

            // Valida los formatos de imagen permitidos
            for ($i = 0; $i < $numArchivosImagen; $i++)
            {
                $nombreArchivo = $_FILES['imagenProducto']['name'][$i];
                $extension = pathinfo($_FILES['imagenProducto']['name'][$i], PATHINFO_EXTENSION);

                if (!in_array($extension, FORMATOS_IMAGEN_PERMITIDOS))
                {
                    $error_message = "formatoNoPermitido";
                    $uploadOk = 0;
                }

                
                // if ($_FILES['imagenProducto']['size'] > 500000) 
                // {
                //     $error_message = "tamanoExcedido";            
                //     $uploadOk = 0;
                // }

            }
        }
        // Fin Loop para validar formatos permitidos

        if ($uploadOk == 0)
        {
            exit(header('Location: edita-producto.php?id='.$idProducto .'&msg=' . $error_message));
        }

        // Loop para cargar al servidor y generar sql para insertar a la BDD posteriormente.
        $conteoNombre   = 1;
        $sqlImgProducto = "INSERT INTO imagenProducto (id, idProducto, idTienda, url, isPrincipal) VALUES ";

        if (!$conservaImagenes)
        {
            for($i=0; $i<$numArchivosImagen; $i++)
            {
                // nombreDB = id Producto _ consecutivo . extension
                $nombreDB = $conteoNombre . "." . pathinfo($_FILES["imagenProducto"]["name"][$i], PATHINFO_EXTENSION);

                // Aumento el consecutivo
                $conteoNombre++;

                // $idUsuario = $email
                // Valido si es ultimo loop para controlar la coma (,) en la construccion de la cadena SQL
                // Cargo cada imagen al servidor
                if (move_uploaded_file($_FILES['imagenProducto']['tmp_name'][$i], $usr_products . $nombreDB))
                {
                    if ($i == $numArchivosImagen-1)
                    {
                        // Ultimo
                        $sqlImgProducto .= "(NULL, '$idProducto', '$managedStore', '$nombreDB', 1)";
                    }
                    else
                    {
                        $sqlImgProducto .= "(NULL, '$idProducto', '$managedStore', '$nombreDB', 0), ";
                    }
                }
            }
            $sqlImgProducto .= ";";
        }

        // Actualizo el producto en la BDD
        $sqlProducto = "UPDATE productos SET
                            idCategoria   =  '$idCategoria',
                            nombre        = '$nombreProducto',
                            descripcion   = '$descripcionProducto',
                            costo         = '$costoProducto',
                            precio        = '$precioVenta',
                            unidadVenta   = '$unidadVenta',
                            inventario    = '$inventarioInicial',
                            inventarioMinimo = '$inventarioMinimo',
                            requiereEnvio    = '$requiereEnvio',
                            inventarioMinimo    = '$inventarioMinimo',
                            isActiveOnlineStore = '$isActiveOnlineStore'
                        WHERE
                            idProducto = '$idProducto'
                        AND
                            idTienda   = '$managedStore'";

        // Inserto Producto a BDD
        if (mysqli_query($conn, $sqlProducto) && $uploadOk == 1)
        {
            $result = "cargaCompleta";
            // Inserto las imagenes del producto en la BDD
            if (!$conservaImagenes)
            {
                if (mysqli_query($conn, $sqlImgProducto))
                {
                    $result = "cargaCompleta";
                }
                else
                {
                    //echo "Error: " . $sqlImgProducto . "<br>" . mysqli_error($conn);
                    $result = "errorCarga";
                }
            }
        }
        else
        {
            $result = "errorCarga";
            //echo "Error al registrar en DB";
        }
        exit(header('Location: edita-producto.php?id=' . $idProducto . '&msg=' . $result));
    }
    // ACTUALIZAR DATOS PRODUCTO FIN

    // ALTA PRODUCTO INICIO
     if (isset($_POST['btnAltaProducto']) && isset($_SESSION['email']))
    {

        // Define la matriz de formatos de imagen permitidos
        define('FORMATOS_IMAGEN_PERMITIDOS', ['jpg', 'png', 'jpeg', 'webp']);

        // Obtengo datos de la tienda
        $managedStore = $_SESSION['managedStore'];
        $tienda       = getDatosTienda($conn, $managedStore);
        $idTienda     = $managedStore;

        // Inicializamos variables
        $barcode = "";
        $nombreProducto = "";
        $idCategoria = "";
        $descripcionProducto = NULL;

        $costoProducto  = 0.0;
        $precioVenta = 0.0;

        $unidadVenta = "";
        $inventarioInicial = 0.0;
        $inventarioMinimo  = 0.0;

        $requiereEnvio = 1;

        $isActiveOnlineStore = 0;

        // Obtenemos los datos del formulario
        if (isset($_POST['generarBarcode']))
        {
            $barcode = generarBarcode($conn, $idTienda);
        }
        else
        {
            $barcode = $_POST['barcode'];
            if (existeBarcode($conn, $idTienda, $barcode))
            {
                //echo "no existe";
                exit(header('Location: nuevo-articulo.php?msg=barcodeExistente'));
            }
            else
            {
                //echo "existe";
            }
        }


        $nombreProducto        = isset($_POST['nombreProducto']) ? ucwords(limpiarDato($_POST['nombreProducto'])) : '';
        $idCategoria           = isset($_POST['categoriaSeleccionada']) ? $_POST['categoriaSeleccionada'] : '';
        $descripcionProducto   = isset($_POST['descripcionProducto']) ? mb_strtolower(limpiarDato($_POST['descripcionProducto'])) : '';

        $costoProducto         = $_POST['costoProducto'];
        $precioVenta           = $_POST['precioVenta'];

        // Obtengo unidades de venta
        if (isset($_POST['unidadVenta']))
        {
            $unidadVenta = $_POST['unidadVenta'];

            switch ($unidadVenta)
            {
                case 'Kilogramos':
                    $inventarioInicial = $_POST['inventarioInicialKgs'];
                    $inventarioMinimo  = $_POST['inventarioMinimoKgs'];
                break;

                case 'Piezas':
                    $inventarioInicial = $_POST['inventarioInicialPzs'];
                    $inventarioMinimo  = $_POST['inventarioMinimoPzs'];
                break;

              default:
                // code...
                break;
            }
        }
 

         // Validar y asignar valor para requiereEnvio
         $requiereEnvio = isset($_POST['requiereEnvio']) ? 0 : 1;

         // Validar y asignar valor para isActiveOnlineStore
         $isActiveOnlineStore = isset($_POST['isActiveOnlineStore']) ? $_POST['isActiveOnlineStore'] : 0;
 
         // Asignar valor para isActive
         $isActive = 1;


        // Inicializa la bandera de carga de imagen en 1 (OK)
        $uploadOk = 1;

        // Obtiene el ID del producto para el nuevo producto
        $idProducto = getNewIdProducto($conn, $tienda);

        // Crea el directorio del usuario si no existe
        $rutaUsuarioProductos = "verifica/usr_docs/" . $managedStore . "/productos/" . $idProducto . "/";
        if (!is_dir($rutaUsuarioProductos))
        {
            mkdir($rutaUsuarioProductos, 0777, true);
        }

        // Obtiene el número de archivos de imagen subidos

        // Veo si viene vacio el array de imagenes
        $numArchivosImagen = ($_FILES['imagenProducto']['name'][0] === '') ? 0 : count($_FILES['imagenProducto']['name']);

        // die;
        // Validar formatos de imágenes
        if ($numArchivosImagen > 0)
        {
            // Valida los formatos de imagen permitidos
            for ($i = 0; $i < $numArchivosImagen; $i++)
            {
                $nombreArchivo = $_FILES['imagenProducto']['name'][$i];
                $extension = pathinfo($_FILES["imagenProducto"]["name"][$i], PATHINFO_EXTENSION);

                if (!in_array($extension, FORMATOS_IMAGEN_PERMITIDOS))
                {
                    $error_message = "formatoNoPermitido";
                    $uploadOk = 0;
                }
            }
        }

        // Si alguna imagen no tiene un formato permitido, redirige al usuario con un mensaje de error
        if ($uploadOk == 0)
        {
            exit(header('Location: nuevo-articulo.php?msg=' . $error_message));
        }

        // Elimina las imágenes previas si existen en DB
        eliminarImagenesPrevias($conn, $idProducto, $managedStore);

        // Elimina las imágenes previas si existen en Directorio
        // Obtiene una lista de todos los archivos del directorio
        $archivos = scandir($rutaUsuarioProductos);

        // echo "<pre>";
        // var_dump($archivos);
        // die;

        // Elimina los archivos del directorio utilizando unlink
        foreach($archivos as $archivo)
        {
            // construir el camino completo del archivo
            $rutaCompleta = $rutaUsuarioProductos . '/' . $archivo;
            // verificar si es un archivo normal
            if(is_file($rutaCompleta))
            {
                // eliminar el archivo
                unlink($rutaCompleta);
            }
        }

        // Inicializa el contador de nombres de imagen en 1
        $conteoNombre = 1;

        // Inicializa la consulta SQL para insertar las imágenes del producto en la base de datos
        $sqlImgProducto = "INSERT INTO imagenProducto (id, idProducto, idTienda, url, isPrincipal) VALUES ";

        // Recorre cada imagen recibida y la carga al servidor y a la base de datos
        //echo "numArchivosImagen: " . $numArchivosImagen . "<br>";

        $nombres = array();

        if($numArchivosImagen == 0)  // Si no hay imagenes, carga 1 por defecto del servidor o de url
        {
            $nombreImagenDefecto = 'default.png';
            $urlImagenDefecto  = 'assets/img/product_default.png';
            $rutaImagenDefecto = $rutaUsuarioProductos . $nombreImagenDefecto;

            // Descarga la imagen y guárdala en la carpeta img
            $imageData = file_get_contents($urlImagenDefecto);
            file_put_contents($rutaImagenDefecto, $imageData);
            $nombreDB = $nombreImagenDefecto;
            $sqlImgProducto .= "(NULL, '$idProducto', '$managedStore', '$nombreDB', 1);";
        }
        else
        {
            foreach ($_FILES['imagenProducto']['tmp_name'] as $key => $tmp_name)
            {
                $nombre    = $_FILES['imagenProducto']['name'][$key];
                $nombres[] = $nombre;
                $nombreDB  = $idProducto . "_" . bin2hex(random_bytes(4)) . "." . pathinfo($nombre, PATHINFO_EXTENSION);

                $result = move_uploaded_file($tmp_name, $rutaUsuarioProductos . $nombreDB);
                //var_dump($result);

                if($key+1 == $numArchivosImagen)
                {
                    $sqlImgProducto .= "(NULL, '$idProducto', '$managedStore', '$nombreDB', 1);";
                }
                else
                {
                    $sqlImgProducto .= "(NULL, '$idProducto', '$managedStore', '$nombreDB', 0), ";
                }
            }
        }

        try
        {
            // Prepara la consulta para insertar el producto
            $stmt = $conn->prepare("INSERT INTO productos (idProducto, barcode, idTienda, idCategoria, nombre, descripcion, costo, precio, unidadVenta, inventario, inventarioMinimo, requiereEnvio, isActiveOnlineStore, isActive) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('ssssssddsddsss', $idProducto, $barcode, $managedStore, $idCategoria, $nombreProducto, $descripcionProducto, $costoProducto, $precioVenta, $unidadVenta, $inventarioInicial, $inventarioMinimo, $requiereEnvio, $isActiveOnlineStore, $isActive);

            // Ejecuta la consulta
            $stmt->execute();

            // Cierra la consulta
            $stmt->close();
            if ($conn->query($sqlImgProducto) === TRUE)
            {
                // La consulta se ejecutó correctamente
            }
            else
            {
                // La consulta falló
                //echo "Error al insertar las imágenes del producto: " . $conn->error;
            }
            // Redirige al usuario con un mensaje de éxito
            exit(header('Location: edita-producto.php?id='. $idProducto .'&msg=altaExitosa'));
        }
        catch (Exception $e)
        {
            // Muestra un mensaje de error y termina la ejecución del script
            // die("Error al insertar el producto: " . $e->getMessage());
            // Redirige al usuario con un mensaje de éxito
            exit(header('Location: mis-articulos.php?msg=altaFallida&e=' . $e));
        }
    }
    // ALTA PRODUCTO FIN

    // REENVIO DE CORREO DE ACTIVACION
    if (isset($_POST['email']) && isset($_POST['btnEnvioActivacion']))
    {
        // Almaceno email y limpio el dato
        $email = limpiarDato($_POST['email']);

        //Genero Token para activar la cuenta
        $token = substr(str_shuffle("0123456789"), 0, 4);
        //$token = base64_encode(openssl_random_pseudo_bytes(4));

        // Genero el link que se enviará al correo, $urlActivacion en config.php
        $linkActivacion = "<a href=' " . $urlActivacion . "app/verifica/index.php?email=". $email ."&token=". $token ."'>Activar ahora</a>";

        // Ahora ingreso los valores previamente preparados
        $inserto_usuario = mysqli_query($conn, "UPDATE `usuarios` SET `token` = '$token' WHERE email = '$email'");

        // Verifico errores y preparo mensajes
        if($inserto_usuario === TRUE)
        {
            $emailRecipiente  = $email;
            $nombreRecipiente = $email;
            $tituloCorreo 	  = "Activa tu cuenta vendy";
            $cuerpoCorreo  = '<!DOCTYPE html<html lang="es" dir="ltr<head><meta charset="utf-8"><title>VENDY</title></head><body>';
            $cuerpoCorreo .= "<h2>¡Felicidades! Estás a un paso de unirte a <span class='font-size: 23px; font-weight: bold;'>vendy</span>, usa el siguiente botón para activar tu cuenta: <br><br><b>" . $linkActivacion . "</b></h2><br>";
            $cuerpoCorreo .= "<br><br>Si no puedes ver el botón correctamente copia el siguiente enlace y pégalo en tu navegador web:<br>";
            $cuerpoCorreo .= $urlActivacion . "app/verifica/index.php?email=". $form_email ."&token=". ($token) . "</body></html>";

            enviaEmail($emailRecipiente, $nombreRecipiente, $tituloCorreo, $cuerpoCorreo);
            $message = "envioActivacionExitoso";
        }
        else
        {
            $message = "errorActivacion";
        }

        exit(header('Location: index.php?msg=' . $message));

    }
    // FIN REENVIO DE CORREO DE ACTIVACION

    // LOGIN CUENTA
    if(isset($_POST['form_email']) && isset($_POST['form_password']) && isset($_POST['btnIngresar']))
    {
        // echo "<br><br>axel<br><br>";
        // die;

        if (isset($_POST['redirect']))
        {
            $redirect = $_POST['redirect'];
        }

        if (isset($_POST['vendedor']))
        {
            $vendedor = $_POST['vendedor'];
        }

        $error_message = NULL;

        if (empty(trim($_POST['form_password'])))
        {
            $inputPassword = "#$&&(&/)##ASD3$!#$=$)?";
        } 
        else 
        {
            $inputPassword = $_POST['form_password'];
        }


        // Quito espacios en blanco y verifico que no esten vacios
        if(!empty(trim($_POST['form_email'])) )
        {
            // Escapo caracteres especiales en el email ingresado para evitar hacking SQL injection
            $form_email = mysqli_real_escape_string($conn, htmlspecialchars(trim($_POST['form_email'])));

            // realizo la consulta para ver si existe el email ingresado y está activa la cuenta
            $query = mysqli_query($conn, "SELECT * FROM `usuarios` WHERE email = '$form_email'");

            //si la consulta tiene valores, existe ese email, entonces procedo a consultar por la clave
            if(mysqli_num_rows($query) > 0)
            {
                $row = mysqli_fetch_assoc($query);

                //asigno el valor de la clave ingresada en el formulario de login a un variable para mejor vista
                $usuario_db_pass = $row['password'];

                // Verifico que la clave ingresada sea igual a la almacenada en la tabla de la db.
                if ($inputPassword == $usuario_db_pass)
                {
                    $verifico_password = TRUE;
                }
                else
                {
                    $verifico_password = FALSE;
                }

                // Valido si la cuenta está activada
                $isActive = $row['isActive'];

                // Valido si la cuenta está verificada
                $isVerified = $row['isVerified'];

                // Guardo datos del usuario
                $nombre = $row['nombre'];

                if ($isActive == 1)
                {
                    // echo "active";
                    // die;
                    // si la verificación es cierta, valido la contraseña
                    if($verifico_password === TRUE)
                    {
                        // Select tiendas
                        $tiendasOwner = getTiendasOwner($conn, $row['email']);
                        // echo $tiendasOwner[0]['idTienda'];
                        // echo "<pre>";
                        // var_dump($tiendasOwner);
                        // die;

                        //coloco el email del usuario en una variable de sesión para poder acceder en otras páginas
                        $_SESSION['email']      = $form_email;
                        $_SESSION['isVerified'] = $row['isVerified'];
                        $_SESSION['isActive']   = $row['isActive'];
                        $_SESSION['nombre']     = $row['nombre'];
                        $_SESSION['paterno']    = $row['paterno'];
                        $_SESSION['materno']    = $row['materno'];
                        $_SESSION['telefono']   = $row['telefono'];

                        $_SESSION['managedStore'] = "";
                        $_SESSION['nombreTienda'] = "";

                        if ($tiendasOwner !== false)
                        {

                            $sucursales = getSucursalesTienda($conn, $tiendasOwner[0]['idTienda']);
                            //Actualizo el id de sesión actual con uno generado más reciente
                            session_regenerate_id(true);


                            // $_SESSION['username']   = $row['username']; // Comentada para validar que se consulte la tabla tiendas desde getTiendasOwner();

                            if (count($tiendasOwner)>1)
                            {
                                // Elegir tienda
                                //echo "elegir tienda";
                            }

                            if (count($tiendasOwner) == 1)
                            {
                                // Guardar tienda en sesión
                                $_SESSION['username']     = $tiendasOwner[0]['idTienda'];
                                $_SESSION['managedStore'] = $tiendasOwner[0]['idTienda'];
                                $_SESSION['nombreTienda'] = $tiendasOwner[0]['nombreTienda'];


                                // Guardar en sesión la sucursal principal
                                foreach ($sucursales as $key => $branch)
                                {
                                    if ($branch['isPrincipal'] == 1)
                                    {
                                        $_SESSION['idSucursalVenta'] = $branch['idSucursal'];
                                        $_SESSION['nombreSucursalVenta'] = $branch['nombreSucursal'];
                                    }
                                }
                            }

                            // echo "<pre>";
                            // print_r($_SESSION);
                            // die;

                            // Busco en config.php si está algun bloqueo, "preregistro"
                            // $preventLogin es 1 paso antes del login, administrar desde config.php
                            if ($preventLogin == false)
                            {
                                // direcciono al panel de administración o pagina del logueo exitoso.
                                if (isset($redirect) && !empty($redirect))
                                {
                                    header('Location: ../' . $redirect . '?tienda=' . $vendedor);
                                    exit;
                                }
                                else
                                {
                                    header('Location: index.php?msg=bienvenido');
                                    exit;
                                }
                            }
                            else
                            {
                                // var_dump($preventLogin);
                                header('Location: ' . $preventLogin);
                                exit();
                            }
                        }
                        else
                        {
                            // var_dump($preventLogin);
                            header('Location: setup_tienda.php');
                            exit();
                        }
                    }
                    else
                    {
                        // Configuro mensaje de error
                        $error_message = "errorCredencialesInvalidas";
                    }
                }
                else
                {
                    // Configuro mensaje de error
                    $error_message = "errorCuentaInactiva";
                }
            }
            else
            {
                // Si el email no existe, no esta registrado, mando error
                $error_message = "errorCredencialesInvalidasNulo";
            }
        }
        else
        {
            // En caso que no haya completado los campos del formulario
            $error_message = "errorDatosFaltantes";
        }

        header('Location: index.php?msg=' . $error_message . "&email=" . $form_email);
        exit();

    }
    // FIN LOGIN CUENTA


    // REGISTRAR USUARIO
    if(isset($_POST['form_email']) && isset($_POST['btnRegistrar']))
  	{

    	// Escapo posibles caracteres especiales que haya ingresado
    	$form_email = mysqli_real_escape_string($conn, htmlspecialchars($_POST['form_email']));

  		//Verifico que el email sea valido, que tenga el formato correcto
  		if (filter_var($form_email, FILTER_VALIDATE_EMAIL))
  		{
  				// Verifico que email no exista previamente en la tabla
  				$verifico_email = mysqli_query($conn, "SELECT `email` FROM `usuarios` WHERE email = '$form_email'");

  				if(mysqli_num_rows($verifico_email) > 0)
  				{
  					$error_message = "errorEmailExistente";
  				}
  				else
  				{
  					// En caso que no exista, procedo a preparar el campo clave para guardarlo
  					// Utilizaremos la funcion password_hash ( http://php.net/manual/en/function.password-hash.php )

  					// Encripto la clave ingresada desde el formulario
  					//$usuario_hash_password = password_hash($_POST['form_password'], PASSWORD_DEFAULT);

  					//Genero Token para activar la cuenta
  					$token = substr(str_shuffle("0123456789"), 0, 6);

  					//$token = base64_encode(openssl_random_pseudo_bytes(4));

  					//echo "token: " . $token . "<br>";
  					$linkActivacion = "<a href=' " . $urlActivacion . "app/verifica/index.php?email=". $form_email ."&token=". ($token) ."'>Activar ahora</a>";
  					// Ahora ingreso los valores previamente preparados
  					$inserto_usuario = mysqli_query($conn, "INSERT INTO `usuarios` (email, token, isActive, isVerified) VALUES ('$form_email', '$token', 0, 0)");

  					// Verifico errores y preparo mensajes
  					if($inserto_usuario === TRUE)
  					{

  						$success_message = "registradoCorrectamente";

  						$emailRecipiente 	= $form_email;
  						$nombreRecipiente = $form_email;

                        $tituloCorreo  = "Activa tu cuenta vendy";
                        $cuerpoCorreo  = '<!DOCTYPE html<html lang="es" dir="ltr<head><meta charset="utf-8"><title>VENDY</title></head><body>';
                        $cuerpoCorreo .= "<h2>¡Felicidades! Estás a un paso de unirte a <span class='font-size: 28px; font-weight: bold;'>vendy</span>, usa el siguiente botón para activar tu cuenta: <br><br><b>" . $linkActivacion . "</b></h2><br>";
                        $cuerpoCorreo .= "<br><br>Si no puedes ver el botón correctamente copia el siguiente enlace y pégalo en tu navegador web:<br>";
                        $cuerpoCorreo .= $urlActivacion . "app/verifica/index.php?email=". $form_email ."&token=". ($token) . "</body></html>";

  						enviaEmail($emailRecipiente, $nombreRecipiente, $tituloCorreo, $cuerpoCorreo);

  					}
  					else
  					{
  						$error_message = "errorSql";
  					}

  				}
  		}
  		else
  		{
  				// Si el email no es correcto, notifico en el mensaje
  				$error_message = "errorEmailInvalido";
  		}

      // redireccionaMsg($vista, $parametro)


      $landing = "../index.php";

      if (isset($success_message))
      {
        //echo "success_message:" . $success_message;
        redireccionaMsg("index.php", $success_message . "&email=" . $form_email);
      }
      elseif(isset($error_message))
      {
        //echo "error_message:" . $error_message;
        redireccionaMsg($landing, $error_message . "#registro");
      }
      else
      {
        //echo "string";
        redireccionaMsg($landing, "#registro");
      }


  	}
  	// FIN REGISTRAR USUARIO


    // Agregar a la sesion del carrito
    if (isset($_POST['btnAgregarCarrito2']) && isset($_POST['idProducto']))
    {

        $idProducto  = $_POST['idProducto'];
        $redireccion = $_POST['redireccion'];

        //echo "Agregar carrito<br><br>";
        //echo "Agregando ahora: ". $idProducto . "<br><br>";

        $_SESSION['cart'][] = $idProducto;

        print_r($redireccion);

        $word = "?id=";
        $mystring = $redireccion;

        // Test if string contains the word
        if(strpos($mystring, $word) !== false)
        {
            //echo "Word Found!";
            $msgAlerta = "&msg=addedToCart";
        }
        else
        {
            //echo "Word Not Found!";
            $msgAlerta = "&msg=addedToCart";
        }

        header('Location: ../' . $redireccion . $msgAlerta);
        exit();
    }


  // ACTIVAR CUENTA
  if(isset($_POST['btnActivarCuenta'])
            && isset($_POST['nombre']) 
            && !empty($_POST['nombre']) 
            && isset($_POST['psw'])
            && !empty($_POST['psw'])
            && isset($_POST['psw2'])
            && !empty($_POST['psw2'])
    )
    {
    
    $nombre        = "";
    $paterno       = "";
    $materno       = "";
    $telefono      = "";
    $password      = "";
    $password2     = "";
    $externalEmail = "";
    $externalToken = "";

    $nombre        = limpiarDato($_POST['nombre']);
    $paterno       = limpiarDato($_POST['paterno']);
    $materno       = limpiarDato($_POST['materno']);
    $telefono      = limpiarDato($_POST['telefono']);
    $password      = limpiarDato($_POST['psw']);
    $password2     = limpiarDato($_POST['psw2']);
    $externalEmail = limpiarDato($_POST['email']);
    $externalToken = limpiarDato(($_POST['token']));

    $number     = preg_match('@[0-9]@', $password);
    $uppercase  = preg_match('@[A-Z]@', $password);
    $lowercase  = preg_match('@[a-z]@', $password);

    // echo "nombre: " . $nombre        . "<br>";
    // echo "password: " . $password      . "<br>";
    // echo "password2: " . $password2     . "<br>";
    // echo "externalEmail: " . $externalEmail . "<br>";
    // echo "externalToken: " . $externalToken . "<br><br><br>";

    //Valido parametros de password y que coincidan
    // if(strlen($password) < 8 || !$number || !$uppercase || !$lowercase || $password != $password2)
    if(strlen($password) < 8 || $password != $password2)
    {
    	 $error_message = "errorFormatoPass";
    }
    else
    {

        $sql = "SELECT * FROM usuarios WHERE email = '$externalEmail' AND isActive = 0";
        $verifico_email = mysqli_query($conn, $sql);

        if(mysqli_num_rows($verifico_email) == 1) // Si Hay un resultado (email) OK
        {

            //echo "validar token";
            while($row = $verifico_email->fetch_assoc())
            {
                $tokenDB    = $row['token'];
                $isVerified = $row['isVerified'];
            }

            if ($externalToken == $tokenDB)
            {

            //echo "Activar cuenta";
            $sql = "UPDATE usuarios SET
            nombre = '$nombre',
            paterno = '$paterno',
            materno = '$materno',
            telefono = '$telefono',
            password = '$password',
            nombre = '$nombre',
            isActive = 1 WHERE email = '$externalEmail'";

            if ($conn->query($sql) === TRUE)
            {
                $success_message = "Cuenta activada correctamente.";

                // Inicio el id de sesión actual con uno generado más reciente
                session_start();

                //coloco el email del usuario en una variable de sesión para poder acceder en otras páginas

                $_SESSION['nombre']     = $nombre;
                $_SESSION['paterno']    = $paterno;
                $_SESSION['materno']    = $materno;
                $_SESSION['email']      = $externalEmail;
                $_SESSION['isVerified'] = $isVerified;
                $_SESSION['telefono']   = $telefono;
                $_SESSION['isActive']   = 1;

                // direcciono al panel de administración o pagina del logueo exitoso.
                header('Location: ../setup-tienda.php?msg=cuentaActivada');
                exit;
            }
            else
            {
                $error_message = "Ocurrió un error. Intente nuevamente.3";
            }

            $conn->close();

            }
            else
            {
                $error_message = "errorToken";
            }

        }
        elseif(mysqli_num_rows($verifico_email) > 1) // Si hay más de 1 resultado
        {
            //Hay más de 1 coincidencia con el correo, error grave
            $error_message = "errorGrave";
        }
        else
        {
            //No existe email o cuenta activada
            $error_message = "errorActivacion";
        }
    }

    header('Location: index.php?msg=' . $error_message);
    exit();

    }
    // FIN ACTIVAR CUENTA
    // header('Location: dashboard.php?msg=c');
    // exit();
?>
