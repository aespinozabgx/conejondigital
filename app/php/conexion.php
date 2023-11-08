<?php
	
	require 'config.php';
	
	if ($isConexionLocal)
	{
		$servername = "localhost";
		$username   = "root";
		$password   = '';
		$database	= "conejondigital";	
	}
	else
	{
		$servername = "185.212.71.16";
		$username   = "u854920720_app";
		$password   = '[dU&@Tjf1';
		$database	= "u854920720_conejon";
	}

	$conn = mysqli_connect(
		$servername,
		$username,
		$password,
		$database
	);
	
	mysqli_set_charset($conn, "utf8");
	
	// Verificar la conexión
	if (mysqli_connect_errno()) 
	{
		echo "Error al intentar conectarse con la DB: " . mysqli_connect_error();
	}

?>
