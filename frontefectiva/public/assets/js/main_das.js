/* Validar solo Números */
var BASE_URL = document.getElementById("base_url").value;
function soloNumero(e)
{
    var key = window.Event ? e.which : e.keyCode;
    return ((key >= 48 && key <= 57) || (key==8) || (key==45));
}


/* Validar solo Letras */

function soloLetra(e)
{
    var key = window.Event ? e.which : e.keyCode;
    return ((key >= 65 && key <= 90) || (key >= 97 && key <= 122) || (key==8) || (key==32) || (key==45) || (key==209) || (key==241));
}

   
var timeout;
document.onmousemove = function(){ 
    clearTimeout(timeout); 
    contadorSesion(); //aqui cargamos la funcion de inactividad
} 

function contadorSesion() {
   timeout = setTimeout(function () {
        $.confirm({
            title: 'Alerta de Inactividad!',
            content: 'La sesión esta a punto de expirar.',
            autoClose: 'expirar|10000',//cuanto tiempo necesitamos para cerrar la sess automaticamente
            type: 'red',
            icon: 'fa fa-spinner fa-spin',
            buttons: {
                expirar: {
                    text: 'Cerrar Sesión',
                    btnClass: 'btn-red',
                    action: function () {
                        salir();
                    }
                },
                permanecer: function () {
                    contadorSesion(); //reinicia el conteo
                    clearTimeout(timeout); //reinicia el conteo
                    $.alert('La Sesión ha sido reiniciada!'); //mensaje
                    window.location.href = BASE_URL + "/inicio";
                }
            }
        });
    }, 900000);//3 segundos para no demorar tanto 
}

function salir() {
        
                    const postData = { 
                     
                    };
                  
                    try {
    
                        $.ajax({
                            method: "POST",
                            url: BASE_URL+"/logout",
                            data: postData,
                            dataType: "JSON"
                        })
                        .done(function(respuesta) {
                           
                           if(respuesta.dato){
                           
                            setTimeout( function() { window.location.href = BASE_URL+"/login"; }, 2000 );
                            Swal.fire(
                                'Advertencia!!',
                                'Deslogeado por Inactividad',
                                'warning'
                              );
                           }
                                   
                                                  
                        })
                        .fail(function(error) {
                            alert("Error en el ajax");
                        })
                        .always(function() {
                        });
                    }
                    catch(err) {
                        // alert("Error en el try");
                    }
                
    
       
    
    

}