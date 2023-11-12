<?php

    session_start();

    
    require '../../../app/php/conexion.php';
    require '../../php/funciones.php';

    if (isset($_POST['lpn']))
    {
        $data = $_POST['lpn'];
        $data = limpiarDato($data);
    };

    // echo($data);
    $idTienda = $_SESSION['managedStore'];

    if (is_numeric($data))
    {
        // ================================ BUSQUEDA SCANNER ================================ //
        $barcode = $data;
        $datosProducto = getDatosProducto($conn, $idTienda, $barcode);

        if ($datosProducto !== false)
        {
            //return $datosProducto;
            $idProducto = $datosProducto['idProducto'];
            $idTienda   = $datosProducto['idTienda'];
            $stock      = 1;
            $precio     = $datosProducto['precio'];
            $precioOferta = $datosProducto['precioOferta'];
            $contadorCarrito = 0;

            if ($datosProducto['unidadVenta'] == "Piezas")
            {
                $response = agregarCarrito($conn, $datosProducto, $idProducto, $idTienda, $stock, $precio, $precioOferta);

                if ($response === true)
                {
                    // Itero el carrito para obtener total de elementos
                    // if (isset($_SESSION[$idTienda]))
                    // {
                    //     foreach ($_SESSION[$idTienda] as $producto)
                    //     {
                    //         $contadorCarrito += $producto['stock'];
                    //     }
                    // }
                    $contadorCarrito = contarCarrito($idTienda);

                    // Construyo el mensaje
                    $msg =  '<u>' . $datosProducto['nombre'] . '</u> agregado al carrito';

                    // Crear el array de respuesta con la información solicitada
                    $responseAjax = array(true, "notificacion", $msg, $contadorCarrito);

                    // Devolver la respuesta como un array en formato JSON
                    echo json_encode($responseAjax);
                }
                elseif ($response == "inventarioInsuficiente")
                {
                    $inventarioProductoDB = getInventarioProducto($conn, $idTienda, $idProducto);
                    $msg =  '<i class="fas fa-exclamation-triangle"></i> El inventario de <b>' . $datosProducto['nombre'] . '</b> es insuficiente. Disponible(s): ' . $inventarioProductoDB;
                    // Crear el array de respuesta con la información solicitada
                    $responseAjax = array(false, "notificacion", $msg);
                    // Devolver la respuesta como un array en formato JSON
                    echo json_encode($responseAjax);
                }
                elseif($response == 'stockInsuficiente')
                {
                    //exit(header('Location: ../'. $redirect .'?tienda=' . $idTienda .'&idProducto=' . $idProducto . '&msg=errorAddedToCart#notificacion'));
                    $msg =  '<i class="fas fa-exclamation-triangle"></i> <b>' . $datosProducto['nombre'] . '</b> está agotado.';
                    // Crear el array de respuesta con la información solicitada
                    $responseAjax = array(false, "notificacion", $msg);
                    // Devolver la respuesta como un array en formato JSON
                    echo json_encode($responseAjax);
                }
                elseif ($response === false)
                {
                    //exit(header('Location: ../'. $redirect .'?tienda=' . $idTienda .'&idProducto=' . $idProducto . '&msg=errorAddedToCart#notificacion'));
                    $msg =  '<i class="fas fa-exclamation-triangle"></i> Producto <u>' . $barcode . '</u> no encontrado.';
                    // Crear el array de respuesta con la información solicitada
                    $responseAjax = array(false, "notificacion", $msg);
                    // Devolver la respuesta como un array en formato JSON
                    echo json_encode($responseAjax);
                }
            }
            else
            {
                // ===================== VENTA GRANEL, ENVIAR IDPRODUCTO Y SOLICITAR DATOS AL USUARIO CON MODAL EN POS.PHP ===================== //
                // Le paso el idProducto
                $msg =  $datosProducto['idProducto'];
                // Crear el array de respuesta con la información solicitada
                $responseAjax = array(false, "sweetAlert", $msg);
                // Devolver la respuesta como un array en formato JSON
                echo json_encode($responseAjax);
            }
        }
        else
        {
            // ===================== ESCANEO NO ENCONTRADO EN DB ===================== //

            $msg =  'Producto no encontrado.';
            // Crear el array de respuesta con la información solicitada
            $responseAjax = array(false, "notificacion", $msg);
            // Devolver la respuesta como un array en formato JSON
            echo json_encode($responseAjax);
            //return false;
        }
    }
    else
    {
        // ================================ BUSQUEDA MANUAL ================================ //
        $sql = "SELECT
                    producto.*, imgProducto.url AS url
                FROM
                    productos AS producto
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
                    (producto.nombre LIKE '%$data%' OR producto.idProducto = '$data')
                GROUP BY
                    producto.nombre
                ORDER BY
                    producto.nombre ASC";

        $result = mysqli_query($conn, $sql);

        // Mostrar los resultados
        $msg = '<p class="mb-2 mt-4 fw-600 fs-4">Resultados: </p>';

        if (mysqli_num_rows($result) > 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                ob_start();
                ?>
                <div class="col-xl-6 mb-4">
                    <!-- Dashboard example card 1-->
                    <a class="card h-100 text-decoration-none">
                        <div class="card-body d-flex justify-content-center flex-column">
                            <div class="d-flex align-items-center justify-content-between">
                                <img class="rounded-1" src="<?php echo $dominio; ?>/app/verifica/usr_docs/<?php echo $row["idTienda"]; ?>/productos/<?php echo $row["idProducto"]; ?>/<?php echo $row["url"]; ?>" alt="..." style="width: 8rem" />
                                <div class="ms-3">
                                    <!-- <i class="feather-xl text-primary mb-3" data-feather="package"></i> -->
                                    <h5 class="fw-600"><?php echo $row["nombre"]; ?></h5>
                                    <div class="text-green fw-700 small">
                                        <?php
                                        if ($row["precioOferta"] < $row["precio"] && ($row["precioOferta"] > 0)) {
                                            echo "$ " . number_format($row["precioOferta"], 2);
                                            ?>
                                            <span class="text-danger">
                                                <s>
                                                    <?php echo "$ " . number_format($row["precio"], 2); ?>
                                                </s>
                                            </span>
                                            <?php
                                        } else {
                                            echo "$ " . number_format($row["precio"], 2);
                                        }
                                        ?>
                                    </div>

                                    <div class="mb-2">
                                        <button type="button" class="btn btn-outline-blue btn-sm mb-2" onclick="location.href='detalle-producto-pos.php?idProducto=<?php echo $row['idProducto']; ?>&tienda=<?php echo $row['idTienda']; ?>';">
                                            Detalle
                                        </button>
                                        <br>
                                        <span class="fw-300" style="font-size:12px;"><?php echo $row["inventario"] . " " . ((strpos($row["unidadVenta"], "Kilogramos") !== false) ? "Kgs." : "Pzs.") . " Disponibles"; ?></span>
                                    </div>

                                    <!-- <a href="carrito.php" class="btn btn-outline-success btn-sm mt-2 ">Detalle</a> -->
                                    <form action="procesa.php" method="post">

                                        <?php
                                            if ($row['unidadVenta'] == "Kilogramos")
                                            {
                                            ?>
                                                <div class="input-group mb-1 mt-2 w-100">

                                                    <input type="number" class="form-control" name="stock" value="10" id="<?php echo $row['id']; ?>" min="10" step="10" onchange="validarStock(this)" required>

                                                    <button class="btn btn-outline-success" type="button" onclick="decrementValueGranel(<?php echo $row['id']; ?>)">
                                                        <i class="fas fa-minus"></i>
                                                    </button>

                                                    <button class="btn btn-outline-success" type="button" onclick="incrementValueGranel(<?php echo $row['id']; ?>)">
                                                        <i class="fas fa-plus"></i>
                                                    </button>

                                                </div>
                                                <div class="small mb-2 text-center" id="salidaGramos">Gramos</div>
                                            <?php
                                            }
                                            else
                                            {
                                            ?>
                                                <!-- <input type="number" class="form-control form-control-sm" name="stock" value="1" step="1" min="1" required> -->
                                                <div class="input-group mb-1 mt-2 w-100">
                                                    <button class="btn btn-outline-success" type="button" onclick="decrementValue(<?php echo $row['id']; ?>)">
                                                        <i class="fas fa-minus"></i>
                                                    </button>

                                                    <input type="number" class="rounded-0 form-control text-center" name="stock" value="1" id="<?php echo $row['id']; ?>" min="1" step="1" pattern="[0-9]*" required>

                                                    <button class="btn btn-outline-success" type="button" onclick="incrementValue(<?php echo $row['id']; ?>)">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            <?php
                                            }
                                        ?>

                                        <input type="hidden" name="idProducto" value="<?php echo $row['idProducto']; ?>">
                                        <input type="hidden" name="idTienda" value="<?php echo $row['idTienda']; ?>">

                                        <button type="submit" class="btn btn-primary mt-2 w-100" name="btnAgregarCarrito" value="app/pos.php"
                                            <?php
                                            if ($row['inventario'] > 0)
                                            {
                                                //echo "disabled";
                                            }
                                            else
                                            {
                                                echo "disabled";
                                            }
                                            ?>>
                                            <i class="fa-solid fa-basket-shopping me-1"></i> Agregar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php
                $msg .= ob_get_clean();
            }
            $responseAjax = array(false, "contenido", $msg);
            // Devolver la respuesta como un array en formato JSON
            echo json_encode($responseAjax);
        }
        else
        {
            $msg =  'No se encontraron coincidencias, intenta nuevamente.';
            // Crear el array de respuesta con la información solicitada
            $responseAjax = array(false, "notificacion", $msg);
            // Devolver la respuesta como un array en formato JSON
            echo json_encode($responseAjax);
        }
    }
?>
