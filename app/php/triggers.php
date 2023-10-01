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
          case 'errorCuentaInactiva':
              echo "<script>             
                      var myModal = new bootstrap.Modal(document.getElementById('modalReenvioActivacionCuenta'))
                      myModal.show();                      
                    </script>";
          break;

          case 'cuentaExistente':
              echo "<script>             
                      var myModal = new bootstrap.Modal(document.getElementById('modalCuentaExistente'))
                      myModal.show();                      
                    </script>";
          break;
      }
  }
?>
