<?php
    session_start();
    require '../app/php/conexion.php'; //configuración conexión db
    require 'php/funciones.php'; //configuración conexión db

    if (isset($_SESSION['email'], $_SESSION['managedStore']))
    {
        $email    = $_SESSION['email'];
        $idTienda = $_SESSION['managedStore'];
    }

    $metodosDePagoTienda = getMetodosDePagoTienda($conn, $idTienda);
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
        <title>Configura tus pagos</title>
        <link href="css/styles.css?id=5" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
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
                    <button type="submit" class="btn btn-success fw-600 circle flotante rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#modalNuevoPago" name="btnAddCart">
                        <i class="fas fa-wallet me-1 text-white-75"></i> Nuevo pago
                    </button>

                    <div class="container-xl px-4 mt-4">
                        <!-- Account page navigation-->
                        <?php
                            include 'src/menuConfiguracion.php';
                        ?>
                        <hr class="mt-0 mb-4" />
                        <div class="row">

                            <?php
                            if ($metodosDePagoTienda)
                            {
                                foreach ($metodosDePagoTienda as $key => $pago)
                                {
                                    // echo "<pre>";
                                    // print_r($pago);
                                ?>
                                    <div class="col-lg-6 col-xl-4 mb-4 mt-2">
                                        <div class="card bg-white text-dark h-100 card-angles">

                                            <div class="modal-header-sm">
                                                <span class="small" id="datosBancariosTiendaLabel">
                                                      <?php echo ucwords($pago['nombre']); ?>
                                                </span>

                                                <div class="dropdown no-caret">

                                                    <button class="btn btn-transparent-dark btn-icon btn-sm dropdown-toggle" id="dropdownMenuButton" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>

                                                    <div class="dropdown-menu dropdown-menu-end animated--fade-in-up" aria-labelledby="dropdownMenuButton">
                                                        <?php
                                                            $mp  = mb_strtoupper($pago['banco']);
                                                            $mp .= "," . $pago['clabe'];
                                                            $mp .= "," . $pago['numeroTarjeta'];
                                                            $mp .= "," . $pago['id'];

                                                            $terminacion = substr($pago['numeroTarjeta'], -4);

                                                            if (!isset($pago['urlPago']) && ($pago['idMetodoDePago'] == "TRANSFER"))
                                                            {
                                                                ?>
                                                                <a class="dropdown-item" href="javascript: void(0);" onclick="javascript: enviaModal('<?php echo $mp; ?>')" class="text-success small" data-bs-toggle="modal" data-bs-target="#datosBancariosTienda">
                                                                    <div class="dropdown-item-icon"><i class="text-gray-500" data-feather="edit-3"></i></div>
                                                                    Editar
                                                                </a>
                                                                <?php
                                                            }
                                                        ?>

                                                        <a class="dropdown-item" href="#!" onclick="javascript: sendToDeleteModal('<?php echo $pago['id'] . "," . $pago['nombreMP']; ?>')" class="text-success small" data-bs-toggle="modal" data-bs-target="#modalEliminarPago">
                                                            <div class="dropdown-item-icon"><i class="text-gray-500" data-feather="minus-circle"></i></div>
                                                            Eliminar
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="me-3">

                                                        <div class="fw-600 fs-5 text-indigo">
                                                            <?php echo ucwords($pago['nombreMP']); ?>
                                                        </div>

                                                        <?php
                                                            if (isset($pago['urlPago']) && ($pago['idMetodoDePago'] == "PP" || $pago['idMetodoDePago'] == "MP"))
                                                            {
                                                                ?>
                                                                <div class="">
                                                                    <a class="text-primary small" href="<?php echo $pago['urlPago']; ?>" target="_blank">Ver link <i class="fas fa-link"></i></a>
                                                                </div>
                                                                <?php
                                                            }

                                                            if (!isset($pago['urlPago']) && ($pago['idMetodoDePago'] == "TRANSFER"))
                                                            {
                                                                ?>
                                                                <div class="">
                                                                    <!-- Button trigger modal -->
                                                                    <span class="small text-success fw-600"><?php echo "****" . $terminacion; ?></span>
                                                                    <a href="javascript: void(0);" onclick="javascript: enviaModal('<?php echo $mp; ?>')" class="text-success small" data-bs-toggle="modal" data-bs-target="#datosBancariosTienda">
                                                                        <i class="far fa-eye"></i>
                                                                    </a>
                                                                </div>
                                                                <?php
                                                            }
                                                        ?>

                                                    </div>
                                                    <div class="display-6 text-blue opacity-25">
                                                        <?php echo $pago['icono']; ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card-footer small bg-primary text-white">
                                                Aceptado:
                                                <?php echo ($pago['hasOnlinePayment']   == 1) ? "<span class='badge bg-transparent border border-white border-1 text-white'>En línea</span>" : ""; ?>
                                                <?php echo ($pago['hasDeliveryPayment'] == 1) ? "<span class='badge bg-transparent border border-white border-1 text-white'>A la entrega</span>" : ""; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                            }
                            else
                            {
                                echo "No hay métodos de pago registrados.";
                            }
                            ?>

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


        <!-- modal nuevo pago Inicio-->
        <div class="modal fade" id="modalNuevoPago" tabindex="-1" aria-labelledby="modalNuevoPagoLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-gray-600" id="modalNuevoPagoLabel"><i class="fas fa-wallet opacity-50"></i> Nuevo método de pago</h5>
                        <button type="button" class="btn btn-icon btn-outline-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa-solid fa-xmark fa-xl"></i>
                        </button>
                    </div>
                    <form class="" id="formNuevoPago" action="procesa.php" method="post">
                        <div class="modal-body">

                            <!-- Pago aceptado -->
                            <div class="mb-3">
                                <label class="small mb-1 text-primary fw-500" for="inputNombreEnvio">Quiero aceptar pagos a través de:</label>
                                <?php
                                    // Query to select idMetodoDePago from metodosDePagoTienda
                                    $query1 = "SELECT idMetodoDePago FROM metodosDePagoTienda WHERE idTienda = '$idTienda'";
                                    $result1 = mysqli_query($conn, $query1);

                                    // Create an array to store the idMetodoDePago
                                    $metodosDePagoTienda = array();

                                    // Store the idMetodoDePago in the array
                                    while ($row = mysqli_fetch_assoc($result1))
                                    {
                                        $metodosDePagoTienda[] = $row['idMetodoDePago'];
                                    }

                                    // Query to select all idMetodoDePago and nombre from CAT_metodoDePago
                                    $query2  = "SELECT * FROM CAT_metodoDePago WHERE idMetodoDePago NOT IN ('" . implode("','", $metodosDePagoTienda) . "') OR idMetodoDePago = 'TRANSFER'";
                                    $result2 = mysqli_query($conn, $query2);

                                    // Create a select element
                                    echo "<select class='form-select mb-3' id='metodoDePago' name='idMetodoDePago' required>";
                                    echo "<option value=''>Seleccionar</option>";
                                    // Add options to the select element
                                    while ($row = mysqli_fetch_assoc($result2))
                                    {
                                        echo "<option hasonlinepayment='". $row['hasOnlinePayment'] ."' hasdeliverypayment='". $row['hasDeliveryPayment'] ."' value='" . $row['idMetodoDePago'] . "'>" . $row['nombre'] . "</option>";
                                    }

                                    // Close the connection
                                    mysqli_close($conn);

                                    // Close the select element
                                    echo "</select>";
                                ?>
                                <div class="mb-3 p-2">
                                    <span id="paymentStatus" class="small mb-1" for=""></span>
                                </div>

                                <div class="rounded-2 bg-gray-100 rounded p-4" id="fondoDatosAdicionales" style="display: none;">
                                    <!-- URL PAGO -->
                                    <label for="urlPago" id="labelUrlPago" class="text-primary small fw-600 mb-1" style="display:none;">Link de pago</label>
                                    <input type="text" id="urlPago" class="form-control mb-2" style="display: none;" name="urlPago" placeholder="https://linkdepago.com/tu_usuario" value="">

                                    <!-- DATOS BANCARIOS -->
                                    <label for="banco" id="labelBanco" class="text-primary small fw-600 mb-1" style="display:none;">Banco</label>
                                    <input type="text" id="banco" class="form-control mb-2" style="display: none;" name="banco" placeholder="Banco">

                                    <label for="numeroTarjeta" id="labelNumeroTarjeta" class="text-primary small fw-600 mb-1" style="display:none;">Número de tarjeta</label>
                                    <input type="number" id="numeroTarjeta" pattern="^[0-9]{16}$" title="16 Digitos" class="form-control mb-2" style="display: none;" name="numeroTarjeta" placeholder="Número de tarjeta" pattern="\d*">

                                    <label for="clabe" id="labelClabe" class="text-primary small fw-600 mb-1" style="display:none;">Clabe bancaria</label>
                                    <input type="number" id="clabe" pattern="^[0-9]{18}$" title="18 Digitos" class="form-control mb-2" style="display: none;" name="clabe" placeholder="(18 Digitos)">

                                    <label for="beneficiario" id="labelBeneficiario" class="text-primary small fw-600 mb-1" style="display:none;">Beneficiario</label>
                                    <input type="text"  id="beneficiario" class="form-control mb-2" style="display: none;" name="beneficiario"  placeholder="Nombre y apellidos" >
                                </div>

                            </div>

                            <!-- Form Group (email address)-->
                            <div class="mb-3">
                                <label class="small mb-1 text-primary fw-500" for="inputNombreEnvio">Alias</label> <span style="font-size: 11px;" class="small text-gray-600">(Este dato sólo lo verás tú)</span>
                                <input class="form-control" type="text" id="inputNombreEnvio" pattern="\S(?:\s*\S){2}.*\S" title="Al menos 4 letras" name="nombreEnvio" placeholder="Cuenta principal, Paypal Principal, etc ..."  autocomplete="off" required />
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success" name="btnGuardarPago">Guardar pago</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- modal nuevo pago Fin -->

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script type="text/javascript">

            // Validar tipo de pago y mostrar campos de acuerdo a ello
            const metodoDePago = document.getElementById('metodoDePago');
            metodoDePago.addEventListener("change", function()
            {
                var selectedValue = this.value;
                console.log(selectedValue);

                const label = document.getElementById('paymentStatus');
                const selectedOption     = this.options[this.selectedIndex];
                const hasOnlinePayment   = selectedOption.getAttribute('hasonlinepayment') === '1';
                const hasDeliveryPayment = selectedOption.getAttribute('hasdeliverypayment') === '1';

                label.innerHTML = '';
                label.innerHTML = 'Aceptado: ';

                if (hasOnlinePayment)
                {
                    label.innerHTML = label.innerHTML + '<span class="small bg-success text-white rounded-pill shadow-sm p-2 me-1">En línea</span>';
                }

                if (hasDeliveryPayment)
                {
                    label.innerHTML = label.innerHTML + '<span class="small bg-success text-white rounded-pill shadow-sm p-2 me-1">En la entrega</span>';
                }

            });

            // Get the select element
            var select = document.getElementById("metodoDePago");

            // Add event listener to detect when the selection changes
            select.addEventListener("change", function()
            {
               // Get the selected value
               var selectedValue = select.value;

               // Check the selected value
               if (selectedValue === "PP" || selectedValue === "MP")
               {
                    document.getElementById("fondoDatosAdicionales").style.display  = "block";

                    // Show the input field
                    document.getElementById("urlPago").style.display       = "block";
                    document.getElementById("urlPago").required            = true;
                    document.getElementById("labelUrlPago").style.display  = "block";

                    // hide
                    document.getElementById("banco").style.display         = "none";
                    document.getElementById("numeroTarjeta").style.display = "none";
                    document.getElementById("clabe").style.display         = "none";
                    document.getElementById("beneficiario").style.display  = "none";

                    document.getElementById("labelBanco").style.display         = "none";
                    document.getElementById("labelNumeroTarjeta").style.display = "none";
                    document.getElementById("labelClabe").style.display         = "none";
                    document.getElementById("labelBeneficiario").style.display  = "none";
               }
               else if (selectedValue === "TRANSFER")
               {
                    document.getElementById("fondoDatosAdicionales").style.display  = "block";
                    document.getElementById("labelUrlPago").style.display           = "none";

                    // Show the two input fields
                    document.getElementById("banco").style.display                  = "block";
                    document.getElementById("banco").required                       = true;
                    document.getElementById("labelBanco").style.display             = "block";

                    document.getElementById("numeroTarjeta").style.display          = "block";
                    document.getElementById("numeroTarjeta").required               = true;
                    document.getElementById("labelNumeroTarjeta").style.display     = "block";

                    document.getElementById("clabe").style.display                  = "block";
                    document.getElementById("clabe").required                       = true;
                    document.getElementById("labelClabe").style.display             = "block";

                    document.getElementById("beneficiario").style.display           = "block";
                    document.getElementById("beneficiario").required                = true;
                    document.getElementById("labelBeneficiario").style.display      = "block";

                    // hide
                    document.getElementById("urlPago").style.display = "none";
                    document.getElementById("urlPago").required      = false;
               }
               else
               {
                    // Hide the input fields
                    document.getElementById("urlPago").required                 = false;
                    document.getElementById("banco").required                   = false;
                    document.getElementById("numeroTarjeta").required           = false;
                    document.getElementById("clabe").required                   = false;
                    document.getElementById("beneficiario").required            = false;

                    document.getElementById("urlPago").style.display            = "none";
                    document.getElementById("banco").style.display              = "none";
                    document.getElementById("numeroTarjeta").style.display      = "none";
                    document.getElementById("clabe").style.display              = "none";
                    document.getElementById("beneficiario").style.display       = "none";

                    document.getElementById("labelBanco").style.display         = "none";
                    document.getElementById("labelNumeroTarjeta").style.display = "none";
                    document.getElementById("labelClabe").style.display         = "none";
                    document.getElementById("labelBeneficiario").style.display  = "none";

                    document.getElementById("fondoDatosAdicionales").style.display  = "none";
               }

               switch (selectedValue)
               {
                  case 'PP':
                    //alert('axel');
                  break;

                  default:

               }
            });

            function enviaModal(data)
            {
                //var info = "banco,numerodetarjeta,clabe";
                var valores = data.split(",");
                //console.log(); // Output: ["banco", "numerodetarjeta", "clabe"]

                document.getElementById("bancoModal").value  = valores[0];
                document.getElementById("clabeModal").value  = valores[1];
                document.getElementById("numeroTarjetaModal").value  = valores[2];
                document.getElementById("idDB").value  = valores[3];
            }

            function sendToDeleteModal(data)
            {
                var valores = data.split(",");
                console.log(valores);
                //var info = "banco,numerodetarjeta,clabe";
                document.getElementById("idToDeletePago").value  = valores[0];
                document.getElementById("paymentNameToDelete").innerHTML  = valores[1];
            }

        </script>
    </body>
</html>
