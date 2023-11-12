<?php

function correo($idPedido, $fechaPedido, $reqEnvio, $direccionPedido, $subtotal, $descuento, $total, $getDatosContactoVendedor, $datosBancariosCorreo)
{

	$data = '<!DOCTYPE html>
	<html lang="es" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">
	<head>
	<title></title>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
	<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
	<!--[if mso]><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch><o:AllowPNG/></o:OfficeDocumentSettings></xml><![endif]-->
	<!--[if !mso]><!-->
	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css"/>
	<!--<![endif]-->
	<style>
			* {
				box-sizing: border-box;
			}

			body {
				margin: 0;
				padding: 0;
			}

			a[x-apple-data-detectors] {
				color: inherit !important;
				text-decoration: inherit !important;
			}

			#MessageViewBody a {
				color: inherit;
				text-decoration: none;
			}

			p {
				line-height: inherit
			}

			.desktop_hide,
			.desktop_hide table {
				mso-hide: all;
				display: none;
				max-height: 0px;
				overflow: hidden;
			}

			@media (max-width:700px) {

				.desktop_hide table.icons-inner,
				.row-16 .column-1 .block-6.social_block .alignment table,
				.row-4 .column-2 .block-2.button_block .alignment div,
				.row-6 .column-1 .block-3.button_block .alignment div,
				.social_block.desktop_hide .social-table {
					display: inline-block !important;
				}

				.icons-inner {
					text-align: center;
				}

				.icons-inner td {
					margin: 0 auto;
				}

				.image_block img.big,
				.row-content {
					width: 100% !important;
				}

				.mobile_hide {
					display: none;
				}

				.stack .column {
					width: 100%;
					display: block;
				}

				.mobile_hide {
					min-height: 0;
					max-height: 0;
					max-width: 0;
					overflow: hidden;
					font-size: 0px;
				}

				.desktop_hide,
				.desktop_hide table {
					display: table !important;
					max-height: none !important;
				}

				.row-1 .column-1 .block-2.heading_block td.pad {
					padding: 15px !important;
				}

				.row-3 .column-1 .block-2.text_block td.pad {
					padding: 15px 10px 10px 15px !important;
				}

				.row-4 .column-2 .block-2.button_block a span,
				.row-4 .column-2 .block-2.button_block div,
				.row-4 .column-2 .block-2.button_block div span,
				.row-6 .column-1 .block-3.button_block a span,
				.row-6 .column-1 .block-3.button_block div,
				.row-6 .column-1 .block-3.button_block div span {
					line-height: 2 !important;
				}

				.row-16 .column-1 .block-6.social_block .alignment,
				.row-4 .column-2 .block-2.button_block .alignment,
				.row-6 .column-1 .block-3.button_block .alignment {
					text-align: center !important;
				}

				.row-11 .column-1 .block-2.text_block td.pad {
					padding: 10px 0 10px 25px !important;
				}

				.row-16 .column-1 .block-6.social_block td.pad {
					padding: 0 0 0 20px !important;
				}

				.row-3 .column-1 {
					padding: 5px 20px 0 !important;
				}
			}
		</style>
	</head>
	<body style="margin: 0; background-color: #3333d3; padding: 0; -webkit-text-size-adjust: none; text-size-adjust: none;">
	<table border="0" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #3333d3;" width="100%">
	<tbody>
	<tr>
	<td>
	<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
	<tbody>
	<tr>
	<td>
	<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #3333d3; color: #000000; border-radius: 4px; width: 680px;" width="680">
	<tbody>
	<tr>
	<td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
	<table border="0" cellpadding="0" cellspacing="0" class="heading_block block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
	<tr>
	<td class="pad" style="text-align:center;width:100%;padding-top:40px;">
	<h1 style="margin: 0; color: #ffffff; direction: ltr; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif; font-size: 38px; font-weight: 700; letter-spacing: normal; line-height: 120%; text-align: center; margin-top: 0; margin-bottom: 0;"><a href="mayoristapp.mx" rel="noopener" style="text-decoration: none; color: #ffffff;" target="_blank"><span class="tinyMce-placeholder">mayoristapp.mx</span></a></h1>
	</td>
	</tr>
	</table>
	<table border="0" cellpadding="0" cellspacing="0" class="divider_block block-4" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
	<tr>
	<td class="pad" style="padding-bottom:10px;padding-left:10px;padding-right:10px;padding-top:30px;">
	<div align="center" class="alignment">
	<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="10%">
	<tr>
	<td class="divider_inner" style="font-size: 1px; line-height: 1px; border-top: 4px solid #FFFFFF;"><span> </span></td>
	</tr>
	</table>
	</div>
	</td>
	</tr>
	</table>
	<table border="0" cellpadding="10" cellspacing="0" class="text_block block-5" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
	<tr>
	<td class="pad">
	<div style="font-family: sans-serif">
	<div class="" style="font-size: 12px; mso-line-height-alt: 18px; color: #ffffff; line-height: 1.5; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
	<p style="margin: 0; font-size: 14px; text-align: center; mso-line-height-alt: 42px;"><span style="font-size:28px;">
		<strong>
			Confirmación de tu orden
			' . $idPedido . '
		</strong></span></p>
	</div>
	</div>
	</td>
	</tr>
	</table>
	<table border="0" cellpadding="0" cellspacing="0" class="text_block block-6" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
	<tr>
	<td class="pad" style="padding-bottom:35px;padding-left:10px;padding-right:10px;padding-top:10px;">
	<div style="font-family: sans-serif">
	<div class="" style="font-size: 12px; mso-line-height-alt: 21.6px; color: #ffffff; line-height: 1.8; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
	<p style="margin: 0; font-size: 14px; text-align: center; mso-line-height-alt: 32.4px;"><span style="font-size:18px;">¡Gracias por tu compra!</span></p>
	</div>
	</div>
	</td>
	</tr>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #3333d3;" width="100%">
	<tbody>
	<tr>
	<td>
	<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px;" width="680">
	<tbody>
	<tr>
	<td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 0px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
	<table border="0" cellpadding="0" cellspacing="0" class="image_block block-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
	<tr>
	<td class="pad" style="width:100%;padding-right:0px;padding-left:0px;">
	<div align="center" class="alignment" style="line-height:10px"><img alt="Alternate text" class="big" src="https://mayoristapp.mx/app/assets/img/mail/plantillaOrdenConfirmada/round_corner.png" style="display: block; height: auto; border: 0; width: 680px; max-width: 100%;" title="Alternate text" width="680"/></div>
	</td>
	</tr>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-3" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #3333d3;" width="100%">
	<tbody>
	<tr>
	<td>
	<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; border-radius: 0; width: 680px;" width="680">
	<tbody>
	<tr>
	<td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 0px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
	<table border="0" cellpadding="0" cellspacing="0" class="text_block block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
	<tr>
	<td class="pad" style="padding-bottom:10px;padding-left:35px;padding-right:10px;padding-top:35px;">
	<div style="font-family: sans-serif">
	<div class="" style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #030303; line-height: 1.2; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
	<p style="margin: 0; font-size: 14px; mso-line-height-alt: 16.8px;"><span style="font-size:18px;"><strong><span style="">Dirección de envío</span></strong></span></p>
	</div>
	</div>
	</td>
	</tr>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-4" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #3333d3;" width="100%">
	<tbody>
	<tr>
	<td>
	<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; width: 680px;" width="680">
	<tbody>
	<tr>
	<td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="50%">
	<table border="0" cellpadding="0" cellspacing="0" class="text_block block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
	<tr>
	<td class="pad" style="padding-bottom:10px;padding-left:35px;padding-right:10px;padding-top:20px;">
	<div style="font-family: sans-serif">
	<div class="" style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #030303; line-height: 1.2; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
	<p style="margin: 0; font-size: 14px; mso-line-height-alt: 16.8px;"><span style="font-size:15px;color:#332f2f;"><strong>
			<span style="">
					' . $_SESSION["nombre"] . ' ' . $_SESSION["paterno"] . '
			</span>
	</strong></span></p>
	</div>
	</div>
	</td>
	</tr>
	</table>
	<table border="0" cellpadding="0" cellspacing="0" class="text_block block-3" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
	<tr>
	<td class="pad" style="padding-left:35px;padding-right:10px;padding-top:10px;">
	<div style="font-family: sans-serif">
		<div class="" style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #626262; line-height: 1.2; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
				<p style="margin: 0; font-size: 14px; mso-line-height-alt: 16.8px;">';

				if ($reqEnvio == 0)
				{
						$data .= $getDatosContactoVendedor['email'] . '<br>';
				}

				if (isset($direccionPedido[0]))
				{
						$data .= $direccionPedido[0]["aliasDireccion"]  . ' <br><p> ' . $direccionPedido[0]["direccion"] . '</p>';
				}

				$data .= '
				</p>
		</div>
	</div>
	</td>
	</tr>
	</table>

	</td>
	<td class="column column-2" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="50%">
	<table border="0" cellpadding="0" cellspacing="0" class="button_block block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
	<tr>
	<td class="pad" style="padding-bottom:15px;padding-left:35px;padding-right:10px;padding-top:55px;text-align:left;">
	<div align="left" class="alignment">
	<!--[if mso]><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="https://mayoristapp.mx/app/mis-compras.php" style="height:42px;width:171px;v-text-anchor:middle;" arcsize="10%" stroke="false" fillcolor="#e17370"><w:anchorlock/><v:textbox inset="0px,0px,0px,0px"><center style="color:#ffffff; font-family:Tahoma, sans-serif; font-size:16px"><![endif]--><a href="https://mayoristapp.mx/app/mis-compras.php" style="text-decoration:none;display:inline-block;color:#ffffff;background-color:#e17370;border-radius:4px;width:auto;border-top:0px solid #E17370;font-weight:400;border-right:0px solid #E17370;border-bottom:0px solid #E17370;border-left:0px solid #E17370;padding-top:5px;padding-bottom:5px;font-family:Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;font-size:16px;text-align:center;mso-border-alt:none;word-break:keep-all;" target="_blank"><span style="padding-left:40px;padding-right:40px;font-size:16px;display:inline-block;letter-spacing:normal;"><span dir="ltr" style="word-break: break-word; line-height: 32px;">Ver Detalle </span></span></a>
	<!--[if mso]></center></v:textbox></v:roundrect><![endif]-->
	</div>
	</td>
	</tr>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-5" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #3333d3;" width="100%">
	<tbody>
	<tr>
	<td>
	<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; width: 680px;" width="680">
	<tbody>
	<tr>
	<td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 0px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
	<table border="0" cellpadding="10" cellspacing="0" class="divider_block block-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
	<tr>
	<td class="pad">
	<div align="center" class="alignment">
	<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
	<tr>
	<td class="divider_inner" style="font-size: 1px; line-height: 1px; border-top: 1px solid #D6D3D3;"><span> </span></td>
	</tr>
	</table>
	</div>
	</td>
	</tr>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-6" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
	<tbody>
	<tr>
	<td>
	<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; width: 680px;" width="680">
	<tbody>
	<tr>
	<td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
	<table border="0" cellpadding="0" cellspacing="0" class="text_block block-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
	<tr>
	<td class="pad" style="padding-bottom:10px;padding-left:35px;padding-right:10px;padding-top:15px;">
	<div style="font-family: sans-serif">
	<div class="" style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #030303; line-height: 1.2; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
	<p style="margin: 0; font-size: 14px; mso-line-height-alt: 16.8px;"><span style="font-size:18px;"><strong><span style="">¿Ya realizaste tu pago? 💵</span></strong></span></p>
	</div>
	</div>
	</td>
	</tr>
	</table>
	<table border="0" cellpadding="0" cellspacing="0" class="paragraph_block block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
	<tr>
	<td class="pad" style="padding-bottom:15px;padding-left:35px;padding-right:35px;padding-top:15px;">
	<div style="color:#101112;direction:ltr;font-family:Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;font-size:15px;font-weight:400;letter-spacing:0px;line-height:120%;text-align:left;mso-line-height-alt:18px;">
	<p style="margin: 0;">Confirma tu pago al vendedor, carga tu comprobante desde tu cuenta mayoristapp.mx o envíaselo por whatsapp.</p>
	</div>
	</td>
	</tr>
	</table>
	<table border="0" cellpadding="0" cellspacing="0" class="button_block block-3" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
	<tr>
	<td class="pad" style="padding-bottom:15px;padding-left:35px;padding-right:10px;padding-top:10px;text-align:left;">
	<div align="left" class="alignment">
	<!--[if mso]><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="https://mayoristapp.mx/app/mis-compras.php" style="height:36px;width:189px;v-text-anchor:middle;" arcsize="12%" strokeweight="0.75pt" strokecolor="#E17370" fillcolor="#e17370"><w:anchorlock/><v:textbox inset="0px,0px,0px,0px"><center style="color:#ffffff; font-family:Tahoma, sans-serif; font-size:12px"><![endif]--><a href="https://mayoristapp.mx/app/mis-compras.php" style="text-decoration:none;display:inline-block;color:#ffffff;background-color:#e17370;border-radius:4px;width:auto;border-top:1px solid #E17370;font-weight:400;border-right:1px solid #E17370;border-bottom:1px solid #E17370;border-left:1px solid #E17370;padding-top:5px;padding-bottom:5px;font-family:Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;font-size:12px;text-align:center;mso-border-alt:none;word-break:keep-all;" target="_blank"><span style="padding-left:30px;padding-right:30px;font-size:12px;display:inline-block;letter-spacing:normal;"><span dir="ltr" style="word-break: break-word; line-height: 24px;">Cargar comprobante</span></span></a>
	<!--[if mso]></center></v:textbox></v:roundrect><![endif]-->
	</div>
	</td>
	</tr>
	</table>
	<table border="0" cellpadding="10" cellspacing="0" class="divider_block block-4" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
	<tr>
	<td class="pad">
	<div align="center" class="alignment">
	<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
	<tr>
	<td class="divider_inner" style="font-size: 1px; line-height: 1px; border-top: 1px solid #D6D3D3;"><span> </span></td>
	</tr>
	</table>
	</div>
	</td>
	</tr>
	</table>
	<table border="0" cellpadding="0" cellspacing="0" class="text_block block-5" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
	<tr>
	<td class="pad" style="padding-bottom:10px;padding-left:35px;padding-top:15px;">
	<div style="font-family: sans-serif">
	<div class="" style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #030303; line-height: 1.2; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
			<p style="margin: 0; font-size: 14px; mso-line-height-alt: 16.8px;">
					<span style="font-size:18px;">
							<strong>
									<span style="">
											Datos de pago
									</span>
							</strong>
					</span>
			</p>
	</div>
	</div>
	</td>
	</tr>
	</table>
	<table border="0" cellpadding="0" cellspacing="0" class="paragraph_block block-6" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
	<tr>
	<td class="pad" style="padding-bottom:15px;padding-left:35px;padding-right:35px;padding-top:15px;">
	<div style="color:#101112;direction:ltr;font-family:Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;font-size:13px;font-weight:400;letter-spacing:0px;line-height:120%;text-align:left;mso-line-height-alt:15.6px;">
	<p style="margin: 0;">
			Vendedor: '. $getDatosContactoVendedor['nombre'] . ' ' . $getDatosContactoVendedor['paterno'] .'
	</p>
	</div>
	</td>
	</tr>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-7" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
	<tbody>
	<tr>
	<td>
	<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; width: 680px;" width="680">
	<tbody>
			<tr>';

					foreach ($datosBancariosCorreo as $key => $value)
					{

							$data .= '<td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="50%">
									<table border="0" cellpadding="0" cellspacing="0" class="text_block block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
											<tr>
													<td class="pad" style="padding-bottom:15px;padding-left:35px;padding-right:30px;padding-top:15px;">
															<div style="font-family: sans-serif">
																	<div class="" style="font-size: 12px; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif; mso-line-height-alt: 14.399999999999999px; color: #555555; line-height: 1.2;">

																			<p style="margin: 0; font-size: 14px; mso-line-height-alt: 14.399999999999999px;"> </p>
																			<p style="margin: 0; font-size: 14px; mso-line-height-alt: 16.8px;"><span style="font-size:14px;">' . $value['banco'] . '</span></p>
																			<p style="margin: 0; font-size: 14px; mso-line-height-alt: 16.8px;"><span style="font-size:14px;">' . $value['numTarjeta'] . '</span></p>
																			<p style="margin: 0; font-size: 14px; mso-line-height-alt: 16.8px;"><span style="font-size:14px;">' . $value['numClabe'] . '</span></p>

																	</div>
															</div>
													</td>
											</tr>
									</table>
							</td>';

					}


				$data .= '
			</tr>
	</tbody>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-8" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #3333d3;" width="100%">
	<tbody>
	<tr>
	<td>
	<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; width: 680px;" width="680">
	<tbody>
	<tr>
	<td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 0px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
	<table border="0" cellpadding="10" cellspacing="0" class="divider_block block-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
	<tr>
	<td class="pad">
	<div align="center" class="alignment">
	<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
	<tr>
	<td class="divider_inner" style="font-size: 1px; line-height: 1px; border-top: 1px solid #D6D3D3;"><span> </span></td>
	</tr>
	</table>
	</div>
	</td>
	</tr>
	</table>
	<table border="0" cellpadding="0" cellspacing="0" class="text_block block-3" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
	<tr>
	<td class="pad" style="padding-bottom:10px;padding-left:35px;padding-right:10px;padding-top:25px;">
	<div style="font-family: sans-serif">
	<div class="" style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #030303; line-height: 1.2; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
	<p style="margin: 0; font-size: 14px; mso-line-height-alt: 16.8px;"><span style="font-size:18px;"><strong><span style="">Total a pagar</span></strong></span></p>
	</div>
	</div>
	</td>
	</tr>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-9" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
	<tbody>
	<tr>
	<td>
	<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; width: 680px;" width="680">
	<tbody>
	<tr>
	<td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="33.333333333333336%">
	<table border="0" cellpadding="0" cellspacing="0" class="text_block block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
			<tr>
					<td class="pad" style="padding-left:25px;padding-top:15px;padding-bottom:5px;">
							<div style="font-family: sans-serif">
									<div class="" style="font-size: 12px; mso-line-height-alt: 18px; color: #848484; line-height: 1.5; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
											<p style="margin: 0; font-size: 14px; text-align: left; mso-line-height-alt: 21px;">
													<span style="font-size:14px;">
															Subtotal
													</span>
											</p>
									</div>
							</div>
					</td>
			</tr>
	</table>
	</td>
	<td class="column column-2" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="33.333333333333336%">
	<div class="spacer_block" style="height:5px;line-height:5px;font-size:1px;"> </div>
	<table border="0" cellpadding="10" cellspacing="0" class="text_block mobile_hide block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
	<tr>
	<td class="pad">
	<div style="font-family: sans-serif">
	<div class="" style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #555555; line-height: 1.2; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
	<p style="margin: 0; font-size: 12px; mso-line-height-alt: 14.399999999999999px;"> </p>
	</div>
	</div>
	</td>
	</tr>
	</table>
	<div class="spacer_block" style="height:5px;line-height:5px;font-size:1px;"> </div>
	</td>
	<td class="column column-3" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="33.333333333333336%">
	<table border="0" cellpadding="0" cellspacing="0" class="text_block block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
			<tr>
					<td class="pad" style="padding-left:35px;padding-right:10px;padding-top:15px;padding-bottom:5px;">
							<div style="font-family: sans-serif">
									<div class="" style="font-size: 12px; mso-line-height-alt: 18px; color: #666666; line-height: 1.5; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
											<p style="margin: 0; font-size: 14px; text-align: left; mso-line-height-alt: 21px;">
													<span style="font-size:14px;">
															$ ' . $subtotal . '
													</span>
											</p>
									</div>
							</div>
					</td>
			</tr>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-10" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
	<tbody>
	<tr>
	<td>
	<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; width: 680px;" width="680">
	<tbody>
	<tr>
	<td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="33.333333333333336%">
	<table border="0" cellpadding="0" cellspacing="0" class="text_block block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
			<tr>
					<td class="pad" style="padding-left:25px;padding-top:15px;padding-bottom:5px;">
							<div style="font-family: sans-serif">
									<div class="" style="font-size: 12px; mso-line-height-alt: 18px; color: #848484; line-height: 1.5; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
											<p style="margin: 0; font-size: 14px; text-align: left; mso-line-height-alt: 21px;">
													<span style="font-size:14px;">
															Descuentos
													</span>
											</p>
									</div>
							</div>
					</td>
			</tr>
	</table>
	</td>
	<td class="column column-2" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="33.333333333333336%">
	<div class="spacer_block" style="height:5px;line-height:5px;font-size:1px;"> </div>
	<table border="0" cellpadding="10" cellspacing="0" class="text_block mobile_hide block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
	<tr>
	<td class="pad">
	<div style="font-family: sans-serif">
	<div class="" style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #555555; line-height: 1.2; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
	<p style="margin: 0; font-size: 12px; mso-line-height-alt: 14.399999999999999px;"> </p>
	</div>
	</div>
	</td>
	</tr>
	</table>
	<div class="spacer_block" style="height:5px;line-height:5px;font-size:1px;"> </div>
	</td>
	<td class="column column-3" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="33.333333333333336%">
	<table border="0" cellpadding="0" cellspacing="0" class="text_block block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
			<tr>
					<td class="pad" style="padding-left:35px;padding-right:10px;padding-top:15px;padding-bottom:5px;">
							<div style="font-family: sans-serif">
									<div class="" style="font-size: 12px; mso-line-height-alt: 18px; color: #666666; line-height: 1.5; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
											<p style="margin: 0; font-size: 14px; text-align: left; mso-line-height-alt: 21px;">
													<span style="font-size:14px;">
															$ ' . $descuento . '
													</span>
											</p>
									</div>
							</div>
					</td>
			</tr>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-11" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
	<tbody>
	<tr>
	<td>
	<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; width: 680px;" width="680">
	<tbody>
	<tr>
	<td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="33.333333333333336%">
	<table border="0" cellpadding="0" cellspacing="0" class="text_block block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
	<tr>
	<td class="pad" style="padding-bottom:15px;padding-left:60px;padding-right:10px;padding-top:20px;">
	<div style="font-family: sans-serif">
	<div class="" style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #030303; line-height: 1.2; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
	<p style="margin: 0; font-size: 14px; mso-line-height-alt: 16.8px;"><span style="font-size:18px;"><strong><span style="">Total</span></strong></span></p>
	</div>
	</div>
	</td>
	</tr>
	</table>
	</td>
	<td class="column column-2" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="33.333333333333336%">
	<div class="spacer_block" style="height:5px;line-height:5px;font-size:1px;"> </div>
	<table border="0" cellpadding="10" cellspacing="0" class="text_block mobile_hide block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
	<tr>
	<td class="pad">
	<div style="font-family: sans-serif">
	<div class="" style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #555555; line-height: 1.2; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
	<p style="margin: 0; font-size: 12px; mso-line-height-alt: 14.399999999999999px;"> </p>
	</div>
	</div>
	</td>
	</tr>
	</table>
	<div class="spacer_block" style="height:5px;line-height:5px;font-size:1px;"> </div>
	</td>
	<td class="column column-3" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="33.333333333333336%">
	<table border="0" cellpadding="0" cellspacing="0" class="text_block block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
			<tr>
					<td class="pad" style="padding-bottom:15px;padding-left:35px;padding-right:10px;padding-top:20px;">
							<div style="font-family: sans-serif">
									<div class="" style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #030303; line-height: 1.2; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
											<p style="margin: 0; font-size: 14px; mso-line-height-alt: 16.8px;">
													<strong>
															<span style="font-size:20px;">
																	<span style="">
																			$ ' . $total . '
																	</span>
															</span>
													</strong>
											</p>
									</div>
							</div>
					</td>
			</tr>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-12" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #3333d3;" width="100%">
	<tbody>
	<tr>
	<td>
	<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; width: 680px;" width="680">
	<tbody>
	<tr>
	<td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 0px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
	<table border="0" cellpadding="10" cellspacing="0" class="divider_block block-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
	<tr>
	<td class="pad">
	<div align="center" class="alignment">
	<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
	<tr>
	<td class="divider_inner" style="font-size: 1px; line-height: 1px; border-top: 1px solid #D6D3D3;"><span> </span></td>
	</tr>
	</table>
	</div>
	</td>
	</tr>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-13" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
	<tbody>
	<tr>
	<td>
	<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; width: 680px;" width="680">
	<tbody>
	<tr>
	<td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
	<table border="0" cellpadding="10" cellspacing="0" class="text_block block-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
	<tr>
	<td class="pad">
	<div style="font-family: sans-serif">
	<div class="" style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #393d47; line-height: 1.2; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
	<p style="margin: 0; font-size: 14px; text-align: center; mso-line-height-alt: 16.8px;">Fecha de pedido: <strong>12.12.2020</strong></p>
	</div>
	</div>
	</td>
	</tr>
	</table>
	<table border="0" cellpadding="10" cellspacing="0" class="divider_block block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
	<tr>
	<td class="pad">
	<div align="center" class="alignment">
	<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
	<tr>
	<td class="divider_inner" style="font-size: 1px; line-height: 1px; border-top: 1px solid #D6D3D3;"><span> </span></td>
	</tr>
	</table>
	</div>
	</td>
	</tr>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-14" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
	<tbody>
	<tr>
	<td>
	<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #3939ad; color: #000000; width: 680px;" width="680">
	<tbody>
	<tr>
	<td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
	<table border="0" cellpadding="10" cellspacing="0" class="divider_block block-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
	<tr>
	<td class="pad">
	<div align="center" class="alignment">
	<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
	<tr>
	<td class="divider_inner" style="font-size: 1px; line-height: 1px; border-top: 1px solid #FFFFFF;"><span> </span></td>
	</tr>
	</table>
	</div>
	</td>
	</tr>
	</table>
	<table border="0" cellpadding="10" cellspacing="0" class="text_block block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
	<tr>
	<td class="pad">
	<div style="font-family: sans-serif">
	<div class="" style="font-size: 12px; mso-line-height-alt: 18px; color: #ffffff; line-height: 1.5; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
	<p style="margin: 0; font-size: 14px; text-align: center; mso-line-height-alt: 24px;"><span style="font-size:16px;">Gracias por usar <span style="color:#ffffff;"><a href="https://mayoristapp.mx" rel="noopener" style="text-decoration: none; color: #ffffff;" target="_blank"><strong>https://mayoristapp.mx</strong></a></span><span style="background-color:#ffffff;"><a href="mayoristapp.mx" rel="noopener" style="text-decoration: none; background-color: #ffffff; color: #ffffff;" target="_blank"></a></span></span></p>
	</div>
	</div>
	</td>
	</tr>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-15" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
	<tbody>
	<tr>
	<td>
	<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #3939ad; color: #000000; width: 680px;" width="680">
	<tbody>
	<tr>
	<td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
	<table border="0" cellpadding="10" cellspacing="0" class="divider_block block-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
	<tr>
	<td class="pad">
	<div align="center" class="alignment">
	<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
	<tr>
	<td class="divider_inner" style="font-size: 1px; line-height: 1px; border-top: 1px solid #FFFFFF;"><span> </span></td>
	</tr>
	</table>
	</div>
	</td>
	</tr>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-16" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
	<tbody>
	<tr>
	<td>
	<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #3939ad; color: #000000; width: 680px;" width="680">
	<tbody>
	<tr>
	<td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
	<table border="0" cellpadding="0" cellspacing="0" class="text_block block-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
	<tr>
	<td class="pad" style="padding-bottom:10px;padding-left:25px;padding-right:10px;padding-top:10px;">
	<div style="font-family: sans-serif">
	<div class="" style="font-size: 12px; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif; mso-line-height-alt: 14.399999999999999px; color: #ffffff; line-height: 1.2;">
	<p style="margin: 0; font-size: 18px; text-align: left; mso-line-height-alt: 21.599999999999998px;"><strong><span style="color:#ffffff;">Comienza a vender en línea</span></strong></p>
	</div>
	</div>
	</td>
	</tr>
	</table>
	<table border="0" cellpadding="0" cellspacing="0" class="text_block block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
	<tr>
	<td class="pad" style="padding-bottom:20px;padding-left:25px;padding-right:10px;padding-top:10px;">
	<div style="font-family: sans-serif">
	<div class="" style="font-size: 12px; mso-line-height-alt: 21.6px; color: #C0C0C0; line-height: 1.8; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;">
	<p style="margin: 0; mso-line-height-alt: 21.6px;"><span style="color:#ffffff;">Crea tu tienda gratis, recibe pedidos por Whatsapp, estadísticas de tus ventas o vende directo en tu sucursal, todo en un sólo lugar.</span></p>
	</div>
	</div>
	</td>
	</tr>
	</table>
	<table border="0" cellpadding="0" cellspacing="0" class="button_block block-3" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
	<tr>
	<td class="pad" style="padding-bottom:10px;padding-left:35px;padding-right:10px;padding-top:10px;text-align:left;">
	<div align="left" class="alignment">
	<!--[if mso]><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="https://mayoristapp.mx/#registro" style="height:44px;width:188px;v-text-anchor:middle;" arcsize="10%" strokeweight="0.75pt" strokecolor="#E17370" fillcolor="#e17370"><w:anchorlock/><v:textbox inset="0px,0px,0px,0px"><center style="color:#ffffff; font-family:Tahoma, sans-serif; font-size:16px"><![endif]--><a href="https://mayoristapp.mx/#registro" style="text-decoration:none;display:inline-block;color:#ffffff;background-color:#e17370;border-radius:4px;width:auto;border-top:1px solid #E17370;font-weight:400;border-right:1px solid #E17370;border-bottom:1px solid #E17370;border-left:1px solid #E17370;padding-top:5px;padding-bottom:5px;font-family:Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;font-size:16px;text-align:center;mso-border-alt:none;word-break:keep-all;" target="_blank"><span style="padding-left:30px;padding-right:30px;font-size:16px;display:inline-block;letter-spacing:normal;"><span dir="ltr" style="word-break: break-word; line-height: 32px;">Crear mi tienda</span></span></a>
	<!--[if mso]></center></v:textbox></v:roundrect><![endif]-->
	</div>
	</td>
	</tr>
	</table>
	<table border="0" cellpadding="0" cellspacing="0" class="text_block block-5" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
	<tr>
	<td class="pad" style="padding-bottom:10px;padding-left:25px;padding-right:10px;padding-top:31px;">
	<div style="font-family: sans-serif">
	<div class="" style="font-size: 12px; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif; mso-line-height-alt: 18px; color: #ffffff; line-height: 1.5;">
	<p style="margin: 0; text-align: center; mso-line-height-alt: 27px;"><span style="background-color:transparent;font-size:18px;"><strong>Encuéntranos</strong></span><strong style="font-family:inherit;font-family:inherit;font-size:18px;"><span style="color:#ffffff;"> en:</span></strong></p>
	</div>
	</div>
	</td>
	</tr>
	</table>
	<table border="0" cellpadding="0" cellspacing="0" class="social_block block-6" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
	<tr>
	<td class="pad" style="padding-bottom:35px;padding-left:20px;text-align:center;padding-right:0px;">
	<div align="center" class="alignment">
	<table border="0" cellpadding="0" cellspacing="0" class="social-table" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; display: inline-block;" width="94px">
	<tr>
	<td style="padding:0 15px 0 0px;"><a href="https://instagram.com/" target="_blank"><img alt="Instagram" height="32" src="https://mayoristapp.mx/app/assets/img/mail/plantillaOrdenConfirmada/instagram2x.png" style="display: block; height: auto; border: 0;" title="Instagram" width="32"/></a></td>
	<td style="padding:0 15px 0 0px;"><a href="https://www.whatsapp.com" target="_blank"><img alt="WhatsApp" height="32" src="https://mayoristapp.mx/app/assets/img/mail/plantillaOrdenConfirmada/whatsapp2x.png" style="display: block; height: auto; border: 0;" title="WhatsApp" width="32"/></a></td>
	</tr>
	</table>
	</div>
	</td>
	</tr>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-17" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
	<tbody>
	<tr>
	<td>
	<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px;" width="680">
	<tbody>
	<tr>
	<td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
	<table border="0" cellpadding="0" cellspacing="0" class="icons_block block-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
	<tr>
	<td class="pad" style="vertical-align: middle; color: #9d9d9d; font-family: inherit; font-size: 15px; padding-bottom: 5px; padding-top: 5px; text-align: center;">
	<table cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">

	</table>
	</td>
	</tr>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	</td>
	</tr>
	</tbody>
	</table><!-- End -->
	</body>
	</html>';

	echo $data;

}

$idPedido                  	= "88-1s";
$fechaPedido   							= "fechaPedido";
$reqEnvio   								= 1;

$direccionPedido[0]["aliasDireccion"] = 'alias1';
$direccionPedido[0]["direccion"] = 'calle 28';



$subtotal   								= "133";
$descuento   								= "5";
$total   										= "128";
$getDatosContactoVendedor   = array('nombre' => 'axel', 'paterno' => 'espino');
$datosBancariosCorreo   		= "datosBancariosCorreo";

correo($idPedido, $fechaPedido, $reqEnvio, $direccionPedido, $subtotal, $descuento, $total, $getDatosContactoVendedor, $datosBancariosCorreo);
?>
