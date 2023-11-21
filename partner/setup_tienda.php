<?php
    session_start();
    require '../app/php/conexion.php'; //configuración conexión db
    require 'php/funciones.php'; //configuración conexión db

    if (isset($_SESSION['email'], $_SESSION['nombre']))
    {
        $emailUsuario  = $_SESSION['email'];
        $nombreUsuario = $_SESSION['nombre'];
    }

    if (isset($_SESSION['managedStore']))
    {
        $idTienda = $_SESSION['managedStore'];
        header('Location: dashboard.php?msg=tiendaExistente');
    }


    // $managedStore = $_SESSION['managedStore'];
    // $tienda = getDatosTienda($conn, $managedStore);
    // $idTienda = $tienda['idTienda'];

    // echo "<pre>";
    // print_r($_SESSION);
    // die;
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title></title>
        <link href="css/styles.css?id=288" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <style type="text/css">

            input 
            {
                border: 0;
                outline: 0;
                width: 100%;
            }
            
            input:focus
            {
                outline: none !important;
            }

            .input_border_bottom
            {
                border: 0;
                outline: 0;
                background: transparent;
                border-bottom: 3px solid #00ac69;
            }

            .input-box 
            {
                display: flex;
                align-items: center;
                max-width: 100%;

                background: #fff;
                border: 1px solid #a0a0a0;
                border-radius: 4px;                
                overflow: hidden;
                font-family: sans-serif;
            }

            .input-box .prefix 
            { 
                font-family: 'poppins';
            }

            .input-box input 
            {
                flex-grow: 1; 
                background: #fff;
                border: none;
                outline: none;
                padding: 0.5rem;
                font-family: 'poppins';
            }

            .input-box:focus-within 
            {
                border-color: #777;
            }

        </style>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container-xl px-4">
                        <div class="row justify-content-center">
                            <div class="col-xl-5 col-lg-6 col-md-8 col-sm-11">
                                <!-- Social forgot password form-->
                                <div class="card mt-5">
                                    <div class="card-body p-5 text-center">
                                        <div class="h3 fw-light mb-0">
                                            ¡Hola, <?php echo ucwords(strtolower($nombreUsuario)); ?>! &#x1F44B;
                                        </div>
                                    </div>
                                    <hr class="my-0" />
                                    <div class="card-body p-5">
                                        <div class="text-center text-gray-600 mb-4 fw-500 fs-2">
                                            Vamos a configurar tu tienda 
                                            <span class="logo text-yellow fw-600 display-6 text-nowrap">Conejón Digital</span>
                                            <!-- <i class="fas fa-store fa-sm"></i> --> 
                                        </div>
                                        <div class="mb-3 text-center">
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#modalSetupTiendaWizard" class="btn btn-primary w-100 fs-2 fw-500 fa-beat mb-2" style="--fa-animation-duration: 3s; --fa-beat-scale: 1.1;" name="button">
                                                Comenzar
                                                <i class="far fa-hand-point-right fa-lg ms-2"></i>
                                                <!-- <i class="fas fa-arrow-right ms-2"></i> -->
                                            </button>
                                            <a href="dashboard.php">En otro momento</a>

                                            <!-- Modal -->
                                            <div class="modal fade" id="modalSetupTiendaWizard" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalSetupTiendaWizardLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <form id="formSetupTienda" class="" action="procesa.php" method="post">

                                                            <div class="modal-header">
                                                                <h5 class="modal-title text-gray-600 fw-300">
                                                                    Configura tu cuenta
                                                                </h5>
                                                                <button type="button" class="btn btn-icon btn-outline-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">
                                                                    <i class="fa-solid fa-xmark fa-xl"></i>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">

                                                                <div class="mb-4 px-3 text-center">
                                                                    <label class="fs-6 mb-1 small text-primary text-center mb-2 fw-300">Nombre de tu tienda:</label>
                                                                    <input type="text" id="inputNombreTienda" style="border-bottom: 3px solid red;" class="text-center rounded-0 fs-4 input-nombre-tienda shadow-none" name="nombreTienda" placeholder='Mi Tienda' autocomplete="off" required>
                                                                </div>                                                                
                                                                
                                                                <div class="mb-3 px-0 text-center">
                                                                    <div class="container">
                                                                        <div class="row justify-content-center m-0">
                                                                            <div class="col-12 col-md-12 col-lg-8 col-xl-8 col-xxl-8">
                                                                                <label class="fs-6 mb-1 small text-primary text-center mb-0 fw-300">Enlace personaliado:</label>
                                                                                <div class="input-box rounded-pill border-2 m-1" style="overflow: hidden;">
                                                                                    <span class="prefix text-gray-600 fw-500 ps-4 pe-0 fs-2">                                                                                    
                                                                                        conejondigital.com/
                                                                                    </span>
                                                                                    <input type="text" id="idTienda" class="form-control text-green form-control-lg shadow-none bg-white fs-1 is-invalid" name="idTienda" placeholder="mitienda" style="white-space: nowrap;" autocomplete="off" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>   
                                                                

                                                                <div id="outputIdTiendaExistente" class="mb-2 p-1 text-danger small" style="display: none;">No está disponible, intenta con otra opción.</div>
                                                                <div id="reglasUsername" class="mb-2 px-3" style="">
                                                                    <div class="text-start small">
                                                                        <p class="fw-600 text-danger">Debe cumplir con:</p>
                                                                        <ul class="text-start small">
                                                                            <li>Mínimo 6 y máximo 28 caractéres</li>
                                                                            <li>Sólo puede contener letras, números, puntos y guión bajo</li>
                                                                            <li>Debe ser único</li>
                                                                        </ul>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="modal-footer text-end">
                                                                <button type="submit" class="btn btn-success w-100 rounded-2" name="btnSetupTienda" onclick="return validarFormulario();">Finalizar</button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- <form>
                                            <div class="mb-3">
                                                <label class="text-gray-600 small" for="emailExample">Email address</label>
                                                <input class="form-control form-control-solid" type="text" placeholder="" aria-label="Email Address" aria-describedby="emailExample" />
                                            </div>
                                            <a class="btn btn-primary" href="auth-login-social.html">Reset Password</a>
                                        </form> -->
                                    </div>
                                    <hr class="my-0" />
                                    <div class="card-body px-5 py-4">
                                        <div class="text-center">
                                            <a class="text-primary" href="https://api.whatsapp.com/send?phone=5215610346590&text=Hola,%20requiero%20soporte%20con%20mi%20tienda%20vendy.%20Email:%20<?php echo $_SESSION['email']; ?>" target="_blank">
                                                <div class="nav-link-icon">
                                                    <i class="fas fa-headset"></i>
                                                </div>
                                                Soporte<span class="fw-600">Vendy</span>
                                            </a>
                                            <p style="font-size: 0.7rem;" class="text-gray-600 fw-200">24/7 los 365 días del año</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <?php
                    if (file_exists('src/modals.php'))
                    {
                        include 'src/modals.php';
                    }
                ?>
            </div>
        </div>
        <script type="text/javascript">

            const inputNombreTienda = document.getElementById('inputNombreTienda');
            const idTienda = document.getElementById('idTienda');

            // Expresión regular que acepta letras y números, y convierte todo a minúsculas
            const regex = /^[a-z0-9]+$/;

            inputNombreTienda.addEventListener('input', () =>
            {
              // Obtener el valor del campo inputNombreTienda
              let value = inputNombreTienda.value;

              // Limitar la cantidad de caracteres a 50
              if (value.length > 50)
              {
                  value = value.substring(0, 50);
                  inputNombreTienda.value = value;
              }

              // Limpiar el valor para que sólo contenga letras, números y espacios en blanco
              const newValue = value.replace(/[^a-z0-9\s]/gi, '');
              inputNombreTienda.value = newValue;

              // Aplicar la expresión regular y verificar si el valor cumple con las características
              if (regex.test(newValue))
              {
                  // Si el valor cumple con las características, asignar el valor al campo idTienda en minúsculas
                  let newIdValue = newValue.substring(0, 28).toLowerCase();
                  // Limitar la cantidad de caracteres a 28
                  if (newIdValue.length > 28)
                  {
                      newIdValue = newIdValue.substring(0, 28);
                  }
                  idTienda.value = newIdValue;
              }
              else
              {
                  // Si el valor no cumple con las características, eliminar cualquier caracter que no sea letra o número
                  const newCleanValue = newValue.replace(/[^a-z0-9]/gi, '').toLowerCase();
                  let newIdValue = newCleanValue.substring(0, 28);
                  // Limitar la cantidad de caracteres a 28
                  if (newIdValue.length > 28)
                  {
                      newIdValue = newIdValue.substring(0, 28);
                  }
                  idTienda.value = newIdValue;
              }
            });

            idTienda.addEventListener('input', () =>
            {
                const value = idTienda.value.trim().toLowerCase();
                const regex = /^(?!.*\.\.)(?!.*\.$)[^\W][\w.]{5,27}$/;

                if (regex.test(value))
                {
                    // Si el valor cumple con las características, asignar el valor al campo idTienda en minúsculas
                    idTienda.value = value;

                    // Hacer la solicitud AJAX
                    $.ajax({
                        type: "POST",
                        url: "php/ajax/validateIdTienda.php",
                        data: { idTienda: value },
                        success: function(data)
                        {
                            //console.log('axel');
                            const response = JSON.parse(data);
                            const status = response.status;
                            const message = response.message;

                            if (response.status)
                            {
                                idTienda.classList.remove('text-dark');
                                idTienda.classList.add('text-danger');

                                idTienda.classList.remove('fw-300');
                                idTienda.classList.add('fw-600');

                                idTienda.classList.remove('is-valid');
                                idTienda.classList.add('is-invalid');

                                document.getElementById('outputIdTiendaExistente').style.display = "block";
                                document.getElementById('reglasUsername').style.display = "block";
                            }
                            else
                            {
                                idTienda.classList.remove('text-danger');
                                idTienda.classList.add('text-dark');

                                idTienda.classList.remove('fw-600');
                                idTienda.classList.add('fw-300');

                                idTienda.classList.remove('is-invalid');
                                idTienda.classList.add('is-valid');

                                document.getElementById('outputIdTiendaExistente').style.display = "none";
                                document.getElementById('reglasUsername').style.display = "none";
                            }
                        },
                        error: function(xhr, status, error)
                        {
                            console.error(xhr);
                        }
                      });
                      document.getElementById('reglasUsername').style.display = "none";
                  }
                  else
                  {
                      // Si el valor no cumple con las características, eliminar cualquier caracter que no sea letra o número
                      idTienda.classList.remove('text-dark');
                      idTienda.classList.add('text-danger');

                      idTienda.classList.remove('fw-300');
                      idTienda.classList.add('fw-600');

                      idTienda.classList.remove('is-valid');
                      idTienda.classList.add('is-invalid');
                      document.getElementById('reglasUsername').style.display = "block";
                  }
            });

            function validarFormulario()
            {
                const nombreTienda = document.getElementById('inputNombreTienda');

                console.log(nombreTienda.value.length);
                if ( nombreTienda.value.length == 0)
                {
                    console.log('=> '+nombreTienda.value.length);

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ingresa el nombre de tu tienda'
                    });
                    return false;
                }

                if (nombreTienda.value !== "" && nombreTienda.value.length > 4)
                {
                    nombreTienda.classList.remove('is-invalid');
                }
                else
                {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'El nombre de tu tienda debe tener al menos 5 letras.' + nombreTienda.value.length
                    });
                    nombreTienda.classList.add('is-invalid');
                    return false;
                }

                const idTienda = document.getElementById('idTienda');
                if (idTienda.value !== "")
                {
                    const value = idTienda.value.trim().toLowerCase();
                    const regex = /^(?!.*\.\.)(?!.*\.$)[^\W][\w.]{5,27}$/;
                    if (regex.test(value))
                    {
                        return true;
                    }
                    else
                    {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'El enlace parece no cumplir el formato solicitado.'
                        });
                        idTienda.classList.add('is-invalid');
                        return false;
                    }
                }
                else
                {
                    console.log('idTienda vacio');
                    idTienda.classList.add('is-invalid');
                    return false;
                }
            }

            // Obtener el formulario y los campos de entrada
            const form = document.getElementById('formSetupTienda');
            const inputFields = form.querySelectorAll('input[type="text"]');

            // Agregar un evento keydown a cada campo de entrada
            inputFields.forEach(input =>
            {
                input.addEventListener('keydown', e =>
                {
                    if (e.keyCode === 13)
                    {
                        e.preventDefault();
                        validarFormulario();
                    }
                });
            });


        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
