<?php
    
    session_start();
    require 'php/conexion.php';
    require 'php/funciones.php';

        $idOwner = $_SESSION['email'];
        $arrayMascotas = buscarMascotasPorIdOwner($conn, $idOwner);

    // echo "<pre>";
    // print_r($arrayMascotas);
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
        <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
        <link href="css/styles.css?id=28" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
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
                    <!-- Main page content-->
                    <div class="container-xl px-4 mt-5">                         

                        <div class="row mb-2">                             

                            <div class="col-xl-12 col-md-12 mb-4">
                                <a class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#modalNuevaMascota">
                                    <!-- Dashboard info widget 1-->
                                    <div class="card bg-success h-100 btn w-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1">
                                                    <!-- <div class="small fw-bold text-orante mb-1">Mis mascotas</div> -->
                                                    <div class="display-4 text-white text-center">
                                                        Nuevo Registro
                                                        <i class="fas fa-carrot"></i>                                                        
                                                    </div>                                                
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <?php
                                                        
                                if($arrayMascotas !== false)
                                {
                                    foreach ($arrayMascotas as $mascota) 
                                    {
                                    ?>
                                    <div class="col-xl-6 col-md-6 mb-4">
                                        <a href="edita-mascota.php?idMascota=<?php echo $mascota['idMascota']; ?>" class="text-decoration-none">
                                            <!-- Dashboard info widget 1-->
                                            <div class="card border-start-lg lift border-start-green h-100">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1">
                                                            <!-- <div class="small fw-bold text-orante mb-1">Mis mascotas</div> -->
                                                            <div class="display-6 text-orange">
                                                                <?php echo $mascota['nombre']; ?>                                               
                                                            </div>                                                
                                                        </div>
                                                        <div class="ms-2">
                                                            <img src="users/<?php echo $_SESSION['email'] . "/mascotas/" . $mascota['idMascota'] . "/" . $mascota['imgPerfil']; ?> " style="height: 99px;" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <?php
                                    }
                                }
                                else
                                {                                    
                                    ?>                                    
                                    <div class="col-12 d-flex justify-content-center">                                                                                
                                        <img src="assets/img/banners/sinconejos.jpg" style="height: 350px;" class="img-fluid rounded-bottom" alt="">
                                    </div>
                                    <?php
                                }
                            ?>
 
                                     
                        </div>

                        <div class="row mb-5" style="display:none;">
                            <div class="col-xl-12 col-md-6 mb-4">
                                <a href="mascotas.php" class="text-decoration-none">
                                    <!-- Dashboard info widget 1-->
                                    <div class="card bg-pink lift h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1">
                                                    <!-- <div class="small fw-bold text-orante mb-1">Mis mascotas</div> -->
                                                    <div class="display-6 text-white text-center">
                                                        📢 Se extravió mi mascota 🚨
                                                    </div>                                                
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        

                    </div>
                </main>
            </div>
        </div>
        <?php
            include 'src/modals.php';
        ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script> 
        <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script> 
    </body>
</html>
