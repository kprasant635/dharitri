<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->load->library('session');

        $this->load->model('mutation/cofieldmutationmodel');
        $this->load->model('APCancellation/APCancellationModel');
        $this->load->model('NameCorrection/NameCorrectionModel');
        if(ESCALATION_ENABLE == 1)
        {
            $this->load->model('NameCorrection/NameCorrectionModelV2');
            $this->load->model('Escalationmodel');
            $this->load->model('AutoEscalationmodel');
        }
        
        $this->load->model('NameCancellation/NameCancellationModel');
        $this->load->model('ServicePlus/ServicePlusModel');
        $this->load->helper('cookie');
        $this->load->model('dashboard');
        $this->load->model('AdcMappingWithCircleModel','circleMappingModel');
        $this->load->model('SnaReport/SnaReportModel');
        //newly added
        $this->load->model('conversion/COofficeConversionModel');
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
        $language = $this->session->userdata('language');
        if (!$this->session->userdata('language')) {
            $language = "english";
        }

        $this->load->language($language, $language);
        //$this->dbswitch();
        // var_dump($this->session->all_userdata());
        $data['profile_update_flag'] = 1;
        $user_desig = $this->session->userdata('user_desig_code');
        switch ($user_desig) {
            case 'CO':
                $this->coHome();
                break;
            case 'LM':
                $this->lmHome();
                break;
            case 'SK':
                $this->skHome();
                break;
            case 'AST':
                $this->astHome();
                break;
            case 'DC':
                $this->dcHome();
                break;
            case 'ADC':
                $this->adcHome();
                break;
            case 'LAO':
                $this->laoHome();
                break;
            case 'ADM':
                $this->MasterHome();
                break;
            case 'SA':
                $this->astHome();
                break;
            case 'BO':
                $this->BoHome();
                break;
            case 'RKG':
                $this->rkgHome();
                break;
            case 'ASO':
                $this->asoHome();
                break;
            case 'JAD':
                $this->jadHome();
                break;
            case 'SAD':
                $this->sadHome();
                break;
            case 'DEO':
                $this->deoHome();
                break;
            case 'SCN':
                $this->StateConsultantHome();
                break;
            case 'DIO':
                $this->dioHome();
                break;
            case 'MOU':
                $this->mouHome();
                break;
            case 'SDO':
                $this->sdoHome();
                break;
            case 'DCN':
                $this->cstHome();
                break;
            case 'TN':
                $this->TnHome();
                break;
        }
        $requiredParama = array(
            'session_id', 'ip_address', 'user_agent', 'last_activity', 'user_data', 'word', 'time', 'image', 'districtname', 'language', 'dist_code', 'subdiv_code', 'cir_code', 'lot_no', 'mouza_pargona_code', 'vill_townprt_code', 'user_code', 'user_desig_code', 'priv', 'message', 'first_login', 'date_of_last_password_change', 'nocuser',
        );
        unset($_SESSION['dag_det']);
        unset($_SESSION['pat_det']);
        unset($_SESSION['appdet']);
        unset($_SESSION['chitha_report']);
        unset($_SESSION['pdaridarray']);
        $sessionKeys = array_keys($this->session->all_userdata());
        $save = array();
        foreach ($sessionKeys as $p) {
            if (!in_array($p, $requiredParama)) {
                array_push($save, $p);
            }
        }
        foreach ($save as $s) {
            $this->session->unset_userdata($s);
        }
    }

    public function cstHome()
    {
        $user_code = $this->session->userdata('user_desig_code');
        $data['_view'] = 'home/cst';
        $this->load->view('layouts/main', $data);
    }

    public function mouHome()
    {
        $data['_view'] = 'home/mouzadar';
        $this->load->view('layouts/main', $data);
    }

    public function coHome()
    {
        //$this->dbswitch();
        // var_dump($this->session->all_userdata());
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page',
        );

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';

        $data['all_field'] = $this->dashboard->allMutation($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['pen_field'] = $this->dashboard->penMutation($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['del_field'] = $this->dashboard->delMutation($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['o_mut'] = $this->dashboard->ofcMutation($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['field_mut'] = $this->dashboard->fieldMutation($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['o_part'] = $this->dashboard->ofcPartition($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['field_part'] = $this->dashboard->fieldPartition($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['conversion'] = $this->dashboard->conversion($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['reclassification'] = $this->dashboard->reclassification($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['certificate'] = $this->dashboard->certificate($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['apcases'] = $this->dashboard->apcases($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['acpp'] = $this->dashboard->alotCertificate($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['settlement'] = $this->dashboard->settlement($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['misccases'] = $this->dashboard->misccases($user_desig_code, $dist_code, $subdiv_code, $cir_code);
        
        if(EKHAJANA_CO_PENDING_CONTROL == 1){
            $data['ekhajana_pending_co_cases'] = $this->utilityclass->getEkhajanaCoPendingCases($dist_code, $subdiv_code, $cir_code);
        }else{
            $data['ekhajana_pending_co_cases'] = 0;
        }


        if(CIRCLE_WISE_LAND_CLASS_AND_RATE_CHECK == 1){
            $data['co_block_flag'] = $this->utilityclass->getCoBlockFlagForLandClassAndRateUpdate($this->session->userdata('dist_code'),
            $this->session->userdata('subdiv_code'),$this->session->userdata('cir_code'));
        }
        
        $data['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from  users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
            . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();

//        $data['civil_appeal_basic'] = $this->db->query("SELECT count(*) as c from   civil_appeal_basic WHERE co_order_yn is null and chitha_correct_yn is null and status = 'P' and"
        //                . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $date_of_last_password_changed = $data['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }

        ///***********INTEGRATION OF PROFILE UPDATE CHECK***********///
        $user_details_array = array(
            'user_code' => $this->session->userdata('user_code'),
            'user_desig_code' => $user_desig_code,
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
        );
        $data['profile_update_flag'] = $this->profile_upload_check($user_details_array);
        //************END********************//
        // var_dump($data);
        // $this->load->view('header', $headtitle);
        // $this->load->view('home/co', $data);
        // $this->load->view('footer');
        //*************************************/
        $data['ekhajana_pending_count'] = $this->db->query("select count(*) from ekhajana_basic where status=?", array('COM_F'))->row()->count;

        // mb2 case pending alert
        $pending_count = $this->utilityclass->getM2PendingCount($dist_code, $subdiv_code, $cir_code);

        if ($pending_count > 0) {
            $data['show_mb2_alert'] = true;
            $data['pending_count'] = $pending_count;
        } else {
            $data['show_mb2_alert'] = false;
            $data['pending_count'] = 0;
        }
            
        $data['_view'] = 'home/co';
        $this->load->view('layouts/main', $data);
    }

    public function dashAll()
    {
        //
        // var_dump($this->session->all_userdata());
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page',
        );

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';

        $data['all_field'] = $this->dashboard->allMutationCircle($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['pen_field'] = $this->dashboard->penMutationCircle($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['del_field'] = $this->dashboard->delMutationCircle($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['o_mut'] = $this->dashboard->ofcMutationCircle($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['field_mut'] = $this->dashboard->fieldMutationCircle($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['o_part'] = $this->dashboard->ofcPartitionCircle($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['field_part'] = $this->dashboard->fieldPartitionCircle($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['conversion'] = $this->dashboard->conversionCircle($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['reclassification'] = $this->dashboard->reclassificationCircle($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['certificate'] = $this->dashboard->certificateCircle($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['apcases'] = $this->dashboard->apcasesCircle($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['acpp'] = $this->dashboard->alotCertificateCircle($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['settlement'] = $this->dashboard->settlementCircle($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['misccases'] = $this->dashboard->misccasesCircle($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from  users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
            . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();

//        $data['civil_appeal_basic'] = $this->db->query("SELECT count(*) as c from   civil_appeal_basic WHERE co_order_yn is null and chitha_correct_yn is null and status = 'P' and"
        //                . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $date_of_last_password_changed = $data['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }
        // var_dump($data);
        // $this->load->view('header', $headtitle);
        // $this->load->view('home/co', $data);
        // $this->load->view('footer');
        $data['_view'] = 'home/dashall';
        $this->load->view('layouts/main', $data);
    }

    public function asoHome()
    {
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page',
        );

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';
        $data['sronote'] = $this->db->query("SELECT * from   sro_note WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status!='3' and (deed_type='SALE' or deed_type='GIFT' )  order by update_date desc   ")->result();

//         $data['map_partition'] = $this->db->query("Select count(*) as c from  t_chitha_col8_order where map_partition is not null and "
        //                         . " order_type_code='02' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  "
        //                         . " and date(co_ord_date) >= '$define_date'  and iscorrected_inco is null")->row()->c;

//         $officemutationCount = $this->cofieldmutationmodel->countPendingMutationCases($dist_code, $subdiv_code, $cir_code);
        //         $data['fmutation'] = $officemutationCount;

//         $officepartitionCount = $this->cofieldmutationmodel->countPendingPartitionCases($dist_code, $subdiv_code, $cir_code);
        //         $data['fpartition'] = $officepartitionCount;

//         $data['opartition'] = $this->getPendingOfficePartitionCases($dist_code, $subdiv_code, $cir_code);
        //         $data['omutation'] = $this->getPendingOfficeMutationCases($dist_code, $subdiv_code, $cir_code);

//         $data['oconv'] = $this->getPendingConversionCases($user_code, $dist_code, $subdiv_code, $cir_code);
        //         $data['first_proceeding'] = $this->getFirstProceedingConvertion($user_code, $dist_code, $subdiv_code, $cir_code);
        //         $data['second_proceeding'] = $this->getSecondProceedingConvertion($user_code, $dist_code, $subdiv_code, $cir_code);
        //         $data['third_proceeding'] = $this->getConvertionOrderPassedByDC($user_desig_code, $dist_code, $subdiv_code, $cir_code);
        //         $data['rejected_proceeding'] = $this->getRejectedProceedingConvertion($user_code, $dist_code, $subdiv_code, $cir_code);
        //         $data['conversion_proceeding_report'] = $this->getconversion_proceeding_report($user_code, $dist_code, $subdiv_code, $cir_code);

//         $data['mfirst_proceeding'] = $this->getFisrtProceedingMutation($user_code, $dist_code, $subdiv_code, $cir_code);
        //         $data['msecond_proceeding'] = $this->getSecondProceedingMutation($user_code, $dist_code, $subdiv_code, $cir_code);
        //         $data['pfirst_proceeding'] = $this->getFisrtProceedingPartition($user_code, $dist_code, $subdiv_code, $cir_code);
        //         $data['psecond_proceeding'] = $this->getSecondProceedingPartition($user_code, $dist_code, $subdiv_code, $cir_code);

//         $data['allotment_first'] = $this->db->query("Select count(*) as c from     allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  not_fresh is null and status is null")->row()->c;

//         $data['allotment_second'] = $this->db->query("Select count(*) as c from     allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  not_fresh='Y' and status='P' and co_note is not null")->row()->c;

//         $data['allotment_final'] = $this->db->query("Select count(*) as c from     allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  status='F' and dc_code is not null and chitha_correct_yn is null ")->row()->c;

//         $data['countAPCaseforCO'] = $this->APCancellationModel->getCountAPCasesforCO(); //not used location condition
        //         $data['countNoteHearingAPCaseforCO'] = $this->APCancellationModel->getNoteHearingAPCasesforCO(); //not used location condition
        //         $data['getOrderAPCancellation'] = $this->APCancellationModel->getOrderAPCancellation(); //not used location condition

//         $data['fchithaupdates'] = $this->getPendingFieldChithaUpdates();
        //         $data['ochithaupdates'] = $this->getPendingOfficeChithaUpdates();

//         $data['FirstPro'] = $this->db->query("SELECT count(*) as c from   Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  and mut_type='04' and co_user_code='$user_code' and not_fresh is null and lm_note_yn is null and date_entry >= '$define_date' ")->row()->c;

//         $data['SecondPro'] = $this->db->query("SELECT count(*) as c from   Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  and co_user_code='$user_code' and not_fresh = 'Y' and status='P' and mut_type='04' and date_entry >= '$define_date' ")->row()->c;

//         $data['citizenPendingCO'] = $this->db->query("SELECT count(*) as c from   Cert_Application WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  and LM_Checked_yn='Y' and CO_Checked_yn is null and apply_date >= '$define_date'")->row()->c;

//         $data['land_proposals'] = $this->db->query("SELECT count(*) as c from   t_reclassification WHERE co_yn is null and dc_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status != 'R' OR status is null)")->row()->c;

//         $data['g_trans_for_dc'] = $this->db->query("SELECT count(*) as c from   t_reclassification WHERE co_yn = 'Y' and dc_yn is null and dc_approval is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status != 'R' OR status is null)")->row()->c;

//         $data['land_proposals_returned_DC'] = $this->db->query("SELECT count(*) as c from   t_reclassification WHERE co_yn = 'Y' and dc_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and dc_approval is not null and (status != 'R' OR status is null)")->row()->c;

//         $data['land_proposals_for_jamaupdate'] = $this->db->query("SELECT count(*) as c from   t_reclassification as t JOIN chitha_basic as c ON c.dist_code=t.dist_code and "
        //                         . "c.subdiv_code = t.subdiv_code and c.cir_code = t.cir_code and c.mouza_pargona_code=t.mouza_pargona_code and c.lot_no=t.lot_no and "
        //                         . "c.vill_townprt_code=t.vill_townprt_code and c.dag_no = t.dag_no and trim(c.patta_no) = trim(t.patta_no) and c.dist_code='$dist_code' and "
        //                         . "c.subdiv_code='$subdiv_code' and c.cir_code='$cir_code' and t.co_chitha_updated_yn = 'Y' and c.jama_yn != 'y'")->row()->c;

//         $data['pending_objection'] = $this->db->query("Select count(*) as c from     field_mut_objection where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and obj_flag is null and entry_date >= '$define_date' ")->row()->c;

//         $data['proceedingPartRpt'] = $this->proceedingReportpart($user_code, $dist_code, $subdiv_code, $cir_code);

//         $data['proceedingMutRpt'] = $this->proceedingReportofcmut($user_code, $dist_code, $subdiv_code, $cir_code, $year_no, $define_date);

//         $data['name_correction'] = $this->db->query("SELECT count(*) as c from   t_chitha_rmk_ordbasic WHERE ord_type_code = '05' and iscorrected_inco is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  ")->row()->c;

//         $data['partchithaupdate'] = $this->db->query("SELECT count(*) as c from   t_chitha_rmk_ordbasic WHERE ord_type_code = '04' and iscorrected_inco is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ")->row()->c;

//         $data['MisCases'] = $this->NameCorrectionModel->getMiscCases($user_code, $dist_code, $subdiv_code, $cir_code);

//         $data['MisCasesNC'] = $this->NameCancellationModel->getMiscCasesNC($user_code, $dist_code, $subdiv_code, $cir_code);

//         $data['FinalOrderMisc'] = $this->NameCorrectionModel->getFinalOrderMisc($user_code);

//         $data['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
        //                         . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
        //                         . "loginuser_table.date_password_changed AS date_password_changed from users INNER JOIN loginuser_table ON "
        //                         . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
        //                         . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
        //                         . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
        //                         . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
        //                         . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();

// //        $data['civil_appeal_basic'] = $this->db->query("SELECT count(*) as c from   civil_appeal_basic WHERE co_order_yn is null and chitha_correct_yn is null and status = 'P' and"
        // //                . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

//         $date_of_last_password_changed = $data['my_info']->date_password_changed;
        //         if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
        //             $this->updatepasswordnow($user_code, $user_desig_code);
        //         }

        $this->load->view('header', $headtitle);
        $this->load->view('home/aso', $data);
        $this->load->view('footer');
    }

    public function proceedingReportofcmut($user_code, $dist_code, $subdiv_code, $cir_code)
    {
        $year_no = year_no;
        $define_date = define_date;

        $query = "select count(*) as c from     petition_basic where  add_off_name ='$user_code' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='03'  and date_entry >= '$define_date'  ";
        return $this->db->query($query)->row()->c;
    }

    public function proceedingReportpart($user_code, $dist_code, $subdiv_code, $cir_code)
    {
        $year_no = year_no;
        $define_date = define_date;

        $query = "select count(*) as c from     petition_basic where  co_user_code = '$user_code' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='04'  and date_entry >= '$define_date'   ";
        return $this->db->query($query)->row()->c;
    }

    public function getPendingOfficePartitionCases($dist_code, $subdiv_code, $cir_code)
    {
        $year_no = year_no;
        $define_date = define_date;

        $query = "select count(*) as c from     petition_basic where not_fresh is null and lm_note_yn is null and mut_type='04' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  and date_entry >= '$define_date'    ";
        return $this->db->query($query)->row()->c;
    }

    public function getPendingOfficeMutationCases($dist_code, $subdiv_code, $cir_code)
    {
        $year_no = year_no;
        $define_date = define_date;

        $query = "select count(*) as c from     petition_basic where status is null and not_fresh is null and lm_note_yn is null and mut_type='03' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  and date_entry >= '$define_date'  ";
        return $this->db->query($query)->row()->c;
    }

    public function getPendingConversionCases($dsg, $dist_code, $subdiv_code, $cir_code)
    {
        $year_no = year_no;
        $define_date = define_date;

        $query = "select count(*) as c from     petition_basic where is_mb3!=1 and not_fresh is null and (status is null or status = 'P') and lm_note_yn is null and co_user_code = '$dsg' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='01'  and date_entry >= '$define_date'   ";
        return $this->db->query($query)->row()->c;
    }

    public function getPendingConversionCasesMb3($dsg, $dist_code, $subdiv_code, $cir_code)
    {
        $year_no = year_no;
        $define_date = define_date;

        $query = "select count(*) as c from     petition_basic where is_mb3=1 and not_fresh is null and (status is null or status = 'P') and lm_note_yn is null and co_user_code = '$dsg' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='01'  and date_entry >= '$define_date'   ";
        return $this->db->query($query)->row()->c;
    }

    public function getFirstProceedingConvertion($dsg, $dist_code, $subdiv_code, $cir_code)
    {
        $year_no = year_no;
        $define_date = define_date;

        $query = "select count(*) as c from     petition_basic where not_fresh is null and lm_note_yn is null and (status is null or status = 'P') and co_user_code = '$dsg' and mut_type='01' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  and date_entry >= '$define_date'  ";
        return $this->db->query($query)->row()->c;
    }

    public function getSecondProceedingConvertion($dsg, $dist_code, $subdiv_code, $cir_code)
    {
        $year_no = year_no;
        $define_date = define_date;

        $query = "select count(*) as c from     petition_basic where not_fresh = 'Y' and status = 'P' and mut_type='01' and co_user_code = '$dsg' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'   and date_entry >= '$define_date'  ";
        return $this->db->query($query)->row()->c;
    }

    public function getRejectedProceedingConvertion($dsg, $dist_code, $subdiv_code, $cir_code)
    {
        $year_no = year_no;
        $define_date = define_date;

        $query = "select count(*) as c from     petition_basic where not_fresh = 'Y' and status = 'R' and mut_type='01' and co_user_code = '$dsg' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'   and date_entry >= '$define_date'  ";
        return $this->db->query($query)->row()->c;
    }

    public function getconversion_proceeding_report($dsg, $dist_code, $subdiv_code, $cir_code)
    {
        $year_no = year_no;
        $define_date = define_date;

        $query = "select count(*) as c from     petition_basic where mut_type = '01' and status != 'B' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'   and date_entry >= '$define_date' ";
        return $this->db->query($query)->row()->c;
    }

    public function getConvertionOrderPassedByDC($dsg, $dist_code, $subdiv_code, $cir_code)
    {
        $year_no = year_no;
        $define_date = define_date;

        $query = "select count(*) as c from     petition_basic where not_fresh = 'Y' and status = 'W' and mut_type='01' and add_off_desig = '$dsg' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'   and date_entry >= '$define_date'  ";
        return $this->db->query($query)->row()->c;
    }

    public function getFisrtProceedingMutation($dsg, $dist_code, $subdiv_code, $cir_code)
    {
        $year_no = year_no;
        $define_date = define_date;

        $query = "select count(*) as c from     petition_basic where comp_serv_yn is null and status is null and not_fresh is null and lm_note_yn is null and mut_type='03' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  and date_entry >= '$define_date' ";
        return $this->db->query($query)->row()->c;
    }

    public function getSecondProceedingMutation($dsg, $dist_code, $subdiv_code, $cir_code)
    {
        $year_no = year_no;
        $define_date = define_date;

        $query = "select count(*) as c from     petition_basic where comp_serv_yn is null and not_fresh='Y' and status='P' and mut_type='03' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  and date_entry >= '$define_date' ";
        return $this->db->query($query)->row()->c;
    }

    public function getFisrtProceedingPartition($dsg, $dist_code, $subdiv_code, $cir_code)
    {
        $year_no = year_no;
        $define_date = define_date;

        $query = "select count(*) as c from     petition_basic where not_fresh is null and lm_note_yn is null and mut_type='04' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  and date_entry >= '$define_date' ";
        return $this->db->query($query)->row()->c;
    }

    public function getSecondProceedingPartition($dsg, $dist_code, $subdiv_code, $cir_code)
    {
        $year_no = year_no;
        $define_date = define_date;

        $query = "select count(*) as c from     petition_basic where not_fresh='Y' and status='P' and mut_type='04' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  and date_entry >= '$define_date' ";
        return $this->db->query($query)->row()->c;
    }

    public function lmHome()
    {
        //
        $user_desig_code = $this->session->userdata('user_desig_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        if ($mouza_pargona_code == '00' || $lot_no == '00' || $cir_code == '00' || $subdiv_code == '00') {
            redirect('login/logout');
        }
        $user_code = $this->session->userdata('user_code');
        $year_no = year_no;
        $define_date = define_date;
        //
        //var_dump($this->session->all_userdata());
        $user_desig_code = $this->session->userdata('user_desig_code');

        $data['all_field'] = $this->dashboard->allMutationLMwise($user_desig_code, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        $data['pen_field'] = $this->dashboard->penMutationLMwise($user_desig_code, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        $data['del_field'] = $this->dashboard->delMutation($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['o_mut'] = $this->dashboard->ofcMutationLMwise($user_desig_code, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        $data['field_mut'] = $this->dashboard->fieldMutationLMwise($user_desig_code, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        $data['o_part'] = $this->dashboard->ofcPartitionLMwise($user_desig_code, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        $data['field_part'] = $this->dashboard->fieldPartitionLMwise($user_desig_code, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        $data['conversion'] = $this->dashboard->conversionLMwise($user_desig_code, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        $data['reclassification'] = $this->dashboard->reclassificationLMwise($user_desig_code, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        $data['certificate'] = $this->dashboard->certificateLMwise($user_desig_code, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        $data['apcases'] = $this->dashboard->apcasesLMwise($user_desig_code, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        $data['acpp'] = $this->dashboard->alotCertificateLMwise($user_desig_code, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        $data['settlement'] = $this->dashboard->settlementLMwise($user_desig_code, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        $data['misccases'] = $this->dashboard->misccasesLMwise($user_desig_code, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        if(EKHAJANA_LM_PENDING_CONTROL == 1){
            $data['ekhajana_pending_lm_cases'] = $this->utilityclass->getEkhajanaLmPendingCases($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        }else{
            $data['ekhajana_pending_lm_cases'] = 0;
        }


        $data['stateCadre'] = $this->lmStateCadre();
        $data['my_info'] = $this->db->query("Select lm_code.lm_name AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed, lm_code.corres_sk_code AS corres_sk_code from  lm_code INNER JOIN loginuser_table ON "
            . "lm_code.lm_code = loginuser_table.user_code and lm_code.dist_code = loginuser_table.dist_code and "
            . "lm_code.subdiv_code = loginuser_table.subdiv_code and lm_code.cir_code = loginuser_table.cir_code and "
            . "lm_code.mouza_pargona_code = loginuser_table.mouza_pargona_code and lm_code.lot_no = loginuser_table.lot_no "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
            . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();

        $date_of_last_password_changed = $data['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }

        ///******INTEGRATION OF PROFILE UPDATE CHECK***********///
        $user_details_array = array(
            'user_code' => $this->session->userdata('user_code'),
            'user_desig_code' => $user_desig_code,
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
        );
        $data['profile_update_flag'] = $this->profile_upload_check($user_details_array);
        //var_dump($counts);
        //$this->load->view('header');
        $data['_view'] = 'home/lm';
        $this->load->view('layouts/main', $data);
        // $this->load->view('home/lm', $counts);
        // $this->load->view('footer');
    }

    public function getPendingLMConversionCases($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no)
    {
        $year_no = year_no;
        $define_date = define_date;
        //
        $query = "select count(*) as c from     petition_basic where is_mb3!=1 and not_fresh = 'Y'  and date_entry >= '$define_date' "
            . "and lm_note_yn is null and status = 'P' and mut_type='01' and dist_code='$dist_code' and "
            . "subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code ='$mouza_pargona_code' and lot_no='$lot_no'";
        return $this->db->query($query)->row()->c;
    }

    public function getPendingLMConversionCasesMb3($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no)
    {
        $year_no = year_no;
        $define_date = define_date;
        //
        $query = "select count(*) as c from     petition_basic where is_mb3=1 and not_fresh = 'Y'  and date_entry >= '$define_date' "
            . "and lm_note_yn is null and status = 'P' and mut_type='01' and dist_code='$dist_code' and "
            . "subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code ='$mouza_pargona_code' and lot_no='$lot_no'";
        return $this->db->query($query)->row()->c;
    }

    public function skHome()
    {

        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page',
        );

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';

        $data['all_field'] = $this->dashboard->allMutation($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['pen_field'] = $this->dashboard->penMutation($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['del_field'] = $this->dashboard->delMutation($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['o_mut'] = $this->dashboard->ofcMutation($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['field_mut'] = $this->dashboard->fieldMutation($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['o_part'] = $this->dashboard->ofcPartition($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['field_part'] = $this->dashboard->fieldPartition($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['conversion'] = $this->dashboard->conversion($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['reclassification'] = $this->dashboard->reclassification($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['certificate'] = $this->dashboard->certificate($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['apcases'] = $this->dashboard->apcases($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['acpp'] = $this->dashboard->alotCertificate($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['settlement'] = $this->dashboard->settlement($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['misccases'] = $this->dashboard->misccases($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['stateCadre'] = $this->lmStateCadre();
        $data['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from     users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.user_code = '$user_code'")->row();

        $date_of_last_password_changed = $data['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }

        $data['_view'] = 'home/sk';
        $this->load->view('layouts/main', $data);
    }

    public function dcHome()
    {
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = '00';
        $lot_no = '00';

        $year_no = year_no;
        $define_date = define_date;
        $doul_year_no = doul_year_no;

        $data['all_field'] = $this->dashboard->allMutationDC($user_desig_code, $dist_code);

        $data['pen_field'] = $this->dashboard->penMutationDC($user_desig_code, $dist_code);

        $data['del_field'] = $this->dashboard->delMutationDC($user_desig_code, $dist_code);

        $data['conversion'] = $this->dashboard->conversionDC($user_desig_code, $dist_code);

        $data['reclassification'] = $this->dashboard->reclassificationDC($user_desig_code, $dist_code);

        $data['apcases'] = $this->dashboard->apcasesDC($user_desig_code, $dist_code);

        $data['acpp'] = $this->dashboard->alotCertificateDC($user_desig_code, $dist_code);

        $data['doul_info'] = $this->db->query("select * from current_doul_approve where status in ('P','R') and yeardoul='$doul_year_no'")->num_rows();

        $data['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from     users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
            . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();

        $date_of_last_password_changed = $data['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }

        ///******INTEGRATION OF PROFILE UPDATE CHECK***********///
        $user_details_array = array(
            'user_code' => $this->session->userdata('user_code'),
            'user_desig_code' => $user_desig_code,
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
        );
        $data['profile_update_flag'] = $this->profile_upload_check($user_details_array);

        //$this->load->view('header');
        //$this->load->view('home/dc', $counts);
        //$this->load->view('footer');
        if(ESCALATION_ENABLE == 1)
        {
            $this->load->model('DcEscalationModel');
            $user_desig_code = $this->session->userdata('user_desig_code');
            $dist_code       = $this->session->userdata('dist_code');
            $user_code       = $this->session->userdata('user_code');

            $data['escalated_cases'] = $this->DcEscalationModel->getEscalationFromUserToDc($user_desig_code, $user_code);
        }

        $data['_view'] = 'home/dc';
        $this->load->view('layouts/main', $data);
    }

    public function adcHome()
    {
        //var_dump($this->session->all_userdata());
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = '00';
        $lot_no = '00';

        $year_no = year_no;
        $define_date = define_date;

        $data['all_field'] = $this->dashboard->allMutationDC($user_desig_code, $dist_code);

        $data['pen_field'] = $this->dashboard->penMutationDC($user_desig_code, $dist_code);

        $data['del_field'] = $this->dashboard->delMutationDC($user_desig_code, $dist_code);

        $data['conversion'] = $this->dashboard->conversionDC($user_desig_code, $dist_code);

        $data['reclassification'] = $this->dashboard->reclassificationDC($user_desig_code, $dist_code);

        $data['apcases'] = $this->dashboard->apcasesDC($user_desig_code, $dist_code);

        $data['acpp'] = $this->dashboard->alotCertificateDC($user_desig_code, $dist_code);

        $data['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from     users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
            . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();

        $date_of_last_password_changed = $data['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }

        ///******INTEGRATION OF PROFILE UPDATE CHECK***********///
        $user_details_array = array(
            'user_code' => $this->session->userdata('user_code'),
            'user_desig_code' => $user_desig_code,
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
        );
        $data['profile_update_flag'] = $this->profile_upload_check($user_details_array);

        // $this->load->view('header');
        // $this->load->view('home/adc', $counts);
        // $this->load->view('footer');

        $data['_view'] = 'home/adc';
        $this->load->view('layouts/main', $data);
    }

    public function laoHome()
    {
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = '00';
        $cir_code = '00';
        $mouza_pargona_code = '00';
        $lot_no = '00';

        $year_no = year_no;
        $define_date = define_date;
        $counts['getDCAPCancellation'] = $this->APCancellationModel->getDCAPCancellationMatter();
        $counts['recommended_reclassification_DC'] = $this->db->query("SELECT count(*) as c from   t_reclassification WHERE co_yn = 'Y' and dc_yn is null and (status != 'R' OR status is null)")->row()->c;
        $counts['g_trans_for_Co'] = $this->db->query("SELECT count(*) as c from   t_reclassification WHERE co_yn = 'Y' and dc_yn = 'Y' and co_chitha_updated_yn is null and (status != 'R' OR status is null)")->row()->c;

        $counts['sronote'] = $this->db->query("SELECT * from   sro_note WHERE dist_code='$dist_code' and (deed_type='SALE' or deed_type='GIFT' )")->result();

        $counts['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from     users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
            . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();

        $date_of_last_password_changed = $counts['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }

        $this->load->view('header');
        $this->load->view('home/lao', $counts);
        $this->load->view('footer');
    }

    public function astHome()
    {

        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page',
        );

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';

        $data['all_field'] = $this->dashboard->allMutation($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['pen_field'] = $this->dashboard->penMutation($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['del_field'] = $this->dashboard->delMutation($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['o_mut'] = $this->dashboard->ofcMutation($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['field_mut'] = $this->dashboard->fieldMutation($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['o_part'] = $this->dashboard->ofcPartition($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['field_part'] = $this->dashboard->fieldPartition($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['conversion'] = $this->dashboard->conversion($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['reclassification'] = $this->dashboard->reclassification($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['certificate'] = $this->dashboard->certificate($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['apcases'] = $this->dashboard->apcases($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['acpp'] = $this->dashboard->alotCertificate($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['settlement'] = $this->dashboard->settlement($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['misccases'] = $this->dashboard->misccases($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from  users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = ? and loginuser_table.subdiv_code = ? "
            . "and loginuser_table.cir_code = ? and loginuser_table.user_code = ?", array($dist_code, $subdiv_code, $cir_code, $user_code))->row();

        $date_of_last_password_changed = $data['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }

        ///******INTEGRATION OF PROFILE UPDATE CHECK***********///
        $user_details_array = array(
            'user_code' => $this->session->userdata('user_code'),
            'user_desig_code' => $user_desig_code,
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
        );
        $data['profile_update_flag'] = $this->profile_upload_check($user_details_array);

        $data['_view'] = 'home/ast';
        $this->load->view('layouts/main', $data);
    }

    public function getPendingASTNoticeGeneratedNameCorrection($user_code, $dist_code, $subdiv_code, $cir_code)
    {
        $year_no = year_no;
        $define_date = define_date;

        $query = "select count(*) as c from     misc_case_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lm_note_yn is null"
            . "  and submission_date >= '$define_date' and status='18' and sk_note_yn is null and notice_generated_yn is null ";
        return $this->db->query($query)->row()->c;
    }

    public function getPendingASTActionTakenNameCorrection($user_code, $dist_code, $subdiv_code, $cir_code)
    {
        $year_no = year_no;
        $define_date = define_date;

        $query = "select count(*) as c from     misc_case_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and dag_no is not null"
            . "  and submission_date >= '$define_date' and status='18' and notice_generated_yn='Y' and notice_generated_date is not null";
        return $this->db->query($query)->row()->c;
    }

    public function getPendingASTNoticeGeneratedConversionCases($user_code, $dist_code, $subdiv_code, $cir_code)
    {
        $year_no = year_no;
        $define_date = define_date;

        // $query = "select count(*) as c from     petition_basic where not_fresh = 'Y'  and date_entry >= '$define_date' and user_code = '$user_code' and "
        //         . "notice_generated_yn is null and status = 'P' and mut_type = '01' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
        $query = "select count(*) as c from     petition_basic where not_fresh = 'Y'  and date_entry >= '$define_date' and "
            . "notice_generated_yn is null and status = 'P' and mut_type = '01' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and user_code like '%AS%'";
        return $this->db->query($query)->row()->c;
    }

    public function getPendingASTActionTakenConversionCases($user_code, $dist_code, $subdiv_code, $cir_code)
    {
        $year_no = year_no;
        $define_date = define_date;

        // $query = "select count(*) as c from     petition_basic where not_fresh = 'Y'  and date_entry >= '$define_date' and user_code = '$user_code' and "
        //         . "proceeding_yn is null and status = 'P' and mut_type = '01' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
        $query = "select count(*) as c from     petition_basic where not_fresh = 'Y'  and date_entry >= '$define_date' and "
            . "proceeding_yn is null and status = 'P' and mut_type = '01' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and user_code like '%AS%'";
        return $this->db->query($query)->row()->c;
    }

    public function getPendingASTPremiumConversionCases($user_code, $dist_code, $subdiv_code, $cir_code)
    {
        $year_no = year_no;
        $define_date = define_date;

        $query = "select count(*) as c from     petition_basic where is_mb3!=1 and not_fresh = 'Y'  and date_entry >= '$define_date' and status = 'P'  "
            . "and mut_type = '01' and co_order_conv_premium = 'Y' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and co_order_conv_notice is not null and user_code like '%AS%'";
        return $this->db->query($query)->row()->c;
    }

    public function getPendingASTPremiumConversionCasesMb3($user_code, $dist_code, $subdiv_code, $cir_code)
    {
        $year_no = year_no;
        $define_date = define_date;

        $query = "select count(*) as c from     petition_basic where is_mb3=1 and not_fresh = 'Y'  and date_entry >= '$define_date' and status = 'P'  "
            . "and mut_type = '01' and co_order_conv_premium = 'Y' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and co_order_conv_notice is not null and user_code like '%AS%'";
        return $this->db->query($query)->row()->c;
    }

    public function getPendingASTPaymentConversionCases($user_code, $dist_code, $subdiv_code, $cir_code)
    {
        $year_no = year_no;
        $define_date = define_date;

        // $query = "select count(*) as c from     petition_basic where not_fresh = 'Y'  and date_entry >= '$define_date' and user_code = '$user_code' and "
        //         . "status = 'P' and mut_type = '01' and co_order_conv_premium = 'Y' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
        $query = "select count(*) as c from     petition_basic where is_mb3!=1 and not_fresh = 'Y'  and date_entry >= '$define_date' and "
            . "status = 'P' and mut_type = '01' and co_order_conv_premium = 'Y' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and user_code like '%AS%'";
        return $this->db->query($query)->row()->c;
    }

    public function getPendingASTPaymentConversionCasesMb3($user_code, $dist_code, $subdiv_code, $cir_code)
    {
        $year_no = year_no;
        $define_date = define_date;

        // $query = "select count(*) as c from     petition_basic where not_fresh = 'Y'  and date_entry >= '$define_date' and user_code = '$user_code' and "
        //         . "status = 'P' and mut_type = '01' and co_order_conv_premium = 'Y' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
        $query = "select count(*) as c from     petition_basic where is_mb3=1 and not_fresh = 'Y'  and date_entry >= '$define_date' and "
            . "status = 'P' and mut_type = '01' and co_order_conv_premium = 'Y' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and user_code like '%AS%'";
        return $this->db->query($query)->row()->c;
    }

    public function getPendingFieldChithaUpdates()
    {
        $location = $this->utilityclass->getLocationFromSession();

        $query = "select count(*) as c from  t_chitha_col8_order where dist_code='$location[dist_code]' and "
            . "subdiv_code='$location[subdiv_code]' and cir_code='$location[cir_code]' and iscorrected_inco is null";
        return $this->db->query($query)->row()->c;
    }

    public function getPendingOfficeChithaUpdates()
    {
        $location = $this->utilityclass->getLocationFromSession();

        $query = "select count(*) as c from     t_chitha_rmk_ordbasic where dist_code='$location[dist_code]' and "
            . "subdiv_code='$location[subdiv_code]' and cir_code='$location[cir_code]' and iscorrected_inco is null";
        return $this->db->query($query)->row()->c;
    }

    public function MasterHome()
    {
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');

        $subdiv_code = '00';
        $cir_code = '00';
        $mouza_pargona_code = '00';
        $lot_no = '00';

        $data['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from     users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
            . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();

        // $this->load->view('header');
        // $this->load->view('home/admin', $data);
        // $this->load->view('footer');
        $data['_view'] = 'home/admin';
        $this->load->view('layouts/main', $data);
    }

    public function dioHome()
    {
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = '00';
        $cir_code = '00';
        $mouza_pargona_code = '00';
        $lot_no = '00';

        $data['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
            . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();

        // $this->load->view('header');
        // $this->load->view('home/dio', $data);
        // $this->load->view('footer');

        $data['_view'] = 'home/dio';
        $this->load->view('layouts/main', $data);
    }

    public function BoHome()
    {

        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        //
        $subdiv_code = '00';
        $cir_code = '00';
        $mouza_pargona_code = '00';
        $lot_no = '00';
        //
        $data['all_field'] = $this->dashboard->allMutation($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['pen_field'] = $this->dashboard->penMutation($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['del_field'] = $this->dashboard->delMutation($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['conversion'] = $this->dashboard->conversion($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['apcases'] = $this->dashboard->apcases($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['acpp'] = $this->dashboard->alotCertificate($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['misccases'] = $this->dashboard->misccases($user_desig_code, $dist_code, $subdiv_code, $cir_code);

        $data['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from  users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.user_code = '$user_code'")->row();

        $date_of_last_password_changed = $data['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }

        ///******INTEGRATION OF PROFILE UPDATE CHECK***********///
        $user_details_array = array(
            'user_code' => $this->session->userdata('user_code'),
            'user_desig_code' => $user_desig_code,
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
        );
        $data['profile_update_flag'] = $this->profile_upload_check($user_details_array);

        $data['_view'] = 'home/bo';
        $this->load->view('layouts/main', $data);
    }

    public function getPendingBoNoticeGeneratedConversionCases($user_code, $dist_code)
    {
        $year_no = year_no;
        $define_date = define_date;

        $query = "select count(*) as c from     petition_basic where not_fresh = 'Y'  and date_entry >= '$define_date' "
            . "and user_code = '$user_code' and bo_note_yn is null and status = 'P' and mut_type = '01' and dist_code='$dist_code'";
        return $this->db->query($query)->row()->c;
    }

    public function rkgHome()
    {
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');

        $cir_code = '00';
        $mouza_pargona_code = '00';
        $lot_no = '00';

        $counts['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from     users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
            . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();

        $date_of_last_password_changed = $data['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }

        $this->load->view('header');
        $this->load->view('home/rkg', $counts);
        $this->load->view('footer');
    }

    public function getPendingASTActionTakenConversionCasesDC($user_code, $dist_code)
    {

        $query = "select count(*) as c from     petition_basic where not_fresh = 'Y' and user_code = '$user_code' and proceeding_yn is null and "
            . "status = 'P' and mut_type = '01' and dist_code='$dist_code'";
        return $this->db->query($query)->row()->c;
    }

    public function getPendingASTPremiumConversionCasesDC($user_code, $dist_code)
    {

        $query = "select count(*) as c from     petition_basic where not_fresh = 'Y' and status = 'P' and user_code = '$user_code' and mut_type = '01' and "
            . "co_order_conv_premium = 'Y' and dist_code='$dist_code' and co_order_conv_notice is not null";
        return $this->db->query($query)->row()->c;
    }

    public function getPendingASTPaymentConversionCasesDC($user_code, $dist_code)
    {

        $query = "select count(*) as c from     petition_basic where not_fresh = 'Y' and user_code = '$user_code' and status = 'P' and mut_type = '01' and "
            . "co_order_conv_premium = 'Y' and dist_code='$dist_code'";
        return $this->db->query($query)->row()->c;
    }

    public function jadHome()
    {

        $dist_code = $this->session->userdata('dist_code');
        $this->load->view('header');
        $this->load->view('home/jad');
        $this->load->view('footer');
    }

    public function sadHome()
    {
        $dist_code = $this->session->userdata('dist_code');
        $this->load->view('header');
        $this->load->view('home/sad');
        $this->load->view('footer');
    }

    public function deoHome()
    {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        if (isset($_SESSION['basic_entry'])) {
            unset($_SESSION['dagpattadar']);
            unset($_SESSION['pattadar']);
            unset($_SESSION['basic_entry']);
        }

        $sql = "Select * from     chitha_basic_entry where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
        $data['basic'] = $this->db->query($sql)->result();

        // $this->load->view('../views/chitha_basic/header');
        // $this->load->view('../views/chitha_basic/main', $data);
        // $this->load->view('footer');

        $data['_view'] = 'chitha_basic/main';
        $this->load->view('layouts/main', $data);
    }

    public function updatepasswordnow($userid, $ucode)
    {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $sql = "Update loginuser_table set first_login='Y' where user_code='$userid' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
        $this->db->query($sql);
    }

    public function StateConsultantHome()
    {
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = '00';
        $cir_code = '00';
        $mouza_pargona_code = '00';
        $lot_no = '00';

        $data['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from     users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
            . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();

        $this->load->view('header');
        $this->load->view('home/Madmin', $data);
        $this->load->view('footer');
    }

    public function update_dag_no_int()
    {
        $sql = "select * from  chitha_basic where dist_code = '14' and subdiv_code = '01' and cir_code = '04' and mouza_pargona_code = '04' and
            lot_no = '11' and vill_townprt_code = '10004'";
        $array = $this->db->query($sql)->result();
        foreach ($array as $value) {
            $dag_no_int = $value->dag_no . '00';

            $update = "update  chitha_basic set dag_no_int = '$dag_no_int' where dist_code = '14' and subdiv_code = '01' and cir_code = '04' and mouza_pargona_code = '04' and
            lot_no = '11' and vill_townprt_code = '10004' and dag_no = '$value->dag_no'";

            //$this->db->query($update);
        }
    }

    public function MutationLm()
    {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $user_code = $this->session->userdata('user_code');
        $year_no = year_no;
        $define_date = define_date;

        //var_dump($this->session->all_userdata());
        $user_desig_code = $this->session->userdata('user_desig_code');

        $counts['map_partition'] = $this->db->query("Select count(*) as c from  t_chitha_col8_order where map_partition is null and order_type_code='02' and "
            . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' "
            . "and lot_no = '$lot_no'  and date(co_ord_date) >= '$define_date' ")->row()->c;

        $counts['fconsent'] = $this->db->query("select count(*) as c from     field_mut_basic where order_passed is null and mut_type='02' and p_consent is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no = '$lot_no'  and date_entry >= '$define_date' ")->row()->c;
        $counts['reverted'] = $this->db->query("select count(*) as c from field_mut_basic where order_passed is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and is_dispose='L' and lot_no = '$lot_no'   and date_entry >= '$define_date' ")->row()->c;
        $counts['fmutation'] = $this->db->query("select count(*) as c from     field_mut_basic where order_passed is null and mut_type='01' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no = '$lot_no'  and date_entry >= '$define_date' ")->row()->c;

        $counts['fpartition'] = $this->db->query("select count(*) as c from     field_mut_basic where order_passed is null and mut_type='02' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no = '$lot_no'  and date_entry >= '$define_date'")->row()->c;

        $counts['oconsent'] = $this->db->query("select count(*) as c from     petition_basic where order_passed is null and mut_type='04' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'  and date_entry >= '$define_date'")->row()->c;

        $counts['omutation'] = $this->db->query("select count(*) as c from     petition_basic where order_passed is null and not_fresh='Y' and lm_note_date is null and "
            . "sk_comment is null and mut_type='03' and status='P' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
            . "lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code'  and date_entry >= '$define_date'")->row()->c;

        $counts['opartition'] = $this->db->query("select count(*) as c from     petition_basic where order_passed is null  and date_entry >= '$define_date' and not_fresh='Y' and status='P' and lm_note_date is null and sk_comment is null and mut_type='04' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'")->row()->c;

        $counts['allotment_lm'] = $this->db->query("Select count(*) as c from     allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and lm_note is null and not_fresh='Y' and status='P' and co_note is not null")->row()->c;

        $counts['sronotepen'] = $this->db->query("SELECT count(*) as c from   sro_note WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and status='1' and nature_of_land = 'r'")->row()->c;

        $counts['oconversion'] = $this->db->query("select count(*) as c from     petition_basic where order_passed is null  and "
            . "date_entry >= '$define_date' and not_fresh='Y' and lm_note_date is null and sk_comment is null and mut_type='01' and "
            . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'")->row()->c;

        $counts['freshreport'] = $this->db->query("select count(*) as c from     field_mut_basic where co_flag_for_fresh_mut is not null and dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'")->row()->c;

        $counts['ofcPartition'] = $this->db->query("SELECT count(*) as c from   Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code'  and date_entry >= '$define_date' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and mut_type='04' and  not_fresh='Y' and status='P' and (lm_note_yn is null ) and (lm_note_date is null) ")->row()->c;

        $counts['ofcByayPrak'] = $this->db->query("SELECT count(*) as c from   Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code'  and date_entry >= '$define_date' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and  mut_type='04' and not_fresh='Y' and status='P' and byayprak_yn is null ")->row()->c;

        $counts['mappartition'] = $this->db->query("SELECT count(*) as c from   chitha_rmk_ordbasic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and  ord_type_code='04' and map_partition='P' ")->row()->c;

        $counts['CitizenCentric'] = $this->db->query("SELECT count(*) as c from   Cert_Application WHERE LM_Checked_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and apply_date >='$define_date'  and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no'")->row()->c;

        $counts['ConsentPattadar'] = $this->db->query("SELECT count(*) as c from   Petition_Basic pb INNER JOIN (SELECT dist_code, subdiv_code, cir_code, mouza_pargona_code,"
            . " Lot_No, vill_townprt_code, Year_no, Petition_no,Patta_no, patta_type_code,dag_no from   petitioner_part GROUP BY dist_code, subdiv_code, "
            . "cir_code, mouza_pargona_code, Lot_No, vill_townprt_code, Year_no, Petition_no, Patta_no,patta_type_code,dag_no) pp ON pb.dist_code = pp.dist_code AND "
            . "pb.subdiv_code = pp.subdiv_code AND pb.cir_code = pp.cir_code AND pb.mouza_pargona_code = pp.mouza_pargona_code AND pb.Lot_No = pp.Lot_No "
            . "AND pb.vill_townprt_code = pp.vill_townprt_code AND pb.Year_no = pp.Year_no AND pb.Petition_no = pp.Petition_no WHERE pb.dist_code='$dist_code' and pb.subdiv_code='$subdiv_code'  and pb.year_no='$year_no' and pb.date_entry >= '$define_date' and pb.cir_code='$cir_code' and pb.mouza_pargona_code='$mouza_pargona_code' and pb.lot_no='$lot_no' and  pb.mut_type='04' and pb.status='P' and pb.consent_updated is null ")->row()->c;

        $counts['oconv'] = $this->getPendingLMConversionCases($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        $counts['countAPCase'] = $this->APCancellationModel->getCountAPCasesforLM($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no); //not done with the location checking
        //adding it for miscellaneous cases
        $counts['countMiscCase'] = $this->NameCorrectionModel->getMiscCaseLM($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no); //not done with the location checking

        $counts['my_info'] = $this->db->query("Select lm_code.lm_name AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed, lm_code.corres_sk_code AS corres_sk_code from  lm_code INNER JOIN loginuser_table ON "
            . "lm_code.lm_code = loginuser_table.user_code and lm_code.dist_code = loginuser_table.dist_code and "
            . "lm_code.subdiv_code = loginuser_table.subdiv_code and lm_code.cir_code = loginuser_table.cir_code and "
            . "lm_code.mouza_pargona_code = loginuser_table.mouza_pargona_code and lm_code.lot_no = loginuser_table.lot_no "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
            . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();

//        $counts['civil_appeal_basic'] = $this->db->query("SELECT count(*) as c from   civil_appeal_basic WHERE lm_sign is null and dist_code='$dist_code' and "
//                . "subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no'")->row()->c;



        


        if(ESCALATION_ENABLE == 1){
            $counts['fmutation_case'] = $this->db->query("select count(*) as c from     field_mut_basic where order_passed is null and lm_note is null and possession_yn is null and mut_type='01' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no = '$lot_no'  and date_entry >= '$define_date' and es_flag =1 ")->row()->c;
            $counts['fpartition_case'] = $this->db->query("select count(*) as c from     field_mut_basic where order_passed is null and lm_note is null  and mut_type='02' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no = '$lot_no'  and date_entry >= '$define_date' and es_flag =1")->row()->c;
            $service_code = 1;
            $counts['service_type'] = FMUT;
            $counts['escAllocateDays'] = $this->Escalationmodel->getTimeLine($service_code, FMUT);
            $counts['escAllocateDaysDeed'] = $this->Escalationmodel->getTimeLine(2, 'OMUTD');
        }
        


        $date_of_last_password_changed = $counts['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }

        $counts['_view'] = 'home/mutation_lm';
        $this->load->view('layouts/main', $counts);
    }

    public function MutationLmOM()
    {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $user_code = $this->session->userdata('user_code');
        $year_no = year_no;
        $define_date = define_date;

        //var_dump($this->session->all_userdata());
        $user_desig_code = $this->session->userdata('user_desig_code');

        $counts['map_partition'] = $this->db->query("Select count(*) as c from  t_chitha_col8_order where map_partition is null and order_type_code='02' and "
            . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' "
            . "and lot_no = '$lot_no'  and date(co_ord_date) >= '$define_date' ")->row()->c;

        $counts['fconsent'] = $this->db->query("select count(*) as c from     field_mut_basic where order_passed is null and mut_type='02' and p_consent is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'  and date_entry >= '$define_date' ")->row()->c;

        $counts['fmutation'] = $this->db->query("select count(*) as c from     field_mut_basic where order_passed is null and mut_type='01' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'  and date_entry >= '$define_date' ")->row()->c;

        $counts['fpartition'] = $this->db->query("select count(*) as c from     field_mut_basic where order_passed is null and mut_type='02' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'  and date_entry >= '$define_date'")->row()->c;

        $counts['oconsent'] = $this->db->query("select count(*) as c from     petition_basic where order_passed is null and mut_type='04' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'  and date_entry >= '$define_date'")->row()->c;

        $counts['omutation'] = $this->db->query("select count(*) as c from     petition_basic where order_passed is null and not_fresh='Y' and lm_note_date is null and "
            . "sk_comment is null and mut_type='03' and status='P' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
            . "lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code'  and date_entry >= '$define_date'")->row()->c;

        $counts['opartition'] = $this->db->query("select count(*) as c from     petition_basic where order_passed is null  and date_entry >= '$define_date' and not_fresh='Y' and status='P' and lm_note_date is null and sk_comment is null and mut_type='04' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'")->row()->c;

        $counts['allotment_lm'] = $this->db->query("Select count(*) as c from     allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and lm_note is null and not_fresh='Y' and status='P' and co_note is not null")->row()->c;

        $counts['sronotepen'] = $this->db->query("SELECT count(*) as c from   sro_note WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and status='1' and nature_of_land = 'r'")->row()->c;

        $counts['oconversion'] = $this->db->query("select count(*) as c from     petition_basic where order_passed is null  and "
            . "date_entry >= '$define_date' and not_fresh='Y' and lm_note_date is null and sk_comment is null and mut_type='01' and "
            . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'")->row()->c;

        $counts['freshreport'] = $this->db->query("select count(*) as c from     field_mut_basic where co_flag_for_fresh_mut is not null and dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'")->row()->c;

        $counts['ofcPartition'] = $this->db->query("SELECT count(*) as c from   Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code'  and date_entry >= '$define_date' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and mut_type='04' and  not_fresh='Y' and status='P' and (lm_note_yn is null ) and (lm_note_date is null) ")->row()->c;

        $counts['ofcByayPrak'] = $this->db->query("SELECT count(*) as c from   Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code'  and date_entry >= '$define_date' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and  mut_type='04' and not_fresh='Y' and status='P' and byayprak_yn is null ")->row()->c;

        $counts['revert_from_co'] = $this->db->query("SELECT count(case_no) AS c
        FROM petition_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND
        mouza_pargona_code=? AND lot_no=? AND lm_note_yn IS NULL and status!='D' AND is_pending='Y'", array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no))->row()->c;
        $counts['mappartition'] = $this->db->query("SELECT count(*) as c from   chitha_rmk_ordbasic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and  ord_type_code='04' and map_partition='P' ")->row()->c;

        $counts['CitizenCentric'] = $this->db->query("SELECT count(*) as c from   Cert_Application WHERE LM_Checked_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and apply_date >='$define_date'  and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no'")->row()->c;

        $counts['ConsentPattadar'] = $this->db->query("SELECT count(*) as c from   Petition_Basic pb INNER JOIN (SELECT dist_code, subdiv_code, cir_code, mouza_pargona_code,"
            . " Lot_No, vill_townprt_code, Year_no, Petition_no,Patta_no, patta_type_code,dag_no from   petitioner_part GROUP BY dist_code, subdiv_code, "
            . "cir_code, mouza_pargona_code, Lot_No, vill_townprt_code, Year_no, Petition_no, Patta_no,patta_type_code,dag_no) pp ON pb.dist_code = pp.dist_code AND "
            . "pb.subdiv_code = pp.subdiv_code AND pb.cir_code = pp.cir_code AND pb.mouza_pargona_code = pp.mouza_pargona_code AND pb.Lot_No = pp.Lot_No "
            . "AND pb.vill_townprt_code = pp.vill_townprt_code AND pb.Year_no = pp.Year_no AND pb.Petition_no = pp.Petition_no WHERE pb.dist_code='$dist_code' and pb.subdiv_code='$subdiv_code'  and pb.year_no='$year_no' and pb.date_entry >= '$define_date' and pb.cir_code='$cir_code' and pb.mouza_pargona_code='$mouza_pargona_code' and pb.lot_no='$lot_no' and  pb.mut_type='04' and pb.status='P' and pb.consent_updated is null ")->row()->c;

        $counts['oconv'] = $this->getPendingLMConversionCases($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        $counts['countAPCase'] = $this->APCancellationModel->getCountAPCasesforLM($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no); //not done with the location checking
        //adding it for miscellaneous cases
        $counts['countMiscCase'] = $this->NameCorrectionModel->getMiscCaseLM($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no); //not done with the location checking

        $counts['my_info'] = $this->db->query("Select lm_code.lm_name AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed, lm_code.corres_sk_code AS corres_sk_code from  lm_code INNER JOIN loginuser_table ON "
            . "lm_code.lm_code = loginuser_table.user_code and lm_code.dist_code = loginuser_table.dist_code and "
            . "lm_code.subdiv_code = loginuser_table.subdiv_code and lm_code.cir_code = loginuser_table.cir_code and "
            . "lm_code.mouza_pargona_code = loginuser_table.mouza_pargona_code and lm_code.lot_no = loginuser_table.lot_no "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
            . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();

//        $counts['civil_appeal_basic'] = $this->db->query("SELECT count(*) as c from   civil_appeal_basic WHERE lm_sign is null and dist_code='$dist_code' and "
        //                . "subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no'")->row()->c;

        $date_of_last_password_changed = $counts['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }
        if(ESCALATION_ENABLE == 1){
            $service_code = 1;
            $counts['service_type'] = OMUT;
            $counts['escAllocateDays'] = $this->Escalationmodel->getTimeLine($service_code, 'OMUT');
            $counts['escAllocateDaysDeed'] = $this->Escalationmodel->getTimeLine(2, 'OMUTD');
        }

        $counts['_view'] = 'home/mutation_lm_om';
        $this->load->view('layouts/main', $counts);
    }

    public function PartitionLm()
    {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $user_code = $this->session->userdata('user_code');
        $year_no = year_no;
        $define_date = define_date;

        //var_dump($this->session->all_userdata());
        $user_desig_code = $this->session->userdata('user_desig_code');

        $counts['map_partition'] = $this->db->query("Select count(*) as c from  t_chitha_col8_order where map_partition is null and order_type_code='02' and "
            . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' "
            . "and lot_no = '$lot_no'  and date(co_ord_date) >= '$define_date' ")->row()->c;

        $counts['fconsent'] = $this->db->query("select count(*) as c from     field_mut_basic where order_passed is null and mut_type='02' and p_consent is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'  and date_entry >= '$define_date' ")->row()->c;

        $counts['fmutation'] = $this->db->query("select count(*) as c from     field_mut_basic where order_passed is null and mut_type='01' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'  and date_entry >= '$define_date' ")->row()->c;

        $counts['fpartition'] = $this->db->query("select count(*) as c from     field_mut_basic where order_passed is null and mut_type='02' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'  and date_entry >= '$define_date'")->row()->c;

        $counts['oconsent'] = $this->db->query("select count(*) as c from     petition_basic where order_passed is null and mut_type='04' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'  and date_entry >= '$define_date'")->row()->c;

        $counts['omutation'] = $this->db->query("select count(*) as c from     petition_basic where order_passed is null and not_fresh='Y' and lm_note_date is null and "
            . "sk_comment is null and mut_type='03' and status='P' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
            . "lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code'  and date_entry >= '$define_date'")->row()->c;

        $counts['opartition'] = $this->db->query("select count(*) as c from     petition_basic where order_passed is null  and date_entry >= '$define_date' and not_fresh='Y' and status='P' and lm_note_date is null and sk_comment is null and mut_type='04' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'")->row()->c;

        $counts['allotment_lm'] = $this->db->query("Select count(*) as c from     allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and lm_note is null and not_fresh='Y' and status='P' and co_note is not null")->row()->c;

        $counts['sronotepen'] = $this->db->query("SELECT count(*) as c from   sro_note WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and status='1' and nature_of_land = 'r'")->row()->c;

        $counts['oconversion'] = $this->db->query("select count(*) as c from     petition_basic where order_passed is null  and "
            . "date_entry >= '$define_date' and not_fresh='Y' and lm_note_date is null and sk_comment is null and mut_type='01' and "
            . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'")->row()->c;

        $counts['freshreport'] = $this->db->query("select count(*) as c from     field_mut_basic where co_flag_for_fresh_mut is not null and dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'")->row()->c;

        $counts['ofcPartition'] = $this->db->query("SELECT count(*) as c from   Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code'  and date_entry >= '$define_date' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and mut_type='04' and  not_fresh='Y' and status='P' and (lm_note_yn is null ) and (lm_note_date is null) ")->row()->c;

        $counts['ofcByayPrak'] = $this->db->query("SELECT count(*) as c from   Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code'  and date_entry >= '$define_date' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and  mut_type='04' and not_fresh='Y' and status='P' and byayprak_yn is null ")->row()->c;

        $counts['mappartition'] = $this->db->query("SELECT count(*) as c from   chitha_rmk_ordbasic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and  ord_type_code='04' and map_partition='P' ")->row()->c;

        $counts['CitizenCentric'] = $this->db->query("SELECT count(*) as c from   Cert_Application WHERE LM_Checked_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and apply_date >='$define_date'  and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no'")->row()->c;

        $counts['ConsentPattadar'] = $this->db->query("SELECT count(*) as c from   Petition_Basic pb INNER JOIN (SELECT dist_code, subdiv_code, cir_code, mouza_pargona_code,"
            . " Lot_No, vill_townprt_code, Year_no, Petition_no,Patta_no, patta_type_code,dag_no from   petitioner_part GROUP BY dist_code, subdiv_code, "
            . "cir_code, mouza_pargona_code, Lot_No, vill_townprt_code, Year_no, Petition_no, Patta_no,patta_type_code,dag_no) pp ON pb.dist_code = pp.dist_code AND "
            . "pb.subdiv_code = pp.subdiv_code AND pb.cir_code = pp.cir_code AND pb.mouza_pargona_code = pp.mouza_pargona_code AND pb.Lot_No = pp.Lot_No "
            . "AND pb.vill_townprt_code = pp.vill_townprt_code AND pb.Year_no = pp.Year_no AND pb.Petition_no = pp.Petition_no WHERE pb.dist_code='$dist_code' and pb.subdiv_code='$subdiv_code'  and pb.year_no='$year_no' and pb.date_entry >= '$define_date' and pb.cir_code='$cir_code' and pb.mouza_pargona_code='$mouza_pargona_code' and pb.lot_no='$lot_no' and  pb.mut_type='04' and pb.status='P' and pb.consent_updated is null ")->row()->c;

        $counts['oconv'] = $this->getPendingLMConversionCases($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        $counts['countAPCase'] = $this->APCancellationModel->getCountAPCasesforLM($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no); //not done with the location checking
        //adding it for miscellaneous cases
        $counts['countMiscCase'] = $this->NameCorrectionModel->getMiscCaseLM($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no); //not done with the location checking

        $counts['my_info'] = $this->db->query("Select lm_code.lm_name AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed, lm_code.corres_sk_code AS corres_sk_code from  lm_code INNER JOIN loginuser_table ON "
            . "lm_code.lm_code = loginuser_table.user_code and lm_code.dist_code = loginuser_table.dist_code and "
            . "lm_code.subdiv_code = loginuser_table.subdiv_code and lm_code.cir_code = loginuser_table.cir_code and "
            . "lm_code.mouza_pargona_code = loginuser_table.mouza_pargona_code and lm_code.lot_no = loginuser_table.lot_no "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
            . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();

//        $counts['civil_appeal_basic'] = $this->db->query("SELECT count(*) as c from   civil_appeal_basic WHERE lm_sign is null and dist_code='$dist_code' and "
        //                . "subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no'")->row()->c;

        $date_of_last_password_changed = $counts['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }

        $counts['_view'] = 'home/partition_lm';
        $this->load->view('layouts/main', $counts);
    }

    public function PartitionLmOP()
    {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $user_code = $this->session->userdata('user_code');
        $year_no = year_no;
        $define_date = define_date;

        //var_dump($this->session->all_userdata());
        $user_desig_code = $this->session->userdata('user_desig_code');

        $counts['map_partition'] = $this->db->query("Select count(*) as c from  t_chitha_col8_order where map_partition is null and order_type_code='02' and "
            . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' "
            . "and lot_no = '$lot_no'  and date(co_ord_date) >= '$define_date' ")->row()->c;

        $counts['fconsent'] = $this->db->query("select count(*) as c from     field_mut_basic where order_passed is null and mut_type='02' and p_consent is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'  and date_entry >= '$define_date' ")->row()->c;

        $counts['fmutation'] = $this->db->query("select count(*) as c from     field_mut_basic where order_passed is null and mut_type='01' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'  and date_entry >= '$define_date' ")->row()->c;

        $counts['fpartition'] = $this->db->query("select count(*) as c from     field_mut_basic where order_passed is null and mut_type='02' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'  and date_entry >= '$define_date'")->row()->c;

        $counts['oconsent'] = $this->db->query("select count(*) as c from     petition_basic where order_passed is null and mut_type='04' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'  and date_entry >= '$define_date'")->row()->c;

        $counts['omutation'] = $this->db->query("select count(*) as c from     petition_basic where order_passed is null and not_fresh='Y' and lm_note_date is null and "
            . "sk_comment is null and mut_type='03' and status='P' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
            . "lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code'  and date_entry >= '$define_date'")->row()->c;

        $counts['opartition'] = $this->db->query("select count(*) as c from     petition_basic where order_passed is null  and date_entry >= '$define_date' and not_fresh='Y' and status='P' and lm_note_date is null and sk_comment is null and mut_type='04' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'")->row()->c;

        $counts['allotment_lm'] = $this->db->query("Select count(*) as c from     allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and lm_note is null and not_fresh='Y' and status='P' and co_note is not null")->row()->c;

        $counts['sronotepen'] = $this->db->query("SELECT count(*) as c from   sro_note WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and status='1' and nature_of_land = 'r'")->row()->c;

        $counts['oconversion'] = $this->db->query("select count(*) as c from     petition_basic where order_passed is null  and "
            . "date_entry >= '$define_date' and not_fresh='Y' and lm_note_date is null and sk_comment is null and mut_type='01' and "
            . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'")->row()->c;

        $counts['freshreport'] = $this->db->query("select count(*) as c from     field_mut_basic where co_flag_for_fresh_mut is not null and dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'")->row()->c;

        $counts['ofcPartition'] = $this->db->query("SELECT count(*) as c from   Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code'  and date_entry >= '$define_date' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and mut_type='04' and  not_fresh='Y' and status='P' and (lm_note_yn is null ) and (lm_note_date is null) ")->row()->c;

        $counts['ofcByayPrak'] = $this->db->query("SELECT count(*) as c from   Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code'  and date_entry >= '$define_date' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and  mut_type='04' and not_fresh='Y' and status='P' and byayprak_yn is null ")->row()->c;

        $counts['mappartition'] = $this->db->query("SELECT count(*) as c from   chitha_rmk_ordbasic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and  ord_type_code='04' and map_partition='P' ")->row()->c;

        $counts['CitizenCentric'] = $this->db->query("SELECT count(*) as c from   Cert_Application WHERE LM_Checked_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and apply_date >='$define_date'  and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no'")->row()->c;

        $counts['ConsentPattadar'] = $this->db->query("SELECT count(*) as c from   Petition_Basic pb INNER JOIN (SELECT dist_code, subdiv_code, cir_code, mouza_pargona_code,"
            . " Lot_No, vill_townprt_code, Year_no, Petition_no,Patta_no, patta_type_code,dag_no from   petitioner_part GROUP BY dist_code, subdiv_code, "
            . "cir_code, mouza_pargona_code, Lot_No, vill_townprt_code, Year_no, Petition_no, Patta_no,patta_type_code,dag_no) pp ON pb.dist_code = pp.dist_code AND "
            . "pb.subdiv_code = pp.subdiv_code AND pb.cir_code = pp.cir_code AND pb.mouza_pargona_code = pp.mouza_pargona_code AND pb.Lot_No = pp.Lot_No "
            . "AND pb.vill_townprt_code = pp.vill_townprt_code AND pb.Year_no = pp.Year_no AND pb.Petition_no = pp.Petition_no WHERE pb.dist_code='$dist_code' and pb.subdiv_code='$subdiv_code'  and pb.year_no='$year_no' and pb.date_entry >= '$define_date' and pb.cir_code='$cir_code' and pb.mouza_pargona_code='$mouza_pargona_code' and pb.lot_no='$lot_no' and  pb.mut_type='04' and pb.status='P' and pb.consent_updated is null ")->row()->c;

        $counts['oconv'] = $this->getPendingLMConversionCases($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        $counts['countAPCase'] = $this->APCancellationModel->getCountAPCasesforLM($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no); //not done with the location checking
        //adding it for miscellaneous cases
        $counts['countMiscCase'] = $this->NameCorrectionModel->getMiscCaseLM($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no); //not done with the location checking

        $counts['my_info'] = $this->db->query("Select lm_code.lm_name AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed, lm_code.corres_sk_code AS corres_sk_code from  lm_code INNER JOIN loginuser_table ON "
            . "lm_code.lm_code = loginuser_table.user_code and lm_code.dist_code = loginuser_table.dist_code and "
            . "lm_code.subdiv_code = loginuser_table.subdiv_code and lm_code.cir_code = loginuser_table.cir_code and "
            . "lm_code.mouza_pargona_code = loginuser_table.mouza_pargona_code and lm_code.lot_no = loginuser_table.lot_no "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
            . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();

//        $counts['civil_appeal_basic'] = $this->db->query("SELECT count(*) as c from   civil_appeal_basic WHERE lm_sign is null and dist_code='$dist_code' and "
        //                . "subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no'")->row()->c;

        $date_of_last_password_changed = $counts['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }

        if(ESCALATION_ENABLE == 1){
            $service_code = 3;
            $counts['service_type'] = OPART;
            $counts['escAllocateDays'] = $this->Escalationmodel->getTimeLine($service_code, 'OPART');
        }


        $counts['_view'] = 'home/partition_lm_op';
        $this->load->view('layouts/main', $counts);
    }

    public function ConversionLm()
    {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $user_code = $this->session->userdata('user_code');
        $year_no = year_no;
        $define_date = define_date;

        //var_dump($this->session->all_userdata());
        $user_desig_code = $this->session->userdata('user_desig_code');

        $counts['map_partition'] = $this->db->query("Select count(*) as c from  t_chitha_col8_order where map_partition is null and order_type_code='02' and "
            . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' "
            . "and lot_no = '$lot_no'  and date(co_ord_date) >= '$define_date' ")->row()->c;

        $counts['fconsent'] = $this->db->query("select count(*) as c from     field_mut_basic where order_passed is null and mut_type='02' and p_consent is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'  and date_entry >= '$define_date' ")->row()->c;

        $counts['fmutation'] = $this->db->query("select count(*) as c from     field_mut_basic where order_passed is null and mut_type='01' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'  and date_entry >= '$define_date' ")->row()->c;

        $counts['fpartition'] = $this->db->query("select count(*) as c from     field_mut_basic where order_passed is null and mut_type='02' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'  and date_entry >= '$define_date'")->row()->c;

        $counts['oconsent'] = $this->db->query("select count(*) as c from     petition_basic where order_passed is null and mut_type='04' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'  and date_entry >= '$define_date'")->row()->c;

        $counts['omutation'] = $this->db->query("select count(*) as c from     petition_basic where order_passed is null and not_fresh='Y' and lm_note_date is null and "
            . "sk_comment is null and mut_type='03' and status='P' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
            . "lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code'  and date_entry >= '$define_date'")->row()->c;

        $counts['opartition'] = $this->db->query("select count(*) as c from     petition_basic where order_passed is null  and date_entry >= '$define_date' and not_fresh='Y' and status='P' and lm_note_date is null and sk_comment is null and mut_type='04' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'")->row()->c;

        $counts['allotment_lm'] = $this->db->query("Select count(*) as c from     allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and lm_note is null and not_fresh='Y' and status='P' and co_note is not null")->row()->c;

        $counts['sronotepen'] = $this->db->query("SELECT count(*) as c from   sro_note WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and status='1' and nature_of_land = 'r'")->row()->c;

        $counts['oconversion'] = $this->db->query("select count(*) as c from     petition_basic where order_passed is null  and "
            . "date_entry >= '$define_date' and not_fresh='Y' and lm_note_date is null and sk_comment is null and mut_type='01' and "
            . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'")->row()->c;

        $counts['freshreport'] = $this->db->query("select count(*) as c from     field_mut_basic where co_flag_for_fresh_mut is not null and dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'")->row()->c;

        $counts['ofcPartition'] = $this->db->query("SELECT count(*) as c from   Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code'  and date_entry >= '$define_date' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and mut_type='04' and  not_fresh='Y' and status='P' and (lm_note_yn is null ) and (lm_note_date is null) ")->row()->c;

        $counts['ofcByayPrak'] = $this->db->query("SELECT count(*) as c from   Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code'  and date_entry >= '$define_date' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and  mut_type='04' and not_fresh='Y' and status='P' and byayprak_yn is null ")->row()->c;

        $counts['mappartition'] = $this->db->query("SELECT count(*) as c from   chitha_rmk_ordbasic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and  ord_type_code='04' and map_partition='P' ")->row()->c;

        $counts['CitizenCentric'] = $this->db->query("SELECT count(*) as c from   Cert_Application WHERE LM_Checked_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and apply_date >='$define_date'  and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no'")->row()->c;

        $counts['ConsentPattadar'] = $this->db->query("SELECT count(*) as c from   Petition_Basic pb INNER JOIN (SELECT dist_code, subdiv_code, cir_code, mouza_pargona_code,"
            . " Lot_No, vill_townprt_code, Year_no, Petition_no,Patta_no, patta_type_code,dag_no from   petitioner_part GROUP BY dist_code, subdiv_code, "
            . "cir_code, mouza_pargona_code, Lot_No, vill_townprt_code, Year_no, Petition_no, Patta_no,patta_type_code,dag_no) pp ON pb.dist_code = pp.dist_code AND "
            . "pb.subdiv_code = pp.subdiv_code AND pb.cir_code = pp.cir_code AND pb.mouza_pargona_code = pp.mouza_pargona_code AND pb.Lot_No = pp.Lot_No "
            . "AND pb.vill_townprt_code = pp.vill_townprt_code AND pb.Year_no = pp.Year_no AND pb.Petition_no = pp.Petition_no WHERE pb.dist_code='$dist_code' and pb.subdiv_code='$subdiv_code'  and pb.year_no='$year_no' and pb.date_entry >= '$define_date' and pb.cir_code='$cir_code' and pb.mouza_pargona_code='$mouza_pargona_code' and pb.lot_no='$lot_no' and  pb.mut_type='04' and pb.status='P' and pb.consent_updated is null ")->row()->c;

        $counts['oconv'] = $this->getPendingLMConversionCases($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        $counts['countAPCase'] = $this->APCancellationModel->getCountAPCasesforLM($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no); //not done with the location checking
        //adding it for miscellaneous cases
        $counts['countMiscCase'] = $this->NameCorrectionModel->getMiscCaseLM($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no); //not done with the location checking

        $counts['my_info'] = $this->db->query("Select lm_code.lm_name AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed, lm_code.corres_sk_code AS corres_sk_code from  lm_code INNER JOIN loginuser_table ON "
            . "lm_code.lm_code = loginuser_table.user_code and lm_code.dist_code = loginuser_table.dist_code and "
            . "lm_code.subdiv_code = loginuser_table.subdiv_code and lm_code.cir_code = loginuser_table.cir_code and "
            . "lm_code.mouza_pargona_code = loginuser_table.mouza_pargona_code and lm_code.lot_no = loginuser_table.lot_no "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
            . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();

//        $counts['civil_appeal_basic'] = $this->db->query("SELECT count(*) as c from   civil_appeal_basic WHERE lm_sign is null and dist_code='$dist_code' and "
        //                . "subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no'")->row()->c;

        $date_of_last_password_changed = $counts['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }

        if(ESCALATION_ENABLE == 1){
            $service_code = 9;
            $counts['service_type'] = CONV_SERV;
            $counts['escAllocateDays'] = $this->Escalationmodel->getTimeLine($service_code, 'CONVR');
            $counts['escAllocateDaysP'] = $this->Escalationmodel->getTimeLine($service_code, 'CONVP');
            $counts['escAllocateDaysU'] = $this->Escalationmodel->getTimeLine($service_code, 'CONVU');
        }

        $counts['_view'] = 'home/conversion_lm';
        $this->load->view('layouts/main', $counts);
    }
    public function CitizenLm()
    {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $user_code = $this->session->userdata('user_code');
        $year_no = year_no;
        $define_date = define_date;

        $counts['CitizenCentric'] = $this->db->query("SELECT count(*) as c from   Cert_Application WHERE LM_Checked_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and apply_date >='$define_date'  and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no'")->row()->c;

        $counts['_view'] = 'home/citizen_lm';
        $this->load->view('layouts/main', $counts);
    }

    public function LandReLm()
    {
        $allowed = ['LM'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $user_code = $this->session->userdata('user_code');
        $year_no = year_no;

        $counts['land_proposals_returned_DC'] = $this->db->query("SELECT count(*) as c from  t_reclassification WHERE status='M' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' ")->row()->c;

        if(ESCALATION_ENABLE == 1){

            $counts['count'] = $this->db->query("select t_reclassification.*, t_reclassification.case_no as
                                c_no, basundhar_application.basundhara as rtps_no, escalation_details.* FROM t_reclassification
                                left join basundhar_application on t_reclassification.case_no = basundhar_application.dharitree
                                left join escalation_details on t_reclassification.case_no = escalation_details.case_no
                                where dist_code=? AND subdiv_code=? AND cir_code=? AND 
                                t_reclassification.lm_yn IS NULL
                                and t_reclassification.lm_date is null AND t_reclassification.es_flag=?", 
                                array($dist_code, $subdiv_code, $cir_code, '1'))->num_rows();

            $service_code = 4;
            $counts['service_type'] = RECLASS_SERV;
            $counts['escAllocateDays'] = $this->Escalationmodel->getTimeLine($service_code, 'RECLASS');
        }

        $counts['_view'] = 'home/landre_lm';
        $this->load->view('layouts/main', $counts);
    }

    public function MiscLm()
    {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $user_code = $this->session->userdata('user_code');
        $year_no = year_no;
        $define_date = define_date;

        $counts['countMiscCase'] = $this->NameCorrectionModel->getMiscCaseLM($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no); //not done with the location checking
        $counts['countMiscCaseRevert'] = $this->NameCorrectionModel->getMiscCaseLMRevert($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $counts['countMiscCaseRevertNC'] = $this->NameCancellationModel->getMiscCaseLMRevert($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no); 

        

        if(ESCALATION_ENABLE == 1){
            
            $service_code = 8; //for NCAN=====
            $service_code_ncor = 6; //for NCOR=====
            $counts['service_type']    = MIND_SERV;
            // $counts['service_type']    = NCAN_SERV;
            $counts['escAllocateDays'] = $this->Escalationmodel->getTimeLine($service_code, 'NCAN');
            $counts['escAllocateDaysNCOR'] = $this->Escalationmodel->getTimeLine($service_code_ncor, 'NCOR');
            $counts['countMiscCaseEscalation'] = $this->NameCorrectionModelV2->getMiscCaseLMforEscalation($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
            $counts['countMiscCaseRevertEsc'] = $this->NameCorrectionModelV2->getMiscCaseLMRevertEsc($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        }


        $counts['_view'] = 'home/misc_lm';
        $this->load->view('layouts/main', $counts);
    }
    public function ApcLm()
    {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $user_code = $this->session->userdata('user_code');
        $year_no = year_no;
        $define_date = define_date;

        //var_dump($this->session->all_userdata());
        $user_desig_code = $this->session->userdata('user_desig_code');

        $counts['countAPCase'] = $this->APCancellationModel->getCountAPCasesforLM($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no); //not done with the location checking

        $counts['_view'] = 'home/apc_lm';
        $this->load->view('layouts/main', $counts);
    }

    public function AcPpLm()
    {

        $allowed = ['LM'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $user_code = $this->session->userdata('user_code');
        $year_no = year_no;
        $define_date = define_date;

        //var_dump($this->session->all_userdata());
        $user_desig_code = $this->session->userdata('user_desig_code');

        $counts['allotment_lm'] = $this->db->query("Select count(*) as c from     allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and lm_note is null and not_fresh='Y' and status='P' and co_note is not null")->row()->c;

        $counts['countAPCase'] = $this->APCancellationModel->getCountAPCasesforLM($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        if(ESCALATION_ENABLE == 1)
        {
            $service_code = 5;
            $counts['service_type'] = ALLOT_SERV;
            $counts['escAllocateDays'] = $this->Escalationmodel->getTimeLine($service_code, 'ACPP');
        }

        $counts['_view'] = 'home/acpp_lm';
        $this->load->view('layouts/main', $counts);
    }

    public function MutationSk()
    {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $year_no = year_no;
        $define_date = define_date;
        // echo "select  count(*) as c from field_mut_basic where order_passed is null and sk_flag is null and is_dispose='S' and dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";

        $append = "dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code'";

        $counts['fmutation'] = $this->db->query("select count(*) as c from     field_mut_basic where es_flag=0 and order_passed is null and sk_flag is null and mut_type='01'  and date_entry >= '$define_date' and " . $append)->row()->c;

        $counts['fpartition'] = $this->db->query("select  count(*) as c from     field_mut_basic where es_flag=0 and  order_passed is null and sk_flag is null and mut_type='02'and dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;
        $counts['reverted'] = $this->db->query("select  count(*) as c from field_mut_basic where order_passed is null  and is_dispose='S' and dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;
        $counts['omutation'] = $this->db->query("SELECT count(*) as c from   Petition_basic WHERE  not_fresh='Y' and sk_comment is null and  lm_note_date is not null and order_passed is null and mut_type='01'  and date_entry >= '$define_date' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $counts['oconversion'] = $this->db->query("SELECT count(*) as c from   Petition_basic WHERE  not_fresh='Y' and sk_comment is null and  lm_note_date is not null and order_passed is null and mut_type='01'  and date_entry >= '$define_date' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $counts['omutation'] = $this->db->query("SELECT count(*) as c from   Petition_basic WHERE  not_fresh='Y' and sk_comment is null and  lm_note_date is not null and order_passed is null and mut_type='03' and dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $counts['opartition'] = $this->db->query("SELECT count(*) as c from   Petition_basic WHERE  not_fresh='Y' and sk_comment is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  lm_note_date is not null and order_passed is null and mut_type='04' and dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $counts['cases'] = $this->db->query("select count(*) as c from     petition_basic where not_fresh = 'Y'  and date_entry >= '$define_date' and lm_note_yn = 'Y' and status = 'P' and sk_comment is null and mut_type='01' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $counts['allotment_sk'] = $this->db->query("Select count(*) as c from     allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and lm_note='Y' and sk_note is null and not_fresh='Y' and status='P' and co_note is not null and settlement_typ is null")->row()->c;

        $counts['countAPCaseforSK'] = $this->APCancellationModel->getCountAPCasesforSK(); //not done with the location checking
        //adding it for miscellaneous cases
        $counts['countMiscCaseSK'] = $this->NameCorrectionModel->getMiscCaseSK($user_code); //not done with the location checking

        $counts['grant_sk'] = $this->db->query("Select count(*) as c from     allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and lm_note='Y'  and sk_note is null and not_fresh='Y' and status='P' and settlement_typ='gr' ")->row()->c;

        $counts['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from     users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.user_code = '$user_code'")->row();

        $date_of_last_password_changed = $counts['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }

        $counts['_view'] = 'home/mutation_sk';
        $this->load->view('layouts/main', $counts);
    }

    public function ConversionSk()
    {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $year_no = year_no;
        $define_date = define_date;

        $append = "dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code'";

        $counts['fmutation'] = $this->db->query("select count(*) as c from     field_mut_basic where order_passed is null and sk_flag is null and mut_type='01'  and date_entry >= '$define_date' and " . $append)->row()->c;

        $counts['fpartition'] = $this->db->query("select  count(*) as c from     field_mut_basic where order_passed is null and sk_flag is null and mut_type='02'and dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $counts['omutation'] = $this->db->query("SELECT count(*) as c from   Petition_basic WHERE  not_fresh='Y' and sk_comment is null and  lm_note_date is not null and order_passed is null and mut_type='01'  and date_entry >= '$define_date' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $counts['oconversion'] = $this->db->query("SELECT count(*) as c from   Petition_basic WHERE  not_fresh='Y' and sk_comment is null and  lm_note_date is not null and order_passed is null and mut_type='01'  and date_entry >= '$define_date' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $counts['omutation'] = $this->db->query("SELECT count(*) as c from   Petition_basic WHERE  not_fresh='Y' and sk_comment is null and  lm_note_date is not null and order_passed is null and mut_type='03' and dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $counts['opartition'] = $this->db->query("SELECT count(*) as c from   Petition_basic WHERE  not_fresh='Y' and sk_comment is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  lm_note_date is not null and order_passed is null and mut_type='04' and dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $counts['cases'] = $this->db->query("select count(*) as c from     petition_basic where is_mb3!=1 and not_fresh = 'Y'  and date_entry >= '$define_date' and lm_note_yn = 'Y' and status = 'P' and sk_comment is null and mut_type='01' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $counts['allotment_sk'] = $this->db->query("Select count(*) as c from     allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and lm_note='Y' and sk_note is null and not_fresh='Y' and status='P' and co_note is not null")->row()->c;

        $counts['countAPCaseforSK'] = $this->APCancellationModel->getCountAPCasesforSK(); //not done with the location checking
        //adding it for miscellaneous cases
        $counts['countMiscCaseSK'] = $this->NameCorrectionModel->getMiscCaseSK($user_code); //not done with the location checking

        $counts['grant_sk'] = $this->db->query("Select count(*) as c from     allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and lm_note='Y'  and sk_note is null and not_fresh='Y' and status='P' and settlement_typ='gr' ")->row()->c;

        $counts['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from     users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.user_code = '$user_code'")->row();

        $date_of_last_password_changed = $counts['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }

        $counts['_view'] = 'home/conversion_sk';
        $this->load->view('layouts/main', $counts);
    }

    public function AcPPSk()
    {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $year_no = year_no;
        $define_date = define_date;

        $append = "dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code'";

        $counts['fmutation'] = $this->db->query("select count(*) as c from     field_mut_basic where order_passed is null and sk_flag is null and mut_type='01'  and date_entry >= '$define_date' and " . $append)->row()->c;

        $counts['fpartition'] = $this->db->query("select  count(*) as c from     field_mut_basic where order_passed is null and sk_flag is null and mut_type='02'and dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $counts['omutation'] = $this->db->query("SELECT count(*) as c from   Petition_basic WHERE  not_fresh='Y' and sk_comment is null and  lm_note_date is not null and order_passed is null and mut_type='01'  and date_entry >= '$define_date' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $counts['oconversion'] = $this->db->query("SELECT count(*) as c from   Petition_basic WHERE  not_fresh='Y' and sk_comment is null and  lm_note_date is not null and order_passed is null and mut_type='01'  and date_entry >= '$define_date' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $counts['omutation'] = $this->db->query("SELECT count(*) as c from   Petition_basic WHERE  not_fresh='Y' and sk_comment is null and  lm_note_date is not null and order_passed is null and mut_type='03' and dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $counts['opartition'] = $this->db->query("SELECT count(*) as c from   Petition_basic WHERE  not_fresh='Y' and sk_comment is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  lm_note_date is not null and order_passed is null and mut_type='04' and dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $counts['cases'] = $this->db->query("select count(*) as c from     petition_basic where not_fresh = 'Y'  and date_entry >= '$define_date' and lm_note_yn = 'Y' and status = 'P' and sk_comment is null and mut_type='01' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $counts['allotment_sk'] = $this->db->query("Select count(*) as c from     allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and lm_note='Y' and sk_note is null and not_fresh='Y' and status='P' and co_note is not null")->row()->c;

        $counts['countAPCaseforSK'] = $this->APCancellationModel->getCountAPCasesforSK(); //not done with the location checking
        //adding it for miscellaneous cases
        $counts['countMiscCaseSK'] = $this->NameCorrectionModel->getMiscCaseSK($user_code); //not done with the location checking

        $counts['grant_sk'] = $this->db->query("Select count(*) as c from     allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and lm_note='Y'  and sk_note is null and not_fresh='Y' and status='P' and settlement_typ='gr' ")->row()->c;

        $counts['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from     users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.user_code = '$user_code'")->row();

        $date_of_last_password_changed = $counts['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }

        if(ESCALATION_ENABLE == 1)
        {
            $service_code = 5;
            $counts['service_type'] = ALLOT_SERV;
            $counts['escAllocateDays'] = $this->Escalationmodel->getTimeLine($service_code, 'ACPP');
        }

        $counts['_view'] = 'home/acpp_sk';
        $this->load->view('layouts/main', $counts);
    }

    public function MiscSk()
    {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $year_no = year_no;
        $define_date = define_date;

        $append = "dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code'";

        $counts['fmutation'] = $this->db->query("select count(*) as c from     field_mut_basic where order_passed is null and sk_flag is null and mut_type='01'  and date_entry >= '$define_date' and " . $append)->row()->c;

        $counts['fpartition'] = $this->db->query("select  count(*) as c from     field_mut_basic where order_passed is null and sk_flag is null and mut_type='02'and dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $counts['omutation'] = $this->db->query("SELECT count(*) as c from   Petition_basic WHERE  not_fresh='Y' and sk_comment is null and  lm_note_date is not null and order_passed is null and mut_type='01'  and date_entry >= '$define_date' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $counts['oconversion'] = $this->db->query("SELECT count(*) as c from   Petition_basic WHERE  not_fresh='Y' and sk_comment is null and  lm_note_date is not null and order_passed is null and mut_type='01'  and date_entry >= '$define_date' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $counts['omutation'] = $this->db->query("SELECT count(*) as c from   Petition_basic WHERE  not_fresh='Y' and sk_comment is null and  lm_note_date is not null and order_passed is null and mut_type='03' and dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $counts['opartition'] = $this->db->query("SELECT count(*) as c from   Petition_basic WHERE  not_fresh='Y' and sk_comment is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  lm_note_date is not null and order_passed is null and mut_type='04' and dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $counts['cases'] = $this->db->query("select count(*) as c from     petition_basic where not_fresh = 'Y'  and date_entry >= '$define_date' and lm_note_yn = 'Y' and status = 'P' and sk_comment is null and mut_type='01' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $counts['allotment_sk'] = $this->db->query("Select count(*) as c from     allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and lm_note='Y' and sk_note is null and not_fresh='Y' and status='P' and co_note is not null")->row()->c;

        $counts['countAPCaseforSK'] = $this->APCancellationModel->getCountAPCasesforSK(); //not done with the location checking
        //adding it for miscellaneous cases
        $counts['countMiscCaseSK'] = $this->NameCorrectionModel->getMiscCaseSK($user_code); //not done with the location checking

        $counts['grant_sk'] = $this->db->query("Select count(*) as c from     allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and lm_note='Y'  and sk_note is null and not_fresh='Y' and status='P' and settlement_typ='gr' ")->row()->c;

        $counts['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from     users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.user_code = '$user_code'")->row();

        $date_of_last_password_changed = $counts['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }

        $counts['_view'] = 'home/misc_sk';
        $this->load->view('layouts/main', $counts);
    }

    public function MutationCo()
    {
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page',
        );

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';

        $data['map_partition'] = $this->db->query("Select count(*) as c from  t_chitha_col8_order where map_partition!=null and "
            . " order_type_code='02' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  "
            . "and date(co_ord_date) >= '$define_date'  and iscorrected_inco is null")->row()->c;

        $officemutationCount = $this->cofieldmutationmodel->countPendingMutationCases($dist_code, $subdiv_code, $cir_code);
        $data['fmutation'] = $officemutationCount;

        $officepartitionCount = $this->cofieldmutationmodel->countPendingPartitionCases($dist_code, $subdiv_code, $cir_code);
        $data['fpartition'] = $officepartitionCount;

        $data['opartition'] = $this->getPendingOfficePartitionCases($dist_code, $subdiv_code, $cir_code);
        $data['omutation'] = $this->getPendingOfficeMutationCases($dist_code, $subdiv_code, $cir_code);

        $data['oconv'] = $this->getPendingConversionCases($user_code, $dist_code, $subdiv_code, $cir_code);
        $data['first_proceeding'] = $this->getFirstProceedingConvertion($user_code, $dist_code, $subdiv_code, $cir_code);
        $data['second_proceeding'] = $this->getSecondProceedingConvertion($user_code, $dist_code, $subdiv_code, $cir_code);
        $data['third_proceeding'] = $this->getConvertionOrderPassedByDC($user_desig_code, $dist_code, $subdiv_code, $cir_code);
        $data['rejected_proceeding'] = $this->getRejectedProceedingConvertion($user_code, $dist_code, $subdiv_code, $cir_code);
        $data['conversion_proceeding_report'] = $this->getconversion_proceeding_report($user_code, $dist_code, $subdiv_code, $cir_code);

        $data['mfirst_proceeding'] = $this->getFisrtProceedingMutation($user_code, $dist_code, $subdiv_code, $cir_code);
        $data['msecond_proceeding'] = $this->getSecondProceedingMutation($user_code, $dist_code, $subdiv_code, $cir_code);
        $data['pfirst_proceeding'] = $this->getFisrtProceedingPartition($user_code, $dist_code, $subdiv_code, $cir_code);
        $data['psecond_proceeding'] = $this->getSecondProceedingPartition($user_code, $dist_code, $subdiv_code, $cir_code);

        $data['sronote'] = $this->db->query("SELECT * from  sro_note WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status!='3' and (deed_type='SALE' or deed_type='GIFT' ) order by update_date desc   limit 10 ")->result();

        $data['countAPCaseforCO'] = $this->APCancellationModel->getCountAPCasesforCO(); //not used location condition
        $data['countNoteHearingAPCaseforCO'] = $this->APCancellationModel->getNoteHearingAPCasesforCO(); //not used location condition
        $data['getOrderAPCancellation'] = $this->APCancellationModel->getOrderAPCancellation(); //not used location condition

        $data['fchithaupdates'] = $this->getPendingFieldChithaUpdates();
        $data['ochithaupdates'] = $this->getPendingOfficeChithaUpdates();

        $data['grant_finalco'] = $this->db->query("Select count(*) as c from  allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and not_fresh is not null and status is not null and lm_note='Y' and sk_note='Y' and chitha_correct_yn is null and settlement_typ='gr' ")->row()->c; //Bondita

        $data['FirstPro'] = $this->db->query("SELECT count(*) as c from  Petition_basic WHERE comp_serv_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='04' and co_user_code='$user_code' and (status!='D' or status is null) and not_fresh is null and lm_note_yn is null and date_entry >= '$define_date' ")->row()->c;

        $data['SecondPro'] = $this->db->query("SELECT count(*) as c from  Petition_basic WHERE comp_serv_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and co_user_code='$user_code'  and mut_type='04' and not_fresh = 'Y' and status='P' and date_entry >= '$define_date' ")->row()->c;

        $data['citizenPendingCO'] = $this->db->query("SELECT count(*) as c from  Cert_Application WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and LM_Checked_yn='Y' and CO_Checked_yn is null and status = 'C' and apply_date >= '$define_date'")->row()->c;

        $data['land_proposals'] = $this->db->query("SELECT count(*) as c from   t_reclassification WHERE co_yn is null and dc_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status != 'R' OR status is null)")->row()->c;

        $data['g_trans_for_dc'] = $this->db->query("SELECT count(*) as c from  t_reclassification WHERE co_yn = 'Y' and dc_yn is null and dc_approval is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status != 'R' OR status is null)")->row()->c;

        $data['land_proposals_returned_DC'] = $this->db->query("SELECT count(*) as c from  t_reclassification WHERE co_yn = 'Y' and dc_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and dc_approval is not null and (status != 'R' OR status is null)")->row()->c;

        $data['land_proposals_for_jamaupdate'] = $this->db->query("SELECT count(*) as c from   t_reclassification as t JOIN  chitha_basic as c ON c.dist_code=t.dist_code and "
            . "c.subdiv_code = t.subdiv_code and c.cir_code = t.cir_code and c.mouza_pargona_code=t.mouza_pargona_code and c.lot_no=t.lot_no and "
            . "c.vill_townprt_code=t.vill_townprt_code and c.dag_no = t.dag_no and trim(c.patta_no) = trim(t.patta_no) and c.dist_code='$dist_code' and "
            . "c.subdiv_code='$subdiv_code' and c.cir_code='$cir_code' and t.co_chitha_updated_yn = 'Y' and c.jama_yn != 'y'")->row()->c;

        $data['pending_objection'] = $this->db->query("Select count(*) as c from  field_mut_objection where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and obj_flag is null and entry_date >= '$define_date' ")->row()->c;

        $data['proceedingPartRpt'] = $this->proceedingReportpart($user_code, $dist_code, $subdiv_code, $cir_code);

        $data['proceedingMutRpt'] = $this->proceedingReportofcmut($user_code, $dist_code, $subdiv_code, $cir_code, $year_no, $define_date);

        $data['name_correction'] = $this->db->query("SELECT count(*) as c from   t_chitha_rmk_ordbasic WHERE ord_type_code = '05' and "
            . "iscorrected_inco is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $data['partchithaupdate'] = $this->db->query("SELECT count(*) as c from   t_chitha_rmk_ordbasic WHERE ord_type_code = '04' and iscorrected_inco is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        //for miscellaneous cases i.e Name Correction
        $data['MisCases'] = $this->NameCorrectionModel->getMiscCases($user_code, $dist_code, $subdiv_code, $cir_code);

        $data['MisCasesNC'] = $this->NameCancellationModel->getMiscCasesNC($user_code, $dist_code, $subdiv_code, $cir_code);

        $data['FinalOrderMisc'] = $this->NameCorrectionModel->getFinalOrderMisc($user_code);

        $data['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from  users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
            . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();

//        $data['civil_appeal_basic'] = $this->db->query("SELECT count(*) as c from   civil_appeal_basic WHERE co_order_yn is null and chitha_correct_yn is null and status = 'P' and"
//                . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;
        if(ESCALATION_ENABLE == 1){
            $service_code            = 1;
            $data['service_type']     = FMUT;
            $data['escAllocateDays'] = $this->Escalationmodel->getTimeLine($service_code, FMUT);
            $data['escAllocateDaysDeed'] = $this->Escalationmodel->getTimeLine(2, 'FMUTD');
        }
        
        $date_of_last_password_changed = $data['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }
        $data['_view'] = 'home/mutation_co';
        $this->load->view('layouts/main', $data);
    }

    public function MutationCoOM()
    {
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page',
        );

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';

        $data['map_partition'] = $this->db->query("Select count(*) as c from  t_chitha_col8_order where map_partition!=null and "
            . " order_type_code='02' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  "
            . "and date(co_ord_date) >= '$define_date'  and iscorrected_inco is null")->row()->c;

        $officemutationCount = $this->cofieldmutationmodel->countPendingMutationCases($dist_code, $subdiv_code, $cir_code);
        $data['fmutation'] = $officemutationCount;

        $officepartitionCount = $this->cofieldmutationmodel->countPendingPartitionCases($dist_code, $subdiv_code, $cir_code);
        $data['fpartition'] = $officepartitionCount;

        $data['opartition'] = $this->getPendingOfficePartitionCases($dist_code, $subdiv_code, $cir_code);
        $data['omutation'] = $this->getPendingOfficeMutationCases($dist_code, $subdiv_code, $cir_code);

        $data['oconv'] = $this->getPendingConversionCases($user_code, $dist_code, $subdiv_code, $cir_code);
        $data['first_proceeding'] = $this->getFirstProceedingConvertion($user_code, $dist_code, $subdiv_code, $cir_code);
        $data['second_proceeding'] = $this->getSecondProceedingConvertion($user_code, $dist_code, $subdiv_code, $cir_code);
        $data['third_proceeding'] = $this->getConvertionOrderPassedByDC($user_desig_code, $dist_code, $subdiv_code, $cir_code);
        $data['rejected_proceeding'] = $this->getRejectedProceedingConvertion($user_code, $dist_code, $subdiv_code, $cir_code);
        $data['conversion_proceeding_report'] = $this->getconversion_proceeding_report($user_code, $dist_code, $subdiv_code, $cir_code);

        $data['mfirst_proceeding'] = $this->getFisrtProceedingMutation($user_code, $dist_code, $subdiv_code, $cir_code);
        $data['msecond_proceeding'] = $this->getSecondProceedingMutation($user_code, $dist_code, $subdiv_code, $cir_code);
        $data['pfirst_proceeding'] = $this->getFisrtProceedingPartition($user_code, $dist_code, $subdiv_code, $cir_code);
        $data['psecond_proceeding'] = $this->getSecondProceedingPartition($user_code, $dist_code, $subdiv_code, $cir_code);

        $data['sronote'] = $this->db->query("SELECT * from  sro_note WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status!='3' and (deed_type='SALE' or deed_type='GIFT' ) order by update_date desc   limit 10 ")->result();

        $data['countAPCaseforCO'] = $this->APCancellationModel->getCountAPCasesforCO(); //not used location condition
        $data['countNoteHearingAPCaseforCO'] = $this->APCancellationModel->getNoteHearingAPCasesforCO(); //not used location condition
        $data['getOrderAPCancellation'] = $this->APCancellationModel->getOrderAPCancellation(); //not used location condition

        $data['fchithaupdates'] = $this->getPendingFieldChithaUpdates();
        $data['ochithaupdates'] = $this->getPendingOfficeChithaUpdates();

        $data['grant_finalco'] = $this->db->query("Select count(*) as c from  allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and not_fresh is not null and status is not null and lm_note='Y' and sk_note='Y' and chitha_correct_yn is null and settlement_typ='gr' ")->row()->c; //Bondita

        $data['FirstPro'] = $this->db->query("SELECT count(*) as c from  Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='04' and co_user_code='$user_code' and (status!='D' or status is null) and not_fresh is null and lm_note_yn is null and date_entry >= '$define_date' ")->row()->c;

        $data['SecondPro'] = $this->db->query("SELECT count(*) as c from  Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and co_user_code='$user_code'  and mut_type='04' and not_fresh = 'Y' and status='P' and date_entry >= '$define_date' ")->row()->c;

        $data['citizenPendingCO'] = $this->db->query("SELECT count(*) as c from  Cert_Application WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and LM_Checked_yn='Y' and CO_Checked_yn is null and status = 'C' and apply_date >= '$define_date'")->row()->c;

        $data['land_proposals'] = $this->db->query("SELECT count(*) as c from   t_reclassification WHERE co_yn is null and dc_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status != 'R' OR status is null)")->row()->c;

        $data['g_trans_for_dc'] = $this->db->query("SELECT count(*) as c from  t_reclassification WHERE co_yn = 'Y' and dc_yn is null and dc_approval is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status != 'R' OR status is null)")->row()->c;

        $data['land_proposals_returned_DC'] = $this->db->query("SELECT count(*) as c from  t_reclassification WHERE co_yn = 'Y' and dc_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and dc_approval is not null and (status != 'R' OR status is null)")->row()->c;

        $data['land_proposals_for_jamaupdate'] = $this->db->query("SELECT count(*) as c from   t_reclassification as t JOIN  chitha_basic as c ON c.dist_code=t.dist_code and "
            . "c.subdiv_code = t.subdiv_code and c.cir_code = t.cir_code and c.mouza_pargona_code=t.mouza_pargona_code and c.lot_no=t.lot_no and "
            . "c.vill_townprt_code=t.vill_townprt_code and c.dag_no = t.dag_no and trim(c.patta_no) = trim(t.patta_no) and c.dist_code='$dist_code' and "
            . "c.subdiv_code='$subdiv_code' and c.cir_code='$cir_code' and t.co_chitha_updated_yn = 'Y' and c.jama_yn != 'y'")->row()->c;

        $data['pending_objection'] = $this->db->query("Select count(*) as c from  field_mut_objection where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and obj_flag is null and entry_date >= '$define_date' ")->row()->c;

        $data['proceedingPartRpt'] = $this->proceedingReportpart($user_code, $dist_code, $subdiv_code, $cir_code);

        $data['proceedingMutRpt'] = $this->proceedingReportofcmut($user_code, $dist_code, $subdiv_code, $cir_code, $year_no, $define_date);

        $data['name_correction'] = $this->db->query("SELECT count(*) as c from   t_chitha_rmk_ordbasic WHERE ord_type_code = '05' and "
            . "iscorrected_inco is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $data['partchithaupdate'] = $this->db->query("SELECT count(*) as c from   t_chitha_rmk_ordbasic WHERE ord_type_code = '04' and iscorrected_inco is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        //for miscellaneous cases i.e Name Correction
        $data['MisCases'] = $this->NameCorrectionModel->getMiscCases($user_code, $dist_code, $subdiv_code, $cir_code);

        $data['MisCasesNC'] = $this->NameCancellationModel->getMiscCasesNC($user_code, $dist_code, $subdiv_code, $cir_code);

        $data['FinalOrderMisc'] = $this->NameCorrectionModel->getFinalOrderMisc($user_code);

        $data['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from  users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
            . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();

//        $data['civil_appeal_basic'] = $this->db->query("SELECT count(*) as c from   civil_appeal_basic WHERE co_order_yn is null and chitha_correct_yn is null and status = 'P' and"
//                . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;
        if(ESCALATION_ENABLE == 1){
            $service_code = 1;
            $data['service_type'] = OMUT;
            $data['escAllocateDays'] = $this->Escalationmodel->getTimeLine($service_code, OMUT);
            $data['escAllocateDaysDeed'] = $this->Escalationmodel->getTimeLine(2, 'OMUTD');
        }
        $data['on'] = false;
        if($dist_code == '24' && $subdiv_code == '01' && $cir_code == '03')
        {
            $data['on'] = true;
        }

        $date_of_last_password_changed = $data['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }
        $data['_view'] = 'home/mutation_co_om';
        $this->load->view('layouts/main', $data);
    }

    public function CitizenCo()
    {

        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page',
        );

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';

        $data['citizenPendingCO'] = $this->db->query("SELECT count(*) as c from  Cert_Application WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and LM_Checked_yn='Y' and CO_Checked_yn is null and status = 'C' and apply_date >= '$define_date'")->row()->c;

        ///////////////////////
        $url = RTPS_API_LINK."cicleWiseRegisterCaseROR/$dist_code/$subdiv_code/$cir_code" ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $output = curl_exec($ch);
        // log_message('error',$output);
        
        curl_close($ch);
        $data['output'] = $outputnew = json_decode($output);

        $data['count_dsc_ror'] = $outputnew->data[0]->count;
        $data['service_code'] = $outputnew->data[0]->service_code;

        // var_dump($outputnew->data[0]->count);exit;

        ////////////////////////
        $data['_view'] = 'home/citizen_co';
        $this->load->view('layouts/main', $data);
    }

    public function AcPPCo()
    {
        $allowed = ['CO'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page',
        );

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';

        $data['citizenPendingCO'] = $this->db->query("SELECT count(*) as c from  Cert_Application WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and LM_Checked_yn='Y' and CO_Checked_yn is null and status = 'C' and apply_date >= '$define_date'")->row()->c;

        $data['allotment_first'] = $this->db->query("Select count(*) as c from  allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  not_fresh is null and status is null and settlement_typ is null")->row()->c;
        $data['allotment_second'] = $this->db->query("Select count(*) as c from  allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  not_fresh='Y' and status='P' and co_note is not null and settlement_typ is null")->row()->c;
        $data['allotment_final'] = $this->db->query("Select count(*) as c from  allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  status='F' and dc_code is not null and chitha_correct_yn is null and settlement_typ is null")->row()->c;

        if(ESCALATION_ENABLE == 1)
        {
            $service_code = 5;
            $data['service_type'] = ALLOT_SERV;
            $data['escAllocateDays'] = $this->Escalationmodel->getTimeLine($service_code, 'ACPP');
        }

        $data['_view'] = 'home/acpp_co';
        $this->load->view('layouts/main', $data);
    }

    public function MiscCo()
    {
        $allowed = ['CO'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page',
        );

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';

        $data['pending_objection'] = $this->db->query("Select count(*) as c from  field_mut_objection where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and obj_flag is null and entry_date >= '$define_date' ")->row()->c;

        // //for miscellaneous cases i.e Name Correction
        $data['MisCases'] = $this->NameCorrectionModel->getMiscCases($user_code, $dist_code, $subdiv_code, $cir_code);

        $data['MisCasesNC'] = $this->NameCancellationModel->getMiscCasesNC($user_code, $dist_code, $subdiv_code, $cir_code);

        //$data['FinalOrderMisc'] = $this->NameCorrectionModel->getFinalOrderMisc($user_code);
        $data['FinalOrderMisc'] = $this->NameCorrectionModel->getFinalOrderMisc($user_code);
        $data['FinalOrderMiscDel'] = $this->NameCorrectionModel->getFinalOrderMiscDelete($user_code);

        // $date_of_last_password_changed = $data['my_info']->date_password_changed;
        // if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
        //     $this->updatepasswordnow($user_code, $user_desig_code);
        // }
        
        if(ESCALATION_ENABLE == 1){
            $service_code = 8; //for NCAN=====
            $service_code_ncor = 6; //for NCOR=====
            $data['service_type']    = MIND_SERV;
            // $data['service_type']    = MINC_SERV;
            $data['escAllocateDays'] = $this->Escalationmodel->getTimeLine($service_code, 'NCAN');
            $data['escAllocateDaysNCOR'] = $this->Escalationmodel->getTimeLine($service_code_ncor, 'NCOR');

            // var_dump($data['escAllocateDaysNCOR']); die;
           $data['countMiscCaseEscalation'] = $this->NameCorrectionModelV2->getMiscCaseLMforEscalationCO($dist_code, $subdiv_code, $cir_code);
           $data['countMiscCaseRevertEsc'] = $this->NameCorrectionModelV2->getMiscCaseCORevertEsc($dist_code, $subdiv_code, $cir_code);
        }

        $data['_view'] = 'home/misc_co';
        $this->load->view('layouts/main', $data);
    }

    public function ConversionBo()
    {

        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        //
        $subdiv_code = '00';
        $cir_code = '00';
        $mouza_pargona_code = '00';
        $lot_no = '00';
        //
        $counts['bo_notice'] = $this->getPendingBoNoticeGeneratedConversionCases($user_code, $dist_code);
        $counts['premium'] = $this->getPendingASTPremiumConversionCasesDC($user_code, $dist_code);
        $counts['payment'] = $this->getPendingASTPaymentConversionCasesDC($user_code, $dist_code);
        $counts['cases'] = $this->getPendingASTActionTakenConversionCasesDC($user_code, $dist_code);

        $counts['sronote'] = $this->db->query("SELECT * from   sro_note WHERE dist_code='$dist_code' and (deed_type='SALE' or deed_type='GIFT' ) limit 10")->result();

        $counts['sronotepen'] = $this->db->query("SELECT count(*) as c from   sro_note WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'"
            . " and status='1'")->row()->c;

        $counts['allote_bo'] = $this->db->query("select count(*) as c from     allotment_cert_basic where status = 'R' and co_code is not null and dist_code='$dist_code' and dc_note is not null and bo_note is null")->row()->c;

        $counts['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from     users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
            . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();

        $date_of_last_password_changed = $counts['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }
        $counts['_view'] = 'home/conversion_bo';
        $this->load->view('layouts/main', $counts);
    }

    public function AppealBo()
    {
        $counts['_view'] = 'home/appeal_bo';
        $this->load->view('layouts/main', $counts);
    }

    public function AcPPBo()
    {

        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $subdiv_code = '00';
        $cir_code = '00';
        $mouza_pargona_code = '00';
        $lot_no = '00';
        // 
          $counts['premium'] = $this->getPendingASTPremiumConversionCasesDC($user_code, $dist_code);
        
        $counts['allote_bo'] = $this->db->query("select count(*) as c from     allotment_cert_basic where status = 'R' and co_code is not null and dist_code='$dist_code' and dc_note is not null and bo_note is null")->row()->c;

        $counts['allote_bo'] = $this->db->query("select count(*) as c from     allotment_cert_basic where status = 'R' and co_code is not null and dist_code='$dist_code' and dc_note is not null and bo_note is null")->row()->c;

        $counts['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from     users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
            . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();

        $date_of_last_password_changed = $counts['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }
        $counts['_view'] = 'home/acpp_bo';
        $this->load->view('layouts/main', $counts);
    }

    public function MutationAst()
    {
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $year_no = year_no;
        $define_date = define_date;

        $counts['pnotice'] = $this->db->query("SELECT count(*) as c from    Petition_basic where not_fresh='Y' and status='P' and notice_generated_yn is null and mut_type='03' and  dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $counts['pactiontaken'] = $this->db->query("SELECT count(*) as c from    Petition_basic where not_fresh='Y' and status = 'P' and proceeding_yn is null and mut_type='03'  and date_entry >= '$define_date' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $counts['byayPrak'] = $this->db->query("SELECT count(*) as c from    Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  and date_entry >= '$define_date'  and pay_notice_gen_yn='Y' and status='P' and not_fresh='Y' and mut_type='04' and petition_no in ( SELECT petition_no from    Petition_byayprak WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and if_paid is null ) ")->row()->c;

        $counts['NoticeGen'] = $this->db->query("SELECT count(*) as c from    Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and not_fresh='Y' and status ='P' and mut_type='04' and (notice_generated_yn is null or notice_generated_yn='' )  and date_entry >= '$define_date' ")->row()->c;

        $counts['sronote'] = $this->db->query("SELECT * from    sro_note WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (deed_type='SALE' or deed_type='GIFT') and status='1' limit 10")->result();

        $counts['sronotepen'] = $this->db->query("SELECT count(*) as c from    sro_note WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='1' and (nature_of_land != 'r' or nature_of_land is null)")->row()->c;

        $counts['PayNoticeGen'] = $this->db->query("SELECT count(*) as c from    Petition_basic WHERE dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and not_fresh='Y' and status ='P' and mut_type='04' and pay_notice_gen_yn ='Y' and  notice_served_yn!='Y'  ")->row()->c;

        $counts['ProceedingOrder'] = $this->db->query("SELECT count(*) as c from    Petition_basic WHERE dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and not_fresh='Y' and status ='P' and mut_type='04' and (proceeding_yn is null or proceeding_yn='')")->row()->c;

        $sql = "SELECT case_no from      petitioner_part pb WHERE pb.dist_code='$dist_code' and pb.subdiv_code='$subdiv_code' and pb.cir_code='$cir_code'  ";

        $counts['Isthar'] = $this->db->query("SELECT count(case_no) as c from    Petition_Basic as pb WHERE pb.dist_code='$dist_code' and pb.subdiv_code='$subdiv_code' and pb.cir_code='$cir_code' and pb.mut_type='04' and pb.order_passed='Y' and pb.status='F' and pb.isthar_update is null and case_no in ($sql) ")->row()->c;

        $counts['citizenpending'] = $this->db->query("Select count(*) as c from      cert_application WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='R' and apply_date >='$define_date'  ")->row()->c;

        $counts['countAPCaseShowCauseForAST'] = $this->APCancellationModel->countAPCaseShowCauseForAST($user_code, $dist_code, $subdiv_code, $cir_code); //not done with location checking
        $counts['NoticeGenerate'] = $this->NameCancellationModel->getNoticeGenerateMiscCase($user_code, $dist_code, $subdiv_code, $cir_code); //not done with location checking
        $counts['ConfirmNoticeGenerate'] = $this->NameCancellationModel->getConfirmNoticeGenerate($user_code, $dist_code, $subdiv_code, $cir_code); //not done with location checking

        $counts['Pcases'] = $this->getPendingASTNoticeGeneratedConversionCases($user_code, $dist_code, $subdiv_code, $cir_code);
        $counts['cases'] = $this->getPendingASTActionTakenConversionCases($user_code, $dist_code, $subdiv_code, $cir_code);
        $counts['premium'] = $this->getPendingASTPremiumConversionCases($user_code, $dist_code, $subdiv_code, $cir_code);
        $counts['payment'] = $this->getPendingASTPaymentConversionCases($user_code, $dist_code, $subdiv_code, $cir_code);

        $counts['NameCorrectionNoticeGenerate'] = $this->getPendingASTNoticeGeneratedNameCorrection($user_code, $dist_code, $subdiv_code, $cir_code);
        $counts['NameCorrectionActionTaken'] = $this->getPendingASTActionTakenNameCorrection($user_code, $dist_code, $subdiv_code, $cir_code);

        $counts['CountJamaNakalOnline'] = $this->ServicePlusModel->count_online_ror_cases();
        $counts['CountMutationOnline'] = $this->ServicePlusModel->count_online_mutation_cases();
        $counts['CountOsOnline'] = $this->ServicePlusModel->count_online_os_cases();
        $counts['CountPartitionOnline'] = $this->ServicePlusModel->count_online_partition_cases();

        $counts['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from  users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.user_code = '$user_code'")->row();

        $date_of_last_password_changed = $counts['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }
        if(ESCALATION_ENABLE == 1){
            $service_code = 1;
            $counts['service_type'] = OMUT;
            $counts['escAllocateDays'] = $this->Escalationmodel->getTimeLine($service_code, 'OMUT');
            $counts['escAllocateDaysDeed'] = $this->Escalationmodel->getTimeLine(2, 'OMUTD');
        }


        $counts['_view'] = 'home/mutation_ast';
        $this->load->view('layouts/main', $counts);
    }

    public function PartitionCoFP()
    {
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page',
        );

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';

        $data['map_partition'] = $this->db->query("Select count(*) as c from  t_chitha_col8_order where map_partition!=null and "
            . " order_type_code='02' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  "
            . "and date(co_ord_date) >= '$define_date'  and iscorrected_inco is null")->row()->c;

        $officemutationCount = $this->cofieldmutationmodel->countPendingMutationCases($dist_code, $subdiv_code, $cir_code);
        $data['fmutation'] = $officemutationCount;

        $officepartitionCount = $this->cofieldmutationmodel->countPendingPartitionCases($dist_code, $subdiv_code, $cir_code);
        $data['fpartition'] = $officepartitionCount;

        $data['opartition'] = $this->getPendingOfficePartitionCases($dist_code, $subdiv_code, $cir_code);
        $data['omutation'] = $this->getPendingOfficeMutationCases($dist_code, $subdiv_code, $cir_code);

        $data['oconv'] = $this->getPendingConversionCases($user_code, $dist_code, $subdiv_code, $cir_code);
        $data['first_proceeding'] = $this->getFirstProceedingConvertion($user_code, $dist_code, $subdiv_code, $cir_code);
        $data['second_proceeding'] = $this->getSecondProceedingConvertion($user_code, $dist_code, $subdiv_code, $cir_code);
        $data['third_proceeding'] = $this->getConvertionOrderPassedByDC($user_desig_code, $dist_code, $subdiv_code, $cir_code);
        $data['rejected_proceeding'] = $this->getRejectedProceedingConvertion($user_code, $dist_code, $subdiv_code, $cir_code);
        $data['conversion_proceeding_report'] = $this->getconversion_proceeding_report($user_code, $dist_code, $subdiv_code, $cir_code);

        $data['mfirst_proceeding'] = $this->getFisrtProceedingMutation($user_code, $dist_code, $subdiv_code, $cir_code);
        $data['msecond_proceeding'] = $this->getSecondProceedingMutation($user_code, $dist_code, $subdiv_code, $cir_code);
        $data['pfirst_proceeding'] = $this->getFisrtProceedingPartition($user_code, $dist_code, $subdiv_code, $cir_code);
        $data['psecond_proceeding'] = $this->getSecondProceedingPartition($user_code, $dist_code, $subdiv_code, $cir_code);

        $data['sronote'] = $this->db->query("SELECT * from  sro_note WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status!='3' and (deed_type='SALE' or deed_type='GIFT' ) order by update_date desc   limit 10 ")->result();

        $data['allotment_first'] = $this->db->query("Select count(*) as c from  allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  not_fresh is null and status is null")->row()->c;
        $data['allotment_second'] = $this->db->query("Select count(*) as c from  allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  not_fresh='Y' and status='P' and co_note is not null")->row()->c;
        $data['allotment_final'] = $this->db->query("Select count(*) as c from  allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  status='F' and dc_code is not null and chitha_correct_yn is null ")->row()->c;

        $data['countAPCaseforCO'] = $this->APCancellationModel->getCountAPCasesforCO(); //not used location condition
        $data['countNoteHearingAPCaseforCO'] = $this->APCancellationModel->getNoteHearingAPCasesforCO(); //not used location condition
        $data['getOrderAPCancellation'] = $this->APCancellationModel->getOrderAPCancellation(); //not used location condition

        $data['fchithaupdates'] = $this->getPendingFieldChithaUpdates();
        $data['ochithaupdates'] = $this->getPendingOfficeChithaUpdates();

        $data['grant_finalco'] = $this->db->query("Select count(*) as c from  allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and not_fresh is not null and status is not null and lm_note='Y' and sk_note='Y' and chitha_correct_yn is null and settlement_typ='gr' ")->row()->c; //Bondita

        $data['FirstPro'] = $this->db->query("SELECT count(*) as c from  Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='04' and co_user_code='$user_code' and (status!='D' or status is null) and not_fresh is null and lm_note_yn is null and date_entry >= '$define_date' ")->row()->c;

        $data['SecondPro'] = $this->db->query("SELECT count(*) as c from  Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and co_user_code='$user_code'  and mut_type='04' and not_fresh = 'Y' and status='P' and date_entry >= '$define_date' ")->row()->c;

        $data['citizenPendingCO'] = $this->db->query("SELECT count(*) as c from  Cert_Application WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and LM_Checked_yn='Y' and CO_Checked_yn is null and status = 'C' and apply_date >= '$define_date'")->row()->c;

        $data['land_proposals'] = $this->db->query("SELECT count(*) as c from   t_reclassification WHERE co_yn is null and dc_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status != 'R' OR status is null)")->row()->c;

        $data['g_trans_for_dc'] = $this->db->query("SELECT count(*) as c from  t_reclassification WHERE co_yn = 'Y' and dc_yn is null and dc_approval is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status != 'R' OR status is null)")->row()->c;

        $data['land_proposals_returned_DC'] = $this->db->query("SELECT count(*) as c from  t_reclassification WHERE co_yn = 'Y' and dc_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and dc_approval is not null and (status != 'R' OR status is null)")->row()->c;

        $data['land_proposals_for_jamaupdate'] = $this->db->query("SELECT count(*) as c from   t_reclassification as t JOIN  chitha_basic as c ON c.dist_code=t.dist_code and "
            . "c.subdiv_code = t.subdiv_code and c.cir_code = t.cir_code and c.mouza_pargona_code=t.mouza_pargona_code and c.lot_no=t.lot_no and "
            . "c.vill_townprt_code=t.vill_townprt_code and c.dag_no = t.dag_no and trim(c.patta_no) = trim(t.patta_no) and c.dist_code='$dist_code' and "
            . "c.subdiv_code='$subdiv_code' and c.cir_code='$cir_code' and t.co_chitha_updated_yn = 'Y' and c.jama_yn != 'y'")->row()->c;

        $data['pending_objection'] = $this->db->query("Select count(*) as c from  field_mut_objection where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and obj_flag is null and entry_date >= '$define_date' ")->row()->c;

        $data['proceedingPartRpt'] = $this->proceedingReportpart($user_code, $dist_code, $subdiv_code, $cir_code);

        $data['proceedingMutRpt'] = $this->proceedingReportofcmut($user_code, $dist_code, $subdiv_code, $cir_code, $year_no, $define_date);

        $data['name_correction'] = $this->db->query("SELECT count(*) as c from   t_chitha_rmk_ordbasic WHERE ord_type_code = '05' and "
            . "iscorrected_inco is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $data['partchithaupdate'] = $this->db->query("SELECT count(*) as c from   t_chitha_rmk_ordbasic WHERE ord_type_code = '04' and iscorrected_inco is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        //for miscellaneous cases i.e Name Correction
        $data['MisCases'] = $this->NameCorrectionModel->getMiscCases($user_code, $dist_code, $subdiv_code, $cir_code);

        $data['MisCasesNC'] = $this->NameCancellationModel->getMiscCasesNC($user_code, $dist_code, $subdiv_code, $cir_code);

        $data['FinalOrderMisc'] = $this->NameCorrectionModel->getFinalOrderMisc($user_code);

        $data['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from  users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
            . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();

//        $data['civil_appeal_basic'] = $this->db->query("SELECT count(*) as c from   civil_appeal_basic WHERE co_order_yn is null and chitha_correct_yn is null and status = 'P' and"
        //                . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $date_of_last_password_changed = $data['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }

        if(ESCALATION_ENABLE == 1){
            $service_code = 3;
            $data['service_type'] = FPART;
            $data['escAllocateDays'] = $this->Escalationmodel->getTimeLine($service_code, 'FPART');
        }



        $data['_view'] = 'home/mutation_co';
        $this->load->view('layouts/main', $data);
    }

    public function PartitionCoOP()
    {
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page',
        );

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';

        $data['map_partition'] = $this->db->query("Select count(*) as c from  t_chitha_col8_order where map_partition!=null and "
            . " order_type_code='02' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  "
            . "and date(co_ord_date) >= '$define_date'  and iscorrected_inco is null")->row()->c;

        $officemutationCount = $this->cofieldmutationmodel->countPendingMutationCases($dist_code, $subdiv_code, $cir_code);
        $data['fmutation'] = $officemutationCount;

        $officepartitionCount = $this->cofieldmutationmodel->countPendingPartitionCases($dist_code, $subdiv_code, $cir_code);
        $data['fpartition'] = $officepartitionCount;

        $data['opartition'] = $this->getPendingOfficePartitionCases($dist_code, $subdiv_code, $cir_code);
        $data['omutation'] = $this->getPendingOfficeMutationCases($dist_code, $subdiv_code, $cir_code);

        $data['oconv'] = $this->getPendingConversionCases($user_code, $dist_code, $subdiv_code, $cir_code);
        $data['first_proceeding'] = $this->getFirstProceedingConvertion($user_code, $dist_code, $subdiv_code, $cir_code);
        $data['second_proceeding'] = $this->getSecondProceedingConvertion($user_code, $dist_code, $subdiv_code, $cir_code);
        $data['third_proceeding'] = $this->getConvertionOrderPassedByDC($user_desig_code, $dist_code, $subdiv_code, $cir_code);
        $data['rejected_proceeding'] = $this->getRejectedProceedingConvertion($user_code, $dist_code, $subdiv_code, $cir_code);
        $data['conversion_proceeding_report'] = $this->getconversion_proceeding_report($user_code, $dist_code, $subdiv_code, $cir_code);

        $data['mfirst_proceeding'] = $this->getFisrtProceedingMutation($user_code, $dist_code, $subdiv_code, $cir_code);
        $data['msecond_proceeding'] = $this->getSecondProceedingMutation($user_code, $dist_code, $subdiv_code, $cir_code);
        $data['pfirst_proceeding'] = $this->getFisrtProceedingPartition($user_code, $dist_code, $subdiv_code, $cir_code);
        $data['psecond_proceeding'] = $this->getSecondProceedingPartition($user_code, $dist_code, $subdiv_code, $cir_code);

        $data['sronote'] = $this->db->query("SELECT * from  sro_note WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status!='3' and (deed_type='SALE' or deed_type='GIFT' ) order by update_date desc   limit 10 ")->result();

        $data['allotment_first'] = $this->db->query("Select count(*) as c from  allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  not_fresh is null and status is null")->row()->c;
        $data['allotment_second'] = $this->db->query("Select count(*) as c from  allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  not_fresh='Y' and status='P' and co_note is not null")->row()->c;
        $data['allotment_final'] = $this->db->query("Select count(*) as c from  allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  status='F' and dc_code is not null and chitha_correct_yn is null ")->row()->c;

        $data['countAPCaseforCO'] = $this->APCancellationModel->getCountAPCasesforCO(); //not used location condition
        $data['countNoteHearingAPCaseforCO'] = $this->APCancellationModel->getNoteHearingAPCasesforCO(); //not used location condition
        $data['getOrderAPCancellation'] = $this->APCancellationModel->getOrderAPCancellation(); //not used location condition

        $data['fchithaupdates'] = $this->getPendingFieldChithaUpdates();
        $data['ochithaupdates'] = $this->getPendingOfficeChithaUpdates();

        $data['grant_finalco'] = $this->db->query("Select count(*) as c from  allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and not_fresh is not null and status is not null and lm_note='Y' and sk_note='Y' and chitha_correct_yn is null and settlement_typ='gr' ")->row()->c; //Bondita

        $data['FirstPro'] = $this->db->query("SELECT count(*) as c from  Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='04' and co_user_code='$user_code' and (status!='D' or status is null) and not_fresh is null and lm_note_yn is null and date_entry >= '$define_date' ")->row()->c;

        $data['SecondPro'] = $this->db->query("SELECT count(*) as c from  Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and co_user_code='$user_code'  and mut_type='04' and not_fresh = 'Y' and status='P' and date_entry >= '$define_date' ")->row()->c;

        $data['citizenPendingCO'] = $this->db->query("SELECT count(*) as c from  Cert_Application WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and LM_Checked_yn='Y' and CO_Checked_yn is null and status = 'C' and apply_date >= '$define_date'")->row()->c;

        $data['land_proposals'] = $this->db->query("SELECT count(*) as c from   t_reclassification WHERE co_yn is null and dc_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status != 'R' OR status is null)")->row()->c;

        $data['g_trans_for_dc'] = $this->db->query("SELECT count(*) as c from  t_reclassification WHERE co_yn = 'Y' and dc_yn is null and dc_approval is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status != 'R' OR status is null)")->row()->c;

        $data['land_proposals_returned_DC'] = $this->db->query("SELECT count(*) as c from  t_reclassification WHERE co_yn = 'Y' and dc_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and dc_approval is not null and (status != 'R' OR status is null)")->row()->c;

        $data['land_proposals_for_jamaupdate'] = $this->db->query("SELECT count(*) as c from   t_reclassification as t JOIN  chitha_basic as c ON c.dist_code=t.dist_code and "
            . "c.subdiv_code = t.subdiv_code and c.cir_code = t.cir_code and c.mouza_pargona_code=t.mouza_pargona_code and c.lot_no=t.lot_no and "
            . "c.vill_townprt_code=t.vill_townprt_code and c.dag_no = t.dag_no and trim(c.patta_no) = trim(t.patta_no) and c.dist_code='$dist_code' and "
            . "c.subdiv_code='$subdiv_code' and c.cir_code='$cir_code' and t.co_chitha_updated_yn = 'Y' and c.jama_yn != 'y'")->row()->c;

        $data['pending_objection'] = $this->db->query("Select count(*) as c from  field_mut_objection where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and obj_flag is null and entry_date >= '$define_date' ")->row()->c;

        $data['proceedingPartRpt'] = $this->proceedingReportpart($user_code, $dist_code, $subdiv_code, $cir_code);

        $data['proceedingMutRpt'] = $this->proceedingReportofcmut($user_code, $dist_code, $subdiv_code, $cir_code, $year_no, $define_date);

        $data['name_correction'] = $this->db->query("SELECT count(*) as c from   t_chitha_rmk_ordbasic WHERE ord_type_code = '05' and "
            . "iscorrected_inco is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $data['partchithaupdate'] = $this->db->query("SELECT count(*) as c from   t_chitha_rmk_ordbasic WHERE ord_type_code = '04' and iscorrected_inco is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        //for miscellaneous cases i.e Name Correction
        $data['MisCases'] = $this->NameCorrectionModel->getMiscCases($user_code, $dist_code, $subdiv_code, $cir_code);

        $data['MisCasesNC'] = $this->NameCancellationModel->getMiscCasesNC($user_code, $dist_code, $subdiv_code, $cir_code);

        $data['FinalOrderMisc'] = $this->NameCorrectionModel->getFinalOrderMisc($user_code);

        $data['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from  users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
            . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();

//        $data['civil_appeal_basic'] = $this->db->query("SELECT count(*) as c from   civil_appeal_basic WHERE co_order_yn is null and chitha_correct_yn is null and status = 'P' and"
        //                . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $date_of_last_password_changed = $data['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }

        if(ESCALATION_ENABLE == 1){
            $service_code = 3;
            $data['service_type'] = OPART;
            $data['escAllocateDays'] = $this->Escalationmodel->getTimeLine($service_code, 'OPART');
        }


        $data['_view'] = 'home/partition_co';
        $this->load->view('layouts/main', $data);
    }

    public function ConversionCo()
    {
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page',
        );

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';

        $data['map_partition'] = $this->db->query("Select count(*) as c from  t_chitha_col8_order where map_partition!=null and "
            . " order_type_code='02' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  "
            . "and date(co_ord_date) >= '$define_date'  and iscorrected_inco is null")->row()->c;

        $officemutationCount = $this->cofieldmutationmodel->countPendingMutationCases($dist_code, $subdiv_code, $cir_code);
        $data['fmutation'] = $officemutationCount;

        $officepartitionCount = $this->cofieldmutationmodel->countPendingPartitionCases($dist_code, $subdiv_code, $cir_code);
        $data['fpartition'] = $officepartitionCount;

        $data['opartition'] = $this->getPendingOfficePartitionCases($dist_code, $subdiv_code, $cir_code);
        $data['omutation'] = $this->getPendingOfficeMutationCases($dist_code, $subdiv_code, $cir_code);

        $data['oconv'] = $this->getPendingConversionCases($user_code, $dist_code, $subdiv_code, $cir_code);
        $data['first_proceeding'] = $this->getFirstProceedingConvertion($user_code, $dist_code, $subdiv_code, $cir_code);
        $data['second_proceeding'] = $this->getSecondProceedingConvertion($user_code, $dist_code, $subdiv_code, $cir_code);
        $data['third_proceeding'] = $this->getConvertionOrderPassedByDC($user_desig_code, $dist_code, $subdiv_code, $cir_code);
        $data['rejected_proceeding'] = $this->getRejectedProceedingConvertion($user_code, $dist_code, $subdiv_code, $cir_code);
        $data['conversion_proceeding_report'] = $this->getconversion_proceeding_report($user_code, $dist_code, $subdiv_code, $cir_code);

        $data['mfirst_proceeding'] = $this->getFisrtProceedingMutation($user_code, $dist_code, $subdiv_code, $cir_code);
        $data['msecond_proceeding'] = $this->getSecondProceedingMutation($user_code, $dist_code, $subdiv_code, $cir_code);
        $data['pfirst_proceeding'] = $this->getFisrtProceedingPartition($user_code, $dist_code, $subdiv_code, $cir_code);
        $data['psecond_proceeding'] = $this->getSecondProceedingPartition($user_code, $dist_code, $subdiv_code, $cir_code);

        $data['sronote'] = $this->db->query("SELECT * from  sro_note WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status!='3' and (deed_type='SALE' or deed_type='GIFT' ) order by update_date desc   limit 10 ")->result();

        $data['allotment_first'] = $this->db->query("Select count(*) as c from  allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  not_fresh is null and status is null")->row()->c;
        $data['allotment_second'] = $this->db->query("Select count(*) as c from  allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  not_fresh='Y' and status='P' and co_note is not null")->row()->c;
        $data['allotment_final'] = $this->db->query("Select count(*) as c from  allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  status='F' and dc_code is not null and chitha_correct_yn is null ")->row()->c;

        $data['countAPCaseforCO'] = $this->APCancellationModel->getCountAPCasesforCO(); //not used location condition
        $data['countNoteHearingAPCaseforCO'] = $this->APCancellationModel->getNoteHearingAPCasesforCO(); //not used location condition
        $data['getOrderAPCancellation'] = $this->APCancellationModel->getOrderAPCancellation(); //not used location condition

        $data['fchithaupdates'] = $this->getPendingFieldChithaUpdates();
        $data['ochithaupdates'] = $this->getPendingOfficeChithaUpdates();

        $data['grant_finalco'] = $this->db->query("Select count(*) as c from  allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and not_fresh is not null and status is not null and lm_note='Y' and sk_note='Y' and chitha_correct_yn is null and settlement_typ='gr' ")->row()->c; //Bondita

        $data['FirstPro'] = $this->db->query("SELECT count(*) as c from  Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='04' and co_user_code='$user_code' and (status!='D' or status is null) and not_fresh is null and lm_note_yn is null and date_entry >= '$define_date' ")->row()->c;

        $data['SecondPro'] = $this->db->query("SELECT count(*) as c from  Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and co_user_code='$user_code'  and mut_type='04' and not_fresh = 'Y' and status='P' and date_entry >= '$define_date' ")->row()->c;

        $data['citizenPendingCO'] = $this->db->query("SELECT count(*) as c from  Cert_Application WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and LM_Checked_yn='Y' and CO_Checked_yn is null and status = 'C' and apply_date >= '$define_date'")->row()->c;

        $data['land_proposals'] = $this->db->query("SELECT count(*) as c from   t_reclassification WHERE co_yn is null and dc_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status != 'R' OR status is null)")->row()->c;

        $data['g_trans_for_dc'] = $this->db->query("SELECT count(*) as c from  t_reclassification WHERE co_yn = 'Y' and dc_yn is null and dc_approval is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status != 'R' OR status is null)")->row()->c;

        $data['land_proposals_returned_DC'] = $this->db->query("SELECT count(*) as c from  t_reclassification WHERE co_yn = 'Y' and dc_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and dc_approval is not null and (status != 'R' OR status is null)")->row()->c;

        $data['land_proposals_for_jamaupdate'] = $this->db->query("SELECT count(*) as c from   t_reclassification as t JOIN  chitha_basic as c ON c.dist_code=t.dist_code and "
            . "c.subdiv_code = t.subdiv_code and c.cir_code = t.cir_code and c.mouza_pargona_code=t.mouza_pargona_code and c.lot_no=t.lot_no and "
            . "c.vill_townprt_code=t.vill_townprt_code and c.dag_no = t.dag_no and trim(c.patta_no) = trim(t.patta_no) and c.dist_code='$dist_code' and "
            . "c.subdiv_code='$subdiv_code' and c.cir_code='$cir_code' and t.co_chitha_updated_yn = 'Y' and c.jama_yn != 'y'")->row()->c;

        $data['pending_objection'] = $this->db->query("Select count(*) as c from  field_mut_objection where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and obj_flag is null and entry_date >= '$define_date' ")->row()->c;

        $data['proceedingPartRpt'] = $this->proceedingReportpart($user_code, $dist_code, $subdiv_code, $cir_code);

        $data['proceedingMutRpt'] = $this->proceedingReportofcmut($user_code, $dist_code, $subdiv_code, $cir_code, $year_no, $define_date);

        $data['name_correction'] = $this->db->query("SELECT count(*) as c from   t_chitha_rmk_ordbasic WHERE ord_type_code = '05' and "
            . "iscorrected_inco is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $data['partchithaupdate'] = $this->db->query("SELECT count(*) as c from   t_chitha_rmk_ordbasic WHERE ord_type_code = '04' and iscorrected_inco is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        //for miscellaneous cases i.e Name Correction
        $data['MisCases'] = $this->NameCorrectionModel->getMiscCases($user_code, $dist_code, $subdiv_code, $cir_code);

        $data['MisCasesNC'] = $this->NameCancellationModel->getMiscCasesNC($user_code, $dist_code, $subdiv_code, $cir_code);

        $data['FinalOrderMisc'] = $this->NameCorrectionModel->getFinalOrderMisc($user_code);

        $data['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from  users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
            . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();

//        $data['civil_appeal_basic'] = $this->db->query("SELECT count(*) as c from   civil_appeal_basic WHERE co_order_yn is null and chitha_correct_yn is null and status = 'P' and"
//                . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;


        if(ESCALATION_ENABLE == 1){
            $service_code = 9;
            $data['service_type'] = CONV_SERV;
            $data['escAllocateDays'] = $this->Escalationmodel->getTimeLine($service_code, 'CONVR');
            $data['escAllocateDaysP'] = $this->Escalationmodel->getTimeLine($service_code, 'CONVP');
            $data['escAllocateDaysU'] = $this->Escalationmodel->getTimeLine($service_code, 'CONVU');
        }

        $date_of_last_password_changed = $data['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }

        $data['_view'] = 'home/conversion_co';
        $this->load->view('layouts/main', $data);
    }

    public function LandReCo()
    {

        $allowed = ['CO'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page',
        );

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';

        $data['land_proposals'] = $this->db->query("SELECT count(*) as c from   t_reclassification WHERE co_yn is null and dc_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status != 'R' and status!='M' OR status is null OR status='C')")->row()->c;

        $data['g_trans_for_dc'] = $this->db->query("SELECT count(*) as c from  t_reclassification WHERE co_yn = 'Y' and dc_yn is null and dc_approval is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status != 'R' OR status is null)")->row()->c;

        //$data['land_proposals_returned_DC'] = $this->db->query("SELECT count(*) as c from  t_reclassification WHERE co_yn = 'Y' and dc_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and dc_approval is not null and (status != 'R' OR status is null)")->row()->c;

        $data['land_proposals_returned_DC'] = $this->db->query("SELECT count(*) as c from  t_reclassification WHERE co_yn = 'Y' and dc_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status = 'C' )")->row()->c;

        $data['land_proposals_for_jamaupdate'] = $this->db->query("SELECT count(*) as c from   t_reclassification as t JOIN  chitha_basic as c ON c.dist_code=t.dist_code and "
            . "c.subdiv_code = t.subdiv_code and c.cir_code = t.cir_code and c.mouza_pargona_code=t.mouza_pargona_code and c.lot_no=t.lot_no and "
            . "c.vill_townprt_code=t.vill_townprt_code and c.dag_no = t.dag_no and trim(c.patta_no) = trim(t.patta_no) and c.dist_code='$dist_code' and "
            . "c.subdiv_code='$subdiv_code' and c.cir_code='$cir_code' and t.co_chitha_updated_yn = 'Y' and c.jama_yn != 'y'")->row()->c;

        $data['pending_objection'] = $this->db->query("Select count(*) as c from  field_mut_objection where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and obj_flag is null and entry_date >= '$define_date' ")->row()->c;

        $data['proceedingPartRpt'] = $this->proceedingReportpart($user_code, $dist_code, $subdiv_code, $cir_code);

        $data['proceedingMutRpt'] = $this->proceedingReportofcmut($user_code, $dist_code, $subdiv_code, $cir_code, $year_no, $define_date);

        $data['name_correction'] = $this->db->query("SELECT count(*) as c from   t_chitha_rmk_ordbasic WHERE ord_type_code = '05' and "
            . "iscorrected_inco is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $data['partchithaupdate'] = $this->db->query("SELECT count(*) as c from   t_chitha_rmk_ordbasic WHERE ord_type_code = '04' and iscorrected_inco is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        //for miscellaneous cases i.e Name Correction
        $data['MisCases'] = $this->NameCorrectionModel->getMiscCases($user_code, $dist_code, $subdiv_code, $cir_code);

        $data['MisCasesNC'] = $this->NameCancellationModel->getMiscCasesNC($user_code, $dist_code, $subdiv_code, $cir_code);

        $data['FinalOrderMisc'] = $this->NameCorrectionModel->getFinalOrderMisc($user_code);

        $data['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from  users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
            . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();

//        $data['civil_appeal_basic'] = $this->db->query("SELECT count(*) as c from   civil_appeal_basic WHERE co_order_yn is null and chitha_correct_yn is null and status = 'P' and"
        //                . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $data['suomoto_reclass'] = $this->db->query("SELECT count(*) as c from   suomoto_reclass WHERE status='C' and dc_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $data['cusuomoto_reclass'] = $this->db->query("SELECT count(*) as c from   suomoto_reclass WHERE dc_yn is not null and co_chitha_updated_yn is null and lm_code is not null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $date_of_last_password_changed = $data['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }

        if(ESCALATION_ENABLE == 1){
            $service_code = 4;
            $data['service_type'] = RECLASS_SERV;
            $data['escAllocateDays'] = $this->Escalationmodel->getTimeLine($service_code, 'RECLASS');
        }



        $data['_view'] = 'home/landre_co';
        $this->load->view('layouts/main', $data);
    }

    public function ApcCo()
    {
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page',
        );

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';

        $data['map_partition'] = $this->db->query("Select count(*) as c from  t_chitha_col8_order where map_partition!=null and "
            . " order_type_code='02' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  "
            . "and date(co_ord_date) >= '$define_date'  and iscorrected_inco is null")->row()->c;

        $officemutationCount = $this->cofieldmutationmodel->countPendingMutationCases($dist_code, $subdiv_code, $cir_code);

        $data['countAPCaseforCO'] = $this->APCancellationModel->getCountAPCasesforCO(); //not used location condition
        $data['countNoteHearingAPCaseforCO'] = $this->APCancellationModel->getNoteHearingAPCasesforCO(); //not used location condition
        $data['getOrderAPCancellation'] = $this->APCancellationModel->getOrderAPCancellation(); //not used location condition

        $data['fchithaupdates'] = $this->getPendingFieldChithaUpdates();
        $data['ochithaupdates'] = $this->getPendingOfficeChithaUpdates();

        $data['grant_finalco'] = $this->db->query("Select count(*) as c from  allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and not_fresh is not null and status is not null and lm_note='Y' and sk_note='Y' and chitha_correct_yn is null and settlement_typ='gr' ")->row()->c; //Bondita

        $data['FirstPro'] = $this->db->query("SELECT count(*) as c from  Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='04' and co_user_code='$user_code' and (status!='D' or status is null) and not_fresh is null and lm_note_yn is null and date_entry >= '$define_date' ")->row()->c;

        $data['SecondPro'] = $this->db->query("SELECT count(*) as c from  Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and co_user_code='$user_code'  and mut_type='04' and not_fresh = 'Y' and status='P' and date_entry >= '$define_date' ")->row()->c;

        $data['citizenPendingCO'] = $this->db->query("SELECT count(*) as c from  Cert_Application WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and LM_Checked_yn='Y' and CO_Checked_yn is null and status = 'C' and apply_date >= '$define_date'")->row()->c;

        $data['land_proposals'] = $this->db->query("SELECT count(*) as c from   t_reclassification WHERE co_yn is null and dc_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status != 'R' OR status is null)")->row()->c;

        $data['g_trans_for_dc'] = $this->db->query("SELECT count(*) as c from  t_reclassification WHERE co_yn = 'Y' and dc_yn is null and dc_approval is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status != 'R' OR status is null)")->row()->c;

        $data['land_proposals_returned_DC'] = $this->db->query("SELECT count(*) as c from  t_reclassification WHERE co_yn = 'Y' and dc_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and dc_approval is not null and (status != 'R' OR status is null)")->row()->c;

        $data['land_proposals_for_jamaupdate'] = $this->db->query("SELECT count(*) as c from   t_reclassification as t JOIN  chitha_basic as c ON c.dist_code=t.dist_code and "
            . "c.subdiv_code = t.subdiv_code and c.cir_code = t.cir_code and c.mouza_pargona_code=t.mouza_pargona_code and c.lot_no=t.lot_no and "
            . "c.vill_townprt_code=t.vill_townprt_code and c.dag_no = t.dag_no and trim(c.patta_no) = trim(t.patta_no) and c.dist_code='$dist_code' and "
            . "c.subdiv_code='$subdiv_code' and c.cir_code='$cir_code' and t.co_chitha_updated_yn = 'Y' and c.jama_yn != 'y'")->row()->c;

        $data['pending_objection'] = $this->db->query("Select count(*) as c from  field_mut_objection where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and obj_flag is null and entry_date >= '$define_date' ")->row()->c;

        $data['proceedingPartRpt'] = $this->proceedingReportpart($user_code, $dist_code, $subdiv_code, $cir_code);

        $data['proceedingMutRpt'] = $this->proceedingReportofcmut($user_code, $dist_code, $subdiv_code, $cir_code, $year_no, $define_date);

        $data['name_correction'] = $this->db->query("SELECT count(*) as c from   t_chitha_rmk_ordbasic WHERE ord_type_code = '05' and "
            . "iscorrected_inco is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $data['partchithaupdate'] = $this->db->query("SELECT count(*) as c from   t_chitha_rmk_ordbasic WHERE ord_type_code = '04' and iscorrected_inco is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        //for miscellaneous cases i.e Name Correction
        $data['MisCases'] = $this->NameCorrectionModel->getMiscCases($user_code, $dist_code, $subdiv_code, $cir_code);

        $data['MisCasesNC'] = $this->NameCancellationModel->getMiscCasesNC($user_code, $dist_code, $subdiv_code, $cir_code);

        $data['FinalOrderMisc'] = $this->NameCorrectionModel->getFinalOrderMisc($user_code);

        $data['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from  users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
            . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();

//        $data['civil_appeal_basic'] = $this->db->query("SELECT count(*) as c from   civil_appeal_basic WHERE co_order_yn is null and chitha_correct_yn is null and status = 'P' and"
        //                . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $date_of_last_password_changed = $data['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }

        $data['_view'] = 'home/apc_co';
        $this->load->view('layouts/main', $data);
    }

    public function PartitionAst()
    {
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $year_no = year_no;
        $define_date = define_date;

        $counts['NoticeGen'] = $this->db->query("SELECT count(*) as c from    Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and not_fresh='Y' and status ='P' and mut_type='04' and (notice_generated_yn is null or notice_generated_yn='' )  and date_entry >= '$define_date' ")->row()->c;

        $counts['PayNoticeGen'] = $this->db->query("SELECT count(*) as c from    Petition_basic WHERE dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and not_fresh='Y' and status ='P' and mut_type='04' and pay_notice_gen_yn ='Y' and  notice_served_yn!='Y'  ")->row()->c;

        $counts['byayPrak'] = $this->db->query("SELECT count(*) as c from    Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  and date_entry >= '$define_date'  and pay_notice_gen_yn='Y' and status='P' and not_fresh='Y' and mut_type='04' and petition_no in ( SELECT petition_no from    Petition_byayprak WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and if_paid is null ) ")->row()->c;

        $counts['ProceedingOrder'] = $this->db->query("SELECT count(*) as c from    Petition_basic WHERE dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and not_fresh='Y' and status ='P' and mut_type='04' and (proceeding_yn is null or proceeding_yn='')")->row()->c;

        $sql = "SELECT case_no from      petitioner_part pb WHERE pb.dist_code='$dist_code' and pb.subdiv_code='$subdiv_code' and pb.cir_code='$cir_code'  ";

        $counts['Isthar'] = $this->db->query("SELECT count(case_no) as c from    Petition_Basic as pb WHERE pb.dist_code='$dist_code' and pb.subdiv_code='$subdiv_code' and pb.cir_code='$cir_code' and pb.mut_type='04' and pb.order_passed='Y' and pb.status='F' and pb.isthar_update is null and case_no in ($sql) ")->row()->c;
        $counts['CountPartitionOnline'] = $this->ServicePlusModel->count_online_partition_cases();

        $counts['Pcases'] = $this->getPendingASTNoticeGeneratedConversionCases($user_code, $dist_code, $subdiv_code, $cir_code);

        $counts['cases'] = $this->getPendingASTActionTakenConversionCases($user_code, $dist_code, $subdiv_code, $cir_code);

        $counts['premium'] = $this->getPendingASTPremiumConversionCases($user_code, $dist_code, $subdiv_code, $cir_code);

        $counts['payment'] = $this->getPendingASTPaymentConversionCases($user_code, $dist_code, $subdiv_code, $cir_code);

        $counts['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from  users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.user_code = '$user_code'")->row();

        $date_of_last_password_changed = $counts['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }
        if(ESCALATION_ENABLE == 1){
            $service_code = 3;
            $counts['service_type'] = OPART;
            $counts['escAllocateDays'] = $this->Escalationmodel->getTimeLine($service_code, 'OPART');
        }
        //var_dump($counts);

        $counts['_view'] = 'home/partition_ast';
        $this->load->view('layouts/main', $counts);
    }
    public function PartitionSk()
    {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $year_no = year_no;
        $define_date = define_date;

        $append = "dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code'";

        $counts['fmutation'] = $this->db->query("select count(*) as c from     field_mut_basic where order_passed is null and sk_flag is null and mut_type='01'  and date_entry >= '$define_date' and " . $append)->row()->c;

        $counts['fpartition'] = $this->db->query("select  count(*) as c from     field_mut_basic where order_passed is null and sk_flag is null and mut_type='02'and dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $counts['omutation'] = $this->db->query("SELECT count(*) as c from   Petition_basic WHERE  not_fresh='Y' and sk_comment is null and  lm_note_date is not null and order_passed is null and mut_type='01'  and date_entry >= '$define_date' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $counts['oconversion'] = $this->db->query("SELECT count(*) as c from   Petition_basic WHERE  not_fresh='Y' and sk_comment is null and  lm_note_date is not null and order_passed is null and mut_type='01'  and date_entry >= '$define_date' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $counts['omutation'] = $this->db->query("SELECT count(*) as c from   Petition_basic WHERE  not_fresh='Y' and sk_comment is null and  lm_note_date is not null and order_passed is null and mut_type='03' and dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $counts['opartition'] = $this->db->query("SELECT count(*) as c from   Petition_basic WHERE  not_fresh='Y' and sk_comment is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  lm_note_date is not null and order_passed is null and mut_type='04' and dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $counts['cases'] = $this->db->query("select count(*) as c from     petition_basic where not_fresh = 'Y'  and date_entry >= '$define_date' and lm_note_yn = 'Y' and status = 'P' and sk_comment is null and mut_type='01' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $counts['allotment_sk'] = $this->db->query("Select count(*) as c from     allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and lm_note='Y' and sk_note is null and not_fresh='Y' and status='P' and co_note is not null")->row()->c;

        $counts['countAPCaseforSK'] = $this->APCancellationModel->getCountAPCasesforSK(); //not done with the location checking
        //adding it for miscellaneous cases
        $counts['countMiscCaseSK'] = $this->NameCorrectionModel->getMiscCaseSK($user_code); //not done with the location checking

        $counts['grant_sk'] = $this->db->query("Select count(*) as c from     allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and lm_note='Y'  and sk_note is null and not_fresh='Y' and status='P' and settlement_typ='gr' ")->row()->c;

        $counts['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from     users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.user_code = '$user_code'")->row();

        $date_of_last_password_changed = $counts['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }

        if(ESCALATION_ENABLE == 1){
            $service_code = 1;
            $counts['service_type'] = OMUT;
            $counts['escAllocateDays'] = $this->Escalationmodel->getTimeLine($service_code, 'OMUT');
        }


        $counts['_view'] = 'home/partition_sk';
        $this->load->view('layouts/main', $counts);
    }

    public function ApcSk()
    {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $year_no = year_no;
        $define_date = define_date;

        $append = "dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code'";

        $counts['cases'] = $this->db->query("select count(*) as c from     petition_basic where not_fresh = 'Y'  and date_entry >= '$define_date' and lm_note_yn = 'Y' and status = 'P' and sk_comment is null and mut_type='01' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $counts['countAPCaseforSK'] = $this->APCancellationModel->getCountAPCasesforSK(); //not done with the location checking
        //adding it for miscellaneous cases
        $counts['countMiscCaseSK'] = $this->NameCorrectionModel->getMiscCaseSK($user_code); //not done with the location checking

        $counts['grant_sk'] = $this->db->query("Select count(*) as c from     allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and lm_note='Y'  and sk_note is null and not_fresh='Y' and status='P' and settlement_typ='gr' ")->row()->c;

        $counts['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from     users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.user_code = '$user_code'")->row();

        $date_of_last_password_changed = $counts['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }

        $counts['_view'] = 'home/apc_sk';
        $this->load->view('layouts/main', $counts);
    }

    public function ConversionAst()
    {

        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $year_no = year_no;
        $define_date = define_date;

        $counts['NoticeGen'] = $this->db->query("SELECT count(*) as c from    Petition_basic WHERE is_mb3!=1 and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and not_fresh='Y' and status ='P' and mut_type='04' and (notice_generated_yn is null or notice_generated_yn='' )  and date_entry >= '$define_date' ")->row()->c;

        $counts['PayNoticeGen'] = $this->db->query("SELECT count(*) as c from    Petition_basic WHERE is_mb3!=1 and dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and not_fresh='Y' and status ='P' and mut_type='04' and pay_notice_gen_yn ='Y' and  notice_served_yn!='Y'  ")->row()->c;

        $counts['byayPrak'] = $this->db->query("SELECT count(*) as c from    Petition_basic WHERE is_mb3!=1 and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  and date_entry >= '$define_date'  and pay_notice_gen_yn='Y' and status='P' and not_fresh='Y' and mut_type='04' and petition_no in ( SELECT petition_no from    Petition_byayprak WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and if_paid is null ) ")->row()->c;

        $counts['ProceedingOrder'] = $this->db->query("SELECT count(*) as c from    Petition_basic WHERE is_mb3!=1 and dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and not_fresh='Y' and status ='P' and mut_type='04' and (proceeding_yn is null or proceeding_yn='')")->row()->c;

        $counts['CountPartitionOnline'] = $this->ServicePlusModel->count_online_partition_cases();

        $counts['Pcases'] = $this->getPendingASTNoticeGeneratedConversionCases($user_code, $dist_code, $subdiv_code, $cir_code);

        $counts['cases'] = $this->getPendingASTActionTakenConversionCases($user_code, $dist_code, $subdiv_code, $cir_code);

        $counts['premium'] = $this->getPendingASTPremiumConversionCases($user_code, $dist_code, $subdiv_code, $cir_code);

        $counts['payment'] = $this->getPendingASTPaymentConversionCases($user_code, $dist_code, $subdiv_code, $cir_code);

        $counts['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from  users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.user_code = '$user_code'")->row();

        $date_of_last_password_changed = $counts['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }

        $counts['_view'] = 'home/conversion_ast';
        $this->load->view('layouts/main', $counts);
    }

    public function CitizenAst()
    {
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $year_no = year_no;
        $define_date = define_date;

        $counts['citizenpending'] = $this->db->query("Select count(*) as c from      cert_application WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='R' and apply_date >='$define_date'  ")->row()->c;
        $counts['CountJamaNakalOnline'] = 0; //$this->ServicePlusModel->count_online_ror_cases();
        $counts['CountMutationOnline'] = 0; // $this->ServicePlusModel->count_online_mutation_cases();
        $counts['CountOsOnline'] = 0; // $this->ServicePlusModel->count_online_os_cases();
        $counts['CountPartitionOnline'] = 0; // $this->ServicePlusModel->count_online_partition_cases();
        $counts['printR'] = $this->ServicePlusModel->getRoRCases($user_code, $dist_code, $subdiv_code, $cir_code);

        $counts['_view'] = 'home/citizen_ast';
        $this->load->view('layouts/main', $counts);
    }

    public function ApcAst()
    {
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $year_no = year_no;
        $define_date = define_date;

        $counts['citizenpending'] = $this->db->query("Select count(*) as c from      cert_application WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='R' and apply_date >='$define_date'  ")->row()->c;
        $counts['CountJamaNakalOnline'] = $this->ServicePlusModel->count_online_ror_cases();
        $counts['CountMutationOnline'] = $this->ServicePlusModel->count_online_mutation_cases();
        $counts['CountOsOnline'] = $this->ServicePlusModel->count_online_os_cases();
        $counts['CountPartitionOnline'] = $this->ServicePlusModel->count_online_partition_cases();

        $counts['countAPCaseShowCauseForAST'] = $this->APCancellationModel->countAPCaseShowCauseForAST($user_code, $dist_code, $subdiv_code, $cir_code); //not done with location checking

        $counts['_view'] = 'home/apc_ast';
        $this->load->view('layouts/main', $counts);
    }

    public function AcPPAst()
    {

        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $year_no = year_no;
        $define_date = define_date;

        $counts['citizenpending'] = $this->db->query("Select count(*) as c from      cert_application WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='R' and apply_date >='$define_date'  ")->row()->c;
        $counts['CountJamaNakalOnline'] = $this->ServicePlusModel->count_online_ror_cases();
        $counts['CountMutationOnline'] = $this->ServicePlusModel->count_online_mutation_cases();
        $counts['CountOsOnline'] = $this->ServicePlusModel->count_online_os_cases();
        $counts['CountPartitionOnline'] = $this->ServicePlusModel->count_online_partition_cases();

        $counts['countAPCaseShowCauseForAST'] = $this->APCancellationModel->countAPCaseShowCauseForAST($user_code, $dist_code, $subdiv_code, $cir_code); //not done with location checking

        $counts['_view'] = 'home/acpp_ast';
        $this->load->view('layouts/main', $counts);
    }

    public function MiscAst()
    {

        $allowed = ['AST'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $year_no = year_no;
        $define_date = define_date;

        $counts['citizenpending'] = $this->db->query("Select count(*) as c from      cert_application WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='R' and apply_date >='$define_date'  ")->row()->c;
        $counts['CountJamaNakalOnline'] = $this->ServicePlusModel->count_online_ror_cases();
        $counts['CountMutationOnline'] = $this->ServicePlusModel->count_online_mutation_cases();
        $counts['CountOsOnline'] = $this->ServicePlusModel->count_online_os_cases();
        $counts['CountPartitionOnline'] = $this->ServicePlusModel->count_online_partition_cases();

         $counts['NameCorrectionNoticeGenerate'] = $this->getPendingASTNoticeGeneratedNameCorrection($user_code, $dist_code, $subdiv_code, $cir_code);
     

         $counts['countAPCaseShowCauseForAST'] = $this->APCancellationModel->countAPCaseShowCauseForAST($user_code, $dist_code, $subdiv_code, $cir_code); //not done with location checking

         


         if(ESCALATION_ENABLE == 1){
            $counts['pactiontaken'] =  $this->db->query("SELECT count(*) as c from  misc_case_basic where fresh_yn='Y' and proceeding_yn='Y' and notice_generated_yn = 'Y' and note_of_action is null and es_flag = 1 and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

            // echo $this->db->last_query();

            $service_code = 8; //for NCAN=====
            $service_code_ncor = 6; //for NCOR=====
            // $counts['service_type']    = NCAN_SERV;
            $counts['service_type']    = MIND_SERV;
            $counts['escAllocateDays'] = $this->Escalationmodel->getTimeLine($service_code, 'NCAN');
            $counts['escAllocateDaysNCOR'] = $this->Escalationmodel->getTimeLine($service_code_ncor, 'NCOR');
        }
        
        $counts['_view'] = 'home/misc_ast';
        $this->load->view('layouts/main', $counts);
    }

    public function ConversionDc()
    {

        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = '00';
        $cir_code = '00';
        $mouza_pargona_code = '00';
        $lot_no = '00';

        $year_no = year_no;
        $define_date = define_date;
        $counts['sronote'] = $this->db->query("SELECT * from   sro_note WHERE dist_code='$dist_code' and (deed_type='SALE' or deed_type='GIFT' ) limit 10")->result();

        $counts['getDCAPCancellation'] = $this->APCancellationModel->getDCAPCancellationMatter();
        $counts['recommended_reclassification_DC'] = $this->db->query("SELECT count(*) as c from   t_reclassification WHERE co_yn = 'Y' and dc_yn is null and dc_approval is null and (status ='D')")->row()->c;
        $counts['reverted_reclassification_DC'] = $this->db->query("SELECT count(*) as c from   t_reclassification WHERE co_yn = 'Y' and dc_approval is not null and dc_yn is null and co_chitha_updated_yn is null and (status != 'R' OR status is null)")->row()->c;

        $counts['first_proceeding_for_dc'] = $this->db->query("select count(*) as c from     petition_basic where add_off_desig = '$user_desig_code' and bo_note_yn is null and co_user_code = '$user_code' and mut_type='01' and dist_code='$dist_code' and proceeding_yn is not null and bo_notice_gen is null and not status='D'")->row()->c;

        $counts['second_proceeding_for_dc'] = $this->db->query("select count(*) as c from     petition_basic where not_fresh = 'Y' and status = 'P' and add_off_desig = '$user_desig_code' and co_user_code = '$user_code' and mut_type='01' and dist_code='$dist_code' and bo_note_yn is not null and dept_note_yn is null")->row()->c;

        $counts['dpt_proceeding_for_dc'] = $this->db->query("select count(*) as c from petition_basic where dept_note_yn is null and not_fresh = 'Y' and status = 'W' and add_off_desig = 'DPT' and co_user_code = '$user_code' and mut_type='01' and dist_code='$dist_code' and bo_note_yn is not null")->row()->c;

        $counts['dpt_app_proceeding_for_dc'] = $this->db->query("select count(*) as c from petition_basic where dept_note_yn='Y' and not_fresh = 'Y' and status = 'P' and add_off_desig = '$user_desig_code' and co_user_code = '$user_code' and mut_type='01' and dist_code='$dist_code' and bo_note_yn is not null")->row()->c;

        $counts['allote_dc'] = $this->db->query("select count(*) as c from     allotment_cert_basic where status = 'R' and co_code is not null and dist_code='$dist_code' and bo_note is null and dc_code is null")->row()->c;

        $counts['allote_dc_bo'] = $this->db->query("select count(*) as c from     allotment_cert_basic where status = 'R' and co_code is not null and dist_code='$dist_code' and bo_note is not null and dc_note is not null")->row()->c;

        //added by hridayjit--12/05/2024
        $counts['dpt_revert_cases'] = $this->db->query("SELECT COUNT(*) as c FROM petition_basic WHERE dept_note_yn IS NULL AND not_fresh='Y' AND status='R' AND add_off_desig='DC' AND co_user_code=? AND user_code LIKE '%DPT%' AND mut_type='01' AND dist_code=? AND bo_note_yn IS NOT NULL", [$user_code, $dist_code])->row()->c;
        //

        //$counts['appeal_count'] = $this->db->query("select count(*) as c from     civil_appeal_basic where dist_code='$dist_code' and status = 'P' and order_type='12' and next_hearing_date is null and dc_order_yn is null ")->row()->c;

        $counts['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from     users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
            . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();

        $date_of_last_password_changed = $counts['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }

        if(ESCALATION_ENABLE == 1){
            $service_code = 4;
            $counts['service_type'] = CONV_SERV;
            $counts['escAllocateDays'] = $this->Escalationmodel->getTimeLine($service_code, 'RECLASS');
        }

        $counts['suomoto_reclass'] = $this->db->query("SELECT count(*) as c from   suomoto_reclass WHERE co_yn = 'Y' and dc_yn is null and dc_approval is null and (status='D') and not_fresh is not null")->row()->c;

        $counts['_view'] = 'home/conversion_dc';
        $this->load->view('layouts/main', $counts);
    }

    public function ApcDc()
    {

        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = '00';
        $cir_code = '00';
        $mouza_pargona_code = '00';
        $lot_no = '00';

        $year_no = year_no;
        $define_date = define_date;
        $counts['sronote'] = $this->db->query("SELECT * from   sro_note WHERE dist_code='$dist_code' and (deed_type='SALE' or deed_type='GIFT' ) limit 10")->result();

        $counts['getDCAPCancellation'] = $this->APCancellationModel->getDCAPCancellationMatter();
        $counts['recommended_reclassification_DC'] = $this->db->query("SELECT count(*) as c from   t_reclassification WHERE co_yn = 'Y' and dc_yn is null and dc_approval is null and (status != 'R' OR status is null)")->row()->c;
        $counts['reverted_reclassification_DC'] = $this->db->query("SELECT count(*) as c from   t_reclassification WHERE co_yn = 'Y' and dc_approval is not null and dc_yn is null and co_chitha_updated_yn is null and (status != 'R' OR status is null)")->row()->c;

        $counts['first_proceeding_for_dc'] = $this->db->query("select count(*) as c from     petition_basic where add_off_desig = '$user_desig_code' and bo_note_yn is null and co_user_code = '$user_code' and mut_type='01' and dist_code='$dist_code' and proceeding_yn is not null and bo_notice_gen is null and not status='D'")->row()->c;

        $counts['second_proceeding_for_dc'] = $this->db->query("select count(*) as c from     petition_basic where not_fresh = 'Y' and status = 'P' and add_off_desig = '$user_desig_code' and co_user_code = '$user_code' and mut_type='01' and dist_code='$dist_code' and bo_note_yn is not null")->row()->c;

        $counts['allote_dc'] = $this->db->query("select count(*) as c from     allotment_cert_basic where status = 'R' and co_code is not null and dist_code='$dist_code' and bo_note is null and dc_code is null")->row()->c;

        $counts['allote_dc_bo'] = $this->db->query("select count(*) as c from     allotment_cert_basic where status = 'R' and co_code is not null and dist_code='$dist_code' and bo_note is not null and dc_note is not null")->row()->c;

        //$counts['appeal_count'] = $this->db->query("select count(*) as c from     civil_appeal_basic where dist_code='$dist_code' and status = 'P' and order_type='12' and next_hearing_date is null and dc_order_yn is null ")->row()->c;

        $counts['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from     users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
            . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();

        $date_of_last_password_changed = $counts['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }

        $counts['_view'] = 'home/apc_dc';
        $this->load->view('layouts/main', $counts);
    }

    public function AcPPDc()
    {
        $allowed = ['DC'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = '00';
        $cir_code = '00';
        $mouza_pargona_code = '00';
        $lot_no = '00';

        $year_no = year_no;
        $define_date = define_date;
        $counts['sronote'] = $this->db->query("SELECT * from   sro_note WHERE dist_code='$dist_code' and (deed_type='SALE' or deed_type='GIFT' ) limit 10")->result();

        $counts['getDCAPCancellation'] = $this->APCancellationModel->getDCAPCancellationMatter();
        $counts['recommended_reclassification_DC'] = $this->db->query("SELECT count(*) as c from   t_reclassification WHERE co_yn = 'Y' and dc_yn is null and dc_approval is null and (status != 'R' OR status is null)")->row()->c;
        $counts['reverted_reclassification_DC'] = $this->db->query("SELECT count(*) as c from   t_reclassification WHERE co_yn = 'Y' and dc_approval is not null and dc_yn is null and co_chitha_updated_yn is null and (status != 'R' OR status is null)")->row()->c;

        $counts['first_proceeding_for_dc'] = $this->db->query("select count(*) as c from     petition_basic where add_off_desig = '$user_desig_code' and bo_note_yn is null and co_user_code = '$user_code' and mut_type='01' and dist_code='$dist_code' and proceeding_yn is not null and bo_notice_gen is null and not status='D'")->row()->c;

        $counts['second_proceeding_for_dc'] = $this->db->query("select count(*) as c from     petition_basic where not_fresh = 'Y' and status = 'P' and add_off_desig = '$user_desig_code' and co_user_code = '$user_code' and mut_type='01' and dist_code='$dist_code' and bo_note_yn is not null")->row()->c;

        $counts['allote_dc'] = $this->db->query("select count(*) as c from     allotment_cert_basic where status = 'R' and co_code is not null and dist_code='$dist_code' and bo_note is null and dc_code is null and settlement_typ is null")->row()->c;

        $counts['allote_dc_bo'] = $this->db->query("select count(*) as c from     allotment_cert_basic where status = 'R' and co_code is not null and dist_code='$dist_code' and bo_note is not null and dc_note is not null")->row()->c;

        //$counts['appeal_count'] = $this->db->query("select count(*) as c from     civil_appeal_basic where dist_code='$dist_code' and status = 'P' and order_type='12' and next_hearing_date is null and dc_order_yn is null ")->row()->c;

        $counts['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from     users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
            . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();

        $date_of_last_password_changed = $counts['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }

        if(ESCALATION_ENABLE == 1){
            $counts['allote_dc_esc'] = $this->db->query("select count(*) as c from allotment_cert_basic where status = 'R' and co_code is not null and dist_code='$dist_code' and bo_note is not null and dc_code is null and settlement_typ is null")->row()->c;

            $service_code = 5;
            $counts['service_type'] = ALLOT_SERV;
            $counts['escAllocateDays'] = $this->Escalationmodel->getTimeLine($service_code, 'ACPP');
        }

        $counts['_view'] = 'home/acpp_dc';
        $this->load->view('layouts/main', $counts);
    }

    public function AlotDc()
    {

        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = '00';
        $cir_code = '00';
        $mouza_pargona_code = '00';
        $lot_no = '00';

        $year_no = year_no;
        $define_date = define_date;
        $counts['sronote'] = $this->db->query("SELECT * from   sro_note WHERE dist_code='$dist_code' and (deed_type='SALE' or deed_type='GIFT' ) limit 10")->result();

        $counts['getDCAPCancellation'] = $this->APCancellationModel->getDCAPCancellationMatter();
        $counts['recommended_reclassification_DC'] = $this->db->query("SELECT count(*) as c from   t_reclassification WHERE co_yn = 'Y' and dc_yn is null and dc_approval is null and (status != 'R' OR status is null)")->row()->c;
        $counts['reverted_reclassification_DC'] = $this->db->query("SELECT count(*) as c from   t_reclassification WHERE co_yn = 'Y' and dc_approval is not null and dc_yn is null and co_chitha_updated_yn is null and (status != 'R' OR status is null)")->row()->c;

        $counts['first_proceeding_for_dc'] = $this->db->query("select count(*) as c from     petition_basic where add_off_desig = '$user_desig_code' and bo_note_yn is null and co_user_code = '$user_code' and mut_type='01' and dist_code='$dist_code' and proceeding_yn is not null and bo_notice_gen is null and not status='D'")->row()->c;

        $counts['second_proceeding_for_dc'] = $this->db->query("select count(*) as c from     petition_basic where not_fresh = 'Y' and status = 'P' and add_off_desig = '$user_desig_code' and co_user_code = '$user_code' and mut_type='01' and dist_code='$dist_code' and bo_note_yn is not null")->row()->c;

        $counts['allote_dc'] = $this->db->query("select count(*) as c from     allotment_cert_basic where status = 'R' and co_code is not null and dist_code='$dist_code' and bo_note is null and dc_code is null")->row()->c;

        $counts['allote_dc_bo'] = $this->db->query("select count(*) as c from     allotment_cert_basic where status = 'R' and co_code is not null and dist_code='$dist_code' and bo_note is not null and dc_note is not null")->row()->c;

        //$counts['appeal_count'] = $this->db->query("select count(*) as c from     civil_appeal_basic where dist_code='$dist_code' and status = 'P' and order_type='12' and next_hearing_date is null and dc_order_yn is null ")->row()->c;

        $counts['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from     users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
            . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();

        $date_of_last_password_changed = $counts['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }

        if(ESCALATION_ENABLE == 1){
            $service_code = 5;
            $counts['service_type'] = ALLOT_SERV;
            $counts['escAllocateDays'] = $this->Escalationmodel->getTimeLine($service_code, 'ACPP');
        }

        $counts['_view'] = 'home/alot_dc';
        $this->load->view('layouts/main', $counts);
    }

    public function ConversionAdc()
    {

        $allowed = ['DC','ADC'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = '00';
        $cir_code = '00';
        $mouza_pargona_code = '00';
        $lot_no = '00';

        $year_no = year_no;
        $define_date = define_date;

        $adc_code = $this->session->userdata('user_code');

        //************INTEGRATE CIRCLE MAPPING***************
        $circle_bifurcate = '';
        if (CIRCLE_BIRFURCATE_ADC == 1 && $this->session->userdata('user_desig_code') == 'ADC') {
            $circle_bifurcate = $this->circleMappingModel->caseListUnderMappingCircleOfADC();
        }
        //************END************************************

        $counts['sronote'] = $this->db->query("SELECT * from   sro_note WHERE dist_code='$dist_code' and (deed_type='SALE' or deed_type='GIFT' ) limit 10")->result();

        

        $counts['getDCAPCancellation'] = $this->APCancellationModel->getDCAPCancellationMatter();

       
        //$counts['recommended_reclassification_DC'] = $this->db->query("SELECT count(*) as c from   t_reclassification WHERE co_yn = 'Y' and dc_yn is null and dc_approval is null and (status != 'R' OR status is null)")->row()->c;
        $counts['recommended_reclassification_DC'] = $this->db->query("SELECT count(*) as c from   t_reclassification WHERE co_yn = 'Y' and dc_yn is null and dc_approval is null and (status='A') and (adc_code = '$adc_code' or adc_code is null) $circle_bifurcate ")->row()->c;
       
        $counts['reverted_reclassification_DC'] = $this->db->query("SELECT count(*) as c from   t_reclassification WHERE co_yn = 'Y' and dc_approval is not null and dc_yn is null and co_chitha_updated_yn is null and (status != 'R' OR status is null) $circle_bifurcate")->row()->c;

        $counts['first_proceeding_for_adc'] = $this->db->query("select count(*) as c from     petition_basic where add_off_desig = '$user_desig_code' and bo_note_yn is null and co_user_code = '$user_code' and  mut_type='01' and dist_code='$dist_code' and proceeding_yn is not null and bo_notice_gen is null $circle_bifurcate")->row()->c;

        $counts['second_proceeding_for_adc'] = $this->db->query("select count(*) as c from     petition_basic where not_fresh = 'Y' and status = 'P' and add_off_desig = '$user_desig_code' and co_user_code = '$user_code' and mut_type='01' and dist_code='$dist_code' and bo_note_yn is not null $circle_bifurcate")->row()->c;

        $counts['dpt_proceeding_for_adc'] = $this->db->query("select count(*) as c from petition_basic where dept_note_yn is null and not_fresh = 'Y' and status = 'W' and add_off_desig = 'DPT' and co_user_code = '$user_code' and mut_type='01' and dist_code='$dist_code' and bo_note_yn is not null $circle_bifurcate")->row()->c;

        $counts['dpt_app_proceeding_for_adc'] = $this->db->query("select count(*) as c from petition_basic where dept_note_yn='Y' and not_fresh = 'Y' and status = 'P' and add_off_desig = '$user_desig_code' and co_user_code = '$user_code' and mut_type='01' and dist_code='$dist_code' and bo_note_yn is not null $circle_bifurcate")->row()->c;

        $counts['first_proceeding_for_dc'] = $this->db->query("select count(*) as c from     petition_basic where add_off_desig = '$user_desig_code' and bo_note_yn is null and status not in ('F','D') and co_user_code = '$user_code' and mut_type='01' and dist_code='$dist_code' and proceeding_yn is not null and bo_notice_gen is null and not status='D'")->row()->c;
        
        

        $counts['second_proceeding_for_dc'] = $this->db->query("select count(*) as c from     petition_basic where not_fresh = 'Y' and status = 'P' and add_off_desig = '$user_desig_code' and co_user_code = '$user_code' and mut_type='01' and dist_code='$dist_code' and bo_note_yn is not null")->row()->c;

        $counts['allote_dc'] = $this->db->query("select count(*) as c from     allotment_cert_basic where status = 'R' and co_code is not null and dist_code='$dist_code' and bo_note is null and dc_code is null")->row()->c;

        $counts['allote_dc_bo'] = $this->db->query("select count(*) as c from     allotment_cert_basic where status = 'R' and co_code is not null and dist_code='$dist_code' and bo_note is not null and dc_note is not null")->row()->c;

        

        $counts['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from     users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
            . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();

        $date_of_last_password_changed = $counts['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }

        if(ESCALATION_ENABLE == 1){
            $service_code = 4;
            $counts['service_type'] = RECLASS_SERV;
            $counts['escAllocateDays'] = $this->Escalationmodel->getTimeLine($service_code, 'RECLASS');
        }

        $counts['suomoto_reclass'] = $this->db->query("SELECT count(*) as c from   suomoto_reclass WHERE co_yn = 'Y' and dc_yn is null and dc_approval is null and (status='A')")->row()->c;

        $counts['_view'] = 'home/conversion_adc';
        $this->load->view('layouts/main', $counts);
    }

    public function ApcAdc()
    {
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = '00';
        $cir_code = '00';
        $mouza_pargona_code = '00';
        $lot_no = '00';

        $year_no = year_no;
        $define_date = define_date;
        $counts['sronote'] = $this->db->query("SELECT * from   sro_note WHERE dist_code='$dist_code' and (deed_type='SALE' or deed_type='GIFT' ) limit 10")->result();

        $counts['getDCAPCancellation'] = $this->APCancellationModel->getDCAPCancellationMatter();
        $counts['recommended_reclassification_DC'] = $this->db->query("SELECT count(*) as c from   t_reclassification WHERE co_yn = 'Y' and dc_yn is null and dc_approval is null and (status != 'R' OR status is null)")->row()->c;
        $counts['reverted_reclassification_DC'] = $this->db->query("SELECT count(*) as c from   t_reclassification WHERE co_yn = 'Y' and dc_approval is not null and dc_yn is null and co_chitha_updated_yn is null and (status != 'R' OR status is null)")->row()->c;

        $counts['first_proceeding_for_adc'] = $this->db->query("select count(*) as c from     petition_basic where add_off_desig = '$user_desig_code' and bo_note_yn is null and co_user_code = '$user_code' and  mut_type='01' and dist_code='$dist_code' and proceeding_yn is not null and bo_notice_gen is null")->row()->c;

        $counts['second_proceeding_for_adc'] = $this->db->query("select count(*) as c from     petition_basic where not_fresh = 'Y' and status = 'P' and add_off_desig = '$user_desig_code' and co_user_code = '$user_code' and mut_type='01' and dist_code='$dist_code' and bo_note_yn is not null")->row()->c;

        $counts['first_proceeding_for_dc'] = $this->db->query("select count(*) as c from     petition_basic where add_off_desig = '$user_desig_code' and bo_note_yn is null and co_user_code = '$user_code' and mut_type='01' and dist_code='$dist_code' and proceeding_yn is not null and bo_notice_gen is null and not status='D'")->row()->c;

        $counts['second_proceeding_for_dc'] = $this->db->query("select count(*) as c from     petition_basic where not_fresh = 'Y' and status = 'P' and add_off_desig = '$user_desig_code' and co_user_code = '$user_code' and mut_type='01' and dist_code='$dist_code' and bo_note_yn is not null")->row()->c;

        $counts['allote_dc'] = $this->db->query("select count(*) as c from     allotment_cert_basic where status = 'R' and co_code is not null and dist_code='$dist_code' and bo_note is null and dc_code is null")->row()->c;

        $counts['allote_dc_bo'] = $this->db->query("select count(*) as c from     allotment_cert_basic where status = 'R' and co_code is not null and dist_code='$dist_code' and bo_note is not null and dc_note is not null")->row()->c;

        $counts['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from     users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
            . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();

        $date_of_last_password_changed = $counts['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }

        $counts['_view'] = 'home/apc_adc';
        $this->load->view('layouts/main', $counts);
    }

    public function AlotAdc()
    {
        $allowed = ['ADC'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = '00';
        $cir_code = '00';
        $mouza_pargona_code = '00';
        $lot_no = '00';

        $year_no = year_no;
        $define_date = define_date;

        //************INTEGRATE CIRCLE MAPPING***************
        $circle_bifurcate = '';
        if (CIRCLE_BIRFURCATE_ADC == 1 && $this->session->userdata('user_desig_code') == 'ADC') {
            $flag = 'ALLOTMENT';
            $circle_bifurcate = $this->circleMappingModel->caseListUnderMappingCircleOfADC($flag);
        }
        //************END************************************

        $counts['sronote'] = $this->db->query("SELECT * from   sro_note WHERE dist_code='$dist_code' and (deed_type='SALE' or deed_type='GIFT' ) limit 10")->result();

        $counts['getDCAPCancellation'] = $this->APCancellationModel->getDCAPCancellationMatter();
        $counts['recommended_reclassification_DC'] = $this->db->query("SELECT count(*) as c from   t_reclassification WHERE co_yn = 'Y' and dc_yn is null and dc_approval is null and (status != 'R' OR status is null)")->row()->c;
        $counts['reverted_reclassification_DC'] = $this->db->query("SELECT count(*) as c from   t_reclassification WHERE co_yn = 'Y' and dc_approval is not null and dc_yn is null and co_chitha_updated_yn is null and (status != 'R' OR status is null)")->row()->c;

        $counts['first_proceeding_for_adc'] = $this->db->query("select count(*) as c from     petition_basic where add_off_desig = '$user_desig_code' and bo_note_yn is null and co_user_code = '$user_code' and  mut_type='01' and dist_code='$dist_code' and proceeding_yn is not null and bo_notice_gen is null")->row()->c;

        $counts['second_proceeding_for_adc'] = $this->db->query("select count(*) as c from     petition_basic where not_fresh = 'Y' and status = 'P' and add_off_desig = '$user_desig_code' and co_user_code = '$user_code' and mut_type='01' and dist_code='$dist_code' and bo_note_yn is not null")->row()->c;

        $counts['first_proceeding_for_dc'] = $this->db->query("select count(*) as c from     petition_basic where add_off_desig = '$user_desig_code' and bo_note_yn is null and co_user_code = '$user_code' and mut_type='01' and dist_code='$dist_code' and proceeding_yn is not null and bo_notice_gen is null and not status='D'")->row()->c;

        $counts['second_proceeding_for_dc'] = $this->db->query("select count(*) as c from     petition_basic where not_fresh = 'Y' and status = 'P' and add_off_desig = '$user_desig_code' and co_user_code = '$user_code' and mut_type='01' and dist_code='$dist_code' and bo_note_yn is not null")->row()->c;

        $counts['allote_dc'] = $this->db->query("select count(*) as c from     allotment_cert_basic where status = 'R' and co_code is not null and dist_code='$dist_code' and bo_note is null and dc_code is null and settlement_typ is null $circle_bifurcate")->row()->c;

        $counts['allote_dc_bo'] = $this->db->query("select count(*) as c from     allotment_cert_basic where status = 'R' and co_code is not null and dist_code='$dist_code' and bo_note is not null and dc_note is not null and settlement_typ is null $circle_bifurcate")->row()->c;

        $counts['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from     users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
            . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();
        $counts['reverted_by_co'] = $this->db->query("SELECT count(*) AS c FROM allotment_cert_basic
                    WHERE dc_note IS NULL AND status='R' AND case_no IN
                    (SELECT distinct on (pp.case_no) pp.case_no FROM petition_proceeding_dc_adc pp WHERE pp.status='R' ORDER BY pp.case_no,pp.proceeding_id DESC) $circle_bifurcate")->row()->c;
        $date_of_last_password_changed = $counts['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }

        if(ESCALATION_ENABLE == 1)
        {
            $service_code = 5;
            $counts['service_type'] = ALLOT_SERV;
            $counts['escAllocateDays'] = $this->Escalationmodel->getTimeLine($service_code, 'ACPP');
        }

        $counts['_view'] = 'home/alot_adc';
        $this->load->view('layouts/main', $counts);
    }

    public function MisAdc()
    {
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = '00';
        $cir_code = '00';
        $mouza_pargona_code = '00';
        $lot_no = '00';

        $year_no = year_no;
        $define_date = define_date;
        $counts['sronote'] = $this->db->query("SELECT * from   sro_note WHERE dist_code='$dist_code' and (deed_type='SALE' or deed_type='GIFT' ) limit 10")->result();

        $counts['getDCAPCancellation'] = $this->APCancellationModel->getDCAPCancellationMatter();
        $counts['recommended_reclassification_DC'] = $this->db->query("SELECT count(*) as c from   t_reclassification WHERE co_yn = 'Y' and dc_yn is null and dc_approval is null and (status != 'R' OR status is null)")->row()->c;
        $counts['reverted_reclassification_DC'] = $this->db->query("SELECT count(*) as c from   t_reclassification WHERE co_yn = 'Y' and dc_approval is not null and dc_yn is null and co_chitha_updated_yn is null and (status != 'R' OR status is null)")->row()->c;

        $counts['first_proceeding_for_adc'] = $this->db->query("select count(*) as c from     petition_basic where add_off_desig = '$user_desig_code' and bo_note_yn is null and co_user_code = '$user_code' and  mut_type='01' and dist_code='$dist_code' and proceeding_yn is not null and bo_notice_gen is null")->row()->c;

        $counts['second_proceeding_for_adc'] = $this->db->query("select count(*) as c from     petition_basic where not_fresh = 'Y' and status = 'P' and add_off_desig = '$user_desig_code' and co_user_code = '$user_code' and mut_type='01' and dist_code='$dist_code' and bo_note_yn is not null")->row()->c;

        $counts['first_proceeding_for_dc'] = $this->db->query("select count(*) as c from     petition_basic where add_off_desig = '$user_desig_code' and bo_note_yn is null and co_user_code = '$user_code' and mut_type='01' and dist_code='$dist_code' and proceeding_yn is not null and bo_notice_gen is null and not status='D'")->row()->c;

        $counts['second_proceeding_for_dc'] = $this->db->query("select count(*) as c from     petition_basic where not_fresh = 'Y' and status = 'P' and add_off_desig = '$user_desig_code' and co_user_code = '$user_code' and mut_type='01' and dist_code='$dist_code' and bo_note_yn is not null")->row()->c;

        $counts['allote_dc'] = $this->db->query("select count(*) as c from     allotment_cert_basic where status = 'R' and co_code is not null and dist_code='$dist_code' and bo_note is null and dc_code is null")->row()->c;

        $counts['allote_dc_bo'] = $this->db->query("select count(*) as c from     allotment_cert_basic where status = 'R' and co_code is not null and dist_code='$dist_code' and bo_note is not null and dc_note is not null")->row()->c;

        $counts['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from     users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
            . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();

        $date_of_last_password_changed = $counts['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }

        $counts['_view'] = 'home/mis_adc';
        $this->load->view('layouts/main', $counts);
    }
    public function CompServiceAst()
    {
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $year_no = year_no;
        $define_date = define_date;

        $sql = "select count(*) as c from landsale where distcode=? and
            subcode=? and circode=? and compserv=? and noticeserv is null";
        $res = $this->db->query($sql, array($dist_code, $subdiv_code, $cir_code, 'Y'));

        if ($res->num_rows() > 0) {
            $counts['pnotice'] = $res->row()->c;
        }

        $sql2 = "select count(*) as c from petition_basic where dist_code=? and
            subdiv_code=? and cir_code=? and noc_no is not null
            and note_action_yn is null and notice_generated_yn=? and comp_serv_yn=?";
        $res2 = $this->db->query($sql2, array($dist_code, $subdiv_code, $cir_code, 'Y', 'Y'));

        if ($res2->num_rows() > 0) {
            $counts['paction'] = $res2->row()->c;
        }
        $counts['_view'] = 'home/composite_service';
        $this->load->view('layouts/main', $counts);
    }

    public function CompServiceCo()
    {
        if ( ! in_array($this->session->userdata('user_desig_code'), ['CO']) )
        {
            echo json_encode('Unauthorized access');
            exit;
        }

        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page',
        );

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $sql2 = "select count(noc_no) as c from petition_basic p left join landsale l on p.noc_no=l.appno where dist_code=? and
            subdiv_code=? and cir_code=? and noc_no is not null
            and note_action_yn is not null and (status=? or status=?)
            and notice_served_yn=? and add_off_name=? and comp_serv_yn=? and l.boallowed!=?";
        $res2 = $this->db->query($sql2,
            array($dist_code, $subdiv_code, $cir_code, 'P', 'H', 'Y', $this->session->userdata('user_code'), 'Y', 'Reject'));

        if ($res2->num_rows() > 0) {
            $data['cases_no'] = $res2->row()->c;
        }

        $sql3 = "select count(distinct(noc_no)) as c from petition_basic p left join sro_note sn on p.noc_no=sn.nocno and p.dist_code=sn.dist_code and p.subdiv_code=sn.subdiv_code and p.cir_code=sn.cir_code and p.mouza_pargona_code=sn.mouza_pargona_code and p.lot_no=sn.lot_no and p.vill_townprt_code=sn.vill_townprt_code left join landsale l on p.noc_no=l.appno  where p.dist_code=? and
            p.subdiv_code=? and p.cir_code=? and p.noc_no is not null and
            sn.nocno is not null  and (p.status=? or p.status=?)
            and notice_served_yn=? and add_off_name=? and comp_serv_yn=? and l.boallowed!=?";
        $res3 = $this->db->query($sql3,
            array($dist_code, $subdiv_code, $cir_code, 'P', 'H', 'Y', $this->session->userdata('user_code'), 'Y', 'Reject'));
        // echo $this->db->last_query();
        if ($res3->num_rows() > 0) {
            $data['casef_no'] = $res3->row()->c;
        }

        $data['_view'] = 'home/composite_service';
        $this->load->view('layouts/main', $data);
    }

    /******* Khatian 15.7.2022 *****/
    public function khatianLm()
    {
        $user_desig_code = $this->session->userdata('user_desig_code');
        if ($user_desig_code == 'LM') {
            $data['_view'] = 'Khatian/khatian_lm';
            $this->load->view('layouts/main', $data);
        }
    }

    public function khatianCo()
    {
        $user_desig_code = $this->session->userdata('user_desig_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        if ($user_desig_code == 'CO') {
            $sqlKhatian20 = "select count(*) as c from (select distinct on (uuid, khatian_no) uuid, khatian_no, count(*) from temp_khatian where status='P' and dist_code=? and subdiv_code = ? and cir_code = ? group by uuid, khatian_no ) as c";
            $countKhatian20 = $this->db->query($sqlKhatian20, array($dist_code, $subdiv_code, $cir_code))->row()->c;
            $sqlKhatian21 = "select count(*) as c from (select distinct on (uuid, khatian_no) uuid, khatian_no, count(*) from temp_khatian where status='F' and subdiv_code = ? and cir_code = ? group by uuid, khatian_no ) as c";
            $countKhatian21 = $this->db->query($sqlKhatian21, array($subdiv_code, $cir_code))->row()->c;
            $sqlKhatian22 = "select count(*) as c from chitha_tenant where subdiv_code=? and cir_code=? and khatian_no!='0' ";
            $countKhatian22 = $this->db->query($sqlKhatian22, array($subdiv_code, $cir_code))->row()->c;
            $data['count'] = $countKhatian20;
            $data['approved'] = $countKhatian21;
            $data['totalRaytee'] = $countKhatian22;
            $data['_view'] = 'Khatian/khatian_co_menu';
            $this->load->view('layouts/main', $data);
        }
    }

    /***** Patta Apply 29.07.2022 *****/
    public function pattaLm()
    {
        $user_desig_code = $this->session->userdata('user_desig_code');
        if ($user_desig_code == 'LM') {
            $data['_view'] = 'Patta/patta_lm_menu';
            $this->load->view('layouts/main', $data);
        }
    }

    /***** Patta Apply 29.07.2022 *****/
    public function pattaCo()
    {
        $user_desig_code = $this->session->userdata('user_desig_code');
        if ($user_desig_code == 'CO') {
            $data['_view'] = 'Patta/patta_co_menu';
            $this->load->view('layouts/main', $data);
        }
    }

    //// settlement addition ////

    public function caseListUnderMappingLot()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');
        //////////////////MARKING FOR CIRCLE WISE LOT MAPPING===========
        $sql = "Select user_code from loginuser_table where dist_code=? and subdiv_code=? and cir_code=? and dis_enb_option='E' and user_code like 'CO%'";
        $data = $this->db->query($sql, array($dist_code, $subdiv_code, $cir_code));
        $lot_array = array();
        if ($data->num_rows() > 1) {
            $sql1 = "Select * from user_attached_mapping where dist_code=? and subdiv_code=? and cir_code=? and user_code=? ";
            $data1 = $this->db->query($sql1, array($dist_code, $subdiv_code, $cir_code, $user_code));

            foreach ($data1->result() as $key => $value) {
                $lot_array[] = $value->mouza_pargona_code . '_' . $value->lot_no;
            }
            //////////////////
        }
        $lot_string = null;
        if (!empty($lot_array) && $lot_array != null) {
            $lot_string = $this->convertLiteral($lot_array);
        }
        log_message("error", "MB: LOT STRING====FOR CIRCLE==D" . $dist_code . "S" . $subdiv_code . "C" . $cir_code . "==" . json_encode($lot_string));
        return $lot_string;
    }

    public function convertLiteral($array)
    {
        $index = 0;
        $final_str = '';
        foreach ($array as $a) {
            if ($index == 0) {
                $final_str = "'" . $a . "'";
            } else {
                $final_str = $final_str . ",'" . $a . "'";
            }

            $index++;
        }
        return $final_str;
    }

    public function SettlementTenantCo()
    {
        
        $service_code = $this->input->get('service');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $lot_no = $this->session->userdata('lot_no');
        $user_code = $this->session->userdata('user_code');
        $year_no = year_no;
        $define_date = define_date;
        $this->dbswitch();
        $user_desig_code = $this->session->userdata('user_desig_code');
        if ($user_desig_code != 'CO' && $user_desig_code != 'SK') {
            $this->session->set_flashdata('message', "#HOMEC0503303 : Unauthorized access");
            redirect(base_url() . "index.php/home");
        }
        $counts['user_desig_code'] = $user_desig_code;

        if (LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO') {
            $lot_string = $this->caseListUnderMappingLot();
        }

        $lot_bifurcate = '';
        $lot_bifurcate_sb = '';

        if (LOT_BIFURCATE == 1) {
            if (isset($lot_string) && $lot_string != null) {
                $lot_bifurcate = "and mouza_pargona_code ||'_' || lot_no in ($lot_string)";
            }
        }

        $data['pendingcount'] = $this->db->query("select count(*) as c from  settlement_basic where service_code = '$service_code' and pending_office = 'CO' and dist_code ='$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'")->row()->c;
        $user_desig_code = $this->session->userdata('user_desig_code');

        // $counts['first'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='W' and (from_office='LM' OR from_office='SK') and (pending_officer='CO' OR pending_officer='SK') and service_code='$service_code'  and date_entry >= '$define_date' ")->row()->c;
        $counts['first'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='W' and from_office in ('LM','SK','CO','ADC','SDO') and (pending_officer='CO' or pending_officer='SK') and service_code='$service_code'   and date_entry >= '$define_date' $lot_bifurcate")->row()->c;

        // $counts['sk_first'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='W' and from_office='LM' and pending_officer='SK' and service_code='$service_code'  and date_entry >= '$define_date' ")->row()->c;
        $counts['sk_first'] = $this->db->query("select count(*) as c from settlement_basic sb left join settlement_ap_lmnote sal on sb.case_no=sal.case_no where  sal.lm_note ='1' and  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and sb.status='W' and from_office='LM' and (pending_officer='SK' or pending_officer='CO') and service_code='$service_code'  and sb.date_entry >= '$define_date' ")->row()->c;
        // $counts['_view'] = 'settlement_mb/settlement_mb_co';
        $counts['re_report_lm'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='X' and (from_office='LM' OR from_office='SK' OR from_office='DC') and (pending_officer='CO' OR pending_officer='SK') and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['re_report_lm_co'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='X' and (from_office='LM' OR from_office='SK') and (pending_officer='CO' OR pending_officer='SK') and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['re_report_lm_sk'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='X' and (from_office='LM' OR from_office='DC') and pending_officer='SK' and service_code='$service_code'  and date_entry >= '$define_date' ")->row()->c;
        // $counts['reverted_by_dc'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='R' and from_office='DC' and pending_officer='CO' and service_code='$service_code'  and date_entry >= '$define_date' ")->row()->c;
        $counts['reverted_by_dc'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='R' and (from_office='DC' or from_office='ADC' or from_office='SDO') and pending_officer='CO' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['chitha'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='C' and from_office='DC' and pending_officer='CO'  and service_code='$service_code'  and date_entry >= '$define_date' ")->row()->c;

        $counts['payment_notice'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='M' and (from_office='DPT' or from_office='DC') and pending_officer='CO' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['payment_confirm'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='N' and from_office='CO' and pending_officer='CO' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['reverted_by_co'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='R' and from_office='CO'  and pending_officer='LM' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['forwarded_to_adc'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_officer not in('LM','SK','CO') and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['rejected_by_co'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_officer='CO' and status='D' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['revival_flag_list'] = $this->db->query("select count(*) as c from settlement_revival_flag where  req_by='CO' and  req_by = 'CO' and service_code='$service_code'  and (user_code='$user_code')")->row()->c;

        $counts['bulk_chitha_update'] = $this->db->query("select count(distinct(sb.case_no)) as c from settlement_basic sb join settlement_premium sp on sb.case_no = sp.case_no where sb.status = ? and sb.dist_code = ? and sb.subdiv_code = ? and sb.cir_code = ? and sb.from_office in ('CO', 'DC') and sb.pending_officer in ('CO') and sb.service_code = ? and sp.is_final = ? and sp.grn_no is not null AND sb.order_passed is null AND sb.co_chitha_corrected_yn is null " . $lot_bifurcate_sb, array('VN', $dist_code, $subdiv_code, $cir_code, SETTLEMENT_TENANT_ID, 1))->row()->c;
        // echo $this->db->last_query(); die();
        // var_dump($counts['payment_notice']); die();
        $counts['service_code'] = $service_code;
        $counts['_view'] = 'SettlementView/Co/Tenant/SettlementTenantCoMenuView';
        $this->load->view('layouts/main', $counts);
    }

    public function SettlementTenantLm()
    {
        $service_code = SETTLEMENT_TENANT_ID;
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $user_code = $this->session->userdata('user_code');
        $year_no = year_no;
        $define_date = define_date;
        $this->dbswitch();
        //var_dump($this->session->all_userdata());
        $user_desig_code = $this->session->userdata('user_desig_code');
        $counts['reverted'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no = '$lot_no' and service_code='$service_code' and status='R' and from_office='CO' and pending_officer='LM'  and date_entry >= '$define_date' ")->row()->c;

        $counts['notice_generated_count'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and service_code='$service_code' and status='N' and pending_officer='CO' and chitha_processing_details = 0  and date_entry >= '$define_date' ")->row()->c;

        $counts['reverted_review'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and service_code='$service_code' and status='RA' and from_office='CO' and pending_officer='LM'  and date_entry >= '$define_date' ")->row()->c;
        // echo $this->db->last_query(); die();
        $counts['service_code'] = $service_code;
        $counts['_view'] = 'settlement_mb/settlement_mb_lm';
        $this->load->view('layouts/main', $counts);
    }

    public function SettlementKhasLandLm()
    {
        $service_code = SETTLEMENT_KHAS_LAND_ID;
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $user_code = $this->session->userdata('user_code');
        $year_no = year_no;
        $define_date = define_date;
        $this->dbswitch();
        //var_dump($this->session->all_userdata());
        $user_desig_code = $this->session->userdata('user_desig_code');
        $counts['reverted'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and service_code='$service_code' and status='R' and from_office='CO' and pending_officer='LM'  and date_entry >= '$define_date' ")->row()->c;

        $counts['notice_generated_count'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and service_code='$service_code' and status='N' and pending_officer='CO' and chitha_processing_details = 0  and date_entry >= '$define_date' ")->row()->c;

        $counts['reverted_review'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and service_code='$service_code' and status='RA' and from_office='CO' and pending_officer='LM'  and date_entry >= '$define_date' ")->row()->c;

        $counts['service_code'] = $service_code;
        $counts['_view'] = 'settlement_mb/settlement_mb_lm';
        $this->load->view('layouts/main', $counts);
    }

    public function SettlementKhasLandCo()
    {
        // echo "sadfghjk"; die;
        $service_code = $this->input->get('service');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $lot_no = $this->session->userdata('lot_no');
        $user_code = $this->session->userdata('user_code');
        $year_no = year_no;
        $define_date = define_date;
        $this->dbswitch();
        // var_dump($this->session->all_userdata()); die;
        $user_desig_code = $this->session->userdata('user_desig_code');
        if ($user_desig_code != 'CO' && $user_desig_code != 'SK') {
            $this->session->set_flashdata('message', "#HOMEC1503303 : Unauthorized access");
            redirect(base_url() . "index.php/home");
        }

        $counts['user_desig_code'] = $user_desig_code;

        if (LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO') {
            $lot_string = $this->caseListUnderMappingLot();
        }

        $lot_bifurcate = '';
        $lot_bifurcate_sb = '';

        if (LOT_BIFURCATE == 1) {
            if (isset($lot_string) && $lot_string != null) {
                $lot_bifurcate = "and mouza_pargona_code ||'_' || lot_no in ($lot_string)";
                $lot_bifurcate_sb = "and sb.mouza_pargona_code ||'_' || sb.lot_no in ($lot_string)";
            }
        }

        $counts['sk_first'] = $this->db->query("select count(*) as c from settlement_basic left join settlement_ap_lmnote on settlement_basic.case_no=settlement_ap_lmnote.case_no where  lm_note ='1' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and settlement_basic.status='W' and from_office='LM' and (pending_officer='SK' OR pending_officer='CO') and service_code='$service_code'  and settlement_basic.date_entry >= '$define_date' ")->row()->c;

        $counts['re_report_lm_sk'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='X' and (from_office='LM' OR from_office='DC') and pending_officer='SK' and service_code='$service_code'  and date_entry >= '$define_date' ")->row()->c;

        $counts['first'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='W' and from_office in ('LM','SK','CO','ADC','SDO') and (pending_officer='CO' or pending_officer='SK') and service_code='$service_code'   and date_entry >= '$define_date' $lot_bifurcate")->row()->c;
        // $counts['_view'] = 'settlement_mb/settlement_mb_co';

        $counts['re_report_lm'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='X' and (from_office='LM' OR from_office='SK' OR from_office='DC') and (pending_officer='CO' or pending_officer='SK') and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['reverted_by_dc'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='R' and (from_office='DC' or from_office='ADC' or from_office='SDO') and pending_officer='CO'  and service_code='$service_code'  and date_entry >= '$define_date' $lot_bifurcate")->row()->c;

        $counts['chitha'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='C' and from_office='DC' and pending_officer='CO' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['payment_notice'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='M' and (from_office='DPT' or from_office='DC') and pending_officer='CO' and service_code='$service_code' and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        // echo $this->db->last_query();

        $counts['payment_confirm'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='N' and from_office='CO' and pending_officer='CO' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['reverted_by_co'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='R' and from_office='CO'  and pending_officer='LM' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['forwarded_to_adc'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_officer not in('LM','SK','CO') and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['rejected_by_co'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_officer='CO' and status='D' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['revival_flag_list'] = $this->db->query("select count(*) as c from settlement_revival_flag where  req_by='CO' and  req_by = 'CO' and service_code='$service_code'  and (user_code='$user_code')")->row()->c;

        $counts['bulk_approve_lm_report'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='N' and from_office='CO' and pending_officer='CO' and service_code='$service_code' and chitha_processing_details = 1  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['bulk_chitha_update'] = $this->db->query("select count(distinct(sb.case_no)) as c from settlement_basic sb join settlement_premium sp on sb.case_no = sp.case_no where sb.status = ? and sb.chitha_processing_details = ? and sb.dist_code = ? and sb.subdiv_code = ? and sb.cir_code = ? and sb.from_office = ? and sb.pending_officer = ? and sb.service_code = ? and sp.is_final = ? and sp.grn_no is not null and DATE_PART('day', now()::timestamp- sb.ppp_issue_date::timestamp)>15 AND DATE_PART('day', now()::timestamp- sb.ppp_issue_date::timestamp)>15 AND sb.order_passed is null AND sb.co_chitha_corrected_yn is null " . $lot_bifurcate_sb, array('N', 2, $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', SETTLEMENT_KHAS_LAND_ID, 1))->row()->c;


        $counts['bulk_chitha_update_partial'] = $this->db->query("
        SELECT
            count(distinct(sb.case_no)) as C
            FROM settlement_basic sb
            JOIN
            (
                SELECT
                     sh.case_no
                 FROM
                     settlement_emi_history sh
                 JOIN
                     (
                         SELECT
                             case_no,
                             MAX(id) AS max_id
                         FROM
                             settlement_emi_history
                         GROUP BY
                             case_no
                         HAVING
                             COUNT(*) > 1
                     ) max_ids
                 ON
                     sh.case_no = max_ids.case_no
                 AND
                     sh.id = max_ids.max_id AND paid_no_of_installment != chitha_update_status
            ) AS seh
            ON sb.case_no = seh.case_no
            where sb.status = ?
            and sb.chitha_processing_details = ?
            and sb.dist_code = ?
            and sb.subdiv_code = ?
            and sb.cir_code = ?
            and sb.from_office = ?
            and sb.pending_officer = ?
            and sb.service_code = ?
            AND DATE_PART('day', now()::timestamp- sb.ppp_issue_date::timestamp)>15 AND DATE_PART('day', now()::timestamp- sb.ppp_issue_date::timestamp)>15 AND sb.order_passed is NOT NULL AND sb.co_chitha_corrected_yn is NOT NULL " . $lot_bifurcate_sb, array('N', 2, $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', SETTLEMENT_KHAS_LAND_ID))->row()->c;

        $counts['re_generate_premium_notice'] = $this->db->query('select count(distinct(sb.case_no)) as c from settlement_basic sb join settlement_premium sp on sb.case_no = sp.case_no join settlement_notice sn on sb.case_no = sn.case_no where sb.status = ? and sb.dist_code = ? and sb.subdiv_code = ? and sb.cir_code = ? and sb.from_office = ? and sb.pending_officer = ? and sb.service_code = ? and sp.is_final = ? and sp.grn_no is null and sn.notice_type=?' . $lot_bifurcate . '', array('N', $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', SETTLEMENT_KHAS_LAND_ID, 1, 'PN'))->row()->c;


        $counts['remain_amt_prem_notice'] = $this->db->query('select count(distinct(sb.case_no)) as c from settlement_basic sb join settlement_premium sp on sb.case_no = sp.case_no where sb.status = ? and sb.dist_code = ? and sb.subdiv_code = ? and sb.cir_code = ? and sb.from_office = ? and sb.pending_officer = ? and sb.service_code = ? and sp.is_final = ? and sp.grn_no is not null and sp.due_amount > sp.paid_amount and sb.case_no NOT IN (SELECT DISTINCT(case_no) FROM settlement_notice WHERE case_no = sb.case_no AND notice_type = ?) ' . $lot_bifurcate . '', array('N', $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', SETTLEMENT_KHAS_LAND_ID, 1, 'PNP1'))->row()->c;

        $counts['print_partial_notice'] = $this->db->query('select count(distinct(sb.case_no)) as c from settlement_basic sb join settlement_premium sp on sb.case_no = sp.case_no where sb.status = ? and sb.dist_code = ? and sb.subdiv_code = ? and sb.cir_code = ? and sb.from_office = ? and sb.pending_officer = ? and sb.service_code = ? and sp.is_final = ? and sp.grn_no is not null and sp.due_amount > sp.paid_amount and sb.case_no IN (SELECT DISTINCT(case_no) FROM settlement_notice WHERE case_no = sb.case_no AND notice_type = ?) ' . $lot_bifurcate . '', array('N', $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', SETTLEMENT_KHAS_LAND_ID, 1, 'PNP1'))->row()->c;


        // mb2 with already generated PN and not paid status for urban cases only 
        // $counts['notPaidAlreadyGeneratedPN'] = $this->db->query("SELECT distinct on (sb.case_no) * FROM settlement_basic sb LEFT JOIN settlement_premium sp ON sb.case_no=sp.case_no WHERE sb.dist_code='$dist_code' AND sb.subdiv_code='$subdiv_code' AND sb.cir_code='$cir_code' AND sb.status='N' AND (sb.from_office='DPT' OR sb.from_office='DC') AND sb.pending_officer='CO' AND sb.service_code='$service_code' AND sb.date_entry >= '$define_date' AND sp.is_final=1 AND sp.grn_no IS NULL AND sb.review_flag=0 AND 
        //     sp.area_name IN (1,2,3,4,5,6,11,12,13,14,15,16,17)  $lot_bifurcate")->num_rows();

        if($service_code == 16) 
        {
            $counts['notPaidAlreadyGeneratedPN'] = $this->db->query("SELECT distinct on (sb.case_no) * FROM settlement_basic sb LEFT JOIN settlement_premium sp ON sb.case_no=sp.case_no WHERE sb.dist_code=? AND sb.subdiv_code=? AND sb.cir_code=? AND sb.status=? AND (sb.from_office=? OR sb.from_office=?) AND sb.pending_officer=? AND sb.service_code=? AND sb.date_entry >= ? AND sp.is_final=? AND sp.grn_no IS NULL AND sb.review_flag=? AND sp.area_name IN (1,2,3,4,5,6,11,12,13,14,15,16,17) $lot_bifurcate", [$dist_code, $subdiv_code, $cir_code, 'N', 'DPT', 'DC', 'CO', $service_code, $define_date, 1, 0])->num_rows();
        }

        if($service_code == 16) 
        {
            $counts['notPaidAlreadyGeneratedPNRural'] = $this->db->query("SELECT distinct on (sb.case_no) * FROM settlement_basic sb LEFT JOIN settlement_premium sp ON sb.case_no=sp.case_no WHERE sb.dist_code=? AND sb.subdiv_code=? AND sb.cir_code=? AND sb.status=?  AND sb.pending_officer=? AND sb.service_code=? AND sb.date_entry >= ? AND sp.is_final=? AND sp.grn_no IS NULL AND sb.review_flag=? AND sp.area_name IN (10) and sb.review_flag=0 and date(sb.date_entry) <' 2024-06-01' $lot_bifurcate", [$dist_code, $subdiv_code, $cir_code, 'N', 'CO', $service_code, $define_date, 1, 0])->num_rows();
        }

        // echo $this->db->last_query(); die;

        $counts['service_code'] = $service_code;

        $counts['_view'] = 'settlement_mb/settlement_mb_co';
        $this->load->view('layouts/main', $counts);
    }

    public function SettlementApCo()
    {
        $service_code = $this->input->get('service');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $lot_no = $this->session->userdata('lot_no');
        $user_code = $this->session->userdata('user_code');
        $year_no = year_no;
        $define_date = define_date;
        // $service_code=SETTLEMENT_AP_TRANSFER_ID;
        $this->dbswitch();
        //var_dump($this->session->all_userdata());
        $user_desig_code = $this->session->userdata('user_desig_code');
        if ($user_desig_code != 'CO' && $user_desig_code != 'SK') {
            $this->session->set_flashdata('message', "#HOMEC2503303 : Unauthorized access");
            redirect(base_url() . "index.php/home");
        }
        $counts['user_desig_code'] = $user_desig_code;

        if (LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO') {
            $lot_string = $this->caseListUnderMappingLot();
        }

        $lot_bifurcate = '';
        $lot_bifurcate_sb = '';

        if (LOT_BIFURCATE == 1) {
            if (isset($lot_string) && $lot_string != null) {
                $lot_bifurcate = "and mouza_pargona_code ||'_' || lot_no in ($lot_string)";
                $lot_bifurcate_sb = "and sb.mouza_pargona_code ||'_' || sb.lot_no in ($lot_string)";

            }
        }

        // $counts['sk_first'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='W' and from_office='LM' and pending_officer='SK' and service_code='$service_code'  and date_entry >= '$define_date' ")->row()->c;
        $counts['sk_first'] = $this->db->query("select count(*) as c from settlement_basic sb left join settlement_ap_lmnote sal on sb.case_no=sal.case_no where  sal.lm_note ='1' and  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and sb.status='W' and from_office='LM' and (pending_officer='SK' or pending_officer='CO') and service_code='$service_code'  and sb.date_entry >= '$define_date' ")->row()->c;

        $counts['re_report_lm_sk'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='X' and (from_office='LM' OR from_office='DC') and pending_officer='SK' and service_code='$service_code'  and date_entry >= '$define_date' ")->row()->c;

        // $counts['first'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='W' and (from_office='LM' OR from_office='SK') and (pending_officer='CO' OR pending_officer='SK')  and date_entry >= '$define_date' and service_code='$service_code' ")->row()->c;
        // $counts['_view'] = 'settlement_mb/settlement_mb_co';

        // new code on 03/07/2023
        // $counts['first']  = $this->db->query("select count(*) as c from settlement_basic where notice_generated_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='W' and (from_office='LM' OR from_office='SK') and (pending_officer='CO' OR pending_officer='SK')  and date_entry >= '$define_date' and service_code='$service_code' ")->row()->c;
        $counts['first'] = $this->db->query("select count(*) as c from settlement_basic where notice_generated_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='W' and from_office in ('LM','SK','CO','ADC','SDO') and (pending_officer='CO' or pending_officer='SK') and service_code='$service_code'   and date_entry >= '$define_date' $lot_bifurcate ")->row()->c;
        $counts['second'] = $this->db->query("select count(*) as c from settlement_basic where notice_generated_yn='Y' and  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='W' and (pending_officer='CO' OR pending_officer='SK')  and date_entry >= '$define_date' and service_code='$service_code' ")->row()->c;

        $counts['apconotice'] = $this->db->query("select count(*) as c from settlement_basic where notice_generated_yn='Y' and status ='W' and  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (pending_officer='CO' OR pending_officer='LM' OR pending_officer='SK')  and date_entry >= '$define_date' and service_code='$service_code'  $lot_bifurcate")->row()->c;

        $counts['re_report_lm'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='X' and (from_office='LM' OR from_office='SK' OR from_office='DC') and (pending_officer='CO' OR pending_officer='SK')  and date_entry >= '$define_date' and service_code='$service_code'  $lot_bifurcate")->row()->c;

        $counts['reverted_by_dc'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='R' and (from_office='DC' OR from_office='ADC' OR from_office='SDO') and pending_officer='CO'  and date_entry >= '$define_date' and service_code='$service_code'  $lot_bifurcate")->row()->c;

        $counts['chitha'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='C' and from_office='DC' and pending_officer='CO'  and date_entry >= '$define_date' and service_code='$service_code'  $lot_bifurcate")->row()->c;

        $counts['payment_notice'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='M' and (from_office='DPT' or from_office='DC')  and pending_officer='CO'  and date_entry >= '$define_date' and service_code='$service_code'  $lot_bifurcate")->row()->c;

        $counts['payment_confirm'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='N' and from_office='CO' and pending_officer='CO'  and date_entry >= '$define_date' and service_code='$service_code'  $lot_bifurcate")->row()->c;
        // echo $this->db->last_query(); die();
        // var_dump($counts['payment_notice']); die();

        $counts['nrchitha'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='Z' and from_office='DC' and pending_officer='CO'  and date_entry >= '$define_date' and service_code='$service_code'  $lot_bifurcate")->row()->c;

        $counts['nrcase'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and service_code='$service_code' and status='Y' and from_office='DC' and pending_officer='CO'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['reverted_by_co'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='R' and from_office='CO'  and pending_officer='LM' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['forwarded_to_adc'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_officer not in('LM','SK','CO') and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['rejected_by_co'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_officer='CO' and status='D' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['forwarded_to_lm'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_officer in('LM') and status='V' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['revival_flag_list'] = $this->db->query("select count(*) as c from settlement_revival_flag where  req_by='CO' and  req_by = 'CO' and service_code='$service_code'  and (user_code='$user_code')")->row()->c;

        $counts['bulk_approve_lm_report'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='N' and from_office='CO' and pending_officer='CO' and service_code='$service_code' and chitha_processing_details = 1  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['service_code'] = $service_code;

        $counts['bulk_chitha_update'] = $this->db->query("select count(distinct(sb.case_no)) as c from settlement_basic sb join settlement_premium sp on sb.case_no = sp.case_no where sb.status = ? and sb.chitha_processing_details = ? and sb.dist_code = ? and sb.subdiv_code = ? and sb.cir_code = ? and sb.from_office = ? and sb.pending_officer = ? and sb.service_code = ? and sp.is_final = ? and sp.grn_no is not null and DATE_PART('day', now()::timestamp- sb.ppp_issue_date::timestamp)>15 AND DATE_PART('day', now()::timestamp- sb.ppp_issue_date::timestamp)>15 AND sb.order_passed is null AND sb.co_chitha_corrected_yn is null " . $lot_bifurcate_sb, array('N', 2, $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', SETTLEMENT_AP_TRANSFER_ID, 1))->row()->c;

        $counts['re_generate_premium_notice'] = $this->db->query('select count(distinct(sb.case_no)) as c from settlement_basic sb join settlement_premium sp on sb.case_no = sp.case_no join settlement_notice sn on sb.case_no = sn.case_no where sb.status = ? and sb.dist_code = ? and sb.subdiv_code = ? and sb.cir_code = ? and sb.from_office = ? and sb.pending_officer = ? and sb.service_code = ? and sp.is_final = ? and sp.grn_no is null and sn.notice_type=?' . $lot_bifurcate . '', array('N', $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', SETTLEMENT_AP_TRANSFER_ID, 1, 'PN'))->row()->c;

        $counts['remain_amt_prem_notice'] = $this->db->query('select count(distinct(sb.case_no)) as c from settlement_basic sb join settlement_premium sp on sb.case_no = sp.case_no where sb.status = ? and sb.dist_code = ? and sb.subdiv_code = ? and sb.cir_code = ? and sb.from_office = ? and sb.pending_officer = ? and sb.service_code = ? and sp.is_final = ? and sp.grn_no is not null and sp.due_amount > sp.paid_amount and sb.case_no NOT IN (SELECT DISTINCT(case_no) FROM settlement_notice WHERE case_no = sb.case_no AND notice_type = ?) ' . $lot_bifurcate . '', array('N', $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', SETTLEMENT_AP_TRANSFER_ID, 1, 'PNP1'))->row()->c;

        $counts['print_partial_notice'] = $this->db->query('select count(distinct(sb.case_no)) as c from settlement_basic sb join settlement_premium sp on sb.case_no = sp.case_no where sb.status = ? and sb.dist_code = ? and sb.subdiv_code = ? and sb.cir_code = ? and sb.from_office = ? and sb.pending_officer = ? and sb.service_code = ? and sp.is_final = ? and sp.grn_no is not null and sp.due_amount > sp.paid_amount and sb.case_no IN (SELECT DISTINCT(case_no) FROM settlement_notice WHERE case_no = sb.case_no AND notice_type = ?) ' . $lot_bifurcate . '', array('N', $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', SETTLEMENT_AP_TRANSFER_ID, 1, 'PNP1'))->row()->c;

        $counts['bulk_chitha_update_partial'] = $this->db->query("
        SELECT
            count(distinct(sb.case_no)) as C
            FROM settlement_basic sb
            JOIN
            (
                SELECT
                     sh.case_no
                 FROM
                     settlement_emi_history sh
                 JOIN
                     (
                         SELECT
                             case_no,
                             MAX(id) AS max_id
                         FROM
                             settlement_emi_history
                         GROUP BY
                             case_no
                         HAVING
                             COUNT(*) > 1
                     ) max_ids
                 ON
                     sh.case_no = max_ids.case_no
                 AND
                     sh.id = max_ids.max_id AND paid_no_of_installment != chitha_update_status
            ) AS seh
            ON sb.case_no = seh.case_no
            where sb.status = ?
            and sb.chitha_processing_details = ?
            and sb.dist_code = ?
            and sb.subdiv_code = ?
            and sb.cir_code = ?
            and sb.from_office = ?
            and sb.pending_officer = ?
            and sb.service_code = ?
            AND DATE_PART('day', now()::timestamp- sb.ppp_issue_date::timestamp)>15 AND DATE_PART('day', now()::timestamp- sb.ppp_issue_date::timestamp)>15 AND sb.order_passed is NOT NULL AND sb.co_chitha_corrected_yn is NOT NULL " . $lot_bifurcate_sb, array('N', 2, $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', SETTLEMENT_AP_TRANSFER_ID, 1))->row()->c;
        // added on 30/09/2023 starts here

        $curr_date = date('Y-m-d');
        $newDate2 = date('Y-m-d', strtotime($curr_date . ' - 2 days'));
        $newDate1 = date('Y-m-d', strtotime($curr_date . ' - 1 day'));

        $counts['notice_already_completed'] = $this->db->query("SELECT count(*) as count FROM settlement_basic WHERE service_code = '$service_code'
            AND pending_officer IN ('CO', 'SK') AND from_office != 'DC'
            AND status =  'W'
            AND dist_code =  '$dist_code'
            AND subdiv_code =  '$subdiv_code'
            AND cir_code =  '$cir_code'
            AND notice_generated_yn =  'Y'
            AND (date(notice_generated_date) + INTERVAL '30 days') <'$curr_date'")->row();

        $counts['to_be_completed_2days'] = $this->db->query("SELECT count(*) as count
            FROM settlement_basic
            WHERE service_code =  '$service_code'
            AND pending_officer IN ('CO', 'SK')
            AND from_office !='DC'
            AND status =  'W'
            AND dist_code =  '$dist_code'
            AND subdiv_code =  '$subdiv_code'
            AND cir_code =  '$cir_code'
            AND notice_generated_yn =  'Y'
            AND date(notice_generated_date) =  '$newDate2'")->row();

        $counts['to_be_completed_1day'] = $this->db->query("SELECT count(*) as count
            FROM settlement_basic
            WHERE service_code =  '$service_code'
            AND pending_officer IN ('CO', 'SK')
            AND from_office !='DC'
            AND status =  'W'
            AND dist_code =  '$dist_code'
            AND subdiv_code =  '$subdiv_code'
            AND cir_code =  '$cir_code'
            AND notice_generated_yn =  'Y'
            AND date(notice_generated_date) =  '$newDate1'")->row();

        // added on 30/09/2023 ends here

        $url = API_LINK_MB2 . "getAllApCasesCoWise/$dist_code/$subdiv_code/$cir_code";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $output = curl_exec($ch);
        curl_close($ch);
        if (trim($output) == '0') {
            $counts['apcoapicases'] = 0;
        } else {
            $dataapi = json_decode($output);
            $counts['apcoapicases'] = json_decode($dataapi->count);
        }

        $counts['_view'] = 'settlement_mb/settlement_mb_co';
        $this->load->view('layouts/main', $counts);
    }

    public function SettlementTribalCo()
    {
        $service_code = $this->input->get('service');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $lot_no = $this->session->userdata('lot_no');
        $user_code = $this->session->userdata('user_code');
        $year_no = year_no;
        $define_date = define_date;
        // $service_code=SETTLEMENT_AP_TRANSFER_ID;
        $this->dbswitch();
        //var_dump($this->session->all_userdata());
        $user_desig_code = $this->session->userdata('user_desig_code');
        if ($user_desig_code != 'CO' && $user_desig_code != 'SK') {
            $this->session->set_flashdata('message', "#HOMEC3503303 : Unauthorized access");
            redirect(base_url() . "index.php/home");
        }

        $counts['user_desig_code'] = $user_desig_code;

        if (LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO') {
            $lot_string = $this->caseListUnderMappingLot();
        }

        $lot_bifurcate = '';
        $lot_bifurcate_sb = '';

        if (LOT_BIFURCATE == 1) {
            if (isset($lot_string) && $lot_string != null) {
                $lot_bifurcate = "and mouza_pargona_code ||'_' || lot_no in ($lot_string)";
                $lot_bifurcate_sb = "and sb.mouza_pargona_code ||'_' || sb.lot_no in ($lot_string)";
            }
        }

        $counts['sk_first'] = $this->db->query("select count(*) as c from settlement_basic sb left join settlement_ap_lmnote sal on sb.case_no=sal.case_no where  sal.lm_note ='1' and  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and sb.status='W' and from_office='LM' and (pending_officer='SK' or pending_officer='CO') and service_code='$service_code'  and sb.date_entry >= '$define_date' ")->row()->c;

        $counts['re_report_lm_sk'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='X' and (from_office='LM' OR from_office='DC') and pending_officer='SK' and service_code='$service_code'  and date_entry >= '$define_date' ")->row()->c;

        // $counts['first'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='W' and (from_office='LM' OR from_office='SK') and (pending_officer='CO' OR pending_officer='SK')  and date_entry >= '$define_date' and service_code='$service_code' ")->row()->c;
        $counts['first'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='W' and from_office in ('LM','SK','CO','ADC','SDO') and (pending_officer='CO' or pending_officer='SK') and service_code='$service_code'   and date_entry >= '$define_date' $lot_bifurcate")->row()->c;
        // $counts['_view'] = 'settlement_mb/settlement_mb_co';
        $counts['re_report_lm'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='X' and (from_office='LM' OR from_office='SK' OR from_office='DC') and (pending_officer='CO' OR pending_officer='SK')  and date_entry >= '$define_date' and service_code='$service_code'  $lot_bifurcate")->row()->c;
        // $counts['reverted_by_dc'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='R' and from_office='DC' and pending_officer='CO'  and date_entry >= '$define_date' and service_code='$service_code' ")->row()->c;

        $counts['reverted_by_dc'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='R' and (from_office='DC' or from_office='ADC' or from_office='SDO') and pending_officer='CO' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['chitha'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='C' and from_office='DC' and pending_officer='CO'  and date_entry >= '$define_date' and service_code='$service_code'  $lot_bifurcate")->row()->c;

        $counts['payment_notice'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='M' and (from_office='DPT' or from_office='DC') and pending_officer='CO'  and date_entry >= '$define_date' and service_code='$service_code'  $lot_bifurcate")->row()->c;

        $counts['payment_confirm'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='N' and from_office='CO' and pending_officer='CO'  and date_entry >= '$define_date' and service_code='$service_code'  $lot_bifurcate")->row()->c;

        $counts['reverted_by_co'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='R' and from_office='CO'  and pending_officer='LM' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['forwarded_to_adc'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_officer not in('LM','SK','CO') and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['rejected_by_co'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_officer='CO' and status='D' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['revival_flag_list'] = $this->db->query("select count(*) as c from settlement_revival_flag where  req_by='CO' and  req_by = 'CO' and service_code='$service_code'  and (user_code='$user_code')")->row()->c;

        $counts['bulk_approve_lm_report'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='N' and from_office='CO' and pending_officer='CO' and service_code='$service_code' and chitha_processing_details = 1  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['bulk_chitha_update'] = $this->db->query("select count(distinct(sb.case_no)) as c from settlement_basic sb join settlement_premium sp on sb.case_no = sp.case_no where sb.status = ? and sb.chitha_processing_details = ? and sb.dist_code = ? and sb.subdiv_code = ? and sb.cir_code = ? and sb.from_office = ? and sb.pending_officer = ? and sb.service_code = ? and sp.is_final = ? and sp.grn_no is not null and DATE_PART('day', now()::timestamp- sb.ppp_issue_date::timestamp)>15 AND DATE_PART('day', now()::timestamp- sb.ppp_issue_date::timestamp)>15 AND sb.order_passed is null AND sb.co_chitha_corrected_yn is null " . $lot_bifurcate_sb, array('N', 2, $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', SETTLEMENT_TRIBAL_COMMUNITY_ID, 1))->row()->c;
        // var_dump($counts['bulk_chitha_update']); die;

        $counts['re_generate_premium_notice'] = $this->db->query('select count(distinct(sb.case_no)) as c from settlement_basic sb join settlement_premium sp on sb.case_no = sp.case_no join settlement_notice sn on sb.case_no = sn.case_no where sb.status = ? and sb.dist_code = ? and sb.subdiv_code = ? and sb.cir_code = ? and sb.from_office = ? and sb.pending_officer = ? and sb.service_code = ? and sp.is_final = ? and sp.grn_no is null and sn.notice_type=?' . $lot_bifurcate . '', array('N', $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', SETTLEMENT_TRIBAL_COMMUNITY_ID, 1, 'PN'))->row()->c;

        $counts['remain_amt_prem_notice'] = $this->db->query('select count(distinct(sb.case_no)) as c from settlement_basic sb join settlement_premium sp on sb.case_no = sp.case_no where sb.status = ? and sb.dist_code = ? and sb.subdiv_code = ? and sb.cir_code = ? and sb.from_office = ? and sb.pending_officer = ? and sb.service_code = ? and sp.is_final = ? and sp.grn_no is not null and sp.due_amount > sp.paid_amount and sb.case_no NOT IN (SELECT DISTINCT(case_no) FROM settlement_notice WHERE case_no = sb.case_no AND notice_type = ?) ' . $lot_bifurcate . '', array('N', $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', SETTLEMENT_TRIBAL_COMMUNITY_ID, 1, 'PNP1'))->row()->c;

        $counts['print_partial_notice'] = $this->db->query('select count(distinct(sb.case_no)) as c from settlement_basic sb join settlement_premium sp on sb.case_no = sp.case_no where sb.status = ? and sb.dist_code = ? and sb.subdiv_code = ? and sb.cir_code = ? and sb.from_office = ? and sb.pending_officer = ? and sb.service_code = ? and sp.is_final = ? and sp.grn_no is not null and sp.due_amount > sp.paid_amount and sb.case_no IN (SELECT DISTINCT(case_no) FROM settlement_notice WHERE case_no = sb.case_no AND notice_type = ?) ' . $lot_bifurcate . '', array('N', $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', SETTLEMENT_TRIBAL_COMMUNITY_ID, 1, 'PNP1'))->row()->c;

        $counts['bulk_chitha_update_partial'] = $this->db->query("
        SELECT
            count(distinct(sb.case_no)) as C
            FROM settlement_basic sb
            JOIN
            (
                SELECT
                     sh.case_no
                 FROM
                     settlement_emi_history sh
                 JOIN
                     (
                         SELECT
                             case_no,
                             MAX(id) AS max_id
                         FROM
                             settlement_emi_history
                         GROUP BY
                             case_no
                         HAVING
                             COUNT(*) > 1
                     ) max_ids
                 ON
                     sh.case_no = max_ids.case_no
                 AND
                     sh.id = max_ids.max_id AND paid_no_of_installment != chitha_update_status
            ) AS seh
            ON sb.case_no = seh.case_no
            where sb.status = ?
            and sb.chitha_processing_details = ?
            and sb.dist_code = ?
            and sb.subdiv_code = ?
            and sb.cir_code = ?
            and sb.from_office = ?
            and sb.pending_officer = ?
            and sb.service_code = ?
            AND DATE_PART('day', now()::timestamp- sb.ppp_issue_date::timestamp)>15 AND DATE_PART('day', now()::timestamp- sb.ppp_issue_date::timestamp)>15 AND sb.order_passed is NOT NULL AND sb.co_chitha_corrected_yn is NOT NULL " . $lot_bifurcate_sb, array('N', 2, $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', SETTLEMENT_TRIBAL_COMMUNITY_ID, 1))->row()->c;
        // echo $this->db->last_query(); die();
        // var_dump($counts['payment_notice']); die();
        $counts['service_code'] = $service_code;
        $counts['_view'] = 'settlement_mb/settlement_mb_co';
        $this->load->view('layouts/main', $counts);
    }

    ////PLB///////
    public function SettlementSpecialCulCo()
    {
        $service_code = $this->input->get('service');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $lot_no = $this->session->userdata('lot_no');
        $user_code = $this->session->userdata('user_code');
        $year_no = year_no;
        $define_date = define_date;
        $this->dbswitch();
        //var_dump($this->session->all_userdata());
        $user_desig_code = $this->session->userdata('user_desig_code');
        if ($user_desig_code != 'CO' && $user_desig_code != 'SK') {
            $this->session->set_flashdata('message', "#HOMEC4503303 : Unauthorized access");
            redirect(base_url() . "index.php/home");
        }
        $counts['user_desig_code'] = $user_desig_code;

        if (LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO') {
            $lot_string = $this->caseListUnderMappingLot();
        }

        $lot_bifurcate = '';
        $lot_bifurcate_sb = '';

        if (LOT_BIFURCATE == 1) {
            if (isset($lot_string) && $lot_string != null) {
                $lot_bifurcate = "and mouza_pargona_code ||'_' || lot_no in ($lot_string)";
                $lot_bifurcate_sb = "and sb.mouza_pargona_code ||'_' || sb.lot_no in ($lot_string)";
            }
        }
        // $counts['first'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='W' and (from_office='LM' OR from_office='SK') and (pending_officer='CO' OR pending_officer='SK') and service_code='$service_code'  and date_entry >= '$define_date' ")->row()->c;
        $counts['first'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='W' and from_office in ('LM','SK','CO','ADC','SDO') and (pending_officer='CO' or pending_officer='SK') and service_code='$service_code'   and date_entry >= '$define_date' $lot_bifurcate")->row()->c;

        // $counts['sk_first'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='W' and from_office='LM' and pending_officer='SK' and service_code='$service_code'  and date_entry >= '$define_date' ")->row()->c;
        $counts['sk_first'] = $this->db->query("select count(*) as c from settlement_basic sb left join settlement_ap_lmnote sal on sb.case_no=sal.case_no where  sal.lm_note ='1' and  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and sb.status='W' and from_office='LM' and (pending_officer='SK' or pending_officer='CO') and service_code='$service_code'  and sb.date_entry >= '$define_date' ")->row()->c;
        // $counts['_view'] = 'settlement_mb/settlement_mb_co';

        $counts['re_report_lm'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='X' and (from_office='LM' OR from_office='SK' OR from_office='DC' OR from_office='SK') and (pending_officer='CO' OR pending_officer='SK') and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['re_report_lm_sk'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='X' and (from_office='LM' OR from_office='DC') and pending_officer='SK' and service_code='$service_code'  and date_entry >= '$define_date' ")->row()->c;
        // $counts['reverted_by_dc'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='R' and from_office='DC' and pending_officer='CO' and service_code='$service_code'  and date_entry >= '$define_date' ")->row()->c;

        $counts['reverted_by_dc'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='R' and (from_office='DC' or from_office='ADC' or from_office='SDO') and pending_officer='CO' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['chitha'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='C' and from_office='DC' and pending_officer='CO' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['payment_notice'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='M' and (from_office='DPT' or from_office='DC') and pending_officer='CO' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['payment_confirm'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='N' and from_office='CO' and pending_officer='CO' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['reverted_by_co'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='R' and from_office='CO'  and pending_officer='LM' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['forwarded_to_adc'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_officer not in('LM','SK','CO') and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['rejected_by_co'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_officer='CO' and status='D' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['revival_flag_list'] = $this->db->query("select count(*) as c from settlement_revival_flag where  req_by='CO' and  req_by = 'CO' and service_code='$service_code'  and (user_code='$user_code')")->row()->c;

        $counts['bulk_approve_lm_report'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='N' and from_office='CO' and pending_officer='CO' and service_code='$service_code' and chitha_processing_details = 1  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['bulk_chitha_update'] = $this->db->query("select count(distinct(sb.case_no)) as c from settlement_basic sb join settlement_premium sp on sb.case_no = sp.case_no where sb.status = ? and sb.chitha_processing_details = ? and sb.dist_code = ? and sb.subdiv_code = ? and sb.cir_code = ? and sb.from_office = ? and sb.pending_officer = ? and sb.service_code = ? and sp.is_final = ? and sp.grn_no is not null and DATE_PART('day', now()::timestamp- sb.ppp_issue_date::timestamp)>15 AND DATE_PART('day', now()::timestamp- sb.ppp_issue_date::timestamp)>15 AND sb.order_passed is null AND sb.co_chitha_corrected_yn is null " . $lot_bifurcate_sb, array('N', 2, $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', SETTLEMENT_SPECIAL_CULTIVATORS_ID, 1))->row()->c;

        $counts['re_generate_premium_notice'] = $this->db->query('select count(distinct(sb.case_no)) as c from settlement_basic sb join settlement_premium sp on sb.case_no = sp.case_no join settlement_notice sn on sb.case_no = sn.case_no where sb.status = ? and sb.dist_code = ? and sb.subdiv_code = ? and sb.cir_code = ? and sb.from_office = ? and sb.pending_officer = ? and sb.service_code = ? and sp.is_final = ? and sp.grn_no is null and sn.notice_type=?' . $lot_bifurcate . '', array('N', $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', SETTLEMENT_SPECIAL_CULTIVATORS_ID, 1, 'PN'))->row()->c;

        $counts['remain_amt_prem_notice'] = $this->db->query('select count(distinct(sb.case_no)) as c from settlement_basic sb join settlement_premium sp on sb.case_no = sp.case_no where sb.status = ? and sb.dist_code = ? and sb.subdiv_code = ? and sb.cir_code = ? and sb.from_office = ? and sb.pending_officer = ? and sb.service_code = ? and sp.is_final = ? and sp.grn_no is not null and sp.due_amount > sp.paid_amount and sb.case_no NOT IN (SELECT DISTINCT(case_no) FROM settlement_notice WHERE case_no = sb.case_no AND notice_type = ?) ' . $lot_bifurcate . '', array('N', $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', SETTLEMENT_SPECIAL_CULTIVATORS_ID, 1, 'PNP1'))->row()->c;

        $counts['print_partial_notice'] = $this->db->query('select count(distinct(sb.case_no)) as c from settlement_basic sb join settlement_premium sp on sb.case_no = sp.case_no where sb.status = ? and sb.dist_code = ? and sb.subdiv_code = ? and sb.cir_code = ? and sb.from_office = ? and sb.pending_officer = ? and sb.service_code = ? and sp.is_final = ? and sp.grn_no is not null and sp.due_amount > sp.paid_amount and sb.case_no IN (SELECT DISTINCT(case_no) FROM settlement_notice WHERE case_no = sb.case_no AND notice_type = ?) ' . $lot_bifurcate . '', array('N', $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', SETTLEMENT_SPECIAL_CULTIVATORS_ID, 1, 'PNP1'))->row()->c;

        $counts['bulk_chitha_update_partial'] = $this->db->query("
        SELECT
            count(distinct(sb.case_no)) as C
            FROM settlement_basic sb
            JOIN
            (
                SELECT
                     sh.case_no
                 FROM
                     settlement_emi_history sh
                 JOIN
                     (
                         SELECT
                             case_no,
                             MAX(id) AS max_id
                         FROM
                             settlement_emi_history
                         GROUP BY
                             case_no
                         HAVING
                             COUNT(*) > 1
                     ) max_ids
                 ON
                     sh.case_no = max_ids.case_no
                 AND
                     sh.id = max_ids.max_id AND paid_no_of_installment != chitha_update_status
            ) AS seh
            ON sb.case_no = seh.case_no
            where sb.status = ?
            and sb.chitha_processing_details = ?
            and sb.dist_code = ?
            and sb.subdiv_code = ?
            and sb.cir_code = ?
            and sb.from_office = ?
            and sb.pending_officer = ?
            and sb.service_code = ?
            AND DATE_PART('day', now()::timestamp- sb.ppp_issue_date::timestamp)>15 AND DATE_PART('day', now()::timestamp- sb.ppp_issue_date::timestamp)>15 AND sb.order_passed is NOT NULL AND sb.co_chitha_corrected_yn is NOT NULL " . $lot_bifurcate_sb, array('N', 2, $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', SETTLEMENT_SPECIAL_CULTIVATORS_ID, 1))->row()->c;
        // echo $this->db->last_query(); die();
        // var_dump($counts['payment_notice']); die();
        $counts['service_code'] = $service_code;

        $counts['_view'] = 'settlement_mb/settlement_mb_co';
        $this->load->view('layouts/main', $counts);
    }

    public function SettlementVgrCo()
    {
        $service_code = $this->input->get('service');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $lot_no = $this->session->userdata('lot_no');
        $user_code = $this->session->userdata('user_code');
        $year_no = year_no;
        $define_date = define_date;
        $this->dbswitch();
        //var_dump($this->session->all_userdata());
        $user_desig_code = $this->session->userdata('user_desig_code');
        if ($user_desig_code != 'CO' && $user_desig_code != 'SK') {
            $this->session->set_flashdata('message', "#HOMEC5503303 : Unauthorized access");
            redirect(base_url() . "index.php/home");
        }

        $counts['user_desig_code'] = $user_desig_code;

        if (LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO') {
            $lot_string = $this->caseListUnderMappingLot();
        }

        $lot_bifurcate = '';
        $lot_bifurcate_sb = '';

        if (LOT_BIFURCATE == 1) {
            if (isset($lot_string) && $lot_string != null) {
                $lot_bifurcate = "and mouza_pargona_code ||'_' || lot_no in ($lot_string)";
                $lot_bifurcate_sb = "and sb.mouza_pargona_code ||'_' || sb.lot_no in ($lot_string)";
            }
        }

        $counts['sk_first'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='W' and from_office='LM' and pending_officer='SK' and service_code='$service_code'  and date_entry >= '$define_date' ")->row()->c;

        $counts['re_report_lm_sk'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='X' and (from_office='LM' OR from_office='DC') and pending_officer='SK' and service_code='$service_code'  and date_entry >= '$define_date' ")->row()->c;

        $counts['first'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='W' and from_office in ('LM','SK','CO','ADC','SDO') and (pending_officer='CO' OR pending_officer='SK') and service_code='$service_code'  and date_entry >= '$define_date' $lot_bifurcate")->row()->c;
        // $counts['_view'] = 'settlement_mb/settlement_mb_co';

        $counts['re_report_lm'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='X' and (from_office='LM' OR from_office='SK' OR from_office='DC') and (pending_officer='CO' OR pending_officer='SK') and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['clusters'] = $this->db->query("select COUNT(DISTINCT (dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code)) AS c from settlement_basic  where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and status = 'AA' and service_code = '$service_code' group by dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code")->row()->c;

        $counts['reverted_case_by_adc_for_vgr_reserv'] = $this->db->query("select count(*) AS c from settlement_basic  where pending_officer = 'CO' and status = 'AD'")->row()->c;
        // $counts['reverted_by_dc'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='R' and from_office='DC' and pending_officer='CO' and service_code='$service_code'  and date_entry >= '$define_date' ")->row()->c;

        $counts['reverted_by_dc'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='R' and (from_office='DC' or from_office='ADC' or from_office='SDO') and pending_officer='CO' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['bulk_approve_lm_report'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='N' and from_office='CO' and pending_officer='CO' and service_code='$service_code' and chitha_processing_details = 1  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        // $counts['reverted_by_dc'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='R' and from_office='DC' and pending_officer='CO' and service_code='$service_code'  and date_entry >= '$define_date' ")->row()->c;

        //*****handle reverted caess VGR */

        $revetedVgrSql = $this->db->query('select * from settlement_vgr_pgr_revert_cases where dist_code = ? and subdiv_code = ? and cir_code = ? and status = ? and to_office = ?', array($dist_code, $subdiv_code, $cir_code, 1, 'CO'));

        if ($revetedVgrSql->num_rows() <= 0) {
            $counts['vgr_meeting_reverted_count'] = 0;
        } else {
            $counts['vgr_meeting_reverted_count'] = $revetedVgrSql->num_rows();
        }

        $counts['chitha'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='C' and from_office='DC' and pending_officer='CO' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['payment_notice'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='M' and (from_office='DPT' or from_office='DC') and pending_officer='CO' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['payment_confirm'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='N' and from_office='CO' and pending_officer='CO' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['reverted_by_co'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='R' and from_office='CO'  and pending_officer='LM' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['forwarded_to_adc'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_officer not in('LM','SK','CO') and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['rejected_by_co'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_officer='CO' and status='D' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['re_report_by_lm_with_vgr_proposal'] = $this->db->query("select count(*) AS c from settlement_basic  where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and status = 'AC' and service_code = '$service_code'")->row()->c;

        $counts['revival_flag_list'] = $this->db->query("select count(*) as c from settlement_revival_flag where  req_by='CO' and  req_by = 'CO' and service_code='$service_code'  and (user_code='$user_code')")->row()->c;
        // echo $this->db->last_query(); die();
        // var_dump($counts['payment_notice']); die();
        $counts['service_code'] = $service_code;

        $counts['bulk_chitha_update'] = $this->db->query("select count(distinct(sb.case_no)) as c from settlement_basic sb join settlement_premium sp on sb.case_no = sp.case_no where sb.status = ? and sb.chitha_processing_details = ? and sb.dist_code = ? and sb.subdiv_code = ? and sb.cir_code = ? and sb.from_office = ? and sb.pending_officer = ? and sb.service_code = ? and sp.is_final = ? and sp.grn_no is not null and DATE_PART('day', now()::timestamp- sb.ppp_issue_date::timestamp)>15 AND DATE_PART('day', now()::timestamp- sb.ppp_issue_date::timestamp)>15 AND sb.order_passed is null AND sb.co_chitha_corrected_yn is null " . $lot_bifurcate_sb, array('N', 2, $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', SETTLEMENT_PGR_VGR_LAND_ID, 1))->row()->c;

        $counts['re_generate_premium_notice'] = $this->db->query('select count(distinct(sb.case_no)) as c from settlement_basic sb join settlement_premium sp on sb.case_no = sp.case_no join settlement_notice sn on sb.case_no = sn.case_no where sb.status = ? and sb.dist_code = ? and sb.subdiv_code = ? and sb.cir_code = ? and sb.from_office = ? and sb.pending_officer = ? and sb.service_code = ? and sp.is_final = ? and sp.grn_no is null and sn.notice_type=?' . $lot_bifurcate . '', array('N', $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', SETTLEMENT_PGR_VGR_LAND_ID, 1, 'PN'))->row()->c;

        $counts['remain_amt_prem_notice'] = $this->db->query('select count(distinct(sb.case_no)) as c from settlement_basic sb join settlement_premium sp on sb.case_no = sp.case_no where sb.status = ? and sb.dist_code = ? and sb.subdiv_code = ? and sb.cir_code = ? and sb.from_office = ? and sb.pending_officer = ? and sb.service_code = ? and sp.is_final = ? and sp.grn_no is not null and sp.due_amount > sp.paid_amount and sb.case_no NOT IN (SELECT DISTINCT(case_no) FROM settlement_notice WHERE case_no = sb.case_no AND notice_type = ?) ' . $lot_bifurcate . '', array('N', $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', SETTLEMENT_PGR_VGR_LAND_ID, 1, 'PNP1'))->row()->c;

        $counts['print_partial_notice'] = $this->db->query('select count(distinct(sb.case_no)) as c from settlement_basic sb join settlement_premium sp on sb.case_no = sp.case_no where sb.status = ? and sb.dist_code = ? and sb.subdiv_code = ? and sb.cir_code = ? and sb.from_office = ? and sb.pending_officer = ? and sb.service_code = ? and sp.is_final = ? and sp.grn_no is not null and sp.due_amount > sp.paid_amount and sb.case_no IN (SELECT DISTINCT(case_no) FROM settlement_notice WHERE case_no = sb.case_no AND notice_type = ?) ' . $lot_bifurcate . '', array('N', $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', SETTLEMENT_PGR_VGR_LAND_ID, 1, 'PNP1'))->row()->c;

        $counts['_view'] = 'settlement_mb/settlement_mb_co';
        $this->load->view('layouts/main', $counts);
    }

    public function SettlementVgrPgrLm()
    {
        $service_code = SETTLEMENT_PGR_VGR_LAND_ID;
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $user_code = $this->session->userdata('user_code');
        $year_no = year_no;
        $define_date = define_date;
        $this->dbswitch();
        //var_dump($this->session->all_userdata());
        $user_desig_code = $this->session->userdata('user_desig_code');
        $counts['reverted'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no ='$lot_no' and service_code='$service_code' and status='R' and from_office='CO' and pending_officer='LM'  and date_entry >= '$define_date' ")->row()->c;

        $counts['reservation_req'] = $this->db->query("select count(*) as c from settlement_vgr_lm_assign where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no = '$lot_no' and status='AB' and user_code = '$user_code' and date_entry >= '$define_date' ")->row()->c;

        $counts['notice_generated_count'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and service_code='$service_code' and status='N' and pending_officer='CO' and chitha_processing_details = 0  and date_entry >= '$define_date' ")->row()->c;

        $counts['reverted_review'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and service_code='$service_code' and status='RA' and from_office='CO' and pending_officer='LM'  and date_entry >= '$define_date' ")->row()->c;

        $counts['service_code'] = $service_code;
        $counts['_view'] = 'settlement_mb/settlement_mb_lm';
        $this->load->view('layouts/main', $counts);
    }

    public function SettlementTribalLm()
    {
        $service_code = SETTLEMENT_TRIBAL_COMMUNITY_ID;
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $user_code = $this->session->userdata('user_code');
        $year_no = year_no;
        $define_date = define_date;
        $this->dbswitch();
        //var_dump($this->session->all_userdata());
        $user_desig_code = $this->session->userdata('user_desig_code');
        $counts['reverted'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no = '$lot_no' and service_code='$service_code' and status='R' and from_office='CO' and pending_officer='LM'  and date_entry >= '$define_date' ")->row()->c;

        $counts['notice_generated_count'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and service_code='$service_code' and status='N' and pending_officer='CO' and chitha_processing_details = 0  and date_entry >= '$define_date' ")->row()->c;

        $counts['reverted_review'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and service_code='$service_code' and status='RA' and from_office='CO' and pending_officer='LM'  and date_entry >= '$define_date' ")->row()->c;

        $counts['service_code'] = $service_code;
        $counts['_view'] = 'settlement_mb/settlement_mb_lm';
        $this->load->view('layouts/main', $counts);
    }

    public function SettlementApLm()
    {
        $service_code = SETTLEMENT_AP_TRANSFER_ID;
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $user_code = $this->session->userdata('user_code');
        $year_no = year_no;
        $define_date = define_date;
        $this->dbswitch();
        //var_dump($this->session->all_userdata());
        $user_desig_code = $this->session->userdata('user_desig_code');
        $counts['reverted'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and service_code='$service_code' and status='R' and from_office='CO' and pending_officer='LM'  and date_entry >= '$define_date' ")->row()->c;

        $counts['nrcase'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and service_code='$service_code' and status='G' and (from_office='DPT' or from_office='DC') and pending_officer='LM'  and date_entry >= '$define_date' ")->row()->c;
        $counts['notice_generated'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and service_code='$service_code' and status='V' and from_office='CO' and pending_officer='LM'  and date_entry >= '$define_date' ")->row()->c;

        $counts['notice_generated_count'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and service_code='$service_code' and status='N' and pending_officer='CO' and chitha_processing_details = 0  and date_entry >= '$define_date' ")->row()->c;

        $counts['reverted_review'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and service_code='$service_code' and status='RA' and from_office='CO' and pending_officer='LM'  and date_entry >= '$define_date' ")->row()->c;

        $counts['service_code'] = $service_code;
        $counts['_view'] = 'settlement_mb/settlement_mb_lm';
        $this->load->view('layouts/main', $counts);
    }

    public function SettlementSpecialCulLm()
    {
        $service_code = SETTLEMENT_SPECIAL_CULTIVATORS_ID;
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $user_code = $this->session->userdata('user_code');
        $year_no = year_no;
        $define_date = define_date;
        $this->dbswitch();
        //var_dump($this->session->all_userdata());
        $user_desig_code = $this->session->userdata('user_desig_code');
        $counts['service_code'] = $service_code;
        $counts['reverted'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no = '$lot_no' and service_code='$service_code' and status='R' and from_office='CO' and pending_officer='LM'  and date_entry >= '$define_date' ")->row()->c;

        $counts['notice_generated_count'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and service_code='$service_code' and status='N' and pending_officer='CO' and chitha_processing_details = 0  and date_entry >= '$define_date' ")->row()->c;

        $counts['reverted_review'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and service_code='$service_code' and status='RA' and from_office='CO' and pending_officer='LM'  and date_entry >= '$define_date' ")->row()->c;

        $counts['_view'] = 'settlement_mb/settlement_mb_lm';
        $this->load->view('layouts/main', $counts);
    }

    public function SettlementTenantLmUrban()
    {
        $service_code = SETTLEMENT_TENANT_URBAN_ID;
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $user_code = $this->session->userdata('user_code');
        $year_no = year_no;
        $define_date = define_date;
        $this->dbswitch();
        //var_dump($this->session->all_userdata());
        $user_desig_code = $this->session->userdata('user_desig_code');
        
        $counts['forwarded_by_co'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no = '$lot_no' and service_code='$service_code' and status='Z' and from_office='CO' and pending_officer='LM'  and date_entry >= '$define_date' ")->row()->c;
        
        $counts['reverted'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no = '$lot_no' and service_code='$service_code' and status='R' and from_office='CO' and pending_officer='LM'  and date_entry >= '$define_date' ")->row()->c;

        $counts['notice_generated_count'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and service_code='$service_code' and status='N' and pending_officer='CO' and chitha_processing_details = 0  and date_entry >= '$define_date' ")->row()->c;

        $counts['reverted_review'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and service_code='$service_code' and status='RA' and from_office='CO' and pending_officer='LM'  and date_entry >= '$define_date' ")->row()->c;
        // echo $this->db->last_query(); die();
        $counts['service_code'] = $service_code;
        $counts['_view'] = 'settlement_mb/settlement_mb_lm';
        $this->load->view('layouts/main', $counts);
    }

    public function TenantUrbanCoLanding(){
        $service_code = $this->input->get('service');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $lot_no = $this->session->userdata('lot_no');
        $user_code = $this->session->userdata('user_code');
        $year_no = year_no;
        $define_date = define_date;
        $this->dbswitch();
        $user_desig_code = $this->session->userdata('user_desig_code');
        if ($user_desig_code != 'CO' && $user_desig_code != 'SK') {
            $this->session->set_flashdata('message', "#HOMEC0503303 : Unauthorized access");
            redirect(base_url() . "index.php/home");
        }
        $counts['user_desig_code'] = $user_desig_code;

        if (LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO') {
            $lot_string = $this->caseListUnderMappingLot();
        }

        $lot_bifurcate = '';
        $lot_bifurcate_sb = '';

        if (LOT_BIFURCATE == 1) {
            if (isset($lot_string) && $lot_string != null) {
                $lot_bifurcate = "and mouza_pargona_code ||'_' || lot_no in ($lot_string)";
            }
        }

        $url = API_LINK_MB3."tenantUrbanCoLandingCount/$dist_code/$subdiv_code/$cir_code" ;
        $ch  = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);

        $counts['new_reg_count'] = $output[0]->count;


        $data['pendingcount'] = $this->db->query("select count(*) as c from  settlement_basic where service_code = '$service_code' and pending_office = 'CO' and dist_code ='$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'")->row()->c;
        $user_desig_code = $this->session->userdata('user_desig_code');

        // $counts['first'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='W' and (from_office='LM' OR from_office='SK') and (pending_officer='CO' OR pending_officer='SK') and service_code='$service_code'  and date_entry >= '$define_date' ")->row()->c;
        $counts['first'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='W' and from_office in ('LM','SK','CO','ADC','SDO') and (pending_officer='CO' or pending_officer='SK') and service_code='$service_code'   and date_entry >= '$define_date' $lot_bifurcate")->row()->c;

        // $counts['sk_first'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='W' and from_office='LM' and pending_officer='SK' and service_code='$service_code'  and date_entry >= '$define_date' ")->row()->c;
        $counts['sk_first'] = $this->db->query("select count(*) as c from settlement_basic sb left join settlement_ap_lmnote sal on sb.case_no=sal.case_no where  sal.lm_note ='1' and  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and sb.status='W' and from_office='LM' and (pending_officer='SK' or pending_officer='CO') and service_code='$service_code'  and sb.date_entry >= '$define_date' ")->row()->c;
        // $counts['_view'] = 'settlement_mb/settlement_mb_co';
        $counts['re_report_lm'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='X' and (from_office='LM' OR from_office='SK' OR from_office='DC') and (pending_officer='CO' OR pending_officer='SK') and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['re_report_lm_co'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='X' and (from_office='LM' OR from_office='SK') and (pending_officer='CO' OR pending_officer='SK') and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['re_report_lm_sk'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='X' and (from_office='LM' OR from_office='DC') and pending_officer='SK' and service_code='$service_code'  and date_entry >= '$define_date' ")->row()->c;
        // $counts['reverted_by_dc'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='R' and from_office='DC' and pending_officer='CO' and service_code='$service_code'  and date_entry >= '$define_date' ")->row()->c;
        $counts['reverted_by_dc'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='R' and (from_office='DC' or from_office='ADC' or from_office='SDO') and pending_officer='CO' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['chitha'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='C' and from_office='DC' and pending_officer='CO'  and service_code='$service_code'  and date_entry >= '$define_date' ")->row()->c;

        $counts['payment_notice'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='M' and (from_office='DPT' or from_office='DC') and pending_officer='CO' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['payment_confirm'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='N' and from_office='CO' and pending_officer='CO' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['reverted_by_co'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='R' and from_office='CO'  and pending_officer='LM' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['forwarded_to_adc'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_officer not in('LM','SK','CO') and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['rejected_by_co'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_officer='CO' and status='D' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['revival_flag_list'] = $this->db->query("select count(*) as c from settlement_revival_flag where  req_by='CO' and  req_by = 'CO' and service_code='$service_code'  and (user_code='$user_code')")->row()->c;

        $counts['bulk_chitha_update'] = $this->db->query("select count(distinct(sb.case_no)) as c from settlement_basic sb join settlement_premium sp on sb.case_no = sp.case_no where sb.status = ? and sb.dist_code = ? and sb.subdiv_code = ? and sb.cir_code = ? and sb.from_office in ('CO', 'DC') and sb.pending_officer in ('CO') and sb.service_code = ? and sp.is_final = ? and sp.grn_no is not null AND sb.order_passed is null AND sb.co_chitha_corrected_yn is null " . $lot_bifurcate_sb, array('VN', $dist_code, $subdiv_code, $cir_code, SETTLEMENT_TENANT_URBAN_ID, 1))->row()->c;
        // echo $this->db->last_query(); die();
        // var_dump($counts['payment_notice']); die();
        $counts['service_code'] = $service_code;
        // $counts['_view'] = 'SettlementView/Co/Tenant/SettlementTenantCoMenuView';
        $counts['_view'] = 'SettlementView/Co/Tenant/tenant_co_urban_menu';
        $this->load->view('layouts/main', $counts);
    }

    //// settlement addition end ////

    ///sdo dashboard ////
    public function sdoHome()
    {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $cir_code = '00';
        $mouza_pargona_code = '00';
        $lot_no = '00';
        // $cir_code = $this->session->userdata('cir_code');
        // $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        // $lot_no = $this->session->userdata('lot_no');
        // $user_desig_code = $this->session->userdata('user_desig_code');
        // $define_date = define_date;
        $sql = "Select count(case_no),service_code,CASE
                WHEN (service_code = '13') THEN 'SETTLEMENT TENANT'
                WHEN (service_code = '14') THEN 'SETTLEMENT AP TRANSFER'
                WHEN (service_code = '15') THEN 'SETTLEMENT TRIBAL COMMUNITY'
                WHEN (service_code = '16') THEN 'SETTLEMENT KHAS LAND'
                WHEN (service_code = '17') THEN 'SETTLEMENT PGR VGR LAND'
                WHEN (service_code = '18') THEN 'SETTLEMENT SPECIAL CULTIVATORS'
              END AS service from settlement_basic where dist_code ='$dist_code' and subdiv_code='$subdiv_code' and status='W' and pending_officer='SDO' group by service_code";
        $data['servicecount'] = $this->db->query($sql)->result_array();

        ///******INTEGRATION OF PROFILE UPDATE CHECK***********///
        $user_details_array = array(
            'user_code' => $this->session->userdata('user_code'),
            'user_desig_code' => $user_desig_code,
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
        );
        $data['profile_update_flag'] = $this->profile_upload_check($user_details_array);

        $data['_view'] = 'home/sdo';
        $this->load->view('layouts/main', $data);
    }

    ///sdo dashboard end///

    ///sdo dashboard end///
    public function lmTransferConfirmation()
    {
        $errors = [];
        $data = [];
        $users = $this->lm_name_confirm();
        $data['success'] = false;
        if ($users == 'NO_USER_FOUND') {
            $errors['confirm'] = 'User Not found';
        }
        if (empty($_POST)) {
            $errors['confirm'] = 'Select YES/NO is required.';
        }
        if (empty($_POST['confirmation'])) {
            $errors['confirm'] = 'Select YES/NO is required.';

        }
        if ($_POST['confirmation'] == 'no' && empty($_POST['reason_y_n'])) {
            $errors['reason_y_n'] = 'Select one option is required.';

        }
        if ($_POST['confirmation'] == 'no' && ($_POST['reason_y_n'] == '1') && empty($_POST['date_of_super'])) {
            $errors['date_of_super'] = 'Date of suppernation is required.';
        }
        if (empty($_POST['reason_any']) && $_POST['confirmation'] == 'no' && $_POST['reason_y_n'] == '3') {
            $errors['reason_any'] = 'Please Type Remark(s)';
        }
        if ($_POST['date_of_super']) {
            $date_of_suppernation = date('Y-m-d', strtotime($_POST['date_of_super']));
            $date_of_end = date('Y-m-d', strtotime(lm_state_cadre_date));
            //$days=($date_of_suppernation - $date_of_end)/60/60/24;
            $diff = date_diff(date_create($date_of_end), date_create($date_of_suppernation));
            //log_message('error',json_encode($diff.$date_of_end.$date_of_suppernation));
            if ($diff->days < 1095) {
                $errors['date_of_super'] = 'You are not eligible. It might be more than three years';
            }
        }
        if (!empty($errors)) {
            $data['success'] = false;
            $data['errors'] = $errors;
            echo json_encode($data);
            return;
        } else {
            $params = [
                'dist_code' => $this->session->userdata('dist_code'),
                'subdiv_code' => $this->session->userdata('subdiv_code'),
                'cir_code' => $this->session->userdata('cir_code'),
                'mouza_pargona_code' => $this->session->userdata('mouza_pargona_code'),
                'lot_no' => $this->session->userdata('lot_no'),
                'name' => $users,
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d'),
                'confirm_y_n' => $_POST['confirmation'],
                'reason_y_n' => $_POST['reason_y_n'] == null ? 'NA' : $_POST['reason_y_n'],
                'reason_any' => $_POST['reason_any'] == null ? 'NA' : $_POST['reason_any'],
                'date_of_retirement' => $_POST['date_of_super'] == null ? '1970-01-01' : date('Y-m-d', strtotime($_POST['date_of_super'])),
            ];
            $numRows = $this->lmStateCadre();
            if ($numRows == 0) {
                $this->db->insert('lm_state_cadre_y_n', $params);
                //log_message('error',json_encode($_POST));
                //log_message('error',$this->db->last_query());
            } else {
                $data['success'] = false;
                $errors['reason_any'] = 'Already Updated Your Record';
                $data['errors'] = $errors;
                echo json_encode($data);
                return;
            }
            if ($this->db->affected_rows() == 1) {
                $data['success'] = true;
            } else {
                $data['success'] = false;
                $errors['reason_any'] = 'Failed in Insertion';
                $data['errors'] = $errors;
            }
        }
        echo json_encode($data);
        return;
    }
    public function lm_name_confirm()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        if ($user_desig_code == 'LM') {
            $name = "select lm_name from lm_code where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=?
            and lm_code=? ";
            $data = $this->db->query($name, array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $user_code));
        } else {
            $name = "select username as lm_name from users where dist_code=? and subdiv_code=? and cir_code=?
            and user_code=? ";
            $data = $this->db->query($name, array($dist_code, $subdiv_code, $cir_code, $user_code));
        }
        //log_message('error',$this->db->last_query());
        if ($data->num_rows() == 1) {
            $lm_name_confirm = $data->row()->lm_name;
            return $lm_name_confirm;
        } else {
            return 'NO_USER_FOUND';
        }
    }
    public function lmStateCadre()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $user_code = $this->session->userdata('user_code');
        $name = "select id from lm_state_cadre_y_n where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=?
        and user_code=? ";
        $data = $this->db->query($name, array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $user_code));
        //log_message('error',$this->db->last_query());
        if ($data->num_rows() == 1) {
            return $data->num_rows();
        } else {
            return 0;
        }
    }
    public function date_valid($date)
    {
        if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $date)) {
            return false;
        }

        $day = (int) substr($date, 8, 2);
        $month = (int) substr($date, 5, 2);
        $year = (int) substr($date, 0, 4);
        return checkdate($month, $day, $year);
    }

    public function SettlementApAst()
    {
        $service_code = $this->input->get('service');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $lot_no = $this->session->userdata('lot_no');
        $user_code = $this->session->userdata('user_code');
        $year_no = year_no;
        $define_date = define_date;
        // $service_code=SETTLEMENT_AP_TRANSFER_ID;
        $this->dbswitch();
        //var_dump($this->session->all_userdata());
        $user_desig_code = $this->session->userdata('user_desig_code');
        if ($user_desig_code != 'AST') {
            $this->session->set_flashdata('message', "#HOMEC250773 : Unauthorized access");
            redirect(base_url() . "index.php/home");
        }
        $counts['user_desig_code'] = $user_desig_code;

        $counts['apconotice'] = $this->db->query("select count(*) as c from settlement_basic where status !='D' and ast_notice_print_yn is null and notice_generated_yn='Y' and  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (pending_officer='CO' OR pending_officer='LM')  and date_entry >= '$define_date' and service_code='$service_code' ")->row()->c;
        $counts['apconotice_generated'] = $this->db->query("select count(*) as c from settlement_basic where status !='D' and ast_notice_print_yn='Y' and notice_generated_yn='Y' and  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (pending_officer='CO' OR pending_officer='LM')  and date_entry >= '$define_date' and service_code='$service_code' ")->row()->c;
        $counts['ppp'] = $this->db->query("select count(distinct(a.case_no)) as c from settlement_basic a join settlement_premium b on a.case_no=b.case_no where a.status ='N' and a.chitha_processing_details=2 and b.grn_no is not null and b.is_final=1 and  a.dist_code='$dist_code' and a.subdiv_code='$subdiv_code' and a.cir_code='$cir_code' and a.pending_officer='CO'  and a.date_entry >= '$define_date' and a.service_code='$service_code' ")->row()->c;

        $counts['service_code'] = $service_code;

        $counts['_view'] = 'settlement_mb/settlement_mb_ast';
        $this->load->view('layouts/main', $counts);
    }

    public function profile_upload_check($user_details_array)
    {

        $user_code = $user_details_array['user_code'];
        $dist_code = $user_details_array['dist_code'];
        $subdiv_code = $user_details_array['subdiv_code'];
        $cir_code = $user_details_array['cir_code'];
        $mouza_pargona_code = $user_details_array['mouza_pargona_code'];
        $lot_no = $user_details_array['lot_no'];
        // $user_details_array['flag'] = 0;

        $sql = "select * from loginuser_table where user_code=? and dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code = ? and lot_no = ?";
        $row = $this->db->query($sql, array($user_code, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no))->row();
        // log_message('error','-----------user_details_query---'.$this->db->last_query());
        if (!empty($row)) {
            $date_of_last_password_changed = $row->date_password_changed;
            if (strtotime($date_of_last_password_changed) < strtotime('-60 days')) {
                $user_details_array['flag'] = 0;
            } else if ($row->first_login == 'Y') {
                $user_details_array['flag'] = 0;
            }
        }
        if (DHARLOGIN_PASSWORD_UPDATE_FIRST == 1) {
            return $user_details_array;
        } else {
            $user_details_array['flag'] = 1;
            return $user_details_array;
        }

    }


       function NameCorrectionAdc(){

        $allowed = ['ADC'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }


        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = '00';
        $cir_code = '00';
        $mouza_pargona_code = '00';
        $lot_no = '00';
        
        $year_no = year_no;
        $define_date = define_date;

        //************INTEGRATE CIRCLE MAPPING***************
        $circle_bifurcate = ''; 
        if(CIRCLE_BIRFURCATE_ADC == 1 && $this->session->userdata('user_desig_code') == 'ADC')
        {
            $circle_bifurcate = $this->circleMappingModel->caseListUnderMappingCircleOfADC();
        }
        //************END************************************




       $counts['namecorrect_adc'] = $this->db->query("SELECT count(*) as c from   misc_case_basic WHERE status = 'A' and es_flag='1'")->row()->c;

        $counts['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
                        . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
                        . "loginuser_table.date_password_changed AS date_password_changed from     users INNER JOIN loginuser_table ON "
                        . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
                        . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
                        . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
                        . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
                        . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();

        $date_of_last_password_changed = $counts['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }

        if(ESCALATION_ENABLE == 1){
            $service_code = 8; //for NCAN=====
            $service_code_ncor = 6; //for NCOR=====
            $counts['service_type']    = MIND_SERV;
            // $data['service_type']    = NCAN_SERV;
            $counts['escAllocateDays'] = $this->Escalationmodel->getTimeLine($service_code, 'NCAN');
            $counts['escAllocateDaysNCOR'] = $this->Escalationmodel->getTimeLine($service_code_ncor, 'NCOR');

            // var_dump($data['escAllocateDaysNCOR']); die;
            $counts['countMiscCaseEscalation'] = $this->NameCorrectionModelV2->getMiscCaseLMforEscalationCO($dist_code, $subdiv_code, $cir_code);
        }

        $counts['_view'] = 'home/namecorrect_adc';
        $this->load->view('layouts/main',$counts);
    }

    function TnHome(){
        $data['_view'] = 'home/tnBranch';
        $this->load->view('layouts/main',$data);
    }


    // Tea Grant Starts here =======================================
    public function TeaGrantLandLm()
    {
      $service_code       = TEA_SERVICE_CODE;
      $dist_code          = $this->session->userdata('dist_code');
      $subdiv_code        = $this->session->userdata('subdiv_code');
      $cir_code           = $this->session->userdata('cir_code');
      $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
      $lot_no             = $this->session->userdata('lot_no');
      $user_code          = $this->session->userdata('user_code');
      $year_no            = year_no;
      $define_date        = define_date;
      $this->dbswitch();

      $user_desig_code    = $this->session->userdata('user_desig_code');
      
      $counts['reverted'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and service_code='$service_code' and status='R' and from_office='CO' and pending_officer='LM'  and date_entry >= '$define_date' ")->row()->c;

      $counts['notice_generated_count'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and service_code='$service_code' and status='N' and pending_officer='CO' and chitha_processing_details = 0  and date_entry >= '$define_date' ")->row()->c;

      $counts['reverted_review'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and service_code='$service_code' and status='RA' and from_office='CO' and pending_officer='LM'  and date_entry >= '$define_date' ")->row()->c;

      $counts['forwarded_by_co'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and service_code='$service_code' and status='Z' and from_office='CO' and pending_officer='LM'  and date_entry >= '$define_date' ")->row()->c;

      $counts['forwarded_by_co'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and service_code='$service_code' and status='Z' and from_office='CO' and pending_officer='LM'  and date_entry >= '$define_date' ")->row()->c;

      $counts['final_verify_after_pn'] = $this->db->query("SELECT distinct(sb.case_no), sb.service_code, sb.applid, 
            sb.dist_code, sb.subdiv_code, sb.cir_code, sb.mouza_pargona_code, sb.lot_no, sb.vill_townprt_code, sb.date_entry, 
            slm.lm_note, sb.chitha_processing_details, sb.submission_date 
            FROM settlement_basic sb 
            JOIN settlement_premium sp ON sb.case_no = sp.case_no 
            JOIN settlement_ap_lmnote slm ON sb.case_no = slm.case_no
            WHERE sb.dist_code=? AND sb.subdiv_code=? AND sb.cir_code=? AND sb.mouza_pargona_code=? AND sb.lot_no=?
            AND sb.service_code=? AND sb.pending_officer=? AND sb.status=? AND sb.dc_code IS NOT NULL AND 
            sb.pay_notice_gen_yn=? AND 
            EXISTS (SELECT 1 FROM settlement_notice sn2 WHERE sn2.case_no = sb.case_no AND sn2.notice_type=?)",
            [$dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, '43', 'ADC', 'N', 'Y', 'PN'])->num_rows();

      $counts['service_code'] = $service_code;
      $counts['_view']        = 'TeaGrant/LM/ProcessTeaGrantLM';
      $this->load->view('layouts/main', $counts);
    }

    public function TeaGrantLandCo()
    {
      $service_code = $this->input->get('service');
      $dist_code    = $this->session->userdata('dist_code');
      $subdiv_code  = $this->session->userdata('subdiv_code');
      $cir_code     = $this->session->userdata('cir_code');
      $lot_no       = $this->session->userdata('lot_no');
      $user_code    = $this->session->userdata('user_code');
      $year_no      = year_no;
      $define_date  = define_date;
      $this->dbswitch();
      // var_dump($this->session->all_userdata()); die;
      $user_desig_code = $this->session->userdata('user_desig_code');
      if ($user_desig_code != 'CO' && $user_desig_code != 'SK') {
        $this->session->set_flashdata('message', "#HOMEC1503303 : Unauthorized access");
        redirect(base_url() . "index.php/home");
      }

      $counts['user_desig_code'] = $user_desig_code;

      if (LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO') {
        $lot_string = $this->caseListUnderMappingLot();
      }

      $lot_bifurcate = '';
      $lot_bifurcate_sb = '';

      if (LOT_BIFURCATE == 1) {
        if (isset($lot_string) && $lot_string != null) {
          $lot_bifurcate = "and mouza_pargona_code ||'_' || lot_no in ($lot_string)";
          $lot_bifurcate_sb = "and sb.mouza_pargona_code ||'_' || sb.lot_no in ($lot_string)";
        }
      }

      $counts['transfer_tgtpp_to_inst'] = $this->db->query("SELECT count(*) AS c FROM settlement_basic WHERE dist_code=? 
                                            AND subdiv_code=? AND cir_code=? AND pending_office=? AND service_code=? 
                                              AND tgtpp_ins IS NULL", [$dist_code, $subdiv_code, $cir_code, 'CO', '43'])->row()->c;

      $counts['reverted_to_co_from_dc'] = $this->db->query("select count(*) as c from settlement_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='R' and from_office in ('ADC', 'DC', 'DPT') and pending_office='CO'
            and service_code='$service_code'")->row()->c;

      $counts['sk_first'] = $this->db->query("select count(*) as c from settlement_basic left join settlement_ap_lmnote on settlement_basic.case_no=settlement_ap_lmnote.case_no where  lm_note ='1' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and settlement_basic.status='W' and from_office='LM' and (pending_officer='SK' OR pending_officer='CO') and service_code='$service_code'  and settlement_basic.date_entry >= '$define_date' ")->row()->c;

      $counts['re_report_lm_sk'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='X' and (from_office='LM' OR from_office='DC') and pending_officer='SK' and service_code='$service_code'  and date_entry >= '$define_date' ")->row()->c;

      $counts['first'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='W' and from_office in ('LM','SK','CO','ADC','SDO') and (pending_officer='CO' or pending_officer='SK') and service_code='$service_code'   and date_entry >= '$define_date' $lot_bifurcate")->row()->c;

      $counts['re_report_lm'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='X' and (from_office='LM' OR from_office='SK' OR from_office='DC') and (pending_officer='CO' or pending_officer='SK') and service_code='$service_code'  and date_entry >= '$define_date' $lot_bifurcate")->row()->c;

      $counts['reverted_by_dc'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='R' and (from_office='DC' or from_office='ADC' or from_office='SDO') and pending_officer='CO'  and service_code='$service_code'  and date_entry >= '$define_date' $lot_bifurcate")->row()->c;

      $counts['chitha'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='C' and from_office='DC' and pending_officer='CO' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

      $counts['payment_notice'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='M' and (from_office='DPT' or from_office='DC') and pending_officer='CO' and service_code='$service_code' and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

      $counts['payment_confirm'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='N' and from_office='CO' and pending_officer='CO' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

      $counts['reverted_by_co'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='R' and from_office='CO'  and pending_officer='LM' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

      $counts['forwarded_to_adc'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_officer not in('LM','SK','CO') and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

      $counts['rejected_by_co'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_officer='CO' and status='D' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

      $counts['revival_flag_list'] = $this->db->query("select count(*) as c from settlement_revival_flag where  req_by='CO' and  req_by = 'CO' and service_code='$service_code'  and (user_code='$user_code')")->row()->c;

      $counts['bulk_approve_lm_report'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='N' and from_office='CO' and pending_officer='CO' and service_code='$service_code' and chitha_processing_details = 1  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

      $counts['bulk_chitha_update'] = $this->db->query("select count(distinct(sb.case_no)) as c from settlement_basic sb join settlement_premium sp on sb.case_no = sp.case_no where sb.status = ? and sb.chitha_processing_details = ? and sb.dist_code = ? and sb.subdiv_code = ? and sb.cir_code = ? and sb.from_office = ? and sb.pending_officer = ? and sb.service_code = ? and sp.is_final = ? and sp.grn_no is not null and DATE_PART('day', now()::timestamp- sb.ppp_issue_date::timestamp)>15 AND DATE_PART('day', now()::timestamp- sb.ppp_issue_date::timestamp)>15 AND sb.order_passed is null AND sb.co_chitha_corrected_yn is null " . $lot_bifurcate_sb, array('N', 2, $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', TEA_SERVICE_CODE, 1))->row()->c;

      $counts['bulk_chitha_update_partial'] = $this->db->query("
        SELECT
          count(distinct(sb.case_no)) as C
          FROM settlement_basic sb
          JOIN
          (
              SELECT
                   sh.case_no
               FROM
                   settlement_emi_history sh
               JOIN
                   (
                       SELECT
                           case_no,
                           MAX(id) AS max_id
                       FROM
                           settlement_emi_history
                       GROUP BY
                           case_no
                       HAVING
                           COUNT(*) > 1
                   ) max_ids
               ON
                   sh.case_no = max_ids.case_no
               AND
                   sh.id = max_ids.max_id AND paid_no_of_installment != chitha_update_status
          ) AS seh
          ON sb.case_no = seh.case_no
          where sb.status = ?
          and sb.chitha_processing_details = ?
          and sb.dist_code = ?
          and sb.subdiv_code = ?
          and sb.cir_code = ?
          and sb.from_office = ?
          and sb.pending_officer = ?
          and sb.service_code = ?
          AND DATE_PART('day', now()::timestamp- sb.ppp_issue_date::timestamp)>15 AND DATE_PART('day', now()::timestamp- sb.ppp_issue_date::timestamp)>15 AND sb.order_passed is NOT NULL AND sb.co_chitha_corrected_yn is NOT NULL " . $lot_bifurcate_sb, array('N', 2, $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', TEA_SERVICE_CODE))->row()->c;

      $counts['re_generate_premium_notice'] = $this->db->query('select count(distinct(sb.case_no)) as c from settlement_basic sb join settlement_premium sp on sb.case_no = sp.case_no join settlement_notice sn on sb.case_no = sn.case_no where sb.status = ? and sb.dist_code = ? and sb.subdiv_code = ? and sb.cir_code = ? and sb.from_office = ? and sb.pending_officer = ? and sb.service_code = ? and sp.is_final = ? and sp.grn_no is null and sn.notice_type=?' . $lot_bifurcate . '', array('N', $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', TEA_SERVICE_CODE, 1, 'PN'))->row()->c;

      $counts['remain_amt_prem_notice'] = $this->db->query('select count(distinct(sb.case_no)) as c from settlement_basic sb join settlement_premium sp on sb.case_no = sp.case_no where sb.status = ? and sb.dist_code = ? and sb.subdiv_code = ? and sb.cir_code = ? and sb.from_office = ? and sb.pending_officer = ? and sb.service_code = ? and sp.is_final = ? and sp.grn_no is not null and sp.due_amount > sp.paid_amount and sb.case_no NOT IN (SELECT DISTINCT(case_no) FROM settlement_notice WHERE case_no = sb.case_no AND notice_type = ?) ' . $lot_bifurcate . '', array('N', $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', TEA_SERVICE_CODE, 1, 'PNP1'))->row()->c;

      $counts['print_partial_notice'] = $this->db->query('select count(distinct(sb.case_no)) as c from settlement_basic sb join settlement_premium sp on sb.case_no = sp.case_no where sb.status = ? and sb.dist_code = ? and sb.subdiv_code = ? and sb.cir_code = ? and sb.from_office = ? and sb.pending_officer = ? and sb.service_code = ? and sp.is_final = ? and sp.grn_no is not null and sp.due_amount > sp.paid_amount and sb.case_no IN (SELECT DISTINCT(case_no) FROM settlement_notice WHERE case_no = sb.case_no AND notice_type = ?) ' . $lot_bifurcate . '', array('N', $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', TEA_SERVICE_CODE, 1, 'PNP1'))->row()->c;

      $counts['re_report_lm'] = $this->db->query("SELECT count(*) as c FROM settlement_basic 
                                    WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND status=? AND lm_code is not null", array($dist_code, $subdiv_code, $cir_code, MB_RE_REPORT))->row()->c;  

      $counts['report_from_sro'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='W' and from_office='CO' and pending_officer='SRO' and service_code='$service_code'  and date_entry >= '$define_date' $lot_bifurcate")->row()->c;

      // $counts['pending_for_chitha_update'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='N' and from_office='DC' and pending_officer='CO' and service_code='$service_code'  and date_entry >= '$define_date' $lot_bifurcate and notice_generated_yn='y' AND pay_notice_gen_yn='Y' and general_notice_dc='y' and dc_proceeding=1")->row()->c;


      $counts['pending_for_chitha_update'] = $this->db->query(" SELECT COUNT(*) AS c FROM settlement_basic sb JOIN settlement_premium sp ON sp.case_no = sb.case_no WHERE sb.dist_code = ? AND sb.subdiv_code = ? AND sb.cir_code = ? AND sb.status = ? AND sb.pending_officer = ? AND sb.service_code = ? AND sb.date_entry >= ? AND sb.notice_generated_yn = ? AND sb.pay_notice_gen_yn = ? AND sb.general_notice_dc = ? AND sb.dc_proceeding = ? AND sb.chitha_processing_details = ? AND sp.is_final = ? AND sp.grn_no IS NOT NULL AND sb.order_passed IS NULL AND sb.co_chitha_corrected_yn IS NULL", [ $dist_code, $subdiv_code, $cir_code, MB_PAYMENT_NOTICE, 'CO', TEA_SERVICE_CODE, define_date, 'y', 'Y', 'y', 1, 2, 1 ] )->row()->c;


      $counts['bulk_chitha_update'] = $this->db->query("select count(distinct(sb.case_no)) as c from settlement_basic sb join settlement_premium sp on sb.case_no = sp.case_no where sb.status = ? and sb.chitha_processing_details = ? and sb.dist_code = ? and sb.subdiv_code = ? and sb.cir_code = ? and sb.from_office = ? and sb.pending_officer = ? and sb.service_code = ? and sp.is_final = ? and sp.grn_no is not null and DATE_PART('day', now()::timestamp- sb.ppp_issue_date::timestamp)>15 AND DATE_PART('day', now()::timestamp- sb.ppp_issue_date::timestamp)>15 AND sb.order_passed is null AND sb.co_chitha_corrected_yn is null " . $lot_bifurcate_sb, array('N', 2, $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', TEA_SERVICE_CODE, 1))->row()->c;

      $counts['service_code'] = $service_code;
      $counts['_view']        = 'TeaGrant/CO/TeaGrantCO';

      $this->load->view('layouts/main', $counts);
    }
    // Tea Grant Ends here   =======================================


    //newly added for MB3 Conversion by Hridayjit (05-11-2024)
    public function Mb3ConversionCo()
    {
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page',
        );

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';

        

        $data['map_partition'] = $this->db->query("Select count(*) as c from  t_chitha_col8_order where map_partition!=null and "
            . " order_type_code='02' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  "
            . "and date(co_ord_date) >= '$define_date'  and iscorrected_inco is null")->row()->c;

           

        $officemutationCount = $this->cofieldmutationmodel->countPendingMutationCases($dist_code, $subdiv_code, $cir_code);
        $data['fmutation'] = $officemutationCount;

        

        $officepartitionCount = $this->cofieldmutationmodel->countPendingPartitionCases($dist_code, $subdiv_code, $cir_code);
        $data['fpartition'] = $officepartitionCount;

        

        $data['opartition'] = $this->getPendingOfficePartitionCases($dist_code, $subdiv_code, $cir_code);
        $data['omutation'] = $this->getPendingOfficeMutationCases($dist_code, $subdiv_code, $cir_code);

        

        $data['oconv'] = $this->getPendingConversionCasesMb3($user_code, $dist_code, $subdiv_code, $cir_code);
        
        $data['first_proceeding'] = $this->COofficeConversionModel->countCoConversionFirst();
        
        
        // $data['first_proceeding'] = $this->getFirstProceedingConvertion($user_code, $dist_code, $subdiv_code, $cir_code);
        $data['second_proceeding'] = $this->getSecondProceedingConvertionMb3($user_code, $dist_code, $subdiv_code, $cir_code);
        
        $data['third_proceeding'] = $this->getConvertionOrderPassedByDC($user_desig_code, $dist_code, $subdiv_code, $cir_code);
        $data['rejected_proceeding'] = $this->getRejectedProceedingConvertionMb3($user_code, $dist_code, $subdiv_code, $cir_code);
        $data['conversion_proceeding_report'] = $this->getconversion_proceeding_report($user_code, $dist_code, $subdiv_code, $cir_code);
        $data['ast_payment_declined'] = $this->getConversionAstPaymentDeclined($user_code, $dist_code, $subdiv_code, $cir_code);
        $data['all_circle_cases'] = $this->getAllCircleCases($user_code, $dist_code, $subdiv_code, $cir_code);

        // $data['mfirst_proceeding'] = $this->getFisrtProceedingMutation($user_code, $dist_code, $subdiv_code, $cir_code);
        // $data['msecond_proceeding'] = $this->getSecondProceedingMutation($user_code, $dist_code, $subdiv_code, $cir_code);
        // $data['pfirst_proceeding'] = $this->getFisrtProceedingPartition($user_code, $dist_code, $subdiv_code, $cir_code);
        // $data['psecond_proceeding'] = $this->getSecondProceedingPartition($user_code, $dist_code, $subdiv_code, $cir_code);

        // $data['sronote'] = $this->db->query("SELECT * from  sro_note WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status!='3' and (deed_type='SALE' or deed_type='GIFT' ) order by update_date desc   limit 10 ")->result();

        // $data['allotment_first'] = $this->db->query("Select count(*) as c from  allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  not_fresh is null and status is null")->row()->c;
        // $data['allotment_second'] = $this->db->query("Select count(*) as c from  allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  not_fresh='Y' and status='P' and co_note is not null")->row()->c;
        // $data['allotment_final'] = $this->db->query("Select count(*) as c from  allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  status='F' and dc_code is not null and chitha_correct_yn is null ")->row()->c;

        // $data['countAPCaseforCO'] = $this->APCancellationModel->getCountAPCasesforCO(); //not used location condition
        // $data['countNoteHearingAPCaseforCO'] = $this->APCancellationModel->getNoteHearingAPCasesforCO(); //not used location condition
        // $data['getOrderAPCancellation'] = $this->APCancellationModel->getOrderAPCancellation(); //not used location condition

        // $data['fchithaupdates'] = $this->getPendingFieldChithaUpdates();
        // $data['ochithaupdates'] = $this->getPendingOfficeChithaUpdates();

        // $data['grant_finalco'] = $this->db->query("Select count(*) as c from  allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and not_fresh is not null and status is not null and lm_note='Y' and sk_note='Y' and chitha_correct_yn is null and settlement_typ='gr' ")->row()->c; //Bondita

        // $data['FirstPro'] = $this->db->query("SELECT count(*) as c from  Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='04' and co_user_code='$user_code' and (status!='D' or status is null) and not_fresh is null and lm_note_yn is null and date_entry >= '$define_date' ")->row()->c;

        // $data['SecondPro'] = $this->db->query("SELECT count(*) as c from  Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and co_user_code='$user_code'  and mut_type='04' and not_fresh = 'Y' and status='P' and date_entry >= '$define_date' ")->row()->c;

        // $data['citizenPendingCO'] = $this->db->query("SELECT count(*) as c from  Cert_Application WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and LM_Checked_yn='Y' and CO_Checked_yn is null and status = 'C' and apply_date >= '$define_date'")->row()->c;

        // $data['land_proposals'] = $this->db->query("SELECT count(*) as c from   t_reclassification WHERE co_yn is null and dc_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status != 'R' OR status is null)")->row()->c;

        // $data['g_trans_for_dc'] = $this->db->query("SELECT count(*) as c from  t_reclassification WHERE co_yn = 'Y' and dc_yn is null and dc_approval is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status != 'R' OR status is null)")->row()->c;

        // $data['land_proposals_returned_DC'] = $this->db->query("SELECT count(*) as c from  t_reclassification WHERE co_yn = 'Y' and dc_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and dc_approval is not null and (status != 'R' OR status is null)")->row()->c;

        // $data['land_proposals_for_jamaupdate'] = $this->db->query("SELECT count(*) as c from   t_reclassification as t JOIN  chitha_basic as c ON c.dist_code=t.dist_code and "
        //     . "c.subdiv_code = t.subdiv_code and c.cir_code = t.cir_code and c.mouza_pargona_code=t.mouza_pargona_code and c.lot_no=t.lot_no and "
        //     . "c.vill_townprt_code=t.vill_townprt_code and c.dag_no = t.dag_no and trim(c.patta_no) = trim(t.patta_no) and c.dist_code='$dist_code' and "
        //     . "c.subdiv_code='$subdiv_code' and c.cir_code='$cir_code' and t.co_chitha_updated_yn = 'Y' and c.jama_yn != 'y'")->row()->c;

        // $data['pending_objection'] = $this->db->query("Select count(*) as c from  field_mut_objection where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and obj_flag is null and entry_date >= '$define_date' ")->row()->c;

        // $data['proceedingPartRpt'] = $this->proceedingReportpart($user_code, $dist_code, $subdiv_code, $cir_code);

        // $data['proceedingMutRpt'] = $this->proceedingReportofcmut($user_code, $dist_code, $subdiv_code, $cir_code, $year_no, $define_date);

        // $data['name_correction'] = $this->db->query("SELECT count(*) as c from   t_chitha_rmk_ordbasic WHERE ord_type_code = '05' and "
        //     . "iscorrected_inco is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        // $data['partchithaupdate'] = $this->db->query("SELECT count(*) as c from   t_chitha_rmk_ordbasic WHERE ord_type_code = '04' and iscorrected_inco is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        // //for miscellaneous cases i.e Name Correction
        // $data['MisCases'] = $this->NameCorrectionModel->getMiscCases($user_code, $dist_code, $subdiv_code, $cir_code);

        // $data['MisCasesNC'] = $this->NameCancellationModel->getMiscCasesNC($user_code, $dist_code, $subdiv_code, $cir_code);

        // $data['FinalOrderMisc'] = $this->NameCorrectionModel->getFinalOrderMisc($user_code);

        $data['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from  users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
            . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();
        if(ESCALATION_ENABLE == 1){
            $service_code = 9;
            $data['service_type'] = CONV_SERV;
            $data['escAllocateDays'] = $this->Escalationmodel->getTimeLine($service_code, 'CONVR');
            $data['escAllocateDaysP'] = $this->Escalationmodel->getTimeLine($service_code, 'CONVP');
            $data['escAllocateDaysU'] = $this->Escalationmodel->getTimeLine($service_code, 'CONVU');
        }

        $date_of_last_password_changed = $data['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }

        $data['_view'] = 'home/mb3_conversion_co';
        $this->load->view('layouts/main', $data);
    }

    public function Mb3ConversionLm()
    {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $user_code = $this->session->userdata('user_code');
        $year_no = year_no;
        $define_date = define_date;

        //var_dump($this->session->all_userdata());
        $user_desig_code = $this->session->userdata('user_desig_code');

        $counts['map_partition'] = $this->db->query("Select count(*) as c from  t_chitha_col8_order where map_partition is null and order_type_code='02' and "
            . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' "
            . "and lot_no = '$lot_no'  and date(co_ord_date) >= '$define_date' ")->row()->c;

        $counts['fconsent'] = $this->db->query("select count(*) as c from     field_mut_basic where order_passed is null and mut_type='02' and p_consent is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'  and date_entry >= '$define_date' ")->row()->c;

        $counts['fmutation'] = $this->db->query("select count(*) as c from     field_mut_basic where order_passed is null and mut_type='01' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'  and date_entry >= '$define_date' ")->row()->c;

        $counts['fpartition'] = $this->db->query("select count(*) as c from     field_mut_basic where order_passed is null and mut_type='02' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'  and date_entry >= '$define_date'")->row()->c;

        $counts['oconsent'] = $this->db->query("select count(*) as c from     petition_basic where order_passed is null and mut_type='04' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'  and date_entry >= '$define_date'")->row()->c;

        $counts['omutation'] = $this->db->query("select count(*) as c from     petition_basic where order_passed is null and not_fresh='Y' and lm_note_date is null and "
            . "sk_comment is null and mut_type='03' and status='P' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
            . "lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code'  and date_entry >= '$define_date'")->row()->c;

        $counts['opartition'] = $this->db->query("select count(*) as c from     petition_basic where order_passed is null  and date_entry >= '$define_date' and not_fresh='Y' and status='P' and lm_note_date is null and sk_comment is null and mut_type='04' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'")->row()->c;

        $counts['allotment_lm'] = $this->db->query("Select count(*) as c from     allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and lm_note is null and not_fresh='Y' and status='P' and co_note is not null")->row()->c;

        $counts['sronotepen'] = $this->db->query("SELECT count(*) as c from   sro_note WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and status='1' and nature_of_land = 'r'")->row()->c;

        $counts['oconversion'] = $this->db->query("select count(*) as c from     petition_basic where order_passed is null  and "
            . "date_entry >= '$define_date' and not_fresh='Y' and lm_note_date is null and sk_comment is null and mut_type='01' and "
            . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'")->row()->c;

        $counts['freshreport'] = $this->db->query("select count(*) as c from     field_mut_basic where co_flag_for_fresh_mut is not null and dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'")->row()->c;

        $counts['ofcPartition'] = $this->db->query("SELECT count(*) as c from   Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code'  and date_entry >= '$define_date' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and mut_type='04' and  not_fresh='Y' and status='P' and (lm_note_yn is null ) and (lm_note_date is null) ")->row()->c;

        $counts['ofcByayPrak'] = $this->db->query("SELECT count(*) as c from   Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code'  and date_entry >= '$define_date' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and  mut_type='04' and not_fresh='Y' and status='P' and byayprak_yn is null ")->row()->c;

        $counts['mappartition'] = $this->db->query("SELECT count(*) as c from   chitha_rmk_ordbasic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and  ord_type_code='04' and map_partition='P' ")->row()->c;

        $counts['CitizenCentric'] = $this->db->query("SELECT count(*) as c from   Cert_Application WHERE LM_Checked_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and apply_date >='$define_date'  and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no'")->row()->c;

        $counts['ConsentPattadar'] = $this->db->query("SELECT count(*) as c from   Petition_Basic pb INNER JOIN (SELECT dist_code, subdiv_code, cir_code, mouza_pargona_code,"
            . " Lot_No, vill_townprt_code, Year_no, Petition_no,Patta_no, patta_type_code,dag_no from   petitioner_part GROUP BY dist_code, subdiv_code, "
            . "cir_code, mouza_pargona_code, Lot_No, vill_townprt_code, Year_no, Petition_no, Patta_no,patta_type_code,dag_no) pp ON pb.dist_code = pp.dist_code AND "
            . "pb.subdiv_code = pp.subdiv_code AND pb.cir_code = pp.cir_code AND pb.mouza_pargona_code = pp.mouza_pargona_code AND pb.Lot_No = pp.Lot_No "
            . "AND pb.vill_townprt_code = pp.vill_townprt_code AND pb.Year_no = pp.Year_no AND pb.Petition_no = pp.Petition_no WHERE pb.dist_code='$dist_code' and pb.subdiv_code='$subdiv_code'  and pb.year_no='$year_no' and pb.date_entry >= '$define_date' and pb.cir_code='$cir_code' and pb.mouza_pargona_code='$mouza_pargona_code' and pb.lot_no='$lot_no' and  pb.mut_type='04' and pb.status='P' and pb.consent_updated is null ")->row()->c;

        $counts['oconv'] = $this->getPendingLMConversionCasesMb3($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        $counts['countAPCase'] = $this->APCancellationModel->getCountAPCasesforLM($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no); //not done with the location checking
        //adding it for miscellaneous cases
        $counts['countMiscCase'] = $this->NameCorrectionModel->getMiscCaseLM($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no); //not done with the location checking

        $counts['my_info'] = $this->db->query("Select lm_code.lm_name AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed, lm_code.corres_sk_code AS corres_sk_code from  lm_code INNER JOIN loginuser_table ON "
            . "lm_code.lm_code = loginuser_table.user_code and lm_code.dist_code = loginuser_table.dist_code and "
            . "lm_code.subdiv_code = loginuser_table.subdiv_code and lm_code.cir_code = loginuser_table.cir_code and "
            . "lm_code.mouza_pargona_code = loginuser_table.mouza_pargona_code and lm_code.lot_no = loginuser_table.lot_no "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
            . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();

        $date_of_last_password_changed = $counts['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }

        if(ESCALATION_ENABLE == 1){
            $service_code = 9;
            $counts['service_type'] = CONV_SERV;
            $counts['escAllocateDays'] = $this->Escalationmodel->getTimeLine($service_code, 'CONVR');
            $counts['escAllocateDaysP'] = $this->Escalationmodel->getTimeLine($service_code, 'CONVP');
            $counts['escAllocateDaysU'] = $this->Escalationmodel->getTimeLine($service_code, 'CONVU');
        }

        $counts['_view'] = 'home/mb3_conversion_lm';
        $this->load->view('layouts/main', $counts);
    }

    public function Mb3ConversionSk() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $year_no = year_no;
        $define_date = define_date;

        $append = "dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code'";

        $counts['fmutation'] = $this->db->query("select count(*) as c from     field_mut_basic where order_passed is null and sk_flag is null and mut_type='01'  and date_entry >= '$define_date' and " . $append)->row()->c;

        $counts['fpartition'] = $this->db->query("select  count(*) as c from     field_mut_basic where order_passed is null and sk_flag is null and mut_type='02'and dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $counts['omutation'] = $this->db->query("SELECT count(*) as c from   Petition_basic WHERE  not_fresh='Y' and sk_comment is null and  lm_note_date is not null and order_passed is null and mut_type='01'  and date_entry >= '$define_date' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $counts['oconversion'] = $this->db->query("SELECT count(*) as c from   Petition_basic WHERE  not_fresh='Y' and sk_comment is null and  lm_note_date is not null and order_passed is null and mut_type='01'  and date_entry >= '$define_date' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $counts['omutation'] = $this->db->query("SELECT count(*) as c from   Petition_basic WHERE  not_fresh='Y' and sk_comment is null and  lm_note_date is not null and order_passed is null and mut_type='03' and dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $counts['opartition'] = $this->db->query("SELECT count(*) as c from   Petition_basic WHERE  not_fresh='Y' and sk_comment is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  lm_note_date is not null and order_passed is null and mut_type='04' and dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $counts['cases'] = $this->db->query("select count(*) as c from     petition_basic where is_mb3=1 and not_fresh = 'Y'  and date_entry >= '$define_date' and lm_note_yn = 'Y' and status = 'P' and sk_comment is null and mut_type='01' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $counts['allotment_sk'] = $this->db->query("Select count(*) as c from     allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and lm_note='Y' and sk_note is null and not_fresh='Y' and status='P' and co_note is not null")->row()->c;

        $counts['countAPCaseforSK'] = $this->APCancellationModel->getCountAPCasesforSK(); //not done with the location checking
        //adding it for miscellaneous cases
        $counts['countMiscCaseSK'] = $this->NameCorrectionModel->getMiscCaseSK($user_code); //not done with the location checking

        $counts['grant_sk'] = $this->db->query("Select count(*) as c from     allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and lm_note='Y'  and sk_note is null and not_fresh='Y' and status='P' and settlement_typ='gr' ")->row()->c;

        $counts['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from     users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.user_code = '$user_code'")->row();

        $date_of_last_password_changed = $counts['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }

        $counts['_view'] = 'home/mb3_conversion_sk';
        $this->load->view('layouts/main', $counts);
    }

    public function Mb3ConversionAst()
    {
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $year_no = year_no;
        $define_date = define_date;

        $counts['NoticeGen'] = $this->db->query("SELECT count(*) as c from    Petition_basic WHERE is_mb3=1 and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and not_fresh='Y' and status ='P' and mut_type='04' and (notice_generated_yn is null or notice_generated_yn='' )  and date_entry >= '$define_date' ")->row()->c;

        $counts['PayNoticeGen'] = $this->db->query("SELECT count(*) as c from    Petition_basic WHERE is_mb3=1 and dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and not_fresh='Y' and status ='P' and mut_type='04' and pay_notice_gen_yn ='Y' and  notice_served_yn!='Y'  ")->row()->c;

        // $counts['byayPrak'] = $this->db->query("SELECT count(*) as c from    Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  and date_entry >= '$define_date'  and pay_notice_gen_yn='Y' and status='P' and not_fresh='Y' and mut_type='04' and petition_no in ( SELECT petition_no from    Petition_byayprak WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and if_paid is null ) ")->row()->c;

        // $counts['ProceedingOrder'] = $this->db->query("SELECT count(*) as c from    Petition_basic WHERE dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and not_fresh='Y' and status ='P' and mut_type='04' and (proceeding_yn is null or proceeding_yn='')")->row()->c;

        // $counts['CountPartitionOnline'] = $this->ServicePlusModel->count_online_partition_cases();

        $counts['Pcases'] = $this->getPendingASTNoticeGeneratedConversionCasesMb3($user_code, $dist_code, $subdiv_code, $cir_code);

        $counts['cases'] = $this->getPendingASTActionTakenConversionCasesMb3($user_code, $dist_code, $subdiv_code, $cir_code);

        $counts['premium'] = $this->getPendingASTPremiumConversionCasesMb3($user_code, $dist_code, $subdiv_code, $cir_code);

        $counts['payment'] = $this->getPendingASTPaymentConversionCasesMb3($user_code, $dist_code, $subdiv_code, $cir_code);

        $counts['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from  users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.user_code = '$user_code'")->row();

        $date_of_last_password_changed = $counts['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }

        $counts['_view'] = 'home/mb3_conversion_ast';
        $this->load->view('layouts/main', $counts);
    }

   public function ReclassSuiteLandCo()
    {
      $service_code = $this->input->get('service');
      $dist_code    = $this->session->userdata('dist_code');
      $subdiv_code  = $this->session->userdata('subdiv_code');
      $cir_code     = $this->session->userdata('cir_code');
      $lot_no       = $this->session->userdata('lot_no');
      $user_code    = $this->session->userdata('user_code');
      $year_no      = year_no;
      $define_date  = define_date;
      $this->dbswitch();
      // var_dump($this->session->all_userdata()); die;
      $user_desig_code = $this->session->userdata('user_desig_code');
      if ($user_desig_code != 'CO' && $user_desig_code != 'SK') {
        $this->session->set_flashdata('message', "#HOMEC1503303 : Unauthorized access");
        redirect(base_url() . "index.php/home");
      }

      $counts['user_desig_code'] = $user_desig_code;

      if (LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO') {
        $lot_string = $this->caseListUnderMappingLot();
      }

      $lot_bifurcate = '';
      $lot_bifurcate_sb = '';

      if (LOT_BIFURCATE == 1) {
        if (isset($lot_string) && $lot_string != null) {
          $lot_bifurcate = "and mouza_pargona_code ||'_' || lot_no in ($lot_string)";
          $lot_bifurcate_sb = "and sb.mouza_pargona_code ||'_' || sb.lot_no in ($lot_string)";
        }
      }

      $counts['sk_first'] = $this->db->query("select count(*) as c from settlement_basic left join settlement_ap_lmnote on settlement_basic.case_no=settlement_ap_lmnote.case_no where  lm_note ='1' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and settlement_basic.status='W' and from_office='LM' and (pending_officer='SK' OR pending_officer='CO') and service_code='$service_code'  and settlement_basic.date_entry >= '$define_date' ")->row()->c;

      $counts['re_report_lm_sk'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='X' and (from_office='LM' OR from_office='DC') and pending_officer='SK' and service_code='$service_code'  and date_entry >= '$define_date' ")->row()->c;

      $counts['first'] = $this->db->query("select count(*) as c from reclass_suite_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='W' and from_office in ('LM','SK','CO','ADC','SDO') and (pending_officer='CO' or pending_officer='SK') and service_code='$service_code'   and date_entry >= '$define_date' $lot_bifurcate")->row()->c;

      $counts['re_report_lm'] = $this->db->query("select count(*) as c from reclass_suite_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='X' and (from_office='LM' OR from_office='SK' OR from_office='DC') and (pending_officer='CO' or pending_officer='SK') and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

      $counts['notice_report_ast'] = $this->db->query("select count(*) as c from reclass_suite_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='S' and from_office='CO' and pending_officer='CO' and notice_generated_yn is not null and note_action_yn is not null and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

      $counts['reverted_by_dc'] = $this->db->query("select count(*) as c from reclass_suite_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='R' and (from_office='DC' or from_office='ADC' or from_office='SDO') and pending_officer='CO'  and service_code='$service_code'  and date_entry >= '$define_date' $lot_bifurcate")->row()->c;

      $counts['chitha'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='C' and from_office='DC' and pending_officer='CO' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

      $counts['payment_notice'] = $this->db->query("select count(*) as c from reclass_suite_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='M' and (from_office='DPT' or from_office='DC') and pending_officer='CO' and service_code='$service_code' and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

      $counts['payment_confirm'] = $this->db->query("select count(*) as c from reclass_suite_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='N' and pending_officer='CO' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

      $counts['reverted_by_co'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='R' and from_office='CO'  and pending_officer='LM' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

      $counts['forwarded_to_adc'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_officer not in('LM','SK','CO') and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

      $counts['rejected_by_co'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_officer='CO' and status='D' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

      $counts['revival_flag_list'] = $this->db->query("select count(*) as c from settlement_revival_flag where  req_by='CO' and  req_by = 'CO' and service_code='$service_code'  and (user_code='$user_code')")->row()->c;

      $counts['bulk_approve_lm_report'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='N' and from_office='CO' and pending_officer='CO' and service_code='$service_code' and chitha_processing_details = 1  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

      $counts['bulk_chitha_update'] = $this->db->query("select count(distinct(sb.case_no)) as c from settlement_basic sb join settlement_premium sp on sb.case_no = sp.case_no where sb.status = ? and sb.chitha_processing_details = ? and sb.dist_code = ? and sb.subdiv_code = ? and sb.cir_code = ? and sb.from_office = ? and sb.pending_officer = ? and sb.service_code = ? and sp.is_final = ? and sp.grn_no is not null and DATE_PART('day', now()::timestamp- sb.ppp_issue_date::timestamp)>15 AND DATE_PART('day', now()::timestamp- sb.ppp_issue_date::timestamp)>15 AND sb.order_passed is null AND sb.co_chitha_corrected_yn is null " . $lot_bifurcate_sb, array('N', 2, $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', TEA_SERVICE_CODE, 1))->row()->c;

      $counts['bulk_chitha_update_partial'] = $this->db->query("
      SELECT
          count(distinct(sb.case_no)) as C
          FROM settlement_basic sb
          JOIN
          (
              SELECT
                   sh.case_no
               FROM
                   settlement_emi_history sh
               JOIN
                   (
                       SELECT
                           case_no,
                           MAX(id) AS max_id
                       FROM
                           settlement_emi_history
                       GROUP BY
                           case_no
                       HAVING
                           COUNT(*) > 1
                   ) max_ids
               ON
                   sh.case_no = max_ids.case_no
               AND
                   sh.id = max_ids.max_id AND paid_no_of_installment != chitha_update_status
          ) AS seh
          ON sb.case_no = seh.case_no
          where sb.status = ?
          and sb.chitha_processing_details = ?
          and sb.dist_code = ?
          and sb.subdiv_code = ?
          and sb.cir_code = ?
          and sb.from_office = ?
          and sb.pending_officer = ?
          and sb.service_code = ?
          AND DATE_PART('day', now()::timestamp- sb.ppp_issue_date::timestamp)>15 AND DATE_PART('day', now()::timestamp- sb.ppp_issue_date::timestamp)>15 AND sb.order_passed is NOT NULL AND sb.co_chitha_corrected_yn is NOT NULL " . $lot_bifurcate_sb, array('N', 2, $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', TEA_SERVICE_CODE))->row()->c;

      $counts['re_generate_premium_notice'] = $this->db->query('select count(distinct(sb.case_no)) as c from settlement_basic sb join settlement_premium sp on sb.case_no = sp.case_no join settlement_notice sn on sb.case_no = sn.case_no where sb.status = ? and sb.dist_code = ? and sb.subdiv_code = ? and sb.cir_code = ? and sb.from_office = ? and sb.pending_officer = ? and sb.service_code = ? and sp.is_final = ? and sp.grn_no is null and sn.notice_type=?' . $lot_bifurcate . '', array('N', $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', TEA_SERVICE_CODE, 1, 'PN'))->row()->c;

      $counts['remain_amt_prem_notice'] = $this->db->query('select count(distinct(sb.case_no)) as c from settlement_basic sb join settlement_premium sp on sb.case_no = sp.case_no where sb.status = ? and sb.dist_code = ? and sb.subdiv_code = ? and sb.cir_code = ? and sb.from_office = ? and sb.pending_officer = ? and sb.service_code = ? and sp.is_final = ? and sp.grn_no is not null and sp.due_amount > sp.paid_amount and sb.case_no NOT IN (SELECT DISTINCT(case_no) FROM settlement_notice WHERE case_no = sb.case_no AND notice_type = ?) ' . $lot_bifurcate . '', array('N', $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', TEA_SERVICE_CODE, 1, 'PNP1'))->row()->c;

      $counts['print_partial_notice'] = $this->db->query('select count(distinct(sb.case_no)) as c from settlement_basic sb join settlement_premium sp on sb.case_no = sp.case_no where sb.status = ? and sb.dist_code = ? and sb.subdiv_code = ? and sb.cir_code = ? and sb.from_office = ? and sb.pending_officer = ? and sb.service_code = ? and sp.is_final = ? and sp.grn_no is not null and sp.due_amount > sp.paid_amount and sb.case_no IN (SELECT DISTINCT(case_no) FROM settlement_notice WHERE case_no = sb.case_no AND notice_type = ?) ' . $lot_bifurcate . '', array('N', $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', TEA_SERVICE_CODE, 1, 'PNP1'))->row()->c;

      $counts['service_code'] = $service_code;
      $counts['_view']        = 'reclass_suite/CO/ReclassSuite_CO';

      $this->load->view('layouts/main', $counts);
    }

    public function ReclassSuiteLm()
    {
      $service_code       = RECLASS_ID;
      $dist_code          = $this->session->userdata('dist_code');
      $subdiv_code        = $this->session->userdata('subdiv_code');
      $cir_code           = $this->session->userdata('cir_code');
      $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
      $lot_no             = $this->session->userdata('lot_no');
      $user_code          = $this->session->userdata('user_code');
      $year_no            = year_no;
      $define_date        = define_date;
      $this->dbswitch();

      $user_desig_code    = $this->session->userdata('user_desig_code');
      
      $counts['reverted'] = $this->db->query("select count(*) as c from reclass_suite_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and service_code='$service_code' and status='R' and from_office='CO' and pending_officer='LM'  and date_entry >= '$define_date' ")->row()->c;

      $counts['notice_generated_count'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and service_code='$service_code' and status='N' and pending_officer='CO' and chitha_processing_details = 0  and date_entry >= '$define_date' ")->row()->c;

      $counts['reverted_review'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and service_code='$service_code' and status='RA' and from_office='CO' and pending_officer='LM'  and date_entry >= '$define_date' ")->row()->c;

      $counts['forwarded_by_co'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and service_code='$service_code' and status='Z' and from_office='CO' and pending_officer='LM'  and date_entry >= '$define_date' ")->row()->c;

      $counts['service_code'] = $service_code;
      $counts['_view']        = 'reclass_suite/LM/ProcessReclassSuiteLM';
      $this->load->view('layouts/main', $counts);
    }

    public function ConversionDcMb()
    {
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = '00';
        $cir_code = '00';
        $mouza_pargona_code = '00';
        $lot_no = '00';


        $counts['first_proceeding_for_dc'] = $this->db->query("select count(*) as c from petition_basic where add_off_desig = '$user_desig_code' and status not in ('F','D') and is_mb3=1 and co_user_code = '$user_code' and mut_type='01' and dist_code='$dist_code' and proceeding_yn is not null and new_status='ADDC1'")->row()->c;

        // $counts['second_proceeding_for_dc'] = $this->db->query("select count(*) as c from petition_basic where not_fresh = 'Y' and status = 'P' and add_off_desig = '$user_desig_code' and co_user_code = '$user_code' and mut_type='01' and dist_code='$dist_code' and bo_note_yn is not null")->row()->c;
        $counts['second_proceeding_for_dc'] = $this->db->query("select count(*) as c from petition_basic where not_fresh = 'Y' and status = 'P' and add_off_desig = '$user_desig_code' and co_user_code = '$user_code' and mut_type='01' and dist_code='$dist_code' and ((dept_note_yn='Y' and new_status='DPDCA') or (new_status in ('ADPSO','ADCPS')))")->row()->c;
        $counts['dpt_proceeding_for_dc'] = $this->db->query("select count(*) as c from petition_basic where dept_note_yn is null and not_fresh = 'Y' and status = 'W' and add_off_desig = 'DPT' and co_user_code = '$user_code' and mut_type='01' and dist_code='$dist_code' and new_status='DCDPT'")->row()->c;

        $counts['dpt_app_proceeding_for_dc'] = $this->db->query("select count(*) as c from petition_basic where dept_note_yn='Y' and not_fresh = 'Y' and status = 'P' and add_off_desig = '$user_desig_code' and co_user_code = '$user_code' and mut_type='01' and dist_code='$dist_code' and new_status='DPDCA'")->row()->c;

        //added by hridayjit--12/05/2024
        $counts['dpt_revert_cases'] = $this->db->query("SELECT COUNT(*) as c FROM petition_basic WHERE dept_note_yn IS NULL AND not_fresh='Y' AND status='R' AND add_off_desig='DC' AND co_user_code=? AND user_code LIKE '%DPT%' AND mut_type='01' AND dist_code=? AND new_status='DPDCR'", [$user_code, $dist_code])->row()->c;
        //


        $counts['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from     users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
            . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();

        $date_of_last_password_changed = $counts['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }

        $counts['_view'] = 'home/conversion_dc_mb';
        $this->load->view('layouts/main', $counts);
  }

  public function ConversionAdcMb()
    {
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = '00';
        $cir_code = '00';
        $mouza_pargona_code = '00';
        $lot_no = '00';

        $year_no = year_no;
        $define_date = define_date;

        $adc_code = $this->session->userdata('user_code');

        //************INTEGRATE CIRCLE MAPPING***************
        $circle_bifurcate = '';
        if (CIRCLE_BIRFURCATE_ADC == 1 && $this->session->userdata('user_desig_code') == 'ADC') {
            $circle_bifurcate = $this->circleMappingModel->caseListUnderMappingCircleOfADC();
        }
        //************END************************************


        $counts['first_proceeding_for_adc'] = $this->db->query("select count(*) as c from     petition_basic where add_off_desig = '$user_desig_code' and bo_note_yn is null and co_user_code = '$user_code' and  mut_type='01' and dist_code='$dist_code' and proceeding_yn is not null and bo_notice_gen is null and is_mb3=1 $circle_bifurcate")->row()->c;

        $counts['second_proceeding_for_adc'] = $this->db->query("select count(*) as c from     petition_basic where not_fresh = 'Y' and status = 'P' and add_off_desig = '$user_desig_code' and co_user_code = '$user_code' and mut_type='01' and dist_code='$dist_code' and bo_note_yn is not null and is_mb3=1 $circle_bifurcate")->row()->c;

        // $counts['dpt_proceeding_for_adc'] = $this->db->query("select count(*) as c from petition_basic where dept_note_yn is null and not_fresh = 'Y' and status = 'W' and add_off_desig = 'DPT' and co_user_code = '$user_code' and mut_type='01' and dist_code='$dist_code' and bo_note_yn is not null $circle_bifurcate")->row()->c;

        // $counts['dpt_app_proceeding_for_adc'] = $this->db->query("select count(*) as c from petition_basic where dept_note_yn='Y' and not_fresh = 'Y' and status = 'P' and add_off_desig = '$user_desig_code' and co_user_code = '$user_code' and mut_type='01' and dist_code='$dist_code' and bo_note_yn is not null $circle_bifurcate")->row()->c;

        // $counts['first_proceeding_for_dc'] = $this->db->query("select count(*) as c from     petition_basic where add_off_desig = '$user_desig_code' and bo_note_yn is null and status not in ('F','D') and co_user_code = '$user_code' and mut_type='01' and dist_code='$dist_code' and proceeding_yn is not null and bo_notice_gen is null and not status='D'")->row()->c;

        // $counts['second_proceeding_for_dc'] = $this->db->query("select count(*) as c from     petition_basic where not_fresh = 'Y' and status = 'P' and add_off_desig = '$user_desig_code' and co_user_code = '$user_code' and mut_type='01' and dist_code='$dist_code' and bo_note_yn is not null")->row()->c;

        $counts['premium'] = $this->getPendingASTPremiumConversionCasesDCMb($user_code, $dist_code);
        $counts['payment'] = $this->getPendingASTPaymentConversionCasesDCMb($user_code, $dist_code);

        $counts['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
            . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
            . "loginuser_table.date_password_changed AS date_password_changed from     users INNER JOIN loginuser_table ON "
            . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
            . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
            . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
            . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
            . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();

        $date_of_last_password_changed = $counts['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }

        $counts['_view'] = 'home/conversion_adc_mb';
        $this->load->view('layouts/main', $counts);
    }

    public function getPendingASTPremiumConversionCasesDCMb($user_code, $dist_code)
    {

        $query = "select count(*) as c from petition_basic where not_fresh = 'Y' and status = 'P' and user_code = '$user_code' and mut_type = '01' and "
            . "co_order_conv_premium = 'Y' and dist_code='$dist_code' and co_order_conv_notice is not null and is_mb3=1 and new_status='DCADP'";
        return $this->db->query($query)->row()->c;
    }

    public function getPendingASTPaymentConversionCasesDCMb($user_code, $dist_code)
    {

        $query = "select count(*) as c from     petition_basic where not_fresh = 'Y' and user_code = '$user_code' and status = 'P' and mut_type = '01' and "
            . "co_order_conv_premium = 'Y' and dist_code='$dist_code' and is_mb3=1 and new_status='ADCTP'";
        return $this->db->query($query)->row()->c;
    }

    public function getSecondProceedingConvertionMb3($dsg, $dist_code, $subdiv_code, $cir_code)
    {
        $year_no = year_no;
        $define_date = define_date;

        $query = "select count(*) as c from petition_basic where not_fresh = 'Y' and status = 'P' and mut_type='01' and co_user_code = '$dsg' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'   and date_entry >= '$define_date'  and is_mb3=1 and new_status='LRSCO'";
        return $this->db->query($query)->row()->c;
    }

    public function getPendingASTNoticeGeneratedConversionCasesMb3($user_code, $dist_code, $subdiv_code, $cir_code)
    {
        $year_no = year_no;
        $define_date = define_date;

        // $query = "select count(*) as c from     petition_basic where not_fresh = 'Y'  and date_entry >= '$define_date' and user_code = '$user_code' and "
        //         . "notice_generated_yn is null and status = 'P' and mut_type = '01' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
        $query = "select count(*) as c from     petition_basic where not_fresh = 'Y'  and date_entry >= '$define_date' and "
            . "notice_generated_yn='Y' and notice_served_yn is null and status = 'P' and mut_type = '01' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and is_mb3=1";
        return $this->db->query($query)->row()->c;
    }

    public function getPendingASTActionTakenConversionCasesMb3($user_code, $dist_code, $subdiv_code, $cir_code)
    {
        $year_no = year_no;
        $define_date = define_date;

        // $query = "select count(*) as c from     petition_basic where not_fresh = 'Y'  and date_entry >= '$define_date' and user_code = '$user_code' and "
        //         . "proceeding_yn is null and status = 'P' and mut_type = '01' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
        $query = "select count(*) as c from     petition_basic where is_mb3=1 and not_fresh = 'Y'  and date_entry >= '$define_date' and "
            . "proceeding_yn is null and status = 'P' and notice_served_yn='Y' and is_mb3=1 and (new_status='COLM1' or new_status='LMLRS' or new_status='LRSCO') and mut_type = '01' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
        return $this->db->query($query)->row()->c;
    }


    // Bhoodan Gramdan
    public function BhoodanLm()
    {
        $service_code = BHODDAN_SERVICE_CODE;
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $user_code = $this->session->userdata('user_code');
        $year_no = year_no;
        $define_date = define_date;
        $this->dbswitch();
        //var_dump($this->session->all_userdata());
        $user_desig_code = $this->session->userdata('user_desig_code');
        $counts['reverted'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and service_code='$service_code' and status='R' and from_office='CO' and pending_officer='LM'  and date_entry >= '$define_date' ")->row()->c;

        $counts['notice_generated_count'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and service_code='$service_code' and status='N' and pending_officer='CO' and chitha_processing_details = 0  and date_entry >= '$define_date' ")->row()->c;

        $counts['reverted_review'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and service_code='$service_code' and status='RA' and from_office='CO' and pending_officer='LM'  and date_entry >= '$define_date' ")->row()->c;

        $counts['service_code'] = $service_code;
        $counts['_view'] = 'Bhoodan/LM/bhoodan_lm_main';
        $this->load->view('layouts/main', $counts);
    }

    public function BhoodanCo()
    {
      // echo "sadfghjk"; die;
      $service_code = $this->input->get('service');
      $dist_code    = $this->session->userdata('dist_code');
      $subdiv_code  = $this->session->userdata('subdiv_code');
      $cir_code     = $this->session->userdata('cir_code');
      $lot_no       = $this->session->userdata('lot_no');
      $user_code    = $this->session->userdata('user_code');
      $year_no      = year_no;
      $define_date  = define_date;
      $this->dbswitch();

      $user_desig_code = $this->session->userdata('user_desig_code');
      if ($user_desig_code != 'CO' && $user_desig_code != 'SK' ) {
        $this->session->set_flashdata('message', "#HOME6153 : Unauthorized access");
        redirect(base_url() . "index.php/home");
      }

      $counts['user_desig_code'] = $user_desig_code;

      if (LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO') {
        $lot_string = $this->caseListUnderMappingLot();
      }

      $lot_bifurcate = '';
      $lot_bifurcate_sb = '';

      if (LOT_BIFURCATE == 1) {
        if (isset($lot_string) && $lot_string != null) {
          $lot_bifurcate    = "and mouza_pargona_code ||'_' || lot_no in ($lot_string)";
          $lot_bifurcate_sb = "and sb.mouza_pargona_code ||'_' || sb.lot_no in ($lot_string)";
        }
      }

      $counts['first'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='W' and from_office = 'LM' and pending_officer='CO' and service_code='$service_code' and date_entry >= '$define_date' $lot_bifurcate")->row()->c;

      $counts['re_report_lm_sk'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='X' and (from_office='LM' OR from_office='DC') and pending_officer='SK' and service_code='$service_code'  and date_entry >= '$define_date' ")->row()->c;

      
      // $counts['_view'] = 'settlement_mb/settlement_mb_co';

      $counts['re_report_lm'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='X' and (from_office='LM' OR from_office='SK' OR from_office='DC') and (pending_officer='CO' or pending_officer='SK') and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

      $counts['reverted_by_dc'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='R' and (from_office='DC' or from_office='ADC' or from_office='SDO') and pending_officer='CO'  and service_code='$service_code'  and date_entry >= '$define_date' $lot_bifurcate")->row()->c;

      $counts['chitha'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='C' and from_office='DC' and pending_officer='CO' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

      $counts['payment_notice'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='M' and (from_office='DPT' or from_office='DC') and pending_officer='CO' and service_code='$service_code' and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

      $counts['payment_confirm'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='N' and from_office='CO' and pending_officer='CO' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

      $counts['reverted_by_co'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='R' and from_office='CO'  and pending_officer='LM' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

      $counts['forwarded_to_adc'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_officer not in('LM','SK','CO') and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

      $counts['rejected_by_co'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_officer='CO' and status='D' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

      $counts['revival_flag_list'] = $this->db->query("select count(*) as c from settlement_revival_flag where  req_by='CO' and  req_by = 'CO' and service_code='$service_code'  and (user_code='$user_code')")->row()->c;

      $counts['bulk_approve_lm_report'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='N' and from_office='CO' and pending_officer='CO' and service_code='$service_code' and chitha_processing_details = 1  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

      $counts['bulk_chitha_update'] = $this->db->query("select count(distinct(sb.case_no)) as c from settlement_basic sb join settlement_premium sp on sb.case_no = sp.case_no where sb.status = ? and sb.chitha_processing_details = ? and sb.dist_code = ? and sb.subdiv_code = ? and sb.cir_code = ? and sb.from_office = ? and sb.pending_officer = ? and sb.service_code = ? and sp.is_final = ? and sp.grn_no is not null and DATE_PART('day', now()::timestamp- sb.ppp_issue_date::timestamp)>15 AND DATE_PART('day', now()::timestamp- sb.ppp_issue_date::timestamp)>15 AND sb.order_passed is null AND sb.co_chitha_corrected_yn is null " . $lot_bifurcate_sb, array('N', 2, $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', BHODDAN_SERVICE_CODE, 1))->row()->c;

      $counts['re_generate_premium_notice'] = $this->db->query('select count(distinct(sb.case_no)) as c from settlement_basic sb join settlement_premium sp on sb.case_no = sp.case_no join settlement_notice sn on sb.case_no = sn.case_no where sb.status = ? and sb.dist_code = ? and sb.subdiv_code = ? and sb.cir_code = ? and sb.from_office = ? and sb.pending_officer = ? and sb.service_code = ? and sp.is_final = ? and sp.grn_no is null and sn.notice_type=?' . $lot_bifurcate . '', array('N', $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', BHODDAN_SERVICE_CODE, 1, 'PN'))->row()->c;

      $counts['remain_amt_prem_notice'] = $this->db->query('select count(distinct(sb.case_no)) as c from settlement_basic sb join settlement_premium sp on sb.case_no = sp.case_no where sb.status = ? and sb.dist_code = ? and sb.subdiv_code = ? and sb.cir_code = ? and sb.from_office = ? and sb.pending_officer = ? and sb.service_code = ? and sp.is_final = ? and sp.grn_no is not null and sp.due_amount > sp.paid_amount and sb.case_no NOT IN (SELECT DISTINCT(case_no) FROM settlement_notice WHERE case_no = sb.case_no AND notice_type = ?) ' . $lot_bifurcate . '', array('N', $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', BHODDAN_SERVICE_CODE, 1, 'PNP1'))->row()->c;

      $counts['print_partial_notice'] = $this->db->query('select count(distinct(sb.case_no)) as c from settlement_basic sb join settlement_premium sp on sb.case_no = sp.case_no where sb.status = ? and sb.dist_code = ? and sb.subdiv_code = ? and sb.cir_code = ? and sb.from_office = ? and sb.pending_officer = ? and sb.service_code = ? and sp.is_final = ? and sp.grn_no is not null and sp.due_amount > sp.paid_amount and sb.case_no IN (SELECT DISTINCT(case_no) FROM settlement_notice WHERE case_no = sb.case_no AND notice_type = ?) ' . $lot_bifurcate . '', array('N', $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', BHODDAN_SERVICE_CODE, 1, 'PNP1'))->row()->c;

      $counts['service_code'] = $service_code;

      $counts['_view'] = 'Bhoodan/CO/bhoodan_co.php';
      $this->load->view('layouts/main', $counts);
    }

    public function Mb3JuridicalAst()
    {
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $year_no = year_no;
        $define_date = define_date;
        $counts['Pcases'] = $this->db->query("SELECT count(*) as c from    settlement_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  and status ='W' and ast_notice_hearing_date is not null and ast_notice_generated is null and ast_notice_serve is null")->row()->c;

        $counts['cases'] = $this->db->query("SELECT count(*) as c from    settlement_basic WHERE dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  and status ='W'  and ast_notice_hearing_date is not null and ast_notice_generated is not null and ast_notice_serve is null")->row()->c;

        
        $counts['_view'] = 'home/mb3_juridical_ast';
        $this->load->view('layouts/main', $counts);
    }

    function ReclassBO(){
        
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
       // 
        $subdiv_code = '00';
        $cir_code = '00';
        $mouza_pargona_code = '00';
        $lot_no = '00';
        // 

        $counts['reclassbo'] = $this->db->query("select count(*) as c from suomoto_reclass where notice_generated_yn is null and notice_served_yn is null and status='D'  and dist_code='$dist_code'")->row()->c;


        $counts['reclassactiontaken'] = $this->db->query("select count(*) as c from suomoto_reclass where notice_generated_yn is null and status='D'  and dist_code='$dist_code'")->row()->c;

        $counts['reclaspaymentNotice'] = $this->db->query("select count(*) as c from suomoto_reclass where notice_generated_yn is not null and status='B'  and not_fresh is not null and pay_notice_generated_yn is null and dist_code='$dist_code'")->row()->c;

        $counts['reclaspaymentConfirm'] = $this->db->query("select count(*) as c from suomoto_reclass where notice_generated_yn is not null and status='B'  and not_fresh is not null and pay_notice_generated_yn is not null and dist_code='$dist_code'")->row()->c;

        $counts['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
                        . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
                        . "loginuser_table.date_password_changed AS date_password_changed from     users INNER JOIN loginuser_table ON "
                        . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
                        . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
                        . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
                        . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
                        . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();

        $date_of_last_password_changed = $counts['my_info']->date_password_changed;
        if (strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
            $this->updatepasswordnow($user_code, $user_desig_code);
        }
        $counts['_view'] = 'SuomotoReclassification/reclass_bo';
        $this->load->view('layouts/main',$counts);
    }

    public function getConversionAstPaymentDeclined($dsg, $dist_code, $subdiv_code, $cir_code)
    {
        $year_no = year_no;
        $define_date = define_date;

        $query = "select count(*) as c from petition_basic where not_fresh = 'Y' and status = 'P' and mut_type='01' and co_user_code = '$dsg' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'   and date_entry >= '$define_date'  and is_mb3=1 and new_status='ASPCA'";
        return $this->db->query($query)->row()->c;
    }

    public function getRejectedProceedingConvertionMb3($dsg, $dist_code, $subdiv_code, $cir_code)
    {
        $year_no = year_no;
        $define_date = define_date;

        $query = "select count(*) as c from     petition_basic where is_mb3=1 and not_fresh = 'Y' and status = 'R' and mut_type='01' and co_user_code = '$dsg' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'   and date_entry >= '$define_date'  ";
        return $this->db->query($query)->row()->c;
    }

    public function getAllCircleCases($dsg, $dist_code, $subdiv_code, $cir_code) {
        $year_no = year_no;
        $define_date = define_date;

        $count = $this->db->query("SELECT COUNT(*) as c FROM petition_basic WHERE not_fresh='Y' AND lm_note_yn IS NOT NULL AND mut_type='01' AND co_user_code=? AND dist_code=? AND subdiv_code=? AND cir_code=? AND date_entry >= '$define_date' AND is_mb3=1 AND status!=? AND status!=?", [$dsg, $dist_code, $subdiv_code, $cir_code, 'F', 'D'])->row()->c;

        return $count;
    }

}
