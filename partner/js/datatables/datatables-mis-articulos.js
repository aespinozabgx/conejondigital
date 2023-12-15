window.addEventListener('DOMContentLoaded', event => {
    // Simple-DataTables
    // https://github.com/fiduswriter/Simple-DataTables/wiki

    const datatablesSimple = document.getElementById('tablaArticulosDataTable');
    if (datatablesSimple) {

        new simpleDatatables.DataTable(datatablesSimple, {
             sortable: true,
             paging: true,
             searchable: true,
             language: {
                url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
             }
        });

    }
});
