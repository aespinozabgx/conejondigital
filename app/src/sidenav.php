<div id="layoutSidenav_nav">
    <nav class="sidenav shadow-right sidenav-dark">
        <div class="sidenav-menu">
            <div class="nav accordion" id="accordionSidenav">
                <!-- Sidenav Menu Heading (Account)-->
                <!-- * * Note: * * Visible only on and above the sm breakpoint-->
                <!-- <div class="sidenav-menu-heading d-sm-none">Account</div> -->


                <!-- Sidenav Menu Heading (Core)-->
                <div class="sidenav-menu-heading">Menú</div>

                <!-- Sidenav Accordion (Dashboard)-->
                <a class="nav-link" href="index.php" />
                    <div class="nav-link-icon"><i data-feather="home"></i></div>
                    Inicio
                </a>
                                
                <a class="nav-link collapsed" href="eventos.php">
                    <div class="nav-link-icon">
                        <i class="" data-feather="calendar"></i>
                    </div>
                    Eventos
                </a>

                <a class="nav-link collapsed" href="mis-conejos.php">
                    <div class="nav-link-icon">
                        <i class="fas fa-carrot"></i>
                    </div>
                    Mis Cheñoles
                </a>


                
                <div class="sidenav-menu-heading">Cuenta</div>

                <a class="nav-link collapsed" href="cuenta-configuracion.php">
                    <div class="nav-link-icon">
                        <i class="" data-feather="settings"></i>
                    </div>
                    Configuración <span class="text-gray-600 fw-700"> </span>
                </a>

                <a class="nav-link collapsed" href="" target="_blank">
                    <div class="nav-link-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    Soporte <span class="text-gray-600 fw-700"> App</span>
                </a>

            </div>
        </div>
        <!-- Sidenav Footer-->
        <div class="sidenav-footer">
            <div class="sidenav-footer-content">
                <div class="sidenav-footer-subtitle">Hola, </div>
                <div class="sidenav-footer-title fw-600 fs-6 text-gray-600">
                  <?php
                    if (isset($_SESSION['nombre']))
                    {
                      echo ucwords(strtolower($_SESSION['nombre']));
                    }
                  ?>
                </div>
            </div>
        </div>
    </nav>
</div>
