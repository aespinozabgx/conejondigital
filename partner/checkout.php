  <?php

  session_start();
  require 'php/conexion_db.php';
  require 'php/funciones.php';
  require 'header.php';

  // Validate if there is something in the cart
  if (isset($_SESSION['cart']))
  {
    // Count each occurrence
    $cartData = array_count_values($_SESSION['cart']);

    // Sort the counts in descending order
    arsort($cartData);

    // Take de Product ID into idProducto array
    $i = 0;$conteo = 0;
    $sql = "";
    foreach ($cartData as $key => $value)
    {
      $idProducto[$i]  = $key;
      $sql .= "SELECT * FROM `productos` WHERE `ProdId` = '$key';";
      $i++;
    }

    // fetch info from database using the cart products
    // Execute multi query
    if (mysqli_multi_query($db_connection, $sql))
    {
      do
      {
        // Store first result set
        if ($result = mysqli_store_result($db_connection))
        {

          while ($row = mysqli_fetch_assoc($result))
          {
            $carrito[$conteo][0] = $row["ProdId"];
            $carrito[$conteo][1] = $row["ProdNombre"];
            $carrito[$conteo][2] = $row["ProdPrecioCompleto"];
            $carrito[$conteo][3] = $row["ProdPrecioDescuento"];
            $carrito[$conteo][4] = $cartData[$row["ProdId"]];
            // $carrito[$conteo][4] = $cartData[$row["ProdPrecioDescuento"]];
            $conteo++;
          }
          mysqli_free_result($result);
        }

        // if there are more result-sets, the print a divider
        if (mysqli_more_results($db_connection))
        {
          //printf("<br>");
        }
         //Prepare next result set
      }
      while (mysqli_next_result($db_connection));
    }

    mysqli_close($db_connection);

  }

	isVerified();

?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h2>Carrito de compras</h2>
    <?php

      if (isset($carrito))
      {
        echo "<ul>";
        $total = 0; $subTotal = 0;
        for ($i=0; $i < sizeof($carrito); $i++)
        {

          echo "<a href='detalle.php?id=". $carrito[$i][0]. "' target='_self'>Detalle producto</a>";
          echo "<br>";

          echo "id: " . $carrito[$i][0];
          echo "<br>";

          echo "Nombre: ". $carrito[$i][1];
          echo "<br>";

          echo "Precio: <strike>$ ". numero($carrito[$i][2]) . "</strike> <b>$ " . numero($carrito[$i][3]) ."</b>";
          echo "<br>";

          echo "Cant: ". $carrito[$i][4];
          echo "<br>";

          $subTotal = ($carrito[$i][3]*$carrito[$i][4]);
          echo "Subtotal: $" . numero($subTotal);
          echo "<br><br>";

          // echo "TOTAL: ";
          // var_dump($total);
          // echo "<br>";
          // echo "SUBTOTAL: ";
          // var_dump($subTotal);
          // echo "<br>";

          $total += $subTotal;


        }

        echo "Total a pagar: " . numero($total);

      }

    if (isset($carrito))
    {
    ?>
      <form action="php/procesa.php" method="post">
        <button type="submit" name="btnProcesaPago">Enviar</button>
      </form>
    <?php
  }
  else
  {
    ?>
    Aún no hay productos en tu carrito.
    <?php
  }
    ?>

  </body>
</html>
