
function LoadTableUsers() {
    if ($.fn.DataTable.isDataTable('#table_users')){
        
        $('#table_users').DataTable().rows().remove();
        $('#table_users').DataTable().destroy();
    
    }
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
        
        responsive: true,
        autoWidth: false,
        // processing: true,
        lengthMenu:[5,10,25,50],
        pageLength:10,
        clickToSelect:false,
        ajax: $('#base_url').val()+"/main/getUsers",
        aoColumns: [
            { "data": "id_us" },
            { "data": "nombres_us"},
            {  "data": "apepat_us",
                "bSortable": false,
                "mRender": function(data, type, value) {

                return  value["apepat_us"]+" "+value["apemat_us"];
                
                

                }
            },
            
            { "data": "usuario_us" },
            {  "data": "creacion_us",
                "bSortable": false,
                "mRender": function(data, type, value) {

                    return  data.split(" ")[0].split("-").reverse().join("-");
                    
                    

                }
            },
            {  "data": "estado_us",
                        "bSortable": false,
                        "mRender": function(data, type, value) {
                            if (data == '1') return  'Activo';
                            else return 'Inactivo'
                              
    
                        }
                    },
            { "data": "id_us" },
          
            { "defaultContent": "<a href='<?=base_url('modifyUser/')?>' class='mr-3 text-primary' data-toggle='tooltip' data-placement='top' title='' data-original-title='Editar'><i class='fas fa-edit font-size-18'></i></a>"+
            "<estadoUser class='text-danger btn btn-opcionTabla' data-toggle='tooltip' data-placement='top' title='' data-original-title='Cambiar Estado'><i class='mdi mdi-trash-can font-size-18'></i></estadoUser>"+
            "<a href='<?=base_url('deleteUser/') ?>' class='text-danger' data-toggle='tooltip' data-placement='top' title='' data-original-title='Eliminar'><i class='far fa-trash-alt font-size-18'></i></a>"
                                 
            },
        ],
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
}

window.addEventListener("load", () => {
    LoadTableUsers();

});