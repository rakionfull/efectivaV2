<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Muser;
use App\Models\Mcaptcha;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;
use App\Libraries\Capcha;
class Login extends BaseController
{
    use ResponseTrait;
 
    public function index()
    {
        //$userModel = model('UserModel');
        $userModel = new Muser();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $user = $userModel->getUser($username);
       
        if(!($user)){
            return $this->respond(
                [
                    'error' => 'Usuario inválido',
                    'msg' => 0,
                ],
                ResponseInterface::HTTP_UNAUTHORIZED // 401
            );
        }else{
            $pass_verify = veriPass($password, $user[0]['pass_cl']);
            if(!$pass_verify){
                return $this->respond(
                    [
                    'error' => 'Contraseña invalida',
                    'msg' => 0,
                    ],
                    ResponseInterface::HTTP_UNAUTHORIZED
                );
            }else{
                if($user[0]['change_pass'] == 1){
                    return $this->respond(
                        [
                        'change' => 0,
                        'msg' => 0,
                        'error' => 'cambio de clave',
                        ],
                        ResponseInterface::HTTP_UNAUTHORIZED
                    );
                }else{
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
                        'user' => $user[0]['usuario_us']
                    ];

                    $token = JWT::encode($payload, $key, 'HS256');
                    
                    $response = [
                        'msg' => 1,
                        'iat' => $iat,
                        'exp' => $exp,
                        'token' => $token,
                    ];

                    return $this->respond($response, ResponseInterface::HTTP_OK);
                }
                
            }
        }

       

    }
    public function newCaptcha(){
        
        $captcha = new Capcha();
        $Mcaptcha = new Mcaptcha();   
        $newCaptcha= $captcha->CreaCaptcha(180,50,120);
        $captchaword = $newCaptcha['word'];
        $query=$Mcaptcha->saveCaptcha($newCaptcha, $this->request->getIPAddress());
        $response = [
            'image' => $newCaptcha["image"],
            'captcha' => $newCaptcha["word"],
           
            
        ];
        return $this->respond($response, ResponseInterface::HTTP_OK);
    }
    public function validaCaptcha(){
        // funcion para validar el captcha 
        $Mcaptcha = new Mcaptcha();   
        $expiration = time() - 2*60; //limite de 2 minutos
        $ip = $this->request->getIPAddress(); //ip del usuario
        $captcha = $this->request->getVar('captcha'); //captcha introducido por el user

        //eliminanos los captcha con mas de 2 mintos de vida
        $Mcaptcha->deleteOldCaptcha($expiration);

        //comprobamos si es correcta la imagen introducida
        $last = $Mcaptcha->check($ip,$expiration,$captcha);
            
        //validacion del capcha
        if(count($last) == 1)
        {
            $response = [
                'msg' => 1  
            ];
            return $this->respond($response, ResponseInterface::HTTP_OK);
           
        }else{
            return $this->respond(
                [
                'error' => 'Captcha Expirado',
                ],
                ResponseInterface::HTTP_UNAUTHORIZED
            );
        }
       
       
    }
}

