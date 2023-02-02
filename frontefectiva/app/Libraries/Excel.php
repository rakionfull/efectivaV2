
<?php 

/*  
 * Clase para la exportación de resultados a excel  
 * @version 0.1 Primera version  
 */ 
require_once APPPATH ."/third_party/PHPExcel.php";   
class Excel extends PHPExcel {     
  public function __construct(){         
    parent::__construct();      
  } 
} 
?>