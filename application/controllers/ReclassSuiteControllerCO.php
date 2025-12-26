<?php
class ReclassSuiteControllerCO extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('patta/pattamodel');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->model('basundhara/basundhara3Model');
        //$this->load->model('rtps/rtpsmodel');
        $this->load->model('SettlementModel/SettlementApModel');
        $this->load->model('SettlementModel/SettlementTenantModel');
        $this->load->model('SettlementModel/SettlementCommonModel');
        $this->load->model('SettlementModel/SettlementKhasModel');
        $this->load->model('basundhara3/reclassModel');
        $this->load->model('SettlementModel/SettlementVgrModel');
        $this->load->model('UtilsModel');
        $this->load->model('basundhara/SettlementApiModel');
        //$this->load->model('chitha/ChithaModelMb3');
        $this->dbswitch();


        if(HOLD_All_MB2_CASES_STATUS == 1)
        {
            if(strtotime(HOLD_All_MB2_CASES_DATE) < strtotime(date('Y-m-d H:i:s')))
            {
                $this->session->set_flashdata('message', " Processing of settlement MB 2.0 Cases has been stopped !");
                redirect(base_url() . "index.php/Home/index");
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

    public function convertLiteral($array)
    {
        $index = 0;
        $final_str = '';
        foreach($array as $a)
        {
            if ($index == 0)
                $final_str = "'".$a."'";
            else
                $final_str = $final_str.",'". $a."'";
            $index++;
        }
        return $final_str;
    }

    public function agrAreaLessaValidation()
    {
        return false;
    }

    public function appAreaMoreThanDagA()
    {
        return false;
    }

    public function decodeBase64($encoded_string)
    {
        $file_data = base64_decode($encoded_string);
        $file = finfo_open();
        $mime_type = finfo_buffer($file, $file_data, FILEINFO_MIME_TYPE);
        $file_type = explode('/', $mime_type)[0];
        $extension = explode('/', $mime_type)[1];
        log_message("error", "No error occured" . json_encode($mime_type));
        return $mime_type;
    }

    private function UUID4()
    {
        $bytes = random_bytes(16);
        $bytes[6] = chr(ord($bytes[6]) & 0x0f | 0x40);
        $bytes[8] = chr(ord($bytes[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));
    }

    public function getValidationBypass($service_code)
    {
        if(!$service_code)
        {
            return false;
        }

        foreach(json_decode(VALIDATION_BYPASS) as $cons_reasons)
        {
            if($cons_reasons->SERVICE_CODE == $service_code)
            {
                $validation_bypass_array = ($cons_reasons->REJECTED_CODE);
            }
        }
        return $validation_bypass_array;
    }

    // Reclass application view

    public function FirstProceedingReclass()
    {
        $service_code        = $this->input->get('service');
        $status              = $this->input->get('s');
        $data['select_data'] = $this->reclassModel->locationSelect($service_code, $status);
        $data['_view']       = 'reclass_suite/co/ReclassSuiteFirstProceedingCo';
        $this->load->view('layouts/main', $data);
    }

    public function getLotsFromMouzaCoRS()
    {
        $dist_code          = $this->session->userdata('dist_code');
        $subdiv_code        = $this->session->userdata('subdiv_code');
        $cir_code           = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no             = $this->input->post('lot_no');

        if(!empty($mouza_pargona_code))
        {
            $this->db->select('loc_name, lot_no, vill_townprt_code');
            $this->db->from('location');
            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('cir_code', $cir_code);
            $this->db->where('mouza_pargona_code', $mouza_pargona_code);

            if(!empty($lot_no))
            {
                $this->db->where('lot_no =', $lot_no);
                $this->db->where('vill_townprt_code !=', '00000');
            }
            else
            {
                $this->db->where('lot_no !=', '00');
                $this->db->where('vill_townprt_code', '00000');
            }

            $query = $this->db->get();
            $result = $query->result();

            if(!empty($lot_no))
            {
                echo json_encode([
                    'responseType'    => 2,
                    'lot_details'     => '',
                    'village_details' => $result,
                ]);
            }
            else
            {
                echo json_encode([
                    'responseType'    => 2,
                    'lot_details'     => $result,
                    'village_details' => '',
                ]);
            }
        }
        else
        {
            echo json_encode([
                'responseType'    => 2,
                'lot_details'     => '',
                'village_details' => '',
            ]);
        }
    }

    public function caseListUnderMappingLot()
    {
        $dist_code    = $this->session->userdata('dist_code');
        $subdiv_code  = $this->session->userdata('subdiv_code');
        $cir_code     = $this->session->userdata('cir_code');
        $user_code    = $this->session->userdata('user_code');
        //////////////////MARKING FOR CIRCLE WISE LOT MAPPING===========

        $sql="Select user_code from loginuser_table where dist_code=? and subdiv_code=? and cir_code=? and dis_enb_option='E' and user_code like 'CO%'";

        $data=$this->db->query($sql,array($dist_code,$subdiv_code,$cir_code));

        $lot_array = array();

        if($data->num_rows()> 1)
        {
            $sql1="Select * from user_attached_mapping where dist_code=? and subdiv_code=? and cir_code=? and user_code=? ";
            $data1=$this->db->query($sql1,array($dist_code,$subdiv_code,$cir_code,$user_code));

            foreach ($data1->result() as $key => $value) {
                $lot_array[] = $value->mouza_pargona_code.'_'.$value->lot_no;
            }
            //////////////////
        }
        $lot_string = null;
        if(!empty($lot_array) && $lot_array!=null){
            $lot_string = $this->convertLiteral($lot_array);
        }
        log_message("error","MB: LOT STRING====FOR CIRCLE==D".$dist_code."S".$subdiv_code."C".$cir_code."==".json_encode($lot_string));
        return $lot_string;
    }

    public function pagination()
    {
        if(LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO'){
            $lot_string = $this->caseListUnderMappingLot();
        }

        $s_code             = $this->input->post('service');
        $search_term        = $this->input->post('search_term');
        $remark_cat         = $this->input->post('remark_cat');
        $reverted           = $this->input->post('reverted');
        $user_code          = $this->session->userdata('user_code');
        $payment_status     = $this->input->post('payment_status');

        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no             = $this->input->post('lot_no');
        $nr_cat             = $this->input->post('nr_cat');

        $status             = $this->input->post('status');
        $draw               = intval($this->input->post('draw'));
        $start              = intval($this->input->post('start'));
        $length             = intval($this->input->post('length'));
        $order              = $this->input->post('order');

        $pagination         = $this->input->post('pagination');


        $final_verification_report = $this->input->post('final_verification_report');
        $co_approved               = $this->input->post('co_approved');

        $col = 0;
        $dir = "";
        $search = $this->input->post('search');
        $search = $search['value'];

        $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
        $searchByCol_1 = $this->input->post('columns')[1]['search']['value'];
        $searchByCol_3 = $this->input->post('columns')[3]['search']['value'];

        $is_cat        = $this->input->post('is_category');

        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }

        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'asc';
        }

        $valid_columns = array(
            0 => 'date_entry',
            // 1   => 'applid',
        );

        if (!isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }

        if ($order != null) {
            $this->db->order_by($order, $dir);
        }

        if (!empty($searchByCol_0)) {
            $this->db->like('a.case_no', strtoupper($searchByCol_0));
        }

        if (!empty($searchByCol_1)) {
            $this->db->like('a.applid', strtoupper($searchByCol_1));
        }

        if (!empty($searchByCol_3)) {
            $this->db->like('TO_CHAR(a.date_entry,\'yyyy-mm-dd\')', $searchByCol_3);
        }

        $this->db->limit($length, $start);

        $this->db->where('a.service_code', $s_code);

        if(!empty($remark_cat))
        {  //settlement_ap_lmnote, lm_note
            $this->db->where('b.lm_note', $remark_cat);
        }

        if(!empty($mouza_pargona_code))
        {
            $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
        }

        if(!empty($mouza_pargona_code) && !empty($lot_no))
        {
            $this->db->where('a.lot_no', $lot_no);
        }

        if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat)) {
            $this->db->where('a.vill_townprt_code', $is_cat);
        }

        if (trim($reverted) == 'LM'){
            $this->db->where('a.pending_officer', MB_LOT_MONDOL);
        }
        else if (trim($reverted) == 'ADC'){
            $this->db->where_not_in('a.pending_officer',array(MB_LOT_MONDOL,MB_SUPERVISOR_KANANGU,MB_CIRCLE_OFFICER));
        }
        else {
            $this->db->where_in('a.pending_officer', array(MB_CIRCLE_OFFICER, MB_SUPERVISOR_KANANGU));
        }
        if ($this->session->userdata('user_desig_code') == 'CO'){
            // $this->db->where("(a.co_code = '".$user_code."' or a.co_code is null)");
            if(LOT_BIFURCATE ==1 && empty($mouza_pargona_code) && empty($lot_no)){
                if(isset($lot_string) && $lot_string != null)
                {
                    $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                }
            }
        }
        if ($this->session->userdata('user_desig_code') == 'SK') {
            $this->db->where('b.lm_note', '1');
            $this->db->where('a.from_office', 'LM');
        }
        if(trim($reverted) == 'LM' and $status =='V'){
            $this->db->select("distinct(a.case_no),a.service_code, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, a.chitha_processing_details");
            $this->db->select('(select \'0\') as lm_note');
        } else {
            $this->db->select('distinct(a.case_no), a.service_code, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, b.lm_note, a.chitha_processing_details');
        }

        if (trim($reverted) != 'ADC'){
            $this->db->where('a.status', $status);
        }
        $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
        $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('a.cir_code', $this->session->userdata('cir_code'));

        // $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
        if(trim($reverted) == 'LM' and $status =='V'){
            $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no', 'left');
        }else{
            $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
        }

        if($s_code == 14 && ($status !='R' && $status !='X' && $status !='M' && $status !='N' && $status !='D'))
        {
            if (trim($reverted) != 'ADC'){
                if (($this->session->userdata('user_desig_code') == 'SK' and $status =='W') || trim($reverted) == 'LM' and $status =='V') {

                }

                else{
                    $this->db->where('a.notice_generated_yn', NULL);
                }
            }
        }

        $this->db->from('reclass_suite_basic a');

        if($status == MB_PAYMENT_NOTICE)
        {
            $this->db->join('settlement_premium c', 'a.case_no = c.case_no');
            $this->db->where('c.is_final', 1);

            if(!empty($payment_status))
            {
                if(trim($payment_status) == 'paid')
                {
                    $this->db->where('c.grn_no is not null');
                }
                elseif(trim($payment_status) == 'unpaid')
                {
                    $this->db->where('c.grn_no is null');
                }
            }

            if(!empty($final_verification_report))
            {
                if($final_verification_report == 'Yes')
                {
                    $this->db->where_in('a.chitha_processing_details', array(1,2));
                }
                else if($final_verification_report == 'No')
                {
                    $this->db->where('a.chitha_processing_details', 0);
                }
                elseif(trim($final_verification_report) == 'land_class_issue') {

                    $this->db->where('EXISTS (SELECT 1 FROM settlement_dag_details sd WHERE sd.case_no = a.case_no AND ((sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = \'\' OR sd.new_land_class_agri = \'\')))', NULL, FALSE);
                }
            }

            if(!empty($co_approved))
            {
                if($co_approved == 'Yes')
                {
                    $this->db->where('a.chitha_processing_details', 2);
                }
                else if($co_approved == 'No')
                {
                    $this->db->where_in('a.chitha_processing_details', array(1,0));
                }
            }
        }

        $query = $this->db->get();
        // echo $this->db->last_query();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {

                $revialSql = $this->db->query('select * from settlement_revival_flag where case_no = ? and revival_status = ?', array($rows->case_no, 1));

                if($revialSql->num_rows() > 0)
                {
                    $revival_flg_button = '';
                }
                else
                {
                    $revival_flg_button = '<button type="button" onclick="caseRevivalList(\''.$rows->case_no.'\',\''.$rows->service_code.'\');" class="btn btn-sm btn-warning">Flag for Revival</button>';
                }

                $download_rejected_cases = '<br><a class="mt-2 btn btn-sm btn-dark" target= "RejectedCases" href="'.base_url().'index.php/SettlementCommon/downloadRejectedCases/?service='.$s_code.'">Download Reject Cases</a>';

                if(trim($rows->lm_note) == 1)
                {
                    $lmnoteRemark = 'Recommended';
                }
                else
                {
                    $lmnoteRemark = 'Not Recommended';
                }

                // if ($status == MB_PAYMENT_REQUEST) {
                //     $tenant_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
                //         <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                //         <br>
                //         <a type="button" href="' . base_url() . 'index.php/SettlementTenantCo/generatePaymentNoticeCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                //         Generate Payment Notice</a>';

                //     $tribal_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
                //         <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                //         <br>
                //         <a type="button" href="' . base_url() . 'index.php/SettlementTribalCo/generatePaymentNoticeCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                //         Generate Payment Notice</a>';

                //     $ap_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
                //         <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                //         <br>
                //         <a type="button" href="' . base_url() . 'index.php/SettlementApCo/generatePaymentNoticeCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                //         Generate Payment Notice</a>';

                //     $khas_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
                //         <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                //         <br>
                //         <a type="button" href="' . base_url() . 'index.php/SettlementKhasCo/generatePaymentNoticeCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                //         Payment Notice</a>';

                //     $vgr_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
                //         <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                //         <br>
                //         <a type="button" href="' . base_url() . 'index.php/SettlementVgrCo/generatePaymentNoticeCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                //         Generate Payment Notice</a>';

                //     $tea_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
                //         <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                //         <br>
                //         <a type="button" href="' . base_url() . 'index.php/SettlementTeaCo/generatePaymentNoticeCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                //         Generate Payment Notice</a>';

                // } elseif ($status == MB_PAYMENT_NOTICE) {


                //     if($rows->chitha_processing_details == 1)
                //     {
                //         $lm_chitha_report = 'Yes';
                //     }
                //     elseif($rows->chitha_processing_details == 2)
                //     {
                //         $lm_chitha_report = 'Yes';
                //     }
                //     elseif($rows->chitha_processing_details == 0)
                //     {
                //         $lm_chitha_report = 'No';
                //     }


                //     if($rows->chitha_processing_details == 2)
                //     {
                //         $co_approved_status = 'Yes';
                //     }
                //     elseif($rows->chitha_processing_details == 1)
                //     {
                //         $co_approved_status = 'No';
                //     }
                //     elseif($rows->chitha_processing_details == 0)
                //     {
                //         $co_approved_status = 'No';
                //     }


                //     $tenant_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                //         <br>

                //         <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="' . base_url() . 'index.php/SettlementCommon/printPaymentNotice?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Payment Notice</a>

                //         <br>
                //         <a type="button" href="' . base_url() . 'index.php/SettlementMbCo/confirmPaymentCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                //         write report</a>';

                //     $tribal_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>

                //         <br>

                //         <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="' . base_url() . 'index.php/SettlementCommon/printPaymentNotice?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Payment Notice</a>

                //         <br>
                //         <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="https://basundhara.assam.gov.in/rtpsmb/SikritiController/viewSwikritiPatraDharitree?app='.$this->utilityclass->encryptJwtCase($rows->applid).'" class="mt-1 lmreportmut btn-sm btn btn-primary"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Prastavit Patra</a>


                //         <br>
                //         <a type="button" href="' . base_url() . 'index.php/SettlementMbCo/confirmPaymentCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                //         write report</a>';

                //     $ap_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                //         <br>

                //         <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="' . base_url() . 'index.php/SettlementCommon/printPaymentNotice?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Payment Notice</a>

                //         <br>
                //         <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="https://basundhara.assam.gov.in/rtpsmb/SikritiController/viewSwikritiPatraDharitree?app='.$this->utilityclass->encryptJwtCase($rows->applid).'" class="mt-1 lmreportmut btn-sm btn btn-primary"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Prastavit Patra</a>

                //         <br>
                //         <a type="button" href="' . base_url() . 'index.php/SettlementMbCo/confirmPaymentCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                //         write report</a>';

                //     $khas_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>

                //         <br>
                //         <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="' . base_url() . 'index.php/SettlementCommon/printPaymentNotice?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Payment Notice</a>

                //         <br>
                //         <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="https://basundhara.assam.gov.in/rtpsmb/SikritiController/viewSwikritiPatraDharitree?app='.$this->utilityclass->encryptJwtCase($rows->applid).'" class="mt-1 lmreportmut btn-sm btn btn-primary"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Prastavit Patra</a>

                //         <br>
                //         <a type="button" href="' . base_url() . 'index.php/SettlementMbCo/confirmPaymentCo?case=' . $rows->case_no . '" class="mt-1 lmreportmut btn-sm btn btn-primary">
                //         write report</a>';

                //     $vgr_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                //         <br>

                //         <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="' . base_url() . 'index.php/SettlementCommon/printPaymentNotice?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Payment Notice</a>
                //         <br>
                //         <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="https://basundhara.assam.gov.in/rtpsmb/SikritiController/viewSwikritiPatraDharitree?app='.$this->utilityclass->encryptJwtCase($rows->applid).'" class="mt-1 lmreportmut btn-sm btn btn-primary"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Prastavit Patra</a>

                //         <br>
                //         <a type="button" href="' . base_url() . 'index.php/SettlementMbCo/confirmPaymentCo?case=' . $rows->case_no . '" class="mt-1 lmreportmut btn-sm btn btn-primary">
                //         write report</a>';

                //     $tea_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                //         <br>

                //         <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="' . base_url() . 'index.php/SettlementCommon/printPaymentNotice?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Payment Notice</a>

                //         <br>
                //         <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="https://basundhara.assam.gov.in/rtpsmb/SikritiController/viewSwikritiPatraDharitree?app='.$this->utilityclass->encryptJwtCase($rows->applid).'" class="mt-1 lmreportmut btn-sm btn btn-primary"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Prastavit Patra</a>


                //         <br>

                //         <a type="button" href="' . base_url() . 'index.php/SettlementMbCo/confirmPaymentCo?case=' . $rows->case_no . '" class="mt-1 lmreportmut btn-sm btn btn-primary">
                //         write report</a>';
                // } else if ($status == MB_ORDER_FOR_CHITHA_UPDATE) {
                //     $tenant_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                //     View</a>

                //     <a href="' . base_url() . 'index.php/SettlementMbCo/coFinalOrderUpdate?case_no=' . $rows->case_no . '&dist_code=' . $rows->dist_code . '&subdiv_code=' . $rows->subdiv_code . '&cir_code=' . $rows->cir_code . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure you would like to update chitha for this case?\');">Update Chitha</a>

                //     ';
                // }
                // else if (trim($reverted) == 'ADC' or trim($reverted) == 'LM'){
                //     $tenant_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                //     view</a>';
                //     $tribal_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                //     view</a>';
                //     $ap_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                //     view</a>';
                //     $khas_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                //     view</a>';
                //     $vgr_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                //     view</a>';
                //     $tea_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                //     view</a>';


                // }
                // else if($status == MB_DISMISS)
                // {
                //     $tenant_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                //     view</a>'.$revival_flg_button.$download_rejected_cases;
                //     $tribal_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                //     view</a>'.$revival_flg_button.$download_rejected_cases;
                //     $ap_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                //     view</a>'.$revival_flg_button.$download_rejected_cases;
                //     $khas_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                //     view</a>  '.$revival_flg_button.$download_rejected_cases;
                //     $vgr_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                //     view</a> '.$revival_flg_button.$download_rejected_cases;
                //     $tea_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                //     view</a>'.$revival_flg_button.$download_rejected_cases;
                // }
                // else
                // {
                //     $tenant_link = '<a type="button" href="' . base_url() . 'index.php/SettlementTenantCo/settlementTenantCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                //         write report</a>';
                //     $tribal_link = '<a type="button" href="' . base_url() . 'index.php/SettlementTribalCo/settlementTribalCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                //         write report</a>';
                //     $ap_link = '<a type="button" href="' . base_url() . 'index.php/SettlementApCo/settlementApCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                //         write report</a>';
                //     $khas_link = '<a type="button" href="' . base_url() . 'index.php/SettlementKhasCo/settlementKhasCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                //         write report</a>';
                //     $vgr_link = '<a type="button" href="' . base_url() . 'index.php/SettlementVgrCo/settlementVgrCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                //         write report</a>';
                //     $tea_link = '<a type="button" href="' . base_url() . 'index.php/SettlementTeaCo/settlementTeaCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                //         write report</a>';
                // }

                // if($status == MB_PAYMENT_NOTICE)
                // {
                //     $sqlgrn = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ?', array($rows->case_no, 1));

                //     if($sqlgrn->num_rows() <= 0)
                //     {
                //         $grn_status = '<strong class="text-danger">NOT PAID</strong>';
                //     }
                //     else
                //     {
                //         if(isset($sqlgrn->row()->grn_no))
                //         {
                //             if($sqlgrn->row()->grn_no == null || $sqlgrn->row()->grn_no == '')
                //             {
                //                 $grn_status = '<strong class="text-danger">NOT PAID</strong>';
                //             }
                //             else
                //             {
                //                 $grn_status = '<strong class="text-success">PAID</strong>';
                //             }
                //         }
                //         else
                //         {
                //             $grn_status = '<strong class="text-danger">NOT PAID</strong>';
                //         }
                //     }

                //     $json[] = array(
                //         '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                //         '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',

                //         $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),

                //         $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

                //         $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                //         // $nr_status,

                //         // $rows->date_entry,
                //         // date("Y-m-d", strtotime($rows->date_entry)),

                //         // $lmnoteRemark,

                //         $grn_status,
                //         $lm_chitha_report,
                //         $co_approved_status,

                //         (($s_code == SETTLEMENT_TENANT_ID) ? $tenant_link : (($s_code == SETTLEMENT_AP_TRANSFER_ID) ? $ap_link : (($s_code == SETTLEMENT_TRIBAL_COMMUNITY_ID) ? $tribal_link : (($s_code == TEA_SERVICE_CODE) ? $khas_link : (($s_code == SETTLEMENT_PGR_VGR_LAND_ID) ? $vgr_link : (($s_code == SETTLEMENT_SPECIAL_CULTIVATORS_ID) ? $tea_link : '')))))),
                //     );

                // }
                // else

                if ($status == MB_PAYMENT_REQUEST) {
                    $reclass_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
                <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>';

                    // $reclass_pay_link = ' <a type="button" href="' . base_url() . 'index.php/ReclassSuiteControllerCO/generatePaymentNoticeCoReclass?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                    //  Generate Payment Notice</a>';

                    $reclass_pay_link = '<button title="Generate Payment Notice" class="btn btn-info btn-sm gen_payment_notice_btn" onclick="gen_payment_notice_btn(\''.$rows->case_no.'\')">Generate Payment Notice</button>';

                    $button = $reclass_link.$reclass_pay_link;
                }
                else if($status == MB_PAYMENT_NOTICE)
                {


                    $sqlgrn = $this->db->query('select * from reclass_suite_basic where case_no = ? and is_dlc_req = ? and from_office = ? and pending_officer = ? ', array($rows->case_no, 'N',MB_DEPUTY_COMM,MB_CIRCLE_OFFICER));

                    if($sqlgrn->num_rows() > 0)
                    {
                        $grn_status = '<strong class="text-danger">NOT REQUIRED</strong>';

                        $sqlOrder = $this->db->query('select * from reclass_suite_basic where case_no = ? and order_passed = ? and co_chitha_corrected_yn = ? ', array($rows->case_no, 'Y', 'Y'));

                        if($sqlOrder->num_rows() > 0)
                        {
                            $reclass_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>

                        <br><br>
                        <a type="button" class="lmreportmut btn-sm btn btn-danger">Chitha Updated</a>';

                        }

                        else
                        {

                        $reclass_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>

                        <br><br>
                    <a type="button" href="' . base_url() . 'index.php/ReclassSuiteControllerCO/confirmPaymentCoFinal?case=' . enc_param('case_no', $rows->case_no, 600). '" class="lmreportmut btn-sm btn btn-primary">Write Report</a>';
                        }
                    }

                    else
                    {

                    $sqlgrn = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ?', array($rows->case_no, 1));

                    if($sqlgrn->num_rows() <= 0)
                    {
                        $grn_status = '<strong class="text-danger">NOT PAID</strong>';
                    }
                    else
                    {
                        if(isset($sqlgrn->row()->grn_no))
                        {
                            if($sqlgrn->row()->grn_no == null || $sqlgrn->row()->grn_no == '')
                            {
                                $grn_status = '<strong class="text-danger">NOT PAID</strong>';
                            }
                            else
                            {
                                $grn_status = '<strong class="text-success">PAID</strong>';
                            }
                        }
                        else
                        {
                            $grn_status = '<strong class="text-danger">NOT PAID</strong>';
                        }
                    }


                     $sqlOrder = $this->db->query('select * from reclass_suite_basic where case_no = ? and order_passed = ? and co_chitha_corrected_yn = ? ', array($rows->case_no, 'Y', 'Y'));

                        if($sqlOrder->num_rows() > 0)
                        {
                             $reclass_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>

                        <br>
                        <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="' . base_url() . 'index.php/SettlementCommon/printPaymentNotice?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Payment Notice</a>

                        <br><br>
                    <a type="button" class="lmreportmut btn-sm btn btn-danger">Chitha Updated</a>';

                        }

                        else
                        {

                            $reclass_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>

                        <br>
                        <a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="' . base_url() . 'index.php/SettlementCommon/printPaymentNotice?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Payment Notice</a>

                        <br><br>
                    <a type="button" href="' . base_url() . 'index.php/ReclassSuiteControllerCO/confirmPaymentCo?case=' .  enc_param('case_no', $rows->case_no, 600). '" class="lmreportmut btn-sm btn btn-primary">Write Report</a>';
                        }
                    }

                    $button = $reclass_link;
                }
                else{
                    $reclass_link = '<a type="button" href="' . base_url() . 'index.php/ReclassSuiteControllerCO/ReclassSuiteCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">Write Report</a>';
                    $button = $reclass_link;
                }

                if($status == MB_PAYMENT_NOTICE)
                {
                    $json[] = array(
                    '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                    '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',

                    $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),

                    $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    // date("Y-m-d", strtotime($rows->date_entry)),
                    $grn_status,

                    $lmnoteRemark,

                    $button,
                );
                }

                else{

                $json[] = array(
                    '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                    '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',

                    $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),

                    $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    date("Y-m-d", strtotime($rows->date_entry)),
                    // $grn_status,

                    $lmnoteRemark,

                    $button,
                );
                }


            }

            $this->db->where('a.service_code', $s_code);

            if(!empty($remark_cat))
            {  //settlement_ap_lmnote, lm_note
                $this->db->where('b.lm_note', $remark_cat);
            }

            if (trim($reverted) == 'LM'){
                $this->db->where('a.pending_officer', MB_LOT_MONDOL);
            }
            else if (trim($reverted) == 'ADC'){
                $this->db->where_not_in('a.pending_officer',array(MB_LOT_MONDOL,MB_SUPERVISOR_KANANGU,MB_CIRCLE_OFFICER));
            }
            else {
                $this->db->where_in('a.pending_officer', array(MB_CIRCLE_OFFICER, MB_SUPERVISOR_KANANGU));
            }

            if ($this->session->userdata('user_desig_code') == 'CO'){
                // $this->db->where('a.co_code', $user_code);
                // $this->db->where("(a.co_code = '".$user_code."' or a.co_code is null)");
                if(LOT_BIFURCATE ==1 && empty($mouza_pargona_code) && empty($lot_no)){

                    if(isset($lot_string) && $lot_string != null)
                    {
                        $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                    }
                }
            }

            if ($this->session->userdata('user_desig_code') == 'SK') {
                $this->db->where('b.lm_note', '1');
                $this->db->where('a.from_office', 'LM');
            }

            if(!empty($mouza_pargona_code))
            {
                $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
            }

            if(!empty($mouza_pargona_code) && !empty($lot_no))
            {
                $this->db->where('a.lot_no', $lot_no);
            }

            if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat)) {
                $this->db->where('a.vill_townprt_code', $is_cat);
            }


            if(trim($reverted) == 'LM' and $status =='V') {
                $this->db->select('distinct(a.case_no)');
                $this->db->select('(select \'0\') as lm_note');
            } else {
                $this->db->select('distinct(a.case_no)');
            }

            if (trim($reverted) != 'ADC') {
                $this->db->where('a.status', $status);
            }
            $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
            $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
            $this->db->where('a.cir_code', $this->session->userdata('cir_code'));

            // $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
            if(trim($reverted) == 'LM' and $status =='V') {
                $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no', 'left');
            } else {
                $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
            }

            if($s_code == 14 && ($status !='R' && $status !='X' && $status !='M' && $status !='N' && $status !='D'))
            {
                if (trim($reverted) != 'ADC'){
                    if (($this->session->userdata('user_desig_code') == 'SK' and $status =='W') || trim($reverted) == 'LM' and $status =='V') {

                    }
                    else{
                        $this->db->where('a.notice_generated_yn', NULL);
                    }
                }
            }

            if($status == MB_PAYMENT_NOTICE)
            {
                $this->db->join('settlement_premium c', 'a.case_no = c.case_no');
                $this->db->where('c.is_final', 1);

                if(!empty($payment_status))
                {
                    if(trim($payment_status) == 'paid')
                    {
                        $this->db->where('c.grn_no is not null');
                    }
                    elseif(trim($payment_status) == 'unpaid')
                    {
                        $this->db->where('c.grn_no is null');
                    }
                }

                if(!empty($final_verification_report))
                {
                    if($final_verification_report == 'Yes')
                    {
                        $this->db->where_in('a.chitha_processing_details', array(1,2));
                    }
                    else if($final_verification_report == 'No')
                    {
                        $this->db->where('a.chitha_processing_details', 0);
                    }
                    elseif(trim($final_verification_report) == 'land_class_issue')
                    {
                        $this->db->where('EXISTS (SELECT 1 FROM settlement_dag_details sd WHERE sd.case_no = a.case_no AND ((sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = \'\' OR sd.new_land_class_agri = \'\')))', NULL, FALSE);
                    }
                }

                if(!empty($co_approved))
                {
                    if($co_approved == 'Yes')
                    {
                        $this->db->where('a.chitha_processing_details', 2);
                    }
                    else if($co_approved == 'No')
                    {
                        $this->db->where_in('a.chitha_processing_details', array(1,0));
                    }
                }
            }


            // $total_records = $this->db->count_all_results('settlement_basic a');
            $data=$this->db->get('reclass_suite_basic a');
            $total_records = $data->num_rows();
            $response = array(
                'draw'            => $draw,
                'recordsTotal'    => $total_records,
                'recordsFiltered' => $total_records,
                'data'            => $json,
            );

            echo json_encode($response);

        }
        else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }

    public function ReclassSuiteCo()
    {
        $application_no  = $this->input->get('case');
        $user_desig_code = $this->session->userdata('user_desig_code');

        if($user_desig_code == 'SK')
        {
            $this->utilityclass->authCheckCoSk($application_no, 'SK');
            $this->utilityclass->checkUserAuthForCaseForSk($application_no);
        }
        else if ($user_desig_code == 'CO')
        {
            $this->utilityclass->authCheckCoSkReclass($application_no, 'CO');
            $this->utilityclass->checkUserAuthForCaseForCoReclass($application_no);
        }
        else
        {
            $this->session->set_flashdata('message', "#ERR290: error occured! Contact admin...");
            redirect(base_url() . "index.php/home");
            return false;
        }

        $penalty_dags      = $this->reclassModel->getSettlementDagPenalty($application_no);
        $chk_penalty_rate  = $this->reclassModel->getSettlementDagPenaltyRate($application_no);


        if($penalty_dags == 'Y' && $chk_penalty_rate =='N')
        {
            $updateArr = [
                    'co_edit' => null,
                ];
                $this->db->where('case_no', $application_no);
                $this->db->update('reclass_suite_basic', $updateArr);
        }

        $basic             = $this->reclassModel->getSettlementBasic($application_no);
        $applicants_buyers = $this->reclassModel->getAllApplicantBuyers($application_no);
        $applicants_owners = $this->reclassModel->getAllApplicantOwners($application_no);

        $applicants_dag_details = $this->reclassModel->getAllApplicantDagDetails($application_no);

        $lmdata        = [];
        $dags          = $this->reclassModel->getSettlementDag($application_no);
        $lmnotes       = $this->reclassModel->getSettlementTenantLmNote($application_no);
        $proceedings   = $this->reclassModel->getSettlementProceeding($application_no);
        $dhardocuments = $this->reclassModel->getDocuments($application_no);
        $nominee       = $this->reclassModel->getAllNomineeDetail($application_no);
        $deed_applicant= '';//$this->reclassModel->getAllDeedPattadar($application_no);
        $family_tree   = '';//$this->reclassModel->getAllFamilyTree($application_no);

        $existing_pattadar = $this->reclassModel->getAllExistingPattadar($application_no);

        $lmdata['basic']             = $basic;
        $lmdata['nominee']           = $nominee;
        $lmdata['applicants_buyers'] = $applicants_buyers;
        $lmdata['applicants_owners'] = $applicants_owners;

        $lmdata['existing_pattadar'] = $existing_pattadar;
        $lmdata['deed_applicant']    = $deed_applicant;
        $lmdata['family_tree']       = $family_tree;
        $lmdata['applicants_dag_details'] = $applicants_dag_details;

        $lmdata['checkAdditionalProperty'] = '';
        //$this->SettlementCommonModel->activeAdditionalPropertyDetailByCase($application_no)->result();

        // if($basic['is_cum_transfer']=='Y')
        // {
        //     $buyer                  = $this->reclassModel->getAllBuyer($application_no);
        //     $lmdata['buyer']        = $buyer;
        //     $other_land             = $this->reclassModel->getAllOtherLand($application_no);
        //     $lmdata['other_land']   = $other_land;
        // }

        $applid = $this->utilityclass->getApplidFromCaseNoReclass($application_no);

        // foreach($lmdata['applicants_buyers'] as $adhar_photo):
        //     if($adhar_photo->is_applicant == 1):
        //         if (trim($adhar_photo->identity_type) == 'AADHAAR'):
        //             $adhar_photo_link = $adhar_photo->identity_doc_link;
        //             if(!file_exists($adhar_photo_link))
        //             {
        //                 //****Directory Change */
        //                 $parts = explode("uploads/", $adhar_photo_link, 2);
        //                 if (count($parts) > 1) {
        //                     $path = BACKUP_DIR."uploads/" . $parts[1];
        //                 }
        //                 else
        //                 {
        //                     $path = $adhar_photo_link;
        //                 }

        //                 if(!file_exists($path))
        //                 {
        //                     $url = API_LINK_MB2."getApplicantPhoto";
        //                     $arrayData =array(
        //                         'application_no' => $applid,
        //                     );
        //                     //*****API call again for aadhar photo missing */
        //                     $aadhaarPhotoReCall = $this->utilityclass->curlPost($url, $arrayData);

        //                     if($aadhaarPhotoReCall == true)
        //                     {
        //                         $aadhar_path = $adhar_photo_link;
        //                         $aadhaar_file_to_write_base64 = fopen($aadhar_path, "w") or die("Unable to open file!");
        //                         $aadhaar_encoded_file = $aadhaarPhotoReCall;
        //                         fwrite($aadhaar_file_to_write_base64, $aadhaar_encoded_file);
        //                         fclose($aadhaar_file_to_write_base64);
        //                     }
        //                     else
        //                     {
        //                         echo json_encode(array('ERROR885784: API Response fail!'));
        //                         return false;
        //                     }
        //                 }
        //                 else
        //                 {
        //                     $adhar_photo_link = $path;
        //                 }
        //             }
        //             //**********reopening the updated file */
        //             $open_adhar_file = fopen($adhar_photo_link, "r") or die("Unable to open file!");
        //             $read_adhar_file = fread($open_adhar_file, filesize($adhar_photo_link));
        //             fclose($open_adhar_file);
        //             // decoding the base64 encoding file variable
        //             $lmdata['base64_decoded_adhar_file'] = "<img src = data:".$this->decodeBase64($read_adhar_file).";base64,".$read_adhar_file." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
        //         endif;
        //     endif;
        // endforeach;


        $lmdata['dags']          = $dags;
        $lmdata['penalty_dags']  = $penalty_dags;
        $lmdata['lmnotes']       = $lmnotes;
        $lmdata['proceedings']   = $proceedings;
        $lmdata['dhardocuments'] = $dhardocuments;

        // $premium_data = $this->db->query("SELECT * FROM settlement_premium sp where case_no='$application_no' and is_final=1")->result();

        $premium_data = $this->db->query("SELECT sp.*,spa.* FROM settlement_premium sp inner join reclass_dag_details spa on spa.dag_no=sp.dag_no and spa.case_no=sp.case_no where sp.case_no='$application_no' and is_final=1")->result();
        $lmdata['premium_data'] = $premium_data;

        $premium_data_lm = $this->db->query("SELECT * FROM settlement_premium where case_no='$application_no' and user_code like 'M%' and is_final=1")->row();
        $lmdata['premium_data_lm'] = $premium_data_lm;


        $lmdata['premium']     = $this->SettlementCommonModel->getPremium($application_no);
        // $lmdata['reservation'] = $this->SettlementVgrModel->getSettlementReservation($application_no);
        $lmdata['reservation'] = '';
        $lmdata['additional_property'] = $this->reclassModel->getAdditionalProperty($application_no);

        //********check if SDO exist for that area */
        $headQtrCheck = $this->SettlementCommonModel->headquarterCheck($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'));
        if(trim($headQtrCheck) != 'Y'){

            $sdoCheckResult = $this->SettlementCommonModel->userCheckSDO($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'));

            if(trim($sdoCheckResult) == 'y'){
                $lmdata['sdo_user_check'] = trim($sdoCheckResult);
            }
            else
            {
                $lmdata['sdo_user_check'] = 'No SDO created for this location...';
            }
        }
        else
        {
            $lmdata['sdo_user_check'] = 'y';
        }


        $lmdata['chithaArea']   = '';//$checkAreaDetails['chithaArea'];
        $lmdata['reservedArea'] = '';//$checkAreaDetails['reservedArea'];
        $lmdata['areaCheck']    = '';//$checkAreaDetails['areaCheck'];
        $lmdata['appliedDags']  = '';//$checkAreaDetails['appliedDags'];
        $lmdata['lmProcessArea']= '';//$checkAreaDetails['lmProcessArea'];

        // for guardian relation
        $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
        $relation_executation = $this->db->query($query_for_guar_rel);
        $row = $relation_executation->num_rows;
        if ($row != 0) {
            $lmdata['guar_rel'] = $relation_executation->result();
        }

        $lmdata['basic_status'] = '';
//        $lmdata['basic_status'] = $this->SettlementCommonModel->getCurrentBasicStatus($application_no);

        $lmdata['user_desig_code'] = $this->session->userdata('user_desig_code');
        $lmdata['co_name']= $this->SettlementCommonModel->getCoName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);


        $lmdata['deleted_encroacher'] = '';

        //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
        $deletedDags=$this->SettlementCommonModel->getDeletedDags($application_no);
        $deletedData = array();
        foreach($deletedDags as $deleteDag){
            $deletedData[] = json_decode($deleteDag->table_data);
        }
        $lmdata['deleted_dags'] = $deletedData;

        $rejected_data = $this->SettlementCommonModel->getRejectModal(RECLASS_ID);
        if($rejected_data == 'n')
        {
            $lmdata['rejected_list'] = false;
        }
        else
        {
            $lmdata['rejected_list'] = $rejected_data;
        }


        foreach(json_decode(VALIDATION_BYPASS_RECLASS) as $val_bypas)
        {
            if($val_bypas->SERVICE_CODE == RECLASS_ID)
            {
                $const_bypass_arr_code = $val_bypas->REJECTED_CODE;
            }
        }

        $lmdata['validation_bypass'] = 0;

        foreach($lmdata['lmnotes'] as $lm_rr)
        {
            $decoded_r = json_decode($lm_rr->lm_rejected_remarks);

            if($decoded_r){
                foreach($decoded_r as  $lm_rejected_code)
                {
                    if(isset($lm_rejected_code->reject_code))
                    {
                        if(in_array($lm_rejected_code->reject_code, $const_bypass_arr_code)){
                            $lmdata['validation_bypass'] = 1;
                        }
                    }
                    else
                    {
                        if(in_array($lm_rejected_code, $const_bypass_arr_code)){
                            $lmdata['validation_bypass'] = 1;
                        }
                    }
                }
            }
        }

        $lmdata['reject_list_type'] = '';

        foreach($lmnotes as $r_remark)
        {
            $rejected_list_json = json_decode($r_remark->lm_rejected_remarks);

            if($rejected_list_json)
            {
                foreach ($rejected_list_json as $re_list)
                {
                    if(isset($re_list->reject_code))
                    {
                        $r_code = $re_list->reject_code;
                    }
                    else
                    {
                        $r_code = $re_list;
                    }

                    $sql = $this->db->query("select remark_head from reject_master where reject_code = ?", array($r_code));

                    if($sql->row()->remark_head != null)
                    {
                        $lmdata['reject_list_type'] = 'new';
                    }
                    else
                    {
                        $lmdata['reject_list_type'] = 'old';
                    }
                }
            }
        }

        $lmdata['adcUsers'] = $this->UtilsModel->adcSelect($basic['dist_code']);

        $lmdata['_view'] = 'reclass_suite/co/ReclassSuiteCoView';
        $this->load->view('layouts/main', $lmdata);
    }


    public function generateNoticeCo()
    {

        // var_dump($_POST);exit;
        //******disagree and revert to LM */
        if(isset($_POST['co_rejection_disagree']))
        {
            if($_POST['co_rejection_disagree'] == 'co_rejection_disagree')
            {
                $case_no = $this->input->post('case_no');
                $remark_co = 'Re-verify this case';
                $remark_co_type = '3';

                $this->db->trans_begin();

                $updateArr = [
                    'status' => 'R',
                    'co_code' => $this->session->userdata('user_code'),
                    'date_update' => date('Y-m-d h:i:s'),
                    'from_office' => 'CO',
                    'pending_officer' => 'LM',
                    'pending_office' => 'CO',

                ];
                $this->db->where('case_no', $case_no);
                $this->db->update('reclass_suite_basic', $updateArr);

                if ($this->db->affected_rows() == 0) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCO0001: Falied to revert back to LM');
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCO0001: Falied to revert back to LM. Kindly contact system administrator',
                    ];
                    echo json_encode($json);
                    return false;
                }

                //////proceeding start//////
                $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                if ($proceeding_id == null) {
                    $proceeding_id = 1;
                }

                $insertArr = [
                    'case_no' => $case_no,
                    'proceeding_id' => $proceeding_id,
                    'date_of_hearing' => date('Y-m-d h:i:s'),
                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                    'note_type' => $remark_co_type,
                    'note_on_order' => $remark_co,
                    'status' => 'W',
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d h:i:s'),
                    'operation' => 'E',
                    'ip' => $this->utilityclass->get_client_ip(),
                    'office_from' => 'CO',
                    'office_to' => 'LM',
                    'task' => 'Reverted Back to LM',
                ];
                $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
                if ($insertProc != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCO0002: Insertion failed in settlement_proceeding');
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCO0002: Failed to generate notice. Kindly contact System Administrator',
                    ];
                    echo json_encode($json);
                    return false;
                }
                if ($this->db->trans_status() == false)
                {
                    $this->db->trans_rollback();
                    $data = array(
                        'error' => "Error in submitting. Please try Again",
                    );
                    return $data;
                    exit;
                }
                else
                {
                    //////////////POST To basundhara////////////////////
                    $application_no = $this->reclassModel->getReclassBasicCo($case_no)->applid;

                    $rmk='Reverted to LM';
                    $status='M';
                    $task='CO';
                    $pen='LM';
                    $case=$case_no;
                    $rtps_status=$this->SettlementApiModel->postApiBasundharaMb3($application_no,$case,$rmk,$status,$task,$pen);
                    $rtps_status=json_decode($rtps_status);
                    //var_dump($rtps_status);
                    if(trim($rtps_status) != "y")
                    {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error #ERRAPP003211: Revert to LM failed case no # $case_no");
                        redirect(base_url() . "index.php/home");
                    }
                    else
                    {
                        $this->db->trans_commit();
                        $this->session->set_flashdata('message', "Case no # $case_no reverted back to LM");
                        redirect(base_url() . "index.php/home");
                        // redirect(base_url() . 'index.php/SettlementKhasCo/settlementKhasCo?case=' . $case_no);
                    }
                }
            }
        }

        // Revert back to LM stats here
        if (isset($_POST['revert_to_lm']))
        {
            $case_no         = $this->input->post('case_no');
            $remark_co       = $this->input->post('remark_co');
            $remark_co_type  = $this->input->post('remark_co_type');

            $district        = $this->input->post('district');
            $sub_division    = $this->input->post('sub_division');
            $circle          = $this->input->post('circle');
            $lot_no          = $this->input->post('lot_no');
            $mouza           = $this->input->post('mouza');
            $village         = $this->input->post('village');
            $petitioner_name = $this->input->post('petitioner_name');
            $g_name          = $this->input->post('g_name');
            $dag_name        = $this->input->post('dag_name');

            $this->db->trans_begin();

            $updateArr = [
                'status'          => 'R',
                'co_code'         => $this->session->userdata('user_code'),
                'date_update'     => date('Y-m-d h:i:s'),
                'from_office'     => 'CO',
                'pending_officer' => 'LM',
                'pending_office'  => 'CO',
            ];
            $this->db->where('case_no', $case_no);
            $this->db->update('reclass_suite_basic', $updateArr);

            if ($this->db->affected_rows() == 0) {
                $this->db->trans_rollback();
                log_message('error', '#ERRCO0001: Falied to revert back to LM');
                $json = [
                    'responseType' => 3,
                    'message'      => '#ERRCO0001: Falied to revert back to LM. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return false;
            }

            //////proceeding start//////
            $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
            if ($proceeding_id == null) {
                $proceeding_id = 1;
            }

            $insertArr = [
                'case_no'              => $case_no,
                'proceeding_id'        => $proceeding_id,
                'date_of_hearing'      => date('Y-m-d h:i:s'),
                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                'note_type'            => $remark_co_type,
                'note_on_order'        => $remark_co,
                'status'               => 'W',
                'user_code'            => $this->session->userdata('user_code'),
                'date_entry'           => date('Y-m-d h:i:s'),
                'operation'            => 'E',
                'ip'                   => $this->utilityclass->get_client_ip(),
                'office_from'          => 'CO',
                'office_to'            => 'LM',
                'task'                 => 'Reverted Back to LM',
            ];
            $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
            if ($insertProc != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRCO0002: Insertion failed in settlement_proceeding');
                $json = [
                    'responseType' => 3,
                    'message'      => '#ERRCO0002: Failed to generate notice. Kindly contact System Administrator',
                ];
                echo json_encode($json);
                return false;
            }
            if ($this->db->trans_status() == false) {
                $this->db->trans_rollback();
                $data = array(
                    'error' => "Error in submitting. Please try Again",
                );
                return $data;
                exit;
            }
            else
            {
                //////////////POST To basundhara////////////////////
                $application_no = $this->reclassModel->getReclassBasicCo($case_no)->applid;

                $rmk            = 'Reverted to LM';
                $status         = 'M';
                $task           = 'CO';
                $pen            = 'LM';
                $case           = $case_no;
                $rtps_status    = $this->SettlementApiModel->postApiBasundharaMb3($application_no,$case,$rmk,$status,$task,$pen);
                $rtps_status    = json_decode($rtps_status);
                //var_dump($rtps_status);
                if(trim($rtps_status) != "y"){
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error #ERRAPP003211: Revert to LM failed case no # $case_no");
                    redirect(base_url() . "index.php/home");
                }else{
                    $this->db->trans_commit();
                    $this->session->set_flashdata('message', "Case no # $case_no reverted back to LM");
                    redirect(base_url() . "index.php/home");
                }
            }
        }

        if(isset($_POST['sk_forward_co']))
        {
            $case_no = $this->input->post('case_no');
            $remark_co = $this->input->post('remark_co_type');
            $remark_co_text = $this->input->post('remark_co_note');

            $basic_status = $this->reclassModel->getCurrentBasicStatusReclass($case_no);

            if($basic_status == 'X')
            {
                $status = 'X';
            }
            else
            {
                $status = 'W';
            }

            $co_code = $this->input->post('co_code');

            $this->db->trans_begin();

            $updateArr = [
                'status' => $status,
                'date_update' => date('Y-m-d h:i:s'),
                'from_office' => 'SK',
                'pending_officer' => 'CO',
                'pending_office' => 'CO',
                'sk_code' => $this->session->userdata('user_code'),
            ];

            if($status == 'W')
            {
                $updateArr['co_code'] = $this->input->post('co_code');
            }

            $this->db->where('case_no', $case_no);
            $this->db->update('reclass_suite_basic', $updateArr);

            if($this->db->affected_rows() == 0 ){
                $this->db->trans_rollback();
                log_message('error', '#ERRCO003303: Falied to forward to CO');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO003303: Falied to forward to CO. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return false;
            }

            //////proceeding start//////
            $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
            if($proceeding_id==null){
                $proceeding_id=1;
            }

            $insertArr = [
                'case_no' => $case_no,
                'proceeding_id' => $proceeding_id,
                'date_of_hearing' => date('Y-m-d h:i:s'),
                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                'note_type' => $remark_co,
                'note_on_order' => $remark_co_text,
                'status' => $status,
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'SK',
                'office_to' => 'CO',
                'task' => 'Forwarded to CO'
            ];
            $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
            if($insertProc != 1){
                $this->db->trans_rollback();
                log_message('error', '#ERRCO0004: Insertion failed in settlement_proceeding');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO0004: Failed to foward to DC. Kindly contact System Administrator',
                ];
                echo json_encode($json);
                return false;
            }
            if($this->db->trans_status()==FALSE){
                $this->db->trans_rollback();
                $data=array(
                    'error'=>"Error in submitting. Please try Again"
                );
                echo json_encode($data);
                return false;
            }else{

                //////////////POST To basundhara////////////////////
                $application_no = $this->reclassModel->getReclassBasicCo($case_no)->applid;

                $rmk='Forwarded to CO';
                $status='M';
                $task='SK';
                $pen='CO';
                $case=$case_no;
                $rtps_status=$this->SettlementApiModel->postApiBasundharaMb3($application_no,$case,$rmk,$status,$task,$pen);
                $rtps_status=json_decode($rtps_status);
                //var_dump($rtps_status);
                if(trim($rtps_status)!="y"){
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error #ERRAPP1701: Forward to DC failed case no # $case_no");
                    redirect(base_url() . "index.php/home");
                }else{
                    $this->db->trans_commit();
                    $this->session->set_flashdata('message', "Case no # $case_no forwarded to CO");
                    redirect(base_url() . "index.php/home");
                    // redirect(base_url() . 'index.php/SettlementKhasCo/settlementKhasCo?case=' . $case_no);
                }
                // $this->load->view('SettlementView/Co/SettlementApTransferred');
            }
        }

        //forward to DC starts here
        if (isset($_POST['forward_to_dc'])) {
            $case_no = $this->input->post('case_no');
            $remark_co = $this->input->post('remark_co');
            $remark_co_type = $this->input->post('remark_co_type');
            $district = $this->input->post('district');
            $sub_division = $this->input->post('sub_division');

            $adc_code = $this->input->post('adc_code');

            if($adc_code == '' || $adc_code == null)
            {
                log_message('error', '#ERROR98530: ADC selection is required !!!');
                $this->session->set_flashdata('message', "Warning98530: Please select ADC");
                redirect(base_url() . "index.php/home");
            }

            $this->db->trans_begin();


            // new code --- MR

            $sql = $this->db->query("SELECT * FROM settlement_proposal_cases WHERE case_no = ? AND status = ?",
                array($case_no, PRO_CASE_STATUS_REVERTED));
            if($sql->num_rows() > 0)
            {

                // update basic data
                $updateArrBasic = [
                    'co_code' => $this->session->userdata('user_code'),
                    'co_note_yn' => $remark_co_type,
                    'date_update' => date('Y-m-d h:i:s'),
                    'status'          => MB_SEND_TO_SDLAC,
                    'pending_office'  => MB_SDLAC,
                    'pending_officer' => MB_DEPUTY_COMM,
                    'from_office'     => MB_DEPUTY_COMM,
                    'dc_proceeding'   => 1,
                ];
                $this->db->where('case_no', $case_no);
                $this->db->update('settlement_basic', $updateArrBasic);
                if ($this->db->affected_rows() == 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCO00032: Failed to forward to DC');
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCO00032: Failed to forward to DC. Kindly contact system administrator',
                    ];
                    echo json_encode($json);
                    return false;
                }

                // update proposal case details
                $updatePro = [
                    'status' => PRO_CASE_STATUS_PENDING,
                    'co_submit' => 1
                ];
                $this->db->where('case_no', $case_no);
                $this->db->where('status', PRO_CASE_STATUS_REVERTED);
                $this->db->update('settlement_proposal_cases', $updatePro);

                // echo $this->db->last_query();
                // die;

                if ($this->db->affected_rows() == 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCO0003343: Failed to forward to DC');
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCO0003343: Failed to forward to DC. Kindly contact system administrator',
                    ];
                    echo json_encode($json);
                    return false;
                }

                //////proceeding for CO//////
                $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                if ($proceeding_id == null)
                {
                    $proceeding_id = 1;
                }

                $insertArr = [
                    'case_no' => $case_no,
                    'proceeding_id' => $proceeding_id,
                    'date_of_hearing' => date('Y-m-d h:i:s'),
                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                    'note_type' => $remark_co_type,
                    'note_on_order' => $remark_co,
                    'status' => 'W',
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d h:i:s'),
                    'operation' => 'E',
                    'ip' => $this->utilityclass->get_client_ip(),
                    'office_from' => 'CO',
                    'office_to' => 'DC',
                    'task' => 'Forwarded to DC',
                ];
                $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
                if ($insertProc != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCO0004: Insertion failed in settlement_proceeding');
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCO0004: Failed to forward to DC. Kindly contact System Administrator',
                    ];
                    echo json_encode($json);
                    return false;
                }


                //////proceeding for DC//////
                $proceeding_id_dc = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                if ($proceeding_id_dc == null)
                {
                    $proceeding_id_dc = 1;
                }

                $insertArrDc = [
                    'case_no' => $case_no,
                    'proceeding_id' => $proceeding_id_dc,
                    'date_of_hearing' => date('Y-m-d h:i:s'),
                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d h:i:s'),
                    'operation' => 'E',
                    'ip' => $this->utilityclass->get_client_ip(),
                    'status' => MB_SEND_TO_SDLAC,
                    'note_on_order' => 'Send to SDLAC',
                    'office_from' => MB_DEPUTY_COMM,
                    'office_to'   => MB_DEPUTY_COMM,
                    'task' => 'Send to SDLAC'
                ];
                $insertProDC = $this->db->insert('settlement_proceeding', $insertArrDc);
                if ($insertProDC != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCO0004: Insertion failed in settlement_proceeding');
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCO0004: Failed to forward to DC. Kindly contact System Administrator',
                    ];
                    echo json_encode($json);
                    return false;
                }

                if ($this->db->trans_status() == false)
                {
                    $this->db->trans_rollback();
                    $data = array(
                        'error' => "Error in submitting. Please try Again",
                    );
                    echo json_encode($data);
                    return false;
                }
                else
                {
                    //////////////POST To basundhara////////////////////
                    $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;

                    $rmk='Send to SDLAC';
                    $status='M';
                    $task=MB_DEPUTY_COMM;
                    $pen=MB_DEPUTY_COMM;
                    $case=$case_no;
                    $rtps_status=$this->SettlementApiModel->postApiBasundharaMb3($application_no,$case,$rmk,$status,$task,$pen);
                    $rtps_status=json_decode($rtps_status);
                    //var_dump($rtps_status);
                    if(trim($rtps_status)!="y"){
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error #ERRAPP1878: Forward to DC failed case no # $case_no");
                        redirect(base_url() . "index.php/home");
                    }else{
                        $this->db->trans_commit();
                        $this->session->set_flashdata('message', "Case no # $case_no forwarded to DC");
                        redirect(base_url() . "index.php/home");
                        // redirect(base_url() . 'index.php/SettlementKhasCo/settlementKhasCo?case=' . $case_no);
                    }
                    // $this->load->view('SettlementView/Co/SettlementApTransferred');
                }
            }

            // new Code end here ---- MR




            // $applicants_riotee_nok = $this->SettlementKhasModel->getAllApplicantRioteeNok($case_no);
            // if ($applicants_riotee_nok == true) {
            //     foreach ($applicants_riotee_nok as $nok) {

            //         $insertData = [
            //             'dist_code' => $nok->dist_code,
            //             'subdiv_code' => $nok->subdiv_code,
            //             'cir_code' => $nok->cir_code,
            //             'mouza_pargona_code' => $nok->mouza_pargona_code,
            //             'lot_no' => $nok->lot_no,
            //             'vill_townprt_code' => $nok->vill_townprt_code,
            //             'dag_no' => $nok->dag_no,
            //             'tenant_name' => $nok->pdar_name,
            //             'tenants_father' => $nok->pdar_guardian,
            //             'tenants_add1' => 'addr1',
            //             'tenants_add2' => 'addr2',
            //             'type_of_tenant' => '1',
            //             'khatian_no' => $nok->khatian_no,
            //             'user_code' => $this->session->userdata('user_code'),
            //             'date_entry' => date('Y-m-d h:i:s'),
            //             'operation' => 'E',
            //         ];

            //         $insertChithaTenant = $this->db->insert('chitha_tenant', $insertData);
            //         if ($insertChithaTenant != 1) {
            //             $this->db->trans_rollback();
            //             log_message('error', '#ERRCO0045: Insertion failed in chitha_tenant');
            //             $json = [
            //                 'responseType' => 3,
            //                 'message' => '#ERRCO0045: Failed to generate notice. Kindly contact System Administrator',
            //             ];
            //             echo json_encode($json);
            //             return false;
            //         }
            //     }
            // }

            // foward to dc updates

            $get_settlement_basic2 = $this->reclassModel->getReclassBasicCo($case_no);
            $from_office_check = $get_settlement_basic2->from_office;

            $headQtrCheck = $this->SettlementCommonModel->headquarterCheck($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'));


            if(trim($headQtrCheck) == 'Y'){
                $pending_officer = 'ADC';
                $pending_office = 'DC';
            }else{
                $pending_officer = 'ADC';
                $pending_office = 'DC';
            }

            if($get_settlement_basic2->wet_land=='Y')
            {
                $get_reclass_dag = $this->reclassModel->getDagWiseCaseApprovalInfoJDS($case_no);
            }
            else
            {
                $get_reclass_dag = $this->reclassModel->getDagWiseCaseApprovalInfo($case_no);
            }

            //var_dump($get_reclass_dag->approval_by); $this->db->trans_rollback();exit;


            //////proceeding if sk report not submitted//////
            if($from_office_check == 'LM'){

                $proceeding_sk_check = $this->db->query("Select * from settlement_proceeding where case_no='$case_no' and office_from='SK' and office_to='CO'");

                if($proceeding_sk_check->num_rows() <= 0) {

                    $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                    if ($proceeding_id == null) {
                        $proceeding_id = 1;
                    }

                    $insertArr = [
                        'case_no' => $case_no,
                        'proceeding_id' => $proceeding_id,
                        'date_of_hearing' => date('Y-m-d h:i:s'),
                        'next_date_of_hearing' => date('Y-m-d h:i:s'),
                        'note_type' => '',
                        'note_on_order' => 'SK Report not submitted',
                        'status' => 'W',
                        'user_code' => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d h:i:s'),
                        'operation' => 'E',
                        'ip' => $this->utilityclass->get_client_ip(),
                        'office_from' => 'CO',
                        'office_to' => 'CO',
                        'task' => 'SK Report not submitted.',
                    ];
                    $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
                    if ($insertProc != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRCO000433: Insertion failed in settlement_proceeding');
                        $json = [
                            'responseType' => 3,
                            'message' => '#ERRCO000433: Failed to forward to DC. Kindly contact System Administrator',
                        ];
                        echo json_encode($json);
                        return false;
                    }
                }

            }
            //////proceeding if sk report not submitted end//////


            if($get_settlement_basic2->co_partition_enable =='Y')
            {
                $status = 'AN';
            }

            else
            {
                $status = 'W';
            }


            $updateArr = [
                'status' => $status,
                'co_code' => $this->session->userdata('user_code'),
                'co_note_yn' => $remark_co_type,
                'date_update' => date('Y-m-d h:i:s'),
                'from_office' => 'CO',
                'pending_officer' => $pending_officer,
                'pending_office' => $pending_office,
                'approve_by' => $get_reclass_dag->approval_by,
                'adc_code'   => $adc_code,
                'notice_generated_yn' => null,
                'next_date_of_hearing' =>null,
                'note_action_yn' =>null
            ];
            $this->db->where('case_no', $case_no);
            $this->db->update('reclass_suite_basic', $updateArr);

            if ($this->db->affected_rows() == 0) {
                $this->db->trans_rollback();
                log_message('error', '#ERRCO00034343: Failed to forward to DC');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO00034343: Failed to forward to DC. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return false;
            }

            // upload additional file
                  if(isset($_FILES['fileUpload']['name'])){
                      for($i = 0; $i < $fileCount; $i++)
                      {
                          $_FILES['file']['name'] = $_FILES['fileUpload']['name'][$i];
                          $_FILES['file']['type'] = $_FILES['fileUpload']['type'][$i];
                          $_FILES['file']['tmp_name'] = $_FILES['fileUpload']['tmp_name'][$i];
                          $_FILES['file']['error'] = $_FILES['fileUpload']['error'][$i];
                          $_FILES['file']['size'] = $_FILES['fileUpload']['size'][$i];

                          $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
                          $exp  = explode("/",$mime);
                          $onlyExtension  = $exp[1];

                          $fileRename =  $this->UUID4() . '.' . $onlyExtension;

                          $config['upload_path']   = UPLOAD_DIR;
                          $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
                          $config['max_size']  = UPLOAD_MAX_SIZE;;
                          $config['file_name'] = $fileRename;
                          $this->load->library('upload', $config);
                          $this->upload->initialize($config);
                          if ($this->upload->do_upload('file'))
                          {
                              $document= array(
                                  'case_no'   => $case_no,
                                  'file_name' => $_POST['fileText'][$i],
                                  'user_code' => $this->session->userdata('user_code'),
                                  // 'fetch_file_name' => $_FILES['file']['name'],
                                  'fetch_file_name' => $_POST['fileText'][$i],
                                  'file_type'  => $_FILES['file']['type'],
                                  'file_path'  => UPLOAD_DIR . $fileRename,
                                  'date_entry' => date('Y-m-d h:i:s'),
                                  'mut_type'   => RECLASS_ID,
                              );

                              // save data in attachment file
                              $addMoreDocQuery = $this->db->insert('supportive_document',$document);

                              if($addMoreDocQuery != 1)
                              {
                                  $this->db->trans_rollback();
                                  log_message('error', '#ERRADDDOC0001: Insertion failed in supportive document RTPS Case No '.$case_no);

                                  $this->session->set_flashdata('message', "#ERRADDDOC0001: Registration of Settlement failed for case no : ".$case_no);
                                  redirect(base_url() . "index.php/home");
                                  return false;
                              }

                          }
                          else
                          {
                              $this->db->trans_rollback();
                              // todo error show
                              // redirect to respected route with error mgs
                              log_message('error', '#ERRADDDOC0001: Insertion failed in supportive document RTPS Case No '.$case_no);

                              $this->session->set_flashdata('message', "#ERRADDDOC0001: Registration of Settlement failed for case no : ".$case_no);
                              redirect(base_url() . "index.php/home");
                              return false;
                          }
                      }
                  }



            //////proceeding start//////
            $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
            if ($proceeding_id == null) {
                $proceeding_id = 1;
            }

            $insertArr = [
                'case_no' => $case_no,
                'proceeding_id' => $proceeding_id,
                'date_of_hearing' => date('Y-m-d h:i:s'),
                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                'note_type' => $remark_co_type,
                'note_on_order' => $remark_co,
                'status' => 'W',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'CO',
                'office_to' => $pending_officer,
                'task' => 'Forwarded to '.$pending_officer,
            ];
            $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
            if ($insertProc != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRCO0004: Insertion failed in settlement_proceeding');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO0004: Failed to forward to DC. Kindly contact System Administrator',
                ];
                echo json_encode($json);
                return false;
            }


            if ($this->db->trans_status() == false) {
                $this->db->trans_rollback();
                $data = array(
                    'error' => "Error in submitting. Please try Again",
                );
                return $data;
                exit;
            } else {

                //////////////POST To basundhara////////////////////

                $application_no = $this->reclassModel->getReclassBasicCo($case_no)->applid;
                // $this->db->trans_rollback();

                $rmk='Forwarded to '.$pending_officer;
                $status='M';
                $task='CO';
                $pen=$pending_officer;
                $case=$case_no;
                $rtps_status=$this->SettlementApiModel->postApiBasundharaMb3($application_no,$case,$rmk,$status,$task,$pen);
                $rtps_status=json_decode($rtps_status);

                // var_dump($rtps_status);$this->db->trans_rollback();exit;
                if(trim($rtps_status)!="y"){
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error #ERRAPP2076: Forward to DC failed case no # $case_no");
                    redirect(base_url() . "index.php/home");
                }else{
                    $this->db->trans_commit();
                    $this->session->set_flashdata('message', "Case no # $case_no forwarded to ".$pending_officer);
                    redirect(base_url() . "index.php/home");
                    // redirect(base_url() . 'index.php/SettlementKhasCo/settlementKhasCo?case=' . $case_no);
                }
                // $this->load->view('SettlementView/Co/SettlementApTransferred');
            }
        }

        if (isset($_POST['notice_generate_ast'])) {
            $case_no = $this->input->post('case_no');
            $remark_co = $this->input->post('remark_co');
            $remark_co_type = $this->input->post('remark_co_type');
            $district = $this->input->post('district');
            $sub_division = $this->input->post('sub_division');

            $hearingdt = $this->input->post('w3date');

            if($hearingdt==null)
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error_data', "#ERROR0011: Notice Generation failed : " . $case_no);
                $data = array(
                    'error' => "#ERROR0011: Notice Generation failed, Hraing date required : " . $case_no,
                );
                echo json_encode($data);
                return false;
            }



            $this->db->trans_begin();

            $get_settlement_basic2 = $this->reclassModel->getReclassBasicCo($case_no);
            $from_office_check = $get_settlement_basic2->from_office;

            $headQtrCheck = $this->SettlementCommonModel->headquarterCheck($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'));


            if(trim($headQtrCheck) == 'Y'){
                $pending_officer = 'AST';
                $pending_office = 'CO';
            }else{
                $pending_officer = 'AST';
                $pending_office = 'CO';
            }


            //////proceeding if sk report not submitted//////
            // if($from_office_check == 'LM'){

            //     $proceeding_sk_check = $this->db->query("Select * from settlement_proceeding where case_no='$case_no' and office_from='SK' and office_to='CO'");

            //     if($proceeding_sk_check->num_rows() <= 0) {

            //         $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
            //         if ($proceeding_id == null) {
            //             $proceeding_id = 1;
            //         }

            //         $insertArr = [
            //             'case_no' => $case_no,
            //             'proceeding_id' => $proceeding_id,
            //             'date_of_hearing' =>  $hearingdt,
            //             'next_date_of_hearing' =>  $hearingdt,
            //             'note_type' => '',
            //             'note_on_order' => 'SK Report not submitted',
            //             'status' => 'A',
            //             'user_code' => $this->session->userdata('user_code'),
            //             'date_entry' => date('Y-m-d h:i:s'),
            //             'operation' => 'E',
            //             'ip' => $this->utilityclass->get_client_ip(),
            //             'office_from' => 'CO',
            //             'office_to' => 'CO',
            //             'task' => 'SK Report not submitted.',
            //         ];
            //         $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
            //         if ($insertProc != 1) {
            //             $this->db->trans_rollback();
            //             log_message('error', '#ERRCO000433: Insertion failed in settlement_proceeding');
            //             $json = [
            //                 'responseType' => 3,
            //                 'message' => '#ERRCO000433: Failed to forward to DC. Kindly contact System Administrator',
            //             ];
            //             echo json_encode($json);
            //             return false;
            //         }
            //     }

            // }
            //////proceeding if sk report not submitted end//////



            $updateArr = [
                'status' => 'A',
                'next_date_of_hearing' =>  $hearingdt,
                'co_code' => $this->session->userdata('user_code'),
                'co_note_yn' => $remark_co_type,
                'date_update' => date('Y-m-d h:i:s'),
                'from_office' => 'CO',
                'pending_officer' => $pending_officer,
                'pending_office' => $pending_office,
            ];
            $this->db->where('case_no', $case_no);
            $this->db->update('reclass_suite_basic', $updateArr);

            if ($this->db->affected_rows() == 0) {
                $this->db->trans_rollback();
                log_message('error', '#ERRCO00034343: Failed to forward to AST');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO00034343: Failed to forward to DC. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return false;
            }



            //////proceeding start//////
            $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
            if ($proceeding_id == null) {
                $proceeding_id = 1;
            }

            $insertArr = [
                'case_no' => $case_no,
                'proceeding_id' => $proceeding_id,
                'date_of_hearing' => date('Y-m-d h:i:s'),
                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                'note_type' => $remark_co_type,
                'note_on_order' => $remark_co,
                'status' => 'A',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'CO',
                'office_to' => $pending_officer,
                'task' => 'Forwarded to '.$pending_officer,
            ];
            $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
            if ($insertProc != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRCO0004: Insertion failed in settlement_proceeding');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO0004: Failed to forward to DC. Kindly contact System Administrator',
                ];
                echo json_encode($json);
                return false;
            }
            if ($this->db->trans_status() == false) {
                $this->db->trans_rollback();
                $data = array(
                    'error' => "Error in submitting. Please try Again",
                );
                return $data;
                exit;
            } else {

                //////////////POST To basundhara////////////////////

                $application_no = $this->reclassModel->getReclassBasicCo($case_no)->applid;
                // $this->db->trans_rollback();

                $rmk='Forwarded to '.$pending_officer;
                $status='A';
                $task='CO';
                $pen=$pending_officer;
                $case=$case_no;
                $rtps_status=$this->SettlementApiModel->postApiBasundharaMb3($application_no,$case,$rmk,$status,$task,$pen);
                $rtps_status=json_decode($rtps_status);
                if(trim($rtps_status)!="y"){
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error #ERRAPP2076: Forward to DC failed case no # $case_no");
                    redirect(base_url() . "index.php/home");
                }else{
                    $this->db->trans_commit();
                    $this->session->set_flashdata('message', "Case no # $case_no forwarded to ".$pending_officer."for Notice Generation");
                    redirect(base_url() . "index.php/home");
                    // redirect(base_url() . 'index.php/SettlementKhasCo/settlementKhasCo?case=' . $case_no);
                }
                // $this->load->view('SettlementView/Co/SettlementApTransferred');
            }
        }

        if (isset($_POST['partition_done'])) {
            $case_no = $this->input->post('case_no');
            $remark_co = $this->input->post('remark_co');
            $remark_co_type = $this->input->post('remark_co_type');
            $district = $this->input->post('district');
            $sub_division = $this->input->post('sub_division');

            $this->db->trans_begin();

            $get_settlement_basic2 = $this->reclassModel->getReclassBasicCo($case_no);
            $from_office_check = $get_settlement_basic2->from_office;

            $headQtrCheck = $this->SettlementCommonModel->headquarterCheck($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'));


            if(trim($headQtrCheck) == 'Y'){
                $pending_officer = 'CO';
                $pending_office = 'CO';
            }else{
                $pending_officer = 'CO';
                $pending_office = 'CO';
            }

            $get_settlement_dag= $this->reclassModel->getSettlementDagforPartition($case_no);

            $get_settlement_applicant= $this->reclassModel->getAllApplicantPartitionPartial($case_no);


            $location = [
                'dist_code'=>$get_settlement_basic2->dist_code,
                'subdiv_code'=>$get_settlement_basic2->subdiv_code,
                'cir_code'=>$get_settlement_basic2->cir_code,
                'mouza_pargona_code'=>$get_settlement_basic2->mouza_pargona_code,
                'lot_no'=>$get_settlement_basic2->lot_no,
                'vill_townprt_code'=>$get_settlement_basic2->vill_townprt_code,
                'case_no'=>$get_settlement_basic2->case_no,
            ];

            $dags_list = array();
            $pattadar_list = array();
            foreach($get_settlement_dag as $dag)
            {

                if($dag->is_partition=='Y' && $dag->is_full_partition=='N')
                {
                    $partition = 'P';
                    $dag_area_b = $dag->lm_area_b;
                    $dag_area_k = $dag->lm_area_k;
                    $dag_area_lc = $dag->lm_area_lc;
                    $dag_area_g = 0;
                    $dag_area_kr = 0;
                }

                else if($dag->is_partition=='Y' && $dag->is_full_partition=='Y')
                {
                    $partition = 'F';
                    $dag_area_b = $dag->lm_area_b;
                    $dag_area_k = $dag->lm_area_k;
                    $dag_area_lc = $dag->lm_area_lc;
                    $dag_area_g = 0;
                    $dag_area_kr = 0;
                }

                // else
                // {
                //   $partition = 'F';
                //   $dag_area_b = $dag->dag_area_b;
                //   $dag_area_k = $dag->dag_area_k;
                //   $dag_area_lc = $dag->dag_area_lc;
                //   $dag_area_g = $dag->dag_area_g;
                //   $dag_area_kr = 0;
                // }


                $nested['dag_no'] = $dag->dag_no;
                $nested['patta_no'] = $dag->patta_no;
                $nested['patta_type_code'] = $dag->patta_type_code;
                $nested['reclass_type'] = $partition;
                $nested['dag_area_b'] = $dag_area_b;
                $nested['dag_area_k'] = $dag_area_k;
                $nested['dag_area_lc'] = $dag_area_lc;
                $nested['dag_area_g'] = $dag_area_g;
                $nested['dag_area_kr'] = $dag_area_kr;

                $dags_list[]=$nested;
            }

            if(isset($get_settlement_applicant))
            {

                foreach($get_settlement_applicant as $pattadar)
                {

                    $nested1 = [
                        'pdar_id' => $pattadar->pdar_id,
                        'dag_no' => $pattadar->dag_no,
                        'retain_old_dag' => $pattadar->retain_old_dag == '1' ? true : false
                    ];



                    // Grouping by dag_no
                    $pattadar_list[$pattadar->dag_no][] = $nested1;

                }
            }



            $params = [
                'location' => $location,
                'dags' => $dags_list,
                'pattadar' => $pattadar_list

            ];


            // echo "<pre>";
            // var_dump($params);exit;

            $result = '';//$this->ChithaModelMb3->reclassPartition($params);

            // echo "<pre>";
            // var_dump($result);$this->db->trans_rollback();exit;

            if($result!=false)
            {

                foreach($result as $res)
                {

                    //var_dump($res);$this->db->trans_rollback();exit;

                    $updateDag = [
                        'new_dag' => $res['new_dag'],
                        'new_patta' => $res['new_patta']
                    ];


                    $this->db->where('case_no', $case_no);
                    $this->db->where('dag_no', $res['old_dag']);
                    $this->db->update('reclass_dag_details', $updateDag);

                    if ($this->db->affected_rows() == 0) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRCO0002265: Failed to update Dag');
                        $json = [
                            'responseType' => 3,
                            'message' => '#ERRCO0002265: Failed to update Dag. Kindly contact system administrator',
                        ];
                        echo json_encode($json);
                        return false;
                    }

                }
            }



            $updateArr = [
                'status' => 'W',
                'co_code' => $this->session->userdata('user_code'),
                'date_update' => date('Y-m-d h:i:s'),
                'from_office' => 'CO',
                'pending_officer' => $pending_officer,
                'pending_office' => $pending_office,
                'is_partition_done' => 'Y'
            ];
            $this->db->where('case_no', $case_no);
            $this->db->update('reclass_suite_basic', $updateArr);

            if ($this->db->affected_rows() == 0) {
                $this->db->trans_rollback();
                log_message('error', '#ERRCO00034343: Failed to forward to AST');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO00034343: Failed to forward to DC. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return false;
            }



            //////proceeding start//////
            $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
            if ($proceeding_id == null) {
                $proceeding_id = 1;
            }

            $insertArr = [
                'case_no' => $case_no,
                'proceeding_id' => $proceeding_id,
                'note_type' => $remark_co_type,
                'note_on_order' => $remark_co,
                'status' => 'W',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'CO',
                'office_to' => $pending_officer,
                'task' => 'Forwarded to '.$pending_officer,
            ];
            $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
            if ($insertProc != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRCO0004: Insertion failed in settlement_proceeding');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO0004: Failed to forward to DC. Kindly contact System Administrator',
                ];
                echo json_encode($json);
                return false;
            }

            if ($this->db->trans_status() == false) {
                $this->db->trans_rollback();
                $data = array(
                    'error' => "Error in submitting. Please try Again",
                );
                return $data;
                exit;
            } else {

                //////////////POST To basundhara////////////////////

                $application_no = $this->reclassModel->getReclassBasicCo($case_no)->applid;
                // $this->db->trans_rollback();

                $rmk='Forwarded to '.$pending_officer;
                $status='A';
                $task='CO';
                $pen=$pending_officer;
                $case=$case_no;
                $rtps_status=$this->SettlementApiModel->postApiBasundharaMb3($application_no,$case,$rmk,$status,$task,$pen);
                $rtps_status=json_decode($rtps_status);
                if(trim($rtps_status)!="y"){
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error #ERRAPP2076: Partition done failed case no # $case_no");
                    redirect(base_url() . "index.php/home");
                }else{
                    $this->db->trans_commit();
                    $this->session->set_flashdata('message', "For $case_no Partition done by ".$pending_officer.". The case will be available in CO first proceeding for further processing of Reclassification!!");
                    redirect(base_url() . "index.php/home");
                    // redirect(base_url() . 'index.php/SettlementKhasCo/settlementKhasCo?case=' . $case_no);
                }
                // $this->load->view('SettlementView/Co/SettlementApTransferred');
            }
        }

        if (isset($_POST['forward_to_jds'])) {
            $case_no = $this->input->post('case_no');
            $remark_co = $this->input->post('remark_co');
            $remark_co_type = $this->input->post('remark_co_type');
            $district = $this->input->post('district');
            $sub_division = $this->input->post('sub_division');

            // echo "<pre>";var_dump($_POST);exit;


            $this->db->trans_begin();

            $get_settlement_basic2 = $this->reclassModel->getReclassBasicCo($case_no);
            $from_office_check = $get_settlement_basic2->from_office;

            $headQtrCheck = $this->SettlementCommonModel->headquarterCheck($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'));


            if(trim($headQtrCheck) == 'Y'){
                $pending_officer = 'JDS';
                $pending_office = 'Survey';
            }else{
                $pending_officer = 'JDS';
                $pending_office = 'Survey';
            }

            //$get_reclass_dag = $this->reclassModel->getDagWiseCaseApprovalInfoJDS($case_no);

            if($get_settlement_basic2->jds_revert!=null)
            {
                $checkingPremiumExistSql = $this->db->query("SELECT * FROM supportive_document WHERE case_no = ? and doc_flag = ?", array($case_no,'J'));
                if($checkingPremiumExistSql->num_rows() <= 0)
                {
                $this->db->trans_rollback();
                log_message('error', '#ERRCO0004: Insertion failed in supportive document');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO0004: Failed to forward to JDS. Upload Map data first!!!',
                ];
                echo json_encode($json);
                return false;
                }
            }


            $updateArr = [
                'status' => 'J',
                'co_code' => $this->session->userdata('user_code'),
                'co_note_yn' => $remark_co_type,
                'date_update' => date('Y-m-d h:i:s'),
                'from_office' => 'CO',
                'pending_officer' => $pending_officer,
                'pending_office' => $pending_office,
            ];
            $this->db->where('case_no', $case_no);
            $this->db->update('reclass_suite_basic', $updateArr);

            if ($this->db->affected_rows() == 0) {
                $this->db->trans_rollback();
                log_message('error', '#ERRCO00034343: Failed to forward to JDS');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO00034343: Failed to forward to JDS. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return false;
            }



            //////proceeding start//////
            $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
            if ($proceeding_id == null) {
                $proceeding_id = 1;
            }

            $insertArr = [
                'case_no' => $case_no,
                'proceeding_id' => $proceeding_id,
                'note_type' => $remark_co_type,
                'note_on_order' => $remark_co,
                'status' => 'J',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'CO',
                'office_to' => $pending_officer,
                'task' => 'Forwarded to '.$pending_officer,
            ];
            $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
            if ($insertProc != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRCO0004: Insertion failed in settlement_proceeding');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO0004: Failed to forward to DC. Kindly contact System Administrator',
                ];
                echo json_encode($json);
                return false;
            }
            if ($this->db->trans_status() == false) {
                $this->db->trans_rollback();
                $data = array(
                    'error' => "Error in submitting. Please try Again",
                );
                return $data;
                exit;
            } else {

                //////////////POST To basundhara////////////////////

                $application_no = $this->reclassModel->getReclassBasicCo($case_no)->applid;
                // $this->db->trans_rollback();

                $rmk='Forwarded to '.$pending_officer;
                $status='J';
                $task='CO';
                $pen=$pending_officer;
                $case=$case_no;
                $rtps_status=$this->SettlementApiModel->postApiBasundharaMb3($application_no,$case,$rmk,$status,$task,$pen);
                $rtps_status=json_decode($rtps_status);
                if(trim($rtps_status)!="y"){
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error #ERRAPP2076: Forward to JDS failed case no # $case_no");
                    redirect(base_url() . "index.php/home");
                }else{
                    $this->db->trans_commit();
                    $this->session->set_flashdata('message', "Case no # $case_no forwarded to ".$pending_officer);
                    redirect(base_url() . "index.php/home");
                    // redirect(base_url() . 'index.php/SettlementKhasCo/settlementKhasCo?case=' . $case_no);
                }
                // $this->load->view('SettlementView/Co/SettlementApTransferred');
            }
        }

    }

    public function reclassTypeSave()
    {

        // var_dump($_POST);exit;
        $case_no = $this->input->post('case_no');
        $recls_update = $this->input->post('recls_update');
        $user_code = $this->session->userdata('user_code');
       


        $this->db->trans_begin();

        $get_settlement_basic2 = $this->reclassModel->getReclassBasicCo($case_no);
        $from_office_check = $get_settlement_basic2->from_office;
        $uuid = $get_settlement_basic2->uuid;


        $district['dags'] = $dags          = $this->reclassModel->getSettlementDag($case_no);
        foreach ($dags as $dagsland)
        {
            if($dagsland->is_penalty == 'Y')
            {
             $rate_section = $this->input->post('reclass_check'.$dagsland->dag_no);
             $rate_section_five = $this->input->post('reclass_five_check'.$dagsland->dag_no);
             $reclass_check_penalty = $this->input->post('reclass_check_penalty'.$dagsland->dag_no);

             if($dagsland->exit_lc_by_lm==1 && $dagsland->prop_lc_cat_id!=2)
             {
             $this->form_validation->set_rules('reclass_check'.$dagsland->dag_no, 'Penalty Type', 'trim|required');
             $this->form_validation->set_rules('reclass_five_check'.$dagsland->dag_no, 'Penalty Type', 'trim|required');
             $this->form_validation->set_rules('reclass_check_penalty'.$dagsland->dag_no, 'Penalty Type', 'trim|required');
             }

             if($dagsland->exit_lc_by_lm==1 && $dagsland->prop_lc_cat_id==2)
             {
                if($dagsland->is_partition=='Y' && $dagsland->is_full_partition=='N')
                {
                    $bigha_part_co = $this->input->post('bigha_part_co'.$dagsland->dag_no);
                    $katha_part_co = $this->input->post('katha_part_co'.$dagsland->dag_no);
                    $lessa_part_co = $this->input->post('lessa_part_co'.$dagsland->dag_no);
                    $ganda_part_co = $this->input->post('ganda_part_co'.$dagsland->dag_no);

                    if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY))))
                    {
                        $total_p_dag_area = ($bigha_part_co * 6400) + ($katha_part_co * 320) + ($lessa_part_co * 20) + $ganda_part_co; //total area
                        $total_p_dag_in_lessa = ($total_p_dag_area/6400);


                        if($total_p_dag_in_lessa>1)
                        {
                            $this->form_validation->set_rules('reclass_check'.$dagsland->dag_no, 'Penalty Type', 'trim|required');
                            $this->form_validation->set_rules('reclass_five_check'.$dagsland->dag_no, 'Penalty Type', 'trim|required');
                        }
                    }
                    else
                    {
                        $total_p_dag_area = ($bigha_part_co * 100) + ($katha_part_co * 20) + $lessa_part_co; //total area
                        $total_p_dag_in_lessa = ($total_p_dag_area/100);

                        if($total_p_dag_in_lessa>1)
                        {
                            $this->form_validation->set_rules('reclass_check'.$dagsland->dag_no, 'Penalty Type', 'trim|required');
                            $this->form_validation->set_rules('reclass_five_check'.$dagsland->dag_no, 'Penalty Type', 'trim|required');
                        }
                    }

                }
             }
            }
        }

        $checkingPremiumExistSql = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ?", array($case_no));
        if($checkingPremiumExistSql->num_rows() > 0)
        {
            $sqlprem = "update settlement_premium set is_final=0  WHERE case_no = '$case_no'";
            $resultprem = $this->db->query($sqlprem);

            if ($this->db->affected_rows() == 0)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRSET000311: Updation failed in settlement_applicant RTPS Case No '.$case_no);
                $data = array(
                    'error'=>"#ERRSET000311: Updation Settlement failed for case no : ".$case_no
                );
                echo json_encode($data);
                return false;
            }
        }

        if($recls_update=='YES')
        {
            $district['dags'] = $dags          = $this->reclassModel->getSettlementDag($case_no);


            $sumMbAmountTotal = 0;
            foreach ($dags as $dagsland)
            {
                $this->form_validation->set_rules('reclass_option_'.$dagsland->dag_no, 'Reclass Type', 'trim|required');

                if ($this->form_validation->run() == false) {
                    $data = array(
                        'error' => "#RECLDAGS00011:" . validation_errors(),
                    );
                    echo json_encode($data);
                    return false;
                }

                $reclass_option = $this->input->post('reclass_option_'.$dagsland->dag_no);

                $dag_area = $this->db->query("SELECT dag_no,dag_revenue, dag_area_b, dag_area_k, dag_area_lc, dag_area_g,dag_area_kr FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($district['dags'][0]->dist_code, $district['dags'][0]->subdiv_code, $district['dags'][0]->cir_code, $district['dags'][0]->mouza_pargona_code, $district['dags'][0]->lot_no, $district['dags'][0]->vill_townprt_code, $dagsland->dag_no))->row();

                //echo "<pre>"; var_dump($dag_area->dag_area_lc);$this->db->trans_rollback();exit;
                $tot_bigha = $dag_area->dag_area_b;
                $tot_katha = $dag_area->dag_area_k;
                $tot_lessa = $dag_area->dag_area_lc;
                $tot_ganda = $dag_area->dag_area_g;

                $prem_rate_section = null;
                $co_penalty = null;
                $reclass_check_penalty_just = null;

                if($reclass_option=="part_yes")
                {
                    $applied_bigha = $this->input->post('bigha_part'.$dagsland->dag_no);
                    $applied_katha = $this->input->post('katha_part'.$dagsland->dag_no);
                    $applied_lessa = $this->input->post('lessa_part'.$dagsland->dag_no);

                    $dist_code = $this->input->post('dist_code');

                    if(in_array($dist_code, json_decode(BARAK_VALLEY)))
                    { // for barak valley
                        $total_dag_area = ($tot_bigha * 6400) + ($tot_katha * 320) + ($tot_lessa * 20) + $tot_ganda;
                        $total_dag_area_in_lessa = ($total_dag_area/6400);

                        $total_p_dag_area = ($applied_bigha * 100) + ($applied_katha * 20) + $applied_lessa; //total area
                        $total_p_dag_in_lessa = ($total_p_dag_area/100);


                        if($total_dag_area_in_lessa == $total_p_dag_in_lessa)
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#PART0013: Insertion failed in reclass_partition_info RTPS Case No '.$case_no);

                            $data = array(
                                'error'=>"#ERROR0012: Registration of Settlement failed for case no : ".$case_no
                            );
                            echo json_encode($data);
                            return false;
                        }

                        if($total_dag_area_in_lessa < $total_p_dag_in_lessa)
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#PART0013: Insertion failed in reclass_partition_info RTPS Case No '.$case_no);

                            $data = array(
                                'error'=>"#ERROR0012: Registration of Settlement failed for case no : ".$case_no
                            );
                            echo json_encode($data);
                            return false;
                        }

                    }

                    else
                    {
                        $total_dag_area = ($tot_bigha * 100) + ($tot_katha * 20) + $tot_lessa; //total area
                        $total_dag_area_in_lessa = ($total_dag_area/100);

                        $total_p_dag_area = ($applied_bigha * 100) + ($applied_katha * 20) + $applied_lessa; //total area
                        $total_p_dag_in_lessa = ($total_p_dag_area/100);

                        if($total_dag_area_in_lessa == $total_p_dag_in_lessa)
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#PART0013: Insertion failed in reclass_partition_info RTPS Case No '.$case_no);

                            $data = array(
                                'error' => "#PART0013: For Partial reclass, Applied area and total area of Dag can not be equal..You can choose Full reclass with Partition for Dag- ".$dagsland->dag_no,
                            );
                            echo json_encode($data);
                            return false;
                        }

                        if($total_dag_area_in_lessa < $total_p_dag_in_lessa)
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#PART0013: Insertion failed in reclass_partition_info RTPS Case No '.$case_no);

                            $data = array(
                                'error' => "#PART0013: For Partial reclass, Applied area can not be more than total area of Dag..You can choose Full reclass with Partition for Dag- ".$dagsland->dag_no,
                            );
                            echo json_encode($data);
                            return false;
                        }
                    }

                    $co_area_b = $applied_bigha;
                    $co_area_k = $applied_katha;
                    $co_area_lc = $applied_lessa;
                    $co_area_g = 0;


                    $is_partion = 'Y';
                    $is_full_partition = 'N';

                    foreach ($_POST['pdar_selected_all'] as $selected)
                    {
                        ///reclass partition//
                        $partition_array_co = [
                            'case_no' => $case_no,
                            'from_office' => 'CO',
                            //'to_office' => $pending_officer,
                            'status' => 'W',
                            'dag_no' => $dagsland->dag_no,
                            'pdar_id' =>$selected,
                            'retain_old_dag'=>'0',
                            'user_code' => $user_code
                        ];

                        $partition_array_co = $this->db->insert('reclass_partition_info', $partition_array_co);
                        if($partition_array_co != 1){
                            $this->db->trans_rollback();
                            log_message('error', '#PART001: Insertion failed in reclass_partition_info RTPS Case No '.$case_no);

                            $data = array(
                                'error'=>"#ERROR0012: Registration of Settlement failed for case no : ".$case_no
                            );
                            echo json_encode($data);
                            return false;
                        }
                    }


                    if (isset($_POST['pdar_selected']))
                    {
                        foreach ($_POST['pdar_selected'] as $selected_pdar)
                        {
                            ///reclass partition//
                            $chkpdar_array_co = [
                                'retain_old_dag'=>'1'
                            ];

                            $this->db->where('case_no', $case_no);
                            $this->db->where('dag_no', $dagsland->dag_no);
                            $this->db->where('pdar_id', $selected_pdar);
                            $this->db->update('reclass_partition_info', $chkpdar_array_co);
                            if($this->db->affected_rows() <= 0)
                            {
                                $this->db->trans_rollback();
                                log_message('error', '#ERROR0012: Updation failed in reclass_partition_info RTPS Case No '.$case_no);
                                $data = array(
                                    'error'=>"#ERROR0012: Registration of Reclassification failed for case no : ".$case_no
                                );
                                echo json_encode($data);
                                return false;
                            }
                        }
                    }

                    //premium calculation//

                }
                else if($reclass_option=="part_no")
                {
                    $is_partion = 'N';
                    $is_full_partition = 'N';

                    $co_area_b = null;
                    $co_area_k = null;
                    $co_area_lc = null;
                    $co_area_g = null;
                }
                else if($reclass_option=="part_full_yes")
                {
                    $is_partion = 'Y';
                    $is_full_partition = 'Y';

                    $co_area_b = $tot_bigha;
                    $co_area_k = $tot_katha;
                    $co_area_lc = $tot_lessa;
                    $co_area_g = $tot_ganda;
                }

                //////////

                $fmddata= [
                    'date_entry' => date('Y-m-d'),
                    'co_is_partition' => $is_partion,
                    'co_is_full_partition' => $is_full_partition,
                    'co_area_b' =>$co_area_b,
                    'co_area_k' =>$co_area_k,
                    'co_area_lc'=>$co_area_lc,
                    'co_area_g' =>$co_area_g
                ];
                $this->db->where('case_no', $case_no);
                $this->db->where('dag_no', $dagsland->dag_no);
                $this->db->update('reclass_dag_details', $fmddata);
                if($this->db->affected_rows() <= 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERROR0012: Updation failed in settlement_dag_details RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERROR0012: Registration of Settlement failed for case no : ".$case_no
                    );
                    echo json_encode($data);
                    return false;
                }

                if($reclass_option=="part_yes")
                {
                    $premiumData = $this->db->query("Select * from settlement_premium where case_no='$case_no' and dag_no ='$dagsland->dag_no' order by pid desc limit 1")->row();
                    $district['premiumData'] = $premiumData;

                    $reclass_dag_data = $this->db->query("Select * from reclass_dag_details where case_no='$case_no' and dag_no ='$dagsland->dag_no'")->row();

                    // var_dump($premiumData->rate);exit;

                    $dist_code = $this->session->userdata('dist_code');
                    if(in_array($dist_code, json_decode(BARAK_VALLEY)))
                    {
                        $dag_area =$this->db->query("SELECT sum(co_area_b*6400+co_area_k*320+co_area_lc*20+co_area_g) as sarea
                  from reclass_dag_details where dag_no = ? and case_no = ?",array($dagsland->dag_no,$case_no))->row();
                    }
                    else
                    {
                        $dag_area =$this->db->query("SELECT sum(co_area_b*100+co_area_k*20+co_area_lc) as sarea
                  from reclass_dag_details where dag_no = ? and case_no = ?",array($dagsland->dag_no,$case_no))->row();
                    }

                    $sum_area = $dag_area->sarea;

                    // var_dump($sum_area);exit;

                    $prem_zonal1 = $this->utilityclass->getZonalValue($dagsland->dist_code,$get_settlement_basic2->uuid,$dagsland->dag_no);
                    // $ratepr = $premiumData->rate;

                    if($premiumData->rate_type==1 && $reclass_dag_data->prop_lc_cat_id==2)
                    {
                        if(in_array($dist_code, json_decode(BARAK_VALLEY)))
                        {
                            if($sum_area<=6400)
                            {
                                $ratepr = 0;
                            }
                            else
                            {
                                 $ratepr = $premiumData->rate;
                            }
                        }
                        else
                        {
                            if($sum_area<=100)
                            {
                                $ratepr = 0;
                            }
                            else
                            {
                                 $ratepr = $premiumData->rate;
                            }
                        }
                    }
                    else
                    {
                        $ratepr = $premiumData->rate;
                    }

                    $sumMbAmountperzonal = ($prem_zonal1 * $ratepr) / 100;


                    $dist_code = $this->session->userdata('dist_code');
                    if(in_array($dist_code, json_decode(BARAK_VALLEY)))
                    {
                        $premium_zonal_per_lessa = $sumMbAmountperzonal / 6400;
                    }
                    else
                    {
                        $premium_zonal_per_lessa = $sumMbAmountperzonal / 100;
                    }

                    $sumMbAmount = $sum_area * $premium_zonal_per_lessa;

                    if($reclass_dag_data->is_penalty == 'Y')
                      {
                        $premium_without_penalty = $sumMbAmount;
                      }

                      else
                      {
                        $premium_without_penalty = null;
                      }



                    if($dagsland->is_penalty=='Y')
                    {

                            if($dagsland->exit_lc_by_lm==1 && $dagsland->prop_lc_cat_id==2)
                            {
                                if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY))))
                                {
                                    $total_p_dag_area = ($bigha_part_co * 6400) + ($katha_part_co * 320) + ($lessa_part_co * 20) + $ganda_part_co; //total area
                                    $total_p_dag_in_lessa = ($total_p_dag_area/6400);

                                }
                                else
                                {
                                    $total_p_dag_area = ($bigha_part_co * 100) + ($katha_part_co * 20) + $lessa_part_co; //total area
                                    $total_p_dag_in_lessa = ($total_p_dag_area/100);

                                }

                                // var_dump($total_p_dag_in_lessa);exit;

                                if($total_p_dag_in_lessa<=1)
                                {
                                    $prem_rate_section = 0;
                                    $co_penalty = 'N';
                                    
                                }

                            else{


                                    $rate_section = $this->input->post('reclass_check'.$dagsland->dag_no);
                                    $rate_section_five = $this->input->post('reclass_five_check'.$dagsland->dag_no);
                                    $reclass_check_penalty = $this->input->post('reclass_check_penalty'.$dagsland->dag_no);

                                    // Normalize nulls to 'NO'
                                    $rate_section = $rate_section ?: 'NO';
                                    $rate_section_five = $rate_section_five ?: 'NO';
                                    $reclass_check_penalty = $reclass_check_penalty ?: 'NO';

                                    $yes_count = 0;
                                    $yes_count += ($rate_section === 'YES') ? 1 : 0;
                                    $yes_count += ($rate_section_five === 'YES') ? 1 : 0;
                                    $yes_count += ($reclass_check_penalty === 'YES') ? 1 : 0;

                                    // Validate logic
                                    if ($yes_count === 0 || $yes_count > 1) {
                                        $this->db->trans_rollback();
                                        log_message('error', '#ERRSETFUL001: Invalid selection combination for RTPS Case No ' . $case_no);
                                        $data = array(
                                            'error' => "#ERRSETFUL001: Select only one option. If no rate sections selected, penalty must be YES for case: " . $case_no
                                        );
                                        echo json_encode($data);
                                        return false;
                                    }

                                    if($rate_section=='YES'){
                                        $prem_rate_section = 2;
                                    }
                                    if($rate_section_five=='YES'){
                                        $prem_rate_section = 5;
                                        $reclass_check_penalty_just = $this->input->post('remark_co_justification'.$dagsland->dag_no);

                                        if ($reclass_check_penalty_just==null) 
                                        {
                                        $this->db->trans_rollback();
                                        log_message('error', '#ERRSETJUST001: Invalid selection combination for RTPS Case No ' . $case_no);
                                        $data = array(
                                            'error' => "#ERRSETJUST001: JUSTIFICATION needed: " . $case_no
                                        );
                                        echo json_encode($data);
                                        return false;
                                        }
                                    }

                                    if($reclass_check_penalty=='YES'){
                                        $prem_rate_section = null;
                                        $co_penalty = 'N';
                                    }
                                }
                            }
                        else
                        {

                            $rate_section = $this->input->post('reclass_check'.$dagsland->dag_no);
                            $rate_section_five = $this->input->post('reclass_five_check'.$dagsland->dag_no);
                            $reclass_check_penalty = $this->input->post('reclass_check_penalty'.$dagsland->dag_no);

                            // Normalize nulls to 'NO'
                            $rate_section = $rate_section ?: 'NO';
                            $rate_section_five = $rate_section_five ?: 'NO';
                            $reclass_check_penalty = $reclass_check_penalty ?: 'NO';

                            $yes_count = 0;
                            $yes_count += ($rate_section === 'YES') ? 1 : 0;
                            $yes_count += ($rate_section_five === 'YES') ? 1 : 0;
                            $yes_count += ($reclass_check_penalty === 'YES') ? 1 : 0;

                            // Validate logic
                            if ($yes_count === 0 || $yes_count > 1) {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRSETFUL001: Invalid selection combination for RTPS Case No ' . $case_no);
                                $data = array(
                                    'error' => "#ERRSETFUL001: Select only one option. If no rate sections selected, penalty must be YES for case: " . $case_no
                                );
                                echo json_encode($data);
                                return false;
                            }

                            if($rate_section=='YES'){
                                $prem_rate_section = 2;
                            }
                            if($rate_section_five=='YES'){
                                $prem_rate_section = 5;
                                $reclass_check_penalty_just = $this->input->post('remark_co_justification'.$dagsland->dag_no);

                                if ($reclass_check_penalty_just==null) 
                                        {
                                        $this->db->trans_rollback();
                                        log_message('error', '#ERRSETJUST002: Invalid selection combination for RTPS Case No ' . $case_no);
                                        $data = array(
                                            'error' => "#ERRSETJUST002: JUSTIFICATION needed: " . $case_no
                                        );
                                        echo json_encode($data);
                                        return false;
                                        }
                            }

                            if($reclass_check_penalty=='YES'){
                                $prem_rate_section = null;
                                $co_penalty = 'N';
                            }
                        }


                        $dag_amount = $sum_area * $premium_zonal_per_lessa;
                        $sumMbAmount = ($prem_rate_section * $dag_amount) + $dag_amount ;
                        $sumMbAmountTotal += ($prem_rate_section * $dag_amount) + $dag_amount;

                        if($prem_rate_section == 5){

                            $insertArr = [
                                'case_no' => $case_no,
                                'proceeding_id' => $proceeding_id,
                                'note_type' => 'JUSTIFICATION',
                                'note_on_order' => 'JUSTIFICATION for 5X penalty for Dag :'.$dagsland->dag_no.'-'.$reclass_check_penalty_just,
                                'status' => 'W',
                                'user_code' => $this->session->userdata('user_code'),
                                'date_entry' => date('Y-m-d h:i:s'),
                                'operation' => 'E',
                                'ip' => $this->utilityclass->get_client_ip(),
                                'office_from' => 'CO',
                                'task'          => 'Penalty Updated',
                            ];
                            $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
                            if ($insertProc != 1)
                            {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRCO0004: Insertion failed in settlement_proceeding');
                                $json = [
                                    'responseType' => 3,
                                    'message' => '#ERRCO0004: Failed to forward to DC. Kindly contact System Administrator',
                                ];
                                echo json_encode($json);
                                return false;
                            }
                            }
                        
                    }

                    else
                    {
                        $sumMbAmount = $sum_area * $premium_zonal_per_lessa;
                        $sumMbAmountTotal += $sum_area * $premium_zonal_per_lessa;
                    }

                    if($reclass_dag_data->is_penalty == 'Y')
                      {
                        $premium_without_penalty = $dag_amount;
                      }

                      else
                      {
                        $premium_without_penalty = null;
                      }



                    $fmd=array(
                        'case_no'=>$case_no,
                        'user_code'=>$this->session->userdata('user_code'),
                        'uuid'=>$get_settlement_basic2->uuid,
                        'dag_no'=>$dagsland->dag_no,
                        'zonal_valuation'=>$premiumData->zonal_valuation,
                        'land_type'=>$premiumData->land_type,
                        'rate_type'=>$premiumData->rate_type,
                        'rate'=>$premiumData->rate,
                        'amount_dag'=>$sumMbAmount,
                        // 'final_amount'=>$sumMbAmountTotal,
                        // 'due_amount'=>$sumMbAmountTotal,
                        'total_lessa'=>$sum_area,
                        //'is_full_pay'=>$this->input->post('paymode'),
                        'is_final'=>1,
                        'date_entry'=>date('Y-m-d h:i:s'),
                        'penalty_rate' => $prem_rate_section,
                        'premium_without_penalty' => $premium_without_penalty

                    );

                    $insPremium = $this->db->insert('settlement_premium', $fmd);

                    if ($insPremium != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRSET000101: Insertion failed in settlement_premium RTPS Case No '.$case_no);
                        $data = array(
                            'error'=>"#ERRSET000101: Registration of Settlement failed for case no : ".$case_no
                        );
                        echo json_encode($data);
                        return false;
                    }
                }


                else
                {
                    $premiumData = $this->db->query("Select * from settlement_premium where case_no='$case_no' and dag_no='$dagsland->dag_no' order by pid desc limit 1")->row();
                    $district['premiumData'] = $premiumData;

                    //var_dump($premiumData);exit;

                    $dist_code = $this->session->userdata('dist_code');
                    if(in_array($dist_code, json_decode(BARAK_VALLEY)))
                    {
                        $dag_area = $this->db->query("SELECT sum(dag_area_b*6400+dag_area_k*320+dag_area_lc*20+dag_area_g) as sarea FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($district['dags'][0]->dist_code, $district['dags'][0]->subdiv_code, $district['dags'][0]->cir_code, $district['dags'][0]->mouza_pargona_code, $district['dags'][0]->lot_no, $district['dags'][0]->vill_townprt_code, $dagsland->dag_no))->row();
                    }
                    else
                    {
                        $dag_area = $this->db->query("SELECT sum(dag_area_b*100+dag_area_k*20+dag_area_lc) as sarea FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($district['dags'][0]->dist_code, $district['dags'][0]->subdiv_code, $district['dags'][0]->cir_code, $district['dags'][0]->mouza_pargona_code, $district['dags'][0]->lot_no, $district['dags'][0]->vill_townprt_code, $dagsland->dag_no))->row();
                    }

                    $sum_area = $dag_area->sarea;



                    $prem_zonal1 = $this->utilityclass->getZonalValue($dagsland->dist_code,$get_settlement_basic2->uuid,$dagsland->dag_no);
                    //$ratepr = $premiumData->rate;

                    $reclass_dag_data = $this->db->query("Select * from reclass_dag_details where case_no='$case_no' and dag_no ='$dagsland->dag_no'")->row();

                    if($premiumData->rate_type==1 && $reclass_dag_data->prop_lc_cat_id==2)
                    {
                        if(in_array($dist_code, json_decode(BARAK_VALLEY)))
                        {
                            if($sum_area<=6400)
                            {
                                $ratepr = 0;
                            }
                            else
                            {
                                 $ratepr = $premiumData->rate;
                            }
                        }
                        else
                        {
                            if($sum_area<=100)
                            {
                                $ratepr = 0;
                            }
                            else
                            {
                                 $ratepr = $premiumData->rate;
                            }
                        }
                    }
                    else
                    {
                        $ratepr = $premiumData->rate;
                    }

                    $sumMbAmountperzonal = ($prem_zonal1 * $ratepr) / 100;


                    $dist_code = $this->session->userdata('dist_code');
                    if(in_array($dist_code, json_decode(BARAK_VALLEY)))
                    {
                        $premium_zonal_per_lessa = $sumMbAmountperzonal / 6400;
                    }
                    else
                    {
                        $premium_zonal_per_lessa = $sumMbAmountperzonal / 100;
                    }

                    //$sumMbAmount = $sum_area * $premium_zonal_per_lessa;
                   // $sumMbAmountTotal += $sum_area * $premium_zonal_per_lessa;

                    $prem_rate_section = null;
                    $co_penalty = null;


                    if($dagsland->is_penalty=='Y')
                    {
                            $rate_section = $this->input->post('reclass_check'.$dagsland->dag_no);
                            $rate_section_five = $this->input->post('reclass_five_check'.$dagsland->dag_no);
                            $reclass_check_penalty = $this->input->post('reclass_check_penalty'.$dagsland->dag_no);

                            // Normalize nulls to 'NO'
                            $rate_section = $rate_section ?: 'NO';
                            $rate_section_five = $rate_section_five ?: 'NO';
                            $reclass_check_penalty = $reclass_check_penalty ?: 'NO';

                            $yes_count = 0;
                            $yes_count += ($rate_section === 'YES') ? 1 : 0;
                            $yes_count += ($rate_section_five === 'YES') ? 1 : 0;
                            $yes_count += ($reclass_check_penalty === 'YES') ? 1 : 0;

                            // Validate logic
                            if ($yes_count === 0 || $yes_count > 1) {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRSETFUL001: Invalid selection combination for RTPS Case No ' . $case_no);
                                $data = array(
                                    'error' => "#ERRSETFUL001: Select only one option. If no rate sections selected, penalty must be YES for case: " . $case_no
                                );
                                echo json_encode($data);
                                return false;
                            }

                           // var_dump($rate_section_five);exit;

                            if($rate_section=='YES'){
                                $prem_rate_section = 2;
                            }
                            if($rate_section_five=='YES'){
                                $prem_rate_section = 5;
                                $reclass_check_penalty_just = $this->input->post('remark_co_justification'.$dagsland->dag_no);

                                if ($reclass_check_penalty_just==null) 
                                        {
                                        $this->db->trans_rollback();
                                        log_message('error', '#ERRSETJUST003: Invalid selection combination for RTPS Case No ' . $case_no);
                                        $data = array(
                                            'error' => "#ERRSETJUST003: JUSTIFICATION needed: " . $case_no
                                        );
                                        echo json_encode($data);
                                        return false;
                                        }
                            }

                            if($reclass_check_penalty=='YES'){
                                $prem_rate_section = null;
                                $co_penalty = 'N';
                            }

                        $dag_amount = $sum_area * $premium_zonal_per_lessa;
                        $sumMbAmount = ($prem_rate_section * $dag_amount) + $dag_amount ;
                        $sumMbAmountTotal += ($prem_rate_section * $dag_amount) + $dag_amount;

                        if($prem_rate_section == 5){

                            $insertArr = [
                                'case_no' => $case_no,
                                'proceeding_id' => $proceeding_id,
                                'note_type' => 'JUSTIFICATION',
                                'note_on_order' => 'JUSTIFICATION for 5X penalty for Dag :'.$dagsland->dag_no.'-'.$reclass_check_penalty_just,
                                'status' => 'W',
                                'user_code' => $this->session->userdata('user_code'),
                                'date_entry' => date('Y-m-d h:i:s'),
                                'operation' => 'E',
                                'ip' => $this->utilityclass->get_client_ip(),
                                'office_from' => 'CO',
                                'task'          => 'Penalty Updated',
                            ];
                            $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
                            if ($insertProc != 1)
                            {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRCO0004: Insertion failed in settlement_proceeding');
                                $json = [
                                    'responseType' => 3,
                                    'message' => '#ERRCO0004: Failed to forward to DC. Kindly contact System Administrator',
                                ];
                                echo json_encode($json);
                                return false;
                            }
                            }
                    }

                    else
                    {
                        $sumMbAmount = $sum_area * $premium_zonal_per_lessa;
                        $sumMbAmountTotal += $sum_area * $premium_zonal_per_lessa;
                    }

                    if($reclass_dag_data->is_penalty == 'Y')
                      {
                        $premium_without_penalty = $dag_amount;
                      }

                      else
                      {
                        $premium_without_penalty = null;
                      }


                    $fmd=array(
                        'case_no'=>$case_no,
                        'user_code'=>$this->session->userdata('user_code'),
                        'uuid'=>$get_settlement_basic2->uuid,
                        'dag_no'=>$dagsland->dag_no,
                        'zonal_valuation'=>$premiumData->zonal_valuation,
                        'land_type'=>$premiumData->land_type,
                        'rate_type'=>$premiumData->rate_type,
                        'rate'=>$premiumData->rate,
                        'amount_dag'=>$sumMbAmount,
                        // 'final_amount'=>$sumMbAmountTotal,
                        // 'due_amount'=>$sumMbAmountTotal,
                        'total_lessa'=>$sum_area,
                        //'is_full_pay'=>$this->input->post('paymode'),
                        'is_final'=>1,
                        'date_entry'=>date('Y-m-d h:i:s'),
                        //'approve_by'=>$this->input->post('approval'.$dag_premium->dag_no),
                        'penalty_rate' => $prem_rate_section,
                        'premium_without_penalty' => $premium_without_penalty

                    );

                    $insPremium = $this->db->insert('settlement_premium', $fmd);

                    if ($insPremium != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRSET000101: Insertion failed in settlement_premium RTPS Case No '.$application_no);
                        $data = array(
                            'error'=>"#ERRSET000101: Registration of Settlement failed for case no : ".$case_no
                        );
                        echo json_encode($data);
                        return false;
                    }
                }

                $fmddata= [
                    'penalty_rate'=>$prem_rate_section,
                    'co_penalty' => $co_penalty
                ];
                $this->db->where('case_no', $case_no);
                $this->db->where('dag_no', $dagsland->dag_no);
                $this->db->update('reclass_dag_details', $fmddata);
                if($this->db->affected_rows() <= 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERROR0012: Updation failed in settlement_dag_details RTPS Case No '.$case_no);
                    $data = array(
                        'error'=>"#ERROR0012: Registration of Settlement failed for case no : ".$case_no
                    );
                    echo json_encode($data);
                    return false;
                }
            }
            $co_edit = 'Y';
        }

        //if co does not changed reclass data//

        else
        {
            $district['dags'] = $dags          = $this->reclassModel->getSettlementDag($case_no);
            $sumMbAmountTotal = 0;
            foreach ($dags as $dagsland)
            {
                if($dagsland->is_partition=='Y' && $dagsland->is_full_partition=='N')
                {
                    $this->form_validation->set_rules('bigha_part_co'.$dagsland->dag_no, 'Bigha', 'trim|required');
                    $this->form_validation->set_rules('katha_part_co'.$dagsland->dag_no, 'Katha', 'trim|required');
                    $this->form_validation->set_rules('lessa_part_co'.$dagsland->dag_no, 'Lessa', 'trim|required');

                    if (in_array($dagsland->dist_code, json_decode(BARAK_VALLEY))){
                        $this->form_validation->set_rules('ganda_part_co'.$dagsland->dag_no, 'Ganda', 'trim|required');
                    }

                    if ($this->form_validation->run() == false) {
                        $data = array(
                            'error' => "#RECLDAGS00011:" . validation_errors(),
                        );
                        echo json_encode($data);
                        return false;
                    }

                    $prem_rate_section = null;
                    $co_penalty =  null;

                    if($dagsland->is_penalty=='Y')
                    {
                        if($dagsland->exit_lc_by_lm==1 && $dagsland->prop_lc_cat_id==2)
                         {
                                if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY))))
                                {
                                    $total_p_dag_area = ($bigha_part_co * 6400) + ($katha_part_co * 320) + ($lessa_part_co * 20) + $ganda_part_co; //total area
                                    $total_p_dag_in_lessa = ($total_p_dag_area/6400);

                                }
                                else
                                {
                                    $total_p_dag_area = ($bigha_part_co * 100) + ($katha_part_co * 20) + $lessa_part_co; //total area
                                    $total_p_dag_in_lessa = ($total_p_dag_area/100);

                                }

                                // var_dump($total_p_dag_in_lessa);exit;

                                if($total_p_dag_in_lessa<=1)
                                {
                                    $prem_rate_section = 0;
                                    $co_penalty = 'N';
                                    
                                }

                                else
                                {
                                    $rate_section = $this->input->post('reclass_check'.$dagsland->dag_no);
                                    $rate_section_five = $this->input->post('reclass_five_check'.$dagsland->dag_no);
                                    $reclass_check_penalty = $this->input->post('reclass_check_penalty'.$dagsland->dag_no);

                                    // Normalize nulls to 'NO'
                                    $rate_section = $rate_section ?: 'NO';
                                    $rate_section_five = $rate_section_five ?: 'NO';
                                    $reclass_check_penalty = $reclass_check_penalty ?: 'NO';

                                    $yes_count = 0;
                                    $yes_count += ($rate_section === 'YES') ? 1 : 0;
                                    $yes_count += ($rate_section_five === 'YES') ? 1 : 0;
                                    $yes_count += ($reclass_check_penalty === 'YES') ? 1 : 0;

                                    // Validate logic
                                    if ($yes_count === 0 || $yes_count > 1) {
                                        $this->db->trans_rollback();
                                        log_message('error', '#ERRSETFUL001: Invalid selection combination for RTPS Case No ' . $case_no);
                                        $data = array(
                                            'error' => "#ERRSETFUL001: Select only one option. If no rate sections selected, penalty must be YES for case: " . $case_no
                                        );
                                        echo json_encode($data);
                                        return false;
                                    }

                                   // var_dump($rate_section_five);exit;

                                    if($rate_section=='YES'){
                                        $prem_rate_section = 2;
                                    }
                                    if($rate_section_five=='YES'){
                                        $prem_rate_section = 5;
                                    }

                                    if($reclass_check_penalty=='YES'){
                                        $prem_rate_section = null;
                                        $co_penalty = 'N';
                                    }
                                }
                         }

                        else
                        {
                            $rate_section = $this->input->post('reclass_check'.$dagsland->dag_no);
                            $rate_section_five = $this->input->post('reclass_five_check'.$dagsland->dag_no);
                            $reclass_check_penalty = $this->input->post('reclass_check_penalty'.$dagsland->dag_no);

                            // Normalize nulls to 'NO'
                            $rate_section = $rate_section ?: 'NO';
                            $rate_section_five = $rate_section_five ?: 'NO';
                            $reclass_check_penalty = $reclass_check_penalty ?: 'NO';

                            $yes_count = 0;
                            $yes_count += ($rate_section === 'YES') ? 1 : 0;
                            $yes_count += ($rate_section_five === 'YES') ? 1 : 0;
                            $yes_count += ($reclass_check_penalty === 'YES') ? 1 : 0;

                            // Validate logic
                            if ($yes_count === 0 || $yes_count > 1) {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRSETFUL001: Invalid selection combination for RTPS Case No ' . $case_no);
                                $data = array(
                                    'error' => "#ERRSETFUL001: Select only one option. If no rate sections selected, penalty must be YES for case: " . $case_no
                                );
                                echo json_encode($data);
                                return false;
                            }

                           // var_dump($rate_section_five);exit;

                            if($rate_section=='YES'){
                                $prem_rate_section = 2;
                            }
                            if($rate_section_five=='YES'){
                                $prem_rate_section = 5;
                            }

                            if($reclass_check_penalty=='YES'){
                                $prem_rate_section = null;
                                $co_penalty = 'N';
                            }
                        }
                    }

                    $get_insert_info = $this->reclassModel->insertPartialdata($case_no,$dagsland->dag_no,$district['dags'],$uuid,$prem_rate_section,$co_penalty);

                    if($get_insert_info['response']=='true')
                    {
                        //$sumMbAmountTotal +=$get_insert_info['sumMbAmount'];
                        $amount_dag = $get_insert_info['sumMbAmount'];

                        if($dagsland->is_penalty=='Y')
                        {

                            if($dagsland->exit_lc_by_lm==1 && $dagsland->prop_lc_cat_id==2)
                            {
                                if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY))))
                                {
                                    $total_p_dag_area = ($bigha_part_co * 6400) + ($katha_part_co * 320) + ($lessa_part_co * 20) + $ganda_part_co; //total area
                                    $total_p_dag_in_lessa = ($total_p_dag_area/6400);

                                }
                                else
                                {
                                    $total_p_dag_area = ($bigha_part_co * 100) + ($katha_part_co * 20) + $lessa_part_co; //total area
                                    $total_p_dag_in_lessa = ($total_p_dag_area/100);

                                }

                                // var_dump($total_p_dag_in_lessa);exit;

                                if($total_p_dag_in_lessa<=1)
                                {
                                    $prem_rate_section = 0;
                                    $co_penalty = 'N';
                                    
                                }

                                else{

                                    $rate_section = $this->input->post('reclass_check'.$dagsland->dag_no);
                                    $rate_section_five = $this->input->post('reclass_five_check'.$dagsland->dag_no);
                                    $reclass_check_penalty = $this->input->post('reclass_check_penalty'.$dagsland->dag_no);

                                    // Normalize nulls to 'NO'
                                    $rate_section = $rate_section ?: 'NO';
                                    $rate_section_five = $rate_section_five ?: 'NO';
                                    $reclass_check_penalty = $reclass_check_penalty ?: 'NO';

                                    $yes_count = 0;
                                    $yes_count += ($rate_section === 'YES') ? 1 : 0;
                                    $yes_count += ($rate_section_five === 'YES') ? 1 : 0;
                                    $yes_count += ($reclass_check_penalty === 'YES') ? 1 : 0;

                                    // Validate logic
                                    if ($yes_count === 0 || $yes_count > 1) {
                                        $this->db->trans_rollback();
                                        log_message('error', '#ERRSETFUL001: Invalid selection combination for RTPS Case No ' . $case_no);
                                        $data = array(
                                            'error' => "#ERRSETFUL001: Select only one option. If no rate sections selected, penalty must be YES for case: " . $case_no
                                        );
                                        echo json_encode($data);
                                        return false;
                                    }

                                   // var_dump($rate_section_five);exit;

                                    if($rate_section=='YES'){
                                        $prem_rate_section = 2;
                                    }
                                    if($rate_section_five=='YES'){
                                        $prem_rate_section = 5;
                                        $reclass_check_penalty_just = $this->input->post('remark_co_justification'.$dagsland->dag_no);

                                        if ($reclass_check_penalty_just==null) 
                                        {
                                        $this->db->trans_rollback();
                                        log_message('error', '#ERRSETJUST004: Invalid selection combination for RTPS Case No ' . $case_no);
                                        $data = array(
                                            'error' => "#ERRSETJUST004: JUSTIFICATION needed: " . $case_no
                                        );
                                        echo json_encode($data);
                                        return false;
                                        }
                                    }

                                    if($reclass_check_penalty=='YES'){
                                        $prem_rate_section = null;
                                        $co_penalty = 'N';
                                    }

                            $sumMbAmountTotal += ($prem_rate_section * $amount_dag) + $amount_dag ;
                            $amount_dag = ($prem_rate_section * $amount_dag) + $amount_dag ;
                            }
                            }

                            else{

                                    $rate_section = $this->input->post('reclass_check'.$dagsland->dag_no);
                                    $rate_section_five = $this->input->post('reclass_five_check'.$dagsland->dag_no);
                                    $reclass_check_penalty = $this->input->post('reclass_check_penalty'.$dagsland->dag_no);

                                    // Normalize nulls to 'NO'
                                    $rate_section = $rate_section ?: 'NO';
                                    $rate_section_five = $rate_section_five ?: 'NO';
                                    $reclass_check_penalty = $reclass_check_penalty ?: 'NO';

                                    $yes_count = 0;
                                    $yes_count += ($rate_section === 'YES') ? 1 : 0;
                                    $yes_count += ($rate_section_five === 'YES') ? 1 : 0;
                                    $yes_count += ($reclass_check_penalty === 'YES') ? 1 : 0;

                                    // Validate logic
                                    if ($yes_count === 0 || $yes_count > 1) {
                                        $this->db->trans_rollback();
                                        log_message('error', '#ERRSETFUL001: Invalid selection combination for RTPS Case No ' . $case_no);
                                        $data = array(
                                            'error' => "#ERRSETFUL001: Select only one option. If no rate sections selected, penalty must be YES for case: " . $case_no
                                        );
                                        echo json_encode($data);
                                        return false;
                                    }

                                   // var_dump($rate_section_five);exit;

                                    if($rate_section=='YES'){
                                        $prem_rate_section = 2;
                                    }
                                    if($rate_section_five=='YES'){
                                        $prem_rate_section = 5;
                                        $reclass_check_penalty_just = $this->input->post('remark_co_justification'.$dagsland->dag_no);

                                        if ($reclass_check_penalty_just==null) 
                                        {
                                        $this->db->trans_rollback();
                                        log_message('error', '#ERRSETJUST005: Invalid selection combination for RTPS Case No ' . $case_no);
                                        $data = array(
                                            'error' => "#ERRSETJUST005: JUSTIFICATION needed: " . $case_no
                                        );
                                        echo json_encode($data);
                                        return false;
                                        }
                                    }

                                    if($reclass_check_penalty=='YES'){
                                        $prem_rate_section = null;
                                        $co_penalty = 'N';
                                    }

                            $sumMbAmountTotal += ($prem_rate_section * $amount_dag) + $amount_dag ;
                            $amount_dag = ($prem_rate_section * $amount_dag) + $amount_dag ;
                          }

                            if($prem_rate_section == 5){

                            $insertArr = [
                                'case_no' => $case_no,
                                'proceeding_id' => $proceeding_id,
                                'note_type' => 'JUSTIFICATION',
                                'note_on_order' => 'JUSTIFICATION for 5X penalty for Dag :'.$dagsland->dag_no.'-'.$reclass_check_penalty_just,
                                'status' => 'W',
                                'user_code' => $this->session->userdata('user_code'),
                                'date_entry' => date('Y-m-d h:i:s'),
                                'operation' => 'E',
                                'ip' => $this->utilityclass->get_client_ip(),
                                'office_from' => 'CO',
                                'task'          => 'Penalty Updated',
                            ];
                            $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
                            if ($insertProc != 1)
                            {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRCO0004: Insertion failed in settlement_proceeding');
                                $json = [
                                    'responseType' => 3,
                                    'message' => '#ERRCO0004: Failed to forward to DC. Kindly contact System Administrator',
                                ];
                                echo json_encode($json);
                                return false;
                            }
                            }
                        }

                        else
                        {
                            $sumMbAmountTotal +=$get_insert_info['sumMbAmount'];
                        }

                        $dagPremium = [
                        'amount_dag'=>$amount_dag
                        ];

                        $this->db->where('case_no', $case_no);
                        $this->db->where('dag_no', $dagsland->dag_no);
                        $this->db->where('is_final', 1);
                        $this->db->update('settlement_premium', $dagPremium);

                        //*******check if data updated */
                        if ($this->db->affected_rows() == 0) {
                            $this->db->trans_rollback();
                            log_message('error', '#RECLPENALTY001: Update fail in reclass_dag_details ' . $case_no);
                            $data = array(
                                'responseType' => 0,
                                'msg' => "#RECLPENALTY001: Update fail in reclass_dag_details : " . $case_no,
                            );
                            echo json_encode($data);
                            return false;
                        }
                    }

                    else
                    {
                        $this->db->trans_rollback();
                        return false;
                    }
                }

                else if($dagsland->is_partition=='Y' && $dagsland->is_full_partition=='Y')
                {

                    $prem_rate_section = null;
                    $co_penalty =  null;
                    $reclass_check_penalty_just = null;

                    if($dagsland->is_penalty=='Y')
                    {

                        if($dagsland->exit_lc_by_lm==1 && $dagsland->prop_lc_cat_id==2)
                         {
                                if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY))))
                                {
                                    $total_p_dag_area = ($bigha_part_co * 6400) + ($katha_part_co * 320) + ($lessa_part_co * 20) + $ganda_part_co; //total area
                                    $total_p_dag_in_lessa = ($total_p_dag_area/6400);

                                }
                                else
                                {
                                    $total_p_dag_area = ($bigha_part_co * 100) + ($katha_part_co * 20) + $lessa_part_co; //total area
                                    $total_p_dag_in_lessa = ($total_p_dag_area/100);

                                }

                                // var_dump($total_p_dag_in_lessa);exit;

                                if($total_p_dag_in_lessa<=1)
                                {
                                    $prem_rate_section = 0;
                                    $co_penalty = 'N';
                                    
                                }

                                else
                                {
                                    $rate_section = $this->input->post('reclass_check'.$dagsland->dag_no);
                                    $rate_section_five = $this->input->post('reclass_five_check'.$dagsland->dag_no);
                                    $reclass_check_penalty = $this->input->post('reclass_check_penalty'.$dagsland->dag_no);

                                    // Normalize nulls to 'NO'
                                    $rate_section = $rate_section ?: 'NO';
                                    $rate_section_five = $rate_section_five ?: 'NO';
                                    $reclass_check_penalty = $reclass_check_penalty ?: 'NO';

                                    $yes_count = 0;
                                    $yes_count += ($rate_section === 'YES') ? 1 : 0;
                                    $yes_count += ($rate_section_five === 'YES') ? 1 : 0;
                                    $yes_count += ($reclass_check_penalty === 'YES') ? 1 : 0;

                                    // Validate logic
                                    if ($yes_count === 0 || $yes_count > 1) {
                                        $this->db->trans_rollback();
                                        log_message('error', '#ERRSETFUL001: Invalid selection combination for RTPS Case No ' . $case_no);
                                        $data = array(
                                            'error' => "#ERRSETFUL001: Select only one option. If no rate sections selected, penalty must be YES for case: " . $case_no
                                        );
                                        echo json_encode($data);
                                        return false;
                                    }

                                   // var_dump($rate_section_five);exit;

                                    if($rate_section=='YES'){
                                        $prem_rate_section = 2;
                                    }
                                    if($rate_section_five=='YES'){
                                        $prem_rate_section = 5;
                                    }

                                    if($reclass_check_penalty=='YES'){
                                        $prem_rate_section = null;
                                        $co_penalty = 'N';
                                    }
                                }
                         }

                        else
                        {
                        $rate_section = $this->input->post('reclass_check'.$dagsland->dag_no);
                        $rate_section_five = $this->input->post('reclass_five_check'.$dagsland->dag_no);
                        $reclass_check_penalty = $this->input->post('reclass_check_penalty'.$dagsland->dag_no);

                        // Normalize nulls to 'NO'
                        $rate_section = $rate_section ?: 'NO';
                        $rate_section_five = $rate_section_five ?: 'NO';
                        $reclass_check_penalty = $reclass_check_penalty ?: 'NO';

                        $yes_count = 0;
                        $yes_count += ($rate_section === 'YES') ? 1 : 0;
                        $yes_count += ($rate_section_five === 'YES') ? 1 : 0;
                        $yes_count += ($reclass_check_penalty === 'YES') ? 1 : 0;

                        // Validate logic
                        if ($yes_count === 0 || $yes_count > 1) {
                            $this->db->trans_rollback();
                            log_message('error', '#ERRSETFUL001: Invalid selection combination for RTPS Case No ' . $case_no);
                            $data = array(
                                'error' => "#ERRSETFUL001: Select only one option. If no rate sections selected, penalty must be YES for case: " . $case_no
                            );
                            echo json_encode($data);
                            return false;
                        }

                       // var_dump($rate_section_five);exit;

                        if($rate_section=='YES'){
                            $prem_rate_section = 2;
                        }
                        if($rate_section_five=='YES'){
                            $prem_rate_section = 5;
                        }

                        if($reclass_check_penalty=='YES'){
                            $prem_rate_section = null;
                            $co_penalty = 'N';
                        }
                        }
                    }

                    $get_insert_info = $this->reclassModel->insertFullReclasswithPartitiondata($case_no,$dagsland->dag_no,$dagsland,$uuid,$prem_rate_section);

                    if($get_insert_info['response']=='true')
                    {
                        //$sumMbAmountTotal +=$get_insert_info['sumMbAmount'];
                        $amount_dag = $get_insert_info['sumMbAmount'];

                        if($dagsland->is_penalty=='Y')
                        {

                            if($dagsland->exit_lc_by_lm==1 && $dagsland->prop_lc_cat_id==2)
                            {
                                if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY))))
                                {
                                    $total_p_dag_area = ($bigha_part_co * 6400) + ($katha_part_co * 320) + ($lessa_part_co * 20) + $ganda_part_co; //total area
                                    $total_p_dag_in_lessa = ($total_p_dag_area/6400);

                                }
                                else
                                {
                                    $total_p_dag_area = ($bigha_part_co * 100) + ($katha_part_co * 20) + $lessa_part_co; //total area
                                    $total_p_dag_in_lessa = ($total_p_dag_area/100);

                                }

                                // var_dump($total_p_dag_in_lessa);exit;

                                if($total_p_dag_in_lessa<=1)
                                {
                                    $prem_rate_section = 0;
                                    $co_penalty = 'N';
                                    
                                }

                                else{

                                    $rate_section = $this->input->post('reclass_check'.$dagsland->dag_no);
                                    $rate_section_five = $this->input->post('reclass_five_check'.$dagsland->dag_no);
                                    $reclass_check_penalty = $this->input->post('reclass_check_penalty'.$dagsland->dag_no);

                                    // Normalize nulls to 'NO'
                                    $rate_section = $rate_section ?: 'NO';
                                    $rate_section_five = $rate_section_five ?: 'NO';
                                    $reclass_check_penalty = $reclass_check_penalty ?: 'NO';

                                    $yes_count = 0;
                                    $yes_count += ($rate_section === 'YES') ? 1 : 0;
                                    $yes_count += ($rate_section_five === 'YES') ? 1 : 0;
                                    $yes_count += ($reclass_check_penalty === 'YES') ? 1 : 0;

                                    // Validate logic
                                    if ($yes_count === 0 || $yes_count > 1) {
                                        $this->db->trans_rollback();
                                        log_message('error', '#ERRSETFUL001: Invalid selection combination for RTPS Case No ' . $case_no);
                                        $data = array(
                                            'error' => "#ERRSETFUL001: Select only one option. If no rate sections selected, penalty must be YES for case: " . $case_no
                                        );
                                        echo json_encode($data);
                                        return false;
                                    }

                                   // var_dump($rate_section_five);exit;

                                    if($rate_section=='YES'){
                                        $prem_rate_section = 2;
                                    }
                                    if($rate_section_five=='YES'){
                                        $prem_rate_section = 5;
                                        $reclass_check_penalty_just = $this->input->post('remark_co_justification'.$dagsland->dag_no);

                                        if ($reclass_check_penalty_just==null) 
                                        {
                                        $this->db->trans_rollback();
                                        log_message('error', '#ERRSETFUL006: Invalid selection combination for RTPS Case No ' . $case_no);
                                        $data = array(
                                            'error' => "#ERRSETFUL006: JUSTIFICATION needed: " . $case_no
                                        );
                                        echo json_encode($data);
                                        return false;
                                        }
                                    }

                                    if($reclass_check_penalty=='YES'){
                                        $prem_rate_section = null;
                                        $co_penalty = 'N';
                                    }

                            $sumMbAmountTotal += ($prem_rate_section * $amount_dag) + $amount_dag ;
                            $amount_dag = ($prem_rate_section * $amount_dag) + $amount_dag ;
                            }
                            }

                            else{
                            $rate_section = $this->input->post('reclass_check'.$dagsland->dag_no);
                            $rate_section_five = $this->input->post('reclass_five_check'.$dagsland->dag_no);
                            $reclass_check_penalty = $this->input->post('reclass_check_penalty'.$dagsland->dag_no);

                            // Normalize nulls to 'NO'
                            $rate_section = $rate_section ?: 'NO';
                            $rate_section_five = $rate_section_five ?: 'NO';
                            $reclass_check_penalty = $reclass_check_penalty ?: 'NO';

                            $yes_count = 0;
                            $yes_count += ($rate_section === 'YES') ? 1 : 0;
                            $yes_count += ($rate_section_five === 'YES') ? 1 : 0;
                            $yes_count += ($reclass_check_penalty === 'YES') ? 1 : 0;

                            // Validate logic
                            if ($yes_count === 0 || $yes_count > 1) {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRSETFUL001: Invalid selection combination for RTPS Case No ' . $case_no);
                                $data = array(
                                    'error' => "#ERRSETFUL001: Select only one option. If no rate sections selected, penalty must be YES for case: " . $case_no
                                );
                                echo json_encode($data);
                                return false;
                            }

                           // var_dump($rate_section_five);exit;

                            if($rate_section=='YES'){
                                $prem_rate_section = 2;
                            }
                            if($rate_section_five=='YES'){
                                $prem_rate_section = 5;
                                $reclass_check_penalty_just = $this->input->post('remark_co_justification'.$dagsland->dag_no);

                                if ($reclass_check_penalty_just==null) 
                                        {
                                        $this->db->trans_rollback();
                                        log_message('error', '#ERRSETFUL007: Invalid selection combination for RTPS Case No ' . $case_no);
                                        $data = array(
                                            'error' => "#ERRSETFUL007: JUSTIFICATION needed: " . $case_no
                                        );
                                        echo json_encode($data);
                                        return false;
                                        }

                            }

                            if($reclass_check_penalty=='YES'){
                                $prem_rate_section = null;
                                $co_penalty = 'N';
                            }

                            $sumMbAmountTotal += ($prem_rate_section * $amount_dag) + $amount_dag ;
                            $amount_dag = ($prem_rate_section * $amount_dag) + $amount_dag ;
                            }


                            if($prem_rate_section == 5){

                            $insertArr = [
                                'case_no' => $case_no,
                                'proceeding_id' => $proceeding_id,
                                'note_type' => 'JUSTIFICATION',
                                'note_on_order' => 'JUSTIFICATION for 5X penalty for Dag :'.$dagsland->dag_no.'-'.$reclass_check_penalty_just,
                                'status' => 'W',
                                'user_code' => $this->session->userdata('user_code'),
                                'date_entry' => date('Y-m-d h:i:s'),
                                'operation' => 'E',
                                'ip' => $this->utilityclass->get_client_ip(),
                                'office_from' => 'CO',
                                'task'          => 'Penalty Updated',
                            ];
                            $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
                            if ($insertProc != 1)
                            {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRCO0004: Insertion failed in settlement_proceeding');
                                $json = [
                                    'responseType' => 3,
                                    'message' => '#ERRCO0004: Failed to forward to DC. Kindly contact System Administrator',
                                ];
                                echo json_encode($json);
                                return false;
                            }
                            }
                        }

                        else
                        {
                            $sumMbAmountTotal +=$get_insert_info['sumMbAmount'];
                        }

                        $dagPremium = [
                        'amount_dag'=>$amount_dag
                        ];

                        $this->db->where('case_no', $case_no);
                        $this->db->where('dag_no', $dagsland->dag_no);
                        $this->db->where('is_final', 1);
                        $this->db->update('settlement_premium', $dagPremium);

                        //*******check if data updated */
                        if ($this->db->affected_rows() == 0) {
                            $this->db->trans_rollback();
                            log_message('error', '#RECLPENALTY001: Update fail in reclass_dag_details ' . $case_no);
                            $data = array(
                                'responseType' => 0,
                                'msg' => "#RECLPENALTY001: Update fail in reclass_dag_details : " . $case_no,
                            );
                            echo json_encode($data);
                            return false;
                        }
                    }

                    else
                    {
                        $this->db->trans_rollback();
                        return false;
                    }
                }

                else
                {

                    $prem_rate_section = null;
                    $co_penalty =  null;
                    $reclass_check_penalty_just = null;


                    if($dagsland->is_penalty == 'Y')
                    {

                        if($dagsland->exit_lc_by_lm==1 && $dagsland->prop_lc_cat_id==2)
                         {
                                if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY))))
                                {
                                    $total_p_dag_area = ($dagsland->dag_area_b * 6400) + ($dagsland->dag_area_k * 320) + ($dagsland->dag_area_lc * 20) + $dagsland->dag_area_g; //total area
                                    $total_p_dag_in_lessa = ($total_p_dag_area/6400);

                                }
                                else
                                {
                                    $total_p_dag_area = ($dagsland->dag_area_b * 100) + ($dagsland->dag_area_k * 20) + $dagsland->dag_area_lc; //total area
                                    $total_p_dag_in_lessa = ($total_p_dag_area/100);

                                }

                                if($total_p_dag_in_lessa<=1)
                                {
                                    $prem_rate_section = 0;
                                    $co_penalty = 'N';
                                    
                                }

                                else
                                {
                                    $rate_section = $this->input->post('reclass_check'.$dagsland->dag_no);
                                    $rate_section_five = $this->input->post('reclass_five_check'.$dagsland->dag_no);
                                    $reclass_check_penalty = $this->input->post('reclass_check_penalty'.$dagsland->dag_no);

                                    // Normalize nulls to 'NO'
                                    $rate_section = $rate_section ?: 'NO';
                                    $rate_section_five = $rate_section_five ?: 'NO';
                                    $reclass_check_penalty = $reclass_check_penalty ?: 'NO';

                                    $yes_count = 0;
                                    $yes_count += ($rate_section === 'YES') ? 1 : 0;
                                    $yes_count += ($rate_section_five === 'YES') ? 1 : 0;
                                    $yes_count += ($reclass_check_penalty === 'YES') ? 1 : 0;

                                    // Validate logic
                                    if ($yes_count === 0 || $yes_count > 1) {
                                        $this->db->trans_rollback();
                                        log_message('error', '#ERRSETFUL001: Invalid selection combination for RTPS Case No ' . $case_no);
                                        $data = array(
                                            'error' => "#ERRSETFUL001: Select only one option. If no rate sections selected, penalty must be YES for case: " . $case_no
                                        );
                                        echo json_encode($data);
                                        return false;
                                    }

                                   // var_dump($rate_section_five);exit;

                                    if($rate_section=='YES'){
                                        $prem_rate_section = 2;
                                    }
                                    if($rate_section_five=='YES'){
                                        $prem_rate_section = 5;
                                    }

                                    if($reclass_check_penalty=='YES'){
                                        $prem_rate_section = null;
                                        $co_penalty = 'N';
                                    }
                                }
                         }

                        else
                        {
                        $rate_section = $this->input->post('reclass_check'.$dagsland->dag_no);
                        $rate_section_five = $this->input->post('reclass_five_check'.$dagsland->dag_no);
                        $reclass_check_penalty = $this->input->post('reclass_check_penalty'.$dagsland->dag_no);

                        // Normalize nulls to 'NO'
                        $rate_section = $rate_section ?: 'NO';
                        $rate_section_five = $rate_section_five ?: 'NO';
                        $reclass_check_penalty = $reclass_check_penalty ?: 'NO';

                        $yes_count = 0;
                        $yes_count += ($rate_section === 'YES') ? 1 : 0;
                        $yes_count += ($rate_section_five === 'YES') ? 1 : 0;
                        $yes_count += ($reclass_check_penalty === 'YES') ? 1 : 0;

                        // Validate logic
                        if ($yes_count === 0 || $yes_count > 1) {
                            $this->db->trans_rollback();
                            log_message('error', '#ERRSETFUL001: Invalid selection combination for RTPS Case No ' . $case_no);
                            $data = array(
                                'error' => "#ERRSETFUL001: Select only one option. If no rate sections selected, penalty must be YES for case: " . $case_no
                            );
                            echo json_encode($data);
                            return false;
                        }

                       // var_dump($rate_section_five);exit;

                        if($rate_section=='YES'){
                            $prem_rate_section = 2;
                        }
                        if($rate_section_five=='YES'){
                            $prem_rate_section = 5;
                        }

                        if($reclass_check_penalty=='YES'){
                            $prem_rate_section = null;
                            $co_penalty = 'N';
                        }

                     }
                    }

                    $get_insert_info = $this->reclassModel->insertFullReclassdata($case_no,$dagsland->dag_no,$dagsland,$uuid,$prem_rate_section,$co_penalty);

                    // var_dump($get_insert_info);$this->db->trans_rollback();exit;

                    if($get_insert_info['response']=='true')
                    {
                        //$sumMbAmountTotal +=$get_insert_info['sumMbAmount'];
                        $amount_dag = $get_insert_info['sumMbAmount'];

                        if($dagsland->is_penalty=='Y')
                        {
                            if($dagsland->exit_lc_by_lm==1 && $dagsland->prop_lc_cat_id==2)
                            {
                                if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY))))
                                {
                                    $total_p_dag_area = ($dagsland->dag_area_b * 6400) + ($dagsland->dag_area_k * 320) + ($dagsland->dag_area_lc * 20) + $dagsland->dag_area_g; //total area
                                    $total_p_dag_in_lessa = ($total_p_dag_area/6400);

                                }
                                else
                                {
                                    $total_p_dag_area = ($dagsland->dag_area_b * 100) + ($dagsland->dag_area_k * 20) + $dagsland->dag_area_lc; //total area
                                    $total_p_dag_in_lessa = ($total_p_dag_area/100);

                                }

                                // var_dump($total_p_dag_in_lessa);exit;

                                if($total_p_dag_in_lessa<=1)
                                {
                                    $prem_rate_section = 0;
                                    $co_penalty = 'N';
                                    
                                }

                                else{

                                    $rate_section = $this->input->post('reclass_check'.$dagsland->dag_no);
                                    $rate_section_five = $this->input->post('reclass_five_check'.$dagsland->dag_no);
                                    $reclass_check_penalty = $this->input->post('reclass_check_penalty'.$dagsland->dag_no);

                                    // Normalize nulls to 'NO'
                                    $rate_section = $rate_section ?: 'NO';
                                    $rate_section_five = $rate_section_five ?: 'NO';
                                    $reclass_check_penalty = $reclass_check_penalty ?: 'NO';

                                    $yes_count = 0;
                                    $yes_count += ($rate_section === 'YES') ? 1 : 0;
                                    $yes_count += ($rate_section_five === 'YES') ? 1 : 0;
                                    $yes_count += ($reclass_check_penalty === 'YES') ? 1 : 0;

                                    // Validate logic
                                    if ($yes_count === 0 || $yes_count > 1) {
                                        $this->db->trans_rollback();
                                        log_message('error', '#ERRSETFUL001: Invalid selection combination for RTPS Case No ' . $case_no);
                                        $data = array(
                                            'error' => "#ERRSETFUL001: Select only one option. If no rate sections selected, penalty must be YES for case: " . $case_no
                                        );
                                        echo json_encode($data);
                                        return false;
                                    }

                                   // var_dump($rate_section_five);exit;

                                    if($rate_section=='YES'){
                                        $prem_rate_section = 2;
                                    }
                                    if($rate_section_five=='YES'){
                                        $prem_rate_section = 5;
                                        $reclass_check_penalty_just = $this->input->post('remark_co_justification'.$dagsland->dag_no);

                                        if ($reclass_check_penalty_just==null) 
                                        {
                                        $this->db->trans_rollback();
                                        log_message('error', '#ERRSETFUL008: Invalid selection combination for RTPS Case No ' . $case_no);
                                        $data = array(
                                            'error' => "#ERRSETFUL008: JUSTIFICATION needed: " . $case_no
                                        );
                                        echo json_encode($data);
                                        return false;
                                        }
                                    }

                                    if($reclass_check_penalty=='YES'){
                                        $prem_rate_section = null;
                                        $co_penalty = 'N';
                                    }

                            $sumMbAmountTotal += ($prem_rate_section * $amount_dag) + $amount_dag ;
                            $amount_dag = ($prem_rate_section * $amount_dag) + $amount_dag ;
                            }
                            }

                            else{
                            $rate_section = $this->input->post('reclass_check'.$dagsland->dag_no);
                            $rate_section_five = $this->input->post('reclass_five_check'.$dagsland->dag_no);
                            $reclass_check_penalty = $this->input->post('reclass_check_penalty'.$dagsland->dag_no);

                            // Normalize nulls to 'NO'
                            $rate_section = $rate_section ?: 'NO';
                            $rate_section_five = $rate_section_five ?: 'NO';
                            $reclass_check_penalty = $reclass_check_penalty ?: 'NO';

                            $yes_count = 0;
                            $yes_count += ($rate_section === 'YES') ? 1 : 0;
                            $yes_count += ($rate_section_five === 'YES') ? 1 : 0;
                            $yes_count += ($reclass_check_penalty === 'YES') ? 1 : 0;

                            // Validate logic
                            if ($yes_count === 0 || $yes_count > 1) {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRSETFUL001: Invalid selection combination for RTPS Case No ' . $case_no);
                                $data = array(
                                    'error' => "#ERRSETFUL001: Select only one option. If no rate sections selected, penalty must be YES for case: " . $case_no
                                );
                                echo json_encode($data);
                                return false;
                            }

                           // var_dump($rate_section_five);exit;

                            if($rate_section=='YES'){
                                $prem_rate_section = 2;
                            }
                            if($rate_section_five=='YES'){
                                $prem_rate_section = 5;
                                $reclass_check_penalty_just = $this->input->post('remark_co_justification'.$dagsland->dag_no);

                                if ($reclass_check_penalty_just==null) 
                                {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRSETFUL009: Invalid selection combination for RTPS Case No ' . $case_no);
                                $data = array(
                                    'error' => "#ERRSETFUL009: JUSTIFICATION needed: " . $case_no
                                );
                                echo json_encode($data);
                                return false;
                                }
                            }

                            if($reclass_check_penalty=='YES'){
                                $prem_rate_section = null;
                                $co_penalty = 'N';
                            }

                            $sumMbAmountTotal += ($prem_rate_section * $amount_dag) + $amount_dag ;
                            $amount_dag = ($prem_rate_section * $amount_dag) + $amount_dag ;
                            }


                            //////proceeding start//////
                            $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                            if ($proceeding_id == null) {
                                $proceeding_id = 1;
                            }

                            if($prem_rate_section == 5){

                            $insertArr = [
                                'case_no' => $case_no,
                                'proceeding_id' => $proceeding_id,
                                'note_type' => 'JUSTIFICATION',
                                'note_on_order' => 'JUSTIFICATION for 5X penalty for Dag :'.$dagsland->dag_no.'-'.$reclass_check_penalty_just,
                                'status' => 'W',
                                'user_code' => $this->session->userdata('user_code'),
                                'date_entry' => date('Y-m-d h:i:s'),
                                'operation' => 'E',
                                'ip' => $this->utilityclass->get_client_ip(),
                                'office_from' => 'CO',
                                'task'          => 'Penalty Updated',
                            ];
                            $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
                            if ($insertProc != 1)
                            {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRCO0004: Insertion failed in settlement_proceeding');
                                $json = [
                                    'responseType' => 3,
                                    'message' => '#ERRCO0004: Failed to forward to DC. Kindly contact System Administrator',
                                ];
                                echo json_encode($json);
                                return false;
                            }
                            }
                        }

                        else
                        {
                            $sumMbAmountTotal +=$get_insert_info['sumMbAmount'];
                        }

                        $dagPremium = [
                        'amount_dag'=>$amount_dag
                        ];

                        $this->db->where('case_no', $case_no);
                        $this->db->where('dag_no', $dagsland->dag_no);
                        $this->db->where('is_final', 1);
                        $this->db->update('settlement_premium', $dagPremium);

                        //*******check if data updated */
                        if ($this->db->affected_rows() == 0) {
                            $this->db->trans_rollback();
                            log_message('error', '#RECLPENALTY001: Update fail in reclass_dag_details ' . $case_no);
                            $data = array(
                                'responseType' => 0,
                                'msg' => "#RECLPENALTY001: Update fail in reclass_dag_details : " . $case_no,
                            );
                            echo json_encode($data);
                            return false;
                        }
                    }

                    else
                    {
                        $this->db->trans_rollback();
                        return false;
                    }
                }
            }
            $co_edit = 'N';
        }



        $totalPremium = [
            'final_amount'=>$sumMbAmountTotal,
            'due_amount'=>$sumMbAmountTotal
        ];


        $this->db->where('case_no', $case_no);
        $this->db->where('is_final', 1);
        $this->db->update('settlement_premium', $totalPremium);

        //*******check if data updated */
        if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            log_message('error', '#RECLPENALTY001: Update fail in reclass_dag_details ' . $case_no);
            $data = array(
                'responseType' => 0,
                'msg' => "#RECLPENALTY001: Update fail in reclass_dag_details : " . $case_no,
            );
            echo json_encode($data);
            return false;
        }

        $partition_info = $this->reclassModel->getPartionInfoforCO($case_no);

        $updateArr = [
            'co_partition_enable'=> $partition_info,
            'co_edit'=>$co_edit
        ];
        $this->db->where('case_no', $case_no);
        $this->db->update('reclass_suite_basic', $updateArr);

        if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            log_message('error', '#ERRCO00034343: Failed to save');
            $json = [
                'responseType' => 3,
                'message' => '#ERRCO00034343: Failed to save. Kindly contact system administrator',
            ];
            echo json_encode($json);
            return false;
        }



        //////proceeding start//////
        $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
        if ($proceeding_id == null) {
            $proceeding_id = 1;
        }

        $insertArr = [
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'note_type' => 'CO edited reclass type',
            'note_on_order' => 'CO Edited reclass type',
            'status' => 'W',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d h:i:s'),
            'operation' => 'E',
            'ip' => $this->utilityclass->get_client_ip(),
            'office_from' => 'CO',
            'task'          => 'Reclass Type Updated',
        ];
        $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
        if ($insertProc != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRCO0004: Insertion failed in settlement_proceeding');
            $json = [
                'responseType' => 3,
                'message' => '#ERRCO0004: Failed to forward to DC. Kindly contact System Administrator',
            ];
            echo json_encode($json);
            return false;
        }
        if ($this->db->trans_status() == false)
        {
            $this->db->trans_rollback();
            $data = array(
                'error' => "Error in submitting. Please try Again",
            );
            return $data;
            exit;
        }
        else
        {
            $this->db->trans_commit();
            $data=array(
                'success'=>"Data saved successfully!"
            );

            echo json_encode($data);
        }
    }


    public function coReSubmitLmCases()
    {
        $service_code = $this->input->get('service');
        $status = $this->input->get('s');

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $chitha_data['cases'] = $this->db->query("
            SELECT * FROM reclass_suite_basic WHERE dist_code='$dist_code'AND subdiv_code='$subdiv_code'AND cir_code='$cir_code'AND status='X'AND lm_code is not null")->result();

        $chitha_data['select_data'] = $this->SettlementCommonModel->locationSelect($service_code, $status);
        $chitha_data['service_code'] = $service_code;
        $chitha_data['_view'] = 'reclass_suite/co/co_resubmit_lm_cases';

        $this->load->view('layouts/main', $chitha_data);
    }

    public function checkRuralUrban()
    {
        $case_no = $this->input->post('case_no');
        $sql = $this->db->query("SELECT * FROM reclass_dag_details WHERE case_no = ?", array($case_no));

        if ($sql->num_rows() > 0) {
            $data = array(
                'responseType' => 2,
                'villageName' => $this->utilityclass->getEnglishVillageName($sql->row()->dist_code, $sql->row()->subdiv_code, $sql->row()->cir_code, $sql->row()->mouza_pargona_code, $sql->row()->lot_no, $sql->row()->vill_townprt_code),
                'mouzaName' => $this->utilityclass->getEnglishMouzaName($sql->row()->dist_code, $sql->row()->subdiv_code, $sql->row()->cir_code, $sql->row()->mouza_pargona_code),
                'circleName' => $this->utilityclass->getEnglishCircleName($sql->row()->dist_code, $sql->row()->subdiv_code, $sql->row()->cir_code),
                'isUrban' => $sql->row()->is_urban,
                'area' => $sql->result(),
            );
            echo json_encode($data);
        } else {
            $data = array(
                'responseType' => 0,
                'msg' => "#RURAL003344: Case not found against case_no : " . $case_no,
            );
            echo json_encode($data);
            return false;
        }
    }

    public function astNoticeGivenReclass()
    {
        $service_code = $this->input->get('service');
        $status = $this->input->get('s');

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $chitha_data['cases'] = $this->db->query("
            SELECT * FROM reclass_suite_basic WHERE dist_code='$dist_code'AND subdiv_code='$subdiv_code'AND cir_code='$cir_code'AND status='N'AND lm_code is not null")->result();

        $chitha_data['select_data'] = $this->SettlementCommonModel->locationSelect($service_code, $status);
        $chitha_data['service_code'] = $service_code;
        $chitha_data['_view'] = 'reclass_suite/co/co_partition_cases';

        $this->load->view('layouts/main', $chitha_data);
    }

    public function paymentNoticeCoReclass()
    {
        $status = $this->input->get('s');
        $service_code = $this->input->get("service");
        $data['getPaymentNoticeCo'] = $this->reclassModel->getPaymentNoticeCoReclass($service_code);
        $data['select_data'] = $this->SettlementCommonModel->locationSelect($service_code, $status);
        $dist_code = $this->session->userdata('dist_code');
        if ($service_code == 16 || $service_code == 14 || $service_code == 15 || $service_code == 17) {
            if (in_array($dist_code, json_decode(PAYMENT_NOTICE_BULK_REQUEST_DIST))) {
                return $this->paymentNoticeCoNew();
            }
        }

        $data['_view'] = 'reclass_suite/co/payment_notice_co';
        $this->load->view('layouts/main', $data);
    }


    public function generatePaymentNoticeCoReclass(){
        if(isset($_POST['generate_notice'])){
            $payment_amount = $this->input->post('payment_amount');
            $case_no = $this->input->post('case_no');
            $remark = $this->input->post('remark_co');
            $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);
            //$get_dag_details = $this->SettlementApModel->getSettlementDagDetails($case_no);
            $get_settlement_applicant = $this->SettlementApModel->getAllApplicant($case_no);
            $get_owners = $this->SettlementApModel->getOwners($case_no);
            $get_buyers = $this->SettlementApModel->getBuyers($case_no);
            $get_dag_details = $this->SettlementApModel->getDags($case_no);
            $data = [
                'payment_amount' => $payment_amount,
                'case_no' => $case_no,
                'get_settlement_basic' => $get_settlement_basic,
                'get_dag_details' => $get_dag_details,
                'get_owners' => $get_owners,
                'get_buyers' => $get_buyers,
                'get_settlement_applicant' => $get_settlement_applicant,
                'remark' => $remark,
                'pay_notice_date' => date('Y-m-d')
            ];
            $this->load->view('SettlementView/Co/Tenant/paymentNotice',$data);
        }else{
            $case_no = $this->input->get('case');
            $data['basic'] = $this->reclassModel->getSettlementBasicCo($case_no);
            $data['_view'] = 'reclass_suite/co/generateNoticeView';
            $this->load->view('layouts/main', $data);
        }
    }


    public function loadViewForPaymentGenerationReclass()
    {
        $case_no         = $this->input->post('case_no');
        $data['prem']    = $this->db->query("SELECT * FROM settlement_premium WHERE case_no=? and is_final = ?",
            array($case_no,1))->row();

        $data['case_no'] = $this->input->post('case_no');
        $this->load->view('reclass_suite/co/ReclassLoadModalPaymentNotice', $data);
    }


    // get payment generation page
    public function generatePaymentNotice()
    {
        // $_POST        = json_decode(file_get_contents("php://input"), true);
        $final_amount = $this->input->post('final_amount');
        $due_amount   = $this->input->post('due_amount');
        $case_no      = $this->input->post('case_no_notice');

        $get_settlement_basic     = $this->reclassModel->getSettlementBasic($case_no);
        $get_settlement_applicant = $this->reclassModel->getAllApplicant($case_no);
        $get_owners               = $this->reclassModel->getAllApplicantOwners($case_no);
        $get_buyers               = $this->reclassModel->getMainApplicantPayment($case_no);
        $get_dag_details          = $this->reclassModel->getSettlementDag($case_no);
        $get_land_class_details   = $this->reclassModel->getLandcLassdetails($case_no);
        //var_dump($get_land_class_details->exit_lc_by_lm);exit;

        if (empty($get_buyers) || $get_buyers == null || $get_buyers == '') {
            $this->session->set_flashdata('message', "#ERR5930: Unable to generate payment notice for case #".$case_no);
            redirect(base_url().'index.php/TeaGrantControllerAdc/viewAllGeneratedNoticeTeaGrantAdcCaseList');
        }

        // $premium_data = $this->db->query("SELECT sp.*, spa.area, spl.land_type, spr.house_type FROM
        //                   settlement_premium sp LEFT OUTER JOIN settlement_premium_area spa
        //                     ON spa.paid=sp.area_name LEFT OUTER JOIN settlement_premium_land_type spl
        //                       ON spl.plid=sp.land_type LEFT OUTER JOIN settlement_premium_rate spr
        //                         ON spr.prid=sp.rate_type WHERE case_no=? and is_final=?",
        //                           array($case_no, 1))->result();

        $premium_data = $this->db->query("SELECT sp.*,sp.penalty_rate as pr,rd.* from settlement_premium sp
            join reclass_dag_details rd on sp.case_no=rd.case_no and sp.dag_no=rd.dag_no WHERE sp.case_no=? and is_final=?",
            array($case_no, 1))->result();

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3 . "getApplicationDate");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'application_no' => $this->utilityclass->getApplidFromCaseNoReclass($case_no),
        )));
        $output = curl_exec($curl_handle);
        if (isset(json_decode($output)->responseType)) {
            if (json_decode($output)->responseType != 'y') {
                echo json_decode($output)->data . " - Unauthorized access!";
                return false;
            }
        }
        curl_close($curl_handle);
        $res = json_decode($output);


        // echo "<pre>"; var_dump($get_buyers); die;

        $data = [
            'payment_amount'           => $final_amount,
            'case_no'                  => $case_no,
            'get_settlement_basic'     => $get_settlement_basic,
            'get_dag_details'          => $get_dag_details,
            'get_owners'               => $get_owners,
            'get_buyers'               => $get_buyers,
            'get_settlement_applicant' => $get_settlement_applicant,
            'pay_notice_date'          => date('Y-m-d'),
            'premium_data'             => $premium_data,
            'date_of_application'      => date('d/m/Y', strtotime($res->submission_date)),
            'get_land_class_details'   => $get_land_class_details
        ];

        $this->load->view('reclass_suite/co/paymentNoticePrint', $data);

    }

    // save payment notice
    public function savePaymentNotice()
    {
        $_POST                  = json_decode(file_get_contents("php://input"), true);
        $case_no                = $this->input->post('case_no');
        $amount                 = $this->input->post('amount');
        $district               = $this->input->post('district');
        $sub_division           = $this->input->post('sub_division');
        $circle                 = $this->input->post('circle');
        $lot_no                 = $this->input->post('lot_no');
        $mouza                  = $this->input->post('mouza');
        $village                = $this->input->post('village');
        $payment_notice_gn_date = $this->input->post('pay_notice_gn_date');

        //var_dump($case_no);exit;

        //$this->utilityclass->checkUserAuthForCaseForAdc($case_no);

        // check if general notice generated
        // $checkGeneralNotice = $this->db->query("SELECT * FROM settlement_notice WHERE case_no=? AND notice_type=?", array($case_no, 'GN'))->num_rows();



        // if($checkGeneralNotice == 0) {
        //   log_message('error', "#ERR6002: General notice yet to be generated for case no: $case_no");
        //   $json = [
        //     'responseType' => 1,
        //     'message'      => "#ERR6002: General notice yet to be generated for case no: $case_no",
        //   ];
        //   echo json_encode($json);
        //   return;
        // }

        $noticeAlreadyGeneratedCheck = $this->db->query('SELECT * FROM settlement_notice WHERE case_no = ? AND notice_type = ?', array($case_no, 'PN'));

        if ($noticeAlreadyGeneratedCheck->num_rows() > 0) {
            log_message('error', "#ERR6009: Premium notice already generated for case no: $case_no");
            $json = [
                'responseType' => 1,
                'message'      => "#ERR6009: Premium notice already generated for case no: $case_no",
            ];
            echo json_encode($json);
            return;
        }

        // replacing file case number to savable format
        $new_case_no = str_replace('/', "-", $case_no);

        // creating and saving the base64 format payment notice to uploads/paymentNotice folder
        $base_64_file_path    = PAYMENT_NOTICE_PATH . $new_case_no . ".json";

        $file_to_write_base64 = fopen($base_64_file_path, "w") or die("Unable to open file!");
        $htmlstring_text      = json_encode($this->input->post('htmlstring_text'));
        fwrite($file_to_write_base64, $htmlstring_text);
        fclose($file_to_write_base64);

        $get_settlement_basic     = $this->reclassModel->getSettlementBasic($case_no);
        $get_dag_details          = $this->reclassModel->getSettlementDag($case_no);
        $get_settlement_applicant = $this->reclassModel->getAllApplicant($case_no);
        // $checkArea                = $this->chithaReserveAreaCheckWithCaseNo($case_no);

        // if ($checkArea != 0) {
        //   log_message('error', '#ERR6038: Applied area cannot exceed total chitha area !');
        //   $json = [
        //     'responseType' => 1,
        //     'message'      => '#ERR6038: Applied area cannot exceed total chitha area !',
        //   ];
        //   echo json_encode($json);
        //   return;
        // }

        $this->db->trans_begin();

        // settlement_notice table insertaion
        $sql_service      = "SELECT * FROM reclass_suite_basic WHERE case_no = ?";
        $service_details  = $this->db->query($sql_service, $case_no)->row();
        $sql_buyers       = "SELECT * FROM reclass_applicant WHERE case_no = ? AND pdar_type = 'O'";
        $applicant_buyers = $this->db->query($sql_buyers, $case_no)->result();

        foreach ($applicant_buyers as $buyers)
        {
            $applicant_buyers_json[] = [
                'APPLICANT_ID'         => $buyers->id,
                'APPLICANT_NAME_BUYER' => $buyers->pdar_name,
                'GUARDIAN_NAME'        => $buyers->pdar_guardian,
            ];
        }
        $notice_no = "MB3/PN/".date('Y')."/".RECLASS_SUITE."/".$service_details->petition_no;

        $insertIntoSettlementNotice = [
            'case_no'                => $case_no,
            'service_code'           => $service_details->service_code,
            'case_registration_date' => $service_details->submission_date,
            'payment_notice_date'    => date('Y-m-d'),
            'total_amount'           => $amount,
            'sdlac_proposal_id'      => $service_details->sdlace_proposal_no,
            'sdlac_proposal_date'    => $service_details->sdlac_date,
            'applicant_details'      => json_encode($applicant_buyers_json),
            'notice_no'              => $notice_no,
            'notice_link'            => $base_64_file_path,
            'notice_type'            => 'PN',
        ];
        $insertIntoSettlementNotice = $this->db->insert('settlement_notice', $insertIntoSettlementNotice);
        if ($insertIntoSettlementNotice != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERR6081: Insertion failed in settlement_notice : '.$this->db->last_query());
            $json = [
                'responseType' => 1,
                'message'      => "#ERR6081: Failed to generate payment notice for case no $case_no",
            ];
            echo json_encode($json);
            return;
        }
        $updateArr = [
            'status'             => 'N',
            'dc_code'            => $this->session->userdata('user_code'),
            'user_code'          => $this->session->userdata('user_code'),
            'pay_notice_gen_yn'  => 'Y',
            'pay_notice_gn_date' => $payment_notice_gn_date,
            'date_update'        => date('Y-m-d h:i:s'),
            'from_office'        => 'CO',
            'pending_officer'    => 'CO',
            'pending_office'     => 'CO',
            'co_notice_link'     => $base_64_file_path,
            'dc_proceeding'      => 1,
        ];
        $this->db->where('case_no', $case_no);
        $this->db->update('reclass_suite_basic', $updateArr);
        if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            log_message('error', '#ERR6109: Updation failed in reclass_suite_basic : '.$this->db->last_query());
            $json = [
                'responseType' => 1,
                'message'      => "#ERR6109: Failed to generate payment notice for case no $case_no",
            ];
            echo json_encode($json);
            return;
        }
        //////proceeding start//////
        $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
        if ($proceeding_id == null) {
            $proceeding_id = 1;
        }
        $insertArr = [
            'case_no'              => $case_no,
            'proceeding_id'        => $proceeding_id,
            'date_of_hearing'      => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'note_on_order'        => "",
            'status'               => 'N',
            'user_code'            => $this->session->userdata('user_code'),
            'date_entry'           => date('Y-m-d h:i:s'),
            'operation'            => 'E',
            'ip'                   => $this->utilityclass->get_client_ip(),
            'office_from'          => 'CO',
            'office_to'            => 'CO',
            'task'                 => 'Payment Notice Generated',
        ];
        $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
        if ($insertProc != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERR6137: Insertion failed in settlement_proceeding : '.$this->db->last_query());
            $json = [
                'responseType' => 1,
                'message'      => "#ERR6137: Failed to generate payment notice for case no $case_no",
            ];
            echo json_encode($json);
            return;
        }

        if($this->db->trans_status() == false) {
            $this->db->trans_rollback();
            log_message('error', '#ERR6132: Transaction failed : '.json_encode($this->db->trans_status()));
            $json = [
                'responseType' => 1,
                'message'      => "#ERR6132: Failed to generate payment notice for case no $case_no",
            ];
            echo json_encode($json);
            return;
        }

        // var_dump($htmlstring_text); $this->db->trans_rollback();die;



        //   API CALL END HERE
        $sql = "Select basundhara from basundhar_application where dharitree=?";
        $basundhara = $this->db->query($sql, array($case_no))->row();

        // call api to upload notice
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3."uploadNotice");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'encoded_file'   => json_decode($htmlstring_text),
            'application_no' => $basundhara->basundhara,
            'type'           => 'PN',
            'amount'         => $amount,
            'is_full_pay'    => 'Y',
        )));
        $result = curl_exec($curl_handle);
        log_message("error", "#6157_API_RESP: ". json_encode($result));

        // var_dump($result);

        if (trim($result) != 'y') {
            $this->db->trans_rollback();
            log_message('error', '#6162: Issue in API response : '.json_encode($result));
            $json = [
                'responseType' => 1,
                'message'      => "#6162: Failed to generate payment notice for case no $case_no",
            ];
            echo json_encode($json);
            return;
        }
        else {
            $this->db->trans_commit();

            $json = [
              'responseType' => 2,
              'message'      => "#SUCCESS6175: Payment notice successfully saved for case no $case_no",
            ];
            echo json_encode($json);
            return;

            // $this->session->set_flashdata('message', "Payment notice successfully saved for Case no # $case_no By CO");
            // redirect(base_url() . "index.php/Home/ReclassSuiteLandCo?service=40");
        }
    }

    public function getDagEligibility()
    {
        $case_no = $this->input->post('case_no');
        $dag_no = $this->input->post('dag_no');



        $dag_data = $this->db->select()
            ->where('case_no',$case_no)
            ->where('dag_no', $dag_no)
            ->where('status', 1)
            ->get('reclass_dag_eligibility');
        $result_data = $dag_data->result();
        // echo $this->db->last_query();

        // if($result_data){

        $data = array(
            'responseType' => 2,
            'dag_data' => $result_data
        );
        echo json_encode($data);
        //}
    }

    public function getDagEligibilityforotherthanagrinonagri()
    {
        $case_no = $this->input->post('case_no');
        $dag_no = $this->input->post('dag_no');



        $dag_data = $this->db->select()
            ->where('case_no',$case_no)
            ->where('dag_no', $dag_no)
            ->where('status', 1)
            ->get('reclass_dag_eligibility');
        $result_data = $dag_data->result();
        // echo $this->db->last_query();

        // if($result_data){

        $data = array(
            'responseType' => 2,
            'dag_data' => $result_data
        );
        echo json_encode($data);
        //}
    }

    public function getPartionInforDags()
    {
        $case_no = $this->input->post('case_no');
        $dag_no = $this->input->post('dag_no');



        // $dag_data = $this->db->select()
        //       ->where('case_no',$case_no)
        //       ->where('dag_no', $dag_no)
        //       ->get('reclass_partition_info');

        $dag_data = $this->db->query("select rpi.*,rdd.lm_area_b,rdd.lm_area_k,rdd.lm_area_lc,rdd.lm_area_g from reclass_partition_info rpi join reclass_dag_details rdd on rpi.case_no=rdd.case_no where rdd.case_no = ? and rdd.dag_no = ?",array($case_no,$dag_no));


        $result_data = $dag_data->result();
        // echo $this->db->last_query();

        // if($result_data){

        $data = array(
            'responseType' => 2,
            'dag_data' => $result_data
        );
        echo json_encode($data);
        //}
    }





    public function paymentNoticeCofirmationCases()
    {
        $service_code = $this->input->get('service');
        $status = $this->input->get('s');
        $data['getPaymentConfirmationCo'] = $this->reclassModel->getPaymentConfirmationCo($service_code);
        $data['select_data'] = $this->SettlementCommonModel->locationSelect($service_code, $status);
        $data['_view'] = 'reclass_suite/co/paymentConfirmationCasesReclass';
        $this->load->view('layouts/main', $data);
    }


    public function confirmPaymentCo()
    {

        $case_no = $_GET['case_no'] = dec_param($this->input->get('case'), 'case_no');
        if($_GET['case_no'] == null)
        {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
            return;
        }

        $allowed = ['CO'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }


        $get_settlement_basic = $this->reclassModel->getSettlementBasicCo($case_no);
        // var_dump($get_settlement_basic); die();
        $case_no_rtps = $get_settlement_basic->applid;
        // payment status check thourgh API
        $payment_status_check = $this->basundhara3Model->paymentConfirmation($case_no_rtps);
        $get_settlement_prem = $this->reclassModel->getSettlementPremium($case_no);
        $get_dags = $this->reclassModel->getElligibleDags($case_no);
        // var_dump($get_settlement_prem->final_amount);
        if ($payment_status_check == null || (
                !isset($payment_status_check->payment_status)
                && !isset($payment_status_check->total_premium)
                && !isset($payment_status_check->paid_amount)
                && !isset($payment_status_check->remaining_amount)
                && !isset($payment_status_check->tenure)
                && !isset($payment_status_check->installment_amount)
            )) {
            $total_premium = 0;
            $paid_amount = 0;
            $remaining_amount = 0;
            $tenure = 0;
            $installment_amount = 0;
            $percentage = 0;
            $pay_date = null;
        }

        $pay_status = $payment_status_check->payment_status;
        if (strtoupper($pay_status) == 'Y') {
            $total_premium =$get_settlement_prem->final_amount;// $payment_status_check->total_premium;
            $paid_amount = $get_settlement_prem->final_amount;//$payment_status_check->paid_amount;
            $remaining_amount = $payment_status_check->remaining_amount;
            $tenure = $payment_status_check->tenure;
            // $installment_amount = '';//$payment_status_check->installment_amount;
            $percentage = '100';//$payment_status_check->percentage;
            $pay_date = date('Y-m-d');//$payment_status_check->payment_date;
        } else {
            $total_premium = 0;
            $paid_amount = 0;
            $remaining_amount = 0;
            $tenure = 0;
            $installment_amount = 0;
            $percentage = 0;
            $pay_date = null;
        }

        $data = [
            'case_no' => $case_no,
            'payment_status' => strtolower($pay_status),
            'payment_date' => $pay_date,
            'case_no_rtps' => $case_no_rtps,
            'total_premium' => $total_premium,
            'paid_amount' => $paid_amount,
            'remaining_amount' => $remaining_amount,
            'tenure' => $tenure,
            'installment_amount' => '',//$installment_amount,
            'percentage' => $percentage,
            //'_view' => 'settlement_mb/confirmPaymentView'
            'get_dags' => $get_dags
        ];

        // if (strtoupper($pay_status) == 'Y') {
        //     $sqlCheck = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ? and grn_no is null limit 1', array($case_no, 1));

        //     if ($sqlCheck->num_rows() > 0) {
        //         $this->db->trans_begin();

        //         $dagsResult = $this->SettlementKhasModel->getSettlementDag($case_no);
        //         $isFullPay = 'YES';

        //         if ($payment_status_check->total_premium != $payment_status_check->paid_amount) {
        //             $isFullPay = 'NO';
        //         }

        //         $insertArr = [
        //             'is_full_pay' => $isFullPay,
        //             'total_premium' => $payment_status_check->total_premium,
        //             'paid_amount' => $payment_status_check->paid_amount,
        //             'remaining_amount' => $payment_status_check->remaining_amount,
        //             'tenure' => $payment_status_check->tenure,
        //             'installment_amount' => $payment_status_check->installment_amount,
        //             'payment_date' => $payment_status_check->payment_date,
        //             'grn_no' => $payment_status_check->grn_no,
        //         ];

        //         $this->db->where('case_no', $case_no);
        //         $this->db->where('is_final', 1);
        //         $this->db->update('settlement_premium', $insertArr);

        //         if ($this->db->affected_rows() != count($dagsResult)) {
        //             $this->db->trans_rollback();
        //             $this->session->set_flashdata('message', "#ERR737: Something went wrong! Unable to process...");
        //             redirect(base_url() . "index.php/Home/index");
        //         }
        //         $this->db->trans_commit();
        //     }
        // }

        // $getNomTrasSql = $this->db->query('select * from settlement_nominee_transaction where case_no = ?', array($case_no));
        // if ($getNomTrasSql->num_rows() <= 0) {
        //     $data['nomTrans'] = false;
        // } else {
        //     $data['nomTrans'] = $getNomTrasSql->result();
        // }

        //$getNomTrasSql = $this->db->query('select * from settlement_nominee where case_no = ?', array($case_no));
        // if ($getNomTrasSql->num_rows() <= 0) {
        //     $data['nomReal'] = false;
        // } else {
        //     $data['nomReal'] = $getNomTrasSql->result();
        // }

        if ($get_settlement_basic->service_code == RECLASS_ID) {
            $pattasqll = "SELECT type_code, patta_type FROM patta_code where settlement='y' order by type_code asc";
            $data['_view'] = 'reclass_suite/co/confirmPaymentViewReclass';
        }

        // $dist_code = $get_settlement_basic->dist_code;
        // $subdiv_code = $get_settlement_basic->subdiv_code;
        // $cir_code = $get_settlement_basic->cir_code;
        // $q = "Select * from settlement_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and case_no='$case_no'"; // and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill'";
        // $data['alm'] = $alm = $this->db->query($q)->row();
        // $mouza = $get_settlement_basic->mouza_pargona_code;
        // $lot_no = $get_settlement_basic->lot_no;
        // $vill = $get_settlement_basic->vill_townprt_code;
        // //$patta_type = $alm->patta_type_code;
        // $data['dagDetails'] = $patta_type_code = $this->db->query("
        //         SELECT * FROM settlement_dag_details
        //         WHERE dist_code = '$dist_code' AND subdiv_code = '$subdiv_code'
        //         AND cir_code = '$cir_code' AND  mouza_pargona_code = '$mouza'
        //         AND lot_no = '$lot_no' AND vill_townprt_code = '$vill' AND case_no = '$case_no'")->result();

        // $data['update_land_class'] = false;

        // foreach ($data['dagDetails'] as $dagRow) {
        //     $getPremSql = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ? and dag_no = ?', array($case_no, '1', $dagRow->dag_no));

        //     if ($getPremSql->num_rows() <= 0) {
        //         $dagRow->final_settlement_area = false;
        //     } else {
        //         $premiumRow = $getPremSql->row();
        //         if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
        //             $total_settlement_area = $this->utilityclass->Total_Bigha_Katha_Lessa2($premiumRow->total_lessa);

        //             $dagRow->final_settlement_area = 'B: ' . $total_settlement_area[0] . ' K: ' . $total_settlement_area[1] . ' C: ' . $total_settlement_area[2] . ' G: ' . $total_settlement_area[3];
        //         } else {
        //             $total_settlement_area = $this->utilityclass->Total_Bigha_Katha_Lessa($premiumRow->total_lessa);

        //             $dagRow->final_settlement_area = 'B: ' . $total_settlement_area[0] . ' K: ' . $total_settlement_area[1] . ' L: ' . $total_settlement_area[2];
        //         }
        //     }

        //     //****getting the roadside reservation area */
        //     $reservation = $this->db->query('select * from settlement_reservation where case_no = ? and type = ? and dag_no = ?', array($case_no, 'R', $dagRow->dag_no));

        //     if ($reservation->num_rows() <= 0) {
        //         $dagRow->road_side_reservation = false;
        //     } else {
        //         $reservation = $reservation->result();

        //         foreach ($reservation as $reservationRow) {
        //             if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
        //                 $dagRow->road_side_reservation = 'B: ' . $reservationRow->bigha . ' K: ' . $reservationRow->katha . ' C: ' . $reservationRow->lessa . ' G: ' . $reservationRow->ganda;
        //             } else {
        //                 $dagRow->road_side_reservation = 'B: ' . $reservationRow->bigha . ' K: ' . $reservationRow->katha . ' L: ' . $reservationRow->lessa;
        //             }
        //         }
        //     }

        //     //*****getting the approval report */

        //     //******getting the final settlement area */
        //     if ($get_settlement_basic->service_code == '14') {
        //         $getAppTransSql = $this->db->query('select * from settlement_approval_transaction where case_no = ? and dag_no = ?', array($case_no, $dagRow->new_dag_no));
        //     } else {
        //         $getAppTransSql = $this->db->query('select * from settlement_approval_transaction where case_no = ? and dag_no = ?', array($case_no, $dagRow->dag_no));
        //     }

        //     if ($getAppTransSql->num_rows() <= 0) {
        //         $data['approvalRow'] = false;
        //     } else {
        //         $appRow = $getAppTransSql->row();

        //         $dagRow->new_patta_type_code = $appRow->patta_type_code;
        //         $dagRow->new_possession_from = $appRow->possession_from;
        //         $dagRow->new_landclass_home = $appRow->landclass_home;
        //         $dagRow->new_landclass_agri = $appRow->landclass_agri;

        //         $dagRow->newHomeRevenue = $appRow->new_home_land_revenue;
        //         $dagRow->newAgriRevenue = $appRow->new_agri_land_revenue;

        //         $dagRow->newHomeLocalTax = $appRow->new_home_land_local_tax;
        //         $dagRow->newAgrilocalTax = $appRow->new_agri_land_local_tax;

        //         $dagRow->new_landmark = json_decode($appRow->landmark);
        //     }

        //     $dagRow->landmark = json_decode($dagRow->landmark);

        //     if ($data['alm']->chitha_processing_details == 2 && (empty($data['alm']->order_passed) || $data['alm']->order_passed == null || $data['alm']->order_passed == '')) {
        //         $landType = 0;
        //         $home_b = $dagRow->home_b;
        //         $home_k = $dagRow->home_k;
        //         $home_lc = $dagRow->home_lc;
        //         $home_g = $dagRow->home_g;
        //         $homestead = $home_b + $home_k + $home_lc + $home_g;
        //         if ($homestead > 0) {
        //             $landType = 1;
        //         }
        //         $agri_b = $dagRow->agri_b;
        //         $agri_k = $dagRow->agri_k;
        //         $agri_lc = $dagRow->agri_lc;
        //         $agri_g = $dagRow->agri_g;
        //         $agriculture = $agri_b + $agri_k + $agri_lc + $agri_g;
        //         if ($agriculture > 0) {
        //             $landType = 2;
        //         }
        //         if ($homestead > 0 && $agriculture > 0) {
        //             $landType = 3;
        //         }

        //         if ($landType == 3) {
        //             if (empty($dagRow->new_land_class_home) || empty($dagRow->new_land_class_agri)) {
        //                 if ($data['update_land_class'] != true) {
        //                     $data['update_land_class'] = true;
        //                 }
        //             }
        //         }
        //     }
        // }

        // $data['class_code'] = $patta_type_code[0]->new_land_class_code;

        // $data['mutpatta'] = $this->db->query($pattasqll)->result();
        // $data['newdag'] = $this->utilityclass->maxdag($dist_code, $subdiv_code, $cir_code, $mouza, $lot_no, $vill);
        // $data['newpatta'] = 0;
        // // $data['newpatta'] = $this->utilityclass->maxpatta($dist_code, $subdiv_code, $cir_code, $mouza, $lot_no, $vill, $patta_type);
        // //var_dump($data);
        // $q = "SELECT dag_no,patta_no,dag_no_int AS new_dag FROM chitha_basic WHERE dist_code='$dist_code'AND subdiv_code='$subdiv_code'AND cir_code='$cir_code'AND mouza_pargona_code='$mouza'AND lot_no='$lot_no'AND vill_townprt_code='$vill'ORDER BY dag_no_int";
        // $data['dag_patta'] = $this->db->query($q)->result();
        // $data['dcnote'] = 'Manipulate text';
        // $data['land_class_code'] = $this->db->query("Select * from landclass_code")->result();

        //var_dump($data['newdag']);

        $this->load->view('layouts/main', $data);

        // if(isset($_POST['payment_confirmed'])){
        //     $case_no = $this->input->post('case_no');
        //     $this->db->trans_begin();
        //     $updateArr = [
        //         'status' => 'P',
        //         'co_code' => $this->session->userdata('user_code'),
        //         'user_code' => $this->session->userdata('user_code'),
        //         'date_update' => date('Y-m-d h:i:s'),
        //         'from_office' => 'CO',
        //         'pending_officer' => 'DC',
        //         'pending_office' => 'DC',
        //     ];
        //     $this->db->where('case_no', $case_no);
        //     $this->db->update('settlement_basic', $updateArr);
        //     if($this->db->affected_rows() == 0 ){
        //         $this->db->trans_rollback();
        //         log_message('error', '#ERRPN0003: Payment confirmation updation failed in settlement_basic table');
        //         $json = [
        //             'responseType' => 3,
        //             'message' => '#ERRPN0003: Payment confirmation updation failed. Kindly contact system administrator',
        //         ];
        //         echo json_encode($json);
        //         return false;
        //     }
        //     //////proceeding start//////
        //     $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
        //     if($proceeding_id==null){
        //         $proceeding_id=1;
        //     }
        //     $insertArr = [
        //         'case_no' => $case_no,
        //         'proceeding_id' => $proceeding_id,
        //         'date_of_hearing' => date('Y-m-d h:i:s'),
        //         'next_date_of_hearing' => date('Y-m-d h:i:s'),
        //         'note_on_order' => 'Payment Cofirmed',
        //         'status' => 'P',
        //         'user_code' => $this->session->userdata('user_code'),
        //         'date_entry' => date('Y-m-d h:i:s'),
        //         'operation' => 'E',
        //         'ip' => $this->utilityclass->get_client_ip(),
        //         'office_from' => 'CO',
        //         'office_to' => 'DC',
        //         'task' => 'Payment Confirmed'
        //     ];
        //     $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
        //     if($insertProc != 1){
        //         $this->db->trans_rollback();
        //         log_message('error', '#ERRPN0004: Insertion failed in settlement_proceeding on payment confirmed');
        //         $json = [
        //             'responseType' => 3,
        //             'message' => '#ERRPN0004: Failed to update payment status. Kindly contact System Administrator',
        //         ];
        //         echo json_encode($json);
        //         return false;
        //     }
        //     if($this->db->trans_status()==FALSE){
        //         $this->db->trans_rollback();
        //         $data=array(
        //             'error'=>"Error in submitting. Please try Again"
        //         );
        //         return $data;
        //         exit;
        //     }else{
        //         $this->db->trans_commit();
        //         $this->session->set_flashdata('message', "Payment status updated to confirmed...");
        //         redirect(base_url() . 'index.php/SettlementMbCo/confirmPaymentCo?case='.$case_no);
        //     }
        // }
    }




    public function dcRevertedCasesReclass()
    {

        $data['getFirstProceeding'] = $this->reclassModel->getDcRevertedCases();

        $service_code = $this->input->get('service');
        $status = $this->input->get('s');
        $data['select_data'] = $this->SettlementCommonModel->locationSelect($service_code, $status);

        $data['_view'] = 'reclass_suite/co/ReclassSuiteFirstProceedingCo';

        $this->load->view('layouts/main', $data);
    }

    public function fetch_land_classes()
    {
        $cat_id = $this->input->post('cat_id');
        $prop_class = "select name,name_ass,landclass_category_id,id from land_class_groups";
        $res = $this->db->query($prop_class)->result();
        echo json_encode($res);
    }

     //****update settlement_applicant*** */
    public function updateProposedClassData()
    {
        $case_no = $this->input->post('case_no');
        $selected = $this->input->post('selectedClass');
        $dag_no = $this->input->post('dag_no');
        $selected_prop_name = $this->input->post('selectedClassText');

        $this->form_validation->set_error_delimiters('', '');
        // $this->form_validation->set_rules('applicant_d_id', 'Applicant ID', 'trim|required');
        $this->form_validation->set_rules('case_no', 'Case no', 'trim|required');

        if ($this->form_validation->run() == false) {
            $data = array(
                'responseType' => 0,
                'msg' => "#RECLDAGS00011:" . validation_errors() . "#case_no : " . $case_no,
            );
            echo json_encode($data);
            return false;
        }

        $this->db->trans_begin();



        $petition_no = $this->db->select()
            ->where('case_no', $case_no)
            ->get('reclass_suite_basic')->row()->petition_no;

        $basic = $this->db->select()
        ->where('case_no', $case_no)
        ->get('reclass_suite_basic')
        ->row();

        $row = $this->db->select()
        ->where('case_no', $case_no)
        ->where('dag_no', $dag_no)
        ->get('reclass_dag_details')
        ->row();

        $proposed_land_class_code = $row ? $row->proposed_land_class_code : null;
        $proposed_land_class_name = $row ? $row->proposed_land_class_name : null;


        $updateArr = [
                    'prop_class_by_appl'      => $proposed_land_class_code,
                    'prop_class_name_by_appl' => $proposed_land_class_name
                ];
                $this->db->where('case_no', $case_no);
                $this->db->where('dag_no', $dag_no);
                $this->db->update('reclass_dag_details', $updateArr);

                if ($this->db->affected_rows() != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCO0004280: Failed to update');
                    $data = [
                        'responseType' => 0,
                        'msg' => '#ERRCO0004280: Failed to update. Kindly contact system administrator',
                    ];
                    echo json_encode($data);
                    return false;
                }

        $prop_lc_cat_id = $this->db->query("select landclass_category_id from land_class_groups 
                        where id=?",array($selected))->row();
                        $prop_lc_category_id = $prop_lc_cat_id->landclass_category_id;

        $updateArrProp = [
                    'proposed_land_class_code' => $selected,
                    'proposed_land_class_name' => $selected_prop_name,
                    'prop_lc_cat_id' =>$prop_lc_category_id
                ];
                $this->db->where('case_no', $case_no);
                $this->db->where('dag_no', $dag_no);
                $this->db->update('reclass_dag_details', $updateArrProp);

                if ($this->db->affected_rows() != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCO0004299: Failed to update');
                    $data = [
                        'responseType' => 0,
                        'msg' => '#ERRCO0004299: Failed to update. Kindly contact system administrator',
                    ];
                    echo json_encode($data);
                    return false;
                }


                ////////supporting document////
                  $_FILES['file']['name']     = $_FILES['nocDocument']['name'];
                  $_FILES['file']['type']     = $_FILES['nocDocument']['type'];
                  $_FILES['file']['tmp_name'] = $_FILES['nocDocument']['tmp_name'];
                  $_FILES['file']['error']    = $_FILES['nocDocument']['error'];
                  $_FILES['file']['size']     = $_FILES['nocDocument']['size'];

                  $mime = mime_content_type($_FILES['nocDocument']['tmp_name']);
                  $exp  = explode("/",$mime);
                  $onlyExtension  = $exp[1];

                  $fileRename =  $this->UUID4() . '.' . $onlyExtension;

                  $doc_upload_path = UPLOAD_DIR . $fileRename;

                  $config['upload_path']   = UPLOAD_DIR;
                  $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
                  $config['max_size']      = UPLOAD_MAX_SIZE;;
                  $config['file_name']     = $fileRename;
                  $this->load->library('upload', $config);
                  $this->upload->initialize($config);
                  if ($this->upload->do_upload('file'))
                  {
                    $document= array(
                      'case_no'   => $case_no,
                      'file_name' => 'No Objection Document',
                      'user_code' => $this->session->userdata('user_code'),
                      'dag_no'    => $dag_no,
                      'fetch_file_name' => $_FILES['file']['name'],
                      'file_type'  => $_FILES['file']['type'],
                      'file_path'  => UPLOAD_DIR . $fileRename,
                      'date_entry' => date('Y-m-d h:i:s'),
                      'mut_type'   => RECLASS_ID,
                    );

                    // save data in attachment file
                    $addMoreDocQuery = $this->db->insert('supportive_document',$document);

                    if($addMoreDocQuery != 1)
                    {
                      $this->db->trans_rollback();
                      log_message('error', '#ERRADDDOC0001: Insertion failed in supportive document RTPS Case No '.$application_no);

                      $data = array(
                        'responseType' => 0,
                        'msg' => "Failed to update document",
                        );
                     echo json_encode($data);
                     return;
                    }

                  }
                ////////premium calculation///
                $prop_lc_det = $this->db->query("select landclass_category_id from land_class_groups 
                        where id=?",array($selected))->row();
                $proc_lc_cat_code = $prop_lc_det->landclass_category_id;

                
                $exist_code_by_lm = $row->exit_lc_by_lm;
                $nature_possession = $row->nature_possession;
                // var_dump($exist_code_by_lm);$this->db->trans_rollback();exit;


                $ratepr2=$this->db->query("select prid,rate from reclass_premium_rate where exist_code='$exist_code_by_lm' and prop_code='$proc_lc_cat_code' order by prid ")->row();
                $ratepr = $ratepr2->rate;

                $sql = $this->db->query("SELECT * FROM reclass_dag_eligibility  WHERE case_no = ? and dag_no = ? and is_agri_to_nonagri = ? and is_eligible = ? and status = ?", array($case_no,$dag_no,'Y','N',1));

                //echo $this->db->last_query();

                if ($sql->num_rows()>=1) 
                {
                    $this->db->trans_rollback();
                    $data = array(
                        'responseType' => 1,
                        'msg' => "Dag is made in-elligible for reclassification by LRA !!!Kindly Check",
                        );
                    echo json_encode($data);
                    return;
                }


                $dist_code = $this->session->userdata('dist_code');
                if(in_array($dist_code, json_decode(BARAK_VALLEY)))
                {
                    $dag_area = $this->db->query("SELECT sum(dag_area_b*6400+dag_area_k*320+dag_area_lc*20+dag_area_g) as sarea FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($row->dist_code, $row->subdiv_code, $row->cir_code, $row->mouza_pargona_code, $row->lot_no, $row->vill_townprt_code, $dag_no))->row();
                }
                else
                {
                    $dag_area = $this->db->query("SELECT sum(dag_area_b*100+dag_area_k*20+dag_area_lc) as sarea FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($row->dist_code, $row->subdiv_code, $row->cir_code, $row->mouza_pargona_code, $row->lot_no, $row->vill_townprt_code, $dag_no))->row();
                }

                $sum_area = $dag_area->sarea;

                if($exist_code_by_lm==1 && $proc_lc_cat_code==2)
                {
                    $dist_code = $this->session->userdata('dist_code');
                    if(in_array($dist_code, json_decode(BARAK_VALLEY)))
                    {
                        if($sum_area<=6400)
                        {
                            $ratepr = 0;
                            $sum_area = $sum_area;
                        }
                        else
                        {
                            $ratepr = $ratepr;
                            $sum_area = $sum_area;
                        }
                    }
                    else
                    {
                        if($sum_area<=100)
                        {
                            $ratepr = 0;
                            $sum_area = $sum_area;
                        }
                        else
                        {
                            $ratepr = $ratepr;
                            $sum_area = $sum_area;
                        }
                    }
                }

                else
                {
                    $ratepr = $ratepr;
                    $sum_area = $sum_area;
                }

                $prem_zonal1 = null;
                $sumMbAmountperzonal = null;

                $prem_zonal1 = $this->utilityclass->getZonalValue($row->dist_code,$basic->uuid,$dag_no);

                $sumMbAmountperzonal = ($prem_zonal1 * $ratepr) / 100;


                $dist_code = $this->session->userdata('dist_code');
                if(in_array($dist_code, json_decode(BARAK_VALLEY)))
                {
                    $premium_zonal_per_lessa = $sumMbAmountperzonal / 6400;
                }
                else
                {
                    $premium_zonal_per_lessa = $sumMbAmountperzonal / 100;
                }

                $sumMbAmount = $sum_area * $premium_zonal_per_lessa;



                $premium_data = $this->db->select()
                ->where('case_no', $case_no)
                ->where('dag_no', $dag_no)
                ->where('is_final', 1)
                ->get('settlement_premium')
                ->row();

                // $proposed_land_class_code = $premium_data ? $premium_data->proposed_land_class_code : null;

                $checkingPremiumExistSql = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and dag_no = ? and is_final = ?", array($case_no,$dag_no,1));

                if($checkingPremiumExistSql->num_rows() > 0)
                  {
                      $sqlprem = "update settlement_premium set is_final=0  WHERE case_no = '$case_no' and dag_no='$dag_no'";
                      $resultprem = $this->db->query($sqlprem);

                      if ($this->db->affected_rows() == 0)
                      {
                          $this->db->trans_rollback();
                          log_message('error', '#ERRSET000311: Updation failed in settlement_applicant RTPS Case No '.$case_no);
                          $data = array(
                                'responseType' => 0,
                                'msg' => "Error in premium update!!",
                                );
                          echo json_encode($data);
                          return;
                      }
                  }



                $fmd=array(
                            'case_no'=>$case_no,
                            'user_code'=>$this->session->userdata('user_code'),
                            'uuid'=>$basic->uuid,
                            'dag_no'=>$dag_no,
                            'zonal_valuation'=>$prem_zonal1,
                            'land_type'=>0,
                            'rate_type'=>$exist_code_by_lm,
                            'rate'=>$ratepr,
                            'amount_dag'=>$sumMbAmount,
                            'final_amount'=>$sumMbAmount,
                            'due_amount'=>$sumMbAmount,
                            'total_lessa'=>$sum_area,
                            'is_final'=>1,
                            'date_entry'=>date('Y-m-d h:i:s')

                        );

                        $insPremium = $this->db->insert('settlement_premium', $fmd);

                        if ($insPremium != 1) {
                            $this->db->trans_rollback();
                            log_message('error', '#ERRSET000101: Insertion failed in settlement_premium RTPS Case No '.$application_no);
                            $data = array(
                                'responseType' => 0,
                                'msg' => "Error in premium update",
                                );
                            echo json_encode($data);
                            return;
                        }


                //////proceeding start//////
                $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

                if ($proceeding_id==null) {
                    $proceeding_id=1;
                }

                $insPetProceed = [
                    'case_no' => $case_no,
                    'proceeding_id' => $proceeding_id,
                    'date_of_hearing' => date('Y-m-d h:i:s'),
                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                    'note_on_order' => $dag_no.'-Dag -CO has changed the proposed class',
                    'status' => 'W',
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d h:i:s'),
                    'operation' => 'E',
                    'ip' => $this->utilityclass->get_client_ip(),
                    'office_from' => 'CO',
                    'office_to' => 'CO',
                    'task' => 'CO has changed the proposed class'
                ];
                $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                // echo $this->db->last_query(); die();
                if ($insertProceeding != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :'. $case_no);
                    $data = array(
                                'responseType' => 0,
                                'msg' => "Error in proceeding update",
                                );
                    echo json_encode($data);
                    return;
                }



            $updateArrPropBasic = [
                    'co_edit'=>null
                ];
                $this->db->where('case_no', $case_no);
                $this->db->update('reclass_suite_basic', $updateArrPropBasic);

                if ($this->db->affected_rows() != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCO0004299: Failed to update');
                    $data = [
                        'responseType' => 0,
                        'msg' => '#ERRCO0004299: Failed to update. Kindly contact system administrator',
                    ];
                    echo json_encode($data);
                    return false;
                }



            $this->db->trans_commit();
            /**** if data intserted successfully*/
            $data = array(
                'responseType' => 2,
                //'appnData' => $applicantDetailsArr,
                'msg' => "Class information updated successfully...",
            );
            echo json_encode($data);
    }



    /// NEW LIST FOR RE_GEOTAG ----------------07072025
    public function reGeoTagCaseList()
    {
        // exit;
        $service_code = $this->input->get('service');
        $status = 'Z'; // in query it is checked as not equal to Z status/////
        $data['select_data'] = $this->reclassModel->locationSelectReGeotagReclass($service_code, $status);
        $data['_view'] = 'reclass_suite/co/settlement_mb_re_geotag_recls';
        $this->load->view('layouts/main', $data);
    }

    public function paginationForReGeoTagRecls()
    {

        if(LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO'){
            $lot_string = $this->caseListUnderMappingLot();
        }

        $s_code = $this->input->post('service');
        $search_term = $this->input->post('search_term');
        $remark_cat = $this->input->post('remark_cat');
        $reverted = $this->input->post('reverted');
        $user_code = $this->session->userdata('user_code');

        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');

        $status = $this->input->post('status');
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');
        $col = 0;
        $dir = "";
        $search = $this->input->post('search');
        $search = $search['value'];

        $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
        $searchByCol_1 = $this->input->post('columns')[1]['search']['value'];
        $searchByCol_3 = $this->input->post('columns')[3]['search']['value'];

        $is_cat = $this->input->post('is_category');

        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }

        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'asc';
        }

        $valid_columns = array(
            0 => 'date_entry',
            // 1   => 'applid',
        );

        if (!isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }

        if ($order != null) {
            $this->db->order_by($order, $dir);
        }

        if (!empty($searchByCol_0)) {

            $this->db->like('a.case_no', strtoupper($searchByCol_0));
        }

        if (!empty($searchByCol_1)) {

            $this->db->like('a.applid', strtoupper($searchByCol_1));
        }

        if (!empty($searchByCol_3)) {
            $this->db->like('TO_CHAR(a.date_entry,\'yyyy-mm-dd\')', $searchByCol_3);
            //$this->db->like('date_entry', $searchByCol_2);
        }

        $this->db->limit($length, $start);

        $this->db->where('a.service_code', $s_code);


        if(!empty($mouza_pargona_code))
        {
            $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
        }

        if(!empty($mouza_pargona_code) && !empty($lot_no))
        {
            $this->db->where('a.lot_no', $lot_no);
        }

        if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat)) {
            $this->db->where('a.vill_townprt_code', $is_cat);
        }



        if ($this->session->userdata('user_desig_code') == 'CO'){
            // $this->db->where("(a.co_code = '".$user_code."' or a.co_code is null)");
            if(LOT_BIFURCATE ==1 && empty($mouza_pargona_code) && empty($lot_no)){
                if(isset($lot_string) && $lot_string != null)
                {
                    $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                }
            }

            // $this->db->orWhere('a.co_code', null);
        }



        $this->db->select('distinct(a.case_no), a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry,a.re_geotag_status,a.status');

        $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
        $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('a.cir_code', $this->session->userdata('cir_code'));

        $this->db->from('reclass_suite_basic a');
        $this->db->join('supportive_document b', 'a.case_no = b.case_no or a.applid = b.case_no');
        $query = $this->db->get();


        log_message('error',"Query for Sel=======".$this->db->last_query());
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {

                $khas_ins_link = '<a type="button" href="#" onclick="reGeotagIns(\''.$rows->case_no.'\',\''.$rows->applid.'\')" class="btn-sm btn btn-primary">
                    <i class="fa fa-map-marker" aria-hidden="true"></i> Enable Re-Geotag</a>';
                if(trim($rows->re_geotag_status) == 1)
                {
                    $re_geotag_status = 'Requested For Re-Geotag';
                    $khas_ins_link = '--';

                }
                elseif(trim($rows->re_geotag_status) == 2)
                {
                    $re_geotag_status = 'Re-Geotag Done';
                }
                else
                {
                    $re_geotag_status = 'N/A';
                }
                $status = '<b class="text-warning">On Process</b>';
                if(trim($rows->status) == 'D'){
                    $status = '<b class="text-danger">Rejected</b>';
                }

                $json[] = array(
                    '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                    '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',

                    $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),

                    $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    // $rows->date_entry,
                    date("Y-m-d", strtotime($rows->date_entry)),
                    $status,
                    $re_geotag_status,

                    $s_code == RECLASS_ID ? $khas_ins_link : "NA"
                );
            }

            $this->db->where('a.service_code', $s_code);




            if ($this->session->userdata('user_desig_code') == 'CO'){
                // $this->db->where('a.co_code', $user_code);
                // $this->db->where("(a.co_code = '".$user_code."' or a.co_code is null)");
                if(LOT_BIFURCATE ==1 && empty($mouza_pargona_code) && empty($lot_no)){

                    if(isset($lot_string) && $lot_string != null)
                    {
                        $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                    }
                }
            }



            if(!empty($mouza_pargona_code))
            {
                $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
            }

            if(!empty($mouza_pargona_code) && !empty($lot_no))
            {
                $this->db->where('a.lot_no', $lot_no);
            }

            if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat)) {
                $this->db->where('a.vill_townprt_code', $is_cat);
            }

            // $this->db->distinct();
            $this->db->select('a.case_no');
            $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
            $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
            $this->db->where('a.cir_code', $this->session->userdata('cir_code'));
            $this->db->join('supportive_document b', 'a.case_no = b.case_no or a.applid = b.case_no');
            $this->db->group_by('a.case_no');

            // $query1 = $query->num_rows();
            $this->db->from('reclass_suite_basic a');
            $query = $this->db->get();
            log_message("error","Count Query==========".$this->db->last_query());
            $total_records =$query->num_rows();
            $response = array(
                'draw' => $draw,
                'recordsTotal' => $total_records,
                'recordsFiltered' => $total_records,
                'data' => $json,
            );

            echo json_encode($response);

        } else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }


     public function checkWhetherGeoTagorNot()
    {
        $case_no = $this->input->post('case_no');
        $applid = $this->input->post('applid');

        if($case_no == null && $applid == null){
            echo json_encode([
                'responseType' => 3,
                'msg' => '#ERRREGEO0002: Enable Re-geotag cancelled...!case no missing',
            ]);
            return false;
        }
        $url = API_LINK_MB3."requestRegeo";

        $arrayData =array(
            'application' => $applid,
        );
        log_message("error","MB001: CALLING URL=======".$url."===PARAMETER===".json_encode($arrayData));
        //*****API call again for geotag available */
        $getAvailable = $this->utilityclass->curlPost($url, $arrayData);


        if(isset($getAvailable) && !empty(json_decode($getAvailable)) && trim(json_decode($getAvailable)->status) == 'y'){
             //*****update in settlement_basic */
            $basicArray = [
                're_geotag_status'   => 1
            ];
            $this->db->where('case_no', $case_no);
            $this->db->update('reclass_suite_basic', $basicArray);
            if($this->db->affected_rows() !=1)
            {
                log_message('error', '#ERRREGEOINS0001: Updating failed in reclass_basic and query is: ' . $this->db->last_query());
                echo json_encode([
                    'responseType' => 3,
                    'msg' => '#ERRREGEOINS0001: Enable Re-geotag cancelled...!',
                ]);
                return false;
            }
            if($this->db->affected_rows() == 1 && trim(json_decode($getAvailable)->status) == 'y') {
                echo json_encode([
                    'responseType' => 2,
                    'msg' => 'Requested for Re-geotag for the case no --'.$case_no,
                ]);
                return false;
            }


        }else{
            log_message('error', '#ERRREGEOINS0003: Fetching data error');
            echo json_encode([
                'responseType' => 3,
                'msg' => '#ERRREGEOINS0003: Fetching data error',
            ]);
            return false;
        }

    }


      public function confirmPaymentCoFinal()
    {

        $case_no = $_GET['case_no'] = dec_param($this->input->get('case'), 'case_no');
        if($_GET['case_no'] == null)
        {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
            return;
        }

        $allowed = ['CO'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }
        $get_settlement_basic = $this->reclassModel->getSettlementBasicCo($case_no);
        // var_dump($get_settlement_basic); die();
        $case_no_rtps = $get_settlement_basic->applid;
        // payment status check thourgh API
        $payment_status_check = $this->basundhara3Model->paymentConfirmation($case_no_rtps);
        $get_settlement_prem = $this->reclassModel->getSettlementPremium($case_no);
        $get_dags = $this->reclassModel->getElligibleDags($case_no);
        // var_dump($get_settlement_prem->final_amount);
       

        $data = [
            'case_no' => $case_no,
            'case_no_rtps'=>$case_no_rtps,
            'get_dags'=>$get_dags
        ];

        $data['_view'] = 'reclass_suite/co/confirmFinalChithaCO';
         $this->load->view('layouts/main', $data);
    }



     // get payment generation page
    public function regeneratePayment()
    {
        // $_POST        = json_decode(file_get_contents("php://input"), true);
        $final_amount = $this->input->post('final_amount');
        $due_amount   = $this->input->post('due_amount');
        $case_no      = $this->input->post('case_no_notice');

        $get_settlement_basic     = $this->reclassModel->getSettlementBasic($case_no);
        $get_settlement_applicant = $this->reclassModel->getAllApplicant($case_no);
        $get_owners               = $this->reclassModel->getAllApplicantOwners($case_no);
        $get_buyers               = $this->reclassModel->getMainApplicantPayment($case_no);
        $get_dag_details          = $this->reclassModel->getSettlementDag($case_no);
        $get_land_class_details   = $this->reclassModel->getLandcLassdetails($case_no);
        //var_dump($get_land_class_details->exit_lc_by_lm);exit;

        if (empty($get_buyers) || $get_buyers == null || $get_buyers == '') {
            $this->session->set_flashdata('message', "#ERR5930: Unable to generate payment notice for case #".$case_no);
            redirect(base_url().'index.php/TeaGrantControllerAdc/viewAllGeneratedNoticeTeaGrantAdcCaseList');
        }

        // $premium_data = $this->db->query("SELECT sp.*, spa.area, spl.land_type, spr.house_type FROM
        //                   settlement_premium sp LEFT OUTER JOIN settlement_premium_area spa
        //                     ON spa.paid=sp.area_name LEFT OUTER JOIN settlement_premium_land_type spl
        //                       ON spl.plid=sp.land_type LEFT OUTER JOIN settlement_premium_rate spr
        //                         ON spr.prid=sp.rate_type WHERE case_no=? and is_final=?",
        //                           array($case_no, 1))->result();

        $premium_data = $this->db->query("SELECT sp.*,sp.penalty_rate as pr,rd.* from settlement_premium sp
            join reclass_dag_details rd on sp.case_no=rd.case_no and sp.dag_no=rd.dag_no WHERE sp.case_no=? and is_final=?",
            array($case_no, 1))->result();

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3 . "getApplicationDate");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'application_no' => $this->utilityclass->getApplidFromCaseNoReclass($case_no),
        )));
        $output = curl_exec($curl_handle);
        if (isset(json_decode($output)->responseType)) {
            if (json_decode($output)->responseType != 'y') {
                echo json_decode($output)->data . " - Unauthorized access!";
                return false;
            }
        }
        curl_close($curl_handle);
        $res = json_decode($output);


        // echo "<pre>"; var_dump($get_buyers); die;

        $data = [
            'payment_amount'           => $final_amount,
            'case_no'                  => $case_no,
            'get_settlement_basic'     => $get_settlement_basic,
            'get_dag_details'          => $get_dag_details,
            'get_owners'               => $get_owners,
            'get_buyers'               => $get_buyers,
            'get_settlement_applicant' => $get_settlement_applicant,
            'pay_notice_date'          => date('Y-m-d'),
            'premium_data'             => $premium_data,
            'date_of_application'      => date('d/m/Y', strtotime($res->submission_date)),
            'get_land_class_details'   => $get_land_class_details
        ];

        $this->load->view('reclass_suite/co/paymentreCalculate', $data);

    }





    public function getRateCO($exist_code,$proc_lc_code,$dag_no,$case_no,$nature_possession)
    {

        if($exist_code==1 && $nature_possession!=1)
        {
            // $json[] = array('prid' => 0, 'rate' => 0,'msg' =>'Penalty Case , Dag can not be recommended!!');
            // echo json_encode($json);
            // return;

            $prop_lc_det = $this->db->query("select landclass_category_id from land_class_groups 
            where id=?",array($proc_lc_code))->row();
            $proc_lc_cat_code = $prop_lc_det->landclass_category_id;

            $lands = $this->db->query("select prid,rate from reclass_premium_rate 
            where exist_code='$exist_code' and prop_code='$proc_lc_cat_code' order by prid");

            $data = $lands->result();

            $case_no = str_replace("_", "/", $case_no);

            $sum_area = 0;

            $sql = $this->db->query("SELECT * FROM reclass_dag_eligibility  WHERE case_no = ? and dag_no = ? and is_agri_to_nonagri = ? and is_eligible = ? and status = ?", array($case_no,$dag_no,'Y','N',0));

            //echo $this->db->last_query();

            if ($sql->num_rows()>=1) 
            {
                $json[] = array('prid' => 0, 'rate' => 0, 'msg' =>'Not Recommended','is_penalty' =>'N','total_lessa'=>'0');
                echo json_encode($json);
                return;
            }

            else
            {

                $sql_dag = $this->db->query("SELECT * FROM reclass_dag_details  WHERE case_no = ? and dag_no = ?", array($case_no,$dag_no));
                $part_data = $sql_dag->row();



                if($part_data->co_is_partition=='Y' && $part_data->co_is_full_partition=='N')
                {
                    if(in_array($d->dist_code, json_decode(BARAK_VALLEY)))
                    {
                    $dag_area =$this->db->query("SELECT sum(co_area_b*6400+co_area_k*320+co_area_lc*20+co_area_g) as sarea
                        from reclass_dag_details where dag_no = ? and case_no = ?",array($d->dag_no,$case_no))->row();
                    }
                    else
                    {
                    $dag_area =$this->db->query("SELECT sum(co_area_b*100+co_area_k*20+co_area_lc) as sarea
                        from reclass_dag_details where dag_no = ? and case_no = ?",array($d->dag_no,$case_no))->row();
                    }

                    $sum_area+= $dag_area->sarea;
                }


                else
                {

                $sql2 = $this->db->query("SELECT * FROM reclass_suite_basic  WHERE case_no = ? ", array($case_no));
                $data2 = $sql2->row();


                $dist_code = $this->session->userdata('dist_code');
                if(in_array($dist_code, json_decode(BARAK_VALLEY)))
                {
                    $dag_area = $this->db->query("SELECT sum(dag_area_b*6400+dag_area_k*320+dag_area_lc*20+dag_area_g) as sarea FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($data2->dist_code, $data2->subdiv_code, $data2->cir_code, $data2->mouza_pargona_code, $data2->lot_no, $data2->vill_townprt_code, $dag_no))->row();
                }
                else
                {
                    $dag_area = $this->db->query("SELECT sum(dag_area_b*100+dag_area_k*20+dag_area_lc) as sarea FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($data2->dist_code, $data2->subdiv_code, $data2->cir_code, $data2->mouza_pargona_code, $data2->lot_no, $data2->vill_townprt_code, $dag_no))->row();
                }

                // if($dag_area->sarea!=$total_lessa)
                // {
                //     //return false;
                //     $json[] = array('prid' => 0, 'rate' => 0, 'msg' =>'Check details again!!','is_penalty' =>'Y','total_lessa' => $sum_area);
                //     echo json_encode($json);
                //     return;
                // }

                $sum_area = $dag_area->sarea;
            }
            }

            // $sql2 = $this->db->query("SELECT * FROM reclass_dag_details  WHERE case_no = ? and dag_no = ? ", array($case_no,$dag_no));
            // $data2 = $sql2->row();


            // if(isset($data2))
            // {
            //     $sum_area = 0;
            //     if($data2->is_partition=='Y' && $data2->is_full_partition=='N')
            //         {
            //             $dist_code = $this->session->userdata('dist_code');
            //             if(in_array($dist_code, json_decode(BARAK_VALLEY)))
            //             {
            //                 $dag_area =$this->db->query("SELECT sum(lm_area_b*6400+lm_area_k*320+lm_area_lc*20+lm_area_g) as sarea
            //                 from reclass_dag_details where dag_no = ? and case_no = ?",array($dag_no,$case_no))->row();
            //             }
            //             else
            //             {
            //                 $dag_area =$this->db->query("SELECT sum(lm_area_b*100+lm_area_k*20+lm_area_lc) as sarea
            //                 from reclass_dag_details where dag_no = ? and case_no = ?",array($dag_no,$case_no))->row();
            //             }

            //             $sum_area = $dag_area->sarea;
            //         }
            //     else
            //         {
            //             $dist_code = $this->session->userdata('dist_code');
            //             if(in_array($dist_code, json_decode(BARAK_VALLEY)))
            //             {
            //                 $dag_area = $this->db->query("SELECT sum(dag_area_b*6400+dag_area_k*320+dag_area_lc*20+dag_area_g) as sarea FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($data2->dist_code, $data2->subdiv_code, $data2->cir_code, $data2->mouza_pargona_code, $data2->lot_no, $data2->vill_townprt_code, $dag_no))->row();
            //             }
            //             else
            //             {
            //                 $dag_area = $this->db->query("SELECT sum(dag_area_b*100+dag_area_k*20+dag_area_lc) as sarea FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($data2->dist_code, $data2->subdiv_code, $data2->cir_code, $data2->mouza_pargona_code, $data2->lot_no, $data2->vill_townprt_code, $dag_no))->row();
            //             }

            //             $sum_area = $dag_area->sarea;

            //         }
            // }

            if($exist_code==1 && $proc_lc_cat_code==2)
            {
                $dist_code = $this->session->userdata('dist_code');
                if(in_array($dist_code, json_decode(BARAK_VALLEY)))
                {
                    if($sum_area<6400)
                    {
                        $json = array();
                        foreach ($data as $object) {
                        $json[] = array('prid' => trim($object->prid), 'rate' => 0, 'msg' =>'Recommended:No premium','is_penalty' =>'N','total_lessa' => $sum_area);
                    }
                    }
                    else
                    {
                        $json = array();
                        foreach ($data as $object) {
                        $json[] = array('prid' => trim($object->prid), 'rate' => trim($object->rate), 'msg' =>'Penalty Case !!','is_penalty' =>'Y','total_lessa' => $sum_area);
                        }
                    }
                }
                else
                {
                    if($sum_area<100)
                    {
                        $json = array();
                        foreach ($data as $object) {
                        $json[] = array('prid' => trim($object->prid), 'rate' => 0, 'msg' =>'Recommended:No premium','is_penalty' =>'N','total_lessa' => $sum_area);
                    }
                    }
                    else
                    {
                        $json = array();
                        foreach ($data as $object) {
                        $json[] = array('prid' => trim($object->prid), 'rate' => trim($object->rate), 'msg' =>'Penalty Case !!','is_penalty' =>'Y','total_lessa' => $sum_area);
                        }
                    }
                }
            }
            else
            {
                $json = array();
                foreach ($data as $object) {
                $json[] = array('prid' => trim($object->prid), 'rate' => trim($object->rate), 'msg' =>'Penalty Case !!','is_penalty' =>'Y','total_lessa' => $sum_area);
                }
            }
            //var_dump($json);
            echo json_encode($json);
            return;
        }


        $case_no = str_replace("_", "/", $case_no);

        $sql = $this->db->query("SELECT * FROM reclass_dag_eligibility  WHERE case_no = ? and dag_no = ? and is_agri_to_nonagri = ? and is_eligible = ? and status = ?", array($case_no,$dag_no,'Y','N',0));

        //echo $this->db->last_query();

        if ($sql->num_rows()>=1) 
        {
            $json[] = array('prid' => 0, 'rate' => 0, 'msg' =>'Not Recommended','is_penalty' =>'N','total_lessa'=>'0');
            echo json_encode($json);
            return;
        }

        else
        {
            $prop_lc_det = $this->db->query("select landclass_category_id from land_class_groups 
            where id=?",array($proc_lc_code))->row();
            $proc_lc_cat_code = $prop_lc_det->landclass_category_id;

            $lands = $this->db->query("select prid,rate from reclass_premium_rate 
            where exist_code='$exist_code' and prop_code='$proc_lc_cat_code' order by prid");

            $data = $lands->result();

            $sum_area = 0;
            $sql_dag = $this->db->query("SELECT * FROM reclass_dag_details  WHERE case_no = ? and dag_no = ?", array($case_no,$dag_no));
                $part_data = $sql_dag->row();



                if($part_data->co_is_partition=='Y' && $part_data->co_is_full_partition=='N')
                {
                    if(in_array($d->dist_code, json_decode(BARAK_VALLEY)))
                    {
                    $dag_area =$this->db->query("SELECT sum(co_area_b*6400+co_area_k*320+co_area_lc*20+co_area_g) as sarea
                        from reclass_dag_details where dag_no = ? and case_no = ?",array($d->dag_no,$case_no))->row();
                    }
                    else
                    {
                    $dag_area =$this->db->query("SELECT sum(co_area_b*100+co_area_k*20+co_area_lc) as sarea
                        from reclass_dag_details where dag_no = ? and case_no = ?",array($d->dag_no,$case_no))->row();
                    }

                    $sum_area+= $dag_area->sarea;
                }

            else
            {

                $sql2 = $this->db->query("SELECT * FROM reclass_suite_basic  WHERE case_no = ? ", array($case_no));
                $data2 = $sql2->row();

                $dist_code = $this->session->userdata('dist_code');
                if(in_array($dist_code, json_decode(BARAK_VALLEY)))
                {
                    $dag_area = $this->db->query("SELECT sum(dag_area_b*6400+dag_area_k*320+dag_area_lc*20+dag_area_g) as sarea FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($data2->dist_code, $data2->subdiv_code, $data2->cir_code, $data2->mouza_pargona_code, $data2->lot_no, $data2->vill_townprt_code, $dag_no))->row();
                }

                else
                {
                $dag_area = $this->db->query("SELECT sum(dag_area_b*100+dag_area_k*20+dag_area_lc) as sarea FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($data2->dist_code, $data2->subdiv_code, $data2->cir_code, $data2->mouza_pargona_code, $data2->lot_no, $data2->vill_townprt_code, $dag_no))->row();
                }

                // if($dag_area!=$total_lessa)
                // {
                //     return false;
                // }

                $sum_area = $dag_area->sarea;
            }

            // var_dump($proc_lc_cat_code);exit;

            if($exist_code==1 && $proc_lc_cat_code==2)
            {
                if($sum_area<100)
                {
                    $json = array();
                    foreach ($data as $object) {
                    $json[] = array('prid' => trim($object->prid), 'rate' => 0, 'msg' =>'Recommended:No premium','is_penalty' =>'N','total_lessa' => $sum_area);
                }
                }

                else
                {
                    $json = array();
                    foreach ($data as $object) {
                    $json[] = array('prid' => trim($object->prid), 'rate' => trim($object->rate), 'msg' =>'Recommended','is_penalty' =>'N','total_lessa' => $sum_area);
                }
                }
            }

            else
            {
            $json = array();
            foreach ($data as $object) {
                $json[] = array('prid' => trim($object->prid), 'rate' => trim($object->rate), 'msg' =>'Recommended','is_penalty' =>'N','total_lessa' => $sum_area);
            }
            }
            //var_dump($json);
            echo json_encode($json);
        }
    }


    public function updateRevenueLoctax()
    {

        $dag_nos     = $this->input->post('dag_no');
        $case_nos    = $this->input->post('case_no');
        $P_land_rev  = $this->input->post('P_land_rev');
        $p_local_tax = $this->input->post('p_local_tax');


        $errors = [];

        foreach ($P_land_rev as $key => $value) {
            if (trim($value) === '') {
                $errors[] = "Land revenue at row " . ($key + 1) . " is required.";
            }
        }

        if (!empty($errors)) {
            echo json_encode([
                'error' => "#ERRSETCHUP001:<p>" . implode('<br>', $errors) . "</p>#case_no : " . $case_nos,
            ]);
            return false;
        }

        $this->db->trans_begin();

        foreach ($dag_nos as $index => $dagNo) {
            $result = $this->reclassModel->update_dag_entry([
                'case_no'            => $case_nos,
                'dag_no'             => $dagNo,
                'proposed_land_rev'  => $P_land_rev[$index],
                'proposed_local_tax' => $p_local_tax[$index]
            ]);
        }

         
        $this->db->trans_commit();

        $sql = $this->db->query("select is_dlc_req from reclass_suite_basic where case_no='$case_nos'")->row();
        
        if($sql->is_dlc_req=='N')
        {
            redirect(base_url() . "index.php/ReclassSuiteControllerCO/confirmPaymentCoFinal?case=" . enc_param('case_no', $case_nos, 600));
        }
        else
        {
            redirect(base_url() . "index.php/ReclassSuiteControllerCO/confirmPaymentCo?case=" . enc_param('case_no', $case_nos, 600));
        }

    }


    public function updateChitha()
    {
        $case_no = $this->input->post('case_no');

        $this->form_validation->set_rules('case_no', 'Case no', 'trim|required');

        if ($this->form_validation->run() == false) {
            $data = array(
                'error' => "#ERRSETCHUP001:" . validation_errors() . "#case_no : " . $case_no,
            );
            echo json_encode($data);
            return false;
        }

        $this->db->trans_begin();

        $get_settlement_basic2        = $this->reclassModel->getReclassBasicCo($case_no);

        $dags                         = $this->reclassModel->getElligibleDags($case_no);

        foreach ($dags as $dagsland)
        {
            $proposed_rev = $dagsland->proposed_land_rev;
            $proposed_ltax = $dagsland->proposed_local_tax;


            if (($proposed_rev==null && $proposed_ltax==null) || ($proposed_rev==0 && $proposed_ltax==0))
            {
            $this->db->trans_rollback();
            log_message('error', '#ERRSETCHUP002: Revenue and local tax is not updated Case No ' . $case_no);
            $data = array(
                'error' => "#ERRSETCHUP002: Revenue should be updated first: " . $case_no
            );
            echo json_encode($data);
            return false;
            }
        }


        $get_settlement_dag= $this->reclassModel->getSettlementDagforPartition($case_no);

        $get_settlement_applicant= $this->reclassModel->getAllEligibleApplicantPartitionPartial($case_no);

        $get_ekyc_applicant= $this->reclassModel->getMainApplicantPayment($case_no);

        $get_settlement_prem = $this->reclassModel->getSettlementPremium($case_no);

        $get_settlement_proceeding = $this->reclassModel->getSettlementProceedingbyLM($case_no);


        if($get_settlement_basic2->is_payment_req =='N')
        {
            $grn_no         = null;
            $paymnet_date   = null;
            $amount         = null;
        }

        else
        {
            $grn_no         = $get_settlement_prem->grn_no;
            $paymnet_date   = $get_settlement_prem->payment_date;
            $amount         = $get_settlement_prem->final_amount;
        }



        $ekyc_pdar_list = array();
        foreach($get_ekyc_applicant as $appl)
            {

                // $nested3['pdar_id']              = $appl->pdar_id;
                // $nested3['patta_no']             = $appl->patta_no;
                // $nested3['dag_no']               = $appl->dag_no;
                // $nested3['pdar_name']            = $appl->pdar_name;
                // $nested3['identity_ref_no']      = $appl->identity_ref_no;
                // $nested3['identity_type']        = $appl->identity_type;

                // $ekyc_pdar_list[]=$nested3;

                 $nested3 = [
                        'pdar_id'               => $appl->pdar_id,
                        'dag_no'                => $appl->dag_no,
                        'patta_no'              => $appl->patta_no,
                        'pdar_name'             => $appl->pdar_name,
                        'identity_ref_no'       => $appl->identity_ref_no,
                        'identity_type'         => $appl->identity_type,
                        'pdar_guardian'         => $appl->pdar_guardian,
                        'pdar_relation'         => $appl->pdar_rel_guar,
                    ];

                    // Grouping by dag_no
                    $ekyc_pdar_list[$appl->dag_no][] = $nested3;

            }


        $location = [
            'dist_code'=>$get_settlement_basic2->dist_code,
            'subdiv_code'=>$get_settlement_basic2->subdiv_code,
            'cir_code'=>$get_settlement_basic2->cir_code,
            'mouza_pargona_code'=>$get_settlement_basic2->mouza_pargona_code,
            'lot_no'=>$get_settlement_basic2->lot_no,
            'vill_townprt_code'=>$get_settlement_basic2->vill_townprt_code,
        ];

            $dags_list = array();
            $pattadar_list = array();
            foreach($dags as $dag)
            {

                if($dag->co_is_partition=='Y' && $dag->co_is_full_partition=='N')
                {
                    $partition = 'P';
                    $dag_area_b = $dag->co_area_b;
                    $dag_area_k = $dag->co_area_k;
                    $dag_area_lc = $dag->co_area_lc;
                    $dag_area_g = $dag->co_area_g;
                    $dag_area_kr = 0;
                }

                else if($dag->co_is_partition=='Y' && $dag->co_is_full_partition=='Y')
                {
                    $partition = 'F';
                    $dag_area_b = $dag->co_area_b;
                    $dag_area_k = $dag->co_area_k;
                    $dag_area_lc = $dag->co_area_lc;
                    $dag_area_g = $dag->co_area_g;
                    $dag_area_kr = 0;
                }

                else
                {
                  $partition = 'N';
                  $dag_area_b = $dag->dag_area_b;
                  $dag_area_k = $dag->dag_area_k;
                  $dag_area_lc = $dag->dag_area_lc;
                  $dag_area_g = $dag->dag_area_g;
                  $dag_area_kr = 0;
                }

                


                $nested['dag_no'] = $dag->dag_no;
                $nested['patta_no'] = $dag->patta_no;
                $nested['patta_type_code'] = $dag->patta_type_code;
                $nested['full_part_dag'] = $partition;
                $nested['old_land_class'] = $dag->land_class_code;
                $nested['new_land_class'] = $dag->proposed_land_class_code;
                $nested['applied_b'] = $dag_area_b;
                $nested['applied_k'] = $dag_area_k;
                $nested['applied_lc'] = $dag_area_lc;
                $nested['applied_g'] = $dag_area_g;
                $nested['revenue'] = $dag->proposed_land_rev;
                $nested['local_tax'] = $dag->proposed_local_tax;

                $dags_list[]=$nested;
            }

            if(isset($get_settlement_applicant))
            {

                foreach($get_settlement_applicant as $pattadar)
                {

                    $nested1 = [
                        'pdar_id' => $pattadar->pdar_id,
                        'dag_no' => $pattadar->dag_no,
                        'retain_old_dag' => $pattadar->retain_old_dag == '1' ? true : false
                    ];



                    // Grouping by dag_no
                    $pattadar_list[$pattadar->dag_no][] = $nested1;

                }
            }

            $meeting_info = $this->getMeetingNo($case_no);

            if($meeting_info=='NOT-FOUND')
            {
            $meeting_name = 'NA';
            $dc_date = $get_settlement_basic2->date_update;
            }
            else
            {
            $meeting_name = $meeting_info->meeting_name;
            $dc_date = $meeting_info->digital_sign_date;
            }



            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3 . "getApplicationDate");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application_no' => $this->utilityclass->getApplidFromCaseNoReclass($case_no),
            )));
            $output = curl_exec($curl_handle);
            if (isset(json_decode($output)->responseType)) {
                if (json_decode($output)->responseType != 'y') {
                    echo json_decode($output)->data . " - Unauthorized access!";
                    return false;
                }
            }
            curl_close($curl_handle);
            $res = json_decode($output);
            $params = [
                'case_no'           =>$get_settlement_basic2->case_no,
                'service_code'      => RECLASS_ID,
                'approve_by'        =>$get_settlement_basic2->approve_by,
                'dc_order_no'       =>$meeting_name,
                'dc_order_date'     =>$dc_date,
                'dept_order_no'     =>$get_settlement_basic2->dept_order_no,
                'dept_order_date'   =>$get_settlement_basic2->dept_order_date,
                'rtps_ref_no'       =>$get_settlement_basic2->applid,
                'grn_no'            =>$grn_no,
                'payment_date'      =>$paymnet_date,
                'lm_code'           =>$get_settlement_proceeding->user_code,
                'lm_date'           =>$get_settlement_proceeding->date_entry,
                'amount'            =>$amount,
                'date_of_application' => date('d/m/Y', strtotime($res->submission_date)),
                'location'          => $location,
                'dags'              => $dags_list,
                'pattadar'          => $pattadar_list,
                'all_pattadar'      => $ekyc_pdar_list,

            ];
            $this->db->trans_begin();
            $this->load->model('ChithaUpdateModel');
            $response=$this->ChithaUpdateModel->reclassFinalOrder($case_no,$params);
            // var_dump($response);
            $result=json_decode($response);
            if($result->responseType==2){
                $this->db->trans_commit();
                // $this->db->trans_rollback();
            }else{
                $this->db->trans_rollback();
            }
            echo $response;
    }


    public function getMeetingNo($dhar_case_no)
    {
        $query = $this->db->query("SELECT * FROM settlement_proposal_cases A
         JOIN settlement_proposal_list B ON B.id=A.proposal_id
         JOIN proposal_meeting_list C ON C.id=B.proposal_meeting_id
         WHERE A.case_no = ?", [$dhar_case_no]);

        if ($query->num_rows() != 0) {
            return $query->row();
        } else {
            return "NOT-FOUND";
        }
    }


        public function manualPaymentDetailsSubmitHandle()
    {
        //***********************************************************************/
        // file validation
        if (isset($_FILES['manual_chalan']['name'])) {
            if ($_FILES['manual_chalan']['name'] && $_FILES['manual_chalan']['size'] && $_FILES['manual_chalan']['tmp_name']) {
                $name = $_FILES['manual_chalan']['name'];
                $size = $_FILES['manual_chalan']['size'];
                $mime = mime_content_type($_FILES['manual_chalan']['tmp_name']);
                $exp = explode("/", $mime);
                $ext = $exp[1];
                if ($name != null) {
                    if ($ext == null) {
                        echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Invalid Challan, Please Upload Correctly, ERR-#SMCPF001']);
                        exit;

                    }
                    if ($ext != 'pdf') {
                        echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Invalid Challan, Please Upload Pdf Only, ERR-#SMCPF002']);
                        exit;
                    }
                    if ($size > UPLOAD_MAX_SIZE) {
                        echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Invalid Challan, Please Upload Challan Less Than 5mb, ERR-#SMCPF003']);
                        exit;
                    }
                } else {
                    echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Please Upload The Challan, ERR-#SMCPF004']);
                    exit;
                }
            } else {
                echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Please Upload The Challan, ERR-#SMCPF005']);
                exit;
            }
        } else {
            echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Please Upload The Challan, ERR-#SMCPF006']);
            exit;
        }
        //***********************************************************************/
        // post field validation
        $error_msg = array();
        $manual_challan_validation_arr = [
            [
                'field' => 'grn_no',
                'label' => 'GRN-NO',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[45]',
            ],
            [
                'field' => 'amount',
                'label' => 'Amount',
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric',
            ],
            [
                'field' => 'payment_date',
                'label' => 'Payment-Date',
                'rules' => 'required|callback_check_script|trim|xss_clean|callback_date_valid',
            ],
            [
                'field' => 'case_no',
                'label' => 'Case-No',
                'rules' => 'required|callback_check_script|trim|xss_clean',
            ],

        ];
        $this->form_validation->set_rules($manual_challan_validation_arr);
        $this->form_validation->set_message('check_script', 'Please Fill The %s Correctly!');
        $this->form_validation->set_message('date_valid', 'Please Fill The %s Correctly!');
        if ($this->form_validation->run() == false) {
            foreach ($manual_challan_validation_arr as $rule) {
                if (form_error($rule['field'])) {
                    array_push($error_msg, form_error($rule['field']));
                }
            }
        }
        if (count($error_msg) != 0) {
            echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => $error_msg]);
            exit;
        }
        //***********************************************************************/
        $sql = "select applid from reclass_suite_basic sb where case_no=?";
        $query = $this->db->query($sql, array($_POST['case_no']));
        if ($query->num_rows() != 1) {
            echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => 'Some error occured, Error-Code : #smcu0045']);
            exit;
        }

        $paymentDate = $_POST['payment_date'];
        if (date('Y-m-d H:i:s', strtotime(MANUAL_MAX_PAYMENT_DATE)) < date('Y-m-d H:i:s', strtotime($paymentDate))) {
            echo json_encode(['result' => 'FAILED', 'msg' => 'Payment date cannot be greater then ' . MANUAL_MAX_PAYMENT_DATE_SHOW]);
            exit;
        }

        $application_no = $query->row()->applid;
        $sql = "select pid,due_amount from settlement_premium where case_no=? and is_final=1";
        $query = $this->db->query($sql, array($_POST['case_no']));
        $result = $query->result();
        $sp_row_count = count($result);
        //***********************************************************************/
        if ($sp_row_count == 0) {
            echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => 'Some error occured, Error-Code : #smcu003']);
            exit;
        }
        //***********************************************************************/
        $due_amount = $result[0]->due_amount;
        $remaining_amount = (float) $due_amount - (float) $_POST['amount'];
        if ($remaining_amount > 0) {
            echo json_encode(['result' => 'FAILED', 'msg' => 'Partial payment for reclassification is not allowed..!']);
            exit;
            // $is_full_pay = 'NO';
            // $percentage = '30';
            // //***************************************************************************/
            // //Rural Urban Checking
            // $sqlRU = "select area_name from settlement_premium where case_no=? and is_final=1";
            // $queryRU = $this->db->query($sqlRU, array($_POST['case_no']));
            // $resultRU = $queryRU->result();
            // foreach ($resultRU as $rowRU) {
            //     $area_name = trim((string) $rowRU->area_name);
            //     if ($area_name == '7' || $area_name == '8' || $area_name == '9' || $area_name == '10' || $area_name == '18' || $area_name == '19' || $area_name == '20' || $area_name == '21' || $area_name == '22') {
            //         echo json_encode(['result' => 'FAILED', 'msg' => 'Partial payment for rural area is not allowed..!']);
            //         exit;
            //     }
            // }
            //***************************************************************************/
        } else {
            $is_full_pay = 'YES';
            $percentage = '100';
        }
        //***************************************************************** */
        //file moving section
        $file_new_name = "reclass_echallan" . trim($_POST['grn_no']);
        $manual_challan_upload_dir = UPLOAD_MANUAL_CHALAN_DIR . $file_new_name;
        $file_full_path = UPLOAD_MANUAL_CHALAN_DIR . $file_new_name . ".pdf";
        move_uploaded_file($_FILES['manual_chalan']['tmp_name'], $file_full_path);
        if (!file_exists($file_full_path)) {
            log_message("error", "#smcuuf001, Error in moving file for the case_no " . $_POST['case_no']);
            echo json_encode(['result' => 'FAILED', 'msg' => 'Some error occured, Error-Code : #smcuuf001']);
            exit;
        }
        //******************************************************************/
        $this->db->trans_begin();
        $sp_update_data = [
            'grn_no' => $_POST['grn_no'],
            'payment_date' => $_POST['payment_date'],
            'is_full_pay' => $is_full_pay,
            'total_premium' => $due_amount,
            'paid_amount' => $_POST['amount'],
            'remaining_amount' => $remaining_amount,
            'tenure' => '0',
            'installment_amount' => $remaining_amount / 5,
            'manual_challan_upload_dir' => $manual_challan_upload_dir,
            'manual_challan_details' => json_encode($_POST),
            'is_manual_challan' => 'Y',
        ];
        
        $this->db->where('case_no', $_POST['case_no'])
            ->where('is_final', 1)
            ->update('settlement_premium', $sp_update_data);

        if ($this->db->affected_rows() != $sp_row_count) {
            //if no updation made
            $this->db->trans_rollback();
            log_message("error", "#smcu001, Error in update, table 'settlement_premium' with query :" . $this->db->last_query());
            echo json_encode(['result' => 'FAILED', 'msg' => 'Some error occured, Error-Code : #smcu001']);
            exit;
        }

        if ($this->db->trans_status() == false) {
            $this->db->trans_rollback();
            log_message("error", "#smcu002, Transaction Status Error In manual challan update, settlement_premium tables for case_no " . $_POST['case_no']);
            echo json_encode(['result' => 'FAILED', 'msg' => 'Some error occured, Error-Code : #smcu002']);
            exit;
        } else {
            $this->db->trans_commit();
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => API_LINK_MB3 . 'updateManualPaymentDetails',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'application_no' => $application_no,
                    'grn_no' => $_POST['grn_no'],
                    'due_amount' => $due_amount,
                    'ip_address' => $this->utilityclass->get_client_ip(),
                    'payment_date' => $_POST['payment_date'],
                    'paid_amount' => $_POST['amount'],
                    'remaining_amount' => $remaining_amount,
                    'installment_amount' => $remaining_amount / 5,
                    'percentage' => $percentage,
                ),
            ));
            $response = curl_exec($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            if ($httpcode == 200) {
                $resp = json_decode($response);
                if ($resp->result == 'SUCCESS') {
                    $this->db->trans_commit();
                    echo json_encode(['result' => 'SUCCESS', 'msg' => 'Challan Details Updated Successfully..!']);
                    exit;
                } else {
                    echo json_encode(['result' => 'FAILED', 'msg' => 'Interal Server Error, Error-Code : #smcu0034']);
                    exit;
                }

            } else {
                echo json_encode(['result' => 'FAILED', 'msg' => 'Interal Server Error, Error-Code : #smcu0035']);
                exit;
            }
        }
    }


    public function upload_kml_ajax()
{
    $case_no = $this->input->post('case_no');

    $config['upload_path']   = UPLOAD_DIR . 'reclass_Map/';
    $config['allowed_types'] = '*';
    $config['max_size']      = 2048;

    if (!is_dir($config['upload_path'])) {
        mkdir($config['upload_path'], 0777, true);
    }

    // Load upload library first
    $this->load->library('upload', $config);

    // Get the uploaded file extension dynamically
    $original_name = $_FILES['kml_file']['name'];
    $ext = pathinfo($original_name, PATHINFO_EXTENSION);

    // Sanitize and generate unique filename
    $safe_case = str_replace(['/', '\\', ' '], '_', $case_no);
    $unique_name = 'reclass_' . $safe_case . '_' . time() . '.' . $ext;

    // Set the unique name before uploading
    $this->upload->initialize(array_merge($config, ['file_name' => $unique_name]));

    if (!$this->upload->do_upload('kml_file')) {
        http_response_code(400);
        echo strip_tags($this->upload->display_errors());
    } else {
        $data = $this->upload->data();

        $document = array(
            'case_no'         => $case_no,
            'file_name'       => $data['file_name'],       // the new unique name
            'user_code'       => $this->session->userdata('user_code'),
            'fetch_file_name' => $data['client_name'],     // original name
            'file_type'       => $data['file_type'],
            'file_path'       => $config['upload_path'].$data['file_name'],
            'date_entry'      => date('Y-m-d h:i:s'),
            'mut_type'        => RECLASS_ID,
            'doc_flag'        => 'J'
        );

        $addMoreDocQuery = $this->db->insert('supportive_document', $document);

        if (!$addMoreDocQuery) {
            $this->db->trans_rollback();
            log_message('error', '#ERRADDDOC0001: Insertion failed in supportive document RTPS Case No ' . $case_no);
            $this->session->set_flashdata('message', "#ERRADDDOC0001: File upload failed for case: " . $case_no);
            redirect(base_url() . "index.php/home");
            return false;
        }

            //////proceeding start//////
            $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
            if ($proceeding_id == null) {
                $proceeding_id = 1;
            }

            $insertArr = [
                'case_no' => $case_no,
                'proceeding_id' => $proceeding_id,
                'date_of_hearing' => date('Y-m-d h:i:s'),
                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                'note_type' => 'CO uploaded map data',
                'note_on_order' => 'CO uploaded map data',
                'status' => 'W',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'CO',
                'office_to' => 'Survey',
                'task' => 'Map data upload',
            ];
            $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
            if ($insertProc != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRCO0002: Insertion failed in settlement_proceeding');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO0002: Failed to generate notice. Kindly contact System Administrator',
                ];
                echo json_encode($json);
                return false;
            }

        echo 'File uploaded successfully.';
    }
}



}
