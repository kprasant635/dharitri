<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class dc_conversion_mb extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // Allowed designations
        $allowed = ['DC'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }
        
        $this->load->model('mutation/mutationmodel');
        $this->load->model('conversion/MbOfficeConversionModel');
        $this->load->model('basundhara/basundharamodel');
        $this->load->library('form_validation');
        $this->load->helper('html');
        $this->load->model('v2/SupportiveDocumentModel');
        $this->load->model('v2/PetitionBasicModel');
        $this->load->model('v2/PetitionProceedingDcAdcModel');
        $this->load->model('v2/PetitionDagDetailsModel');
        $this->load->model('v2/UsersModel');
        $this->load->model('v2/LoginUserTableModel');
        $this->load->model('v2/PetitionProceedingModel');
        $this->load->model('validation/FormValidationModel');
        $this->load->model('validation/AuthorizationModel');
        $this->load->model('v2/Services/Conversion/ConversionModel');
        $this->load->model('v2/BasundharApplicationModel');
        $this->load->model('AgriStackCaseHistory');
        $this->load->model('SettlementMb/SettlementMeetingDcInsModel');

        if(ENABLED_BLOCKCHAIN == 1)
        {
            $this->load->model('propChain/PropChainModel');
            $this->load->model('propChain/PropChainCommonModel');
        }
    }

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

    public function GoToDC() {
        //$db=  $this->session->userdata('db');
        $process = $this->input->get('pro');
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');

        if ($process == '3') {
            $config['total_rows'] = $this->MbOfficeConversionModel->countPendingConversionSecondCases_dc($user_code);
            $cases['cases'] = $this->MbOfficeConversionModel->getPendingConversionSecondCases_dc($user_code)->result();
        } elseif ($process == '2') {
            // $config['total_rows'] = $this->MbOfficeConversionModel->countPendingConversionSecondCases_adc($user_code);
            // $cases['cases'] = $this->MbOfficeConversionModel->getPendingConversionSecondCases_adc($user_code)->result();
            $config['total_rows'] = $this->MbOfficeConversionModel->countPendingConversionSecondCases_dc($user_code);
            $cases['cases'] = $this->MbOfficeConversionModel->getPendingConversionSecondCases_dc($user_code)->result();
        } elseif ($process == '1') {
            $config['total_rows'] = $this->MbOfficeConversionModel->countPendingConversionFirstCases_dc($user_code);
            $cases['cases'] = $this->MbOfficeConversionModel->getPendingConversionFirstCases_dc($user_code)->result();
        } elseif ($process == '4') {
            $config['total_rows'] = $this->MbOfficeConversionModel->countPendingConversionFirstCases_adc($user_code);
            $cases['cases'] = $this->MbOfficeConversionModel->getPendingConversionFirstCases_adc($user_code)->result();
        } elseif ($process == '5') {
            $config['total_rows'] = $this->MbOfficeConversionModel->countDepartmentPendingConversionSecondCasesDc($user_code);
            $cases['cases'] = $this->MbOfficeConversionModel->getDepartmentPendingConversionSecondCasesDc($user_code)->result();
        } elseif ($process == '6') {
            $config['total_rows'] = $this->MbOfficeConversionModel->countAppConversionSecondCases_adc_dpt($user_code);
            $cases['cases'] = $this->MbOfficeConversionModel->getAppConversionSecondCases_adc_dpt($user_code)->result();
        }
        else if($process == '7') {
            $config['total_rows'] = $this->MbOfficeConversionModel->countRevertCasesFromDpt($user_code);
            $cases['cases'] = $this->MbOfficeConversionModel->getRevertCasesFromDpt($user_code)->result();
        }

        //echo $config['total_rows'];
        $cases['process'] = $process;
        //var_dump($cases);
        $cases['branch_officer']=$this->db->query("Select users.username as username, users.user_desig_code as user_desig_code, loginuser_table.user_code as user_code from    users, "
            . "loginuser_table where users.dist_code = loginuser_table.dist_code "
            . "and users.user_code = loginuser_table.user_code and users.user_desig_code = 'BO' and users.dist_code='$dist_code' and "
            . "users.subdiv_code='00' and users.cir_code='00' and loginuser_table.dis_enb_option = 'E'")->result();

        $designation_code = $this->session->userdata('user_desig_code');
        $get_designation = $this->db->query("select user_desig_as as designation from    master_user_designation "
            . "where user_desig_code = '$designation_code'")->row()->designation;

        $cases['location'] = array(
            'designation_name' => $get_designation
        );
        $cases['_view'] = 'dc_adc_office_conversion/dc_conversion_cases_mb';
        $this->load->view('layouts/main',$cases);
    }

    public function PassToDC() {
        $case_no = $this->input->get('case_no');
        $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'ADC', $case_no);
        if($authorization['status'] == 'n') {
            //ERRCONVADCSECONDTODC001
            log_message('error', $authorization['messages'] . '. Error: ERRCONVADCSECONDTODC001');
            $this->session->set_flashdata('message', $authorization['messages'].'. Error: ERRCONVADCSECONDTODC001');
            redirect(base_url('index.php/home'));
        }
        // echo '<pre>';
        // var_dump($authorization);
        // die();
        $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');
        $this->session->set_userdata(array('subdiv_code1' => $subdiv_code));
        $this->session->set_userdata(array('cir_code1' => $cir_code));
        $this->session->set_userdata(array('mouza_pargona_code1' => $mouza_pargona_code));
        $this->session->set_userdata(array('lot_no1' => $lot_no));
        $this->session->set_userdata(array('vill_townprt_code1' => $vill_townprt_code));

        $dc_name = $this->db->query("Select users.username, loginuser_table.user_code, users.user_desig_code from    users, loginuser_table where users.dist_code = loginuser_table.dist_code "
            . "and users.user_code = loginuser_table.user_code and users.user_desig_code = 'DC' and users.dist_code='$dist_code' and "
            . "users.subdiv_code='00' and users.cir_code='00' and loginuser_table.dis_enb_option = 'E' and loginuser_table.priv = 'adm'")->row();

        $this->db->trans_begin();
        $this->db->query("UPDATE Petition_Basic SET add_off_desig = '$dc_name->user_desig_code', add_off_name = '$dc_name->username', status='P', co_user_code = '$dc_name->user_code' WHERE case_no = '$case_no' and "
            . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
            . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'");

        if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            log_message('error', '#ERRCONVDC0002: Updation failed in Petition_Basic Case No ' . $case_no);
            $data = array(
                'error' => "#ERRCONVDC0002: Registration of Petition basic failed for case no : " . $case_no,
            );
            echo json_encode($data);
            return false;
        }

        if ($this->db->trans_status() == false) {
            $this->db->trans_rollback();
            $data = array(
                'error' => "Error in submitting. Please try Again",
            );
        }
        else
        {
            $this->db->trans_commit();

            $this->session->set_flashdata('message', "Case no # $case_no has been forwarded to Deputy Commissioner");
            redirect(base_url() . "index.php/home");
        }
    }

    public function FirstProceedingOld() {
        $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');
        $this->session->set_userdata(array('subdiv_code1' => $subdiv_code));
        $this->session->set_userdata(array('cir_code1' => $cir_code));
        $this->session->set_userdata(array('mouza_pargona_code1' => $mouza_pargona_code));
        $this->session->set_userdata(array('lot_no1' => $lot_no));
        $this->session->set_userdata(array('vill_townprt_code1' => $vill_townprt_code));

        $data = array();
        $case_no = $this->input->get('case_no');
        $pb = $data['petition_basic'] = $this->db->query("select * from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and "
            . "subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
            . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row();
        $date = date('Y-m-d');
        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and "
            . "subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
            . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row();
        $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,add_off_name,add_off_desig,next_date_of_hearing "
            . "from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and "
            . "subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
            . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row_array();

        $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from    petition_dag_details where "
            . "dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and "
            . "lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' "
            . "and petition_no='$petition_basic->petition_no'")->row_array();
        $locationData = array(
            'dist_code' => $location['dist_code'],
            'subdiv_code' => $location['subdiv_code'],
            'cir_code' => $location['cir_code'],
            'lot_no' => $location['lot_no'],
            'vill_code' => $location['vill_townprt_code'],
            'mouza_pargona_code' => $location['mouza_pargona_code']
        );
        $data['l_data']=$locationData;
        $data['patta_type'] = $this->db->query("select patta_type from    patta_code "
            . " where type_code='$landdetails[patta_type_code]'")->row()->patta_type;
        $dist_code = $this->utilityclass->getDistrictName($location['dist_code']);
        $subdiv_code = $this->utilityclass->getSubDivName($location['dist_code'], $location['subdiv_code']);
        $cir_code = $this->utilityclass->getCircleName($location['dist_code'], $location['subdiv_code'], $location['cir_code']);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code']);
        $lot_no = $this->utilityclass->getLotName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no']);
        $vill_townprt_code = $this->utilityclass->getVillageName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $location['vill_townprt_code']);

        $m_dag_area_lc = $landdetails['m_dag_area_lc'];
        $m_dag_area_lc = round($m_dag_area_lc, 2);

        $designation_code = $location['add_off_desig'];
        $get_designation = $this->db->query("select user_desig_as as designation from    master_user_designation "
            . "where user_desig_code = '$designation_code'")->row()->designation;

        $data['location'] = array(
            'dist' => $dist_code,
            'sub' => $subdiv_code,
            'cir' => $cir_code,
            'mouza' => $mouza_pargona_code,
            'lot' => $lot_no,
            'vill' => $vill_townprt_code,
            'case_no' => $case_no,
            'date' => $date,
            'dag' => $landdetails['dag_no'],
            'm_dag_area_b' => $landdetails['m_dag_area_b'],
            'm_dag_area_k' => $landdetails['m_dag_area_k'],
            'm_dag_area_lc' => $m_dag_area_lc,
            'patta_no' => trim($landdetails['patta_no']),
            'patta_type' => $landdetails['patta_type_code'],
            'next_date' => $location['next_date_of_hearing'],
            'add_to' => $location['add_off_name'],
            'designation_name' => $get_designation
        );

        $convertion_code = CONVERSION_CODE;
        $data['conv_type'] = $this->db->query("select order_type from    master_office_mut_type "
            . " where order_type_code='$convertion_code'")->row()->order_type;

        $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from    petition_dag_details where "
            . "dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' "
            . "and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' "
            . "and petition_no='$petition_basic->petition_no'")->row_array();

        $m_dag_area_lc = $landdetails['m_dag_area_lc'];
        $m_dag_area_lc = round($m_dag_area_lc, 2);

        $data['land_details'] = array(
            'dag' => $landdetails['dag_no'],
            'm_dag_area_b' => $landdetails['m_dag_area_b'],
            'm_dag_area_k' => $landdetails['m_dag_area_k'],
            'm_dag_area_lc' => $m_dag_area_lc,
            'patta_no' => trim($landdetails['patta_no']),
            'patta_type' => $landdetails['patta_type_code']
        );

        $data['patta_type'] = $this->db->query("select patta_type from    patta_code "
            . " where type_code='$landdetails[patta_type_code]'")->row()->patta_type;

        $pattadardetails = "select pdar_name,pdar_guardian,pdar_rel_guar,pdar_add1,pdar_add2, inplace_alongwith from    petitioner_part where dist_code='$petition_basic->dist_code' "
            . "and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and "
            . "vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and "
            . "petition_no='$petition_basic->petition_no' and dag_no='$landdetails[dag_no]' and TRIM(patta_no)=trim('$landdetails[patta_no]') and patta_type_code= '$landdetails[patta_type_code]'";
        //echo $pattadardetails;
        $data['pattadar'] = $this->db->query($pattadardetails)->result();
        $data['p_in_order'] = $this->db->query($pattadardetails)->result();

        $lm_details = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
            . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and "
            . "mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' order by note_no desc limit 1 ")->row_array();

        if (count($lm_details) != '0') {
            $land = $lm_details['land_class_code'];
            $land_type = $this->db->query("Select * from    landclass_code where class_code = '$land'")->row();

            $prim_per_bigha = $lm_details['prim_per_bigha'];
            $prim_per_bigha = round($prim_per_bigha, 2);

            $prim_tot = $lm_details['prim_tot'];
            $prim_tot = round($prim_tot, 2);

            $data['lm_details'] = array(
                //'petition_no' => $lm_details[''],
                'dag_no' => $lm_details['dag_no'],
                'note_no' => $lm_details['note_no'],
                'partition_info' => $lm_details['partition_info'],
                //'user_code' => $lm_details[''],
                'date_entry' => $lm_details['date_entry'],
                //'operation' => $lm_details[''],
                'applicant_patta_yn' => $lm_details['applicant_patta_yn'],
                'occupied_yn' => $lm_details['occupied_yn'],
                'val_tree_yn' => $lm_details['val_tree_yn'],
                'dist_frm_town' => $lm_details['dist_frm_town'],
                'inside_outside_town' => $lm_details['inside_outside_town'],
                'land_class_code' => $land_type->land_type,
                'issuit_forconv_under105' => $lm_details['issuit_forconv_under105'],
                'roadside_rsv_b' => $lm_details['roadside_rsv_b'],
                'roadside_rsv_k' => $lm_details['roadside_rsv_k'],
                'roadside_rsv_lc' => $lm_details['roadside_rsv_lc'],
                'near_river_yn' => $lm_details['near_river_yn'],
                'prim_per_bigha' => $prim_per_bigha,
                'conv_b' => $lm_details['conv_b'],
                'conv_k' => $lm_details['conv_k'],
                'conv_lc' => $lm_details['conv_lc'],
                'prim_tot' => $prim_tot,
                'lm_sign_yn' => $lm_details['lm_sign_yn'],
                'case_no' => $case_no,
                'lm_code' => $lm_details['lm_code'],
                'sk_note_date' => $lm_details['sk_note_date'],
                'sk_note' => $lm_details['sk_note'],
                'sk_sign_yn' => $lm_details['sk_sign_yn'],
                'sk_name' => $lm_details['user_code'],
                'jati_janajati_yn' => $lm_details['jati_janajati_yn'],
                'jati_janajati_upload' => $lm_details['jati_janajati_upload'],
                'freedom_fighter_yn' => $lm_details['freedom_fighter_yn'],
                'freedom_fighter_upload' => $lm_details['freedom_fighter_upload'],
                'widow_yn' => $lm_details['widow_yn'],
                'widow_upload' => $lm_details['widow_upload'],
                'premium_assesment' => $lm_details['premium_assesment']
            );
        }
        $namelm = $this->db->query("select * from    lm_code where lm_code = '" . $lm_details['lm_code'] . "'  and dist_code = '" . $location['dist_code'] . "' and "
            . "subdiv_code = '" . $location['subdiv_code'] . "' and cir_code = '" . $location['cir_code'] . "' and mouza_pargona_code = '" . $location['mouza_pargona_code'] . "' "
            . "and lot_no = '" . $location['lot_no'] . "' ")->row();

        $data['lm_name'] = $namelm->lm_name;

        $skname = $this->db->query("select * from    users where user_code='" . $lm_details['user_code'] . "'  and dist_code = '" . $lm_details['dist_code'] . "' and "
            . "subdiv_code = '" . $lm_details['subdiv_code'] . "' and cir_code = '" . $lm_details['cir_code'] . "' ")->row();

        $data['sk_skname'] = $skname->username;

        $query = "select * from    petition_proceeding where case_no = '$case_no'";
        $data['cases'] = $this->db->query($query)->result();

        $dc_adc_order = "select * from    petition_proceeding_dc_adc where case_no = '$case_no' order by proceeding_id";
        $data['dc_adc_order'] = $this->db->query($dc_adc_order)->result();

        $data['lm_details_final'] = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
            . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and "
            . "mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' order by note_no desc limit 1")->result();
        //echo "Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'";
        $data['premium'] = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and "
            . "cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and "
            . "mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and "
            . "co_reject is NULL ORDER BY note_no DESC LIMIT 1")->result();

        $data['branch_officer']=$this->db->query("Select users.username as username, users.user_desig_code as user_desig_code, loginuser_table.user_code as user_code from    users, "
            . "loginuser_table where users.dist_code = loginuser_table.dist_code "
            . "and users.user_code = loginuser_table.user_code and users.user_desig_code = 'BO' and users.dist_code='$petition_basic->dist_code' and "
            . "users.subdiv_code='00' and users.cir_code='00' and loginuser_table.dis_enb_option = 'E'")->result();

        $user_desig_code = $this->session->userdata('user_desig_code');
        if($user_desig_code == 'ADC') {
            $data['post_url'] = 'index.php/dc_conversion_mb/FirstProceedingADC_save';
        }
        else if($user_desig_code == 'DC') {
            $data['post_url'] = 'index.php/dc_conversion_mb/FirstProceedingDC_save';
        }
        $this->session->set_userdata(array('case_no' => $case_no));
        $data['_view'] = 'dc_adc_office_conversion/first_proceeding';
        $this->load->view('layouts/main',$data);
    }

    public function FirstProceeding() {
        $db=  $this->session->userdata('db');
        //var_dump($this->session->all_userdata());
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');
        $this->session->set_userdata(array('subdiv_code1' => $subdiv_code));
        $this->session->set_userdata(array('cir_code1' => $cir_code));
        $this->session->set_userdata(array('mouza_pargona_code1' => $mouza_pargona_code));
        $this->session->set_userdata(array('lot_no1' => $lot_no));
        $this->session->set_userdata(array('vill_townprt_code1' => $vill_townprt_code));

        $data = array();
        $case_no = $this->input->get('case_no');

        $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'DC', $case_no, CONV_DC_FIRST);
        if($authorization['status'] == 'n') {
            //ERRCONVDCFIRSTVIEW0004
            log_message('error', $authorization['messages'] . '. Error: ERRCONVDCFIRSTVIEW0004');
            $this->session->set_flashdata('message', $authorization['messages'].'. Error: ERRCONVDCFIRSTVIEW0004');
            redirect(base_url('index.php/home'));
        }

        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and "
            . "subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
            . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row();
        $data['petition_basic']= $petition_basic;

        $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,date_entry,add_off_name,add_off_desig,next_date_of_hearing,sk_comment,petition_no "
            . "from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
            . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row_array();

        $petition_no = $location['petition_no'];
        $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code 
        from    petition_dag_details where dist_code='$dist_code' and subdiv_code='$subdiv_code'
        and cir_code='$cir_code' and lot_no='$lot_no' and 
        vill_townprt_code='$vill_townprt_code' and mouza_pargona_code='$mouza_pargona_code' 
        and petition_no='$petition_no'")->row_array();

        $designation = $this->db->query("select user_desig_as as user_designation from    master_user_designation where user_desig_code='".$location['add_off_desig']."'")->row()->user_designation;
        $locationData = array(
            'dist_code' => $location['dist_code'],
            'subdiv_code' => $location['subdiv_code'],
            'cir_code' => $location['cir_code'],
            'lot_no' => $location['lot_no'],
            'vill_code' => $location['vill_townprt_code'],
            'mouza_pargona_code' => $location['mouza_pargona_code']
        );
        $data['l_data']=$locationData;
        $dist_code = $this->utilityclass->getDistrictName($location['dist_code']);
        $subdiv_code = $this->utilityclass->getSubDivName($location['dist_code'], $location['subdiv_code']);
        $cir_code = $this->utilityclass->getCircleName($location['dist_code'], $location['subdiv_code'], $location['cir_code']);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code']);
        $lot_no = $this->utilityclass->getLotName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no']);
        $vill_townprt_code = $this->utilityclass->getVillageName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $location['vill_townprt_code']);

        $data['patta_type'] = $this->db->query("select patta_type from    patta_code "
            . " where type_code='$landdetails[patta_type_code]'")->row()->patta_type;
        $m_dag_area_lc = $landdetails['m_dag_area_lc'];
        $m_dag_area_lc = round($m_dag_area_lc, 2);
        $data['location'] = array(
            'dist' => $dist_code,
            'sub' => $subdiv_code,
            'cir' => $cir_code,
            'mouza' => $mouza_pargona_code,
            'lot' => $lot_no,
            'vill' => $vill_townprt_code,
            'case_no' => $case_no,
            'date' => $location['date_entry'],
            'add_to' => $location['add_off_name'],
            'add_off_designation' => $designation,
            'next_date' => $location['next_date_of_hearing'],
            'sk_comment' => $location['sk_comment'],
            'dag' => $landdetails['dag_no'],
            'm_dag_area_b' => $landdetails['m_dag_area_b'],
            'm_dag_area_k' => $landdetails['m_dag_area_k'],
            'm_dag_area_lc' => $m_dag_area_lc,
            'patta_no' => trim($landdetails['patta_no']),
            'patta_type' => $landdetails['patta_type_code'],
        );

        $convertion_code = CONVERSION_CODE;
        $data['conv_type'] = $this->db->query("select order_type from    master_office_mut_type "
            . " where order_type_code='$convertion_code'")->row()->order_type;

        $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from    petition_dag_details where "
            . "dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' "
            . "and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' "
            . "and petition_no='$petition_basic->petition_no'")->row_array();

        $m_dag_area_lc = $landdetails['m_dag_area_lc'];
        $m_dag_area_lc = round($m_dag_area_lc, 2);

        $data['land_details'] = array(
            'dag' => $landdetails['dag_no'],
            'm_dag_area_b' => $landdetails['m_dag_area_b'],
            'm_dag_area_k' => $landdetails['m_dag_area_k'],
            'm_dag_area_lc' => $m_dag_area_lc,
            'patta_no' => trim($landdetails['patta_no']),
            'patta_type' => $landdetails['patta_type_code']
        );

        $data['patta_type'] = $this->db->query("select patta_type from    patta_code "
            . " where type_code='$landdetails[patta_type_code]'")->row()->patta_type;

        $pattadardetails = "select pdar_name,pdar_guardian,pdar_rel_guar,pdar_add1,pdar_add2, inplace_alongwith from    petitioner_part where dist_code='$petition_basic->dist_code' "
            . "and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and "
            . "vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and "
            . "petition_no='$petition_basic->petition_no' and dag_no='$landdetails[dag_no]' and TRIM(patta_no)=trim('$landdetails[patta_no]') and patta_type_code= '$landdetails[patta_type_code]'";

        $data['pattadar'] = $this->db->query($pattadardetails)->result();
        $data['p_in_order'] = $this->db->query($pattadardetails)->result();
        $lm_details = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
            . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and "
            . "mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' order by note_no desc limit 1 ")->row_array();

        if (count($lm_details) != '0') {
            $land = $lm_details['land_class_code'];
            $land_type = $this->db->query("Select * from    landclass_code where class_code = '$land'")->row();

            $prim_per_bigha = $lm_details['prim_per_bigha'];
            $prim_per_bigha = round($prim_per_bigha, 2);

            $prim_tot = $lm_details['prim_tot'];
            $prim_tot = round($prim_tot, 2);

            $data['lm_details'] = array(
                //'petition_no' => $lm_details[''],
                'dag_no' => $lm_details['dag_no'],
                'note_no' => $lm_details['note_no'],
                'partition_info' => $lm_details['partition_info'],
                //'user_code' => $lm_details[''],
                'date_entry' => $lm_details['date_entry'],
                //'operation' => $lm_details[''],
                'applicant_patta_yn' => $lm_details['applicant_patta_yn'],
                'occupied_yn' => $lm_details['occupied_yn'],
                'val_tree_yn' => $lm_details['val_tree_yn'],
                'dist_frm_town' => $lm_details['dist_frm_town'],
                'inside_outside_town' => $lm_details['inside_outside_town'],
                'land_class_code' => $land_type->land_type,
                'issuit_forconv_under105' => $lm_details['issuit_forconv_under105'],
                'roadside_rsv_b' => $lm_details['roadside_rsv_b'],
                'roadside_rsv_k' => $lm_details['roadside_rsv_k'],
                'roadside_rsv_lc' => $lm_details['roadside_rsv_lc'],
                'near_river_yn' => $lm_details['near_river_yn'],
                'prim_per_bigha' => $prim_per_bigha,
                'conv_b' => $lm_details['conv_b'],
                'conv_k' => $lm_details['conv_k'],
                'conv_lc' => $lm_details['conv_lc'],
                'prim_tot' => $prim_tot,
                'lm_sign_yn' => $lm_details['lm_sign_yn'],
                'case_no' => $case_no,
                'lm_code' => $lm_details['lm_code'],
                'sk_note_date' => $lm_details['sk_note_date'],
                'sk_note' => $lm_details['sk_note'],
                'sk_sign_yn' => $lm_details['sk_sign_yn'],
                'sk_name' => $lm_details['user_code'],
                'jati_janajati_yn' => $lm_details['jati_janajati_yn'],
                'jati_janajati_upload' => $lm_details['jati_janajati_upload'],
                'freedom_fighter_yn' => $lm_details['freedom_fighter_yn'],
                'freedom_fighter_upload' => $lm_details['freedom_fighter_upload'],
                'widow_yn' => $lm_details['widow_yn'],
                'widow_upload' => $lm_details['widow_upload'],
                'premium_assesment' => $lm_details['premium_assesment']
            );
        }

        $namelm = $this->db->query("select * from    lm_code where lm_code = '" . $lm_details['lm_code'] . "'  and dist_code = '" . $location['dist_code'] . "' and "
            . "subdiv_code = '" . $location['subdiv_code'] . "' and cir_code = '" . $location['cir_code'] . "' and mouza_pargona_code = '" . $location['mouza_pargona_code'] . "' "
            . "and lot_no = '" . $location['lot_no'] . "' ")->row();

        $data['lm_name'] = $namelm->lm_name;

        $skname = $this->db->query("select * from    users where user_code='" . $lm_details['user_code'] . "'  and dist_code = '" . $lm_details['dist_code'] . "' and "
            . "subdiv_code = '" . $lm_details['subdiv_code'] . "' and cir_code = '" . $lm_details['cir_code'] . "' ")->row();

        $data['sk_skname'] = $skname->username;

        $query = "select * from    petition_proceeding where case_no = '$case_no'";
        $data['cases'] = $this->db->query($query)->result();

        $dc_adc_order = "select * from    petition_proceeding_dc_adc where case_no = '$case_no' order by proceeding_id";
        $data['dc_adc_order'] = $dc_order = $this->db->query($dc_adc_order)->result();

        $data['adc_order'] = $this->db->query("SELECT * FROM petition_proceeding_dc_adc WHERE case_no=? AND user_code LIKE '%ADC%' ORDER BY proceeding_id DESC LIMIT 1", [$case_no])->row();

        $data['dept_order'] = $this->db->query("SELECT * FROM petition_proceeding_dc_adc WHERE case_no=? AND user_code LIKE '%DPT%' ORDER BY proceeding_id DESC LIMIT 1", [$case_no])->row();

        $data['lm_details_final'] = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
            . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and "
            . "mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' order by note_no desc limit 1")->result();
        $data['bo_details_final'] = $this->db->query("Select * from    petition_bo_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
            . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and "
            . "mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'")->result();


        $data['premium'] = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and "
            . "cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and "
            . "mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and "
            . "co_reject is NULL ORDER BY note_no DESC LIMIT 1")->result();

        $data['adc_active']=$this->db->query("Select users.username as username, users.user_desig_code as user_desig_code, loginuser_table.user_code as user_code from    users, "
            . "loginuser_table where users.dist_code = loginuser_table.dist_code "
            . "and users.user_code = loginuser_table.user_code and users.user_desig_code = 'ADC' and users.dist_code='$petition_basic->dist_code' and "
            . "users.subdiv_code='00' and users.cir_code='00' and loginuser_table.dis_enb_option = 'E'")->result();

        $data['basundharaAttachment']=$this->MbOfficeConversionModel->searchBasundharaLink($case_no);
        if(!$data['basundharaAttachment']) {
            $data['supportiveDocs'] = $this->SupportiveDocumentModel->getDocs($case_no);
        }

        $data['approval_authority'] = $this->MbOfficeConversionModel->approvalAuthority($data['lm_details_final'][0]->conversion_premium_rates_id);
        $data['conversion_premium_area'] = $this->db->query("SELECT * FROM conversion_premium_areas WHERE id=?", [$lm_details['conversion_premium_areas_id']])->row();
        $data['conversion_premium_rate'] = $this->db->query("SELECT * FROM conversion_premium_rates WHERE id=?", [$lm_details['conversion_premium_rates_id']])->row();


        // var_dump($data['approval_authority']); die;

        // echo '<pre>';
        // var_dump($data['lm_details_final']);
        // die();

        $user_desig_code = $this->session->userdata('user_desig_code');
        $data['post_url'] = 'index.php/dc_conversion_mb/RegenerateDC';
        $data['_view'] = 'dc_adc_office_conversion/dc_conversion_first_proceeding_mb';
        $this->load->view('layouts/main',$data);
    }

    public function FirstProceedingDC_save() {
        //form validation
        $formValidation = $this->FormValidationModel->formValidationForPost($_POST, [
            'case_no'=>'Case No.|required|case_no',
            'dc_adc_order'=>'DC/ADC Order|required',
            'hearing_date'=>'Hearing Date|required|date',
            'bo_code'=>'BO Code|required'
        ]);
        if($formValidation['status'] == 'n') {
            //ERRCONVDCFIRST0001
            log_message('error', 'Message: '. $formValidation['message'] .', Data: '. json_encode($formValidation['data']) .'. Error: ERRCONVDCFIRST0001');
            $this->session->set_flashdata('message', $formValidation['message'] .' Error: ERRCONVDCFIRST0001');
            redirect(base_url('index.php/dc_conversion_mb/GoToDC?pro=3'));
        }

        //syntax validation
        $requestResponse = checkRequestSpecChar($_POST, [], [], ['dc_adc_order'=>true]);
        if($requestResponse['status'] == 'n') {
            //ERRCONVDCFIRST0002
            log_message('error', $requestResponse['messages'] . '. Error: ERRCONVDCFIRST0002');
            $this->session->set_flashdata('message', 'Contains Illegal parameter values. Error: ERRCONVDCFIRST0002');
            redirect(base_url('index.php/dc_conversion_mb/GoToDC?pro=3'));
        }

        //malicious query validation
        $validResponse = checkRequestValidQuery($_POST, [], ['dc_adc_order'=>true]);
        if($validResponse['status'] == 'n') {
            //ERRCONVDCFIRST0003
            log_message('error', $validResponse['messages'] . '. Error: ERRCONVDCFIRST0003');
            $this->session->set_flashdata('message', 'Contains Malicious parameter values. Error: ERRCONVDCFIRST0003');
            redirect(base_url('index.php/dc_conversion_mb/GoToDC?pro=3'));
        }

        $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'DC', $_POST['case_no'], CONV_DC_FIRST);
        if($authorization['status'] == 'n') {
            //ERRCONVDCFIRST0004
            log_message('error', $authorization['messages'] . '. Error: ERRCONVDCFIRST0004');
            $this->session->set_flashdata('message', $authorization['messages'].'. Error: ERRCONVDCFIRST0004');
            redirect(base_url('index.php/home'));
        }

        // echo '<pre>';
        // var_dump($_POST);
        // die();

        $db=  $this->session->userdata('db');
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code1');
        $cir_code = $this->session->userdata('cir_code1');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code1');
        $lot_no = $this->session->userdata('lot_no1');
        $vill_townprt_code = $this->session->userdata('vill_townprt_code1');

        $case_no = $this->input->post('case_no');
        $hearing_date = date('Y-m-d', strtotime($this->input->post('hearing_date')));
        $dc_adc_order = $this->input->post('dc_adc_order');
        $bo_code = $this->input->post('bo_code');
        $date_entry = date('Y-m-d H:i:s');
        $operation = 'E';
        $year_no = date('Y');
        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and "
            . "subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
            . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row();

        $proceeding = $this->db->query("select count(proceeding_id) as proceed from    petition_proceeding_dc_adc where case_no = '$case_no' limit 1")->result();
        $proceeding_id = $proceeding[0]->proceed + 1;


        $this->db->trans_begin();

        $proceeding_data = array(
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => $hearing_date,
            'co_order' => $dc_adc_order,
            //'note_on_order' => '',
            //'next_date_of_hearing' => $hearing_date,
            'status' => 'Pending',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => $date_entry,
            'operation' => 'E',
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code
        );
        //var_dump($proceeding_data);


        $insert_pp = $this->db->insert('petition_proceeding_dc_adc', $proceeding_data);//****************
        if($insert_pp != 1){
            $this->db->trans_rollback();
            log_message('error', '#ERRCONVDC0003: Insertion failed in petition_proceeding for case no :'. $case_no);
            $json = [
                'message'=>"#ERRCONVDC0003: Failed to in Proceeding for Case No : ".$case_no
            ];
            echo json_encode($json);
            return false;
        }

        $bo_name = $this->db->query("Select users.username, loginuser_table.user_code from    users, loginuser_table where users.dist_code = loginuser_table.dist_code "
            . "and users.user_code = loginuser_table.user_code and users.user_code = '$bo_code' and users.dist_code='$petition_basic->dist_code' and "
            . "users.subdiv_code='00' and users.cir_code='00' and loginuser_table.dis_enb_option = 'E'")->row();

        // $this->db->query("UPDATE Petition_Basic SET user_code = '$bo_name->user_code', bo_notice_gen = 'Y', proceeding_yn = null WHERE "
        //         . "case_no = '$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
        //         . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'");

        $this->db->query("UPDATE Petition_Basic SET user_code = '$bo_code', bo_notice_gen = 'Y', proceeding_yn = null WHERE "
            . "case_no = '$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
            . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'");

        if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            log_message('error', '#ERRCONVDC0004: Updation failed in petition_basic Case No ' . $case_no);
            $data = array(
                'error' => "#ERRCONVDC0004: Registration of Petition basic for case no : " . $case_no,
            );
            echo json_encode($data);
            return false;
        }

        if ($this->db->trans_status() == false) {
            $this->db->trans_rollback();
            $data = array(
                'error' => "Error in submitting. Please try Again",
            );
        }
        else
        {

            //////////
            $penUser='BO';
            $rmrk='Forwarded by DC';
            $this->DashboardData($case_no,$penUser,$rmrk);
            $status='M';
            $task='DC';
            $pen='BO';
            $case=$case_no;

            $rtps_status = $this->basundharamodel->postApiBasundharaSec($case,$rmrk,$status,$task,$pen);
            //var_dump($rtps_status);
            if (trim($rtps_status) !="y") {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error #ERRDCAPI0001: Application unable to process case no # $case_no");
                redirect(base_url() . "index.php/home");
            } else {
                $this->db->trans_commit();
                $this->session->set_flashdata('message', "Conversion Proceeding Order has been Passed to Branch Officer's for Report on Case no # $case_no");
                redirect(base_url() . "index.php/home");
            }
            ///////


        }
    }

    public function FirstProceedingADC_save() {
        //form validation
        $formValidation = $this->FormValidationModel->formValidationForPost($_POST, [
            'case_no'=>'Case No.|required|case_no',
            'dc_adc_order'=>'DC/ADC Order|required',
            'hearing_date'=>'Hearing Date|required|date',
            'bo_code'=>'BO Code|required'
        ]);
        if($formValidation['status'] == 'n') {
            //ERRCONVADCFIRST0001
            log_message('error', 'Message: '. $formValidation['message'] .', Data: '. json_encode($formValidation['data']) .'. Error: ERRCONVADCFIRST0001');
            $this->session->set_flashdata('message', $formValidation['message'] .' Error: ERRCONVADCFIRST0001');
            redirect(base_url('index.php/dc_conversion_mb/GoToDC?pro=4'));
        }

        //syntax validation
        $requestResponse = checkRequestSpecChar($_POST, [], [], ['dc_adc_order'=>true]);
        if($requestResponse['status'] == 'n') {
            //ERRCONVADCFIRST0002
            log_message('error', $requestResponse['messages'] . '. Error: ERRCONVADCFIRST0002');
            $this->session->set_flashdata('message', 'Contains Illegal parameter values. Error: ERRCONVADCFIRST0002');
            redirect(base_url('index.php/dc_conversion_mb/GoToDC?pro=4'));
        }

        //malicious query validation
        $validResponse = checkRequestValidQuery($_POST, [], ['dc_adc_order'=>true]);
        if($validResponse['status'] == 'n') {
            //ERRCONVADCFIRST0003
            log_message('error', $validResponse['messages'] . '. Error: ERRCONVADCFIRST0003');
            $this->session->set_flashdata('message', 'Contains Malicious parameter values. Error: ERRCONVADCFIRST0003');
            redirect(base_url('index.php/dc_conversion_mb/GoToDC?pro=4'));
        }

        $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'ADC', $_POST['case_no'], CONV_ADC_FIRST);
        if($authorization['status'] == 'n') {
            //ERRCONVADCFIRST0004
            log_message('error', $authorization['messages'] . '. Error: ERRCONVADCFIRST0004');
            $this->session->set_flashdata('message', $authorization['messages'].'. Error: ERRCONVADCFIRST0004');
            redirect(base_url('index.php/home'));
        }

        // echo '<pre>';
        // var_dump($_POST, $authorization);
        // die();

        $db=  $this->session->userdata('db');
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code1');
        $cir_code = $this->session->userdata('cir_code1');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code1');
        $lot_no = $this->session->userdata('lot_no1');
        $vill_townprt_code = $this->session->userdata('vill_townprt_code1');

        $case_no = $this->input->post('case_no');
        $hearing_date = date('Y-m-d', strtotime($this->input->post('hearing_date')));
        $dc_adc_order = $this->input->post('dc_adc_order');
        $bo_code = $this->input->post('bo_code');
        $date_entry = date('Y-m-d H:i:s');
        $operation = 'E';
        $year_no = date('Y');
        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and "
            . "subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
            . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row();

        $proceeding = $this->db->query("select count(proceeding_id) as proceed from    petition_proceeding_dc_adc where case_no = '$case_no' limit 1")->result();
        $proceeding_id = $proceeding[0]->proceed + 1;


        $this->db->trans_begin();

        $proceeding_data = array(
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => $hearing_date,
            'co_order' => $dc_adc_order,
            //'note_on_order' => '',
            //'next_date_of_hearing' => $hearing_date,
            'status' => 'Pending',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => $date_entry,
            'operation' => 'E',
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code
        );
        //var_dump($proceeding_data);


        $insert_pp = $this->db->insert('petition_proceeding_dc_adc', $proceeding_data);//****************
        if($insert_pp != 1){
            $this->db->trans_rollback();
            log_message('error', '#ERRCONVDC0003: Insertion failed in petition_proceeding for case no :'. $case_no);
            $json = [
                'message'=>"#ERRCONVDC0003: Failed to in Proceeding for Case No : ".$case_no
            ];
            echo json_encode($json);
            return false;
        }

        $bo_name = $this->db->query("Select users.username, loginuser_table.user_code from    users, loginuser_table where users.dist_code = loginuser_table.dist_code "
            . "and users.user_code = loginuser_table.user_code and users.user_code = '$bo_code' and users.dist_code='$petition_basic->dist_code' and "
            . "users.subdiv_code='00' and users.cir_code='00' and loginuser_table.dis_enb_option = 'E'")->row();

        // $this->db->query("UPDATE Petition_Basic SET user_code = '$bo_name->user_code', bo_notice_gen = 'Y', proceeding_yn = null WHERE "
        //         . "case_no = '$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
        //         . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'");

        $this->db->query("UPDATE Petition_Basic SET user_code = '$bo_code', bo_notice_gen = 'Y', proceeding_yn = null WHERE "
            . "case_no = '$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
            . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'");

        if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            log_message('error', '#ERRCONVDC0004: Updation failed in petition_basic Case No ' . $case_no);
            $data = array(
                'error' => "#ERRCONVDC0004: Registration of Petition basic for case no : " . $case_no,
            );
            echo json_encode($data);
            return false;
        }

        if ($this->db->trans_status() == false) {
            $this->db->trans_rollback();
            $data = array(
                'error' => "Error in submitting. Please try Again",
            );
        }
        else
        {

            //////////
            $penUser='BO';
            $rmrk='Forwarded by DC';
            $this->DashboardData($case_no,$penUser,$rmrk);
            $status='M';
            $task='DC';
            $pen='BO';
            $case=$case_no;

            $rtps_status = $this->basundharamodel->postApiBasundharaSec($case,$rmrk,$status,$task,$pen);
            //var_dump($rtps_status);
            if (trim($rtps_status) !="y") {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error #ERRDCAPI0001: Application unable to process case no # $case_no");
                redirect(base_url() . "index.php/home");
            } else {
                $this->db->trans_commit();
                $this->session->set_flashdata('message', "Conversion Proceeding Order has been Passed to Branch Officer's for Report on Case no # $case_no");
                redirect(base_url() . "index.php/home");
            }
            ///////


        }
    }

    public function FirstProceeding_save_direct() {
        //form validation
        $formValidation = $this->FormValidationModel->formValidationForPost($_POST, [
            'case_no'=>'Case No.|required|case_no',
            'dc_adc_order'=>'DC/ADC Order|required',
            'bo_code'=>'BO Code|required',
            'dist_code'=>'District Code|required|digit',
            'subdiv_code'=>'Subdiv Code|required|digit',
            'cir_code'=>'Circle Code|required|digit',
            'mouza_pargona_code'=>'Mouza Pargona Code|required|digit',
            'lot_no'=>'Lot No.|required|digit',
            'vill_townprt_code'=>'Village TownPart Code|required|digit'
        ]);
        if($formValidation['status'] == 'n') {
            //ERRCONVDCFIRSTDIRECT0001
            log_message('error', 'Message: '. $formValidation['message'] .', Data: '. json_encode($formValidation['data']) .'. Error: ERRCONVDCFIRSTDIRECT0001');
            $this->session->set_flashdata('message', $formValidation['message'] .' Error: ERRCONVDCFIRSTDIRECT0001');
            redirect(base_url('index.php/dc_conversion_mb/GoToDC?pro=3'));
        }

        //syntax validation
        $requestResponse = checkRequestSpecChar($_POST, [], [], ['dc_adc_order'=>true]);
        if($requestResponse['status'] == 'n') {
            //ERRCONVDCFIRSTDIRECT0002
            log_message('error', $requestResponse['messages'] . '. Error: ERRCONVDCFIRSTDIRECT0002');
            $this->session->set_flashdata('message', 'Contains Illegal parameter values. Error: ERRCONVDCFIRSTDIRECT0002');
            redirect(base_url('index.php/dc_conversion_mb/GoToDC?pro=3'));
        }

        //malicious query validation
        $validResponse = checkRequestValidQuery($_POST, [], ['dc_adc_order'=>true]);
        if($validResponse['status'] == 'n') {
            //ERRCONVDCFIRSTDIRECT0003
            log_message('error', $validResponse['messages'] . '. Error: ERRCONVDCFIRSTDIRECT0003');
            $this->session->set_flashdata('message', 'Contains Malicious parameter values. Error: ERRCONVDCFIRSTDIRECT0003');
            redirect(base_url('index.php/dc_conversion_mb/GoToDC?pro=3'));
        }

        $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'DC', $_POST['case_no'], CONV_DC_FIRST);
        if($authorization['status'] == 'n') {
            //ERRCONVDCFIRSTDIRECT0004
            log_message('error', $authorization['messages'] . '. Error: ERRCONVDCFIRSTDIRECT0004');
            $this->session->set_flashdata('message', $authorization['messages'].'. Error: ERRCONVDCFIRSTDIRECT0004');
            redirect(base_url('index.php/home'));
        }
        // echo '<pre>';
        // var_dump($_POST);
        // die();
        $db=  $this->session->userdata('db');
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $vill_townprt_code = $this->input->post('vill_townprt_code');

        $case_no = $this->input->post('case_no');
        $hearing_date = date('Y-m-d H:i:s');
        $dc_adc_order = $this->input->post('dc_adc_order');
        $bo_code = $this->input->post('bo_code');
        $date_entry = date('Y-m-d H:i:s');
        $operation = 'E';
        $year_no = date('Y');
        //var_dump($_POST);
        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and "
            . "subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
            . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row();

        $proceeding = $this->db->query("select count(proceeding_id) as proceed from    petition_proceeding_dc_adc where case_no = '$case_no' limit 1")->result();
        $proceeding_id = $proceeding[0]->proceed + 1;

        $this->db->trans_begin();

        $proceeding_data = array(
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => $hearing_date,
            'co_order' => $dc_adc_order,
            //'note_on_order' => '',
            //'next_date_of_hearing' => $hearing_date,
            'status' => 'Pending',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => $date_entry,
            'operation' => 'E',
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code
        );
        //var_dump($proceeding_data);

        $insert_pp2 = $this->db->insert('petition_proceeding_dc_adc', $proceeding_data);//****************
        if($insert_pp2 != 1){
            $this->db->trans_rollback();
            log_message('error', '#ERRCONVDC0005: Insertion failed in petition_proceeding for case no :'. $case_no);
            $json = [
                'message'=>"#ERRCONVDC0005: Failed to in Proceeding for Case No : ".$case_no
            ];
            echo json_encode($json);
            return false;
        }

        $bo_name = $this->db->query("Select users.username, loginuser_table.user_code from    users, loginuser_table where users.dist_code = loginuser_table.dist_code "
            . "and users.user_code = loginuser_table.user_code and users.user_code = '$bo_code' and users.dist_code='$petition_basic->dist_code' and "
            . "users.subdiv_code='00' and users.cir_code='00' and loginuser_table.dis_enb_option = 'E'")->row();

        $this->db->query("UPDATE Petition_Basic SET user_code = '$bo_name->user_code', bo_notice_gen = 'Y', proceeding_yn = null WHERE "
            . "case_no = '$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
            . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'");

        if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            log_message('error', '#ERRCONVDC0006: Updation failed in petition_basic Case No ' . $case_no);
            $data = array(
                'error' => "#ERRCONVDC0006: Registration of Petition basic for case no : " . $case_no,
            );
            echo json_encode($data);
            return false;
        }

        if ($this->db->trans_status() == false) {
            $this->db->trans_rollback();
            $data = array(
                'error' => "Error in submitting. Please try Again",
            );
        }
        else
        {
            $this->db->trans_commit();
            $this->session->set_flashdata('message', "Conversion Proceeding Order has been Passed to Branch Officer's for Report on Case no # $case_no");
            redirect(base_url() . "index.php/home");
        }
    }

    public function SecondProceeding() {
        $db=  $this->session->userdata('db');
        //var_dump($this->session->all_userdata());
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');
        $this->session->set_userdata(array('subdiv_code1' => $subdiv_code));
        $this->session->set_userdata(array('cir_code1' => $cir_code));
        $this->session->set_userdata(array('mouza_pargona_code1' => $mouza_pargona_code));
        $this->session->set_userdata(array('lot_no1' => $lot_no));
        $this->session->set_userdata(array('vill_townprt_code1' => $vill_townprt_code));

        $data = array();
        $case_no = $this->input->get('case_no');
        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and "
            . "subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
            . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row();
        $data['petition_basic']= $petition_basic;

        $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,date_entry,add_off_name,add_off_desig,next_date_of_hearing,sk_comment,petition_no "
            . "from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
            . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row_array();

        $petition_no = $location['petition_no'];
        $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code 
        from    petition_dag_details where dist_code='$dist_code' and subdiv_code='$subdiv_code'
        and cir_code='$cir_code' and lot_no='$lot_no' and 
        vill_townprt_code='$vill_townprt_code' and mouza_pargona_code='$mouza_pargona_code' 
        and petition_no='$petition_no'")->row_array();

        $designation = $this->db->query("select user_desig_as as user_designation from    master_user_designation where user_desig_code='".$location['add_off_desig']."'")->row()->user_designation;
        $locationData = array(
            'dist_code' => $location['dist_code'],
            'subdiv_code' => $location['subdiv_code'],
            'cir_code' => $location['cir_code'],
            'lot_no' => $location['lot_no'],
            'vill_code' => $location['vill_townprt_code'],
            'mouza_pargona_code' => $location['mouza_pargona_code']
        );
        $data['l_data']=$locationData;
        $dist_code = $this->utilityclass->getDistrictName($location['dist_code']);
        $subdiv_code = $this->utilityclass->getSubDivName($location['dist_code'], $location['subdiv_code']);
        $cir_code = $this->utilityclass->getCircleName($location['dist_code'], $location['subdiv_code'], $location['cir_code']);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code']);
        $lot_no = $this->utilityclass->getLotName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no']);
        $vill_townprt_code = $this->utilityclass->getVillageName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $location['vill_townprt_code']);

        $data['patta_type'] = $this->db->query("select patta_type from    patta_code "
            . " where type_code='$landdetails[patta_type_code]'")->row()->patta_type;
        $m_dag_area_lc = $landdetails['m_dag_area_lc'];
        $m_dag_area_lc = round($m_dag_area_lc, 2);
        $data['location'] = array(
            'dist' => $dist_code,
            'sub' => $subdiv_code,
            'cir' => $cir_code,
            'mouza' => $mouza_pargona_code,
            'lot' => $lot_no,
            'vill' => $vill_townprt_code,
            'case_no' => $case_no,
            'date' => $location['date_entry'],
            'add_to' => $location['add_off_name'],
            'add_off_designation' => $designation,
            'next_date' => $location['next_date_of_hearing'],
            'sk_comment' => $location['sk_comment'],
            'dag' => $landdetails['dag_no'],
            'm_dag_area_b' => $landdetails['m_dag_area_b'],
            'm_dag_area_k' => $landdetails['m_dag_area_k'],
            'm_dag_area_lc' => $m_dag_area_lc,
            'patta_no' => trim($landdetails['patta_no']),
            'patta_type' => $landdetails['patta_type_code'],
        );

        $convertion_code = CONVERSION_CODE;
        $data['conv_type'] = $this->db->query("select order_type from    master_office_mut_type "
            . " where order_type_code='$convertion_code'")->row()->order_type;

        $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from    petition_dag_details where "
            . "dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' "
            . "and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' "
            . "and petition_no='$petition_basic->petition_no'")->row_array();

        $m_dag_area_lc = $landdetails['m_dag_area_lc'];
        $m_dag_area_lc = round($m_dag_area_lc, 2);

        $data['land_details'] = array(
            'dag' => $landdetails['dag_no'],
            'm_dag_area_b' => $landdetails['m_dag_area_b'],
            'm_dag_area_k' => $landdetails['m_dag_area_k'],
            'm_dag_area_lc' => $m_dag_area_lc,
            'patta_no' => trim($landdetails['patta_no']),
            'patta_type' => $landdetails['patta_type_code']
        );

        $data['patta_type'] = $this->db->query("select patta_type from    patta_code "
            . " where type_code='$landdetails[patta_type_code]'")->row()->patta_type;

        $pattadardetails = "select pdar_name,pdar_guardian,pdar_rel_guar,pdar_add1,pdar_add2, inplace_alongwith from    petitioner_part where dist_code='$petition_basic->dist_code' "
            . "and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and "
            . "vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and "
            . "petition_no='$petition_basic->petition_no' and dag_no='$landdetails[dag_no]' and TRIM(patta_no)=trim('$landdetails[patta_no]') and patta_type_code= '$landdetails[patta_type_code]'";

        $data['pattadar'] = $this->db->query($pattadardetails)->result();
        $data['p_in_order'] = $this->db->query($pattadardetails)->result();
        $lm_details = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
            . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and "
            . "mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' order by note_no desc limit 1 ")->row_array();

        if (count($lm_details) != '0') {
            $land = $lm_details['land_class_code'];
            $land_type = $this->db->query("Select * from    landclass_code where class_code = '$land'")->row();

            $prim_per_bigha = $lm_details['prim_per_bigha'];
            $prim_per_bigha = round($prim_per_bigha, 2);

            $prim_tot = $lm_details['prim_tot'];
            $prim_tot = round($prim_tot, 2);

            $data['lm_details'] = array(
                //'petition_no' => $lm_details[''],
                'dag_no' => $lm_details['dag_no'],
                'note_no' => $lm_details['note_no'],
                'partition_info' => $lm_details['partition_info'],
                //'user_code' => $lm_details[''],
                'date_entry' => $lm_details['date_entry'],
                //'operation' => $lm_details[''],
                'applicant_patta_yn' => $lm_details['applicant_patta_yn'],
                'occupied_yn' => $lm_details['occupied_yn'],
                'val_tree_yn' => $lm_details['val_tree_yn'],
                'dist_frm_town' => $lm_details['dist_frm_town'],
                'inside_outside_town' => $lm_details['inside_outside_town'],
                'land_class_code' => $land_type->land_type,
                'issuit_forconv_under105' => $lm_details['issuit_forconv_under105'],
                'roadside_rsv_b' => $lm_details['roadside_rsv_b'],
                'roadside_rsv_k' => $lm_details['roadside_rsv_k'],
                'roadside_rsv_lc' => $lm_details['roadside_rsv_lc'],
                'near_river_yn' => $lm_details['near_river_yn'],
                'prim_per_bigha' => $prim_per_bigha,
                'conv_b' => $lm_details['conv_b'],
                'conv_k' => $lm_details['conv_k'],
                'conv_lc' => $lm_details['conv_lc'],
                'prim_tot' => $prim_tot,
                'lm_sign_yn' => $lm_details['lm_sign_yn'],
                'case_no' => $case_no,
                'lm_code' => $lm_details['lm_code'],
                'sk_note_date' => $lm_details['sk_note_date'],
                'sk_note' => $lm_details['sk_note'],
                'sk_sign_yn' => $lm_details['sk_sign_yn'],
                'sk_name' => $lm_details['user_code'],
                'jati_janajati_yn' => $lm_details['jati_janajati_yn'],
                'jati_janajati_upload' => $lm_details['jati_janajati_upload'],
                'freedom_fighter_yn' => $lm_details['freedom_fighter_yn'],
                'freedom_fighter_upload' => $lm_details['freedom_fighter_upload'],
                'widow_yn' => $lm_details['widow_yn'],
                'widow_upload' => $lm_details['widow_upload'],
                'premium_assesment' => $lm_details['premium_assesment']
            );
        }

        $namelm = $this->db->query("select * from    lm_code where lm_code = '" . $lm_details['lm_code'] . "'  and dist_code = '" . $location['dist_code'] . "' and "
            . "subdiv_code = '" . $location['subdiv_code'] . "' and cir_code = '" . $location['cir_code'] . "' and mouza_pargona_code = '" . $location['mouza_pargona_code'] . "' "
            . "and lot_no = '" . $location['lot_no'] . "' ")->row();

        $data['lm_name'] = $namelm->lm_name;

        $skname = $this->db->query("select * from    users where user_code='" . $lm_details['user_code'] . "'  and dist_code = '" . $lm_details['dist_code'] . "' and "
            . "subdiv_code = '" . $lm_details['subdiv_code'] . "' and cir_code = '" . $lm_details['cir_code'] . "' ")->row();

        $data['sk_skname'] = $skname->username;


        $query = "select * from    petition_proceeding where case_no = '$case_no'";
        $data['cases'] = $this->db->query($query)->result();

        $dc_adc_order = "select * from    petition_proceeding_dc_adc where case_no = '$case_no' order by proceeding_id";
        $data['dc_adc_order'] = $dc_order = $this->db->query($dc_adc_order)->result();

        $data['adc_order'] = $this->db->query("SELECT * FROM petition_proceeding_dc_adc WHERE case_no=? AND user_code LIKE '%ADC%' ORDER BY proceeding_id DESC LIMIT 1", [$case_no])->row();

        $data['dept_order'] = $this->db->query("SELECT * FROM petition_proceeding_dc_adc WHERE case_no=? AND user_code LIKE '%DPT%' ORDER BY proceeding_id DESC LIMIT 1", [$case_no])->row();

        $data['lm_details_final'] = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
            . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and "
            . "mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' order by note_no desc limit 1")->result();
        $data['bo_details_final'] = $this->db->query("Select * from    petition_bo_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
            . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and "
            . "mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'")->result();


        $data['premium'] = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and "
            . "cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and "
            . "mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and "
            . "co_reject is NULL ORDER BY note_no DESC LIMIT 1")->result();

        // $data['branch_officer']=$this->db->query("Select users.username as username, users.user_desig_code as user_desig_code, loginuser_table.user_code as user_code from    users, "
        //         . "loginuser_table where users.dist_code = loginuser_table.dist_code "
        //         . "and users.user_code = loginuser_table.user_code and users.user_desig_code = 'BO' and users.dist_code='$petition_basic->dist_code' and "
        //         . "users.subdiv_code='00' and users.cir_code='00' and loginuser_table.dis_enb_option = 'E'")->result();

        $data['adc_active']=$this->db->query("Select users.username as username, users.user_desig_code as user_desig_code, loginuser_table.user_code as user_code from    users, "
            . "loginuser_table where users.dist_code = loginuser_table.dist_code "
            . "and users.user_code = loginuser_table.user_code and users.user_desig_code = 'ADC' and users.dist_code='$petition_basic->dist_code' and "
            . "users.subdiv_code='00' and users.cir_code='00' and loginuser_table.dis_enb_option = 'E'")->result();
        $data['approval_authority'] = $this->MbOfficeConversionModel->approvalAuthority($lm_details['conversion_premium_rates_id']);
        $data['basundharaAttachment']=$this->MbOfficeConversionModel->searchBasundharaLink($case_no);
        if(!$data['basundharaAttachment']) {
            $data['supportiveDocs'] = $this->SupportiveDocumentModel->getDocs($case_no);
        }

        // echo '<pre>';
        // var_dump($data['lm_details_final']);
        // die();
        $data['approval_authority'] = $this->MbOfficeConversionModel->approvalAuthority($data['lm_details_final'][0]->conversion_premium_rates_id);
        $data['conversion_premium_area'] = $this->db->query("SELECT * FROM conversion_premium_areas WHERE id=?", [$lm_details['conversion_premium_areas_id']])->row();
        $data['conversion_premium_rate'] = $this->db->query("SELECT * FROM conversion_premium_rates WHERE id=?", [$lm_details['conversion_premium_rates_id']])->row();

        $user_desig_code = $this->session->userdata('user_desig_code');

        $data['post_url'] = 'index.php/dc_conversion_mb/RegenerateDC';

        $data['_view'] = 'dc_adc_office_conversion/Second_Proceeding_Mb';
        $this->load->view('layouts/main',$data);
    }

    public function RegenerateDC() {
        //form validation
        $formValidation = $this->FormValidationModel->formValidationForPost($_POST, [
            'case_no'=>'Case No.|required|case_no',
            'dc_adc_notice'=>'DC/ADC Notice|required',
            // 'hearing_date'=>'Hearing Date|required|date',
            'order_type'=>'Order Type|required',
            're_co_note'=>'Revert CO Note|char',
            'prepare_premium'=>'Prepare Premium|char',
            'frwd_dept'=>'Forward To Department|char'
        ]);
        if($formValidation['status'] == 'n') {
            if($_POST['order_type'] == 'continuehearing') {
                //ERRCONVDCSECOND0001
                log_message('error', 'Message: '. $formValidation['message'] .', Data: '. json_encode($formValidation['data']) .'. Error: ERRCONVDCSECOND0001');
                $this->session->set_flashdata('message', $formValidation['message'] .' Error: ERRCONVDCSECOND0001');
                redirect(base_url('index.php/dc_conversion_mb/GoToDC?pro=1'));
            }
            else if($_POST['order_type'] == 'finalhukum') {
                //ERRCONVDCFINALORDER0001
                log_message('error', 'Message: '. $formValidation['message'] .', Data: '. json_encode($formValidation['data']) .'. Error: ERRCONVDCFINALORDER0001');
                $this->session->set_flashdata('message', $formValidation['message'] .' Error: ERRCONVDCFINALORDER0001');
                redirect(base_url('index.php/dc_conversion_mb/GoToDC?pro=1'));
            }
            else {

            }
        }

        //syntax validation
        $requestResponse = checkRequestSpecChar($_POST, ['dc_adc_notice'=>['%']], [], ['dc_adc_notice'=>true]);
        if($requestResponse['status'] == 'n') {
            if($_POST['order_type'] == 'continuehearing') {
                //ERRCONVDCSECOND0002
                log_message('error', $requestResponse['messages'] . '. Error: ERRCONVDCSECOND0002');
                $this->session->set_flashdata('message', 'Contains Illegal parameter values. Error: ERRCONVDCSECOND0002');
                redirect(base_url('index.php/dc_conversion_mb/GoToDC?pro=1'));
            }
            else if($_POST['order_type'] == 'finalhukum') {
                //ERRCONVDCFINALORDER0002
                log_message('error', $requestResponse['messages'] . '. Error: ERRCONVDCFINALORDER0002');
                $this->session->set_flashdata('message', 'Contains Illegal parameter values. Error: ERRCONVDCFINALORDER0002');
                redirect(base_url('index.php/dc_conversion_mb/GoToDC?pro=1'));
            }
            else{

            }
        }

        //malicious query validation
        $validResponse = checkRequestValidQuery($_POST, [], ['dc_adc_notice'=>true]);
        if($validResponse['status'] == 'n') {
            if($_POST['order_type'] == 'continuehearing') {
                //ERRCONVDCSECOND0003
                log_message('error', $validResponse['messages'] . '. Error: ERRCONVDCSECOND0003');
                $this->session->set_flashdata('message', 'Contains Malicious parameter values. Error: ERRCONVDCSECOND0003');
                redirect(base_url('index.php/dc_conversion_mb/GoToDC?pro=1'));
            }
            else if($_POST['order_type'] == 'finalhukum') {
                //ERRCONVDCFINALORDER0003
                log_message('error', $validResponse['messages'] . '. Error: ERRCONVDCFINALORDER0003');
                $this->session->set_flashdata('message', 'Contains Malicious parameter values. Error: ERRCONVDCFINALORDER0003');
                redirect(base_url('index.php/dc_conversion_mb/GoToDC?pro=1'));
            }
            else{

            }
        }

        //authorization
        if($_POST['order_type'] == 'continuehearing' && $_POST['prepare_premium'] != 'Y') {
            // if($_POST['prepare_premium'] == 'Y') {
            //     $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'DC', $_POST['case_no'], CONV_DC_SECOND);
            // }
            // else
            // {
            //     $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'DC', $_POST['case_no'], CONV_DC_FIRST);
            // }
            $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'DC', $_POST['case_no'], CONV_DC_FIRST);
            if($authorization['status'] == 'n') {
                //ERRCONVDCSECOND0004
                log_message('error', $authorization['messages'] . '. Error: ERRCONVDCSECOND0004');
                $this->session->set_flashdata('message', $authorization['messages'].'. Error: ERRCONVDCSECOND0004');
                redirect(base_url('index.php/home'));
            }
        }
        else if($_POST['order_type'] == 'finalhukum') {
            $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'DC', $_POST['case_no'], CONV_DC_FINALORD);
            if($authorization['status'] == 'n') {
                //ERRCONVDCFINALORDER0004
                log_message('error', $authorization['messages'] . '. Error: ERRCONVDCFINALORDER0004');
                $this->session->set_flashdata('message', $authorization['messages'].'. Error: ERRCONVDCFINALORDER0004');
                redirect(base_url('index.php/home'));
            }
        }
        else{

        }

        // echo '<pre>';
        // var_dump($_POST);
        // die();
        $db=  $this->session->userdata('db');
        //var_dump($this->session->all_userdata());
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code1');
        $cir_code = $this->session->userdata('cir_code1');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code1');
        $lot_no = $this->session->userdata('lot_no1');
        $vill_townprt_code = $this->session->userdata('vill_townprt_code1');
        $hearing_date = date('Y-m-d H:i:s');
        $dc_adc_order = $this->input->post('dc_adc_notice');
        $prepare_premium = $this->input->post('prepare_premium');
        $re_co_note = $this->input->post('re_co_note');
        $order_type = $this->input->post('order_type');
        $adc_code = $this->input->post('adc_code');
        $frwd_dept = $this->input->post('frwd_dept');
        //echo $dc_code;
        $case_no = $this->input->post('case_no');
        $this->session->set_userdata(array('case_no' => $case_no));

        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' "
            . "and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row();

        $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,date_entry,add_off_name,next_date_of_hearing "
            . "from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
            . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row_array();

        $subdiv_code = $location['subdiv_code'];
        $cir_code = $location['cir_code'];

        $proceeding = $this->db->query("select count(proceeding_id) as proceed from    petition_proceeding_dc_adc where case_no = '$case_no' limit 1")->result();
        $proceeding_id = $proceeding[0]->proceed + 1;
        //var_dump($proceeding_id);
        $date_entry = date('Y-m-d H:i:s');
        $proceeding_data = array(
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => $hearing_date,
            'co_order' => $dc_adc_order,
            //'note_on_order' => '',
            //'next_date_of_hearing' => $hearing_date,
            'status' => 'Pending',
            'user_code' => $user_code,
            'date_entry' => $date_entry,
            'operation' => 'E',
            'dist_code' => $location['dist_code'],
            'subdiv_code' => $location['subdiv_code'],
            'cir_code' => $location['cir_code']
        );

        // so we revart back that to co
        $q = $this->db->query("select * from    users where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (user_desig_code='CO' or user_desig_code='ASO')");
        $c = $q->result();

        foreach ($c as $x) {
            $users = "Select user_code as user_c from    loginuser_table where user_code='" . $x->user_code . "' and dis_enb_option = 'E' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
            $select = $this->db->query($users)->row();
            if (!empty($select)) {
                $co_name = $x->username;
                $user_desig_code = $x->user_desig_code;
                $user_code_co = $select->user_c;
            }
        }
        if ($re_co_note == 'Y') {

            // if re_co_note is Y that means its a village land and lm has wrongly entered report
            $this->db->trans_begin();

            $this->db->query("UPDATE Petition_Basic SET add_off_desig = '$user_desig_code', add_off_name = '$co_name', co_user_code = '$user_code_co', status = 'R', new_status = 'DCCOR' WHERE "
                . "case_no = '$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'");

            if ($this->db->affected_rows() == 0) {
                $this->db->trans_rollback();
                log_message('error', '#ERRCONVDC0007: Updation failed in petition_basic Case No ' . $case_no);
                $data = array(
                    'error' => "#ERRCONVDC0007: Registration of Petition basic for case no : " . $case_no,
                );
                echo json_encode($data);
                return false;
            }


            $proceeding = $this->db->query("select count(proceeding_id) as proceed from    petition_proceeding where case_no = '$case_no' order by proceed desc limit 1")->result();
            $proceeding_id = $proceeding[0]->proceed;

            // $note_on_order = '<span class="red">অবেদিত মাটি চহৰ অথবা চহৰৰ পৰিহিমাৰ পৰা 3 কিঃ মিঃ ব্যাসাৰ্দ্ধ আৰু গুৱাহাটী পৌৰনিগোম পৰিহিমাৰ পৰা 10 কিঃ মিঃ ব্যাসাৰ্দ্ধৰ বাহিৰৰ মাটি হয় ।  পুনৰ পৰীক্ষা কৰক ।</span>';

            $update1 = "UPDATE petition_proceeding set note_on_order = '$dc_adc_order', user_code = '$user_code', status = 'Reject' WHERE proceeding_id = '$proceeding_id' and case_no = '$case_no' "
                . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
            $this->db->query($update1);

            if ($this->db->affected_rows() == 0) {
                $this->db->trans_rollback();
                log_message('error', '#ERRCONVDC0008: Updation failed in petition_basic Case No ' . $case_no);
                $data = array(
                    'error' => "#ERRCONVDC0008: Registration of Petition basic for case no : " . $case_no,
                );
                echo json_encode($data);
                return false;
            }

            $status = 'Reject';

            if ($this->db->trans_status() == false) {
                $this->db->trans_rollback();
                $data = array(
                    'error' => "Error in submitting. Please try Again",
                );
            }
            else
            {
                ///////////////////////////////////////
                $penUser='CO';
                $rmrk='Reverted to CO by DC';
                // $this->DashboardData($case_no,$penUser,$rmrk);
                $status='M';
                $task='DC';
                $pen='CO';


                $rtps_status = $this->basundharamodel->postApiBasundharaSec($case_no,$rmrk,$status,$task,$pen);
                //var_dump($rtps_status);
                if (trim($rtps_status) !="y") {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error #ERRDCAPI6004: Application unable to process case no # $case_no");
                    redirect(base_url() . "index.php/home");
                } else {
                    $this->db->trans_commit();
                    $this->session->set_flashdata('message', "Case no # $case_no has been Reverted back to Circle Officer");
                    redirect(base_url() . "index.php/home");

                }
                ////////////////////////////////////////

            }
        }
        else{
            if ($order_type == 'finalhukum') {
                $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from    petition_dag_details where "
                    . "dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and "
                    . "lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' "
                    . "and petition_no='$petition_basic->petition_no'")->row_array();
                $m_dag_area_lc = $landdetails['m_dag_area_lc'];
                $m_dag_area_lc = round($m_dag_area_lc);
                $data['display'] = array(
                    'date' => date('Y-m-d H:i:s'),
                    'proceeding_id' => $proceeding_id,
                    'case_no' => $case_no,
                    'dag' => $landdetails['dag_no'],
                    'm_dag_area_b' => $landdetails['m_dag_area_b'],
                    'm_dag_area_k' => $landdetails['m_dag_area_k'],
                    'm_dag_area_lc' => $m_dag_area_lc,
                    'patta_no' => trim($landdetails['patta_no']),
                    'patta_type' => $landdetails['patta_type_code']
                );
                $data['patta_type'] = $this->db->query("select patta_type from    patta_code where type_code='$landdetails[patta_type_code]'")->row()->patta_type;

                $proceeding = $this->db->query("select count(proceeding_id) as proceed from    petition_proceeding where case_no = '$case_no' limit 1")->result();
                $proceeding_id = $proceeding[0]->proceed + 1;

                $this->db->trans_begin();

                $proceeding_data_end = array(
                    'case_no' => $case_no,
                    'proceeding_id' => $proceeding_id,
                    'date_of_hearing' => $hearing_date,
                    'co_order' => $dc_adc_order,
                    //'note_on_order' => '',
                    //'next_date_of_hearing' => $hearing_date,
                    'status' => 'Pending',
                    'user_code' => $user_code,
                    'date_entry' => $date_entry,
                    'operation' => 'E',
                    'dist_code' => $location['dist_code'],
                    'subdiv_code' => $location['subdiv_code'],
                    'cir_code' => $location['cir_code']
                );
                //var_dump($proceeding_data_end);


                $insert_pp3 = $this->db->insert('petition_proceeding', $proceeding_data_end);
                if($insert_pp3 != 1){
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCONVDC0009: Insertion failed in petition_proceeding for case no :'. $case_no);
                    $json = [
                        'message'=>"#ERRCONVDC0009: Failed to in Proceeding for Case No : ".$case_no
                    ];
                    echo json_encode($json);
                    return false;
                }


                $proceeding_dc_adc = $this->db->query("select count(proceeding_id) as proceed from    petition_proceeding_dc_adc where case_no = '$case_no' limit 1")->result();
                $proceeding_id_dc_adc = $proceeding_dc_adc[0]->proceed + 1;
                $proceeding_data_end_dc_adc = array(
                    'case_no' => $case_no,
                    'proceeding_id' => $proceeding_id_dc_adc,
                    'date_of_hearing' => $hearing_date,
                    'co_order' => $dc_adc_order,
                    //'note_on_order' => '',
                    //'next_date_of_hearing' => $hearing_date,
                    'status' => 'Pending',
                    'user_code' => $user_code,
                    'date_entry' => $date_entry,
                    'operation' => 'E',
                    'dist_code' => $location['dist_code'],
                    'subdiv_code' => $location['subdiv_code'],
                    'cir_code' => $location['cir_code']
                );
                //var_dump($proceeding_data_end_dc_adc);

                $insert_ppd = $this->db->insert('petition_proceeding_dc_adc', $proceeding_data_end_dc_adc);
                if($insert_ppd != 1){
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCONVDC0010: Insertion failed in petition_proceeding for case no :'. $case_no);
                    $json = [
                        'message'=>"#ERRCONVDC0010: Failed to in Proceeding for Case No : ".$case_no
                    ];
                    echo json_encode($json);
                    return false;
                }


                //exit();
                $order_type = $this->db->query("select * from    master_office_mut_type where order_type_code ='$petition_basic->mut_type'")->row();
                $lm_premium = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
                    . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and "
                    . "mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and co_reject is NULL order by note_no desc limit 1")->row();

                $q = "Select * from    lm_code where lm_code = '$lm_premium->lm_code' and dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
                    . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no'";

                $name_of_lm = $this->db->query("Select * from    lm_code where lm_code = '$lm_premium->lm_code' and dist_code='$petition_basic->dist_code' "
                    . "and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and lot_no='$petition_basic->lot_no'")->row();
                $name_of_lm = $name_of_lm->lm_name;

                $skname = $this->db->query("select * from    users where user_code='$lm_premium->user_code'  and dist_code='$petition_basic->dist_code' "
                    . "and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code'")->row();
                $sk_name = $skname->username;
                $data['display'] = array(
                    'date' => date('Y-m-d H:i:s'),
                    'proceeding_id' => $proceeding_id,
                    'case_no' => $case_no,
                    'order_type' => $order_type->order_type,
                    'co_name' => $petition_basic->add_off_name,
                    'co_order_date' => $petition_basic->co_order_conv_date,
                    'sk_note_date' => $lm_premium->sk_note_date,
                    'lm_note_date' => $lm_premium->lm_sign_date,
                    'lm_name' => $name_of_lm,
                    'sk_name' => $sk_name,
                    'co_code' => $petition_basic->add_off_desig,
                    'lm_code' => $lm_premium->lm_code,
                    'sk_code' => $lm_premium->user_code
                );


                // $this->db->query("UPDATE Petition_Basic SET add_off_desig = 'CO', status = 'W', new_status = 'DCCOC' WHERE "
                //     . "case_no = '$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                //     . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'");

                $dc_final_approval_date = date('Y-m-d H:i:s');

                $this->db->set('add_off_desig', 'CO');
                $this->db->set('status', 'W');
                $this->db->set('new_status', 'DCCOC');
                $this->db->set('dc_final_approval', 'Y');
                $this->db->set('dc_final_approval_date', $dc_final_approval_date);

                $this->db->where('case_no', $case_no);
                $this->db->where('dist_code', $dist_code);
                $this->db->where('subdiv_code', $subdiv_code);
                $this->db->where('cir_code', $cir_code);
                $this->db->where('mouza_pargona_code', $mouza_pargona_code);
                $this->db->where('lot_no', $lot_no);
                $this->db->where('vill_townprt_code', $vill_townprt_code);

                $this->db->update('petition_basic');


                if ($this->db->affected_rows() == 0) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCONVDC0011: Updation failed in petition_basic Case No ' . $case_no);
                    $data = array(
                        'error' => "#ERRCONVDC0011: Registration of Petition basic for case no : " . $case_no,
                    );
                    echo json_encode($data);
                    return false;
                }


                if ($this->db->trans_status() == false) {
                    $this->db->trans_rollback();
                    $data = array(
                        'error' => "Error in submitting. Please try Again",
                    );
                }
                else
                {
                    ///////////////////////////////////////
                    $penUser='CO';
                    $rmrk='Order passed by DC';
                    $this->DashboardData($case_no,$penUser,$rmrk);
                    $status='M';
                    $task='DC';
                    $pen='CO';

                    $rtps_status = $this->basundharamodel->postApiBasundharaSec($case_no,$rmrk,$status,$task,$pen);
                    //var_dump($rtps_status);
                    if (trim($rtps_status) !="y") {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error #ERRDCAPI0002: Application unable to process case no # $case_no");
                        redirect(base_url() . "index.php/home");
                    } else {
                        $this->db->trans_commit();
                        $this->session->set_flashdata('message', "Thank you..Order has been Passed on Case no # $case_no for Chitha Updation By Circle Officer");
                        redirect(base_url() . "index.php/home");
                    }
                    ////////////////////////////////////////    

                }

            } elseif ($order_type == 'continuehearing') {

                $formValid = $this->FormValidationModel->formValidationForPost($_POST, [
                    // 'prepare_premium'=>'Prepare Premium|required_as_option(frwd_dept)|char',
                    // 'frwd_dept'=>'Forward To Department|required_as_option(prepare_premium)|char'
                    'prepare_premium'=>'Prepare Premium|char',
                    'frwd_dept'=>'Forward To Department|char'
                ]);

                if($formValid['status'] == 'n') {
                    //ERRCONVDCSECOND0005
                    $this->db->trans_rollback();
                    log_message('error', 'Message: '. $formValid['message'] .', Data: '. json_encode($formValid['data']) .'. Error: ERRCONVDCSECOND0005');
                    $this->session->set_flashdata('message', $formValid['message'] .' Error: ERRCONVDCSECOND0005');
                    redirect(base_url('index.php/dc_conversion_mb/GoToDC?pro=1'));
                }

                if ($prepare_premium == 'Y') {

                    $formValid = $this->FormValidationModel->formValidationForPost($_POST, [
                        'adc_code'=>'ADC Code|required'
                    ]);
                    if($formValid['status'] == 'n') {
                        //ERRCONVDCSECOND0006
                        $this->db->trans_rollback();
                        log_message('error', 'Message: '. $formValid['message'] .', Data: '. json_encode($formValid['data']) .'. Error: ERRCONVDCSECOND0006');
                        $this->session->set_flashdata('message', $formValid['message'] .' Error: ERRCONVDCSECOND0006');
                        redirect(base_url('index.php/dc_conversion_mb/GoToDC?pro=1'));

                    }

                    //echo "Y";
                    $adc_name = $this->db->query("Select users.username, loginuser_table.user_code from    users, loginuser_table where users.dist_code = loginuser_table.dist_code "
                        . "and users.user_code = loginuser_table.user_code and users.user_code = '$adc_code' and users.dist_code='$petition_basic->dist_code' and "
                        . "users.subdiv_code='00' and users.cir_code='00' and loginuser_table.dis_enb_option = 'E'")->row();

                    $this->db->trans_begin();

                    $this->db->query("UPDATE petition_basic SET new_status='DCADP', user_code = '$adc_name->user_code', proceeding_yn = NULL, co_order_conv_premium = 'Y', co_order_conv_date = '$date_entry', co_order_conv_notice = 'Y' "
                        . "WHERE case_no = '$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                        . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'");

                    if ($this->db->affected_rows() == 0) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRCONVDC0012: Updation failed in petition_basic Case No ' . $case_no);
                        $data = array(
                            'error' => "#ERRCONVDC0012: Unable to forward ADC for Premium Notice Generate, case no : " . $case_no,
                        );
                        echo json_encode($data);
                        return false;
                    }

                    $proceeding_prem = $this->db->query("select count(proceeding_id) as proceed from petition_proceeding_dc_adc where case_no = '$case_no' limit 1")->result();
                    $proceeding_prem_id = $proceeding_prem[0]->proceed + 1;
                    //var_dump($proceeding_id);
                    $date_entry = date('Y-m-d H:i:s');
                    $proceeding_prem_data = array(
                        'case_no' => $case_no,
                        'proceeding_id' => $proceeding_prem_id,
                        'date_of_hearing' => $hearing_date,
                        'co_order' => $dc_adc_order,
                        'note_on_order' => 'Generate Premium Notice',
                        //'next_date_of_hearing' => $hearing_date,
                        'status' => 'Pending',
                        'user_code' => $user_code,
                        'date_entry' => $date_entry,
                        'operation' => 'E',
                        'dist_code' => $location['dist_code'],
                        'subdiv_code' => $location['subdiv_code'],
                        'cir_code' => $location['cir_code']
                    );



                    $insert_ppd1 = $this->db->insert('petition_proceeding_dc_adc', $proceeding_prem_data);
                    if($insert_ppd1 != 1){
                        $this->db->trans_rollback();
                        log_message('error', '#ERRCONVDC0013: Insertion failed in petition_proceeding_dc_adc for case no :'. $case_no);
                        $json = [
                            'message'=>"#ERRCONVDC0013: Failed to in Proceeding for Case No : ".$case_no
                        ];
                        echo json_encode($json);
                        return false;
                    }
                    ////


                    if ($this->db->trans_status() == false) {
                        $this->db->trans_rollback();
                        $data = array(
                            'error' => "Error in submitting. Please try Again",
                        );
                    }
                    else
                    {

                        $penUser='ADC';
                        $rmrk='Forwarded by DC';
                        // $this->DashboardData($case_no,$penUser,$rmrk);
                        $this->ConversionModel->DashboardData($case_no,$penUser,$rmrk);
                        $status='M';
                        $task='DC';
                        $pen='ADC';

                        $rtps_status = $this->basundharamodel->postApiBasundharaSec($case_no,$rmrk,$status,$task,$pen);

                        if (trim($rtps_status) !="y") {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #ERRDCAPI003: Application unable to process case no # $case_no");
                            redirect(base_url() . "index.php/home");
                        } else {
                            $this->db->trans_commit();
                            $this->session->set_flashdata('message', "Notice for Premium Requested on Conversion case no # $case_no");
                            redirect(base_url() . "index.php/home");
                        }
                        ////////////////////////////////////////

                    }
                }
                // new addition for case forward to department
                elseif ($frwd_dept == 'Y') {
                    $endDate = HOLD_CASES_FORWARD_TO_DEPT_BY_DC_APTOPP;
                    $today   = date('Y-m-d H:i:s');
                    if(strtotime($endDate) < strtotime($today))
                    {
                        $this->session->set_flashdata('message', "#MR00313: Cases cannot be Forwarded to the department, as forwarding has been stopped...#" . $case_no);
                        redirect(base_url() . "index.php/home");
                        die();
                    }

                    // var_dump("i am in dept"); die;
                    $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from    petition_dag_details where "
                        . "dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and "
                        . "lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' "
                        . "and petition_no='$petition_basic->petition_no'")->row_array();

                    $m_dag_area_lc = $landdetails['m_dag_area_lc'];
                    $m_dag_area_lc = round($m_dag_area_lc);
                    $data['display'] = array(
                        'date' => date('Y-m-d H:i:s'),
                        'proceeding_id' => $proceeding_id,
                        'case_no' => $case_no,
                        'dag' => $landdetails['dag_no'],
                        'm_dag_area_b' => $landdetails['m_dag_area_b'],
                        'm_dag_area_k' => $landdetails['m_dag_area_k'],
                        'm_dag_area_lc' => $m_dag_area_lc,
                        'patta_no' => trim($landdetails['patta_no']),
                        'patta_type' => $landdetails['patta_type_code']
                    );
                    $data['patta_type'] = $this->db->query("select patta_type from    patta_code where type_code='$landdetails[patta_type_code]'")->row()->patta_type;

                    $proceeding = $this->db->query("select count(proceeding_id) as proceed from    petition_proceeding where case_no = '$case_no' limit 1")->result();
                    $proceeding_id = $proceeding[0]->proceed + 1;

                    $this->db->trans_begin();

                    $proceeding_data_end = array(
                        'case_no' => $case_no,
                        'proceeding_id' => $proceeding_id,
                        'date_of_hearing' => $hearing_date,
                        'co_order' => $dc_adc_order,
                        //'note_on_order' => '',
                        //'next_date_of_hearing' => $hearing_date,
                        'status' => 'Pending',
                        'user_code' => $user_code,
                        'date_entry' => $date_entry,
                        'operation' => 'E',
                        'dist_code' => $location['dist_code'],
                        'subdiv_code' => $location['subdiv_code'],
                        'cir_code' => $location['cir_code']
                    );
                    //var_dump($proceeding_data_end);


                    $insert_pp4 = $this->db->insert('petition_proceeding', $proceeding_data_end);
                    if($insert_pp4 != 1){
                        $this->db->trans_rollback();
                        log_message('error', '#ERRCONVDC0014: Insertion failed in petition_proceeding_dc_adc for case no :'. $case_no);
                        $json = [
                            'message'=>"#ERRCONVDC0014: Failed to in Proceeding for Case No : ".$case_no
                        ];
                        echo json_encode($json);
                        return false;
                    }

                    $proceeding_dc_adc = $this->db->query("select count(proceeding_id) as proceed from    petition_proceeding_dc_adc where case_no = '$case_no' limit 1")->result();
                    $proceeding_id_dc_adc = $proceeding_dc_adc[0]->proceed + 1;
                    $proceeding_data_end_dc_adc = array(
                        'case_no' => $case_no,
                        'proceeding_id' => $proceeding_id_dc_adc,
                        'date_of_hearing' => $hearing_date,
                        'co_order' => $dc_adc_order,
                        //'note_on_order' => '',
                        //'next_date_of_hearing' => $hearing_date,
                        'status' => 'Pending',
                        'user_code' => $user_code,
                        'date_entry' => $date_entry,
                        'operation' => 'E',
                        'dist_code' => $location['dist_code'],
                        'subdiv_code' => $location['subdiv_code'],
                        'cir_code' => $location['cir_code']
                    );
                    //var_dump($proceeding_data_end_dc_adc);


                    $insert_ppd2 = $this->db->insert('petition_proceeding_dc_adc', $proceeding_data_end_dc_adc);
                    if($insert_ppd2 != 1){
                        $this->db->trans_rollback();
                        log_message('error', '#ERRCONVDC0015: Insertion failed in petition_proceeding_dc_adc for case no :'. $case_no);
                        $json = [
                            'message'=>"#ERRCONVDC0015: Failed to in Proceeding for Case No : ".$case_no
                        ];
                        echo json_encode($json);
                        return false;
                    }
                    //exit();
                    $order_type = $this->db->query("select * from    master_office_mut_type where order_type_code ='$petition_basic->mut_type'")->row();
                    $lm_premium = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
                        . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and "
                        . "mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and co_reject is NULL order by note_no desc limit 1")->row();

                    $q = "Select * from    lm_code where lm_code = '$lm_premium->lm_code' and dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
                        . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no'";

                    $name_of_lm = $this->db->query("Select * from    lm_code where lm_code = '$lm_premium->lm_code' and dist_code='$petition_basic->dist_code' "
                        . "and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and lot_no='$petition_basic->lot_no'")->row();
                    $name_of_lm = $name_of_lm->lm_name;

                    $skname = $this->db->query("select * from    users where user_code='$lm_premium->user_code'  and dist_code='$petition_basic->dist_code' "
                        . "and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code'")->row();
                    $sk_name = $skname->username;
                    $data['display'] = array(
                        'date' => date('Y-m-d H:i:s'),
                        'proceeding_id' => $proceeding_id,
                        'case_no' => $case_no,
                        'order_type' => $order_type->order_type,
                        'co_name' => $petition_basic->add_off_name,
                        'co_order_date' => $petition_basic->co_order_conv_date,
                        'sk_note_date' => $lm_premium->sk_note_date,
                        'lm_note_date' => $lm_premium->lm_sign_date,
                        'lm_name' => $name_of_lm,
                        'sk_name' => $sk_name,
                        'co_code' => $petition_basic->add_off_desig,
                        'lm_code' => $lm_premium->lm_code,
                        'sk_code' => $lm_premium->user_code
                    );
                    $this->db->query("UPDATE Petition_Basic SET add_off_desig = 'DPT', status = 'W', user_code = 'DPT1', new_status='DCDPT', dept_js_approve=null, adlr_remark=null, adlr_code=null, adlr_asign_code=null, adlr_verification=null WHERE "
                        . "case_no = '$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                        . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'");

                    if ($this->db->affected_rows() == 0) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRCONVDC0016: Updation failed in petition_basic Case No ' . $case_no);
                        $data = array(
                            'error' => "#ERRCONVDC0016: Registration of Petition basic for case no : " . $case_no,
                        );
                        echo json_encode($data);
                        return false;
                    }


                    if ($this->db->trans_status() == false) {
                        $this->db->trans_rollback();
                        $data = array(
                            'error' => "Error in submitting. Please try Again",
                        );
                    }
                    else
                    {
                        ///////////////////////////////////////
                        $penUser='DPT';
                        $rmrk='Forwarded by DC';
                        // $this->DashboardData($case_no,$penUser,$rmrk);
                        $status='M';
                        $task='DC';
                        $pen='DPT';


                        $rtps_status = $this->basundharamodel->postApiBasundharaSec($case_no,$rmrk,$status,$task,$pen);
                        //var_dump($rtps_status);
                        if (trim($rtps_status) !="y") {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #ERRDCAPI004: Application unable to process case no # $case_no");
                            redirect(base_url() . "index.php/home");
                        } else {
                            $this->db->trans_commit();

                        }
                        ////////////////////////////////////////              


                    }
                    $this->session->set_flashdata('message', "Forwarded to Department: Conversion case no # $case_no");
                    redirect(base_url() . "index.php/home");
                    // new department addition end
                }
                $this->session->set_flashdata('message', "Continue Hearing: Conversion case no # $case_no");
                redirect(base_url() . "index.php/home");

            } else {
                $proceeding = $this->db->query("select count(proceeding_id) as proceed from    petition_proceeding where case_no = '$case_no' limit 1")->result();
                $proceeding_id = $proceeding[0]->proceed + 1;

                $this->db->trans_begin();

                $proceeding_data_end = array(
                    'case_no' => $case_no,
                    'proceeding_id' => $proceeding_id,
                    'date_of_hearing' => $hearing_date,
                    'co_order' => $dc_adc_order,
                    //'note_on_order' => '',
                    //'next_date_of_hearing' => $hearing_date,
                    'status' => 'disposed',
                    'user_code' => $user_code,
                    'date_entry' => $date_entry,
                    'operation' => 'E',
                    'dist_code' => $location['dist_code'],
                    'subdiv_code' => $location['subdiv_code'],
                    'cir_code' => $location['cir_code']
                );


                $insert_pp5 = $this->db->insert('petition_proceeding', $proceeding_data_end);
                if($insert_pp5 != 1){
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCONVDC0017: Insertion failed in petition_proceeding for case no :'. $case_no);
                    $json = [
                        'message'=>"#ERRCONVDC0017: Failed to in Proceeding for Case No : ".$case_no
                    ];
                    echo json_encode($json);
                    return false;
                }

                $proceeding_dc_adc = $this->db->query("select count(proceeding_id) as proceed from    petition_proceeding_dc_adc where case_no = '$case_no' limit 1")->result();
                $proceeding_id_dc_adc = $proceeding_dc_adc[0]->proceed + 1;
                $proceeding_data_end_dc_adc = array(
                    'case_no' => $case_no,
                    'proceeding_id' => $proceeding_id_dc_adc,
                    'date_of_hearing' => $hearing_date,
                    'co_order' => $dc_adc_order,
                    //'note_on_order' => '',
                    //'next_date_of_hearing' => $hearing_date,
                    'status' => 'disposed',
                    'user_code' => $user_code,
                    'date_entry' => $date_entry,
                    'operation' => 'E',
                    'dist_code' => $location['dist_code'],
                    'subdiv_code' => $location['subdiv_code'],
                    'cir_code' => $location['cir_code']
                );


                $insert_ppd3 =  $this->db->insert('petition_proceeding_dc_adc', $proceeding_data_end_dc_adc);
                if($insert_ppd3 != 1){
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCONVDC0018: Insertion failed in petition_proceeding_dc_adc for case no :'. $case_no);
                    $json = [
                        'message'=>"#ERRCONVDC0018: Failed to in Proceeding for Case No : ".$case_no
                    ];
                    echo json_encode($json);
                    return false;
                }

                $this->db->query("UPDATE petition_basic SET proceeding_yn = 'y' , status = 'D' WHERE case_no = '$case_no' and dist_code='$dist_code' and "
                    . "subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
                    . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'");

                if ($this->db->affected_rows() == 0) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCONVDC0019: Updation failed in petition_basic Case No ' . $case_no);
                    $data = array(
                        'error' => "#ERRCONVDC0019: Registration of Petition basic for case no : " . $case_no,
                    );
                    echo json_encode($data);
                    return false;
                }

                if ($this->db->trans_status() == false) {
                    $this->db->trans_rollback();
                    $data = array(
                        'error' => "Error in submitting. Please try Again",
                    );
                }
                else
                {
                    $this->db->trans_commit();
                    $this->session->set_flashdata('message', "Conversion Case no # $case_no is dismissed..");
                    redirect(base_url() . "index.php/home");
                }
            }
        }
    }

    public function ThirdProceeding() {
        $db=  $this->session->userdata('db');
        $case_no = $this->session->userdata('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code1');
        $cir_code = $this->session->userdata('cir_code1');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code1');
        $lot_no = $this->session->userdata('lot_no1');
        $vill_townprt_code = $this->session->userdata('vill_townprt_code1');

        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
            . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row();
        $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,date_entry,add_off_name,next_date_of_hearing"
            . " from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
            . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row_array();

        $proceeding = $this->db->query("select count(proceeding_id) as proceed from    petition_proceeding where case_no = '$case_no' and "
            . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' limit 1")->result();
        $proceeding_id = $proceeding[0]->proceed + 1;

        $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from    petition_dag_details where "
            . "dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' "
            . "and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' "
            . "and petition_no='$petition_basic->petition_no'")->row_array();

        $order_type = $this->db->query("select * from    master_office_mut_type where order_type_code ='$petition_basic->mut_type'")->row();

        $lm_premium = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
            . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and "
            . "mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and co_reject is NULL order by note_no desc limit 1")->row();

        $q = "Select * from    lm_code where lm_code = '$lm_premium->lm_code'";

        $name_of_lm = $this->db->query("Select * from    lm_code where lm_code = '$lm_premium->lm_code' and dist_code='$petition_basic->dist_code' "
            . "and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no'")->row();
        $name_of_lm = $name_of_lm->lm_name;
        $skname = $this->db->query("select * from    users where user_code='$lm_premium->user_code'  and dist_code='$petition_basic->dist_code' "
            . "and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code'")->row();
        $sk_name = $skname->username;
        $data['display'] = array(
            'date' => date('Y-m-d H:i:s'),
            'proceeding_id' => $proceeding_id,
            'case_no' => $case_no,
            'order_type' => $order_type->order_type,
            'co_name' => $petition_basic->add_off_name,
            'co_order_date' => $petition_basic->co_order_conv_date,
            'sk_note_date' => $lm_premium->sk_note_date,
            'lm_note_date' => $lm_premium->lm_sign_date,
            'lm_name' => $name_of_lm,
            'sk_name' => $sk_name,
            'co_code' => $petition_basic->add_off_desig,
            'lm_code' => $lm_premium->lm_code,
            'sk_code' => $lm_premium->user_code
        );
        $data['patta_type'] = $this->db->query("select patta_type from    patta_code "
            . " where type_code='$landdetails[patta_type_code]'")->row()->patta_type;
        if (isset($_POST['submit2'])) {
            // $this->load->helper('html');
            // $this->load->view('../views/header');
            // $this->load->view('../views/dc_adc_office_conversion/Second_Proceeding_2', $data);
            // $this->load->view('../views/footer');

            $data['_view'] = 'dc_adc_office_conversion/Second_Proceeding_2';
            $this->load->view('layouts/main',$data);
        }
        if (isset($_POST['submit1'])) {
            $this->session->set_flashdata('message', "Order Cancelled for Conversion case no # $case_no");
            redirect(base_url() . "index.php/home");
        }
    }

    public function FourthProceedingCo() {
        //form validation
        $formValidation = $this->FormValidationModel->formValidationForPost($_POST, [
            'case_no'=>'Case No.|required|case_no',
            'order_no'=>'Order No.|required|case_no',
            'lm_name'=>'LM Name|required',
            'order_date'=>'Order Date|required|date',
            'lm_sign'=>'LM Sign|required|char',
            'order_type'=>'Order Type|required',
            'lm_sign_date'=>'LM Sign Date|required|date',
            'order_passed_by'=>'Order passed by|required',
            'sk_name'=>'SK Name|required',
            'order_passed_sign'=>'Order passed sign|required|char',
            'sk_sign'=>'SK Sign|required|char',
            'sk_sign_date'=>'SK Sign Date|required|date',
            'co_name'=>'CO Name|required',
            'co_order_date'=>'CO Order date|required|date',
            'co_sign'=>'CO Sign|required|char',
            'co_code'=>'CO Code|required',
            'lm_code'=>'LM Code|required',
            'sk_code'=>'SK Code|required'
        ]);
        if($formValidation['status'] == 'n') {
            //ERRCONVCOUPDCHITHACOEND20001
            log_message('error', 'Message: '. $formValidation['message'] .', Data: '. json_encode($formValidation['data']) .'. Error: ERRCONVCOUPDCHITHACOEND20001');
            $this->session->set_flashdata('message', $formValidation['message'] .' Error: ERRCONVCOUPDCHITHACOEND20001');
            redirect(base_url('index.php/COconversionPartha/GoToCO?pro=6'));
        }

        //syntax validation
        $requestResponse = checkRequestSpecChar($_POST);
        if($requestResponse['status'] == 'n') {
            //ERRCONVCOUPDCHITHACOEND20002
            log_message('error', $requestResponse['messages'] . '. Error: ERRCONVCOUPDCHITHACOEND20002');
            $this->session->set_flashdata('message', 'Contains Illegal parameter values. Error: ERRCONVCOUPDCHITHACOEND20002');
            redirect(base_url('index.php/COconversionPartha/GoToCO?pro=6'));
        }

        //malicious query validation
        $validResponse = checkRequestValidQuery($_POST);
        if($validResponse['status'] == 'n') {
            //ERRCONVCOUPDCHITHACOEND20003
            log_message('error', $validResponse['messages'] . '. Error: ERRCONVCOUPDCHITHACOEND20003');
            $this->session->set_flashdata('message', 'Contains Malicious parameter values. Error: ERRCONVCOUPDCHITHACOEND20003');
            redirect(base_url('index.php/COconversionPartha/GoToCO?pro=6'));
        }

        //authorization
        $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'CO', $_POST['case_no'], CONV_CO_CHITHAUPD_COEND);
        if($authorization['status'] == 'n') {
            //ERRCONVCOUPDCHITHACOEND20004
            log_message('error', $authorization['messages'] . '. Error: ERRCONVCOUPDCHITHACOEND20004');
            $this->session->set_flashdata('message', $authorization['messages'].'. Error: ERRCONVCOUPDCHITHACOEND20004');
            redirect(base_url('index.php/home'));
        }
        // echo '<pre>';
        // var_dump($_POST, $authorization);
        // die();

        $db=  $this->session->userdata('db');
        $case_no = $this->session->userdata('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code1');
        $cir_code = $this->session->userdata('cir_code1');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code1');
        $lot_no = $this->session->userdata('lot_no1');
        $vill_townprt_code = $this->session->userdata('vill_townprt_code1');
        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
            . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row();

        $order_date = date('Y-m-d', strtotime($this->input->post('order_date')));
        $lm_name = $this->input->post('lm_name');
        $lm_sign = $this->input->post('lm_sign');
        $order_type = $this->input->post('order_type');
        $lm_sign_date = date('Y-m-d', strtotime($this->input->post('lm_sign_date')));
        $order_passed_by = $this->input->post('order_passed_by');
        $sk_name = $this->input->post('sk_name');
        $order_passed_sign = $this->input->post('order_passed_sign');
        $sk_sign = $this->input->post('sk_sign');
        $sk_sign_date = date('Y-m-d', strtotime($this->input->post('sk_sign_date')));
        $co_name = $this->input->post('co_name');
        $co_order_date = date('Y-m-d', strtotime($this->input->post('co_order_date')));
        $co_sign = $this->input->post('co_sign');
        $co_code = $this->input->post('co_code');
        $lm_code = $this->input->post('lm_code');
        $sk_code = $this->input->post('sk_code');

        $this->session->set_userdata(array('order_date' => $order_date, 'lm_sign' => $lm_sign, 'order_type' => $order_type, 'lm_sign_date' => $lm_sign_date, 'order_passed_by' => $order_passed_by, 'sk_sign' => $sk_sign, 'sk_sign_date' => $sk_sign_date, 'co_order_date' => $co_order_date, 'co_sign' => $co_sign, 'co_code' => $co_code, 'lm_code' => $lm_code, 'sk_code' => $sk_code));

        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
            . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row();

        $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,date_entry,add_off_name,next_date_of_hearing"
            . " from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
            . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row_array();

        $locationData = array(
            'dist_codee' => $location['dist_code'],
            'subdiv_codee' => $location['subdiv_code'],
            'cir_codee' => $location['cir_code'],
            'lot_noe' => $location['lot_no'],
            'vill_codee' => $location['vill_townprt_code'],
            'mouza_pargona_codee' => $location['mouza_pargona_code']
        );
        $this->session->set_userdata($locationData);
        $proceeding = $this->db->query("select count(proceeding_id) as proceed from    petition_proceeding where case_no = '$case_no' and "
            . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' limit 1")->result();
        $proceeding_id = $proceeding[0]->proceed + 1;

        $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from    petition_dag_details where "
            . "dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' "
            . "and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' "
            . "and petition_no='$petition_basic->petition_no'")->row_array();

        $order_type = $this->db->query("select * from    master_office_mut_type where order_type_code ='$petition_basic->mut_type'")->row();

        $lm_premium = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
            . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and "
            . "mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and co_reject is NULL order by note_no desc limit 1")->row();

        $data['display'] = array(
            'date' => date('Y-m-d H:i:s'),
            'proceeding_id' => $proceeding_id,
            'case_no' => $case_no,
            'order_type' => $order_type->order_type,
            'co_name' => $petition_basic->add_off_name,
            'co_order_date' => $petition_basic->co_order_conv_date,
            'sk_note_date' => $lm_premium->sk_note_date,
            'lm_note_date' => $lm_premium->lm_sign_date,
            'patta_no' => trim($landdetails['patta_no']),
            'patta_type' => $landdetails['patta_type_code'],
            'dag_no' => $landdetails['dag_no']
        );
        $data['patta_type'] = $this->db->query("select patta_type from    patta_code "
            . " where type_code='$landdetails[patta_type_code]'")->row()->patta_type;
        $patta_no = trim($landdetails['patta_no']);
        $patta_type = $landdetails['patta_type_code'];
        $type_of_premium = $lm_premium->prem_pay_method;
        $premium_reciept = $lm_premium->recpt_number;
        $premium_amount = $lm_premium->prim_tot;
        $bigha = $landdetails['m_dag_area_b'];
        $kotha = $landdetails['m_dag_area_k'];
        $lessa = $landdetails['m_dag_area_lc'];

        $this->load->model('patta/PattaModel');
        $data['dags'] = $this->PattaModel->getDagsByPattaNoConversion($patta_no, $patta_type, $location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['lot_no'], $location['vill_townprt_code'], $location['mouza_pargona_code'])->result();
        $this->session->set_userdata(array('dag_no' => $landdetails['dag_no']));

        $this->session->set_userdata(array('proceeding_id' => $proceeding_id, 'patta_no' => $patta_no, 'patta_type' => $patta_type, 'type_of_premium' => $type_of_premium, 'premium_reciept' => $premium_reciept, 'premium_amount' => $premium_amount, 'bigha' => $bigha, 'kotha' => $kotha, 'lessa' => $lessa,));
        //var_dump($this->session->all_userdata());
//        $this->load->helper('html');
//        $this->load->view('../views/header');
//        $this->load->view('../views/dc_adc_office_conversion/Second_Proceeding_3', $data);
//        $this->load->view('../views/footer');


        /////////////////////PROPERTY CHAIN CODE STARTED//////////////////////

        /////////////////////////////////////////////////////////////////////
        $ulpinCheckFlag = $this->input->post('ulpinCheckFlag', true);
        $compareCheckFlag = $this->input->post('compareCheckFlag', true);
        if($ulpinCheckFlag ==1 && $compareCheckFlag == 'Y' && ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {
            // property chain data

            $ulpin = $this->input->post('ulpin', true);
            $chain_revenue = $this->input->post('chain_revenue', true);
            $chain_local_tax = $this->input->post('chain_local_tax', true);
            $old_ulpin = $this->input->post('old_ulpin', true);
            if (!isset($old_ulpin))
                $old_ulpin = "";

            redirect(base_url() . "index.php/dc_conversion_mb/TestFinalForm?ulpin=" . $ulpin . "&chain_revenue=" . $chain_revenue . "&chain_local_tax=" . $chain_local_tax . "&old_ulpin=" . $old_ulpin. "&ulpinCheckFlag=" . $ulpinCheckFlag . "&compareCheckFlag=" . $compareCheckFlag);
        }
        redirect(base_url() . "index.php/dc_conversion_mb/TestFinalForm");
    }

    public function FourthProceeding() {
        //form validation
        $formValidation = $this->FormValidationModel->formValidationForPost($_POST, [
            'case_no'=>'Case No.|required|case_no',
            'order_no'=>'Order No.|required|case_no',
            'lm_name'=>'LM Name|required',
            'order_date'=>'Order Date|required|date',
            'lm_sign'=>'LM Sign|required|char',
            'order_type'=>'Order Type|required',
            'lm_sign_date'=>'LM Sign Date|required|date',
            'order_passed_by'=>'Order passed by|required',
            'sk_name'=>'SK Name|required',
            'order_passed_sign'=>'Order passed sign|required|char',
            'sk_sign'=>'SK Sign|required|char',
            'sk_sign_date'=>'SK Sign Date|required|date',
            'co_name'=>'CO Name|required',
            'co_order_date'=>'CO Order date|required|date',
            'co_sign'=>'CO Sign|required|char',
            'co_code'=>'CO Code|required',
            'lm_code'=>'LM Code|required',
            'sk_code'=>'SK Code|required'
        ]);
        if($formValidation['status'] == 'n') {
            //ERRCONVCOUPDCHITHA20001
            log_message('error', 'Message: '. $formValidation['message'] .', Data: '. json_encode($formValidation['data']) .'. Error: ERRCONVCOUPDCHITHA20001');
            $this->session->set_flashdata('message', $formValidation['message'] .' Error: ERRCONVCOUPDCHITHA20001');
            redirect(base_url('index.php/COconversionPartha/GoToCO?pro=6'));
        }

        //syntax validation
        $requestResponse = checkRequestSpecChar($_POST);
        if($requestResponse['status'] == 'n') {
            //ERRCONVCOUPDCHITHA20002
            log_message('error', $requestResponse['messages'] . '. Error: ERRCONVCOUPDCHITHA20002');
            $this->session->set_flashdata('message', 'Contains Illegal parameter values. Error: ERRCONVCOUPDCHITHA20002');
            redirect(base_url('index.php/COconversionPartha/GoToCO?pro=6'));
        }

        //malicious query validation
        $validResponse = checkRequestValidQuery($_POST);
        if($validResponse['status'] == 'n') {
            //ERRCONVCOUPDCHITHA20003
            log_message('error', $validResponse['messages'] . '. Error: ERRCONVCOUPDCHITHA20003');
            $this->session->set_flashdata('message', 'Contains Malicious parameter values. Error: ERRCONVCOUPDCHITHA20003');
            redirect(base_url('index.php/COconversionPartha/GoToCO?pro=6'));
        }

        //authorization
        $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'CO', $_POST['case_no'], CONV_CO_CHITHAUPD);
        if($authorization['status'] == 'n') {
            //ERRCONVCOUPDCHITHA20004
            log_message('error', $authorization['messages'] . '. Error: ERRCONVCOUPDCHITHA20004');
            $this->session->set_flashdata('message', $authorization['messages'].'. Error: ERRCONVCOUPDCHITHA20004');
            redirect(base_url('index.php/home'));
        }
        // echo '<pre>';
        // var_dump($_POST, $authorization);
        // die();

        $db=  $this->session->userdata('db');
        $case_no = $this->session->userdata('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code1');
        $cir_code = $this->session->userdata('cir_code1');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code1');
        $lot_no = $this->session->userdata('lot_no1');
        $vill_townprt_code = $this->session->userdata('vill_townprt_code1');
        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
            . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row();

        $order_date = date('Y-m-d', strtotime($this->input->post('order_date')));
        $lm_name = $this->input->post('lm_name');
        $lm_sign = $this->input->post('lm_sign');
        $order_type = $this->input->post('order_type');
        $lm_sign_date = date('Y-m-d', strtotime($this->input->post('lm_sign_date')));
        $order_passed_by = $this->input->post('order_passed_by');
        $sk_name = $this->input->post('sk_name');
        $order_passed_sign = $this->input->post('order_passed_sign');
        $sk_sign = $this->input->post('sk_sign');
        $sk_sign_date = date('Y-m-d', strtotime($this->input->post('sk_sign_date')));
        $co_name = $this->input->post('co_name');
        $co_order_date = date('Y-m-d', strtotime($this->input->post('co_order_date')));
        $co_sign = $this->input->post('co_sign');
        $co_code = $this->input->post('co_code');
        $lm_code = $this->input->post('lm_code');
        $sk_code = $this->input->post('sk_code');

        $this->session->set_userdata(array('order_date' => $order_date, 'lm_sign' => $lm_sign, 'order_type' => $order_type, 'lm_sign_date' => $lm_sign_date, 'order_passed_by' => $order_passed_by, 'sk_sign' => $sk_sign, 'sk_sign_date' => $sk_sign_date, 'co_order_date' => $co_order_date, 'co_sign' => $co_sign, 'co_code' => $co_code, 'lm_code' => $lm_code, 'sk_code' => $sk_code));

        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
            . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row();

        $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,date_entry,add_off_name,next_date_of_hearing"
            . " from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
            . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row_array();

        $locationData = array(
            'dist_codee' => $location['dist_code'],
            'subdiv_codee' => $location['subdiv_code'],
            'cir_codee' => $location['cir_code'],
            'lot_noe' => $location['lot_no'],
            'vill_codee' => $location['vill_townprt_code'],
            'mouza_pargona_codee' => $location['mouza_pargona_code']
        );
        $this->session->set_userdata($locationData);
        $proceeding = $this->db->query("select count(proceeding_id) as proceed from    petition_proceeding where case_no = '$case_no' and "
            . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' limit 1")->result();
        $proceeding_id = $proceeding[0]->proceed + 1;

        $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from    petition_dag_details where "
            . "dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' "
            . "and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' "
            . "and petition_no='$petition_basic->petition_no'")->row_array();

        $order_type = $this->db->query("select * from    master_office_mut_type where order_type_code ='$petition_basic->mut_type'")->row();

        $lm_premium = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
            . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and "
            . "mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and co_reject is NULL order by note_no desc limit 1")->row();

        $data['display'] = array(
            'date' => date('Y-m-d H:i:s'),
            'proceeding_id' => $proceeding_id,
            'case_no' => $case_no,
            'order_type' => $order_type->order_type,
            'co_name' => $petition_basic->add_off_name,
            'co_order_date' => $petition_basic->co_order_conv_date,
            'sk_note_date' => $lm_premium->sk_note_date,
            'lm_note_date' => $lm_premium->lm_sign_date,
            'patta_no' => trim($landdetails['patta_no']),
            'patta_type' => $landdetails['patta_type_code'],
            'dag_no' => $landdetails['dag_no']
        );
        $data['patta_type'] = $this->db->query("select patta_type from    patta_code "
            . " where type_code='$landdetails[patta_type_code]'")->row()->patta_type;
        $patta_no = trim($landdetails['patta_no']);
        $patta_type = $landdetails['patta_type_code'];
        $type_of_premium = $lm_premium->prem_pay_method;
        $premium_reciept = $lm_premium->recpt_number;
        $premium_amount = $lm_premium->prim_tot;
        $bigha = $landdetails['m_dag_area_b'];
        $kotha = $landdetails['m_dag_area_k'];
        $lessa = $landdetails['m_dag_area_lc'];

        $this->load->model('patta/PattaModel');
        $data['dags'] = $this->PattaModel->getDagsByPattaNoConversion($patta_no, $patta_type, $location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['lot_no'], $location['vill_townprt_code'], $location['mouza_pargona_code'])->result();
        $this->session->set_userdata(array('dag_no' => $landdetails['dag_no']));

        $this->session->set_userdata(array('proceeding_id' => $proceeding_id, 'patta_no' => $patta_no, 'patta_type' => $patta_type, 'type_of_premium' => $type_of_premium, 'premium_reciept' => $premium_reciept, 'premium_amount' => $premium_amount, 'bigha' => $bigha, 'kotha' => $kotha, 'lessa' => $lessa,));
        //var_dump($this->session->all_userdata());
//        $this->load->helper('html');
//        $this->load->view('../views/header');
//        $this->load->view('../views/dc_adc_office_conversion/Second_Proceeding_3', $data);
//        $this->load->view('../views/footer');


        /////////////////////PROPERTY CHAIN CODE STARTED//////////////////////

        /////////////////////////////////////////////////////////////////////
        $ulpinCheckFlag = $this->input->post('ulpinCheckFlag', true);
        $compareCheckFlag = $this->input->post('compareCheckFlag', true);
        if($ulpinCheckFlag ==1 && $compareCheckFlag == 'Y' && ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {
            // property chain data

            $ulpin = $this->input->post('ulpin', true);
            $chain_revenue = $this->input->post('chain_revenue', true);
            $chain_local_tax = $this->input->post('chain_local_tax', true);
            $old_ulpin = $this->input->post('old_ulpin', true);
            if (!isset($old_ulpin))
                $old_ulpin = "";

            redirect(base_url() . "index.php/dc_conversion_mb/TestFinalForm?ulpin=" . $ulpin . "&chain_revenue=" . $chain_revenue . "&chain_local_tax=" . $chain_local_tax . "&old_ulpin=" . $old_ulpin. "&ulpinCheckFlag=" . $ulpinCheckFlag . "&compareCheckFlag=" . $compareCheckFlag);
        }
        redirect(base_url() . "index.php/dc_conversion_mb/TestFinalForm");
    }

    public function FifthProceeding() {
        $db=  $this->session->userdata('db');
        $dag_no = $this->input->post('dag_no');
        $this->session->set_userdata(array('dag_no' => $dag_no));
        redirect(base_url() . "index.php/dc_conversion_mb/TestFinalForm");
    }

    public function TestFinalForm() {
        $db=  $this->session->userdata('db');
        $case_no = $this->session->userdata('case_no');
        $proceeding_id = $this->session->userdata('proceeding_id');
        $patta_no = trim($this->session->userdata('patta_no'));
        $dag = $this->session->userdata('dag_no');
        var_dump("ERRSESSION001: Please Contact Administartor"); die;
        //$patta_no = trim($this->session->userdata('patta_no'));
        $patta_type = $this->session->userdata('patta_type');
        $type_of_premium = $this->session->userdata('type_of_premium');
        $premium_reciept = $this->session->userdata('premium_reciept');
        $premium_amount = $this->session->userdata('premium_amount');
        $bigha = $this->session->userdata('bigha');
        $kotha = $this->session->userdata('kotha');
        $lessa = $this->session->userdata('lessa');
        //$patta_no = $this->session->userdata('patta_no');
        $patta_name = $this->db->query("select patta_type from    patta_code "
            . " where type_code='$patta_type'")->row();

        $dist_code = $this->session->userdata('dist_codee');
        $subdiv_code = $this->session->userdata('subdiv_codee');
        $cir_code = $this->session->userdata('cir_codee');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_codee');
        $lot_no = $this->session->userdata('lot_noe');
        $vill_townprt_code = $this->session->userdata('vill_codee');

        $data['location'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_code' => $vill_townprt_code,

        );
        $rev_and_tax = "Select * from    chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
            . "and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' and patta_type_code= '$patta_type'";
        $rev_and_tax = $this->db->query($rev_and_tax)->row();
        //var_dump($rev_and_tax);
        $old_b = $rev_and_tax->dag_area_b;
        $old_k = $rev_and_tax->dag_area_k;
        $old_lc = $rev_and_tax->dag_area_lc;
        $old_dag_revenue = $rev_and_tax->dag_revenue;
        $old_g = 0.0;
        $old_kr = 0.0;
        $converted_to_lessa_old = ($old_b) * 100 + ($old_k) * 20 + ($old_lc);
        $onelessa = ($old_dag_revenue / $converted_to_lessa_old);
        $hundredlessa = $onelessa * 100;

        $converted_b = $bigha;
        $converted_k = $kotha;
        $converted_lc = $lessa;
        $converted_g = 0.0;
        $converted_kr = 0.0;
        $converted_to_lessa_new = ($converted_b) * 100 + ($converted_k) * 20 + ($converted_lc);

        if ($converted_to_lessa_new < 100) {
            $cal_new_rev = round($hundredlessa, 2);
            $new_dag_local_tax = round($cal_new_rev / 4, 2);
        } else {

            $remaining_lessa = $converted_to_lessa_new;
//                    $b = round(floor($remaining_lessa/100));
//                    $remainder=$remaining_lessa%100;
//                    $k = round(floor($remainder/20));
//                    $lc = round(floor($remainder%20));
//                    $g = 0.0;
//                    $kr = 0.0;
//                    $saperating_bigha = $remaining_lessa-($b*100);
            $cal_new_rev = round($onelessa * $remaining_lessa, 2);
            $new_dag_local_tax = round($cal_new_rev / 4, 2);
        }

        $check_dag_no = "Select dag_no from    chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
            . "and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' order by dag_no_int asc";
        //echo $check_dag_no;
        $data['check_dag_no'] = $this->db->query($check_dag_no)->result();

        $check_patta_no = "Select distinct (patta_no) as patta_no from    chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
            . "and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' and TRIM(patta_no)!='' and TRIM(patta_no)!='.' order by patta_no asc";
        //echo $check_patta_no;
        $data['check_patta_no'] = $this->db->query($check_patta_no)->result();

        $sql = "Select dag_no from    chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
            . "and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' and patta_type_code= '$patta_type'";
        //echo $sql;
        $dag_no = $data['oldDag'] = $this->db->query($sql)->result();
        //var_dump($dag_no);
        $newDag = 0;
        foreach ($dag_no as $d) {
            $d = $d->dag_no;
            if ($newDag < $d) {
                $newDag = $d;
            }
        }
        $sqll = "Select patta_no from    chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
            . "and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' and patta_type_code= '$patta_type'";
        $patta = $data['oldPatta'] = $this->db->query($sqll)->result();
        $newpatta = 0;
        foreach ($patta as $p) {
            $p = trim($p->patta_no);
            if ($newpatta < $p) {
                $newpatta = $p;
            }
        }

        $data['datas'] = array(
            'proceeding_id' => $proceeding_id,
            'patta_no' => trim($patta_no),
            'patta_type' => $patta_name->patta_type,
            'type_of_premium' => $type_of_premium,
            'premium_reciept' => $premium_reciept,
            'premium_amount' => round($premium_amount, 2),
            'bigha' => $bigha,
            'kotha' => $kotha,
            'lessa' => round($lessa, 2),
            'dag_no' => $dag,
            'new_dag' => $newDag + 1,
            'newpatta' => $newpatta + 1,
            'revenue' => $cal_new_rev,
            'local_tax' => $new_dag_local_tax
        );

        $data['payment_type'] = $this->db->query("Select * from    premium_chalan_receipt where code = '$type_of_premium'")->row();

        $data['type'] = $this->db->query("SELECT * from patta_code where mutation='a' ")->result();
        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' "
            . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row();
        $data['petition_basic'] = $petition_basic;
        //var_dump($petition_basic);
        $data['pattadar_details'] = $this->db->query("Select * from    petitioner_part where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
            . "and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' and patta_type_code= '$patta_type' and dag_no = '$dag' and TRIM(patta_no) = '$patta_no' and petition_no = '$petition_basic->petition_no'")->result();


        $this->load->model('patta/PattaModel');
        // $this->load->view('../views/header');
        // $this->load->view('../views/dc_adc_office_conversion/Test_Proceeding_4', $data);
        // $this->load->view('../views/footer');


        if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {

            $data['propChainEnableFlag'] = $this->PropChainCommonModel->isLocationEnable($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code);

            $data['ulpin'] = $this->input->get('ulpin', true);
            $data['revenue'] = $this->input->get('chain_revenue', true);
            $data['local_tax'] = $this->input->get('chain_local_tax', true);
            $data['old_ulpin'] = $this->input->get('old_ulpin', true);
            $data['ulpinCheck'] = $this->input->get('ulpinCheckFlag', true);
            $data['chithaPropChainCmpFlag'] = $this->input->get('compareCheckFlag', true);
            if (!isset($data['old_ulpin']))
                $data['old_ulpin'] = "";
        }


        if($petition_basic->bo_note_yn == 'Y' && $petition_basic->pay_notice_gen_yn == null) {
            $data['post_url'] = 'index.php/dc_conversion_mb/FinalSaveTest';
        }
        else if($petition_basic->bo_note_yn == null && $petition_basic->pay_notice_gen_yn == 'Y') {
            $data['post_url'] = 'index.php/dc_conversion_mb/FinalSaveTestCo';
        }
        $data['_view'] = 'dc_adc_office_conversion/Test_Proceeding_4';
        $this->load->view('layouts/main',$data);
    }

    public function FinalSaveTestCo() {
        //form validation
        $formValidation = $this->FormValidationModel->formValidationForPost($_POST, [
            'pdar_cron_no'=>'Pattadar Cron No.|digit',
            'prem_type'=>'Premium Type|required',
            //    'chalan_no'=>'Challan No|required',
            'prem_amt'=>'Premium Amount|3_digit_decimal',
            'c_bigha'=>'C Bigha|required|digit',
            'c_kotha'=>'C Katha|required|katha',
            'c_lessa'=>'C Lessa|required|lessa',
            'patta_type'=>'Patta Type|required',
            'patta_no'=>'Patta No.|required|digit',
            'new_patta_type'=>'New Patta Type|required|digit',
            'sugg_dag_no'=>'Suggested Dag No.|required|digit',
            'old_dag_no'=>'Old Dag No.|required|digit',
            'sugg_patta_no'=>'Suggested Patta No.|required|digit',
            'old_patta_no'=>'Old Patta No.|required|digit',
            'dag_revenue'=>'Dag Revenue|required|2_digit_decimal',
            'dag_local_tax'=>'Dag Local Tax|required|2_digit_decimal',
            'land_portion_status'=>'Land Portion Status|required'
        ]);
        if($formValidation['status'] == 'n') {
            //ERRCONVCOUPDCHITHACOEND30001
            log_message('error', 'Message: '. $formValidation['message'] .', Data: '. json_encode($formValidation['data']) .'. Error: ERRCONVCOUPDCHITHACOEND30001');
            $this->session->set_flashdata('message', $formValidation['message'] .' Error: ERRCONVCOUPDCHITHACOEND30001');
            redirect(base_url('index.php/dc_conversion_mb/TestFinalForm'));
        }

        //syntax validation
        $requestResponse = checkRequestSpecChar($_POST);
        if($requestResponse['status'] == 'n') {
            //ERRCONVCOUPDCHITHACOEND30002
            log_message('error', $requestResponse['messages'] . '. Error: ERRCONVCOUPDCHITHACOEND30002');
            $this->session->set_flashdata('message', 'Contains Illegal parameter values. Error: ERRCONVCOUPDCHITHACOEND30002');
            redirect(base_url('index.php/dc_conversion_mb/TestFinalForm'));
        }

        //malicious query validation
        $validResponse = checkRequestValidQuery($_POST);
        if($validResponse['status'] == 'n') {
            //ERRCONVCOUPDCHITHACOEND30003
            log_message('error', $validResponse['messages'] . '. Error: ERRCONVCOUPDCHITHACOEND30003');
            $this->session->set_flashdata('message', 'Contains Malicious parameter values. Error: ERRCONVCOUPDCHITHACOEND30003');
            redirect(base_url('index.php/dc_conversion_mb/TestFinalForm'));
        }

        //authorization
        $db=  $this->session->userdata('db');
        $case_no = $this->session->userdata('case_no');
        $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'CO', $case_no, CONV_CO_CHITHAUPD_COEND);
        if($authorization['status'] == 'n') {
            //ERRCONVCOUPDCHITHACOEND30004
            log_message('error', $authorization['messages'] . '. Error: ERRCONVCOUPDCHITHACOEND30004');
            $this->session->set_flashdata('message', $authorization['messages'].'. Error: ERRCONVCOUPDCHITHACOEND30004');
            redirect(base_url('index.php/home'));
        }

        //    echo '<pre>';
        //    var_dump($_POST, $authorization);
        //    die();

        $this->db->trans_begin();
        $data = array();
        $dist_code = $this->session->userdata('dist_codee');
        $subdiv_code = $this->session->userdata('subdiv_codee');
        $cir_code = $this->session->userdata('cir_codee');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_codee');
        $lot_no = $this->session->userdata('lot_noe');
        $vill_townprt_code = $this->session->userdata('vill_codee');


        $proceeding_id = $this->session->userdata('proceeding_id');

        $type_of_premium = $this->session->userdata('type_of_premium');
        $premium_reciept = $this->session->userdata('premium_reciept');
        $premium_amount = $this->session->userdata('premium_amount');
        $bigha = $this->session->userdata('bigha');
        $kotha = $this->session->userdata('kotha');
        $lessa = $this->session->userdata('lessa');
        $order_date = $this->session->userdata('order_date');

        $patta_no = trim($this->session->userdata('patta_no'));
        $dag = $this->session->userdata('dag_no');
        var_dump("ERRSESSION002: Please Contact Administartor"); die;
        $patta_type = $this->session->userdata('patta_type');

        $new_patta_type = $this->input->post('new_patta_type');
        $sugg_patta_no = trim($this->input->post('sugg_patta_no'));
        $old_patta_no = trim($this->input->post('old_patta_no'));
        $sugg_dag_no = $this->input->post('sugg_dag_no');
        $old_dag_no = $this->input->post('old_dag_no');
        $land_portion_status = $this->input->post('land_portion_status'); // N
        $revenue = $this->input->post('dag_revenue');
        $local_tax = $this->input->post('dag_local_tax');


        $lm_sign = $this->session->userdata('lm_sign');
        $order_type = $this->session->userdata('order_type');
        $lm_sign_date = $this->session->userdata('lm_sign_date');
        $order_passed_by = $this->session->userdata('order_passed_by');
        $sk_sign = $this->session->userdata('sk_sign');
        $sk_sign_date = $this->session->userdata('sk_sign_date');
        $co_order_date = $this->session->userdata('co_order_date');
        $co_sign = $this->session->userdata('co_sign');
        $co_code = $this->session->userdata('user_code');
        $lm_code = $this->session->userdata('lm_code');
        $sk_code = $this->session->userdata('sk_code');
        //$land_portion_status = $this->session->userdata('land_portion_status');


        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' "
            . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row();
        $petition_no = $petition_basic->petition_no;
        $type_of_conversion = $petition_basic->trans_code;
        //echo $type_of_conversion;

        $year_no = $petition_basic->year_no;
        $pattadar_details = $this->db->query("Select * from    petitioner_part where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
            . "and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' and patta_type_code= '$patta_type' and dag_no = '$dag' and TRIM(patta_no) = '$patta_no' and petition_no = '$petition_no'")->result();

        //$revenue = $this->db->query("Select * from    petition_dag_details where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
        //. "and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' and patta_type_code= '$patta_type' and dag_no = '$dag' and TRIM(patta_no) = '$patta_no'")->row();



        //==========check dag pending in blockchain or not=================
        if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {
            $this->load->model('propChain/PropChainCommonModel');
            $checkVal = $this->PropChainCommonModel->checkDagExistsInPropChainInPending($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$dag);
            if($checkVal === false)
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "#ERRORBLOCCHAIN1894 : You cannot procced as dag no is pending for property chain update...");
                redirect(base_url() . "index.php/home");
            }
        }
        ///=============end CODE=====================

        $chitha_rmk_ordbasic = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code,
            'dag_no' => $dag,
            'year_no' => $year_no,
            'petition_no' => $petition_no,
            'ord_no' => $case_no,
            'ord_date' => $order_date,
            'ord_type_code' => '01',
            'case_no' => $case_no,
            'ord_on_gl_type' => '',
            'ord_passby_sign_yn' => 'Y',
            'ord_passby_desig' => $order_passed_by,
            'ord_ref_let_no' => '',
            'lm_code' => $lm_code,
            'lm_sign_yn' => $lm_sign,
            'lm_sign_date' => $lm_sign_date,
            'sk_code' => $sk_code,
            'sk_sign_yn' => $sk_sign,
            'sk_sign_date' => $sk_sign_date,
            'co_code' => $co_code,
            'co_sign_yn' => $co_sign,
            'co_ord_date' => $co_order_date,
            'm_dag_area_b' => $bigha,
            'm_dag_area_k' => $kotha,
            'm_dag_area_lc' => $lessa, //
            'm_dag_area_g' => '0.0000',
            'm_dag_area_kr' => '0',
            //'area_left_b'=>'',
            //'area_left_k'=>'',
            //'area_left_lc'=>'',
            //'area_left_g'=>'',
            //'area_left_kr'=>'',
            'wrt_order1' => '',
            'wrt_order2' => '',
            'wrt_order3' => '',
            'wrt_order4' => '',
            'wrt_order5' => '',
            'ord_impli_flag' => '',
            //'ord_impli_date'=>'',
            'iscorrected_inco' => '',
            //'iscorrected_inco_date'=>'',
            'iscorrected_rkg_record' => '',
            //'iscorrected_rkg_date'=>'',
            'isdataposted_torkg_db' => '',
            'isorder_cancelled' => '',
            'ifyes_reason1' => '',
            'ifyes_reason2' => '',
            'ifyes_reason3' => '',
            'make_mdb' => $type_of_conversion, //full conversion or partial
            'new_dag_no' => $sugg_dag_no,
            'min_revenue' => $revenue
        );

        $conv_order_id = $this->db->query("select max(ord_onbehalf_id) as conv_id from    t_chitha_rmk_convorder where ord_no = '$case_no' limit 1")->result();
        $conv_order_id = $conv_order_id[0]->conv_id + 1;
        $i = 1;
        // var_dump($pattadar_details);
        foreach ($pattadar_details as $p) {
            $pdar_id = $p->pdar_id;
            $mother_name = $p->pdar_mother;
            $gender = $p->pdar_gender;
            $pdar_rel_guar = $p->pdar_rel_guar;


            $query = "select p.pdar_id,p.pdar_name,p.pdar_father,p.pdar_add1,p.pdar_add2,p.pdar_add3,p.pdar_guard_reln from    chitha_pattadar p join 
                   chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code 
                   and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and
                   p.pdar_id = d.pdar_id and trim(p.patta_no) = trim(d.patta_no) where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
                   p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
                   and d.lot_no='$lot_no' and d.dag_no='$dag' and trim(p.patta_no)='$patta_no' 
                   and p.patta_type_code='$patta_type' and p.pdar_id='$pdar_id'";

            $data = $this->db->query($query);
            if($data->num_rows()<=0){
                log_message('error','Error:#CONVDC00098:'.$this->db->last_query());
                $this->db->trans_rollback();
                redirect(base_url() . "index.php/home");
            }
            //var_dump($data);
            $values = array();
            foreach ($data->result() as $value) {
                $relation = $pdar_rel_guar;
                $pdar_add1 = $p->pdar_add1;
                $pdar_add2 = $p->pdar_add2;

                $chitha_rmk_convorder = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'dag_no' => $dag,
                    'year_no' => $year_no,
                    'petition_no' => $petition_no,
                    'ord_no' => $case_no,
                    'ord_date' => $order_date, //this date needs to be sorted out
                    'patta_type_code' => $patta_type,
                    'patta_no' => trim($patta_no),
                    'ord_onbehalf_id' => $i++, //auto increment id
                    'ord_onbehalf_of' => $value->pdar_name, //pattadar name
                    'premium' => $premium_amount,
                    'premi_chal_recpt' => $type_of_premium, //only 3 char
                    'premi_chal_recpt_no' => $premium_reciept,
                    'land_area_b' => $bigha,
                    'land_area_k' => $kotha,
                    'land_area_lc' => $lessa,
                    'land_area_g' => '0.0000',
                    'land_area_kr' => '0',
                    'new_patta_type' => $new_patta_type,
                    'new_patta_no' => trim($sugg_patta_no),
                    'new_dag_no' => $sugg_dag_no,
                    //'ord_impli_flag'=>'',
                    //'ord_impli_date'=>'',
                    //'iscorrected_inco' =>'',
                    //'iscorrected_inco_date'=>'',
                    //'iscorrected_rkg_record'=>'',
                    //'iscorrected_rkg_date' =>'',
                    'pdar_id' => $pdar_id, //pattadar id
                    'pdar_strike' => $p->pdar_strike,
                    'ord_onbehalf_guard' => $value->pdar_father, //gurdian name
                    'ord_onbehalf_add1' => $pdar_add1, //add1
                    'ord_onbehalf_add2' => $pdar_add2, //add2
                    'pdar_gender' => $gender,
                    'pdar_mother' => $mother_name,
                    'pdar_guard_reln' => $relation
                );
                //var_dump($chitha_rmk_convorder);

                $insert_rmk_conv = $this->db->insert('t_chitha_rmk_convorder', $chitha_rmk_convorder);
                if($insert_rmk_conv != 1){
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCONVDC0020: Insertion failed in t_chitha_rmk_convorder for case no :'. $case_no);
                    $json = [
                        'message'=>"#ERRCONVDC0020: Failed to in chitha rmk for Case No : ".$case_no
                    ];
                    echo json_encode($json);
                    return false;
                }
            }
        }
        //var_dump($chitha_rmk_ordbasic);


        $insert_rmk_ord= $this->db->insert('t_chitha_rmk_ordbasic', $chitha_rmk_ordbasic);
        if($insert_rmk_ord != 1){
            $this->db->trans_rollback();
            log_message('error', '#ERRCONVDC0021: Insertion failed in t_chitha_rmk_ordbasic for case no :'. $case_no);
            $json = [
                'message'=>"#ERRCONVDC0021: Failed to in chitha rmk ord for Case No : ".$case_no
            ];
            echo json_encode($json);
            return false;
        }

        $this->db->query("UPDATE Petition_Basic SET status = 'F' WHERE case_no = '$case_no'");

        if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            log_message('error', '#ERRCONVDC0022: Updation failed in petition_basic Case No ' . $case_no);
            $data = array(
                'error' => "#ERRCONVDC0022: Registration of Petition basic for case no : " . $case_no,
            );
            echo json_encode($data);
            return false;
        }

        // $last_proceeding_id = $this->db->query("select max(proceeding_id) as proceed from    petition_proceeding where case_no = '$case_no' limit 1")->result();
        // $last_proceeding_id = $last_proceeding_id[0]->proceed;
        // $this->db->query("UPDATE Petition_Proceeding SET status = 'Finish', user_code='$co_code' WHERE proceeding_id = '$last_proceeding_id' and case_no = '$case_no'");

        $proceeding = $this->db->query("select count(proceeding_id) as proceed from    petition_proceeding where case_no = '$case_no' limit 1")->result();
        $proceeding_id = $proceeding[0]->proceed + 1;
        $proceeding_data_end = array(
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => $order_date,
            'co_order' => $this->session->userdata('Co_notice'),
            'note_on_order' => '',
            'status' => 'Finish',
            'user_code' => $co_code,
            'date_entry' => $co_order_date,
            'operation' => 'E',
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code
        );

        $insert_pp6 = $this->db->insert("petition_proceeding", $proceeding_data_end);
        if($insert_pp6 != 1){
            $this->db->trans_rollback();
            log_message('error', '#ERRCONVDC0023: Insertion failed in petition_proceeding for case no :'. $case_no);
            $json = [
                'message'=>"#ERRCONVDC0023: Failed to in Proceeding for Case No : ".$case_no
            ];
            echo json_encode($json);
            return false;
        }

        if ($this->db->trans_status() == false) {
            $this->db->trans_rollback();
            $data = array(
                'error' => "Error in submitting. Please try Again",
            );
        }
        else
        {
            $this->db->trans_commit();



            $old_patta_type = $patta_type;
            $new_patta_type = $new_patta_type;
            $new_patta_no = $sugg_patta_no;
            $old_patta_no = $old_patta_no;
            $new_dag_no = $sugg_dag_no;
            $old_dag_no = $old_dag_no;
            $new_revenue = $revenue;
            $new_local_tax = $local_tax;
            $ulpinCheckFlag = $this->input->post('ulpinCheckFlag', true);
            $compareCheckFlag = $this->input->post('compareCheckFlag', true);
            if($ulpinCheckFlag ==1 && $compareCheckFlag == 'Y' && ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
            {

                $ulpin = $this->input->post('ulpin', true);
                $chain_revenue = $this->input->post('chain_revenue', true);
                $chain_local_tax = $this->input->post('chain_local_tax', true);
                $old_ulpin = $this->input->post('old_ulpin', true);
                if (!isset($old_ulpin))
                    $old_ulpin = "";

                redirect(base_url() . "index.php/dc_conversion_mb/select_full_or_partial?ulpin=" . $ulpin . "&chain_revenue=" . $chain_revenue . "&chain_local_tax=" . $chain_local_tax . "&old_ulpin=" . $old_ulpin . "&old_patta_type=" . $old_patta_type . "&new_patta_type=" . $new_patta_type . "&new_patta_no=" . $new_patta_no . "&old_patta_no=" . $old_patta_no . "&new_patta_no=" . $new_patta_no . "&old_dag_no=" . $old_dag_no . "&new_revenue=" . $new_revenue . "&new_local_tax=" . $new_local_tax . "&new_dag_no=" . $new_dag_no. "&ulpinCheckFlag=" . $ulpinCheckFlag . "&compareCheckFlag=" . $compareCheckFlag);
            }

            redirect(base_url() . "index.php/dc_conversion_mb/select_full_or_partial");
        }

    }

    public function FinalSaveTest() {
        //form validation
        $formValidation = $this->FormValidationModel->formValidationForPost($_POST, [
            'pdar_cron_no'=>'Pattadar Cron No.|digit',
            'prem_type'=>'Premium Type|required',
            // 'chalan_no'=>'Challan No|required_on_condition(prem_type,notEquals,[ৰাজহৰ বকেয়া])',
            'prem_amt'=>'Premium Amount|3_digit_decimal',
            'c_bigha'=>'C Bigha|required|digit',
            'c_kotha'=>'C Katha|required|katha',
            'c_lessa'=>'C Lessa|required|lessa',
            'patta_type'=>'Patta Type|required',
            'patta_no'=>'Patta No.|required|digit',
            'new_patta_type'=>'New Patta Type|required|digit',
            'sugg_dag_no'=>'Suggested Dag No.|required|digit',
            'old_dag_no'=>'Old Dag No.|required|digit',
            'sugg_patta_no'=>'Suggested Patta No.|required|digit',
            'old_patta_no'=>'Old Patta No.|required|digit',
            'dag_revenue'=>'Dag Revenue|required|2_digit_decimal',
            'dag_local_tax'=>'Dag Local Tax|required|2_digit_decimal',
            'land_portion_status'=>'Land Portion Status|required'
        ]);
        if($formValidation['status'] == 'n') {
            //ERRCONVCOUPDCHITHA30001
            log_message('error', 'Message: '. $formValidation['message'] .', Data: '. json_encode($formValidation['data']) .'. Error: ERRCONVCOUPDCHITHA30001');
            $this->session->set_flashdata('message', $formValidation['message'] .' Error: ERRCONVCOUPDCHITHA30001');
            redirect(base_url('index.php/dc_conversion_mb/TestFinalForm'));
        }

        //syntax validation
        $requestResponse = checkRequestSpecChar($_POST);
        if($requestResponse['status'] == 'n') {
            //ERRCONVCOUPDCHITHA30002
            log_message('error', $requestResponse['messages'] . '. Error: ERRCONVCOUPDCHITHA30002');
            $this->session->set_flashdata('message', 'Contains Illegal parameter values. Error: ERRCONVCOUPDCHITHA30002');
            redirect(base_url('index.php/dc_conversion_mb/TestFinalForm'));
        }

        //malicious query validation
        $validResponse = checkRequestValidQuery($_POST);
        if($validResponse['status'] == 'n') {
            //ERRCONVCOUPDCHITHA30003
            log_message('error', $validResponse['messages'] . '. Error: ERRCONVCOUPDCHITHA30003');
            $this->session->set_flashdata('message', 'Contains Malicious parameter values. Error: ERRCONVCOUPDCHITHA30003');
            redirect(base_url('index.php/dc_conversion_mb/TestFinalForm'));
        }

        //authorization
        $db=  $this->session->userdata('db');
        $case_no = $this->session->userdata('case_no');
        $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'CO', $case_no, CONV_CO_CHITHAUPD);
        if($authorization['status'] == 'n') {
            //ERRCONVCOUPDCHITHA30004
            log_message('error', $authorization['messages'] . '. Error: ERRCONVCOUPDCHITHA30004');
            $this->session->set_flashdata('message', $authorization['messages'].'. Error: ERRCONVCOUPDCHITHA30004');
            redirect(base_url('index.php/home'));
        }

        // echo '<pre>';
        // var_dump($_POST, $authorization);
        // die();

        $this->db->trans_begin();
        $data = array();
        $dist_code = $this->session->userdata('dist_codee');
        $subdiv_code = $this->session->userdata('subdiv_codee');
        $cir_code = $this->session->userdata('cir_codee');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_codee');
        $lot_no = $this->session->userdata('lot_noe');
        $vill_townprt_code = $this->session->userdata('vill_codee');


        $proceeding_id = $this->session->userdata('proceeding_id');

        $type_of_premium = $this->session->userdata('type_of_premium');
        $premium_reciept = $this->session->userdata('premium_reciept');
        $premium_amount = $this->session->userdata('premium_amount');
        $bigha = $this->session->userdata('bigha');
        $kotha = $this->session->userdata('kotha');
        $lessa = $this->session->userdata('lessa');
        $order_date = $this->session->userdata('order_date');

        $patta_no = trim($this->session->userdata('patta_no'));
        $dag = $this->session->userdata('dag_no');
        var_dump("ERRSESSION003: Please Contact Administartor"); die;
        $patta_type = $this->session->userdata('patta_type');

        $new_patta_type = $this->input->post('new_patta_type');
        $sugg_patta_no = trim($this->input->post('sugg_patta_no'));
        $old_patta_no = trim($this->input->post('old_patta_no'));
        $sugg_dag_no = $this->input->post('sugg_dag_no');
        $old_dag_no = $this->input->post('old_dag_no');
        $land_portion_status = $this->input->post('land_portion_status'); // N
        $revenue = $this->input->post('dag_revenue');
        $local_tax = $this->input->post('dag_local_tax');


        $lm_sign = $this->session->userdata('lm_sign');
        $order_type = $this->session->userdata('order_type');
        $lm_sign_date = $this->session->userdata('lm_sign_date');
        $order_passed_by = $this->session->userdata('order_passed_by');
        $sk_sign = $this->session->userdata('sk_sign');
        $sk_sign_date = $this->session->userdata('sk_sign_date');
        $co_order_date = $this->session->userdata('co_order_date');
        $co_sign = $this->session->userdata('co_sign');
        $co_code = $this->session->userdata('user_code');
        $lm_code = $this->session->userdata('lm_code');
        $sk_code = $this->session->userdata('sk_code');
        //$land_portion_status = $this->session->userdata('land_portion_status');


        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' "
            . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row();
        $petition_no = $petition_basic->petition_no;
        $type_of_conversion = $petition_basic->trans_code;
        //echo $type_of_conversion;

        $year_no = $petition_basic->year_no;
        $pattadar_details = $this->db->query("Select * from    petitioner_part where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
            . "and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' and patta_type_code= '$patta_type' and dag_no = '$dag' and TRIM(patta_no) = '$patta_no' and petition_no = '$petition_no'")->result();

        //$revenue = $this->db->query("Select * from    petition_dag_details where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
        //. "and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' and patta_type_code= '$patta_type' and dag_no = '$dag' and TRIM(patta_no) = '$patta_no'")->row();



        //==========check dag pending in blockchain or not=================
        if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {
            $this->load->model('propChain/PropChainCommonModel');
            $checkVal = $this->PropChainCommonModel->checkDagExistsInPropChainInPending($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$dag);
            if($checkVal === false)
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "#ERRORBLOCCHAIN1894 : You cannot procced as dag no is pending for property chain update...");
                redirect(base_url() . "index.php/home");
            }
        }
        ///=============end CODE=====================

        $chitha_rmk_ordbasic = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code,
            'dag_no' => $dag,
            'year_no' => $year_no,
            'petition_no' => $petition_no,
            'ord_no' => $case_no,
            'ord_date' => $order_date,
            'ord_type_code' => '01',
            'case_no' => $case_no,
            'ord_on_gl_type' => '',
            'ord_passby_sign_yn' => 'Y',
            'ord_passby_desig' => $order_passed_by,
            'ord_ref_let_no' => '',
            'lm_code' => $lm_code,
            'lm_sign_yn' => $lm_sign,
            'lm_sign_date' => $lm_sign_date,
            'sk_code' => $sk_code,
            'sk_sign_yn' => $sk_sign,
            'sk_sign_date' => $sk_sign_date,
            'co_code' => $co_code,
            'co_sign_yn' => $co_sign,
            'co_ord_date' => $co_order_date,
            'm_dag_area_b' => $bigha,
            'm_dag_area_k' => $kotha,
            'm_dag_area_lc' => $lessa, //
            'm_dag_area_g' => '0.0000',
            'm_dag_area_kr' => '0',
            //'area_left_b'=>'', 
            //'area_left_k'=>'',
            //'area_left_lc'=>'',
            //'area_left_g'=>'',
            //'area_left_kr'=>'',
            'wrt_order1' => '',
            'wrt_order2' => '',
            'wrt_order3' => '',
            'wrt_order4' => '',
            'wrt_order5' => '',
            'ord_impli_flag' => '',
            //'ord_impli_date'=>'',
            'iscorrected_inco' => '',
            //'iscorrected_inco_date'=>'',
            'iscorrected_rkg_record' => '',
            //'iscorrected_rkg_date'=>'',
            'isdataposted_torkg_db' => '',
            'isorder_cancelled' => '',
            'ifyes_reason1' => '',
            'ifyes_reason2' => '',
            'ifyes_reason3' => '',
            'make_mdb' => $type_of_conversion, //full conversion or partial
            'new_dag_no' => $sugg_dag_no,
            'min_revenue' => $revenue
        );

        $conv_order_id = $this->db->query("select max(ord_onbehalf_id) as conv_id from    t_chitha_rmk_convorder where ord_no = '$case_no' limit 1")->result();
        $conv_order_id = $conv_order_id[0]->conv_id + 1;
        $i = 1;
        // var_dump($pattadar_details);
        foreach ($pattadar_details as $p) {
            $pdar_id = $p->pdar_id;
            $mother_name = $p->pdar_mother;
            $gender = $p->pdar_gender;
            $pdar_rel_guar = $p->pdar_rel_guar;


            $query = "select p.pdar_id,p.pdar_name,p.pdar_father,p.pdar_add1,p.pdar_add2,p.pdar_add3,p.pdar_guard_reln from    chitha_pattadar p join 
                    chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code 
                    and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and
                    p.pdar_id = d.pdar_id and trim(p.patta_no) = trim(d.patta_no) where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
                    p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
                    and d.lot_no='$lot_no' and d.dag_no='$dag' and trim(p.patta_no)='$patta_no' 
                    and p.patta_type_code='$patta_type' and p.pdar_id='$pdar_id'";

            $data = $this->db->query($query);
            if($data->num_rows()<=0){
                log_message('error','Error:#CONVDC00098:'.$this->db->last_query());
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', 'Error in query. Error: #CONVDC00098');
                redirect(base_url() . "index.php/home");
            }
            //var_dump($data);
            $values = array();
            foreach ($data->result() as $value) {
                $relation = $pdar_rel_guar;
                $pdar_add1 = $p->pdar_add1;
                $pdar_add2 = $p->pdar_add2;

                $chitha_rmk_convorder = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'dag_no' => $dag,
                    'year_no' => $year_no,
                    'petition_no' => $petition_no,
                    'ord_no' => $case_no,
                    'ord_date' => $order_date, //this date needs to be sorted out
                    'patta_type_code' => $patta_type,
                    'patta_no' => trim($patta_no),
                    'ord_onbehalf_id' => $i++, //auto increment id
                    'ord_onbehalf_of' => $value->pdar_name, //pattadar name
                    'premium' => $premium_amount,
                    'premi_chal_recpt' => $type_of_premium, //only 3 char
                    'premi_chal_recpt_no' => $premium_reciept,
                    'land_area_b' => $bigha,
                    'land_area_k' => $kotha,
                    'land_area_lc' => $lessa,
                    'land_area_g' => '0.0000',
                    'land_area_kr' => '0',
                    'new_patta_type' => $new_patta_type,
                    'new_patta_no' => trim($sugg_patta_no),
                    'new_dag_no' => $sugg_dag_no,
                    //'ord_impli_flag'=>'',
                    //'ord_impli_date'=>'',
                    //'iscorrected_inco' =>'',
                    //'iscorrected_inco_date'=>'',
                    //'iscorrected_rkg_record'=>'',
                    //'iscorrected_rkg_date' =>'',
                    'pdar_id' => $pdar_id, //pattadar id
                    'pdar_strike' => $p->pdar_strike,
                    'ord_onbehalf_guard' => $value->pdar_father, //gurdian name
                    'ord_onbehalf_add1' => $pdar_add1, //add1
                    'ord_onbehalf_add2' => $pdar_add2, //add2
                    'pdar_gender' => $gender,
                    'pdar_mother' => $mother_name,
                    'pdar_guard_reln' => $relation
                );
                //var_dump($chitha_rmk_convorder);

                $insert_rmk_conv = $this->db->insert('t_chitha_rmk_convorder', $chitha_rmk_convorder);
                if($insert_rmk_conv != 1){
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCONVDC0020: Insertion failed in t_chitha_rmk_convorder for case no :'. $case_no);
                    $json = [
                        'message'=>"#ERRCONVDC0020: Failed to in chitha rmk for Case No : ".$case_no
                    ];
                    echo json_encode($json);
                    return false;
                }
            }
        }
        //var_dump($chitha_rmk_ordbasic);


        $insert_rmk_ord= $this->db->insert('t_chitha_rmk_ordbasic', $chitha_rmk_ordbasic);
        if($insert_rmk_ord != 1){
            $this->db->trans_rollback();
            log_message('error', '#ERRCONVDC0021: Insertion failed in t_chitha_rmk_ordbasic for case no :'. $case_no);
            $json = [
                'message'=>"#ERRCONVDC0021: Failed to in chitha rmk ord for Case No : ".$case_no
            ];
            echo json_encode($json);
            return false;
        }

        $this->db->query("UPDATE Petition_Basic SET status = 'F' WHERE case_no = '$case_no'");

        if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            log_message('error', '#ERRCONVDC0022: Updation failed in petition_basic Case No ' . $case_no);
            $data = array(
                'error' => "#ERRCONVDC0022: Registration of Petition basic for case no : " . $case_no,
            );
            echo json_encode($data);
            return false;
        }

        // $last_proceeding_id = $this->db->query("select max(proceeding_id) as proceed from    petition_proceeding where case_no = '$case_no' limit 1")->result();
        // $last_proceeding_id = $last_proceeding_id[0]->proceed;
        // $this->db->query("UPDATE Petition_Proceeding SET status = 'Finish', user_code='$co_code' WHERE proceeding_id = '$last_proceeding_id' and case_no = '$case_no'");

        $proceeding = $this->db->query("select count(proceeding_id) as proceed from    petition_proceeding where case_no = '$case_no' limit 1")->result();
        $proceeding_id = $proceeding[0]->proceed + 1;
        $proceeding_data_end = array(
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => $order_date,
            'co_order' => $this->session->userdata('Co_notice'),
            'note_on_order' => '',
            'status' => 'Finish',
            'user_code' => $co_code,
            'date_entry' => $co_order_date,
            'operation' => 'E',
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code
        );

        $insert_pp6 = $this->db->insert("petition_proceeding", $proceeding_data_end);
        if($insert_pp6 != 1){
            $this->db->trans_rollback();
            log_message('error', '#ERRCONVDC0023: Insertion failed in petition_proceeding for case no :'. $case_no);
            $json = [
                'message'=>"#ERRCONVDC0023: Failed to in Proceeding for Case No : ".$case_no
            ];
            echo json_encode($json);
            return false;
        }

        if ($this->db->trans_status() == false) {
            $this->db->trans_rollback();
            $data = array(
                'error' => "Error in submitting. Please try Again",
            );
        }
        else
        {
            $this->db->trans_commit();



            $old_patta_type = $patta_type;
            $new_patta_type = $new_patta_type;
            $new_patta_no = $sugg_patta_no;
            $old_patta_no = $old_patta_no;
            $new_dag_no = $sugg_dag_no;
            $old_dag_no = $old_dag_no;
            $new_revenue = $revenue;
            $new_local_tax = $local_tax;
            $ulpinCheckFlag = $this->input->post('ulpinCheckFlag', true);
            $compareCheckFlag = $this->input->post('compareCheckFlag', true);
            if($ulpinCheckFlag ==1 && $compareCheckFlag == 'Y' && ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
            {

                $ulpin = $this->input->post('ulpin', true);
                $chain_revenue = $this->input->post('chain_revenue', true);
                $chain_local_tax = $this->input->post('chain_local_tax', true);
                $old_ulpin = $this->input->post('old_ulpin', true);
                if (!isset($old_ulpin))
                    $old_ulpin = "";

                redirect(base_url() . "index.php/dc_conversion_mb/select_full_or_partial?ulpin=" . $ulpin . "&chain_revenue=" . $chain_revenue . "&chain_local_tax=" . $chain_local_tax . "&old_ulpin=" . $old_ulpin . "&old_patta_type=" . $old_patta_type . "&new_patta_type=" . $new_patta_type . "&new_patta_no=" . $new_patta_no . "&old_patta_no=" . $old_patta_no . "&new_patta_no=" . $new_patta_no . "&old_dag_no=" . $old_dag_no . "&new_revenue=" . $new_revenue . "&new_local_tax=" . $new_local_tax . "&new_dag_no=" . $new_dag_no. "&ulpinCheckFlag=" . $ulpinCheckFlag . "&compareCheckFlag=" . $compareCheckFlag);
            }

            redirect(base_url() . "index.php/dc_conversion_mb/select_full_or_partial");
        }

    }

    public function select_full_or_partial() {
        $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_codee');
        $subdiv_code = $this->session->userdata('subdiv_codee');
        $cir_code = $this->session->userdata('cir_codee');
        $case_no = $this->session->userdata('case_no');
        $query = "select * from    t_chitha_rmk_ordbasic where ord_no = '$case_no' "
            . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
        $result = $this->db->query($query)->row();

        $ulpinCheckFlag = $this->input->get('ulpinCheckFlag', true);
        $compareCheckFlag = $this->input->get('compareCheckFlag', true);
        if($ulpinCheckFlag ==1 && $compareCheckFlag == 'Y' && ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {
            $ulpinCheckFlag = $this->input->get('ulpinCheckFlag', true);
            $compareCheckFlag = $this->input->get('compareCheckFlag', true);
            $ulpin = $this->input->get('ulpin', true);
            $chain_revenue = $this->input->get('chain_revenue', true);
            $chain_local_tax = $this->input->get('chain_local_tax', true);
            $old_ulpin = $this->input->get('old_ulpin', true);
            if (!isset($old_ulpin))
                $old_ulpin = "";


            $old_patta_type = $this->input->get('old_patta_type', true);
            $new_patta_type = $this->input->get('new_patta_type', true);
            $new_patta_no = $this->input->get('new_patta_no', true);
            $old_patta_no = $this->input->get('old_patta_no', true);
            $new_patta_no = $this->input->get('new_patta_no', true);
            $old_dag_no = $this->input->get('old_dag_no', true);
            $new_revenue = $this->input->get('new_revenue', true);
            $new_local_tax = $this->input->get('new_local_tax', true);
            $new_dag_no = $this->input->get('new_dag_no', true);

            if ($result->make_mdb == 'F') {
                // echo "full";
                redirect(base_url() . "index.php/dc_conversion_mb/updateChithaConversionForFullConversion?ulpin=" . $ulpin . "&chain_revenue=" . $chain_revenue . "&chain_local_tax=" . $chain_local_tax . "&old_ulpin=" . $old_ulpin . "&old_patta_type=" . $old_patta_type . "&new_patta_type=" . $new_patta_type . "&new_patta_no=" . $new_patta_no . "&old_patta_no=" . $old_patta_no . "&new_patta_no=" . $new_patta_no . "&old_dag_no=" . $old_dag_no . "&new_revenue=" . $new_revenue . "&new_local_tax=" . $new_local_tax. "&ulpinCheckFlag=" . $ulpinCheckFlag . "&compareCheckFlag=" . $compareCheckFlag);
            } else {
                // echo "partial";
                redirect(base_url() . "index.php/dc_conversion_mb/updateChithaConversionForPartialConversion?ulpin=" . $ulpin . "&chain_revenue=" . $chain_revenue . "&chain_local_tax=" . $chain_local_tax . "&old_ulpin=" . $old_ulpin . "&old_patta_type=" . $old_patta_type . "&new_patta_type=" . $new_patta_type . "&new_patta_no=" . $new_patta_no . "&old_patta_no=" . $old_patta_no . "&new_patta_no=" . $new_patta_no . "&old_dag_no=" . $old_dag_no . "&new_revenue=" . $new_revenue . "&new_local_tax=" . $new_local_tax . "&new_dag_no=" . $new_dag_no. "&ulpinCheckFlag=" . $ulpinCheckFlag . "&compareCheckFlag=" . $compareCheckFlag);
            }
        }


        if ($result->make_mdb == 'F') {
            // echo "full";
            redirect(base_url() . "index.php/dc_conversion_mb/updateChithaConversionForFullConversion");
        } else {
            // echo "partial";
            redirect(base_url() . "index.php/dc_conversion_mb/updateChithaConversionForPartialConversion");
        }
    }

    public function updateChithaConversionForFullConversion() {
        $db=  $this->session->userdata('db');
        $this->db->trans_begin();
        $dist_code = $this->session->userdata('dist_codee');
        $subdiv_code = $this->session->userdata('subdiv_codee');
        $cir_code = $this->session->userdata('cir_codee');
        $case_no = $this->session->userdata('case_no');
        $this->AgriStackCaseHistory->CreateLogFile($dist_code, $case_no);
        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' "
            . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row();

        $query = "select * from    t_chitha_rmk_ordbasic where ord_no = '$case_no' and dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code'";
        $result = $this->db->query($query)->result();
        //var_dump($result);
        //echo "##########################################################";
        foreach ($result as $order) {
            $query_rmk_hist = "select max(rmk_type_hist_no) as c from    chitha_rmk_gen where "
                . "dist_code='$order->dist_code' and subdiv_code='$order->subdiv_code' and cir_code='$order->cir_code'"
                . " and lot_no='$order->lot_no' and mouza_pargona_code='$order->mouza_pargona_code' and "
                . " vill_townprt_code='$order->vill_townprt_code' and dag_no='$order->dag_no' ";

//            $query_rmk_hist = "select max(rmk_type_hist_no) as c from    chitha_rmk_convorder where "
//                    . "dist_code='$order->dist_code' and subdiv_code='$order->subdiv_code' and cir_code='$order->cir_code'"
//                    . " and lot_no='$order->lot_no' and mouza_pargona_code='$order->mouza_pargona_code' and "
//                    . " vill_townprt_code='$order->vill_townprt_code' and dag_no='$order->dag_no' ";
            $rmk_hist_no = $this->db->query($query_rmk_hist)->row()->c;
            if ($rmk_hist_no == null) {
                $rmk_hist_no = 1;
            } else
                $rmk_hist_no += 1;

            $q = "select max(ord_cron_no)+1 as c1,max(rmk_type_hist_no)+1 as c2 from    chitha_rmk_ordbasic where "
                . "dist_code='$order->dist_code' and subdiv_code='$order->subdiv_code' and cir_code='$order->cir_code'"
                . " and lot_no='$order->lot_no' and mouza_pargona_code='$order->mouza_pargona_code' and "
                . " vill_townprt_code='$order->vill_townprt_code' and dag_no='$order->dag_no' ";

            $ord_cron_no = $this->db->query($q)->row()->c1;
            if ($ord_cron_no == null) {
                $ord_cron_no = 1;
            } else {
                $ord_cron_no+=1;
            }

            $chitha_basic_update = FALSE;
            $query = "select * from    t_chitha_rmk_convorder where ord_no='$order->ord_no' and iscorrected_inco is null ";
            $pattdars = $this->db->query($query)->result();

            foreach ($pattdars as $p) {
                $c = $p;
                $ord = clone $p;
                unset($c->year_no);
                unset($c->petition_no);
                unset($c->ord_no);
                unset($c->petition_no);
                unset($c->ord_date);
                unset($c->ord_date);
                unset($c->iscorrected_inco);
                unset($c->iscorrected_inco_date);
                unset($c->iscorrected_rkg_record);
                unset($c->iscorrected_rkg_date);
                unset($c->pdar_id);
                unset($c->pdar_strike);
                unset($c->ord_onbehalf_guard);
                unset($c->ord_onbehalf_add1);
                unset($c->ord_onbehalf_add2);
                unset($c->make_mdb);
                unset($c->is_converted_pattadar);
                unset($c->is_converted_pattadar);
                $c->rmk_type_hist_no = $rmk_hist_no;
                $c->ord_cron_no = $rmk_hist_no;
                $c->user_code = $this->session->userdata('user_code');
                $c->date_entry = date('Y-m-d H:i:s');
                $c->operation = 'E';

                $tstatus1 = $this->db->insert('chitha_rmk_convorder', $c); //**************************
                if ($tstatus1 != 1 )
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#ERRCONVDC0024)");
                    log_message("error","#ERRCONVDC0024 Insert chitha_rmk_convorder for dist:"
                        .$dist_code.", case: ". $case_no);
                    redirect(base_url() . "index.php/home");
                }

                $d = date('Y-m-d');
                $update_conv_order_q = "update t_chitha_rmk_convorder set iscorrected_inco='Y',iscorrected_inco_date='$d' "
                    . " where ord_no='$order->ord_no'";
                $this->db->query($update_conv_order_q); //*********************

                if ($this->db->affected_rows() <=0)
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#ERRCONVDC0025)");
                    log_message("error","#ERRCONVDC0025 update t_chitha_rmk_convorder for dist:"
                        .$dist_code.", case: ". $case_no);
                    redirect(base_url() . "index.php/home");
                }

                $data = array(
                    'pdar_name' => $ord->ord_onbehalf_of,
                    'pdar_father' => $ord->ord_onbehalf_guard,
                    'patta_no' => trim($ord->new_patta_no),
                    'patta_type_code' => $ord->new_patta_type,
                    'pdar_add1' => $ord->ord_onbehalf_add1,
                    'pdar_add2' => $ord->ord_onbehalf_add2,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d H:i:s'),
                    'operation' => 'E',
                    'dist_code' => $ord->dist_code,
                    'subdiv_code' => $ord->subdiv_code,
                    'cir_code' => $ord->cir_code,
                    'mouza_pargona_code' => $ord->mouza_pargona_code,
                    'lot_no' => $ord->lot_no,
                    'vill_townprt_code' => $ord->vill_townprt_code,
                    'pdar_id' => $ord->pdar_id,
                    'new_pdar_name' => 'N',
                    'jama_yn' => ' ',
                    'pdar_gender' => $ord->pdar_gender,
                    'pdar_mother' => $ord->pdar_mother,
                    'pdar_guard_reln' => $ord->pdar_guard_reln
                );

                $chech_existance=$this->db->query("select count(*) as c from    chitha_pattadar where dist_code = '$ord->dist_code' and subdiv_code = '$ord->subdiv_code' and "
                    . "cir_code = '$ord->cir_code' and mouza_pargona_code = '$ord->mouza_pargona_code' "
                    . "and lot_no = '$ord->lot_no' and vill_townprt_code = '$ord->vill_townprt_code' and pdar_id = '$ord->pdar_id' "
                    . "and patta_no = trim('$ord->new_patta_no') and patta_type_code = '$ord->new_patta_type'")->row()->c;

                if($chech_existance == 0)
                {

                    // $tstatus2 = $this->db->insert('chitha_pattadar', $data); //*********************
                    $data['f1_case_no']=$case_no;
                    $tstatus2 = $this->Chitha_basic_model->insert_table('chitha_pattadar',$data);
                    if ($tstatus2 !=1)
                    {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#ERRCONVDC0026)");
                        log_message("error","#ERRCONVDC0026 insert chitha_pattadar for dist:"
                            .$dist_code.", case: ". $case_no);
                        redirect(base_url() . "index.php/home");
                    }
                }

                $landArea_query = "select dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr from    chitha_basic"
                    . "  where dist_code='$ord->dist_code' and"
                    . " subdiv_code='$ord->subdiv_code' and cir_code='$ord->cir_code'"
                    . " and lot_no='$ord->lot_no' and mouza_pargona_code='$ord->mouza_pargona_code' and "
                    . " vill_townprt_code='$ord->vill_townprt_code' and dag_no='$ord->dag_no'  "
                    . " and patta_no=trim('$ord->patta_no') and patta_type_code='$ord->patta_type_code'";

                if ($chitha_basic_update == FALSE) {
                    $landclass_query = "select land_class_code from    petition_lm_note  where dist_code='$ord->dist_code' and"
                        . " subdiv_code='$ord->subdiv_code' and cir_code='$ord->cir_code'"
                        . " and lot_no='$ord->lot_no' and mouza_pargona_code='$ord->mouza_pargona_code' and "
                        . " vill_townprt_code='$ord->vill_townprt_code' and dag_no='$ord->dag_no' "
                        . " and co_reject is null order by note_no desc limit 1";
                    //echo $landclass_query;
                    $landclasscode = $this->db->query($landclass_query)->row()->land_class_code;
                    $user_code = $this->session->userdata('user_code');
                    $date_entry = date('Y-m-d H:i:s');
                    $new_revenue = $order->min_revenue;
                    $dag_local_tax = round($new_revenue / 4, 2);

                    // $chitha_update = "update chitha_basic set patta_no=trim('$ord->new_patta_no'), old_patta_no=trim('$ord->patta_no'),"
                    //         . "dag_no='$ord->new_dag_no',patta_type_code='$ord->new_patta_type',"
                    //         . "user_code='$user_code', date_entry='$date_entry', operation='E',"
                    //         . "jama_yn=' ', land_class_code='$landclasscode', dag_revenue = '$new_revenue', dag_local_tax = '$dag_local_tax' where dist_code='$ord->dist_code' and"
                    //         . " subdiv_code='$ord->subdiv_code' and cir_code='$ord->cir_code'"
                    //         . " and lot_no='$ord->lot_no' and mouza_pargona_code='$ord->mouza_pargona_code' and "
                    //         . " vill_townprt_code='$ord->vill_townprt_code' and dag_no='$ord->dag_no'  "
                    //         . " and TRIM(patta_no)=trim('$ord->patta_no') and patta_type_code='$ord->patta_type_code'";

                    // $this->db->query($chitha_update);  //*********************

                    $table = 'chitha_basic';

                    $params = [
                        'patta_no'        => trim($ord->new_patta_no),
                        'old_patta_no'    => trim($ord->patta_no),
                        'dag_no'          => $ord->new_dag_no,
                        'patta_type_code' => $ord->new_patta_type,
                        'user_code'       => $user_code,
                        'date_entry'      => $date_entry,
                        'operation'       => 'E',
                        'jama_yn'         => ' ',
                        'land_class_code' => $landclasscode,
                        'dag_revenue'     => $new_revenue,
                        'dag_local_tax'   => $dag_local_tax,
                    ];

                    $where = [
                        'dist_code'          => $ord->dist_code,
                        'subdiv_code'        => $ord->subdiv_code,
                        'cir_code'           => $ord->cir_code,
                        'lot_no'             => $ord->lot_no,
                        'mouza_pargona_code' => $ord->mouza_pargona_code,
                        'vill_townprt_code'  => $ord->vill_townprt_code,
                        'dag_no'             => $ord->dag_no,
                        'patta_no'           => trim($ord->patta_no), // PHP trim simulates SQL TRIM()
                        'patta_type_code'    => $ord->patta_type_code,
                    ];

                    // Perform the update
                    $result = $this->Chitha_basic_model->update_table($table, $params, $where);


                    if ($result <=0)
                    {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#ERRCONVDC0027)");
                        log_message("error","#ERRCONVDC0027 update chitha_basic for dist:"
                            .$dist_code.", case: ". $case_no);
                        redirect(base_url() . "index.php/home");
                    }
                    $chitha_basic_update = TRUE;
                }

                // $update_query = "update chitha_dag_pattadar set p_flag='1',operation='M' where "
                //         . "dist_code='$ord->dist_code' and subdiv_code='$ord->subdiv_code' and cir_code='$ord->cir_code'"
                //         . " and lot_no='$ord->lot_no' and mouza_pargona_code='$ord->mouza_pargona_code' and "
                //         . " vill_townprt_code='$ord->vill_townprt_code' and dag_no='$ord->dag_no' "
                //         . " and pdar_id=$ord->pdar_id and patta_type_code='$ord->patta_type_code' and "
                //         . "TRIM(patta_no)=trim('$ord->patta_no')";

                // $this->db->query($update_query);  //*********************
                $table = 'chitha_dag_pattadar';

                $params = [
                    'p_flag'    => '1',
                    'operation' => 'M',
                ];

                $where = [
                    'dist_code'          => $ord->dist_code,
                    'subdiv_code'        => $ord->subdiv_code,
                    'cir_code'           => $ord->cir_code,
                    'lot_no'             => $ord->lot_no,
                    'mouza_pargona_code' => $ord->mouza_pargona_code,
                    'vill_townprt_code'  => $ord->vill_townprt_code,
                    'dag_no'             => $ord->dag_no,
                    'pdar_id'            => $ord->pdar_id, // assumed integer
                    'patta_type_code'    => $ord->patta_type_code,
                    'patta_no'           => trim($ord->patta_no), // trim applied here in PHP
                ];

                // Execute the update
                $result = $this->Chitha_basic_model->update_table($table, $params, $where);


                if ($result <=0)
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#ERRCONVDC0028)");
                    log_message("error","#ERRCONVDC0028 update chitha_dag_pattadar for dist:"
                        .$dist_code.", case: ". $case_no);
                    redirect(base_url() . "index.php/home");
                }

                $dag_pattadar = array(
                    'dist_code' => $ord->dist_code,
                    'subdiv_code' => $ord->subdiv_code,
                    'cir_code' => $ord->cir_code,
                    'mouza_pargona_code' => $ord->mouza_pargona_code,
                    'lot_no' => $ord->lot_no,
                    'vill_townprt_code' => $ord->vill_townprt_code,
                    'pdar_id' => $ord->pdar_id,
                    'patta_no' => trim($ord->new_patta_no),
                    'dag_no' => $ord->new_dag_no,
                    'patta_type_code' => $ord->new_patta_type,
                    'dag_por_b' => $ord->land_area_b,
                    'dag_por_k' => $ord->land_area_k,
                    'dag_por_lc' => $ord->land_area_lc,
                    'dag_por_g' => 0.0,
                    'dag_por_kr' => 0,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d H:i:s'),
                    'operation' => 'E',
                    'p_flag' => '0',
                );


                // $tstatus3 = $this->db->insert('chitha_dag_pattadar', $dag_pattadar);  //*********************
                $tstatus3 = $this->Chitha_basic_model->insert_table('chitha_dag_pattadar',$dag_pattadar);
                if ($tstatus3 !=1)
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#ERRCONVDC0029)");
                    log_message("error","#ERRCONVDC0029 insert chitha_dag_pattadar for dist:"
                        .$dist_code.", case: ". $case_no);
                    redirect(base_url() . "index.php/home");
                }

            }

            unset($order->year_no);
            unset($order->petition_no);
            unset($order->petition_no);
            unset($order->iscorrected_inco);
            unset($order->iscorrected_inco_date);
            unset($order->iscorrected_rkg_record);
            unset($order->iscorrected_rkg_date);
            unset($order->pdar_id);
            unset($order->pdar_strike);
            unset($order->ord_onbehalf_guard);
            unset($order->ord_onbehalf_add1);
            unset($order->ord_onbehalf_add2);
            unset($order->make_mdb);
            unset($order->is_converted_pattadar);
            unset($order->patta_type_code);
            //unset($order->patta_no);
            unset($order->ord_onbehalf_id);
            unset($order->ord_onbehalf_of);
            unset($order->premium);
            unset($order->premi_chal_recpt);
            unset($order->premi_chal_recpt_no);
            unset($order->land_area_b);
            unset($order->land_area_k);
            unset($order->land_area_lc);
            unset($order->min_revenue);
            unset($order->ifyes_reason3);
            unset($order->ifyes_reason2);
            unset($order->ifyes_reason1);
            unset($order->isorder_cancelled);
            unset($order->isdataposted_torkg_db);

            $order->ord_cron_no = $ord_cron_no;
            $order->rmk_type_hist_no = $rmk_hist_no;
            $order->user_code = $this->session->userdata('user_code');
            $order->operation = 'E';
            $order->date_entry = date('Y-m-d H:i:s');
            $order->area_left_b = 0;
            $order->area_left_k = 0;
            $order->area_left_lc = 0;
            $order->area_left_g = 0;
            $order->area_left_kr = 0;

            //var_dump($order);
            $get_patta_no = $this->db->query("select distinct(new_patta_no) as new_patta_no from    t_chitha_rmk_convorder where ord_no='$order->ord_no'")->row()->new_patta_no;

            $rmk_gen = array(
                'dist_code' => $order->dist_code,
                'subdiv_code' => $order->subdiv_code,
                'cir_code' => $order->cir_code,
                'mouza_pargona_code' => $order->mouza_pargona_code,
                'vill_townprt_code' => $order->vill_townprt_code,
                'lot_no' => $order->lot_no,
                'dag_no' => $order->dag_no,
                'rmk_type_code' => '01',
                'rmk_type_hist_no' => $rmk_hist_no,
                'user_code' => $this->session->userdata('user_code'),
                'operation' => 'E',
                'date_entry' => date('Y-m-d H:i:s'),
                'jama_updated' => ' ',
                'new_dag_no' => $order->new_dag_no,
                'patta_no'=>trim($get_patta_no)
            );


            $tstatus4 = $this->db->insert('chitha_rmk_gen', $rmk_gen); //*********************
            if ($tstatus4 !=1)
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#ERRCONVDC0030)");
                log_message("error","#ERRCONVDC0030 insert chitha_rmk_gen for dist:"
                    .$dist_code.", case: ". $case_no);
                redirect(base_url() . "index.php/home");
            }



            $tstatus5 = $this->db->insert('chitha_rmk_ordbasic', $order); //*********************
            if ($tstatus5 !=1)
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#ERRCONVDC0031)");
                log_message("error","#ERRCONVDC0031 insert chitha_rmk_ordbasic for dist:"
                    .$dist_code.", case: ". $case_no);
                redirect(base_url() . "index.php/home");
            }

            $d = date('Y-m-d');
            $update_q = "update t_chitha_rmk_ordbasic set iscorrected_inco='Y',iscorrected_inco_date='$d'"
                . " where ord_no='$order->ord_no' and dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code'";
            $this->db->query($update_q); //*********************

            if ($this->db->affected_rows() <=0)
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#ERRCONVDC0032)");
                log_message("error","#ERRCONVDC0032 update t_chitha_rmk_ordbasic for dist:"
                    .$dist_code.", case: ". $case_no);
                redirect(base_url() . "index.php/home");
            }

            if ($this->db->trans_status() == false) {
                $this->db->trans_rollback();
                $data = array(
                    'error' => "Error in submitting. Please try Again",
                );
            }
            else
            {

                $penUser='NA';
                $rmrk='Chitha Updated';
                $this->DashboardData($case_no,$penUser,$rmrk);
                $status='F';
                $task='CO';
                $pen='NA';

                $rtps_status = $this->basundharamodel->postApiBasundharaSec($case_no,$rmrk,$status,$task,$pen);
                //var_dump($rtps_status);
                if (trim($rtps_status) !="y") {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error #ERRDCAPI005: Application not processed case no # $case_no");
                    redirect(base_url() . "index.php/home");
                } else {

                    // $this->load->view('../views/header');
                    // $this->load->view('../views/dc_adc_office_conversion/test');
                    // $this->load->view('../views/footer');

                    ///////////////////////////////////////////////////////////////////////////
                    //////////////////////Property chain code /////////////////////////////////
                    ///////////////////////////////////////////////////////////////////////////
                    $ulpinCheckFlag = $this->input->get('ulpinCheckFlag', true);
                    $compareCheckFlag = $this->input->get('compareCheckFlag', true);
                    $jama_patta_no = trim($ord->new_patta_no);
                    $jama_patta_type_code = $ord->new_patta_type;
                    $update_chain_api =  new \stdClass;
                    $update_chain_api->success = 1;
                    if($ulpinCheckFlag ==1 && $compareCheckFlag == 'Y' && ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                    {
                        $type = LOC_TYPE_RURAL;
                        $conversion_type = CONVERSION_FULL;
                        $certmnemonic = CERTMNEMONIC_CONV;

                        $dist_code = $petition_basic->dist_code;
                        $subdiv_code = $petition_basic->subdiv_code;
                        $cir_code = $petition_basic->cir_code;
                        $lot_no = $petition_basic->lot_no;
                        $vill_townprt_code = $petition_basic->vill_townprt_code;
                        $mouza_pargona_code = $petition_basic->mouza_pargona_code;

                        $property_signature = "base64 encoded signature";
                        $property_signer_key = "base64 encoded public key";
                        $office_code = $this->session->userdata('cir_code');
                        $user_code = $this->session->userdata('user_code');
                        $ulpin = $this->input->get('ulpin', true);
                        $chain_revenue = $this->input->get('chain_revenue', true);
                        $chain_local_tax = $this->input->get('chain_local_tax', true);
                        $old_ulpin = $this->input->get('old_ulpin', true);
                        if (!isset($old_ulpin))
                            $old_ulpin = "";
                        $reference_id = $case_no;

                        $old_patta_type = $this->input->get('old_patta_type', true);
                        $new_patta_type = $this->input->get('new_patta_type', true);
                        $new_patta_no = $this->input->get('new_patta_no', true);
                        $old_patta_no = $this->input->get('old_patta_no', true);

                        $old_dag_no = $this->input->get('old_dag_no', true);
                        $ne_revenue = $this->input->get('new_revenue', true);
                        $new_local_tax = $this->input->get('new_local_tax', true);

                        // since full conversion dag number will remain same
                        $property_id_update = $this->blockchainutilityclass->generatePropertyId($type, $vill_townprt_code, $old_patta_no, $old_dag_no, $ulpin);

                        // 
                        // $pattadar_details = $this->PropChainModel->getPattadars($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $old_patta_no, $old_dag_no);

                        $pattadar_details = $this->PropChainModel->getPattadars($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $new_patta_no, $old_dag_no);

                        // $land_area = $this->PropChainModel->getLandArea($dist_code, $subdiv_code,  $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $old_patta_no, $old_dag_no);

                        $land_area = $this->PropChainModel->getLandArea2($case_no);

                        $bigha_chain = $land_area->dag_area_b;
                        $katha_chain = $land_area->dag_area_k;
                        $lessa_chain = $land_area->dag_area_lc;
                        $ganda_chain = $land_area->dag_area_g;
                        // delete this code when property id is changed (start)
                        $remaining_b = "0";
                        $remaining_k = "0";
                        $remaining_lc = "0";
                        $remaining_g = "0";
                        // (end)

                        // $landclasscode = $this->PropChainModel->getLandClassCode($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $old_patta_no, $old_dag_no);

                        ////////////////////////////////////////////////////////////////////////first update old property ///////////////////////////////////////////////////////////////
                        $old_land_class_code = '';
                        $chain_data_params = array(
                            'pattadar_details' => $pattadar_details,
                            'dist_code' => $dist_code,
                            'subdiv_code' => $subdiv_code,
                            'cir_code' => $cir_code,
                            'mouza_pargona_code' => $mouza_pargona_code,
                            'lot_no' => $lot_no,
                            'vill_townprt_code' => $vill_townprt_code,
                            'reference_id' => $reference_id,
                            'old_dag' => $old_dag_no,
                            'old_patta' => $old_patta_no,
                            'patta_type_code' => $old_patta_type,
                            'land_class_code' => $landclasscode,
                            'remaining_b' => $bigha_chain,
                            'remaining_k' => $katha_chain,
                            'remaining_lc' => $lessa_chain,
                            'remaining_g' => $ganda_chain,
                            'certmnemonic' => $certmnemonic,
                            'property_signature' => $property_signature,
                            'property_signer_key' => $property_signer_key,
                            'office_code' => $office_code,
                            'user_code' => $user_code,
                            'ulpin' => $ulpin,
                            'old_ulpin' => $old_ulpin,
                            'dag_revenue' => $ne_revenue,
                            'dag_local_tax' => $new_local_tax,
                            'new_patta_no' => $new_patta_no,
                            'old_dag_revenue' => $chain_revenue,
                            'old_dag_local_tax' => $chain_local_tax,
                            'old_land_class_code' => $old_land_class_code,
                            'new_patta_type_code' => $new_patta_type
                        );
                        $chain_trans = $this->PropChainModel->chainFullDagProcess((object)$chain_data_params);

                        $update_chain_api = $chain_trans;
                    }
                    if($update_chain_api->success == 1) {

                        $this->db->trans_commit();
                        $this->AgriStackCaseHistory->CreateLog($dist_code,$case_no);

                        if($ulpinCheckFlag ==1 && $compareCheckFlag == 'Y' && ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                        {
                            $location = array(
                                'd' => $order->dist_code,
                                's' => $order->subdiv_code,
                                'c' => $order->cir_code,
                                'm' => $order->mouza_pargona_code,
                                'l' => $order->lot_no,
                                'v' => $order->vill_townprt_code,
                            );
                            $this->session->set_userdata(array('loc' => $location));
                            $popUpmsg = "<h4>Order for Case No $case_no Successfully Saved.Chitha has been Updated !!! Updating JamaBandi Now<h4>";
                            $msgggg = "<script type='text/javascript'>alert(' " . $popUpmsg . " ');</script>";

                            redirect('JamaBandi/step3/' . $jama_patta_no . '/' . $jama_patta_type_code . '/' .  urlencode(base64_encode($case_no)));
                        }
                        $data['_view'] = 'dc_adc_office_conversion/test';
                        $this->load->view('layouts/main',$data);




                    } elseif ($update_chain_api->success == 0) {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', $update_chain_api->message . ": " . $update_chain_api->error_msg . ". Property Chain updation for Case No $case_no Not Successfull. Error Code(" . $update_chain_api->error_code . ")");
                        redirect(base_url() . "index.php/home");
                    } else {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error occured. Property Chain updation and creation for Case No $case_no Not Successfull.");
                    }





                }


            }
        }
    }

    public function updateChithaConversionForPartialConversion() {
        $db=  $this->session->userdata('db');
        $this->db->trans_begin();
        $dist_code = $this->session->userdata('dist_codee');
        $subdiv_code = $this->session->userdata('subdiv_codee');
        $cir_code = $this->session->userdata('cir_codee');
        $case_no = $this->session->userdata('case_no');
        $this->AgriStackCaseHistory->CreateLogFile($dist_code, $case_no);
        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' "
            . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row();


        $query = "select * from    t_chitha_rmk_ordbasic where ord_no = '$case_no' and dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code'";
        $result = $this->db->query($query)->result();
        //var_dump($result);
        //echo "##########################################################";
        foreach ($result as $order) {

            $query_rmk_hist = "select max(rmk_type_hist_no) as c from    chitha_rmk_gen where "
                . "dist_code='$order->dist_code' and subdiv_code='$order->subdiv_code' and cir_code='$order->cir_code'"
                . " and lot_no='$order->lot_no' and mouza_pargona_code='$order->mouza_pargona_code' and "
                . " vill_townprt_code='$order->vill_townprt_code' and dag_no='$order->dag_no' ";

//            $query_rmk_hist = "select max(rmk_type_hist_no) as c from    chitha_rmk_convorder where "
//                    . "dist_code='$order->dist_code' and subdiv_code='$order->subdiv_code' and cir_code='$order->cir_code'"
//                    . " and lot_no='$order->lot_no' and mouza_pargona_code='$order->mouza_pargona_code' and "
//                    . " vill_townprt_code='$order->vill_townprt_code' and dag_no='$order->dag_no' ";
            $rmk_hist_no = $this->db->query($query_rmk_hist)->row()->c;
            if ($rmk_hist_no == null) {
                $rmk_hist_no = 1;
            } else
                $rmk_hist_no += 1;

            $q = "select max(ord_cron_no)+1 as c1,max(rmk_type_hist_no)+1 as c2 from    chitha_rmk_ordbasic where "
                . "dist_code='$order->dist_code' and subdiv_code='$order->subdiv_code' and cir_code='$order->cir_code'"
                . " and lot_no='$order->lot_no' and mouza_pargona_code='$order->mouza_pargona_code' and "
                . " vill_townprt_code='$order->vill_townprt_code' and dag_no='$order->dag_no' ";

            $ord_cron_no = $this->db->query($q)->row()->c1;
            if ($ord_cron_no == null) {
                $ord_cron_no = 1;
            } else {
                $ord_cron_no+=1;
            }
            $chitha_basic_update = FALSE;
            $query = "select * from    t_chitha_rmk_convorder where ord_no='$order->ord_no' and iscorrected_inco is null ";
            //echo $query;
            $pattdars = $this->db->query($query)->result();
            foreach ($pattdars as $p) {
                $c = $p;
                $ord = clone $p;
                unset($c->year_no);
                unset($c->petition_no);
                unset($c->ord_no);
                unset($c->petition_no);
                unset($c->ord_date);
                unset($c->iscorrected_inco);
                unset($c->iscorrected_inco_date);
                unset($c->iscorrected_rkg_record);
                unset($c->iscorrected_rkg_date);
                unset($c->pdar_id);
                unset($c->pdar_strike);
                unset($c->ord_onbehalf_guard);
                unset($c->ord_onbehalf_add1);
                unset($c->ord_onbehalf_add2);
                unset($c->make_mdb);
                unset($c->is_converted_pattadar);
                unset($c->is_converted_pattadar);
                $c->rmk_type_hist_no = $rmk_hist_no;
                $c->ord_cron_no = $rmk_hist_no;
                $c->user_code = $this->session->userdata('user_code');
                $c->date_entry = date('Y-m-d H:i:s');
                $c->operation = 'E';


                $tstatus11 =$this->db->insert('chitha_rmk_convorder', $c); //**************************
                if ($tstatus11 != 1 )
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#ERRCONVDC0033)");
                    log_message("error","#ERRCONVDC0033 Insert chitha_rmk_convorder for dist:"
                        .$dist_code.", case: ". $case_no);
                    redirect(base_url() . "index.php/home");
                }

                $d = date('Y-m-d');
                $update_conv_order_q = "update t_chitha_rmk_convorder set iscorrected_inco='Y',iscorrected_inco_date='$d' "
                    . " where ord_no='$order->ord_no'";
                $this->db->query($update_conv_order_q); //*********************

                if ($this->db->affected_rows() <=0)
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#ERRCONVDC0034)");
                    log_message("error","#ERRCONVDC0034 update t_chitha_rmk_convorder for dist:"
                        .$dist_code.", case: ". $case_no);
                    redirect(base_url() . "index.php/home");
                }

                $data = array(
                    'pdar_name' => $ord->ord_onbehalf_of,
                    'pdar_father' => $ord->ord_onbehalf_guard,
                    'patta_no' => trim($ord->new_patta_no),
                    'patta_type_code' => $ord->new_patta_type,
                    'pdar_add1' => $ord->ord_onbehalf_add1,
                    'pdar_add2' => $ord->ord_onbehalf_add2,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d H:i:s'),
                    'operation' => 'E',
                    'dist_code' => $ord->dist_code,
                    'subdiv_code' => $ord->subdiv_code,
                    'cir_code' => $ord->cir_code,
                    'mouza_pargona_code' => $ord->mouza_pargona_code,
                    'lot_no' => $ord->lot_no,
                    'vill_townprt_code' => $ord->vill_townprt_code,
                    'pdar_id' => $ord->pdar_id,
                    'new_pdar_name' => 'N',
                    'jama_yn' => '',
                    'pdar_gender' => $ord->pdar_gender,
                    'pdar_mother' => $ord->pdar_mother,
                    'pdar_guard_reln' => $ord->pdar_guard_reln
                );
                //var_dump($data);
                $chech_existance=$this->db->query("select count(*) as c from    chitha_pattadar where dist_code = '$ord->dist_code' and subdiv_code = '$ord->subdiv_code' and "
                    . "cir_code = '$ord->cir_code' and mouza_pargona_code = '$ord->mouza_pargona_code' "
                    . "and lot_no = '$ord->lot_no' and vill_townprt_code = '$ord->vill_townprt_code' and pdar_id = '$ord->pdar_id' "
                    . "and TRIM(patta_no) = trim('$ord->new_patta_no') and patta_type_code = '$ord->new_patta_type'")->row()->c;

                if($chech_existance == 0)
                {

                    // $tstatus21 = $this->db->insert('chitha_pattadar', $data); //*********************
                    $data['f1_case_no']=$case_no;
                    $tstatus21 = $this->Chitha_basic_model->insert_table('chitha_pattadar',$data);
                    if ($tstatus21 !=1)
                    {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#ERRCONVDC0035)");
                        log_message("error","#ERRCONVDC0035 insert chitha_pattadar for dist:"
                            .$dist_code.", case: ". $case_no. "######".$this->db->last_query());
                        redirect(base_url() . "index.php/home");
                    }
                }

                $landArea_query = "select dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,dag_revenue from    chitha_basic"
                    . "  where dist_code='$ord->dist_code' and"
                    . " subdiv_code='$ord->subdiv_code' and cir_code='$ord->cir_code'"
                    . " and lot_no='$ord->lot_no' and mouza_pargona_code='$ord->mouza_pargona_code' and "
                    . " vill_townprt_code='$ord->vill_townprt_code' and dag_no='$ord->dag_no'  "
                    . " and TRIM(patta_no)=trim('$ord->patta_no') and patta_type_code='$ord->patta_type_code'";
                //echo $landArea_query;
                $b = '0';
                $k = '0';
                $lc = '0.00';
                $g = '0.0';
                $kr = '0.0';
                //old land portion
                $old_b = $this->db->query($landArea_query)->row()->dag_area_b;
                $old_k = $this->db->query($landArea_query)->row()->dag_area_k;
                $old_lc = $this->db->query($landArea_query)->row()->dag_area_lc;
                $old_dag_revenue = $this->db->query($landArea_query)->row()->dag_revenue;
                $old_g = 0.0;
                $old_kr = 0.0;
                $converted_to_lessa_old = ($old_b) * 100 + ($old_k) * 20 + ($old_lc);
                //to be converted land portion
                $converted_b = $ord->land_area_b;
                $converted_k = $ord->land_area_k;
                $converted_lc = $ord->land_area_lc;
                $converted_g = 0.0;
                $converted_kr = 0.0;
                $converted_to_lessa_new = ($converted_b) * 100 + ($converted_k) * 20 + ($converted_lc);
                //left land portion
                $remaining_lessa = $converted_to_lessa_old - $converted_to_lessa_new;
                $b = round(floor($remaining_lessa / 100));
                $remainder = $remaining_lessa % 100;
                $k = round(floor($remainder / 20));
                //$lc = round(floor($remainder % 20));
                $lc = fmod($remaining_lessa, 20);
                $g = 0.0;
                $kr = 0.0;
                //revenue
                $new_revenue = $order->min_revenue;
                $dag_local_tax = round($new_revenue / 4, 2);

                //$cal_new_rev =round($old_dag_revenue, 2);
                //$new_dag_local_tax =round($cal_new_rev/4, 2);
                //$cal_new_rev =round(($old_dag_revenue/$converted_to_lessa_old)*$remaining_lessa, 2);
                //$new_dag_local_tax =round($cal_new_rev/4, 2);

                if ($chitha_basic_update == FALSE) {
                    // $chitha_update = "update chitha_basic set dag_status='NR', dag_area_b='$b',dag_area_k='$k',"
                    //         . " dag_area_lc='$lc',dag_area_g='$g',dag_area_kr='$kr',jama_yn='', dag_revenue = '0.0', dag_local_tax = '0.00'  where dist_code='$ord->dist_code' and"
                    //         . " subdiv_code='$ord->subdiv_code' and cir_code='$ord->cir_code'"
                    //         . " and lot_no='$ord->lot_no' and mouza_pargona_code='$ord->mouza_pargona_code' and "
                    //         . " vill_townprt_code='$ord->vill_townprt_code' and dag_no='$ord->dag_no'  "
                    //         . " and TRIM(patta_no)=trim('$ord->patta_no') and patta_type_code='$ord->patta_type_code'";

                    // //var_dump($chitha_update);
                    // $this->db->query($chitha_update);  //*********************

                    $table = 'chitha_basic';

                    $params = [
                        'dag_status'     => 'NR',
                        'dag_area_b'     => $b,
                        'dag_area_k'     => $k,
                        'dag_area_lc'    => $lc,
                        'dag_area_g'     => $g,
                        'dag_area_kr'    => $kr,
                        'jama_yn'        => '',
                        'dag_revenue'    => '0.0',
                        'dag_local_tax'  => '0.00',
                    ];

                    $where = [
                        'dist_code'          => $ord->dist_code,
                        'subdiv_code'        => $ord->subdiv_code,
                        'cir_code'           => $ord->cir_code,
                        'lot_no'             => $ord->lot_no,
                        'mouza_pargona_code' => $ord->mouza_pargona_code,
                        'vill_townprt_code'  => $ord->vill_townprt_code,
                        'dag_no'             => $ord->dag_no,
                        'patta_no'           => trim($ord->patta_no), // PHP trim equivalent of SQL TRIM()
                        'patta_type_code'    => $ord->patta_type_code,
                    ];

                    // Execute the update using model
                    $result = $this->Chitha_basic_model->update_table($table, $params, $where);


                    if ($result <=0)
                    {
                        log_message("error","#ERRCONVDC0036 update chitha_basic for dist:"
                            .$dist_code.", case: ". $case_no. "######".$this->db->last_query());
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error in chitha update. Please try Again. Error Code(#ERRCONVDC0036)");

                        redirect(base_url() . "index.php/home");
                    }

                    //LM NR Note
                    $lm_nr_note = $this->db->query("Select lm_sign_date,lm_code,date_entry,partial_untrans_b,partial_untrans_k,partial_untrans_lc from  petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
                        . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and "
                        . "mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and co_reject is NULL order by note_no desc limit 1")->row();

                    $query_lm_note = "select max(lm_note_cron_no) as lm from chitha_rmk_lmnote where "
                        . "dist_code='$ord->dist_code' and subdiv_code='$ord->subdiv_code' and cir_code='$ord->cir_code'"
                        . " and lot_no='$ord->lot_no' and mouza_pargona_code='$ord->mouza_pargona_code' and "
                        . " vill_townprt_code='$ord->vill_townprt_code' and dag_no='$ord->dag_no' ";

                    $lm_note_cron_no = $this->db->query($query_lm_note)->row()->lm;
                    if ($lm_note_cron_no == null) {
                        $lm_note_cron_no = 1;
                    } else
                        $lm_note_cron_no += 1;

                    $lmNOte=$lm_nr_note->partial_untrans_b."b ".$lm_nr_note->partial_untrans_k."k ".$lm_nr_note->partial_untrans_lc."lc shall be made Sarkari under NR proceedings.";

                    $status2=$this->db->query("INSERT INTO chitha_rmk_lmnote(dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code, dag_no, lm_note_cron_no, rmk_type_hist_no,lm_note_lno, lm_note, lm_note_date,lm_sign,co_approval, user_code, date_entry, operation) VALUES ('$ord->dist_code','$ord->subdiv_code','$ord->cir_code','$ord->mouza_pargona_code','$ord->lot_no', '$ord->vill_townprt_code','$ord->dag_no','$lm_note_cron_no','1','1','$lmNOte','$lm_nr_note->lm_sign_date','Y','Y', '$lm_nr_note->lm_code','$lm_nr_note->date_entry','N')");
                    if($status2!=1){
                        log_message("error","#ERRCONVDC0037 insert chitha_rmk_lmnote for dist:"
                            .$dist_code.", case: ". $case_no. "######".$this->db->last_query());
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "could not Process. Error Code(#ERRCONVDC0037)");
                        redirect(base_url() . "index.php/home");
                    }
                    //LM NR Note end

                    $landclass_query = "select land_class_code from    petition_lm_note  where dist_code='$ord->dist_code' and"
                        . " subdiv_code='$ord->subdiv_code' and cir_code='$ord->cir_code'"
                        . " and lot_no='$ord->lot_no' and mouza_pargona_code='$ord->mouza_pargona_code' and "
                        . " vill_townprt_code='$ord->vill_townprt_code' and dag_no='$ord->dag_no' "
                        . " and co_reject is null order by note_no desc limit 1";
                    //echo $landclass_query;
                    $landclasscode = $this->db->query($landclass_query)->row()->land_class_code;
                    $dag_no_int = $ord->new_dag_no . "00";

                    //////////////PROPERTY CHAIN CODE//////////////////////
                    $ulpin = null;
                    $map_for_property = null;
                    $ulpinCheckFlag = $this->input->get('ulpinCheckFlag', true);
                    $compareCheckFlag = $this->input->get('compareCheckFlag', true);

                    ///////////////END/////////////////////////////////////



                    $chitha_basic = array(
                        'dist_code' => $ord->dist_code,
                        'subdiv_code' => $ord->subdiv_code,
                        'cir_code' => $ord->cir_code,
                        'mouza_pargona_code' => $ord->mouza_pargona_code,
                        'lot_no' => $ord->lot_no,
                        'vill_townprt_code' => $ord->vill_townprt_code,
                        'patta_no' => trim($ord->new_patta_no),
                        'old_patta_no' => trim($ord->patta_no),
                        'old_dag_no' => $ord->dag_no,
                        'dag_no' => $ord->new_dag_no,
                        'dag_no_int' => $dag_no_int,
                        'patta_type_code' => $ord->new_patta_type,
                        'dag_area_b' => $ord->land_area_b,
                        'dag_area_k' => $ord->land_area_k,
                        'dag_area_lc' => $ord->land_area_lc,
                        'dag_area_g' => 0.0,
                        'dag_area_kr' => 0,
                        'dag_revenue' => $new_revenue,
                        'dag_local_tax' => $dag_local_tax,
                        'user_code' => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d H:i:s'),
                        'operation' => 'E',
                        'jama_yn' => ' ',
                        'land_class_code' => $landclasscode,

                    );
                    //var_dump($chitha_basic);

                    if($ulpinCheckFlag == 1 && $compareCheckFlag=='Y' && ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                    {
                        $ulpin = $this->input->get('ulpin', true);
                        $map_for_property = 'N';
                        //=============PROPERTY CHAIN==========//
                        $chitha_basic['old_ulpin'] = $ulpin;
                        // set map_for_property = N as new map is not created
                        $chitha_basic['map_for_property'] = $map_for_property;

                    }


                    // $insert_cb = $this->db->insert('chitha_basic', $chitha_basic);  //*********************
                    $insert_cb = $this->Chitha_basic_model->insert_table('chitha_basic',$chitha_basic);
                    if($insert_cb != 1){

                        log_message('error', '#ERRCONVDC0038: Insertion failed in petition_proceeding for case no :'. $case_no. "######".$this->db->last_query());
                        $this->db->trans_rollback();
                        $json = [
                            'message'=>"#ERRCONVDC0038: Failed to in Proceeding for Case No : ".$case_no
                        ];
                        echo json_encode($json);
                        return false;
                    }
                    $chitha_basic_update = TRUE;
                }
                if ($ord->pdar_strike == 'Y') {
                    $p_flag = '1';
                } else {
                    $p_flag = '0';
                }
                $p_flag = '1';
                // $update_query = "update chitha_dag_pattadar set p_flag='$p_flag',operation='M' where "
                //         . "dist_code='$ord->dist_code' and subdiv_code='$ord->subdiv_code' and cir_code='$ord->cir_code'"
                //         . " and lot_no='$ord->lot_no' and mouza_pargona_code='$ord->mouza_pargona_code' and "
                //         . " vill_townprt_code='$ord->vill_townprt_code' and dag_no='$ord->dag_no' "
                //         . " and pdar_id='$ord->pdar_id' and patta_type_code='$ord->patta_type_code'";
                // //echo $update_query;
                // $this->db->query($update_query);  //*********************

                $table = 'chitha_dag_pattadar';

                $params = [
                    'p_flag'    => $p_flag,
                    'operation' => 'M',
                ];

                $where = [
                    'dist_code'          => $ord->dist_code,
                    'subdiv_code'        => $ord->subdiv_code,
                    'cir_code'           => $ord->cir_code,
                    'lot_no'             => $ord->lot_no,
                    'mouza_pargona_code' => $ord->mouza_pargona_code,
                    'vill_townprt_code'  => $ord->vill_townprt_code,
                    'dag_no'             => $ord->dag_no,
                    'pdar_id'            => $ord->pdar_id, // no quotes if it's an integer
                    'patta_type_code'    => $ord->patta_type_code,
                ];

                // Then execute the update
                $result = $this->Chitha_basic_model->update_table($table, $params, $where);


                if ($result == 0) {

                    log_message('error', '#ERRCONVDC0039: Updation failed in chitha_dag_pattadar Case No ' . $case_no. "######".$this->db->last_query());
                    $this->db->trans_rollback();
                    $data = array(
                        'error' => "#ERRCONVDC0039: Update chitha dag for case no : " . $case_no,
                    );
                    echo json_encode($data);
                    return false;
                }

                $dag_pattadar = array(
                    'dist_code' => $ord->dist_code,
                    'subdiv_code' => $ord->subdiv_code,
                    'cir_code' => $ord->cir_code,
                    'mouza_pargona_code' => $ord->mouza_pargona_code,
                    'lot_no' => $ord->lot_no,
                    'vill_townprt_code' => $ord->vill_townprt_code,
                    'pdar_id' => $ord->pdar_id,
                    'patta_no' => trim($ord->new_patta_no),
                    'dag_no' => trim($ord->new_dag_no),
                    'patta_type_code' => $ord->new_patta_type,
                    'dag_por_b' => $ord->land_area_b,
                    'dag_por_k' => $ord->land_area_k,
                    'dag_por_lc' => $ord->land_area_lc,
                    'dag_por_g' => 0.0,
                    'dag_por_kr' => 0,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d H:i:s'),
                    'operation' => 'E',
                    'p_flag' => '0',
                );
                //var_dump($dag_pattadar);

                // $insert_cdp = $this->db->insert('chitha_dag_pattadar', $dag_pattadar);  //*********************
                $insert_cdp = $this->Chitha_basic_model->insert_table('chitha_dag_pattadar',$dag_pattadar);
                if($insert_cdp != 1){

                    log_message('error', '#ERRCONVDC0040: Insertion failed in petition_proceeding for case no :'. $case_no. "######".$this->db->last_query());
                    $this->db->trans_rollback();
                    $json = [
                        'message'=>"#ERRCONVDC0040: Failed to insert for Case No : ".$case_no
                    ];
                    echo json_encode($json);
                    return false;
                }
            }

            unset($order->year_no);
            unset($order->petition_no);

            unset($order->petition_no);

            unset($order->iscorrected_inco);
            unset($order->iscorrected_inco_date);
            unset($order->iscorrected_rkg_record);
            unset($order->iscorrected_rkg_date);
            unset($order->pdar_id);
            unset($order->pdar_strike);
            unset($order->ord_onbehalf_guard);
            unset($order->ord_onbehalf_add1);
            unset($order->ord_onbehalf_add2);
            unset($order->make_mdb);
            unset($order->is_converted_pattadar);
            unset($order->patta_type_code);
            //unset($order->patta_no);
            unset($order->ord_onbehalf_id);
            unset($order->ord_onbehalf_of);
            unset($order->premium);
            unset($order->premi_chal_recpt);
            unset($order->premi_chal_recpt_no);
            unset($order->land_area_b);
            unset($order->land_area_k);
            unset($order->land_area_lc);
            unset($order->min_revenue);
            unset($order->ifyes_reason3);
            unset($order->ifyes_reason2);
            unset($order->ifyes_reason1);
            unset($order->isorder_cancelled);
            unset($order->isdataposted_torkg_db);

            $order->ord_cron_no = $ord_cron_no;
            $order->rmk_type_hist_no = $rmk_hist_no;
            $order->user_code = $this->session->userdata('user_code');
            $order->operation = 'E';
            $order->date_entry = date('Y-m-d H:i:s');
            $order->area_left_b = 0;
            $order->area_left_k = 0;
            $order->area_left_lc = 0;
            $order->area_left_g = 0;
            $order->area_left_kr = 0;

            //var_dump($order);
            $get_new_patta_no = $this->db->query("select distinct(new_patta_no) as new_patta_no from    t_chitha_rmk_convorder where ord_no='$order->ord_no'")->row()->new_patta_no;
            $get_old_patta_no = $this->db->query("select distinct(patta_no) as patta_no from    t_chitha_rmk_convorder where ord_no='$order->ord_no'")->row()->patta_no;
            //this is for the old one
            $rmk_gen_for_old = array(
                'dist_code' => $order->dist_code,
                'subdiv_code' => $order->subdiv_code,
                'cir_code' => $order->cir_code,
                'mouza_pargona_code' => $order->mouza_pargona_code,
                'vill_townprt_code' => $order->vill_townprt_code,
                'lot_no' => $order->lot_no,
                'dag_no' => $order->dag_no,
                'rmk_type_code' => '01',
                'rmk_type_hist_no' => $rmk_hist_no,
                'user_code' => $this->session->userdata('user_code'),
                'operation' => 'E',
                'date_entry' => date('Y-m-d H:i:s'),
                'jama_updated' => ' ',
                'new_dag_no' => $order->new_dag_no,
                'patta_no'=>trim($get_old_patta_no)
            );


            $insert_crg = $this->db->insert('chitha_rmk_gen', $rmk_gen_for_old); //*********************
            if($insert_crg != 1){

                log_message('error', '#ERRCONVDC0041: Insertion failed in chitha_rmk_gen for case no :'. $case_no. "######".$this->db->last_query());
                $this->db->trans_rollback();
                $json = [
                    'message'=>"#ERRCONVDC0041: Failed to insert for Case No : ".$case_no
                ];
                echo json_encode($json);
                return false;
            }

            //this is for the new one
            $rmk_gen_for_new = array(
                'dist_code' => $order->dist_code,
                'subdiv_code' => $order->subdiv_code,
                'cir_code' => $order->cir_code,
                'mouza_pargona_code' => $order->mouza_pargona_code,
                'vill_townprt_code' => $order->vill_townprt_code,
                'lot_no' => $order->lot_no,
                'dag_no' => $order->new_dag_no,
                'rmk_type_code' => '01',
                'rmk_type_hist_no' => $rmk_hist_no,
                'user_code' => $this->session->userdata('user_code'),
                'operation' => 'E',
                'date_entry' => date('Y-m-d H:i:s'),
                'jama_updated' => ' ',
                'new_dag_no' => null,
                'patta_no'=>trim($get_new_patta_no)
            );


            $insert_crg2 = $this->db->insert('chitha_rmk_gen', $rmk_gen_for_new); //*********************
            if($insert_crg2 != 1){
                log_message('error', '#ERRCONVDC0042: Insertion failed in chitha_rmk_gen for case no :'. $case_no. "######".$this->db->last_query());
                $this->db->trans_rollback();
                $json = [
                    'message'=>"#ERRCONVDC0042: Failed to insert for Case No : ".$case_no
                ];
                echo json_encode($json);
                return false;
            }



            $insert_cro = $this->db->insert('chitha_rmk_ordbasic', $order); //*********************
            if($insert_cro != 1){
                log_message('error', '#ERRCONVDC0043: Insertion failed in chitha_rmk_ordbasic for case no :'. $case_no. "######".$this->db->last_query());
                $this->db->trans_rollback();
                $json = [
                    'message'=>"#ERRCONVDC0043: Failed to insert for Case No : ".$case_no
                ];
                echo json_encode($json);
                return false;
            }

            unset($order->dag_no);
            $order->dag_no=$order->new_dag_no;
            $newDag=$order->new_dag_no;
            //var_dump($order);
            unset($order->new_dag_no);


            $insert_cro2 = $this->db->insert('chitha_rmk_ordbasic', $order);
            if($insert_cro2 != 1){
                log_message('error', '#ERRCONVDC0044: Insertion failed in chitha_rmk_ordbasic for case no :'. $case_no. "######".$this->db->last_query());
                $this->db->trans_rollback();
                $json = [
                    'message'=>"#ERRCONVDC0044: Failed to insert for Case No : ".$case_no
                ];
                echo json_encode($json);
                return false;
            }

            $d = date('Y-m-d');
            $update_q = "update t_chitha_rmk_ordbasic set iscorrected_inco='Y',iscorrected_inco_date='$d'"
                . " where ord_no='$order->ord_no' and dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code'";
            $this->db->query($update_q); //*********************

            if ($this->db->affected_rows() == 0) {
                log_message('error', '#ERRCONVDC0045: Updation failed in t_chitha_rmk_ordbasic Case No ' . $case_no. "######".$this->db->last_query());
                $this->db->trans_rollback();
                $data = array(
                    'error' => "#ERRCONVDC0045: Update failed for case no : " . $case_no,
                );
                echo json_encode($data);
                return false;
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo "Error Occured";
            } else {
                $this->db->trans_commit();
                $this->AgriStackCaseHistory->CreateLog($dist_code,$case_no);



                $ulpinCheckFlag = $this->input->get('ulpinCheckFlag', true);
                $compareCheckFlag = $this->input->get('compareCheckFlag', true);
                $update_chain =  new \stdClass;
                $update_chain->success = 1;
                if($ulpinCheckFlag == 1 && $compareCheckFlag=='Y' && ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                {
                    ///////////////////////////////////////////////////////////////////////////
                    //////////////////////Property chain code /////////////////////////////////
                    ///////////////////////////////////////////////////////////////////////////

                    $type = LOC_TYPE_RURAL;
                    $conversion_type = CONVERSION_PARTIAL;
                    $certmnemonic = CERTMNEMONIC_CONV;

                    $dist_code = $petition_basic->dist_code;
                    $subdiv_code = $petition_basic->subdiv_code;
                    $cir_code = $petition_basic->cir_code;
                    $lot_no = $petition_basic->lot_no;
                    $vill_townprt_code = $petition_basic->vill_townprt_code;
                    $mouza_pargona_code = $petition_basic->mouza_pargona_code;

                    $property_signature = "base64 encoded signature";
                    $property_signer_key = "base64 encoded public key";
                    $office_code = $this->session->userdata('cir_code');
                    $user_code = $this->session->userdata('user_code');

                    $ulpin = $this->input->get('ulpin', true);
                    $chain_revenue = $this->input->get('chain_revenue', true);
                    $chain_local_tax = $this->input->get('chain_local_tax', true);
                    $old_ulpin = $this->input->get('old_ulpin', true);
                    if (!isset($old_ulpin))
                        $old_ulpin = "";
                    $reference_id = $case_no;
                    $location_id = $dist_code . $subdiv_code . $cir_code . $mouza_pargona_code . $lot_no . $vill_townprt_code;

                    $old_patta_type = $this->input->get('old_patta_type', true);
                    $new_patta_type = $this->input->get('new_patta_type', true);
                    $new_patta_no = $this->input->get('new_patta_no', true);
                    $old_patta_no = $this->input->get('old_patta_no', true);
                    $new_patta_no = $this->input->get('new_patta_no', true);
                    $old_dag_no = $this->input->get('old_dag_no', true);
                    $new_dag_no = $this->input->get('new_dag_no', true);
                    $ne_revenue = $this->input->get('new_revenue', true);
                    $new_local_tax = $this->input->get('new_local_tax', true);

                    $property_id_update = $this->blockchainutilityclass->generatePropertyId($type, $vill_townprt_code, $old_patta_no, $old_dag_no, $ulpin);

                    // 
                    $pattadar_details = $this->PropChainModel->getPattadars($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $old_patta_no, $old_dag_no);

                    // $land_area = $this->PropChainModel->getLandArea($dist_code, $subdiv_code,  $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $old_patta_no, $old_dag_no);

                    // $land_area = $this->PropChainModel->getLandArea2($case_no);

                    // $bigha_chain = $land_area->dag_area_b;
                    // $katha_chain = $land_area->dag_area_k;
                    // $lessa_chain = $land_area->dag_area_lc;
                    // $ganda_chain = $land_area->dag_area_g;

                    ////////////////////////////////////////////////////////////////////////first update old property ///////////////////////////////////////////////////////////////

                    $chain_data_params = array(
                        'dist_code' => $dist_code,
                        'subdiv_code' => $subdiv_code,
                        'cir_code' => $cir_code,
                        'mouza_pargona_code' => $mouza_pargona_code,
                        'lot_no' => $lot_no,
                        'vill_townprt_code' => $vill_townprt_code,
                        'old_patta' => $old_patta_no,
                        'old_dag' => $old_dag_no,
                        'patta_type_code' => $old_patta_type,
                        'reference_id' => $reference_id,
                        'land_class_code' => $landclasscode,
                        'remaining_b' => $b,
                        'remaining_k' => $k,
                        'remaining_lc' => $lc,
                        'remaining_g' => $g,
                        'certmnemonic' => $certmnemonic,
                        'property_signature' => $property_signature,
                        'property_signer_key' => $property_signer_key,
                        'office_code' => $office_code,
                        'user_code' => $user_code,
                        'ulpin' => $ulpin,
                        'old_ulpin' => $old_ulpin,
                        'dag_revenue' => $ne_revenue,
                        'dag_local_tax' => $new_local_tax,
                        'new_patta_no' => $new_patta_no,
                        'new_dag_no' => $new_dag_no,
                        'old_dag_revenue' => $chain_revenue,
                        'old_dag_local_tax' => $chain_local_tax,
                        'old_land_class_code' => $landclasscode,
                        'bigha_new' => $converted_b,
                        'katha_new' => $converted_k,
                        'lessa_new' => $converted_lc,
                        'ganda_new' => $converted_g,
                        'new_patta_type_code' => $new_patta_type
                    );

                    $chainTrans = $this->PropChainModel->chainPartialDagProcessN((object)$chain_data_params);
                    $update_chain =  $chainTrans;
                }

                if ($update_chain->success == 1) {
                    // $this->db->trans_commit();
                    if($ulpinCheckFlag == 1 && $compareCheckFlag=='Y' && ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                    {
                        $location = array(
                            'd' =>  $order->dist_code,
                            's' => $order->subdiv_code,
                            'c' => $order->cir_code,
                            'm' => $order->mouza_pargona_code,
                            'l' => $order->lot_no,
                            'v' => $order->vill_townprt_code,
                        );
                        $this->session->set_userdata(array('loc' => $location));
                        // $popUpmsg = "<h4>Order for Case No $case_no Successfully Saved.Chitha has been Updated !!! Updating JamaBandi Now<h4>";
                        // $msgggg = "<script type='text/javascript'>alert(' " . $popUpmsg . " ');</script>";
                        // redirect('JamaBandi/step3/' . $jama_patta_no . '/' . $jama_patta_type_code . '/' . $chain_update . '/' . $chain_create);
                        $this->session->set_flashdata('message', "*Conversion case is successfully passed for Case No $case_no.<br> *Property Chain updation successful.<br>*New asset creation is pending.<br>*New asset will be created when map is generated at Bhunaksha.");
                        // redirect(base_url() . "index.php/home");
                        redirect(base_url() . 'index.php/PropChainReport/sendPropChain/' . urlencode(base64_encode($case_no)));
                    }
                    $data['_view'] = 'dc_adc_office_conversion/test';
                    $this->load->view('layouts/main',$data);
                } elseif ($update_chain->success == 0 || $update_chain->success == 2) {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', $update_chain->message . ": " . $update_chain->error_msg . ". Property Chain updation for Case No $case_no Not Successfull. Error Code(" . $update_chain->error_code . ")");
                    log_message('error', $update_chain->message . ": " . $update_chain->error_msg . ". Property Chain updation for Case No $case_no Not Successfull. Error Code(" . $update_chain->error_code . ")");
                    redirect(base_url() . "index.php/home");
                } else {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error occured. Property Chain updation and creation for Case No $case_no Not Successfull.");
                    log_message('error', $update_chain->message . ": " . $update_chain->error_msg . ". Property Chain updation for Case No $case_no Not Successfull. Error Code(" . $update_chain->error_code . ")");
                    redirect(base_url() . "index.php/home");
                }






                // $this->load->view('../views/header');
                // $this->load->view('../views/dc_adc_office_conversion/test');
                // $this->load->view('../views/footer');
            }
        }
    }

    public function getNewDagPattaTypeJSON($type_code) {
        $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_codee');
        $subdiv_code = $this->session->userdata('subdiv_codee');
        $cir_code = $this->session->userdata('cir_codee');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_codee');
        $lot_no = $this->session->userdata('lot_noe');
        $vill_townprt_code = $this->session->userdata('vill_codee');
        $sql = "Select dag_no,patta_no from    chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no'";
        //echo $sql;
        $dag_no = $data['oldDag'] = $this->db->query($sql)->result();
        //var_dump($dag_no);
        $newDag = 0;
        foreach ($dag_no as $d) {
            $d = $d->dag_no;
            if ($newDag < $d) {
                $newDag = $d;
            }
        }
        $sqll = "Select dag_no,patta_no from    chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no'";
        $patta = $data['oldPatta'] = $this->db->query($sqll)->result();
        $newpatta = 0;
        foreach ($patta as $p) {
            $p = trim($p->patta_no);
            if ($newpatta < $p) {
                $newpatta = $p;
            }
        }
        $json[] = array('new_dag' => $newDag + 1, 'new_patta' => $newpatta + 1);
        echo json_encode($json);
    }

    public function ViewActionTakenReport() {
        $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $data = array();
        $case_no = $this->input->get('case_no');
        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' "
            . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row();

        $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,next_date_of_hearing,co_order_conv_date"
            . " from    petition_basic where case_no='$case_no'")->row_array();



        $locationData = array(
            'dist_code' => $location['dist_code'],
            'subdiv_code' => $location['subdiv_code'],
            'cir_code' => $location['cir_code'],
            'lot_no' => $location['lot_no'],
            'vill_code' => $location['vill_townprt_code'],
            'mouza_pargona_code' => $location['mouza_pargona_code']
        );
        $dist_code = $this->utilityclass->getDistrictName($location['dist_code']);
        $subdiv_code = $this->utilityclass->getSubDivName($location['dist_code'], $location['subdiv_code']);
        $cir_code = $this->utilityclass->getCircleName($location['dist_code'], $location['subdiv_code'], $location['cir_code']);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code']);
        $lot_no = $this->utilityclass->getLotName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no']);
        $vill_townprt_code = $this->utilityclass->getVillageName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $location['vill_townprt_code']);
        $data['location'] = array(
            'dist' => $dist_code,
            'sub' => $subdiv_code,
            'cir' => $cir_code,
            'mouza' => $mouza_pargona_code,
            'lot' => $lot_no,
            'vill' => $vill_townprt_code,
            'case_no' => $case_no,
            'date' => $location['next_date_of_hearing'],
            'next_date' => $location['co_order_conv_date']
        );

        $convertion_code = CONVERSION_CODE;
        $data['conv_type'] = $this->db->query("select order_type from    master_office_mut_type "
            . " where order_type_code='$convertion_code'")->row()->order_type;

        $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from    petition_dag_details where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'")->row_array();

        $pattadardetails = "select pdar_name,pdar_guardian,pdar_rel_guar,pdar_add1,pdar_add2 from    petitioner_part where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and dag_no='$landdetails[dag_no]' and TRIM(patta_no)=trim('$landdetails[patta_no]') and patta_type_code= '$landdetails[patta_type_code]'";
        $data['p_in_order'] = $this->db->query($pattadardetails)->result();


        $query = "select * from    petition_proceeding where case_no = '$case_no'";
        $data['cases'] = $this->db->query($query)->result();


        $this->load->helper('html');
        $this->load->view('../views/header');
        $this->load->view('../views/dc_adc_office_conversion/action_taken_report', $data);
        $this->load->view('../views/footer');
    }

    public function chech_dag_patta_exist($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$new_dag_no,$new_patta_no,$new_patta_type){
        $db=  $this->session->userdata('db');
        $check_dag = $this->db->query("Select count(*) as cd from    chitha_basic where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and "
            . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code' and dag_no = '$new_dag_no'")->row()->cd;// and patta_type_code = '$new_patta_type'

        //if $check_dag is 1 then the dag exist
        echo json_encode($check_dag);
    }

    function confirmRejectOrder(){
        $this->form_validation->set_rules('remark', 'Remark', 'required');
        $this->form_validation->set_rules('case_no', 'Case Number', 'required');
        $this->db->trans_begin();
        //$this->form_validation->set_rules('type', 'type', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message',"Case No not Found. Please Try Again");
            redirect('/home');
        }else{
            //syntax validation
            $requestResponse = checkRequestSpecChar($_POST);
            if($requestResponse['status'] == 'n') {
                //ERRCONVDCREJECT0001
                log_message('error', $requestResponse['messages'] . '. Error: ERRCONVDCREJECT0001');
                $this->session->set_flashdata('message', 'Contains Illegal parameter values. Error: ERRCONVDCREJECT0001');
                redirect(base_url('index.php/home'));
            }

            //malicious query validation
            $validResponse = checkRequestValidQuery($_POST);
            if($validResponse['status'] == 'n') {
                //ERRCONVDCREJECT0002
                log_message('error', $validResponse['messages'] . '. Error: ERRCONVDCREJECT0002');
                $this->session->set_flashdata('message', 'Contains Malicious parameter values. Error: ERRCONVDCREJECT0002');
                redirect(base_url('index.php/home'));
            }
            // echo '<pre>';
            // var_dump($_POST);
            // die();
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $user_code = $this->session->userdata('user_code');
            $case_no=$this->input->post('case_no');
            $remark=$this->input->post('remark');
            //$case_no=$this->input->post('case_no');
            $q = "Select max(proceeding_id)+1 as id from petition_proceeding where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
            $id = $this->db->query($q)->row()->id;

            if ($id == null) {
                $id = 1;
            }
            $date = date('Y-m-d');
            $pp = array(
                'case_no' => $case_no,
                'proceeding_id' => $id,
                'date_of_hearing' => date('Y-m-d H:i:s'),
                'co_order' => $remark,
                'next_date_of_hearing' => date('Y-m-d'),
                'status' => 'F',
                'user_code' => $user_code,
                'date_entry' => date('Y-m-d H:i:s'),
                'operation' => 'E',
                'dist_code' => $dist_code,
                'subdiv_code' => '00',
                'cir_code' => '00'
            );
            $pb=array(
                'status'=>'D',
                'order_passed'=>'Y',
                'date_of_order'=>date('Y-m-d H:i:s'),
                'co_user_code'=>$user_code,
            );
            $this->db->where('case_no', $case_no);
            $this->db->where('dist_code', $dist_code);
            // $this->db->where('subdiv_code', $subdiv_code);
            // $this->db->where('cir_code', $cir_code);
            $this->db->update('petition_basic', $pb);

            if ($this->db->affected_rows() == 0) {
                log_message('error', '#ERRCONVDC0046: Updation failed in petition_basic Case No ' . $case_no. "######".$this->db->last_query());
                $this->db->trans_rollback();
                $data = array(
                    'error' => "#ERRCONVDC0046: Update failed for case no : " . $case_no,
                );
                echo json_encode($data);
                return false;
            }


            $insert_pp7 = $this->db->insert('petition_proceeding', $pp);
            if($insert_pp7 != 1){
                $this->db->trans_rollback();
                log_message('error', '#ERRCONVDC0047: Insertion failed in petition_proceeding for case no :'. $case_no);
                $json = [
                    'message'=>"#ERRCONVDC0047: Failed to in Proceeding for Case No : ".$case_no
                ];
                echo json_encode($json);
                return false;
            }

            if ($this->db->trans_status() == false) {
                $this->db->trans_rollback();
                $data = array(
                    'error' => "Error in submitting. Please try Again",
                );
            }
            else
            {

                $this->DashboardDataReject($case_no);

                $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
                if($basundharaExist){
                    $rmk= $remark;
                    $status='R';
                    $task='CO';
                    $pen='NA';
                    $case=$case_no;

                    $rtps_status = $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
                    //var_dump($rtps_status);
                    if (trim($rtps_status) !="y") {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error #ERRDCAPI006: Application unable to process case no # $case_no");
                        redirect(base_url() . "index.php/home");
                    } else {
                        $this->db->trans_commit();
                        $this->session->set_flashdata('message', "Case Rejected Successfully ## $case_no !!");
                        redirect(base_url() . 'index.php/home/index');
                    }
                }

            }
        }
    }
    function DashboardData($case_no,$penUser,$rmrk){
        //////////////Update Dashboard Database///////////////////////
        $this->dbb = $this->load->database('dash', TRUE);
        $base=array(
            'pending_with_user' => $penUser,
            'date_of_update'=>date("Y-m-d h:i:s")
        );
        $this->dbb->where('case_no',$case_no);
        $this->dbb->update('dashboard_data',$base);
        $action= array(
            'case_no' => $case_no,
            'user_code' => $this->session->userdata('user_code'),
            'date_of_action_taken' => date('Y-m-d'),
            'user_designation' => $this->session->userdata('user_desig_code'),
            'remark' => $rmrk,
        );
        $this->dbb->insert('dashboard_action',$action);
        /////////////////////////////////////

        $this->db->where('case_no',$case_no);

        $this->db->update('dashboard_data',$base);
    }

    function DashboardDataFinal($case_no){
        //////////////Update Dashboard Database///////////////////////
        $this->dbb = $this->load->database('dash', TRUE);
        $base=array(
            'final_order_date' => date('Y-m-d'),
            'pending_with_user'=>'NA',
            'status'=>'F',
            'remark'=>'Final Order Passed',
            'date_of_update'=>date("Y-m-d h:i:s")
        );
        $this->dbb->where('case_no',$case_no);
        $this->dbb->update('dashboard_data',$base);
        $action= array(
            'case_no' => $case_no,
            'user_code' => $this->session->userdata('user_code'),
            'date_of_action_taken' => date('Y-m-d'),
            'user_designation' => $this->session->userdata('user_desig_code'),
            'remark' => 'Final Order Passed',
        );
        $this->dbb->insert('dashboard_action',$action);
        /////////////////////////////////////
    }

    function DashboardDataReject($case_no){
        $this->dbb = $this->load->database('dash', TRUE);
        $base=array(
            'final_order_date' => date('Y-m-d'),
            'pending_with_user'=>'NA',
            'status'=>'R',
            'remark'=>'Case Rejected',
            'date_of_update'=>date("Y-m-d h:i:s")
        );
        $this->dbb->where('case_no',$case_no);
        $this->dbb->update('dashboard_data',$base);

        $this->db->where('case_no',$case_no);
        $this->db->update('dashboard_data',$base);

        $action= array(
            'case_no' => $case_no,
            'user_code' => $this->session->userdata('user_code'),
            'date_of_action_taken' => date("Y-m-d h:i:s"),
            'user_designation' => $this->session->userdata('user_desig_code'),
            'remark' => 'Rejected',
            'ip_address'=>$this->utilityclass->get_client_ip()
        );
        $this->dbb->insert('dashboard_action',$action);
        $this->db->insert('dashboard_action',$action);
    }


    public function DepartmentProceeding() {
        $db=  $this->session->userdata('db');
        //var_dump($this->session->all_userdata());
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');
        $this->session->set_userdata(array('subdiv_code1' => $subdiv_code));
        $this->session->set_userdata(array('cir_code1' => $cir_code));
        $this->session->set_userdata(array('mouza_pargona_code1' => $mouza_pargona_code));
        $this->session->set_userdata(array('lot_no1' => $lot_no));
        $this->session->set_userdata(array('vill_townprt_code1' => $vill_townprt_code));

        $data = array();
        $case_no = $this->input->get('case_no');
        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and "
            . "subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
            . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row();
        $data['petition_basic']= $petition_basic;

        $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,date_entry,add_off_name,add_off_desig,next_date_of_hearing,sk_comment,petition_no "
            . "from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
            . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row_array();

        $petition_no = $location['petition_no'];
        $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code 
               from    petition_dag_details where dist_code='$dist_code' and subdiv_code='$subdiv_code'
               and cir_code='$cir_code' and lot_no='$lot_no' and 
               vill_townprt_code='$vill_townprt_code' and mouza_pargona_code='$mouza_pargona_code' 
               and petition_no='$petition_no'")->row_array();

        //    $designation = $this->db->query("select user_desig_as as user_designation from    master_user_designation where user_desig_code='".$location['add_off_desig']."'")->row()->user_designation;

        $locationData = array(
            'dist_code' => $location['dist_code'],
            'subdiv_code' => $location['subdiv_code'],
            'cir_code' => $location['cir_code'],
            'lot_no' => $location['lot_no'],
            'vill_code' => $location['vill_townprt_code'],
            'mouza_pargona_code' => $location['mouza_pargona_code']
        );
        $data['l_data']=$locationData;
        $dist_code = $this->utilityclass->getDistrictName($location['dist_code']);
        $subdiv_code = $this->utilityclass->getSubDivName($location['dist_code'], $location['subdiv_code']);
        $cir_code = $this->utilityclass->getCircleName($location['dist_code'], $location['subdiv_code'], $location['cir_code']);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code']);
        $lot_no = $this->utilityclass->getLotName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no']);
        $vill_townprt_code = $this->utilityclass->getVillageName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $location['vill_townprt_code']);

        $data['patta_type'] = $this->db->query("select patta_type from    patta_code "
            . " where type_code='$landdetails[patta_type_code]'")->row()->patta_type;
        $m_dag_area_lc = $landdetails['m_dag_area_lc'];
        $m_dag_area_lc = round($m_dag_area_lc, 2);
        $data['location'] = array(
            'dist' => $dist_code,
            'sub' => $subdiv_code,
            'cir' => $cir_code,
            'mouza' => $mouza_pargona_code,
            'lot' => $lot_no,
            'vill' => $vill_townprt_code,
            'case_no' => $case_no,
            'date' => $location['date_entry'],
            'add_to' => $location['add_off_name'],
            'add_off_designation' => 'DC',
            'next_date' => $location['next_date_of_hearing'],
            'sk_comment' => $location['sk_comment'],
            'dag' => $landdetails['dag_no'],
            'm_dag_area_b' => $landdetails['m_dag_area_b'],
            'm_dag_area_k' => $landdetails['m_dag_area_k'],
            'm_dag_area_lc' => $m_dag_area_lc,
            'patta_no' => trim($landdetails['patta_no']),
            'patta_type' => $landdetails['patta_type_code'],
        );

        $convertion_code = CONVERSION_CODE;
        $data['conv_type'] = $this->db->query("select order_type from    master_office_mut_type "
            . " where order_type_code='$convertion_code'")->row()->order_type;

        $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from    petition_dag_details where "
            . "dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' "
            . "and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' "
            . "and petition_no='$petition_basic->petition_no'")->row_array();

        $m_dag_area_lc = $landdetails['m_dag_area_lc'];
        $m_dag_area_lc = round($m_dag_area_lc, 2);

        $data['land_details'] = array(
            'dag' => $landdetails['dag_no'],
            'm_dag_area_b' => $landdetails['m_dag_area_b'],
            'm_dag_area_k' => $landdetails['m_dag_area_k'],
            'm_dag_area_lc' => $m_dag_area_lc,
            'patta_no' => trim($landdetails['patta_no']),
            'patta_type' => $landdetails['patta_type_code']
        );

        $data['patta_type'] = $this->db->query("select patta_type from    patta_code "
            . " where type_code='$landdetails[patta_type_code]'")->row()->patta_type;

        $pattadardetails = "select pdar_name,pdar_guardian,pdar_rel_guar,pdar_add1,pdar_add2 from    petitioner_part where dist_code='$petition_basic->dist_code' "
            . "and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and "
            . "vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and "
            . "petition_no='$petition_basic->petition_no' and dag_no='$landdetails[dag_no]' and TRIM(patta_no)=trim('$landdetails[patta_no]') and patta_type_code= '$landdetails[patta_type_code]'";

        $data['pattadar'] = $this->db->query($pattadardetails)->result();
        $data['p_in_order'] = $this->db->query($pattadardetails)->result();
        $lm_details = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
            . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and "
            . "mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' order by note_no desc limit 1 ")->row_array();

        if (count($lm_details) != '0') {
            $land = $lm_details['land_class_code'];
            $land_type = $this->db->query("Select * from    landclass_code where class_code = '$land'")->row();

            $prim_per_bigha = $lm_details['prim_per_bigha'];
            $prim_per_bigha = round($prim_per_bigha, 2);

            $prim_tot = $lm_details['prim_tot'];
            $prim_tot = round($prim_tot, 2);

            $data['lm_details'] = array(
                //'petition_no' => $lm_details[''],
                'dag_no' => $lm_details['dag_no'],
                'note_no' => $lm_details['note_no'],
                'partition_info' => $lm_details['partition_info'],
                //'user_code' => $lm_details[''],
                'date_entry' => $lm_details['date_entry'],
                //'operation' => $lm_details[''],
                'applicant_patta_yn' => $lm_details['applicant_patta_yn'],
                'occupied_yn' => $lm_details['occupied_yn'],
                'val_tree_yn' => $lm_details['val_tree_yn'],
                'dist_frm_town' => $lm_details['dist_frm_town'],
                'inside_outside_town' => $lm_details['inside_outside_town'],
                'land_class_code' => $land_type->land_type,
                'issuit_forconv_under105' => $lm_details['issuit_forconv_under105'],
                'roadside_rsv_b' => $lm_details['roadside_rsv_b'],
                'roadside_rsv_k' => $lm_details['roadside_rsv_k'],
                'roadside_rsv_lc' => $lm_details['roadside_rsv_lc'],
                'near_river_yn' => $lm_details['near_river_yn'],
                'prim_per_bigha' => $prim_per_bigha,
                'conv_b' => $lm_details['conv_b'],
                'conv_k' => $lm_details['conv_k'],
                'conv_lc' => $lm_details['conv_lc'],
                'prim_tot' => $prim_tot,
                'lm_sign_yn' => $lm_details['lm_sign_yn'],
                'case_no' => $case_no,
                'lm_code' => $lm_details['lm_code'],
                'sk_note_date' => $lm_details['sk_note_date'],
                'sk_note' => $lm_details['sk_note'],
                'sk_sign_yn' => $lm_details['sk_sign_yn'],
                'sk_name' => $lm_details['user_code'],
                'jati_janajati_yn' => $lm_details['jati_janajati_yn'],
                'jati_janajati_upload' => $lm_details['jati_janajati_upload'],
                'freedom_fighter_yn' => $lm_details['freedom_fighter_yn'],
                'freedom_fighter_upload' => $lm_details['freedom_fighter_upload'],
                'widow_yn' => $lm_details['widow_yn'],
                'widow_upload' => $lm_details['widow_upload'],
                'premium_assesment' => $lm_details['premium_assesment']
            );
        }

        $namelm = $this->db->query("select * from    lm_code where lm_code = '" . $lm_details['lm_code'] . "'  and dist_code = '" . $location['dist_code'] . "' and "
            . "subdiv_code = '" . $location['subdiv_code'] . "' and cir_code = '" . $location['cir_code'] . "' and mouza_pargona_code = '" . $location['mouza_pargona_code'] . "' "
            . "and lot_no = '" . $location['lot_no'] . "' ")->row();

        $data['lm_name'] = $namelm->lm_name;

        $skname = $this->db->query("select * from    users where user_code='" . $lm_details['user_code'] . "'  and dist_code = '" . $lm_details['dist_code'] . "' and "
            . "subdiv_code = '" . $lm_details['subdiv_code'] . "' and cir_code = '" . $lm_details['cir_code'] . "' ")->row();

        $data['sk_skname'] = $skname->username;



        $query = "select * from    petition_proceeding where case_no = '$case_no'";
        $data['cases'] = $this->db->query($query)->result();

        $dc_adc_order = "select * from    petition_proceeding_dc_adc where case_no = '$case_no' order by proceeding_id";
        $data['dc_adc_order'] = $this->db->query($dc_adc_order)->result();

        $data['lm_details_final'] = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
            . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and "
            . "mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' order by note_no desc limit 1")->result();
        $data['bo_details_final'] = $this->db->query("Select * from    petition_bo_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
            . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and "
            . "mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'")->result();


        $data['premium'] = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and "
            . "cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and "
            . "mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and "
            . "co_reject is NULL ORDER BY note_no DESC LIMIT 1")->result();

        $data['branch_officer']=$this->db->query("Select users.username as username, users.user_desig_code as user_desig_code, loginuser_table.user_code as user_code from    users, "
            . "loginuser_table where users.dist_code = loginuser_table.dist_code "
            . "and users.user_code = loginuser_table.user_code and users.user_desig_code = 'BO' and users.dist_code='$petition_basic->dist_code' and "
            . "users.subdiv_code='00' and users.cir_code='00' and loginuser_table.dis_enb_option = 'E'")->result();
        $data['basundharaAttachment']=$this->MbOfficeConversionModel->searchBasundharaLink($case_no);
        $data['_view'] = 'dc_adc_office_conversion/Department_Proceeding';
        $this->load->view('layouts/main',$data);


    }


    public function DepartmentReportSubmit(){
        //form validation
        $formValidation = $this->FormValidationModel->formValidationForPost($_POST, [
            'case_no'=>'Case No|required|case_no',
            'dc_adc_notice'=>'DC/ADC Notice|required',
            'dept_order_no'=>'Department Order No|required',
            'date_of_entry'=>'Date of Entry|required|date',
            'order_type'=>'Order Type|required'
        ]);
        if($formValidation['status'] == 'n') {
            //ERRCONVDCDEPT0001
            log_message('error', 'Message: '. $formValidation['message'] .', Data: '. json_encode($formValidation['data']) .'. Error: ERRCONVDCDEPT0001');
            $this->session->set_flashdata('message', $formValidation['message'] .' Error: ERRCONVDCDEPT0001');
            redirect(base_url('index.php/dc_conversion_mb/GoToDC?pro=5'));
        }

        //syntax validation
        $requestResponse = checkRequestSpecChar($_POST, ['dc_adc_notice'=>['%']], [], ['dc_adc_notice'=>true]);
        if($requestResponse['status'] == 'n') {
            //ERRCONVDCDEPT0002
            log_message('error', $requestResponse['messages'] . '. Error: ERRCONVDCDEPT0002');
            $this->session->set_flashdata('message', 'Contains Illegal parameter values. Error: ERRCONVDCDEPT0002');
            redirect(base_url('index.php/dc_conversion_mb/GoToDC?pro=5'));
        }

        //malicious query validation
        $validResponse = checkRequestValidQuery($_POST, [], ['dc_adc_notice'=>['%']], ['dc_adc_notice'=>true]);
        if($validResponse['status'] == 'n') {
            //ERRCONVDCDEPT0003
            log_message('error', $validResponse['messages'] . '. Error: ERRCONVDCDEPT0003');
            $this->session->set_flashdata('message', 'Contains Malicious parameter values. Error: ERRCONVDCDEPT0003');
            redirect(base_url('index.php/dc_conversion_mb/GoToDC?pro=5'));
        }

        //authorization
        $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'DC', $_POST['case_no'], CONV_DC_DEPT_REPORT);
        if($authorization['status'] == 'n') {
            //ERRCONVDCDEPT0004
            log_message('error', $authorization['messages'] . '. Error: ERRCONVDCDEPT0004');
            $this->session->set_flashdata('message', $authorization['messages'].'. Error: ERRCONVDCDEPT0004');
            redirect(base_url('index.php/home'));
        }
        // echo '<pre>';
        // var_dump($_POST);
        // die();

        $path = CONVERSION_DOCS_BASE_DIR;
        if(!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        //$db=  $this->session->userdata('db');
        $this->db->trans_begin();
        $config['upload_path'] = CONVERSION_DOCS_BASE_DIR;
        $config['allowed_types'] = 'gif|jpg|png';
        $config['encrypt_name'] = TRUE;
        $config['detect_mime'] = TRUE;
        $config['mod_mime_fix'] = TRUE;
        $this->load->library('upload', $config);


        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code1');
        $cir_code = $this->session->userdata('cir_code1');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code1');
        $lot_no = $this->session->userdata('lot_no1');
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');

        $case_no = $this->input->post('case_no');
        $dag_no = $this->input->post('dag_no');
        $entry_date =  date('Y-m-d',strtotime($this->input->post('date_of_entry')));
        $dept_order_no = $this->input->post('dept_order_no');

        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' and 
        dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
            . "and mouza_pargona_code ='$mouza_pargona_code' and lot_no='$lot_no'")->row();
        // echo $this->db->last_query();

        //Department upload validation starts here

        $count = $this->db->query("SELECT count(case_no) AS count FROM supportive_document 
        WHERE case_no=?", array($case_no))->row()->count;
        // var_dump($petition_basic); die;
        $sl = $count+1;
        // $path = './ConversionDocs/';

        $file = $petition_basic->petition_no.date('Y').'_'.$sl;

        $_FILES['file']['type'] = $_FILES['up_dept_doc']['type'];
        $_FILES['file']['tmp_name'] = $_FILES['up_dept_doc']['tmp_name'];
        $_FILES['file']['error'] = $_FILES['up_dept_doc']['error'];
        $_FILES['file']['size'] = $_FILES['up_dept_doc']['size'];

        $ext = pathinfo($_FILES['up_dept_doc']['name'], PATHINFO_EXTENSION);
        $_FILES['file']['name'] = $file.'.'.$ext;

        $config = array(
            'upload_path' => CONVERSION_DOCS_BASE_DIR,
            'allowed_types' => FILE_TYPE,
            'max_size' => MAX_SIZE,
        );

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ($this->upload->do_upload('file'))
        {
            $data = $this->upload->data();
            $img = [
                'case_no' => $case_no,
                'user_code' => $this->session->userdata('user_code'),
                'file_name' => 'CONVERSION_DEPARTMENT',
                'fetch_file_name' => $file.$data['file_ext'],
                'file_type' => $data['file_type'],
                'file_path' => $path.$file.$data['file_ext'],
                'date_entry' => date('Y-m-d h:i:s'),
                'mut_type' => 'NA',
            ];
            $insUpload = $this->db->insert('supportive_document', $img);

            if($insUpload != 1 ){
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "DPT0001: Unable to pass order !");
                log_message("error","#DPT0001 Uploading Failed for dist:"
                    .$dist_code.", case no: ". $case_no);
                redirect(base_url() . "index.php/home");
                return false;
            }
        }
        ////////////Department ends here////////

        $proceeding = $this->db->query("select count(proceeding_id) as proceed from    petition_proceeding_dc_adc where case_no = '$case_no' limit 1")->result();
        $proceeding_id = $proceeding[0]->proceed + 1;

        $proceeding_data_dept = array(
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => $entry_date,
            'co_order' => "Convesrion Case Approved by Department. Department Order Number : ".$dept_order_no,
            //'note_on_order' => '',
            //'next_date_of_hearing' => $hearing_date,
            'status' => 'Pending',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d h:i:s'),
            'operation' => 'E',
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code
        );
        //var_dump($proceeding_data);
        $deptInsert = $this->db->insert('petition_proceeding_dc_adc', $proceeding_data_dept);//****************

        if($deptInsert != 1){
            $this->db->trans_rollback();
            log_message('error', '#DPT0012: Insertion failed in petition_proceeding_dc_adc Case No '.$case_no);

            $this->session->set_flashdata('message', "#DPT0012: Conversion can't be proceed for case no : ".$case_no);
            redirect(base_url() . "index.php/home");
            return false;
        }

        $dept_note = "UPDATE  Petition_Basic SET dept_note_yn='Y', dept_order_no='$dept_order_no', status='P', co_user_code='$user_code', add_off_desig='$user_desig_code' WHERE case_no = '$case_no' and dist_code='$petition_basic->dist_code' "
            . "and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and "
            . "vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code'";

        $this->db->query($dept_note); // ********************
        if($this->db->affected_rows() <=0 )
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "LMCP0002: Unable to pass order !");
            log_message("error","#LMCP0002 Failed to update Department Approval in Petition_Basic for dist:"
                .$dist_code.", case no: ". $case_no);
            redirect(base_url() . "index.php/home");
            return false;
        }

        if ($this->db->trans_status()==false) {
            $this->db->trans_rollback();
            $data=array(
                'error'=>"Error in submitting. Please try Again"
            );
        } else {

            //////////
            $penUser='DC';
            $rmrk='Report by Department';
            $this->DashboardData($case_no,$penUser,$rmrk);
            $rmk=$rmrk;
            $status='M';
            $task='DC';
            $pen='DC';
            $case=$case_no;

            $rtps_status = $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
            //var_dump($rtps_status);
            if (trim($rtps_status) !="y") {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error #ERRDCAPI008: Application unable to process case no # $case_no");
                redirect(base_url() . "index.php/home");
            } else {
                $this->db->trans_commit();

            }
            ///////
            $this->session->set_flashdata('message',"Conversion Case no # $case_no forwarded to # $user_desig_code for Payment Generate !!");
            redirect(base_url()."index.php/home");
        }

    }

    //added by Hridayjit--13/05/2024
    public function DepartmentReverted() {
        $case_no = $this->input->get('case_no');
        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');
        $user_code = $this->session->userdata('user_code');

        // --added by hridayjit--12/05/2024
        //add_off_desig='DC' AND co_user_code=? AND user_code LIKE '%DPT%'
        // $data['petition_basic'] = $petitionBasic = $this->PetitionBasicModel->get(['dist_code'=>$dist_code, 'subdiv_code'=>$subdiv_code, 'cir_code'=>$cir_code, 'mouza_pargona_code'=>$mouza_pargona_code, 'lot_no'=>$lot_no, 'vill_townprt_code'=>$vill_townprt_code, 'case_no'=>$case_no, 'status'=>'R', 'add_off_desig'=>'DC', 'co_user_code'=>$user_code], ['bo_note_yn is not null'], ['user_code'=>'DPT']);
        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' and dist_code='$dist_code'")->row();
        $data['petition_basic']= $petitionBasic =$petition_basic;

        $data['proceeding_dc_adc'] = $this->PetitionProceedingDcAdcModel->getProceedingDcAdc($petitionBasic->case_no);
        // var_dump($data['petition_basic']); die;

        $petition_no = $petitionBasic->petition_no;

        $petitionDagDetails = $this->PetitionDagDetailsModel->get(['dist_code'=>$petitionBasic->dist_code, 'subdiv_code'=>$petitionBasic->subdiv_code, 'cir_code'=>$petitionBasic->cir_code, 'lot_no'=>$petitionBasic->lot_no, 'vill_townprt_code'=>$petitionBasic->vill_townprt_code, 'mouza_pargona_code'=>$petitionBasic->mouza_pargona_code, 'petition_no'=>$petition_no]);

        $designation = $this->db->query("select user_desig_as as user_designation from master_user_designation where user_desig_code=?", [$petitionBasic->add_off_desig])->row()->user_designation;

        $locationData = array(
            'dist_code' => $petitionBasic->dist_code,
            'subdiv_code' => $petitionBasic->subdiv_code,
            'cir_code' => $petitionBasic->cir_code,
            'lot_no' => $petitionBasic->lot_no,
            'vill_code' => $petitionBasic->vill_townprt_code,
            'mouza_pargona_code' => $petitionBasic->mouza_pargona_code
        );
        $data['l_data'] = $locationData;

        $dist_name = $this->utilityclass->getDistrictName($petitionBasic->dist_code);
        $subdiv_name = $this->utilityclass->getSubDivName($petitionBasic->dist_code, $petitionBasic->subdiv_code);
        $cir_name = $this->utilityclass->getCircleName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code);
        $mouza_pargona_name = $this->utilityclass->getMouzaName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code, $petitionBasic->mouza_pargona_code);
        $lot_name = $this->utilityclass->getLotName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code, $petitionBasic->mouza_pargona_code, $petitionBasic->lot_no);
        $vill_townprt_name = $this->utilityclass->getVillageName($petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code, $petitionBasic->mouza_pargona_code, $petitionBasic->lot_no, $petitionBasic->vill_townprt_code);

        $data['patta_type'] = $this->db->query("select patta_type from patta_code where type_code=?", [$petitionDagDetails->patta_type_code])->row()->patta_type;

        $m_dag_area_lc = $petitionDagDetails->m_dag_area_lc;
        $m_dag_area_lc = round($m_dag_area_lc, 2);
        $data['location'] = array(
            'dist' => $dist_name,
            'sub' => $subdiv_name,
            'cir' => $cir_name,
            'mouza' => $mouza_pargona_name,
            'lot' => $lot_name,
            'vill' => $vill_townprt_name,
            'case_no' => $case_no,
            'date' => $petitionBasic->date_entry,
            'add_to' => $petitionBasic->add_off_name,
            'add_off_designation' => $designation,
            'next_date' => $petitionBasic->next_date_of_hearing,
            'sk_comment' => $petitionBasic->sk_comment,
            'dag' => $petitionDagDetails->dag_no,
            'm_dag_area_b' => $petitionDagDetails->m_dag_area_b,
            'm_dag_area_k' => $petitionDagDetails->m_dag_area_k,
            'm_dag_area_lc' => $m_dag_area_lc,
            'patta_no' => trim($petitionDagDetails->patta_no),
            'patta_type' => $petitionDagDetails->patta_type_code,
        );

        $convertion_code = CONVERSION_CODE;
        $data['conv_type'] = $this->db->query("select order_type from master_office_mut_type where order_type_code=?", [$convertion_code])->row()->order_type;

        $m_dag_area_lc = $petitionDagDetails->m_dag_area_lc;
        $m_dag_area_lc = round($m_dag_area_lc, 2);

        $data['land_details'] = array(
            'dag' => $petitionDagDetails->dag_no,
            'm_dag_area_b' => $petitionDagDetails->m_dag_area_b,
            'm_dag_area_k' => $petitionDagDetails->m_dag_area_k,
            'm_dag_area_lc' => $m_dag_area_lc,
            'patta_no' => trim($petitionDagDetails->patta_no),
            'patta_type' => $petitionDagDetails->patta_type_code
        );

        $pattadardetails = $this->db->query("select pdar_name,pdar_guardian,pdar_rel_guar,pdar_add1,pdar_add2 from    petitioner_part where dist_code=? and subdiv_code=? and cir_code=? and lot_no=? and vill_townprt_code=? and mouza_pargona_code=? and petition_no=? and dag_no=? and TRIM(patta_no)=? and patta_type_code=?", [$petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code, $petitionBasic->lot_no, $petitionBasic->vill_townprt_code, $petitionBasic->mouza_pargona_code, $petitionBasic->petition_no, $petitionDagDetails->dag_no, trim($petitionDagDetails->patta_no), $petitionDagDetails->patta_type_code])->result();

        $data['pattadar'] = $pattadardetails;
        $data['p_in_order'] = $pattadardetails;

        $lm_details = $this->db->query("Select * from petition_lm_note where dist_code=? and subdiv_code=? and cir_code=? and lot_no=? and vill_townprt_code=? and mouza_pargona_code=? and petition_no=? order by note_no desc limit 1", [$petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code, $petitionBasic->lot_no, $petitionBasic->vill_townprt_code, $petitionBasic->mouza_pargona_code, $petitionBasic->petition_no])->row();

        $data['lm_details_final'] = $lm_details;



        // $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,date_entry,add_off_name,add_off_desig,next_date_of_hearing,sk_comment,petition_no "
        //         . "from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
        //         . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row_array();



        // $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code 
        // from    petition_dag_details where dist_code='$petitionBasic->dist_code' and subdiv_code='$subdiv_code'
        // and cir_code='$petitionBasic->cir_code' and lot_no='$lot_no' and 
        // vill_townprt_code='$vill_townprt_code' and mouza_pargona_code='$mouza_pargona_code' 
        // and petition_no='$petition_no'")->row_array();

        // $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from    petition_dag_details where "
        //         . "dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' "
        //         . "and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' "
        //         . "and petition_no='$petition_basic->petition_no'")->row_array();









        if (!empty($lm_details)) {
            $land = $lm_details->land_class_code;
            $land_type = $this->db->query("Select * from landclass_code where class_code = ?", [$land])->row();

            $prim_per_bigha = $lm_details->prim_per_bigha;
            $prim_per_bigha = round($prim_per_bigha, 2);

            $prim_tot = $lm_details->prim_tot;
            $prim_tot = round($prim_tot, 2);

            $data['lm_details'] = array(
                //'petition_no' => $lm_details[''],
                'dag_no' => $lm_details->dag_no,
                'note_no' => $lm_details->note_no,
                'partition_info' => $lm_details->partition_info,
                //'user_code' => $lm_details[''],
                'date_entry' => $lm_details->date_entry,
                //'operation' => $lm_details[''],
                'applicant_patta_yn' => $lm_details->applicant_patta_yn,
                'occupied_yn' => $lm_details->occupied_yn,
                'val_tree_yn' => $lm_details->val_tree_yn,
                'dist_frm_town' => $lm_details->dist_frm_town,
                'inside_outside_town' => $lm_details->inside_outside_town,
                'land_class_code' => $land_type->land_type,
                'issuit_forconv_under105' => $lm_details->issuit_forconv_under105,
                'roadside_rsv_b' => $lm_details->roadside_rsv_b,
                'roadside_rsv_k' => $lm_details->roadside_rsv_k,
                'roadside_rsv_lc' => $lm_details->roadside_rsv_lc,
                'near_river_yn' => $lm_details->near_river_yn,
                'prim_per_bigha' => $prim_per_bigha,
                'conv_b' => $lm_details->conv_b,
                'conv_k' => $lm_details->conv_k,
                'conv_lc' => $lm_details->conv_lc,
                'prim_tot' => $prim_tot,
                'lm_sign_yn' => $lm_details->lm_sign_yn,
                'case_no' => $case_no,
                'lm_code' => $lm_details->lm_code,
                'sk_note_date' => $lm_details->sk_note_date,
                'sk_note' => $lm_details->sk_note,
                'sk_sign_yn' => $lm_details->sk_sign_yn,
                'sk_name' => $lm_details->user_code,
                'jati_janajati_yn' => $lm_details->jati_janajati_yn,
                'jati_janajati_upload' => $lm_details->jati_janajati_upload,
                'freedom_fighter_yn' => $lm_details->freedom_fighter_yn,
                'freedom_fighter_upload' => $lm_details->freedom_fighter_upload,
                'widow_yn' => $lm_details->widow_yn,
                'widow_upload' => $lm_details->widow_upload,
                'premium_assesment' => $lm_details->premium_assesment
            );
        }

        $namelm = $this->db->query("select * from lm_code where lm_code=? and dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=?", [$lm_details->lm_code, $petitionBasic->dist_code, $petitionBasic->subdiv_code, $petitionBasic->cir_code, $petitionBasic->mouza_pargona_code, $petitionBasic->lot_no])->row();
        $data['lm_name'] = $namelm->lm_name;

        $skname = $this->db->query("select * from users where user_code=? and dist_code=? and subdiv_code=? and cir_code=?", [$lm_details->user_code, $lm_details->dist_code, $lm_details->subdiv_code, $lm_details->cir_code])->row();
        $data['sk_skname'] = $skname->username;

        $query = "select * from petition_proceeding where case_no=?";
        $data['cases'] = $this->db->query($query, [$case_no])->result();

        $dc_adc_order = "select * from petition_proceeding_dc_adc where case_no=? order by proceeding_id";
        $data['dc_adc_order'] = $this->db->query($dc_adc_order, [$case_no])->result();


        $data['premium'] = $this->db->query("Select * from petition_lm_note where dist_code='$petitionBasic->dist_code' and subdiv_code='$petitionBasic->subdiv_code' and "
            . "cir_code='$petitionBasic->cir_code' and lot_no='$petitionBasic->lot_no' and vill_townprt_code='$petitionBasic->vill_townprt_code' and "
            . "mouza_pargona_code='$petitionBasic->mouza_pargona_code' and petition_no='$petitionBasic->petition_no' and "
            . "co_reject is NULL ORDER BY note_no DESC LIMIT 1")->result();

        $data['basundharaAttachment']=$this->MbOfficeConversionModel->searchBasundharaLink($case_no);
        if(!$data['basundharaAttachment']) {
            $data['supportiveDocs'] = $this->SupportiveDocumentModel->getDocs($case_no);
        }

        $query44 = "select * from petition_proceeding where case_no=? order by proceeding_id desc limit 1";
        $data['last_proceeding_note'] = $this->db->query($query44, [$case_no])->row();
        
        // echo '<pre>';
        // var_dump($data);
        // die();

        $data['_view'] = 'dc_adc_office_conversion/departmentRevertedMb';
        $this->load->view('layouts/main',$data);


    }
    //
    //added by Hridayjit---13/05/2024
    public function DepartmentRevertToCo() {
        //form validation
        $formValidation = $this->FormValidationModel->formValidationForPost($_POST, [
            'case_no'=>'Case No.|required|case_no',
        ]);
        if($formValidation['status'] == 'n') {
            //ERRCONVDEPTRVRT001
            log_message('error', 'Message: '. $formValidation['message'] .', Data: '. json_encode($formValidation['data']) .'. Error: ERRCONVDEPTRVRT001');
            $this->session->set_flashdata('message', $formValidation['message'] .' Error: ERRCONVDEPTRVRT001');
            redirect(base_url('index.php/home'));
        }

        //syntax validation
        $requestResponse = checkRequestSpecChar($_POST);
        if($requestResponse['status'] == 'n') {
            //ERRCONVDEPTRVRT002
            log_message('error', $requestResponse['messages'] . '. Error: ERRCONVDEPTRVRT002');
            $this->session->set_flashdata('message', 'Contains Illegal parameter values. Error: ERRCONVDEPTRVRT002');
            redirect(base_url('index.php/home'));
        }

        //malicious query validation
        $validResponse = checkRequestValidQuery($_POST);
        if($validResponse['status'] == 'n') {
            //ERRCONVDEPTRVRT003
            log_message('error', $validResponse['messages'] . '. Error: ERRCONVDEPTRVRT003');
            $this->session->set_flashdata('message', 'Contains Malicious parameter values. Error: ERRCONVDEPTRVRT003');
            redirect(base_url('index.php/home'));
        }

        //authorization need to enable later
        // $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'DC', $_POST['case_no'], CONV_DC_DEPT_REVERT);
        // if($authorization['status'] == 'n') {
        //     //ERRCONVDEPTRVRT004
        //     log_message('error', $authorization['messages'] . '. Error: ERRCONVDEPTRVRT004');
        //     $this->session->set_flashdata('message', $authorization['messages'].'. Error: ERRCONVDEPTRVRT004');
        //     redirect(base_url('index.php/home'));
        // }

        $user_code = $this->session->userdata('user_code');
        $case_no = $this->input->post('case_no');

        $this->form_validation->set_rules('reason', 'Reason for Reverting', 'required');

        if ($this->form_validation->run() == FALSE) {
            // Validation failed, reload the form
            $this->load->view('dc_adc_office_conversion/departmentRevertedMb');
        } else {
            $reason = $this->input->post('reason');
        }

        $this->db->trans_begin();

        // $petitionBasic = $this->PetitionBasicModel->get(['case_no'=>$case_no, 'status'=>'R', 'add_off_desig'=>'DC', 'co_user_code'=>$user_code], ['bo_note_yn is not null'], ['user_code'=>'DPT']);
        $petition_basic = $this->db->query("select * from petition_basic where case_no='$case_no' and status='R' and add_off_desig='DC' and co_user_code='$user_code' and user_code like '%DPT%'")->row();
        //var_dump($this->db->last_query()); die;
        $data['petition_basic']= $petitionBasic =$petition_basic;

        $co_name = '';
        $co_desig_code = '';
        $co_user_code = '';

        $coLoginUsers = $this->LoginUserTableModel->get(['dist_code'=>$petitionBasic->dist_code, 'subdiv_code'=>$petitionBasic->subdiv_code, 'cir_code'=>$petitionBasic->cir_code, 'dis_enb_option'=>'E'], 'user_code', 'multiple', ['date_of_creation'=>'DESC']);

        foreach ($coLoginUsers as $coLogin) {
            $coUser = $this->UsersModel->get(['dist_code'=>$petitionBasic->dist_code, 'subdiv_code'=>$petitionBasic->subdiv_code, 'cir_code'=>$petitionBasic->cir_code, 'user_desig_code'=>'CO', 'user_code'=>$coLogin->user_code]);

            if(!empty($coUser)) {
                $co_name = $coUser->username;
                $co_desig_code = $coUser->user_desig_code;
                $co_user_code = $coLogin->user_code;
                break;
            }
        }

        $data = [
            'add_off_desig'=>$co_desig_code,
            'add_off_name'=>$co_name,
            'co_user_code'=>$co_user_code,
            'status'      =>'R',
            'new_status'  =>'DCCOR'
        ];

        $conditions = [
            'case_no'=>$case_no,
            'dist_code'=>$petitionBasic->dist_code,
            'subdiv_code'=>$petitionBasic->subdiv_code,
            'cir_code'=>$petitionBasic->cir_code,
            'mouza_pargona_code'=>$petitionBasic->mouza_pargona_code,
            'lot_no'=>$petitionBasic->lot_no,
            'vill_townprt_code'=>$petitionBasic->vill_townprt_code
        ];

        //$update = $this->PetitionBasicModel->update($conditions, $data);
        $this->db->where('case_no', $case_no);
        $update=$this->db->update('petition_basic', $data);
        //var_dump($this->db->last_query()); die;

        if($update == 0) {
            $this->db->trans_rollback();
            //ERRCONVDEPTRVRT005
            log_message('error', 'Petition Basic Updation Failed for case no. '.$case_no.'. Error: ERRCONVDEPTRVRT005');
            $this->session->set_flashdata('message', 'Petition Basic Updation Failed for case no.'.$case_no.'. Error: ERRCONVDEPTRVRT005');
            redirect(base_url('index.php/home'));
        }

        $proceeding = $this->PetitionProceedingModel->get(['case_no'=>$case_no], 'proceeding_id', 'single', ['proceeding_id'=>'DESC']);
        $proceedingDcAdc = $this->PetitionProceedingDcAdcModel->getProceedingDcAdc($case_no);

        // $conditions = [
        //     'proceeding_id'=>($proceeding->proceeding_id+1),
        //     'case_no'=>$case_no,
        //     'dist_code'=>$petitionBasic->dist_code,
        //     'subdiv_code'=>$petitionBasic->subdiv_code,
        //     'cir_code'=>$petitionBasic->cir_code
        // ];
        $dataProceeding = [
            'proceeding_id'=>($proceeding->proceeding_id+1),
            'case_no'=>$case_no,
            'date_of_hearing'=>date('Y-m-d H:i:s'),
            'dist_code'=>$petitionBasic->dist_code,
            'subdiv_code'=>$petitionBasic->subdiv_code,
            'cir_code'=>$petitionBasic->cir_code,
            'co_order'=>'Case Reverted from DC',
            'note_on_order'=>$reason,
            'user_code'=>$user_code,
            'status'=>'Pending',
            'operation' => 'E',
            'date_entry' => date('Y-m-d H:i:s'),
        ];

        $insert = $this->PetitionProceedingModel->insert($dataProceeding);
        if($insert == 0) {
            $this->db->trans_rollback();
            //ERRCONVDEPTRVRT006
            log_message('error', 'Petition Proceeding Insertion Failed for case no. '.$case_no.'. Error: ERRCONVDEPTRVRT006');
            $this->session->set_flashdata('message', 'Petition Proceeding Insertion Failed for case no.'.$case_no.'. Error: ERRCONVDEPTRVRT006');
            redirect(base_url('index.php/home'));
        }

        if ($this->db->trans_status() == false) {
            $this->db->trans_rollback();
            //ERRCONVDEPTRVRT007
            log_message('error', 'Error in post query. Error: ERRCONVDEPTRVRT007');
            $this->session->set_flashdata('message', 'Error in Post Query. Error: ERRCONVDEPTRVRT007');
            redirect(base_url('index.php/home'));
        }

        $this->db->trans_commit();
        $this->session->set_flashdata('message', "Case no # $case_no has been Reverted back to Circle Officer");
        redirect(base_url() . "index.php/home");

    }
    //
    public function forwardToDc() {
        $case_no = $this->input->post("case_no");
        if($case_no != "KAM/UTT/2022-23/23309/CONV") {
            echo json_encode([
                'status'=>'failed',
                'responseType'=> 1,
                'msg'=>'Changing the status of this case is not permitted!'
            ]);
            exit();
        }
        $dist_code = $this->session->userdata('dist_code');
        $this->dbswitch();
        $this->db->trans_begin();
        $dcInfo = $this->db->query("SELECT lut.user_code, lut.use_name FROM loginuser_table lut, users u WHERE lut.dist_code=u.dist_code AND lut.subdiv_code=u.subdiv_code AND lut.cir_code=u.cir_code AND lut.user_code=u.user_code AND u.user_desig_code='DC' AND lut.dist_code=? AND lut.subdiv_code=? AND lut.cir_code=?AND lut.mouza_pargona_code=? AND lut.lot_no=? AND lut.dis_enb_option='E' ORDER BY lut.date_of_creation DESC LIMIT 1", [$dist_code, '00', '00', '00', '00'])->row();
        $this->db->query("UPDATE petition_basic SET add_off_name=?, add_off_desig=?, proceeding_yn=?, co_user_code=?, co_order_conv_premium=?, co_order_conv_date=? WHERE case_no=?", [$dcInfo->use_name, 'DC', '1', $dcInfo->user_code, null, null, $case_no]);
        if($this->db->affected_rows() > 0) {
            $getCaseLocation = $this->db->query("SELECT * FROM petition_basic WHERE case_no=?", [$case_no])->row();
            $proceeding_query = $this->db->query("SELECT proceeding_id FROM petition_proceeding_dc_adc WHERE case_no=? AND dist_code=? AND subdiv_code=? AND cir_code=? ORDER BY proceeding_id DESC LIMIT 1", [$case_no, $dist_code, $getCaseLocation->subdiv_code, $getCaseLocation->cir_code])->row();
            if(empty($proceeding_query)) {
                $proceeding_id = 1;
            }
            else{
                $proceeding_id = $proceeding_query->proceeding_id + 1;
            }
            $insertArr = [
                'case_no'=>$case_no,
                'proceeding_id'=>$proceeding_id,
                'date_of_hearing'=>$getCaseLocation->next_date_of_hearing,
                'status'=>'pending',
                'user_code'=>$this->session->userdata('user_code'),
                'date_entry'=>date('Y-m-d H:i:s'),
                'operation'=>'E',
                'dist_code'=>$dist_code,
                'subdiv_code'=>$getCaseLocation->subdiv_code,
                'cir_code'=>$getCaseLocation->cir_code,
                'co_order'=>'',
                'note_on_order'=>'This Case No: ' . $case_no . ' is forwarded to DC'
            ];
            $this->db->insert('petition_proceeding_dc_adc', $insertArr);
            $this->db->trans_commit();
            echo json_encode([
                'status'=>'success',
                'responseType'=> 0,
                'msg'=>'Case Successfully Updated!'
            ]);
            exit();
        }
        else{
            $this->db->trans_rollback();
            echo json_encode([
                'status'=>'failed',
                'responseType'=> 1,
                'msg'=>'Failed to update'
            ]);
            exit();
        }
    }






    // Pull back case list view
    public function pullBackCasesFromDepartmentForDCApToPp()
    {
        $dist_code         = $this->session->userdata('dist_code');
        $data['dist_code'] = $dist_code;
        $getDistrict       = $this->SettlementMeetingDcInsModel->getLocationName($dist_code);
        $location          = $getDistrict->result();

        $circleList = array();
        foreach ($location as $key => $circle) {
            $circleList[$key]['cir_name'] = $this->utilityclass->getCircleName($dist_code, $circle->subdiv_code,$circle->cir_code);
            $circleList[$key]['subdiv_code'] = $circle->subdiv_code;
            $circleList[$key]['cir_code'] = $circle->cir_code;
        }
        $data['location'] = $circleList;

        $data['_view'] = 'SettlementView/Dc/pull_back_cases_from_dept_ap_to_pp';
        $this->load->view('layouts/main', $data);
    }


    // Ajax for pull back case list
    public function pullBackCasesWithDeptPaginationAPIApToPp()
    {

        $service       = SERVICE_CONVERSION_MB3;
        $by_case_no    = trim($this->input->post('case_no'));
        $dist_code     = trim($this->session->userdata('dist_code'));
        $subDiv_code   = trim($this->input->post('subdiv'));
        $cir_code      = trim($this->input->post('circle'));
        $mouza_code    = trim($this->input->post('mouza'));
        $lot_no        = trim($this->input->post('lot'));
        $village       = trim($this->input->post('vill_id'));
        $ru            = trim($this->session->userdata('user_desig_code'));
        $draw          = intval($this->input->post('draw'));
        $start         = intval($this->input->post('start'));
        $length        = intval($this->input->post('length'));
        $order         = $this->input->post('order');

        $col = 0;
        $dir = "";
        if(!empty($order)){
            foreach($order as $o){
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if($dir != "asc" && $dir != 'desc'){
            $dir = 'asc';
        }

        if($order != null){
            $this->db->order_by($order, $dir);
        }
        if(!empty($cir_code)){
            $this->db->where('petition_basic.cir_code', $cir_code);
        }
        if(!empty($village)){
            $this->db->where('petition_basic.vill_townprt_code', $village);
            $this->db->where('petition_basic.subdiv_code', $subDiv_code);
            $this->db->where('petition_basic.mouza_pargona_code', $mouza_code);
            $this->db->where('petition_basic.lot_no', $lot_no);
            $this->db->where('petition_basic.vill_townprt_code', $village);
        }
        if(!empty($by_case_no)){
            $this->db->where('petition_basic.case_no', $by_case_no);
        }


        $this->db->select('*');
        $this->db->from('petition_basic');
        $this->db->where('petition_basic.dist_code', $dist_code);
        $this->db->where('petition_basic.is_mb3', 1);
        $this->db->where('petition_basic.mut_type', '01');
        $this->db->where('petition_basic.status', MB_PENDING);
        $this->db->where('new_status', 'DCDPT');
        $this->db->where('add_off_desig', 'DPT');
        $this->db->like('user_code', 'DPT');
        $this->db->limit($length, $start);
        $query = $this->db->get();

        if($query->num_rows() > 0) {

            $result = $query->result();
            $i=1;

            if(!empty($cir_code)){
                $this->db->where('petition_basic.cir_code', $cir_code);
            }
            if(!empty($village)){
                $this->db->where('petition_basic.vill_townprt_code', $village);
                $this->db->where('petition_basic.subdiv_code', $subDiv_code);
                $this->db->where('petition_basic.mouza_pargona_code', $mouza_code);
                $this->db->where('petition_basic.lot_no', $lot_no);
                $this->db->where('petition_basic.vill_townprt_code', $village);
            }
            if(!empty($by_case_no)){
                $this->db->where('petition_basic.case_no', $by_case_no);
            }

            $this->db->select('*');
            $this->db->from('petition_basic');
            $this->db->where('petition_basic.dist_code', $dist_code);
            $this->db->where('petition_basic.is_mb3', 1);
            $this->db->where('petition_basic.mut_type', '01');
            $this->db->where('petition_basic.status', MB_PENDING);
            $this->db->where('new_status', 'DCDPT');
            $this->db->where('add_off_desig', 'DPT');
            $this->db->like('user_code', 'DPT');
            $query1 = $this->db->get();
            $total_records = $query1->num_rows();

            foreach($result as $rows) {


                $lm_remark = '';
                $json[] = array(
                    '<span class="px-3"><strong>' . $i . '</strong></span>',

                    $this->utilityclass->getCircleName($rows->dist_code,$rows->subdiv_code,$rows->cir_code),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    $lm_remark,

                    $rows->case_no."<br><span style='color:red'>Basundhara:".$rows->applid."</span>",

                    '<a class="btn rezaButt" target="_blank" href="'.base_url().'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case='.$rows->case_no.'">  VIEW
                    </a>
                        
                    <button class="btn rezaButt buttPrimary pullBackCasesModal" data-id='.$rows->case_no.'  style="margin-top: 10px">  PULL BACK
                    </button>'

                );

                $i++;
            }

            $response = array(
                'draw' => $draw,
                'recordsTotal' => $total_records,
                'recordsFiltered' => $total_records,
                'data' => $json,
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


    // get revert back meeting details
    public function getPullBackCaseDetailsApToPp()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('meetingId', 'Case Number', 'trim|required');

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        }
        else
        {
            $dist_code = $this->session->userdata('dist_code');
            $appId     = trim($this->input->post('meetingId'));
            $checkCase = $this->db->select()
                ->where('case_no', $appId)
                ->where('dist_code', $dist_code)
                ->where('mut_type', '01')
                ->where('is_mb3', 1)
                ->where('status', MB_PENDING)
                ->where('new_status', 'DCDPT')
                ->where('add_off_desig', 'DPT')
                ->like('user_code', 'DPT')
                ->get('petition_basic')
                ->num_rows();

            if($checkCase == 1)
            {
                echo json_encode(array(
                    'responseType'       => 2,
                    'meetingId'          => $appId,
                    'caseNumber'         => $appId,
                ));

                return;
            }
            else
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#MR0001992: Case not found ! Kindly contact system administrator',
                ));
                return;
            }
        }
    }


    // final pull back submit & revert back to co
    public function finalPullBackRevertToCoSubmitApToPp()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('meetingId', 'Case Number', 'trim|required');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|min_length[3]|max_length[3000]');

        if ($this->form_validation->run() == FALSE)
        {
            $errors = validation_errors();

            echo json_encode(array(
                'responseType' => 1,
                'message'  => '#ERMR002025: Validation error ! ' .$errors,
            ));
            return;
        }
        else
        {
            $dist_code       = trim($this->session->userdata('dist_code'));
            $appId           = trim($this->input->post('meetingId'));
            $remarks         = trim($this->input->post('remarks'));
            $user_desig_code = trim($this->session->userdata('user_desig_code'));
            $user_code       = trim($this->session->userdata('user_code'));

            $checkCase = $this->db->select()
                ->where('case_no', $appId)
                ->where('dist_code', $dist_code)
                ->where('mut_type', '01')
                ->where('is_mb3', 1)
                ->where('status', MB_PENDING)
                ->where('new_status', 'DCDPT')
                ->where('add_off_desig', 'DPT')
                ->like('user_code', 'DPT')
                ->get('petition_basic')
                ->num_rows();

            if($checkCase == 1)
            {
                $this->db->trans_begin();
                $case_no = $appId;
                $caseDetails = $this->db->select()
                    ->where('case_no', $appId)
                    ->where('dist_code', $dist_code)
                    ->where('mut_type', '01')
                    ->where('is_mb3', 1)
                    ->where('status', MB_PENDING)
                    ->where('new_status', 'DCDPT')
                    ->where('add_off_desig', 'DPT')
                    ->like('user_code', 'DPT')
                    ->get('petition_basic')
                    ->row();

                if($caseDetails->status != MB_PENDING)
                {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'  => '#MRBR0003835: Application ('.$case_no.') already Processed ! Kindly contact system administrator',
                    ));
                    return false;
                }

                $proCheckCase = $this->db->select()
                    ->where('case_no', $appId)
                    ->where('dist_code', $dist_code)
                    ->where('dist_code',$caseDetails->dist_code)
                    ->where('subdiv_code', $caseDetails->subdiv_code)
                    ->where('cir_code',$caseDetails->cir_code)
                    ->like('user_code', 'CO')
                    ->get('petition_proceeding')
                    ->num_rows();

                if($proCheckCase == 0)
                {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'  => '#MRBR00038005: Reverted failed  case no (#'.$case_no.') ! Kindly contact system administrator',
                    ));
                    return false;
                }

                $proDetails = $this->db->select()
                    ->where('case_no', $appId)
                    ->where('dist_code', $dist_code)
                    ->where('dist_code',$caseDetails->dist_code)
                    ->where('subdiv_code', $caseDetails->subdiv_code)
                    ->where('cir_code',$caseDetails->cir_code)
                    ->like('user_code', 'CO')
                    ->get('petition_proceeding')
                    ->row();

                $revertUserCode = trim($proDetails->user_code);


                $this->db->select('u.username, lt.user_code, u.user_desig_code');
                $this->db->from('loginuser_table lt');
                $this->db->join('users u', 'lt.dist_code = u.dist_code AND lt.subdiv_code = u.subdiv_code AND lt.cir_code = u.cir_code AND u.user_code = lt.user_code');
                $this->db->where([
                    'lt.dis_enb_option'   => 'E',
                    'u.user_desig_code'   => 'CO',
                    'lt.dist_code'        => $caseDetails->dist_code,
                    'lt.subdiv_code'      => $caseDetails->subdiv_code,
                    'lt.cir_code'         => $caseDetails->cir_code,
                ]);

                $query = $this->db->get();
                $cos   = $query->result();


                $coName = '';
                foreach ($cos as $co)
                {
                    if($co->user_code == $revertUserCode)
                    {
                        $coName = $co->username;
                    }
                }

                if($coName == '')
                {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'  => '#MRBR00038006: Circle Officer not found ! Kindly contact system administrator',
                    ));
                    return false;
                }


                $updateData = array(
                    'status'            => MB_REVERT,
                    'new_status'        => 'DCCOR',
                    'add_off_desig'     => MB_CIRCLE_OFFICER,
                    'add_off_name'      => $coName,
                    'co_user_code'      => $proDetails->user_code,
                    'dept_js_approve'   => '',
                    'adlr_remark'       => '',
                    'adlr_code'         => '',
                    'adlr_asign_code'   => '',
                    'adlr_verification' => '',

                );
                $this->db->where('case_no', $case_no);
                $this->db->where('dist_code',$caseDetails->dist_code);
                $updateDataStatus = $this->db->update('petition_basic', $updateData);
                if($updateDataStatus != 1)
                {
                    $this->db->trans_rollback();
                    log_message("error", "#smcu001, Error in update, table 'petition_basic' with query :". $this->db->last_query());
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'  => '#MRBR0003918: Reverted failed case no #'. $case_no.' ! Kindly contact system administrator',
                    ));
                    return false;
                }


                //////proceeding start//////
                $proceeding = $this->db->query("select count(proceeding_id) as proceed from petition_proceeding_dc_adc where case_no = '$case_no' limit 1")->result();
                $proceeding_id = $proceeding[0]->proceed + 1;
                $date_entry = date('Y-m-d H:i:s');
                $insPetProceed = [
                    'case_no'         => $case_no,
                    'proceeding_id'   => $proceeding_id,
                    'date_of_hearing' => $date_entry,
                    'co_order'        => $remarks,
                    'note_on_order'   => 'Pull Back & Reverted to CO from Department',
                    'status'          => 'Pending',
                    'user_code'       => $user_code,
                    'date_entry'      => $date_entry,
                    'operation'       => 'E',
                    'dist_code'       => $caseDetails->dist_code,
                    'subdiv_code'     => $caseDetails->subdiv_code,
                    'cir_code'        => $caseDetails->cir_code,
                    'ip'              => $this->utilityclass->get_client_ip()
                ];

                $insertProceeding = $this->db->insert('petition_proceeding_dc_adc', $insPetProceed);
                if($insertProceeding != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MRBR0003952: Insertion failed in petition_proceeding_dc_adc for case no :'. $case_no);
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'  => '#MRBR0003952: Reverted failed case no #'. $case_no.' ! Kindly contact system administrator',

                    ));
                    return false;
                }


                $application_no = $this->BasundharApplicationModel->checkExistBasundhar($case_no);
                $case   = $case_no;
                $rmk    = 'Pull Back & Reverted to CO';
                $status = 'M';
                $task   = $this->session->userdata('user_desig_code');
                $pen    = MB_CIRCLE_OFFICER;
                $rtps_status = $this->basundharamodel->postApiBasundharaSec($application_no,$case,$rmk,$status,$task,$pen);
                if(trim($rtps_status) !="y")
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MRAPI104042: Issue in API Call'
                        .$this->db->last_query());
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'      => '#MRAPI104042: Unable to process for final revert.
                                               Kindly contact system administration !!!',
                    ));
                    return false;
                }


                $this->db->trans_commit();
                echo json_encode(array(
                    'responseType' => 2,
                    'message'  => 'Application has been successfully pulled back and reverted to the CO.',
                ));
                return false;
            }
            else
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#MR0001992: Case not found ! Kindly contact system administrator',
                ));
                return false;
            }
        }
    }



}
