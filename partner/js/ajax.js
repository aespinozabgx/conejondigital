    // document.querySelector('.sin-borde').addEventListener('mouseup', function() {
    //   this.style.outline = '';
    //   this.style.boxShadow = '';
    // });
    function validateEmail(email)
    {
        var re = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
        return re.test(email);
    }

    function validarActualizaProducto()
    {
        const barcodeInput = document.querySelector("#barcode");
        if (barcodeInput.value === "")
        {
            Swal.fire
            ({
                title: 'Error',
                text: 'Debes escanear/ingresar un código o seleccionar la casilla para que el sistema asigne uno automáticamente.',
                icon: 'warning',
                confirmButtonText: 'Entendido'
            });
            return false;
        }

        const nombreInput = document.querySelector("#inputFirstName");
        if (nombreInput.value === "")
        {
            Swal.fire
            ({
                title: 'Error',
                text: 'Debes ingresar un nombre para tu producto',
                icon: 'warning',
                confirmButtonText: 'Entendido'
            });
            return false;
        }

        if (nombreInput.value.length < 3)
        {
            Swal.fire
            ({
                title: 'Error',
                text: 'El nombre debe tener al menos 3 caracteres.',
                icon: 'warning',
                confirmButtonText: 'Entendido'
            });
            return false;
        }

        // Obtiene el elemento input de tipo file
        const inputFile = document.getElementById('imagenProducto');

        // Obtiene el elemento switch conservar imagenes
        if (document.getElementById('switchConservarImg'))
        {
            const switchConservarImg = document.getElementById('switchConservarImg');
            if (!switchConservarImg.checked)
            {
                // Verifica si se ha seleccionado al menos un archivo de imagen
                if (inputFile.files.length === 0)
                {
                    // Muestra una notificación de error con SweetAlert
                    Swal.fire({
                      icon: 'error',
                      title: 'Error',
                      text: 'Debes seleccionar al menos una imagen para registrar el producto.',
                      confirmButtonText: 'Entendido'
                    });
                    // Evita que el formulario sea enviado
                    return false;
                    event.preventDefault();
                }
            }
        }
        else
        {
            // Verifica si se ha seleccionado al menos un archivo de imagen
            if (inputFile.files.length === 0)
            {
                // Muestra una notificación de error con SweetAlert
                Swal.fire({
                  icon: 'warning',
                  title: 'Error',
                  text: 'Debes seleccionar al menos una imagen para registrar el producto.',
                  confirmButtonText: 'Entendido'
                });
                // Evita que el formulario sea enviado
                return false;
                event.preventDefault();
            }
        }

        //return false;
        var categorias = $('#categorias-existentes');
        if (categorias.children().length <= 0)
        {
            //console.log(categorias.children().length);
            Swal.fire({
              title: 'Error',
              text: 'No hay categorías registradas, debes asignarle una categoría a tu nuevo producto.',
              icon: 'warning',
              confirmButtonText: 'Entendido'
            });
            return false;
        }


        const categoriasEx = document.getElementById('categorias-existentes');
        //console.log(categoriasEx);
        if (categoriasEx.value === "")
        {
            //console.log(categorias.children().length);
            Swal.fire({
              title: 'Error',
              text: 'Debes seleccionar una categoría para tu nuevo producto.',
              icon: 'warning',
              confirmButtonText: 'Entendido'
            });
            return false;
        }

        const costoProducto = document.querySelector("#costoProducto");
        if (costoProducto.value === "")
        {
            Swal.fire
            ({
                title: 'Error',
                text: 'Debes ingresar el costo de tu producto',
                icon: 'warning',
                confirmButtonText: 'Entendido'
            });
            return false;
        }

        const precioVenta = document.querySelector("#precioVenta");
        if (precioVenta.value === "")
        {
            Swal.fire
            ({
                title: 'Error',
                text: 'Debes ingresar el precio de venta de tu producto',
                icon: 'warning',
                confirmButtonText: 'Entendido'
            });
            return false;
        }

        // element.required = true;
        // const precioVenta = document.querySelector("#precioVenta");

        const selectUnidadVenta = document.querySelector("#selectUnidadVenta");

        //console.log(selectUnidadVenta.value);
        
        console.log('unidad: ' + selectUnidadVenta.value);
        if (selectUnidadVenta.value == "Piezas")
        {
            // Piezas
            console.log('Requerir 1- ..');
            const inventarioPiezas = document.getElementById('inventarioPiezas').value;
            const invMinPiezas = document.getElementById('invMinPiezas').value;
            
            console.log('Requerir 333- ..');
            if (inventarioPiezas == "" || invMinPiezas == "")
            {
                
                console.log('vvvv');
                Swal.fire
                ({
                    title: 'Error',
                    text: 'Debes introducir los datos del inventario.',
                    icon: 'warning',
                    confirmButtonText: 'Entendido'
                });
                
                console.log('333');
                return false;
            }
            
            console.log('Requerir 444- ..');

        }
        else if (selectUnidadVenta.value == "Kilogramos")
        {
            // Kilogramos
            console.log('Requerir 2');
            const inventarioKilogramos = document.getElementById('inventarioKilogramos').value;
            const invMinKilogramos = document.getElementById('invMinKilogramos').value;

            if (inventarioKilogramos == "" || invMinKilogramos == "")
            {
                Swal.fire
                ({
                    title: 'Error',
                    text: 'Debes introducir los datos del inventario.',
                    icon: 'warning',
                    confirmButtonText: 'Entendido'
                });
                return false;
            }

        }
        else
        {
            Swal.fire
            ({
                title: 'Error',
                text: 'Debes seleccionar las unidades de venta para tu producto (Piezas/Kilogramos)',
                icon: 'warning',
                confirmButtonText: 'Entendido'
            });
            return false;
        } 
    }



    /* ============= INICIO VALIDA AL CREAR PEDIDO EN POS ======================= */
    function validaFormulario_pagoPos()
    {
        // Obtener todos los elementos de radio con el nombre "idMetodoDePago"
        var radios = document.getElementsByName('idMetodoDePago');

        // Variable para indicar si al menos un radio está seleccionado
        var seleccionado = false;

        // Iterar sobre todos los elementos de radio
        for (var i = 0; i < radios.length; i++)
        {
            // Verificar si el radio actual está seleccionado
            if (radios[i].checked)
            {
                seleccionado = true;
                break;
            }
        }

        // Verificar si al menos un radio está seleccionado
        if (!seleccionado)
        {
            Swal.fire({
                title: 'Error',
                text: 'Debe seleccionar un método de pago.',
                icon: 'warning',
                showCancelButton: false, // oculta el botón "Cancelar"
                confirmButtonText: 'Entendido',
                allowOutsideClick: false, // evita que la alerta se cierre al hacer clic fuera de ella
                allowEscapeKey: false, // evita que la alerta se cierre al presionar la tecla "Escape"
                customClass: {
                    confirmButton: 'btn btn-primary' // agrega clases Bootstrap al botón de "Entendido"
                },
                buttonsStyling: false // deshabilita el estilo predeterminado de SweetAlert para los botones
            }).then((result) => {
                if (result.isConfirmed) {
                    // se presionó el botón "Entendido", la alerta se cerrará
                }
            });
            return false;
        }

        // Obtener todos los elementos de radio con el nombre "idMetodoDePago"
        var idCliente = document.getElementById('idCliente');
        var asignarCliente = document.getElementById('inputAsignarCliente');

        // console.log('asignar Cliente: '+asignarCliente.checked);
        // console.log('id Cliente: '+ idCliente.disabled);

        var isDisabled = idCliente.getAttribute('disabled');
        // console.log(isDisabled);

        // Verificar las condiciones y mostrar alerta
        if (!(idCliente.disabled && asignarCliente.checked) && !(idCliente.value && !idCliente.disabled && !asignarCliente.checked))
        {
            Swal.fire({
                title: 'Error',
                text: 'Completa los campos necesarios.',
                icon: 'warning',
                showCancelButton: false, // oculta el botón "Cancelar"
                confirmButtonText: 'Entendido',
                allowOutsideClick: false, // evita que la alerta se cierre al hacer clic fuera de ella
                allowEscapeKey: false, // evita que la alerta se cierre al presionar la tecla "Escape"
                customClass: {
                    confirmButton: 'btn btn-primary' // agrega clases Bootstrap al botón de "Entendido"
                },
                buttonsStyling: false // deshabilita el estilo predeterminado de SweetAlert para los botones
            })
            return false;
        }
        else
        {
            if (!validateEmail(idCliente.value) && !asignarCliente.checked)
            {
                Swal.fire({
                    title: 'Error',
                    text: 'Introduce un email válido.',
                    icon: 'warning',
                    showCancelButton: false, // oculta el botón "Cancelar"
                    confirmButtonText: 'Entendido',
                    allowOutsideClick: false, // evita que la alerta se cierre al hacer clic fuera de ella
                    allowEscapeKey: false, // evita que la alerta se cierre al presionar la tecla "Escape"
                    customClass: {
                        confirmButton: 'btn btn-primary' // agrega clases Bootstrap al botón de "Entendido"
                    },
                    buttonsStyling: false // deshabilita el estilo predeterminado de SweetAlert para los botones
                })
                return false;
            }
        }
        $('#modalFinalizarPedidoPDV').modal('hide');        
        $('#modalCreandoPedido').modal('show');
    }
    /* ============= FIN VALIDA AL CREAR PEDIDO EN POS ======================= */

    /* ============= VALIDA AL CREAR NUEVO PRODUCTO ======================= */
    function validarFormulario()
    {

        const barcodeInput = document.querySelector("#barcode");
        const generarBarcodeInput = document.querySelector("#generarBarcode");

        if ((barcodeInput.value === "" && generarBarcodeInput.checked === true) || barcodeInput.value !== "" && generarBarcodeInput.checked === false)
        {
            //console.log('error');
        }
        else
        {
            Swal.fire
            ({
                title: 'Error',
                text: 'Debes escanear/ingresar un código o seleccionar la casilla para que el sistema asigne uno automáticamente.',
                icon: 'warning',
                confirmButtonText: 'Entendido'
            });
            return false;
        }

        // console.log(barcodeInput.value.length);
        // alert(barcodeInput.length);

        if (barcodeInput.value !== "" && generarBarcodeInput.checked === false)
        {
            const longitudBarcode = 6;
            const longitudMaxBarcode = 28;
            const barcodePattern = new RegExp(`^[0-9]{${longitudBarcode},${longitudMaxBarcode}}$`);
            if (!barcodePattern.test(barcodeInput.value) || barcodeInput.value.length < longitudBarcode)
            {
                Swal.fire({
                    title: 'Error',
                    text: 'El código de barras debe tener al menos '+longitudBarcode+' y máximo '+longitudMaxBarcode+' dígitos y deberán ser sólo números.',
                    icon: 'warning',
                    confirmButtonText: 'Entendido'
                });
                return false;
            }
        }

        const nombreInput = document.querySelector("#inputFirstName");
        if (nombreInput.value === "")
        {
            Swal.fire
            ({
                title: 'Error',
                text: 'Debes ingresar un nombre para tu producto',
                icon: 'warning',
                confirmButtonText: 'Entendido'
            });
            return false;
        }

        if (nombreInput.value.length < 3)
        {
            Swal.fire
            ({
                title: 'Error',
                text: 'El nombre debe tener al menos 3 caracteres.',
                icon: 'warning',
                confirmButtonText: 'Entendido'
            });
            return false;
        }

        // Obtiene el elemento input de tipo file
        const inputFile = document.getElementById('imagenProducto');

        // Obtiene el elemento switch conservar imagenes
        if (document.getElementById('switchConservarImg'))
        {
            const switchConservarImg = document.getElementById('switchConservarImg');
            if (!switchConservarImg.checked)
            {
                // Verifica si se ha seleccionado al menos un archivo de imagen
                if (inputFile.files.length === 0)
                {
                    // Muestra una notificación de error con SweetAlert
                    Swal.fire({
                      icon: 'error',
                      title: 'Error',
                      text: 'Debes seleccionar al menos una imagen para registrar el producto.',
                      confirmButtonText: 'Entendido'
                    });
                    // Evita que el formulario sea enviado
                    return false;
                    event.preventDefault();
                }
            }
        }
        else
        {
            // Verifica si se ha seleccionado al menos un archivo de imagen
            // if (inputFile.files.length === 0)
            // {
            //     // Muestra una notificación de error con SweetAlert
            //     Swal.fire({
            //       icon: 'warning',
            //       title: 'Error',
            //       text: 'Debes seleccionar al menos una imagen para registrar el producto.',
            //       confirmButtonText: 'Entendido'
            //     });
            //     // Evita que el formulario sea enviado
            //     return false;
            //     event.preventDefault();
            // }
        }

        //return false;
        var categorias = $('#categorias-existentes');
        if (categorias.children().length <= 0)
        {
            //console.log(categorias.children().length);
            Swal.fire({
              title: 'Error',
              text: 'No hay categorías registradas, debes asignarle una categoría a tu nuevo producto.',
              icon: 'warning',
              confirmButtonText: 'Entendido'
            });
            return false;
        }

        const categoriasEx = document.getElementById('categorias-existentes');
        //console.log(categoriasEx);
        if (categoriasEx.value === "")
        {
            //console.log(categorias.children().length);
            Swal.fire({
              title: 'Error',
              text: 'Debes seleccionar una categoría para tu nuevo producto.',
              icon: 'warning',
              confirmButtonText: 'Entendido'
            });
            return false;
        }

        const costoProducto = document.querySelector("#costoProducto");
        if (costoProducto.value === "")
        {
            Swal.fire
            ({
                title: 'Error',
                text: 'Debes ingresar el costo de tu producto',
                icon: 'warning',
                confirmButtonText: 'Entendido'
            });
            return false;
        }

        const precioVenta = document.querySelector("#precioVenta");
        if (precioVenta.value === "")
        {
            Swal.fire
            ({
                title: 'Error',
                text: 'Debes ingresar el precio de venta de tu producto',
                icon: 'warning',
                confirmButtonText: 'Entendido'
            });
            return false;
        }

        // element.required = true;
        // const precioVenta = document.querySelector("#precioVenta");

        const selectUnidadVenta = document.querySelector("#selectUnidadVenta");

        //console.log(selectUnidadVenta.value);

        if (selectUnidadVenta.value == "Piezas")
        {
            // Piezas
            console.log('Requerir 1111');
            const inventarioPiezas = document.getElementById('inventarioPiezas').value;
            const invMinPiezas = document.getElementById('invMinPiezas').value;

            if (inventarioPiezas == "" || invMinPiezas == "")
            {
                Swal.fire
                ({
                    title: 'Error',
                    text: 'Debes introducir los datos del inventario.',
                    icon: 'warning',
                    confirmButtonText: 'Entendido'
                });
                return false;
            }

        }
        else if (selectUnidadVenta.value == "Kilogramos")
        {
            // Kilogramos
            console.log('Requerir 2');
            const inventarioKilogramos = document.getElementById('inventarioKilogramos').value;
            const invMinKilogramos = document.getElementById('invMinKilogramos').value;

            if (inventarioKilogramos == "" || invMinKilogramos == "")
            {
                Swal.fire
                ({
                    title: 'Error',
                    text: 'Debes introducir los datos del inventario.',
                    icon: 'warning',
                    confirmButtonText: 'Entendido'
                });
                return false;
            }

        }
        else
        {
            Swal.fire
            ({
                title: 'Error',
                text: 'Debes seleccionar las unidades de venta para tu producto (Piezas/Kilogramos)',
                icon: 'warning',
                confirmButtonText: 'Entendido'
            });
            return false;
        }

    }

    function cargarCategorias()
    {
        // Hacer una petición AJAX para recuperar las categorías de la base de datos
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'php/ajax/obtener-categorias.php');
        xhr.onload = function()
        {
          if (xhr.status === 200)
          {
            // Si la petición tiene éxito, procesar la lista de categorías
            var categorias = JSON.parse(xhr.responseText);
            //var select = document.getElementById('categorias-existentes');
            //console.log(categorias);

            var salidaCategorias = document.getElementById('salidaCategorias');
            var elemento = document.getElementById('categorias-existentes');
            //var submitCategoria = document.getElementById('submitCategoria');
            //console.log(categorias);
            if (categorias.length > 0)
            {
                //Crear elemento select
                document.getElementById('labelCatExistentes').innerHTML = "Categoría:";
                salidaCategorias.innerHTML = '';
                elemento.style.display = "block";
                //elemento.required = true;
                //submitCategoria.style.display = "block";
                elemento.innerHTML = '';

                // Agregar un elemento "option" con texto "Seleccionar" al principio del listado
                var option = document.createElement('option');
                option.text = 'Seleccionar';
                option.value = '';
                option.selected = true;
                elemento.add(option);

                // Si hay categorías disponibles, agregarlas al select
                categorias.forEach(function(categoria)
                {
                    var option   = document.createElement('option');
                    option.value = categoria.idCategoria;
                    option.text  = categoria.nombre;
                    elemento.add(option);
                });

                setTimeout(() =>
                {
                    // console.log(idCategoriaDB);
                    if (typeof idCategoriaDB !== "undefined")
                    {
                        elemento.value = idCategoriaDB;
                        console.log(idCategoriaDB);
                    }
                    // else
                    // {
                    //     console.log('no');
                    // }
                }, 100);

            }
            else
            {
                // Si no hay categorías, mostrar una alerta
                // alert('No hay categorías disponibles');
                salidaCategorias.innerHTML = 'Categoría:<br> <span class="small">No hay categorías registradas</span>';
            }
          }
        };
        xhr.send();
    }

    function registrarCategoria(e)
    {
        // Evitar que el formulario se envíe de manera tradicional
        e.preventDefault();

        // Obtener el nombre de la categoría del formulario
        var categoria = document.getElementById('categoria').value;

        // Validar la entrada del usuario
        if (categoria === '')
        {
            // Mostrar un mensaje de error si el campo está vacío
            alert('Por favor ingrese una categoría');
            return;
        }

        // Hacer una petición AJAX para registrar la nueva categoría
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'php/ajax/registra-categoria.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function()
        {
            if (xhr.status === 200)
            {
                // Si la petición tiene éxito, mostrar response con swal
                console.log('sl');
                categoria.innerHTML = '';
                cargarCategorias();
                mostrarNotificacionCategoria(xhr.responseText);
            }
        };
        xhr.send('categoria=' + categoria);
        // cargarCategorias();
    }

    // Función para mostrar una notificación con SweetAlert
    function mostrarNotificacionCategoria(mensaje)
    {
      // Definir las opciones de la notificación
      var opciones = {
        title: '',
        text: mensaje,
        confirmButtonText: 'Entendido'
      };

      // Cambiar el icono de la notificación dependiendo del mensaje
      if (mensaje === 'Ya existe una categoría con ese nombre') {
        opciones.icon = 'error';
      } else if (mensaje === 'Categoría registrada con éxito') {
        opciones.icon = 'success';
      } else if (mensaje === 'Error al registrar la categoría') {
        opciones.icon = 'error';
      }

      // Mostrar la notificación
      Swal.fire(opciones);
    } 

    // Check if the form with id "formulario-categorias" exists
    var form = document.getElementById('formulario-categorias');

    if (form) 
    {
        // Assign the function registrarCategoria to the submit event of the form
        form.addEventListener('submit', registrarCategoria);
    } 
    // else 
    // {
    //     console.error("Form with id 'formulario-categorias' not found.");
    // }


    // Check if the element with id "categoria" exists
    var categoriaInput = document.querySelector('#categoria');

    if (categoriaInput) 
    {
        // Assign the event listener only if the element exists
        categoriaInput.addEventListener('keyup', function() {
            this.value = this.value.toLowerCase();
        });

        // Verificar si el carácter ingresado es una letra, un número o un espacio
        if (!/[a-zA-Z0-9 ]/.test(event.key)) {
            // Evitar que el carácter sea añadido al valor del input
            event.preventDefault();
        }

        // Verificar si el input tiene más de 33 caracteres
        if (this.value.length >= 33) {
            // Evitar que se añadan más caracteres al input
            event.preventDefault();
        }
    }

    // Check if the element with id "requiereEnvio" exists
    const checkbox = document.getElementById('requiereEnvio');
    const text = document.getElementById('requiereEnvioText');

    if (checkbox) {
        // Assign the event listener only if the element exists
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                text.innerHTML = '&nbsp;&nbsp;Sí, se trata de un producto digital.';
            } else {
                text.innerHTML = '&nbsp;&nbsp;No, no es un producto digital.';
            }
        });
    } 
    // else {
    //     console.error("Element with id 'requiereEnvio' not found.");
    // }


    // Venta en línea
    const checkboxOnlineStore = document.getElementById('isActiveOnlineStore');
    const onlineStoreText = document.getElementById('isActiveOnlineStoreLabel');

    if (checkboxOnlineStore) {
        // Assign the event listener only if the element exists
        checkboxOnlineStore.addEventListener('change', function() {
            if (this.checked) {
                onlineStoreText.innerHTML = '&nbsp;&nbsp; Sí.';
            } else {
                onlineStoreText.innerHTML = '&nbsp;&nbsp; No.';
            }
        });
    } 
    // else {
    //     console.error("Element with id 'isActiveOnlineStore' not found.");
    // }


    const labelImagenes = document.getElementById('imagenesLabel');
    const lblImgProducto = document.getElementById('imagenProductoLabel');

    if (document.getElementById('switchConservarImg'))
    {
        switchConservarImg.addEventListener('change', function()
        {
            if (this.checked)
            {
                labelImagenes.style.display = "none";
                lblImgProducto.style.display = "none";
            }
            else
            {
                labelImagenes.style.display = "block";
                lblImgProducto.style.display = "block";
            }
        });
    }
