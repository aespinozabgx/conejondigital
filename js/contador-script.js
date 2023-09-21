function calculateTimeUntilBirthday() {
  const second = 1000,
        minute = second * 60,
        hour = minute * 60,
        day = hour * 24;

  // Establece la fecha y hora de tu cumpleaños en la zona horaria de México  
  const birthday = new Date("2023-12-09T00:00:00-06:00");


  function updateCountdown() {
    const now = new Date().toLocaleString("en-US", { timeZone: "America/Mexico_City" });
    const nowDate = new Date(now).getTime();
    const distance = birthday.getTime() - nowDate;
    
    console.log(birthday);
    console.log(now);

    const days = Math.floor(distance / day);
    const hours = Math.floor((distance % day) / hour);
    const minutes = Math.floor((distance % hour) / minute);
    const seconds = Math.floor((distance % minute) / second);

    return { days, hours, minutes, seconds };
  }

  function displayCountdown() {
    const { days, hours, minutes, seconds } = updateCountdown();

    document.getElementById("days").innerText = days;
    document.getElementById("hours").innerText = hours;
    document.getElementById("minutes").innerText = minutes;
    document.getElementById("seconds").innerText = seconds;

    if (days === 0 && hours === 0 && minutes === 0 && seconds === 0) {
      document.getElementById("headline").innerText = "¡Hoy es mi cumpleaños!";
      document.getElementById("countdown").style.display = "none";
      document.getElementById("content").style.display = "block";
      clearInterval(interval);
    }
  }

  displayCountdown();
  const interval = setInterval(displayCountdown, 1000);
}

calculateTimeUntilBirthday();
