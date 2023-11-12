<?php
    session_start();
    require 'php/conexion_db.php'; //configuración conexión db
    require 'php/funciones.php'; //configuración conexión db

    if (isset($_SESSION['email']))
    {
        $emailUsuario = $_SESSION['email'];
    }
    if (isset($_SESSION['email'], $_SESSION['managedStore']))
    {
        $email    = $_SESSION['email'];
        $idTienda = $_SESSION['managedStore'];
    }
    
    $idUsuario = $emailUsuario;
    $direccionesCliente = getDireccionesCliente($conn, $idUsuario);

    $hasActivePayment = validarPagoActivo($conn, $idTienda);
    // $managedStore = $_SESSION['managedStore'];
    // $tienda = getDatosTienda($conn, $managedStore);
    // $idTienda = $tienda['idTienda'];

    // echo "<pre>";
    // print_r($direccionesCliente);
    // die;
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Configura tus pagos</title>
        <link href="css/styles.css?id=5" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <style type="text/css">
            input[type=checkbox]
            {
                /* Double-sized Checkboxes */
                -ms-transform: scale(1.2); /* IE */
                -moz-transform: scale(1.2); /* FF */
                -webkit-transform: scale(1.2); /* Safari and Chrome */
                -o-transform: scale(1.2); /* Opera */
                padding: 10px;
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
                    <header class="page-header page-header-compact page-header-light border-bottom bg-success mb-4">
                        <div class="container-xl px-4">
                            <div class="page-header-content">
                                <div class="row align-items-center justify-content-between pt-3">
                                    <div class="col-auto mb-3">
                                        <h1 class="page-header-title text-white fw-600 fs-4">
                                            <div class="page-header-icon text-white">
                                                <i data-feather="user"></i>
                                            </div>
                                            Configuración de la cuenta
                                        </h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </header>
                    <!-- Main page content-->
                    <button type="submit" class="btn btn-success fw-600 circle flotante rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#modalNuevaDireccionCliente" name="btnAddCart">
                        <i data-feather="map-pin" class="me-1"></i> Nueva dirección
                    </button>

                    <div class="container-xl px-4 mt-4">
                        <!-- Account page navigation-->
                        <nav class="nav nav-borders">
                            <a class="nav-link" href="cuenta-configuracion.php">Perfil</a>
                            <a class="nav-link active ms-0" href="#">Direcciones</a>
                            <!-- <a class="nav-link" href="account-security.html">Security</a>
                            <a class="nav-link" href="account-notifications.html">Notifications</a> -->
                        </nav>
                        <hr class="mt-0 mb-2" />

                        <div class="mb-2">

                        </div>

                        <div class="row mx-2 mt-4">

                            <div class="table-responsive bg-white rounded p-1">
                                <table id="datatablesSimple" class="table border rounded-2 table-bordered table-hover" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
                                    <thead class="">
                                        <tr>
                                            <th>Alias</th>
                                            <th>Dirección</th>
                                            <th>Detalles</th>
                                        </tr>
                                    </thead>
                                    <tfoot class="">
                                        <tr>
                                            <th>Alias</th>
                                            <th>Dirección</th>
                                            <th>Detalles</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php

                                      if ($direccionesCliente != false)
                                      {
                                          // output data of each row
                                          foreach($direccionesCliente as $direccion)
                                          {
                                              // echo "1";
                                              echo "<tr>";
                                              $isPrincipal = (($direccion['isPrincipal']==1) ? " <span class='small badge bg-primary rounded-pill'>Principal</span> " : "");
                                              echo "<td class='fw-600'>" . $direccion["aliasDireccion"] . $isPrincipal . "</td>";
                                              echo "<td class='fw-600'>" . $direccion['direccion'] . "</td>";

                                              ?>
                                              <td class="text-center">
                                                    <button class="btn btn-datatable btn-icon btn-transparent-dark me-2"><i data-feather="edit-3"></i></button>
                                                    <button class="btn btn-datatable btn-icon btn-transparent-dark"><i data-feather="trash-2"></i></button>
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
                </main>
                <!-- ALTA PRODUCTO -->
                <?php
                if (file_exists('src/footer.php'))
                {
                    include 'src/footer.php';
                }
                if (file_exists('src/modals.php')) { include 'src/modals.php'; }
                if (file_exists('src/triggers.php')) { include 'src/triggers.php'; }
                ?>

            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables/datatables-simple-demo.js"></script>

        <script type="text/javascript">

        </script>
    </body>
</html>
