<?php
    session_start();
    require 'php/conexion_db.php'; //configuración conexión db
    require 'php/funciones.php'; //configuración conexión db

    if (isset($_SESSION['email'], $_SESSION['managedStore']))
    {
        $email    = $_SESSION['email'];
        $idTienda = $_SESSION['managedStore'];
    }

    $enviosTienda  = getEnviosTiendaConfig($conn, $idTienda);
    $hasActivePickup = validarPickupTienda($conn, $idTienda);
    $hasActivePayment  = validarPagoActivo($conn, $idTienda);
    $mediosContacto = getMediosContactoVendedor($conn, $idTienda);
    $listMediosContactoDisponibles = getListadoMediosContactoDisponible($conn, $idTienda);
    // echo "<pre>";
    // print_r($mediosContacto);
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
        <title>Vendy - Configuración</title>
        <link href="css/styles.css?id=33" rel="stylesheet" />
        <!-- <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" /> -->
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <style type="text/css">

            .accordion-button:after
            {
                /* background-image: url("data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23ffffff'><path fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/></svg>") !important; */
            }
            /*
                Auther: Abdelrhman Said
            */

            @import url("https://fonts.googleapis.com/css2?family=Poppins&display=swap");

            * {
              margin: 0;
              padding: 0;
              box-sizing: border-box;
            }

            *:focus,
            *:active {
              outline: none !important;
              -webkit-tap-highlight-color: transparent;
            }


            .wrapper {
              display: inline-flex;
              list-style: none;
              font-family: "Poppins", sans-serif;
              place-items: center;
            }

            .wrapper .icon {
              position: relative;
              background: #ffffff;
              border-radius: 50%;
              padding: 15px;
              margin: 10px;
              width: 50px;
              height: 50px;
              font-size: 18px;
              display: flex;
              justify-content: center;
              align-items: center;
              flex-direction: column;
              box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1);
              cursor: pointer;
              transition: all 0.2s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            }

            .wrapper .tooltip {
              position: absolute;
              top: 0;
              font-size: 14px;
              background: #ffffff;
              color: #ffffff;
              padding: 5px 8px;
              border-radius: 5px;
              box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1);
              opacity: 0;
              pointer-events: none;
              transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            }

            .wrapper .tooltip::before {
              position: absolute;
              content: "";
              height: 8px;
              width: 8px;
              background: #ffffff;
              bottom: -3px;
              left: 50%;
              transform: translate(-50%) rotate(45deg);
              transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            }

            .wrapper .icon:hover .tooltip {
              top: -45px;
              opacity: 1;
              visibility: visible;
              pointer-events: auto;
            }

            .wrapper .icon:hover span,
            .wrapper .icon:hover .tooltip {
              text-shadow: 0px -1px 0px rgba(0, 0, 0, 0.1);
            }

            .wrapper .facebook:hover,
            .wrapper .facebook:hover .tooltip,
            .wrapper .facebook:hover .tooltip::before {
              background: #1877F2;
              color: #ffffff;
            }

            .wrapper .twitter:hover,
            .wrapper .twitter:hover .tooltip,
            .wrapper .twitter:hover .tooltip::before {
              background: #1DA1F2;
              color: #ffffff;
            }

            .wrapper .instagram:hover,
            .wrapper .instagram:hover .tooltip,
            .wrapper .instagram:hover .tooltip::before {
              background: #E4405F;
              color: #ffffff;
            }

            .wrapper .whatsapp:hover,
            .wrapper .whatsapp:hover .tooltip,
            .wrapper .whatsapp:hover .tooltip::before {
              background: #16bd38;
              color: #ffffff;
            }

            .wrapper .youtube:hover,
            .wrapper .youtube:hover .tooltip,
            .wrapper .youtube:hover .tooltip::before {
              background: #CD201F;
              color: #ffffff;
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
                        <nav class="nav nav-borders">
                            <a class="nav-link active ms-0" href="configura-tienda.php">General</a>
                            <a class="nav-link" href="configura-pagos.php">Pagos</a>
                            <a class="nav-link" href="configura-envios.php">Envíos</a>
                            <!-- <a class="nav-link" href="account-security.html">Security</a>
                            <a class="nav-link" href="account-notifications.html">Notifications</a> -->
                        </nav>
                        <hr class="mt-0 mb-4" />
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item shadow-sm">
                                <h2 class="accordion-header " id="headingOne">
                                  <button class="accordion-button bg-primary text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <i class="fas fa-headset me-1"></i> Medios de contacto
                                  </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body bg-pattern-white-75 opacity-1">

                                        <div class="row my-4 mx-2">

                                                <?php

                                                $fb_icon = false;
                                                $ig_icon = false;
                                                $wa_icon = false;
                                                $yt_icon = false;
                                                $tel_icon = false;
                                                $email_icon = false;

                                                // Itero el resultado para ver si tiene lo sig
                                                if ($mediosContacto)
                                                {
                                                    foreach ($mediosContacto as $key => $contacto)
                                                    {
                                                        switch ($contacto['alias'])
                                                        {
                                                            case 'FACEBOOK':
                                                                $fb_icon['data'] = $contacto['data'];
                                                                $fb_icon['id']   = $contacto['id'];
                                                                break;
                                                            case 'INSTAGRAM':
                                                                $ig_icon['data'] = $contacto['data'];
                                                                $ig_icon['id']   = $contacto['id'];
                                                                break;
                                                            case 'WHATSAPP':
                                                                $wa_icon['data'] = $contacto['data'];
                                                                $wa_icon['id']   = $contacto['id'];
                                                                break;
                                                            case 'YOUTUBE':
                                                                $yt_icon['data'] = $contacto['data'];
                                                                $yt_icon['id']   = $contacto['id'];
                                                                break;
                                                            case 'TELEFONO':
                                                                $tel_icon['data'] = $contacto['data'];
                                                                $tel_icon['id']   = $contacto['id'];
                                                                break;
                                                            case 'EMAIL':
                                                                $email_icon['data'] = $contacto['data'];
                                                                $email_icon['id']   = $contacto['id'];
                                                                break;
                                                        }
                                                    }
                                                }
                                                ?>

                                                <div class="mb-3">
                                                    <h1 class="font-poppins fw-300">Contacto</h1>
                                                    <!-- Contacto -->
                                                    <div class="table-responsive">
                                                        <table class="table table-hover">
                                                            <thead>
                                                                <tr class="small fw-200 text-dark">
                                                                    <td>Cuenta</td>
                                                                    <td>Dato</td>
                                                                    <td>Acciones</td>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <i data-feather="phone" class="feather-lg text-orange"></i>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo isset($tel_icon['data']) ? $tel_icon['data'] : " - "; ?>
                                                                    </td>
                                                                    <td>
                                                                        <button type="button" class="btn btn-green rounded-pill btn-sm" name="button" data-bs-toggle="modal" data-bs-target="#modalTelefonoTienda">
                                                                            <i class="fas fa-pencil-alt me-1"></i> Editar
                                                                        </button>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>
                                                                        <i class="fa-xl far fa-envelope text-cyan"></i>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo isset($email_icon['data']) ? $email_icon['data'] : " - "; ?>
                                                                    </td>
                                                                    <td>
                                                                        <button type="button" class="btn btn-green rounded-pill btn-sm" name="button" data-bs-toggle="modal" data-bs-target="#modalEmailTienda">
                                                                            <i class="fas fa-pencil-alt me-1"></i> Editar
                                                                        </button>
                                                                    </td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <!-- Contacto -->
                                                </div>

                                                <div class="mb-3">
                                                    <h1 class="font-poppins fw-300">Social</h2>
                                                    <!-- social icons -->
                                                    <div class="table-responsive">
                                                        <table class="table table-hover">
                                                        <thead>
                                                            <tr class="small fw-200 text-dark">
                                                            <td>Cuenta</td>
                                                            <td>Dato</td>
                                                            <td>Acciones</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <tr>
                                                                <td>
                                                                    <i class="fa-xl fab fa-facebook text-blue"></i>
                                                                </td>
                                                                <td>
                                                                    <?php echo isset($fb_icon['data']) ? $fb_icon['data'] : " - "; ?>
                                                                </td>
                                                                <td>
                                                                    <button type="button" class="btn btn-green rounded-pill btn-sm" name="button" data-bs-toggle="modal" data-bs-target="#modalFacebookTienda">
                                                                        <i class="fas fa-pencil-alt me-1"></i> Editar
                                                                    </button>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td>
                                                                    <i class="fa-xl fab fa-whatsapp text-green"></i>
                                                                </td>
                                                                <td>
                                                                    <?php echo isset($wa_icon['data']) ? $wa_icon['data'] : " - "; ?>
                                                                </td>
                                                                <td>
                                                                    <button type="button" class="btn btn-green rounded-pill btn-sm" name="button" data-bs-toggle="modal" data-bs-target="#modalWhatsappTienda">
                                                                        <i class="fas fa-pencil-alt me-1"></i> Editar
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                            <td>
                                                                <i class="fa-xl fab fa-instagram text-pink"></i>
                                                            </td>
                                                            <td>
                                                                <?php echo isset($ig_icon['data']) ? $ig_icon['data'] : " - "; ?>
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-green rounded-pill btn-sm" name="button" data-bs-toggle="modal" data-bs-target="#modalInstagramTienda">
                                                                    <i class="fas fa-pencil-alt me-1"></i> Editar
                                                                </button>
                                                            </td>
                                                            </tr>

                                                            <tr>
                                                                <td>
                                                                    <i class="fa-xl fab fa-youtube text-danger"></i>
                                                                </td>
                                                                <td>
                                                                    <?php echo isset($yt_icon['data']) ? $yt_icon['data'] : " - "; ?>
                                                                </td>
                                                                <td>
                                                                    <button type="button" class="btn btn-green rounded-pill btn-sm" name="button" data-bs-toggle="modal" data-bs-target="#modalYoutubeTienda">
                                                                        <i class="fas fa-pencil-alt me-1"></i> Editar
                                                                    </button>
                                                                </td>
                                                            </tr>

                                                        </tbody>
                                                        </table>
                                                    </div>                                                
                                                    <!-- social icons -->
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </main>

                <!-- Modal Telefono -->
                <div class="modal fade" id="modalTelefonoTienda"  tabindex="-1" aria-labelledby="modalTelefonoTiendaLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">
                              <i class="fa-lg fas fa-phone text-primary"></i> Teléfono
                          </h5>
                          <button type="button" class="btn btn-sm btn-outline-primary rounded-pill btn-sm" data-bs-dismiss="modal" aria-label="Close">
                              <i class="fas fa-times fa-xl"></i>
                          </button>
                      </div>
                      <div class="modal-body">
                          <form class="" action="procesa.php" method="post">
                              <input type="tel" name="telTienda" class="form-control rounded-2 mb-2 text-center" value="<?php echo isset($tel_icon['data']) ? $tel_icon['data'] : ''; ?>" placeholder="10 dígitos" name="telTienda" title="10 Dígitos" pattern="[1-9]{1}[0-9]{9}" required>
                              <div class="text-end">
                                  <button type="submit" class="btn btn-outline-primary" name="btnSaveTelTienda">
                                      Guardar <i class="far fa-check-circle ms-1"></i>
                                  </button>
                              </div>
                          </form>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Modal Email -->
                <div class="modal fade" id="modalEmailTienda"  tabindex="-1" aria-labelledby="modalEmailTiendaLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">
                              <i class="fa-lg fas fa-envelope  text-primary"></i> Email
                          </h5>
                          <button type="button" class="btn btn-sm btn-outline-primary rounded-pill btn-sm" data-bs-dismiss="modal" aria-label="Close">
                              <i class="fas fa-times fa-xl"></i>
                          </button>
                      </div>
                      <div class="modal-body">
                          <form class="" action="procesa.php" method="post">
                              <input type="email" class="form-control rounded-2 mb-2 text-center" value="<?php echo isset($email_icon['data']) ? $email_icon['data'] : ''; ?>" placeholder="correo@gmail.com" name="emailTienda" required>
                              <div class="text-end">
                                  <button type="submit" class="btn btn-outline-primary" name="btnGuardarEmailTienda">
                                      Guardar <i class="far fa-check-circle ms-1"></i>
                                  </button>
                              </div>
                          </form>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Modal facebook -->
                <div class="modal fade" id="modalFacebookTienda"  tabindex="-1" aria-labelledby="modalFacebookTiendaLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">
                                    <i class="fa-lg fab fa-facebook  text-primary"></i> Facebook
                                </h5>
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill btn-sm" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="fas fa-times fa-xl"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form class="" action="procesa.php" method="post">
                                    <input type="text" class="form-control rounded-2 mb-2 text-center" value="<?php echo isset($fb_icon['data']) ? $fb_icon['data'] : ''; ?>" placeholder="https://facebook.com/enlace-a-tu-página" name="facebookTienda" required>
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-outline-primary" name="btnGuardarFacebookTienda">
                                            Guardar <i class="far fa-check-circle ms-1"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal instagram -->
                <div class="modal fade" id="modalInstagramTienda" tabindex="-1" aria-labelledby="modalInstagramTiendaLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">
                              <i class="fa-lg fab fa-instagram text-pink"></i> Instagram
                          </h5>
                          <button type="button" class="btn btn-sm btn-outline-primary rounded-pill btn-sm" data-bs-dismiss="modal" aria-label="Close">
                              <i class="fas fa-times fa-xl"></i>
                          </button>
                      </div>
                      <div class="modal-body">
                          <form class="" action="procesa.php" method="post">
                              <input type="text" class="form-control rounded-2 mb-2 text-center" value="<?php echo isset($ig_icon['data']) ? $ig_icon['data'] : ''; ?>" placeholder="https://instagram.com/enlace-a-tu-cuenta" name="instagramTienda" required>
                              <div class="text-end">
                                  <button type="submit" class="btn btn-outline-primary" name="btnGuardarInstagramTienda">
                                      Guardar <i class="far fa-check-circle ms-1"></i>
                                  </button>
                              </div>
                          </form>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Modal whatsapp ready -->
                <div class="modal fade" id="modalWhatsappTienda"  tabindex="-1" aria-labelledby="modalWhatsappTiendaLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">
                              <i class="fa-lg fab fa-whatsapp text-green"></i> Whatsapp
                          </h5>
                          <button type="button" class="btn btn-sm btn-outline-primary rounded-pill btn-sm" data-bs-dismiss="modal" aria-label="Close">
                              <i class="fas fa-times fa-xl"></i>
                          </button>
                      </div>
                      <div class="modal-body">

                          <form class="" action="procesa.php" method="post">
                              <input type="text" class="form-control text-center rounded-2 mb-2" value="<?php echo isset($wa_icon['data']) ? $wa_icon['data'] : ''; ?>" placeholder="10 dígitos" title="10 Dígitos" pattern="[1-9]{1}[0-9]{9}" name="whatsappTienda" required>
                              <div class="text-end">
                                  <button type="submit" class="btn btn-outline-primary" name="btnGuardarWhatsappTienda">
                                      Guardar <i class="far fa-check-circle ms-1"></i>
                                  </button>
                              </div>
                          </form>

                      </div>
                    </div>
                  </div>
                </div>

                <!-- Modal youtube ready -->
                <div class="modal fade" id="modalYoutubeTienda"   tabindex="-1" aria-labelledby="modalYoutubeTiendaLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">
                              <i class="fa-lg fab fa-youtube text-red"></i> Youtube
                          </h5>
                          <button type="button" class="btn btn-sm btn-outline-primary rounded-pill btn-sm" data-bs-dismiss="modal" aria-label="Close">
                              <i class="fas fa-times fa-xl"></i>
                          </button>
                      </div>
                      <div class="modal-body">
                          <form class="" action="procesa.php" method="post">
                              <input type="text" class="form-control rounded-2 mb-2 text-center" value="<?php echo isset($yt_icon['data']) ? $yt_icon['data'] : ''; ?>" placeholder="https://youtube.com/enlace-a-tu-canal" name="youtubeTienda" required>
                              <div class="text-end">
                                  <button type="submit" class="btn btn-outline-primary" name="btnGuardarYoutubeTienda">
                                      Guardar <i class="far fa-check-circle ms-1"></i>
                                  </button>
                              </div>
                          </form>
                      </div>
                    </div>
                  </div>
                </div>

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
