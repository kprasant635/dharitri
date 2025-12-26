<?php
class Bankmodel extends CI_Model {

    //function created for displaying the district name
    public function getDistrictName() {
			$db=  $this->session->userdata('db');
        $CI = &get_instance();

        $this->db2 = $CI->load->database('db2', TRUE) or die();
        $district = $this->db2->query("select district_name,district_code AS district from   district_details ");
        return $district->result();
    }
}
    ?>
