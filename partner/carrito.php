<?php

    if (isset($_SESSION['cart']))
    {

        // Count each occurrence
        $counts = array_count_values($_SESSION['cart']);

        // Sort the counts in descending order
        arsort($counts);

        // Display the results
        echo "Carrito: <pre>";
        print_r($counts);
        echo "</pre>";

        $contadorProductos = 0;
        foreach ($counts as $key => $value)
        {
          $contadorProductos += $value;
        }

        echo "<h2>Carro: " . $contadorProductos . "</h2>";
    }
    ?>
