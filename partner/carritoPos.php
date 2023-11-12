<?php
    session_start();

    require 'php/conexion_db.php';
    require 'php/funciones.php';

    if (isset($_SESSION['managedStore']))
    {
        $tienda = $_SESSION['managedStore'];
        $tienda = getDatosTienda($conn, $tienda); // $tienda recibe el idOwner y username(tienda)
        $idTienda = $tienda['idTienda'];
        $idOwner  = $tienda['administradoPor'];

        // echo "<pre>";
        // var_dump($tienda);
        // die;

        if ($tienda === false)
        {
            die("Tienda no encontrada");
        }
    }

    $hasActivePayment = validarPagoActivo($conn, $idTienda);
    
    $totalPedido = 0;
    $totalAPagar = 0;
    $precioSinDescuento = 0;


    //  TOTALES A SESION
    $_SESSION['subtotal']  = 0;
    $_SESSION['descuento'] = 0;
    $_SESSION['total']     = 0;
    $_SESSION['precioEnvio'] = 0;

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Carrito - vendy</title>
        <link href="css/styles.css?id=2" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="nav-fixed">
    <!-- <body class="nav-fixed sidenav-toggled"> -->
        <?php
            if (file_exists('src/header.php'))
            {
                include 'src/header.php';
            }
        ?>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <?php
                  // Menú (sidenav)
                  if (file_exists('src/sidenav-dark.php'))
                  {
                      include 'src/sidenav-dark.php';
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
                                    <div class="col-12 col-lg-auto mb-2 mb-lg-0 text-center text-lg-start">

                                        <!-- Invoice branding-->
                                        <div class="display-6 text-white">
                                            <i data-feather="shopping-cart" class="feather-xl text-white me-1"></i>
                                            Carrito PDV
                                        </div>
                                        <!-- <img class="invoice-brand-img rounded-circle mb-4" src="assets/img/demo/demo-logo.svg" alt="" /> -->
                                        <div class="fs-3 text-white-50 mb-0">Revisa los productos</div>

                                    </div>
                                    <div class="col-12 col-lg-auto text-center text-lg-end">
                                        <div class="h2 mt-2">
                                            <!-- <form action="procesa.php" method="post">
                                                <input type="hidden" name="idTienda" value="<?php //echo $idTienda; ?>">
                                                <button type="submit" class="btn btn-danger btn-sm rounded-2 lift" name="btnEliminaCarrito" value="carritoPos.php">Eliminar Carrito</button>
                                            </form> -->
                                            <a href="pos.php?tienda=<?php echo $idTienda; ?>" class="btn btn-outline-white rounded-pill shadow-sm fw-500 fs-6">
                                                <i class="fas fa-arrow-circle-left me-1"></i>
                                                Volver al PDV
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card-body p-4 p-md-5">
                                <!-- Invoice table-->
                                <?php
                                // echo "<pre>";
                                // print_r($_SESSION[$idTienda]);
                                // die;
                                //  Validar si el carrito está vacio
                                // Ocultar tabla
                                    if (isset($_SESSION[$idTienda]))
                                    {
                                          ?>
                                          <div class="table-responsive mb-4">
                                              <table class="table table-borderless">
                                                  <thead class="border-bottom">
                                                      <tr class="small text-uppercase text-muted">
                                                          <th scope="col">Descripcion</th>
                                                          <th class="text-end" scope="col">Cantidad</th>
                                                          <th class="text-end" scope="col">Precio Unitario</th>
                                                          <th class="text-end" scope="col">Total</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>

                                                      <?php

                                                          $salida = "";
                                                          $acumPrecioPagar = 0;
                                                          $acumPrecioDescuento = 0;
                                                          $acumSinDescuento = 0;
                                                          $acumConDescuento = 0;
                                                          $descuento = 0;

                                                          // echo "<pre>";
                                                          // print_r($_SESSION[$idTienda]);
                                                          // die;


                                                          foreach ($_SESSION[$idTienda] as $index => $value)
                                                          {

                                                              $idProducto = $_SESSION[$idTienda][$index]['idProducto'];
                                                              $idOwner    = $_SESSION[$idTienda][$index]['idTienda'];
                                                              $unidadVentaCarrito = $_SESSION[$idTienda][$index]['unidadVenta'] === 'Kilogramos' ? 'Kgs.' : 'Pzs.';

                                                              // Datos del producto de la BDD
                                                              $datosProducto = buscarProducto($conn, $idProducto, $idOwner);

                                                              $precioProducto = $datosProducto['precio'];
                                                              $cantidadProducto = $_SESSION[$idTienda][$index]['stock'];
                                                              //$precioOferta = $datosProducto['precioOferta'];



                                                              // INICIO ACUMULADO PARA TOTAL
                                                              //$_SESSION['total'] += $cantidadProducto * $precioProducto;
                                                              // FIN ACUMULADO PARA TOTAL


                                                              //  TOTALES A SESION
                                                              $_SESSION['subtotal']  += $precioProducto * $cantidadProducto;
                                                              $_SESSION['descuento'] += $descuento;
                                                              // AXEL

                                                              ?>
                                                              <tr class="border-bottom">
                                                                  <!-- Mostrar datos del producto -->
                                                                  <td>
                                                                      <div class="fw-bold">
                                                                          <a class="poppins-font" target="_self" href="detalle-producto-pos.php?tienda=<?php echo $idTienda; ?>&idProducto=<?php echo $datosProducto['idProducto']; ?>"><?php echo $datosProducto['nombre']; ?></a>
                                                                      </div>
                                                                      <!-- <div class="small text-muted d-none d-md-block">
                                                                          <?php //echo $datosProducto['descripcion']; ?>
                                                                      </div> -->
                                                                  </td>

                                                                  <!-- Cantidad -->
                                                                  <td class="text-end fw-bold">
                                                                      <span class='text-dark fw-600'><?php echo $cantidadProducto; ?></span>
                                                                      <span class='text-dark fw-300 small'><?php echo $unidadVentaCarrito; ?></span>
                                                                  </td>

                                                                  <!-- Precio Unitario -->
                                                                  <td class="text-end fw-bold">
                                                                      <span class="fw-300">$</span>
                                                                      <span class="fw-600"><?php echo number_format($precioProducto, 2); ?></span>
                                                                  </td>

                                                                  <!-- Precio Total item -->
                                                                  <td class="text-end fw-bold">
                                                                      <span class="fw-300">$</span>
                                                                      <span class="fw-600"><?php echo number_format($precioProducto * $cantidadProducto, 2); ?></span>
                                                                  </td>

                                                              </tr>
                                                              <?php
                                                          }
                                                          $_SESSION['total'] = $_SESSION['subtotal'] - $_SESSION['descuento'];
                                                      ?>
                                                      <!-- Invoice subtotal-->
                                                      <tr>
                                                          <td class="text-end pb-0" colspan="3"><div class="text-uppercase small fw-700 text-muted">Subtotal:</div></td>
                                                          <td class="text-end pb-0">

                                                              <div class="h5 mb-0 fw-700">
                                                                  <span class="fw-300">$ </span>
                                                                  <span class="fw-600"><?php echo number_format($_SESSION['subtotal'], 2); ?></span>
                                                              </div>

                                                          </td>
                                                      </tr>

                                                      <!-- Invoice Descuentos -->
                                                      <tr>
                                                          <td class="text-end pb-0" colspan="3"><div class="text-uppercase small fw-700 text-muted">Descuentos:</div></td>
                                                          <td class="text-end pb-0">
                                                              <div class="h5 mb-0 fw-700 text-danger">
                                                                  <span class="fw-300">- $ </span>
                                                                  <span class="fw-600 text-decoration-line-through"><?php echo number_format(($descuento), 2); ?></span>
                                                              </div>
                                                          </td>
                                                      </tr>

                                                      <!-- Invoice total-->
                                                      <tr>
                                                          <td class="text-end pb-0" colspan="3">
                                                              <div class="text-uppercase fw-700 fs-2 text-muted">Total:</div>
                                                          </td>
                                                          <td class="text-end pb-0">
                                                              <div class="fs-2 mb-0 fw-700 text-dark">
                                                                  <span class="fw-300">$ </span>
                                                                  <span class="fw-600"><?php echo number_format($_SESSION['total'], 2); ?></span>
                                                              </div>
                                                          </td>
                                                      </tr>

                                                  </tbody>
                                              </table>
                                          </div>


                                          <div class="text-end mb-4">
                                              <?php
                                                  // Validar si requiere envio
                                                  $requiereEnvio = false;
                                                  foreach ($_SESSION[$idTienda] as $index => $value)
                                                  {

                                                      $idProducto = $_SESSION[$idTienda][$index]['idProducto'];
                                                      $idUsuario  = $_SESSION[$idTienda][$index]['idTienda'];

                                                      if (($_SESSION[$idTienda][$index]['requiereEnvio']+0) == 1)
                                                      {
                                                          //echo "Suma<br>";
                                                          $requiereEnvio = true;
                                                      }
                                                  }


                                                  if (isset($_SESSION['email']))
                                                  {
                                                      if ($requiereEnvio === true)
                                                      {
                                                          ?>
                                                          <a href="pago-pos.php?tienda=<?php echo $idTienda; ?>" class="btn btn-success rounded-pill shadow-sm fw-500 fs-6 poppins-font" name="button">
                                                              Continuar
                                                              <i data-feather="arrow-right" class="feather-lg ms-2"></i>
                                                              <!-- <i class="fas fa-arrow-right ms-1"></i> -->
                                                          </a>
                                                          <?php
                                                      }
                                                      else
                                                      {
                                                          ?>
                                                          <span class="small text-gray-500 me-2">Este pedido no requiere envío</span>
                                                          <a href="pago-pos.php?tienda=<?php echo $idTienda; ?>" class="btn btn-success rounded-pill shadow-sm fw-500 fs-6 poppins-font" name="button">
                                                              Continuar
                                                              <i data-feather="arrow-right" class="feather-lg ms-2"></i>
                                                              <!-- <i class="fas fa-arrow-right ms-1"></i> -->
                                                          </a>
                                                          <?php
                                                      }
                                                  }
                                                  else
                                                  {
                                                      ?>
                                                      Debes <a href="index.php?redirect=carrito.php&tienda=<?php echo $idTienda; ?>" class="btn btn-outline-primary btn-sm">Iniciar sesión</a> para continuar
                                                      <?php
                                                  }
                                              ?>
                                          </div>
                                          <?php
                                    }
                                    else
                                    {
                                      ?>
                                        <h1 class="text-center mb-3 fw-600">El carrito está vacío</h1>
                                        <div class="text-center">
                                          <a class="btn btn-green rounded-pill shadow-sm fw-600 fs-6" href="pos.php?tienda=<?php echo $idTienda; ?>">
                                              <i class="fas fa-cash-register me-1"></i> Volver al PDV
                                          </a>
                                        </div>
                                      <?php
                                    }
                                ?>
                            </div>
                            <!-- <div class="card-footer p-4 p-lg-5 border-top-0">
                                <div class="row">
                                    <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">

                                        <div class="small text-muted text-uppercase fw-700 mb-2">To</div>
                                        <div class="h6 mb-1">Company Name</div>
                                        <div class="small">1234 Company Dr.</div>
                                        <div class="small">Yorktown, MA 39201</div>
                                    </div>
                                    <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">

                                        <div class="small text-muted text-uppercase fw-700 mb-2">From</div>
                                        <div class="h6 mb-0">Start Bootstrap</div>
                                        <div class="small">5678 Company Rd.</div>
                                        <div class="small">Yorktown, MA 39201</div>
                                    </div>
                                    <div class="col-lg-6">

                                        <div class="small text-muted text-uppercase fw-700 mb-2">Note</div>
                                        <div class="small mb-0">Payment is due 15 days after receipt of this invoice. Please make checks or money orders out to Company Name, and include the invoice number in the memo. We appreciate your business, and hope to be working with you again very soon!</div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </main>
                <?php
                    if (file_exists('src/footer.php'))
                    {
                        require 'src/footer.php';
                    }
                ?>
            </div>
        </div>

        <script type="text/javascript">

            function siguiente(id)
            {
                var wizardTab = 'wizard' + id + '-tab';
                var wizard    = 'wizard' + id;

                var elemento = document.getElementById(wizard);
                elemento.classList.remove("active");
                elemento.classList.remove("show");

                var elemento = document.getElementById(wizardTab);
                elemento.classList.remove("active");
                elemento.classList.remove("show");

                var elemento2 = document.getElementById(wizardTab);

                elemento2.classList.add("active");
                elemento2.classList.add("show");

                var elemento2 = document.getElementById(wizard);

                elemento2.classList.add("active");
                elemento2.classList.add("show");

            }

        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
