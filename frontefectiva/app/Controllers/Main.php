<?php

namespace App\Controllers;

class Main extends BaseController {
	
    public function index() {
        return view('main/inicio');
    }
    public function listUsers(){
        return view('accesos/listUsers');
  
      }
      public function configPass(){
        return view('accesos/configPass');
  
      }
	
}