<?php
class LACApprovalController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('LAC_model');
    }

    public function index()
    {
        $dist_code = $this->session->userdata['dist_code'];

        $data['finalizeData'] = $this->LAC_model->getLacList($dist_code);

        
        $data['_view'] = 'lac_approval/index';
        $this->load->view('layouts/main', $data);
    }



    public function approveLAC()
    {
        $lac_id = $this->input->post('lac_id');
        if (!$lac_id) {
            echo 'error';
            return;
        }

        $result = $this->LAC_model->approveLAC($lac_id);
        echo $result ? 1 : 0;
    }

    public function getVillageDetails()
    {
        $lac_id = $this->input->post('lac_id');
        $status = $this->input->post('status'); 
        
        if (!$lac_id) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Invalid LAC ID']);
            return;
        }

        // Pass the status parameter to the model
        $village_codes = $this->LAC_model->getFinalizeDataByLacId($lac_id, $status);

        
        if (empty($village_codes)) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'No villages found for this LAC']);
            return;
        }

        // Get village names using getVillageNamesBulk
        $result = $this->LAC_model->getVillageNamesBulk($village_codes);

        // var_dump($result);
        // die;
        
        // Ensure we have an array of villages
        $villages = is_array($result) ? $result : [];
        
        // Format the response
        $response = [
            'villages' => $villages,
            'lac_id' => $lac_id
        ];

        // Set proper content type and return JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
