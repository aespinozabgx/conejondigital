<?php

    session_start();

    require '../app/php/conexion.php';
    require 'php/funciones.php';

    if (isset($_SESSION['managedStore']))
    {
        $tienda = $_SESSION['managedStore'];
        $tienda = getDatosTienda($conn, $tienda); // $tienda recibe el idOwner y username(tienda)
        $idTienda = $tienda['idTienda'];
        $idOwner  = $tienda['administradoPor'];

        if ($tienda === false)
        {
            die("Redirecciona, usuario no encontrado");
        }
    }

    if (isset($_SESSION['email']))
    {
        $idUsuario = $_SESSION['email'];
    }

    $response = isTurnoCajaActivo($conn, $idTienda, $idUsuario);
    // echo "<pre>";
    // var_dump($response);
    // echo $response['estatus'];

    if (!$response['estatus'])
    {
        exit(header('Location: dashboard.php?msg=requiereAbrirTurnoCaja'));
    }

    $totalPedido = 0;
    $totalAPagar = 0;
    $precioSinDescuento = 0;
    $requiereEnvio = 0;

    if (isset($_SESSION['subtotal']) && isset($_SESSION['descuento']) && isset($_SESSION['total']))
    {
        $subtotal  = $_SESSION['subtotal'];
        $descuento = $_SESSION['descuento'];
        $total     = $_SESSION['total'];
    }

    $hasActivePayment = validarPagoActivo($conn, $idTienda);
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Cobro - vendy.mx</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
        <script src="js/qrcode.js"></script>
        <script src="js/ajax.js?id=2828"></script>

        <style type="text/css">

            .capitaliza
            {
                text-transform: capitalize;
            }

            .confirmaCobro
            {
                position:fixed;
                bottom:0px;
                left:0px;
                right:0px;
                height:50px;
                margin-bottom:0px;
                color: white;
            }

            body
            {
                margin-bottom:50px;
            }

        </style>
    </head>
    <body class="nav-fixed">
        <?php
            if (file_exists('src/header.php'))
            {
                require 'src/header.php';
            }
        ?>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <?php
                  if (file_exists('src/sideMenu.php'))
                  {
                      require 'src/sideMenu.php';
                  }
                ?>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <!-- Main page content-->
                    <div class="container-xl px-4 mt-4">
                        <!-- Invoice-->
                        <div class="card invoice">
                            <div class="card-header p-4 p-md-5 border-bottom-0 bg-primary text-white-50">
                                <div class="row justify-content-between align-items-center">
                                    
                                    <!-- <h1 class="text-white fs-100"><i data-feather="shopping-cart"></i></h1> -->
                                    <div class="col-12 col-lg-auto mb-2 mb-lg-0 text-center text-lg-start">

                                        <!-- Invoice branding-->
                                        <div class="display-4 text-white mb-2">
                                            <!-- <i data-feather="credit-card" class="feather-xl"></i> -->
                                            <span class="sombra2-titulos-vendy">Pago</span>
                                            <button class="btn bg-yellow text-white fs-4 rounded-pill">PDV</button>
                                        </div>
                                        
                                        

                                    </div>

                                    <div class="col-12 col-lg-auto text-center text-lg-end">
                                        <div class="h2 mt-2">
                                            <!-- <form action="procesa.php" method="post">
                                                <input type="hidden" name="idTienda" value="<?php //echo $idTienda; ?>">
                                                <button type="submit" class="btn btn-danger btn-sm rounded-2 lift" name="btnEliminaCarrito" value="carritoPos.php">Eliminar Carrito</button>
                                            </form> -->
                                            <a href="carritoPos.php" class="btn btn-outline-white rounded-pill shadow-sm fw-500 fs-6">
                                                <i class="fas fa-arrow-circle-left me-1"></i>
                                                Regresar
                                            </a>
                                        </div>
                                    </div>

                                </div>

                                <!-- <img class="invoice-brand-img rounded-circle mb-4" src="assets/img/demo/demo-logo.svg" alt="" /> -->
                                <div class="fs-4 fw-300 text-white-75 mb-0">
                                    Total de productos: 
                                    <span class="fw-500">
                                        <?php 
                                            echo contarCarrito($idTienda); 
                                        ?>
                                    </span>
                                </div>

                            </div>

                            <div class="card-body p-4 p-md-5">

                                

                                <?php
                                    // Mostrar totales
                                    // Validar si el carrito está vacio
                                    if (isset($_SESSION[$idTienda]))
                                    {
                                        ?>
                                        <div class="fs-4 text-dark mb-2">
                                            Selecciona la forma de pago elegida por el cliente:
                                        </div>
                                        
                                        <div class="table-responsive mb-0">
                                        <?php
                                            if (isset($_SESSION[$idTienda]))
                                            {
                                                $salida              = "";
                                                $acumPrecioPagar     = 0;
                                                $acumPrecioDescuento = 0;
                                                $acumSinDescuento    = 0;
                                                $acumConDescuento    = 0;
                                                $requiereEnvio       = 0;
                                                $contadorCarrito     = 0;

                                                // echo "<pre>";
                                                // print_r($_SESSION[$idTienda]);

                                                // Iterar carrito para ver si requiere envio
                                                foreach ($_SESSION[$idTienda] as $arr => $value)
                                                {
                                                    $idProducto = $_SESSION[$idTienda][$arr]['idProducto'];
                                                    $idUsuario  = $_SESSION[$idTienda][$arr]['idTienda'];
                                                    $datosProducto = buscarProducto($conn, $idProducto, $idUsuario);
                                                    $precio       = $datosProducto['precio'];
                                                    $precioOferta = $datosProducto['precioOferta'];
                                                    $cantidadProd = $_SESSION[$idTienda][$arr]['stock'];

                                                    // Contar productos del carrito, considerando cualquier cantidad de granel como 1 producto
                                                    if ($_SESSION[$idTienda][$arr]['unidadVenta'] == "Kilogramos")
                                                    {
                                                        $contadorCarrito += 1;
                                                    }
                                                    else
                                                    {
                                                        $contadorCarrito += $_SESSION[$idTienda][$arr]['stock'];
                                                    }

                                                    // Obtener otros totales
                                                    if ($precioOferta > 0 && $precioOferta < $precio)
                                                    {
                                                        $acumSinDescuento = $acumSinDescuento + ($cantidadProd * $precio);
                                                        $acumConDescuento = $acumConDescuento + ($cantidadProd * $precioOferta);
                                                    }
                                                    else
                                                    {
                                                        $acumSinDescuento = $acumSinDescuento + ($cantidadProd * $precio);
                                                        $acumConDescuento = $acumConDescuento + ($cantidadProd * $precio);
                                                    }
                                                }
                                            }
                                        ?>
                                        </div>

                                        <form action="procesa.php" method="post">

                                            <div class="">

                                                <div class="row">
                                                    <?php
                                                    $metodosDePagoTienda = getMetodosDePagoTienda($conn, $idTienda);
                                                    // echo "<pre>";
                                                    // var_dump($metodosDePagoTienda);
                                                    // die;
                                                    if ($metodosDePagoTienda)
                                                    {
                                                        foreach ($metodosDePagoTienda as $key => $pago)
                                                        {
                                                        ?>
                                                            <div class="col-lg-6 col-xl-6 mb-4 mt-2">
                                                                <div class="card bg-success text-white h-100">

                                                                    <div class="modal-header-sm">
                                                                        <span class="small fw-200" id="datosBancariosTiendaLabel">
                                                                            <?php echo ucwords($pago['nombreMP']); ?>
                                                                        </span>
                                                                        <div class="dropdown no-caret">
                                                                            <div class="dropdown-menu dropdown-menu-end animated--fade-in-up" aria-labelledby="dropdownMenuButton">
                                                                                <?php
                                                                                    $mp  = mb_strtoupper($pago['banco']);
                                                                                    $mp .= "," . $pago['clabe'];
                                                                                    $mp .= "," . $pago['numeroTarjeta'];
                                                                                    $mp .= "," . $pago['id'];

                                                                                    $terminacion = substr($pago['numeroTarjeta'], -4);

                                                                                    if (!isset($pago['urlPago']) && ($pago['idMetodoDePago'] == "TRANSFER"))
                                                                                    {
                                                                                        ?>
                                                                                        <a class="dropdown-item" href="javascript: void(0);" onclick="javascript: enviaModal('<?php echo $mp; ?>')" class="text-success small" data-bs-toggle="modal" data-bs-target="#datosBancariosTienda">
                                                                                            <div class="dropdown-item-icon"><i class="text-gray-500" data-feather="edit-3"></i></div>
                                                                                            Editar
                                                                                        </a>
                                                                                        <?php
                                                                                    }
                                                                                ?>

                                                                                <a class="dropdown-item" href="#!" onclick="javascript: sendToDeleteModal('<?php echo $pago['id'] . "," . $pago['nombreMP']; ?>')" class="text-success small" data-bs-toggle="modal" data-bs-target="#modalEliminarPago">
                                                                                    <div class="dropdown-item-icon"><i class="text-gray-500" data-feather="minus-circle"></i></div>
                                                                                    Eliminar
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="card-body">
                                                                        <div class="d-flex justify-content-between align-items-center">
                                                                            <div class="me-3">
                                                                                <div class="fw-600 fs-4 text-white">
                                                                                    <?php echo ucwords($pago['nombre']); ?>
                                                                                </div>

                                                                                <?php
                                                                                // Calcular cambio Efectivo
                                                                                if ($pago['idMetodoDePago'] == "CASH")
                                                                                {
                                                                                ?>
                                                                                    <div class="small text-white fw-200" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modalCalcularCambioEfectivo">
                                                                                        Calcular cambio <i class="fas fa-hand-holding-usd"></i>
                                                                                    </div>
                                                                                <?php
                                                                                }

                                                                                // Mostrar datos de tarjeta/cuenta
                                                                                if (!empty($terminacion))
                                                                                {
                                                                                ?>
                                                                                    <span class="text-white-75 fw-600"><?php echo "**** " . $terminacion; ?></span>
                                                                                    <span class="text-white" style="cursor: pointer;" onclick="javascript: enviaModal('<?php echo $mp; ?>'); makeCode('<?php echo $pago['clabe']; ?>');" data-bs-toggle="modal" data-bs-target="#datosBancariosTienda">
                                                                                        <i class="far fa-eye"></i>
                                                                                    </span>
                                                                                <?php
                                                                                }

                                                                                if ($pago['idMetodoDePago'] == "MP" || $pago['idMetodoDePago'] == "PP")
                                                                                {
                                                                                ?>
                                                                                    <span class="text-white fw-200" style="cursor: pointer;" onclick="javascript: makeCodeUrlPago('<?php echo $pago['urlPago']; ?>', '<?php echo $pago['nombre']; ?>');" data-bs-toggle="modal" data-bs-target="#modalQRCodeUrlPago">
                                                                                        Ver datos <i class="far fa-eye"></i>
                                                                                    </span>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                            <div class="display-6 text-white-50">
                                                                                <?php echo $pago['icono']; ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="card-footer text-white" style="cursor:pointer;">
                                                                    <?php
                                                                    switch (true)
                                                                    {
                                                                        case (isset($pago['urlPago']) && ($pago['idMetodoDePago'] == "PP" || $pago['idMetodoDePago'] == "MP")):
                                                                        // Paypal y MercadoPago
                                                                            ?>
                                                                            <div class="text-center" onclick="javascript: makeCodeUrlPago('<?php echo $pago['urlPago']; ?>', '<?php echo $pago['nombre']; ?>');" data-bs-toggle="modal" data-bs-target="#modalQRCodeUrlPago">
                                                                                <div class="form-check">
                                                                                    <label class="form-check-label border-bottom border-1 border-white poppins text-white fs-6 fw-300" for="ppmp<?php echo $pago['id']; ?>" style="cursor:pointer;">
                                                                                        Seleccionar
                                                                                    </label>
                                                                                    <input class="form-check-input" type="radio" name="idMetodoDePago" id="ppmp<?php echo $pago['id']; ?>" value="<?php echo $pago['idMetodoDePago']; ?>" style="cursor:pointer;" onclick="toggleBotones();" required>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                            break;

                                                                        case (!isset($pago['urlPago']) && ($pago['idMetodoDePago'] == "TRANSFER")):
                                                                        // Transferencia electrónica
                                                                            ?>
                                                                            <div class="text-center" onclick="javascript: enviaModal('<?php echo $mp; ?>'); makeCode('<?php echo $pago['clabe']; ?>');" data-bs-toggle="modal" data-bs-target="#datosBancariosTienda">
                                                                                <div class="form-check">
                                                                                    <label class="form-check-label border-bottom border-1 border-white poppins text-white fs-6 fw-300" for="transfer<?php echo $pago['id']; ?>" style="cursor:pointer;">
                                                                                    Seleccionar
                                                                                    </label>
                                                                                    <input class="form-check-input" type="radio" name="idMetodoDePago" id="transfer<?php echo $pago['id']; ?>" value="<?php echo $pago['idMetodoDePago']; ?>" onclick="toggleBotones();" style="cursor:pointer;" required>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                            break;

                                                                        case ($pago['idMetodoDePago'] == "CASH"):
                                                                        // Efectivo
                                                                            ?>
                                                                            <div class="text-center" data-bs-toggle="modal" data-bs-target="#modalCalcularCambioEfectivo">
                                                                                <div class="form-check">
                                                                                    <label class="form-check-label border-bottom border-1 border-white poppins text-white fs-6 fw-300" for="cash<?php echo $pago['id']; ?>" style="cursor:pointer;">
                                                                                    Seleccionar
                                                                                    </label>
                                                                                    <input class="form-check-input" type="radio" name="idMetodoDePago" id="cash<?php echo $pago['id']; ?>" value="<?php echo $pago['idMetodoDePago']; ?>" style="cursor:pointer;" onclick="toggleBotones();" required>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                            break;

                                                                        case ($pago['idMetodoDePago'] == "CC"):
                                                                        // Efectivo
                                                                            ?>
                                                                            <div class="text-center">
                                                                                <div class="form-check">
                                                                                    <label class="form-check-label border-bottom border-1 border-white poppins text-white fs-6 fw-300" for="cc<?php echo $pago['id']; ?>" style="cursor:pointer;">
                                                                                    Seleccionar
                                                                                    </label>
                                                                                    <input class="form-check-input" type="radio" name="idMetodoDePago" id="cc<?php echo $pago['id']; ?>" value="<?php echo $pago['idMetodoDePago']; ?>" onclick="toggleBotones();" style="cursor:pointer;" required>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                            break;

                                                                        default:
                                                                        // Default
                                                                            echo "&nbsp;";
                                                                            break;
                                                                    }
                                                                    ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php
                                                        }
                                                    }
                                                    else
                                                    {
                                                    ?>
                                                        <span class="m-2">
                                                            No hay métodos de pago registrados.
                                                            <a href="configura-pagos.php" class="fw-500">Configurar ahora</a>
                                                        </span>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>

                                            </div>
                                            <!-- Modal Confirmar Pago -->
                                            <div class="modal fade" id="modalFinalizarPedidoPDV" tabindex="-1" aria-labelledby="modalFinalizarPedidoPDVLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title text-gray-600 fw-600">
                                                                <i data-feather="user-plus" class="me-1 feather-lg"></i>
                                                                Asignar cliente
                                                            </h5>
                                                            <button type="button" class="btn btn-icon border border-1 border-gray-600 btn-sm" data-bs-dismiss="modal" aria-label="Close">
                                                                <i class="fa-solid fa-xmark fa-xl"></i>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="fw-300">Se enviará el resumen del pedido al cliente, incluso si aún no tiene una cuenta <span class="fw-600">conejón digital</span>.</p>
                                                            <div class="mb-3 text-dark">
                                                                <label for="" class="text-primary fw-600 mb-1">Correo del cliente:</label>
                                                                <input type="email" class="form-control text-center" name="idCliente" id="idCliente" placeholder="correo@ejemplo.com" value="" style="display: ;">
                                                            </div>
                                                            <div class="d-flex justify-content-end">
                                                                <label class="form-check-label me-2 fw-200" style="cursor: pointer;" for="inputAsignarCliente">No asignar cliente</label>
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" style="cursor: pointer;" type="checkbox" id="inputAsignarCliente" onchange="toggleClienteInput()">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" name="button" class="btn btn-light rounded-2 fw-500" data-bs-dismiss="modal">
                                                                Cerrar
                                                            </button>
                                                            <button type="submit" class="btn btn-success fw-500 fs-6 rounded-2" onclick="return validaFormulario_pagoPos();" name="btnCrearPedido" value="PDV">
                                                                Finalizar
                                                                <i data-feather="check-circle" class="fa-fade me-1 ms-1 feather-lg"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal Confirmar Pago -->

                                            <input type="hidden" name="idTienda" placeholder="idTienda" value="<?php echo $idTienda; ?>">

                                            <div class="d-none d-lg-flex fixed-bottom justify-content-end mb-4 me-4">
                                                <button type="button" class="btn btn-danger fw-500 fs-5 rounded-pill shadow-sm" style="display: none;" id="btnConfirmar_uno" data-bs-toggle="modal" data-bs-target="#modalFinalizarPedidoPDV">
                                                    <span class="btn btn-white btn-sm shadow-sm rounded-pill me-1">
                                                        $ <?php echo number_format($_SESSION['total'], 2); ?>
                                                    </span>
                                                    Confirmar cobro
                                                </button>
                                            </div>

                                            <div class="d-lg-none fixed-bottom d-flex justify-content-center text-center mb-4">
                                                <button type="button" class="btn btn-danger fw-500 fs-5 rounded-pill shadow-sm" style="display: none;" id="btnConfirmar_dos" data-bs-toggle="modal" data-bs-target="#modalFinalizarPedidoPDV">
                                                    <span class="btn btn-white btn-sm shadow-sm rounded-pill me-1">
                                                        $ <?php echo number_format($_SESSION['total'], 2); ?>
                                                    </span>
                                                    Confirmar cobro
                                                </button>
                                            </div>

                                            <!-- <hr class="mb-4"> -->
                                            <div class="text-end">

                                                <?php
                                                // Botón Finalizar Pedido
                                                if (isset($_SESSION[$idTienda]) && 1==1)
                                                {
                                                ?>
                                                <?php
                                                }
                                                ?>
                                            </div>

                                        </form>
                                    <?php
                                    }
                                    else
                                    {
                                    ?>
                                        <h1 class="text-center mb-3 fw-600">Tu carrito está vacío</h1>
                                        <div class="text-center">
                                            <a class="btn btn-green btn-sm rounded-pill shadow" href="pos.php?tienda=<?php echo $idTienda; ?>">
                                                <i class="fas fa-store me-1"></i> Regresar al PDV
                                            </a>
                                        </div>
                                    <?php
                                    }
                                ?>
                            </div>

                        </div>
                    </div>
                    <!-- <div class="d-flex justify-content-center align-items-center bg-danger confirmaCobro">
                        <span class="text-white fs-2 fw-600">
                            Cobrar: <?php //echo number_format($_SESSION['total'], 2); ?></span>
                        </span>
                    </div> -->
                </main>
                <?php
                    if (file_exists('src/footer.php'))
                    {
                        require 'src/footer.php';
                    }
                ?>
            </div>
        </div>

        <?php
            if (file_exists('src/modals.php'))
            {
                require 'src/modals.php';
            }
        ?>

        <script src="js/numero-a-letras.js"></script>
        <script type="text/javascript">

            // AJAX direccion sucursal o cliente
            $(document).ready(function()
            {

                $("#metodoEnvioDinamico").on('change paste keyup',function(event)
                {

                    var metodoEnvioDinamico = $("#metodoEnvioDinamico").val();
                    var idTienda = $("#idTienda").val();
                    //$("#metodoPago")[0].selectedIndex = 0;

                    document.getElementById('salidaMetodoPago').innerHTML = "";

                    if(metodoEnvioDinamico == '')
                    {
                        //alert("Please fill all fields.");
                        return false;
                    }
                    //alert(metodoEnvioDinamico);
                    // Obtenemos el metodo de pago
                    $.ajax({
                        type: "POST",
                        url: "getMetodoDePago.php",
                        data:
                        {
                            metodoEnvioDinamico: metodoEnvioDinamico,
                            idTienda: idTienda
                        },
                        cache: false,
                        success: function(data)
                        {
                            document.getElementById('salidaMetodoPago').innerHTML = data;
                        },
                        error: function(xhr, status, error)
                        {
                            console.error(xhr);
                        }
                    });

                    $.ajax({
                        type: "POST",
                        url: "buscarDireccion.php",
                        data:
                        {
                            metodoEnvioDinamico: metodoEnvioDinamico,
                            idTienda: idTienda
                        },
                        cache: false,
                        success: function(data)
                        {
                            document.getElementById('salida').innerHTML = data;


                        },
                        error: function(xhr, status, error)
                        {
                            console.error(xhr);
                        }
                    });

                    // Precio Envio
                    $.ajax({
                        type: "POST",
                        url: "buscarPrecioEnvio.php",
                        data:
                        {
                            metodoEnvioDinamico: metodoEnvioDinamico
                        },
                        cache: false,
                        success: function(data)
                        {
                            document.getElementById('salidaPrecioEnvio').innerHTML = data;
                            document.getElementById('valuePrecioEnvio').value = data;
                            //alert("axel");
                        },
                        error: function(xhr, status, error)
                        {
                            console.error(xhr);
                        }
                    });

                    $.ajax({
                        type: "POST",
                        url: "buscarTotal.php",
                        data:
                        {
                            metodoEnvioDinamico: metodoEnvioDinamico
                        },
                        cache: false,
                        success: function(data)
                        {
                            document.getElementById('precioTotal').innerHTML =  "$&nbsp" + data;
                        },
                        error: function(xhr, status, error)
                        {
                            console.error(xhr);
                        }
                    });

                });

            });

            // AJAX metodos de pago
            $(document).ready(function()
            {

                $("#metodoPago").on('change paste keyup', function(event)
                {

                    var idTienda    = $("#idTienda").val();
                    var metodoPago  = $("#metodoPago").val();
                    var metodoEnvio = $("#metodoEnvioDinamico").val();

                    document.getElementById('salidaMetodoPago').innerHTML = "";

                    if (metodoEnvio == "")
                    {
                        $("#metodoPago")[0].selectedIndex = 0;
                        alert("Debes elegir un método de envío.");
                        return false;
                    }

                    if(metodoPago == '')
                    {
                        //alert("Please fill all fields.");
                        return false;
                    }

                });
            });

            function enviaModal(data)
            {
                //var info = "banco,numerodetarjeta,clabe";
                var valores = data.split(",");
                //console.log(); // Output: ["banco", "numerodetarjeta", "clabe"]
                document.getElementById("bancoModal").value  = valores[0];

                var clabeFormateada = valores[1].replace(/\d{4}(?=\d)/g, '$& ');
                document.getElementById("clabeModal").value  = clabeFormateada;

                var tarjetaFormateada = valores[2].replace(/\d{4}(?=\d)/g, '$& ');
                document.getElementById("numeroTarjetaModal").value  = tarjetaFormateada;


                document.getElementById("idDB").value  = valores[3];
            }

            // Check if the element with id "efectivoRecibido" exists
            const efectivoRecibido = document.getElementById("efectivoRecibido");

            if (efectivoRecibido) {
                efectivoRecibido.addEventListener("input", function(event) {
                    // Rest of your code inside the event listener
                    document.getElementById('cambioEfectivo').value = 0.00;
                    document.getElementById('labelCambioEfectivoATexto').innerHTML = "";
                    // Permitir sólo 2 decimales
                    const value = event.target.value;
                    const regex = /^\d+(\.\d{0,2})?$/;

                    if (!regex.test(value) && value != "") {
                        event.target.value = value.slice(0, -1);
                    }

                    calcularCambio();
                    // Verificar si el campo efectivoRecibido ha sido borrado
                    if (value === "") {
                        document.getElementById('cambioEfectivo').value = 0.00;
                        document.getElementById('labelSolicitudEfectivo').innerHTML = "";
                        document.getElementById('labelEfectivoRecibidoATexto').innerHTML = "";
                        document.getElementById('labelCambioEfectivoATexto').innerHTML = "";
                    }
                });
            } 
            // else {
            //     console.log("Element with id 'efectivoRecibido' not found.");
            // }


            function calcularCambio()
            {
                var total = parseFloat('<?php echo $_SESSION['total']; ?>');
                var efectivoRecibido = document.getElementById('efectivoRecibido').value;
                var recibido = parseFloat(efectivoRecibido);

                if (isNaN(recibido) || recibido == "")
                {
                    return;
                }

                if (isNaN(total) || total < 0)
                {
                    alert("El total debe ser un número válido.");
                    return;
                }

                if (!/^\d*\.?\d*$/.test(efectivoRecibido))
                {
                    alert("El efectivo recibido debe ser un número válido.");
                    return;
                }

                if (recibido < 0)
                {
                    alert("El efectivo recibido debe ser un número positivo.");
                    return;
                }

                // Inicio Calcular cambio
                var cambio = (total - recibido).toFixed(2);
                cambio = Math.abs(cambio);
                cambio = cambio.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');

                if ((recibido>=total))
                {
                    //return;
                    cambioEfectivo.value = cambio;
                    // Convertir a letras el cambio
                    const cambioEfectivoLetras = numeroALetras(cambio, "PESOS");
                    const cambioEfectivoLetrasFormateada = cambioEfectivoLetras.charAt(0).toUpperCase() + cambioEfectivoLetras.slice(1).toLowerCase();
                    document.getElementById('labelCambioEfectivoATexto').innerHTML = '(' + cambioEfectivoLetrasFormateada + ')';
                }

                // Convertir a letras el efectivo Recibido
                const cantidadEnLetras = numeroALetras(efectivoRecibido, "PESOS");
                const cantidadEnLetrasFormateada = cantidadEnLetras.charAt(0).toUpperCase() + cantidadEnLetras.slice(1).toLowerCase();
                document.getElementById('labelEfectivoRecibidoATexto').innerHTML = '(' + cantidadEnLetrasFormateada + ')';

                if (recibido < total)
                {
                    document.getElementById('labelSolicitudEfectivo').innerHTML = " <span class='fw-300'>Resta: </span> " + "(<span class='fw-400'>$ " + (cambio) + "</span>)";
                }
                else
                {
                    document.getElementById('labelSolicitudEfectivo').innerHTML = "";
                }
                // Fin Calcular cambio
            }

        		var qrcode = new QRCode(document.getElementById("qrcode"),
        		{
          			width  : 150,
          			height : 150
        		});

            function makeCode(contenidoQR)
        		{
        				if (!contenidoQR)
        				{
        						alert("Input a text");
        						return;
        				}
        				qrcode.makeCode(contenidoQR);
        		}

            var qrcodeUrlPago = new QRCode(document.getElementById("qrcodeUrlPago"),
        		{
          			width  : 150,
          			height : 150
        		});

            function makeCodeUrlPago(contenidoQR, metodoPago)
        		{
        				if (!contenidoQR)
        				{
        						alert("Input a text");
        						return;
        				}
                document.getElementById('nombreMetodoPago').innerHTML = '<i class="fas fa-qrcode"></i> Pago con ' + metodoPago;
        				qrcodeUrlPago.makeCode(contenidoQR);
        		}

            function toggleClienteInput()
            {
                var checkbox = document.getElementById("inputAsignarCliente");
                var clienteInput = document.getElementById("idCliente");

                if (checkbox.checked)
                {
                    // clienteInput.style.display = "none";
                    clienteInput.removeAttribute("required");
                    clienteInput.setAttribute("disabled", "");
                }
                else
                {
                    // clienteInput.style.display = "block";
                    clienteInput.setAttribute("required", "");
                    clienteInput.removeAttribute("disabled");
                }
            }
        </script>
        <script>
        function toggleBotones()
        {
            var radios = document.getElementsByName('idMetodoDePago');
            var btnConfirmar_uno = document.getElementById('btnConfirmar_uno');
            var btnConfirmar_dos = document.getElementById('btnConfirmar_dos');

            // Iterar sobre los radios para verificar si se ha seleccionado alguno
            var algunSeleccionado = false;


            for (var i = 0; i < radios.length; i++)
            {
                if (radios[i].checked)
                {
                    algunSeleccionado = true;
                    break;
                }
            }

            // Mostrar/ocultar los botones según si se ha seleccionado un radio
            if (algunSeleccionado)
            {
                btnConfirmar_uno.style.display = 'block';
                btnConfirmar_dos.style.display = 'block';
            }
            else
            {
                btnConfirmar_uno.style.display = 'none';
                btnConfirmar_dos.style.display = 'none';
            }
        }
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <?php
            if (file_exists('src/triggers.php'))
            {
                include 'src/triggers.php';
            }
        ?>
    </body>
</html>
