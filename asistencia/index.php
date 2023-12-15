<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container { 
        }

        h1 {
            text-align: center;
            color: #007bff;
        }

        #asistenciaForm {
            margin-top: 20px;
        }

        label {
            color: #495057;
        }

        input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            margin-bottom: 20px;
            box-sizing: border-box;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        button {
            background-color: #007bff;
            color: #ffffff;
            padding: 10px 15px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        #mensajeError {
            margin-top: 20px; 
            font-size: 2em;
        }
    </style>
</head>
<body>
    
    <div class="d-flex justify-content-center">
        <div class="col-sm-10 col-md-8 col-lg-8 col-xl-8  p-5 bg-white rounded-2 m-5">
            <h1>Conejón Navideño 2023</h1>

            <form id="asistenciaForm" method="post" action="buscar_asistencia.php">
                <div class="mb-3">
                    <label for="email" class="form-label mb-2">Escanea el código:</label>
                    <input type="email" id="email" name="email" class="form-control form-control-lg" autofocus required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Buscar</button>
            </form>

            <div id="mensajeError" class="mt-3 fs-1">
                <?php
                    // Muestra el mensaje si existe en la variable de sesión
                    if (isset($_SESSION['mensaje'])) {
                        echo $_SESSION['mensaje'];
                        // Limpia la variable de sesión después de mostrar el mensaje
                        unset($_SESSION['mensaje']);
                    }
                ?>
            </div>
            <div id="fechaAsistencia"></div>
        </div>
    </div>

    <!-- Enlaces a Bootstrap 5 JS (opcional, solo si necesitas componentes interactivos) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofT38+2OrAe7F1g9CGtbT7bN8WBhElB" crossorigin="anonymous"></script>
</body>
</html>
