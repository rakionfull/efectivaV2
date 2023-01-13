<?php

namespace App\Models;

use CodeIgniter\Model;

class Muser extends Model
{
  
    public function saveUser($data){
        // return $data;
        
        $creacion_us = date('Y-m-d H:i:s');
        $estado_us = '1';
        $change_pass = '0';

        $query=$this->db->query("INSERT INTO tb_users 
        (docident_us,nombres_us,apepat_us,apemat_us,email_us,
        usuario_us,creacion_us,estado_us,change_pass) VALUES
        ('{$data['docident_us']}','{$data['nombres_us']}',
        '{$data['apepat_us']}','{$data['apemat_us']}',
        '{$data['email_us']}','{$data['usuario_us']}',
        '{$creacion_us}','{$estado_us}','{$change_pass}'); ") ;
    
        // return $this->db->insert('users', $data);
        return $query;
    }
    public function lastid(){
        $maxID = $this->db->query('SELECT SCOPE_IDENTITY() as maxid FROM tb_users');
       // $maxID = $this->db->select("max(id_us) as maxid")->from($tb)->get()->row()->maxid;
        return $maxID->getRow()->maxid;
    }
    public function savePass($data){
        // return $data;
        $creacion_cl = date('Y-m-d H:i:s');
        $expiracion_cl = time() + (24*3600*45);
        $query=$this->db->query("INSERT INTO tb_historial_claves 
        (pass_cl,id_us,creacion_cl,expiracion_cl) VALUES
        ('{$data['pass_cl']}','{$data['id_us']}',
        '{$creacion_cl}','{$expiracion_cl}'); ") ;
    
    
        return $query;
    }
    public function getUser($username){

        $Usuario = $this->db->query("SELECT TOP 1 * FROM  tb_users as TU INNER JOIN tb_historial_claves AS TH
        on TU.id_us=TH.id_us WHERE TU.usuario_us= '{$username}' ORDER BY TH.id_cl DESC");
       
        return $Usuario->getRow();
    }
    public function getUserbyId($id){

        $Usuario = $this->db->query("SELECT TOP 1 * FROM  tb_users as TU INNER JOIN tb_historial_claves AS TH
        on TU.id_us=TH.id_us WHERE TU.id_us= '{$id}' ORDER BY TH.id_cl DESC");
       
        return $Usuario->getRow();
    }
    
   
    public function changePass($data){
        // return $data;
        $query=$this->db->query("UPDATE tb_users SET change_pass = 1 
        where id_us = $data") ;
            
        return $query;
    }
    //retorna todos los usuarios
    public function getUsers(){

        $Usuario = $this->db->query("SELECT * FROM  tb_users");
        return $Usuario->getResultArray();
    }
    //actualiza el usuario
    public function updateUser($data,$id){
      
        $actualizacion_us = date('Y-m-d H:i:s');
        $query=$this->db->query("UPDATE tb_users SET nombres_us = '{$data['nombres_us']}',
        apepat_us = '{$data['apepat_us']}',apemat_us= '{$data['apemat_us']}',
        email_us= '{$data['email_us']}' ,actualizacion_us='{$actualizacion_us}'
        where id_us = {$id} ") ;
           
        return $query;
    }
    public function deleteUser($id){
        $this->db->query("DELETE FROM tb_historial_claves
        where id_us = {$id} ") ;
        $query=$this->db->query("DELETE FROM tb_users
        where id_us = {$id} ") ;
        return $query;
    }
    public function findUser($username){

        $Usuario = $this->db->query("SELECT  * FROM  tb_users where usuario_us= '{$username}' ");
       
        return $Usuario->getRow();
    }
}

