<?php

    session_start();

    require 'php/conexion_db.php'; //configuración conexión db
    require 'php/funciones.php'; //configuración conexión db

    if (isset($_SESSION['email']) && isset($_GET['id']))
    {

        $idProducto   = $_GET['id'];
        $email        = $_SESSION['email'];
        $managedStore = $_SESSION['managedStore'];

        $sql = "SELECT * FROM productos WHERE idTienda = '$managedStore' AND idProducto = '$idProducto'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0)
        {
            // output data of each row
            $producto = mysqli_fetch_assoc($result);
        }

        // Obtener Imagenes del producto
        // Prepara la consulta
        $stmt = $conn->prepare("SELECT * FROM imagenProducto WHERE idTienda = ? AND idProducto = ?");

        // Asigna los parámetros a la consulta
        $stmt->bind_param("ss", $managedStore, $idProducto);

        // Ejecuta la consulta
        $stmt->execute();

        // Obtiene el resultado de la consulta
        $result = $stmt->get_result();

        // Cuenta el número de filas obtenidas en la consulta
        $totalImagenes = $result->num_rows;

    }

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard - vendy.mx</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
        <link href="css/styles.css?id=33" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
        <script src="js/funciones.js?id=11"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>

        <style type="text/css">

            .sin-borde:focus
            {
                outline: 0;
                box-shadow: none;
            }

            input[type=checkbox]
            {
              /* Double-sized Checkboxes */
              -ms-transform: scale(1.7); /* IE */
              -moz-transform: scale(1.7); /* FF */
              -webkit-transform: scale(1.7); /* Safari and Chrome */
              -o-transform: scale(1.7); /* Opera */
              transform: scale(1.7);
              padding:5px;
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
                    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
                        <div class="container-xl px-4">
                            <div class="page-header-content pt-4">

                                <div class="row align-items-center justify-content-between">
                                    <div class="col-auto mt-2">
                                        <h1 class="text-white">
                                            <i class="fa-regular fa-sm fa-pen-to-square me-1"></i>
                                            Editando <i class="fw-200">"<?php echo ucwords($producto['nombre']); ?>"</i>
                                        </h1>
                                        <div class="page-header-subtitle"> <small>Actualiza la galería e información de este producto.</small> </div>
                                    </div>
                                </div>

                                <nav class="mt-4 rounded" aria-label="breadcrumb">
                                  <a href="mis-articulos.php" class="text-decoration-none">
                                      <button type="button" class="btn btn-primary rounded-pill shadow-sm lift" name="button">
                                          <i class="fas fa-arrow-circle-left text-white-50 me-2 text-decoration-none"></i>
                                          Regresar a artículos
                                      </button>
                                  </a>
                                </nav>

                            </div>
                        </div>
                    </header>

                    <!-- Main page content-->
                    <div class="container-xl px-4 mt-n10">
                        <!-- Example Colored Cards for Dashboard Demo-->
                        <div class="row">
                            <div class="col-lg-6 col-xl-3 mb-4">
                                <div class="card bg-yellow text-white h-100 lift">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75"></div>
                                                <div class="text-lg fw-bold"><?php echo $totalImagenes; ?> imágenes</div>
                                            </div>
                                            <i class="fa-regular fa-images fa-2x text-white-50"></i>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between small">
                                        <a class="text-white stretched-link" data-bs-toggle="modal" data-bs-target="#exampleModal" style="cursor: pointer;">Ver imagenes</a>
                                        <div class="text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-lg-6 col-xl-3 mb-4">
                                <div class="card bg-warning border-0">
                                    <div class="card-body">
                                        <h5 class="text-white">Vistas al producto</h5>
                                        <div class="mb-4">
                                            <span class="display-4 text-white">48</span>
                                            <span class="text-white">Clics</span>
                                        </div>
                                        <div class="progress bg-white-25 rounded-pill" style="height: 0.5rem"><div class="progress-bar bg-white w-100 rounded-pill" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div></div>
                                    </div>
                                </div>
                            </div> -->
                        </div>

                        <div class="row">
                            <div class="col-xl-6 mb-4">
                                <div class="card card-header-actions h-100">
                                    <div class="card-header">
                                        Datos del producto
                                    </div>
                                    <div class="card-body">
                                        <form action="procesa.php" method="post" enctype="multipart/form-data">

                                            <!-- Form Row-->
                                            <div class="row gx-3">
                                                <div class="col-md-12">

                                                    <div class="form-floating mb-3">
                                                        <input class="form-control" id="inputFirstName" type="text" name="nombreProducto" placeholder="<?php echo ucwords($producto['nombre']); ?>" value="<?php echo ucwords($producto['nombre']); ?>" required/>
                                                        <label for="floatingInput">Nombre <sup>*</sup></label>
                                                    </div>

                                                </div>
                                            </div>

                                            <!-- Form Row-->
                                            <div class="row gx-3 mb-2">
                                                <div class="col-md-6">
                                                    <!-- Form Group (first name)-->
                                                    <label class="small mb-1 fw-bold text-primary" for="inputFirstName">Precio: <sup>*</sup></label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-addon1">
                                                            <i class="fa-solid fa-dollar-sign"></i>
                                                        </span>
                                                        <input class="form-control" id="inputFirstName" name="precioProducto" type="number" pattern="\d*" step="1" min="1" placeholder="0" value="<?php echo $producto['precio']; ?>" required />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="small mb-1 fw-bold text-primary" for="inputFirstName">🏷️ Precio Oferta:</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-addon1">
                                                            <i class="fa-solid fa-dollar-sign"></i>
                                                        </span>
                                                        <input class="form-control" id="inputFirstName" name="precioOfertaProducto" type="number" pattern="\d*" step="1" placeholder="0" value="<?php echo $producto['precioOferta']; ?>" />
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Form Row-->
                                            <div class="row gx-3 mb-2">
                                                <div class="col-md-6">
                                                    <!-- Form Group (first name)-->
                                                    <label class="mb-1 fw-bold text-primary" for="inputFirstName">Stock: <sup>*</sup></label>
                                                    <div class="input-group mb-3">
                                                      <input type="text" pattern="\d*" class="form-control text-center" name="stock" step="1" placeholder="0" value="<?php echo $producto['stock']; ?>" required >
                                                      <span class="input-group-text text-white bg-green" id="basic-addon2">Unidades</span>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="mb-1 fw-bold text-primary" for="inputFirstName">¿Es un producto digital?: </label>
                                                    <div class="input-group mb-3 mt-2 ms-2">
                                                      <div class="form-check form-switch">
                                                        <?php
                                                          if ($producto['requiereEnvio'] == 0)
                                                          {
                                                            ?>
                                                            <input class="form-check-input form-check-input-lg" type="checkbox" style="" id="requiereEnvio" name="requiereEnvio" value="1" checked>
                                                            <label class="form-check-label small" for="requiereEnvio" id="requiereEnvioText">&nbsp; No.</label>
                                                            <?php
                                                          }
                                                          else
                                                          {
                                                            ?>
                                                            <input class="form-check-input form-check-input-lg" type="checkbox" style="" id="requiereEnvio" name="requiereEnvio" value="1">
                                                            <label class="form-check-label small" for="requiereEnvio" id="requiereEnvioText">&nbsp; Sí.</label>
                                                            <?php
                                                          }
                                                        ?>

                                                      </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row gx-3 mb-2">
                                              <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="mb-1 fw-bold text-primary" for="inputLastName">Imágenes:</label>
                                                    <input type="hidden" name="idProducto" value="<?php echo $producto['idProducto']; ?>">
                                                    <div class="border border-2 rounded-3">
                                                        <div class="custom-control custom-switch m-3 p-0">
                                                            <input type="checkbox" class="custom-control-input" id="switchConservarImg" value="1" name="conservarImagenes" checked>
                                                            <label class="custom-control-label" for="switchConservarImg" style="cursor: pointer;">&nbsp; Conservar imagenes actuales</label>
                                                        </div>
                                                    </div>
                                                </div>
                                              </div>
                                              <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="mb-2" for="inputLastName" id="imagenesLabel" style="display: none;">Imágenes: <sup>*</sup></label>
                                                    <input type="hidden" name="idProducto" value="<?php echo $producto['idProducto']; ?>">
                                                    <input type="file" name="imagenProducto[]" id="imagenProducto" onchange="javascript: etiquetaCargaDocumento(this.id);" style="display: none;" multiple>
                                                    <label for="imagenProducto" id="imagenProductoLabel" style="cursor: pointer; display: none;" class="form-control"><i class="fas fa-folder-open"></i> Seleccionar</label>
                                                </div>
                                              </div>
                                            </div>

                                            <div class="row gx-3 mb-2">
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <!-- Select para mostrar las categorías existentes -->
                                                        <div class="row mb-2">
                                                          <label for="categorias-ex" id="labelCatExistentes" class="fw-bold text-primary"></label>
                                                          <label id="salidaCategorias" class=""></label>
                                                        </div>

                                                        <select class="form-select mb-2" name="categoriaSeleccionada" id="categorias-existentes" style="display: none;"></select>
                                                        <div class=" text-end">
                                                            <a class="fw-500 fs-6" data-bs-toggle="modal" data-bs-target="#modalCategorias" data-backdrop="static" data-keyboard="false" style="cursor: pointer;">
                                                                Nueva Categoría
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Form Row-->
                                            <div class="row gx-3 mb-2">
                                              <div class="col-md-12">
                                                  <!-- Form Group (first name)-->
                                                  <div class="mb-3">
                                                      <label class="mb-1 fw-bold text-primary" for="inputFirstName">Describe tu producto:</label>
                                                      <textarea class="form-control" rows="4" cols="80" maxlength="300" name="descripcionProducto"><?php echo (!empty($producto['descripcion']) ? ucfirst($producto['descripcion']) : ""); ?></textarea>
                                                  </div>
                                              </div>
                                            </div>

                                            <!-- Form Row-->
                                            <div class="row gx-3">
                                                <div class="col-md-12">
                                                    <!-- Form Group (first name)-->
                                                    <div class="mb-3 text-end">
                                                        <button type="button" class="btn btn-danger rounded-pill" name="btnAltaProducto" data-bs-toggle="modal" data-bs-target="#modalEliminarProducto">
                                                            <i class="text-white-75 me-1" data-feather="minus-circle"></i> Eliminar
                                                        </button>
                                                        <button type="submit" onclick="return validarFormulario();" class="btn btn-primary rounded-pill" name="btnActualizaProducto">
                                                            Guardar producto
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Galería de producto</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">


                                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-indicators">
                                      <?php

                                      $sql = "SELECT * FROM imagenProducto WHERE idTienda = '$managedStore' AND idProducto = '$idProducto'";
                                      $result = mysqli_query($conn, $sql);
                                      for ($i=0; $i < mysqli_num_rows($result); $i++)
                                      {
                                        if ($i == 0 )
                                        {
                                          ?>
                                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?php echo $i; ?>"  class="active" aria-current="true" aria-label="Imagen <?php echo $i; ?>"></button>
                                          <?php
                                        }
                                        else
                                        {

                                        ?>
                                          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?php echo $i; ?>" aria-label="Imagen <?php echo $i; ?>"></button>
                                        <?php
                                        }
                                      }
                                    ?>

                                    </div>

                                    <div class="carousel-inner">

                                      <?php



                                        $cont = 0;
                                        if (mysqli_num_rows($result) > 0)
                                        {
                                            // output data of each row
                                            while($imagenProducto = mysqli_fetch_assoc($result))
                                            {
                                                $url = $dominio . "/app/verifica/usr_docs/" . $managedStore . "/productos/" . $idProducto . "/" . $imagenProducto['url'];
                                                if ($cont == 0)
                                                {
                                                  ?>
                                                    <div class="carousel-item active">
                                                        <img src="<?php echo $url; ?>" class="d-block w-100" alt="...">
                                                    </div>
                                                  <?php
                                                }
                                                else
                                                {
                                                  ?>
                                                    <div class="carousel-item">
                                                        <img src="<?php echo $url; ?>" class="d-block w-100" alt="...">
                                                    </div>
                                                  <?php
                                                }
                                                $cont++;
                                            }
                                        }
                                        else
                                        {
                                            echo "No tiene imagenes este producto.";
                                        }

                                      ?>

                                    </div>

                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                      <span class="visually-hidden">Previous</span>
                                    </button>

                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                      <span class="visually-hidden">Next</span>
                                    </button>

                                </div>

                              </div>
                              <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                              </div>

                            </div>
                          </div>
                        </div>
                        <!-- Modal Fin  -->

                        <!-- Modal -->
                        <div class="modal fade" id="modalCategorias" tabindex="-1" aria-labelledby="modalCategoriasLabel" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0">
                              <div class="modal-header bg-white border-1 border-bottom">
                                <h5 class="modal-title text-gray" id="modalDatosPagoLabel"> Nueva Categoría </h5>
                                <button type="button" class="btn btn-icon btn-outline-indigo btn-sm" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="fa-solid fa-xmark fa-xl"></i>
                                </button>
                              </div>
                              <div class="modal-body bg-white text-gray border-0 rounded-bottom">
                                  <!-- Formulario de registro de categorías -->
                                  <form id="formulario-categorias" class="">

                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control sin-borde border-indigo text-dark text-center" placeholder="Electrónicos, Abarrotes, Etc" aria-label="Categoría" aria-describedby="Categoría" id="categoria" name="categoria" autocomplete="off" required>

                                        <button class="btn btn-indigo border-1 sin-borde" type="submit" id="">Registrar</button>
                                    </div>
                                    <div class="row text-center">
                                      <?php
                                          if (basename($_SERVER["SCRIPT_FILENAME"], '.php') != "mis-categorias")
                                          {
                                            ?>
                                            <a href="mis-categorias.php" target="_blank">Administrar categorías</a>
                                            <?php
                                          }
                                      ?>
                                    </div>

                                  </form>

                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- Modal Fin  -->

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">

                                  <form id="formulario-categorias" class="">

                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control sin-borde border-indigo text-dark text-center" placeholder="Electrónicos, Abarrotes, Etc" aria-label="Categoría" aria-describedby="Categoría" id="categoria" name="categoria" autocomplete="off" required>

                                        <button class="btn btn-indigo border-1 sin-borde" type="submit" id="">Registrar</button>
                                    </div>
                                    <div class="row text-center">
                                      <?php

                                      ?>
                                    </div>

                                  </form>

                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                              </div>
                            </div>
                          </div>
                        </div>

                    </div>
                </main>
                <?php
                  if (file_exists('src/modals.php'))
                  {
                      include 'src/modals.php';
                  }

                  if (file_exists('src/footer.php'))
                  {
                      include 'src/footer.php';
                  }
                ?>
            </div>
        </div>
        <?php
            if (isset($producto["idCategoria"]))
            {
            ?>
                <script type="text/javascript">
                    var idCategoriaDB = '<?php echo $producto["idCategoria"]; ?>';
                </script>
            <?php
            }
        ?>

        <script type="text/javascript">
            $(document).ready(function()
            {
              $(window).keydown(function(event)
              {
                if(event.keyCode == 13)
                {
                  event.preventDefault();
                  return false;
                }
              });
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/ajax.js?id=33"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
        <script src="js/litepicker.js"></script>
        <script type="text/javascript">
            cargarCategorias();
        </script>
    </body>
</html>
<?php
    if (file_exists('src/triggers.php'))
    {
      include 'src/triggers.php';
    }
?>
