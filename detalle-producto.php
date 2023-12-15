<?php
    session_start();

    require 'app/php/conexion.php';
    require 'app/php/funciones.php';

    $whatsappMsg = "https://api.whatsapp.com/send?phone=5215610346590&text=Hola, requiero info adicional de mi perfil verificado mayoristapp.mx";

    if (isset($_GET['tienda']) && isset($_GET['idProducto']))
    {
        $idTienda = $_GET['tienda'];
        $tienda = getDatosTienda($conn, $idTienda); // $tienda recibe el idOwner y username(tienda)

        $idProducto = $_GET['idProducto'];

        if ($tienda === false)
        {
            die("Tienda no encontrada");
        }
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
        <title>vendy.mx :: <?php echo $idTienda; ?></title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="app/css/styles.css?id=333" rel="stylesheet" />
        <!-- <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" /> -->
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
        <style type="text/css">

          .float
          {
              position: fixed;
              left: 0;
              right: 0;
              bottom: 40px;
              width: 66%;
              margin: auto;
              color: white;
              z-index: 3000;
          }

          .altura
          {
              /* min-height: 400px;
              width: 100%;
              max-height: 400px; */
          }

          .contenedorC
          {

          }

          carousel-inner
          {
            width: 100%;
            margin: auto;
            text-align: center;
          }

          .carousel-inner img
          {

              width: 100%;
              max-width: 400px;
              height: auto;
          }

          /* Remover flechas del input numero */
          input[type=number]::-webkit-inner-spin-button,
          input[type=number]::-webkit-outer-spin-button
          {
              -webkit-appearance: none;
              margin: 0;
          }

        </style>
    </head>
    <body class="nav-fixed">
      <?php
          if (file_exists('src/topmenu.php'))
          {
              require 'src/topmenu.php';
          }
      ?>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <?php
                  if (file_exists('src/sidenav.php'))
                  {
                      require 'src/sidenav.php';
                  }
                ?>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <header class="page-header page-header-dark bg-pattern-ama2 pb-10">
                        <div class="container-xl px-4">
                            <div class="page-header-content pt-4">

                                <div class="mb-3">
                                    <div class=" mt-4 d-flex justify-content-center">
                                    
                                        <div class="page-header-title text-dark mx-auto mx-lg-0">

                                            <div class="display-6 text-dark fw-400 " style="text-shadow: 1px 1px 0px rgba(121, 120, 121, 0.68);">
                                                <?php echo $tienda['nombreTienda']; ?>                                                
                                            </div>                                                                                    

                                            <?php
                                            if ($hasActivePayment !== false && $hasActivePayment['existePagoActivo'] == true)
                                            {
                                            ?>
                                                <a class="ms-1 text-decoration-none text-dark" style="font-size: 20px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modalCuentaVerificada">
                                                    <span class="tw-verified-badge tw-icon-defaults tw-hidden" style="--fa-beat-scale: 0.9;" title="Verified Account"></span>
                                                </a>
                                            <?php
                                            }
                                            else
                                            {
                                            ?>
                                                <a class="ms-1 text-decoration-none text-dark" style="font-size: 20px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modalCuentaVerificada">
                                                    <i class="fa-regular fa-times-circle fa-beat" style="--fa-beat-scale: 0.9;"></i>
                                                </a>
                                            <?php
                                            }
                                            ?>

                                        </div>                                            
                                    </div>
                                    
                                    <div class="small text-dark text-center">
                                            <?php echo "@" . $tienda['idTienda']; ?>
                                    </div>

                                </div>

                                <div class="col-lg-4">
                                    <a href="perfil.php?tienda=<?php echo $idTienda; ?>" class="btn btn-primary shadow-sm rounded-pill fw-300 fs-6" name="button">
                                        <i data-feather='corner-up-left' class="me-2"></i>
                                        Regresar
                                    </a>
                                </div>


                            </div>

                            <div id="notificacion">
                            
                                <div id="errorInventarioInsuficiente" style="display: none;">
                                    <div class="alert alert-pink fa-beat alert-solid alert-icon" role="alert" style="--fa-beat-scale: 0.99; --fa-animation-duration: 1s;">
                                        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                                        <div class="alert-icon-aside">
                                            <i class="fas fa-warning"></i>
                                        </div>
                                        <div class="alert-icon-content">
                                            <h6 class="alert-heading">Notificación</h6>
                                            Ocurrió un error al agregar al carrito, <span class="fw-600">no hay inventario suficiente</span>.
                                        </div>
                                    </div>
                                </div>

                                <div id="alertaCarrito" style="display: none;">
                                    <div class="alert alert-success alert-solid alert-icon" role="alert" style="--fa-beat-scale: 0.99; --fa-animation-duration: 1s;">
                                        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                                        <div class="alert-icon-aside">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <div class="alert-icon-content">
                                            <h6 class="alert-heading">Notificación</h6>
                                            Agregado al carrito.
                                        </div>
                                    </div>
                                </div>

                                <div id="alertaCarritoError" style="display: none;">
                                    <div class="alert alert-danger fa-beat alert-solid alert-icon" role="alert" style="--fa-beat-scale: 0.99; --fa-animation-duration: 1s;">
                                        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                                        <div class="alert-icon-aside">
                                            <i class="fas fa-times"></i>
                                        </div>
                                        <div class="alert-icon-content">
                                            <h6 class="alert-heading">Notificación</h6>
                                            Ocurrió un error al agregar al carrito, intenta nuevamente.
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </header>
                    <!-- Main page content-->

                    <div class="container-xl px-4 mt-n10">
                        <div class="row gx-4">

                            <div class="col-lg-8 mb-4">
                                <!--  -->
                                <?php
                                    
                                    $id  = $tienda['administradoPor'];

                                    $sql = "SELECT
                                                productos.*,
                                                imagenProducto.*
                                            FROM
                                                productos
                                            LEFT JOIN imagenProducto
                                                ON productos.idTienda = imagenProducto.idTienda
                                                AND productos.idProducto = imagenProducto.idProducto 
                                            WHERE
                                                productos.idTienda = '$idTienda'
                                                AND productos.idProducto = '$idProducto'
                                                AND productos.isActive = 1;";

                                    $result = mysqli_query($conn, $sql);
                                    if (mysqli_num_rows($result) > 0)
                                    {
                                        // output data of each row
                                        while($row = mysqli_fetch_assoc($result))
                                        {
                                            $datosProducto['id']           = $row['id'];
                                            $datosProducto['nombre']       = $row['nombre'];
                                            $datosProducto['inventario']   = $row['inventario'];
                                            $datosProducto['idTienda']     = $row['idTienda'];
                                            $datosProducto['idProducto']   = $row['idProducto'];
                                            $datosProducto['descripcion']  = $row['descripcion'];
                                            $datosProducto['precio']       = $row['precio'];
                                            $datosProducto['precioOferta'] = $row['precioOferta'];
                                            $datosProducto['unidadVenta']  = $row['unidadVenta'];
                                            $datosProducto['url'][]        = $row['url'];
                                        }

                                        ?>
                                          <div class="">
                                              <a class="card h-100 text-decoration-none">
                                                  <div class="card-body d-flex justify-content-center flex-column">
                                                      <div class="d-flex align-items-center">
                                                          <div class="col-lg-6" style="width: 100%; margin: auto;">

                                                              <div id="carouselExampleIndicators" class="carousel slide carousel-dark justify-content-center" data-bs-ride="carousel">

                                                                  <div class="carousel-indicators">
                                                                      <?php
                                                                          $contador = 1;
                                                                          for ($i=0; $i < sizeof($datosProducto['url']); $i++)
                                                                          {
                                                                            ?>
                                                                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?php echo $i; ?>" class="active" aria-current="true" aria-label="Imagen <?php echo $contador; ?>"></button>
                                                                            <?php
                                                                            $contador++;
                                                                          }
                                                                      ?>
                                                                  </div>


                                                                  <div class="">
                                                                    <div class="carousel-inner">
                                                                        <?php
                                                                            $contadorImg = 1;
                                                                            for ($i=0; $i < sizeof($datosProducto['url']); $i++)
                                                                            {
                                                                                if ($i == 0)
                                                                                {
                                                                                    echo '<div class="carousel-item active">';
                                                                                }
                                                                                else
                                                                                {
                                                                                    echo '<div class="carousel-item">';
                                                                                }

                                                                              ?>
                                                                                <div class="d-flex justify-content-center">
                                                                                    <img src="<?php echo $dominio; ?>/app/verifica/usr_docs/<?php echo $datosProducto['idTienda']; ?>/productos/<?php echo $datosProducto['idProducto']; ?>/<?php echo $datosProducto['url'][$i]; ?>" class="d-block altura" alt="...">
                                                                                </div>
                                                                              <?php
                                                                                  echo '</div>';
                                                                              $contadorImg++;
                                                                            }
                                                                        ?>
                                                                    </div>
                                                                  </div>

                                                                  <div class="contenedorC align-items-middle text-center align-center">

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
                                                      </div>
                                                  </div>
                                              </a>
                                          </div>
                                        <?php

                                    }
                                    else
                                    {
                                        echo "0";
                                    }
                                ?>
                                <!--  -->
                            </div>

                            <div class="col-lg-4 mb-4">

                              <!--  -->
                              <div class="row">
                                  <div class="">
                                      <a class="card h-100 text-decoration-none">
                                          <div class="card-body d-flex justify-content-center flex-column">
                                              <div class="align-items-center">

                                                  <div class="p-1">
                                                      <div class="fw-400 fs-1 text-dark poppins text-center" style="text-shadow: 1px 1px 0px rgba(121, 120, 121, 0.68);"><?php echo $datosProducto['nombre']; ?></div>
                                                      <?php
                                                      // var_dump($datosProducto['descripcion']);
                                                      if (strlen($datosProducto['descripcion'])>0)
                                                      {
                                                      ?>
                                                      <div class="text-dark mt-2 p-2">
                                                          <?php echo ucfirst($datosProducto['descripcion']); ?>
                                                      </div>
                                                      <?php
                                                      }
                                                      ?>
                                                  </div>

                                                  <h1 class="fw-500 fs-1 mt-3 text-success text-center">
                                                      <?php

                                                      if ($datosProducto['precioOferta'] < $datosProducto['precio'] && ($datosProducto['precioOferta'] > 0))
                                                      {
                                                          ?>
                                                          <span class="fw-500 text-danger h5">
                                                              <!-- <s> $ <?php //echo number_format($datosProducto['precio'], 2); ?> </s> -->
                                                              <s>$ <?php echo number_format($datosProducto['precio'], 2); ?></s>
                                                          </span>
                                                          <br>
                                                          $ <?php echo number_format($datosProducto['precioOferta'], 2); ?>

                                                          <?php
                                                      }
                                                      else
                                                      {
                                                          echo "$ " . number_format($datosProducto['precio'], 2);
                                                      }

                                                      ?>

                                                  </h1>

                                                  <?php
                                                  if ($hasActivePayment !== false && $hasActivePayment['existePagoActivo'] == true)
                                                  {
                                                  ?>
                                                  <hr class="mt-4 bg-success">
                                                  <form action="app/procesa.php" method="post">
                                                      <div class="row g-3 align-items-center">
                                                            <div class="col-auto">
                                                                <label class="col-form-label text-dark">Cantidad:</label>
                                                            </div>

                                                            <!--  -->
                                                            <?php
                                                            if ($datosProducto['unidadVenta'] == "Kilogramos")
                                                            {
                                                            ?>
                                                                <div class="input-group mb-1 mt-2 w-100 ">

                                                                    <input type="number" class="form-control shadow-none border border-2 border-success text-center" name="stock" value="10" id="<?php echo $datosProducto['id']; ?>" min="10" step="10" onchange="validarStock(this)" required>

                                                                    <button class="btn btn-outline-success shadow-none border border-2 border-success" type="button" onclick="decrementValueGranel(<?php echo $datosProducto['id']; ?>)">
                                                                        <i class="fas fa-minus"></i>
                                                                    </button>

                                                                    <button class="btn btn-outline-success shadow-none border border-2 border-success" type="button" onclick="incrementValueGranel(<?php echo $datosProducto['id']; ?>)">
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
                                                                <div class="input-group mb-1 mt-2 w-100">
                                                                    <button class="btn btn-outline-success" type="button" onclick="decrementValue(<?php echo $datosProducto['id']; ?>)">
                                                                        <i class="fas fa-minus"></i>
                                                                    </button>

                                                                        <input type="number" class="form-control text-center" name="stock" value="1" id="<?php echo $datosProducto['id']; ?>" min="1" step="1" pattern="[0-9]*" required>

                                                                    <button class="btn btn-outline-success" type="button" onclick="incrementValue(<?php echo $datosProducto['id']; ?>)">
                                                                        <i class="fas fa-plus"></i>
                                                                    </button>
                                                                </div>
                                                            <?php
                                                            }
                                                            ?>
                                                            <!--  -->

                                                            <div class="col-auto">
                                                              <span id="passwordHelpInline" class="form-text">
                                                                  <?php

                                                                      // Mostrar Stock
                                                                      if ($datosProducto['unidadVenta']== "Kilogramos")
                                                                      {
                                                                          echo $datosProducto['inventario'] . " Kgs. Disponible(s)";
                                                                      }
                                                                      else
                                                                      {
                                                                          echo $datosProducto['inventario'] . " Pzs. Disponible(s)";
                                                                      }

                                                                  ?>
                                                              </span>
                                                            </div>
                                                      </div>
                                                      <div class="text-end mt-2">
                                                        <input type="hidden" name="idProducto" value="<?php echo $datosProducto['idProducto']; ?>">
                                                        <input type="hidden" name="idTienda" value="<?php echo $datosProducto['idTienda']; ?>">
                                                        <button type="submit" class="btn btn-primary mt-2 w-100 rounded-2" name="btnAgregarCarrito" value="detalle-producto.php"
                                                        <?php
                                                            if ($datosProducto['inventario'] > 0)
                                                            {
                                                                //echo "disabled";
                                                            }
                                                            else
                                                            {
                                                                echo "disabled";
                                                            }
                                                        ?>>
                                                        <i class="fa-solid fa-basket-shopping me-1"></i> Agregar</button>
                                                    </div>
                                                  </form>
                                                  <?php
                                                  }
                                                  ?>
                                              </div>
                                          </div>
                                      </a>
                                  </div>
                              </div>
                              <!--  -->

                            </div>

                        </div>
                    </div>



                </main>
                <?php
                    if (file_exists('src/footer.php'))
                    {
                        require 'src/footer.php';
                    }
                ?>
            </div>
        </div>

        <?php
            if (file_exists('src/modals.php'))
            {
                require 'src/modals.php';
            }
        ?>

        <script type="text/javascript">

            let timeout;

            function hideElement()
            {
                timeout = setTimeout(alertFunc, 4000);
            }

            function alertFunc()
            {
                var myAlert = document.getElementById('notificacion');
                myAlert.style.display = 'none';
            }

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
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables/datatables-simple-demo.js"></script>
    </body>
</html>
<?php

    if (isset($_GET['msg']))
    {
        $msg = $_GET['msg'];
        switch ($msg)
        {

            case 'addedToCart':
            ?>
            <script type="text/javascript">

                var alertaCarrito = document.getElementById('alertaCarrito');
                alertaCarrito.style.display = 'block';
                hideElement(alertaCarrito);

            </script>
            <?php
            break;


            case 'errorAddedToCart':
                ?>
                <script type="text/javascript">

                    var alertaCarrito = document.getElementById('alertaCarritoError');
                    alertaCarritoError.style.display = 'block';
                    hideElement(alertaCarritoError);

                </script>
                <?php
            break;

            case 'errorInventarioInsuficiente':
                ?>
                <script type="text/javascript">

                    var errorInventarioInsuficiente = document.getElementById('errorInventarioInsuficiente');
                    errorInventarioInsuficiente.style.display = 'block';
                    hideElement(errorInventarioInsuficiente);

                </script>
                <?php
            break;            

        }
    }

    require 'src/triggers.php';
?>
