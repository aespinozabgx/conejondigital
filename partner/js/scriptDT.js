$(function (){
  $('#tablaArticulos').dataTable({
      lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
      iDisplayLength: 10,
      ordering: true,
      paging: true,
      fixedHeader: {
        header: true
      },
      columnDefs: [
          { orderable: true, targets: "_all" }
      ],
      dom: 'Bfrtip',
      buttons: [
        {
          // extend: 'excel',
              // exportOptions: {
                  // columns: [ 0, 1, 2 ]
              // },
          // text: '<button class="btn btn-success btn-sm">Excel <i class="fas fa-cloud-download-alt ms-1"></i></button>'
        },
      ],
      language: {
          url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
      }
  });
});
