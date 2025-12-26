<?php

ini_set('memory_limit', '-1');

class BhunakshaIntegrationController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('agri_stack_helper'));
        $this->load->model('BhunakshaIntegrationModel');
    }

    public function dbswitch($dist_code)
    {
        //$CI=&get_instance();
        if ($dist_code == "02") {
            $this->db = $this->load->database('dha3', true);
        } else if ($dist_code == "05") {
            $this->db = $this->load->database('dha1', true);
        } else if ($dist_code == "10") {
            $this->db = $this->load->database('dha24', true);
        } else if ($dist_code == "13") {
            $this->db = $this->load->database('dha2', true);
        } else if ($dist_code == "17") {
            $this->db = $this->load->database('dha4', true);
        } else if ($dist_code == "15") {
            $this->db = $this->load->database('dha5', true);
        } else if ($dist_code == "14") {
            $this->db = $this->load->database('dha6', true);
        } else if ($dist_code == "07") {
            $this->db = $this->load->database('dha7', true);
        } else if ($dist_code == "03") {
            $this->db = $this->load->database('dha8', true);
        } else if ($dist_code == "18") {
            $this->db = $this->load->database('dha9', true);
        } else if ($dist_code == "12") {
            $this->db = $this->load->database('dha13', true);
        } else if ($dist_code == "24") {
            $this->db = $this->load->database('dha10', true);
        } else if ($dist_code == "06") {
            $this->db = $this->load->database('dha11', true);
        } else if ($dist_code == "11") {
            $this->db = $this->load->database('dha12', true);
        } else if ($dist_code == "12") {
            $this->db = $this->load->database('dha13', true);
        } else if ($dist_code == "16") {
            $this->db = $this->load->database('dha14', true);
        } else if ($dist_code == "32") {
            $this->db = $this->load->database('dha15', true);
        } else if ($dist_code == "33") {
            $this->db = $this->load->database('dha16', true);
        } else if ($dist_code == "34") {
            $this->db = $this->load->database('dha17', true);
        } else if ($dist_code == "21") {
            $this->db = $this->load->database('dha18', true);
        } else if ($dist_code == "08") {
            $this->db = $this->load->database('dha19', true);
        } else if ($dist_code == "35") {
            $this->db = $this->load->database('dha20', true);
        } else if ($dist_code == "36") {
            $this->db = $this->load->database('dha21', true);
        } else if ($dist_code == "37") {
            $this->db = $this->load->database('dha22', true);
        } else if ($dist_code == "25") {
            $this->db = $this->load->database('dha23', true);
        } else if ($dist_code == "39") {
            $this->db = $this->load->database('dha39', true);
        } else if ($dist_code == "38") {
            $this->db = $this->load->database('dha25', true);
        }
    }

    public function test(){
        $savimtva_array=[
            'dist_code' => '07',
            'subdiv_code' => '01',
            'cir_code' => '05',
            'mouza_pargona_code' => '06',
            'lot_no' => '05',
            'vill_townprt_code' => '10001',
            'new_dag_no' => '120',
            'mutation_date' => date('Y-m-d'),
            'dag_no' => '62',
            'case_no' => 'TEST122',
        ];
        $result = $this->BhunakshaIntegrationModel->insert($savimtva_array);

        var_dump($result);die;
    }

    

    public function getPendingList(){
        $split_filter = $this->input->get('split_filter');
        $property_filter = $this->input->get('property_filter');
        $case_no = $this->input->get('case_no');
        $this->db->where([
            'dist_code' => $this->session->userdata('dist_code'),
            'subdiv_code' => $this->session->userdata('subdiv_code'),
            'cir_code' => $this->session->userdata('cir_code'),
            'mouza_pargona_code' => $this->session->userdata('mouza_pargona_code'),
            'lot_no' => $this->session->userdata('lot_no'),
            // 'status'     => 0,
        ]);

        if ($split_filter!= '' && $property_filter==='') {
            // $this->db->where('is_full_dag', 0);
            $this->db->where('status', $split_filter);
        }

        if ($property_filter!= '' && $split_filter==='') {
            $this->db->where('property_status', $property_filter);
        }

        if ($case_no != '') {
            $this->db->like('case_no', $case_no);
        }

        // var_dump($split_filter, $property_filter, $case_no);
        if(($split_filter === '' && $property_filter === '' && $case_no === '')||($split_filter === false && $property_filter === false && $case_no === false)){
            // dd('here');
            $this->db->where('status', 0);
            $this->db->where('property_status', 0);
        }
        
        $records = $this->db->order_by('id', 'ASC')->get('bhunaksha_svamitva_cases')->result();
        // dd($this->db->last_query());
        $dist_code = $this->session->userdata('dist_code');
        if(in_array($dist_code,['21','22','23'])){
            $data['is_barak_valley'] = true;
        }else{
            $data['is_barak_valley'] = false;
        }
        $data['records'] = $records;
        $data['_view'] = 'BhunakshaIntegration/index';
        $this->load->view('layouts/main',$data);
    }

    public function getPropertyList() {
        $id = $this->input->post('id');
        $query = $this->db->get_where('property_details', ['f_key' => $id]);
        $prop_details = $query->result_array();
        $case_details = $this->db->get_where('bhunaksha_svamitva_cases', ['id' => $id])->row();
        $chitha_basic = $this->db->get_where('chitha_basic', 
            [
                'dist_code'=> $case_details->dist_code,	
                'subdiv_code'=> $case_details->subdiv_code,	
                'cir_code'=> $case_details->cir_code,	
                'mouza_pargona_code'=> $case_details->mouza_pargona_code,	
                'lot_no'=> $case_details->lot_no,	
                'vill_townprt_code'=> $case_details->vill_townprt_code,
                'dag_no'=> $case_details->new_dag_no,])->row();
        $result = [
            'prop_details' => $prop_details,
            'case_details' => $case_details,
            'chitha_basic' => $chitha_basic
        ];
        echo json_encode($result);
    }

    public function storePropertyDetails() {
        $this->db->trans_begin();
        $this->db->where('id', $this->input->post('primary_key'));
        $record = $this->db->get('bhunaksha_svamitva_cases')->row();
        if(in_array($record->property_status,[2,3])){
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', 'Cannot add more property.');
            redirect(base_url('index.php/BhunakshaIntegrationController/getPendingList'));
        }
        foreach ($this->input->post('property_type') as $key => $property_type) {
            $p_d_id = $this->input->post('p_d_id')[$key] ?? null;
            $build_up_area = $this->input->post('build_up_area')[$key] ?? null;
            $total_area = $this->input->post('total_area')[$key] ?? null;
            $tax = $this->input->post('tax')[$key] ?? null;
            $property_value = $this->input->post('property_value')[$key] ?? null;
            $encumbrance_details = $this->input->post('encumbrance_details')[$key] ?? null;
            if (empty($property_type) || empty($build_up_area) || empty($total_area) || empty($tax) || empty($property_value) || empty($encumbrance_details)) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'All property fields are required');
                redirect(base_url('index.php/BhunakshaIntegrationController/getPendingList'));
            }
            if($build_up_area> $total_area){
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Built-up Area cannot be greater than Total Area.');
                redirect(base_url('index.php/BhunakshaIntegrationController/getPendingList'));
            }
            if($tax> $property_value){
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Tax cannot be greater then Property Value');
                redirect(base_url('index.php/BhunakshaIntegrationController/getPendingList'));
            }
            $data = [
                'f_key' => $this->input->post('primary_key'),
                'case_no' => $record->case_no,
                'old_dag_no' => $record->dag_no,
                'new_dag_no' => $record->new_dag_no,
                'property_type' => $property_type,
                'build_up_area' => $build_up_area,
                'total_area' => $total_area,
                'tax' => $tax,
                'property_value' => $property_value,
                'encumbrance_details' => $encumbrance_details,
                'status' => 'initiated',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('user_code')
            ];
            if($p_d_id){
                $this->db->where('id', $p_d_id);
                $this->db->update('property_details', $data);
            }else{
                $this->db->insert('property_details', $data);
            }
            // $status = $record->property_status==0?1:2;
            $status = 1;
            if($record->prop_edit_count==4){
                $status = 2;
            }
            $this->db->where('id', $this->input->post('primary_key'));
            $this->db->update('bhunaksha_svamitva_cases',['property_status'=>$status,'prop_edit_count'=>$record->prop_edit_count+1]);
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', 'Failed to save property details');
            redirect(base_url('index.php/BhunakshaIntegrationController/getPendingList'));
        }
        $this->db->trans_commit();
        $this->session->set_flashdata('message', 'Successfull');
        redirect(base_url('index.php/BhunakshaIntegrationController/getPendingList'));
    }

    public function deleteProperty() {
        $id = $this->input->post('id');

        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
            return;
        }
        $query = $this->db->get_where('property_details', ['id' => $id])->row();
        $case_details = $this->db->get_where('bhunaksha_svamitva_cases', ['id' => $query->f_key])->row();
        if(in_array($case_details->property_status,[2,3])){
            echo json_encode(['status' => 'error', 'message' => 'Cannot delete']);
            return;
        }
        if (!$query) {
            echo json_encode(['status' => 'error', 'message' => 'Property not found']);
            return;
        }
        $related_properties = $this->db->get_where('property_details', ['f_key' => $query->f_key])->result_array();
        if (count($related_properties) > 1) {
            $this->db->where('id', $id);
            $deleted = $this->db->delete('property_details');

            if ($deleted) {
                echo json_encode(['status' => 'success', 'message' => 'Property deleted successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete property']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Cannot delete the last remaining property']);
        }
    }




    public function splitDag(){
        $id = $this->input->post('id');
        $result = $this->BhunakshaIntegrationModel->getPendingAssets($id);
        echo "
            <script>
                 window.location.replace('$result');
            </script>
            ";
        exit;
    }



    public function nc_khas_case_verify(){
        if ($this->input->method() !== 'post') {
            echo json_encode([
                'status' => false,
                'message' => 'Only POST method is allowed'
            ]);
            return;
        }
        $dist_code = $this->input->post('dist_code');
        $case_no   = $this->input->post('case_no');
        $dag_no    = $this->input->post('dag_no');
        $new_dag_no    = $this->input->post('new_dag_no');
        if (!$dist_code || !$case_no || !$dag_no || !$new_dag_no) {
            $json = json_decode(file_get_contents('php://input'), true);

            if (is_array($json)) {
                $dist_code = $dist_code ?: (isset($json['dist_code']) ? $json['dist_code'] : null);
                $case_no   = $case_no   ?: (isset($json['case_no']) ? $json['case_no'] : null);
                $dag_no    = $dag_no    ?: (isset($json['dag_no']) ? $json['dag_no'] : null);
                $new_dag_no    = $new_dag_no    ?: (isset($json['new_dag_no']) ? $json['new_dag_no'] : null);
            }
        }
        $this->db = $this->LandMaster->dbswitch($dist_code);
        $this->db->where([
            'dist_code' => $dist_code,
            'case_no' => $case_no,
            'dag_no' => $dag_no,
            'new_dag_no' => $new_dag_no,
        ]);
        // $this->db->where_in('status', [0, 1]);
        $record = $this->db->get('bhunaksha_svamitva_cases')->row();
        if($record->status==2){
           echo json_encode([
                'status' => false,
                'message' => 'Already Completed'
            ]);
            return; 
        }
        if (!$record) {
            $response = [
                'old_dag_no'   => $dag_no,
                'new_dag_no'   => null,
                'case_no'  => $case_no,
                'status'       => false,
            ];
            echo json_encode($response);
            return;
        }
        $response = [
            'old_dag_no'   => $record->dag_no ?? null,
            'new_dag_no'   => $record->new_dag_no ?? null,
            'case_no'  => $record->case_no ?? null,
            'case_date' => date('Y-m-d', strtotime($record->mutation_date)),
            'status'       => true,
        ];
        echo json_encode($response);
        return;
    }

    public function nc_khas_case_confirm() {

        if ($this->input->method() !== 'post') {
            echo json_encode([
                'status' => false,
                'message' => 'Only POST method is allowed'
            ]);
            return;
        }
        $dist_code = $this->input->post('dist_code');
        $case_no   = $this->input->post('case_no');
        $dag_no    = $this->input->post('dag_no');
        $status    = $this->input->post('status');
        $new_dag_no    = $this->input->post('new_dag_no');
        if (!$dist_code || !$case_no || !$dag_no || !$new_dag_no) {
            $json = json_decode(file_get_contents('php://input'), true);

            if (is_array($json)) {
                $dist_code = $dist_code ?: (isset($json['dist_code']) ? $json['dist_code'] : null);
                $case_no   = $case_no   ?: (isset($json['case_no']) ? $json['case_no'] : null);
                $dag_no    = $dag_no    ?: (isset($json['dag_no']) ? $json['dag_no'] : null);
                $status    = $status    ?: (isset($json['status']) ? $json['status'] : null);
                $new_dag_no    = $new_dag_no    ?: (isset($json['new_dag_no']) ? $json['new_dag_no'] : null);
            }
        }
        $this->db = $this->LandMaster->dbswitch($dist_code);

        /////////// validation ///////
        $this->db->where([
            'dist_code' => $dist_code,
            'case_no' => $case_no,
            'dag_no' => $dag_no,
            'new_dag_no' => $new_dag_no,
        ]);
        $record = $this->db->get('bhunaksha_svamitva_cases')->row();
        if($record->status==2){
           echo json_encode([
                'status' => false,
                'message' => 'Already Completed'
            ]);
            return; 
        }
        ///////// Validation Ends /////

        $this->db->where([
            'dist_code' => $dist_code,
            'case_no'   => $case_no,
            'dag_no'    => $dag_no,
        ]);
        $this->db->where_in('status', [0, 1]);
        if($status == 'initiated'){
            $sts = 1;
        }else if($status == 'completed'){
            $sts = 2;
        }
        $this->db->set('status', $sts);
        $this->db->update('bhunaksha_svamitva_cases');
        if ($this->db->affected_rows() > 0) {
            $response = [
                'status' => true,
                'message' => 'Update successful'
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'Failed to update or no matching record found'
            ];
        }
        echo json_encode($response);
        return;
    }



    
}
?>
