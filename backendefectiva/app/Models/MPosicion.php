<?php

namespace App\Models;

use CodeIgniter\Model;

class MPosicion extends Model
{
    public function validaPosicion($data){
        
            $query = $this->db->query("SELECT * FROM posicion_puesto where posicion_puesto='{$data['posicion']}'
            and idempresa={$data['idempresa']} and idarea={$data['idarea']} and idunidad={$data['idunidad']}");
            $query->getRow();
            if( $query->getRow()) return true;
            else return false;
    }
    public function getPosicionByActivo(){

        $query = $this->db->query("SELECT * FROM posicion_puesto where estado='1'");
        return $query->getResultArray();
    }
    public function getPosicion(){

        $query = $this->db->query("SELECT PP.id as id_pos,PP.posicion_puesto,PP.idempresa,PP.idunidad,PP.idarea,
        E.empresa,A.area,U.unidad,PP.estado FROM posicion_puesto as PP inner join empresa as E
        on PP.idempresa=E.id inner join area as A on PP.idarea=A.id 
        inner join unidades as U on PP.idunidad=U.id");
        return $query->getResultArray();
    }

    
    public function savePosicion($data){       

        $query=$this->db->query("INSERT INTO posicion_puesto
        (posicion_puesto,idempresa,idarea,idunidad,estado) VALUES
        ('{$data['posicion']}',{$data['idempresa']},{$data['idarea']},{$data['idunidad']},{$data['estado']})") ;

        return $query;
    }
    public function updatePosicion($data){  
        
        $query=$this->db->query("UPDATE posicion_puesto SET 
        posicion_puesto = '{$data['posicion']}',
        idempresa = '{$data['idempresa']}',
        idarea = '{$data['idarea']}',
        idunidad = '{$data['idunidad']}',  estado = '{$data['estado']}'
        where id = {$data['id']} ") ;
        
        return $query;
    }
    public function deletePosicion($data){
        
            
        $query=$this->db->query("DELETE posicion_puesto 
        where id = {$data} ") ;
        
        return $query;
    }


}