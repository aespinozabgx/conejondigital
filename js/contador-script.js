function calcularTiempoRestante(targetDate) 
{
  const second = 1000,
        minute = second * 60,
        hour   = minute * 60,
        day    = hour   * 24;

  const target = new Date(targetDate);

  function actualizaContador() 
  {
    const now = new Date().toLocaleString("en-US", { timeZone: "America/Mexico_City" });
    const nowDate = new Date(now).getTime();
    const distance = target.getTime() - nowDate;

    const days = Math.floor(distance / day);
    const hours = Math.floor((distance % day) / hour);
    const minutes = Math.floor((distance % hour) / minute);
    const seconds = Math.floor((distance % minute) / second);

    // Seleccionar todos los elementos con los mismos IDs y actualizarlos
    const elements = document.querySelectorAll('#days, #hours, #minutes, #seconds');
    elements.forEach(element => 
      {
      switch (element.id) 
      {
        case 'days':
          element.innerText = days;
          break;
        case 'hours':
          element.innerText = hours;
          break;
        case 'minutes':
          element.innerText = minutes;
          break;
        case 'seconds':
          element.innerText = seconds;
          break;
        default:
          break;
      }
    });
  }

  actualizaContador(); // Llamar a la función inicialmente

  // Configurar un intervalo para actualizar el contador cada segundo
  const interval = setInterval(actualizaContador, 1000);
}

// Inicializar el contador con la fecha de cumpleaños deseada
calcularTiempoRestante("2023-12-09T00:00:00-06:00");
