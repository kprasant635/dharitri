<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->library('session');

        $this->load->model('mutation/cofieldmutationmodel');
        $this->load->model('APCancellation/APCancellationModel');
        $this->load->model('NameCorrection/NameCorrectionModel');
        $this->load->model('NameCancellation/NameCancellationModel');
		$this->load->model('ServicePlus/ServicePlusModel');
        $this->load->helper('cookie');
    }

    public function index() {
        $language = $this->session->userdata('language');
        if (!$this->session->userdata('language'))
            $language = "english";
        $this->load->language($language, $language);

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
        }
        $requiredParama = array(
            'session_id', 'ip_address', 'user_agent', 'last_activity', 'user_data', 'word', 'time', 'image', 'districtname', 'language', 'dist_code', 'subdiv_code', 'cir_code', 'lot_no', 'mouza_pargona_code', 'vill_townprt_code', 'user_code', 'user_desig_code', 'priv', 'message', 'first_login', 'date_of_last_password_change',
        );
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

    public function coHome() {
        $user_code = $this->session->userdata('user_code');
        $user_desig_code=$this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
        
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        
        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';

        $data['map_partition'] = $this->db->query("Select count(*) as c from t_chitha_col8_order where map_partition!=null and "
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

        $data['sronote'] = $this->db->query("SELECT * FROM sro_note WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status!='3' and (deed_type='SALE' or deed_type='GIFT' ) order by update_date desc   limit 10 ")->result();

        $data['allotment_first'] = $this->db->query("Select count(*) as c from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  not_fresh is null and status is null")->row()->c;
        $data['allotment_second'] = $this->db->query("Select count(*) as c from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  not_fresh='Y' and status='P' and co_note is not null")->row()->c;
        $data['allotment_final'] = $this->db->query("Select count(*) as c from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  status='F' and dc_code is not null and chitha_correct_yn is null ")->row()->c;

        $data['countAPCaseforCO'] = $this->APCancellationModel->getCountAPCasesforCO(); //not used location condition
        $data['countNoteHearingAPCaseforCO'] = $this->APCancellationModel->getNoteHearingAPCasesforCO(); //not used location condition
        $data['getOrderAPCancellation'] = $this->APCancellationModel->getOrderAPCancellation(); //not used location condition

        $data['fchithaupdates'] = $this->getPendingFieldChithaUpdates();
        $data['ochithaupdates'] = $this->getPendingOfficeChithaUpdates();
		
        $data['FirstPro'] = $this->db->query("SELECT count(*) as c FROM Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='04' and co_user_code='$user_code' and (status!='D' or status is null) and not_fresh is null and lm_note_yn is null and date_entry >= '$define_date' ")->row()->c;
        
        $data['SecondPro'] = $this->db->query("SELECT count(*) as c FROM Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and co_user_code='$user_code'  and mut_type='04' and not_fresh = 'Y' and status='P' and date_entry >= '$define_date' ")->row()->c;
        
        $data['citizenPendingCO'] = $this->db->query("SELECT count(*) as c FROM Cert_Application WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and LM_Checked_yn='Y' and CO_Checked_yn is null and status = 'C' and apply_date >= '$define_date'")->row()->c;

        $data['land_proposals'] = $this->db->query("SELECT count(*) as c FROM t_reclassification WHERE co_yn is null and dc_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status != 'R' OR status is null)")->row()->c;
        
        $data['g_trans_for_dc'] = $this->db->query("SELECT count(*) as c FROM t_reclassification WHERE co_yn = 'Y' and dc_yn is null and dc_approval is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status != 'R' OR status is null)")->row()->c;
        
        $data['land_proposals_returned_DC'] = $this->db->query("SELECT count(*) as c FROM t_reclassification WHERE co_yn = 'Y' and dc_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and dc_approval is not null and (status != 'R' OR status is null)")->row()->c;
        
        $data['land_proposals_for_jamaupdate'] = $this->db->query("SELECT count(*) as c FROM t_reclassification as t JOIN chitha_basic as c ON c.dist_code=t.dist_code and "
                        . "c.subdiv_code = t.subdiv_code and c.cir_code = t.cir_code and c.mouza_pargona_code=t.mouza_pargona_code and c.lot_no=t.lot_no and "
                        . "c.vill_townprt_code=t.vill_townprt_code and c.dag_no = t.dag_no and trim(c.patta_no) = trim(t.patta_no) and c.dist_code='$dist_code' and "
                        . "c.subdiv_code='$subdiv_code' and c.cir_code='$cir_code' and t.co_chitha_updated_yn = 'Y' and c.jama_yn != 'y'")->row()->c;

        $data['pending_objection'] = $this->db->query("Select count(*) as c from field_mut_objection where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and obj_flag is null and entry_date >= '$define_date' ")->row()->c;
        
        $data['proceedingPartRpt'] = $this->proceedingReportpart($user_code, $dist_code, $subdiv_code, $cir_code);
        
        $data['proceedingMutRpt'] = $this->proceedingReportofcmut($user_code, $dist_code, $subdiv_code, $cir_code, $year_no, $define_date);

        $data['name_correction'] = $this->db->query("SELECT count(*) as c FROM t_chitha_rmk_ordbasic WHERE ord_type_code = '05' and "
                        . "iscorrected_inco is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;
        
        $data['partchithaupdate'] = $this->db->query("SELECT count(*) as c FROM t_chitha_rmk_ordbasic WHERE ord_type_code = '04' and iscorrected_inco is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        //for miscellaneous cases i.e Name Correction
        $data['MisCases'] = $this->NameCorrectionModel->getMiscCases($user_code, $dist_code, $subdiv_code, $cir_code);
	
        $data['MisCasesNC'] = $this->NameCancellationModel->getMiscCasesNC($user_code, $dist_code, $subdiv_code, $cir_code);
        
        $data['FinalOrderMisc'] = $this->NameCorrectionModel->getFinalOrderMisc($user_code);
        
        $data['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
                        . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
                        . "loginuser_table.date_password_changed AS date_password_changed from users INNER JOIN loginuser_table ON "
                        . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
                        . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
                        . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
                        . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
                        . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();
        
//        $data['civil_appeal_basic'] = $this->db->query("SELECT count(*) as c FROM civil_appeal_basic WHERE co_order_yn is null and chitha_correct_yn is null and status = 'P' and"
//                . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;
        
        $date_of_last_password_changed = $data['my_info']->date_password_changed;
        if(strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
                $this->updatepasswordnow($user_code,$user_desig_code);
        }
        
        $this->load->view('header', $headtitle);
        $this->load->view('home/co', $data);
        $this->load->view('footer');
    }

    public function asoHome() {
        $user_code = $this->session->userdata('user_code');
        $user_desig_code=$this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
        
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        
        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';
        
        $data['map_partition'] = $this->db->query("Select count(*) as c from t_chitha_col8_order where map_partition is not null and "
                        . " order_type_code='02' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  "
                        . " and date(co_ord_date) >= '$define_date'  and iscorrected_inco is null")->row()->c;
        
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

        $data['sronote'] = $this->db->query("SELECT * FROM sro_note WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status!='3' and (deed_type='SALE' or deed_type='GIFT' )  order by update_date desc   ")->result();
        
        $data['allotment_first'] = $this->db->query("Select count(*) as c from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  not_fresh is null and status is null")->row()->c;
        
        $data['allotment_second'] = $this->db->query("Select count(*) as c from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  not_fresh='Y' and status='P' and co_note is not null")->row()->c;
        
        $data['allotment_final'] = $this->db->query("Select count(*) as c from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  status='F' and dc_code is not null and chitha_correct_yn is null ")->row()->c;

        $data['countAPCaseforCO'] = $this->APCancellationModel->getCountAPCasesforCO(); //not used location condition
        $data['countNoteHearingAPCaseforCO'] = $this->APCancellationModel->getNoteHearingAPCasesforCO(); //not used location condition
        $data['getOrderAPCancellation'] = $this->APCancellationModel->getOrderAPCancellation(); //not used location condition

        $data['fchithaupdates'] = $this->getPendingFieldChithaUpdates();
        $data['ochithaupdates'] = $this->getPendingOfficeChithaUpdates();

        $data['FirstPro'] = $this->db->query("SELECT count(*) as c FROM Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  and mut_type='04' and co_user_code='$user_code' and not_fresh is null and lm_note_yn is null and date_entry >= '$define_date' ")->row()->c;
        
        $data['SecondPro'] = $this->db->query("SELECT count(*) as c FROM Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  and co_user_code='$user_code' and not_fresh = 'Y' and status='P' and mut_type='04' and date_entry >= '$define_date' ")->row()->c;
        
        $data['citizenPendingCO'] = $this->db->query("SELECT count(*) as c FROM Cert_Application WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  and LM_Checked_yn='Y' and CO_Checked_yn is null and apply_date >= '$define_date'")->row()->c;

        $data['land_proposals'] = $this->db->query("SELECT count(*) as c FROM t_reclassification WHERE co_yn is null and dc_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status != 'R' OR status is null)")->row()->c;
        
        $data['g_trans_for_dc'] = $this->db->query("SELECT count(*) as c FROM t_reclassification WHERE co_yn = 'Y' and dc_yn is null and dc_approval is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status != 'R' OR status is null)")->row()->c;
        
        $data['land_proposals_returned_DC'] = $this->db->query("SELECT count(*) as c FROM t_reclassification WHERE co_yn = 'Y' and dc_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and dc_approval is not null and (status != 'R' OR status is null)")->row()->c;
        
        $data['land_proposals_for_jamaupdate'] = $this->db->query("SELECT count(*) as c FROM t_reclassification as t JOIN chitha_basic as c ON c.dist_code=t.dist_code and "
                        . "c.subdiv_code = t.subdiv_code and c.cir_code = t.cir_code and c.mouza_pargona_code=t.mouza_pargona_code and c.lot_no=t.lot_no and "
                        . "c.vill_townprt_code=t.vill_townprt_code and c.dag_no = t.dag_no and trim(c.patta_no) = trim(t.patta_no) and c.dist_code='$dist_code' and "
                        . "c.subdiv_code='$subdiv_code' and c.cir_code='$cir_code' and t.co_chitha_updated_yn = 'Y' and c.jama_yn != 'y'")->row()->c;

        $data['pending_objection'] = $this->db->query("Select count(*) as c from field_mut_objection where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and obj_flag is null and entry_date >= '$define_date' ")->row()->c;
        
        $data['proceedingPartRpt'] = $this->proceedingReportpart($user_code, $dist_code, $subdiv_code, $cir_code);
        
        $data['proceedingMutRpt'] = $this->proceedingReportofcmut($user_code, $dist_code, $subdiv_code, $cir_code, $year_no, $define_date);

        $data['name_correction'] = $this->db->query("SELECT count(*) as c FROM t_chitha_rmk_ordbasic WHERE ord_type_code = '05' and iscorrected_inco is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  ")->row()->c;
        
        $data['partchithaupdate'] = $this->db->query("SELECT count(*) as c FROM t_chitha_rmk_ordbasic WHERE ord_type_code = '04' and iscorrected_inco is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ")->row()->c;

        $data['MisCases'] = $this->NameCorrectionModel->getMiscCases($user_code, $dist_code, $subdiv_code, $cir_code);
	
        $data['MisCasesNC'] = $this->NameCancellationModel->getMiscCasesNC($user_code, $dist_code, $subdiv_code, $cir_code);
        
        $data['FinalOrderMisc'] = $this->NameCorrectionModel->getFinalOrderMisc($user_code);
        
        $data['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
                        . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
                        . "loginuser_table.date_password_changed AS date_password_changed from users INNER JOIN loginuser_table ON "
                        . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
                        . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
                        . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
                        . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
                        . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();
        
//        $data['civil_appeal_basic'] = $this->db->query("SELECT count(*) as c FROM civil_appeal_basic WHERE co_order_yn is null and chitha_correct_yn is null and status = 'P' and"
//                . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;
        
        $date_of_last_password_changed = $data['my_info']->date_password_changed;
        if(strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
                $this->updatepasswordnow($user_code,$user_desig_code);
        }
        
        $this->load->view('header', $headtitle);
        $this->load->view('home/aso', $data);
        $this->load->view('footer');
    }

    public function proceedingReportofcmut($user_code, $dist_code, $subdiv_code, $cir_code) {
        $year_no = year_no;
        $define_date = define_date;
        $query = "select count(*) as c from petition_basic where  add_off_name ='$user_code' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='03'  and date_entry >= '$define_date'  ";
        return $this->db->query($query)->row()->c;
    }

    public function proceedingReportpart($user_code, $dist_code, $subdiv_code, $cir_code) {
        $year_no = year_no;
        $define_date = define_date;
        $query = "select count(*) as c from petition_basic where  co_user_code = '$user_code' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='04'  and date_entry >= '$define_date'   ";
        return $this->db->query($query)->row()->c;
    }

    public function getPendingOfficePartitionCases($dist_code, $subdiv_code, $cir_code) {
        $year_no = year_no;
        $define_date = define_date;
        $query = "select count(*) as c from petition_basic where not_fresh is null and lm_note_yn is null and mut_type='04' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  and date_entry >= '$define_date'    ";
        return $this->db->query($query)->row()->c;
    }

    public function getPendingOfficeMutationCases($dist_code, $subdiv_code, $cir_code) {
        $year_no = year_no;
        $define_date = define_date;
        $query = "select count(*) as c from petition_basic where status is null and not_fresh is null and lm_note_yn is null and mut_type='03' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  and date_entry >= '$define_date'  ";
        return $this->db->query($query)->row()->c;
    }

    public function getPendingConversionCases($dsg, $dist_code, $subdiv_code, $cir_code) {
        $year_no = year_no;
        $define_date = define_date;
        $query = "select count(*) as c from petition_basic where not_fresh is null and (status is null or status = 'P') and lm_note_yn is null and co_user_code = '$dsg' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='01'  and date_entry >= '$define_date'   ";
        return $this->db->query($query)->row()->c;
    }

    public function getFirstProceedingConvertion($dsg, $dist_code, $subdiv_code, $cir_code) {
        $year_no = year_no;
        $define_date = define_date;
        $query = "select count(*) as c from petition_basic where not_fresh is null and lm_note_yn is null and (status is null or status = 'P') and co_user_code = '$dsg' and mut_type='01' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  and date_entry >= '$define_date'  ";
        return $this->db->query($query)->row()->c;
    }

    public function getSecondProceedingConvertion($dsg, $dist_code, $subdiv_code, $cir_code) {
        $year_no = year_no;
        $define_date = define_date;
        $query = "select count(*) as c from petition_basic where not_fresh = 'Y' and status = 'P' and mut_type='01' and co_user_code = '$dsg' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'   and date_entry >= '$define_date'  ";
        return $this->db->query($query)->row()->c;
    }

    public function getRejectedProceedingConvertion($dsg, $dist_code, $subdiv_code, $cir_code) {
        $year_no = year_no;
        $define_date = define_date;
        $query = "select count(*) as c from petition_basic where not_fresh = 'Y' and status = 'R' and mut_type='01' and co_user_code = '$dsg' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'   and date_entry >= '$define_date'  ";
        return $this->db->query($query)->row()->c;
    }

    public function getconversion_proceeding_report($dsg, $dist_code, $subdiv_code, $cir_code) {
        $year_no = year_no;
        $define_date = define_date;
        $query = "select count(*) as c from petition_basic where mut_type = '01' and status != 'B' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'   and date_entry >= '$define_date' ";
        return $this->db->query($query)->row()->c;
    }
    
    public function getConvertionOrderPassedByDC($dsg, $dist_code, $subdiv_code, $cir_code) {
        $year_no = year_no;
        $define_date = define_date;
        $query = "select count(*) as c from petition_basic where not_fresh = 'Y' and status = 'W' and mut_type='01' and add_off_desig = '$dsg' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'   and date_entry >= '$define_date'  ";
        return $this->db->query($query)->row()->c;
    }

    public function getFisrtProceedingMutation($dsg, $dist_code, $subdiv_code, $cir_code) {
        $year_no = year_no;
        $define_date = define_date;
        $query = "select count(*) as c from petition_basic where status is null and not_fresh is null and lm_note_yn is null and mut_type='03' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  and date_entry >= '$define_date' ";
        return $this->db->query($query)->row()->c;
    }

    public function getSecondProceedingMutation($dsg, $dist_code, $subdiv_code, $cir_code) {
        $year_no = year_no;
        $define_date = define_date;
        $query = "select count(*) as c from petition_basic where not_fresh='Y' and status='P' and mut_type='03' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  and date_entry >= '$define_date' ";
        return $this->db->query($query)->row()->c;
    }

    public function getFisrtProceedingPartition($dsg, $dist_code, $subdiv_code, $cir_code) {
        $year_no = year_no;
        $define_date = define_date;
        $query = "select count(*) as c from petition_basic where not_fresh is null and lm_note_yn is null and mut_type='04' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  and date_entry >= '$define_date' ";
        return $this->db->query($query)->row()->c;
    }

    public function getSecondProceedingPartition($dsg, $dist_code, $subdiv_code, $cir_code) {
        $year_no = year_no;
        $define_date = define_date;
        $query = "select count(*) as c from petition_basic where not_fresh='Y' and status='P' and mut_type='04' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  and date_entry >= '$define_date' ";
        return $this->db->query($query)->row()->c;
    }

    public function lmHome() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $user_code = $this->session->userdata('user_code');
        $year_no = year_no;
        $define_date = define_date;
        $user_desig_code=$this->session->userdata('user_desig_code');

        $counts['map_partition'] = $this->db->query("Select count(*) as c from t_chitha_col8_order where map_partition is null and order_type_code='02' and "
                . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' "
                . "and lot_no = '$lot_no'  and date(co_ord_date) >= '$define_date' ")->row()->c;
        
        $counts['fconsent'] = $this->db->query("select count(*) as c from field_mut_basic where order_passed is null and mut_type='02' and p_consent is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'  and date_entry >= '$define_date' ")->row()->c;

        $counts['fmutation'] = $this->db->query("select count(*) as c from field_mut_basic where order_passed is null and mut_type='01' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'  and date_entry >= '$define_date' ")->row()->c;

        $counts['fpartition'] = $this->db->query("select count(*) as c from field_mut_basic where order_passed is null and mut_type='02' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'  and date_entry >= '$define_date'")->row()->c;

        $counts['oconsent'] = $this->db->query("select count(*) as c from petition_basic where order_passed is null and mut_type='04' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'  and date_entry >= '$define_date'")->row()->c;

        $counts['omutation'] = $this->db->query("select count(*) as c from petition_basic where order_passed is null and not_fresh='Y' and lm_note_date is null and "
                . "sk_comment is null and mut_type='03' and status='P' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code'  and date_entry >= '$define_date'")->row()->c;

        $counts['opartition'] = $this->db->query("select count(*) as c from petition_basic where order_passed is null  and date_entry >= '$define_date' and not_fresh='Y' and status='P' and lm_note_date is null and sk_comment is null and mut_type='04' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'")->row()->c;

        $counts['allotment_lm'] = $this->db->query("Select count(*) as c from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and lm_note is null and not_fresh='Y' and status='P' and co_note is not null")->row()->c;

        $counts['sronotepen'] = $this->db->query("SELECT count(*) as c FROM sro_note WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and status='1' and nature_of_land = 'r'")->row()->c;

        $counts['oconversion'] = $this->db->query("select count(*) as c from petition_basic where order_passed is null  and "
                        . "date_entry >= '$define_date' and not_fresh='Y' and lm_note_date is null and sk_comment is null and mut_type='01' and "
                        . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'")->row()->c;

        $counts['freshreport'] = $this->db->query("select count(*) as c from field_mut_basic where co_flag_for_fresh_mut is not null and dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'")->row()->c;

        $counts['ofcPartition'] = $this->db->query("SELECT count(*) as c FROM Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code'  and date_entry >= '$define_date' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and mut_type='04' and  not_fresh='Y' and status='P' and (lm_note_yn is null ) and (lm_note_date is null) ")->row()->c;

        $counts['ofcByayPrak'] = $this->db->query("SELECT count(*) as c FROM Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code'  and date_entry >= '$define_date' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and  mut_type='04' and not_fresh='Y' and status='P' and byayprak_yn is null ")->row()->c;
        
        $counts['mappartition'] = $this->db->query("SELECT count(*) as c FROM chitha_rmk_ordbasic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and  ord_type_code='04' and map_partition='P' ")->row()->c;
        
        $counts['CitizenCentric'] = $this->db->query("SELECT count(*) as c FROM Cert_Application WHERE LM_Checked_yn is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and apply_date >='$define_date'  and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no'")->row()->c;

        $counts['ConsentPattadar'] = $this->db->query("SELECT count(*) as c FROM Petition_Basic pb INNER JOIN (SELECT dist_code, subdiv_code, cir_code, mouza_pargona_code,"
                        . " Lot_No, vill_townprt_code, Year_no, Petition_no,Patta_no, patta_type_code,dag_no FROM petitioner_part GROUP BY dist_code, subdiv_code, "
                        . "cir_code, mouza_pargona_code, Lot_No, vill_townprt_code, Year_no, Petition_no, Patta_no,patta_type_code,dag_no) pp ON pb.dist_code = pp.dist_code AND "
                        . "pb.subdiv_code = pp.subdiv_code AND pb.cir_code = pp.cir_code AND pb.mouza_pargona_code = pp.mouza_pargona_code AND pb.Lot_No = pp.Lot_No "
                        . "AND pb.vill_townprt_code = pp.vill_townprt_code AND pb.Year_no = pp.Year_no AND pb.Petition_no = pp.Petition_no WHERE pb.dist_code='$dist_code' and pb.subdiv_code='$subdiv_code'  and pb.year_no='$year_no' and pb.date_entry >= '$define_date' and pb.cir_code='$cir_code' and pb.mouza_pargona_code='$mouza_pargona_code' and pb.lot_no='$lot_no' and  pb.mut_type='04' and pb.status='P' and pb.consent_updated is null ")->row()->c;

        $counts['oconv'] = $this->getPendingLMConversionCases($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        $counts['countAPCase'] = $this->APCancellationModel->getCountAPCasesforLM($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no); //not done with the location checking
        //adding it for miscellaneous cases
        $counts['countMiscCase'] = $this->NameCorrectionModel->getMiscCaseLM($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no); //not done with the location checking

        $counts['my_info'] = $this->db->query("Select lm_code.lm_name AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
                        . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
                        . "loginuser_table.date_password_changed AS date_password_changed, lm_code.corres_sk_code AS corres_sk_code from lm_code INNER JOIN loginuser_table ON "
                        . "lm_code.lm_code = loginuser_table.user_code and lm_code.dist_code = loginuser_table.dist_code and "
                        . "lm_code.subdiv_code = loginuser_table.subdiv_code and lm_code.cir_code = loginuser_table.cir_code and "
                        . "lm_code.mouza_pargona_code = loginuser_table.mouza_pargona_code and lm_code.lot_no = loginuser_table.lot_no "
                        . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
                        . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
                        . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();
        
//        $counts['civil_appeal_basic'] = $this->db->query("SELECT count(*) as c FROM civil_appeal_basic WHERE lm_sign is null and dist_code='$dist_code' and "
//                . "subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no'")->row()->c;

        $date_of_last_password_changed = $counts['my_info']->date_password_changed;
        if(strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
                $this->updatepasswordnow($user_code,$user_desig_code);
        }
        
        $this->load->view('header');
        $this->load->view('home/lm', $counts);
        $this->load->view('footer');
    }

    public function getPendingLMConversionCases($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no) {
        $year_no = year_no;
        $define_date = define_date;
        $query = "select count(*) as c from petition_basic where not_fresh = 'Y'  and date_entry >= '$define_date' "
                . "and lm_note_yn is null and status = 'P' and mut_type='01' and dist_code='$dist_code' and "
                . "subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code ='$mouza_pargona_code' and lot_no='$lot_no'";
        return $this->db->query($query)->row()->c;
    }

    public function skHome() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');
        $year_no = year_no;
        $define_date = define_date;

        $append = "dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code'";
        
        $counts['fmutation'] = $this->db->query("select count(*) as c from field_mut_basic where order_passed is null and sk_flag is null and mut_type='01'  and date_entry >= '$define_date' and " . $append)->row()->c;

        $counts['fpartition'] = $this->db->query("select  count(*) as c from field_mut_basic where order_passed is null and sk_flag is null and mut_type='02'and dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $counts['omutation'] = $this->db->query("SELECT count(*) as c FROM Petition_basic WHERE  not_fresh='Y' and sk_comment is null and  lm_note_date is not null and order_passed is null and mut_type='01'  and date_entry >= '$define_date' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $counts['oconversion'] = $this->db->query("SELECT count(*) as c FROM Petition_basic WHERE  not_fresh='Y' and sk_comment is null and  lm_note_date is not null and order_passed is null and mut_type='01'  and date_entry >= '$define_date' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $counts['omutation'] = $this->db->query("SELECT count(*) as c FROM Petition_basic WHERE  not_fresh='Y' and sk_comment is null and  lm_note_date is not null and order_passed is null and mut_type='03' and dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;

        $counts['opartition'] = $this->db->query("SELECT count(*) as c FROM Petition_basic WHERE  not_fresh='Y' and sk_comment is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  lm_note_date is not null and order_passed is null and mut_type='04' and dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;
        
        $counts['cases'] = $this->db->query("select count(*) as c from petition_basic where not_fresh = 'Y'  and date_entry >= '$define_date' and lm_note_yn = 'Y' and status = 'P' and sk_comment is null and mut_type='01' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->c;
        
        $counts['allotment_sk'] = $this->db->query("Select count(*) as c from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and lm_note='Y' and sk_note is null and not_fresh='Y' and status='P' and co_note is not null")->row()->c;

        $counts['countAPCaseforSK'] = $this->APCancellationModel->getCountAPCasesforSK(); //not done with the location checking
        //adding it for miscellaneous cases
        $counts['countMiscCaseSK'] = $this->NameCorrectionModel->getMiscCaseSK($user_code); //not done with the location checking

        $counts['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
                        . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
                        . "loginuser_table.date_password_changed AS date_password_changed from users INNER JOIN loginuser_table ON "
                        . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
                        . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
                        . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
                        . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.user_code = '$user_code'")->row();
		
        $date_of_last_password_changed = $counts['my_info']->date_password_changed;
        if(strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
                $this->updatepasswordnow($user_code,$user_desig_code);
        }
        
        $this->load->view('header');
        $this->load->view('home/sk', $counts);
        $this->load->view('footer');
    }

    public function dcHome() {
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = '00';
        $cir_code = '00';
        $mouza_pargona_code = '00';
        $lot_no = '00';

        $year_no = year_no;
        $define_date = define_date;
        $counts['sronote'] = $this->db->query("SELECT * FROM sro_note WHERE dist_code='$dist_code' and (deed_type='SALE' or deed_type='GIFT' ) limit 10")->result();
        
        $counts['getDCAPCancellation'] = $this->APCancellationModel->getDCAPCancellationMatter();
        $counts['recommended_reclassification_DC'] = $this->db->query("SELECT count(*) as c FROM t_reclassification WHERE co_yn = 'Y' and dc_yn is null and dc_approval is null and (status != 'R' OR status is null)")->row()->c;
        $counts['reverted_reclassification_DC'] = $this->db->query("SELECT count(*) as c FROM t_reclassification WHERE co_yn = 'Y' and dc_approval is not null and dc_yn is null and co_chitha_updated_yn is null and (status != 'R' OR status is null)")->row()->c;

        $counts['first_proceeding_for_dc'] = $this->db->query("select count(*) as c from petition_basic where add_off_desig = '$user_desig_code' and bo_note_yn is null and co_user_code = '$user_code' and mut_type='01' and dist_code='$dist_code' and proceeding_yn is not null and bo_notice_gen is null")->row()->c;

        $counts['second_proceeding_for_dc'] = $this->db->query("select count(*) as c from petition_basic where not_fresh = 'Y' and status = 'P' and add_off_desig = '$user_desig_code' and co_user_code = '$user_code' and mut_type='01' and dist_code='$dist_code' and bo_note_yn is not null")->row()->c;
		
        $counts['allote_dc'] = $this->db->query("select count(*) as c from allotment_cert_basic where status = 'R' and co_code is not null and dist_code='$dist_code' and bo_note is null and dc_code is null")->row()->c;
        
        $counts['allote_dc_bo'] = $this->db->query("select count(*) as c from allotment_cert_basic where status = 'R' and co_code is not null and dist_code='$dist_code' and bo_note is not null and dc_note is not null")->row()->c;
        
        //$counts['appeal_count'] = $this->db->query("select count(*) as c from civil_appeal_basic where dist_code='$dist_code' and status = 'P' and order_type='12' and next_hearing_date is null and dc_order_yn is null ")->row()->c;
		
        $counts['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
                        . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
                        . "loginuser_table.date_password_changed AS date_password_changed from users INNER JOIN loginuser_table ON "
                        . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
                        . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
                        . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
                        . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
                        . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();
        
        $date_of_last_password_changed = $counts['my_info']->date_password_changed;
        if(strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
                $this->updatepasswordnow($user_code,$user_desig_code);
        }
                
        $this->load->view('header');
        $this->load->view('home/dc', $counts);
        $this->load->view('footer');
    }

    public function adcHome() {
        //var_dump($this->session->all_userdata());
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = '00';
        $cir_code = '00';
        $mouza_pargona_code = '00';
        $lot_no = '00';

        $year_no = year_no;
        $define_date = define_date;
        $counts['sronote'] = $this->db->query("SELECT * FROM sro_note WHERE dist_code='$dist_code' and (deed_type='SALE' or deed_type='GIFT' ) limit 10")->result();
        
        $counts['getDCAPCancellation'] = $this->APCancellationModel->getDCAPCancellationMatter();
        $counts['recommended_reclassification_DC'] = $this->db->query("SELECT count(*) as c FROM t_reclassification WHERE co_yn = 'Y' and dc_yn is null and dc_approval is null and (status != 'R' OR status is null)")->row()->c;
        $counts['reverted_reclassification_DC'] = $this->db->query("SELECT count(*) as c FROM t_reclassification WHERE co_yn = 'Y' and dc_approval is not null and dc_yn is null and co_chitha_updated_yn is null and (status != 'R' OR status is null)")->row()->c;

        $counts['first_proceeding_for_adc'] = $this->db->query("select count(*) as c from petition_basic where add_off_desig = '$user_desig_code' and bo_note_yn is null and co_user_code = '$user_code' and  mut_type='01' and dist_code='$dist_code' and proceeding_yn is not null and bo_notice_gen is null")->row()->c;

        $counts['second_proceeding_for_adc'] = $this->db->query("select count(*) as c from petition_basic where not_fresh = 'Y' and status = 'P' and add_off_desig = '$user_desig_code' and co_user_code = '$user_code' and mut_type='01' and dist_code='$dist_code' and bo_note_yn is not null")->row()->c;
		
        $counts['first_proceeding_for_dc'] = $this->db->query("select count(*) as c from petition_basic where add_off_desig = '$user_desig_code' and bo_note_yn is null and co_user_code = '$user_code' and mut_type='01' and dist_code='$dist_code' and proceeding_yn is not null and bo_notice_gen is null")->row()->c;

        $counts['second_proceeding_for_dc'] = $this->db->query("select count(*) as c from petition_basic where not_fresh = 'Y' and status = 'P' and add_off_desig = '$user_desig_code' and co_user_code = '$user_code' and mut_type='01' and dist_code='$dist_code' and bo_note_yn is not null")->row()->c;
		
        $counts['allote_dc'] = $this->db->query("select count(*) as c from allotment_cert_basic where status = 'R' and co_code is not null and dist_code='$dist_code' and bo_note is null and dc_code is null")->row()->c;
	
        $counts['allote_dc_bo'] = $this->db->query("select count(*) as c from allotment_cert_basic where status = 'R' and co_code is not null and dist_code='$dist_code' and bo_note is not null and dc_note is not null")->row()->c;
		
        $counts['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
                        . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
                        . "loginuser_table.date_password_changed AS date_password_changed from users INNER JOIN loginuser_table ON "
                        . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
                        . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
                        . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
                        . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
                        . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();
		
        $date_of_last_password_changed = $counts['my_info']->date_password_changed;
        if(strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
                $this->updatepasswordnow($user_code,$user_desig_code);
        }
        
        $this->load->view('header');
        $this->load->view('home/adc', $counts);
        $this->load->view('footer');
    }

    public function laoHome() {
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
        $counts['recommended_reclassification_DC'] = $this->db->query("SELECT count(*) as c FROM t_reclassification WHERE co_yn = 'Y' and dc_yn is null and (status != 'R' OR status is null)")->row()->c;
        $counts['g_trans_for_Co'] = $this->db->query("SELECT count(*) as c FROM t_reclassification WHERE co_yn = 'Y' and dc_yn = 'Y' and co_chitha_updated_yn is null and (status != 'R' OR status is null)")->row()->c;

        $counts['sronote'] = $this->db->query("SELECT * FROM sro_note WHERE dist_code='$dist_code' and (deed_type='SALE' or deed_type='GIFT' )")->result();
        
        $counts['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
                        . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
                        . "loginuser_table.date_password_changed AS date_password_changed from users INNER JOIN loginuser_table ON "
                        . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
                        . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
                        . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
                        . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
                        . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();
        
        $date_of_last_password_changed = $counts['my_info']->date_password_changed;
        if(strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
                $this->updatepasswordnow($user_code,$user_desig_code);
        }
        
        $this->load->view('header');
        $this->load->view('home/lao', $counts);
        $this->load->view('footer');
    }
    
    public function astHome() {
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $define_date = define_date;

        $query = "SELECT count(*) as c FROM Petition_basic where not_fresh='Y' and status='P' and notice_generated_yn is null and mut_type='03' and  dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
        $counts['pnotice'] = $this->db->query($query)->row()->c;

        $query = "SELECT count(*) as c FROM Petition_basic where not_fresh='Y' and status = 'P' and proceeding_yn is null and mut_type='03'  and date_entry >= '$define_date' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
        $counts['pactiontaken'] = $this->db->query($query)->row()->c;

        $query = "SELECT count(*) as c FROM Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  and date_entry >= '$define_date'  and pay_notice_gen_yn='Y' and status='P' and not_fresh='Y' and mut_type='04' and petition_no in ( SELECT petition_no FROM Petition_byayprak WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and if_paid is null ) ";
        $counts['byayPrak'] = $this->db->query($query)->row()->c;

        $query = "SELECT count(*) as c FROM Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and not_fresh='Y' and status ='P' and mut_type='04' and (notice_generated_yn is null or notice_generated_yn='' )  and date_entry >= '$define_date' ";
        $counts['NoticeGen'] = $this->db->query($query)->row()->c;

        $counts['sronote'] = $this->db->query("SELECT * FROM sro_note WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (deed_type='SALE' or deed_type='GIFT') and status='1' limit 10")->result();
        
        $counts['sronotepen'] = $this->db->query("SELECT count(*) as c FROM sro_note WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='1' and (nature_of_land != 'r' or nature_of_land is null)")->row()->c;

        $query = "SELECT count(*) as c FROM Petition_basic WHERE dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and not_fresh='Y' and status ='P' and mut_type='04' and pay_notice_gen_yn ='Y' and  notice_served_yn!='Y'  ";
        $counts['PayNoticeGen'] = $this->db->query($query)->row()->c;

        $query = "SELECT count(*) as c FROM Petition_basic WHERE dist_code='$dist_code'  and date_entry >= '$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and not_fresh='Y' and status ='P' and mut_type='04' and (proceeding_yn is null or proceeding_yn='')";
        $counts['ProceedingOrder'] = $this->db->query($query)->row()->c;
		
        $sql= "SELECT case_no from petitioner_part pb WHERE pb.dist_code='$dist_code' and pb.subdiv_code='$subdiv_code' and pb.cir_code='$cir_code'  ";
		
        $query = "SELECT count(case_no) as c FROM Petition_Basic as pb WHERE pb.dist_code='$dist_code' and pb.subdiv_code='$subdiv_code' and pb.cir_code='$cir_code' and pb.mut_type='04' and pb.order_passed='Y' and pb.status='F' and pb.isthar_update is null and case_no in ($sql) ";
        $counts['Isthar'] = $this->db->query($query)->row()->c;

        $sql = "Select count(*) as c from cert_application WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='R' and apply_date >='$define_date'   ";
        $counts['citizenpending'] = $this->db->query($sql)->row()->c;

        $counts['countAPCaseShowCauseForAST'] = $this->APCancellationModel->countAPCaseShowCauseForAST($user_code, $dist_code, $subdiv_code, $cir_code); //not done with location checking
        $counts['NoticeGenerate'] = $this->NameCancellationModel->getNoticeGenerateMiscCase($user_code, $dist_code, $subdiv_code, $cir_code); //not done with location checking
        $counts['ConfirmNoticeGenerate'] = $this->NameCancellationModel->getConfirmNoticeGenerate($user_code, $dist_code, $subdiv_code, $cir_code); //not done with location checking

        $counts['Pcases'] = $this->getPendingASTNoticeGeneratedConversionCases($user_code, $dist_code, $subdiv_code, $cir_code);
        $counts['cases'] = $this->getPendingASTActionTakenConversionCases($user_code, $dist_code, $subdiv_code, $cir_code);
        $counts['premium'] = $this->getPendingASTPremiumConversionCases($user_code, $dist_code, $subdiv_code, $cir_code);
        $counts['payment'] = $this->getPendingASTPaymentConversionCases($user_code, $dist_code, $subdiv_code, $cir_code);

        $counts['NameCorrectionNoticeGenerate'] = $this->getPendingASTNoticeGeneratedNameCorrection($user_code, $dist_code, $subdiv_code, $cir_code);
        $counts['NameCorrectionActionTaken'] = $this->getPendingASTActionTakenNameCorrection($user_code, $dist_code, $subdiv_code, $cir_code);
		
		$counts['CountJamaNakalOnline'] = $this->ServicePlusModel->count_online_ror_cases($user_code, $dist_code, $subdiv_code, $cir_code);
		$counts['CountMutationOnline'] = $this->ServicePlusModel->count_online_mutation_cases($user_code, $dist_code, $subdiv_code, $cir_code);

        $counts['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
                        . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
                        . "loginuser_table.date_password_changed AS date_password_changed from users INNER JOIN loginuser_table ON "
                        . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
                        . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
                        . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
                        . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.user_code = '$user_code'")->row();
		
        $date_of_last_password_changed = $counts['my_info']->date_password_changed;
        if(strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
                $this->updatepasswordnow($user_code,$user_desig_code);
        }
        
        $this->load->view('header');
        $this->load->view('home/ast', $counts);
        $this->load->view('footer');
    }

    public function getPendingASTNoticeGeneratedNameCorrection($user_code, $dist_code, $subdiv_code, $cir_code) {
        $year_no = year_no;
        $define_date = define_date;
        $query = "select count(*) as c from misc_case_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lm_note_yn is null"
                . "  and submission_date >= '$define_date' and status='18' and sk_note_yn is null and notice_generated_yn is null ";
        return $this->db->query($query)->row()->c;
    }

    public function getPendingASTActionTakenNameCorrection($user_code, $dist_code, $subdiv_code, $cir_code) {
        $year_no = year_no;
        $define_date = define_date;
        $query = "select count(*) as c from misc_case_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and dag_no is not null"
                . "  and submission_date >= '$define_date' and status='18' and notice_generated_yn='Y' and notice_generated_date is not null";
        return $this->db->query($query)->row()->c;
    }

    public function getPendingASTNoticeGeneratedConversionCases($user_code, $dist_code, $subdiv_code, $cir_code) {
        $year_no = year_no;
        $define_date = define_date;
        $query = "select count(*) as c from petition_basic where not_fresh = 'Y'  and date_entry >= '$define_date' and user_code = '$user_code' and "
                . "notice_generated_yn is null and status = 'P' and mut_type = '01' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
        return $this->db->query($query)->row()->c;
    }

    public function getPendingASTActionTakenConversionCases($user_code, $dist_code, $subdiv_code, $cir_code) {
        $year_no = year_no;
        $define_date = define_date;
        $query = "select count(*) as c from petition_basic where not_fresh = 'Y'  and date_entry >= '$define_date' and user_code = '$user_code' and "
                . "proceeding_yn is null and status = 'P' and mut_type = '01' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
        return $this->db->query($query)->row()->c;
    }

    public function getPendingASTPremiumConversionCases($user_code, $dist_code, $subdiv_code, $cir_code) {
        $year_no = year_no;
        $define_date = define_date;
        $query = "select count(*) as c from petition_basic where not_fresh = 'Y'  and date_entry >= '$define_date' and status = 'P' and user_code = '$user_code' "
                . "and mut_type = '01' and co_order_conv_premium = 'Y' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and co_order_conv_notice is not null";
        return $this->db->query($query)->row()->c;
    }

    public function getPendingASTPaymentConversionCases($user_code, $dist_code, $subdiv_code, $cir_code) {
        $year_no = year_no;
        $define_date = define_date;
        $query = "select count(*) as c from petition_basic where not_fresh = 'Y'  and date_entry >= '$define_date' and user_code = '$user_code' and "
                . "status = 'P' and mut_type = '01' and co_order_conv_premium = 'Y' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
        return $this->db->query($query)->row()->c;
    }

    public function getPendingFieldChithaUpdates() {
        $location = $this->utilityclass->getLocationFromSession();
        $query = "select count(*) as c from t_chitha_col8_order where dist_code='$location[dist_code]' and "
                . "subdiv_code='$location[subdiv_code]' and cir_code='$location[cir_code]' and iscorrected_inco is null";
        return $this->db->query($query)->row()->c;
    }

    public function getPendingOfficeChithaUpdates() {
        $location = $this->utilityclass->getLocationFromSession();
        $query = "select count(*) as c from t_chitha_rmk_ordbasic where dist_code='$location[dist_code]' and "
                . "subdiv_code='$location[subdiv_code]' and cir_code='$location[cir_code]' and iscorrected_inco is null";
        return $this->db->query($query)->row()->c;
    }

    public function MasterHome() {
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

        $this->load->view('header');
        $this->load->view('home/admin', $data);
        $this->load->view('footer');
    }

    public function BoHome() {
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = '00';
        $cir_code = '00';
        $mouza_pargona_code = '00';
        $lot_no = '00';

        $counts['bo_notice'] = $this->getPendingBoNoticeGeneratedConversionCases($user_code, $dist_code);
        $counts['premium'] = $this->getPendingASTPremiumConversionCasesDC($user_code, $dist_code);
        $counts['payment'] = $this->getPendingASTPaymentConversionCasesDC($user_code, $dist_code);
        $counts['cases'] = $this->getPendingASTActionTakenConversionCasesDC($user_code, $dist_code);

        $counts['sronote'] = $this->db->query("SELECT * FROM sro_note WHERE dist_code='$dist_code' and (deed_type='SALE' or deed_type='GIFT' ) limit 10")->result();

        $counts['sronotepen'] = $this->db->query("SELECT count(*) as c FROM sro_note WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'"
                        . " and status='1'")->row()->c;
						
        $counts['allote_bo'] = $this->db->query("select count(*) as c from allotment_cert_basic where status = 'R' and co_code is not null and dist_code='$dist_code' and dc_note is not null and bo_note is null")->row()->c;
		

        $counts['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
                        . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
                        . "loginuser_table.date_password_changed AS date_password_changed from users INNER JOIN loginuser_table ON "
                        . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
                        . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
                        . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
                        . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
                        . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();
		
        $date_of_last_password_changed = $counts['my_info']->date_password_changed;
        if(strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
                $this->updatepasswordnow($user_code,$user_desig_code);
        }
        
        $this->load->view('header');
        $this->load->view('home/bo', $counts);
        $this->load->view('footer');
    }

    public function getPendingBoNoticeGeneratedConversionCases($user_code, $dist_code) {
        $year_no = year_no;
        $define_date = define_date;
        $query = "select count(*) as c from petition_basic where not_fresh = 'Y'  and date_entry >= '$define_date' "
                . "and user_code = '$user_code' and bo_note_yn is null and status = 'P' and mut_type = '01' and dist_code='$dist_code'";
        return $this->db->query($query)->row()->c;
    }

    public function rkgHome() {
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = '00';
        $mouza_pargona_code = '00';
        $lot_no = '00';

        $counts['my_info'] = $this->db->query("select users.username AS username,loginuser_table.use_name AS use_name,loginuser_table.password AS "
                        . "hashed_password,loginuser_table.user_code AS user_code,loginuser_table.first_login AS first_login,"
                        . "loginuser_table.date_password_changed AS date_password_changed from users INNER JOIN loginuser_table ON "
                        . "users.user_code = loginuser_table.user_code and users.dist_code = loginuser_table.dist_code and "
                        . "users.subdiv_code = loginuser_table.subdiv_code and users.cir_code = loginuser_table.cir_code "
                        . "where loginuser_table.dist_code = '$dist_code' and loginuser_table.subdiv_code = '$subdiv_code' "
                        . "and loginuser_table.cir_code = '$cir_code' and loginuser_table.mouza_pargona_code = '$mouza_pargona_code'"
                        . " and loginuser_table.lot_no = '$lot_no' and loginuser_table.user_code = '$user_code'")->row();
		
        $date_of_last_password_changed = $data['my_info']->date_password_changed;
        if(strtotime($date_of_last_password_changed) < strtotime('-30 days')) {
                $this->updatepasswordnow($user_code,$user_desig_code);
        }
        
        $this->load->view('header');
        $this->load->view('home/rkg', $counts);
        $this->load->view('footer');
    }

    public function getPendingASTActionTakenConversionCasesDC($user_code, $dist_code) {
        $query = "select count(*) as c from petition_basic where not_fresh = 'Y' and user_code = '$user_code' and proceeding_yn is null and "
                . "status = 'P' and mut_type = '01' and dist_code='$dist_code'";
        return $this->db->query($query)->row()->c;
    }

    public function getPendingASTPremiumConversionCasesDC($user_code, $dist_code) {
        $query = "select count(*) as c from petition_basic where not_fresh = 'Y' and status = 'P' and user_code = '$user_code' and mut_type = '01' and "
                . "co_order_conv_premium = 'Y' and dist_code='$dist_code' and co_order_conv_notice is not null";
        return $this->db->query($query)->row()->c;
    }

    public function getPendingASTPaymentConversionCasesDC($user_code, $dist_code) {
        $query = "select count(*) as c from petition_basic where not_fresh = 'Y' and user_code = '$user_code' and status = 'P' and mut_type = '01' and "
                . "co_order_conv_premium = 'Y' and dist_code='$dist_code'";
        return $this->db->query($query)->row()->c;
    }

    public function jadHome() {
        $dist_code = $this->session->userdata('dist_code');
        $this->load->view('header');
        $this->load->view('home/jad');
        $this->load->view('footer');
    }

    public function sadHome() {
        $dist_code = $this->session->userdata('dist_code');
        $this->load->view('header');
        $this->load->view('home/sad');
        $this->load->view('footer');
    }

    public function deoHome() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        if(isset($_SESSION['basic_entry'])){
            unset($_SESSION['dagpattadar']);
            unset($_SESSION['pattadar']);
            unset($_SESSION['basic_entry']);
        }
		
        $sql="SElect * from chitha_basic_entry where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
        $data['basic']=$this->db->query($sql)->result();
        
        $this->load->view('../views/chitha_basic/header');
        $this->load->view('../views/chitha_basic/main',$data);
        $this->load->view('footer');
    }
	
    function updatepasswordnow($userid,$ucode){
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $sql="Update loginuser_table set first_login='Y' where user_code='$userid' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
        $this->db->query($sql);
    } 
    
    public function StateConsultantHome() {
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

        $this->load->view('header');
        $this->load->view('home/Madmin', $data);
        $this->load->view('footer');
    }
    
    public function update_dag_no_int(){
        $sql = "select * from chitha_basic where dist_code = '14' and subdiv_code = '01' and cir_code = '04' and mouza_pargona_code = '04' and 
            lot_no = '11' and vill_townprt_code = '10004'";
        $array=$this->db->query($sql)->result();
        foreach ($array as $value) {
            $dag_no_int = $value->dag_no.'00';
            
            $update = "update chitha_basic set dag_no_int = '$dag_no_int' where dist_code = '14' and subdiv_code = '01' and cir_code = '04' and mouza_pargona_code = '04' and 
            lot_no = '11' and vill_townprt_code = '10004' and dag_no = '$value->dag_no'";
            
            //$this->db->query($update);
            
        }
        
        
    }
    
}
