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

        if(is_null($user)){
            return $this->respond(
                [
                    'error' => 'Usuario inválido',
                ],
                ResponseInterface::HTTP_UNAUTHORIZED // 401
            );
        }else{
            $pass_verify = veriPass($password, $user[0]['pass_cl']);
            if(!$pass_verify){
                return $this->respond(
                    [
                    'error' => 'Contraseña invalida',
                    ],
                    ResponseInterface::HTTP_UNAUTHORIZED
                );
            }else{
                if($user[0]['change_pass'] == 1){
                    return $this->respond(
                        [
                        'change' => 0,
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
                        'message' => 'Credenciales correctas',
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
            
                'msg' => 'Captcha Correcto',
               
            ];
            return $this->respond($response, ResponseInterface::HTTP_OK);
            // $this->session->set_flashdata('error',' <div class="alert alert-success alert-dismissible fade show" role="alert">
            //    Captcha Correcto
            //     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            //         <span aria-hidden="true">&times;</span>
            //     </button>
            // </div>');

            //  $usuario = $this->input->post('username');
            //  $password = $this->input->post('pass');
            //  //aqui encripto la clave
            //  $encript= trim(enc_dec("encrypt",$password));
           
            //  $datosUsuario = $this->musuarios->obtenerUsuario($usuario,$encript);
            
           
            // if (count($datosUsuario) > 0 ) {
            //     //validamos la fecha de expiracion
            //     $configuracion =  $this->mconfig_pass->getConfig_pass();
            //     $fecha_expiracion=date("Y-m-d H:i:s",strtotime($datosUsuario[0]->fecha_creacion."+ ".$configuracion[0]->duracion." days")); 
            //     //datos para la validacion de expiracion
            //     $tipo=2;
            //     $cod=random_string('numeric',6);
            //     $id=enc_dec("encrypt",$datosUsuario[0]->id_usuario."-".$tipo."-".$cod);
                  
            //     // $id=enc_dec("encrypt",$datosUsuario[0]->id_usuario);

            //     if(date("Y-m-d H:i:s")  <= $fecha_expiracion){
            //         // sitodo ok eliminamos los captachas con tiempode vida menor a 2 min
                   
            //         $data = [
            //             "usuario" => $datosUsuario[0]->usuario,
            //             "type" => $datosUsuario[0]->type,
            //             "nombre" => $datosUsuario[0]->nombres,
            //             "correo" => $datosUsuario[0]->correo,
            //         ];

            //         $this->session->unset_userdata('captchaword');
            //         $this->session->set_userdata($data);
            //         // $this->load->view('auth/verificacion',$data)
            //         $dato=$this->session->userdata('usuario');
                    
            //         redirect('verificacion',$dato);
            //         // print_r ($this->session->userdata('usuario'));
            //         //print_r("claves correctyas");
            //     }else{
            //         $this->session->set_flashdata('error','<div class="alert alert-danger alert-dismissible fade show" role="alert">
            //             Clave ha expirado, debe crear una nueva contraseña
            //             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            //                 <span aria-hidden="true">&times;</span>
            //             </button>
            //         </div>'); 
            //         redirect('change_pass/'.$id);
            //     }
               

            // } else {
            //     $this->session->set_flashdata('error','<div class="alert alert-danger alert-dismissible fade show" role="alert">
            //         Usuario o clave incorrectos
            //             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            //                 <span aria-hidden="true">&times;</span>
            //             </button>
            //         </div>'); 
            //     redirect('login');
            // }
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

