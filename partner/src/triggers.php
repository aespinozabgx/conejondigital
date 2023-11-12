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

          case 'cargaCompleta':
              echo "<script>
                      Swal.fire({
                          title: 'Listo!',
                          text: 'Guardado exitosamente',
                          icon: 'success',
                          showConfirmButton: true,
                          confirmButtonText: 'Entendido',
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
              
  }
}
?>
