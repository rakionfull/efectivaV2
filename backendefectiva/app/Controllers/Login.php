<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Muser;
use App\Models\Mcaptcha;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Libraries\Capcha;
use Exception;
use ReflectionException;

class Login extends BaseController
{
    use ResponseTrait;
 
    public function index()
    {
       
        $rules = [
            'username' => 'required|min_length[3]|max_length[50]',
            'password' => 'required|min_length[6]|max_length[255]|validateUser[username, password]'
        ];

        $errors = [
            // 'username' => [
            //     'validateUser' => 'Usuario Incorrecto'
            // ],
            'password' => [
                'validateUser' => 'Credenciales Incorrectas'
            ]
        ];

        $input = $this->getRequestInput($this->request);


        if (!$this->validateRequest($input, $rules, $errors)) {
            return $this->getResponse(
                    $this->validator->getErrors(), ResponseInterface::HTTP_OK
                    // ResponseInterface::HTTP_BAD_REQUEST
                );
        }
      
        return $this->getJWTForUser($input["username"]);
       

    }
    public function newCaptcha(){
        
        $captcha = new Capcha();
        $Mcaptcha = new Mcaptcha();   
        $newCaptcha= $captcha->CreaCaptcha(180,50,180);
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
        $expiration = time() - 3*60; //limite de 2 minutos
        $ip = $this->request->getIPAddress(); //ip del usuario
        $captcha = $this->request->getVar('captcha'); //captcha introducido por el user
        //$captcha2 = $this->request->getServer('HTTP_AUTHORIZATION');
        //eliminanos los captcha con mas de 2 mintos de vida
        $Mcaptcha->deleteOldCaptcha($expiration);

        //comprobamos si es correcta la imagen introducida
        $last = $Mcaptcha->check($ip,$expiration,$captcha);
            // $response = [
            //     '0' => $captcha,
            //     '1' => $captcha2
            // ];
            // return $this->respond($response, ResponseInterface::HTTP_OK);
       // validacion del capcha
        if(count($last) == 1)
        {
            $response = [
                'msg' => 1  
            ];
            return $this->respond($response, ResponseInterface::HTTP_OK);
           
        }else{
            return $this->respond(
                [
                'msg' => 0, 
                'error' => 'Captcha Expirado',
                ],
                ResponseInterface::HTTP_OK
            );
        }
       
       
    }
    public function change_pass(){
        $rules = [
            'passw' => 'required|min_length[6]|max_length[255]',
            'repassw' => 'required|min_length[6]|max_length[255]'
        ];

        $errors = [
            // 'username' => [
            //     'validateUser' => 'Usuario Incorrecto'
            // ],
            'passw' => [
                'validateRePass' => 'No cumple con la cadena de caracteres'
            ]
        ];

        $input = $this->getRequestInput($this->request);


        if (!$this->validateRequest($input, $rules, $errors)) {
            return $this->getResponse(
                    $this->validator->getErrors(), ResponseInterface::HTTP_OK
                    // ResponseInterface::HTTP_BAD_REQUEST
                );
        }
       if($input['passw'] == $input['repassw']){
        //guardo la nueva clave
        $userModel = new Muser();
        $datos = array(
            'creacion_cl' => date('Y-m-d H:i:s'),
            'pass_cl' => hashPass($input['passw']),
            'expiracion_cl' => time() + (24*3600*45),
            'id_us' =>$input['id_us'],
        );
        $userModel->savePass($datos);
        $result=$userModel->changePass($input['id_us']);
        $response = [
            'msg' => 1,
            'dato' => $result,
        ];
       }else{
        //envio el error
        $response = [
            'msg' => 0,
            'error' => 'Contraseñas no coinciden',
        ];
       }
        // return $this->getJWTForUser($input["username"]);
        
        return $this->respond($response, ResponseInterface::HTTP_OK);
    }
    private function getJWTForUser(string $username,int $responseCode = ResponseInterface::HTTP_OK) 
    {
        try {
            $model = new Muser();
            $user = $model->getUser($username);
            unset($user->pass_cl);

            helper('jwt');
            $msg=1;
            if($user->change_pass == 0){
                $msg=0;
            }
            return $this->getResponse(
                    [
                        'password' => false,
                        'msg' => 1,
                        'change' => $msg,
                        'user' => $user->usuario_us,
                        'id' => $user->id_us,
                        'access_token' => getSignedJWTForUser($username)
                    ]
                );
        } catch (Exception $ex) {
            return $this->getResponse(
                    [
                        'error' => $ex->getMessage(),
                    ],
                    $responseCode
                );
        }
    }
}

