<?php

    if (isset($_GET['msg']) && !empty(($_GET['msg'])))
    {
        $msg = $_GET['msg'];

        if (isset($_GET['error']))
        {
            $error = $_GET['error'];
        }

        switch ($msg)
        {
                case 'requiereAbrirTurnoCaja':
                    if (isset($hasActivePayment['existePagoActivo']) && $hasActivePayment['existePagoActivo'] == true)
                    {
                        if (isset($_SESSION['idSucursalVenta'], $_SESSION['nombreSucursalVenta']))
                        {
                        ?>
                        <script type="text/javascript">
                            var cargaCompleta = new bootstrap.Modal(document.getElementById("modalIniciarTurnoCaja"), {});
                            document.onreadystatechange = function ()
                            {
                                cargaCompleta.show();
                            };
                        </script>
                        <?php
                        }
                        else
                        {
                            ?>
                            <script type="text/javascript">
                                var cargaCompleta = new bootstrap.Modal(document.getElementById("modalSeleccionarSucursal"), {});
                                document.onreadystatechange = function ()
                                {
                                    cargaCompleta.show();
                                };
                            </script>
                            <?php
                        }
                    }
                    else
                    {
                        ?>
                        <script type="text/javascript">
                            var modalSeccionDePago = new bootstrap.Modal(document.getElementById("modalSeccionDePago"), {});
                            document.onreadystatechange = function ()
                            {
                                modalSeccionDePago.show();
                            };
                        </script>
                        <?php
                    }
                break;

                case 'exitoRegistroGafete':
                ?>
                <script type="text/javascript">
                    var exitoRegistroGafete = new bootstrap.Modal(document.getElementById("modalFullscreen"), {});
                    document.onreadystatechange = function ()
                    {
                        exitoRegistroGafete.show();
                    };
                </script>
                <?php
                break;

            case 'formatoNoPermitido':
            ?>
            <script type="text/javascript">
                var formatoNoPermitido = new bootstrap.Modal(document.getElementById("formatoNoPermitido"), {});
                document.onreadystatechange = function ()
                {
                    formatoNoPermitido.show();
                };
            </script>
            <?php
            break;
            

            case 'aperturaTurnoCajaExitoso':
                $montoAbonado = number_format($_GET['montoAbonado'], 2);
                echo "<script>
                        Swal.fire({
                            title: '¡Listo!',
                            text: 'Turno aperturado con $ $montoAbonado en caja',
                            icon: 'success',
                            showConfirmButton: true,
                            confirmButtonText: 'Entendido',
                            timer: 5000  // Tiempo en milisegundos antes de cerrar automáticamente
                        });
                     </script>";
                break;

            case 'errorAperturaTurno':                
                echo "<script>
                        Swal.fire({
                            title: 'Error',
                            text: 'Ocurrió un error al aperturar el turno, intenta nuevamente',
                            icon: 'error',
                            showConfirmButton: true,
                            confirmButtonText: 'Entendido'                            
                        });
                        </script>";
                break;
            
            case 'turnoCajaCerradoCajaAjustada':
                echo "<script>
                        Swal.fire({
                            title: 'Listo',
                            text: 'Turno cerrado correctamente. Se realizó el ajuste de caja correctamente',
                            icon: 'success',
                            showConfirmButton: true,
                            confirmButtonText: 'Entendido'                            
                        });
                        </script>";
                break;
            
            case 'turnoCajaCerradoCorrectamente':
                echo "<script>
                        Swal.fire({
                            title: 'Listo',
                            text: 'Turno cerrado correctamente',
                            icon: 'success',
                            showConfirmButton: true,
                            confirmButtonText: 'Entendido'                            
                        });
                        </script>";
                break;

            case 'cargaCompleta':
                echo "<script>
                        Swal.fire({
                            title: 'Listo!',
                            text: 'Guardado exitosamente',
                            icon: 'success',
                            showConfirmButton: true,
                            confirmButtonText: 'Entendido',
                            timer: 3000  // Tiempo en milisegundos antes de cerrar automáticamente
                        });
                     </script>";
                break;
            

            case 'cargaCompletaBak2':
            ?>
            <script type="text/javascript">
                var cargaCompleta = new bootstrap.Modal(document.getElementById("cargaCompleta"), {});
                document.onreadystatechange = function ()
                {
                    cargaCompleta.show();
                };
            </script>
            <?php
            break;

            case 'errorCarga':
            ?>
            <script type="text/javascript">
                var errorCarga = new bootstrap.Modal(document.getElementById("errorCarga"), {});
                document.onreadystatechange = function ()
                {
                    errorCarga.show();
                };
            </script>
            <?php
            break;

            case 'direccionFaltante':
                ?>
                <script type="text/javascript">
                    var direccionFaltante = new bootstrap.Modal(document.getElementById("modalDireccionFaltante"), {});
                    document.onreadystatechange = function ()
                    {
                        direccionFaltante.show();
                    };
                </script>
                <?php
            break;

            case 'pedidoPDVRealizado':
                ?>
                <script type="text/javascript">
                    var direccionFaltante = new bootstrap.Modal(document.getElementById("modalPedidoPDVRealizado"), {});
                    document.onreadystatechange = function ()
                    {
                        direccionFaltante.show();
                    };
                </script>
                <?php
            break;

            case 'categoriaActualizada':
                if (isset($_GET['categoria']))
                {
                    $cat = $_GET['categoria'];
                }
                echo "<script>
                        Swal.fire({
                            title: '¡Éxito!',
                            text: 'La categoría " . $cat ." se ha actualizado correctamente.',
                            icon: 'success',
                            showConfirmButton: true,
                            confirmButtonText: 'Aceptar',
                        });
                    </script>";
                break;

            case 'errorActualizarCategoria':
                if (isset($_GET['categoria']))
                {
                    $cat = $_GET['categoria'];
                }
                echo "<script>
                        Swal.fire({
                            title: 'Error',
                            text: 'Ha ocurrido un error al actualizar la categoría " . $cat .".',
                            icon: 'error',
                            showConfirmButton: true,
                            confirmButtonText: 'Aceptar',
                        });
                    </script>";
                break;

            case 'categoriaEliminada':
                echo "<script>
                        Swal.fire({
                            title: '¡Éxito!',
                            text: 'La categoría se ha eliminado correctamente.',
                            icon: 'success',
                            showConfirmButton: true,
                            confirmButtonText: 'Entendido',
                        });
                    </script>";
                break;

            case 'errorEliminarCategoria':
                echo "<script>
                        Swal.fire({
                            title: 'Error',
                            text: 'Ha ocurrido un error al intentar eliminar esa categoría.',
                            icon: 'error',
                            showConfirmButton: true,
                            confirmButtonText: 'Entendido',
                        });
                    </script>";
                break;
                
                case 'exitoNotificacionPago':
                    echo "<script>
                            Swal.fire({
                                title: 'Exito',
                                text: 'Usuario notificado correctamente',
                                icon: 'success',
                                showConfirmButton: true,
                                confirmButtonText: 'Entendido',
                            });
                        </script>";
                break;
                
                case 'errorNotificacionPago':
                    echo "<script>
                            Swal.fire({
                                title: 'Error',
                                text: 'Ocurrió un error al notificar al usuario, inténtalo nuevamente.',
                                icon: 'error',
                                showConfirmButton: true,
                                confirmButtonText: 'Entendido',
                            });
                        </script>";
                break;

                case 'altaExitosa':
                echo "<script>
                        Swal.fire({
                            title: '¡Listo!',
                            html: 'Producto registrado correctamente.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: true,
                            confirmButtonText: 'Entendido',
                            customClass: {
                            content: 'my-swal-font'
                            }
                        });
                        </script>";
                break;
        }
    }

?>
