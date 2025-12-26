<?php
class BasundharApplicationModel extends CI_Model {
    
    // Constructor
    public function __construct() {
        parent::__construct();
        // Load database library
        $this->load->database();
    }

    // Get all Basundhar applications
    public function get_all_applications() {
        return $this->db->get('basundhar_application')->result();
    }

    // Get Basundhar application by ID
    public function get_application_no_by_case_no($case_no) {
        return $this->db->get_where('basundhar_application', array('dharitree' => $case_no))->row();
    }
    // Get Basundhar application by ID
    public function get_case_no_by_application_no($application_no) {
        return $this->db->get_where('basundhar_application', array('basundhara' => $application_no))->row();
    }

    // Insert a new Basundhar application
    public function insert($data) {
        return $this->db->insert('basundhar_application', $data);
        // return $this->db->insert_id();
    }

    // Update Basundhar application
    public function update($case_no=null, $application_no=null, $data) {

        if(empty($case_no) && empty($application_no)){
            return json_encode([
                'responseType' => 0,
                'msg'          => '#ERRJS38: Atleast one ID is required!'
            ]);
        }
        if(!empty($case_no))
        {
            $this->db->where('dharitree', $case_no);
        }
        if(!empty($case_no))
        {
            $this->db->where('basundhara', $application_no);
        }
        return $this->db->update('basundhar_application', $data);
    }

    // Delete Basundhar application
    public function delete($case_no=null, $application_no=null) {
        if(empty($case_no) && empty($application_no)){
            return json_encode([
                'responseType' => 0,
                'msg'          => '#ERRJS383: Atleast one ID is required!'
            ]);
        }
        if(!empty($case_no))
        {
            $this->db->where('dharitree', $case_no);
        }
        if(!empty($case_no))
        {
            $this->db->where('basundhara', $application_no);
        }
        return $this->db->delete('basundhar_application');
    }




    
}
