<?php
// Definir un array asociativo con los enlaces y sus destinos
$enlaces = array(
    'General' => 'configura-tienda.php',
    'Contacto' => 'configura-contactoTienda.php',
    'Pagos' => 'configura-pagos.php',
    'Envíos' => 'configura-envios.php'
);

// Obtener la URL actual para resaltar el enlace activo
$urlActual = basename($_SERVER['PHP_SELF']);

?>

<nav class="nav nav-borders">
    <?php foreach ($enlaces as $texto => $destino) : ?>
        <a class="nav-link<?= ($urlActual == $destino) ? ' active ms-0' : '' ?>" href="<?= $destino ?>"><?= $texto ?></a>
    <?php endforeach; ?>
</nav>
