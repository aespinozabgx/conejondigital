
<nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-dark bg-gray-800" id="sidenavAccordion">
    <!-- Sidenav Toggle Button-->
    <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 me-2 ms-lg-2 me-lg-0" id="sidebarToggle"><i data-feather="menu" class="feather-lg text-white"></i></button>
    <!-- Navbar Brand-->
    <a class="navbar-brand pe-3 ps-4 ps-lg-2 text-yellow " href="index.php"> 
        <div class="fs-6 fw-500">
            <!-- <span class="material-symbols-outlined">
                cruelty_free
            </span>
            Conejón Digital -->
            Conejón Digital <small class="text-white fw-300">Partner</small>
            <!-- <img src="./assets/img/logo.jpg" style="height: 55px;" class="mt-0 img-fluid p-1" alt="">             -->
            <?php
                if(isset($isConexionLocal) && $isConexionLocal && 1==1)
                {
                    ?>
                    <span class="small text-white fw-300"> {Developer}</span>
                    <?php
                }
            ?>
        </div>
    </a>
    <!-- Navbar Search Input-->

    <ul class="navbar-nav align-items-center ms-auto">

        <!-- Alerts Dropdown-->
        <li class="nav-item dropdown no-caret d-none d-sm-block me-3 dropdown-notifications">
            <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownAlerts" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i data-feather="bell" class="text-white"></i></a>
            <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownAlerts">
                <h6 class="dropdown-header dropdown-notifications-header">
                    <i class="me-2" data-feather="bell"></i>
                    Centro de alertas
                </h6>
                <!-- Example Alert 1-->
                <!-- <a class="dropdown-item dropdown-notifications-item" href="#!">
                    <div class="dropdown-notifications-item-icon bg-warning"><i data-feather="activity"></i></div>
                    <div class="dropdown-notifications-item-content">
                        <div class="dropdown-notifications-item-content-details">December 29, 2021</div>
                        <div class="dropdown-notifications-item-content-text">This is an alert message. It's nothing serious, but it requires your attention.</div>
                    </div>
                </a> -->
                <!-- Example Alert 2-->
                <!-- <a class="dropdown-item dropdown-notifications-item" href="#!">
                    <div class="dropdown-notifications-item-icon bg-info"><i data-feather="bar-chart"></i></div>
                    <div class="dropdown-notifications-item-content">
                        <div class="dropdown-notifications-item-content-details">December 22, 2021</div>
                        <div class="dropdown-notifications-item-content-text">A new monthly report is ready. Click here to view!</div>
                    </div>
                </a> -->
                <!-- Example Alert 3-->
                <!-- <a class="dropdown-item dropdown-notifications-item" href="#!">
                    <div class="dropdown-notifications-item-icon bg-danger"><i class="fas fa-exclamation-triangle"></i></div>
                    <div class="dropdown-notifications-item-content">
                        <div class="dropdown-notifications-item-content-details">December 8, 2021</div>
                        <div class="dropdown-notifications-item-content-text">Critical system failure, systems shutting down.</div>
                    </div>
                </a> -->
                <!-- Example Alert 4-->
                <!-- <a class="dropdown-item dropdown-notifications-item" href="#!">
                    <div class="dropdown-notifications-item-icon bg-success"><i data-feather="user-plus"></i></div>
                    <div class="dropdown-notifications-item-content">
                        <div class="dropdown-notifications-item-content-details">December 2, 2021</div>
                        <div class="dropdown-notifications-item-content-text">New user request. Woody has requested access to the organization.</div>
                    </div>
                </a> -->
                <a class="dropdown-item dropdown-notifications-footer" href="#!">No hay alertas</a>
            </div>
        </li>
        <!-- Messages Dropdown-->
        <li class="nav-item dropdown no-caret d-none d-sm-block me-3 dropdown-notifications">
            <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownMessages" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i data-feather="mail" class="text-white"></i></a>
            <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownMessages">
                <h6 class="dropdown-header dropdown-notifications-header">
                    <i class="me-2" data-feather="mail"></i>
                    Centro de mensajes
                </h6>

                <!-- Footer Link-->
                <a class="dropdown-item dropdown-notifications-footer" href="#!">No hay mensajes</a>
            </div>
        </li>

        <!-- User Dropdown-->
        <li class="nav-item dropdown no-caret dropdown-user me-3 me-lg-4">
            <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="img-fluid" src="assets/img/illustrations/profiles/profile-1.png" /></a>
            <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
                <h6 class="dropdown-header d-flex align-items-center">
                    <img class="dropdown-user-img" src="assets/img/illustrations/profiles/profile-1.png" />
                    <div class="dropdown-user-details">
                        <div class="dropdown-user-details-name"><?php echo $_SESSION['nombre']; ?></div>
                        <div class="dropdown-user-details-email"><?php echo $_SESSION['email']; ?></div>
                    </div>
                </h6>
                <div class="dropdown-divider"></div>

                <?php
                    //var_dump($_SESSION['isPartner']);
                    if (isset($_SESSION['isPartner']) && $_SESSION['isPartner'] == 1) 
                    {
                        ?>
                        <a class="dropdown-item text-center" href="../app/">
                            <div class="dropdown-item-icon">
                                <i data-feather="refresh-cw"></i>
                            </div>
                            <span class="fs-6 fw-400 text-dark">Volver a mi cuenta</span>
                        </a>
                        <?php
                    }
                ?>

                <!-- <a class="dropdown-item" href="cuenta-configuracion.php">
                    <div class="dropdown-item-icon"><i data-feather="settings"></i></div>
                    Cuenta
                </a>
                <a class="dropdown-item" href="salir.php">
                    <div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
                    Cerrar Sesión
                </a> -->
            </div>
        </li>
    </ul>
</nav>
