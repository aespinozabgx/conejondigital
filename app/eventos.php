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
    <h1><a href="../index.php">Conejón Digital</a>/Eventos</h1>
    <div style="padding: 30px;">
        Próximos Eventos:
        <p>
            Conejón Navideño 2023 
            <ul>
                <?php
                if (isset($_SESSION['email'])) 
                {
                    ?>
                    <li><a href="#">Descargar boleto</a></li>
                    <?php
                }
                else
                {
                    ?>
                    <li><a href="../registro.php">Quiero asistir</a></li>
                    <?php
                }
                ?>
                <li><a href="#">Ver evento</a></li>
            </ul>
        </p>
    </div>

    <a href="salir.php">salir</a>
  </body>
</html>
