<?php

namespace App\Models;

use CodeIgniter\Model;

class Marea extends Model
{
  
    
    //retorna todos los perfiles
    public function getAreasEmpresa(){

        $query = $this->db->query("SELECT AE.id as id,AE.id_areas as id_areas
        ,AE.id_empresa as id_empresa,AE.estado as estado,E.empresa as empresa,
        A.area as area FROM areas_empresa as AE inner join
        areas as A on AE.id_areas=A.id inner join 
        empresa as E on AE.id_empresa=E.id ");
        return $query->getResultArray();
    }
    public function getAreasEmpresaById($id){

        $query = $this->db->query("SELECT AE.id as id,AE.id_areas as id_areas
        ,AE.id_empresa as id_empresa,AE.estado as estado,E.empresa as empresa,
        A.area as area FROM areas_empresa as AE inner join
        areas as A on AE.id_areas=A.id inner join 
        empresa as E on AE.id_empresa=E.id where AE.id_areas={$id}");
        return $query->getResultArray();
    }
    public function getAreas(){

        $query = $this->db->query("SELECT * FROM areas");
        return $query->getResultArray();
    }
    public function saveArea($data){
    
        $query=$this->db->query("INSERT INTO areas
        (area,estado) VALUES
        ('{$data['area']}',{$data['estado']})") ;
        return $query;
    }
    public function saveAreaEmpresa($data){
    
        $query=$this->db->query("INSERT INTO areas_empresa
        (id_areas,id_empresa,estado) VALUES
        ('{$data['area']}',{$data['empresa']},{$data['estado']})") ;
        return $query;
    }
    public function updateArea($data){
        $query=$this->db->query("UPDATE areas SET 
        area = '{$data['area']}',
        estado = '{$data['estado']}'
        where id = {$data['id']} ") ;
           
        return $query;
    }
    public function updateAreaEmpresa($data){
        $query=$this->db->query("UPDATE areas_empresa SET 
        id_areas = '{$data['area']}',
        id_empresa = '{$data['empresa']}',
        estado = '{$data['estado']}'
        where id = {$data['id']} ") ;
           
        return $query;
    }
}
