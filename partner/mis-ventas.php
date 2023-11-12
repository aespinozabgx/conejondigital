<?php

    session_start();
    require 'php/conexion_db.php'; //configuración conexión db
    require 'php/funciones.php'; //configuración conexión db

    if (isset($_SESSION['email']))
    {
        $emailUsuario = $_SESSION['email'];
    }

    $idTienda = $_SESSION['managedStore'];
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
        <title>Ventas :: vendy</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
        <link rel="<stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.13.1/datatables.min.css"/>
        <style type="text/css">
            .totalPedido
            {
                background-color: blue;
                color: white;
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
                include 'src/sidenav.php';
              }
            ?>
            <div id="layoutSidenav_content">
                <main>
                    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-9">
                        <div class="container-xl px-4">
                            <div class="page-header-content pt-4">
                                <div class="row align-items-center justify-content-between">
                                    <div class="col-auto mt-4">
                                        <div class="display-6 text-white sombra-titulos-vendy">
                                            <i class="feather-xl me-1 text-white-50" data-feather="package"></i>
                                            Mis Ventas
                                        </div>
                                        <div class="page-header-subtitle">Conoce el detalle de tus ventas</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </header>
                    <!-- Main page content-->
                    <div class="container-xl px-4 mt-n10">
                        <div class="card mb-4">
                            <div class="card-header">Listado de ventas</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="tablaArticulosDataTable" class="table border rounded-2 table-bordered table-hover" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
                                  <thead>
                                      <tr>
                                          <th>Pedido</th>
                                          <th>Tipo Pedido</th>
                                          <th>Cliente</th>
                                          <th>Fecha Pedido</th>
                                          <!-- <th>Envío</th>
                                          <th>Precio Envío</th> -->
                                          <th>Total</th>
                                          <th>Estatus</th>
                                          <th>Detalles</th>
                                      </tr>
                                  </thead>
                                  <tfoot>
                                      <tr>
                                          <th>Pedido</th>
                                          <th>Tipo Pedido</th>
                                          <th>Cliente</th>
                                          <th>Fecha Pedido</th>
                                          <!-- <th>Envío</th>
                                          <th>Precio Envío</th> -->
                                          <th>Total</th>
                                          <th>Estatus</th>
                                          <th>Detalles</th>
                                      </tr>
                                  </tfoot>
                                  <tbody>
                                      <?php
                                        $sql = "SELECT
                                                    pedidos.*,
                                                    CAT_estatusPedido.nombre AS estatusPedido
                                                FROM
                                                    pedidos
                                                INNER JOIN CAT_estatusPedido ON pedidos.idEstatusPedido = CAT_estatusPedido.idEstatus
                                                WHERE
                                                    pedidos.idTienda = '$idTienda' AND pedidos.isActive = 1
                                                ORDER BY pedidos.fechaPedido DESC";

                                        $result = mysqli_query($conn, $sql);

                                        if (mysqli_num_rows($result) > 0)
                                        {

                                            // output data of each row
                                            while($row = mysqli_fetch_assoc($result))
                                            {

                                                echo "<tr>";

                                                  echo "<td class='fw-600 text-nowrap'>" . substr($row["idPedido"], 0)      . "</td>";

                                                  if ($row['idTipoPedido'] == "PDV")
                                                  {
                                                      echo "<td class='fw-600'> <i class='fas fa-cash-register text-gray-500'></i> PDV </td>";
                                                  }
                                                  else
                                                  {
                                                      echo "<td class='fw-600'> <i class='fas fa-store text-gray-500'></i> WEB </td>";
                                                  }

                                                  $idCliente = !empty($row["idCliente"]) ? $row["idCliente"] : "No Disponible";

                                                  echo "<td class='fw-600'>" . $idCliente . "</td>";
                                                  echo "<td><span class='fw-300'>" . date("d/m/Y · ", strtotime($row["fechaPedido"])) . "</span><span class='fw-500'>" . date("H:i", strtotime($row["fechaPedido"])) . " hrs</span></td>";
                                                  echo "<td class='text-center'> $ " . number_format($row['total'], 2) . "</td>";
                                                  ?>
                                                  <td>
                                                      <?php echo ($row["estatusPedido"] == "Entregado") ? ' <span class="btn btn-success btn-sm rounded-pill">Entregado <i class="far fa-check-circle ms-1"></i></span> ' : $row["estatusPedido"]; ?>
                                                  </td>
                                                  <?php

                                                  // echo "<td>" . $row["estatusPedido"] . "</td>";
                                                  // echo "<td>" . $row["estatusPedido"] . "</td>";
                                                  ?>
                                                  <td class='text-center'>
                                                      <a class="btn btn-primary btn-sm rounded-pill" href="detalleVenta.php?id=<?php echo $row['idPedido']; ?>">
                                                          <i class="far fa-eye me-1"></i> Ver
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
                                <script src='https://cdn.datatables.net/v/bs-3.3.6/jqc-1.12.3/jszip-2.5.0/pdfmake-0.1.18/dt-1.10.12/af-2.1.2/b-1.2.2/b-colvis-1.2.2/b-html5-1.2.2/b-print-1.2.2/cr-1.3.2/fc-3.2.2/fh-3.1.2/kt-2.1.3/r-2.1.0/rr-1.1.2/sc-1.4.2/se-1.2.0/datatables.min.js'></script>
                                <!-- <script  src="js/scriptDT.js"></script> -->
                            </div>
                        </div>
                        <!-- <div class="card card-icon mb-4">
                            <div class="row g-0">
                                <div class="col-auto card-icon-aside bg-primary"><i class="me-1 text-white-50" data-feather="alert-triangle"></i></div>
                                <div class="col">
                                    <div class="card-body py-5">
                                        <h5 class="card-title">Third-Party Documentation Available</h5>
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
                    <?php
                      if (file_exists('src/modals.php'))
                      {
                          include 'src/modals.php';
                      }
                    ?>
                </main>
                <?php
                  if (file_exists('src/footer.php'))
                  {
                      include 'src/footer.php';
                  }
                ?>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        d<script src="js/datatables/datatables-mis-articulos.js?id=28"></script>
    </body>
</html>
<?php
  if (file_exists('src/triggers.php'))
  {
    include 'src/triggers.php';
  }
?>
