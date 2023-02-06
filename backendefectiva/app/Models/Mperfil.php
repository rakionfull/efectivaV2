<?php

namespace App\Models;

use CodeIgniter\Model;

class Mperfil extends Model
{
  
    
    //retorna todos los perfiles
    public function getPerfiles($estado){
        $consulta = '';
        if($estado==-1){
            $consulta="SELECT * FROM  tb_perfiles";
        }else{
            $consulta ="SELECT * FROM  tb_perfiles where est_perfil={$estado}";
        }
        $query = $this->db->query($consulta);
        return $query->getResultArray();
    }
    //agregar el perfil
    public function savePerfil($data){
        // return $data;
        
        $actualizacion_perfil = date('Y-m-d H:i:s');
    

        $query=$this->db->query("INSERT INTO tb_perfiles
        (perfil,desc_perfil,est_perfil,creacion_perfil) VALUES
        ('{$data['perfil']}','{$data['desc_perfil']}',
        '{$data['est_perfil']}','{$creacion_perfil}'); ") ;
    
    
        return $query;
    }
    public function updatePerfil($data){
      
        $actualizacion_perfil = date('Y-m-d H:i:s');
        $query=$this->db->query("UPDATE tb_perfiles SET 
        perfil = '{$data['perfil']}',
        desc_perfil = '{$data['desc_perfil']}',
        est_perfil= '{$data['est_perfil']}',
        actualizacion_perfil='{$actualizacion_perfil}'
        where id_perfil = {$data['id_perfil']} ") ;
           
        return $query;
    }
    //detalle perfiles}
    public function getDetPerfil($id){

        $query = $this->db->query("SELECT * from tb_detalle_perfil as DP inner join tb_opcion as O on DP.id_op=O.id_op inner join tb_perfiles as P
        on DP.id_perfil=P.id_perfil inner join tb_modulo as M on O.id_mod=M.id_mod
         where P.id_perfil=$id" );
        return $query->getResultArray();
    }
    public function updateDetPer($data,$column){
      
        $query=$this->db->query("UPDATE tb_detalle_perfil SET 
        {$column} = {$data['estado']}
        where id_det_per = {$data['id_op']} ") ;
           
        return $query;
    }
}

