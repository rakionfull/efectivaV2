<?php

namespace App\Models;

use CodeIgniter\Model;

class Mmacroprocesos extends Model
{
    public function validaMacroproceso($data){
        
        $query = $this->db->query("SELECT * FROM macroprocesos where  macroproceso='{$data['macroproceso']}' 
        and idempresa='{$data['idempresa']}' and  idarea='{$data['idarea']}' and  idunidad='{$data['idunidad']}'");
        $query->getRow();
        if( $query->getRow()) return true;
        else return false;
    }
    
    //retorna todos MacroProcesos
    public function getMacroproceso(){

        $query = $this->db->query("SELECT M.id, m.macroproceso,E.empresa,A.area,U.unidad,M.estado,M.idempresa,
        M.idarea,M.idunidad
        from macroprocesos as M inner join empresa as E on M.idempresa=e.id
                                inner join area as A on M.idarea=A.id
                                inner join unidades as U on M.idunidad=U.id");
        return $query->getResultArray();
    }
   
    public function saveMacroproceso($data){
       

        $query=$this->db->query("INSERT INTO macroprocesos (macroproceso,estado,idempresa,idarea,idunidad) values
        ('{$data['macroproceso']}', '{$data['estado']}', '{$data['idempresa']}','{$data['idarea']}','{$data['idunidad']}')") ;
    
    
        return $query;
    }
    public function updateMacroproceso($data){
      
        
        $query=$this->db->query("UPDATE macroprocesos SET 
        macroproceso = '{$data['macroproceso']}',
        estado = '{$data['estado']}'
        where id = {$data['id']} ") ;
           
        return $query;
    }

    public function getMacroprocesoByActivo(){

        $query = $this->db->query("SELECT * from macroprocesos where estado = '1'");
        return $query->getResultArray();
    }
    
    public function deleteMacroproceso($data){
    
        $query = $this->db->query("DELETE from macroprocesos where id = {$data} ");
        return $query;
    }
}
