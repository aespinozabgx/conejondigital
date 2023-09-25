<?php
  session_start();

  if (isset($_SESSION['email']) && isset($_SESSION['nombre'])) 
  {
    echo "Hola, " . $_SESSION['nombre'];
  } 
  else
  {
    ?>
    <a href="../login.php">Iniciar sesión</a>
    <?php
  }

?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h1>Conejón Digital</h1>
    <a href="eventos.php">Eventos</a>
    <a href="salir.php">salir</a>
  </body>
</html>
