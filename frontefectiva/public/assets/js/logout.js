
document.getElementById("btn_Logout").addEventListener("click",function(){
    event.preventDefault();
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
                        Swal.fire(
                            'Exito!!',
                            'Has Deslogeado Correctamente',
                            'success'
                          );
                        setTimeout( function() { window.location.href = BASE_URL+"/login"; }, 2000 );
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
            

   


});