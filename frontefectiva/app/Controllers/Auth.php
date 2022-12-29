<?php

namespace App\Controllers;

class Auth extends BaseController {
	
    public function index() {
		helper(['curl']);
			
		// $rest_api_base_url = 'http://localhost:8080';
        //POST - respuesta del logeo
        // $get_endpoint = '/login';
        // $request_data = (array("email" => "mpantac@unprg.edu.pe", "password" => "12345678"));
        // $response = perform_http_request('POST', $rest_api_base_url . $get_endpoint,$request_data);
       
       // $data['response'] = $response;
        //opteniendo el cpatcha
        $get_endpoint = '/newcaptcha';
        $response =json_decode(perform_http_request('POST', REST_API_URL . $get_endpoint));
       
        $data = [
            "captcha" => $response->image,
         ];
        return view('auth/login',$data);
    }
    public function getNewCaptcha() {
		helper(['curl']);
			
        //opteniendo el cpatcha
        $get_endpoint = '/newcaptcha';
        $response =json_decode(perform_http_request('POST', REST_API_URL . $get_endpoint));
         $data=$response->image;
        
       return $data;
    }
    public function validaCaptcha() {
        helper(['curl']);
          $get_endpoint = '/login';
          $request_data = (array("username" => $this->request->getPost('username'), "password" => $this->request->getPost('pass')));
          $response = perform_http_request('POST', REST_API_URL . $get_endpoint,$request_data);
         
         var_dump($response);
          //opteniendo el cpatcha
        
          // return view('auth/login',$data);
      }
	
}
