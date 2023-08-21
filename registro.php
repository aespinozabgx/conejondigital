<?php
    // require 'php/conexion.php';    
    // require 'php/funciones.php';
    
    $idCliente = NULL;
    if (isset($_GET['correo'])) 
    {
        $idCliente = $_GET['correo'];
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
        <link href="css/styles.css?id=28" rel="stylesheet" />
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
    <body class="bg-blue">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container-xl px-4">
                        
                        <div class="row pt-5 text-center">
                            <div class="fw-300 text-green m-2" style="text-shadow: -2px 2px 0px rgba(95, 44, 148, 0.68);">
                                
                                <div class="fw-400 f-poppins text-white display-6">Registro</div>
                                <a href="index.php" class="text-decoration-none">
                                    <div class="display-4 fa-beat mb-2" style="--fa-beat-scale: 0.9; --fa-animation-duration: 2s; color: rgb(85, 255, 0);">                                                                        
                                        Conejón Navideño 2023
                                    </div>
                                </a>
                                
                            </div>
                            <div class="fs-4 text-white fw-300 mb-1">Obtendrás tu acceso al evento y también acceso a la tienda oficial del Conejón</div>
                            <div class="fs-4 text-white fw-300 mb-2">
                                <span class="" style="text-shadow: -2px 2px 0px rgba(95, 44, 148, 0.68);">
                                    Totalmente ¡GRATIS!
                                </span>
                            </div>
                            
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-lg-6">
                                <!-- Basic forgot password form-->
                                
                                <div class="mb-3 rounded-3 bg-transparent shadow-lg border-0 rounded-lg mt-3">
                                    
                                    <div class="p-4">
                                        <!-- <div class="small mb-3 text-muted">Enter your email address and we will send you a link to reset your password.</div> -->
                                        <!-- Forgot password form-->
                                        <form action="tienda/procesa.php" method="POST">
                                            
                                            <!-- Form Group (email address)-->
                                            <div class="mb-3">
                                                <label class="small mb-1 text-white" for="inputEmailAddress">¿Cómo te llamas?</label>
                                                <input type="text" name="nombreCliente" required class="form-control text-center rounded-3 fs-4 border-4 shadow-none border-blue-soft" placeholder="Nombre Completo" />
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="small mb-1 text-white" for="inputEmailAddress">Ingresa tu correo:</label>
                                                <input type="email" name="idCliente" required class="form-control text-center rounded-3 fs-4 border-4 shadow-none border-blue-soft" placeholder="correo@dominio.com" />
                                            </div>

                                            <!-- Form Group (submit options)-->
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small w-100 text-white" href="login.php">Iniciar sesión</a>
                                                <button type="submit" class="btn btn-yellow fs-6 fw-500 w-100" name="btnRegistroVisitante">
                                                    Solicitar acceso
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    
                                </div>

                                <div class="text-white">
                                    <a href="index.php" class="text-white">Información del evento</a>
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
                            <div class="col-md-6 small">Copyright &copy; Vendy 2023</div>                            
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
