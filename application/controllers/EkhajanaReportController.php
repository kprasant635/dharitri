<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class EkhajanaReportController extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('eKhajana/Common/EkhajanaCommonModel');
        $this->load->model('eKhajana/CoArrearUpdate/CoArrearUpdateModel');
        $this->load->model('eKhajana/EkhajanaDoul/EkhajanaDoulModel');
        $this->load->model('eKhajana/EkhajanaCO/EkhajanaCoModel');
        $this->load->model('eKhajana/EkhajanaReport/EkhajanaReportModel');
        $this->dbswitch();
    }
    //script-validation-callback
    function check_script($str){
        if( strpos( trim(strtolower($str)), '<' ) !== false) {
            return FALSE;
        }
        if( strpos( trim(strtolower($str)), '>' ) !== false) {
            return FALSE;
        }
        if( strpos( trim(strtolower($str)), '<script>' ) !== false) {
            return FALSE;
        }
        if( strpos( trim(strtolower($str)), '</script>' ) !== false) {
            return FALSE;
        }
        return TRUE;
    }
    //date-validation-callback
    function date_valid($date){
        if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date))
            return false;
        $day = (int) substr($date, 8, 2);
        $month = (int) substr($date, 5, 2);
        $year = (int) substr($date, 0, 4);
        return checkdate($month, $day, $year);
    }
    //db switch method
    public function dbswitch(){
        //$CI=&get_instance();
        if($this->session->userdata('dist_code') == "02"){
            $this->db=$this->load->database('dha3', TRUE);
        } else if($this->session->userdata('dist_code') == "05"){
            $this->db=$this->load->database('dha1', TRUE);
            } else if($this->session->userdata('dist_code') == "10"){
            $this->db=$this->load->database('dha24', TRUE);
        } else if($this->session->userdata('dist_code') == "13"){
            $this->db=$this->load->database('dha2', TRUE);
        }  else if($this->session->userdata('dist_code') == "17"){
            $this->db=$this->load->database('dha4', TRUE);
        }  else if($this->session->userdata('dist_code') == "15"){
            $this->db=$this->load->database('dha5', TRUE);
        }  else if($this->session->userdata('dist_code') == "14"){
            $this->db=$this->load->database('dha6', TRUE);
        }  else if($this->session->userdata('dist_code') == "07"){
            $this->db=$this->load->database('dha7', TRUE);
        }  else if($this->session->userdata('dist_code') == "03"){
            $this->db=$this->load->database('dha8', TRUE);
        }  else if($this->session->userdata('dist_code') == "18"){
            $this->db=$this->load->database('dha9', TRUE);
        }  else if($this->session->userdata('dist_code') == "12"){
            $this->db=$this->load->database('dha13', TRUE);
        }  else if($this->session->userdata('dist_code') == "24"){
            $this->db=$this->load->database('dha10', TRUE);
        }  else if($this->session->userdata('dist_code') == "06"){
            $this->db=$this->load->database('dha11', TRUE);
        }  else if($this->session->userdata('dist_code') == "11"){
            $this->db=$this->load->database('dha12', TRUE);
        }  else if($this->session->userdata('dist_code') == "12"){
            $this->db=$this->load->database('dha13', TRUE);
        }  else if($this->session->userdata('dist_code') == "16"){
            $this->db=$this->load->database('dha14', TRUE);
        }  else if($this->session->userdata('dist_code') == "32"){
            $this->db=$this->load->database('dha15', TRUE);
        }  else if($this->session->userdata('dist_code') == "33"){
            $this->db=$this->load->database('dha16', TRUE);
        }  else if($this->session->userdata('dist_code') == "34"){
            $this->db=$this->load->database('dha17', TRUE);
        }  else if($this->session->userdata('dist_code') == "21"){
            $this->db=$this->load->database('dha18', TRUE);
        }  else if($this->session->userdata('dist_code') == "08"){
            $this->db=$this->load->database('dha19', TRUE);
        }  else if($this->session->userdata('dist_code') == "35"){
            $this->db=$this->load->database('dha20', TRUE);
        }  else if($this->session->userdata('dist_code') == "36"){
            $this->db=$this->load->database('dha21', TRUE);
        }  else if($this->session->userdata('dist_code') == "37"){
            $this->db=$this->load->database('dha22', TRUE);
        }  else if($this->session->userdata('dist_code') == "25"){
            $this->db=$this->load->database('dha23', TRUE);
        }
    }

    //display form of amdani report 
    public function amdaniReportForm() {
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "CO"){
            echo json_encode("Not Authorised..!, Please Login With CO's Credentials!");
            exit;
        }
        //**************************************************/      
        $data['dist_code'] = $dist_code = $_SESSION['credentials']["dist_code"];
        $data['subdiv_code'] = $subdiv_code = $_SESSION['credentials']["subdiv_code"];
        $data['cir_code'] = $cir_code = $_SESSION['credentials']["cir_code"];
        $data['mouza_list'] = $this->EkhajanaReportModel->getMouzaList($dist_code,$subdiv_code,$cir_code);
        $data['_view'] = 'e_khajana/report_views/amdaniReportForm';
        $this->load->view('layouts/main',$data);
    }

    //amdnai report validation 
    public function amdaniReportFormValidation(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('ek_mouza_code', 'Mouza', 'trim|required|max_length[2]');
        $this->form_validation->set_rules('village_uuid', 'Village', 'trim|required');
        $this->form_validation->set_rules('patta_type_code', 'Patta', 'trim|required|max_length[4]');
        $this->form_validation->set_rules('patta_no', 'Patta no', 'trim|required|max_length[20]');
        $this->form_validation->set_rules('start_date', 'Start Date Selection', 'trim|required');
        $this->form_validation->set_rules('to_date', 'End Date Selection', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->form_validation->set_error_delimiters('', '');
            $validation = [];
            if (form_error('ek_mouza_code')) {
                $validation[] = array('field' => 'ek_mouza_code', 'message' => form_error('ek_mouza_code'));
            }
            if (form_error('patta_type_code')) {
                $validation[] = array('field' => 'patta_type_code', 'message' => form_error('patta_type_code'));
            }
            if (form_error('patta_no')) {
                $validation[] = array('field' => 'patta_no', 'message' => form_error('patta_no'));
            }
            if (form_error('start_date')) {
                $validation[] = array('field' => 'start_date', 'message' => form_error('start_date'));
            }
            if (form_error('to_date')) {
                $validation[] = array('field' => 'to_date', 'message' => form_error('to_date'));
            }
            echo json_encode([
                "response_type" => 1,
                'validation' => $validation
            ]);
        }else{
            //to do validation 
            echo json_encode([
                "response_type" => 2,
                "msg" => "validation_passed"
            ]);
        }
        
    }

    //amdani report display method
    public function amdaniReport(){
        if(isset($_POST['paginate_form'])){
            //echo json_encode($_POST);
            $_POST['ek_mouza_code'] = json_decode($_POST['posted_data'])->ek_mouza_code;
            $_POST['village_uuid'] = json_decode($_POST['posted_data'])->village_uuid;
            $_POST['patta_type_code'] = json_decode($_POST['posted_data'])->patta_type_code;
            $_POST['patta_no'] = json_decode($_POST['posted_data'])->patta_no;
            $_POST['start_date'] = json_decode($_POST['posted_data'])->start_date;
            $_POST['to_date'] = json_decode($_POST['posted_data'])->to_date;      
            $data['posted_data'] = $_POST;
            $offset = $_POST['offset'];
            $data['offset'] = $offset;
            $data['reportData'] = $this->EkhajanaReportModel->getJamaWasilTransactionData($data['posted_data'], $offset);            
            $data['reportDataCount'] = $this->EkhajanaReportModel->getJamaWasilTransactionDataCount($data['posted_data']);            
        }else{
            $data['offset'] = 10;
            $data['posted_data'] = $_POST;
            $data['reportData'] = $this->EkhajanaReportModel->getJamaWasilTransactionData($data['posted_data'], 10);
            $data['reportDataCount'] = $this->EkhajanaReportModel->getJamaWasilTransactionDataCount($data['posted_data']);
        }
        // echo "<pre>";
        // var_dump($_POST['paginate_form']);
        // echo "</pre>";
        // exit;
        $data['_view'] = 'e_khajana/report_views/amdaniReport';
        $this->load->view('layouts/main',$data);
    }

    //Dashboard for co display
    public function viewCircleWiseCount(){
        $data['dist_code'] = $dist_code = $_SESSION['credentials']["dist_code"];
        $data['subdiv_code'] = $subdiv_code = $_SESSION['credentials']["subdiv_code"];
        $data['cir_code'] = $cir_code = $_SESSION['credentials']["cir_code"];
        // curl to get response from basundhara server 
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => EKHAJANA_API_FOR_CO_COUNT_CIRCLE,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
            ),
        ));
        
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if($httpcode == 200){
            //return "curl successfull";
            $response_obj = json_decode($response);
            $data['registered_app_count'] = $response_obj->registered_app_count;
            $data['pending_app_count'] = $response_obj->pending_app_count;
            $data['delivered_app_count'] = $response_obj->delivered_app_count;
            $data['rejected_app_count'] = $response_obj->rejected_app_count;
            $data['_view'] = 'e_khajana/co_dashboard/dashboardindex';
            $this->load->view('layouts/main',$data);
        }else{
            echo json_encode("Error in fecthing details, Please try again later..!!");
        }
        
    }

    //lot wise case for co display
    public function viewLotWiseCount(){
        $data['dist_code'] = $dist_code = $_SESSION['credentials']["dist_code"];
        $data['subdiv_code'] = $subdiv_code = $_SESSION['credentials']["subdiv_code"];
        $data['cir_code'] = $cir_code = $_SESSION['credentials']["cir_code"];
        // curl to get response from basundhara server 
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => EKHAJANA_API_FOR_CO_COUNT_LOT,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
            ),
        ));
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if($httpcode == 200){
            $response_obj = json_decode($response);
            $data['lot_details'] = $response_obj;
            $data['_view'] = 'e_khajana/co_dashboard/lotWiseData';
            $this->load->view('layouts/main',$data);
        }else{
            echo json_encode("Error in fecthing details, Please try again later..!!");
        }
    }

    //view all cases  display method
    public function viewCaseDetail($mouza_code, $lot_no){
        $data['dist_code'] = $dist_code = $_SESSION['credentials']["dist_code"];
        $data['subdiv_code'] = $subdiv_code = $_SESSION['credentials']["subdiv_code"];
        $data['cir_code'] = $cir_code = $_SESSION['credentials']["cir_code"];
        $data['mouza_code'] = $mouza_code;
        $data['lot_no'] = $lot_no;
        $data['getStatus'] =  $this->EkhajanaReportModel->getStatusOfCases();
        $data['_view'] = 'e_khajana/co_dashboard/caseDetail';
        $this->load->view('layouts/main',$data);
    }

    //view api cases data method
    public function viewCasesAPI(){

        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_code = $this->input->post('mouza_code');
        $lot_no = $this->input->post('lot_no');

        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');
        $status = $this->input->post('ekhajana_status');
    
        $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
        $searchByCol_1 = $this->input->post('columns')[1]['search']['value'];

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => EKHAJANA_API_FOR_DETAIL_CASE,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array( 
                'dist_code'          => $dist_code,
                'subdiv_code'        => $subdiv_code,
                'cir_code'           => $cir_code,
                'mouza_pargona_code' => $mouza_code,
                'lot_no'             => $lot_no,
                'offset'             => $start,
                'length'             => $length,
                'application_no'     => $searchByCol_0,
                'ekhajana_status'    => $status,
                //'ld_application_no'  => $searchByCol_1, 
            )));
            $response = curl_exec($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            $results = json_decode($response); 
            // var_dump($results);
            // exit;
              
            if(count($results) == 0){
                $recordsTotal = 0;    
            }else{
                $recordsTotal = (int)$results[0]->recordsTotal;
            }
            if($results){
                $data_rows = $results;    
                foreach($data_rows as $rows){                                                         
                    $alldata = json_decode($rows->all_application_data, "true");
                    $status = $alldata['land_details_status'];
                    if($status == "P"){
                        $status_text = "PENDING FOR PROCESSING";
                    }elseif($status == "LM-F"){
                        $status_text = "PENDING-WITH-CO";
                    }elseif($status == "CO-F"){
                        $status_text = "PENDING-WITH-ASSISTNAT";
                    }elseif($status == "F"){
                        $status_text = "DISPOSED";
                    }elseif($status == "R"){
                        $status_text = "REJECTED";
                    }elseif($status == "L"){
                        $status_text = "REVERTED BY AST";
                    }elseif($status == "MLM_F"){
                        $status_text = "PENDING-WITH-MOUZADAR";
                    }elseif($status == "MOU_F"){
                        $status_text = "PENDING-WITH-LM";
                    }elseif($status == "COM_F"){
                        $status_text = "PENDING-WITH-CO";
                    }elseif($status == "M_OBJ"){
                        $status_text = "OBJECTION-BY-MOUZADAR";
                    }else{
                        $status_text = "WAITING-FOR-CITIZEN-PAYMENT";
                    }

                    $constant_data = json_decode(EKHAJANA_CASE_UPDATE);
                    $sql123 = $this->db->query('SELECT manual_flag FROM ekhajana_basic WHERE ld_application_no = ?', array($rows->ld_application_no));

                    if(in_array($rows->application_no, array($constant_data[0]->application_no))){
                        if($sql123->row()->manual_flag == '1'){
                            $update_button ='<button class="btn btn-secondary" disabled> NO ACTION </button>';
                        }else{
                            $update_button = '<a type="button" href="' . base_url() . 'index.php/EkhajanaUpdate/updateEkhajanaApplication?application_no=' . $rows->application_no . '&ld_application_no=' . $rows->ld_application_no . '"" class="btn btn-success">UPDATE</a>';
                        } 
                    }else{
                        $update_button ='<button class="btn btn-secondary" disabled> NO ACTION </button>';
                    } 
                    
                    $json[] = array(
                        '<span class="px-3"><strong>'.$rows->application_no.'</strong></span>',
                        $rows->ld_application_no,
                        $rows->payment_status,
                        $status_text,
                        $update_button,
                    );
                }
                //$total_records = $results->total_records;
                $response = array(
                    'draw'              => $draw,
                    'recordsTotal'      => $recordsTotal,
                    'recordsFiltered'   => $recordsTotal,
                    'data'              => $json
                );
                echo json_encode($response);
    
            }else{
                $response = array();
                $response['sEcho']=0;
                $response['iTotalRecords']=0;
                $response['iTotalDisplayRecords']=0;
                $response['aaData']=[];
                echo json_encode($response);
            }
        } 
        
        
    public function dailyRevenue()
    {
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['circle_code'] = $cir_code = $this->session->userdata('cir_code');
        $data['_view'] = 'e_khajana/co_reports/index';
        $this->load->view('layouts/main',$data);
    }

    public function populateReport()
    {
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['circle_code'] = $cir_code = $this->session->userdata('cir_code');
        $data['select_date'] = $select_date = $_POST['select_date'];
        $data['revenueData'] = $this->EkhajanaReportModel->getRevenueAmount($dist_code,$subdiv_code,$cir_code,$select_date);
        // var_dump($data['revenueData']);
        // exit;
        $data['_view'] = 'e_khajana/co_reports/revenue_collection_report';
        $this->load->view('layouts/main',$data);

    }

    public function index()
    {
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['cir_code'] = $cir_code = $this->session->userdata('cir_code');
        $data['_view'] = 'e_khajana/co_reports/landing_page';
        $this->load->view('layouts/main',$data);
    }

    public function unpaidPattadarList()
    {
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['cir_code'] = $cir_code = $this->session->userdata('cir_code');
        $data['unpaidPattadar'] = $this->EkhajanaReportModel->getUnpaidPattadarList($dist_code,$subdiv_code,$cir_code);
        if($data['unpaidPattadar'] == 'NOT-FOUND'){
            echo "No Unpaid Pattadar Available in The Circle..!!";
            exit;
        }
        $data['_view'] = 'e_khajana/co_reports/unpaidPattadarList';
        $this->load->view('layouts/main',$data);
    }

    public function allRejectCasesList()
    {
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['cir_code'] = $cir_code = $this->session->userdata('cir_code');
        $data['rejectList'] = $this->EkhajanaReportModel->getAllRejectList($dist_code,$subdiv_code,$cir_code);
        if($data['rejectList'] == 'NOT-FOUND'){
            echo "No Reject Cases Available in The Circle..!!";
            exit;
        }
        $data['_view'] = 'e_khajana/co_reports/allRejectCasesList';
        $this->load->view('layouts/main',$data);
    }

    public function monthlyEkhajanaReceived()
    {
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['cir_code'] = $cir_code = $this->session->userdata('cir_code');
        $data['_view'] = 'e_khajana/co_reports/monthlyKhajanaReport';
        $this->load->view('layouts/main',$data);
    }

    public function monthlyReport()
    {
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['cir_code'] = $cir_code = $this->session->userdata('cir_code');
        $data['date'] = $date =  $_POST['select_date_from'];
        $data['monthly_amount'] = $this->EkhajanaReportModel->getMonthlyKhajanaReport($dist_code,$subdiv_code,$cir_code,$date);
        // var_dump($monthly_amount);
        // exit;
        $data['_view'] = 'e_khajana/co_reports/monthly_khajana_report';
        $this->load->view('layouts/main',$data);
    }
// 
    public function yearlyEkhajanaReceived()
    {
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['cir_code'] = $cir_code = $this->session->userdata('cir_code');
        $data['_view'] = 'e_khajana/co_reports/yearlyKhajanaReport';
        $this->load->view('layouts/main',$data); 
    }

    public function yearlyReport()
    {
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['cir_code'] = $cir_code = $this->session->userdata('cir_code');
        $data['year'] = $year =  $_POST['select_year'];
        $data['yearly_amount'] = $this->EkhajanaReportModel->getYearlyKhajanaReport($dist_code,$subdiv_code,$cir_code,$year);
        $data['_view'] = 'e_khajana/co_reports/yearly_khajana_data';
        $this->load->view('layouts/main',$data); 
    }

    public function EcfrMouzadarDashboard()
    {
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['cir_code'] = $cir_code = $this->session->userdata('cir_code');
        $data['ecfr_data'] = $this->EkhajanaReportModel->getEcfrDetails($dist_code,$subdiv_code,$cir_code);
        if($data['ecfr_data']['flag'] == 'ERROR'){
            echo "Some error Occurred In Fetching Details.. Kindly Try After Some Time";
            exit;
        }
        $data['ecfr_details'] = $data['ecfr_data']['msg'];
        $data['_view'] = 'e_khajana/co_reports/ecfr_report';
        $this->load->view('layouts/main',$data);
        
    } 

    public function unregisteredPattaList()
    {
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['cir_code'] = $cir_code = $this->session->userdata('cir_code'); 
        $data['excelReport'] = $this->EkhajanaReportModel->getUnRegisteredPattaList($dist_code,$subdiv_code,$cir_code);
        if($data['excelReport']['flag'] =='ERROR'){
            echo "Error In Fetching Un Registered Patta details";
            exit;
        }
        $data['all_pattas'] = (array)$data['excelReport']['msg'];
        $data['_view'] = 'e_khajana/co_reports/unregistered_patta_list';
        $this->load->view('layouts/main',$data);
    }


    // dahsboard
    public function MouzaWiseReconciliationDashborad()
    {
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['reconcil_data'] = $this->EkhajanaReportModel->getMouzaWiseReconciliationDetails($dist_code);
        if($data['reconcil_data']['flag'] == 'ERROR'){
            echo "Some error Occurred In Fetching Details.. Kindly Try After Some Time";
            exit;
        }
        $data['reconcil_details'] = $data['reconcil_data']['msg'];
        $data['_view'] = 'e_khajana/report_views/mouza_wise_dashboard';
        $this->load->view('layouts/main',$data);
    }

    public function circleWiseReconciliationDashboard()
    {
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['cir_code'] = $cir_code = $this->session->userdata('cir_code');
        $data['reconcil_data'] = $this->EkhajanaReportModel->getCircleWiseReconciliationDetails($dist_code,$subdiv_code,$cir_code);
        if($data['reconcil_data']['flag'] == 'ERROR'){
            echo "Some error Occurred In Fetching Details.. Kindly Try After Some Time";
            exit;
        }
        $data['reconcil_details'] = $data['reconcil_data']['msg'];
        $data['_view'] = 'e_khajana/report_views/circle_wise_dashboard_reconcil';
        $this->load->view('layouts/main',$data);
    }

    public function MouzaWiseCFRBooksData()
    {
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['cfr_books_data'] = $this->EkhajanaReportModel->MouzaWiseCFRBooksData($dist_code);
        if($data['cfr_books_data']['flag'] == 'ERROR'){
            echo "Some error Occurred In Fetching Details.. Kindly Try After Some Time";
            exit;
        }
        
        $data['cfr_book_entries'] = $data['cfr_books_data']['msg'];
        $data['_view'] = 'e_khajana/report_views/mouza_wise_cfr_books_details';
        $this->load->view('layouts/main',$data);
    }

    public function indexDCN()
    {
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['cir_code'] = $cir_code = $this->session->userdata('cir_code');
        $data['_view'] = 'e_khajana/co_reports/landing_page_dcn';
        $this->load->view('layouts/main',$data);
    }

    public function unpaidPattadarListDcn()
    {
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['unpaidPattadar'] = $this->EkhajanaReportModel->getUnpaidPattadarListDcn($dist_code);
        if($data['unpaidPattadar'] == 'NOT-FOUND'){
            echo "No Unpaid Pattadar Available in The Circle..!!";
            exit;
        }
        $data['_view'] = 'e_khajana/co_reports/unpaidPattadarList';
        $this->load->view('layouts/main',$data);
    }

}


        


