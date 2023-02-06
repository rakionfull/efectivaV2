var BASE_URL = document.getElementById("base_url").value;
document.getElementById("btn_Acceder").addEventListener("click",function(){
    event.preventDefault();
    $username=document.getElementById("username").value;
    $pass=document.getElementById("pass").value;
    $captcha=document.getElementById("captcha").value;

    if($username !=""  && $pass != "" && $captcha != ""){
       
                const postData = { 
                    username:$username,
                    pass:$pass,
                    captcha:$captcha
                    
                };
          
                try {

                    $.ajax({
                        method: "POST",
                        url: BASE_URL+"/auth/validaCaptcha",
                        data: postData,
                        dataType: "JSON"
                    })
                    .done(function(respuesta) {
                        console.log(respuesta);
                        if(respuesta.error){
                            
                            document.getElementById("form_login").reset();
                           
                            $("#alert_login").append('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
                            respuesta.error+
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                                '<span aria-hidden="true">&times;</span>'+
                             '</button>'+
                             '</div>'
                            );
                          
                        }else{
                            if (!respuesta.password) 
                            {
                                if(respuesta.change==0){
                                    Swal.fire(
                                        'Cambio de clave!!',
                                         respuesta.msg,
                                        'warning'
                                      );
                                    setTimeout( function() { window.location.href = BASE_URL+"/change_pass"; }, 3000 );
                                   
                                }else{
                                    Swal.fire(
                                        'Exito!!',
                                        'Logeado Correctamente',
                                        'success'
                                      );
                                    setTimeout( function() { window.location.href = BASE_URL+"/inicio"; }, 2000 );
                                   
                                }
                                
                               
                                                       
                            }else{
                                //credenciales incorrectas
                                document.getElementById("form_login").reset();
                                $("#alert_login").append('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
                                respuesta.password+
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                                    '<span aria-hidden="true">&times;</span>'+
                                    '</button>'+
                                '</div>');
                               
                            }

                        }
                        
                        
                    })
                    .fail(function(error) {
                        
                    })
                    .always(function() {
                    });
                }
                catch(err) {
                    
                }
            
           
       
    }else{
        Swal.fire({
                 icon: 'error',
                 title: 'Error',
                 text: 'Debe completar todos los campos'
               })
  }
   


});