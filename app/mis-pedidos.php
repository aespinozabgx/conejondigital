<?php

    session_start();

    require 'php/conexion.php'; //configuración conexión db
    require 'php/funciones.php'; //configuración conexión db

    if (isset($_SESSION['email']))
    {
        $emailUsuario = $_SESSION['email'];
    }

     
    // $tienda = getDatosTienda($conn, $managedStore);
    // $idTienda = $tienda['idTienda'];

    //$hasActivePayment  = validarPagoActivo($conn, $idTienda);
    // print_r($hasActivePayment);

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" /> -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Menú Digital</title>

        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css?id=28" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />

        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>    

        <style type="text/css">

          .imagenProducto
          {
              height: 128px;
          }

          .flotante
          {
              position:fixed;
              bottom:15px;
              right:15px;
              margin:0;
              padding:10px;
          }


          .circle
          {
              transition: 0.5s;
          }

          .circle:hover
          {
              transition: 0.5s;
              transform: scale(1.3);
          }

        </style>
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
                    require 'src/sidenav.php';
                }
            ?>
            <div id="layoutSidenav_content">
                <main>
                    <header class="page-header page-header-dark bg-success pb-10">
                        <div class="container-xl px-4">
                            <div class="page-header-content pt-4">
                                <div class="row align-items-center justify-content-between">
                                    <div class="col-auto mt-4">
                                        <h1 class="page-header-title">
                                            <div class="page-header-icon"></div>
                                            <!-- <i class="fas fa-history fa-sm text-white-50 me-2"></i> -->
                                            <i class="feather-xl text-white-75 me-2" data-feather="shopping-bag"></i>
                                            Mis pedidos
                                        </h1>
                                        <div class="page-header-subtitle text-white">Conoce el detalle de tus compras realizadas. </div>
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

                        <div id="datosBancarios"></div>
                    </header>
                    <!-- Main page content-->
                    <div class="container-xl px-4 mt-n10">
                        <div class="row">
                            <div class="col-xl-12">

                                <!-- TABLA PRODUCTOS INICIO -->
                                <div class="card card-header-actions mx-auto">
                                  <div class="card-header">
                                      Mi historial de compras
                                      <!-- <div>
                                          <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#altaProducto">
                                            <i class="fas fa-plus me-2"></i> Nuevo
                                          </button>
                                      </div> -->
                                  </div>
                                  <div class="card-body">
                                      <div class="table-responsive">
                                          <table id="datatablesSimple" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Pedido</th> 
                                                <th>Fecha Pedido</th>
                                                <th>Estatus</th>
                                                <th>Detalles</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Pedido</th> 
                                                <th>Fecha Pedido</th>
                                                <th>Estatus</th>
                                                <th>Detalles</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT
                                                        pedidos.idPedido,
                                                        pedidos.idCliente, 
                                                        pedidos.fechaPedido,
                                                        pedidos.idEstatusPedido,
                                                        CAT_estatusPedido.nombre AS estatusPedido
                                                    FROM
                                                        pedidos
                                                    INNER JOIN 
                                                        CAT_estatusPedido ON pedidos.idEstatusPedido = CAT_estatusPedido.idEstatus
                                                    WHERE
                                                        pedidos.idCliente = '$emailUsuario' 
                                                    AND pedidos.isActive = 1 
                                                    ORDER BY pedidos.idEstatusPedido, pedidos.fechaPedido ASC";

                                              $result = mysqli_query($conn, $sql);

                                              if (mysqli_num_rows($result) > 0)
                                              {

                                                  // output data of each row
                                                  while($row = mysqli_fetch_assoc($result))
                                                  {

                                                    $dominio = "2";

                                                        echo "<tr>";
                                                        echo "<td class='fw-600'>" . $row["idPedido"]      . "</td>"; 
                                                        echo "<td>" . date("d/M/Y H:i", strtotime($row["fechaPedido"])) . " hrs.</td>";
                                                        echo "<td class=''>";

                                                        if ($row["estatusPedido"] == "Entregado")
                                                        {
                                                            ?>
                                                            
                                                            <div class='btn btn-success fs-6 btn-sm rounded-pill mb-1'>
                                                                Completado <i class='fas fa-check-circle fa-lg ms-2'></i>
                                                            </div>
                                                            <?php
                                                            $calificacion = false;
                                                            //$calificacion = hasCalificacionPedido($conn, $row["idPedido"]);
                                                            // var_dump($calificacion);
                                                            if ($calificacion === false)
                                                            {
                                                            ?>
                                                            <!-- <a class='btn btn-primary rounded-pill mb-1' href='detalleCompra.php?id=<?php //echo $row['idPedido']; ?>&modal=modalCalificarPedido'>Calificar <i class='fas fa-star ms-1 text-yellow'></i></a> -->
                                                            <?php
                                                            }

                                                        }
                                                        elseif($row["estatusPedido"] == "Pedido Recibido")
                                                        {
                                                            ?>
                                                            <div class='btn btn-danger fs-6 btn-sm rounded-pill mb-1'>
                                                                <i class='fas fa-warning fa-lg me-2'></i> Pago Pendiente
                                                            </div>
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                            echo $row['estatusPedido'];
                                                        }
                                                        echo "</td>";

                                                        ?>
                                                        <td class='text-center'>
                                                            <a class="btn btn-blue rounded-pill fw-600" href="detalle-compra.php?id=<?php echo $row['idPedido']; ?>">
                                                                <i class="far fa-eye me-1"></i> Ver
                                                            </a>
                                                        </td>
                                                        <?php
                                                      echo "</tr>";
                                                  }

                                              }
                                              mysqli_close($conn);
                                            ?>
                                        </tbody>
                                    </table>
                                    </div>
                                  </div>
                              </div>
                              <!-- TABLA PRODUCTOS FIN -->

                              <!-- <div class="card card-icon my-4">
                                  <div class="row g-0">
                                      <div class="col-auto card-icon-aside bg-primary"><i class="me-1 text-white-50" data-feather="alert-triangle"></i></div>
                                      <div class="col">
                                          <div class="card-body py-5">
                                              <h5 class="card-title">Comparte</h5>
                                              <p class="card-text">Simple DataTables is a third party plugin that is used to generate the demo table above. For more information about how to use Simple DataTables with your project, please visit the official documentation.</p>
                                              <a class="btn btn-primary btn-sm" href="https://github.com/fiduswriter/Simple-DataTables" target="_blank">
                                                  <i class="me-1" data-feather="external-link"></i>
                                                  Visit Simple DataTables Docs
                                              </a>
                                          </div>
                                      </div>
                                  </div>
                              </div> -->

                          </div>
                        </div>
                    </div>
                </main>
                <?php
                    if (file_exists('src/footer.php')) { include 'src/footer.php'; }
                ?>
            </div>

            <!-- <a class="btn btn-primary btn-md btn-icon circle flotante"  data-bs-toggle="modal" data-bs-target="#altaProducto">
              <i class="fas fa-plus fa-xl"></i>
            </a> -->

        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables/datatables-simple-demo.js"></script>

        <script type="text/javascript">


         

        </script>
        <?php
            if (file_exists('src/modals.php')) { include 'src/modals.php'; }

            if (file_exists('src/triggers.php'))
            {
                include 'src/triggers.php';
            }
        ?>
    </body>
</html>
