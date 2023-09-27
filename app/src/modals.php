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
                    <div class="col d-none d-lg-block mt-xxl-n4"><img class="img-fluid px-xl-4 mt-xxl-n5" src="assets/img/stats.svg" /></div>
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