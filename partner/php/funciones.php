<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    date_default_timezone_set("America/Mexico_City");
    $hora = strtotime(date("Y-m-d h:i:s"));
    $time = date('Y-m-d h:i:s', $hora);

    // INICIO DASHBOARD
    function getTop10NoVendidos($conn, $idTienda)
    {
        $query = "SELECT productos.nombre, SUM(detallePedido.cantidad) as cantidadTotal
                FROM detallePedido
                INNER JOIN productos
                ON detallePedido.idProducto = productos.idProducto
                GROUP BY detallePedido.idProducto
                ORDER BY cantidadTotal ASC
                LIMIT 10";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0)
        {
        while($row = mysqli_fetch_array($result))
        {
            echo "Producto: " . $row['nombre'] . " | Cantidad vendida: " . $row['cantidadTotal'] . "<br>";
        }
        }
        else
        {
        echo "No hay resultados";
        }
    }

    function getTop10Vendidos($conn, $idTienda)
    {
        $query = "SELECT productos.nombre, SUM(detallePedido.cantidad) as cantidadTotal
                FROM detallePedido
                INNER JOIN productos
                ON detallePedido.idProducto = productos.idProducto
                GROUP BY detallePedido.idProducto
                ORDER BY cantidadTotal DESC
                LIMIT 10";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0)
        {
            while($row = mysqli_fetch_array($result))
            {
            return "Producto: " . $row['nombre'] . " | Cantidad vendida: " . $row['cantidadTotal'] . "<br>";
            }
        }
        else
        {
            return "No hay resultados";
        }
    }

    function getTotalPedidosHoy($conn, $idTienda)
    {
        $dia = date("d");
        $mes = date("m");
        $anio = date("Y");
        $query = "SELECT COUNT(*) as totalPedidos FROM pedidos WHERE MONTH(fechaPedido) = '$mes' AND DAY(fechaPedido) = '$dia' AND YEAR(fechaPedido) = '$anio' AND idTienda = '$idTienda'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result);
        $totalPedidos = $row['totalPedidos'];
        echo $totalPedidos;
    }

    function getTotalPedidosMesActual($conn, $idTienda)
    {
        $mesActual = date("m");
        $query = "SELECT COUNT(*) as totalPedidos FROM pedidos WHERE MONTH(fechaPedido) = '$mesActual' AND idTienda = '$idTienda'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result);
        $totalPedidos = $row['totalPedidos'];
        echo $totalPedidos;
    }

    function getTotalVendidoDiaActual($conn, $idTienda)
    {
        $totalVendido = 0;
        $fechaActual = date("Y-m-d");
        $query = "SELECT total FROM pedidos WHERE fechaPedido BETWEEN '$fechaActual 00:00:00' AND '$fechaActual 23:59:59' AND idTienda = '$idTienda'";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_array($result)) {
            $totalVendido += $row['total'];
        }
        echo $totalVendido;
    }

    function getTotalVendidoMesActual($conn, $idTienda)
    {
        $totalVendido = 0;
        $mesActual = date("m");
        $query = "SELECT total FROM pedidos WHERE MONTH(fechaPedido) = '$mesActual' AND idTienda = '$idTienda'";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_array($result))
        {
            $totalVendido += $row['total'];
        }
        echo number_format($totalVendido, 0);
    }
    // FIN DASHBOARD

    function getCategoriasMasVendidas($conn, $idTienda)
    {
        $sql = "SELECT
                    p.nombre,
                    p.idProducto,
                    p.unidadVenta,
                    p.idCategoria,
                    c.nombre AS nombreCategoria,
                    COUNT(d.idPedido) AS num_pedidos,
                    SUM(d.cantidad) AS cantidad_vendida
                FROM
                    detallePedido d
                JOIN productos p ON
                    d.idProducto = p.idProducto
                INNER JOIN pedidos pe ON
                    d.idPedido = pe.idPedido
                JOIN categoriasTienda c ON
                    p.idCategoria = c.idCategoria
                WHERE
                    pe.isActive = 1 AND pe.idTienda = '$idTienda'
                GROUP BY
                    p.idCategoria
                ORDER BY
                    cantidad_vendida
                DESC LIMIT 5";

        // Ejecución de la consulta
        $resultado = mysqli_query($conn, $sql);

        if ($resultado->num_rows == 0)
        {
            // No hay registros para la tienda en cuestión
            return false;
        }
        else
        {
            $datos = array();
            while ($fila = mysqli_fetch_assoc($resultado))
            {
            $datos[] = $fila;
            }
            return $datos;
        }
    }

    function getProductosMasVendido($conn, $idTienda)
    {
        $sql = "SELECT p.nombre, p.idProducto, p.unidadVenta,
                        COUNT(d.idPedido) AS num_pedidos,
                        SUM(d.cantidad) AS cantidad_vendida,
                        p.costo,
                        p.precio,
                        (p.precio - p.costo) AS margen_ganancia
                FROM detallePedido d
                JOIN productos p ON d.idProducto = p.idProducto
                INNER JOIN pedidos pe ON d.idPedido = pe.idPedido
                WHERE pe.isActive = 1
                AND pe.idTienda = '$idTienda'
                GROUP BY p.idProducto
                ORDER BY cantidad_vendida DESC
                LIMIT 10";

        // Ejecución de la consulta
        $resultado = mysqli_query($conn, $sql);

        // Comprobación del resultado
        if ($resultado->num_rows == 0)
        {
            // No hay registros para la tienda en cuestión
            return false;
        }
        else
        {
            $datos = array();
            while ($fila = mysqli_fetch_assoc($resultado))
            {
            $datos[] = $fila;
            }
            return $datos;
        }
    }

    function consultarPedidosEfectivoTurno($conn, $idTienda, $fechaInicioTurno, $fechaActual)
    {
        $idMetodoDePago = "CASH";
        $stmt = $conn->prepare("SELECT SUM(total) as total FROM pedidos WHERE idTienda = ? AND idMetodoDePago = ? AND isActive = 1 AND fechaPedido BETWEEN ? AND ? ORDER BY fechaPedido ASC");
        $stmt->bind_param("ssss", $idTienda, $idMetodoDePago, $fechaInicioTurno, $fechaActual);
        $stmt->execute();
        $result = $stmt->get_result();
        $pedidos = 0;

        if ($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            $pedidos = $row['total'];
        }
        return $pedidos;
    }


    function obtener_ingresos_y_egresos_por_tienda($conn, $idTienda, $fechaInicioTurno, $fechaActual)
    {
        $result = array(
            'ingresos' => 0,
            'egresos' => 0
        );

        $fecha = date("Y-m-d");
        $stmt = $conn->prepare("SELECT idTipoMovimiento, SUM(monto) as total FROM ingresos_egresos_Tienda WHERE idTienda = ? AND fechaMovimiento BETWEEN ? AND ? GROUP BY idTipoMovimiento");
        $stmt->bind_param("sss", $idTienda, $fechaInicioTurno, $fechaActual);
        $stmt->execute();
        $stmt->bind_result($tipoMovimiento, $total);

        while ($stmt->fetch()) {
            if ($tipoMovimiento == "Ingreso Efectivo") {
                $result['ingresos'] = $total;
            } else if ($tipoMovimiento == "Egreso Efectivo") {
                $result['egresos'] = $total;
            }
        }
        return $result;
    }


    function isTurnoCajaActivo($conn, $idTienda, $idUsuario)
    {
        // Obtener el último registro de la tabla bitacoraCaja para la tienda en cuestión
        $query = "SELECT * FROM bitacoraCaja WHERE idTienda='$idTienda' ORDER BY fechaApertura DESC LIMIT 1";
        $result = $conn->query($query);
        $efectivoInicial   = 0;
        $fechaAperturaCaja = "";
        $usuarioTurno = "";
        $idTurno = "";

        if (!$result)
        {
            // Error al ejecutar la consulta
            $response = "errorConsulta";
            $estatus = false;
        }
        else if ($result->num_rows == 0)
        {
            // No hay registros para la tienda en cuestión
            $response = "noHayRegistros";
            $estatus = false;
        }
        else
        {

            $row = $result->fetch_assoc();
            $usuarioTurno      = $row['idUsuario'];
            $fechaAperturaCaja = $row['fechaApertura'];
            $idTurno           = $row['id'];

            if ($row['fechaCierre'] === null)
            {
                // Existe un turno activo para la tienda en cuestión
                if ($row['idUsuario'] === $idUsuario)
                {
                    // El turno activo es del usuario en cuestión
                    $response = "turnoActivoUsuarioActual";
                    $estatus  = true;
                }
                else
                {
                    // El turno activo no es del usuario en cuestión
                    $response = "turnoActivoNotUsuarioActual";
                    $estatus = false;
                }
                $efectivoInicial = $row['efectivoInicial'];
            }
            else
            {
                // No hay un turno activo para la tienda en cuestión
                $response = "turnoCajaInactivo";
                $estatus  = false;
            }
        }
        return array('estatus'  => $estatus,
                    'response' => $response,
                    'efectivoInicial' => $efectivoInicial,
                    'fechaApertura'   => $fechaAperturaCaja,
                    'usuarioTurno'    => $usuarioTurno,
                    'idTurno'         => $idTurno);
    }

    function obtenerPedidosAbiertos($conn, $idTienda, $fechaInicio, $fechaFin)
    {


        // Consulta SQL
        $sql = "SELECT
                        COUNT(idPedido) AS conteo
                    FROM
                        pedidos
                    WHERE
                        idEstatusPedido != 'EP-4'
                    AND idTienda = '$idTienda'
                    AND pedidos.isActive = 1";

        if (!is_null($fechaInicio) || !is_null($fechaFin))
        {
            $sql .= " AND DATE(fechaPedido) BETWEEN '$fechaInicio' AND '$fechaFin'";
        }

        // echo $sql;
        // Ejecutar la consulta
        $resultados = $conn->query($sql);

        if (!$resultados)
        {
            return false;
        }

        $datos = [];
        while ($fila = $resultados->fetch_assoc())
        {
            $datos = $fila;
        }
        return $datos;
    }

    function getVentasMetodoDePagoTienda($conn, $idTienda, $fechaInicio, $fechaFin)
    {
        // Consulta SQL
        $sql = "SELECT
                    pedidos.idTienda,
                    pedidos.idMetodoDePago,
                    pedidos.fechaPedido,
                    pedidos.fechaPago,
                    pedidos.idPedido,
                    pedidos.subtotal as subtotal_pedidos,
                    pedidos.total as total_pedidos,
                    CAT_metodoDePago.nombre as nombre_metodoPago,
                    CAT_metodoDePago.icono as icono
                FROM
                    `pedidos`
                LEFT JOIN CAT_metodoDePago
                ON pedidos.idMetodoDePago = CAT_metodoDePago.idMetodoDePago
                WHERE pedidos.idTienda = '$idTienda'
                AND DATE(pedidos.fechaPedido) BETWEEN '$fechaInicio' AND '$fechaFin'
                AND pedidos.isActive = 1
                ORDER BY pedidos.fechaPedido
                LIMIT 10"; // <-- Agregar la cláusula LIMIT aquí


        $resultados = $conn->query($sql);

        if ($resultados->num_rows > 0)
        {
            $datos = [];
            while ($fila = $resultados->fetch_assoc())
            {
                $datos[] = $fila;
            }
            return $datos;
        }
        else
        {

            return false;
        }
    }

    function getVentaGananciaPorMesTienda($conn, $idTienda)
    {
        $anio = date("Y");
        $sql = "SELECT
                    MONTH(pedidos.fechaPedido) AS mes,
                    ROUND(SUM(detallePedido.precioUnitario * detallePedido.cantidad), 2) AS total_Venta,
                    ROUND(SUM(detallePedido.costoUnitario * detallePedido.cantidad), 2) AS total_Costo,
                    ((ROUND(SUM(detallePedido.precioUnitario * detallePedido.cantidad), 2)) - (ROUND(SUM(detallePedido.costoUnitario * detallePedido.cantidad), 2))) AS total_Ganancia
                FROM
                    detallePedido
                INNER JOIN pedidos ON detallePedido.idPedido = pedidos.idPedido
                INNER JOIN tiendas ON pedidos.idTienda = tiendas.idTienda
                WHERE
                    tiendas.idTienda = '$idTienda' AND YEAR(pedidos.fechaPedido) = '$anio'
                GROUP BY
                    MONTH(pedidos.fechaPedido)";

        $resultados = $conn->query($sql);

        if (!$resultados)
        {
            return false;
        }

        $datos = [];

        while ($fila = $resultados->fetch_assoc())
        {
            $datos[] = $fila;
        }

        $resultados->free();
        return $datos;
    }


    function getGananciasPorPedido($conn)
    {
        $anio = date("Y");
        $sql = "SELECT
                    ROUND(SUM(detallePedido.precioUnitario * detallePedido.cantidad), 2) AS total_Venta,
                    ROUND(SUM(detallePedido.costoUnitario * detallePedido.cantidad), 2) AS total_Costo,
                    ((ROUND(SUM(detallePedido.precioUnitario * detallePedido.cantidad), 2))
                    -
                    (ROUND(SUM(detallePedido.costoUnitario * detallePedido.cantidad), 2))) AS total_Ganancia
                FROM
                    detallePedido
                INNER JOIN pedidos ON detallePedido.idPedido = pedidos.idPedido
                INNER JOIN tiendas ON pedidos.idTienda = tiendas.idTienda
                WHERE
                    tiendas.idTienda = 'velasartesanales' AND YEAR(pedidos.fechaPedido) = '$anio'
                GROUP BY
                    detallePedido.idPedido";

        $resultados = $conn->query($sql);

        if (!$resultados)
        {
            return false;
        }

        $datos = [];

        while ($fila = $resultados->fetch_assoc())
        {
            $datos[] = $fila;
        }

        $resultados->free();
        return $datos;
    }

    function getVentasGananciasTienda($conn, $idTienda, $fechaInicio, $fechaFin)
    {
        $fechaInicioUnix = strtotime($fechaInicio);
        $fechaFinUnix = strtotime($fechaFin);

        $fechaInicio = date('Y-m-d', $fechaInicioUnix);
        $fechaFin = date('Y-m-d', $fechaFinUnix);

        $query = "SELECT
                    COUNT(DISTINCT(detallePedido.idPedido)) AS total_CantidadPedidos,
                    ROUND(SUM(detallePedido.precioUnitario * detallePedido.cantidad), 2) AS total_Venta,
                    ROUND(SUM(detallePedido.costoUnitario  * detallePedido.cantidad), 2) AS total_Costo,
                    (
                        (ROUND(SUM(detallePedido.precioUnitario * detallePedido.cantidad), 2))
                        -
                        (ROUND(SUM(detallePedido.costoUnitario  * detallePedido.cantidad), 2))
                    ) AS total_Ganancia
                FROM
                    detallePedido
                INNER JOIN
                    pedidos ON detallePedido.idPedido = pedidos.idPedido
                INNER JOIN
                    tiendas ON pedidos.idTienda = tiendas.idTienda
                WHERE
                    tiendas.idTienda = '$idTienda'
                AND
                    DATE(pedidos.fechaPedido) BETWEEN '$fechaInicio' AND '$fechaFin'
                GROUP BY
                    detallePedido.idTienda";

        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 0)
        {
            $rows = array(
                'total_CantidadPedidos' => 0,
                'total_Venta' => 0,
                'total_Costo' => 0,
                'total_Ganancia' => 0,
            );
            return $rows;
        }

        $rows = array();
        while ($row = mysqli_fetch_assoc($result))
        {
            $rows = $row;
        }

        return $rows;
        var_dump($rows);
    }

    function getOperacionesIngresosTienda($conn, $idTienda, $fechaInicio, $fechaFin)
    {

        $venta_global = 0;
        $ingreso_global = 0;

        // echo $fechaInicio . " * " . $fechaFin . "<br>";
        // CALCULO LA VENTA GLOBAL
        echo $query = "SELECT * FROM
                    pedidos
                INNER JOIN
                    CAT_metodoDePago
                ON
                    pedidos.idMetodoDePago = CAT_metodoDePago.idMetodoDePago
                WHERE
                    pedidos.idTienda = '$idTienda'
                AND
                    DATE(pedidos.fechaPedido) BETWEEN '$fechaInicio' AND '$fechaFin'
                AND
                    pedidos.isActive = 1";
        echo "<br>";
        $result = mysqli_query($conn, $query);

        // Verificar si la consulta es exitosa
        if (!$result)
        {
            die("La consulta a la base de datos ha fallado: " . mysqli_error($conn));
        }

        // Almacenar los resultados en un array
        $ventaPedidos = array();
        while ($row = mysqli_fetch_assoc($result))
        {
            $ventaPedidos[] = $row;
        }


        // echo "Venta Global: <br>";
        // echo "<pre>";
        foreach ($ventaPedidos as $venta)
        {
            echo $venta['icono'] . "";
        }


        // CALCULO INGRESO GLOBAL
        $query = "SELECT COALESCE(ROUND(SUM(monto), 2), 0) as ingreso_global
                FROM ingresos_egresos_Tienda
                WHERE idTienda = '$idTienda'
                AND idTipoMovimiento = 'Ingreso'
                AND DATE(ingresos_egresos_Tienda.fechaMovimiento) BETWEEN '$fechaInicio' AND '$fechaFin'";

        $resultIngresoTotal = mysqli_query($conn, $query);

        if (mysqli_num_rows($resultIngresoTotal) == 0)
        {
            $ingreso_global = 0;
        }
        else
        {
            $rowDB = mysqli_fetch_assoc($resultIngresoTotal);
            $ingreso_global = $rowDB['ingreso_global'];
        }
        // echo "Ingreso: ";
        // var_dump($ingreso_global);
        $total = 0;
        $total += ($venta_global +$ingreso_global);

        return $total;
    }


    function getIngresosTienda($conn, $idTienda, $fechaInicio, $fechaFin)
    {

        $venta_global = 0;
        $ingreso_global = 0;

        // CALCULO LA VENTA GLOBAL
        $query = "SELECT ROUND(SUM(pedidos.total), 2) as venta_global FROM pedidos
                WHERE pedidos.idTienda = '$idTienda'
                AND DATE(pedidos.fechaPedido) BETWEEN '$fechaInicio' AND '$fechaFin'";
        $resultVentaTotal = mysqli_query($conn, $query);

        if (mysqli_num_rows($resultVentaTotal) == 0)
        {
            $venta_global = 0;
        }
        else
        {
            $rowDB = mysqli_fetch_assoc($resultVentaTotal);
            $venta_global = $rowDB['venta_global'];
        }

        // echo "Venta Global: <br>";
        // var_dump($venta_global);

        // CALCULO INGRESO GLOBAL
        $query = "SELECT COALESCE(ROUND(SUM(monto), 2), 0) as ingreso_global
                FROM ingresos_egresos_Tienda
                WHERE idTienda = '$idTienda'
                AND idTipoMovimiento = 'Ingreso'
                AND DATE(ingresos_egresos_Tienda.fechaMovimiento) BETWEEN '$fechaInicio' AND '$fechaFin'";

        $resultIngresoTotal = mysqli_query($conn, $query);

        if (mysqli_num_rows($resultIngresoTotal) == 0)
        {
            $ingreso_global = 0;
        }
        else
        {
            $rowDB = mysqli_fetch_assoc($resultIngresoTotal);
            $ingreso_global = $rowDB['ingreso_global'];
        }
        // echo "Ingreso: ";
        // var_dump($ingreso_global);
        $total = 0;
        $total += ($venta_global +$ingreso_global);

        return $total;
    }

    function getEgresosTienda($conn, $idTienda, $fechaInicio, $fechaFin)
    {
        $venta_global = 0;
        $ingreso_global = 0;

        // CALCULO LA INVERSIÓN DE LOS PRODUCTOS
        $query = "SELECT
                    ROUND(SUM(detallePedido.costoUnitario * detallePedido.cantidad), 2) AS inversion_productos
                FROM
                    detallePedido
                INNER JOIN
                    pedidos ON detallePedido.idPedido = pedidos.idPedido
                INNER JOIN
                    tiendas ON pedidos.idTienda = tiendas.idTienda
                WHERE
                    tiendas.idTienda = '$idTienda'
                AND
                    DATE(pedidos.fechaPedido) BETWEEN '$fechaInicio' AND '$fechaFin'";

        $resultInversionTotal = mysqli_query($conn, $query);

        if (mysqli_num_rows($resultInversionTotal) == 0)
        {
            $inversion_productos = 0;
        }
        else
        {
            $rowDB = mysqli_fetch_assoc($resultInversionTotal);
            $inversion_productos = $rowDB['inversion_productos'];
        }

        // echo "inversion_productos: <br>";
        // var_dump($inversion_productos);

        // CALCULO INGRESO GLOBAL
        $query = "SELECT COALESCE(ROUND(SUM(monto), 2), 0) as egreso_global
                FROM ingresos_egresos_Tienda
                WHERE idTienda = '$idTienda'
                AND idTipoMovimiento = 'Egreso'
                AND DATE(ingresos_egresos_Tienda.fechaMovimiento) BETWEEN '$fechaInicio' AND '$fechaFin'";

        $resultEgresoTotal = mysqli_query($conn, $query);

        if (mysqli_num_rows($resultEgresoTotal) == 0)
        {
            $egreso_global = 0; // Fix: changed variable name to match
        }
        else
        {
            $rowDB = mysqli_fetch_assoc($resultEgresoTotal);
            $egreso_global = $rowDB['egreso_global'];
        }

        // echo "Egreso: ";
        // var_dump($egreso_global);

        $total = 0;
        $total += ($inversion_productos + $egreso_global);

        return $total;
    }

    function existeBarcode($conn, $idTienda, $barcode)
    {
        $query = "SELECT barcode FROM productos WHERE idTienda = ? AND barcode = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $idTienda, $barcode);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
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

    function getDetallesProductoImg($conn, $idTienda, $idProducto)
    {
        $sql = "SELECT
                    productos.*,
                    imagenProducto.*
                FROM
                    productos
                LEFT JOIN
                    imagenProducto
                ON
                    productos.idTienda = imagenProducto.idTienda
                AND
                    productos.idProducto = imagenProducto.idProducto
                WHERE
                    imagenProducto.idTienda = '$idTienda'
                AND
                    productos.idTienda   = '$idTienda'
                AND
                    productos.isActive   = 1
                AND
                    productos.inventario > 0
                AND
                    productos.idProducto = '$idProducto'";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 0) {
            return false;
        }

        $rows = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    function getDatosProducto($conn, $idTienda, $barcode)
    {
        $sql = "SELECT
                    producto.*, imgProducto.url AS url
                FROM productos AS producto
                LEFT JOIN
                    imagenProducto AS imgProducto
                ON
                    producto.idProducto = imgProducto.idProducto
                AND
                    imgProducto.isPrincipal = 1
                WHERE
                    producto.idTienda = '$idTienda'
                AND
                    producto.isActive = 1
                AND
                    producto.barcode = '$barcode'
                GROUP BY
                    producto.nombre
                ORDER BY
                    producto.nombre ASC";

        $result = $conn->query($sql);

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

    function validarPickupTienda($conn, $idTienda)
    {
        $idTipoEnvio = "PIK";
        $sql = "SELECT * FROM enviosTiendas WHERE idTienda = '$idTienda' AND idTipoEnvio = '$idTipoEnvio'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0)
        {
            // Hay resultados
            return true;
        }
        else
        {
            // No hay resultados
            return false;
        }
    }

    function getImagenesProducto($conn, $idProducto, $idTienda)
    {
        // Preparar la consulta
        $stmt = mysqli_prepare($conn, "SELECT * FROM imagenProducto WHERE idTienda = ? AND idProducto = ?");
        mysqli_stmt_bind_param($stmt, "ss", $idTienda, $idProducto);

        // Ejecutar la consulta
        mysqli_stmt_execute($stmt);

        // Obtener el resultado
        $result = mysqli_stmt_get_result($stmt);

        // Verificar si hay filas
        if (mysqli_num_rows($result) === 0)
        {
            return false;
        }

        // Almacenar el resultado en un array
        $imagenes = array();
        while ($row = mysqli_fetch_assoc($result))
        {
            $imagenes[] = $row;
        }
        // Devolver el array con las imágenes
        return $imagenes;
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

    function guardarEnvioNuevo($conn, $idTienda, $nombreEnvio, $precioEnvio, $hasOnlinePayment, $hasDeliveryPayment)
    {
        $isActive    = 1;
        $idTipoEnvio = "DOM";

        // Consulta para verificar si ya existe un envío con el mismo nombre
        $queryVerificacion = "SELECT id FROM enviosTiendas WHERE nombreEnvio = '$nombreEnvio' AND idTienda = '$idTienda'";
        $resultadoVerificacion = mysqli_query($conn, $queryVerificacion);

        // Si no se encuentra un envío con el mismo nombre, se procede a insertar
            if (mysqli_num_rows($resultadoVerificacion) == 0)
            {
                // Consulta para insertar el nuevo envío
                $query = "INSERT INTO enviosTiendas (idTipoEnvio, idTienda, nombreEnvio, precioEnvio, hasOnlinePayment, hasDeliveryPayment, isActive) VALUES ('$idTipoEnvio', '$idTienda', '$nombreEnvio', '$precioEnvio', '$hasOnlinePayment', '$hasDeliveryPayment', '$isActive')";

                // Ejecución de la consulta
                $resultado = mysqli_query($conn, $query);

                if ($resultado)
                {
                    $respuesta["resultado"] = true;
                }
                else
                {
                    $respuesta["resultado"] = false;
                    $respuesta["error"] = base64_encode("Error al insertar el nuevo envío: " . mysqli_error($conn));
                }
            }
            else
            {
                $respuesta["resultado"] = false;
                $respuesta["error"] = base64_encode("Ya existe un envío con el mismo nombre para la tienda especificada");
            }
            return $respuesta;

    }

    function getEnviosTiendaPago($conn, $idTienda)
    {
        $sql = "SELECT
                    CAT_tipoEnvio.idEnvio,
                    CAT_tipoEnvio.nombre,
                    enviosTiendas.id,
                    enviosTiendas.idTienda,
                    enviosTiendas.nombreEnvio,
                    enviosTiendas.precioEnvio,
                    enviosTiendas.hasOnlinePayment,
                    enviosTiendas.hasDeliveryPayment
                FROM
                    enviosTiendas
                JOIN
                    CAT_tipoEnvio
                ON
                    enviosTiendas.idTipoEnvio = CAT_tipoEnvio.idEnvio
                WHERE
                    CAT_tipoEnvio.isActive = 1
                AND
                    enviosTiendas.idTienda = ?
                ORDER BY
                    precioEnvio
                ASC";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $idTienda);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0)
        {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        else
        {
            return false;
        }
    }

    function getEnviosTiendaConfig($conn, $idTienda)
    {
        $sql = "SELECT
                    CAT_tipoEnvio.idEnvio,
                    CAT_tipoEnvio.nombre,
                    enviosTiendas.id,
                    enviosTiendas.idTienda,
                    enviosTiendas.nombreEnvio,
                    enviosTiendas.precioEnvio,
                    enviosTiendas.hasOnlinePayment,
                    enviosTiendas.hasDeliveryPayment
                FROM
                    enviosTiendas
                JOIN
                    CAT_tipoEnvio
                ON
                    enviosTiendas.idTipoEnvio = CAT_tipoEnvio.idEnvio
                WHERE
                    CAT_tipoEnvio.isActive = 1
                AND
                    enviosTiendas.idTienda = ?
                AND
                    CAT_tipoEnvio.idEnvio != 'PIK'
                ORDER BY
                    precioEnvio, nombre
                ASC";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $idTienda);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0)
        {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        else
        {
            return false;
        }
    }

    function getTiendasRegistradas($conn)
    {
        $sql  = "SELECT * FROM tiendas";
        $stmt = mysqli_prepare($conn, $sql); 
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

    function getTiendasOwner($conn, $idUsuario)
    {
        $sql  = "SELECT * FROM tiendas WHERE administradoPor = ? AND isActive = 1";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $idUsuario);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $count  = mysqli_num_rows($result);
        if ($count === 0) {
            return false;
        } else {
            $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $data;
        }
    }

    function isIdTiendaAvailable($conn, $idTienda)
    {

        // Realizar la consulta en la base de datos para verificar si el idTienda existe
        $sql = "SELECT COUNT(*) FROM tiendas WHERE idTienda = '$idTienda'";
        $result = mysqli_query($conn, $sql);

        // Verificar si la consulta fue exitosa
        if (!$result)
        {
            return false;
        }

        // Obtener el número de filas afectadas por la consulta
        $row = mysqli_fetch_array($result);
        $count = $row[0];

        // Verificar si el idTienda existe en la base de datos
        if ($count > 0) {
            return false;
        } else {
            return true;
        }
    }


    function generaIdCategoria($conn, $idTienda)
    {
        // Generar una cadena única de longitud fija utilizando SHA-256
        $idCategoria = hash('sha256', uniqid());
        $idCategoria = substr($idCategoria, 0, 28);

        // Verificar si el ID aleatorio ya está en uso en la tabla de categorías
        $query = "SELECT * FROM categoriasTienda WHERE idCategoria = '$idCategoria' AND idTienda = '$idTienda'";
        $result = mysqli_query($conn, $query);

        // Si el ID aleatorio ya está en uso, volver a generar un ID aleatorio
        while (mysqli_num_rows($result) > 0)
        {
            $idCategoria = hash('sha256', uniqid());
            $idCategoria = substr($idCategoria, 0, 28);
            $result = mysqli_query($conn, $query);
        }

        // Devolver el ID único generado
        return $idCategoria;
    }


    function getDetallesProducto($conn, $idPedido, $idCliente, $idTienda)
    {
        $sql = "SELECT
                    productos.*,
                    detallePedido.*
                FROM
                    detallePedido
                INNER JOIN productos ON
                    (
                        (
                            detallePedido.idTienda = productos.idTienda
                        ) AND(
                            detallePedido.idProducto = productos.idProducto
                        )
                    )
                WHERE
                    detallePedido.idPedido  = '$idPedido'
                AND
                    detallePedido.idCliente = '$idCliente'
                AND
                    detallePedido.idTienda  = '$idTienda'";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0)
        {
            $i = 0;
            // output data of each row
            while($row = mysqli_fetch_assoc($result))
            {

                $data[$i]["idProducto"]       = $row["idProducto"];
                $data[$i]["idTienda"]         = $row["idTienda"];
                $data[$i]["nombre"]           = $row["nombre"];
                $data[$i]["descripcion"]      = $row["descripcion"];
                $data[$i]["idPedido"]         = $row["idPedido"];
                $data[$i]["cantidad"]         = $row["cantidad"];
                $data[$i]["precioUnitario"]   = $row["precioUnitario"];
                $i++;
            }

            return $data;
        }
        else
        {
            return false;
        }
    }

    function decodeIdVendedor($encoded)
    {
        return base64_decode(base64_decode($encoded));
    }

    function encodeIdVendedor($encoded)
    {
        return base64_encode(base64_encode($encoded));
    }

    function getProductosTiendaPOS($conn, $idTienda, $limiteRegistros)
    {
        $sql = "SELECT
                    productos.*,
                    imagenProducto.url
                FROM
                    productos
                LEFT JOIN
                    imagenProducto
                ON
                    productos.idProducto = imagenProducto.idProducto
                AND
                    productos.idTienda   = imagenProducto.idTienda
                WHERE
                    productos.idTienda = '$idTienda'
                AND productos.isActive = 1
                AND imagenProducto.isPrincipal = 1
                ORDER BY productos.id DESC, productos.inventario DESC";

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

    function getProductosTiendaPerfilPublico($conn, $idTienda, $limiteRegistros)
    {
        $sql = "SELECT
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
        categoriasTienda.nombre ASC, productos.nombre ASC;
    ";

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

    function hasCalificacionPedido($conn, $idPedido)
    {
        $query = "SELECT * FROM reputacionTienda WHERE idPedido = '$idPedido'";

        // echo $query;
        if(!$conn)
        {
            die("Error al conectar con la base de datos: " . mysqli_connect_error());
        }

        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result) > 0)
        {
            $reputacion = array();
            while($row = mysqli_fetch_assoc($result))
            {
                $reputacion = $row;
            }
            return $reputacion;
        }
        else
        {
            return false;
        }
    }

    function getPedidosCalificados($conn, $idTienda)
    {
        $query = "SELECT
                    pedidos.*,
                    reputacionTienda.*,
                    usuarios.*
                FROM
                    pedidos
                INNER JOIN reputacionTienda ON pedidos.idTienda = reputacionTienda.idTienda AND pedidos.idPedido = reputacionTienda.idPedido
                INNER JOIN usuarios ON reputacionTienda.idCliente = usuarios.email
                WHERE
                    pedidos.idTienda = '$idTienda'";

        // echo $query;
        if(!$conn)
        {
            die("Error al conectar con la base de datos: " . mysqli_connect_error());
        }

        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result) > 0)
        {
            $reputacion = array();
            while($row = mysqli_fetch_assoc($result))
            {
                $reputacion[] = $row;
            }
            return $reputacion;
        }
        else
        {
            return false;
        }
    }

    function getDireccionesCliente($conn, $idCliente)
    {

        // Creamos la consulta SQL
        $sql = "SELECT * FROM direccionesClientes WHERE idCliente = '$idCliente' AND isActive = 1";

        // Ejecutamos la consulta
        $result = mysqli_query($conn, $sql);

        // Verificamos si la consulta ha devuelto algún resultado
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

    function getTotalesPorUsuario($conn, $idTienda, $fechaInicio, $fechaFin)
    {

        // Creamos la consulta SQL
        $sql = "SELECT
                    COUNT(*) AS num_registros,
                    SUM(SUBSTRING_INDEX(total, ';', 1)) AS subtotal,
                    SUM(SUBSTRING_INDEX(SUBSTRING_INDEX(total, ';', 2), ';', -1)) AS descuento,
                    SUM(SUBSTRING_INDEX(SUBSTRING_INDEX(total, ';', 3), ';', -1)) AS envio,
                    SUM(SUBSTRING_INDEX(total, ';', -1)) AS total
                FROM pedidos
                WHERE email = '$idTienda'
                AND fechaPedido
                BETWEEN '$fechaInicio'
                AND '$fechaFin'";

        // Ejecutamos la consulta
        $result = mysqli_query($conn, $sql);

        // Verificamos si la consulta ha devuelto algún resultado
        if (mysqli_num_rows($result) > 0)
        {
            // Si hay resultados, obtenemos el primer y único resultado
            $row = mysqli_fetch_assoc($result);

            // Devolvemos el resultado como un array
            return $row;
        }
        else
        {
            // Si no hay resultados, devolvemos false
            return false;
        }
    }

    function getArticulosTienda($conn, $managedStore)
    {
        $managedStore ."<br>";
        $sql = "SELECT
                    productos.*,
                    categoriasTienda.nombre AS nombreCategoria
                FROM
                    productos
                INNER JOIN categoriasTienda ON productos.idCategoria = categoriasTienda.idCategoria
                WHERE
                    productos.idTienda = ?
                AND productos.isActive = 1";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $managedStore);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $data;
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

    function ocultarNombreCliente($string)
    {
        // Obtener el primer caracter de la cadena
        $first_char = ucwords(substr($string, 0, 1));

        // Obtener la longitud de la cadena
        $string_length = strlen($string);

        // Generar una cadena de asteriscos con la longitud de la cadena menos 1 (para excluir el primer caracter)
        $mask = str_repeat('*', $string_length - 1);

        // Devolver la cadena con el primer caracter y la máscara de asteriscos
        return $first_char . $mask;
    }

    function showStars($rating)
    {
        $fullStars = intval($rating / 2);
        $halfStar = ($rating / 2) - $fullStars >= 0.5;
        $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);

        if ($rating < 1)
        {
        echo '<i class="fas fa-star-half-alt text-yellow"></i>';
        }
        else
        {
            for ($i = 0; $i < $fullStars; $i++)
            {
                echo '<i class="fas fa-star text-yellow"></i>';
            }
            if ($halfStar)
            {
                echo '<i class="fas fa-star-half-alt text-yellow"></i>';
            }
        }

        for ($i = 0; $i < $emptyStars; $i++)
        {
            echo '<i class="far fa-star text-yellow"></i>';
        }
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

    function restaInventarioProducto($conn, $idTienda, $idProducto, $stock)
    {

        $sql ="UPDATE `productos` SET inventario = inventario - $stock WHERE idTienda = '$idTienda' AND idProducto = '$idProducto'";

        if (mysqli_query($conn, $sql))
        {
            return true;
        }
        else
        {
            return false;
        }


    }

    function getProductosComprados($conn, $idPedido, $idTienda)
    {
        $sql = "SELECT
                    productos.*,
                    detallePedido.*
                FROM
                    detallePedido
                INNER JOIN productos ON
                    (
                        (
                            detallePedido.idTienda = productos.idTienda
                        ) AND(
                            detallePedido.idProducto = productos.idProducto
                        )
                    )
                WHERE
                    detallePedido.idPedido = '$idPedido' AND detallePedido.idTienda = '$idTienda'";

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

    function cierrePedido($conn, $idPedido, $idCliente, $idTienda)
    {
        $fechaCierrePedido = date("Y-m-d h:i:s");
        $sql = "UPDATE pedidos SET idEstatusPedido = 'EP-4', fechaCierrePedido = '$fechaCierrePedido' WHERE idPedido = '$idPedido' AND idTienda = '$idTienda'";

        $response = false;
        if (mysqli_query($conn, $sql))
        {
            //echo "New record created successfully";
            $response = true;
        }

        return $response;

    }

    function guardarEnvio($conn, $guiaEnvio, $nombrePaqueteria, $fechaEnvio, $idPedido, $idCliente)
    {

        if (empty($guiaEnvio) || empty($nombrePaqueteria))
        {
            $sql = "UPDATE pedidos SET fechaEnvio = '$fechaEnvio', idEstatusPedido = 'EP-3' WHERE idPedido = '$idPedido' AND idCliente = '$idCliente'";
        }
        else
        {
            $sql = "UPDATE pedidos SET guiaEnvio = '$guiaEnvio', paqueteriaEnvio = '$nombrePaqueteria', fechaEnvio = '$fechaEnvio', idEstatusPedido = 'EP-3' WHERE idPedido = '$idPedido' AND idCliente = '$idCliente'";
        }

        $response = false;
        if (mysqli_query($conn, $sql))
        {
            //echo "New record created successfully";
            $response = true;
        }
        return $response;
    }

    function registraComprobante($conn, $nombreComprobante, $idPedido, $idCliente, $fechaPago, $hasFile)
    {


        if (is_bool($hasFile) && $hasFile == true)
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
        }
        else
        {
            // Registra datos del pedido sin comprobante de pago
            $sql = "UPDATE pedidos SET
                        idEstatusPedido = 'EP-2',
                        fechaPago = '$fechaPago'
                    WHERE
                        idPedido = '$idPedido'
                    AND
                        idCliente = '$idCliente'";
        }

        if (is_null($fechaPago))
        {
            $sql = "UPDATE pedidos SET comprobantePago = '$nombreComprobante' WHERE idPedido = '$idPedido' AND idCliente = '$idCliente'";
        }
        // echo $nombreComprobante;

        $response = false;
        if (mysqli_query($conn, $sql))
        {
            //echo "New record created successfully";
            $response = true;
        }
        return $response;

    }

    function cargarComprobante($conn, $idCliente, $idPedido)
    {
        $sql = "SELECT idTienda FROM pedidos WHERE idCliente = '$idCliente' AND idPedido = '$idPedido'";
        $resultado = mysqli_query($conn, $sql);

        // Verificación del resultado
        if ($resultado)
        {
            // La consulta se ejecutó correctamente
            $fila = mysqli_fetch_assoc($resultado);
            $idTienda = $fila['idTienda'];
        }
        // else
        // {
        //     // Ocurrió un error al ejecutar la consulta
        //     return false;
        //     exit;
        // }

        $salida = false;
        // if ($FILES['fileToUpload']['size'] <= 0)
        // {
        //     return true;
        //     exit;
        // }

        // Apunta a la carpeta del pedido
        $target_dir = "verifica/usr_docs/" . $idTienda . "/pedidos/" . $idPedido . "/";

        if(is_dir($target_dir))
        {
        }
        else
        {
            mkdir($target_dir, 0777, true);
        }

        $target_file = $target_dir . $idPedido . "." . strtolower(pathinfo($_FILES['fileToUpload']['name'], PATHINFO_EXTENSION));
        $extension = strtolower(pathinfo($_FILES['fileToUpload']['name'], PATHINFO_EXTENSION));
        // Apunta al arhivo: "verifica/usr_docs/idCliente/Pagos/idPedido.ext"

        $uploadOk = 1;

        if(!is_dir($target_dir))
        {
            mkdir($target_dir, 0777, true);
        }

        // Check if file already exists
        // if (file_exists($target_file))
        // {
        //     echo "Sorry, file already exists.";
        //     $uploadOk = 0;
        // }

        // Check file size
        // if ($_FILES["fileToUpload"]["size"] > 500000)
        // {
        //     echo "Sorry, your file is too large.";
        //     $uploadOk = 0;
        // }

        // Allow certain file formats
        $allowedExt = Array('jpg', 'png', 'jpeg', 'pdf', 'webp');

        if(!in_array($extension, $allowedExt))
        {
            $msg = "Sólo se admiten archivos 'jpg', 'png', 'jpeg' y 'pdf'. ";
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
                $nombre = $idPedido . "." . strtolower(pathinfo($_FILES['fileToUpload']['name'], PATHINFO_EXTENSION));
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

    function getDatosCliente($conn, $idCliente)
    {
        $sql = "SELECT
                *
                FROM
                usuarios
                WHERE
                    email = '$idCliente'
                AND isActive = 1";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0)
        {

            // output data of each row
            while($row = mysqli_fetch_assoc($result))
            {

                $data["nombre"]   = $row["nombre"];
                $data["paterno"]  = $row["paterno"];
                $data["materno"]  = $row["materno"];
                $data["telefono"] = $row["telefono"];

            }

            return $data;
        }
        else
        {
            return false;
        }
    }

    function getNombreVendedor($conn, $idVendedor)
    {
        $sql = "SELECT
                *
                FROM
                usuarios
                WHERE
                    email = '$idVendedor'";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0)
        {

            // output data of each row
            while($row = mysqli_fetch_assoc($result))
            {

                $data["nombre"]   = $row["nombre"];
                $data["paterno"] = $row["paterno"];
                $data["materno"]  = $row["materno"];

            }

            return $data;
        }
        else
        {
            return false;
        }
    }

    function getListadoMediosContactoDisponible($conn, $idTienda)
    {
        $sql = "SELECT * FROM CAT_mediosContacto
                WHERE idMediosContacto
                NOT IN
                (
                    SELECT DISTINCT idMediosContacto
                    FROM contactoTiendas
                    WHERE isActive = 1 AND idTienda = '$idTienda'
                )
                AND isActive = 1 ORDER BY alias ASC";


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

    function getDireccionPedidoDetalle($conn, $idEnvio, $idDireccionEnvio, $idCliente, $idTienda)
    {

        // e/cho $idEnvio . "<br>" . $idDireccionEnvio . "<br>" . $idCliente . "<br>" . $idTienda;
        $consultaDB = 0;
        $recolectarSucursal = 0;
        $msg = "";
        $output = Array();

        switch ($idEnvio)
        {

        case 'DOM': // Paquetería
            $consultaDB = 1;
            $output['msg'] = "Recibirás tu paquete en:";
            break;

        case 'PIK': // Sucursal
            $consultaDB = 1;
            $recolectarSucursal = 1;
            $output['msg'] = "Podrás recolectar tu paquete en:";
            break;


        default:
            // code...
            break;

        }
        //echo "consultaDB: " . $consultaDB . "<br>";

        if ($consultaDB)
        {
            $datos;
            $i = 0;

            if ($recolectarSucursal)
            {

                $sql = "SELECT * FROM sucursalesTienda WHERE idTienda = '$idTienda' AND idSucursal = '$idDireccionEnvio'";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0)
                {
                    // output data of each row
                    while ($row = mysqli_fetch_assoc($result))
                    {
                        $datos['id']              = $row['id'];
                        $datos['idSucursal']      = $row['idSucursal'];
                        $datos['nombreSucursal']  = $row['nombreSucursal'];
                        $datos['codigoPostal']    = $row['codigoPostal'];
                        $datos['estado']          = $row['estado'];
                        $datos['isPrincipal']     = $row['isPrincipal'];


                        $datos['calle']     = $row['calle'];
                        $datos['numeroExterior']     = $row['numeroExterior'];
                        $datos['interiorDepto']     = $row['interiorDepto'];
                        $datos['colonia']     = $row['colonia'];

                        $datos['codigoPostal']     = $row['codigoPostal'];
                        $datos['municipioAlcaldia']     = $row['municipioAlcaldia'];
                        $datos['estado']     = $row['estado'];
                    }

                    $direccion  = "";
                    $direccion .= ucfirst($datos['calle']) . ' ' . $datos['numeroExterior'];

                    if (!empty($datos['interiorDepto']))
                    {
                        $direccion .= ', No. Interior o Depto. ' . $datos['interiorDepto'];
                    }

                    $direccion .= ', Colonia ' . $datos['colonia'] . ', C.P. ' . $datos['codigoPostal'] . ', Municipio/Alcaldía: ' . $datos['municipioAlcaldia'] . ', ' . $datos['estado'];

                    $output['alias']     = $datos['nombreSucursal'];
                    $output['direccion'] = $direccion;

                    return $output;
                }
                else
                {
                    return $output;
                }

            }
            else
            {

                $sql = "SELECT * FROM direccionesClientes WHERE idCliente = '$idCliente' AND idDireccion = '$idDireccionEnvio'";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0)
                {
                    // output data of each row
                    while ($row = mysqli_fetch_assoc($result))
                    {
                        $output['direccion'] = $row['direccion'];
                        $output['alias']     = $row['aliasDireccion'];
                    }

                    return $output;
                }
                else
                {
                    return $output;
                }

            }

        }
        else
        {
            return $output;
        }

    }

    function getDatosPedidoCliente($conn, $idPedido, $idCliente)
    {
        $sql = "SELECT
                    pedidos.*,
                    CAT_estatusPedido.nombre AS estatusEnvio
                FROM
                    pedidos
                INNER JOIN 
                    CAT_estatusPedido ON pedidos.idEstatusPedido = CAT_estatusPedido.idEstatus
                WHERE
                    pedidos.idCliente = '$idCliente' 
                AND 
                    pedidos.idPedido = '$idPedido' 
                AND 
                    pedidos.isActive = 1";

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

    function getDatosPedido($conn, $idPedido, $idTienda)
    {
        $sql = "SELECT
                    CAT_estatusPedido.*,
                    pedidos.*,
                    CAT_metodoDePago.nombre AS nombreMetodoPago
                FROM
                    pedidos
                INNER JOIN CAT_estatusPedido ON pedidos.idEstatusPedido = CAT_estatusPedido.idEstatus
                LEFT JOIN CAT_metodoDePago ON pedidos.idMetodoDePago = CAT_metodoDePago.idMetodoDePago
                WHERE
                    pedidos.idPedido = '$idPedido' AND pedidos.idTienda = '$idTienda' AND pedidos.isActive = 1;";

        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0)
        {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            return $row;
        }
        else
        {
            return false;
        }
    }

    function generarIDSucursal($conn)
    {
        // Obtener el último consecutivo registrado en la tabla pedidos
        $sql = "SELECT MAX(CAST(RIGHT(idSucursal, LENGTH(idSucursal) - 4) AS UNSIGNED)) AS ultimo_consecutivo
                FROM sucursalesTienda
                WHERE idSucursal REGEXP '^SUC-[0-9]+$'";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0)
        {
            $row = mysqli_fetch_assoc($result);
            $ultimo_consecutivo = $row['ultimo_consecutivo'];
        }
        else
        {
            // Si no hay registros, empezar desde 1
            $ultimo_consecutivo = 0;
        }

        // Generar el nuevo consecutivo
        $nuevo_consecutivo = $ultimo_consecutivo + 1;

        // Construir el nuevo idPedido con el formato ddmmyyyy-consecutivo
        $nuevo_idPedido = 'SUC-' . $nuevo_consecutivo;

        return $nuevo_idPedido;
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
        <h1 style="margin: 0; color: #754aff; direction: ltr; font-family: "Cabin", Arial, "Helvetica Neue", Helvetica, sans-serif; font-size: 33px; font-weight: 700; letter-spacing: normal; line-height: 120%; text-align: center; margin-top: 0; margin-bottom: 0;"><a href="https://vendy.click" rel="noopener" style="color: #754aff;" target="_blank">Vendy</a></h1>
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
        <div align="center" class="alignment" style="line-height:10px"><img alt="Pedido Enviado" class="big" src="https://vendy.click/app/assets/img/mail/pedido-enviado.png" style="display: block; height: auto; border: 0; width: 441px; max-width: 100%;" title="Pedido Enviado" width="441"/></div>
        </td>
        </tr>
        </table>
        <table border="0" cellpadding="0" cellspacing="0" class="button_block block-5" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
        <tr>
        <td class="pad" style="padding-bottom:40px;padding-top:30px;text-align:center;">
        <div align="center" class="alignment">
        <!--[if mso]><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="https://vendy.click/app/detalleCompra.php?id=';

            $data .= $idPedido;
            $data .='" style="height:56px;width:180px;v-text-anchor:middle;" arcsize="9%" stroke="false" fillcolor="#4f7eef"><w:anchorlock/><v:textbox inset="0px,0px,0px,0px"><center style="color:#ffffff; font-family:Arial, sans-serif; font-size:18px"><![endif]-->

            <a href="https://vendy.click/app/detalleCompra.php?id=';

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
        <!--[if mso]><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="https://vendy.click/#registro" style="height:44px;width:152px;v-text-anchor:middle;" arcsize="19%" stroke="false" fillcolor="#dbe430"><w:anchorlock/><v:textbox inset="0px,0px,0px,0px"><center style="color:#000000; font-family:Arial, sans-serif; font-size:16px"><![endif]-->
            <a href="https://vendy.click/#registro" style="text-decoration:none;display:inline-block;color:#000000;background-color:#dbe430;border-radius:8px;width:auto;border-top:0px solid transparent;font-weight:400;border-right:0px solid transparent;border-bottom:0px solid transparent;border-left:0px solid transparent;padding-top:10px;padding-bottom:10px;font-family:Oswald, Arial, Helvetica Neue, Helvetica, sans-serif;font-size:16px;text-align:center;mso-border-alt:none;word-break:keep-all;" target="_blank">
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
        <div align="center" class="alignment" style="line-height:10px"><img alt="Back to School" src="https://vendy.click/app/assets/img/mail/tienda-ejemplo.png" style="display: block; height: auto; border: 0; width: 146px; max-width: 100%;" title="Back to School" width="146"/></div>
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
        <p style="margin: 0; font-size: 16px; text-align: center; mso-line-height-alt: 19.2px;"><span style="font-size:26px;"><strong><a href="httsp://vendy.click" rel="noopener" style="color: #ffffff;" target="_blank">vendy.click</a></strong></span><span style="font-size:18px;"><a href="httsp://vendy.click" rel="noopener" style="text-decoration: underline; color: #ffffff;" target="_blank"></a></span></p>
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
    <h1 style="margin: 0; color: #ffffff; direction: ltr; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif; font-size: 38px; font-weight: 700; letter-spacing: normal; line-height: 120%; text-align: center; margin-top: 0; margin-bottom: 0;"><a href="vendy.click" rel="noopener" style="text-decoration: none; color: #ffffff;" target="_blank"><span class="tinyMce-placeholder">Vendy</span></a></h1>
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
    <div align="center" class="alignment" style="line-height:10px"><img alt="Alternate text" class="big" src="https://vendy.click/app/assets/img/mail/plantillaOrdenConfirmada/round_corner.png" style="display: block; height: auto; border: 0; width: 680px; max-width: 100%;" title="Alternate text" width="680"/></div>
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
    <p style="margin: 0; font-size: 14px; mso-line-height-alt: 16.8px;"><span style="font-size:18px;"><strong><span style="">Dirección de envío:</span></strong></span></p>
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
    <!--[if mso]><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="https://vendy.click/app/detalleCompra.php?id='. $idPedido .'" style="height:42px;width:171px;v-text-anchor:middle;" arcsize="10%" stroke="false" fillcolor="#e17370"><w:anchorlock/><v:textbox inset="0px,0px,0px,0px"><center style="color:#ffffff; font-family:Tahoma, sans-serif; font-size:16px"><![endif]--><a href="https://vendy.click/app/detalleCompra.php?id='. $idPedido .'" style="text-decoration:none;display:inline-block;color:#ffffff;background-color:#e17370;border-radius:4px;width:auto;border-top:0px solid #E17370;font-weight:400;border-right:0px solid #E17370;border-bottom:0px solid #E17370;border-left:0px solid #E17370;padding-top:5px;padding-bottom:5px;font-family:Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;font-size:16px;text-align:center;mso-border-alt:none;word-break:keep-all;" target="_blank"><span style="padding-left:40px;padding-right:40px;font-size:16px;display:inline-block;letter-spacing:normal;"><span dir="ltr" style="word-break: break-word; line-height: 32px;">Ver Detalle </span></span></a>
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
    <!--[if mso]><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="https://vendy.click/app/detalleCompra.php?id=' . $idPedido . '" style="height:36px;width:189px;v-text-anchor:middle;" arcsize="12%" strokeweight="0.75pt" strokecolor="#E17370" fillcolor="#e17370"><w:anchorlock/><v:textbox inset="0px,0px,0px,0px"><center style="color:#ffffff; font-family:Tahoma, sans-serif; font-size:12px"><![endif]--><a href="https://vendy.click/app/detalleCompra.php?id=' . $idPedido . '" style="text-decoration:none;display:inline-block;color:#ffffff;background-color:#e17370;border-radius:4px;width:auto;border-top:1px solid #E17370;font-weight:400;border-right:1px solid #E17370;border-bottom:1px solid #E17370;border-left:1px solid #E17370;padding-top:5px;padding-bottom:5px;font-family:Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;font-size:12px;text-align:center;mso-border-alt:none;word-break:keep-all;" target="_blank"><span style="padding-left:30px;padding-right:30px;font-size:12px;display:inline-block;letter-spacing:normal;"><span dir="ltr" style="word-break: break-word; line-height: 24px;">Cargar comprobante</span></span></a>
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
    <p style="margin: 0; font-size: 14px; text-align: center; mso-line-height-alt: 24px;"><span style="font-size:16px;">Gracias por usar <span style="color:#ffffff;"><a href="https://vendy.click" rel="noopener" style="text-decoration: none; color: #ffffff;" target="_blank"><strong>vendy.click</strong></a></span><span style="background-color:#ffffff;"><a href="https://vendy.click" rel="noopener" style="text-decoration: none; background-color: #ffffff; color: #ffffff;" target="_blank"></a></span></span></p>
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
    <!--[if mso]><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="https://vendy.click/#registro" style="height:44px;width:188px;v-text-anchor:middle;" arcsize="10%" strokeweight="0.75pt" strokecolor="#E17370" fillcolor="#e17370"><w:anchorlock/><v:textbox inset="0px,0px,0px,0px"><center style="color:#ffffff; font-family:Tahoma, sans-serif; font-size:16px"><![endif]--><a href="https://vendy.click/#registro" style="text-decoration:none;display:inline-block;color:#ffffff;background-color:#e17370;border-radius:4px;width:auto;border-top:1px solid #E17370;font-weight:400;border-right:1px solid #E17370;border-bottom:1px solid #E17370;border-left:1px solid #E17370;padding-top:5px;padding-bottom:5px;font-family:Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;font-size:16px;text-align:center;mso-border-alt:none;word-break:keep-all;" target="_blank"><span style="padding-left:30px;padding-right:30px;font-size:16px;display:inline-block;letter-spacing:normal;"><span dir="ltr" style="word-break: break-word; line-height: 32px;">Crear mi tienda</span></span></a>
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
    <td style="padding:0 15px 0 0px;"><a href="https://instagram.com/" target="_blank"><img alt="Instagram" height="32" src="https://vendy.click/app/assets/img/mail/plantillaOrdenConfirmada/instagram2x.png" style="display: block; height: auto; border: 0;" title="Instagram" width="32"/></a></td>
    <td style="padding:0 15px 0 0px;"><a href="https://www.whatsapp.com" target="_blank"><img alt="WhatsApp" height="32" src="https://vendy.click/app/assets/img/mail/plantillaOrdenConfirmada/whatsapp2x.png" style="display: block; height: auto; border: 0;" title="WhatsApp" width="32"/></a></td>
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
        $msg = "Empty";
        
        
        echo "<br>Dirección Envio";
        var_dump($idDireccionEnvio);
        
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

        case 'DOM': // No Aplica
            $consultaDB = 1;            
            $recolectarSucursal = 0;
            $msg = "Recibirás tu paquete en:<br><br>";
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
        // Utiliza sentencias preparadas para evitar SQL injection
        $sql = "SELECT inventario FROM productos WHERE idTienda = ? AND idProducto = ? AND isActive = 1";
        
        // Preparar la sentencia
        $stmt = mysqli_prepare($conn, $sql);
        
        // Verificar si la preparación de la sentencia fue exitosa
        if ($stmt) 
        {
            // Asociar los parámetros y ejecutar la consulta
            mysqli_stmt_bind_param($stmt, "ss", $idTienda, $idProducto);
            mysqli_stmt_execute($stmt);
            
            // Obtener el resultado de la consulta
            mysqli_stmt_store_result($stmt);
            
            // Verificar si se encontraron resultados
            if (mysqli_stmt_num_rows($stmt) > 0) 
            {
                // Asociar el resultado a una variable
                mysqli_stmt_bind_result($stmt, $inventario);
                
                // Inicializar la variable de inventario
                $stock = 0;
                
                // Recorrer los resultados
                while (mysqli_stmt_fetch($stmt)) 
                {
                    $stock += $inventario;
                }
                
                // Cerrar la sentencia preparada
                mysqli_stmt_close($stmt);
                
                return $stock;
            }
        }
        
        return 0; // Devolver 0 si no se encontraron resultados o hubo un error
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
            $mail->Username  = 'contacto@vendy.click';
            $mail->Password  = 'kaka4545A1$$$';
            //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('contacto@vendy.click', 'vendy.click');
            $mail->addReplyTo('contacto@vendy.click', 'vendy.click');
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
            return false;
            //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
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
