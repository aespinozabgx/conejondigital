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

            <form action="app/procesa.php" method="post">
                
                <div class="modal-body">
                                    
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo electrónico:*</label>
                        <div class="input-group">
                            <span class="input-group-text"><i data-feather="mail"></i></span>
                            <input type="email" class="form-control" id="correo" placeholder="correo@dominio.com" name="correo" required>                        
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="nombre" class="form-label">¿Cómo te llamas?*</label>
                        <div class="input-group">
                            <span class="input-group-text"><i data-feather="user"></i></span>                        
                            <input type="text" class="form-control" id="nombre" placeholder="Nombre" name="nombre" required>
                        </div>
                        
                    </div>
                    
                    <div class="mb-3">
                        <label for="whatsapp" class="form-label">Whatsapp (10 dígitos)*</label>
                        <div class="input-group">
                            <span class="input-group-text"><i data-feather="phone"></i></span>
                            <input type="tel" class="form-control" id="whatsapp" name="whatsapp" placeholder="10 dígitos" pattern="[0-9]{10}" required>
                        </div>                    
                    </div>
                    
                    <div class="mb-3">
                        <label for="nombre_negocio" class="form-label">Nombre de tu negocio/empresa*</label>
                        <div class="input-group">
                            <span class="input-group-text"><i data-feather="briefcase"></i></span>
                            <input type="text" class="form-control" id="nombre_negocio" placeholder="Negocio" name="nombre_negocio" required>                        
                        </div>                    
                    </div>
                    
                    <div class="mb-3">
                        <label for="productos" class="form-label">Si eres seleccionado, ¿Qué productos pretendes vender en el Conejón Navideño 2023?*</label>
                        <textarea class="form-control" id="giro_negocio" name="giro_negocio" rows="3" required></textarea>
                    </div>
 

                    <div class="mb-3">
                        <label for="sitio_web" class="form-label">Sitio web o Redes sociales de tu negocio*</label>                     
                        <textarea class="form-control" id="contacto_negocio" name="contacto_negocio" rows="3" required></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="enteraste" class="form-label">¿Cómo te enteraste de este evento?*</label>
                        <input type="text" class="form-control" id="como_te_enteraste" name="como_te_enteraste" required>
                    </div>

                </div>            

                <div class="modal-footer">
                    <!-- <input type="hidden" name="idTienda" value="<?php //echo $idTienda; ?>" required>
                    <input type="hidden" name="idPedido" value="<?php //echo $idPedido; ?>" required> -->
                    
                    <button type="submit" class="btn btn-blue rounded-2" name="btnRegistroExpositor">
                        <!-- <i class="me-2 " data-feather="plus"></i>  -->
                        Registrarme
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="modalRegistroVisitante" tabindex="-1" aria-labelledby="modalRegistroVisitanteLabel" aria-hidden="true">
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
