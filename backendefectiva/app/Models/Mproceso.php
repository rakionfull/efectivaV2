<?php

namespace App\Models;

use CodeIgniter\Model;

class Mproceso extends Model
{
  
    public function validaProceso($data){
        
        $query = $this->db->query("SELECT * FROM procesos where  proceso='{$data['proceso']}' 
        and idempresa='{$data['idempresa']}' and  idarea='{$data['idarea']}' and  idunidad='{$data['idunidad']}'
        and  idmacroproceso='{$data['idmacroproceso']}'");
        $query->getRow();
        if( $query->getRow()) return true;
        else return false;
    }
    //retorna todos Proceso
    public function getProceso(){

        $query = $this->db->query("SELECT P.id,P.proceso,E.empresa,A.area,U.unidad,m.macroproceso,P.estado,
        P.idempresa,P.idarea,P.idunidad,P.idmacroproceso
        from procesos as P inner join empresa as E on P.idempresa=e.id
                                inner join area as A on P.idarea=A.id
                                inner join unidades as U on P.idunidad=U.id												   
                                inner join macroprocesos as M on P.idmacroproceso = M.id");
        return $query->getResultArray();
    }
    
    public function getProcesoByActivo(){

        $query = $this->db->query("SELECT * FROM procesos where estado='1'");
        return $query->getResultArray();
    }
    
    public function saveProceso($data){
       

        $query=$this->db->query("INSERT INTO procesos
        (proceso,estado,idempresa,idarea,idunidad,idmacroproceso) VALUES
        ('{$data['proceso']}',{$data['estado']},{$data['idempresa']},{$data['idarea']},
        {$data['idunidad']},{$data['idmacroproceso']})") ;
    
    
        return $query;
    }
    public function updateProceso($data){
      
        
        $query=$this->db->query("UPDATE procesos SET 
        proceso = '{$data['proceso']}',
        estado = '{$data['estado']}'
        where id = {$data['id']} ") ;
           
        return $query;
    }

    public function deleteProceso(){
    
        $query = $this->db->query("DELETE from procesos where id = {$data} ");
        return $query->getResultArray();
    }
}
