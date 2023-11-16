<?php

    session_start();
    require '../app/php/conexion.php';
    require '../app/php/funciones.php';

    if (isset($_SESSION['email'], $_SESSION['managedStore']))
    {
        $email    = $_SESSION['email'];
        $idTienda = $_SESSION['managedStore'];
    }
    //$hasActivePayment = validarPagoActivo($conn, $idTienda);

    $hasActivePayment = array();
    $hasActivePayment['existePagoActivo'] = true;
    
    $idTienda = "conejondigital";

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Articulos :: Vendy</title>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css?id=2828" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.13.1/datatables.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/qrcode.js"></script>
    
    
    <style type="text/css">

        .flotante
        {
            position:fixed;
            bottom:25px;
            right:20px;
            margin:0;
            padding:10px;
            z-index: 3000;
        }

        .paginate_button.active
        {
           color: black;
           background-color: white;
        }

        .paginate_button:hover
        {
           color: yellow;
           background-color: green;
        }

        .paginate_button
        {
            background-color: #fff;
            color: #333;
        }

        div.dataTables_filter > label > input
        {
            font-family: 'poppins', Arial, sans-serif;
            font-size: 1em;
            border: 1px solid rgb(33, 47, 115);
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
                                <div class="col-auto mt-4">
                                    <div class="display-6 text-white sombra-titulos-vendy">
                                        <i class="fas fa-boxes fa-sm text-white-50 me-2"></i> Artículos
                                    </div>
                                    <!-- <div class="page-header-subtitle">Agrega y modifica artículos a tu tienda, compártelo con tus clientes o vende en tu tienda física.</div> -->
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>                    
                </header>
                <!-- Main page content-->

                
                <div class="container-xl px-4 mt-n10">

                    <div class="row">

                        <!-- Dashboard info widget 1-->
                        <!-- <div class="col-lg-3 col-xl-6 mb-4">                            
                            <div class="card border-start-lg gradient-red h-100">
                                
                                <div class="card-body">
                                    
                                    <div class="d-flex align-items-center">
                                        
                                        <div class="flex-grow-1">
                                            
                                            <div class="text-xs fw-bold text-white d-inline-flex align-items-center">
                                                <i class="me-1" data-feather="trending-up"></i>
                                                Aumenta tus ventas
                                            </div>

                                            <div class="fw-bold text-white mb-1">
                                                <span class="fw-600">¡Vende más</span> <span class="fw-300">compartiendo</span><span class="fw-600">!</span>
                                            </div>                                                                                       
                                            
                                        </div>

                                        <div class="ms-2">
                                            <i class="text-white-75 feather-xl" data-feather="share-2"></i>
                                        </div>

                                    </div>

                                </div>

                                <div class="card-footer bg-transparent">                                        
                                    <?php
                                    if ($hasActivePayment) 
                                    {
                                    ?>
                                        <button class="btn btn-outline-white rounded-pill w-100 fs-4" data-bs-toggle="modal" data-bs-target="#modalCompartirTienda">
                                            Compartir
                                            <i class="ms-2" data-feather="share"></i>
                                        </button>
                                    <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <a class="btn btn-outline-white rounded-pill w-100 fs-4" href="setup_tienda.php">
                                            Compartir
                                            <i class="ms-2" data-feather="share"></i>
                                        </a>
                                        <?php
                                    }
                                    ?>
                                </div>

                            </div>
                        </div> -->
                    
                        <div class="col-lg-3 col-xl-6 mb-4">
                            <!-- Dashboard info widget 1-->                        
                            <div class="card bg-blue h-100">
                                
                                <div class="card-body">
                                    
                                    <div class="d-flex align-items-center">                                        
                                        <div class="flex-grow-1">                                             

                                            <div class="me-3">                                                
                                                <div class="text-white-75 small">Agrega más</div>
                                                <div class="fs-1 text-white sombra-titulos-vendy fw-500">Productos</div>
                                            </div>                                             
                                            
                                        </div>

                                        <div class="ms-2">
                                            
                                            <i class="text-white-75 feather-xl" data-feather="package"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer bg-transparent">                                                                            
                                    <a class="btn btn-outline-white rounded-pill w-100 fs-4" href="nuevo-articulo.php">
                                        Nuevo artículo                                       
                                    </a>                                    
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-3 col-xl-6 mb-4">                    
                            <div class="card bg-success h-100">
                                
                                <div class="card-body">
                                    
                                    <div class="d-flex align-items-center">                                        
                                        <div class="flex-grow-1">                                             

                                            <div class="me-3">                                                
                                                <div class="text-white-75 small">Que todo esté en</div>
                                                <div class="fs-1 text-white sombra-titulos-vendy fw-500">Orden</div>
                                            </div>                                             
                                            
                                        </div>

                                        <div class="ms-2">
                                            
                                            <i class="text-white-75 feather-xl" data-feather="tag"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer d-flex align-items-center justify-content-between small">                                                
                                    <a class="text-white stretched-link" href="mis-categorias.php">
                                        Gestionar Categorías
                                    </a>
                                    <div class="text-white"><i class="fas fa-angle-right"></i></div>                                    
                                </div>

                            </div>
                        </div>                        
                    
                    </div>                    

                    
                    
                    
                    <div class="card card-header-actions mx-auto rounded-3">                    

                        <div class="card-body">
                            <!-- partial:index.partial.html -->
                            <div class="table-responsive">
                                <table id="tablaArticulosDataTable" class="table border rounded-2 table-bordered table-striped" cellpadding="0" cellspacing="0" border="0" role="grid" aria-describedby="example_info">
                                
                                    <thead>
                                        <tr class="bg-gray-100">
                                            <th>Nombre</th>
                                            <th>Código</th>
                                            <th>Categoría</th>
                                            <th>Precio</th>
                                            <th>Stock</th>
                                            <th>Detalles</th>
                                        </tr>
                                    </thead>

                                    <tfoot>
                                        <tr class="bg-gray-100">
                                            <th>Nombre</th>
                                            <th>Código</th>
                                            <th>Categoría</th>
                                            <th>Precio</th>
                                            <th>Stock</th>
                                            <th>Detalles</th>
                                        </tr>
                                    </tfoot>

                                    <tbody>
                                        <?php

                                        $ssql = "SELECT
                                                    productos.nombre AS nombreProducto,
                                                    productos.precio,
                                                    productos.barcode,
                                                    productos.inventario,
                                                    productos.unidadVenta,
                                                    productos.isActiveOnlineStore,
                                                    productos.idProducto,
                                                    imagenProducto.url
                                                FROM
                                                    productos
                                                LEFT JOIN
                                                    imagenProducto
                                                ON
                                                    productos.idProducto = imagenProducto.idProducto
                                                AND
                                                    productos.idTienda   = imagenProducto.idTienda
                                                WHERE
                                                    productos.idTienda = '$idTienda'
                                                AND 
                                                    productos.isActive = 1
                                                AND 
                                                imagenProducto.isPrincipal = 1";

                                        $sql = "SELECT
                                                    productos.nombre AS nombreProducto,
                                                    productos.precio,
                                                    productos.barcode,
                                                    productos.inventario,
                                                    productos.unidadVenta,
                                                    productos.isActiveOnlineStore,
                                                    productos.idProducto,
                                                    categoriasTienda.nombre AS nombreCategoria
                                                FROM
                                                    productos
                                                LEFT JOIN categoriasTienda ON productos.idCategoria = categoriasTienda.idCategoria
                                                WHERE
                                                    productos.idTienda = '$idTienda' AND isActive = 1";

                                        $result = mysqli_query($conn, $sql);

                                        if (mysqli_num_rows($result) > 0)
                                        {
                                            while ($row = mysqli_fetch_assoc($result))
                                            {   
                                                // echo "<pre>";
                                                // var_dump($row);
                                                ?>

                                                <tr onclick="location.href='edita-producto.php?id=<?= $row['idProducto'] ?>';" style="cursor: pointer;">
                                                    <td class="fw-600"><?= ucwords($row['nombreProducto']) ?></td>
                                                    <td class="fw-400 small"><?= $row['barcode'] ?></td>

                                                    <td class="">
                                                        <span class="text-nowrap">
                                                            <?php 
                                                            if (!empty($row['nombreCategoria'])) 
                                                            { 
                                                                echo ucwords($row['nombreCategoria']); 
                                                            }
                                                            else
                                                            {
                                                                ?>
                                                                <div class="small"> - </div>
                                                                <?php
                                                            }
                                                            ?>
                                                        </span>
                                                    </td>

                                                    <td><?php echo "$&nbsp;" . number_format($row['precio'], 2) ?></td>
                                                    <?php if ($row['inventario'] == 'ilimitado'): ?>
                                                        <td>
                                                            <span class="badge bg-blue-soft text-blue">Digital</span>
                                                        </td>
                                                    <?php else: ?>
                                                        <td>
                                                            <?= $row['inventario'] ?> <?= $row['unidadVenta'] ?>
                                                        </td>
                                                    <?php endif; ?>
                                                    <td class="text-center">
                                                        <a class="btn btn-blue-soft btn-sm rounded-pill" href="edita-producto.php?id=<?= $row['idProducto'] ?>">
                                                            <i class="far fa-eye me-1"></i> Detalle
                                                        </a>
                                                        <!-- <button class="btn btn-danger btn-sm btn-icon"><i data-feather="trash-2"></i></button> -->
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        mysqli_close($conn);
                                        ?>
                                    </tbody>

                                </table>
                            </div>

                            <!-- partial -->
                            <script src='https://cdn.datatables.net/v/bs-3.3.6/jqc-1.12.3/jszip-2.5.0/pdfmake-0.1.18/dt-1.10.12/af-2.1.2/b-1.2.2/b-colvis-1.2.2/b-html5-1.2.2/b-print-1.2.2/cr-1.3.2/fc-3.2.2/fh-3.1.2/kt-2.1.3/r-2.1.0/rr-1.1.2/sc-1.4.2/se-1.2.0/datatables.min.js'></script>
                            <!-- <script  src="js/scriptDT.js?id=11"></script> -->
                        </div>

                    </div>
                    <div id="qrcode" class="d-flex justify-content-center p-3"></div>
                </div>
                
            </main>
            
            <?php
              if (file_exists('src/footer.php')) { include 'src/footer.php'; }
            ?>
        </div>
    </div>
    <script src="js/funciones.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="js/datatables/datatables-mis-articulos.js?id=28"></script>
    <?php if (file_exists('src/modals.php')) { include 'src/modals.php'; } ?>
    <script type="text/javascript">

        $('.paginate_button.active').removeClass('active');

        function downloadURI(uri, name)
        {
            var link = document.createElement("a");
            link.download = name;
            link.href = uri;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            delete link;
        }            

        function makeCodeUrlPago(contenidoQR)
        {
            let qrcode = new QRCode(document.getElementById("qrcode"),
            {
            text: contenidoQR,
            width: 1080,
            height: 1080,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
            });

            setTimeout(
                function ()
                {
                    let dataUrl = document.querySelector('#qrcode').querySelector('img').src;
                    var tienda = '<?php echo $_SESSION['managedStore']; ?>';
                    downloadURI(dataUrl, 'vendyQR_' + tienda + '.png');
                }, 1000
            );
        }

    </script>
</body>
</html>
<?php
  if (file_exists('src/triggers.php'))
  {
    include 'src/triggers.php';
  }
?>
