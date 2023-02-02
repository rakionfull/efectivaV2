<?php

namespace App\Models;

use CodeIgniter\Model;

class Mvaloractivo extends Model
{

public function getValorActivo(){

    $query = $this->db->query("SELECT * FROM valor_activo");
    return $query->getResultArray();
}

public function getValorActivo2(){

    $query = $this->db->query("SELECT * FROM valor_activo");
    return $query->getResultArray();
}

public function saveValorActivo($data){       

    $query=$this->db->query("INSERT INTO valor_activo
    (valor,estado) VALUES
    ('{$data['valor']}',{$data['estado']})") ;

    return $query;
}
public function updateValorActivo($data){  
    
    $query=$this->db->query("UPDATE valor_activo SET 
    valor = '{$data['valor']}',
    estado = '{$data['estado']}'
    where id = {$data['id']} ") ;
       
    return $query;
}


}