<?php

class DigitalPattaNC extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'Language'));
        $this->load->library('form_validation');
        $this->load->model('digitalPatta/DigitalPattaCommonNcModel');
        $this->load->model('digitalPatta/digitalPattaLocationModel');
        $this->load->model('UtilsModel');
        $this->load->helper('qrcode');
    }

    //db_switch method
    public function dbswitch()
    {
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



        if(HOLD_All_MB3_CASES_STATUS == 1)
        {
            if(strtotime(HOLD_All_MB3_CASES_DATE) < strtotime(date('Y-m-d H:i:s')))
            {
                $this->session->set_flashdata('message', " Processing of settlement MB 3.0 Cases has been stopped !");
                redirect(base_url() . "index.php/Home/index");
            }
        }

        $allowed = ['DC'];
        $user_desig_code = $this->session->userdata('user_desig_code');
        if(! in_array($user_desig_code, $allowed))
        {
            $this->session->set_flashdata('message', "#MRNC001 : Unauthorized access");
            redirect(base_url() . "index.php/home");
        }

    }


    // code by Masud Reza 29/07/2025


    // checking login user access
    public function checkingLoginUserAccessSingleUserOnlyDC()
    {
        $allowed = [MB_DEPUTY_COMM];
        $user_desig_code = $this->session->userdata('user_desig_code');
        if(! in_array($user_desig_code, $allowed))
        {
            $this->session->set_flashdata('message', "#MRNC001 : Unauthorized access");
            redirect(base_url() . "index.php/home");
        }
    }



    // landing page
    public function digitalPattaLandingPage()
    {
        $this->checkingLoginUserAccessSingleUserOnlyDC();
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['certificate'] = "digital_sign";//$this->DigitalPattaCommonNcModel->getDscSignCertificate($dist_code);
        $data['_view'] = 'digitalPatta/landing_page_nc';
        $this->load->view('layouts/main',$data);
    }


    // getting all digital patta details (datatable list)
    public function getAllDigitalPattaDetails()
    {
        $this->checkingLoginUserAccessSingleUserOnlyDC();
        $json   = null;
        $draw   = intval($this->input->post('draw'));
        $start  = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order  = $this->input->post('order');
        $cases_list = $this->DigitalPattaCommonNcModel->getAllCasesDigitalPatta($start, $length, $order);
        if(!empty($cases_list))
        {
            if($cases_list['total_records'] > 0)
            {
                $data_rows = $cases_list['data_results'];

                foreach($data_rows as $row)
                {
                    $case_no    = "<small class='case-no-bg'><i class='fa fa-archive'></i> " . $row->case_no . "</small> <br>".
                        "<small class='case-no-bg' style='color: #6A1B9A'><i class='fa fa-archive'></i> ". $row->applid .  "</small>";
                    $service    = "<small class='case-no-bg'> " . $this->utilityclass->getServiceName($row->service_code). "</small>";
                    $dated_at   = date('d-M-Y',strtotime($row->date_entry));
                    $created_at = "<small class='case-no-bg'><i class='fa fa-clock'></i> " . $dated_at . "</small>";
                    $district   = "<small class='case-no-bg'>" . $this->utilityclass->getDistrictName($row->dist_code) . "</small>";
                    $circle     = "<small class='case-no-bg'>" . $this->utilityclass->getCircleName($row->dist_code,$row->subdiv_code,$row->cir_code) . "</small>";
                    $village    = "<small class='case-no-bg'>" . $this->utilityclass->getVillageName($row->dist_code,$row->subdiv_code,$row->cir_code,$row->mouza_pargona_code,$row->lot_no,$row->vill_townprt_code) . "</small>";
                    $button1    = '<button type="button" class="rezaButt buttInfo" onclick="viewDigitalPatta(\'' . $row->case_no . '\', \'' . $row->dist_code . '\')"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;View</button>';

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


    // method to view the digital patta and display in modal
    public function getDigitalPattaDetails()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('case_no', 'Case Number', 'trim|required');
        $this->form_validation->set_rules('dist_code', 'District Name', 'trim|required');
        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        }

        $this->checkingLoginUserAccessSingleUserOnlyDC();
        $dhar_case_no = trim($this->input->post('case_no'));
        $dist_code    = trim($this->session->userdata('dist_code'));
        $caseCount    = $this->DigitalPattaCommonNcModel->caseForDcApprovalNc($dhar_case_no,$dist_code);
        if($caseCount == 0)
        {
            echo json_encode(array(
                'responseType' => 3,
                'msg'          => "#MRPC0002 : Case not found in records !"
            ));
            return;
        }
        $data['application_no'] = $application_no = $this->DigitalPattaCommonNcModel->getApplidFromCaseNo($dhar_case_no);
        $data['rtps_ref_no']    = $rtps_no        = $this->DigitalPattaCommonNcModel->getRtpsRefNo($application_no);
        $patta_info_details     = $this->DigitalPattaCommonNcModel->getPattaInfo($application_no);
        $data['patta_info']     = $patta_info_details;

        if(!$data['patta_info']['result'])
        {
            echo json_encode($data['patta_info']);
            exit;
        }


        $lat = $data['patta_info']['co_ordinates']->lat;
        $lng = $data['patta_info']['co_ordinates']->long;


        $parts    = explode("/", $rtps_no);
        $lastPart = array_pop($parts);
        $randomDigits = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        $parts[] = $randomDigits . $lastPart;
        $modified_application_no = implode("/", $parts);
        $appNo = base64_encode($modified_application_no);

        $data['base_64_qr_geo_cordinates'] = printQR("https://basundhara.assam.gov.in/rtpsmb/QRData/viewgeocordinates?dc=" . $dist_code . "&app_no=" . $appNo);
        $data['base_64_qr_sketch']         = printQR("https://basundhara.assam.gov.in/rtpsmb/QRData/viewgeocordinatesSketch?dc=" . $dist_code . "&app_no=" . $appNo);
        $data['base_64_qr_google']         = printQR("https://www.google.com/maps/place/" . $lat . "," . $lng);
        $data['dag_sketch_qr_photos']      = printQR("https://basundhara.assam.gov.in/rtpsmb/QRData/getSketchOfTheDagForDigitalPatta?dc=$dist_code&app_no=$appNo");
        $data['base_64_qr']                = printQR("https://basundhara.assam.gov.in/rtpsmb/QRData/viewCertificate?dc=" . $dist_code . "&app_no=" . $appNo);

        $string                     = $this->load->view('digitalPatta/digitalPatta_nc', $data, true);

        echo json_encode($string);
    }


    // method to save the digital patta without sign  used
    public function bulkApproveCasesOfDigitalPattaWithoutDigitalSignWithoutPdf()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->checkingLoginUserAccessSingleUserOnlyDC();
        $dhar_case_no_list  = $_POST['selectedList'];
        $string             = '';
        $dhar_case_no       = '';
        $base64array        = array();
        $entire_page        = '';
        $failed_case        = array();
        $all_failed_case    = '0';
        $dist_code          = $this->session->userdata('dist_code');

        foreach($dhar_case_no_list as $key => $dhar_case_no)
        {
            $data['application_no'] = $application_no = $this->DigitalPattaCommonNcModel->getApplidFromCaseNo($dhar_case_no);
            $data['rtps_no']        = $rtps_no        = $this->DigitalPattaCommonNcModel->getRtpsRefNo($application_no);
            $data['patta_info']     = $patta_info     = $this->DigitalPattaCommonNcModel->getPattaInfo($application_no);
            $check_partial          = $this->DigitalPattaCommonNcModel->checkPartialPayment($dhar_case_no);

            // check bhunaksha_svamitva_cases table
            $countBhunaksha = $this->DigitalPattaCommonNcModel->checkBhunakshaSvamitvaCase($dist_code,$dhar_case_no);
            if($countBhunaksha == 0)
            {
                log_message("error","#MRPRN10002: Processing failed for Case No: 
                    . $dhar_case_no. ' Please check the case details.");
                echo json_encode(['flag' => 'E', 'msg' => '#MRPRN10002: Processing failed for Case No: '
                    . $dhar_case_no. ' Please check the case details.']);
                exit;
            }

            if($check_partial == 'Y')
            {
                $check_chitha_update_status = $this->DigitalPattaCommonNcModel->checkChithaUpdateStatusForPartialPayment($dhar_case_no);
                if($check_chitha_update_status =='N')
                {
                    log_message("error","chitha not updated for case no".$dhar_case_no);
                    echo json_encode(['flag' => 'N', 'msg' =>"Chitha is not Updated for the case no: ".$dhar_case_no]);
                    exit;
                }

                $data['checkBasundhara']  = $this->DigitalPattaCommonNcModel->checkPartialPaymentStatusInBasundhara($application_no);
                if($data['checkBasundhara']['result'] =='SERVER-ERROR')
                {
                    echo json_encode(['flag' => 'N', 'msg' =>$data['checkBasundhara']['msg']]);
                    exit;
                }
            }
            if(!$data['patta_info']['result'])
            {
                array_push($failed_case,$data['patta_info']['case_no']);
                $all_failed_case = implode(",",$failed_case)."<br>";
                continue;
            }
            $insert_all_data = $this->DigitalPattaCommonNcModel->insertAllDigitalPattaDataWithoutPdf($application_no,$rtps_no,$patta_info,$dhar_case_no,$dist_code);
            if($insert_all_data['result'] == 'SERVER-ERROR')
            {
                echo json_encode(['flag' => 'N', 'msg' =>$insert_all_data['msg']]);
                exit;
            }

        }
        if($all_failed_case == null)
        {
            $all_failed_case ='0';
        }
        echo json_encode(['flag' => 'Y', 'msg' =>"Process completed... <br><br>Failed cases: $all_failed_case !"]);
    }



    // view Issued property card List data table
    public function digitalPattaView()
    {
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['_view'] = 'digitalPatta/view_digital_patta_nc';
        $this->load->view('layouts/main',$data);
    }

    // view Issued property card  API
    public function getAllDigitalPattaViewDetails()
    {
        $json   = null;
        $draw   = intval($this->input->post('draw'));
        $start  = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order  = $this->input->post('order');
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $cases_list = $this->DigitalPattaCommonNcModel->viewAllCasesDigitalPatta($dist_code,$start, $length, $order);

        if(!empty($cases_list))
        {
            if($cases_list['total_records'] > 0)
            {
                $data_rows = $cases_list['data_results'];
                foreach($data_rows as $row)
                {
                    $case_no    = "<small class='case-no-bg'><i class='fa fa-archive'></i> " . $row->case_no . "</small> <br>".
                        "<small class='case-no-bg' style='color: #6A1B9A'><i class='fa fa-archive'></i> " . $row->applid . "</small>";
                    $service    = "<small class='case-no-bg'></i>" . $this->utilityclass->getServiceName($row->service_code). "</small>";
                    $dated_at   = date('d-M-Y',strtotime($row->date_entry));
                    $created_at = "<small class='case-no-bg'><i class='fa fa-clock'></i>" . $dated_at . "</small>";
                    $district   = "<small class='case-no-bg'>" . $this->utilityclass->getDistrictName($row->dist_code) . "</small>";
                    $circle     = "<small class='case-no-bg'>" . $this->utilityclass->getCircleName($row->dist_code,$row->subdiv_code,$row->cir_code) . "</small>";
                    $village    = "<small class='case-no-bg'>" . $this->utilityclass->getVillageName($row->dist_code,$row->subdiv_code,$row->cir_code,$row->mouza_pargona_code,$row->lot_no,$row->vill_townprt_code) . "</small>";
                    $button1    = '<button type="button" class="rezaButt buttInfo" onclick="viewDigitalPatta(\'' . enc_param('case_no', $row->case_no, 600) . '\')"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;View</button>';


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
            else
            {
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


    // method to view the digital patta and display in new Page
    public function getDigitalPattaDetailsForPrint()
    {
        $case_no   = trim($this->input->get('case_no'));
        $dist_code = trim($this->session->userdata('dist_code'));
        if (empty($case_no) || empty($dist_code))
        {
            show_error("Missing required parameters", 400);
        }

        $this->checkingLoginUserAccessSingleUserOnlyDC();
        $dhar_case_no = trim(dec_param($this->input->get('case_no'), 'case_no'));
        $dist_code    = trim($this->session->userdata('dist_code'));
        $caseCount    = $this->DigitalPattaCommonNcModel->caseForDcApprovalNcPrint($dhar_case_no,$dist_code);

        if($caseCount == 0)
        {
            echo json_encode(array(
                'responseType' => 3,
                'msg'          => "#MRPC0004 : Case not found in records !"
            ));
            return;
        }
        $data['application_no'] = $application_no = $this->DigitalPattaCommonNcModel->getApplidFromCaseNo($dhar_case_no);
        $data['rtps_ref_no']    = $rtps_no        = $this->DigitalPattaCommonNcModel->getRtpsRefNo($application_no);
        $patta_info_details     = $this->DigitalPattaCommonNcModel->getPattaInfoPrint($application_no);
        $data['patta_info']     = $patta_info_details;

        if(!$data['patta_info']['result'])
        {
            echo json_encode($data['patta_info']);
            exit;
        }

        $lat = $data['patta_info']['co_ordinates']->lat;
        $lng = $data['patta_info']['co_ordinates']->long;

        $parts    = explode("/", $rtps_no);
        $lastPart = array_pop($parts);
        $randomDigits = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        $parts[] = $randomDigits . $lastPart;
        $modified_application_no = implode("/", $parts);
        $appNo = base64_encode($modified_application_no);

        $data['base_64_qr_geo_cordinates'] = printQR("https://basundhara.assam.gov.in/rtpsmb/QRData/viewgeocordinates?dc=" . $dist_code . "&app_no=" . $appNo);
        $data['base_64_qr_sketch']         = printQR("https://basundhara.assam.gov.in/rtpsmb/QRData/viewgeocordinatesSketch?dc=" . $dist_code . "&app_no=" . $appNo);
        $data['base_64_qr_google']         = printQR("https://www.google.com/maps/place/" . $lat . "," . $lng);
        $data['dag_sketch_qr_photos']      = printQR("https://basundhara.assam.gov.in/rtpsmb/QRData/getSketchOfTheDagForDigitalPatta?dc=$dist_code&app_no=$appNo");
        $data['base_64_qr']                = printQR("https://basundhara.assam.gov.in/rtpsmb/QRData/viewCertificate?dc=" . $dist_code . "&app_no=" . $appNo);


        $this->load->view('digitalPatta/digitalPatta_nc_print',$data);

    }



    // print multiple property card
    public function bulkPropertyCardViewOrPrintNc()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->checkingLoginUserAccessSingleUserOnlyDC();
        $dhar_case_no_list  = $_POST['selectedList'];
        $dist_code          = trim($this->session->userdata('dist_code'));

        if (count($dhar_case_no_list) == 0)
        {
            $json = [
                'responseType' => 3,
                'message' => "#MRPC0005: Kindly select a case to proceed ! ",
            ];
            echo json_encode($json);
            return;
        }
        if (count($dhar_case_no_list) > DIGITAL_PATTA_CHECK_LIMIT_NC)
        {
            $mm = DIGITAL_PATTA_CHECK_LIMIT_NC;
            $json = [
                'responseType' => 3,
                'msg'          => "#MRPC0006 : ailed to generate notice. Selection Limit ' $mm ' Only ! "
            ];
            echo json_encode($json);
            return;
        }
        foreach ($dhar_case_no_list as $case)
        {
            $dhar_case_no = trim($case);
            $caseCount    = $this->DigitalPattaCommonNcModel->caseForDcApprovalNcPrint($dhar_case_no,$dist_code);

            if($caseCount == 0)
            {
                echo json_encode(array(
                    'responseType' => 3,
                    'msg'          => "#MRPC0007 : Case Number ' $dhar_case_no ' not found in records ! "
                ));
                return;
            }
        }

        $caseParam = implode(",", $dhar_case_no_list);

        $caseParamEncode = enc_param('case_no', $caseParam, 600);

        echo json_encode([
            'responseType' => 2,
            'url' => site_url("DigitalPattaNC/getBulkPropertyCardViewOrPrintNc?cases={$caseParamEncode}")
        ]);
    }


    public function getBulkPropertyCardViewOrPrintNc()
    {
        $caseListEn = $this->input->get('cases');
        $this->checkingLoginUserAccessSingleUserOnlyDC();
        if (empty($caseListEn))
        {
            $data['errorCode'] = 'MRNCPC001';
            $data['errorMsg']  = 'Missing required parameters';
            $this->load->view('digitalPatta/digitalPatta_nc_error',$data);
            return;
        }

        $case_list = trim(dec_param($caseListEn, 'case_no'));
        $cases     = explode(",", $case_list);
        $dist_code = trim($this->session->userdata('dist_code'));

        $data['dist_code'] = $dist_code;
        if (count($cases) > DIGITAL_PATTA_CHECK_LIMIT_NC)
        {
            $mm = DIGITAL_PATTA_CHECK_LIMIT_NC;
            $data['errorCode'] = 'MRNCPC002';
            $data['errorMsg']  = "Ailed to generate notice. Selection Limit ' $mm ' Only ! ";
            $this->load->view('digitalPatta/digitalPatta_nc_error',$data);
            return;
        }


        foreach ($cases as $case)
        {
            $dhar_case_no = trim($case);
            $caseCount    = $this->DigitalPattaCommonNcModel->caseForDcApprovalNcPrint($dhar_case_no,$dist_code);

            if($caseCount == 0)
            {
                $data['errorCode'] = 'MRNCPC003';
                $data['errorMsg']  = "Case Number ' $dhar_case_no ' not found in records !  ";
                $this->load->view('digitalPatta/digitalPatta_nc_error',$data);
                return;
            }


            $application_no = $this->DigitalPattaCommonNcModel->getApplidFromCaseNo($dhar_case_no);
            $rtps_no        = $this->DigitalPattaCommonNcModel->getRtpsRefNo($application_no);
            $patta_info     = $this->DigitalPattaCommonNcModel->getPattaInfoPrint($application_no);
            if($patta_info['responseType'] == 2)
            {
                $lat = $patta_info['co_ordinates']->lat;
                $lng = $patta_info['co_ordinates']->long;

                // create modified application no for QR
                $parts = explode("/", $rtps_no);
                $lastPart = array_pop($parts);
                $randomDigits = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
                $parts[] = $randomDigits . $lastPart;
                $modified_application_no = implode("/", $parts);
                $appNo = base64_encode($modified_application_no);

                $caseData = [
                    'case_no'                   => $dhar_case_no,
                    'application_no'            => $application_no,
                    'rtps_ref_no'               => $rtps_no,
                    'patta_info'                => $patta_info,
                    'base_64_qr_geo_cordinates' => printQR("https://basundhara.assam.gov.in/rtpsmb/QRData/viewgeocordinates?dc=$dist_code&app_no=$appNo"),
                    'base_64_qr_sketch'         => printQR("https://basundhara.assam.gov.in/rtpsmb/QRData/viewgeocordinatesSketch?dc=$dist_code&app_no=$appNo"),
                    'base_64_qr_google'         => printQR("https://www.google.com/maps/place/$lat,$lng"),
                    'dag_sketch_qr_photos'      => printQR("https://basundhara.assam.gov.in/rtpsmb/QRData/getSketchOfTheDagForDigitalPatta?dc=$dist_code&app_no=$appNo"),
                    'base_64_qr'                => printQR("https://basundhara.assam.gov.in/rtpsmb/QRData/viewCertificate?dc=$dist_code&app_no=$appNo"),
                ];

                $data['cases'][] = $caseData;
            }
            else
            {
                $data['errorCode'] = 'MRNCPC004';
                $data['errorMsg']  = $patta_info['msg'];
                $this->load->view('digitalPatta/digitalPatta_nc_error',$data);
                return;
            }

            if (!$patta_info['result'])
            {
                $data['errorCode'] = 'MRNCPC005';
                $data['errorMsg']  = $patta_info['msg'];
                $this->load->view('digitalPatta/digitalPatta_nc_error',$data);
                return;
            }


        }

        $this->load->view('digitalPatta/digitalPatta_nc_print_multi', $data);
    }










    //method to generate the digital patta and digitally sign in bulk
    public function bulkSignOfDigitalPatta()
    {

        $this->checkingLoginUserAccessSingleUserOnlyDC();
        $_POST = json_decode(file_get_contents("php://input"), true);
        $dhar_case_no_list = $_POST['selectedList'];
        $string       = '';
        $dhar_case_no = '';
        $base64array  = array();
        $entire_page  = '';
        $this->db->trans_begin();
        foreach($dhar_case_no_list as $key => $dhar_case_no)
        {
            $data['application_no'] = $application_no = $this->DigitalPattaCommonNcModel->getApplidFromCaseNo($dhar_case_no);
            $data['rtps_no']        = $rtps_no        = $this->DigitalPattaCommonNcModel->getRtpsRefNo($application_no);
            $data['patta_info']     = $patta_info     = $this->DigitalPattaCommonNcModel->getPattaInfo($application_no);
            if(!$data['patta_info']['result'])
            {
                echo json_encode($data['patta_info']);
                exit;
            }
            $insert_all_data    = $this->DigitalPattaCommonNcModel->insertAllDigitalPattaData($application_no,$rtps_no,$patta_info,$dhar_case_no);
            $data['base_64_qr'] = printQR("URL:https://sewasetu.assam.gov.in/"."\nApplication-No: ".$application_no."\nLease-Holder: ".$data['patta_info']['chitha_pattadar_applicant_data']->pdar_name_eng);
            $dist_code          = $_POST['dist_code'];
            $dag_no             = $data['patta_info']['chitha_basic'][0]->old_dag_no;
            $data['dag_sketch_qr_code'] = printQR(BASUNDHARA_LIVE_URL."/DigitalPatta/getSketchOfTheDagForDigitalPatta/?dist_code=$dist_code&dag_no=$dag_no&app_no=$application_no");
            $string = $this->load->view('digitalPatta/digitalPatta_nc', $data, true);
            $css  ='';
            $css .= '<style>
                        .logo{
                            height : 15%!important; 
                            width : 14%!important;
                            text-align :center!important;
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
                         .reza-header-red {
                            font-weight: bold!important;
                            text-align: center!important;
                        }
                    
                        .reza-table {
                            width: 100%!important;
                            border-collapse: collapse!important;
                        }
                    
                        .reza-table th,
                        .reza-table td {
                            border: 1px solid black!important;
                            padding: 6px!important;
                            vertical-align: middle!important;
                        }
                    
                        .reza-table th {
                            text-align: center!important;
                            font-weight: bold!important;
                        }
                    </style>';

            $entire_page = $string . $css;
            $base64array[$key]['base64'] = $this->getPdfBase64Data(base64_encode($entire_page));
            $base64array[$key]['case_no'] = $dhar_case_no;
        }

        $this->db->trans_commit();
        echo json_encode($base64array);
    }


    //method to generate the pdf base64
    public function getPdfBase64Data($htmbase64Encoded)
    {
        include 'vendor/mpdf/vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetWatermarkText('PROPERTY CARD (NC)');
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
        $this->checkingLoginUserAccessSingleUserOnlyDC();
        $pdf_data           = trim($this->input->post('pdfData'));
        $case_no            = trim($this->input->post('case_no'));
        $digitalPattaName   = "PROPERTY_CARD_NC";
        $application_no     = $this->DigitalPattaCommonNcModel->getApplidFromCaseNo($case_no);
        $new_case_no        = str_replace('/', "-", $case_no);
        $fileName           = $digitalPattaName.$new_case_no.date("Ymdhis");
        $base64PDFData      = $pdf_data;
        $uploadpath         = DIGITAL_PATTA_FINAL_UPLOAD_DIR;
        $digital_patta_path = $uploadpath.$fileName;
        file_put_contents($uploadpath.$fileName.".pdf", base64_decode($base64PDFData));

        //$this->db->trans_begin();
        $digital_patta_insert_details = array(
            'application_no'     => $application_no,
            'digital_patta_path' => $uploadpath.$fileName,
            'content_type'       => 'pdf',
            'file_details'       => $fileName,
            'case_no'            => $case_no,
            'created_at'         => date('Y-m-d'),
            'modified_at'        => null,
            'user_code'          => $this->session->all_userdata()['user_code'],
            'ip_address'         => $this->utilityclass->get_client_ip(),
            'signed_time'        => date('Y-m-d h:i:s'),
            'status'             => 'A'
        );

        $insert_data = $this->DigitalPattaCommonNcModel->insertDigitalPattaDetails($digital_patta_insert_details);
        if($insert_data!= null && $insert_data['result'] =='Y')
        {
            $update_settlement_basic = $this->DigitalPattaCommonNcModel->updateSettlement_basic_and_digital_patta_all_data($case_no,$digital_patta_path);
            if($update_settlement_basic['result'] =='SUCCESS')
            {
                $this->db->trans_commit();
                echo json_encode(['flag'=> 'Y', 'msg'=>'Property Card generated Successfully']);
            }
            else
            {
                $this->db->trans_rollback();
                log_message("error","#DIGIPATTA008253 Some error occurred in updating data into settlement basic table for case no ".$case_no);
                echo json_encode(['flag'=> 'N', 'msg'=>'#DIGIPATTA008253 Some error occurred, Could not generate Property Card, Please try Again']);
            }
        }
        else
        {
            $this->db->trans_rollback();
            log_message("error","#DIGIPATTA008254 Some error occurred in inserting data into digital patta table for case no ".$case_no);
            echo json_encode(['flag'=> 'N', 'msg'=>'#DIGIPATTA008254 Some error occurred, Could not generate Property Card, Please try Again']);
        }

    }


    //method to save the digital patta without sign
    public function bulkApproveCasesOfDigitalPattaWithoutDigitalSign()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $dhar_case_no_list = $_POST['selectedList'];
        $string       = '';
        $dhar_case_no = '';
        $base64array  = array();
        $entire_page  = '';

        foreach($dhar_case_no_list as $key => $dhar_case_no)
        {
            $data['application_no'] = $application_no = $this->DigitalPattaCommonNcModel->getApplidFromCaseNo($dhar_case_no);
            $data['rtps_no']        = $rtps_no        = $this->DigitalPattaCommonNcModel->getRtpsRefNo($application_no);
            $data['patta_info']     = $patta_info     = $this->DigitalPattaCommonNcModel->getPattaInfo($application_no);
            if(!$data['patta_info']['result'])
            {
                echo json_encode($data['patta_info']);
                exit;
            }
            $insert_all_data = $this->DigitalPattaCommonNcModel->insertAllDigitalPattaData($application_no,$rtps_no,$patta_info,$dhar_case_no);
            $data['base_64_qr'] = printQR("URL:https://sewasetu.assam.gov.in/"."\nApplication-No: ".$application_no."\nLease-Holder: ".$data['patta_info']['chitha_pattadar_applicant_data']->pdar_name_eng);
            $dist_code = $_POST['district_id'];
            $dag_no = $data['patta_info']['chitha_basic'][0]->old_dag_no;
            $data['dag_sketch_qr_code'] = printQR(BASUNDHARA_LIVE_URL."/DigitalPatta/getSketchOfTheDagForDigitalPatta/?dist_code=$dist_code&dag_no=$dag_no&app_no=$application_no");
            $string = $this->load->view('digitalPatta/digitalPatta_nc', $data, true);
            $css ='';
            $css .= '<style>
                        .logo{
                            height : 15%!important; 
                            width : 14%!important;
                            text-align :center!important;
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
                        .reza-header-red {
                            font-weight: bold!important;
                            text-align: center!important;
                        }                    
                        .reza-table {
                            width: 100%!important;
                            border-collapse: collapse!important;
                        }                    
                        .reza-table th,
                        .reza-table td {
                            border: 1px solid black!important;
                            padding: 6px!important;
                            vertical-align: middle!important;
                        }                    
                        .reza-table th {
                            text-align: center!important;
                            font-weight: bold!important;
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
        $pdf_data           = $base64;
        $case_no            = trim($case_no);
        $digitalPattaName   = "PROPERTY_CARD";
        $application_no     = $this->DigitalPattaCommonNcModel->getApplidFromCaseNo($case_no);
        $new_case_no        = str_replace('/', "-", $case_no);
        $fileName           = $digitalPattaName.$new_case_no.date("Ymdhis");
        $base64PDFData      = $pdf_data;
        $uploadpath         = DIGITAL_PATTA_FINAL_UPLOAD_DIR;
        $digital_patta_path = $uploadpath.$fileName;
        file_put_contents($uploadpath.$fileName.".pdf", base64_decode($base64PDFData));

        $this->db->trans_begin();
        $digital_patta_insert_details = array(
            'application_no'        => $application_no,
            'digital_patta_path'    => $uploadpath.$fileName,
            'content_type'          => 'pdf',
            'file_details'          => $fileName,
            'case_no'               => $case_no,
            'created_at'            => date('Y-m-d'),
            'modified_at'           => null,
            'user_code'             => $this->session->all_userdata()['user_code'],
            'ip_address'            => $this->utilityclass->get_client_ip(),
            'signed_time'           => date('Y-m-d h:i:s'),
            'status'                => 'A',
            'nc'                    => 1
        );

        $insert_data = $this->DigitalPattaCommonNcModel->insertDigitalPattaDetails($digital_patta_insert_details);
        if($insert_data!= null && $insert_data['result'] =='Y')
        {
            $update_settlement_basic = $this->DigitalPattaCommonNcModel->updateSettlement_basic_and_digital_patta_all_data($case_no,$digital_patta_path);
            if($update_settlement_basic['result'] =='SUCCESS')
            {
                $this->db->trans_commit();
                return ['flag'=> 'Y', 'msg'=>'Property Card generated Successfully'];
            }
            else
            {
                $this->db->trans_rollback();
                log_message("error","#DIGIPATTA008257 Some error occurred in updating data into settlement basic table for case no ".$case_no);
                return ['flag'=> 'N', 'msg'=>'#DIGIPATTA008257 Some error occurred, Could not generate digital Patta, Please try Again'];
            }
        }
        else
        {
            $this->db->trans_rollback();
            log_message("error","DIGIPATTA008258 Some error occurred in inserting data into digita patta table for case no ".$case_no);
            return ['flag'=> 'N', 'msg'=>'DIGIPATTA008258 Some error occurred, Could not generate digital Patta, Please try Again'];
        }

    }














    // todo check view page
    public function digitalPattaViewForCo()
    {
        $data['dist_code']   = $dist_code   = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['cir_code']    = $cir_code    = $this->session->userdata('cir_code');
        $data['locationCo']  = $locationCo  = $this->digitalPattaLocationModel->getDigitalPattaVillageList($dist_code, $subdiv_code, $cir_code);
        $data['_view']       = 'digitalPatta/co_landing_page_nc';
        $this->load->view('layouts/main',$data);
    }

    public function getAllDigitalPattaInCoLogin()
    {
        $data['dist_code']   = $dist_code   = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['cir_code']    = $cir_code    = $this->session->userdata('cir_code');
        $json   = null;
        $draw   = intval($this->input->post('draw'));
        $start  = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order  = $this->input->post('order');
        $uuid   = $this->input->post('village_list_dp');

        $mouza_pargona_code = null;
        $lot_no             = null;
        $vill_townprt_code  = null;

        if(!empty($uuid))
        {
            $getLocation        = $this->digitalPattaLocationModel->getLocationByUUID($uuid);
            $mouza_pargona_code = $getLocation->mouza_pargona_code;
            $lot_no             = $getLocation->lot_no;
            $vill_townprt_code  = $getLocation->vill_townprt_code;
        }
        $cases_list = $this->DigitalPattaCommonNcModel->viewAllCasesInCoLoginDigitalPatta($start, $length, $order,$dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code);

        if(!empty($cases_list))
        {
            if($cases_list['total_records'] > 0)
            {
                $data_rows = $cases_list['data_results'];
                foreach($data_rows as $row)
                {
                    $case_no    = "<small class='case-no-bg'><i class='fa fa-archive'></i>" . $row->case_no . "</small>";
                    $appl_no    = "<small class='case-no-bg'><i class='fa fa-archive'></i>" . $row->applid . "</small>";
                    $service    = "<small class='case-no-bg'><i class='fa fa-archive'></i>" . $this->utilityclass->getServiceName($row->service_code). "</small>";
                    $dated_at   = date('d-M-Y',strtotime($row->date_entry));
                    $created_at = "<small class='case-no-bg'><i class='fa fa-clock'></i>" . $dated_at . "</small>";
                    $district   = "<small class='case-no-bg'>" . $this->utilityclass->getDistrictName($row->dist_code) . "</small>";
                    $circle     = "<small class='case-no-bg'>" . $this->utilityclass->getCircleName($row->dist_code,$row->subdiv_code,$row->cir_code) . "</small>";
                    $village    = "<small class='case-no-bg'>" . $this->utilityclass->getVillageName($row->dist_code,$row->subdiv_code,$row->cir_code,$row->mouza_pargona_code,$row->lot_no,$row->vill_townprt_code) . "</small>";
                    $view_link  = BASUNDHARA_LIVE_URL."/DigitalPatta/ViewPropertyCard?dc=".$row->dist_code."&app_no=".$this->digitalPattaLocationModel->encryptJwtCase($row->applid);
                    $button1    = '<a href="'.$view_link.'" class="btn btn-info btn-sm" target= "_blank" role="button">VIEW DIGITAL PATTA</a>';

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
            else
            {
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