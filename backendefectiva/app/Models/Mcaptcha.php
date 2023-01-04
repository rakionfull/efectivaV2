<?php

namespace App\Models;

use CodeIgniter\Model;

class Mcaptcha extends Model
{
   
    // public function saveCaptcha($data){
    //     // return $data;
    //     $query = $this->db->query("INSERT INTO users (email,password) VALUES ('{$data['email']}','{$data['password']}')") ;
    //     // return $this->db->insert('users', $data);
    //     return $query;
    // }
    //guardando el captcha creado
    public function saveCaptcha($cap,$ip)
    {
        // $data = array(
        //     'captcha_time' => $cap['time'],
        //     'ip_address' => $this->request->getIPAddress(),
        //     'word' => $cap['word']
        // );
        // $query = $this->db->insert_string('captcha',$data);
        // $this->db->query($query);
        $query = $this->db->query("INSERT INTO captcha (captcha_time,ip_address,word) VALUES ('{$cap['time']}','{$ip}','{$cap['word']}')") ;
        // return $this->db->insert('users', $data);
        return $query;
    }
    public function deleteOldCaptcha($experation)
    {
        //eliminamos los registros si el captcha_time es menos a la expiration
        $this->db->query("DELETE FROM captcha where captcha_time < {$experation}");
       
    }
    public function check($ip,$experation,$captcha)
    {
        //comprobamos si existe el registro con los datos
        //enviamos desde el formulario
      // $query= $this->db->query("SELECT * FROM captcha WHERE word='{$captcha}' and ip_address='{$ip}' and captcha_time > {$experation} ");
        //devolvem,os el numero de files que conciden
        $query = $this->db->table('captcha');
        $query->where('word',$captcha);
        $query->where('ip_address',$ip);
        $query->where('captcha_time >',$experation);
        return $query->get()->getResultArray();
        
        // return $query->get()->num_rows();
    }
}
