<?php

if(!function_exists('hashPass')){
  function hashPass($password){
    return password_hash($password, PASSWORD_DEFAULT);
  }
}

if(!function_exists('veriPass')){
  function veriPass($passPost, $passDB){
    return password_verify($passPost, $passDB);
  }
}
if(!function_exists('validacionPassword')){
  function validacionPassword($data){
      if (empty($data["passw"]) && empty($data["repassw"]))
      {
        
        return "Los campos son obligatorios";
      }
      if (strlen($data["passw"]) < 8 && strlen($data["repassw"]) < 8)
      {
    
        return "Las claves deben tener un minimo de 8 caracteres";
      }
      if(!($data["passw"] == $data["repassw"])){
        return "Las contraseñas no coinciden";
      }
      $password = trim($data['passw']);

      $regex_lowercase = '/[a-z]/';
      $regex_uppercase = '/[A-Z]/';
      $regex_number = '/[0-9]/';
      $regex_special = '/[!@#$%^&*()\-_=+{};:,<.>ยง~]/';

    
      if (preg_match_all($regex_lowercase, $password) < 1)
			{
				
        return "La clave debe contener 1 May, 1 Min , 1 Núm y 1 Caract. especial";
			}
	
			if (preg_match_all($regex_uppercase, $password) < 1)
			{
				
				return "La clave debe contener 1 May, 1 Min , 1 Núm y 1 Caract. especial";
			}
	
		
		
		    if (preg_match_all($regex_number, $password) < 1)
			{
				
				return "La clave debe contener 1 May, 1 Min , 1 Núm y 1 Caract. especial";
			}
		
		
			if (preg_match_all($regex_special, $password) < 1)
			{
			
				return "La clave debe contener 1 May, 1 Min , 1 Núm y 1 Caract. especial";
			}
    
    return 1;
  }
}