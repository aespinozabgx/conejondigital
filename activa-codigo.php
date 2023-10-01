<?php
    require 'app/php/conexion.php';    
    require 'app/php/funciones.php'; 
    
    session_start();
    
    if (isset($_SESSION['email'])) 
    {
        exit(header('Location: app/'));
    }

    if(isset($_GET['correo']))
    {
        $correo = $_GET['correo'];
    }
    
    if(isset($_GET['token']))
    {
        $token = $_GET['token'];
    }
    
    
    
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>VIP</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
        <style>
            .dogPattern
            {                 
                background: url('images/dogs.jpg') repeat; /* Reemplaza 'ruta-de-tu-imagen.jpg' con la ruta de tu imagen y ajusta el valor de opacidad (0.5 en este caso) */
                background-size: 550px; /* Establece el tamaño de la imagen repetida */              
            }
        </style>
    </head>
    <body class="bg-green">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container-xl px-4">
                        
                        <div class="row pt-5 text-center">
                            <div class="fw-300 text-white m-2" style="text-shadow: 1px 2px 0px rgba(13, 97, 20, 0.68);">
                                <div class="display-6 text-yellow">Activa tu cuenta</div>
                                <div class="mb-2 display-4" style="--fa-beat-scale: 0.9; --fa-animation-duration: 2s;">                                    
                                    Conejón Digital🐰
                                    <!-- <span class="fw-400">exclusivo</span> -->
                                </div>

                            </div>
                            <div class="fs-4 text-dark fw-300 mb-1">
                                Recuerda validar tu carpeta de spam
                            </div>
                            
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-lg-6">
                                <!-- Basic forgot password form-->
                                
                                <div class="rounded-3 bg-transparent shadow-lg rounded-lg mt-3 mb-3">
                                    
                                    <div class="p-4">
                                        
                                        <form action="app/procesa.php" method="POST">                                            

                                            <div class="mb-3"> 
                                                <div class="text-white text-center mb-2 fs-4 fw-300">
                                                    Activación de <i><?php echo $correo; ?></i>
                                                    <a href="registro.php" class="btn btn-outline-white btn-icon btn-sm shadow-sm fs-6 fw-500" name="btnActivarCuenta">
                                                        <i class="fas fa-pencil"></i>
                                                    </a>
                                                </div>                                                                                                
                                            </div>

                                            <div class="mb-3">
                                                <input type="hidden" name="idCliente" value="<?php echo $correo; ?>" required>
                                                <label for="" class="text-white fs-5">Código: </label>
                                                <input required autocomplete="off" name="tokenActivacion" class="form-control text-center rounded-3 fs-4 shadow-none" id="inputCodigo" type="number" value="<?php echo $token; ?>" placeholder="Código de activación" />
                                            </div>
                                            
                                            <div class="mb-3"> 
                                                <label for="" class="text-white fs-5">Nueva contraseña: </label>
                                                <input type="password" name="password" class="form-control text-center rounded-3 fs-4 shadow-none" placeholder="Mínimo 6 dígitos" autocomplete="off">
                                            </div>

                                            <!-- Form Group (submit options)-->
                                            <div class="text-end justify-content-between mt-4 mb-0">                                                                                                     

                                                    <button type="submit" class="btn btn-yellow fs-6 fw-500" name="btnActivarCuenta">
                                                        Continuar
                                                    </button> 

                                            </div>
                                            
                                        </form>                                        
                                    </div>                                                                    
                                </div>

                                <div class="text-white">
                                    <a href="index.php" class="text-white">Ir al Inicio</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="footer-admin mt-auto footer-dark">
                    <div class="container-xl px-4">
                        <div class="row">
                            
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
