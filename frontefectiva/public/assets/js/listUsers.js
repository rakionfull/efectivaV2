var table = $('#table_users').DataTable({
    language: {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
        }
    },
    // scrollY: "200px",
    // fixedColumns:   {
    //     heightMatch: 'none'
    // },
    responsive: true,
    autoWidth: false,
    // processing: true,
    lengthMenu:[5,10,25,50],
    pageLength:5,
    clickToSelect:false,
    //ajax: base_url+"/main/getFormularios/"+id_camp,
    // aoColumns: [
    //     { "data": "id_form" },
    //     { "data": "numero"},
    //     { "data": "desc-form" },

    //     {  "data": "est_form",
    //                 "bSortable": false,
    //                 "mRender": function(data, type, value) {
    //                     if (data == '1') {
    //                         return  '<input  type="checkbox" id="form_'+value["id_camp"]+'" onclick="changeCampania(this, event)" switch="none" checked/><label for="camp_'+value["id_camp"]+'" data-on-label="On"data-off-label="Off"></label>'
                          
    //                     }else{
    //                         return  '<input type="checkbox" id="form_'+value["id_camp"]+'" onclick="changeCampania(this, event)" switch="none" /><label for="camp_'+value["id_camp"]+'" data-on-label="On"data-off-label="Off"></label>'
                          
    //                     }
    //                 }
    //             },
    //     { "data": "id_user" },
    //     { "data": "fecha_reg" },
    //     { "defaultContent": "<editForm class='mr-3 text-primary btn btn-opcionTabla' data-toggle='tooltip' data-placement='top' title='' data-original-title='Editar'><i class='mdi mdi-pencil font-size-18'></i></editForm>"+
    //                         "<deleteForm class='text-danger btn btn-opcionTabla' data-toggle='tooltip' data-placement='top' title='' data-original-title='Eliminar'><i class='mdi mdi-trash-can font-size-18'></i></deleteForm>" 
    //     },
    // ],
    columnDefs: [
        {
            "targets": [ 0 ],
            "visible": false,
            "searchable": false
        },
        
    ],
    'drawCallback': function () {
        $( 'table_users tbody tr td' ).css( 'padding', '1px 1px 1px 1px' );
    }
    
});