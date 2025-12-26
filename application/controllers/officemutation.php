<?php
class OfficeMutation extends CI_Controller {

    var $user_code;
    var $base_query;
    var $base;

    public function __construct() {
        parent::__construct();
        $this->load->model('mutation/mutationmodel');
        $this->user_code = $this->session->userdata('user_code');
        $location = $this->utilityclass->getLocationfromSession();
        $this->load->model('Escalationmodel');
        $dist_code = $location['dist_code'];
        $subdiv_code = $location['subdiv_code'];
        $cir_code = $location['cir_code'];
        $year_no = year_no;
        $defined_date = define_date;
        $this->base_query = "dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'  and date(date_entry)>='$defined_date'";
        $this->load->model('basundhara/basundharamodel');
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


    public function registermutation() {
        $db=  $this->session->userdata('db');
        $this->session->unset_userdata('petitioner');
        $this->session->unset_userdata('dags');
        $this->session->unset_userdata('pattadar');

        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $dist_code = $this->input->post('dist_code');
            $subdiv_code = $this->input->post('subdiv_code');
            $circle_code = $this->input->post('circle_code');
            $mouza_pargona_code = $this->input->post('mouza_code');
            $lot_no = $this->input->post('lot_no');
            $vill_townprtcode = $this->input->post('vill_code');
            $location = array(
                'dist_code' => $dist_code, 'subdiv_code' => $subdiv_code,
                'cir_code' => $circle_code, 'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no, 'vill_code' => $vill_townprtcode
            );
            $this->session->set_userdata($location);
            redirect(base_url() . "index.php/officemutation/mutationtype");
        } else if ($this->input->server('REQUEST_METHOD') == 'GET') {
            // $this->load->helper('html');
            // $this->load->view('../views/header');
            $data = $this->mutationmodel->getDistricts();
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouzas = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);
            $district['d'] = $dist_code;
            $district['s'] = $subdiv_code;
            $district['c'] = $cir_code;
            $district['mouzas'] = $mouzas;
            // $this->load->view('../views/asstofficemutation/registermutation', $district);
            // $this->load->view('../views/footer');
            $district['_view'] = 'asstofficemutation/registermutation';
            $this->load->view('layouts/main',$district);
        }
    }

    public function Suomotodeed() {
        $db=  $this->session->userdata('db');
        $data = array();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $q = "Select * from     sro_note where dist_code='$dist_code'  and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='1' and (nature_of_land != 'r' or nature_of_land is null)";
        $data['sronote'] = $this->db->query($q)->result();
        $this->load->view('../views/header');
        $this->load->view('../views/asstofficemutation/suomotodeed', $data);
        $this->load->view('../views/footer');
    }

    public function RegisterSuomoto() {
        $db=  $this->session->userdata('db');
        $mutation = array();
        $this->load->view('../views/header');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $deed_no = $this->input->get('deed');
        $mutation['transfertype'] = $this->getTransferType();
        $q = "Select * from    sro_note where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='1'  and deed_no='$deed_no' ";
        $data = $mutation['deeddata'] = $this->db->query($q)->row();
        $location = array(
            'dist_code' => $data->dist_code, 'subdiv_code' => $data->subdiv_code,
            'cir_code' => $data->cir_code, 'mouza_pargona_code' => $data->mouza_pargona_code,
            'lot_no' => $data->lot_no, 'vill_code' => $data->vill_townprt_code
        );
        $this->session->set_userdata($location);

        $q = "select * from    loginuser_table where dist_code = '$dist_code' and subdiv_code='$subdiv_code' and  cir_code='$cir_code' and dis_enb_option='E' and priv='adm' ";

        $users = $this->db->query($q)->result();
        foreach ($users as $u) {
            $query_string = "dist_code = '$dist_code' and subdiv_code='$subdiv_code' and"
                    . " cir_code = '$cir_code' and user_code='$u->user_code' ";

            $mutation['user'] = $this->db->query("select * from    users where " . $query_string)->result();
        }

        $this->load->view('../views/asstofficemutation/deedmutationtype', $mutation);
        $this->load->view('../views/footer');
    }

    public function mutationtype($proceed = 0) {
        $db=  $this->session->userdata('db');
        $this->load->model('mutationmodel');

        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            if ($proceed == 0) {
                $patta_no_trim = trim($this->input->post('patta_no'));
                $patta_type = $this->input->post('patta_type');
                $add_of_name = $this->input->post('add_of_name');
                $reg_deed_no = $this->input->post('reg_deed_no');
                $reg_deed_date = $this->input->post('reg_deed_date');
                $reg_deed_value = $this->input->post('reg_deed_value');
                $transfer_type = $this->input->post('transfer_type');
                $suomotocase = $this->input->post('suomoto');
                $arr = array(
                    'patta_no' => $patta_no_trim,
                    'patta_type' => $patta_type,
                    'add_of_name' => $add_of_name,
                    'reg_deed_no' => $reg_deed_no,
                    'reg_deed_date' => $reg_deed_date,
                    'reg_deed_value' => $reg_deed_value,
                    'transfer_type' => $transfer_type,
                    'suomoto' => $suomotocase
                );
                
                $this->session->set_userdata($arr);
                $revert = array('%21'=>'!', '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')');
                $patta_no = strtr(rawurlencode($patta_no_trim), $revert);
                
                redirect(base_url() . "index.php/ChithaJamaCompare/compare/$patta_no");
                return;
            }
            redirect(base_url() . "index.php/officemutation/mutationapplicantDetails");
        } else if ($this->input->server('REQUEST_METHOD') == 'GET') {
            //$this->load->view('../views/header');
            $patt_type = $this->mutationmodel->getPattaType();
            $mutation['patta_type'] = $patt_type;
            $patt_type_without_aksona = $this->mutationmodel->getPattaTypeExcludingAksona();
            $mutation['patta_type_excluding_aksona'] = $patt_type_without_aksona;
            $mutation['transfertype'] = $this->getTransferType();
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mutation['dist_code'] = $dist_code;
            $mutation['subdiv_code'] = $subdiv_code;
            $mutation['cir_code'] = $cir_code;
            $mutation['mouza_code'] = $this->session->userdata('mouza_pargona_code');
            $mutation['lot_no'] = $this->session->userdata('lot_no');
            $mutation['vill_code'] = $this->session->userdata('vill_code');
            $q = "select * from  loginuser_table where dist_code = '$dist_code' and subdiv_code='$subdiv_code' and  cir_code='$cir_code' and dis_enb_option='E' and (priv='adm' or priv='mut') and user_code like 'CO%' ";

            $users = $this->db->query($q)->result();
            foreach ($users as $u) {
                $query_string = "dist_code = '$dist_code' and subdiv_code='$subdiv_code' and"
                        . " cir_code = '$cir_code' and user_code='$u->user_code' ";

                $mutation['user'] = $this->db->query("select * from   users where " . $query_string)->result();
            }
            // $this->load->view('../views/asstofficemutation/mutationtype', $mutation);
            // $this->load->view('../views/footer');
            $mutation['_view'] = 'asstofficemutation/mutationtype';
            $this->load->view('layouts/main',$mutation);
        }
    }
    
    public function mutationapplicantDetails() {
        $db=  $this->session->userdata('db');
        //var_dump($this->session->all_userdata());
        //$this->load->view('../views/header');
        $this->load->model('relation/relationmodel');
        $this->load->model('patta/pattamodel');
        $data['relation'] = $this->relationmodel->getRelations();
        $data["pdars"] = $this->pattamodel->getPattadarsByPattaNo1();
        if ($this->input->get('next')) {
            $data['disabled'] = false;
        } else {
            $data['disabled'] = true;
        }
        if ($this->input->get('hus_wife')) {
            $data['husband_wife'] = true;
        } else {
            $data['husband_wife'] = false;
        }
        // $this->load->view('../views/asstofficemutation/applicantdetails', $data);
        // $this->load->view('../views/footer');
        $data['_view'] = 'asstofficemutation/applicantdetails';
        $this->load->view('layouts/main',$data);
    }
    
    public function saveApplicantDetails() {
        $db=  $this->session->userdata('db');
        $data = array();
        $applied_b = $this->input->post('applied_b');
        $applied_k = $this->input->post('applied_k');
        $applied_lc = $this->input->post('applied_lc');
        $hus_wife = $this->input->post('hus_wife');
        if ($this->session->userdata('applied_b')) {
            $applied_b += $this->session->userdata('applied_b');
            $this->session->set_userdata(array('applied_b' => $applied_b));
        } else {
            $this->session->set_userdata(array('applied_b' => $applied_b));
        }
        if ($this->session->userdata('applied_k')) {
            $applied_k += $this->session->userdata('applied_k');
            $this->session->set_userdata(array('applied_k' => $applied_k));
        } else {
            $this->session->set_userdata(array('applied_k' => $applied_k));
        }
        if ($this->session->userdata('applied_lc')) {
            $applied_lc += $this->session->userdata('applied_lc');
            $this->session->set_userdata(array('applied_lc' => $applied_lc));
        } else {
            $this->session->set_userdata(array('applied_lc' => $applied_lc));
        }
        foreach ($_POST as $k => $v) {
            $data[$k] = $v;
        }
        $husband_wife = false;
        if ($hus_wife == 'h') {
            $husband_wife = true;
        }
        if (isset($data['copname'])) {
            $data['pdar_id'] = $data['copname'];
        }
        $location = $this->utilityclass->getLocationfromSession();
        $merged = array_merge($data, $location);
        $case_no = $this->session->userdata('case_no');
        $petition_no = $this->session->userdata('petition_no');
        $petition = $this->db->query("select count(pet_id) as pet_id from    field_mut_petitioner where pet_id is not null "
                        . " and case_no='$case_no' limit 1")->result();
        $pet_id = $petition[0]->pet_id + 1;
        $report_date = $timestamp = date('Y-m-d G:i:s');
        $date_entry = $timestamp = date('Y-m-d G:i:s');
        $otherdata = array(
            'case_no' => $case_no,
            'petition_no' => $petition_no,
            'year_no' => $year_no,
            'pet_id' => $pet_id,
            'user_code' => $this->user_code,
            'date_entry' => $date_entry,
            'operation' => 'E',
            'hus_wife' => $hus_wife
        );
        $merged = array_merge($otherdata, $merged);
        if (!$this->session->userdata('appdet')) {
            $this->session->set_userdata('appdet', array());
            $appdet = $this->session->userdata('appdet');
            $appdet[] = $merged;
            $this->session->set_userdata('appdet', $appdet);
        } else {
            $appdet = $this->session->userdata('appdet');
            $appdet[] = $merged;
            $this->session->set_userdata('appdet', $appdet);
        }
        
        if ($husband_wife == true)
            redirect(base_url() . "index.php/officemutation/mutationapplicantDetails?hus_wife=$husband_wife");
        else
            redirect(base_url() . "index.php/officemutation/addmoreapplicat");
    }
    
    public function addmoreapplicat() {
        // $this->load->view('../views/header');
        // $this->load->view('../views/asstofficemutation/addmoreapplicant');
        // $this->load->view('../views/footer');
        $data['_view'] = 'asstofficemutation/addmoreapplicant';
        $this->load->view('layouts/main',$data);
    }
    
    public function mutationLandArea() {
        $db=  $this->session->userdata('db');
        //var_dump($this->session->all_userdata());
        $this->load->model('patta/PattaModel');
        $patta_no = trim($this->session->userdata('patta_no'));

        $patta_type = $this->session->userdata('patta_type');
        $case_no = $this->session->userdata('case_no');
        $dags['dags'] = $this->PattaModel->getDagsByPattaNoPattaType($patta_no, $patta_type, $case_no)->result();
        
        $b = $this->session->userdata('applied_b');
        $k = $this->session->userdata('applied_k');
        $lc = $this->session->userdata('applied_lc');
        $sourcelessa = $b * 100 + $k * 20 + $lc;
        $dags['b'] = floor($sourcelessa / 100);
        $dags['k'] = floor(($sourcelessa - $dags['b'] * 100) / 20);
        $dags['lc'] = $sourcelessa - $dags['b'] * 100 - $dags['k'] * 20;
        $dags['mut_type'] = '02';
        if ($this->input->get('mut_type') == '02') {
            $dags['type'] = 02;
        } else {
            $dags['type'] = 01;
        }
        // $this->load->view('../views/header');
        // $this->load->view('../views/asstofficemutation/mutationlandarea', $dags);
        // $this->load->view('../views/footer');
        $dags['_view'] = 'asstofficemutation/mutationlandarea';
        $this->load->view('layouts/main',$dags);
    }
    
    public function saveMutationDagDetails() {
        //$db=  $this->session->userdata('db');
        //var_dump($this->session->all_userdata());
        $location = $this->utilityclass->getLocationfromSession();
        $petition_no = $this->session->userdata('petition_no');
        $case_no = $this->session->userdata('case_no');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type_code = $this->session->userdata('patta_type');
        $deed_date = $this->session->userdata('deed_date');
        $deed_value = $this->session->userdata('deed_value');
        $deed_reg_no = $this->session->userdata('deed_reg_no');
        $user_code = $this->user_code;
        $date_entry = date('Y-m-d G:i:s');
        $operation = 'E';
        $year_no = year_no;
        $data = array();
        //var_dump($_POST);
        foreach ($_POST as $k => $v) {
            $data[$k] = $v;
        }
        //var_dump($data);
        $dag_no = $data['dag_no'];
        $this->session->set_userdata(array('dag_no' => $dag_no));
        $other = array('case_no' => $case_no, 'petition_no' => $petition_no,
            'patta_no' => $patta_no, 'patta_type_code' => $patta_type_code,
            'user_code' => $user_code, 'date_entry' => $date_entry, 'operation' => $operation,
            'deed_date' => $deed_date, 'deed_value' => $deed_value, 'deed_reg_no' => $deed_reg_no, 'year_no' => $year_no
        );
        $merged = array_merge($other, $location);
        // if (!$this->session->userdata('dag_det')) {
        //     $this->session->set_userdata('dag_det', array());
        //     $dagdet = $this->session->userdata('dag_det');
        //     $dagdet[] = $merged;
        //     $this->session->set_userdata('dag_det', $dagdet);
        // } else {
        //     $dagdet = $this->session->userdata('dag_det');
        //     $dagdet[] = $merged;
        //     $this->session->set_userdata('dag_det', $dagdet);
        
        // }
        $dag_det[]=$data;
        $this->session->set_userdata('dag_det',$dag_det);
       // var_dump($this->session->all_userdata());
       echo json_encode($this->session->userdata('ismultiple'));
    }
    
    public function getDagsByPattaNoPattaTypeJSON() {
        $this->load->model('patta/PattaModel');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type = $this->session->userdata('patta_type');
        $case_no = $this->session->userdata('case_no');
        $dags = $this->PattaModel->getDagsByPattaNoPattaType($patta_no, $patta_type, $case_no)->result();
        $json = array();
        foreach ($dags as $object) {
            $json[] = array('dag_no' => $object->dag_no);
        }
        echo json_encode($json);
    }

    public function getPattadars() {
        $this->dbswitch();
        $this->load->model('patta/pattamodel');
        $data = $this->pattamodel->getPattadars();
        
        $json_array = array();
        foreach ($data as $d) {
            $json_array[] = array(
                'pdar_id' => $d->pdar_id,
                'pdar_name' => $d->pdar_name
            );
        }
        echo json_encode($json_array);
    }

    public function pattadarDetails() {
        
        $location = $this->utilityclass->getLocationfromSession();
        if ($this->input->server('REQUEST_METHOD') == 'POST') {

            if ($this->session->userdata('pattadar') != null) {

                $pattadar = $this->session->userdata('pattadar');
                echo sizeof($pattadar);
                $pdar_cron_no = $this->input->post('pdar_cron_no');
                $pdar_name = $this->input->post('pdar_name');
                $striked_out = $this->input->post('striked_out');
                $pdar_guard_name = $this->input->post('pdar_guardian');
                $pdar_rel_guar = $this->input->post('pdar_rel_guar');
                $pdar_add1 = $this->input->post('pdar_add1');
                $pdar_add2 = $this->input->post('pdar_add2');
                $data = array(
                    'pdar_name' => $pdar_name,
                    'pdar_guardian' => $pdar_guard_name,
                    'pdar_rel_guar' => $pdar_rel_guar,
                    'pdar_add1' => $pdar_add2,
                    'pdar_add2' => $pdar_add2,
                );

                $pattadar[] = $data;
                $this->session->set_userdata('pattadar', $pattadar);
            } else {
                $this->session->set_userdata('pattadar', array());
                $pattadar = $this->session->userdata('pattadar');


                $pdar_cron_no = $this->input->post('pdar_cron_no');
                $pdar_name = $this->input->post('pdar_name');
                $striked_out = $this->input->post('striked_out');
                $pdar_guard_name = $this->input->post('pdar_guardian');
                $pdar_rel_guar = $this->input->post('pdar_rel_guar');
                $pdar_add1 = $this->input->post('pdar_add1');
                $pdar_add2 = $this->input->post('pdar_add2');
                $data = array(
                    'pdar_name' => $pdar_name,
                    'pdar_guardian' => $pdar_guard_name,
                    'pdar_rel_guar' => $pdar_rel_guar,
                    'pdar_add1' => $pdar_add2,
                    'pdar_add2' => $pdar_add2,
                );

                array_push($pattadar, $data);
                $this->session->set_userdata('pattadar', $pattadar);
            }
        } else if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $this->load->model('patta/PattaModel');
            //$this->load->view('../views/header');
           
            $dag = $this->session->userdata('dag_det');
            //var_dump($dag);
            $dag = $dag[0]['dag_no'];
            //var_dump($dag);
            $data['dag'] = $dag;
            
            // $this->load->view('../views/asstofficemutation/pattadardetails', $data);
            // $this->load->view('../views/footer');
            $data['_view'] = 'asstofficemutation/pattadardetails';
            $this->load->view('layouts/main',$data);
        }
    }

    public function pattadarDetails1() {
        $location = $this->utilityclass->getLocationfromSession();

        if ($this->input->server('REQUEST_METHOD') == 'POST') {

            if ($this->session->userdata('pattadar') != null) {

                $pattadar = $this->session->userdata('pattadar');
                $pdar_cron_no = $this->input->post('pdar_cron_no');
                $pdar_name = $this->input->post('pdar_name');
                $striked_out = $this->input->post('striked_out');
                $pdar_guard_name = $this->input->post('pdar_guardian');
                $pdar_rel_guar = $this->input->post('pdar_rel_guar');
                $pdar_add1 = $this->input->post('pdar_add1');
                $pdar_add2 = $this->input->post('pdar_add2');
                $data = array(
                    'dist_code' => $location['dist_code'],
                    'cir_code' => $location['cir_code'],
                    'subdiv_code' => $location['subdiv_code'],
                    'lot_no' => $location['lot_no'],
                    'mouza_pargona_code' => $location['mouza_pargona_code'],
                    'vill_code' => $location['vill_townprt_code'],
                    'pdar_cron_no' => $pdar_cron_no,
                    'striked_out' => $striked_out,
                    'pdar_guardian' => $pdar_guard_name,
                    'pdar_rel_guar' => $pdar_rel_guar,
                    'pdar_add1' => $pdar_add2,
                    'pdar_add2' => $pdar_add2,
                    'pdar_name' => $pdar_name
                );

                array_push($pattadar, $data);
                $this->session->set_userdata('pattadar', $pattadar);
            } else {

                $this->session->set_userdata('pattadar', array());
                $pattadar = $this->session->userdata('pattadar');

                $pdar_cron_no = $this->input->post('pdar_cron_no');
                $pdar_name = $this->input->post('pdar_name');
                $striked_out = $this->input->post('striked_out');
                $pdar_guard_name = $this->input->post('pdar_guardian');
                $pdar_rel_guar = $this->input->post('pdar_rel_guar');
                $pdar_add1 = $this->input->post('pdar_add1');
                $pdar_add2 = $this->input->post('pdar_add2');
                $data = array(
                    'dist_code' => $location['dist_code'],
                    'cir_code' => $location['cir_code'],
                    'subdiv_code' => $location['subdiv_code'],
                    'lot_no' => $location['lot_no'],
                    'mouza_pargona_code' => $location['mouza_pargona_code'],
                    'vill_code' => $location['vill_townprt_code'],
                    'pdar_cron_no' => $pdar_cron_no,
                    'striked_out' => $striked_out,
                    'pdar_guardian' => $pdar_guard_name,
                    'pdar_rel_guar' => $pdar_rel_guar,
                    'pdar_add1' => $pdar_add2,
                    'pdar_add2' => $pdar_add2,
                    'pdar_name' => $pdar_name
                );

                array_push($pattadar, $data);
                $this->session->set_userdata('pattadar', $pattadar);
            }
        } else if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $this->load->model('patta/PattaModel');
            $this->load->view('../views/header');
            $this->load->view('../views/asstofficemutation/pattadardetails');
            $this->load->view('../views/footer');
        }
    }

    public function registrationPetition() {
        //var_dump($this->session->all_userdata());
        $db=  $this->session->userdata('db');
        $data = array();
        $data['petitioner'] = $this->session->userdata('appdet');
        $data['pattadar'] = $this->session->userdata('pattadar');
        $trans_code = $this->session->userdata('transfer_type');
        $data['tranfer_type'] = $this->db->query("select trans_desc_as from    nature_trans_code "
                        . " where trans_code='$trans_code'")->row()->trans_desc_as;
        $addressed_to = $this->session->userdata('add_of_name');
        $data['patta_no'] = trim($this->session->userdata('patta_no'));
        $data['dags'] = $this->session->userdata('dag_det');
        
        $location = $this->utilityclass->getLocationfromSession();
        $data['addressed_to'] = $this->utilityclass->getSelectedCOName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $addressed_to);
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
            'vill' => $vill_townprt_code
        );
        $data['location_codes'] = $location;
        $this->load->model('patta/PattaModel');
        // $this->load->view('../views/header');
        // $this->load->view('../views/asstofficemutation/registrationpetition', $data);
        // $this->load->view('../views/footer');
        $data['_view'] = 'asstofficemutation/registrationpetition';
        $this->load->view('layouts/main',$data);
    }

    public function getTransferType() {
        $this->load->model('mutation/mutationmodel');
        $data = $this->mutationmodel->getTransferType();
        return $data;
    }

    public function savePetition() {
        //$db=  $this->session->userdata('db');
        $mb = 0;
        $mk = 0;
        $mlc = 0;
        $this->db->trans_begin();
        $year_no =year_no;
        $location = $this->utilityclass->getLocationfromSession();
        $dist_code = $location['dist_code'];
        $subdiv_code = $location['subdiv_code'];
        $cir_code = $location['cir_code'];
        // $petition_no = $this->db->query("select max(petition_no) as count from petition_basic where dist_code = '$dist_code' and "
        //                 . "subdiv_code = '$subdiv_code' and cir_code = '$cir_code' ")->row()->count;
        // if ($petition_no == null) {
        //     $petition_no = 1;
        // } else {
        //     $petition_no+=1;
        // }
        // $petition_no_case = $this->db->query("select count(petition_no)+1 as count from    petition_basic where $this->base_query and mut_type='03' and year_no='$year_no' ")->row()->count;
        // if ($petition_no_case == null) {
        //     $petition_no_case = 1;
        // } 
        $petitioner = $this->session->userdata('appdet');
        //var_dump($petitioner);
        $pattadar = $this->session->userdata('pattadar');
        
        $dags = $this->session->userdata('dag_det');
        
        $i = 1;
        // $financialyeardate = (date('m') < '07') ? date('Y', strtotime('-1 year')) . "-" . date('y') : date('Y') . "-" . date('y', strtotime('+1 year'));

        $dist_code = $location['dist_code'];
        $subdiv_code = $location['subdiv_code'];
        $cir_code = $location['cir_code'];
        $mouza_pargona_code = $location['mouza_pargona_code'];
        $vill_townprt_code = $location['vill_townprt_code'];
        $lot_no = $location['lot_no'];

        // $q = "Select dist_abbr,cir_abbr from location where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code!='00' ";
        // $abbrname = $this->db->query($q)->row();
        // $cir_dist_name = $abbrname->dist_abbr . "/" . $abbrname->cir_abbr;

        // $check_status = TRUE;

        // while($check_status == TRUE){

        //     $case_no = $cir_dist_name . "/" . $financialyeardate . "/" . $petition_no_case . "/" . "OMUT";
        //     $check_existance = $this->db->query("select count(*) as c from    petition_basic where case_no='$case_no'")->row()->c;
        //     if($check_existance<='0'){
        //         $case_no = $cir_dist_name . "/" . $financialyeardate . "/" . $petition_no_case . "/" . "OMUT";
        //         $check_status = FALSE;
        //     }
        //     else{
        //         $petition_no_case = $petition_no_case+1;
        //         //$appln_no = $cername . "/" . $increment_appln_no . "/" . $year_no;
        //     }
        // }




        $case_name=$this->basundharamodel->genearteCaseName();
        $case_no['petition_no']=$petition_no=$this->basundharamodel->genearteOfficePetitionNo();

        $case_no=$case_name.$petition_no."/OMUT";

        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type_code = $this->session->userdata('patta_type');


        if ($this->session->userdata('reg_deed_date') == "") {
            $petition_basic = array(
                'dist_code' => $location['dist_code'],
                'subdiv_code' => $location['subdiv_code'],
                'cir_code' => $location['cir_code'],
                'mouza_pargona_code' => $location['mouza_pargona_code'],
                'lot_no' => $location['lot_no'],
                'vill_townprt_code' => $location['vill_townprt_code'],
                'year_no' => $year_no,
                'petition_no' => $petition_no,
                'case_no' => $case_no,
                'submission_date' => date('Y-m-d G:i:s'),
                'mut_type' => '03',
                'trans_code' => $this->session->userdata('transfer_type'),
                'add_off_name' => $this->session->userdata('add_of_name'),
                'user_code' => $this->user_code,
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E',
            );
        } else {
            $petition_basic = array(
                'dist_code' => $location['dist_code'],
                'subdiv_code' => $location['subdiv_code'],
                'cir_code' => $location['cir_code'],
                'mouza_pargona_code' => $location['mouza_pargona_code'],
                'lot_no' => $location['lot_no'],
                'vill_townprt_code' => $location['vill_townprt_code'],
                'year_no' => $year_no,
                'petition_no' => $petition_no,
                'case_no' => $case_no,
                'submission_date' => date('Y-m-d G:i:s'),
                'mut_type' => '03',
                'trans_code' => $this->session->userdata('transfer_type'),
                'add_off_name' => $this->session->userdata('add_of_name'),
                'user_code' => $this->user_code,
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E',
                'deed_no' => $this->session->userdata('reg_deed_no'),
                'deed_value' => $this->session->userdata('reg_deed_value'),
                'deed_date' => date('Y-m-d', strtotime($this->session->userdata('reg_deed_date')))
            );
        }
        
        $this->db->insert("petition_basic", $petition_basic); //************
        $suomoto = $this->session->userdata('suomoto');
        if ($suomoto != 0) {
            $suomotodata = array('status' => '2');
            $this->db->where('deed_no', $suomoto);
            $this->db->update('sro_note', $suomotodata);
        }
        foreach ($petitioner as $p) {
            if ($p['pet_minor_dob'] != null) {
                $date = date('Y-m-d', strtotime($p['pet_minor_dob']));
            } else {
                $date = null;
            }
            $petitioner_data = array(
                'dist_code' => $location['dist_code'],
                'subdiv_code' => $location['subdiv_code'],
                'cir_code' => $location['cir_code'],
                'mouza_pargona_code' => $location['mouza_pargona_code'],
                'lot_no' => $location['lot_no'],
                'vill_townprt_code' => $location['vill_townprt_code'],
                'year_no' => $year_no,
                'petition_no' => $petition_no,
                'pet_id' => $i++,
                'guard_name' => $p['guard_name'],
                'guard_rel' => $p['guard_rel'],
                'pet_name' => $p['pet_name'],
                //'pet_is_copdar' => $p['pet_is_copdar'],
                'add1' => $p['add1'],
                'add2' => $p['add2'],
                'user_code' => $this->user_code,
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E',
                'new_pattadar' => 'N',
                'pet_gender' => $p['pet_gender'],
                'pet_mother' => $p['pet_mother'],
                'pet_minor_yn' => $p['pet_minor_yn'],
                'pet_minor_dob' => $date,
                'pdar_mobile' => $p['pdar_mobile'],
                'applied_b' => $p['applied_b'],
                'applied_k' => $p['applied_k'],
                'applied_lc' => $p['applied_lc']
            );
            //var_dump($petitioner_data);
            $this->db->insert("petitioner", $petitioner_data); //************
        }
        //var_dump($dags);
        foreach ($dags as $d) {
            $mb += $d['m_dag_area_b'];
            $mk += $d['m_dag_area_k'];
            $mlc += $d['m_dag_area_lc'];

            $dags_data = array(
                'dist_code' => $location['dist_code'],
                'subdiv_code' => $location['subdiv_code'],
                'cir_code' => $location['cir_code'],
                'mouza_pargona_code' => $location['mouza_pargona_code'],
                'lot_no' => $location['lot_no'],
                'vill_townprt_code' => $location['vill_townprt_code'],
                'year_no' => $year_no,
                'petition_no' => $petition_no,
                'm_dag_area_b' => $mb,
                'm_dag_area_k' => $mk,
                'm_dag_area_lc' => $mlc,
                'm_dag_area_g' => $d['m_dag_area_g'],
                'dag_area_b' => $d['dag_area_b'],
                'dag_area_k' => $d['dag_area_k'],
                'dag_area_lc' => $d['dag_area_lc'],
                'dag_area_g' => $d['dag_area_g'],
                'dag_area_kr' => '0',
                //'m_dag_area_kr' => $d['m_dag_area_kr'],
                'patta_no' => trim($this->session->userdata('patta_no')),
                'patta_type_code' => $this->session->userdata('patta_type'),
                'user_code' => $this->user_code,
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E',
                'dag_no' => $d['dag_no']
            );
        }
        $cron_no = 1;
        $dag_no = $dags[0]['dag_no'];

        $m = $mb * 100 + $mk * 20 + $mlc;
        $bigha_r = floor($m / 100.0);
        $katha_r = floor(($m - $bigha_r * 100.0) / 20.0);
        $lessa_r = $m - $bigha_r * 100.0 - $katha_r * 20.0;
        $dags_data['m_dag_area_b'] = $bigha_r;
        $dags_data['m_dag_area_k'] = $katha_r;
        $dags_data['m_dag_area_lc'] = $lessa_r;
        //var_dump($dags_data);

        foreach ($pattadar as $p) {

            $pdar_id = $p['pdar_name'];
            $query = "select p.pdar_id,p.pdar_name,p.pdar_father,p.pdar_add1,p.pdar_add2,p.pdar_add3,p.pdar_guard_reln from    chitha_pattadar p join 
                     chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code 
                    and TRIM(p.patta_no)=TRIM(d.patta_no) and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and
                    p.pdar_id = d.pdar_id where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
                    p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
                    and d.lot_no='$lot_no' and d.dag_no='$dag_no' and TRIM(p.patta_no)='$patta_no' 
                    and p.patta_type_code='$patta_type_code' and p.pdar_id=$pdar_id";

            $data = $this->db->query($query)->result();
            //var_dump($data);
            $values = array();
            $count = 0;
            
            foreach ($data as $value) {

                $relation = "u";
                if ($value->pdar_guard_reln != null)
                $relation = $value->pdar_guard_reln;
                $other_data = array(
                    'dist_code' => $location['dist_code'],
                    'subdiv_code' => $location['subdiv_code'],
                    'cir_code' => $location['cir_code'],
                    'mouza_pargona_code' => $location['mouza_pargona_code'],
                    'lot_no' => $location['lot_no'],
                    'vill_townprt_code' => $location['vill_townprt_code'],
                    'year_no' => $year_no,
                    'petition_no' => $petition_no,
                    'dag_no' => $d['dag_no'],
                    'patta_no' => $patta_no,
                    'patta_type_code' => $patta_type_code,
                    'pdar_id' => $pdar_id,
                    'pdar_cron_no' => $cron_no++,
                    'pdar_name' => $value->pdar_name,
                    'pdar_guardian' => $value->pdar_father,
                    'pdar_rel_guar' => $relation,
                    'pdar_add1' => $value->pdar_add1,
                    'pdar_add2' => $value->pdar_add2,
                    'user_code' => $this->user_code,
                    'date_entry' => date('Y-m-d G:i:s'),
                    'operation' => 'E'
                );
                //var_dump($other_data);
                $this->db->insert("petition_pattadar", $other_data);//************
            }
        }
        //var_dump($dags_data);
        $this->db->insert("petition_dag_details", $dags_data);//************
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->session->set_flashdata("message", "Case Cannot Be Registered. Contact Help Desk with Location Details");
            redirect(base_url() . "index.php/home");
        } else {
            $this->db->trans_commit();
            $this->session->unset_userdata('appdet');
            $this->session->unset_userdata('dag_det');
            //////
            $this->Dashboard($case_no);
            /////
            $msgg = "New Case with case no " . $case_no . " Registered !!";
            foreach ($petitioner as $p) {
                $this->CurlSMS($case_no, $p['phone_no']);
            }

            $this->session->set_userdata(array('case_no' => $case_no));
            redirect(base_url() . "index.php/officemutation/applicant_receipet");
        }
    }
    
    public function applicant_receipet() {
        $db=  $this->session->userdata('db');
        $case_no = $this->session->userdata('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');

        $dist = $this->utilityclass->getDistrictName($dist_code);
        $cir = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);

        $q = "Select * from    petition_basic where dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code' and user_code='$user_code' and case_no = '$case_no'";
        $result = $this->db->query($q)->row();

        $mutation_type_name = $this->db->query("select order_type as mut_name from    master_office_mut_type where order_type_code = '$result->mut_type'")->row()->mut_name;
        $mut_type = $result->mut_type;

        $applicant_name = $this->db->query("select * from    petitioner where dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code' and "
                            . "petition_no='$result->petition_no' and year_no='$result->year_no' ")->result();

        $amount_fees = $this->db->query("select order_amount as amount from    master_fees_mut_type where order_type_code = '$result->mut_type'")->row()->amount;
        $data = array(
            'user_code' => $user_code,
            'current_date' => date('Y-m-d G:i:s'),
            'next_due_date' => $result->date_entry,
            'total_fee_amt' => $amount_fees,
            'case_no' => $case_no,
            'mut_type' => $mut_type,
            'mutation_type_name' => $mutation_type_name,
            'district' => $dist,
            'circle' => $cir,
            'applicant_name' => $applicant_name
        );
        
        // $this->load->view('../views/header');
        // $this->load->view('../views/asstofficemutation/applicant_receipet', $data);
        // $this->load->view('../views/footer');
        $data['_view'] = 'asstofficemutation/applicant_receipet';
        $this->load->view('layouts/main',$data);
    }

    public function sendsms($case_no, $mobno) {
        $msg = "Your Office Mutation Application has been registered with Case No " . $case_no . " has been registered on " . date('d-m-Y');
        header("Location:http://103.8.249.55/smsgwam/form_/send_api_dckam_get.php?username=dckam&password=amingaon&groupname=DEPCOM&to=$mobno&msg=$msg");
    }

    public function CurlSMS($case_no, $mobno) {
        $msg = urlencode("Your Office Mutation Application has been registered with Case No " . $case_no . " on " . date('d-m-Y'));

        $url = "http://103.8.249.55/smsgwam/form_/send_api_dckam_get.php?username=dckam&password=amingaon&groupname=DEPCOM&to=$mobno&msg=" . $msg;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPGET, 1);
        curl_exec($ch);
        curl_close($ch);
    }
    public function issueNotice() {
        //xss & security validation starts
        $errorMessageStr = '';
        $POST_REQUEST = $_POST;
        unset($POST_REQUEST['pageContent']);
        $resp = checkRequestSpecChar($POST_REQUEST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }
        $resp = checkRequestValidQuery($POST_REQUEST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }    
        if($errorMessageStr != ''){
            $this->session->set_flashdata('message1', $errorMessageStr);
            return redirect($_SERVER['HTTP_REFERER']);
        }

        if ($this->input->server('REQUEST_METHOD') == 'GET')
        {
            $case_no = $_GET['case_no'] = dec_param($this->input->get('case_no'), 'case_no');
            if($_GET['case_no'] == null)
            {
                echo json_encode('Sorry !! You are not Authorized to access the content!!');
                return;
            }
            $case_no = $this->input->get('case_no');
        }
        else
        {
            $case_no = $this->input->get('case_no');
        }


        //xss & security validation ends 
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
        //**************validation***************/
        $om_ain = [
            [
                'field' => 'case_no',
                'label' => 'Case-No',
                'rules' => 'required|callback_check_script|max_length[50]|trim|xss_clean'
            ],
            [
                'field' => 'mouza_pargona_code',
                'label' => 'Mouza Pargona Code',
                'rules' => 'required|callback_check_script|max_length[2]|trim|xss_clean'
            ],
            [
                'field' => 'lot_no',
                'label' => 'Lot-No',
                'rules' => 'required|callback_check_script|max_length[2]|trim|xss_clean'
            ],
            [
                'field' => 'vill_townprt_code',
                'label' => 'Village-Code',
                'rules' => 'required|callback_check_script|max_length[5]|trim|xss_clean'
            ],
        ];
        $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
        $this->form_validation->set_rules($om_ain);
        if ($this->form_validation->run() == FALSE)
        {   
            $error_msg = array();
            foreach($om_ain as $rule){
                if (form_error($rule['field'])) {
                    array_push($error_msg, form_error($rule['field']));
                }
            }  
            $this->session->set_flashdata('validation_msg', $error_msg);
            redirect(base_url() . "index.php/home");
            exit;
        }
        //***************************************/
        $this->db->trans_begin();  
        $this->load->model('FileUpload_model');
        $case_no = $this->input->post('case_no');
        //////////File Uplod/////////////
        $result = $this->FileUpload_model->save_notice(($_POST['pageContent']), $case_no);
        ////////////////////////////
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $vill_townprt_code = $this->input->post('vill_townprt_code');
        $append = $this->base_query;
        $query = "update  petition_basic set notice_generated_yn='Y', notice_served_yn='Y', notice_generated_date='" . date('Y-m-d H:i:s') . "' "
                . "where case_no='$case_no' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' "
                . "and vill_townprt_code = '$vill_townprt_code' and $append ";
        $this->db->query($query);
        if($this->db->affected_rows() <= 0)
        {
            $this->db->trans_rollback();
            log_message('error', "#OMAIN001: Updation failed in table 'petition_basic' with case-no :". $case_no);
            $this->session->set_flashdata('message', "Error in Notice Generation. Error Code(#OMAIN001)");
            redirect(base_url() . "index.php/home");
            exit;
        }
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message('error', "#OMAIN002: transaction failed in table 'petition_basic' with case-no :". $case_no);
            $this->session->set_flashdata('message', "Error in Notice Generation. Error Code(#OMAIN002)");
            redirect(base_url() . "index.php/home");
            exit;
        }else{
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');

            //ESCALATION CODE INTEGRATION================SANMRI

            $executionDate = $this->input->post('executionDate');
            $queryForUpdate = "select proceeding_yn,next_date_of_hearing,es_flag from petition_basic"
                ." where case_no='$case_no' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' "
                ." and vill_townprt_code = '$vill_townprt_code' and $append";

            $hearingDateDetails = $this->db->query($queryForUpdate)->row();
            // log_message('error',"LAST QUERY===============".$this->db->last_query());
            // log_message('error',"DATE OF HEARING =========".json_encode($hearingDateDetails));
            if($hearingDateDetails->es_flag == 1 && ESCALATION_ENABLE ==1 && $hearingDateDetails->proceeding_yn == null){
                $this->Escalationmodel->
                $user_code = $this->session->userdata('user_code');
                $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
                $serviceType = explode('/',$basundharaExist);
                $service_code =1;
                if($serviceType[1] == 'MUTD')
                {
                    $service_code = 2;
                }
                $escRow = $this->Escalationmodel->getEscalatedRowDetailsBasic($case_no);
                // as the escalation removed from notice print BHRIGU DA/MRIDU SIR////////////////decided on 20-11-2024
                if($escRow->registerd_on < NOTICE_REMOVED_DATE_OMUT_OPART)
                {
                    // $escalationUpdateStatus = $this->Escalationmodel->escalationDANotice($service_code,$executionDate,$dist_code,$subdiv_code,$cir_code,$case_no,$user_code,$hearingDateDetails->next_date_of_hearing);

                    // log_message("error", "#ESC1052, transaction-error-STATUS======".json_encode($escalationUpdateStatus));
                    // if($escalationUpdateStatus['responseType'] == 0){
                    //     $this->db->trans_rollback();
                    //     log_message("error", "#ESC1052, transaction-error in method 'officemutation/issuenotice' with case-no :". $case_no);
                    //     $this->session->set_flashdata('message', "Something went wrong.OMUT- Error Code(#ESC1052)");
                    //     redirect(base_url() . "index.php/home");
                    // }
                }
                

                ///////////////END ESCALATION//////////////
            }
            $this->db->trans_commit();        

        }   
        //////
        $penUser='LM';
        $rmrk='Notice Generated By Assistant';
        $this->DashboardData($case_no,$penUser,$rmrk);
        /////
        $this->session->set_flashdata(array('message' => "Notice Generated for case no : $case_no"));
        //check if its from    service plus
        $check = $this->db->query("Select * from    petition_basic where case_no='$case_no' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' "
                . "and vill_townprt_code = '$vill_townprt_code' and $append")->row();
        if($check->mode_of_registration == 'citizen'){              
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL,RTPS_LINK."mutation/mutation_notice_query.php");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'applId' => $check->applid,
                'application_ref_no' => $check->application_ref_no,
                'msg' => 'Notice Generated for case no '. $check->application_ref_no .'. Your Date of Hearing is '.$check->next_date_of_hearing,
                //'msg' => 'HearingOn'. date('d-m-Y', strtotime($check->next_date_of_hearing)),
                'notice_generated_yn' => 'Y',
                'notice_generated_date' => $check->notice_generated_date,
                'next_date_of_hearing' => $check->next_date_of_hearing,
            )));
            echo $result = curl_exec($curl_handle);
        }
        $this->session->set_flashdata('success1', "Notice Generated for case no : $case_no");
        return redirect($_SERVER['HTTP_REFERER']);
    } else if ($this->input->server('REQUEST_METHOD') == 'GET') {
        $case_no = $this->input->get('case_no');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');
        $year_no = year_no;
        $detailsQuery = "select * from    petition_basic pb join   petition_dag_details pd on"
                . " pb.dist_code = pd.dist_code and pb.subdiv_code = pd.subdiv_code and pb.cir_code = pd.cir_code and pb.petition_no=pd.petition_no and "
                . " pb.lot_no = pd.lot_no and pb.mouza_pargona_code = pd.mouza_pargona_code and pb.vill_townprt_code = pd.vill_townprt_code"
                . " where pb.case_no = '$case_no' and pb.mouza_pargona_code = '$mouza_pargona_code' and pb.lot_no = '$lot_no' and pb.vill_townprt_code = '$vill_townprt_code'";
        
        $details = $this->db->query($detailsQuery)->row();
        $data['details'] = $details;

        $applicantQuery = "select * from    petitioner where petition_no = $details->petition_no and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' "
                . "and vill_townprt_code = '$vill_townprt_code' and $this->base_query";
        $applicants = $this->db->query($applicantQuery)->result();
        $data['applicants'] = $applicants;

        $pattadarQuery = "select * from    petition_pattadar where petition_no = $details->petition_no and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' "
                . "and vill_townprt_code = '$vill_townprt_code' and dag_no='$details->dag_no' and $this->base_query";
        $pattadars = $this->db->query($pattadarQuery)->result();
        
        $notifyPerson="Select * from    petition_notified where petition_no = $details->petition_no and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' "
                . "and vill_townprt_code = '$vill_townprt_code' and $this->base_query";
        $data['notifyname']= $this->db->query($notifyPerson)->result();
        
        $data['pattadars'] = $pattadars;
        $data['case_no'] = $case_no;
        // $this->load->view('../views/header');
        // $this->load->view('../views/asstofficemutation/notice', $data);
        // $this->load->view('../views/footer');
        $dist_code = $this->session->userdata('dist_code');
        if(in_array($dist_code, json_decode(BARAK_VALLEY)))
        {
           $data['_view'] = 'asstofficemutation/notice_kar';
        }
        else{
            $data['_view'] = 'asstofficemutation/notice';
        }
        //$data['_view'] = 'asstofficemutation/notice';
        $this->load->view('layouts/main',$data);
    }
}

    // Added by Abhijit -- 2024-04-26
    public function multiGenIssueNotice() {
        if(MULTIGENERATION_ACTIVE != 1){
            return $this->issueNotice();
        }
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
            $this->session->set_flashdata('message1', $errorMessageStr);
            return redirect($_SERVER['HTTP_REFERER']);
        }
        //xss & security validation ends 
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            //**************validation***************/
            $om_ain = [
                [
                    'field' => 'case_no',
                    'label' => 'Case-No',
                    'rules' => 'required|callback_check_script|max_length[50]|trim|xss_clean'
                ],
                [
                    'field' => 'mouza_pargona_code',
                    'label' => 'Mouza Pargona Code',
                    'rules' => 'required|callback_check_script|max_length[2]|trim|xss_clean'
                ],
                [
                    'field' => 'lot_no',
                    'label' => 'Lot-No',
                    'rules' => 'required|callback_check_script|max_length[2]|trim|xss_clean'
                ],
                [
                    'field' => 'vill_townprt_code',
                    'label' => 'Village-Code',
                    'rules' => 'required|callback_check_script|max_length[5]|trim|xss_clean'
                ],
            ];
            $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
            $this->form_validation->set_rules($om_ain);
            if ($this->form_validation->run() == FALSE)
            {   
                $error_msg = array();
                foreach($om_ain as $rule){
                    if (form_error($rule['field'])) {
                        array_push($error_msg, form_error($rule['field']));
                    }
                }  
                $this->session->set_flashdata('validation_msg', $error_msg);
                redirect(base_url() . "index.php/home");
                exit;
            }
            //***************************************/
            $this->db->trans_begin();  
            $case_no = $this->input->post('case_no');
            $mouza_pargona_code = $this->input->post('mouza_pargona_code');
            $lot_no = $this->input->post('lot_no');
            $vill_townprt_code = $this->input->post('vill_townprt_code');
            $append = $this->base_query;
            $query = "update  petition_basic set notice_generated_yn='Y', notice_served_yn='Y', notice_generated_date='" . date('Y-m-d G:i:s') . "' "
                    . "where case_no='$case_no' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' "
                    . "and vill_townprt_code = '$vill_townprt_code' and $append ";
            $this->db->query($query);
            if($this->db->affected_rows() <= 0)
            {
                $this->db->trans_rollback();
                log_message('error', "#MULGENOMAIN001: Updation failed in table 'petition_basic' with case-no :". $case_no);
                $this->session->set_flashdata('message', "Error in Notice Generation. Error Code(#MULGENOMAIN001)");
                redirect(base_url() . "index.php/home");
                exit;
            }
            if($this->db->trans_status()==FALSE){
                $this->db->trans_rollback();
                log_message('error', "#MULGENOMAIN002: transaction failed in table 'petition_basic' with case-no :". $case_no);
                $this->session->set_flashdata('message', "Error in Notice Generation. Error Code(#MULGENOMAIN002)");
                redirect(base_url() . "index.php/home");
                exit;
            }else{

                //ESCALATION CODE INTEGRATION================SANMRI

                $executionDate = $this->input->post('executionDate');
                $queryForUpdate = "select next_date_of_hearing,es_flag from petition_basic"
                    ." where case_no='$case_no' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' "
                    ." and vill_townprt_code = '$vill_townprt_code' and $append";

                $hearingDateDetails = $this->db->query($queryForUpdate)->row();
                log_message('error',"LAST QUERY===============".$this->db->last_query());
                log_message('error',"DATE OF HEARING =========".json_encode($hearingDateDetails));
                if($hearingDateDetails->es_flag == 1 && ESCALATION_ENABLE ==1){
      
                    $user_code = $this->session->userdata('user_code');
                    $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
                    $serviceType = explode('/',$basundharaExist);
                    $service_code =1;
                    if($serviceType[1] == 'MUTD')
                    {
                        $service_code = 2;
                    }

                    $escalationUpdateStatus = $this->Escalationmodel->escalationDANotice($service_code,$executionDate,$dist_code,$subdiv_code,$cir_code,$case_no,$user_code,$hearingDateDetails->next_date_of_hearing);

                    log_message("error", "#ESC1052, transaction-error-STATUS======".json_encode($escalationUpdateStatus));
                    if($escalationUpdateStatus['responseType'] == 0){
                        $this->db->trans_rollback();
                        log_message("error", "#ESC1052, transaction-error in method 'officemutation/issuenotice' with case-no :". $case_no);
                        $this->session->set_flashdata('message', "Something went wrong.OMUT- Error Code(#ESC1052)");
                        redirect(base_url() . "index.php/home");
                    }

                
                }
                ///////////////END ESCALATION//////////////
                $this->db->trans_commit();
            }   
            //////
            $penUser='LM';
            $rmrk='Notice Generated By Assistant';
            $this->DashboardData($case_no,$penUser,$rmrk);
            /////
            $this->session->set_flashdata(array('message' => "Notice Generated for case no : $case_no"));
            //check if its from    service plus
            $check = $this->db->query("Select * from    petition_basic where case_no='$case_no' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' "
                    . "and vill_townprt_code = '$vill_townprt_code' and $append")->row();
            if($check->mode_of_registration == 'citizen'){    
                $url = RTPS_LINK."mutation/mutation_notice_query.php";
                $update_arr = [
                                'applId' => $check->applid,
                                'application_ref_no' => $check->application_ref_no,
                                'msg' => 'Notice Generated for case no '. $check->application_ref_no .'. Your Date of Hearing is '.$check->next_date_of_hearing,
                                //'msg' => 'HearingOn'. date('d-m-Y', strtotime($check->next_date_of_hearing)),
                                'notice_generated_yn' => 'Y',
                                'notice_generated_date' => $check->notice_generated_date,
                                'next_date_of_hearing' => $check->next_date_of_hearing,
                            ];
                $result = sendCurlRequest($url, 'POST');
                echo $result;
            }
            $this->session->set_flashdata('success1', "Notice Generated for case no : $case_no");
            return redirect($_SERVER['HTTP_REFERER']);
        } else if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $case_no = $this->input->get('case_no');
            $mouza_pargona_code = $this->input->get('mouza_pargona_code');
            $lot_no = $this->input->get('lot_no');
            $vill_townprt_code = $this->input->get('vill_townprt_code');
            $year_no = year_no;
            $detailsQuery = "select * from    petition_basic pb join   petition_dag_details pd on"
                    . " pb.dist_code = pd.dist_code and pb.subdiv_code = pd.subdiv_code and pb.cir_code = pd.cir_code and pb.petition_no=pd.petition_no and "
                    . " pb.lot_no = pd.lot_no and pb.mouza_pargona_code = pd.mouza_pargona_code and pb.vill_townprt_code = pd.vill_townprt_code"
                    . " where pb.case_no = '$case_no' and pb.mouza_pargona_code = '$mouza_pargona_code' and pb.lot_no = '$lot_no' and pb.vill_townprt_code = '$vill_townprt_code'";
            
            $details = $this->db->query($detailsQuery)->result();
            $petition_nos = $dag_nos = [];
            foreach($details as $detail){
                array_push($petition_nos, "'" . $detail->petition_no . "'");
                array_push($dag_nos,  "'" . $detail->dag_no . "'");

                $pattadarQuery = "select * from petition_pattadar where petition_no = ? and mouza_pargona_code = ? and lot_no = ? "
                    . "and vill_townprt_code = ? and dag_no = ? and $this->base_query";
                $pattadars = $this->db->query($pattadarQuery, array($detail->petition_no, $mouza_pargona_code, $lot_no, $vill_townprt_code, $detail->dag_no))->result();
                
                $applicantQuery = "select * from petitioner where petition_no = ? and mouza_pargona_code = ? and lot_no = ? "
                    . "and vill_townprt_code = ? and $this->base_query";
                $applicants = $this->db->query($applicantQuery, array($detail->petition_no, $mouza_pargona_code, $lot_no, $vill_townprt_code))->result();

                $detail->pattadars = $pattadars;
                $detail->applicants = $applicants;
            }
            
            $data['details'] = $details;

            $applicantQuery = "select * from petitioner where petition_no in (" . implode(',', $petition_nos) . ") and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' "
                    . "and vill_townprt_code = '$vill_townprt_code' and $this->base_query";
            $applicants = $this->db->query($applicantQuery)->result();
            $data['applicants'] = $applicants;

            // $pattadarQuery = "select * from petition_pattadar where petition_no in (" . implode(',', $petition_nos) . ") and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' "
            //         . "and vill_townprt_code = '$vill_townprt_code' and dag_no in (" . implode(',', $dag_nos) . ") and $this->base_query";
            // $pattadars = $this->db->query($pattadarQuery)->result();
            
            $notifyPerson="Select * from petition_notified where petition_no in (" . implode(',', $petition_nos) . ") and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' "
                    . "and vill_townprt_code = '$vill_townprt_code' and $this->base_query";
            $data['notifyname']= $this->db->query($notifyPerson)->result();
            
            // $data['pattadars'] = $pattadars;
            $data['case_no'] = $case_no;
            
            $dist_code = $this->session->userdata('dist_code');
            if(in_array($dist_code, json_decode(BARAK_VALLEY)))
            {
                $data['_view'] = 'asstofficemutation/multi-gen-notice_kar';
            }
            else{
                $data['_view'] = 'asstofficemutation/multi-gen-notice';
            }
            //$data['_view'] = 'asstofficemutation/notice';

            $this->load->view('layouts/main',$data);
        }
    }

    // Added by Abhijit -- 2024-04-23
    public function multiDagIssueNotice() {
        // if(MULTI_DAG_MUTATION_DEED_ACTIVE != 1){
        //     return $this->issueNotice();
        // }
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
            $this->session->set_flashdata('message1', $errorMessageStr);
            return redirect($_SERVER['HTTP_REFERER']);
        }
        //xss & security validation ends 
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            //**************validation***************/
            $om_ain = [
                [
                    'field' => 'case_no',
                    'label' => 'Case-No',
                    'rules' => 'required|callback_check_script|max_length[50]|trim|xss_clean'
                ],
                [
                    'field' => 'mouza_pargona_code',
                    'label' => 'Mouza Pargona Code',
                    'rules' => 'required|callback_check_script|max_length[2]|trim|xss_clean'
                ],
                [
                    'field' => 'lot_no',
                    'label' => 'Lot-No',
                    'rules' => 'required|callback_check_script|max_length[2]|trim|xss_clean'
                ],
                [
                    'field' => 'vill_townprt_code',
                    'label' => 'Village-Code',
                    'rules' => 'required|callback_check_script|max_length[5]|trim|xss_clean'
                ],
            ];
            $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
            $this->form_validation->set_rules($om_ain);
            if ($this->form_validation->run() == FALSE)
            {   
                $error_msg = array();
                foreach($om_ain as $rule){
                    if (form_error($rule['field'])) {
                        array_push($error_msg, form_error($rule['field']));
                    }
                }  
                $this->session->set_flashdata('validation_msg', $error_msg);
                redirect(base_url() . "index.php/home");
                exit;
            }
            //***************************************/
            $this->db->trans_begin();  
            $case_no = $this->input->post('case_no');
            $mouza_pargona_code = $this->input->post('mouza_pargona_code');
            $lot_no = $this->input->post('lot_no');
            $vill_townprt_code = $this->input->post('vill_townprt_code');
            $append = $this->base_query;
            
            $application = $this->db->query('select * from petition_basic where case_no=?', array($case_no))->row();
            if(!$application){
                $this->session->set_flashdata('message',"No such case found.");
                return redirect('/home');
            }
            
            // if(MULTI_DAG_MUTATION_DEED_ACTIVE != 1 || $application->is_multidag != 'Y'){
            if($application->is_multidag != 'Y'){
                $this->session->set_flashdata('message',"This service is inactive for now.");
                return redirect('/home');
            }

            $query = "update  petition_basic set notice_generated_yn='Y', notice_served_yn='Y', notice_generated_date='" . date('Y-m-d G:i:s') . "' "
                    . "where case_no='$case_no' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' "
                    . "and vill_townprt_code = '$vill_townprt_code' and $append ";
            $this->db->query($query);
            if($this->db->affected_rows() <= 0)
            {
                $this->db->trans_rollback();
                log_message('error', "#MULOMAIN001: Updation failed in table 'petition_basic' with case-no :". $case_no);
                $this->session->set_flashdata('message', "Error in Notice Generation. Error Code(#MULOMAIN001)");
                redirect(base_url() . "index.php/home");
                exit;
            }
            if($this->db->trans_status()==FALSE){
                $this->db->trans_rollback();
                log_message('error', "#MULOMAIN002: transaction failed in table 'petition_basic' with case-no :". $case_no);
                $this->session->set_flashdata('message', "Error in Notice Generation. Error Code(#MULOMAIN002)");
                redirect(base_url() . "index.php/home");
                exit;
            }else{

                //ESCALATION CODE INTEGRATION================SANMRI

                $executionDate = $this->input->post('executionDate');
                $queryForUpdate = "select next_date_of_hearing,es_flag from petition_basic"
                    ." where case_no='$case_no' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' "
                    ." and vill_townprt_code = '$vill_townprt_code' and $append";

                $hearingDateDetails = $this->db->query($queryForUpdate)->row();
                log_message('error',"LAST QUERY===============".$this->db->last_query());
                log_message('error',"DATE OF HEARING =========".json_encode($hearingDateDetails));
                if($hearingDateDetails->es_flag == 1 && ESCALATION_ENABLE ==1){
                    $user_code = $this->session->userdata('user_code');
                    $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
                    $serviceType = explode('/',$basundharaExist);
                    $service_code =1;
                    if($serviceType[1] == 'MUTD')
                    {
                        $service_code = 2;
                    }
                    $escalationUpdateStatus = $this->Escalationmodel->escalationDANotice($service_code,$executionDate,$dist_code,$subdiv_code,$cir_code,$case_no,$user_code,$hearingDateDetails->next_date_of_hearing);

                    log_message("error", "#ESC1052, transaction-error-STATUS======".json_encode($escalationUpdateStatus));
                    if($escalationUpdateStatus['responseType'] == 0){
                        $this->db->trans_rollback();
                        log_message("error", "#ESC1052, transaction-error in method 'officemutation/issuenotice' with case-no :". $case_no);
                        $this->session->set_flashdata('message', "Something went wrong.OMUT- Error Code(#ESC1052)");
                        redirect(base_url() . "index.php/home");
                    }
                }
                ///////////////END ESCALATION//////////////


                $this->db->trans_commit();
            }   
            //////
            $penUser='LM';
            $rmrk='Notice Generated By Assistant';
            $this->DashboardData($case_no,$penUser,$rmrk);
            /////
            $this->session->set_flashdata(array('message' => "Notice Generated for case no : $case_no"));
            //check if its from    service plus
            $check = $this->db->query("Select * from    petition_basic where case_no='$case_no' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' "
                    . "and vill_townprt_code = '$vill_townprt_code' and $append")->row();
            if($check->mode_of_registration == 'citizen'){    
                $url = RTPS_LINK."mutation/mutation_notice_query.php";
                $update_arr = [
                                'applId' => $check->applid,
                                'application_ref_no' => $check->application_ref_no,
                                'msg' => 'Notice Generated for case no '. $check->application_ref_no .'. Your Date of Hearing is '.$check->next_date_of_hearing,
                                //'msg' => 'HearingOn'. date('d-m-Y', strtotime($check->next_date_of_hearing)),
                                'notice_generated_yn' => 'Y',
                                'notice_generated_date' => $check->notice_generated_date,
                                'next_date_of_hearing' => $check->next_date_of_hearing,
                            ];
                $result = sendCurlRequest($url, 'POST');
                echo $result;
            }
            $this->session->set_flashdata('success1', "Notice Generated for case no : $case_no");
            return redirect($_SERVER['HTTP_REFERER']);
        } else if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $case_no = $this->input->get('case_no');
            $application = $this->db->query('select * from petition_basic where case_no=?', array($case_no))->row();
            if(!$application){
                $this->session->set_flashdata('message',"No such case found.");
                return redirect('/home');
            }
            
            // if(MULTI_DAG_MUTATION_DEED_ACTIVE != 1 || $application->is_multidag != 'Y'){
            if($application->is_multidag != 'Y'){
                $this->session->set_flashdata('message',"This service is inactive for now.");
                return redirect('/home');
            }

            $mouza_pargona_code = $this->input->get('mouza_pargona_code');
            $lot_no = $this->input->get('lot_no');
            $vill_townprt_code = $this->input->get('vill_townprt_code');
            $year_no = year_no;
            $detailsQuery = "select * from    petition_basic pb join   petition_dag_details pd on"
                    . " pb.dist_code = pd.dist_code and pb.subdiv_code = pd.subdiv_code and pb.cir_code = pd.cir_code and pb.petition_no=pd.petition_no and "
                    . " pb.lot_no = pd.lot_no and pb.mouza_pargona_code = pd.mouza_pargona_code and pb.vill_townprt_code = pd.vill_townprt_code"
                    . " where pb.case_no = '$case_no' and pb.mouza_pargona_code = '$mouza_pargona_code' and pb.lot_no = '$lot_no' and pb.vill_townprt_code = '$vill_townprt_code'";
            
            // $details = $this->db->query($detailsQuery)->row();
            $details = $this->db->query($detailsQuery)->result();
            $petition_nos = $dag_nos = [];
            foreach($details as $detail){
                array_push($petition_nos, "'" . $detail->petition_no . "'");
                array_push($dag_nos,  "'" . $detail->dag_no . "'");

                $pattadarQuery = "select * from petition_pattadar where petition_no = ? and mouza_pargona_code = ? and lot_no = ? "
                    . "and vill_townprt_code = ? and dag_no = ? and $this->base_query";
                $pattadars = $this->db->query($pattadarQuery, array($detail->petition_no, $mouza_pargona_code, $lot_no, $vill_townprt_code, $detail->dag_no))->result();
                
                $applicantQuery = "select * from petitioner where petition_no = ? and mouza_pargona_code = ? and lot_no = ? "
                    . "and vill_townprt_code = ? and $this->base_query";
                $applicants = $this->db->query($applicantQuery, array($detail->petition_no, $mouza_pargona_code, $lot_no, $vill_townprt_code))->result();

                $detail->pattadars = $pattadars;
                $detail->applicants = $applicants;
            }
            
            $data['details'] = $details;

            $applicantQuery = "select * from petitioner where petition_no in (" . implode(',', $petition_nos) . ") and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' "
                    . "and vill_townprt_code = '$vill_townprt_code' and $this->base_query";
            $applicants = $this->db->query($applicantQuery)->result();
            $data['applicants'] = $applicants;

            // $pattadarQuery = "select * from petition_pattadar where petition_no in (" . implode(',', $petition_nos) . ") and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' "
            //         . "and vill_townprt_code = '$vill_townprt_code' and dag_no in (" . implode(',', $dag_nos) . ") and $this->base_query";
            // $pattadars = $this->db->query($pattadarQuery)->result();
            
            $notifyPerson="Select * from petition_notified where petition_no in (" . implode(',', $petition_nos) . ") and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' "
                    . "and vill_townprt_code = '$vill_townprt_code' and $this->base_query";
            $data['notifyname']= $this->db->query($notifyPerson)->result();
            
            // $data['pattadars'] = $pattadars;
            $data['case_no'] = $case_no;
            // $this->load->view('../views/header');
            // $this->load->view('../views/asstofficemutation/notice', $data);
            // $this->load->view('../views/footer');
            $dist_code = $this->session->userdata('dist_code');
            if(in_array($dist_code, json_decode(BARAK_VALLEY)))
            {
                $data['_view'] = 'asstofficemutation/multi-dag-notice_kar';
            }
            else{
                $data['_view'] = 'asstofficemutation/multi-dag-notice';
            }
            //$data['_view'] = 'asstofficemutation/notice';

            $this->load->view('layouts/main',$data);
        }
    }
    
    public function getPendingNoticeGeneration() {
        $this->load->library('pagination');
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            redirect(base_url() . "index.php/home");
        } else if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $this->config->load('pagination_config');
            $page_config = $this->config->item('pg');
            $page_config['base_url'] = base_url() . '/index.php/officemutation/getPendingNoticeGeneration';
            $append = $this->base_query;
            
            $count_query = "SELECT count(*) as c from    Petition_basic where not_fresh='Y' and mut_type='03' and notice_generated_yn is null and $append ";
            $page_config['total_rows'] = $this->db->query($count_query)->row()->c;

            $this->pagination->initialize($page_config);
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $query ="Select *,ba.basundhara from petition_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree  where fmb.not_fresh='Y' and notice_generated_yn is null and fmb.mut_type='03' and fmb.status='P' and $append  order by submission_date desc  ";
            $data['cases'] = $this->db->query($query)->result();

            foreach($data['cases'] as $rows) {

                if(ESCALATION_ENABLE == 1 ){
                    if($rows->es_flag == '1'){

                        $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);

                        // log_message('error', '#1141: From escalation_detail_table : '.json_encode($escRow)); 

                        $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_other, $escRow->da_target_days, $escRow->assigned_other_date, $escRow->assigned_other_es_date, $rows->date_entry)); 

                        // log_message('error', '#1146: Escalation details : '.json_encode($escData)); 

                        $rows->escalation_date = $escData->escalation_date;
                        $rows->escalation_zone = $escData->escalation_zone;
                        $rows->assigned_date   = $escData->assigned_date;
                    }
                    else {
                        $rows->escalation_date = 'NA';
                        $rows->escalation_zone = 'NA';
                    }
                }

                
            }

            $data['_view'] = 'asstofficemutation/noticegeneration';
            $this->load->view('layouts/main',$data);
        }
    }

    public function getPendingactionTakenReport() {
            $db=  $this->session->userdata('db');
        // $query = "SELECT * from    Petition_basic WHERE not_fresh='Y' and mut_type='03' and status != 'F' and proceeding_yn is null and $this->base_query ";
        $query = "Select *,ba.basundhara from petition_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree  WHERE fmb.not_fresh='Y' and fmb.mut_type='03' and fmb.status != 'F' and fmb.proceeding_yn is null and fmb.notice_generated_yn is not null and $this->base_query ";
        $cases = $this->db->query($query)->result();
        $data['cases'] = $cases;

        foreach($data['cases'] as $rows) {

            if($rows->es_flag == '1' && ESCALATION_ENABLE == 1){

                $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);

                // log_message('error', '#1175: From escalation_detail_table : '.json_encode($escRow)); 
                if(!empty($escRow) && $escRow != null){
                    $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_other, $escRow->da_target_days, $escRow->assigned_other_date, $escRow->assigned_other_es_date, $rows->date_entry)); 

                    // log_message('error', '#1179: Escalation details : '.json_encode($escData));

                    if($escRow->assigned_other_date < date('Y-m-d H:i:s')) {
                        $rows->escalation_date = $escData->escalation_date;
                        $rows->escalation_zone = $escData->escalation_zone;
                        $rows->assigned_date   = $escData->assigned_date;    
                    }
                    else {
                        $rows->escalation_date = 'NA';
                        $rows->escalation_zone = 'NA';
                    } 
                }else{
                    $rows->escalation_date = 'NA';
                    $rows->escalation_zone = 'NA';
                }   
                               
            }
            else {
                $rows->escalation_date = 'NA';
                $rows->escalation_zone = 'NA';
            }
        }



        // $this->load->view('../views/header');
        // $this->load->view('../views/asstofficemutation/actiontakenreport', $data);
        // $this->load->view('../views/footer');
        $data['_view'] = 'asstofficemutation/actiontakenreport';
        $this->load->view('layouts/main',$data);
    }

    public function writeNote() {
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
                $this->session->set_flashdata('message', $errorMessageStr);
                return redirect($_SERVER['HTTP_REFERER']);
            }

            if ($this->input->server('REQUEST_METHOD') == 'GET')
            {
                $case_no = $_GET['case_no'] = dec_param($this->input->get('case_no'), 'case_no');
                if($_GET['case_no'] == null)
                {
                    echo json_encode('Sorry !! You are not Authorized to access the content!!');
                    return;
                }
                $case_no = $this->input->get('case_no');
            }
            else
            {
                $case_no = $this->input->get('case_no');
            }
            //xss & security validation ends 
            if ($this->input->server('REQUEST_METHOD') == 'POST') {
                // --- Step 1: Base validation rules ---
                $om_act = [
                    [
                        'field' => 'case_no',
                        'label' => 'Case-No',
                        'rules' => 'required|callback_check_script|max_length[50]|trim|xss_clean'
                    ]
                ];
                // --- Step 2: Add dynamic validation for proceeding_id[] + note[] ---
                $proceeding_ids = $this->input->post('proceeding_id');
                $notes = $this->input->post('note');
                if (is_array($proceeding_ids)) {
                    foreach ($proceeding_ids as $pid) {
                        // Add rule for its corresponding note
                        $om_act[] = [
                            'field' => "note[$pid]",
                            'label' => "Note for Proceeding Id ($pid)",
                            'rules' => 'required|callback_check_script|trim|xss_clean'
                        ];
                    }
                } else {
                    // fallback single entry validation
                    $om_act[] = [
                        'field' => 'proceeding_id_n',
                        'label' => 'Proceeding Id',
                        'rules' => 'required|integer|less_than_equal_to[32766]|greater_than_equal_to[0]'
                    ];
                    $om_act[] = [
                        'field' => 'note_n',
                        'label' => 'Note',
                        'rules' => 'required|callback_check_script|trim|xss_clean'
                    ];
                }

                // --- Step 3: Apply all rules ---
                $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
                $this->form_validation->set_rules($om_act);
            if ($this->form_validation->run() == FALSE)
            {   
                $error_msg = array();
                foreach($om_act as $rule){
                    if (form_error($rule['field'])) {
                        array_push($error_msg, form_error($rule['field']));
                    }
                }  
                $this->session->set_flashdata('validation_msg', $error_msg);
                redirect(base_url() . "index.php/home");
                exit;
            }
            //***************************************/
            $this->db->trans_begin();  
            $notes = $this->input->post('note');
            $case_no = $this->input->post('case_no');
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code'); // $location['subdiv_code'];
            $cir_code = $this->session->userdata('cir_code'); // $location['cir_code'];
            //////////////UPLOAD ATTACHMENT//////////////////////
            if (empty($_FILES['upload_consent_report']['name'])) {
                echo "Error: No file selected!";
                return;
            }
            $this->load->model('FileUpload_model');
            $result = $this->FileUpload_model->upload_file('upload_consent_report', $case_no);
            if ($result['status']) {
                log_message('error',"FILES-SAVED-SUCCESSFULLY###$case_no".$result['data']['file_name']);
            } else {
                $this->session->set_flashdata('message', "ERROR IN UPLOADING FILE".$result['error']);
                return redirect($_SERVER['HTTP_REFERER']);
            }
            //////////////////////////////////
            $notice_count=$this->db->query("Select * from petition_basic where case_no=? and not_fresh='Y' and mut_type='03' and status != 'F' and proceeding_yn is null and notice_generated_yn is null",array($case_no));
            if($notice_count->num_rows()>0){
                $this->db->trans_rollback();
                $data=array(
                    'error'=>"#ERROMUT-NOTICE-SERVE-EMPTY-7779 : Error in submitting . Please Serve Notice First After that you should be allowed to report action-taken-report"
                );
                echo json_encode($data);
                return false;
            }
            //ESCALATION ==============
            $es_flag_data = $this->db->query("select es_flag,out_of_esc from petition_basic where case_no=?",array($case_no))->row();
            if(ESCALATION_ENABLE == 1 && $es_flag_data->es_flag == 1 && ESCALATION_REMARK_ENABLE == 1 && $es_flag_data->out_of_esc == 0)
            {

                $responseEsc = $this->Escalationmodel->escalationRemarkCheckandUpdate($case_no,$this->input->post('esc_remark'),$this->session->userdata('user_desig_code'));
                if($responseEsc['responseType'] == 1)
                {
                    $this->db->trans_rollback();
                    $data=array(
                        'error'=>"#ERROMUTESCREMARK1735 : Error in submitting in escalation remarks. Please try Again"
                    );
                    echo json_encode($data);
                    return false;
                }

            }
            ///END+==================


            foreach ($notes as $key => $value) {
                echo $key . "=>" . $value;
                $user_code = $this->session->userdata('user_code');
                $query = "update  petition_proceeding set note_on_order='$value',user_code='$user_code' where case_no='$case_no' and dist_code='$dist_code' "
                        . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and proceeding_id=$key;";
                $this->db->query($query);
                if($this->db->affected_rows() <= 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', "#OMAAT003: Updation failed in table 'petition_proceeding' with case-no :". $case_no);
                    $this->session->set_flashdata('message', "Error in Action Taken Report Generation. Error Code(#OMAAT003)");
                    redirect(base_url() . "index.php/home");
                    exit;
                }
                $query = "update  petition_basic set proceeding_yn='1' where case_no='$case_no'";
                $this->db->query($query);
                if($this->db->affected_rows() <= 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', "#OMAAT001: Updation failed in table 'petition_basic' with case-no :". $case_no);
                    $this->session->set_flashdata('message', "Error in Action Taken Report Generation. Error Code(#OMAAT001)");
                    redirect(base_url() . "index.php/home");
                    exit;
                }
                if($this->db->trans_status()==FALSE){
                    $this->db->trans_rollback();
                    log_message('error', "#OMAAT002: transaction failed in table 'petition_basic','petition_proceeding' with case-no :". $case_no);
                    $this->session->set_flashdata('message', "Error in Action Taken Report Generation. Error Code(#OMAAT002)");
                    redirect(base_url() . "index.php/home");
                    exit;
                }else{



                    //ESCALATION CODE INTEGRATION================SANMRI
                    $query1 = "select es_flag,out_of_esc,lm_note_yn from petition_basic where case_no='$case_no'";
                    $data = $this->db->query($query1)->row();
                    if($data->es_flag == 1 && ESCALATION_ENABLE ==1 && $data->out_of_esc == 0){
                        $executionDate = $this->input->post('executionDate');
                        $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
                        $serviceType = explode('/',$basundharaExist);
                        $service_code =1;
                        if($serviceType[1] == 'MUTD')
                        {
                            $service_code = 2;
                        }
                        if($data->lm_note_yn == 'Y' || $data->lm_note_yn == 'y')
                        {
                            $executionDate = date('Y-m-d H:i:s');
                        }
                        else
                        {
                            $executionDate = date('Y-m-d H:i:s');
                        }
                        $escalationUpdateStatus = $this->Escalationmodel->escalationDAAction($service_code,$executionDate,$dist_code,$subdiv_code,$cir_code,$case_no,$user_code);
                        log_message("error", "#ESC1333, transaction-error-STATUS======".json_encode($escalationUpdateStatus));
                        if($escalationUpdateStatus['responseType'] == 0){
                            $this->db->trans_rollback();
                            log_message("error", "#ESC1333, transaction-error in method 'officemutation/writenote' with case-no :". $case_no);
                            $this->session->set_flashdata('message', "Something went wrong. Error Code(#ESC1333)");
                            redirect(base_url() . "index.php/home");
                        }
                        
                    }
                    ///END ESCALATION==============

                    
                    $this->db->trans_commit();
                    
                }  
                //////
                $penUser='LM';
                $rmrk='Action taken report given by Assistant';
                $this->DashboardData($case_no,$penUser,$rmrk);
                /////
                $this->session->set_flashdata(array('message' => "Action taken report given for case no $case_no"));
                redirect(base_url() . "index.php/home");
            }
        } else if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code'); 
            $cir_code = $this->session->userdata('cir_code'); 
            $mouza_pargona_code = $this->input->get('mouza_pargona_code');
            $lot_no = $this->input->get('lot_no');
            $vill_townprt_code = $this->input->get('vill_townprt_code');
            $case_no = $this->input->get('case_no');
            $data['case_no'] = $case_no;
            $dist_code_name = $this->utilityclass->getDistrictName($dist_code);
            $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,date_entry,add_off_name,next_date_of_hearing,petition_no "
                    . "from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row_array();
            
            $this->db->select('*');
            $this->db->from('petition_proceeding');
            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('cir_code', $cir_code);
            $this->db->where('case_no', $case_no);
            $this->db->like('user_code', 'CO', 'after');   // user_code LIKE 'CO%'
            $this->db->where('note_on_order IS NULL', null, false); // IS NULL check (CI2 style)
            $query = $this->db->get();
            if ($query && $query->num_rows() > 0) {
                $data['details'] = $query->result();   // single object
            } else {
                $data['details'] = null; // no record found
            }
            
            $query1 = "select * from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
            $petition_basic = $this->db->query($query1)->row();
            //var_dump($petition_basic);
            $data['location'] = array(
                'dist' => $dist_code_name,
                'sub' => $subdiv_code,
                'cir' => $cir_code,
                'mouza' => $mouza_pargona_code,
                'lot' => $lot_no,
                'vill' => $vill_townprt_code,
                'case_no' => $case_no,
                'date' => $location['date_entry'],
                'add_to' => $location['add_off_name'],
                'case_no' => $case_no,
                'date_of_hearing' => $location['next_date_of_hearing'],
                'application_ref_no' => $petition_basic->application_ref_no,
            );


            //ESCALATED CASES REMARK ENTRY FORM==============
            $data['es_flag'] = $petition_basic->es_flag;
            if(ESCALATION_ENABLE == 1 && ESCALATION_REMARK_ENABLE == 1 && $petition_basic->es_flag == 1)
            {

                $escRemarkData = $this->Escalationmodel->getEscalationRemarkDetails($case_no,$this->session->userdata('user_desig_code'),$this->session->userdata('user_code'));
                if(isset($escRemarkData) && !empty($escRemarkData))
                {
                    $data['escRemarkData'] = $escRemarkData;
                }
            }
            ///END REMARKS/////////


            $data['_view'] = 'asstofficemutation/writenote';
            $this->load->view('layouts/main',$data);
        }
    }

    public function lmReport() {
        $db=  $this->session->userdata('db');
        $append = $this->base_query;
        $case_no = $this->input->get('case_no');
        $data['case_no'] = $case_no;

        $caseDetails = $this->db->query("select * from    petition_basic where case_no=? and " . $append,array($case_no))->row();
        if(MULTIGENERATION_ACTIVE ==1){
            if($caseDetails->is_multigeneration == "M" || $caseDetails->is_multigeneration =='S'){
                return $this->lmReportMultiGen($case_no);
            }
        }

        // Added by Abhijit -- 2024-04-29
        if(MULTI_DAG_MUTATION_DEED_ACTIVE == 1){
            $case_parts = explode('/', $case_no);
            $service_code = end($case_parts);
            if($service_code == 'OMUT'){
                return $this->lmReportForMultidag($case_no);
            }
        }

        $petition = $this->db->query("select * from    petition_basic where case_no='$case_no' and " . $append)->row()->petition_no;
        $dag_details = $this->db->query("select * from    petition_dag_details where petition_no=$petition and $this->base_query")->row();
        // $q = "select * from    petition_lm_note where petition_no=$petition and $this->base_query order by note_no desc";
        $q = "Select report_on_possession,date(date_entry) as date_entry, dispute from (
                Select report_on_possession as report_on_possession,lm_sign_date as date_entry,dispute from petition_lm_note where petition_no='$petition' and $this->base_query union 
                SElect co_order as report_on_possession,date_entry, null as dispute from petition_proceeding  where case_no='$case_no' and user_code like 'M%' )
                 as t order by date_entry desc limit 1";
        $note = $this->db->query($q)->row();
        
        $data['dag'] = $dag_details;
        $data['note'] = $note;

        //$this->load->helper('html');
        //$data['_view'] = 'officemutation/lmreport';
        //$this->load->view('layouts/main',$data);
        $this->load->view('../views/officemutation/lmreport', $data);
    }

    public function lmReport1() {
            $db=  $this->session->userdata('db');
        $append = $this->base_query;
        $case_no = $this->input->get('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code1 = $this->input->get('mouza_pargona_code');
        $lot_no1 = $this->input->get('lot_no');
        $vill_townprt_code1 = $this->input->get('vill_townprt_code');
        
        
        $location = $this->db->get_where('petition_basic', array('case_no' => $case_no, 'cir_code' => $cir_code, 'dist_code' => $dist_code, 
            'subdiv_code' => $subdiv_code, 'mouza_pargona_code' => $mouza_pargona_code1, 'lot_no' => $lot_no1, 'vill_townprt_code' => $vill_townprt_code1))->row();
        
        $q = "select * from     field_mut_pattadar where case_no ='$case_no' and mouza_pargona_code = '$mouza_pargona_code1' and "
                . "lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1' and " . $append;
        
        $patta = $this->db->query("select * from    field_mut_pattadar where case_no ='$case_no' and mouza_pargona_code = '$mouza_pargona_code1' and "
                . "lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1' and petition_no='$location->petition_no' and $append")->row();

        $petitioner = $this->db->get_where('field_mut_petitioner', array('case_no' => $case_no, 'cir_code' => $cir_code, 'dist_code' => $dist_code, 
            'subdiv_code' => $subdiv_code, 'mouza_pargona_code' => $mouza_pargona_code1, 'lot_no' => $lot_no1, 'vill_townprt_code' => $vill_townprt_code1 , 'petition_no'=>$location->petition_no))->result();
        
        $dag_details = $this->db->get_where('field_mut_dag_details', array('case_no' => $case_no, 'cir_code' => $cir_code, 'dist_code' => $dist_code, 
            'subdiv_code' => $subdiv_code, 'mouza_pargona_code' => $mouza_pargona_code1, 'lot_no' => $lot_no1, 'vill_townprt_code' => $vill_townprt_code1 , 'petition_no'=>$location->petition_no))->result();

        $allpattadar = array();
        foreach ($dag_details as $d) {
            $q = "select * from    chitha_pattadar p join 
                chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code 
                and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and
                p.pdar_id = d.pdar_id where p.dist_code='$location->dist_code' and p.subdiv_code='$location->subdiv_code' and p.cir_code='$location->cir_code' and
                p.mouza_pargona_code='$location->mouza_pargona_code' and p.vill_townprt_code='$location->vill_townprt_code' 
                and d.lot_no='$location->lot_no' and d.dag_no='$d->dag_no' and TRIM(p.patta_no)=trim('$patta->patta_no') 
                and p.patta_type_code='$patta->patta_type_code' and d.p_flag!='1' and d.dag_no='$d->dag_no' and TRIM(d.patta_no)=trim('$d->patta_no') ";
                
            $allpattadar[$d->dag_no] = $this->db->query($q)->result();
        }

        $dist_code = $this->utilityclass->getDistrictName($location->dist_code);
        $subdiv_code = $this->utilityclass->getSubDivName($location->dist_code, $location->subdiv_code);
        $cir_code = $this->utilityclass->getCircleName($location->dist_code, $location->subdiv_code, $location->cir_code);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($location->dist_code, $location->subdiv_code, $location->cir_code, $location->mouza_pargona_code);
        $lot_no = $this->utilityclass->getLotName($location->dist_code, $location->subdiv_code, $location->cir_code, $location->mouza_pargona_code, $location->lot_no);
        $vill_townprt_code = $this->utilityclass->getVillageName($location->dist_code, $location->subdiv_code, $location->cir_code, $location->mouza_pargona_code, $location->lot_no, $location->vill_townprt_code);
        $transcode = $this->utilityclass->getTransferType($location->trans_code);

        $patta_type_code = $patta->patta_type_code;
        $patta_type = $this->db->get_where('patta_code', array('type_code' => $patta_type_code))->row()->patta_type;

        $locations = array(
            'd' => $dist_code, 'sd' => $subdiv_code, 'c' => $cir_code, 'm' => $mouza_pargona_code, 'l' => $lot_no,
            'v' => $vill_townprt_code, 'trans_code' => $transcode, 'deedno' => $location->reg_deed_no,
            'possession' => $location->possession_yn, 'dispute' => $location->dispute_yn
        );

        $pattainfo = array(
            'p' => $patta_type
        );

        $sql = "select dag_no,dag_area_b,dag_area_k,dag_area_lc,m_dag_area_b,m_dag_area_k,m_dag_area_lc from    field_mut_dag_details where case_no='$case_no' "
                . "and mouza_pargona_code = '$mouza_pargona_code1' and lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1' and "
                . "petition_no='$location->petition_no' and $append";
        $values = $this->db->query($sql)->result();
        
        $rem = array();
        foreach ($values as $v) {
            $sourcelessa = $v->dag_area_b * 100 + $v->dag_area_k * 20 + $v->dag_area_lc;
            $targetlessa = $v->m_dag_area_b * 100 + $v->m_dag_area_k * 20 + $v->m_dag_area_lc;
            $remaining_lessa = $sourcelessa - $targetlessa;
            $rem_b = floor($remaining_lessa / 100);

            $rem_k = floor(($remaining_lessa - $rem_b * 100) / 20);
            $rem_lc = $remaining_lessa - $rem_b * 100 - $rem_k * 20;

            $left = array('rem_b' => $rem_b, 'rem_k' => $rem_k, 'rem_lc' => $rem_lc);
            $rem[$v->dag_no] = $left;
        }
        $data['location'] = $locations;
        $data['pattadar'] = $location;
        $data['patta'] = $pattainfo;
        $data['case_no'] = $case_no;
        $data['petitioner'] = $petitioner;
        $data['dag'] = $dag_details;
        $data['allpattadar'] = $allpattadar;
        $data['land_rem'] = $rem;
       
        $this->load->view('../views/skmutation/lmreport', $data);
    }

    public function skReport() {
            $db=  $this->session->userdata('db');
        $case_no = $this->input->get('case_no');
        $data['case_no'] = $case_no;
        $petition = $this->db->query("select * from    petition_basic where case_no='$case_no'")->row()->petition_no;
        $dag_details = $this->db->query("select * from    petition_dag_details where petition_no=$petition and $this->base_query")->row();
        $note = $this->db->query("select sk_note from    petition_lm_note where petition_no=$petition and $this->base_query order by note_no desc")->row();
        
        $data['dag'] = $dag_details;
        $data['note'] = $note;

        $this->load->helper('html');

        $this->load->view('../views/header');
        $this->load->view('../views/officemutation/skreport', $data);
        $this->load->view('../views/footer');
    }

    public function skReport1() {
        $db=  $this->session->userdata('db');
        $this->load->model('mutation/cofieldmutationmodel');
        $append = $this->base_query;
        $case_no = $this->input->get('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $cir_code = $this->session->userdata('cir_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $mouza_pargona_code1 = $this->input->get('mouza_pargona_code');
        $lot_no1 = $this->input->get('lot_no');
        $vill_townprt_code1 = $this->input->get('vill_townprt_code');

        $petitionDetails = $this->db->query("select * from    petition_basic where case_no=?",array($case_no))->row();
        if(MULTIGENERATION_ACTIVE == 1)
        {
            if($petitionDetails->is_multigeneration == 'M' || $petitionDetails->is_multigeneration == 'S')
            {
                return $this->skReportMultigen();
            }
        }

        // Added by Abhijit -- 2024-04-29
        if(MULTI_DAG_MUTATION_DEED_ACTIVE == 1){
            $case_parts = explode('/', $case_no);
            $service_code = end($case_parts);
            if($service_code == 'OMUT'){
                return $this->skReportForMultidag($case_no);
            }
        }

        $data['sknote'] = $this->cofieldmutationmodel->getSkNoteOfficeMutation($case_no, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code1, $lot_no1, $vill_townprt_code1);
        $data['case_no'] = $case_no;
        $location = $this->db->get_where(" petition_basic", array('case_no' => $case_no, 'cir_code' => $cir_code, 'dist_code' => $dist_code, 'subdiv_code' => $subdiv_code))->row();
        $dist_code = $this->utilityclass->getDistrictName($location->dist_code);
        $subdiv_code = $this->utilityclass->getSubDivName($location->dist_code, $location->subdiv_code);
        $cir_code = $this->utilityclass->getCircleName($location->dist_code, $location->subdiv_code, $location->cir_code);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($location->dist_code, $location->subdiv_code, $location->cir_code, $location->mouza_pargona_code);
        $lot_no = $this->utilityclass->getLotName($location->dist_code, $location->subdiv_code, $location->cir_code, $location->mouza_pargona_code, $location->lot_no);
        $vill_townprt_code = $this->utilityclass->getVillageName($location->dist_code, $location->subdiv_code, $location->cir_code, $location->mouza_pargona_code, $location->lot_no, $location->vill_townprt_code);

        $locations = array(
            'd' => $dist_code, 'sd' => $subdiv_code, 'c' => $cir_code, 'm' => $mouza_pargona_code, 'l' => $lot_no,
            'v' => $vill_townprt_code, 'deedno' => $location->deed_no,
            'possession' => '', 'dispute' => $data['sknote'][0]->dispute, 'report_date' => $data['sknote'][0]->sk_note_date
        );

        $data['location'] = $locations;
        $this->load->view('../views/comutation/sknote', $data);
    }


    public function asstReport1() {
        $db=  $this->session->userdata('db');
        $case_no = $this->input->get('case_no');
        $data['case_no'] = $case_no;
        $query = "select * from    petition_proceeding where case_no='$case_no'";
        $details = $this->db->query($query)->result();
        $data['details'] = $details;
        $this->load->helper('html');

        $this->load->view('../views/asstofficemutation/writenote1', $data);
    }

    public function asstReport() {
            $db=  $this->session->userdata('db');
        $case_no = $this->input->get('case_no');
        $data['case_no'] = $case_no;
        $query = "select * from    petition_proceeding where case_no='$case_no'";
        $details = $this->db->query($query)->result();
        $data['details'] = $details;
        $this->load->helper('html');
        $this->load->view('../views/header');
        $this->load->view('../views/asstofficemutation/writenote', $data);
        $this->load->view('../views/footer');
    }

    public function viewpetition() {
        $db=  $this->session->userdata('db');
        $append = $this->base_query;
        $case_no = $this->input->get('case_no');
        $data['case_no'] = $case_no;
        $petition_data = $this->db->query("select * "
                        . " from    petition_basic where case_no='$case_no' and " . $append)->row();

        $petition_no = $petition_data->petition_no;
        $trans_code = $petition_data->trans_code;
        $year_no= $petition_data->year_no;
        $data = array();
        if($trans_code != NULL){
            $data['tranfer_type'] = $this->db->query("select trans_desc_as from    nature_trans_code "
                        . " where trans_code='$trans_code'")->row()->trans_desc_as;
        }else{
            $data['tranfer_type'] = false;
        }

        $year_no= $petition_data->year_no;
        
        $data['pb']=$petition_data;

        if(MULTIGENERATION_ACTIVE ==1){
            if($petition_data->is_multigeneration == "M" || $petition_data->is_multigeneration =='S'){
                return $this->viewpetitionMultiGen($case_no);
            }
        }
        
        $data['petitioner'] = $this->db->query("select * from petitioner where petition_no=$petition_no and lot_no='$petition_data->lot_no' and vill_townprt_code='$petition_data->vill_townprt_code' and mouza_pargona_code='$petition_data->mouza_pargona_code' and $this->base_query")->result_array();


        //////////START FIRST PROCEEDING WITH AADHAAR DETAILS////////////
        $petitionerData = $this->db->query("select * from petitioner where petition_no=$petition_no and lot_no='$petition_data->lot_no' and vill_townprt_code='$petition_data->vill_townprt_code' and mouza_pargona_code='$petition_data->mouza_pargona_code' and auth_type is not null and $this->base_query")->row();

        $data['selfDecData'] = json_decode($petitionerData->self_declaration);
        if($petitionerData->auth_type !=null){
            $statusAadhar = "<i class='fa fa-check'></i> ".$petitionerData->auth_type. " Verified";
            $engName = $petitionerData->pdar_name_eng;
        }else{
            $statusAadhar = 'N/A';
            $engName = null;
        }
        $data['status'] = $statusAadhar;
        $data['engName'] = $engName;

        $application_no_sql="select * from basundhar_application where dharitree='$case_no' ";
        $data['application'] = $this->db->query($application_no_sql)->row();

        $data['base64_decoded_adhar_file'] = "";
        if (!empty($petitionerData) && $petitionerData !=null && trim($petitionerData->auth_type) == 'AADHAAR' ):

                $adhar_photo_link = $petitionerData->photo;
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
                        $aadhar_path = AADHAAR_UPLOAD_DIR. $petitionerData->id_ref_no . '.json';
                        $aadhaar_file_to_write_base64 = fopen($aadhar_path, "w") or die("Unable to open file!");
                        $aadhaar_encoded_file = $aadhaarPhotoDetails->path;
                        fwrite($aadhaar_file_to_write_base64, $aadhaar_encoded_file);
                        fclose($aadhaar_file_to_write_base64);
                        $idRefNo = $petitionerData->id_ref_no;
                        $query = "update petitioner set photo = '$aadhar_path' where case_no='$case_no' and id_ref_no = '$idRefNo' and auth_type is not null";
                        $this->db->query($query);
                       
                        $adhar_photo_link = $aadhar_path;
                        
                    }
                    else
                    {
                        echo json_encode(array('ERROR885784: API Response fail!'));
                        return false;
                    }


                }
                //**********reopening the updated file */
                $open_adhar_file = fopen($adhar_photo_link, "r") or die("Unable to open file!");
                $read_adhar_file = fread($open_adhar_file, filesize($adhar_photo_link));
                fclose($open_adhar_file);
                // decoding the base64 encoding file variable
                $data['base64_decoded_adhar_file'] = "<img src = data:".$this->decodeBase64($read_adhar_file).";base64,".$read_adhar_file." class='img-thumbnail mrl' alt='Aadhaar Photo' width='170' height='200'>";
      
            
        endif;

        ////////////////END///////////////////


        $data['pattadar'] = $this->db->query("select * from petition_pattadar where petition_no=$petition_no and lot_no='$petition_data->lot_no' and vill_townprt_code='$petition_data->vill_townprt_code' and mouza_pargona_code='$petition_data->mouza_pargona_code' and $this->base_query")->result_array();

        $data['tranfer_type'] = $this->db->query("select trans_desc_as from    nature_trans_code "
                        . " where trans_code='$trans_code'")->row()->trans_desc_as;
        $addressed_to = $petition_data->add_off_name;

        $d = $petition_data->dist_code;
        $s = $petition_data->subdiv_code;
        $c = $petition_data->cir_code;

        $data['addressed_to'] = $this->utilityclass->getSelectedCOName($d, $s, $c, $addressed_to);
        $data['dags'] = $this->db->query("select * from    petition_dag_details where petition_no=$petition_no and lot_no='$petition_data->lot_no' and vill_townprt_code='$petition_data->vill_townprt_code' and mouza_pargona_code='$petition_data->mouza_pargona_code' and $this->base_query")->result_array();

        $location = array(
            'dist_code' => $petition_data->dist_code,
            'subdiv_code' => $petition_data->subdiv_code,
            'cir_code' => $petition_data->cir_code,
            'mouza_pargona_code' => $petition_data->mouza_pargona_code,
            'lot_no' => $petition_data->lot_no,
            'vill_townprt_code' => $petition_data->vill_townprt_code,
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
            'vill' => $vill_townprt_code
        );
        $data['case_no'] = $case_no;

        $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
        $serviceType = explode('/',$basundharaExist);
        $service_code =1;
        $remarks = 'Office Mutation Inheritance';
        if($serviceType[1] == 'MUTD')
        {
            $service_code = 2;
            $remarks = 'Office Mutation Deed';
        }

        $params = [
          'case_no'          => $case_no,
          'service_code'     => $service_code,
          'remarks'          => $remarks,
          'accessed_entity'  => 'Aadhaar Name, Photo',
        ];
        $this->load->model('EkycLogModel');
        $log = $this->EkycLogModel->insertEkycAccessedBy($this->db, $params);

        $this->load->model('patta/PattaModel');
        $this->load->view('../views/officemutation/registrationpetition', $data);
    }



    ///////////////Dashboard Data Insert///////////////////////////
    function Dashboard($case_no){
        $this->dbb = $this->load->database('dash', TRUE);
        $sql="Select pb.*,pd.dag_no,pd.patta_no,pd.patta_type_code from petition_basic pb join petition_dag_details pd on pb.dist_code=pd.dist_code and pb.subdiv_code=pd.subdiv_code and pb.cir_code=pd.cir_code and pb.mouza_pargona_code=pd.mouza_pargona_code and pb.lot_no=pd.lot_no and pb.vill_townprt_code=pd.vill_townprt_code and pb.year_no=pd.year_no and pb.petition_no=pd.petition_no 
            where  pb.mut_type='03' and pb.case_no='$case_no' ";
        $data=$this->db->query($sql)->row_array();
        if($data['mut_type']=='03'){
            $type='OM';
        }else{
            
        }
        $base= array(
              'dist_code'=> $data['dist_code'],
              'subdiv_code' =>$data['subdiv_code'],
              'cir_code'=>$data['cir_code'],
              'mouza_pargona_code'=>$data['mouza_pargona_code'],
              'lot_no'=>$data['lot_no'],
              'vill_townprt_code'=>$data['vill_townprt_code'],
              'case_no'=>$data['case_no'],
              'date_of_reg'=>$data['date_entry'],
              'dag_no'=>$data['dag_no'],
              'patta_type_code' =>$data['patta_type_code'],
              'patta_no' =>$data['patta_no'],
              'status' =>'P',
              'pending_with_user' =>'CO',
              'case_type' =>$type,
              'date_of_insert'=>date("Y-m-d h:i:s")
            );
        


            unset($base['dag_no']);
            unset($base['patta_type_code']);
            unset($base['patta_no']);

        $this->dbb->insert('dashboard_data',$base);
        $this->db->insert('dashboard_data',$base);

        $sql="Select pet_name,guard_name,guard_rel from petitioner where dist_code='$data[dist_code]' and subdiv_code='$data[subdiv_code]' and cir_code='$data[cir_code]' and "
                    . "mouza_pargona_code = '$data[mouza_pargona_code]' and lot_no = '$data[lot_no]' and vill_townprt_code = '$data[vill_townprt_code]' and petition_no='$data[petition_no]'  ";
        $petitioner=$this->db->query($sql)->result();
        foreach ($petitioner as $key => $value) {
            $applicant= array(
                'case_no' => $case_no,
                'applicant_name' => $value->pet_name,
                'guardian_name' => $value->guard_name,
                'gender' => $value->guard_rel );
            $this->dbb->insert('dashboard_applicant',$applicant);
        }

        $ip=$this->utilityclass->checkIp($this->utilityclass->get_client_ip());
        if ($ip == true)
        return;


        $action= array(
            'case_no' => $case_no,
            'user_code' => $this->session->userdata('user_code'),
            'date_of_action_taken' => date("Y-m-d h:i:s"),
            'user_designation' => $this->session->userdata('user_desig_code'),
            'ip_address'=>$this->utilityclass->get_client_ip(),
            'remark' => 'Registered By Assistant'
             );
        $this->db->insert('dashboard_action',$action);
        $this->dbb->insert('dashboard_action',$action);
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


                    $this->db->where('case_no',$case_no);

                    $this->db->update('dashboard_data',$base);

                    $ip=$this->utilityclass->checkIp($this->utilityclass->get_client_ip());
                    if ($ip == true)
                    return;

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


                    $this->db->where('case_no',$case_no);

                    $this->db->update('dashboard_data',$base);

                    $ip=$this->utilityclass->checkIp($this->utilityclass->get_client_ip());
                    if ($ip == true)
                    return;
                    
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
                /////////////////////////////////////
        }

    /////////////////////////////////////////
        //script-validation 
    function check_script($str){

        if( strpos( trim(strtolower($str)), '<' ) !== false) {
            return FALSE;
        }

        if( strpos( trim(strtolower($str)), '>' ) !== false) {
            return FALSE;
        }
        
        if( strpos( trim(strtolower($str)), '<script>' ) !== false) {
            return FALSE;
        }
        if( strpos( trim(strtolower($str)), '</script>' ) !== false) {
            return FALSE;
        }
        return TRUE;
    }

    //date-validation 
    function date_valid($date){
        $day = (int) substr($date, 0, 2);
        $month = (int) substr($date, 3, 2);
        $year = (int) substr($date, 6, 4);
        return checkdate($month, $day, $year);
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

    //co view petition details for multigeneration-----------

    public function viewpetitionMultiGen($case_no) {
        $db=  $this->session->userdata('db');
        $append = $this->base_query;
        $data['case_no'] = $case_no;
        $petition_data = $this->db->query("select * from    petition_basic where case_no=? and " . $append,array($case_no))->row();

        $petition_no = $petition_data->petition_no;
        $trans_code = $petition_data->trans_code;
        $year_no= $petition_data->year_no;
        $data = array();
        $data['pb']=$petition_data;
        if($petition_data->is_multigeneration == "M"){
            $genType = "Multi Generation ";
        }else{
            $genType = "Single Generation";
        }
        $data['mutation_type_single_multi'] = $genType;
        $data['other_properties'] = $this->db->where('case_no', $case_no)->get('mut_additional_properties')->result();

        
        $data['petitioner'] = $this->db->query("select * from petitioner where petition_no=$petition_no and lot_no='$petition_data->lot_no' and vill_townprt_code='$petition_data->vill_townprt_code' and mouza_pargona_code='$petition_data->mouza_pargona_code' and $this->base_query")->result_array();
        //echo $this->db->last_query();

        if($petition_data->is_multigeneration == "M"){
            foreach ($data['petitioner'] as $key => $value) {
              if($value['generation_type'] == "P" || $value['generation_type'] == "A" ){
                $sql = "select pet_name as name from petitioner where pdar_id = ?";
                $child_of = $this->db->query($sql,array($value['next_of_pdar_id']))->row();
                $data['petitioner'][$key]['child_of'] = $child_of ? $child_of->name : '';
              }else{
                $data['petitioner'][$key]['child_of'] = "Owner Dag Pattadar";
              }  
            }
        }
        $data['pattadar'] = $this->db->query("select * from petition_pattadar where petition_no=$petition_no and lot_no='$petition_data->lot_no' and vill_townprt_code='$petition_data->vill_townprt_code' and mouza_pargona_code='$petition_data->mouza_pargona_code' and $this->base_query")->result_array();

        $data['tranfer_type'] = $this->db->query("select trans_desc_as from    nature_trans_code "
                        . " where trans_code='$trans_code'")->row()->trans_desc_as;
        $addressed_to = $petition_data->add_off_name;

        $d = $petition_data->dist_code;
        $s = $petition_data->subdiv_code;
        $c = $petition_data->cir_code;

        $data['addressed_to'] = $this->utilityclass->getSelectedCOName($d, $s, $c, $addressed_to);
        $data['dags'] = $this->db->query("select * from    petition_dag_details where petition_no=$petition_no and lot_no='$petition_data->lot_no' and vill_townprt_code='$petition_data->vill_townprt_code' and mouza_pargona_code='$petition_data->mouza_pargona_code' and $this->base_query")->result_array();

        $location = array(
            'dist_code' => $petition_data->dist_code,
            'subdiv_code' => $petition_data->subdiv_code,
            'cir_code' => $petition_data->cir_code,
            'mouza_pargona_code' => $petition_data->mouza_pargona_code,
            'lot_no' => $petition_data->lot_no,
            'vill_townprt_code' => $petition_data->vill_townprt_code,
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
            'vill' => $vill_townprt_code
        );
        $data['case_no'] = $case_no;

        //tree view for CO end----------
        $data['owner_pattadar'] = null;
        $tree['tree'] = null;
        $tree['generation_type'] = null;
        if($petition_data->is_multigeneration == "M"){
            $this->load->model('mutation/cofieldmutationmodel');
            $tree = $this->cofieldmutationmodel->fetchTreeDataOffice($case_no); 
            $data['owner_pattadar'] = $tree['owner_pattadar'];
            $data['tree'] = $tree['tree'];
            $data['generation_type'] = $tree['generation_type'];
        }
        //

        $this->load->model('patta/PattaModel');
        $this->load->view('../views/officemutation/registrationpetitionMultiGen', $data);
    }

    // Added by Abhijit -- 2024-04-29
    private function lmReportForMultidag($case_no){
        $append = $this->base_query;
        $data['case_no'] = $case_no;
        $petition = $this->db->query("select * from    petition_basic where case_no='$case_no' and " . $append)->row()->petition_no;
        $dag_details = $this->db->query("select * from    petition_dag_details where petition_no=$petition and $this->base_query")->result();
        // $q = "select * from    petition_lm_note where petition_no=$petition and $this->base_query order by note_no desc";
        $q = "Select report_on_possession,date(date_entry) as date_entry, dispute from (
                Select report_on_possession as report_on_possession,lm_sign_date as date_entry,dispute from petition_lm_note where petition_no='$petition' and $this->base_query union 
                SElect co_order as report_on_possession,date_entry, null as dispute from petition_proceeding  where case_no='$case_no' and user_code like 'M%' )
                 as t order by date_entry desc limit 1";
        $note = $this->db->query($q)->row();
        
        $data['dag_details'] = $dag_details;
        $data['note'] = $note;

        $this->load->view('../views/officemutation/multi-dag-lmreport', $data);
    }
    
    // Added by Abhijit -- 2024-04-29
    private function skReportForMultidag($case_no){
        $db=  $this->session->userdata('db');
        $this->load->model('mutation/cofieldmutationmodel');
        $append = $this->base_query;
        $case_no = $this->input->get('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $cir_code = $this->session->userdata('cir_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $mouza_pargona_code1 = $this->input->get('mouza_pargona_code');
        $lot_no1 = $this->input->get('lot_no');
        $vill_townprt_code1 = $this->input->get('vill_townprt_code');

        $petitionDetails = $this->db->query("select * from    petition_basic where case_no=?",array($case_no))->row();

        $data['sknote'] = $this->cofieldmutationmodel->getSkNoteOfficeMutationMultiDag($case_no, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code1, $lot_no1, $vill_townprt_code1);
        $data['case_no'] = $case_no;
        $location = $this->db->get_where(" petition_basic", array('case_no' => $case_no, 'cir_code' => $cir_code, 'dist_code' => $dist_code, 'subdiv_code' => $subdiv_code))->row();
        $dist_code = $this->utilityclass->getDistrictName($location->dist_code);
        $subdiv_code = $this->utilityclass->getSubDivName($location->dist_code, $location->subdiv_code);
        $cir_code = $this->utilityclass->getCircleName($location->dist_code, $location->subdiv_code, $location->cir_code);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($location->dist_code, $location->subdiv_code, $location->cir_code, $location->mouza_pargona_code);
        $lot_no = $this->utilityclass->getLotName($location->dist_code, $location->subdiv_code, $location->cir_code, $location->mouza_pargona_code, $location->lot_no);
        $vill_townprt_code = $this->utilityclass->getVillageName($location->dist_code, $location->subdiv_code, $location->cir_code, $location->mouza_pargona_code, $location->lot_no, $location->vill_townprt_code);

        $locations = array(
            'd' => $dist_code, 'sd' => $subdiv_code, 'c' => $cir_code, 'm' => $mouza_pargona_code, 'l' => $lot_no,
            'v' => $vill_townprt_code, 'deedno' => $location->deed_no,
            'possession' => '', 'dispute' => $data['sknote'][0]->dispute, 'report_date' => $data['sknote'][0]->sk_note_date
        );

        $data['location'] = $locations;
        $this->load->view('../views/comutation/multi-dag-sknote', $data);
    }

    //lm report view in co login for multigeneration=====================

    public function lmReportMultiGen() {
        $db=  $this->session->userdata('db');
        $append = $this->base_query;
        $case_no = $this->input->get('case_no');
        $data['case_no'] = $case_no;
        $petition = $this->db->query("select * from    petition_basic where case_no='$case_no' and " . $append)->row()->petition_no;
        $dag_details = $this->db->query("select * from    petition_dag_details where petition_no=$petition and $this->base_query")->result();
        // $q = "select * from    petition_lm_note where petition_no=$petition and $this->base_query order by note_no desc";
        $q = "Select report_on_possession,date(date_entry) as date_entry, dispute from (
                Select report_on_possession as report_on_possession,lm_sign_date as date_entry,dispute from petition_lm_note where petition_no='$petition' and $this->base_query union 
                SElect co_order as report_on_possession,date_entry, null as dispute from petition_proceeding  where case_no='$case_no' and user_code like 'M%' )
                 as t order by date_entry desc limit 1";
        $note = $this->db->query($q)->row();   
        $data['dag'] = $dag_details;
        $data['note'] = $note;

        //$this->load->helper('html');
        //$data['_view'] = 'officemutation/lmreport';
        //$this->load->view('layouts/main',$data);
        $this->load->view('../views/officemutation/lmReportMultiGen', $data);
    }


    //sk report view in co login for multigeneration----------
    public function skReportMultigen()
    {
        $db=  $this->session->userdata('db');
        $this->load->model('mutation/cofieldmutationmodel');
        $append = $this->base_query;
        $case_no = $this->input->get('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $cir_code = $this->session->userdata('cir_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $mouza_pargona_code1 = $this->input->get('mouza_pargona_code');
        $lot_no1 = $this->input->get('lot_no');
        $vill_townprt_code1 = $this->input->get('vill_townprt_code');
        
        $data['sknote'] = $this->cofieldmutationmodel->getSkNoteOfficeMutationMultiGen($case_no, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code1, $lot_no1, $vill_townprt_code1);

        $data['case_no'] = $case_no;
        $location = $this->db->get_where(" petition_basic", array('case_no' => $case_no, 'cir_code' => $cir_code, 'dist_code' => $dist_code, 'subdiv_code' => $subdiv_code))->row();
        $dist_code = $this->utilityclass->getDistrictName($location->dist_code);
        $subdiv_code = $this->utilityclass->getSubDivName($location->dist_code, $location->subdiv_code);
        $cir_code = $this->utilityclass->getCircleName($location->dist_code, $location->subdiv_code, $location->cir_code);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($location->dist_code, $location->subdiv_code, $location->cir_code, $location->mouza_pargona_code);
        $lot_no = $this->utilityclass->getLotName($location->dist_code, $location->subdiv_code, $location->cir_code, $location->mouza_pargona_code, $location->lot_no);
        $vill_townprt_code = $this->utilityclass->getVillageName($location->dist_code, $location->subdiv_code, $location->cir_code, $location->mouza_pargona_code, $location->lot_no, $location->vill_townprt_code);

        $locations = array(
            'd' => $dist_code, 'sd' => $subdiv_code, 'c' => $cir_code, 'm' => $mouza_pargona_code, 'l' => $lot_no,
            'v' => $vill_townprt_code, 'deedno' => $location->deed_no,
            'possession' => '', 'dispute' => $data['sknote'][0]->dispute, 'report_date' => $data['sknote'][0]->sk_note_date
        );

        $data['location'] = $locations;
        $this->load->view('../views/comutation/sknoteMultiGen', $data);
    }

}
