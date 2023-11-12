<?php
    session_start();

    require 'php/conexion_db.php';
    require 'php/funciones.php';

    if (isset($_SESSION['username']))
    {
        $username = $_SESSION['username'];
    }
    else
    {
        $username = $_SESSION['email'];
    }

    if (isset($_SESSION['email']))
    {
        $managedStore = $_SESSION['managedStore'];
        $tienda = $managedStore;
        $idTienda = $managedStore;
        $sql    = "SELECT count(*) AS conteo FROM productos WHERE idTienda = '$idTienda' AND isActive = 1";
        $result = mysqli_query($conn, $sql);
        $row    = mysqli_fetch_assoc($result);
        $totalProductos = $row['conteo'];
    }

    $idTienda = $_SESSION['managedStore'];

    // Obtener la fecha de hoy en español
    setlocale(LC_TIME, 'es_ES.UTF-8');
    setlocale(LC_TIME, "spanish");

    $fechaInicio = date('Y-m-01');
    $fechaFin = date('Y-m-d');

    if (isset($_GET['rangoFecha']))
    {
        // echo "GET";
        $fechas = $_GET['rangoFecha'];
        $fechas_array = explode(";", $fechas);

        // Validate the input dates
        $fechaInicio = date('Y-m-d', strtotime($fechas_array[0]));
        $fechaFin    = date('Y-m-d', strtotime($fechas_array[1]));

        if (!$fechaInicio || !$fechaFin || $fechaInicio > $fechaFin)
        {
            // echo "Default";
            // Fechas inválidas, establecer fechas default
            $fechaInicio = date('Y-m-d');
            $fechaFin = date('Y-m-d');
        }
    }

    // echo "<br><br>Resultado: " . $fechaInicio . ", " . $fechaFin . "<br><br>";
    $ventas_ganancias = getVentasGananciasTienda($conn, $idTienda, $fechaInicio, $fechaFin);
    $total_ingresos   = getIngresosTienda($conn, $idTienda, $fechaInicio, $fechaFin);
    $total_egresos    = getEgresosTienda($conn, $idTienda, $fechaInicio, $fechaFin);


    // Datos para gráfica por mes
    $ventaGananciaPorMesTienda = getVentaGananciaPorMesTienda($conn, $idTienda);

    // Datos para tabla prodc más relevantes
    $productosMasVendidos  = getProductosMasVendido($conn, $idTienda);

    // Datos para gráfica pie
    $categoriasMasVendidas = getCategoriasMasVendidas($conn, $idTienda);
    // echo "<pre>";
    // print_r($categoriasMasVendidas);
    // die;
    $hasActivePayment = validarPagoActivo($conn, $idTienda);
    // $categoriasMasVendidas = false;

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Estadísticas</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link rel="<stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.13.1/datatables.min.css"/>
        <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
        <link href="css/styles.css?id=28282828" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
        <style type="text/css">

        </style>
    </head>
    <body class="nav-fixed">
        <?php
            // Header
            if (file_exists('src/header.php'))
            {
              include 'src/header.php';
            }
        ?>
        <div id="layoutSidenav">
            <?php
                // Menú (sidenav)
                if (file_exists('src/sidenav.php'))
                {
                  include 'src/sidenav.php';
                }
            ?>
            <div id="layoutSidenav_content">
                <main>
                    <header class="page-header page-header-dark bg-pattern-green pb-10">
                        <div class="container-xl px-4">
                            <div class="page-header-content pt-4">
                                <div class="row align-items-center justify-content-between">
                                    <div class="col-auto mt-4">
                                        <h1 class=" display-6 sombra-titulos-vendy fw-300 text-white">
                                            <i data-feather="trending-up" class="feather-xl"></i>
                                            Estadísticas
                                        </h1>
                                        <div class="page-header-subtitle">
                                            <div class="">
                                                <span class="fw-500 text-white-75 small">
                                                    <?php
                                                        setlocale(LC_TIME, "spanish");
                                                        setlocale(LC_TIME, 'es_ES.UTF-8');
                                                        //echo strftime("%d %bk %Y", strtotime($fechaInicio)) . " <span class='text-white'>al</span> " . strftime("%d/%m/%Y", strtotime($fechaFin));
                                                        echo date("j M, Y", strtotime($fechaInicio)) . " al " . date("j M, Y", strtotime($fechaFin));
                                                    ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-xl-auto mt-4">
                                        <form class="" id="formularioFechaFiltrado" action="index.html" method="post">
                                            <div class="input-group input-group-joined shadow-sm border-0 " style="width: 21rem">
                                                <span class="input-group-text"><i class="text-primary" data-feather="calendar"></i></span>
                                                <input class="form-control ps-0 pointer" id="litepickerRangePlugin" onkeydown="if (event.keyCode === 13) { event.preventDefault(); }" placeholder="Select date range..." />
                                                <button type="button" onclick="leerFechasFiltrado();" class="btn btn-success border border-2 shadow-none border-success" name="button">
                                                    <i class="feather-lg" data-feather="search"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </header>
                    <!-- Main page content-->
                    <div class="container-xl px-4 mt-n10">


                        <div class="row">

                            <div class="col-xl-3 col-md-6 mb-4">
                                <!-- Dashboard info widget 2-->
                                <div class="card border-start-lg border-start-danger h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <div class="small fw-bold text-secondary mb-1">Vendido</div>
                                                <div class="text-lg fw-bold">$ <?php echo number_format($ventas_ganancias['total_Venta'], 2); ?></div>
                                                <div class="text-xs fw-bold text-danger d-inline-flex align-items-center"></div>
                                            </div>
                                            <div class="ms-2">
                                                <!-- <i class="fas fa-tag fa-2x text-gray-200"></i> -->
                                                <i class="feather-xl text-gray-300" data-feather="shopping-bag"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="card-footer d-flex align-items-center justify-content-between small text-dark">
                                        <a class="stretched-link" href="#!">Descargar reporte</a>
                                        <div class="">
                                            <i class="fas fa-angle-right"></i>
                                        </div>
                                    </div> -->
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6 mb-4">
                                <!-- Dashboard info widget 2-->
                                <div class="card border-start-lg border-start-blue h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <div class="small fw-bold text-secondary mb-1">Ganado</div>
                                                <div class="text-lg fw-bold">$ <?php echo  number_format($ventas_ganancias['total_Ganancia'], 2); ?></div>
                                                <div class="text-xs fw-bold text-danger d-inline-flex align-items-center">
                                                    <i class="me-1" data-feather="trending-up"></i>
                                                    <?php
                                                        $precio_de_venta_total = $ventas_ganancias['total_Venta'];
                                                        $ganancia_total = $ventas_ganancias['total_Ganancia'];

                                                        if ($precio_de_venta_total > 0 && $ganancia_total > 0)
                                                        {
                                                            $porcentaje_de_ganancia = ($ganancia_total / $precio_de_venta_total) * 100;
                                                        }
                                                        else
                                                        {
                                                            $porcentaje_de_ganancia = 0;
                                                        }
                                                        echo number_format($porcentaje_de_ganancia, 2) . "%";
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="ms-2">
                                                <!-- <i class="fas fa-tag fa-2x text-gray-200"></i> -->
                                                <i class="feather-xl text-gray-300" data-feather="dollar-sign"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="card-footer d-flex align-items-center justify-content-between small text-dark">
                                        <a class="stretched-link" href="#!">Descargar reporte</a>
                                        <div class="">
                                            <i class="fas fa-angle-right"></i>
                                        </div>
                                    </div> -->
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6 mb-4">
                                <!-- Dashboard info widget 2-->
                                <div class="card border-start-lg border-start-yellow h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <div class="small fw-bold text-secondary mb-1">Egresos</div>
                                                <div class="text-lg fw-bold">
                                                    <?php echo "$ " . number_format($total_egresos, 2); ?>
                                                </div>
                                                <div class="text-xs fw-bold text-danger d-inline-flex align-items-center"></div>
                                            </div>
                                            <div class="ms-2">
                                                <!-- <i class="fas fa-tag fa-2x text-gray-200"></i> -->
                                                <i class="feather-xl text-gray-300" data-feather="arrow-up"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="card-footer d-flex align-items-center justify-content-between small text-dark">
                                        <a class="stretched-link" href="#!">Descargar reporte</a>
                                        <div class="">
                                            <i class="fas fa-angle-right"></i>
                                        </div>
                                    </div> -->
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6 mb-4">
                                <!-- Dashboard info widget 2-->
                                <div class="card border-start-lg border-start-success h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <div class="small fw-bold text-secondary mb-1">Ingresos</div>
                                                <div class="text-lg fw-bold">
                                                    <?php echo "$ " . number_format($total_ingresos, 2); ?>
                                                </div>
                                                <div class="text-xs fw-bold text-danger d-inline-flex align-items-center">
                                                    <i class="me-1" data-feather="trending-up"></i>
                                                    <?php
                                                        if ($total_ingresos > 0)
                                                        {
                                                            $margen_de_beneficio = (($total_ingresos - $total_egresos) / $total_ingresos) * 100;
                                                        }
                                                        else
                                                        {
                                                            $margen_de_beneficio = 0;
                                                        }
                                                        echo number_format($margen_de_beneficio, 2) . "%";
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="ms-2">
                                                <!-- <i class="fas fa-tag fa-2x text-gray-200"></i> -->
                                                <i class="feather-xl text-gray-300" data-feather="arrow-down"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="card-footer d-flex align-items-center justify-content-between small text-dark">
                                        <a class="stretched-link" href="#!">Descargar reporte</a>
                                        <div class="">
                                            <i class="fas fa-angle-right"></i>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-xl-12 col-md-12 mb-2">
                                <div class="card mb-4">
                                    <div class="card-header">Datos del año en curso</div>
                                    <div class="card-body bg-pattern-white-75">
                                        <?php
                                        if (!isset($ventaGananciaPorMesTienda) || empty($ventaGananciaPorMesTienda))
                                        {
                                            ?>
                                            <div class="d-flex text-center small">
                                                Datos insuficientes para realizar el cálculo. Comparte tu tienda vendy y realiza tu primera venta.
                                            </div>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <div class="chart-area">
                                                <canvas id="myBarChart" class="" width="100%" height="30"></canvas>
                                            </div>
                                            <?php
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Example Charts for Dashboard Demo-->
                        <div class="row">
                            <div class="col-xl-6 mb-4">
                                <div class="card card-header-actions h-100">
                                    <div class="card-header">
                                        <div class="">
                                            Productos relevantes <span class="small fw-300">(Top 10)</span>
                                        </div>
                                        <!-- <div class="dropdown no-caret">
                                            <button class="btn btn-transparent-dark btn-icon dropdown-toggle" id="areaChartDropdownExample" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="text-gray-500" data-feather="more-vertical"></i></button>
                                            <div class="dropdown-menu dropdown-menu-end animated--fade-in-up" aria-labelledby="areaChartDropdownExample">
                                                <a class="dropdown-item" href="#!">Last 12 Months</a>
                                                <a class="dropdown-item" href="#!">Last 30 Days</a>
                                                <a class="dropdown-item" href="#!">Last 7 Days</a>
                                                <a class="dropdown-item" href="#!">This Month</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="#!">Custom Range</a>
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="card-body bg-pattern-white align-items-center">
                                        <?php
                                            if ($productosMasVendidos !== false)
                                            {
                                                ?>
                                                <div class="table-responsive border border-1 rounded-2 bg-white">
                                                    <table id="" class="table bg-white rounded-0 table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>Nombre</th>
                                                                <th>Total Ventas</th>
                                                            </tr>
                                                        </thead>
                                                        <tfoot>
                                                            <tr>
                                                                <th>Nombre</th>
                                                                <th>Total Ventas</th>
                                                            </tr>
                                                        </tfoot>
                                                        <tbody>
                                                            <?php
                                                                foreach ($productosMasVendidos as $index => $articulo)
                                                                {
                                                                    echo "<tr>";
                                                                    echo "<td>" . $articulo['nombre'] . "</td>";
                                                                    echo '<td><div class="badge bg-success text-white rounded-pill fs-6">';

                                                                    if ($articulo['unidadVenta'] !== 'Piezas')
                                                                    {
                                                                        echo number_format($articulo['cantidad_vendida'], 2);
                                                                    }
                                                                    else
                                                                    {
                                                                        echo $articulo['cantidad_vendida'];
                                                                    }

                                                                    echo " " . ($articulo['unidadVenta'] === 'Piezas' ? 'Pzs' : 'Kgs');
                                                                    echo "</div></td>";
                                                                    echo "</tr>";
                                                                }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <div class="d-flex text-center small">
                                                    Datos insuficientes para realizar el cálculo. Comparte tu tienda vendy y realiza tu primera venta.
                                                </div>
                                                <?php
                                            }
                                        ?>

                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 mb-4">
                                <div class="card card-header-actions h-100">
                                    <div class="card-header">
                                        <div class="">
                                            Categorías más vendidas <span class="small fw-300">(Top 5)</span>
                                        </div>
                                        <!-- <div class="dropdown no-caret">
                                            <button class="btn btn-transparent-dark btn-icon dropdown-toggle" id="areaChartDropdownExample" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="text-gray-500" data-feather="more-vertical"></i></button>
                                            <div class="dropdown-menu dropdown-menu-end animated--fade-in-up" aria-labelledby="areaChartDropdownExample">
                                                <a class="dropdown-item" href="#!">Last 12 Months</a>
                                                <a class="dropdown-item" href="#!">Last 30 Days</a>
                                                <a class="dropdown-item" href="#!">Last 7 Days</a>
                                                <a class="dropdown-item" href="#!">This Month</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="#!">Custom Range</a>
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="card-body bg-pattern-white align-items-center">
                                        <?php
                                            if ($categoriasMasVendidas !== false)
                                            {
                                                ?>
                                                <div class="chart-area">
                                                    <canvas id="myPieChart" class="" width="100%" height="30"></canvas>
                                                </div>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <div class="d-flex text-center small">
                                                    Datos insuficientes para realizar el cálculo. Comparte tu tienda vendy y realiza tu primera venta.
                                                </div>
                                                <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Example DataTable for Dashboard Demo-->
                        <!-- <div class="card mb-4">
                            <div class="card-header">Personnel Management</div>
                            <div class="card-body">
                                saxe
                            </div>
                        </div> -->
                    </div>

                </main>
                <?php
                    // Header
                    if (file_exists('src/footer.php'))
                    {
                        include 'src/footer.php';
                    }
                ?>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.2.1/chart.umd.js" integrity="sha512-vCUbejtS+HcWYtDHRF2T5B0BKwVG/CLeuew5uT2AiX4SJ2Wff52+kfgONvtdATqkqQMC9Ye5K+Td0OTaz+P7cw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.2.1/chart.min.js" integrity="sha512-v3ygConQmvH0QehvQa6gSvTE2VdBZ6wkLOlmK7Mcy2mZ0ZF9saNbbk19QeaoTHdWIEiTlWmrwAL4hS8ElnGFbA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
        <!-- <script src="assets/demo/chart-bar-demo.js"></script> -->
        <script src="assets/demo/chart-pie-demo.js?id=28"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables/datatables-simple-demo.js?id=28"></script>

        <script type="text/javascript">
            // Obtener los datos de ventas y ganancias desde PHP
            <?php
                // Ganancias y ventas
                $meses = array(1 => "Ene", 2 => "Feb", 3 => "Mar", 4 => "Abr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Ago", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dic");
                $gananciasPHP = Array();
                $ventasPHP = Array();
                $mesesPHP = Array();

                foreach ($ventaGananciaPorMesTienda as $ganancia)
                {
                    $gananciasPHP[] = $ganancia['total_Ganancia'];
                    $ventasPHP[]    = $ganancia['total_Venta'];
                    $mesesPHP[]     = $meses[$ganancia['mes']];
                }
            ?>
            console.log('<?php echo json_encode($mesesPHP); ?>');
            // Definir los meses
            var meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

            // Configuración de la gráfica de barras
            var config = {
              type: 'bar',
              data: {
                  labels: <?php echo json_encode($mesesPHP); ?>,
                  datasets: [{
                    label: 'Ventas',
                    backgroundColor: 'rgba(255, 0, 0, 0.5)',
                    borderColor: 'rgba(255, 0, 0, 1)',
                    borderWidth: 2,
                    data: <?php echo json_encode($ventasPHP); ?>
                  },
                  {
                      label: 'Ganancias',
                      backgroundColor: 'rgba(96, 75, 245, 0.7)',
                      borderColor: 'rgba(92, 72, 238, 1)',
                      borderWidth: 2,
                      data: <?php echo json_encode($gananciasPHP); ?>
                  }]
              },
              options: {
                  maintainAspectRatio: false,
                  responsive: true,
                  title: {
                      display: true,
                      text: 'Ventas y Ganancias del año'
                },
                scales: {
                }
              }
            };

            // Crear la gráfica de barras
            var ctx = document.getElementById('myBarChart').getContext('2d');
            var myBarChart = new Chart(ctx, config);

            // Creo gráfica de pie
            <?php

                $nombreCategoria = Array();
                $totalVentas = Array();

                if ($categoriasMasVendidas !== false)
                {
                    // $categoriasMasVendidas = array_unique($categoriasMasVendidas);
                    foreach ($categoriasMasVendidas as $key => $categoria)
                    {
                        $nombreCategoria[] = ucfirst($categoria['nombreCategoria']);

                        if ( $categoria['unidadVenta'] == "Piezas")
                        {
                            $totalVentas[] = $categoria['cantidad_vendida'];
                        }
                        else
                        {
                            $totalVentas[] = number_format($categoria['cantidad_vendida'], 2);
                        }
                    }
                }

                // $nombreCategoria = array_unique($nombreCategoria);
                // $totalVentas = array_unique($totalVentas);

                $originalColors = array(
                    'rgba(0, 97, 242, 1)',
                    'rgba(82, 186, 80, 1)',
                    'rgba(255, 187, 0, 1)',
                    'rgba(255, 0, 0, 1)',
                    'rgba(255, 0, 255, 1)'
                );

                $hoverColors = array(
                    'rgba(0, 77, 192, 1)',
                    'rgba(72, 162, 68, 1)',
                    'rgba(220, 140, 0, 1)',
                    'rgba(220, 0, 0, 1)',
                    'rgba(220, 0, 220, 1)'
                );
            ?>

            // Pie Chart Example
            var ctx = document.getElementById('myPieChart');
            // var ctx = document.getElementById("myPieChart");
            var myPieChart = new Chart(ctx, {
                type: "doughnut",
                data: {
                    labels: <?php echo json_encode($nombreCategoria); ?>,
                    datasets: [{
                        label: 'Vendido',
                        data: <?php echo json_encode($totalVentas); ?>,
                        backgroundColor: <?php echo json_encode($originalColors); ?>,
                        hoverBackgroundColor: <?php echo json_encode($hoverColors); ?>,
                        hoverBorderColor: "rgba(234, 236, 244, 1)"
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        borderColor: "#dddfeb",
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        caretPadding: 10
                    },
                    legend: {
                        display: true
                    },
                    cutoutPercentage: 80
                }
            });
            // Cierro gráfica de pie
        </script>
        <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
        <script src="js/litepicker.js?id=2828"></script>
        <script type="text/javascript">

            function convertirFecha(cadenaFecha)
            {
                const partes = cadenaFecha.split(" ");
                const dia = parseInt(partes[0], 10);
                const mes = obtenerNumeroMes(partes[1]);
                const anio = parseInt(partes[2], 10);
                return new Date(anio, mes, dia);
            }

            function obtenerNumeroMes(mesAbreviado)
            {
                const meses = ["ene", "feb", "mar", "abr", "may", "jun", "jul", "ago", "sep", "oct", "nov", "dic"];
                return meses.indexOf(mesAbreviado.toLowerCase());
            }

            function leerFechasFiltrado()
            {
                // Obtener el rango de fechas en formato "01 ene, 2023 - 08 ene, 2023"
                const fechaOriginal = document.getElementById('litepickerRangePlugin').value;
                const fechasSeparadas = fechaOriginal.split(" - ");

                // console.log(fechasSeparadas);

                const fechaInicio = convertirFecha(fechasSeparadas[0]);
                const fechaFin    = convertirFecha(fechasSeparadas[1]);

                const meses = ['ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic'];

                const fechaInicioFormateada = `${(fechaInicio.getFullYear() +1)}-${("0" + (meses.indexOf(fechasSeparadas[0].substr(3, 3)) + 1)).slice(-2)}-${("0" + fechaInicio.getDate()).slice(-2)}`;
                const fechaFinFormateada = `${(fechaFin.getFullYear() +1)}-${("0" + (meses.indexOf(fechasSeparadas[1].substr(3, 3)) + 1)).slice(-2)}-${("0" + fechaFin.getDate()).slice(-2)}`;
                // console.log('fechaInicio: ' + fechaInicioFormateada);
                // console.log('fechaFin: ' + fechaFinFormateada);
                location.href = 'estadisticas.php?rangoFecha=' + fechaInicioFormateada + ';' + fechaFinFormateada;
            }

            function actualizarLitePicker(fecha)
            {
                //console.log(fecha);
                document.getElementById('litepickerRangePlugin').value = fecha;
            }

        </script>
        <?php

        if (isset($_GET['rangoFecha']))
        {
            ?>
            <script type="text/javascript">

                <?php
                    setlocale(LC_TIME, "es_ES");
                    $meses = array(
                        "Enero"   => "ene",
                        "Febrero" => "feb",
                        "Marzo"   => "mar",
                        "Abril"   => "abr",
                        "Mayo"    => "may",
                        "Junio"   => "jun",
                        "Julio"   => "jul",
                        "Agosto"  => "ago",
                        "Septiembre" => "sep",
                        "Octubre"    => "oct",
                        "Noviembre"  => "nov",
                        "Diciembre"  => "dic"
                    );
                    // $fechaInicio = date("d", strtotime($fechaInicio)) . " " . $meses[4] . ", " . date("Y", strtotime($fechaInicio));

                    //echo $fechaInicio . $fechaFin;
                    $mesfechaInicio = strftime("%B", strtotime($fechaInicio));
                    $mesfechaFin    = strftime("%B", strtotime($fechaFin));

                    // Construyo fecha con formato para litepicker
                    $fechaLitepicker =
                        strftime("%d", strtotime($fechaInicio))
                        . " "
                        . $meses[ucfirst($mesfechaInicio)]
                        . ", "
                        . strftime("%Y", strtotime($fechaInicio))
                        . " - "
                        . strftime("%d", strtotime($fechaFin))
                        . " "
                        . $meses[ucfirst($mesfechaFin)]
                        . ", "
                        . strftime("%Y", strtotime($fechaFin));

                    $fechaLitepicker = strtolower($fechaLitepicker);
                ?>

                setTimeout(function ()
                {
                    actualizarLitePicker('<?php echo $fechaLitepicker; ?>');
                }, 500);

                // console.log('<?php echo $fechaLitepicker; ?>');
            </script>
            <?php
        }
        ?>
    </body>
</html>
