<?php
    
    session_start();
    require '../app/php/conexion.php';
    require '../app/php/funciones.php';

    if (isset($_SESSION['username']))
    {
        $username = $_SESSION['username'];
    }
    else
    {
        $username = $_SESSION['email'];
    }
	
	if (isset($_SESSION['rol']) && $_SESSION['rol'] !== "admin") 
	{
		die('No tienes permitido estar aquí.');
	}

?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title> </title>
  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'>
<link rel='stylesheet' href='https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css'>
<link rel='stylesheet' href='https://cdn.datatables.net/buttons/1.2.2/css/buttons.bootstrap.min.css'><link rel="stylesheet" href="./style.css">

</head>
<body>
<!-- partial:index.partial.html -->
<a href="../app/"  class="btn btn-info btn-lg" style="margin-bottom: 15px;">Regresar</a>
 

<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>Nombre</th>
			<th>Correo</th> 
		</tr>
	</thead>
	<tbody>
	<?php

// Verifica la conexión
if ($conn->connect_error) 
{
	die("Conexión fallida: " . $conn->connect_error);
}

// Realiza la consulta SQL
$sql = "SELECT * FROM usuarios WHERE rol !='admin'";
$result = $conn->query($sql);

// Inicializa el array
$usuarios = array();

// Verifica si hay resultados y almacena los datos en el array
if ($result->num_rows > 0) 
{
	while ($row = $result->fetch_assoc()) 
	{
		$usuarios[] = $row;
	}
} 
else 
{
	$usuarios = false; // No hay resultados, se establece en false
}

// Cierra la conexión a la base de datos
$conn->close();

// $usuarios contiene los resultados o false si no hay resultados

foreach ($usuarios as $user) {
	echo "<tr>";                                                    
	echo "<td>" . $user['nombre'] . "</td>";
	echo "<td>" . $user['email'] . "</td>";
	echo "</tr>";
}

?>
		 
	</tbody>
</table>
 
<!-- partial -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
<script src='https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js'></script>
<script src='https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js'></script>
<script src='https://cdn.datatables.net/buttons/1.2.2/js/buttons.colVis.min.js'></script>
<script src='https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js'></script>
<script src='https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js'></script>
<script src='https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js'></script>
<script src='https://cdn.datatables.net/buttons/1.2.2/js/buttons.bootstrap.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js'></script>
<script src='https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js'></script>
<script src='https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js'></script>
<script  src="./script.js"></script>

</body>
</html>
