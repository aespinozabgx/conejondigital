<?php
    session_start();

    require 'php/conexion_db.php';
    require 'php/funciones.php';

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
        <!-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" /> -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>vendy.mx :: <?php echo $idTienda; ?></title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css?id=2828" rel="stylesheet" />
        <!-- <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" /> -->
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
          if (file_exists('src/header.php'))
          {
              require 'src/header.php';
          }
      ?>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <?php
                  if (file_exists('src/sidenav-dark.php'))
                  {
                      require 'src/sidenav-dark.php';
                  }
                ?>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <header class="page-header page-header-dark bg-pattern-pdv pb-10">
                        <div class="container-xl px-4">
                            <div class="page-header-content pt-4">

                                <div class="row align-items-center justify-content-between">
                                    <div class="col-auto mt-4">
                                        <h1 class="page-header-title text-dark">
                                            <!-- Nombre de la tienda -->
                                            <div class="page-header-icon">
                                                <i class="fa-solid fa-store text-white fa-sm"></i>
                                            </div>

                                            <span class="titulo text-white">
                                                <?php echo $idTienda ?>
                                            </span>

                                            <a class="ms-1 text-decoration-none text-white" style="font-size: 18px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modalPerfilVerificado">
                                                <small><i class="fa-regular fa-circle-check fa-beat" style="--fa-beat-scale: 0.9;"></i></small>
                                            </a>

                                        </h1>
                                        <div class="page-header-subtitle text-white">
                                            <!-- <i class="fa-solid fa-star text-white shadow"></i> -->
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 mt-3">
                                  <a href="pos.php" class="btn btn-outline-white rounded-pill shadow shadow-sm fs-5 fw-500" name="button">
                                      <i class="far fa-arrow-alt-circle-left me-1"></i>
                                      Volver al PDV
                                  </a>

                                </div>


                            </div>

                            <div id="notificacion">

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
                                                imagenProducto.idTienda = '$idTienda'
                                            AND
                                                productos.idTienda = '$idTienda'
                                            AND productos.isActive = 1 
                                            AND productos.idProducto = '$idProducto';";

                                    // echo $sql . "<br>";

                                    $result = mysqli_query($conn, $sql);
                                    if (mysqli_num_rows($result) > 0)
                                    {
                                        // output data of each row
                                        while($row = mysqli_fetch_assoc($result))
                                        {
                                            $datosProducto['id']       = $row['id'];
                                            $datosProducto['nombre']       = $row['nombre'];
                                            $datosProducto['inventario']        = $row['inventario'];
                                            $datosProducto['idTienda']    = $row['idTienda'];
                                            $datosProducto['idProducto']   = $row['idProducto'];
                                            $datosProducto['descripcion']  = $row['descripcion'];
                                            $datosProducto['precio']       = $row['precio'];
                                            $datosProducto['precioOferta'] = $row['precioOferta'];
                                            $datosProducto['unidadVenta'] = $row['unidadVenta'];
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
                                                      <div class="display-6 text-gray-800 poppins text-center sombra-titulos-vendy"><?php echo $datosProducto['nombre']; ?></div>
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

                                                  <h1 class="fw-700 fs-2 mt-3 text-success text-center">
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
                                                        ?>
                                                        <div style="font-size: 1.3em;" class="fw-300 text-success sombra-titulos-vendy">
                                                            $ 
                                                            <?php echo number_format($datosProducto['precio'], ($datosProducto['precio'] == round($datosProducto['precio'], 0)) ? 0 : 2); ?>
                                                        </div>
                                                        <?php
                                                      }

                                                      ?>

                                                  </h1>

                                                  <hr class="mt-4 bg-success">

                                                  <form action="procesa.php" method="post" class="disable-dbl-tap-zoom">
                                                    <div class="row g-3 align-items-center">
                                                          
                                                          <?php
                                                          
                                                            if($datosProducto['inventario'] > 0)
                                                            {
                                                                ?>
                                                                <div class="col-auto">
                                                                    <label class="col-form-label text-dark">Cantidad:</label>
                                                                </div>
                                                                <?php
                                                                if ($datosProducto['unidadVenta'] == "Kilogramos")
                                                                {
                                                                ?>
                                                                    <div class="input-group mb-1 mt-0 w-100 disable-dbl-tap-zoom">

                                                                        <input type="number" class="form-control" name="stock" value="10" id="<?php echo $datosProducto['id']; ?>" min="10" step="10" onchange="validarStock(this)" required>

                                                                        <button class="btn btn-outline-success" type="button" onclick="decrementValueGranel(<?php echo $datosProducto['id']; ?>)">
                                                                            <i class="fas fa-minus"></i>
                                                                        </button>

                                                                        <button class="btn btn-outline-success" type="button" onclick="incrementValueGranel(<?php echo $datosProducto['id']; ?>)">
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
                                                                    <div class="input-group mb-1 mt-0 w-100">
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
                                                            }
                                                          ?>
                                                          <!--  -->

                                                          <div class="col-auto">
                                                            <span id="passwordHelpInline" class="form-text text-center">
                                                                <?php

                                                                    // Mostrar Stock
                                                                    if($datosProducto['inventario'] > 0)
                                                                    {                                                                
                                                                        if ($datosProducto['unidadVenta'] == "Kilogramos")
                                                                        {
                                                                            echo $datosProducto['inventario'] . " Kgs. Disponible(s)";
                                                                        }
                                                                        else
                                                                        {
                                                                            echo $datosProducto['inventario'] . " Pzs. Disponible(s)";
                                                                        }
                                                                    } 

                                                                ?>
                                                            </span>
                                                          </div>
                                                    </div>
                                                    <div class="text-end mt-2">
                                                        <input type="hidden" name="idProducto" value="<?php echo $datosProducto['idProducto']; ?>">
                                                        <input type="hidden" name="idTienda" value="<?php echo $datosProducto['idTienda']; ?>">
                                                        
                                                        <?php
                                                            if ($datosProducto['inventario'] > 0)
                                                            {
                                                                ?>
                                                                <button type="submit" class="btn btn-primary mt-2 w-100" name="btnAgregarCarrito" value="app/detalle-producto-pos.php">
                                                                    <i class="fa-solid fa-basket-shopping me-1"></i> Agregar
                                                                </button>
                                                                <?php
                                                            }
                                                            else
                                                            {
                                                                ?>
                                                                <button type="submit" class="btn btn-danger mt-2 w-100" name="btnAgregarCarrito" value="app/detalle-producto-pos.php" disabled>
                                                                    <i class="fa-solid fa-warning me-1"></i> Agotado
                                                                </button>
                                                                <?php
                                                            }
                                                        ?>
                                                        
                                                    </div>
                                                  </form>

                                              </div>
                                          </div>
                                      </a>
                                  </div>
                              </div>
                              <!--  -->

                            </div>

                        </div>
                    </div>

                    <div class="btn btn-danger fw-600 fs-5 circlePos flotantePos rounded-pill shadow" onclick="window.location='carritoPos.php?tienda=<?php echo $idTienda; ?>';">
                        <a href="javascript:void(0);" class="btn btn-white btn-sm rounded-pill me-2">
                            <i data-feather="shopping-cart" class="me-1"></i>
                            <span id="salidaCarrito" class="fw-00"><?php echo contarCarrito($idTienda); ?></span>
                        </a>
                        Cobrar
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

            function myFunction()
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
        <?php
            if (file_exists('src/triggers.php'))
            {
                require 'src/triggers.php';
            }
        ?>
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
              myFunction(alertaCarrito);

          </script>
          <?php
        break;


        case 'errorAddedToCart':
          ?>
          <script type="text/javascript">

              var alertaCarrito = document.getElementById('alertaCarritoError');
              alertaCarritoError.style.display = 'block';
              myFunction(alertaCarritoError);

          </script>
          <?php
        break;


        default:
        // code...
        break;
    }
  }
?>
