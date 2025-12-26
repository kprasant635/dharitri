<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UnstrikePattadar_model extends CI_Model {

    protected $table = 'rccms_land_unstriked_pattadars';

    // public function __construct()
    // {
    //     parent::__construct();
    // }



     public function insert($data){
        $tstatus =  $this->db->insert($this->table, $data);
     
        if ($tstatus != 1) {

            // echo "<pre>";
            // echo "POSTGRES ERROR:\n";
            // print_r($this->db->_error_message());
            // echo "\nERROR CODE:\n";
            // print_r($this->db->_error_number());
            // echo "\nLAST QUERY:\n";
            // print_r($this->db->last_query());
            // exit;
            // Rollback transaction
            $this->db->trans_rollback();

            // Log the error with the NEW CODE
            log_message(
                 "error",
                "#ERR_UNSTRIKE001: Error inserting into {$this->table}. SQL: " 
                . json_encode($this->db->last_query())
            );

            return [
                'result' => 'SERVER-ERROR',
                'msg' => 'Some error occurred, Error-Code : #ERRRCCMS002_Strike_Pattadar'
            ];
        }

      

        // Insert success
        return [
            'result' => 'SUCCESS',
            // 'insert_id' => $this->db->insert_id()
        ];
    }

   

    public function get_by_land($land_id)
    {
        return $this->db->where('land_id', $land_id)->get($this->table)->result();
    }
}
