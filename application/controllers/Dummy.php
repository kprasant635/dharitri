
<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dummy extends CI_Controller {

   public function demo(){
	   $data = file_get_contents('data.jso');
	   
	   echo $data;
   }

}
