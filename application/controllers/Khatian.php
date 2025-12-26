<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Khatian extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mutation/mutationmodel');
        $this->load->helper(array('form', 'url', 'Language'));
         $this->dbswitch();
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

    public function index() {

        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            //var_dump($this->input->post());
            $this->session->set_userdata(array('tenants' => $this->input->post()));

            
            redirect(base_url() . "index.php/Khatian/khatian");
        } else if ($this->input->server('REQUEST_METHOD') == 'GET') {

      //     var_dump($this->session->all_userdata());
      // exit;
            // $this->load->helper('html');
            // $this->load->view('../views/header');
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $data = $this->mutationmodel->getVillageCodeJSON($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
            $district['villages'] = $data;

            // var_dump($data);
            // exit;
            // $this->load->view('../views/Khatian/index', $district);
            // $this->load->view('../views/footer');

            $district['_view'] = 'Khatian/index';
            $this->load->view('layouts/main',$district);
        }
    }

    public function khatian() {
        // $this->load->helper('html');
        // $this->load->view('../views/header');



        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $tenants = $this->session->userdata('tenants');
            $d = $tenants['dist_code'];
            $s = $tenants['subdiv_code'];
            $c = $tenants['circle_code'];
            $m = $tenants['mouza_code'];
            $l = $tenants['lot_no'];
            $v = $tenants['vill_code'];

            $st = $this->input->post('start');
            $end = $this->input->post('end');
            $query = "select * from khatian as c where c.dist_code='$d' and c.subdiv_code='$s' and "
                    . " c.cir_code='$c' and c.mouza_pargona_code='$m' and c.lot_no='$l' and c.vill_townprt_code='$v' and  c.id BETWEEN $st AND $end";
            //echo $query;
            $kts = $this->db->query($query)->result();
            $allData = array();
            foreach ($kts as $kt) {
                //var_dump($kt);
                $query = "select distinct on (tenant_name, tenants_father) * from chitha_tenant where dist_code='$d' and subdiv_code='$s' and "
                        . " cir_code='$c' and mouza_pargona_code='$m' and lot_no='$l' and vill_townprt_code='$v' and khatian_no=$kt->id ";
                //echo $query;
                $allData[$kt->id][$kt->dag_no]['tenants'] = $this->db->query($query)->result();
                //var_dump($allData);
                $query = "select * from chitha_basic where dist_code='$d' and subdiv_code='$s' and "
                        . " cir_code='$c' and mouza_pargona_code='$m' and lot_no='$l' and vill_townprt_code='$v' and dag_no='$kt->dag_no'";
                //echo $query;
                $allData[$kt->id][$kt->dag_no]['cb'] = $this->db->query($query)->result();
                $query = " select * from chitha_pattadar cp,chitha_dag_pattadar dp where TRIM(cp.patta_no)=TRIM(dp.patta_no) and cp.patta_type_code=dp.patta_type_code and"
                        . " cp.dist_code=dp.dist_code and cp.subdiv_code=dp.subdiv_code and "
                        . " cp.cir_code=dp.cir_code and cp.mouza_pargona_code=dp.mouza_pargona_code and cp.lot_no=dp.lot_no and "
                        . "cp.vill_townprt_code =dp.vill_townprt_code and cp.pdar_id = dp.pdar_id and dp.dist_code='$d' and dp.subdiv_code='$s' and "
                        . " dp.cir_code='$c' and dp.mouza_pargona_code='$m' and dp.lot_no='$l' and dp.vill_townprt_code='$v' and dp.dag_no='$kt->dag_no' and dp.p_flag!='1'"
                        . "";
                
                $allData[$kt->id][$kt->dag_no]['pattadars'] = $this->db->query($query)->result();
                $query = "select * from khatian where dist_code='$d' and subdiv_code='$s' and "
                        . " cir_code='$c' and mouza_pargona_code='$m' and lot_no='$l' and vill_townprt_code='$v'  and dag_no='$kt->dag_no'";
               // echo $query;
                $allData[$kt->id][$kt->dag_no]['khatians'] =$this->db->query($query)->result();
                $query = "select co_remarks from khatian where dist_code='$d' and subdiv_code='$s' and "
                        . " cir_code='$c' and mouza_pargona_code='$m' and lot_no='$l' and vill_townprt_code='$v'  and dag_no='$kt->dag_no'";
                $remarks = $this->db->query($query)->row();
                $allData[$kt->id][$kt->dag_no]['co_remarks'] = $remarks;

                //documents 
                $sql="Select case_no,file_name,file_path,id from supportive_document  where case_no=? order by id desc";
                $documents=$this->db->query($sql,array($kt->app_id))->result_array();
                $allData[$kt->id][$kt->dag_no]['documents'] = $documents;

            }
            $data['all'] = $allData;
            // echo "<pre>";
            // var_dump($data['all']);
            // exit;
            //$this->load->view('../views/khatian/khatian', $data);

             $data['_view'] = 'khatian/khatian';
            $this->load->view('layouts/main',$data);
        } else if ($this->input->server('REQUEST_METHOD') == 'GET') {

            $tenants = $this->session->userdata('tenants');
            $d = $tenants['dist_code'];
            $s = $tenants['subdiv_code'];
            $c = $tenants['circle_code'];
            $m = $tenants['mouza_code'];
            $l = $tenants['lot_no'];
            $v = $tenants['vill_code'];
            $query = "select distinct khatian_no from chitha_tenant where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and "
                    . " mouza_pargona_code='$m' and lot_no='$l' and vill_townprt_code='$v' order by khatian_no";

            $data['khatians'] = $this->db->query($query)->result();
            //$this->load->view('../views/khatian/khatian_range', $data);

            $data['_view'] = 'Khatian/khatian_range';
            $this->load->view('layouts/main',$data);
        }
        //$this->load->view('../views/footer');
    }

    //******** 06.07.2022 *******//
    public function khatianSelectLocationForLm()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $data['villages'] = $this->mutationmodel->getVillageCodeJSON($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $data['_view'] = 'Khatian/khatian_select_location_for_lm';
        $this->load->view('layouts/main',$data);
    }
    // Khatian Update----
    public function khatianSelectLocationForLmUpdt()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $data['mouza'] = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);
        
        $data['villages'] = $this->mutationmodel->getVillageCodeJSON($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $data['_view'] = 'Khatian/khatian_select_location_for_lm_update';
        $this->load->view('layouts/main',$data);
    }

    public function getKhatianNoVillage() {
        $data = array();
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $vill_townprt_code = $this->input->post('vill_townprt_code');

        $khatians = $this->mutationmodel->getKhatianDetails($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code);
        // return $khatians;
            $json = array();
            foreach ($khatians as $object) {
                $json[] = array('khatian_no' => $object->id);
            }
            echo json_encode($json);
        }
    public function getKhatianExistOrNot() {
        $data = array();
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $vill_townprt_code = $this->input->post('vill_townprt_code');
        $khatian_no = $this->input->post('khatian_no');
        $where  = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code,
            'id' => $khatian_no
        );
        $khatians = $this->mutationmodel->checkKhatianExistorNot('khatian','id', $where);
        // $khatians = $this->mutationmodel->checkKhatianExistorNot($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$khatian_no);
        $error = array();
        if($khatians>0){
            $error['error_code'] = 'Khatian already exist. try another khatian no.';
        }else{
            $error['error_code'] = null;
        }
        
        echo json_encode($error);
        }
    //end----

    /***** Khatian Form ******/
    public function khatianViewTenantForm()
    {
        $this->form_validation->set_rules('vill_code', 'Village','required|trim|strip_tags|xss_clean|interger|callback_villageCodeCheck|exact_length[5]');
        $this->form_validation->set_rules('khatian_no', 'Khatian No', 'required|trim|integer|callback_khatianCheckInCOLevel|callback_khatianCheckInRevertBack');

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $data['villages'] = $this->mutationmodel->getVillageCodeJSON($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        if ($this->form_validation->run() == FALSE) {
            $data['_view'] = 'Khatian/khatian_select_location_for_lm';
            $this->load->view('layouts/main', $data);
        }else{
            $vill_code = $this->input->post('vill_code');
            $khatian_no = $this->input->post('khatian_no');

            $value=$this->checkKhatianExist($vill_code,$khatian_no);
            if($value==0){
                $query = "select * from tenant_type";
                $data['tenant_type'] = $this->db->query($query)->result();
                $data['dist_code'] = $this->session->userdata('dist_code');
                $data['subdiv_code'] = $this->session->userdata('subdiv_code');
                $data['cir_code'] = $this->session->userdata('cir_code');
                $data['mouza_pargona_code'] = $this->session->userdata('mouza_pargona_code');
                $data['lot_no'] = $this->session->userdata('lot_no');
                $data['vill_code'] = $vill_code;
                $data['app_id'] = time();
                $data['khatian_no'] = $khatian_no;
                $data['_view'] = 'Khatian/add_tenant';
                $this->load->view('layouts/main',$data);
            }else{
                $query = "select * from tenant_type";
                $data['tenant_type'] = $this->db->query($query)->result();
                $data['dist_code'] = $this->session->userdata('dist_code');
                $data['subdiv_code'] = $this->session->userdata('subdiv_code');
                $data['cir_code'] = $this->session->userdata('cir_code');
                $data['mouza_pargona_code'] = $this->session->userdata('mouza_pargona_code');
                $data['lot_no'] = $this->session->userdata('lot_no');
                $data['vill_code'] = $vill_code;
                $data['app_id'] = time();
                $data['khatian_no'] = $khatian_no;
                $data['khatian_status'] = 'Y';
                $data['_view'] = 'Khatian/update_tenant_khatian_form';
                $this->load->view('layouts/main',$data);
            }
        }
    }

    /***** Khatian Form ******/
    public function khatianViewTenantFormUpdate()
    {
        $this->form_validation->set_rules('khatian_no', 'khatian no','required|trim|xss_clean|integer');
        $this->form_validation->set_rules('new_khatian_no', 'New khatian no','required|trim|xss_clean|integer');
        $this->form_validation->set_rules('remarks_co', 'Remarks','required|trim|xss_clean|alpha_numeric');
        // $this->form_validation->set_rules('vill_code', 'Village','required|trim|strip_tags|xss_clean|interger|callback_villageCodeCheck|exact_length[5]');
        // $this->form_validation->set_rules('khatian_no', 'Khatian No', 'required|trim|integer|callback_khatianCheckInCOLevel|callback_khatianCheckInRevertBack');

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $data['mouza'] = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);
        // $data['villages'] = $this->mutationmodel->getVillageCodeJSON($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        if ($this->form_validation->run() == FALSE) {
            $data['_view'] = 'Khatian/khatian_select_location_for_lm_update';
            $this->load->view('layouts/main', $data);
        }else{

            $circle_code = $this->input->post('circle_code');
            $mouza_code = $this->input->post('mouza_code');
            $lot_no = $this->input->post('lot_no');
            $vill_code = $this->input->post('vill_code');
            $khatian_no = $this->input->post('khatian_no');
            $new_khatian_no = $this->input->post('new_khatian_no');
            $remarks_co = $this->input->post('remarks_co');
            $checkKhatian = $this->getKhatianExistOrNotCall($dist_code,$subdiv_code,$circle_code,$mouza_code,$lot_no,$vill_code,$new_khatian_no);
            if($checkKhatian == true){
                $this->session->set_flashdata('message',"Khatian No already exist...please enter another no.");
                redirect(base_url() . "index.php/Khatian/khatianSelectLocationForLmUpdt");
                return;
            }
    
            $this->db->trans_begin();
            $flag = false;
            $where  = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'id' => $khatian_no
                );
            $where_chitha  = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'khatian_no' => $khatian_no
            );
            $whereDelete  = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'id' => $new_khatian_no
            );
            $whereDeleteChitha  = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'khatian_no' => $new_khatian_no
            );
            

            $FinalUpdateKhatian = $this->mutationmodel->finalUpdateKhatianByCO($dist_code,$subdiv_code,$circle_code,$mouza_code,$lot_no,$vill_code,$khatian_no,$new_khatian_no,date('Y-m-d H:i:s'),$remarks_co);
            $FinalUpdateChitha = $this->mutationmodel->finalUpdateKhatianChithaByCO($dist_code,$subdiv_code,$circle_code,$mouza_code,$lot_no,$vill_code,$khatian_no,$new_khatian_no,date('Y-m-d H:i:s'));

           
            if($FinalUpdateKhatian == 0 && $FinalUpdateChitha == 0){
                $this->db->trans_rollback();
                $data['error_save'] = true;
                $data['error_msg'] = "#KHA10007 Unable to submit data";
                log_message("error", "#KHA10007 Unable to update data
                        for dist_code: " . $this->session->userdata('dist_code'));
                $this->session->set_flashdata('message',"Unable to submit data due to technical Glitch-");
                redirect(base_url() . "index.php/Khatian/khatianSelectLocationForLmUpdt");
                return;
            }
            $fetchData = $this->mutationmodel->getAllRecordsKhatian('khatian', $where);
            $fetchChithaData = $this->mutationmodel->getAllRecordsKhatian('chitha_tenant', $where_chitha);
            $JSONData = json_encode($fetchData);
            $JSONChithaData = json_encode($fetchChithaData);
            $dataInsert = array(
                'dist_code'                    => $dist_code,
                'subdiv_code'                  => $subdiv_code,
                'cir_code'                     => $circle_code,
                'mouza_pargona_code'           => $mouza_code,
                'lot_no'                       => $lot_no,
                'vill_townprt_code'            => $vill_code,
                'old_khatian_no'               => $khatian_no,
                'created_date'                 => date('Y-m-d H:i:s'),
                'updated_date'                 => date('Y-m-d H:i:s'),
                'deleted_khatian_records'      => $JSONData,
                'deleted_khatian_chitha_records' => $JSONChithaData
            );

            $deletedDataInsert = $this->mutationmodel->deletedDataInsert('khatian_deleted_records',$dataInsert);
            if($deletedDataInsert == false){
                $this->db->trans_rollback();
                $data['error_save'] = true;
                $data['error_msg'] = "#KHA10008 Unable to submit deleted data";
               
                $this->session->set_flashdata('message',"Unable to keep old data due to technical Glitch");
                redirect(base_url() . "index.php/Khatian/khatianSelectLocationForLmUpdt");
            }
            // $deletedData = array(
            //     'deleted_khatian_records' => $JSONData
            // );
            // $this->mutationmodel->updateDeletedRecords('khatian_deleted_records',$whereDelete,$deletedData);
            // $deletedChithaData = array(
            //     'deleted_khatian_chitha_records' => $JSONChithaData
            // );
            // $this->mutationmodel->updateDeletedRecords('khatian_deleted_records',$whereDeleteChitha,$deletedChithaData);
            $sql = "select uuid from location where dist_code=?
                and subdiv_code=? and cir_code=?
                and mouza_pargona_code=? and lot_no=? and vill_townprt_code=?";
            $uuid = $this->db->query($sql,array($dist_code,$subdiv_code,
                $circle_code,$mouza_code,$lot_no,$vill_code))->row()->uuid;
            $proceeding_id = $this->db->query("select max(proceeding_id)+1 as c from khatian_proceeding where
                        uuid=? and khatian_no=? and status is null?", array($uuid, $khatian_no))->row()->c;
            $proceeding['khatian_no'] = $new_khatian_no;
            $proceeding['proceeding_id'] = $proceeding_id;
            $proceeding['note'] = "Updated by CO";
            $proceeding['note_on_order'] = $this->input->post('lm_note');
            $proceeding['created_date'] = date('Y-m-d H:i:s');
            $proceeding['user_code'] = $this->session->userdata('user_code');
            $proceeding['operation'] = "E";
            $proceeding['uuid'] = $uuid;
            $proceeding['dist_code'] = $dist_code;
            $proceeding['subdiv_code'] = $subdiv_code;
            $proceeding['cir_code'] = $circle_code;
            $proceeding['mouza_pargona_code'] = $mouza_code;
            $proceeding['lot_no'] = $lot_no;
            $proceeding['vill_townprt_code'] = $vill_code;
            $khatian_proceeding = $this->db->insert('khatian_proceeding', $proceeding);
            if($khatian_proceeding != 1)
                {
                    $this->db->trans_rollback();
                    $data['error_save'] = true;
                    $data['error_msg'] = "#KHA10008 Unable to submit data";
                    log_message("error", "#KHA10008 Unable to insert data into khatian_proceeding
                            for dist_code: " . $this->session->userdata('dist_code'));
                    $this->session->set_flashdata('message',"Unable to submit data due to technical Glitch1");
                    redirect(base_url() . "index.php/Khatian/khatianSelectLocationForLmUpdt");
                }
            if ($this->db->trans_status() === FALSE || $flag == true)
            {
                $this->db->trans_rollback();
                $data['error_save'] = true;
                $data['error_msg'] = "#KHA10009 Unable to submit data";
                log_message("error", "#KHA10009 Unable to update data
                        for dist_code: " . $this->session->userdata('dist_code'));
                log_message("error1",$this->db->last_query());
                $this->session->set_flashdata('message',"Unable to submit data due to technical Glitch2");
                redirect(base_url() . "index.php/Khatian/khatianSelectLocationForLmUpdt");
            }
            else
            {
                $where  = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'id' => $khatian_no
                );
                $where1  = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'khatian_no' => $khatian_no
                );
                $fetchData = $this->mutationmodel->getAllRecordsKhatian('khatian', $where);

                $deleteOldKhatianData = $this->mutationmodel->deleteKhatianDetails('khatian',$where);
                $deleteOldKhatianChithaData = $this->mutationmodel->deleteKhatianDetails('chitha_tenant',$where1);
                if($deleteOldKhatianData != 1 && $deleteOldKhatianChithaData != 1){
                    $this->db->trans_rollback();
                    $data['error_save'] = true;
                    $data['error_msg'] = "#KHA10010 Unable to submit data";
                    log_message("error", "#KHA10010 Unable to update data
                            for dist_code: " . $this->session->userdata('dist_code'));
                    $this->session->set_flashdata('message',"Unable to submit data due to technical Glitch");
                    redirect(base_url() . "index.php/Khatian/khatianSelectLocationForLmUpdt");
                }
                $this->db->trans_commit();
                $this->session->set_flashdata('message',"Khatian No. ".$khatian_no." Updated to New Khatian No. ".$new_khatian_no." Successfully...");
                redirect(base_url() . "index.php/Khatian/khatianSelectLocationForLmUpdt");
            }
        }
    }

    public function checkKhatianExist($vill_code,$khatian) {
        $d = $this->session->userdata('dist_code');
        $s = $this->session->userdata('subdiv_code');
        $c = $this->session->userdata('cir_code');
        $m = $this->session->userdata('mouza_pargona_code');
        $l = $this->session->userdata('lot_no');
        $v = $vill_code;
        $id = $khatian;
        $exists = $this->db->query("select count(*) as c from chitha_tenant where 
        dist_code=? and subdiv_code=? and cir_code=? and "
            . " mouza_pargona_code=? and lot_no=?
        and vill_townprt_code=? and khatian_no=? ",array($d,$s,$c,$m,$l,$v,$id))->row()->c;
        return($exists);
    }

    /********** Khatian check in co level *******/
    public function khatianCheckInCOLevel($khatian_no)
    {
        $d = $this->session->userdata('dist_code');
        $s = $this->session->userdata('subdiv_code');
        $c = $this->session->userdata('cir_code');
        $m = $this->session->userdata('mouza_pargona_code');
        $l = $this->session->userdata('lot_no');
        $v = $this->input->post('vill_code');

        $exists = $this->db->query("select count(*) as c from temp_khatian where 
        dist_code=? and subdiv_code=? and cir_code=? and "
            . " mouza_pargona_code=? and lot_no=?
        and vill_townprt_code=? and khatian_no=? and status=?",array($d,$s,$c,$m,$l,$v,$khatian_no,'P'))->row()->c;
        if ($exists == 0) {
            return TRUE;
        } else {
            $this->form_validation->set_message('khatianCheckInCOLevel', 'Khatian already in CO level.');
            return FALSE;
        }
    }

    /********** Khatian check in LM Reverted *******/
    public function khatianCheckInRevertBack($khatian_no)
    {
        $d = $this->session->userdata('dist_code');
        $s = $this->session->userdata('subdiv_code');
        $c = $this->session->userdata('cir_code');
        $m = $this->session->userdata('mouza_pargona_code');
        $l = $this->session->userdata('lot_no');
        $v = $this->input->post('vill_code');

        $exists = $this->db->query("select count(*) as c from temp_khatian where 
        dist_code=? and subdiv_code=? and cir_code=? and "
            . " mouza_pargona_code=? and lot_no=?
        and vill_townprt_code=? and khatian_no=? and status=?",array($d,$s,$c,$m,$l,$v,$khatian_no,'L'))->row()->c;
        if ($exists == 0) {
            return TRUE;
        } else {
            $this->form_validation->set_message('khatianCheckInRevertBack', 'Khatian available in Revert back from CO tab (LM level).');
            return FALSE;
        }
    }

    /******** CHECK VILLAGE CODE CALL BACK FUNCTION *********/
    public function villageCodeCheck($vill_code)
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $vill_code;

        $villages_code_check = $this->db->query("select vill_townprt_code from location where 
            dist_code =?  and subdiv_code=? and 
            cir_code=? and mouza_pargona_code=? and  lot_no=? 
            and vill_townprt_code=?",
            array($dist_code, $subdiv_code, $cir_code,
                $mouza_pargona_code, $lot_no, $vill_code));
        if ($villages_code_check->num_rows() == 1) {
            return TRUE;
        } else {
            $this->form_validation->set_message('villageCodeCheck', 'This %s is invalid');
            return FALSE;
        }
    }

    //******* save Tenant ********//
    public function saveTenant(){
        $dist_code = $this->session->userdata('dist_code');
        $this->form_validation->set_rules('app_id', 'Session Id', 'required|trim|xss_clean|integer');
        $this->form_validation->set_rules('khatian_no', 'Khatian No', 'required|trim|xss_clean|integer');
        $this->form_validation->set_rules('tenant_name', 'Name', 'required|trim|xss_clean|max_length[100]');
        $this->form_validation->set_rules('tenant_gurdian', 'Gurdian Name', 'required|trim|xss_clean|max_length[100]');
        $this->form_validation->set_rules('tenant_add1', 'Address', 'required|trim|xss_clean|max_length[100]');
        $this->form_validation->set_rules('tenant_add2', 'Second Address', 'trim|xss_clean|max_length[100]');
        $this->form_validation->set_rules('bigha', 'Bigha', 'required|trim|is_natural|xss_clean');
        if(in_array($dist_code, json_decode(BARAK_VALLEY))){
            $this->form_validation->set_rules('katha', 'Katha', 'required|trim|is_natural|xss_clean|less_than[20]');
            $this->form_validation->set_rules('lessa', 'Lessa', 'required|trim|numeric|xss_clean|less_than[15]');
            $this->form_validation->set_rules('ganda', 'Ganda', 'required|trim|numeric|xss_clean|less_than[20]');
            $this->form_validation->set_rules('kranti', 'Kranti', 'required|trim|numeric|xss_clean|max_length[2]');
        }else{
            $this->form_validation->set_rules('katha', 'Katha', 'required|trim|is_natural|xss_clean|less_than[5]');
            $this->form_validation->set_rules('lessa', 'Lessa', 'required|trim|numeric|xss_clean|less_than[20]');
        }
        $this->form_validation->set_rules('vill_code', 'Village','required|trim|xss_clean|interger|callback_villageCodeCheck|exact_length[5]');
        $this->form_validation->set_rules('tenant_type', 'Tenant Type','required|trim|xss_clean|interger|exact_length[2]');
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            echo json_encode(['error'=>$errors]);
            return;
        }else{
            $data['success'] = true;
            $app_id = $this->input->post('app_id');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->input->post('vill_code');;

            $sql = "select uuid from location where dist_code=?
                and subdiv_code=? and cir_code=?
                and mouza_pargona_code=? and lot_no=? and vill_townprt_code=?";
            $uuid = $this->db->query($sql,array($dist_code,$subdiv_code,
                $cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code))->row()->uuid;

            $array['app_id'] = $app_id;
            $array['dist_code'] = $dist_code;
            $array['subdiv_code'] = $subdiv_code;
            $array['cir_code'] = $cir_code;
            $array['mouza_pargona_code'] = $mouza_pargona_code;
            $array['lot_no'] = $lot_no;
            $array['vill_townprt_code'] = $vill_townprt_code;
            $array['uuid'] = $uuid;
            $array['tenant_name'] = $this->input->post('tenant_name');
            $array['tenants_father'] = $this->input->post('tenant_gurdian');
            $array['tenants_add1'] = $this->input->post('tenant_add1');
            $array['tenants_add2'] = $this->input->post('tenant_add2');
            $array['type_of_tenant'] = $this->input->post('tenant_type');
            $array['khatian_no'] = $this->input->post('khatian_no');
            $array['bigha'] = $this->input->post('bigha');
            $array['katha'] = $this->input->post('katha');
            $array['lessa'] = $this->input->post('lessa');
            $array['ganda'] = $this->input->post('ganda');
            $array['kranti'] = $this->input->post('kranti');
            $array['created_date'] = date('Y-m-d H:i:s');
            $array['user_code'] = $this->session->userdata('user_code');

            $tenant_save = $this->db->insert('temp_tenant', $array);
            $data['temp_tenant'] = null;
            if($tenant_save == true)
            {
                $data['tenant_save'] = true;
                $data['temp_tenant'] = $this->db->query("select temp.*,type.tenant_type  from temp_tenant as temp
            INNER JOIN tenant_type as type ON temp.type_of_tenant = type.type_code where temp.app_id=? order by id desc",$app_id)->result();
            }
            else
            {
                $data['tenant_save'] = false;
                $data['tenant_msg'] = "#KHA10001 Error in inserting data";
                log_message("error", "#KHA10001 Error in inserting in temp_tenant
                                for dist_code: " . $this->session->userdata('dist_code'));
            }
        }
        echo json_encode($data);
        return;
    }

    /********* DELETE TENANT SINGLE ROW *******/
    public function deleteTempTenant()
    {
        $app_id = $this->input->post('app_id');
        $row_id = $this->input->post('row_id');

        $sql = "select count(*) as c from temp_tenant where app_id=?";
        $check_temp_tenant = $this->db->query($sql,array($app_id))->row()->c;
        if($check_temp_tenant == 1)
        {
            $json = array(
                'delete_tenant' => "Add one more Tenant then you can delete selected one.",
                'tenant_details' => null,
            );
            echo json_encode($json);
            return;
        }

        $delete_tenant = $this->db->delete('temp_tenant',
            array('id' => $row_id, 'app_id' => $app_id));

        if($this->db->affected_rows() != 1)
        {
            log_message("error", "#KHA10002 Unable to delete data from temp_tenant
                                for dist_code: " . $this->session->userdata('dist_code'));
            $json = array(
                'delete_tenant' => "#KHA10002 Unable to delete data",
                'tenant_details' => null,
            );
            echo json_encode($json);
            return;
        }
        $tenant_details =  $this->db->query("select temp.*,type.tenant_type  from temp_tenant as temp
            INNER JOIN tenant_type as type ON temp.type_of_tenant = type.type_code where temp.app_id=? order by id desc ",$app_id)->result();
        $json = array(
            'delete_tenant' => $delete_tenant,
            'tenant_details' => $tenant_details,
        );
        echo json_encode($json);
    }
    /**** END DELETE TENANT *********/

    /********* TENANT NEXT BUTTON ***********/
    public function tenantNextButton()
    {
        $app_id = $this->input->post('app_id');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->input->post('vill_code');

        $tenant_row = 0;
        $tenant_dags = null;
        $chitha_dag = null;

        $tenant = $this->db->query("SELECT * from temp_tenant WHERE app_id=?",
            array($app_id));
        if($tenant->num_rows() > 0)
        {
            $tenant_row = $tenant->num_rows();

            $chitha_dag = $this->db->query("SELECT dag_no from chitha_basic WHERE 
            patta_type_code in (select type_code from patta_code where jamabandi='y') AND
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? order by dag_no_int ASC ",
                array($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_code))->result();
        }

        $json = array(
            'tenant_row' => $tenant_row,
            'chitha_dag' => $chitha_dag,
        );
        echo json_encode($json);
    }
    /*********** END TENANT NEX BUTTON ********/

    //******* save Khatian Basic ********//
    public function saveKhatianBasic(){
        if($this->session->userdata('user_desig_code') !='LM')
        {
            return;
        }
        $dist_code = $this->session->userdata('dist_code');
        $this->form_validation->set_rules('app_id', 'Session Id', 'required|trim|xss_clean|integer');
        $this->form_validation->set_rules('khatian_no', 'Khatian No', 'required|trim|xss_clean|integer');
        $this->form_validation->set_rules('dag_no', 'Dag No', 'required|trim|xss_clean|integer|callback_dagNoCheck');
        $this->form_validation->set_rules('length_posession', 'Length Possession', 'required|trim|xss_clean|max_length[3]|integer');
        // $this->form_validation->set_rules('tenant_status', 'Tenant Status', 'required|trim|xss_clean|max_length[200]');
        // $this->form_validation->set_rules('paid_cash_kind', 'Paid Cash', 'required|trim|xss_clean|max_length[200]');
        // $this->form_validation->set_rules('payable_cash_kind', 'Payable Cash', 'required|trim|xss_clean|max_length[200]');
        // $this->form_validation->set_rules('special_conditions', 'Special Conditions', 'required|trim|xss_clean|max_length[500]');
        $this->form_validation->set_rules('remarks', 'Remarks', 'required|trim|xss_clean|max_length[1000]');
        $this->form_validation->set_rules('vill_code', 'Village','required|trim|xss_clean|integer|callback_villageCodeCheck|exact_length[5]');
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            echo json_encode(['error'=>$errors]);
            return;
        }else{
            $data['success'] = true;
            $app_id = $this->input->post('app_id');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->input->post('vill_code');

            $sql = "select uuid from location where dist_code=?
                and subdiv_code=? and cir_code=?
                and mouza_pargona_code=? and lot_no=? and vill_townprt_code=?";
            $uuid = $this->db->query($sql,array($dist_code,$subdiv_code,
                $cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code))->row()->uuid;

            $chitha_data ="select dag_revenue from chitha_basic where dist_code=?
                    and subdiv_code=? and cir_code=?
                    and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
            $chitha_result = $this->db->query($chitha_data,array($dist_code,$subdiv_code,
                $cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$this->input->post('dag_no')))->row_array();

            $array['app_id'] = $app_id;
            $array['dist_code'] = $dist_code;
            $array['subdiv_code'] = $subdiv_code;
            $array['cir_code'] = $cir_code;
            $array['mouza_pargona_code'] = $mouza_pargona_code;
            $array['lot_no'] = $lot_no;
            $array['vill_townprt_code'] = $vill_townprt_code;
            $array['uuid'] = $uuid;
            $array['dag_no'] = $this->input->post('dag_no');
            $array['revenue_tenant'] = $chitha_result['dag_revenue'];
            $array['length_posession'] = $this->input->post('length_posession');
            $array['tenant_status'] = $this->input->post('tenant_status');
            $array['paid_cash_kind'] = $this->input->post('paid_cash_kind');
            $array['payable_cash_kind'] = $this->input->post('payable_cash_kind');
            $array['khatian_no'] = $this->input->post('khatian_no');
            $array['special_conditions'] = $this->input->post('special_conditions');
            $array['remarks'] = $this->input->post('remarks');
            $array['created_date'] = date('Y-m-d H:i:s');
            $array['user_code'] = $this->session->userdata('user_code');

            $khatian_save = $this->db->insert('temp_khatian', $array);
            $data['temp_khatian'] = null;
            if($khatian_save == true)
            {
                $data['khatian_save'] = true;
                $data['temp_khatian'] = $this->db->query("select *  from temp_khatian where app_id=? order by id desc ",$app_id)->result();
            }
            else
            {
                $data['khatian_save'] = false;
                $data['khatian_msg'] = "#KHA10003 Error in inserting data";
                log_message("error", "#KHA10003 Error in inserting in temp_khatian
                                for dist_code: " . $this->session->userdata('dist_code'));
            }
        }
        echo json_encode($data);
        return;
    }

    /******* Dag No Check ***********/
    public function dagNoCheck($dag)
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->input->post('vill_code');
        $app_id = $this->input->post('app_id');

        $dag_check = $this->db->query("select dag_no from chitha_basic where 
            patta_type_code in (select type_code from patta_code where jamabandi='y') AND
            dist_code =?  and subdiv_code=? and 
            cir_code=? and mouza_pargona_code=? and  lot_no=? 
            and vill_townprt_code=? and dag_no=?",
            array($dist_code, $subdiv_code, $cir_code,
                $mouza_pargona_code, $lot_no, $vill_code,$dag));
        if ($dag_check->num_rows() == 1) {
            $dag_check2 = $this->db->query("select * from temp_khatian where 
            app_id =?  and dag_no=?",
                array($app_id, $dag));
            if ($dag_check2->num_rows() > 0) {
                $this->form_validation->set_message('dagNoCheck', 'You already added same dag');
                return FALSE;
            } else {
                $sql = "SELECT pdar_id FROM Chitha_dag_pattadar WHERE dist_code = ? 
                        and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? 
                        and lot_no = ? and vill_townprt_code = ? and  dag_no=? and p_flag !='1' ";
                $pdar_check = $this->db->query($sql, array($dist_code, $subdiv_code, $cir_code,
                                $mouza_pargona_code, $lot_no, $vill_code,$dag));
                if ($pdar_check->num_rows() <= 0) {
                    $this->form_validation->set_message('dagNoCheck', 'No Pattadar exists for the Selected Dag');
                    return FALSE;
                }
                return true;
            }
        } else {
            $this->form_validation->set_message('dagNoCheck', 'This %s is invalid');
            return FALSE;
        }
    }

    /********* DELETE Khatian SINGLE ROW *******/
    public function deleteTempKhatian()
    {
        if($this->session->userdata('user_desig_code') !='LM')
        {
            return;
        }
        $app_id = $this->input->post('app_id');
        $row_id = $this->input->post('row_id');

        $sql = "select count(*) as c from temp_khatian where app_id=?";
        $check_temp_khatian = $this->db->query($sql,array($app_id))->row()->c;
        if($check_temp_khatian == 1)
        {
            $json = array(
                'delete_khatian' => "Add one more Khatian Basic then you can delete selected one.",
                'khatian_details' => null,
            );
            echo json_encode($json);
            return;
        }

        $delete_khatian = $this->db->delete('temp_khatian',
            array('id' => $row_id, 'app_id' => $app_id));

        if($this->db->affected_rows() != 1)
        {
            log_message("error", "#KHA10004 Unable to delete data from temp_khatian
                                for dist_code: " . $this->session->userdata('dist_code'));
            $json = array(
                'delete_khatian' => "#KHA10004 Unable to delete data",
                'khatian_details' => null,
            );
            echo json_encode($json);
            return;
        }
        $khatian_details =  $this->db->query("select *  from temp_khatian where app_id=? order by id desc ",$app_id)->result();
        $json = array(
            'delete_khatian' => $delete_khatian,
            'khatian_details' => $khatian_details,
        );
        echo json_encode($json);
    }
    /**** END DELETE Khatian *********/

    /********* KHATIAN NEXT BUTTON ***********/
    public function khatianNextButton()
    {
        $app_id = $this->input->post('app_id');

        $khatian_row = 0;
        $khatian_details = null;

//        $khatian = $this->db->query("SELECT * from temp_khatian WHERE app_id=?",
//            array($app_id));

        $query = "select t.*, c.dag_area_b,c.dag_area_k,c.dag_area_lc,c.dag_area_g,c.dag_area_kr from
        temp_khatian as t join chitha_basic as c ON t.dag_no::varchar = c.dag_no 
        and t.dist_code = c.dist_code and t.subdiv_code = c.subdiv_code 
        and t.cir_code = c.cir_code and t.mouza_pargona_code = c.mouza_pargona_code 
        and t.lot_no = c.lot_no and t.vill_townprt_code = c.vill_townprt_code
        where t.app_id=? order by id desc";
        $khatian = $this->db->query($query,array($app_id));

        if($khatian->num_rows() > 0)
        {
            $khatian_row = $khatian->num_rows();
            $tenant_details =  $this->db->query("select temp.*,type.tenant_type  from temp_tenant as temp
            INNER JOIN tenant_type as type ON temp.type_of_tenant = type.type_code where temp.app_id=? order by id desc ",$app_id)->result();
//            $khatian_details = $this->db->query("SELECT * from temp_khatian WHERE app_id=? order by id desc ", array($app_id))->result();
            $khatian_details = $khatian->result();
        }


        $sql="Select case_no,file_name,file_path,id from supportive_document  where case_no=? order by id desc";
        $documents=$this->db->query($sql,array($app_id))->result_array();
        // var_dump($documents);
        // die;
        // if ($row->num_rows()>0){
        //         $rowData=$row->row_array();
        //         echo json_encode(array(
        //         'responseType' => 2,
        //         'application_id' => $app_id,
        //         'doc_file'=> $rowData['file_name'],
        //         'doc_id' => $rowData['id'],
        //         'file_path' => $rowData['file_path'],
        //     ));
        //     return;
        // }else{
        //     echo json_encode(array(
        //         'responseType' => 3,
        //         'error' => 'Something Went wrong--3!!!'
        //     ));
        //     return;
        // }

        $json = array(
            'khatian_row' => $khatian_row,
            'tenant_details' => $tenant_details,
            'khatian_details' => $khatian_details,
            'documents' => $documents,
        );
        echo json_encode($json);
    }
    /*********** END KHATIAN NEX BUTTON ********/

    //******* save Khatian Final Submit for LM ********//
    public function submitFinalKhatianByLm(){
        if($this->session->userdata('user_desig_code') !='LM')
        {
            return;
        }
        $dist_code = $this->session->userdata('dist_code');
        $this->form_validation->set_rules('app_id', 'Session Id', 'required|trim|xss_clean|integer');
        $this->form_validation->set_rules('khatian_no', 'Khatian No', 'required|trim|xss_clean|integer');
        $this->form_validation->set_rules('vill_code', 'Village','required|trim|xss_clean|interger|callback_villageCodeCheck|exact_length[5]');
        $this->form_validation->set_rules('lm_note', 'LM Report', 'required|trim|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            echo json_encode(['error'=>$errors]);
            return;
        }else{
            $data['success'] = true;
            $app_id = $this->input->post('app_id');
            $khatian_no = $this->input->post('khatian_no');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->input->post('vill_code');

            $sql = "select uuid from location where dist_code=?
                and subdiv_code=? and cir_code=?
                and mouza_pargona_code=? and lot_no=? and vill_townprt_code=?";
            $uuid = $this->db->query($sql,array($dist_code,$subdiv_code,
                $cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code))->row()->uuid;

            $sql2 = "select * from temp_tenant where app_id=? and uuid=? and khatian_no=?";
            $tenants_data = $this->db->query($sql2,array($app_id,$uuid,$khatian_no));

            $sql3 = "select * from temp_khatian where app_id=? and uuid=? and khatian_no=?";
            $khatian_data = $this->db->query($sql3,array($app_id,$uuid,$khatian_no));
            $this->db->trans_begin();
            $flag = false;
            if($khatian_data->num_rows() > 0){
                if($tenants_data->num_rows() > 0){
                    $update_tenant="Update temp_tenant set status=? where uuid=? and 
                    app_id=? and khatian_no=?";
                    $this->db->query($update_tenant,array('P',$uuid,$app_id,$khatian_no));

                    if( $this->db->affected_rows() != $tenants_data->num_rows())
                    {
                        $flag = true;
                        $this->db->trans_rollback();
                        $data['error_save'] = true;
                        $data['error_msg'] = "#KHA10005 Unable to submit data";
                        log_message("error", "#KHA10005 Unable to update data into temp_tenant
                                for dist_code: " . $this->session->userdata('dist_code'));
                        echo json_encode($data);
                        return;
                    }

                    $update_khatian="Update temp_khatian set status=? where uuid=? and 
                    app_id=? and khatian_no=?";
                    $this->db->query($update_khatian,array('P',$uuid,$app_id,$khatian_no));

                    if( $this->db->affected_rows() != $khatian_data->num_rows())
                    {
                        $flag = true;
                        $this->db->trans_rollback();
                        $data['error_save'] = true;
                        $data['error_msg'] = "#KHA10006 Unable to submit data";
                        log_message("error", "#KHA10006 Unable to update data into temp_khatian
                                for dist_code: " . $this->session->userdata('dist_code'));
                        echo json_encode($data);
                        return;
                    }
                    $khatian = $khatian_data->row();
                    $proceeding_id = $this->db->query("select max(proceeding_id)+1 as c from khatian_proceeding where
                        uuid=? and khatian_no=? and status is null?", array($uuid, $khatian_no))->row()->c;

                    if($proceeding_id == null)
                    {
                        $proceeding_id = 1;
                    }
                    $proceeding['khatian_no'] = $khatian_no;
                    $proceeding['proceeding_id'] = $proceeding_id;
                    $proceeding['note'] = "Submitted by LM";
                    $proceeding['note_on_order'] = $this->input->post('lm_note');
                    $proceeding['created_date'] = date('Y-m-d H:i:s');
                    $proceeding['user_code'] = $this->session->userdata('user_code');
                    $proceeding['operation'] = "E";
                    $proceeding['uuid'] = $uuid;
                    $proceeding['dist_code'] = $khatian->dist_code;
                    $proceeding['subdiv_code'] = $khatian->subdiv_code;;
                    $proceeding['cir_code'] = $khatian->cir_code;;
                    $proceeding['mouza_pargona_code'] = $khatian->mouza_pargona_code;;
                    $proceeding['lot_no'] = $khatian->lot_no;;
                    $proceeding['vill_townprt_code'] = $khatian->vill_townprt_code;;

                    $khatian_proceeding = $this->db->insert('khatian_proceeding', $proceeding);
                    if($khatian_proceeding != 1)
                    {
                        $this->db->trans_rollback();
                        $data['error_save'] = true;
                        $data['error_msg'] = "#KHA10008 Unable to submit data";
                        log_message("error", "#KHA10008 Unable to insert data into khatian_proceeding
                                for dist_code: " . $this->session->userdata('dist_code'));
                        echo json_encode($data);
                        return;
                    }

                    if ($this->db->trans_status() === FALSE || $flag == true)
                    {
                        $this->db->trans_rollback();
                        $data['error_save'] = true;
                        $data['error_msg'] = "#KHA10007 Unable to submit data";
                        log_message("error", "#KHA10007 Unable to update data
                                for dist_code: " . $this->session->userdata('dist_code'));
                        echo json_encode($data);
                        return;
                    }
                    else
                    {
                        $this->db->trans_commit();
                        $this->session->set_flashdata('message',"Khatian ".$khatian_no." Submitted Successfully, Forwarded to CO !!");
                        $data['error_save'] = false;
                        echo json_encode($data);
                        return;
                    }
                }
            }
        }
    }

    //******* khatian list for co ********//
    public function khatianListForCo()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $sql = "select dist_code,subdiv_code,
                cir_code,mouza_pargona_code,lot_no,vill_townprt_code,khatian_no,uuid,app_id
                from temp_khatian where status=? and dist_code=? and subdiv_code=? and cir_code=?
                group by dist_code,subdiv_code,
                cir_code,mouza_pargona_code,lot_no,vill_townprt_code,khatian_no,uuid,app_id";
        $khatian_data = $this->db->query($sql,array('P',$dist_code,$subdiv_code,$cir_code));
        $data['khatian'] = null;
        if($khatian_data->num_rows()>0)
        {
            $data['khatian'] = $khatian_data->result();
        }
        $data['_view'] = 'Khatian/khatian_list_for_co';
        $this->load->view('layouts/main',$data);
    }

    public function proreport() {
        $db=  $this->session->userdata('db');
        $khatian_no = $this->input->get('khatian');
        $uuid = $this->input->get('uuid');
        $data['case_no'] = $khatian_no;
        $query = "select * from khatian_proceeding where khatian_no=? and uuid=? and status is null";
        $details = $this->db->query($query,array($khatian_no,$uuid))->result();
        $data['details'] = $details;
        $this->load->helper('html');
        $this->load->view('../views/Khatian/proreport', $data);
    }

    /**** Co VIEW KHATIAN *******/
    public function khatianCoFinalView()
    {
        if($this->session->userdata('user_desig_code') !='CO')
        {
            return;
        }
        $app_id = $this->input->get('app_id');
        $khatian_no = $this->input->get('khatian');
        $uuid = $this->input->get('uuid');

//        $query = "select * from temp_khatian where app_id=? and khatian_no=? and uuid=?";
//        $data['khatians'] = $this->db->query($query,array($app_id,$khatian_no,$uuid))->result();

        $query = "select t.*, c.dag_area_b,c.dag_area_k,c.dag_area_lc,c.dag_area_g,c.dag_area_kr from
        temp_khatian as t join chitha_basic as c ON t.dag_no::varchar = c.dag_no 
        and t.dist_code = c.dist_code and t.subdiv_code = c.subdiv_code 
        and t.cir_code = c.cir_code and t.mouza_pargona_code = c.mouza_pargona_code 
        and t.lot_no = c.lot_no and t.vill_townprt_code = c.vill_townprt_code
        where t.app_id=? and t.khatian_no=? and t.uuid=?";
        $data['khatians'] = $this->db->query($query,array($app_id,$khatian_no,$uuid))->result();

        $data['tenants'] = $this->db->query("select temp.*,type.tenant_type  from temp_tenant as temp
            INNER JOIN tenant_type as type ON temp.type_of_tenant = type.type_code where
            temp.app_id=? and temp.khatian_no=? and temp.uuid=?",array($app_id,$khatian_no,$uuid))->result();

        $data['dist_code'] = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $this->session->userdata('subdiv_code');
        $data['cir_code'] = $this->session->userdata('cir_code');
        $data['mouza_pargona_code'] = $data['khatians'][0]->mouza_pargona_code;
        $data['lot_no'] = $data['khatians'][0]->lot_no;
        $data['vill_code'] = $data['khatians'][0]->vill_townprt_code;

        $sql="Select case_no,file_name,file_path,id from supportive_document  where case_no=? order by id desc";
        $data['documents'] = $documents=$this->db->query($sql,array($app_id))->result_array();
        $data['_view'] = 'Khatian/khatian_co_final_view';
        $this->load->view('layouts/main',$data);
    }

    //******* save Khatian Final Submit BY CO ********//
    public function submitFinalKhatianByCo(){
        if($this->session->userdata('user_desig_code') !='CO')
        {
            return;
        }
        $dist_code = $this->session->userdata('dist_code');
        $this->form_validation->set_rules('app_id', 'Session Id', 'required|trim|xss_clean|integer');
        $this->form_validation->set_rules('khatian_no', 'Khatian No', 'required|trim|xss_clean|integer');
        $this->form_validation->set_rules('uuid', 'Village Unique Code', 'required|trim|xss_clean|integer');
        $this->form_validation->set_rules('co_note', 'CO Report', 'required|trim|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            echo json_encode(['error'=>$errors]);
            return;
        }else{
            $data['success'] = true;
            $app_id = $this->input->post('app_id');
            $uuid = $this->input->post('uuid');
            $khatian_no = $this->input->post('khatian_no');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');

            $sql2 = "select * from temp_tenant where app_id=? and uuid=? and khatian_no=?";
            $tenants_data = $this->db->query($sql2,array($app_id,$uuid,$khatian_no));

            $sql3 = "select * from temp_khatian where app_id=? and uuid=? and khatian_no=?";
            $khatian_data = $this->db->query($sql3,array($app_id,$uuid,$khatian_no));
            $this->db->trans_begin();
            $flag = false;
            $tenant_id = 1;
            if($khatian_data->num_rows() > 0){
                $khatians = $khatian_data->result_array();



                if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
               {

                   $this->load->model('propChain/PropChainCommonModel');
                   $block_status=$this->PropChainCommonModel->checkDagExistsInPropChain($dist_code,$subdiv_code,$cir_code,$khatians[0]['mouza_pargona_code'],
                        $khatians[0]['lot_no'],$khatians[0]['vill_townprt_code'],$khatians[0]['dag_no']);

                   if($block_status==true){

                       $this->session->set_flashdata('message', "Backlog Entry cannot be passed for the given Dag as it is in Property chain!!");
                       redirect(base_url() . "index.php/home");
                       return;
                   }

               }



                $sql4 = "select count(*) as c from chitha_tenant where 
                dist_code=? and subdiv_code=? and cir_code=? 
                and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and khatian_no=?";
                $check_exist_tenant = $this->db->query($sql4,
                    array($dist_code,$subdiv_code,$cir_code,$khatians[0]['mouza_pargona_code'],
                    $khatians[0]['lot_no'],$khatians[0]['vill_townprt_code'],$khatian_no))->row()->c;

                if($check_exist_tenant > 0)
                {
                    $sql8 = "DELETE FROM chitha_tenant WHERE dist_code=? and subdiv_code=? and cir_code=? 
                    and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and khatian_no=?";
                    $delete_chitha_tenant = $this->db->query($sql8,
                        array($dist_code,$subdiv_code,$cir_code,$khatians[0]['mouza_pargona_code'],
                        $khatians[0]['lot_no'],$khatians[0]['vill_townprt_code'],$khatian_no));

                    if($this->db->affected_rows() != $check_exist_tenant)
                    {
                        $flag = true;
                        $this->db->trans_rollback();
                        $data['error_save'] = true;
                        $data['error_msg'] = "#KHA10017 Unable to delete old records";
                        log_message("error", "#KHA10017 Unable to delete old record from chitha_tenant
                                for dist_code: " . $this->session->userdata('dist_code'));
                        echo json_encode($data);
                        return;
                    }
                }

                $sql19 = "select count(*) as c from khatian where 
                dist_code=? and subdiv_code=? and cir_code=? 
                and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and id=?";
                $check_exist_khatian = $this->db->query($sql19,
                    array($dist_code,$subdiv_code,$cir_code,$khatians[0]['mouza_pargona_code'],
                        $khatians[0]['lot_no'],$khatians[0]['vill_townprt_code'],$khatian_no))->row()->c;

                if($check_exist_khatian > 0)
                {
                    $sql8 = "DELETE FROM khatian WHERE dist_code=? and subdiv_code=? and cir_code=? 
                    and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and id=?";
                    $delete_khatian = $this->db->query($sql8,
                        array($dist_code,$subdiv_code,$cir_code,$khatians[0]['mouza_pargona_code'],
                            $khatians[0]['lot_no'],$khatians[0]['vill_townprt_code'],$khatian_no));

                    if($this->db->affected_rows() != $check_exist_khatian)
                    {
                        $flag = true;
                        $this->db->trans_rollback();
                        $data['error_save'] = true;
                        $data['error_msg'] = "#KHA10018 Unable to delete old records";
                        log_message("error", "#KHA10018 Unable to delete old record from khatian
                                for dist_code: " . $this->session->userdata('dist_code'));
                        echo json_encode($data);
                        return;
                    }
                }


                

                $update_temp_tenant="Update temp_tenant set status=? where uuid=? and
                app_id=? and khatian_no=?";
                $this->db->query($update_temp_tenant,array('F',$uuid,$app_id,$khatian_no));

                if($this->db->affected_rows() != $tenants_data->num_rows())
                {
                    $flag = true;
                    $this->db->trans_rollback();
                    $data['error_save'] = true;
                    $data['error_msg'] = "#KHA10020 Unable to update into Tenant";
                    log_message("error", "#KHA10020 Unable to update into temp_tenant
                                    for dist_code: " . $this->session->userdata('dist_code'));
                    echo json_encode($data);
                    return;
                }

                $update_temp_khatian="Update temp_khatian set status=? where uuid=? and
                    app_id=? and khatian_no=?";
                $this->db->query($update_temp_khatian,array('F',$uuid,$app_id,$khatian_no));

                if($this->db->affected_rows() != $khatian_data->num_rows())
                {
                    $flag = true;
                    $this->db->trans_rollback();
                    $data['error_save'] = true;
                    $data['error_msg'] = "#KHA10021 Unable to update into Khatian";
                    log_message("error", "#KHA10021 Unable to to update into temp_khatian
                                    for dist_code: " . $this->session->userdata('dist_code'));
                    echo json_encode($data);
                    return;
                }


                foreach ($khatians as $key=>$k) {
                    /****** insert into khatian ***********/
                    $khatian['dist_code'] = $dist_code;
                    $khatian['subdiv_code'] = $subdiv_code;
                    $khatian['cir_code'] = $cir_code;
                    $khatian['mouza_pargona_code'] = $k['mouza_pargona_code'];
                    $khatian['lot_no'] = $k['lot_no'];
                    $khatian['vill_townprt_code'] = $k['vill_townprt_code'];
                    $khatian['id'] = $k['khatian_no'];
                    $khatian['dag_no'] = $k['dag_no'];
                    $khatian['length_posession'] = $k['length_posession'];
                    $khatian['paid_cash_kind'] = $k['paid_cash_kind'];
                    $khatian['payable_cash_kind'] = $k['payable_cash_kind'];
                    $khatian['special_conditions'] = $k['special_conditions'];
                    $khatian['tenant_status'] = $k['tenant_status'];
                    $khatian['remarks'] = $k['remarks'];
                    $khatian['uuid'] = $uuid;
                    $khatian['created_date'] = $k['created_date'];
                    $khatian['app_id'] = $_POST['app_id'];
                    $khatian_insert = $this->db->insert('khatian', $khatian);
                    if($khatian_insert != 1)
                    {
                        $flag = true;
                        $data['error_save'] = true;
                        $data['error_msg'] = "#KHA10014 Unable to insert data";
                        log_message("error", "#KHA10014 Unable to insert data khatian
                                for dist_code: " . $this->session->userdata('dist_code'));
                        echo json_encode($data);
                        return;
                    }

                    if ($tenants_data->num_rows() > 0) {
                        /****** insert into chitha tenant******/
                        $tenants = $tenants_data->result_array();
                        foreach ($tenants as $key => $t) {
                            $tenant['dist_code'] = $dist_code;
                            $tenant['subdiv_code'] = $subdiv_code;
                            $tenant['cir_code'] = $cir_code;
                            $tenant['mouza_pargona_code'] = $t['mouza_pargona_code'];
                            $tenant['lot_no'] = $t['lot_no'];
                            $tenant['vill_townprt_code'] = $t['vill_townprt_code'];
                            $tenant['dag_no'] = $k['dag_no'];
                            $tenant['revenue_tenant'] = $k['revenue_tenant'];
                            $tenant['tenant_id'] = ++$key;
                            $tenant['tenant_name'] = $t['tenant_name'];
                            $tenant['tenants_father'] = $t['tenants_father'];
                            $tenant['tenants_add1'] = $t['tenants_add1'];
                            $tenant['tenants_add2'] = $t['tenants_add2'];
                            $tenant['type_of_tenant'] = $t['type_of_tenant'];
                            $tenant['khatian_no'] = $t['khatian_no'];
                            $tenant['bigha'] = $t['bigha'];
                            $tenant['katha'] = $t['katha'];
                            $tenant['lessa'] = $t['lessa'];
                            $tenant['ganda'] = $t['ganda'];
                            $tenant['kranti'] = $t['kranti'];
                            $tenant['user_code'] = $this->session->userdata('user_code');
                            $tenant['operation'] = 'E';
                            $tenant['paid_cash_kind'] = $k['paid_cash_kind'];
                            $tenant['payable_cash_kind'] = $k['payable_cash_kind'];
                            $tenant['special_conditions'] = $k['special_conditions'];
                            $tenant['tenant_status'] = $k['tenant_status'];
                            $tenant['remarks'] = $k['remarks'];
                            $tenant['date_entry'] = $t['created_date'];
                            $tenant['uuid'] = $uuid;

                            $tenant_insert = $this->db->insert('chitha_tenant', $tenant);
                            if ($tenant_insert != 1) {
                                $flag = true;
                                $data['error_save'] = true;
                                $data['error_msg'] = "#KHA10012 Unable to insert data";
                                log_message("error", "#KHA10012 Unable to insert data chitha_tenant
                            for dist_code: " . $this->session->userdata('dist_code'));
                                echo json_encode($data);
                                return;
                            }
                        }
                    }
                }

                /******* Proceeding Report ********/
                $khatian_row = $khatian_data->row();
                $proceeding_id = $this->db->query("select max(proceeding_id)+1 as c from khatian_proceeding where
                        uuid=? and khatian_no=? and status is null?", array($uuid, $khatian_no))->row()->c;

                $proceeding['khatian_no'] = $khatian_no;
                $proceeding['proceeding_id'] = $proceeding_id;
                $proceeding['note'] = "Order Passed by CO";
                $proceeding['note_on_order'] = $this->input->post('co_note');
                $proceeding['created_date'] = date('Y-m-d H:i:s');
                $proceeding['user_code'] = $this->session->userdata('user_code');
                $proceeding['operation'] = "E";
                $proceeding['uuid'] = $uuid;
                $proceeding['dist_code'] = $khatian_row->dist_code;
                $proceeding['subdiv_code'] = $khatian_row->subdiv_code;
                $proceeding['cir_code'] = $khatian_row->cir_code;
                $proceeding['mouza_pargona_code'] = $khatian_row->mouza_pargona_code;
                $proceeding['lot_no'] = $khatian_row->lot_no;
                $proceeding['vill_townprt_code'] = $khatian_row->vill_townprt_code;
                $proceeding['status'] = 'F';

                $khatian_proceeding = $this->db->insert('khatian_proceeding', $proceeding);
                if ($khatian_proceeding != 1) {
                    $flag = true;
                    $this->db->trans_rollback();
                    $data['error_save'] = true;
                    $data['error_msg'] = "#KHA10010 Unable to submit data";
                    log_message("error", "#KHA10010 Unable to insert data into khatian_proceeding
                                for dist_code: " . $this->session->userdata('dist_code'));
                    echo json_encode($data);
                    return;
                }

                if ($this->db->trans_status() === FALSE || $flag == true) {
                    $this->db->trans_rollback();
                    $data['error_save'] = true;
                    $data['error_msg'] = "#KHA10011 Unable to submit data";
                    log_message("error", "#KHA10011 Unable to submit data
                                for dist_code: " . $this->session->userdata('dist_code'));
                    echo json_encode($data);
                    return;
                } else {
                    $this->db->trans_commit();
		    $sql5 = "DELETE FROM temp_khatian WHERE uuid=? and khatian_no=?";
		    $delete_temp_khatian = $this->db->query($sql5,array($uuid, $khatian_no));

                    $sql6 = "DELETE FROM temp_tenant WHERE uuid=? and khatian_no=?";
		    $delete_temp_khatian = $this->db->query($sql6,array($uuid, $khatian_no));

                    $this->session->set_flashdata('message', "Khatian No ".$khatian_no." Submitted Successfully !!");
                    $data['error_save'] = false;
                    echo json_encode($data);
                    return;
                }
            }else{
                $flag = true;
                $data['error_save'] = true;
                $data['error_msg'] = "#KHA10015 Unable to Pass Order";
                log_message("error", "#KHA10015 Unable to Pass Order
                            for dist_code: " . $this->session->userdata('dist_code'));
                echo json_encode($data);
                return;
            }
        }
    }

    /****** reverted back to lm *******/
    public function revertedBackToLm()
    {
        if($this->session->userdata('user_desig_code') !='CO')
        {
            return;
        }
        $dist_code = $this->session->userdata('dist_code');
        $this->form_validation->set_rules('app_id', 'Session Id', 'required|trim|xss_clean|integer');
        $this->form_validation->set_rules('khatian_no', 'Khatian No', 'required|trim|xss_clean|integer');
        $this->form_validation->set_rules('uuid', 'Village Unique Code', 'required|trim|xss_clean|integer');
        $this->form_validation->set_rules('co_reason', 'Reason of Revert Back', 'required|trim|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            echo json_encode(['error'=>$errors]);
            return;
        }else {
            $data['success'] = true;
            $app_id = $this->input->post('app_id');
            $uuid = $this->input->post('uuid');
            $khatian_no = $this->input->post('khatian_no');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');

            $sql2 = "select * from temp_tenant where app_id=? and uuid=? and khatian_no=?";
            $tenants_data = $this->db->query($sql2,array($app_id,$uuid,$khatian_no));

            $sql3 = "select * from temp_khatian where app_id=? and uuid=? and khatian_no=?";
            $khatian_data = $this->db->query($sql3,array($app_id,$uuid,$khatian_no));
            $this->db->trans_begin();
            $flag = false;

            /***** reverted back to lm ********/
            $update_temp_tenant="Update temp_tenant set status=? where uuid=? and
                app_id=? and khatian_no=?";
            $this->db->query($update_temp_tenant,array('L',$uuid,$app_id,$khatian_no));

            if($this->db->affected_rows() != $tenants_data->num_rows())
            {
                $flag = true;
                $this->db->trans_rollback();
                $data['error_save'] = true;
                $data['error_msg'] = "#KHA10023 Unable to update into Tenant";
                log_message("error", "#KHA10023 Unable to update into temp_tenant
                                    for dist_code: " . $this->session->userdata('dist_code'));
                echo json_encode($data);
                return;
            }

            $update_temp_khatian="Update temp_khatian set status=? where uuid=? and
                    app_id=? and khatian_no=?";
            $this->db->query($update_temp_khatian,array('L',$uuid,$app_id,$khatian_no));

            if($this->db->affected_rows() != $khatian_data->num_rows())
            {
                $flag = true;
                $this->db->trans_rollback();
                $data['error_save'] = true;
                $data['error_msg'] = "#KHA10022 Unable to update into Khatian";
                log_message("error", "#KHA10022 Unable to to update into temp_khatian
                                    for dist_code: " . $this->session->userdata('dist_code'));
                echo json_encode($data);
                return;
            }

            /******* Proceeding Report ********/
            $khatian_row = $khatian_data->row();
            $proceeding_id = $this->db->query("select max(proceeding_id)+1 as c from khatian_proceeding where
                        uuid=? and khatian_no=? and status is null?", array($uuid, $khatian_no))->row()->c;

            $proceeding['khatian_no'] = $khatian_no;
            $proceeding['proceeding_id'] = $proceeding_id;
            $proceeding['note'] = "Reverted by CO";
            $proceeding['note_on_order'] = $this->input->post('co_reason');
            $proceeding['created_date'] = date('Y-m-d H:i:s');
            $proceeding['user_code'] = $this->session->userdata('user_code');
            $proceeding['operation'] = "E";
            $proceeding['uuid'] = $uuid;
            $proceeding['dist_code'] = $khatian_row->dist_code;
            $proceeding['subdiv_code'] = $khatian_row->subdiv_code;;
            $proceeding['cir_code'] = $khatian_row->cir_code;;
            $proceeding['mouza_pargona_code'] = $khatian_row->mouza_pargona_code;;
            $proceeding['lot_no'] = $khatian_row->lot_no;;
            $proceeding['vill_townprt_code'] = $khatian_row->vill_townprt_code;;

            $khatian_proceeding = $this->db->insert('khatian_proceeding', $proceeding);
            if ($khatian_proceeding != 1) {
                $flag = true;
                $this->db->trans_rollback();
                $data['error_save'] = true;
                $data['error_msg'] = "#KHA10025 Unable to submit data";
                log_message("error", "#KHA10025 Unable to insert data into khatian_proceeding
                                for dist_code: " . $this->session->userdata('dist_code'));
                echo json_encode($data);
                return;
            }

            if ($this->db->trans_status() === FALSE || $flag == true) {
                $this->db->trans_rollback();
                $data['error_save'] = true;
                $data['error_msg'] = "#KHA10024 Unable to submit data";
                log_message("error", "#KHA10024 Unable to submit data
                                for dist_code: " . $this->session->userdata('dist_code'));
                echo json_encode($data);
                return;
            } else {
                $this->db->trans_commit();

                $this->session->set_flashdata('message', "Khatian No.: ".$khatian_no." Reverted to LM Successfully !!");
                $data['error_save'] = false;
                echo json_encode($data);
                return;
            }
        }
    }

    //******* khatian Reverted list for LM ********//
    public function khatianRevertedListForLm()
    {
        if($this->session->userdata('user_desig_code') !='LM')
        {
            return;
        }
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');

        $sql = "select dist_code,subdiv_code,
                cir_code,mouza_pargona_code,lot_no,vill_townprt_code,khatian_no,uuid,app_id
                from temp_khatian where status=? and dist_code=? and subdiv_code=? and cir_code=? 
                and mouza_pargona_code=? and lot_no=?
                group by dist_code,subdiv_code,
                cir_code,mouza_pargona_code,lot_no,vill_townprt_code,khatian_no,uuid,app_id";
        $khatian_data = $this->db->query($sql,array('L',$dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no));
        $data['khatian'] = null;
        if($khatian_data->num_rows()>0)
        {
            $data['khatian'] = $khatian_data->result();
        }
        $data['_view'] = 'Khatian/khatian_reverted_list_for_lm';
        $this->load->view('layouts/main',$data);
    }

    /***** Khatian Reverted Form ******/
    public function khatianRevertedViewTenantForm()
    {
        $app_id = $this->input->get('app_id');
        $khatian_no = $this->input->get('khatian');
        $uuid = $this->input->get('uuid');
        $vill_code = $this->input->get('vill_code');

        $sql22 = "select * from temp_khatian where app_id=? and khatian_no=? and uuid=? and status=?";
        $temp_khatian = $this->db->query($sql22,array($app_id,$khatian_no,$uuid,'L'));
        if($temp_khatian->num_rows() == 0)
        {
            $this->session->set_flashdata('message',"Khatian Details Invalid !! Please Check Khatian ");
            redirect(base_url() . "index.php/Home");
        }
        $sql23 = "select temp.*,type.tenant_type  from temp_tenant as temp
            INNER JOIN tenant_type as type ON temp.type_of_tenant = type.type_code where 
            temp.app_id=? and temp.khatian_no=? and temp.uuid=?";

        $temp_tenant = $this->db->query($sql23,array($app_id,$khatian_no,$uuid));
        if($temp_tenant->num_rows() == 0)
        {
            $this->session->set_flashdata('message',"Tenant Details Not Found !! Please Check Tenant ");
            redirect(base_url() . "index.php/Home");
        }

//        $value=$this->checkKhatianExist($vill_code,$khatian_no);
//        if($value==0){
            $query = "select * from tenant_type";
            $data['tenant_type'] = $this->db->query($query)->result();
            $data['dist_code'] = $this->session->userdata('dist_code');
            $data['subdiv_code'] = $this->session->userdata('subdiv_code');
            $data['cir_code'] = $this->session->userdata('cir_code');
            $data['mouza_pargona_code'] = $this->session->userdata('mouza_pargona_code');
            $data['lot_no'] = $this->session->userdata('lot_no');
            $data['vill_code'] = $vill_code;
            $data['app_id'] = $app_id;
            $data['khatians'] = $temp_khatian->result();
            $data['tenants'] = $temp_tenant->result();
            $data['khatian_no'] = $khatian_no;
            $data['_view'] = 'Khatian/revert_back_tenant_khatian_form';
            $this->load->view('layouts/main',$data);
//        }else{
//            $this->session->set_flashdata('message',"Khatian Already Exists in Records !! Please Check Khatian ");
//            redirect(base_url() . "index.php/Home");
//        }

    }

    /********* View Khatian *************/
    public function khatianViewForCo()
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $this->session->set_userdata(array('tenants' => $this->input->post()));
            redirect(base_url() . "index.php/Khatian/khatian");
        } else if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $query = "Select mouza_pargona_code,loc_name from location where 
            dist_code=? and subdiv_code=? and 
            cir_code=? and mouza_pargona_code!=? and 
            lot_no=? and vill_townprt_code=?";
            $data['mouzas'] = $this->db->query($query,array($dist_code,$subdiv_code,$cir_code,'00','00','00000'))->result();
            $data['_view'] = 'Khatian/khatian_co_view_location_select';
            $this->load->view('layouts/main',$data);
        }
    }

    /********* Insert Into Temp ********/
    public function insertIntoTemp()
    {
        $this->form_validation->set_rules('app_id', 'Session Id', 'required|trim|xss_clean|integer');
        $this->form_validation->set_rules('khatian_no', 'Khatian No', 'required|trim|xss_clean|integer');
        $this->form_validation->set_rules('vill_code', 'Village', 'required|trim|xss_clean|interger|callback_villageCodeCheck|exact_length[5]');
        if ($this->form_validation->run() == FALSE) {
            $data['error'] = true;
            $data['error_msg'] = "#KHA10031 Validation Failed";
            log_message("error", "#KHA10031 Validation Failed
                                for dist_code: " . $this->session->userdata('dist_code'));
            $this->session->set_flashdata('message',"KHA10031 Validation Failed.");
            echo json_encode($data);
            return;
        } else {
            $app_id = $this->input->post('app_id');
            $khatian_no = $this->input->post('khatian_no');
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->input->post('vill_code');;

            $sql22 = "select * from khatian where
            id=? and dist_code=? and subdiv_code=? and
            cir_code=? and mouza_pargona_code=? and lot_no=?
            and vill_townprt_code=?";
            $khatian = $this->db->query($sql22,
                array($khatian_no, $dist_code, $subdiv_code, $cir_code,
                    $mouza_pargona_code, $lot_no, $vill_townprt_code));

            if ($khatian->num_rows() == 0) {
                $data['error'] = true;
                $data['error_msg'] = "#KHA10031 Khatian Not Found !! Please Check Khatian";
                log_message("error", "#KHA10031 Khatian Not Found
                                for dist_code: " . $this->session->userdata('dist_code'));
                $this->session->set_flashdata('message',"#KHA10031 Khatian Not Found !! Please Check Khatian.");
                echo json_encode($data);
                return;
            }
            $dag_no_row = $this->db->query("select dag_no from chitha_tenant as c where 
            c.khatian_no=? and c.dist_code=? and c.subdiv_code=? and c.cir_code=?
            and c.mouza_pargona_code=? and c.lot_no=? and c.vill_townprt_code=?",
                array($khatian_no, $dist_code, $subdiv_code, $cir_code,
                $mouza_pargona_code, $lot_no, $vill_townprt_code))->row();

            $sql23 = "select c.*,type.tenant_type from chitha_tenant as c
            INNER JOIN tenant_type as type ON c.type_of_tenant = type.type_code where
            c.khatian_no=? and c.dist_code=? and c.subdiv_code=? and c.cir_code=?
            and c.mouza_pargona_code=? and c.lot_no=? and c.vill_townprt_code=? and 
            c.dag_no=?";

            $tenant = $this->db->query($sql23, array($khatian_no, $dist_code, $subdiv_code, $cir_code,
                $mouza_pargona_code, $lot_no, $vill_townprt_code,$dag_no_row->dag_no));

            if ($tenant->num_rows() == 0) {
                $data['error'] = true;
                $data['error_msg'] = "#KHA10032 Tenant Not Found !! Please Check Tenant";
                log_message("error", "#KHA10032 Tenant Not Found
                                for dist_code: " . $this->session->userdata('dist_code'));
                $this->session->set_flashdata('message',"#KHA10032 Tenant Not Found !! Please Check Tenant");
                echo json_encode($data);
                return;
            }

            $sql = "select uuid from location where dist_code=?
                and subdiv_code=? and cir_code=?
                and mouza_pargona_code=? and lot_no=? and vill_townprt_code=?";
            $uuid = $this->db->query($sql,array($dist_code,$subdiv_code,
                $cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code))->row()->uuid;

            $tenants = $tenant->result();
            $flag = false;
            $data['error'] = false;
            $this->db->trans_begin();
            foreach ($tenants as $t)
            {
                $array['app_id'] = $app_id;
                $array['dist_code'] = $dist_code;
                $array['subdiv_code'] = $subdiv_code;
                $array['cir_code'] = $cir_code;
                $array['mouza_pargona_code'] = $mouza_pargona_code;
                $array['lot_no'] = $lot_no;
                $array['vill_townprt_code'] = $vill_townprt_code;
                $array['uuid'] = $uuid;
                $array['tenant_name'] =$t->tenant_name;
                $array['tenants_father'] = $t->tenants_father;
                $array['tenants_add1'] = $t->tenants_add1;
                $array['tenants_add2'] = $t->tenants_add2;
                $array['type_of_tenant'] = $t->type_of_tenant;
                $array['khatian_no'] = $t->khatian_no;
                $array['bigha'] = $t->bigha;
                $array['katha'] = $t->katha;
                $array['lessa'] = $t->lessa;
                $array['ganda'] = $t->ganda;
                $array['kranti'] = $t->kranti;
                $array['created_date'] = $t->date_entry;
                $array['user_code'] = $t->user_code;



                $tenant_save = $this->db->insert('temp_tenant', $array);
                if($tenant_save != true)
                {
                    $this->db->trans_rollback();
                    $flag = true;
                    $data['error'] = true;
                    $data['error_msg'] = "#KHA10033 Unable to access tenant data.";
                    log_message("error", "#KHA10033 Unable to insert into temp_tenant
                                for dist_code: " . $this->session->userdata('dist_code'));
                    $this->session->set_flashdata('message',"#KHA10033 Unable to access tenant data.");
                    echo json_encode($data);
                    return;
                }
            }

            $khatians = $khatian->result();
            foreach ($khatians as $k)
            {
                $chitha_data ="select dag_revenue from chitha_basic where dist_code=?
                    and subdiv_code=? and cir_code=?
                    and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
                $chitha_result = $this->db->query($chitha_data,array($dist_code,$subdiv_code,
                    $cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$k->dag_no))->row_array();

                $array2['app_id'] = $app_id;
                $array2['dist_code'] = $dist_code;
                $array2['subdiv_code'] = $subdiv_code;
                $array2['cir_code'] = $cir_code;
                $array2['mouza_pargona_code'] = $mouza_pargona_code;
                $array2['lot_no'] = $lot_no;
                $array2['vill_townprt_code'] = $vill_townprt_code;
                $array2['uuid'] = $uuid;
                $array2['dag_no'] = $k->dag_no;
                $array2['revenue_tenant'] = $chitha_result['dag_revenue'];
                $array2['length_posession'] = $k->length_posession;
                $array2['tenant_status'] =  $k->tenant_status;
                $array2['paid_cash_kind'] =  $k->paid_cash_kind;
                $array2['payable_cash_kind'] =  $k->payable_cash_kind;
                $array2['khatian_no'] = $khatian_no;
                $array2['special_conditions'] =  $k->special_conditions;
                $array2['remarks'] =  $k->remarks;
                $array2['created_date'] = $k->created_date;
                $array2['user_code'] = $this->session->userdata('user_code');

                $khatian_save = $this->db->insert('temp_khatian', $array2);
                if($khatian_save != true)
                {
                    $this->db->trans_rollback();
                    $flag = true;
                    $data['error'] = true;
                    $data['error_msg'] = "#KHA10034 Unable to access khatian data.";
                    log_message("error", "#KHA10034 Unable to insert into temp_khatian
                                for dist_code: " . $this->session->userdata('dist_code'));
                    $this->session->set_flashdata('message',"#KHA10034 Unable to access khatian data.");
                    echo json_encode($data);
                    return;
                }
            }
            if ($this->db->trans_status() === FALSE || $flag == true) {
                $this->db->trans_rollback();
                $data['error'] = true;
                $data['error_msg'] = "#KHA10035 Unable to insert data";
                log_message("error", "#KHA10035 Unable to insert data
                                for dist_code: " . $this->session->userdata('dist_code'));
                $this->session->set_flashdata('message',"#KHA10035 Unable to insert data.");
                echo json_encode($data);
                return;
            } else {
                $this->db->trans_commit();
                $data['temp_tenant'] = $this->db->query("select temp.*,type.tenant_type  from temp_tenant as temp
                INNER JOIN tenant_type as type ON temp.type_of_tenant = type.type_code where temp.app_id=?",$app_id)->result();
                $data['temp_khatian'] = $this->db->query("select *  from temp_khatian where app_id=?",$app_id)->result();
                echo json_encode($data);
                return;
            }

        }
    }

    /******** Pattadar Check ********/
    public function pattadarCheck()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->input->post('vill_code');
        $dag_no = $this->input->post('dag_no');
        $khatian_no = $this->input->post('khatian_no');

        $sql = "select count(*) as c from chitha_dag_pattadar where 
        dist_code=? and subdiv_code=? and cir_code=? and 
        mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=? and p_flag!='1'";
        $count = $this->db->query($sql,
            array($dist_code,$subdiv_code,$cir_code,
                $mouza_pargona_code,$lot_no,$vill_townprt_code,$dag_no))->row()->c;
	   $data['pattadar'] = $count;
        $sql3 = "select khatian_no from temp_khatian where 
        dist_code=? and subdiv_code=? and cir_code=? and 
        mouza_pargona_code=? and lot_no=? and 
        vill_townprt_code=? and dag_no=? and khatian_no!=? and status=?";
        $res3 = $this->db->query($sql3,
            array($dist_code,$subdiv_code,$cir_code,
                $mouza_pargona_code,$lot_no,
                $vill_townprt_code,$dag_no,$khatian_no,'P'));

        $data['temp_dag_count'] = false;
        if($res3->num_rows()>0)
        {
            $data['temp_dag_count'] = true;
            $data['temp_khatian_no'] = $res3->row()->khatian_no;
        }

        $sql4 = "select khatian_no from temp_khatian where 
        dist_code=? and subdiv_code=? and cir_code=? and 
        mouza_pargona_code=? and lot_no=? and 
        vill_townprt_code=? and dag_no=? and khatian_no!=? and status=?";
        $res4 = $this->db->query($sql4,
            array($dist_code,$subdiv_code,$cir_code,
                $mouza_pargona_code,$lot_no,
                $vill_townprt_code,$dag_no,$khatian_no,'L'));

        $data['lm_temp_dag_count'] = false;
        if($res4->num_rows()>0)
        {
            $data['lm_temp_dag_count'] = true;
            $data['lm_temp_khatian_no'] = $res4->row()->khatian_no;
        }

        echo json_encode($data);
    }
    function reportView(){
        $dist_code=$this->session->userdata('dist_code');
        $subdiv_code=$this->session->userdata('subdiv_code');
        $cir_code=$this->session->userdata('cir_code');
        $final=array();
        $sql="Select mouza_pargona_code from location where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code!=? and lot_no=?";
        $data=$this->db->query($sql,array($dist_code,$subdiv_code,$cir_code,'00','00'))->result_array();
        foreach($data as $r){

            $sql="Select lot_no from location where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no!=? and vill_townprt_code=? ";
            $lotdata=$this->db->query($sql,array($dist_code,$subdiv_code,$cir_code,$r['mouza_pargona_code'],'00','00000'))->result_array();
            //echo $this->db->last_query();
            foreach($lotdata as $lot){
                 $sqlKhatian20 = "select count(*) as c from (select distinct on (uuid, khatian_no) uuid, khatian_no, count(*) from temp_khatian where status='P' and dist_code=? and subdiv_code = ? and cir_code = ? and mouza_pargona_code=? and lot_no=? group by uuid, khatian_no ) as c";
                
                $countKhatian20 = $this->db->query($sqlKhatian20,array($dist_code,$subdiv_code,$cir_code,$r['mouza_pargona_code'],$lot['lot_no']))->row()->c;                
                $sqlKhatian21 = 'select distinct on (uuid,id) uuid,id from khatian where subdiv_code = ? and cir_code = ? and mouza_pargona_code=? and lot_no=? group by uuid, id';

                $countKhatian21 = $this->db->query($sqlKhatian21,array($subdiv_code,$cir_code,$r['mouza_pargona_code'],$lot['lot_no']))->num_rows();                
                 
                $sqlKhatian22 = "select count(*) as c from chitha_tenant where subdiv_code=? and cir_code=? and khatian_no!='0' and mouza_pargona_code=? and lot_no=? ";
                $countKhatian22 = $this->db->query($sqlKhatian22,array($subdiv_code,$cir_code,$r['mouza_pargona_code'],$lot['lot_no']))->row()->c;
                $array=[
                    'dist_code'=>$dist_code,
                    'subdiv_code'=>$subdiv_code,
                    'cir_code'=>$cir_code,
                    'mouza_pargona_code'=>$r['mouza_pargona_code'],
                    'lot_no'=>$lot['lot_no'],
                    'pending'=>$countKhatian20,
                    'approved'=>$countKhatian21,
                    'raytee'=>$countKhatian22,
                ];
                array_push($final,$array);
            }          
        }
        $data['lot_wise_report_data']=$final;
        $data['_view'] = 'Khatian/lot_wise';
        $this->load->view('layouts/main',$data); 
    }
    function adcreportView(){
         $dist_code=$this->session->userdata('dist_code');
        // $subdiv_code=$this->session->userdata('subdiv_code');
        // $cir_code=$this->session->userdata('cir_code');
        $final=array();
        $sql="Select subdiv_code,cir_code from location where cir_code!=? and mouza_pargona_code=? ";
        $data=$this->db->query($sql,array('00','00'))->result_array();
        foreach($data as $r){
                $sqlKhatian20 = "select count(*) as c from (select distinct on (uuid, khatian_no) uuid, khatian_no, count(*) from temp_khatian where status='P' and dist_code=? and subdiv_code = ? and cir_code = ? group by uuid, khatian_no ) as c";
                
                $countKhatian20 = $this->db->query($sqlKhatian20,array($dist_code,$r['subdiv_code'],$r['cir_code']))->row()->c;                
                $sqlKhatian21 = 'select distinct on (uuid,id) uuid,id from khatian where subdiv_code = ? and cir_code = ? group by uuid, id';

                $countKhatian21 = $this->db->query($sqlKhatian21,array($r['subdiv_code'],$r['cir_code']))->num_rows();                
                 
                $sqlKhatian22 = "select count(*) as c from chitha_tenant where subdiv_code=? and cir_code=? and khatian_no!='0'  ";
                $countKhatian22 = $this->db->query($sqlKhatian22,array($r['subdiv_code'],$r['cir_code']))->row()->c;
                $array=[
                    'dist_code'=>$dist_code,
                    'subdiv_code'=>$r['subdiv_code'],
                    'cir_code'=>$r['cir_code'],
                    'pending'=>$countKhatian20,
                    'approved'=>$countKhatian21,
                    'raytee'=>$countKhatian22,
                ];
                array_push($final,$array);       
        }
        $data['lot_wise_report_data']=$final;
        $data['_view'] = 'Khatian/circle_wise';
        $this->load->view('layouts/main',$data); 
    }
    function VillageWiseReport($m,$l){
        $dist_code=$this->session->userdata('dist_code');
        $subdiv_code=$this->session->userdata('subdiv_code');
        $cir_code=$this->session->userdata('cir_code');
        $final=array();
        $sql="Select vill_townprt_code from location where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code!=? ";
        $lotdata=$this->db->query($sql,array($dist_code,$subdiv_code,$cir_code,$m,$l,'00000'))->result_array();
        foreach($lotdata as $lot){
                $sqlKhatian20 = "select count(*) as c from (select distinct on (uuid, khatian_no) uuid, khatian_no, count(*) from temp_khatian where status='P' and dist_code=? and subdiv_code = ? and cir_code = ? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? group by uuid, khatian_no ) as c";
                $countKhatian20 = $this->db->query($sqlKhatian20,array($dist_code,$subdiv_code,$cir_code,$m,$l,$lot['vill_townprt_code']))->row()->c;
               
                $sqlKhatian21 = 'select distinct on (uuid,id) uuid,id as c  from khatian where subdiv_code = ? and cir_code = ? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? group by uuid, id';

                $countKhatian21 = $this->db->query($sqlKhatian21,array($subdiv_code,$cir_code,$m,$l,$lot['vill_townprt_code']))->num_rows();
                
                $sqlKhatian22 = "select count(*) as c from chitha_tenant where subdiv_code=? and cir_code=? and khatian_no!='0' and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? ";
                $countKhatian22 = $this->db->query($sqlKhatian22,array($subdiv_code,$cir_code,$m,$l,$lot['vill_townprt_code']))->row()->c;
                $array=[
                    'dist_code'=>$dist_code,
                    'subdiv_code'=>$subdiv_code,
                    'cir_code'=>$cir_code,
                    'mouza_pargona_code'=>$m,
                    'lot_no'=>$l,
                    'vill_townprt_code'=>$lot['vill_townprt_code'],
                    'pending'=>$countKhatian20,
                    'approved'=>$countKhatian21,
                    'raytee'=>$countKhatian22,
                ];
                array_push($final,$array);
        }
        $data['lot_wise_report_data']=$final;
        $data['_view'] = 'Khatian/village_wise';
        $this->load->view('layouts/main',$data);
    }
    // public function villageCodeCheck($vill_code)
    // {
    //     $dist_code = $this->session->userdata('dist_code');
    //     $subdiv_code = $this->session->userdata('subdiv_code');
    //     $cir_code = $this->session->userdata('cir_code');
    //     $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
    //     $lot_no = $this->session->userdata('lot_no');
    //     $vill_code = $vill_code;

    //     $villages_code_check = $this->db->query("select vill_townprt_code from location where 
    //         dist_code =?  and subdiv_code=? and 
    //         cir_code=? and mouza_pargona_code=? and  lot_no=? 
    //         and vill_townprt_code=?",
    //         array($dist_code, $subdiv_code, $cir_code,
    //             $mouza_pargona_code, $lot_no, $vill_code));
    //     if ($villages_code_check->num_rows() == 1) {
    //         return TRUE;
    //     } else {
    //         $this->form_validation->set_message('villageCodeCheck', 'This %s is invalid');
    //         return FALSE;
    //     }
    // }
    public function getKhatianExistOrNotCall($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$new_khatian_no) {
        $data = array();
        $where  = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code,
            'id' => $new_khatian_no
        );
        $khatians = $this->mutationmodel->checkKhatianExistorNot('khatian','id', $where);
            if ($khatians>0) {
                return TRUE;
            } else {
                return FALSE;
            }
        
        }
}

