<?php

	session_start();
	//echo session_id();

	require 'php/conexion_db.php';
	require 'php/login.php';
	require 'php/funciones.php';

	$path = $_SERVER['REQUEST_URI'];
  $file = basename($path);         // $file is set to "index.php"
  $file = basename($path, ".php"); // $f

	echo $file;

	// verifico si el usuario tiene creada la sesion previamente, si el email esta en la variable de sesion.
	if(isset($_SESSION['email']) && !empty($_SESSION['email']))
	{

		$email = $_SESSION['email'];

		// Traigo los datos del email correspondiente, por ej. nombre de usuario, apellido, nombre ,etc
		$get_datos_usuario = mysqli_query($db_connection, "SELECT * FROM `usuarios` WHERE email = '$email'");
		$datosUsuario =  mysqli_fetch_assoc($get_datos_usuario);

	}
	else
	{
		//si no esta es porque no pasó por el formulario de login, asi que afuera
		header('Location: salir.php');
		exit;
	}

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- <link rel="stylesheet" href="estilos.css" media="all" type="text/css"> -->
<title></title>
	<style type="text/css">
		.card
		{
			max-width: 300px;
			height: 100%;
			border: 3px solid green;
			padding: 12px;
		}
		img
		{
			width: 100%;
		}
	</style>
</head>
<body>
	<?php require 'header.php'; ?>
	<h1>Hola, <?php echo $datosUsuario['nombre'];?></h1>
	<br>
	<?php

		$sql = "SELECT
		productos.ProdId,
		productos.ProdNombre,
		productos.ProdDescripcionPrincipal,
		productos.ProdDescripcionSecundario,
		productos.ProdContenidoSimplificado,
		productos.ProdPrecioCompleto,
		productos.ProdPrecioDescuento,
		productosimg.imagen1
		FROM productos
		INNER JOIN productosimg
		ON
		productos.ProdId = productosimg.ProdId";

		if (isset($_GET['id']))
		{
			$id = limpiarDato($_GET['id']);
			$sql .= " WHERE productos.ProdId = '$id'";
		}

		$result = $db_connection->query($sql);

		if ($result->num_rows > 0)
		{
			// output data of each row
			while($row = $result->fetch_assoc())
			{
				?>
					<div class="card">
						<h2><?php echo $row["ProdNombre"]; ?></h2>
						<br>
						<img src="<?php echo $row["imagen1"]; ?>" alt="">
						<small><bold><?php echo $row["ProdDescripcionPrincipal"]; ?></bold></small>


						<div class="row">
							<span style="text-decoration:line-through;">
								$ <?php echo $row["ProdPrecioCompleto"]; ?>
							</span>
							<br>
							<h3><?php echo "$ " . $row["ProdPrecioDescuento"]; ?></h3>

							<?php
								if (!isset($_GET['id']))
								{
									?>
									<a href="detalle.php?id=<?php echo $row["ProdId"]; ?>">Ver detalle</a>
									<?php
								}
							?>

							<form action="php/procesa.php" method="post">
								<input  type="hidden" name="idProducto" value="<?php echo $row["ProdId"]; ?>">
								<input type="text" name="redireccion" value="<?php echo getFileName(); ?>">
								<button type="submit" name="btnAgregarCarrito">Comprar ahora</button>
							</form>

						</div>

					</div>
				<?php
			}

		}
		else
		{
			echo "0 results";
		}

		$db_connection->close();

	?>
	</body>
</html>
