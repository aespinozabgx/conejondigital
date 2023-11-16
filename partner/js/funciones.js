    function validarDecimal(event)
    {
        const input = event.target;
        const valor = input.value;

        // Validar que solo se permita un decimal
        const regex = /^\d*(\.\d{0,1})?$/;
        if (!regex.test(valor))
        {
            input.value = valor.slice(0, -1);
        }
    }

    function validarCierreCaja(totalCaja)
    {
        // console.log("AXEL");
        // Obtener el valor del campo de entrada
        const montoIngresoCaja = document.getElementById("montoIngresoEfectivoCaja").value;

        // Validar que el campo no esté vacío
        if (montoIngresoCaja.trim() === "") {
          Swal.fire({
            icon: "error",
            title: "Campo obligatorio",
            text: "El campo 'Efectivo en caja' es obligatorio.",
          });
          return false;
        }

        // Validar que el valor sea numérico y mayor o igual que cero
        if (isNaN(montoIngresoCaja) || Number(montoIngresoCaja) < 0) {
          Swal.fire({
            icon: "error",
            title: "Valor no válido",
            text: "El valor ingresado en 'Efectivo en caja' no es válido.",
          });
          return false;
        }

        // Definimos las variables totalCajaEsperado y montoEfectivoEnCaja
        let totalCajaEsperado = Number(totalCaja);
        let montoEfectivoEnCaja = Number(montoIngresoCaja);


        // Almacenar elementos en variables
        const salidaCuadreCaja = document.getElementById("salidaCuadreCaja");
        const checkDescuadreCaja = document.getElementById("checkDescuadreCaja");
        const hideDescuadreCaja = document.getElementById("hideDescuadreCaja");
        const labelCuadreCaja = document.getElementById("labelCuadreCaja");
        const diferenciaCaja = document.getElementById("diferenciaCaja");
        const efectivoFinalCaja = document.getElementById("efectivoFinalCaja");

        // Calcular la diferencia entre el efectivo en caja y el total esperado
        diferencia = Number(totalCajaEsperado) - Number(montoEfectivoEnCaja);

        // Verificamos si los montos son negativos
        if (totalCajaEsperado == montoEfectivoEnCaja)
        {
            console.log("Iguales");
            // Cuadre de caja perfecto
            salidaCuadreCaja.innerHTML = "¡Excelente! El efectivo en caja coincide con lo calculado por <b class='fs-1 logo text-yellow'>ConejónDigital</b>";
            checkDescuadreCaja.required = false;
            hideDescuadreCaja.style.display = "none";
            diferenciaCaja.value = 0;
            efectivoFinalCaja.value = montoIngresoCaja;
        }
        else if (montoEfectivoEnCaja < totalCajaEsperado)
        {
            // Verificamos si hay un excedente de efectivo en caja
            console.log("Faltante");

            // Faltante
            salidaCuadreCaja.innerHTML = 'Hay un <b class="text-danger">faltante</b> en caja de $' + Math.abs(diferencia).toFixed(2);
            checkDescuadreCaja.required = true;
            hideDescuadreCaja.style.display = "block";
            labelCuadreCaja.innerHTML = ' Registrar faltante como <span class="border-bottom border-2">ajuste de caja</span>';
            diferenciaCaja.value = diferencia.toFixed(2);
            efectivoFinalCaja.value = montoIngresoCaja;

        }
        else
        {
            // console.log("Excedente");
            // Excedente
            checkDescuadreCaja.required = true;
            salidaCuadreCaja.innerHTML = 'Hay un <b class="text-danger">excedente</b> en caja de $' + Math.abs(diferencia).toFixed(2);
            hideDescuadreCaja.style.display = "block";
            labelCuadreCaja.innerHTML = ' Registrar excedente como <span class="border-bottom border-2">ajuste de caja</span>';
            diferenciaCaja.value = diferencia.toFixed(2);
            efectivoFinalCaja.value = montoIngresoCaja;
        }

        // diferencia += Number(montoIngresoCaja);

        // console.log('totalCaja: ' + totalCaja);
        // console.log('montoIngresoCaja: ' + montoIngresoCaja);
        // console.log('diferencia: ' + diferencia);


        $('#modalCierreTurnoCaja').modal('hide');
        $('#modalFes').modal('show');

        if (diferencia == 0) {
            // // Cuadre de caja perfecto
            // salidaCuadreCaja.innerHTML = "¡El efectivo en caja coincide con lo esperado! <br> $" + totalCajaEsperado.toFixed(2);
            // checkDescuadreCaja.required = false;
            // hideDescuadreCaja.style.display = "none";
            // diferenciaCaja.value = diferencia.toFixed(2);
            // efectivoFinalCaja.value = montoIngresoCaja;
        } else if (diferencia > 0) {
            // // Excedente
            // salidaCuadreCaja.innerHTML = 'Hay un <b class="text-danger">excedente</b> en caja de $' + diferencia.toFixed(2);
            // checkDescuadreCaja.required = true;
            // hideDescuadreCaja.style.display = "block";
            // labelCuadreCaja.innerHTML = ' Registrar excedente como <span class="border-bottom border-2">ajuste de caja</span>';
            // diferenciaCaja.value = diferencia.toFixed(2);
            // efectivoFinalCaja.value = montoIngresoCaja;
        } else if (diferencia < 0) {
            // // Faltante
            // salidaCuadreCaja.innerHTML = 'Hay un <b class="text-danger">faltante</b> en caja de $' + Math.abs(diferencia).toFixed(2);
            // checkDescuadreCaja.required = true;
            // hideDescuadreCaja.style.display = "block";
            // labelCuadreCaja.innerHTML = ' Registrar faltante como <span class="border-bottom border-2">ajuste de caja</span>';
            // diferenciaCaja.value = diferencia.toFixed(2);
            // efectivoFinalCaja.value = montoIngresoCaja;
        }
        // Si se pasaron todas las validaciones, devolver verdadero
        return true;
    }


    function copiarPortapapeles(inputId)
    {
        // Get the text field
        var copyText = document.getElementById(inputId);

        copyText.setSelectionRange(0, 99999);
        copyText.focus(); // se enfoca en el input para seleccionar el texto
        document.execCommand('copy');

        // Alert the copied text
        //alert("Link copiado al portapapeles" + copyText.value);
        const Toast = Swal.mixin({
          toast: true,
          position: 'top',
          showConfirmButton: false,
          timer: 2000,
          timerProgressBar: true,
          customClass: {
          },
          didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
          }
        })

        Toast.fire({
          icon: 'success',
          html: 'Copiado al portapapeles: ' + copyText.value,
        }).then((result) => {
          if (result.isConfirmed) {
            console.log('Alerta cerrada');
          }
        })
    }

    function etiquetaCargaDocumento(dato)
    {
        var remInput = document.getElementById(dato);
        var rem = document.getElementById('labelProductoJs');

        if (remInput.value == "")
        {
            rem.innerHTML = "<i class='fas fa-folder-open'></i> Seleccionar...";
            rem.classList.remove("btn-success");
        }
        else
        {
            rem.innerHTML = "Imagen(es) seleccionada(s) ✓";
            rem.classList.remove("text-blue");
            rem.classList.add("text-white");
            rem.classList.remove("btn-white");
            rem.classList.add("btn-success");
            rem.style.border = "";
        }
    }


    function toggleImagenes()
    {
      if (document.getElementById('customSwitch1').checked)
      {
          document.getElementById('imagenProducto').required = false;
          document.getElementById('imagenProductoJS').style.display = 'none';
      }
      else
      {
          document.getElementById('imagenProducto').required = true;
          document.getElementById('imagenProductoJS').style.display = 'block';
      }

    }

    function branchToDelete(id)
    {
        document.getElementById('idSucursalToDelete').value = id;
    }


    function mostrarDireccion(data)
    {
        Swal.fire({
          title: 'Dirección',
          text: data,
          icon: 'info',
          confirmButtonText: 'Aceptar',
          allowOutsideClick: false // Evita cerrar el modal al dar clic en cualquier lugar
        });
    }

    function editarDireccion(sucursal)
    {
        // convierte el objeto a un objeto JavaScript
        var sucursalObject = JSON.parse(sucursal);

        // obtiene los valores correspondientes del objeto
        var nombreSucursal = sucursalObject.nombreSucursal;
        var codigoPostal = sucursalObject.codigoPostal;
        var estado = sucursalObject.estado;
        var municipioAlcaldia = sucursalObject.municipioAlcaldia;
        var calle = sucursalObject.calle;
        var colonia = sucursalObject.colonia;
        var numeroExterior = sucursalObject.numeroExterior;
        var interiorDepto = sucursalObject.interiorDepto;
        var telefono = sucursalObject.telefono;
        var entreCalle1 = sucursalObject.entreCalle1;
        var entreCalle2 = sucursalObject.entreCalle2;
        var indicacionesAdicionales = sucursalObject.indicacionesAdicionales;
        var isPrincipal = sucursalObject.isPrincipal;
        var idSucursal = sucursalObject.idSucursal;

        // Resetear todos los campos del formulario para después insertar los nuevos
        document.getElementById("formActualizarSucursal").reset();

        // asigna los valores correspondientes a cada campo
        document.getElementById('edit_nombre_sucursal').value   = nombreSucursal;
        document.getElementById('edit_cp_sucursal').value       = codigoPostal;
        document.getElementById('edit_estado_sucursal').value   = estado;
        document.getElementById('edit_mun_alc_sucursal').value  = municipioAlcaldia;
        document.getElementById('edit_calle_sucursal').value    = calle;
        document.getElementById('edit_colonia_sucursal').value  = colonia;
        document.getElementById('edit_exterior_sucursal').value = numeroExterior;
        document.getElementById('edit_interior_sucursal').value = interiorDepto;
        document.getElementById('edit_telefono_sucursal').value = telefono;
        document.getElementById('edit_entre_calles_sucursal').value  = entreCalle1;
        document.getElementById('edit_entre_calles2_sucursal').value = entreCalle2;
        document.getElementById('edit_indicaciones_sucursal').value  = indicacionesAdicionales;
        document.getElementById('idSucursalActualizarDatos').value   = idSucursal;

        if (isPrincipal == 1)
        {
            document.getElementById('edit_is_principal_sucursal').checked = true;
            console.log("Entrar: " + isPrincipal);
        }
        // Abrir modal
        $('#modalEditarSucursal').modal('show');
    }

    function validarTelefono()
    {

        // Obtener el valor del campo de entrada de teléfono
        var telefono = document.getElementById("telefono_sucursal").value;

        // Verificar si el campo de entrada está vacío

        // Validar CP
        const telefonoRegex = /^[0-9]{10}$/;
        if (!telefonoRegex.test(telefono))
        {
            // Mostrar un mensaje de error
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Ingresa un número de teléfono válido a 10 dígitos',
            })
            return false;
        }

        // Si el campo no está vacío, enviar el formulario
        document.querySelector('#formNuevaSucursal').submit();
    }

    function validarCamposRegistroSucursal()
    {
        let nombre   = document.getElementById('nombre_sucursal').value;
        let cp       = document.getElementById('cp_sucursal').value;
        let estado   = document.getElementById('estado_sucursal').value;
        let calle    = document.getElementById('calle_sucursal').value;
        let colonia  = document.getElementById('colonia_sucursal').value;
        let exterior = document.getElementById('exterior_sucursal').value;
        let interior = document.getElementById('interior_sucursal').value;

        if (nombre === '' || cp === '' || (estado === '' && estado !== 'Selecciona un estado...') || calle === '' || colonia === '' || exterior === '')
        {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Completa todos los campos obligatorios (*) para actualizar la sucursal.',
              allowOutsideClick: false,
            })

            $('#modalNuevaSucursal').modal('show');
            return false;
        }

        // Validar CP
        const codigoPostalRegex = /^[0-9]{5}$/;
        if (!codigoPostalRegex.test(cp))
        {
            Swal.fire({
                icon:  'error',
                title: 'Oops...',
                text:  'El CP debe tener 5 caracteres y deben ser sólo números',
            })
            return false;
        }

        $('#modalNuevaSucursal').modal('hide');
        $('#modalNuevaSucursal2').modal('show');
    }
