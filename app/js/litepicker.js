// Litepicker
//
// The date pickers in Material Admin Pro
// are powered by the Litepicker plugin.
// Litepicker is a lightweight, no dependencies
// date picker that allows for date ranges
// and other options. For more usage details
// visit the Litepicker docs.
//
// Litepicker Documentation
// https://wakirin.github.io/Litepicker

// Set new default font family and font color to mimic Bootstrap's default styling


window.addEventListener('DOMContentLoaded', event => {

    const litepickerSingleDate = document.getElementById('litepickerSingleDate');
    if (litepickerSingleDate) {
        new Litepicker({
            element: litepickerSingleDate,
            language: 'es-ES',
            lang: "es-ES",
            startDate: new Date(),
            format: 'MMM DD, YYYY'
        });
    }

    const litepickerDateRange = document.getElementById('litepickerDateRange');
    if (litepickerDateRange) {
        new Litepicker({
            element: litepickerDateRange,
            singleMode: false,
            format: 'MMM DD, YYYY'
        });
    }

    const litepickerDateRange2Months = document.getElementById('litepickerDateRange2Months');
    if (litepickerDateRange2Months) {
        new Litepicker({
            element: litepickerDateRange2Months,
            singleMode: false,
            numberOfMonths: 2,
            numberOfColumns: 2,
            format: 'MMM DD, YYYY'
        });
    }

    const litepickerRangePlugin = document.getElementById('litepickerRangePlugin');
    const currentDate = new Date();
    const startDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
    
    // const fInicio = document.getElementById('finiciophp').value;
    // const fFin = document.getElementById('ffinphp').value;
    // alert(fInicio + fFin);
    if (litepickerRangePlugin)
    {
        const currentYear = new Date().getFullYear();
        new Litepicker({
            element: litepickerRangePlugin,
            language: 'es-ES',
            lang: "es-ES",
            startDate: startDate,
            endDate: new Date(),
            singleMode: false,
            numberOfMonths: 2,
            numberOfColumns: 2,
            format: 'DD MMM, YYYY',
            maxDate: new Date(),
            plugins: ['ranges'],
            ranges:
            {
                customRanges:
                {
                    'Hoy': [new Date(), new Date()],
                    'Ayer': [new Date(new Date().setDate(new Date().getDate() - 1)), new Date(new Date().setDate(new Date().getDate() - 1))],
                    'Ultimos 7 días': [new Date(new Date().setDate(new Date().getDate() - 6)), new Date()],
                    'Mes actual': [new Date(new Date().getFullYear(), new Date().getMonth(), 1), new Date()],
                    'Mes anterior': [new Date(new Date().getFullYear(), new Date().getMonth() - 1, 1), new Date(new Date().getFullYear(), new Date().getMonth(), 0)]
                }
            },
            callback: function(start, end)
            {
                console.log('La fecha de inicio seleccionada es:', start);
                console.log('La fecha de fin seleccionada es:', end);
                // Aquí puedes ejecutar la acción deseada con las fechas seleccionadas
            }
        });
    }

});
