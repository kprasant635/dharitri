<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Case_model extends CI_Model
{

    protected $table = 'rccms_cases';

    public function insert_case($data)
    {
        $tstatus = $this->db->insert('rccms_cases', $data);

        // If insert failed
        if ($tstatus != 1) {

            

            $this->db->trans_rollback();  // rollback transaction

            log_message(
                "error",
                "#ERRRCCMS001, Error inserting into rccms_cases. Query: " . json_encode($this->db->last_query())
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



    public function get_by_case_id($case_id)
    {
        // return $this->db->where('rccms_case_no', $case_id)->get($this->table)->row();

        if (!empty($case_id)) {
            $api_url = "https://129.154.254.176/rccms_stage_backend/v1/caseStatus/getApplication?applicationId=" . urlencode($case_id);
            //  $api_url = "http://10.177.48.246:8082/v1/caseStatus/getApplication?applicationId=" . urlencode($case_id);

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $api_url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'apiKey: RCCMS-DEMO',
                    'Accept: application/json'
                ),
                CURLOPT_SSL_VERIFYPEER => false, // Add this
                CURLOPT_SSL_VERIFYHOST => false  // Add this
            ));

            $response = curl_exec($curl);

            if ($response === false) {
              return  $data['api_response'] = null;
            } else {
              return  $data['api_response'] = json_decode($response, true);;
            }

            curl_close($curl);


        } else {
           return  $data['api_response'] = ['error' => 'Case number is required'];
        }



        // return $this->db->where('rccms_case_no', $case_id)->get($this->table)->row();
        // return $this->db->where('case_id', $case_id)->get($this->table)->row();
    }

    public function get_by_id($id)
    {
        return $this->db->where('id', $id)->get($this->table)->row();
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }

    public function list_all()
    {
        return $this->db->order_by('id', 'DESC')->get($this->table)->result();
    }
}
