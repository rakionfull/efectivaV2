<?php

namespace App\Controllers;
// use App\Libraries\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Main extends BaseController {
  protected $error;
    public function inicio() {
     
      if($this->session->logged_in){
       
        $get_endpoint = '/api/dashboard';
        $response =perform_http_request('GET', REST_API_URL . $get_endpoint,[]);
       
        if($response){
          $data["mensaje"] = $response->msg;
          return view('main/inicio',$data);
        }
      }else{
        return redirect()->to(base_url('/login'));
      }
    
      
    }
    public function cambio_clave(){
      if($this->session->logged_in){
       
        return view('auth/cambio_clave');
      }else{
        return redirect()->to(base_url('/login'));
      }
     

    }
    public function reseteo_pass($id){
      if($this->session->logged_in){
        $this->session->set('id_us',$id);
        $data['id_us'] = $id;
        return view('auth/reseteo_pass',$data);
      }else{
        return redirect()->to(base_url('/login'));
      }
     

    }
    public function updateClave(){
    
      if($this->session->logged_in){
        if($this->request->getPost()){
          $post_endpoint = '/api/change_pass';
          
             $request_data = [
              "passw" => $this->request->getPost('passw'),
              "repassw" => $this->request->getPost('repassw'),
              "terminal" =>navegacion($this->request->getUserAgent()),
              "ip" =>  $this->request->getIPAddress(),
              "username" =>  $this->session->user,
              "id" =>  $this->session->id,
            ];
           $response = (perform_http_request('POST', REST_API_URL . $post_endpoint,$request_data));
            //  var_dump($response);
            if(isset($response->error)){
              $this->session->setFlashdata('error','<div class="alert alert-danger alert-dismissible fade show" role="alert">
             '.$response->error.'
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
            </div>');
            return redirect()->to(base_url('/cambio_clave'));
           }else{
            $this->session->setFlashdata('error','<div class="alert alert-success alert-dismissible fade show" role="alert">
            Clave Modificada Correctamente
             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
             </button>
           </div>');
            return redirect()->to(base_url('/inicio'));
          }
           
           
        }else{
          return redirect()->to(base_url('/login'));
        }
      }

     
    }
    public function updateClave2($id){
   
      if($this->session->logged_in){
        if($this->request->getPost()){
          $post_endpoint = '/api/change_pass';
         
             $request_data = [
              "passw" => $this->request->getPost('passw'),
              "repassw" => $this->request->getPost('repassw'),
              "terminal" =>navegacion($this->request->getUserAgent()),
              "ip" =>  $this->request->getIPAddress(),
              "username" =>  $this->session->user,
              "id" =>  $this->session->id,
              "id_us" =>  $this->session->id_us,
            ];
           $response = (perform_http_request('POST', REST_API_URL . $post_endpoint,$request_data));
            //  var_dump($response);
            if(isset($response->error)){
              $this->session->setFlashdata('error','<div class="alert alert-danger alert-dismissible fade show" role="alert">
             '.$response->error.'
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
            </div>');
          
           $data['id_us'] =  $this->session->id_us;
            return view('auth/reseteo_pass',$data);
           }else{
            $this->session->setFlashdata('error','<div class="alert alert-success alert-dismissible fade show" role="alert">
            Clave Modificada Correctamente
             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
             </button>
           </div>');
           $this->session->remove('id_us');
            return redirect()->to(base_url('/listUsers'));
          }
           
           
        }else{
          return redirect()->to(base_url('/login'));
        }
      }

     
    }
    public function listUsers(){
      
        //opteniendo los datos
        if($this->session->logged_in && $this->session->permisos[3]->view_det==1){
         
          // $response =perform_http_request('GET', REST_API_URL . $get_endpoint,[]);
          // if($response){
     
          //   $data["users"]=$response->datos;
     
              return view('accesos/listUsers');
          //}
        }else{
          return redirect()->to(base_url('/login'));
        }
        
     
  
    }
    public function getUsers($est){

      $get_endpoint = '/api/getUsers';
      $request_data = ['estado' => $est];
      $response =perform_http_request('GET', REST_API_URL . $get_endpoint,$request_data);
      // var_dump($response);
      if($response){
 
       echo json_encode($response);

      }
    }
    public function updateEstadoUser(){
      if($this->session->logged_in){
        if($this->request->getPost()){
          $post_endpoint = '/api/updateEstadoUser';
            $request_data = [
              "data" => $this->request->getPost(),
              "terminal" =>navegacion($this->request->getUserAgent()),
              "ip" =>  $this->request->getIPAddress(),
              "username" =>  $this->session->user,
              "id" =>  $this->session->id,
            ];

            
           $response = (perform_http_request('PUT', REST_API_URL . $post_endpoint,$request_data));
            //  var_dump($response);
          if($response){
            echo json_encode($response);
          }  
           
           
        }else{
          return redirect()->to(base_url('/login'));
        }
      }
    }
    public function configPass(){

      if($this->session->logged_in && $this->session->permisos[4]->view_det==1){
              $post_endpoint = '/api/getConfigPass';
                  
              $request_data = [];
              
              $response = (perform_http_request('GET', REST_API_URL . $post_endpoint,$request_data));
              if($response->data){
                $datos = $response->data[0];
              }else{
                
              }
              
              $error = new  \stdClass;
              $error->duracion = '';
              $error->tama_min = '';
              $error->tama_max = '';
              $error->sesion = '';
              $error->inactividad = '';
              $error->intentos = '';
              // $error->letras = '';
              // $error->numeros = '';
              // $error->caracteres = '';
              $data = [
                'data' => $datos,
                'error'   =>  $error
                
              ];
             
              return view('accesos/configPass',$data);
            }else{
              return redirect()->to(base_url('/login'));
            }
    }
      public function addConfigPass() {
        // helper(['curl']);
        if($this->session->logged_in){
          if(!$this->request->getPost())
          {
            return redirect()->to(base_url('/inicio'));
          }else{
        
              $post_endpoint = '/api/addConfigPass';
              $request_data = $this->request->getPost();
             
              $numeros=0;
              if($this->request->getPost('num_pass')){
                $numeros=1;
                $request_data['numeros'] = $numeros;
              }else{
                
                $numeros=0;
                $request_data['numeros'] = $numeros;
              }
              $letras=0;
              if($this->request->getPost('letra_pass')){
                
                $letras=1;
                $request_data['letras'] = $letras;
              }else{
                
                $letras=0;
                $request_data['letras'] = $letras;
              }
              $char=0;
              if($this->request->getPost('char_pass')){
                
                $char=1;
                $request_data['caracteres'] = $char;
              }else{
                
                $char=0;
                $request_data['caracteres'] = $char;
              }
             
                              
              
             $response = (perform_http_request('POST', REST_API_URL . $post_endpoint,$request_data));
            
              if(isset($response->error)){
                $datos=[
                  'data' => $request_data,
                  'error' => $response->datos,
                ];
  
                return view('accesos/configPass',$datos);
              }else{
                if($response->msg ){
                  $this->session->setFlashdata('error','<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Parametros Guaradados correctamente
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                    </div>');
                    return redirect()->to(base_url('/configPass'));
                  }else{
                      $this->session->setFlashdata('error','<div class="alert alert-danger alert-dismissible fade show" role="alert">
                      Error al registrar
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                      </div>');
                      return redirect()->to(base_url('/inicio'));
                  }
              }
             
              
          
             
            
          }
        }
       
         
      }
      public function createUser(){
        if($this->session->logged_in && $this->session->permisos[3]->create_det==1){
          $datos=[
            'docident_us' => "",
            'nombres_us' => "",
            'apepat_us' => "",
            'apemat_us' => "",
            'email_us' => "",
            'usuario_us' => "",
            'perfil_us' => "",
          ];
          $error = new  \stdClass;
          $error->docident_us = '';
          $error->nombres_us = '';
          $error->apepat_us = '';
          $error->apemat_us = '';
          $error->email_us = '';
          $error->usuario_us = '';
          $error->perfil_us = '';
          $request_data = ['estado' => 1];
          $get_endpoint = '/api/getPerfiles';

          $response =perform_http_request('GET', REST_API_URL . $get_endpoint,$request_data);
          
          $get_endpoint = '/api/getEmpresasByActivo';
          $empresas = perform_http_request('GET', REST_API_URL . $get_endpoint,[]);

          $get_endpoint = '/api/getAreasByActivo';
          $areas = perform_http_request('GET', REST_API_URL . $get_endpoint,[]);
          
          $get_endpoint = '/api/getUnidadByActivo';
          $unidad = perform_http_request('GET', REST_API_URL . $get_endpoint,[]);

          $get_endpoint = '/api/getPosicionByActivo';
          $posicion = perform_http_request('GET', REST_API_URL . $get_endpoint,[]);

          $data = [
                'data' => $datos,
                'error'   =>  $error,
                'perfiles' =>  $response,
                'empresa' =>  $empresas->data,
                'area' =>  $areas->data,
                'unidad' =>  $unidad->data,
                'posicion' =>  $posicion->data,
          ];
      
          return view('accesos/createUser',$data);
        }else{
          return redirect()->to(base_url('/login'));
        }
        
        
  
      }
      public function modifyUser($id){
        if($this->session->logged_in && $this->session->permisos[3]->update_det==1){
            if($id){
              $post_endpoint = '/api/getUser/'.$id;
              $request_data = [];
              $response = (perform_http_request('GET', REST_API_URL . $post_endpoint,$request_data));

              //traigo los perfiles
              $get_endpoint = '/api/getPerfiles';
              $request_data = ['estado' => 1];
              $perfiles =perform_http_request('GET', REST_API_URL . $get_endpoint,$request_data);

              $get_endpoint = '/api/getEmpresasByActivo';
              $empresas = perform_http_request('GET', REST_API_URL . $get_endpoint,[]);

              $get_endpoint = '/api/getAreasByActivo';
              $areas = perform_http_request('GET', REST_API_URL . $get_endpoint,[]);
              
              $get_endpoint = '/api/getUnidadByActivo';
              $unidad = perform_http_request('GET', REST_API_URL . $get_endpoint,[]);

              $get_endpoint = '/api/getPosicionByActivo';
              $posicion = perform_http_request('GET', REST_API_URL . $get_endpoint,[]);

              $error = new  \stdClass;
              $error->docident_us = '';
              $error->nombres_us = '';
              $error->apepat_us = '';
              $error->apemat_us = '';
              $error->email_us = '';
              $error->usuario_us = '';
              $error->perfil_us = '';
              $error->estado_us = '';

              $data = [
                'user' => $response->datos,
                'error'   =>  $error,
                'perfiles' =>  $perfiles,
                'empresa' =>  $empresas->data,
                'area' =>  $areas->data,
                'unidad' =>  $unidad->data,
                'posicion' =>  $posicion->data,
                
             ];
      
              return view('accesos/updateUser',$data);
            }else{
              return redirect()->to(base_url('/listUsers'));
            }
        }else{
          return redirect()->to(base_url('/login'));
        }
       
      
      }
     
      public function addUser() {
        // helper(['curl']);
        if($this->session->logged_in && $this->session->permisos[3]->view_det==1){
          if(!$this->request->getPost())
          {
            return redirect()->to(base_url('/listUsers'));
          }else{
        
              $post_endpoint = '/api/addUser';
             
              // $request_data = (array("username" => $this->request->getPost('username'), "password" => $this->request->getPost('pass')));
              $request_data = [
                                "data" => $this->request->getPost(),
                                "terminal" =>navegacion($this->request->getUserAgent()),
                                "ip" =>  $this->request->getIPAddress(),
                                "username" =>  $this->session->user,
                                "id" =>  $this->session->id,
                              ];
              $response = (perform_http_request('POST', REST_API_URL . $post_endpoint,$request_data));
             
              if(isset($response->error)){
                $get_endpoint = '/api/getPerfiles';
                $request_data = ['estado' => 1];
                $getPerfiles =perform_http_request('GET', REST_API_URL . $get_endpoint,$request_data);

                $datos=[
                  'data' => $this->request->getPost(),
                  'error' => $response->datos,
                  'perfiles' =>  $getPerfiles,
                ];
                return view('accesos/createUser',$datos);
              }else{
                // var_dump($response);
                if($response->user ){
                  $this->session->setFlashdata('error','<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Usuario creado correctamente
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                    </div>');
                    return redirect()->to(base_url('/listUsers'));
                  }else{
                      $this->session->setFlashdata('error','<div class="alert alert-danger alert-dismissible fade show" role="alert">
                      Error al registrar
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                      </div>');
                      return redirect()->to(base_url('/listUsers'));
                  }
              }
             
              
          
             
            
          }
        }
       
         
      }
      public function updateUser($id) {
        
        if($this->session->logged_in && $this->session->permisos[3]->update_det==1){
          if(!$this->request->getPost())
          {
            return redirect()->to(base_url('/modifyUser'));
          }else{
        
              $post_endpoint = '/api/updateUser/'.$id;
              $request_data = [
                                "data" => $this->request->getPost(),
                                "terminal" =>navegacion($this->request->getUserAgent()),
                                "ip" =>  $this->request->getIPAddress(),
                                "username" =>  $this->session->user,
                                "id" =>  $this->session->id,
              ];
              
              $response = perform_http_request('PUT', REST_API_URL . $post_endpoint,$request_data);
             
                if($response->user ){
                  $this->session->setFlashdata('error','<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Usuario modificado correctamente
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                    </div>');
                    return redirect()->to(base_url('/listUsers'));
                  }else{
                      $this->session->setFlashdata('error','<div class="alert alert-danger alert-dismissible fade show" role="alert">
                      Error al modificar
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                      </div>');
                      return redirect()->to(base_url('/listUsers'));
                  }
              
             
          
             
            
          }
        }
       
         
        
      }
      public function deleteUser($id) {
        if($this->session->logged_in && $this->session->permisos[3]->delete_det==1){
          $post_endpoint = '/api/deleteUser/'.$id;
          $request_data = [
            "terminal" =>navegacion($this->request->getUserAgent()),
            "ip" =>  $this->request->getIPAddress(),
            "username" =>  $this->session->user,
            "id" =>  $this->session->id,
          ];
          $response = perform_http_request('DELETE', REST_API_URL . $post_endpoint,$request_data);
         
          if($response->user ){
                 $this->session->setFlashdata('error','<div class="alert alert-success alert-dismissible fade show" role="alert">
            Usuario eliminado correctamente
             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
             </button>
           </div>');
            return redirect()->to(base_url('/listUsers'));
          }else{
              $this->session->setFlashdata('error','<div class="alert alert-danger alert-dismissible fade show" role="alert">
              Error al eliminar
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
             </div>');
              return redirect()->to(base_url('/listUsers'));
          }
        }
            
        
           
          
        
         
          //opteniendo el cpatcha
        
          // return view('auth/login',$data);
      }
      public function perfiles(){
      
        //opteniendo los datos
        if($this->session->logged_in && $this->session->permisos[5]->view_det==1){
       
     
              return view('accesos/perfiles');
         
        }else{
          return redirect()->to(base_url('/login'));
        }
        
     
  
      }
      public function detPerfil($id){
      
        //opteniendo los datos
        if($this->session->logged_in && $this->session->permisos[5]->view_det==1){
        
          $request_data = ['id_perfil' => $id ];
          //endpoint de los datos necesarios para detalle_perfil
          $get_endpoint = '/api/getModulos';
          $get_Perfil = '/api/getDetPerfil';
          $get_Opcion = '/api/getOpcion';
          $get_Item = '/api/getItem';

          $perfil =perform_http_request('GET', REST_API_URL . $get_Perfil,$request_data);
          $modulos =perform_http_request('GET', REST_API_URL . $get_endpoint,$request_data);
          $opcion =perform_http_request('GET', REST_API_URL . $get_Opcion,$request_data);
          $item =perform_http_request('GET', REST_API_URL . $get_Item,$request_data);

          if($modulos){
           
              $data["modulos"]=$modulos->data;
              $data["opciones"]=$opcion->data;
              $data["items"]=$item->data;
              $data["perfil"]=$perfil->data;
             


              return view('accesos/detPerfil',$data);
          }
        }else{
          return redirect()->to(base_url('/login'));
        }
        
     
  
      }
      public function getPerfiles($est){
        if($this->session->logged_in){
          $get_endpoint = '/api/getPerfiles';
          $request_data = ['estado' => $est];
          $response =perform_http_request('GET', REST_API_URL . $get_endpoint,$request_data);
          if($response){
           
            echo json_encode($response);
          }
        }
      }
      public function validarPerfil(){
        if($this->session->logged_in){
         
            $post_endpoint = '/api/validarPerfil';
           
            $request_data =  $this->request->getPost();
             
            $response = (perform_http_request('POST', REST_API_URL . $post_endpoint,$request_data));
  
            echo json_encode($response->msg);

        }
      }
      public function addPerfil() {
        // helper(['curl']);
        if($this->session->logged_in && $this->session->permisos[5]->create_det==1){
          if(!$this->request->getPost())
          {
            return redirect()->to(base_url('/listUsers'));
          }else{
        
              $post_endpoint = '/api/addPerfil';
             
              $request_data = [
                "data" => $this->request->getPost(),
                "terminal" =>navegacion($this->request->getUserAgent()),
                "ip" =>  $this->request->getIPAddress(),
                "username" =>  $this->session->user,
                "id" =>  $this->session->id,
              ];
              $response = (perform_http_request('POST', REST_API_URL . $post_endpoint,$request_data));
              // var_dump($response);
              
                if($response->msg ){
                    echo json_encode($response->msg);
                
                }else{
                  echo json_encode(false);
                }
             
              
          
             
            
          }
        }
       
         
      }
      public function updatePerfil() {
        // helper(['curl']);
        if($this->session->logged_in && $this->session->permisos[5]->update_det==1){
          if(!$this->request->getPost())
          {
            return redirect()->to(base_url('/perfiles'));
          }else{
        
              $post_endpoint = '/api/updatePerfil';
              $request_data = [];
              // $request_data = (array("username" => $this->request->getPost('username'), "password" => $this->request->getPost('pass')));
              $request_data = $this->request->getPost();
             
              $response = (perform_http_request('POST', REST_API_URL . $post_endpoint,$request_data));
              // var_dump($response);
              
                if($response->msg ){
                    echo json_encode($response->msg);
                
                }else{
                  echo json_encode(false);
                }
             
              
          
             
            
          }
        }
       
         
      }
      public function deletePerfil($id) {
      
        if($this->session->logged_in && $this->session->permisos[5]->delete_det==1){
        
        
              $post_endpoint = '/api/deletePerfil';
           
              $request_data = ['id' => $id ] ;

              $response = (perform_http_request('DELETE', REST_API_URL . $post_endpoint,$request_data));
             
              if(isset($response->msg)){
                $this->session->setFlashdata('error','<div class="alert alert-success alert-dismissible fade show" role="alert">
                  Perfil Elimnado correctamente
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                  </div>');
                  return redirect()->to(base_url('/perfiles'));
                }else{
                    $this->session->setFlashdata('error','<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    '.$response->error.'
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                    </div>');
                    return redirect()->to(base_url('/perfiles'));
                }       
                          
          
        }
       
         
      }
     
      //update del detalle perfil
      public function updateView() {
        // helper(['curl']);
        if($this->session->logged_in){
          if(!$this->request->getPost())
          {
            return redirect()->to(base_url('/listUsers'));
          }else{
        
              $post_endpoint = '/api/updateView';
    
              // $request_data = (array("username" => $this->request->getPost('username'), "password" => $this->request->getPost('pass')));
              $request_data = [
                "data" => $this->request->getPost(),
                "terminal" =>navegacion($this->request->getUserAgent()),
                "ip" =>  $this->request->getIPAddress(),
                "username" =>  $this->session->user,
                "id" =>  $this->session->id,
              ];
             
              $response = (perform_http_request('POST', REST_API_URL . $post_endpoint,$request_data));
              // var_dump($response);
              // echo json_encode($request_data);
                if($response->msg ){
                    echo json_encode($response->msg);
                
                }else{
                  echo json_encode(false);
                }
 
          }
        }
       
         
      }
      public function updateCreate() {
        // helper(['curl']);
        if($this->session->logged_in){
          if(!$this->request->getPost())
          {
            return redirect()->to(base_url('/listUsers'));
          }else{
        
              $post_endpoint = '/api/updateCreate';
            
              $request_data = [
                "data" => $this->request->getPost(),
                "terminal" =>navegacion($this->request->getUserAgent()),
                "ip" =>  $this->request->getIPAddress(),
                "username" =>  $this->session->user,
                "id" =>  $this->session->id,
              ];
             
             
              $response = (perform_http_request('POST', REST_API_URL . $post_endpoint,$request_data));
              // var_dump($response);
              
                if($response->msg ){
                    echo json_encode($response->msg);
                
                }else{
                  echo json_encode(false);
                }
 
          }
        }
       
         
      }
      public function updateUpdate() {
        // helper(['curl']);
        if($this->session->logged_in){
          if(!$this->request->getPost())
          {
            return redirect()->to(base_url('/listUsers'));
          }else{
        
              $post_endpoint = '/api/updateUpdate';

              $request_data = [
                "data" => $this->request->getPost(),
                "terminal" =>navegacion($this->request->getUserAgent()),
                "ip" =>  $this->request->getIPAddress(),
                "username" =>  $this->session->user,
                "id" =>  $this->session->id,
              ];
             
             
              $response = (perform_http_request('POST', REST_API_URL . $post_endpoint,$request_data));
              // var_dump($response);
              
                if($response->msg ){
                    echo json_encode($response->msg);
                
                }else{
                  echo json_encode(false);
                }
 
          }
        }
       
         
      }
      public function updateDelete() {
        // helper(['curl']);
        if($this->session->logged_in){
          if(!$this->request->getPost())
          {
            return redirect()->to(base_url('/listUsers'));
          }else{
        
              $post_endpoint = '/api/updateDelete';
              
             $request_data = [
                "data" => $this->request->getPost(),
                "terminal" =>navegacion($this->request->getUserAgent()),
                "ip" =>  $this->request->getIPAddress(),
                "username" =>  $this->session->user,
                "id" =>  $this->session->id,
              ];
             
             
              $response = (perform_http_request('POST', REST_API_URL . $post_endpoint,$request_data));
              // var_dump($response);
              
                if($response->msg ){
                    echo json_encode($response->msg);
                
                }else{
                  echo json_encode(false);
                }
 
          }
        }
       
         
      }


      public function reporteUsuarios(){
        
        $post_endpoint = '/api/dataUser';
        $response = (perform_http_request('GET', REST_API_URL . $post_endpoint,[]));
        $data = $response->campos;
    
    
        $spreadsheet = new Spreadsheet();
 
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'Nombres');
        $sheet->setCellValue('C1', 'Apellidos');
        $sheet->setCellValue('D1', 'Usuario');
        $sheet->setCellValue('E1', 'Perfil');
        $sheet->setCellValue('F1', 'Estado');
        $sheet->setCellValue('G1', 'Fecha_creación');
         
        $rows = 2;
 
        foreach ($response->datos as $val){
            $sheet->setCellValue('A' . $rows, $val->id_us);
            $sheet->setCellValue('B' . $rows, $val->nombres_us);
            $sheet->setCellValue('C' . $rows, $val->apepat_us.' '. $val->apemat_us);
            $sheet->setCellValue('D' . $rows, $val->usuario_us);
            $sheet->setCellValue('E' . $rows, $val->perfil);
            $sheet->setCellValue('F' . $rows, $val->estado_us);
            $sheet->setCellValue('G' . $rows, $val->creacion_us);
            $rows++;
        } 
        $writer = new Xlsx($spreadsheet);
        $fecha_creacion= date("Y-m-d");     
        $ruta="reporte_Usuarios_".$fecha_creacion.".xlsx";
        $writer->save('./public/assets/reportes/'.$ruta);
       
        # Le pasamos la ruta de guardado
      
        header("Content-Type: application/vnd.ms-excel");
        // redirect(base_url()."/listUser/".$ruta); 
        echo json_encode($ruta);
        // echo ($fileName);
      }



      public function activos(){
        
        if($this->session->logged_in && $this->session->permisos[6]->view_det==1){
    
              return view('parametrizacion/activos');
         
        }else{
          return redirect()->to(base_url('/login'));
        }

      }
      public function riesgos(){
        $count_scene_1 = 0;
        if($this->session->logged_in){
          $get_endpoint = '/api/getProbabilidadRiesgo/1';
          $response =perform_http_request('GET', REST_API_URL . $get_endpoint,[]);
          if($response){
            $count_scene_1 = count($response->data);
          }
          $get_endpoint = '/api/getProbabilidadRiesgo/2';
          $response =perform_http_request('GET', REST_API_URL . $get_endpoint,[]);
          if($response){
            $count_scene_2 = count($response->data);
          }
          $get_endpoint = '/api/getImpactoRiesgo/1';
          $response =perform_http_request('GET', REST_API_URL . $get_endpoint,[]);
          if($response){
            $count_scene_1_impacto = count($response->data);
          }
          $get_endpoint = '/api/getImpactoRiesgo/2';
          $response =perform_http_request('GET', REST_API_URL . $get_endpoint,[]);
          if($response){
            $count_scene_2_impacto = count($response->data);
          }
          $get_endpoint = '/api/getTiposAmenaza';
          $response =perform_http_request('GET', REST_API_URL . $get_endpoint,[]);
          if($response){
            $tipo_amenaza = $response->data;
          }
        }
        return view('parametrizacion/riesgos',[
          'count_scene_1' => $count_scene_1,
          'count_scene_2' => $count_scene_2,
          'count_scene_1_impacto' => $count_scene_1_impacto,
          'count_scene_2_impacto' => $count_scene_2_impacto,
          'tipos_amenaza' => $tipo_amenaza
        ]);
      } 





      
  }