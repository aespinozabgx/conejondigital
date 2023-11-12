<?php

  session_start();
  require 'php/conexion_db.php';
  require 'php/funciones.php';

  $limiteCalificacion = 3.3;
  if (isset($_SESSION['email'], $_SESSION['managedStore']))
  {
      $email    = $_SESSION['email'];
      $idTienda = $_SESSION['managedStore'];
  }

  $tienda = getDatosTienda($conn, $idTienda);

  if ($tienda !== false)
  {
      $reputacion = getReputacionTienda($conn, $tienda);
  }

  $pedidos = getPedidosCalificados($conn, $idTienda);
  $hasActivePayment = validarPagoActivo($conn, $idTienda);

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Reputación - vendy.mx</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
        <script src="js/funciones.js?id=11"></script>
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="nav-fixed">

        <?php
        // Header
          if (file_exists('src/header.php'))
          {
            include 'src/header.php';
          }
        ?>

        <div id="layoutSidenav">
            <?php
              // Menú (sidenav)
              if (file_exists('src/sidenav.php'))
              {
                include 'src/sidenav.php';
              }
            ?>
            <div id="layoutSidenav_content">
                <main>

                    <!-- Main page content-->
                    <header class="page-header page-header-dark bg-indigo pb-10">
                        <div class="container-xl px-4">
                            <div class="page-header-content pt-4">
                                <div class="row align-items-center justify-content-between">
                                    <div class="col-auto mt-4">
                                        <h1 class="page-header-title">
                                            <div class="page-header-icon"></div>
                                            Reputación
                                        </h1>
                                        <div class="page-header-subtitle">Asegurate de brindar un buen servicio para que tus calificaciones aumenten y más clientes confíen en ti</div>
                                    </div>
                                    <!-- <div class="col-12 col-xl-auto mt-4">
                                        <div class="input-group input-group-joined border-0" style="width: 16.5rem">
                                            <span class="input-group-text"><i class="text-primary" data-feather="calendar"></i></span>
                                            <input class="form-control ps-0 pointer" id="litepickerRangePlugin" placeholder="Select date range..." />
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </header>
                    <div class="container-xl px-4 mt-n10">
                        <!-- Custom page header alternative example-->

                        <!-- Illustration dashboard card example-->
                        <div class="row">

                            <div class="col-lg-3 mb-4">

                                <!-- Progress card example-->
                                <?php
                                if (isset($reputacion['calificacion']) && $reputacion['calificacion'] > $limiteCalificacion && $reputacion === false)
                                {
                                    echo '<div class="card bg-red border-0 mb-4">';
                                }
                                else
                                {
                                    echo '<div class="card bg-blue border-0 mb-4">';
                                }
                                ?>

                                    <div class="card-body">
                                        <!-- <h5 class="text-white">Budget Overview</h5> -->

                                        <div class="mb-2 text-center">
                                            <div class="row d-flex justify-content-center">
                                                <div class="display-4 text-white">
                                                  <?php
                                                    if ($reputacion === false)
                                                    {
                                                        echo "0";
                                                    }
                                                    else
                                                    {
                                                        echo number_format($reputacion['calificacion'], 2);
                                                    }

                                                  ?>
                                                  <i class="fas fa-star text-white h3 ms-1"></i>
                                                </div>

                                            </div>
                                            <p class="text-white-50">Calificación promedio</p>
                                        </div>
                                        <hr class="bg-white">
                                        <div class=" text-white text-center">
                                            <?php

                                                if ($reputacion === false)
                                                {
                                                    echo "Aún no hay calificaciones";
                                                }
                                                else
                                                {
                                                    echo $reputacion['conteoPedidos'] . " Reseñas de tus clientes";
                                                }

                                            ?>
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <div class="col-lg-9 mb-4">
                                <!-- Area chart example-->
                                <div class="card mb-4">
                                    <div class="card-header">Pedidos calificados</div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="datatablesSimple">
                                            <thead>
                                                <tr>
                                                    <th>Num. Pedido</th>
                                                    <th>Calificación</th>
                                                    <th>Fecha Pedido</th>
                                                    <th>Correo Cliente</th>
                                                    <th>Comentario</th>
                                                    <th>Detalle</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Num. Pedido</th>
                                                    <th>Calificación</th>
                                                    <th>Fecha Pedido</th>
                                                    <th>Correo Cliente</th>
                                                    <th>Comentario</th>
                                                    <th>Detalle</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>


                                              <?php
                                                // echo "<pre>";
                                                // print_r($conn);

                                                // echo "<pre>";
                                                // var_dump($pedidos);
                                                // die;

                                                if ($pedidos !== false)
                                                {
                                                    foreach ($pedidos as $key => $pedido)
                                                    {
                                                    echo "<tr>";
                                                    echo "<td>" . $pedido['idPedido']      . "</td>";
                                                    ?>
                                                    <td>
                                                    <?php
                                                        if ($pedido['calificacion'] < $limiteCalificacion)
                                                        {
                                                            ?>
                                                            <span class='btn btn-danger btn-sm rounded-pill'> <?php echo $pedido['calificacion']; ?> </span>
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                            <span class='btn btn-green btn-sm rounded-pill'> <?php echo $pedido['calificacion']; ?> </span>
                                                            <?php
                                                        }
                                                    ?>
                                                    </td>
                                                    <?php

                                                    echo "<td>" . date("d/M/Y", strtotime($pedido['fechaPedido'])) . "</td>";
                                                    echo "<td>" . $pedido['idCliente'] . "</td>";

                                                    $cadena = trim($pedido['comentario']);
                                                    if (strlen($cadena) > 33)
                                                    {
                                                        $cadena = '"' . substr($cadena, 0, 30) . '"' . '...';
                                                    }
                                                    else
                                                    {
                                                        $cadena = '"' . $cadena . '"';
                                                    }

                                                    echo "<td class='small'>" . $cadena . "</td>";
                                                    ?>
                                                    <td>
                                                        <a class="btn btn-primary-soft btn-sm rounded-pill" href="detalleVenta.php?id=<?php echo $pedido['idPedido']; ?>">
                                                            <i data-feather="eye" class="me-1"></i> Ver pedido
                                                        </a>
                                                    </td>
                                                    <?php
                                                    echo "</tr>";
                                                }
                                                }
                                              ?>

                                            </tbody>
                                        </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <?php
                  if (file_exists('src/footer.php'))
                  {
                    include 'src/footer.php';
                  }
                ?>
            </div>
        </div>
        <script type="text/javascript">



        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables/datatables-simple-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
        <script src="js/litepicker.js"></script>
    </body>
</html>
