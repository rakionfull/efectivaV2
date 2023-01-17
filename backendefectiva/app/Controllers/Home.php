<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Muser;
use App\Models\Mperfil;
use App\Models\Mcaptcha;
use App\Models\Mempresa;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Libraries\Capcha;
use Exception;
use ReflectionException;

class Home extends BaseController
{
    use ResponseTrait;
    public function index()
    {
        return view('welcome_message');
    }
    public function dashboard(){
        $response = [
            'msg' => 'Bienvenido a la aplicación de Efectiva',
        ];
        return $this->respond($response, ResponseInterface::HTTP_OK);

    }
    public function getUsers(){

        try {
            $model = new Muser();
                $response = [
                    'msg' => 'estos son los usuarios',
                    'datos' =>  $model->getUsers(),
                ];
                return $this->respond($response, ResponseInterface::HTTP_OK);
        
        } catch (Exception $ex) {
            return $this->getResponse(
                    [
                        'error' => $ex->getMessage(),
                    ],
                    ResponseInterface::HTTP_OK
                );
        }

           
    }
    public function getUser($id){

        try {
            $model = new Muser();
                $response = [
                    'msg' => 'estos son los usuarios',
                    'datos' =>  $model->getUserbyId($id),
                ];
                return $this->respond($response, ResponseInterface::HTTP_OK);
        
        } catch (Exception $ex) {
            return $this->getResponse(
                    [
                        'error' => $ex->getMessage(),
                    ],
                    ResponseInterface::HTTP_OK
                );
        }

           
    }
    public function addUser()
    {
        $rules = [
            'docident_us' => 'required|min_length[8]|max_length[8]|is_unique[tb_users.docident_us]',
            'nombres_us' => 'required|min_length[2]|max_length[50]',
            'apepat_us' => 'required|min_length[2]|max_length[50]',
            'apemat_us' => 'required|min_length[2]|max_length[50]',
            'email_us' => 'min_length[2]|max_length[50]|valid_email|is_unique[tb_users.email_us]',
            'usuario_us' => 'required|min_length[5]|max_length[50]|is_unique[tb_users.usuario_us]',
            'passw' => 'required|min_length[8]|validatePass[passw]',
        ];
        $errors = [
            'docident_us' => [
                'required' => 'Debe ingresar DNI',
                'is_unique' => 'El campo {field} debe ser único'
            ],
            'nombres_us' => [
                'required' => 'Debe ingresar Nombres',
              
            ],
            'apemat_us' => [
                'required' => 'Debe ingresar Apellido Paterno',
              
            ],
            
            'email_us' => [
                'required' => 'Debe ingresar Correo',
                'is_unique' => 'El campo {field} debe ser único'
            ],
            'usuario_us' => [
                'required' => 'Debe ingresar Usuario',
                'is_unique' => 'El campo {field} debe ser único'
            ],
            'passw' => [
                'required' => 'Debe ingresar Contraseña',     
                'min_length' => 'La clave debe tener como minimo 8 carácteres',  
                'validatePass' => 'La clave debe contener 1 May, 1 Min , 1 Núm y 1 Caract. especial',  
            ]
        ];
        
        $input = $this->getRequestInput($this->request);

        if (!$this->validateRequest($input, $rules, $errors)) {
            $error = [
                'error' => 'valida',
                'datos' => $this->validator->getErrors()
            ];
            return ($this->getResponse($error,ResponseInterface::HTTP_OK));
            // return $this->getResponse(
            //         $this->validator->getErrors(),
            //         ResponseInterface::HTTP_OK
            //     );
        }

        $model = new Muser();
        $result = $model->saveUser($input);
        $id=$model->lastid();
        $datos = array(
            'pass_cl' => hashPass($input['passw']),
            'id_us' =>$id,
        );
        $model->savePass($datos);
        return $this->getResponse(
            [
                'user' =>  $result
            ]
        );
      
        
    }
    public function updateUser($id)
    {
        // $rules = [
        //      ];

        $input = $this->getRequestInput($this->request);

        // if (!$this->validateRequest($input, $rules)) {
        //     return $this->getResponse(
        //             $this->validator->getErrors(),
        //             ResponseInterface::HTTP_OK
        //         );
        // }

        $model = new Muser();
        $result = $model->updateUser($input,$id);
       
        return $this->getResponse(
            [
                'user' =>  $result
            ]
        );
      
        
    }
    public function deleteUser($id){
        $model = new Muser();
        $result = $model->deleteUser($id);
       
        return $this->getResponse(
            [
                'user' =>  $result
            ]
        );
    }
    public function getPerfiles(){

        try {
            $model = new Mperfil();
                $response = [
                    'data' =>  $model->getPerfiles()
                ];
                return $this->respond($response, ResponseInterface::HTTP_OK);
        
        } catch (Exception $ex) {
            return $this->getResponse(
                    [
                        'error' => $ex->getMessage(),
                    ],
                    ResponseInterface::HTTP_OK
                );
        }

           
    }
    public function addPerfil()
    {
   
        
        $input = $this->getRequestInput($this->request);

      
        $model = new Mperfil();
        $result = $model->savePerfil($input);
    
        return $this->getResponse(
            [
                'msg' =>  $result
            ]
        );
      
        
    }
    public function updatePerfil()
    {
   
        
        $input = $this->getRequestInput($this->request);

      
        $model = new Mperfil();
        $result = $model->updatePerfil($input);
    
        return $this->getResponse(
            [
                'msg' =>  $result
            ]
        );
      
        
    }
    public function getDetPerfil($id){

        try {
            $model = new Mperfil();
                $response = [
                    'data' =>  $model->getDetPerfil($id)
                ];
                return $this->respond($response, ResponseInterface::HTTP_OK);
        
        } catch (Exception $ex) {
            return $this->getResponse(
                    [
                        'error' => $ex->getMessage(),
                    ],
                    ResponseInterface::HTTP_OK
                );
        }

           
    }
    public function updateView()
    {
   
        
        $input = $this->getRequestInput($this->request);

      
        $model = new Mperfil();
        $result = $model->updateDetPer($input,'view_det');
    
        return $this->getResponse(
            [
                'msg' =>  $result
            ]
        );
      
        
    }
    public function updateCreate()
    {
   
        
        $input = $this->getRequestInput($this->request);

      
        $model = new Mperfil();
        $result = $model->updateDetPer($input,'create_det');
    
        return $this->getResponse(
            [
                'msg' =>  $result
            ]
        );
      
        
    }
    public function updateUpdate()
    {
   
        
        $input = $this->getRequestInput($this->request);

      
        $model = new Mperfil();
        $result = $model->updateDetPer($input,'update_det');
    
        return $this->getResponse(
            [
                'msg' =>  $result
            ]
        );
      
        
    }
    public function updateDelete()
    {
   
        
        $input = $this->getRequestInput($this->request);

      
        $model = new Mperfil();
        $result = $model->updateDetPer($input,'delete_det');
    
        return $this->getResponse(
            [
                'msg' =>  $result
            ]
        );
      
        
    }
    public function getEmpresas(){

        try {
            $model = new Mempresa();
                $response = [
                    'data' =>  $model->getEmpresas()
                ];
                return $this->respond($response, ResponseInterface::HTTP_OK);
        
        } catch (Exception $ex) {
            return $this->getResponse(
                    [
                        'error' => $ex->getMessage(),
                    ],
                    ResponseInterface::HTTP_OK
                );
        }

           
    }
    public function addEmpresa()
    {
   
        
        $input = $this->getRequestInput($this->request);

      
        $model = new Mempresa();
        $result = $model->saveEmpresa($input);
    
        return $this->getResponse(
            [
                'msg' =>  $result
            ]
        );
      
        
    }
    public function updateEmpresa()
    {
   
        
        $input = $this->getRequestInput($this->request);

      
        $model = new Mempresa();
        $result = $model->updateEmpresa($input);
    
        return $this->getResponse(
            [
                'msg' =>  $result
            ]
        );
      
        
    }
}
