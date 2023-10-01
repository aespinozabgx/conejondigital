<div class="modal fade" id="modalCuentaExistente" tabindex="-1" aria-labelledby="modalCuentaExistenteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary fw-600">
                    Cuenta existente
                </h5>
                <button type="button" class="btn btn-icon btn-outline-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark fa-xl"></i>
                </button>
            </div>

            <form action="tienda/procesa.php" method="post">
                <div class="modal-body">
                DATOS DE REGISTRO
                </div>            

                <div class="modal-footer">
                    <input type="hidden" name="idTienda" value="<?php echo $idTienda; ?>" required>
                    <input type="hidden" name="idPedido" value="<?php echo $idPedido; ?>" required>
                    
                    <button type="submit" class="btn btn-outline-success rounded-2" name="btnRegistroExpositor">
                        <!-- <i class="me-2 " data-feather="plus"></i>  -->
                        Registrar
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="modalRegistroExpositor" tabindex="-1" aria-labelledby="modalRegistroExpositorLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary fw-600">
                    Registro expositor
                </h5>
                <button type="button" class="btn btn-icon btn-outline-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark fa-xl"></i>
                </button>
            </div>

            <form action="tienda/procesa.php" method="post">
                <div class="modal-body">
                DATOS DE REGISTRO
                </div>            

                <div class="modal-footer">
                    <input type="hidden" name="idTienda" value="<?php echo $idTienda; ?>" required>
                    <input type="hidden" name="idPedido" value="<?php echo $idPedido; ?>" required>
                    
                    <button type="submit" class="btn btn-outline-success rounded-2" name="btnRegistroExpositor">
                        <!-- <i class="me-2 " data-feather="plus"></i>  -->
                        Registrar
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="modalRegistroVisitante" tabindex="-1" aria-labelledby="modalRegistroExpositorLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary fw-600">
                    Registro
                </h5>
                <button type="button" class="btn btn-icon btn-outline-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark fa-xl"></i>
                </button>
            </div>

            <form action="procesa.php" method="post">
                
                <div class="modal-body">
                    <h1 class="f-bangers text-center display-6 text-pink mb-2">Conejón Navideño 2023</h1>

                    <p class="small text-center">Registrate para asistir totalmente GRATIS al próximo Conejón y puedas llevar a tu cheñol contigo</p>
                    
                    <div class="row">
                        <div class="mb-2 col-6">
                            <label class="text-primary">Nombre: </label>
                            <input type="text" class="form-control" placeholder="Nombre(s)">
                        </div>

                        <div class="mb-2 col-6">
                            <label class="text-primary">Apellido: </label>
                            <input type="text" class="form-control" placeholder="Apellido(s)">
                        </div>
                    </div>

                    <div class="mb-2">
                            <label class="text-primary">Email: </label>
                            <input type="text" class="form-control" placeholder="correo@dominio.com">
                        </div>
                    

                </div>            

                <div class="modal-footer">
                    <input type="hidden" name="idTienda" value="<?php echo $idTienda; ?>" required>
                    <input type="hidden" name="idPedido" value="<?php echo $idPedido; ?>" required>
                    <button type="button" class="btn btn-secondary rounded-2" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-outline-success rounded-2" name="btnRegistroExpositor" value="Egreso">
                        <!-- <i class="me-2 " data-feather="plus"></i>  -->
                        Continuar
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
