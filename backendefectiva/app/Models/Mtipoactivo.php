<?php

namespace App\Models;

use CodeIgniter\Model;

class Mtipoactivo extends Model
{

public function getTipoActivo(){

    $query = $this->db->query("SELECT * FROM tipo_activo");
    return $query->getResultArray();
}
public function saveTipoActivo($data){       

    $query=$this->db->query("INSERT INTO tipo_activo
    (tipo,estado) VALUES
    ('{$data['tipo']}',{$data['estado']})") ;
    return $query;
}
public function updateTipoActivo($data){  
    
    $query=$this->db->query("UPDATE tipo_activo SET 
    tipo = '{$data['tipo']}',
    estado = '{$data['estado']}'
    where id = {$data['id']} ") ;    
    return $query;
}


}