<?php

namespace App\Controllers;

class Auth extends BaseController {
	
    public function index() {
        $session = session();
		    helper(['curl']);
			
	
        //opteniendo el cpatcha
        $get_endpoint = '/newcaptcha';
        $response =json_decode(perform_http_request('POST', REST_API_URL . $get_endpoint));
        $session->remove('captchaword');
        $session->set('captchaword',$response->captcha);
        $data = [
            "captcha" => $response->image,
         ];
        return view('auth/login',$data);
    }
    public function getNewCaptcha() {
		    helper(['curl']);
        $session = session();
        //opteniendo el cpatcha
        $get_endpoint = '/newcaptcha';
        $response =json_decode(perform_http_request('POST', REST_API_URL . $get_endpoint));
        $session->remove('captchaword');
        $session->set('captchaword',$response->captcha);
        $data=$response->image; 
        return $data;
    }
    public function validaCaptcha() {
        $session = session();
        helper(['curl']);
        if($this->request->getPost('captcha') != $name = $session->captchaword)
        {
          $session->setFlashdata('error','<div class="alert alert-danger alert-dismissible fade show" role="alert">
          Captcha Incorrecto
           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">&times;</span>
           </button>
         </div>');
          return redirect()->to(base_url('/login'));
        }else{
          $get_endpoint = '/validaCaptcha';
          // $request_data = (array("username" => $this->request->getPost('username'), "password" => $this->request->getPost('pass')));
           $request_data = (array("captcha" => $this->request->getPost('captcha')));
           $response = json_decode(perform_http_request('POST', REST_API_URL . $get_endpoint,$request_data));
          
          if($response->msg == 1 ){
            $post_endpoint = '/login';
            $request_data = (array("username" => $this->request->getPost('username'), "password" => $this->request->getPost('pass')));
            $response = json_decode(perform_http_request('POST', REST_API_URL . $post_endpoint,$request_data));
           
            if($response->msg == 1){
                return redirect()->to(base_url('/inicio'));
            }else{
              $session->setFlashdata('error','<div class="alert alert-danger alert-dismissible fade show" role="alert">
              '.$response->error.'
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
             </div>');
              return redirect()->to(base_url('/login'));
            }
          }else{
            $session->setFlashdata('error','<div class="alert alert-danger alert-dismissible fade show" role="alert">
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
	
}
