<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class COconversionPartha extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        // Allowed designations
        $allowed = ['CO','DC'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }
        
        $this->load->model('mutation/mutationmodel');
        $this->load->model('conversion/COofficeConversionModel');
        $this->load->model('basundhara/basundharamodel');
        $this->load->model('rtps/rtpsmodel');
        $this->load->model('v2/SupportiveDocumentModel');
        $this->load->model('validation/FormValidationModel');
        $this->load->model('validation/AuthorizationModel');
        $this->load->model('basundhara/ApiLogModel');
        $this->load->model('AgriStackCaseHistory');
        ini_set('memory_limit', '1024M');
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


    public function GoToCO() {
      //$db=  $this->session->userdata('db');
        $this->load->library('pagination');
        $process = $this->input->get('pro');
        // $page=1;
        // if ($_GET['per_page']!=null)
        //     $page = $this->input->get('per_page');
        $user_code = $this->session->userdata('user_code');
        $user_desig_code=$this->session->userdata('user_desig_code');
    
        $searchKeyword=null;
        if($this->input->post('submitSearch')){
              $inputKeywords = $this->input->post('searchKeyword');
              $searchKeyword = strip_tags($inputKeywords);
              if(!empty($searchKeyword)){
                  $this->session->set_userdata('searchKeyword',$searchKeyword);
              }else{
                  $this->session->unset_userdata('searchKeyword');
              }
        }elseif($this->input->post('submitSearchReset')){
            $this->session->unset_userdata('searchKeyword');
        }

        if ($process == '1') {
            //$config['total_rows'] = $this->COofficeConversionModel->countPendingConversionFreshCases($user_code);
            //$cases['cases'] = $this->COofficeConversionModel->getPendingConversionFreshCases($user_code)->result();

            $cases['searchKeyword'] = $this->session->userdata('searchKeyword');
            $config['base_url'] = base_url().'index.php/COconversionPartha/GoToCO';        
            $config['total_rows'] = $this->COofficeConversionModel->countPendingConversionFreshCases($user_code);
            //$config['page_query_string'] = TRUE;        
            if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
            $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
            $config['per_page'] = 50;        
            $config['uri_segment'] = 3;        
            $config['full_tag_open'] = '<ul class="pagination">';        
            $config['full_tag_close'] = '</ul>';        
            $config['first_link'] = 'First';        
            $config['last_link'] = 'Last';        
            $config['first_tag_open'] = '<li>';        
            $config['first_tag_close'] = '</li>';        
            $config['prev_link'] = '&laquo';        
            $config['prev_tag_open'] = '<li class="prev">';        
            $config['prev_tag_close'] = '</li>';        
            $config['next_link'] = '&raquo';        
            $config['next_tag_open'] = '<li>';        
            $config['next_tag_close'] = '</li>';        
            $config['last_tag_open'] = '<li>';        
            $config['last_tag_close'] = '</li>';        
            $config['cur_tag_open'] = '<li class="active"><a href="#">';        
            $config['cur_tag_close'] = '</a></li>';        
            $config['num_tag_open'] = '<li>';        
            $config['num_tag_close'] = '</li>';
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $this->pagination->initialize($config);        
            $cases['links'] = $this->pagination->create_links();        
            $cases['cases'] = $this->COofficeConversionModel->getPendingConversionFreshCases($user_code,$config["per_page"], $page,$searchKeyword)->result(); 
        } elseif ($process == '2') {
            $cases['searchKeyword'] = $this->session->userdata('searchKeyword');
            $config['base_url'] = base_url().'index.php/COconversionPartha/GoToCO';        
            $config['total_rows'] = $this->COofficeConversionModel->countPendingConversionSecondCases($user_code);
            //$config['page_query_string'] = TRUE;        
            if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
            $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
            $config['per_page'] = 50;        
            $config['uri_segment'] = 3;        
            $config['full_tag_open'] = '<ul class="pagination">';        
            $config['full_tag_close'] = '</ul>';        
            $config['first_link'] = 'First';        
            $config['last_link'] = 'Last';        
            $config['first_tag_open'] = '<li>';        
            $config['first_tag_close'] = '</li>';        
            $config['prev_link'] = '&laquo';        
            $config['prev_tag_open'] = '<li class="prev">';        
            $config['prev_tag_close'] = '</li>';        
            $config['next_link'] = '&raquo';        
            $config['next_tag_open'] = '<li>';        
            $config['next_tag_close'] = '</li>';        
            $config['last_tag_open'] = '<li>';        
            $config['last_tag_close'] = '</li>';        
            $config['cur_tag_open'] = '<li class="active"><a href="#">';        
            $config['cur_tag_close'] = '</a></li>';        
            $config['num_tag_open'] = '<li>';        
            $config['num_tag_close'] = '</li>';
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $this->pagination->initialize($config);        
            $cases['links'] = $this->pagination->create_links();        
            $cases['cases'] = $this->COofficeConversionModel->getPendingConversionSecondCases($user_code,$config["per_page"], $page,$searchKeyword)->result();           
        } elseif ($process == '3') {
            $config['total_rows'] = $this->COofficeConversionModel->countChithaUpdateConvCases($user_code);
            $cases['cases'] = $this->COofficeConversionModel->getChithaUpdateConvCases($user_code)->result();
        } elseif ($process == '4') {
            $config['total_rows'] = $this->COofficeConversionModel->countconversion_proceeding_report($user_code);
            $cases['cases'] = $this->COofficeConversionModel->getconversion_proceeding_report($user_code)->result();
        } elseif ($process == '5') {
            $config['total_rows'] = $this->COofficeConversionModel->countRejectedConversionSecondCases($user_code);
            $cases['cases'] = $this->COofficeConversionModel->getRejectedConversionSecondCases($user_code)->result();
            //var_dump($cases);
        } elseif ($process == '6') {
            $config['total_rows'] = $this->COofficeConversionModel->countConvertionOrderPassedByDC($user_desig_code);
            $cases['cases'] = $this->COofficeConversionModel->getConvertionOrderPassedByDC($user_desig_code)->result();
            //var_dump($cases);
        }
        //$cases['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
        $cases['process'] = $process;
        $cases['_view'] = 'co_office_conversion/co_conversion_cases';
        $this->load->view('layouts/main',$cases);
    }

    public function FirstProcess() {
      //$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');
        $this->session->set_userdata(array('mouza_pargona_code1' => $mouza_pargona_code));
        $this->session->set_userdata(array('lot_no1' => $lot_no));
        $this->session->set_userdata(array('vill_townprt_code1' => $vill_townprt_code));
        $data = array();
        $case_no = $this->input->get('case_no');
        $pb = $data['petition_basic'] = $this->db->query("select * from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' "
                . "and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code' and is_mb3!=1")->row();
        $date = date('Y-m-d');
        
        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                . "cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code' and is_mb3!=1")->row();
        
        $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,add_off_name from    petition_basic where "
                . "case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
                . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code' and is_mb3!=1")->row_array();

        $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from    petition_dag_details where "
                . "dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and "
                . "vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and "
                . "petition_no='$petition_basic->petition_no'")->row_array();
        
        $locationData = array(
            'dist_code' => $location['dist_code'],
            'subdiv_code' => $location['subdiv_code'],
            'cir_code' => $location['cir_code'],
            'lot_no' => $location['lot_no'],
            'vill_code' => $location['vill_townprt_code'],
            'mouza_pargona_code' => $location['mouza_pargona_code']
        );
        
        $data['patta_type'] = $this->db->query("select patta_type from    patta_code where type_code='$landdetails[patta_type_code]'")->row()->patta_type;
        
        $dist_code_name = $this->utilityclass->getDistrictName($location['dist_code']);
        $subdiv_code_name = $this->utilityclass->getSubDivName($location['dist_code'], $location['subdiv_code']);
        $cir_code_name = $this->utilityclass->getCircleName($location['dist_code'], $location['subdiv_code'], $location['cir_code']);
        $mouza_pargona_code_name = $this->utilityclass->getMouzaName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code']);
        $lot_no_name = $this->utilityclass->getLotName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no']);
        $vill_townprt_code_name = $this->utilityclass->getVillageName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $location['vill_townprt_code']);

        $m_dag_area_lc = round($landdetails['m_dag_area_lc'], 2);
        $coName=$this->utilityclass->getSelectedCOName($dist_code,$subdiv_code,$cir_code,$this->session->userdata('user_code'));
        //var_dump($coName);
        $data['location'] = array(
            'dist' => $dist_code_name,
            'sub' => $subdiv_code_name,
            'cir' => $cir_code_name,
            'mouza' => $mouza_pargona_code_name,
            'lot' => $lot_no_name,
            'vill' => $vill_townprt_code_name,
            'case_no' => $case_no,
            'date' => $date,
            'dag' => $landdetails['dag_no'],
            'm_dag_area_b' => $landdetails['m_dag_area_b'],
            'm_dag_area_k' => $landdetails['m_dag_area_k'],
            'm_dag_area_lc' => $m_dag_area_lc,
            'patta_no' => trim($landdetails['patta_no']),
            'patta_type' => $landdetails['patta_type_code'],
            'add_to' => $coName->username
        );
        
        $convertion_code = CONVERSION_CODE;
        
        $data['conv_type'] = $this->db->query("select order_type from    master_office_mut_type where order_type_code='$convertion_code'")->row()->order_type;

        $pattadardetails = "select auth_type,id_ref_no,pdar_name,pdar_guardian,pdar_rel_guar,pdar_add1,pdar_add2,pdar_mobile from    petitioner_part where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and dag_no='$landdetails[dag_no]' and TRIM(patta_no)=trim('$landdetails[patta_no]') and patta_type_code= '$landdetails[patta_type_code]'";
        $data['pattadar'] = $this->db->query($pattadardetails)->result();

        $this->session->set_userdata($locationData);
        $this->session->set_userdata(array('case_no' => $case_no));
        
        $this->load->helper('html');
        $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
        if($basundhara){
            $rtps=$this->rtpsmodel->checkBasundharaService($case_no);
            if($rtps=='RTPS'){
                $data['basundharaAttachment']=$this->rtpsmodel->searchBasundharaLink($case_no);
            }else{
                $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
            }
        }
        else{
            $data['supportiveDocs'] = $this->SupportiveDocumentModel->getDocs($case_no);
        }

        if(ENABLED_BLOCKCHAIN == 1 &&  in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {

            //////////////////////////////////////////////////////////////// Property Chain Code //////////////////////////////////////////////
            $this->load->model('propChain/PropChainModel');

            $data['propChainEnableFlag'] = $this->PropChainCommonModel->isLocationEnable($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);

            $landArea = $this->PropChainModel->getLandArea($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, trim($landdetails['patta_no']), $landdetails['dag_no']);

            $chainChithaCheck = $this->PropChainModel->chainChithaUlpinCheckProcess($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, trim($landdetails['patta_no']), $landdetails['dag_no'], $landArea->dag_area_b, $landArea->dag_area_k, $landArea->dag_area_lc, $landArea->dag_area_g, $landdetails['patta_type_code']);

            // var_dump($chainChithaCheck);
            // die;

            if ($chainChithaCheck['ulpinCheck'] == 1 && ($chainChithaCheck['chithaPropChainCmpFlag'] == 'Y' || $chainChithaCheck['chithaPropChainCmpFlag'] == 'N' || $chainChithaCheck['chithaPropChainCmpFlag'] == 'NE')) {
                $this->PropChainModel->updateCmpFlag($case_no, $chainChithaCheck['chithaPropChainCmpFlag']);
                if ($chainChithaCheck['chithaPropChainCmpFlag'] == 'N') {
                    $data['viewMisMatchBtn'] = $this->PropChainModel->getMismatchBtn(
                        $case_no,
                        $dist_code,
                        $subdiv_code,
                        $cir_code,
                        $mouza_pargona_code,
                        $lot_no,
                        $vill_townprt_code,
                        trim($landdetails['patta_no']),
                        $landdetails['dag_no'],
                        $landArea->dag_area_b,
                        $landArea->dag_area_k,
                        $landArea->dag_area_lc,
                        $landArea->dag_area_g,
                        $landdetails['patta_type_code']
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



        //$data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
        $data['_view'] = 'co_office_conversion/first_proceeding';
        $this->load->view('layouts/main',$data);
    }

    public function SecondProcess() {
        $db=  $this->session->userdata('db');
        $location = $this->utilityclass->getLocationfromSession();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code1');
        $lot_no = $this->session->userdata('lot_no1');
        $vill_townprt_code = $this->session->userdata('vill_townprt_code1');
        
        $hearing_date = date('Y-m-d', strtotime($this->input->post('hearing_date')));
        $this->session->set_userdata(array('hearing_date' => $hearing_date));
        $co_order = $this->input->post('co_order');
        $this->session->set_userdata(array('co_order' => $co_order));
        $case_no = $this->session->userdata('case_no');
        $data['_view'] = 'co_office_conversion/first_proceeding_1';
        $this->load->view('layouts/main',$data);
    }

    public function ThirdProcess() {
        //form validation
        $formValidation = $this->FormValidationModel->formValidationForPost($_POST, [
            'co_order'=>'CO Order|required',
            'hearing_date'=>'Hearing Date|required|date',
            'case_no'=>'Case No.|required|case_no'
        ]);
        if($formValidation['status'] == 'n') {
            //ERRCONVCO0000
            log_message('error', 'Message: '. $formValidation['message'] .', Data: '. json_encode($formValidation['data']) .'. Error: ERRCONVCO0000');
            $this->session->set_flashdata('message', $formValidation['message'] .'. Error: ERRCONVCO0000');
            redirect(base_url('index.php/COconversionPartha/GoToCO?pro=1'));
        }

        //syntax validation
        $coOrder = $_POST['co_order'];
        // $_POST['co_order'] = preg_replace('/\s+/', ' ', strip_tags($coOrder));
        // $_POST['name_spcl'] = 'উত্‍পল অধিকাৰী';
        $requestResponse = checkRequestSpecChar($_POST, [], [], ['co_order'=>true]);//, ['co_order'=>[' ঁ']]
        if($requestResponse['status'] == 'n') {
            //ERRCONVCO0001
            log_message('error', $requestResponse['messages'] . '. Error: ERRCONVCO0001');
            $this->session->set_flashdata('message', 'Contains Illegal parameter values. Error: ERRCONVCO0001');
            redirect(base_url('index.php/COconversionPartha/GoToCO?pro=1'));
        }

        //check for malicious query
        $validResponse = checkRequestValidQuery($_POST, [], ['co_order'=>false]);
        if($validResponse['status'] == 'n') {
            //ERRCONVCO0002
            log_message('error', $validResponse['messages'] . '. Error: ERRCONVCO0002');
            $this->session->set_flashdata('message', 'Contains Malicious parameter values. Error: ERRCONVCO0002');
            redirect(base_url('index.php/COconversionPartha/GoToCO?pro=1'));
        }

        //authorization
        // $case_no = $this->session->userdata('case_no');
        $case_no = $this->input->post('case_no');
        $authorized = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'CO', $case_no, CONV_CO_FIRST);
        if($authorized['status'] == 'n') {
            //ERRCONVCO0003
            log_message('error', $authorized['messages'] . '. Error: ERRCONVCO0003');
            $this->session->set_flashdata('message', $authorized['messages'] .'. Error: ERRCONVCO0003');
            redirect(base_url('index.php/home'));
        }
        // echo '<pre>';
        // var_dump($_POST);
        // die();

        // echo '<pre>';
        // var_dump($_POST, $authorized);
        // die();
       
        // if(!isset($_POST['co_order']) || $_POST['co_order'] == '' || !isset($_POST['hearing_date']) || $_POST['hearing_date'] == '') {
        //     //ERRCONVCO0000
        //     log_message('error', 'The required fields are empty. Error: ERRCONVCO0000');
        //     $this->session->set_flashdata('message', 'The required fields are empty. Error: ERRCONVCO0000');
        //     redirect(base_url('index.php/COconversionPartha/GoToCO?pro=1'));
        // }

        // $formResponse = postParamFormValidation($_POST, [
        //     'hearing_date'=>'date',
        //     'case_no'=>'case_no'
        // ]);
        // if($formResponse['status'] == 'n') {
        //     //ERRCONVCO0003
        //     log_message('error', $formResponse['message'] . '. Error: ERRCONVCO0003');
        //     $this->session->set_flashdata('message', $formResponse['message'] .'. Error: ERRCONVCO0003');
        //     redirect(base_url('index.php/COconversionPartha/GoToCO?pro=1'));
        // }
        
        //$db=  $this->session->userdata('db');
        $case_no = $this->input->post('case_no');
        $location = $this->utilityclass->getLocationfromSession();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code1');
        $lot_no = $this->session->userdata('lot_no1');
        $vill_townprt_code = $this->session->userdata('vill_townprt_code1');
        
        // $case_no = $this->session->userdata('case_no');

        if(ESCALATION_ENABLE == 1)
        {
            $hearing_date = date('Y-m-d H:i:s', strtotime($this->input->post('hearing_date')));    
        }
        else
        {
            $hearing_date = date('Y-m-d', strtotime($this->input->post('hearing_date')));
        }

        
        $hearing_date = date('Y-m-d', strtotime($this->input->post('hearing_date')));
        // $co_order = $this->input->post('co_order');
        $co_order = $coOrder;
        $date_entry = date('Y-m-d G:i:s');
        $operation = 'E';
        $year_no = date('Y');
        $user_code = $this->session->userdata('user_code');

        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' and "
                . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
                . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code' and is_mb3!=1")->row();


        $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from    petition_dag_details where "
                . "dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and "
                . "lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and "
                . "mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'")->row_array();

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
        $pattadardetails = $this->db->query("select pdar_name,pdar_guardian,pdar_rel_guar,pdar_add1,pdar_add2 from    petitioner_part where "
                . "dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' "
                . "and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and "
                . "mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' "
                . "and dag_no='$landdetails[dag_no]' and TRIM(patta_no)=trim('$landdetails[patta_no]') and patta_type_code= '$landdetails[patta_type_code]'")->result();
        
        
        $proceeding = $this->db->query("select count(proceeding_id) as proceed from    petition_proceeding where case_no = '$case_no' limit 1")->result();
        $proceeding_id = $proceeding[0]->proceed + 1;

        $this->db->trans_begin();

        $proceeding_data = array(
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => $hearing_date,
            'co_order' => $co_order,
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

        $insert_pp = $this->db->insert("petition_proceeding", $proceeding_data);
        if($insert_pp != 1){
            $this->db->trans_rollback();
            log_message('error', '#ERRCONV051: Insertion failed in petition_proceeding for case no :'. $case_no);
            $json = [
                'message'=>"#ERRCONV051: Failed to in Proceeding for Case No : ".$case_no
            ];
            echo json_encode($json);
            return false;
        }

        $this->db->query("UPDATE  Petition_Basic SET status = 'P', next_date_of_hearing = '$hearing_date',not_fresh = 'Y',notice_generated_yn='Y',notice_generated_date = '$date_entry' WHERE case_no = '$case_no' and "
                        . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' "
                        . "and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code' and is_mb3!=1");

        if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            log_message('error', '#ERRCONV052: Updation failed in Petition_Basic Case No ' . $case_no);
            $data = array(
                'error' => "#ERRCONV052: Registration of Petition basic failed for case no : " . $case_no,
            );
            echo json_encode($data);
            return false;
        }


        if($petition_basic->es_flag == 1 && ESCALATION_ENABLE == 1)
        {
            $user_code = $this->session->userdata('user_code');
            $executionDate = $this->input->post('executionDate');
            $serviceChoose = explode('/', $case_no);
            $next_date_of_hearing = $petition_basic->next_date_of_hearing.date(' H:i:s');

            $escalationUpdateStatus = $this->ConversionEscalationModel->escalationCoConversionReport($executionDate, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $case_no, $user_code);

            log_message("error", "#ESC481, transaction-error-STATUS======".json_encode($escalationUpdateStatus['responseType']));            

            if($escalationUpdateStatus['responseType'] == 0)
            {
                $this->db->trans_rollback();
                log_message("error", "#ESC481, transaction-error in method 'COconversionPartha/GoToCO?pro=1' with case-no :". $case_no);
                $this->session->set_flashdata('message', "Something went wrong. NCOR- Error Code(#ESC481)");
                redirect(base_url() . "index.php/home");
            }
            ///////////////END ESCALATION//////////////
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
            $penUser='LM';
            $rmrk='Report by CO';
            $status='M';
            $task='CO';
            $pen='LM';
            $case=$case_no;

            $rtps_status = $this->ApiLogModel->sendCurlRequest($case,$rmrk,$status,$task,$pen);
            
            if (trim($rtps_status['result']) !="y") {
                $this->db->trans_rollback();

                //insert curl request
                $this->ApiLogModel->saveCurlLog($rtps_status['url'], 'GET', $rtps_status['postData'], null, null, null,$case_no);

                //insert curl result
                $this->ApiLogModel->saveCurlLog($rtps_status['url'], $rtps_status['method'], $rtps_status['postData'], $rtps_status['httpcode'], $rtps_status['curlError'], $rtps_status['result'],$case_no);
                $this->DashboardData($case_no,$penUser,$rmrk);
                $this->session->set_flashdata('message', "Error #ERRAPP0011: Conversion Application not submitted case no # $case_no");
                redirect(base_url() . "index.php/home");
            } else {
                $this->db->trans_commit();
                 //insert curl request
                $this->ApiLogModel->saveCurlLog($rtps_status['url'], 'GET', $rtps_status['postData'], null, null, null,$case_no);
                $this->DashboardData($case_no,$penUser,$rmrk);
            }


            // $this->basundharamodel->postApiBasundharaSec($case,$rmrk,$status,$task,$pen);   
            ///////
            $this->session->set_flashdata('message', "Conversion Proceeding Order has been Passed for Case no # $case_no");
            redirect(base_url() . "index.php/home");
        }
    }

    public function SecondProceeding() {
      //$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');
        $this->session->set_userdata(array('mouza_pargona_code1' => $mouza_pargona_code));
        $this->session->set_userdata(array('lot_no1' => $lot_no));
        $this->session->set_userdata(array('vill_townprt_code1' => $vill_townprt_code));
        $data = array();
        $case_no = $this->input->get('case_no');
        $user_code=$this->session->userdata('user_code');
        $coname=$this->utilityclass->getSelectedCOName($dist_code,$subdiv_code,$cir_code,$user_code);
        $petition_basic = $this->db->query("select * from petition_basic where case_no='$case_no' "
                . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
                . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code' and is_mb3!=1")->row();

        $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,date_entry,add_off_name,next_date_of_hearing,sk_comment,petition_no"
                        . " from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
                . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code' and is_mb3!=1")->row_array();
        
        $petition_no = $location['petition_no'];
        $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code 
        from    petition_dag_details where dist_code='$dist_code' and subdiv_code='$subdiv_code'
        and cir_code='$cir_code' and lot_no='$lot_no' and 
        vill_townprt_code='$vill_townprt_code' and mouza_pargona_code='$mouza_pargona_code' 
        and petition_no='$petition_no'")->row_array();

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
        
        $data['patta_type'] = $this->db->query("select patta_type from patta_code "
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
            'add_to' => $coname->username,
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
                . "where order_type_code='$convertion_code'")->row()->order_type;

        $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from    petition_dag_details where dist_code='$petition_basic->dist_code' "
                . "and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' "
                . "and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'")->row_array();

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

        $pattadardetails = "select auth_type,id_ref_no,pdar_name,pdar_guardian,pdar_rel_guar,pdar_add1,pdar_add2, inplace_alongwith from petitioner_part where dist_code='$petition_basic->dist_code' and "
                . "subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and "
                . "vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and "
                . "petition_no='$petition_basic->petition_no' and dag_no='$landdetails[dag_no]' and TRIM(patta_no)=trim('$landdetails[patta_no]') and "
                . "patta_type_code= '$landdetails[patta_type_code]'";
        
        $data['pattadar'] = $this->db->query($pattadardetails)->result();
        $data['p_in_order'] = $this->db->query($pattadardetails)->result();
        
        $lm_details = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
                . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' "
                . "and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' order by note_no desc limit 1 ")->row_array();
        if($lm_details['premium_new_yn'] == 1) {
            $getPremiumRate = $this->db->query("SELECT * FROM conversion_premium_rates WHERE id=?", [$lm_details['conversion_premium_rates_id']])->row();
            if($getPremiumRate->amount != 0 && $getPremiumRate->rate == 0) {
                $effective_premium_amount = $getPremiumRate->amount;
                $is_percent = 0;
            }
            else if($getPremiumRate->amount == 0 && $getPremiumRate->rate != 0) {
                $effective_premium_amount = $getPremiumRate->rate;
                $is_percent = 1;
            }
            else {
                $effective_premium_amount = 0;
                $is_percent = 0;
            }
            $data['premium_rate_details'] = $getPremiumRate;
            $data['premium_area_details'] = $this->db->query("SELECT * FROM conversion_premium_areas WHERE is_deleted=0 AND id=?", [$lm_details['conversion_premium_areas_id']])->row();
            $data['conversion_premium_area'] = $data['premium_area_details'];
        }
        else {
            $effective_premium_amount = 0;
            $is_percent = 0;
            $data['premium_rate_details'] = '';
            $data['premium_area_details'] = '';
            $data['conversion_premium_area'] = '';
        }
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
                'land_trans_yn' => $lm_details['land_trans_yn'],
                'premium_new_yn' => $lm_details['premium_new_yn'],
                'effective_premium_amount' => $effective_premium_amount,
                'is_percent' => $is_percent
            );
        }
        
        $namelm = $this->db->query("select * from    lm_code where lm_code = '" . $lm_details['lm_code'] . "'  and dist_code = '" . $location['dist_code'] . "' and subdiv_code = '" . $location['subdiv_code'] . "' and cir_code = '" . $location['cir_code'] . "' and mouza_pargona_code = '" . $location['mouza_pargona_code'] . "' and lot_no = '" . $location['lot_no'] . "' ")->row();
        $data['lm_name'] = $namelm->lm_name;
        
        $skname = $this->db->query("select * from  users where user_code='" . $lm_details['user_code'] . "'  and dist_code = '" . $lm_details['dist_code'] . "' and subdiv_code = '" . $lm_details['subdiv_code'] . "' and cir_code = '" . $lm_details['cir_code'] . "' ")->row();
        $data['sk_skname'] = $skname->username;

        $query = "select * from    petition_proceeding where case_no = '$case_no' order by proceeding_id";
        $data['cases'] = $this->db->query($query)->result();

        $data['lm_details_final'] = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' ORDER BY note_no DESC LIMIT 1")->result();
        
        $data['premium'] = $this->db->query("Select * from petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and co_reject is NULL ORDER BY note_no DESC LIMIT 1")->result();

        $data['dc_adc']=$this->db->query("Select users.username as username, users.user_desig_code as user_desig_code, loginuser_table.user_code as user_code from    users, "
                . "loginuser_table where users.dist_code = loginuser_table.dist_code "
                . "and users.user_code = loginuser_table.user_code and users.user_desig_code like '%DC' and users.dist_code='$petition_basic->dist_code' and "
                . "users.subdiv_code='00' and users.cir_code='00' and loginuser_table.dis_enb_option = 'E' and loginuser_table.priv = 'adm'")->result();

        $data['adc_only']=$this->db->query("Select users.username as username, users.user_desig_code as user_desig_code, loginuser_table.user_code as user_code from    users, "
        . "loginuser_table where users.dist_code = loginuser_table.dist_code "
        . "and users.user_code = loginuser_table.user_code and users.user_desig_code ='ADC' and users.dist_code='$petition_basic->dist_code' and "
        . "users.subdiv_code='00' and users.cir_code='00' and loginuser_table.dis_enb_option = 'E' and loginuser_table.priv = 'adm'")->result();
        //$data['basundharaExist']=$this->basundharamodel->checkExistBasundhar($case_no);
        $data['basuCase']=$basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
        if($basundharaExist){
            $data['query']=null;
            $rtps=$this->rtpsmodel->checkBasundharaService($case_no);
            if($rtps=='RTPS'){
                $data['basundharaAttachment']=$this->rtpsmodel->searchBasundharaLink($case_no);
            }else{
                $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
            }
            $data['query']=$this->basundharamodel->QueryPost($basundharaExist);
        }
        else{
            $data['supportiveDocs'] = $this->SupportiveDocumentModel->getDocs($case_no);
        }


        if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {
            //////////////////////////////////////////////////////////////// Property Chain Code //////////////////////////////////////////////
            $this->load->model('propChain/PropChainModel');

            $data['propChainEnableFlag'] = $this->PropChainCommonModel->isLocationEnable($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $location['vill_townprt_code']);

            $data['propChainEnableFlag'] = $this->PropChainCommonModel->isLocationEnable($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $location['vill_townprt_code']);

            // get total land area
            $landArea = $this->PropChainModel->getLandArea($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $location['vill_townprt_code'], trim($landdetails['patta_no']), $landdetails['dag_no']);

            // echo "<pre>";
            // var_dump($landdetails);
            $chainChithaCheck = $this->PropChainModel->chainChithaUlpinCheckProcess($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $location['vill_townprt_code'], trim($landdetails['patta_no']), $landdetails['dag_no'], $landArea->dag_area_b, $landArea->dag_area_k, $landArea->dag_area_lc, $landArea->dag_area_g, $landdetails['patta_type_code']);

            // die;

            // var_dump($checkRemainingLand);
            if ($chainChithaCheck['ulpinCheck'] == 1 && ($chainChithaCheck['chithaPropChainCmpFlag'] == 'Y' || $chainChithaCheck['chithaPropChainCmpFlag'] == 'N' || $chainChithaCheck['chithaPropChainCmpFlag'] == 'NE')) {
                $this->PropChainModel->updateCmpFlag($case_no, $chainChithaCheck['chithaPropChainCmpFlag']);
                if ($chainChithaCheck['chithaPropChainCmpFlag'] == 'N') {
                    $data['viewMisMatchBtn'] = $this->PropChainModel->getMismatchBtn(
                        $case_no,
                        $location['dist_code'],
                        $location['subdiv_code'],
                        $location['cir_code'],
                        $location['mouza_pargona_code'],
                        $location['lot_no'],
                        $location['vill_townprt_code'],
                        trim($landdetails['patta_no']),
                        $landdetails['dag_no'],
                        $landArea->dag_area_b,
                        $landArea->dag_area_k,
                        $landArea->dag_area_lc,
                        $landArea->dag_area_g,
                        $landdetails['patta_type_code']
                    );
                }
            }

            $data['ulpinCheck'] = $chainChithaCheck['ulpinCheck'];
            $data['ulpinMsg'] = $chainChithaCheck['ulpinMsg'];

            if ($data['ulpinCheck'] == 1) {
                $data['ulpin'] = $chainChithaCheck['ulpin'];
                if (isset($data['old_ulpin']))
                    $data['old_ulpin'] = $chainChithaCheck['old_ulpin'];
                else
                    $data['old_ulpin'] = "";
            }

            $data['chithaPropChainCmpFlag'] =  $chainChithaCheck['chithaPropChainCmpFlag'];
            $data['compareFlagMsg'] = $chainChithaCheck['compareFlagMsg'];

            if ($chainChithaCheck['chithaPropChainCmpFlag'] == 'NE')
                $data['createPropChainBtn'] = $chainChithaCheck['createPropChainBtn'];

            $data['revenue'] = $chainChithaCheck['revenue'];
            $data['local_tax'] = $chainChithaCheck['local_tax'];
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

        // $data['show_nav'] = ['allow'=>true, 'service_code'=>SERVICE_CONVERSION, 'case_no'=>$case_no, 'reports'=>'ast,lm,sk,co'];

        $data['_view'] = 'co_office_conversion/Second_Proceeding';
        $this->load->view('layouts/main',$data);
    }


    public function Regenerate() {
        $coNotice = $_POST['Co_notice'];
        $coReasonNote = $_POST['co_reason_note'];
        // $_POST['Co_notice'] = preg_replace('/\s+/', ' ', strip_tags($coNotice));
        $_POST['co_reason_note'] = preg_replace('/\xc2\xa0/', '', $coReasonNote);

        //form validation
        $formValidation = $this->FormValidationModel->formValidationForPost($_POST, [
            'case_no'=>'Case No.|required|case_no',
            'Co_notice'=>'CO Notice|required',
            'hearing_date'=>'Hearing Date|required|date',
            'order_type'=>'Order Type|required',
            'co_reason_note'=>'CO Revert Note|required_on_condition(order_type,equals,[re_lm_note])',
            're_hearing_date'=>'Reverted Hearing Date|required_on_condition(order_type,equals,[re_lm_note])|date'
        ]);
        if($formValidation['status'] == 'n') {
            //ERRCONVCOSECOND0001
            log_message('error', 'Message: '. $formValidation['message'] .',Data: '. json_encode($formValidation['data']) .' Error: ERRCONVCOSECOND0001');
            $this->session->set_flashdata('message', $formValidation['message'] .' Error: ERRCONVCOSECOND0001');
            redirect(base_url('index.php/COconversionPartha/GoToCO?pro=2'));
        }

        //syntax validation
        $requestResponse = checkRequestSpecChar($_POST, ['Co_notice'=>['%', '৚']], [], ['Co_notice'=>true]);
        if($requestResponse['status'] == 'n') {
            //ERRCONVCOSECOND0002
            log_message('error', $requestResponse['messages'] . '. Error: ERRCONVCOSECOND0002');
            $this->session->set_flashdata('message', 'Contains Illegal parameter values. Error: ERRCONVCOSECOND0002');
            redirect(base_url('index.php/COconversionPartha/GoToCO?pro=2'));
        }

        //malicious query validation
        $validResponse = checkRequestValidQuery($_POST, [], ['Co_notice'=>true]);
        if($validResponse['status'] == 'n') {
            //ERRCONVCOSECOND0003
            log_message('error', $validResponse['messages'] . '. Error: ERRCONVCOSECOND0003');
            $this->session->set_flashdata('message', 'Contains Malicious parameter values. Error: ERRCONVCOSECOND0003');
            redirect(base_url('index.php/COconversionPartha/GoToCO?pro=2'));
        }

        $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'CO', $_POST['case_no'], CONV_CO_SECOND);
        if($authorization['status'] == 'n') {
            //ERRCONVCOSECOND0004
            log_message('error', $authorization['messages'] . '. Error: ERRCONVCOSECOND0004');
            $this->session->set_flashdata('message', $authorization['messages'].'. Error: ERRCONVCOSECOND0004');
            redirect(base_url('index.php/home'));
        }
        
       
      //$db=  $this->session->userdata('db');
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code1');
        $lot_no = $this->session->userdata('lot_no1');
        $vill_townprt_code = $this->session->userdata('vill_townprt_code1');
        $hearing_date = date('Y-m-d', strtotime($this->input->post('hearing_date')));
        $re_hearing_date = date('Y-m-d', strtotime($this->input->post('re_hearing_date')));
        // $co_order = $this->input->post('Co_notice');
        // $co_reason_note = $this->input->post('co_reason_note');
        $co_order = $coNotice;
        $co_reason_note = $coReasonNote;
        $this->session->set_userdata(array('Co_notice' => $co_order));
        $case_no = $this->input->post('case_no');
        $dc_code = $this->input->post('dc_code');
        
        $order_type = $this->input->post('order_type');
        $user_code=$this->session->userdata('user_code');
        $coname=$this->utilityclass->getSelectedCOName($dist_code,$subdiv_code,$cir_code,$user_code);
        $this->session->set_userdata(array('case_no' => $case_no));
        
        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' "
                . "and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row();
        
        $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,date_entry,add_off_name,next_date_of_hearing "
                . "from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row_array();
        
        $proceeding = $this->db->query("select count(proceeding_id) as proceed from    petition_proceeding where case_no = '$case_no' limit 1")->result();
        $proceeding_id = $proceeding[0]->proceed + 1;
        
        $date_entry = date('Y-m-d G:i:s');
        
        if($order_type == 're_lm_note'){
            $co_order = $co_reason_note;
        }
        $proceeding_data = array(
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => $hearing_date,
            'co_order' => $co_order,
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
        //var_dump($proceeding_data);
        
        if ($order_type == 'finalhukum') {
            
            $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from    petition_dag_details where "
                    . "dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and "
                    . "lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' "
                    . "and petition_no='$petition_basic->petition_no'")->row_array();
            $m_dag_area_lc = $landdetails['m_dag_area_lc'];
            $m_dag_area_lc = round($m_dag_area_lc);
            $data['display'] = array(
                'date' => date('Y-m-d G:i:s'),
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
            
            $order_type = $this->db->query("select * from    master_office_mut_type where order_type_code ='$petition_basic->mut_type'")->row();
            $lm_premium = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
                . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and "
                . "mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and co_reject is NULL order by note_no desc limit 1")->row();
        
            $name_of_lm = $this->db->query("Select * from    lm_code where lm_code = '$lm_premium->lm_code' and dist_code='$petition_basic->dist_code' "
                    . "and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and mouza_pargona_code='$petition_basic->mouza_pargona_code'")->row();
            $name_of_lm = $name_of_lm->lm_name;
            
            $skname = $this->db->query("select * from    users where user_code='$lm_premium->user_code'  and dist_code='$petition_basic->dist_code' "
                    . "and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code'")->row();
            $sk_name = $skname->username;
            $data['display'] = array(
                'date' => date('Y-m-d G:i:s'),
                'proceeding_id' => $proceeding_id,
                'case_no' => $case_no,
                'order_type' => $order_type->order_type,
                'co_name' => $coname->username,
                'co_order_date' => date('Y-m-d'),
                'sk_note_date' => $lm_premium->sk_note_date,
                'lm_note_date' => $lm_premium->lm_sign_date,
                'lm_name' => $name_of_lm,
                'sk_name' => $sk_name,
                'co_code' => $petition_basic->add_off_desig,
                'lm_code' => $lm_premium->lm_code,
                'sk_code' => $lm_premium->user_code
            );
            
            //$this->load->helper('html');
            //$this->load->view('../views/header');
            //$this->load->view('../views/co_office_conversion/Second_Proceeding_2', $data);
            //$this->load->view('../views/footer');
            if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
            {
                $data['ulpin'] = $this->input->post('ulpin', true);
                $data['chain_revenue'] = $this->input->post('chain_revenue', true);
                $data['chain_local_tax'] = $this->input->post('chain_local_tax', true);
                $data['old_ulpin'] = $this->input->post('old_ulpin', true);
                if (!isset($data['old_ulpin']))
                    $data['old_ulpin'] = "";
            }



            $data['_view'] = 'co_office_conversion/Second_Proceeding_2';
            $this->load->view('layouts/main',$data);
            
        } elseif ($order_type == 'forwardtodc') {
            
            $dc_name = $this->db->query("Select users.username, loginuser_table.user_code, users.user_desig_code from  users, loginuser_table where users.dist_code = loginuser_table.dist_code "
                    . "and users.user_code = loginuser_table.user_code and users.user_code = '$dc_code' and users.dist_code='$petition_basic->dist_code' and "
                    . "users.subdiv_code='00' and users.cir_code='00' and loginuser_table.dis_enb_option = 'E' and loginuser_table.priv = 'adm'")->row();
            
            $this->db->trans_begin();

            $this->db->query("UPDATE  Petition_Basic SET add_off_desig = '$dc_name->user_desig_code', add_off_name = '$dc_name->username', status='P', co_user_code = '$dc_name->user_code' WHERE case_no = '$case_no' and "
            . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
            . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'");

            if ($this->db->affected_rows() == 0) {
                $this->db->trans_rollback();
                log_message('error', '#ERRCONV053: Updation failed in Petition_Basic Case No ' . $case_no);
                $data = array(
                    'error' => "#ERRCONV053: Registration of Petition basic failed for case no : " . $case_no,
                );
                echo json_encode($data);
                return false;
            }
            
            
            $insert_pp2 = $this->db->insert("petition_proceeding", $proceeding_data);
            if($insert_pp2 != 1){
                $this->db->trans_rollback();
                log_message('error', '#ERRCONV054: Insertion failed in petition_proceeding for case no :'. $case_no);
                $json = [
                    'message'=>"#ERRCONV054: Failed to in Proceeding for Case No : ".$case_no
                ];
                echo json_encode($json);
                return false;
            }


            if ($this->db->trans_status() == false) {
                $this->db->trans_rollback();
                $data = array(
                    'error' => "Error in submitting. Please try Again",
                );
                echo json_encode($data);
                return false;
            }
            else
            {

                ////////////////////////////////////////
                $penUser='DC';
                $rmrk='Forwarded By CO';
                $this->DashboardData($case_no,$penUser,$rmrk);
                $status='M';
                $task='CO';
                $pen='DC';
                $case=$case_no;
                
                $rtps_status = $this->basundharamodel->postApiBasundharaSec($case,$rmrk,$status,$task,$pen);
                //var_dump($rtps_status);
                if (trim($rtps_status) =="n") {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error #ERRAPP0012: Settlement Application not submitted case no # $case_no");
                    redirect(base_url() . "index.php/home");
                } else {
                    $this->db->trans_commit();
                }
                ////////////////////////////////////////

                $this->session->set_flashdata('message', "Case no # $case_no has been forwarded to Deputy Commissioner");
                redirect(base_url() . "index.php/home");
            }
            
        } elseif ($order_type == 'continuehearing') {
            
            $this->db->trans_begin();

            $this->db->query("UPDATE  petition_basic SET next_date_of_hearing = '$hearing_date' WHERE case_no = '$case_no' and "
                . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
                . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'");

            if ($this->db->affected_rows() == 0) {
                $this->db->trans_rollback();
                log_message('error', '#ERRCONV055: Updation failed in Petition_Basic Case No ' . $case_no);
                $data = array(
                    'error' => "#ERRCONV055: Registration of Petition basic failed for case no : " . $case_no,
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
                ////////////////////////////////////////
                $penUser='AST';
                $rmrk='Report given by SK';
                $this->DashboardData($case_no,$penUser,$rmrk);
                $status='M';
                $task='CO';
                $pen='AST';
                $case=$case_no;
                 
                $rtps_status = $this->basundharamodel->postApiBasundharaSec($case,$rmrk,$status,$task,$pen);
                //var_dump($rtps_status);
                if (trim($rtps_status) =="n") {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error #ERRAPP0013: Settlement Application not submitted case no # $case_no");
                    redirect(base_url() . "index.php/home");
                } else {
                    $this->db->trans_commit();
                }
                ////////////////////////////////////////
                
                redirect(base_url() . "index.php/home");
            }
            
        } elseif ($order_type == 're_lm_note') {
            
            $this->db->trans_begin();
            $this->db->query("UPDATE  petition_basic SET lm_note_yn = NULL , lm_note_date = NULL, proceeding_yn = NULL WHERE case_no = '$case_no' and "
                . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
                . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'");

            if ($this->db->affected_rows() == 0) {
                $this->db->trans_rollback();
                log_message('error', '#ERRCONV056: Updation failed in Petition_Basic Case No ' . $case_no);
                $data = array(
                    'error' => "#ERRCONV056: Registration of Petition basic failed for case no : " . $case_no,
                );
                echo json_encode($data);
                return false;
            }

            $this->db->query("UPDATE  petition_lm_note SET co_reject = 'Y' where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
                . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' "
                . "and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'");

            
            if ($this->db->affected_rows() == 0) {
                $this->db->trans_rollback();
                log_message('error', '#ERRCONV057: Updation failed in petition_lm_note Case No ' . $case_no);
                $data = array(
                    'error' => "#ERRCONV057: Registration of Petition lm note failed for case no : " . $case_no,
                );
                echo json_encode($data);
                return false;
            }

            
            $insert_pp3 = $this->db->insert("petition_proceeding", $proceeding_data);
            if($insert_pp3 != 1){
                $this->db->trans_rollback();
                log_message('error', '#ERRCONV051: Insertion failed in petition_proceeding for case no :'. $case_no);
                $json = [
                    'message'=>"#ERRCONV051: Failed to in Proceeding for Case No : ".$case_no
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
            
                ////////////////////////////////////////
                $penUser='LM';
                $rmrk='Forwarded by CO';
                $this->DashboardData($case_no,$penUser,$rmrk);
                $status='M';
                $task='CO';
                $pen='LM';
                $case=$case_no;
                
                $rtps_status = $this->basundharamodel->postApiBasundharaSec($case,$rmrk,$status,$task,$pen);
                //var_dump($rtps_status);
                if (trim($rtps_status) =="n") {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error #ERRAPP0014: Settlement Application not submitted case no # $case_no");
                    redirect(base_url() . "index.php/home");
                } else {
                    $this->db->trans_commit();
                }
                ////////////////////////////////////////
                $this->session->set_flashdata('message', "Request To Reserve Lot Mondals Note for Case no # $case_no");
                redirect(base_url() . "index.php/home");
            }
            
        } elseif ($order_type == 'prepare_premium') {
            
            $this->db->trans_begin();
            $this->db->query("UPDATE  petition_basic SET proceeding_yn = NULL, co_order_conv_premium = 'Y', co_order_conv_date = '$date_entry', co_order_conv_notice = 'Y' "
                . "WHERE case_no = '$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code = '$mouza_pargona_code' and "
                . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'");

            if ($this->db->affected_rows() == 0) {
                $this->db->trans_rollback();
                log_message('error', '#ERRCONV058: Updation failed in petition_basic Case No ' . $case_no);
                $data = array(
                    'error' => "#ERRCONV058: Registration of Petition basic for case no : " . $case_no,
                );
                echo json_encode($data);
                return false;
            }
            
            
            $insert_pp4 = $this->db->insert("petition_proceeding", $proceeding_data);
            if($insert_pp4 != 1){
                $this->db->trans_rollback();
                log_message('error', '#ERRCONV059: Insertion failed in petition_proceeding for case no :'. $case_no);
                $json = [
                    'message'=>"#ERRCONV059: Failed to in Proceeding for Case No : ".$case_no
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
                ////////////////////////////////////////
                $penUser='AST';
                $rmrk='Notice for premium';
                $this->DashboardData($case_no,$penUser,$rmrk);
                $status='M';
                $task='CO';
                $pen='AST';
                $case=$case_no;
                
                $rtps_status = $this->basundharamodel->postApiBasundharaSec($case,$rmrk,$status,$task,$pen);
                //var_dump($rtps_status);
                if (trim($rtps_status) =="n") {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error #ERRAPP0015: Settlement Application not submitted case no # $case_no");
                    redirect(base_url() . "index.php/home");
                } else {
                    $this->db->trans_commit();
                }
                ///////////////////////////////////////
                $this->session->set_flashdata('message', "Notice for Premium Requested on Conversion case no # $case_no");
                redirect(base_url() . "index.php/home");
            }
            
        } else {
            
            $this->db->trans_begin();
            $proceeding_data_end = array(
                'case_no' => $case_no,
                'proceeding_id' => $proceeding_id,
                'date_of_hearing' => $hearing_date,
                'co_order' => $co_order,
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
            
            $insert_pp5 = $this->db->insert("petition_proceeding", $proceeding_data_end);
            if($insert_pp5 != 1){
                $this->db->trans_rollback();
                log_message('error', '#ERRCONV060: Insertion failed in petition_proceeding for case no :'. $case_no);
                $json = [
                    'message'=>"#ERRCONV060: Failed to in Proceeding for Case No : ".$case_no
                ];
                echo json_encode($json);
                return false;
            }

            $this->db->query("UPDATE  petition_basic SET proceeding_yn = 'y' , status = 'D' WHERE case_no = '$case_no' and "
                    . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
                    . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'");

            if ($this->db->affected_rows() == 0) {
                $this->db->trans_rollback();
                log_message('error', '#ERRCONV061: Updation failed in petition_basic Case No ' . $case_no);
                $data = array(
                    'error' => "#ERRCONV061: Registration of Petition basic for case no : " . $case_no,
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
    
    public function RejectedSecondProceeding() {
        $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');
        $this->session->set_userdata(array('mouza_pargona_code1' => $mouza_pargona_code));
        $this->session->set_userdata(array('lot_no1' => $lot_no));
        $this->session->set_userdata(array('vill_townprt_code1' => $vill_townprt_code));
        $data = array();
        $case_no = $this->input->get('case_no');
        $data['pb']=$petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' "
                . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
                . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code' ")->row();

        $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,date_entry,add_off_name,next_date_of_hearing,sk_comment"
                        . " from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
                . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row_array();

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
                . "where order_type_code='$convertion_code'")->row()->order_type;

        $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from    petition_dag_details where dist_code='$petition_basic->dist_code' "
                . "and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' "
                . "and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'")->row_array();

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

        $pattadardetails = "select pdar_name,pdar_guardian,pdar_rel_guar,pdar_add1,pdar_add2 from    petitioner_part where dist_code='$petition_basic->dist_code' and "
                . "subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and "
                . "vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and "
                . "petition_no='$petition_basic->petition_no' and dag_no='$landdetails[dag_no]' and TRIM(patta_no)=trim('$landdetails[patta_no]') and "
                . "patta_type_code= '$landdetails[patta_type_code]'";
        $data['pattadar'] = $this->db->query($pattadardetails)->result();
        $data['p_in_order'] = $this->db->query($pattadardetails)->result();
        $lm_details = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
                . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' "
                . "and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' order by note_no desc limit 1")->row_array();

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
                'sk_name' => $lm_details['user_code']
            );
        }
        $namelm = $this->db->query("select * from    lm_code where lm_code = '" . $lm_details['lm_code'] . "'  and dist_code = '" . $location['dist_code'] . "' and subdiv_code = '" . $location['subdiv_code'] . "' and cir_code = '" . $location['cir_code'] . "' and mouza_pargona_code = '" . $location['mouza_pargona_code'] . "' and lot_no = '" . $location['lot_no'] . "' ")->row();
        //echo " select * from    lm_code where lm_code = '".$lm_details['lm_code']."'  and dist_code = '".$location['dist_code']."' and subdiv_code = '".$location['subdiv_code']."' and cir_code = '".$location['cir_code']."' and mouza_pargona_code = '".$location['mouza_pargona_code']."' and lot_no = '".$location['lot_no']."' ";
        $data['lm_name'] = $namelm->lm_name;
        $skname = $this->db->query("select * from users where user_code='" . $lm_details['user_code'] . "'  and dist_code = '" . $lm_details['dist_code'] . "' and subdiv_code = '" . $lm_details['subdiv_code'] . "' and cir_code = '" . $lm_details['cir_code'] . "' ")->row();
        $data['sk_skname'] = $skname->username;

        $query = "select * from    petition_proceeding where case_no = '$case_no' order by proceeding_id";
        $data['cases'] = $this->db->query($query)->result();
        
        $dc_adc_order = "select * from    petition_proceeding_dc_adc where case_no = '$case_no' order by proceeding_id";
        $data['dc_adc_order'] = $this->db->query($dc_adc_order)->result();

        $data['lm_details_final'] = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' order by note_no desc limit 1")->result();
        //echo "Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'";
        $data['premium'] = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and co_reject is NULL ORDER BY note_no DESC LIMIT 1")->result();

        $data['dc_adc']=$this->db->query("Select users.username as username, users.user_desig_code as user_desig_code, loginuser_table.user_code as user_code from    users, "
                . "loginuser_table where users.dist_code = loginuser_table.dist_code "
                . "and users.user_code = loginuser_table.user_code and users.user_desig_code like '%DC' and users.dist_code='$petition_basic->dist_code' and "
                . "users.subdiv_code='00' and users.cir_code='00' and loginuser_table.dis_enb_option = 'E' and loginuser_table.priv = 'adm'")->result();
        
        $data['_view'] = 'co_office_conversion/rejected_Second_Proceeding';
        $this->load->view('layouts/main',$data);
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/co_office_conversion/rejected_Second_Proceeding', $data);
        // $this->load->view('../views/footer');
    }
    
    public function Regenerate_after_reject() {
        //form validation
        $formValidation = $this->FormValidationModel->formValidationForPost($_POST, [
            'case_no'=>'Case No.|required|case_no',
            'proceeding_id'=>'Proceeding Id|required|digit',
            'hearing_date'=>'Hearing Date|required|date',
            'order_type'=>'Order Type|required'
        ]);
        if($formValidation['status'] == 'n') {
            //ERRCONVCORVRT0001
            log_message('error', 'Message: '. $formValidation['message'] .', Data: '. json_encode($formValidation['data']) .'. Error: ERRCONVCORVRT0001');
            $this->session->set_flashdata('message', $formValidation['message'] .' Error: ERRCONVCORVRT0001');
            redirect(base_url('index.php/COconversionPartha/GoToCO?pro=5'));
        }
        
        //syntax validation
        $note_on_order = $_POST['note_on_order'];
        $_POST['note_on_order'] = preg_replace('/\xc2\xa0/', '', $note_on_order);
        $requestResponse = checkRequestSpecChar($_POST);
        if($requestResponse['status'] == 'n') {
            //ERRCONVCORVRT0002
            log_message('error', $requestResponse['messages'] . '. Error: ERRCONVCORVRT0002');
            $this->session->set_flashdata('message', 'Contains Illegal parameter values. Error: ERRCONVCORVRT0002');
            redirect(base_url('index.php/COconversionPartha/GoToCO?pro=5'));
        }

        //malicious query validation
        $validResponse = checkRequestValidQuery($_POST);
        if($validResponse['status'] == 'n') {
            //ERRCONVCORVRT0003
            log_message('error', $validResponse['messages'] . '. Error: ERRCONVCORVRT0003');
            $this->session->set_flashdata('message', 'Contains Malicious parameter values. Error: ERRCONVCORVRT0003');
            redirect(base_url('index.php/COconversionPartha/GoToCO?pro=5'));
        }

        //authorization
        $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'CO', $_POST['case_no'], CONV_CO_REVERT);
        if($authorization['status'] == 'n') {
            //ERRCONVCORVRT0004
            log_message('error', $authorization['messages'] . '. Error: ERRCONVCORVRT0004');
            $this->session->set_flashdata('message', $authorization['messages'].'. Error: ERRCONVCORVRT0004');
            redirect(base_url('index.php/home'));
        }
        // echo '<pre>';
        // var_dump($_POST);
        // die();
        $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code1');
        $lot_no = $this->session->userdata('lot_no1');
        $vill_townprt_code = $this->session->userdata('vill_townprt_code1');
        $case_no = $this->input->post('case_no');
        $proceedings = $this->input->post('proceeding_id');
        // $action_note = $this->input->post('note_on_order');
        $action_note = $note_on_order;
        $action_note = str_replace("'", '', $action_note);
        $user_code = $this->session->userdata('user_code');
        $hearing_date = date('Y-m-d', strtotime($this->input->post('hearing_date')));
        $re_lm_note = $this->input->post('re_lm_note');
        $order_type = $this->input->post('order_type');
        $dc_code = $this->input->post('dc_code');
        
        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' "
                . "and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row();
        
        $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,date_entry,add_off_name,next_date_of_hearing "
                . "from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row_array();
        
        
        $proceeding = $this->db->query("select count(proceeding_id) as proceed from    petition_proceeding where case_no = '$case_no' limit 1")->result();
        $proceeding_id = $proceeding[0]->proceed + 1;
        $date_entry = date('Y-m-d G:i:s');
        $proceeding_data = array(
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => $hearing_date,
            'co_order' => $action_note,
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
        
        $this->db->trans_begin();
        //newly added by hridayjit
        $ast_info = $this->db->query("SELECT users.username, loginuser_table.user_code, users.user_desig_code FROM users, loginuser_table WHERE users.dist_code = loginuser_table.dist_code AND users.subdiv_code = loginuser_table.subdiv_code AND users.cir_code = loginuser_table.cir_code AND users.user_code = loginuser_table.user_code AND users.user_desig_code = 'AST' AND users.dist_code='$dist_code' AND users.subdiv_code='$subdiv_code' AND users.cir_code='$cir_code' AND loginuser_table.dis_enb_option = 'E' AND loginuser_table.priv = 'mut' ORDER BY loginuser_table.date_of_creation DESC LIMIT 1")->row();

        $update = "UPDATE  petition_basic SET dept_note_yn = NULL, dept_order_no = NULL, co_order_conv_date = NULL, co_order_conv_premium = NULL, user_code = '$ast_info->user_code', trans_code = 'F', bo_note_yn = NULL, bo_note_date = NULL, bo_notice_gen = NULL, lm_note_yn = NULL , lm_note_date = NULL, proceeding_yn = NULL, sk_comment = NULL, status = 'P' WHERE case_no = '$case_no' and "
                    . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
                    . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'";
        $this->db->query($update);
        if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            log_message('error', '#ERRCONV062: Updation failed in petition_basic Case No ' . $case_no);
            $data = array(
                'error' => "#ERRCONV062: Registration of Petition basic for case no : " . $case_no,
            );
            echo json_encode($data);
            return false;
        }

        $update1 = "UPDATE  petition_lm_note SET co_reject = 'Y' where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
                . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' "
                . "and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'";
        $this->db->query($update1);
        if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            log_message('error', '#ERRCONV063: Updation failed in petition_lm_note Case No ' . $case_no);
            $data = array(
                'error' => "#ERRCONV063: Registration of Petition lm note for case no : " . $case_no,
            );
            echo json_encode($data);
            return false;
        }

        // $this->db->insert("petition_proceeding", $proceeding_data);
        $insert_pp5 = $this->db->insert("petition_proceeding", $proceeding_data);
        if($insert_pp5 != 1){
            $this->db->trans_rollback();
            log_message('error', '#ERRCONV064: Insertion failed in petition_proceeding for case no :'. $case_no);
            $json = [
                'message'=>"#ERRCONV064: Failed to in Proceeding for Case No : ".$case_no
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
            $this->session->set_flashdata('message', "Request To Reserve Lot Mondals Note for Case no # $case_no");
            redirect(base_url() . "index.php/home");
        }
    }
    
    public function ThirdProceeding() {
        $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $case_no = $this->session->userdata('case_no');
        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' "
                        . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row();
        $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,date_entry,add_off_name,next_date_of_hearing"
                        . " from    petition_basic where case_no='$case_no'")->row_array();

        $proceeding = $this->db->query("select count(proceeding_id) as proceed from    petition_proceeding where case_no = '$case_no' limit 1")->result();
        $proceeding_id = $proceeding[0]->proceed + 1;
        $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from    petition_dag_details where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'")->row_array();
        $order_type = $this->db->query("select * from    master_office_mut_type where order_type_code ='$petition_basic->mut_type'")->row();

        $lm_premium = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and co_reject is NULL order by note_no desc limit 1")->row();
        $q = "Select * from    lm_code where lm_code = '$lm_premium->lm_code'";

        $name_of_lm = $this->db->query("Select * from    lm_code where lm_code = '$lm_premium->lm_code' and dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no'")->row();
        $name_of_lm = $name_of_lm->lm_name;
        $skname = $this->db->query("select * from    users where user_code='$lm_premium->user_code'  and dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code'")->row();
        $sk_name = $skname->username;
        $data['display'] = array(
            'date' => date('Y-m-d G:i:s'),
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
            // $this->load->view('../views/co_office_conversion/Second_Proceeding_2', $data);
            // $this->load->view('../views/footer');
            $data['_view'] = 'co_office_conversion/Second_Proceeding_2';
            $this->load->view('layouts/main',$data);
        }
        if (isset($_POST['submit1'])) {
            $this->session->set_flashdata('message', "Order Cancelled for Conversion case no # $case_no");
            redirect(base_url() . "index.php/home");
        }
    }

    public function FourthProceeding() {
       // $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $case_no = $this->session->userdata('case_no');
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
        $case_no=$this->input->post('case_no');
        $this->session->set_userdata(array('order_date' => $order_date, 'lm_sign' => $lm_sign, 'order_type' => $order_type, 'lm_sign_date' => $lm_sign_date, 'order_passed_by' => $order_passed_by, 'sk_sign' => $sk_sign, 'sk_sign_date' => $sk_sign_date, 'co_order_date' => $co_order_date, 'co_sign' => $co_sign, 'co_code' => $co_code, 'lm_code' => $lm_code, 'sk_code' => $sk_code));

        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' "
                        . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row();
       
        $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,date_entry,add_off_name,next_date_of_hearing"
                        . " from    petition_basic where case_no='$case_no'")->row_array();

        $locationData = array(
            'dist_code' => $location['dist_code'],
            'subdiv_code' => $location['subdiv_code'],
            'cir_code' => $location['cir_code'],
            'lot_no' => $location['lot_no'],
            'vill_code' => $location['vill_townprt_code'],
            'mouza_pargona_code' => $location['mouza_pargona_code']
        );
        $this->session->set_userdata($locationData);
        
        $proceeding = $this->db->query("select count(proceeding_id) as proceed from    petition_proceeding where case_no = '$case_no' limit 1")->result();
        $proceeding_id = $proceeding[0]->proceed + 1;
        $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from    petition_dag_details where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'")->row_array();
        $order_type = $this->db->query("select * from    master_office_mut_type where order_type_code ='$petition_basic->mut_type'")->row();

        $lm_premium = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and co_reject is NULL order by note_no desc limit 1")->row();

        $data['display'] = array(
            'date' => date('Y-m-d G:i:s'),
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

        $this->session->set_userdata(array('proceeding_id' => $proceeding_id, 'patta_no' => $patta_no, 'patta_type' => $patta_type, 'type_of_premium' => $type_of_premium, 'premium_reciept' => $premium_reciept, 'premium_amount' => $premium_amount, 'bigha' => $bigha, 'kotha' => $kotha, 'lessa' => $lessa,'case_no'=>$case_no));

        if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {
            // property chain data
            $ulpin = $this->input->post('ulpin', true);
            $chain_revenue = $this->input->post('chain_revenue', true);
            $chain_local_tax = $this->input->post('chain_local_tax', true);
            $old_ulpin = $this->input->post('old_ulpin', true);
            if (!isset($old_ulpin))
                $old_ulpin = "";

            redirect(base_url() . "index.php/COconversionPartha/TestFinalForm?ulpin=" . $ulpin . "&chain_revenue=" . $chain_revenue . "&chain_local_tax=" . $chain_local_tax . "&old_ulpin=" . $old_ulpin);
        }

        redirect(base_url() . "index.php/COconversionPartha/TestFinalForm");
    }

    public function FifthProceeding() {
        $db=  $this->session->userdata('db');
        $dag_no = $this->input->post('dag_no');
        $this->session->set_userdata(array('dag_no' => $dag_no));
        redirect(base_url() . "index.php/COconversionPartha/TestFinalForm");
    }

    public function TestFinalForm() {
      //$db=  $this->session->userdata('db');
        //var_dump($this->session->all_userdata());
        $case_no = $this->session->userdata('case_no');
        $proceeding_id = $this->session->userdata('proceeding_id');
        $patta_no = trim($this->session->userdata('patta_no'));
        $dag = $this->session->userdata('dag_no');
        $patta_type = $this->session->userdata('patta_type');
        $type_of_premium = $this->session->userdata('type_of_premium');
        $premium_reciept = $this->session->userdata('premium_reciept');
        $premium_amount = $this->session->userdata('premium_amount');
        $bigha = $this->session->userdata('bigha');
        $kotha = $this->session->userdata('kotha');
        $lessa = $this->session->userdata('lessa');
        $patta_name = $this->db->query("select patta_type from    patta_code where type_code='$patta_type'")->row();

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_code');

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
            $cal_new_rev = round($onelessa * $remaining_lessa, 2);
            $new_dag_local_tax = round($cal_new_rev / 4, 2);
        }

        $check_dag_no = "Select dag_no from    chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
                . "and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' order by dag_no_int asc";
        
        $data['check_dag_no'] = $this->db->query($check_dag_no)->result();

        $check_patta_no = "Select distinct cast(patta_no as varchar) as patta_no from    chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
                . "and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' and TRIM(patta_no)!='' and TRIM(patta_no)!='.' order by patta_no asc";
        
        $data['check_patta_no'] = $this->db->query($check_patta_no)->result();

        $sql = "Select dag_no from    chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
                . "and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' and patta_type_code= '$patta_type'";
        
        $dag_no = $data['oldDag'] = $this->db->query($sql)->result();
        
        
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
         $p=(int)($p);
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
        
        $data['pattadar_details'] = $this->db->query("Select * from    petitioner_part where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
                        . "and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' and patta_type_code= '$patta_type' and dag_no = '$dag' and TRIM(patta_no) = trim('$patta_no') and petition_no = '$petition_basic->petition_no'")->result();

        
        $this->load->model('patta/PattaModel');
        //$this->load->view('../views/header');
        //$this->load->view('../views/co_office_conversion/Test_Proceeding_4', $data);
       //$this->load->view('../views/footer');
        if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {
            $data['ulpin'] = $this->input->get('ulpin', true);
            $data['chain_revenue'] = $this->input->get('chain_revenue', true);
            $data['chain_local_tax'] = $this->input->get('chain_local_tax', true);
            $data['old_ulpin'] = $this->input->get('old_ulpin', true);
            if (!isset($data['old_ulpin']))
                $data['old_ulpin'] = "";
        }

        $data['_view'] = 'co_office_conversion/Test_Proceeding_4';
        $this->load->view('layouts/main',$data);
    }

    public function FinalSaveTest() {
        $db=  $this->session->userdata('db');
        $this->db->trans_begin();

        $data = array();
        $conditions = $this->utilityclass->getLocationfromSession();
        $dist_code = $conditions['dist_code'];
        $subdiv_code = $conditions['subdiv_code'];
        $cir_code = $conditions['cir_code'];
        $mouza_pargona_code = $conditions['mouza_pargona_code'];
        $vill_townprt_code = $conditions['vill_townprt_code'];
        $lot_no = $conditions['lot_no'];

        $case_no = $this->session->userdata('case_no');
        $proceeding_id = $this->session->userdata('proceeding_id');

        $type_of_premium = $this->session->userdata('type_of_premium');
        $premium_reciept = $this->session->userdata('premium_reciept');
        $premium_amount = $this->session->userdata('premium_amount');
        $bigha = $this->input->post('bigha');
        $kotha = $this->input->post('kotha');
        $lessa = $this->input->post('lessa');
        $order_date = $this->session->userdata('order_date');

        $patta_no = trim($this->session->userdata('patta_no'));
        $dag = $this->session->userdata('dag_no');
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
        

        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' "
                        . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row();
        $petition_no = $petition_basic->petition_no;
        $type_of_conversion = $petition_basic->trans_code;
        
        $year_no = $petition_basic->year_no;
        $pattadar_details = $this->db->query("Select * from    petitioner_part where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
                        . "and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' and patta_type_code= '$patta_type' and dag_no = '$dag' and TRIM(patta_no) = trim('$patta_no') and petition_no = '$petition_no'")->result();

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
        //var_dump($pattadar_details);
        
        foreach ($pattadar_details as $p) {
            $pdar_id = $p->pdar_id;
            $mother_name = $p->pdar_mother;
            $gender = $p->pdar_gender;
            $pdar_rel_guar = $p->pdar_rel_guar;


            $query = "select p.pdar_id,p.pdar_name,p.pdar_father,p.pdar_add1,p.pdar_add2,p.pdar_add3,p.pdar_guard_reln from    chitha_pattadar p join 
                     chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code 
                    and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and
                    p.pdar_id = d.pdar_id and TRIM(p.patta_no) = TRIM(d.patta_no) and p.patta_type_code = d.patta_type_code where 
                    d.dist_code='$dist_code' and d.subdiv_code='$subdiv_code' and d.cir_code='$cir_code' and
                    d.mouza_pargona_code='$mouza_pargona_code' and d.vill_townprt_code='$vill_townprt_code' 
                    and d.lot_no='$lot_no' and d.dag_no='$dag' and TRIM(d.patta_no)=trim('$patta_no') 
                    and d.patta_type_code='$patta_type' and d.pdar_id='$pdar_id'";
            
            $data = $this->db->query($query);
            if($data->num_rows()<=0){
                log_message('error','Error:#CONV00098:'.$this->db->last_query());
                $this->db->trans_rollback();
                redirect(base_url() . "index.php/home");
            }

            $values = array();
            foreach ($data->result() as $value) {
                $relation = $pdar_rel_guar;
                $pdar_add1 = $p->pdar_add1;
                $pdar_add2 = $p->pdar_add2;
                $self_declaration = $p->self_declaration;

                $dec= null;
                if(isset($p->self_declaration) && $p->self_declaration !=null){
                    $dec = $p->self_declaration;
                }
                if($p->auth_type != null){
                    if($p->auth_type=='AADHAAR' && $p->photo == null){
                        $this->db->trans_rollback();
                        log_message('error', '#ERRCONV001:Aadhaar Photo fetching error');
                        redirect(base_url() . "index.php/home");
                    }
                    $auth_type = $p->auth_type;
                    $id_ref_no = $p->id_ref_no;
                    $photo     = $p->photo;
                }else{
                    $auth_type = null;
                    $id_ref_no = null;
                    $photo = null;
                }

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
                    'land_area_k' =>$kotha,
                    'land_area_lc' =>$lessa,
                    'land_area_g'=>'0.0000',
                    'land_area_kr'=>'0',
                    'new_patta_type' => $new_patta_type,
                    'new_patta_no' => trim($sugg_patta_no),
                    'new_dag_no' => $sugg_dag_no,
                    'pdar_id' => $pdar_id, //pattadar id
                    'pdar_strike' => $p->pdar_strike,
                    'ord_onbehalf_guard' => $value->pdar_father, //gurdian name
                    'ord_onbehalf_add1' => $pdar_add1, //add1
                    'ord_onbehalf_add2' => $pdar_add2, //add2
                    'pdar_gender' => $gender,
                    'pdar_mother' => $mother_name,
                    'pdar_guard_reln' => $relation,
                    'self_declaration' => $self_declaration,
                    'auth_type' => $auth_type,
                    'id_ref_no' => $id_ref_no,
                    'photo' => $photo
                );
                
                $insert_rmk_conv = $this->db->insert("t_chitha_rmk_convorder", $chitha_rmk_convorder);//********************
                if($insert_rmk_conv != 1){
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCONV065: Insertion failed in t_chitha_rmk_convorder for case no :'. $case_no);
                    $json = [
                        'message'=>"#ERRCONV065: Failed to in chitha rmk for Case No : ".$case_no
                    ];
                    echo json_encode($json);
                    return false;
                }
            }
        }
        
        $insert_rmk_ord= $this->db->insert("t_chitha_rmk_ordbasic", $chitha_rmk_ordbasic);//********************
        if($insert_rmk_ord != 1){
            $this->db->trans_rollback();
            log_message('error', '#ERRCONV066: Insertion failed in t_chitha_rmk_ordbasic for case no :'. $case_no);
            $json = [
                'message'=>"#ERRCONV066: Failed to in chitha rmk ord for Case No : ".$case_no
            ];
            echo json_encode($json);
            return false;
        }
        
        $proceeding = $this->db->query("select count(proceeding_id) as proceed from    petition_proceeding where case_no = '$case_no' limit 1")->result();
        $proceeding_id = $proceeding[0]->proceed + 1;
        $proceeding_data_end = array(
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => $order_date,
            'co_order' => $this->session->userdata('Co_notice'),
            'note_on_order' => 'Chitha Updated Successfully',
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
            log_message('error', '#ERRCONV059: Insertion failed in petition_proceeding for case no :'. $case_no);
            $json = [
                'message'=>"#ERRCONV059: Failed to in Proceeding for Case No : ".$case_no
            ];
            echo json_encode($json);
            return false;
        }

        $this->db->query("UPDATE  Petition_Basic SET status = 'F' WHERE case_no = '$case_no'");
        if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            log_message('error', '#ERRCONV067: Updation failed in petition_basic Case No ' . $case_no);
            $data = array(
                'error' => "#ERRCONV067: Registration of Petition basic for case no : " . $case_no,
            );
            echo json_encode($data);
            return false;
        }
        ////////

        if ($this->db->trans_status() == false) {
            $this->db->trans_rollback();
            $data = array(
                'error' => "Error in submitting. Please try Again",
            );
        }
        else
        {
            $this->DashboardDataFinal($case_no);
            $rmk="Final Order Passed";
            $status='F';
            $task='CO';
            $pen='NA';
            $case=$case_no;
            
            $rtps_status = $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen); 
            //var_dump($rtps_status);
            if (trim($rtps_status) =="n") {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error #ERRAPP0017: Settlement Application not submitted case no # $case_no");
                redirect(base_url() . "index.php/home");
            } else {
                $this->db->trans_commit();


                $old_patta_type = $patta_type;

                $new_patta_type = $new_patta_type;
                $new_patta_no = $sugg_patta_no;
                $old_patta_no = $old_patta_no;
                $new_dag_no = $sugg_dag_no;
                $old_dag_no = $old_dag_no;
                $new_revenue = $revenue;
                $new_local_tax = $local_tax;
                if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                {
                    $ulpin = $this->input->post('ulpin', true);
                    $chain_revenue = $this->input->post('chain_revenue', true);
                    $chain_local_tax = $this->input->post('chain_local_tax', true);
                    $old_ulpin = $this->input->post('old_ulpin', true);
                    if (!isset($old_ulpin))
                        $old_ulpin = "";

                    redirect(base_url() . "index.php/COconversionPartha/select_full_or_partial?ulpin=" . $ulpin . "&chain_revenue=" . $chain_revenue . "&chain_local_tax=" . $chain_local_tax . "&old_ulpin=" . $old_ulpin . "&old_patta_type=" . $old_patta_type . "&new_patta_type=" . $new_patta_type . "&new_patta_no=" . $new_patta_no . "&old_patta_no=" . $old_patta_no . "&new_patta_no=" . $new_patta_no . "&old_dag_no=" . $old_dag_no . "&new_revenue=" . $new_revenue . "&new_local_tax=" . $new_local_tax . "&new_dag_no=" . $new_dag_no);
                }

                redirect(base_url() . "index.php/COconversionPartha/select_full_or_partial");
            }
            
        }
    }

    public function select_full_or_partial() {
        $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $case_no = $this->session->userdata('case_no');
        $query = "select * from    t_chitha_rmk_ordbasic where ord_no = '$case_no' "
                . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
        $result = $this->db->query($query)->row();

        if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        { 
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
                redirect(base_url() . "index.php/COconversionPartha/updateChithaConversionForFullConversion?ulpin=" . $ulpin . "&chain_revenue=" . $chain_revenue . "&chain_local_tax=" . $chain_local_tax . "&old_ulpin=" . $old_ulpin . "&old_patta_type=" . $old_patta_type . "&new_patta_type=" . $new_patta_type . "&new_patta_no=" . $new_patta_no . "&old_patta_no=" . $old_patta_no . "&new_patta_no=" . $new_patta_no . "&old_dag_no=" . $old_dag_no . "&new_revenue=" . $new_revenue . "&new_local_tax=" . $new_local_tax);
            } else {
                // echo "partial";
                redirect(base_url() . "index.php/COconversionPartha/updateChithaConversionForPartialConversion?ulpin=" . $ulpin . "&chain_revenue=" . $chain_revenue . "&chain_local_tax=" . $chain_local_tax . "&old_ulpin=" . $old_ulpin . "&old_patta_type=" . $old_patta_type . "&new_patta_type=" . $new_patta_type . "&new_patta_no=" . $new_patta_no . "&old_patta_no=" . $old_patta_no . "&new_patta_no=" . $new_patta_no . "&old_dag_no=" . $old_dag_no . "&new_revenue=" . $new_revenue . "&new_local_tax=" . $new_local_tax . "&new_dag_no=" . $new_dag_no);
            }
        }

        if ($result->make_mdb == 'F') {
            // echo "full";
            redirect(base_url() . "index.php/COconversionPartha/updateChithaConversionForFullConversion");
        } else {
            // echo "partial";
            redirect(base_url() . "index.php/COconversionPartha/updateChithaConversionForPartialConversion");
        }
    }

    public function updateChithaConversionForFullConversion() {
      
        $this->db->trans_begin();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $case_no = $this->session->userdata('case_no');
        $this->AgriStackCaseHistory->CreateLogFile($dist_code, $case_no);
        $petition_basic = $this->db->query("select * from petition_basic where case_no='$case_no' "
                        . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row();

        $query = "select * from    t_chitha_rmk_ordbasic where ord_no = '$case_no' and dist_code='$petition_basic->dist_code' and "
                . "subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' "
                . "and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code'";
        $result = $this->db->query($query)->result();
        
        foreach ($result as $order) {
            $query_rmk_hist = "select max(rmk_type_hist_no) as c from    chitha_rmk_gen where "
                    . "dist_code='$order->dist_code' and subdiv_code='$order->subdiv_code' and cir_code='$order->cir_code'"
                    . " and lot_no='$order->lot_no' and mouza_pargona_code='$order->mouza_pargona_code' and "
                    . " vill_townprt_code='$order->vill_townprt_code' and dag_no='$order->dag_no' ";
            
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
            $query = "select distinct on (pdar_id)* from    t_chitha_rmk_convorder where ord_no='$order->ord_no' and iscorrected_inco is null ";
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
                $c->date_entry = date('Y-m-d G:i:s');
                $c->operation = 'E';

                $tstatus1 =$this->db->insert("chitha_rmk_convorder", $c); //**************************
                if ($tstatus1 != 1 )
                {
                   $this->db->trans_rollback();
                   $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#CONCRC001)");
                   log_message("error","#CONCRC001 Insert chitha_rmk_convorder for dist:"
                               .$dist_code.", case: ". $case_no);
                   redirect(base_url() . "index.php/home");
                }

                $d = date('Y-m-d');
                $update_conv_order_q = "update  t_chitha_rmk_convorder set iscorrected_inco='Y',iscorrected_inco_date='$d' "
                        . " where ord_no='$order->ord_no'";
                $this->db->query($update_conv_order_q); //*********************

                if ($this->db->affected_rows() <=0)
                {
                   $this->db->trans_rollback();
                   $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#CONTCRC002)");
                   log_message("error","#CONTCRC002 update t_chitha_rmk_convorder for dist:"
                               .$dist_code.", case: ". $case_no);
                   redirect(base_url() . "index.php/home");
                }

                if($ord->auth_type == 'AADHAAR'){
                    $aadharNo = $ord->id_ref_no;
                    $panNo = null;
                    $photo = $ord->photo;
                }else if($ord->auth_type == 'PAN'){
                    $panNo = $ord->id_ref_no;
                    $aadharNo =null;
                    $photo = null;
                }else{
                    $panNo = null;
                    $aadharNo =null;
                    $photo = null;
                }
                $data = array(
                    'pdar_name' => $ord->ord_onbehalf_of,
                    'pdar_father' => $ord->ord_onbehalf_guard,
                    'patta_no' => trim($ord->new_patta_no),
                    'patta_type_code' => $ord->new_patta_type,
                    'pdar_add1' => $ord->ord_onbehalf_add1,
                    'pdar_add2' => $ord->ord_onbehalf_add2,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d G:i:s'),
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
                    'pdar_guard_reln' => $ord->pdar_guard_reln,
                    'pdar_aadharno' => $aadharNo,
                    'pdar_pan_no' => $panNo,
                    'pdar_photo' => $photo
                );
                $chech_existance=$this->db->query("select count(*) as c from    chitha_pattadar where dist_code = '$ord->dist_code' and subdiv_code = '$ord->subdiv_code' and "
                        . "cir_code = '$ord->cir_code' and mouza_pargona_code = '$ord->mouza_pargona_code' "
                        . "and lot_no = '$ord->lot_no' and vill_townprt_code = '$ord->vill_townprt_code' and pdar_id = '$ord->pdar_id' "
                        . "and TRIM(patta_no) = trim('$ord->new_patta_no') and patta_type_code = '$ord->new_patta_type'")->row()->c;
                
                if($chech_existance == 0)
                {
                    // $tstatus2 = $this->db->insert("chitha_pattadar", $data); //*********************
                    $data['f1_case_no']=$case_no;
                    $tstatus2= $this->Chitha_basic_model->insert_table('chitha_pattadar',$data);
                    if ($tstatus2 !=1)
                      {
                         $this->db->trans_rollback();
                         $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#CONCP003)");
                         log_message("error","#CONCP003 insert chitha_pattadar for dist:"
                                     .$dist_code.", case: ". $case_no);
                         redirect(base_url() . "index.php/home");
                      }
                }else{
                    // $chitha_update_aadhar = "update  chitha_pattadar set pdar_aadharno = '$aadharNo',pdar_pan_no = '$panNo',pdar_photo='$photo'"
                    //         . " where dist_code='$ord->dist_code' and"
                    //         . " subdiv_code='$ord->subdiv_code' and cir_code='$ord->cir_code'"
                    //         . " and lot_no='$ord->lot_no' and mouza_pargona_code='$ord->mouza_pargona_code' and "
                    //         . " vill_townprt_code='$ord->vill_townprt_code' "
                    //         . " and TRIM(patta_no)=trim('$ord->patta_no') and patta_type_code='$ord->patta_type_code'";

                    // $this->db->query($chitha_update_aadhar);  //*********************

                    $table = 'chitha_pattadar';
                    $params = [
                        'pdar_aadharno' => $aadharNo,
                        'pdar_pan_no'   => $panNo,
                        'pdar_photo'    => $photo,
                    ];
                    $where = [
                        'dist_code'          => $ord->dist_code,
                        'subdiv_code'        => $ord->subdiv_code,
                        'cir_code'           => $ord->cir_code,
                        'lot_no'             => $ord->lot_no,
                        'mouza_pargona_code' => $ord->mouza_pargona_code,
                        'vill_townprt_code'  => $ord->vill_townprt_code,
                        'patta_no'           => trim($ord->patta_no),
                        'patta_type_code'    => $ord->patta_type_code,
                    ];
                    $result0 = $this->Chitha_basic_model->update_table($table, $params, $where);
                    if ($result0 <=0)
                      {
                         $this->db->trans_rollback();
                         $this->session->set_flashdata('message', "Error in AadharUpdation. Please try Again. Error Code(#CONCB004)");
                         log_message("error","#CONCB004 update chitha_basic for dist:"
                                     .$dist_code.", case: ". $case_no);
                         redirect(base_url() . "index.php/home");
                      }
                }

                $landArea_query = "select dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr from    chitha_basic"
                        . "  where dist_code='$ord->dist_code' and"
                        . " subdiv_code='$ord->subdiv_code' and cir_code='$ord->cir_code'"
                        . " and lot_no='$ord->lot_no' and mouza_pargona_code='$ord->mouza_pargona_code' and "
                        . " vill_townprt_code='$ord->vill_townprt_code' and dag_no='$ord->dag_no'  "
                        . " and TRIM(patta_no)=trim('$ord->patta_no') and patta_type_code='$ord->patta_type_code'";

                if ($chitha_basic_update == FALSE) {

                    $old_petition_no=$order->petition_no;
                    $landclass_query = "select land_class_code from    petition_lm_note  where dist_code='$ord->dist_code' and"
                            . " subdiv_code='$ord->subdiv_code' and cir_code='$ord->cir_code'"
                            . " and lot_no='$ord->lot_no' and mouza_pargona_code='$ord->mouza_pargona_code' and "
                            . " vill_townprt_code='$ord->vill_townprt_code' and dag_no='$ord->dag_no' "
                            . " and co_reject is null and petition_no=$old_petition_no order by note_no desc limit 1";
                    
                    $landclasscode = $this->db->query($landclass_query);
                    if($landclasscode->num_rows()==0){
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error Found for Landclass. Please try Again. Error Code(#CONCB00400)");
                        log_message("error","#CONCB004 Landclass Missing for dist:"
                                     .$dist_code.", case: ". $case_no);
                        redirect(base_url() . "index.php/home");
                    }
                    $landclasscode=$landclasscode->row()->land_class_code;
                    $user_code = $this->session->userdata('user_code');
                    $date_entry = date('Y-m-d G:i:s');
                    $new_revenue = $order->min_revenue;
                    $dag_local_tax = round($new_revenue / 4, 2);
                    
                    // $chitha_update = "update  chitha_basic set patta_no=trim('$ord->new_patta_no'), old_patta_no=trim('$ord->patta_no'),"
                    //         . "dag_no='$ord->new_dag_no',patta_type_code='$ord->new_patta_type',"
                    //         . "user_code='$user_code', date_entry='$date_entry', operation='E',"
                    //         . "jama_yn=' ', land_class_code='$landclasscode', dag_revenue = '$new_revenue', dag_local_tax = '$dag_local_tax' where dist_code='$ord->dist_code' and"
                    //         . " subdiv_code='$ord->subdiv_code' and cir_code='$ord->cir_code'"
                    //         . " and lot_no='$ord->lot_no' and mouza_pargona_code='$ord->mouza_pargona_code' and "
                    //         . " vill_townprt_code='$ord->vill_townprt_code' and dag_no='$ord->dag_no'  "
                    //         . " and TRIM(patta_no)=trim('$ord->patta_no') and patta_type_code='$ord->patta_type_code'";
                    $table = "chitha_basic";
                    $params = [
                        'patta_no' => trim($ord->new_patta_no),
                        'old_patta_no' => trim($ord->patta_no),
                        'dag_no' => $ord->new_dag_no,
                        'patta_type_code' => $ord->new_patta_type,
                        'user_code' => $user_code,
                        'date_entry' => $date_entry,
                        'operation' => 'E',
                        'jama_yn' => ' ',
                        'land_class_code' => $landclasscode,
                        'dag_revenue' => $new_revenue,
                        'dag_local_tax' => $dag_local_tax
                    ];

                    $where = [
                        'dist_code' => $ord->dist_code,
                        'subdiv_code' => $ord->subdiv_code,
                        'cir_code' => $ord->cir_code,
                        'lot_no' => $ord->lot_no,
                        'mouza_pargona_code' => $ord->mouza_pargona_code,
                        'vill_townprt_code' => $ord->vill_townprt_code,
                        'dag_no' => $ord->dag_no,
                        'patta_no' => trim($ord->patta_no),
                        'patta_type_code' => $ord->patta_type_code
                    ];

                    $result_cb = $this->Chitha_basic_model->update_table($table, $params, $where);

                    // $this->db->query($chitha_update);  //*********************
                    if ($result_cb <=0)
                      {
                         $this->db->trans_rollback();
                         $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#CONCB004)");
                         log_message("error","#CONCB004 update chitha_basic for dist:"
                                     .$dist_code.", case: ". $case_no);
                         redirect(base_url() . "index.php/home");
                      }

                    $chitha_basic_update = TRUE;
                }

                // $update_query = "update  chitha_dag_pattadar set p_flag='1',operation='M' where "
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
                    'pdar_id'            => $ord->pdar_id,
                    'patta_type_code'    => $ord->patta_type_code,
                    'patta_no'           => trim($ord->patta_no),
                ];

                $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                if ($result <=0)
                {
                   $this->db->trans_rollback();
                   $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#CONCDB005)");
                   log_message("error","#CONCDB005 update chitha_dag_pattadar for dist:"
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
                    'date_entry' => date('Y-m-d G:i:s'),
                    'operation' => 'E',
                    'p_flag' => '0',
                );
            //    $tstatus3 = $this->db->insert("chitha_dag_pattadar", $dag_pattadar);  //*********************
               $tstatus3=$this->Chitha_basic_model->insert_table('chitha_dag_pattadar',$dag_pattadar);
               if ($tstatus3 !=1)
                {
                   $this->db->trans_rollback();
                   $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#CONCDB006)");
                   log_message("error","#CONCDB006 insert chitha_dag_pattadar for dist:"
                               .$dist_code.", case: ". $case_no);
                   redirect(base_url() . "index.php/home");
                }
               $jama_patta_no=trim($ord->new_patta_no);
               $jama_patta_type_code=$ord->new_patta_type;
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
            $order->date_entry = date('Y-m-d G:i:s');
            $order->area_left_b = 0;
            $order->area_left_k = 0;
            $order->area_left_lc = 0;
            $order->area_left_g = 0;
            $order->area_left_kr = 0;

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
                'date_entry' => date('Y-m-d G:i:s'),
                'jama_updated' => ' ',
                'new_dag_no' => $order->new_dag_no,
                'patta_no'=>trim($get_patta_no)
            );
            $tstatus4 = $this->db->insert("chitha_rmk_gen", $rmk_gen); //*********************
            if ($tstatus4 !=1)
             {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#CONCRG007)");
                log_message("error","#CONCRG007 insert chitha_rmk_gen for dist:"
                            .$dist_code.", case: ". $case_no);
                redirect(base_url() . "index.php/home");
             }

            $tstatus5 = $this->db->insert("chitha_rmk_ordbasic", $order); //*********************
            if ($tstatus5 !=1)
             {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#CONCROB008)");
                log_message("error","#CONCROB008 insert chitha_rmk_ordbasic for dist:"
                            .$dist_code.", case: ". $case_no);
                redirect(base_url() . "index.php/home");
             }
             
            $d = date('Y-m-d');
            $update_q = "update  t_chitha_rmk_ordbasic set iscorrected_inco='Y',iscorrected_inco_date='$d'"
                    . " where ord_no='$order->ord_no' and dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code'";
            $this->db->query($update_q); //*********************
            if ($this->db->affected_rows() <=0)
             {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#CONTCROB009)");
                log_message("error","#CONTCROB009 update t_chitha_rmk_ordbasic for dist:"
                            .$dist_code.", case: ". $case_no);
                redirect(base_url() . "index.php/home");
             }
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo "Error Occured";
            } else {


                ///////////////////////////////////////////////////////////////////////////
                //////////////////////Property chain code /////////////////////////////////
                ///////////////////////////////////////////////////////////////////////////
                if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
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
                    $property_id_update = $this->utilityclass->generatePropertyId($type, $vill_townprt_code, $old_patta_no, $old_dag_no, $ulpin);

                    // 
                    $pattadar_details = $this->PropChainModel->getPattadars($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $old_patta_no, $old_dag_no);

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
                else
                {
                    $update_chain_api = new \stdClass;
                    $update_chain_api->success = 1;
                }

                if ($update_chain_api->success == 1) {

                    $this->db->trans_commit();
                    $this->AgriStackCaseHistory->CreateLog($dist_code,$case_no);
                    $location = array(
                        'd' =>  $order->dist_code,
                        's' => $order->subdiv_code,
                        'c' => $order->cir_code,
                        'm' => $order->mouza_pargona_code,
                        'l' => $order->lot_no,
                        'v' => $order->vill_townprt_code,
                    );
                    $this->session->set_userdata(array('loc' => $location));
                    $popUpmsg = "<h4>Order for Case No $case_no Successfully Saved.Chitha has been Updated !!! Updating JamaBandi Now<h4>";
                    $msgggg = "<script type='text/javascript'>alert(' " . $popUpmsg . " ');</script>";
                    if(ENABLED_BLOCKCHAIN == 1 && in_array($app->dist_code,json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                    {
                        redirect('JamaBandi/step3/' . $jama_patta_no . '/' . $jama_patta_type_code . '/' .  urlencode(base64_encode($case_no)));
                    }

                    redirect('JamaBandi/step3/' .$jama_patta_no .'/'. $jama_patta_type_code);


                } elseif ($update_chain_api->success == 0 && ENABLED_BLOCKCHAIN == 1) {
                    $this->db->trans_rollback();
                    log_message('error','#ERRORPROPCHAIN2626 : #ERRORPROPCHAIN2626: Error occured. Order not passed for Case No $case_no Not Successfull');
                    $this->session->set_flashdata('message', $update_chain_api->message . ": " . $update_chain_api->error_msg . ". Property Chain updation for Case No $case_no Not Successfull. Error Code(" . $update_chain_api->error_code . ")");
                    redirect(base_url() . "index.php/home");
                } else {
                    log_message('error','#ERRORPROPCHAIN2625 : Error occured. Order not passed for Case No $case_no Not Successfull');
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "#ERRORPROPCHAIN2625 : Error occured. Order not passed for Case No $case_no Not Successfull.");
                }

              //echo $msgggg;
                // $data['_view'] = 'co_office_conversion/test';
                // $this->load->view('layouts/main',$data);
            }
        }
    }

    public function updateChithaConversionForPartialConversion() {
        $db=  $this->session->userdata('db');
        $this->db->trans_begin();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $case_no = $this->session->userdata('case_no');
        $this->AgriStackCaseHistory->CreateLogFile($dist_code, $case_no);
        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' "
                        . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row();


        $query = "select * from    t_chitha_rmk_ordbasic where ord_no = '$case_no' and dist_code='$petition_basic->dist_code' "
                . "and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' "
                . "and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code'";
        $result = $this->db->query($query)->result();
        
        foreach ($result as $order) {
            $query_rmk_hist = "select max(rmk_type_hist_no) as c from    chitha_rmk_gen where "
                    . "dist_code='$order->dist_code' and subdiv_code='$order->subdiv_code' and cir_code='$order->cir_code'"
                    . " and lot_no='$order->lot_no' and mouza_pargona_code='$order->mouza_pargona_code' and "
                    . " vill_townprt_code='$order->vill_townprt_code' and dag_no='$order->dag_no' ";
            
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
                $c->date_entry = date('Y-m-d G:i:s');
                $c->operation = 'E';

                
                $tstatus11 =$this->db->insert("chitha_rmk_convorder", $c); //**************************
                if ($tstatus11 != 1 )
                {
                   $this->db->trans_rollback();
                   $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#CONCRC003)");
                   log_message("error","#CONCRC003 Insert chitha_rmk_convorder for dist:"
                               .$dist_code.", case: ". $case_no);
                   redirect(base_url() . "index.php/home");
                }

                $d = date('Y-m-d');
                $update_conv_order_q = "update  t_chitha_rmk_convorder set iscorrected_inco='Y',iscorrected_inco_date='$d' "
                        . " where ord_no='$order->ord_no'";
                $this->db->query($update_conv_order_q); //*********************

                if ($this->db->affected_rows() <=0)
                {
                   $this->db->trans_rollback();
                   $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#CONTCRC004)");
                   log_message("error","#CONTCRC004 update t_chitha_rmk_convorder for dist:"
                               .$dist_code.", case: ". $case_no);
                   redirect(base_url() . "index.php/home");
                }
                if($ord->auth_type == 'AADHAAR'){
                    $aadharNo = $ord->id_ref_no;
                    $panNo = null;
                    $photo = $ord->photo;
                }else if($ord->auth_type == 'PAN'){
                    $panNo = $ord->id_ref_no;
                    $aadharNo =null;
                    $photo = null;
                }else{
                    $panNo = null;
                    $aadharNo =null;
                    $photo = null;
                }

                $data = array(
                    'pdar_name' => $ord->ord_onbehalf_of,
                    'pdar_father' => $ord->ord_onbehalf_guard,
                    'patta_no' => trim($ord->new_patta_no),
                    'patta_type_code' => $ord->new_patta_type,
                    'pdar_add1' => $ord->ord_onbehalf_add1,
                    'pdar_add2' => $ord->ord_onbehalf_add2,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d G:i:s'),
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
                    'pdar_guard_reln' => $ord->pdar_guard_reln,
                    'pdar_aadharno' => $aadharNo,
                    'pdar_pan_no' => $panNo,
                    'pdar_photo' => $photo
                );
                
                $chech_existance=$this->db->query("select count(*) as c from    chitha_pattadar where dist_code = '$ord->dist_code' and subdiv_code = '$ord->subdiv_code' and "
                        . "cir_code = '$ord->cir_code' and mouza_pargona_code = '$ord->mouza_pargona_code' "
                        . "and lot_no = '$ord->lot_no' and vill_townprt_code = '$ord->vill_townprt_code' and pdar_id = '$ord->pdar_id' "
                        . "and TRIM(patta_no) = trim('$ord->new_patta_no') and patta_type_code = '$ord->new_patta_type'")->row()->c;
                
                if($chech_existance == 0)
                {
                    $data['f1_case_no']=$case_no;
                    // $tstatus21 = $this->db->insert("chitha_pattadar", $data); //*********************
                    $tstatus21= $this->Chitha_basic_model->insert_table('chitha_pattadar',$data);
                    if ($tstatus21 !=1)
                      {
                         $this->db->trans_rollback();
                         $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#CONCP0039)");
                         log_message("error","#CONCP0039 insert chitha_pattadar for dist:"
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
                
                $b = '0';
                $k = '0';
                $lc = '0.00';
                $g = '0.0';
                $kr = '0.0';
                
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
                $lc = fmod($remaining_lessa, 20);
                //var_dump($lc); die();
                $g = 0.0;
                $kr = 0.0;
                //revenue
                $new_revenue = $order->min_revenue;
                $dag_local_tax = round($new_revenue / 4, 2);

                
                if ($chitha_basic_update == FALSE) {
                    // $chitha_update = "update  chitha_basic set dag_status='NR', dag_area_b='$b',dag_area_k='$k',"
                    //         . " dag_area_lc='$lc',dag_area_g='$g',dag_area_kr='$kr',jama_yn='', dag_revenue = '0.0', dag_local_tax = '0.00'  where dist_code='$ord->dist_code' and"
                    //         . " subdiv_code='$ord->subdiv_code' and cir_code='$ord->cir_code'"
                    //         . " and lot_no='$ord->lot_no' and mouza_pargona_code='$ord->mouza_pargona_code' and "
                    //         . " vill_townprt_code='$ord->vill_townprt_code' and dag_no='$ord->dag_no'  "
                    //         . " and TRIM(patta_no)=trim('$ord->patta_no') and patta_type_code='$ord->patta_type_code'";

                    //var_dump($chitha_update);
                    // $this->db->query($chitha_update);  //*********************

                    $table = "chitha_basic";

                    $params = [
                        'dag_status' => 'NR',
                        'dag_area_b' => $b,
                        'dag_area_k' => $k,
                        'dag_area_lc' => $lc,
                        'dag_area_g' => $g,
                        'dag_area_kr' => $kr,
                        'jama_yn' => '',
                        'dag_revenue' => '0.0',
                        'dag_local_tax' => '0.00'
                    ];

                    $where = [
                        'dist_code' => $ord->dist_code,
                        'subdiv_code' => $ord->subdiv_code,
                        'cir_code' => $ord->cir_code,
                        'lot_no' => $ord->lot_no,
                        'mouza_pargona_code' => $ord->mouza_pargona_code,
                        'vill_townprt_code' => $ord->vill_townprt_code,
                        'dag_no' => $ord->dag_no,
                        'patta_no' => trim($ord->patta_no),
                        'patta_type_code' => $ord->patta_type_code
                    ];

                    $result2 = $this->Chitha_basic_model->update_table($table, $params, $where);

                    if ($result2 <=0)
                    {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error in chitha update. Please try Again. Error Code(#CONCB0041)");
                        log_message("error","#CONCB0041 update chitha_basic for dist:"
                                    .$dist_code.", case: ". $case_no. "######".$this->db->last_query());
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
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "could not Process. Error Code(#CONL002)");
                        redirect(base_url() . "index.php/home");
                    }
                    //LM NR Note end

                    $old_petition_no= $order->petition_no;
                    $landclass_query = "select land_class_code from    petition_lm_note  where dist_code='$ord->dist_code' and"
                            . " subdiv_code='$ord->subdiv_code' and cir_code='$ord->cir_code'"
                            . " and lot_no='$ord->lot_no' and mouza_pargona_code='$ord->mouza_pargona_code' and "
                            . " vill_townprt_code='$ord->vill_townprt_code' and dag_no='$ord->dag_no' "
                            . " and co_reject is null and petition_no=$old_petition_no order by note_no desc limit 1";
                    //echo $landclass_query;
                    $landclasscode = $this->db->query($landclass_query);
                    //////////////
                    if($landclasscode->num_rows()==0){
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error Found for Landclass. Please try Again. Error Code(#CONCB00400)");
                        log_message("error","#CONCB004 Landclass Missing for dist:"
                                     .$dist_code.", case: ". $case_no);
                        redirect(base_url() . "index.php/home");
                    }
                    $landclasscode=$landclasscode->row()->land_class_code;

                    $dag_no_int = $ord->new_dag_no . "00";
                    $ulpin = null;
                    $map_for_property = null;
                    
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
                        'date_entry' => date('Y-m-d G:i:s'),
                        'operation' => 'E',
                        'jama_yn' => ' ',
                        'land_class_code' => $landclasscode,
                        
                        
                    );
                    //var_dump($chitha_basic);
                    //=============PROPERTY CHAIN==========//
                    if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                    {
                        $ulpin = $this->input->get('ulpin', true);
                        $map_for_property = 'N';

                        $chitha_basic['old_ulpin'] = $ulpin;
                        // set map_for_property = N as new map is not created
                        $chitha_basic['map_for_property'] = $map_for_property;
                    }
                    //=====================================//
                    
                    // $insert_cb = $this->db->insert("chitha_basic", $chitha_basic);  //*********************
                    $insert_cb = $this->Chitha_basic_model->insert_table('chitha_basic',$chitha_basic);
                    if($insert_cb != 1){
                        
                        log_message('error', '#ERRCONV069: Insertion failed in petition_proceeding for case no :'. $case_no. "######".$this->db->last_query());
                        $this->db->trans_rollback();
                        $json = [
                            'message'=>"#ERRCONV069: Failed to in Proceeding for Case No : ".$case_no
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

                // $update_query = "update  chitha_dag_pattadar set p_flag='$p_flag',operation='M' where "
                //         . "dist_code='$ord->dist_code' and subdiv_code='$ord->subdiv_code' and cir_code='$ord->cir_code'"
                //         . " and lot_no='$ord->lot_no' and mouza_pargona_code='$ord->mouza_pargona_code' and "
                //         . " vill_townprt_code='$ord->vill_townprt_code' and dag_no='$ord->dag_no' "
                //         . " and pdar_id='$ord->pdar_id' and patta_type_code='$ord->patta_type_code'";
                // //var_dump($update_query); die();
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
                    'pdar_id'            => $ord->pdar_id,
                    'patta_type_code'    => $ord->patta_type_code,
                ];

                $result = $this->Chitha_basic_model->update_table($table, $params, $where);


                if ($result == 0) {
                    
                    log_message('error', '#ERRCONV070: Updation failed in chitha_dag_pattadar Case No ' . $case_no. "######".$this->db->last_query());
                    $this->db->trans_rollback();
                    $data = array(
                        'error' => "#ERRCONV070: Update chitha dag for case no : " . $case_no,
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
                    'dag_no' => $ord->new_dag_no,
                    'patta_type_code' => $ord->new_patta_type,
                    'dag_por_b' => $ord->land_area_b,
                    'dag_por_k' => $ord->land_area_k,
                    'dag_por_lc' => $ord->land_area_lc,
                    'dag_por_g' => 0.0,
                    'dag_por_kr' => 0,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d G:i:s'),
                    'operation' => 'E',
                    'p_flag' => '0',
                );
                //var_dump($dag_pattadar);
                
                // $insert_cdp = $this->db->insert("chitha_dag_pattadar", $dag_pattadar);  //*********************
                $insert_cdp=$this->Chitha_basic_model->insert_table('chitha_dag_pattadar',$dag_pattadar);
                if($insert_cdp != 1){
                    
                    log_message('error', '#ERRCONV072: Insertion failed in petition_proceeding for case no :'. $case_no. "######".$this->db->last_query());
                    $this->db->trans_rollback();
                    $json = [
                        'message'=>"#ERRCONV072: Failed to insert for Case No : ".$case_no
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
            $order->date_entry = date('Y-m-d G:i:s');
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
                'date_entry' => date('Y-m-d G:i:s'),
                'jama_updated' => ' ',
                'new_dag_no' => $order->new_dag_no,
                'patta_no'=>trim($get_old_patta_no)
            );
            
            $insert_crg = $this->db->insert("chitha_rmk_gen", $rmk_gen_for_old); //*********************
            if($insert_crg != 1){
                
                log_message('error', '#ERRCONV073: Insertion failed in chitha_rmk_gen for case no :'. $case_no. "######".$this->db->last_query());
                $this->db->trans_rollback();
                $json = [
                    'message'=>"#ERRCONV073: Failed to insert for Case No : ".$case_no
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
                'date_entry' => date('Y-m-d G:i:s'),
                'jama_updated' => ' ',
                'new_dag_no' => null,
                'patta_no'=>trim($get_new_patta_no)
            );
            

            $insert_crg2 = $this->db->insert("chitha_rmk_gen", $rmk_gen_for_new); //*********************
            if($insert_crg2 != 1){
                log_message('error', '#ERRCONV074: Insertion failed in chitha_rmk_gen for case no :'. $case_no. "######".$this->db->last_query());
                $this->db->trans_rollback();
                $json = [
                    'message'=>"#ERRCONV074: Failed to insert for Case No : ".$case_no
                ];
                echo json_encode($json);
                return false;
            }

            

            $insert_cro = $this->db->insert("chitha_rmk_ordbasic", $order); //*********************
            if($insert_cro != 1){
                log_message('error', '#ERRCONV075: Insertion failed in chitha_rmk_ordbasic for case no :'. $case_no. "######".$this->db->last_query());
                $this->db->trans_rollback();
                $json = [
                    'message'=>"#ERRCONV075: Failed to insert for Case No : ".$case_no
                ];
                echo json_encode($json);
                return false;
            }

            unset($order->dag_no);
            $order->dag_no=$order->new_dag_no;
            $newDag=$order->new_dag_no;
            //var_dump($order);
            unset($order->new_dag_no);
            

            $insert_cro2 = $this->db->insert("chitha_rmk_ordbasic", $order);
            if($insert_cro2 != 1){
                log_message('error', '#ERRCONV076: Insertion failed in chitha_rmk_ordbasic for case no :'. $case_no. "######".$this->db->last_query());
                $this->db->trans_rollback();
                $json = [
                    'message'=>"#ERRCONV076: Failed to insert for Case No : ".$case_no
                ];
                echo json_encode($json);
                return false;
            }


            $d = date('Y-m-d');
            $update_q = "update  t_chitha_rmk_ordbasic set iscorrected_inco='Y',iscorrected_inco_date='$d'"
                    . " where ord_no='$order->ord_no' and dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code'";
            $this->db->query($update_q); //*********************

            if ($this->db->affected_rows() == 0) {
                log_message('error', '#ERRCONV077: Updation failed in t_chitha_rmk_ordbasic Case No ' . $case_no. "######".$this->db->last_query());
                $this->db->trans_rollback();
                $data = array(
                    'error' => "#ERRCONV077: Update failed for case no : " . $case_no,
                );
                echo json_encode($data);
                return false;
            }


            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo "Error Occured";
            } else {



                if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                {

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

                    $property_id_update = $this->utilityclass->generatePropertyId($type, $vill_townprt_code, $old_patta_no, $old_dag_no, $ulpin);

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
                else
                {
                    $update_chain = new \stdClass;
                    $update_chain->success == 1;
                }


                $this->db->trans_commit();
                $this->AgriStackCaseHistory->CreateLog($dist_code,$case_no);
                if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                {

                    if($update_chain->success == 1) 
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
                    
                        $this->session->set_flashdata('message', "*Conversion case is successfully passed for Case No $case_no.<br> *Property Chain updation successful.<br>*New asset creation is pending.<br>*New asset will be created when map is generated at Bhunaksha.");

                        redirect(base_url() . 'index.php/PropChainReport/sendPropChain/' . urlencode(base64_encode($case_no)));


                    } 
                    elseif ($update_chain->success == 0 || $update_chain->success == 2) 
                    {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', $update_chain->message . ": " . $update_chain->error_msg . ". Property Chain updation for Case No $case_no Not Successfull. Error Code(" . $update_chain->error_code . ")");
                        log_message('error', $update_chain->message . ": " . $update_chain->error_msg . ". Property Chain updation for Case No $case_no Not Successfull. Error Code(" . $update_chain->error_code . ")");
                        redirect(base_url() . "index.php/home");
                    } 
                    else
                    {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error occured. Property Chain updation and creation for Case No $case_no Not Successfull.");
                        log_message('error', $update_chain->message . ": " . $update_chain->error_msg . ". Property Chain updation for Case No $case_no Not Successfull. Error Code(" . $update_chain->error_code . ")");
                        redirect(base_url() . "index.php/home");
                    }

                }

                // $this->load->view('../views/header');
                // $this->load->view('../views/co_office_conversion/test');
                // $this->load->view('../views/footer');

                $data['_view'] = 'co_office_conversion/test';
                $this->load->view('layouts/main',$data);
            }
        }
    }

    public function getNewDagPattaTypeJSON($type_code) {
        $db=  $this->session->userdata('db');
        $conditions = $this->utilityclass->getLocationfromSession();
        $dist_code = $conditions['dist_code'];
        $subdiv_code = $conditions['subdiv_code'];
        $cir_code = $conditions['cir_code'];
        $mouza_pargona_code = $conditions['mouza_pargona_code'];
        $vill_townprt_code = $conditions['vill_townprt_code'];
        $lot_no = $conditions['lot_no'];
        $sql = "Select dag_no,patta_no from    chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no'";
        
        $dag_no = $data['oldDag'] = $this->db->query($sql)->result();
        
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
            $p=(int)($p);
            if ($newpatta < $p) {
                $newpatta = $p;
            }
        }
        $json[] = array('new_dag' => $newDag + 1, 'new_patta' => $newpatta + 1);
        echo json_encode($json);
    }

    public function ViewActionTakenReport() {

       // $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');
        $data = array();
        $case_no = $this->input->get('case_no');
        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' and dist_code='$dist_code' "
                . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' "
                . "and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row();

        $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,next_date_of_hearing,co_order_conv_date "
                . "from    petition_basic where case_no='$case_no' and dist_code='$dist_code' "
                . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code= '$mouza_pargona_code' "
                . "and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row_array();



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

        $pattadardetails = "select pdar_name,pdar_guardian,pdar_rel_guar,pdar_add1,pdar_add2 from    petitioner_part where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and dag_no='$landdetails[dag_no]' and patta_no='$landdetails[patta_no]' and patta_type_code= '$landdetails[patta_type_code]'";
        $data['p_in_order'] = $this->db->query($pattadardetails)->result();


        $query = "select * from    petition_proceeding where case_no = '$case_no' order by proceeding_id";
        $data['cases'] = $this->db->query($query)->result();


        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/co_office_conversion/action_taken_report', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'co_office_conversion/action_taken_report';
        $this->load->view('layouts/main',$data);
    }
    
    public function chech_dag_patta_exist($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$new_dag_no,$new_patta_no,$new_patta_type){
        
        $db=  $this->session->userdata('db');
      $check_dag = $this->db->query("Select count(*) as cd from    chitha_basic where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and "
                . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code' and dag_no = '$new_dag_no'")->row()->cd;// and patta_type_code = '$new_patta_type'
        
        //if $check_dag is 1 then the dag exist
        echo json_encode($check_dag);
    }
    
    public function chech_case_no_exist(){
        $db=  $this->session->userdata('db');
        $case_no = $_GET['case_no'];
        
        $pieces = explode("/CONV-BL", $case_no);
        $case_nos = $pieces[0]."/CONV-BL";
        
        $check_case = $this->db->query("Select count(*) as cb from    t_chitha_rmk_ordbasic where ord_no = '$case_nos'")->row()->cb; 
        echo json_encode($check_case);
    }

    public function DCPassedSecondProceeding() {
        $db=  $this->session->userdata('db');
        //var_dump($this->session->all_userdata());
        $user_code=$this->session->userdata('user_code');
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
        
        $co = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $cir_code, $user_code);
        $data = array();
        $case_no = $this->input->get('case_no');
        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and "
                . "subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
                . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row();

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
            'co_name' => $co->username
        );
        $convertion_code = CONVERSION_CODE;
        $data['conv_type'] = $this->db->query("select order_type from    master_office_mut_type "
                        . " where order_type_code='$convertion_code'")->row()->order_type;

        $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from    petition_dag_details where dist_code='$petition_basic->dist_code' "
                . "and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' "
                . "and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'")->row_array();

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

        $pattadardetails = "select auth_type,id_ref_no,pdar_name,pdar_guardian,pdar_rel_guar,pdar_add1,pdar_add2, inplace_alongwith from petitioner_part where dist_code='$petition_basic->dist_code' and "
                . "subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and "
                . "vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and "
                . "petition_no='$petition_basic->petition_no' and dag_no='$landdetails[dag_no]' and TRIM(patta_no)=trim('$landdetails[patta_no]') and "
                . "patta_type_code= '$landdetails[patta_type_code]'";
        
        $data['pattadar'] = $this->db->query($pattadardetails)->result();
        $data['p_in_order'] = $this->db->query($pattadardetails)->result();
        
        $lm_details = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
                . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' "
                . "and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' order by note_no desc limit 1 ")->row_array();
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
                'land_trans_yn' => $lm_details['land_trans_yn'],
                'premium_new_yn' => $lm_details['premium_new_yn'],
            );
            if($lm_details['premium_new_yn'] == 1) {
                $data['conversion_premium_area'] = $this->db->query("SELECT * FROM conversion_premium_areas WHERE id=?", [$lm_details['conversion_premium_areas_id']])->row();
                $data['conversion_premium_rate'] = $this->db->query("SELECT * FROM conversion_premium_rates WHERE id=?", [$lm_details['conversion_premium_rates_id']])->row();
            }
        }
        
        $namelm = $this->db->query("select * from    lm_code where lm_code = '" . $lm_details['lm_code'] . "'  and dist_code = '" . $location['dist_code'] . "' and subdiv_code = '" . $location['subdiv_code'] . "' and cir_code = '" . $location['cir_code'] . "' and mouza_pargona_code = '" . $location['mouza_pargona_code'] . "' and lot_no = '" . $location['lot_no'] . "' ")->row();
        $data['lm_name'] = $namelm->lm_name;
        
        $skname = $this->db->query("select * from  users where user_code='" . $lm_details['user_code'] . "'  and dist_code = '" . $lm_details['dist_code'] . "' and subdiv_code = '" . $lm_details['subdiv_code'] . "' and cir_code = '" . $lm_details['cir_code'] . "' ")->row();
        $data['sk_skname'] = $skname->username;

        $query = "select * from    petition_proceeding where case_no = '$case_no' order by proceeding_id";
        $data['cases'] = $this->db->query($query)->result();

        $data['lm_details_final'] = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' ORDER BY note_no DESC LIMIT 1")->result();

        $query = "select * from petition_proceeding where case_no='$case_no' order by proceeding_id desc LIMIT 1";
        $data['cases'] = $this->db->query($query)->result();

        // echo '<pre>';
        // var_dump($data);
        // die();

        if($petition_basic->bo_note_yn == 'Y' && $petition_basic->pay_notice_gen_yn == null) {
            $data['post_url'] = 'index.php/COconversionPartha/Chitha_update_generate';
        }
        else if($petition_basic->bo_note_yn == null && $petition_basic->pay_notice_gen_yn == 'Y') {
            $data['post_url'] = 'index.php/COconversionPartha/Chitha_update_generate_Co';
        }
        
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/co_office_conversion/Pending_chithaUpdate_Second_Proceeding', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'co_office_conversion/Pending_chithaUpdate_Second_Proceeding';
        $this->load->view('layouts/main',$data);
    }

    public function Chitha_update_generate_Co(){
        //form validation
        $formValidation = $this->FormValidationModel->formValidationForPost($_POST, [
            'case_no'=>'Case No.|required|case_no',
            'final_notice'=>'Final CO Notice|required'
        ]);
        if($formValidation['status'] == 'n') {
            //ERRCONVCOUPDCHITHACOEND0001
            log_message('error', 'Message: '. $formValidation['message'] .', Data: '. json_encode($formValidation['data']) .'. Error: ERRCONVCOUPDCHITHACOEND0001');
            $this->session->set_flashdata('message', $formValidation['message'] .' Error: ERRCONVCOUPDCHITHACOEND0001');
            redirect(base_url('index.php/COconversionPartha/GoToCO?pro=6'));
        }

        //syntax validation
        $requestResponse = checkRequestSpecChar($_POST, ['final_notice'=>['%', ':']], [], ['final_notice'=>true]);
        if($requestResponse['status'] == 'n') {
            //ERRCONVCOUPDCHITHACOEND0002
            log_message('error', $requestResponse['messages'] . '. Error: ERRCONVCOUPDCHITHACOEND0002');
            $this->session->set_flashdata('message', 'Contains Illegal parameter values. Error: ERRCONVCOUPDCHITHACOEND0002');
            redirect(base_url('index.php/COconversionPartha/GoToCO?pro=6'));
        }

        //malicious query validation
        $validResponse = checkRequestValidQuery($_POST, [], ['final_notice'=>true]);
        if($validResponse['status'] == 'n') {
            //ERRCONVCOUPDCHITHACOEND0003
            log_message('error', $validResponse['messages'] . '. Error: ERRCONVCOUPDCHITHACOEND0003');
            $this->session->set_flashdata('message', 'Contains Malicious parameter values. Error: ERRCONVCOUPDCHITHACOEND0003');
            redirect(base_url('index.php/COconversionPartha/GoToCO?pro=6'));
        }

        $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'CO', $_POST['case_no'], CONV_CO_CHITHAUPD_COEND);
        if($authorization['status'] == 'n') {
            //ERRCONVCOUPDCHITHACOEND0004
            log_message('error', $authorization['messages'] . '. Error: ERRCONVCOUPDCHITHACOEND0004');
            $this->session->set_flashdata('message', $authorization['messages'].'. Error: ERRCONVCOUPDCHITHACOEND0004');
            redirect(base_url('index.php/home'));
        }
        // echo '<pre>';
        // var_dump($authorization, $_POST);
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
        $hearing_date = date('Y-m-d');
        $final_notice = $this->input->post('final_notice');
        
        $case_no = $this->input->post('case_no');
        $this->session->set_userdata(array('case_no' => $case_no));
        $data['user_desig_code']= $this->session->userdata('user_desig_code');
        $co = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $cir_code, $user_code);
        

        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' "
                . "and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row();
        
    

        $this->db->trans_begin();

        $proceeding = $this->db->query("select count(proceeding_id) as proceed from    petition_proceeding where case_no = '$case_no' limit 1")->result();
        $proceeding_id = $proceeding[0]->proceed + 1;
        $proceeding_data_end2 = array(
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => date('Y-m-d'),
            'co_order' => $final_notice,
            'note_on_order' => '',
            'status' => 'Finish',
            'user_code' => $user_code,
            'date_entry' => date('Y-m-d'),
            'operation' => 'E',
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code
        );
        
        $insert_pp61 = $this->db->insert("petition_proceeding", $proceeding_data_end2);
        if($insert_pp61 != 1){
            $this->db->trans_rollback();
            log_message('error', '#ERRCONV059: Insertion failed in petition_proceeding for case no :'. $case_no);
            $json = [
                'message'=>"#ERRCONV059: Failed to in Proceeding for Case No : ".$case_no
            ];
            echo json_encode($json);
            return false;
        }
        
        $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,date_entry,add_off_name,next_date_of_hearing "
                . "from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row_array();
        
        $date_entry = date('Y-m-d G:i:s');
        
        $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from    petition_dag_details where "
                    . "dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and "
                    . "lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' "
                    . "and petition_no='$petition_basic->petition_no'")->row_array();
        $m_dag_area_lc = $landdetails['m_dag_area_lc'];
        $m_dag_area_lc = round($m_dag_area_lc);
        $data['display'] = array(
            'date' => date('Y-m-d G:i:s'),
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
        
        $order_type = $this->db->query("select * from    master_office_mut_type where order_type_code ='$petition_basic->mut_type'")->row();
        
        $lm_premium = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
            . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and "
            . "mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and co_reject is NULL order by note_no desc limit 1")->row();

        $q = "Select * from    lm_code where lm_code = '$lm_premium->lm_code'";
        
        $name_of_lm = $this->db->query("Select * from    lm_code where lm_code = '$lm_premium->lm_code' and dist_code='$petition_basic->dist_code' "
                . "and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and lot_no='$petition_basic->lot_no'")->row();
        $name_of_lm = $name_of_lm->lm_name;

        $skname = $this->db->query("select * from    users where user_code='$lm_premium->user_code'  and dist_code='$petition_basic->dist_code' "
                . "and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code'")->row();
        $sk_name = $skname->username;

        if($data['user_desig_code'] == 'CO'){
            $display_name=$co->username;
        }else{
            $display_name=$petition_basic->add_off_name;
        }

        $data['display'] = array(
            'date' => date('Y-m-d G:i:s'),
            'proceeding_id' => $proceeding_id,
            'case_no' => $case_no,
            'order_type' => $order_type->order_type,
            'co_name' => $display_name,
            'co_order_date' => $petition_basic->co_order_conv_date,
            'sk_note_date' => $lm_premium->sk_note_date,
            'lm_note_date' => $lm_premium->lm_sign_date,
            'lm_name' => $name_of_lm,
            'sk_name' => $sk_name,
            'co_code' => $petition_basic->add_off_desig,
            'lm_code' => $lm_premium->lm_code,
            'sk_code' => $lm_premium->user_code,
            'bo_note_yn' =>  $petition_basic->bo_note_yn
        );
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/dc_adc_office_conversion/Second_Proceeding_2', $data);
        // $this->load->view('../views/footer');


        if(ENABLED_BLOCKCHAIN == 1 &&  in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {

            //////////////////////////////////////////////////////////////// Property Chain Code //////////////////////////////////////////////
            $this->load->model('propChain/PropChainModel');
            $data['propChainEnableFlag'] = $this->PropChainCommonModel->isLocationEnable($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);

            $landArea = $this->PropChainModel->getLandArea($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, trim($landdetails['patta_no']), $landdetails['dag_no']);

            $chainChithaCheck = $this->PropChainModel->chainChithaUlpinCheckProcess($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, trim($landdetails['patta_no']), $landdetails['dag_no'], $landArea->dag_area_b, $landArea->dag_area_k, $landArea->dag_area_lc, $landArea->dag_area_g, $landdetails['patta_type_code']);

            // var_dump($chainChithaCheck);
            // die;

            if ($chainChithaCheck['ulpinCheck'] == 1 && ($chainChithaCheck['chithaPropChainCmpFlag'] == 'Y' || $chainChithaCheck['chithaPropChainCmpFlag'] == 'N' || $chainChithaCheck['chithaPropChainCmpFlag'] == 'NE')) {
                $this->PropChainModel->updateCmpFlag($case_no, $chainChithaCheck['chithaPropChainCmpFlag']);
                if ($chainChithaCheck['chithaPropChainCmpFlag'] == 'N') {
                    $data['viewMisMatchBtn'] = $this->PropChainModel->getMismatchBtn(
                        $case_no,
                        $dist_code,
                        $subdiv_code,
                        $cir_code,
                        $mouza_pargona_code,
                        $lot_no,
                        $vill_townprt_code,
                        trim($landdetails['patta_no']),
                        $landdetails['dag_no'],
                        $landArea->dag_area_b,
                        $landArea->dag_area_k,
                        $landArea->dag_area_lc,
                        $landArea->dag_area_g,
                        $landdetails['patta_type_code']
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


        
        if ($this->db->trans_status() == false) {
            $this->db->trans_rollback();
            $data = array(
                'error' => "Error in submitting. Please try Again",
            );
        }
        else
        {
            $this->db->trans_commit();
            $data['post_url'] = 'index.php/dc_adc_conversion/FourthProceedingCo';
            $data['_view'] = 'dc_adc_office_conversion/Second_Proceeding_2';
            $this->load->view('layouts/main',$data);
        }
    }

    
    public function Chitha_update_generate(){
        //form validation
        $formValidation = $this->FormValidationModel->formValidationForPost($_POST, [
            'case_no'=>'Case No.|required|case_no',
            'final_notice'=>'Final CO Notice|required'
        ]);
        if($formValidation['status'] == 'n') {
            //ERRCONVCOUPDCHITHA0001
            log_message('error', 'Message: '. $formValidation['message'] .', Data: '. json_encode($formValidation['data']) .'. Error: ERRCONVCOUPDCHITHA0001');
            $this->session->set_flashdata('message', $formValidation['message'] .' Error: ERRCONVCOUPDCHITHA0001');
            redirect(base_url('index.php/COconversionPartha/GoToCO?pro=6'));
        }

        //syntax validation
        $requestResponse = checkRequestSpecChar($_POST, ['final_notice'=>['%', ':']], [], ['final_notice'=>true]);
        if($requestResponse['status'] == 'n') {
            //ERRCONVCOUPDCHITHA0002
            log_message('error', $requestResponse['messages'] . '. Error: ERRCONVCOUPDCHITHA0002');
            $this->session->set_flashdata('message', 'Contains Illegal parameter values. Error: ERRCONVCOUPDCHITHA0002');
            redirect(base_url('index.php/COconversionPartha/GoToCO?pro=6'));
        }

        //malicious query validation
        $validResponse = checkRequestValidQuery($_POST, [], ['final_notice'=>true]);
        if($validResponse['status'] == 'n') {
            //ERRCONVCOUPDCHITHA0003
            log_message('error', $validResponse['messages'] . '. Error: ERRCONVCOUPDCHITHA0003');
            $this->session->set_flashdata('message', 'Contains Malicious parameter values. Error: ERRCONVCOUPDCHITHA0003');
            redirect(base_url('index.php/COconversionPartha/GoToCO?pro=6'));
        }

        $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'CO', $_POST['case_no'], CONV_CO_CHITHAUPD);
        if($authorization['status'] == 'n') {
            //ERRCONVCOUPDCHITHA0004
            log_message('error', $authorization['messages'] . '. Error: ERRCONVCOUPDCHITHA0004');
            $this->session->set_flashdata('message', $authorization['messages'].'. Error: ERRCONVCOUPDCHITHA0004');
            redirect(base_url('index.php/home'));
        }
        // echo '<pre>';
        // var_dump($authorization, $_POST);
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
        $hearing_date = date('Y-m-d');
        $final_notice = $this->input->post('final_notice');
        
        $case_no = $this->input->post('case_no');
        $this->session->set_userdata(array('case_no' => $case_no));
        $data['user_desig_code']= $this->session->userdata('user_desig_code');
        $co = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $cir_code, $user_code);
        

        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' "
                . "and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row();
        
    

        $this->db->trans_begin();

        $proceeding = $this->db->query("select count(proceeding_id) as proceed from    petition_proceeding where case_no = '$case_no' limit 1")->result();
        $proceeding_id = $proceeding[0]->proceed + 1;
        $proceeding_data_end2 = array(
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => date('Y-m-d'),
            'co_order' => $final_notice,
            'note_on_order' => '',
            'status' => 'Finish',
            'user_code' => $user_code,
            'date_entry' => date('Y-m-d'),
            'operation' => 'E',
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code
        );
        
        $insert_pp61 = $this->db->insert("petition_proceeding", $proceeding_data_end2);
        if($insert_pp61 != 1){
            $this->db->trans_rollback();
            log_message('error', '#ERRCONV059: Insertion failed in petition_proceeding for case no :'. $case_no);
            $json = [
                'message'=>"#ERRCONV059: Failed to in Proceeding for Case No : ".$case_no
            ];
            echo json_encode($json);
            return false;
        }
        
        $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,date_entry,add_off_name,next_date_of_hearing "
                . "from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row_array();
        
        $date_entry = date('Y-m-d G:i:s');
        
        $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from    petition_dag_details where "
                    . "dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and "
                    . "lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' "
                    . "and petition_no='$petition_basic->petition_no'")->row_array();
        $m_dag_area_lc = $landdetails['m_dag_area_lc'];
        $m_dag_area_lc = round($m_dag_area_lc);
        $data['display'] = array(
            'date' => date('Y-m-d G:i:s'),
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
        
        $order_type = $this->db->query("select * from    master_office_mut_type where order_type_code ='$petition_basic->mut_type'")->row();
        
        $lm_premium = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
            . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and "
            . "mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and co_reject is NULL order by note_no desc limit 1")->row();

        $q = "Select * from    lm_code where lm_code = '$lm_premium->lm_code'";
        
        $name_of_lm = $this->db->query("Select * from    lm_code where lm_code = '$lm_premium->lm_code' and dist_code='$petition_basic->dist_code' "
                . "and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and lot_no='$petition_basic->lot_no'")->row();
        $name_of_lm = $name_of_lm->lm_name;

        $skname = $this->db->query("select * from    users where user_code='$lm_premium->user_code'  and dist_code='$petition_basic->dist_code' "
                . "and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code'")->row();
        $sk_name = $skname->username;

        if($data['user_desig_code'] == 'CO'){
            $display_name=$co->username;
        }else{
            $display_name=$petition_basic->add_off_name;
        }

        $data['display'] = array(
            'date' => date('Y-m-d G:i:s'),
            'proceeding_id' => $proceeding_id,
            'case_no' => $case_no,
            'order_type' => $order_type->order_type,
            'co_name' => $display_name,
            'co_order_date' => $petition_basic->co_order_conv_date,
            'sk_note_date' => $lm_premium->sk_note_date,
            'lm_note_date' => $lm_premium->lm_sign_date,
            'lm_name' => $name_of_lm,
            'sk_name' => $sk_name,
            'co_code' => $petition_basic->add_off_desig,
            'lm_code' => $lm_premium->lm_code,
            'sk_code' => $lm_premium->user_code,
            'bo_note_yn' =>  $petition_basic->bo_note_yn
        );
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/dc_adc_office_conversion/Second_Proceeding_2', $data);
        // $this->load->view('../views/footer');


        if(ENABLED_BLOCKCHAIN == 1 &&  in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {

            //////////////////////////////////////////////////////////////// Property Chain Code //////////////////////////////////////////////
            $this->load->model('propChain/PropChainModel');

            $landArea = $this->PropChainModel->getLandArea($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, trim($landdetails['patta_no']), $landdetails['dag_no']);

            $chainChithaCheck = $this->PropChainModel->chainChithaUlpinCheckProcess($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, trim($landdetails['patta_no']), $landdetails['dag_no'], $landArea->dag_area_b, $landArea->dag_area_k, $landArea->dag_area_lc, $landArea->dag_area_g, $landdetails['patta_type_code']);

            // var_dump($chainChithaCheck);
            // die;

            if ($chainChithaCheck['ulpinCheck'] == 1 && ($chainChithaCheck['chithaPropChainCmpFlag'] == 'Y' || $chainChithaCheck['chithaPropChainCmpFlag'] == 'N' || $chainChithaCheck['chithaPropChainCmpFlag'] == 'NE')) {
                $this->PropChainModel->updateCmpFlag($case_no, $chainChithaCheck['chithaPropChainCmpFlag']);
                if ($chainChithaCheck['chithaPropChainCmpFlag'] == 'N') {
                    $data['viewMisMatchBtn'] = $this->PropChainModel->getMismatchBtn(
                        $case_no,
                        $dist_code,
                        $subdiv_code,
                        $cir_code,
                        $mouza_pargona_code,
                        $lot_no,
                        $vill_townprt_code,
                        trim($landdetails['patta_no']),
                        $landdetails['dag_no'],
                        $landArea->dag_area_b,
                        $landArea->dag_area_k,
                        $landArea->dag_area_lc,
                        $landArea->dag_area_g,
                        $landdetails['patta_type_code']
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


        
        if ($this->db->trans_status() == false) {
            $this->db->trans_rollback();
            $data = array(
                'error' => "Error in submitting. Please try Again",
            );
        }
        else
        {
            $this->db->trans_commit();
            $data['post_url'] = 'index.php/dc_adc_conversion/FourthProceeding';
            $data['_view'] = 'dc_adc_office_conversion/Second_Proceeding_2';
            $this->load->view('layouts/main',$data);
        }
    }
    
    public function update_designation(){
        $db=  $this->session->userdata('db');
        $year_no = year_no;
        $define_date = define_date;
        $dist_code = $this->session->userdata('dist_code');
        
        $result = $this->db->query("select * from    petition_basic where not_fresh = 'Y' and status = 'P' and mut_type='01' "
                . "and dist_code='$dist_code' and "
                . "year_no='$year_no' and date_entry >= '$define_date' ")->result();

        foreach ($result as $petition_basic) {
            
            $update_q = "Update  petition_basic set co_user_code='$petition_basic->add_off_desig', add_off_desig='CO'  where status = '$petition_basic->status' and mut_type='$petition_basic->mut_type' and dist_code='$petition_basic->dist_code' and "
                    . "subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' "
                    . "and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and case_no = '$petition_basic->case_no' and "
                    . "petition_no='$petition_basic->petition_no' and year_no='$year_no' and date_entry >= '$define_date' and not_fresh = '$petition_basic->not_fresh'";
            
            
            $this->db->query($update_q); //*********************
        }
        redirect(base_url() . "index.php/home");
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
                $action= array(
                    'case_no' => $case_no,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_of_action_taken' => date('Y-m-d'),
                    'user_designation' => $this->session->userdata('user_desig_code'),
                    'remark' => 'Rejected',
                     );
                $this->dbb->insert('dashboard_action',$action);
            }
   ////////////////////////////////////
   public function RejectOrder() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');
        $this->session->set_userdata(array('mouza_pargona_code1' => $mouza_pargona_code));
        $this->session->set_userdata(array('lot_no1' => $lot_no));
        $this->session->set_userdata(array('vill_townprt_code1' => $vill_townprt_code));
        $data = array();
        $case_no = $this->input->get('case_no');
        $petition_basic = $this->db->query("select * from petition_basic where case_no='$case_no' "
                . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
                . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code' ")->row();

        $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,date_entry,add_off_name,next_date_of_hearing,sk_comment,petition_no"
                        . " from petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
                . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row_array();
        
        $petition_no = $location['petition_no'];
        $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code 
        from petition_dag_details where dist_code='$dist_code' and subdiv_code='$subdiv_code'
        and cir_code='$cir_code' and lot_no='$lot_no' and 
        vill_townprt_code='$vill_townprt_code' and mouza_pargona_code='$mouza_pargona_code' 
        and petition_no='$petition_no'")->row_array();

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
        
        $data['patta_type'] = $this->db->query("select patta_type from patta_code "
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
        $data['conv_type'] = $this->db->query("select order_type from master_office_mut_type "
                . "where order_type_code='$convertion_code'")->row()->order_type;

        $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from petition_dag_details where dist_code='$petition_basic->dist_code' "
                . "and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' "
                . "and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'")->row_array();

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

        $data['patta_type'] = $this->db->query("select patta_type from patta_code "
                        . " where type_code='$landdetails[patta_type_code]'")->row()->patta_type;

        $pattadardetails = "select pdar_name,pdar_guardian,pdar_rel_guar,pdar_add1,pdar_add2 from petitioner_part where dist_code='$petition_basic->dist_code' and "
                . "subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and "
                . "vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and "
                . "petition_no='$petition_basic->petition_no' and dag_no='$landdetails[dag_no]' and TRIM(patta_no)=trim('$landdetails[patta_no]') and "
                . "patta_type_code= '$landdetails[patta_type_code]'";
        
        $data['pattadar'] = $this->db->query($pattadardetails)->result();
        $data['p_in_order'] = $this->db->query($pattadardetails)->result();
        
        $lm_details = $this->db->query("Select * from petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
                . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' "
                . "and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' order by note_no desc limit 1 ")->row_array();
        

        if (count($lm_details) != '0') {
            $land = $lm_details['land_class_code'];
            $land_type = $this->db->query("Select * from landclass_code where class_code = '$land'")->row();

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
            );
        }
        
        $namelm = $this->db->query("select * from lm_code where lm_code = '" . $lm_details['lm_code'] . "'  and dist_code = '" . $location['dist_code'] . "' and subdiv_code = '" . $location['subdiv_code'] . "' and cir_code = '" . $location['cir_code'] . "' and mouza_pargona_code = '" . $location['mouza_pargona_code'] . "' and lot_no = '" . $location['lot_no'] . "' ")->row();
        $data['lm_name'] = $namelm->lm_name;
        
        $skname = $this->db->query("select * from users where user_code='" . $lm_details['user_code'] . "'  and dist_code = '" . $lm_details['dist_code'] . "' and subdiv_code = '" . $lm_details['subdiv_code'] . "' and cir_code = '" . $lm_details['cir_code'] . "' ")->row();
        $data['sk_skname'] = $skname->username;

        $query = "select * from petition_proceeding where case_no = '$case_no' order by proceeding_id";
        $data['cases'] = $this->db->query($query)->result();

        $data['lm_details_final'] = $this->db->query("Select * from petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' ORDER BY note_no DESC LIMIT 1")->result();
        
        $data['premium'] = $this->db->query("Select * from petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and co_reject is NULL ORDER BY note_no DESC LIMIT 1")->result();

      /* $data['dc_adc']=$this->db->query("Select users.username as username, users.user_desig_code as user_desig_code, loginuser_table.user_code as user_code from users, "
                . "loginuser_table where users.dist_code = loginuser_table.dist_code "
                . "and users.user_code = loginuser_table.user_code and users.user_desig_code like '%DC' and users.dist_code='$petition_basic->dist_code' and "
                . "users.subdiv_code='00' and users.cir_code='00' and loginuser_table.dis_enb_option = 'E' and loginuser_table.priv = 'adm'  and loginuser_table.dist_code='$petition_basic->dist_code' and loginuser_table.subdiv_code='00' and loginuser_table.cir_code='00'")->result(); */
        
      $data['dc_adc']=$this->db->query( "Select users.username as username, users.user_desig_code as user_desig_code, loginuser_table.user_code as user_code from users, "
                . "loginuser_table where users.dist_code = loginuser_table.dist_code "
                . "and users.user_code = loginuser_table.user_code and users.user_desig_code like '%DC' and users.dist_code='$petition_basic->dist_code' and "
                . "users.subdiv_code='00' and users.cir_code='00' and loginuser_table.dis_enb_option = 'E' and loginuser_table.priv = 'adm' and loginuser_table.dist_code='$petition_basic->dist_code' and loginuser_table.subdiv_code='00' and loginuser_table.cir_code='00'")->result();
            
            //exit();
            
         // var_dump($data);
      $data['_view'] = 'co_office_conversion/rejectorder';
        $this->load->view('layouts/main',$data);
     // $this->load->helper('html');
     //    $this->load->view('../views/header');
     //    $this->load->view('../views/co_office_conversion/rejectorder', $data);
     //    $this->load->view('../views/footer');
    }
    ///////////////////19-02-22//////////////////
    public function CoToLMFD() {
        //$db=  $this->session->userdata('db');
        $process = $this->input->get('pro');
        $user_code = $this->session->userdata('user_code');
        $user_desig_code=$this->session->userdata('user_desig_code');

        if ($process == '1') {
            $config['total_rows'] = $this->COofficeConversionModel->countPendingConversionFreshCases($user_code);
            $cases['cases'] = $this->COofficeConversionModel->getPendingConversionFreshCases($user_code)->result();
        }

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $dist_code_name = $this->utilityclass->getDistrictName($dist_code);

        $subdiv_code_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_code_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);

        $coName=$this->utilityclass->getSelectedCOName($dist_code,$subdiv_code,$cir_code,$this->session->userdata('user_code'));

        $cases['location'] = array(
            'dist' => $dist_code_name,
            'sub' => $subdiv_code_name,
            'cir' => $cir_code_name,
            'add_to' => $coName->username
        );

        $cases['process'] = $process;
        $cases['_view'] = 'co_office_conversion/co_bulk_forward';
        $this->load->view('layouts/main',$cases);
    }
    ///////////////////////////checkNumberofCases/////////////////////////////
    function checkNumberofCases()
    {
        if(count($this->input->post('check_case')) > CO_BULK_SELECT_LIMIT)
        {
            $this->form_validation->set_message('checkNumberofCases', 'Allowed only '.CO_BULK_SELECT_LIMIT.' cases at a time.');
            return false;
        }
        else
        {
            return true;
        }
    }
    ////////////////////CO BULK FORWARD TO LM/////////////
    public function coBulkForward()
    {
        $case_validate = array(
            array(
                'field' => 'check_case[]',
                'label' => 'Case No.',
                'rules' => 'trim|required|xss_clean|callback_checkNumberofCases'
            ),
            array(
                'field' => 'hearing_date',
                'label' => 'Hearing Date',
                'rules' => 'trim|required|xss_clean'
            ),
        );

        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->form_validation->set_rules($case_validate);
        $validation = null;
        if ($this->form_validation->run() == false)
        {
            $this->form_validation->set_error_delimiters('', '');
            foreach($case_validate as $rule){
                if (form_error($rule['field'])) {
                    $validation['error'][] = array('field' => $rule['field'], 'message' => form_error($rule['field']));
                }
            }
            echo json_encode($validation);
            return;
        }

        $this->db->trans_begin();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $user_code = $this->session->userdata('user_code');
        $date_entry = date('Y-m-d G:i:s');

        $cases= $this->input->post('check_case');
        $hearing_date = date('Y-m-d',strtotime($this->input->post('hearing_date')));

        $case_list = implode(", ",$cases);
        $define_date = define_date;

        $proceeding_id = 1;

        $coName=$this->utilityclass->getSelectedCOName($dist_code,$subdiv_code,$cir_code,$this->session->userdata('user_code'));

        foreach ($cases as $key=>$case)
        {
            $case_no = trim($case);

            $proceeding = $this->db->query("select count(proceeding_id) as proceed from petition_proceeding where case_no =? limit 1",array($case_no))->result();
            if($proceeding)
            {
                $proceeding_id = $proceeding[0]->proceed + 1;
            }

            $q = "Select *,ba.basundhara from petition_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree  where fmb.case_no =? and fmb.not_fresh is null and fmb.lm_note_yn is null and fmb.mut_type=? and fmb.co_user_code =? and fmb.date_entry >=? "
                . "and fmb.dist_code=? and fmb.subdiv_code=? and fmb.cir_code=? and (fmb.status is null or fmb.status =?)";

            $case_new = $this->db->query($q,array($case_no,'01',$user_code,$define_date,$dist_code,$subdiv_code,$cir_code,'P'))->row();

            $cir_code_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);

            $mouza_pargona_code_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $case_new->mouza_pargona_code);
            $vill_townprt_code_name = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $case_new->mouza_pargona_code, $case_new->lot_no, $case_new->vill_townprt_code);

            $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from petition_dag_details where "
                . "dist_code=? and subdiv_code=? and cir_code=? and lot_no=? and "
                . "vill_townprt_code=? and mouza_pargona_code=? and "
                . "petition_no=?", array($case_new->dist_code,$case_new->subdiv_code,$case_new->cir_code,$case_new->lot_no,$case_new->vill_townprt_code,$case_new->mouza_pargona_code,$case_new->petition_no))->row_array();
            if($landdetails['patta_type_code']=='0')
            {
                $this->db->trans_rollback();
                $validation['db_error'] = true;
                $validation['msg'] = 'Error: Conversion Proceeding Order for Case no '. $case .' Not Successful. Contact Helpdesk with case no.';
                echo json_encode($validation);
                return;
            }else{
               $pattadar_details_query = "select pdar_name,pdar_guardian,pdar_rel_guar,pdar_add1,pdar_add2,pdar_mobile from petitioner_part where dist_code=? and subdiv_code=? and cir_code=? and lot_no=? and vill_townprt_code=? and mouza_pargona_code=? and petition_no=? and dag_no=? and TRIM(patta_no)=? and patta_type_code=?";
               $pattadardetails = $this->db->query($pattadar_details_query,array($case_new->dist_code,$case_new->subdiv_code,$case_new->cir_code,$case_new->lot_no,$case_new->vill_townprt_code,$case_new->mouza_pargona_code,$case_new->petition_no,$landdetails['dag_no'],trim($landdetails['patta_no']),$landdetails['patta_type_code']))->result();
                $patta_type = $this->db->query("select patta_type from  patta_code where type_code=?",array($landdetails['patta_type_code']))->row()->patta_type;
            }
            foreach ($pattadardetails as $p)
            {
                $p_name[] = $p->pdar_name.' ('.$p->pdar_guardian.') ';
            }

            $p_names = implode(', ', $p_name);

            $co_note = "আবেদনকাৰীৰ ম্যাদীকৰণ আৱেদন চোৱা হল । আবেদনকাৰী <span style='color:red;'> " .$p_names. "</span> য়ে " .$mouza_pargona_code_name. " মৌজাৰ "
                .$vill_townprt_code_name. " গাঁৱৰ ".trim($landdetails['patta_no']). " নং ".$patta_type. " পট্টাৰ ".$landdetails['dag_no']. " নং দাগৰ ".$landdetails['m_dag_area_b'].
                " বিঘা " .$landdetails['m_dag_area_k']. " কঠা ".$landdetails['m_dag_area_lc']." লেছা মাটিৰ ম্যাদীকৰণ বিচাৰিছে |<br>ভূমিলেখ্য সহায়ক আৰু  ভূমিলেখ্য পৰ্যবেক্ষকই  ভূমি-লেক্ষ্য নিয়মাৱলীৰ ১০৫ নং ধাৰা মতে প্রতিবেদন দিব । ".
                $hearing_date ." তাৰিখ শুনানি আৰু আপত্তি  দাখিলৰ বাবে ধাৰ্য্য হ'ল । <br><label class='control-label rasid' style='float:right;margin-right:50px;'>"
                .$coName->username. " <br>চক্র বিষয়া, ".$cir_code_name. "</label>";

            $proceeding_data = array(
                'case_no' => $case_no,
                'proceeding_id' => $proceeding_id,
                'date_of_hearing' => $hearing_date,
                'co_order' => $co_note,
                'status' => 'Pending',
                'user_code' => $user_code,
                'date_entry' => $date_entry,
                'operation' => 'E',
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
            );

            $update = $this->db->query("UPDATE  Petition_Basic SET status =?, next_date_of_hearing =?,not_fresh =?,notice_generated_yn=?,notice_generated_date =? WHERE "
                . "dist_code=? and subdiv_code=? and cir_code=? and (status is null or status =?)"
                . " and not_fresh is null and case_no =?",array('P',$hearing_date,'Y','Y',$date_entry,$dist_code,$subdiv_code,$cir_code,'P',$case_no));

            if($this->db->affected_rows() != 1 || $update == false)
            {
                $this->db->trans_rollback();
                $validation['db_error'] = true;
                $validation['msg'] = 'Error: Conversion Proceeding Order for Case no '. $case_list .' Not Successful. Contact Helpdesk with case no.';
                echo json_encode($validation);
                return;
            }

            $proceeding = $this->db->insert("petition_proceeding", $proceeding_data);

            if($proceeding == false)
            {
                $this->db->trans_rollback();
                $validation['db_error'] = true;
                $validation['msg'] = 'Error: Conversion Proceeding Order for Case no '. $case_list .' Not Successful. Contact Helpdesk with case no.';
                echo json_encode($validation);
                return;
            }

            $penUser='LM';
            $rmrk='Forwarded to LM By CO';
            $this->DashboardData(trim($case),$penUser,$rmrk);
            $status='M';
            $task='CO';
            $pen='LM';
            $case=trim($case);
            $this->basundharamodel->postApiBasundharaSec($case,$rmrk,$status,$task,$pen);

        }
        /////////////////// Insert into dashboard_action ///////////////
        foreach ($cases as $key=>$case_no)
        {
            $d_array[$key]['case_no'] = $case_no;
            $d_array[$key]['user_code'] = $this->session->userdata('user_code');
            $d_array[$key]['date_of_action_taken'] = date('Y-m-d');
            $d_array[$key]['user_designation'] = $this->session->userdata('user_desig_code');
            $d_array[$key]['ip_address '] = $this->input->ip_address();
            $d_array[$key]['remark'] = 'Forwarded to LM By CO';
        }


        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $validation['db_error'] = true;
            $validation['msg'] = 'Error: Conversion Proceeding Order for Case no '. $case_list .' Not Successful. Contact Helpdesk with case no.';
            echo json_encode($validation);
            return;
        }
        else
        {
            $this->db->trans_commit();
            $dash_board_insert_1 =  $this->db->insert_batch('dashboard_action', $d_array);

            // $this->dbb = $this->load->database('dash', TRUE);

            // $dash_board_insert_2 =  $this->dbb->insert_batch('dashboard_action', $d_array);
            $validation['db_error'] = false;
            $validation['msg'] = 'Conversion Proceeding Order for Case no '. $case_list .' Successfully.';
            echo json_encode($validation);
            return;
        }
    }
    //////////////////////////////
    function penidngForChithaUpdate(){
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $date=date('2021-09-02');
        $query = "select * from t_chitha_rmk_ordbasic left join basundhar_application on t_chitha_rmk_ordbasic.ord_no=basundhar_application.dharitree where dist_code='$dist_code' and "
                . "subdiv_code='$subdiv_code' and cir_code='$cir_code' and ord_type_code='01' and (iscorrected_inco is null or lower(iscorrected_inco)!='y') and co_ord_date>='$date' ";
        $cases['pending'] = $this->db->query($query)->result();
        $cases['_view'] = 'co_office_conversion/pending_for_chitha_update';
        $this->load->view('layouts/main',$cases);
   }
   function updateChithaConv($case_no=null){
     $case_no=$this->input->get('case_no');
     $this->session->set_userdata('case_no',$case_no);
     redirect('COconversionPartha/updateChithaConversionForFullConversion');
   }
   function updateConv_order(){
        $case_no=$this->input->get('case_no');
        $user_code=$this->session->userdata('user_code');
        $sql="delete from t_chitha_rmk_ordbasic where ord_no='$case_no'";
        $this->db->query($sql);
        $sql="delete from t_chitha_rmk_convorder where ord_no='$case_no'";
        $this->db->query($sql);
        $upsql="Update petition_basic set status='P',add_off_name='$user_code'  where case_no='$case_no' ";
        $this->db->query($upsql);
        redirect('home/ConversionCo');
    }
    ############# 06-05-2022 
    function convBasuReport(){
        $case_no=$this->input->get('app');
        $sql="Select dharitree from basundhar_application where basundhara='$case_no' ";
        $data=$this->db->query($sql)->num_rows();
        if($data>0){
            $dharitree=$this->db->query($sql)->row();
            $send['case']=array('basundhara'=>$case_no,'dharitree'=>$dharitree->dharitree);

            $sql = "SELECT t.co_order,t.date_of_hearing,t.note_on_order,t.date_entry from ( SELECT a.co_order,a.date_of_hearing,a.note_on_order,a.date_entry from  petition_proceeding A where A.case_no='$dharitree->dharitree'
                Union 
                Select b.co_order,b.date_of_hearing,b.note_on_order,b.date_entry from petition_proceeding_dc_adc B WHERE B.case_no='$dharitree->dharitree') as t order by t.date_of_hearing asc  ";

            $pro=$this->db->query($sql)->num_rows();
            if($pro>0){
                //echo $this->db->last_query();
                $send['result']= $this->db->query($sql)->result_array();
                //var_dump($send['result']);
            }else{
                $send['result']=array();
            }
            $this->load->view('dc_adc_office_conversion/rejectReportConv',$send);
        }else{
            echo "No Report Found";
        }
    }


    function setupdateProDate() {
        $case_no = $this->input->get('case_no');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');
        $this->session->set_userdata('case_no', $case_no);
        $this->session->set_userdata('mouza_pargona_code', $mouza_pargona_code);
        $this->session->set_userdata('lot_no', $lot_no);
        $this->session->set_userdata('vill_townprt_code', $vill_townprt_code);
        redirect(base_url() . 'index.php/COconversionPartha/updateProDate');
    }

    function updateProDate() {
        //xss & security validation starts
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
            //ERRCONVCOUPDHEARINGDATE001
            log_message('error', $errorMessageStr .'. Error: ERRCONVCOUPDHEARINGDATE001');
            $this->session->set_flashdata('message', $errorMessageStr .'Error: ERRCONVCOUPDHEARINGDATE001');
            return redirect(base_url('index.php/COconversionPartha/GoToCO?pro=2'));
        }
        //xss & security validation ends 
        $this->dbswitch();
        //$db=  $this->session->userdata('db');
        $this->form_validation->set_rules('update_date', 'Select Date', 'required');
        $this->form_validation->set_rules('remark', 'Write Remarks', 'required');
        if ($this->form_validation->run() == FALSE) {
            //$this->load->view('../views/header');
            //$this->load->view('../views/partition/updatenotice');
            //$this->load->view('../views/footer');
            $data['error'] = 'Date of hearing and Reason are required fields.';
            $data['_view'] = 'co_office_conversion/updatenotice';
            $this->load->view('layouts/main',$data);

        } else {
            $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'CO', $_POST['case_no'], CONV_CO_SECOND);
            if($authorization['status'] == 'n') {
                //ERRCONVCOUPDHEARINGDATE002
                log_message('error', $authorization['messages'] . '. Error: ERRCONVCOUPDHEARINGDATE002');
                $this->session->set_flashdata('message', $authorization['messages'].'. Error: ERRCONVCOUPDHEARINGDATE002');
                redirect(base_url('index.php/home'));
            }
            $updateProDate = $this->input->post('update_date');
            $case_no = $this->input->post('case_no');
            $remark = addslashes($this->input->post('remark'));
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->session->userdata('vill_townprt_code');
            $user_code = $this->session->userdata('user_code');
            $q = "Select max(proceeding_id)+1 as id from    petition_proceeding where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
            $id = $this->db->query($q)->row()->id;
            if ($id == null) {
                $id = 1;
            }
            $date = date('Y-m-d');
            $pb = array(
                'next_date_of_hearing' => date('Y-m-d', strtotime($updateProDate)),
                'submission_date' => $date
            );
            $pp = array(
                'case_no' => $case_no,
                'proceeding_id' => $id,
                'date_of_hearing' => date('Y-m-d G:i:s'),
                'co_order' => $remark,
                'next_date_of_hearing' => date('Y-m-d', strtotime($updateProDate)),
                'status' => 0,
                'user_code' => $user_code,
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E',
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'ip' => $this->utilityclass->get_client_ip()
            );
            $this->db->where('case_no', $case_no);
            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('cir_code', $cir_code);
            $this->db->where('mouza_pargona_code', $mouza_pargona_code);
            $this->db->where('lot_no', $lot_no);
            $this->db->where('vill_townprt_code', $vill_townprt_code);
            $this->db->update("petition_basic", $pb);
            $this->db->insert("petition_proceeding", $pp);

            $penUser='CO';
            $rmrk='Change of Hearing date by CO';
            $this->DashboardData($case_no,$penUser,$rmrk);

            $this->session->set_flashdata('message', "Date Updated Successfully ## $case_no !!");
            redirect(base_url() . 'index.php/home/index');
        }
    }

}
