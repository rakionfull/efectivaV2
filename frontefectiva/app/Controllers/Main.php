<?php

namespace App\Controllers;

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
    public function listUsers(){
      
        //opteniendo los datos
        if($this->session->logged_in){
          $get_endpoint = '/api/getUsers';

          $response =perform_http_request('GET', REST_API_URL . $get_endpoint,[]);
          if($response){
     
            $data["users"]=$response->datos;
     
              return view('accesos/listUsers',$data);
          }
        }else{
          return redirect()->to(base_url('/login'));
        }
        
     
  
      }
      public function configPass(){
        return view('accesos/configPass');
  
      }
      public function createUser(){
        if($this->session->logged_in){
          $datos=[
            'docident_us' => "",
            'nombres_us' => "",
            'apepat_us' => "",
            'apemat_us' => "",
            'email_us' => "",
            'usuario_us' => "",
          ];
          $error = new  \stdClass;
          $error->docident_us = '';
          $error->nombres_us = '';
          $error->apepat_us = '';
          $error->apemat_us = '';
          $error->email_us = '';
          $error->usuario_us = '';
         
          $data = [
             'data' => $datos,
             'error'   =>  $error
             
          ];
      
          return view('accesos/createUser',$data);
        }else{
          return redirect()->to(base_url('/login'));
        }
        
        
  
      }
      public function modifyUser($id){
        if($this->session->logged_in){
            if($id){
              $post_endpoint = '/api/getUser/'.$id;
              $request_data = [];
              $response = (perform_http_request('GET', REST_API_URL . $post_endpoint,$request_data));
              $data["user"]=$response->datos;
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
        if($this->session->logged_in){
          if(!$this->request->getPost())
          {
            return redirect()->to(base_url('/listUsers'));
          }else{
        
              $post_endpoint = '/api/addUser';
              $request_data = [];
              // $request_data = (array("username" => $this->request->getPost('username'), "password" => $this->request->getPost('pass')));
              $request_data = $this->request->getPost();
              $response = (perform_http_request('POST', REST_API_URL . $post_endpoint,$request_data));
              // var_dump($response);
              if(isset($response->error)){
                $datos=[
                  'data' => $request_data,
                  'error' => $response->datos,
                ];
                return view('accesos/createUser',$datos);
              }else{
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
        
        if($this->session->logged_in){
          if(!$this->request->getPost())
          {
            return redirect()->to(base_url('/modifyUser'));
          }else{
        
              $post_endpoint = '/api/updateUser/'.$id;
              $request_data = $this->request->getPost();
              
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
        if($this->session->logged_in){
          $post_endpoint = '/api/deleteUser/'.$id;
        
          $response = perform_http_request('DELETE', REST_API_URL . $post_endpoint,[]);
         
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
}