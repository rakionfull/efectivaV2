<?php

namespace App\Validation;

use App\Models\Muser;
use Exception;

class UserRules
{
 
    public function validateUser(string $str, string $fields, array $data): bool
    {
        try {
            $model = new Muser();
            $user = $model->getUser($data['username']);
          
            return password_verify($data['password'], $user->pass_cl);
        } catch (Exception $ex) {
            return false;
        }
    }
   
}