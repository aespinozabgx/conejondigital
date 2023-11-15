<?php

    session_start();

    require '../app/php/conexion.php';
    require 'php/funciones.php';

    if (isset($_SESSION['managedStore']))
    {
        $idTienda = $_SESSION['managedStore'];
        if ($idTienda === false)
        {
            die("Tienda no encontrada");
        }
    }

    if (isset($_SESSION['email']))
    {
        $idUsuario = $_SESSION['email'];
    }

    if (isset($_SESSION['sucursalTienda']))
    {
        echo $sucursalTienda = $_SESSION['sucursalTienda'];
        if ($sucursalTienda === false)
        {
            die("Selecciona la sucursal");
        }
    }

    $totalPedido = 0;
    $totalAPagar = 0;
    $precioSinDescuento = 0;

    $productos = getProductosTiendaPOS($conn, $idTienda, 6);

    // Valido si hay turno activo
    $response = isTurnoCajaActivo($conn, $idTienda, $idUsuario);
    // echo "<pre>";
    // print_r($_SESSION);
    // die;
    $hasActivePayment = validarPagoActivo($conn, $idTienda);

?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>PDV</title>
        <link href="css/styles.css?id=3328" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <style type="text/css">

            /* Remover flechas del input numero */
            input[type=number]::-webkit-inner-spin-button,
            input[type=number]::-webkit-outer-spin-button
            {
                -webkit-appearance: none;
                margin: 0;
            }

            input[type='radio']
            {
                transform: scale(1.2);
            }

            .addcartShow
            {
                opacity: 0;
            }

            .addcartShow:hover
            {
                display: block;
                transition: 0.5s;
                opacity: 1;
                transition: opacity 0.5s ease-in-out;
            }

            .showProducto:hover
            {
                border: 1px solid rgb(147, 98, 73);
                transition: 1s ease-in-out;
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
                    <header class="page-header page-header-dark bg-pattern-pdv mb-4">
                        <div class="container-xl px-4">
                            <div class="page-header-content pt-4">

                                <div class="row align-items-center justify-content-center">
                                    <div class="col-auto mt-4">
                                        
                                        <div class="display-6 text-white sombra-titulos-vendy m-2">
                                            <div class="page-header-icon">
                                                <i class="fas fa-cash-register text-white-25"></i>
                                                Punto De Venta
                                            </div>                                            
                                        </div>


                                        <div class="d-flex justify-content-center">
                                            <span class="btn btn-outline-white shadow-sm rounded-pill me-1 mb-1 fs-4" style="" id="sucursalHeader" data-bs-toggle="modal" data-bs-target="#modalSeleccionarSucursal"></span>
                                            
                                            <a class="btn btn-danger rounded-pill shadow-sm me-1 mb-1" class="text-decoration-none" href="dashboard.php?msg=cerrarTurnoCaja">
                                                <i class="" data-feather="unlock"></i>
                                            </a>
                                        </div>

                                        <!-- <div class="page-header-subtitle">Escanea o ingresa el nombre del producto</div> -->
                                    </div>
                                </div>

                                <form class="" id="ajaxCart">
                                    <div class="page-header-search mt-4">
                                        <input type="hidden" id="idTienda" value="<?php echo $idTienda; ?>">
                                        <div class="input-group input-group-joined">
                                            <input class="form-control fs-1 fw-300 text-center" type="text" id="lpn" placeholder="Código/Nombre producto" aria-label="Search" autofocus />
                                            <span class="input-group-text">
                                                <!-- <i data-feather="search"></i> -->
                                                <i class="fas fa-barcode"></i>
                                            </span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </header>
                    <!-- Main page content-->
                    <div class="container-xl px-4">
                        <h4 class="mb-0 mt-5"> &nbsp; </h4>
                        <!-- <hr class="mt-2 mb-4" /> -->
                        <div id="contenidoCarrito"></div>
                    </div>

                    <div class="container-xl px-4 mt-n10">

                        <div class="row mb-3 my-2">
                            <div class="col-12 text-end">
                              <!-- <a class="btn bg-white fw-600 text-dark fs-6 shadow-sm rounded-pill" href="#"><i class="feather-lg me-1" data-feather="filter"></i> Filtrar</a> -->
                            </div>
                        </div>

                        <div class="mb-2 mt-5">

                            <div id="salida" class="row mb-2 m-1"></div>
                            <div class="row mb-2">
                                <?php
                                    if ($productos !== false && $response['estatus'] !== false)
                                    {
                                        echo '<p class="mb-4 fw-300 fs-5">Productos sugeridos</p>';
                                        // output data of each row
                                        foreach ($productos as $key => $row)
                                        {
                                        ?>
                                            <div class="col-xl-6 col-lg-6 col-md-6 mb-4" style="cursor: pointer;">
                                                  <!-- Dashboard example card 1-->
                                                  <a class="card h-100 text-decoration-none lift" style="pointer: cursor;">
                                                      <div class="card-body d-flex justify-content-center flex-column">
                                                          <div class="d-flex align-items-center justify-content-between">

                                                              <img class="rounded-1" onclick="location.href='detalle-producto-pos.php?idProducto=<?php echo $row['idProducto']; ?>&tienda=<?php echo $row['idTienda']; ?>'" src="<?php echo $dominio; ?>/partner/verifica/usr_docs/<?php echo $row["idTienda"]; ?>/productos/<?php echo $row["idProducto"]; ?>/<?php echo $row["url"]; ?>" alt="..." style="width: 10rem" />

                                                              <div class="ms-2">
                                                                  <!-- <i class="feather-xl text-primary mb-3" data-feather="package"></i> -->
                                                                  <h5 class="fw-500 fs-2"><?php echo $row["nombre"]; ?></h5>
                                                                  <div class="text-green fs-3 fw-400 text-nowrap">
                                                                      <?php
                                                                          if ($row["precioOferta"] < $row["precio"] && ($row["precioOferta"] > 0))
                                                                          {
                                                                              echo "$ " . number_format($row["precioOferta"], 2);
                                                                              ?>
                                                                              <span class="text-danger">
                                                                                  <s>
                                                                                      <?php echo "$ " . number_format($row["precio"], 2); ?>
                                                                                  </s>
                                                                              </span>
                                                                              <?php
                                                                          }
                                                                          else
                                                                          {
                                                                            echo "$ " . number_format($row['precio'], ($row['precio'] == round($row['precio'], 0)) ? 0 : 2) . " <span class='small'>mxn</span>";

                                                                          }
                                                                      ?>
                                                                  </div>

                                                                  <!-- <a href="carrito.php" class="btn btn-outline-success btn-sm mt-2 ">Detalle</a> -->
                                                                  <form action="procesa.php" class="" method="post">
                                                                      <?php
                                                                      if ($row['unidadVenta'] == "Kilogramos")
                                                                      {
                                                                      ?>
                                                                          <div class="input-group mb-1 mt-2 w-100 disable-dbl-tap-zoom">

                                                                              <input type="number" class="form-control" name="stock" value="10" id="<?php echo $row['id']; ?>" min="10" max="<?php echo ($row["inventario"]*1000); ?>" step="10" onchange="validarStock(this)" required>

                                                                              <button class="btn btn-outline-success" type="button" onclick="decrementValueGranel(<?php echo $row['id']; ?>)">
                                                                                  <i class="fas fa-minus"></i>
                                                                              </button>

                                                                              <button class="btn btn-outline-success" type="button" onclick="incrementValueGranel(<?php echo $row['id']; ?>)">
                                                                                  <i class="fas fa-plus"></i>
                                                                              </button>

                                                                          </div>
                                                                          <div class="small mb-2 text-center" id="salidaGramos"></div>
                                                                      <?php
                                                                      }
                                                                      else
                                                                      {
                                                                      ?>
                                                                          <!-- <input type="number" class="form-control" name="stock" value="1" step="1" min="1" required> -->
                                                                          <div class="input-group mb-1 mt-2 w-100 disable-dbl-tap-zoom">

                                                                              <button class="btn btn-outline-success btn-sm" type="button" onclick="decrementValue(<?php echo $row['id']; ?>)">
                                                                                  <i class="fas fa-minus"></i>
                                                                              </button>

                                                                              <input type="number" class="form-control text-center" name="stock" value="1" id="<?php echo $row['id']; ?>" min="1" max="<?php echo $row["inventario"]; ?>" step="1" pattern="[0-9]*" required>

                                                                              <button class="btn btn-outline-success btn-sm" type="button" onclick="incrementValue(<?php echo $row['id']; ?>)">
                                                                                  <i class="fas fa-plus"></i>
                                                                              </button>

                                                                          </div>
                                                                      <?php
                                                                      }
                                                                      ?>

                                                                      <div class="mb-2">
                                                                          <span class="fw-300" style="font-size:12px;"><?php echo $row["inventario"] . " " . ((strpos($row["unidadVenta"], "Kilogramos") !== false) ? "Kgs." : "Pzs.") . " Disponibles"; ?></span>
                                                                      </div>

                                                                      <input type="hidden" name="idProducto" value="<?php echo $row['idProducto']; ?>">
                                                                      <input type="hidden" name="idTienda"   value="<?php echo $idTienda; ?>">

                                                                      <div class="">
                                                                          <button type="button" name="button" class="btn btn-outline-primary mb-1 w-100" onclick="location.href='detalle-producto-pos.php?idProducto=<?php echo $row['idProducto']; ?>&tienda=<?php echo $row['idTienda']; ?>';">
                                                                              Detalle
                                                                          </button>

                                                                          <?php
                                                                            if($row["inventario"]>0)
                                                                            {
                                                                                ?>
                                                                                <button type="submit" class="btn btn-primary shadow-none w-100 mb-1 fs-6" name="btnAgregarCarrito" value="app/pos.php" <?php echo ($row['inventario'] > 0) ? "" : "disabled"; ?>>
                                                                                    <i class="me-1" data-feather="shopping-bag"></i>
                                                                                    Agregar
                                                                                </button>
                                                                                <?php
                                                                            } 
                                                                            else 
                                                                            {
                                                                                ?>
                                                                                <button type="submit" class="btn btn-danger shadow-none w-100 mb-1 fs-6" name="btnAgregarCarrito" value="app/pos.php" <?php echo ($row['inventario'] > 0) ? "" : "disabled"; ?>>
                                                                                    <i class="me-1" data-feather="shopping-bag"></i>
                                                                                    Agotado
                                                                                </button>
                                                                                <?php
                                                                            }
                                                                          ?>
                                                                          
                                                                      </div>

                                                                  </form>

                                                              </div>
                                                          </div>
                                                      </div>
                                                  </a>
                                              </div>
                                        <?php
                                        }
                                    }
                                ?>
                            </div>

                        </div>

                        <input type="hidden" id="tipoComida" name="tipoComida" value="" required>
                        <input type="hidden" id="fecha" name="fechaSave" value="<?php echo $fechaBusqueda; ?>" required>

                        <div class="d-none d-lg-flex fixed-bottom justify-content-end mb-3 me-4 d-md-none">
                            <a href="carritoPos.php?tienda=<?php echo $idTienda; ?>" class="btn btn-success fw-600 fs-5 rounded-pill shadow-sm" name="btnCrearPedido" value="PDV">
                                <div class="btn btn-white btn-sm rounded-pill me-2 shadow-sm">
                                    <i data-feather="shopping-cart" class="me-1"></i>
                                    <span id="salidaCarrito" class="salidaCarrito">
                                        <?php echo contarCarrito($idTienda); ?>
                                    </span>
                                </div>
                                Carrito
                            </a>
                        </div>

                        <div class="d-lg-none fixed-bottom d-flex justify-content-center text-center mb-3 d-md-flex">
                            <a href="carritoPos.php?tienda=<?php echo $idTienda; ?>" class="btn btn-success fw-600 fs-5 rounded-pill shadow-sm" name="btnCrearPedido" value="PDV">
                                <div class="btn btn-white btn-sm rounded-pill me-2 shadow-sm">
                                    <i data-feather="shopping-cart" class="me-1"></i>
                                    <span id="salidaCarrito" class="salidaCarrito">
                                        <?php echo contarCarrito($idTienda); ?>
                                    </span>
                                </div>
                                Carrito
                            </a>
                        </div>

                    </div>

                </main>
                <?php
                    // Header
                    if (file_exists('src/footer.php'))
                    {
                        include 'src/footer.php';
                    }
                ?>
            </div>
        </div>
        <?php
            if ($response['estatus'] === false)
            {
                //exit(header('Location: dashboard.php?msg=requiereAbrirTurnoCaja'));
                ?>
                    <script type="text/javascript">
                        Swal.fire({
                            icon: "warning",
                            title: "Importante",
                            html: "Para usar el PDV debes abrir el turno de caja",
                            showConfirmButton: true,
                            confirmButtonText: "Abrir turno",
                            timerProgressBar: true,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            timer: 6000,
                            didClose: () => {
                                window.location.href = "dashboard.php?msg=requiereAbrirTurnoCaja";
                            }
                        }).then((result) => {
                            if (result.isConfirmed)
                            {
                                window.location.href = "dashboard.php?msg=requiereAbrirTurnoCaja";
                            }
                        });

                        window.setTimeout(function()
                        {
                            window.location.href = "dashboard.php?msg=requiereAbrirTurnoCaja";
                        }, 5100);

                    </script>
                <?php
            }

            // Header
            if (file_exists('src/modals.php'))
            {
                include 'src/modals.php';
            }
        ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script>

            function setFocusToTextBox()
            {
                document.getElementById("inputBusqueda").focus();
                // document.getElementById("inputBusqueda").reset();
            }

            $(function(){
                $('#ajaxCart').on('submit', function(event){
                    event.preventDefault();
                    document.getElementById("lpn").value = "";
                    //alert();
                });
            });

            const input = document.getElementById('lpn');
            input.addEventListener('keydown', function(event)
            {
                if (event.key === 'Enter')
                {
                    const lpn = input.value;
                    if(lpn == '')
                    {
                      //alert("Please fill all fields.");
                      return false;
                    }

                    $.ajax({
                        type: "POST",
                        url: "php/ajax/addCartAuto.php",
                        data:
                        {
                            lpn: lpn
                        },
                        cache: false,
                        success: function(data)
                        {
                            // console.log(data);
                            var responseArray = JSON.parse(data);
                            var status   = responseArray[0];
                            var type     = responseArray[1];
                            var message  = responseArray[2];
                            var alertDiv = document.createElement('div');

                            document.getElementById('salida').innerHTML = "";
                            switch (type)
                            {
                                // NOTIFICACION
                                case 'notificacion':

                                    var alertDiv = document.createElement('div'); // Crear una nueva instancia de la alerta
                                    alertDiv.className = 'alert alert-dismissible fade show';

                                    if (status == true) 
                                    {
                                        var carritoTotal = responseArray[3];
                                        // document.getElementById('salidaCarrito').innerHTML = carritoTotal;
                                        alertDiv.classList.add('bg-success', 'text-white');

                                        var carritoElements = document.getElementsByClassName('salidaCarrito');
                                        for (var i = 0; i < carritoElements.length; i++) 
                                        {
                                            carritoElements[i].innerHTML = carritoTotal;
                                        }

                                    } 
                                    else 
                                    {
                                        alertDiv.classList.add('bg-danger', 'text-white');
                                    }

                                    alertDiv.innerHTML = message + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';

                                    document.getElementById('salida').appendChild(alertDiv); // Agregar la alerta al contenedor

                                    setTimeout(function() 
                                    {
                                        alertDiv.style.display = 'none';
                                    }, 6000);

                                break;

                                // CONTENIDO
                                case 'contenido':
                                    document.getElementById('salida').innerHTML = message + '<hr class="" />';
                                break;

                                // Modal
                                case 'sweetAlert':
                                    // Crear el formulario HTML con los valores dinámicos
                                    $('#modalVentaGranel').modal('show'); // Abre el modal
                                    document.getElementById('idProductoDB').value = message;
                                    //console.log('axel');
                                break;

                                default:
                            }

                        },
                        error: function(xhr, status, error)
                        {
                            console.error(xhr);
                        }
                    });
                }
            });

            function incrementValue(id)
            {
                var inputEl = document.getElementById(id);
                var currentValue = parseInt(inputEl.value);
                var newValue = currentValue + 1;
                inputEl.value = newValue;
            }

            function decrementValue(id)
            {
                var inputEl = document.getElementById(id);
                var currentValue = parseInt(inputEl.value);
                var newValue = currentValue - 1;
                if (newValue < 1)
                {
                    newValue = 1;
                }
                inputEl.value = newValue;
            }

            function incrementValueGranel(id)
            {
                var inputEl = document.getElementById(id);
                var currentValue = parseInt(inputEl.value);
                var newValue = currentValue + 10; // se incrementa de 10 en 10
                inputEl.value = newValue;

                // Calcular Kilogramos
                const kilogramos = newValue / 1000; // Dividir entre 1000 para obtener los kilogramos
                //document.getElementById('salidaGramos').innerHTML = newValue + " Gramos ≈ " + kilogramos + " kilogramos";

                // Seleccionar todos los elementos con id "salidaGramos"
                var elementos = document.querySelectorAll('#salidaGramos');

                // Recorrer los elementos y modificar su contenido
                for (var i = 0; i < elementos.length; i++)
                {
                    elementos[i].innerHTML = newValue + " Gramos ≈ " + kilogramos + " kilogramos";
                }
            }

            function decrementValueGranel(id)
            {
                var inputEl = document.getElementById(id);
                var currentValue = parseInt(inputEl.value);
                var newValue = currentValue - 10; // se decrementa de 10 en 10
                if (newValue < 10)
                {
                    newValue = 10;
                }
                inputEl.value = newValue;

                // Calcular Kilogramos
                const kilogramos = newValue / 1000; // Dividir entre 1000 para obtener los kilogramos
                //document.getElementById('salidaGramos').innerHTML = newValue + " Gramos ≈ " + kilogramos + " kilogramos";
                // Seleccionar todos los elementos con id "salidaGramos"
                var elementos = document.querySelectorAll('#salidaGramos');

                // Recorrer los elementos y modificar su contenido
                for (var i = 0; i < elementos.length; i++)
                {
                    elementos[i].innerHTML = newValue + " Gramos ≈ " + kilogramos + " kilogramos";
                }
            }

            // Validación input granel
            function validarStock(input)
            {
                const value = parseInt(input.value, 10);
                if (isNaN(value) || value < 10 || value % 10 !== 0)
                {
                    //console.log(kilogramos); // Salida: 5
                    document.getElementById('salidaGramos').innerHTML = "";
                    //alert('El valor debe ser un múltiplo de 10 y mayor o igual a 10');
                    input.value = 0;
                }
                else
                {
                    // Calcular Kilogramos
                    const gramos = 0; // Ejemplo de número entero que debe ser un múltiplo de 10
                    const kilogramos = value / 1000; // Dividir entre 1000 para obtener los kilogramos
                    //document.getElementById('salidaGramos').innerHTML = value + " Gramos ≈ " + kilogramos + " kilogramos";
                    // Seleccionar todos los elementos con id "salidaGramos"
                    var elementos = document.querySelectorAll('#salidaGramos');

                    // Recorrer los elementos y modificar su contenido
                    for (var i = 0; i < elementos.length; i++)
                    {
                        elementos[i].innerHTML = value + " Gramos ≈ " + kilogramos + " kilogramos";
                    }
                    input.setCustomValidity('');
                }
            }
        </script>
        <?php
          if (file_exists('src/triggers.php'))
          {
              include 'src/triggers.php';
          }

          if (isset($_GET['error']))
          {
              if (!isset($_SESSION['idSucursalVenta'], $_SESSION['nombreSucursalVenta']))
              {
                  $error = $_GET['error'];
                  if ($error == "elegirSucursal")
                  {
                  ?>
                  <script>
                      $(document).ready(function() {
                          $('#modalSeleccionarSucursal').modal('show');
                      });
                  </script>
                  <?php
                  }
              }
          }

          if (!isset($_SESSION['idSucursalVenta'], $_SESSION['nombreSucursalVenta']))
          {
          ?>
          <script>
              $(document).ready(function() {
                  $('#modalSeleccionarSucursal').modal('show');
              });
          </script>
          <?php
          }
          else
          {
          ?>
          <script type="text/javascript">
              document.getElementById('sucursalHeader').innerHTML = '<?php echo $_SESSION['nombreSucursalVenta'] . "<i data-feather=\'map-pin\' class=\'ms-2\'></i>"; ?>';
          </script>
          <?php
          }
        ?>

    </body>
</html>
