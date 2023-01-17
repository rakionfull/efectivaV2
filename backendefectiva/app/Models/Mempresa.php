<?php

namespace App\Models;

use CodeIgniter\Model;

class Mempresa extends Model
{
  
    
    //retorna todos los perfiles
    public function getEmpresas(){

        $query = $this->db->query("SELECT * FROM empresa");
        return $query->getResultArray();
    }
    public function saveEmpresa($data){
       

        $query=$this->db->query("INSERT INTO empresa
        (empresa,estado) VALUES
        ('{$data['empresa']}',{$data['estado']})") ;
    
    
        return $query;
    }
    public function updateEmpresa($data){
      
        
        $query=$this->db->query("UPDATE empresa SET 
        empresa = '{$data['empresa']}',
        estado = '{$data['estado']}'
        where id = {$data['id']} ") ;
           
        return $query;
    }
}
