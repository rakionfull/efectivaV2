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
        //eliminanos los captcha con mas de 2 mintos de vida
        $Mcaptcha->deleteOldCaptcha($expiration);

        //comprobamos si es correcta la imagen introducida
        $last = $Mcaptcha->check($ip,$expiration,$captcha);

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
        // $rules = [
        //     'passw' => 'required|min_length[8]|validatePass[passw]',
        //     'repassw' => 'required|min_length[8]|validatePass[repassw]'
        // ];

        // $errors = [
        //     // 'username' => [
        //     //     'validateUser' => 'Usuario Incorrecto'
        //     // ],
        //     'passw' => [
        //         'required' => 'Debe ingresar Contraseña',     
        //         'min_length' => 'La clave debe tener como minimo 8 carácteres',  
        //         'validatePass' => 'La clave debe contener 1 May, 1 Min , 1 Núm y 1 Caract. especial',  
        
        //     ],
        //     'repassw' => [
        //         'required' => 'Debe confirmar Contraseña',     
        //         'min_length' => 'La clave debe tener como minimo 8 carácteres',  
        //         'validatePass' => 'La clave debe contener 1 May, 1 Min , 1 Núm y 1 Caract. especial',  
        
        //     ]
        // ];

        $input = $this->getRequestInput($this->request);
        // if (!$this->validateRequest($input, $rules, $errors)) {

        //     $error = [
        //         'error' => 'valida',
        //         'datos' => $this->validator->getErrors()
        //     ];
        //     return ($this->getResponse($error,ResponseInterface::HTTP_OK));
          
        // }
        // creo un helper de validacion de claves
        $resultado =  validacionPassword($input);
        if($resultado == 1){
                //guardo la nueva clave
            $userModel = new Muser();
            $datos = array(
                'pass_cl' => hashPass($input['passw']),
                'id_us' =>$input['id_us'],
            );
            $userModel->savePass($datos);
            $result=$userModel->changePass($input['id_us']);
            $response = [
                'dato' => $result,
            ];
        }else{
            $response = [
                'error' => $resultado,
            ];
        }
          
       
        // }else{
            
        //}
        
       
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

