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

        case 'expositorRegistrado':
            echo "<script>
                    Swal.fire({
                        title: '¡Listo!',
                        text: 'El expositor se ha registrado correctamente, realizaremos la validación de tus datos y te enviaremos un email.',
                        icon: 'success',
                        showConfirmButton: true,
                        confirmButtonText: 'Entendido',
                    });
                </script>";
        break;

        case 'expositorNoRegistrado':
            echo "<script>
                    Swal.fire({
                        title: 'Error',
                        text: 'Ocurrió un error al registrar al expositor, intenta registrarte nuevamente.',
                        icon: 'error',
                        showConfirmButton: true,
                        confirmButtonText: 'Entendido',
                    });
                </script>";
        break;
        
        case 'expositorYaRegistrado':
            echo "<script>
                    Swal.fire({
                        title: 'Error',
                        text: 'Ocurrió un error, el correo ya se encuentra registrado.',
                        icon: 'error',
                        showConfirmButton: true,
                        confirmButtonText: 'Entendido',
                    });
                </script>";
        break;

        case 'cargaCompletaBak2':
            ?>
            <script type="text/javascript">
                var cargaCompleta = new bootstrap.Modal(document.getElementById("sss"), {});
                document.onreadystatechange = function ()
                {
                    cargaCompleta.show();
                };
            </script>
            <?php
            break;

        case 'openModalRegistroExpositor':
            ?>
            <script type="text/javascript">
                
                var myModal = new bootstrap.Modal(document.getElementById("modalRegistroExpositor"), {});
                document.onreadystatechange = function () 
                {
                    myModal.show();
                };

                
            </script>
            <?php
            break;
        
    }
}
?>
