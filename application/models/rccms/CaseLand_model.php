<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CaseLand_model extends CI_Model
{

    protected $table = 'rccms_case_lands';

    public function insert($data)
    {
   
        $tstatus = $this->db->insert($this->table, $data);

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
                "#ERRRCCMS002_LAND, Error inserting into {$this->table}. Query: "
                . json_encode($this->db->last_query())
            );

            return [
                'result' => 'SERVER-ERROR',
                'msg' => 'Some error occurred, Error-Code : #ERRRCCMS002_LAND'
            ];
        }

        // Insert success
        return [
            'result' => 'SUCCESS',
            'insert_id' => $this->db->insert_id()
        ];

    }

    public function insert_batch($data)
    {
        $this->db->insert_batch($this->table, $data);
    }

    public function get_by_case($case_id)
    {
        return $this->db->where('case_id', $case_id)->get($this->table)->result();
    }

    public function delete_by_case($case_id)
    {
        return $this->db->delete($this->table, ['case_id' => $case_id]);
    }
}
