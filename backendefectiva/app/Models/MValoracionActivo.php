<?php

namespace App\Models;

use CodeIgniter\Model;

class MValoracionActivo extends Model
{
    public function validarValActivo($data){
        
            $query = $this->db->query("SELECT * FROM valoracion_activo where idaspecto1='{$data['id_aspecto1']}'
            and idaspecto2={$data['id_aspecto2']} and idaspecto3={$data['id_aspecto3']} and idvalor={$data['id_valor_val']}
            and valoracion1='{$data['nom_val1']}' and valoracion2='{$data['nom_val2']}' and valoracion3='{$data['nom_val3']}'");
            $query->getRow();
            if( $query->getRow()) return true;
            else return false;
    }
    public function getValActivo(){

        $query = $this->db->query("SELECT VA.id as id_valActivo,(select aspecto from aspectos_seguridad where id=VA.idaspecto1) as aspecto1,
        (select aspecto from aspectos_seguridad where id=VA.idaspecto2) as aspecto2, 
        (select aspecto from aspectos_seguridad where id=VA.idaspecto3) as aspecto3,VA.idaspecto1,VA.idaspecto2
        ,VA.idaspecto3,VA.estado,A.valor,VA.idvalor ,VA.valoracion1,VA.valoracion2,VA.valoracion3
        FROM valoracion_activo  as VA inner join valor_activo as A on VA.idvalor=A.id");
        return $query->getResultArray();
    }

    
    public function saveValActivo($data){       

        $query=$this->db->query("INSERT INTO valoracion_activo
        (idaspecto1,idaspecto2,idaspecto3,valoracion1,valoracion2,valoracion3,idvalor,estado) VALUES
        ('{$data['id_aspecto1']}',{$data['id_aspecto2']},{$data['id_aspecto3']},
        '{$data['nom_val1']}','{$data['nom_val2']}','{$data['nom_val3']}','{$data['id_valor_val']}',1)") ;

        return $query;
    }
    public function updateValActivo($data){  
        
        $query=$this->db->query("UPDATE valoracion_activo SET 
        idaspecto1 = '{$data['id_aspecto1']}', idaspecto2 = '{$data['id_aspecto2']}', idaspecto3 = '{$data['id_aspecto3']}',
        valoracion1 = '{$data['nom_val1']}', valoracion2 = '{$data['nom_val2']}', valoracion3 = '{$data['nom_val3']}',
        idvalor = '{$data['id_valor_val']}'
        where id = {$data['id']} ") ;
        
        return $query;
    }
    public function deleteValActivo($data){
        
            
        $query=$this->db->query("DELETE valoracion_activo 
        where id = {$data} ") ;
        
        return $query;
    }


}