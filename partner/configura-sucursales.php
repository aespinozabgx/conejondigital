<?php

    session_start();

    require 'php/conexion_db.php'; //configuración conexión db
    require 'php/funciones.php'; //configuración conexión db

    if (isset($_SESSION['email'], $_SESSION['managedStore']))
    {
        $email    = $_SESSION['email'];
        $idTienda = $_SESSION['managedStore'];
    }

    $hasActivePayment = validarPagoActivo($conn, $idTienda);
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Sucursales :: Vendy</title>

        <!-- Estilos CSS -->
        <link href="css/styles.css" rel="stylesheet" />

        <!-- Datatables CSS -->
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <!-- <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" /> -->

        <!-- jquery -->
        <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>

        <!-- Fontawesome -->
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>

        <!-- Feather icon -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>

        <!-- Sweet alert -->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Estilos própios -->
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

            .flotante
            {
                position:fixed;
                bottom:25px;
                right:20px;
                margin:0;
                padding:10px;
                z-index: 3000;
            }

            .paginate_button.active
            {
                color: black;
                background-color: white;
            }

            .paginate_button:hover
            {
                color: yellow;
                background-color: green;
            }

            .paginate_button
            {
                background-color: #fff;
                color: #333;
            }

            div.dataTables_filter > label > input
            {
                font-family: 'poppins', Arial, sans-serif;
                font-size: 1em;
                border: 1px solid rgb(33, 47, 115);
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
                    <header class="page-header page-header-dark bg-indigo pb-10">
                        <div class="container-xl px-4">
                            <div class="page-header-content pt-4">
                                <div class="row align-items-center justify-content-between">
                                    <div class="col-auto mt-4">
                                        <h1 class="page-header-title">
                                            <div class="page-header-icon">
                                                <!-- <i data-feather="filter"></i> -->
                                                <i class="far fa-building"></i>
                                            </div>
                                             Sucursales
                                        </h1>
                                        <div class="page-header-subtitle">Administra tus sucursales y permite a tus clientes recoger en sucursal.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </header>
                    <!-- Main page content-->
                    <div class="container-xl px-4 mt-n10">
                        <div class="card mb-4">
                            <div class="card-header">Listado de sucursales</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatablesSimple" class="table table-hover border border-1" cellpadding="0" cellspacing="0" border="0" role="grid" aria-describedby="example_info">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>Sucursal</th>
                                                <th>Dirección</th>
                                                <th>Detalles</th>
                                            </tr>
                                        </thead>
                                        <tfoot class="bg-light">
                                            <tr>
                                                <th>Sucursal</th>
                                                <th>Dirección</th>
                                                <th>Detalles</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                        <?php
                                        // Obtener las sucursales de la tienda
                                        $sucursales = getSucursalesTienda($conn, $idTienda);

                                        // Iterar sobre las sucursales y mostrarlas en la tabla
                                        if ($sucursales)
                                        {
                                            foreach ($sucursales as $sucursal)
                                            {
                                                // Crear badge si es la dirección principal
                                                $isPrincipal = ($sucursal['isPrincipal'] == 1 ? '<span class="badge bg-warning text-white rounded-pill fw-600">Principal</span>' : '');

                                                // Construyo dirección
                                                $direccion = ucfirst(htmlentities($sucursal['calle'])) . ' ' . $sucursal['numeroExterior'];

                                                if (!empty($sucursal['interiorDepto']))
                                                {
                                                    $direccion .= ', Interior/Depto ' . $sucursal['interiorDepto'];
                                                }

                                                $direccion .= ', Colonia ' . $sucursal['colonia'] . ', C.P. ' . $sucursal['codigoPostal'] . ', Municipio/Alcaldía: ' . $sucursal['municipioAlcaldia'] . ', ' . $sucursal['estado'];

                                                if (!empty($sucursal['entreCalle1']) && !empty($sucursal['entreCalle2']))
                                                {
                                                    $direccion .= ', Entre Calle ' . $sucursal['entreCalle1'] . " y calle " . $sucursal['entreCalle2'];
                                                }

                                                if (!empty($sucursal['telefono']))
                                                {
                                                    $direccion .= ', Teléfono: ' . $sucursal['telefono'];
                                                }

                                                if (!empty($sucursal['indicacionesAdicionales']))
                                                {
                                                    $direccion .= ', Indicaciones Adicionales: ' . $sucursal['indicacionesAdicionales'];
                                                }

                                                $direccion = (ucwords(strtolower($direccion)));

                                                //var_dump($isPrincipal);
                                                echo '<tr>';
                                                echo "<td>{$sucursal['nombreSucursal']} {$isPrincipal}</td>";

                                                $shortDireccion = (strlen($direccion) > 44) ? substr($direccion, 0, 44) . ' ...' : $direccion;
                                                echo "<td>{$shortDireccion}</td>";
                                                ?>
                                                    <td>

                                                        <!-- Ver datos -->
                                                        <a href="#" onclick="mostrarDireccion('<?php echo ($direccion); ?>')" class="btn btn-icon btn-outline-success btn-sm rounded-pill mb-1"><i data-feather="eye"></i></a>

                                                        <!-- Editar -->
                                                        <a href='#' onclick="editarDireccion('<?php echo htmlspecialchars(json_encode($sucursal)); ?>')" class='btn btn-icon btn-outline-success btn-sm rounded-pill mb-1'>
                                                            <i data-feather='edit-3'></i>
                                                        </a>

                                                        <!-- Eliminar -->
                                                        <?php
                                                        // MOSTRAR BOTÓN SÓLO A LOS QUE CUMPLAN LA CONDICIÓN
                                                        if ($sucursal['isPrincipal'] == 0)
                                                        {
                                                            ?>
                                                            <a href='#' class='btn btn-icon btn-sm btn-danger rounded-pill mb-1' data-bs-toggle="modal" data-bs-target="#modalEliminarSucursal" onclick="branchToDelete(<?php echo $sucursal['id']; ?>)"><i data-feather='trash'></i></a>
                                                            <?php
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                    </table>
                                </div>
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
                </main>

                <div class="d-none d-lg-flex fixed-bottom justify-content-end mb-4 me-4">
                    <button class="btn btn-primary btn-sm rounded-pill fs-6 fw-300 shadow-sm" type="button" name="button" data-bs-toggle="modal" data-bs-target="#modalNuevaSucursal">
                        <span class="border border-1 btn btn-icon btn-sm text-white me-2"><i class="fas fa-plus fa-sm"></i></span> Nueva sucursal
                    </button>
                </div>

                <div class="d-lg-none fixed-bottom d-flex justify-content-center text-center mb-4">
                    <button class="btn btn-primary btn-sm rounded-pill fs-6 fw-300 shadow-sm" type="button" name="button" data-bs-toggle="modal" data-bs-target="#modalNuevaSucursal">
                        <span class="border border-1 btn btn-icon btn-sm text-white me-2"><i class="fas fa-plus fa-sm"></i></span> Nueva sucursal
                    </button>
                </div>
                <!--  Footer -->
                <?php if (file_exists('src/footer.php')) { include 'src/footer.php'; } ?>
            </div>
        </div>

        <?php
        // Modals
        if (file_exists('src/modals.php'))
        {
            include 'src/modals.php';
        }

        // Triggers
        if (file_exists('src/triggers.php'))
        {
            include 'src/triggers.php';
        }
        ?>
        <!-- <script src='https://cdn.datatables.net/v/bs-3.3.6/jqc-1.12.3/jszip-2.5.0/pdfmake-0.1.18/dt-1.10.12/af-2.1.2/b-1.2.2/b-colvis-1.2.2/b-html5-1.2.2/b-print-1.2.2/cr-1.3.2/fc-3.2.2/fh-3.1.2/kt-2.1.3/r-2.1.0/rr-1.1.2/sc-1.4.2/se-1.2.0/datatables.min.js'></script> -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="js/funciones.js?id=99999"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables/datatables-simple-demo.js"></script>
    </body>
</html>
