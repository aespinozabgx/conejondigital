<?php
    session_start();  
    
    require '../app/php/conexion.php';
    require 'php/funciones.php';

    // Validar si está configurada la tienda, si no hay redirecciona a al cofiguración
    if (!isset($_SESSION['managedStore']) || empty($_SESSION['managedStore']))
    {
        exit(header('Location: setup_tienda.php'));
    }

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
        <title>Dashboard - mayoristapp.mx</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
        <link href="css/styles.css?id=28" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
        <script src="js/funciones.js?id=28"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>

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
                padding: 5px;                
            }

            #segundoBloque
            {
                transition: all 0.5s ease;
                display: none;
            }

            .mybutton 
            {
                position: fixed;
                bottom: 20px;
                /* left: 50%;
                transform: translateX(-50%);  */
                right: 25px;
                
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
                    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-8">
                        <div class="container-xl px-4">
                            <div class="page-header-content pt-4">

                                <nav class="mb-2 rounded" aria-label="breadcrumb">
                                    <a href="mis-articulos.php" class="text-decoration-none">
                                        <button type="button" class="btn btn-outline-white rounded-pill shadow-sm fs-5 fw-300" name="button">
                                            <i class="fas fa-arrow-circle-left me-2 text-decoration-none"></i>
                                            Regresar
                                        </button>
                                    </a>
                                </nav>

                                <div class="row align-items-center justify-content-between">
                                    <div class="col-auto mt-3">
                                        <div class="display-6 text-white sombra-titulos-vendy">
                                            Nuevo artículo
                                        </div>
                                        <div class="text-white-50 fs-4"><small>Registra la información del artículo</small> </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </header>

                    <!-- Main page content-->
                    <div class="container-xl px-4 mt-n10">
                        <form action="procesa.php" id="formulario" method="post" enctype="multipart/form-data">
                            <div class="row">

                                <div class="col-lg-6 col-xl-6 col-xxl-6 mb-4">
                                    <!-- Datos del producto -->
                                    <div class="card card-header-actions mb-3">
                                        
                                        <div class="card-body bg-pattern-white-75 rounded-2">                                          
                                            
                                            <!-- Form Row-->
                                            <div class="row gx-3">
                                                <div class="col-md-12">
                                                    <!-- Form Group (first name)-->
                                                    <div class="mb-3">                                                        
                                                        <label class="small mb-1 fw-600 text-primary" for="inputFirstName">Nombre: <sup>*</sup></label>
                                                        <input class="form-control border border-3 rounded fs-5 fw-400 shadow-none border border-3" id="inputFirstName" type="text" name="nombreProducto" placeholder="Nombre artículo" autocomplete="off" required/>                                                        
                                                    </div>

                                                </div>
                                            </div>                                            

                                            <!-- Descripción -->
                                            <div class="row gx-3">
                                                <div class="col-md-12">
                                                    <!-- Form Group (first name)-->
                                                    <div class="mb-0">
                                                        <label class="small mb-1 fw-600 text-primary" for="inputFirstName">Descripción:</label>
                                                        <textarea class="form-control shadow-none border border-3 rounded" rows="3" cols="90" maxlength="300" name="descripcionProducto" placeholder="(Opcional)"></textarea>
                                                    </div>
                                                </div>
                                            </div>                                            

                                        </div>
                                        
                                    </div>

                                    <div style="display:block;" class="mb-3">
                                        <div class="card card-header-actions h-100">
                                            <div class="card-header">
                                                Multimedia
                                            </div>
                                            <div class="card-body bg-pattern-white-75 rounded-2">
                                            
                                                <!--  -->
                                                <div class="row gx-3">
                                                    <div class="">
                                                        <div class="small mb-2 fw-300">Sólo imágenes jpg, jpeg, png, mp4 y webp</div>                                                        
                                                        <div class="mb-">
                                                            <input type="file" name="imagenProducto[]" id="imagenProducto" onchange="javascript: etiquetaCargaDocumento(this.id);" style="display: none;"  multiple>
                                                            <label for="imagenProducto" id="labelProductoJs" style="cursor: pointer; border: 2px dashed rgb(0, 97, 242);" class="btn btn-transparent btn-lg w-100 rounded-2 text-blue"><i class="fas fa-images me-2"></i> Agregar imágenes</label>
                                                        </div>
                                                    </div>                                                
                                                </div>
                                                <!--  -->
                                            
                                            </div>
                                        </div>
                                    </div>                                                                

                                    <div style="display:block;" id="" class="mb-3">
                                        <div class="card card-header-actions h-100">
                                            <div class="card-header">
                                                Gestión del inventario
                                            </div>
                                            <div class="card-body bg-pattern-white-75 rounded-2">
                                                
                                                <!-- Form Row-->
                                                <div class="row gx-3">
                                                    <div class="col-md-12 mb-3">
                                                        
                                                        <label for="" class="mb-1 fw-300 text-primary small">Código de barras:<sup class="">*</sup></label>                                                                                                                                                                
                                                        
                                                        <div class="d-flex">
                                                            <div class="form-check form-switch ms-2">
                                                                <input class="form-check-input" type="checkbox" name="generarBarcode" value="1" id="generarBarcode" checked>
                                                                <label class="form-check-label fw-400 text-primary text-start ms-2" style="cursor: pointer;" for="generarBarcode">
                                                                    Generar automaticamente
                                                                </label>
                                                            </div>                                                            
                                                        </div>

                                                        <div class="mt-2" id="bloqueCodigoBarras" style="display: none;">
                                                            
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text bg-primary" id="basic-addon1"><i class="text-center text-white fas fa-barcode"></i></span>

                                                                <input class="form-control shadow-none text-center fw-500 fs-4 border border-3"
                                                                        type="text"
                                                                        inputmode="numeric"
                                                                        id="barcode"
                                                                        name="barcode"
                                                                        placeholder="xxxxxx"
                                                                        autocomplete="off"
                                                                        maxlength="28"
                                                                        pattern="[0-9]{6,28}"
                                                                        oninvalid="this.setCustomValidity('El código de barras debe tener al menos 6 dígitos.')"
                                                                        oninput="this.setCustomValidity(this.value.length<6 ? 'Debe tener al menos 6 dígitos tu código de barras.' : '');"
                                                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                                        />
                                                            </div>                                                    
                                                        </div>

                                                    </div>
                                                </div> 

                                                <!-- Form Row-->
                                                <div class="row gx-3">
                                                    <label for="" class="mb-1 fw-300 text-primary small">Unidad de venta:<sup class="">*</sup></label>
                                                    <div class="">

                                                        <select class="form-select bg-success text-white mb-2 rounded-3 shadow-none border border-3 fs-6 fw-600" style="cursor:pointer;" id="selectUnidadVenta" name="unidadVenta" aria-label="Example select with button addon">
                                                            <option value="">Seleccionar</option>
                                                            <option value="Piezas">Pieza</option>
                                                            <!-- <option value="Kilogramos">Kg/Lt</option> -->
                                                        </select>

                                                    </div>
                                                </div>

                                                <div class="row p-1 mt-3" id="inventarioAdicional" style="display: none;">
                                                    
                                                    <!-- Form Row-->
                                                    <div class="row gx-3">
                                                        
                                                        <div class="col-md-6 mb-2">
                                                            <label for="" class="mb-2 fw-300 text-primary small">Inventario actual:<sup class="">*</sup></label>
                                                            <input type="number" class="form-control border border-2 rounded-start" id="inventarioPiezas"     name="inventarioInicialPzs" step="1"   min="0" oninput="validity.valid||(value='');" placeholder="0" style="display:none;">
                                                            <input type="number" class="form-control border border-2 rounded-start" id="inventarioKilogramos" name="inventarioInicialKgs" step=".01" min="0" placeholder="0.00" style="display:none;">
                                                        </div>

                                                        <div class="col-md-6 mb-2">
                                                            <!-- Form Group (first name)-->
                                                            <div class="d-flex">
                                                                <div>
                                                                <label class="small mb-2 fw-300 text-danger" for="inputFirstName">
                                                                <i class="fas fa-bell me-1"></i>
                                                                Alerta Inventario mínimo: <sup>*</sup>                                                                 
                                                                </label>
                                                            
                                                                </div>
                                                                <div class="ms-3">
                                                                    <i data-feather="info" class="text-gray-500 feather-lg" data-bs-toggle="tooltip" data-bs-placement="top" title="Vendy te notificará cuando el inventario llegue a este número o menos."></i> 
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <input type="number" class="form-control border border-2 rounded-start" id="invMinPiezas"     name="inventarioMinimoPzs" step="1"   min="0" oninput="validity.valid||(value='');" placeholder="0"    style="display:none;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Vendy te notificará cuando el inventario llegue a este número o menos.">
                                                                <input type="number" class="form-control border border-2 rounded-start" id="invMinKilogramos" name="inventarioMinimoKgs" step=".01" min="0" oninput="validity.valid||(value='');" placeholder="0.00" style="display:none;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Vendy te notificará cuando el inventario llegue a este número o menos.">
                                                            </div>
                                                        </div>                                                    

                                                    </div>

                                                    <!-- Form Row-->
                                                    <div class="row gx-3" id="isProductoDigital" style="display:none;">
                                                        <div class="col-md-6">
                                                            <label class="small mb-1 fw-600 text-primary" for="inputFirstName">¿Es un producto digital?: </label>
                                                            <div class="input-group mt-2 ms-2">
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input form-check-input-lg" type="checkbox" style="" id="requiereEnvio" name="requiereEnvio" value="1">
                                                                    <label class="form-check-label small" for="reqEnvio" id="requiereEnvioText">&nbsp; No.</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr class="m-2 text-gray-300">
                                                    
                                                    <!-- Form Row-->
                                                    <div class="row gx-3" id="isProductoDigital" style="">
                                                        <div class="col-md-6">
                                                            <label class="small mb-1 fw-600 text-primary" for="inputFirstName">Venta en línea:</label>
                                                            <div class="input-group mt-1 ms-2">

                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input form-check-input-lg" type="checkbox" style="" id="isActiveOnlineStore" name="isActiveOnlineStore" value="1" checked>
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

                                <div class="col-lg-6 col-xl-6 col-xxl-6 mb-2">

                                    <div style="display:block;" class="mb-2">
                                        <div class="card card-header-actions h-100">
                                            <div class="card-header">
                                                Organización
                                            </div>
                                            <div class="card-body bg-pattern-white-75 rounded-2">
                                            
                                                <!--  -->
                                                <div class="row gx-3">
                                                     
                                                    <div class="col-md-12">
                                                        <div class="mb-0">

                                                            <!-- Select para mostrar las categorías existentes -->
                                                            <label for="categorias-ex" class="fw-500 text-primary  mb-1" id="labelCatExistentes"></label><sup>*</sup>
                                                            
                                                            <label id="salidaCategorias"></label>
                                                            
                                                            <!-- <span class="mb-1 small badge bg-pink text-white rounded-pill text-end" data-bs-toggle="modal" data-bs-target="#modalCategorias" data-backdrop="static" data-keyboard="false" style="cursor: pointer;">
                                                                Agregar
                                                            </span> -->

                                                            <select class="form-select bg-success text-white mb-2 rounded-3 shadow-none border border-3 fs-6 fw-600" name="categoriaSeleccionada" id="categorias-existentes">
                                                            </select>

                                                            <div class="mb-1 small text-primary  rounded-pill text-end" data-bs-toggle="modal" data-bs-target="#modalCategorias" data-backdrop="static" data-keyboard="false" style="cursor: pointer;">
                                                                Agregar categoria
                                                            </div>

                                                        </div>
                                                    </div>

                                                </div>
                                            
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Datos del producto -->
                                    <div class="card card-header-actions mb-3">
                                        <div class="card-header">
                                            Precio
                                        </div>
                                        <div class="card-body bg-pattern-white-75 rounded-2">                                          
                                            
                                            <div class="row gx-3">

                                                <div class="col-md-6">
                                                    <label for="" class="mb-2 small fw-600 text-primary">Costo:</label><sup>*</sup>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text rounded-start border border-3 fw-700" id="basic-addon1">$</span>
                                                        <input type="number" class="form-control text-center border border-3 rounded-end fw-500 shadow-none" id="costoProducto" name="costoProducto" placeholder="0.00" pattern="\d*" step="0.01">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="" class="mb-2 small fw-600 text-primary">Precio de venta:</label><sup>*</sup>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text rounded-start border border-3 fw-700" id="basic-addon1">$</span>
                                                        <input type="number" class="form-control text-center border border-3 rounded-end fw-500  shadow-none" id="precioVenta" name="precioVenta" placeholder="0.00" pattern="\d*" step="0.01">
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        
                                            <div id="resultado" class="mb-1 small fw-600 text-success"></div>                                        

                                        </div>

                                        <div class="card-footer text-center text-white bg-danger fw-600" id="advertencia" style="display:none;"></div>

                                    </div>
                                    
                                    <script>
                                                
                                        function calcularGanancia() 
                                        {
                                            var costo = parseFloat(document.getElementById("costoProducto").value);
                                            var venta = parseFloat(document.getElementById("precioVenta").value);
                                            var advertenciaLabel = document.getElementById("advertencia");
                                            if (!isNaN(costo) && !isNaN(venta)) {
                                                var gananciaMoneda = venta - costo;
                                                var margenGanancia = (gananciaMoneda / costo) * 100;

                                                if (gananciaMoneda <= 0) 
                                                {
                                                    var mensaje = "";
                                                    if (gananciaMoneda < 0) 
                                                    {
                                                        mensaje = "Advertencia: ¡Tendrías pérdidas!";
                                                    } 
                                                    else 
                                                    {
                                                        mensaje = "Advertencia: No tendrías ganancias";
                                                    }

                                                    // Mostrar advertencia con etiqueta y icono
                                                    advertenciaLabel.innerHTML = "<span class='fw-600'><i class='icon-feather-alert-circle'></i> " + mensaje + "</span>";
                                                    advertenciaLabel.style.display = "block";
                                                } 
                                                else 
                                                {
                                                    advertenciaLabel.innerHTML = ""; // Borrar la advertencia si la ganancia es positiva
                                                    advertenciaLabel.style.display = "none";
                                                }

                                                document.getElementById("resultado").innerHTML = "Margen de ganancia: <span class='fw-300'>" + margenGanancia.toFixed(2) + "</span> % <br> Ganancia total: $ <span class='fw-300'>" + gananciaMoneda.toFixed(2) + "</span>";
                                            } 
                                            else 
                                            {
                                                document.getElementById("resultado").innerHTML = "";
                                                document.getElementById("advertencia").innerHTML = ""; // Borrar la advertencia si hay campos vacíos o no numéricos
                                                advertenciaLabel.style.display = "none";
                                            }
                                        }

                                        var costoInput = document.getElementById("costoProducto");
                                        var ventaInput = document.getElementById("precioVenta");

                                        costoInput.addEventListener("input", calcularGanancia);
                                        ventaInput.addEventListener("input", calcularGanancia);

                                    </script>
                                    
                                </div>
                                
                            </div>
                            
                            <!-- <button type="submit" onclick="return validarFormulario();" class="btn btn-primary circle flotante rounded-pill fs-400 fs-6 shadow-sm" name="btnAltaProducto">1Guardar</button> -->
                                        
                            <div class="mybutton">
                                <button type="submit" onclick="return validarFormulario();" class="btn btn-primary circle rounded-pill fs-400 fs-6 shadow-sm" name="btnAltaProducto">Registrar producto</button>
                            </div>

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
        <script src="js/ajax.js?id=2828"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js?id=32345"></script>
        <script type="text/javascript">

            cargarCategorias();

            const input = document.querySelector("#barcode");
            const segundoBloque = document.querySelector("#segundoBloque");


            const barcode = document.querySelector("#barcode");

            barcode.addEventListener("input", function() 
            {
                const longitudBarcode = 6;

                if (input.value.length < longitudBarcode) 
                {
                    console.log('Faltan ' + (longitudBarcode - input.value.length));
                    document.getElementById('caracteresFaltantesBarcode').innerHTML = "(Al menos " +longitudBarcode+ " caracteres de longitud, faltan "+ (longitudBarcode - input.value.length) + " dígitos.)";
                } 
                else if (input.value.length === longitudBarcode) 
                {
                    //console.log("ok");
                    document.getElementById('caracteresFaltantesBarcode').innerHTML = "";
                    const barcodePattern = new RegExp("^[0-9]{" + longitudBarcode + "}$");
                    if (!barcodePattern.test(input.value)) 
                    {
                        document.getElementById('caracteresFaltantesBarcode').innerHTML = "El código de barras debe tener " + longitudBarcode + " dígitos y sólo números. ";
                        Swal.fire({
                        title: 'Error',
                        text: 'El código de barras debe tener ' + longitudBarcode + ' dígitos y sólo números.',
                        icon: 'warning',
                        confirmButtonText: 'Entendido'
                        });
                    }
                } 
                else 
                {
                    console.log('Te pasaste: ' + (input.value.length - longitudBarcode));
                }
            });

            input.addEventListener("input", function()
            {
                if (input.value === "")
                {
                    segundoBloque.style.display = "none";
                }
                else
                {
                    segundoBloque.style.display = "block";
                }
            });

            const generarBarcode = document.querySelector("#generarBarcode");

            generarBarcode.addEventListener("change", function()
            {
                if (generarBarcode.checked)
                {
                    // input.disabled = true;
                    bloqueCodigoBarras.style.display = "none";
                    document.getElementById('caracteresFaltantesBarcode').innerHTML =  "";
                }
                else
                {
                    // input.disabled = false;
                    bloqueCodigoBarras.style.display = "block";
                    input.value = "";
                    document.getElementById('caracteresFaltantesBarcode').innerHTML =  "";
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

            // Prevent submit on enter (scanner)
            $(document).on('keyup keypress', 'form input[type="text"]', function(e)
            {
                if(e.keyCode == 13)
                {
                    e.preventDefault();
                    return false;
                }
            });


        </script>

    </body>
</html>
<?php
  if (file_exists('src/triggers.php'))
  {
      include 'src/triggers.php';
  }
?>
