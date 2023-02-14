var alerta_macroproceso = document.getElementById("alert_macroproceso");
function LoadTableMacroproceso() {

//cargando las empresas

$.ajax({
    method: "POST",
    url: BASE_URL+"/activo/getEmpresasByActivo",
    dataType: "JSON"
})
.done(function(respuesta) {
   
    if (respuesta) 
    {
        let datos = respuesta;
      

        $("#select_empresaMacro").empty();
        $("#select_empresaMacro").append('<option value="" selected>Seleccione</option>');

    

        datos.data.forEach(dato => {
            
        
                $("#select_empresaMacro").append('<option value='+dato["id"]+'>'+dato["empresa"]+'</option>');

            
            
        
        });
    } 
    else
    {  }

})
.fail(function(error) {
    alert("Se produjo el siguiente error: ".err);
})
.always(function() {
});

//cargando las areas
$.ajax({
    method: "POST",
    url: BASE_URL+"/activo/getAreasByActivo",
    dataType: "JSON"
})
.done(function(respuesta) {
   
    if (respuesta) 
    {
        let datos = respuesta;
      

        $("#select_areaMacro").empty();
        $("#select_areaMacro").append('<option value="" selected>Seleccione</option>');

    

        datos.data.forEach(dato => {
            
        
                $("#select_areaMacro").append('<option value='+dato["id"]+'>'+dato["area"]+'</option>');

            
            
        
        });
    } 
    else
    {  }

})
.fail(function(error) {
    alert("Se produjo el siguiente error: ".err);
})
.always(function() {
});

//cargando las Unidades
$.ajax({
    method: "POST",
    url: BASE_URL+"/activo/getUnidadByActivo",
    dataType: "JSON"
})
.done(function(respuesta) {
   
    if (respuesta) 
    {
        let datos = respuesta;
      

        $("#select_unidadesMacro").empty();
        $("#select_unidadesMacro").append('<option value="" selected>Seleccione</option>');

    

        datos.data.forEach(dato => {
            
        
                $("#select_unidadesMacro").append('<option value='+dato["id"]+'>'+dato["unidad"]+'</option>');

            
            
        
        });
    } 
    else
    {  }

})
.fail(function(error) {
    alert("Se produjo el siguiente error: ".err);
})
.always(function() {
});


    if ($.fn.DataTable.isDataTable('#table_macroproceso')){
        
        $('#table_macroproceso').DataTable().rows().remove();
        $('#table_macroproceso').DataTable().destroy();
    
    }

    $('#table_macroproceso').DataTable({
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
        scrollX: true,
        fixedColumns:   {
            heightMatch: 'none'
        },
        responsive: false,
        autoWidth: false,
        // processing: true,
        lengthMenu:[5,10,25,50],
        pageLength:10,
        clickToSelect:false,
        ajax: BASE_URL+"/activo/getMacroproceso",
        aoColumns: [
            { "data": "id" },
            { "data": "macroproceso" },
            { "data": "empresa" },
            { "data": "area" },
            { "data": "unidad" },
            {  "data": "estado",
                        
            "mRender": function(data, type, value) {
                if (data == '1') return  'Activo';
                else return 'Inactivo'
                  

                }
            },
            { "data": "idempresa" },
            { "data": "idarea" },
            { "data": "idunidad" },
          
            { "defaultContent": "<editMacroproceso class='text-primary btn btn-opcionTabla' data-toggle='tooltip' data-placement='top' title='Editar' data-original-title='Editar'><i class='fas fa-edit font-size-18'></i></editMacroproceso>"+
            "<deleteMacroproceso class='text-danger btn btn-opcionTabla' data-toggle='tooltip' data-placement='top' title='Eliminar' data-original-title='Eliminar'><i class='far fa-trash-alt font-size-18'></i></deleteMacroproceso>"

},
        ],
        columnDefs: [
            {
                "targets": [ 6,7,8 ],
                "visible": false,
                "searchable": false
            },
            
        ],
        'drawCallback': function () {
            $( 'table_macroproceso tbody tr td' ).css( 'padding', '1px 1px 1px 1px' );
        }
        
    })
   
}
document.getElementById("btnAgregar_Macroproceso").addEventListener("click",function(){
                                
    $("#modal_macroproceso").modal("show");
    document.getElementById("title-macroproceso").innerHTML = "Agregar ";
    document.getElementById("form_macroproceso").reset();
    document.getElementById("Agregar_Macroproceso").style.display = "block";
    document.getElementById("Modificar_Macroproceso").style.display = "none";
});

// // boton de agregar Macroproceso
document.getElementById("Agregar_Macroproceso").addEventListener("click",function(){
    $select_empresaMacro=document.getElementById("select_empresaMacro").value;
    $select_areaMacro=document.getElementById("select_areaMacro").value;
    $select_unidadesMacro=document.getElementById("select_unidadesMacro").value;
    $nom_mac=document.getElementById("nom_macroproceso").value;
    $est_mac=document.getElementById("est_macroproceso").value;
    
    if($select_empresaMacro !="" && $select_areaMacro !="" && $select_unidadesMacro !="" && $nom_mac !="" && $est_mac != ""){
       
                const postData = { 
                    idempresa:$select_empresaMacro,
                    idarea:$select_areaMacro,
                    idunidad:$select_unidadesMacro,
                    macroproceso:$nom_mac,
                    estado:$est_mac,
                    
                };
               
                try {

                    $.ajax({
                        method: "POST",
                        url: BASE_URL+"/activo/addMacroproceso",
                        data: postData,
                        dataType: "JSON"
                    })
                    .done(function(respuesta) {
                     
                        if (respuesta.error==1) 
                        {
                        
                            document.getElementById("form_macroproceso").reset();
                            $('#modal_macroproceso').modal('hide');
                            alerta_macroproceso.innerHTML = '<div class="alert alert-success alert-dismissible fade show" role="alert">'+
                            respuesta.msg+
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                                '<span aria-hidden="true">&times;</span>'+
                                '</button>'+
                            '</div>';
                            $("#table_macroproceso").DataTable().ajax.reload(null, false); 
                           
                        } else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: respuesta.msg
                              })
                        } 
                        
                    })
                    .fail(function(error) {
                        alert("Error en el ajax");
                    })
                    .always(function() {
                    });
                }
                catch(err) {
                    alert("Error en el try");
                }
            
           
       
    }else{
        Swal.fire({
                 icon: 'error',
                 title: 'Error',
                 text: 'Faltan Datos'
               })
  }


});

//editar Macroproceso
$('#table_macroproceso tbody').on( 'click', 'editMacroproceso', function(){
    $("#modal_macroproceso").modal("show");
    document.getElementById("title-macroproceso").innerHTML = "Modificar";
    document.getElementById("form_macroproceso").reset();
    document.getElementById("Agregar_Macroproceso").style.display = "none";
    document.getElementById("Modificar_Macroproceso").style.display = "block";
   
    //recuperando los datos
    var table = $('#table_macroproceso').DataTable();
    var regNum = table.rows( $(this).parents('tr') ).count().toString();
    var regDat = table.rows( $(this).parents('tr') ).data().toArray();
    if (regNum == '0') {
        //console.log("error");
    }else{
        document.getElementById("id_macroproceso").value=regDat[0]["id"];
        document.getElementById("select_empresaMacro").value=regDat[0]["idempresa"];
        document.getElementById("select_areaMacro").value=regDat[0]["idarea"];
        document.getElementById("select_unidadesMacro").value=regDat[0]["idunidad"];
        document.getElementById("nom_macroproceso").value=regDat[0]["macroproceso"];
        document.getElementById("est_macroproceso").value=regDat[0]["estado"];
     
    }
});
//guardando la nueva info
document.getElementById("Modificar_Macroproceso").addEventListener("click", function(){
    $select_empresaMacro=document.getElementById("select_empresaMacro").value;
    $select_areaMacro=document.getElementById("select_areaMacro").value;
    $select_unidadesMacro=document.getElementById("select_unidadesMacro").value;
    $nom_mac=document.getElementById("nom_macroproceso").value;
    $est_mac=document.getElementById("est_macroproceso").value;
    
    if($select_empresaMacro !="" && $select_areaMacro !="" && $select_unidadesMacro !="" && $nom_mac !="" && $est_mac != ""){
       
                const postData = { 
                    id:document.getElementById("id_macroproceso").value,
                    idempresa:$select_empresaMacro,
                    idarea:$select_areaMacro,
                    idunidad:$select_unidadesMacro,
                    macroproceso:$nom_mac,
                    estado:$est_mac,
                };
              
                try {

                    $.ajax({
                        method: "POST",
                        url: BASE_URL+"/activo/updateMacroproceso",
                        data: postData,
                        dataType: "JSON"
                    })
                    .done(function(respuesta) {
                       
                        if (respuesta) 
                        {
                            document.getElementById("form_macroproceso").reset();
                            $('#modal_macroproceso').modal('hide');
                            alerta_macroproceso.innerHTML = '<div class="alert alert-success alert-dismissible fade show" role="alert">'+
                            'Macroproceso Modificado'+
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                                '<span aria-hidden="true">&times;</span>'+
                                '</button>'+
                            '</div>';
                            $("#table_macroproceso").DataTable().ajax.reload(null, false); 
                           
                        } 
                        
                    })
                    .fail(function(error) {
                        // alert("Error en el ajax");
                    })
                    .always(function() {
                    });
                }
                catch(err) {
                    // alert("Error en el try");
                }
            
           
       
    }else{
        Swal.fire({
                 icon: 'error',
                 title: 'Error',
                 text: 'Faltan Datos'
               })
  }
   
});
//eliminar Macroproceso
$('#table_macroproceso tbody').on( 'click', 'deleteMacroproceso', function(){
     
    //recuperando los datos
    var table = $('#table_macroproceso').DataTable();
    var regNum = table.rows( $(this).parents('tr') ).count().toString();
    var regDat = table.rows( $(this).parents('tr') ).data().toArray();
    const postData = { 
        id:regDat[0]["id"],
 
    };
    
    try {

        $.ajax({
            method: "POST",
            url: $('#base_url').val()+"/activo/deleteMacroproceso",
            data: postData,
            dataType: "JSON"
        })

     
        .done(function(respuesta) {
        //  console.log(respuesta);
            if (respuesta.msg) 
            {
                
                alerta_macroproceso.innerHTML = '<div class="alert alert-success alert-dismissible fade show" role="alert">'+
                respuesta.msg+
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                    '<span aria-hidden="true">&times;</span>'+
                    '</button>'+
                '</div>';

                $("#table_macroproceso").DataTable().ajax.reload(null, true); 
               
            }else{
                alerta_macroproceso.innerHTML = '<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
                respuesta.error+
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                    '<span aria-hidden="true">&times;</span>'+
                    '</button>'+
                '</div>';
            } 
            
        })
        .fail(function(error) {
            // alert("Error en el ajax");
        })
        .always(function() {
        });
    }
    catch(err) {
        // alert("Error en el try");
    }
});