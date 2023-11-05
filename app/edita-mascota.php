<?php
    
    session_start();
    require 'php/conexion.php';
    require 'php/funciones.php';
	require 'php/lock.php';

    $idOwner   = $_SESSION['email'];
    $idMascota = $_GET['idMascota'];

    $arrayMascotas = buscarMascotasPorIdOwner($conn, $idOwner);
    $generalesMascota = getGeneralesMascota($conn, $idMascota); 

    //$datosDeContacto = obtenerDatosDeContacto($conn, $idMascota);

    // echo "<pre>";
    // print_r($generalesMascota);
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
        <title>Conejón Digital</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />

        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

        <style>
            
            @font-face 
            {
                font-family: 'bangers';
                src: url('fonts/bangers.ttf') format('truetype');
            }

            @font-face 
            {
                font-family: 'bebas';
                src: url('fonts/bebas.ttf') format('truetype');
            }

            @font-face 
            {
                font-family: 'belanosina';
                src: url('fonts/belanosina.ttf') format('truetype');
            }

            @font-face 
            {
                font-family: 'permanentmarker';
                src: url('fonts/permanentmarker.ttf') format('truetype');
            }

            @font-face 
            {
                font-family: 'poppins';
                src: url('fonts/poppins.ttf') format('truetype');
            }

            .design-option 
            {
                display: inline-block;
                margin-right: 10px;
            }

            .design-option img 
            {
                width: 70px;
                height: 70px;
                border: 2px solid #ccc;
                cursor: pointer;
                border-radius: 50px;
            }

            .selected-image 
            {
                width: 100%;
                height: 200px;
                border: 2px solid #ccc;
                margin-top: 10px;
                background-repeat: no-repeat;
                background-size: cover;
                background-color: white;                
            }

            input[type="radio"] 
            {
                display:none;
            }

            .centered-text
            {
                
                -webkit-text-stroke: 1px white;
                color: #fff;
                text-shadow: -2px 2px 1px rgba(106,31,78,0.54);
            }

            .center 
            { 
                height: 200px;
                position: relative;
                border: 3px solid green; 
            }

            .center span 
            {
                margin: 0;
                position: absolute;
                top: 50%;
                left: 50%;
                -ms-transform: translate(-50%, -50%);
                transform: translate(-50%, -50%);
                font-family: 'poppins';
            }

            .avatar 
            {
                width: 180px; /* Ajusta el ancho deseado */
                height: 180px; /* Ajusta la altura deseada */
            }

            .avatar img 
            {
                width: 100%;
                height: 100%;
                object-fit: cover;
                border-radius: 50%;
                border: 4px solid white;
                -webkit-box-shadow: 1px 8px 10px 1px rgba(0,0,0,0.30);
                -moz-box-shadow: 1px 8px 10px 1px rgba(0,0,0,0.30);
                box-shadow: 1px 8px 10px 1px rgba(0,0,0,0.30);
            }

        </style>
        
    </head>
    <body class="nav-fixed">
        <?php
            include 'src/header.php';
        ?>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <?php
                    include 'src/sidenav.php';
                ?>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
                        <div class="container-xl px-4">
                            <div class="page-header-content pt-4">
                                <div class="row align-items-left ">

                                    <div class="col-auto mt-4">                                       
                                        <div class="">
                                            <div class="avatar">                                        
                                                <img class="" src="<?php echo "users/" . $_SESSION['email'] . "/mascotas/" . $generalesMascota['idMascota'] . "/" . $generalesMascota['imgPerfil'] . "?id=" . mt_rand(1,28); ?>" alt="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-auto mt-5">
                                        
                                        <h1 class="text-white mb-0">
                                            <div class="dropdown">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="fw-400 display-3" style="text-shadow: 2px 2px 0px rgba(228, 202, 86, 0.62); color: #fff700;"><?php echo ucwords($generalesMascota['nombre']); ?></div>
                                                    </div>
                                                    <div class="col text-end">
                                                        <button class="btn shadow-sm btn-transparent border-white border-1 btn-icon mb-3 ms-10" type="button" data-bs-toggle="dropdown">                                                
                                                            <i class="feather-lg text-white" data-feather="more-vertical"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <!-- <li><a class="dropdown-item" href="#">Action</a></li>
                                                            <li><a class="dropdown-item" href="#">Another action</a></li> -->
                                                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalEliminarConejo">Eliminar</a></li>
                                                        </ul>
                                                    </div>                                                                                                    

                                                </div>
                                            </div>
                                        </h1>
                                        <div>
                                            Actualiza los datos de <?php echo ucwords($generalesMascota['nombre']); ?> cuando lo necesites.
                                        </div>
                                        
                                        <div class="page-header-subtitle mb-2">                                                                   

                                            <!-- Modal -->
                                            <div class="modal fade" id="modalEliminarConejo" tabindex="-1" aria-labelledby="modalEliminarConejoLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form action="procesa.php" method="POST">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="modalEliminarConejoLabel">Confirmación</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">                                                        
                                                            <div class="text-dark">Eliminarás toda la información y fotos de <span class="fw-600"><?php echo $generalesMascota['nombre']; ?></span>, ¿Deseas continuar?</div>
                                                            <input type="hidden" value="<?php echo $_GET['idMascota']; ?>" id="idMascotaToDelete" name="idMascota" required>
                                                        </div>
                                                        <div class="modal-footer text-dark">
                                                            <?php
                                                                if (isset($_GET['idMascota'])) 
                                                                {
                                                                    $idMascota = $_GET['idMascota'];
                                                                    ?>
                                                                    <button class="btn btn-danger text-white" name="btnEliminarMascota" type="submit">Eliminar ahora</button>
                                                                    <?php
                                                                }
                                                                else
                                                                {
                                                                    ?>
                                                                    <div class="small">Ocurrió un error, actualiza la página</div>
                                                                    <?php
                                                                }
                                                                
                                                            ?>
                                                            
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            </div>

                                        </div>
                                        
                                        <!-- <div>
                                            <button class="btn btn-dark shadow-sm mb-2" data-bs-toggle="modal" data-bs-target="#modalMascotaPerdida">
                                                <i class="fas fa-qrcode me-2"></i> Registrar plaquita
                                            </button>

                                            <button type="button" class="btn btn-success shadow-sm mb-2" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#modalDisenadorPlaquita">
                                                <i class="fas fa-paw me-2"></i>
                                                Diseñar plaquita 
                                            </button>
                                        </div> -->
                                        
                                    </div>

                                </div>
                            </div>
                        </div>
                    </header>
                    <!-- Main page content-->
                    <div class="container-xl px-4 mt-n10">
                    <div class="row">
                            
                            <?php 
                                // Oculto con una condicion absurda
                                if ($generalesMascota['recompensa'] == 0 && 1==2)
                                {
                                    ?>
                                    <div class="col-lg-6 col-xl-6 mb-4" data-bs-toggle="modal" data-bs-target="#modalEditarRecompensa">
                                        <div class="card bg-yellow text-dark h-100 lift">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="me-3">
                                                        <div class="text-dark small">Activar </div>
                                                        <div class="text-lg fw-bold">Recompensa</div>
                                                    </div>
                                                    <i class="feather-xl text-dark" data-feather="dollar-sign"></i>
                                                </div>
                                            </div>
                                            <div class="card-footer justify-content-between text-center small">
                                                <a class="text-dark stretched-link" href="#!">Agregar monto</a>                                        
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <!-- <div class="col-lg-6 col-xl-6 mb-4" data-bs-toggle="modal" data-bs-target="#modalEditarRecompensa">
                                        
                                        <div class="card bg-primary text-white h-100 lift">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="me-3">
                                                        <div class="text-white-75 small">Recompensa:</div>
                                                        <div class="text-lg fw-bold"><?php //echo number_format($generalesMascota['recompensa'], 2); ?></div>
                                                    </div>
                                                    <i class="feather-xl text-white-50" data-feather="dollar-sign"></i>
                                                </div>
                                            </div>
                                            <div class="card-footer justify-content-between text-center small">
                                                <a class="text-white stretched-link" href="#!">Editar monto</a>                                        
                                            </div>
                                        </div>

                                    </div> -->
                                    <?php
                                }
                            ?>

                            
                            <!-- <div class="col-lg-6 col-xl-6 mb-4">
                                <div class="card bg-danger text-white h-100 lift">                                                                            
                                    <div class="text-center display-6 fw-bold mt-5 mb-5">
                                        Perdí a mi mascota 🚨
                                    </div>                                   
                                </div>
                            </div> -->
                        </div> 

                        <!-- Example Charts for Dashboard Demo-->
                        <div class="row">

                            <div class="col-xl-6 mb-4">
                                <div class="card card-header-actions ">
                                    <div class="card-header fs-4 fw-600">
                                        <div><i class="fas fa-carrot me-1"></i> Datos Generales</div>
                                    </div>
                                    <div class="card-body">
                                    
                                        <form action="procesa.php" method="POST">
                                                <div class="mb-3">
                                                    <label for="nombre" class="form-label text-primary fw-500">Nombre</label>
                                                    <input type="text" class="form-control rounded-3 border-3 border-blue-soft fs-6 fw-500 shadow-none" id="nombre" name="nombreMascota" value="<?php echo $generalesMascota['nombre']; ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="fechaNacimiento" class="form-label text-primary fw-500">Fecha de Nacimiento</label>
                                                    <input type="date" class="form-control rounded-3 border-3 border-blue-soft fs-6 fw-500 shadow-none" id="fechaNacimiento" name="fechaNacimientoMascota" value="<?php echo $generalesMascota['fechaNacimiento']; ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="raza" class="form-label text-primary fw-500">Raza</label>
                                                    <input type="text" class="form-control rounded-3 border-3 border-blue-soft fs-6 fw-500 shadow-none" id="raza" name="razaMascota" value="<?php echo $generalesMascota['raza']; ?>" required>
                                                </div>

                                                <div class="row gx-3 mb-3">
                                                    <!-- Form Group (first name)-->
                                                    <div class="col-md-6">
                                                        <label class="small mb-1" for="inputSexo">Sexo</label>
                                                        <select class="form-select rounded-3 border-3 border-blue-soft fs-6 fw-500 shadow-none" id="inputSexo" name="sexoMascota">
                                                            <option value="">Seleccionar</option>
                                                            <option value="Macho" <?php echo ($generalesMascota['sexo'] === 'Macho') ? 'selected' : ''; ?>>Macho</option>
                                                            <option value="Hembra" <?php echo ($generalesMascota['sexo'] === 'Hembra') ? 'selected' : ''; ?>>Hembra</option>
                                                        </select>
                                                    </div>

                                                    <!-- Form Group (last name)-->
                                                    <div class="col-md-6">
                                                        <label class="small mb-1" for="inputLastName">Color</label>
                                                        <input class="form-control rounded-3 border-3 border-blue-soft fs-6 fw-500 shadow-none" id="inputLastName" type="text" name="colorMascota" placeholder="Color" value="<?php echo $generalesMascota['color']; ?>" />
                                                    </div>
                                                </div>
                                                
                                                <div class="text-end">
                                                    <input type="hidden" name="idMascota" value="<?php echo $idMascota; ?>">
                                                    <button type="submit" class="btn btn-primary" name="btnGuardarGeneralesMascota">Guardar</button>
                                                </div>

                                        </form>
                                    
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="col-xl-6 mb-4">
                                <div class="card card-header-actions">
                                    <div class="card-header fs-4 fw-600">
                                        <div><i class="far fa-id-badge me-1"></i> Datos de contacto</div>
                                        <div class="dropdown no-caret">
                                            
                                            <div class="dropdown-menu dropdown-menu-end animated--fade-in-up" aria-labelledby="areaChartDropdownExample">
                                                <a class="dropdown-item" href="#!">Last 12 Months</a>
                                                <a class="dropdown-item" href="#!">Last 30 Days</a>
                                                <a class="dropdown-item" href="#!">Last 7 Days</a>
                                                <a class="dropdown-item" href="#!">This Month</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="#!">Custom Range</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">

                                        <div class="container">
                                            <div class="row mb-3">

                                                <div class="small text-dark fs-300 mb-3">Registra medios de contacto adicionales para que sea más fácil localizarte cuando alguien escanee la plaquita de <span class="fs-4 fw-500"><?php echo $generalesMascota['nombre']; ?></span></div>    
                                            
                                                <div class="col text-center fs-5 fw-500 text-dark" data-bs-toggle="modal" data-bs-target="#modalDatosDeContacto">
                                                    <a class="btn rounded-pill btn-primary btn-lg m-2 z3">
                                                        <i class="fas fa-phone fs-1"></i>
                                                    </a>
                                                    Teléfono
                                                </div>
                                                
                                                <div class="col text-center fs-5 fw-500 text-dark" data-bs-toggle="modal" data-bs-target="#modalDatosDeContacto">
                                                    <a class="btn btn-icon btn-success btn-lg m-2">
                                                        <i class="fab fa-whatsapp fs-1"></i>
                                                    </a>
                                                    Whatsapp
                                                </div>
                                                
                                                <div class="col text-center fs-5 fw-500 text-dark" data-bs-toggle="modal" data-bs-target="#modalDatosDeContacto">
                                                    <a class="btn rounded-pill btn-teal btn-lg m-2 p-3">
                                                        <i class="fab fa-telegram-plane fs-1"></i>
                                                    </a>
                                                    Telegram
                                                </div>

                                            </div>
                                            <div class="row mb-3">

                                                <div class="col text-center fs-5 fw-500 text-dark" data-bs-toggle="modal" data-bs-target="#modalDatosDeContacto">
                                                    <a class="btn rounded-pill btn-pink btn-lg m-2 p-3">                                                        
                                                        <i class="far fa-envelope fs-1"></i>
                                                    </a>
                                                    Email
                                                </div>
                                                
                                                <div class="col text-center fs-5 fw-500 text-dark" data-bs-toggle="modal" data-bs-target="#modalDatosDeContacto">
                                                    <a class="btn rounded-pill btn-orange btn-lg m-2 p-3">
                                                        <i class="fas fa-map-marked-alt fs-1"></i>
                                                    </a>
                                                    Dirección
                                                </div> 

                                            </div>
                                        </div>

                                        

                                        <div class="mt-5 table-responsive">
                                            <?php
                                            if ($datosDeContacto !== false) 
                                            {
                                            ?>
                                            <table id="datatablesSimple" class="table bg-pink text-white table-hover rounded-3 m-0 p-3">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th> 
                                                        <th>Age</th>  
                                                        <th>Acciones</th> 
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>Name</th> 
                                                        <th>Age</th>  
                                                        <th>Acciones</th> 
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    <?php

                                                        $contadorTelefono = 1; 
                                                        $contadorWhatsapp = 1;
                                                        $contadorTelegram = 1;
                                                        $contadorEmail    = 1;
                                                        $contadorDirecciones = 1;

                                                        if ($datosDeContacto !== false) 
                                                        {                                                                                                    
                                                            foreach ($datosDeContacto as $key => $contacto) 
                                                            {
                                                                if ($contacto['idMediosDeContacto'] == "telefono") 
                                                                {
                                                                ?>
                                                                <tr class="text-white"> 
                                                                    
                                                                    <td class="text-end">
                                                                        <div class="text-white">
                                                                            <i class="fas fa-phone fa-lg text-white me-2"></i>                                                                    
                                                                        </div>
                                                                    </td>
                                                                    
                                                                    <td>
                                                                        <?php echo chunk_split($contacto['dato'], 2, ' '); ?>
                                                                    </td>

                                                                    <td>                                                                        
                                                                        <button onclick="abrirModal('<?php echo $contacto['id'] . ';'. ucwords($contacto['idMediosDeContacto']) . ';'. $contacto['dato']; ?>')" class="btn btn-icon btn-sm text-white btn-dark"><i data-feather="trash-2" class=""></i></button>
                                                                    </td>

                                                                </tr>
                                                                <?php
                                                                $contadorTelefono++;
                                                                }

                                                                if ($contacto['idMediosDeContacto'] == "whatsapp") 
                                                                {
                                                                ?>
                                                                    <tr class="text-dark">                                                             
                                                                        <td class="text-end">
                                                                            <div class="text-green">
                                                                                <i class="fa-brands fa-whatsapp fa-lg text-white me-2"></i>                                                                                                                                            
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo chunk_split($contacto['dato'], 2, ' '); ?>
                                                                        </td>
                                                                        <td>
                                                                            <!-- <button class="btn btn-datatable btn-icon btn-transparent-dark me-2"><i data-feather="more-vertical"></i></button> -->
                                                                            <button onclick="abrirModal('<?php echo $contacto['id'] . ';'. ucwords($contacto['idMediosDeContacto']) . ';'. $contacto['dato']; ?>')" class="btn btn-icon btn-sm text-white btn-dark"><i data-feather="trash-2" class=""></i></button>
                                                                        </td>
                                                                    </tr>
                                                                <?php
                                                                $contadorWhatsapp++;
                                                                }
                                                                
                                                                if ($contacto['idMediosDeContacto'] == "telegram") 
                                                                {
                                                                ?>
                                                                    <tr class="text-dark">                                                             
                                                                        <td class="text-end">
                                                                            <div class="text-teal">
                                                                                <i class="fa-brands fa-telegram fa-lg text-white me-2"></i>                                                                                                                                            
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo chunk_split($contacto['dato'], 2, ' '); ?>
                                                                        </td>
                                                                        <td>
                                                                            <!-- <button class="btn btn-datatable btn-icon btn-transparent-dark me-2"><i data-feather="more-vertical"></i></button> -->
                                                                            <button onclick="abrirModal('<?php echo $contacto['id'] . ';'. ucwords($contacto['idMediosDeContacto']) . ';'. $contacto['dato']; ?>')" class="btn btn-icon btn-sm text-white btn-dark"><i data-feather="trash-2" class=""></i></button>
                                                                        </td>
                                                                    </tr>
                                                                <?php
                                                                $contadorTelegram++;
                                                                }
                                                                
                                                                if ($contacto['idMediosDeContacto'] == "email") 
                                                                {
                                                                ?>
                                                                    <tr class="text-dark">                                                             
                                                                        <td class="text-end">
                                                                            <div class="text-teal">
                                                                                <i class="far fa-envelope fa-lg text-white me-2"></i>                                                                        
                                                                            </div>
                                                                        </td>
                                                                        <td> <?php echo $contacto['dato']; ?> </td> 
                                                                        <td>
                                                                            <!-- <button class="btn btn-datatable btn-icon btn-transparent-dark me-2"><i data-feather="more-vertical"></i></button> -->
                                                                            <button onclick="abrirModal('<?php echo $contacto['id'] . ';'. ucwords($contacto['idMediosDeContacto']) . ';'. $contacto['dato']; ?>')" class="btn btn-icon btn-sm text-white btn-dark"><i data-feather="trash-2" class=""></i></button>
                                                                        </td>
                                                                    </tr>
                                                                <?php
                                                                $contadorEmail++;
                                                                }
                                                                
                                                                if ($contacto['idMediosDeContacto'] == "direccion") 
                                                                {
                                                                ?>
                                                                    <tr class="text-dark">                                                             

                                                                        <td class="text-end">
                                                                            <div class="d-flex justify-content-between">
                                                                                <div class="text-teal">
                                                                                    <i class="fas fa-map-marker-alt fa-lg text-white me-2"></i>                                                                            
                                                                                </div>
                                                                            </div>
                                                                        </td>

                                                                        <td> <?php echo $contacto['dato']; ?> </td>
                                                                        <td>
                                                                            <!-- <button class="btn btn-datatable btn-icon btn-transparent-dark me-2"><i data-feather="more-vertical"></i></button> -->
                                                                            <button onclick="abrirModal('<?php echo $contacto['id'] . ';'. ucwords($contacto['idMediosDeContacto']) . ';'. $contacto['dato']; ?>')" class="btn btn-icon btn-sm text-white btn-dark"><i data-feather="trash-2" class=""></i></button>
                                                                        </td>
                                                                    </tr>
                                                                <?php
                                                                $contadorDirecciones++;
                                                                }
                                                            }
                                                        }
                                                    ?>                                                                                        
                                                    
                                                </tbody>
                                            </table>
                                            <?php
                                            }
                                            ?>
                                        </div>

                                    </div>
                                </div>
                            </div> -->
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
            require 'src/modals.php';            
            require 'src/triggers.php';        
        ?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables/datatables-simple-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
        <script src="js/litepicker.js"></script>
        <script>
            
            var designOptions = document.querySelectorAll('.design-option');
            var selectedImageContainer = document.querySelector('.selected-image');

            designOptions.forEach(function (option) {
                option.addEventListener('click', function () {
                    var selectedImage = this.querySelector('input').value;
                    selectedImageContainer.style.backgroundImage = 'url(templates/' + selectedImage + ')';
                });
            });

            function changeFont() 
            {
                var select = document.getElementById("fontSelect");
                var fontName = select.options[select.selectedIndex].value;
                var centeredTextElements = document.querySelectorAll(".centered-text");

                centeredTextElements.forEach(function(element) {
                element.style.fontFamily = fontName;
                });
            }

            function changeFontColor() 
            {
                var select = document.getElementById("colorSelect");
                var fontColor = select.options[select.selectedIndex].value;

                var centeredTextElements = document.querySelectorAll(".centered-text");

                centeredTextElements.forEach(function(element) {
                    element.style.color = fontColor;
                });
            }
            
            const inputNombreMascota = document.getElementById('inputNombreMascota');
            const inputNumeroMascota = document.getElementById('inputNumeroMascota');
            const txtNombreMascota = document.getElementById('txtNombreMascota');
            const txtNumeroMascota = document.getElementById('txtNumeroMascota');

            inputNombreMascota.addEventListener('input', function() {
                txtNombreMascota.textContent = inputNombreMascota.value;
            });

            inputNumeroMascota.addEventListener('input', function() {
                txtNumeroMascota.textContent = inputNumeroMascota.value;
            });

            const selectMascota = document.getElementById('selectMascota'); 

            selectMascota.addEventListener('change', function() {
                const selectedMascota = this.value;
                console.log(selectedMascota);
                 
                
            });

            const selectElement = document.getElementById("medioDeContacto");
            const labelElement = document.getElementById("labelData");

            selectElement.addEventListener("change", function() {
                const selectedOption = selectElement.value;
                labelElement.textContent = `Ingresa tu ${selectedOption}:`;
            });
        
            function abrirModal(data) 
            {
                
                // Dividir los valores usando el separador ";"
                var valores = data.split(";");
                console.log(valores);
                // Asignar los valores a variables separadas
                var idMediosDeContacto = valores[0];
                var nombre = valores[1]; 
                var dato = valores[2];
                
                // Asignar el valor al campo de entrada
                document.getElementById("idToDelete").value = idMediosDeContacto;
                document.getElementById("labelToDelete").innerHTML = "¿Deseas eliminar  <span class='text-success fw-500'>" + nombre + " (" + dato + ")</b>?";
                
                // Abrir el modal
                var modal = new bootstrap.Modal(document.getElementById("modalConfirmacionEliminarMedioDeContacto"));
                modal.show();
            }

        </script>
    </body>
</html>
