<?php

    session_start();

    require 'app/php/conexion.php';
    require 'app/php/funciones.php';

    // echo "<pre>";
    // print_r($_SESSION);
    
    $whatsappMsg = "https://api.whatsapp.com/send?phone=5215610346590&text=Hola, requiero ayuda con mi cuenta conejondigital.com";

    if (isset($_GET['tienda']))
    {
        $tienda = $_GET['tienda'];
        $tienda = getDatosTienda($conn, $tienda); // $tienda recibe el idOwner y username(tienda)


        if ($tienda === false || (isset($tienda['isActive']) && $tienda['isActive'] == 0))
        {
            die("Redirecciona, usuario no encontrado");
        }

        $idTienda = $tienda['idTienda'];
        $idOwner  = $tienda['administradoPor'];
        $nombreTienda  = $tienda['nombreTienda'];
        
        $_SESSION['ultimaTiendaVisitada'] = $idTienda;
    }

    $categoriasTienda = getCategoriasTienda($conn, $idTienda); 
    
    $categoriasConProducto = getCategoriasConProductos($conn, $idTienda);

    echo "<pre>";
    print_r($categoriasConProducto);
    die("Fin");

    $productos     = getProductosTiendaPerfilPublico($conn, $idTienda, 0);

    $hasActivePayment = validarPagoActivo($conn, $idTienda);
    $comentarios   = getComentariosTienda($conn, $idTienda);

    $reputacion = getReputacionTienda($conn, $tienda);
 
    $mediosContacto = getMediosContactoVendedor($conn, $idTienda);
    $metodosDePagoTienda = getMetodosDePagoTienda($conn, $idTienda);

    $sucursales = getSucursalesTienda($conn, $idTienda);

    echo "<pre>";
    print_r($productos);
    var_dump($productos);
    die;

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="description" content="" />
        <meta name="author" content="" />
        
        <meta property="og:url"          content="https://vendy.click/" />
        <meta property="og:type"         content="article" />
        <meta property="og:title"        content="<?php echo $idTienda; ?>: Tienda en línea" />
        <meta property="og:description"  content="VENDY: Tu tienda en línea 🚀" />
        <meta property="og:image"        content="https://vendy.click/assets/img/vendy_metafb.jpg" />

        <title><?php echo $idTienda; ?></title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="app/css/styles.css?id=2828" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="app/assets/img/favicon.png" />
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="app/js/qrcode.js?id=28"></script>

        <style type="text/css">

            /* Remover flechas del input numero */
            input[type=number]::-webkit-inner-spin-button,
            input[type=number]::-webkit-outer-spin-button
            {
                -webkit-appearance: none;
                margin: 0;
            }

            img
            {
                /* box-shadow: 8px 8px 3px rgba(0,0,0,0.2); */
                /* -moz-box-shadow: 8px 8px 3px rgba(0,0,0,0.2); */
                /* -webkit-box-shadow: 8px 8px 3px rgba(0,0,0,0.2); */
                /* -khtml-box-shadow: 8px 8px 3px rgba(0,0,0,0.2); */
            }
            
            div.scrollmenu 
            {            
                background-color: #333;
                overflow: auto;
                white-space: nowrap;
            }        

            div.scrollmenu a 
            {
                display: inline-block;                
                text-align: center;                
                padding: 14px;
                text-decoration: none;
            }

            div.scrollmenuProductos
            {                            
                overflow: auto;
                white-space: nowrap;
            }        

            div.scrollmenuProductos a 
            {
                display: inline-block;  
                text-align: center; 
                text-decoration: none;
            }

            /* div.scrollmenu a:hover 
            {
                background-color: #777;
            } */

            

            .scrolling-wrapper 
            {
                overflow-x: scroll;
                overflow-y: hidden;
                white-space: nowrap;
                
                .itemCard {
                    display: inline-block;
                }
            }

            .scrolling-wrapper-flexbox 
            {
                display: flex;
                flex-wrap: nowrap;
                overflow-x: auto;
                padding: 10px;
                .itemCard {
                    flex: 1 1 auto;
                    margin-right: 10px;
                }
            }
 

            .scrolling-wrapper, .scrolling-wrapper-flexbox 
            { 
                margin-bottom: 10px;
                width: 100%;
                -webkit-overflow-scrolling: touch;
                &::-webkit-scrollbar {
                    display: none;
                }
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
                    if (file_exists('src/sidenav-dark.php'))
                    {
                        require 'src/sidenav-dark.php';
                    }
                ?>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <header class="page-header page-header-dark bg-pattern-white-75 mb-1">
                        <div class="container-xl px-4">
                            <div class="page-header-content pt-4">
                                <div class="mb-2">
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
                                
                                <?php

                                //var_dump($reputacion);
                                if ($hasActivePayment !== false && $hasActivePayment['existePagoActivo'] == true)
                                {
                                        echo '<div class="row">';
                                        if (isset($reputacion) && $reputacion !== false)
                                        {
                                            ?>
                                            <!-- Ver calificaciones -->
                                        <div class="col-lg-12 col-md-12 col-xl-8 mb-2">
                                            <div class="bg-ama bg-opacity-75 text-dark shadow border-start border-lg rounded border-white p-3 mb-3">
                                                <a href="javascript: void(0);" class="" data-bs-toggle="modal" data-bs-target="#modalReputacion">
                                                    <?php
                                                        // echo "<pre>";
                                                        echo(number_format(($reputacion['calificacion']), 2));
                                                    ?>
                                                    <i class="fa-solid fa-star me-1"></i>
                                                    Ver calificaciones
                                                </a>
                                            </div>
                                            </div>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <!-- <div class="col-lg-5 col-md-6 col-xl-8 mb-2">
                                                <div class="bg-transparent text-dark shadow-lg border-start border-lg rounded border-white p-3 mb-3">
                                                    <a href="javascript: void(0);" class="me-2 text-dark" data-bs-toggle="modal" data-bs-target="#modalReputacion">
                                                        <i class="fa-solid fa-star text-dark"></i>
                                                        Ver calificaciones
                                                    </a>
                                                </div>
                                            </div> -->
                                            <?php
                                        }
                                    ?>
                                        <!-- Datos Contacto -->
                                        <div class="mb-2">
                                            <div class="d-flex justify-content-center">

                                                <!-- Contacto tienda -->
                                                <button type="button" class="btn btn-primary btn-icon btn-lg shadow-sm me-1" data-bs-toggle="modal" data-bs-target="#modalContactoTienda">
                                                    <i class="fas fa-store fa-lg text-white"></i>
                                                </button>

                                                <!-- Medios de pago tienda -->
                                                <button type="button" class="btn bg-orange btn-icon btn-lg shadow-sm me-1" data-bs-toggle="modal" data-bs-target="#modalSucursalesTiendaPerfil">
                                                    <i class="fas fa-map-marker-alt text-white fa-lg"></i>
                                                </button>

                                                <!-- Share -->
                                                <button type="button" class="btn bg-pattern-pdv btn-icon btn-lg shadow-sm me-1" data-bs-toggle="modal" data-bs-target="#modalContactoTienda2">
                                                    <i class="text-white feather-lg" data-feather="share-2"></i>
                                                </button>

                                                <!-- REPORTE -->
                                                <!-- <button type="button" class="btn bg-transparent border-1 shadow-sm border-dark btn-icon btn-lg me-1" data-bs-toggle="modal" data-bs-target="#modalMediosDeContacto">
                                                    <i class="fas fa-exclamation-triangle fa-lg text-dark"></i>
                                                </button> -->

                                            </div>
                                        </div>                                          
                                    <?php
                                    echo "</div>";
                                }
                                else
                                {
                                    ?>
                                    <div class="col-lg-4 mt-3">
                                        <div class="bg-ama text-dark shadow-lg border-start border-lg rounded border-white p-3 mb-3" data-bs-toggle="modal" data-bs-target="#modalPerfilVerificado" style="cursor: pointer;">
                                            Tienda pendiente de verificación
                                            <button type="button" class="btn btn-icon btn-outline-dark btn-xs" name="button" data-bs-toggle="modal" data-bs-target="#modalInfoReputacion">
                                                <i class="fas fa-info"></i>
                                            </button>
                                            <!-- <div class="collapse text-dark mt-2" id="datosVendedor" data-bs-parent="#accordionSidenav">
                                            </div> -->
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>

                                <div id="notificacion">

                                    <div id="alertaCarrito" style="display: none;">
                                        <div class="alert alert-success alert-solid alert-icon" role="alert" style="--fa-beat-scale: 0.99; --fa-animation-duration: 1s;">
                                            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                                            <div class="alert-icon-aside">
                                                <i class="fas fa-check-circle"></i>
                                            </div>
                                            <div class="alert-icon-content">
                                                <h6 class="alert-heading">Notificación</h6>
                                                    <?php
                                                    
                                                    $contador = null;
                                                    $idProducto = $_GET['idProducto'];
                                                    foreach ($productos as $index => $producto) 
                                                    {
                                                        if ($producto['idProducto'] === $idProducto) 
                                                        {
                                                            $contador = $index;
                                                            break;
                                                        }
                                                    }
                                                    
                                                    if ($contador !== null) 
                                                    {
                                                        echo "<i> \"" . $productos[$contador]['nombre'] . "\" </i>";
                                                    }
                                                    else
                                                    {
                                                        echo "No se encontró ningún producto con idProducto " . $idProducto;
                                                    }                                                
                                                    ?>
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

                                    <div id="alertaInventarioInsuficiente" style="display: none;">
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

                                </div>

                            </div>
                        </div>
                    </header>



                    <?php
                    if ($productos !== false)
                    {
                        ?>                    
                        <div class="mt-n5">
                            <div class="">
                                <div class="px-5 bg-green scrollmenu fw-300">
                                    <!-- <i class="fas fa-tags text-white-50"></i> -->
                                    <button class="btn btn-icon btn-green btn-sm"><i class="text-white" data-feather="tag"></i></button>
                                    <?php
                                        foreach ($categoriasConProducto as $catIndex => $categoria) 
                                        {                                                
                                            ?>
                                            <a class="btn shadow-none text-white fs-6" href="#<?php echo $categoria['nombre']; ?>"><?php echo ucwords($categoria['nombre']); ?></a>
                                            <?php
                                        }
                                    ?>
                                </div>
                            </div>                        
                        </div>
                        <?php
                    }
                    ?>
                    
                    <!-- Main page content-->
                    <div class="container-xl px-4 mt-3">
                                            
                        <?php
                        if ($productos !== false)
                        {                            
                            
                            $categoriaActual = "";
                            foreach ($productos as $key => $row) 
                            {
                                
                                // Mostrar nombre de categoría
                                if ($categoriaActual != $row["nombreCategoria"]) 
                                {
                                    // Cerrar el div anterior, si es necesario
                                    if ($categoriaActual != "") {
                                        echo "</div>";
                                    }
                                    
                                    ?>                                    
                                    <div class="border-bottom mb-2 p-2 display-6 poppins-font" id="<?php echo $row["nombreCategoria"]; ?>"><?php echo ucfirst($row["nombreCategoria"]); ?></div>
                                    <?php
                                    
                                    // Abrir un nuevo div para la nueva categoría
                                    echo "<div class='scrolling-wrapper-flexbox mb-3'>";                                    
                                    
                                    // Actualizar la categoría actual
                                    $categoriaActual = $row["nombreCategoria"];
                                }
                                ?>
                                <div class="itemCard pe-2">
                                    <div class="col-sm-12 col-md-12 col-12 col-lg-12 col-xl-12 me-4">
                                        <div class="bg-pattern-white-75 rounded-3 shadow-sm h-100 text-decoration-none">
                                            <div class="p-1 mt-1 d-flex justify-content-center flex-column">
                                                <div class="align-items-center justify-content-between">

                                                    <!-- BLOQUE IMAGEN PRODUCTO -->
                                                    <div class="text-center mb-1 mt-1" style="cursor: pointer;" onclick="location.href='detalle-producto.php?idProducto=<?php echo $row['idProducto']; ?>&tienda=<?php echo $row['idTienda']; ?>'" >
                                                        <img class="img-fluid rounded-2" src="<?php echo $dominio; ?>app/verifica/usr_docs/<?php echo $row["idTienda"]; ?>/productos/<?php echo $row["idProducto"]; ?>/<?php echo $row["url"]; ?>" alt="<?php echo $row["nombre"]; ?>" style="height: 10rem;"/>
                                                    </div>

                                                    <!-- BLOQUE BOTONES -->
                                                    <div class="">
                                                        <!-- <i class="feather-xl text-primary mb-3" data-feather="package"></i> -->
                                                        <form action="app/procesa.php" method="post">

                                                            <div class="p-4 rounded-bottom m-2" style="--bs-bg-opacity: .1;">

                                                                <!-- Inputs hidden -->
                                                                <input type="hidden" name="idProducto" value="<?php echo $row['idProducto']; ?>">
                                                                <input type="hidden" name="idTienda" value="<?php echo $row['idTienda']; ?>">

                                                                <!-- Nombre producto -->
                                                                <div class="poppins-font fw-300 fs-2 text-dark text-start mb-1" style="cursor: pointer;" onclick="location.href='detalle-producto.php?idProducto=<?php echo $row['idProducto']; ?>&tienda=<?php echo $row['idTienda']; ?>'" src="<?php echo $dominio; ?>/app/verifica/usr_docs/<?php echo $row["idTienda"]; ?>/productos/<?php echo $row["idProducto"]; ?>/<?php echo $row["url"]; ?>">
                                                                    <span class="">
                                                                        <?php echo $row["nombre"]; ?>
                                                                    </span>
                                                                </div>

                                                                <!-- Boton detalle y precio -->
                                                                <div class="d-flex w-100 mb-3 flex-sm-row align-items-center">
                                                                    <div class="col flex-grow-1 text-start" id="btnGroupAddon">
                                                                        <div class="d-flex align-items-start justify-content-start">
                                                                            <div class="text-success fw-600 me-2 mt-2">$</div>
                                                                            <div>
                                                                                <span class="fw-300 fs-1 text-success">
                                                                                    <?php echo number_format($row["precio"], 2); ?>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col text-end " style="cursor: pointer;" onclick="location.href='detalle-producto.php?idProducto=<?php echo $row['idProducto']; ?>&tienda=<?php echo $row['idTienda']; ?>'">
                                                                        <butotn class="fw-600 rounded-3 btn btn-outline-primary btn-sm">
                                                                            <i class="me-1" data-feather="eye"></i> Detalle
                                                                        </butotn>
                                                                    </div>
                                                                </div>

                                                                <!-- Mostrar Stock -->
                                                                <?php
                                                                if ($hasActivePayment !== false && $hasActivePayment['existePagoActivo'] == true)
                                                                {
                                                                ?>
                                                                    <div class="col-auto text-center">
                                                                        <span class="form-text small"><?php echo $row['inventario'] . (($row['unidadVenta'] == "Kilogramos") ? " Kgs. Disponible(s)" : " Pzs. Disponible(s)"); ?></span>
                                                                    </div>
                                                                <?php
                                                                }

                                                                if ($hasActivePayment !== false && $hasActivePayment['existePagoActivo'] == true)
                                                                {
                                                                    if ($row['unidadVenta'] == "Kilogramos")
                                                                    {
                                                                        ?>
                                                                        <div class="input-group mb-2 mt-2 w-100 disable-dbl-tap-zoom">
                                                                            <input type="number" class="form-control shadow-none border-2 border-success" name="stock" value="10" id="<?php echo $row['id']; ?>" min="10" step="10" onchange="validarStock(this)" required>

                                                                            <button class="btn btn-outline-success border border-success" type="button" onclick="decrementValueGranel(<?php echo $row['id']; ?>)">
                                                                                <i class="fas fa-minus"></i> 
                                                                            </button>

                                                                            <button class="btn btn-outline-success border border-success" type="button" onclick="incrementValueGranel(<?php echo $row['id']; ?>)">
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
                                                                            <div class="input-group mb-2 mt-2 w-100 disable-dbl-tap-zoom">
                                                                                <button class="btn btn-outline-success border-2 btn-sm" type="button" onclick="decrementValue(<?php echo $row['id']; ?>)">
                                                                                    <i class="fas fa-minus fa-lg"></i>
                                                                                </button>

                                                                                <input type="number" class="form-control form-control-sm text-center fw-600 fs-4 shadow-none border-2 border-success" name="stock" value="1" id="<?php echo $row['id']; ?>" min="1" step="1" pattern="[0-9]*" required>

                                                                                <button class="btn btn-outline-success border-2 btn-sm" type="button" onclick="incrementValue(<?php echo $row['id']; ?>)">
                                                                                    <i class="fas fa-plus fa-lg"></i>
                                                                                </button>
                                                                            </div>
                                                                        <?php
                                                                    }

                                                                    ?>
                                                                    <button type="submit" class="btn btn-primary fs-6 w-100 shadow-sm rounded-3" name="btnAgregarCarrito" value="perfil.php" <?php echo ($row['inventario'] <= 0) ? 'disabled' : ''; ?>>
                                                                        <i class="me-2 feather-lg" data-feather="shopping-bag"></i> Agregar
                                                                    </button>
                                                                    <?php
                                                                }
                                                                ?>

                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }

                            // Cerrar el último div, si es necesario
                            if ($categoriaActual != "") 
                            {
                                echo "</div>";
                            }                        

                        }
                        else
                        {
                        ?>
                            <div class="d-flex justify-content-center">
                                <div class="col-lg-6">
                                    <a class="card h-100 text-decoration-none">
                                        <div class="card-body d-flex justify-content-center flex-column">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <img src="app/assets/img/taken.svg" alt="..." style="width: 12rem" />
                                                <div class="ms-2 p-3  ">
                                                    <h5>Ups! Parece que se llevaron todo</h5>
                                                    <div class="small text-gray-700">No hay productos disponibles, vuelve más tarde.</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                             
                    </div>
                    
                    <!-- Botón flotante de busqueda -->
                    <!-- <a class="botonFlotante btn btn-indigo btn-icon text-white shadow-sm" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                        <i class="feather-lg" data-feather="search"></i>
                    </a> -->

                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                        <div class="offcanvas-header bg-pattern-pdv text-white">                            
                            <span id="offcanvasRightLabel text-white fw-300">Filtrar busqueda</span>
                            <button type="button" class="btn btn-icon btn-outline-white btn-sm" data-bs-dismiss="offcanvas" aria-label="Close">
                                <i class="fa-solid fa-xmark fa-xl"></i>
                            </button>
                        </div>
                        
                        <div class="offcanvas-body bg-pattern-white">
                            
                            <div class="text-end">
                                <button class="btn btn-primary" type="submit">
                                    Buscar                            
                                </button>
                            </div>
                        </div>
                    </div>
                    
                </main>
                <?php
                    if (file_exists('app/src/footer.php'))
                    {
                        require 'app/src/footer.php';
                    }
                ?>
            </div>
        </div>

        <div class="modal fade" id="modalReputacion" tabindex="-1" aria-labelledby="modalReputacionLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">

              <?php
              if ($hasActivePayment !== false && $hasActivePayment['existePagoActivo'] == true)
              {
              ?>
                  <div class="rounded-top p-2 bg-pattern-ama text-center text-dark">
                    <span class="align-items-center">
                        <?php echo $tienda['idTienda']; ?>
                        <a class="text-decoration-none text-dark" style="font-size: 20px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modalCuentaVerificada">
                            <span class="tw-verified-badge tw-icon-defaults tw-hidden" style="--fa-beat-scale: 0.9;" title="Verified Account"></span>
                        </a>
                    </span>
                    <p class="small">Tienda verificada <i class="fa-regular fa-circle-check align-middle"></i></p>
                    <!-- <button type="button" class="btn btn-icon btn-outline-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark fa-xl"></i>
                    </button> -->
                  </div>
              <?php
              }

              ?>
              <div class="modal-body">
                  <h4 class="fw-600 mt-2 mb-3 text-primary">Reviews de clientes</h4>
                  <?php
                      if ($comentarios !== false)
                      {
                          foreach ($comentarios as $key => $value)
                          {
                              ?>
                              <ul class="list-group">
                                  <li class="list-group-item mb-3">
                                      <div class="media">
                                          <div class="media-body">
                                              <!-- <h5 class="mt-0"> -->
                                                  <?php
                                                  //echo ocultarNombreCliente($value['nombre']) . " " . ocultarNombreCliente($value['paterno']);
                                                  ?>
                                              <!-- </h5> -->
                                              <blockquote cite="">
                                                <?php echo $value['comentario']; ?>
                                              </blockquote>
                                              <div class="rating">

                                                    <?php showStars($value['calificacion']*2); ?>
                                                    <span class="small text-muted">
                                                      <?php echo ($value['calificacion']); ?>/5
                                                    </span>

                                              </div>
                                          </div>
                                      </div>
                                  </li>
                              </ul>
                              <?php
                          }
                      }
                      else
                      {
                          echo "Aún no hay suficientes calificaciones.";
                      }
                  ?>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Modal perfil Verificado Inicio 6-->
        <div class="modal fade" id="modalCuentaVerificada" tabindex="-1" aria-labelledby="modalCuentaVerificadaLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <?php
              if ($hasActivePayment !== false && $hasActivePayment['existePagoActivo'] == true)
              {
              ?>
                  <div class="rounded-top p-3 bg-pattern-ama text-center text-dark">
                    <span class="align-items-center fw-500 fs-6">
                        <?php echo $idTienda; ?>
                        <a class="text-decoration-none text-dark" style="font-size: 20px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modalCuentaVerificada">
                            <span class="tw-verified-badge tw-icon-defaults tw-hidden" style="--fa-beat-scale: 0.9;" title="Verified Account"></span>
                        </a>
                    </span>
                    <!-- <button type="button" class="btn btn-icon btn-outline-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark fa-xl"></i>
                    </button> -->
                  </div>
              <?php
              }
              else
              {
              ?>
                  <div class="rounded-top p-3 bg-danger text-center text-white">
                      <span class="align-items-center">
                          <i class="fa-solid fa-store text-white iconTitulo"></i>
                          <?php echo $idTienda; ?>
                      </span>
                      <p>Tienda no verificada <i class="fa-regular fa-times-circle align-middle fs-4"></i></p>
                      <!-- <button type="button" class="btn btn-icon btn-outline-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">
                          <i class="fa-solid fa-xmark fa-xl"></i>
                      </button> -->
                  </div>

              <?php
              }
              ?>
              <div class="modal-body p-4">
                <p class="h2 fw-600 mb-2">Badges</p>
                <hr class="text-gray-400 mx-1">
                <div class="mb-3">
                    <p class="h3 fw-400 text-primary">
                      Verificación
                      <a class="text-decoration-none text-dark" style="font-size: 20px; cursor: pointer;">
                          <span class="tw-verified-badge tw-icon-defaults tw-hidden" style="--fa-beat-scale: 0.9;" title="Verified Account"></span>
                      </a>
                    </p>
                    <span class="fw-300 h6">Este badge indica que se trata de un perfil verificado, es decir, los datos bancarios del vendedor <b>han sido corroborados</b> y cuenta con una <b>reputación válida</b>.</span>
                </div>

                <div class="mb-3">
                    <p class="h3 fw-400 text-primary">Pendiente de Verificación <i class="fa-regular fa-times-circle fs-6"></i></p>
                    <span class="fw-300 h6">Este badge indica que aún no verificamos sus datos bancarios, protege tu dinero comprando sólo con vendedores verificados o bien, usa pago contra entrega.</span>
                </div>


              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-green" data-bs-dismiss="modal">Entendido</button>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal perfil Verificado Fin -->

        <!-- modal X -->
        <div class="modal fade" id="modalInfoReputacion" tabindex="-1" aria-labelledby="modalInfoReputacionLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <?php
              if ($hasActivePayment !== false && $hasActivePayment['existePagoActivo'] == true)
              {
              ?>
                  <div class="rounded-top p-3 bg-ama text-center text-dark">
                    <span class="align-items-center fw-500">
                      <?php echo $tienda['username']; ?>
                    </span>
                    <p>Tienda verificada<i class="fa-regular fa-circle-check align-middle fs-4"></i></p>
                    <!-- <button type="button" class="btn btn-icon btn-outline-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark fa-xl"></i>
                    </button> -->
                  </div>
              <?php
              }
              else
              {
              ?>
                  <div class="rounded-top p-3 bg-danger text-center text-white">
                    <span class="align-items-center">
                      <i class="fa-solid fa-store text-white iconTitulo"></i>
                      <?php echo $tienda['idTienda']; ?>
                    </span>
                    <p>Tienda no verificada <i class="fa-regular fa-times-circle align-middle fs-4"></i></p>
                    <!-- <button type="button" class="btn btn-icon btn-outline-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark fa-xl"></i>
                    </button> -->
                  </div>

              <?php
              }
              ?>
              <div class="modal-body">
                  Aún no verificamos los datos de esta tienda, protege tu dinero comprando sólo con vendedores verificados o bien, usa sólo pago contra entrega en alguna sucursal física.
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
        </div>
        <!-- modal X -->

        <!-- modal modalMediosDeContacto Inicio-->
        <div class="modal fade" id="modalContactoTienda" tabindex="-1" aria-labelledby="modalContactoTiendaLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <?php
                    if (isset($hasActivePayment))
                    {
                    ?>
                        <div class="rounded-top p-2 bg-pattern-ama text-center text-dark">

                            <div class="fw-500 fs-5 align-items-center mb-1 mt-2">
                                <?php echo $tienda['idTienda']; ?>
                                <a class="text-decoration-none text-dark" style="font-size: 20px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modalCuentaVerificada">
                                    <span class="tw-verified-badge tw-icon-defaults tw-hidden" style="--fa-beat-scale: 0.9;" title="Verified Account"></span>
                                </a>
                            </div>

                            <p class="small">Tienda verificada <i class="fa-regular fa-circle-check align-middle"></i></p>
                            <!-- <button type="button" class="btn btn-icon btn-outline-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa-solid fa-xmark fa-xl"></i>
                            </button> -->
                        </div>
                    <?php
                    }
                    ?>

                    <div class="modal-body">
                        <div class="m-0 text-dark">
                            <div class="list-group list-group-flush">

                                <div class="m-2">
                                    <div class="d-flex justify-content-center mt-2">
                                        <ul class="nav nav-pills card-header-pills" id="cardPill" role="tablist">
                                            <li class="nav-item"><a class="nav-link fw-300   rounded-3 active" id="overview-pill" href="#overviewPill" data-bs-toggle="tab" role="tab" aria-controls="overview" aria-selected="true">Contacto</a></li>
                                            <li class="nav-item"><a class="nav-link fw-300   rounded-3" id="example-pill" href="#examplePill" data-bs-toggle="tab" role="tab" aria-controls="example" aria-selected="false">Pago</a></li>
                                        </ul>
                                    </div>
                                    <div class="m-2">
                                        <div class="tab-content" id="cardPillContent">
                                            <div class="tab-pane fade show active" id="overviewPill" role="tabpanel" aria-labelledby="overview-pill">
                                                <!-- <h5 class="card-title">Pill Navigation Card</h5> -->
                                                <p class="card-text">
                                                    <?php
                                                        // echo "<pre>";
                                                        // print_r($mediosContacto);
                                                        if ($mediosContacto !== false)
                                                        {
                                                            foreach ($mediosContacto as $key => $contactoTienda)
                                                            {
                                                                // echo "<pre>";
                                                                // print_r($contactoTienda);
                                                                if ($contactoTienda['isPublicOnline'] == 1 && strlen($contactoTienda['data'])>0)
                                                                {
                                                                    // Obtener la descripción del contacto y su alias
                                                                    $descripcion = $contactoTienda['data'];
                                                                    $icono = $contactoTienda['alias'];
                                                                    $alias = $contactoTienda['alias'];

                                                                    switch ($icono)
                                                                    {
                                                                        case 'TELEFONO':
                                                                            $icono  = '<i data-feather="phone" class=""></i>';
                                                                            $enlace = 'tel:' . $descripcion;
                                                                            $color  = "cyan";
                                                                        break;

                                                                        case 'EMAIL':
                                                                            $icono = '<i data-feather="mail" class=""></i>';
                                                                            $enlace = 'mailto:' . $descripcion;
                                                                            $color  = "purple";
                                                                        break;

                                                                        case 'FACEBOOK':
                                                                            $icono  = '<i class="fab fa-facebook-f fa-lg"></i>';
                                                                            $enlace = $descripcion;
                                                                            $color  = "primary";
                                                                        break;

                                                                        case 'INSTAGRAM':
                                                                            $icono = '<i class="fab fa-instagram  fa-lg"></i>';
                                                                            $enlace = $descripcion;
                                                                            $color  = "pink";
                                                                        break;

                                                                        case 'WHATSAPP':
                                                                            $icono = '<i class="fab fa-whatsapp fa-lg"></i>';
                                                                            $enlace = "https://api.whatsapp.com/send/?phone=" . $descripcion . "&text=Hola, vengo de _" . $dominio . $idTienda . "_ %0ATengo una duda respecto a sus productos _..._";
                                                                            $color  = "green";
                                                                        break;

                                                                        case 'YOUTUBE':
                                                                            $icono = '<i class="fab fa-youtube fa-lg"></i>';
                                                                            $enlace = $descripcion;
                                                                            $color  = "danger";
                                                                        break;

                                                                        default:
                                                                            echo ''; // En caso de que no haya un icono correspondiente
                                                                        break;
                                                                    }

                                                                    // Crear el enlace HTML
                                                                    $linkHtml = sprintf('<a class="btn btn-icon" href="%s"><span class="ms-2">%s</span>', $enlace, $icono);

                                                                    // Creamos ID único
                                                                    $idUnico = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz'), 0, 28);

                                                                    ?>
                                                                    <div class="list-group-item">
                                                                        <div class="d-flex bd-highlight justify-content-center">
                                                                            <div class="mb-0 p-2 flex-grow-1 bd-highlight align-self-center">
                                                                                <input type="text" readonly class="form-control border-0 bg-white fs-6 fw-300 text-start shadow-none" value="<?php echo $descripcion; ?>" id="<?php echo $idUnico; ?>">
                                                                            </div>
                                                                            <div class="mb-0 bd-highlight align-self-center">
                                                                                <button type="button" class="btn btn-light btn-icon m-1" onClick="copiarPortapapeles('<?php echo $idUnico; ?>');">
                                                                                    <i class="" data-feather="copy"></i>
                                                                                </button>
                                                                                <a class="btn btn-icon btn-<?php echo $color; ?> m-1" href="<?php echo $enlace; ?>" target="_blank">
                                                                                    <?php echo $icono; ?>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                </p>
                                            </div>

                                            <div class="tab-pane fade" id="examplePill" role="tabpanel" aria-labelledby="example-pill">
                                                <h5 class="card-title text-center mt-4 fw-300">Medios de pago aceptados por la tienda:</h5>
                                                <p class="card-text">
                                                    <?php
                                                    if ($metodosDePagoTienda)
                                                    {
                                                        foreach ($metodosDePagoTienda as $key => $pago)
                                                        {
                                                            $mp  = mb_strtoupper($pago['banco']);
                                                            $mp .= "," . $pago['clabe'];
                                                            $mp .= "," . $pago['numeroTarjeta'];
                                                            $mp .= "," . $pago['id'];
                                                            $terminacion = $pago['numeroTarjeta'];
                                                            ?>

                                                            <div class="col-12 mb-4 mt-2">
                                                                <div class="card bg-success text-white h-100">
                                                                    <div class="card-body">
                                                                        <div class="d-flex justify-content-between align-items-center">
                                                                            <div class="me-3">
                                                                                <div class="fw-600 fs-4 text-white">
                                                                                    <?php echo ucwords($pago['nombre']); ?>
                                                                                </div>

                                                                                <?php
                                                                                // Calcular cambio Efectivo
                                                                                if ($pago['idMetodoDePago'] == "CASH")
                                                                                {
                                                                                ?>
                                                                                    <!-- <div class="small text-white fw-200" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modalCalcularCambioEfectivo">
                                                                                        Calcular cambio <i class="fas fa-hand-holding-usd"></i>
                                                                                    </div> -->
                                                                                <?php
                                                                                }

                                                                                // Mostrar datos de tarjeta/cuenta
                                                                                if (!empty($terminacion))
                                                                                {
                                                                                ?>
                                                                                    <div class="text-white-75 small fw-300">Banco <?php echo  $pago['banco']; ?></div>
                                                                                    <div class="text-white-75 small fw-300">Tarjeta: <?php echo  $terminacion; ?></div>
                                                                                    <div class="text-white-75 small fw-300">Clabe: <?php echo  $pago['clabe']; ?></div>
                                                                                    <div class="text-white-75 small fw-300">Beneficiario: <?php echo mb_strtoupper(strtolower($pago['beneficiario'])); ?></div>

                                                                                <?php
                                                                                }

                                                                                if ($pago['idMetodoDePago'] == "MP" || $pago['idMetodoDePago'] == "PP")
                                                                                {
                                                                                ?>
                                                                                    <span class="text-white small fw-200" style="cursor: pointer;">
                                                                                        <?php echo $pago['urlPago']; ?>
                                                                                    </span>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                            <div class="display-6 text-white-50">
                                                                                <?php echo $pago['icono']; ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="card-footer text-white" style="cursor:pointer;">
                                                                    <?php
                                                                    switch (true)
                                                                    {
                                                                        case (isset($pago['urlPago']) && ($pago['idMetodoDePago'] == "PP" || $pago['idMetodoDePago'] == "MP")):
                                                                        // Paypal y MercadoPago
                                                                            ?>
                                                                            <div class="text-center">
                                                                                <div class="small text-white">
                                                                                    Aceptado:
                                                                                    <?php echo ($pago['hasOnlinePayment']   == 1) ? "<span class='badge bg-transparent border border-white border-1 text-white'>En línea</span>" : ""; ?>
                                                                                    <?php echo ($pago['hasDeliveryPayment'] == 1) ? "<span class='badge bg-transparent border border-white border-1 text-white'>A la entrega</span>" : ""; ?>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                            break;

                                                                        case (!isset($pago['urlPago']) && ($pago['idMetodoDePago'] == "TRANSFER")):
                                                                        // Transferencia electrónica
                                                                            ?>
                                                                            <div class="text-center">
                                                                                <div class="small text-white">
                                                                                    Aceptado:
                                                                                    <?php echo ($pago['hasOnlinePayment']   == 1) ? "<span class='badge bg-transparent border border-white border-1 text-white'>En línea</span>" : ""; ?>
                                                                                    <?php echo ($pago['hasDeliveryPayment'] == 1) ? "<span class='badge bg-transparent border border-white border-1 text-white'>A la entrega</span>" : ""; ?>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                            break;

                                                                        case ($pago['idMetodoDePago'] == "CASH"):
                                                                        // Efectivo
                                                                            ?>
                                                                            <div class="text-center">
                                                                                <div class="small text-white">
                                                                                    Aceptado:
                                                                                    <?php echo ($pago['hasOnlinePayment']   == 1) ? "<span class='badge bg-transparent border border-white border-1 text-white'>En línea</span>" : ""; ?>
                                                                                    <?php echo ($pago['hasDeliveryPayment'] == 1) ? "<span class='badge bg-transparent border border-white border-1 text-white'>A la entrega</span>" : ""; ?>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                            break;

                                                                        case ($pago['idMetodoDePago'] == "CC"):
                                                                        // Efectivo
                                                                            ?>
                                                                            <div class="text-center">
                                                                                <div class="small text-white">
                                                                                    Aceptado:
                                                                                    <?php echo ($pago['hasOnlinePayment']   == 1) ? "<span class='badge bg-transparent border border-white border-1 text-white'>En línea</span>" : ""; ?>
                                                                                    <?php echo ($pago['hasDeliveryPayment'] == 1) ? "<span class='badge bg-transparent border border-white border-1 text-white'>A la entrega</span>" : ""; ?>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                            break;

                                                                        default:
                                                                        // Default
                                                                            echo "&nbsp;";
                                                                            break;
                                                                    }
                                                                    ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php
                                                        }
                                                    }
                                                    else
                                                    {
                                                    ?>
                                                        <span class="m-2">
                                                            No hay métodos de pago registrados.
                                                            <a href="configura-pagos.php" class="fw-500">Configurar ahora</a>
                                                        </span>
                                                    <?php
                                                    }
                                                    ?>
                                                </p>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>                    

                    <div class="modal-footer d-flex justify-content-center">
                        <div class="rounded-top">

                            <button type="button" class="btn btn-outline-indigo btn-icon" name="button" data-bs-dismiss="modal">
                                <i class="feather-lg" data-feather="x"></i>
                            </button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal modalMediosDeContacto Fin -->


        <!-- modal modalMediosDeContacto Inicio-->
        <div class="modal fade" id="modalContactoTienda2" tabindex="-1" aria-labelledby="modalContactoTiendaLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    
                    <?php
                    if (isset($hasActivePayment))
                    {
                    ?>
                        <div class="rounded-top p-2 bg-pattern-ama2 text-center text-dark">

                            <div class="fw-500 fs-1 align-items-center mb-1 mt-2">
                                @<?php echo $tienda['idTienda']; ?>
                                <a class="text-decoration-none text-dark" style="font-size: 20px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modalCuentaVerificada">
                                    <span class="tw-verified-badge tw-icon-defaults tw-hidden" style="--fa-beat-scale: 0.9;" title="Verified Account"></span>
                                </a>
                            </div>

                        </div>
                    <?php
                    }
                    ?>

                    <div class="modal-body">
                        
                        <div class="text-center fs-3 mb-2 p-2 text-primary">
                            ¡Comparte <b><?php echo $tienda['nombreTienda']; ?></b> con todo el mundo!                        
                        </div>

                        <input class="form-control form-control-lg bg-white border border-1 border-primary rounded-3 p-2 small fw-400 text-center mb-2 w-100 shadow-none" id="enlaceTienda" onClick="copiarPortapapeles('enlaceTienda');" type="text" value="<?php echo $dominio . $_GET['tienda']; ?>" readonly>
                        <div id="qrcodePerfil" style="display: none;"></div>
                        <a class="btn btn-dark w-100 btn-lg mb-2" name="button" onclick="javascript: makeCodeUrlPago('<?php echo $dominio . $_GET["tienda"]; ?>');">
                            Descargar QR <i class="fas fa-qrcode ms-2"></i>
                        </a>

                        <button type="button" class="btn btn-pink w-100 btn-lg mb-2" id="idPortapapeles" name="button" onClick="copiarPortapapeles('enlaceTienda');">
                            Copiar enlace <i class="far fa-clipboard ms-2"></i>
                        </button>

                        <a target="_blank" href="https://api.whatsapp.com/send?text=Conoce la tienda en línea _*<?php echo $_GET['tienda']; ?>*_ %0a%0aEntra ahora y encuentra productos *¡increíbles!* %0a%0a _<?php echo $dominio . $_GET['tienda']; ?>_" class="btn btn-success w-100 btn-lg mb-2" name="button">
                            Whatsapp <i class="fab fa-whatsapp ms-2"></i>
                        </a>

                        <a class="btn btn-primary w-100 btn-lg mb-2" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $dominio . $_GET['tienda']; ?>" target="_blank">
                            Facebook <i class="fab fa-facebook ms-2"></i>
                        </a>

                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-light rounded-2 fs-6" data-bs-dismiss="modal">
                            Cerrar
                        </button>

                    </div>
                </div>
            </div>
        </div>
        <!-- modal modalMediosDeContacto Fin -->


        <!-- modal modalMediosDeContacto Inicio-->
        <div class="modal fade" id="modalSucursalesTiendaPerfil" tabindex="-1" aria-labelledby="modalSucursalesTiendaPerfilLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">

                    <?php
                    if (isset($hasActivePayment))
                    {
                    ?>
                        <div class="rounded-top p-2 bg-pattern-ama text-center text-dark">

                            <div class="fw-500 fs-5 align-items-center mb-1 mt-2">
                                <?php echo $tienda['idTienda']; ?>
                                <a class="text-decoration-none text-dark" style="font-size: 20px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modalCuentaVerificada">
                                    <span class="tw-verified-badge tw-icon-defaults tw-hidden" style="--fa-beat-scale: 0.9;" title="Verified Account"></span>
                                </a>
                            </div>

                            <p class="small">Tienda verificada <i class="fa-regular fa-circle-check align-middle"></i></p>
                            <!-- <button type="button" class="btn btn-icon btn-outline-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa-solid fa-xmark fa-xl"></i>
                            </button> -->
                        </div>
                    <?php
                    }
                    ?>

                    <div class="modal-body">
                        <div class="m-0 text-dark">
                            <div class="list-group list-group-flush">
                                <div class="m-2">
                                    <div class="tab-content" id="cardPillContent">
                                        <div class="tab-pane fade show active" id="overviewPill" role="tabpanel" aria-labelledby="overview-pill">
                                            <!-- <h5 class="card-title">Pill Navigation Card</h5> -->
                                            <p class="card-text">
                                                <?php
                                                if ($sucursales)
                                                {
                                                  // echo "<pre>";
                                                  // print_r($sucursales);
                                                    foreach ($sucursales as $sucursal)
                                                    {
                                                        // Crear badge si es la dirección principal
                                                        $isPrincipal = ($sucursal['isPrincipal'] == 1 ? '<span class="badge bg-warning text-white rounded-pill fw-600">Principal</span>' : '');

                                                        // Construyo dirección
                                                        $direccion = ucfirst(($sucursal['calle'])) . ' ' . $sucursal['numeroExterior'];

                                                        if (!empty($sucursal['interiorDepto']))
                                                        {
                                                        $direccion .= ', Interior/Depto ' . $sucursal['interiorDepto'];
                                                        }

                                                        $direccion .= ', Colonia ' . $sucursal['colonia'] . ', C. P. ' . $sucursal['codigoPostal'] . ', Municipio/Alcaldia: ' . $sucursal['municipioAlcaldia'] . ', ' . $sucursal['estado'] .".<br>";

                                                        if (!empty($sucursal['entreCalle1']) && !empty($sucursal['entreCalle2']))
                                                        {
                                                        $direccion .= ', Entre Calle ' . $sucursal['entreCalle1'] . " y calle " . $sucursal['entreCalle2']. ". ";
                                                        }

                                                        if (!empty($sucursal['telefono']))
                                                        {
                                                        $direccion .= ' Telefono: ' . $sucursal['telefono'];
                                                        }

                                                        if (!empty($sucursal['indicacionesAdicionales']))
                                                        {
                                                        $direccion .= ', Indicaciones Adicionales: ' . $sucursal['indicacionesAdicionales'];
                                                        }

                                                        $direccion = (ucwords(strtolower($direccion)));
                                                        $shortDireccion = (strlen($direccion) > 44) ? substr($direccion, 0, 44) . ' ...' : $direccion;

                                                    ?>
                                                    <div class="border border-2 p-2 rounded-2 mb-2">
                                                        <div class="fw-500 fs-3 mb-2">
                                                            <?php echo $sucursal['nombreSucursal']; ?>
                                                            <?php echo $isPrincipal; ?>                                                            
                                                        </div>
                                                        <div class="mb-2 fw-300">
                                                            <?php
                                                            echo $direccion;
                                                            ?>
                                                        </div>
                                                        <div class="text-end">
                                                            <a href="https://maps.google.com?q=<?php echo $direccion; ?>" target="_blank" class="btn btn-outline-primary rounded-3">
                                                                <i class="fas fa-location-arrow me-2"></i>
                                                                Navegar
                                                            </a>
                                                        </div>                                                        
                                                    </div>
                                                    <?php
                                                  }
                                              }
                                              else
                                              {
                                              ?>
                                                  <span class="m-2">
                                                      No hay sucursales registradas.

                                                  </span>
                                              <?php
                                              }
                                              ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <div class="rounded-top">

                            <button type="button" class="btn btn-outline-indigo btn-icon" name="button" data-bs-dismiss="modal">
                                <i class="feather-lg" data-feather="x"></i>
                            </button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal modalMediosDeContacto Fin -->

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
                let qrcode = new QRCode(document.getElementById("qrcodePerfil"),
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
                        let dataUrl = document.querySelector('#qrcodePerfil').querySelector('img').src;
                        var tienda = '<?php echo $_GET['tienda']; ?>';
                        downloadURI(dataUrl, 'vendyQR_' + tienda + '.png');
                    },  1000
                );
            }

            function copiarPortapapeles(inputId)
            {
                  var copyText = document.getElementById(inputId);
                  copyText.setSelectionRange(0, 99999);
                  copyText.focus(); // se enfoca en el input para seleccionar el texto
                  document.execCommand('copy'); // ejecuta el comando copy para copiar el texto seleccionado

                  // Alert the copied text
                  // alert("Copied the text: " + copyText.value);

                  const Toast = Swal.mixin({
                      toast: true,
                      position: 'top',
                      showConfirmButton: false,
                      timer: 2000,
                      timerProgressBar: true,
                      customClass: {
                      },
                      didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                      }
                  })

                  Toast.fire({
                    icon: 'success',
                    html: 'Copiado al portapapeles: ' + copyText.value,
                  }).then((result) => {
                    if (result.isConfirmed) {
                      console.log('Alerta cerrada');
                    }
                  })
            }

        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="app/js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="app/js/datatables/datatables-simple-demo.js"></script>
        <?php
            // Alertas
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

                    case 'errorInventarioInsuficiente':
                      ?>
                      <script type="text/javascript">

                          var alertaInventarioInsuficiente = document.getElementById('alertaInventarioInsuficiente');
                          alertaInventarioInsuficiente.style.display = 'block';
                          myFunction(alertaInventarioInsuficiente);

                      </script>
                      <?php
                    break;


                    case 'modalContactoTienda':
                      ?>
                      <script type="text/javascript">

                          var modalContactoTienda = new bootstrap.Modal(document.getElementById("modalContactoTienda"), {});
                          document.onreadystatechange = function ()
                          {
                              modalContactoTienda.show();
                          };

                      </script>
                      <?php
                    break;

                }
            }
        ?>
    </body>
    <?php

    if(isset($_GET['filter']))
    {
        $filter = $_GET['filter'];
        $slice = explode(";",$filter);
        // var_dump($slice);
    }
    ?>
</html>
