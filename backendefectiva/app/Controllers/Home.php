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
            'email_us' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[tb_users.email_us]',
            'usuario_us' => 'required|min_length[6]|max_length[50]|is_unique[tb_users.usuario_us]',
        ];

        $input = $this->getRequestInput($this->request);

        if (!$this->validateRequest($input, $rules)) {
            return $this->getResponse(
                    $this->validator->getErrors(),
                    ResponseInterface::HTTP_OK
                );
        }

        $model = new Muser();
        $result = $model->saveUser($input);
        $id=$model->lastid();
        $datos = array(
            'pass_cl' => hashPass($input['pass']),
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
}
