<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class FileUpload_model extends CI_Model {
    public function upload_file($file_field, $case_no) {
        if (empty($_FILES[$file_field]['name'])) {
            return ['status' => false, 'error' => 'No file selected!'];
        }
        $upload_path   = UPLOAD_BASE.'CASES_FILES/'.str_replace("/", "-",$case_no);
        if (is_dir($upload_path) === false || !file_exists($upload_path)){
            mkdir($upload_path, 0777, true);
        }
        $config = [
            'upload_path'   => $upload_path,
            'allowed_types' => 'pdf|jpg|jpeg|png',
            'max_size'      => '2048', // 2MB limit
            'encrypt_name'  => TRUE, // Random file name for security
        ];
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($file_field)) {
            return ['status' => false, 'error' => $this->upload->display_errors()];
        } else {
            return ['status' => true, 'data' => $this->upload->data()];
        }
    }
    function save_notice($content,$case_no){
        $upload_path   = UPLOAD_BASE.'/CASES_FILES/'.str_replace("/", "-",$case_no); 
        if (is_dir($upload_path) === false){
            mkdir($upload_path);
        }
        $timestamp = date('Ymd_His'); 
        $random_string = substr(md5(time()), 0, 6); // Random hash for uniqueness
        $file_name = "notice_{$timestamp}_{$random_string}.html";
        log_message('error',"FILE SAVED".$case_no);
        $file_path = $upload_path."/".$file_name;
        if (file_put_contents($file_path, $content)) return true;
        else return false;
    }
}