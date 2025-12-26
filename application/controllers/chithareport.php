<?php 
//ini_set('max_execution_time', 0);
// session_start();
class ChithaReport extends CI_Controller
 {
     public function __construct() {
        parent::__construct();
        $this->dbswitch();
        // $this->load->model('chitha/DharChithaModel');
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
     } else if($this->session->userdata('dist_code') == "22"){
        $this->db=$this->load->database('dha41', TRUE);   
     }                                                                                                                                                                                                            
}

    public function index() {
        $this->load->helper('html');
        $this->load->view('header');
        $session = $this->session->userdata('username');
        if ($session == 'lm') {
            $this->load->view('menu/menu1');
        } elseif ($session == 'sk') {
            $this->load->view('menu/menu2');
        } elseif ($session == 'oc') {
            $this->load->view('menu/menu3');
        }
        $this->load->model('mutation/mutationmodel');
        $this->load->helper('html');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouzas = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);
        $district['d'] = $dist_code;
        $district['s'] = $subdiv_code;
        $district['c'] = $cir_code;
        $district['mouzas'] = $mouzas;
        //////////var_dump($mouzas);
        $data = $this->mutationmodel->getDistricts();
        $district['names'] = $data;

        $this->load->view('menu/menu4');

        $this->load->view('chitha_report/report1', $district);
        $this->load->view('footer');
    }

    public function viewDownloads()
    {
        //$this->dataswitch();
        // if ($this->session->userdata('usertype') == 02 || $this->session->userdata('usertype') == 2) {
        //     $this->dbswitch($this->session->userdata('dist_code'));
        // } else {
        //     $this->dataswitch();
        // }
        $this->dataswitch();
        $uuid = $this->input->get('uuid');
        $data['dag_no'] = $dag_no = $this->input->get('dag_no');

        $district = $this->db->query("select dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code from   location where  uuid='$uuid'");
        $loc_code = $district->row();
        
        $this->load->model('misreport/MisModel');

        $districtdata = $this->MisModel->getDistrictName($loc_code->dist_code);
        $subdivdata = $this->MisModel->getSubDivName($loc_code->dist_code, $loc_code->subdiv_code);
        $circledata = $this->MisModel->getCircleName($loc_code->dist_code, $loc_code->subdiv_code, $loc_code->cir_code);
        $mouzadata = $this->MisModel->getMouzaName($loc_code->dist_code, $loc_code->subdiv_code, $loc_code->cir_code, $loc_code->mouza_pargona_code);
        $lotdata = $this->MisModel->getLotName($loc_code->dist_code, $loc_code->subdiv_code, $loc_code->cir_code, $loc_code->mouza_pargona_code, $loc_code->lot_no);
        $villagedata = $this->MisModel->getVillageName($loc_code->dist_code, $loc_code->subdiv_code, $loc_code->cir_code, $loc_code->mouza_pargona_code, $loc_code->lot_no, $loc_code->vill_townprt_code);
        $data['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotdata, $villagedata);


        $doc1_id = $this->db->query("SELECT doc_flag,file_name,dag_no,uuid FROM supportive_document_chitha WHERE doc_flag='1' and dag_no= ? and uuid= ?", array($dag_no, $uuid));
        if ($doc1_id->num_rows() > 0) {
            $data['doc1_id'] = $doc1_id->row();
        }

        $doc2_id = $this->db->query("SELECT doc_flag,file_name,dag_no,uuid, patta_no, patta_type_code FROM jamabandi_document WHERE doc_flag='2' and dag_no= ? and uuid= ? ", array($dag_no, $uuid));
        if ($doc2_id->num_rows() > 0) {
            $data['doc2_id'] = $doc2_id->row();
        }

        $doc3_id = $this->db->query("SELECT doc_flag,file_name,dag_no,uuid, khatian_no FROM khatian_document WHERE doc_flag='3' and dag_no= ? and uuid= ? ", array($dag_no, $uuid));
        if ($doc3_id->num_rows() > 0) {
            $data['doc3_id'] = $doc3_id->row();
        }

        $doc4_id = $this->db->query("SELECT doc_flag,file_name,dag_no,uuid FROM supportive_document_chitha WHERE doc_flag='4' and dag_no= ? and uuid = ? ", array($dag_no, $uuid));
        if ($doc4_id->num_rows() > 0) {
            $data['doc4_id'] = $doc4_id->row();
        }

        $doc5_id = $this->db->query("SELECT doc_flag,file_name,dag_no,uuid FROM supportive_document_chitha WHERE doc_flag='5' and dag_no= ? and uuid = ? ", array($dag_no, $uuid));
        if ($doc5_id->num_rows() > 0) {
            $data['doc5_id'] = $doc5_id->row();
        }

        
        $data['_view'] = 'document_upload/view_files';
        $this->load->view('layouts/main', $data);
    }

    public function downloadDocuments()
    {
        //$this->dataswitch();
        // if ($this->session->userdata('usertype') == 02 || $this->session->userdata('usertype') == 2) {
        //     $this->dbswitch($this->session->userdata('dist_code'));
        // } else {
        //     $this->dataswitch();
        // }

        $this->dataswitch();
        $doc_flag = $this->input->get('doc_flag');
        $uuid = $this->input->get('uuid');
        $dag_no = $this->input->get('dag_no');

        if (isset($doc_flag, $uuid, $dag_no)) {
            $result = $this->db->query("SELECT * FROM supportive_document_chitha WHERE doc_flag=? and uuid =? and dag_no= ?", array($doc_flag, $uuid, $dag_no))->row_array();
            //"C:\\xampp\\htdocs\\DharitreeSVN_demo\\"
            $exploded_file = explode('/', $result['file_path']);
            unset($exploded_file[0]);
            $imploded_file = implode('/', array_values($exploded_file));
            $file = CHITHA_UPLOAD . $imploded_file;
            log_message("error", 'DOwnloaded file path: ' . json_encode($file));
            $content_type = $result['file_type'];
            header('Content-Type: ' . $content_type);
            header('Content-Length: ' . filesize($file));
            ob_clean();
            echo file_get_contents($file);
        } else {
            echo "No Data Found..";
        }
    }

    public function downloadJamabandiDocuments()
    {
        //$this->dataswitch();
        // if ($this->session->userdata('usertype') == 02 || $this->session->userdata('usertype') == 2) {
        //     $this->dbswitch($this->session->userdata('dist_code'));
        // } else {
        //     $this->dataswitch();
        // }
        $this->dataswitch();
        $doc_flag = $this->input->get('doc_flag');
        $uuid = $this->input->get('uuid');
        $patta_no = $this->input->get('patta_no');
        $patta_type_code = $this->input->get('patta_type_code');

        if (isset($doc_flag, $uuid, $patta_no, $patta_type_code)) {
            $result = $this->db->query("SELECT * FROM jamabandi_document WHERE doc_flag=? AND uuid =? AND patta_no= ? AND patta_type_code=?", array($doc_flag, $uuid, $patta_no, $patta_type_code))->row_array();
            //"C:\\xampp\\htdocs\\DharitreeSVN_demo\\"
            $file = JAMABANDI_UPLOAD . $result['file_path'];
            log_message("error", 'Downloaded file path: ' . json_encode($file));
            $content_type = $result['file_type'];
            header('Content-Type: ' . $content_type);
            header('Content-Length: ' . filesize($file));
            ob_clean();
            echo file_get_contents($file);
        } else {
            echo "No Data Found..";
        }
    }

    public function downloadKhatianDocuments()
    {
        //$this->dataswitch();
        // if ($this->session->userdata('usertype') == 02 || $this->session->userdata('usertype') == 2) {
        //     $this->dbswitch($this->session->userdata('dist_code'));
        // } else {
        //     $this->dataswitch();
        // }
        $this->dataswitch();
        $doc_flag = $this->input->get('doc_flag');
        $uuid = $this->input->get('uuid');
        $khatian_no = $this->input->get('khatian_no');

        if (isset($doc_flag, $uuid, $khatian_no)) {
            $result = $this->db->query("SELECT * FROM khatian_document WHERE doc_flag=? AND uuid =? AND khatian_no= ?", array($doc_flag, $uuid, $khatian_no))->row_array();
            //"C:\\xampp\\htdocs\\DharitreeSVN_demo\\"
            $file = KHATIAN_UPLOAD . $result['file_path'];
            log_message("error", 'Downloaded file path: ' . json_encode($file));
            $content_type = $result['file_type'];
            header('Content-Type: ' . $content_type);
            header('Content-Length: ' . filesize($file));
            ob_clean();
            echo file_get_contents($file);
        } else {
            echo "No Data Found..";
        }
    }

    public function districtDetails() {
        $this->dataswitch();
        $counts['_view'] = 'chitha_report/report1';
		$this->load->view('layouts/main',$counts);
    }

    public function districtDetailsBarak() {
        $this->dataswitch();
        $data['_view'] = 'chitha_report/reportBarak';
		$this->load->view('layouts/main',$data);
    }

    public function generateDagChithaBarak() {

        $dist_code = $this->input->post('dist_code', true);
        $subdiv_code = $this->input->post('subdiv_code', true);
        $cir_code = $this->input->post('circle_code', true);
        $mouza_pargona_code = $this->input->post('mouza_code', true);
        $lot_no = $this->input->post('lot_no', true);
        $vill_townprt_code = $this->input->post('vill_code', true);

        $this->load->model('misreport/MisModel');
        $this->load->model('chitha/ChithaModel');

        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
        $lotdata = $this->MisModel->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);

        $maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotdata, $villagedata);

        $locationData= array(
            'chitha_dist_code' => $dist_code, 
            'chitha_subdiv_code' => $subdiv_code, 
            'chitha_cir_code' => $cir_code, 
            'chitha_mouza_pargona_code' => $mouza_pargona_code, 
            'chitha_lot_no' => $lot_no, 
            'chitha_vill_code' => $vill_townprt_code
            );

         $_SESSION['chitha_report']= $locationData;
        
        // $daginfo = $this->ChithaModel->getDagforchitha($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, 0);
        
        // $daginformation['dagrange'] = $daginfo;

        $pattatype = $this->ChithaModel->pattatypeforchitha();
        $pattatypeinformation['pattatype'] = $pattatype;
        // $chithadetailsmain = array_merge($daginformation, $pattatypeinformation, $maindata);
        $chithadetailsmain = array_merge($pattatypeinformation, $maindata);
        
		$chithadetailsmain['_view'] = 'chitha_report/reportBarak2';
		$this->load->view('layouts/main',$chithadetailsmain);
        
        // echo '<pre>';
        // var_dump($_POST);
        // die();
    }

    public function generateChithaBarak() {
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
            show_error( $errorMessageStr , 401);
                    return;
        }
        
        if (isset($_GET['case_no'])) {
            $case_no = $this->input->get('case_no');
            $district_code = $this->session->userdata('dist_code');
            $subdivision_code = $this->session->userdata('subdiv_code');
            $circlecode = $this->session->userdata('cir_code');
            if (isset($_GET['dag'])) {
                $dag = $this->input->get('dag');
            }
            if ($case_no == '0') {
                ////var_dump($this->session->all_userdata());
                $district_code = $this->session->userdata('dist_code');
                $subdivision_code = $this->session->userdata('subdiv_code');
                $circlecode = $this->session->userdata('cir_code');
                $mouzacode = $this->session->userdata('mouza_pargona_code');
                $lot_code = $this->session->userdata('lot_no');
                $village_code = $this->session->userdata('vill_code');
                $patta_code = $this->session->userdata('patta_type_code');
                $dag_no_lower = $this->session->userdata('dag_no');
                $dag_no_upper = $this->session->userdata('dag_no');
                $dag_no_lower = $dag_no_lower . '00';
                $dag_no_upper = $dag_no_upper . '00';
            } elseif ($case_no == '2') {
                //var_dump($this->session->all_userdata());
                $district_code = $this->session->userdata('dist_code');
                $subdivision_code = $this->session->userdata('subdiv_code');
                $circlecode = $this->session->userdata('cir_code');
                $mouzacode = $this->session->userdata('mouza_pargona_code');
                $lot_code = $this->session->userdata('lot_no');
                $village_code = $this->session->userdata('vill_townprt_code');
                $patta_code = '0201';
                //$dag_no_lower = $this -> session -> userdata('dag_no');
                //$dag_no_upper = $this -> session -> userdata('dag_no');
                $dag_no_lower = $dag . '00';
                $dag_no_upper = $dag . '00';
            } elseif ($case_no == '3') {
                //var_dump($this->session->all_userdata());
                $district_code = $this->session->userdata('dist_code');
                $subdivision_code = $this->session->userdata('subdiv_code');
                $circlecode = $this->session->userdata('cir_code');
                $mouzacode = $this->input->get('m');
                $lot_code = $this->input->get('l');
                $village_code = $this->input->get('v');
                $patta_code = $this->input->get('p');
                //$dag_no_lower = $this -> session -> userdata('dag_no');
                //$dag_no_upper = $this -> session -> userdata('dag_no');
                $dag_no_lower = $dag . '00';
                $dag_no_upper = $dag . '00';
            } elseif ($case_no == '4') {
                //var_dump($this->session->all_userdata());
                $district_code = $this->input->get('dist');
                $subdivision_code = $this->input->get('sub_div');
                $circlecode = $this->input->get('cir');
                $mouzacode = $this->input->get('m');
                $lot_code = $this->input->get('l');
                $village_code = $this->input->get('v');
                $patta_code = $this->input->get('p');
                //$dag_no_lower = $this -> session -> userdata('dag_no');
                //$dag_no_upper = $this -> session -> userdata('dag_no');
                $dag_no_lower = $dag . '00';
                $dag_no_upper = $dag . '00';
            } elseif ($case_no == '1') {
                //this is for land reclassification
                $case_id = $this->input->get('case_id');
                $proposal_no = $this->input->get('proposal_no');
                $t_reclassification = $this->db->query("Select * from t_reclassification where proposal_no = '$proposal_no' and case_no = '$case_id'")->row();
                $district_code = $t_reclassification->dist_code;
                $subdivision_code = $t_reclassification->subdiv_code;
                $circlecode = $t_reclassification->cir_code;
                $mouzacode = $t_reclassification->mouza_pargona_code;
                $lot_code = $t_reclassification->lot_no;
                $village_code = $t_reclassification->vill_townprt_code;

                $patta_code = $t_reclassification->patta_type_code;
                $dag_no_lower = $t_reclassification->dag_no;
                $dag_no_upper = $t_reclassification->dag_no;
                $dag_no_lower = $dag_no_lower . '00';
                $dag_no_upper = $dag_no_upper . '00';
            } else {
                $petition_basic = $this->db->query("Select * from petition_basic where case_no = '$case_no' and dist_code='$district_code' and subdiv_code='$subdivision_code' and cir_code='$circlecode' ")->row();
                $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from petition_dag_details where dist_code='$petition_basic->dist_code' and" . " subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and " . "lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and " . "mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'")->row_array();

                $district_code = $petition_basic->dist_code;
                $subdivision_code = $petition_basic->subdiv_code;
                $circlecode = $petition_basic->cir_code;
                $mouzacode = $petition_basic->mouza_pargona_code;
                $lot_code = $petition_basic->lot_no;
                $village_code = $petition_basic->vill_townprt_code;

                $patta_code = $landdetails['patta_type_code'];
                $dag_no_lower = $landdetails['dag_no'];
                $dag_no_upper = $landdetails['dag_no'];
                $dag_no_lower = $dag_no_lower . '00';
                $dag_no_upper = $dag_no_upper . '00';
            }
        } else {

            $patta_code = $this->input->post('patta_code', true);
            $dag_no_lower = $this->input->post('dag_no_lower', true);
            $dag_no_upper = $dag_no_lower;
            $district_code = $_SESSION['chitha_report']['chitha_dist_code'];
            $subdivision_code = $_SESSION['chitha_report']['chitha_subdiv_code'];
            $circlecode = $_SESSION['chitha_report']['chitha_cir_code'];
            $mouzacode = $_SESSION['chitha_report']['chitha_mouza_pargona_code'];
            $lot_code = $_SESSION['chitha_report']['chitha_lot_no'];
            $village_code = $_SESSION['chitha_report']['chitha_vill_code'];

            // $location = $this->utilityclass->getLocationFromSession();
            // $district_code = $this->session->userdata('chitha_dist_code');
            // $subdivision_code = $this->session->userdata('chitha_subdiv_code');
            // $circlecode = $this->session->userdata('chitha_cir_code');
            // $mouzacode = $this->session->userdata('chitha_mouza_pargona_code');
            // $lot_code = $this->session->userdata('chitha_lot_no');
            // $village_code = $this->session->userdata('chitha_vill_code');
            // $patta_code = $this->input->post('patta_code');
            // $dag_no_lower = $this->input->post('dag_no_lower');
            // $dag_no_upper = $this->input->post('dag_no_upper');
        }

        $this->load->model('chitha/DharChithaModel');

        $dist_name = $this->utilityclass->getDistrictName($district_code);
        $subdiv_name = $this->utilityclass->getSubDivName($district_code, $subdivision_code);
        $cir_name = $this->utilityclass->getCircleName($district_code, $subdivision_code, $circlecode);
        $mouza_pargona_code_name = $this->utilityclass->getMouzaName($district_code, $subdivision_code, $circlecode, $mouzacode);
        $lot_no = $this->utilityclass->getLotName($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code);
        $vill_townprt_code_name = $this->utilityclass->getVillageName($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code);

        $data['location'] = array('dist' => $dist_name, 'sub' => $subdiv_name, 'cir' => $cir_name, 'mouza' => $mouza_pargona_code_name, 'lot' => $lot_no, 'vill' => $vill_townprt_code_name);

        $uuid = $this->utilityclass->getUuid($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code);


        $secondSelection = array('patta_code' => $patta_code, 'dag_no_lower' => $dag_no_lower, 'dag_no_upper' => $dag_no_upper);

        $chithaBasic = $this->db->query('SELECT patta_type_code FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?', [$district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no_lower])->row();

        $pattatype['chithaPattatypeinfo'] = $this->DharChithaModel->getpattatype($chithaBasic->patta_type_code);
        $this->session->set_userdata(array('patta_type' => $pattatype['chithaPattatypeinfo'][0]->patta_type));
        
        $chithainfo1['data'] = $this->DharChithaModel->getchithaDetailsALL($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no_lower, $dag_no_upper);

        $maindataforchitha = array_merge($data, $secondSelection, $chithainfo1, $pattatype);

        if ($dag_no_upper == $dag_no_lower) {
            $maindataforchitha['single_dag'] = '1';
        } else {
            $maindataforchitha['single_dag'] = '0';
        }

        $maindataforchitha['uuid'] = $this->db->query("select uuid from location where dist_code='$district_code' and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and lot_no='$lot_code' and vill_townprt_code='$village_code'")->row();

        // $this->load->helper('language');
        // $district_code = $this->session->userdata('dist_code');
        // if (in_array($district_code, BARAK_VALLEY)) {
        //     $this->lang->load("bengali", "bengali");
        // } else {
        //     $this->lang->load("assamese", "assamese");
        // }
        $maindataforchitha['dag_no_original'] = [];
        foreach ($maindataforchitha['data'] as $key => $value) {
            $maindataforchitha['dag_no_original'][] = $value['dag_no'];
        }

        $maindataforchitha['uuid'] = ['uuid' => $uuid];
        // echo '<pre>';
        // var_dump($maindataforchitha);
        // die();
        $maindataforchitha['_view'] = 'chitha_report/saveChithaReportBarak';
        $this->load->view('layouts/main', $maindataforchitha);

    }

     public function districtDetails_flagged() {
        $this->dataswitch();
        $counts['_view'] = 'chitha_report/report_flagged';
        $this->load->view('layouts/main',$counts);
    }

    public function districtDetails_dc_lao() {
        //var_dump($this->session->userdata('dist_code'));
        // $this->load->helper('html');
        // $this->load->view('header');
        // $this->load->view('chitha_report/reportdclao');
        // $this->load->view('footer');
        $this->dataswitch();
        //var_dump($this->session->all_userdata());
        $counts['_view'] = 'chitha_report/reportdclao';
        $this->load->view('layouts/main',$counts);
    }

     public function districtDetails_dc_lao_flagged() {
        $this->dataswitch();
        $counts['_view'] = 'chitha_report/reportdclao_flagged';
        $this->load->view('layouts/main',$counts);
    }
    
    public function jamadistrictDetails_dc_lao() {
        //var_dump($this->session->userdata('dist_code'));
        // $this->load->helper('html');
        // $this->load->view('header');
        // $this->load->view('chitha_report/JamaAutoUpdate');
        // $this->load->view('footer');
        $counts['_view'] = 'chitha_report/JamaAutoUpdate';
        $this->load->view('layouts/main',$counts);
    }

    public function generateDagChitha() {
        //session_start();
        $this->load->helper('html');
        //$this->load->view('header');
        $this->dataswitch();
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $circle_code = $this->input->post('circle_code');
        $mouza_code = $this->input->post('mouza_code');
        $lot_no = $this->input->post('lot_no');
        $vill_code = $this->input->post('vill_code');

        $this->load->model('misreport/MisModel');

        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
        $lotdata = $this->MisModel->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);
        $maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotdata, $villagedata);

        $locationData= array(
            'chitha_dist_code' => $dist_code, 
            'chitha_subdiv_code' => $subdiv_code, 
            'chitha_cir_code' => $circle_code, 
            'chitha_mouza_pargona_code' => $mouza_code, 
            'chitha_lot_no' => $lot_no, 
            'chitha_vill_code' => $vill_code
        );


        //$this->session->set_userdata($locationData);
         $_SESSION['chitha_report']= $locationData;
        // $this->session->set_flashdata('chitha',$locationData);
        // $_SESSION['id'] = '90';
        
        //var_dump($this->session->userdata('chitha')); 

        $this->load->model('chitha/ChithaModel');
        $daginfo = $this->ChithaModel->getDagforchitha($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, 0);
        //var_dump ($daginfo);
        $daginformation['dagrange'] = $daginfo;

        $pattatype = $this->ChithaModel->pattatypeforchitha();
        $pattatypeinformation['pattatype'] = $pattatype;
        $chithadetailsmain = array_merge($daginformation, $pattatypeinformation, $maindata);
        //redirect('chithareport/viewF');
        //var_dump($chithadetailsmain);
		$chithadetailsmain['_view'] = 'chitha_report/report2';
		$this->load->view('layouts/main',$chithadetailsmain);
        // $this->load->view('chitha_report/report2', $chithadetailsmain);
        // $this->load->view('footer');
    }
    
    function viewF(){
        var_dump($this->session->userdata('chitha')); 
        var_dump($this->session->all_userdata()); 

    }

    public function districtDetails32() {
        //var_dump($this->session->userdata('dist_code'));
        // $this->load->helper('html');
        // $this->load->view('header');
        // $this->load->view('chitha_report/report1new');
        // $this->load->view('footer');

        $data['_view'] = 'chitha_report/report1new';
        $this->load->view('layouts/main',$data);
    }

    public function districtDetails32dclao() {
        //var_dump($this->session->userdata('chitha'));


        $data['_view'] = 'chitha_report/reportnewdclao';
        $this->load->view('layouts/main',$data);
        // $this->load->helper('html');
        // $this->load->view('header');
        // $this->load->view('chitha_report/reportnewdclao');
        // $this->load->view('footer');
    }

    public function generateDagChitha32() {
        // $this->load->helper('html');
        // $this->load->view('header');

        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $circle_code = $this->input->post('circle_code');
        $mouza_code = $this->input->post('mouza_code');
        $lot_no = $this->input->post('lot_no');
        $vill_code = $this->input->post('vill_code');

        $this->load->model('misreport/MisModel');

        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
        $lotdata = $this->MisModel->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);
        $maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotdata, $villagedata);

        $locationData= array(
            'chitha_dist_code' => $dist_code, 
            'chitha_subdiv_code' => $subdiv_code, 
            'chitha_cir_code' => $circle_code, 
            'chitha_mouza_pargona_code' => $mouza_code, 
            'chitha_lot_no' => $lot_no, 
            'chitha_vill_code' => $vill_code
            );

        //$this->session->set_userdata('chitha',$locationData);
        $_SESSION['chitha_report']= $locationData;
        $this->load->model('chitha/ChithaModel');
        $daginfo = $this->ChithaModel->getDagforchitha($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, 0);
        //var_dump ($daginfo);
        $daginformation['dagrange'] = $daginfo;

        $pattatype = $this->ChithaModel->pattatypeforchitha();
        $pattatypeinformation['pattatype'] = $pattatype;
        $chithadetailsmain = array_merge($daginformation, $pattatypeinformation, $maindata);
        ////var_dump($chithadetailsmain);

        // $this->load->view('chitha_report/report2new', $chithadetailsmain);
        // $this->load->view('footer');

        $chithadetailsmain['_view'] = 'chitha_report/report2new';
        $this->load->view('layouts/main',$chithadetailsmain);
    }

    public function getDags($p) {

        //var_dump($_SESSION['chitha_report']);
        $dist_code = $_SESSION['chitha_report']['chitha_dist_code'];
        $subdiv_code =$_SESSION['chitha_report']['chitha_subdiv_code']; //$this->session->userdata('chitha_subdiv_code');
        $circle_code =$_SESSION['chitha_report']['chitha_cir_code']; //$this->session->userdata('chitha_cir_code');
        $mouza_code =$_SESSION['chitha_report']['chitha_mouza_pargona_code'];//$this->session->userdata('chitha_mouza_pargona_code');
        $lot_no =$_SESSION['chitha_report']['chitha_lot_no']; //$this->session->userdata('chitha_lot_no');
        $vill_code =$_SESSION['chitha_report']['chitha_vill_code'];// $this->session->userdata('chitha_vill_code');
        $this->load->model('chitha/ChithaModel');
        
        if($p == 0000)
        {
            $daginfo = $this->ChithaModel->getDagforchithaAll($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);
        }
        else
        {
            $daginfo = $this->ChithaModel->getDagforchitha1111($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $p);
        }
        
        $json = array();

        foreach ($daginfo as $d) {
            $json[] = array('dag' => $d->dag_no, 'dag_no_int' => $d->dag_no_int);
        }
        echo json_encode($json);
    }

    public function getDagMiscCase($p,$dist_code,$subdiv_code,$circle_code,$mouza_code,$lot_no,$vill_code,$pno) {
        $this->load->model('chitha/ChithaModel');

       
        $daginfo = $this->ChithaModel->getDagforchithaMiscCase($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $p,$pno);
        $json = array();

        foreach ($daginfo as $d) {
            $json[] = array('dag' => $d->dag_no, 'dag_no_int' => $d->dag_no_int);
        }
        echo json_encode($json);
    }

    public function getDagslower($l, $p) {
        $this->load->model('chitha/ChithaModel');
        $dist_code = $_SESSION['chitha_report']['chitha_dist_code'];
        $subdiv_code =$_SESSION['chitha_report']['chitha_subdiv_code']; //$this->session->userdata('chitha_subdiv_code');
        $circle_code =$_SESSION['chitha_report']['chitha_cir_code']; //$this->session->userdata('chitha_cir_code');
        $mouza_code =$_SESSION['chitha_report']['chitha_mouza_pargona_code'];//$this->session->userdata('chitha_mouza_pargona_code');
        $lot_no =$_SESSION['chitha_report']['chitha_lot_no']; //$this->session->userdata('chitha_lot_no');
        $vill_code =$_SESSION['chitha_report']['chitha_vill_code'];// $this->session->userdata('chitha_vill_code');

        if($p == 0000)
        {
            $daginfo = $this->ChithaModel->getDagforALLchithalower($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $l);
        }
        else
        {
            $daginfo = $this->ChithaModel->getDagforchithalower($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $l, $p);
        }
        
        $json = array();

        foreach ($daginfo as $d) {
            $json[] = array('dag' => $d->dag_no, 'dag_no_int' => $d->dag_no_int);
        }
        echo json_encode($json);
    }
	
    public function getPattalower($l, $p, $dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code) {
        $this->load->model('chitha/ChithaModel');

        if ($p == 0000) {
            $daginfo = $this->ChithaModel->getPattaforALLchithalower($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $l);
        } else {
            $daginfo = $this->ChithaModel->getPattaforchithalower($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $l, $p);
        }

        $json = array();

        foreach ($daginfo as $d) {
            $json[] = array('patta_no' => $d->patta_no);
        }
        echo json_encode($json);
    }

    public function generateChitha() {
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
                show_error( $errorMessageStr , 401);
                        return;
            }
         //xss & security validation ends 
        $co_note=array(); 
        if (isset($_GET['case_no'])) {
            // above line represents, this block will be worked for GET Request only
            $case_no = $this->input->get('case_no');
            $district_code = $this->session->userdata('dist_code');
            $subdivision_code = $this->session->userdata('subdiv_code');
            $circlecode = $this->session->userdata('cir_code');
			$db=$this->session->userdata('db');
			
            if (isset($_GET['dag'])) {
                $dag = $this->input->get('dag');
            }
            if ($case_no == '0') {
                ////var_dump($this->session->all_userdata());
                $district_code = $this->session->userdata('dist_code');
                $subdivision_code = $this->session->userdata('subdiv_code');
                $circlecode = $this->session->userdata('cir_code');
                $mouzacode = $this->session->userdata('mouza_pargona_code');
                $lot_code = $this->session->userdata('lot_no');
                $village_code = $this->session->userdata('vill_code');
                $patta_code = $this->session->userdata('patta_type_code');
                $dag_no_lower = $this->session->userdata('dag_no');
                $dag_no_upper = $this->session->userdata('dag_no');
                $dag_no_lower = $dag_no_lower . '00';
                $dag_no_upper = $dag_no_upper . '00';
            } elseif ($case_no == '2') {
                //var_dump($this->session->all_userdata());
                $district_code = $this->session->userdata('dist_code');
                $subdivision_code = $this->session->userdata('subdiv_code');
                $circlecode = $this->session->userdata('cir_code');
                $mouzacode = $this->session->userdata('mouza_pargona_code');
                $lot_code = $this->session->userdata('lot_no');
                $village_code = $this->session->userdata('vill_townprt_code');
                $patta_code = '0201';
                //$dag_no_lower = $this -> session -> userdata('dag_no');
                //$dag_no_upper = $this -> session -> userdata('dag_no');
                $dag_no_lower = $dag . '00';
                $dag_no_upper = $dag . '00';
            } elseif ($case_no == '3') {
                //var_dump($this->session->all_userdata());
                $district_code = $this->session->userdata('dist_code');
                $subdivision_code = $this->session->userdata('subdiv_code');
                $circlecode = $this->session->userdata('cir_code');
                $mouzacode = $this->input->get('m');
                $lot_code = $this->input->get('l');
                $village_code = $this->input->get('v');
                $patta_code = $this->input->get('p');
                //$dag_no_lower = $this -> session -> userdata('dag_no');
                //$dag_no_upper = $this -> session -> userdata('dag_no');
                $dag_no_lower = $dag . '00';
                $dag_no_upper = $dag . '00';
            } elseif ($case_no == '4') {
                //var_dump($this->session->all_userdata());
                $district_code = $this->input->get('dist');
                $subdivision_code = $this->input->get('sub_div');
                $circlecode = $this->input->get('cir');
                $mouzacode = $this->input->get('m');
                $lot_code = $this->input->get('l');
                $village_code = $this->input->get('v');
                $patta_code = $this->input->get('p');
                //$dag_no_lower = $this -> session -> userdata('dag_no');
                //$dag_no_upper = $this -> session -> userdata('dag_no');
                $dag_no_lower = $dag . '00';
                $dag_no_upper = $dag . '00';
            } elseif ($case_no == '1') {
                //this is for land reclassification
                $case_id= $this->input->get('case_id');
                $caseIdValidate = caseNumberValidation($case_id, 'Case id');
                if(count($caseIdValidate)){
                    show_error($caseIdValidate['message'], 401);
                    return;
                }

                $proposal_no = $this->input->get('proposal_no');
                $proposalNumberValidate = proposalNumberValidation($proposal_no);
                if(count($proposalNumberValidate)){
                    show_error($proposalNumberValidate['message'], 401);
                    return;
                }

                $t_reclassification = $this->db->query("Select * from  t_reclassification where proposal_no =? and case_no =?", array($proposal_no, $case_id))->row();
                if(!$t_reclassification){
                    log_message('error', '#ERRTRECLASS10001: Data not found in t_reclassification table for proposal_no = ' . $proposal_no . ' and case_no = '. $case_id);
                    show_error('#ERRTRECLASS10001: No such data found', 404);
                    return;
                }
                $district_code = $t_reclassification->dist_code;
                $subdivision_code = $t_reclassification->subdiv_code;
                $circlecode = $t_reclassification->cir_code;
                $mouzacode = $t_reclassification->mouza_pargona_code;
                $lot_code = $t_reclassification->lot_no;
                $village_code = $t_reclassification->vill_townprt_code;

                $patta_code = $t_reclassification->patta_type_code;
                $dag_no_lower = $t_reclassification->dag_no;
                $dag_no_upper = $t_reclassification->dag_no;
                $dag_no_lower = $dag_no_lower . '00';
                $dag_no_upper = $dag_no_upper . '00';
            } else {
                $caseNoValidate = caseNumberValidation($case_no);
                if(count($caseNoValidate)){
                    show_error($caseNoValidate['message'], 401);
                    return;
                }

                $petition_basic = $this->db->query("Select * from   petition_basic where case_no =? and dist_code=? and subdiv_code=? and cir_code=? ", array($case_no, $district_code, $subdivision_code, $circlecode))->row();
                if(!$petition_basic){
                    log_message('error', '#ERRPETBAS10001: Data not found in petition_basic table for case_no = ' . $case_no . ' and dist_code=' . $district_code . ' and subdiv_code=' . $subdivision_code . ' and cir_code=' . $circlecode);
                    show_error('#ERRPETBAS10001: Unable to fetch data', 404);
                    return;
                }
                $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from   petition_dag_details where dist_code=? and  subdiv_code=? and cir_code=? and lot_no=? and vill_townprt_code=? and mouza_pargona_code=? and petition_no=?", array($petition_basic->dist_code, $petition_basic->subdiv_code, $petition_basic->cir_code, $petition_basic->lot_no, $petition_basic->vill_townprt_code, $petition_basic->mouza_pargona_code, $petition_basic->petition_no))->row_array();

                if(!count($landdetails)){
                    log_message('error', '#ERRPETDAGDTL10001: Data not found in petition_dag_details table for dist_code=' . $petition_basic->dist_code . ' and subdiv_code=' . $petition_basic->subdiv_code . ' and cir_code=' . $petition_basic->cir_code . ' and lot_no=' . $petition_basic->lot_no . ' and vill_townprt_code=' . $petition_basic->vill_townprt_code . ' and mouza_pargona_code=' . $petition_basic->mouza_pargona_code . ' and petition_no=' . $petition_basic->petition_no);

                    show_error('#ERRPETDAGDTL10001: Unable to fetch data.', 404);
                    return;
                }

                $district_code = $petition_basic->dist_code;
                $subdivision_code = $petition_basic->subdiv_code;
                $circlecode = $petition_basic->cir_code;
                $mouzacode = $petition_basic->mouza_pargona_code;
                $lot_code = $petition_basic->lot_no;
                $village_code = $petition_basic->vill_townprt_code;

                $patta_code = $landdetails['patta_type_code'];
                $dag_no_lower = $landdetails['dag_no'];
                $dag_no_upper = $landdetails['dag_no'];

                // Added by Abhijit -- 2024-04-25
                if(isset($_GET['dag_no']) && MULTI_DAG_MUTATION_DEED_ACTIVE == 1){
                    $lndDtlsDags = $this->db->query("select dag_no from petition_dag_details where dist_code=? and  subdiv_code=? and cir_code=? and lot_no=? and vill_townprt_code=? and mouza_pargona_code=? and petition_no=?", array($petition_basic->dist_code, $petition_basic->subdiv_code, $petition_basic->cir_code, $petition_basic->lot_no, $petition_basic->vill_townprt_code, $petition_basic->mouza_pargona_code, $petition_basic->petition_no))->result_array();
                    $dags_arr = [];
                    if(count($lndDtlsDags)){
                        foreach($lndDtlsDags as $lndDtlsDag){
                            array_push($dags_arr, $lndDtlsDag['dag_no']);
                        }
                    }
                    
                    if(in_array($_GET['dag_no'], $dags_arr)){
                        $dag_no_lower = $dag_no_upper = $_GET['dag_no'];
                    }
                }

                // $patta_code = $landdetails['patta_type_code'];
                // $dag_no_lower = $landdetails['dag_no'];
                // $dag_no_upper = $landdetails['dag_no'];
                $dag_no_lower = $dag_no_lower . '00';
                $dag_no_upper = $dag_no_upper . '00';
            }
        } else {
            $location = $this->utilityclass->getLocationFromSession();
            ////var_dump($location);
           
            if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
            {

                if (isset($_SESSION['chitha_report'])) 
                {
                    $district_code = $_SESSION['chitha_report']['chitha_dist_code'];
                    $subdivision_code = $_SESSION['chitha_report']['chitha_subdiv_code'];
                    $circlecode = $_SESSION['chitha_report']['chitha_cir_code'];
                    $mouzacode = $_SESSION['chitha_report']['chitha_mouza_pargona_code'];
                    $lot_code  = $_SESSION['chitha_report']['chitha_lot_no'];
                    $village_code = $_SESSION['chitha_report']['chitha_vill_code'];
                } 

                else 
                {
                    ///////////////////////////////////// edit for property chain ///////////////////////////////////////////
                    $district_code = $this->input->get('chitha_dist_code', true);
                    $subdivision_code = $this->input->get('chitha_subdiv_code', true);
                    $circlecode = $this->input->get('chitha_cir_code', true);
                    $mouzacode = $this->input->get('chitha_mouza_pargona_code', true);
                    $lot_code  = $this->input->get('chitha_lot_no', true);
                    $village_code = $this->input->get('chitha_vill_code', true);
                    ////////////////////////////////////////////////////////////////////
                }
            }

            else
            {
                if (isset($_SESSION['chitha_report'])) 
                {
                    $district_code = $_SESSION['chitha_report']['chitha_dist_code'];
                    $subdivision_code = $_SESSION['chitha_report']['chitha_subdiv_code'];
                    $circlecode = $_SESSION['chitha_report']['chitha_cir_code'];
                    $mouzacode = $_SESSION['chitha_report']['chitha_mouza_pargona_code'];
                    $lot_code  = $_SESSION['chitha_report']['chitha_lot_no'];
                    $village_code = $_SESSION['chitha_report']['chitha_vill_code'];
                } 


            }

        //  $dist_code = $_SESSION['chitha_report']['chitha_dist_code'];
        // $subdiv_code =$_SESSION['chitha_report']['chitha_subdiv_code']; //$this->session->userdata('chitha_subdiv_code');
        // $circle_code =$_SESSION['chitha_report']['chitha_cir_code']; //$this->session->userdata('chitha_cir_code');
        // $mouza_code =$_SESSION['chitha_report']['chitha_mouza_pargona_code'];//$this->session->userdata('chitha_mouza_pargona_code');
        // $lot_no =$_SESSION['chitha_report']['chitha_lot_no']; //$this->session->userdata('chitha_lot_no');
        // $vill_code =$_SESSION['chitha_report']['chitha_vill_code'];// $this->session->userdata('chitha_vill_code');

            $patta_code = $this->input->post('patta_code');
            $dag_no_lower = $this->input->post('dag_no_lower');
            $dag_no_upper = $this->input->post('dag_no_upper');

            ///////////////////////////////////// edit for property chain ///////////////////////////////////////////
            if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
            {
                $bhun_flag = false;
                if ($patta_code == null || $dag_no_lower == null || $dag_no_upper == null) {
                    $bhun_flag = true;

                    if ($patta_code == null)
                        $patta_code = $this->input->get('patta_code');
                    if ($dag_no_lower == null)
                        $dag_no_lower = $this->input->get('dag_no_lower');
                    if ($dag_no_upper == null)
                        $dag_no_upper = $this->input->get('dag_no_upper');
                }
            }

            //////// Druno 6/4/22
        
            $get_dag_no_lower = $this->db->query("select dag_no from chitha_basic WHERE 
        dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? and 
        dag_no_int=?",
        array($district_code,$subdivision_code,$circlecode,$mouzacode,$lot_code,$village_code,$dag_no_lower))->row()->dag_no;

            $get_dag_no_upper = $this->db->query("select dag_no from chitha_basic WHERE 
                dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? and dag_no_int=?",
                array($district_code,$subdivision_code,$circlecode,$mouzacode,$lot_code,$village_code,$dag_no_upper))->row()->dag_no;

            $co_note_data = $this->db->query("select chitha_remarks,co_note,dag_no from t_legacyupdation WHERE 
                dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? and dag_no between '$get_dag_no_lower' and '$get_dag_no_upper' and status='F' ",
                array($district_code,$subdivision_code,$circlecode,$mouzacode,$lot_code,$village_code,$get_dag_no_lower));
            if($co_note_data->num_rows() > 0)
            {
                $co_note['co_note'] = $co_note_data->result();
            }else{
                $co_note['co_note']=null;
            }
            //// end Druno
        }
        
        $dist_name = $this->utilityclass->getDistrictName($district_code);
        $subdiv_name = $this->utilityclass->getSubDivName($district_code, $subdivision_code);
        $cir_name = $this->utilityclass->getCircleName($district_code, $subdivision_code, $circlecode);
        $mouza_pargona_code_name = $this->utilityclass->getMouzaName($district_code, $subdivision_code, $circlecode, $mouzacode);
        $lot_no = $this->utilityclass->getLotLocationName($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code);
        $vill_townprt_code_name = $this->utilityclass->getVillageName($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code);
		
        $data['location'] = array('dist' => $dist_name, 'sub' => $subdiv_name, 'cir' => $cir_name, 'mouza' => $mouza_pargona_code_name, 'lot' => $lot_no, 'vill' => $vill_townprt_code_name,'dist_code'=>$district_code,'subdiv_code'=>$subdivision_code,'cir_code'=>$circlecode,'mouza_pargona_code'=>$mouzacode,'lot_no'=>$lot_code,'vill_townprt_code'=>$village_code);
        

        $secondSelection = array('patta_code' => $patta_code, 'dag_no_lower' => $dag_no_lower, 'dag_no_upper' => $dag_no_upper);
        
        $this->load->model('chitha/ChithaModel');
        $pattatype['chithaPattatypeinfo'] = $this->ChithaModel->getpattatype($patta_code);
        $this->session->set_userdata(array('patta_type' => $pattatype['chithaPattatypeinfo'][0]->patta_type));
        
		if ($patta_code != '0000') {
            if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
            $chithainfo1['data'] = $this->ChithaModel->getchithaDetails123Barak($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no_lower, $dag_no_upper, $patta_code);
            }
            else{
            $chithainfo1['data'] = $this->ChithaModel->getchithaDetails123($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no_lower, $dag_no_upper, $patta_code);
			}
        //var_dump($chithainfo1['data']);
		} else {
            if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
            $chithainfo1['data'] = $this->ChithaModel->getchithaDetailsALLBarak($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no_lower, $dag_no_upper);

            }
            else
            {
            $chithainfo1['data'] = $this->ChithaModel->getchithaDetailsALL($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no_lower, $dag_no_upper);
            }
            //$chithainfo1['data'] = $this->ChithaModel->getchithaDetails2($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no_lower, $dag_no_upper);
            //var_dump($chithainfo1);
        }

        //$maindataforchitha = array_merge($data, $secondSelection, $chithainfo1, $pattatype);  //// Druno 6/4/22
        $maindataforchitha = array_merge($data, $secondSelection, $chithainfo1, $pattatype,$co_note);

        //#START PLB

        $dist_code = $this->session->userdata('dist_code');
        if(in_array($dist_code, json_decode(BARAK_VALLEY)))
        {
            $maindataforchitha['_view'] = 'chitha_report/saveChithaReportKar';
        }
        else{
             $maindataforchitha['_view'] = 'chitha_report/saveChithaReport';   
        }
        
        //#END PLB

         /////////////////////////////////////////////////////////Property chain code/////////////////////////////////////////////////////////
        if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {
             $location_id = $district_code . $subdivision_code . $circlecode . $mouzacode . $lot_code . $village_code;

            $prop_chain_button_array = array();

            foreach ($maindataforchitha['data'] as $propChainData) {

                $dag_no = $propChainData['dag_no'];
                $patta_no = $propChainData['patta_no'];
                // $property_id = LOC_TYPE_RURAL . '-' . $village_code . '-' . $patta_no . '-' . $dag_no . '-' . $location_id;
                $patta_type_code = $patta_code;
                $landclass = $propChainData['land_type_code'];
                $bigha = $propChainData['dag_area_b'];
                $katha = $propChainData['dag_area_k'];
                $lessa = $propChainData['dag_area_lc'];

                if(in_array($dist_code, json_decode(BARAK_VALLEY)))
                {
                    $ganda = $propChainData['dag_area_g'];
                }

                else
                {
                    $ganda = '';

                }
                $revenue = $propChainData['dag_revenue'];
                $local_tax = $propChainData['dag_localtax'];

                $get_create_btn = $this->PropChainModel->chainChithaUlpinCheckProcess($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $patta_no, $dag_no, $bigha, $katha, $lessa, $ganda, $patta_type_code);
                // var_dump($get_create_btn);
                if ($get_create_btn['ulpinCheck'] == 1) {
                    if ($bhun_flag) {
                        $caseno = $this->input->get('caseno', true);
                        // $this->db->where(array('case_no' => $caseno, 'dag_no' => substr($dag_no_lower, 0, -2)));
                        // $this->db->update('bhun_map_creation_cases', array('map_for_property' => 'Y'));
                    }

                    $ulpin = $get_create_btn['ulpin'];

                    if ($get_create_btn['chithaPropChainCmpFlag'] == 'NE')
                        $create_btn = $get_create_btn['createPropChainBtn'];
                }
                // get create asset button for old dag no
                if ($bhun_flag) {
                    $old_dag = $this->input->get('old_dag_no', true);
                    $gisCode = $this->blockchainutilityclass->generateGisCode($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code);

                    $ulpinCheck = $this->blockchainutilityclass->checkUlpin($gisCode, ASSAM_STATE_CODE, $old_dag);
                    // var_dump($ulpinCheck);die;
                    if ($ulpinCheck['success'] == 1 && $get_create_btn['ulpinCheck'] == 1) {
                        $maindataforchitha['ulpin_old'] = $ulpinCheck['success'];
                        $maindataforchitha['ulpin_new'] = $get_create_btn['ulpinCheck'];
                        $old_dag_new_ulpin = $ulpinCheck['ulpin'];

                        $this->db->select(array('old_ulpin', 'ulpin', 'patta_type_code', 'patta_no', 'dag_revenue', 'dag_local_tax', 'dag_area_b', 'dag_area_k', 'dag_area_lc', 'dag_area_g'));

                        $old_dag_details = $this->db->get_where('chitha_basic', array('dist_code' => $district_code, 'subdiv_code' => $subdivision_code, 'cir_code' => $circlecode, 'mouza_pargona_code' => $mouzacode, 'lot_no' => $lot_code, 'vill_townprt_code' => $village_code, 'dag_no' => $old_dag))->row();

                        //echo $this->db->last_query();

                        $old_dag_old_ulpin = $old_dag_details->old_ulpin;

                        $old_dag_prop_create_btn = $this->PropChainModel->getPropCreateBtn(
                            $district_code,
                            $subdivision_code,
                            $circlecode,
                            $mouzacode,
                            $lot_code,
                            $village_code,
                            $old_dag,
                            $old_dag_details->patta_no,
                            $old_dag_details->patta_type_code,
                            $old_dag_details->dag_area_b,
                            $old_dag_details->dag_area_k,
                            $old_dag_details->dag_area_lc,
                            $old_dag_details->dag_area_g,
                            $old_dag_details->dag_revenue,
                            $old_dag_details->dag_local_tax,
                            $old_dag_new_ulpin,
                            $old_dag_old_ulpin
                        );

                        // var_dump($district_code,
                        //     $subdivision_code,
                        //     $circlecode,
                        //     $mouzacode,
                        //     $lot_code,
                        //     $village_code,
                        //     $old_dag,
                        //     $old_dag_details->patta_no,
                        //     $old_dag_details->patta_type_code,
                        //     $old_dag_details->dag_area_b,
                        //     $old_dag_details->dag_area_k,
                        //     $old_dag_details->dag_area_lc,
                        //     $old_dag_details->dag_area_g,
                        //     $old_dag_details->dag_revenue,
                        //     $old_dag_details->dag_local_tax,
                        //     $old_dag_new_ulpin,
                        //     $old_dag_old_ulpin,$old_dag_prop_create_btn);die;

                        if ($old_dag_details->old_ulpin == null) {

                            // $this->db->where(array(
                            //     'dist_code' => $district_code, 'subdiv_code' =>
                            //     $subdivision_code,
                            //     'cir_code' => $circlecode,
                            //     'mouza_pargona_code' => $mouzacode,
                            //     'lot_no' => $lot_code,
                            //     'vill_townprt_code' => $village_code, 'dag_no' => $old_dag
                            // ));
                            // $this->db->update('chitha_basic', array('ulpin' => $old_dag_new_ulpin, 'old_ulpin' => $old_dag_old_ulpin));
                            $table = 'chitha_basic';
                            $params = array('ulpin' => $old_dag_new_ulpin, 'old_ulpin' => $old_dag_old_ulpin);
                            $where = array(
                                'dist_code' => $district_code, 'subdiv_code' =>
                                $subdivision_code,
                                'cir_code' => $circlecode,
                                'mouza_pargona_code' => $mouzacode,
                                'lot_no' => $lot_code,
                                'vill_townprt_code' => $village_code, 'dag_no' => $old_dag
                            );
                            // Call model's reusable update method
                            $this->Chitha_basic_model->update_table($table, $params, $where);
                            
                            // echo $this->db->last_query();
                            $maindataforchitha['old_dag_old_old_ulpin'] = null;
                        } else {
                            $maindataforchitha['old_dag_old_old_ulpin'] = $old_dag_details->old_ulpin;
                        }
                        // $maindataforchitha['update_flag'] = $update_flag;
                        $maindataforchitha['old_dag_create_btn'] = $old_dag_prop_create_btn;

                        // $maindataforchitha['old_prop_create_btn'] = $old_dag_prop_create_btn;
                        // $bulkCreateBtn = $this->PropChainModel->getPropCreateBtnBulk(
                        //     $district_code,
                        //     $subdivision_code,
                        //     $circlecode,
                        //     $mouzacode,
                        //     $lot_code,
                        //     $village_code,
                        //     $dag_no,
                        //     $patta_no,
                        //     $patta_type_code,
                        //     $bigha,
                        //     $katha,
                        //     $lessa,
                        //     $ganda,
                        //     $revenue,
                        //     $local_tax,
                        //     $ulpin,
                        //     $old_dag_details->patta_no,
                        //     $old_dag,
                        //     $old_dag_details->patta_type_code,
                        //     $old_dag_new_ulpin,
                        //     $old_dag_details->dag_area_b,
                        //     $old_dag_details->dag_area_k,
                        //     $old_dag_details->dag_area_lc,
                        //     $old_dag_details->dag_area_g,
                        //     $old_dag_details->dag_revenue,
                        //     $old_dag_details->dag_local_tax,
                        //     $old_dag_old_ulpin
                        // );
                        // var_dump(
                        //     $district_code,
                        //     $subdivision_code,
                        //     $circlecode,
                        //     $mouzacode,
                        //     $lot_code,
                        //     $village_code,
                        //     $dag_no,
                        //     $patta_no,
                        //     $patta_type_code,
                        //     $bigha,
                        //     $katha,
                        //     $lessa,
                        //     $ganda,
                        //     $revenue,
                        //     $local_tax,
                        //     $ulpin,
                        //     $old_dag_details->patta_no,
                        //     $old_dag,
                        //     $old_dag_details->patta_type_code,
                        //     $old_dag_new_ulpin,
                        //     $old_dag_details->dag_area_b,
                        //     $old_dag_details->dag_area_k,
                        //     $old_dag_details->dag_area_lc,
                        //     $old_dag_details->dag_area_g,
                        //     $old_dag_details->dag_revenue,
                        //     $old_dag_details->dag_local_tax,
                        //     $old_dag_old_ulpin
                        // );
                        // $maindataforchitha['create_prop_chain_bulk_btn'] = $bulkCreateBtn;
                    }
                }
                ////////////////////////////////////////////////////////////////////////////////////
                if (isset($create_btn))
                    $prop_chain_button_array[] = $create_btn;
                $propertysignature = "base64 encoded signature";
                $propertysignerkey = "base64 encoded public key";
            }

            $maindataforchitha['create_prop_chain_btns'] = $prop_chain_button_array;
        }

        $this->load->view('layouts/main',$maindataforchitha);
    }

    public function modalgenerateChitha() {
        if (isset($_GET['case_no'])) {
            $case_no = $this->input->get('case_no');
			$district_code = $this->session->userdata('dist_code');
            $subdivision_code = $this->session->userdata('subdiv_code');
            $circlecode = $this->session->userdata('cir_code');
            $db = $this->session->userdata('db');
            if ($case_no) {
                $petition_basic = $this->db->query("Select * from   petition_basic where case_no = '$case_no' and dist_code='$district_code' and subdiv_code='$subdivision_code' and cir_code='$circlecode'   ")->row();
				$landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from   petition_dag_details where dist_code='$petition_basic->dist_code' and" . " subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and " . "lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and " . "mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'")->row_array();

                $district_code = $petition_basic->dist_code;
                $subdivision_code = $petition_basic->subdiv_code;
                $circlecode = $petition_basic->cir_code;
                $mouzacode = $petition_basic->mouza_pargona_code;
                $lot_code = $petition_basic->lot_no;
                $village_code = $petition_basic->vill_townprt_code;

                $patta_code = $landdetails['patta_type_code'];
                $dag_no_lower = $landdetails['dag_no'];
                $dag_no_upper = $landdetails['dag_no'];
                $dag_no_lower = $dag_no_lower . '00';
                $dag_no_upper = $dag_no_upper . '00';
            }
         else {
            $location = $this->utilityclass->getLocationFromSession();
            ////var_dump($location);
            $district_code = $this->session->userdata('chitha_dist_code');
            $subdivision_code = $this->session->userdata('chitha_subdiv_code');
            $circlecode = $this->session->userdata('chitha_cir_code');
            $mouzacode = $this->session->userdata('chitha_mouza_pargona_code');
            $lot_code = $this->session->userdata('chitha_lot_no');
            $village_code = $this->session->userdata('chitha_vill_code');

            $patta_code = $this->input->post('patta_code');
            $dag_no_lower = $this->input->post('dag_no_lower');
            $dag_no_upper = $this->input->post('dag_no_upper');
        }
        //echo $dag_no_lower." and patta code".$dag_no_upper;
        $dist_name = $this->utilityclass->getDistrictName($district_code);
        $subdiv_name = $this->utilityclass->getSubDivName($district_code, $subdivision_code);
        $cir_name = $this->utilityclass->getCircleName($district_code, $subdivision_code, $circlecode);
        $mouza_pargona_code_name = $this->utilityclass->getMouzaName($district_code, $subdivision_code, $circlecode, $mouzacode);
        $lot_no = $this->utilityclass->getLotName($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code);
        $vill_townprt_code_name = $this->utilityclass->getVillageName($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code);

        $data['location'] = array('dist' => $dist_name, 'sub' => $subdiv_name, 'cir' => $cir_name, 'mouza' => $mouza_pargona_code_name, 'lot' => $lot_no, 'vill' => $vill_townprt_code_name);
        $secondSelection = array('patta_code' => $patta_code, 'dag_no_lower' => $dag_no_lower, 'dag_no_upper' => $dag_no_upper);
        //$maindataforchitha = array_merge($data,$secondSelection);
        $this->load->model('chitha/ChithaModel');
        $pattatype['chithaPattatypeinfo'] = $this->ChithaModel->getpattatype($patta_code);
        //var_dump($pattatype);
        $this->session->set_userdata(array('patta_type' => $pattatype['chithaPattatypeinfo'][0]->patta_type));
        if ($patta_code != '0000') {
            $chithainfo1['data'] = $this->ChithaModel->getchithaDetails123($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no_lower, $dag_no_upper, $patta_code);
            // echo'hiii';
            //var_dump($chithainfo1);
        } else {
            $chithainfo1['chithainfo'] = $this->ChithaModel->getchithaDetails2($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no_lower, $dag_no_upper);
        }

        $maindataforchitha = array_merge($data, $secondSelection, $chithainfo1, $pattatype);
        //var_dump ($maindataforchitha);
        $content = $this->load->view('chitha_report/saveChithaReport', $maindataforchitha);
        /* $this->load->library('pdf');
          $this->pdf->load_view('chitha_report/saveChithaReport', $maindataforchitha,true);
          $this->pdf->render();
          $this->pdf->stream("welcome.pdf"); */
        //$this -> load -> view('footer');
    }
	}
    public function generateChithaCitizen() {
        $location = $this->utilityclass->getLocationFromSession();
        ////var_dump($location);
        $district_code = $this->session->userdata('dist_code');
        $subdivision_code = $this->session->userdata('subdiv_code');
        $circlecode = $this->session->userdata('cir_code');
        $mouzacode = $this->session->userdata('mouza_pargona_code');
        $lot_code = $this->session->userdata('lot_no');
        $village_code = $this->session->userdata('vill_townprt_code');
        $patta_code = $this->session->userdata('patta_type_code');
        $dag_no_lower = $this->input->post('dag_no') . "00";
        $dag_no_upper = $this->input->post('dag_no') . "00";

        $dist_name = $this->utilityclass->getDistrictName($district_code);
        $subdiv_name = $this->utilityclass->getSubDivName($district_code, $subdivision_code);
        $cir_name = $this->utilityclass->getCircleName($district_code, $subdivision_code, $circlecode);
        $mouza_pargona_code_name = $this->utilityclass->getMouzaName($district_code, $subdivision_code, $circlecode, $mouzacode);
        $lot_no = $this->utilityclass->getLotName($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code);
        $vill_townprt_code_name = $this->utilityclass->getVillageName($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code);

        $data['location'] = array('dist' => $dist_name, 'sub' => $subdiv_name, 'cir' => $cir_name, 'mouza' => $mouza_pargona_code_name, 'lot' => $lot_no, 'vill' => $vill_townprt_code_name);

        //$data['loc']=$location;
        //var_dump($data);
        // $this->load->helper('html');
        // $this->load->view('header');

        //
        // echo  $patta_code.'<br>'.$dag_no_lower.'<br>'.$dag_no_upper;
        $secondSelection = array('patta_code' => $patta_code, 'dag_no_lower' => $dag_no_lower, 'dag_no_upper' => $dag_no_upper);
        //$maindataforchitha = array_merge($data,$secondSelection);
        //var_dump($secondSelection);
        $this->load->model('chitha/ChithaModel');
        $pattatype['chithaPattatypeinfo'] = $this->ChithaModel->getpattatype($patta_code);
        //var_dump($pattatype);
        $this->session->set_userdata(array('patta_type' => $pattatype['chithaPattatypeinfo'][0]->patta_type));
        if ($patta_code != '0000') {
            $chithainfo1['data'] = $this->ChithaModel->getchithaDetails123($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no_lower, $dag_no_upper, $patta_code);
        } else {
            $chithainfo1['chithainfo'] = $this->ChithaModel->getchithaDetails2($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no_lower, $dag_no_upper);
        }
        $maindataforchitha = array_merge($data, $secondSelection, $chithainfo1, $pattatype);
        //  var_dump($data);
        // $this->load->view('chitha_report/saveChithaReport', $maindataforchitha);
        // $this->load->view('footer');

        $maindataforchitha['_view'] = 'chitha_report/saveChithaReport';
        $this->load->view('layouts/main',$maindataforchitha);


    }

    public function generateChithaRegistration() {
        $district_code = $_GET['distcode'];
        //$this->input->post('dist_code');
        $subdivision_code = $_GET['subdivcode'];
        //$this->input->post('subdiv_code');
        $circlecode = $_GET['circlecode'];
        //$this->input->post('cir_code');
        $mouzacode = $_GET['mousacode'];
        //$this->input->post('mouza_pargona_code');
        $lot_code = $_GET['lotno'];
        //$this->input->post('lot_no');
        $village_code = $_GET['villcode'];
        //$this->input->post('vill_code');
        $patta_code = $_GET['pattatype'];
        //$this->input->post('patta_type_code');
        $dag_no_lower = $_GET['dagno'] * 100;
        //$this->input->post('dag_no');
        $dag_no_upper = $_GET['dagno'] * 100;
        //$this->input->post('dag_no');

        $dist_name = $this->utilityclass->getDistrictName($district_code);
        $subdiv_name = $this->utilityclass->getSubDivName($district_code, $subdivision_code);
        $cir_name = $this->utilityclass->getCircleName($district_code, $subdivision_code, $circlecode);
        $mouza_pargona_code_name = $this->utilityclass->getMouzaName($district_code, $subdivision_code, $circlecode, $mouzacode);
        $lot_no = $this->utilityclass->getLotName($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code);
        $vill_townprt_code_name = $this->utilityclass->getVillageName($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code);

        $data['location'] = array('dist' => $dist_name, 'sub' => $subdiv_name, 'cir' => $cir_name, 'mouza' => $mouza_pargona_code_name, 'lot' => $lot_no, 'vill' => $vill_townprt_code_name);

        $secondSelection = array('patta_code' => $patta_code, 'dag_no_lower' => $dag_no_lower, 'dag_no_upper' => $dag_no_upper);

        $this->load->model('chitha/ChithaModel');

        $pattatype['chithaPattatypeinfo'] = $this->ChithaModel->getpattatype($patta_code);

        $this->session->set_userdata(array('patta_type' => $pattatype['chithaPattatypeinfo'][0]->patta_type));
        if ($patta_code != '0000') {
            $chithainfo1['data'] = $this->ChithaModel->getchithaDetails123($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no_lower, $dag_no_upper, $patta_code);
        } else {
            $chithainfo1['chithainfo'] = $this->ChithaModel->getchithaDetails2($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no_lower, $dag_no_upper);
        }

        $maindataforchitha = array_merge($data, $secondSelection, $chithainfo1, $pattatype);

        $content = $this->load->view('chitha_report/saveChithaReport', $maindataforchitha, true);

        header("Access-Control-Allow-Origin: *");

        echo json_encode(array('d' => $content));
    }
    
    public function generateChithaforSro() {
        //var_dump($this->input->get());
        //var_dump($this->session->all_userdata());
        
        $case_no = $this->input->get('case_no');
        
        $district_code = $this->session->userdata('dist_code');
        $subdivision_code = $this->session->userdata('subdiv_code');
        $circlecode = $this->session->userdata('cir_code');
        $mouzacode = $this->input->get('m');
        $lot_code = $this->input->get('l');
        $village_code = $this->input->get('v');
        $patta_code = $this->input->get('p');
        
        $dag = $this->input->get('dag');
        if (isset($_GET['case_no'])) {
            
            if (isset($_GET['dag'])) {
                
            }
            if ($case_no == '0') {
                ////var_dump($this->session->all_userdata());
                $district_code = $this->session->userdata('dist_code');
                $subdivision_code = $this->session->userdata('subdiv_code');
                $circlecode = $this->session->userdata('cir_code');
                $mouzacode = $this->session->userdata('mouza_pargona_code');
                $lot_code = $this->session->userdata('lot_no');
                $village_code = $this->session->userdata('vill_code');
                $patta_code = $this->session->userdata('patta_type_code');
                $dag_no_lower = $this->session->userdata('dag_no');
                $dag_no_upper = $this->session->userdata('dag_no');
                $dag_no_lower = $dag_no_lower . '00';
                $dag_no_upper = $dag_no_upper . '00';
            } elseif ($case_no == '2') {
                //var_dump($this->session->all_userdata());
                $district_code = $this->session->userdata('dist_code');
                $subdivision_code = $this->session->userdata('subdiv_code');
                $circlecode = $this->session->userdata('cir_code');
                $mouzacode = $this->session->userdata('mouza_pargona_code');
                $lot_code = $this->session->userdata('lot_no');
                $village_code = $this->session->userdata('vill_townprt_code');
                $patta_code = '0201';
                //$dag_no_lower = $this -> session -> userdata('dag_no');
                //$dag_no_upper = $this -> session -> userdata('dag_no');
                $dag_no_lower = $dag . '00';
                $dag_no_upper = $dag . '00';
            } elseif ($case_no == '3') {
                //var_dump($this->session->all_userdata());
                $district_code = $this->session->userdata('dist_code');
                $subdivision_code = $this->session->userdata('subdiv_code');
                $circlecode = $this->session->userdata('cir_code');
                
                //$dag_no_lower = $this -> session -> userdata('dag_no');
                //$dag_no_upper = $this -> session -> userdata('dag_no');
                $dag_no_lower = $dag . '00';
                $dag_no_upper = $dag . '00';
            } elseif ($case_no == '4') {
                //var_dump($this->session->all_userdata());
                $district_code = $this->input->get('dist');
                $subdivision_code = $this->input->get('sub_div');
                $circlecode = $this->input->get('cir');
                $mouzacode = $this->input->get('m');
                $lot_code = $this->input->get('l');
                $village_code = $this->input->get('v');
                $patta_code = $this->input->get('p');
                //$dag_no_lower = $this -> session -> userdata('dag_no');
                //$dag_no_upper = $this -> session -> userdata('dag_no');
                $dag_no_lower = $dag . '00';
                $dag_no_upper = $dag . '00';
            } elseif ($case_no == '1') {
                //this is for land reclassification
                $proposal_no = $this->input->get('proposal_no');
                $t_reclassification = $this->db->query("Select * from   t_reclassification where proposal_no = '$proposal_no'")->row();
                $district_code = $t_reclassification->dist_code;
                $subdivision_code = $t_reclassification->subdiv_code;
                $circlecode = $t_reclassification->cir_code;
                $mouzacode = $t_reclassification->mouza_pargona_code;
                $lot_code = $t_reclassification->lot_no;
                $village_code = $t_reclassification->vill_townprt_code;

                $patta_code = $t_reclassification->patta_type_code;
                $dag_no_lower = $t_reclassification->dag_no;
                $dag_no_upper = $t_reclassification->dag_no;
                $dag_no_lower = $dag_no_lower . '00';
                $dag_no_upper = $dag_no_upper . '00';
            } else {
                $petition_basic = $this->db->query("Select * from   petition_basic where case_no = '$case_no' and dist_code='$district_code' and subdiv_code='$subdivision_code' and cir_code='$circlecode' ")->row();
                $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from   petition_dag_details where dist_code='$petition_basic->dist_code' and" . " subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and " . "lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and " . "mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'")->row_array();

                $district_code = $petition_basic->dist_code;
                $subdivision_code = $petition_basic->subdiv_code;
                $circlecode = $petition_basic->cir_code;
                $mouzacode = $petition_basic->mouza_pargona_code;
                $lot_code = $petition_basic->lot_no;
                $village_code = $petition_basic->vill_townprt_code;

                $patta_code = $landdetails['patta_type_code'];
                $dag_no_lower = $landdetails['dag_no'];
                $dag_no_upper = $landdetails['dag_no'];
                $dag_no_lower = $dag_no_lower . '00';
                $dag_no_upper = $dag_no_upper . '00';
            }
        } else {
            $location = $this->utilityclass->getLocationFromSession();
            ////var_dump($location);
            $district_code = $this->session->userdata('chitha_dist_code');
            $subdivision_code = $this->session->userdata('chitha_subdiv_code');
            $circlecode = $this->session->userdata('chitha_cir_code');
            $mouzacode = $this->session->userdata('chitha_mouza_pargona_code');
            $lot_code = $this->session->userdata('chitha_lot_no');
            $village_code = $this->session->userdata('chitha_vill_code');

            $patta_code = $this->input->post('patta_code');
            $dag_no_lower = $this->input->post('dag_no_lower');
            $dag_no_upper = $this->input->post('dag_no_upper');
        }
        
        $dist_name = $this->utilityclass->getDistrictName($district_code);
        $subdiv_name = $this->utilityclass->getSubDivName($district_code, $subdivision_code);
        $cir_name = $this->utilityclass->getCircleName($district_code, $subdivision_code, $circlecode);
        $mouza_pargona_code_name = $this->utilityclass->getMouzaName($district_code, $subdivision_code, $circlecode, $mouzacode);
        $lot_no = $this->utilityclass->getLotLocationName($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code);
        $vill_townprt_code_name = $this->utilityclass->getVillageName($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code);

        $data['location'] = array('dist' => $dist_name, 'sub' => $subdiv_name, 'cir' => $cir_name, 'mouza' => $mouza_pargona_code_name, 'lot' => $lot_no, 'vill' => $vill_townprt_code_name);
        

        $secondSelection = array('patta_code' => $patta_code, 'dag_no_lower' => $dag_no_lower, 'dag_no_upper' => $dag_no_upper);
        
        $this->load->model('chitha/ChithaModel');
        $pattatype['chithaPattatypeinfo'] = $this->ChithaModel->getpattatype($patta_code);
        //var_dump($pattatype);
        $this->session->set_userdata(array('patta_type' => $pattatype['chithaPattatypeinfo'][0]->patta_type));
        if ($patta_code != '0000') {
            $chithainfo1['data'] = $this->ChithaModel->getchithaDetails123($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no_lower, $dag_no_upper, $patta_code);
            //var_dump($chithainfo1);
        } else {
            $chithainfo1['data'] = $this->ChithaModel->getchithaDetailsALL($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no_lower, $dag_no_upper);
            //$chithainfo1['data'] = $this->ChithaModel->getchithaDetails2($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no_lower, $dag_no_upper);
            //var_dump($chithainfo1);
        }

        $maindataforchitha = array_merge($data, $secondSelection, $chithainfo1, $pattatype);
        //var_dump ($data);
        // $this->load->helper('html');
        // $this->load->view('header');
        // $content = $this->load->view('chitha_report/saveChithaReport', $maindataforchitha);
        // $this->load->view('footer');

        $maindataforchitha['_view'] = 'chitha_report/saveChithaReport';
        $this->load->view('layouts/main',$maindataforchitha);
    }


    public function dataswitch(){       
     $CI=&get_instance();
     if($this->session->userdata('dist_code') == "02"){
        $this->db=$CI->load->database('dha3', TRUE);    
     } else if($this->session->userdata('dist_code') == "05"){
        $this->db=$CI->load->database('dha1', TRUE);    
      } else if($this->session->userdata('dist_code') == "10"){
        $this->db=$CI->load->database('dha24', TRUE);       
     } else if($this->session->userdata('dist_code') == "13"){
        $this->db=$CI->load->database('dha2', TRUE);    
     }  else if($this->session->userdata('dist_code') == "17"){
        $this->db=$CI->load->database('dha4', TRUE);    
     }  else if($this->session->userdata('dist_code') == "15"){
        $this->db=$CI->load->database('dha5', TRUE);    
     }  else if($this->session->userdata('dist_code') == "14"){
        $this->db=$CI->load->database('dha6', TRUE);    
     }  else if($this->session->userdata('dist_code') == "07"){
        $this->db=$CI->load->database('dha7', TRUE);    
     }  else if($this->session->userdata('dist_code') == "03"){
        $this->db=$CI->load->database('dha8', TRUE);    
     }  else if($this->session->userdata('dist_code') == "18"){
        $this->db=$CI->load->database('dha9', TRUE);    
     }  else if($this->session->userdata('dist_code') == "12"){
        $this->db=$CI->load->database('dha13', TRUE);   
     }  else if($this->session->userdata('dist_code') == "24"){
        $this->db=$CI->load->database('dha10', TRUE);   
     }  else if($this->session->userdata('dist_code') == "06"){
        $this->db=$CI->load->database('dha11', TRUE);   
     }  else if($this->session->userdata('dist_code') == "11"){
        $this->db=$CI->load->database('dha12', TRUE);   
     }  else if($this->session->userdata('dist_code') == "12"){
        $this->db=$CI->load->database('dha13', TRUE);   
     }  else if($this->session->userdata('dist_code') == "16"){
        $this->db=$CI->load->database('dha14', TRUE);   
     }  else if($this->session->userdata('dist_code') == "32"){
        $this->db=$CI->load->database('dha15', TRUE);   
     }  else if($this->session->userdata('dist_code') == "33"){
        $this->db=$CI->load->database('dha16', TRUE);   
     }  else if($this->session->userdata('dist_code') == "34"){
        $this->db=$CI->load->database('dha17', TRUE);   
     }  else if($this->session->userdata('dist_code') == "21"){
        $this->db=$CI->load->database('dha18', TRUE);   
     }  else if($this->session->userdata('dist_code') == "22"){
        $this->db=$CI->load->database('dha41', TRUE);   
     }  else if($this->session->userdata('dist_code') == "08"){
        $this->db=$CI->load->database('dha19', TRUE);   
     }  else if($this->session->userdata('dist_code') == "35"){
        $this->db=$CI->load->database('dha20', TRUE);   
     }  else if($this->session->userdata('dist_code') == "36"){
        $this->db=$CI->load->database('dha21', TRUE);   
     }  else if($this->session->userdata('dist_code') == "37"){
        $this->db=$CI->load->database('dha22', TRUE);   
     }  else if($this->session->userdata('dist_code') == "25"){
        $this->db=$CI->load->database('dha23', TRUE);   
     }                                                                                                                                                                                                              
}

}
