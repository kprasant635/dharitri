<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Log_model extends CI_Model {
    private $log_path;
    public function __construct() {
        parent::__construct();
        $this->log_path = APPPATH . 'logs/custom_log_' . date('Y-m-d') . '.log'; 
        // $this->log_path = APPPATH . 'logs/custom_log_' . date('Y-m-d') . '.log'; 
    }
    public function write_log($level = 'query',$method, $message) {
        if($method=='MUT'){
            $this->log_path = APPPATH . 'logs/MUTATION_' . date('Y-m-d') . '.log';
        }
        else if($method=='PART'){
            $this->log_path = APPPATH . 'logs/PART_' . date('Y-m-d') . '.log';
        }
        else{
            $this->log_path = APPPATH . 'logs/custom_log_' . date('Y-m-d') . '.log';
        }
        $log_message = "[" . date('Y-m-d H:i:s') . "] [$level] $message" . PHP_EOL;
        file_put_contents($this->log_path, $log_message, FILE_APPEND);
    }
}
?>