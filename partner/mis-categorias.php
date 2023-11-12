<?php
    session_start();

   
    require '../app/php/conexion.php';
    require '../app/php/funciones.php';
    $hasActivePayment = array();
    $hasActivePayment['existePagoActivo'] = true;
    if (isset($_SESSION['email']))
    {
        $email = $_SESSION['email'];
    }

    $idTienda = $_SESSION['managedStore'];
    $categorias = getCategoriasTienda($conn, $idTienda);
    //$hasActivePayment = validarPagoActivo($conn, $idTienda);
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
        <title>Mis Categorías</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
        <link href="css/styles.css?id=3328" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
        <script src="js/funciones.js?id=33"></script>
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
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
              transition: 0.3s;
              opacity: 0.3;
          }

          .circle:hover
          {
              transition: 0.5s;
              transform: scale(1.1);
              opacity: 1;
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
              if (file_exists('src/sideMenu.php'))
              {
                include 'src/sideMenu.php';
              }
            ?>
            <div id="layoutSidenav_content">
                <main>
                    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-9">
                        <div class="container-xl px-4">
                            <div class="page-header-content pt-4">
                                <div class="row align-items-center justify-content-between">
                                    <div class="col-auto mt-3">
                                        <div class="display-6 text-white sombra-titulos-vendy"> 
                                            <i class="fas fa-tags fa-sm text-white-50 me-2"></i> Mis Categorías
                                        </div>
                                        <div class="page-header-subtitle">Administra tus categorías.</div>
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
                            <div class="col-xl-6">

                                <!-- TABLA PRODUCTOS INICIO -->
                                <div class="card card-header-actions mx-auto">
                                    <div class="card-header">
                                        Listado
                                        <div>

                                            <!-- <button type="button" class="btn btn-outline-primary rounded-pill fw-600" data-bs-toggle="modal" data-bs-target="#modalCategoriasPost">
                                                <i class="fas fa-plus me-1"></i> Nueva categoría
                                            </button> -->

                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="datatablesSimple" class="table table-hover table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th>Productos activos</th>
                                                        <th>Detalle</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th>Productos activos</th>
                                                        <th>Detalle</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    <?php
                                                        if ($categorias != false)
                                                        {
                                                            foreach ($categorias as $key => $value)
                                                            {
                                                                echo "<tr class='align-middle'>";
                                                                ?>

                                                                <td class="">
                                                                <div class="fw-400 fs-4 text-start">
                                                                    <?php echo ucfirst($value['nombre']); ?>
                                                                </div>
                                                                </td>
                                                                
                                                                <td>
                                                                    <div class="text-center fs-4 <?php echo ($value['numProductos'] === 0) ? 'text-danger fw-600' : 'text-dark fw-500'; ?>">
                                                                        <?php echo ($value['numProductos']); ?>
                                                                    </div>                                                                
                                                                </td>

                                                                <td>
                                                                    <button type="button" class="btn btn-success btn-icon btn-lg mb-1 me-1" onclick="javascript: enviarCategoria(this.id, this.name);" name="<?php echo $value['nombre']; ?>" id="<?php echo $value['idCategoria']; ?>" data-bs-toggle="modal" data-bs-target="#modalEditarCategoria">
                                                                        <i class="fas fa-pencil-alt"></i>
                                                                    </button>

                                                                    <?php
                                                                    if ($value['numProductos'] <= 0) 
                                                                    {                                                                                                                                
                                                                        ?>
                                                                        <button type="button" class="btn btn-danger btn-icon btn-lg mb-1 me-1" onclick="javascript: eliminarCategoria(this.id);" id="<?php echo $value['idCategoria']; ?>" data-bs-toggle="modal" data-bs-target="#modalEliminarCategoria">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                        <?php
                                                                    }
                                                                    ?>
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

            <!-- <a class="btn btn-primary btn-md btn-icon circle flotante" href="altaProducto.php">
              <i class="fas fa-plus fa-xl"></i>
            </a> -->

            <div class="flotante">
                <button type="button" class="btn btn-primary rounded-pill fw-600" name="button" data-bs-toggle="modal" data-bs-target="#modalCategoriasPost">
                    <i class="fas fa-plus me-1"></i> Nueva categoría
                </button>
            </div>

        </div>
        
        <?php
            if (file_exists('src/triggers.php'))
            {
                include 'src/triggers.php';
            }
        ?>
        
        <?php if (file_exists('src/modals.php')) { include 'src/modals.php'; } ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

        <script src="js/scripts.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables/datatables-simple-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
        <script src="js/litepicker.js"></script>        

        <script type="text/javascript">

            document.querySelector('#categoriaNombre').addEventListener('keypress', function(event) 
            {
                // Verificar si el carácter ingresado es una letra, un número o un espacio
                if (!/[a-z0-9 ]/.test(event.key))
                {
                // Evitar que el carácter sea añadido al valor del input
                event.preventDefault();
                }

                // Verificar si el input tiene más de 33 caracteres
                if (this.value.length >= 33)
                {
                // Evitar que se añadan más caracteres al input
                event.preventDefault();
                }
            });

            function actualizarCategorias(idBoton)
            {
                // Crear objeto XMLHttpRequest
                var xhr = new XMLHttpRequest();

                // Configurar la solicitud
                xhr.open("POST", "procesar_categorias.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                // Enviar la solicitud con el ID del botón como parámetro
                xhr.send("id_boton=" + idBoton);

                // Gestionar la respuesta
                xhr.onload = function()
                {
                  if (xhr.status == 200)
                  {
                    // Si la solicitud se procesó correctamente, actualizar la tabla
                    document.querySelector("table").innerHTML = xhr.responseText;
                  }
                  else
                  {
                    // Si hubo un error, mostrar un mensaje de error
                    alert("Error al actualizar la tabla de categorías: " + xhr.status + " " + xhr.statusText);
                  }
                };
            }

            function enviarCategoria(id, categoria)
            {
                document.getElementById('idCategoria').value = id;
                document.getElementById('categoriaNombre').value  = categoria;
            }

            function eliminarCategoria(id)
            {
                document.getElementById('idCategoriaEliminar').value = id;
            }

        </script>

    </body>
</html>
