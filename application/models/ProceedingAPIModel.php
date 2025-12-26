<?php
class ProceedingAPIModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function getTableData()
    {
        $this->db->select('
            petition_proceeding.*, 
            petition_proceeding_dc_adc.*
        ', FALSE);

        $this->db->from('petition_proceeding');
        $this->db->join('petition_proceeding_dc_adc', 'petition_proceeding.case_no = petition_proceeding_dc_adc.case_no', 'inner');
        $this->db->where('petition_proceeding.case_no IS NOT NULL');
        $this->db->order_by('petition_proceeding.date_entry', 'DESC');
        $this->db->limit(5);

        $query = $this->db->get();

        // Debugging: Log executed query
        error_log("Executed Query: " . $this->db->last_query());

        // Error Handling
        if (!$query) {
            $error = $this->db->error(); // Get error details
            error_log("SQL Error: " . json_encode($error));
            return ["error" => "Query execution failed!", "sql_error" => $error];
        }

        $results = $query->result();

        // Debugging: Log fetched results
        error_log("Fetched Results: " . json_encode($results));

        // Ensure `user_code` field exists and rename accordingly
        foreach ($results as &$row) {
            if (!isset($row->user_code) || empty($row->user_code)) {
                $row->user_code_renamed = "Unknown";
            } else {
                if (stripos($row->user_code, 'CO') !== false) {
                    $row->user_code_renamed = "Forwarded by CO";
                } elseif (stripos($row->user_code, 'ADC') !== false) {
                    $row->user_code_renamed = "Forwarded by ADC";
                } elseif (stripos($row->user_code, 'DC') !== false) {
                    $row->user_code_renamed = "Forwarded by DC";
                } elseif (stripos($row->user_code, 'LRA') !== false) {
                    $row->user_code_renamed = "Forwarded by LRA";
                } elseif (stripos($row->user_code, 'LRS') !== false) {
                    $row->user_code_renamed = "Forwarded by LRS";
                } elseif (stripos($row->user_code, 'AST') !== false) {
                    $row->user_code_renamed = "Forwarded by AST";
                } else {
                    $row->user_code_renamed = "Unknown";
                }
            }
        }

        return $results;
    }

    public function getApplicationWithQuery($dab, $application_no) {
        $application_no = 'RTPS/APPP/2024/755';
        $dab = $this->load->database('rtpsmb_nc', TRUE);
        
        // Fetch application details
        $dab->select('*');
        $dab->from('applications');
        $dab->where('applications.application_no', $application_no);
        $query = $dab->get();
        
        // Error Handling
        if (!$query) {
            $error = $dab->error(); // Get error details
            error_log("SQL Error: " . json_encode($error));
            return ["error" => "Query execution failed!", "sql_error" => $error];
        }
        
        $results = $query->result();
        
        // Check if data exists
        if (empty($results)) {
            return ["error" => "No application found with the given application number."];
        }

        if($results[0]->status == 'Q'){
         $query_sent = 'Y';
        }
        
        // Extract application_id
        $application_id = $results[0]->id;



        // Query application_query table using application_id
        $dab->select('*');
        $dab->from('application_query');
        $dab->where('application_id', $application_id);
        $query2 = $dab->get();
        
        // Error Handling
        if (!$query2) {
            $error = $dab->error();
            error_log("SQL Error: " . json_encode($error));
            return ["error" => "Query execution failed!", "sql_error" => $error];
        }
        
        $application_queries = $query2->result();
        
        // Return final result
        return [
            "query_sent" => $query_sent,
            "application_queries" => $application_queries
        ];
        
    }
    
    
}
