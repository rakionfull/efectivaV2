<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;
use App\Libraries\Capcha;
class Login extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        //$userModel = model('UserModel');
        $userModel = new UserModel();
        $email = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $user = $userModel->getUser($email);

        // $user = $userModel->where('email', $email)->first();

        if(is_null($user)){
            return $this->respond(
                [
                    'error' => 'Correo electrónico invalido',
                ],
                ResponseInterface::HTTP_UNAUTHORIZED // 401
            );
        }

        // $pass_verify = password_verify($password, $user['password']);
        // Helper Tools
        $pass_verify = veriPass($password, $user[0]['password']);
        if(!$pass_verify){
            return $this->respond(
                [
                'error' => 'Contraseña invalida',
                ],
                ResponseInterface::HTTP_UNAUTHORIZED
            );
        }

        // Generación de token con JWT
        $key =  JWT_SECRET;
        // $key = getenv('JWT_SECRET');
        $iat = time();
        $exp = $iat + 3600;

        $payload = [
            // 'iss' => '',
            // 'aud' => '',
            'iat' => $iat,
            'exp' => $exp,
            'email' => $user[0]['email']
        ];

       $token = JWT::encode($payload, $key, 'HS256');
        
        $response = [
            'message' => 'Credenciales correctas',
            'iat' => $iat,
            'exp' => $exp,
            'token' => $token,
        ];

        return $this->respond($response, ResponseInterface::HTTP_OK);

    }
    public function newCaptcha(){
        $captcha = new Capcha();
        $newCaptcha= $captcha->CreaCaptcha(180,50,60);
       
        $response = [
            'image' => $newCaptcha["image"],
        ];
        return $this->respond($response, ResponseInterface::HTTP_OK);
    }
}

