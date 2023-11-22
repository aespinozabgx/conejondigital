<nav class="sidenav shadow-right sidenav-light">
    <div class="sidenav-menu">
        <?php

        //echo basename($_SERVER["SCRIPT_FILENAME"]);

        if (isset($_SESSION['email']))
        {
        ?>
          <div class="nav accordion" id="accordionSidenav">
            <!-- Sidenav Menu Heading (Account)-->
            <!-- * * Note: * * Visible only on and above the sm breakpoint-->
            <!-- <div class="sidenav-menu-heading d-sm-none">Account</div> -->


            <!-- Sidenav Menu Heading (Core)-->
            <div class="sidenav-menu-heading">Inicio</div>
            <!-- Sidenav Accordion (Dashboard)-->
            <a class="nav-link" href="app/dashboard.php" />
                <div class="nav-link-icon"><i data-feather="activity"></i></div>
                Dashboard
            </a>

            <!-- Sidenav Heading (Custom)-->
            <div class="sidenav-menu-heading">Vendy</div>

            <!-- Sidenav Accordion (Pages)-->
            <a class="nav-link" href="app/pos.php" />
                <div class="nav-link-icon"><i class="fas fa-cash-register"></i></div>
                Punto de venta
            </a>

            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapsePerfil" aria-expanded="false" aria-controls="collapsePerfil">
                <div class="nav-link-icon">
                    <i class="fas fa-store"></i>
                </div>
                Mi tienda
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapsePerfil" data-bs-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav">
                    <a class="nav-link" href="app/mis-articulos.php">Articulos</a>
                    <a class="nav-link" href="app/mis-ventas.php">Ventas</a>
                    <a class="nav-link" href="app/reportes.php">Reportes</a>
                    <a class="nav-link" href="app/mi-reputacion.php">Reputación</a>
                    <a class="nav-link" href="app/configura-sucursales.php">Sucursales</a>
                    <a class="nav-link" href="app/configura-tienda.php">Configuración</a>
                </nav>
            </div>

            <!-- Sidenav Accordion (Utilities)-->
            <a class="nav-link collapsed" href="app/mis-compras.php">
                <div class="nav-link-icon">
                    <i class="" data-feather="shopping-bag"></i>
                </div>
                Mis Compras
            </a>

            <a class="nav-link collapsed" href="app/cuenta-configuracion.php">
                <div class="nav-link-icon">
                    <i class="" data-feather="user"></i>
                </div>
                Cuenta
            </a>

            <a class="nav-link collapsed" href="https://api.whatsapp.com/send?phone=5215610346590&text=Hola,%20requiero%20soporte%20con%20mi%20tienda%20vendy." target="_blank">
                <div class="nav-link-icon">
                    <i class="fas fa-headset"></i>
                </div>
                Soporte <span class="text-gray-600 fw-700">Vendy</span>
            </a>

        </div>
        <?php
        }
        else
        {
        ?>
          <div class="nav accordion" id="accordionSidenav">
            <!-- Sidenav Menu Heading (Account)-->
            <!-- * * Note: * * Visible only on and above the sm breakpoint-->

            <!-- Sidenav Link (Messages)-->
            <!-- * * Note: * * Visible only on and above the sm breakpoint-->
            <!-- <a class="nav-link d-sm-none" href="#!">
                <div class="nav-link-icon"><i data-feather="mail"></i></div>
                Messages
                <span class="badge bg-success-soft text-success ms-auto">2 New!</span>
            </a> -->
            <!-- Sidenav Menu Heading (Core)-->
            <div class="sidenav-menu-heading">LOGIN</div>
            <!-- Sidenav Accordion (Dashboard)-->
            <a class="nav-link collapsed" href="app/index.php?redirect=carrito.php&idTienda=<?php echo ($idTienda); ?>">
                Iniciar Sesión
            </a>

          </div>
        <?php
        }
        ?>
    </div>
    <!-- Sidenav Footer-->
    <?php
      if (isset($_SESSION['email']))
      {
          ?>
          <div class="sidenav-footer">
              <div class="sidenav-footer-content">
                  <div class="sidenav-footer-subtitle">Tienda: </div>
                  <div class="sidenav-footer-title fw-600 fs-6 text-gray-600">
                    <?php
                      if (isset($_SESSION['managedStore']))
                      {
                        echo strtolower($_SESSION['managedStore']);
                      }
                    ?>
                  </div>
              </div>
          </div>
          <?php
      }
      else
      {
        ?>
        <div class="sidenav-footer">
            <div class="sidenav-footer-content">
                <div class="sidenav-footer-subtitle">Hola, </div>
                <div class="sidenav-footer-title">Invitado</div>
            </div>
        </div>
        <?php
      }
    ?>
</nav>
