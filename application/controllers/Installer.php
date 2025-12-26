<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Installer extends CI_Controller {

    public function index() {
        if($_SERVER['REQUEST_METHOD']==='POST'){
            
            $folderName  = $this->input->post('folder');
            $host  = $this->input->post('ip');

            $file = $folderName."/application/views/js/ajax.js";
            $lines = file( $file ); 
            $folder = explode("\\", $folderName);
        
            $url  ="\twindow.baseurl = \"http://$host/".$folder[sizeof($folder)-1]."/index.php\";\n";
            $lines[62] = $url;
            
            file_put_contents("C:\\ajax.js", $lines);

            $file = $folderName."/application/views/js/dharitreecore.js";
            $lines = file( $file );  
            
            $lines[8] = "\twindow.baseurl = \"http://$host/".$folder[sizeof($folder)-1]."/index.php\";\n";
            file_put_contents("C:\\dharitreecore.js", $lines);

            $file = $folderName."/application/config/config.php";
            $lines = file( $file );  
            var_dump($lines[18]);
            
            //file_put_contents("C:\\config.php", $lines);
            
        }else{
            $this->load->view('../views/header.php');
            $this->load->view('Installer/index.php');
            $this->load->view('../views/footer.php');    
        }
        
    }

}
