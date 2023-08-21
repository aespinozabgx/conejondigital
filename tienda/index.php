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
    <h1>Tienda Conejón</h1>

    <a href="salir.php">salir</a>
  </body>
</html>
