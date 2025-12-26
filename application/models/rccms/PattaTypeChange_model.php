<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PattaTypeChange_model extends CI_Model {

    protected $table = 'rccms_land_patta_type_change';

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
                "#ERRRCCMS002_Patta_type_change, Error inserting into {$this->table}. Query: "
                . json_encode($this->db->last_query())
            );

            return [
                'result' => 'SERVER-ERROR',
                'msg' => 'Some error occurred, Error-Code : #ERRRCCMS002_Patta_type_change'
            ];
        }

        // Insert success
        return [
            'result' => 'SUCCESS',
            // 'insert_id' => $this->db->insert_id()
        ];
    }

    public function get_by_land($land_id){
        return $this->db->where('land_id', $land_id)->get($this->table)->row();
    }

    public function delete_by_land($land_id){
        return $this->db->delete($this->table, ['land_id' => $land_id]);
    }
}
