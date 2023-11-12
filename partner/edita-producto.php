<?php

    session_start(); 
    require '../app/php/conexion.php';
    require 'php/funciones.php';

    if (isset($_SESSION['email']) && isset($_GET['id']))
    {

        $idProducto   = $_GET['id'];
        $email        = $_SESSION['email'];
        $idTienda = $_SESSION['managedStore'];

        //Obtener datos del producto
        $sql = "SELECT * FROM productos WHERE idTienda = '$idTienda' AND idProducto = '$idProducto'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0)
        {
            // output data of each row
            $producto = mysqli_fetch_assoc($result);
        }

        // Obtener Imagenes del producto
        $imagenesProducto = getImagenesProducto($conn, $idProducto, $idTienda);

        $hasActivePayment = validarPagoActivo($conn, $idTienda);
        // echo "<pre>";
        // var_dump($producto);
        // die;
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
        <title>Dashboard - mayoristapp.mx</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
        <link href="css/styles.css?id=323" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
        <script src="js/funciones.js?id=22"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>

        <!-- Galería  -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.3/css/lightgallery.css'>
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.3/css/lg-zoom.css'>
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/justifiedGallery@3.8.1/dist/css/justifiedGallery.css'>
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.3/css/lg-thumbnail.css'>
        <link rel="stylesheet" href="css/gallery-styles.css?id=28">
        <!-- Galería  -->

        <style type="text/css">

            .sin-borde:focus
            {
                outline: 0;
                box-shadow: none;
            }

            .custom-select
            {
                background: #668c1c url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 5'%3e%3cpath fill='white' d='M2 0L0 2h4zm0 5L0 3h4z'/%3e%3c/svg%3e") no-repeat right .75rem center/8px 10px !important;
            }

            input[type=checkbox]
            {
                /* Double-sized Checkboxes */
                -ms-transform: scale(1.5); /* IE */
                -moz-transform: scale(1.5); /* FF */
                -webkit-transform: scale(1.5); /* Safari and Chrome */
                -o-transform: scale(1.5); /* Opera */
                transform: scale(1.5);
                padding: 8px;
            }

            #segundoBloque
            {
                transition: all 0.5s ease;
                display: none;
            }

            .img
            {
                float: left;
                width:  100px;
                height: 100px;
                background-size: cover;
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
                    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
                        <div class="container-xl px-4">
                            <div class="page-header-content pt-2">

                                <nav class="mt-3 mb-4 rounded" aria-label="breadcrumb">
                                  <a href="mis-articulos.php" class="text-decoration-none">
                                      <button type="button" class="btn btn-light text-dark fw-500 btn-sm rounded-pill shadow-sm" name="button">
                                          <i class="fas fa-arrow-circle-left text-gray-700 me-2 text-decoration-none"></i>
                                          Regresar a Artículos
                                      </button>
                                  </a>
                                </nav>

                                <div class="row align-items-center justify-content-between">
                                    <div class="col-auto mt-2">
                                        <h1 class="text-white fw-200">
                                            <i class="fas fa-pencil-alt me-1"></i>
                                            Editando <i class="fw-500">"<?php echo ucwords($producto['nombre']); ?>"</i>
                                        </h1>
                                        <div class="page-header-subtitle"> <small>Modifica los campos necesarios para actualizar el artículo.</small> </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </header>

                    <!-- Main page content-->
                    <div class="container-xl px-4 mt-n10">


                        
                        <div class="row">

                            <div class="col-lg-6 col-xl-4 mb-4">
                                <div class="card bg-indigo text-white h-100 lift">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">Etiqueta de</div>
                                                <div class="text-lg fw-bold">Producto</div>
                                            </div>
                                            <!-- <i class="feather-xl text-white-50" data-feather="printer"></i> -->
                                            <i class="fas fa-barcode display-6 text-white-50"></i>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <!-- <a style="cursor: pointer;" class="text-white stretched-link" onclick="javascript: makeCodeUrlPago('<?php echo $producto['barcode']; ?>');">Descargar</a> -->
                                        
                                        <form action="procesa.php" method="POST">
                                            <input type="hidden" name="idProducto" value="<?php echo $idProducto;?>">
                                            <button type="submit" class="btn text-white text-center poppins-font fw-500 fs-6 w-100" name="btnGenerarEtiqueta" value="<?php echo $producto['barcode']. ';' . $producto['nombre'] . ';' . $producto['precio']; ?>" style="cursor: pointer;">
                                                <i class="text-white me-2 feather-lg" data-feather="download-cloud"></i>
                                                Descargar                                                
                                            </button>
                                        </form>
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-xl-4 mb-4">
                                <div class="card bg-yellow text-white h-100 lift">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75">Multimedia</div>
                                                <div class="text-lg fw-bold">
                                                    <?php
                                                        if ($imagenesProducto === false) 
                                                        {
                                                            echo "0 Imágenes";
                                                        } 
                                                        else 
                                                        {
                                                            $numImagenes = count($imagenesProducto);
                                                            echo $numImagenes . " " . ($numImagenes === 1 ? "Imagen" : "Imágenes");
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                            <i class="fa-regular fa-images display-6 text-white-75"></i>
                                        </div>
                                    </div>
                                    <div class="card-footer ">

                                        <div class="gallery-container text-center" id="gallery-container">
                                            <?php
                                            if ($imagenesProducto !== false)
                                            {
                                                foreach ($imagenesProducto as $key => $imgProducto)
                                                {
                                                    if ($key === array_key_first($imagenesProducto))
                                                    {
                                                    ?>
                                                        <a data-lg-size="1400-1400" style="cursor: pointer;" class="gallery-item fs-6 poppins-font text-white fw-600 text-center" data-src="verifica/usr_docs/<?php echo $idTienda; ?>/productos/<?php echo $idProducto; ?>/<?php echo $imgProducto['url']; ?>" data-sub-html="">
                                                            <i class="far fa-eye"></i> Ver imagenes
                                                        </a>
                                                    <?php
                                                    }
                                                    else
                                                    {
                                                    ?>
                                                        <a data-lg-size="1400-1400" style="cursor: pointer;" class="gallery-item text-decoration-none" data-src="verifica/usr_docs/<?php echo $idTienda; ?>/productos/<?php echo $idProducto; ?>/<?php echo $imgProducto['url']; ?>" data-sub-html="">
                                                        </a>
                                                    <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </div> 

                                    </div>
                                </div>
                            </div>                       
                            
                            <div class="col-lg-6 col-xl-4 mb-4">
                                <div class="card bg-danger text-white h-100 lift" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#modalEliminarProducto">                                
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="fs-2 text-white-75">Eliminar</div>
                                                <div class="display-6 fw-bold">Artículo</div>
                                            </div>
                                            <i class="feather-xl text-white-75" data-feather="trash"></i>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>

                        </div>
                        
                        <form action="procesa.php" id="formulario" method="post" enctype="multipart/form-data" >
                            <div class="row">

                                <div class="col-xl-6 col-xxl-6 mb-4">
                                    <!-- Datos del producto -->
                                    <div class="card card-header-actions h-100 mb-4">
                                        <div class="card-header">
                                            Datos del artículo
                                        </div>
                                        <div class="card-body">

                                            <!-- Form Row-->
                                            <div class="row gx-3">
                                                <div class="col-md-12">
                                                    <!-- Form Group (first name)-->
                                                    <div class="fw-600 text-primary mb-2"> Código:<sup>*</sup></div>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text bg-primary" id="basic-addon1"><i class="text-center text-white fas fa-barcode"></i></span>
                                                        <input type="text" class="form-control text-center fw-500 fs-4 shadow-none border border-3" id="barcode" name="barcode" value="<?php echo $producto['barcode']; ?>" readonly>
                                                    </div>

                                                </div>
                                            </div>

                                            <hr class="mb-4 text-gray-300">

                                            <!-- Form Row-->
                                            <div class="row gx-3">
                                                <div class="col-md-12">
                                                    <!-- Form Group (first name)-->
                                                    <div class="form-floating mb-3">
                                                        <input class="form-control border border-3 rounded fs-3 fw-500 shadow-none border border-3" id="inputFirstName" type="text" name="nombreProducto" placeholder="Nombre articulo" autocomplete="off" value="<?php echo $producto['nombre']; ?>" required/>
                                                        <label for="floatingInput">Nombre<sup>*</sup></label>
                                                    </div>

                                                </div>
                                            </div>


                                            <div class="row gx-3">
                                                <div class="col-md-12">
                                                  <div class="mb-3">
                                                      <label class="small mb-1 fw-600 text-primary" for="inputLastName">Imágenes: </label><sup>*</sup>

                                                      <div class="col-md-12">
                                                          <div class="border border-2 rounded-3 mb-2">
                                                              <div class="custom-control custom-switch m-2 p-1">
                                                                  <input type="checkbox" class="custom-control-input" id="switchConservarImg" value="1" name="conservarImagenes" checked>
                                                                  <label class="custom-control-label small" for="switchConservarImg" style="cursor: pointer;"> &nbsp; Conservar imagenes actuales</label>
                                                              </div>

                                                              <div id="imagenProductoJS" class="m-2" style="cursor: pointer; display: none;">
                                                                  <input type="file" name="imagenProducto[]" id="imagenProducto" onchange="javascript: etiquetaCargaDocumento(this.id);" style="display: none;"  multiple>
                                                                  <label for="imagenProducto" id="labelProductoJs" style="cursor: pointer;" class="form-control"><i class="fas fa-folder-open"></i> Seleccionar</label>
                                                              </div>
                                                          </div>
                                                      </div>
                                                  </div>
                                                </div>

                                            </div>

                                            <div class="row gx-3">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <!-- Select para mostrar las categorías existentes -->
                                                        <label for="categorias-ex" class="fw-600 text-primary small" id="labelCatExistentes"></label><sup>*</sup>
                                                        <label id="salidaCategorias"></label>
                                                        <!-- <span class="mb-1 small badge bg-green text-white rounded-pill" data-bs-toggle="modal" data-bs-target="#modalCategorias" data-backdrop="static" data-keyboard="false" style="cursor: pointer;">Agregar</span> -->
                                                        <select class="form-select mb-2" name="categoriaSeleccionada" id="categorias-existentes"></select>

                                                        <div class="text-end">
                                                            <a class="fw-500 small" data-bs-toggle="modal" data-bs-target="#modalCategorias" data-backdrop="static" data-keyboard="false" style="cursor: pointer;">
                                                                Nueva Categoría
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- Descripción -->
                                            <div class="row gx-3">
                                              <div class="col-md-12">
                                                  <!-- Form Group (first name)-->
                                                  <div class="mb-3">
                                                      <label class="small mb-1 fw-600 text-primary" for="inputFirstName">Describe tu producto:</label>
                                                      <?php
                                                          if (!is_null($producto['descripcion']))
                                                          {
                                                              echo '<textarea class="form-control" rows="4" cols="80" maxlength="300" name="descripcionProducto" placeholder="(Opcional)">'.$producto['descripcion'].'</textarea>';
                                                          }
                                                          else
                                                          {
                                                              echo '<textarea class="form-control" rows="4" cols="80" maxlength="300" name="descripcionProducto" placeholder="(Opcional)"></textarea>';
                                                          }
                                                      ?>
                                                  </div>
                                              </div>
                                            </div>

                                            <hr class="mb-4 text-gray-300">

                                            <div class="row gx-3">

                                                <div class="col-md-6">
                                                    <label for="" class="mb-2 small fw-600 text-primary">Costo:</label><sup>*</sup>
                                                    <div class="input-group mb-3">
                                                      <span class="input-group-text" id="basic-addon1">$</span>
                                                      <input type="number" class="form-control text-center" id="costoProducto" name="costoProducto" value="<?php echo $producto['costo']; ?>" placeholder="0.00" pattern="\d*" step="0.01">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="" class="mb-2 small fw-600 text-primary">Precio de venta:</label><sup>*</sup>
                                                    <!-- <span class="mb-1 small badge bg-light text-dark border border-gray-200 rounded-pill" data-bs-toggle="modal" data-bs-target="#modalCategorias" data-backdrop="static" data-keyboard="false" style="cursor: pointer;"><i class="fas fa-dollar-sign small"></i> Calcular</span> -->
                                                    <div class="input-group mb-3">
                                                      <span class="input-group-text" id="basic-addon1">$</span>
                                                      <input type="number" class="form-control text-center" id="precioVenta" name="precioVenta" value="<?php echo $producto['precio']; ?>" placeholder="0.00" pattern="\d*" step="0.01">
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-xxl-6 mb-4">
                                    <!-- Inicio Bloque 2 -->

                                    <div style="display:block;" class="mb-2" id="segundoBloque">
                                        <div class="card card-header-actions h-100">
                                            <div class="card-header">
                                                Gestión del inventario
                                            </div>
                                            <div class="card-body">

                                                    <!-- Form Row-->
                                                    <div class="row gx-3">
                                                        <label for="" class="mb-2 fw-600 text-primary small">Inventario inicial:<sup>*</sup></label>
                                                        <div class="input-group mb-3">

                                                            <input type="number" class="form-control border border-2 rounded-start" id="inventarioPiezas"     name="inventarioInicialPzs" step="1"   min="0" oninput="validity.valid||(value='');" placeholder="0" style="display:none;">
                                                            <input type="number" class="form-control border border-2 rounded-start" id="inventarioKilogramos" name="inventarioInicialKgs" step=".01" min="0" placeholder="0.00" style="display:none;">

                                                            <select class="form-select fw-600 text-white bg-success custom-select" id="selectUnidadVenta" name="unidadVenta" aria-label="Example select with button addon">
                                                                <option value="">Seleccionar unidades</option>
                                                                <option value="Piezas">Piezas</option>
                                                                <option value="Kilogramos">Kilogramos</option>
                                                            </select>

                                                        </div>
                                                    </div>

                                                    <div class="row p-1" id="inventarioAdicional" style="display: none;">
                                                        <!-- Form Row-->
                                                        <div class="row gx-3">
                                                            <div class="col-md-6">
                                                                <!-- Form Group (first name)-->
                                                                <label class="small mb-1 fw-600 text-primary" for="inputFirstName"><i class="far fa-bell"></i> Alerta Inventario mínimo: <sup>*</sup></label>
                                                                <div class="mb-3">
                                                                    <input type="number" class="form-control border border-2 rounded-start" id="invMinPiezas"     name="inventarioMinimoPzs" step="1"   min="0" oninput="validity.valid||(value='');" placeholder="0"    style="display:none;">
                                                                    <input type="number" class="form-control border border-2 rounded-start" id="invMinKilogramos" name="inventarioMinimoKgs" step=".01" min="0" oninput="validity.valid||(value='');" placeholder="0.00" style="display:none;">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Form Row-->
                                                        <div class="row gx-3" id="isProductoDigital" style="display:none;">
                                                            <div class="col-md-6">
                                                                <label class="small mb-1 fw-600 text-primary" for="inputFirstName">¿Es un producto digital?: </label>
                                                                <div class="input-group mb-3 mt-2 ms-2">
                                                                  <div class="form-check form-switch">
                                                                      <input class="form-check-input form-check-input-lg" type="checkbox" style="" id="requiereEnvio" name="requiereEnvio" value="1" <?php echo !empty($producto['requiereEnvio']) ? "" : " checked"; ?>>
                                                                      <label class="form-check-label small" for="reqEnvio" id="requiereEnvioText">&nbsp; No.</label>
                                                                  </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <hr class="m-2 text-gray-300">
                                                        <!-- Form Row-->
                                                        <div class="row gx-3" id="isProductoDigital" style="">
                                                            <div class="col-md-12">
                                                                <label class="small mb-1 fw-600 text-primary" for="inputFirstName">Venta en línea:</label>
                                                                <div class="input-group mb-3 mt-2 ms-2">
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input form-check-input-lg" type="checkbox" style="" id="isActiveOnlineStore" name="isActiveOnlineStore" value="1" <?php echo !empty($producto['isActiveOnlineStore']) ? " checked" : ""; ?>>
                                                                        <label class="form-check-label small" for="reqEnvio" id="isActiveOnlineStoreLabel">&nbsp; Sí.</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Form Row-->
                                                        <div class="row gx-3">
                                                            <div class="col-md-12 text-gray-600 small">
                                                                <b class="text-danger fs-3">*</b>: Dato requerido
                                                            </div>
                                                        </div>
                                                    </div>                                                    
                                            </div>
                                            
                                        </div>

                                    </div>


                                </div>
                                
                            </div>
                            
                            <input type="hidden" name="idProducto" value="<?php echo $idProducto; ?>">
                            <button type="submit" onclick="return validarActualizaProducto();" class="btn btn-primary circle flotante rounded-pill poppins-font shadow-sm" name="btnActualizaProducto">
                                <i class="far fa-save me-2"></i> Guardar cambios
                            </button>
                        </form>

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
                                        <a href="mis-categorias.php" target="_blank">Administrar categorías</a>
                                      </div>

                                  </form>

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

        <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
        <script src="js/ajax.js?id=33353"></script>
        <script type="text/javascript">
            cargarCategorias();
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js?id=322265"></script>
        <script type="text/javascript">

            const switchConservarImg = document.getElementById("switchConservarImg");
            const imagenProductoJS = document.getElementById("imagenProductoJS");

            switchConservarImg.addEventListener("change", function()
            {
                if (switchConservarImg.checked === true)
                {
                    imagenProductoJS.style.display = "none";
                }
                else
                {
                    imagenProductoJS.style.display = "block";
                }
            });


            $(document).ready(function()
            {
                $("#selectUnidadVenta").change(function()
                {
                    if ($(this).val() === "Piezas")
                    {
                        $('#inventarioPiezas').prop('required',true);
                        $('#invMinPiezas').prop('required',true);

                        $("#inventarioPiezas").show();
                        $("#invMinPiezas").show();

                        $("#inventarioKilogramos").hide();
                        $("#invMinKilogramos").hide();

                        $('#inventarioKilogramos').prop('required', false);
                        $('#invMinKilogramos').prop('required', false);

                        $("#isProductoDigital").show();
                    }
                    else if ($(this).val() === "Kilogramos")
                    {
                        $("#inventarioPiezas").hide();
                        $("#invMinPiezas").hide();

                        $('#inventarioPiezas').prop('required', false);
                        $('#invMinPiezas').prop('required', false);

                        $("#inventarioKilogramos").show();
                        $("#invMinKilogramos").show();

                        $('#inventarioKilogramos').prop('required', true);
                        $('#invMinKilogramos').prop('required', true);
                        $("#isProductoDigital").hide();
                    }
                    $("#inventarioAdicional").show();
                });
            });

            var unidadVenta = '';
            unidadVenta = '<?php echo isset($producto['unidadVenta']) ? $producto['unidadVenta'] : ""; ?>';
            //console.log(unidadVenta);

            //alert(unidadVenta);
            if (unidadVenta === '')
            {

            }
            else
            {
                // Cambio el valor del select
                document.getElementById("selectUnidadVenta").value = unidadVenta;

                var inventarioDB = '';
                inventarioDB = '<?php echo isset($producto['inventario']) ? $producto['inventario'] : ""; ?>';
                //console.log(inventarioDB);

                var inventarioMinimoDB = '';
                inventarioMinimoDB = '<?php echo isset($producto['inventarioMinimo']) ? $producto['inventarioMinimo'] : ""; ?>';
                //console.log(inventarioMinimoDB);

                //Asigno los datos de inventario
                switch (unidadVenta)
                {
                    case 'Piezas':

                        // Mostrar input inventario Piezas
                        $("#inventarioPiezas").show();
                        $("#inventarioPiezas").val(inventarioDB);

                        $("#invMinPiezas").show();
                        $("#invMinPiezas").val(inventarioMinimoDB);

                        $("#inventarioKilogramos").hide();
                        $("#invMinKilogramos").hide();

                        $("#isProductoDigital").show();

                    break;

                    case 'Kilogramos':

                        // Mostrar input inventario Piezas
                        $("#inventarioKilogramos").show();
                        $("#invMinKilogramos").show();

                        $("#inventarioKilogramos").val(inventarioDB);
                        $("#invMinKilogramos").val(inventarioMinimoDB);

                        $("#inventarioPiezas").hide();
                        $("#invMinPiezas").hide();

                        $("#isProductoDigital").hide();

                    break;

                    default:
                }
                $("#inventarioAdicional").show();
            }

        </script>
        <script type="text/javascript">
            setTimeout(() =>
            {
                // console.log(idCategoriaDB);
                document.getElementById('categorias-existentes').value = '<?php echo $producto['idCategoria']; ?>';
            }, 1000);
        </script>

        <script type="module" src="js/gallery-script.js?id=52"></script>
    </body>
</html>
<?php
  if (file_exists('src/triggers.php'))
  {
      include 'src/triggers.php';
  }
?>
