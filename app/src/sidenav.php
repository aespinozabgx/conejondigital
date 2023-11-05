<div id="layoutSidenav_nav">
    <nav class="sidenav shadow-right sidenav-dark">
        <div class="sidenav-menu">
            <div class="nav accordion" id="accordionSidenav">
                <div class="sidenav-menu-heading">Menú</div>
                <a class="nav-link text-white-50" href="index.php">
                    <div class="nav-link-icon text-white-50"><i data-feather="home"></i></div>
                    Inicio
                </a>                            

                <a class="nav-link collapsed" href="eventos.php">
                    <div class="nav-link-icon">
                        <i data-feather="calendar"></i>
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
                        <i data-feather="settings"></i>
                    </div>
                    Configuración <span class="text-gray-600 fw-700"> </span>
                </a>
                <a class="nav-link collapsed" href="https://api.whatsapp.com/send?phone=5215610346590&text=Hola,%20requiero%20soporte%20de%20mi%20cuenta%20conejondigital.com" target="_blank">
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
