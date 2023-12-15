<?php
    session_start();

    if (isset($_SESSION['email'])) 
    {
        exit(header('Location: app/'));
    }

    if (isset($_GET['msg'])) 
    {
        $urlMsg = $_GET['msg'];   
    }

    if (isset($_GET['email'])) 
    {
        $urlEmail = $_GET['email'];    
    }
    
    $redirect = "";
    if (isset($_GET['redirect'])) 
    {
        $redirect = $_GET['redirect'];
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
        <title>Inicia sesión</title>
        <link href="app/css/styles.css" href="app/css/styles.css?id=28" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
        
        <!-- Enlace a Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">

        <!-- Enlace a Bootstrap JavaScript (incluyendo Popper.js) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
        
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bangers" rel="stylesheet">
        <style>
            
            .bgHueso
            {
                background-image: url('bg.jpg'); 
                background-repeat: repeat; 
                background-size: 500px; 
            }

        </style>
    </head>
    <body style="background-image: url('assets/img/pattern.png'); background-size: 200px 200px; background-repeat: repeat;">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container-xl px-4 mt-5">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <!-- Basic login form-->
                                <div class="card bg-light shadow-lg border-3 rounded-3 mt-5">
                                    <div class="card-header justify-content-center text-center p-4">
                                        <div class="text-pink sombra-titulos-vendy f-bangers display-4 fw-00">
                                            Conejón Digital                                            
                                        </div>                                        
                                    </div>
                                    <div class="card-body px-4 pt-2">
                                        <!-- Login form-->
                                        <div class="fs-2 fw-300 text-pink mb-2">Inicia sesión</div>

                                        <form action="app/procesa.php" method="POST">                                            
                                        
                                            <div class="form-floating mb-3">
                                                <input type="email" class="form-control fs-5 fw-400 text-center rounded-1" id="floatingInput" name="form_email" value="<?php echo isset($_GET['correo']) ? $_GET['correo'] : ''; ?>" type="email" placeholder="correo@dominio.com" required />
                                                <label for="floatingInput" class="fw-300">Correo Electrónico</label>
                                            </div>
                                        
                                            <div class="form-floating mb-3">
                                                <input type="password" class="form-control fs-5 fw-400 text-center rounded-1" id="floatingPassword" name="form_password" type="password" placeholder="Contraseña" required autocomplete >
                                                <label for="floatingPassword" class="fw-300">Contraseña</label>
                                            </div>  
                                            
                                            <input type="hidden" placeholder="Redirección" name="redirect" value="<?php echo $redirect; ?>">

                                            <!-- Form Group (login box)-->
                                            <div class="mt-2 mb-3" >
                                                <!-- <a class="" href="auth-password-basic.html">Olvidé mi contraseña</a> -->
                                                <button class="btn btn-primary f-bangers text-center fw-400 fs-3 w-100 " type="submit" name="btnLogin28">
                                                    Entrar
                                                </button>
                                            </div>

                                            <div class="text-center">
                                            <?php
                                            
                                            //if(isset($_GET['msg']) && $_GET['msg'] == "errorCredencialesInvalidas")
                                            if (1) 
                                            {
                                                ?>
                                                <a data-bs-toggle="modal" data-bs-target="#modalReestablecePassword" class="text-dark text-center fs-6 f-poppins fw-300 text-decoration-none" style="cursor: pointer;">
                                                    Olvidé mi contraseña
                                                </a>
                                                <?php
                                            }
                                            ?>
                                            </div>

                                        </form>
                                        <?php
                                            if (isset($urlMsg)) 
                                            {                                                                                        
                                                if ($urlMsg == 'errorCuentaInactiva') 
                                                {
                                                    ?>
                                                    <script>             
                                                        var myModal = new bootstrap.Modal(document.getElementById('modalReenvioActivacionCuenta'));
                                                    </script>
                                                    <div class="text-white text-center px-3 pt-4 mb-1">
                                                        Cuenta inactiva                                                        
                                                    </div>
                                                    <div class="text-center">
                                                        <button type="button" onclick="myModal.show();"; id="openModalBtn" class="btn btn-danger shadow-sm rounded-pill">
                                                            <i class="far fa-paper-plane me-2"></i> Reenviar correo de activación
                                                        </button>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </div>
                                    <div class="card-footer text-center bg-pink" style="background--image: url('assets/img/pattern.png'); background-size: 200px 200px; background-repeat: repeat;">
                                        <div class="p-3 f-poppins">
                                            
                                            <!-- <a href="#" class="text-dark text-decoration-none">Olvidé mi cuenta</a> -->
                                            <a href="registro.php" class="text-white fs-5 f-poppins fw-400 text-decoration-none">Registrarme</a>
                                            
                                           

                                        </div>
                                    </div>

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
                            <div class="col-md-6 small">Copyright &copy; Conejón Digital</div>                            
                        </div>
                    </div>
                </footer>
            </div>
        </div>
 

        
         <!-- Modal -->
         <div class="modal fade" id="modalReestablecePassword" tabindex="-1" aria-labelledby="modalReestablecePasswordLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    
                    <form action="app/procesa.php" method="POST" class="">

                        <div class="modal-header">
                            <h5 class="modal-title text-blue fw-500">
                                <i class="fas fa-lock me-1"></i> Reestablece tu contraseña
                            </h5>
                            <button type="button" class="btn btn-icon btn-outline-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa-solid fa-xmark fa-xl"></i>
                            </button>
                        </div>

                        <div class="modal-body">
                            
                            <div class="mb-3">
                                Enviaremos un correo con las instrucciones para reestablecer tu contraseña.
                            </div>                            

                            <div>
                                <label for="" class="text-primary fw-500 mb-1">Email:</label>
                                <input type="email" name="emailReestablece" class="form-control text-center shadow-none border border-3 fs-3" value="<?php echo isset($_GET['email']) ? $_GET['email'] : ''; ?>" placeholder="correo@dominio.com" required />
                            </div>
                                                
                        </div>
                        <div class="modal-footer">

                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>                            
                            <button type="submit" class="btn btn-success" name="btnReestablecePassword"><i class="far fa-paper-plane me-2"></i> Enviar</button>

                        </div>
                    </form>

                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="modalReenvioActivacionCuenta" tabindex="-1" aria-labelledby="modalReenvioActivacionCuentaLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    
                    <form action="app/procesa.php" method="POST" class="">

                        <div class="modal-header">
                            <h5 class="modal-title text-danger fw-500">
                                <i class="fas fa-exclamation-triangle me-1"></i> Cuenta inactiva
                            </h5>
                            <button type="button" class="btn btn-icon btn-outline-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa-solid fa-xmark fa-xl"></i>
                            </button>
                        </div>

                        <div class="modal-body">
                            
                            <div class="mb-3 small">
                                <p>Para asegurarnos que la plataforma se mantenga segura debemos validar las direcciones de correo. </p>
                                <p>Te enviaremos un correo para verificar que la cuenta te pertenece.</p>
                            </div>
                            

                            <div>
                                <label for="" class="text-primary fw-500 mb-1">Email:</label>
                                <input type="email" name="emailReactivacion" class="form-control text-center shadow-none border border-3 fs-3" value="<?php echo isset($_GET['email']) ? $_GET['email'] : ''; ?>" placeholder="correo@dominio.com" required />
                            </div>
                                                
                        </div>
                        <div class="modal-footer">

                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>                            
                            <button type="submit" class="btn btn-success" name="btnReenvioActivacionCuenta"><i class="far fa-paper-plane me-2"></i> Enviar</button>

                        </div>
                    </form>

                </div>
            </div>
        </div>

        <div class="modal fade" id="modalCuentaExistente" tabindex="-1" aria-labelledby="modalCuentaExistenteLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    
                     

                        <div class="modal-header">
                            <h5 class="modal-title text-danger fw-500">
                                <i class="fas fa-exclamation-triangle me-1"></i> Cuenta existente
                            </h5>
                            <button type="button" class="btn btn-icon btn-outline-danger btn-sm" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa-solid fa-xmark fa-xl"></i>
                            </button>
                        </div>

                        <div class="modal-body">
                            
                            <div class="mb-3 ">
                                <p>Ya existe una cuenta ligada al correo ingresado, intenta iniciar sesión o reestablecer tu contraseña.</p>
                            </div>
                  
                                                
                        </div>
                        <div class="modal-footer">

                            <button type="button" class="btn btn-green" data-bs-dismiss="modal">Entedido</button>                

                        </div> 

                </div>
            </div>
        </div>
        
        <!-- <script src="app/js/scripts.js"></script> -->
        <?php
            include 'src/modals.php';
            include 'app/php/triggers.php';
        ?>  
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>        
        <script src="js/scripts.js"></script> 
        <script>
            // document.getElementById("openModalBtn").addEventListener("click", function () {
            //     var myModal = new bootstrap.Modal(document.getElementById('modalReenvioActivacionCuenta'));
            //     myModal.show();
            // });
        </script>
    </body>
</html>
