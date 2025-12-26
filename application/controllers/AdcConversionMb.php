<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AdcConversionMb extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // Allowed designations
        $allowed = ['ADC'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }
        
        $this->load->model('mutation/mutationmodel');
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
        $this->load->model('conversion/MbOfficeConversionModel');
        $this->load->model('v2/BasundharApplicationModel');
        $this->load->model('rtps/RtpsModel');
        

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

    public function GoToDC_ADC() {
		//$db=  $this->session->userdata('db');
        $process = $this->input->get('pro');
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');

        if ($process == '1') {
            $config['total_rows'] = $this->MbOfficeConversionModel->countPendingConversionSecondCases_dc($user_code);
            $cases['cases'] = $this->MbOfficeConversionModel->getPendingConversionSecondCases_dc($user_code)->result();
        } elseif ($process == '2') {
            $config['total_rows'] = $this->MbOfficeConversionModel->countPendingConversionSecondCases_adc($user_code);
            $cases['cases'] = $this->MbOfficeConversionModel->getPendingConversionSecondCases_adc($user_code)->result();
        } elseif ($process == '3') {
            $config['total_rows'] = $this->MbOfficeConversionModel->countPendingConversionFirstCases_dc($user_code);
            $cases['cases'] = $this->MbOfficeConversionModel->getPendingConversionFirstCases_dc($user_code)->result();
        } elseif ($process == '4') {
            $config['total_rows'] = $this->MbOfficeConversionModel->countPendingConversionFirstCases_adc($user_code);
            $cases['cases'] = $this->MbOfficeConversionModel->getPendingConversionFirstCases_adc($user_code)->result();
        } elseif ($process == '5') {
            $config['total_rows'] = $this->MbOfficeConversionModel->countPendingConversionSecondCases_adc_dpt($user_code);
            $cases['cases'] = $this->MbOfficeConversionModel->getPendingConversionSecondCases_adc_dpt($user_code)->result();
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
        $cases['_view'] = 'dc_adc_office_conversion/adc_conversion_cases_mb';
        $this->load->view('layouts/main',$cases);
    }

    public function adcPaymentConfirmation() {
      // $db=  $this->session->userdata('db');
         $user_code = $this->session->userdata('user_code');
         $this->load->library('pagination');
         $process = $this->input->get('pro');
 
         if ($process == '2') {
             $config['total_rows'] = $this->ASTofficeConversionModel->countPendingActionTakenBO($user_code);
             $cases['cases'] = $this->ASTofficeConversionModel->getPendingActionTakenBO($user_code)->result();
         } elseif ($process == '3') {
            
             $config['total_rows'] = $this->MbOfficeConversionModel->countPendingPremiumBO($user_code);
             $cases['cases'] = $this->MbOfficeConversionModel->getPendingPremiumBO($user_code)->result();
             //var_dump("mmmmmmmmmmmm:---".$cases['cases']); die;
         } elseif ($process == '4') {
             $config['total_rows'] = $this->MbOfficeConversionModel->countPendingPaymentAdc($user_code);
             $cases['cases'] = $this->MbOfficeConversionModel->getPendingPaymentAdc($user_code)->result();
         }
          elseif ($process == '5') {
             $config['total_rows'] = $this->ASTofficeConversionModel->countPendingReportBO($user_code);
             $cases['cases'] = $this->ASTofficeConversionModel->getPendingReportBO($user_code)->result();
         }
         //echo $config['total_rows'];
         $cases['process'] = $process;
         $cases['_view'] = 'dc_adc_office_conversion/adc_payment_conversion_cases';
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
                'error' => "Error in submitting. Please try Again 1",
            );
        }
        else
        {
            $this->db->trans_commit();

            $this->session->set_flashdata('message', "Case no # $case_no has been forwarded to Deputy Commissioner");
            redirect(base_url() . "index.php/home");
        }
    }
    

    
    public function FirstProceedingMb() {
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
        
        $bo_details = $this->db->query("Select * from    petition_bo_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
                . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and "
                . "mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'")->row_array();

        if (count($bo_details) != '0') {
            $data['bo_details'] = array(
                'dag_no' => $bo_details['dag_no'],
                'case_no' => $bo_details['case_no'],
                'note_no' => $bo_details['note_no'],
                'dist_frm_town' => $bo_details['dist_frm_town'],
                'inside_outside_town' =>  $bo_details['inside_outside_town'],
                'land_scenario' => $bo_details['land_scenario'],
                'prt_transfer' => $bo_details['prt_transfer'],
                'sent_to_govt' => $bo_details['sent_to_govt'],
                'approved' => $bo_details['approved'],
                'reason' => $bo_details['reason'],
                'prim_assesed' => $bo_details['prim_assesed'],
                'road_rvr_rerservation' => $bo_details['road_rvr_rerservation'],
                'reverify' => $bo_details['reverify'],
                'bo_note' => $bo_details['bo_note'],
                'bo_sign_yn' => $bo_details['bo_sign_yn'],
                'bo_code' => $bo_details['bo_code'],
                'bo_sign_date' =>  $bo_details['bo_sign_date'],
            );
            
            $boname = $this->db->query("select * from    users where user_code='" . $bo_details['bo_code'] . "'  and dist_code = '" . $bo_details['dist_code'] . "'")->row();
            $data['bo_boname'] = $boname->username;
        }

        $query = "select * from    petition_proceeding where case_no = '$case_no'";
        $data['cases'] = $this->db->query($query)->result();
        
        $dc_adc_order = "select * from    petition_proceeding_dc_adc where case_no = '$case_no' order by proceeding_id";
        $data['dc_adc_order'] = $dc_order = $this->db->query($dc_adc_order)->result();

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

        $data['branch_officer']=$this->db->query("Select users.username as username, users.user_desig_code as user_desig_code, loginuser_table.user_code as user_code from    users, "
                . "loginuser_table where users.dist_code = loginuser_table.dist_code "
                . "and users.user_code = loginuser_table.user_code and users.user_desig_code = 'BO' and users.dist_code='$petition_basic->dist_code' and "
                . "users.subdiv_code='00' and users.cir_code='00' and loginuser_table.dis_enb_option = 'E'")->result();

        $data['approval_authority'] = $this->MbOfficeConversionModel->approvalAuthority($lm_details['conversion_premium_rates_id']);
        $data['basundharaAttachment']=$this->MbOfficeConversionModel->searchBasundharaLink($case_no);
        if(!$data['basundharaAttachment']) {
            $data['supportiveDocs'] = $this->SupportiveDocumentModel->getDocs($case_no);
        }

        $data['conversion_premium_area'] = $this->db->query("SELECT * FROM conversion_premium_areas WHERE id=?", [$lm_details['conversion_premium_areas_id']])->row();
        $data['conversion_premium_rate'] = $this->db->query("SELECT * FROM conversion_premium_rates WHERE id=?", [$lm_details['conversion_premium_rates_id']])->row();

        // echo '<pre>';
        // var_dump($data['lm_details_final']);
        // die();

        $user_desig_code = $this->session->userdata('user_desig_code');

        $data['post_url'] = 'index.php/AdcConversionMb/RegenerateADC';

        
        // $data['_view'] = 'dc_adc_office_conversion/first_proceeding_mb';
        $data['_view'] = 'dc_adc_office_conversion/first_proceeding_adc';
        $this->load->view('layouts/main',$data);
    }

    public function RegenerateADC() {
        //form validation
        $formValidation = $this->FormValidationModel->formValidationForPost($_POST, [
            'case_no'=>'Case No.|required|case_no',
            'dc_adc_notice'=>'DC/ADC Notice|required',
            //'hearing_date'=>'Hearing Date|required|date',
            'order_type'=>'Order Type|required',
            'prepare_premium'=>'Prepare Premium|char',
            're_co_note'=>'Revert CO Note|char',
            'frwd_dept'=>'Forward To Department|char'
        ]);
        if($formValidation['status'] == 'n') {
            if($_POST['order_type'] == 'continuehearing') {
                //ERRCONVADCSECOND0001
                log_message('error', 'Message: '. $formValidation['message'] .', Data: '. json_encode($formValidation['data']) .'. Error: ERRCONVADCSECOND0001');
                $this->session->set_flashdata('message', $formValidation['message'] .' Error: ERRCONVADCSECOND0001');
                redirect(base_url('index.php/dc_adc_conversion/GoToDC_ADC?pro=2'));
            }
            else if($_POST['order_type'] == 'finalhukum') {
                //ERRCONVADCFINALORDER0001
                log_message('error', 'Message: '. $formValidation['message'] .', Data: '. json_encode($formValidation['data']) .'. Error: ERRCONVADCFINALORDER0001');
                $this->session->set_flashdata('message', $formValidation['message'] .' Error: ERRCONVADCFINALORDER0001');
                redirect(base_url('index.php/dc_adc_conversion/GoToDC_ADC?pro=2'));
            }
            else {
                //ERRCONVADCSECOND0001
                log_message('error', 'Message: '. $formValidation['message'] .', Data: '. json_encode($formValidation['data']) .'. Error: ERRCONVADCSECOND0001');
                $this->session->set_flashdata('message', $formValidation['message'] .' Error: ERRCONVADCSECOND0001');
                redirect(base_url('index.php/dc_adc_conversion/GoToDC_ADC?pro=2'));
            }
        }

        //syntax validation
        $requestResponse = checkRequestSpecChar($_POST, ['dc_adc_notice'=>['%']], [], ['dc_adc_notice'=>true]);
        if($requestResponse['status'] == 'n') {
            if($_POST['order_type'] == 'continuehearing') {
                //ERRCONVADCSECOND0002
                log_message('error', $requestResponse['messages'] . '. Error: ERRCONVADCSECOND0002');
                $this->session->set_flashdata('message', 'Contains Illegal parameter values. Error: ERRCONVADCSECOND0002');
                redirect(base_url('index.php/dc_adc_conversion/GoToDC_ADC?pro=2'));
            }
            else if($_POST['order_type'] == 'finalhukum') {
                //ERRCONVADCFINALORDER0002
                log_message('error', $requestResponse['messages'] . '. Error: ERRCONVADCFINALORDER0002');
                $this->session->set_flashdata('message', 'Contains Illegal parameter values. Error: ERRCONVADCFINALORDER0002');
                redirect(base_url('index.php/dc_adc_conversion/GoToDC_ADC?pro=2'));
            }
            else{

            }
        }

        //malicious query validation
        $validResponse = checkRequestValidQuery($_POST, [], ['dc_adc_notice'=>true]);
        if($validResponse['status'] == 'n') {
            if($_POST['order_type'] == 'continuehearing') {
                //ERRCONVADCSECOND0003
                log_message('error', $validResponse['messages'] . '. Error: ERRCONVADCSECOND0003');
                $this->session->set_flashdata('message', 'Contains Malicious parameter values. Error: ERRCONVADCSECOND0003');
                redirect(base_url('index.php/dc_adc_conversion/GoToDC_ADC?pro=2'));
            }
            else if($_POST['order_type'] == 'finalhukum') {
                //ERRCONVADCFINALORDER0003
                log_message('error', $validResponse['messages'] . '. Error: ERRCONVADCFINALORDER0003');
                $this->session->set_flashdata('message', 'Contains Malicious parameter values. Error: ERRCONVADCFINALORDER0003');
                redirect(base_url('index.php/dc_adc_conversion/GoToDC_ADC?pro=2'));
            }
            else{

            }
        }

        //authorization
        if($_POST['order_type'] == 'continuehearing') {
            $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'ADC', $_POST['case_no'], CONV_ADC_FIRST);
            if($authorization['status'] == 'n') {
                //ERRCONVADCSECOND0004
                log_message('error', $authorization['messages'] . '. Error: ERRCONVADCSECOND0004');
                $this->session->set_flashdata('message', $authorization['messages'].'. Error: ERRCONVADCSECOND0004');
                redirect(base_url('index.php/home'));
            }
        }
        else if($_POST['order_type'] == 'finalhukum') {
            $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'ADC', $_POST['case_no'], CONV_ADC_FINALORD);
            if($authorization['status'] == 'n') {
                //ERRCONVADCFINALORDER0004
                log_message('error', $authorization['messages'] . '. Error: ERRCONVADCFINALORDER0004');
                $this->session->set_flashdata('message', $authorization['messages'].'. Error: ERRCONVADCFINALORDER0004');
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
        $hearing_date = date('Y-m-d', strtotime($this->input->post('hearing_date')));
        $dc_adc_order = $this->input->post('dc_adc_notice');
        $prepare_premium = $this->input->post('prepare_premium');
        $re_co_note = $this->input->post('re_co_note');
        $order_type = $this->input->post('order_type');
        $bo_code = $this->input->post('bo_code');
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
        $date_entry = date('Y-m-d G:i:s');
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
               $user_code = $select->user_c;
            }
        }
        if ($re_co_note == 'Y') {
          // var_dump("helllllooooooo i am in revert"); die;
            // if re_co_note is Y that means its a village land and lm has wrongly entered report
            $this->db->trans_begin();
            
            $this->db->query("UPDATE Petition_Basic SET add_off_desig = '$user_desig_code', add_off_name = '$co_name', co_user_code = '$user_code', status = 'R' WHERE "
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
           

            // $proceeding = $this->db->query("select count(proceeding_id) as proceed from    petition_proceeding where case_no = '$case_no' order by proceed desc limit 1")->result();
            // $proceeding_id = $proceeding[0]->proceed;
            $proceeding_id = $this->db->query("SELECT max(proceeding_id) FROM petition_proceeding WHERE case_no=?", [$case_no])->row()->max;

            $proceeding_details = $this->db->query("SELECT * FROM petition_proceeding WHERE case_no=? AND proceeding_id=?", [$case_no, $proceeding_id])->row();

            $co_order = $proceeding_details->co_order;
            $date_of_hearing = $proceeding_details->next_date_of_hearing;
            $note_on_order = $dc_adc_order;


            $pp_data = [
                'case_no' => $case_no,
                'proceeding_id' => $proceeding_id + 1,
                'date_of_hearing' => $date_of_hearing,
                'co_order' => $co_order,
                'note_on_order' => $note_on_order,
                'next_date_of_hearing' => $date_of_hearing,
                'status' => 'Reject',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d H:i:s'),
                'operation' => 'E',
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $location['mouza_pargona_code'],
                'lot_no' => $location['lot_no'],
                'ip' => $this->utilityclass->get_client_ip()
            ];

            $ppInsertStatus = $this->db->insert('petition_proceeding', $pp_data);
            if(!$ppInsertStatus || $this->db->affected_rows() < 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRCONVDC0008: Insertion failed in petition proceeding for case no ' . $case_no);
                $data = array(
                    'error' => "#ERRCONVDC0008: Registration failed of Petition basic for case no : " . $case_no,
                );
                echo json_encode($data);
                return false;
            }


			
            // $note_on_order = '<span class="red">Reverted by ADC, Recheck the application. </span>';
            
			
            // $update1 = "UPDATE petition_proceeding set note_on_order = '$note_on_order', user_code = '$user_code', status = 'Reject' WHERE proceeding_id = '$proceeding_id' and case_no = '$case_no' "
            //     . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
            // $this->db->query($update1);

            // if ($this->db->affected_rows() == 0) {
            //     $this->db->trans_rollback();
            //     log_message('error', '#ERRCONVDC0008: Updation failed in petition_basic Case No ' . $case_no);
            //     $data = array(
            //         'error' => "#ERRCONVDC0008: Registration of Petition basic for case no : " . $case_no,
            //     );
            //     echo json_encode($data);
            //     return false;
            // }
			
            $status = 'Reject';

            if ($this->db->trans_status() == false) {
                $this->db->trans_rollback();
                $data = array(
                    'error' => "Error in submitting. Please try Again 2",
                );
                echo json_encode($data);
                return false;
            }
            else
            {
                
                $penUser='CO';
                $rmrk='Reverted back to Circle Officer';
                $this->DashboardData($case_no,$penUser,$rmrk);
                $status='M';
                $task='ADC';
                $pen='CO';
                $rtps_status = $this->basundharamodel->postApiBasundharaSec($case_no,$rmrk,$status,$task,$pen);
                
                if(trim($rtps_status) !="y") {  //(trim($rtps_status) =="n") this check is dangerous
                    //ERRCONVCOFIRST0012
                    $this->db->trans_rollback();
                    log_message('error', 'Error in revrt back the Application for case no: '. $case_no .'. Error: ERRCONVREV0012');
                    echo json_encode([
                        'status'=>'FAILED',
                        'responseType'=>1,
                        'msg'=>'Error in Submitting Settlement Application for case no: '. $case_no .'. Error: ERRCONVREV0012'
                    ]);
                    exit();
                }
                $this->db->trans_commit();
                $this->session->set_flashdata('message', "Case no # $case_no has been Reverted back to Circle Officer");
                redirect(base_url() . "index.php/home");
            }
        }
        if ($order_type == 'continuehearing') 
        {
          
            // $formValid = $this->FormValidationModel->formValidationForPost($_POST, [
            //     'prepare_premium'=>'Prepare Premium|required_as_option(frwd_dept)|char',
            //     'frwd_dept'=>'Forward To Department|required_as_option(prepare_premium)|char'
            // ]);
            // if($formValid['status'] == 'n') {
            //     //ERRCONVADCSECOND0005
            //     $this->db->trans_rollback();
            //     log_message('error', 'Message: '. $formValid['message'] .', Data: '. json_encode($formValid['data']) .'. Error: ERRCONVADCSECOND0005');
            //     $this->session->set_flashdata('message', $formValid['message'] .' Error: ERRCONVADCSECOND0005');
            //     redirect(base_url('index.php/dc_adc_conversion/GoToDC_ADC?pro=2'));
            // }

            
            //////dc forward

            // $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'ADC', $case_no);
            // if($authorization['status'] == 'n') {
            //     //ERRCONVADCSECONDTODC001
            //     log_message('error', $authorization['messages'] . '. Error: ERRCONVADCSECONDTODC001');
            //     $this->session->set_flashdata('message', $authorization['messages'].'. Error: ERRCONVADCSECONDTODC001');
            //     redirect(base_url('index.php/home'));
            // }
            // echo '<pre>';
            // var_dump($authorization);
            // die();

            $dc_name = $this->db->query("Select users.username, loginuser_table.user_code, users.user_desig_code from    users, loginuser_table where users.dist_code = loginuser_table.dist_code "
                        . "and users.user_code = loginuser_table.user_code and users.user_desig_code = 'DC' and users.dist_code='$dist_code' and "
                        . "users.subdiv_code='00' and users.cir_code='00' and loginuser_table.dis_enb_option = 'E' and loginuser_table.priv = 'adm'")->row();
            
            $this->db->trans_begin();
            $this->db->query("UPDATE Petition_Basic SET add_off_desig = '$dc_name->user_desig_code', add_off_name = '$dc_name->username', status='P', co_user_code = '$dc_name->user_code',new_status='ADDC1' WHERE case_no = '$case_no' and "
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


            $proceeding_dc_adc = $this->db->query("select count(proceeding_id) as proceed from    petition_proceeding_dc_adc where case_no = '$case_no' limit 1")->result();
            $proceeding_id_dc_adc = $proceeding_dc_adc[0]->proceed + 1;
            $proceeding_data_end_dc_adc = array(
                'case_no' => $case_no,
                'proceeding_id' => $proceeding_id_dc_adc,
                'date_of_hearing' => date('Y-m-d h:i:s'),
                'co_order' => $dc_adc_order,
                'note_on_order' => 'Case forwarded to DC',
                //'next_date_of_hearing' => $hearing_date,
                'status' => 'disposed',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => $date_entry,
                'operation' => 'E',
                'dist_code' => $location['dist_code'],
                'subdiv_code' => $location['subdiv_code'],
                'cir_code' => $location['cir_code']
            );
           

            $insert_ppd39 =  $this->db->insert('petition_proceeding_dc_adc', $proceeding_data_end_dc_adc);
            // var_dump("helllllooooooo:-> ".$insert_ppd39); die;
            if($insert_ppd39 != 1){
                $this->db->trans_rollback();
                log_message('error', '#ERRCONVDC00187: Insertion failed in petition_proceeding_dc_adc for case no :'. $case_no);
                $json = [
                    'message'=>"#ERRCONVDC00187: Failed to in Proceeding for Case No : ".$case_no
                ];
                echo json_encode($json);
                return false;
            }

            if ($this->db->trans_status() == false) {
                $this->db->trans_rollback();
                $data = array(
                    'error' => "Error in submitting. Please try Again 3",
                );
            }
            else
            {

                $penUser='DC';
                $rmrk='Case has been forwarded to DC';
                $this->DashboardData($case_no,$penUser,$rmrk);
                $status='M';
                $task='ADC';
                $pen='DC';
                $rtps_status = $this->basundharamodel->postApiBasundharaSec($case_no,$rmrk,$status,$task,$pen);
                
                if(trim($rtps_status) !="y") {  //(trim($rtps_status) =="n") this check is dangerous
                    //ERRCONVCOFIRST0012
                    $this->db->trans_rollback();
                    log_message('error', 'Error in revrt back the Application for case no: '. $case_no .'. Error: ERRCONVREV0012');
                    echo json_encode([
                        'status'=>'FAILED',
                        'responseType'=>1,
                        'msg'=>'Error in Submitting Settlement Application for case no: '. $case_no .'. Error: ERRCONVREV0012'
                    ]);
                    exit();
                }

                $this->db->trans_commit();

                $this->session->set_flashdata('message', "Case no # $case_no has been forwarded to Deputy Commissioner");
                redirect(base_url() . "index.php/home");
            }


            //////dc forwrd end
          

        
        }
        else 
        {
            var_dump("ERR09223: Something Went Wrong"); die;
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
                    'error' => "Error in submitting. Please try Again 4",
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
               
               $bo_details = $this->db->query("Select * from    petition_bo_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
                       . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and "
                       . "mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'")->row_array();
       
               if (count($bo_details) != '0') {
                   $data['bo_details'] = array(
                       'dag_no' => $bo_details['dag_no'],
                       'case_no' => $bo_details['case_no'],
                       'note_no' => $bo_details['note_no'],
                       'dist_frm_town' => $bo_details['dist_frm_town'],
                       'inside_outside_town' =>  $bo_details['inside_outside_town'],
                       'land_scenario' => $bo_details['land_scenario'],
                       'prt_transfer' => $bo_details['prt_transfer'],
                       'sent_to_govt' => $bo_details['sent_to_govt'],
                       'approved' => $bo_details['approved'],
                       'reason' => $bo_details['reason'],
                       'prim_assesed' => $bo_details['prim_assesed'],
                       'road_rvr_rerservation' => $bo_details['road_rvr_rerservation'],
                       'reverify' => $bo_details['reverify'],
                       'bo_note' => $bo_details['bo_note'],
                       'bo_sign_yn' => $bo_details['bo_sign_yn'],
                       'bo_code' => $bo_details['bo_code'],
                       'bo_sign_date' =>  $bo_details['bo_sign_date'],
                   );
                   
                   $boname = $this->db->query("select * from    users where user_code='" . $bo_details['bo_code'] . "'  and dist_code = '" . $bo_details['dist_code'] . "'")->row();
                   $data['bo_boname'] = $boname->username;
               }
       
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
               $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
               $data['_view'] = 'dc_adc_office_conversion/Department_Proceeding';
               $this->load->view('layouts/main',$data);
       
       
    }

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

    public function notice_premium() {
      $db=  $this->session->userdata('db');
      $dist_code1 = $this->session->userdata('dist_code');
      $subdiv_code1 = $this->input->get('subdiv_code');
      $cir_code1 = $this->input->get('cir_code');
      $mouza_pargona_code1 = $this->input->get('mouza_pargona_code');
      $lot_no1 = $this->input->get('lot_no');
      $vill_townprt_code1 = $this->input->get('vill_townprt_code');
      $this->session->set_userdata(array('subdiv_code' => $subdiv_code1));
      $this->session->set_userdata(array('cir_code' => $cir_code1));
      $this->session->set_userdata(array('mouza_pargona_code' => $mouza_pargona_code1));
      $this->session->set_userdata(array('lot_no' => $lot_no1));
      $this->session->set_userdata(array('vill_townprt_code' => $vill_townprt_code1));
      $data = array();
      $case_no = $this->input->get('case_no');
      $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' "
              . "and dist_code='$dist_code1' and subdiv_code='$subdiv_code1' and cir_code='$cir_code1' and mouza_pargona_code = '$mouza_pargona_code1' and "
              . "lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1'")->row();
      
      $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,date_entry,add_off_desig,add_off_name,next_date_of_hearing,sk_comment"
                      . " from    petition_basic where case_no='$case_no' "
              . "and dist_code='$dist_code1' and subdiv_code='$subdiv_code1' and cir_code='$cir_code1' and mouza_pargona_code = '$mouza_pargona_code1' and "
              . "lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1'")->row_array();

              
      $designation = $this->db->query("select user_desig_as as user_designation from    master_user_designation where user_desig_code='".$location['add_off_desig']."'")->row()->user_designation;
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
          'date' => $location['date_entry'],
          'add_to' => $location['add_off_name'],
          'next_date' => $location['next_date_of_hearing'],
          'sk_comment' => $location['sk_comment'],
          'add_off_designation' => $designation,
      );
      $convertion_code = CONVERSION_CODE;
      $data['conv_type'] = $this->db->query("select order_type from    master_office_mut_type "
                      . " where order_type_code='$convertion_code'")->row()->order_type;

      $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from    petition_dag_details where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'")->row_array();

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

      $pattadardetails = "select pdar_name,pdar_guardian,pdar_rel_guar,pdar_add1,pdar_add2, inplace_alongwith from    petitioner_part where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and dag_no='$landdetails[dag_no]' and TRIM(patta_no)='" . trim($landdetails['patta_no']) . "' and patta_type_code= '$landdetails[patta_type_code]'";
      $data['pattadar'] = $petitioner_parts = $this->db->query($pattadardetails)->result();
      $lm_details = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and co_reject is NULL order by note_no desc limit 1")->row_array();

    //   if (count($lm_details) != '0') {
    //         $land = $lm_details['land_class_code'];
    //         $land_type = $this->db->query("Select * from    landclass_code where class_code = '$land'")->row();

    //         $prim_per_bigha = $lm_details['prim_per_bigha'];
    //         $prim_per_bigha = round($prim_per_bigha, 2);

    //         $prim_tot = $lm_details['prim_tot'];
    //         $prim_tot = round($prim_tot, 2);

    //         $data['lm_details'] = array(
    //             //'petition_no' => $lm_details[''],
    //             'dag_no' => $lm_details['dag_no'],
    //             'note_no' => $lm_details['note_no'],
    //             'partition_info' => $lm_details['partition_info'],
    //             //'user_code' => $lm_details[''],
    //             'date_entry' => $lm_details['date_entry'],
    //             //'operation' => $lm_details[''],
    //             'applicant_patta_yn' => $lm_details['applicant_patta_yn'],
    //             'occupied_yn' => $lm_details['occupied_yn'],
    //             'val_tree_yn' => $lm_details['val_tree_yn'],
    //             'dist_frm_town' => $lm_details['dist_frm_town'],
    //             'inside_outside_town' => $lm_details['inside_outside_town'],
    //             'land_class_code' => $land_type->land_type,
    //             'issuit_forconv_under105' => $lm_details['issuit_forconv_under105'],
    //             'roadside_rsv_b' => $lm_details['roadside_rsv_b'],
    //             'roadside_rsv_k' => $lm_details['roadside_rsv_k'],
    //             'roadside_rsv_lc' => $lm_details['roadside_rsv_lc'],
    //             'near_river_yn' => $lm_details['near_river_yn'],
    //             'prim_per_bigha' => $prim_per_bigha,
    //             'conv_b' => $lm_details['conv_b'],
    //             'conv_k' => $lm_details['conv_k'],
    //             'conv_lc' => $lm_details['conv_lc'],
    //             'prim_tot' => $prim_tot,
    //             'lm_sign_yn' => $lm_details['lm_sign_yn'],
    //             'case_no' => $case_no,
    //             'lm_code' => $lm_details['lm_code'],
    //             'sk_note_date' => $lm_details['sk_note_date'],
    //             'sk_note' => $lm_details['sk_note'],
    //             'sk_sign_yn' => $lm_details['sk_sign_yn'],
    //             'sk_name' => $lm_details['user_code'],
    //             'jati_janajati_yn' => $lm_details['jati_janajati_yn'],
    //             'jati_janajati_upload' => $lm_details['jati_janajati_upload'],
    //             'freedom_fighter_yn' => $lm_details['freedom_fighter_yn'],
    //             'freedom_fighter_upload' => $lm_details['freedom_fighter_upload'],
    //             'widow_yn' => $lm_details['widow_yn'],
    //             'widow_upload' => $lm_details['widow_upload'],
    //             'premium_assesment' => $lm_details['premium_assesment']
    //         );
    //     }

    $prim_per_bigha = $lm_details['prim_per_bigha'];
    $prim_per_bigha = round($prim_per_bigha, 2);

    $prim_tot = $lm_details['prim_tot'];
    $prim_tot = round($prim_tot, 2);

    $land = $lm_details['land_class_code'];
    $land_type = $this->db->query("Select * from    landclass_code where class_code = '$land'")->row();
    $data['p_in_order'] = $petitioner_parts;
    $data['lm_details'] = array(
        'dag_no' => $lm_details['dag_no'],
        'prim_per_bigha' => $prim_per_bigha,
        'conv_b' => $lm_details['conv_b'],
        'conv_k' => $lm_details['conv_k'],
        'conv_lc' => $lm_details['conv_lc'],
        'prim_tot' => $prim_tot,
        'jati_janajati_yn' => $lm_details['jati_janajati_yn'],
        'jati_janajati_upload' => $lm_details['jati_janajati_upload'],
        'freedom_fighter_yn' => $lm_details['freedom_fighter_yn'],
        'freedom_fighter_upload' => $lm_details['freedom_fighter_upload'],
        'widow_yn' => $lm_details['widow_yn'],
        'widow_upload' => $lm_details['widow_upload'],
        'premium_assesment' => $lm_details['premium_assesment'],
        'dist_frm_town' => $lm_details['dist_frm_town'],
        'inside_outside_town' => $lm_details['inside_outside_town'],
        'conversion_premium_rates_id' => $lm_details['conversion_premium_rates_id'],

        'note_no' => $lm_details['note_no'],
        'partition_info' => $lm_details['partition_info'],
        'date_entry' => $lm_details['date_entry'],
        'applicant_patta_yn' => $lm_details['applicant_patta_yn'],
        'occupied_yn' => $lm_details['occupied_yn'],
        'val_tree_yn' => $lm_details['val_tree_yn'],
        'land_class_code' => $land_type->land_type,
        'issuit_forconv_under105' => $lm_details['issuit_forconv_under105'],
        'roadside_rsv_b' => $lm_details['roadside_rsv_b'],
        'roadside_rsv_k' => $lm_details['roadside_rsv_k'],
        'roadside_rsv_lc' => $lm_details['roadside_rsv_lc'],
        'near_river_yn' => $lm_details['near_river_yn'],
        'lm_sign_yn' => $lm_details['lm_sign_yn'],
        'lm_code' => $lm_details['lm_code'],
        'sk_note_date' => $lm_details['sk_note_date'],
        'sk_note' => $lm_details['sk_note'],
        'sk_sign_yn' => $lm_details['sk_sign_yn'],
        'sk_name' => $lm_details['user_code'],
    );

    $data['lm_details_final'] = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
                . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and "
                . "mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' order by note_no desc limit 1")->result();

    $namelm = $this->db->query("select * from    lm_code where lm_code = '" . $lm_details['lm_code'] . "'  and dist_code = '" . $location['dist_code'] . "' and "
                . "subdiv_code = '" . $location['subdiv_code'] . "' and cir_code = '" . $location['cir_code'] . "' and mouza_pargona_code = '" . $location['mouza_pargona_code'] . "' "
                . "and lot_no = '" . $location['lot_no'] . "' ")->row();
        
    $data['lm_name'] = $namelm->lm_name;

    $ppquery = "select * from    petition_proceeding where case_no = '$case_no'";
    $data['cases'] = $this->db->query($ppquery)->result();

    $data['conversion_premium_area'] = $this->db->query("SELECT * FROM conversion_premium_areas WHERE id=?", [$lm_details['conversion_premium_areas_id']])->row();
    $data['conversion_premium_rate'] = $this->db->query("SELECT * FROM conversion_premium_rates WHERE id=?", [$lm_details['conversion_premium_rates_id']])->row();

      $data['approval_authority'] = $this->MbOfficeConversionModel->approvalAuthority($lm_details['conversion_premium_rates_id']);
      $data['basundharaAttachment']=$this->MbOfficeConversionModel->searchBasundharaLink($case_no);
      if(!$data['basundharaAttachment']) {
          $data['supportiveDocs'] = $this->SupportiveDocumentModel->getDocs($case_no);
      }
      $application_no = $this->BasundharApplicationModel->checkExistBasundhar($case_no);
    //   if($application_no == null) {
    //       return null;
    //   }

    //   $appDetails = $this->RtpsModel->getApplicationDetails($application_no);
    //   var_dump($application_no);

    //   if(isset($appDetails->mutation) && !empty($appDetails->mutation)) {
    //     $firstparty = $appDetails->mutation;
    //    }
    //    var_dump($appDetails);
    $appDetails = $this->RtpsModel->getApplicationDetails($application_no);


    if(!isset($appDetails) || empty($appDetails) || !isset($appDetails->application) || empty($appDetails->application) || !isset($appDetails->mutation) || empty($appDetails->mutation) || !isset($appDetails->documents) || empty($appDetails->documents) || !isset($appDetails->documents) || empty($appDetails->documents)) {

    }
    $mutation = $appDetails->mutation;
    $pattadar = [];
    foreach($mutation as $mut) {
        $mut->relation = $this->utilityclass->get_relation_from_id($mut->gurdian_relation_id);
        $pattadar[] = $mut;
    }
    $data['pattadar'] = $pattadar;

    $query = "select * from   petition_basic where case_no='$case_no' and dist_code='$dist_code1' and subdiv_code='$subdiv_code1' "
        . "and cir_code='$cir_code1' and mouza_pargona_code = '$mouza_pargona_code1' and lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1'";

    // print_r($query);
    // die;

    $data['petition_basic'] = $this->db->query($query)->row();

    // echo '<pre>';
    // var_dump($data);
    // die;

    $data['_view'] = 'dc_adc_office_conversion/notice_for_premium';
    $this->load->view('layouts/main',$data);
  }


  public function notice_for_premium_save() {

    //form validation
    $formValidation = $this->FormValidationModel->formValidationForPost($_POST, [
       'case_no'=>'Case No.|required|case_no',
       'amount'=>'Amount|required|2_digit_decimal'
   ]);
   if($formValidation['status'] == 'n') {
       //ERRCONVBOSECOND0001
       log_message('error', 'Message: '. $formValidation['message'] .', Data: '. json_encode($formValidation['data']) .'. Error: ERRCONVBOSECOND0001');
       $this->session->set_flashdata('message', $formValidation['message'] .' Error: ERRCONVBOSECOND0001');
       redirect(base_url('index.php/BranchOfficerConversion/GoToBo?pro=3'));
   }

   //syntax validation
   $requestResponse = checkRequestSpecChar($_POST);
   if($requestResponse['status'] == 'n') {
       //ERRCONVBOSECOND0002
       log_message('error', $requestResponse['messages'] . '. Error: ERRCONVBOSECOND0002');
       $this->session->set_flashdata('message', 'Contains Illegal parameter values. Error: ERRCONVBOSECOND0002');
       redirect(base_url('index.php/BranchOfficerConversion/GoToBo?pro=3'));
   }


   //malicious query validation
   $validResponse = checkRequestValidQuery($_POST);
   if($validResponse['status'] == 'n') {
       //ERRCONVBOSECOND0003
       log_message('error', $validResponse['messages'] . '. Error: ERRCONVBOSECOND0003');
       $this->session->set_flashdata('message', 'Contains Malicious parameter values. Error: ERRCONVBOSECOND0003');
       redirect(base_url('index.php/BranchOfficerConversion/GoToBo?pro=3'));
   }


   //authorization to add later
//    $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'BO', $_POST['case_no'], CONV_BO_SECOND);
//    if($authorization['status'] == 'n') {
//        //ERRCONVBOSECOND0004
//        log_message('error', $authorization['messages'] . '. Error: ERRCONVBOSECOND0004');
//        $this->session->set_flashdata('message', $authorization['messages'].'. Error: ERRCONVBOSECOND0004');
//        redirect(base_url('index.php/home'));
//    }


   // echo '<pre>';
   // var_dump($_POST);
   // die();
   $db=  $this->session->userdata('db');
   $case_no = $this->input->post('case_no');
   $dist_code = $this->session->userdata('dist_code');
   $subdiv_code = $this->session->userdata('subdiv_code');
   $cir_code = $this->session->userdata('cir_code');
   $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
   $lot_no = $this->session->userdata('lot_no');
   $vill_townprt_code = $this->session->userdata('vill_townprt_code');
//    $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
   $basundhara=$this->MbOfficeConversionModel->checkExistBasundhar($case_no);
   log_message("info", "********************MPR: basundhara ".$basundhara);
   //var_dump($this->session->all_userdata());
   //exit();
   //////////////////////////////////////
    $this->db->trans_begin();

   
   /////////////Basundhara////////////////////
   if($basundhara){
       $amount=$this->input->post('amount');
          
       //////////////////////
       $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' "
               . "and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
               . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row();
       
       $this->db->query("UPDATE Petition_Basic SET new_status='ADCTP', co_order_conv_notice = NULL WHERE case_no = '$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' "
               . "and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
               . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'");
        
       if($this->db->affected_rows() <= 0)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRCONVDC001988: Updation failed in Petition_Basic Case No '.$case_no);
            $data = array(
                'error'=>"#ERRCONVDC001988: Update failed for case no : ".$case_no
            );
            echo json_encode($data);
            return false;
        }
       //////////////////////////////////////

       $proceeding_dc_adc          = $this->db->query("select count(proceeding_id) as proceed from    petition_proceeding_dc_adc where case_no = '$case_no' limit 1")->result();
        $proceeding_id_dc_adc       = $proceeding_dc_adc[0]->proceed + 1;
        $proceeding_data_end_dc_adc = [
            'case_no'         => $case_no,
            'proceeding_id'   => $proceeding_id_dc_adc,
            'date_of_hearing' => date('Y-m-d h:i:s'),
            'co_order'        => 'Premium Notice',
            'note_on_order'   => 'Premium Notice Generated',
            //'next_date_of_hearing' => $hearing_date,
            'status'          => 'Pending',
            'user_code'       => $this->session->userdata('user_code'),
            'date_entry'      => date('Y-m-d H:i:s'),
            'operation'       => 'E',
            'dist_code'       => $dist_code,
            'subdiv_code'     => $subdiv_code,
            'cir_code'        => $cir_code,
        ];

        $insert_ppd39 = $this->db->insert('petition_proceeding_dc_adc', $proceeding_data_end_dc_adc);
        // var_dump("helllllooooooo:-> ".$insert_ppd39); die;
        if ($insert_ppd39 != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERRCONVDC001987: Insertion failed in petition_proceeding_dc_adc for case no :' . $case_no);
            $json = [
                'message' => "#ERRCONVDC001987: Failed to in Proceeding for Case No : " . $case_no,
            ];
            echo json_encode($json);
            return false;
        }

        $penUser='ADC';
        $rmrk='Notice Granted for payment';
        $status='Q';
        $task='ADC';
        $pen='ADC';
        $case=$basundhara;
        $success=$this->basundharamodel->payqueryRequestMb3($basundhara,$amount);
        if(intval($success) > 0)
        {
            $this->DashboardData($case_no,$penUser,$rmrk);
            if($basundhara){
                $status='M';
                $task='ADC';
                $pen='ADC';
                $rtps_status = $this->basundharamodel->postApiBasundharaSec($case_no,$rmrk,$status,$task,$pen);
                    
                if(trim($rtps_status) !="y") {
                    $this->db->trans_rollback();
                    log_message('error', 'Error in Premium Notice cancellation for case no: '. $case_no .'. Error: ERRCONVADCPAYCAN004152');
                    $this->session->set_flashdata('message', "Premium Notice on Conversion is cancelled for Case no # $case_no");
                    redirect(base_url() . "index.php/home");
                    exit();
                }
            } 

            $this->db->trans_commit();
        }
        else
        {
             $this->db->trans_rollback();
            log_message('error', 'Error in Premium Notice cancellation for case no: '. $case_no .'. Error: ERRCONVADCPAYCAN004152');
            $this->session->set_flashdata('message', "Premium Notice on Conversion is cancelled for Case no # $case_no");
            redirect(base_url() . "index.php/home");
            exit();
        }

        //    $this->session->set_flashdata('message', "Notice Generated for Payment of Premium on Conversion Case # $case_no");
        //    redirect(base_url() . "index.php/home");
        echo json_encode([
            'status' => 'SUCCESS',
            'msg' => "Notice Generated for Payment of Premium on Conversion Case # $case_no"
        ]);      
        exit;

   
    
   }
   else
   {
       var_dump("ERR09777: Something Went Wrong!!!"); die;
       //////////////////////
       $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' "
               . "and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
               . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row();
       
       $this->db->query("UPDATE Petition_Basic SET new_status='ADCTP', co_order_conv_notice = NULL WHERE case_no = '$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' "
               . "and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
               . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'");
       //////////////////////////////////////

    //    $this->session->set_flashdata('message', "Notice Generated for Payment of Premium on Conversion Case # $case_no");
    //    redirect(base_url() . "index.php/home");
    echo json_encode([
        'status' => 'SUCCESS',
        'msg' => "Notice Generated for Payment of Premium on Conversion Case # $case_no"
    ]);      
    exit;
   }
   
}

public function confirmation_premium() {
  $db=  $this->session->userdata('db');
  $dist_code1 = $this->session->userdata('dist_code');
  $subdiv_code1 = $this->input->get('subdiv_code');
  $cir_code1 = $this->input->get('cir_code');
  $mouza_pargona_code1 = $this->input->get('mouza_pargona_code');
  $lot_no1 = $this->input->get('lot_no');
  $vill_townprt_code1 = $this->input->get('vill_townprt_code');
  $this->session->set_userdata(array('subdiv_code' => $subdiv_code1));
  $this->session->set_userdata(array('cir_code' => $cir_code1));
  $this->session->set_userdata(array('mouza_pargona_code' => $mouza_pargona_code1));
  $this->session->set_userdata(array('lot_no' => $lot_no1));
  $this->session->set_userdata(array('vill_townprt_code' => $vill_townprt_code1));
  $data = array();
  $case_no = $this->input->get('case_no');
  $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' "
          . "and dist_code='$dist_code1' and subdiv_code='$subdiv_code1' and cir_code='$cir_code1' and mouza_pargona_code = '$mouza_pargona_code1' and "
          . "lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1'")->row();
  $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,date_entry,add_off_name,next_date_of_hearing,sk_comment"
                  . " from    petition_basic where case_no='$case_no' "
          . "and dist_code='$dist_code1' and subdiv_code='$subdiv_code1' and cir_code='$cir_code1' and mouza_pargona_code = '$mouza_pargona_code1' and "
          . "lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1'")->row_array();

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
      'date' => $location['date_entry'],
      'add_to' => $location['add_off_name'],
      'next_date' => $location['next_date_of_hearing'],
      'sk_comment' => $location['sk_comment']
  );
  $convertion_code = CONVERSION_CODE;
  $data['conv_type'] = $this->db->query("select order_type from    master_office_mut_type "
                  . " where order_type_code='$convertion_code'")->row()->order_type;

  $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from    petition_dag_details where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'")->row_array();
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

  $pattadardetails = "select pdar_name,pdar_guardian,pdar_rel_guar,pdar_add1,pdar_add2, inplace_alongwith from    petitioner_part where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and dag_no='$landdetails[dag_no]' and TRIM(patta_no)='" . trim($landdetails['patta_no']) . "' and patta_type_code= '$landdetails[patta_type_code]'";
  $data['pattadar'] = $petitioner_parts = $this->db->query($pattadardetails)->result();
  $lm_details = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and co_reject is NULL order by note_no desc limit 1")->row_array();

    $prim_per_bigha = $lm_details['prim_per_bigha'];
    $prim_per_bigha = round($prim_per_bigha, 2);

    $prim_tot = $lm_details['prim_tot'];
    $prim_tot = round($prim_tot, 2);

    $land = $lm_details['land_class_code'];
    $land_type = $this->db->query("Select * from    landclass_code where class_code = '$land'")->row();
    $data['p_in_order'] = $petitioner_parts;
    $data['lm_details'] = array(
        'dag_no' => $lm_details['dag_no'],
        'prim_per_bigha' => $prim_per_bigha,
        'conv_b' => $lm_details['conv_b'],
        'conv_k' => $lm_details['conv_k'],
        'conv_lc' => $lm_details['conv_lc'],
        'prim_tot' => $prim_tot,
        'premium_assesment' => $lm_details['premium_assesment'],
        'dist_frm_town' => $lm_details['dist_frm_town'],
        'inside_outside_town' => $lm_details['inside_outside_town'],

        'conversion_premium_rates_id' => $lm_details['conversion_premium_rates_id'],
        'jati_janajati_yn' => $lm_details['jati_janajati_yn'],
        'jati_janajati_upload' => $lm_details['jati_janajati_upload'],
        'freedom_fighter_yn' => $lm_details['freedom_fighter_yn'],
        'freedom_fighter_upload' => $lm_details['freedom_fighter_upload'],
        'widow_yn' => $lm_details['widow_yn'],
        'widow_upload' => $lm_details['widow_upload'],
        'note_no' => $lm_details['note_no'],
        'partition_info' => $lm_details['partition_info'],
        'date_entry' => $lm_details['date_entry'],
        'applicant_patta_yn' => $lm_details['applicant_patta_yn'],
        'occupied_yn' => $lm_details['occupied_yn'],
        'val_tree_yn' => $lm_details['val_tree_yn'],
        'land_class_code' => $land_type->land_type,
        'issuit_forconv_under105' => $lm_details['issuit_forconv_under105'],
        'roadside_rsv_b' => $lm_details['roadside_rsv_b'],
        'roadside_rsv_k' => $lm_details['roadside_rsv_k'],
        'roadside_rsv_lc' => $lm_details['roadside_rsv_lc'],
        'near_river_yn' => $lm_details['near_river_yn'],
        'lm_sign_yn' => $lm_details['lm_sign_yn'],
        'lm_code' => $lm_details['lm_code'],
        'sk_note_date' => $lm_details['sk_note_date'],
        'sk_note' => $lm_details['sk_note'],
        'sk_sign_yn' => $lm_details['sk_sign_yn'],
        'sk_name' => $lm_details['user_code'],
    );
    $data['lm_details_final'] = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
                . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and "
                . "mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' order by note_no desc limit 1")->result();

    $namelm = $this->db->query("select * from    lm_code where lm_code = '" . $lm_details['lm_code'] . "'  and dist_code = '" . $location['dist_code'] . "' and "
                . "subdiv_code = '" . $location['subdiv_code'] . "' and cir_code = '" . $location['cir_code'] . "' and mouza_pargona_code = '" . $location['mouza_pargona_code'] . "' "
                . "and lot_no = '" . $location['lot_no'] . "' ")->row();
        
    $data['lm_name'] = $namelm->lm_name;

    $ppquery = "select * from    petition_proceeding where case_no = '$case_no'";
    $data['cases'] = $this->db->query($ppquery)->result();

    $data['conversion_premium_area'] = $this->db->query("SELECT * FROM conversion_premium_areas WHERE id=?", [$lm_details['conversion_premium_areas_id']])->row();
    $data['conversion_premium_rate'] = $this->db->query("SELECT * FROM conversion_premium_rates WHERE id=?", [$lm_details['conversion_premium_rates_id']])->row();

    $data['payment_type'] = $this->db->query("Select * from    premium_chalan_receipt")->result();
    $data['basundharaExist']=$this->MbOfficeConversionModel->checkExistBasundhar($case_no);

    $application_no = $this->BasundharApplicationModel->checkExistBasundhar($case_no);
    $appDetails = $this->RtpsModel->getApplicationDetails($application_no);


    if(!isset($appDetails) || empty($appDetails) || !isset($appDetails->application) || empty($appDetails->application) || !isset($appDetails->mutation) || empty($appDetails->mutation) || !isset($appDetails->documents) || empty($appDetails->documents) || !isset($appDetails->documents) || empty($appDetails->documents)) {

    }
    $mutation = $appDetails->mutation;
        $pattadar = [];
        foreach($mutation as $mut) {
            $mut->relation = $this->utilityclass->get_relation_from_id($mut->gurdian_relation_id);
            $pattadar[] = $mut;
        }
        $data['pattadar'] = $pattadar;

    ////////Payment Track//////////

    $data['success']=json_decode($this->basundharamodel->paymentConfirmationMb3($data['basundharaExist'])); ///this method to create for MB3 AP in rtpsmb
    //var_dump($data['success']); die;
    // var_dump($data['success']); die();
    ///////////////
    $data['_view'] = 'dc_adc_office_conversion/confirmation_of_premium';
    $this->load->view('layouts/main',$data);
}

public function confirmation_premium_save() {
    if(!isset($_POST['paymentBasu'])) {
        //form validation
        $formValidation = $this->FormValidationModel->formValidationForPost($_POST, [
            'case_no'=>'Case No.|required|case_no',
            'payment_type'=>'Payment Type|required_on_condition(submit1,equals,[true])|digit',
            'chalan_no'=>'Chalan No.|required_on_condition(payment_type, notEquals, [003])',
            'premium_amount'=>'Premium Amount|required|2_digit_decimal'
        ]);
        
        if($formValidation['status'] == 'n') {
            //ERRCONVBOCONFPREM0001
            log_message('error', 'Message: '. $formValidation['message'] .', Data: '. json_encode($formValidation['data']) .'. Error: ERRCONVBOCONFPREM0001');
            $this->session->set_flashdata('message', $formValidation['message'] .' Error: ERRCONVBOCONFPREM0001');
            redirect(base_url('index.php/BranchOfficerConversion/GoToBo?pro=4'));
        }

        //syntax validation
        $requestResponse = checkRequestSpecChar($_POST);
        if($requestResponse['status'] == 'n') {
            //ERRCONVBOCONFPREM0002
            log_message('error', $requestResponse['messages'] . '. Error: ERRCONVBOCONFPREM0002');
            $this->session->set_flashdata('message', 'Contains Illegal parameter values. Error: ERRCONVBOCONFPREM0002');
            redirect(base_url('index.php/BranchOfficerConversion/GoToBo?pro=4'));
        }
        

        //malicious query validation
        $validResponse = checkRequestValidQuery($_POST);
        if($validResponse['status'] == 'n') {
            //ERRCONVBOCONFPREM0003
            log_message('error', $validResponse['messages'] . '. Error: ERRCONVBOCONFPREM0003');
            $this->session->set_flashdata('message', 'Contains Malicious parameter values. Error: ERRCONVBOCONFPREM0003');
            redirect(base_url('index.php/BranchOfficerConversion/GoToBo?pro=4'));
        }
        

        //authorization need to add later
        // $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'ADC', $_POST['case_no'], CONV_BO_CONFPREM);
        // if($authorization['status'] == 'n') {
        //     //ERRCONVBOCONFPREM0004
        //     log_message('error', $authorization['messages'] . '. Error: ERRCONVBOCONFPREM0004');
        //     $this->session->set_flashdata('message', $authorization['messages'].'. Error: ERRCONVBOCONFPREM0004');
        //     redirect(base_url('index.php/home'));
        // }

        // echo '<pre>';
        // var_dump($_POST, $authorization);
        // die();
    }

    // echo '<pre>';
    // var_dump($_POST);
    // die;

    $db=  $this->session->userdata('db');
    $dist_code = $this->session->userdata('dist_code');
    $subdiv_code = $this->session->userdata('subdiv_code');
    $cir_code = $this->session->userdata('cir_code');
    $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
    $lot_no = $this->session->userdata('lot_no');
    $vill_townprt_code = $this->session->userdata('vill_townprt_code');
    $case_no = $this->input->post('case_no');
    $payment_type = $this->input->post('payment_type');
    $chalan_no = $this->input->post('chalan_no');
    $petition_basic = $this->db->query("select * from petition_basic where case_no='$case_no' ")->row();
    if (isset($_POST['submit2'])) {
        //echo "one";
        $this->db->query("UPDATE Petition_Basic SET co_order_conv_notice = NULL, co_order_conv_premium = NULL ,bo_note_yn='Y', new_status='ADPCA' WHERE case_no = '$case_no' "
            . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
            . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'");
        $this->db->query("UPDATE petition_lm_note SET recpt_number = 'N' where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and co_reject is NULL");

        ///////////////////////////////////////
        $penUser='ADC';
        $rmrk='Payment not done';
        $this->DashboardData($case_no,$penUser,$rmrk);
        $status='M';
        $task='ADC';
        $pen='ADC';
        $this->basundharamodel->postApiBasundharaSec($case_no,$rmrk,$status,$task,$pen);
        ////////////////////////////////////////
    }
    if(isset($_POST['paymentBasu'])){
        $user_code_adc = $this->session->userdata('user_code');
        $date = $this->input->post('date');
        $bo_note = "আবেদনকাৰীয়ে ".$date." তাৰিখত ম্যাদীকৰন প্ৰিমিয়াম অনলাইন পৰিশোধ কৰিছে | বিহিত ব্যবস্তাৰ বাবে দাখিল কৰা হল | শাখা বিষয়া |";
        $proceeding_no = $this->db->query("select proceeding_id as proceeding_no from    petition_proceeding_dc_adc where case_no = '$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
            . "cir_code='$cir_code' order by proceeding_id desc limit 1 ")->row()->proceeding_no;
        if ($proceeding_no != null)
        {
            $this->db->query("UPDATE petition_proceeding_dc_adc SET note_on_order = '$bo_note', user_code = '$user_code_adc' WHERE proceeding_id = '$proceeding_no' and case_no = '$case_no' "
            . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'");
        }
        $this->db->query("UPDATE petition_basic SET co_order_conv_notice = NULL, co_order_conv_premium = 'P', bo_note_yn = 'Y', bo_note_date='$date', proceeding_yn = '1', new_status='ADCPS'  WHERE case_no = '$case_no' "
            . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
            . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'");
        $this->db->query("UPDATE petition_lm_note SET astt_confirm = 'Y' where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and co_reject is NULL");
        ///////////////////////////////////////
        $penUser='DC';
        $rmrk='Payment Confirmed';
        $this->DashboardData($case_no,$penUser,$rmrk);
        $rmk='Payment Received';
        $status='M';
        $task='ADC';
        $pen='DC';
        $this->basundharamodel->postApiBasundharaSec($case_no,$rmrk,$status,$task,$pen);
        ////////////////////////////////////////
    }
    if (isset($_POST['submit1'])) {
        //echo "two";
        $user_code_adc = $this->session->userdata('user_code');
        $date = date('Y-m-d');
        $premium_amount = $this->input->post('premium_amount');
        $premium_type_name = $this->db->query("Select chalan_name as name from    premium_chalan_receipt where code = '$payment_type' ")->row()->name;
        $payment_date = $this->input->post('payment_date');
        

        //Premium challan upload validation starts here

        $count = $this->db->query("SELECT count(case_no) AS count FROM supportive_document 
        WHERE case_no=?", array($case_no))->row()->count;
        $sl = $count+1;
        $path = CONVERSION_PREMCHALLAN_BASE_DIR;

        if(!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        
        $file = $petition_basic->petition_no.date('Y').'_'.$sl;
        
        $_FILES['file']['type'] = $_FILES['up_prem_conv']['type'];
        $_FILES['file']['tmp_name'] = $_FILES['up_prem_conv']['tmp_name'];
        $_FILES['file']['error'] = $_FILES['up_prem_conv']['error'];
        $_FILES['file']['size'] = $_FILES['up_prem_conv']['size'];

        $ext = pathinfo($_FILES['up_prem_conv']['name'], PATHINFO_EXTENSION);
        $_FILES['file']['name'] = $file.'.'.$ext;

        $config = array(
            // 'upload_path' => './ConversionDocs/PremChallan/',
            'upload_path' => $path,
            'allowed_types' => FILE_TYPE,
            'max_size' => MAX_SIZE,
        );
        $this->db->trans_begin();
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ($this->upload->do_upload('file')) 
        {
            $data = $this->upload->data();
            if(!file_exists($data['full_path'])) {
                $this->db->trans_rollback();
                log_message('error', 'Premium Challan file could not be uploaded for case no: ' . $case_no);
                $this->session->set_flashdata('message', 'Premium Challan file could not be uploaded for case no: ' . $case_no);
                redirect(base_url() . "index.php/home");
                return;
            }
            $img = [
                'case_no' => $case_no,
                'user_code' => $this->session->userdata('user_code'),
                'file_name' => NOC,
                'fetch_file_name' => $file.$data['file_ext'],
                'file_type' => $data['file_type'],
                'file_path' => $path.$file.$data['file_ext'],
                'date_entry' => date('Y-m-d h:i:s'),
                'mut_type' => 'NA',
            ];
            $insUpload = $this->db->insert('supportive_document', $img);
            
            if($insUpload != 1 ){
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "LMCR0001: Unable to pass order !");
                log_message("error","#LMCR0001 Uploading Failed for dist:"
                            .$dist_code.", case no: ". $case_no);
                redirect(base_url() . "index.php/home");
                return;
            }
        }
        ////////////Premium challan ends here////////

        if($payment_type == '003'){
            //it is arrear
            $bo_note = "আবেদনকাৰীয়ে ".$date." তাৰিখৰ ".$premium_type_name." যোগে মুঠ ".$premium_amount." টকা ম্যাদীকৰন প্ৰিমিয়াম আদায় দিছে | বিহিত ব্যবস্তাৰ বাবে দাখিল কৰা হল |";
        }
        else{
            $bo_note = "আবেদনকাৰীয়ে ".$date." তাৰিখৰ ".$chalan_no." নং ৰছিদ / ".$premium_type_name." যোগে মুঠ ".$premium_amount." টকা ম্যাদীকৰন প্ৰিমিয়াম আদায় দিছে | বিহিত ব্যবস্তাৰ বাবে দাখিল কৰা হল |";
        }
        
        //echo $bo_note;
        $proceeding_no = $this->db->query("select proceeding_id as proceeding_no from    petition_proceeding_dc_adc where case_no = '$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
            . "cir_code='$cir_code' order by proceeding_id desc limit 1 ")->row()->proceeding_no;
        if ($proceeding_no != null)
        {   
            $pettition_update = "UPDATE petition_proceeding_dc_adc SET note_on_order = '$bo_note', user_code = '$user_code_adc' WHERE proceeding_id = '$proceeding_no' and case_no = '$case_no' "
            . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";

            $this->db->query($pettition_update); // ********************
            if($this->db->affected_rows() <=0 )
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "LMCON0016: Unable to pass order !");
                log_message("error","#LMCON0016 Failed to update petition_proceeding_dc_adc for dist:"
                            .$dist_code.", case no: ". $case_no);
                redirect(base_url() . "index.php/home");
                return;
            }
             
        }
        
        $petition_basic_update="UPDATE petition_basic SET co_order_conv_notice = NULL, co_order_conv_premium = 'P', bo_note_yn = 'Y', bo_note_date='$date', proceeding_yn = '1', new_status='ADPSO'  WHERE case_no = '$case_no' "
        . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
        . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'";
        $this->db->query($petition_basic_update); // ********************
        if($this->db->affected_rows() <=0 )
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "LMCON0017: Unable to pass order !");
            log_message("error","#LMCON0017 Failed to update petition_basic for dist:"
                        .$dist_code.", case no: ". $case_no);
            redirect(base_url() . "index.php/home");
            return;
        }

        $petition_lm_note_update="UPDATE petition_lm_note SET astt_confirm = 'Y', prem_pay_method = '$payment_type', recpt_number = '$chalan_no', prem_pay_date='$payment_date' where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and co_reject is NULL";
        $this->db->query($petition_lm_note_update);
        if($this->db->affected_rows() <=0 )
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "LMCON0018: Unable to pass order !");
            log_message("error","#LMCON0018 Failed to update petition_lm_note for dist:"
                        .$dist_code.", case no: ". $case_no);
            redirect(base_url() . "index.php/home");
            return;
        }
        // var_dump("mmmmm888999:".$this->db->affected_rows()); die;
        ///////////////////////////////////////
        $penUser='DC';
        $rmrk='Payment Confirmed';
        $this->DashboardData($case_no,$penUser,$rmrk);
        $rmk='Payment Received';
        $status='M';
        $task='ADC';
        $pen='DC';
        $basundharaExist=$this->MbOfficeConversionModel->checkExistBasundhar($case_no);
        if($basundharaExist){
            $success=$this->basundharamodel->postApiManualPaymentMb3($case_no,$task);  
            log_message("info", "************ success=".$success);
            if(intval($success) > 0){
                $this->db->trans_commit();
                $this->basundharamodel->postApiBasundharaSec($case_no,$rmrk,$status,$task,$pen);
            }else{
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "LMCON0019: Unable to pass order !");
                log_message("error","#LMCON0019 Failed to update payment confirmation for dist:"
                            .$dist_code.", case no: ". $case_no);
                redirect(base_url() . "index.php/home");
                return;
            }
        }
        else
        {
            $this->db->trans_commit();
        }
        
        ////////////////////////////////////////
    }
    $this->session->set_flashdata('message', "Payment of Premium Confirmed on Conversion Case no # $case_no");
    redirect(base_url() . "index.php/home");
}

    function cancelPremium(){
        $case_no = $this->input->get('case_no');
        $this->db->trans_begin();
        // $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'BO', $case_no);
        // if($authorization['status'] == 'n') {
        //     //ERRCONVBOCANCPREM0001
        //     log_message('error', $authorization['messages'] . '. Error: ERRCONVBOCANCPREM0001');
        //     $this->session->set_flashdata('message', $authorization['messages'].'. Error: ERRCONVBOCANCPREM0001');
        //     redirect(base_url('index.php/home'));
        // }
        $sql="Select * from petition_basic where case_no='$case_no' and status!='D' ";
        $rowData=$this->db->query($sql)->row_array();
        if($rowData){
            $dist_code=$rowData['dist_code'];
            $subdiv_code=$rowData['subdiv_code'];
            $cir_code=$rowData['cir_code'];
            //////////////////////////////
            $q = $this->db->query("select * from users where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (user_desig_code='CO' or user_desig_code='ASO')");
                $c = $q->result();
                foreach ($c as $x) {
                    $users = "Select user_code as user_c from loginuser_table where user_code='" . $x->user_code . "' and dis_enb_option = 'E' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
                    $select = $this->db->query($users)->row();
                    if ($select) {
                       $co_name = $x->username;
                       $user_desig_code = $x->user_desig_code;
                       $user_code = $select->user_c;
                    }
                } 
            $proceeding = $this->db->query("select count(proceeding_id) as proceed from petition_proceeding where case_no = '$case_no' order by proceed desc limit 1")->result();
            $proceeding_id = $proceeding[0]->proceed;            
            $note_on_order = 'Cacncel the Premium Notice and reverted back to CO';   
            $user_code_bo=$this->session->userdata('user_code');        
            $update1 = "UPDATE petition_proceeding set note_on_order = '$note_on_order', user_code = '$user_code_bo', status = 'pending' WHERE proceeding_id = '$proceeding_id' and case_no = '$case_no' "
                . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
            $this->db->query($update1);
            //////////////////////////////
            $update = array(
                    'order_passed'=>null,
                    'date_of_order'=>null,
                    'status'=> 'R',
                    'new_status'=> 'ADCOR',
                    'bo_note_yn'=>null,
                    'bo_notice_gen'=>null,
                    'bo_note_date'=>null,
                    'co_order_conv_date'=>null,
                    'add_off_desig' => $user_desig_code, 
                    'add_off_name' => $co_name, 
                    'co_user_code' => $user_code,
                    'user_code' => $user_code,
                    'notice_generated_yn'=>'Y',
                    'proceeding_yn'=>'1',
                    'co_order_conv_premium'=>null
            );
            $this->db->where('case_no', $case_no);
            $basic_update = $this->db->update('petition_basic', $update);
            if($basic_update){
                $basundhara=$this->MbOfficeConversionModel->checkExistBasundhar($case_no);
                if($basundhara){

                     ///////////////////////////////////////
                    $penUser='CO';
                    $rmrk='Payment notice cancelled';
                    $this->DashboardData($case_no,$penUser,$rmrk);
                    $status='M';
                    $task='ADC';
                    $pen='CO';
                    $rtps_status = $this->basundharamodel->postApiBasundharaSec($case_no,$rmrk,$status,$task,$pen);
        
                    if(trim($rtps_status) !="y") {
                        //ERRCONVCOFIRST0012
                        $this->db->trans_rollback();
                        log_message('error', 'Error in Premium Notice cancellation for case no: '. $case_no .'. Error: ERRCONVADCPAYCAN00152');
                        $this->session->set_flashdata('message', "Premium Notice on Conversion is cancelled for Case no # $case_no");
                        redirect(base_url() . "index.php/home");
                        exit();
                    }
                    ////////////////////////////////////////


                    $apilink=API_LINK_MB3;
                    $curl_handle = curl_init();
                    //curl_setopt($curl_handle,CURLOPT_URL, "https://basundhara.assam.gov.in/demo/LocalAPI/cancelPayRequest");
                    curl_setopt($curl_handle, CURLOPT_URL, $apilink."cancelPayRequest");
                    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
                    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                        'application' => $basundhara,
                        'query' => 'Cacncel the Premium Notice and reverted back to CO',
                        'query_from_officer' => $this->session->userdata('user_code'),
                        'query_from_office' => 'DC',
                    )));
                    $data=curl_exec($curl_handle);
                    echo json_decode($data);
                }
            }

           
            $this->db->trans_commit();
            $this->session->set_flashdata('message', "Premium Notice on Conversion is cancelled for Case no # $case_no");
            redirect(base_url() . "index.php/home");
        }else{
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "Case no # $case_no not found ... Please try again");
            redirect(base_url() . "index.php/home");
        }   
    }

    public function viewPremiumNoticeAPtoPPNoticeSaveCases()
    {
        // 1. Get case_no from query string
        $case_no = $this->input->get('case_no');

        if (!$case_no) {
            show_error('Missing case number.', 400);
            return;
        }

        // 2. Load DB
        $this->load->database();

        // 3. Fetch document
        $this->db->where('case_no', $case_no);
        $this->db->where('file_name', 'Premium Notice');
        $query = $this->db->get('supportive_document');
        $document = $query->row();

        if (!$document) {
            show_error('Document not found for case number: ' . $case_no, 404);
            return;
        }

        // 4. Get file content
        $file_path = $document->file_path;

        if (!file_exists($file_path)) {
            show_error('File not found on server: ' . $file_path, 404);
            return;
        }

        $json_data = file_get_contents($file_path);
        $html_content = json_decode($json_data, true); // or base64_decode(json_decode(...)) if stored that way

        // 5. Output HTML directly
        header('Content-Type: text/html; charset=utf-8');
        echo '<!DOCTYPE html><html><head><title>Premium Notice</title></head><body>';
        echo base64_decode($html_content);
        echo "<script>window.onload = function() { window.print(); window.onafterprint = () => window.close(); }</script>";
        echo '</body></html>';
    }

    public function viewPremiumNoticeAPtoPP() {
      $db=  $this->session->userdata('db');
      $dist_code1 = $this->session->userdata('dist_code');
      $subdiv_code1 = $this->input->get('subdiv_code');
      $cir_code1 = $this->input->get('cir_code');
      $mouza_pargona_code1 = $this->input->get('mouza_pargona_code');
      $lot_no1 = $this->input->get('lot_no');
      $vill_townprt_code1 = $this->input->get('vill_townprt_code');
      $this->session->set_userdata(array('subdiv_code' => $subdiv_code1));
      $this->session->set_userdata(array('cir_code' => $cir_code1));
      $this->session->set_userdata(array('mouza_pargona_code' => $mouza_pargona_code1));
      $this->session->set_userdata(array('lot_no' => $lot_no1));
      $this->session->set_userdata(array('vill_townprt_code' => $vill_townprt_code1));
      $data = array();
      $case_no = $this->input->get('case_no');
      $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' "
              . "and dist_code='$dist_code1' and subdiv_code='$subdiv_code1' and cir_code='$cir_code1' and mouza_pargona_code = '$mouza_pargona_code1' and "
              . "lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1'")->row();
      
      $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,date_entry,add_off_desig,add_off_name,next_date_of_hearing,sk_comment"
                      . " from    petition_basic where case_no='$case_no' "
              . "and dist_code='$dist_code1' and subdiv_code='$subdiv_code1' and cir_code='$cir_code1' and mouza_pargona_code = '$mouza_pargona_code1' and "
              . "lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1'")->row_array();

              
      $designation = $this->db->query("select user_desig_as as user_designation from    master_user_designation where user_desig_code='".$location['add_off_desig']."'")->row()->user_designation;
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
          'date' => $location['date_entry'],
          'add_to' => $location['add_off_name'],
          'next_date' => $location['next_date_of_hearing'],
          'sk_comment' => $location['sk_comment'],
          'add_off_designation' => $designation,
      );
      $convertion_code = CONVERSION_CODE;
      $data['conv_type'] = $this->db->query("select order_type from    master_office_mut_type "
                      . " where order_type_code='$convertion_code'")->row()->order_type;

      $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from    petition_dag_details where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'")->row_array();

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

      $pattadardetails = "select pdar_name,pdar_guardian,pdar_rel_guar,pdar_add1,pdar_add2 from    petitioner_part where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and dag_no='$landdetails[dag_no]' and TRIM(patta_no)='trim($landdetails[patta_no])' and patta_type_code= '$landdetails[patta_type_code]'";
      $data['pattadar'] = $this->db->query($pattadardetails)->result();
      $lm_details = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and co_reject is NULL order by note_no desc limit 1")->row_array();

      $prim_per_bigha = $lm_details['prim_per_bigha'];
      $prim_per_bigha = round($prim_per_bigha, 2);

      $prim_tot = $lm_details['prim_tot'];
      $prim_tot = round($prim_tot, 2);

      $data['lm_details'] = array(
          'dag_no' => $lm_details['dag_no'],
          'prim_per_bigha' => $prim_per_bigha,
          'conv_b' => $lm_details['conv_b'],
          'conv_k' => $lm_details['conv_k'],
          'conv_lc' => $lm_details['conv_lc'],
          'prim_tot' => $prim_tot,
          'jati_janajati_yn' => $lm_details['jati_janajati_yn'],
          'jati_janajati_upload' => $lm_details['jati_janajati_upload'],
          'freedom_fighter_yn' => $lm_details['freedom_fighter_yn'],
          'freedom_fighter_upload' => $lm_details['freedom_fighter_upload'],
          'widow_yn' => $lm_details['widow_yn'],
          'widow_upload' => $lm_details['widow_upload'],
          'premium_assesment' => $lm_details['premium_assesment'],
          'dist_frm_town' => $lm_details['dist_frm_town'],
          'inside_outside_town' => $lm_details['inside_outside_town'],
          'conversion_premium_rates_id' => $lm_details['conversion_premium_rates_id'],
      );

      $data['approval_authority'] = $this->MbOfficeConversionModel->approvalAuthority($lm_details['conversion_premium_rates_id']);
      $data['basundharaAttachment']=$this->MbOfficeConversionModel->searchBasundharaLink($case_no);
      if(!$data['basundharaAttachment']) {
          $data['supportiveDocs'] = $this->SupportiveDocumentModel->getDocs($case_no);
      }
      $application_no = $this->BasundharApplicationModel->checkExistBasundhar($case_no);

    $appDetails = $this->RtpsModel->getApplicationDetails($application_no);


    if(!isset($appDetails) || empty($appDetails) || !isset($appDetails->application) || empty($appDetails->application) || !isset($appDetails->mutation) || empty($appDetails->mutation) || !isset($appDetails->documents) || empty($appDetails->documents) || !isset($appDetails->documents) || empty($appDetails->documents)) {

    }
    $mutation = $appDetails->mutation;
        $pattadar = [];
        foreach($mutation as $mut) {
            $mut->relation = $this->utilityclass->get_relation_from_id($mut->gurdian_relation_id);
            $pattadar[] = $mut;
        }
        $data['pattadar'] = $pattadar;


       $data['_view'] = 'dc_adc_office_conversion/notice_for_premium_mb_view_only';
       $this->load->view('layouts/main',$data);
  }

  public function reverificationbyco()
    {
        $db                 = $this->session->userdata('db');
        $dist_code          = $this->input->post('dist_code');
        $subdiv_code        = $this->input->post('subdiv_code');
        $cir_code           = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no             = $this->input->post('lot_no');
        $vill_townprt_code  = $this->input->post('vill_townprt_code');
        $case_no            = $this->input->post('case_no');
        $user_desig_code    = $this->session->userdata('user_desig_code');
        $user_code          = $this->session->userdata('user_code');
        $reason             = $this->input->post('reason');

        // var_dump("helllllooooooo i am in revert"); die;
        // if re_co_note is Y that means its a village land and lm has wrongly entered report
        $this->db->trans_begin();

        $getLastProcessedCOQuery = "select user_code from petition_proceeding where user_code like 'CO%' and case_no='" . $case_no . "' order by proceeding_id limit 1";
        $getLastProcessedCO      = $this->db->query($getLastProcessedCOQuery)->row()->user_code;

        $userNameQuery = "select * from users where user_code = '$getLastProcessedCO'";
        $userName      = $this->db->query($userNameQuery)->row();

        // print_r($userName);
        // die;

        $this->db->query("UPDATE Petition_Basic SET add_off_desig = 'CO', add_off_name = '$userName->username', co_user_code = '$getLastProcessedCO', status = 'R' WHERE "
            . "case_no = '$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
            . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'");

        if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            log_message('error', '#ERRCONVDC0007: Updation failed in petition_basic Case No ' . $case_no);
            $data = [
                'error' => "#ERRCONVDC0007: Registration of Petition basic for case no : " . $case_no,
            ];
            echo json_encode($data);
            return false;
        }

        $proceeding    = $this->db->query("select count(proceeding_id) as proceed from    petition_proceeding where case_no = '$case_no' order by proceed desc limit 1")->result();
        $proceeding_id = $proceeding[0]->proceed;

        $note_on_order = '<span class="red">Reverted by ADC, Recheck the application. </span>';

        $update1 = "UPDATE petition_proceeding set note_on_order = '$note_on_order', user_code = '$user_code', status = 'Reject' WHERE proceeding_id = '$proceeding_id' and case_no = '$case_no' "
            . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
        $this->db->query($update1);

        if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            log_message('error', '#ERRCONVDC0008: Updation failed in petition_basic Case No ' . $case_no);
            $data = [
                'error' => "#ERRCONVDC0008: Registration of Petition basic for case no : " . $case_no,
            ];
            echo json_encode($data);
            return false;
        }

        $status = 'Reject';

        $proceeding_dc_adc          = $this->db->query("select count(proceeding_id) as proceed from    petition_proceeding_dc_adc where case_no = '$case_no' limit 1")->result();
        $proceeding_id_dc_adc       = $proceeding_dc_adc[0]->proceed + 1;
        $proceeding_data_end_dc_adc = [
            'case_no'         => $case_no,
            'proceeding_id'   => $proceeding_id_dc_adc,
            'date_of_hearing' => date('Y-m-d h:i:s'),
            'co_order'        => $reason,
            'note_on_order'   => $note_on_order,
            //'next_date_of_hearing' => $hearing_date,
            'status'          => $status,
            'user_code'       => $this->session->userdata('user_code'),
            'date_entry'      => date('Y-m-d H:i:s'),
            'operation'       => 'E',
            'dist_code'       => $dist_code,
            'subdiv_code'     => $subdiv_code,
            'cir_code'        => $cir_code,
        ];

        $insert_ppd39 = $this->db->insert('petition_proceeding_dc_adc', $proceeding_data_end_dc_adc);
        // var_dump("helllllooooooo:-> ".$insert_ppd39); die;
        if ($insert_ppd39 != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERRCONVDC00187: Insertion failed in petition_proceeding_dc_adc for case no :' . $case_no);
            $json = [
                'message' => "#ERRCONVDC00187: Failed to in Proceeding for Case No : " . $case_no,
            ];
            echo json_encode($json);
            return false;
        }

        if ($this->db->trans_status() == false) {
            $this->db->trans_rollback();
            $data = [
                'error' => "Error in submitting. Please try Again 2",
            ];
        } else {
            $this->db->trans_commit();

            $basundhara = $this->MbOfficeConversionModel->checkExistBasundhar($case_no);
            log_message("info", "********************MPR: basundhara " . $basundhara);
            //var_dump($this->session->all_userdata());
            //exit();
            //////////////////////////////////////

            $penUser = 'CO';
            $rmrk    = 'Revert Back to CO';
            $this->DashboardData($case_no, $penUser, $rmrk);
            if ($basundhara) {
                $status = 'M';
                $task   = 'ADC';
                $pen    = 'CO';
                $this->basundharamodel->postApiBasundharaSec($case_no, $rmrk, $status, $task, $pen);
            }

            $this->session->set_flashdata('message', "Case no # $case_no has been Reverted back to Circle Officer");
            redirect(base_url() . "index.php/home");
        }

    }

}
