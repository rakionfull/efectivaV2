
var alerta_posicion = document.getElementById("alert_posicion");

function cargarDatosPosicion() {
     //Carga todas las empresas
     try {
 
        $.ajax({
            method: "POST",
            url: $('#base_url').val()+"/activo/getEmpresasByActivo",
            dataType: "JSON"
        })
        .done(function(respuesta) {
            if (respuesta) 
            {
                let datos = respuesta["data"];
               
                $("#id_empresa_pos").empty();
                $("#id_empresa_pos").append('<option value=>Empresa</option>');
                datos.forEach(dato => {
                    $("#id_empresa_pos").append('<option value='+dato["id"]+'>'+dato["empresa"]+'</option>');
                });
            } 
            else
            { //swal("Error", "Error al recoger los datos", "error"); }
            }
        })
        .fail(function(error) {
            // alert("Se produjo el siguiente error: ".err);
        })
        .always(function() {
        });
    }
    catch(err) {
        // alert("Se produjo el siguiente error: ".err);
    }
     //Carga todas las areas
     try {
 
        $.ajax({
            method: "POST",
            url: $('#base_url').val()+"/activo/getAreasByActivo",
            dataType: "JSON"
        })
        .done(function(respuesta) {
            if (respuesta) 
            {
                let datos = respuesta["data"];
                //console.log(datos);
                $("#id_area_pos").empty();
                $("#id_area_pos").append('<option value=>Área</option>');
                datos.forEach(dato => {
                    $("#id_area_pos").append('<option value='+dato["id"]+'>'+dato["area"]+'</option>');
                });
            } 
            else
            { //swal("Error", "Error al recoger los datos", "error"); }
            }
        })
        .fail(function(error) {
            // alert("Se produjo el siguiente error: ".err);
        })
        .always(function() {
        });
    }
    catch(err) {
        // alert("Se produjo el siguiente error: ".err);
    }
     //Carga todas las unidades
     try {
 
        $.ajax({
            method: "POST",
            url: $('#base_url').val()+"/activo/getUnidadByActivo",
            dataType: "JSON"
        })
        .done(function(respuesta) {
            if (respuesta) 
            {
                let datos = respuesta["data"];
                //console.log(datos);
                $("#id_unidad_pos").empty();
                $("#id_unidad_pos").append('<option value=>Unidad</option>');
                datos.forEach(dato => {
                    $("#id_unidad_pos").append('<option value='+dato["id"]+'>'+dato["unidad"]+'</option>');
                });
            } 
            else
            { //swal("Error", "Error al recoger los datos", "error"); }
            }
        })
        .fail(function(error) {
            // alert("Se produjo el siguiente error: ".err);
        })
        .always(function() {
        });
    }
    catch(err) {
        // alert("Se produjo el siguiente error: ".err);
    }
}

function LoadTablePosicion() {
    if ($.fn.DataTable.isDataTable('#table_posicion')){
        
        $('#table_posicion').DataTable().rows().remove();
        $('#table_posicion').DataTable().destroy();
    
    }

    $('#table_posicion').DataTable({
        
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
        ajax: $('#base_url').val()+"/activo/getPosicion",
        aoColumns: [
            { "data": "id_pos" },
            { "data": "posicion_puesto" },
            { "data": "idempresa" },
            { "data": "empresa" },
            { "data": "idarea" },
            { "data": "area" },
            { "data": "idunidad" },
            { "data": "unidad" },
            {  "data": "estado",
                        
            "mRender": function(data, type, value) {
                if (data == '1') return  'Activo';
                else return 'Inactivo'
                  

                }
            },
            { "defaultContent": "<editPosicion class='text-primary btn btn-opcionTabla' data-toggle='tooltip' data-placement='top' title='Editar' data-original-title='Editar'><i class='fas fa-edit font-size-18'></i></editPosicion>"+
            "<deletePosicion class='text-danger btn btn-opcionTabla' data-toggle='tooltip' data-placement='top' title='Eliminar' data-original-title='Eliminar'><i class='far fa-trash-alt font-size-18'></i></deletePosicion>"

},
        ],
        columnDefs: [
            {
                "targets": [2,4,6 ],
                "visible": false,
                "searchable": false
            },
            
        ],
        'drawCallback': function () {
            $( 'table_posicion tbody tr td' ).css( 'padding', '1px 1px 1px 1px' );
        }
        
    })
    $("#table_posicion").DataTable().ajax.reload(null, true); 
}

//validamos
async function validacionPosicion(){

    let result; /* Variable Resultado de Funcion */

    // Validar existe
        try {

            const postData = {   
              
                posicion : document.getElementById("nom_posicion").value,
                idempresa : document.getElementById("id_empresa_pos").value,
                idarea:document.getElementById("id_area_pos").value,
                idunidad:document.getElementById("id_unidad_pos").value,
            };
           
            await $.ajax({
                method: "POST",
                url: $('#base_url').val()+"/activo/validarPosicion",
                data: postData,
                dataType: "JSON"
            })
            .done(function(respuesta) {
               
                result = respuesta;
            })
            .fail(function(error) {
                // alert("Se produjo el siguiente error: ".err);
            })
            .always(function() {
            });
        }
        catch(err) {
            // alert("Se produjo el siguiente error: ".err);
        }
    // /.Validar existe

    return result; /* Retorno de Resultado */

};

document.getElementById("btnAgregar_Posicion").addEventListener("click",function(){

    $("#modal_posicion").modal("show");
    document.getElementById("title-posicion").innerHTML = "Agregar Posicion/Puesto";
    document.getElementById("form_posicion").reset();
    document.getElementById("Agregar_Posicion").style.display = "block";
    document.getElementById("Modificar_Posicion").style.display = "none";
   
});



// // boton de agregar Valor Activo
document.getElementById("Agregar_Posicion").addEventListener("click",async function(){
    $nom_posicion=document.getElementById("nom_posicion").value;
    $est_posicion=document.getElementById("est_posicion").value;
    $id_empresa_pos=document.getElementById("id_empresa_pos").value;
    $id_area_pos=document.getElementById("id_area_pos").value;
    $id_unidad_pos=document.getElementById("id_unidad_pos").value;
    
    if($nom_posicion !=""  && $est_posicion != "" && $id_empresa_pos != "" && $id_area_pos != "" && $id_unidad_pos != ""){
        if (!(await validacionPosicion())){
                
                const postData = { 
                    posicion : document.getElementById("nom_posicion").value,
                    idempresa : document.getElementById("id_empresa_pos").value,
                    idarea:document.getElementById("id_area_pos").value,
                    idunidad:document.getElementById("id_unidad_pos").value,
                    estado:$est_posicion,
                };
               console.log(postData);
                try {

                    $.ajax({
                        method: "POST",
                        url: $('#base_url').val()+"/activo/addPosicion",
                        data: postData,
                        dataType: "JSON"
                    })
                    .done(function(respuesta) {
                     
                        if (respuesta) 
                        {
                            document.getElementById("form_posicion").reset();
                            $('#modal_posicion').modal('hide');
                            alerta_posicion.innerHTML = '<div class="alert alert-success alert-dismissible fade show" role="alert">'+
                            'Posicion Registrada Correctamente'+
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                                '<span aria-hidden="true">&times;</span>'+
                                '</button>'+
                            '</div>';
                            $("#table_posicion").DataTable().ajax.reload(null, true); 
                           
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
                         text: 'El puesto ya fue registrado para esa empresa, area y unidad'
                       })
          }
           
       
    }else{
        Swal.fire({
                 icon: 'error',
                 title: 'Error',
                 text: 'Debe completar todos los campos'
               })
  }

});

//editar Valor Activo
$('#table_posicion tbody').on( 'click', 'editPosicion', function(){
    $("#modal_posicion").modal("show");
    document.getElementById("title-posicion").innerHTML = "Modificar Posición/Puesto";
    document.getElementById("form_posicion").reset();
    document.getElementById("Agregar_Posicion").style.display = "none";
    document.getElementById("Modificar_Posicion").style.display = "block";
    //recuperando los datos
    var table = $('#table_posicion').DataTable();
    var regNum = table.rows( $(this).parents('tr') ).count().toString();
    var regDat = table.rows( $(this).parents('tr') ).data().toArray();
    
    if (regNum == '0') {
        //console.log("error");
    }else{
        document.getElementById("id_posicion").value=regDat[0]["id_pos"];
        document.getElementById("nom_posicion").value=regDat[0]["posicion_puesto"];
        document.getElementById("est_posicion").value=regDat[0]["estado"];
        document.getElementById("id_empresa_pos").value=regDat[0]["idempresa"];
        document.getElementById("id_area_pos").value=regDat[0]["idarea"];
        document.getElementById("id_unidad_pos").value=regDat[0]["idunidad"];
     
    }
});
//guardando la nueva info
document.getElementById("Modificar_Posicion").addEventListener("click",async function(){
    
    $nom_posicion=document.getElementById("nom_posicion").value;
    $est_posicion=document.getElementById("est_posicion").value;
    $id_empresa_pos=document.getElementById("id_empresa_pos").value;
    $id_area_pos=document.getElementById("id_area_pos").value;
    $id_unidad_pos=document.getElementById("id_unidad_pos").value;
    
    if($nom_posicion !=""  && $est_posicion != "" && $id_empresa_pos != "" && $id_area_pos != "" && $id_unidad_pos != ""){
        // if (!(await validacionPosicion())){
                
       
                const postData = { 
                    id:document.getElementById("id_posicion").value,
                    posicion : document.getElementById("nom_posicion").value,
                    idempresa : document.getElementById("id_empresa_pos").value,
                    idarea:document.getElementById("id_area_pos").value,
                    idunidad:document.getElementById("id_unidad_pos").value,
                    estado:$est_posicion,
                };
              
                try {

                    $.ajax({
                        method: "POST",
                        url: $('#base_url').val()+"/activo/updatePosicion",
                        data: postData,
                        dataType: "JSON"
                    })
                    .done(function(respuesta) {
                       
                        if (respuesta) 
                        {
                            document.getElementById("form_posicion").reset();
                            $('#modal_posicion').modal('hide');
                            alerta_posicion.innerHTML = '<div class="alert alert-success alert-dismissible fade show" role="alert">'+
                            'Modificado Correctamente'+
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                                '<span aria-hidden="true">&times;</span>'+
                                '</button>'+
                            '</div>';
                            $("#table_posicion").DataTable().ajax.reload(null, false); 
                           
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
                         text: 'El puesto ya fue registrado para esa empresa, area y unidad'
                       })
          }
       
//     }else{
//         Swal.fire({
//                  icon: 'error',
//                  title: 'Error',
//                  text: 'Faltan Datos'
//                })
//   }
   
});

//eliminar Valor Activo
$('#table_posicion tbody').on( 'click', 'deletePosicion', function(){
     
    //recuperando los datos
    var table = $('#table_posicion').DataTable();
    var regNum = table.rows( $(this).parents('tr') ).count().toString();
    var regDat = table.rows( $(this).parents('tr') ).data().toArray();
    const postData = { 
        id:regDat[0]["id_pos"],
 
    };
    
    try {

        $.ajax({
            method: "POST",
            url: $('#base_url').val()+"/activo/deletePosicion",
            data: postData,
            dataType: "JSON"
        })

     
        .done(function(respuesta) {
       
            if (respuesta.msg) 
            {
                
                alerta_posicion.innerHTML = '<div class="alert alert-success alert-dismissible fade show" role="alert">'+
                respuesta.msg+
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                    '<span aria-hidden="true">&times;</span>'+
                    '</button>'+
                '</div>';

                $("#table_posicion").DataTable().ajax.reload(null, true); 
               
            }else{
                alerta_posicion.innerHTML = '<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
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
