<?php
    session_start();
    require '../app/php/conexion.php'; //configuración conexión db
    require 'php/funciones.php'; //configuración conexión db

    if (isset($_SESSION['email'], $_SESSION['managedStore']))
    {
        $email    = $_SESSION['email'];
        $idTienda = $_SESSION['managedStore'];
    }

    $hasActivePayment = validarPagoActivo($conn, $idTienda);

    $enviosTienda    = getEnviosTiendaConfig($conn, $idTienda);
    $hasActivePickup = validarPickupTienda($conn, $idTienda);
    
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Vendy - Configuración</title>
        <link href="css/styles.css?id=33" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <style type="text/css">
        .accordion-button:after
        {
            /* background-image: url("data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23ffffff'><path fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/></svg>") !important; */
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
                    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
                        <div class="container-xl px-4">
                            <div class="page-header-content">
                                <div class="row align-items-center justify-content-between pt-3">
                                    <div class="col-auto mb-3">
                                        <h1 class="page-header-title">
                                            <div class="page-header-icon"><i data-feather="settings"></i></div>
                                            Configura tu tienda
                                        </h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </header>
                    <!-- Main page content-->
                    <div class="container-xl px-4 mt-4">
                        <!-- Account page navigation-->
                        <?php
                            include 'src/menuConfiguracion.php';
                        ?>
                        <hr class="mt-0 mb-4" />

                        <button type="submit" class="btn btn-primary circle fw-600 flotante rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#modalNuevoEnvio" name="btnAddCart">
                            <i class="fas fa-truck me-1 text-white-75"></i> Nuevo envío
                        </button>

                        <div class="accordion" id="accordionExample">
                          <div class="accordion-item shadow-sm">
                              <h2 class="accordion-header " id="headingOne">
                                <button class="accordion-button bg-white text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                  <i class="fas fa-people-carry me-1"></i> Pick Up en sucursal
                                </button>
                              </h2>
                              <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                              <div class="accordion-body bg-light">
                                  <div class="row my-4 mx-2">
                                      <span class="mb-2 fw-600 text-primary">Activa/Desactiva la recolección de los pedidos en sucursal.</span>
                                      <div class="form-check mx-2">

                                          <form class="" id="" action="procesa.php" method="post">
                                              <input class="form-check-input" type="checkbox" id="allowPickup" name="allowPickup" value="1" <?php echo ($hasActivePickup === true ? "checked" : ""); ?>>
                                              <button type="submit" style="display: none;" id="btnAllowPickup" name="btnAllowPickup"></button>
                                          </form>
                                          <label class="form-check-label" style="cursor: pointer;" for="allowPickup">Sí, permitir al cliente recolectar su pedido en sucursal.</label>

                                      </div>
                                  </div>
                              </div>
                            </div>
                          </div>
                          <div class="accordion-item shadow-sm">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button bg-white text-primary collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <i class="fas fa-globe me-1"></i> Tienda en línea
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body bg-white card-waves">
                                    <div class="row my-2 mx-2">
                                    <?php

                                    if ($enviosTienda)
                                    {
                                        $anterior = "";
                                        foreach ($enviosTienda as $key => $envio)
                                        {
                                            ?>
                                            <div class="col-lg-6 col-xl-4 mb-4 mt-2">
                                                <div class="card bg-white text-dark h-100 card-angles">
                                                    <div class="modal-header-sm">
                                                        <span class="small" id="datosBancariosTiendaLabel">
                                                              <?php echo ucwords($envio['nombre']); ?>
                                                        </span>

                                                        <div class="dropdown no-caret">

                                                            <button class="btn btn-transparent-dark btn-icon btn-sm dropdown-toggle" id="dropdownMenuButton" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fas fa-ellipsis-v"></i>
                                                            </button>

                                                            <div class="dropdown-menu dropdown-menu-end animated--fade-in-up" aria-labelledby="dropdownMenuButton">
                                                                <a class="dropdown-item" href="#!" onclick="javascript: sendToDeleteDeliveryModal('<?php echo $envio['id']; ?>,<?php echo $envio['nombreEnvio']; ?>')" class="text-success small" data-bs-toggle="modal" data-bs-target="#modalEliminarEnvio">
                                                                    <div class="dropdown-item-icon"><i class="text-gray-500" data-feather="minus-circle"></i></div>
                                                                    Eliminar
                                                                </a>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="me-3">

                                                                <div class="fw-600 fs-5 text-dark">
                                                                    <?php echo ucwords($envio['nombreEnvio']); ?>
                                                                    <p>
                                                                    <?php
                                                                        if ($envio['precioEnvio'] == 0)
                                                                        {
                                                                            echo "<span class='fw-300'>GRATIS</span>";
                                                                        }
                                                                        elseif ($envio['precioEnvio'] >= 1)
                                                                        {
                                                                            echo "<span class='fw-300'>$ " . number_format($envio['precioEnvio'], 2) . "</span>";
                                                                        }
                                                                        else
                                                                        {
                                                                            echo "0.0";
                                                                        }

                                                                    ?>
                                                                    </p>
                                                                </div>

                                                            </div>
                                                            <div class="text-blue opacity-25">
                                                                <i class="fas fa-truck fa-xl opacity-2"></i>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="card-footer small bg-primary text-white">
                                                        Aceptado:
                                                        <?php echo ($envio['hasOnlinePayment']   == 1) ? "<span class='badge bg-transparent border border-white border-1 text-white'>En línea</span>" : ""; ?>
                                                        <?php echo ($envio['hasDeliveryPayment'] == 1) ? "<span class='badge bg-transparent border border-white border-1 text-white'>A la entrega</span>" : ""; ?>
                                                    </div>
                                                </div>
                                            </div>


                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        echo "No hay envíos registrados.";
                                    }

                                    ?>
                                </div>
                            </div>
                          </div>

                          <!-- modal eliminar pago Inicio-->
                          <div class="modal fade" id="modalEliminarEnvio" tabindex="-1" aria-labelledby="modalEliminarEnvioLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <h5 class="modal-title" id="modalEliminarEnvioLabel">Confirmación</h5>
                                          <button type="button" class="btn btn-icon btn-outline-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">
                                              <i class="fa-solid fa-xmark fa-xl"></i>
                                          </button>
                                      </div>

                                      <form class="" action="procesa.php" method="post">
                                          <div class="modal-body">
                                              Estás a punto de eliminar el envío "<span id="deliveryNameToDelete" class="fw-600"></span>". ¿Deseas continuar?
                                              <input type="hidden" id="idToDeleteEnvio" name="idToDeleteDelivery" required>
                                          </div>
                                          <div class="modal-footer">

                                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                  Cancelar
                                              </button>
                                              <button type="submit" class="btn btn-danger" name="btnEliminarEnvio">
                                                  Sí, eliminar
                                              </button>

                                          </div>
                                    </form>
                                  </div>
                              </div>
                          </div>
                          <!-- modal eliminar pago Fin -->

                          <!-- <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Accordion Item #3
                              </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                              <div class="accordion-body">
                                <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                              </div>
                            </div>
                          </div> -->

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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.17.1/components/prism-core.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.17.1/plugins/autoloader/prism-autoloader.min.js" crossorigin="anonymous"></script>

        <script type="text/javascript">

            // enviar id a modal para eliminar envio
            function sendToDeleteDeliveryModal(data)
            {
                // alert(data);
                // return false;
                var valores = data.split(",");
                console.log(valores);
                //var info = "banco,numerodetarjeta,clabe";
                document.getElementById("idToDeleteEnvio").value  = valores[0];
                document.getElementById("deliveryNameToDelete").innerHTML  = valores[1];
                console.log('ok');
            }

            // Modal al presionar el checkbox
            document.querySelector('#allowPickup').addEventListener('click', function()
            {
                Swal.fire({
                    title: 'Cargando...',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    html: '<i class="fas fa-spinner fa-spin fa-3x mb-3"></i><br><p>Espere por favor</p>',
                    onBeforeOpen: () =>
                    {
                        Swal.showLoading();
                    }
                });
                document.querySelector('#btnAllowPickup').click();
            });

            // Submit "permitir al cliente recolectar su pedido en sucursal"
            document.getElementById("allowPickup").addEventListener("change", function()
            {
                document.getElementById("btnAllowPickup").click();
            });

            //
            $("#formNuevoEnvio").submit(function(e){
               var checkboxes = $("input[type='checkbox']");
               var checked = false;
               checkboxes.each(function(){
                   if($(this).is(":checked"))
                   {
                       checked = true;
                       return false;
                   }
               });
               if(!checked){
                   e.preventDefault();
                   swal.fire("Error", "Debe seleccionar al menos un checkbox", "warning");
               }
            });

        </script>
        <?php
          if (file_exists('src/triggers.php'))
          {
            include 'src/triggers.php';
          }
        ?>
    </body>
</html>
