<!-- Modal datos de pago -->
<div class="modal fade" id="modalConfirmarPagoCliente" tabindex="-1" aria-labelledby="modalConfirmarPagoClienteLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-primary" id="modalConfirmarPagoClienteLabel"> Confirma el pago </h5>
        <button type="button" class="btn btn-icon btn-outline-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">
            <i class="fa-solid fa-xmark fa-xl"></i>
        </button>
      </div>

        <form class="" action="../app/procesa.php" method="post" enctype="multipart/form-data">
            <div class="modal-body">

                <p class="text-dark fw-400 fs-6">Carga tu comprobante de pago/transferencia</p>
                <?php
                    if (!isset($datosPedido['comprobantePago']))
                    {
                        ?>
                        <p class="fw-200 small">(Sólo archivos jpg, png, jpeg o pdf.)</p>
                        <input type="file" class="form-control border-2" name="fileToUpload" required>                      
                        <?php
                    }

                    if (isset($datosPedido))
                    {
                        ?>
                        <input type="hidden" name="idCliente" value="<?php echo $datosPedido['idCliente']; ?>">
                        <input type="hidden" name="idPedido"   value="<?php echo $idPedido; ?>">
                        <?php
                    }
                ?> 
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-outline-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#modalDatosPago">
                    <i class="me-1" data-feather='credit-card'></i> Pagar ahora
                </button>
                <button type="submit" class="btn btn-success" name="btnCargaComprobante">
                    <i class="me-1" data-feather='upload-cloud'></i> Subir
                </button>
            </div>
        </form>

    </div>
  </div>
</div>
<!-- Modal datos de pago Fin -->

<!-- Modal Confirma envío vendedor -->
<div class="modal fade" id="modalConfirmaEnvio" tabindex="-1" aria-labelledby="modalConfirmaEnvioLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalConfirmaEnvioLabel">Confirma el envío</h5>
        <button type="button" class="btn btn-icon btn-outline-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">
            <i class="fa-solid fa-xmark fa-xl"></i>
        </button>
      </div>

      <form action="procesa.php" method="post">


          <div class="modal-body">


            <div class="row mb-2 p-2">
                <label for="paqueteria" class="fw-400 text-primary">Paquetería</label>
                <input type="text" id="paqueteria" class="form-control" name="nombrePaqueteria" placeholder="(Opcional)">
            </div>

            <div class="row mb-2 p-2">
                <label for="guia" class="fw-400 text-primary">Número de Guía</label>
                <input type="text" id="guia" class="form-control" name="guiaEnvio" placeholder="(Opcional)">
            </div>

            <div class="row mb-2 p-2">
                <label for="envio" class="fw-400 text-primary">Fecha Envío*</label>
                <input type="date" id="envio" class="form-control" name="fechaEnvio" required>
            </div>

            <?php
            if (isset($datosPedido))
            {
            ?>
            <input type="hidden" name="idPedido"  value="<?php echo $idPedido; ?>" required>
            <input type="hidden" name="idCliente" value="<?php echo $datosPedido['idCliente']; ?>" required>
            <?php
            }
            ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary" name="btnNotificarEnvio">Notificar Ahora</button>
          </div>
      </form>

    </div>
  </div>
</div>
<!-- Modal Confirma envío vendedor Fin -->

<!-- modal nuevo envio Inicio-->
<div class="modal fade" id="modalNuevoEnvio" tabindex="-1" aria-labelledby="modalNuevoEnvioLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalNuevoEnvioLabel">Nuevo envío</h5>
                <button type="button" class="btn btn-icon btn-outline-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark fa-xl"></i>
                </button>
            </div>
            <form class="" id="formNuevoEnvio" action="procesa.php" method="post">
                <div class="modal-body">

                    <!-- Form Group (email address)-->
                    <div class="mb-3">
                        <label class="small mb-1 text-primary fw-500" for="inputNombreEnvio">Nombre</label>
                        <input class="form-control" type="text" id="inputNombreEnvio" name="nombreEnvio" placeholder="DHL Exprés, Envío inmediato, etc ..." value="" required />
                    </div>

                    <label class="small mb-1 text-primary fw-500" for="inputNombreEnvio">Precio</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">$</span>
                        <input type="number" class="form-control" pattern="\d*" placeholder="0" name="precioEnvio" aria-label="Precio envio" aria-describedby="basic-addon1" required>
                    </div>

                    <div class="mb-3">
                        <label class="small mb-1 text-primary fw-500" for="inputNombreEnvio">Tipo de envío</label>
                        <input class="form-control" type="text" value="A domicilio" readonly />
                    </div>

                    <!-- Form Group (Group Selection Checkboxes)-->
                    <div class="mb-3">
                        <label class="small mb-1 text-primary fw-500">Este envío acepta el pago:</label>
                        <div class="form-check" style="cursor: pointer;">
                            <input class="form-check-input" style="cursor: pointer;" id="onlineP" name="hasOnlinePayment" type="checkbox" value="1" />
                            <label class="form-check-label" style="cursor: pointer;" for="onlineP">En línea</label>
                        </div>
                        <div class="form-check" style="cursor: pointer;">
                            <input class="form-check-input" style="cursor: pointer;" id="deliveryP" name="hasDeliveryPayment" type="checkbox" value="1" />
                            <label class="form-check-label" style="cursor: pointer;" for="deliveryP">En la entrega</label>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success" name="btnGuardarEnvio">Guardar envío</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- modal nuevo envio Fin -->

<!-- Inicio Modal Calcular cambio efectivo -->
<div class="modal fade" id="modalCalcularCambioEfectivo" tabindex="-1" aria-labelledby="modalCalcularCambioEfectivo" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0">
      <div class="modal-header bg-white border-1 border-bottom">
        <h5 class="modal-title text-primary fw-600" id=""><i class="fas fa-hand-holding-usd"></i> Pago en efectivo </h5>
        <button type="button" class="btn btn-icon btn-outline-indigo btn-sm" data-bs-dismiss="modal" aria-label="Close">
            <i class="fa-solid fa-xmark fa-xl"></i>
        </button>
      </div>
      <div class="modal-body bg-white text-gray border-0 rounded-bottom">
          <!-- Formulario de registro de categorías -->
          <form id="formCalcularCambio" action="procesa.php" method="post">
              <div class="mb-3">

                  <label class="small text-primary fw-500" for="">Total a cobrar:</label>
                  <div class="input-group mb-3">
                      <span class="input-group-text border border-2 shadow-none text-dark text-center fs-1 fw-500 " id="basic-addon1">$</span>
                      <?php
                          if (isset($_SESSION['total']))
                          {
                          ?>
                          <input type="text" class="form-control border border-2 shadow-none text-dark text-center fs-1" id="totalCompra" autocomplete="off" value="<?php echo number_format($_SESSION['total'], 2); ?>" readonly required>
                          <?php
                          }
                      ?>
                  </div>

                  <label class="small text-primary fw-500" for="">Total de efectivo recibido:</label>
                  <div class="input-group mb-3">
                      <span class="input-group-text border border-2 shadow-none text-dark text-center fs-1 fw-500 " id="basic-addon1">$</span>
                      <input type="text" class="form-control border border-2 shadow-none text-dark text-center fs-1" placeholder="0.00" id="efectivoRecibido" autocomplete="off" pattern="\d*" required>
                  </div>


                  <p class="text-start fw-600 fs-2 text-danger" id="salidaEfectivoCaja"> </p>

                  <label class="small text-primary fw-500" for="">Entregar al cliente:</label>
                  <div class="input-group mb-3">
                      <span class="input-group-text border border-2 border-danger shadow-none text-danger text-center fs-1 fw-500 " id="basic-addon1">$</span>
                      <input type="text" class="form-control border border-2 bg-white border-danger shadow-none text-danger text-center fw-600 fs-1" placeholder="0.00" id="cambioEfectivo" autocomplete="off" readonly>
                  </div>
                  <div class="small text-danger mb-2 text-center fw-400 fs-6" id="labelCambioEfectivoATexto"></div>

              </div>
          </form>
      </div>

    </div>
  </div>
</div>
<!-- Fin Modal Calcular cambio efectivo -->

<!-- modal seleccionar sucursal Inicio-->
<div class="modal fade" id="modalSeleccionarSucursal" tabindex="-1" aria-labelledby="modalSeleccionarSucursalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="procesa.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title text-primary fw-600">Selecciona la sucursal</h5>
                    <!-- <button type="button" class="btn btn-icon btn-outline-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark fa-xl"></i>
                    </button> -->
                </div>
                <div class="modal-body">
                    <div class="mb-2 m-2 text-dark">
                        <?php

                        if (isset($conn) && isset($idTienda))
                        {
                            $sucursales = getSucursalesTienda($conn, $idTienda);

                            // Verificar si se encontraron sucursales
                            if ($sucursales)
                            {
                                // Iterar sobre las sucursales y mostrar cada una en un radio button
                                foreach ($sucursales as $sucursal)
                                {
                                    if (isset($_SESSION['idSucursalVenta']) && ($_SESSION['idSucursalVenta'] == $sucursal['idSucursal']))
                                    {
                                        echo '<div class="mb-2">';
                                        echo '<label style="cursor: pointer;" class="fw-400 fs-4 text-dark poppins-font"><input type="radio" name="sucursal" value="' . $sucursal['idSucursal'] . '" checked required> ' . $sucursal['nombreSucursal'] . '</label><br>';
                                        echo '</div>';
                                    }
                                    else
                                    {
                                        echo '<div class="mb-2">';
                                        echo '<label style="cursor: pointer;" class="fw-400 fs-4 text-dark poppins-font"><input type="radio" name="sucursal" value="' . $sucursal['idSucursal'] . '" required> ' . $sucursal['nombreSucursal'] . '</label><br>';
                                        echo '</div>';
                                    }
                                }
                            }
                            else
                            {
                                echo 'No se encontraron sucursales para esta tienda.';
                            }
                        }
                        ?>
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="idTienda" value="<?php echo isset($idTienda) ? $idTienda : ''; ?>">
                    <button type="button" class="btn btn-light fw-400" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <?php
                    if ($sucursales)
                    {
                      ?>
                      <button type="submit" class="btn btn-success" name="btnSeleccionarSucursal">
                          <i class="me-1" data-feather='save'></i> Seleccionar
                      </button>
                      <?php
                    }
                    else
                    {
                    ?>
                      <a href="#" class="btn btn-primary rounded-3" data-bs-toggle="modal" data-bs-target="#modalNuevaSucursal">
                        Registrar sucursal
                      </a>
                    <?php
                    }
                    ?>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- modal seleccionar sucursal Fin -->


<form action="procesa.php" method="post" id="formNuevaSucursal" autocomplete="off">
    <!-- modal nueva direccion cliente Inicio -->
    <div class="modal fade" id="modalNuevaSucursal" tabindex="-1" aria-labelledby="modalNuevaSucursalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary fw-600">
                        <i class="far fa-building me-1"></i> Registro de sucursal 
                    </h5>
                    <button type="button" class="btn btn-icon btn-outline-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark fa-xl"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-2 text-dark">

                        <div class="row mb-2">
                            <div class="col">
                                <label class="text-primary fw-400 small" for="nombre_sucursal">Nombre de la Sucursal:*</label>
                                <input type="text" class="form-control fs-6 fw-500 text-center" id="nombre_sucursal" name="nombre_sucursal" placeholder="Nombre sucursal" autocomplete="off">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-6">
                                <label class="text-primary fw-400 small" for="cp_sucursal">Código postal:*</label>
                                <input type="number" class="form-control" id="cp_sucursal" min="0" maxlength="5" name="cp_sucursal" placeholder="xxxxx" autocomplete="off" oninput="if (this.value.length > 5) { this.value = this.value.slice(0, 5); }">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col">
                                <label class="text-primary fw-400 small" for="estado_sucursal">Estado:*</label>
                                <select class="form-select" id="estado_sucursal" name="estado_sucursal">
                                    <option value="" selected>Seleccionar</option>
                                    <option value="AGUASCALIENTES">AGUASCALIENTES</option>
                                    <option value="BAJA CALIFORNIA">BAJA CALIFORNIA</option>
                                    <option value="BAJA CALIFORNIA SUR">BAJA CALIFORNIA SUR</option>
                                    <option value="CHIHUAHUA">CHIHUAHUA</option>
                                    <option value="CHIAPAS">CHIAPAS</option>
                                    <option value="CAMPECHE">CAMPECHE</option>
                                    <option value="CIUDAD DE MEXICO">CIUDAD DE MEXICO</option>
                                    <option value="COAHUILA">COAHUILA</option>
                                    <option value="COLIMA">COLIMA</option>
                                    <option value="DURANGO">DURANGO</option>
                                    <option value="GUERRERO">GUERRERO</option>
                                    <option value="GUANAJUATO">GUANAJUATO</option>
                                    <option value="HIDALGO">HIDALGO</option>
                                    <option value="JALISCO">JALISCO</option>
                                    <option value="MICHOACAN">MICHOACAN</option>
                                    <option value="ESTADO DE MEXICO">ESTADO DE MEXICO</option>
                                    <option value="MORELOS">MORELOS</option>
                                    <option value="NAYARIT">NAYARIT</option>
                                    <option value="NUEVO LEON">NUEVO LEON</option>
                                    <option value="OAXACA">OAXACA</option>
                                    <option value="PUEBLA">PUEBLA</option>
                                    <option value="QUINTANA ROO">QUINTANA ROO</option>
                                    <option value="QUERETARO">QUERETARO</option>
                                    <option value="SINALOA">SINALOA</option>
                                    <option value="SAN LUIS POTOSI">SAN LUIS POTOSI</option>
                                    <option value="SONORA">SONORA</option>
                                    <option value="TABASCO">TABASCO</option>
                                    <option value="TLAXCALA">TLAXCALA</option>
                                    <option value="TAMAULIPAS">TAMAULIPAS</option>
                                    <option value="VERACRUZ">VERACRUZ</option>
                                    <option value="YUCATAN">YUCATAN</option>
                                    <option value="ZACATECAS">ZACATECAS</option>
                                </select>
                            </div>
                            <div class="col">
                                <label class="text-primary fw-400 small" for="calle_sucursal">Municipio/Alcaldía:*</label>
                                <input type="text" class="form-control" id="calle_sucursal" name="mun_alc_sucursal" placeholder="Municipio/Alcaldía" autocomplete="off">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col">
                                <label class="text-primary fw-400 small" for="colonia_sucursal">Colonia:*</label>
                                <input type="text" class="form-control" id="colonia_sucursal" name="colonia_sucursal" placeholder="Colonia" autocomplete="off">
                            </div>
                            <div class="col">
                                <label class="text-primary fw-400 small" for="calle_sucursal">Calle:*</label>
                                <input type="text" class="form-control" id="calle_sucursal" name="calle_sucursal" placeholder="Calle" autocomplete="off">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col">
                                <label class="text-primary fw-400 small" for="exterior_sucursal">Número Exterior:*</label>
                                <input type="text" class="form-control" id="exterior_sucursal" name="exterior_sucursal" placeholder="Núm. Exterior" autocomplete="off">
                            </div>
                            <div class="col">
                                <label class="text-primary fw-400 small" for="interior_sucursal">Interior/Depto:</label>
                                <input type="text" class="form-control" id="interior_sucursal" name="interior_sucursal" placeholder="Interior/Depto" autocomplete="off">
                            </div>
                        </div>

                        <div class="mb-2">
                            * Campos requeridos
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col">
                        <span class="border border-1 p-2 fw-300 small rounded-pill border-gray">1/2</span>
                    </div>
                    <div class="col text-end">
                        <button type="button" class="btn btn-light border border-2 rounded-3 mb-2 fw-500 fs-6" data-bs-dismiss="modal">
                            Cerrar
                        </button>
                        <button type="button" class="btn btn-primary rounded-3 mb-2 fw-500 fs-6" onclick="validarCamposRegistroSucursal()">
                            Siguiente <i class="ms-1" data-feather='arrow-right'></i>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- modal nueva direccion cliente fin -->

    <!-- modal nueva direccion cliente Inicio -->
    <div class="modal fade" id="modalNuevaSucursal2" tabindex="-1" aria-labelledby="modalNuevaSucursal2Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary fw-600">
                        <i class="far fa-building me-1"></i> Registro de sucursal
                    </h5>
                    <button type="button" class="btn btn-icon btn-outline-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark fa-xl"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-2 text-dark">

                        <div class="row mb-2">
                            <div class="col">
                              <label class="text-primary fw-400 small" for="telefono_sucursal">Teléfono:*</label>
                              <input type="text" class="form-control" id="telefono_sucursal" name="telefono_sucursal" placeholder="10 Dígitos" oninput="if (this.value.length > 10) { this.value = this.value.slice(0, 10); }" autocomplete="off">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="mb-1 mt-2 text-primary fw-500">
                                ¿Entre qué calles se encuentra?
                            </div>
                            <div class="col">
                                <label class="text-primary fw-400 small" for="entre_calles_sucursal">Calle 1:</label>
                                <input type="text" class="form-control" id="entre_calles_sucursal" name="entre_calles_sucursal" autocomplete="off">
                            </div>
                            <div class="col">
                                <label class="text-primary fw-400 small" for="entre_calles2_sucursal">Calle 2:</label>
                                <input type="text" class="form-control" id="entre_calles2_sucursal" name="entre_calles2_sucursal" autocomplete="off">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col">
                                <label class="text-primary fw-400 small" for="indicaciones_sucursal">Indicaciones Adicionales:</label>
                                <textarea id="indicaciones_sucursal" class="form-control" name="indicaciones_sucursal"></textarea>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="form-check checkbox-lg">
                                <label class="text-primary fw-400" for="is_principal_sucursal">¿Es la sucursal principal?</label>
                                <input type="checkbox" class="" id="is_principal_sucursal" name="is_principal_sucursal" value="1">
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col">
                        <span class="border border-1 p-2 fw-300 small rounded-pill border-gray">2/2</span>
                    </div>
                    <div class="col text-end">
                        <input type="hidden" name="btnNuevaSucursal">
                        <button type="button" class="btn btn-light rounded-3 border border-2 rounded-3 mb-2 fw-500 fs-6 w-100" data-bs-toggle="modal" data-bs-target="#modalNuevaSucursal">
                            <i class="me-1" data-feather='arrow-left'></i> Regresar
                        </button>
                        <button type="button" class="btn btn-indigo rounded-3 fw-500 fs-6 w-100" onclick="return validarTelefono()">
                            Guardar <i class="ms-1" data-feather='save'></i>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- modal nueva direccion cliente fin -->
</form>

<!-- modal ver datos bancarios configuracion tienda Inicio-->
<div class="modal fade" id="modalEliminarPago" tabindex="-1" aria-labelledby="modalEliminarPagoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEliminarPagoLabel">Confirmación</h5>
                <button type="button" class="btn btn-icon btn-outline-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark fa-xl"></i>
                </button>
            </div>

            <form class="" action="procesa.php" method="post">
                <div class="modal-body">
                    Estás a punto de eliminar el método de pago "<span id="paymentNameToDelete" class="fw-600"></span>". ¿Deseas continuar?
                    <input type="hidden" id="idToDeletePago" name="idToDelete" required>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-danger" name="btnEliminarPago">
                        Sí, eliminar
                    </button>

                </div>
          </form>
        </div>
    </div>
</div>
<!-- modal ver datos bancarios configuracion tienda Fin -->

<!-- modal ver datos bancarios configuracion tienda Inicio-->
<div class="modal fade" id="datosBancariosTienda" tabindex="-1" aria-labelledby="datosBancariosTiendaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                
                <h5 class="modal-title fw-600 text-blue" id="datosBancariosTiendaLabel">Datos bancarios</h5>

                <button type="button" class="btn btn-icon btn-outline-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark fa-xl"></i>
                </button>
            </div>

            <form class="" action="procesa.php" method="post">
                <div class="modal-body">

                    <div class="text-center">
                        Permite al cliente escanear el código QR para leer la información de pago
                    </div>
                    <div id="qrcode" class="d-flex justify-content-center p-3"></div>

                    <label class="fw-600" for="">Banco: </label>
                    <input type="text" class="form-control text-primary text-center fw-600 fs-4 mb-2" id="bancoModal" name="banco" readonly required autocomplete="off">

                    <label class="fw-600" for="">Número de tarjeta: </label>
                    <input type="text" class="form-control text-primary text-center fw-600 fs-4 mb-2" id="numeroTarjetaModal" name="numeroTarjeta" readonly required autocomplete="off">

                    <label class="fw-600" for="">Clabe interbancaria: </label>
                    <input type="text" class="form-control text-primary text-center fw-600 fs-4 mb-2" id="clabeModal" name="clabe" readonly required autocomplete="off">

                    <input type="hidden" id="idDB" name="idDB">

                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>

                    <?php
                    $filename =  basename($_SERVER["SCRIPT_FILENAME"]);
                    if ($filename != "pago-pos.php")
                    {
                    ?>
                        <button type="button" class="btn btn-success" id="jsEditar" onclick="javascript: habilitarEdicion();">
                            Permitir edición <i class="fas fa-edit ms-1"></i>
                        </button>
                    <?php
                    }
                    ?>
                    <button type="submit" class="btn btn-indigo" id="jsGuardar" name="btnActualizarDatosBancarios" style="display: none;">
                        Guardar
                    </button>
                </div>
                <script type="text/javascript">
                    function habilitarEdicion()
                    {

                        document.getElementById('jsGuardar').style.display = "block";
                        document.getElementById('jsEditar').style.display  = "none";

                        document.getElementById('bancoModal').removeAttribute('readonly');
                        document.getElementById('numeroTarjetaModal').removeAttribute('readonly');
                        document.getElementById('clabeModal').removeAttribute('readonly');

                    }
                </script>
          </form>
        </div>
    </div>
</div>
<!-- modal ver datos bancarios configuracion tienda Fin -->

<div class="modal fade" id="modalFes" tabindex="-1" aria-labelledby="modalFesLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="procesa.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title text-primary fw-600"><i class="fas fa-cash-register"></i> Cierre turno de caja</h5>
                    <button type="button" class="btn btn-icon btn-outline-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark fa-xl"></i>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="m-1 mb-2 text-center fs-4" id="salidaCuadreCaja"></div>

                    <input type="hidden" name="diferenciaCaja" id="diferenciaCaja">
                    <input type="hidden" name="efectivoFinalCaja" id="efectivoFinalCaja">

                    <div id="hideDescuadreCaja" style="display: none;" class="text-center">
                        <div class="form-check">
                            <input type="checkbox" name="checkDescuadreCaja" id="checkDescuadreCaja" value="1" required>
                            <label class="form-check-label text-primary" for="checkDescuadreCaja" style="cursor: pointer;" id="labelCuadreCaja"></label>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light rounded-2 fs-6" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#modalCierreTurnoCaja">
                        Regresar
                    </button>
                    <?php
                    if (isset($totalCajaEfectivo))
                    {
                      ?>
                    <button type="submit" class="btn btn-danger rounded-2 fs-6" onclick="validarCierreCaja('<?php echo $totalCajaEfectivo; ?>')" name="btnCierreTurnoCaja">
                        <!-- <i class="me-2 " data-feather="plus"></i>  -->
                        Cerrar turno <i class="ms-2 feather-lg" data-feather="log-out"></i>
                    </button>
                    <?php
                    }
                    ?>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- modal egreso efectivo caja -->
<div class="modal fade" id="modalCierreTurnoCaja" tabindex="-1" aria-labelledby="modalCierreTurnoCajaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="formCierreCaja" onsubmit="">
                <div class="modal-header">
                    <h5 class="modal-title text-danger fw-600"><i class="fas fa-lock me-1 text-dark-25"></i> Cierre turno de caja</h5>
                    <button type="button" class="btn btn-icon btn-outline-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark fa-xl"></i>
                    </button>
                </div>
                <div class="modal-body">

                  <div class="">
                      <div class="text-start fw-300 mb-2">
                          <?php
                              if (isset($response))
                              {
                                  echo "Turno iniciado desde el <span class='fw-500'>" . date("d/m/Y", strtotime($response['fechaApertura'])) . "</span> a las <span class='fw-500'>" . date("H:i", strtotime($response['fechaApertura'])) . "</span> hrs por " . $_SESSION['email'];
                              }
                          ?>
                      </div>
                      <div class="m-1 mb-2">

                          <label for="fechaInicio" class="text-dark text-center fw-500 mb-1">Ingresa el total de efectivo en caja:</label>
                          <div class="input-group mb-3">
                              <!-- <span class="input-group-text border border-2 border-success fs-4 fw-500 shadow-none text-center text-white bg-success" id="basic-addon1">$</span> -->
                              <input type="number" class="form-control border-2 text-success fs-4 fw-500 text-center" id="montoIngresoEfectivoCaja" min="0" step="0.1" name="montoCierreCaja" placeholder="0.00" oninput="validarDecimal(event)">
                          </div>

                      </div>
                  </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-light rounded-3" data-bs-dismiss="modal">
                        Cancelar
                    </a>
                    <?php
                    if (isset($totalCajaEfectivo))
                    {
                    ?>
                    <button type="button" id="btnContinuarModalCuadreCaja" class="btn btn-success rounded-3" onclick="validarCierreCaja('<?php echo $totalCajaEfectivo; ?>')" name="btnCierreTurnoCaja" value="Egreso">
                        <!-- <i class="me-2 " data-feather="plus"></i>  -->
                        Continuar <i class="ms-1" data-feather="arrow-right"></i>
                    </button>
                    <?php
                    }
                    ?>
                </div>
            </form>

            <script type="text/javascript">

                document.getElementById("formCierreCaja").addEventListener("keydown", function(event) {
                    if (event.keyCode === 13) { // 13 es el código de tecla para Enter
                        event.preventDefault(); // Cancela la acción predeterminada del formulario
                    }
                });


            </script>
        </div>
    </div>
</div>
<!-- Modal egreso efectivo caja Fin -->

<!-- modal Compartir Tienda -->
<div class="modal fade" id="modalCompartirTienda" tabindex="-1" aria-labelledby="modalCompartirTiendaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary fw-500">
                    <i class="me-1 feather-lg" data-feather="share-2"></i>
                    Compartir
                </h5>
                <button type="button" class="btn btn-icon btn-outline-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark fa-xl"></i>
                </button>
            </div>
            <div class="modal-body">

                <div class="text-center mb-2 text-center" style="">
                    <style>
                        svg#freepik_stories-in-no-time:not(.animated) .animable {opacity: 0;}svg#freepik_stories-in-no-time.animated #freepik--speech-bubble--inject-11 {animation: 1.5s Infinite  linear wind;animation-delay: 0s;}svg#freepik_stories-in-no-time.animated #freepik--character-2--inject-11 {animation: 1s 1 forwards cubic-bezier(.36,-0.01,.5,1.38) slideDown,1.5s Infinite  linear floating;animation-delay: 0s,1s;}svg#freepik_stories-in-no-time.animated #freepik--character-1--inject-11 {animation: 1s 1 forwards cubic-bezier(.36,-0.01,.5,1.38) slideUp;animation-delay: 0s;}            @keyframes wind {                0% {                    transform: rotate( 0deg );                }                25% {                    transform: rotate( 1deg );                }                75% {                    transform: rotate( -1deg );                }            }                    @keyframes slideDown {                0% {                    opacity: 0;                    transform: translateY(-30px);                }                100% {                    opacity: 1;                    transform: translateY(0);                }            }                    @keyframes floating {                0% {                    opacity: 1;                    transform: translateY(0px);                }                50% {                    transform: translateY(-10px);                }                100% {                    opacity: 1;                    transform: translateY(0px);                }            }                    @keyframes slideUp {                0% {                    opacity: 0;                    transform: translateY(30px);                }                100% {                    opacity: 1;                    transform: inherit;                }            }
                    </style>
                    <svg class="animated" id="freepik_stories-in-no-time" xmlns="http://www.w3.org/2000/svg" viewBox="-150 0 800 500" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs"><g id="freepik--Floor--inject-11" class="animable" style="transform-origin: 249.975px 342.733px;"><path d="M413.32,247.81c-90.8-52.43-237.54-52.43-327.76,0S-4.17,385.24,86.63,437.66s237.55,52.43,327.76,0S504.13,300.24,413.32,247.81Z" style="fill: rgb(245, 245, 245); transform-origin: 249.975px 342.733px;" id="eltsbzmvtunii" class="animable"></path></g><g id="freepik--Shadows--inject-11" class="animable" style="transform-origin: 262.339px 369.986px;"><path d="M446.11,340c6.7-3.86,17.52-3.86,24.18,0s6.62,10.13-.08,14-17.52,3.87-24.18,0S439.41,343.89,446.11,340Z" style="fill: rgb(224, 224, 224); transform-origin: 458.16px 347.004px;" id="el14mctaj55p7j" class="animable"></path><path d="M255.62,345.65l-12.39-16.84a14.68,14.68,0,0,0-10.69-5.94l-18.26-1.4-29-17.63,10.85-6.27a1,1,0,0,0,0-1.69l-4.51-2.57a5.88,5.88,0,0,0-5.84,0L79.43,354.8a1,1,0,0,0,0,1.69l4.4,2.54a5.86,5.86,0,0,0,5.87,0l46.16-26.66,28.61,16.41,3.74,10.53a16.63,16.63,0,0,0,15.66,11.05h26.7l18.12,10.46,43.78-25.45Z" style="fill: rgb(224, 224, 224); transform-origin: 175.717px 336.677px;" id="eldovmlm046g" class="animable"></path><path d="M418.52,330.11c-28.94-16.7-75.71-16.7-104.46,0-25.41,14.76-28.23,37.62-8.58,54.28-15.86-1-32.28,2-44.39,9.07-21.25,12.35-21.14,32.37.25,44.72s56,12.34,77.2,0c16.9-9.83,20.27-24.51,10.18-36.32,24.36,3.53,51.17-.22,70.15-11.24C447.62,373.92,447.47,346.83,418.52,330.11Z" style="fill: rgb(224, 224, 224); transform-origin: 342.779px 382.512px;" id="elnqofnqllkvl" class="animable"></path><path d="M82.58,376.23c-7.62-4.4-19.94-4.4-27.51,0s-7.53,11.54.09,15.94,19.94,4.4,27.51,0S90.21,380.63,82.58,376.23Z" style="fill: rgb(224, 224, 224); transform-origin: 68.8719px 384.2px;" id="el2ft73r4jr6s" class="animable"></path></g><g id="freepik--Windows--inject-11" class="animable" style="transform-origin: 111.21px 116.51px;"><polygon points="156.77 31.94 162.12 28.88 162.45 145.82 162.44 145.83 119.32 170.45 119.3 164.33 118.98 53.51 156.77 31.94" style="fill: rgb(240, 240, 240); transform-origin: 140.715px 99.665px;" id="elegk8mqefl9f" class="animable"></polygon><g id="el4pppqrikc8w"><polygon points="157.09 142.75 156.77 31.94 162.12 28.88 162.45 145.82 162.44 145.83 157.07 142.76 157.09 142.75" style="opacity: 0.1; transform-origin: 159.61px 87.355px;" class="animable" id="el01ugue3vohjd"></polygon></g><g id="elynugy8f5kna"><polygon points="119.3 164.33 157.07 142.76 162.44 145.83 119.32 170.45 119.3 164.33" style="opacity: 0.2; transform-origin: 140.87px 156.605px;" class="animable" id="eld0f2w6hxypn"></polygon></g><polygon points="97.76 65.63 103.11 62.57 103.44 179.51 103.43 179.52 60.31 204.14 60.29 198.02 59.97 87.2 97.76 65.63" style="fill: rgb(240, 240, 240); transform-origin: 81.705px 133.355px;" id="elniu74wucom" class="animable"></polygon><g id="el7qo983w2jxg"><polygon points="98.08 176.44 97.76 65.63 103.11 62.57 103.44 179.51 103.43 179.52 98.06 176.45 98.08 176.44" style="opacity: 0.1; transform-origin: 100.6px 121.045px;" class="animable" id="elw2jerm5f2x"></polygon></g><g id="elyzmxbtxacgk"><polygon points="60.29 198.02 98.06 176.45 103.43 179.52 60.31 204.14 60.29 198.02" style="opacity: 0.2; transform-origin: 81.86px 190.295px;" class="animable" id="elgnqh0ffh0qc"></polygon></g></g><g id="freepik--Clock--inject-11" class="animable" style="transform-origin: 292.385px 78.6887px;"><path d="M293.85,57h0a3.92,3.92,0,0,1-.32-.25h0Z" style="fill: none; transform-origin: 293.69px 56.875px;" id="elgbje62pk6c7" class="animable"></path><path d="M295.64,58.5l-.06,0,.06,0Z" style="fill: none; transform-origin: 295.61px 58.5px;" id="elagogk3jft5n" class="animable"></path><path d="M283,51.52c-.15,0-.3-.06-.45-.09l.43.08Z" style="fill: none; transform-origin: 282.775px 51.475px;" id="el0yztearb6c8" class="animable"></path><path d="M284.05,51.77l-.41-.1.39.1Z" style="fill: none; transform-origin: 283.845px 51.72px;" id="eltaogz7d5dm" class="animable"></path><path d="M288.36,53.47l0,0,0,0Z" style="fill: none; transform-origin: 288.36px 53.47px;" id="el0zvs0ixgow7" class="animable"></path><path d="M302.38,106.62q.44-.14.84-.3Q302.81,106.49,302.38,106.62Z" style="fill: none; transform-origin: 302.8px 106.47px;" id="elpbuaqq6pael" class="animable"></path><path d="M305.67,70.94h0l-.18-.31h0Z" style="fill: none; transform-origin: 305.58px 70.785px;" id="elwvs9udf0c3" class="animable"></path><path d="M304.57,69.13l-.22-.35h0Z" style="fill: none; transform-origin: 304.46px 68.955px;" id="els4i2x4q1nz" class="animable"></path><path d="M297.44,60.18l-.2-.18.2.18Z" style="fill: none; transform-origin: 297.34px 60.09px;" id="elg58qvtxo8j" class="animable"></path><polygon points="298.64 61.42 298.63 61.41 298.64 61.42 298.64 61.42" style="fill: none; transform-origin: 298.635px 61.415px;" id="el43f9mi3us8q" class="animable"></polygon><path d="M301.63,64.94l0,0h0Z" style="fill: none; transform-origin: 301.63px 64.94px;" id="elmkue4ar11v" class="animable"></path><path d="M300,107.06c.32,0,.62-.06.93-.11C300.61,107,300.31,107,300,107.06Z" style="fill: none; transform-origin: 300.465px 107.005px;" id="elqptuxm3am9" class="animable"></path><path d="M282.81,99c.47.45.94.9,1.43,1.32C283.75,99.86,283.28,99.41,282.81,99Z" style="fill: none; transform-origin: 283.525px 99.66px;" id="elenatntzyh9g" class="animable"></path><path d="M289.65,104.23c.45.26.89.49,1.33.71C290.54,104.72,290.1,104.49,289.65,104.23Z" style="fill: none; transform-origin: 290.315px 104.585px;" id="elntreb77fwxd" class="animable"></path><path d="M288,103.2c.54.36,1.09.71,1.64,1C289.1,103.91,288.55,103.56,288,103.2Z" style="fill: none; transform-origin: 288.82px 103.7px;" id="elig8ezbrccx" class="animable"></path><path d="M296.38,106.84l.48.09Z" style="fill: none; transform-origin: 296.62px 106.885px;" id="elg28q3omi5ft" class="animable"></path><path d="M307.58,74.53l-.06-.13h0Z" style="fill: none; transform-origin: 307.55px 74.465px;" id="ell880kf2vm5k" class="animable"></path><path d="M277.62,51.3h0Z" style="fill: none; transform-origin: 277.62px 51.3px;" id="eljhu2s1qtobd" class="animable"></path><path d="M280.78,51.19l-.29,0,.23,0Z" style="fill: none; transform-origin: 280.635px 51.19px;" id="ellvhbe0rykhi" class="animable"></path><path d="M278.86,51.17h0l-.26,0h0Z" style="fill: none; transform-origin: 278.73px 51.17px;" id="el5z43on510mc" class="animable"></path><path d="M282,51.32h0l-.47-.06.42,0Z" style="fill: none; transform-origin: 281.765px 51.29px;" id="elt0j1x1gj4b" class="animable"></path><path d="M276.17,51.62h0l-.17,0,.09,0Z" style="fill: none; transform-origin: 276.085px 51.62px;" id="el9fnztwsd5ud" class="animable"></path><path d="M275.12,52l-.16.06.14-.06Z" style="fill: none; transform-origin: 275.04px 52.03px;" id="elbb9k31chxwl" class="animable"></path><path d="M291.87,55.56l-.06-.05.06.05Z" style="fill: none; transform-origin: 291.84px 55.535px;" id="ela1lff3vwksk" class="animable"></path><path d="M312,97.57c0,.21-.07.43-.11.64C311.89,98,311.92,97.78,312,97.57Z" style="fill: none; transform-origin: 311.945px 97.89px;" id="elpshdpqpc7cn" class="animable"></path><path d="M311.45,99.81c-.05.19-.1.38-.16.57C311.35,100.19,311.4,100,311.45,99.81Z" style="fill: none; transform-origin: 311.37px 100.095px;" id="elug337m02hy" class="animable"></path><path d="M311.73,98.73c0,.2-.09.4-.14.59C311.64,99.13,311.69,98.93,311.73,98.73Z" style="fill: none; transform-origin: 311.66px 99.025px;" id="elomxqetl9le" class="animable"></path><path d="M310.74,101.82l-.21.5Z" style="fill: none; transform-origin: 310.635px 102.07px;" id="elu0zuukpsql" class="animable"></path><path d="M311.12,100.84c-.06.18-.12.36-.19.54C311,101.2,311.06,101,311.12,100.84Z" style="fill: none; transform-origin: 311.025px 101.11px;" id="elrwn1nph38ki" class="animable"></path><path d="M310.31,102.74c-.08.16-.15.32-.24.47C310.16,103.06,310.23,102.9,310.31,102.74Z" style="fill: none; transform-origin: 310.19px 102.975px;" id="elcmfawjm1czh" class="animable"></path><polygon points="310.18 80.91 310.18 80.9 310.18 80.91 310.18 80.91" style="fill: none; transform-origin: 310.18px 80.905px;" id="el2x91yhotfk2" class="animable"></polygon><path d="M289.79,54.24c.32.18.63.37.94.57C290.42,54.61,290.11,54.42,289.79,54.24Z" style="fill: none; transform-origin: 290.26px 54.525px;" id="el2go2ojr3sy8" class="animable"></path><path d="M312.26,95l-.06.85Z" style="fill: none; transform-origin: 312.23px 95.425px;" id="elj4ezdnyfxsg" class="animable"></path><path d="M312.14,96.31l-.09.74Z" style="fill: none; transform-origin: 312.095px 96.68px;" id="el3td2aprmn6y" class="animable"></path><path d="M312.32,93.26q0,.67,0,1.32Q312.32,93.94,312.32,93.26Z" style="fill: none; transform-origin: 312.32px 93.92px;" id="elpoywhjlht9b" class="animable"></path><path d="M312.26,91.3v-.13a.62.62,0,0,0,0,.13Z" style="fill: none; transform-origin: 312.258px 91.235px;" id="ely4esvlpfg1f" class="animable"></path><path d="M312,89l0-.25,0,.25Z" style="fill: none; transform-origin: 312px 88.875px;" id="elir36qw8fpl" class="animable"></path><path d="M307.81,106.18l.33-.34Z" style="fill: none; transform-origin: 307.975px 106.01px;" id="elkng2huewcqb" class="animable"></path><path d="M311.55,86l0-.14,0,.14Z" style="fill: none; transform-origin: 311.55px 85.93px;" id="el49ycg2zljxu" class="animable"></path><path d="M311.83,87.49h0c0-.2-.07-.4-.11-.61h0C311.76,87.09,311.79,87.29,311.83,87.49Z" style="fill: none; transform-origin: 311.775px 87.185px;" id="elux9t64nqw79" class="animable"></path><path d="M309.83,103.6c-.08.15-.17.3-.26.44C309.66,103.9,309.75,103.75,309.83,103.6Z" style="fill: none; transform-origin: 309.7px 103.82px;" id="ellw3huva6ale" class="animable"></path><path d="M306.81,107l-.38.28Z" style="fill: none; transform-origin: 306.62px 107.14px;" id="el7myv0rok4aq" class="animable"></path><path d="M308.75,105.15a3.79,3.79,0,0,1-.31.37A3.79,3.79,0,0,0,308.75,105.15Z" style="fill: none; transform-origin: 308.595px 105.335px;" id="elmtoui07p5y" class="animable"></path><path d="M309.31,104.41c-.09.13-.18.27-.28.4C309.13,104.68,309.22,104.54,309.31,104.41Z" style="fill: none; transform-origin: 309.17px 104.61px;" id="el7zqgbpe08f8" class="animable"></path><path d="M307.49,106.46a3.38,3.38,0,0,1-.35.31A3.38,3.38,0,0,0,307.49,106.46Z" style="fill: none; transform-origin: 307.315px 106.615px;" id="eluk0zztad9e" class="animable"></path><path d="M274.59,54.93l-.33.22Z" style="fill: none; transform-origin: 274.425px 55.04px;" id="elpkfcvnwt8da" class="animable"></path><path d="M271.45,81.43c-.22-.58-.43-1.16-.62-1.74.19.58.4,1.16.62,1.74Z" style="fill: none; transform-origin: 271.14px 80.56px;" id="eljpry9xkn8wj" class="animable"></path><path d="M270.78,79.55h0c-.2-.6-.38-1.2-.55-1.8h0C270.4,78.35,270.58,79,270.78,79.55Z" style="fill: none; transform-origin: 270.505px 78.65px;" id="elzzhf77p1lqb" class="animable"></path><path d="M306.46,103.73a9.5,9.5,0,0,1-.95.11l-.2,0c-.4,0-.8,0-1.21,0l-.28,0a11.44,11.44,0,0,1-1.4-.14c-.31,0-.62-.1-.94-.17l-.3-.08-.66-.16c-.37-.1-.75-.22-1.13-.35l-.23-.08-.92-.35-.35-.15-1-.46-.37-.18c-.44-.23-.88-.46-1.33-.72s-1.1-.67-1.65-1l-.27-.18c-.52-.36-1-.73-1.54-1.12l-.3-.23c-.51-.41-1-.82-1.52-1.26l-.13-.12c-.49-.43-1-.88-1.43-1.33-.08-.08-.16-.15-.23-.23-.36-.35-.72-.72-1.07-1.09l-.06-.06-1-1.09-.2-.24c-.53-.61-1-1.23-1.54-1.87l-.16-.21c-.4-.52-.78-1-1.16-1.58l-.17-.23c-.36-.52-.71-1-1.06-1.58l-.24-.38c-.28-.44-.55-.89-.81-1.33-.06-.1-.12-.19-.17-.29-.3-.51-.59-1-.87-1.55l-.2-.39c-.22-.42-.43-.84-.64-1.26-.07-.14-.14-.28-.2-.42-.26-.53-.5-1.06-.74-1.6l-.09-.23c-.21-.49-.41-1-.6-1.46-.06-.14-.11-.29-.17-.44-.22-.57-.43-1.15-.62-1.74,0,0,0-.09-.05-.14-.2-.6-.38-1.2-.55-1.79a3.57,3.57,0,0,0-.1-.35c-.19-.7-.36-1.4-.51-2.09,0-.16-.06-.31-.1-.46l-.15-.82c0-.19-.07-.38-.1-.57s-.09-.56-.13-.84-.05-.33-.07-.5c-.08-.6-.14-1.2-.18-1.79,0-.13,0-.25,0-.38,0-.61-.06-1.22-.06-1.82,0-5,1.34-8.81,3.59-11.34,3.37-.72,7.45.07,11.85,2.61,11.54,6.66,20.88,22.82,20.84,36.09,0,5-1.33,8.8-3.58,11.33l-.3.07Z" style="fill: none; transform-origin: 292.49px 78.5928px;" id="el675kgsdstvw" class="animable"></path><path d="M275.94,90.39c-.28-.43-.55-.88-.81-1.33.26.45.53.89.81,1.33Z" style="fill: none; transform-origin: 275.535px 89.725px;" id="eldaoutqgk21d" class="animable"></path><path d="M280.27,96.25c-.53-.61-1-1.23-1.54-1.87.5.64,1,1.26,1.54,1.87Z" style="fill: none; transform-origin: 279.5px 95.315px;" id="elgy346sm276a" class="animable"></path><path d="M273.25,85.58c.21.42.42.84.64,1.25C273.67,86.42,273.46,86,273.25,85.58Z" style="fill: none; transform-origin: 273.57px 86.205px;" id="elmp3ia3anfqb" class="animable"></path><path d="M275,88.78h0c-.3-.51-.59-1-.87-1.55h0C274.37,87.75,274.66,88.27,275,88.78Z" style="fill: none; transform-origin: 274.565px 88.005px;" id="elmzdn3kbr5w" class="animable"></path><path d="M304.28,105.82l.07,0c-.28.15-.57.29-.86.42h0C303.77,106.08,304,106,304.28,105.82Z" style="fill: none; transform-origin: 303.92px 106.03px;" id="elk94kas1jp1a" class="animable"></path><path d="M277.24,92.36c-.36-.52-.71-1-1.05-1.58.34.53.69,1.06,1.05,1.58Z" style="fill: none; transform-origin: 276.715px 91.57px;" id="elsdlgahunj8m" class="animable"></path><path d="M281.45,97.57c-.33-.35-.65-.71-1-1.08h0C280.8,96.86,281.12,97.22,281.45,97.57Z" style="fill: none; transform-origin: 280.95px 97.03px;" id="ellnkk2kdkds8" class="animable"></path><path d="M285.89,101.67c-.54-.43-1.08-.87-1.6-1.34a.6.6,0,0,0,.08.08C284.87,100.84,285.38,101.26,285.89,101.67Z" style="fill: none; transform-origin: 285.09px 101px;" id="el7ntluv6aqe7" class="animable"></path><path d="M287.73,103l.2.13c-.65-.44-1.3-.91-1.93-1.4l.19.15C286.7,102.29,287.21,102.66,287.73,103Z" style="fill: none; transform-origin: 286.965px 102.43px;" id="elhh8qv64vbqp" class="animable"></path><path d="M304.45,105.74h0Z" style="fill: none; transform-origin: 304.45px 105.74px;" id="ell7byfastgu" class="animable"></path><path d="M282.58,98.73c-.36-.35-.72-.72-1.07-1.09C281.86,98,282.22,98.38,282.58,98.73Z" style="fill: none; transform-origin: 282.045px 98.185px;" id="elw95iwit3q0h" class="animable"></path><path d="M292.35,105.58h0c-.41-.18-.81-.36-1.22-.57l.22.11Q291.86,105.37,292.35,105.58Z" style="fill: none; transform-origin: 291.74px 105.295px;" id="elpn7c87aczt" class="animable"></path><path d="M293.63,106.09l.23.08c.37.13.74.24,1.11.35a21.37,21.37,0,0,1-2.28-.79h0Z" style="fill: none; transform-origin: 293.83px 106.125px;" id="el6t0su0e3z35" class="animable"></path><path d="M298.28,107.07l-.66,0,.66,0Z" style="fill: none; transform-origin: 297.95px 107.07px;" id="elg7znts95p9" class="animable"></path><path d="M299.75,107.08c-.39,0-.8,0-1.21,0h0C299,107.1,299.36,107.1,299.75,107.08Z" style="fill: none; transform-origin: 299.145px 107.088px;" id="elmquo46gkh5d" class="animable"></path><path d="M302.23,106.67c-.34.09-.69.17-1,.24h0C301.56,106.84,301.9,106.76,302.23,106.67Z" style="fill: none; transform-origin: 301.73px 106.79px;" id="el9apacv309ub" class="animable"></path><path d="M295.92,106.75c-.12,0-.24-.06-.36-.09l.08,0Z" style="fill: none; transform-origin: 295.74px 106.705px;" id="elhwuhb9w4moh" class="animable"></path><path d="M278.57,94.16h0c-.4-.52-.78-1-1.16-1.58h0C277.79,93.13,278.17,93.65,278.57,94.16Z" style="fill: none; transform-origin: 277.99px 93.37px;" id="elulcx2e03ruo" class="animable"></path><path d="M271.59,57.83l-.24.34Z" style="fill: none; transform-origin: 271.47px 58px;" id="elomrl0om2l2j" class="animable"></path><path d="M272.12,57.14c-.09.11-.18.21-.26.32C271.94,57.35,272,57.25,272.12,57.14Z" style="fill: none; transform-origin: 271.99px 57.3px;" id="elouabyjdzko" class="animable"></path><path d="M271.11,58.58l-.22.36Z" style="fill: none; transform-origin: 271px 58.76px;" id="elkmuykik9i2" class="animable"></path><path d="M273.28,55.92l-.3.27Z" style="fill: none; transform-origin: 273.13px 56.055px;" id="eluqi9lval7y" class="animable"></path><path d="M273.92,55.4l-.32.24Z" style="fill: none; transform-origin: 273.76px 55.52px;" id="elsogvhphzlrj" class="animable"></path><path d="M272.68,56.5c-.09.1-.19.19-.28.3C272.49,56.69,272.59,56.6,272.68,56.5Z" style="fill: none; transform-origin: 272.54px 56.65px;" id="el2bl7l3nycex" class="animable"></path><path d="M271.62,81.87c.19.49.39,1,.6,1.46C272,82.84,271.81,82.36,271.62,81.87Z" style="fill: none; transform-origin: 271.92px 82.6px;" id="elitna0bze1sg" class="animable"></path><path d="M272.31,83.56c.24.54.48,1.07.74,1.6C272.79,84.63,272.55,84.1,272.31,83.56Z" style="fill: none; transform-origin: 272.68px 84.36px;" id="elh6423leixe" class="animable"></path><path d="M281.45,97.57c-.33-.35-.65-.71-1-1.08h0l-.21-.24h0c-.53-.61-1-1.23-1.54-1.87l-.16-.21h0c-.4-.51-.78-1-1.16-1.57h0l-.17-.23h0c-.36-.52-.71-1-1.05-1.58-.09-.13-.17-.26-.25-.39h0c-.28-.44-.55-.88-.81-1.33a2.61,2.61,0,0,1-.17-.28h0c-.3-.51-.59-1-.87-1.55h0l-.2-.4c-.22-.41-.43-.83-.64-1.25l-.2-.42c-.26-.53-.5-1.06-.74-1.6l-.09-.23c-.21-.49-.41-1-.6-1.46l-.17-.44h0c-.22-.58-.43-1.16-.62-1.74,0,0,0-.09-.05-.14h0c-.2-.6-.38-1.2-.55-1.8h0l-.09-.34c-.2-.7-.37-1.4-.52-2.09h0c0-.16-.06-.31-.1-.46l-.15-.82c0-.17-.07-.34-.09-.52v0c0-.28-.09-.56-.13-.84s-.05-.33-.07-.5c-.08-.6-.13-1.2-.18-1.79,0-.13,0-.26,0-.38,0-.61-.06-1.22-.06-1.82,0-.41,0-.82,0-1.21l0-.45c0-.24,0-.49.06-.72s0-.3.05-.45,0-.46.08-.68.06-.31.08-.46.07-.41.11-.61.07-.31.1-.47.09-.37.13-.56.09-.3.13-.45.1-.35.16-.52l.15-.44c.06-.16.11-.33.18-.49s.12-.27.17-.41.13-.31.2-.46.13-.26.2-.39.14-.29.22-.43l.22-.36.24-.41.24-.34c.09-.12.17-.25.27-.37s.17-.21.26-.32.18-.23.28-.34.19-.2.28-.3l.3-.31.3-.27.32-.28.32-.24.34-.25.33-.22a10.35,10.35,0,0,1,3.35-1.35c-2.25,2.53-3.57,6.38-3.59,11.34,0,.6,0,1.21.06,1.82,0,.13,0,.25,0,.38,0,.59.1,1.19.18,1.79,0,.17.05.34.07.5s.08.56.13.84.06.38.1.57l.15.82c0,.15.07.3.1.46.15.69.32,1.39.51,2.09a3.57,3.57,0,0,1,.1.35c.17.59.35,1.19.55,1.79,0,0,0,.1.05.14.19.59.4,1.17.62,1.74.06.15.11.3.17.44.19.49.39,1,.6,1.46l.09.23c.24.54.48,1.07.74,1.6.06.14.13.28.2.42.21.42.42.84.64,1.26l.2.39c.28.52.57,1,.87,1.55.05.1.11.19.17.29.26.44.53.89.81,1.33l.24.38c.35.53.7,1.06,1.06,1.58l.17.23c.38.54.76,1.06,1.16,1.58l.16.21c.5.64,1,1.26,1.54,1.87l.2.24,1,1.09.06.06c.35.37.71.74,1.07,1.09.07.08.15.15.23.23.47.45.94.9,1.43,1.33l.13.12c.5.44,1,.85,1.52,1.26l.3.23c.5.39,1,.76,1.54,1.12l.27.18c.55.36,1.1.71,1.65,1s.89.49,1.33.72l.37.18,1,.46.35.15.92.35.23.08c.38.13.76.25,1.13.35l.66.16.3.08c.32.07.63.12.94.17a11.44,11.44,0,0,0,1.4.14l.28,0c.41,0,.81,0,1.21,0l.2,0a9.5,9.5,0,0,0,.95-.11l.29,0,.3-.07a10.25,10.25,0,0,1-2.59,2.12h0l-.1.05-.07,0c-.25.14-.51.26-.77.38h0l-.27.11q-.41.17-.84.3l-.15,0c-.33.09-.67.17-1,.23h0l-.27,0c-.31,0-.61.08-.93.11l-.24,0c-.39,0-.79,0-1.19,0h0l-.26,0h0l-.66,0-.76-.09-.48-.09-.46-.09-.28-.07-.08,0-.59-.14c-.37-.11-.74-.22-1.11-.35l-.23-.08-.93-.35h0l-.33-.14h0q-.5-.21-1-.45l-.22-.11a.8.8,0,0,1-.16-.08c-.44-.22-.88-.45-1.33-.71s-1.1-.67-1.64-1l-.08,0-.2-.13c-.52-.36-1-.73-1.54-1.12l-.19-.15-.11-.08c-.51-.41-1-.83-1.52-1.26a.6.6,0,0,1-.08-.08l-.05,0c-.49-.42-1-.87-1.43-1.32l-.23-.23c-.36-.35-.72-.72-1.07-1.09Z" style="fill: rgb(235, 235, 235); transform-origin: 287.9px 80.32px;" id="elax20vpkggoi" class="animable"></path><polygon points="306.7 86.16 306.7 87.45 310.33 89.54 310.33 88.25 306.7 86.16" style="fill: rgb(255, 255, 255); transform-origin: 308.515px 87.85px;" id="el4f4qn0cy5kr" class="animable"></polygon><polygon points="277.35 59.04 276.79 59.82 279.93 63.73 280.49 62.94 277.35 59.04" style="fill: rgb(255, 255, 255); transform-origin: 278.64px 61.385px;" id="elnqvzlyyhup" class="animable"></polygon><path d="M313.4,90.67c0,13.27-9.43,18.62-21,12S271.55,79.8,271.58,66.53s9.43-18.62,21-12S313.44,77.4,313.4,90.67ZM283,77.86a1.25,1.25,0,0,0,.52.68.47.47,0,0,0,.22.07l8.88.7a.29.29,0,0,0,.33-.13l5.81-9.85a1,1,0,0,0-.25-1,1,1,0,0,0-.25-.21c-.2-.11-.4-.1-.5.07l-5.71,9.69-8.75-.69c-.28,0-.42.28-.3.68m17.08-8.7,1.82-2.56-1-1.2L299.15,68l1,1.2m.75,32.38,1-.08L300,96.8l-1,.08,1.8,4.66M277.29,80.65l3.15-.27-.55-1.44-3.16.27.56,1.44m30.34,17.52.56-.79-3.14-3.91-.56.79,3.14,3.91M277.35,59l-.56.78,3.14,3.91.56-.79L277.35,59M305.1,78.26l3.15-.27-.56-1.43-3.15.26.56,1.44m-21-22.6-1,.08,1.8,4.66,1-.08-1.81-4.66M284,91.8l1.83-2.57-1-1.19L283,90.6l1,1.2M278.28,71V69.75l-3.63-2.09v1.28l3.63,2.1m32.05,17.22-3.63-2.1v1.29l3.63,2.09V88.26M291.88,98.78l1.11.64V95.25l-1.11-.65v4.18m1.23-40.36L292,57.78V62l1.11.65,0-4.18" style="fill: rgb(224, 224, 224); transform-origin: 292.49px 78.6px;" id="elmv865ff3ex9" class="animable"></path><polygon points="291.99 57.78 291.98 61.95 293.09 62.6 293.11 58.42 291.99 57.78" style="fill: rgb(255, 255, 255); transform-origin: 292.545px 60.19px;" id="eliua3696nb5k" class="animable"></polygon><polygon points="300.98 65.4 299.15 67.96 300.12 69.16 301.94 66.6 300.98 65.4" style="fill: rgb(255, 255, 255); transform-origin: 300.545px 67.28px;" id="el1jbcahblon9" class="animable"></polygon><polygon points="307.69 76.56 304.54 76.82 305.1 78.26 308.25 77.99 307.69 76.56" style="fill: rgb(255, 255, 255); transform-origin: 306.395px 77.41px;" id="eleo2b9mcrkls" class="animable"></polygon><polygon points="305.05 93.47 304.49 94.26 307.63 98.17 308.19 97.38 305.05 93.47" style="fill: rgb(255, 255, 255); transform-origin: 306.34px 95.82px;" id="elpxcxw0bpe3b" class="animable"></polygon><polygon points="300.04 96.8 299.07 96.88 300.87 101.54 301.84 101.46 300.04 96.8" style="fill: rgb(255, 255, 255); transform-origin: 300.455px 99.17px;" id="el1wavm1f7pot" class="animable"></polygon><polygon points="291.89 94.6 291.88 98.78 292.99 99.42 293 95.25 291.89 94.6" style="fill: rgb(255, 255, 255); transform-origin: 292.44px 97.01px;" id="elbjuznmasahf" class="animable"></polygon><polygon points="284.87 88.04 283.04 90.6 284 91.8 285.83 89.23 284.87 88.04" style="fill: rgb(255, 255, 255); transform-origin: 284.435px 89.92px;" id="el8e8oo8toaiw" class="animable"></polygon><polygon points="279.88 78.94 276.73 79.21 277.29 80.65 280.44 80.38 279.88 78.94" style="fill: rgb(255, 255, 255); transform-origin: 278.585px 79.795px;" id="elmvawsybo6yf" class="animable"></polygon><polygon points="274.65 67.66 274.65 68.94 278.28 71.04 278.28 69.75 274.65 67.66" style="fill: rgb(255, 255, 255); transform-origin: 276.465px 69.35px;" id="el96x4hfp66p" class="animable"></polygon><polygon points="284.1 55.66 283.14 55.74 284.94 60.4 285.91 60.32 284.1 55.66" style="fill: rgb(255, 255, 255); transform-origin: 284.525px 58.03px;" id="elyt0bdhdnsan" class="animable"></polygon><path d="M292.49,78a.47.47,0,0,0-.22-.07l-.18,0-8.75-.69c-.28,0-.42.28-.3.68a1.25,1.25,0,0,0,.52.68.47.47,0,0,0,.22.07l8.88.7h0c.28,0,.41-.27.29-.67A1.2,1.2,0,0,0,292.49,78Z" style="fill: rgb(255, 255, 255); transform-origin: 287.996px 78.305px;" id="el6de8u34ru3j" class="animable"></path><path d="M298.3,68.11c-.2-.11-.4-.1-.5.07l-5.71,9.69.18,0a.47.47,0,0,1,.22.07,1.2,1.2,0,0,1,.51.68c.12.4,0,.7-.29.67h0a.29.29,0,0,0,.33-.13l5.81-9.85a1,1,0,0,0-.25-1A1,1,0,0,0,298.3,68.11Z" style="fill: rgb(245, 245, 245); transform-origin: 295.492px 73.6697px;" id="elnsz9rfh6aui" class="animable"></path><path d="M306.81,107l.33-.26a3.38,3.38,0,0,0,.35-.31c.11-.09.22-.18.32-.28l.33-.34.3-.32a3.79,3.79,0,0,0,.31-.37c.09-.11.19-.22.28-.34s.19-.27.28-.4.18-.24.26-.37.18-.29.26-.44.17-.26.24-.39.16-.31.24-.47l.22-.42.21-.5c.06-.15.13-.29.19-.44s.13-.36.19-.54.12-.31.17-.46.11-.38.16-.57.1-.32.14-.49.1-.39.14-.59l.12-.52c0-.21.07-.43.11-.64l.09-.52.09-.74.06-.47.06-.85,0-.41q0-.64,0-1.32c0-.65,0-1.3-.06-2h0a.62.62,0,0,1,0-.13c-.05-.73-.11-1.47-.21-2.22h0l0-.25-.18-1.21h0c0-.2-.07-.4-.11-.61h0c-.06-.29-.11-.59-.17-.89h0l0-.14a44.67,44.67,0,0,0-1.34-4.94h0a51,51,0,0,0-2.6-6.37l-.06-.13h0c-.58-1.17-1.19-2.33-1.85-3.46h0l-.18-.31h0c-.3-.51-.61-1-.92-1.5l-.22-.35h0c-.86-1.33-1.76-2.61-2.72-3.84l0,0h0q-1.41-1.81-3-3.47h0c-.39-.42-.79-.82-1.19-1.23h0l-.2-.18c-.52-.52-1.05-1-1.6-1.5h0l-.06,0c-.56-.5-1.14-1-1.72-1.44h0l-.31-.25h0c-.55-.42-1.1-.82-1.67-1.2h0l-.06-.05c-.36-.24-.72-.48-1.08-.7s-.62-.39-.94-.57c-.48-.28-1-.53-1.43-.77h0l0,0a23.55,23.55,0,0,0-4.27-1.68h0l-.39-.1-.62-.15h0l-.43-.08-.58-.1h-.05l-.42,0-.74-.08h-.06l-.23,0a14.41,14.41,0,0,0-1.61,0h0l-.23,0h0c-.34,0-.68.06-1,.11h0a10.53,10.53,0,0,0-1.4.3h-.08l-.09,0c-.31.1-.61.21-.91.33h0l-.14.06c-.41.18-.82.37-1.21.59l0,0,5.54-3.22.12-.07.15-.08c.27-.14.55-.28.83-.4a1.19,1.19,0,0,1,.16-.08l.13,0q.5-.2,1-.36h0a10.88,10.88,0,0,1,1.13-.26l.13,0,.18,0a8.86,8.86,0,0,1,1-.12l.17,0h.05a11.43,11.43,0,0,1,1.31,0h.13l.43,0,.3,0c.3,0,.61.06.92.11h0l1,.19.32.08.65.16.06,0c.4.11.81.23,1.22.37l.25.1c.33.11.66.24,1,.38l.14.05.25.11c.35.15.71.32,1.07.49l.41.2c.47.24,1,.49,1.43.77s1.19.72,1.78,1.12l.3.2c.56.38,1.12.78,1.67,1.2l.31.25c.56.44,1.11.89,1.65,1.37a.86.86,0,0,1,.14.13c.53.46,1,.94,1.55,1.44l.15.14.1.1c.39.38.77.77,1.15,1.18l.06.06c.36.39.71.78,1.06,1.18l.1.11.12.15c.57.66,1.13,1.33,1.67,2l0,.06a1.67,1.67,0,0,1,.12.16q.65.84,1.26,1.71l.13.17a.41.41,0,0,1,.05.09c.4.55.78,1.12,1.15,1.7a.91.91,0,0,0,.11.16l.15.26c.3.47.59,1,.88,1.43l.13.22a.41.41,0,0,1,0,.09c.33.56.64,1.12.94,1.68l.07.14.15.28.69,1.36c0,.09.09.19.14.28s.05.12.08.17c.27.58.54,1.16.79,1.74l0,0a1.34,1.34,0,0,0,.07.18c.23.53.44,1.06.65,1.59,0,.09.07.17.11.26s.05.14.07.22c.24.62.47,1.25.68,1.88v0l0,.11q.33,1,.6,2l.07.25a.65.65,0,0,1,0,.13c.2.76.39,1.51.55,2.26a1.46,1.46,0,0,1,0,.2l.06.3c.06.29.11.59.17.88s.07.41.11.62.09.61.13.91c0,.14.05.28.07.43a.45.45,0,0,0,0,.11c.08.65.14,1.3.19,1.94,0,.14,0,.27,0,.41,0,.66.07,1.31.07,2,0,7.13-2.54,12.14-6.59,14.5l-5.54,3.22.35-.23c.12-.07.24-.14.35-.22Z" style="fill: rgb(235, 235, 235); transform-origin: 295.785px 77.9906px;" id="elbqsszjo00zr" class="animable"></path><path d="M267.12,67.16c0,14.34,10,31.81,22.53,39,6.46,3.73,12.3,4,16.43,1.35.12-.07.24-.14.35-.22l.38-.28.33-.26a3.38,3.38,0,0,0,.35-.31c.11-.09.22-.18.32-.28l.33-.34.3-.32a3.79,3.79,0,0,0,.31-.37c.09-.11.19-.22.28-.34s.19-.27.28-.4.18-.24.26-.37.18-.29.26-.44.17-.26.24-.39.16-.31.24-.47l.22-.42.21-.5c.06-.15.13-.29.19-.44s.13-.36.19-.54.12-.31.17-.46.11-.38.16-.57.1-.32.14-.49.1-.39.14-.59l.12-.52c0-.21.07-.43.11-.64l.09-.52.09-.74.06-.47.06-.85,0-.41q0-.64,0-1.32c0-.65,0-1.3-.06-2v-.13c-.05-.73-.11-1.47-.21-2.22l0-.25-.18-1.21c0-.2-.07-.4-.11-.61s-.11-.59-.17-.89l0-.14a44.67,44.67,0,0,0-1.34-4.94h0a51,51,0,0,0-2.6-6.37l-.06-.13c-.58-1.17-1.19-2.33-1.85-3.46l-.18-.31c-.3-.51-.61-1-.92-1.5l-.22-.35c-.86-1.33-1.76-2.61-2.72-3.84l0,0q-1.41-1.81-3-3.47h0c-.39-.42-.79-.82-1.19-1.23l-.2-.18c-.52-.52-1.05-1-1.6-1.5l-.06,0c-.56-.5-1.14-1-1.72-1.44a3.92,3.92,0,0,1-.32-.25c-.55-.42-1.1-.82-1.67-1.2l-.06-.05c-.36-.24-.72-.48-1.08-.7s-.62-.39-.94-.57c-.48-.28-1-.53-1.43-.77l0,0a23.55,23.55,0,0,0-4.27-1.68l-.41-.1-.62-.15c-.15,0-.3-.06-.45-.09l-.58-.1-.47-.06-.74-.08-.29,0a14.41,14.41,0,0,0-1.61,0l-.26,0c-.34,0-.68.06-1,.11h0a10.53,10.53,0,0,0-1.4.3l-.17,0c-.31.1-.61.21-.91.33l-.16.06c-.41.18-.82.37-1.21.59C269.67,55,267.14,60,267.12,67.16Zm14.39,30.48-.06-.07c-.33-.35-.65-.71-1-1.08l-.21-.24c-.53-.61-1-1.23-1.54-1.87l-.16-.21c-.4-.52-.78-1-1.16-1.58l-.17-.23c-.36-.52-.71-1-1.05-1.58-.09-.13-.17-.26-.25-.39-.28-.43-.55-.88-.81-1.33a2.61,2.61,0,0,1-.17-.28c-.3-.51-.59-1-.87-1.55l-.2-.4c-.22-.41-.43-.83-.64-1.25l-.2-.42c-.26-.53-.5-1.06-.74-1.6l-.09-.23c-.21-.49-.41-1-.6-1.46l-.17-.44c-.22-.58-.43-1.16-.62-1.74,0,0,0-.09-.05-.14-.2-.6-.38-1.2-.55-1.8l-.09-.34c-.2-.7-.37-1.4-.52-2.09,0-.16-.06-.31-.1-.46l-.15-.82c0-.17-.07-.34-.09-.52s-.1-.59-.14-.89-.05-.33-.07-.5c-.08-.6-.13-1.2-.18-1.79,0-.13,0-.26,0-.38,0-.61-.06-1.22-.06-1.82,0-.41,0-.82,0-1.21l0-.45c0-.24,0-.49.06-.72s0-.3.05-.45,0-.46.08-.68.06-.31.08-.46.07-.41.11-.61.07-.31.1-.47.09-.37.13-.56.09-.3.13-.45.1-.35.16-.52l.15-.44c.06-.16.11-.33.18-.49s.12-.27.17-.41.13-.31.2-.46.13-.26.2-.39.14-.29.22-.43l.22-.36.24-.41.24-.34c.09-.12.17-.25.27-.37s.17-.21.26-.32.18-.23.28-.34.19-.2.28-.3l.3-.31.3-.27.32-.28.32-.24.34-.25.33-.22a10.35,10.35,0,0,1,3.35-1.35c3.37-.72,7.45.07,11.85,2.61,11.54,6.66,20.88,22.82,20.84,36.09,0,5-1.33,8.8-3.58,11.33a10.25,10.25,0,0,1-2.59,2.12h0l-.1.05c-.28.15-.57.29-.86.42l-.27.11q-.41.17-.84.3l-.15,0c-.34.09-.69.17-1,.24l-.27,0c-.31,0-.61.08-.93.11l-.24,0c-.39,0-.8,0-1.21,0l-.26,0-.66,0-.76-.09-.48-.09-.46-.09c-.12,0-.24-.06-.36-.09l-.59-.14a21.37,21.37,0,0,1-2.28-.79l-.33-.14c-.41-.18-.81-.36-1.22-.57a.8.8,0,0,1-.16-.08c-.44-.22-.88-.45-1.33-.71s-1.1-.67-1.64-1l-.08,0c-.65-.44-1.3-.91-1.93-1.4l-.11-.08c-.54-.43-1.08-.87-1.6-1.34l-.05,0c-.49-.42-1-.87-1.43-1.32l-.23-.23C282.22,98.38,281.86,98,281.51,97.64Z" style="fill: rgb(255, 255, 255); transform-origin: 289.69px 80.2569px;" id="elzoef90ykxn" class="animable"></path></g><g id="freepik--Pictures--inject-11" class="animable" style="transform-origin: 441.94px 140.18px;"><polygon points="426.09 143.34 456.66 160.99 456.59 184.35 426.03 166.7 426.09 143.34" style="fill: none; transform-origin: 441.345px 163.845px;" id="el8gajphf724i" class="animable"></polygon><polygon points="426.09 143.34 426.03 166.7 423.2 168.35 423.27 141.72 426.09 143.34" style="fill: rgb(240, 240, 240); transform-origin: 424.645px 155.035px;" id="elyayof4nlq2k" class="animable"></polygon><polygon points="456.59 184.35 456.58 187.62 423.2 168.35 426.03 166.7 456.59 184.35" style="fill: rgb(245, 245, 245); transform-origin: 439.895px 177.16px;" id="elqkgqdqkpt8" class="animable"></polygon><path d="M419.76,170.3,460,193.53l.1-34.49-40.23-23.23Zm3.44-2,.07-26.64,2.82,1.63L456.66,161l-.07,23.36v3.27Z" style="fill: rgb(224, 224, 224); transform-origin: 439.93px 164.67px;" id="elr86soiquqa" class="animable"></path><polygon points="419.86 135.81 422.69 134.17 462.92 157.4 460.09 159.04 419.86 135.81" style="fill: rgb(245, 245, 245); transform-origin: 441.39px 146.605px;" id="elye8hveq6x2" class="animable"></polygon><polygon points="462.92 157.4 462.82 191.88 459.99 193.53 460.09 159.04 462.92 157.4" style="fill: rgb(240, 240, 240); transform-origin: 461.455px 175.465px;" id="el9bn8wzatve" class="animable"></polygon><polygon points="427.29 96.01 457.86 113.66 457.79 137.01 427.23 119.37 427.29 96.01" style="fill: none; transform-origin: 442.545px 116.51px;" id="ellpk5go4dx" class="animable"></polygon><polygon points="427.29 96.01 427.23 119.37 424.39 121.01 424.47 94.38 427.29 96.01" style="fill: rgb(240, 240, 240); transform-origin: 425.84px 107.695px;" id="ela0hogptjves" class="animable"></polygon><polygon points="457.79 137.01 457.78 140.29 424.39 121.01 427.23 119.37 457.79 137.01" style="fill: rgb(245, 245, 245); transform-origin: 441.09px 129.83px;" id="elfi93ycop1xg" class="animable"></polygon><path d="M421,123l40.23,23.23.1-34.49L421.06,88.48Zm3.43-2,.08-26.63L427.29,96l30.57,17.65L457.79,137v3.28Z" style="fill: rgb(224, 224, 224); transform-origin: 441.165px 117.355px;" id="eld1rorlt2fyg" class="animable"></path><polygon points="421.06 88.48 423.89 86.83 464.12 110.06 461.29 111.71 421.06 88.48" style="fill: rgb(245, 245, 245); transform-origin: 442.59px 99.27px;" id="ele1f4nfakwog" class="animable"></polygon><polygon points="464.12 110.06 464.02 144.55 461.19 146.19 461.29 111.71 464.12 110.06" style="fill: rgb(240, 240, 240); transform-origin: 462.655px 128.125px;" id="elq3i201jm5f" class="animable"></polygon><polygon points="435.81 152.21 427.47 158.78 427.45 165.19 455.17 181.19 455.19 174.78 449.91 164.29 445.17 167.97 446.84 173.18 444.41 168.56 435.81 152.21" style="fill: rgb(224, 224, 224); transform-origin: 441.32px 166.7px;" id="el8bxe6srzy0b" class="animable"></polygon><path d="M444.91,155.44c-1.3-.75-2.37-.14-2.37,1.36a5.17,5.17,0,0,0,2.36,4.07c1.3.76,2.36.15,2.37-1.35A5.2,5.2,0,0,0,444.91,155.44Z" style="fill: rgb(224, 224, 224); transform-origin: 444.905px 158.158px;" id="elb2rhn6dmoc" class="animable"></path><polygon points="437 104.88 428.67 111.44 428.65 117.85 456.37 133.86 456.39 127.45 451.11 116.95 446.36 120.64 448.04 125.85 445.61 121.22 437 104.88" style="fill: rgb(224, 224, 224); transform-origin: 442.52px 119.37px;" id="el6xafnbiresd" class="animable"></polygon><path d="M446.11,108.11c-1.31-.75-2.37-.15-2.37,1.35a5.18,5.18,0,0,0,2.35,4.08c1.31.75,2.37.15,2.37-1.35A5.18,5.18,0,0,0,446.11,108.11Z" style="fill: rgb(224, 224, 224); transform-origin: 446.1px 110.825px;" id="el2u4orr2xdxa" class="animable"></path></g><g id="freepik--speech-bubble--inject-11" class="animable" style="transform-origin: 369.09px 122.312px;"><path d="M342.5,69.11l59.87,34.62a6.69,6.69,0,0,1,3.34,5.77v60.2a6.57,6.57,0,0,1-10,5.41l-25-14.84-.54.87s-.05.05-.08.08h0l-.06,0h0c-1,.65-2.69,1.57-3.07,1.77v0a.36.36,0,0,1-.45-.22l-2.18-6.18h0L335.8,140.57a6.65,6.65,0,0,1-3.35-5.77V74.52C332.45,69.72,339.51,67.39,342.5,69.11Z" style="fill: #FF944C; transform-origin: 369.08px 122.312px;" id="el5vi5rsmscft" class="animable"></path><path d="M396.45,107.77Z" style="fill: none; transform-origin: 396.45px 107.77px;" id="el18k368hzfgvi" class="animable"></path><g id="els69jk8u40vn"><path d="M370.08,161.14s-.05.05-.08.08h0l-.06,0h0c-1,.65-2.69,1.57-3.07,1.77v0a.31.31,0,0,0,.22-.15l2.11-3.42-.42-.24h0l1.86,1.06Z" style="fill: rgb(255, 255, 255); opacity: 0.2; transform-origin: 368.755px 161.085px;" class="animable" id="el3ws7hteux9s"></path></g><g id="elm7gdgioy03"><path d="M398.23,110a6.86,6.86,0,0,0-1.78-2.23h0a6.08,6.08,0,0,0-.81-.55L335.77,72.59a2.22,2.22,0,0,0-3.32,1.93c0-4.8,7.06-7.13,10.05-5.41l59.87,34.62a6.71,6.71,0,0,1,2.48,2.51Z" style="fill: rgb(255, 255, 255); opacity: 0.4; transform-origin: 368.65px 89.273px;" class="animable" id="el25ivea1ctgs"></path></g><g id="elebftgxehzr"><path d="M399,173.19V113a6.36,6.36,0,0,0-.75-3l6.62-3.76a6.67,6.67,0,0,1,.86,3.26v60.2a6.57,6.57,0,0,1-10,5.41A2.22,2.22,0,0,0,399,173.19Z" style="fill: rgb(255, 255, 255); opacity: 0.2; transform-origin: 400.73px 141.159px;" class="animable" id="elfh02hbrbpzd"></path></g><path d="M347.11,97.32l34.75,20.06-2.09,23.82c-.12,1.45-1.24,2-2.57,1.2L350.58,127a4.87,4.87,0,0,1-1.37-1.25l.05.68a10.22,10.22,0,0,0,4.6,7.5l1.17.67a4.53,4.53,0,0,1,1.25.5,6.17,6.17,0,0,1,1.25,1L370,143.3a4.14,4.14,0,0,1,1.25.5,6.5,6.5,0,0,1,1.25.94l2.65,1.53a2.26,2.26,0,0,1,1,1.78c0,.65-.47.91-1,.59l-.21-.12a7.08,7.08,0,0,1,.46,2.47c0,2.64-1.87,3.71-4.18,2.38a9.18,9.18,0,0,1-4.15-7.19,3.67,3.67,0,0,1,.48-1.93l-7.62-4.4a7.41,7.41,0,0,1,.46,2.47c0,2.65-1.88,3.71-4.18,2.38a9.12,9.12,0,0,1-4.15-7.19,3.61,3.61,0,0,1,.53-2,15.08,15.08,0,0,1-5.42-10l-2.36-32a4.54,4.54,0,0,0-2.05-3.33l-4.3-2.49a2.26,2.26,0,0,1-1-1.77c0-.66.47-.92,1-.59l4.3,2.48a9.11,9.11,0,0,1,4.09,6.67Zm18.19,33.91.05-19.08a3.08,3.08,0,0,0-1.39-2.41c-.77-.44-1.39-.09-1.4.8l-.05,19.08A3.09,3.09,0,0,0,363.9,132c.77.44,1.4.08,1.4-.8m6,3.48.05-19.08a3.08,3.08,0,0,0-1.39-2.41c-.77-.44-1.4-.09-1.4.8l0,19.08a3.06,3.06,0,0,0,1.39,2.41c.77.44,1.39.08,1.4-.8m6,3.48.06-19.08A3.08,3.08,0,0,0,376,116.7c-.77-.44-1.4-.09-1.4.8l-.05,19.08A3.06,3.06,0,0,0,376,139c.76.44,1.39.08,1.39-.8m-18.08-10.44.05-19.08a3,3,0,0,0-1.39-2.41c-.77-.44-1.39-.09-1.4.8l0,19.08a3.09,3.09,0,0,0,1.39,2.41c.77.44,1.4.08,1.4-.8m-6-3.48.06-19.08a3.1,3.1,0,0,0-1.39-2.41c-.77-.44-1.4-.09-1.4.8l-.06,19.08a3.06,3.06,0,0,0,1.39,2.4c.77.45,1.4.09,1.4-.79m3,13.85c-.86-.5-1.56-.1-1.57.89a3.46,3.46,0,0,0,1.56,2.7c.87.5,1.56.1,1.57-.89a3.43,3.43,0,0,0-1.56-2.7m15,8.67c-.86-.5-1.56-.1-1.56.89a3.42,3.42,0,0,0,1.55,2.7c.86.5,1.57.1,1.57-.9a3.44,3.44,0,0,0-1.56-2.69" style="fill: rgb(255, 255, 255); transform-origin: 359.66px 119.564px;" id="el48xibmnhv7m" class="animable"></path><path d="M391.81,117.89a3,3,0,0,1,1.07,1.12c.59,1,.59,2.12,0,2.45l-8.83,5a1.06,1.06,0,0,1-1.07-.11,3.13,3.13,0,0,1-1.07-1.12l-4.32-7.5c-.6-1-.59-2.12,0-2.46a1.08,1.08,0,0,1,1.07.11,3.13,3.13,0,0,1,1.07,1.12L383,122.2l7.76-4.42A1.06,1.06,0,0,1,391.81,117.89Z" style="fill: rgb(255, 255, 255); transform-origin: 385.233px 120.867px;" id="el6eqpckr8rib" class="animable"></path><path d="M385.25,108.64c5.89,3.4,10.64,11.64,10.62,18.4s-4.8,9.48-10.69,6.08-10.63-11.62-10.61-18.39S379.37,105.25,385.25,108.64ZM384,126.5l8.83-5c.6-.33.6-1.43,0-2.45a3,3,0,0,0-1.07-1.12,1.06,1.06,0,0,0-1.07-.11L383,122.2l-3.26-5.66a3.13,3.13,0,0,0-1.07-1.12,1.08,1.08,0,0,0-1.07-.11c-.59.34-.6,1.43,0,2.46l4.32,7.5a3.13,3.13,0,0,0,1.07,1.12,1.06,1.06,0,0,0,1.07.11" style="fill: #FF944C; transform-origin: 385.22px 120.882px;" id="ely0ex42u19e" class="animable"></path><g id="eloxp1h06cdzb"><path d="M385.25,108.64c5.89,3.4,10.64,11.64,10.62,18.4s-4.8,9.48-10.69,6.08-10.63-11.62-10.61-18.39S379.37,105.25,385.25,108.64ZM384,126.5l8.83-5c.6-.33.6-1.43,0-2.45a3,3,0,0,0-1.07-1.12,1.06,1.06,0,0,0-1.07-.11L383,122.2l-3.26-5.66a3.13,3.13,0,0,0-1.07-1.12,1.08,1.08,0,0,0-1.07-.11c-.59.34-.6,1.43,0,2.46l4.32,7.5a3.13,3.13,0,0,0,1.07,1.12,1.06,1.06,0,0,0,1.07.11" style="fill: rgb(255, 255, 255); opacity: 0.3; transform-origin: 385.22px 120.882px;" class="animable" id="elhb4fgggnlst"></path></g></g><g id="freepik--character-2--inject-11" class="animable animator-active" style="transform-origin: 176.62px 213.553px;"><path d="M193.31,79.64h0c-.7-2.47-5.72-7.17-10.72-7.07a4.32,4.32,0,0,0-1.4.28L84.2,128a9.15,9.15,0,0,0-3.73,4,9.26,9.26,0,0,0-1,4.07V345.92c0,5.34,6.16,10.44,11.95,8l0,0a2,2,0,0,0,.38-.15l97-55.28a9.29,9.29,0,0,0,4.68-8.06V80.65A2.25,2.25,0,0,0,193.31,79.64Z" style="fill: rgb(69, 90, 100); transform-origin: 136.477px 213.558px;" id="el9l9nai1p1lg" class="animable"></path><path d="M93,158.27a4.62,4.62,0,0,1,2.34-4L185.45,103a2.32,2.32,0,0,1,3.47,2v169.2a4.67,4.67,0,0,1-2.34,4L96.51,329.56a2.32,2.32,0,0,1-3.47-2Z" style="fill: #FF944C; transform-origin: 140.96px 216.28px;" id="elc7ck4x0av08" class="animable"></path><g id="elz839l3ba1t"><path d="M93,158.27a4.62,4.62,0,0,1,2.34-4L185.45,103a2.32,2.32,0,0,1,3.47,2v169.2a4.67,4.67,0,0,1-2.34,4L96.51,329.56a2.32,2.32,0,0,1-3.47-2Z" style="opacity: 0.2; transform-origin: 140.96px 216.28px;" class="animable" id="elci3gz9mo81l"></path></g><g id="elmgich98mtka"><path d="M93,158.27a4.62,4.62,0,0,1,2.34-4L185.45,103a2.32,2.32,0,0,1,3.47,2v169.2a4.67,4.67,0,0,1-2.34,4L96.51,329.56a2.32,2.32,0,0,1-3.47-2Z" style="fill: rgb(255, 255, 255); opacity: 0.1; transform-origin: 140.96px 216.28px;" class="animable" id="ellvbgzn9mzii"></path></g><g id="elhvo7jxljva"><path d="M79.51,136.09V345.92c0,5.34,6.16,10.44,11.95,8l0,0a2.3,2.3,0,0,1-3.09-2.16V141.89A9.25,9.25,0,0,1,90,136.77L80.47,132A9.26,9.26,0,0,0,79.51,136.09Z" style="opacity: 0.3; transform-origin: 85.485px 243.274px;" class="animable" id="el7w1recvnal3"></path></g><g id="elbog046dtbdm"><path d="M182.6,72.56a4.32,4.32,0,0,0-1.4.28L84.2,128a9.15,9.15,0,0,0-3.73,4L90,136.77a9.23,9.23,0,0,1,3.13-3l97-55.18a2.3,2.3,0,0,1,3.22,1h0C192.62,77.16,187.6,72.46,182.6,72.56Z" style="fill: rgb(255, 255, 255); opacity: 0.1; transform-origin: 136.91px 104.664px;" class="animable" id="el5q7hq8r68hk"></path></g><path d="M152.93,113.28c.69-.39,1.25-.08,1.25.7a2.78,2.78,0,0,1-1.24,2.15l-19,11c-.68.4-1.23.07-1.23-.72a2.71,2.71,0,0,1,1.22-2.12Z" style="fill: rgb(38, 50, 56); transform-origin: 143.445px 120.206px;" id="elvlgbeo45sd8" class="animable"></path><path d="M129,127.09c.68-.39,1.23-.08,1.23.71a2.75,2.75,0,0,1-1.23,2.14c-.68.39-1.24.07-1.24-.71A2.7,2.7,0,0,1,129,127.09Z" style="fill: rgb(38, 50, 56); transform-origin: 128.995px 128.514px;" id="eljt5da2sv9j" class="animable"></path><path d="M141.2,111.69c1.36-.79,2.46-.16,2.46,1.4a5.42,5.42,0,0,1-2.45,4.27c-1.36.79-2.49.15-2.49-1.42A5.44,5.44,0,0,1,141.2,111.69Z" style="fill: rgb(38, 50, 56); transform-origin: 141.19px 114.524px;" id="elxiot5ixzyb" class="animable"></path><path d="M141.2,309.22c2.78-1.6,5-.32,5,2.86a11.08,11.08,0,0,1-5,8.71c-2.77,1.6-5.07.29-5.08-2.9A11.08,11.08,0,0,1,141.2,309.22Z" style="fill: rgb(38, 50, 56); transform-origin: 141.16px 315.002px;" id="el0g8kt8pmanjr" class="animable"></path><polygon points="188.62 100.34 221.38 127.53 209.44 134.43 176.69 107.24 188.62 100.34" style="fill: #FF944C; transform-origin: 199.035px 117.385px;" id="elgfph8htvmv" class="animable"></polygon><polygon points="164.75 114.14 197.5 141.32 185.56 148.22 152.82 121.04 164.75 114.14" style="fill: #FF944C; transform-origin: 175.16px 131.18px;" id="elesrozkmgyio" class="animable"></polygon><polygon points="152.82 121.04 185.56 148.22 173.62 155.12 140.88 127.94 152.82 121.04" style="fill: rgb(255, 255, 255); transform-origin: 163.22px 138.08px;" id="elwuz36fiqr5e" class="animable"></polygon><polygon points="176.69 107.24 209.44 134.43 197.5 141.32 164.75 114.14 176.69 107.24" style="fill: rgb(255, 255, 255); transform-origin: 187.095px 124.28px;" id="el20weo6wu03s" class="animable"></polygon><polygon points="117.01 141.73 149.74 168.91 137.8 175.81 105.07 148.63 117.01 141.73" style="fill: #FF944C; transform-origin: 127.405px 158.77px;" id="elt982dcwb66" class="animable"></polygon><polygon points="140.88 127.94 173.62 155.12 161.68 162.01 128.94 134.83 140.88 127.94" style="fill: #FF944C; transform-origin: 151.28px 144.975px;" id="elct48xlvx937" class="animable"></polygon><polygon points="92.91 155.66 105.07 148.63 137.8 175.81 125.61 182.85 92.91 155.66" style="fill: rgb(255, 255, 255); transform-origin: 115.355px 165.74px;" id="el8mp2ang1v3x" class="animable"></polygon><polygon points="128.94 134.83 161.68 162.01 149.74 168.91 117.01 141.73 128.94 134.83" style="fill: rgb(255, 255, 255); transform-origin: 139.345px 151.87px;" id="el685xxch9d99" class="animable"></polygon><path d="M221.38,127.53l-11.94,6.9h0a4.61,4.61,0,0,0,6.91,4h0a10.09,10.09,0,0,0,5-8.72Z" style="fill: #FF944C; transform-origin: 215.41px 133.287px;" id="elmc0aycspu3s" class="animable"></path><path d="M209.44,134.43l-11.94,6.9h0a4.61,4.61,0,0,0,6.91,4h0a10.07,10.07,0,0,0,5-8.72Z" style="fill: rgb(224, 224, 224); transform-origin: 203.47px 140.187px;" id="elne0wfetz94" class="animable"></path><path d="M197.5,141.33l-11.94,6.89h0a4.61,4.61,0,0,0,6.91,4h0a10.07,10.07,0,0,0,5-8.72Z" style="fill: #FF944C; transform-origin: 191.53px 147.082px;" id="el2ydp4uwhl3r" class="animable"></path><path d="M185.56,148.22l-11.94,6.9h0a4.6,4.6,0,0,0,6.91,4h0a10.06,10.06,0,0,0,5-8.71Z" style="fill: rgb(224, 224, 224); transform-origin: 179.59px 153.981px;" id="el906e8zr0yag" class="animable"></path><path d="M173.62,155.12,161.68,162h0a4.61,4.61,0,0,0,6.91,4h0a10.07,10.07,0,0,0,5-8.72Z" style="fill: #FF944C; transform-origin: 167.65px 160.867px;" id="elxcdkywbyfqe" class="animable"></path><path d="M161.68,162l-11.94,6.89h0a4.61,4.61,0,0,0,6.91,4h0a10.09,10.09,0,0,0,5-8.72Z" style="fill: rgb(224, 224, 224); transform-origin: 155.71px 167.752px;" id="eli1skuvdt4hl" class="animable"></path><path d="M149.74,168.91l-11.94,6.9h0a4.6,4.6,0,0,0,6.91,4h0a10,10,0,0,0,5-8.72Z" style="fill: #FF944C; transform-origin: 143.77px 174.671px;" id="elzaf5xgegubd" class="animable"></path><g id="elg6a5cftxyu8"><path d="M221.38,127.53l-11.94,6.9h0a4.61,4.61,0,0,0,6.91,4h0a10.09,10.09,0,0,0,5-8.72Z" style="opacity: 0.2; transform-origin: 215.41px 133.287px;" class="animable" id="els18k77l3yi8"></path></g><g id="el8uad6yyhomx"><path d="M197.5,141.33l-11.94,6.89h0a4.61,4.61,0,0,0,6.91,4h0a10.07,10.07,0,0,0,5-8.72Z" style="opacity: 0.2; transform-origin: 191.53px 147.082px;" class="animable" id="eleuz53esvfm"></path></g><g id="el9iopbpr1ey"><path d="M173.62,155.12,161.68,162h0a4.61,4.61,0,0,0,6.91,4h0a10.07,10.07,0,0,0,5-8.72Z" style="opacity: 0.2; transform-origin: 167.65px 160.867px;" class="animable" id="elbonb9r1baw"></path></g><g id="elhvq4cqga59f"><path d="M149.74,168.91l-11.94,6.9h0a4.6,4.6,0,0,0,6.91,4h0a10,10,0,0,0,5-8.72Z" style="opacity: 0.2; transform-origin: 143.77px 174.671px;" class="animable" id="el78hfrjk1nts"></path></g><path d="M137.8,175.81l-12.19,7h0a4.6,4.6,0,0,0,6.9,4h0a10.58,10.58,0,0,0,5.29-9.17Z" style="fill: rgb(224, 224, 224); transform-origin: 131.705px 181.618px;" id="el2doww5nch5t" class="animable"></path><path d="M151.72,211a29.41,29.41,0,0,0-10.14,3.13,32.41,32.41,0,0,0-15.74,18.12,29.48,29.48,0,0,0-1.67,10.48,49.63,49.63,0,0,1,3.39-9.78,41.63,41.63,0,0,1,14.95-17.22A50.12,50.12,0,0,1,151.72,211Z" style="fill: #FF944C; transform-origin: 137.941px 226.865px;" id="elps663qdjneb" class="animable"></path><path d="M142.38,263.36a18.6,18.6,0,0,1-5.71-1,16.08,16.08,0,0,1-9.42-8.27,18.34,18.34,0,0,1-1.73-5.53,13,13,0,0,0,.77,5.94,14,14,0,0,0,10.1,8.86A13,13,0,0,0,142.38,263.36Z" style="fill: #FF944C; transform-origin: 133.915px 256.135px;" id="elbwho4ks6njh" class="animable"></path><path d="M157.88,231.2a45.46,45.46,0,0,1-.12,8A40.5,40.5,0,0,1,152,256.14a45.41,45.41,0,0,1-4.79,6.45,25.07,25.07,0,0,0,6-5.64,29.1,29.1,0,0,0,6-17.64A25.09,25.09,0,0,0,157.88,231.2Z" style="fill: #FF944C; transform-origin: 153.21px 246.895px;" id="elvhvoo6k1o7i" class="animable"></path><path d="M126.53,220.16a27.72,27.72,0,0,0-5.83,8.1,30.54,30.54,0,0,0-1.58,22.53,28.14,28.14,0,0,0,4.65,8.84,48,48,0,0,1-3-9.28,39.3,39.3,0,0,1,1.5-21.41A46.56,46.56,0,0,1,126.53,220.16Z" style="fill: #FF944C; transform-origin: 122.103px 239.895px;" id="el2273czc0bl5" class="animable"></path><path d="M164.73,221.34a15.4,15.4,0,0,0-2.84-7.57A16.44,16.44,0,0,0,145.21,207a15.55,15.55,0,0,0-7.31,3.46,20.83,20.83,0,0,1,7.5-2.06,18.1,18.1,0,0,1,15.39,6.24A20.78,20.78,0,0,1,164.73,221.34Z" style="fill: #FF944C; transform-origin: 151.315px 214.016px;" id="elefzg7xanjn" class="animable"></path><path d="M207.62,190h0a12.63,12.63,0,0,1,13.71,10.34l4.64,26,29.1,20.35-6.5,7.91-27.68-14.54a13.79,13.79,0,0,1-6.81-8.28l-8.92-30.09Z" style="fill: rgb(255, 168, 167); transform-origin: 230.115px 222.268px;" id="elqwfiy9hcz79" class="animable"></path><path d="M218.42,217.94a13.49,13.49,0,0,0,5.87-6.17l-2.61-11.92A12.63,12.63,0,0,0,208.06,190l-.44.05-2.46,11.71L209,219A13.57,13.57,0,0,0,218.42,217.94Z" style="fill: rgb(69, 90, 100); transform-origin: 214.725px 204.669px;" id="elzt05ekkwge" class="animable"></path><path d="M218.42,217.94A13.57,13.57,0,0,1,209,219l1,4.25c3.61.81,12.86.54,15.27-7.1l-1-4.4A13.49,13.49,0,0,1,218.42,217.94Z" style="fill: rgb(69, 90, 100); transform-origin: 217.135px 217.656px;" id="elhu5gwfnonwu" class="animable"></path><g id="elwb3jm3dv0h"><path d="M218.42,217.94a13.49,13.49,0,0,0,5.87-6.17l-2.61-11.92A12.63,12.63,0,0,0,208.06,190l-.44.05-2.46,11.71L209,219A13.57,13.57,0,0,0,218.42,217.94Z" style="fill: rgb(255, 255, 255); opacity: 0.2; transform-origin: 214.725px 204.669px;" class="animable" id="elimycxju923o"></path></g><g id="el1b1tw1428h"><path d="M218.42,217.94A13.57,13.57,0,0,1,209,219l1,4.25c3.61.81,12.86.54,15.27-7.1l-1-4.4A13.49,13.49,0,0,1,218.42,217.94Z" style="fill: rgb(255, 255, 255); opacity: 0.5; transform-origin: 217.135px 217.656px;" class="animable" id="elud6bef9uvsi"></path></g><path d="M214.06,201.19s-1.16-8.85-6.44-11.16c0,0-12.64,3.79-23.12,7.77A121.51,121.51,0,0,0,172.34,203c-2.38,2.06-9.21,8.19-12.42,9.84a15.25,15.25,0,0,1-5,1.5h0a17.46,17.46,0,0,0-6.22,2.27c-9.62,5.56-17.39,19-17.36,30.07,0,7.25,3.4,11.64,8.43,12.25v0H140a11.29,11.29,0,0,0,2.39,0c8.75-.08,22.78-.15,28.29-1.73C196.42,249.64,216.66,231,214.06,201.19Z" style="fill: rgb(69, 90, 100); transform-origin: 172.813px 224.512px;" id="eli1lgtggb17m" class="animable"></path><path d="M189.53,197.56l3.77-6.84,15.17,10.22-6,8.06a10.1,10.1,0,0,1-8.14.33,10.36,10.36,0,0,1-5.5-6.16A7.23,7.23,0,0,1,189.53,197.56Z" style="fill: rgb(255, 168, 167); transform-origin: 198.512px 200.375px;" id="el44mjrmab5me" class="animable"></path><g id="elagtylep5jvg"><path d="M194.72,191.67c0,8.24,6.55,12.1,10.55,13.56l3.2-4.29Z" style="opacity: 0.2; transform-origin: 201.595px 198.45px;" class="animable" id="elvwx0ccu5j6"></path></g><path d="M187.87,183.45c-.56-3.29-1.13-6.67-.49-9.95s2.76-6.48,6-7.44a11.22,11.22,0,0,1,6.77-5.93,30.87,30.87,0,0,1,8.89-1.08,43.08,43.08,0,0,1,9.9.55,14.65,14.65,0,0,1,8.48,4.81,14.12,14.12,0,0,1,2.46,10.86,31.75,31.75,0,0,1-4.11,10.63c-6.36.45-12.84,1.18-19.2,1.63a51.25,51.25,0,0,1-9.75.09A18.13,18.13,0,0,1,187.87,183.45Z" style="fill: rgb(38, 50, 56); transform-origin: 208.606px 173.391px;" id="eliej77lcqza" class="animable"></path><path d="M226.81,168.2a54.37,54.37,0,0,1-3.12,29.05c-.85,2.13-2,4.34-3.95,5.47s-4.67.95-7,.59a36.12,36.12,0,0,1-11.13-3.13,15.18,15.18,0,0,1-7.7-8.3,6.69,6.69,0,0,1-6.75-2.65,12.62,12.62,0,0,1-2.19-7.36c0-1.67.31-3.64,1.81-4.37s3.06.08,4.27,1.06a12.69,12.69,0,0,1,4.16,6.24c1.1-4.07,2.81-8,3.91-12,.44-1.6,1-3.34,2.37-4.23,1.7-1.09,3.92-.47,5.89,0A38.68,38.68,0,0,0,226.81,168.2Z" style="fill: rgb(255, 168, 167); transform-origin: 206.258px 185.774px;" id="eltwwgcxt916" class="animable"></path><polygon points="214.97 180.53 219.72 188.52 214.06 189.59 214.97 180.53" style="fill: rgb(242, 143, 143); transform-origin: 216.89px 185.06px;" id="elpdchfw8h3z" class="animable"></polygon><path d="M208.6,192.34l4.3,2.09a2.8,2.8,0,0,1-3.26.93A2.54,2.54,0,0,1,208.6,192.34Z" style="fill: rgb(242, 143, 143); transform-origin: 210.674px 193.946px;" id="el99z3lu8czhs" class="animable"></path><g id="elat41irja0y4"><path d="M208.6,192.34l4.3,2.09a2.8,2.8,0,0,1-3.26.93A2.54,2.54,0,0,1,208.6,192.34Z" style="opacity: 0.3; transform-origin: 210.674px 193.946px;" class="animable" id="ell5zpr49luml"></path></g><path d="M211.13,195.5a2.58,2.58,0,0,1-1.49-.14,2.28,2.28,0,0,1-1.15-2.27,2.76,2.76,0,0,1,1.7.59A2.73,2.73,0,0,1,211.13,195.5Z" style="fill: rgb(242, 143, 143); transform-origin: 209.801px 194.321px;" id="elh2c532g15hb" class="animable"></path><path d="M206.77,180.85a1.63,1.63,0,1,0,1.78-1.46A1.63,1.63,0,0,0,206.77,180.85Z" style="fill: rgb(38, 50, 56); transform-origin: 208.392px 181.012px;" id="el39k72hycemc" class="animable"></path><path d="M220.41,181.69a1.62,1.62,0,1,0,1.78-1.45A1.62,1.62,0,0,0,220.41,181.69Z" style="fill: rgb(38, 50, 56); transform-origin: 222.022px 181.851px;" id="ellaeyaa5spp8" class="animable"></path><path d="M222.63,175.41l3.34,2.84a2.32,2.32,0,0,0-.45-2.61A2.75,2.75,0,0,0,222.63,175.41Z" style="fill: rgb(38, 50, 56); transform-origin: 224.409px 176.677px;" id="elact0p5ymo5" class="animable"></path><path d="M209.33,175.19l-3.83,2.12a2.32,2.32,0,0,1,.95-2.47A2.76,2.76,0,0,1,209.33,175.19Z" style="fill: rgb(38, 50, 56); transform-origin: 207.382px 175.948px;" id="elcdv9fz79lxt" class="animable"></path><path d="M229.85,171.49a132.86,132.86,0,0,1-42,0c.65-17,8.3-22.57,21.5-22.57S230,156,229.85,171.49Z" style="fill: rgb(69, 90, 100); transform-origin: 208.851px 161.04px;" id="elbc7aj5nloi" class="animable"></path><path d="M229.85,171.49c0-6.51-1.26-11.51-3.73-15.14l-5.53-1.55a18.24,18.24,0,0,0-8-.42l-5.27.88a8.39,8.39,0,0,0-7,7.31l-1.21,10.26h0A133.56,133.56,0,0,0,229.85,171.49Z" style="fill: rgb(69, 90, 100); transform-origin: 214.48px 163.648px;" id="elwhvmtyi4wyt" class="animable"></path><g id="ellljy0bfrkcm"><path d="M229.85,171.49c0-6.51-1.26-11.51-3.73-15.14l-5.53-1.55a18.24,18.24,0,0,0-8-.42l-5.27.88a8.39,8.39,0,0,0-7,7.31l-1.21,10.26h0A133.56,133.56,0,0,0,229.85,171.49Z" style="fill: rgb(255, 255, 255); opacity: 0.29; transform-origin: 214.48px 163.648px;" class="animable" id="ell7y199zqxbi"></path></g><path d="M231.5,157.18h-2.44c-.79,0-1.57,0-2.35.09a32.44,32.44,0,0,0-19.28,8.18l-8.22,7.38a133.56,133.56,0,0,0,30.64-1.34L235.2,165A4.8,4.8,0,0,0,231.5,157.18Z" style="fill: rgb(69, 90, 100); transform-origin: 217.74px 165.175px;" id="elnneavnkjhgk" class="animable"></path><g id="eldhplgp03qhk"><path d="M231.5,157.18h-2.44c-.79,0-1.57,0-2.35.09a32.44,32.44,0,0,0-19.28,8.18l-8.22,7.38a133.56,133.56,0,0,0,30.64-1.34L235.2,165A4.8,4.8,0,0,0,231.5,157.18Z" style="opacity: 0.2; transform-origin: 217.74px 165.175px;" class="animable" id="eli2dps3ham8s"></path></g><polygon points="273.77 248.06 236.49 269.72 198.97 248.06 236.24 226.39 273.77 248.06" style="fill: #FF944C; transform-origin: 236.37px 248.055px;" id="eltz3wsh6s4sp" class="animable"></polygon><g id="elu22hys3al7"><g style="opacity: 0.3; transform-origin: 236.37px 248.055px;" class="animable" id="eltfbw0c05pz"><polygon points="273.77 248.06 236.49 269.72 198.97 248.06 236.24 226.39 273.77 248.06" style="fill: rgb(255, 255, 255); transform-origin: 236.37px 248.055px;" id="elmvhvgdmt61l" class="animable"></polygon></g></g><polygon points="273.77 248.06 273.66 285.98 236.38 307.64 236.49 269.72 273.77 248.06" style="fill: #FF944C; transform-origin: 255.075px 277.85px;" id="elwpom6fgqb0e" class="animable"></polygon><g id="elrt0v4y7a43d"><g style="opacity: 0.1; transform-origin: 255.075px 277.85px;" class="animable" id="elv7ls45igmb"><polygon points="273.77 248.06 273.66 285.98 236.38 307.64 236.49 269.72 273.77 248.06" style="fill: rgb(255, 255, 255); transform-origin: 255.075px 277.85px;" id="elkvnl26edhkh" class="animable"></polygon></g></g><polygon points="236.49 269.72 236.38 307.64 198.86 285.98 198.97 248.06 236.49 269.72" style="fill: #FF944C; transform-origin: 217.675px 277.85px;" id="el47vwh8bjo2s" class="animable"></polygon><polygon points="242.98 245.28 255.6 237.57 249.16 233.85 236.49 241.41 242.98 245.28" style="fill: rgb(224, 224, 224); transform-origin: 246.045px 239.565px;" id="els4wl1l4mwk" class="animable"></polygon><polygon points="242.98 245.28 236.49 241.41 223.62 233.73 217.2 237.46 229.99 245.28 236.49 249.25 253.65 259.75 260.53 255.75 242.98 245.28" style="fill: rgb(255, 255, 255); transform-origin: 238.865px 246.74px;" id="elvba4dvv347" class="animable"></polygon><polygon points="229.99 245.28 212.37 255.79 219.27 259.78 236.49 249.25 229.99 245.28" style="fill: rgb(224, 224, 224); transform-origin: 224.43px 252.53px;" id="elyh5nf6icvqm" class="animable"></polygon><polygon points="260.53 255.75 253.65 259.75 253.71 259.78 253.81 297.51 260.77 293.47 260.67 255.82 260.53 255.75" style="fill: rgb(224, 224, 224); transform-origin: 257.21px 276.63px;" id="el2rae30j39p5" class="animable"></polygon><polygon points="219.27 259.78 212.37 255.79 212.31 255.82 212.2 293.69 219.16 297.7 219.27 259.78 219.27 259.78" style="fill: rgb(255, 255, 255); transform-origin: 215.735px 276.745px;" id="el79pobis8s3o" class="animable"></polygon><g id="elzn44jd8sf1"><polygon points="219.27 259.78 212.37 255.79 212.31 255.82 212.2 293.69 219.16 297.7 219.27 259.78 219.27 259.78" style="opacity: 0.2; transform-origin: 215.735px 276.745px;" class="animable" id="eldsrvmvspghi"></polygon></g><polygon points="236.47 256.74 228.67 261.51 236.47 266.02 244.25 261.5 236.47 256.74" style="fill: rgb(255, 255, 255); transform-origin: 236.46px 261.38px;" id="elzesk8r43kj" class="animable"></polygon><path d="M162.67,255.43s2.91-42.35,3.52-45c2.33-10.07,16.93-9.35,18.32.89.57,4.18-6.1,44.77-6.1,44.77l24.16,25.56,4.89,4.49,4.36-.88,9.94.94a1.22,1.22,0,0,1,1.08,1h0a1.23,1.23,0,0,1-.9,1.44l-6.57,1.6,4.74,3.24a5.73,5.73,0,0,0,2.21.91l7.43,1.41a1.36,1.36,0,0,1,1.11,1.43h0a1.37,1.37,0,0,1-.88,1.2l-4,1.49a19.23,19.23,0,0,1-16-1.14L201.38,294a21.27,21.27,0,0,1-3.55-2.4L167,266.1A12.07,12.07,0,0,1,162.67,255.43Z" style="fill: rgb(255, 168, 167); transform-origin: 196.729px 252.197px;" id="elh4z2cizv9go" class="animable"></path><path d="M184.12,239.2l3.09-23a12,12,0,1,0-23.87-2.92l-2.58,23.47a28.76,28.76,0,0,0,23.36,2.42Z" style="fill: rgb(69, 90, 100); transform-origin: 174.03px 221.656px;" id="elw0mb3cv6ii" class="animable"></path><g id="elwnrljgpnqq"><path d="M184.12,239.2l3.09-23a12,12,0,1,0-23.87-2.92l-2.58,23.47a28.76,28.76,0,0,0,23.36,2.42Z" style="fill: rgb(255, 255, 255); opacity: 0.2; transform-origin: 174.03px 221.656px;" class="animable" id="elxmagdn4v7dk"></path></g><path d="M171.71,240.43a29.42,29.42,0,0,1-11-3.65l-.59,5.41c10.39,8,23.13,3.06,23.13,3.06l.82-6.05A29.33,29.33,0,0,1,171.71,240.43Z" style="fill: rgb(69, 90, 100); transform-origin: 172.095px 241.769px;" id="el0q2qizsrf6" class="animable"></path><g id="elejwuix5z5an"><path d="M171.71,240.43a29.42,29.42,0,0,1-11-3.65l-.59,5.41c10.39,8,23.13,3.06,23.13,3.06l.82-6.05A29.33,29.33,0,0,1,171.71,240.43Z" style="fill: rgb(255, 255, 255); opacity: 0.5; transform-origin: 172.095px 241.769px;" class="animable" id="els6oe8jl0vqi"></path></g></g><g id="freepik--Plants--inject-11" class="animable" style="transform-origin: 256.195px 325.087px;"><path d="M441.94,317.77l16.22.48,16.22-.48c.69,11-1.44,22.12-4.39,27.57h0a7.39,7.39,0,0,1-3.21,3.26c-4.79,2.77-12.52,2.77-17.28,0a7.21,7.21,0,0,1-3.2-3.35C443.36,339.77,441.25,328.67,441.94,317.77Z" style="fill: rgb(255, 255, 255); transform-origin: 458.16px 334.224px;" id="elxj00m6uek4f" class="animable"></path><path d="M446.73,311.13c-6.35,3.67-6.39,9.62-.08,13.29s16.58,3.66,22.94,0,6.39-9.62.07-13.29S453.08,307.46,446.73,311.13Z" style="fill: rgb(235, 235, 235); transform-origin: 458.161px 317.773px;" id="elrk7oszno37k" class="animable"></path><path d="M449.24,312.59c-5,2.86-5,7.5-.06,10.37s12.94,2.86,17.9,0,5-7.51.05-10.37S454.2,309.73,449.24,312.59Z" style="fill: rgb(224, 224, 224); transform-origin: 458.152px 317.777px;" id="ele6b0sb2091b" class="animable"></path><g id="elpubup9p9n3a"><g style="opacity: 0.15; transform-origin: 458.152px 317.777px;" class="animable" id="eln92cgoudplq"><path d="M449.24,312.59c-5,2.86-5,7.5-.06,10.37s12.94,2.86,17.9,0,5-7.51.05-10.37S454.2,309.73,449.24,312.59Z" id="elya8e50fb7wd" class="animable" style="transform-origin: 458.152px 317.777px;"></path></g></g><path d="M466.43,284.59c2.64-3.28,5.7-6.22,8.12-9.66,1.65-2.35,3-5.23,2.33-8a7.15,7.15,0,0,0-5.67-5,10.87,10.87,0,0,0-7.62,1.7,23.25,23.25,0,0,0-5.76,5.48A57.23,57.23,0,0,0,445.77,310a8.61,8.61,0,0,0,1.51,4.7,4.71,4.71,0,0,0,4.85,1.48c4.42-1.31,3.83-7.28,4.55-10.79a49.08,49.08,0,0,1,5.08-13.77A47.54,47.54,0,0,1,466.43,284.59Z" style="fill: #FF944C; transform-origin: 461.284px 289.082px;" id="ela3u4mtbnpsp" class="animable"></path><g id="ela4sv1d9ct66"><path d="M466.43,284.59c2.64-3.28,5.7-6.22,8.12-9.66,1.65-2.35,3-5.23,2.33-8a7.15,7.15,0,0,0-5.67-5,10.87,10.87,0,0,0-7.62,1.7,23.25,23.25,0,0,0-5.76,5.48A57.23,57.23,0,0,0,445.77,310a8.61,8.61,0,0,0,1.51,4.7,4.71,4.71,0,0,0,4.85,1.48c4.42-1.31,3.83-7.28,4.55-10.79a49.08,49.08,0,0,1,5.08-13.77A47.54,47.54,0,0,1,466.43,284.59Z" style="fill: rgb(255, 255, 255); opacity: 0.2; transform-origin: 461.284px 289.082px;" class="animable" id="el0nf1iguq83en"></path></g><path d="M451.85,311.7a.39.39,0,0,0,.31-.37c.31-7.09,2.62-31.29,19.3-45a.37.37,0,0,0,.05-.54.38.38,0,0,0-.54-.06c-16.93,13.94-19.27,38.43-19.58,45.6a.39.39,0,0,0,.37.4Z" style="fill: rgb(240, 240, 240); transform-origin: 461.497px 288.687px;" id="elb620qwo8awk" class="animable"></path><path d="M449.42,312.46a11.8,11.8,0,0,0,5.41,7.51,15.17,15.17,0,0,0,8.2,1.38,36.27,36.27,0,0,0,8.32-2c1.34-.45,2.82-1.05,3-2.71a3,3,0,0,0-.95-2.33,9.06,9.06,0,0,0-.86-.75.85.85,0,0,1,.45-1.53,20.74,20.74,0,0,0,2.37-.3,10.35,10.35,0,0,0,5-2.25,8.26,8.26,0,0,0,2.3-3.4c.4-1.12.52-2.52-.33-3.35a3.57,3.57,0,0,0-1.84-.8c-.59-.13-1.19-.24-1.78-.33a.79.79,0,0,1-.19-1.51l2.52-1.05a4.68,4.68,0,0,0,1.91-1.19,4.16,4.16,0,0,0,.48-3.46c-.31-1.58-.85-3.1-1.22-4.66A10,10,0,0,1,482,285a40,40,0,0,0-14.09.94,10.24,10.24,0,0,0-3.85,1.68c-1.57,1.26-2,3.14-1.81,5.19a.36.36,0,0,1-.68.19L460,290a1.91,1.91,0,0,0-2.5-.8,11.62,11.62,0,0,0-3.68,2.9,6.37,6.37,0,0,0-1.57,4.7,41.4,41.4,0,0,0,1.17,6.91.63.63,0,0,1-1,.67l-.07,0a2.15,2.15,0,0,0-1.52-.44c-1.42.17-1.78,1.61-1.88,2.84A23.82,23.82,0,0,0,449.42,312.46Z" style="fill: #FF944C; transform-origin: 466.272px 303.099px;" id="elryz9ojwdjhh" class="animable"></path><g id="el9vse88l49w"><path d="M449.42,312.46a11.8,11.8,0,0,0,5.41,7.51,15.17,15.17,0,0,0,8.2,1.38,36.27,36.27,0,0,0,8.32-2c1.34-.45,2.82-1.05,3-2.71a3,3,0,0,0-.95-2.33,9.06,9.06,0,0,0-.86-.75.85.85,0,0,1,.45-1.53,20.74,20.74,0,0,0,2.37-.3,10.35,10.35,0,0,0,5-2.25,8.26,8.26,0,0,0,2.3-3.4c.4-1.12.52-2.52-.33-3.35a3.57,3.57,0,0,0-1.84-.8c-.59-.13-1.19-.24-1.78-.33a.79.79,0,0,1-.19-1.51l2.52-1.05a4.68,4.68,0,0,0,1.91-1.19,4.16,4.16,0,0,0,.48-3.46c-.31-1.58-.85-3.1-1.22-4.66A10,10,0,0,1,482,285a40,40,0,0,0-14.09.94,10.24,10.24,0,0,0-3.85,1.68c-1.57,1.26-2,3.14-1.81,5.19a.36.36,0,0,1-.68.19L460,290a1.91,1.91,0,0,0-2.5-.8,11.62,11.62,0,0,0-3.68,2.9,6.37,6.37,0,0,0-1.57,4.7,41.4,41.4,0,0,0,1.17,6.91.63.63,0,0,1-1,.67l-.07,0a2.15,2.15,0,0,0-1.52-.44c-1.42.17-1.78,1.61-1.88,2.84A23.82,23.82,0,0,0,449.42,312.46Z" style="opacity: 0.2; transform-origin: 466.272px 303.099px;" class="animable" id="eluo62w3soj5"></path></g><g id="eloxnudlc3e8"><path d="M449.42,312.46a11.8,11.8,0,0,0,5.41,7.51,15.17,15.17,0,0,0,8.2,1.38,36.27,36.27,0,0,0,8.32-2c1.34-.45,2.82-1.05,3-2.71a3,3,0,0,0-.95-2.33,9.06,9.06,0,0,0-.86-.75.85.85,0,0,1,.45-1.53,20.74,20.74,0,0,0,2.37-.3,10.35,10.35,0,0,0,5-2.25,8.26,8.26,0,0,0,2.3-3.4c.4-1.12.52-2.52-.33-3.35a3.57,3.57,0,0,0-1.84-.8c-.59-.13-1.19-.24-1.78-.33a.79.79,0,0,1-.19-1.51l2.52-1.05a4.68,4.68,0,0,0,1.91-1.19,4.16,4.16,0,0,0,.48-3.46c-.31-1.58-.85-3.1-1.22-4.66A10,10,0,0,1,482,285a40,40,0,0,0-14.09.94,10.24,10.24,0,0,0-3.85,1.68c-1.57,1.26-2,3.14-1.81,5.19a.36.36,0,0,1-.68.19L460,290a1.91,1.91,0,0,0-2.5-.8,11.62,11.62,0,0,0-3.68,2.9,6.37,6.37,0,0,0-1.57,4.7,41.4,41.4,0,0,0,1.17,6.91.63.63,0,0,1-1,.67l-.07,0a2.15,2.15,0,0,0-1.52-.44c-1.42.17-1.78,1.61-1.88,2.84A23.82,23.82,0,0,0,449.42,312.46Z" style="fill: rgb(255, 255, 255); opacity: 0.2; transform-origin: 466.272px 303.099px;" class="animable" id="elme81bwxeme"></path></g><path d="M456.89,319.59a56.82,56.82,0,0,1,3.79-11,.41.41,0,0,1,.13-.29l.27-.57a35.58,35.58,0,0,0-3.76-12.58.4.4,0,0,1,.14-.53.39.39,0,0,1,.53.15,35.85,35.85,0,0,1,3.7,11.69c3.21-6.44,8.33-14,16.23-19.46a.39.39,0,0,1,.54.1.38.38,0,0,1-.1.53c-8.15,5.68-13.29,13.54-16.41,20.06a23.73,23.73,0,0,1,13.43-1.82.4.4,0,0,1,.31.46.38.38,0,0,1-.31.3h-.15c-.07,0-7.44-1.35-13.82,2.21a56,56,0,0,0-3.76,10.89.4.4,0,0,1-.31.3h-.15A.38.38,0,0,1,456.89,319.59Z" style="fill: rgb(240, 240, 240); transform-origin: 467.705px 303.481px;" id="elxblpprotttl" class="animable"></path><path d="M87.33,350.91l-18.46.54-18.45-.54c-.8,12.46,1.64,25.16,5,31.37h0A8.38,8.38,0,0,0,59.08,386c5.44,3.15,14.24,3.15,19.65,0a8.14,8.14,0,0,0,3.65-3.81C85.71,375.94,88.12,363.31,87.33,350.91Z" style="fill: rgb(255, 255, 255); transform-origin: 68.874px 369.636px;" id="el6subku4xv08" class="animable"></path><path d="M81.88,343.35c7.23,4.18,7.27,10.94.09,15.12s-18.87,4.17-26.1,0-7.27-10.94-.09-15.12S74.65,339.18,81.88,343.35Z" style="fill: rgb(235, 235, 235); transform-origin: 68.875px 350.91px;" id="elj84wzbvh8o" class="animable"></path><path d="M79,345c5.64,3.26,5.67,8.54.07,11.8s-14.72,3.25-20.36,0-5.67-8.54-.07-11.8S73.38,341.76,79,345Z" style="fill: rgb(224, 224, 224); transform-origin: 68.855px 350.902px;" id="ela5wu1viz86e" class="animable"></path><g id="elmxr73wd23gl"><g style="opacity: 0.15; transform-origin: 68.855px 350.902px;" class="animable" id="elobj7dhlb3ha"><path d="M79,345c5.64,3.26,5.67,8.54.07,11.8s-14.72,3.25-20.36,0-5.67-8.54-.07-11.8S73.38,341.76,79,345Z" id="elbv2u0sy3u2q" class="animable" style="transform-origin: 68.855px 350.902px;"></path></g></g><path d="M99.22,272.16c-41.59,13.62-42,41.44-32.59,61.25,2.36,4,9.52,6.17,15.74-18.47l-10.92,1.4,12.73-6.46L87.49,300l-10.62.79,13.48-5.67A198.61,198.61,0,0,1,99.22,272.16Z" style="fill: #FF944C; transform-origin: 80.4302px 304.017px;" id="elwwae4rjl7a" class="animable"></path><g id="elfvheppkdwyp"><path d="M99.22,272.16c-41.59,13.62-42,41.44-32.59,61.25,2.36,4,9.52,6.17,15.74-18.47l-10.92,1.4,12.73-6.46L87.49,300l-10.62.79,13.48-5.67A198.61,198.61,0,0,1,99.22,272.16Z" style="opacity: 0.2; transform-origin: 80.4302px 304.017px;" class="animable" id="elbrzemgevkpa"></path></g><g id="el525leoi87h5"><path d="M99.22,272.16c-41.59,13.62-42,41.44-32.59,61.25,2.36,4,9.52,6.17,15.74-18.47l-10.92,1.4,12.73-6.46L87.49,300l-10.62.79,13.48-5.67A198.61,198.61,0,0,1,99.22,272.16Z" style="fill: rgb(255, 255, 255); opacity: 0.2; transform-origin: 80.4302px 304.017px;" class="animable" id="elc5iiuy0knz9"></path></g><path d="M87.45,279.12c-21.93,16.64-23.91,35.73-17.71,55.65C67.55,317.23,65.18,299.49,87.45,279.12Z" style="fill: rgb(255, 255, 255); transform-origin: 77.0665px 306.945px;" id="elrowhx3yb1gn" class="animable"></path><path d="M28.78,300.42c41,5.77,46,31.62,40.52,51.63-1.53,4.13-7.84,7.33-17.73-14.59L62,337,49,333.06l-4.72-8.66,10-1-13.49-3A190.85,190.85,0,0,0,28.78,300.42Z" style="fill: #FF944C; transform-origin: 49.9548px 327.724px;" id="el0l8a7k9sy09h" class="animable"></path><g id="elxy1hxjlm9iq"><path d="M28.78,300.42c41,5.77,46,31.62,40.52,51.63-1.53,4.13-7.84,7.33-17.73-14.59L62,337,49,333.06l-4.72-8.66,10-1-13.49-3A190.85,190.85,0,0,0,28.78,300.42Z" style="fill: rgb(255, 255, 255); opacity: 0.2; transform-origin: 49.9548px 327.724px;" class="animable" id="elo2o6z4lket"></path></g><g id="el840e00t6rul"><path d="M28.78,300.42c41,5.77,46,31.62,40.52,51.63-1.53,4.13-7.84,7.33-17.73-14.59L62,337,49,333.06l-4.72-8.66,10-1-13.49-3A190.85,190.85,0,0,0,28.78,300.42Z" style="opacity: 0.1; transform-origin: 49.9548px 327.724px;" class="animable" id="elqgnlkowjuv"></path></g><path d="M40.89,305c23.19,11.86,28.2,29.3,25.74,48.88C65.76,337.13,65,320.22,40.89,305Z" style="fill: rgb(255, 255, 255); transform-origin: 54.0433px 329.44px;" id="elvngumipqnb" class="animable"></path><path d="M111.21,310.11c-37.59.61-45,23.35-42.3,42,.92,3.89,6.25,7.48,17.62-11.17l-9.33-1.62,12.09-2.07L94.52,330l-8.92-2.05,12.5-1.23A171.9,171.9,0,0,1,111.21,310.11Z" style="fill: #FF944C; transform-origin: 89.8097px 332.671px;" id="elgf5hu7ucyx" class="animable"></path><path d="M99.79,312.83c-22.23,8.09-28.7,23.26-28.67,41.18C73.77,339.06,76.33,323.9,99.79,312.83Z" style="fill: rgb(255, 255, 255); transform-origin: 85.4549px 333.42px;" id="elp43ad76uuhs" class="animable"></path><g id="el09go6s5s0zv"><path d="M111.21,310.11c-37.59.61-45,23.35-42.3,42,.92,3.89,6.25,7.48,17.62-11.17l-9.33-1.62,12.09-2.07L94.52,330l-8.92-2.05,12.5-1.23A171.9,171.9,0,0,1,111.21,310.11Z" style="fill: rgb(255, 255, 255); opacity: 0.2; transform-origin: 89.8097px 332.671px;" class="animable" id="elce0t84bz32n"></path></g></g><g id="freepik--character-1--inject-11" class="animable" style="transform-origin: 360.882px 305.198px;"><path d="M328,272.54c-9.87,6.86-21,11.6-29.23,20.79-15.39,17.16-15.75,44.78-3.66,64.41s34.58,31.42,57.48,34.12c24,2.84,49.23-3.8,68.08-19s30.84-38.85,30.83-63-12.4-48.28-32.66-61.5c-18.49-12-45.05-15.49-63.6-1.7-9.37,7-15.63,17.27-25,24.27C329.56,271.47,328.8,272,328,272.54Z" style="fill: #FF944C; transform-origin: 369.04px 315.122px;" id="eldc3u65r3g0v" class="animable"></path><g id="eluaczx237djr"><path d="M328,272.54c-9.87,6.86-21,11.6-29.23,20.79-15.39,17.16-15.75,44.78-3.66,64.41s34.58,31.42,57.48,34.12c24,2.84,49.23-3.8,68.08-19s30.84-38.85,30.83-63-12.4-48.28-32.66-61.5c-18.49-12-45.05-15.49-63.6-1.7-9.37,7-15.63,17.27-25,24.27C329.56,271.47,328.8,272,328,272.54Z" style="opacity: 0.2; transform-origin: 369.04px 315.122px;" class="animable" id="elg0pp46ek8cl"></path></g><g id="elyuoxbgelaqn"><path d="M328,272.54c-9.87,6.86-21,11.6-29.23,20.79-15.39,17.16-15.75,44.78-3.66,64.41s34.58,31.42,57.48,34.12c24,2.84,49.23-3.8,68.08-19s30.84-38.85,30.83-63-12.4-48.28-32.66-61.5c-18.49-12-45.05-15.49-63.6-1.7-9.37,7-15.63,17.27-25,24.27C329.56,271.47,328.8,272,328,272.54Z" style="fill: rgb(255, 255, 255); opacity: 0.1; transform-origin: 369.04px 315.122px;" class="animable" id="el2rabrxsn23e"></path></g><g id="el7meoxec7758"><path d="M332.06,373.11c0-.17.05-.33.07-.49A26,26,0,0,1,353.18,351a82,82,0,0,0,27-10.33c5.89-3.56,11.46-7.93,18.07-9.86a29.47,29.47,0,0,1,19.48,1.13c-5.56-5.83-15.08-8.4-22.69-5.76,5.26-8.07,9.9-16.75,11.72-26.21s.52-19.85-5.18-27.61A27.78,27.78,0,0,0,358.67,270c-5.65,6.18-8.83,14.88-12.54,22.38-2.67,5.39-5.42,10.91-9.82,15-6.62,6.2-16.16,8.43-23,14.36-7.79,6.73-11.15,17.48-11.18,27.77a81.39,81.39,0,0,0,3,20.53,77.91,77.91,0,0,0,28.18,17.23A30.54,30.54,0,0,1,332.06,373.11Z" style="opacity: 0.1; transform-origin: 359.93px 324.125px;" class="animable" id="ely09n28skb0k"></path></g><path d="M438.65,306.53A70.62,70.62,0,0,0,378.42,238a51.75,51.75,0,0,0-6.81,1.14,68.83,68.83,0,0,1,65.17,67.45c.45,22.51-10.57,45.46-29.46,61.38-14.8,12.48-34.46,20.76-56.08,23.73.46.07.93.13,1.39.18,1.94.23,3.89.39,5.85.5,19.2-3.73,36.59-11.64,50-23C427.84,353.09,439.1,329.6,438.65,306.53Z" style="fill: rgb(255, 255, 255); transform-origin: 394.952px 315.19px;" id="el7f6fqfqthil" class="animable"></path><path d="M323.34,389.66l2.48,4.91c3.49-3.24,4.13-5.85,4.13-5.85-1.13-4-2.45-8.07-3.11-10.05-.33,2.76-2.21,5.13-3,7.82A13.68,13.68,0,0,0,323.34,389.66Z" style="fill: rgb(55, 71, 79); transform-origin: 326.645px 386.62px;" id="elp86m98vgx0s" class="animable"></path><path d="M323.46,394.69l2.36-.12-2.48-4.91C323.27,391.32,323.41,393,323.46,394.69Z" style="fill: rgb(38, 50, 56); transform-origin: 324.57px 392.175px;" id="ell5csb3n4f5" class="animable"></path><path d="M325.26,372.88a21.7,21.7,0,0,0-2.93-3.42,11.86,11.86,0,0,1-.05,6.55c-.73,2.84-2.06,5.51-2.73,8.37-.81,3.48-.62,7.22-2.1,10.48a11.21,11.21,0,0,1-7.85,6.26,4.94,4.94,0,0,1-3.74-.45,2.65,2.65,0,0,1-1-1.39,24.64,24.64,0,0,1-2.69,4.38c-1.16,1.5-2.61,3.16-2.29,5a4,4,0,0,0,3.28,3,10.6,10.6,0,0,0,4.67-.39,29.12,29.12,0,0,0,9.35-3.81,14,14,0,0,0,5.94-8,17.87,17.87,0,0,0,.36-4.85c0-1.68-.19-3.37-.12-5a13.68,13.68,0,0,1,.49-3.17c.8-2.69,2.68-5.06,3-7.82,0-.15.05-.29.06-.44A9,9,0,0,0,325.26,372.88Z" style="fill: rgb(69, 90, 100); transform-origin: 313.373px 390.612px;" id="el4340oinau0f" class="animable"></path><g id="el79brqenk3xk"><path d="M325.26,372.88a21.7,21.7,0,0,0-2.93-3.42,11.86,11.86,0,0,1-.05,6.55c-.73,2.84-2.06,5.51-2.73,8.37-.81,3.48-.62,7.22-2.1,10.48a11.21,11.21,0,0,1-7.85,6.26,4.94,4.94,0,0,1-3.74-.45,2.65,2.65,0,0,1-1-1.39,24.64,24.64,0,0,1-2.69,4.38c-1.16,1.5-2.61,3.16-2.29,5a4,4,0,0,0,3.28,3,10.6,10.6,0,0,0,4.67-.39,29.12,29.12,0,0,0,9.35-3.81,14,14,0,0,0,5.94-8,17.87,17.87,0,0,0,.36-4.85c0-1.68-.19-3.37-.12-5a13.68,13.68,0,0,1,.49-3.17c.8-2.69,2.68-5.06,3-7.82,0-.15.05-.29.06-.44A9,9,0,0,0,325.26,372.88Z" style="opacity: 0.1; transform-origin: 313.373px 390.612px;" class="animable" id="elzwsojgcerss"></path></g><path d="M309.6,401.12a11.21,11.21,0,0,0,7.85-6.26c1.48-3.26,1.29-7,2.1-10.48.67-2.86,2-5.53,2.73-8.37a11.86,11.86,0,0,0,.05-6.55c-.28-.28-.56-.56-.85-.83-4.22,2.18-9,4-12.85,6.78a91.62,91.62,0,0,1-.94,14.72,34.75,34.75,0,0,1-2.85,9.15,2.65,2.65,0,0,0,1,1.39A4.94,4.94,0,0,0,309.6,401.12Z" style="fill: rgb(171, 97, 96); transform-origin: 313.803px 384.967px;" id="el55estttxwcg" class="animable"></path><path d="M295.27,388.14c-.69,4.07-3.81,12.36-3.81,12.36s14.61.59,14.94-.08l4.29-6.64Z" style="fill: rgb(196, 130, 129); transform-origin: 301.075px 394.44px;" id="el65hs0emyelt" class="animable"></path><path d="M339,291.26,301.75,312a18.47,18.47,0,0,0-9.17,19.51l7.23,39-5.93,18.85c5.12,6.86,16.87,7.21,16.87,7.21,6.56-13.15,11.37-18.73,15.09-29.75s6.21-18.62,6.21-18.62l31-8.46a36.7,36.7,0,0,0,26.83-31.22c.53-4.68.55-7.87.55-7.87Z" style="fill: rgb(69, 90, 100); transform-origin: 341.349px 343.915px;" id="el817n6xfouun" class="animable"></path><g id="elkz2nma1j8u"><path d="M336.5,303.53a17.62,17.62,0,0,0,4.17,11.36l-23.49,14.67a18.92,18.92,0,0,0-8.06,10.5l-9.31,30.45,8.4-33.91a15.37,15.37,0,0,1,6.84-9.38L336.53,314C334.05,307.8,336.5,303.53,336.5,303.53Z" style="opacity: 0.2; transform-origin: 320.24px 337.02px;" class="animable" id="el3etjy5gz74c"></path></g><path d="M299.39,419.4l.34,5.48c4.49-1.6,6.1-3.75,6.1-3.75.53-4.13.92-8.39,1.1-10.47-1.4,2.41-4.06,3.85-5.85,6A12.81,12.81,0,0,0,299.39,419.4Z" style="fill: rgb(55, 71, 79); transform-origin: 303.16px 417.77px;" id="elplhez97mz" class="animable"></path><path d="M297.52,424.06l2.21.82-.34-5.48C298.67,420.89,298.13,422.5,297.52,424.06Z" style="fill: rgb(38, 50, 56); transform-origin: 298.625px 422.14px;" id="el37w2fxxmse4" class="animable"></path><path d="M307.74,404.71a22,22,0,0,0-1.34-4.29,11.9,11.9,0,0,1-2.62,6c-1.79,2.32-4.07,4.25-5.8,6.61-2.12,2.89-3.42,6.4-6.05,8.81a11.24,11.24,0,0,1-9.69,2.68,4.94,4.94,0,0,1-3.25-1.89,2.67,2.67,0,0,1-.4-1.68,25,25,0,0,1-4.19,3c-1.66.93-3.65,1.88-4.09,3.73a4,4,0,0,0,1.84,4,10.58,10.58,0,0,0,4.44,1.48,29.06,29.06,0,0,0,10.1.17,13.91,13.91,0,0,0,8.58-5,17.92,17.92,0,0,0,2.25-4.32c.61-1.56,1.15-3.17,1.87-4.66a12.81,12.81,0,0,1,1.69-2.73c1.79-2.16,4.45-3.6,5.85-6,.07-.12.16-.24.23-.38A9,9,0,0,0,307.74,404.71Z" style="fill: rgb(69, 90, 100); transform-origin: 289.1px 417.056px;" id="elifdpwspwyng" class="animable"></path><path d="M282.24,424.53a11.24,11.24,0,0,0,9.69-2.68c2.63-2.41,3.93-5.92,6.05-8.81,1.73-2.36,4-4.29,5.8-6.61a11.9,11.9,0,0,0,2.62-6l-.45-1.1c-4.74.35-9.86.12-14.49,1.18a90.66,90.66,0,0,1-6.65,13.16,34.27,34.27,0,0,1-6.22,7.3,2.67,2.67,0,0,0,.4,1.68A4.94,4.94,0,0,0,282.24,424.53Z" style="fill: rgb(196, 130, 129); transform-origin: 292.489px 412.035px;" id="el9ar7w2zac0n" class="animable"></path><path d="M377.24,236.19a59.31,59.31,0,0,0,1-44.4c-1.74-4.54-4.2-9-8.23-11.77-5.16-3.48-11.83-3.43-18.05-3.25-3.3.1-6.67.2-9.77,1.34a10.07,10.07,0,0,0-6.45,6.79c-4.07-.75-8.17,2.46-9.27,6.45s.34,8.33,2.87,11.61,6,5.63,9.56,7.78c-2.14,1.12-3.72,3.7-4.46,6a9.46,9.46,0,0,0,.49,7,9.37,9.37,0,0,0-8.73,6.22,11.78,11.78,0,0,0,2.11,10.6,17.14,17.14,0,0,0,9.36,5.86,32,32,0,0,0,11.18.6c3.86,3.74,10.93,3.66,15.78,1.34S375.09,241.11,377.24,236.19Z" style="fill: rgb(38, 50, 56); transform-origin: 353.904px 213.346px;" id="el1pn329sa89h" class="animable"></path><path d="M342.69,226.8h-.95c-6.35.07-14.39,4.4-18.32,15.48l-15.26,29.56,17.42,7.72,9.53-27.9Z" style="fill: rgb(196, 130, 129); transform-origin: 325.425px 253.18px;" id="elvkxymzzwyfk" class="animable"></path><path d="M330.45,246.42c-1.21,3.49-1.29,7.25-1.48,11s-.62,8.14-2.31,11.43a10.49,10.49,0,0,0-12.56.46,9.68,9.68,0,0,0-2.82,4l14.3,6.34,9.53-27.9,4.69-15.38A17.84,17.84,0,0,0,330.45,246.42Z" style="fill: rgb(171, 97, 96); transform-origin: 325.54px 258.01px;" id="elzp5kylr1vyj" class="animable"></path><path d="M325.74,274.24a10.38,10.38,0,0,0-7.88-6.37c-3.49-.57-7.44,1.26-9.7,4-1.9,2.29-1.6,5.4-.4,8.13a10.14,10.14,0,0,0,11.62,5.5C323.88,284.23,327.44,278.59,325.74,274.24Z" style="fill: rgb(196, 130, 129); transform-origin: 316.485px 276.784px;" id="elzu6zw3fa3nb" class="animable"></path><path d="M344.29,226.26c-6.72,1.07-10.89,18.07-13.07,24.53-2.26,6.67.81,11.51,4.23,15.54h0a6.9,6.9,0,0,1,1.57,5.34L330,297.94c19.3,14.33,51.66,7.39,60.44,2.71a62,62,0,0,0-5.67-26.6,43.81,43.81,0,0,1-4.28-17.21l-.33-9.64,2.33-16.64-16.76-4-14.77-.66A58.78,58.78,0,0,0,344.29,226.26Z" style="fill: #FF944C; transform-origin: 360.222px 266.204px;" id="ell6thr1y7m7" class="animable"></path><g id="elgsqi6my3dfb"><path d="M344.29,226.26c-6.72,1.07-10.89,18.07-13.07,24.53-2.26,6.67.81,11.51,4.23,15.54h0a6.9,6.9,0,0,1,1.57,5.34L330,297.94c19.3,14.33,51.66,7.39,60.44,2.71a62,62,0,0,0-5.67-26.6,43.81,43.81,0,0,1-4.28-17.21l-.33-9.64,2.33-16.64-16.76-4-14.77-.66A58.78,58.78,0,0,0,344.29,226.26Z" style="opacity: 0.4; transform-origin: 360.222px 266.204px;" class="animable" id="el1drdbm1kww3"></path></g><g style="isolation: isolate; transform-origin: 329.167px 287.652px;" id="ellibqck1zr2" class="animable"><path d="M344.14,302.16v0h0a0,0,0,0,1,0,0s0,0,0-.06a77265801265.14,77265801265.14,0,0,0,0-.12l0-.06,0-.05,0-.06h0l-11.4-21.23,0-.06,0-.06,0-.06-.05-.07,0-.07a163246272339.33,163246272339.33,0,0,1-.1-.14l-.06-.06-.05-.07,0-.05,0-.05,0-.05,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0-.17-.15,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0h0l0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0-.06,0-.05,0-.06,0-.07,0-.07-.05-.08,0,0,0L317,270.74l0,0-.08,0-.07,0-.08,0-.07,0-.07,0-.07,0-.06,0-.07,0-.08,0h-.07l-.08,0H316a.31.31,0,0,0-.2.08l-1.56,1.79h.05c-.13.1-.14.31.05.66l11.4,21.23a7.35,7.35,0,0,0,2.52,2.38l13.11,7.38c.67.38,1.08.39,1.14.11,0,0,0,.1,0,.12h0l1.57-1.79a.2.2,0,0,0,0-.08.17.17,0,0,0,0-.07Zm-29.56-29.92s0,0,.09,0h0l.05,0Zm15,8.47c.12.1.25.2.36.31h0C329.86,280.91,329.73,280.81,329.61,280.71Zm.82.8.16.17h0ZM342.57,304a1.17,1.17,0,0,0-.14-.43,1.24,1.24,0,0,1,.14.39h0S342.56,303.94,342.57,304Z" style="fill: rgb(69, 90, 100); transform-origin: 329.167px 287.652px;" id="elbcojj4au68h" class="animable"></path></g><g id="elipvha58k20e"><path d="M344.14,302.16v0h0a0,0,0,0,1,0,0s0,0,0-.06a77265801265.14,77265801265.14,0,0,0,0-.12l0-.06,0-.05,0-.06h0l-11.4-21.23L331,282.3l11.41,21.23a1.24,1.24,0,0,1,.14.39h0a.26.26,0,0,1-.05.24h0l1.57-1.79a.2.2,0,0,0,0-.08.17.17,0,0,0,0-.07Z" style="fill: rgb(255, 255, 255); opacity: 0.15; transform-origin: 337.57px 292.37px;" class="animable" id="ely2o98pjcnr"></path></g><g id="el3rnnm1vp12s"><path d="M332.55,280.45l0-.06,0-.06-.05-.07,0-.07a163246272339.33,163246272339.33,0,0,1-.1-.14l-.06-.06-.05-.07,0-.05,0-.05,0-.05,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0-.17-.15,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0h0l0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0-.06,0-.05,0-.06,0-.07,0-.07-.05-.08,0,0,0L317,270.74l0,0-.08,0-.07,0-.08,0-.07,0-.07,0-.07,0-.06,0-.07,0-.08,0h-.07l-.08,0H316a.31.31,0,0,0-.2.08l-1.56,1.79q.11-.12.39-.06h0a2.77,2.77,0,0,1,.72.3l13.11,7.38a5.33,5.33,0,0,1,.75.49h0a8.42,8.42,0,0,1,.72.62h0a6.32,6.32,0,0,1,.62.66h0a3.89,3.89,0,0,1,.43.62l1.57-1.79Z" style="fill: rgb(255, 255, 255); opacity: 0.2; transform-origin: 323.395px 276.68px;" class="animable" id="el8jdsgs618p6"></path></g><path d="M388.92,236.12c-1.86-3.19-4.3-5.64-8-5.92,0,0-6,3.12-6,17.28l.4,35.43h0c-.87.35-1.74.72-2.6,1.08a106,106,0,0,1-22.79,6.89A22.51,22.51,0,0,0,335.55,286l1.93,3.6c-3.66,2.35-11.94-1.88-11.94-1.88-.61,5.16,2.74,10.52,7.18,13.23s46.78-1.27,55.76-7.08c5.91-3.82,4.51-40.35,4.51-40.35A30.56,30.56,0,0,0,388.92,236.12Z" style="fill: rgb(196, 130, 129); transform-origin: 359.301px 266.009px;" id="elm53j3jpny4" class="animable"></path><path d="M316.59,277a24.48,24.48,0,0,0-.48,4.23,15.49,15.49,0,0,0,4.08,9.06,4.6,4.6,0,0,0,1.76,1.24,2,2,0,0,0,2-.32,3.07,3.07,0,0,0,.71-2.13,11.25,11.25,0,0,0-.19-3.43,4.75,4.75,0,0,0-1.81-2.85,10.22,10.22,0,0,0-2.29-1,5.6,5.6,0,0,1-2-1.48Z" style="fill: rgb(196, 130, 129); transform-origin: 320.412px 284.334px;" id="ela7cbbdtc6c4" class="animable"></path><path d="M350.91,219.33v13.38c-1.31,1.24-2.57,2.66-2.69,4.43a4.62,4.62,0,0,0,2.39,4.17,6.51,6.51,0,0,0,4.92.48,11.22,11.22,0,0,0,4.35-2.52,18.08,18.08,0,0,0,5.8-12.7V213Z" style="fill: rgb(196, 130, 129); transform-origin: 356.949px 227.533px;" id="el957z5cy6xem" class="animable"></path><path d="M365.11,213c-1.4,7.36-4.27,13.74-14.2,16v-9.72Z" style="fill: rgb(171, 97, 96); transform-origin: 358.01px 221px;" id="elicq1pg89nm" class="animable"></path><path d="M361.64,205.26a14.54,14.54,0,0,0,0,3.55,4.2,4.2,0,0,0,1.27,2.32,2.65,2.65,0,0,0,2.42.61,4.63,4.63,0,0,1,8.89-2.56,5.78,5.78,0,0,1-.77,4.85,11,11,0,0,1-3.73,3.38,3.91,3.91,0,0,1-4.74-1.64c-4.27,5.89-11.94,10.49-19.31,10.17A10.52,10.52,0,0,1,340,224.2c-2.86-2-3.2-5.27-3.68-8.47a45.07,45.07,0,0,1-.41-12.22c.67-5.62,2.93-11.22,7.12-15C346,200.53,357.34,204.54,361.64,205.26Z" style="fill: rgb(196, 130, 129); transform-origin: 355.06px 207.233px;" id="elcptk4ovtcwh" class="animable"></path><polygon points="346.28 204.5 341.5 210.91 346.25 212.33 346.28 204.5" style="fill: rgb(171, 97, 96); transform-origin: 343.89px 208.415px;" id="elb87tdgdxevm" class="animable"></polygon><path d="M350.67,215.18l-3.87,1.4a2.43,2.43,0,0,0,2.71,1.08A2.18,2.18,0,0,0,350.67,215.18Z" style="fill: rgb(171, 97, 96); transform-origin: 348.767px 216.462px;" id="elkbrgxy2hlo" class="animable"></path><g id="elzk66ovwm51"><path d="M350.67,215.18l-3.87,1.4a2.43,2.43,0,0,0,2.71,1.08A2.18,2.18,0,0,0,350.67,215.18Z" style="opacity: 0.3; transform-origin: 348.767px 216.462px;" class="animable" id="el5e93xdavypk"></path></g><path d="M348.22,217.65a2.27,2.27,0,0,0,1.29,0,2,2,0,0,0,1.18-1.83,2.23,2.23,0,0,0-2.47,1.82Z" style="fill: rgb(171, 97, 96); transform-origin: 349.455px 216.773px;" id="elgr88dluop2t" class="animable"></path><path d="M353.26,205.51a1.4,1.4,0,1,1-1.39-1.4A1.39,1.39,0,0,1,353.26,205.51Z" style="fill: rgb(38, 50, 56); transform-origin: 351.86px 205.51px;" id="eluwmt13pqmw" class="animable"></path><path d="M341.53,205a1.41,1.41,0,0,1-1.41,1.39,1.4,1.4,0,0,1,0-2.8A1.41,1.41,0,0,1,341.53,205Z" style="fill: rgb(38, 50, 56); transform-origin: 340.125px 204.99px;" id="eloy6uqejjm9c" class="animable"></path><path d="M340.19,199.44l-3.11,2.13a2,2,0,0,1,.62-2.19A2.36,2.36,0,0,1,340.19,199.44Z" style="fill: rgb(38, 50, 56); transform-origin: 338.581px 200.312px;" id="elxrmruftsuwm" class="animable"></path><path d="M352.16,199.32l3.09,2.16a2,2,0,0,0-.59-2.2A2.37,2.37,0,0,0,352.16,199.32Z" style="fill: rgb(38, 50, 56); transform-origin: 353.764px 200.212px;" id="el9f92w9xgto" class="animable"></path></g><defs>     <filter id="active" height="200%">         <feMorphology in="SourceAlpha" result="DILATED" operator="dilate" radius="2"></feMorphology>                <feFlood flood-color="#32DFEC" flood-opacity="1" result="PINK"></feFlood>        <feComposite in="PINK" in2="DILATED" operator="in" result="OUTLINE"></feComposite>        <feMerge>            <feMergeNode in="OUTLINE"></feMergeNode>            <feMergeNode in="SourceGraphic"></feMergeNode>        </feMerge>    </filter>    <filter id="hover" height="200%">        <feMorphology in="SourceAlpha" result="DILATED" operator="dilate" radius="2"></feMorphology>                <feFlood flood-color="#ff0000" flood-opacity="0.5" result="PINK"></feFlood>        <feComposite in="PINK" in2="DILATED" operator="in" result="OUTLINE"></feComposite>        <feMerge>            <feMergeNode in="OUTLINE"></feMergeNode>            <feMergeNode in="SourceGraphic"></feMergeNode>        </feMerge>            <feColorMatrix type="matrix" values="0   0   0   0   0                0   1   0   0   0                0   0   0   0   0                0   0   0   1   0 "></feColorMatrix>    </filter></defs></svg>
                </div>

                <div class="text-center mb-5">

                    <div class="fw-300 mb-3">Amplía tu alcance y <span class="fw-600">aumenta tus posibilidades de ventas</span> al compartir tu tienda.💵🤑</div>

                    <input style="display: none;" class="" id="enlaceTienda" type="text" value="<?php echo $dominio . $_SESSION['managedStore']; ?>">

                    <a href="<?php echo $dominio . $_SESSION['managedStore']; ?>" target="_blank" class="fs-4 fw-300 text-decoration-underline text-center">
                        <?php echo "conejondigital.com/" . $_SESSION['managedStore']; ?>
                        <i class="ms-1 mt-1 feather-sm" data-feather="external-link"></i>
                    </a>

                </div>

                <div class="container">

                    <div class="row">

                        <!-- <input class="border border-0 rounded rounded-2 shadow-none p-2 small fw-400 text-center mb-2 w-100 shadow-none" id="enlaceTienda" onClick="copiarPortapapeles('enlaceTienda');" type="text" value="<?php echo $dominio . $_SESSION['managedStore']; ?>" readonly>                                                         -->

                        <div class="col">
                            <button class="btn btn-indigo w-100 btn-lg mb-2" name="button" onclick="javascript: makeCodeUrlPago('<?php echo $dominio . $_SESSION["managedStore"]; ?>');">
                                Descargar QR <i class="fas fa-qrcode ms-2"></i>
                            </button>
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-pink w-100 btn-lg mb-2" id="idPortapapeles" name="button" onClick="copiarPortapapeles('enlaceTienda');">
                                Copiar enlace <i class="far fa-clipboard ms-2"></i>
                            </button>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col">
                            <a class="btn btn-primary w-100 btn-lg mb-2" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $dominio . $idTienda; ?>" target="_blank">
                                Facebook <i class="fab fa-facebook ms-2"></i>
                            </a>
                        </div>
                        <div class="col">
                            <a target="_blank" href="https://api.whatsapp.com/send?text=Conoce _*<?php echo $_SESSION['managedStore']; ?>*_, entra ahora y encuentra productos increíbles: _<?php echo $dominio . $_SESSION['managedStore']; ?>_" class="btn btn-success w-100 btn-lg mb-2" name="button">
                                Whatsapp <i class="fab fa-whatsapp ms-2"></i>
                            </a>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>
</div>
<!-- modal Compartir Tienda -->

<!-- modal eliminar producto Inicio-->
<div class="modal fade" id="modalEliminarProducto" tabindex="-1" aria-labelledby="modalEliminarProductoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEliminarProductoLabel">Confirmación</h5>
                <button type="button" class="btn btn-icon btn-outline-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark fa-xl"></i>
                </button>
            </div>

            <form class="" action="procesa.php" method="post">
                <div class="modal-body">
                    Estás a punto de eliminar este producto de tu inventario. ¿Deseas continuar?
                    <?php
                    if (isset($idProducto))
                    {
                        ?>
                            <input type="hidden" id="idProductDelete" name="idProductDelete" value="<?php echo $idProducto; ?>" required>
                            <input type="hidden" name="idTienda" value="<?php echo $managedStore; ?>">
                        <?php
                    }
                    ?>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <?php
                        if (isset($idProducto))
                        {
                            ?>
                            <button type="submit" class="btn btn-danger" name="btnEliminarProducto">
                                Sí, eliminar
                            </button>
                            <?php
                        }
                    ?>

                </div>
          </form>
        </div>
    </div>
</div>
<!-- modal eliminar producto Fin -->

<!-- iniciar turno caja -->
<div class="modal fade" id="modalIniciarTurnoCaja" tabindex="-1" aria-labelledby="modalIniciarTurnoCajaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form class="" action="procesa.php" method="post" onsubmit="return validarFechas()">
                <div class="modal-header">
                    <h5 class="modal-title text-primary fw-600"><i class="fas fa-unlock-alt"></i> Iniciar turno de caja</h5>
                    <button type="button" class="btn btn-icon btn-outline-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark fa-xl"></i>
                    </button>
                </div>
                <div class="modal-body">

                  <div class="mb-2 text-dark">
                      <div class="row mb-3">
                          <label for="fechaInicio" class="text-center text-dark fw-500 mb-3">¿Con cuánto efectivo en caja inicias el turno?</label>
                          <div class="">
                              <input type="number" class="form-control border border-3 fs-6 text-center" id="efectivoCaja" min="0" step="0.5" name="efectivoInicialCaja" placeholder="0" required>
                          </div>
                      </div>
                  </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light rounded-2" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary rounded-2" name="btnIniciarTurnoCaja">Iniciar <i class="ms-1" data-feather="arrow-right-circle"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- iniciar turno caja -->


<!-- modal eliminar categoria Inicio-->
<div class="modal fade" id="modalEliminarCategoria" tabindex="-1" aria-labelledby="modalEliminarCategoriaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEliminarCategoriaLabel">Eliminar categoría</h5>
                <button type="button" class="btn btn-icon btn-outline-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark fa-xl"></i>
                </button>
            </div>
            <form class="" action="procesa.php" method="post">
                <div class="modal-body">
                    ¿Deseas eliminar esta categoría?
                    <input type="hidden" name="idCategoriaEliminar" id="idCategoriaEliminar" value="" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger" name="btnEliminarCategoria">Sí, eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- modal eliminar categoria Fin -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Acceso Conejón Navideño 2023</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
            <input id="text" type="text" value="https://vendy.click/" style="width:80%; display:none;" />
                
                <h2 class="f-poppins sombra-titulos-vendy text-green text-center display-6 fw-500"><?php echo ucwords(strtolower($_SESSION['nombre'])); ?></h2>
                <div id="qrcode-contenedor" style=""></div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-green rounded-2 fs-5 w-100" href="mis-conejos.php">
                    Registra tu cheñol 🐰
                </a> 
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDevoluciones" tabindex="-1" aria-labelledby="modalNoCalificarPedidoLabel" aria-hidden="true">
    <div class="modal-dialog  ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary fw-600">
                    Devolución
                </h5>
                <button type="button" class="btn btn-icon btn-outline-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark fa-xl"></i>
                </button>
            </div>

            <form action="procesa.php" method="post">
                <div class="modal-body">
                <?php
                    if ($detallesProducto !== false)
                    {
                        ?>
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <thead class="border-bottom">
                                    <tr class="small text-uppercase text-pink">
                                        <th scope="col">Artículo</th>
                                        <th class="text-end" scope="col">Cantidad</th> 
                                        <th class="text-end" scope="col">Por Devolver</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if(isset($detallesProducto))
                                        {                                    
                                            foreach ($detallesProducto as $key => $val)
                                            {
                                                ?>
                                                <tr class="border-bottom small">
                                                    <td>
                                                        <div class="fw-bold">
                                                            <!-- <a href="../detalleProducto.php?idProducto=<?php echo $val['idProducto']; ?>&idVendedor=<?php //echo $val['idVendedor']; ?>" target="_blank"><?php //echo $val['nombre']; ?></a> -->
                                                            <?php echo $val['nombre']; ?>
                                                        </div>
                                                        <div class="small text-muted d-none d-md-block">
                                                            <?php
                                                                echo mb_strimwidth($val['descripcion'], 0, 100, "...");
                                                            ?>
                                                        </div>
                                                    </td>

                                                    <?php $unidadVenta = $val['unidadVenta'] === 'Kilogramos' ? 'Kgs.' : 'Pz(s).'; ?>
                                                    <td class="text-end fs-6 fw-300 small">
                                                        <?php echo $val['cantidad'] . " " . $unidadVenta; ?>
                                                    </td>

                                                    <td class="text-end fw-700 text-end">
                                                        <div class="d-flex justify-content-center">
                                                            <?php
                                                                if ($val['unidadVenta'] === 'Kilogramos') 
                                                                {
                                                                ?>
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox" id="" value="1" name="<?php echo $val['idProducto']; ?>">                                                            
                                                                </div>
                                                                <?php
                                                                }
                                                                else
                                                                {
                                                                ?>
                                                                    <input type="number" class="form-control border border-3 rounded-3 poppins-font shadow-none text-center" value="0" max="<?php echo $val['cantidad']; ?>" min="0" name="<?php echo $val['idProducto']; ?>" required>
                                                                <?php
                                                                }
                                                                
                                                            ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                    }
                ?>
                </div>            

                <div class="modal-footer">
                    <input type="hidden" name="idTienda" value="<?php echo $idTienda; ?>" required>
                    <input type="hidden" name="idPedido" value="<?php echo $idPedido; ?>" required>
                    <button type="button" class="btn btn-secondary rounded-2" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-outline-success rounded-2" name="btnDevolucion" value="Egreso">
                        <!-- <i class="me-2 " data-feather="plus"></i>  -->
                        Continuar
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Modal Confirmar Pago -->
<div class="modal fade" id="modalFinalizarPedidoPDV" tabindex="-1" aria-labelledby="modalFinalizarPedidoPDVLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-gray-600 fw-600">
                                                            <i data-feather="user-plus" class="me-1 feather-lg"></i>
                                                            Asignar cliente
                                                        </h5>
                                                        <button type="button" class="btn btn-icon border border-1 border-gray-600 btn-sm" data-bs-dismiss="modal" aria-label="Close">
                                                            <i class="fa-solid fa-xmark fa-xl"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="fw-300">Se enviará el resumen del pedido al cliente, incluso si aún no tiene una cuenta <span class="fw-600">vendy</span>.</p>
                                                        <div class="mb-3 text-dark">
                                                            <label for="" class="text-primary fw-600 mb-1">Correo del cliente:</label>
                                                            <input type="email" class="form-control text-center" name="idCliente" id="idCliente" placeholder="correo@ejemplo.com" value="" style="display: ;">
                                                        </div>
                                                        <div class="d-flex justify-content-end">
                                                            <label class="form-check-label me-2 fw-200" style="cursor: pointer;" for="inputAsignarCliente">No asignar cliente</label>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" style="cursor: pointer;" type="checkbox" id="inputAsignarCliente" onchange="toggleClienteInput()">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" name="button" class="btn btn-light rounded-2 fw-500" data-bs-dismiss="modal">
                                                            Cerrar
                                                        </button>
                                                        <button type="submit" class="btn btn-success fw-500 fs-6 rounded-2" onclick="return validaFormulario_pagoPos();" name="btnCrearPedido" value="PDV">
                                                            Finalizar
                                                            <i data-feather="check-circle" class="fa-fade me-1 ms-1 feather-lg"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Modal Confirmar Pago -->

            <div class="modal fade" id="modalNuevaMascota" tabindex="-1" aria-labelledby="modalNuevaMascotaLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title fs-4 fw-600 text-primary" id="modalNuevaMascotaLabel"> <i class="fas fa-carrot me-1"></i> Registra tu cheñol</h5>
                            <button type="button" class="btn btn-icon btn-outline-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa-solid fa-xmark fa-xl"></i>
                            </button>
                        </div>

                        <form class="" action="../app/procesa.php" method="post" enctype="multipart/form-data">
                            <div class="modal-body">

                                <div class="container"> 
                                    
                                    <label for="">Nombre:</label>
                                    <input type="text" class="form-control form-control-lg text-center fs-2 border-4 border-blue-soft shadow-none mb-2" placeholder="Cheñol" name="nombreMascota" id="" value="" required>

                                    <label for="">Agrega una foto:</label>
                                    <input type="file" class="form-control mb-2" name="fotoMascota" id="fotoMascota" required> 

                                    <label for="">Fecha de nacimiento:</label>
                                    <input type="date" class="form-control mb-2" name="fechaNacimiento" id="fechaNacimiento" max="<?php echo date('Y-m-d'); ?>" required>

                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-success" name="btnRegistraMascota">Guardar</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>



<div class="modal fade" id="modalDescargaEtiquetaProducto" tabindex="-1" aria-labelledby="modalNoCalificarPedidoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary fw-600">
                    <i class="fas fa-receipt"></i>
                    Etiqueta de producto
                </h5>
                <button type="button" class="btn btn-icon btn-outline-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark fa-xl"></i>
                </button>
            </div>

            <div class="modal-body">
                <div id="codigoBarrasEtiqueta"></div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modalNoCalificarPedido" tabindex="-1" aria-labelledby="modalNoCalificarPedidoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary fw-600">
                    <i class="fas fa-bullhorn"></i>
                    Cuéntanos tu experiencia
                </h5>
                <button type="button" class="btn btn-icon btn-outline-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark fa-xl"></i>
                </button>
            </div>

            <div class="modal-body">
                <div class="text-center text-danger">
                    No puedes calificar el pedido hasta que lo recibas.
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal Categorias -->
<div class="modal fade" id="modalEditarCategoria" tabindex="-1" aria-labelledby="modalEditarCategoriaLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0">
      <div class="modal-header bg-white border-1 border-bottom">
        <h5 class="modal-title text-gray" id="modalDatosPagoLabel"> Editar Categoría </h5>
        <button type="button" class="btn btn-icon btn-outline-indigo btn-sm" data-bs-dismiss="modal" aria-label="Close">
            <i class="fa-solid fa-xmark fa-xl"></i>
        </button>
      </div>
      <div class="modal-body bg-white text-gray border-0 rounded-bottom">

        <form id="formulario-categorias" action="procesa.php" method="post">

            <div class="input-group mb-2">
                <input type="text" class="form-control text-center text-dark" placeholder="Categoría" aria-label="Categoría" aria-describedby="Categoría" id="categoriaNombre" name="categoria" required>
                <input type="hidden" class="form-control" id="idCategoria" name="idCategoria" required>
                <button class="btn btn-secondary sin-borde" type="submit" name="btnActualizarCategoria">Actualizar</button>
            </div>

        </form>

      </div>
    </div>
  </div>
</div>
<!-- modal Categorias Fin -->

<div class="modal fade" id="modalCategoriasPost" tabindex="-1" aria-labelledby="modalCategoriasPostLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0">
      <div class="modal-header bg-white border-1 border-bottom">
        <h5 class="modal-title text-primary fw-500" id="modalDatosPagoLabel"> Nueva Categoría </h5>
        <button type="button" class="btn btn-icon btn-outline-indigo btn-sm" data-bs-dismiss="modal" aria-label="Close">
            <i class="fa-solid fa-xmark fa-xl"></i>
        </button>
      </div>
      <div class="modal-body bg-white text-gray border-0 rounded-bottom">
          <!-- Formulario de registro de categorías -->
          <form id="" action="procesa.php" method="post">

            <div class="input-group mb-3">
                <input type="text" class="form-control sin-borde border-indigo text-dark text-center" placeholder="Electrónicos, Abarrotes, Etc" aria-label="Categoría" aria-describedby="Categoría" id="categoriaNombreNueva" name="categoria" autocomplete="off" required>
                <button class="btn btn-indigo border-1 sin-borde" type="submit" name="btnRegistrarCategoria">Registrar</button>
            </div>

          </form>

      </div>
    </div>
  </div>
</div>

<!-- Modal Calificar Pedido -->
<div class="modal fade" id="modalCalificarPedido" tabindex="-1" aria-labelledby="modalCalificarPedidoLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title text-primary fw-600">
                      <i class="fas fa-bullhorn"></i>
                      Cuéntanos tu experiencia
                  </h5>
                  <button type="button" class="btn btn-icon btn-outline-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">
                      <i class="fa-solid fa-xmark fa-xl"></i>
                  </button>
              </div>
              <form class="" action="procesa.php" method="post">

                  <div class="modal-body">

                      <style type="text/css">

                          .rate {
                              margin: 0 auto;
                              height: 46px;
                              padding: 0 10px;
                          }
                          .rate:not(:checked) > input {
                              position:absolute;
                              top:-9999px;
                          }
                          .rate:not(:checked) > label {
                              float:right;
                              width:1em;
                              overflow:hidden;
                              white-space:nowrap;
                              cursor:pointer;
                              font-size:3em;
                              color:#ccc;
                          }
                          .rate:not(:checked) > label:before {
                              content: '★ ';
                          }
                          .rate > input:checked ~ label {
                              color: #fccb19;
                          }
                          .rate:not(:checked) > label:hover,
                          .rate:not(:checked) > label:hover ~ label {
                              color: #ffc700;
                          }
                          .rate > input:checked + label:hover,
                          .rate > input:checked + label:hover ~ label,
                          .rate > input:checked ~ label:hover,
                          .rate > input:checked ~ label:hover ~ label,
                          .rate > label:hover ~ input:checked ~ label {
                          color: #c59b08;
                      }

                      </style>

                      <div class="d-flex justify-content-center">
                          <div class="rate">
                            <input type="radio" id="star5" name="rate" value="5" required/>
                            <label for="star5" title="5 Estrellas">5 Estrellas</label>

                            <input type="radio" id="star4" name="rate" value="4" />
                            <label for="star4" title="4 Estrellas">4 Estrellas</label>

                            <input type="radio" id="star3" name="rate" value="3" />
                            <label for="star3" title="3 Estrellas">3 Estrellas</label>

                            <input type="radio" id="star2" name="rate" value="2" />
                            <label for="star2" title="2 Estrellas">2 Estrellas</label>

                            <input type="radio" id="star1" name="rate" value="1" />
                            <label for="star1" title="1 Estrella">1 Estrella</label>
                          </div>
                      </div>
                      <br>
                      <div class="">
                          <div class="form-group">
                              <label class="small mb-2" for="exampleFormControlTextarea1">Comentarios: </label>
                              <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="comentarios" required></textarea>
                          </div>
                      </div>
                  </div>
                  <div class="modal-footer">
                    <input type="hidden" name="idTienda" value="<?php echo $datosPedido['idTienda']; ?>" required>
                      <button type="submit" class="btn btn-primary rounded-2 fs-6" value="<?php echo $idPedido; ?>" name="btnCalificaPedido">
                          Guardar
                      </button>
                  </div>
              </form>
          </div>
      </div>
  </div>
<!-- Modal Calificar Pedido -->

<!-- iniciar modalCreandoPedido -->
<div class="modal fade" id="modalCreandoPedido" tabindex="-1" aria-labelledby="modalCreandoPedidoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered rounded-2">
        <div class="modal-content bg-ama">
            <div class="modal-body bg-pattern-ama rounded-2">

                <div class="d-flex justify-content-center mb-5 mt-4">
                  <div class="spinner"></div>

                  <style>
                      .spinner {
                         position: relative;
                         width: 20.4px;
                         height: 20.4px;
                      }

                      .spinner::before,
                      .spinner::after {
                         content: '';
                         width: 100%;
                         height: 100%;
                         display: block;
                         animation: spinner-b4c8mmmd 0.5s backwards, spinner-49opz7md 1.25s 0.5s infinite ease;
                         border: 5.6px solid #2d4271;
                         border-radius: 50%;
                         box-shadow: 0 -33.6px 0 -5.6px #2d4271;
                         position: absolute;
                      }

                      .spinner::after {
                         animation-delay: 0s, 1.25s;
                      }

                      @keyframes spinner-b4c8mmmd {
                         from {
                            box-shadow: 0 0 0 -5.6px #ffffff;
                         }
                      }

                      @keyframes spinner-49opz7md {
                     to {
                        transform: rotate(360deg);
                     }
                  }
                  </style>
                </div>
                <div class="mb-2 text-dark text-center fs-1 font-poppins fw-300">
                    Estamos creando tu pedido...
                </div>

            </div>

        </div>
    </div>
</div>
<!-- iniciar modalCreandoPedido -->

<!--  modal Seccion de pago -->
<div class="modal fade" id="modalSeccionDePago" tabindex="-1" aria-labelledby="modalSeccionDePagoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-600">
                    <span class="fs-1 text-yellow logo">
                        <i class="fas fa-store fa-sm"></i> vendy
                    </span>
                </h5>
                <button type="button" class="btn btn-icon btn-outline-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark fa-xl"></i>
                </button>
            </div>
            <div class="m-0 bg-pattern-white">


                <div class="row align-items-center justify-content-between m-3 mb-4">
                    <div class="col d-none d-lg-block mt-xxl-n4">
                        <img class="img-fluid px-xl-4 mt-xxl-n5" src="assets/img/stats.svg" alt="img28" />
                    </div>
                    <div class="col">
                        <div class="text-primary fs-2 mb-3">
                            Adquiere tu licencia

                            <span class="fs-1 fw-700 text-yellow logo">
                                vendy
                            </span>
                            <span class="small text-dark border border-1 border-dark rounded-3 p-1 fw-300">Pro</span>

                            e impulsa tu negocio al máximo
                            <i class="fas fa-rocket"></i>
                        </div>
                        <p class="text-gray-600 fw-300"> <span class="text-gray-600 fw-500">¡Accede a todas las funciones!</span>  Tienda en línea, punto de venta, reporte de ventas, estadísticas en tiempo real, <span class="fw-500">0% de comisión</span> por venta, asesoría y soporte 24/7 y ¡mucho más!</p>
                        <a class="btn btn-success p-3 w-100 rounded-2 fs-6" href="https://mpago.la/2EdMqpU">
                            Aprovechar oferta&nbsp;<small>$1,800</small>
                        </a>
                        <div class="text-danger fw-500 small text-center m-2">
                          Precio normal $3,300
                        </div>
                        <div class="text-dark fw-300 text-center small m-2" id="salidaContador"></div>

                    </div>
                </div>

                <div class="bg-pattern-pdv m-0">
                    <div class="p-4 pt-2">
                        <div class="text-start text-center mt-3 mb-2">
                            <span class="text-white fs-2">Beneficios</span>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="list-group list-group-flush small rounded-2">
                                    <a class="list-group-item list-group-item-action bg-transparent text-white" href="#!">
                                        <i class="fas fa-cash-register fa-fw text-yellow me-2"></i>
                                        Tienda en línea + Punto de venta
                                    </a>
                                    <a class="list-group-item list-group-item-action bg-transparent text-white" href="#!">
                                        <i class="fas fa-truck fa-fw text-green me-2"></i>
                                        Ofrece pickup en sucursal y envío a domicilio
                                    </a>
                                    <a class="list-group-item list-group-item-action bg-transparent text-white" href="#!">
                                        <i class="fas fa-percentage fa-fw text-yellow me-2"></i>
                                        Calculadora de precio de venta incluida
                                    </a>
                                    <a class="list-group-item list-group-item-action bg-transparent text-white" href="#!">
                                        <i class="fas fa-chart-pie fa-fw text-pink me-2"></i>
                                        Gestiona tus ganancias fácilmente
                                    </a>
                                </div>
                            </div>
                            <div class="col-6">
                            <div class="list-group list-group-flush small rounded-2">
                                <a class="list-group-item list-group-item-action bg-transparent text-white" href="#!">
                                    <i class="me-1 me-2 fa-fw text-pink" data-feather="smartphone"></i>
                                    Administra tu negocio desde cualquier parte del mundo
                                </a>
                                <a class="list-group-item list-group-item-action bg-transparent text-white" href="#!">
                                    <i class="fas fa-store fa-fw text-green me-2"></i>
                                    Sucursales ilimitadas
                                </a>
                                <a class="list-group-item list-group-item-action bg-transparent text-white" href="#!">
                                    <i class="fas fa-headset fa-fw text-yellow me-2"></i>
                                    Asesoría y soporte técnico 24/7
                                </a>
                                <a class="list-group-item list-group-item-action bg-transparent text-white" href="#!">
                                    <i class="me-1 me-2 fa-fw text-pink" data-feather="bar-chart-2"></i>
                                    Estadísticas en tiempo real
                                </a>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="p-3 border-0 bg-transparent text-end">
                        <a href="https://mpago.la/2EdMqpU" class="btn btn-outline-white rounded-2 fs-6 p-3">
                            Aprovechar oferta&nbsp;<small>$1,800</small>
                        </a>
                    </div>
                </div>


            </div>

        </div>
    </div>
</div>
<!--  modal Seccion de pago -->