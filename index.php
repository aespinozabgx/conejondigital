<?php

    session_start();

?>

<!DOCTYPE html>
<html lang="es">
    <head>
        
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        
        <title></title>
        
        <link href="css/styles.css?id=2444" rel="stylesheet" />
        <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
        
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.24.1/feather.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bangers" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,400,900" rel="stylesheet">   
        <link rel="stylesheet" href="css/contador-style.css">
        
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> -->


        <style>
            
            mark 
            {
                background-color: rgba(129, 88, 53, 0.48);
                color: #FFF;
            }

        </style>
     
    </head>
    <body>
        <div id="layoutDefault">
            <div id="layoutDefault_content">
                <main>
                    <!-- Navbar-->
                    <nav class="navbar navbar-marketing navbar-expand-lg bg-transparent navbar-light">
                        <div class="container px-5">
                            <a class="text-decoration-none text-pink fs-1 f-bangers" href="index.php">                                
                                <span class="material-symbols-outlined">cruelty_free</span>
                                Conejón Digital
                            </a>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i data-feather="menu"></i></button>
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav ms-auto me-lg-5">

                                    <li class="nav-item"><a class="nav-link f-poppins" href="index.php">Inicio</a></li>

                                    <li class="nav-item dropdown dropdown-xl no-caret">
                                        <!-- <a class="f-poppins nav-link dropdown-toggle" id="navbarDropdownDemos" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Tienda
                                            <i class="fas fa-chevron-right dropdown-arrow"></i>
                                        </a> -->
                                        <div class="dropdown-menu dropdown-menu-end animated--fade-in-up me-lg-n25 me-xl-n15" aria-labelledby="navbarDropdownDemos">
                                            <div class="row g-0">
                                                <div class="col-lg-5 p-lg-3 bg-img-cover overlay overlay-primary overlay-70 d-none d-lg-block" style="background-image: url('assets/img/backgrounds/bg-dropdown-xl.jpg')">
                                                    <div class="d-flex h-100 w-100 align-items-center justify-content-center">
                                                        <div class="text-white text-center z-1">
                                                            <div class="mb-3">Gran variedad de productos con vendedores confiables.</div>
                                                            <a class="btn btn-white btn-sm text-primary fw-500" href="tienda">Ver todo</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7 p-lg-5">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            
                                                            <h6 class="dropdown-header text-primary">Salud</h6>
                                                            <a class="dropdown-item" href="#">Subcategoría</a>
                                                            <a class="dropdown-item" href="#">Subcategoría</a>
                                                            <div class="dropdown-divider border-0"></div>
                                                            
                                                            <h6 class="dropdown-header text-primary">Alimentación</h6>
                                                            <a class="dropdown-item" href="#">Subcategoría</a>
                                                            <a class="dropdown-item" href="#">Subcategoría</a>
                                                            <a class="dropdown-item" href="#">Subcategoría</a>
                                                            <div class="dropdown-divider border-0"></div>

                                                            <h6 class="dropdown-header text-primary">Jueguetes</h6>
                                                            <a class="dropdown-item" href="#">Subcategoría</a>
                                                            <div class="dropdown-divider border-0 d-lg-none"></div>

                                                        </div>
                                                        <div class="col-lg-6">
                                                           

                                                            <h6 class="dropdown-header text-primary">Habitat</h6>
                                                            <a class="dropdown-item" href="#">Subcategoría</a>
                                                            <a class="dropdown-item" href="#">Subcategoría</a>
                                                            <div class="dropdown-divider border-0"></div>

                                                            <h6 class="dropdown-header text-primary">Accesorios</h6>
                                                            <a class="dropdown-item" href="#">Subcategoría</a>
                                                            <a class="dropdown-item" href="#">Subcategoría</a>
                                                            <div class="dropdown-divider border-0"></div>
                                                            
                                                            <h6 class="dropdown-header text-primary">Arte y Manualidades</h6>
                                                            <a class="dropdown-item" href="#">Subcategoría</a>
                                                            <a class="dropdown-item" href="#">Subcategoría</a>
                                                            <div class="dropdown-divider border-0"></div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    
                                    <li class="nav-item f-poppins "><a class="nav-link" href="#evento">Evento</a></li>

                                    <li class="nav-item f-poppins "><a class="nav-link" href="#layoutDefault_footer">Contacto</a></li>

                                </ul>
                                
                                <!-- <a class="btn fw-500 ms-lg-4 mb-2 me-1 btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#modalRegistroExpositor">
                                    Registrarme                                    
                                </a> -->
                                
                                <?php
                                if (!isset($_SESSION['email'])) 
                                {
                                    ?>
                                    <a class="btn fw-500 ms-lg-1 mb-2 me-1 btn-danger" href="registro.php">
                                        Registrarme                       
                                    </a>

                                    <a class="btn fw-500 ms-lg-1 mb-2 me-1 btn-light shadow-sm" href="login.php">
                                        Iniciar sesión                       
                                    </a>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <a class="btn fw-500 ms-lg-1 mb-2 me-1 btn-outline-pink" href="app/">
                                        Mi cuenta
                                    </a>  
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </nav>

                    
                    <div class="snowflakes" aria-hidden="true">                        
                        <div class="snowflake">❅</div><div class="snowflake">❅</div><div class="snowflake">❅</div><div class="snowflake">❅</div>
                        <div class="snowflake">❅</div><div class="snowflake">❅</div><div class="snowflake">❅</div><div class="snowflake">❅</div>
                        <div class="snowflake">❅</div><div class="snowflake">❅</div><div class="snowflake">❅</div><div class="snowflake">❅</div>
                        <div class="snowflake">❅</div><div class="snowflake">❅</div><div class="snowflake">❅</div><div class="snowflake">❅</div>
                        <div class="snowflake">❅</div><div class="snowflake">❅</div><div class="snowflake">❅</div><div class="snowflake">❅</div>
                        <div class="snowflake">❅</div><div class="snowflake">❅</div><div class="snowflake">❅</div><div class="snowflake">❅</div>
                        <div class="snowflake">❅</div><div class="snowflake">❅</div><div class="snowflake">❅</div><div class="snowflake">❅</div>
                        <div class="snowflake">❅</div><div class="snowflake">❅</div><div class="snowflake">❅</div><div class="snowflake">❅</div>
                        <div class="snowflake">❅</div><div class="snowflake">❅</div><div class="snowflake">❅</div><div class="snowflake">❅</div>
                        <div class="snowflake">❅</div><div class="snowflake">❅</div><div class="snowflake">❅</div><div class="snowflake">❅</div>
                        <div class="snowflake">❅</div><div class="snowflake">❅</div><div class="snowflake">❅</div><div class="snowflake">❅</div>
                        <div class="snowflake">❅</div><div class="snowflake">❅</div><div class="snowflake">❅</div><div class="snowflake">❅</div>
                        <div class="snowflake">❅</div><div class="snowflake">❅</div><div class="snowflake">❅</div><div class="snowflake">❅</div>
                        <div class="snowflake">❅</div><div class="snowflake">❅</div><div class="snowflake">❅</div><div class="snowflake">❅</div>
                    </div>
                    
                    <!-- Page Header-->
                    <header class="page-header-ui page-header-ui-light bg-img-cover" style="background-image: url('assets/img/landing-5.jpg')">
                        <div class="page-header-ui-content pt-5">
                            <div class="container px-5">
                                <div class="row gx-5 align-items-center">
                                    <div class="col-lg-5 col-xl-5 mb-3" data-aos="zoom-out-down">
                                        <div class="f-bangers text-white display-1 mb-2" style="text-shadow: -4px 4px 1px rgba(236, 18, 18, 0.962);">¡Cheñolas <span class="f-bebas display-6">y</span> <br> cheñoles!</div>
                                        <div class="text-white mb-3 fs-1" style=" ">
                                            <mark>¡Ya viene el conejón navideño 2023!</mark>
                                        </div>
                                        <div class="text-white mb-1 fs-3">
                                            <mark><i class="far fa-calendar-alt me-1"></i> 9 y 10 de Diciembre</mark>
                                        </div>
                                        <div class="text-white mb-5 fs-3">
                                            <mark>
                                                <i class="fas fa-map-marker-alt me-1"></i>
                                                <a class="text-white" href="https://maps.app.goo.gl/R5SRP6jJLXRyz5k5A" target="_blank">
                                                    Reforma Nte 742, CDMX
                                                    <i class="ms-1" data-feather="external-link"></i>
                                                </a>
                                            </mark>                                            
                                        </div>
                                        
                                        <div class="d-flex flex-column flex-sm-row">
                                                                                    
                                            <a class="btn btn-lg btn-light f-poppins fw-300 mb-3 ms-sm-0 mb-sm-0" style="" href="#evento">
                                                Detalles del evento
                                                <i class="ms-2" data-feather="info"></i>
                                            </a>
                                            <a class="btn btn-lg btn-danger f-poppins fs-2 fa-beat fw-500 ms-sm-4 mb-3 mb-sm-0" style="--fa-beat-scale: 1.1; --fa-animation-duration: 2s;" href="registro.php">
                                                ¡Quiero asistir!
                                                <i class="ms-2" data-feather="arrow-right"></i>
                                            </a>

                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                        <div class="svg-border-rounded text-blue"  style="color: ;">
                            <!-- Rounded SVG Border-->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 144.54 17.34" preserveAspectRatio="none" fill="currentColor"><path d="M144.54,17.34H0V0H144.54ZM0,0S32.36,17.34,72.27,17.34,144.54,0,144.54,0"></path></svg>
                        </div>                        
                    </header>
                    
                    
                    <section class="py-10 bg-blue" style="">
                        <div class="container px-2" id="evento">
                            <div class="row gx-5 justify-content-center">
                                <div class="">
                                    <div class="mb-10 text-center" data-aos="fade-up">
                                        
                                        <img src="app/assets/img/banners/landing.jpg" class="img-fluid rounded-3 shadow-sm mb-5" alt="">
                                        <!-- <div class="display-3 f-bangers fw-400 text-uppercase text-white mb-2">El CONEJÓN NAVIDEÑO 2023<br></div> -->
                                        <span class="display-3 f-bangers fw-400 text-uppercase text-white mb-2">9 y 10 de Diciembre!</span>
                                                                                 
                                    </div>
                                </div>
                            </div>

                            <div class="display-3 px-3 f-poppins text-white mb-3" data-aos="fade-up">
                                Encontrarás ...
                            </div>

                            <div class="row gx-5 px-3 justify-content-center mb-3">
                                
                                <div class="col-md-4 col-lg-4 col-xl-3 mb-5" data-aos="fade-up">
                                    <a class="card bg-white" href="#!">
                                        <img class="card-img-top" src="assets/img/evento/arte-2.jpg" alt="..." />
                                        <div class="card-body text-center py-3"><h6 class="card-title text-pink f-poppins mb-0">Arte y Manualidades</h6></div>
                                    </a>
                                </div>

                                <div class="col-md-4 col-lg-4 col-xl-3 mb-5" data-aos="fade-up">
                                    <a class="card bg-white" href="#!">
                                        <img class="card-img-top" src="assets/img/evento/salud-2.jpg" alt="..." />
                                        <div class="card-body text-center py-3"><h6 class="card-title text-pink f-poppins mb-0">Salud y cuidados</h6></div>
                                    </a>
                                </div>

                                <div class="col-md-4 col-lg-4 col-xl-3 mb-5" data-aos="fade-up">
                                    <a class="card bg-white" href="#!">
                                        <img class="card-img-top" src="assets/img/evento/alimentacion.jpg" alt="..." />
                                        <div class="card-body text-center py-3"><h6 class="card-title text-pink f-poppins mb-0">Alimentación</h6></div>
                                    </a>
                                </div>
                                <div class="col-md-4 col-lg-4 col-xl-3 mb-5" data-aos="fade-up">
                                    <a class="card bg-white" href="#!">
                                        <img class="card-img-top" src="assets/img/evento/juegos.jpg" alt="..." />
                                        <div class="card-body text-center py-3"><h6 class="card-title text-pink f-poppins mb-0">Juguetes</h6></div>
                                    </a>
                                </div>
                                <div class="col-md-4 col-lg-4 col-xl-3 mb-5 mb-lg-0" data-aos="fade-up">
                                    <a class="card bg-white" href="#!">
                                        <img class="card-img-top" src="assets/img/evento/habitad.jpg" alt="..." />
                                        <div class="card-body text-center py-3"><h6 class="card-title text-pink f-poppins mb-0">Habitat</h6></div>
                                    </a>
                                </div>
                                <div class="col-md-4 col-lg-4 col-xl-3 mb-5 mb-lg-0" data-aos="fade-up">
                                    <a class="card bg-white" href="#!">
                                        <img class="card-img-top" src="assets/img/evento/accesorios.jpg" alt="..." />
                                        <div class="card-body bg-transparent text-center py-3"><h6 class="card-title text-pink f-poppins mb-0">Accesorios</h6></div>
                                    </a>
                                </div>
                                <div class="col-md-4 col-lg-4 col-xl-3 mb-5 mb-md-0" data-aos="fade-up">
                                    <a class="card bg-white" href="#!">
                                        <img class="card-img-top" src="assets/img/evento/adopcion.jpg" alt="..." />
                                        <div class="card-body text-center py-3"><h6 class="card-title text-pink f-poppins mb-0">Adopciones</h6></div>
                                    </a>
                                </div>
                                <div class="col-md-4 col-lg-4 col-xl-3" data-aos="fade-up">
                                    <a class="card bg-white" href="#!">
                                        <img class="card-img-top" src="assets/img/evento/mas.jpg" alt="..." />
                                        <div class="card-body text-center py-3"><h6 class="card-title text-pink f-poppins mb-0">Muchos más</h6></div>
                                    </a>
                                </div>
                            </div>

                            <div class="text-center text-white f-bangers display-1 py-5" data-aos="fade-up">
                                
                                ¡Entrada GRATIS!                                
                                <a class="btn btn-orange btn-lg f-poppins fa-beat fw-500 fs-4 ms-3 me-sm-3 mb-3 mt-2 mb-sm-0" style="--fa-beat-scale: 1.1; --fa-animation-duration: 2s;" href="registro.php">
                                    Registrarme
                                </a>

                            </div>                        

                        </div>
                        <div class="svg-border-angled text-white" style="color:;">
                            <!-- Angled SVG Border-->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none" fill="currentColor"><polygon points="0,100 100,0 100,100"></polygon></svg>
                        </div>
                    </section>
                    
                    <section class="pt-5 pb-10 bg-white">

                        <div class="container col-6"  data-aos="fade-up">
                            <div class="bg-green card mt-n15 shadow-sm mb-0 z-1 rounded-3 fa-beat" style="--fa-beat-scale: 1.1; --fa-animation-duration: 2s; background-color: #FFDAC1;">
                                <div class="card-body p-5 rounded-3">
                                    <div class="row gx-5 align-items-center">
                                        <div class="col-lg-6">
                                            <h1 class="text-white">                                                
                                                <i class="fas fa-bullhorn fa-rotate-by fa-lg me-2" style="--fa-rotate-angle: -30deg;"></i>
                                                Atención Expositores 
                                            </h1>
                                            <p class="lead text-white mb-3">Realiza tu pre registro y consigue tu lugar en el Conejón Navideño 2023 y en la tienda oficial del Conejón. <b>Lugares limitados.</b></p>
                                        </div>
                                        <div class="col-lg-6">
                                            <form action="">
                                                <div class="input-group mb-2 rounded-3" style=";">
                                                    <!-- <input class="form-control form-control-solid fs-3 shadow-none" type="text" placeholder="tucorreo@mail.com" aria-label="Recipient's username" aria-describedby="button-addon2" required /> -->
                                                    <!-- <button class="btn btn-outline-white fs-4 w-100 shadow-none" style="background-color:;" id="button-addon2" type="button" data-bs-toggle="modal" data-bs-target="#modalRegistroExpositor">Registro Expositor</button> -->

                                                    <a class="btn btn-white btn-lg fs-4 fw-500 w-100" style="" data-bs-toggle="modal" data-bs-target="#modalRegistroExpositor">Registrarme</a>
                                                </div>                                            
                                                 
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                          
                    </section>

                    <section class="bg-white pt-5 pb-10" style="background-color:;">
                        <div class="container px-5" data-aos="fade-up">
                            <div class="row gx-5 justify-content-center">
                                <div class="col-12">
                                    <div class="text-center mb-10">                                        
                                        <!-- <div class="f-bebas display-1 mb-3" style="color: #f17e76f3; text-shadow: 2px 2px 0px rgba(206, 190, 190, 0.653);"> 🛍️ Tienda Oficial </div> -->
                                        <!-- <p class="lead text-blue fw-500 fs-2">¡Encuentra todo para tus peluditos en la Tienda Oficial del Conejón!</p> -->
                                        <img src="app/assets/img/banners/2.jpg" class="img-fluid rounded-3" alt="">
                                        <div class="f-bangers display-6 mt-5 mb-3" data-aos="fade-up">¡Espérala pronto!</div>
                                    </div>
                                </div>
                            </div>
                            
                             
                        </div>
                        <div class="svg-border-rounded text-light">
                            <!-- Rounded SVG Border-->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 144.54 17.34" preserveAspectRatio="none" fill="currentColor"><path d="M144.54,17.34H0V0H144.54ZM0,0S32.36,17.34,72.27,17.34,144.54,0,144.54,0"></path></svg>
                        </div>
                    </section>                    
                    
                    <section class="bg-light ">
                        <!-- <div class="container px-5">

                            <div class="row gx-5 justify-content-center">
                                <div class="col-lg-8">
                                    <div class="text-center mb-10">
                                        <h2>sss</h2>
                                        <p class="lead">Our professional documentation includes usage instructions and other tips to help guide your development process as you build your project.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row gx-5">
                                <div class="col-lg-4 text-center mb-5">
                                    <div class="display-1 fw-700 text-gray-400">70+</div>
                                    <div class="h5">Custom/Extended Components</div>
                                    <p>We've extended and restyled Bootstrap's default components to create a this beautifully designed UI Toolkit.</p>
                                </div>
                                <div class="col-lg-4 text-center mb-5">
                                    <div class="display-1 fw-700 text-gray-400">35+</div>
                                    <div class="h5">Pre-Built Page Examples</div>
                                    <p>Pre-built page templates will save you hours of development time, allowing you to launch your project faster.</p>
                                </div>
                                <div class="col-lg-4 text-center mb-5">
                                    <div class="display-1 fw-700 text-gray-400">100+</div>
                                    <div class="h5">Custom/Extended Utilites</div>
                                    <p>Extended and new utility classes will give you even more control over your content with minimal custom CSS.</p>
                                </div>
                            </div>
                            <div class="text-center"><a class="btn btn-primary fw-500" href="https://docs.startbootstrap.com/sb-ui-kit-pro/quickstart">View Documentation</a></div>
                        </div> -->
                        <div class="svg-border-rounded text-green">
                            <!-- Rounded SVG Border-->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 144.54 17.34" preserveAspectRatio="none" fill="currentColor"><path d="M144.54,17.34H0V0H144.54ZM0,0S32.36,17.34,72.27,17.34,144.54,0,144.54,0"></path></svg>
                        </div>
                    </section>
                </main>
            </div>
            <div id="layoutDefault_footer">
                <footer class="footer pt-10 pb-5 mt-auto bg-green  text-white">
                    <div class="container px-5">
                        <div class="row gx-5">
                            <div class="col-lg-4">
                                <div class="fs-1 f-bangers text-white">
                                    <span class="material-symbols-outlined">cruelty_free</span>
                                    Conejón Digital
                                </div>
                                <div class="mb-3"></div>
                                <div class="icon-list-social mb-5 text-white">
                                    <a class="icon-list-social-link" href="#!"><i class="fab fa-instagram"></i></a>
                                    <a class="icon-list-social-link" href="#!"><i class="fab fa-facebook"></i></a> 
                                    <a class="icon-list-social-link" href="#!"><i class="fab fa-twitter"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="row gx-5">
                                    
                                    <div class="col-lg-3 col-md-6 mb-5 mb-lg-0 text-white">
                                        <div class="text-uppercase-expanded text-xs mb-4">Tienda Oficial</div>
                                        <!-- <ul class="list-unstyled mb-0">
                                            <li class="mb-2"><a href="tienda/"><i class="fas fa-carrot"></i> Alimentación</a></li>
                                            <li class="mb-2"><a href="tienda/"><i class="fas fa-medkit"></i> Salud</a></li>
                                            <li class="mb-2"><a href="tienda/"><i class="fas fa-baseball-ball"></i> Juguetes</a></li>
                                            <li class="mb-2"><a href="tienda/">Ver todo</a></li>                                            
                                        </ul> -->
                                        Próximamente
                                    </div>
                                    <div class="col-lg-4 col-md-6 mb-5 mb-md-0">
                                        <div class="text-uppercase-expanded mb-4 text-white">Conejón Navideño 2023</div>
                                        <ul class="list-unstyled mb-0">
                                            <li class="mb-2"><a href="registro.php" class="btn btn-blue text-dark shadow-none">Registro Visitante</a></li>
                                            <li class="mb-2 text-white"><a data-bs-toggle="modal" data-bs-target="#modalRegistroExpositor" class="btn btn-pink shadow-none">Registro Expositor</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="text-uppercase-expanded text-xs mb-4">Contacto</div>
                                        <ul class="list-unstyled mb-0">
                                            <li class="mb-2"><a href="#!"><i class="fas fa-headset"></i> Soporte</a></li>
                                            <li class="mb-2"><a href="mailto:ventas@conejondigital.com"><i class="far fa-envelope"></i> Ventas</a></li>                                            
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-5" />
                        <div class="row gx-5 align-items-center">
                            <div class="col-md-6 small"></div>
                            <div class="col-md-6 text-md-end small">
                                <a href="#!">Política de privacidad</a>
                                &middot;
                                <a href="#!">Terminos y Condiciones</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

         

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="js/contador-script.js?id=2828"></script>
        <script  src="js/scripts.js?id=2828"></script>
		<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            AOS.init({
				easing: 'ease-out-back',
				duration: 1000
			});
        </script>
        <?php
            
            if (file_exists('src/modals.php'))
            {
                require 'src/modals.php';
            }

            if (file_exists('src/triggers.php'))
            {
                require 'src/triggers.php';
            }

        ?>

    </body>
</html>
