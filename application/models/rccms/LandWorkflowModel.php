<?php defined('BASEPATH') OR exit('No direct script access allowed');

class LandWorkflowModel extends CI_Model
{

    private $table = 'rccms_land_workflow';





    public function insertWorkflow($data)
    { 
            $tstatus = $this->db->insert('rccms_land_workflow', $data);

            // If insert failed
            if ($tstatus != 1) {



                $this->db->trans_rollback();  // rollback transaction

                log_message(
                    "error",
                    "#ERRRCCMS001, Error inserting into rccms_cases_workFlow. Query: " . json_encode($this->db->last_query())
                );

                return [
                    'result' => 'SERVER-ERROR',
                    'msg' => 'Some error occurred, Error-Code : #ERRRCCMS001'
                ];
            }

            // Insert succeeded → return insert ID if needed
            return [
                'result' => 'SUCCESS',
                'insert_id' => $this->db->insert_id()  // will work only if sl is SERIAL/IDENTITY
            ];
        
    }

}
