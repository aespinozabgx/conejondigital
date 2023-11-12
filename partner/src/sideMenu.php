<?php

    $hasActivePayment = array();
    $hasActivePayment['existePagoActivo'] = true;
    
?>

<div id="layoutSidenav_nav">
    <nav class="sidenav shadow-right sidenav-light">
        <div class="sidenav-menu">
            <div class="nav accordion" id="accordionSidenav">
                
                <div class="sidenav-menu-heading">Menú</div>
                <a class="nav-link" href="index.php">
                    <div class="nav-link-icon"><i data-feather="home"></i></div>
                    Inicio
                </a>                            
                
                <!-- Sidenav Accordion (Pages)-->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapsePerfil" aria-expanded="false" aria-controls="collapsePerfil">
                    <div class="nav-link-icon">
                        <i class="fas fa-store"></i>
                    </div>
                    Mi tienda
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapsePerfil" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <?php
                        // var_dump(empty($hasActivePayment));
                        // echo "<hr>";
                        // var_dump(($hasActivePayment));
                        if (isset($hasActivePayment) && ($hasActivePayment !== false))
                        {
                            ?>
                            <a class="nav-link" href="pos.php" />                                
                                POS
                            </a>
                            <?php
                        }
                        else
                        {
                            ?>
                            <a style="cursor: pointer;" class="nav-link" data-bs-toggle="modal" data-bs-target="#modalSeccionDePago">
                                <div class="nav-link-icon"><i class="fas fa-cash-register"></i></div>
                                POS <span class="badge bg-yellow ms-1 rounded-pill small"><i class="fa-solid fa-sm fa-star"></i></span>
                            </a>
                            <?php
                        }
                        ?>
                        
                        <a class="nav-link" href="mis-articulos.php">Articulos</a>
                        <a class="nav-link" href="mis-categorias.php">Categorías</a>
                        
                        <?php                       

                        if (($hasActivePayment) && $hasActivePayment['existePagoActivo'] == true)
                        {
                            ?><a class="nav-link" href="mis-ventas.php">Ventas</a><?php
                        }
                        else
                        {
                            ?><a style="cursor: pointer;" class="nav-link" data-bs-toggle="modal" data-bs-target="#modalSeccionDePago">Ventas <span class="badge bg-yellow ms-1 rounded-pill"><i class="fa-solid fa-star fa-sm"></i></span></a><?php
                        }

                        if (($hasActivePayment) && $hasActivePayment['existePagoActivo'] == true)
                        {
                            ?><a class="nav-link" href="reportes.php">Reportes </a><?php
                        }
                        else
                        {
                            ?><a style="cursor: pointer;" class="nav-link" data-bs-toggle="modal" data-bs-target="#modalSeccionDePago">Reportes <span class="badge bg-yellow ms-1 rounded-pill"><i class="fa-solid fa-star fa-sm"></i></span></a><?php
                        }

                        if (($hasActivePayment) && $hasActivePayment['existePagoActivo'] == true)
                        {
                            ?><a class="nav-link" href="mi-reputacion.php">Reputación</a><?php
                        }
                        else
                        {
                            ?><a style="cursor: pointer;" class="nav-link" data-bs-toggle="modal" data-bs-target="#modalSeccionDePago">Reputación <span class="badge bg-yellow ms-1 rounded-pill"><i class="fa-solid fa-star fa-sm"></i></span></a><?php
                        }

                        if (($hasActivePayment) && $hasActivePayment['existePagoActivo'] == true)
                        {
                            ?><a class="nav-link" href="configura-sucursales.php">Sucursales</a><?php
                        }
                        else
                        {
                            ?><a style="cursor: pointer;" class="nav-link" data-bs-toggle="modal" data-bs-target="#modalSeccionDePago">Sucursales <span class="badge bg-yellow ms-1 rounded-pill"><i class="fa-solid fa-star fa-sm"></i></span></a><?php
                        }

                        if (($hasActivePayment) && $hasActivePayment['existePagoActivo'] == true)
                        {
                            ?><a class="nav-link" href="configura-tienda.php">Configuración</a><?php
                        }
                        else
                        {
                            ?><a style="cursor: pointer;" class="nav-link" data-bs-toggle="modal" data-bs-target="#modalSeccionDePago">Configuración <span class="badge bg-yellow ms-1 rounded-pill"><i class="fa-solid fa-star fa-sm"></i></span></a><?php
                        }

                        ?>
                        
                    </nav>
                </div>
                        
                <div class="sidenav-menu-heading">Cuenta</div>
               
                <a class="nav-link collapsed" href="https://api.whatsapp.com/send?phone=5215610346590&text=Hola,%20requiero%20soporte%20de%20mi%20cuenta%20de%20afiliado%20en%20conejondigital.com" target="_blank">
                    <div class="nav-link-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    Soporte <span class="text-gray-600 fw-700"> App</span>
                </a>
                
                <?php
                if (isset($_SESSION['rol']) && $_SESSION['rol'] == "admin") 
                {
                ?>
                <div class="sidenav-menu-heading">Admin</div>
                <a class="nav-link collapsed" href="../admin">
                    <div class="nav-link-icon">
                        <i data-feather="shield"></i>
                    </div>
                    Panel <span class="text-gray-600 fw-700"> </span>
                </a>
                <?php
                }
                ?>

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
<script>
    document.addEventListener('DOMContentLoaded', function() 
    {
        // Obtén el nombre real del archivo PHP actual
        let currentFileName = window.location.pathname.split('/').pop();

        // Obtén el menú con el ID "accordionSidenav"
        let menu = document.getElementById('accordionSidenav');

        // Obtén todos los enlaces del menú
        let menuLinks = menu.querySelectorAll('.nav-link');

        // Recorre todos los enlaces del menú y elimina la clase "active" de todos ellos
        menuLinks.forEach(function(link) 
        {
            link.classList.remove('active');
        });

        // Recorre los enlaces del menú y agrega la clase "active" al enlace cuyo href coincide con el nombre del archivo PHP actual (sin la barra diagonal inicial)
        menuLinks.forEach(function(link) 
        {
            let href = link.getAttribute('href');
            if (href && href.endsWith(currentFileName)) 
            {
                link.classList.add('active');

                // Expandir el elemento padre del enlace si es un elemento colapsable
                let parentCollapse = link.closest('.collapse');
                if (parentCollapse) 
                {
                    parentCollapse.classList.add('show');
                }

                // Verifica si el archivo actual es "index.php" y elimina la clase "text-white-75" del enlace y su elemento <i> correspondiente
                if (currentFileName === 'index.php') 
                {
                    link.classList.remove('text-white-75');
                    let iconElement = link.querySelector('i');
                    if (iconElement) 
                    {
                        iconElement.classList.remove('text-white-75');
                    }
                }
            }
        });
    });
</script>

