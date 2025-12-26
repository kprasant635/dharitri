<?php
class DigitalPattaCommonNcModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('digitalPatta/digitalPattaPattadarModel');
        $this->load->model('digitalPatta/digitalPattaDagDetailsModel');
        $this->load->model('digitalPatta/digitalPattaLocationModel');
        $this->load->model('digitalPatta/digitalPattaDetailsModel');
        $this->load->model('digitalPatta/digitalPattaPhotoModel');
        $this->load->model('digitalPatta/digitalPattaServiceDetailsModel');
        $this->load->model('digitalPatta/digitalPattaTACModel');
        $this->dbswitch();
        $this->load->model('DataBaseSwitchModel');
    }

    //db_switch method
    public function dbswitch()
    {
        //$CI=&get_instance();
        if ($this->session->userdata('dist_code') == "02") {
            $this->db = $this->load->database('dha3', TRUE);
        } else if ($this->session->userdata('dist_code') == "05") {
            $this->db = $this->load->database('dha1', TRUE);
        } else if ($this->session->userdata('dist_code') == "10") {
            $this->db = $this->load->database('dha24', TRUE);
        } else if ($this->session->userdata('dist_code') == "13") {
            $this->db = $this->load->database('dha2', TRUE);
        } else if ($this->session->userdata('dist_code') == "17") {
            $this->db = $this->load->database('dha4', TRUE);
        } else if ($this->session->userdata('dist_code') == "15") {
            $this->db = $this->load->database('dha5', TRUE);
        } else if ($this->session->userdata('dist_code') == "14") {
            $this->db = $this->load->database('dha6', TRUE);
        } else if ($this->session->userdata('dist_code') == "07") {
            $this->db = $this->load->database('dha7', TRUE);
        } else if ($this->session->userdata('dist_code') == "03") {
            $this->db = $this->load->database('dha8', TRUE);
        } else if ($this->session->userdata('dist_code') == "18") {
            $this->db = $this->load->database('dha9', TRUE);
        } else if ($this->session->userdata('dist_code') == "12") {
            $this->db = $this->load->database('dha13', TRUE);
        } else if ($this->session->userdata('dist_code') == "24") {
            $this->db = $this->load->database('dha10', TRUE);
        } else if ($this->session->userdata('dist_code') == "06") {
            $this->db = $this->load->database('dha11', TRUE);
        } else if ($this->session->userdata('dist_code') == "11") {
            $this->db = $this->load->database('dha12', TRUE);
        } else if ($this->session->userdata('dist_code') == "16") {
            $this->db = $this->load->database('dha14', TRUE);
        } else if ($this->session->userdata('dist_code') == "32") {
            $this->db = $this->load->database('dha15', TRUE);
        } else if ($this->session->userdata('dist_code') == "33") {
            $this->db = $this->load->database('dha16', TRUE);
        } else if ($this->session->userdata('dist_code') == "34") {
            $this->db = $this->load->database('dha17', TRUE);
        } else if ($this->session->userdata('dist_code') == "21") {
            $this->db = $this->load->database('dha18', TRUE);
        } else if ($this->session->userdata('dist_code') == "08") {
            $this->db = $this->load->database('dha19', TRUE);
        } else if ($this->session->userdata('dist_code') == "35") {
            $this->db = $this->load->database('dha20', TRUE);
        } else if ($this->session->userdata('dist_code') == "36") {
            $this->db = $this->load->database('dha21', TRUE);
        } else if ($this->session->userdata('dist_code') == "37") {
            $this->db = $this->load->database('dha22', TRUE);
        } else if ($this->session->userdata('dist_code') == "25") {
            $this->db = $this->load->database('dha23', TRUE);
        } else if ($this->session->userdata('dist_code') == "39") {
            $this->db = $this->load->database('dha39', TRUE);
        } else if ($this->session->userdata('dist_code') == "38") {
            $this->db = $this->load->database('dha25', TRUE);
        }
    }


    // code by Masud Reza 31/07/2025

    // count application id by case no for DC
    public function caseForDcApprovalNc($caseNo,$dist_code)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where('dist_code', $dist_code)
            ->where_in('service_code', NC_DIGITAL_PATTA_SERVICE_CODE_ALLOW)
            ->where('chitha_processing_details', 2)
            ->where('order_passed', 'Y')
            ->where('co_chitha_corrected_yn', 'Y')
            ->get('settlement_basic')
            ->num_rows();
    }


    // count application id by case no for DC
    public function caseForDcApprovalNcPrint($caseNo,$dist_code)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where('dist_code', $dist_code)
            ->where_in('service_code', NC_DIGITAL_PATTA_SERVICE_CODE_ALLOW)
            ->where('chitha_processing_details', 2)
            ->where('order_passed', 'Y')
            ->where('co_chitha_corrected_yn', 'Y')
            ->where('digital_patta_offered','1')
            ->get('settlement_basic')
            ->num_rows();
    }


    //method to get the certificate
    public function getDscSignCertificate($dist_code)
    {
        $query = $this->db->query("select cert from dsc_registration_details where dist_code=? and status =? and subdiv_code ='00'", array($dist_code,'ACTIVE'));
        if($query->num_rows() == 0)
        {
            return null;
        }
        else
        {
            return $query->row()->cert;
        }
    }


    //method to get all the cases in datatable
    public function getAllCasesDigitalPatta($start, $length, $order)
    {
        $searchByCol_0 = strtoupper($this->input->post('columns')[1]['search']['value']);
        if(!empty($searchByCol_0))
        {
            $this->db->where('sb.case_no like \'%'.$searchByCol_0.'%\'');
        }
        $col = 0;
        $dir = "";
        if (!empty($order))
        {
            foreach ($order as $o)
            {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc')
        {
            $dir = 'desc';
        }
        if ($order != null)
        {
            $this->db->order_by($order, $dir);
        }

        $dist_code = $this->session->userdata('dist_code');

        $this->db->select('*');
        $this->db->from('settlement_basic sb');
        $this->db->where('sb.chitha_processing_details', 2);
        $this->db->where('sb.dist_code', $dist_code);
        $this->db->where_in('sb.service_code', NC_DIGITAL_PATTA_SERVICE_CODE_ALLOW);
        $this->db->where('sb.order_passed', 'Y');
        $this->db->where('sb.co_chitha_corrected_yn', 'Y');
        $this->db->where('sb.digital_patta_offered IS NULL', NULL, FALSE);
        $this->db->join('settlement_emi_history seh', 'seh.case_no = sb.case_no');
        $this->db->where('seh.is_full_paid', 1);
        $this->db->where('EXISTS (
            SELECT DISTINCT(case_no) 
            FROM settlement_premium 
            WHERE case_no = sb.case_no 
              AND is_final = 1 
              AND grn_no IS NOT NULL
        )', NULL, FALSE);
        $this->db->where_not_in('sb.applid', DIGITAL_PATTA_TO_EXCLUDE_NC);
        $this->db->where("NOT EXISTS (
            SELECT 1 
            FROM bhunaksha_svamitva_cases bns
            WHERE bns.case_no = sb.case_no
              AND bns.status <> 2
        )", NULL, FALSE);
        $this->db->where("NOT EXISTS (
            SELECT 1 
            FROM bhunaksha_svamitva_cases bns
            WHERE bns.case_no = sb.case_no
              AND bns.property_status NOT IN (1,2)
        )", NULL, FALSE);

        $this->db->limit($length, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            if(DIGITAL_PATTA_OPEN_NC == 1 )
            {
                $data['data_results'] = $query->result();
            }
            else
            {
                $data['data_results'] = null;
            }

            $this->db->select('*');
            $this->db->from('settlement_basic sb');
            $this->db->where('sb.chitha_processing_details', 2);
            $this->db->where('sb.dist_code', $dist_code);
            $this->db->where_in('sb.service_code', NC_DIGITAL_PATTA_SERVICE_CODE_ALLOW);
            $this->db->where('sb.order_passed', 'Y');
            $this->db->where('sb.co_chitha_corrected_yn', 'Y');
            $this->db->where('sb.digital_patta_offered IS NULL', NULL, FALSE);
            $this->db->join('settlement_emi_history seh', 'seh.case_no = sb.case_no');
            $this->db->where('seh.is_full_paid', 1);
            $this->db->where('EXISTS (
                SELECT DISTINCT(case_no) 
                FROM settlement_premium 
                WHERE case_no = sb.case_no 
                  AND is_final = 1
                  AND grn_no IS NOT NULL
            )', NULL, FALSE);
            $this->db->where_not_in('sb.applid', DIGITAL_PATTA_TO_EXCLUDE_NC);
            $this->db->where("NOT EXISTS (
                SELECT 1 
                FROM bhunaksha_svamitva_cases bns
                WHERE bns.case_no = sb.case_no
                  AND bns.status <> 2
            )", NULL, FALSE);
            $this->db->where("NOT EXISTS (
                SELECT 1 
                FROM bhunaksha_svamitva_cases bns
                WHERE bns.case_no = sb.case_no
                  AND bns.property_status NOT IN (1,2)
            )", NULL, FALSE);
            if(DIGITAL_PATTA_OPEN_NC == 1 )
            {
                $data['total_records'] = $this->db->count_all_results();
            }
            else
            {
                $data['total_records'] = 0;
            }
            return $data;
        }
    }


    //getting application no from dhar case no
    public function getApplidFromCaseNo($case_no) {

        $CI = & get_instance();
        $d=$CI->session->userdata['dist_code'];
        $this->dbswitch($d);
        $applid = $this->db->query("select applid from settlement_basic where case_no ='$case_no'");
        return $applid->row()->applid;
    }


    //getting rtps refernce no
    public function getRtpsRefNo($application_no)
    {
        $ref_no_query = $this->db->select('ref_no')
            ->where('applid', $application_no)
            ->from('settlement_basic')
            ->get();
        if ($ref_no_query->num_rows() > 0)
        {
            $rtps_no = $ref_no_query->row()->ref_no;
        }
        else
        {
            $rtps_no ="NO DATA FOUND";
        }

        return $rtps_no;
    }


    //getting digital patta details
    public function getPattaInfo($applno)
    {
        $error_msgs = array();
        //getting settlement basic details
        $settlementBasic = $this->digitalPattaDetailsModel->getSettlementBasicDetails($applno);
        if($settlementBasic !="No Data Found")
        {
            $settlement_basic_details = $settlementBasic;
        }
        else
        {
            $settlement_basic_details = null;
            log_message('error', '#DIGITALPATTA00001,settlement basic details not found for applid '. $applno);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTA00001, SOME ERROR OCCURRED, for Case NO .'.$applno.'. PLEASE CONTACT ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $applno
            ];
        }

        $case_no    = trim($settlementBasic->case_no);
        $sb_status  = trim($settlementBasic->status);
        $sb_service = trim($settlementBasic->service_code);
        //checking whether status is N or not
        if(trim($sb_status) != 'N'){
            log_message('error', '#DIGITALPATTA001,settlement basic status is not found to be N for applid '. $applno);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTA001, SOME ERROR OCCURRED, for Case NO .'.$case_no.'. PLEASE CONTACT ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        //checking service code
        if(trim($settlementBasic->service_code) == '' || $settlementBasic->service_code == null){
            log_message('error', '#DIGITALPATTA002, service code not found in settlement basic for case_no '. $case_no);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTA002, SOME ERROR OCCURRED, for Case NO .'.$case_no.'. PLEASE CONTACT ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        //checking whether service_code
        if(!in_array($sb_service, NC_DIGITAL_PATTA_SERVICE_CODE_ALLOW))
        {
            log_message('error', '#DIGITALPATTA00141,settlement basic service_code is not found for applid '. $applno);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTA00141, SOME ERROR OCCURRED, for Case NO .'.$case_no.'. PLEASE CONTACT ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        //checking dist_code
        if(trim($settlementBasic->dist_code) == '' || $settlementBasic->dist_code == null){
            log_message('error', '#DIGITALPATTA003, dist_code not found in settlement basic for applid '. $applno);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTA003, SOME ERROR OCCURRED, for Case NO .'.$case_no.'. PLEASE CONTACT ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        //checking subdiv_code
        if(trim($settlementBasic->subdiv_code) == '' || $settlementBasic->subdiv_code == null){
            log_message('error', '#DIGITALPATTA004, subdiv_code not found in settlement basic for applid '. $applno);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTA004, SOME ERROR OCCURRED, for Case NO .'.$case_no.'. PLEASE CONTACT ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        //checking cir_code
        if(trim($settlementBasic->cir_code) == '' || $settlementBasic->cir_code == null){
            log_message('error', '#DIGITALPATTA005, cir_code not found in settlement basic for applid '. $applno);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTA005, SOME ERROR OCCURRED, for Case NO .'.$case_no.'. PLEASE CONTACT ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        //checking mouza_pargona_code
        if(trim($settlementBasic->mouza_pargona_code) == '' || $settlementBasic->mouza_pargona_code == null){
            log_message('error', '#DIGITALPATTA006, mouza_pargona_code not found in settlement basic for applid '. $applno);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTA006 , SOME ERROR OCCURRED, for Case NO .'.$case_no.'. PLEASE CONTACT ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        //checking lot_no
        if(trim($settlementBasic->lot_no) == '' || $settlementBasic->lot_no == null){
            log_message('error', '#DIGITALPATTA007, lot_no not found in settlement basic for applid '. $applno);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTA007, SOME ERROR OCCURRED, for Case NO .'.$case_no.'. PLEASE CONTACT ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        //checking vill_townprt_code
        if(trim($settlementBasic->vill_townprt_code) == '' || $settlementBasic->vill_townprt_code == null){
            log_message('error', '#DIGITALPATTA008, vill_townprt_code not found in settlement basic for applid '. $applno);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTA008, SOME ERROR OCCURRED, for Case NO .'.$case_no.'. PLEASE CONTACT ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        //geteting settlement applicant data
        $applicant_data_query = $this->digitalPattaPattadarModel->getSettlememtApplicant_data($case_no);

        if($applicant_data_query !="NOT-FOUND")
        {
            $settlement_applicant_data = $applicant_data_query;
        }
        else
        {
            //if applicant data is not found throw error and return
            $settlement_applicant_data = null;
            log_message('error', '#DIGITALPATTA1009, Applicant details not found for the case no  '. $case_no);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTA1009, Applicant details not found ,for Case NO .'.$case_no,
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        //getting digital patta applicant details from chitha_settlement_allottee where is applicant is 1
        $applicant_query = $this->digitalPattaPattadarModel->getApplicantDetails($case_no);
        if($applicant_query !="NOT-FOUND")
        {
            $applicant_data = $applicant_query;
        }
        else
        {
            //if applicant data is not found throw error and return
            $applicant_data = null;
            log_message('error', '#DIGITALPATTA009, Applicant details not found for the case no  '. $case_no);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTA009, Applicant details not found ,for Case NO .'.$case_no,
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        //checking settlement_name
        if(trim($applicant_query->settlement_name) == "" || $applicant_query->settlement_name == null){
            log_message('error', '#DIGITALPATTA0010, settlement_name not found for applicant in chitha settlement allottee for case_no '. $case_no);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTA0010, SOME ERROR OCCURRED, for Case NO .'.$case_no.'.  PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        //checking settlement_guardian
        if(trim($applicant_query->settlement_guardian) == "" || $applicant_query->settlement_guardian == null){
            log_message('error', '#DIGITALPATTA0011, settlement_guardian not found for applicant in settlement_allotee for case_no '. $case_no);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTA0011, for Case NO .'.$case_no.'. SOME ERROR OCCURRED, PLEASE CONTACT ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        //checking grn_no
        if(trim($applicant_query->grn_no) == "" || $applicant_query->grn_no == null){
            log_message('error', '#DIGITALPATTA0012, grn_no not found for applicant in settlement_allottee for case_no '. $case_no);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTA0012, SOME ERROR OCCURRED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        //checking identity type
        if(trim($applicant_query->identity_type) == "" || $applicant_query->identity_type == null){
            log_message('error', '#DIGITALPATTA0013, identity_type not found for applicant in settlement_allottee for case_no '. $case_no);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTA0013, SOME ERROR OCCURRED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        //getting settlement_applicant details from chitha pattadar
        $chitha_pattadar_applicant_query = $this->digitalPattaPattadarModel->getAllDetailsOfApplicant($case_no);
        if($chitha_pattadar_applicant_query !="NOT-FOUND")
        {
            $chitha_pattadar_applicant_data = $chitha_pattadar_applicant_query;
        }
        else
        {
            $chitha_pattadar_applicant_data = null;
            log_message('error', '#DIGITALPATTA0014, Pattadar details not found for the case no  '. $case_no);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTA0014, Pattadar details not found ,for Case NO .'.$case_no,
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        // fetching out the location of the new patta
        $dist_code          = $chitha_pattadar_applicant_query->dist_code;
        $subdiv_code        = $chitha_pattadar_applicant_query->subdiv_code;
        $cir_code           = $chitha_pattadar_applicant_query->cir_code;
        $mouza_pargona_code = $chitha_pattadar_applicant_query->mouza_pargona_code;
        $lot_no             = $chitha_pattadar_applicant_query->lot_no;
        $vill_townprt_code  = $chitha_pattadar_applicant_query->vill_townprt_code;
        $patta_type_code    = $chitha_pattadar_applicant_query->patta_type_code;
        $patta_no           = $chitha_pattadar_applicant_query->patta_no;


        //checking case_no
        if(trim($chitha_pattadar_applicant_query->o1_case_no) == "" || $chitha_pattadar_applicant_query->o1_case_no == null){
            log_message('error', '#DIGITALPATTA0015, o1_case_no_caste not found for applicant in chitha_pattadar for case_no '. $case_no);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTA0015, SOME ERROR OCCURRED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }



        //checking pdar_caste
        if(trim($chitha_pattadar_applicant_query->pdar_caste) == "" || $chitha_pattadar_applicant_query->pdar_caste == null){
            log_message('error', '#DIGITALPATTA0017, pdar_caste not found for applicant in chitha_pattadar for case_no '. $case_no);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTA0017, SOME ERROR OCCURRED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        //checking pdar_add1
        if(trim($chitha_pattadar_applicant_query->pdar_add1) == "" || $chitha_pattadar_applicant_query->pdar_add1 == null){
            log_message('error', '#DIGITALPATTA0018, pdar_add1 not found for applicant in chitha_pattadar for case_no '. $case_no);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTA0018, SOME ERROR OCCURRED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        //checking pdar_name
        if(trim($chitha_pattadar_applicant_query->pdar_name) == "" || $chitha_pattadar_applicant_query->pdar_name == null){
            log_message('error', '#DIGITALPATTA0019, pdar_name not found for applicant in chitha_pattadar for case_no '. $case_no);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTA0019, SOME ERROR OCCURRED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        //checking patta_no
        if(trim($chitha_pattadar_applicant_query->patta_no) == "" || $chitha_pattadar_applicant_query->patta_no == null){
            log_message('error', '#DIGITALPATTA0020, patta_no not found for applicant in chitha_pattadar for case_no '. $case_no);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTA0020, SOME ERROR OCCURRED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        //checking dob
        if(trim($chitha_pattadar_applicant_query->dob) == "" || $chitha_pattadar_applicant_query->dob == null){
            log_message('error', '#DIGITALPATTA0021, dob not found for applicant in chitha_pattadar for case_no '. $case_no);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTA0021, SOME ERROR OCCURRED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        //getting joint applicant details
        $applicant_details_query = $this->digitalPattaPattadarModel->getJointApplicantDetails($case_no);
        if($applicant_details_query !="NOT-FOUND")
        {
            $joint_applicant_data = $applicant_details_query;
        }
        else
        {
            $joint_applicant_data = [];
        }

        //geting family details from chitha_nominee_pattadar
        $family_details_query = $this->digitalPattaPattadarModel->getFamilyDetailsFromLocation($dist_code,
            $subdiv_code,$cir_code,$mouza_pargona_code,
            $lot_no,$vill_townprt_code,
            $patta_type_code,$patta_no);
        if($family_details_query !="NOT-FOUND")
        {
            $family_details = $family_details_query;
            foreach ($family_details_query as $family_detail)
            {
                //checking nominee_name
                if(trim($family_detail->nominee_name) == "" || $family_detail->nominee_name == null)
                {
                    log_message('error', '#DIGITALPATTA0025, nominee_name not found in chitha_nominee_pattadar for case_no '. $case_no);
                    return [
                        'result' => false,
                        'msg' => 'ERROR-CODE:#DIGITALPATTA0025, SOME ERROR OCCURRED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                        'responseType' => 3,
                        'case_no' => $case_no
                    ];
                }

                //checking nominee_address
                if(trim($family_detail->nominee_address) == "" || $family_detail->nominee_address == null)
                {
                    log_message('error', '#DIGITALPATTA0026, nominee_address not found in chitha_nominee_pattadar for case_no '. $case_no);
                    return [
                        'result' => false,
                        'msg' => 'ERROR-CODE:#DIGITALPATTA0026, SOME ERROR OCCURRED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                        'responseType' => 3,
                        'case_no' => $case_no
                    ];
                }

                //checking nominee_relation
                if(trim($family_detail->nominee_relation) == "" || $family_detail->nominee_relation == null)
                {
                    log_message('error', '#DIGITALPATTA0027, nominee_relation not found in chitha_nominee_pattadar for case_no '. $case_no);
                    return [
                        'result' => false,
                        'msg' => 'ERROR-CODE:#DIGITALPATTA0027, SOME ERROR OCCURRED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                        'responseType' => 3,
                        'case_no' => $case_no
                    ];
                }
            }
        }
        else
        {
            $family_details = [];
        }


        //geting chitha_settlement_allottee details from case no
        $chitha_allottee_details = $this->digitalPattaLocationModel->getChithaAlloteeDetailsFromcaseNo($case_no);
        if($chitha_allottee_details !="No Data Found")
        {
            $allotee_details = $chitha_allottee_details;
        }
        else
        {
            $allotee_details = null;
            log_message('error', '#DIGITALPATTA0028, chitha settlement allotee details not found for the case no  '. $case_no);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTA0028, chitha settlement allotee details not found for Case No .'.$case_no.'. PLEASE CONTACT ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }


        //geting chitha basic details from location
        $chitha_basic_details = $this->digitalPattaLocationModel->getChithaBasicDetailsFromLocation($dist_code,
            $subdiv_code,$cir_code,$mouza_pargona_code, $lot_no,$vill_townprt_code, $patta_type_code,$patta_no);
        if($chitha_basic_details !="NOT-FOUND")
        {
            $chitha_basic = $chitha_basic_details;
        }
        else
        {
            $chitha_basic = null;
            log_message('error', '#DIGITALPATTA0029, chitha basic details not found for the case no  '. $case_no);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTA0029, chitha basic details not found for Case NO .'.$case_no.'. PLEASE CONTACT ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }


        foreach($chitha_basic_details as $chitha_basic_detail)
        {

            //checking chitha_Old_dag no
            if (trim($chitha_basic_detail->old_dag_no) == "" || $chitha_basic_detail->old_dag_no == null)
            {
                $check_old_dag = $this->digitalPattaDagDetailsModel->checkOldDagNo($case_no, $chitha_basic_detail->dag_no, $chitha_basic_detail->old_dag_no);
                if ($check_old_dag == "SAME_DAG") {
                    $chitha_basic_detail->old_dag_no = "N/A";
                } else {
                    $chitha_basic_detail->old_dag_no = '--';
                }

            }

            //checking new dag no
            if (trim($chitha_basic_detail->dag_no) == "" || $chitha_basic_detail->dag_no == null) {
                log_message('error', '#DIGITALPATTA0031, dag_no not found in chitha_basic for case_no ' . $case_no);
                return [
                    'result' => false,
                    'msg' => 'ERROR-CODE:#DIGITALPATTA0031, SOME ERROR OCCURRED, for Case NO .' . $case_no . '. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no' => $case_no
                ];
            }


            $dag_no_new = trim($chitha_basic_detail->dag_no);
            $dag_no_old = trim($chitha_basic_detail->old_dag_no);

            // check bhunaksha_svamitva_cases status
            $bhunakshaDetails = $this->checkBhunakshaDetails($dist_code,$case_no,$dag_no_new,$dag_no_old);
            if ($bhunakshaDetails != 1)
            {
                log_message('error', '#DIGITALPATTA00310, dag_no not found in bhunaksha_svamitva_cases for case_no ' . $case_no);
                return [
                    'result' => false,
                    'msg' => 'ERROR-CODE:#DIGITALPATTA00310, SOME ERROR OCCURRED, for Case NO .' . $case_no . '. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no' => $case_no
                ];
            }

            $checkPropertyDetails = $this->checkPropertyDetails($case_no,$dag_no_new,$dag_no_old);
            if ($checkPropertyDetails == 0)
            {
                log_message('error', '#DIGITALPATTA00311, case not found in property_details for case_no ' . $case_no);
                return [
                    'result' => false,
                    'msg' => 'ERROR-CODE:#DIGITALPATTA00311, SOME ERROR OCCURRED, for Case NO .' . $case_no . '. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no' => $case_no
                ];
            }

            $propertyDetails = $this->getPropertyDetails($case_no,$dag_no_new,$dag_no_old);


            //checking old patta no
            if (trim($chitha_basic_detail->old_patta_no) == "" || $chitha_basic_detail->old_patta_no == null)
            {
                if ($settlementBasic->service_code != '13' || $settlementBasic->service_code != '14')
                {
                    $chitha_basic_detail->old_patta_no = '0';
                }
                else
                {
                    log_message('error', '#DIGITALPATTA0032, old_patta_no not found in chitha_basic for case_no ' . $case_no);
                    return [
                        'result' => false,
                        'msg' => 'ERROR-CODE:#DIGITALPATTA0032, SOME ERROR OCCURRED, for Case NO .' . $case_no . '. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                        'responseType' => 3,
                        'case_no' => $case_no
                    ];
                }
            }

            //checking patta no
            if (trim($chitha_basic_detail->patta_no) == "" || $chitha_basic_detail->patta_no == null) {
                log_message('error', '#DIGITALPATTA0033, patta_no not found in chitha_basic for case_no ' . $case_no);
                return [
                    'result' => false,
                    'msg' => 'ERROR-CODE:#DIGITALPATTA0033, SOME ERROR OCCURRED, for Case NO .' . $case_no . '. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no' => $case_no
                ];
            }

            //checking land_class_code
            if (trim($chitha_basic_detail->land_class_code) == "" || $chitha_basic_detail->land_class_code == null) {
                log_message('error', '#DIGITALPATTA0034, land_class_code not found in chitha_basic for case_no ' . $case_no);
                return [
                    'result' => false,
                    'msg' => 'ERROR-CODE:#DIGITALPATTA0034, SOME ERROR OCCURRED, for Case NO .' . $case_no . '. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no' => $case_no
                ];
            }

            //checking land_class_code
            if (trim($chitha_basic_detail->land_class_code) == '0134') {
                log_message('error', '#DIGITALPATTA01134, land_class_code not found to be shreni nai in chitha_basic for case_no ' . $case_no);
                return [
                    'result' => false,
                    'msg' => 'ERROR-CODE:#DIGITALPATTA01134, SOME ERROR OCCURRED, for Case NO .' . $case_no . '. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no' => $case_no
                ];
            }

            //checking dag_revenue
            if (trim($chitha_basic_detail->dag_revenue) == "" || $chitha_basic_detail->dag_revenue == null || $chitha_basic_detail->dag_revenue == 0) {
                log_message('error', '#DIGITALPATTA0035, dag_revenue not found in chitha_basic for case_no ' . $case_no);
                return [
                    'result' => false,
                    'msg' => 'ERROR-CODE:#DIGITALPATTA0035, SOME ERROR OCCURRED, for Case NO .' . $case_no . '. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no' => $case_no
                ];
            }

            //checking dag_local_tax
            if (trim($chitha_basic_detail->dag_local_tax) == "" || $chitha_basic_detail->dag_local_tax == null || $chitha_basic_detail->dag_local_tax == 0) {
                log_message('error', '#DIGITALPATTA0036, dag_local_tax not found in chitha_basic for case_no ' . $case_no);
                return [
                    'result' => false,
                    'msg' => 'ERROR-CODE:#DIGITALPATTA0036, SOME ERROR OCCURRED, for Case NO .' . $case_no . '. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no' => $case_no
                ];
            }

            //checking north village
            if (trim($chitha_basic_detail->dag_n_desc) == "" || $chitha_basic_detail->dag_n_desc == null) {
                log_message('error', '#DIGITALPATTA0037, dag_n_desc not found in chitha_basic for case_no ' . $case_no);
                return [
                    'result' => false,
                    'msg' => 'ERROR-CODE:#DIGITALPATTA0037, SOME ERROR OCCURRED, for Case NO .' . $case_no . '. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no' => $case_no
                ];
            }

            $chitha_basic_detail->dag_n_desc = $this->digitalPattaDagDetailsModel->getVillagenameFromLocation($dist_code,
                $subdiv_code, $cir_code, $mouza_pargona_code,
                $lot_no, $vill_townprt_code);

            if ($chitha_basic_detail->dag_n_desc == "NOT-FOUND") {
                log_message('error', '#DIGITALPATTA0138, dag_n_des not found in location for case_no ' . $case_no);
                return [
                    'result' => false,
                    'msg' => 'ERROR-CODE:#DIGITALPATTA0138, SOME ERROR OCCURRED, for Case NO .' . $case_no . '. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no' => $case_no
                ];
            }
            // ****************************
            //checking south village
            if (trim($chitha_basic_detail->dag_s_desc) == "" || $chitha_basic_detail->dag_s_desc == null) {
                log_message('error', '#DIGITALPATTA0038, dag_s_desc not found in chitha_basic for case_no ' . $case_no);
                return [
                    'result' => false,
                    'msg' => 'ERROR-CODE:#DIGITALPATTA0038, SOME ERROR OCCURRED, for Case NO .' . $case_no . '. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no' => $case_no
                ];
            }
            $chitha_basic_detail->dag_s_desc = $this->digitalPattaDagDetailsModel->getVillagenameFromLocation($dist_code,
                $subdiv_code, $cir_code, $mouza_pargona_code,
                $lot_no, $vill_townprt_code);

            if ($chitha_basic_detail->dag_s_desc == "NOT-FOUND") {
                log_message('error', '#DIGITALPATTA0139, dag_s_des not found in location for case_no ' . $case_no);
                return [
                    'result' => false,
                    'msg' => 'ERROR-CODE:#DIGITALPATTA0139, SOME ERROR OCCURRED, for Case NO .' . $case_no . '. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no' => $case_no
                ];
            }
            // ****************************
            //checking east village
            if (trim($chitha_basic_detail->dag_e_desc) == "" || $chitha_basic_detail->dag_e_desc == null) {
                log_message('error', '#DIGITALPATTA0039, dag_e_desc not found in chitha_basic for case_no ' . $case_no);
                return [
                    'result' => false,
                    'msg' => 'ERROR-CODE:#DIGITALPATTA0039, SOME ERROR OCCURRED, for Case NO .' . $case_no . '. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no' => $case_no
                ];
            }
            $chitha_basic_detail->dag_e_desc = $this->digitalPattaDagDetailsModel->getVillagenameFromLocation($dist_code,
                $subdiv_code, $cir_code, $mouza_pargona_code,
                $lot_no, $vill_townprt_code);

            if ($chitha_basic_detail->dag_e_desc == "NOT-FOUND") {
                log_message('error', '#DIGITALPATTA0140, dag_e_des not found in location for case_no ' . $case_no);
                return [
                    'result' => false,
                    'msg' => 'ERROR-CODE:#DIGITALPATTA0140, SOME ERROR OCCURRED, for Case NO .' . $case_no . '. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no' => $case_no
                ];
            }
            // *********************
            //checking west village
            if (trim($chitha_basic_detail->dag_w_desc) == "" || $chitha_basic_detail->dag_w_desc == null) {
                log_message('error', '#DIGITALPATTA0040, dag_w_desc not found in chitha_basic for case_no ' . $case_no);
                return [
                    'result' => false,
                    'msg' => 'ERROR-CODE:#DIGITALPATTA0040, SOME ERROR OCCURRED, for Case NO .' . $case_no . '. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no' => $case_no
                ];
            }

            $chitha_basic_detail->dag_w_desc = $this->digitalPattaDagDetailsModel->getVillagenameFromLocation($dist_code,
                $subdiv_code, $cir_code, $mouza_pargona_code,
                $lot_no, $vill_townprt_code);
            if ($chitha_basic_detail->dag_w_desc == "NOT-FOUND") {
                log_message('error', '#DIGITALPATTA0141, dag_w_desc not found in location for case_no ' . $case_no);
                return [
                    'result' => false,
                    'msg' => 'ERROR-CODE:#DIGITALPATTA0141, SOME ERROR OCCURRED, for Case NO .' . $case_no . '. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no' => $case_no
                ];
            }

            //checking north dag
            if (trim($chitha_basic_detail->dag_n_dag_no) == "" || $chitha_basic_detail->dag_n_dag_no == null) {
                log_message('error', '#DIGITALPATTA0041, dag_n_dag_no not found in chitha_basic for case_no ' . $case_no);
                return [
                    'result' => false,
                    'msg' => 'ERROR-CODE:#DIGITALPATTA0041, SOME ERROR OCCURRED, for Case NO .' . $case_no . '. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no' => $case_no
                ];
            }

            //checking south dag
            if (trim($chitha_basic_detail->dag_s_dag_no) == "" || $chitha_basic_detail->dag_s_dag_no == null) {
                log_message('error', '#DIGITALPATTA0042, dag_s_dag_no not found in chitha_basic for case_no ' . $case_no);
                return [
                    'result' => false,
                    'msg' => 'ERROR-CODE:#DIGITALPATTA0042, SOME ERROR OCCURRED, for Case NO .' . $case_no . '. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no' => $case_no
                ];
            }

            //checking west dag
            if (trim($chitha_basic_detail->dag_w_dag_no) == "" || $chitha_basic_detail->dag_w_dag_no == null) {
                log_message('error', '#DIGITALPATTA0043, dag_w_dag_no not found in chitha_basic for case_no ' . $case_no);
                return [
                    'result' => false,
                    'msg' => 'ERROR-CODE:#DIGITALPATTA0043, SOME ERROR OCCURRED, for Case NO .' . $case_no . '. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no' => $case_no
                ];
            }

            //checking east dag
            if (trim($chitha_basic_detail->dag_e_dag_no) == "" || $chitha_basic_detail->dag_e_dag_no == null) {
                log_message('error', '#DIGITALPATTA0044, dag_e_dag_no not found in chitha_basic for case_no ' . $case_no);
                return [
                    'result' => false,
                    'msg' => 'ERROR-CODE:#DIGITALPATTA0044, SOME ERROR OCCURRED, for Case NO .' . $case_no . '. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no' => $case_no
                ];
            }

        }


        //geting longitude and latitude details from application_no
        $geo_co_ordinate_details = $this->digitalPattaLocationModel->getGeoCordinatesFromAppNo($applno);
        if($geo_co_ordinate_details !="No Data Found")
        {
            $geo_co_ordinates = $geo_co_ordinate_details;
        }
        else
        {
            $geo_co_ordinates = null;
            log_message('error', '#DIGITALPATTA0045, supportive_document_mobile details not found for the case no  '. $case_no);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTA0045, geo co-ordinate details not found for Case NO .'.$case_no.'. PLEASE CONTACT ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        $locationCode = $dist_code.$subdiv_code.$cir_code.$mouza_pargona_code.$lot_no.$vill_townprt_code;

        return [
            "result"                         => true,
            'responseType'                   => 2,
            "errors"                         => $error_msgs,
            "settlement_applicant"           => $settlement_applicant_data,
            "settlement_basic_details"       => $settlement_basic_details,
            "applicant_data"                 => $applicant_data,
            "chitha_pattadar_applicant_data" => $chitha_pattadar_applicant_data,
            "chitha_settlement_allotee"      => $allotee_details,
            "chitha_basic"                   => $chitha_basic,
            "joint_applicant_data"           => $joint_applicant_data,
            "family_details"                 => $family_details,
            "co_ordinates"                   => $geo_co_ordinates,
            "location_code"                  => $locationCode,
            "propertyDetails"                => $propertyDetails,
        ];

    }


    //getting digital patta details
    public function getPattaInfoPrint($applno)
    {
        $error_msgs = array();
        //getting settlement basic details
        $settlementBasic = $this->digitalPattaDetailsModel->getSettlementBasicDetails($applno);
        if($settlementBasic !="No Data Found")
        {
            $settlement_basic_details = $settlementBasic;
        }
        else
        {
            $settlement_basic_details = null;
            log_message('error', '#DIGITALPATTAP00001,settlement basic details not found for applid '. $applno);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTAP00001, SOME ERROR OCCURRED, for Case NO .'.$applno.'. PLEASE CONTACT ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $applno
            ];
        }

        $case_no    = trim($settlementBasic->case_no);
        $sb_status  = trim($settlementBasic->status);
        $sb_service = trim($settlementBasic->service_code);
        //checking whether status is N or not
        if(trim($sb_status) != 'N'){
            log_message('error', '#DIGITALPATTAP001,settlement basic status is not found to be N for applid '. $applno);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTAP001, SOME ERROR OCCURRED, for Case NO .'.$case_no.'. PLEASE CONTACT ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        //checking service code
        if(trim($settlementBasic->service_code) == '' || $settlementBasic->service_code == null){
            log_message('error', '#DIGITALPATTAP002, service code not found in settlement basic for case_no '. $case_no);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTAP002, SOME ERROR OCCURRED, for Case NO .'.$case_no.'. PLEASE CONTACT ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        //checking whether service_code
        if(!in_array($sb_service, NC_DIGITAL_PATTA_SERVICE_CODE_ALLOW))
        {
            log_message('error', '#DIGITALPATTAP00141,settlement basic service_code is not found for applid '. $applno);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTAP00141, SOME ERROR OCCURRED, for Case NO .'.$case_no.'. PLEASE CONTACT ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        //checking dist_code
        if(trim($settlementBasic->dist_code) == '' || $settlementBasic->dist_code == null){
            log_message('error', '#DIGITALPATTAP003, dist_code not found in settlement basic for applid '. $applno);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTAP003, SOME ERROR OCCURRED, for Case NO .'.$case_no.'. PLEASE CONTACT ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        //checking subdiv_code
        if(trim($settlementBasic->subdiv_code) == '' || $settlementBasic->subdiv_code == null){
            log_message('error', '#DIGITALPATTAP004, subdiv_code not found in settlement basic for applid '. $applno);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTAP004, SOME ERROR OCCURRED, for Case NO .'.$case_no.'. PLEASE CONTACT ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        //checking cir_code
        if(trim($settlementBasic->cir_code) == '' || $settlementBasic->cir_code == null){
            log_message('error', '#DIGITALPATTAP005, cir_code not found in settlement basic for applid '. $applno);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTAP005, SOME ERROR OCCURRED, for Case NO .'.$case_no.'. PLEASE CONTACT ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        //checking mouza_pargona_code
        if(trim($settlementBasic->mouza_pargona_code) == '' || $settlementBasic->mouza_pargona_code == null){
            log_message('error', '#DIGITALPATTAP006, mouza_pargona_code not found in settlement basic for applid '. $applno);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTAP006 , SOME ERROR OCCURRED, for Case NO .'.$case_no.'. PLEASE CONTACT ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        //checking lot_no
        if(trim($settlementBasic->lot_no) == '' || $settlementBasic->lot_no == null){
            log_message('error', '#DIGITALPATTAP007, lot_no not found in settlement basic for applid '. $applno);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTAP007, SOME ERROR OCCURRED, for Case NO .'.$case_no.'. PLEASE CONTACT ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        //checking vill_townprt_code
        if(trim($settlementBasic->vill_townprt_code) == '' || $settlementBasic->vill_townprt_code == null){
            log_message('error', '#DIGITALPATTAP008, vill_townprt_code not found in settlement basic for applid '. $applno);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTAP008, SOME ERROR OCCURRED, for Case NO .'.$case_no.'. PLEASE CONTACT ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        //geteting settlement applicant data
        $applicant_data_query = $this->digitalPattaPattadarModel->getSettlememtApplicant_data($case_no);

        if($applicant_data_query !="NOT-FOUND")
        {
            $settlement_applicant_data = $applicant_data_query;
        }
        else
        {
            //if applicant data is not found throw error and return
            $settlement_applicant_data = null;
            log_message('error', '#DIGITALPATTA1009, Applicant details not found for the case no  '. $case_no);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTA1009, Applicant details not found ,for Case NO .'.$case_no,
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        //getting digital patta applicant details from chitha_settlement_allottee where is applicant is 1
        $applicant_query = $this->digitalPattaPattadarModel->getApplicantDetails($case_no);
        if($applicant_query !="NOT-FOUND")
        {
            $applicant_data = $applicant_query;
        }
        else
        {
            //if applicant data is not found throw error and return
            $applicant_data = null;
            log_message('error', '#DIGITALPATTAP009, Applicant details not found for the case no  '. $case_no);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTAP009, Applicant details not found ,for Case NO .'.$case_no,
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        //checking settlement_name
        if(trim($applicant_query->settlement_name) == "" || $applicant_query->settlement_name == null){
            log_message('error', '#DIGITALPATTAP0010, settlement_name not found for applicant in chitha settlement allottee for case_no '. $case_no);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTAP0010, SOME ERROR OCCURRED, for Case NO .'.$case_no.'.  PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        //checking settlement_guardian
        if(trim($applicant_query->settlement_guardian) == "" || $applicant_query->settlement_guardian == null){
            log_message('error', '#DIGITALPATTAP0011, settlement_guardian not found for applicant in settlement_allotee for case_no '. $case_no);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTAP0011, for Case NO .'.$case_no.'. SOME ERROR OCCURRED, PLEASE CONTACT ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        //checking grn_no
        if(trim($applicant_query->grn_no) == "" || $applicant_query->grn_no == null){
            log_message('error', '#DIGITALPATTAP0012, grn_no not found for applicant in settlement_allottee for case_no '. $case_no);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTAP0012, SOME ERROR OCCURRED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        //checking identity type
        if(trim($applicant_query->identity_type) == "" || $applicant_query->identity_type == null){
            log_message('error', '#DIGITALPATTAP0013, identity_type not found for applicant in settlement_allottee for case_no '. $case_no);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTAP0013, SOME ERROR OCCURRED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        //getting settlement_applicant details from chitha pattadar
        $chitha_pattadar_applicant_query = $this->digitalPattaPattadarModel->getAllDetailsOfApplicant($case_no);
        if($chitha_pattadar_applicant_query !="NOT-FOUND")
        {
            $chitha_pattadar_applicant_data = $chitha_pattadar_applicant_query;
        }
        else
        {
            $chitha_pattadar_applicant_data = null;
            log_message('error', '#DIGITALPATTAP0014, Pattadar details not found for the case no  '. $case_no);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTAP0014, Pattadar details not found ,for Case NO .'.$case_no,
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        // fetching out the location of the new patta
        $dist_code          = $chitha_pattadar_applicant_query->dist_code;
        $subdiv_code        = $chitha_pattadar_applicant_query->subdiv_code;
        $cir_code           = $chitha_pattadar_applicant_query->cir_code;
        $mouza_pargona_code = $chitha_pattadar_applicant_query->mouza_pargona_code;
        $lot_no             = $chitha_pattadar_applicant_query->lot_no;
        $vill_townprt_code  = $chitha_pattadar_applicant_query->vill_townprt_code;
        $patta_type_code    = $chitha_pattadar_applicant_query->patta_type_code;
        $patta_no           = $chitha_pattadar_applicant_query->patta_no;


        //checking case_no
        if(trim($chitha_pattadar_applicant_query->o1_case_no) == "" || $chitha_pattadar_applicant_query->o1_case_no == null){
            log_message('error', '#DIGITALPATTAP0015, o1_case_no_caste not found for applicant in chitha_pattadar for case_no '. $case_no);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTAP0015, SOME ERROR OCCURRED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }



        //checking pdar_caste
        if(trim($chitha_pattadar_applicant_query->pdar_caste) == "" || $chitha_pattadar_applicant_query->pdar_caste == null){
            log_message('error', '#DIGITALPATTAP0017, pdar_caste not found for applicant in chitha_pattadar for case_no '. $case_no);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTAP0017, SOME ERROR OCCURRED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        //checking pdar_add1
        if(trim($chitha_pattadar_applicant_query->pdar_add1) == "" || $chitha_pattadar_applicant_query->pdar_add1 == null){
            log_message('error', '#DIGITALPATTAP0018, pdar_add1 not found for applicant in chitha_pattadar for case_no '. $case_no);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTAP0018, SOME ERROR OCCURRED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        //checking pdar_name
        if(trim($chitha_pattadar_applicant_query->pdar_name) == "" || $chitha_pattadar_applicant_query->pdar_name == null){
            log_message('error', '#DIGITALPATTAP0019, pdar_name not found for applicant in chitha_pattadar for case_no '. $case_no);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTAP0019, SOME ERROR OCCURRED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        //checking patta_no
        if(trim($chitha_pattadar_applicant_query->patta_no) == "" || $chitha_pattadar_applicant_query->patta_no == null){
            log_message('error', '#DIGITALPATTAP0020, patta_no not found for applicant in chitha_pattadar for case_no '. $case_no);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTAP0020, SOME ERROR OCCURRED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        //checking dob
        if(trim($chitha_pattadar_applicant_query->dob) == "" || $chitha_pattadar_applicant_query->dob == null){
            log_message('error', '#DIGITALPATTAP0021, dob not found for applicant in chitha_pattadar for case_no '. $case_no);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTAP0021, SOME ERROR OCCURRED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        //getting joint applicant details
        $applicant_details_query = $this->digitalPattaPattadarModel->getJointApplicantDetails($case_no);
        if($applicant_details_query !="NOT-FOUND")
        {
            $joint_applicant_data = $applicant_details_query;
        }
        else
        {
            $joint_applicant_data = [];
        }

        //geting family details from chitha_nominee_pattadar
        $family_details_query = $this->digitalPattaPattadarModel->getFamilyDetailsFromLocation($dist_code,
            $subdiv_code,$cir_code,$mouza_pargona_code,
            $lot_no,$vill_townprt_code,
            $patta_type_code,$patta_no);
        if($family_details_query !="NOT-FOUND")
        {
            $family_details = $family_details_query;
            foreach ($family_details_query as $family_detail)
            {
                //checking nominee_name
                if(trim($family_detail->nominee_name) == "" || $family_detail->nominee_name == null)
                {
                    log_message('error', '#DIGITALPATTAP0025, nominee_name not found in chitha_nominee_pattadar for case_no '. $case_no);
                    return [
                        'result' => false,
                        'msg' => 'ERROR-CODE:#DIGITALPATTAP0025, SOME ERROR OCCURRED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                        'responseType' => 3,
                        'case_no' => $case_no
                    ];
                }

                //checking nominee_address
                if(trim($family_detail->nominee_address) == "" || $family_detail->nominee_address == null)
                {
                    log_message('error', '#DIGITALPATTAP0026, nominee_address not found in chitha_nominee_pattadar for case_no '. $case_no);
                    return [
                        'result' => false,
                        'msg' => 'ERROR-CODE:#DIGITALPATTAP0026, SOME ERROR OCCURRED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                        'responseType' => 3,
                        'case_no' => $case_no
                    ];
                }

                //checking nominee_relation
                if(trim($family_detail->nominee_relation) == "" || $family_detail->nominee_relation == null)
                {
                    log_message('error', '#DIGITALPATTAP0027, nominee_relation not found in chitha_nominee_pattadar for case_no '. $case_no);
                    return [
                        'result' => false,
                        'msg' => 'ERROR-CODE:#DIGITALPATTAP0027, SOME ERROR OCCURRED, for Case NO .'.$case_no.'. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                        'responseType' => 3,
                        'case_no' => $case_no
                    ];
                }
            }
        }
        else
        {
            $family_details = [];
        }


        //geting chitha_settlement_allottee details from case no
        $chitha_allottee_details = $this->digitalPattaLocationModel->getChithaAlloteeDetailsFromcaseNo($case_no);
        if($chitha_allottee_details !="No Data Found")
        {
            $allotee_details = $chitha_allottee_details;
        }
        else
        {
            $allotee_details = null;
            log_message('error', '#DIGITALPATTAP0028, chitha settlement allotee details not found for the case no  '. $case_no);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTAP0028, chitha settlement allotee details not found for Case No .'.$case_no.'. PLEASE CONTACT ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }


        //geting chitha basic details from location
        $chitha_basic_details = $this->digitalPattaLocationModel->getChithaBasicDetailsFromLocation($dist_code,
            $subdiv_code,$cir_code,$mouza_pargona_code, $lot_no,$vill_townprt_code, $patta_type_code,$patta_no);
        if($chitha_basic_details !="NOT-FOUND")
        {
            $chitha_basic = $chitha_basic_details;
        }
        else
        {
            $chitha_basic = null;
            log_message('error', '#DIGITALPATTAP0029, chitha basic details not found for the case no  '. $case_no);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTAP0029, chitha basic details not found for Case NO .'.$case_no.'. PLEASE CONTACT ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }


        foreach($chitha_basic_details as $chitha_basic_detail)
        {

            //checking chitha_Old_dag no
            if (trim($chitha_basic_detail->old_dag_no) == "" || $chitha_basic_detail->old_dag_no == null)
            {
                $check_old_dag = $this->digitalPattaDagDetailsModel->checkOldDagNo($case_no, $chitha_basic_detail->dag_no, $chitha_basic_detail->old_dag_no);
                if ($check_old_dag == "SAME_DAG") {
                    $chitha_basic_detail->old_dag_no = "N/A";
                } else {
                    $chitha_basic_detail->old_dag_no = '--';
                }

            }

            //checking new dag no
            if (trim($chitha_basic_detail->dag_no) == "" || $chitha_basic_detail->dag_no == null) {
                log_message('error', '#DIGITALPATTAP0031, dag_no not found in chitha_basic for case_no ' . $case_no);
                return [
                    'result' => false,
                    'msg' => 'ERROR-CODE:#DIGITALPATTAP0031, SOME ERROR OCCURRED, for Case NO .' . $case_no . '. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no' => $case_no
                ];
            }


            $dag_no_new = trim($chitha_basic_detail->dag_no);
            $dag_no_old = trim($chitha_basic_detail->old_dag_no);

            // check bhunaksha_svamitva_cases status
            $bhunakshaDetails = $this->checkBhunakshaDetailsPrint($dist_code,$case_no,$dag_no_new,$dag_no_old);
            if ($bhunakshaDetails != 1)
            {
                log_message('error', '#DIGITALPATTAP00310, dag_no not found in bhunaksha_svamitva_cases for case_no ' . $case_no);
                return [
                    'result' => false,
                    'msg' => 'ERROR-CODE:#DIGITALPATTAP00310, SOME ERROR OCCURRED, for Case NO .' . $case_no . '. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no' => $case_no
                ];
            }

            $checkPropertyDetails = $this->checkPropertyDetails($case_no,$dag_no_new,$dag_no_old);
            if ($checkPropertyDetails == 0)
            {
                log_message('error', '#DIGITALPATTAP00311, case not found in property_details for case_no ' . $case_no);
                return [
                    'result' => false,
                    'msg' => 'ERROR-CODE:#DIGITALPATTAP00311, SOME ERROR OCCURRED, for Case NO .' . $case_no . '. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no' => $case_no
                ];
            }

            $propertyDetails = $this->getPropertyDetails($case_no,$dag_no_new,$dag_no_old);


            //checking old patta no
            if (trim($chitha_basic_detail->old_patta_no) == "" || $chitha_basic_detail->old_patta_no == null)
            {
                if ($settlementBasic->service_code != '13' || $settlementBasic->service_code != '14')
                {
                    $chitha_basic_detail->old_patta_no = '0';
                }
                else
                {
                    log_message('error', '#DIGITALPATTAP0032, old_patta_no not found in chitha_basic for case_no ' . $case_no);
                    return [
                        'result' => false,
                        'msg' => 'ERROR-CODE:#DIGITALPATTAP0032, SOME ERROR OCCURRED, for Case NO .' . $case_no . '. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                        'responseType' => 3,
                        'case_no' => $case_no
                    ];
                }
            }

            //checking patta no
            if (trim($chitha_basic_detail->patta_no) == "" || $chitha_basic_detail->patta_no == null) {
                log_message('error', '#DIGITALPATTAP0033, patta_no not found in chitha_basic for case_no ' . $case_no);
                return [
                    'result' => false,
                    'msg' => 'ERROR-CODE:#DIGITALPATTAP0033, SOME ERROR OCCURRED, for Case NO .' . $case_no . '. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no' => $case_no
                ];
            }

            //checking land_class_code
            if (trim($chitha_basic_detail->land_class_code) == "" || $chitha_basic_detail->land_class_code == null) {
                log_message('error', '#DIGITALPATTAP0034, land_class_code not found in chitha_basic for case_no ' . $case_no);
                return [
                    'result' => false,
                    'msg' => 'ERROR-CODE:#DIGITALPATTAP0034, SOME ERROR OCCURRED, for Case NO .' . $case_no . '. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no' => $case_no
                ];
            }

            //checking land_class_code
            if (trim($chitha_basic_detail->land_class_code) == '0134') {
                log_message('error', '#DIGITALPATTAP01134, land_class_code not found to be shreni nai in chitha_basic for case_no ' . $case_no);
                return [
                    'result' => false,
                    'msg' => 'ERROR-CODE:#DIGITALPATTAP01134, SOME ERROR OCCURRED, for Case NO .' . $case_no . '. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no' => $case_no
                ];
            }

            //checking dag_revenue
            if (trim($chitha_basic_detail->dag_revenue) == "" || $chitha_basic_detail->dag_revenue == null || $chitha_basic_detail->dag_revenue == 0) {
                log_message('error', '#DIGITALPATTAP0035, dag_revenue not found in chitha_basic for case_no ' . $case_no);
                return [
                    'result' => false,
                    'msg' => 'ERROR-CODE:#DIGITALPATTAP0035, SOME ERROR OCCURRED, for Case NO .' . $case_no . '. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no' => $case_no
                ];
            }

            //checking dag_local_tax
            if (trim($chitha_basic_detail->dag_local_tax) == "" || $chitha_basic_detail->dag_local_tax == null || $chitha_basic_detail->dag_local_tax == 0) {
                log_message('error', '#DIGITALPATTAP0036, dag_local_tax not found in chitha_basic for case_no ' . $case_no);
                return [
                    'result' => false,
                    'msg' => 'ERROR-CODE:#DIGITALPATTAP0036, SOME ERROR OCCURRED, for Case NO .' . $case_no . '. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no' => $case_no
                ];
            }

            //checking north village
            if (trim($chitha_basic_detail->dag_n_desc) == "" || $chitha_basic_detail->dag_n_desc == null) {
                log_message('error', '#DIGITALPATTAP0037, dag_n_desc not found in chitha_basic for case_no ' . $case_no);
                return [
                    'result' => false,
                    'msg' => 'ERROR-CODE:#DIGITALPATTAP0037, SOME ERROR OCCURRED, for Case NO .' . $case_no . '. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no' => $case_no
                ];
            }

            $chitha_basic_detail->dag_n_desc = $this->digitalPattaDagDetailsModel->getVillagenameFromLocation($dist_code,
                $subdiv_code, $cir_code, $mouza_pargona_code,
                $lot_no, $vill_townprt_code);

            if ($chitha_basic_detail->dag_n_desc == "NOT-FOUND") {
                log_message('error', '#DIGITALPATTAP0138, dag_n_des not found in location for case_no ' . $case_no);
                return [
                    'result' => false,
                    'msg' => 'ERROR-CODE:#DIGITALPATTAP0138, SOME ERROR OCCURRED, for Case NO .' . $case_no . '. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no' => $case_no
                ];
            }
            // ****************************
            //checking south village
            if (trim($chitha_basic_detail->dag_s_desc) == "" || $chitha_basic_detail->dag_s_desc == null) {
                log_message('error', '#DIGITALPATTAP0038, dag_s_desc not found in chitha_basic for case_no ' . $case_no);
                return [
                    'result' => false,
                    'msg' => 'ERROR-CODE:#DIGITALPATTAP0038, SOME ERROR OCCURRED, for Case NO .' . $case_no . '. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no' => $case_no
                ];
            }
            $chitha_basic_detail->dag_s_desc = $this->digitalPattaDagDetailsModel->getVillagenameFromLocation($dist_code,
                $subdiv_code, $cir_code, $mouza_pargona_code,
                $lot_no, $vill_townprt_code);

            if ($chitha_basic_detail->dag_s_desc == "NOT-FOUND") {
                log_message('error', '#DIGITALPATTAP0139, dag_s_des not found in location for case_no ' . $case_no);
                return [
                    'result' => false,
                    'msg' => 'ERROR-CODE:#DIGITALPATTAP0139, SOME ERROR OCCURRED, for Case NO .' . $case_no . '. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no' => $case_no
                ];
            }
            // ****************************
            //checking east village
            if (trim($chitha_basic_detail->dag_e_desc) == "" || $chitha_basic_detail->dag_e_desc == null) {
                log_message('error', '#DIGITALPATTAP0039, dag_e_desc not found in chitha_basic for case_no ' . $case_no);
                return [
                    'result' => false,
                    'msg' => 'ERROR-CODE:#DIGITALPATTAP0039, SOME ERROR OCCURRED, for Case NO .' . $case_no . '. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no' => $case_no
                ];
            }
            $chitha_basic_detail->dag_e_desc = $this->digitalPattaDagDetailsModel->getVillagenameFromLocation($dist_code,
                $subdiv_code, $cir_code, $mouza_pargona_code,
                $lot_no, $vill_townprt_code);

            if ($chitha_basic_detail->dag_e_desc == "NOT-FOUND") {
                log_message('error', '#DIGITALPATTAP0140, dag_e_des not found in location for case_no ' . $case_no);
                return [
                    'result' => false,
                    'msg' => 'ERROR-CODE:#DIGITALPATTAP0140, SOME ERROR OCCURRED, for Case NO .' . $case_no . '. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no' => $case_no
                ];
            }
            // *********************
            //checking west village
            if (trim($chitha_basic_detail->dag_w_desc) == "" || $chitha_basic_detail->dag_w_desc == null) {
                log_message('error', '#DIGITALPATTAP0040, dag_w_desc not found in chitha_basic for case_no ' . $case_no);
                return [
                    'result' => false,
                    'msg' => 'ERROR-CODE:#DIGITALPATTAP0040, SOME ERROR OCCURRED, for Case NO .' . $case_no . '. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no' => $case_no
                ];
            }

            $chitha_basic_detail->dag_w_desc = $this->digitalPattaDagDetailsModel->getVillagenameFromLocation($dist_code,
                $subdiv_code, $cir_code, $mouza_pargona_code,
                $lot_no, $vill_townprt_code);
            if ($chitha_basic_detail->dag_w_desc == "NOT-FOUND") {
                log_message('error', '#DIGITALPATTAP0141, dag_w_desc not found in location for case_no ' . $case_no);
                return [
                    'result' => false,
                    'msg' => 'ERROR-CODE:#DIGITALPATTAP0141, SOME ERROR OCCURRED, for Case NO .' . $case_no . '. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no' => $case_no
                ];
            }

            //checking north dag
            if (trim($chitha_basic_detail->dag_n_dag_no) == "" || $chitha_basic_detail->dag_n_dag_no == null) {
                log_message('error', '#DIGITALPATTAP0041, dag_n_dag_no not found in chitha_basic for case_no ' . $case_no);
                return [
                    'result' => false,
                    'msg' => 'ERROR-CODE:#DIGITALPATTAP0041, SOME ERROR OCCURRED, for Case NO .' . $case_no . '. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no' => $case_no
                ];
            }

            //checking south dag
            if (trim($chitha_basic_detail->dag_s_dag_no) == "" || $chitha_basic_detail->dag_s_dag_no == null) {
                log_message('error', '#DIGITALPATTAP0042, dag_s_dag_no not found in chitha_basic for case_no ' . $case_no);
                return [
                    'result' => false,
                    'msg' => 'ERROR-CODE:#DIGITALPATTAP0042, SOME ERROR OCCURRED, for Case NO .' . $case_no . '. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no' => $case_no
                ];
            }

            //checking west dag
            if (trim($chitha_basic_detail->dag_w_dag_no) == "" || $chitha_basic_detail->dag_w_dag_no == null) {
                log_message('error', '#DIGITALPATTAP0043, dag_w_dag_no not found in chitha_basic for case_no ' . $case_no);
                return [
                    'result' => false,
                    'msg' => 'ERROR-CODE:#DIGITALPATTAP0043, SOME ERROR OCCURRED, for Case NO .' . $case_no . '. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no' => $case_no
                ];
            }

            //checking east dag
            if (trim($chitha_basic_detail->dag_e_dag_no) == "" || $chitha_basic_detail->dag_e_dag_no == null) {
                log_message('error', '#DIGITALPATTAP0044, dag_e_dag_no not found in chitha_basic for case_no ' . $case_no);
                return [
                    'result' => false,
                    'msg' => 'ERROR-CODE:#DIGITALPATTAP0044, SOME ERROR OCCURRED, for Case NO .' . $case_no . '. PLEASE CONTACT PORTAL ADMINISTRATOR..!',
                    'responseType' => 3,
                    'case_no' => $case_no
                ];
            }

        }


        //geting longitude and latitude details from application_no
        $geo_co_ordinate_details = $this->digitalPattaLocationModel->getGeoCordinatesFromAppNo($applno);
        if($geo_co_ordinate_details !="No Data Found")
        {
            $geo_co_ordinates = $geo_co_ordinate_details;
        }
        else
        {
            $geo_co_ordinates = null;
            log_message('error', '#DIGITALPATTAP0045, supportive_document_mobile details not found for the case no  '. $case_no);
            return [
                'result' => false,
                'msg' => 'ERROR-CODE:#DIGITALPATTAP0045, geo co-ordinate details not found for Case NO .'.$case_no.'. PLEASE CONTACT ADMINISTRATOR..!',
                'responseType' => 3,
                'case_no' => $case_no
            ];
        }

        $locationCode = $dist_code.$subdiv_code.$cir_code.$mouza_pargona_code.$lot_no.$vill_townprt_code;

        return [
            "result"                         => true,
            'responseType'                   => 2,
            "errors"                         => $error_msgs,
            "settlement_applicant"           => $settlement_applicant_data,
            "settlement_basic_details"       => $settlement_basic_details,
            "applicant_data"                 => $applicant_data,
            "chitha_pattadar_applicant_data" => $chitha_pattadar_applicant_data,
            "chitha_settlement_allotee"      => $allotee_details,
            "chitha_basic"                   => $chitha_basic,
            "joint_applicant_data"           => $joint_applicant_data,
            "family_details"                 => $family_details,
            "co_ordinates"                   => $geo_co_ordinates,
            "location_code"                  => $locationCode,
            "propertyDetails"                => $propertyDetails,
        ];

    }

    //method to insert all the digital patta information in a table
    public function insertAllDigitalPattaData($application_no,$rtps_no,$patta_info,$dhar_case_no)
    {
        $query1  = $this->db->query("select distinct dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,uuid,service_code from settlement_basic where applid =?",array($application_no));
        $result1 = $query1->row();
        $insert_data = array(
            'application_no'     => $application_no,
            'case_no'            => $dhar_case_no,
            'rtps_ref_no'        => $rtps_no,
            'dist_code'          => trim($result1->dist_code),
            'subdiv_code'        => trim($result1->subdiv_code),
            'cir_code'           => trim($result1->cir_code),
            'mouza_pargona_code' => trim($result1->mouza_pargona_code),
            'lot_no'             => trim($result1->lot_no),
            'vill_townprt_code'  => trim($result1->vill_townprt_code),
            'uuid'               => trim($result1->uuid),
            'service_code'       => trim($result1->service_code),
            'created_at'         => date('Y-m-d'),
            'modified_at'        => null,
            'status'             => 'P',
            'all_data_json'      => json_encode($patta_info),
            'user_data'          => json_encode($this->session->all_userdata()),
        );
        $tstatus1 = $this->db->insert('property_card_all_data', $insert_data);
        if ($tstatus1!= 1)
        {
            $this->db->trans_rollback();
            log_message("error", "#EKCOF002, Error in insert on digital_patta_all_data table with query- ". $this->db->last_query());
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occurred, Error-Code : #EKCOF002'];
        }
        else
        {
            //$this->db->trans_commit();
            return ['result' => 'SUCCESS', 'msg' => 'INSERTED SUCCESSFULLYY'];
        }

    }


    //method to insert path and other details of digital patta
    public function insertDigitalPattaDetails($digital_patta_insert_details)
    {
        $insert_data = $this->db->insert('digital_patta',$digital_patta_insert_details);
        if($insert_data != 1)
        {
            return['result' => 'N', 'msg'=> "Data not inserted Properly"] ;
        }
        else
        {
            return ['result'=>'Y' , 'msg'=> "Data Inserted" ];
        }

    }


    // check in Bhunaksha
    public function checkBhunakshaDetails($dist_code,$caseNo,$dagNoNew,$dagNoOld)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('case_no', $caseNo)
            ->where('new_dag_no', $dagNoNew)
            ->where('dag_no', $dagNoOld)
            ->where('status', 2)
            ->where_in('property_status', [1,2])
            ->get('bhunaksha_svamitva_cases')
            ->num_rows();
    }


    // check in Bhunaksha
    public function checkBhunakshaDetailsPrint($dist_code,$caseNo,$dagNoNew,$dagNoOld)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('case_no', $caseNo)
            ->where('new_dag_no', $dagNoNew)
            ->where('dag_no', $dagNoOld)
            ->where('property_status', 3)
            ->get('bhunaksha_svamitva_cases')
            ->num_rows();
    }


    // check Property details
    public function checkPropertyDetails($caseNo,$dagNoNew,$dagNoOld)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where('new_dag_no', $dagNoNew)
            ->where('old_dag_no', $dagNoOld)
            ->get('property_details')
            ->num_rows();
    }


    // get Property details
    public function getPropertyDetails($caseNo,$dagNoNew,$dagNoOld)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where('new_dag_no', $dagNoNew)
            ->where('old_dag_no', $dagNoOld)
            ->get('property_details')
            ->result();
    }



    // check in Bhunaksha for Final update
    public function checkBhunakshaSvamitvaCase($dist_code,$caseNo)
    {
        return $this->db->select('*')
            ->where('dist_code', $dist_code)
            ->where('case_no', $caseNo)
            ->where("NOT EXISTS (
                SELECT 1 
                FROM bhunaksha_svamitva_cases bns
                WHERE bns.case_no = bhunaksha_svamitva_cases.case_no
                  AND bns.status <> 2
            )", NULL, FALSE)
            ->where("NOT EXISTS (
                SELECT 1 
                FROM bhunaksha_svamitva_cases bns
                WHERE bns.case_no = bhunaksha_svamitva_cases.case_no
                  AND bns.property_status NOT IN (1,2)
            )", NULL, FALSE)
            ->get('bhunaksha_svamitva_cases')
            ->num_rows();
    }








    //method to update settlement basic table after digital patta is delivered
    public function updateSettlement_basic_and_digital_patta_all_data($case_no,$digital_patta_path)
    {
        $update_data = array(
            'date_update' => date('Y-m-d h:i:s'),
            'digital_patta_offered' => '1',
        );
        $this->db->where('case_no', $case_no);
        $this->db->where_in('service_code', NC_DIGITAL_PATTA_SERVICE_CODE_ALLOW);
        $this->db->update('settlement_basic', $update_data);
        if($this->db->affected_rows() != 1)
        {
            $this->db->trans_rollback();
            log_message("error", "#DIGITA_PATTA_SETTLEMENT_BASIC1, Error in update, table 'settlement_basic ' with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occurred, Error-Code : #DIGITA_PATTA_SETTLEMENT_BASIC1'];
        }
        $updateDigitalPattaData = array(
            'digital_patta_path' => $digital_patta_path,
            'status' => 'A',
        );
        $this->db->where('case_no', $case_no);
        $this->db->update('property_card_all_data', $updateDigitalPattaData);
        if($this->db->affected_rows() != 1)
        {
            $this->db->trans_rollback();
            log_message("error", "#DIGITA_PATTA_SETTLEMENT_BASIC3, Error in update, table 'all_digital_Patta_data ' with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => '  Some error occurred, Error-Code : #DIGITA_PATTA_SETTLEMENT_BASIC3'];
        }
        else
        {
            log_message("error", "#DIGITA_PATTA_SETTLEMENT_BASIC2, Settlement basic and digital_patta_all_data updated successfully". json_encode($this->db->last_query()));
            return['result' => 'SUCCESS', 'msg' => 'Data updated successfully'];
        }

    }


    public function checkPartialPaymentStatusInBasundhara($application_no)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => CHECK_SETTLEMENT_MB2_PARTIAL_PAYMENT,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'application_no' => $application_no,
            ),
        ));
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if($httpcode == 200){
            //return "curl successfull";
            $response_obj = json_decode($response);
            if($response_obj->result == "Y"){
                return ['result' => 'SUCCESS', 'msg' => 'Partial payment fully completed'];
            }else{
                log_message("error", "#DIGIPPY001, Curl Error(Y) In Api ".CHECK_SETTLEMENT_MB2_PARTIAL_PAYMENT);
                return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured , Error-Code : #DIGIPPY001'];
            }
        }else{
            log_message("error", "#DIGIPPY002, Curl Error(200) In Api ".CHECK_SETTLEMENT_MB2_PARTIAL_PAYMENT);
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #DIGIPPY002'];
        }
    }


    public function checkPartialPayment($case_no)
    {
        $sql = $this->db->query("select * from settlement_premium where case_no=? and is_final=? and due_amount > paid_amount",array($case_no,1));
        if($sql->num_rows() <= 0){
            return 'N';
        }else{
            return 'Y';
        }
    }


    public function checkChithaUpdateStatusForPartialPayment($case_no)
    {
        $sql = $this->db->query("SELECT DISTINCT(sp.case_no) FROM settlement_premium sp JOIN chitha_rmk_ordbasic crb ON sp.case_no = crb.ord_no 
                                join settlement_basic sb on sb.case_no = crb.case_no join settlement_emi_history seh on seh.case_no = crb.ord_no 
                                WHERE seh.chitha_update_status =? and sb.order_passed is not null and sp.due_amount > sp.paid_amount AND sp.grn_no is not null 
                                and sp.is_final = ? AND crb.partial_pay_status = ? and sp.case_no = ?",array(5,1,1,$case_no));
        if($sql->num_rows() <=0){
            return 'N';
        }else{
            return 'Y';
        }
    }


    public function insertAllDigitalPattaDataWithoutPdf($application_no,$rtps_no,$patta_info,$dhar_case_no,$dist_code)
    {
        $query1   = $this->db->query("select distinct dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,uuid,service_code from settlement_basic where applid =?",array($application_no));
        $result1  = $query1->row();
        $distCode = trim($dist_code);

        $this->db->trans_begin();
        $insert_data = array(
            'application_no'        => trim($application_no),
            'case_no'               => trim($dhar_case_no),
            'rtps_ref_no'           => trim($rtps_no),
            'dist_code'             => trim($result1->dist_code),
            'subdiv_code'           => trim($result1->subdiv_code),
            'cir_code'              => trim($result1->cir_code),
            'mouza_pargona_code'    => trim($result1->mouza_pargona_code),
            'lot_no'                => trim($result1->lot_no),
            'vill_townprt_code'     => trim($result1->vill_townprt_code),
            'uuid'                  => trim($result1->uuid),
            'service_code'          => trim($result1->service_code),
            'created_at'            => date('Y-m-d'),
            'modified_at'           => null,
            'status'                => 'P',
            'all_data_json'         => json_encode($patta_info),
            'user_data'             => json_encode($this->session->all_userdata()),
        );
        $tstatus1 = $this->db->insert('property_card_all_data', $insert_data);
        if ($tstatus1!= 1)
        {
            $this->db->trans_rollback();
            log_message("error", "#EKCOF002, Error in insert on digital_patta_all_data table with query- ". $this->db->last_query());
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKCOF002'];
        }
        else
        {
            $update_data = array(
                'date_update' => date('Y-m-d h:i:s'),
                'digital_patta_offered' => '1',
            );
            $this->db->where('case_no', $dhar_case_no);
            $this->db->where('dist_code', $distCode);
            $this->db->where_in('service_code', NC_DIGITAL_PATTA_SERVICE_CODE_ALLOW);
            $this->db->update('settlement_basic', $update_data);
            if($this->db->affected_rows() != 1)
            {
                $this->db->trans_rollback();
                log_message("error", "#DIGITA_PATTA_SETTLEMENT_BASIC1, Error in update, table 'settlement_basic ' with query- ". json_encode($this->db->last_query()));
                return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #DIGITA_PATTA_SETTLEMENT_BASIC1'];
            }
            else
            {

                // update bhunaksha_svamitva_cases table
                $update_bhu = array(
                    'property_status' => 3,
                );
                $this->db->where('case_no', $dhar_case_no);
                $this->db->where('dist_code', $distCode);
                $this->db->update('bhunaksha_svamitva_cases', $update_bhu);
                if($this->db->affected_rows() == 0)
                {
                    $this->db->trans_rollback();
                    log_message("error", "#DIGITA_PATTA_SETTLEMENT_BHUNAKSHA, Error in update, table 'bhunaksha_svamitva_cases ' with query- ". json_encode($this->db->last_query()));
                    return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #DIGITA_PATTA_SETTLEMENT_BHUNAKSHA'];
                }
                else
                {
                    $this->db->trans_commit();
                    return ['result' => 'SUCCESS', 'msg' => 'INSERTED SUCCESSFULLYY'];
                }
            }
        }
    }


    public function viewAllCasesDigitalPatta($dist_code,$start, $length, $order)
    {
        $repDB = $this->DataBaseSwitchModel->dharReplDbSwitch($dist_code);
        $searchByCol_0 = strtoupper($this->input->post('columns')[1]['search']['value']);
        if(!empty($searchByCol_0)){
            $repDB->where('sb.case_no like \'%'.$searchByCol_0.'%\'');

        }
        $searchByCol_1 = strtoupper($this->input->post('columns')[2]['search']['value']);
        if(!empty($searchByCol_1)){
            $repDB->where('sb.applid like \'%'.$searchByCol_1.'%\'');

        }
        $col = 0;
        $dir = "";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        if ($order != null) {
            $repDB->order_by($order, $dir);
        }

        $repDB->distinct('sb.case_no');
        $repDB->select('sb.*');
        $repDB->from('settlement_basic sb');
        $repDB->where('sb.dist_code', $dist_code);
        $repDB->where_in('sb.service_code', NC_DIGITAL_PATTA_SERVICE_CODE_ALLOW);
        $repDB->where('sb.chitha_processing_details',2);
        $repDB->where('sb.order_passed','Y');
        $repDB->where('sb.co_chitha_corrected_yn','Y');
        $repDB->where('sb.digital_patta_offered','1');
        $repDB->limit($length, $start);
        $query = $repDB->get();

        if ($query->num_rows() > 0) {
            $data['data_results'] = $query->result();
            $repDB->distinct('sb.case_no');
            $repDB->select('sb.*');
            $repDB->from('settlement_basic sb');
            $repDB->where('sb.dist_code', $dist_code);
            $repDB->where_in('sb.service_code', NC_DIGITAL_PATTA_SERVICE_CODE_ALLOW);
            $repDB->where('sb.chitha_processing_details',2);
            $repDB->where('sb.order_passed','Y');
            $repDB->where('sb.co_chitha_corrected_yn','Y');
            $repDB->where('sb.digital_patta_offered','1');
            $data['total_records'] = $repDB->count_all_results();
            return $data;
        }
    }




    //method to get the name of issuing authority nam efrom dharitree database
    public function getIssuingAuthNameNc()
    {
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $query = $this->db->query("select * from loginuser_table where dist_code=? and subdiv_code='00' and cir_code='00' and user_map='y' and user_code=?",array($dist_code,$user_code));
        $use_code = $query->row()->user_code;
        $query2 = $this->db->query("Select * from users where user_code =? and dist_code=? and subdiv_code='00' and cir_code='00'",array($use_code,$dist_code));
        $user_name = $query2->row()->username;
        return $user_name;
    }






    public function viewAllCasesInCoLoginDigitalPatta($start, $length, $order,$dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code)
    {
        $repDB = $this->DataBaseSwitchModel->dharReplDbSwitch($dist_code);
        $searchByCol_0 = strtoupper($this->input->post('columns')[1]['search']['value']);
        if(!empty($searchByCol_0)){
            $repDB->where('sb.case_no like \'%'.$searchByCol_0.'%\'');

        }
        $searchByCol_1 = strtoupper($this->input->post('columns')[2]['search']['value']);
        if(!empty($searchByCol_1)){
            $repDB->where('sb.applid like \'%'.$searchByCol_1.'%\'');

        }
        $col = 0;
        $dir = "";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        if ($order != null) {
            $repDB->order_by($order, $dir);
        }

        $repDB->distinct('sb.case_no');
        $repDB->select('sb.*');
        $repDB->from('settlement_basic sb');
        $repDB->where_in('sb.service_code', NC_DIGITAL_PATTA_SERVICE_CODE_ALLOW);
        $repDB->where('sb.chitha_processing_details',2);
        $repDB->where('sb.dist_code',$dist_code);
        $repDB->where('sb.subdiv_code',$subdiv_code);
        $repDB->where('sb.cir_code',$cir_code);
        if (!empty($mouza_pargona_code)) {
            $repDB->where('sb.mouza_pargona_code', $mouza_pargona_code);
        }
        if (!empty($lot_no)) {
            $repDB->where('sb.lot_no', $lot_no);
        }
        if (!empty($vill_townprt_code)) {
            $repDB->where('sb.vill_townprt_code', $vill_townprt_code);
        }
        $repDB->where('sb.order_passed','Y');
        $repDB->where('sb.digital_patta_offered','1');
        $repDB->limit($length, $start);
        $query = $repDB->get();


        if ($query->num_rows() > 0) {
            $data['data_results'] = $query->result();
            $repDB->distinct('sb.case_no');
            $repDB->select('sb.*');
            $repDB->from('settlement_basic sb');
            $repDB->where_in('sb.service_code', NC_DIGITAL_PATTA_SERVICE_CODE_ALLOW);
            $repDB->where('sb.chitha_processing_details',2);
            $repDB->where('sb.dist_code',$dist_code);
            $repDB->where('sb.subdiv_code',$subdiv_code);
            $repDB->where('sb.cir_code',$cir_code);
            if (!empty($mouza_pargona_code)) {
                $repDB->where('sb.mouza_pargona_code', $mouza_pargona_code);
            }
            if (!empty($lot_no)) {
                $repDB->where('sb.lot_no', $lot_no);
            }
            if (!empty($vill_townprt_code)) {
                $repDB->where('sb.vill_townprt_code', $vill_townprt_code);
            }
            $repDB->where('sb.order_passed','Y');
            $repDB->where('sb.co_chitha_corrected_yn','Y');
            $repDB->where('sb.digital_patta_offered','1');
            $data['total_records'] = $repDB->count_all_results();
            return $data;
        }
    }



}