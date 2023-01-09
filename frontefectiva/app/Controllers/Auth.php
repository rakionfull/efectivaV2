<?php

namespace App\Controllers;
use CodeIgniter\HTTP\Response;
 
class Auth extends BaseController {
  public $session = null;
  public function __construct(){
    $this->session = \Config\Services::session();
  }
    public function index() {

		    helper(['curl']);
			
	
        //opteniendo el cpatcha
        $get_endpoint = '/newcaptcha';
        $response =(perform_http_request('GET', REST_API_URL . $get_endpoint,[]));
        // var_dump($response);
        $this->session->remove('captchaword');
        $this->session->set('captchaword',$response->captcha);
        $data = [
            "captcha" => $response->image,
         ];
        return view('auth/login',$data);
    }
    public function getNewCaptcha() {
		    helper(['curl']);
        //opteniendo el cpatcha
        $get_endpoint = '/newcaptcha';
        $response =(perform_http_request('POST', REST_API_URL . $get_endpoint));
        
        $this->session->remove('captchaword');
        $this->session->set('captchaword',$response->captcha);
        $data=$response->image; 
        return $data;
    }
    public function validaCaptcha() {
        helper(['curl']);
        if($this->request->getPost('captcha') != $name = $this->session->captchaword)
        {
          $this->session->setFlashdata('error','<div class="alert alert-danger alert-dismissible fade show" role="alert">
          Captcha Incorrecto
           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">&times;</span>
           </button>
         </div>');
          return redirect()->to(base_url('/login'));
        }else{
          $get_endpoint = '/validaCaptcha';
          // $request_data = (array("username" => $this->request->getPost('username'), "password" => $this->request->getPost('pass')));
           $request_data = [
            'captcha' => $this->request->getPost('captcha')
          ];
           $response = perform_http_request('POST', REST_API_URL . $get_endpoint,$request_data );
          //  var_dump(("la respuesta"));
          //  var_dump(($response));
          if($response->msg == 1 ){
            $post_endpoint = '/login';
            $request_data = (array("username" => $this->request->getPost('username'), "password" => $this->request->getPost('pass')));
            $response = (perform_http_request('POST', REST_API_URL . $post_endpoint,$request_data));
          
            if(!$response->password){
               $newdata = [
                'user' => $response->user,
                'id' => $response->id,
                'logged_in' => true,
                'token' => $response->access_token,
      
              ];
          
              $this->session->set($newdata);
                if($response->change == 0 ){
                  
                  return redirect()->to(base_url('/change_pass'));
                }else{
                
                  return redirect()->to(base_url('/inicio'));
                }
               
            }else{
              $this->session->setFlashdata('error','<div class="alert alert-danger alert-dismissible fade show" role="alert">
              '.$response->password.'
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
             </div>');
              return redirect()->to(base_url('/login'));
            }
          }else{
            $this->session->setFlashdata('error','<div class="alert alert-danger alert-dismissible fade show" role="alert">
            '.$response->error.'
             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
             </button>
           </div>');
            return redirect()->to(base_url('/login'));
          }
          
        }
         
          //opteniendo el cpatcha
        
          // return view('auth/login',$data);
    }
    public function logout(){
      return redirect()->to(base_url('/login'));
    }
    public function updatePass(){
      helper(['curl']);
      

      if($this->request->getPost()){
           $post_endpoint = '/api/change_pass';
            $request_data = (array("passw" => $this->request->getPost('passw'),
               "repassw" => $this->request->getPost('repassw'),
               "id_us"=> $this->session->id)
              );
          
            $response = (perform_http_request('POST', REST_API_URL . $post_endpoint,$request_data));
            
            return redirect()->to(base_url('/login'));
            
      }else{
        return redirect()->to(base_url('/login'));
      }
    }
    public function change_pass(){
      return view('auth/change_pass');

    }
  
	
}
