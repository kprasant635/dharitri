<?php

class SettlementCertificate extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('SettlementCertificateModel');
        $this->load->library('session'); // Load session library
        $this->load->helper(['form', 'url']);
        $this->load->helper('qrcode');

        $this->dbswitch();

        $method = $this->router->fetch_method();

        if (! in_array($method, VERIFICATION_MODULE_METHODS)) {
            if (HOLD_All_MB2_CASES_STATUS == 1) {
                if (strtotime(HOLD_All_MB2_CASES_DATE) < strtotime(date('Y-m-d H:i:s'))) {
                    $this->session->set_flashdata('message', " Processing of settlement MB 2.0 Cases has been stopped !");
                    redirect(base_url() . "index.php/Home/index");
                }
            }
        }
    }

    public function dbswitch()
    {
        //$CI=&get_instance();
        if ($this->session->userdata('dist_code') == "02") {
            $this->db = $this->load->database('dha3', true);
        } else if ($this->session->userdata('dist_code') == "05") {
            $this->db = $this->load->database('dha1', true);
        } else if ($this->session->userdata('dist_code') == "10") {
            $this->db = $this->load->database('dha24', true);
        } else if ($this->session->userdata('dist_code') == "13") {
            $this->db = $this->load->database('dha2', true);
        } else if ($this->session->userdata('dist_code') == "17") {
            $this->db = $this->load->database('dha4', true);
        } else if ($this->session->userdata('dist_code') == "15") {
            $this->db = $this->load->database('dha5', true);
        } else if ($this->session->userdata('dist_code') == "14") {
            $this->db = $this->load->database('dha6', true);
        } else if ($this->session->userdata('dist_code') == "07") {
            $this->db = $this->load->database('dha7', true);
        } else if ($this->session->userdata('dist_code') == "03") {
            $this->db = $this->load->database('dha8', true);
        } else if ($this->session->userdata('dist_code') == "18") {
            $this->db = $this->load->database('dha9', true);
        } else if ($this->session->userdata('dist_code') == "12") {
            $this->db = $this->load->database('dha13', true);
        } else if ($this->session->userdata('dist_code') == "24") {
            $this->db = $this->load->database('dha10', true);
        } else if ($this->session->userdata('dist_code') == "06") {
            $this->db = $this->load->database('dha11', true);
        } else if ($this->session->userdata('dist_code') == "11") {
            $this->db = $this->load->database('dha12', true);
        } else if ($this->session->userdata('dist_code') == "12") {
            $this->db = $this->load->database('dha13', true);
        } else if ($this->session->userdata('dist_code') == "16") {
            $this->db = $this->load->database('dha14', true);
        } else if ($this->session->userdata('dist_code') == "32") {
            $this->db = $this->load->database('dha15', true);
        } else if ($this->session->userdata('dist_code') == "33") {
            $this->db = $this->load->database('dha16', true);
        } else if ($this->session->userdata('dist_code') == "34") {
            $this->db = $this->load->database('dha17', true);
        } else if ($this->session->userdata('dist_code') == "21") {
            $this->db = $this->load->database('dha18', true);
        } else if ($this->session->userdata('dist_code') == "08") {
            $this->db = $this->load->database('dha19', true);
        } else if ($this->session->userdata('dist_code') == "35") {
            $this->db = $this->load->database('dha20', true);
        } else if ($this->session->userdata('dist_code') == "36") {
            $this->db = $this->load->database('dha21', true);
        } else if ($this->session->userdata('dist_code') == "37") {
            $this->db = $this->load->database('dha22', true);
        } else if ($this->session->userdata('dist_code') == "25") {
            $this->db = $this->load->database('dha23', true);
        } else if ($this->session->userdata('dist_code') == "39") {
            $this->db = $this->load->database('dha39', true);
        } else if ($this->session->userdata('dist_code') == "38") {
            $this->db = $this->load->database('dha25', true);
        }
    }

    public function index()
    {
        $allowed = ['CO','DC'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }
        $data['dist_code']   = $dist_code   = $this->session->userdata('dist_code');

        $data['villages'] = $this->SettlementCertificateModel->getAllVillages($dist_code, null);
        $data['circles']  = $this->SettlementCertificateModel->getAllCircles($dist_code, null);

        // print_r($data['villages']);
        // exit();

        if (ALLOTMENT_AND_SETTLEMENT == 1) {
            $data['certificate'] = $this->SettlementCertificateModel->getAllotmentCertificates($dist_code);
            $data['_view']       = 'settlement_certificate/landing_page';
        } else {
            $data['_view'] = 'settlement_certificate/closed';
        }
        $this->load->view('layouts/main', $data);
    }

    public function getAllAllotmentCertificateDetails()
    {

        $json       = null;
        $draw       = intval($this->input->post('draw'));
        $start      = intval($this->input->post('start'));
        $length     = intval($this->input->post('length'));
        $order      = $this->input->post('order');
        $cases_list = $this->SettlementCertificateModel->getAllCasesAllocatedCertificate($start, $length, $order);

        if (! empty($cases_list)) {

            if ($cases_list['total_records'] > 0) {

                $data_rows = $cases_list['data_results'];

                foreach ($data_rows as $row) {

                    $case_no = "<small class='case-no-bg'><i class='fa fa-archive'></i>" . $row->case_no . "</small>";

                    $service = "<small class='case-no-bg'><i class='fa fa-archive'></i>" . $this->utilityclass->getServiceName($row->service_code) . "</small>";

                    $dated_at   = date('d-M-Y', strtotime($row->date_entry));
                    $created_at = "<small class='case-no-bg'><i class='fa fa-clock'></i>" . $dated_at . "</small>";

                    $district = "<small class='case-no-bg'>" . $this->utilityclass->getDistrictName($row->dist_code) . "</small>";

                    $circle  = "<small class='case-no-bg'>" . $this->utilityclass->getCircleName($row->dist_code, $row->subdiv_code, $row->cir_code) . "</small>";
                    $village = "<small class='case-no-bg'>" . $this->utilityclass->getVillageName($row->dist_code, $row->subdiv_code, $row->cir_code, $row->mouza_pargona_code, $row->lot_no, $row->vill_townprt_code) . "</small>";
                    $button1 = '<button type="button" class="btn btn-sm btn-danger" onclick="viewAllotmentCertificate(\'' . $row->case_no . '\', \'' . $row->dist_code . '\')"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;View</button>';
                    //$button2 = '<button type="button" class="btn btn-sm btn-success" onclick="viewDigitalPatta(\'' . $row->case_no . '\', \'' . $row->dist_code . '\')"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;Download</button>';

                    $json[] = [
                        $row->case_no,
                        $case_no,
                        $service,
                        $created_at,
                        $district,
                        $circle,
                        $village,
                        $button1,
                    ];
                }
            } else {
                $json = "";
            }
            $total_records = $cases_list['total_records'];
            $response      = [
                'draw'            => $draw,
                'recordsTotal'    => $total_records,
                'recordsFiltered' => $total_records,
                'data'            => $json,
            ];
            echo json_encode($response);
        } else {
            $response                         = [];
            $response['sEcho']                = 0;
            $response['iTotalRecords']        = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData']               = [];
            echo json_encode($response);
        }
    }

    public function bulkApproveCasesOfAllotmentCertificateWithoutDigitalSignWithoutPdf()
    {
        $allowed = ['CO','DC'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }
        $_POST = json_decode(file_get_contents("php://input"), true);

        // var_dump($_POST);
        // exit();
        $dhar_case_no_list = $_POST['selectedList'];
        $string            = '';
        $dhar_case_no      = '';
        $base64array       = [];
        $entire_page       = '';
        $failed_case       = [];

        $all_failed_case = '0';

         if(count($dhar_case_no_list) == 0){
        echo json_encode([
            'flag' => 'N',
            'msg'  => 'Please select at least one case'
        ]);
        return;
    }if(count($dhar_case_no_list) > 10){
        echo json_encode([
            'flag' => 'N',
            'msg'  => 'Please select less than 10 cases'
        ]);
        return;
    }

        foreach ($dhar_case_no_list as $key => $dhar_case_no) {

            // $passed_cases = array();
            $data['application_no'] = $application_no = $this->SettlementCertificateModel->getApplidFromCaseNo($dhar_case_no);
            $data['rtps_no']        = $rtps_no        = $this->SettlementCertificateModel->getRtpsRefNo($application_no);
            // $data['patta_info']     = $patta_info     = $this->SettlementCertificateModel->getPattaInfo($application_no);
            $check_partial = $this->SettlementCertificateModel->checkPartialPayment($dhar_case_no);
            if ($check_partial != 'Y') {
                // $check_chitha_update_status = $this->DigitalPattaCommonModel->checkChithaUpdateStatusForPartialPayment($dhar_case_no);
                // if($check_chitha_update_status =='N'){
                //     log_message("error","chitha not updated for case no".$dhar_case_no);
                //     echo json_encode(['flag' => 'N', 'msg' =>"Chitha is not Updated for the case no: ".$dhar_case_no]);
                //     exit;   
                // }                

                // $data['checkBasundhara']  = $this->DigitalPattaCommonModel->checkPartialPaymentStatusInBasundhara($application_no);
                // if($data['checkBasundhara']['result'] =='SERVER-ERROR'){
                //     echo json_encode(['flag' => 'N', 'msg' =>$data['checkBasundhara']['msg']]);
                //     exit; 
                // }
                $insert_all_data = $this->SettlementCertificateModel->insertAllAllocatedCertificateDataWithoutPdf($application_no, $rtps_no, isset($patta_info) ? $patta_info : null, $dhar_case_no);
            }

            // print_r($patta_info);
            // exit();
            // if (! $data['patta_info']['result']) {

            //     //echo json_encode([$data['patta_info']]);
            //     //echo json_encode(['flag' => 'N', 'msg' =>$data['patta_info']['msg']]);
            //     array_push($failed_case, $data['patta_info']['case_no']);
            //     $all_failed_case = implode(",", $failed_case) . "<br>";
            //     continue;
            // }
            // else{
            //     array_push($passed_cases,$patta_info);
            // }

            if ($insert_all_data['result'] == 'SERVER-ERROR') {
                echo json_encode(['flag' => 'N', 'msg' => $insert_all_data['msg']]);
                exit;
            }

        }
        if ($all_failed_case == null) {
            $all_failed_case = '0';
        }
        echo json_encode(['flag' => 'Y', 'msg' => "Process completed... <br><br>Failed cases: $all_failed_case !"]);
    }

    // public function generateCertificate($dist_code, $dhar_case_no)
    // {
    //     $data['application_no'] = $application_no = $this->SettlementCertificateModel->getApplidFromCaseNo($dhar_case_no);
    //     $data['rtps_ref_no']    = $rtps_no    = $this->SettlementCertificateModel->getRtpsRefNo($application_no);

    //     $data['institution_details'] = $institute_details = $this->SettlementCertificateModel->getInstitutionDetails($dhar_case_no);
    //     $data['location_details']    = $this->SettlementCertificateModel->getLocationDetails($dhar_case_no);
    //     // $data['location_details'] = $location_details;
    //     $data['dag_details'] = $dag_details = $this->SettlementCertificateModel->getDagDetails($dhar_case_no);

    //     $location_details_settlement = $data['location_details']['settlement'];
    //     $location_details_raw        = $data['location_details'];

    //     // $data['bigha'] = $location_details['bigha'];

    //     // print_r($data['dag_details']);exit;

    //     $bigha = 0;
    //     $katha = 0;
    //     $lessa = 0;

    //     $data['hec_are_car'] = $this->utilityclass->get_Hec_Are_CAre($bigha, $katha, $lessa);

    //     if (isset($data['dag_details']->landmark_with_code)) {
    //         // Decode the JSON data and assign the 'north' field
    //         $landmark_with_code = json_decode($data['dag_details']->landmark_with_code, true);
    //         $north              = isset($landmark_with_code['north']) ? $landmark_with_code['north'] : null;
    //         $south              = isset($landmark_with_code['south']) ? $landmark_with_code['south'] : null;
    //         $east               = isset($landmark_with_code['east']) ? $landmark_with_code['east'] : null;
    //         $west               = isset($landmark_with_code['west']) ? $landmark_with_code['west'] : null;

    //         $north_boundary_district    = $this->SettlementCertificateModel->getLocationName($north['dist_code']);
    //         $north_boundary_subdivision = $this->SettlementCertificateModel->getLocationName($north['dist_code'], $north['subdiv_code']);
    //         $north_boundary_circle      = $this->SettlementCertificateModel->getLocationName($north['dist_code'], $north['subdiv_code'], $north['cir_code']);
    //         $north_boundary_mouza       = $this->SettlementCertificateModel->getLocationName($north['dist_code'], $north['subdiv_code'], $north['cir_code'], $north['mouza_pargona_code']);
    //         $north_boundary_lot         = $this->SettlementCertificateModel->getLocationName($north['dist_code'], $north['subdiv_code'], $north['cir_code'], $north['mouza_pargona_code'], $north['lot_no']);
    //         $north_boundary_village     = $this->SettlementCertificateModel->getLocationName($north['dist_code'], $north['subdiv_code'], $north['cir_code'], $north['mouza_pargona_code'], $north['lot_no'], $north['vill_townprt_code']);
    //         $north_text                 = $north_boundary_district . ", " . $north_boundary_subdivision . ", " . $north_boundary_circle . ", " . $north_boundary_mouza . ", " . $north_boundary_lot . ", " . $north_boundary_village . ', Dag No: ' . $north['dag_no'];

    //         $south_boundary_district    = $this->SettlementCertificateModel->getLocationName($south['dist_code']);
    //         $south_boundary_subdivision = $this->SettlementCertificateModel->getLocationName($south['dist_code'], $south['subdiv_code']);
    //         $south_boundary_circle      = $this->SettlementCertificateModel->getLocationName($south['dist_code'], $south['subdiv_code'], $south['cir_code']);
    //         $south_boundary_mouza       = $this->SettlementCertificateModel->getLocationName($south['dist_code'], $south['subdiv_code'], $south['cir_code'], $south['mouza_pargona_code']);
    //         $south_boundary_lot         = $this->SettlementCertificateModel->getLocationName($south['dist_code'], $south['subdiv_code'], $south['cir_code'], $south['mouza_pargona_code'], $south['lot_no']);
    //         $south_boundary_village     = $this->SettlementCertificateModel->getLocationName($south['dist_code'], $south['subdiv_code'], $south['cir_code'], $south['mouza_pargona_code'], $south['lot_no'], $south['vill_townprt_code']);
    //         $south_text                 = $south_boundary_district . ", " . $south_boundary_subdivision . ", " . $south_boundary_circle . ", " . $south_boundary_mouza . ", " . $south_boundary_lot . ", " . $south_boundary_village . ', Dag No: ' . $south['dag_no'];

    //         $east_boundary_district    = $this->SettlementCertificateModel->getLocationName($east['dist_code']);
    //         $east_boundary_subdivision = $this->SettlementCertificateModel->getLocationName($east['dist_code'], $east['subdiv_code']);
    //         $east_boundary_circle      = $this->SettlementCertificateModel->getLocationName($east['dist_code'], $east['subdiv_code'], $east['cir_code']);
    //         $east_boundary_mouza       = $this->SettlementCertificateModel->getLocationName($east['dist_code'], $east['subdiv_code'], $east['cir_code'], $east['mouza_pargona_code']);
    //         $east_boundary_lot         = $this->SettlementCertificateModel->getLocationName($east['dist_code'], $east['subdiv_code'], $east['cir_code'], $east['mouza_pargona_code'], $east['lot_no']);
    //         $east_boundary_village     = $this->SettlementCertificateModel->getLocationName($east['dist_code'], $east['subdiv_code'], $east['cir_code'], $east['mouza_pargona_code'], $east['lot_no'], $east['vill_townprt_code']);
    //         $east_text                 = $east_boundary_district . ", " . $east_boundary_subdivision . ", " . $east_boundary_circle . ", " . $east_boundary_mouza . ", " . $east_boundary_lot . ", " . $east_boundary_village . ', Dag No: ' . $east['dag_no'];

    //         $west_boundary_district    = $this->SettlementCertificateModel->getLocationName($west['dist_code']);
    //         $west_boundary_subdivision = $this->SettlementCertificateModel->getLocationName($west['dist_code'], $west['subdiv_code']);
    //         $west_boundary_circle      = $this->SettlementCertificateModel->getLocationName($west['dist_code'], $west['subdiv_code'], $west['cir_code']);
    //         $west_boundary_mouza       = $this->SettlementCertificateModel->getLocationName($west['dist_code'], $west['subdiv_code'], $west['cir_code'], $west['mouza_pargona_code']);
    //         $west_boundary_lot         = $this->SettlementCertificateModel->getLocationName($west['dist_code'], $west['subdiv_code'], $west['cir_code'], $west['mouza_pargona_code'], $west['lot_no']);
    //         $west_boundary_village     = $this->SettlementCertificateModel->getLocationName($west['dist_code'], $west['subdiv_code'], $west['cir_code'], $west['mouza_pargona_code'], $west['lot_no'], $west['vill_townprt_code']);
    //         $west_text                 = $west_boundary_district . ", " . $west_boundary_subdivision . ", " . $west_boundary_circle . ", " . $west_boundary_mouza . ", " . $west_boundary_lot . ", " . $west_boundary_village . ', Dag No: ' . $west['dag_no'];

    //         $data['boundary_details']['east'] = $east_text;
    //         $data['boundary_details']['west'] = $west_text;

    //         $data['boundary_details']['north'] = $north_text;
    //         $data['boundary_details']['south'] = $south_text;

    //     } else if (isset($data['dag_details']->landmark)) {
    //         $landmark                          = $data['dag_details']->landmark;
    //         $north                             = isset($landmark['north']) ? $landmark['north'] : null;
    //         $south                             = isset($landmark['south']) ? $landmark['south'] : null;
    //         $east                              = isset($landmark['east']) ? $landmark['east'] : null;
    //         $west                              = isset($landmark['west']) ? $landmark['west'] : null;
    //         $data['boundary_details']['north'] = isset($landmark['north']) ? $landmark['north'] : null;
    //         $data['boundary_details']['south'] = isset($landmark['south']) ? $landmark['south'] : null;
    //         $data['boundary_details']['east']  = isset($landmark['east']) ? $landmark['east'] : null;
    //         $data['boundary_details']['west']  = isset($landmark['west']) ? $landmark['west'] : null;
    //     }

    //     // generate certificate number
    //     $certificate_no = $this->SettlementCertificateModel->generateCertificateNumber();

    //     $landclass = $this->utilityclass->getLandClassCode($dag_details->new_land_class_code);

    //     $get_meeting_no = $this->SettlementCertificateModel->getMeetingNo($dhar_case_no);

    //     $otherDetails = $this->SettlementCertificateModel->getOtherDetails($dhar_case_no);

    //     $dist_code = $location_details_settlement->dist_code;
    //     $sub       = $location_details_settlement->subdiv_code;
    //     $cir       = $location_details_settlement->cir_code;
    //     $mou       = $location_details_settlement->mouza_pargona_code;
    //     $lot       = $location_details_settlement->lot_no;
    //     $vill      = $location_details_settlement->vill_townprt_code;

    //     $getVillageUUID = $this->SettlementCertificateModel->getVillageUUID($dist_code, $sub, $cir, $mou, $lot, $vill);
    //     // make the array for insertion into the database

    //     $dag_nos = $this->SettlementCertificateModel->getChithaDagNos($dhar_case_no);

    //     $getArea = $this->SettlementCertificateModel->getDagAreaBYCase($dhar_case_no);

    //     // print_r($getArea);
    //     // die;

    //     $certificate_data = [

    //         'certificate_no'             => strtoupper($certificate_no),
    //         'dhar_case_no'               => strtoupper($dhar_case_no),
    //         'application_no'             => strtoupper($application_no),
    //         'land_advisiory_proposal_no' => strtoupper($get_meeting_no->meeting_name),
    //         'lapn_date'                  => strtoupper($get_meeting_no->digital_sign_date),
    //         'certificate_date'           => strtoupper(date('Y-m-d')),
    //         'institute_name'             => strtoupper($institute_details->ins_name_co),
    //         'ins_category'               => strtoupper($institute_details->category_name),
    //         'dist_code'                  => strtoupper($location_details_settlement->dist_code),
    //         'subdiv_code'                => strtoupper($location_details_settlement->subdiv_code),
    //         'cir_code'                   => strtoupper($location_details_settlement->cir_code),
    //         'mouza_pargona_code'         => strtoupper($location_details_settlement->mouza_pargona_code),
    //         'lot_no'                     => strtoupper($location_details_settlement->lot_no),
    //         'vill_townprt_code'          => strtoupper($location_details_settlement->vill_townprt_code),

    //         'district_name'              => strtoupper($location_details_raw['district_name']),
    //         'subdivision_name'           => strtoupper($location_details_raw['subdiv_name']),
    //         'circle_name'                => strtoupper($location_details_raw['cir_name']),
    //         'mouza_pargona_name'         => strtoupper($location_details_raw['mouza_name']),
    //         'lot_name'                   => strtoupper($location_details_raw['lot_name']),
    //         'village_name'               => strtoupper($location_details_raw['village_name']),
    //         'village_uuid'               => $getVillageUUID,

    //         'dag_no_old'                 => strtoupper($dag_nos[0]->applied_dag_no),
    //         'dag_no_new'                 => strtoupper($dag_nos[0]->dag_no),

    //         'total_land_area'            => strtoupper(null),
    //         'land_area_b'                => strtoupper($bigha),
    //         'land_area_k'                => strtoupper($katha),
    //         'land_area_l'                => strtoupper($lessa),
    //         'hectare_area_car'           => strtoupper($data['hec_are_car']),
    //         'boundary_description'       => strtoupper(null),
    //         'dag_no_new_ls'              => strtoupper(null),
    //         'land_class_code'            => strtoupper($dag_details->new_land_class_code),
    //         'land_class_name'            => strtoupper($landclass),
    //         'north'                      => strtoupper(isset($data['boundary_details']['north']) ? $data['boundary_details']['north'] : null),
    //         'south'                      => strtoupper(isset($data['boundary_details']['south']) ? $data['boundary_details']['south'] : null),
    //         'east'                       => strtoupper(isset($data['boundary_details']['east']) ? $data['boundary_details']['east'] : null),
    //         'west'                       => strtoupper(isset($data['boundary_details']['west']) ? $data['boundary_details']['west'] : null),

    //         'ulpin_dag_no_1'             => strtoupper(null),
    //         'ulpin_dag_no_2'             => strtoupper(null),
    //         'ulpin_dag_no_3'             => strtoupper(null),
    //         'ulpin_dag_no_4'             => strtoupper(null),
    //         'ulpin_geo_cordinates'       => strtoupper(null),
    //         'land_schedule_sketch_link'  => strtoupper('https://sewasetu.assam.gov.in/'),
    //         'service_code'               => strtoupper(45),
    //         'status'                     => strtoupper(1),
    //         'other_details'              => strtoupper($otherDetails),
    //     ];

    //     // insert the data into the database
    //     $insert_data = $this->SettlementCertificateModel->insertOrUpdateCertificateData($certificate_data);
    //     // print($insert_data);
    //     return $insert_data;
    // }

    // public function generateCertificateV2($dhar_case_no, $type)
    // {

    //     // check if already generated certificate for this case
    //     $certificate_no = $this->SettlementCertificateModel->getCertificateData($dhar_case_no);
    //     if ($certificate_no != 'NOT-FOUND') {
    //         return ['result' => "NO ERROR"];
    //     } else {
    //         // print_r("GG");die;
    //         $data['application_no'] = $application_no = $this->SettlementCertificateModel->getApplidFromCaseNo($dhar_case_no);
    //         $data['rtps_ref_no']    = $rtps_no    = $this->SettlementCertificateModel->getRtpsRefNo($application_no);

    //         $data['institution_details'] = $institute_details = $this->SettlementCertificateModel->getInstitutionDetails($dhar_case_no);
    //         $data['location_details']    = $this->SettlementCertificateModel->getLocationDetails($dhar_case_no);
    //         // $data['location_details'] = $location_details;
    //         $otherDetails = $this->SettlementCertificateModel->getOtherDetails($dhar_case_no);

    //         $location_details_settlement = $data['location_details']['settlement'];
    //         $location_details_raw        = $data['location_details'];

    //         $dist_code = $location_details_settlement->dist_code;
    //         $sub       = $location_details_settlement->subdiv_code;
    //         $cir       = $location_details_settlement->cir_code;
    //         $mou       = $location_details_settlement->mouza_pargona_code;
    //         $lot       = $location_details_settlement->lot_no;
    //         $vill      = $location_details_settlement->vill_townprt_code;

    //         $getVillageUUID = $this->SettlementCertificateModel->getVillageUUID($dist_code, $sub, $cir, $mou, $lot, $vill);
    //         // make the array for insertion into the database

    //         $data['dag_details'] = $dag_details = $this->SettlementCertificateModel->getDagDetails($dhar_case_no);

    //         $dagArray = [];

    //         foreach ($dag_details as $key => $value) {

    //             $applied_b  = $value->s_dag_area_b;
    //             $applied_k  = $value->s_dag_area_k;
    //             $applied_lc = $value->s_dag_area_lc;
    //             $applied_g  = $value->s_dag_area_g;
    //             //////////////////
    //             if (in_array($value->dist_code, json_decode(BARAK_VALLEY))) {
    //                 $totalHectar = $this->utilityclass->get_Hec_Are_CAre2($applied_b, $applied_k, $applied_lc, $applied_g);
    //                 $sqrMeter    = $this->utilityclass->Total_ganda($applied_b, $applied_k, $applied_lc, $applied_g) * 4.1806368;
    //             } else {
    //                 $totalHectar = $this->utilityclass->get_Hec_Are_CAre($applied_b, $applied_k, $applied_lc);
    //                 $sqrMeter    = $this->utilityclass->Total_Lessa($applied_b, $applied_k, $applied_lc) * 13.37803776;
    //             }

    //             if (isset($value->landmark_with_code)) {
    //                 // Decode the JSON data and assign the 'north' field
    //                 $landmark_with_code = json_decode($value->landmark_with_code, true);
    //                 $north              = isset($landmark_with_code['north']) ? $landmark_with_code['north'] : null;
    //                 $south              = isset($landmark_with_code['south']) ? $landmark_with_code['south'] : null;
    //                 $east               = isset($landmark_with_code['east']) ? $landmark_with_code['east'] : null;
    //                 $west               = isset($landmark_with_code['west']) ? $landmark_with_code['west'] : null;

    //                 $north_boundary_district    = $this->SettlementCertificateModel->getLocationName($north['dist_code']);
    //                 $north_boundary_subdivision = $this->SettlementCertificateModel->getLocationName($north['dist_code'], $north['subdiv_code']);
    //                 $north_boundary_circle      = $this->SettlementCertificateModel->getLocationName($north['dist_code'], $north['subdiv_code'], $north['cir_code']);
    //                 $north_boundary_mouza       = $this->SettlementCertificateModel->getLocationName($north['dist_code'], $north['subdiv_code'], $north['cir_code'], $north['mouza_pargona_code']);
    //                 $north_boundary_lot         = $this->SettlementCertificateModel->getLocationName($north['dist_code'], $north['subdiv_code'], $north['cir_code'], $north['mouza_pargona_code'], $north['lot_no']);
    //                 $north_boundary_village     = $this->SettlementCertificateModel->getLocationName($north['dist_code'], $north['subdiv_code'], $north['cir_code'], $north['mouza_pargona_code'], $north['lot_no'], $north['vill_townprt_code']);
    //                 $north_text                 = $north_boundary_district . ", " . $north_boundary_subdivision . ", " . $north_boundary_circle . ", " . $north_boundary_mouza . ", " . $north_boundary_lot . ", " . $north_boundary_village . ', Dag No: ' . $north['dag_no'];

    //                 $south_boundary_district    = $this->SettlementCertificateModel->getLocationName($south['dist_code']);
    //                 $south_boundary_subdivision = $this->SettlementCertificateModel->getLocationName($south['dist_code'], $south['subdiv_code']);
    //                 $south_boundary_circle      = $this->SettlementCertificateModel->getLocationName($south['dist_code'], $south['subdiv_code'], $south['cir_code']);
    //                 $south_boundary_mouza       = $this->SettlementCertificateModel->getLocationName($south['dist_code'], $south['subdiv_code'], $south['cir_code'], $south['mouza_pargona_code']);
    //                 $south_boundary_lot         = $this->SettlementCertificateModel->getLocationName($south['dist_code'], $south['subdiv_code'], $south['cir_code'], $south['mouza_pargona_code'], $south['lot_no']);
    //                 $south_boundary_village     = $this->SettlementCertificateModel->getLocationName($south['dist_code'], $south['subdiv_code'], $south['cir_code'], $south['mouza_pargona_code'], $south['lot_no'], $south['vill_townprt_code']);
    //                 $south_text                 = $south_boundary_district . ", " . $south_boundary_subdivision . ", " . $south_boundary_circle . ", " . $south_boundary_mouza . ", " . $south_boundary_lot . ", " . $south_boundary_village . ', Dag No: ' . $south['dag_no'];

    //                 $east_boundary_district    = $this->SettlementCertificateModel->getLocationName($east['dist_code']);
    //                 $east_boundary_subdivision = $this->SettlementCertificateModel->getLocationName($east['dist_code'], $east['subdiv_code']);
    //                 $east_boundary_circle      = $this->SettlementCertificateModel->getLocationName($east['dist_code'], $east['subdiv_code'], $east['cir_code']);
    //                 $east_boundary_mouza       = $this->SettlementCertificateModel->getLocationName($east['dist_code'], $east['subdiv_code'], $east['cir_code'], $east['mouza_pargona_code']);
    //                 $east_boundary_lot         = $this->SettlementCertificateModel->getLocationName($east['dist_code'], $east['subdiv_code'], $east['cir_code'], $east['mouza_pargona_code'], $east['lot_no']);
    //                 $east_boundary_village     = $this->SettlementCertificateModel->getLocationName($east['dist_code'], $east['subdiv_code'], $east['cir_code'], $east['mouza_pargona_code'], $east['lot_no'], $east['vill_townprt_code']);
    //                 $east_text                 = $east_boundary_district . ", " . $east_boundary_subdivision . ", " . $east_boundary_circle . ", " . $east_boundary_mouza . ", " . $east_boundary_lot . ", " . $east_boundary_village . ', Dag No: ' . $east['dag_no'];

    //                 $west_boundary_district    = $this->SettlementCertificateModel->getLocationName($west['dist_code']);
    //                 $west_boundary_subdivision = $this->SettlementCertificateModel->getLocationName($west['dist_code'], $west['subdiv_code']);
    //                 $west_boundary_circle      = $this->SettlementCertificateModel->getLocationName($west['dist_code'], $west['subdiv_code'], $west['cir_code']);
    //                 $west_boundary_mouza       = $this->SettlementCertificateModel->getLocationName($west['dist_code'], $west['subdiv_code'], $west['cir_code'], $west['mouza_pargona_code']);
    //                 $west_boundary_lot         = $this->SettlementCertificateModel->getLocationName($west['dist_code'], $west['subdiv_code'], $west['cir_code'], $west['mouza_pargona_code'], $west['lot_no']);
    //                 $west_boundary_village     = $this->SettlementCertificateModel->getLocationName($west['dist_code'], $west['subdiv_code'], $west['cir_code'], $west['mouza_pargona_code'], $west['lot_no'], $west['vill_townprt_code']);
    //                 $west_text                 = $west_boundary_district . ", " . $west_boundary_subdivision . ", " . $west_boundary_circle . ", " . $west_boundary_mouza . ", " . $west_boundary_lot . ", " . $west_boundary_village . ', Dag No: ' . $west['dag_no'];

    //                 $data['boundary_details']['east'] = $east_text;
    //                 $data['boundary_details']['west'] = $west_text;

    //                 $data['boundary_details']['north'] = $north_text;
    //                 $data['boundary_details']['south'] = $south_text;

    //                 $ulpin1 = $east['dag_no'];
    //                 $ulpin2 = $west['dag_no'];
    //                 $ulpin3 = $north['dag_no'];
    //                 $ulpin4 = $south['dag_no'];

    //             } else if (isset($value->landmark)) {
    //                 $landmark                          = $value->landmark;
    //                 $north                             = isset($landmark['north']) ? $landmark['north'] : null;
    //                 $south                             = isset($landmark['south']) ? $landmark['south'] : null;
    //                 $east                              = isset($landmark['east']) ? $landmark['east'] : null;
    //                 $west                              = isset($landmark['west']) ? $landmark['west'] : null;
    //                 $data['boundary_details']['north'] = isset($landmark['north']) ? $landmark['north'] : null;
    //                 $data['boundary_details']['south'] = isset($landmark['south']) ? $landmark['south'] : null;
    //                 $data['boundary_details']['east']  = isset($landmark['east']) ? $landmark['east'] : null;
    //                 $data['boundary_details']['west']  = isset($landmark['west']) ? $landmark['west'] : null;
    //                 $ulpin1                            = null;
    //                 $ulpin2                            = null;
    //                 $ulpin3                            = null;
    //                 $ulpin4                            = null;
    //             } else {
    //                 $data['boundary_details']['north'] = "Unidentified";
    //                 $data['boundary_details']['south'] = "Unidentified";
    //                 $data['boundary_details']['east']  = "Unidentified";
    //                 $data['boundary_details']['west']  = "Unidentified";

    //                 $ulpin1 = null;
    //                 $ulpin2 = null;
    //                 $ulpin3 = null;
    //                 $ulpin4 = null;
    //             }
    //             $landclass = $this->utilityclass->getLandClassCode($value->new_land_class_code);
    //             $dag_nos   = $this->SettlementCertificateModel->getChithaDagNosByOldDag($dhar_case_no, $value->dag_no);

    //             $dag_no_old = $value->dag_no ?? null;
    //             $dag_no_new = $dag_nos->dag_no ?? null;

    //             $dagArray[] = [
    //                 'bigha'                => $applied_b,
    //                 'katha'                => $applied_k,
    //                 'lessa'                => $applied_lc,
    //                 'ganga'                => $applied_g,
    //                 'total_hectare'        => $totalHectar,
    //                 'total_square_meter'   => $sqrMeter,
    //                 'land_class_code'      => $value->new_land_class_code,
    //                 'boundary_description' => $data['boundary_details'],
    //                 'dag_no_old'           => $dag_no_old,
    //                 'dag_no_new'           => $dag_no_new,
    //                 'land_class'           => $landclass,
    //             ];

    //             $pattaDetails = $this->SettlementCertificateModel->getPattaDetails($dist_code, $sub, $cir, $mou, $lot, $vill, $dag_no_old, $dag_no_new);

    //             if ($pattaDetails && ! isset($dagArray[0]['patta_details'])) {

    //                 $dagArray[0]['patta_details'] = [
    //                     'dag_revenue'     => $pattaDetails->dag_revenue,
    //                     'dag_local_tax'   => $pattaDetails->dag_local_tax,
    //                     'patta_type_code' => $pattaDetails->patta_type_code,
    //                     'patta_no'        => $pattaDetails->patta_no,
    //                     'old_patta_no'    => $pattaDetails->old_patta_no,
    //                     'patta_type_name' => $this->utilityclass->getPattaName($patta->patta_type_code),
    //                 ];
    //             }

    //         }

    //         $get_meeting_no = $this->SettlementCertificateModel->getMeetingNo($dhar_case_no);

    //         // generate certificate number
    //         $certificate_no = $this->SettlementCertificateModel->generateCertificateNumber();
    //         // print_r($certificate_no);die;

    //         $getDataFromApLmNote = $this->SettlementCertificateModel->getDataFromApLmNotes($dhar_case_no);
    //         $isSettlement        = $this->SettlementCertificateModel->isSettlementorAllotment($institute_details->ins_cat_type_co, $getDataFromApLmNote); // or use: $this->SettlementCertificateModel->isSettlement($case_no);

    //         $certificate_data = [

    //             'certificate_no'             => strtoupper($certificate_no),
    //             'dhar_case_no'               => strtoupper($dhar_case_no),
    //             'application_no'             => strtoupper($application_no),
    //             'land_advisiory_proposal_no' => strtoupper($get_meeting_no->meeting_name),
    //             'lapn_date'                  => strtoupper($get_meeting_no->digital_sign_date),
    //             'certificate_date'           => date('Y-m-d'),
    //             'institute_name'             => strtoupper($institute_details->ins_name_co),
    //             'ins_category'               => $institute_details->category_name,
    //             'dist_code'                  => $location_details_settlement->dist_code,
    //             'subdiv_code'                => $location_details_settlement->subdiv_code,
    //             'cir_code'                   => $location_details_settlement->cir_code,
    //             'mouza_pargona_code'         => $location_details_settlement->mouza_pargona_code,
    //             'lot_no'                     => $location_details_settlement->lot_no,
    //             'vill_townprt_code'          => $location_details_settlement->vill_townprt_code,
    //             'district_name'              => strtoupper($location_details_raw['district_name']),
    //             'subdivision_name'           => strtoupper($location_details_raw['subdiv_name']),
    //             'circle_name'                => strtoupper($location_details_raw['cir_name']),
    //             'mouza_pargona_name'         => strtoupper($location_details_raw['mouza_name']),
    //             'lot_name'                   => strtoupper($location_details_raw['lot_name']),
    //             'village_name'               => strtoupper($location_details_raw['village_name']),
    //             'village_uuid'               => $getVillageUUID,

    //             'ins_cat_type_co'            => $institute_details->ins_cat_type_co,
    //             'issettlement'               => $isSettlement,

    //             'dag_details'                => json_encode($dagArray),

    //             'ulpin_dag_no_1'             => $ulpin1,
    //             'ulpin_dag_no_2'             => $ulpin2,
    //             'ulpin_dag_no_3'             => $ulpin3,
    //             'ulpin_dag_no_4'             => $ulpin4,
    //             'ulpin_geo_cordinates'       => strtoupper(null),
    //             'land_schedule_sketch_link'  => 'https://sewasetu.assam.gov.in/',
    //             'service_code'               => strtoupper(45),
    //             'status'                     => strtoupper(1),
    //             'other_details'              => strtoupper($otherDetails),
    //         ];

    //         // insert the data into the database
    //         $insert_data = $this->SettlementCertificateModel->insertOrUpdateCertificateData($certificate_data);
    //         // print($insert_data);


    //         // genearte the base64 of the view of the certificate
    //         return true;
    //     }
    // }

    // public function generateCertificate($dist_code = null, $dhar_case_no, $type)
    // {

    //     // check if already generated certificate for this case
    //     $certificate_no = $this->SettlementCertificateModel->getCertificateData($dhar_case_no);
    //     if ($certificate_no != 'NOT-FOUND') {
    //         return ['result' => "NO ERROR"];
    //     } else {
    //         // print_r("GG");die;
    //         $data['application_no'] = $application_no = $this->SettlementCertificateModel->getApplidFromCaseNo($dhar_case_no);
    //         $data['rtps_ref_no']    = $rtps_no    = $this->SettlementCertificateModel->getRtpsRefNo($application_no);

    //         $data['institution_details'] = $institute_details = $this->SettlementCertificateModel->getInstitutionDetails($dhar_case_no);
    //         $data['location_details']    = $this->SettlementCertificateModel->getLocationDetails($dhar_case_no);
    //         // $data['location_details'] = $location_details;
    //         $otherDetails = $this->SettlementCertificateModel->getOtherDetails($dhar_case_no);

    //         $location_details_settlement = $data['location_details']['settlement'];
    //         $location_details_raw        = $data['location_details'];

    //         $dist_code = $location_details_settlement->dist_code;
    //         $sub       = $location_details_settlement->subdiv_code;
    //         $cir       = $location_details_settlement->cir_code;
    //         $mou       = $location_details_settlement->mouza_pargona_code;
    //         $lot       = $location_details_settlement->lot_no;
    //         $vill      = $location_details_settlement->vill_townprt_code;

    //         $getVillageUUID = $this->SettlementCertificateModel->getVillageUUID($dist_code, $sub, $cir, $mou, $lot, $vill);
    //         // make the array for insertion into the database

    //         $data['dag_details'] = $dag_details = $this->SettlementCertificateModel->getDagDetails($dhar_case_no);

    //         $dagArray = [];

    //         foreach ($dag_details as $key => $value) {

    //             $applied_b  = $value->s_dag_area_b;
    //             $applied_k  = $value->s_dag_area_k;
    //             $applied_lc = $value->s_dag_area_lc;
    //             $applied_g  = $value->s_dag_area_g;
    //             //////////////////
    //             if (in_array($value->dist_code, json_decode(BARAK_VALLEY))) {
    //                 $totalHectar = $this->utilityclass->get_Hec_Are_CAre2($applied_b, $applied_k, $applied_lc, $applied_g);
    //                 $sqrMeter    = $this->utilityclass->Total_ganda($applied_b, $applied_k, $applied_lc, $applied_g) * 4.1806368;
    //             } else {
    //                 $totalHectar = $this->utilityclass->get_Hec_Are_CAre($applied_b, $applied_k, $applied_lc);
    //                 $sqrMeter    = $this->utilityclass->Total_Lessa($applied_b, $applied_k, $applied_lc) * 13.37803776;
    //             }

    //             if (isset($value->landmark_with_code)) {
    //                 // Decode the JSON data and assign the 'north' field
    //                 $landmark_with_code = json_decode($value->landmark_with_code, true);
    //                 $north              = isset($landmark_with_code['north']) ? $landmark_with_code['north'] : null;
    //                 $south              = isset($landmark_with_code['south']) ? $landmark_with_code['south'] : null;
    //                 $east               = isset($landmark_with_code['east']) ? $landmark_with_code['east'] : null;
    //                 $west               = isset($landmark_with_code['west']) ? $landmark_with_code['west'] : null;

    //                 $north_boundary_district    = $this->SettlementCertificateModel->getLocationName($north['dist_code']);
    //                 $north_boundary_subdivision = $this->SettlementCertificateModel->getLocationName($north['dist_code'], $north['subdiv_code']);
    //                 $north_boundary_circle      = $this->SettlementCertificateModel->getLocationName($north['dist_code'], $north['subdiv_code'], $north['cir_code']);
    //                 $north_boundary_mouza       = $this->SettlementCertificateModel->getLocationName($north['dist_code'], $north['subdiv_code'], $north['cir_code'], $north['mouza_pargona_code']);
    //                 $north_boundary_lot         = $this->SettlementCertificateModel->getLocationName($north['dist_code'], $north['subdiv_code'], $north['cir_code'], $north['mouza_pargona_code'], $north['lot_no']);
    //                 $north_boundary_village     = $this->SettlementCertificateModel->getLocationName($north['dist_code'], $north['subdiv_code'], $north['cir_code'], $north['mouza_pargona_code'], $north['lot_no'], $north['vill_townprt_code']);
    //                 $north_text                 = $north_boundary_district . ", " . $north_boundary_subdivision . ", " . $north_boundary_circle . ", " . $north_boundary_mouza . ", " . $north_boundary_lot . ", " . $north_boundary_village . ', Dag No: ' . $north['dag_no'];

    //                 $south_boundary_district    = $this->SettlementCertificateModel->getLocationName($south['dist_code']);
    //                 $south_boundary_subdivision = $this->SettlementCertificateModel->getLocationName($south['dist_code'], $south['subdiv_code']);
    //                 $south_boundary_circle      = $this->SettlementCertificateModel->getLocationName($south['dist_code'], $south['subdiv_code'], $south['cir_code']);
    //                 $south_boundary_mouza       = $this->SettlementCertificateModel->getLocationName($south['dist_code'], $south['subdiv_code'], $south['cir_code'], $south['mouza_pargona_code']);
    //                 $south_boundary_lot         = $this->SettlementCertificateModel->getLocationName($south['dist_code'], $south['subdiv_code'], $south['cir_code'], $south['mouza_pargona_code'], $south['lot_no']);
    //                 $south_boundary_village     = $this->SettlementCertificateModel->getLocationName($south['dist_code'], $south['subdiv_code'], $south['cir_code'], $south['mouza_pargona_code'], $south['lot_no'], $south['vill_townprt_code']);
    //                 $south_text                 = $south_boundary_district . ", " . $south_boundary_subdivision . ", " . $south_boundary_circle . ", " . $south_boundary_mouza . ", " . $south_boundary_lot . ", " . $south_boundary_village . ', Dag No: ' . $south['dag_no'];

    //                 $east_boundary_district    = $this->SettlementCertificateModel->getLocationName($east['dist_code']);
    //                 $east_boundary_subdivision = $this->SettlementCertificateModel->getLocationName($east['dist_code'], $east['subdiv_code']);
    //                 $east_boundary_circle      = $this->SettlementCertificateModel->getLocationName($east['dist_code'], $east['subdiv_code'], $east['cir_code']);
    //                 $east_boundary_mouza       = $this->SettlementCertificateModel->getLocationName($east['dist_code'], $east['subdiv_code'], $east['cir_code'], $east['mouza_pargona_code']);
    //                 $east_boundary_lot         = $this->SettlementCertificateModel->getLocationName($east['dist_code'], $east['subdiv_code'], $east['cir_code'], $east['mouza_pargona_code'], $east['lot_no']);
    //                 $east_boundary_village     = $this->SettlementCertificateModel->getLocationName($east['dist_code'], $east['subdiv_code'], $east['cir_code'], $east['mouza_pargona_code'], $east['lot_no'], $east['vill_townprt_code']);
    //                 $east_text                 = $east_boundary_district . ", " . $east_boundary_subdivision . ", " . $east_boundary_circle . ", " . $east_boundary_mouza . ", " . $east_boundary_lot . ", " . $east_boundary_village . ', Dag No: ' . $east['dag_no'];

    //                 $west_boundary_district    = $this->SettlementCertificateModel->getLocationName($west['dist_code']);
    //                 $west_boundary_subdivision = $this->SettlementCertificateModel->getLocationName($west['dist_code'], $west['subdiv_code']);
    //                 $west_boundary_circle      = $this->SettlementCertificateModel->getLocationName($west['dist_code'], $west['subdiv_code'], $west['cir_code']);
    //                 $west_boundary_mouza       = $this->SettlementCertificateModel->getLocationName($west['dist_code'], $west['subdiv_code'], $west['cir_code'], $west['mouza_pargona_code']);
    //                 $west_boundary_lot         = $this->SettlementCertificateModel->getLocationName($west['dist_code'], $west['subdiv_code'], $west['cir_code'], $west['mouza_pargona_code'], $west['lot_no']);
    //                 $west_boundary_village     = $this->SettlementCertificateModel->getLocationName($west['dist_code'], $west['subdiv_code'], $west['cir_code'], $west['mouza_pargona_code'], $west['lot_no'], $west['vill_townprt_code']);
    //                 $west_text                 = $west_boundary_district . ", " . $west_boundary_subdivision . ", " . $west_boundary_circle . ", " . $west_boundary_mouza . ", " . $west_boundary_lot . ", " . $west_boundary_village . ', Dag No: ' . $west['dag_no'];

    //                 $data['boundary_details']['east'] = $east_text;
    //                 $data['boundary_details']['west'] = $west_text;

    //                 $data['boundary_details']['north'] = $north_text;
    //                 $data['boundary_details']['south'] = $south_text;

    //                 $ulpin1 = $east['dag_no'];
    //                 $ulpin2 = $west['dag_no'];
    //                 $ulpin3 = $north['dag_no'];
    //                 $ulpin4 = $south['dag_no'];

    //                 $plotNos    = array_filter([$ulpin1, $ulpin2, $ulpin3, $ulpin4]);
    //                 $plotNosStr = implode(",", $plotNos); // convert array -> "21,2,23,78,56"

    //                 $location = $west['dist_code'] . $west['subdiv_code'] . $west['cir_code'] . $west['mouza_pargona_code'] . $west['lot_no'] . $west['vill_townprt_code'];
    //                 // Call API once with all dag numbers
    //                 $curl    = curl_init();
    //                 $payload = json_encode([
    //                     "location" => $location, // you can make dynamic if needed
    //                     "plotNos"  => $plotNosStr,
    //                 ]);

    //                 curl_setopt_array($curl, [
    //                     CURLOPT_URL            => 'https://landhub.assam.gov.in/apidemo/index.php/NicApi/ULPINs',
    //                     CURLOPT_RETURNTRANSFER => true,
    //                     CURLOPT_ENCODING       => '',
    //                     CURLOPT_MAXREDIRS      => 10,
    //                     CURLOPT_TIMEOUT        => 0,
    //                     CURLOPT_FOLLOWLOCATION => true,
    //                     CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
    //                     CURLOPT_CUSTOMREQUEST  => 'POST', // should be POST (not GET) because you are sending JSON body
    //                     CURLOPT_POSTFIELDS     => $payload,
    //                     CURLOPT_HTTPHEADER     => [
    //                         'Content-Type: application/json',
    //                     ],
    //                 ]);

    //                 $response = curl_exec($curl);
    //                 curl_close($curl);

    //                 // Decode API response
    //                 $ulpinData = json_decode($response, true);

    //                 // Original plot numbers you sent
    //                 $plotNos = [$ulpin1, $ulpin2, $ulpin3, $ulpin4];

    //                 // Build a lookup array from API response
    //                 $ulpinMap = [];
    //                 if (isset($ulpinData['data']) && is_array($ulpinData['data'])) {
    //                     foreach ($ulpinData['data'] as $item) {
    //                         if (isset($item['plotNo'], $item['ULPIN'])) {
    //                             $ulpinMap[$item['plotNo']] = $item['ULPIN'];
    //                         }
    //                     }
    //                 }

    //                 // Assign back in "ULPIN/DAG" format
    //                 foreach ($plotNos as $index => $p) {
    //                     $ulpinVar = "ulpin" . ($index + 1); // makes ulpin1, ulpin2, etc.
    //                     if (isset($ulpinMap[$p])) {
    //                         $$ulpinVar = $ulpinMap[$p] . "/" . $p;
    //                     } else {
    //                         $$ulpinVar = "N/A/" . $p; // fallback if not found
    //                     }
    //                 }

    //             } else if (isset($value->landmark)) {
    //                 $landmark                          = $value->landmark;
    //                 $north                             = isset($landmark['north']) ? $landmark['north'] : null;
    //                 $south                             = isset($landmark['south']) ? $landmark['south'] : null;
    //                 $east                              = isset($landmark['east']) ? $landmark['east'] : null;
    //                 $west                              = isset($landmark['west']) ? $landmark['west'] : null;
    //                 $data['boundary_details']['north'] = isset($landmark['north']) ? $landmark['north'] : null;
    //                 $data['boundary_details']['south'] = isset($landmark['south']) ? $landmark['south'] : null;
    //                 $data['boundary_details']['east']  = isset($landmark['east']) ? $landmark['east'] : null;
    //                 $data['boundary_details']['west']  = isset($landmark['west']) ? $landmark['west'] : null;
    //                 $ulpin1                            = null;
    //                 $ulpin2                            = null;
    //                 $ulpin3                            = null;
    //                 $ulpin4                            = null;
    //             } else {
    //                 $data['boundary_details']['north'] = "Unidentified";
    //                 $data['boundary_details']['south'] = "Unidentified";
    //                 $data['boundary_details']['east']  = "Unidentified";
    //                 $data['boundary_details']['west']  = "Unidentified";

    //                 $ulpin1 = null;
    //                 $ulpin2 = null;
    //                 $ulpin3 = null;
    //                 $ulpin4 = null;
    //             }
    //             $landclass = $this->utilityclass->getLandClassCode($value->new_land_class_code);
    //             $dag_nos   = $this->SettlementCertificateModel->getChithaDagNosByOldDag($dhar_case_no, $value->dag_no);

    //             $dag_no_old = $value->dag_no ?? null;
    //             $dag_no_new = $dag_nos->dag_no ?? null;

    //             $dagArray[] = [
    //                 'bigha'                => $applied_b,
    //                 'katha'                => $applied_k,
    //                 'lessa'                => $applied_lc,
    //                 'ganga'                => $applied_g,
    //                 'total_hectare'        => $totalHectar,
    //                 'total_square_meter'   => $sqrMeter,
    //                 'land_class_code'      => $value->new_land_class_code,
    //                 'boundary_description' => $data['boundary_details'],
    //                 'dag_no_old'           => $dag_no_old,
    //                 'dag_no_new'           => $dag_no_new,
    //                 'land_class'           => $landclass,
    //             ];

    //         }

    //         $get_meeting_no = $this->SettlementCertificateModel->getMeetingNo($dhar_case_no);

    //         // generate certificate number

    //         if($type == "generate"){
    //             $certificate_no = $this->SettlementCertificateModel->generateCertificateNumber();
    //         }else{
    //             $certificate_no = "THIS IS A DRAFT CERTIFICATE";
    //         }
    //         // print_r($certificate_no);die;

    //         $getDataFromApLmNote = $this->SettlementCertificateModel->getDataFromApLmNotes($dhar_case_no);
    //         $isSettlement        = $this->SettlementCertificateModel->isSettlementorAllotment($institute_details->ins_cat_type_co, $getDataFromApLmNote); // or use: $this->SettlementCertificateModel->isSettlement($case_no);

    //         $certificate_data = [

    //             'certificate_no'             => strtoupper($certificate_no),
    //             'dhar_case_no'               => strtoupper($dhar_case_no),
    //             'application_no'             => strtoupper($application_no),
    //             'land_advisiory_proposal_no' => strtoupper($get_meeting_no->meeting_name),
    //             'lapn_date'                  => strtoupper($get_meeting_no->digital_sign_date),
    //             'certificate_date'           => date('Y-m-d'),
    //             'institute_name'             => strtoupper($institute_details->ins_name_co),
    //             'ins_category'               => $institute_details->category_name,
    //             'dist_code'                  => $location_details_settlement->dist_code,
    //             'subdiv_code'                => $location_details_settlement->subdiv_code,
    //             'cir_code'                   => $location_details_settlement->cir_code,
    //             'mouza_pargona_code'         => $location_details_settlement->mouza_pargona_code,
    //             'lot_no'                     => $location_details_settlement->lot_no,
    //             'vill_townprt_code'          => $location_details_settlement->vill_townprt_code,
    //             'district_name'              => strtoupper($location_details_raw['district_name']),
    //             'subdivision_name'           => strtoupper($location_details_raw['subdiv_name']),
    //             'circle_name'                => strtoupper($location_details_raw['cir_name']),
    //             'mouza_pargona_name'         => strtoupper($location_details_raw['mouza_name']),
    //             'lot_name'                   => strtoupper($location_details_raw['lot_name']),
    //             'village_name'               => strtoupper($location_details_raw['village_name']),
    //             'village_uuid'               => $getVillageUUID,

    //             'ins_cat_type_co'            => $institute_details->ins_cat_type_co,
    //             'issettlement'               => $isSettlement,

    //             'dag_details'                => json_encode($dagArray),

    //             'ulpin_dag_no_1'             => $ulpin1,
    //             'ulpin_dag_no_2'             => $ulpin2,
    //             'ulpin_dag_no_3'             => $ulpin3,
    //             'ulpin_dag_no_4'             => $ulpin4,
    //             'ulpin_geo_cordinates'       => strtoupper(null),
    //             'land_schedule_sketch_link'  => 'https://sewasetu.assam.gov.in/',
    //             'service_code'               => strtoupper(45),
    //             'status'                     => strtoupper(1),
    //             'other_details'              => strtoupper($otherDetails),
    //         ];

    //         // insert the data into the database

    //        if ($type == "generate") {
    //             $data['certificate_data'] = $certificate_no;
    //             $checkType = $certificate_data['ins_cat_type_co'];



    //             if ($checkType == 8) { // State Government
    //                 $html = $this->load->view('settlement_certificate/actual_certificate/settlement_certificate_state_govt', $data, true);
    //             } else if ($checkType == 9) {
    //                 $html = $this->load->view('settlement_certificate/actual_certificate/settlement_certificate_state_govt_undertaking', $data, true);
    //             } else if ($checkType == 10) {
    //                 $html = $this->load->view('settlement_certificate/actual_certificate/settlement_certificate_central_govt', $data, true);
    //             } else if ($checkType == 11) {
    //                 $html = $this->load->view('settlement_certificate/actual_certificate/settlement_certificate_central_govt_undertaking', $data, true);
    //             } else if ($checkType == 12) {
    //                 $html = $this->load->view('settlement_certificate/actual_certificate/settlement_certificate_non_govt', $data, true);
    //             } else {
    //                 $html = $this->load->view('settlement_certificate/actual_certificate/settlement_certificate', $data, true);
    //             }



    //             // rename dhar case name replace '/' with '_'
    //             $dhar_case_name = str_replace("/", "_", $dhar_case_no);
    //             $file_name = "settlement_certificate_state_govt_" . $dhar_case_name . ".txt"; // save as text file
    //             $file_path = UPLOAD_BASE . "allotment_certificate/actual_certificate/" . $file_name;

    //             // var_dump($file_path);
    //             // convert HTML to base64
    //             $base64encoded = base64_encode($html);


    //             $certificate_data['base_64_file'] = $file_path;


    //             // save base64 string into a file
    //             file_put_contents($file_path, $base64encoded);

    //             $data['base_64_file'] = base_url() . "uploads/settlement_certificate/actual_certificate/" . $file_name;
    //         }


    //         if ($type == "generateandsign") {
    //               $data['certificate_data'] = $certificate_no;
    //             $checkType = $certificate_data['ins_cat_type_co'];

    //             if ($checkType == 8) { // State Government
    //                 $html = $this->load->view('settlement_certificate/actual_certificate/settlement_certificate_state_govt', $data, true);
    //             } else if ($checkType == 9) {
    //                 $html = $this->load->view('settlement_certificate/actual_certificate/settlement_certificate_state_govt_undertaking', $data, true);
    //             } else if ($checkType == 10) {
    //                 $html = $this->load->view('settlement_certificate/actual_certificate/settlement_certificate_central_govt', $data, true);
    //             } else if ($checkType == 11) {
    //                 $html = $this->load->view('settlement_certificate/actual_certificate/settlement_certificate_central_govt_undertaking', $data, true);
    //             } else if ($checkType == 12) {
    //                 $html = $this->load->view('settlement_certificate/actual_certificate/settlement_certificate_non_govt', $data, true);
    //             } else {
    //                 $html = $this->load->view('settlement_certificate/actual_certificate/settlement_certificate', $data, true);
    //             }

    //             // rename dhar case name replace '/' with '_'
    //             $dhar_case_name = str_replace("/", "_", $dhar_case_no);
    //             $file_name = "settlement_certificate_state_govt_" . $dhar_case_name . ".txt"; // save as text file
    //             $file_path = UPLOAD_BASE . "allotment_certificate/actual_certificate/" . $file_name;

    //             // var_dump($file_path);
    //             // convert HTML to base64
    //             $base64encoded = base64_encode($html);
    //             $certificate_data['base_64_file'] = $file_path;
    //             //signed
    //             $certificate_data['signed_base_64_file'] = "";

    //             // save base64 string into a file
    //             file_put_contents($file_path, $base64encoded);

    //             $data['base_64_file'] = base_url() . "uploads/settlement_certificate/actual_certificate/" . $file_name;
           
    //         }

    //         $insert_data = $this->SettlementCertificateModel->insertOrUpdateCertificateData($certificate_data);
    //         // print($insert_data);
    //         return $insert_data;
    //     }
    // }


    public function generateCertificate($dist_code = '07', $dhar_case_no, $type)
    {

      
            $data['application_no'] = $application_no = $this->SettlementCertificateModel->getApplidFromCaseNo($dhar_case_no);
            $data['rtps_ref_no']    = $rtps_no    = $this->SettlementCertificateModel->getRtpsRefNo($application_no);

            $data['institution_details'] = $institute_details = $this->SettlementCertificateModel->getInstitutionDetails($dhar_case_no);
            $data['location_details']    = $this->SettlementCertificateModel->getLocationDetails($dhar_case_no);
            // $data['location_details'] = $location_details;
            $otherDetails = $this->SettlementCertificateModel->getOtherDetails($dhar_case_no);

            $location_details_settlement = $data['location_details']['settlement'];
            $location_details_raw        = $data['location_details'];

            $dist_code = $location_details_settlement->dist_code;
            $sub       = $location_details_settlement->subdiv_code;
            $cir       = $location_details_settlement->cir_code;
            $mou       = $location_details_settlement->mouza_pargona_code;
            $lot       = $location_details_settlement->lot_no;
            $vill      = $location_details_settlement->vill_townprt_code;

            $dept_order_no = $location_details_settlement->dept_order_no;
            $dept_order_date = $location_details_settlement->dept_order_date;

            $getVillageUUID = $this->SettlementCertificateModel->getVillageUUID($dist_code, $sub, $cir, $mou, $lot, $vill);
            // make the array for insertion into the database

            $data['dag_details'] = $dag_details = $this->SettlementCertificateModel->getDagDetails($dhar_case_no);

            $dagArray = [];

            // $this->db->trans_begin(); // start transaction
            

            foreach ($dag_details as $key => $value) {

                $applied_b  = $value->s_dag_area_b;
                $applied_k  = $value->s_dag_area_k;
                $applied_lc = $value->s_dag_area_lc;
                $applied_g  = $value->s_dag_area_g;


                $reservation = $this->SettlementCertificateModel->getReservationArea($dhar_case_no, $value->dag_no);
                // print_r($reservation);
                // die;
                $reservation_b  = $reservation['bigha'];
                $reservation_k  = $reservation['katha'];
                $reservation_lc = $reservation['lessa'];
                $reservation_g  = $reservation['ganda'];




                //////////////////
                if (in_array($value->dist_code, json_decode(BARAK_VALLEY))) {

                    $totalAppliedGanda = $this->utilityclass->Total_ganda($applied_b, $applied_k, $applied_lc, $applied_g);
                    $totalReserveGanda = $this->utilityclass->Total_ganda($reservation_b, $reservation_k, $reservation_lc, $reservation_g);

                    $totalEligibleArea = $totalAppliedGanda - $totalReserveGanda;

                    $bigha_katha_lessa_ganda = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalEligibleArea);

                    $applied_b  = $bigha_katha_lessa_ganda[0];
                    $applied_k  = $bigha_katha_lessa_ganda[1];
                    $applied_lc = $bigha_katha_lessa_ganda[2];
                    $applied_g  = $bigha_katha_lessa_ganda[3];
                    
                    $totalHectar = $this->utilityclass->get_Hec_Are_CAre2($applied_b, $applied_k, $applied_lc, $applied_g);
                    $sqrMeter    = $this->utilityclass->Total_ganda($applied_b, $applied_k, $applied_lc, $applied_g) * 4.1806368;
                } else {

                    
                    $totalAppliedLessa = $this->utilityclass->Total_Lessa($applied_b, $applied_k, $applied_lc);
                    $totalReserveLessa = $this->utilityclass->Total_Lessa($reservation_b, $reservation_k, $reservation_lc);

                    $totalEligibleArea = $totalAppliedLessa - $totalReserveLessa;

                    $bigha_katha_lessa_ganda = $this->utilityclass->Total_Bigha_Katha_Lessa($totalEligibleArea);

                    $applied_b  = $bigha_katha_lessa_ganda[0];
                    $applied_k  = $bigha_katha_lessa_ganda[1];
                    $applied_lc = $bigha_katha_lessa_ganda[2];

                    $totalHectar = $this->utilityclass->get_Hec_Are_CAre($applied_b, $applied_k, $applied_lc);
                    $sqrMeter    = $this->utilityclass->Total_Lessa($applied_b, $applied_k, $applied_lc) * 13.37803776;
                }

                if (isset($value->landmark_with_code)) {
                    // Decode the JSON data and assign the 'north' field
                    $landmark_with_code = json_decode($value->landmark_with_code, true);
                    $north              = isset($landmark_with_code['north']) ? $landmark_with_code['north'] : null;
                    $south              = isset($landmark_with_code['south']) ? $landmark_with_code['south'] : null;
                    $east               = isset($landmark_with_code['east']) ? $landmark_with_code['east'] : null;
                    $west               = isset($landmark_with_code['west']) ? $landmark_with_code['west'] : null;

                    $north_boundary_district    = $this->SettlementCertificateModel->getLocationName($north['dist_code']);
                    $north_boundary_subdivision = $this->SettlementCertificateModel->getLocationName($north['dist_code'], $north['subdiv_code']);
                    $north_boundary_circle      = $this->SettlementCertificateModel->getLocationName($north['dist_code'], $north['subdiv_code'], $north['cir_code']);
                    $north_boundary_mouza       = $this->SettlementCertificateModel->getLocationName($north['dist_code'], $north['subdiv_code'], $north['cir_code'], $north['mouza_pargona_code']);
                    $north_boundary_lot         = $this->SettlementCertificateModel->getLocationName($north['dist_code'], $north['subdiv_code'], $north['cir_code'], $north['mouza_pargona_code'], $north['lot_no']);
                    $north_boundary_village     = $this->SettlementCertificateModel->getLocationName($north['dist_code'], $north['subdiv_code'], $north['cir_code'], $north['mouza_pargona_code'], $north['lot_no'], $north['vill_townprt_code']);
                    $north_text                 = $north_boundary_district . ", " . $north_boundary_subdivision . ", " . $north_boundary_circle . ", " . $north_boundary_mouza . ", " . $north_boundary_lot . ", " . $north_boundary_village . ', Dag No: ' . $north['dag_no'];

                    $south_boundary_district    = $this->SettlementCertificateModel->getLocationName($south['dist_code']);
                    $south_boundary_subdivision = $this->SettlementCertificateModel->getLocationName($south['dist_code'], $south['subdiv_code']);
                    $south_boundary_circle      = $this->SettlementCertificateModel->getLocationName($south['dist_code'], $south['subdiv_code'], $south['cir_code']);
                    $south_boundary_mouza       = $this->SettlementCertificateModel->getLocationName($south['dist_code'], $south['subdiv_code'], $south['cir_code'], $south['mouza_pargona_code']);
                    $south_boundary_lot         = $this->SettlementCertificateModel->getLocationName($south['dist_code'], $south['subdiv_code'], $south['cir_code'], $south['mouza_pargona_code'], $south['lot_no']);
                    $south_boundary_village     = $this->SettlementCertificateModel->getLocationName($south['dist_code'], $south['subdiv_code'], $south['cir_code'], $south['mouza_pargona_code'], $south['lot_no'], $south['vill_townprt_code']);
                    $south_text                 = $south_boundary_district . ", " . $south_boundary_subdivision . ", " . $south_boundary_circle . ", " . $south_boundary_mouza . ", " . $south_boundary_lot . ", " . $south_boundary_village . ', Dag No: ' . $south['dag_no'];

                    $east_boundary_district    = $this->SettlementCertificateModel->getLocationName($east['dist_code']);
                    $east_boundary_subdivision = $this->SettlementCertificateModel->getLocationName($east['dist_code'], $east['subdiv_code']);
                    $east_boundary_circle      = $this->SettlementCertificateModel->getLocationName($east['dist_code'], $east['subdiv_code'], $east['cir_code']);
                    $east_boundary_mouza       = $this->SettlementCertificateModel->getLocationName($east['dist_code'], $east['subdiv_code'], $east['cir_code'], $east['mouza_pargona_code']);
                    $east_boundary_lot         = $this->SettlementCertificateModel->getLocationName($east['dist_code'], $east['subdiv_code'], $east['cir_code'], $east['mouza_pargona_code'], $east['lot_no']);
                    $east_boundary_village     = $this->SettlementCertificateModel->getLocationName($east['dist_code'], $east['subdiv_code'], $east['cir_code'], $east['mouza_pargona_code'], $east['lot_no'], $east['vill_townprt_code']);
                    $east_text                 = $east_boundary_district . ", " . $east_boundary_subdivision . ", " . $east_boundary_circle . ", " . $east_boundary_mouza . ", " . $east_boundary_lot . ", " . $east_boundary_village . ', Dag No: ' . $east['dag_no'];

                    $west_boundary_district    = $this->SettlementCertificateModel->getLocationName($west['dist_code']);
                    $west_boundary_subdivision = $this->SettlementCertificateModel->getLocationName($west['dist_code'], $west['subdiv_code']);
                    $west_boundary_circle      = $this->SettlementCertificateModel->getLocationName($west['dist_code'], $west['subdiv_code'], $west['cir_code']);
                    $west_boundary_mouza       = $this->SettlementCertificateModel->getLocationName($west['dist_code'], $west['subdiv_code'], $west['cir_code'], $west['mouza_pargona_code']);
                    $west_boundary_lot         = $this->SettlementCertificateModel->getLocationName($west['dist_code'], $west['subdiv_code'], $west['cir_code'], $west['mouza_pargona_code'], $west['lot_no']);
                    $west_boundary_village     = $this->SettlementCertificateModel->getLocationName($west['dist_code'], $west['subdiv_code'], $west['cir_code'], $west['mouza_pargona_code'], $west['lot_no'], $west['vill_townprt_code']);
                    $west_text                 = $west_boundary_district . ", " . $west_boundary_subdivision . ", " . $west_boundary_circle . ", " . $west_boundary_mouza . ", " . $west_boundary_lot . ", " . $west_boundary_village . ', Dag No: ' . $west['dag_no'];

                    $data['boundary_details']['east'] = $east_text;
                    $data['boundary_details']['west'] = $west_text;

                    $data['boundary_details']['north'] = $north_text;
                    $data['boundary_details']['south'] = $south_text;

                    $ulpin1 = $east['dag_no'];
                    $ulpin2 = $west['dag_no'];
                    $ulpin3 = $north['dag_no'];
                    $ulpin4 = $south['dag_no'];

                    $plotNos    = array_filter([$ulpin1, $ulpin2, $ulpin3, $ulpin4]);
                    $plotNosStr = implode(",", $plotNos); // convert array -> "21,2,23,78,56"

                    $location = $west['dist_code'] . $west['subdiv_code'] . $west['cir_code'] . $west['mouza_pargona_code'] . $west['lot_no'] . $west['vill_townprt_code'];
                    // Call API once with all dag numbers
                    $curl    = curl_init();
                    $payload = json_encode([
                        "location" => $location, // you can make dynamic if needed
                        "plotNos"  => $plotNosStr,
                    ]);

                    curl_setopt_array($curl, [
                        CURLOPT_URL            => 'https://landhub.assam.gov.in/apidemo/index.php/NicApi/ULPINs',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING       => '',
                        CURLOPT_MAXREDIRS      => 10,
                        CURLOPT_TIMEOUT        => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST  => 'POST', // should be POST (not GET) because you are sending JSON body
                        CURLOPT_POSTFIELDS     => $payload,
                        CURLOPT_HTTPHEADER     => [
                            'Content-Type: application/json',
                        ],
                    ]);

                    $response = curl_exec($curl);
                    curl_close($curl);

                    // Decode API response
                    $ulpinData = json_decode($response, true);

                    // Original plot numbers you sent
                    $plotNos = [$ulpin1, $ulpin2, $ulpin3, $ulpin4];

                    // Build a lookup array from API response
                    $ulpinMap = [];
                    if (isset($ulpinData['data']) && is_array($ulpinData['data'])) {
                        foreach ($ulpinData['data'] as $item) {
                            if (isset($item['plotNo'], $item['ULPIN'])) {
                                $ulpinMap[$item['plotNo']] = $item['ULPIN'];
                            }
                        }
                    }

                    // Assign back in "ULPIN/DAG" format
                    foreach ($plotNos as $index => $p) {
                        $ulpinVar = "ulpin" . ($index + 1); // makes ulpin1, ulpin2, etc.
                        if (isset($ulpinMap[$p])) {
                            $$ulpinVar = $ulpinMap[$p] . "/" . $p;
                        } else {
                            $$ulpinVar = "N/A/" . $p; // fallback if not found
                        }
                    }

                } else if (isset($value->landmark)) {
                    $landmark                          = $value->landmark;
                    $north                             = isset($landmark['north']) ? $landmark['north'] : null;
                    $south                             = isset($landmark['south']) ? $landmark['south'] : null;
                    $east                              = isset($landmark['east']) ? $landmark['east'] : null;
                    $west                              = isset($landmark['west']) ? $landmark['west'] : null;
                    $data['boundary_details']['north'] = isset($landmark['north']) ? $landmark['north'] : null;
                    $data['boundary_details']['south'] = isset($landmark['south']) ? $landmark['south'] : null;
                    $data['boundary_details']['east']  = isset($landmark['east']) ? $landmark['east'] : null;
                    $data['boundary_details']['west']  = isset($landmark['west']) ? $landmark['west'] : null;
                    $ulpin1                            = null;
                    $ulpin2                            = null;
                    $ulpin3                            = null;
                    $ulpin4                            = null;
                } else {
                    $data['boundary_details']['north'] = "Unidentified";
                    $data['boundary_details']['south'] = "Unidentified";
                    $data['boundary_details']['east']  = "Unidentified";
                    $data['boundary_details']['west']  = "Unidentified";

                    $ulpin1 = null;
                    $ulpin2 = null;
                    $ulpin3 = null;
                    $ulpin4 = null;
                }
                $landclass = $this->utilityclass->getLandClassCode($value->new_land_class_code);
                $dag_nos   = $this->SettlementCertificateModel->getChithaDagNosByOldDag($dhar_case_no, $value->dag_no);

                $dag_no_old = $value->dag_no ?? null;
                $dag_no_new = $dag_nos->dag_no ?? null;

                if($dag_no_new == 0){
                    $dag_no_new = $dag_no_old;
                }




                $dagArray[] = [
                    'bigha'                => $applied_b,
                    'katha'                => $applied_k,
                    'lessa'                => $applied_lc,
                    'ganga'                => $applied_g,
                    'total_hectare'        => $totalHectar,
                    'total_square_meter'   => $sqrMeter,
                    'land_class_code'      => $value->new_land_class_code,
                    'boundary_description' => $data['boundary_details'],
                    'dag_no_old'           => $dag_no_old,
                    'dag_no_new'           => $dag_no_new,
                    'land_class'           => $landclass,
                ];

                $pattaDetails = $this->SettlementCertificateModel->getPattaDetails($dist_code, $sub, $cir, $mou, $lot, $vill, $dag_no_old, $dag_no_new);


                if ($pattaDetails && ! isset($dagArray[0]['patta_details'])) {

                    if($pattaDetails->old_patta_no == ''){
                        $old_patta_no = 0;
                    }else{
                        $old_patta_no = $pattaDetails->old_patta_no;
                    }
                    $dagArray[0]['patta_details'] = [
                        'dag_revenue'     => $pattaDetails->dag_revenue,
                        'dag_local_tax'   => $pattaDetails->dag_local_tax,
                        'patta_type_code' => $pattaDetails->patta_type_code,
                        'patta_no'        => $pattaDetails->patta_no,
                        'old_patta_no'    => $old_patta_no,
                        'patta_type_name' => $this->utilityclass->getPattaName($pattaDetails->patta_type_code),
                    ];
                }

            }

            $get_meeting_no = $this->SettlementCertificateModel->getMeetingNo($dhar_case_no);

            // generate certificate number
            if($type == "generate"){
                $certificate_no = $this->SettlementCertificateModel->generateCertificateNumber();
            }else{
                $certificate_no = "THIS IS A DRAFT CERTIFICATE";
            }
            $getDataFromApLmNote = $this->SettlementCertificateModel->getDataFromApLmNotes($dhar_case_no);
            $isSettlement        = $this->SettlementCertificateModel->isSettlementorAllotment($institute_details->ins_cat_type_co, $getDataFromApLmNote); // or use: $this->SettlementCertificateModel->isSettlement($case_no);
            
             if($institute_details->ins_cat_type_co == 12){
                $purpose =  null;
                $allDataFromPurpose = $this->SettlementCertificateModel->getPruposeBycaseNo($dhar_case_no);

                $purpose_land_allot_co = $allDataFromPurpose->purpose_land_allot_co;
                
                $venture_type          = $allDataFromPurpose->venture_type ?? null;
                $under_venture_school  = $allDataFromPurpose->under_venture_school  ?? null;


                if($purpose_land_allot_co == "education"  && ($under_venture_school == 'NO' || $under_venture_school == NULL)){
                    $purpose = "eductaion-non-venture";
                }

                if($purpose_land_allot_co == "education"  && $under_venture_school == 'YES' && $venture_type =='unrecognised_venture'){
                    $purpose = "eductaion-unrecognized-venture";
                }


                if($purpose_land_allot_co == "education"  && $under_venture_school == 'YES' && $venture_type =='govt_aided_venture'){
                    $purpose = "eductaion-govt-aidded";
                }

                if($purpose_land_allot_co == "religious" || $purpose_land_allot_co =="socioculture"){
                    $purpose = 'religious-socio-culture';
                }
            }

            // if($institute_details->ins_cat_type_co == 12 && $purpose == null){
            //     echo "Purpose Not Found";
            //     die;
            // }

            $certificate_data = [

                'certificate_no'             => strtoupper($certificate_no),
                'dhar_case_no'               => strtoupper($dhar_case_no),
                'application_no'             => strtoupper($application_no),
                'land_advisiory_proposal_no' => strtoupper($get_meeting_no->meeting_name),
                'lapn_date'                  => strtoupper($get_meeting_no->digital_sign_date),
                'certificate_date'           => date('Y-m-d'),
                'institute_name'             => strtoupper($institute_details->ins_name_co),
                'ins_category'               => $institute_details->category_name,
                'dist_code'                  => $location_details_settlement->dist_code,
                'subdiv_code'                => $location_details_settlement->subdiv_code,
                'cir_code'                   => $location_details_settlement->cir_code,
                'mouza_pargona_code'         => $location_details_settlement->mouza_pargona_code,
                'lot_no'                     => $location_details_settlement->lot_no,
                'vill_townprt_code'          => $location_details_settlement->vill_townprt_code,
                'district_name'              => strtoupper($location_details_raw['district_name']),
                'subdivision_name'           => strtoupper($location_details_raw['subdiv_name']),
                'circle_name'                => strtoupper($location_details_raw['cir_name']),
                'mouza_pargona_name'         => strtoupper($location_details_raw['mouza_name']),
                'lot_name'                   => strtoupper($location_details_raw['lot_name']),
                'village_name'               => strtoupper($location_details_raw['village_name']),
                'village_uuid'               => $getVillageUUID,

                'ins_cat_type_co'            => $institute_details->ins_cat_type_co,
                'issettlement'               => $isSettlement,

                'dag_details'                => json_encode($dagArray),

                'ulpin_dag_no_1'             => $ulpin1,
                'ulpin_dag_no_2'             => $ulpin2,
                'ulpin_dag_no_3'             => $ulpin3,
                'ulpin_dag_no_4'             => $ulpin4,
                'ulpin_geo_cordinates'       => strtoupper(null),
                'land_schedule_sketch_link'  => 'https://sewasetu.assam.gov.in/',
                'service_code'               => strtoupper(45),
                'status'                     => strtoupper(1),
                'other_details'              => strtoupper($otherDetails),
                'purpose_land_allot_co'      => $purpose ?? null,
                'dept_order_no'              => $dept_order_no ?? null,
                'dept_order_date'            => $dept_order_date ?? null
            ];

            // insert the data into the database

            $parts = explode("/", $application_no);

            // Get the last part (1046)
            $lastPart = array_pop($parts);

            // Generate 4 random digits
            $randomDigits = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

            // Replace last part with modified one
            $parts[] = $randomDigits . $lastPart;

            // Join back together
            $modified_application_no = implode("/", $parts);


            $appNo = base64_encode($modified_application_no);

            $query = $this->db->query("select * from supportive_document_mobile where applid=?", [$application_no]);
            if ($query->num_rows() == 0) {
                echo "Supportive Document Not Found " . $application_no;
                die;
            } else {
                $result = $query->row();
                $lat    = $result->lat;
                $lng    = $result->long;
            }


            if ($type == "generate") {
                $data['certificate_data'] = (object) $certificate_data;
                $data['base_64_qr_geo_cordinates'] = printQR("https://basundhara.assam.gov.in/rtpsmb/QRData/viewgeocordinates?dc=" . $dist_code . "&app_no=" . $appNo);
                $data['base_64_qr_sketch']         = printQR("https://basundhara.assam.gov.in/rtpsmb/QRData/viewgeocordinatesSketch?dc=" . $dist_code . "&app_no=" . $appNo);
                $data['base_64_qr_google']         = printQR("https://www.google.com/maps/place/" . $lat . "," . $lng);
                $data['dag_sketch_qr_photos']      = printQR("https://basundhara.assam.gov.in/rtpsmb/QRData/getSketchOfTheDagForDigitalPatta?dc=$dist_code&app_no=$appNo");
                $data['base_64_qr']                = printQR("https://basundhara.assam.gov.in/rtpsmb/QRData/viewCertificate?dc=" . $dist_code . "&app_no=" . $appNo);    
                // print_r($certificate_data);die;


                $checkType = $certificate_data['ins_cat_type_co'];
                $purpose_land_allot_co = $certificate_data['purpose_land_allot_co'];



                 if ($checkType == 9) {
                    $html = $this->load->view('settlement_certificate/actual_certificate/state_govt_undertaking', $data, true);
                }else if ($checkType == 11) {
                    $html = $this->load->view('settlement_certificate/actual_certificate/central_govt_undertaking', $data, true);
                } else if ($checkType == 12) {
                    $html = $this->load->view('settlement_certificate/actual_certificate/non_govt', $data, true);
                }else{
                    echo "Invalid Institute Type";
                    die;
                }

                
                // // Render certificate directly
                // header('Content-Type: text/html; charset=utf-8');
                // echo $html;
                // exit;


                // rename dhar case name replace '/' with '_'
                $dhar_case_name = str_replace("/", "_", $dhar_case_no);
                $file_name = "settlement_certificate_state_govt_" . $dhar_case_name . ".txt"; // save as text file
                $file_path = UPLOAD_BASE . "allotment_certificate/actual_certificate/" . $file_name;

                // var_dump($file_path);
                // convert HTML to base64
                $base64encoded = base64_encode($html);

                //send this to the rtps side

                // upload notice API
                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3 . "upload_allotment_and_settlement_certificate");
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query([
                    'encoded_file'   => $base64encoded,
                    'application_no' => $application_no,
                ]));
                $result = curl_exec($curl_handle);

                if (trim($result) != 'y') {
                    $this->db->trans_rollback();
                    log_message('message', "#KHASPAYAPI0011  Payment notice  could not be generated...");
                    exit;
                } else {
                    $this->db->trans_commit();
                    log_message('message', "Payment notice successfully saved...");
                }

                $certificate_data['base_64_file'] = $file_path;


                // save base64 string into a file
                file_put_contents($file_path, $base64encoded);

                $data['base_64_file'] = base_url() . "uploads/settlement_certificate/actual_certificate/" . $file_name;
            }


            if ($type == "sign_and_generate") {
                // $data['certificate_data'] = (object) $certificate_no;

                

                // use $data['certificate_data'] everywhere
                $checkType = $certificate_data['ins_cat_type_co'];

                if ($checkType == 9) {
                    $html = $this->load->view('settlement_certificate/actual_certificate/state_govt_undertaking', $data, true);
                }else if ($checkType == 11) {
                    $html = $this->load->view('settlement_certificate/actual_certificate/central_govt_undertaking', $data, true);
                } else if ($checkType == 12) {
                    $html = $this->load->view('settlement_certificate/actual_certificate/non_govt', $data, true);
                }else {
                    $this->db->trans_commit();
                    log_message('message', "Payment notice successfully saved...");
                }

                // header('Content-Type: text/html; charset=utf-8');
                // echo $html;
                // exit;
            }


            $insert_data = $this->SettlementCertificateModel->insertOrUpdateCertificateData($certificate_data);
            // print($insert_data);
            return $insert_data;
        // }
    }


    public function getAllotmentCertificate()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);

        $dhar_case_no = $_POST['case_no'];
        $dist_code    = $_POST['dist_code'];
        $insert_data  = $this->generateCertificate($dist_code, $dhar_case_no, "view");

        if ($insert_data['result'] == 'ERROR') {
            $string = $this->load->view('settlement_certificate/no-certificate', $insert_data, true);
            echo json_encode($string);
        } else {

            $getCertifacteData        = $this->SettlementCertificateModel->getCertificateData($dhar_case_no);
            $data['certificate_data'] = $getCertifacteData;
            // $data['patta_info'] = $this->SettlementCertificateModel->getPattaInfo($dhar_case_no);
            $data['district_name_eng'] = $this->SettlementCertificateModel->getDistrictNameEng($dist_code);
            // if(!$data['patta_info']['result']){

            $data['application_no'] = $application_no = $this->SettlementCertificateModel->getApplidFromCaseNo($dhar_case_no);


             // Split by slash
            $parts = explode("/", $application_no);

            // Get the last part (1046)
            $lastPart = array_pop($parts);

            // Generate 4 random digits
            $randomDigits = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

            // Replace last part with modified one
            $parts[] = $randomDigits . $lastPart;

            // Join back together
            $modified_application_no = implode("/", $parts);


            $appNo = base64_encode($modified_application_no);



            // $appNo = urlencode(base64_encode($application_no));

            $query = $this->db->query("select * from supportive_document_mobile where applid=?", [$application_no]);
            if ($query->num_rows() == 0) {
                echo "Supportive Document Not Found " . $application_no;
                die;
            } else {
                $result = $query->row();
                $lat    = $result->lat;
                $lng    = $result->long;
            }

            $data['base_64_qr_geo_cordinates'] = printQR("https://basundhara.assam.gov.in/rtpsmb/QRData/viewgeocordinates?dc=" . $dist_code . "&app_no=" . $appNo);
            $data['base_64_qr_sketch']         = printQR("https://basundhara.assam.gov.in/rtpsmb/QRData/viewgeocordinatesSketch?dc=" . $dist_code . "&app_no=" . $appNo);
            $data['base_64_qr_google']         = printQR("https://www.google.com/maps/place/" . $lat . "," . $lng);
            $data['dag_sketch_qr_photos']      = printQR("https://basundhara.assam.gov.in/rtpsmb/QRData/getSketchOfTheDagForDigitalPatta?dc=$dist_code&app_no=$appNo");
            $data['base_64_qr']                = printQR("https://basundhara.assam.gov.in/rtpsmb/QRData/viewCertificate?dc=" . $dist_code . "&app_no=" . $appNo);    

            $checkType = (int) $this->SettlementCertificateModel->checkType($dhar_case_no)->ins_cat_type_co;

            // if ($checkType == 8) { //State Government
            //     $string = $this->load->view('settlement_certificate/settlement_certificate_state_govt', $data, true);
            // } else
             if ($checkType == 9) { //State Government Under Taking
                $string = $this->load->view('settlement_certificate/state_govt_undertaking', $data, true);
             }// else if ($checkType == 10) { //Central Government
            //     $string = $this->load->view('settlement_certificate/central_govt', $data, true);
            // } 
            else if ($checkType == 11) { //Central Government UnderTaking
                $string = $this->load->view('settlement_certificate/central_govt_undertaking', $data, true);
            } else if ($checkType == 12) { //Non Goverment
                $string = $this->load->view('settlement_certificate/non_govt', $data, true);
            } else {

                //$data['dag_sketch_qr_code'] = printQR("https://basundhara.assam.gov.in/rtpsmb/sikriticontroller/getSketchOfTheDagForDigitalPatta/$dist_code/$dag_no/$encrypted_app_no");
                $string = $this->load->view('settlement_certificate/no_certificate', $data, true);
            }
            echo json_encode($string);
        }
    }



    





    
// public function genratetheArrays($case_no = null)
    // {
    //     if ($case_no == null) {

//         $case_no = 'DIB/DIBW/2024-25/65815/SLIJE';
    //     }
    //     $this->db->trans_begin();
    //     echo $response = $this->SettlementCertificateModel->genArrayForCithaUpdate($case_no);

//     $result = json_decode($response);
    //     if ($result->responseType == 2) {
    //         // $this->db->trans_commit();

//         $this->db->trans_rollback();
    //         $passedcases[] = [$case_no];
    //     } else {
    //         $this->db->trans_rollback();
    //         $final[] = [$case_no];
    //         log_message('error', '#ERRINS008888##' . json_encode($result->error));
    //     }
    // }

    public function genratetheArrays($case_no = null)
    {
        // If not passed in function call, try to get from GET
        if ($case_no === null) {
            $case_no = $this->input->get('case_no');
        }

        // If still empty, set default
        if (empty($case_no)) {
            $case_no = 'DIB/DIBW/2024-25/65815/SLIJE';
        }

        $this->db->trans_begin();
        echo $response = $this->SettlementCertificateModel->genArrayForCithaUpdate($case_no);

        $result = json_decode($response);
        if ($result->responseType == 2) {
            $this->db->trans_rollback();
            $passedcases[] = [$case_no];
        } else {
            $this->db->trans_rollback();
            $final[] = [$case_no];
            log_message('error', '#ERRINS008888##' . json_encode($result->error));
        }
    }

    public function getAllDigitalPattaDetails()
    {
        $json       = null;
        $draw       = intval($this->input->post('draw'));
        $start      = intval($this->input->post('start'));
        $length     = intval($this->input->post('length'));
        $order      = $this->input->post('order');

        $selectService = $this->input->post('selectService');
        $selectVillage  = $this->input->post('selectVillage');
        $selectCircle = $this->input->post('selectCircle');


        // print_r($_POST);
        // die;
        $cases_list = $this->SettlementCertificateModel->getAllCasesAllocatedCertificate($start, $length, $order, $selectService, $selectVillage, $selectCircle);

        if (! empty($cases_list)) {

            if ($cases_list['total_records'] > 0) {

                $data_rows = $cases_list['data_results'];

                foreach ($data_rows as $row) {
                    $case_no        = $row->case_no;
                    $application_no = $row->applid;

                    $serviceMap = [
                        '8'  => ['name' => "State Government", 'color' => "green"],
                        '9'  => ['name' => "State Government Undertaking", 'color' => "blue"],
                        '10' => ['name' => "Central Government", 'color' => "red"],
                        '11' => ['name' => "Central Government Undertaking", 'color' => "orange"],
                        '12' => ['name' => "Non Government", 'color' => "purple"],
                    ];

                    //now get this from the constant


                    // $serviceData = $serviceMap[$row->ins_cat_type_co] ?? ['name' => "Unknown", 'color' => "black"];

                   $services = json_decode(SERVICE_MAP_ALLOMENT_AND_SETTLEMENT, true);

                    // Default service data
                    $serviceData = ['name' => "Unknown", 'color' => "black"];

                    // Search for the service by id
                    if (is_array($services)) {
                        foreach ($services as $service) {
                            if ($service['id'] === (string)$row->ins_cat_type_co) {
                                $serviceData = $service;
                                break;
                            }
                        }
                    }

                    // Generate the HTML span
                    $service = '<span style="
                            display:inline-block;
                            padding:2px 6px;
                            font-size:12px;
                            font-weight:bold;
                            color:white;
                            background-color:' . $serviceData['color'] . ';
                            border-radius:4px;
                        ">'
                        . $serviceData['name'] .
                        '</span>';


                    $dated_at   = date('d-M-Y', strtotime($row->date_entry));
                    $created_at = $dated_at;

                    $category_type = "<small class='case-no-bg'>" . $this->utilityclass->getDistrictName($row->dist_code) . "</small>";
                    $district      = "<small class='case-no-bg'>" . $this->utilityclass->getDistrictName($row->dist_code) . "</small>";

                    $circle  = "<small class='case-no-bg'>" . $this->utilityclass->getCircleName($row->dist_code, $row->subdiv_code, $row->cir_code) . "</small>";
                    $village = "<small class='case-no-bg'>" . $this->utilityclass->getVillageName($row->dist_code, $row->subdiv_code, $row->cir_code, $row->mouza_pargona_code, $row->lot_no, $row->vill_townprt_code) . "</small>";
                    $button1 = '<button type="button" class="btn btn-sm btn-danger" onclick="viewDigitalPatta(\'' . $row->case_no . '\', \'' . $row->dist_code . '\')"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;View</button>';
                    //$button2 = '<button type="button" class="btn btn-sm btn-success" onclick="viewDigitalPatta(\'' . $row->case_no . '\', \'' . $row->dist_code . '\')"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;Download</button>';

                    $json[] = [
                        $row->case_no,
                        $case_no,
                        $application_no,
                        $service,
                        $created_at,
                        $district,
                        $circle,
                        $village,
                        $button1,
                    ];
                }
            } else {
                $json = "";
            }
            $total_records = $cases_list['total_records'];
            $response      = [
                'draw'            => $draw,
                'recordsTotal'    => $total_records,
                'recordsFiltered' => $total_records,
                'data'            => $json,
            ];
            echo json_encode($response);
        } else {
            $response                         = [];
            $response['sEcho']                = 0;
            $response['iTotalRecords']        = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData']               = [];
            echo json_encode($response);
        }
    }

    public function getAllDigitalPattaDetailsIssuedv2()
    {
        $json   = null;
        $draw   = intval($this->input->post('draw'));
        $start  = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order  = $this->input->post('order');

        $selectService = $this->input->post('selectService');
        $selectVillage  = $this->input->post('selectVillage');
        $selectCircle = $this->input->post('selectCircle');


        // print_r($_POST);
        // die;
        $cases_list = $this->SettlementCertificateModel->getAllCasesAllocatedCertificateIssuedv2($start, $length, $order, $selectService, $selectVillage, $selectCircle);


        // $cases_list = $this->SettlementCertificateModel->getAllCasesAllocatedCertificateIssuedv2($start, $length, $order);

        if (! empty($cases_list)) {

            if ($cases_list['total_records'] > 0) {

                $data_rows = $cases_list['data_results'];

                foreach ($data_rows as $row) {
                    $case_no        = $row->case_no;
                    $application_no = $row->applid;

                    $serviceMap = [
                        '8'  => ['name' => "State Government", 'color' => "green"],
                        '9'  => ['name' => "State Government Undertaking", 'color' => "blue"],
                        '10' => ['name' => "Central Government", 'color' => "red"],
                        '11' => ['name' => "Central Government Undertaking", 'color' => "orange"],
                        '12' => ['name' => "Non Government", 'color' => "purple"],
                    ];

                    $serviceData = $serviceMap[$row->ins_cat_type_co] ?? ['name' => "Unknown", 'color' => "black"];

                    $service = '<span style="
                            display:inline-block;
                            padding:2px 6px;
                            font-size:12px;
                            font-weight:bold;
                            color:white;
                            background-color:' . $serviceData['color'] . ';
                            border-radius:4px;
                        ">'
                        . $serviceData['name'] .
                        '</span>';

                    $dated_at   = date('d-M-Y', strtotime($row->date_entry));
                    $created_at = $dated_at;

                    $category_type = "<small class='case-no-bg'>" . $this->utilityclass->getDistrictName($row->dist_code) . "</small>";
                    $district      = "<small class='case-no-bg'>" . $this->utilityclass->getDistrictName($row->dist_code) . "</small>";

                    $circle  = "<small class='case-no-bg'>" . $this->utilityclass->getCircleName($row->dist_code, $row->subdiv_code, $row->cir_code) . "</small>";
                    $village = "<small class='case-no-bg'>" . $this->utilityclass->getVillageName($row->dist_code, $row->subdiv_code, $row->cir_code, $row->mouza_pargona_code, $row->lot_no, $row->vill_townprt_code) . "</small>";

                    $dist_code   = $row->dist_code;
                    $enc_case_no = urlencode(base64_encode($row->case_no));

                    // var_dump("ds");
                    // exit;

                    $button1 = '<a href="' . site_url('ViewDetails?case_no=' . $enc_case_no . '&dist_code=' . $dist_code) . '" class="btn btn-sm btn-danger"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;View</a>'; //<button type="button" class="btn btn-sm btn-danger" onclick="viewIssuedDigitalPatta(\'' . $enc_case_no . '\', \'' . $dist_code . '\')"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;View</button>';


                     $status = $row->printing_status == 1 
    ? '<i class="fa fa-print text-primary"></i> <i class="fa fa-check-circle text-success"></i>'   // Printed
    : '<i class="fa fa-print text-muted"></i> <i class="fa fa-times-circle text-danger"></i>';    // Not Printed
  // Not Printed (red cross)

                    // $button1 = '<button type="button" class="btn btn-sm btn-danger" onclick="viewDigitalPatta(\'' . $row->case_no . '\', \'' . $row->dist_code . '\')"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;View</button>';
                    //$button2 = '<button type="button" class="btn btn-sm btn-success" onclick="viewDigitalPatta(\'' . $row->case_no . '\', \'' . $row->dist_code . '\')"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;Download</button>';

                    $json[] = [
                        $row->case_no,
                        $case_no,
                        $application_no,
                        $service,
                        $created_at,
                        $district,
                        $circle,
                        $village,
                        $status,
                        $button1,
                    ];
                }
            } else {
                $json = "";
            }
            $total_records = $cases_list['total_records'];
            $response      = [
                'draw'            => $draw,
                'recordsTotal'    => $total_records,
                'recordsFiltered' => $total_records,
                'data'            => $json,
            ];
            echo json_encode($response);
        } else {
            $response                         = [];
            $response['sEcho']                = 0;
            $response['iTotalRecords']        = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData']               = [];
            echo json_encode($response);
        }
    }

    // public function bulkApproveCasesOfDigitalPattaWithoutDigitalSignWithoutPdf()
    // {
    //     $_POST = json_decode(file_get_contents("php://input"), true);

    //     // var_dump($_POST);
    //     // exit();
    //     $dhar_case_no_list = $_POST['selectedList'];
    //     $string            = '';
    //     $dhar_case_no      = '';
    //     $base64array       = [];
    //     $entire_page       = '';
    //     $failed_case       = [];

    //     $all_failed_case = '0';

    //     foreach ($dhar_case_no_list as $key => $dhar_case_no) {
    //         // $passed_cases = array();
    //         $data['application_no'] = $application_no = $this->SettlementCertificateModel->getApplidFromCaseNo($dhar_case_no);
    //         $data['rtps_no']        = $rtps_no        = $this->SettlementCertificateModel->getRtpsRefNo($application_no);
    //         $data['patta_info']     = $patta_info     = $this->SettlementCertificateModel->getPattaInfo($application_no);
    //         $check_partial          = $this->SettlementCertificateModel->checkPartialPayment($dhar_case_no);
    //         if ($check_partial == 'Y') {
    //             // $check_chitha_update_status = $this->DigitalPattaCommonModel->checkChithaUpdateStatusForPartialPayment($dhar_case_no);
    //             // if($check_chitha_update_status =='N'){
    //             //     log_message("error","chitha not updated for case no".$dhar_case_no);
    //             //     echo json_encode(['flag' => 'N', 'msg' =>"Chitha is not Updated for the case no: ".$dhar_case_no]);
    //             //     exit;   
    //             // }                

    //             // $data['checkBasundhara']  = $this->DigitalPattaCommonModel->checkPartialPaymentStatusInBasundhara($application_no);
    //             // if($data['checkBasundhara']['result'] =='SERVER-ERROR'){
    //             //     echo json_encode(['flag' => 'N', 'msg' =>$data['checkBasundhara']['msg']]);
    //             //     exit; 
    //             // }
    //         }
    //         if (! $data['patta_info']['result']) {

    //             //echo json_encode([$data['patta_info']]);
    //             //echo json_encode(['flag' => 'N', 'msg' =>$data['patta_info']['msg']]);
    //             array_push($failed_case, $data['patta_info']['case_no']);
    //             $all_failed_case = implode(",", $failed_case) . "<br>";
    //             continue;
    //         }
    //         // else{
    //         //     array_push($passed_cases,$patta_info);
    //         // }
    //         $insert_all_data = $this->SettlementCertificateModel->insertAllAllocatedCertificateDataWithoutPdf($application_no, $rtps_no, $patta_info, $dhar_case_no);

    //         if ($insert_all_data['result'] == 'SERVER-ERROR') {
    //             echo json_encode(['flag' => 'N', 'msg' => $insert_all_data['msg']]);
    //             exit;
    //         }

    //     }
    //     if ($all_failed_case == null) {
    //         $all_failed_case = '0';
    //     }
    //     echo json_encode(['flag' => 'Y', 'msg' => "Process completed... <br><br>Failed cases: $all_failed_case !"]);
    // }

    public function bulkApproveCasesOfDigitalPattaWithoutDigitalSignWithoutPdf()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);

        // var_dump($_POST);
        // exit();
        $dhar_case_no_list = $_POST['selectedList'];
        $string            = '';
        $dhar_case_no      = '';
        $base64array       = [];
        $entire_page       = '';
        $failed_case       = [];

        $all_failed_case = [];
        $allCase         = [];
        $dist_code       = $this->session->userdata('dist_code');

         if(count($dhar_case_no_list) == 0){
        echo json_encode([
            'flag' => 'N',
            'msg'  => 'Please select at least one case'
        ]);
        return;
    }if(count($dhar_case_no_list) > 10){
        echo json_encode([
            'flag' => 'N',
            'msg'  => 'Please select less than 10 cases'
        ]);
        return;
    }



        foreach ($dhar_case_no_list as $key => $dhar_case_no) {
            log_message("info", "AllotmentCetificate Processing for Case No: " . $dhar_case_no);
            try {
                $status = $this->generateCertificate($dist_code, $dhar_case_no, "generate");
                if ($status != true) {
                    $all_failed_case[] = $dhar_case_no;
                    log_message("error", "Failed for Case No: " . $dhar_case_no . " | Error: " . $e->getMessage());
                } else {
                    $updateStatus = $this->SettlementCertificateModel->updateSettlementBasicTable($dhar_case_no);
                    if ($updateStatus == false) {
                        $all_failed_case[] = $dhar_case_no;
                        log_message("error", "Failed for Case No: " . $dhar_case_no . " | Error: " . "Failed to update settlement basic table");
                    } else {
                        log_message('info', "AllotmentCetificate Process Complete for Case No: " . $dhar_case_no . " | Success");
                    }
                }
            } catch (Exception $e) {
                // add to failed cases
                $all_failed_case[] = $dhar_case_no;
                log_message("error", "Failed for Case No: " . $dhar_case_no . " | Error: " . $e->getMessage());
            }
            $allCase[] = $dhar_case_no;
        }

        // Prepare failed cases
        if (count($all_failed_case) == 0) {
            $all_failed_case = '0';
        } else {
            $all_failed_case = implode(",", $all_failed_case) . "<br>";
        }

        // Prepare passed cases
        if (! empty($allCase)) {
            $allPassedCase = implode(",", $allCase) . "<br>";
        }

        echo json_encode(['flag' => 'Y', 'msg' => "Process completed... $allPassedCase <br><br>Failed cases: $all_failed_case !"]);
    }



    public function signAndBulkCasesApproveSubmit()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);

        // var_dump($_POST);
        // exit();
        $dhar_case_no_list = $_POST['selectedList'];
        $string            = '';
        $dhar_case_no      = '';
        $base64array       = [];
        $entire_page       = '';
        $failed_case       = [];

        $all_failed_case = [];
        $allCase         = [];

         if(count($dhar_case_no_list) == 0){
        echo json_encode([
            'flag' => 'N',
            'msg'  => 'Please select at least one case'
        ]);
        return;
    }if(count($dhar_case_no_list) > 10){
        echo json_encode([
            'flag' => 'N',
            'msg'  => 'Please select less than 10 cases'
        ]);
        return;
    }

        foreach ($dhar_case_no_list as $key => $dhar_case_no) {
            log_message("info", "AllotmentCetificate Processing for Case No: " . $dhar_case_no);
            try {
                $status = $this->generateCertificate($dist_code, $dhar_case_no, "generate");
                if ($status != true) {
                    $all_failed_case[] = $dhar_case_no;
                    log_message("error", "Failed for Case No: " . $dhar_case_no . " | Error: " . $e->getMessage());
                } else {
                    $updateStatus = $this->SettlementCertificateModel->updateSettlementBasicTable($dhar_case_no);
                    if ($updateStatus == false) {
                        $all_failed_case[] = $dhar_case_no;
                        log_message("error", "Failed for Case No: " . $dhar_case_no . " | Error: " . "Failed to update settlement basic table");
                    } else {
                        log_message('info', "AllotmentCetificate Process Complete for Case No: " . $dhar_case_no . " | Success");
                    }
                }
            } catch (Exception $e) {
                // add to failed cases
                $all_failed_case[] = $dhar_case_no;
                log_message("error", "Failed for Case No: " . $dhar_case_no . " | Error: " . $e->getMessage());
            }
            $allCase[] = $dhar_case_no;
        }

        // Prepare failed cases
        if (count($all_failed_case) == 0) {
            $all_failed_case = '0';
        } else {
            $all_failed_case = implode(",", $all_failed_case) . "<br>";
        }

        // Prepare passed cases
        if (! empty($allCase)) {
            $allPassedCase = implode(",", $allCase) . "<br>";
        }

        echo json_encode(['flag' => 'Y', 'msg' => "Process completed... $allPassedCase <br><br>Failed cases: $all_failed_case !"]);
    }




    public function issued()
    {
         $allowed = ['CO','DC'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }
        $data['dist_code']   = $dist_code   = $this->session->userdata('dist_code');

        $data['villages'] = $this->SettlementCertificateModel->getAllVillages($dist_code, null);
        $data['circles']  = $this->SettlementCertificateModel->getAllCircles($dist_code, null);


        if (ALLOTMENT_AND_SETTLEMENT == 1) {
            $data['certificate'] = $this->SettlementCertificateModel->getAllotmentCertificatesIssued($dist_code);
            $data['_view']       = 'settlement_certificate/issued_landing_page';
        } else {
            $data['_view'] = 'settlement_certificate/closed';
        }
        $this->load->view('layouts/main', $data);
    }


    public function getVillagesByCircle(){
        $dist_code = $this->input->post('dist_code');
        $circle_id = $this->input->post('circle_id');
        $villages = $this->SettlementCertificateModel->getAllVillages($dist_code, $circle_id);
        echo json_encode($villages);
    }

        public function generateCertificateTest($dist_code = '07', $dhar_case_no="BON/BON/2024-25/35323/SLIJE", $type="generate")
    {
    
        $dhar_case_no = $this->input->get('dhar_case_no') ?? 'BON/BON/2024-25/35323/SLIJE';

        // check if already generated certificate for this case
        // $certificate_no = $this->SettlementCertificateModel->getCertificateData($dhar_case_no);



        // if ($certificate_no != 'NOT-FOUND') {
        //     return ['result' => "NO ERROR"];
        // } else {
            $data['application_no'] = $application_no = $this->SettlementCertificateModel->getApplidFromCaseNo($dhar_case_no);
            $data['rtps_ref_no']    = $rtps_no    = $this->SettlementCertificateModel->getRtpsRefNo($application_no);

            $data['institution_details'] = $institute_details = $this->SettlementCertificateModel->getInstitutionDetails($dhar_case_no);
            $data['location_details']    = $this->SettlementCertificateModel->getLocationDetails($dhar_case_no);
            // $data['location_details'] = $location_details;
            $otherDetails = $this->SettlementCertificateModel->getOtherDetails($dhar_case_no);

            $location_details_settlement = $data['location_details']['settlement'];
            $location_details_raw        = $data['location_details'];

            $dist_code = $location_details_settlement->dist_code;
            $sub       = $location_details_settlement->subdiv_code;
            $cir       = $location_details_settlement->cir_code;
            $mou       = $location_details_settlement->mouza_pargona_code;
            $lot       = $location_details_settlement->lot_no;
            $vill      = $location_details_settlement->vill_townprt_code;

            $getVillageUUID = $this->SettlementCertificateModel->getVillageUUID($dist_code, $sub, $cir, $mou, $lot, $vill);
            // make the array for insertion into the database

            $data['dag_details'] = $dag_details = $this->SettlementCertificateModel->getDagDetails($dhar_case_no);

            $dagArray = [];

            

            foreach ($dag_details as $key => $value) {

                $applied_b  = $value->s_dag_area_b;
                $applied_k  = $value->s_dag_area_k;
                $applied_lc = $value->s_dag_area_lc;
                $applied_g  = $value->s_dag_area_g;
                //////////////////
                if (in_array($value->dist_code, json_decode(BARAK_VALLEY))) {
                    $totalHectar = $this->utilityclass->get_Hec_Are_CAre2($applied_b, $applied_k, $applied_lc, $applied_g);
                    $sqrMeter    = $this->utilityclass->Total_ganda($applied_b, $applied_k, $applied_lc, $applied_g) * 4.1806368;
                } else {
                    $totalHectar = $this->utilityclass->get_Hec_Are_CAre($applied_b, $applied_k, $applied_lc);
                    $sqrMeter    = $this->utilityclass->Total_Lessa($applied_b, $applied_k, $applied_lc) * 13.37803776;
                }

                if (isset($value->landmark_with_code)) {
                    // Decode the JSON data and assign the 'north' field
                    $landmark_with_code = json_decode($value->landmark_with_code, true);
                    $north              = isset($landmark_with_code['north']) ? $landmark_with_code['north'] : null;
                    $south              = isset($landmark_with_code['south']) ? $landmark_with_code['south'] : null;
                    $east               = isset($landmark_with_code['east']) ? $landmark_with_code['east'] : null;
                    $west               = isset($landmark_with_code['west']) ? $landmark_with_code['west'] : null;

                    $north_boundary_district    = $this->SettlementCertificateModel->getLocationName($north['dist_code']);
                    $north_boundary_subdivision = $this->SettlementCertificateModel->getLocationName($north['dist_code'], $north['subdiv_code']);
                    $north_boundary_circle      = $this->SettlementCertificateModel->getLocationName($north['dist_code'], $north['subdiv_code'], $north['cir_code']);
                    $north_boundary_mouza       = $this->SettlementCertificateModel->getLocationName($north['dist_code'], $north['subdiv_code'], $north['cir_code'], $north['mouza_pargona_code']);
                    $north_boundary_lot         = $this->SettlementCertificateModel->getLocationName($north['dist_code'], $north['subdiv_code'], $north['cir_code'], $north['mouza_pargona_code'], $north['lot_no']);
                    $north_boundary_village     = $this->SettlementCertificateModel->getLocationName($north['dist_code'], $north['subdiv_code'], $north['cir_code'], $north['mouza_pargona_code'], $north['lot_no'], $north['vill_townprt_code']);
                    $north_text                 = $north_boundary_district . ", " . $north_boundary_subdivision . ", " . $north_boundary_circle . ", " . $north_boundary_mouza . ", " . $north_boundary_lot . ", " . $north_boundary_village . ', Dag No: ' . $north['dag_no'];

                    $south_boundary_district    = $this->SettlementCertificateModel->getLocationName($south['dist_code']);
                    $south_boundary_subdivision = $this->SettlementCertificateModel->getLocationName($south['dist_code'], $south['subdiv_code']);
                    $south_boundary_circle      = $this->SettlementCertificateModel->getLocationName($south['dist_code'], $south['subdiv_code'], $south['cir_code']);
                    $south_boundary_mouza       = $this->SettlementCertificateModel->getLocationName($south['dist_code'], $south['subdiv_code'], $south['cir_code'], $south['mouza_pargona_code']);
                    $south_boundary_lot         = $this->SettlementCertificateModel->getLocationName($south['dist_code'], $south['subdiv_code'], $south['cir_code'], $south['mouza_pargona_code'], $south['lot_no']);
                    $south_boundary_village     = $this->SettlementCertificateModel->getLocationName($south['dist_code'], $south['subdiv_code'], $south['cir_code'], $south['mouza_pargona_code'], $south['lot_no'], $south['vill_townprt_code']);
                    $south_text                 = $south_boundary_district . ", " . $south_boundary_subdivision . ", " . $south_boundary_circle . ", " . $south_boundary_mouza . ", " . $south_boundary_lot . ", " . $south_boundary_village . ', Dag No: ' . $south['dag_no'];

                    $east_boundary_district    = $this->SettlementCertificateModel->getLocationName($east['dist_code']);
                    $east_boundary_subdivision = $this->SettlementCertificateModel->getLocationName($east['dist_code'], $east['subdiv_code']);
                    $east_boundary_circle      = $this->SettlementCertificateModel->getLocationName($east['dist_code'], $east['subdiv_code'], $east['cir_code']);
                    $east_boundary_mouza       = $this->SettlementCertificateModel->getLocationName($east['dist_code'], $east['subdiv_code'], $east['cir_code'], $east['mouza_pargona_code']);
                    $east_boundary_lot         = $this->SettlementCertificateModel->getLocationName($east['dist_code'], $east['subdiv_code'], $east['cir_code'], $east['mouza_pargona_code'], $east['lot_no']);
                    $east_boundary_village     = $this->SettlementCertificateModel->getLocationName($east['dist_code'], $east['subdiv_code'], $east['cir_code'], $east['mouza_pargona_code'], $east['lot_no'], $east['vill_townprt_code']);
                    $east_text                 = $east_boundary_district . ", " . $east_boundary_subdivision . ", " . $east_boundary_circle . ", " . $east_boundary_mouza . ", " . $east_boundary_lot . ", " . $east_boundary_village . ', Dag No: ' . $east['dag_no'];

                    $west_boundary_district    = $this->SettlementCertificateModel->getLocationName($west['dist_code']);
                    $west_boundary_subdivision = $this->SettlementCertificateModel->getLocationName($west['dist_code'], $west['subdiv_code']);
                    $west_boundary_circle      = $this->SettlementCertificateModel->getLocationName($west['dist_code'], $west['subdiv_code'], $west['cir_code']);
                    $west_boundary_mouza       = $this->SettlementCertificateModel->getLocationName($west['dist_code'], $west['subdiv_code'], $west['cir_code'], $west['mouza_pargona_code']);
                    $west_boundary_lot         = $this->SettlementCertificateModel->getLocationName($west['dist_code'], $west['subdiv_code'], $west['cir_code'], $west['mouza_pargona_code'], $west['lot_no']);
                    $west_boundary_village     = $this->SettlementCertificateModel->getLocationName($west['dist_code'], $west['subdiv_code'], $west['cir_code'], $west['mouza_pargona_code'], $west['lot_no'], $west['vill_townprt_code']);
                    $west_text                 = $west_boundary_district . ", " . $west_boundary_subdivision . ", " . $west_boundary_circle . ", " . $west_boundary_mouza . ", " . $west_boundary_lot . ", " . $west_boundary_village . ', Dag No: ' . $west['dag_no'];

                    $data['boundary_details']['east'] = $east_text;
                    $data['boundary_details']['west'] = $west_text;

                    $data['boundary_details']['north'] = $north_text;
                    $data['boundary_details']['south'] = $south_text;

                    $ulpin1 = $east['dag_no'];
                    $ulpin2 = $west['dag_no'];
                    $ulpin3 = $north['dag_no'];
                    $ulpin4 = $south['dag_no'];

                    $plotNos    = array_filter([$ulpin1, $ulpin2, $ulpin3, $ulpin4]);
                    $plotNosStr = implode(",", $plotNos); // convert array -> "21,2,23,78,56"

                    $location = $west['dist_code'] . $west['subdiv_code'] . $west['cir_code'] . $west['mouza_pargona_code'] . $west['lot_no'] . $west['vill_townprt_code'];
                    // Call API once with all dag numbers
                    $curl    = curl_init();
                    $payload = json_encode([
                        "location" => $location, // you can make dynamic if needed
                        "plotNos"  => $plotNosStr,
                    ]);

                    curl_setopt_array($curl, [
                        CURLOPT_URL            => 'https://landhub.assam.gov.in/apidemo/index.php/NicApi/ULPINs',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING       => '',
                        CURLOPT_MAXREDIRS      => 10,
                        CURLOPT_TIMEOUT        => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST  => 'POST', // should be POST (not GET) because you are sending JSON body
                        CURLOPT_POSTFIELDS     => $payload,
                        CURLOPT_HTTPHEADER     => [
                            'Content-Type: application/json',
                        ],
                    ]);

                    $response = curl_exec($curl);
                    curl_close($curl);

                    // Decode API response
                    $ulpinData = json_decode($response, true);

                    // Original plot numbers you sent
                    $plotNos = [$ulpin1, $ulpin2, $ulpin3, $ulpin4];

                    // Build a lookup array from API response
                    $ulpinMap = [];
                    if (isset($ulpinData['data']) && is_array($ulpinData['data'])) {
                        foreach ($ulpinData['data'] as $item) {
                            if (isset($item['plotNo'], $item['ULPIN'])) {
                                $ulpinMap[$item['plotNo']] = $item['ULPIN'];
                            }
                        }
                    }

                    // Assign back in "ULPIN/DAG" format
                    foreach ($plotNos as $index => $p) {
                        $ulpinVar = "ulpin" . ($index + 1); // makes ulpin1, ulpin2, etc.
                        if (isset($ulpinMap[$p])) {
                            $$ulpinVar = $ulpinMap[$p] . "/" . $p;
                        } else {
                            $$ulpinVar = "N/A/" . $p; // fallback if not found
                        }
                    }

                } else if (isset($value->landmark)) {
                    $landmark                          = $value->landmark;
                    $north                             = isset($landmark['north']) ? $landmark['north'] : null;
                    $south                             = isset($landmark['south']) ? $landmark['south'] : null;
                    $east                              = isset($landmark['east']) ? $landmark['east'] : null;
                    $west                              = isset($landmark['west']) ? $landmark['west'] : null;
                    $data['boundary_details']['north'] = isset($landmark['north']) ? $landmark['north'] : null;
                    $data['boundary_details']['south'] = isset($landmark['south']) ? $landmark['south'] : null;
                    $data['boundary_details']['east']  = isset($landmark['east']) ? $landmark['east'] : null;
                    $data['boundary_details']['west']  = isset($landmark['west']) ? $landmark['west'] : null;
                    $ulpin1                            = null;
                    $ulpin2                            = null;
                    $ulpin3                            = null;
                    $ulpin4                            = null;
                } else {
                    $data['boundary_details']['north'] = "Unidentified";
                    $data['boundary_details']['south'] = "Unidentified";
                    $data['boundary_details']['east']  = "Unidentified";
                    $data['boundary_details']['west']  = "Unidentified";

                    $ulpin1 = null;
                    $ulpin2 = null;
                    $ulpin3 = null;
                    $ulpin4 = null;
                }
                $landclass = $this->utilityclass->getLandClassCode($value->new_land_class_code);
                $dag_nos   = $this->SettlementCertificateModel->getChithaDagNosByOldDag($dhar_case_no, $value->dag_no);

                $dag_no_old = $value->dag_no ?? null;
                $dag_no_new = $dag_nos->dag_no ?? null;

                $dagArray[] = [
                    'bigha'                => $applied_b,
                    'katha'                => $applied_k,
                    'lessa'                => $applied_lc,
                    'ganga'                => $applied_g,
                    'total_hectare'        => $totalHectar,
                    'total_square_meter'   => $sqrMeter,
                    'land_class_code'      => $value->new_land_class_code,
                    'boundary_description' => $data['boundary_details'],
                    'dag_no_old'           => $dag_no_old,
                    'dag_no_new'           => $dag_no_new,
                    'land_class'           => $landclass,
                ];


                $pattaDetails = $this->SettlementCertificateModel->getPattaDetails($dist_code, $sub, $cir, $mou, $lot, $vill, $dag_no_old, $dag_no_new);


                if ($pattaDetails && ! isset($dagArray[0]['patta_details'])) {
                    $dagArray[0]['patta_details'] = [
                        'dag_revenue'     => $pattaDetails->dag_revenue,
                        'dag_local_tax'   => $pattaDetails->dag_local_tax,
                        'patta_type_code' => $pattaDetails->patta_type_code,
                        'patta_no'        => $pattaDetails->patta_no,
                        'old_patta_no'    => $pattaDetails->old_patta_no,
                        'patta_type_name' => $this->utilityclass->getPattaName($patta->patta_type_code),
                    ];
                }



            }

            $get_meeting_no = $this->SettlementCertificateModel->getMeetingNo($dhar_case_no);

            // generate certificate number

            if($type == "generate"){
                $certificate_no = $this->SettlementCertificateModel->generateCertificateNumber();
            }else{
                $certificate_no = "THIS IS A DRAFT CERTIFICATE";
            }
            // print_r($certificate_no);die;

            $getDataFromApLmNote = $this->SettlementCertificateModel->getDataFromApLmNotes($dhar_case_no);
            $isSettlement        = $this->SettlementCertificateModel->isSettlementorAllotment($institute_details->ins_cat_type_co, $getDataFromApLmNote); // or use: $this->SettlementCertificateModel->isSettlement($case_no);
            
            if($institute_details->ins_cat_type_co == 12){
                $purpose =  null;
                $allDataFromPurpose = $this->SettlementCertificateModel->getPruposeBycaseNo($dhar_case_no);

                $purpose_land_allot_co = $allDataFromPurpose->purpose_land_allot_co;
                
                $venture_type          = $allDataFromPurpose->venture_type ?? null;
                $under_venture_school  = $allDataFromPurpose->under_venture_school  ?? null;


                if($purpose_land_allot_co == "education"  && ($under_venture_school == 'NO' || $under_venture_school == NULL)){
                    $purpose = "eductaion-non-venture";
                }

                if($purpose_land_allot_co == "education"  && $under_venture_school == 'YES' && $venture_type =='unrecognised_venture'){
                    $purpose = "eductaion-unrecognized-venture";
                }


                if($purpose_land_allot_co == "education"  && $under_venture_school == 'YES' && $venture_type =='govt_aided_venture'){
                    $purpose = "eductaion-govt-aidded";
                }

                if($purpose_land_allot_co == "religious" || $purpose_land_allot_co =="socioculture"){
                    $purpose = 'religious-socio-culture';
                }
            }

            // if($institute_details->ins_cat_type_co == 12 && $purpose == null){
            //     echo "Purpose Not Found";die;
            // }

            // print_r($purpose);die;




            $certificate_data = [

                'certificate_no'             => strtoupper($certificate_no),
                'dhar_case_no'               => strtoupper($dhar_case_no),
                'application_no'             => strtoupper($application_no),
                'land_advisiory_proposal_no' => strtoupper($get_meeting_no->meeting_name),
                'lapn_date'                  => strtoupper($get_meeting_no->digital_sign_date),
                'certificate_date'           => date('Y-m-d'),
                'institute_name'             => strtoupper($institute_details->ins_name_co),
                'ins_category'               => $institute_details->category_name,
                'dist_code'                  => $location_details_settlement->dist_code,
                'subdiv_code'                => $location_details_settlement->subdiv_code,
                'cir_code'                   => $location_details_settlement->cir_code,
                'mouza_pargona_code'         => $location_details_settlement->mouza_pargona_code,
                'lot_no'                     => $location_details_settlement->lot_no,
                'vill_townprt_code'          => $location_details_settlement->vill_townprt_code,
                'district_name'              => strtoupper($location_details_raw['district_name']),
                'subdivision_name'           => strtoupper($location_details_raw['subdiv_name']),
                'circle_name'                => strtoupper($location_details_raw['cir_name']),
                'mouza_pargona_name'         => strtoupper($location_details_raw['mouza_name']),
                'lot_name'                   => strtoupper($location_details_raw['lot_name']),
                'village_name'               => strtoupper($location_details_raw['village_name']),
                'village_uuid'               => $getVillageUUID,

                'ins_cat_type_co'            => $institute_details->ins_cat_type_co,
                'issettlement'               => $isSettlement,

                'dag_details'                => json_encode($dagArray),

                'ulpin_dag_no_1'             => $ulpin1,
                'ulpin_dag_no_2'             => $ulpin2,
                'ulpin_dag_no_3'             => $ulpin3,
                'ulpin_dag_no_4'             => $ulpin4,
                'ulpin_geo_cordinates'       => strtoupper(null),
                'land_schedule_sketch_link'  => 'https://sewasetu.assam.gov.in/',
                'service_code'               => strtoupper(45),
                'status'                     => strtoupper(1),
                'other_details'              => strtoupper($otherDetails),
                'purpose_land_allot_co'      => $purpose ?? null
            ];

            // insert the data into the database


            // Split by slash
            $parts = explode("/", $application_no);

            // Get the last part (1046)
            $lastPart = array_pop($parts);

            // Generate 4 random digits
            $randomDigits = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

            // Replace last part with modified one
            $parts[] = $randomDigits . $lastPart;

            // Join back together
            $modified_application_no = implode("/", $parts);


            $appNo = base64_encode($modified_application_no);
            $query = $this->db->query("select * from supportive_document_mobile where applid=?", [$application_no]);
            if ($query->num_rows() == 0) {
                echo "Supportive Document Not Found " . $application_no;
                die;
            } else {
                $result = $query->row();
                $lat    = $result->lat;
                $lng    = $result->long;
            }


           if ($type == "generate") {
                $data['certificate_data'] = (object) $certificate_data;
                $data['base_64_qr_geo_cordinates'] = printQR("https://basundhara.assam.gov.in/rtpsmb/QRData/viewgeocordinates?dc=" . $dist_code . "&app_no=" . $appNo);
                $data['base_64_qr_sketch']         = printQR("https://basundhara.assam.gov.in/rtpsmb/QRData/viewgeocordinatesSketch?dc=" . $dist_code . "&app_no=" . $appNo);
                $data['base_64_qr_google']         = printQR("https://www.google.com/maps/place/" . $lat . "," . $lng);
                $data['dag_sketch_qr_photos']      = printQR("https://basundhara.assam.gov.in/rtpsmb/QRData/getSketchOfTheDagForDigitalPatta?dc=$dist_code&app_no=$appNo");
                $data['base_64_qr']                = printQR("https://basundhara.assam.gov.in/rtpsmb/QRData/viewCertificate?dc=" . $dist_code . "&app_no=" . $appNo);    
                // print_r($certificate_data);die;


                $checkType = $certificate_data['ins_cat_type_co'];
                $purpose_land_allot_co = $certificate_data['purpose_land_allot_co'];



                if ($checkType == 9) {
                    $html = $this->load->view('settlement_certificate/actual_certificate/state_govt_undertaking', $data, true);
                }else if ($checkType == 11) {
                    $html = $this->load->view('settlement_certificate/actual_certificate/central_govt_undertaking', $data, true);
                } else if ($checkType == 12) {
                    $html = $this->load->view('settlement_certificate/actual_certificate/non_govt', $data, true);
                }

                
            // Render certificate directly
            header('Content-Type: text/html; charset=utf-8');
            echo $html;
            exit;


                // rename dhar case name replace '/' with '_'
                $dhar_case_name = str_replace("/", "_", $dhar_case_no);
                $file_name = "settlement_certificate_state_govt_" . $dhar_case_name . ".txt"; // save as text file
                $file_path = UPLOAD_BASE . "allotment_certificate/actual_certificate/" . $file_name;

                // var_dump($file_path);
                // convert HTML to base64
                $base64encoded = base64_encode($html);


                $certificate_data['base_64_file'] = $file_path;


                // save base64 string into a file
                file_put_contents($file_path, $base64encoded);

                $data['base_64_file'] = base_url() . "uploads/settlement_certificate/actual_certificate/" . $file_name;
            }


            if ($type == "generate") {
                $data['certificate_data'] = (object) $certificate_no;

                

                // use $data['certificate_data'] everywhere
                $checkType = $data['certificate_data']->ins_cat_type_co;

                 if ($checkType == 9) {
                    $html = $this->load->view('settlement_certificate/actual_certificate/state_govt_undertaking', $data, true);
                }else if ($checkType == 11) {
                    $html = $this->load->view('settlement_certificate/actual_certificate/central_govt_undertaking', $data, true);
                } else if ($checkType == 12) {
                    $html = $this->load->view('settlement_certificate/actual_certificate/non_govt', $data, true);
                }

                header('Content-Type: text/html; charset=utf-8');
                echo $html;
                exit;
            }


            $insert_data = $this->SettlementCertificateModel->insertOrUpdateCertificateData($certificate_data);
            // print($insert_data);
            return $insert_data;
        // }
    }

  public function print_certificates_without_sign()
{
    $_POST = json_decode(file_get_contents("php://input"), true);
    $dhar_case_no_list = $_POST['selectedList'];
    $entire_page = '';

    $first_ins_cat_type = null; // store the category of the first case

    if(count($dhar_case_no_list) == 0){
        echo json_encode([
            'flag' => 'N',
            'msg'  => 'Please select at least one case'
        ]);
        return;
    }if(count($dhar_case_no_list) > 10){
        echo json_encode([
            'flag' => 'N',
            'msg'  => 'Please select less than 10 cases'
        ]);
        return;
    }


    foreach ($dhar_case_no_list as $dhar_case_no) {
        $certificate_data = $this->SettlementCertificateModel->getCertificateData($dhar_case_no);
        $this->SettlementCertificateModel->updatePrintStatus($dhar_case_no);

        if (!$certificate_data) {
            echo json_encode([
                'flag' => 'N',
                'msg'  => 'Certificate data not found for case no: ' . $dhar_case_no
            ]);
            return;
        }

        $ins_cat_type_co = $certificate_data->ins_cat_type_co;

        // Check category consistency
        if ($first_ins_cat_type === null) {
            $first_ins_cat_type = $ins_cat_type_co;
        } elseif ($first_ins_cat_type !== $ins_cat_type_co) {
            echo json_encode([
                'flag' => 'N',
                'msg'  => 'Only similar Category can be selected for bulk printing'
            ]);
            return;
        }

        $certificate = $certificate_data->base_64_file;
        $all_html = '';

        if (file_exists($certificate)) {
            $base64Content = file_get_contents($certificate);
            $decrypted_certificate = base64_decode($base64Content);
            $all_html .= '<div class="page-break">' . $decrypted_certificate . '</div>';
        } else {
            $decrypted_certificate = '';
        }

        $entire_page .= $all_html;
    }

    // Return HTML as JSON
    echo json_encode([
        'flag' => 'Y',
        'html' => $entire_page
    ]);
}

public function print_certificates_as_pdf()
{
    $post_data = json_decode($this->input->post('data'), true);
    $dhar_case_no_list = $post_data['selectedList'] ?? [];
    if (empty($dhar_case_no_list)) {
        show_error("No certificates selected.");
        return;
    }

    // Load mPDF (nested install path)
    include APPPATH . '../vendor/mpdf/vendor/autoload.php';
    $mpdf = new \Mpdf\Mpdf();

    $all_html = '';

    foreach ($dhar_case_no_list as $index => $dhar_case_no) {

        $certificate_data = $this->SettlementCertificateModel->getCertificateData($dhar_case_no);
        $certificate_file = $certificate_data->base_64_file ?? '';

        if ($certificate_file && file_exists($certificate_file)) {
            $base64Content = file_get_contents($certificate_file);
            $decrypted_certificate = trim(base64_decode($base64Content));
            if (empty($decrypted_certificate)) {
                $decrypted_certificate = '<p>Certificate content is empty for ' . htmlspecialchars($dhar_case_no) . '</p>';
            }
        } else {
            $decrypted_certificate = '<p>Certificate not found for ' . htmlspecialchars($dhar_case_no) . '</p>';
        }

        // Wrap each certificate in a div with page break
        $all_html .= '<div style="page-break-after: always;">' . $decrypted_certificate . '</div>';
    }

    // Suppress notices temporarily for mPDF
    error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
    $mpdf->WriteHTML($all_html);
    error_reporting(E_ALL);

    // Output PDF directly to browser
    $mpdf->Output('Certificates.pdf', 'I');
    exit;
}







}

