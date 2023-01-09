<?php

namespace App\Models;

use CodeIgniter\Model;

class Muser extends Model
{
  
    public function saveUser($data){
        // return $data;
        $query=$this->db->query("INSERT INTO tb_users 
        (docident_us,nombres_us,apepat_us,apemat_us,email_us,
        usuario_us,creacion_us,estado_us,change_pass) VALUES
        ('{$data['docident_us']}','{$data['nombres_us']}',
        '{$data['apepat_us']}','{$data['apemat_us']}',
        '{$data['email_us']}','{$data['usuario_us']}',
        '{$data['creacion_us']}','{$data['estado_us']}','{$data['change_pass']}'); ") ;
    
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
        $query=$this->db->query("INSERT INTO tb_historial_claves 
        (pass_cl,id_us,creacion_cl,expiracion_cl) VALUES
        ('{$data['pass_cl']}','{$data['id_us']}',
        '{$data['creacion_cl']}','{$data['expiracion_cl']}'); ") ;
    
    
        return $query;
    }
    public function getUser($username){

        $Usuario = $this->db->query("SELECT TOP 1 * FROM  tb_users as TU INNER JOIN tb_historial_claves AS TH
        on TU.id_us=TH.id_us WHERE TU.usuario_us= '{$username}' ORDER BY TH.id_cl DESC");
       
        return $Usuario->getRow();
    }
    // public function findUserByEmailAddress(string $emailAddress)
    // {
    //     $Usuario = $this->db->table('tb_users');
    //     $Usuario->where('email_us',$emailAddress);
    //     $Usuario->get()->getResultArray();
    //     // $Usuario->first();
    //     // $user = $this
    //     //     ->asArray()
    //     //     ->where(['email' => $emailAddress])
    //     //     ->first();

    //     if (!$Usuario) 
    //         throw new Exception('User does not exist for specified email address');

    //     return $Usuario;
    // }
   
    public function changePass($data){
        // return $data;
        $query=$this->db->query("UPDATE tb_users SET change_pass = 1 
        where id_us = $data") ;
            
        return $query;
    }
}

