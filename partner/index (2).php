<?php
		// login
		session_start();

		require 'php/conexion_db.php'; //configuración conexión db
		require 'php/funciones.php'; //configuración conexión db

		// verifico si el usuario tiene creada la sesion previamente y si está verificado y activo
		if(isset($_SESSION['email']) && isset($_SESSION['isVerified']) && isset($_SESSION['isActive']))
		{
				//if ($_SESSION['isVerified'] == 1 && $_SESSION['isActive'] == 1)
				if ($_SESSION['isActive'] == 1)
				{
						exit(header('Location: dashboard.php'));
				}
		}

		if (isset($_GET['msg']))
		{
			$msg = limpiarDato($_GET['msg']);
		}

		if (isset($_GET['email']))
		{
			$email = limpiarDato($_GET['email']);
		}

?>
<!DOCTYPE html>
<html lang="es">
		<head>
				<meta charset="utf-8" />
				<meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
				<meta name="description" content="" />
				<meta name="author" content="" />
				<title>Inicia sesión</title>
				<link href="../css/styles.css?id=28" rel="stylesheet" />
			  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
				<link rel="icon" type="image/x-icon" href="../assets/img/favicon.png" />
				<script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
				<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
		</head>
		<body class="bg-primary">
				<div id="layoutAuthentication">
					<div id="layoutAuthentication_content">
						<main>
							<div class="container-xl px-4">
								<div class="row justify-content-center">
									<div class="col-xl-5 col-lg-6 col-md-8 col-sm-11">
										<!-- Social login form-->
										<div class="card mt-5 bg-blue">
											<div class="p-1 m-3 rounded-2 text-center">
													<a href="../" class="text-primary text-decoration-none bebas">
														<i class="fas fa-store text-yellow fs-2"></i>
														<div class="font-poppins display-5 text-center text-yellow fw-500" style="text-shadow: 2px 2px 0px rgba(158, 138, 134, 0.669);">
															Vendy
														</div>
													</a>
													<small class="fw-300 text-white">La solución perfecta para tu negocio</small>
													<!-- <small>La app que todos los emprendedores México para validar tu identidad en línea y vender SIN LÍMITES</small> -->
											</div>
											<hr class="my-0" />
											<div class="card-body mt-2 pb-1 px-4">
												<!-- Login form-->
												<div class="fw-200 display-6 mb-3 text-white">Inicia sesión</div>
												<form action="procesa.php" method="POST">

													<div class="mb-3">
														<label for="email" class="text-white fw-300">Correo electrónico:</label>
														<input type="email" class="form-control form-control-solid text-center" placeholder="Ingrese el email" value="<?php echo (!empty($email)) ? $email : ''; ?>" id="email" name="form_email" required>
													</div>

													<div class="mb-3">
														<label for="password" class="text-white fw-300">Contraseña:</label>
														<input type="password" class="form-control form-control-solid text-center" placeholder="Ingrese la clave" id="password" name="form_password" required>																					
													</div>

													<div class="mb-3">
															<!-- <div class="form-check">
																	<input class="form-check-input" id="checkRememberPassword" type="checkbox" value="" />
																	<label class="form-check-label" for="checkRememberPassword">Remember password</label>
															</div> -->
															<?php
																if (isset($_GET['redirect']) && isset($_GET['tienda']))
																{
																		$redirect = $_GET['redirect'];
																		$vendedor = $_GET['tienda'];
																		?>
																		<input type="hidden" name="redirect" value="<?php echo $redirect; ?>">
																		<input type="hidden" name="vendedor" value="<?php echo $vendedor; ?>">
																		<?php
																}
															?>		
															<div class="text-end">
																
															<?php
																if (isset($_GET['errorCredencialesInvalidas']) && isset($_GET['email']))
																{
																		$redirect = $_GET['errorCredencialesInvalidas'];
																		$email = $_GET['email'];
																		?>
																		<button class="btn btn-danger mb-2" type="button">
																			Recuperar contraseña
																		</button>
																		<?php
																}
															?>	

															
															

															<button type="submit" class="btn btn-yellow mb-2" name="btnIngresar">Entrar</button>
															</div>
															
															

													</div>
												</form>																			
												<?php
													//en caso de exito mostrar mensaje exitoso
													if(isset($msg))
													{
														switch ($msg)
														{
															case 'errorCuentaInactiva':
																echo '
																<div class="mb-0">
																<hr>
																	<label class="small text-danger fw-500">Cuenta inactiva</label>
																	<br>
																	<form action="procesa.php" method="post" class="">
																		<input type="hidden" name="email" value="' . $email . '">
																			<button type="submit" class="btn btn-outline-primary btn-sm" name="btnEnvioActivacion"><i class="fas fa-paper-plane"></i> &nbsp; Reenviar correo de activación</button>
																	</form>
																</div>
																';
																break;

															case 'errorCredencialesInvalidas':
																echo '
																<div class="text-center fs-4 mb-2">
																	<label class="small text-yellow fw-500">Credenciales inválidas</label>	
																	<button class="btn btn-danger mb-2" type="button">
																			Recuperar contraseña
																	</button>
																</div>
																
																';
																break;

															case 'errorCredencialesInvalidasNulo':
																echo '
																<div class="text-center fs-4 mb-2">
																	<label class="small text-danger fw-500">Credenciales inválidas</label>																	
																</div>
																';
																break;																

															default:
																// code...
																break;
														}
													}
												?> 
											</div>
											
											<hr class="my-0" />
											<div class="px-5 pt-4">
												<p class="text-center text-white">
													¿No tienes cuenta?
													<a href="../#registro" class="text-white">Registrarme <i class="fas fa-user-plus"></i></a>
												</p>
											</p>
										</div>
									</div>
								</div>
							</div>
						</main>
					</div>
					<div id="layoutAuthentication_footer">
						<footer class="footer mt-auto text-white" class="mb-3">
							<div class="container-xl px-4">
								<div class="row">
									<!-- Le pongo el año en php para que no tengamos que editarlo cada año que pase, ya que serán muchísimos -->
									<div class="col-md-6 small">Copyright &copy; VENDY 2021 - <?php echo date("Y"); ?></div>
									<div class="col-md-6 text-md-end small">
										<a href="#!"></a>
										<a href="#!">Terminos y Condiciones</a>
									</div>
								</div>
							</div>
						</footer>
					</div>
				</div>

				<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
				<script src="../js/scripts.js"></script>
				<?php require 'src/modals.php'; ?>

		</body>
</html>
<?php

	if (isset($_GET['msg']))
	{

			$msg = $_GET['msg'];

			if ($msg == "registradoCorrectamente")
			{
				?>
				<script type="text/javascript">

					var myModal = new bootstrap.Modal(document.getElementById('registradoCorrectamente'), {
						keyboard: false
					})

					myModal.show();

				</script>
				<?php
			}

			if ($msg == "errorCredencialesInvalidasNulo")
			{
				?>
				<script type="text/javascript">
					//alert("Credenciales Invalidas. Intenta nuevamente.");
				</script>
				<?php
			}

			if ($msg == "errorFormatoPass")
			{
				?>
				<script type="text/javascript">
					alert("Las contraseñas no coinciden.");
					history.back();
				</script>
				<?php
			}

			if ($msg == "cuentaExistente")
			{
				?>
				<script type="text/javascript">
					alert("Ya existe una cuenta con el correo indicado, inicia sesión para continuar.");					
				</script>
				<?php
			}

	}

?>
