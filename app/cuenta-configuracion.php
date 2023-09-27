<?php
    session_start();
    require 'php/conexion.php'; //configuración conexión db
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
    
    // $idUsuario = $emailUsuario;
    // $direccionesCliente = getDireccionesCliente($conn, $idUsuario);

    // $hasActivePayment = validarPagoActivo($conn, $idTienda);
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
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />

        <title>Conejón Digital</title> 
        <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
        <link href="css/styles.css?id=3328" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
        
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="js/qrcode.js"></script>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

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
                            <a class="nav-link active ms-0" href="#">Perfil</a>
                            <!-- <a class="nav-link" href="cuenta-direcciones.php">Direcciones</a> -->
                            <!-- <a class="nav-link" href="account-security.html">Security</a>
                            <a class="nav-link" href="account-notifications.html">Notifications</a> -->
                        </nav>
                        <hr class="mt-0 mb-2" />

                        <div class="mb-2">

                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <!-- Change password card-->
                                <div class="card mb-4">
                                    <div class="card-header fw-600">
                                        <i data-feather="key" class="feather-lg me-1"></i>
                                        Cambiar contraseña
                                    </div>
                                    <div class="card-body">
                                        <form action="procesa.php" method="post">
                                            <!-- Form Group (current password)-->
                                            <div class="mb-3">
                                                <label class="small mb-1" for="currentPassword">Contraseña actual:</label>
                                                <input class="form-control shadow-none border border-2 " name="currentPassword" id="currentPassword" type="password" placeholder="Contraseña actual" required />
                                            </div>

                                            <!-- Form Group (new password)-->
                                            <div class="mb-3">
                                              <label class="small mb-1" for="newPassword">Nueva contraseña:</label>
                                              <input class="form-control shadow-none border border-2" name="newPassword" id="newPassword" type="password" placeholder="Nueva contraseña" minlength="8" required />
                                            </div>

                                            <!-- Form Group (confirm password)-->
                                            <div class="mb-3">
                                              <label class="small mb-1" for="confirmPassword">Confirma tu contraseña:</label>
                                              <input class="form-control shadow-none border border-2" name="confirmPassword" id="confirmPassword" type="password" placeholder="Confirma tu contraseña" minlength="8" required />
                                            </div>

                                            <div class="text-end">
                                                <button class="btn btn-primary rounded-2" type="submit" name="btnCambiarPasswordCliente">Guardar</button>
                                            </div>
                                        </form>
                                    </div>
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
        
        <script src="js/scripts.js?id=28"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables/datatables-simple-demo.js"></script>

        <script type="text/javascript">

        </script>
    </body>
</html>
