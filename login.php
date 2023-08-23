<?php
        
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
        <title>Login - SB Admin Pro</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
        
        <style>
            
            .bgHueso
            {
                background-image: url('bg.jpg'); 
                background-repeat: repeat; 
                background-size: 500px; 
            }

        </style>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container-xl px-4 mt-5">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <!-- Basic login form-->
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header justify-content-center text-center">
                                        <i class="fas fa-carrot fs-1 text-yellow"></i>
                                        <div class="text-yellow display-6 fw-400">                                            
                                            Conejón Digital                                            
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <!-- Login form-->
                                        <form action="tienda/procesa.php" method="POST">
                                            <!-- Form Group (email address)-->
                                            <div class="fw-300 text-center fs-1 small text-dark">Ingresa a tu cuenta</div>
                                            <div class="mb-3">
                                                <label class="small text-dark mb-1" for="inputEmailAddress">Email</label>
                                                <input class="form-control border-3 rounded-3" name="form_email" value="<?php echo isset($_GET['correo']) ? $_GET['correo'] : ''; ?>" type="email" placeholder="correo@dominio.com" required />
                                            </div>
                                            <!-- Form Group (password)-->
                                            <div class="mb-3">
                                                <label class="small text-dark mb-1" for="inputPassword">Contraseña</label>
                                                <input class="form-control border-3 rounded-3" name="form_password" type="password" placeholder="Contraseña" required />
                                            </div>
                                            
                                            <input type="hidden" placeholder="Redirección" name="redirect" value="<?php echo $redirect; ?>">

                                            <!-- Form Group (login box)-->
                                            <div class="text-end mt-4 mb-0">
                                                <!-- <a class="small" href="auth-password-basic.html">Olvidé mi contraseña</a> -->
                                                <button class="btn btn-primary rounded-3 w-100 fs-6" type="submit" name="btnLogin28">
                                                    Iniciar sesión
                                                </button>
                                            </div>
                                        </form>
                                        <?php
                                            if (isset($urlMsg)) 
                                            {                                                                                        
                                                if ($urlMsg == 'errorCuentaInactiva') 
                                                {
                                                    ?>
                                                    <div class="text-danger text-center p-3 pt-4">
                                                        Cuenta inactiva<a href="">reenviar correo de activación</a>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class=""><a href="registro.php">¿No tienes cuenta? Registrate GRATIS</a></div>
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
        <div class="modal fade" id="modalReenvioActivacionCuenta" tabindex="-1" aria-labelledby="modalReenvioActivacionCuentaLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-primary fw-500">
                            <i class="feather-lg me-1" data-feather='mail'></i> Cuenta inactiva
                        </h5>
                        <button type="button" class="btn btn-icon btn-outline-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa-solid fa-xmark fa-xl"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        Para asegurarnos que la plataforma se mantenga segura debemos validar las direcciones de correo.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <form action="procesa.php" method="POST" class="">
                            <button class="btn btn-success">Reenviar correo de activación</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        
        <script src="tienda/js/scripts.js"></script>
        <?php
            include 'tienda/php/triggers.php';
        ?>
    </body>
</html>
