<?php

    session_start();

    require 'php/conexion.php';
    require 'php/funciones.php';
    require 'php/lock.php';

    if (isset($_GET['tienda']))
    {
        $tienda = $_GET['tienda'];
            
    }

    if (isset($_SESSION['email']))
    {
        $idUsuario = $_SESSION['email'];
    }

    $totalPedido = 0;
    $totalAPagar = 0;
    $precioSinDescuento = 0;
    $requiereEnvio = 0;

    // echo "<pre>";
    // print_r($_SESSION);
    // die; 

    $registrosNoComprados = obtenerGafetesNoComprados($conn, $idUsuario);
    // echo "<pre>";
    // print_r($registrosNoComprados);
    // die;                                             
    
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" /><meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Completa tu pedido - vendy</title>
        <link href="css/styles.css?id=2828" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <style>

            /* HIDE RADIO */
            .customRadio [type=radio] 
            {                        
                opacity: 1;
                width: 25;
                height: 25;
                margin: 10px;
            }

            /* IMAGE STYLES */
            .customRadio [type=radio] + img 
            {
                cursor: pointer;
                margin: 50px 0px;
                border-radius: 5px;
            }

            /* CHECKED STYLES */
            .customRadio [type=radio]:checked + img 
            {
                outline: 2px solid #ccf;
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
                  if (file_exists('src/sidenav.php'))
                  {
                      require 'src/sidenav.php';
                  }
                ?>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <!-- Main page content-->
                    <div class="container-xl px-4 mt-4">
                        <!-- Invoice-->
                        <div class="card invoice">
                            <div class="card-header p-4 p-md-5 border-bottom-0 bg-gradient-primary-to-secondary text-white-50">
                                <div class="row justify-content-between align-items-center">
                                    <!-- <h1 class="text-white fs-100"><i data-feather="shopping-cart"></i></h1> -->
                                    <div class="mb-4 text-start">                                            
                                        <a href="disenaGafete.php" class="btn btn-outline-white shadow-sm rounded-pill">
                                            <i class="fas fa-arrow-circle-left me-2"></i>
                                            Regresar
                                        </a>                                            
                                    </div>

                                    <div class="col-12 col-lg-auto mb-2 mb-lg-0 text-center text-lg-start">

                                        <!-- Invoice branding-->
                                        <h1 class="display-8 text-white">
                                            <i class="fas fa-shipping-fast"></i>
                                            Últimos detalles
                                        </h1>
                                        <!-- <img class="invoice-brand-img rounded-circle mb-4" src="assets/img/demo/demo-logo.svg" alt="" /> -->
                                        <div class="h2 text-white-50 mb-0"> <small>Selecciona la forma de envío y tu método de pago preferido</small> </div>
                                        
                                    </div>

                                </div>
                            </div>
                            <div class="card-body p-2 p-md-5">
                                <?php

                                    // Validar si el carrito está vacio
                                    if (isset($_SESSION['carrito']))
                                    {
                                          ?>
                                          <div class="table-responsive mb-4">

                                            <?php

                                              if (isset($_SESSION['carrito']))
                                              {

                                                  $salida              = "";
                                                  $acumPrecioPagar     = 0;
                                                  $acumPrecioDescuento = 0;
                                                  $acumSinDescuento    = 0;
                                                  $acumConDescuento    = 0;
                                                  $requiereEnvio       = 0;

                                                  // echo "<pre>";
                                                  // print_r($_SESSION['carrito']);

                                                  foreach ($_SESSION['carrito'] as $arr => $value)
                                                  {
                                                     

                                                  }

                                              }

                                            ?>

                                          </div>

                                          <?php
                                    }
                                    else
                                    {
                                      ?>
                                        <h1 class="text-center mb-3 fw-600">Tu carrito está vacío</h1>
                                        <div class="text-center">
                                          <a class="btn btn-green btn-sm rounded-pill shadow" href="perfil.php?tienda=<?php echo $idTienda; ?>">
                                              <i class="fas fa-store me-1"></i> Regresar a la tienda
                                          </a>
                                        </div>
                                      <?php
                                    }
                                ?>

                                <form action="procesa.php" method="post" onsubmit="mostrarModal();">
                                    <div class="row col-lg-6 mb-3 p-3">
                                        <?php
                                        if ($requiereEnvio > 0)
                                        {
                                            // echo "<pre>";
                                            // print_r($_SESSION);
                                            ?>
                                            <!-- Cantidad de productos en el carrito -->
                                            <p class="fw-300 fs-2 border-bottom border-1 p-2 mx-2 text-indigo">
                                                <span class="fw-500">
                                                    <?php echo sizeof($registrosNoComprados); ?>
                                                </span>
                                                producto(s) en tu carrito
                                            </p>
                                            <?php
                                            if (isset($_SESSION['email']))
                                            {
                                                ?>
                                                <input type="hidden" name="idCliente" id="idCliente" value="<?php echo $_SESSION['email']; ?>">
                                                <?php
                                            }
                                            ?>
                                            

                                            <div class="">
                                                <label for="floatingSelect" class="fw-600 fs-4 mb-2 text-primary">
                                                    <i class="fas fa-truck me-1"></i>
                                                    Método de envío
                                                </label>

                                                <select class="form-select form-select-lg fw-500 fs-4 text-success shadow-none border-success border-2" id="metodoEnvioDinamico" name="metodoEnvioDinamico" required>
                                                    <option value="" class="fs-5" selected>Seleccionar</option>
                                                    <?php

                                                        // Obtengo envios del vendedor
                                                        $datos = getEnviosTienda($conn);
                                                        
                                                        // echo "<pre>";
                                                        // var_dump($datos);
                                                        // die;
                                                        if ($datos !== false)
                                                        {
                                                            foreach ($datos as $key => $value)
                                                            {
                                                                ?>
                                                                <!-- Crear cada option -->
                                                                <!-- PrecioEnvio//idTipoEnvio//idEnvio -->
                                                                <option class="fs-5" value="<?php echo $value['precioEnvio'] . ";" . $value['idTipoEnvio'] . ";" . $value['idEnvio']; ?>">
                                                                <?php
                                                                    if ($value['precioEnvio'] == 0)
                                                                    {
                                                                        echo $value['nombreEnvio'] . " (GRATIS)";
                                                                    }
                                                                    else
                                                                    {
                                                                        //echo $value['nombreEnvio'] . " - $ " . number_format($value['precioEnvio'], 2);
                                                                        echo $value['nombreEnvio'];
                                                                    }
                                                                ?>
                                                                </option>
                                                                <!-- Fin crear  cada option -->
                                                                <?php
                                                            }
                                                        }

                                                         
                                                    ?>
                                                </select>
                                            </div>
                                            
                                            
                                            
                                            <?php
                                        }
                                        elseif ($requiereEnvio == 0 && isset($_SESSION['carrito']))
                                        {
                                            ?>
                                            <!-- Cantidad de productos en el carrito -->
                                            <p class="fw-300 fs-2 border-bottom border-1 p-2 mx-2 text-indigo">
                                                <span class="fw-00">
                                                    <?php echo sizeof($registrosNoComprados); ?>
                                                </span>
                                                producto(s) en tu carrito
                                            </p>
                                             
                                            <div for="floatingSelect" class="fw-600 fs-4 mb-3 text-primary">
                                                <i class="fas fa-people-carry me-2"></i>
                                                Método de envío
                                            </div>
                                            <div class="px-4">
                                                <input type="radio" id="radioC" checked> 
                                                <label for="radioC"> Recibirás tu pedido el día del evento al hacer check in.</label>
                                            </div>
                                            
                                            <?php
                                        }
                                        ?>
                                    </div>

                                    
                                    <div class="row">
                                        <div class="form-floating">
                                            <!-- Inicio Direcciones -->
                                            <div class="row" id="salidaPrecio" class=""></div>
                                            <div class="row m-1" id="salida"></div>
                                            <!-- Fin Direcciones -->
                                        </div>
                                    </div>

                                    <div class="px-3">
                                        <div for="floatingSelect" class="fw-600 fs-4 mb-3 text-primary"><i class="fas fa-credit-card me-2"></i> Método de pago</div>
                                        <div class="row mt-2">

                                            <div class="col-xl-6 mb-4">
                                                <!-- Dashboard example card 1-->
                                                <a class="card lift shadow-none h-100 border-3 code-block" href="#!">
                                                    <label for="transferenciaBancaria" style="cursor: pointer;">
                                                        <div class="card-body d-flex justify-content-center flex-column">                                                        
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="me-3">
                                                                    
                                                                    <i class="feather-xl text-primary mb-3" data-feather="credit-card"></i>
                                                                    <h5>Transferencia bancaria</h5>
                                                                    <div class="text-muted small ">                                                                         
                                                                        <input class="form-check-input" type="radio" name="metodoPago" value="transferenciaBancaria" id="transferenciaBancaria" required>
                                                                    </div>
                                                                    
                                                                </div>
                                                                <img src="transferencia.jpg" class="rounded-3" alt="..." style="width: 8rem" />
                                                            </div>                                                        
                                                        </div>
                                                    </label>
                                                </a>
                                            </div>                                             

                                            <div class="col-xl-6 mb-4">
                                                <!-- Dashboard example card 1-->
                                                <a class="card lift shadow-none h-100 border-3 code-block" href="#!">
                                                    <label for="spinOxxo" style="cursor: pointer;">
                                                        <div class="card-body d-flex justify-content-center flex-column">                                                        
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="me-3">
                                                                                                                                        
                                                                    <i class="fas fa-money-bill-wave fa-xl text-primary mb-3"></i>
                                                                    <h5>Efectivo en OXXO</h5>
                                                                    <div class="text-muted small">                                                                         
                                                                        <input class="form-check-input" type="radio" name="metodoPago" value="spinOxxo" id="spinOxxo">
                                                                    </div>
                                                                    
                                                                </div>
                                                                <img src="oxxo.png" class="rounded-3" alt="..." style="width: 8rem" />
                                                            </div>                                                        
                                                        </div>
                                                    </label>
                                                </a>
                                            </div>
                                            
                                        </div>
                                    </div>

                                    <div class="row"></div>

                                    <div class="table-responsive mb-4 border-bottom">
                                        <table class="table table-borderless  ">
                                            <thead class="border-bottom">
                                                <tr class="small text-uppercase text-muted"></tr>
                                            </thead>
                                            <tbody>

                                                <!-- Invoice item 1-->
                                                <?php
                                                if (isset($_SESSION['carrito']))
                                                {
                                                    $salida = "";
                                                    $acumPrecioPagar = 0;
                                                    $acumPrecioDescuento = 0;
                                                    $acumSinDescuento = 0;
                                                    $acumConDescuento = 0;
                                                    ?>

                                                    <!-- Subtotal -->
                                                    <tr>
                                                        <td class="text-end pb-0" colspan="3"><div class="text-uppercase small fw-700 text-muted">Subtotal:</div></td>
                                                        <td class="text-end pb-0">
                                                            <div class="fs-3 mb-0 fw-700" id="salidaSubtotal">
                                                                <?php
                                                                    echo "$&nbsp;" . number_format($_SESSION['carrito']['subtotal'], 2);
                                                                ?>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!-- Descuentos -->
                                                    <tr>
                                                        <td class="text-end pb-0" colspan="3"><div class="text-uppercase small fw-700 text-muted">Descuentos:</div></td>
                                                        <td class="text-end pb-0">
                                                            <div class="fs-3 mb-0 fw-600 text-danger" id="salidaDescuento">
                                                                <?php
                                                                    echo "- $&nbsp;" . number_format($_SESSION['carrito']['descuentos'], 2) . "";
                                                                ?>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!-- ENVÍO -->
                                                    <tr>
                                                        <td class="text-end pb-0" colspan="3"><div class="text-uppercase small fw-700 text-muted">Envío:</div></td>
                                                        <td class="text-end pb-0">
                                                            <div class="fs-4 mb-0 fw-700">
                                                                <span id="salidaPrecioEnvio">
                                                                    $ <?php echo number_format("0", 2); ?>
                                                                </span>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!-- TOTAL -->
                                                    <tr>
                                                        <td class="text-end pb-0" colspan="3">
                                                            <div class="text-uppercase small fw-700 fs-3 text-muted">Total a pagar:</div>
                                                        </td>
                                                        <td class="text-end pb-0">
                                                            <!-- El id #precioTotal muestra por defecto la variable de sesion 'total', se actualiza por AJAX tomando el valor de la variable local $total -->
                                                            <div class="h5 mb-0 fw-700 fs-1 text-green" id="precioTotal">
                                                                <span class="fw-300 fs-6 text-green">
                                                                    $
                                                                </span>
                                                                <span class="fw-500 fs-1 text-green">
                                                                    <?php echo number_format($_SESSION['carrito']['total'], 2); ?>
                                                                </span>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="mt-5 text-end ">

                                        <?php
                                        if (isset($_SESSION['carrito']))
                                        {

                                            echo '<p class="fw-300 small me-1 m-4">Recibirás los métodos de pago en tu correo electrónico y también podrás consultarlos en el detalle del pedido.</p>';
                                            ?>
                                            <button type="submit" class="btn btn-success fw-600 fs-6 rounded-pill mb-4 me-1" name="btnCrearPedido" value="">
                                                Enviar pedido
                                                <i data-feather="check-circle" class="fa-fade ms-2 feather-lg"></i>
                                            </button>
                                            <?php
                                            
                                        }
                                        ?>
                                    </div>

                                </form>
                                <?php
                                // echo "<pre>";
                                // print_r($_SESSION);
                                ?>
                            </div>
                            <?php
                                // echo "<pre>";
                                // print_r($_SESSION);
                            ?>
                        </div>
                    </div>
                </main>
                <?php
                if (file_exists('app/src/footer.php'))
                {
                    require 'app/src/footer.php';
                }
                ?>
            </div>
        </div>

        <!-- iniciar modalCreandoPedido -->
        <div class="modal fade" id="modalCreandoPedido" tabindex="-1" aria-labelledby="modalCreandoPedidoLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered rounded-2">
                <div class="modal-content bg-ama">
                    <div class="modal-body bg-pattern-ama rounded-2">

                        <div class="d-flex justify-content-center mb-5 mt-4">
                          <div class="spinner"></div>

                          <style>
                              .spinner {
                                 position: relative;
                                 width: 20.4px;
                                 height: 20.4px;
                              }

                              .spinner::before,
                              .spinner::after {
                                 content: '';
                                 width: 100%;
                                 height: 100%;
                                 display: block;
                                 animation: spinner-b4c8mmmd 0.5s backwards, spinner-49opz7md 1.25s 0.5s infinite ease;
                                 border: 5.6px solid #2d4271;
                                 border-radius: 50%;
                                 box-shadow: 0 -33.6px 0 -5.6px #2d4271;
                                 position: absolute;
                              }

                              .spinner::after {
                                 animation-delay: 0s, 1.25s;
                              }

                              @keyframes spinner-b4c8mmmd {
                                 from {
                                    box-shadow: 0 0 0 -5.6px #ffffff;
                                 }
                              }

                              @keyframes spinner-49opz7md {
                             to {
                                transform: rotate(360deg);
                             }
                          }
                          </style>
                        </div>
                        <div class="mb-2 text-dark text-center fs-1 font-poppins fw-300">
                            Estamos creando tu pedido...
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <!-- iniciar modalCreandoPedido -->

        <?php
            require 'src/modals.php';
        ?>

        <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
        <script type="text/javascript">
            
            function updateTotal()
            {
                // Buscar Total
                $.ajax({
                        type: "POST",
                        url: "ajax/buscarTotal.php",
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
            }


            // AJAX direccion sucursal o cliente
            $(document).ready(function()
            {

                $("#metodoEnvioDinamico").on('change paste keyup',function(event)
                {
                    
                    var metodoEnvioDinamico = $("#metodoEnvioDinamico").val();
                    
                    //var idTienda = $("#idTienda").val();
                    //$("#metodoPago")[0].selectedIndex = 0;
                                  

                    $.ajax({
                        type: "POST",
                        url: "ajax/buscarDireccion.php",
                        data:
                        {
                            metodoEnvioDinamico: metodoEnvioDinamico,
                         
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


                    // Obtener Precio Envio
                    $.ajax({
                        type: "POST",
                        url: "ajax/buscarPrecioEnvio.php",
                        data:
                        {
                            metodoEnvioDinamico: metodoEnvioDinamico
                        },
                        cache: false,
                        success: function(data)
                        {
                            //console.log(data);
                            if (data == 0)
                            {
                                document.getElementById('salidaPrecioEnvio').innerHTML = "GRATIS";
                            }
                            else
                            {
                                document.getElementById('salidaPrecioEnvio').innerHTML = "$ " + data;
                            }
                            
                            //document.getElementById('valuePrecioEnvio').value = data;
                            
                        },
                        error: function(xhr, status, error)
                        {
                            console.error(xhr);
                        }
                    });

                    var creditosPorUsar = $("#creditosPorUsar").val(); // Obtén el valor del input

                    // Buscar Total
                    $.ajax({
                        type: "POST",
                        url: "ajax/buscarTotal.php",
                        data: 
                        {
                            metodoEnvioDinamico: metodoEnvioDinamico,
                            creditosPorUsar: creditosPorUsar
                        },
                        cache: false,
                        success: function(data) 
                        {
                            const jsonData = JSON.parse(data);
                            const precioTotalElement = document.getElementById('precioTotal');
                            console.log(jsonData.total);
                            precioTotalElement.innerHTML = "$&nbsp" + jsonData.total;
                            
                            // Utiliza jQuery para establecer el valor del input
                            $("#creditosPorUsar").val(jsonData.creditosAUsar);

                            if (parseFloat(jsonData.total) < 0) 
                            {
                                
                            } 
                            else 
                            {
                                //alert("Se utilizará(n) " + jsonData.creditosAUsar + " crédito(s)");
                            }
                        },
                        error: function(xhr, status, error)
                        {
                            console.error(xhr);
                        }
                    }); 

                });

            });

            // Valida créditos usados y recalcula total
            $(document).ready(function() {
                // Valida créditos usados y recalcula total
                $("#creditosPorUsar").on('change paste keyup', function(event) {
                    var creditosPorUsar = $(this).val();

                    // Debes definir la variable metodoEnvioDinamico antes de usarla en la solicitud AJAX
                    var metodoEnvioDinamico = $("#metodoEnvioDinamico").val(); // Supongo que obtienes el valor del select

                    // Buscar Total
                    $.ajax({
                        type: "POST",
                        url: "ajax/buscarTotal.php",
                        data: {
                            metodoEnvioDinamico: metodoEnvioDinamico,
                            creditosPorUsar: creditosPorUsar
                        },
                        cache: false,
                        success: function(data) 
                        {

                            const jsonData = JSON.parse(data);                                                        
                            
                            document.getElementById('salidaSubtotal').innerHTML  = "$&nbsp" + jsonData.subtotal;
                            document.getElementById('precioTotal').innerHTML     = "$&nbsp" + jsonData.total;
                            document.getElementById('salidaDescuento').innerHTML = "- $&nbsp" + jsonData.descuento;
                            
                            // Utiliza jQuery para establecer el valor del input creditosPorUsar
                            $("#creditosPorUsar").val(jsonData.creditosAUsar);

                        },
                        error: function(xhr, status, error) 
                        {
                            console.error(xhr);
                        }
                    });
                }); // Cierra el evento .on()
            });



            // Detecta movimientos en metodoPago: AJAX metodos de pago
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

            // Detectar movimiento en los créditos
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
 
            // Leer radio 
            document.addEventListener('DOMContentLoaded', function() 
            {
                const codeBlocks = document.querySelectorAll('.code-block');

                codeBlocks.forEach(block => 
                {
                    block.addEventListener('click', () => 
                    {
                        codeBlocks.forEach(b => b.classList.remove('selected'));
                        block.classList.add('selected');
                    });
                });
            });

        
            document.addEventListener("DOMContentLoaded", function() 
            {
                //const btnRestarCredito = document.getElementById("btnRestarCredito");
                const btnSumarCredito = document.getElementById("btnSumarCredito");
                const creditosPorUsarInput = document.getElementById("creditosPorUsar");

                const maxCreditos = <?php echo $datosUsuario['creditos']; ?>;

                function realizarOperacion(operacion) 
                {
                    const valor = parseInt(creditosPorUsarInput.value) || 0;

                    if (operacion === "sumar") {
                        const nuevoCredito = Math.min(valor + 1, maxCreditos);
                        creditosPorUsarInput.value = nuevoCredito;
                    } else if (operacion === "restar") {
                        const nuevoCredito = Math.max(valor - 1, 0);
                        creditosPorUsarInput.value = nuevoCredito;
                    }
                }

                // btnRestarCredito.addEventListener("click", function() {
                //     realizarOperacion("restar");
                // });

                btnSumarCredito.addEventListener("click", function() {
                    realizarOperacion("sumar");
                });

                
            });


            
            function mostrarModal()
            {
                // Swal.fire({
                //   title: 'Estamos creando tu pedido',
                //   html: 'Por favor, espera...',
                //   allowOutsideClick: false,
                //   didOpen: () => {
                //     Swal.showLoading();
                //     // document.getElementById('formulario').submit(); // Enviar formulario
                //   }
                // });
                $('#modalCreandoPedido').modal('show');
            }

        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>        
    </body>
   

</html>
<?php
  if (file_exists('src/triggers.php'))
  {
      include 'src/triggers.php';
  }
?>
