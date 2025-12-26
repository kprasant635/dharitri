<?php

class DigitalPatta extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'Language'));
        $this->load->library('form_validation');
        $this->load->model('digitalPatta/DigitalPattaCommonModel');
        $this->load->model('digitalPatta/digitalPattaLocationModel');
        $this->load->model('UtilsModel');
        $this->load->helper('qrcode');
    }
  
    //db_switch method
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
        } else if($this->session->userdata('dist_code') == "39"){
            $this->db=$this->load->database('dha39', TRUE);
        } else if($this->session->userdata('dist_code') == "38"){
            $this->db=$this->load->database('dha25', TRUE);
        }
    }

    //landing page
    public function digitalPattaLandingPage()
    {
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['certificate'] = $this->DigitalPattaCommonModel->getDscSignCertificate($dist_code);
        $data['_view'] = 'digitalPatta/landing_page';
        $this->load->view('layouts/main',$data);
    } 

    //getting all digital patta details (datatable list)
    public function getAllDigitalPattaDetails() 
    {

        $json = null;
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');
        $cases_list = $this->DigitalPattaCommonModel->getAllCasesDigitalPatta($start, $length, $order);
        
        if(!empty($cases_list)) {
    
          if($cases_list['total_records'] > 0){
    
            $data_rows = $cases_list['data_results'];
    
            foreach($data_rows as $row) {
    
                $case_no = "<small class='case-no-bg'><i class='fa fa-archive'></i>" . $row->case_no . "</small>";
    
                $service = "<small class='case-no-bg'><i class='fa fa-archive'></i>" . $this->utilityclass->getServiceName($row->service_code). "</small>";

                $dated_at = date('d-M-Y',strtotime($row->date_entry));
                $created_at = "<small class='case-no-bg'><i class='fa fa-clock'></i>" . $dated_at . "</small>";

                $district = "<small class='case-no-bg'>" . $this->utilityclass->getDistrictName($row->dist_code) . "</small>";

                $circle = "<small class='case-no-bg'>" . $this->utilityclass->getCircleName($row->dist_code,$row->subdiv_code,$row->cir_code) . "</small>";
                $village = "<small class='case-no-bg'>" . $this->utilityclass->getVillageName($row->dist_code,$row->subdiv_code,$row->cir_code,$row->mouza_pargona_code,$row->lot_no,$row->vill_townprt_code) . "</small>";
                $button1 = '<button type="button" class="btn btn-sm btn-danger" onclick="viewDigitalPatta(\'' . $row->case_no . '\', \'' . $row->dist_code . '\')"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;View</button>';
                //$button2 = '<button type="button" class="btn btn-sm btn-success" onclick="viewDigitalPatta(\'' . $row->case_no . '\', \'' . $row->dist_code . '\')"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;Download</button>';
              
              $json[] = array(
                    $row->case_no,
                    $case_no,
                    $service,
                    $created_at,
                    $district,
                    $circle,
                    $village,
                    $button1,
              );
            }
          }
          else {
            $json = "";
          }      
        $total_records = $cases_list['total_records'];
          $response = array(
            'draw'              => $draw,
            'recordsTotal'      => $total_records,
            'recordsFiltered'   => $total_records,
            'data'              => $json
          );
          echo json_encode($response);
        }
        else
        {
          $response = array();
          $response['sEcho']=0;
          $response['iTotalRecords']=0;
          $response['iTotalDisplayRecords']=0;
          $response['aaData']=[];
          echo json_encode($response);
        }
    }

    //method to view the digital patta and display in modal
    public function getDigitalPattaDetails()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        
        $dhar_case_no = $_POST['case_no'];
        $data['application_no'] = $application_no =$this->DigitalPattaCommonModel->getApplidFromCaseNo($dhar_case_no);
        $data['rtps_ref_no'] = $rtps_no = $this->DigitalPattaCommonModel->getRtpsRefNo($application_no);
        $data['patta_info'] = $this->DigitalPattaCommonModel->getPattaInfo($application_no);
        if(!$data['patta_info']['result']){
            echo json_encode($data['patta_info']);
            exit;
        }
        $data['base_64_qr'] = printQR("URL:https://sewasetu.assam.gov.in/"."\nApplication-No: ".$application_no."\nPrimaryLandHolderName: ".$data['patta_info']['chitha_pattadar_applicant_data']->pdar_name_eng);
        $dist_code = $_POST['dist_code'];
        $dag_no = $data['patta_info']['chitha_basic'][0]->old_dag_no;
        $data['dag_sketch_qr_code'] = printQR(BASUNDHARA_LIVE_URL."/DigitalPatta/getSketchOfTheDagForDigitalPatta/?dist_code=$dist_code&dag_no=$dag_no&app_no=$application_no");
        //$data['dag_sketch_qr_code'] = printQR("https://basundhara.assam.gov.in/rtpsmb/sikriticontroller/getSketchOfTheDagForDigitalPatta/$dist_code/$dag_no/$encrypted_app_no");
        $string = $this->load->view('digitalPatta/digitalPatta', $data, true);       
        echo json_encode($string);
    }

    //method to generate the digital patta and digitally sign in bulk
    public function bulkSignOfDigitalPatta()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $dhar_case_no_list = $_POST['selectedList'];
        $string = '';
        $dhar_case_no = '';
        $base64array = array();
        $entire_page='';

        foreach($dhar_case_no_list as $key => $dhar_case_no){
            $data['application_no'] = $application_no =$this->DigitalPattaCommonModel->getApplidFromCaseNo($dhar_case_no);
            $data['rtps_no'] = $rtps_no = $this->DigitalPattaCommonModel->getRtpsRefNo($application_no);
            $data['patta_info'] = $patta_info = $this->DigitalPattaCommonModel->getPattaInfo($application_no);
            if(!$data['patta_info']['result']){
                echo json_encode($data['patta_info']);
                exit;
            }
            $insert_all_data = $this->DigitalPattaCommonModel->insertAllDigitalPattaData($application_no,$rtps_no,$patta_info,$dhar_case_no);
            $data['base_64_qr'] = printQR("URL:https://sewasetu.assam.gov.in/"."\nApplication-No: ".$application_no."\nLease-Holder: ".$data['patta_info']['chitha_pattadar_applicant_data']->pdar_name_eng);
            $dist_code = $_POST['dist_code'];
            $dag_no = $data['patta_info']['chitha_basic'][0]->old_dag_no;
            $data['dag_sketch_qr_code'] = printQR(BASUNDHARA_LIVE_URL."/DigitalPatta/getSketchOfTheDagForDigitalPatta/?dist_code=$dist_code&dag_no=$dag_no&app_no=$application_no");
            $string = $this->load->view('digitalPatta/digitalPatta', $data, true);
            $css ='';
            $css .= '<style>
                        .logo{
                            height : 15%!important; 
                            width : 15%!important;
                            text-align :center!important;
                        }
                        .logoEmblem{
                            height:100%!important;
                            width:100%!important;
                        }
                        .logoBorder{
                            border:0px;
                        }
                        .center-text{
                            text-align: center!important;
                            display: inline-block;
                        }
                        td, th, tbody{
                            border:1px solid;
                            border-collapse:collapse;
                            font-size:11px;
                        }
                        table {
                            border-collapse: collapse;
                        }
                        .himanxu-margin-top{
                            margin-top:1rem;
                        }
                        .himanxu-table-width-100{
                            width:100%!important;
                        }
                        .himanxu-heading-weight{
                            font-weight: 900;
                            background-color:#f2d0da!important;
                        }
                        .himanxu_header_red{
                            color:red!important;
                        }
                        .digital_patta_heading{
                            font-size:15px;
                            font-weight: bolder;
                            font-weight: 1200;
                            text-decoration: underline;
                        }
                        .himanxu_body_color_blue{
                            background-color: #d0e6f2!important;
                        }
                        .himanxu_body_color_maroon{
                            background-color: #e6caae!important;
                        }
                        .himanxu_body_color_purple{
                            background-color: #ded5e0!important;
                        }
                        .himanxu_body_color_green{
                            background-color: #e3fad7!important;
                        }
                        .himanxu_color_blue{
                            color:blue;
                        }
                        .himanxu_font_bold_heading{
                            font-weight:900!important;
                        }
                        .thick-head{
                            font-weight: bolder;
                            font-weight: 900;
                        }
                        .himanxuNotShowButton{
                            color:white;
                            display:none;
                        }
                    </style>';
           
            $entire_page = $string . $css;
            $base64array[$key]['base64'] = $this->getPdfBase64Data(base64_encode($entire_page));
            $base64array[$key]['case_no'] = $dhar_case_no;
        }
        echo json_encode($base64array);
    }

    //method to generate the pdf base64
    public function getPdfBase64Data($htmbase64Encoded)
    {
        include 'vendor/mpdf/vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetWatermarkText('DIGITAL PATTA');
        $mpdf->showWatermarkText = true;
        $mpdf->watermarkTextAlpha = 0.1;
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $html = base64_decode($htmbase64Encoded);
        $pdfGenerated = $mpdf->writeHTML($html);
        $pdfBase64 = base64_encode($mpdf->Output('', 'S'));
        return $pdfBase64;
    }

    //method to save the pdf after sign
    public function signAndSavePDF()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);

        $pdf_data = $this->input->post('pdfData');
        $case_no = $this->input->post('case_no');
        $digitalPattaName = "DIGITAL_PATTA";
        $application_no = $this->DigitalPattaCommonModel->getApplidFromCaseNo($case_no);
        $new_case_no = str_replace('/', "-", $case_no);
        $fileName    = $digitalPattaName.$new_case_no.date("Ymdhis");
        $base64PDFData = $pdf_data;
        $uploadpath   = DIGITAL_PATTA_FINAL_UPLOAD_DIR;
        $digital_patta_path = $uploadpath.$fileName;
        file_put_contents($uploadpath.$fileName.".pdf", base64_decode($base64PDFData));
        
        //$this->db->trans_begin();
        $digital_patta_insert_details = array(
            'application_no' => $application_no,
            'digital_patta_path' =>  $uploadpath.$fileName,
            'content_type' => 'pdf',
            'file_details' => $fileName,
            'case_no' => $case_no,
            'created_at' => date('Y-m-d'),
            'modified_at' => null,
            'user_code' => $this->session->all_userdata()['user_code'],
            'ip_address' => $this->utilityclass->get_client_ip(),
            'signed_time' => date('Y-m-d h:i:s'),
            'status' => 'A'
        );

        $insert_data = $this->DigitalPattaCommonModel->insertDigitalPattaDetails($digital_patta_insert_details);
        if($insert_data!= null && $insert_data['result'] =='Y'){
            $update_settlement_basic = $this->DigitalPattaCommonModel->updateSettlement_basic_and_digital_patta_all_data($case_no,$digital_patta_path);
            if($update_settlement_basic['result'] =='SUCCESS'){
                $this->db->trans_commit();
                echo json_encode(['flag'=> 'Y', 'msg'=>'Digital Patta generated Successfully']);
            }else{
                $this->db->trans_rollback();
                log_message("error","#DIGIPATTA008253 Some error occured in updating data into settlement basic table for case no ".$case_no);
                echo json_encode(['flag'=> 'N', 'msg'=>'#DIGIPATTA008253 Some error occured, Could not generate digital Patta, Please try Again']);
            }
        }else{
            $this->db->trans_rollback();
            log_message("error","#DIGIPATTA008254 Some error occured in inserting data into digita patta table for case no ".$case_no);
            echo json_encode(['flag'=> 'N', 'msg'=>'#DIGIPATTA008254 Some error occured, Could not generate digital Patta, Please try Again']);
        }
           
    }

    //method to save the digital patta without sign
    public function bulkApproveCasesOfDigitalPattaWithoutDigitalSign()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        // var_dump($_POST);
        // exit();
        $dhar_case_no_list = $_POST['selectedList'];
        $string = '';
        $dhar_case_no = '';
        $base64array = array();
        $entire_page='';

        foreach($dhar_case_no_list as $key => $dhar_case_no){
            $data['application_no'] = $application_no =$this->DigitalPattaCommonModel->getApplidFromCaseNo($dhar_case_no);
            $data['rtps_no'] = $rtps_no = $this->DigitalPattaCommonModel->getRtpsRefNo($application_no);
            $data['patta_info'] = $patta_info = $this->DigitalPattaCommonModel->getPattaInfo($application_no);
            if(!$data['patta_info']['result']){
                echo json_encode($data['patta_info']);
                exit;
            }
            $insert_all_data = $this->DigitalPattaCommonModel->insertAllDigitalPattaData($application_no,$rtps_no,$patta_info,$dhar_case_no);
            $data['base_64_qr'] = printQR("URL:https://sewasetu.assam.gov.in/"."\nApplication-No: ".$application_no."\nLease-Holder: ".$data['patta_info']['chitha_pattadar_applicant_data']->pdar_name_eng);
            $dist_code = $_POST['district_id'];
            $dag_no = $data['patta_info']['chitha_basic'][0]->old_dag_no;
            $data['dag_sketch_qr_code'] = printQR(BASUNDHARA_LIVE_URL."/DigitalPatta/getSketchOfTheDagForDigitalPatta/?dist_code=$dist_code&dag_no=$dag_no&app_no=$application_no");
            $string = $this->load->view('digitalPatta/digitalPatta', $data, true);
            $css ='';
            $css .= '<style>
                        .logo{
                            height : 15%!important; 
                            width : 15%!important;
                            text-align :center!important;
                        }
                        .logoEmblem{
                            height:100%!important;
                            width:100%!important;
                        }
                        .logoBorder{
                            border:0px;
                        }
                        .center-text{
                            text-align: center!important;
                            display: inline-block;
                        }
                        td, th, tbody{
                            border:1px solid;
                            border-collapse:collapse;
                            font-size:11px;
                        }
                        table {
                            border-collapse: collapse;
                        }
                        .himanxu-margin-top{
                            margin-top:1rem;
                        }
                        .himanxu-table-width-100{
                            width:100%!important;
                        }
                        .himanxu-heading-weight{
                            font-weight: 900;
                            background-color:#f2d0da!important;
                        }
                        .himanxu_header_red{
                            color:red!important;
                        }
                        .digital_patta_heading{
                            font-size:15px;
                            font-weight: bolder;
                            font-weight: 1200;
                            text-decoration: underline;
                        }
                        .himanxu_body_color_blue{
                            background-color: #d0e6f2!important;
                        }
                        .himanxu_body_color_maroon{
                            background-color: #e6caae!important;
                        }
                        .himanxu_body_color_purple{
                            background-color: #ded5e0!important;
                        }
                        .himanxu_body_color_green{
                            background-color: #e3fad7!important;
                        }
                        .himanxu_color_blue{
                            color:blue;
                        }
                        .himanxu_font_bold_heading{
                            font-weight:900!important;
                        }
                        .thick-head{
                            font-weight: bolder;
                            font-weight: 900;
                        }
                        .himanxuNotShowButton{
                            color:white;
                            display:none;
                        }
                    </style>';
           
            $entire_page = $string . $css;
            $base64 = $this->getPdfBase64Data(base64_encode($entire_page));
            $case_no = $dhar_case_no;
            $saved_data = $this->saveDigitalPattaWithoutSign($base64,$case_no);
        }
        echo json_encode($saved_data);
    }

    //method to save the digital patta without signing
    public function saveDigitalPattaWithoutSign($base64,$case_no)
    {
        $pdf_data = $base64;
        $case_no = $case_no;
        $digitalPattaName = "DIGITAL_PATTA";
        $application_no = $this->DigitalPattaCommonModel->getApplidFromCaseNo($case_no);
        $new_case_no = str_replace('/', "-", $case_no);
        $fileName    = $digitalPattaName.$new_case_no.date("Ymdhis");
        $base64PDFData = $pdf_data;
        $uploadpath   = DIGITAL_PATTA_FINAL_UPLOAD_DIR;
        $digital_patta_path = $uploadpath.$fileName;
        file_put_contents($uploadpath.$fileName.".pdf", base64_decode($base64PDFData));
        
        //$this->db->trans_begin();
        $digital_patta_insert_details = array(
            'application_no' => $application_no,
            'digital_patta_path' =>  $uploadpath.$fileName,
            'content_type' => 'pdf',
            'file_details' => $fileName,
            'case_no' => $case_no,
            'created_at' => date('Y-m-d'),
            'modified_at' => null,
            'user_code' => $this->session->all_userdata()['user_code'],
            'ip_address' => $this->utilityclass->get_client_ip(),
            'signed_time' => date('Y-m-d h:i:s'),
            'status' => 'A'
        );

        $insert_data = $this->DigitalPattaCommonModel->insertDigitalPattaDetails($digital_patta_insert_details);
        if($insert_data!= null && $insert_data['result'] =='Y'){
            $update_settlement_basic = $this->DigitalPattaCommonModel->updateSettlement_basic_and_digital_patta_all_data($case_no,$digital_patta_path);
            if($update_settlement_basic['result'] =='SUCCESS'){
                $this->db->trans_commit();
                return ['flag'=> 'Y', 'msg'=>'Digital Patta generated Successfully'];
            }else{
                $this->db->trans_rollback();
                log_message("error","#DIGIPATTA008257 Some error occured in updating data into settlement basic table for case no ".$case_no);
                return ['flag'=> 'N', 'msg'=>'#DIGIPATTA008257 Some error occured, Could not generate digital Patta, Please try Again'];
            }
        }else{
            $this->db->trans_rollback();
            log_message("error","DIGIPATTA008258 Some error occured in inserting data into digita patta table for case no ".$case_no);
            return ['flag'=> 'N', 'msg'=>'DIGIPATTA008258 Some error occured, Could not generate digital Patta, Please try Again'];
        }
           
    }

    //method to save the digital patta without sign
    public function bulkApproveCasesOfDigitalPattaWithoutDigitalSignWithoutPdf()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        // var_dump($_POST);
        // exit();
        $dhar_case_no_list = $_POST['selectedList'];
        $string = '';
        $dhar_case_no = '';
        $base64array = array();
        $entire_page='';
        $failed_case = array();
        
        $all_failed_case ='0';
        foreach($dhar_case_no_list as $key => $dhar_case_no){
            // $passed_cases = array();
            $data['application_no'] = $application_no =$this->DigitalPattaCommonModel->getApplidFromCaseNo($dhar_case_no);
            $data['rtps_no'] = $rtps_no = $this->DigitalPattaCommonModel->getRtpsRefNo($application_no);
            $data['patta_info'] = $patta_info = $this->DigitalPattaCommonModel->getPattaInfo($application_no);
            $check_partial = $this->DigitalPattaCommonModel->checkPartialPayment($dhar_case_no);
            if($check_partial == 'Y'){
                $check_chitha_update_status = $this->DigitalPattaCommonModel->checkChithaUpdateStatusForPartialPayment($dhar_case_no);
                if($check_chitha_update_status =='N'){
                    log_message("error","chitha not updated for case no".$dhar_case_no);
                    echo json_encode(['flag' => 'N', 'msg' =>"Chitha is not Updated for the case no: ".$dhar_case_no]);
                    exit;   
                }                

                $data['checkBasundhara']  = $this->DigitalPattaCommonModel->checkPartialPaymentStatusInBasundhara($application_no);
                if($data['checkBasundhara']['result'] =='SERVER-ERROR'){
                    echo json_encode(['flag' => 'N', 'msg' =>$data['checkBasundhara']['msg']]);
                    exit; 
                }
            }
            if(!$data['patta_info']['result']){
           
                //echo json_encode([$data['patta_info']]);
                //echo json_encode(['flag' => 'N', 'msg' =>$data['patta_info']['msg']]);
                array_push($failed_case,$data['patta_info']['case_no']);
                $all_failed_case = implode(",",$failed_case)."<br>";
                continue;
            }
            // else{
            //     array_push($passed_cases,$patta_info);
            // }
            $insert_all_data = $this->DigitalPattaCommonModel->insertAllDigitalPattaDataWithoutPdf($application_no,$rtps_no,$patta_info,$dhar_case_no);
         
            if($insert_all_data['result'] == 'SERVER-ERROR'){
                echo json_encode(['flag' => 'N', 'msg' =>$insert_all_data['msg']]);
                exit;
            }
            
        }
        if($all_failed_case == null){
            $all_failed_case ='0';
        }
        echo json_encode(['flag' => 'Y', 'msg' =>"Process completed... <br><br>Failed cases: $all_failed_case !"]);
    }

    public function digitalPattaView()
    {

        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['_view'] = 'digitalPatta/view_digital_patta';
        $this->load->view('layouts/main',$data);
    }

    public function getAllDigitalPattaViewDetails()
    {
        $json = null;
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $cases_list = $this->DigitalPattaCommonModel->viewAllCasesDigitalPatta($dist_code,$start, $length, $order);
        
        if(!empty($cases_list)) {
    
          if($cases_list['total_records'] > 0){
    
            $data_rows = $cases_list['data_results'];
    
            foreach($data_rows as $row) {
    
                $case_no = "<small class='case-no-bg'><i class='fa fa-archive'></i>" . $row->case_no . "</small>";
                $appl_no = "<small class='case-no-bg'><i class='fa fa-archive'></i>" . $row->applid . "</small>";
                $service = "<small class='case-no-bg'><i class='fa fa-archive'></i>" . $this->utilityclass->getServiceName($row->service_code). "</small>";

                $dated_at = date('d-M-Y',strtotime($row->date_entry));
                $created_at = "<small class='case-no-bg'><i class='fa fa-clock'></i>" . $dated_at . "</small>";

                $district = "<small class='case-no-bg'>" . $this->utilityclass->getDistrictName($row->dist_code) . "</small>";

                $circle = "<small class='case-no-bg'>" . $this->utilityclass->getCircleName($row->dist_code,$row->subdiv_code,$row->cir_code) . "</small>";
                $village = "<small class='case-no-bg'>" . $this->utilityclass->getVillageName($row->dist_code,$row->subdiv_code,$row->cir_code,$row->mouza_pargona_code,$row->lot_no,$row->vill_townprt_code) . "</small>";
                
                $view_link = BASUNDHARA_LIVE_URL."/DigitalPatta/View?dc=".$row->dist_code."&app_no=".$this->DigitalPattaLocationModel->encryptJwtCase($row->applid);

                //$view_link = BASUNDHARA_URL."/DigitalPatta/View?dc=07&app_no=".$this->DigitalPattaLocationModel->encryptJwtCase($row->cir_code);

                $button1 = '<a href="'.$view_link.'" class="btn btn-info btn-sm" target= "_blank" role="button">VIEW DIGITAL PATTA</a>';

               // $button1 = '<button type="button" class="btn btn-sm btn-success" onclick="DigitalPattaPreview(\'' . $row->dist_code . '\', \'' . $row->applid . '\')"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;View</button>';
                //$button2 = '<button type="button" class="btn btn-sm btn-success" onclick="viewDigitalPatta(\'' . $row->case_no . '\', \'' . $row->dist_code . '\')"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;Download</button>';
              
              $json[] = array(
                    $row->case_no,
                    $case_no,
                    $appl_no,
                    $service,
                    $created_at,
                    $district,
                    $circle,
                    $village,
                    $button1,
              );
            }
          }
          else {
            $json = "";
          }      
        $total_records = $cases_list['total_records'];
          $response = array(
            'draw'              => $draw,
            'recordsTotal'      => $total_records,
            'recordsFiltered'   => $total_records,
            'data'              => $json
          );
          echo json_encode($response);
        }
        else
        {
          $response = array();
          $response['sEcho']=0;
          $response['iTotalRecords']=0;
          $response['iTotalDisplayRecords']=0;
          $response['aaData']=[];
          echo json_encode($response);
        }
    }

    public function digitalPattaViewForCo()
    {
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['cir_code'] = $cir_code = $this->session->userdata('cir_code');
        $data['locationCo'] = $locationCo =  $this->digitalPattaLocationModel->getDigitalPattaVillageList($dist_code, $subdiv_code, $cir_code);
        $data['_view'] = 'digitalPatta/co_landing_page';
        $this->load->view('layouts/main',$data);
    }

    public function getAllDigitalPattaInCoLogin()
    {
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['cir_code'] = $cir_code = $this->session->userdata('cir_code');
        $json = null;
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');
        $uuid = $this->input->post('village_list_dp');

        $mouza_pargona_code = null;
        $lot_no = null;
        $vill_townprt_code = null;

        if(!empty($uuid)){
            $getLocation = $this->digitalPattaLocationModel->getLocationByUUID($uuid);
            $mouza_pargona_code = $getLocation->mouza_pargona_code;
            $lot_no = $getLocation->lot_no;
            $vill_townprt_code = $getLocation->vill_townprt_code;
        }
        $cases_list = $this->DigitalPattaCommonModel->viewAllCasesInCoLoginDigitalPatta($start, $length, $order,$dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code);
        
        if(!empty($cases_list)) {
    
          if($cases_list['total_records'] > 0){
    
            $data_rows = $cases_list['data_results'];
    
            foreach($data_rows as $row) {
    
                $case_no = "<small class='case-no-bg'><i class='fa fa-archive'></i>" . $row->case_no . "</small>";
                $appl_no = "<small class='case-no-bg'><i class='fa fa-archive'></i>" . $row->applid . "</small>";
    
                $service = "<small class='case-no-bg'><i class='fa fa-archive'></i>" . $this->utilityclass->getServiceName($row->service_code). "</small>";

                $dated_at = date('d-M-Y',strtotime($row->date_entry));
                $created_at = "<small class='case-no-bg'><i class='fa fa-clock'></i>" . $dated_at . "</small>";

                $district = "<small class='case-no-bg'>" . $this->utilityclass->getDistrictName($row->dist_code) . "</small>";

                $circle = "<small class='case-no-bg'>" . $this->utilityclass->getCircleName($row->dist_code,$row->subdiv_code,$row->cir_code) . "</small>";
                $village = "<small class='case-no-bg'>" . $this->utilityclass->getVillageName($row->dist_code,$row->subdiv_code,$row->cir_code,$row->mouza_pargona_code,$row->lot_no,$row->vill_townprt_code) . "</small>";
                $view_link = BASUNDHARA_LIVE_URL."/DigitalPatta/View?dc=".$row->dist_code."&app_no=".$this->digitalPattaLocationModel->encryptJwtCase($row->applid);

                //$view_link = BASUNDHARA_URL."/DigitalPatta/View?dc=07&app_no=".$this->DigitalPattaLocationModel->encryptJwtCase($row->cir_code);

                $button1 = '<a href="'.$view_link.'" class="btn btn-info btn-sm" target= "_blank" role="button">VIEW DIGITAL PATTA</a>';

                // $button1 = '<button type="button" class="btn btn-sm btn-success" onclick="DigitalPattaPreview(\'' . $row->dist_code . '\', \'' . $row->applid . '\')"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;View</button>';
                //$button2 = '<button type="button" class="btn btn-sm btn-success" onclick="viewDigitalPatta(\'' . $row->case_no . '\', \'' . $row->dist_code . '\')"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;Download</button>';
              
              $json[] = array(
                    $row->case_no,
                    $case_no,
                    $appl_no,
                    $service,
                    $created_at,
                    $district,
                    $circle,
                    $village,
                    $button1,
              );
            }
          }
          else {
            $json = "";
          }      
        $total_records = $cases_list['total_records'];
          $response = array(
            'draw'              => $draw,
            'recordsTotal'      => $total_records,
            'recordsFiltered'   => $total_records,
            'data'              => $json
          );
          echo json_encode($response);
        }
        else
        {
          $response = array();
          $response['sEcho']=0;
          $response['iTotalRecords']=0;
          $response['iTotalDisplayRecords']=0;
          $response['aaData']=[];
          echo json_encode($response);
        }
    }

}
?>