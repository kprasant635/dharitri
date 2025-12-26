<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * @property LandClassUpdateModel $landclassupdatemodel
 */
 
class LandClassUpdate extends CI_Controller {
    // Constant to control reupdate feature
    const ENABLE_REUPDATE = true; // Set to false to disable reupdate globally

    public function __construct() {
        parent::__construct();
    $this->load->model('land_class_update/LandClassUpdateModel', 'landclassupdatemodel');
    }

    public function index() {
        // only CO can access
        $user_desig_code = (string)$this->session->userdata('user_desig_code');
        if ($user_desig_code != 'CO') {
            echo json_encode(['error' => "Unauthorized access by:  $user_desig_code"]);
            return;
        }
        // end only CO can access

        $data['_view'] = 'land_class_update/village_landclass_update';
        $this->load->view('layouts/main', $data);
    }

    public function get_pending_villages() {
        // only CO can access
        $user_desig_code = (string)$this->session->userdata('user_desig_code');
        if ($user_desig_code != 'CO') {
            echo json_encode(['data' => [], 'error' => "Unauthorized access by:  $user_desig_code"]);
            return;
        }
        // end only CO can access

        $dist_code   = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code    = $this->session->userdata('cir_code');
        $data = $this->landclassupdatemodel->get_pending_villages($dist_code, $subdiv_code, $cir_code);
        echo json_encode(['data' => $data]);
    }

    public function get_updated_villages() {
        // only CO can access
        $user_desig_code = (string)$this->session->userdata('user_desig_code');
        if ($user_desig_code != 'CO') {
            echo json_encode(['data' => [], 'error' => "Unauthorized access by:  $user_desig_code"]);
            return;
        }
        // end only CO can access

        $dist_code   = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code    = $this->session->userdata('cir_code');
        $data = $this->landclassupdatemodel->get_updated_villages($dist_code, $subdiv_code, $cir_code);
        echo json_encode(['data' => $data]);
    }

    public function update_land_class() {
        // only CO can access
        $user_desig_code = (string)$this->session->userdata('user_desig_code');
        if ($user_desig_code != 'CO') {
            echo json_encode(['success' => false, 'error' => "Unauthorized access by:  $user_desig_code"]);
            return;
        }
        // end only CO can access
        $dist_code   = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code    = $this->session->userdata('cir_code');
        
        $village_code = $this->input->post('village_code');
        $reupdate     = $this->input->post('reupdate');
        
        // Validate village_code is exactly 14 digits
        if (!preg_match('/^\d{14}$/', $village_code)) {
            echo json_encode(['success' => false, 'error' => 'Invalid village code. Must be exactly 14 digits.']);
            return;
        }

        $result = $this->landclassupdatemodel->validate_village($village_code, $dist_code,$subdiv_code,$cir_code);
        if (!$result)
        {
            echo json_encode(['success' => false, 'error' => 'Cannot update for village: '.$village_code]);
            return; 
        }
        
        // If reupdate is requested, check if allowed
        if ($reupdate && !self::ENABLE_REUPDATE) {
            echo json_encode(['success' => false, 'error' => 'Re-update is currently disabled by admin.']);
            return;
        }
        $user_code = $this->session->userdata('user_code');
        $result = $this->landclassupdatemodel->update_land_class($village_code, $user_code);
        if (isset($result['status']) && !$result['status'])
        {
            echo json_encode(['success' => false, 'error' => 'Cannot update for village: '.$village_code."###Error###:".$result['message'] ]);
            return; 
        }
        echo json_encode(['success' => true]);
    }
}
