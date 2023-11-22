<?php
    // echo "<pre>";
    // print_r($_SESSION[$idTienda]);
    // die;
?>
<nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-white" id="sidenavAccordion">
    <!-- Sidenav Toggle Button-->
    <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 me-2 ms-lg-2 me-lg-0" id="sidebarToggle"><i data-feather="menu"></i></button>
    <!-- Navbar Brand-->
    <!-- * * Tip * * You can use text or an image for your navbar brand.-->
    <!-- * * * * * * When using an image, we recommend the SVG format.-->
    <!-- * * * * * * Dimensions: Maximum height: 32px, maximum width: 240px-->
    <a class="navbar-brand pe-3 ps-4 ps-lg-2 text-yellow text-decoration-none" href="index.php">
        <div class="fs-1">
            <i class="fas fa-store"></i>
            vendy
        </div>
    </a>
    <!-- Navbar Search Input-->
    <!-- * * Note: * * Visible only on and above the lg breakpoint-->

    <!-- Navbar Items-->
    <ul class="navbar-nav align-items-center ms-auto">

        <!-- Carrito -->
        <!-- <li class="nav-item dropdown no-caret me-3">
            <a class="btn btn-icon btn-transparent-dark btn-sm dropdown-toggle" id="navbarDropdownMessages" href="carrito.php" aria-haspopup="true" aria-expanded="false"><i data-feather="shopping-cart"></i></a>
        </li> -->

        <li class="nav-item dropdown no-caret me-1">
            <a href="carrito.php?tienda=<?php echo $idTienda; ?>" class="btn btn-outline-primary rounded-pill">
                <i data-feather="shopping-cart" class="me-1"></i>
                <span id="salidaCarrito" class="fw-00">
                    <?php 
                        echo contarCarrito($idTienda);
                    ?>
                </span>
            </a>
        </li>


        <!-- Cuenta-->
        <li class="nav-item dropdown no-caret dropdown-user me-1 me-lg-4">
            <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="img-fluid" src="assets/img/illustrations/profiles/profile-1.png" /></a>
            <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
                <?php
                if (isset($_SESSION['email']))
                {
                ?>
                  <h6 class="dropdown-header d-flex align-items-center">
                      <img class="dropdown-user-img" src="assets/img/illustrations/profiles/profile-1.png" />
                      <div class="dropdown-user-details">
                          <div class="dropdown-user-details-name">
                              <?php
                                  if (isset($_SESSION['nombre']))
                                  {
                                      echo ucwords(strtolower($_SESSION['nombre']));
                                  }
                              ?>
                          </div>
                          <div class="dropdown-user-details-email">
                              <?php
                                  if (isset($_SESSION['email']))
                                  {
                                      echo $_SESSION['email'];
                                  }
                              ?>
                          </div>
                      </div>
                  </h6>
                  <div class="dropdown-divider"></div>

                  <a class="dropdown-item" href="app/cuenta-configuracion.php">
                      <div class="dropdown-item-icon"><i data-feather="settings"></i></div>
                      Mi cuenta
                  </a>

                  <a class="dropdown-item" href="salir.php">
                      <div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
                      Cerrar sesión
                  </a>
                <?php
                }
                else
                {
                  ?>
                  <a class="dropdown-item" href="app/index.php?redirect=carrito.php&tienda=<?php echo $tienda['idTienda']; ?>">
                      <div class="dropdown-item-icon">
                          <i class="fas fa-sign-in-alt"></i>
                      </div>
                      Iniciar Sesión
                  </a>
                  <?php
                }
                ?>
            </div>
        </li>
    </ul>
</nav>
