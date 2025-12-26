    <?php
    class LandReclassification extends CI_Controller {

        public function __construct() {
            parent::__construct();
            $this->load->model('mutation/mutationmodel');
            $this->load->model('conversion/ASTofficeConversionModel');
            $this->load->model('conversion/COofficeConversionModel');
            $this->load->model('UtilsModel');
            $this->load->model('rtps/rtpsmodel');
            $this->load->helper(array('form', 'url'));
            $this->load->model('Escalationmodel');
            $this->load->model('basundhara/basundharamodel');
            $this->load->model('AgriStackCaseHistory');
			$location = $this->utilityclass->getLocationFromSession();
            $dist_code = $location['dist_code'];
            $subdiv_code = $location['subdiv_code'];
            $cir_code = $location['cir_code'];
            $db=  $this->session->userdata('db');
            $this->base_query = "dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and  cir_code = '$cir_code' ";
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


        public function LMlocationSelect() {
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
            $this->session->set_userdata(array('end' => false));

            $data = $this->mutationmodel->getVillageCodeJSON($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
            $district['villages'] = $data;

            $district['_view'] = 'LandReclassification/LMlocationSelect';
            $this->load->view('layouts/main',$district);
        }

        public function LMConvertionType() {
            // $dist_code = $this->input->post('dist_code');
            // $subdiv_code = $this->input->post('subdiv_code');
            // $cir_code = $this->input->post('circle_code');
            // $lot_no = $this->input->post('lot_no');
            // $mouza_pargona_code = $this->input->post('mouza_code');
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
            $lot_no = $this->session->userdata('lot_no');
            $vill_code = $this->input->post('vill_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');

            $villages_arr = $this->mutationmodel->getVillageCodeJSON($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
            if(!count($villages_arr)){
                $this->session->set_flashdata('message', "No villages found");
                return redirect($_SERVER['HTTP_REFERER']);
            }
            $village_ids = array_column($villages_arr, 'vill_townprt_code');
            if(!in_array($vill_code, $village_ids)){
                $this->session->set_flashdata('message', "Village/Town is invalid.");
                return redirect($_SERVER['HTTP_REFERER']);
            }

            $this->session->set_userdata(array('dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'lot_no' => $lot_no,
                'vill_code' => $vill_code,
                'mouza_pargona_code' => $mouza_pargona_code));


            $land_class_agri = "Select * from landclass_code where class_code_cat = '01'";
            $convertion['land_class_agri'] = $this->db->query($land_class_agri)->result();
            
            $land_class_non_agri = "Select * from landclass_code where class_code_cat = '02'";
            $convertion['land_class_non_agri'] = $this->db->query($land_class_non_agri)->result();

            $convertion['type'] = $this->mutationmodel->getConvertionPattaType();
            // $this->load->view('../views/header');
            // $this->load->view('../views/LandReclassification/LMlandclassregister', $convertion);
            // $this->load->view('../views/footer');
            $convertion['_view'] = 'LandReclassification/LMlandclassregister';
            $this->load->view('layouts/main',$convertion);
        }

        public function getDagDetJSON($dag_no) {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_code = $this->session->userdata('vill_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');

            $data = $this->db->query("select * from chitha_basic join landclass_code on landclass_code.class_code=chitha_basic.land_class_code where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_code' and dag_no='$dag_no' and landclass_code.class_code_cat='02'");
            $landarea = $data->result();

            echo json_encode($landarea, JSON_UNESCAPED_UNICODE);
        }
        
        public function getDagDetJSONForBacklog($dag_no, $mouzaselect, $lotselect, $villageselect) {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');

            $data = $this->db->query("select * from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    . "mouza_pargona_code = '$mouzaselect' and lot_no = '$lotselect' and vill_townprt_code = '$villageselect' and dag_no='$dag_no'");
            $landarea = $data->result();

            echo json_encode($landarea, JSON_UNESCAPED_UNICODE);
        }

        public function getPattaNameJSON($patta_code) {
            $data1 = $this->db->query("select * from patta_code where type_code = '$patta_code'");
            $data = $data1->result();
            $json = array();
            foreach ($data as $object) {
                $json[] = array('type_code' => $object->type_code, 'patta_type' => $object->patta_type);
            }
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
        }

        public function getLandClassNameJSON($land_class_code) {
            $data2 = $this->db->query("select * from landclass_code where class_code = '$land_class_code'");
            $data = $data2->result();
            $json1 = array();
            foreach ($data as $object) {
                $json1[] = array('class_code' => $object->class_code, 'land_type' => $object->land_type);
            }
            echo json_encode($json1, JSON_UNESCAPED_UNICODE);
        }

        public function saveReclasificationDetails() {

            $allowed = ['LM'];
            $user_desig_code = $this->session->userdata('user_desig_code');

            // Restrict access if not in allowed list
            if ( ! in_array($user_desig_code, $allowed)) {
                echo json_encode(['error' => 'Unauthorized access']);
                exit; // or die();
            }
            $this->db->trans_begin();

            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_code = $this->session->userdata('vill_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $year_no = year_no;
            $define_date = define_date;
            $case_name=$this->basundharamodel->genearteCaseName();
           // $case_no['petition_no']=$petition_no=$this->basundharamodel->genearteReclassPetitionNo();
           // $case_no=$case_name.$petition_no."/RECLASS";


            $seq_pet=year_no.'0';
            $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteReclassPetitionNo();
            $case_no['case_no']=$case_no=$case_name.$petition_no."/RECLASS";
            
            $t_reclassification = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_code,
                'proposal_no' => $petition_no,
                'dag_no' => $this->input->post('dag_no'),
                'patta_no' => trim($this->input->post('patta_no')),
                'patta_type_code' => $this->input->post('patta_type'),
                'present_land_class' => $this->input->post('land_class'),
                'present_land_revenue' => $this->input->post('land_rev'),
                'present_land_localtax' => $this->input->post('loc_tax'),
                'present_total_revenue' => $this->input->post('tot_rev'),
                'new_landuse_year' => $this->input->post('new_landuse_year'),
                'dag_area_b' => $this->input->post('dag_area_b'),
                'dag_area_k' => $this->input->post('dag_area_k'),
                'dag_area_lc' => $this->input->post('dag_area_lc'),
                'dag_area_g' => $this->input->post('dag_area_g'),
                'dag_area_kr' => $this->input->post('dag_area_kr'),
                'proposed_land_class' => $this->input->post('new_land_class'),
                'proposed_land_revenue' => $this->input->post('P_land_rev'),
                'proposed_land_localtax' => $this->input->post('p_local_tax'),
                'revenue_diff' => $this->input->post('Rev_diff'),
                'lm_code' => $this->session->userdata('user_code'),
                'lm_yn' => 'Y',
                'lm_date' => date('Y-m-d G:i:s'),
                'case_no' => $case_no,
                'year_no' => $year_no
            );
            //var_dump($t_reclassification);
            $this->db->insert('t_reclassification', $t_reclassification);

            $data['case_no'] = $case_no;

              
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo "Error Occured";
            } else {
                $this->db->trans_commit();
                $this->Dashboard($case_no);
                $data['_view'] = 'LandReclassification/test_first';
                $this->load->view('layouts/main',$data);
            }
        }
        
        public function getLandClassNameAgriJSON($land_class_code) {
            $data2 = $this->db->query("select * from landclass_code where class_code = '$land_class_code'");
            $data = $data2->result();
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }

        public function GoToREOLDD() {
            $process = $this->input->get('pro');
             $user_desig = $this->session->userdata('user_desig_code');
            $user_code = $this->session->userdata('user_code');
            if ($process == '1') {
                $config['total_rows'] = $this->COofficeConversionModel->countPendingLandReclassificationProposals();
                $cases['cases'] = $this->COofficeConversionModel->getPendingLandReclassificationProposals()->result();
            } elseif ($process == '2') {
                $config['total_rows'] = $this->COofficeConversionModel->countGenerateTransmissionForDC();
                $cases['cases'] = $this->COofficeConversionModel->getPendingGenerateTransmissionForDC()->result();
            } elseif (($process == '3')&&($user_desig !='DC')) {
                $config['total_rows'] = $this->COofficeConversionModel->countPendingLandReclassificationDC();
                $cases['cases'] = $this->COofficeConversionModel->getPendingLandReclassificationDC()->result();
            } 
            elseif (($process=='3')&&($user_desig =='DC')) {
            
                $config['total_rows'] = $this->COofficeConversionModel->countPendingLandReclassificationDCReal();
                $cases['cases'] = $this->COofficeConversionModel->getPendingLandReclassificationDCReal()->result();
            }
            elseif ($process == '4') {
                $config['total_rows'] = $this->COofficeConversionModel->countApprovedLandReclassification();
                $cases['cases'] = $this->COofficeConversionModel->getApprovedLandReclassification()->result();
            } elseif ($process == '5') {
                $config['total_rows'] = $this->COofficeConversionModel->countGenerateTransmissionForCO();
                $cases['cases'] = $this->COofficeConversionModel->getPendingGenerateTransmissionForCO()->result();
            } elseif ($process == '6') {
                $config['total_rows'] = $this->COofficeConversionModel->countRevertedBackFromDC();
                $cases['cases'] = $this->COofficeConversionModel->getPendingRevertedBackFromDC()->result();
            } elseif ($process == '7') {
                $config['total_rows'] = $this->COofficeConversionModel->countJamaupdatereclass();
                $cases['cases'] = $this->COofficeConversionModel->getJamaupdatereclass()->result();
            } elseif ($process == '8') {
                $config['total_rows'] = $this->COofficeConversionModel->countRevertedPending();
                $cases['cases'] = $this->COofficeConversionModel->getRevertedPending()->result();
            }
            
             elseif ($process == '10') {
                 //echo "hello";
                $config['total_rows'] = $this->COofficeConversionModel->countRejectedCasesfromADC();
                $cases['cases'] = $this->COofficeConversionModel->getRejectedCasesfromADC()->result();
            }

             elseif ($process == '11') {
                $config['total_rows'] = $this->COofficeConversionModel->countRevertedBackFromDC();
                $cases['cases'] = $this->COofficeConversionModel->getPendingRevertedBackFromCO()->result();
            }
            $cases['process'] = $process;
            $cases['_view'] = 'LandReclassification/Land_reclasification_cases';
            $this->load->view('layouts/main',$cases);
        }

        public function GoToRE() {
            $process = $this->input->get('pro');
             $user_desig = $this->session->userdata('user_desig_code');
            $user_code = $this->session->userdata('user_code');
            if ($process == '1') {
                 $allowed = ['CO'];
                $user_desig_code = $this->session->userdata('user_desig_code');

                // Restrict access if not in allowed list
                if ( ! in_array($user_desig_code, $allowed)) {
                    echo json_encode(['error' => 'Unauthorized access']);
                    exit; // or die();
                }

                $config['total_rows'] = $this->COofficeConversionModel->countPendingLandReclassificationProposals();
                $cases['cases'] = $this->COofficeConversionModel->getPendingLandReclassificationProposals()->result();

                foreach($cases['cases'] as $rows){
                    if($rows->es_flag == '1' && ESCALATION_ENABLE == 1 && $rows->out_of_esc == 0){
                        $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);
                        log_message('error', '#258: Escalation details : '.json_encode($escRow));
                        if(!empty($escRow) && $escRow != null){
                            $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->co_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry));
                            log_message('error', '#262: Escalation details : '.json_encode($escData));
                            if(!empty($escData) && $escData != null){
                                $rows->escalation_date = $escData->escalation_date;
                                $rows->escalation_zone = $escData->escalation_zone;
                                $rows->assigned_date   = $escData->assigned_date;
                            }
                            else {
                                $rows->escalation_date = 'NA';
                                $rows->escalation_zone = 'NA';
                            }
                        }
                        else {
                            $rows->escalation_date = 'NA';
                            $rows->escalation_zone = 'NA';
                        }
                    }
                    else {
                        $rows->escalation_date = 'NA';
                        $rows->escalation_zone = 'NA';
                    }
                }
            } elseif ($process == '2') {
                $config['total_rows'] = $this->COofficeConversionModel->countGenerateTransmissionForDC();
                $cases['cases'] = $this->COofficeConversionModel->getPendingGenerateTransmissionForDC()->result();
            } elseif (($process == '3')&&($user_desig !='DC')) {
                $config['total_rows'] = $this->COofficeConversionModel->countPendingLandReclassificationDC();
                $cases['cases'] = $this->COofficeConversionModel->getPendingLandReclassificationDC()->result();
                foreach($cases['cases'] as $rows){
                    if($rows->es_flag == '1' && ESCALATION_ENABLE == 1 && $rows->out_of_esc == 0){
                        $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);
                        // log_message('error', '#297: Escalation Row : '.json_encode($escRow));
                        if(!empty($escRow) && $escRow != null){
                            $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->adc_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry));
                            // log_message('error', '#301: Escalation details : '.json_encode($escData));
                            if(!empty($escData) && $escData != null){
                                $rows->escalation_date = $escData->escalation_date;
                                $rows->escalation_zone = $escData->escalation_zone;
                                $rows->assigned_date   = $escData->assigned_date;
                            }
                            else {
                                $rows->escalation_date = 'NA';
                                $rows->escalation_zone = 'NA';
                            }
                        }
                        else {
                            $rows->escalation_date = 'NA';
                            $rows->escalation_zone = 'NA';
                        }
                    }
                    else {
                        $rows->escalation_date = 'NA';
                        $rows->escalation_zone = 'NA';
                    }
                }
            } 
            elseif (($process=='3')&&($user_desig =='DC')) {
            
                $config['total_rows'] = $this->COofficeConversionModel->countPendingLandReclassificationDCReal();
                $cases['cases'] = $this->COofficeConversionModel->getPendingLandReclassificationDCReal()->result();

                foreach($cases['cases'] as $rows)
                {
                    if($rows->es_flag == '1' && ESCALATION_ENABLE == 1 && $rows->out_of_esc == 0)
                    {
                        $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);
                        // log_message('error', '#297: Escalation Row : '.json_encode($escRow));
                        if(!empty($escRow) && $escRow != null){
                            $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->dc_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry));
                            // log_message('error', '#301: Escalation details : '.json_encode($escData));
                            if(!empty($escData) && $escData != null){
                                $rows->escalation_date = $escData->escalation_date;
                                $rows->escalation_zone = $escData->escalation_zone;
                                $rows->assigned_date   = $escData->assigned_date;
                            }
                            else {
                                $rows->escalation_date = 'NA';
                                $rows->escalation_zone = 'NA';
                            }
                        }
                        else {
                            $rows->escalation_date = 'NA';
                            $rows->escalation_zone = 'NA';
                        }
                    }
                    else {
                        $rows->escalation_date = 'NA';
                        $rows->escalation_zone = 'NA';
                    }
                }
            }
            elseif ($process == '4') {
                $config['total_rows'] = $this->COofficeConversionModel->countApprovedLandReclassification();
                $cases['cases'] = $this->COofficeConversionModel->getApprovedLandReclassification()->result();
            } elseif ($process == '5') {
                $config['total_rows'] = $this->COofficeConversionModel->countGenerateTransmissionForCO();
                $cases['cases'] = $this->COofficeConversionModel->getPendingGenerateTransmissionForCO()->result();
            } elseif ($process == '6') {
                $allowed = ['CO'];
                $user_desig_code = $this->session->userdata('user_desig_code');

                // Restrict access if not in allowed list
                if ( ! in_array($user_desig_code, $allowed)) {
                    echo json_encode(['error' => 'Unauthorized access']);
                    exit; // or die();
                }
                $config['total_rows'] = $this->COofficeConversionModel->countRevertedBackFromDC();
                $cases['cases'] = $this->COofficeConversionModel->getPendingRevertedBackFromDC()->result();

            foreach($cases['cases'] as $rows)
            {
                if($rows->es_flag == '1' && ESCALATION_ENABLE == 1 && $rows->out_of_esc == 0){
                    $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);
                    // log_message('error', '#258: Escalation details : '.json_encode($escRow));
                    if(!empty($escRow) && $escRow != null){
                        $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->co_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry));
                        // log_message('error', '#262: Escalation details : '.json_encode($escData));
                        if(!empty($escData) && $escData != null){
                            $rows->escalation_date = $escData->escalation_date;
                            $rows->escalation_zone = $escData->escalation_zone;
                            $rows->assigned_date   = $escData->assigned_date;
                        }
                        else {
                            $rows->escalation_date = 'NA';
                            $rows->escalation_zone = 'NA';
                        }
                    }
                    else {
                        $rows->escalation_date = 'NA';
                        $rows->escalation_zone = 'NA';
                    }
                }
                else {
                    $rows->escalation_date = 'NA';
                    $rows->escalation_zone = 'NA';
                }
            }

                
            } elseif ($process == '7') {
                $config['total_rows'] = $this->COofficeConversionModel->countJamaupdatereclass();
                $cases['cases'] = $this->COofficeConversionModel->getJamaupdatereclass()->result();
            } elseif ($process == '8') {
                $config['total_rows'] = $this->COofficeConversionModel->countRevertedPending();
                $cases['cases'] = $this->COofficeConversionModel->getRevertedPending()->result();
            }
            
            elseif ($process == '10') {
                 //echo "hello";
                $config['total_rows'] = $this->COofficeConversionModel->countRejectedCasesfromADC();
                $cases['cases'] = $this->COofficeConversionModel->getRejectedCasesfromADC()->result();
            }

            elseif ($process == '11') {
                $config['total_rows'] = $this->COofficeConversionModel->countRevertedBackFromDC();
                $cases['cases'] = $this->COofficeConversionModel->getPendingRevertedBackFromCO()->result();

                foreach($cases['cases'] as $rows)
                {
                    if($rows->es_flag == '1' && ESCALATION_ENABLE == 1 && $rows->out_of_esc == 0)
                    {
                        $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);
                        // log_message('error', '#258: Escalation details : '.json_encode($escRow));

                        if(!empty($escRow) && $escRow != null)
                        {
                            $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->lm_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry));
                            // log_message('error', '#262: Escalation details : '.json_encode($escData));

                            if(!empty($escData) && $escData != null)
                            {
                                $rows->escalation_date = $escData->escalation_date;
                                $rows->escalation_zone = $escData->escalation_zone;
                                $rows->assigned_date   = $escData->assigned_date;
                            }
                            else 
                            {
                                $rows->escalation_date = 'NA';
                                $rows->escalation_zone = 'NA';
                            }
                        }
                        else 
                        {
                            $rows->escalation_date = 'NA';
                            $rows->escalation_zone = 'NA';
                        }
                    }
                    else 
                    {
                        $rows->escalation_date = 'NA';
                        $rows->escalation_zone = 'NA';
                    }
                }




            }
            $cases['process'] = $process;
            $cases['_view'] = 'LandReclassification/Land_reclasification_cases';
            $this->load->view('layouts/main',$cases);
        }

        Public function FirstCoProcess() {

            $allowed = ['CO'];
            $user_desig_code = $this->session->userdata('user_desig_code');

            // Restrict access if not in allowed list
            if ( ! in_array($user_desig_code, $allowed)) {
                echo json_encode(['error' => 'Unauthorized access']);
                exit; // or die();
            }

            $user_code = $this->session->userdata('user_code');
            $case_no = $this->input->GET('case_no');
            $caseNoValidate = caseNumberValidation($case_no);
            if(count($caseNoValidate)){
                show_error($caseNoValidate['message'], 401);
                return;
            }

            $response = isValidQuery($case_no);
            if($response['status'] == 'n'){
                show_error('MALECIOUS QUERY in Case no', 401);
                return;
            }
            // $application_no=$this->input->GET('application_no');
            $proposal_no = $this->input->GET('proposal_no');
            $proposanNoValidate = proposalNumberValidation($proposal_no);
            if(count($proposanNoValidate)){
                show_error($proposanNoValidate['message'], 401);
                return;
            }

            $response = isValidQuery($proposal_no);
            if($response['status'] == 'n'){
                show_error('MALECIOUS QUERY in Proposal no', 401);
                return;
            }

            $q = "select * from t_reclassification where case_no =? and proposal_no =?";
            $details = $this->db->query($q, array($case_no, $proposal_no))->row();
            
            if(!$details){
                log_message('error', '#ERRTRECLASS10002: Data not found in t_reclassification table for proposal_no = ' . $proposal_no . ' and case_no = '. $case_no);
                show_error('#ERRTRECLASS10002: No such data found', 404);
                return;
            }
            
            $old_patta = $this->db->query("select * from patta_code where type_code =?", array($details->patta_type_code))->row();
            $old_land_class = $this->db->query("select * from landclass_code where class_code =?", array($details->present_land_class))->row();
            $proposed_land_class = $this->db->query("select * from landclass_code where class_code =?", array($details->proposed_land_class))->row();

            if(!$old_patta){
                log_message('error', '#ERRRECLASS10003: Data not found in patta_code table for type_code = ' . $details->patta_type_code);
                show_error('#ERRRECLASS10003: Patta detail is not found', 401);
                return;
            }
            if(!$old_land_class){
                log_message('error', '#ERRRECLASS10004: Data not found in landclass_code table for class_code = ' . $details->present_land_class);
                show_error('#ERRRECLASS10004: Land detail is not found', 401);
                return;
            }
            if(!$proposed_land_class){
                log_message('error', '#ERRRECLASS10005: Data not found in landclass_code table for class_code = ' . $details->proposed_land_class);
               // show_error('#ERRRECLASS10005: Proposed detail is not found.');
               // return;
            }

            $dist_code = $this->utilityclass->getDistrictName($details->dist_code);
            $subdiv_code = $this->utilityclass->getSubDivName($details->dist_code, $details->subdiv_code);
            $cir_code = $this->utilityclass->getCircleName($details->dist_code, $details->subdiv_code, $details->cir_code);
            $mouza_pargona_code = $this->utilityclass->getMouzaName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code);
            $lot_no = $this->utilityclass->getLotName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no);
            $vill_townprt_code = $this->utilityclass->getVillageName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no, $details->vill_townprt_code);
            
            $co = $this->utilityclass->getSelectedCOName($details->dist_code, $details->subdiv_code, $details->cir_code, $user_code);
            $data['location'] = array(
                'dist' => $dist_code,
                'sub' => $subdiv_code,
                'cir' => $cir_code,
                'mouza' => $mouza_pargona_code,
                'lot' => $lot_no,
                'vill' => $vill_townprt_code,
                'co_name' => $co->username
            ); 
            
            $data['det'] = array(
                'patta_type' => $old_patta->patta_type,
                'old_land_class' => $old_land_class->land_type,
                'proposed_land_class' => $proposed_land_class->land_type,
                'proposed_land_class_code' => $details->proposed_land_class
            );
            
            $all_land_class = "Select * from landclass_code";
            $data['land_class'] = $this->db->query($all_land_class)->result();

            $data['Pcases'] = $details;

            $lmnote="select * from petition_proceeding_dc_adc where case_no=? and user_code like 'M%' order by proceeding_id desc";
            $data['lmrmk']= $this->db->query($lmnote, array($case_no))->row();
            $data['sup_doc']=null;
            $data['sup_doc']=$this->db->query("SELECT * FROM supportive_document WHERE case_no=?", array($case_no))->result();


            $application_no="select * from basundhar_application where dharitree=?";
            $data['app'] = $this->db->query($application_no, array($case_no))->row();

            $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
            if($basundhara){
                $rtps=$this->rtpsmodel->checkBasundharaService($case_no);
                if($rtps=='RTPS'){
                    $data['basundharaAttachment']=$this->rtpsmodel->searchBasundharaLink($case_no);
                    $data['basundharaApp']=$this->rtpsmodel->searchBasundharaLinkApp($case_no);
                }else{
                    $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
                    $data['basundharaApp']=$this->basundharamodel->searchBasundharaLinkApp($case_no);
                }
            }



            //////////////////////////////////////////////////////////////// Property Chain Code //////////////////////////////////////////////
            if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
            {
            $this->load->model('propChain/PropChainModel');

            //////////////////////////////////////////////////////////////// Property Chain Code //////////////////////////////////////////////

            $data['propChainEnableFlag'] = $this->PropChainCommonModel->isLocationEnable($details->dist_code,
                $details->subdiv_code,
                $details->cir_code,
                $details->mouza_pargona_code,
                $details->lot_no,
                $details->vill_townprt_code);

            $chainChithaCheck = $this->PropChainModel->chainChithaUlpinCheckProcess(
                $details->dist_code,
                $details->subdiv_code,
                $details->cir_code,
                $details->mouza_pargona_code,
                $details->lot_no,
                $details->vill_townprt_code,
                $details->patta_no,
                $details->dag_no,
                $details->dag_area_b,
                $details->dag_area_k,
                $details->dag_area_lc,
                $details->dag_area_g,
                $details->patta_type_code
            );

            // var_dump($chainChithaCheck);
            // die;
            if ($chainChithaCheck['chithaPropChainCmpFlag'] == 'Y' || $chainChithaCheck['chithaPropChainCmpFlag'] == 'N' || $chainChithaCheck['chithaPropChainCmpFlag'] == 'NE') {
                $this->PropChainModel->updateCmpFlag($case_no, $chainChithaCheck['chithaPropChainCmpFlag']);
                // get view mismatch case button
                if ($chainChithaCheck['chithaPropChainCmpFlag'] == 'N') {
                    $data['mismatchBtn'] = $this->PropChainModel->getMismatchBtn(
                        $case_no,
                        $details->dist_code,
                        $details->subdiv_code,
                        $details->cir_code,
                        $details->mouza_pargona_code,
                        $details->lot_no,
                        $details->vill_townprt_code,
                        $details->patta_no,
                        $details->dag_no,
                        $details->dag_area_b,
                        $details->dag_area_k,
                        $details->dag_area_lc,
                        $details->dag_area_g,
                        $details->patta_type_code
                    );
                }
            }

            $data['ulpinCheck'] = $chainChithaCheck['ulpinCheck'];
            $data['ulpinMsg'] = $chainChithaCheck['ulpinMsg'];

            if ($data['ulpinCheck'] == 1) {
                $data['ulpin'] = $chainChithaCheck['ulpin'];
                if (isset($chainChithaCheck['old_ulpin']))
                    $data['old_ulpin'] = $chainChithaCheck['old_ulpin'];
                else
                    $data['old_ulpin'] = "";
            }

            // $data['chithaPropChainCmpFlag'] = $chainChithaCheck['chithaPropChainCmpFlag'];
            // $data['compareFlagMsg'] = $chainChithaCheck['compareFlagMsg'];

            $data['chithaPropChainCmpFlag'] = $chainChithaCheck['chithaPropChainCmpFlag'];
            $data['compareFlagMsg'] = $chainChithaCheck['compareFlagMsg'];
            $data['revenue'] = $chainChithaCheck['revenue'];
            $data['local_tax'] = $chainChithaCheck['local_tax'];

            if ($chainChithaCheck['chithaPropChainCmpFlag'] == 'NE')
                $data['createPropChainBtn'] = $chainChithaCheck['createPropChainBtn'];

            // hidden fields
            $data['ulpin_hidden'] = $chainChithaCheck['ulpin_hidden'];
            $data['uplpin_msg_hidden'] = $chainChithaCheck['uplpin_msg_hidden'];
            $data['compare_hidden'] = $chainChithaCheck['compare_hidden'];
            $data['compare_msg_hidden'] = $chainChithaCheck['compare_msg_hidden'];

            // bhunaksha area cmp
            $data['bhuChithaCmpStatus'] = $chainChithaCheck['bhuChithaCmpStatus'];
            $data['bhuChithaCmpMsg'] = $chainChithaCheck['bhuChithaCmpMsg'];
            $data['bhu_hidden'] = $chainChithaCheck['bhu_hidden'];
            $data['bhu_compare_msg_hidden'] = $chainChithaCheck['bhu_compare_msg_hidden'];
           }

            //ESCALATED CASES REMARK ENTRY FORM==============
            if(ESCALATION_ENABLE == 1 && ESCALATION_REMARK_ENABLE == 1 && $details->es_flag == 1 && $details->out_of_esc == 0)
            {
                $remainingTime = $this->Escalationmodel->calculateRemainingTime($case_no,$this->session->userdata('user_desig_code'));
                $data['remainingTime'] = $remainingTime;
                $escRemarkData = $this->Escalationmodel->getEscalationRemarkDetails($case_no,$this->session->userdata('user_desig_code'),$this->session->userdata('user_code'));
                if(isset($escRemarkData) && !empty($escRemarkData))
                {
                    $data['escRemarkData'] = $escRemarkData;
                }
            }
            ///END REMARKS///////// 

            $data['adc'] = $this->db->query("Select users.username as username, users.user_desig_code as user_desig_code, loginuser_table.user_code as user_code from    users, "
                        . "loginuser_table where users.dist_code = loginuser_table.dist_code and users.user_code = loginuser_table.user_code and users.user_desig_code like 'ADC%' and "
                        . "loginuser_table.dist_code='$details->dist_code' and loginuser_table.subdiv_code='00' and loginuser_table.cir_code='00' and loginuser_table.dis_enb_option = 'E' and loginuser_table.priv = 'adm'")->result();

            $params = [
              'case_no'          => $case_no,
              'service_code'     => 4,
              'remarks'          => 'Reclassification',
              'accessed_entity'  => 'Aadhaar Status Checked',
            ];
            $this->load->model('EkycLogModel');
            $log = $this->EkycLogModel->insertEkycAccessedBy($this->db, $params);


            $data['_view'] = 'LandReclassification/FirstCoProcess';
            $this->load->view('layouts/main',$data);
        }

        public function SaveCoProcess() {

            $allowed = ['CO'];
            $user_desig_code = $this->session->userdata('user_desig_code');

            // Restrict access if not in allowed list
            if ( ! in_array($user_desig_code, $allowed)) {
                echo json_encode(['error' => 'Unauthorized access']);
                exit; // or die();
            }

            $user_dist_code = $this->session->userdata('dist_code');
            $user_subdiv_code = $this->session->userdata('subdiv_code');
            $user_cir_code = $this->session->userdata('cir_code');
            $co_code = $this->session->userdata('user_code');
            $user_desig_code = $this->session->userdata('user_desig_code');
            $proposed_land_revenue = $this->input->post('P_land_rev');
            // $proposed_land_localtax = $this->input->post('p_local_tax');
            $new_land_class = $this->input->post('new_land_class');
            $co_report1 = $this->input->POST('co_report');
            $case_no = $this->input->POST('case_no');
            $adc_code = $this->input->POST('adc_code');


            if(!in_array($user_desig_code, ['CO'])){
                $this->session->set_flashdata('message', 'You are not authorized to perform this action');
                return redirect($_SERVER['HTTP_REFERER']);
            }
 
            $this->form_validation->set_rules('new_land_class', 'New land class', 'required');
            $this->form_validation->set_rules('P_land_rev', 'Proposed land revenue', 'required|numeric|greater_than[-1]');
            $this->form_validation->set_rules('p_local_tax', 'Proposed local tax', 'required|numeric|greater_than[-1]');
            $this->form_validation->set_rules('co_report', 'Report', 'required|max_length[1000]');
            $this->form_validation->set_rules('case_no', 'Case number', 'required');
            $this->form_validation->set_rules('adc_code', 'ADC code', 'required');

            if ($this->form_validation->run() == FALSE)
            {
                $this->session->set_flashdata('message', validation_errors());
                return redirect($_SERVER['HTTP_REFERER']);
            }
            
            // $error_data_messages_arr = [];
            // $proposal_no = $this->input->POST('proposal_no');
            
            // XSS validation start
            $errorMessageStr = '';
            $resp = checkRequestSpecChar($_POST);
            if($resp['status'] == 'n'){
                $errorMessageStr .= $resp['messages'];
            }

            $resp = checkRequestValidQuery($_POST);
            if($resp['status'] == 'n'){
                $errorMessageStr .= $resp['messages'];
            }

            if($errorMessageStr != ''){
                $this->session->set_flashdata('message', $errorMessageStr);
                return redirect($_SERVER['HTTP_REFERER']);
            }
            // XSS validation end

            // $caseNoValidate = caseNumberValidation($case_no);
            // if(count($caseNoValidate)){
            //     array_push($error_data_messages_arr, $caseNoValidate['message']);
            // }
            
            // $response = specialCharacterCheckingInInput($co_report1, ['.', ',', '|', '-',':','।','\''], 'Report');
            // if($response['status'] == 'n'){
            //     array_push($error_data_messages_arr, $response['message']);
            // }
            
            // $response = specialCharacterCheckingInInput($new_land_class, [], 'New land class');
            // if($response['status'] == 'n'){
            //     array_push($error_data_messages_arr, $response['message']);
            // }
            
            // if(count($error_data_messages_arr)){
            //     $error_messages = convertArrayToHtmlUlLi($error_data_messages_arr);
            //     $this->session->set_flashdata('message', $error_messages);
            //     return redirect($_SERVER['HTTP_REFERER']);
            // }

            // // Malecious checking Start
            // $error_data_messages_arr = [];
            // $response = isValidQuery($case_no);
            // if($response['status'] == 'n'){
            //     array_push($error_data_messages_arr, 'Case number has MALECIOUS QUERY');
            // }

            // $response = isValidQuery($co_report1);
            // if($response['status'] == 'n'){
            //     array_push($error_data_messages_arr, 'Report has MALECIOUS QUERY');
            // }
            
            // $response = isValidQuery($new_land_class);
            // if($response['status'] == 'n'){
            //     array_push($error_data_messages_arr, 'New land class has MALECIOUS QUERY');
            // }
            // // Malecious checking End

            // if(count($error_data_messages_arr)){
            //     $error_messages = convertArrayToHtmlUlLi($error_data_messages_arr);
            //     $this->session->set_flashdata('message', $error_messages);

            //     return redirect($_SERVER['HTTP_REFERER']);
            // }
            
            $proposed_land_localtax = $proposed_land_revenue/4;
            $proposed_land_localtax = round($proposed_land_localtax, 4);

            // Land class checking existance
            $land_class = $this->db->query("Select * from landclass_code where class_code=?", array($new_land_class))->num_rows();
            if($land_class == 0){
                log_message('error', '#ERRLNDCLS00001: New land class not found in the landclass_code table for class_code = ' . $new_land_class);
                $this->session->set_flashdata('message', '#ERRLNDCLS00001: New land class not found');

                return redirect($_SERVER['HTTP_REFERER']);
            }
            
            $basundhara_application = $this->db->query("select * from basundhar_application where dharitree=?", array($case_no))->row();
            // if(!$basundhara_application){
            //     log_message('error', '#ERRBSNDAP00001: No such application found in the basundhar_application table for dharitree = ' . $case_no);
            //     $this->session->set_flashdata('message', '#ERRBSNDAP00001: No such application found');

            //     return redirect($_SERVER['HTTP_REFERER']);
            // }
            
            // if(!in_array($basundhara_application->pending_with, ['CO'])){
            //     log_message('error', '#ERRBSNDAP00002: Application is not pending with CO. Application status is ' . $basundhara_application->pending_with . ' basundhar_application table for dharitree = ' . $case_no);
            //     $this->session->set_flashdata('message', '#ERRBSNDAP00002: Application is not pending with CO.');

            //     return redirect($_SERVER['HTTP_REFERER']);
            // }
            // if($basundhara_application){
            //     if(!in_array($basundhara_application->pending_with, ['CO'])){
            //         log_message('error', '#ERRBSNDAP00002: Application is not pending with CO. Application status is ' . $basundhara_application->pending_with . ' basundhar_application table for dharitree = ' . $case_no);
            //         $this->session->set_flashdata('message', '#ERRBSNDAP00002: Application is not pending with CO.');

            //         return redirect($_SERVER['HTTP_REFERER']);
            //     }
            // }
            
            $details = $this->db->query("select * from t_reclassification where case_no =?", array($case_no))->row();
            if(!$details){
                log_message('error', '#ERRTRECLS10006: No such record found in the t_reclassfication table for case_no = ' . $case_no);
                $this->session->set_flashdata('message', '#ERRTRECLS10006: Something went wrong with the application.');

                return redirect($_SERVER['HTTP_REFERER']);
            }



            //ESCALATION ==============
            if(ESCALATION_ENABLE == 1 && $details->es_flag == 1 && ESCALATION_REMARK_ENABLE == 1 && $details->out_of_esc == 0)
            {

                $responseEsc = $this->Escalationmodel->escalationRemarkCheckandUpdate($case_no,$this->input->post('esc_remark'),$this->session->userdata('user_desig_code'));
                if($responseEsc['responseType'] == 1)
                {
                    $this->db->trans_rollback();
                    $data=array(
                        'error'=>"#ERRESCREMARKRECLASS00111 : Error in submitting in escalation remarks. Please try Again"
                    );
                    echo json_encode($data);
                    return false;
                }

            }
            ///END+==================

            if($details->status == 'A'){
                $this->session->set_flashdata('message', 'This case is already forwarded.');

                return redirect($_SERVER['HTTP_REFERER']);
            }

            /*if(!in_array($details->status, [NULL])){
                log_message('error', '#ERRCSFWD10001: Case doesn\'t belong to the login user for case_no = ' . $case_no . ' as this case\'s status is ' . $details->status);
                $this->session->set_flashdata('message', '#ERRCSFWD10001: This case doesn\'t belong to you.');
    
                return redirect($_SERVER['HTTP_REFERER']);
	        }*/

            if($details->dist_code != $user_dist_code || $details->subdiv_code != $user_subdiv_code || $details->cir_code != $user_cir_code){
                $this->session->set_flashdata('message', 'This case doesn\'t belong to you.');

                return redirect($_SERVER['HTTP_REFERER']);
            }

            $cir_code = $this->utilityclass->getCircleName($details->dist_code, $details->subdiv_code, $details->cir_code);
            $co = $this->utilityclass->getSelectedCOName($details->dist_code, $details->subdiv_code, $details->cir_code, $co_code);

            $application_no = $basundhara_application->basundhara;
            $proposal_no = $details->proposal_no;
            
            $co_report_suffix = $co->username . ", চক্র বিষয়া, " . $cir_code;
            // $co_report_suffix = $this->input->POST('co_report_suffix');
            $co_report = $co_report1." - ".$co_report_suffix;
            $co_report = str_replace("'", '', $co_report);


            $this->db->trans_begin();

            // $application_no= $this->input->post('application_no');

            $co_sign = 'Y';
            $co_date_entry = date('Y-m-d G:i:s');

            $update_data = [
                                'status'                    => 'A',
                                'co_recommendation'         => $co_report,
                                'co_recom_date'             => $co_date_entry,
                                'co_yn'                     => $co_sign,
                                'co_date'                   => $co_date_entry,
                                'proposed_land_revenue'     => $proposed_land_revenue,
                                'proposed_land_localtax'    => $proposed_land_localtax,
                                'proposed_land_class'       => $new_land_class,
                                'adc_code'                  => $adc_code
                            ];

            $this->db->update('t_reclassification', $update_data, array('case_no' => $case_no, 'proposal_no' => $proposal_no));

            // $this->db->query("UPDATE t_reclassification SET status='A',co_recommendation = '$co_report', co_recom_date = '$co_date_entry', co_yn = '$co_sign', "
            //         . "co_date = '$co_date_entry', proposed_land_revenue = '$proposed_land_revenue', proposed_land_localtax = '$proposed_land_localtax', "
            //         . "proposed_land_class='$new_land_class' WHERE case_no = '$case_no' and proposal_no = '$proposal_no'");
            /////////////////////
            ///////////////For Proceeding///////////////////
            // $q = "select * from t_reclassification where case_no = '$case_no' and proposal_no = '$proposal_no' ";
            // $details = $this->db->query($q)->row();

            $proID=$this->maxProceedingID($case_no);
            $pro_array=array(
                'dist_code' => $details->dist_code,
                'subdiv_code' => $details->subdiv_code,
                'cir_code' => $details->cir_code,
                'case_no'=>$case_no,
                'proceeding_id'=>$proID,
                'status'=>'pending',
                'date_of_hearing'=>date('Y-m-d'),
                'co_order'=>$co_report,
                'user_code'=>$co_code,
                'date_entry'=>$co_date_entry,
                'operation'=>'E',
                'ip' => $this->utilityclass->get_client_ip()
                );
            $this->db->insert('petition_proceeding_dc_adc',$pro_array);
            $supportedDocFilepaths = $this->UtilsModel->uploadFile($case_no, $_SERVER['HTTP_REFERER']);
            //////////////////////////////////
            $penUser='ADC';
            $rmrk='Report by CO';
            $this->DashboardData($case_no,$penUser,$rmrk);
            ///////          
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();

                if(count($supportedDocFilepaths)){
                    foreach($supportedDocFilepaths as $singlefile_name){
                        unlink($singlefile_name);
                    }
                }

                log_message('error', '#ERRCOCASEFRWD10001: Server error for case_no = ' . $case_no);
                $this->session->set_flashdata('message', '#ERRCOCASEFRWD10001: Something went wrong with the application.');

                return redirect($_SERVER['HTTP_REFERER']);
            }else {
                    if($application_no)
                    {

                        //START ESCALATION FOR CO PROCESS===========
                        $dist_code=$this->session->userdata('dist_code');
                        $subdiv_code=$this->session->userdata('subdiv_code');
                        $cir_code= $this->session->userdata('cir_code');

                        $user_code = $this->session->userdata('user_code');
                        if($details->es_flag == 1 && ESCALATION_ENABLE == 1 && $details->out_of_esc == 0){
                            $executionDate = $this->input->post('executionDate');
                            $escalationUpdateStatus = $this->Escalationmodel->escalationCOProcessRECLASS($executionDate,$dist_code,$subdiv_code,$cir_code,$case_no,$user_code);
                            log_message("error", "#ESC950, transaction-error-STATUS======".json_encode($escalationUpdateStatus));

                            if($escalationUpdateStatus['responseType'] == 0){
                                $this->db->trans_rollback();
                                log_message("error", "#ESC950, transaction-error in method 'LandReclassification/SaveCoProcess' with case-no :". $case_no);
                                $this->session->set_flashdata('message', "Something went wrong. Error Code(#ESC950)");
                                redirect(base_url() . "index.php/home");
                            }
                        }
                        $rtps=$this->rtpsmodel->checkRtpsService($application_no);
                        if($rtps=='RTPS'){
                            $apilink=RTPS_API_LINK;
                        }else{
                            $apilink=API_LINK;
                        }
                        $curl_handle = curl_init();
                        curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
                        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
                        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 10); // setting 10 seconds 
                        curl_setopt($curl_handle, CURLOPT_TIMEOUT, 30); // setting 30 seconds
                        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                            'application' => $application_no,
                            'dharitree' => $case_no,
                            'rmk' => 'forwared to ADC',
                            'status' => 'M',
                            'task' => 'CO',
                            'pen'=>'ADC',
                            'penat'=>'DC office'
                        )));
                        $result = curl_exec($curl_handle);
                        if($result==true){


                            


                            $this->db->trans_commit();
                            $this->session->set_flashdata('message',"CO order has been passed");
                            redirect(base_url() . "index.php/home");
                        }else{
                            $this->db->trans_rollback();

                            if(count($supportedDocFilepaths)){
                                foreach($supportedDocFilepaths as $singlefile_name){
                                    unlink($singlefile_name);
                                }
                            }

                            log_message('error', '#ERRCOCASEFRWD10002: Error in CO API for case_no = ' . $case_no);
                            $this->session->set_flashdata('message', '#ERRCOCASEFRWD10002: Something went wrong with the application.');

                            return redirect($_SERVER['HTTP_REFERER']);
                            // $this->session->set_flashdata('message',"Error in CO API");
                            // redirect(base_url() . "index.php/home");
                        }
                    }
                $this->db->trans_commit();
                $this->session->set_flashdata('message',"Circle Officer's Report on Reclassification Case no with case no $case_no ");
                // echo "string";die;
                //////////////////////////////////
                $data=array(
                    'success'=>"Circle Officer's Report on Reclassification Case no $case_no",
                    'redirect_url'=>base_url().'index.php/home'
                );
                redirect(base_url() . "index.php/home");
                
            }
            // echo json_encode($data);
        }

        Public function FirstDCProcess() {
            //var_dump($this->session->all_userdata());
            $user_desig_code = $this->session->userdata('user_desig_code');
            $user_code = $this->session->userdata('user_code');
            $case_no = $this->input->GET('case_no');
            $proposal_no = $this->input->GET('proposal_no');

            if(!in_array($user_desig_code, ['DC', 'ADC'])){
                show_error('You are not authorize to perform this action.', 401);
                return;
            }

            $caseNoValidate = caseNumberValidation($case_no);
            if(count($caseNoValidate)){
                show_error($caseNoValidate['message'], 401);
                return;
            }

            $response = isValidQuery($case_no);
            if($response['status'] == 'n'){
                show_error('MALECIOUS QUERY in Case no', 401);
                return;
            }

            $proposanNoValidate = proposalNumberValidation($proposal_no);
            if(count($proposanNoValidate)){
                show_error($proposanNoValidate['message'], 401);
                return;
            }

            $response = isValidQuery($proposal_no);
            if($response['status'] == 'n'){
                show_error('MALECIOUS QUERY in Proposal no', 401);
                return;
            }

            $q = "select * from t_reclassification where case_no =? and proposal_no =?";
            $details = $this->db->query($q, array($case_no, $proposal_no))->row();
            
            if(!$details){
                log_message('error', '#ERRADCTRECLASS10002: Data not found in t_reclassification table for proposal_no = ' . $proposal_no . ' and case_no = '. $case_no);
                show_error('#ERRADCTRECLASS10002: No such data found', 404);
                return;
            }

            $old_patta = $this->db->query("select * from patta_code where type_code =?", array($details->patta_type_code))->row();
            $old_land_class = $this->db->query("select * from landclass_code where class_code =?", array($details->present_land_class))->row();
            $proposed_land_class = $this->db->query("select * from landclass_code where class_code =?", array($details->proposed_land_class))->row();

            if(!$old_patta){
                log_message('error', '#ERRADCRECLASS10003: Data not found in patta_code table for type_code = ' . $details->patta_type_code);
                show_error('#ERRADCRECLASS10003: Patta detail is not found', 401);
                return;
            }
            if(!$old_land_class){
                log_message('error', '#ERRADCRECLASS10004: Data not found in landclass_code table for class_code = ' . $details->present_land_class);
                show_error('#ERRADCRECLASS10004: Land detail is not found', 401);
                return;
            }
            if(!$proposed_land_class){
                log_message('error', '#ERRADCRECLASS10005: Data not found in landclass_code table for class_code = ' . $details->proposed_land_class);
                show_error('#ERRADCRECLASS10005: Proposed detail is not found.');
                return;
            }

            $dist_code = $this->utilityclass->getDistrictName($details->dist_code);
            $subdiv_code = $this->utilityclass->getSubDivName($details->dist_code, $details->subdiv_code);
            $cir_code = $this->utilityclass->getCircleName($details->dist_code, $details->subdiv_code, $details->cir_code);
            $mouza_pargona_code = $this->utilityclass->getMouzaName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code);
            $lot_no = $this->utilityclass->getLotName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no);
            $vill_townprt_code = $this->utilityclass->getVillageName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no, $details->vill_townprt_code);
            
            $adc = $this->utilityclass->getSelectedCOName($details->dist_code, '00', '00', $user_code);
            $username = $this->db->query("select user_code from loginuser_table where user_code like '%ADC%' ")->result();
            $usercodeadc='';
            foreach($username as $uc){
                if($uc->user_code==$user_code)
                    $usercodeadc = $user_code;
            }
            
            $data['location'] = array(
                'dist' => $dist_code,
                'sub' => $subdiv_code,
                'cir' => $cir_code,
                'mouza' => $mouza_pargona_code,
                'lot' => $lot_no,
                'vill' => $vill_townprt_code,
                'adc_name' => $adc->username,
                'uc'=>$usercodeadc
            );

            $data['det'] = array(
                'patta_type' => $old_patta->patta_type,
                'old_land_class' => $old_land_class->land_type,
                'proposed_land_class' => $proposed_land_class->land_type
            );

            $data['Pcases'] = $details;

            $application_no="select * from basundhar_application where dharitree='$case_no' ";
            $data['app'] = $this->db->query($application_no)->row();

            $lmnote="select * from petition_proceeding_dc_adc where case_no='$case_no' and user_code like 'ADC%' order by proceeding_id desc";
            $data['lmrmk']= $this->db->query($lmnote)->row();

            $conote="select * from petition_proceeding_dc_adc where case_no='$case_no' and user_code like 'CO%' order by proceeding_id desc";
            $data['cormk']= $this->db->query($conote)->row();
            $data['basundharaAttachment']=$data['basundharaApp']=$data['sup_doc']=null;
            $data['sup_doc']=$this->db->query("SELECT * FROM supportive_document WHERE case_no=?", array($case_no))->result();
            //echo $this->db->last_query();
            $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
            if($basundhara){
                $rtps=$this->rtpsmodel->checkBasundharaService($case_no);
                if($rtps=='RTPS'){
                    $data['basundharaAttachment']=$this->rtpsmodel->searchBasundharaLink($case_no);
                    $data['basundharaApp']=$this->rtpsmodel->searchBasundharaLinkApp($case_no);
                }else{
                    $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
                    $data['basundharaApp']=$this->basundharamodel->searchBasundharaLinkApp($case_no);
                }
            }

            $flag_adc = false;
            $flag_co = false;
            if($details->es_flag == 1 && ESCALATION_ENABLE == 1 && $details->out_of_esc == 0){
                //remaining Days of CO ============
                $escalatedRowDetailsAgainstPetitionno = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($case_no);

                $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->co_target_days;
                $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
                $remaining_days_CO = $this->Escalationmodel->getRemainingDays($previousCompletedDaysCO,$originalAllocation);

                //remaining days of CO==============
                $originalAllocationADC   = $escalatedRowDetailsAgainstPetitionno->adc_target_days;
                $previousCompletedDaysADC = $escalatedRowDetailsAgainstPetitionno->adc_completed_days;
                $remaining_days_ADC= $this->Escalationmodel->getRemainingDays($previousCompletedDaysADC,$originalAllocationADC);

                //remaining days of DC==============
                if($this->session->userdata('user_desig_code') == 'DC'){
                    $originalAllocationDC   = $escalatedRowDetailsAgainstPetitionno->dc_target_days;
                    $previousCompletedDaysDC = $escalatedRowDetailsAgainstPetitionno->dc_completed_days;
                    $remaining_days_DC= $this->Escalationmodel->getRemainingDays($previousCompletedDaysDC,$originalAllocationDC);
                }

                if($this->session->userdata('user_desig_code') == 'ADC'){
                    $originalAllocationADC   = $escalatedRowDetailsAgainstPetitionno->adc_target_days;
                    $previousCompletedDaysDC = $escalatedRowDetailsAgainstPetitionno->adc_completed_days;
                    $remaining_days_DC= $this->Escalationmodel->getRemainingDays($previousCompletedDaysADC,$originalAllocationADC);
                }
                


                if($remaining_days_CO == 0){
                    $flag_co = true;
                }
                if($remaining_days_ADC == 0){
                    $flag_adc = true;
                }
            }
            $data['flag_adc'] = $flag_adc;
            $data['flag_co']  = $flag_co;
            $data['remainingDaysDC'] = $remaining_days_DC;
            $data['out_of_esc'] = $details->out_of_esc;

            //////////////////////////////////////////////////////////////// Property Chain Code //////////////////////////////////////////////
            if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
            {
            $this->load->model('propChain/PropChainModel');

            //////////////////////////////////////////////////////////////// Property Chain Code //////////////////////////////////////////////

             $data['propChainEnableFlag'] = $this->PropChainCommonModel->isLocationEnable($details->dist_code,
                $details->subdiv_code,
                $details->cir_code,
                $details->mouza_pargona_code,
                $details->lot_no,
                $details->vill_townprt_code);

            $chainChithaCheck = $this->PropChainModel->chainChithaUlpinCheckProcess(
                $details->dist_code,
                $details->subdiv_code,
                $details->cir_code,
                $details->mouza_pargona_code,
                $details->lot_no,
                $details->vill_townprt_code,
                $details->patta_no,
                $details->dag_no,
                $details->dag_area_b,
                $details->dag_area_k,
                $details->dag_area_lc,
                $details->dag_area_g,
                $details->patta_type_code
            );

            // var_dump($chainChithaCheck);
            // die;
            if ($chainChithaCheck['chithaPropChainCmpFlag'] == 'Y' || $chainChithaCheck['chithaPropChainCmpFlag'] == 'N' || $chainChithaCheck['chithaPropChainCmpFlag'] == 'NE') {
                $this->PropChainModel->updateCmpFlag($case_no, $chainChithaCheck['chithaPropChainCmpFlag']);
                // get view mismatch case button
                if ($chainChithaCheck['chithaPropChainCmpFlag'] == 'N') {
                    $data['mismatchBtn'] = $this->PropChainModel->getMismatchBtn(
                        $case_no,
                        $details->dist_code,
                        $details->subdiv_code,
                        $details->cir_code,
                        $details->mouza_pargona_code,
                        $details->lot_no,
                        $details->vill_townprt_code,
                        $details->patta_no,
                        $details->dag_no,
                        $details->dag_area_b,
                        $details->dag_area_k,
                        $details->dag_area_lc,
                        $details->dag_area_g,
                        $details->patta_type_code
                    );
                }
            }

            $data['ulpinCheck'] = $chainChithaCheck['ulpinCheck'];
            $data['ulpinMsg'] = $chainChithaCheck['ulpinMsg'];

            if ($data['ulpinCheck'] == 1) {
                $data['ulpin'] = $chainChithaCheck['ulpin'];
                if (isset($chainChithaCheck['old_ulpin']))
                    $data['old_ulpin'] = $chainChithaCheck['old_ulpin'];
                else
                    $data['old_ulpin'] = "";
            }

            // $data['chithaPropChainCmpFlag'] = $chainChithaCheck['chithaPropChainCmpFlag'];
            // $data['compareFlagMsg'] = $chainChithaCheck['compareFlagMsg'];

            $data['chithaPropChainCmpFlag'] = $chainChithaCheck['chithaPropChainCmpFlag'];
            $data['compareFlagMsg'] = $chainChithaCheck['compareFlagMsg'];
            $data['revenue'] = $chainChithaCheck['revenue'];
            $data['local_tax'] = $chainChithaCheck['local_tax'];

            if ($chainChithaCheck['chithaPropChainCmpFlag'] == 'NE')
                $data['createPropChainBtn'] = $chainChithaCheck['createPropChainBtn'];

            // hidden fields
            $data['ulpin_hidden'] = $chainChithaCheck['ulpin_hidden'];
            $data['uplpin_msg_hidden'] = $chainChithaCheck['uplpin_msg_hidden'];
            $data['compare_hidden'] = $chainChithaCheck['compare_hidden'];
            $data['compare_msg_hidden'] = $chainChithaCheck['compare_msg_hidden'];

            // bhunaksha area cmp
            $data['bhuChithaCmpStatus'] = $chainChithaCheck['bhuChithaCmpStatus'];
            $data['bhuChithaCmpMsg'] = $chainChithaCheck['bhuChithaCmpMsg'];
            $data['bhu_hidden'] = $chainChithaCheck['bhu_hidden'];
            $data['bhu_compare_msg_hidden'] = $chainChithaCheck['bhu_compare_msg_hidden'];
           }

           //ESCALATED CASES REMARK ENTRY FORM==============
            if(ESCALATION_ENABLE == 1 && ESCALATION_REMARK_ENABLE == 1 && $details->es_flag == 1 && $details->out_of_esc == 0)
            {
                $remainingTime = $this->Escalationmodel->calculateRemainingTime($case_no,$this->session->userdata('user_desig_code'));
                $data['remainingTime'] = $remainingTime;
                $escRemarkData = $this->Escalationmodel->getEscalationRemarkDetails($case_no,$this->session->userdata('user_desig_code'),$this->session->userdata('user_code'));
                if(isset($escRemarkData) && !empty($escRemarkData))
                {
                    $data['escRemarkData'] = $escRemarkData;
                }
            }
            ///END REMARKS/////////


            $params = [
              'case_no'          => $application_no,
              'service_code'     => 4,
              'remarks'          => 'Reclassification',
              'accessed_entity'  => 'Aadhaar Status Checked',
            ];
            $this->load->model('EkycLogModel');
            $log = $this->EkycLogModel->insertEkycAccessedBy($this->db, $params);


            
            $data['_view'] = 'LandReclassification/FirstDCProcess';
            $this->load->view('layouts/main',$data);
        }
        public function forwardtodc(){
            $case_no = $this->input->GET('case_id');
            $proposal_no = $this->input->GET('proposal_no');
            $forwardtodc = $this->input->GET('forwarddc');
            $account = $this->input->GET('account');
            $application_no= $this->input->post('application_no');
            $this->db->trans_begin();
            $this->db->query("UPDATE t_reclassification SET forwardtodc = '$forwardtodc',account='$account' WHERE case_no = '$case_no' and proposal_no = '$proposal_no'");
               //////////
            $penUser='DC';
            $rmrk='Report by ADC';
            $this->DashboardData($case_no,$penUser,$rmrk);

            ///////

                if($application_no)
                {
                    $rtps=$this->rtpsmodel->checkRtpsService($application_no);
                    if($rtps=='RTPS'){
                        $apilink=RTPS_API_LINK;
                    }else{
                        $apilink=API_LINK;
                    }
                    $curl_handle = curl_init();
                    curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
                    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                        'application' => $application_no,
                        'dharitree' => $case_no,
                        'rmk' => 'forwared to DC',
                        'status' => 'M',
                        'task' => 'ADC',
                        'pen'=>'DC',
                        'penat'=>'DC office'
                    )));
                    $result = curl_exec($curl_handle);
                    if($result==true){
                        $this->db->trans_commit();
                    }else{
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message',"ADC's Report on Reclassification Case no with case no $case_no ");
                        redirect(base_url() . "index.php/home");
                    }
                }
                $this->db->trans_commit();
                $this->session->set_flashdata('message',"ADC's Report on Reclassification Case no with case no $case_no ");
                //////////////////////////////////
                $data=array(
                    'success'=>"ADC's Report on Reclassification Case no $case_no",
                    'redirect_url'=>base_url().'index.php/home'
                );
                redirect(base_url() . "index.php/home");
        }  
        public function forwardtoCO(){
             $case_no = $this->input->GET('case_id');
             $proposal_no = $this->input->GET('proposal_no');
             $forwardcofrom_adc = $this->input->GET('forwardcofrom_adc');
             //$account = $this->input->GET('account');
             $this->db->query("UPDATE t_reclassification SET forwardcofrom_adc = '$forwardcofrom_adc',account=null WHERE case_no = '$case_no' and proposal_no = '$proposal_no'");
            //echo"UPDATE t_reclassification SET forwardtodc = '$forwardtodc',account='$account' WHERE case_no = '$case_no' and proposal_no = '$proposal_no'";
            redirect(base_url() . "index.php/home");
        }
        public function revertToLm(){
            $user_dist_code = $this->session->userdata('dist_code');
            $user_subdiv_code = $this->session->userdata('subdiv_code');
            $user_cir_code = $this->session->userdata('cir_code');
            $co_code = $this->session->userdata('user_code');
            $user_desig_code = $this->session->userdata('user_desig_code');

            $case_no = $this->input->post('case_no');
            $co_report1 = $this->input->POST('co_report');
            $co_sign = 'Y';
            $co_date_entry = date('Y-m-d G:i:s');

            if(!in_array($user_desig_code, ['CO'])){
                $this->session->set_flashdata('revrt_mdl_message', 'You are not authorized to perform this action');
                return redirect($_SERVER['HTTP_REFERER']);
            }
 
            // $proposal_no = $this->input->post('proposal_no');
            // $application_no=$this->input->post('application_no');

            // $co_report_suffix = $this->input->POST('co_report_suffix');
            // $co_report = $co_report1." - ".$co_report_suffix;
            //$co_report = str_replace("'", '', $co_report);
             // $forwardcofrom_adc = $this->input->GET('forwardcofrom_adc');
             //$account = $this->input->GET('account');

            $error_data_messages_arr = [];

            $caseNoValidate = caseNumberValidation($case_no);
            if(count($caseNoValidate)){
                array_push($error_data_messages_arr, $caseNoValidate['message']);
            }

            if(empty($co_report1)){
                array_push($error_data_messages_arr, 'Report is required.');
            }
            
            $response = specialCharacterCheckingInInput($co_report1, ['.', ',', '|', '-',':','।','\''], 'Report');
            if($response['status'] == 'n'){
                array_push($error_data_messages_arr, $response['message']);
            }
            
            if(count($error_data_messages_arr)){
                $error_messages = convertArrayToHtmlUlLi($error_data_messages_arr);
                $this->session->set_flashdata('revrt_mdl_message', $error_messages);
                return redirect($_SERVER['HTTP_REFERER']);
            }

            // Malecious checking Start
            $response = isValidQuery($case_no);
            if($response['status'] == 'n'){
                array_push($error_data_messages_arr, 'Case number has MALECIOUS QUERY');
            }

            $response = isValidQuery($co_report1);
            if($response['status'] == 'n'){
                array_push($error_data_messages_arr, 'Report has MALECIOUS QUERY');
            }
            
            // Malecious checking End

            if(count($error_data_messages_arr)){
                $error_messages = convertArrayToHtmlUlLi($error_data_messages_arr);
                $this->session->set_flashdata('revrt_mdl_message', $error_messages);

                return redirect($_SERVER['HTTP_REFERER']);
            }

            $basundhara_application = $this->db->query("select * from basundhar_application where dharitree=?", array($case_no))->row();
            // if(!$basundhara_application){
            //     log_message('error', '#ERRBSNDAPRV00001: No such application found in the basundhar_application table for dharitree = ' . $case_no);
            //     $this->session->set_flashdata('revrt_mdl_message', '#ERRBSNDAPRV00001: No such application found');

            //     return redirect($_SERVER['HTTP_REFERER']);
            // }
            
            // if(!in_array($basundhara_application->pending_with, ['CO'])){
            //     log_message('error', '#ERRBSNDAPRV00002: Application is not pending with CO. Application status is ' . $basundhara_application->pending_with . ' basundhar_application table for dharitree = ' . $case_no);
            //     $this->session->set_flashdata('revrt_mdl_message', '#ERRBSNDAPRV00002: Application is not pending with CO.');

            //     return redirect($_SERVER['HTTP_REFERER']);
            // }
            if($basundhara_application){
                if(!in_array($basundhara_application->pending_with, ['CO'])){
                    log_message('error', '#ERRBSNDAPRV00002: Application is not pending with CO. Application status is ' . $basundhara_application->pending_with . ' basundhar_application table for dharitree = ' . $case_no);
                    $this->session->set_flashdata('revrt_mdl_message', '#ERRBSNDAPRV00002: Application is not pending with CO.');

                    return redirect($_SERVER['HTTP_REFERER']);
                } 
            }
            
            $tclass = $this->db->query("select * from t_reclassification where case_no =?", array($case_no))->row();
            if(!$tclass){
                log_message('error', '#ERRTRECLSRV10001: No such record found in the t_reclassfication table for case_no = ' . $case_no);
                $this->session->set_flashdata('revrt_mdl_message', '#ERRTRECLSRV10001: Something went wrong with the application.');

                return redirect($_SERVER['HTTP_REFERER']);
            }

            if($tclass->status == 'M'){
                $this->session->set_flashdata('revrt_mdl_message', 'This case is already reverted.');

                return redirect($_SERVER['HTTP_REFERER']);
            }
            
            if(!in_array($tclass->status, [NULL, 'C'])){
                log_message('error', '#ERRCSRVRT10001: Case doesn\'t belong to the login user for case_no = ' . $case_no . ' as this case\'s status is ' . $tclass->status);
                $this->session->set_flashdata('revrt_mdl_message', '#ERRCSRVRT10001: This case doesn\'t belong to you.');

                return redirect($_SERVER['HTTP_REFERER']);
            }

            if($tclass->dist_code != $user_dist_code || $tclass->subdiv_code != $user_subdiv_code || $tclass->cir_code != $user_cir_code){
                $this->session->set_flashdata('revrt_mdl_message', 'This case doesn\'t belong to you.');

                return redirect($_SERVER['HTTP_REFERER']);
            }

            $cir_code = $this->utilityclass->getCircleName($tclass->dist_code, $tclass->subdiv_code, $tclass->cir_code);
            $co = $this->utilityclass->getSelectedCOName($tclass->dist_code, $tclass->subdiv_code, $tclass->cir_code, $co_code);

            $application_no = $basundhara_application->basundhara;
            $proposal_no = $tclass->proposal_no;
            
            $co_report_suffix = $co->username . ", চক্র বিষয়া, " . $cir_code;
            $co_report = $co_report1." - ".$co_report_suffix;
            $co_report = str_replace("'", '', $co_report);

            $this->db->trans_begin();

            $update_data = [
                                'status' => 'M',
                            ];

            $this->db->update('t_reclassification', $update_data, array('case_no' => $case_no, 'proposal_no' => $proposal_no));

            // $this->db->query("UPDATE t_reclassification SET status='M' WHERE case_no = '$case_no' and proposal_no = '$proposal_no'");
            //echo"UPDATE t_reclassification SET forwardtodc = '$forwardtodc',account='$account' WHERE case_no = '$case_no' and proposal_no = '$proposal_no'";

             /////////////ProCedding///////////////////////
            // $sql="Select * from t_reclassification WHERE case_no =? and proposal_no =?";
            // $tclass=$this->db->query($sql, array($case_no, $proposal_no))->row();
            $prodId=$this->maxProceedingID($case_no);
            $pro_array = array(
                            'dist_code' => $tclass->dist_code,
                            'subdiv_code' => $tclass->subdiv_code,
                            'cir_code' => $tclass->cir_code,
                            'case_no'=>$case_no,
                            'proceeding_id'=>$prodId,
                            'status'=>'pending',
                            'date_of_hearing'=>date('Y-m-d'),
                            'co_order'=>$co_report,
                            'user_code'=>$co_code,
                            'date_entry'=>$co_date_entry,
                            'operation'=>'E',
                            'ip' => $this->utilityclass->get_client_ip()
                        );

            $this->db->insert('petition_proceeding_dc_adc',$pro_array);
            $penUser='LM';
            $rmrk='Revert to LM by CO';
            $this->DashboardData($case_no,$penUser,$rmrk);
            
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();

                log_message('error', '#ERRCOCASERVRT10001: Server error for case_no = ' . $case_no);
                $this->session->set_flashdata('revrt_mdl_message', '#ERRCOCASERVRT10001: Something went wrong with the application.');

                return redirect($_SERVER['HTTP_REFERER']);
            }else{
                if($application_no)
                {
                    $rtps=$this->rtpsmodel->checkRtpsService($application_no);
                    if($rtps=='RTPS'){
                        $apilink=RTPS_API_LINK;
                    }else{
                        $apilink=API_LINK;
                    }
                    $curl_handle = curl_init();
                    curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
                    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 10); // setting 10 seconds 
                    curl_setopt($curl_handle, CURLOPT_TIMEOUT, 30); // setting 30 seconds
                    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                        'application' => $application_no,
                        'dharitree' => $case_no,
                        'rmk' => 'forwared to LM',
                        'status' => 'M',
                        'task' => 'CO',
                        'pen'=>'LM',
                        'penat'=>'Circle office'
                    )));
                    $result = curl_exec($curl_handle);
                    if($result==true){
                        // $this->db->trans_commit();
                    }else{
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('revrt_mdl_message',"Error in API Call");
                        return redirect($_SERVER['HTTP_REFERER']);
                        // redirect(base_url() . "index.php/home");
                    }
                }

            }
            $this->db->trans_commit();
            $this->session->set_flashdata('message',"Forwared to LM for correction of remark #$case_no ");
            redirect(base_url() . "index.php/home");
        }

        public function ResponseLM() {
            $user_code = $this->session->userdata('user_code');
            $case_no = $this->input->GET('case_no');

            $caseNoValidate = caseNumberValidation($case_no);
            if(count($caseNoValidate)){
                show_error($caseNoValidate['message'], 401);
                return;
            }

            $response = isValidQuery($case_no);
            if($response['status'] == 'n'){
                show_error('MALECIOUS QUERY in Case no', 401);
                return;
            }
            
            $q = "select * from t_reclassification where case_no =?";
            $details = $this->db->query($q, array($case_no))->row();

            if(!$details){
                log_message('error', '#ERRRVTRECLASS10001: Data not found in t_reclassification table for case_no = '. $case_no);
                show_error('#ERRRVTRECLASS10001: No such data found', 404);
                return;
            }

            $dist_code = $this->utilityclass->getDistrictName($details->dist_code);
            $subdiv_code = $this->utilityclass->getSubDivName($details->dist_code, $details->subdiv_code);
            $cir_code = $this->utilityclass->getCircleName($details->dist_code, $details->subdiv_code, $details->cir_code);
            $mouza_pargona_code = $this->utilityclass->getMouzaName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code);
            $lot_no = $this->utilityclass->getLotName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no);
            $vill_townprt_code = $this->utilityclass->getVillageName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no, $details->vill_townprt_code);
            
           // $co = $this->utilityclass->getSelectedCOName($details->dist_code, $details->subdiv_code, $details->cir_code, $user_code);
            $lm = $this->utilityclass->getDefinedMondalsName($details->dist_code, $details->subdiv_code, $details->cir_code,$details->mouza_pargona_code,$details->lot_no, $user_code);

            $data['location'] = array(
                'dist' => $dist_code,
                'sub' => $subdiv_code,
                'cir' => $cir_code,
                'mouza' => $mouza_pargona_code,
                'lot' => $lot_no,
                'vill' => $vill_townprt_code,
                //'co_name' => $co->username,
                'lm_name'=>$lm->lm_name

            );

            $old_patta = $this->db->query("select * from patta_code where type_code =?", array($details->patta_type_code))->row();
            $old_land_class = $this->db->query("select * from landclass_code where class_code =?", array($details->present_land_class))->row();
            $proposed_land_class = $this->db->query("select * from landclass_code where class_code =?", array($details->proposed_land_class))->row();

            if(!$old_patta){
                log_message('error', '#ERRRVTRECLASS10002: Data not found in patta_code table for type_code = ' . $details->patta_type_code);
                show_error('#ERRRVTRECLASS10002: Patta detail is not found', 401);
                return;
            }
            if(!$old_land_class){
                log_message('error', '#ERRRVTRECLASS10003: Data not found in landclass_code table for class_code = ' . $details->present_land_class);
                show_error('#ERRRVTRECLASS10003: Land detail is not found', 401);
                return;
            }
            if(!$proposed_land_class){
                log_message('error', '#ERRRVTRECLASS10004: Data not found in landclass_code table for class_code = ' . $details->proposed_land_class);
                show_error('#ERRRVTRECLASS10004: Proposed detail is not found.');
                return;
            }

            $data['det'] = array(
                'patta_type' => $old_patta->patta_type,
                'old_land_class' => $old_land_class->land_type,
                'proposed_land_class' => $proposed_land_class->land_type,
                'proposed_land_class_code' => $details->present_land_class,
                'pp_code'=>$details->proposed_land_class
            );
            $all_land_class = "Select * from landclass_code";
            $data['land_class'] = $this->db->query($all_land_class)->result();
            $data['Pcases'] = $details;
            $lmnote="select * from petition_proceeding_dc_adc where case_no='$case_no' and user_code='$user_code' order by proceeding_id desc ";
            $data['lmrmk']= $this->db->query($lmnote)->row();

            $conote="select * from petition_proceeding_dc_adc where case_no='$case_no' and user_code like 'CO%' order by proceeding_id desc ";
            $data['cormk']= $this->db->query($conote)->row();
            $application_no="select * from basundhar_application where dharitree='$case_no' ";
            $data['app'] = $this->db->query($application_no)->row();

            $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
            if($basundhara){
                $rtps=$this->rtpsmodel->checkBasundharaService($case_no);
                if($rtps=='RTPS'){
                    $data['basundharaAttachment']=$this->rtpsmodel->searchBasundharaLink($case_no);
                    $data['basundharaApp']=$this->rtpsmodel->searchBasundharaLinkApp($case_no);
                }else{
                    $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
                    $data['basundharaApp']=$this->basundharamodel->searchBasundharaLinkApp($case_no);
                }
            }
            $data['_view'] = 'LandReclassification/response_lm';
            $this->load->view('layouts/main',$data);
        }
        public function SaveCoProcessLMRe() {
            $user_dist_code = $this->session->userdata('dist_code');
            $user_subdiv_code = $this->session->userdata('subdiv_code');
            $user_cir_code = $this->session->userdata('cir_code');
            $user_code = $this->session->userdata('user_code');
            $user_desig_code = $this->session->userdata('user_desig_code');
            $proposed_land_revenue = $this->input->post('P_land_rev');
            // $proposed_land_localtax = $this->input->post('p_local_tax');
            $new_land_class = $this->input->post('new_land_class');
            $co_report1 = $this->input->POST('co_report');
            $case_no = $this->input->POST('case_no');

            if(!in_array($user_desig_code, ['LM'])){
                $this->session->set_flashdata('message', 'You are not authorized to perform this action');
                return redirect($_SERVER['HTTP_REFERER']);
            }
 
            $this->form_validation->set_rules('new_land_class', 'New land class', 'required');
            $this->form_validation->set_rules('P_land_rev', 'Proposed land revenue', 'required|numeric|greater_than[-1]');
            // $this->form_validation->set_rules('p_local_tax', 'Proposed local tax', 'required|numeric|greater_than[-1]');
            $this->form_validation->set_rules('co_report', 'Report', 'required|max_length[1000]');
            $this->form_validation->set_rules('case_no', 'Case number', 'required');

            if ($this->form_validation->run() == FALSE)
            {
                $this->session->set_flashdata('message', validation_errors());
                return redirect($_SERVER['HTTP_REFERER']);
            }

            // XSS validation start
            $errorMessageStr = '';
            $resp = checkRequestSpecChar($_POST);
            if($resp['status'] == 'n'){
                $errorMessageStr .= $resp['messages'];
            }

            $resp = checkRequestValidQuery($_POST);
            if($resp['status'] == 'n'){
                $errorMessageStr .= $resp['messages'];
            }

            if($errorMessageStr != ''){
                $this->session->set_flashdata('message', $errorMessageStr);
                return redirect($_SERVER['HTTP_REFERER']);
            }
            // XSS validation end
            
            // $error_data_messages_arr = [];            

            // $caseNoValidate = caseNumberValidation($case_no);
            // if(count($caseNoValidate)){
            //     array_push($error_data_messages_arr, $caseNoValidate['message']);
            // }

            // $response = isValidQuery($case_no);
            // if($response['status'] == 'n'){
            //     array_push($error_data_messages_arr, 'Case number has MALECIOUS QUERY');
            // }
            
            // $response = specialCharacterCheckingInInput($co_report1, ['.', ',', '|', '-',':','।','\''], 'Report');
            // if($response['status'] == 'n'){
            //     array_push($error_data_messages_arr, $response['message']);
            // }

            // $response = isValidQuery($co_report1);
            // if($response['status'] == 'n'){
            //     array_push($error_data_messages_arr, 'Report has MALECIOUS QUERY');
            // }
            
            // $response = specialCharacterCheckingInInput($new_land_class, [], 'New land class');
            // if($response['status'] == 'n'){
            //     array_push($error_data_messages_arr, $response['message']);
            // }

            // $response = isValidQuery($new_land_class);
            // if($response['status'] == 'n'){
            //     array_push($error_data_messages_arr, 'New land class has MALECIOUS QUERY');
            // }
            
            // if(count($error_data_messages_arr)){
            //     $error_messages = convertArrayToHtmlUlLi($error_data_messages_arr);
            //     $this->session->set_flashdata('message', $error_messages);
            //     return redirect($_SERVER['HTTP_REFERER']);
            // }
            
            // Land class checking existance
            $land_class = $this->db->query("Select * from landclass_code where class_code=?", array($new_land_class))->num_rows();
            if($land_class == 0){
                log_message('error', '#ERRRVTLNDCLS00001: New land class not found in the landclass_code table for class_code = ' . $new_land_class);
                $this->session->set_flashdata('message', '#ERRRVTLNDCLS00001: New land class not found');

                return redirect($_SERVER['HTTP_REFERER']);
            }

            $basundhara_application = $this->db->query("select * from basundhar_application where dharitree=?", array($case_no))->row();
            // if(!$basundhara_application){
            //     log_message('error', '#ERRRVTBSNDAP00001: No such application found in the basundhar_application table for dharitree = ' . $case_no);
            //     $this->session->set_flashdata('message', '#ERRRVTBSNDAP00001: No such application found');

            //     return redirect($_SERVER['HTTP_REFERER']);
            // }
            
            $tclass = $this->db->query("select * from t_reclassification where case_no =?", array($case_no))->row();
            if(!$tclass){
                log_message('error', '#ERRRVTTRECLS10001: No such record found in the t_reclassfication table for case_no = ' . $case_no);
                $this->session->set_flashdata('message', '#ERRRVTTRECLS10001: Something went wrong with the application.');

                return redirect($_SERVER['HTTP_REFERER']);
            }

            if($tclass->status == 'C'){
                $this->session->set_flashdata('message', 'This case is already submitted.');

                return redirect($_SERVER['HTTP_REFERER']);
            }

            if(!in_array($tclass->status, ['M'])){
                log_message('error', '#ERRRVTCS10001: Case doesn\'t belong to the login user for case_no = ' . $case_no . ' as this case\'s status is ' . $tclass->status);
                $this->session->set_flashdata('message', '#ERRRVTCS10001: This case doesn\'t belong to you.');
    
                return redirect($_SERVER['HTTP_REFERER']);
            }

            if($tclass->dist_code != $user_dist_code || $tclass->subdiv_code != $user_subdiv_code || $tclass->cir_code != $user_cir_code){
                $this->session->set_flashdata('message', 'This case doesn\'t belong to you.');

                return redirect($_SERVER['HTTP_REFERER']);
            }

            // $cir_code = $this->utilityclass->getCircleName($tclass->dist_code, $tclass->subdiv_code, $tclass->cir_code);
            // $co = $this->utilityclass->getSelectedCOName($tclass->dist_code, $tclass->subdiv_code, $tclass->cir_code, $user_code);
            $lm = $this->utilityclass->getDefinedMondalsName($tclass->dist_code, $tclass->subdiv_code, $tclass->cir_code,$tclass->mouza_pargona_code,$tclass->lot_no, $user_code);

            $application_no = $basundhara_application ? $basundhara_application->basundhara : NULL;
            $proposal_no = $tclass->proposal_no;

            $proposed_land_revenue = $this->input->post('P_land_rev');
            $proposed_land_localtax = $proposed_land_revenue/4;
            $proposed_land_localtax = round($proposed_land_localtax, 4);
            
            $co_report_suffix = $lm->lm_name . ", ভূমিলেখ্য সহায়ক, ";
            // $co_report_suffix = $this->input->POST('co_report_suffix');
            $co_report = $co_report1." - ".$co_report_suffix;
            $co_report = $c_p = str_replace("'", '', $co_report);


            $this->db->trans_begin();
            // $proposal_no = $this->input->POST('proposal_no');
            // $co_report_suffix = $this->input->POST('co_report_suffix');
            // $co_report = $co_report1." - ".$co_report_suffix;
            // $co_report=$c_p = str_replace("'", '', $co_report);

            $co_sign = 'Y';
            $co_date_entry = date('Y-m-d G:i:s');
            // $sql="Select co_recommendation from t_reclassification WHERE case_no = '$case_no' and proposal_no = '$proposal_no'";
            // $co_recomm_old=$this->db->query($sql)->row()->co_recommendation;
            $co_recomm_old = $tclass->co_recommendation;
            $co_report = $co_recomm_old . "<br>" . $co_report;

            $update_data = [
                            'status'                    => 'C',
                            'co_yn'                     => $co_sign,
                            'proposed_land_revenue'     => $proposed_land_revenue,
                            'proposed_land_localtax'    => $proposed_land_localtax,
                            'proposed_land_class'       => $new_land_class,
                        ];

            $this->db->update('t_reclassification', $update_data, array('case_no' => $case_no, 'proposal_no' => $proposal_no));

            // $this->db->query("UPDATE t_reclassification SET proposed_land_revenue = '$proposed_land_revenue', proposed_land_localtax = '$proposed_land_localtax',status='C',co_yn=null,proposed_land_class='$new_land_class' WHERE case_no = '$case_no' and proposal_no = '$proposal_no'");
            ////////////////////
            // $sql="Select * from t_reclassification WHERE case_no = '$case_no' and proposal_no = '$proposal_no'";
            // $tclass=$this->db->query($sql)->row();


            $prodId=$this->maxProceedingID($case_no);
            $proArray= array(
                'case_no' => $case_no,
                'proceeding_id' => $prodId,
                'user_code' => $this->session->userdata('user_code'),
                'status' => 'Pending',
                'co_order'=>$c_p,
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E',
                'dist_code' => $tclass->dist_code,
                'subdiv_code' => $tclass->subdiv_code,
                'cir_code' => $tclass->cir_code,
                'ip' => $this->utilityclass->get_client_ip()
                 );
            $this->db->insert('petition_proceeding_dc_adc',$proArray);
            $supportedDocFilepaths = $this->UtilsModel->uploadFile($case_no, $_SERVER['HTTP_REFERER']);
            ///////////////////
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                if(count($supportedDocFilepaths)){
                    foreach($supportedDocFilepaths as $singlefile_name){
                        unlink($singlefile_name);
                    }
                }

                log_message('error', '#ERRLMCASEFRVT10001: Server error for case_no = ' . $case_no);
                $this->session->set_flashdata('message', '#ERRLMCASEFRVT10001: Something went wrong with the application.');

                return redirect($_SERVER['HTTP_REFERER']);
            } else {

                // $application_no=$this->input->post('application_no'); // already getting from $basundhara_application
                if($application_no)
                {
                        $dist_code = $this->session->userdata('dist_code');
                        $subdiv_code = $this->session->userdata('subdiv_code');
                        $cir_code = $this->session->userdata('cir_code');

                        //ESCALATION CODE INTEGRATION================SANMRI
                        $es_flag_data = $this->db->query("select es_flag,out_of_esc from  t_reclassification where "
                                . " case_no='$case_no'")->row();
                        if($es_flag_data->es_flag == 1 && ESCALATION_ENABLE == 1 && $es_flag_data->out_of_esc == 0)
                        {
                            $user_code = $this->session->userdata('user_code');
                            $executionDate = $this->input->post('executionDate');
                            $escalationUpdateStatus = $this->Escalationmodel->escalationLMReclassReport($executionDate,$dist_code,$subdiv_code,$cir_code,$case_no,$user_code);

                            log_message("error", "#ESC1838, transaction-error-STATUS======".json_encode($escalationUpdateStatus));

                            if($escalationUpdateStatus['responseType'] == 0){
                                $this->db->trans_rollback();
                                log_message("error", "#ESC1838, transaction-error in method 'LandReclassification/response_lm' with case-no :". $case_no);
                                $this->session->set_flashdata('message', "Something went wrong.RECLASS- Error Code(#ESC1838)");
                                redirect(base_url() . "index.php/home");
                            }
                        ///////////////END ESCALATION//////////////
                        }
                        $rtps=$this->rtpsmodel->checkRtpsService($application_no);
                        if($rtps=='RTPS'){
                            $apilink=RTPS_API_LINK;
                        }else{
                            $apilink=API_LINK;
                        }
                        $curl_handle = curl_init();
                        curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
                        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
                        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 10); // setting 10 seconds 
                        curl_setopt($curl_handle, CURLOPT_TIMEOUT, 30); // setting 30 seconds
                        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                            'application' => $application_no,
                            'dharitree' => $case_no,
                            'rmk' => 'Re-report given by LM',
                            'status' => 'M',
                            'task' => 'LM',
                            'pen'=>'CO',
                            'penat'=>'Circle office'
                        )));
                        $result = curl_exec($curl_handle);
                        if($result==true){


                            // $this->db->trans_commit();
                        }else{
                            $this->db->trans_rollback();
                            if(count($supportedDocFilepaths)){
                                foreach($supportedDocFilepaths as $singlefile_name){
                                    unlink($singlefile_name);
                                }
                            }

                            log_message('error', '#ERRLMCASERVT10002: Error in LM API for case_no = ' . $case_no);
                            $this->session->set_flashdata('message', '#ERRLMCASERVT10002: Something went wrong with the application.');

                            return redirect($_SERVER['HTTP_REFERER']);

                            // $this->session->set_flashdata('message',"Error in API Call");
                            // redirect(base_url() . "index.php/home");
                        }
                }
                /////////////////////////
                $this->db->trans_commit();
                $penUser='CO';
                $rmrk='Re-report by LM';
                $this->DashboardData($case_no,$penUser,$rmrk);
                $this->session->set_flashdata('message',"LM's Report on Reclassification Case no # $case_no");
                redirect(base_url() . "index.php/home");
            }
        }
        
        
        public function SaveDCProcess() {

            $this->db->trans_begin();
            $revarted=$this->input->POST('revarted');
            $case_no = $this->input->POST('case_no');
            $proposal_no = $this->input->POST('proposal_no');
            $dc_report = $this->input->POST('dc_report');
            $dc_report = str_replace("'", '', $dc_report);
            
            $dc_code = $this->session->userdata('user_code');
            $dc_sign = 'Y';
            $dc_date_entry = date('Y-m-d G:i:s');
            
            if($revarted=='Y')
            {
                $this->db->query("UPDATE t_reclassification SET dc_approval = '$dc_report', dc_date = '$dc_date_entry' WHERE case_no = '$case_no' and proposal_no = '$proposal_no'");
                $this->session->set_flashdata('message',"Deputy Commissioner / Aditional Deputy Commissioner's Report on Reclassification Case no # $case_no Revarted Back To CO");
                redirect(base_url() . "index.php/home");
            }
            else
            {
                $this->db->query("UPDATE t_reclassification SET dc_approval = '$dc_report', dc_approval_date = '$dc_date_entry', dc_yn = '$dc_sign', dc_date = '$dc_date_entry' WHERE case_no = '$case_no' and proposal_no = '$proposal_no'");
            
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    echo "Error Occured";
                } else {
                    $this->db->trans_commit();
                    $this->session->set_flashdata('message',"Deputy Commissioner / Aditional Deputy Commissioner's Report on Reclassification Case no # $case_no updated");
                    redirect(base_url() . "index.php/home");
                }
            }
        }

        public function ApprovedProposals() {
            $user_code = $this->session->userdata('user_code');
            $case_no = $this->input->GET('case_no');
            $q = "select * from t_reclassification where case_no = '$case_no'";
            $details = $this->db->query($q)->row();

            $dist_code = $this->utilityclass->getDistrictName($details->dist_code);
            $subdiv_code = $this->utilityclass->getSubDivName($details->dist_code, $details->subdiv_code);
            $cir_code = $this->utilityclass->getCircleName($details->dist_code, $details->subdiv_code, $details->cir_code);
            $mouza_pargona_code = $this->utilityclass->getMouzaName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code);
            $lot_no = $this->utilityclass->getLotName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no);
            $vill_townprt_code = $this->utilityclass->getVillageName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no, $details->vill_townprt_code);
            
            $co = $this->utilityclass->getSelectedCOName($details->dist_code, $details->subdiv_code, $details->cir_code, $user_code);
            $data['location'] = array(
                'dist' => $dist_code,
                'sub' => $subdiv_code,
                'cir' => $cir_code,
                'mouza' => $mouza_pargona_code,
                'lot' => $lot_no,
                'vill' => $vill_townprt_code,
                'co_name' => $co->username
            );

            $old_patta = $this->db->query("select * from patta_code where type_code = '$details->patta_type_code' ")->row();
            $old_land_class = $this->db->query("select * from landclass_code where class_code = '$details->present_land_class' ")->row();
            $proposed_land_class = $this->db->query("select * from landclass_code where class_code = '$details->proposed_land_class' ")->row();
            $data['app']=null;
            $data['det'] = array(
                'patta_type' => $old_patta->patta_type,
                'old_land_class' => $old_land_class->land_type,
                'proposed_land_class' => $proposed_land_class->land_type,
                'proposed_land_class_code' => $details->present_land_class,
                'pp_code'=>$details->proposed_land_class
            );
            $all_land_class = "Select * from landclass_code";
            $data['land_class'] = $this->db->query($all_land_class)->result();
            $application_no="select * from basundhar_application where dharitree='$case_no' ";
            $data['app'] = $this->db->query($application_no)->row();
            $data['Pcases'] = $details;
            $data['sup_doc']=$this->db->query("SELECT * FROM supportive_document WHERE case_no=?", array($case_no))->result();
            // $this->load->helper('html');
            // $this->load->view('../views/header');
            // $this->load->view('../views/LandReclassification/ApprovedProposals', $data);
            // $this->load->view('../views/footer');


            $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
            if($basundhara){
                $rtps=$this->rtpsmodel->checkBasundharaService($case_no);
                if($rtps=='RTPS'){
                    $data['basundharaAttachment']=$this->rtpsmodel->searchBasundharaLink($case_no);
                    $data['basundharaApp']=$this->rtpsmodel->searchBasundharaLinkApp($case_no);
                }else{
                    $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
                    $data['basundharaApp']=$this->basundharamodel->searchBasundharaLinkApp($case_no);
                }
            }

            $data['adc'] = $this->db->query("Select users.username as username, users.user_desig_code as user_desig_code, loginuser_table.user_code as user_code from    users, "
                        . "loginuser_table where users.dist_code = loginuser_table.dist_code and users.user_code = loginuser_table.user_code and users.user_desig_code like 'ADC%' and "
                        . "loginuser_table.dist_code='$details->dist_code' and loginuser_table.subdiv_code='00' and loginuser_table.cir_code='00' and loginuser_table.dis_enb_option = 'E' and loginuser_table.priv = 'adm'")->result();

            $data['_view'] = 'LandReclassification/ApprovedProposals';
            $this->load->view('layouts/main',$data);
        }
        
        public function SaveCoProcessRee() {
            $user_desig_code = $this->session->userdata('user_desig_code');
            $co_code = $this->session->userdata('user_code');
            //var_dump($this->input->post());
            //exit();
            $errorMessageStr = '';
            $resp = checkRequestSpecChar($_POST);
            if($resp['status'] == 'n'){
                $errorMessageStr .= $resp['messages'];
            }
            
            $resp = checkRequestValidQuery($_POST);
            if($resp['status'] == 'n'){
                $errorMessageStr .= $resp['messages'];
            }
            
            if($errorMessageStr != ''){
                $this->session->set_flashdata('message', $errorMessageStr);
                return redirect($_SERVER['HTTP_REFERER']);
            }

            if(!in_array($user_desig_code, ['CO'])){
                $this->session->set_flashdata('message', 'You are not authorized to perform this action');
                return redirect($_SERVER['HTTP_REFERER']);
            }

            $this->form_validation->set_rules('P_land_rev', 'Proposed land revenue', 'required|numeric|greater_than[-1]');
            // $this->form_validation->set_rules('p_local_tax', 'Proposed local tax', 'required|numeric|greater_than[-1]');
            $this->form_validation->set_rules('co_report', 'Report', 'required|max_length[1000]');
            $this->form_validation->set_rules('case_no', 'Case number', 'required');

            if ($this->form_validation->run() == FALSE)
            {
                $this->session->set_flashdata('message', validation_errors());
                return redirect($_SERVER['HTTP_REFERER']);
            }
            
            $proposal_no = $this->input->POST('proposal_no');
            $case_no = $this->input->POST('case_no');

            $details = $this->db->query("select * from t_reclassification where case_no =?", array($case_no))->row();
            if(!$details){
                log_message('error', '#ERRTRECLS10007: No such record found in the t_reclassfication table for case_no = ' . $case_no);
                $this->session->set_flashdata('message', '#ERRTRECLS10007: Something went wrong with the application.');

                return redirect($_SERVER['HTTP_REFERER']);
            }

            $cir_code = $this->utilityclass->getCircleName($details->dist_code, $details->subdiv_code, $details->cir_code);
            $co = $this->utilityclass->getSelectedCOName($details->dist_code, $details->subdiv_code, $details->cir_code, $co_code);
            
            $co_report_suffix = $co->username . ", চক্র বিষয়া, " . $cir_code;
            $co_report1 = $this->input->POST('co_report');
            // $co_report_suffix = $this->input->POST('co_report_suffix');
            $co_report = $co_report1." - ".$co_report_suffix;
            // $proposed_land_localtax = $this->input->post('p_local_tax');
            $new_land_class = $this->input->post('new_land_class');
            $co_report=$c_p = str_replace("'", '', $co_report);
            
            $proposed_land_revenue = $this->input->post('P_land_rev');
            $proposed_land_localtax = $proposed_land_revenue/4;
            $proposed_land_localtax = round($proposed_land_localtax, 4);

            $co_code = $this->session->userdata('user_code');
            $co_sign = 'Y';
            $co_date_entry = date('Y-m-d G:i:s');

            $adc_code = $this->input->POST('adc_code');
            //////////////////////////////////
            // var_dump($_FILES['fileUpload']);
            // die;
            if(isset($_FILES['fileUpload']['name'])){
            $this->form_validation->set_rules('fileText[]', 'Document Details', 'trim|xss_clean|required');
            $fileCount = count($_FILES['fileUpload']['name']);
            // validation for file type and file size
            for($i = 0; $i < $fileCount; $i++)
            {
                if($_FILES['fileUpload']['name'][$i] && $_FILES['fileUpload']['size'][$i] && $_FILES['fileUpload']['tmp_name'][$i]){
                    $name = $_FILES['fileUpload']['name'][$i];
                    $size = $_FILES['fileUpload']['size'][$i];
                    $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
                    $exp  = explode("/",$mime);
                    $ext  = $exp[1];
                        if($name != NULL)
                        {
                            if($ext == NULL)
                            {
                                // todo error show extension missing
                                $this->session->set_flashdata('message', "File Not Supported. Error Code(#FAPL001)");
                                redirect(base_url() . "index.php/home");
                            }
                            if(! in_array($ext, UPLOAD_TYPE_VALIDATION))
                            {
                                // todo error show file allow type not match
                                $this->session->set_flashdata('message', "File Not Supported (ONLY JPG/PNG/PDF). Error Code(#FAPL002)");
                                redirect(base_url() . "index.php/home");
                            }
                            if($size > UPLOAD_MAX_SIZE)
                            {
                                $this->session->set_flashdata('message', "Maximum 2MB file size. Error Code(#FAPL003)");
                                redirect(base_url() . "index.php/home");
                            }

                        }
                        else
                        {
                            $this->session->set_flashdata('message', "File name cann't be empty. Error Code(#FAPL004)");
                            redirect(base_url() . "index.php/home");
                        }
                    }
                    else{
                        $this->session->set_flashdata('message', "File is required. Error Code(#FAPL005)");
                        redirect(base_url() . "index.php/home");
                    }
                }
            }
            ///////////////////Insert attached file////////////////////////
            $this->db->trans_begin();
            $this->UtilsModel->uploadFile($case_no);
            $sql="Select co_recommendation from t_reclassification WHERE case_no = '$case_no' and proposal_no = '$proposal_no'";
            $co_recomm_old=$this->db->query($sql)->row()->co_recommendation;
            $co_report=$co_recomm_old."<br>".$co_report;
            $this->db->query("UPDATE t_reclassification SET co_recommendation = '$co_report', co_recom_date = '$co_date_entry', co_yn = '$co_sign', "
                    . "co_date = '$co_date_entry', proposed_land_revenue = '$proposed_land_revenue', proposed_land_localtax = '$proposed_land_localtax',"
                    . " proposed_land_class='$new_land_class', status='A', adc_code='$adc_code' WHERE case_no = '$case_no' and proposal_no = '$proposal_no'");
            ////////////////////
            $sql="Select * from t_reclassification WHERE case_no = '$case_no' and proposal_no = '$proposal_no'";
            $tclass=$this->db->query($sql)->row();

            $prodId=$this->maxProceedingID($case_no);
            $proArray= array(
                'case_no' => $case_no,
                'proceeding_id' => $prodId,
                'user_code' => $this->session->userdata('user_code'),
                'status' => 'Pending',
                'co_order'=>$c_p,
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E',
                'dist_code' => $tclass->dist_code,
                'subdiv_code' => $tclass->subdiv_code,
                'cir_code' => $tclass->cir_code,
                'ip' => $this->utilityclass->get_client_ip()
                 );
            $this->db->insert('petition_proceeding_dc_adc',$proArray);

            ///////////////////
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo "Error Occured";
            } else {
                //$this->db->trans_commit();
                //////////////////////////
                $application_no=$this->input->post('application_no');
                if($application_no)
                {

                        //START ESCALATION FOR CO PROCESS===========
                        $dist_code=$this->session->userdata('dist_code');
                        $subdiv_code=$this->session->userdata('subdiv_code');
                        $cir_code= $this->session->userdata('cir_code');

                        $user_code = $this->session->userdata('user_code');
                        $sql="Select es_flag,out_of_esc from t_reclassification WHERE case_no = ? and proposal_no = ?";
                        $details=$this->db->query($sql,array($case_no,$proposal_no))->row();
                        if($details->es_flag == 1 && ESCALATION_ENABLE == 1 && $details->out_of_esc == 0)
                        {
                            $executionDate = $this->input->post('executionDate');
                            $escalationUpdateStatus = $this->Escalationmodel->escalationCOProcessRECLASS($executionDate,$dist_code,$subdiv_code,$cir_code,$case_no,$user_code);
                            log_message("error", "#ESC2137, transaction-error-STATUS======".json_encode($escalationUpdateStatus));

                            if($escalationUpdateStatus['responseType'] == 0){
                                $this->db->trans_rollback();
                                log_message("error", "#ESC2137, transaction-error in method 'LandReclassification/SaveCoProcessRee' with case-no :". $case_no);
                                $this->session->set_flashdata('message', "Something went wrong.RECLASS Error Code(#ESC2137)");
                                redirect(base_url() . "index.php/home");
                            }
                        }

                        $rtps=$this->rtpsmodel->checkRtpsService($application_no);
                        if($rtps=='RTPS'){
                            $apilink=RTPS_API_LINK;
                        }else{
                            $apilink=API_LINK;
                        }
                        $curl_handle = curl_init();
                        curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
                        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
                        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                            'application' => $application_no,
                            'dharitree' => $case_no,
                            'rmk' => 'Forwared to ADC',
                            'status' => 'M',
                            'task' => 'CO',
                            'pen'=>'ADC',
                            'penat'=>'DC office'
                        )));
                        $result = curl_exec($curl_handle);
                        if($result==true){


                            


                            $this->db->trans_commit();
                        }else{
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message',"Error in API Call");
                            redirect(base_url() . "index.php/home");
                        }
                }
                /////////////////////////
                $this->db->trans_commit();
                $penUser='ADC';
                $rmrk='Re-report by CO';
                $this->DashboardData($case_no,$penUser,$rmrk);
                $this->session->set_flashdata('message',"Circle Officer's Report on Reclassification Case no # $case_no");
                redirect(base_url() . "index.php/home");
            }
        }
        function FinalProcessDC(){
            $user_dist_code = $this->session->userdata('dist_code');
            $dc_code = $this->session->userdata('user_code');
            $user_desig_code = $this->session->userdata('user_desig_code');
            
            $this->form_validation->set_rules('revarted', 'Type', 'required|matches[F|R|A|C]');
            $this->form_validation->set_rules('P_land_rev', 'Proposed land revenue', 'required|numeric|greater_than[-1]');
            // $this->form_validation->set_rules('p_local_tax', 'Proposed local tax', 'required|numeric|greater_than[-1]');
            $this->form_validation->set_rules('dc_report', 'Report', 'required|max_length[1000]');
            $this->form_validation->set_rules('case_no', 'Case number', 'required');

            if ($this->form_validation->run() == FALSE)
            {
                $this->session->set_flashdata('message', validation_errors());
                return redirect($_SERVER['HTTP_REFERER']);
            }

            $dc_report1 = $this->input->POST('dc_report');
            $revarted = $this->input->POST('revarted');
            $case_no = $this->input->POST('case_no');

            if(!in_array($user_desig_code, ['DC'])){
                $this->session->set_flashdata('message', 'You are not authorized to perform this action');
                return redirect($_SERVER['HTTP_REFERER']);
            }
 
            $errorMessageStr = '';
            $resp = checkRequestSpecChar($_POST);
            if($resp['status'] == 'n'){
                $errorMessageStr .= $resp['messages'];
            }

            $resp = checkRequestValidQuery($_POST);
            if($resp['status'] == 'n'){
                $errorMessageStr .= $resp['messages'];
            }

            if($errorMessageStr != ''){
                $this->session->set_flashdata('message', $errorMessageStr);
                return redirect($_SERVER['HTTP_REFERER']);
            }

            $basundhara_application = $this->db->query("select * from basundhar_application where dharitree=?", array($case_no))->row();
            // if(!$basundhara_application){
            //     log_message('error', '#ERRDCBSNDAP00001: No such application found in the basundhar_application table for dharitree = ' . $case_no);
            //     $this->session->set_flashdata('message', '#ERRDCBSNDAP00001: No such application found');

            //     return redirect($_SERVER['HTTP_REFERER']);
            // }
            
            $tclass = $this->db->query("select * from t_reclassification where case_no =?", array($case_no))->row();
            if(!$tclass){
                log_message('error', '#ERRDCTRECLS10006: No such record found in the t_reclassfication table for case_no = ' . $case_no);
                $this->session->set_flashdata('message', '#ERRDCTRECLS10006: Something went wrong with the application.');
                
                return redirect($_SERVER['HTTP_REFERER']);
            }




            // if(in_array($tclass->status,['C', 'D'])){
            //     $this->session->set_flashdata('message', 'This case is already submitted.');

            //     return redirect($_SERVER['HTTP_REFERER']);
            // }

            // if(!in_array($tclass->status, ['A'])){
            //     log_message('error', '#ERRADCCSFWD10001: Case doesn\'t belong to the login user for case_no = ' . $case_no . ' as this case\'s status is ' . $tclass->status);
            //     $this->session->set_flashdata('message', '#ERRADCCSFWD10001: This case doesn\'t belong to you.');
    
            //     return redirect($_SERVER['HTTP_REFERER']);
            // }

            if($tclass->dist_code != $user_dist_code){
                $this->session->set_flashdata('message', 'This case doesn\'t belong to you.');

                return redirect($_SERVER['HTTP_REFERER']);
            }

            $adc = $this->utilityclass->getSelectedCOName($tclass->dist_code, '00', '00', $dc_code);

            $application_no = $basundhara_application ? $basundhara_application->basundhara : NULL;
            $proposal_no = $tclass->proposal_no;
            
            $dc_report_suffix = $adc->username . ", উপায়ুক্ত";
            $dc_report = $dc_report1." - ".$dc_report_suffix;
            $dc_report = str_replace("'", '', $dc_report);
            // $proposed_land_revenue = $tclass->proposed_land_revenue;
            // $proposed_land_localtax = $tclass->proposed_land_localtax;

            // $dc_report_suffix = $this->input->POST('dc_report_suffix');
            // $revarted = $this->input->POST('revarted');
            // $dc_report = $dc_report1." - ".$dc_report_suffix;
            //echo $dc_report;
            $proposed_land_revenue = $this->input->post('P_land_rev');
            $proposed_land_localtax = $proposed_land_revenue/4;
            $proposed_land_localtax = round($proposed_land_localtax, 4);

            // $proposed_land_localtax = $this->input->post('p_local_tax');
            // $dc_report = str_replace("'", '', $dc_report);
            
            $dc_sign = 'Y';
            $dc_date_entry = date('Y-m-d G:i:s');
            $this->db->trans_begin();
            $application_no=$this->input->post('application_no');

            if($revarted=='F'){
                /////Final Order//////
                $status='Final';
                //////////update the time frame if DC done the final order//////////////
                $user_desig_code = $this->session->userdata('user_desig_code');
                if(ESCALATION_ENABLE == 1 && $tclass->es_flag == 1)
                {
                    $escalationUpdateTimeFrame = $this->Escalationmodel->escalationUpdateTimeFrame($executionDate,$tclass->dist_code,$case_no,$dc_code,$user_desig_code,'RECLASS');
                    log_message("error", "#ESC2620, transaction-error-STATUS======".json_encode($escalationUpdateTimeFrame));
                    if($escalationUpdateTimeFrame['responseType'] == 1)
                    {
                        $this->db->trans_rollback();
                        log_message("error", "#ESC2822, transaction-error in method 'LandReclassification/FinalProcessDC' with case-no :". $case_no);
                        $this->session->set_flashdata('message', "Something went wrong.RECLASS- Error Code(#ESC2822)");
                        redirect(base_url() . "index.php/home");
                    }
                }
                
                ////////////////////END////////////////////////////
            }elseif($revarted=='R'){
                ///////////Reject Order/////////////
                $status='Reject';
                $date_entry = date('Y-m-d');
                $update_data = [
                                'status' => 'R',
                                'status_date' => $date_entry,
                            ];

                $this->db->update('t_reclassification', $update_data, array('case_no' => $case_no, 'proposal_no' => $proposal_no));
                // $this->db->query("UPDATE t_reclassification SET status = 'R', status_date = '$date_entry' WHERE case_no = '$case_no' and  proposal_no = '$proposal_no'");
                $penUser='NA';
                $rmrk='Rejected by DC';
                $this->DashboardDataReject($case_no,$penUser,$rmrk);  
                if($application_no)
                {
                    $rtps=$this->rtpsmodel->checkRtpsService($application_no);
                    if($rtps=='RTPS'){
                        $apilink=RTPS_API_LINK;
                    }else{
                        $apilink=API_LINK;
                    }
                    $curl_handle = curl_init();
                    curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
                    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 10); // setting 10 seconds 
                    curl_setopt($curl_handle, CURLOPT_TIMEOUT, 30); // setting 30 seconds
                    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                        'application' => $application_no,
                        'dharitree' => $case_no,
                        'rmk' => 'Rejected by DC',
                        'status' => 'R',
                        'task' => 'DC',
                        'pen'=>'N/A',
                        'penat'=>'DC office'
                    )));
                    $result = curl_exec($curl_handle);
                    if($result==true){
                        // $this->db->trans_commit();
                    }else{
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message',"Error in API Call");
                        // redirect(base_url() . "index.php/home");
                        return redirect($_SERVER['HTTP_REFERER']);
                    }
                }
                $this->db->trans_commit();
                $this->session->set_flashdata('message',"Case has been rejected having case no $case_no ");
                redirect(base_url() . "index.php/home");    
            }elseif($revarted=='A'){
                ///////////Revert To ADC/////////////
                $status='Reject';
                $date_entry = date('Y-m-d');
                $update_data = [
                                'status' => 'A',
                                'status_date' => $date_entry,
                            ];

                $this->db->update('t_reclassification', $update_data, array('case_no' => $case_no, 'proposal_no' => $proposal_no));
                // $this->db->query("UPDATE t_reclassification SET status = 'A', status_date = '$date_entry' WHERE case_no = '$case_no' and  proposal_no = '$proposal_no'");


                //START ESCALATION FOR CO PROCESS===========
                $dist_code=$this->session->userdata('dist_code');
                $user_code = $this->session->userdata('user_code');
                $sql="Select es_flag,out_of_esc from t_reclassification WHERE case_no =? and proposal_no =?";
                $es_flag_data=$this->db->query($sql, array($case_no, $proposal_no))->row();
                if($es_flag_data->es_flag == 1 && ESCALATION_ENABLE == 1 && $es_flag_data->out_of_esc == 0 ){
                    $executionDate = $this->input->post('executionDate');
                    $allocation_days = $this->input->post('allocate_day');
                    // $executionDate= date('Y-m-d');
                    $escalationUpdateStatus = $this->Escalationmodel->escalationDCRevertADCRECLASS($executionDate,$allocation_days,$dist_code,$case_no,$user_code);
                    
                    log_message("error", "#ESC2377, transaction-error-STATUS======".json_encode($escalationUpdateStatus));

                    if($escalationUpdateStatus['responseType'] == 0){
                        $this->db->trans_rollback();
                        log_message("error", "#ESC2377, transaction-error in method 'LandReclassification/FinalProcessDC' with case-no :". $case_no);
                        $this->session->set_flashdata('message', "Something went wrong. Error Code(#ESC2377)");
                        redirect(base_url() . "index.php/home");
                    }
                }
                ///////
                $penUser='ADC';
                $rmrk='Reverted by DC';
                $this->DashboardData($case_no,$penUser,$rmrk);
                //////

                if($application_no)
                {
                    $rtps=$this->rtpsmodel->checkRtpsService($application_no);
                    if($rtps=='RTPS'){
                        $apilink=RTPS_API_LINK;
                    }else{
                        $apilink=API_LINK;
                    }
                    $curl_handle = curl_init();
                    curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
                    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 10); // setting 10 seconds 
                    curl_setopt($curl_handle, CURLOPT_TIMEOUT, 30); // setting 30 seconds
                    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                        'application' => $application_no,
                        'dharitree' => $case_no,
                        'rmk' => 'Reverted by DC',
                        'status' => 'M',
                        'task' => 'DC',
                        'pen'=>'ADC',
                        'penat'=>'DC office'
                    )));
                    $result = curl_exec($curl_handle);
                    if($result==true){

                        


                        $this->db->trans_commit();
                    }else{
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message',"Error in API Call");
                        // redirect(base_url() . "index.php/home");
                        return redirect($_SERVER['HTTP_REFERER']);
                    }
                }
                $this->db->trans_commit();
                $this->session->set_flashdata('message',"Case has been reverted back by DC with case no $case_no ");
                // echo "string";die;
                //////////////////////////////////
                $data=array(
                    'success'=>"Case has been reverted having case no $case_no",
                    'redirect_url'=>base_url().'index.php/home'
                );
                redirect(base_url() . "index.php/home");
           
             echo json_encode($data);
                
                
            }else{

                /////////Revert To CO////////////
                $status='Pending';
                $date_entry = date('Y-m-d');
                $update_data = [
                                'status' => 'C',
                                'status_date' => $date_entry,
                            ];

                $this->db->update('t_reclassification', $update_data, array('case_no' => $case_no, 'proposal_no' => $proposal_no));
                // $this->db->query("UPDATE t_reclassification SET status = 'C', status_date = '$date_entry' WHERE case_no = '$case_no' and  proposal_no = '$proposal_no'");

                //START ESCALATION FOR CO PROCESS===========
                $dist_code=$this->session->userdata('dist_code');
                $user_code = $this->session->userdata('user_code');
                $sql="Select es_flag,out_of_esc from t_reclassification WHERE case_no =? and proposal_no =?";
                $es_flag_data=$this->db->query($sql, array($case_no, $proposal_no))->row();
                if($es_flag_data->es_flag == 1 && ESCALATION_ENABLE == 1 && $es_flag_data->out_of_esc == 0){
                    $executionDate = $this->input->post('executionDate');
                    $allocation_days = $this->input->post('allocate_day');
                    // $executionDate= date('Y-m-d');
                    $escalationUpdateStatus = $this->Escalationmodel->escalationDCRevertCoRECLASS($executionDate,$allocation_days,$dist_code,$tclass->subdiv_code,$tclass->cir_code,$case_no,$user_code);
                    
                    log_message("error", "#ESC2466, transaction-error-STATUS======".json_encode($escalationUpdateStatus));

                    if($escalationUpdateStatus['responseType'] == 0){
                        $this->db->trans_rollback();
                        log_message("error", "#ESC2466, transaction-error in method 'LandReclassification/FinalProcessDC' with case-no :". $case_no);
                        $this->session->set_flashdata('message', "Something went wrong.RECLASS- Error Code(#ESC2466)");
                        redirect(base_url() . "index.php/home");
                    }
                }

                 ///////
                $penUser='CO';
                $rmrk='Reverted by DC to CO';
                $this->DashboardData($case_no,$penUser,$rmrk);
                //////
                if($application_no)
                {
                    $rtps=$this->rtpsmodel->checkRtpsService($application_no);
                    if($rtps=='RTPS'){
                        $apilink=RTPS_API_LINK;
                    }else{
                        $apilink=API_LINK;
                    }
                    $curl_handle = curl_init();
                    curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
                    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 10); // setting 10 seconds 
                    curl_setopt($curl_handle, CURLOPT_TIMEOUT, 30); // setting 30 seconds
                    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                        'application' => $application_no,
                        'dharitree' => $case_no,
                        'rmk' => 'Reverted by DC',
                        'status' => 'M',
                        'task' => 'DC',
                        'pen'=>'CO',
                        'penat'=>'DC office'
                    )));
                    $result = curl_exec($curl_handle);
                    $result = curl_exec($curl_handle);
                    if($result==true){

                        


                        // $this->db->trans_commit();
                    }else{
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message',"Error in API Call");
                        // redirect(base_url() . "index.php/home");
                        return redirect($_SERVER['HTTP_REFERER']);
                    }
                }
                $this->db->trans_commit();
                $this->session->set_flashdata('message',"Case has been reverted back by DC with case no $case_no ");
                // echo "string";die;
                //////////////////////////////////
                $data=array(
                    'success'=>"Case has been reverted having case no $case_no",
                    'redirect_url'=>base_url().'index.php/home'
                );
                redirect(base_url() . "index.php/home");
           
             // echo json_encode($data);
                
            }
            /////////////ProCedding///////////////////////
            // $sql="Select * from t_reclassification WHERE case_no =? and proposal_no =?";
            // $tclass=$this->db->query($sql, array($case_no, $proposal_no))->row();

            $prodId=$this->maxProceedingID($case_no);
            $proArray= array(
                'case_no' => $case_no,
                'proceeding_id' => $prodId,
                'user_code' => $this->session->userdata('user_code'),
                'status' => $status,
                'co_order'=>$dc_report,
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E',
                'dist_code' => $tclass->dist_code,
                'subdiv_code' => $tclass->subdiv_code,
                'cir_code' => $tclass->cir_code,
                'ip' => $this->utilityclass->get_client_ip()
                 );
            $this->db->insert('petition_proceeding_dc_adc',$proArray);
            if($status!='Final'){
                redirect(base_url() . "index.php/home");
                exit;
            }


            //==========check dag pending in blockchain or not=================
                if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                {
                      $checkVal = $this->PropChainCommonModel->checkDagExistsInPropChainInPending($tclass->dist_code,$tclass->subdiv_code,$tclass->cir_code,$tclass->mouza_pargona_code,$tclass->lot_no,$tclass->vill_townprt_code,$tclass->dag_no);
                      if($checkVal === false)
                      {
                          $this->db->trans_rollback();
                          $this->session->set_flashdata('message', "#ERRORBLOCCHAIN6166 : You cannot procced as dag no is pending for property chain update...");
                          redirect(base_url() . "index.php/home");
                      }
                }
                ///=============end CODE=====================
                
            /////////////////////////
            //exit;
            $update_data = [
                            'dc_approval' => $dc_report,
                            'dc_approval_date' => $dc_date_entry,
                            // 'dc_yn' => $dc_sign,
                            'dc_date' => $dc_date_entry,
                            'proposed_land_revenue' => $proposed_land_revenue,
                            'proposed_land_localtax' => $proposed_land_localtax,
                        ];

            $this->db->update('t_reclassification', $update_data, array('case_no' => $case_no, 'proposal_no' => $proposal_no));

            // $this->db->query("UPDATE t_reclassification SET dc_approval = '$dc_report', dc_approval_date = '$dc_date_entry', dc_yn = '$dc_sign', dc_date = '$dc_date_entry', "
            //             . "proposed_land_revenue = '$proposed_land_revenue',proposed_land_localtax = '$proposed_land_localtax' WHERE case_no = '$case_no' and proposal_no = '$proposal_no'");
            //////////
            $penUser='DC';
            $rmrk='Approval by DC';
            $this->DashboardData($case_no,$penUser,$rmrk);
            ///////
            $details = $tclass;
            // $q = "select * from t_reclassification where case_no =? and proposal_no =?";
            // $details = $this->db->query($q, array($case_no, $proposal_no))->row();
            $old_patta = $this->db->query("select * from patta_code where type_code = '$details->patta_type_code' ")->row();
            $old_land_class = $this->db->query("select * from landclass_code where class_code = '$details->present_land_class' ")->row();
            $proposed_land_class = $this->db->query("select * from landclass_code where class_code = '$details->proposed_land_class' ")->row();

            $data['det'] = array(
                'patta_type' => $old_patta->patta_type,
                'old_land_class' => $old_land_class->land_type,
                'proposed_land_class' => $proposed_land_class->land_type,
                'case_no' => $case_no,
                'proposal_no' => $proposal_no
            );

            $data['Pcases'] = $details;
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                log_message('error', '#ERRDCFNLPRC10001: Something went wrong. QUERY: ' . $this->db->last_query());
                $this->session->set_flashdata('message',"#ERRDCFNLPRC10001: Something went wrong. Please try again later.");
                return redirect($_SERVER['HTTP_REFERER']);
                // echo "Error Occured";
            } else {
                // if($application_no)
                // {
                //     $rtps=$this->rtpsmodel->checkRtpsService($application_no);
                //     if($rtps=='RTPS'){
                //         $apilink=RTPS_API_LINK;
                //     }else{
                //         $apilink=API_LINK;
                //     }
                //     $curl_handle = curl_init();
                //     curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
                //     curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                //     curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                //     curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                //     curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                //         'application' => $application_no,
                //         'dharitree' => $case_no,
                //         'rmk' => 'Final order by DC',
                //         'status' => 'F',
                //         'task' => 'DC',
                //         'pen'=>'Approved',
                //         'penat'=>'Dc office'
                //     )));
                //     $result = curl_exec($curl_handle);
                //     if($result==true){
                //         $this->db->trans_commit();
                //     }else{
                //         $this->db->trans_rollback();
                //         $this->session->set_flashdata('message',"Error in API CALL ");
                //         redirect('/home');
                //     }
                // }
                
                //START ESCALATION FOR CO PROCESS===========

                //ESCALATION ==============




                $dist_code=$this->session->userdata('dist_code');
                $user_code = $this->session->userdata('user_code');
                $sql="Select es_flag,out_of_esc from t_reclassification WHERE case_no =?";
                $es_flag_data=$this->db->query($sql, array($case_no))->row();
                if($es_flag_data->es_flag == 1 && ESCALATION_ENABLE == 1 && $es_flag_data->out_of_esc == 0){
                    $executionDate = $this->input->post('executionDate');

                    if(ESCALATION_REMARK_ENABLE ==1)
                    {

                        $responseEsc = $this->Escalationmodel->escalationRemarkCheckandUpdate($case_no,$this->input->post('esc_remark'),$this->session->userdata('user_desig_code'));
                        if($responseEsc['responseType'] == 1)
                        {
                            $this->db->trans_rollback();
                            $data=array(
                                'error'=>"#ERRFPARTESCREMARK2374 : Error in submitting in escalation remarks. Please try Again"
                            );
                            echo json_encode($data);
                            return false;
                        }

                    }
                    ///END+==================
                     

                    $escalationUpdateStatus = $this->Escalationmodel->escalationDCProcessRECLASS($executionDate,$dist_code,$case_no,$user_code);

                    log_message("error", "#ESC2620, transaction-error-STATUS======".json_encode($escalationUpdateStatus));

                    if($escalationUpdateStatus['responseType'] == 0){
                        $this->db->trans_rollback();
                        log_message("error", "#ESC2620, transaction-error in method 'LandReclassification/FinalProcessDC' with case-no :". $case_no);
                        $this->session->set_flashdata('message', "Something went wrong.RECLASS- Error Code(#ESC2620)");
                        redirect(base_url() . "index.php/home");
                    }
                }
                $this->db->trans_commit();
                // $this->session->set_flashdata('message',"Case has been Approved by DC with case no $case_no ");

                if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                {

                $data['ulpin'] = $this->input->post('ulpin', true);
                $data['ulpinCheckFlag'] = $this->input->post('ulpinCheckFlag', true);
                $data['compareCheckFlag'] = $this->input->post('compareCheckFlag', true);

                }

                $params = [
                  'case_no'          => $case_no,
                  'service_code'     => 4,
                  'remarks'          => 'Reclassification',
                  'accessed_entity'  => 'Aadhaar Status',
                ];
                $this->load->model('EkycLogModel');
                $log = $this->EkycLogModel->insertEkycAccessedBy($this->db, $params);

                $data['_view'] = 'LandReclassification/Confirm';
                $this->load->view('layouts/main',$data);
            }
        }
        public function FinalProcess() {
            $user_dist_code = $this->session->userdata('dist_code');
            $dc_code = $this->session->userdata('user_code');
            $user_desig_code = $this->session->userdata('user_desig_code');
            
            $this->form_validation->set_rules('revarted', 'Type', 'required|matches[Y|N]');
            // $this->form_validation->set_rules('P_land_rev', 'Proposed land revenue', 'required|numeric|greater_than[-1]');
            // $this->form_validation->set_rules('p_local_tax', 'Proposed local tax', 'required|numeric|greater_than[-1]');
            $this->form_validation->set_rules('dc_report', 'Report', 'required|max_length[1000]');
            $this->form_validation->set_rules('case_no', 'Case number', 'required');

            if ($this->form_validation->run() == FALSE)
            {
                $this->session->set_flashdata('message', validation_errors());
                return redirect($_SERVER['HTTP_REFERER']);
            }

            $dc_report1 = $this->input->POST('dc_report');
            $revarted = $this->input->POST('revarted');
            // $proposal_no = $this->input->POST('proposal_no');
            $case_no = $this->input->POST('case_no');

            // $proposed_land_revenue = $this->input->post('P_land_rev');
            // $proposed_land_localtax = $proposed_land_revenue/4;
            // $proposed_land_localtax = round($proposed_land_localtax, 4);
            // $proposed_land_localtax = $this->input->post('p_local_tax');
            

            // $application_no = $this->input->POST('application_no');
            // $dc_report_suffix = $this->input->POST('dc_report_suffix');
            // $dc_report = $dc_report1." - ".$dc_report_suffix;
            //echo $dc_report;
            // $dc_report = str_replace("'", '', $dc_report);

            if(!in_array($user_desig_code, ['ADC'])){
                $this->session->set_flashdata('message', 'You are not authorized to perform this action');
                return redirect($_SERVER['HTTP_REFERER']);
            }
 
            
            $error_data_messages_arr = [];
            // $proposal_no = $this->input->POST('proposal_no');

            $caseNoValidate = caseNumberValidation($case_no);
            if(count($caseNoValidate)){
                array_push($error_data_messages_arr, $caseNoValidate['message']);
            }
            
            $response = isValidQuery($case_no);
            if($response['status'] == 'n'){
                array_push($error_data_messages_arr, 'Case number has MALECIOUS QUERY');
            }
            
            $response = specialCharacterCheckingInInput($dc_report1, ['.', ',', '|', '-',':','।','\''], 'Report');
            if($response['status'] == 'n'){
                array_push($error_data_messages_arr, $response['message']);
            }

            $response = isValidQuery($dc_report1);
            if($response['status'] == 'n'){
                array_push($error_data_messages_arr, 'Report has MALECIOUS QUERY');
            }
            
            if(count($error_data_messages_arr)){
                $error_messages = convertArrayToHtmlUlLi($error_data_messages_arr);
                $this->session->set_flashdata('message', $error_messages);
                return redirect($_SERVER['HTTP_REFERER']);
            }

            $basundhara_application = $this->db->query("select * from basundhar_application where dharitree=?", array($case_no))->row();
            // if(!$basundhara_application){
            //     log_message('error', '#ERRADCBSNDAP00001: No such application found in the basundhar_application table for dharitree = ' . $case_no);
            //     $this->session->set_flashdata('message', '#ERRADCBSNDAP00001: No such application found');

            //     return redirect($_SERVER['HTTP_REFERER']);
            // }
            
            $tclass = $this->db->query("select * from t_reclassification where case_no =?", array($case_no))->row();
            if(!$tclass){
                log_message('error', '#ERRADCTRECLS10006: No such record found in the t_reclassfication table for case_no = ' . $case_no);
                $this->session->set_flashdata('message', '#ERRADCTRECLS10006: Something went wrong with the application.');
                
                return redirect($_SERVER['HTTP_REFERER']);
            }


            //ESCALATION ==============
            if(ESCALATION_ENABLE == 1 && $tclass->es_flag == 1 && ESCALATION_REMARK_ENABLE ==1 && $tclass->out_of_esc == 0)
            {

                $responseEsc = $this->Escalationmodel->escalationRemarkCheckandUpdate($case_no,$this->input->post('esc_remark'),$this->session->userdata('user_desig_code'));
                if($responseEsc['responseType'] == 1)
                {
                    $this->db->trans_rollback();
                    $data=array(
                        'error'=>"#ERRFPARTESCREMARK2882 : Error in submitting in escalation remarks. Please try Again"
                    );
                    echo json_encode($data);
                    return false;
                }

            }
            ///END+==================

            if(in_array($tclass->status,['C', 'D'])){
                $this->session->set_flashdata('message', 'This case is already submitted.');

                return redirect($_SERVER['HTTP_REFERER']);
            }

            if(!in_array($tclass->status, ['A'])){
                log_message('error', '#ERRADCCSFWD10001: Case doesn\'t belong to the login user for case_no = ' . $case_no . ' as this case\'s status is ' . $tclass->status);
                $this->session->set_flashdata('message', '#ERRADCCSFWD10001: This case doesn\'t belong to you.');
    
                return redirect($_SERVER['HTTP_REFERER']);
            }

            if($tclass->dist_code != $user_dist_code){
                $this->session->set_flashdata('message', 'This case doesn\'t belong to you.');

                return redirect($_SERVER['HTTP_REFERER']);
            }

            $adc = $this->utilityclass->getSelectedCOName($tclass->dist_code, '00', '00', $dc_code);

            $application_no = $basundhara_application ? $basundhara_application->basundhara : NULL;
            $proposal_no = $tclass->proposal_no;
            
            $dc_report_suffix = $adc->username . ", অতিৰিক্ত উপায়ুক্ত";
            $dc_report = $dc_report1." - ".$dc_report_suffix;
            $dc_report = str_replace("'", '', $dc_report);


            $this->db->trans_begin();
            // $dc_code = $this->session->userdata('user_code');
            $dc_sign = 'Y';
            $dc_date_entry = date('Y-m-d G:i:s');
            //////////////////////////////
            // $sql="Select * from t_reclassification WHERE case_no = '$case_no' and proposal_no = '$proposal_no'";
            // $tclass=$this->db->query($sql)->row();

            $prodId=$this->maxProceedingID($case_no);
            $proArray= array(
                'case_no' => $case_no,
                'proceeding_id' => $prodId,
                'user_code' => $this->session->userdata('user_code'),
                'status' => 'Pending',
                'co_order'=>$dc_report,
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E',
                'dist_code' => $tclass->dist_code,
                'subdiv_code' => $tclass->subdiv_code,
                'cir_code' => $tclass->cir_code,
                'ip' => $this->utilityclass->get_client_ip()
                );
            $this->db->insert('petition_proceeding_dc_adc',$proArray);
            ////////////////////////////
            if($revarted=='Y'){
                $sql="Select adc_report from t_reclassification WHERE case_no =? and proposal_no =?";
                $adc_previous=$this->db->query($sql, array($case_no, $proposal_no))->row()->adc_report;
                $dc_report = $dc_report ."<br>". $adc_previous  ;
                $update_data = [
                                    'status' => 'C',
                                    'adc_report' => $dc_report,
                                ];

                $this->db->update('t_reclassification', $update_data, array('case_no' => $case_no, 'proposal_no' => $proposal_no));

                // $this->db->query("UPDATE t_reclassification SET adc_report = '$dc_report',status='C'  WHERE case_no = '$case_no' and proposal_no = '$proposal_no'");
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    // echo "Error Occured";
                    log_message('error', '#ERRADCYCASEFRWD10001: Server error for case_no = ' . $case_no);
                    $this->session->set_flashdata('message', '#ERRADCYCASEFRWD10001: Something went wrong with the application.');

                    return redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $penUser='CO';
                    $rmrk='Reverted by ADC to CO';
                    $this->DashboardData($case_no,$penUser,$rmrk);
                    if($application_no)
                    {
                            //START ESCALATION FOR CO PROCESS===========
                            $dist_code=$this->session->userdata('dist_code');
                            $subdiv_code = $tclass->subdiv_code;
                            $cir_code = $tclass->cir_code;
                            $user_code = $this->session->userdata('user_code');
                            $sql="Select es_flag,out_of_esc from t_reclassification WHERE case_no =? and proposal_no =?";
                            $es_flag_data=$this->db->query($sql, array($case_no, $proposal_no))->row();
                            if($es_flag_data->es_flag == 1 && ESCALATION_ENABLE == 1 && $es_flag_data->out_of_esc == 0){
                                $executionDate = $this->input->post('executionDate');
                                $allocation_days = null;

                                if($this->input->post('allocate_day') !=null){
                                    $allocation_days = $this->input->post('allocate_day');
                                }
           
                                $escalationUpdateStatus = $this->Escalationmodel->escalationADCRevertCoRECLASS($executionDate,$allocation_days,$dist_code,$subdiv_code,$cir_code,$case_no,$user_code);
                                
                                log_message("error", "#ESC2850, transaction-error-STATUS======".json_encode($escalationUpdateStatus));

                                if($escalationUpdateStatus['responseType'] == 0){
                                    $this->db->trans_rollback();
                                    log_message("error", "#ESC2850, transaction-error in method 'LandReclassification/FinalProcessRevertCO' with case-no :". $case_no);
                                    $this->session->set_flashdata('message', "Something went wrong. Error Code(#ESC2850)");
                                    redirect(base_url() . "index.php/home");
                                }
                            }
                            $rtps=$this->rtpsmodel->checkRtpsService($application_no);
                            if($rtps=='RTPS'){
                                $apilink=RTPS_API_LINK;
                            }else{
                                $apilink=API_LINK;
                            }
                            $curl_handle = curl_init();
                            curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
                            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                            curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 10); // setting 10 seconds 
                            curl_setopt($curl_handle, CURLOPT_TIMEOUT, 30); // setting 30 seconds
                            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                            'application' => $application_no,
                            'dharitree' => $case_no,
                            'rmk' => 'forwared to CO',
                            'status' => 'M',
                            'task' => 'ADC',
                            'pen'=>'CO',
                            'penat'=>'DC office'
                            )));
                            $result = curl_exec($curl_handle);
                            if($result==true){

                                
                                $this->db->trans_commit();
                            }else{
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('message',"Error in API CALL ");
                                return redirect($_SERVER['HTTP_REFERER']);
                                // redirect('/home');
                            }
                    } 
                    $this->db->trans_commit();
                    $this->session->set_flashdata('message',"ADC's Report on Reclassification Case no with case no $case_no ");
                }
            }else{
                $sql="Select adc_report,es_flag from t_reclassification WHERE case_no =? and proposal_no =?";
                $adc_previous=$this->db->query($sql, array($case_no, $proposal_no))->row()->adc_report;
                $dc_report = $dc_report ."\n". $adc_previous  ;

                $update_data = [
                                    'status' => 'D',
                                    'adc_report' => $dc_report,
                                ];

                $this->db->update('t_reclassification', $update_data, array('case_no' => $case_no, 'proposal_no' => $proposal_no));
                // $this->db->query("UPDATE t_reclassification SET adc_report='$dc_report',status = 'D' WHERE case_no = '$case_no' and proposal_no = '$proposal_no'");
                $penUser='DC';
                $rmrk='Forward to DC';
                $this->DashboardData($case_no,$penUser,$rmrk);
                if($application_no)
                {
                    //START ESCALATION FOR CO PROCESS===========
                    $dist_code=$this->session->userdata('dist_code');
                    $subdiv_code=$this->session->userdata('subdiv_code');
                    $cir_code= $this->session->userdata('cir_code');
                    $user_code = $this->session->userdata('user_code');
                    $sql="Select adc_report,es_flag,out_of_esc from t_reclassification WHERE case_no =? and proposal_no =?";
                    $es_flag_data=$this->db->query($sql, array($case_no, $proposal_no))->row();
                    if($es_flag_data->es_flag == 1 && ESCALATION_ENABLE == 1 && $es_flag_data->out_of_esc == 0){
                        $executionDate = $this->input->post('executionDate');
                        $escalationUpdateStatus = $this->Escalationmodel->escalationADCProcessRECLASS($executionDate,$dist_code,$subdiv_code,$cir_code,$case_no,$user_code);

                        log_message("error", "#ESC2925, transaction-error-STATUS======".json_encode($escalationUpdateStatus));

                        if($escalationUpdateStatus['responseType'] == 0){
                            $this->db->trans_rollback();
                            log_message("error", "#ESC2925, transaction-error in method 'LandReclassification/FinalProcess' with case-no :". $case_no);
                            $this->session->set_flashdata('message', "Something went wrong.RECLASS- Error Code(#ESC2925)");
                            redirect(base_url() . "index.php/home");
                        }
                    }
                        
                    $rtps=$this->rtpsmodel->checkRtpsService($application_no);
                    if($rtps=='RTPS'){
                        $apilink=RTPS_API_LINK;
                    }else{
                        $apilink=API_LINK;
                    }
                    $curl_handle = curl_init();
                    curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
                    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 10); // setting 10 seconds 
                    curl_setopt($curl_handle, CURLOPT_TIMEOUT, 30); // setting 30 seconds
                    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                    'application' => $application_no,
                    'dharitree' => $case_no,
                    'rmk' => 'forwared to DC',
                    'status' => 'M',
                    'task' => 'ADC',
                    'pen'=>'DC',
                    'penat'=>'DC office'
                    )));
                    $result = curl_exec($curl_handle);
                    if($result==true){

                        



                        $this->db->trans_commit();
                    }else{
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message',"Error in API CALL ");
                        return redirect($_SERVER['HTTP_REFERER']);
                        // redirect('/home');
                    }
                }
                $this->db->trans_commit();
                $this->session->set_flashdata('message',"ADC's Report on Reclassification Case no with case no $case_no ");
            }
            redirect('/home');
        }
        
        public function reject(){
            $application_no=$this->input->post('application_no');
            $date_entry = date('Y-m-d');
            if($application_no)
                    {
                        $case_no=$this->input->post('case_no');
                        $proposal_no=$this->input->post('proposal_no');
                        $order=$this->input->post('order');
                        $this->db->query("UPDATE t_reclassification SET adc_report='$order',status = 'R', status_date = '$date_entry' WHERE case_no = '$case_no' and  proposal_no = '$proposal_no'");
                        $this->DashboardDataReject($case_no);
                        $this->basundharamodel->RejectOrder();
                    }
            else{
                $case_no = $this->input->GET('case_id');
                $proposal_no = $this->input->GET('proposal_no');
                $this->db->query("UPDATE t_reclassification SET status = 'R', status_date = '$date_entry' WHERE case_no = '$case_no' and  proposal_no = '$proposal_no'");
                $this->DashboardDataReject($case_no);
                }
            $this->session->set_flashdata('message',"# $case_no has been rejected.");
            redirect(base_url() . "index.php/home");
        }

        public function SaveLandReclassification() {
            $user_dist_code = $this->session->userdata('dist_code');
            $user_desig_code = $this->session->userdata('user_desig_code');

            $co_chitha_updated_date = date('Y-m-d G:i:s');
            $user_code = $this->session->userdata('user_code');
            $case_no = $this->input->GET('case_no');
            $this->AgriStackCaseHistory->CreateLogFile($user_dist_code, $case_no);
            $proposal_no = $this->input->GET('proposal_no');

            //echo $user_code;
            $error_data_messages_arr = [];

            $caseNoValidate = caseNumberValidation($case_no);
            if(count($caseNoValidate)){
                array_push($error_data_messages_arr, $caseNoValidate['message']);
            }
            
            $response = isValidQuery($case_no);
            if($response['status'] == 'n'){
                array_push($error_data_messages_arr, 'Case number has MALECIOUS QUERY');
            }
            
            $proposal_noValidate = proposalNumberValidation($proposal_no);
            if(count($proposal_noValidate)){
                array_push($error_data_messages_arr, $proposal_noValidate['message']);
            }
            
            $response = isValidQuery($case_no);
            if($response['status'] == 'n'){
                array_push($error_data_messages_arr, 'Case number has MALECIOUS QUERY');
            }
            
            
            if(count($error_data_messages_arr)){
                $error_messages = convertArrayToHtmlUlLi($error_data_messages_arr);
                show_error($error_messages, 401);
                return;
            }
            
            if($user_desig_code != 'DC'){
                show_error('You are not authorize to perform this action.', 401);
                return;
            }

            $q = "select * from t_reclassification where case_no =? and proposal_no =?";
            $ord = $this->db->query($q, array($case_no, $proposal_no))->row();
            if(!$ord){
                log_message('error', '#ERRDCSVLNDRCLS100001: Record not found. QUERY: ' . $this->db->last_query());
                show_error('#ERRDCSVLNDRCLS100001: Data not found', 401);
                return;
            }

            $this->db->trans_begin();
            $q1 = "select * from t_reclassification where dist_code =? and subdiv_code =? and cir_code =?"
                     . "and mouza_pargona_code =? and vill_townprt_code =? "
                     . "and lot_no =? and dag_no =? and dc_yn =? ";
            $t_result = $this->db->query($q1, array($ord->dist_code, $ord->subdiv_code, $ord->cir_code, $ord->mouza_pargona_code, $ord->vill_townprt_code, $ord->lot_no, $ord->dag_no, 'Y'))->result();
            $data['Pcases'] = $ord;
            $check = "Select * from chitha_rmk_reclassification where dist_code =? and subdiv_code =? and cir_code =?"
                     . "and mouza_pargona_code =? and vill_townprt_code =? "
                     . "and lot_no =? and dag_no =? ";
            $check_presence = $this->db->query($check, array($ord->dist_code, $ord->subdiv_code, $ord->cir_code, $ord->mouza_pargona_code, $ord->vill_townprt_code, $ord->lot_no, $ord->dag_no))->result();
            $counted = count($check_presence);
            $lineNo = "select max(rmk_line_no)+1 as max from jama_remark where dist_code=? and"
                    . " subdiv_code=? and cir_code=? and mouza_pargona_code=? and "
                    . "  lot_no=? and vill_townprt_code=? and patta_type_code=? and "
                    . " TRIM(patta_no)=trim('$ord->patta_no')";

            $line_no = $this->db->query($lineNo, array($ord->dist_code, $ord->subdiv_code, $ord->cir_code, $ord->mouza_pargona_code, $ord->lot_no, $ord->vill_townprt_code, $ord->patta_type_code))->row()->max;
            if ($line_no == null) {
                $line_no = 1;
            }
            $remark31="";
            ///////////////////
            $rmk_type_hist_no=null;
            $q = "SELECT count(*) as c FROM chitha_rmk_gen where dist_code =? and subdiv_code =? and cir_code =?"
                 . "and mouza_pargona_code =? and vill_townprt_code =? "
                 . "and lot_no =? and dag_no =?";               
            $rmk_type_hist_no = $this->db->query($q, array($ord->dist_code, $ord->subdiv_code, $ord->cir_code, $ord->mouza_pargona_code, $ord->vill_townprt_code, $ord->lot_no, $ord->dag_no))->row()->c;
            if($rmk_type_hist_no==null)
                $rmk_type_hist_no=1;
            else
                $rmk_type_hist_no=$rmk_type_hist_no+1;
            ///////////////////
            if ($check_presence == null) {
                $rmk_gen = array(
                    'dist_code'=>$ord->dist_code,
                    'subdiv_code'=>$ord->subdiv_code,
                    'cir_code'=>$ord->cir_code,
                    'mouza_pargona_code'=>$ord->mouza_pargona_code,
                    'vill_townprt_code'=>$ord->vill_townprt_code,
                    'lot_no'=>$ord->lot_no,
                    'dag_no'=>$ord->dag_no,
                    'rmk_type_code'=>'08',
                    'rmk_type_hist_no'=>$rmk_type_hist_no,
                    'user_code'=>$user_code,
                    'operation'=>'E',
                    'date_entry'=>date('Y-m-d G:i:s'),
                    'jama_updated'=>null,
                    'patta_no'=>trim($ord->patta_no)
                );
                //var_dump($rmk_gen);
                $tstatus1=$this->db->insert('chitha_rmk_gen',$rmk_gen); //*********************
                if ($tstatus1 != 1 )
                {
                   $this->db->trans_rollback();
                   log_message('error',$this->db->last_query());
                   $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#RECLASS001)");
                   redirect(base_url() . "index.php/home");
                }
            }   
            $remark31 .= "<u class='text-danger'>হুকুম নং : ".$rmk_type_hist_no." </u><br>";
            $remark31 .=  $case_no;
           // $remark31 .= " শ্রেণী সংশোধনীকৰণ প্রস্তাব  " . $user_code. " মহোদয়ে  " . date('Y-m-d G:i:s');
            $remark31 .= " শ্রেণী সংশোধনীকৰণ প্রস্তাব  উপায়ুক্ত মহোদয়ে  " . date('Y-m-d G:i:s');
            $remark31 .= "  তাৰিখে দিয়া অনুমোদন মৰ্মে  " . $ord->patta_no;
            $remark31 .= "  নং পট্টাৰ  " . $ord->dag_no . "  নং দাগৰ শ্রেণী  " . $this->utilityclass->getLandClassCode($ord->present_land_class) . "'ৰ  পৰা  " . $this->utilityclass->getLandClassCode($ord->proposed_land_class);
            $remark31 .= "  লৈ পৰিবৰ্তন কৰা হ'ল । ";
            $remarkData = array(
                    'dist_code' => $ord->dist_code,
                    'subdiv_code' => $ord->subdiv_code,
                    'cir_code' => $ord->cir_code,
                    'mouza_pargona_code' => $ord->mouza_pargona_code,
                    'lot_no' => $ord->lot_no,
                    'vill_townprt_code' => $ord->vill_townprt_code,
                    'patta_no' => $ord->patta_no,
                    'patta_type_code' => $ord->patta_type_code,
                    'rmk_line_no' => $line_no++,
                    'remark' => $remark31,
                    'user_code' => $user_code,
                    'entry_date' => date('Y-m-d'),
                    'entry_mode' => 'U'
            );
            $tstatus2=$this->db->insert('jama_remark', $remarkData); //.......................
            if ($tstatus2 != 1 )
            {
               $this->db->trans_rollback();
               log_message('error',$this->db->last_query());
               $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#RECLASS002)");
               redirect(base_url() . "index.php/home");
            }
            $q3 = "SELECT * FROM chitha_rmk_reclassification where dist_code =? and subdiv_code =? and cir_code =?"
                 . "and mouza_pargona_code =? and vill_townprt_code =? "
                 . "and lot_no =? and dag_no =? and proposal_no=?";        
            $rmkexist = $this->db->query($q3, array($ord->dist_code, $ord->subdiv_code, $ord->cir_code, $ord->mouza_pargona_code, $ord->vill_townprt_code, $ord->lot_no, $ord->dag_no, $proposal_no))->num_rows(); 
            //echo $this->db->last_query();
            //$rmkexisted =   count($rmkexist);
            if ($rmkexist==0) {
                $chitha_rmk_reclassification = array(
                    'dist_code' => $ord->dist_code,
                    'subdiv_code' => $ord->subdiv_code,
                    'cir_code' => $ord->cir_code,
                    'mouza_pargona_code' => $ord->mouza_pargona_code,
                    'lot_no' => $ord->lot_no,
                    'vill_townprt_code' => $ord->vill_townprt_code,
                    'proposal_no' => $proposal_no,
                    'dag_no' => $ord->dag_no,
                    'patta_no' => trim($ord->patta_no),
                    'patta_type_code' => $ord->patta_type_code,
                    'present_land_class' => $ord->present_land_class,
                    'present_land_revenue' => $ord->present_land_revenue,
                    'present_land_localtax' => $ord->present_land_localtax,
                    'present_total_revenue' => $ord->present_total_revenue,
                    'new_landuse_year' => $ord->new_landuse_year,
                    'dag_area_b' => $ord->dag_area_b,
                    'dag_area_k' => $ord->dag_area_k,
                    'dag_area_lc' => $ord->dag_area_lc,
                    'dag_area_g' => $ord->dag_area_g,
                    'dag_area_kr' => $ord->dag_area_kr,
                    'proposed_land_class' => $ord->proposed_land_class,
                    'proposed_land_revenue' => $ord->proposed_land_revenue,
                    'proposed_land_localtax' => $ord->proposed_land_localtax,
                    'revenue_diff' => $ord->revenue_diff,
                    'lm_code' => $ord->lm_code,
                    'lm_yn' => $ord->lm_yn,
                    'lm_date' => $ord->lm_date,
                    'case_no' => $case_no,
                    'co_recommendation' => $ord->co_recommendation,
                    'co_recom_date' => $ord->co_recom_date,
                    'co_yn' => $ord->co_yn,
                    'co_date' => $ord->co_date,
                    'dc_approval'  => $ord->dc_approval,
                    'dc_approval_date' => $ord->dc_approval_date,
                    'dc_yn' => $ord->dc_yn,
                    'dc_date' => $ord->dc_date,
                    'rkg_chitha_updated_yn' => 'Y',
                    'rkg_chitha_updated_date'  => $co_chitha_updated_date,
                    //'rkg_transmit_yn' => '',
                    'co_chitha_updated_yn' => 'Y',
                    'co_chitha_updated_date'  => $co_chitha_updated_date,
                    //'make_mdb' => ord->,
                    'self_declaration' => $ord->self_declaration,
                    'id_ref_no' => $ord->id_ref_no,
                    'auth_type' => $ord->auth_type,
                    'photo' => $ord->photo

                );
                //var_dump($chitha_rmk_reclassification);
              $tstatus3=$this->db->insert('chitha_rmk_reclassification', $chitha_rmk_reclassification);  
              if ($tstatus3 != 1 )
                {
                   $this->db->trans_rollback();
                   log_message('error',$this->db->last_query());
                   $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#RECLASS002)");
                   redirect(base_url() . "index.php/home");
                }
            }
            $jama_dag = "update jama_dag set dag_class_code='$ord->proposed_land_class' where dist_code='$ord->dist_code' and"
                    . " subdiv_code='$ord->subdiv_code' and cir_code='$ord->cir_code'"
                    . " and lot_no='$ord->lot_no' and mouza_pargona_code='$ord->mouza_pargona_code' and "
                    . " vill_townprt_code='$ord->vill_townprt_code' and dag_no='$ord->dag_no'  "
                    . " and TRIM(patta_no)=trim('$ord->patta_no') and patta_type_code='$ord->patta_type_code'";
            $tstatus4=$this->db->query($jama_dag);
            if ($tstatus4 != 1 )
            {
               $this->db->trans_rollback();
               log_message('error',$this->db->last_query());
               $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#RECLASS004)");
               redirect(base_url() . "index.php/home");
            }       
            // $chitha_update = "update chitha_basic set land_class_code='$ord->proposed_land_class',dag_revenue='$ord->proposed_land_revenue',"
            //         . " dag_local_tax='$ord->proposed_land_localtax',jama_yn=' ' where dist_code='$ord->dist_code' and"
            //         . " subdiv_code='$ord->subdiv_code' and cir_code='$ord->cir_code'"
            //         . " and lot_no='$ord->lot_no' and mouza_pargona_code='$ord->mouza_pargona_code' and "
            //         . " vill_townprt_code='$ord->vill_townprt_code' and dag_no='$ord->dag_no'  "
            //         . " and TRIM(patta_no)=trim('$ord->patta_no') and patta_type_code='$ord->patta_type_code'";
            // $tstatus5=$this->db->query($chitha_update);  //*********************
            $table = 'chitha_basic';

            $params = [
                'land_class_code' => $ord->proposed_land_class,
                'dag_revenue'     => $ord->proposed_land_revenue,
                'dag_local_tax'   => $ord->proposed_land_localtax,
                'jama_yn'         => ' ',
            ];

            $where = [
                'dist_code'          => $ord->dist_code,
                'subdiv_code'        => $ord->subdiv_code,
                'cir_code'           => $ord->cir_code,
                'lot_no'             => $ord->lot_no,
                'mouza_pargona_code' => $ord->mouza_pargona_code,
                'vill_townprt_code'  => $ord->vill_townprt_code,
                'dag_no'             => $ord->dag_no,
                'patta_no'           => trim($ord->patta_no),  // Equivalent to SQL TRIM()
                'patta_type_code'    => $ord->patta_type_code,
            ];

            // Execute the update
            $tstatus5 = $this->Chitha_basic_model->update_table($table, $params, $where);

            if ($tstatus5 != 1 )
            {
               $this->db->trans_rollback();
               log_message('error','#RECLASS005: ' . $this->db->last_query());
               $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#RECLASS005)");
               redirect(base_url() . "index.php/home");
            }
            //chitha pattadar aadhar updation --------------
            $auth_type = $ord->auth_type;
            $ref_no = $ord->id_ref_no;
            $photo = $ord->photo;
            log_message('error',$auth_type);
            log_message('error',$ord->patta_no);
            log_message('error',$ord->patta_type_code);
            log_message('error',$ref_no);
            log_message('error',$photo);
            log_message('error',$ord->pdar_id);
            $pdar_id_aadhar = $ord->pdar_id;
            if(isset($auth_type)){
               if($auth_type == 'AADHAAR'){
                  $aadharNo = $ref_no;
                  $panNo    = null;
                  $photo    = null;
                }else if($auth_type == 'PAN'){
                  $aadharNo = null;
                  $panNo    = $ref_no;
                  $photo    = null;
                }else{
                  $aadharNo = null;
                  $panNo    = null;
                  $photo    = null;
                }
                if($pdar_id_aadhar != null){
                    if($aadharNo != null || $panNo != null || $pdar_id_aadhar !=null){
                        // $chitha_update_aadhar = "update chitha_pattadar set pdar_aadharno='$aadharNo',pdar_pan_no='$panNo',pdar_photo = '$photo' where dist_code='$ord->dist_code' and"
                        //         . " subdiv_code='$ord->subdiv_code' and cir_code='$ord->cir_code'"
                        //         . " and lot_no='$ord->lot_no' and mouza_pargona_code='$ord->mouza_pargona_code' and "
                        //         . " vill_townprt_code='$ord->vill_townprt_code' and pdar_id = '$pdar_id_aadhar'"
                        //         . " and TRIM(patta_no)=trim('$ord->patta_no') and patta_type_code='$ord->patta_type_code'";
                        // $tstatus_aadhar=$this->db->query($chitha_update_aadhar);  //*********************

                        $table = 'chitha_pattadar';

                        $params = [
                            'pdar_aadharno' => $aadharNo,
                            'pdar_pan_no'   => $panNo,
                            'pdar_photo'    => $photo,
                            'f1_case_no'      => $case_no
                        ];

                        $where = [
                            'dist_code'          => $ord->dist_code,
                            'subdiv_code'        => $ord->subdiv_code,
                            'cir_code'           => $ord->cir_code,
                            'lot_no'             => $ord->lot_no,
                            'mouza_pargona_code' => $ord->mouza_pargona_code,
                            'vill_townprt_code'  => $ord->vill_townprt_code,
                            'pdar_id'            => $pdar_id_aadhar,
                            'patta_no'           => trim($ord->patta_no), // equivalent to TRIM in SQL
                            'patta_type_code'    => $ord->patta_type_code,
                        ];

                        // Perform update using model
                        $tstatus_aadhar = $this->Chitha_basic_model->update_table($table, $params, $where);

                        if ($tstatus_aadhar != 1)
                        {
                           $this->db->trans_rollback();
                           log_message('error',$this->db->last_query());
                           $this->session->set_flashdata('message', "Error in Processing Aadhar Information. Please try Again. Error Code(#RECLASS00012)");
                           redirect(base_url() . "index.php/home");
                        }
                    }
                }
               
            }
            $this->db->query("UPDATE t_reclassification SET co_chitha_updated_yn = 'Y', co_chitha_updated_date = '$co_chitha_updated_date',"
                    . "rkg_chitha_updated_yn = 'Y', rkg_chitha_updated_date = '$co_chitha_updated_date',status='F' WHERE case_no = '$case_no' and  proposal_no = '$proposal_no'");
            if ($this->db->affected_rows()!= 1 )
            {
               $this->db->trans_rollback();
               log_message('error',$this->db->last_query());
               $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#RECLASS006)");
               redirect(base_url() . "index.php/home");
            }
            ////////
            $this->DashboardDataFinal($case_no);
            //////
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo "Error Occured";
            } else {
                //autoupdate jamabandi ends here



                //////////////////////////////////////////////////////////////////////////// Property chain code //////////////////////////////////////////////////////////////////

                $save_chain_data=true; 
                if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                {

                $this->load->model('propChain/PropChainModel');  
                $ulpinFlag = $this->input->get('ulpinCheckFlag');
                $compareFlag = $this->input->get('compareCheckFlag');


                if($compareFlag == 'Y' && $ulpinFlag ==1)
                {

                $ulpin = $this->input->get('ulpin');

                $old_ulpin = $this->input->get('ulpin');;

                $location_id = $ord->dist_code . $ord->subdiv_code . $ord->cir_code . $ord->mouza_pargona_code . $ord->lot_no . $ord->vill_townprt_code;


                $certmnemonic = CERTMNEMONIC_RECLASS;

                $chain_dag = $ord->dag_no;
                $chain_patta = $ord->patta_no;

                $property_id = $this->blockchainutilityclass->generatePropertyId(LOC_TYPE_RURAL, $ord->vill_townprt_code, $chain_patta, $chain_dag, $ulpin);

                 // var_dump($ord);exit;

                $bigha_chain = $ord->dag_area_b;
                $katha_chain = $ord->dag_area_k;
                $lessa_chain = $ord->dag_area_lc;
                $ganda_chain = $ord->dag_area_g;

                $old_land_class = $ord->present_land_class;
                $old_revenue = $ord->present_land_revenue;
                $old_local_tax = $ord->present_land_localtax;

                $new_land_class = $ord->proposed_land_class;
                $new_revenue = $ord->proposed_land_revenue;
                $new_local_tax = $ord->proposed_land_localtax;

                $patta_type_code = $ord->patta_type_code;

                $property_signature = "base64 encoded signature";
                $property_signer_key = "base64 encoded public key";

                // take district code as office code for dc
                $office_code = $this->session->userdata('dist_code');

                // required for partition cases here send empty string
                $new_patta_no = $new_dag_no = $new_bigha = $new_katha = $new_lessa = $new_ganda = '';

                $pattadar_details = $this->PropChainModel->getPattadars($ord->dist_code, $ord->subdiv_code, $ord->cir_code, $ord->mouza_pargona_code, $ord->lot_no, $ord->vill_townprt_code, $ord->patta_no, $ord->dag_no);
                $update_params = array(
                    'pattadar_details' => $pattadar_details,
                    'location_id' => $location_id,
                    'property_id' => $property_id,
                    'reference_id' => $case_no,
                    'dag_no' => $chain_dag,
                    'patta_no' => $chain_patta,
                    'patta_type_code' => $patta_type_code,
                    'land_class_code' => $new_land_class,
                    'bigha_chain' => $bigha_chain,
                    'katha_chain' => $katha_chain,
                    'lessa_chain' => $lessa_chain,
                    'ganda_chain' => $ganda_chain,
                    'certmnemonic' => $certmnemonic,
                    'property_signature' => $property_signature,
                    'property_signer_key' => $property_signer_key,
                    'office_code' => $office_code,
                    'user_code' => $user_code,
                    'ulpin' => $ulpin,
                    'old_ulpin' => $old_ulpin,
                    'revenue' => $new_revenue,
                    'local_tax' => $new_local_tax,
                    'new_patta_no' => $new_patta_no,
                    'new_dag_no' => $new_dag_no,
                    'old_revenue' => $old_revenue,
                    'old_local_tax' => $old_local_tax,
                    'old_land_class_code' => $old_land_class,
                    'new_bigha' => $new_bigha,
                    'new_katha' => $new_katha,
                    'new_lessa' => $new_lessa,
                    'new_ganda' => $new_ganda
                );

                $chain_update_data = $this->blockchainutilityclass->getUpdateChainArrayN((object)$update_params);


                $save_chain_data = $this->PropChainModel->save_chain_data(json_encode($chain_update_data), $case_no);

                }
            }


                if ($save_chain_data) {

                    //     $data['msg'] = '<table class="rasid table">
                    //     <tr>
                    //         <td style="text-align: center;">Land Reclassification Process Completed and Chitha has been Updated.</td>

                    //     </tr>
                    //     <tr>
                    //         <td style="text-align: center;">Property chain successfully updated.</td>

                    //     </tr>
                    //     <tr>
                    //         <td style="text-align: center; font-size: 30px;">নতুন (প্রস্তাবিত) মাটিৰ শ্রেণী পঞ্জীকৰণ প্রক্রিয়া সম্পূর্ণ ' . "হ'ল" . ' আৰু চিঠাবহী সংশোধন কৰা' . " হ'ল" . ' ।</td>
                    //     </tr>
                    //  </table>';

                    $this->db->trans_commit();
                    $this->AgriStackCaseHistory->CreateLog($user_dist_code,$case_no);

                    $basundhara=$this->db->query("SELECT basundhara FROM basundhar_application 
                            WHERE dharitree=?", array($case_no))->row()->basundhara;

                    if($basundhara)
                    {
                        $rtps=$this->rtpsmodel->checkRtpsService($basundhara);
                        if($rtps=='RTPS'){
                            $apilink=RTPS_API_LINK;
                        }else{
                            $apilink=API_LINK;
                        }
                        $curl_handle = curl_init();
                        curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
                        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                            'application' => $basundhara,
                            'dharitree' => $case_no,
                            'rmk' => 'Final order by DC',
                            'status' => 'F',
                            'task' => 'DC',
                            'pen'=>'Approved',
                            'penat'=>'Dc office'
                        )));
                        $result = curl_exec($curl_handle);
                        if($result==false){
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message',"Error in API CALL ");
                            redirect('/home');
                        }
                    }



                    
                    if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                    {

                        if($ulpinFlag == 1 && $compareFlag == 'Y')
                        {
                        redirect(base_url() . 'index.php/PropChainReport/sendPropChain/' . urlencode(base64_encode($case_no)));
                        }
                    }
                }

                else{
                    echo "ERRRCPROPCHAIN:Interrnal server error!!";
                    exit;
                }

                $params = [
                  'case_no'          => $case_no,
                  'service_code'     => 4,
                  'remarks'          => 'Reclassification',
                  'accessed_entity'  => 'Aadhaar Status',
                ];
                $this->load->model('EkycLogModel');
                $log = $this->EkycLogModel->insertEkycAccessedBy($this->db, $params);

              //  $this->db->trans_commit();
                $data['_view'] = 'LandReclassification/test';
                $this->load->view('layouts/main',$data);
            }
        }        
        public function dcWaitLandReclassification() {
            $case_no = $this->input->GET('case_no');
            $proposal_no = $this->input->GET('proposal_no');            
            $this->db->query("UPDATE t_reclassification SET dc_approval = null, dc_approval_date = null, dc_yn = null, dc_date = null WHERE case_no = '$case_no' and proposal_no = '$proposal_no'");
            $this->session->set_flashdata('message',"Chitha Not Updated. # $case_no is not yet Processed.");
            redirect(base_url() . "index.php/home");
        }
        function maxProceedingID($case_no){
            $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from petition_proceeding_dc_adc where case_no='$case_no' ")->row()->c;
            if($proceeding_id==null){
                $proceeding_id=1;
            }
            return $proceeding_id;
        }
        function proceedingDetails(){
            $case_no=$this->input->get('case_id');
            $q="Select * from petition_proceeding_dc_adc where case_no='$case_no' ";
            $data['pb']=$this->db->query($q)->result();
            
            //$this->load->view('../views/header');
            $this->load->view('../views/LandReclassification/view_proceeding', $data);
            //$this->load->view('../views/footer');
        }

        function Dashboard($case_no)
        {
            $this->dbb = $this->load->database('dash', TRUE);

            $sql="select * from t_reclassification where case_no='$case_no' ";
            
            $type='RC';
            $data=$this->db->query($sql)->row_array();
            $base= array(
                        'dist_code'=> $data['dist_code'],
                          'subdiv_code' =>$data['subdiv_code'],
                          'cir_code'=>$data['cir_code'],
                          'mouza_pargona_code'=>$data['mouza_pargona_code'],
                          'lot_no'=>$data['lot_no'],
                          'vill_townprt_code'=>$data['vill_townprt_code'],
                          'case_no'=>$data['case_no'],
                          'date_of_reg'=>$data['lm_date'],
                          'dag_no'=>$data['dag_no'],
                          'patta_type_code' =>$data['patta_type_code'],
                          'patta_no' =>$data['patta_no'],
                          'status' =>'P',
                          'pending_with_user' =>'CO',
                          'case_type' =>$type,
                      );
                

                unset($base['dag_no']);
                unset($base['patta_type_code']);
                unset($base['patta_no']);

            $this->dbb->insert('dashboard_data',$base);
            $this->db->insert('dashboard_data',$base);


            $action= array(
                'case_no' => $case_no,
                'user_code' => $this->session->userdata('user_code'),
                'date_of_action_taken' => date("Y-m-d h:i:s"),
                'user_designation' => $this->session->userdata('user_desig_code'),
                'remark' => 'Registered By LM',
                'ip_address'=>$this->utilityclass->get_client_ip()
                 );
             $this->dbb->insert('dashboard_action',$action);
             $this->db->insert('dashboard_action',$action);

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
                            'date_of_action_taken' => date("Y-m-d h:i:s"),
                            'user_designation' => $this->session->userdata('user_desig_code'),
                            'remark' => $rmrk,
                            'ip_address'=>$this->utilityclass->get_client_ip()
                             );
                        $this->dbb->insert('dashboard_action',$action);
                        $this->db->insert('dashboard_action',$action);

                        $this->db->where('case_no',$case_no);
                        $this->db->update('dashboard_data',$base);
                    /////////////////////////////////////
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
                                'date_of_action_taken' => date("Y-m-d h:i:s"),
                                'user_designation' => $this->session->userdata('user_desig_code'),
                                'remark' => 'Final Order Passed',
                                'ip_address'=>$this->utilityclass->get_client_ip()
                                 );
                            $this->dbb->insert('dashboard_action',$action);
                            $this->db->insert('dashboard_action',$action);
                             
                            $this->db->where('case_no',$case_no);
                            $this->db->update('dashboard_data',$base);
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

        public function getPendingReclassCases() {
            $this->dbswitch();

            $allowed = ['LM'];
            $user_desig_code = $this->session->userdata('user_desig_code');

            // Restrict access if not in allowed list
            if ( ! in_array($user_desig_code, $allowed)) {
                echo json_encode(['error' => 'Unauthorized access']);
                exit; // or die();
            }

            $append=$this->base_query;
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $villageListNew = array();
            $villageList = $this->mutationmodel->getAllDistinctVillageListLotWiseReclass($append,$mouza_pargona_code,$lot_no);
                foreach ($villageList as $key => $value) {
                    $villageListNew[$key]['village_code'] = $value->mouza_pargona_code."-".$value->lot_no."-".$value->vill_townprt_code;
                    $villageListNew[$key]['vill_name'] = $this->utilityclass->getVillageName($value->dist_code,$value->subdiv_code,$value->cir_code,$value->mouza_pargona_code,$value->lot_no,$value->vill_townprt_code);
                 }
            $uniqueVillage = array_map("unserialize", array_unique(array_map("serialize", $villageListNew)));
            $data['villageListNew'] =  $uniqueVillage;

            $newMouzaList = array();
                foreach ($villageList as $key => $value) {
                    $newMouzaList[$key]['mouza_code'] = $value->mouza_pargona_code;
                    $newMouzaList[$key]['mouza_name'] = $this->utilityclass->getMouzaName($value->dist_code,$value->subdiv_code,$value->cir_code,$value->mouza_pargona_code);
                    $newMouzaList[$key]['lot_name'] = $this->utilityclass->getLotName($value->dist_code,$value->subdiv_code,$value->cir_code,$value->mouza_pargona_code,$value->lot_no);
                    $newMouzaList[$key]['lot_no'] = $value->lot_no;
            }
           
            $uniqueMouzaList = array_map("unserialize", array_unique(array_map("serialize", $newMouzaList)));
            $data['newMouzaList'] = $uniqueMouzaList;

            $data['_view'] = 'LandReclassification/reclassCases';
            $this->load->view('layouts/main',$data);
        }

        //created for getting all the pending list at LM login circle wise---------
        public function getPendingReclassLMend(){
            $dist_code =$this->session->userdata('dist_code');
            $subdiv_code =$this->session->userdata('subdiv_code');
            $cir_code =$this->session->userdata('cir_code');
            $draw = intval($this->input->post('draw'));
            $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
            $start = intval($this->input->post('start'));
            $length = intval($this->input->post('length'));
            $order = $this->input->post('order');
            $mouza_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_mouza_code = $this->input->post('vill_mouza_code');
            $vill_lot_no = $this->input->post('vill_lot_no');
            $village_code = $this->input->post('village_code');
            $zone_status = $this->input->post('zone_status');
            // $define_date = define_date;

            if(($zone_status != null || $zone_status != '') && ESCALATION_ENABLE == 1){
                $results = $this->Escalationmodel->getPendingReclassCaseLMend($dist_code,$subdiv_code,$cir_code,$start,$length,$order,$mouza_code,$lot_no,$vill_mouza_code,$vill_lot_no,$village_code,$searchByCol_0, $zone_status);    
            }
            else {
                $results = $this->mutationmodel->getPendingReclassCaseLMend($dist_code,$subdiv_code,$cir_code,$start,$length,$order,$mouza_code,$lot_no,$vill_mouza_code,$vill_lot_no,$village_code,$searchByCol_0);
            }
            

            
            if(isset($results)){
                $data_rows = $results['data_results'];
                $total_records = $results['total_records'];

                // echo "<pre>";
                // var_dump($data_rows); die;
                // var_dump($total_records); die;

                if($total_records > 0) {
                    foreach($data_rows as $rows){
                        // log_message("error","UTPAL2026: ==========".json_encode($rows));
                        if($rows->es_flag == '1' && $rows->out_of_esc == 0){
                            $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);
                            // log_message('error', '#2030: Escalation details : '.json_encode($escRow));
                            if(!empty($escRow) && $escRow != null){
                                $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->lm_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry));
                                // log_message('error', '#2034: Escalation details : '.json_encode($escData));
                                if(!empty($escData) && $escData != null){
                                    $rows->escalation_date = $escData->escalation_date;
                                    $rows->escalation_zone = $escData->escalation_zone;
                                    $rows->assigned_date   = $escData->assigned_date;
                                }
                                else {
                                    $rows->escalation_date = 'NA';
                                    $rows->escalation_zone = 'NA';
                                }
                            }
                            else {
                                $rows->escalation_date = 'NA';
                                $rows->escalation_zone = 'NA';
                            }
                        }
                        else {
                            $rows->escalation_date = 'NA';
                            $rows->escalation_zone = 'NA';
                        }
                        $link = base_url() . "index.php/LandReclassification/write_report_lm?case_no=" . $rows->case_no . "&dist_code=" . $rows->dist_code . "&subdiv_code=" . $rows->subdiv_code . "&cir_code=" . $rows->cir_code . "&mouza_pargona_code=" . $rows->mouza_pargona_code . "&lot_no=" . $rows->lot_no . "&vill_townprt_code=" . $rows->vill_townprt_code;
                        

                        if(ESCALATION_ENABLE == 1 && $rows->is_escalated == 1)
                        {
                            $button = 'Escalated to Appellate Authority';
                        }
                        else
                        {
                            $button = "<a href=".$link." class='btn btn-success'>".$this->lang->line("write_report")."</a>";
                        }
                        $mouza_lot = $this->utilityclass->getMouzaName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code)."-".$this->utilityclass->getLotName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code,$rows->lot_no);
                        $e = $rows->basundhara;
                        $json[] = array(
                            $rows->escalation_zone,
                            $rows->escalation_date,
                            $rows->case_no."<br><span class='small font-italic red'>".$e."</span>",
                            $mouza_lot,
                            $this->utilityclass->getVillageName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code,$rows->lot_no,$rows->vill_townprt_code),
                            date('M jS, Y',strtotime($rows->date_entry)),
                            $button
                        );
                    }    
                }
                else {
                    $json = "";
                } 
                
                $response = array(
                    'draw'              => $draw,
                    'recordsTotal'      => $total_records,
                    'recordsFiltered'   => $total_records,
                    'data'              => $json
                );
                echo json_encode($response);
            }else{
                $response = array();
                $response['sEcho']=0;
                $response['iTotalRecords']=0;
                $response['iTotalDisplayRecords']=0;
                $response['aaData']=[];
                echo json_encode($response);
            }
        }

        public function write_report_lm(){
            $case_no = $this->input->get('case_no');
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code1 = $this->input->get('mouza_pargona_code');
            $lot_no1 = $this->input->get('lot_no');
            $vill_townprt_code1 = $this->input->get('vill_townprt_code');
            $data['case_no'] = $case_no;
            $sql="Select * from t_reclassification where case_no = '$case_no'";
            $reclass=$this->db->query($sql)->row();
            $data['app'] = $reclass;
            $data['applicant_info'] = json_decode($reclass->applicant_info);

            $data['selfDecData'] = json_decode($reclass->self_declaration);
            $data['basuCase']=null;
            // $data['app']=$rtps=null;
            $data['basuCase']=$basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
            $data['application_no'] = $basundharaExist;


            if($reclass->auth_type !=null){
                $statusAadhar = "<i class='fa fa-check'></i> ".$reclass->auth_type. " Verified";
                $engName = $data['applicant_info'][0]->pat_name_eng;
            }else{
                $statusAadhar = 'N/A';
                $engName = null;
            }
            $data['status'] = $statusAadhar;
            $data['engName'] = $engName;



            $application_no_sql="select * from basundhar_application where dharitree='$case_no' ";
            $data['application'] = $this->db->query($application_no_sql)->row();

            $data['base64_decoded_adhar_file'] = "";
            if (!empty($reclass) && $reclass !=null && trim($reclass->auth_type) == 'AADHAAR' ):

                    $adhar_photo_link = $reclass->photo;
                    if($adhar_photo_link == null)
                    {
                        $url = RTPS_API_LINK."getApplicantPhoto";
                        $arrayData =array(
                            'application_no' => $data['application']->basundhara,
                        );
                        //*****API call again for aadhar photo missing */
                        $aadhaarPhotoReCall = $this->utilityclass->curlPost($url, $arrayData);
                        if($aadhaarPhotoReCall != 'n')
                        {
                            $aadhaarPhotoDetails = json_decode($aadhaarPhotoReCall);
                            $aadhar_path = AADHAAR_UPLOAD_DIR. $reclass->id_ref_no . '.json';

                            if($aadhar_path == null || $aadhar_path == '')
                            {
                                $this->load->model('AadhaarPhotoViewModel');
                                $get_aadhaar_photo = $this->AadhaarPhotoViewModel->aadhaarPhotoView($data['application']->basundhara);
                                if($get_aadhaar_photo != 'n'){
                                  $data['base64_decoded_adhar_file'] = "<img src = data:".$this->decodeBase64($get_aadhaar_photo).";base64,".$get_aadhaar_photo." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
                                }
                            }
                            else
                            {
                                $aadhaar_file_to_write_base64 = fopen($aadhar_path, "w") or die("Unable to open file!");
                                $aadhaar_encoded_file = $aadhaarPhotoDetails->path;
                                fwrite($aadhaar_file_to_write_base64, $aadhaar_encoded_file);
                                fclose($aadhaar_file_to_write_base64);

                                $query = "update t_reclassification set photo = '$aadhar_path' where case_no='$case_no' and id_ref_no = '$reclass->id_ref_no' and auth_type is not null";
                                $this->db->query($query);
                               
                                $adhar_photo_link = $aadhar_path;
                            }
                        }
                        else
                        {
                            echo json_encode(array('ERROR885784: API Response fail!'));
                            return false;
                        }


                    }

                    if($adhar_photo_link == null || $adhar_photo_link == '')
                    {
                        $this->load->model('AadhaarPhotoViewModel');
                        $get_aadhaar_photo = $this->AadhaarPhotoViewModel->aadhaarPhotoView($data['application']->basundhara);
                        if($get_aadhaar_photo != 'n'){
                          $data['base64_decoded_adhar_file'] = "<img src = data:".$this->decodeBase64($get_aadhaar_photo).";base64,".$get_aadhaar_photo." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
                        }
                    }
                    else
                    {
                      $open_adhar_file = fopen($adhar_photo_link, "r") or die("Unable to open file!");
                      $read_adhar_file = fread($open_adhar_file, filesize($adhar_photo_link));
                      fclose($open_adhar_file);
                      // decoding the base64 encoding file variable
                      $data['base64_decoded_adhar_file'] = "<img src = data:".$this->decodeBase64($read_adhar_file).";base64,".$read_adhar_file." class='img-thumbnail mrl' alt='Aadhaar Photo' width='170' height='200'>";
                    }

                    
                    // //**********reopening the updated file */
                    // $open_adhar_file = fopen($adhar_photo_link, "r") or die("Unable to open file!");
                    // $read_adhar_file = fread($open_adhar_file, filesize($adhar_photo_link));
                    // fclose($open_adhar_file);
                    // // decoding the base64 encoding file variable
                    // $data['base64_decoded_adhar_file'] = "<img src = data:".$this->decodeBase64($read_adhar_file).";base64,".$read_adhar_file." class='img-thumbnail mrl' alt='Aadhaar Photo' width='170' height='200'>";
          
                
            endif;





            $user_code=$this->session->userdata('user_code');

            $data['lm'] = $this->utilityclass->getDefinedMondalsName($dist_code,$subdiv_code, $cir_code,$mouza_pargona_code1,$lot_no1,$user_code);


            if($basundharaExist){
                $data['sup_doc']=$this->db->query("SELECT * FROM supportive_document WHERE case_no=?", array($case_no))->result();
                $data['query']=null;
                $data['rtps']=$rtps=$this->rtpsmodel->checkBasundharaService($case_no);
                if($rtps=='RTPS'){
                    $url = RTPS_API_LINK."serviceResponse?application_no=" . $basundharaExist ;
                    $data['basundharaAttachment']=$this->rtpsmodel->searchBasundharaLink($case_no);
                }else{
                    $url = API_LINK."serviceResponse?application_no=" . $basundharaExist ;
                    $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
                }
                //var_dump($data['basundharaAttachment']);
                $data['query']=$this->basundharamodel->QueryPost($basundharaExist);
                $data['sro']=$this->basundharamodel->SroPost($basundharaExist);
                
            }


            //ESCALATED CASES REMARK ENTRY FORM==============
            if(ESCALATION_ENABLE == 1 && ESCALATION_REMARK_ENABLE == 1 && $reclass->es_flag == 1 && $reclass->out_of_esc == 0)
            {
                $remainingTime = $this->Escalationmodel->calculateRemainingTime($case_no,$this->session->userdata('user_desig_code'));
                $data['remainingTime'] = $remainingTime;
                $escRemarkData = $this->Escalationmodel->getEscalationRemarkDetails($case_no,$this->session->userdata('user_desig_code'),$this->session->userdata('user_code'));
                if(isset($escRemarkData) && !empty($escRemarkData))
                {
                    $data['escRemarkData'] = $escRemarkData;
                }
            }
            ///END REMARKS/////////

            $params = [
              'case_no'          => $case_no,
              'service_code'     => 4,
              'remarks'          => 'Reclassification',
              'accessed_entity'  => 'Aadhaar Name, Photo',
            ];
            $this->load->model('EkycLogModel');
            $log = $this->EkycLogModel->insertEkycAccessedBy($this->db, $params);


            $data['_view'] = 'LandReclassification/write_report_lm';
            $this->load->view('layouts/main',$data);
        }

        public function decodeBase64($encoded_string){
            $file_data= base64_decode($encoded_string);
            $file = finfo_open();
            $mime_type = finfo_buffer($file, $file_data, FILEINFO_MIME_TYPE);
            $file_type = explode('/', $mime_type)[0];
            $extension = explode('/', $mime_type)[1];
            log_message("error","No error occured".json_encode($mime_type));
            return $mime_type;
        }

        


        public function reclassPost(){

            $this->db->trans_begin();  
            $case_no = $this->input->post('case_no');

            $co_report1 = $this->input->post('co_report');
            $co_report_suffix = $this->input->post('co_report_suffix');
            $co_report = $co_report1." - ".$co_report_suffix;

            $dag_revenue = $this->input->post('dag_revenue');
            $dag_local_tax = $this->input->post('dag_local_tax');
            $sum = $this->input->post('sum');
        
            $proposed_land_revenue = $this->input->post('P_land_rev');
            $proposed_land_localtax = $this->input->post('p_local_tax');
            $revenue_diff = $this->input->post('Rev_diff');

            $queryForBasundhara = "select * from basundhar_application where dharitree = ?";
            $dataDhar = $this->db->query($queryForBasundhara,array($case_no))->row();

            $reclassDataSql = "select * from t_reclassification where case_no = ?";
            $reclassData = $this->db->query($reclassDataSql,array($case_no))->row();

            $dateN = date('Y-m-d H:i:s');

            $q = "update t_reclassification set lm_code = ?, lm_yn = ? ,lm_date= ?,proposed_land_revenue=? , proposed_land_localtax=? where case_no=?";
            $this->db->query($q,array($this->session->userdata('user_code'),'Y',$dateN,$proposed_land_revenue,$proposed_land_localtax,$case_no));

            if($this->db->affected_rows() <= 0){
                $this->db->trans_rollback();
                $data=array(
                    'error'=>"#ERRORMBRECLASS00215 : Error in submitting. Please try Again"
                );
                echo json_encode($data);
                return false;
            }

            //ESCALATION ==============
            if(ESCALATION_ENABLE == 1 && $reclassData->es_flag == 1 && ESCALATION_REMARK_ENABLE ==1 && $reclassData->out_of_esc == 0)
            {

                $responseEsc = $this->Escalationmodel->escalationRemarkCheckandUpdate($case_no,$this->input->post('esc_remark'),$this->session->userdata('user_desig_code'));
                if($responseEsc['responseType'] == 1)
                {
                    $this->db->trans_rollback();
                    $data=array(
                        'error'=>"#ERRRECLASS4012 : Error in submitting in escalation remarks. Please try Again"
                    );
                    echo json_encode($data);
                    return false;
                }

            }
            ///END+==================



            $proID=$this->rtpsmodel->maxProceedingID($case_no);
            $pro_array=array(
                'dist_code' => $reclassData->dist_code,
                'subdiv_code' => $reclassData->subdiv_code,
                'cir_code' => $reclassData->cir_code,
                'case_no'=>$case_no,
                'proceeding_id'=>$proID,
                'status'=>'pending',
                'date_of_hearing'=>date('Y-m-d'),
                'co_order'=>$co_report,
                'user_code'=>$this->session->userdata('user_code'),
                'date_entry'=>date('Y-m-d G:i:s'),
                'operation'=>'E'
                );
            $insProceedRECLASS = $this->db->insert('petition_proceeding_dc_adc',$pro_array);
            if($insProceedRECLASS != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRRECLASS003: Insertion failed in petition_proceeding_dc_adc for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRRECLASS003: Registration of Reclassification failed for case no : ".$application_no,
                    'status' => false
                );
                echo json_encode($data);
                return false;
            }


            if($this->db->trans_status()===FALSE){
                $this->db->trans_rollback();
                $data=array(
                    'error'=>"#ERRORRECLASS00216 : Error in submitting in remarks. Please try Again"
                );
                echo json_encode($data);
                return false;
            }else{
                $dist_code = $this->session->userdata('dist_code');
                $subdiv_code = $this->session->userdata('subdiv_code');
                $cir_code = $this->session->userdata('cir_code');

                //ESCALATION CODE INTEGRATION================SANMRI
                $es_flag = $this->db->query("select es_flag from  t_reclassification where "
                        . " case_no='$case_no'")->row()->es_flag;
                if($es_flag == 1 && ESCALATION_ENABLE == 1 && $reclassData->out_of_esc == 0){
                    $user_code = $this->session->userdata('user_code');
                    $executionDate = $this->input->post('executionDate');
                    $escalationUpdateStatus = $this->Escalationmodel->escalationLMReclassReport($executionDate,$dist_code,$subdiv_code,$cir_code,$case_no,$user_code);

                    log_message("error", "#ESC3931, transaction-error-STATUS======".json_encode($escalationUpdateStatus));

                    if($escalationUpdateStatus['responseType'] == 0){
                        $this->db->trans_rollback();
                        log_message("error", "#ESC3931, transaction-error in method 'LandReclassification/write_report_lm' with case-no :". $case_no);
                        $this->session->set_flashdata('message', "Something went wrong.RECLASS- Error Code(#ESC3931)");
                        redirect(base_url() . "index.php/home");
                    }
                ///////////////END ESCALATION//////////////
                }
                
                $this->db->trans_commit();
                //////////////POST To rtps/////////////////////
                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK."applicationStatusUpdate");
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                    'application' => $dataDhar->basundhara,
                    'dharitree' => $case_no,
                    'rmk' => 'Registered Successfully',
                    'status' => 'M',
                    'task' => 'LM',
                    'pen'=>'CO',
                    'penat'=>'Circle office'
                )));
                $result = curl_exec($curl_handle);
                
                $this->DashboardReclass($case_no);
                $this->session->set_flashdata('message',"Application Forwarded to Circle Officer Successfully with case no $case_no ");
                //////////////////////////////////
                $data=array(
                    'success'=>"Application Forwarded to Circle Officer Successfully with case no $case_no",
                    'redirect_url'=>base_url().'index.php/home'
                );
            }

            echo json_encode($data);
        }

    public function DashboardReclass($case_no)
            {
                //$this->dbb = $this->load->database('dash', TRUE);

                $sql="select * from t_reclassification where case_no='$case_no' ";
                
                $type='RC';
                $data=$this->db->query($sql)->row_array();
                $base= array(
                            'dist_code'=> $data['dist_code'],
                              'subdiv_code' =>$data['subdiv_code'],
                              'cir_code'=>$data['cir_code'],
                              'mouza_pargona_code'=>$data['mouza_pargona_code'],
                              'lot_no'=>$data['lot_no'],
                              'vill_townprt_code'=>$data['vill_townprt_code'],
                              'case_no'=>$data['case_no'],
                              'date_of_reg'=>$data['lm_date'],
                              'dag_no'=>$data['dag_no'],
                              'patta_type_code' =>$data['patta_type_code'],
                              'patta_no' =>$data['patta_no'],
                              'status' =>'P',
                              'pending_with_user' =>'CO',
                              'case_type' =>$type,
                          );
                   // $this->db->insert('dashboard_data',$base);

                    unset($base['dag_no']);
                    unset($base['patta_type_code']);
                    unset($base['patta_no']);

                $this->db->insert('dashboard_data',$base);

        }

    public function revertToLMReclassByCOEscalation(){

        $db = $this->session->userdata('db');
        $case_no = $this->input->get('case_id');
        $proposal_no = $this->input->get('proposal_no');
        $user_code=$this->session->userdata('user_code');

        $q = "select * from t_reclassification where case_no = '$case_no'";
        $details = $this->db->query($q)->row();

        $dist_code = $this->utilityclass->getDistrictName($details->dist_code);
        $subdiv_code = $this->utilityclass->getSubDivName($details->dist_code, $details->subdiv_code);
        $cir_code = $this->utilityclass->getCircleName($details->dist_code, $details->subdiv_code, $details->cir_code);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code);
        $lot_no = $this->utilityclass->getLotName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no);
        $vill_townprt_code = $this->utilityclass->getVillageName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no, $details->vill_townprt_code);
        
        $co = $this->utilityclass->getSelectedCOName($details->dist_code, $details->subdiv_code, $details->cir_code, $user_code);
        $data['location'] = array(
            'dist' => $dist_code,
            'sub' => $subdiv_code,
            'cir' => $cir_code,
            'mouza' => $mouza_pargona_code,
            'lot' => $lot_no,
            'vill' => $vill_townprt_code,
            'co_name' => $co->username
        );
        $application_no="select * from basundhar_application where dharitree='$case_no' ";
        $data['app'] = $this->db->query($application_no)->row();
        $data['Pcases'] = $details;


        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $flag =false;
            if($details->es_flag == 1 && ESCALATION_ENABLE == 1 && $details->out_of_esc == 0){
                //remaining Days of LM ============
                $escalatedRowDetailsAgainstPetitionno = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($case_no);
                if(empty($escalatedRowDetailsAgainstPetitionno) || $escalatedRowDetailsAgainstPetitionno == null)
                {
                    log_message("error", "#ESC4047, transaction-error in method 'LandReclassification/revertToLMReclassByCOEscalation' with case-no :". $case_no);
                    $this->session->set_flashdata('message', "Something went wrong.RECLASS- Error Code(#ESC4047)");
                            redirect(base_url() . "index.php/home");
                }

                $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->lm_target_days;
                $previousCompletedDaysLM = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
                $remaining_days_LM = $this->Escalationmodel->getRemainingDays($previousCompletedDaysLM,$originalAllocation);

                //remaining days of CO==============
                $originalAllocationCO   = $escalatedRowDetailsAgainstPetitionno->co_target_days;
                $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
                $remaining_days_CO= $this->Escalationmodel->getRemainingDays($previousCompletedDaysCO,$originalAllocationCO);
                if($remaining_days_LM == 0){
                    $flag = true;
                }else{
                    $flag = false;
                }
            }
            $data['flag'] = $flag;
            $data['out_of_esc'] = $details->out_of_esc;
            $data['remainingDaysCO'] = $remaining_days_CO;

            $params = [
              'case_no'          => $case_no,
              'service_code'     => 4,
              'remarks'          => 'Reclassification',
              'accessed_entity'  => 'Aadhaar Status',
            ];
            $this->load->model('EkycLogModel');
            $log = $this->EkycLogModel->insertEkycAccessedBy($this->db, $params);
            
            $data['_view'] = 'LandReclassification/reverttoLMReclass';
            $this->load->view('layouts/main',$data);

        }else if ($this->input->server('REQUEST_METHOD') == 'POST') {


            $case_no = $this->input->post('case_no');
            $proposal_no = $this->input->post('proposal_no');
            $application_no=$this->input->post('application_no');

            $co_report1 = $this->input->POST('revert_report_remarks_co');
            $co_report_suffix = $this->input->POST('co_report_suffix');
            $co_report = $co_report1." - ".$co_report_suffix;
            //$co_report = str_replace("'", '', $co_report);
            $co_code = $this->session->userdata('user_code');
            $co_sign = 'Y';
            $co_date_entry = date('Y-m-d G:i:s');

            $this->db->trans_begin();
            $this->db->query("UPDATE t_reclassification SET status='M' WHERE case_no = '$case_no' and proposal_no = '$proposal_no'");


             /////////////ProCedding///////////////////////
            $sql="Select * from t_reclassification WHERE case_no = '$case_no' and proposal_no = '$proposal_no'";
            $tclass=$this->db->query($sql)->row();
            $prodId=$this->maxProceedingID($case_no);
            $pro_array=array(
                'dist_code' => $tclass->dist_code,
                'subdiv_code' => $tclass->subdiv_code,
                'cir_code' => $tclass->cir_code,
                'case_no'=>$case_no,
                'proceeding_id'=>$prodId,
                'status'=>'pending',
                'date_of_hearing'=>date('Y-m-d'),
                'co_order'=>$co_report,
                'user_code'=>$co_code,
                'date_entry'=>$co_date_entry,
                'operation'=>'E'
            );
            $this->db->insert('petition_proceeding_dc_adc',$pro_array);
            $penUser='LM';
            $rmrk='Revert to LM by CO';
            $this->DashboardData($case_no,$penUser,$rmrk);

            if($application_no)
            {
                $rtps=$this->rtpsmodel->checkRtpsService($application_no);
                if($rtps=='RTPS'){
                    $apilink=RTPS_API_LINK;
                }else{
                    $apilink=API_LINK;
                }
                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                    'application' => $application_no,
                    'dharitree' => $case_no,
                    'rmk' => 'forwared to LM',
                    'status' => 'M',
                    'task' => 'CO',
                    'pen'=>'LM',
                    'penat'=>'Circle office'
                )));
                $result = curl_exec($curl_handle);
                if($result==true){

                    $dist_code = $this->session->userdata('dist_code');
                    $subdiv_code = $this->session->userdata('subdiv_code');
                    $cir_code = $this->session->userdata('cir_code');

                    //ESCALATION CODE INTEGRATION================SANMRI
                    $es_flag_data = $this->db->query("select es_flag,out_of_esc from  t_reclassification where "
                                . " case_no='$case_no'")->row();
                    if($es_flag_data->es_flag == 1 && ESCALATION_ENABLE ==1 && $es_flag_data->out_of_esc == 0){

                        $user_code = $this->session->userdata('user_code');
                        $executionDate = $this->input->post('executionDate');
                        $allocation_days = null;

                        if($this->input->post('allocate_day') !=null){
                            $allocation_days = $this->input->post('allocate_day');
                        }

                        $escalationUpdateStatus = $this->Escalationmodel->escalationCORevertToLMRECLASS($executionDate,$dist_code,$subdiv_code,$cir_code,$case_no,$user_code,$tclass->mouza_pargona_code,$tclass->lot_no,$allocation_days);

                        log_message("error", "#ESC4152, transaction-error-STATUS======".json_encode($escalationUpdateStatus));
                        if($escalationUpdateStatus['responseType'] == 0){
                            $this->db->trans_rollback();
                            log_message("error", "#ESC4152, transaction-error in method 'LandReclassification/revertToLMReclassByCOEscalation' with case-no :". $case_no);
                            $this->session->set_flashdata('message', "Something went wrong.RECLASS- Error Code(#ESC4152)");
                            redirect(base_url() . "index.php/home");
                        }
                        ///////////////END ESCALATION//////////////
                    }

                    $this->db->trans_commit();
                }else{
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message',"Error in API Call");
                    redirect(base_url() . "index.php/home");
                }
            }
                $this->db->trans_commit();
                $this->session->set_flashdata('message',"Forwared to LM for correction of remark #$case_no ");
                redirect(base_url() . "index.php/home");


            }
        }



    }
