<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class BranchOfficerConversion extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // Allowed designations
        $allowed = ['BO'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }
        
        $this->load->model('basundhara/basundharamodel');
        $this->load->model('mutation/mutationmodel');
        $this->load->model('conversion/ASTofficeConversionModel');
        $this->load->helper(array('form', 'url'));
        $this->load->model('v2/SupportiveDocumentModel');
        $this->load->model('validation/FormValidationModel');
        $this->load->model('validation/AuthorizationModel');
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
    public function GoToBo() {
		 // $db=  $this->session->userdata('db');
        $user_code = $this->session->userdata('user_code');
        $this->load->library('pagination');
        $process = $this->input->get('pro');

        if ($process == '2') {
            $config['total_rows'] = $this->ASTofficeConversionModel->countPendingActionTakenBO($user_code);
            $cases['cases'] = $this->ASTofficeConversionModel->getPendingActionTakenBO($user_code)->result();
        } elseif ($process == '3') {
            $config['total_rows'] = $this->ASTofficeConversionModel->countPendingPremiumBO($user_code);
            $cases['cases'] = $this->ASTofficeConversionModel->getPendingPremiumBO($user_code)->result();
        } elseif ($process == '4') {
            $config['total_rows'] = $this->ASTofficeConversionModel->countPendingPaymentBO($user_code);
            $cases['cases'] = $this->ASTofficeConversionModel->getPendingPaymentBO($user_code)->result();
        }
         elseif ($process == '5') {
            $config['total_rows'] = $this->ASTofficeConversionModel->countPendingReportBO($user_code);
            $cases['cases'] = $this->ASTofficeConversionModel->getPendingReportBO($user_code)->result();
        }
        //echo $config['total_rows'];
        $cases['process'] = $process;
        $cases['_view'] = 'Boofficeconversion/bo_conversion_cases';
        $this->load->view('layouts/main',$cases);
    }
    
    public function Bo_Report(){
		//  $db=  $this->session->userdata('db');
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
        $user_code = $this->session->userdata('user_code');
        $data = array();
        $case_no = $this->input->get('case_no');
        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and "
                . "subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
                . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row();

        $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,date_entry,add_off_name,add_off_desig,next_date_of_hearing,sk_comment "
                . "from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row_array();

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
            'sk_comment' => $location['sk_comment']
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
        
        $bo_name = $this->db->query("Select users.username, loginuser_table.user_code from    users, loginuser_table where users.dist_code = loginuser_table.dist_code "
                    . "and users.user_code = loginuser_table.user_code and users.user_code = '$user_code' and users.dist_code='$petition_basic->dist_code' and "
                    . "users.subdiv_code='00' and users.cir_code='00' and loginuser_table.dis_enb_option = 'E'")->row();
        $bo_name=$bo_name->username;
        $bo_code=$user_code;

        $data['land_details'] = array(
            'dag' => $landdetails['dag_no'],
            'm_dag_area_b' => $landdetails['m_dag_area_b'],
            'm_dag_area_k' => $landdetails['m_dag_area_k'],
            'm_dag_area_lc' => $m_dag_area_lc,
            'patta_no' => trim($landdetails['patta_no']),
            'patta_type' => $landdetails['patta_type_code'],
            'bo_name' => $bo_name,
            'bo_code' => $bo_code,
        );

        $data['patta_type'] = $this->db->query("select patta_type from    patta_code "
                        . " where type_code='$landdetails[patta_type_code]'")->row()->patta_type;

        $pattadardetails = "select pdar_name,pdar_guardian,pdar_rel_guar,pdar_add1,pdar_add2 from    petitioner_part where dist_code='$petition_basic->dist_code' "
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
                'premium_assesment' => $lm_details['premium_assesment'],
                'premium_new_yn' => $lm_details['premium_new_yn']
            );
            if($lm_details['premium_new_yn'] == 1) {
                $data['conversion_premium_area'] = $this->db->query("SELECT * FROM conversion_premium_areas WHERE id=?", [$lm_details['conversion_premium_areas_id']])->row();
                $data['conversion_premium_rate'] = $this->db->query("SELECT * FROM conversion_premium_rates WHERE id=?", [$lm_details['conversion_premium_rates_id']])->row();
            }
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
        
        $data['_view'] = 'Boofficeconversion/FirstProcess';
        $this->load->view('layouts/main',$data);

    }
    public function revert_to_co(){
        //form validation
        $formValidation = $this->FormValidationModel->formValidationForPost($_POST, [
            'case_no'=>'Case No.|required|case_no',
            'bo_code'=>'BO Code|required'
        ]);
        if($formValidation['status'] == 'n') {
            //ERRCONVBORVRTTOCO0001
            log_message('error', 'Message: '. $formValidation['message'] .', Data: '. json_encode($formValidation['data']) .'. Error: ERRCONVBORVRTTOCO0001');
            $this->session->set_flashdata('message', $formValidation['message'] .' Error: ERRCONVBORVRTTOCO0001');
            redirect(base_url('index.php/BranchOfficerConversion/GoToBo?pro=5'));
        }

         //syntax validation
         $requestResponse = checkRequestSpecChar($_POST);
         if($requestResponse['status'] == 'n') {
             //ERRCONVBORVRTTOCO0002
             log_message('error', $requestResponse['messages'] . '. Error: ERRCONVBORVRTTOCO0002');
             $this->session->set_flashdata('message', 'Contains Illegal parameter values. Error: ERRCONVBORVRTTOCO0002');
             redirect(base_url('index.php/BranchOfficerConversion/GoToBo?pro=5'));
         }
 
         //malicious query validation
         $validResponse = checkRequestValidQuery($_POST);
         if($validResponse['status'] == 'n') {
             //ERRCONVBORVRTTOCO0003
             log_message('error', $validResponse['messages'] . '. Error: ERRCONVBORVRTTOCO0003');
             $this->session->set_flashdata('message', 'Contains Malicious parameter values. Error: ERRCONVBORVRTTOCO0003');
             redirect(base_url('index.php/BranchOfficerConversion/GoToBo?pro=5'));
         }
 
         //authorization
         $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'BO', $_POST['case_no'], CONV_BO_FIRST);
         if($authorization['status'] == 'n') {
             //ERRCONVBORVRTTOCO0004
             log_message('error', $authorization['messages'] . '. Error: ERRCONVBORVRTTOCO0004');
             $this->session->set_flashdata('message', $authorization['messages'].'. Error: ERRCONVBORVRTTOCO0004');
             redirect(base_url('index.php/home'));
         }
        // echo '<pre>';
        // var_dump($_POST);
        // die();
        $db=  $this->session->userdata('db');
        $this->db->trans_begin();
        $case_no = $this->input->post('case_no');
        $user_code_bo = $this->input->post('bo_code');
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code1');
        $cir_code = $this->session->userdata('cir_code1');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code1');
        $lot_no = $this->session->userdata('lot_no1');
        $vill_townprt_code = $this->session->userdata('vill_townprt_code1');

        $q = $this->db->query("select * from    users where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (user_desig_code='CO' or user_desig_code='ASO')");
        $c = $q->result();

        foreach ($c as $x) {
            $users = "Select user_code as user_c from    loginuser_table where user_code='" . $x->user_code . "' and dis_enb_option = 'E' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
            $select = $this->db->query($users)->row();
            if (count($select) == '1') {
               $co_name = $x->username;
               $user_desig_code = $x->user_desig_code;
               $user_code = $select->user_c;
            }
        }

        $revert_query="UPDATE Petition_Basic SET add_off_desig = '$user_desig_code', add_off_name = '$co_name', co_user_code = '$user_code', status = 'R' WHERE "
        . "case_no = '$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
        . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'";
        //var_dump($revert_query); die();

        $this->db->query($revert_query); // ********************
        if($this->db->affected_rows() <=0 )
        {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "BCRC0001: Unable to pass order !");
                log_message("error","#BCRC0001 Failed to update Petition_Basic for dist:"
                            .$dist_code.", case no: ". $case_no);
                redirect(base_url() . "index.php/home");
                return;
        }
        // $this->db->query("UPDATE Petition_Basic SET add_off_desig = '$user_desig_code', add_off_name = '$co_name', co_user_code = '$user_code', status = 'R' WHERE "
        //             . "case_no = '$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
        //             . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'");
        
        $this->session->set_flashdata('message', "Case no # $case_no has been Revarted back to Circle Officer");

        $proceeding = $this->db->query("select count(proceeding_id) as proceed from    petition_proceeding where case_no = '$case_no' order by proceed desc limit 1")->result();
        $proceeding_id = $proceeding[0]->proceed;
        
        $note_on_order = '<span class="red">অবেদিত মাটি পুনৰ পৰীক্ষা কৰক ।</span>';
			
        $update1 = "UPDATE petition_proceeding set note_on_order = '$note_on_order', user_code = '$user_code_bo', status = 'Reject' WHERE proceeding_id = '$proceeding_id' and case_no = '$case_no' "
            . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
        $this->db->query($update1);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo "Error Occured";
        } else {
            $this->db->trans_commit();
            $status = 'Reject';
            $this->session->set_flashdata('message', "Sent Back to CO for Conversion Case no # $case_no");
            redirect(base_url() . "index.php/home");
        }

    }
    
    public function FirstProceeding_save(){
         //form validation
         $formValidation = $this->FormValidationModel->formValidationForPost($_POST, [
            'case_no'=>'Case No.|required|case_no',
            'land_scenario'=>'Land Scenario|required|char',
            'prim_assesed'=>'Prim Assesed|required|char',
            'approved'=>'Approved|required_as_option(sent_to_govt)|char',
            'sent_to_govt'=>'Sent to Govt|required_as_option(approved)|char',
            'prt_transfer'=>'Part Transfer|char',
            'road_rvr_rerservation'=>'Road River Reservation|required|char',
            'reverify'=>'Reverify|required|char',
            'bo_notice_predefined'=>'BO Notice Predefined|required',
            'bo_sign_yn'=>'BO Sign|required|char',
            'bo_code'=>'BO Code|required',
            'bo_name'=>'BO Name|required',
            'date_of_entry'=>'Date of Entry|required|date',
            'dag_no'=>'Dag No|required|digit',
            // 'dist_frm_town'=>'Distance from Town|required|digit',
            // 'inside_outside_town'=>'Inside Outside Town|required|char',
            'reason'=>'Reason|required_on_condition(approved,equals,[N])|required_on_condition(sent_to_govt,equals,[N])',
            // 'bo_notice'=>''
            // prt_transfer
        ]);
        if($formValidation['status'] == 'n') {
            //ERRCONVBOFIRST0001
            log_message('error', 'Message: '. $formValidation['message'] .', Data: '. json_encode($formValidation['data']) .'. Error: ERRCONVBOFIRST0001');
            $this->session->set_flashdata('message', $formValidation['message'] .' Error: ERRCONVBOFIRST0001');
            redirect(base_url('index.php/BranchOfficerConversion/GoToBo?pro=5'));
        }

         //syntax validation
         $requestResponse = checkRequestSpecChar($_POST, ['bo_notice_predefined'=>['%']]);
         if($requestResponse['status'] == 'n') {
             //ERRCONVBOFIRST0002
             log_message('error', $requestResponse['messages'] . '. Error: ERRCONVBOFIRST0002');
             $this->session->set_flashdata('message', 'Contains Illegal parameter values. Error: ERRCONVBOFIRST0002');
             redirect(base_url('index.php/BranchOfficerConversion/GoToBo?pro=5'));
         }
 
         //malicious query validation
         $validResponse = checkRequestValidQuery($_POST, [], ['bo_notice_predefined'=>['%']]);
         if($validResponse['status'] == 'n') {
             //ERRCONVBOFIRST0003
             log_message('error', $validResponse['messages'] . '. Error: ERRCONVBOFIRST0003');
             $this->session->set_flashdata('message', 'Contains Malicious parameter values. Error: ERRCONVBOFIRST0003');
             redirect(base_url('index.php/BranchOfficerConversion/GoToBo?pro=5'));
         }
 
         //authorization
         $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'BO', $_POST['case_no'], CONV_BO_FIRST);
         if($authorization['status'] == 'n') {
             //ERRCONVBOFIRST0004
             log_message('error', $authorization['messages'] . '. Error: ERRCONVBOFIRST0004');
             $this->session->set_flashdata('message', $authorization['messages'].'. Error: ERRCONVBOFIRST0004');
             redirect(base_url('index.php/home'));
         }

        //  echo '<pre>';
        //  var_dump($_POST);
        //  die();
        
        //var_dump($this->input->post());
        $case_no = $this->input->post('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code1');
        $cir_code = $this->session->userdata('cir_code1');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code1');
        $lot_no = $this->session->userdata('lot_no1');
        $vill_townprt_code = $this->session->userdata('vill_townprt_code1');
        $user_code_bo = $this->input->post('bo_code');
        $land_scenario=$this->input->post('land_scenario');
        
        $bo_notice=$this->session->userdata('bo_notice');
        if(empty($bo_notice)){
            $bo_report = $this->input->post('bo_notice_predefined');
        } else {
            $bo_report = $bo_notice;
        }       
        $date = date('Y-m-d');
        $this->db->trans_begin();
        $petition_basic = $this->db->query("select * from petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
                . "and mouza_pargona_code ='$mouza_pargona_code' and lot_no='$lot_no'")->row();
        
        $note_no = $this->db->query("select max(note_no) as note_no from petition_bo_note where petition_no = '$petition_basic->petition_no' and "
                . "dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and "
                . "lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and "
                . "mouza_pargona_code='$petition_basic->mouza_pargona_code' limit 1")->row()->note_no;
        if ($note_no == null) {
            $note_no = 1;
        } else {
            $note_no += 1;
        } 
        $petition_bo_note = array(
            'dist_code' => $petition_basic->dist_code, 
            'subdiv_code' => $petition_basic->subdiv_code,
            'cir_code' => $petition_basic->cir_code,
            'mouza_pargona_code' => $petition_basic->mouza_pargona_code,
            'lot_no' => $petition_basic->lot_no,
            'vill_townprt_code' => $petition_basic->vill_townprt_code,
            'year_no' => $petition_basic->year_no,
            'petition_no' => $petition_basic->petition_no,
            'dag_no' => $this->input->post('dag_no'),
            'case_no' => $case_no,
            'note_no' => $note_no,
            'dist_frm_town' => ($this->input->post('dist_frm_town')) ? $this->input->post('dist_frm_town') : '0',
            'inside_outside_town' => ($this->input->post('inside_outside_town')) ? $this->input->post('inside_outside_town') : '',
            'land_scenario' => $this->input->post('land_scenario'),
            'prt_transfer' => ($this->input->post('prt_transfer')) ? $this->input->post('prt_transfer') : '',
            'sent_to_govt' => ($this->input->post('sent_to_govt')) ? $this->input->post('sent_to_govt') : '',
            'approved' => $this->input->post('approved'),
            'reason' => $this->input->post('reason'),
            'prim_assesed' => $this->input->post('prim_assesed'),
            'road_rvr_rerservation' => $this->input->post('road_rvr_rerservation'),
            'reverify' => $this->input->post('reverify'),
            'bo_note' => $bo_report,
            'bo_sign_yn' => $this->input->post('bo_sign_yn'), 
            'bo_code' => $this->input->post('bo_code'),
            'bo_sign_date' =>  date('Y-m-d',strtotime($this->input->post('date_of_entry')))
        );
        //echo $land_scenario;       
        if($land_scenario == 'Y')// Y means its not a village land
        {
            $status = 'pending';
            //var_dump($petition_bo_note);
            $tstatus1=$this->db->insert('petition_bo_note', $petition_bo_note);
            if(!$tstatus1 || $this->db->affected_rows() < 1){
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error.... #CONVPBN0001");
                redirect(base_url() . "index.php/home");
            }
        } else if($land_scenario == 'N'){
            // if land_scenario is N that means its a village land and lm has wrongly entered report
            // so we revart back that to co
            $q = $this->db->query("select * from users where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (user_desig_code='CO' or user_desig_code='ASO')");
            $c = $q->result();
            foreach ($c as $x) {
                $users = "Select user_code as user_c from loginuser_table where user_code='" . $x->user_code . "' and dis_enb_option = 'E' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
                $select = $this->db->query($users)->row();
                if (count($select) == '1') {
                   $co_name = $x->username;
                   $user_desig_code = $x->user_desig_code;
                   $user_code = $select->user_c;
                }
            }
            //please also update the user_code with the assistant assigned
            $update="UPDATE Petition_Basic SET add_off_desig = '$user_desig_code', add_off_name = '$co_name', co_user_code = '$user_code', status = 'R' WHERE "
                    . "case_no = '$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'";
            $this->db->query($update);
            if($this->db->affected_rows()!=1){
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error.... #CONVPB0002");
                redirect(base_url() . "index.php/home");
            } 
            $proceeding = $this->db->query("select count(proceeding_id) as proceed from petition_proceeding where case_no = '$case_no' order by proceed desc limit 1")->result();
            $proceeding_id = $proceeding[0]->proceed;            
            $note_on_order = '<span class="red">অবেদিত মাটি চহৰ অথবা চহৰৰ পৰিহিমাৰ পৰা 3 কিঃ মিঃ ব্যাসাৰ্দ্ধ আৰু গুৱাহাটী পৌৰনিগোম পৰিহিমাৰ পৰা 10 কিঃ মিঃ ব্যাসাৰ্দ্ধৰ বাহিৰৰ মাটি হয় ।  পুনৰ পৰীক্ষা কৰক ।</span>';           
            $update1 = "UPDATE petition_proceeding set note_on_order = '$note_on_order', user_code = '$user_code_bo', status = 'Reject' WHERE proceeding_id = '$proceeding_id' and case_no = '$case_no' "
                . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
            $this->db->query($update1);
            if($this->db->affected_rows()!=1){
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error.... #CONVPP0003");
                redirect(base_url() . "index.php/home");
            }
            $this->db->trans_commit();
            $status = 'Reject';
            ///////////////////////////////////////
            $penUser='CO';
            $rmrk='Revert back to CO';
            $this->DashboardData($case_no,$penUser,$rmrk);
            $status='M';
            $task='BO';
            $pen='CO';
            $this->basundharamodel->postApiBasundharaSec($case_no,$rmrk,$status,$task,$pen);
            ////////////////////////////////////////
            $this->session->set_flashdata('message', "Case no # $case_no has been Reverted back to Circle Officer");
            redirect(base_url() . "index.php/home");
        }
        
        $proceeding_no = $this->db->query("select proceeding_id as proceeding_no from petition_proceeding_dc_adc where case_no = '$case_no' order by proceeding_id desc limit 1 ")->row()->proceeding_no;
        if ($proceeding_no != null)
        {

            $this->db->query("UPDATE petition_proceeding_dc_adc SET note_on_order = '$bo_report', user_code = '$user_code_bo', status = '$status' WHERE proceeding_id = '$proceeding_no' and case_no = '$case_no' ");
        }
        if($this->db->affected_rows()!=1){
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "Error.... #CONVPPDAC0004");
            redirect(base_url() . "index.php/home");
        }
        
        $this->db->query("UPDATE Petition_Basic SET bo_note_yn = 'Y', bo_note_date='$date', proceeding_yn = '1'  WHERE case_no = '$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' "
                . "and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
                . "lot_no = '$lot_no'");
        if($this->db->affected_rows()!=1){
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "Error.... #CONVPB0005");
            redirect(base_url() . "index.php/home");
        }
        
        ///////////////////////////////////////
        $penUser='DC';
        $rmrk='Report given by BO';
        $this->DashboardData($case_no,$penUser,$rmrk);
        $rmk='Report given by BO';
        $status='M';
        $task='BO';
        $pen='DC';
        $apiStatus = $this->basundharamodel->postApiBasundharaSec($case_no,$rmk,$status,$task,$pen);
        if(trim($apiStatus) != 'y') {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "API Error!");
            redirect(base_url() . "index.php/home");
        }
        $this->db->trans_commit();
        ////////////////////////////////////////
        $this->session->set_flashdata('message', "Report on Conversion Case # $case_no successfully done.");
        redirect(base_url() . "index.php/home");
        
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
            'premium_new_yn' => $lm_details['premium_new_yn'],
        );
        if($lm_details['premium_new_yn'] == 1) {
            $data['conversion_premium_area'] = $this->db->query("SELECT * FROM conversion_premium_areas WHERE id=?", [$lm_details['conversion_premium_areas_id']])->row();
            $data['conversion_premium_rate'] = $this->db->query("SELECT * FROM conversion_premium_rates WHERE id=?", [$lm_details['conversion_premium_rates_id']])->row();

        }
        $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
        if(!$data['basundharaAttachment']) {
            $data['supportiveDocs'] = $this->SupportiveDocumentModel->getDocs($case_no);
        }
        $data['_view'] = 'Boofficeconversion/notice_for_premium';
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

        //authorization
        $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'BO', $_POST['case_no'], CONV_BO_SECOND);
        if($authorization['status'] == 'n') {
            //ERRCONVBOSECOND0004
            log_message('error', $authorization['messages'] . '. Error: ERRCONVBOSECOND0004');
            $this->session->set_flashdata('message', $authorization['messages'].'. Error: ERRCONVBOSECOND0004');
            redirect(base_url('index.php/home'));
        }
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
        $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
        log_message("info", "********************MPR: basundhara ".$basundhara);
        //var_dump($this->session->all_userdata());
        //exit();
        //////////////////////////////////////
        $penUser='BO';
        $rmrk='Notice Granted for payment';
        $this->DashboardData($case_no,$penUser,$rmrk);
        if($basundhara){
            $status='M';
            $task='DC';
            $pen='BO';
            $this->basundharamodel->postApiBasundharaSec($case_no,$rmrk,$status,$task,$pen);
        }
        
        /////////////Basundhara////////////////////
        if($basundhara){
            $amount=$this->input->post('amount');
            $rmk='Payment Notice Generated';
            $status='Q';
            $task='BO';
            $pen='BO';
            $case=$basundhara;
            //$this->basundharamodel->postApiBasundharaSec($case_no,$rmk,$status,$task,$pen);
            // var_dump($amount); die();
            $success=$this->basundharamodel->payqueryRequest($basundhara,$amount);
            
            log_message("info", "************ success=".$success);
            if(intval($success) > 0){           
            //////////////////////
            $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' "
                    . "and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
                    . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row();
            
            $this->db->query("UPDATE Petition_Basic SET co_order_conv_notice = NULL WHERE case_no = '$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' "
                    . "and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
                    . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'");
            //////////////////////////////////////

            $this->session->set_flashdata('message', "Notice Generated for Payment of Premium on Conversion Case # $case_no");
            redirect(base_url() . "index.php/home");
            }else{
            $this->session->set_flashdata('message', "Please Try Again !");
            redirect(base_url() . "index.php/home");
            } 
        }else{
            //////////////////////
            $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' "
                    . "and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
                    . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row();
            
            $this->db->query("UPDATE Petition_Basic SET co_order_conv_notice = NULL WHERE case_no = '$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' "
                    . "and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
                    . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'");
            //////////////////////////////////////

            $this->session->set_flashdata('message', "Notice Generated for Payment of Premium on Conversion Case # $case_no");
            redirect(base_url() . "index.php/home");
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
            'premium_assesment' => $lm_details['premium_assesment'],
            'dist_frm_town' => $lm_details['dist_frm_town'],
            'inside_outside_town' => $lm_details['inside_outside_town'],
            'premium_new_yn' => $lm_details['premium_new_yn']
        );
        if($lm_details['premium_new_yn'] == 1) {
            $data['conversion_premium_area'] = $this->db->query("SELECT * FROM conversion_premium_areas WHERE id=?", [$lm_details['conversion_premium_areas_id']])->row();
            $data['conversion_premium_rate'] = $this->db->query("SELECT * FROM conversion_premium_rates WHERE id=?", [$lm_details['conversion_premium_rates_id']])->row();
        }
        $data['payment_type'] = $this->db->query("Select * from    premium_chalan_receipt")->result();
        $data['basundharaExist']=$this->basundharamodel->checkExistBasundhar($case_no);
        ////////Payment Track//////////
        $data['success']=json_decode($this->basundharamodel->paymentConfirmation($data['basundharaExist']));
        // var_dump($data['success']); die();
        ///////////////
        $data['_view'] = 'Boofficeconversion/confirmation_of_premium';
        $this->load->view('layouts/main',$data);
    }
    
  //   public function confirmation_premium_save() {
		// $db=  $this->session->userdata('db');
  //       $dist_code = $this->session->userdata('dist_code');
  //       $subdiv_code = $this->session->userdata('subdiv_code');
  //       $cir_code = $this->session->userdata('cir_code');
		// $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
  //       $lot_no = $this->session->userdata('lot_no');
  //       $vill_townprt_code = $this->session->userdata('vill_townprt_code');
  //       $case_no = $this->input->post('case_no');
  //       $payment_type = $this->input->post('payment_type');
  //       $chalan_no = $this->input->post('chalan_no');
  //       $petition_basic = $this->db->query("select * from petition_basic where case_no='$case_no' "
  //               . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
  //               . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row();
  //       if (isset($_POST['submit2'])) {
  //           //echo "one";
  //           $this->db->query("UPDATE Petition_Basic SET co_order_conv_notice = NULL, co_order_conv_premium = NULL  WHERE case_no = '$case_no' "
  //               . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
  //               . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'");
  //           $this->db->query("UPDATE petition_lm_note SET recpt_number = 'N' where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and co_reject is NULL");

  //           ///////////////////////////////////////
  //           $penUser='BO';
  //           $rmrk='Payment not done';
  //           $this->DashboardData($case_no,$penUser,$rmrk);
  //           $status='M';
  //           $task='BO';
  //           $pen='BO';
  //           $this->basundharamodel->postApiBasundharaSec($case_no,$rmrk,$status,$task,$pen);
  //           ////////////////////////////////////////
  //       }
  //       if(isset($_POST['paymentBasu'])){
  //           $user_code_bo = $this->session->userdata('user_code');
  //           $date = $this->input->post('date');
  //           $bo_note = "আবেদনকাৰীয়ে ".$date." তাৰিখত ম্যাদীকৰন প্ৰিমিয়াম অনলাইন পৰিশোধ কৰিছে | বিহিত ব্যবস্তাৰ বাবে দাখিল কৰা হল | শাখা বিষয়া |";
  //           $proceeding_no = $this->db->query("select proceeding_id as proceeding_no from    petition_proceeding_dc_adc where case_no = '$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
  //               . "cir_code='$cir_code' order by proceeding_id desc limit 1 ")->row()->proceeding_no;
  //           if ($proceeding_no != null)
  //           {
  //               $this->db->query("UPDATE petition_proceeding_dc_adc SET note_on_order = '$bo_note', user_code = '$user_code_bo' WHERE proceeding_id = '$proceeding_no' and case_no = '$case_no' "
  //               . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'");
  //           }
  //           $this->db->query("UPDATE petition_basic SET co_order_conv_notice = NULL, co_order_conv_premium = 'P', bo_note_yn = 'Y', bo_note_date='$date', proceeding_yn = '1'  WHERE case_no = '$case_no' "
  //               . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
  //               . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'");
  //           $this->db->query("UPDATE petition_lm_note SET astt_confirm = 'Y', prem_pay_method = '200', recpt_number = 'basundhara_payment' where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and co_reject is NULL");
  //           ///////////////////////////////////////
  //           $penUser='DC';
  //           $rmrk='Payment Confirmed';
  //           $this->DashboardData($case_no,$penUser,$rmrk);
  //           $rmk='Payment Received';
  //           $status='M';
  //           $task='BO';
  //           $pen='DC';
  //           $this->basundharamodel->postApiBasundharaSec($case_no,$rmrk,$status,$task,$pen);
  //           ////////////////////////////////////////
  //       }
  //       if (isset($_POST['submit1'])) {
  //           //echo "two";
		// 	$user_code_bo = $this->session->userdata('user_code');
		// 	$date = date('Y-m-d');
		// 	$premium_amount = $this->input->post('premium_amount');
		// 	$premium_type_name = $this->db->query("Select chalan_name as name from    premium_chalan_receipt where code = '$payment_type' ")->row()->name;
			
		// 	if($payment_type == '003'){
		// 		//it is arrear
		// 		$bo_note = "আবেদনকাৰীয়ে ".$date." তাৰিখৰ ".$premium_type_name." যোগে মুঠ ".$premium_amount." টকা ম্যাদীকৰন প্ৰিমিয়াম আদায় দিছে | বিহিত ব্যবস্তাৰ বাবে দাখিল কৰা হল | শাখা বিষয়া |";
		// 	}
		// 	else{
		// 		$bo_note = "আবেদনকাৰীয়ে ".$date." তাৰিখৰ ".$chalan_no." নং ৰছিদ / ".$premium_type_name." যোগে মুঠ ".$premium_amount." টকা ম্যাদীকৰন প্ৰিমিয়াম আদায় দিছে | বিহিত ব্যবস্তাৰ বাবে দাখিল কৰা হল | শাখা বিষয়া |";
		// 	}
			
		// 	//echo $bo_note;
  //           $proceeding_no = $this->db->query("select proceeding_id as proceeding_no from    petition_proceeding_dc_adc where case_no = '$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
  //               . "cir_code='$cir_code' order by proceeding_id desc limit 1 ")->row()->proceeding_no;
		// 	if ($proceeding_no != null)
  //           {	
		// 	     $this->db->query("UPDATE petition_proceeding_dc_adc SET note_on_order = '$bo_note', user_code = '$user_code_bo' WHERE proceeding_id = '$proceeding_no' and case_no = '$case_no' "
  //               . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'");
  //           }
		// 	$this->db->query("UPDATE petition_basic SET co_order_conv_notice = NULL, co_order_conv_premium = 'P', bo_note_yn = 'Y', bo_note_date='$date', proceeding_yn = '1'  WHERE case_no = '$case_no' "
  //               . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
  //               . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'");
  //           $this->db->query("UPDATE petition_lm_note SET astt_confirm = 'Y', prem_pay_method = '$payment_type', recpt_number = '$chalan_no' where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and co_reject is NULL");
  //           ///////////////////////////////////////
  //           $penUser='DC';
  //           $rmrk='Payment Confirmed';
  //           $this->DashboardData($case_no,$penUser,$rmrk);
  //           $rmk='Payment Received';
  //           $status='M';
  //           $task='BO';
  //           $pen='DC';
  //           $this->basundharamodel->postApiBasundharaSec($case_no,$rmrk,$status,$task,$pen);
  //           ////////////////////////////////////////
  //       }
  //       $this->session->set_flashdata('message', "Payment of Premium Confirmed on Conversion Case no # $case_no");
  //       redirect(base_url() . "index.php/home");
  //   }
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

            //authorization
            $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'BO', $_POST['case_no'], CONV_BO_CONFPREM);
            if($authorization['status'] == 'n') {
                //ERRCONVBOCONFPREM0004
                log_message('error', $authorization['messages'] . '. Error: ERRCONVBOCONFPREM0004');
                $this->session->set_flashdata('message', $authorization['messages'].'. Error: ERRCONVBOCONFPREM0004');
                redirect(base_url('index.php/home'));
            }
            // echo '<pre>';
            // var_dump($_POST, $authorization);
            // die();
        }

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
            $this->db->query("UPDATE Petition_Basic SET co_order_conv_notice = NULL, co_order_conv_premium = NULL ,bo_note_yn='Y' WHERE case_no = '$case_no' "
                . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
                . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'");
            $this->db->query("UPDATE petition_lm_note SET recpt_number = 'N' where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and co_reject is NULL");

            ///////////////////////////////////////
            $penUser='BO';
            $rmrk='Payment not done';
            $this->DashboardData($case_no,$penUser,$rmrk);
            $status='M';
            $task='BO';
            $pen='BO';
            $this->basundharamodel->postApiBasundharaSec($case_no,$rmrk,$status,$task,$pen);
            ////////////////////////////////////////
        }
        if(isset($_POST['paymentBasu'])){
            $user_code_bo = $this->session->userdata('user_code');
            $date = $this->input->post('date');
            $bo_note = "আবেদনকাৰীয়ে ".$date." তাৰিখত ম্যাদীকৰন প্ৰিমিয়াম অনলাইন পৰিশোধ কৰিছে | বিহিত ব্যবস্তাৰ বাবে দাখিল কৰা হল | শাখা বিষয়া |";
            $proceeding_no = $this->db->query("select proceeding_id as proceeding_no from    petition_proceeding_dc_adc where case_no = '$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                . "cir_code='$cir_code' order by proceeding_id desc limit 1 ")->row()->proceeding_no;
            if ($proceeding_no != null)
            {
                $this->db->query("UPDATE petition_proceeding_dc_adc SET note_on_order = '$bo_note', user_code = '$user_code_bo' WHERE proceeding_id = '$proceeding_no' and case_no = '$case_no' "
                . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'");
            }
            $this->db->query("UPDATE petition_basic SET co_order_conv_notice = NULL, co_order_conv_premium = 'P', bo_note_yn = 'Y', bo_note_date='$date', proceeding_yn = '1'  WHERE case_no = '$case_no' "
                . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
                . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'");
            $this->db->query("UPDATE petition_lm_note SET astt_confirm = 'Y', prem_pay_method = '200', recpt_number = 'basundhara_payment' where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and co_reject is NULL");
            ///////////////////////////////////////
            $penUser='DC';
            $rmrk='Payment Confirmed';
            $this->DashboardData($case_no,$penUser,$rmrk);
            $rmk='Payment Received';
            $status='M';
            $task='BO';
            $pen='DC';
            $this->basundharamodel->postApiBasundharaSec($case_no,$rmrk,$status,$task,$pen);
            ////////////////////////////////////////
        }
        if (isset($_POST['submit1'])) {
            //echo "two";
            $user_code_bo = $this->session->userdata('user_code');
            $date = date('Y-m-d');
            $premium_amount = $this->input->post('premium_amount');
            $premium_type_name = $this->db->query("Select chalan_name as name from    premium_chalan_receipt where code = '$payment_type' ")->row()->name;
            

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
                $bo_note = "আবেদনকাৰীয়ে ".$date." তাৰিখৰ ".$premium_type_name." যোগে মুঠ ".$premium_amount." টকা ম্যাদীকৰন প্ৰিমিয়াম আদায় দিছে | বিহিত ব্যবস্তাৰ বাবে দাখিল কৰা হল | শাখা বিষয়া |";
            }
            else{
                $bo_note = "আবেদনকাৰীয়ে ".$date." তাৰিখৰ ".$chalan_no." নং ৰছিদ / ".$premium_type_name." যোগে মুঠ ".$premium_amount." টকা ম্যাদীকৰন প্ৰিমিয়াম আদায় দিছে | বিহিত ব্যবস্তাৰ বাবে দাখিল কৰা হল | শাখা বিষয়া |";
            }
            
            //echo $bo_note;
            $proceeding_no = $this->db->query("select proceeding_id as proceeding_no from    petition_proceeding_dc_adc where case_no = '$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                . "cir_code='$cir_code' order by proceeding_id desc limit 1 ")->row()->proceeding_no;
            if ($proceeding_no != null)
            {   
                $pettition_update = "UPDATE petition_proceeding_dc_adc SET note_on_order = '$bo_note', user_code = '$user_code_bo' WHERE proceeding_id = '$proceeding_no' and case_no = '$case_no' "
                . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";

                $this->db->query($pettition_update); // ********************
                if($this->db->affected_rows() <=0 )
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "LMCON0016: Unable to pass order !");
                    log_message("error","#LMCON0016 Failed to update petition_proceeding_dc_adc for dist:"
                                .$dist_code.", petition no: ". $petition_no);
                    redirect(base_url() . "index.php/home");
                    return;
                }
                 
            }
            $petition_basic_update="UPDATE petition_basic SET co_order_conv_notice = NULL, co_order_conv_premium = 'P', bo_note_yn = 'Y', bo_note_date='$date', proceeding_yn = '1'  WHERE case_no = '$case_no' "
            . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
            . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'";
            $this->db->query($petition_basic_update); // ********************
            if($this->db->affected_rows() <=0 )
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "LMCON0017: Unable to pass order !");
                log_message("error","#LMCON0017 Failed to update petition_basic for dist:"
                            .$dist_code.", petition no: ". $petition_no);
                redirect(base_url() . "index.php/home");
                return;
            }

            $petition_lm_note_update="UPDATE petition_lm_note SET astt_confirm = 'Y', prem_pay_method = '$payment_type', recpt_number = '$chalan_no' where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and co_reject is NULL";
            $this->db->query($petition_lm_note_update);
            if($this->db->affected_rows() <=0 )
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "LMCON0018: Unable to pass order !");
                log_message("error","#LMCON0018 Failed to update petition_lm_note for dist:"
                            .$dist_code.", petition no: ". $petition_no);
                redirect(base_url() . "index.php/home");
                return;
            }
            ///////////////////////////////////////
            $penUser='DC';
            $rmrk='Payment Confirmed';
            $this->DashboardData($case_no,$penUser,$rmrk);
            $rmk='Payment Received';
            $status='M';
            $task='BO';
            $pen='DC';
            $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
            if($basundharaExist){
                $success=$this->basundharamodel->postApiManualPayment($case_no,$task);  
                log_message("info", "************ success=".$success);
                if(intval($success) > 0){
                    $this->db->trans_commit();
                    $this->basundharamodel->postApiBasundharaSec($case_no,$rmrk,$status,$task,$pen);
                }else{
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "LMCON0019: Unable to pass order !");
                    log_message("error","#LMCON0019 Failed to update payment confirmation for dist:"
                                .$dist_code.", petition no: ". $petition_no);
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

    public function notice_action_taken() {
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
        $case_no = $this->input->get('case_no');
        $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,date_entry,add_off_name,next_date_of_hearing"
                        . " from    petition_basic where case_no='$case_no' and dist_code='$dist_code1' and subdiv_code='$subdiv_code1' and cir_code='$cir_code1' and mouza_pargona_code = '$mouza_pargona_code1' and "
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
            'case_no' => $case_no,
            'date_of_hearing' => $location['next_date_of_hearing']
        );

        $query = "select * from    petition_proceeding_dc_adc where case_no = '$case_no' "
                . "and dist_code='$dist_code1' and subdiv_code='$subdiv_code1' and cir_code='$cir_code1' order by proceeding_id";
        $data['cases'] = $this->db->query($query)->result();
        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' and dist_code='$dist_code1' and subdiv_code='$subdiv_code1' and cir_code='$cir_code1' and mouza_pargona_code = '$mouza_pargona_code1' and "
                . "lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1'")->row();
        $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from    petition_dag_details where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'")->row_array();
        $data['land_details'] = array(
            'dag' => $landdetails['dag_no'],
            'm_dag_area_b' => $landdetails['m_dag_area_b'],
            'm_dag_area_k' => $landdetails['m_dag_area_k'],
            'm_dag_area_lc' => $landdetails['m_dag_area_lc'],
            'patta_no' => trim($landdetails['patta_no']),
            'patta_type' => $landdetails['patta_type_code']
        );

        $pattadardetails = "select pdar_name,pdar_guardian,pdar_rel_guar,pdar_add1,pdar_add2 from    petitioner_part where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and dag_no='$landdetails[dag_no]' and TRIM(patta_no)='trim($landdetails[patta_no])' and patta_type_code= '$landdetails[patta_type_code]'";
        $data['p_in_order'] = $this->db->query($pattadardetails)->result();

        //var_dump($data);
        // $this->load->view('../views/header');
        // $this->load->view('../views/Boofficeconversion/action_taken_conversion', $data);
        // $this->load->view('../views/footer');


        $data['_view'] = 'Boofficeconversion/action_taken_conversion';
        $this->load->view('layouts/main',$data);
    }

    public function action_taken_conversion_save() {
		  $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
	$mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_townprt_code');
        $case_no = $this->input->post('case_no');
        $proceedings = $this->input->post('proceeding_id');
        $action_note = $_POST['note_on_order'];
        $action_note = str_replace("'", '', $action_note);
        $user_code = $this->session->userdata('user_code');
        $i = count($proceedings);

        for ($z = 0; $z < $i; $z++) {
            $this->db->query("UPDATE petition_proceeding_dc_adc SET note_on_order = '$action_note[$z]', user_code = '$user_code' WHERE proceeding_id = '$proceedings[$z]' and case_no = '$case_no' "
                . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'");
        }
        $this->db->query("UPDATE Petition_Basic SET proceeding_yn = '1' WHERE case_no = '$case_no' "
                . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
                . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'");
        $this->session->set_flashdata('message', "Action Taken Report Passed for Conversion case no # $case_no");
        redirect(base_url() . "index.php/home");
    }

    public function saveJamabandiByPattano() {
		  $db=  $this->session->userdata('db');
        if (isset($_GET['case_no'])) {
            $case_no = $this->input->get('case_no');
            if ($case_no == '0') {
                //var_dump($this->session->all_userdata());
                $dist_code = $this->session->userdata('dist_code');
                $subdiv_code = $this->session->userdata('subdiv_code');
                $circle_code = $this->session->userdata('cir_code');
                $mouza_code = $this->session->userdata('mouza_pargona_code');
                $lot_no = $this->session->userdata('lot_no');
                $vill_code = $this->session->userdata('vill_code');

                $pattatypeCode = $this->session->userdata('patta_type_code');
                $patta_no = trim($this->session->userdata('patta_no'));
            } elseif ($case_no == '1') {
                //this is for land reclassification
                $proposal_no = $this->input->get('proposal_no');
                $t_reclassification = $this->db->query("Select * from    t_reclassification where proposal_no = '$proposal_no'")->row();

                $dist_code = $t_reclassification->dist_code;
                $subdiv_code = $t_reclassification->subdiv_code;
                $circle_code = $t_reclassification->cir_code;
                $mouza_code = $t_reclassification->mouza_pargona_code;
                $lot_no = $t_reclassification->lot_no;
                $vill_code = $t_reclassification->vill_townprt_code;

                $pattatypeCode = $t_reclassification->patta_type_code;
                $patta_no = trim($t_reclassification->patta_no);
            } else {
                $petition_basic = $this->db->query("Select * from    petition_basic where case_no = '$case_no'")->row();
                $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,"
                                . "patta_type_code from    petition_dag_details where dist_code='$petition_basic->dist_code' and"
                                . " subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and "
                                . "lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and "
                                . "mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'")->row_array();

                $dist_code = $petition_basic->dist_code;
                $subdiv_code = $petition_basic->subdiv_code;
                $circle_code = $petition_basic->cir_code;
                $mouza_code = $petition_basic->mouza_pargona_code;
                $lot_no = $petition_basic->lot_no;
                $vill_code = $petition_basic->vill_townprt_code;

                $pattatypeCode = $landdetails['patta_type_code'];
                $patta_no = trim($landdetails['patta_no']);
            }
        }
        $main = array();
        $jamainfo = array();

        $pattatype = array(
            'patta_type' => $pattatypeCode,
            'patta_no' => $patta_no
        );
        $this->session->set_userdata($pattatype);


        $this->load->model('misreport/MisModel');

        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
        $lotdata = $this->MisModel->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);
        $pattatypename = $this->MisModel->getpattatypeNameforJamabandi($pattatypeCode);
        //$maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotdata, $villagedata, $pattaArray);

        $maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotdata, $villagedata, $pattatypename);
        $maindata['pattainfo'] = $pattatype;
        //print_r($maindata['namedata']);


        $pno = trim($patta_no);
        $main['daginfo'] = array();
        // echo $pno;
        $query = "select jd.dag_no,jd.dag_revenue,jd.dag_localtax,jd.dag_area_b,jd.dag_area_k,jd.dag_area_lc,lcd.land_type,lcd.class_code_cat from    "
                . "jama_dag as jd  JOIN  landclass_code as lcd ON jd.dag_class_code=lcd.class_code WHERE jd.dist_code='$dist_code' and jd.subdiv_code = '$subdiv_code' and jd.cir_code='$circle_code' and "
                . "jd.mouza_pargona_code = '$mouza_code' and jd.lot_no = '$lot_no' and jd.vill_townprt_code='$vill_code' and "
                . "jd.patta_type_code='$pattatypeCode' and TRIM(jd.patta_no)='$pno'";
        // echo $query . "<br>";
        $main['daginfo'] = $this->db->query($query)->result();
        $daginfo_counted = count($main['daginfo']);
        if ($daginfo_counted != "") {

//  var_dump($main['daginfo']);
            // echo "select dag_no,dag_revenue,dag_localtax,dag_area_b,dag_area_k,dag_area_lc from    jama_dag WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and TRIM(patta_no)='trim($patta_no->patta_no)'";
            //print_r($main['daginfo']);
            $query = "select patta_no,pdar_name,pdar_id,pdar_father,pdar_add1,pdar_add2,pdar_add3,p_flag,new_pdar_name,pdar_land_b,pdar_land_k,pdar_land_lc "
                    . "from    jama_pattadar WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                    . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and "
                    . "patta_type_code='$pattatypeCode' and TRIM(patta_no)='$pno' order by length(pdar_id), pdar_id";
            //echo $query . "<br>";
            $main['pattadarinf'] = $this->db->query($query)->result();
            //var_dump($main['pattadarinf'] );

            $query = "select patta_no,remark,rmk_line_no from    jama_remark WHERE "
                    . "dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                    . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and "
                    . "vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and "
                    . "TRIM(patta_no)='$pno' order by rmk_line_no";
            //echo $query . "<br>";
            $main['remarkinf'] = $this->db->query($query)->result();
            $query = "select old_patta_no from    jama_patta WHERE "
                    . "dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                    . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and "
                    . "vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and "
                    . "TRIM(patta_no)='$pno' ";
            // echo $query . "<br>";
            $main['oldpno'] = $this->db->query($query)->result();


            $main = array_merge($maindata, $main);


            // $this->load->helper('html');
            // $this->load->view('header');
            // $this->load->view('jamabandi/save_jamabandi_by_selecting_pattano', $main);
        } else {
            echo "no jamabandi found";
        }
        //$this->load->view('footer');


        $main['_view'] = 'jamabandi/save_jamabandi_by_selecting_pattano';
        $this->load->view('layouts/main',$data);
    }

    public function regenerate_notice() {
		  $db=  $this->session->userdata('db');
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/Boofficeconversion/regenerate_notice_form');
        // $this->load->view('../views/footer');

        $data['_view'] = 'Boofficeconversion/regenerate_notice_form';
        $this->load->view('layouts/main',$data);

    }

    public function regenerate_notice_result() {
		  $db=  $this->session->userdata('db');
        //var_dump($this->input->post());
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $category = $this->input->post('category');
        $case_no = $this->input->post('case_no');
        $data['case_no'] = $case_no;
        //echo $case_no;

        if ($category == '1') { //1 = Notice Generation for Petitioners and Concerned Parties
            $query = "select count(*) as c from    petition_basic where case_no='$case_no' and not_fresh = 'Y' and user_code = '$user_code' and status = 'P' and mut_type = '01' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
            $count = $this->db->query($query)->row()->c;
            //echo $query;
            //exit();
            if ($count > 0) {
                redirect(base_url() . "index.php/BranchOfficerConversion/notice_ree_generation?case_no=" . $case_no . "");
            } else {
                $data['_view'] = 'Boofficeconversion/notice_not_available';
                $this->load->view('layouts/main',$data);
                // $this->load->helper('html');
                // $this->load->view('../views/header');
                // $this->load->view('../views/Boofficeconversion/notice_not_available', $data);
                // $this->load->view('../views/footer');
            }
        } else { //0 = Notice Generation for payment of Premium
            $query = "select count(*) as c from    petition_basic where case_no='$case_no' and not_fresh = 'Y' and status = 'P' and user_code = '$user_code' and mut_type = '01' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
            $count = $this->db->query($query)->row()->c;
            //echo $query;
            //exit();
            if ($count > 0) {
                redirect(base_url() . "index.php/BranchOfficerConversion/notice_ree_premium?case_no=" . $case_no . "");
            } else {
                $data['_view'] = 'Boofficeconversion/notice_not_available';
                $this->load->view('layouts/main',$data);
            }
        }
    }

    public function notice_ree_generation() {
		  $db=  $this->session->userdata('db');
        $dist_code1 = $this->session->userdata('dist_code');
        $subdiv_code1 = $this->session->userdata('subdiv_code');
        $cir_code1 = $this->session->userdata('cir_code');
        $data = array();
        $case_no = $this->input->get('case_no');
        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' "
                        . "and dist_code='$dist_code1' and subdiv_code='$subdiv_code1' and cir_code='$cir_code1'")->row();

        $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,date_entry,add_off_desig,add_off_name,next_date_of_hearing"
                        . " from    petition_basic where case_no='$case_no' "
                        . "and dist_code='$dist_code1' and subdiv_code='$subdiv_code1' and cir_code='$cir_code1'")->row_array();


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
        
        $designation = $this->db->query("select user_desig_as as user_designation from    master_user_designation where user_desig_code='".$location['add_off_desig']."'")->row()->user_designation;
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
            'case_no' => $case_no,
            'next_date_of_hearing' => $location['next_date_of_hearing']
        );
        $convertion_code = CONVERSION_CODE;
        $data['conv_type'] = $this->db->query("select order_type from    master_office_mut_type "
                        . " where order_type_code='$convertion_code'")->row()->order_type;

        $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from    petition_dag_details where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'")->row_array();
        //var_dump($landdetails);
        //echo $landdetails['dag_no'];
        $data['land_details'] = array(
            'dag' => $landdetails['dag_no'],
            'm_dag_area_b' => $landdetails['m_dag_area_b'],
            'm_dag_area_k' => $landdetails['m_dag_area_k'],
            'm_dag_area_lc' => $landdetails['m_dag_area_lc'],
            'patta_no' => trim($landdetails['patta_no']),
            'patta_type' => $landdetails['patta_type_code']
        );

        $data['patta_type'] = $this->db->query("select patta_type from    patta_code "
                        . " where type_code='$landdetails[patta_type_code]'")->row()->patta_type;

        $patta_no = trim($landdetails['patta_no']);
        $pattadardetails = $this->db->query("select * from    petitioner_part where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and dag_no='$landdetails[dag_no]' and TRIM(patta_no)='$patta_no' and patta_type_code= '$landdetails[patta_type_code]'")->result();

        $data['pattadar'] = $pattadardetails;
        $data['pattadar1'] = $pattadardetails;
        $data['pattadar2'] = $pattadardetails;
        //var_dump($data);
        // $this->load->view('../views/header');
        // $this->load->view('../views/Boofficeconversion/ree_notice_generation_conversion', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'Boofficeconversion/ree_notice_generation_conversion';
        $this->load->view('layouts/main',$data);
    }

    public function notice_ree_premium() {
		  $db=  $this->session->userdata('db');
        $dist_code1 = $this->session->userdata('dist_code');
        $subdiv_code1 = $this->session->userdata('subdiv_code');
        $cir_code1 = $this->session->userdata('cir_code');
        $data = array();
        $case_no = $this->input->get('case_no');
        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' "
                        . "and dist_code='$dist_code1' and subdiv_code='$subdiv_code1' and cir_code='$cir_code1'")->row();
        $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,add_off_desig,date_entry,add_off_name,next_date_of_hearing,sk_comment"
                        . " from    petition_basic where case_no='$case_no' "
                        . "and dist_code='$dist_code1' and subdiv_code='$subdiv_code1' and cir_code='$cir_code1'")->row_array();

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
        
        $designation = $this->db->query("select user_desig_as as user_designation from    master_user_designation where user_desig_code='".$location['add_off_desig']."'")->row()->user_designation;
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

        $pattadardetails = "select pdar_name,pdar_guardian,pdar_rel_guar,pdar_add1,pdar_add2 from    petitioner_part where dist_code=? and subdiv_code=? and cir_code=? and lot_no=? and vill_townprt_code=? and mouza_pargona_code=? and petition_no=? and dag_no=? and TRIM(patta_no)=? and patta_type_code= ?";
        $data['pattadar'] = $this->db->query($pattadardetails, [$petition_basic->dist_code, $petition_basic->subdiv_code, $petition_basic->cir_code, $petition_basic->lot_no, $petition_basic->vill_townprt_code, $petition_basic->mouza_pargona_code, $petition_basic->petition_no, $landdetails['dag_no'], trim($landdetails['patta_no']), $landdetails['patta_type_code']])->result();
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
            'premium_new_yn' => $lm_details['premium_new_yn']
        );
        
        // $this->load->view('../views/header');
        // $this->load->view('../views/Boofficeconversion/ree_notice_for_premium', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'Boofficeconversion/ree_notice_for_premium';
        $this->load->view('layouts/main',$data);
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
                            'remark'=>'Case Rejected'
                );
                $this->dbb->where('case_no',$case_no);
                $this->dbb->update('dashboard_data',$base);
                $action= array(
                    'case_no' => $case_no,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_of_action_taken' => date('Y-m-d'),
                    'user_designation' => $this->session->userdata('user_desig_code'),
                    'remark' => 'Rejected',
                     );
                $this->dbb->insert('dashboard_action',$action);
    }
    /////////////2022-05-03///////////////
    function cancelPremium(){
        $case_no = $this->input->get('case_no');
        $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'BO', $case_no);
        if($authorization['status'] == 'n') {
            //ERRCONVBOCANCPREM0001
            log_message('error', $authorization['messages'] . '. Error: ERRCONVBOCANCPREM0001');
            $this->session->set_flashdata('message', $authorization['messages'].'. Error: ERRCONVBOCANCPREM0001');
            redirect(base_url('index.php/home'));
        }
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
                    'status'=> 'P',
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
                $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
                if($basundhara){
                    $caseRtpsBasu=$this->checkRtpsService($basundhara);
                    if($caseRtpsBasu=='RTPS'){
                        $apilink=RTPS_API_LINK;
                    }
                    else{
                        $apilink=API_LINK;
                    }
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
            $this->session->set_flashdata('message', "Premium Notice on Conversion is cancelled for Case no # $case_no");
            redirect(base_url() . "index.php/home");
        }else{
            $this->session->set_flashdata('message', "Case no # $case_no not found ... Please try again");
            redirect(base_url() . "index.php/home");
        }   
    }
    ///////////////////////////

}
