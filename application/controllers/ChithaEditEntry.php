<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ChithaEditEntry extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mutation/mutationmodel');
        $this->load->helper(array('form', 'url', 'Language'));

        $this->load->library('form_validation');
    }

    public function index() {
		  $db=  $this->session->userdata('db');
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
            redirect(base_url() . "index.php/ChithaEditEntry/basicdetails");
        } else {
			redirect('/home');
            $this->load->helper('html');
            $this->load->view('../views/header');
            $data = $this->mutationmodel->getDistricts();
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouzas = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);
            $district['d'] = $dist_code;
            $district['s'] = $subdiv_code;
            $district['c'] = $cir_code;
            $district['mouzas'] = $mouzas;
            
            $this->load->view('../views/chithaeditentry/index', $district);
            $this->load->view('../views/footer');
        }
    }

    public function basicdetails() {
		  $db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $data['d'] = $dist_code;
            $data['s'] = $subdiv_code;
            $data['c'] = $cir_code;
            $data['m'] = $mouza_pargona_code;
            $data['l'] = $lot_no;
            $data['v'] = $vill_townprt_code;
            
            $dist_code1 = $this->utilityclass->getDistrictName($dist_code);
            $subdiv_code1 = $this->utilityclass->getSubDivName($dist_code,$subdiv_code);
            $cir_code1 = $this->utilityclass->getCircleName($dist_code,$subdiv_code,$cir_code);
            $mouza_pargona_code1 = $this->utilityclass->getMouzaName($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code);
            $lot_no1 = $this->utilityclass->getLotName($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no);
            $vill_townprt_code1 = $this->utilityclass->getVillageName($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code);
            $data['location'] = array(
                'dist' => $dist_code1,
                'sub' => $subdiv_code1,
                'cir' => $cir_code1,
                'mouza' => $mouza_pargona_code1,
                'lot' => $lot_no1,
                'vill' => $vill_townprt_code1
            );
            //var_dump($data);
            $patta_types = $this->db->query("select type_code,patta_type from    patta_code")->result();
            $data['patta_types'] = $patta_types;
            $land_classes = $this->db->query("select class_code,land_type from    landclass_code")->result();
            $data['land_classes'] = $land_classes;

            $this->load->helper('html');
            $this->load->view('../views/header');
            $this->load->view('../views/chithaeditentry/basicdetails', $data);
            $this->load->view('../views/footer');
        } else if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $action = $this->input->post('submit');
            if ($action === 'submit') {
                $this->session->set_userdata($this->input->post());
                $data = $this->input->post();
                $data['user_code'] = $this->session->userdata('user_code');
                $data['operation'] = 'E';
                $data['date_entry'] = date('Y-m-d');
                unset($data['submit']);
                if (!$this->input->post('edit') == '1') {
                    unset($data['edit']);
                    // $this->db->insert('chitha_basic', $data);
                    $this->Chitha_basic_model->insert_table('chitha_basic',$data);
                } else {
                    $where = array(
                        'dist_code' => $data['dist_code'],
                        'subdiv_code' => $data['subdiv_code'],
                        'cir_code' => $data['cir_code'],
                        'mouza_pargona_code' => $data['mouza_pargona_code'],
                        'lot_no' => $data['lot_no'],
                        'vill_townprt_code' => $data['vill_townprt_code'],
                        'dag_no' => $data['dag_no'],
                        'patta_no' => trim($data['patta_no']),
                        'patta_type_code' => $data['patta_type_code']
                    );
                    unset($data['dist_code']);
                    unset($data['subdiv_code']);
                    unset($data['cir_code']);
                    unset($data['mouza_pargona_code']);
                    unset($data['vill_townprt_code']);
                    unset($data['dag_no']);
                    unset($data['edit']);

                    $rem = $this->input->post('dag_area_b') * 100 + $this->input->post('dag_area_k') * 20 + $this->input->post('dag_area_lc');
                    $bigha_r = floor($rem / 100.0);
                    $katha_r = floor(($rem - $bigha_r * 100.0) / 20.0);
                    $lessa_r = $rem - $bigha_r * 100.0 - $katha_r * 20.0;
                    $data['dag_area_b'] = $bigha_r;
                    $data['dag_area_k'] = $katha_r;
                    $data['dag_area_lc'] = $lessa_r;
                    $data['jama_yn'] = 'n';
                    // $this->db->where($where);
                    // $this->db->update('chitha_basic', $data);
                    $table = 'chitha_basic';
                    $this->Chitha_basic_model->update_table($table, $data, $where);
                    $this->session->set_flashdata('message', 'Basic Details Saved!');
                }
                redirect(base_url() . "index.php/chithaeditentry/pattadardetails");
            } else {
                redirect(base_url() . "index.php/chithaeditentry/pattadardetails");
            }
        }
    }

    public function getdagdetails() {
		  $db=  $this->session->userdata('db');
        $dag_no = $this->input->post('dag_no');
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $vill_townprt_code = $this->input->post('vill_townprt_code');
        $patta_no = trim($this->input->post('patta_no'));
        $patta_type_code = $this->input->post('patta_type_code');
        $data = $this->db->get_where('chitha_basic', array('dag_no' => $dag_no, 'dist_code' => $dist_code, 'subdiv_code' => $subdiv_code, 'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code, 'lot_no' => $lot_no, 'vill_townprt_code' => $vill_townprt_code
                ))->result();
        echo json_encode($data);
    }

    public function pattadardetails() {
		  $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type_code = $this->session->userdata('patta_type_code');
        $dag_no = $this->session->userdata('dag_no');
        
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $q = "select d.p_flag,p.pdar_id,p.pdar_name,p.pdar_father,p.pdar_add1,p.pdar_add2,p.pdar_add3,p.pdar_guard_reln from    chitha_pattadar p join 
            chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code 
            and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and
            p.pdar_id = d.pdar_id where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and d.lot_no='$lot_no' and d.dag_no='$dag_no' and TRIM(p.patta_no)='$patta_no' 
            and p.patta_type_code='$patta_type_code' order by p.pdar_id";
            //echo $q;
            $data['pattadars'] = $this->db->query($q)->result();
            //var_dump($data);
            if ($this->session->userdata('pattadars_new') != null) {
                $pattadars = $this->session->userdata('pattadars_new');
                foreach ($pattadars as $key => $value) {
                    $object = new stdClass();
                    foreach ($value as $k => $v) {
                        $object->$k = $v;
                    }
                    $object->newFlag = true;
                    $data['pattadars'][] = $object;
                }
            }
            
            $data['location'] = array(
                'dist_code' => $dist_code,
                $subdiv_code => $subdiv_code,
                $cir_code => $cir_code,
                $mouza_pargona_code => $mouza_pargona_code,
                $lot_no => $lot_no,
                $vill_townprt_code => $vill_townprt_code,
                $patta_no => $patta_no,
                $patta_type_code => $patta_type_code,
                $dag_no => $dag_no,
            );
            //var_dump($data);
            $this->load->helper('html');
            $this->load->view('../views/header');
            $this->load->view('../views/chithaeditentry/pattadars', $data);
            $this->load->view('../views/footer');
        }
    }

    public function pdaredit($pdar_id) {
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type_code = $this->session->userdata('patta_type_code');
        $dag_no = $this->session->userdata('dag_no');
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $patta_no = trim($this->session->userdata('patta_no'));
            $patta_type_code = $this->session->userdata('patta_type_code');
            $dag_no = $this->session->userdata('dag_no');
            $q = "select * from    chitha_pattadar p join 
            chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code 
            and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and
            p.pdar_id = d.pdar_id where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and d.lot_no='$lot_no' and d.dag_no='$dag_no' and TRIM(p.patta_no)='$patta_no' 
            and p.patta_type_code='$patta_type_code' and p.pdar_id='$pdar_id' and d.pdar_id='$pdar_id'";
            $data['pattadar'] = $this->db->query($q)->row();

            $this->load->helper('html');
            $this->load->view('../views/header');
            $this->load->view('../views/chithaeditentry/pdaredit', $data);
            $this->load->view('../views/footer');
        } else if ($this->input->server('REQUEST_METHOD') == 'POST') {
            if ($this->input->post('submit') == 'Submit') {
                $pdar_name = $this->input->post('pdar_name');
                $pdar_father = $this->input->post('pdar_father');
                $pdar_add1 = $this->input->post('pdar_add1');
                $pdar_mother = $this->input->post('pdar_mother');
                $dag_por_b = $this->input->post('dag_por_b');
                $dag_por_k = $this->input->post('dag_por_k');
                $dag_por_lc = $this->input->post('dag_por_lc');
                $dag_por_g = $this->input->post('dag_por_g');
                $dag_por_kr = $this->input->post('dag_por_kr');
                $pdar_land_n = $this->input->post('pdar_land_n');
                $pdar_land_s = $this->input->post('pdar_land_s');
                $pdar_land_e = $this->input->post('pdar_land_e');
                $pdar_land_w = $this->input->post('pdar_land_w');
                $pdar_land_acre = $this->input->post('pdar_land_acre');
                $pdar_land_revenue = $this->input->post('pdar_land_revenue');
                $pdar_land_localtax = $this->input->post('pdar_land_localtax');
                $new_pdar_id = $this->input->post('new_pdar_id');
                //var_dump($this->input->post());
                if(empty($pdar_land_acre)){
                    $pdar_land_acre='0';
                }
                if(empty($pdar_land_revenue)){
                    $pdar_land_revenue='0';
                }
                if(empty($pdar_land_localtax)){
                    $pdar_land_localtax='0';
                }
                
                // $query = "update chitha_pattadar p set pdar_id='$new_pdar_id',pdar_name ='$pdar_name',pdar_father='$pdar_father',pdar_mother='$pdar_mother',pdar_add1='$pdar_add1',jama_yn='n' "
                //         . "where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and p.mouza_pargona_code='$mouza_pargona_code' "
                //         . "and p.vill_townprt_code='$vill_townprt_code' and p.lot_no='$lot_no' and TRIM(patta_no)='$patta_no' and patta_type_code='$patta_type_code' "
                //         . "and pdar_id='$pdar_id'";
                //         //echo $query;
                // $this->db->query($query);

                $table = 'chitha_pattadar';

                $params = [
                    'pdar_id'     => $new_pdar_id,
                    'pdar_name'   => $pdar_name,
                    'pdar_father' => $pdar_father,
                    'pdar_mother' => $pdar_mother,
                    'pdar_add1'   => $pdar_add1,
                    'jama_yn'     => 'n',
                ];

                $where = [
                    'dist_code'          => $dist_code,
                    'subdiv_code'        => $subdiv_code,
                    'cir_code'           => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'vill_townprt_code'  => $vill_townprt_code,
                    'lot_no'             => $lot_no,
                    'patta_no'           => trim($patta_no),  // TRIM used here
                    'patta_type_code'    => $patta_type_code,
                    'pdar_id'            => $pdar_id,
                ];

                // Call the update method
                $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                
                // $query = "update chitha_dag_pattadar p set pdar_id='$new_pdar_id', dag_por_b='$dag_por_b', dag_por_k='$dag_por_k', dag_por_lc='$dag_por_lc', dag_por_g='$dag_por_g', "
                //         . "dag_por_kr='$dag_por_kr', pdar_land_n='$pdar_land_n', pdar_land_acre='$pdar_land_acre', pdar_land_revenue='$pdar_land_revenue', "
                //         . "pdar_land_localtax='$pdar_land_localtax',jama_yn='n' where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                //         . "p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' and p.lot_no='$lot_no' and p.dag_no='$dag_no' "
                //         . "and TRIM(patta_no)='$patta_no' and patta_type_code='$patta_type_code' and pdar_id='$pdar_id'";
                //         //echo $query;
                //  $this->db->query($query);
                $table = 'chitha_dag_pattadar';

                $params = [
                    'pdar_id'           => $new_pdar_id,
                    'dag_por_b'         => $dag_por_b,
                    'dag_por_k'         => $dag_por_k,
                    'dag_por_lc'        => $dag_por_lc,
                    'dag_por_g'         => $dag_por_g,
                    'dag_por_kr'        => $dag_por_kr,
                    'pdar_land_n'       => $pdar_land_n,
                    'pdar_land_acre'    => $pdar_land_acre,
                    'pdar_land_revenue' => $pdar_land_revenue,
                    'pdar_land_localtax'=> $pdar_land_localtax,
                    'jama_yn'           => 'n',
                ];

                $where = [
                    'dist_code'          => $dist_code,
                    'subdiv_code'        => $subdiv_code,
                    'cir_code'           => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'vill_townprt_code'  => $vill_townprt_code,
                    'lot_no'             => $lot_no,
                    'dag_no'             => $dag_no,
                    'patta_no'           => trim($patta_no),
                    'patta_type_code'    => $patta_type_code,
                    'pdar_id'            => $pdar_id,
                ];

                // Call your model update function
                $this->Chitha_basic_model->update_table($table, $params, $where);

                 redirect(base_url() . "index.php/chithaeditentry/pattadardetails");
            } else {
                redirect(base_url() . "index.php/chithaeditentry/orderList");
            }
        }
    }

    public function pdaradd() {
		  $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type_code = $this->session->userdata('patta_type_code');
        $dag_no = $this->session->userdata('dag_no');
        if ($this->input->server('REQUEST_METHOD') == 'GET') {

            $q = "select max(p.pdar_id)+1 as pdar_id from    chitha_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no' 
            and p.patta_type_code='$patta_type_code' ";
            $pdar_id = $this->db->query($q)->row()->pdar_id;
            if ($pdar_id == null) {
                $pdar_id = 1;
            }
            $data['pdar_id'] = $pdar_id;
            $this->load->helper('html');
            $this->load->view('../views/header');
            $this->load->view('../views/chithaeditentry/pdaradd', $data);
            $this->load->view('../views/footer');
        } else if ($this->input->server('REQUEST_METHOD') == 'POST') {
            if ($this->input->post('submit') == 'Submit') {
                $pdar_id = $this->input->post('pdar_id');
                $pdar_name = $this->input->post('pdar_name');
                $pdar_father = $this->input->post('pdar_father');
                $pdar_add1 = $this->input->post('pdar_add1');
                $pdar_mother = $this->input->post('pdar_mother');
                $dag_por_b = $this->input->post('dag_por_b');
                $dag_por_k = $this->input->post('dag_por_k');
                $dag_por_lc = $this->input->post('dag_por_lc');
                $dag_por_g = $this->input->post('dag_por_g');
                $dag_por_kr = $this->input->post('dag_por_kr');
                $pdar_land_n = $this->input->post('pdar_land_n');
                $pdar_land_s = $this->input->post('pdar_land_s');
                $pdar_land_e = $this->input->post('pdar_land_e');
                $pdar_land_w = $this->input->post('pdar_land_w');
                $pdar_land_acre = $this->input->post('pdar_land_acre');
                $pdar_land_revenue = $this->input->post('pdar_land_revenue');
                $pdar_land_localtax = $this->input->post('pdar_land_localtax');
                $data = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'pdar_id' => $pdar_id,
                    'patta_no' => $patta_no,
                    'patta_type_code' => $patta_type_code,
                    'pdar_name' => $pdar_name,
                    'pdar_father' => $pdar_father,
                    'pdar_add1' => $pdar_add1,
                    'pdar_mother' => $pdar_mother,
                    'user_code' => $this->session->userdata('user_code'),
                    'operation' => 'E',
                    'date_entry' => date('Y-m-d'),
                    'jama_yn' => 'N'
                );
                // $this->db->insert('chitha_pattadar', $data);
                // $data['f1_case_no']=$case_no;
                $this->Chitha_basic_model->insert_table('chitha_pattadar',$data);
				//var_dump($data);
                $data = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'dag_no' => $dag_no,
                    'pdar_id' => $pdar_id,
                    'patta_no' => $patta_no,
                    'patta_type_code' => $patta_type_code,
                    'dag_por_b' => $dag_por_b,
                    'dag_por_k' => $dag_por_k,
                    'dag_por_lc' => $dag_por_lc,
                    'dag_por_g' => $dag_por_g,
                    'dag_por_kr' => $dag_por_kr,
                    'pdar_land_n' => $pdar_land_n,
                    'pdar_land_s' => $pdar_land_s,
                    'pdar_land_e' => $pdar_land_e,
                    'pdar_land_w' => $pdar_land_w,
                    'pdar_land_acre' => $pdar_land_acre,
                    'pdar_land_revenue' => $pdar_land_revenue,
                    'pdar_land_localtax' => $pdar_land_localtax,
                    'user_code' => $this->session->userdata('user_code'),
                    'operation' => 'E',
                    'date_entry' => date('Y-m-d'),
                    'p_flag' => '0'
                );
                // $this->db->insert('chitha_dag_pattadar', $data);
                $this->Chitha_basic_model->insert_table('chitha_dag_pattadar',$data);
				//var_dump($data);
                redirect(base_url() . "index.php/chithaeditentry/pattadardetails");
            } else {
                redirect(base_url() . "index.php/chithaeditentry/orderList");
            }
        }
    }

    public function colEightOrderEdit($order_cron_no) {
		  $db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $dag_no = $this->session->userdata('dag_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $ord_type_query = "select * from    master_field_mut_type";
            $data['ord_types'] = $this->db->query($ord_type_query)->result();

            $trans_code_query = "select * from    nature_trans_code";
            $data['trans_codes'] = $this->db->query($trans_code_query)->result();
            $mandals_query = "select * from    lm_code where  dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code' and "
                    . "lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code'";

            $data['mandals'] = $this->db->query($mandals_query)->result();
            $cos_query = "select * from    users where user_desig_code='CO'  and dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code' ";


            $data['cos'] = $this->db->query($cos_query)->result();

            $sks_query = "select * from    users where user_desig_code='SK' and dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code' ";


            $data['cos'] = $this->db->query($cos_query)->result();
            $data['sks'] = $this->db->query($sks_query)->result();
            $query = "select * from    chitha_col8_order p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                    . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    . " and p.lot_no='$lot_no' and p.dag_no='$dag_no' and col8order_cron_no='$order_cron_no' "
                    . " ";

            $data['order'] = $this->db->query($query)->row();
            $query = "select * from    chitha_col8_occup p where  p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                    . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    . " and p.lot_no='$lot_no' and p.dag_no='$dag_no' and col8order_cron_no='$order_cron_no' "
                    . " ";
            $data['occupants'] = $this->db->query($query)->result();
            $query = "select * from    chitha_col8_inplace p where  p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                    . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    . " and p.lot_no='$lot_no' and p.dag_no='$dag_no' and col8order_cron_no='$order_cron_no' "
                    . " ";
            $data['inplaces'] = $this->db->query($query)->result();

            $this->load->helper('html');
            $this->load->view('../views/header');
            $this->load->view('../views/chithaeditentry/orderedit', $data);
            $this->load->view('../views/footer');
        } else if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $orderfinal = $this->input->post('finalorder');
            $occupants = $this->input->post('occup');
            $inplaces = $this->input->post('inplace');
            $this->session->set_userdata(array('final' => $orderfinal));
            $this->session->set_userdata(array('inplaces' => $inplaces));
            $this->session->set_userdata(array('occupants' => $occupants));
            redirect(base_url() . "index.php/chithaeditentry/finalSave");
        }
    }

    public function step1Edit($cron) {
		  $db=  $this->session->userdata('db');
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $dag_no = $this->session->userdata('dag_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $ord_type_query = "select * from    master_office_mut_type";
            $data['ord_types'] = $this->db->query($ord_type_query)->result();

            $trans_code_query = "select * from    nature_trans_code";
            $data['trans_codes'] = $this->db->query($trans_code_query)->result();
            $mandals_query = "select * from    lm_code where  dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code' and "
                    . "lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code'";

            $data['mandals'] = $this->db->query($mandals_query)->result();
            $cos_query = "select * from    users where user_desig_code='CO'  and dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code' ";


            $data['cos'] = $this->db->query($cos_query)->result();

            $sks_query = "select * from    users where user_desig_code='SK' and dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code' ";


            $data['cos'] = $this->db->query($cos_query)->result();
            $data['sks'] = $this->db->query($sks_query)->result();

            $all_q = "select * from    chitha_rmk_ordbasic p where  p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                    . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    . " and p.lot_no='$lot_no' and p.dag_no='$dag_no' and ord_cron_no=$cron ";
            $data['all'] = $this->db->query($all_q)->row();
            //var_dump($data['all']);
            $this->load->helper('html');
            $this->load->view('../views/header');
            $this->load->view('../views/ChithaEditEntry/step1edit', $data);
            $this->load->view('../views/footer');
        } else {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $dag_no = $this->session->userdata('dag_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $data = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'dag_no' => $dag_no,
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
                'm_dag_area_b' => 0,
                'm_dag_area_k' => 0,
                'm_dag_area_lc' => 0,
                'm_dag_area_g' => 0,
                'm_dag_area_kr' => 0,
                'area_left_b' => 0,
                'area_left_k' => 0,
                'area_left_lc' => 0,
                'area_left_g' => 0,
                'area_left_kr' => 0,
            );
            $formdata = $this->input->post();
            unset($formdata['submit']);
            $final = array_merge($data, $formdata);
            //$this->db->insert('chitha_rmk_ordbasic', $final);
            $this->session->set_userdata(array('finalmainorder' => $final));
            $this->session->set_userdata(array('ord_no' => $this->input->post('ord_no')));
            $this->session->set_userdata(array('ord_cron_no' => $this->input->post('ord_cron_no')));
            $this->session->set_userdata(array('ord_date' => $this->input->post('ord_date')));
            $this->session->set_userdata(array('rmk_type_hist_no' => $this->input->post('rmk_type_hist_no')));
            redirect(base_url() . "index.php/chithaeditentry/step2list/");
        }
    }

    public function colEightOrderAdd() {
		  $db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $dag_no = $this->session->userdata('dag_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $patta_no = trim($this->session->userdata('patta_no'));
            $patta_type_code = $this->session->userdata('patta_type_code');
            $ord_type_query = "select * from    master_field_mut_type";
            $data['ord_types'] = $this->db->query($ord_type_query)->result();

            $trans_code_query = "select * from    nature_trans_code";
            $data['trans_codes'] = $this->db->query($trans_code_query)->result();
            $mandals_query = "select * from    lm_code where  dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code' and "
                    . "lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code'";

            $data['mandals'] = $this->db->query($mandals_query)->result();
            $cos_query = "select * from    users where user_desig_code='CO'  and dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code' ";


            $data['cos'] = $this->db->query($cos_query)->result();

            $sks_query = "select * from    users where user_desig_code='SK' and dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code' ";


            $data['cos'] = $this->db->query($cos_query)->result();
            $data['sks'] = $this->db->query($sks_query)->result();
            $q = "select * from    chitha_pattadar p join 
            chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code 
            and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and
            p.pdar_id = d.pdar_id where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and d.lot_no='$lot_no' and d.dag_no='$dag_no' and TRIM(p.patta_no)='$patta_no' 
            and p.patta_type_code='$patta_type_code' ";


            $data['inplaces'] = $this->db->query($q)->result();
            $col8_order_cron_no_q = "select max(col8order_cron_no)+1 as max from    chitha_col8_order p where  p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and p.lot_no='$lot_no' and p.dag_no='$dag_no' 
            ";
            $max = $this->db->query($col8_order_cron_no_q)->row()->max;
            if ($max == null) {
                $max = 1;
            }
            $data['max_number'] = $max;

            $this->load->helper('html');
            $this->load->view('../views/header');
            $this->load->view('../views/chithaeditentry/orderadd', $data);
            $this->load->view('../views/footer');
        } else if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $orderfinal = $this->input->post('finalorder');
            $occupants = $this->input->post('occup');
            $inplaces = $this->input->post('inplace');
            $this->session->set_userdata(array('final' => $orderfinal));
            $this->session->set_userdata(array('inplaces' => $inplaces));
            $this->session->set_userdata(array('occupants' => $occupants));
            if ($orderfinal['order_type_code'] == '02') {
                $this->savePartition($this->input->post());
                return;
            }
            redirect(base_url() . "index.php/chithaeditentry/finalSaveNewOrder");
        }
    }

    public function savePartition($post) {

  $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $dag_no = $this->session->userdata('dag_no');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type_code = $this->session->userdata('patta_type_code');

        $data = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code,
            'dag_no' => $post['finalorder']['new_dag'],
            'dag_no_int' => $post['finalorder']['new_dag'] . "00",
            'old_dag_no' => $post['finalorder']['dag_no'],
            'patta_no' => trim($post['finalorder']['new_patta']),
            'old_patta_no' => trim($post['finalorder']['old_patta']),
            'dag_area_b' => $post['finalorder']['dag_area_b'],
            'dag_area_k' => $post['finalorder']['dag_area_k'],
            'dag_area_lc' => $post['finalorder']['dag_area_lc'],
            'dag_area_g' => $post['finalorder']['dag_area_g'],
            'dag_area_kr' => $post['finalorder']['dag_area_kr'],
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d'),
            'operation' => 'E',
            'patta_type_code' => $patta_type_code,
            'land_class_code' => $this->session->userdata('land_class_code')
        );

        // $this->db->insert('chitha_basic', $data);
        $this->Chitha_basic_model->insert_table('chitha_basic',$data);
        $pdar_id = 1;


        $inplaces = $this->session->userdata('inplaces');


        foreach ($inplaces as $inplace) {

            if (isset($inplace['include'])) {

                $data = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'pdar_id' => $pdar_id,
                    'patta_no' => trim($post['finalorder']['new_patta']),
                    'patta_type_code' => $this->session->userdata('patta_type_code'),
                    'pdar_name' => $inplace['inplace_of_name'],
                    'pdar_father' => $inplace['inplace_of_father'],
                    'user_code' => $this->session->userdata('user_code'),
                    'operation' => 'E',
                    'date_entry' => date('Y-m-d'),
                    'jama_yn' => 'N'
                );
                //$this->db->insert('chitha_pattadar', $data);
                $data = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'dag_no' => $post['finalorder']['new_dag'],
                    'pdar_id' => $pdar_id,
                    'patta_no' => trim($post['finalorder']['new_patta']),
                    'patta_type_code' => $patta_type_code,
                    'dag_por_b' => $post['finalorder']['dag_area_b'],
                    'dag_por_k' => $post['finalorder']['dag_area_b'],
                    'dag_por_lc' => $post['finalorder']['dag_area_b'],
                    'dag_por_g' => 0,
                    'dag_por_kr' => 0,
                    'user_code' => $this->session->userdata('user_code'),
                    'operation' => 'E',
                    'date_entry' => date('Y-m-d')
                );
                // $this->db->insert('chitha_dag_pattadar', $data);
                 $this->Chitha_basic_model->insert_table('chitha_dag_pattadar',$data);
                $data = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'dag_no' => $post['finalorder']['new_dag'],
                    'col8order_cron_no' => $post['finalorder']['col8order_cron_no'],
                    'occupant_id' => $pdar_id,
                    'land_area_b' => 0,
                    'land_area_k' => 0,
                    'land_area_lc' => 0,
                    'land_area_g' => 0,
                    'land_area_kr' => 0,
                    'user_code' => $this->session->userdata('user_code'),
                    'operation' => 'E',
                    'date_entry' => date('Y-m-d')
                );
                $values = array(
                    'occupant_name' => $inplace['inplace_of_name'],
                    'occupant_fmh_name' => $inplace['inplace_of_father'],
                );

                $data['dag_no'] = $dag_no;
                $data['new_dag_no'] = $post['finalorder']['new_dag'];
                $data['new_patta_no'] = trim($post['finalorder']['new_patta']);
                $this->db->insert('chitha_col8_occup', array_merge($values, $data));
                // $query = "update chitha_dag_pattadar p set p_flag='1' "
                //         . "where dag_no='$dag_no' and p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                //         . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                //         . " and p.lot_no='$lot_no' and TRIM(patta_no)='$patta_no' and patta_type_code='$patta_type_code' and pdar_id='$inplace[inplace_of_id]'";
                // $this->db->query($query);

                $table = 'chitha_dag_pattadar';

                $params = [
                    'p_flag' => '1',
                ];

                $where = [
                    'dag_no'             => $dag_no,
                    'dist_code'          => $dist_code,
                    'subdiv_code'        => $subdiv_code,
                    'cir_code'           => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'vill_townprt_code'  => $vill_townprt_code,
                    'lot_no'             => $lot_no,
                    'patta_no'           => trim($patta_no),
                    'patta_type_code'    => $patta_type_code,
                    'pdar_id'            => $inplace['inplace_of_id'], // Assuming $inplace is an array
                ];

                $this->Chitha_basic_model->update_table($table, $params, $where);

                $pdar_id++;
            }
        }

        $data = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code,
            'dag_no' => $post['finalorder']['new_dag'],
            'col8order_cron_no' => $post['finalorder']['col8order_cron_no'],
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d'),
            'operation' => 'E',
            'mut_land_area_b' => $post['finalorder']['dag_area_b'],
            'mut_land_area_k' => $post['finalorder']['dag_area_k'],
            'mut_land_area_lc' => $post['finalorder']['dag_area_lc'],
            'mut_land_area_g' => 0,
            'mut_land_area_kr' => 0,
            'land_area_left_b' => 0,
            'land_area_left_k' => 0,
            'land_area_left_lc' => 0,
            'land_area_left_g' => 0,
            'land_area_left_kr' => 0
        );
        unset($post['finalorder']['old_patta']);
        unset($post['finalorder']['new_dag']);
        unset($post['finalorder']['new_patta']);
        unset($post['finalorder']['dag_area_b']);
        unset($post['finalorder']['dag_area_k']);
        unset($post['finalorder']['dag_area_lc']);
        unset($post['finalorder']['dag_area_g']);
        unset($post['finalorder']['dag_area_kr']);
        unset($post['finalorder']['dag_no']);
        $this->db->insert('chitha_col8_order', array_merge($data, $post['finalorder']));

        $post['finalorder']['dag_no'] = $dag_no;
        unset($post['finalorder']['new_dag_no']);
        $this->db->insert('chitha_col8_order', array_merge($data, $post['finalorder']));
        redirect(base_url() . "chithaeditentry/orderlist/");
        return;
    }

    public function finalSave() {
		  $db=  $this->session->userdata('db');
        $orderfinal = $this->session->userdata('final');

        $occupants = $this->session->userdata('occupants');
        //var_dump($occupants);
        $inplaces = $this->session->userdata('inplaces');
        $removals = $this->session->userdata('removals');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type_code = $this->session->userdata('patta_type_code');
        $dag_no = $this->session->userdata('dag_no');
        $l_b = 0;
        $l_k = 0;
        $l_lc = 0;
        $l_g = 0;
        $l_kr = 0;
        foreach ($occupants as $occup) {
            $l_b += $occup['land_area_b'];
            $l_k += $occup['land_area_k'];
            $l_lc += $occup['land_area_lc'];
            $data = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'dag_no' => $dag_no,
                'col8order_cron_no' => $orderfinal['col8order_cron_no'],
                'occupant_id' => $occup['occupant_id']
            );
            $values = array(
                'occupant_name' => $occup['occupant_name'],
                'occupant_fmh_name' => $occup['occupant_fmh_name'],
                'occupant_add1' => $occup['occupant_add1'],
            );
            $this->db->where($data);

            $this->db->update('chitha_col8_occup', $values);
            if ($this->db->affected_rows() == 0) {
                $other_data = array(
                    'land_area_b' => $occup['land_area_b'],
                    'land_area_k' => $occup['land_area_k'],
                    'land_area_lc' => $occup['land_area_lc'],
                    'land_area_g' => 0,
                    'land_area_kr' => 0,
                    'date_entry' => date('Y-m-d'),
                    'operation' => 'E',
                    'user_code' => $this->session->userdata('user_code')
                );
                $final = array_merge($values, $data, $other_data);
                $this->db->insert('chitha_col8_occup', $final);
            } else {
                echo "Updated";
            }
        }
        echo $l_b . " " . $l_k . " " . $l_lc;
        $rem = $l_b * 100 + $l_k * 20 + $l_lc;

        $bigha_r = floor($rem / 100.0);
        echo $bigha_r;
        $katha_r = floor(($rem - $bigha_r * 100.0) / 20.0);
        $lessa_r = $rem - $bigha_r * 100.0 - $katha_r * 20.0;
        $data = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code,
            'dag_no' => $dag_no,
            'col8order_cron_no' => $orderfinal['col8order_cron_no'],
        );
        $this->db->where($data);
        $values = array(
            'mut_land_area_b' => $bigha_r,
            'mut_land_area_k' => $katha_r,
            'mut_land_area_lc' => $lessa_r,
        );

        $this->db->update('chitha_col8_order', $values);
        foreach ($inplaces as $inplace) {
            $data = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'dag_no' => $dag_no,
                'col8order_cron_no' => $orderfinal['col8order_cron_no'],
            );
            $values = array(
                'inplace_of_name' => $inplace['inplace_of_name'],
                'inplace_of_father' => $inplace['inplace_of_father'],
                'inplaceof_alongwith' => $inplace['inplaceof_alongwith'],
            );
            $this->db->where($data);
            $this->db->update('chitha_col8_inplace', $values);
            if ($inplace['inplaceof_alongwith'] == 'i') {
                // $query = "update chitha_dag_pattadar p set p_flag='1' "
                //         . "where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                //         . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                //         . " and p.lot_no='$lot_no' and p.dag_no='$dag_no' and TRIM(patta_no)='$patta_no' and patta_type_code='$patta_type_code' and pdar_id='$inplace[inplace_of_id]'";
                // //echo $query;
                // $this->db->query($query);
                $table = 'chitha_dag_pattadar';

                $params = [
                    'p_flag' => '1',
                ];

                $where = [
                    'dist_code'          => $dist_code,
                    'subdiv_code'        => $subdiv_code,
                    'cir_code'           => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'vill_townprt_code'  => $vill_townprt_code,
                    'lot_no'             => $lot_no,
                    'dag_no'             => $dag_no,
                    'patta_no'           => trim($patta_no),
                    'patta_type_code'    => $patta_type_code,
                    'pdar_id'            => $inplace['inplace_of_id'],  // Assuming $inplace is an array
                ];

                // Then call your model's update method:
                $this->Chitha_basic_model->update_table($table, $params, $where);

            } else {
                // $query = "update chitha_dag_pattadar p set p_flag='0' "
                //         . "where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                //         . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                //         . " and p.lot_no='$lot_no' and p.dag_no='$dag_no' and TRIM(patta_no)='$patta_no' and patta_type_code='$patta_type_code' and pdar_id='$inplace[inplace_of_id]'";
                // //echo $query;
                // $this->db->query($query);
                $table = 'chitha_dag_pattadar';

                $params = [
                    'p_flag' => '0',
                ];

                $where = [
                    'dist_code'          => $dist_code,
                    'subdiv_code'        => $subdiv_code,
                    'cir_code'           => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'vill_townprt_code'  => $vill_townprt_code,
                    'lot_no'             => $lot_no,
                    'dag_no'             => $dag_no,
                    'patta_no'           => trim($patta_no),
                    'patta_type_code'    => $patta_type_code,
                    'pdar_id'            => $inplace['inplace_of_id'],
                ];

                $this->Chitha_basic_model->update_table($table, $params, $where);

            }
        }

        foreach ($removals as $key => $value) {
            $data = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'dag_no' => $dag_no,
                'col8order_cron_no' => $orderfinal['col8order_cron_no'],
                'occupant_id' => $value['id']
            );
            $this->db->where($data);
            $this->db->delete('chitha_col8_occup');
            $this->session->unset_userdata('removals');
            $this->session->unset_userdata('occupants');
            $this->session->unset_userdata('inplaces');
            $this->session->unset_userdata('final');
        }
        redirect(base_url() . "index.php/chithaeditentry/orderlist");
    }

    public function finalSaveNewOrder() {
		  $db=  $this->session->userdata('db');
        $orderfinal = $this->session->userdata('final');

        $occupants = $this->session->userdata('occupants');
        //var_dump($occupants);

        $inplaces = $this->session->userdata('inplaces');

        $removals = $this->session->userdata('removals');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type_code = $this->session->userdata('patta_type_code');
        $dag_no = $this->session->userdata('dag_no');
        $occupant_id = 1;
        $l_b = 0;
        $l_k = 0;
        $l_lc = 0;
        $l_g = 0;
        $l_kr = 0;
        foreach ($occupants as $occup) {
            $q = "select max(p.pdar_id)+1 as pdar_id from    chitha_pattadar p where p.dist_code='$dist_code' and"
                    . " p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no' 
            and p.patta_type_code='$patta_type_code' ";
            //echo $q;

            $pdar_id = $this->db->query($q)->row()->pdar_id;

            if ($pdar_id == null) {
                $pdar_id = 1;
            }
            $data = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'dag_no' => $dag_no,
                'col8order_cron_no' => $orderfinal['col8order_cron_no'],
                'occupant_id' => $occupant_id++,
                'land_area_g' => 0,
                'land_area_kr' => 0,
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
            );

            $l_b += $occup['land_area_b'];
            $l_k += $occup['land_area_k'];
            $l_lc += $occup['land_area_lc'];

            $final = array_merge($data, $occup);
            $this->db->insert('chitha_col8_occup', $final);

            $data = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'pdar_id' => $pdar_id,
                'patta_no' => trim($patta_no),
                'patta_type_code' => $patta_type_code,
                'pdar_name' => $occup['occupant_name'],
                'pdar_father' => $occup['occupant_fmh_name'],
                'user_code' => $this->session->userdata('user_code'),
                'operation' => 'E',
                'date_entry' => date('Y-m-d'),
                'jama_yn' => 'N'
            );
            // $this->db->insert('chitha_pattadar', $data);
            $this->Chitha_basic_model->insert_table('chitha_pattadar',$data);
            $data = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'dag_no' => $dag_no,
                'pdar_id' => $pdar_id,
                'patta_no' => trim($patta_no),
                'patta_type_code' => $patta_type_code,
                'dag_por_b' => $occup['land_area_b'],
                'dag_por_k' => $occup['land_area_k'],
                'dag_por_lc' => $occup['land_area_lc'],
                'dag_por_g' => 0,
                'dag_por_kr' => 0,
                'user_code' => $this->session->userdata('user_code'),
                'operation' => 'E',
                'date_entry' => date('Y-m-d')
            );
            // $this->db->insert('chitha_dag_pattadar', $data);
             $this->Chitha_basic_model->insert_table('chitha_dag_pattadar',$data);
        }

        $rem = $l_b * 100 + $l_k * 20 + $l_lc;

        $bigha_r = floor($rem / 100.0);
        $katha_r = floor(($rem - $bigha_r * 100.0) / 20.0);
        $lessa_r = $rem - $bigha_r * 100.0 - $katha_r * 20.0;
        $data = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code,
            'dag_no' => $dag_no,
            'col8order_cron_no' => $orderfinal['col8order_cron_no'],
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d'),
            'operation' => 'E',
            'mut_land_area_b' => $bigha_r,
            'mut_land_area_k' => $katha_r,
            'mut_land_area_lc' => $lessa_r,
            'mut_land_area_g' => 0,
            'mut_land_area_kr' => 0,
            'land_area_left_b' => 0,
            'land_area_left_k' => 0,
            'land_area_left_lc' => 0,
            'land_area_left_g' => 0,
            'land_area_left_kr' => 0
        );
        unset($orderfinal['old_patta']);
        unset($orderfinal['new_dag']);
        unset($orderfinal['new_patta']);
        unset($orderfinal['dag_area_b']);
        unset($orderfinal['dag_area_k']);
        unset($orderfinal['dag_area_lc']);
        unset($orderfinal['dag_area_g']);
        unset($orderfinal['dag_area_kr']);

        $this->db->insert('chitha_col8_order', array_merge($orderfinal, $data));

        $inplace_of_id = 1;
        foreach ($inplaces as $inplace) {
            //var_dump($inplace);
            if (isset($inplace['include'])) {
                $data = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'dag_no' => $dag_no,
                    'col8order_cron_no' => $orderfinal['col8order_cron_no'],
                    'inplace_of_id' => $inplace_of_id++,
                    'land_area_b' => 0,
                    'land_area_k' => 0,
                    'land_area_lc' => 0,
                    'land_area_g' => 0,
                    'land_area_kr' => 0,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d'),
                    'operation' => 'E',
                );
                $values = array(
                    'inplace_of_name' => $inplace['inplace_of_name'],
                    'inplace_of_father' => $inplace['inplace_of_father'],
                    'inplaceof_alongwith' => $inplace['inplaceof_alongwith'],
                );
                $final = array_merge($values, $data);
                $this->db->insert('chitha_col8_inplace', $final);
                if ($inplace['inplaceof_alongwith'] == 'i') {
                    // $query = "update chitha_dag_pattadar p set p_flag='1' "
                    //         . "where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                    //         . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    //         . " and p.lot_no='$lot_no' and p.dag_no='$dag_no' and TRIM(patta_no)='$patta_no' and patta_type_code='$patta_type_code' and pdar_id='$inplace[inplace_of_id]'";

                    // $this->db->query($query);
                    $table = 'chitha_dag_pattadar';

                    $params = [
                        'p_flag' => '1',
                    ];

                    $where = [
                        'dist_code'          => $dist_code,
                        'subdiv_code'        => $subdiv_code,
                        'cir_code'           => $cir_code,
                        'mouza_pargona_code' => $mouza_pargona_code,
                        'vill_townprt_code'  => $vill_townprt_code,
                        'lot_no'             => $lot_no,
                        'dag_no'             => $dag_no,
                        'patta_no'           => trim($patta_no),
                        'patta_type_code'    => $patta_type_code,
                        'pdar_id'            => $inplace['inplace_of_id'],
                    ];

                    $this->Chitha_basic_model->update_table($table, $params, $where);

                }
            }
        }


        $this->session->unset_userdata('removals');
        $this->session->unset_userdata('occupants');
        $this->session->unset_userdata('inplaces');
        $this->session->unset_userdata('final');
        redirect(base_url() . "index.php/chithaeditentry/orderlist");
    }

    public function orderList() {
		  $db=  $this->session->userdata('db');
		
		
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $patta_no = trim($this->session->userdata('patta_no'));
            $patta_type_code = $this->session->userdata('patta_type_code');
            $dag_no = $this->session->userdata('dag_no');
            $query = "select * from    chitha_col8_order p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                    . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    . " and p.lot_no='$lot_no' and p.dag_no='$dag_no'  "
                    . " ";
            $data['orders'] = $this->db->query($query)->result();
            $query = "select * from    chitha_rmk_ordbasic p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                    . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    . " and p.lot_no='$lot_no' and p.dag_no='$dag_no'  "
                    . " ";
            $data['orders31'] = $this->db->query($query)->result();

            $this->load->helper('html');
            $this->load->view('../views/header');
            $this->load->view('../views/chithaeditentry/orderlist', $data);
            $this->load->view('../views/footer');
        }
    }

    public function removeApplicant($id) {
		
		  $db=  $this->session->userdata('db');
        $data = $this->input->post();
        //var_dump($data);
        if ($this->session->userdata('removals') == null) {
            $this->session->set_userdata('removals', array());
            $removals = $this->session->userdata('removals');
            $removals[] = $data;
            $this->session->set_userdata(array('removals' => $removals));
        } else {
            $removals = $this->session->userdata('removals');
            $removals[] = $data;
            $this->session->set_userdata(array('removals' => $removals));
        }
        //var_dump($this->session->userdata('removals'));
    }

    public function deletepattadars() {
		  $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $patta_no = $this->session->userdata('patta_no');
        $patta_type_code = $this->session->userdata('patta_type_code');
        $dag_no = $this->session->userdata('dag_no');
        $pdar_id = $this->input->post('id');
        $query = "delete from    chitha_dag_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                . " and p.lot_no='$lot_no' and p.dag_no='$dag_no' and TRIM(patta_no)='$patta_no' and patta_type_code='$patta_type_code' and pdar_id='$pdar_id'";
        $this->db->query($query);
        $query = "delete from    chitha_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                . " and p.lot_no='$lot_no' and TRIM(patta_no)='$patta_no' and patta_type_code='$patta_type_code' and pdar_id='$pdar_id'";
        $this->db->query($query);
        $pattadars_new = $this->session->userdata('pattadars_new');
        foreach ($pattadars_new as $key => $p) {
            if ($p['pdar_id'] == $pdar_id) {
                //echo $key;
                unset($pattadars_new[$key]);
                $max_pdar_id = $this->session->userdata('max_pdar_id') - 1;
                $this->session->set_userdata('max_pdar_id', $max_pdar_id);
            }
        }
        $this->session->set_userdata('pattadars_new', $pattadars_new);
    }

    public function strikeoutPattadar($pdar_id) {
		  $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type_code = $this->session->userdata('patta_type_code');
        $dag_no = $this->session->userdata('dag_no');
        //echo $pdar_id;
        // $query = "update  chitha_dag_pattadar p set p_flag='1' where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
        //         . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
        //         . " and p.lot_no='$lot_no' and p.dag_no='$dag_no' and TRIM(patta_no)='$patta_no' and patta_type_code='$patta_type_code' and pdar_id='$pdar_id'";
        // $this->db->query($query);
        $table = 'chitha_dag_pattadar';

        $params = [
            'p_flag' => '1',
        ];

        $where = [
            'dist_code'          => $dist_code,
            'subdiv_code'        => $subdiv_code,
            'cir_code'           => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'vill_townprt_code'  => $vill_townprt_code,
            'lot_no'             => $lot_no,
            'dag_no'             => $dag_no,
            'patta_no'           => trim($patta_no),
            'patta_type_code'    => $patta_type_code,
            'pdar_id'            => $pdar_id,
        ];

        $this->Chitha_basic_model->update_table($table, $params, $where);

        redirect(base_url() . "index.php/chithaeditentry/pattadardetails");
    }

    public function unstrikeoutPattadar($pdar_id) {
		  $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type_code = $this->session->userdata('patta_type_code');
        $dag_no = $this->session->userdata('dag_no');

        // $query = "update  chitha_dag_pattadar p set p_flag='0' where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
        //         . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
        //         . " and p.lot_no='$lot_no' and p.dag_no='$dag_no' and TRIM(patta_no)='$patta_no' and patta_type_code='$patta_type_code' and pdar_id='$pdar_id'";
        // $this->db->query($query);
        $table = 'chitha_dag_pattadar';

        $params = [
            'p_flag' => '0',
        ];

        $where = [
            'dist_code'          => $dist_code,
            'subdiv_code'        => $subdiv_code,
            'cir_code'           => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'vill_townprt_code'  => $vill_townprt_code,
            'lot_no'             => $lot_no,
            'dag_no'             => $dag_no,
            'patta_no'           => trim($patta_no),
            'patta_type_code'    => $patta_type_code,
            'pdar_id'            => $pdar_id,
        ];

        $this->Chitha_basic_model->update_table($table, $params, $where);

        redirect(base_url() . "index.php/chithaeditentry/pattadardetails");
    }

    public function deletePattadar($pdar_id) {
		  $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type_code = $this->session->userdata('patta_type_code');
        $dag_no = $this->session->userdata('dag_no');

        $query = "delete from     chitha_dag_pattadar where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                . " and p.lot_no='$lot_no' and p.dag_no='$dag_no' and TRIM(patta_no)='$patta_no' and patta_type_code='$patta_type_code' and pdar_id='$pdar_id'";
        $this->db->query($query);
        $query = "delete from     chitha_pattadar where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                . " and p.lot_no='$lot_no' and TRIM(patta_no)='$patta_no' and patta_type_code='$patta_type_code' and pdar_id='$pdar_id'";
        $this->db->query($query);
        redirect(base_url() . "index.php/chithaeditentry/pattadardetails");
    }

    public function step1() {
		  $db=  $this->session->userdata('db');
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $dag_no = $this->session->userdata('dag_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $ord_type_query = "select * from    master_office_mut_type";
            $data['ord_types'] = $this->db->query($ord_type_query)->result();

            $trans_code_query = "select * from    nature_trans_code";
            $data['trans_codes'] = $this->db->query($trans_code_query)->result();
            $mandals_query = "select * from    lm_code where  dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code' and "
                    . "lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code'";

            $data['mandals'] = $this->db->query($mandals_query)->result();
            $cos_query = "select * from    users where user_desig_code='CO'  and dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code' ";


            $data['cos'] = $this->db->query($cos_query)->result();

            $sks_query = "select * from    users where user_desig_code='SK' and dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code' ";


            $data['cos'] = $this->db->query($cos_query)->result();
            $data['sks'] = $this->db->query($sks_query)->result();
            $max_rmk_type_hist_no_q = "select max(rmk_type_hist_no)+1 as max from    chitha_rmk_ordbasic p where  p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                    . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    . " and p.lot_no='$lot_no' and p.dag_no='$dag_no'  ";
            $max_rmk_type_hist_no = $this->db->query($max_rmk_type_hist_no_q)->row()->max;
            if ($max_rmk_type_hist_no == null) {
                $max_rmk_type_hist_no = 1;
            }
            $data['max_no'] = $max_rmk_type_hist_no;

            $ord_cron_no_q = "select max(ord_cron_no)+1 as max from    chitha_rmk_ordbasic p where  p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                    . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    . " and p.lot_no='$lot_no' and p.dag_no='$dag_no'  ";
            $max_ord_cron_no = $this->db->query($ord_cron_no_q)->row()->max;
            if ($max_ord_cron_no == null) {
                $max_ord_cron_no = 1;
            }



            $data['max_no'] = $max_rmk_type_hist_no;
            $data['max_cron_no'] = $max_ord_cron_no;

            $this->load->helper('html');
            $this->load->view('../views/header');
            $this->load->view('../views/ChithaEditEntry/order31step1', $data);
            $this->load->view('../views/footer');
        } else {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $dag_no = $this->session->userdata('dag_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $data = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'dag_no' => $dag_no,
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
                'm_dag_area_b' => 0,
                'm_dag_area_k' => 0,
                'm_dag_area_lc' => 0,
                'm_dag_area_g' => 0,
                'm_dag_area_kr' => 0,
                'area_left_b' => 0,
                'area_left_k' => 0,
                'area_left_lc' => 0,
                'area_left_g' => 0,
                'area_left_kr' => 0,
            );
            $formdata = $this->input->post();
            unset($formdata['submit']);
            $final = array_merge($data, $formdata);
            //$this->db->insert('chitha_rmk_ordbasic', $final);
            $this->session->set_userdata(array('finalmainorder' => $final));
            $this->session->set_userdata(array('ord_no' => $this->input->post('case_no')));
            $this->session->set_userdata(array('ord_cron_no' => $this->input->post('ord_cron_no')));
            $this->session->set_userdata(array('ord_date' => $this->input->post('ord_date')));
            $this->session->set_userdata(array('rmk_type_hist_no' => $this->input->post('rmk_type_hist_no')));
            switch ($this->input->post('ord_type_code')) {
                case '01':
                    redirect(base_url() . "index.php/utility/BackEntryLandConversion");
                    break;
                case '03':
                    redirect(base_url() . "index.php/chithaeditentry/step2");
                    break;
                case '04':
                    redirect(base_url() . "index.php/Backlogpartition/index");
                    break;
                case '02':
                    redirect(base_url() . "index.php/Backlogpartition/index");
                    break;
                default:
                    break;
            }
            redirect(base_url() . "index.php/chithaeditentry/step2");
        }
    }

    public function step2edit($id) {
		  $db=  $this->session->userdata('db');
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $dag_no = $this->session->userdata('dag_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $ord_no = $this->session->userdata('ord_no');
            $cron = $this->session->userdata('ord_cron_no');
            $rmk_type_hist_no = $this->session->userdata('rmk_type_hist_no');

            $data = array();
            $this->load->model('relation/relationmodel');
            $data['relation'] = $this->relationmodel->getRelations();
            $patta_types = $this->db->query("select type_code,patta_type from    patta_code")->result();
            $data['patta_types'] = $patta_types;
            $trans_code_query = "select * from    nature_trans_code";
            $data['trans_codes'] = $this->db->query($trans_code_query)->result();
            $all_q = "select * from    chitha_rmk_infavor_of p where  p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                    . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    . " and p.lot_no='$lot_no' and p.dag_no='$dag_no' and ord_no='$ord_no' and ord_cron_no='$cron' and"
                    . " rmk_type_hist_no='$rmk_type_hist_no' and infavor_of_id=$id  ";
            $data['all'] = $this->db->query($all_q)->row();
            $this->load->helper('html');
            $this->load->view('../views/header');
            $this->load->view('../views/ChithaEditEntry/step2edit', $data);
            $this->load->view('../views/footer');
        } else {

            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $dag_no = $this->session->userdata('dag_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $data = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'dag_no' => $dag_no,
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
                'rmk_type_hist_no' => $this->session->userdata('rmk_type_hist_no'),
            );
            $formdata = $this->input->post();
            $formdata['reg_date'] = null;
            unset($formdata['submit']);
            $final = array_merge($data, $formdata);
            if ($this->session->userdata('infav') == null) {
                $this->session->set_userdata('infav', array());
                $toPush = $this->session->userdata('infav');
                $toPush[] = $final;
                $this->session->set_userdata(array('infav' => $toPush));
            } else {
                $toPush = $this->session->userdata('infav');
                $toPush[] = $final;
                $this->session->set_userdata(array('infav' => $toPush));
            }

            redirect(base_url() . "index.php/chithaeditentry/step2list/");
        }
    }

    public function step2list() {
		  $db=  $this->session->userdata('db');
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $dag_no = $this->session->userdata('dag_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $ord_no = $this->session->userdata('ord_no');
            $cron = $this->session->userdata('ord_cron_no');
            $rmk_type_hist_no = $this->session->userdata('rmk_type_hist_no');

            $data = array();
            $this->load->model('relation/relationmodel');
            $data['relation'] = $this->relationmodel->getRelations();
            $patta_types = $this->db->query("select type_code,patta_type from    patta_code")->result();
            $data['patta_types'] = $patta_types;
            $trans_code_query = "select * from    nature_trans_code";
            $data['trans_codes'] = $this->db->query($trans_code_query)->result();
            $all_q = "select * from    chitha_rmk_infavor_of p where  p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                    . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    . " and p.lot_no='$lot_no' and p.dag_no='$dag_no' and ord_no='$ord_no' and ord_cron_no='$cron' and"
                    . " rmk_type_hist_no='$rmk_type_hist_no'  ";
            $data['all'] = $this->db->query($all_q)->result();
            //var_dump($data['all']);
            $this->load->helper('html');
            $this->load->view('../views/header');
            $this->load->view('../views/ChithaEditEntry/step2list', $data);
            $this->load->view('../views/footer');
        } else {

            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $dag_no = $this->session->userdata('dag_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $data = array(
                'infavor_of_id' => 1,
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'dag_no' => $dag_no,
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
                'rmk_type_hist_no' => $this->session->userdata('rmk_type_hist_no'),
            );
            $formdata = $this->input->post();
            $formdata['reg_date'] = null;
            unset($formdata['submit']);
            $final = array_merge($data, $formdata);
            if ($this->session->userdata('infav') == null) {
                $this->session->set_userdata('infav', array());
                $toPush = $this->session->userdata('infav');
                $toPush[] = $final;
                $this->session->set_userdata(array('infav' => $toPush));
            } else {
                $toPush = $this->session->userdata('infav');
                $toPush[] = $final;
                $this->session->set_userdata(array('infav' => $toPush));
            }

            redirect(base_url() . "index.php/chithaeditentry/step2/");
        }
    }

//    public function step2edit() {
//        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
//            $dist_code = $this->session->userdata('dist_code');
//            $subdiv_code = $this->session->userdata('subdiv_code');
//            $cir_code = $this->session->userdata('cir_code');
//            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
//            $lot_no = $this->session->userdata('lot_no');
//            $dag_no = $this->session->userdata('dag_no');
//            $vill_townprt_code = $this->session->userdata('vill_code');
//            $ord_no = $this->session->userdata('ord_no');
//            $cron = $this->session->userdata('ord_cron_no');
//            $rmk_type_hist_no = $this->session->userdata('rmk_type_hist_no');
//
//            $data = array();
//            $this->load->model('relation/relationmodel');
//            $data['relation'] = $this->relationmodel->getRelations();
//            $patta_types = $this->db->query("select type_code,patta_type from    patta_code")->result();
//            $data['patta_types'] = $patta_types;
//            $trans_code_query = "select * from    nature_trans_code";
//            $data['trans_codes'] = $this->db->query($trans_code_query)->result();
//            $all_q = "select * from    chitha_rmk_infavor_of p where  p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
//                    . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
//                    . " and p.lot_no='$lot_no' and p.dag_no='$dag_no' and ord_no='$ord_no' and ord_cron_no='$cron' and"
//                    . " rmk_type_hist_no='$rmk_type_hist_no'  ";
//            $data['all'] = $this->db->query($all_q)->row();
//            $this->load->helper('html');
//            $this->load->view('../views/header');
//            $this->load->view('../views/ChithaEditEntry/step2edit', $data);
//            $this->load->view('../views/footer');
//        } else {
//
//            $dist_code = $this->session->userdata('dist_code');
//            $subdiv_code = $this->session->userdata('subdiv_code');
//            $cir_code = $this->session->userdata('cir_code');
//            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
//            $lot_no = $this->session->userdata('lot_no');
//            $dag_no = $this->session->userdata('dag_no');
//            $vill_townprt_code = $this->session->userdata('vill_code');
//            $data = array(
//                'infavor_of_id' => 1,
//                'dist_code' => $dist_code,
//                'subdiv_code' => $subdiv_code,
//                'cir_code' => $cir_code,
//                'mouza_pargona_code' => $mouza_pargona_code,
//                'lot_no' => $lot_no,
//                'vill_townprt_code' => $vill_townprt_code,
//                'dag_no' => $dag_no,
//                'user_code' => $this->session->userdata('user_code'),
//                'date_entry' => date('Y-m-d'),
//                'operation' => 'E',
//                'rmk_type_hist_no' => $this->session->userdata('rmk_type_hist_no'),
//            );
//            $formdata = $this->input->post();
//            $formdata['reg_date'] = null;
//            unset($formdata['submit']);
//            $final = array_merge($data, $formdata);
//            if ($this->session->userdata('infav') == null) {
//                $this->session->set_userdata('infav', array());
//                $toPush = $this->session->userdata('infav');
//                $toPush[] = $final;
//                $this->session->set_userdata(array('infav' => $toPush));
//            } else {
//                $toPush = $this->session->userdata('infav');
//                $toPush[] = $final;
//                $this->session->set_userdata(array('infav' => $toPush));
//            }
//
//            redirect(base_url() . "index.php/chithaeditentry/step2/");
//        }
//    }

    public function step3list() {
		  $db=  $this->session->userdata('db');
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $dag_no = $this->session->userdata('dag_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $ord_no = $this->session->userdata('ord_no');
            $cron = $this->session->userdata('ord_cron_no');
            $rmk_type_hist_no = $this->session->userdata('rmk_type_hist_no');
            $data = array();
            $this->load->model('relation/relationmodel');
            $data['relation'] = $this->relationmodel->getRelations();
            $patta_types = $this->db->query("select type_code,patta_type from    patta_code")->result();
            $data['patta_types'] = $patta_types;
            $trans_code_query = "select * from    nature_trans_code";
            $data['trans_codes'] = $this->db->query($trans_code_query)->result();
            $all_q = "select * from    chitha_rmk_alongwith p where  p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                    . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    . " and p.lot_no='$lot_no' and p.dag_no='$dag_no' and ord_no='$ord_no' and ord_cron_no='$cron' and"
                    . " rmk_type_hist_no='$rmk_type_hist_no'  ";
            $data['all'] = $this->db->query($all_q)->result();
            $this->load->helper('html');
            $this->load->view('../views/header');
            $this->load->view('../views/ChithaEditEntry/step3list', $data);
            $this->load->view('../views/footer');
        } else {

            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $dag_no = $this->session->userdata('dag_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $data = array(
                'alongwith_id' => 1,
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'dag_no' => $dag_no,
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
                'rmk_type_hist_no' => $this->session->userdata('rmk_type_hist_no'),
            );
            $formdata = $this->input->post();

            unset($formdata['submit']);
            $final = array_merge($data, $formdata);

            //$this->db->insert('chitha_rmk_alongwith',$final);
            if ($this->session->userdata('alongwith') == null) {
                $this->session->set_userdata('alongwith', array());
                $toPush = $this->session->userdata('alongwith');
                $toPush[] = $final;
                $this->session->set_userdata(array('alongwith' => $toPush));
            } else {
                $toPush = $this->session->userdata('alongwith');
                $toPush[] = $final;
                $this->session->set_userdata(array('alongwith' => $toPush));
            }
            redirect(base_url() . "index.php/chithaeditentry/step3edit/");
        }
    }

    public function step3edit($id) {
		  $db=  $this->session->userdata('db');
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $dag_no = $this->session->userdata('dag_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $ord_no = $this->session->userdata('ord_no');
            $cron = $this->session->userdata('ord_cron_no');
            $rmk_type_hist_no = $this->session->userdata('rmk_type_hist_no');
            $data = array();
            $this->load->model('relation/relationmodel');
            $data['relation'] = $this->relationmodel->getRelations();
            $patta_types = $this->db->query("select type_code,patta_type from    patta_code")->result();
            $data['patta_types'] = $patta_types;
            $trans_code_query = "select * from    nature_trans_code";
            $data['trans_codes'] = $this->db->query($trans_code_query)->result();
            $all_q = "select * from    chitha_rmk_alongwith p where  p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                    . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    . " and p.lot_no='$lot_no' and p.dag_no='$dag_no' and ord_no='$ord_no' and ord_cron_no='$cron' and"
                    . " rmk_type_hist_no='$rmk_type_hist_no' and alongwith_id=$id ";
            $data['all'] = $this->db->query($all_q)->row();
            $this->load->helper('html');
            $this->load->view('../views/header');
            $this->load->view('../views/ChithaEditEntry/step3edit', $data);
            $this->load->view('../views/footer');
        } else {

            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $dag_no = $this->session->userdata('dag_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $data = array(
                'alongwith_id' => 1,
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'dag_no' => $dag_no,
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
                'rmk_type_hist_no' => $this->session->userdata('rmk_type_hist_no'),
            );
            $formdata = $this->input->post();

            unset($formdata['submit']);
            $final = array_merge($data, $formdata);

            //$this->db->insert('chitha_rmk_alongwith',$final);
            if ($this->session->userdata('alongwith') == null) {
                $this->session->set_userdata('alongwith', array());
                $toPush = $this->session->userdata('alongwith');
                $toPush[] = $final;
                $this->session->set_userdata(array('alongwith' => $toPush));
            } else {
                $toPush = $this->session->userdata('alongwith');
                $toPush[] = $final;
                $this->session->set_userdata(array('alongwith' => $toPush));
            }
            redirect(base_url() . "index.php/chithaeditentry/step3list/");
        }
    }

    public function step3Delete($id) {
		  $db=  $this->session->userdata('db');
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $dag_no = $this->session->userdata('dag_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $ord_no = $this->session->userdata('ord_no');
            $cron = $this->session->userdata('ord_cron_no');
            $rmk_type_hist_no = $this->session->userdata('rmk_type_hist_no');
            $data = array(
                'alongwith_id' => $id,
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'dag_no' => $dag_no,
                'ord_no' => $ord_no,
                'ord_cron_no' => $cron,
                'rmk_type_hist_no' => $rmk_type_hist_no
            );
            $this->db->where($data);
            $this->db->delete('chitha_rmk_alongwith');
        }
    }

    public function step2() {
		  $db=  $this->session->userdata('db');
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $dag_no = $this->session->userdata('dag_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $data = array();
            $this->load->model('relation/relationmodel');
            $data['relation'] = $this->relationmodel->getRelations();
            $patta_types = $this->db->query("select type_code,patta_type from    patta_code")->result();
            $data['patta_types'] = $patta_types;
            $trans_code_query = "select * from    nature_trans_code";
            $data['trans_codes'] = $this->db->query($trans_code_query)->result();

            $this->load->helper('html');
            $this->load->view('../views/header');
            $this->load->view('../views/ChithaEditEntry/step2', $data);
            $this->load->view('../views/footer');
        } else {

            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $dag_no = $this->session->userdata('dag_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $data = array(
                'infavor_of_id' => 1,
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'dag_no' => $dag_no,
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
                'rmk_type_hist_no' => $this->session->userdata('rmk_type_hist_no'),
            );
            $formdata = $this->input->post();
            $formdata['reg_date'] = null;
            unset($formdata['submit']);
            $final = array_merge($data, $formdata);
            if ($this->session->userdata('infav') == null) {
                $this->session->set_userdata('infav', array());
                $toPush = $this->session->userdata('infav');
                $toPush[] = $final;
                $this->session->set_userdata(array('infav' => $toPush));
            } else {
                $toPush = $this->session->userdata('infav');
                $toPush[] = $final;
                $this->session->set_userdata(array('infav' => $toPush));
            }

            redirect(base_url() . "index.php/chithaeditentry/step2/");
        }
    }

    public function step3() {
		  $db=  $this->session->userdata('db');
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $dag_no = $this->session->userdata('dag_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $data = array();
            $this->load->model('relation/relationmodel');
            $data['relation'] = $this->relationmodel->getRelations();
            $patta_types = $this->db->query("select type_code,patta_type from    patta_code")->result();
            $data['patta_types'] = $patta_types;
            $trans_code_query = "select * from    nature_trans_code";
            $data['trans_codes'] = $this->db->query($trans_code_query)->result();

            $this->load->helper('html');
            $this->load->view('../views/header');
            $this->load->view('../views/ChithaEditEntry/step3', $data);
            $this->load->view('../views/footer');
        } else {

            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $dag_no = $this->session->userdata('dag_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $data = array(
                'alongwith_id' => 1,
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'dag_no' => $dag_no,
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
                'rmk_type_hist_no' => $this->session->userdata('rmk_type_hist_no'),
            );
            $formdata = $this->input->post();

            unset($formdata['submit']);
            $final = array_merge($data, $formdata);

            //$this->db->insert('chitha_rmk_alongwith',$final);
            if ($this->session->userdata('alongwith') == null) {
                $this->session->set_userdata('alongwith', array());
                $toPush = $this->session->userdata('alongwith');
                $toPush[] = $final;
                $this->session->set_userdata(array('alongwith' => $toPush));
            } else {
                $toPush = $this->session->userdata('alongwith');
                $toPush[] = $final;
                $this->session->set_userdata(array('alongwith' => $toPush));
            }
            redirect(base_url() . "index.php/chithaeditentry/step3/");
        }
    }

    public function step4list() {
		  $db=  $this->session->userdata('db');
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $dag_no = $this->session->userdata('dag_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $ord_no = $this->session->userdata('ord_no');
            $cron = $this->session->userdata('ord_cron_no');
            $rmk_type_hist_no = $this->session->userdata('rmk_type_hist_no');
            $data = array();
            $this->load->model('relation/relationmodel');
            $data['relation'] = $this->relationmodel->getRelations();
            $patta_types = $this->db->query("select type_code,patta_type from    patta_code")->result();
            $data['patta_types'] = $patta_types;
            $trans_code_query = "select * from    nature_trans_code";
            $data['trans_codes'] = $this->db->query($trans_code_query)->result();
            $all_q = "select * from    chitha_rmk_inplace_of p where  p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                    . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    . " and p.lot_no='$lot_no' and p.dag_no='$dag_no' and ord_no='$ord_no' and ord_cron_no='$cron' and"
                    . " rmk_type_hist_no='$rmk_type_hist_no'  ";
            $data['all'] = $this->db->query($all_q)->result();
            $this->load->helper('html');
            $this->load->view('../views/header');
            $this->load->view('../views/ChithaEditEntry/step4list', $data);
            $this->load->view('../views/footer');
        } else {

            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $dag_no = $this->session->userdata('dag_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $data = array(
                'inplace_of_id' => 1,
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'dag_no' => $dag_no,
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
                'rmk_type_hist_no' => $this->session->userdata('rmk_type_hist_no'),
            );
            $formdata = $this->input->post();

            unset($formdata['submit']);
            $final = array_merge($data, $formdata);

            //$this->db->insert('chitha_rmk_inplace_of',$final);
            if ($this->session->userdata('inplace') == null) {
                $this->session->set_userdata('inplace', array());
                $toPush = $this->session->userdata('inplace');
                $toPush[] = $final;
                $this->session->set_userdata(array('inplace' => $toPush));
            } else {
                $toPush = $this->session->userdata('inplace');
                $toPush[] = $final;
                $this->session->set_userdata(array('inplace' => $toPush));
            }
            redirect(base_url() . "index.php/chithaeditentry/step4/");
        }
    }

    public function step4edit($id) {
		  $db=  $this->session->userdata('db');
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $dag_no = $this->session->userdata('dag_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $ord_no = $this->session->userdata('ord_no');
            $cron = $this->session->userdata('ord_cron_no');
            $rmk_type_hist_no = $this->session->userdata('rmk_type_hist_no');
            $data = array();
            $this->load->model('relation/relationmodel');
            $data['relation'] = $this->relationmodel->getRelations();
            $patta_types = $this->db->query("select type_code,patta_type from    patta_code")->result();
            $data['patta_types'] = $patta_types;
            $trans_code_query = "select * from    nature_trans_code";
            $data['trans_codes'] = $this->db->query($trans_code_query)->result();
            $all_q = "select * from    chitha_rmk_inplace_of p where  p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                    . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    . " and p.lot_no='$lot_no' and p.dag_no='$dag_no' and ord_no='$ord_no' and ord_cron_no='$cron' and"
                    . " rmk_type_hist_no='$rmk_type_hist_no' and inplace_of_id=$id  ";
            //echo $all_q;
            $data['all'] = $this->db->query($all_q)->row();
            $this->load->helper('html');
            $this->load->view('../views/header');
            $this->load->view('../views/ChithaEditEntry/step4edit', $data);
            $this->load->view('../views/footer');
        } else {

            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $dag_no = $this->session->userdata('dag_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $data = array(
                'inplace_of_id' => 1,
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'dag_no' => $dag_no,
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
                'rmk_type_hist_no' => $this->session->userdata('rmk_type_hist_no'),
            );
            $formdata = $this->input->post();

            unset($formdata['submit']);
            $final = array_merge($data, $formdata);

            //$this->db->insert('chitha_rmk_inplace_of',$final);
            if ($this->session->userdata('inplace') == null) {
                $this->session->set_userdata('inplace', array());
                $toPush = $this->session->userdata('inplace');
                $toPush[] = $final;
                $this->session->set_userdata(array('inplace' => $toPush));
            } else {
                $toPush = $this->session->userdata('inplace');
                $toPush[] = $final;
                $this->session->set_userdata(array('inplace' => $toPush));
            }
            redirect(base_url() . "index.php/chithaeditentry/step4list/");
        }
    }

    public function step4Delete($id) {
		  $db=  $this->session->userdata('db');
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $dag_no = $this->session->userdata('dag_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $ord_no = $this->session->userdata('ord_no');
            $cron = $this->session->userdata('ord_cron_no');
            $rmk_type_hist_no = $this->session->userdata('rmk_type_hist_no');
            $data = array(
                'inplace_of_id' => $id,
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'dag_no' => $dag_no,
                'ord_no' => $ord_no,
                'ord_cron_no' => $cron,
                'rmk_type_hist_no' => $rmk_type_hist_no
            );
            $this->db->where($data);
            $this->db->delete('chitha_rmk_inplace_of');
        }
    }

    public function step4() {
		  $db=  $this->session->userdata('db');
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $dag_no = $this->session->userdata('dag_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $data = array();
            $this->load->model('relation/relationmodel');
            $data['relation'] = $this->relationmodel->getRelations();
            $patta_types = $this->db->query("select type_code,patta_type from    patta_code")->result();
            $data['patta_types'] = $patta_types;
            $trans_code_query = "select * from    nature_trans_code";
            $data['trans_codes'] = $this->db->query($trans_code_query)->result();

            $this->load->helper('html');
            $this->load->view('../views/header');
            $this->load->view('../views/ChithaEditEntry/step4', $data);
            $this->load->view('../views/footer');
        } else {

            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $dag_no = $this->session->userdata('dag_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $data = array(
                'inplace_of_id' => 1,
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'dag_no' => $dag_no,
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
                'rmk_type_hist_no' => $this->session->userdata('rmk_type_hist_no'),
            );
            $formdata = $this->input->post();

            unset($formdata['submit']);
            $final = array_merge($data, $formdata);

            //$this->db->insert('chitha_rmk_inplace_of',$final);
            if ($this->session->userdata('inplace') == null) {
                $this->session->set_userdata('inplace', array());
                $toPush = $this->session->userdata('inplace');
                $toPush[] = $final;
                $this->session->set_userdata(array('inplace' => $toPush));
            } else {
                $toPush = $this->session->userdata('inplace');
                $toPush[] = $final;
                $this->session->set_userdata(array('inplace' => $toPush));
            }
            redirect(base_url() . "index.php/chithaeditentry/step4/");
        }
    }

    public function step5list() {
		  $db=  $this->session->userdata('db');
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $dag_no = $this->session->userdata('dag_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $ord_no = $this->session->userdata('ord_no');
            $cron = $this->session->userdata('ord_cron_no');
            $rmk_type_hist_no = $this->session->userdata('rmk_type_hist_no');
            $data = array();
            $this->load->model('relation/relationmodel');
            $data['relation'] = $this->relationmodel->getRelations();
            $patta_types = $this->db->query("select type_code,patta_type from    patta_code")->result();
            $data['patta_types'] = $patta_types;
            $trans_code_query = "select * from    nature_trans_code";
            $data['trans_codes'] = $this->db->query($trans_code_query)->result();
            $all_q = "select * from    chitha_rmk_onbehalf p where  p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                    . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    . " and p.lot_no='$lot_no' and p.dag_no='$dag_no' and ord_no='$ord_no' and "
                    . " rmk_type_hist_no='$rmk_type_hist_no'  ";
            $data['all'] = $this->db->query($all_q)->result();
            $this->load->helper('html');
            $this->load->view('../views/header');
            $this->load->view('../views/ChithaEditEntry/step5list', $data);
            $this->load->view('../views/footer');
        } else {

            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $dag_no = $this->session->userdata('dag_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $data = array(
                'inplace_of_id' => 1,
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'dag_no' => $dag_no,
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
                'rmk_type_hist_no' => $this->session->userdata('rmk_type_hist_no'),
            );
            $formdata = $this->input->post();

            unset($formdata['submit']);
            $final = array_merge($data, $formdata);

            //$this->db->insert('chitha_rmk_inplace_of',$final);
            if ($this->session->userdata('inplace') == null) {
                $this->session->set_userdata('inplace', array());
                $toPush = $this->session->userdata('inplace');
                $toPush[] = $final;
                $this->session->set_userdata(array('inplace' => $toPush));
            } else {
                $toPush = $this->session->userdata('inplace');
                $toPush[] = $final;
                $this->session->set_userdata(array('inplace' => $toPush));
            }
            redirect(base_url() . "index.php/chithaeditentry/step4/");
        }
    }

    public function step5Delete($id) {
		  $db=  $this->session->userdata('db');
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $dag_no = $this->session->userdata('dag_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $ord_no = $this->session->userdata('ord_no');
            $cron = $this->session->userdata('ord_cron_no');
            $rmk_type_hist_no = $this->session->userdata('rmk_type_hist_no');
            $data = array(
                'onbehalf_id' => $id,
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'dag_no' => $dag_no,
                'ord_no' => $ord_no,
                'rmk_type_hist_no' => $rmk_type_hist_no
            );
            $this->db->where($data);
            $this->db->delete('chitha_rmk_onbehalf');
        }
    }

    public function step5edit($id) {
		
		  $db=  $this->session->userdata('db');
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $dag_no = $this->session->userdata('dag_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $ord_no = $this->session->userdata('ord_no');
            $cron = $this->session->userdata('ord_cron_no');
            $rmk_type_hist_no = $this->session->userdata('rmk_type_hist_no');
            $data = array();
            $this->load->model('relation/relationmodel');
            $data['relation'] = $this->relationmodel->getRelations();
            $patta_types = $this->db->query("select type_code,patta_type from    patta_code")->result();
            $data['patta_types'] = $patta_types;
            $trans_code_query = "select * from    nature_trans_code";
            $data['trans_codes'] = $this->db->query($trans_code_query)->result();
            $all_q = "select * from    chitha_rmk_onbehalf p where  p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                    . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    . " and p.lot_no='$lot_no' and p.dag_no='$dag_no' and ord_no='$ord_no' and "
                    . " rmk_type_hist_no='$rmk_type_hist_no' and onbehalf_id=$id ";
            $data['all'] = $this->db->query($all_q)->row();
            $this->load->helper('html');
            $this->load->view('../views/header');
            $this->load->view('../views/ChithaEditEntry/step5edit', $data);
            $this->load->view('../views/footer');
        } else {

            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $dag_no = $this->session->userdata('dag_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $data = array(
                'onbehalf_id' => 1,
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'dag_no' => $dag_no,
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
                'rmk_type_hist_no' => $this->session->userdata('rmk_type_hist_no'),
            );
            $formdata = $this->input->post();

            unset($formdata['submit']);
            $final = array_merge($data, $formdata);

            if ($this->session->userdata('onbehalf') == null) {
                $this->session->set_userdata('onbehalf', array());
                $toPush = $this->session->userdata('onbehalf');
                $toPush[] = $final;
                $this->session->set_userdata(array('onbehalf' => $toPush));
            } else {
                $toPush = $this->session->userdata('onbehalf');
                $toPush[] = $final;
                $this->session->set_userdata(array('onbehalf' => $toPush));
            }
            //$this->db->insert('chitha_rmk_onbehalf',$final);
            redirect(base_url() . "index.php/chithaeditentry/step5list/");
        }
    }

    public function step5() {
		
		  $db=  $this->session->userdata('db');
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $dag_no = $this->session->userdata('dag_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $data = array();
            $this->load->model('relation/relationmodel');
            $data['relation'] = $this->relationmodel->getRelations();
            $patta_types = $this->db->query("select type_code,patta_type from    patta_code")->result();
            $data['patta_types'] = $patta_types;
            $trans_code_query = "select * from    nature_trans_code";
            $data['trans_codes'] = $this->db->query($trans_code_query)->result();

            $this->load->helper('html');
            $this->load->view('../views/header');
            $this->load->view('../views/ChithaEditEntry/step5', $data);
            $this->load->view('../views/footer');
        } else {

            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $dag_no = $this->session->userdata('dag_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $data = array(
                'onbehalf_id' => 1,
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'dag_no' => $dag_no,
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
                'rmk_type_hist_no' => $this->session->userdata('rmk_type_hist_no'),
            );
            $formdata = $this->input->post();

            unset($formdata['submit']);
            $final = array_merge($data, $formdata);

            if ($this->session->userdata('onbehalf') == null) {
                $this->session->set_userdata('onbehalf', array());
                $toPush = $this->session->userdata('onbehalf');
                $toPush[] = $final;
                $this->session->set_userdata(array('onbehalf' => $toPush));
            } else {
                $toPush = $this->session->userdata('onbehalf');
                $toPush[] = $final;
                $this->session->set_userdata(array('onbehalf' => $toPush));
            }
            //$this->db->insert('chitha_rmk_onbehalf',$final);
            redirect(base_url() . "index.php/chithaeditentry/step5/");
        }
    }

    public function step5newsave() {
		
		  $db=  $this->session->userdata('db');
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {


            $this->load->helper('html');
            $this->load->view('../views/header');
            $this->load->view('../views/ChithaEditEntry/step5newsave');
            $this->load->view('../views/footer');
        } else {
            $main = $this->session->userdata('finalmainorder');
            $inplace = $this->session->userdata('inplace');
            $alongwith = $this->session->userdata('alongwith');
            $onbehalf = $this->session->userdata('onbehalf');
            $infav = $this->session->userdata('infav');
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $dag_no = $this->session->userdata('dag_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $main['ord_no'] = $main['case_no'];

            unset($main['next']);
            $this->db->insert('chitha_rmk_ordbasic', $main);
            $data = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'dag_no' => $dag_no,
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
                'rmk_type_code' => '01',
                'rmk_type_hist_no' => $main['rmk_type_hist_no']
            );
            $this->db->insert('chitha_rmk_gen', $data);
            $inplace_id = 1;

            foreach ($inplace as $in) {
                $in['inplace_of_id'] = $inplace_id;
                $this->db->insert('chitha_rmk_inplace_of', $in);
                $inplace_id++;
            }
            $alongwith_id = 1;
            foreach ($alongwith as $in) {
                $in['alongwith_id'] = $alongwith_id;
                $this->db->insert('chitha_rmk_alongwith', $in);
                $alongwith_id++;
            }
            $onbehalf_id = 1;
            foreach ($onbehalf as $in) {
                $in['onbehalf_id'] = $onbehalf_id;
                $this->db->insert('chitha_rmk_onbehalf', $in);
                $onbehalf_id++;
            }
            $infavor_of_id = 1;
            foreach ($infav as $in) {
                $in['infavor_of_id'] = $infavor_of_id;
                $in['land_area_kr'] = 0;
                $this->db->insert('chitha_rmk_infavor_of', $in);
                $infavor_of_id = 1;
                $infavor_of_id++;
            }
            $this->session->set_flashdata("message", "Col 31 Order Added Successfully. Add Pattadars if not already added.");
            redirect(base_url() . "index.php/home/");
        }
    }

    public function step5editsave() {
		
		  $db=  $this->session->userdata('db');
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {


            $this->load->helper('html');
            $this->load->view('../views/header');
            $this->load->view('../views/ChithaEditEntry/step5newsave');
            $this->load->view('../views/footer');
        } else {
            $main = $this->session->userdata('finalmainorder');
            $inplace = $this->session->userdata('inplace');
            $alongwith = $this->session->userdata('alongwith');
            $onbehalf = $this->session->userdata('onbehalf');
            $infav = $this->session->userdata('infav');
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $dag_no = $this->session->userdata('dag_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $data = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'dag_no' => $dag_no,
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
                'rmk_type_code' => '01',
                'rmk_type_hist_no' => $main['rmk_type_hist_no']
            );
            //$this->db->update('chitha_rmk_gen', $data);
            $whereCondition = $data;
            $whereCondition['ord_type_code'] = $main['ord_type_code'];
            unset($whereCondition['rmk_type_code']);
            $this->db->where($whereCondition);
            $this->db->update('chitha_rmk_ordbasic', $main);
            unset($whereCondition['ord_type_code']);

            foreach ($inplace as $in) {

                $whereCondition['inplace_of_id'] = $in['inplace_of_id'];
                $this->db->where($whereCondition);
                $updateArray = array(
                    'inplace_of_name' => $in['inplace_of_name'],
                    'inplace_of_guardian' => $in['inplace_of_guardian'],
                    'inplace_of_relation' => $in['inplace_of_relation'],
                );
                $this->db->update('chitha_rmk_inplace_of', $updateArray);
            }



            foreach ($alongwith as $in) {

                unset($whereCondition['inplace_of_id']);
                $whereCondition['alongwith_id'] = $in['alongwith_id'];
                $this->db->where($whereCondition);
                $updateArray = array(
                    'alongwith_name' => $in['alongwith_name'],
                    'alongwith_guardian' => $in['alongwith_guardian'],
                    'alongwith_rel_gur' => $in['alongwith_rel_gur'],
                );
                $this->db->update('chitha_rmk_alongwith', $updateArray);
            }


            foreach ($onbehalf as $in) {

                unset($whereCondition['alongwith_id']);
                $whereCondition['onbehalf_id'] = $in['onbehalf_id'];
                $this->db->where($whereCondition);
                $updateArray = array(
                    'onbehalf_name' => $in['onbehalf_name'],
                    'onbehalf_guardian' => $in['onbehalf_guardian'],
                    'onbehalf_rel_gur' => $in['onbehalf_rel_gur'],
                );
                $this->db->update('chitha_rmk_onbehalf', $updateArray);
            }

            foreach ($infav as $in) {

                $in['land_area_kr'] = 0;
                unset($whereCondition['onbehalf_id']);
                unset($whereCondition['alongwith_id']);
                $whereCondition['infavor_of_id'] = $in['infavor_of_id'];
                $this->db->where($whereCondition);

                $updateArray = array(
                    'infavor_of_name' => $in['infavor_of_name'],
                    'infavor_of_guardian' => $in['infavor_of_guardian'],
                    'infav_of_guar_relation' => $in['infav_of_guar_relation'],
                );
                $this->db->update('chitha_rmk_infavor_of', $updateArray);
            }
            echo "<p style='text-align:center;color:red'>SAVED<p>";
            echo "<p style='text-align:center;color:red'><a href=" . base_url() . "index.php/chithaeditentry/orderlist" . ">HOME</a><p>";
        }
    }

    public function col31orderdelete() {
		  $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $dag_no = $this->session->userdata('dag_no');
        $vill_townprt_code = $this->session->userdata('vill_code');

        $ord_no = $this->input->post('ord_no');
        $ord_cron = $this->input->post('ord_cron');
        $rmk_type_hist_no = $this->input->post('rmk_type_hist_no');
        $data = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code,
            'dag_no' => $dag_no,
            'rmk_type_hist_no' => $rmk_type_hist_no,
            'ord_no' => urldecode($ord_no),
            'ord_cron_no' => $ord_cron
        );
        $this->db->where($data);
        $this->db->delete('chitha_rmk_ordbasic');
        //redirect(base_url()."index.php/chithaeditentry/orderlist");
    }

    public function col8OrderDelete($dag_no, $col8_order_cron_no) {
		  $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');

        $vill_townprt_code = $this->session->userdata('vill_code');

        $data = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code,
            'dag_no' => $dag_no,
            'col8order_cron_no' => urldecode($col8_order_cron_no)
        );
        $this->db->where($data);
        $this->db->delete('chitha_col8_inplace');
        $this->db->where($data);
        $this->db->delete('chitha_col8_occup');
        $this->db->where($data);
        $this->db->delete('chitha_col8_order');
        redirect(base_url() . "index.php/chithaeditentry/orderlist");
    }

}
