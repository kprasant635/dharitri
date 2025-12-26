<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ChithaJamaCompare extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mutation/mutationmodel');
        $this->load->helper(array('form', 'url', 'Language'));

        $this->load->library('form_validation');
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


    public function manual() {
		  $db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
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
            $this->load->view('../views/compare/index', $district);
            $this->load->view('../views/footer');
        } else {
            $dist_code = $this->input->post('dist_code');
            $subdiv_code = $this->input->post('subdiv_code');
            $circle_code = $this->input->post('circle_code');
            $mouza_pargona_code = $this->input->post('mouza_code');
            $lot_no = $this->input->post('lot_no');
            $vill_townprtcode = $this->input->post('vill_code');
            $location = array(
                'dist_code_ses' => $dist_code, 'subdiv_code_ses' => $subdiv_code,
                'cir_code_ses' => $circle_code, 'mouza_pargona_code_ses' => $mouza_pargona_code,
                'lot_no_ses' => $lot_no, 'vill_code_ses' => $vill_townprtcode
            );
            $this->session->set_userdata($location);
            redirect(base_url() . "index.php/ChithaJamaCompare/pattano");
        }
    }

    public function startAllCompare() {
		  $db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
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
            $patta_types = $this->db->query("select type_code,patta_type from    patta_code order by type_code")->result();
            $district['patta_types'] = $patta_types;
            $this->load->view('../views/compare/index1', $district);
            $this->load->view('../views/footer');
        } else {
            $dist_code = $this->input->post('dist_code');
            $subdiv_code = $this->input->post('subdiv_code');
            $circle_code = $this->input->post('circle_code');
            $mouza_pargona_code = $this->input->post('mouza_code');
            $lot_no = $this->input->post('lot_no');
            $vill_townprtcode = $this->input->post('vill_code');
            $patta_type_code = $this->input->post('patta_type_code');
            $location = array(
                'dist_code_ses' => $dist_code, 'subdiv_code_ses' => $subdiv_code,
                'cir_code_ses' => $circle_code, 'mouza_pargona_code_ses' => $mouza_pargona_code,
                'lot_no_ses' => $lot_no, 'vill_code_ses' => $vill_townprtcode,
                'patta_type_code' => $patta_type_code
            );
            $this->session->set_userdata($location);
            redirect(base_url() . "index.php/ChithaJamaCompare/compareall");
        }
    }

    public function pattano() {
		  $db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $dist_code = $this->session->userdata('dist_code_ses');
            $subdiv_code = $this->session->userdata('subdiv_code_ses');
            $cir_code = $this->session->userdata('cir_code_ses');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code_ses');
            $lot_no = $this->session->userdata('lot_no_ses');
            $vill_townprt_code = $this->session->userdata('vill_code_ses');
            $data['d'] = $dist_code;
            $data['s'] = $subdiv_code;
            $data['c'] = $cir_code;
            $data['m'] = $mouza_pargona_code;
            $data['l'] = $lot_no;
            $data['v'] = $vill_townprt_code;
            $patta_types = $this->db->query("select type_code,patta_type from    patta_code")->result();
            $data['patta_types'] = $patta_types;
            $this->load->helper('html');
            $this->load->view('../views/header');
            $this->load->view('../views/compare/pattalist', $data);
            $this->load->view('../views/footer');
        } else {
            $patta_no = trim($this->input->post('patta_no'));
            $patta_type = $this->input->post('patta_type_code');
            $this->session->set_userdata(array('patta_no' => $patta_no, 'patta_type_code' => $patta_type));
            redirect(base_url() . "index.php/ChithaJamaCompare/compare/$patta_no/$patta_type");
        }
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
                'dist_code_ses' => $dist_code, 'subdiv_code_ses' => $subdiv_code,
                'cir_code_ses' => $circle_code, 'mouza_pargona_code_ses' => $mouza_pargona_code,
                'lot_no_ses' => $lot_no, 'vill_code_ses' => $vill_townprtcode
            );
            $this->session->set_userdata($location);
            redirect(base_url() . "index.php/ChithaJamaCompare/pattalist");
        } else {
            $this->load->helper('html');
            $this->load->view('../views/header');
            $this->load->view('../views/common/bar');
            $data = $this->mutationmodel->getDistricts();
            $dist_code = $this->session->userdata('dist_code_ses');
            $subdiv_code = $this->session->userdata('subdiv_code_ses');
            $cir_code = $this->session->userdata('cir_code_ses');
            $mouzas = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);
            $district['d'] = $dist_code;
            $district['s'] = $subdiv_code;
            $district['c'] = $cir_code;
            $district['mouzas'] = $mouzas;
            ////var_dump($this->session->all_userdata());
            //$this->load->view('menu/menu4');
            $this->load->view('../views/compare/index', $district);
            $this->load->view('../views/footer');
        }
    }

    public function pattalist() {
		  $db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $dist_code = $this->session->userdata('dist_code_ses');
            $subdiv_code = $this->session->userdata('subdiv_code_ses');
            $cir_code = $this->session->userdata('cir_code_ses');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code_ses');
            $lot_no = $this->session->userdata('lot_no_ses');
            $vill_townprt_code = $this->session->userdata('vill_code_ses');
            $data['d'] = $dist_code;
            $data['s'] = $subdiv_code;
            $data['c'] = $cir_code;
            $data['m'] = $mouza_pargona_code;
            $data['l'] = $lot_no;
            $data['v'] = $vill_townprt_code;
            $patta_types = $this->db->query("select type_code,patta_type from    patta_code")->result();
            $data['patta_types'] = $patta_types;
            $this->load->helper('html');
            $this->load->view('../views/header');
            $this->load->view('../views/compare/pattalist', $data);
            $this->load->view('../views/footer');
        } else {
            $patta_no = trim($this->input->post('patta_no'));
            $patta_type = $this->input->post('patta_type_code');
            $this->session->set_userdata(array('patta_no' => $patta_no, 'patta_type_code' => $patta_type));
            redirect(base_url() . "index.php/ChithaJamaCompare/compare/$patta_no/$patta_type");
        }
    }

    public function compare($patta_no) {
        $this->dbswitch();
        // var_dump($this->session->all_userdata());
		//$db=  $this->session->userdata('db');
        $revert = array('%21'=>'!', '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')');
        //$patta_no = strtr(rawurldecode($patta_no), $revert);
		//var_dump($this->session->all_userdata());
		$patta_no=$this->session->userdata('patta_no');
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $patta_type_code = $this->session->userdata('patta_type');
            $data['dist_code'] = $dist_code;
            $data['subdiv_code'] = $subdiv_code;
            $data['circle_code'] = $cir_code;
            $data['mouza_code'] = $mouza_pargona_code;
            $data['lot_no'] = $lot_no;
            $data['vill_code'] = $vill_townprt_code;
            $data['patta_no'] = trim($patta_no);
            $data['patta_type'] = $patta_type_code;

            //echo $patta_no = pg_escape_string($patta_no);
            $queryJP = "select * from    jama_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and"
                    . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    . " and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no' and patta_type_code='$patta_type_code' order by cast(pdar_id as int)";
            //echo $queryJP;
            $jamaPattadars = $this->db->query($queryJP)->result();
            //var_dump($jamaPattadars);
            $queryCP = "select * from    chitha_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no' and patta_type_code='$patta_type_code'";

            $chitha_pattadars = $this->db->query($queryCP)->result();

            $data['jamaPattadars'] = $jamaPattadars;
            $data['chitha_pattadars'] = $chitha_pattadars;

            $queryj = "select count(*) as c from    jama_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no'  and patta_type_code='$patta_type_code'
             ";

            $jamaCount = $this->db->query($queryj)->row()->c;

            $queryc = "select count(*) as c from    chitha_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no'  and patta_type_code='$patta_type_code'
             ";

            $chithaCount = $this->db->query($queryc)->row()->c;
            $data['jcount'] = $jamaCount;
            $data['ccount'] = $chithaCount;

            $queryj = "select pdar_id as jpid,pdar_name as jpname from    jama_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no'  and patta_type_code='$patta_type_code' order by cast(pdar_id as int)";

            $queryc = "select pdar_id as cpid,pdar_name as cpname from    chitha_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no'  and patta_type_code='$patta_type_code' order by pdar_id";

            $compareDataJ = $this->db->query($queryj)->result();
            $compareDataC = $this->db->query($queryc)->result();
            
            $data['is_jama_updated'] = $this->db->query("select count(*) as status from    chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    . "mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' and patta_type_code='$patta_type_code' and TRIM(patta_no)='$patta_no'"
                    . " and jama_yn is null")->row()->status;

            $data['comparesj'] = $compareDataJ;
            $data['comparesc'] = $compareDataC;
            //var_dump($data);
            // $this->load->view('../views/header');
            // $this->load->view('../views/compare/compareeditprocess', $data);
            // $this->load->view('../views/footer');
			$data['_view'] = 'compare/compareeditprocess';
			$this->load->view('layouts/main',$data);
        } else {
            $jamas = $this->input->post('pattadar');
            $dist_code = $this->session->userdata('dist_code_ses');
            $subdiv_code = $this->session->userdata('subdiv_code_ses');
            $cir_code = $this->session->userdata('cir_code_ses');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code_ses');
            $lot_no = $this->session->userdata('lot_no_ses');
            $vill_townprt_code = $this->session->userdata('vill_code_ses');
            $patta_type_code = $this->session->userdata('patta_type_code');
            foreach ($jamas as $key => $value) {

                if (isset($value['jama'])) {
                    $pdar_id = trim($value['jama']['pdar_id']);
                    $pdar_name = trim($value['jama']['new_pdar_name']);
                    $new_pdar_id = trim($value['jama']['new_pdar_id']);
                    $queryJama = "update jama_pattadar  p set pdar_id='$new_pdar_id',pdar_name='$pdar_name' where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and"
                            . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                            . " and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no'  and patta_type_code='$patta_type_code' and pdar_id='$pdar_id'";

                    $this->db->query($queryJama);
                }
                if (isset($value['chitha'])) {
                    $pdar_id = trim($value['chitha']['pdar_id']);
                    $pdar_name = trim($value['chitha']['new_pdar_name']);
                    $new_pdar_id = trim($value['chitha']['new_pdar_id']);

                    // $queryChitha = "update chitha_pattadar p set pdar_id='$new_pdar_id',pdar_name='$pdar_name' where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and"
                    //         . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    //         . " and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no'  and patta_type_code='$patta_type_code' and pdar_id='$pdar_id'";
                    // $this->db->query($queryChitha);
                    $table = 'chitha_pattadar';

                    $params = [
                        'pdar_id'   => $new_pdar_id,
                        'pdar_name' => $pdar_name,
                    ];

                    $where = [
                        'dist_code'          => $dist_code,
                        'subdiv_code'        => $subdiv_code,
                        'cir_code'           => $cir_code,
                        'mouza_pargona_code' => $mouza_pargona_code,
                        'vill_townprt_code'  => $vill_townprt_code,
                        'lot_no'             => $lot_no,
                        'patta_no'           => trim($patta_no), // since the SQL uses TRIM
                        'patta_type_code'    => $patta_type_code,
                        'pdar_id'            => $pdar_id,
                    ];

                    $result = $this->Chitha_basic_model->update_table($table, $params, $where);


                    
                    // $queryChitha = "update chitha_dag_pattadar p set pdar_id='$new_pdar_id' where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and"
                    //         . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    //         . " and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no'  and patta_type_code='$patta_type_code' and pdar_id='$pdar_id'";



                    // $this->db->query($queryChitha);
                    $table = 'chitha_dag_pattadar';

                    $params = [
                        'pdar_id' => $new_pdar_id,
                    ];

                    $where = [
                        'dist_code'          => $dist_code,
                        'subdiv_code'        => $subdiv_code,
                        'cir_code'           => $cir_code,
                        'mouza_pargona_code' => $mouza_pargona_code,
                        'vill_townprt_code'  => $vill_townprt_code,
                        'lot_no'             => $lot_no,
                        'patta_no'           => trim($patta_no),
                        'patta_type_code'    => $patta_type_code,
                        'pdar_id'            => $pdar_id,
                    ];

                    $this->Chitha_basic_model->update_table($table, $params, $where);

                }
            }
            redirect(base_url() . "index.php/ChithaJamaCompare/compare/$patta_no");
        }
    }

    public function compareedit(){
		  $db=  $this->session->userdata('db');
        //var_dump($this->session->all_userdata());
        $dist_code = $this->session->userdata('dist_code_ses');
        $subdiv_code = $this->session->userdata('subdiv_code_ses');
        $cir_code = $this->session->userdata('cir_code_ses');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code_ses');
        $lot_no = $this->session->userdata('lot_no_ses');
        $vill_townprt_code = $this->session->userdata('vill_code_ses');
        $patta_type_code = $this->session->userdata('patta_type_code');
        $data['dist_code'] = $dist_code;
        $data['subdiv_code'] = $subdiv_code;
        $data['circle_code'] = $cir_code;
        $data['mouza_code'] = $mouza_pargona_code;
        $data['lot_no'] = $lot_no;
        $data['vill_code'] = $vill_townprt_code;
        $patta_no = $this->input->post('patta_no');
        $data['patta_no'] = $patta_no;
        $data['patta_type'] = $patta_type_code;
        
        $queryJP = "select * from    jama_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and"
                    . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    . " and p.lot_no='$lot_no' and TRIM(p.patta_no)=trim('$patta_no') and patta_type_code='$patta_type_code' order by cast(pdar_id as int)";
            
            
            $jamaPattadars = $this->db->query($queryJP)->result();
            
            
            $queryCP = "select * from    chitha_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' and p.lot_no='$lot_no' and trim(p.patta_no)=trim('$patta_no')"
                    . " and p.patta_type_code='$patta_type_code'";
            //echo $queryCP;
            $chitha_pattadars = $this->db->query($queryCP)->result();

            $data['jamaPattadars'] = $jamaPattadars;
            $data['chitha_pattadars'] = $chitha_pattadars;

            $queryj = "select count(*) as c from    jama_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no'  and patta_type_code='$patta_type_code'
             ";

            $jamaCount = $this->db->query($queryj)->row()->c;

            $queryc = "select count(*) as c from    chitha_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no'  and patta_type_code='$patta_type_code'
             ";

            $chithaCount = $this->db->query($queryc)->row()->c;
            $data['jcount'] = $jamaCount;
            $data['ccount'] = $chithaCount;

            $queryj = "select pdar_id as jpid,pdar_name as jpname from    jama_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no'  and patta_type_code='$patta_type_code' order by cast(pdar_id as int)";

            $queryc = "select p.pdar_id as cpid,pdar_name as cpname,dag_no from    chitha_pattadar p,chitha_dag_pattadar d where p.dist_code='$dist_code' and
            p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no'  and p.patta_type_code='$patta_type_code' 
            and p.dist_code=d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code=d.cir_code and d.mouza_pargona_code = p.mouza_pargona_code
            and p.lot_no=d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.pdar_id = d.pdar_id and TRIM(p.patta_no) = TRIM(d.patta_no) and
            p.patta_type_code = d.patta_type_code
            order by p.pdar_id";

            $compareDataJ = $this->db->query($queryj)->result();
            $compareDataC = $this->db->query($queryc)->result();

            $data['comparesj'] = $compareDataJ;
            $data['comparesc'] = $compareDataC;
            $this->load->view('../views/header');
            $this->load->view('../views/compare/compareedit', $data);
            $this->load->view('../views/footer');
        
    }
    public function compareEdit_test($patta_no) {
          $db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $dist_code = $this->session->userdata('dist_code_ses');
            $subdiv_code = $this->session->userdata('subdiv_code_ses');
            $cir_code = $this->session->userdata('cir_code_ses');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code_ses');
            $lot_no = $this->session->userdata('lot_no_ses');
            $vill_townprt_code = $this->session->userdata('vill_code_ses');
            $patta_type_code = $this->session->userdata('patta_type_code');
            $data['dist_code'] = $dist_code;
            $data['subdiv_code'] = $subdiv_code;
            $data['circle_code'] = $cir_code;
            $data['mouza_code'] = $mouza_pargona_code;
            $data['lot_no'] = $lot_no;
            $data['vill_code'] = $vill_townprt_code;
            $data['patta_no'] = $patta_no;
            $data['patta_type'] = $patta_type_code;

            $queryJP = "select * from    jama_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and"
                    . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    . " and p.lot_no='$lot_no' and TRIM(p.patta_no)=trim('$patta_no') and patta_type_code='$patta_type_code' order by cast(pdar_id as int)";
            
            
            $jamaPattadars = $this->db->query($queryJP)->result();
            
            
            $queryCP = "select * from    chitha_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' and p.lot_no='$lot_no' and trim(p.patta_no)=trim('$patta_number')"
                    . " and p.patta_type_code='$patta_type_code'";
            echo $queryCP;
            $chitha_pattadars = $this->db->query($queryCP)->result();

            $data['jamaPattadars'] = $jamaPattadars;
            $data['chitha_pattadars'] = $chitha_pattadars;

            $queryj = "select count(*) as c from    jama_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no'  and patta_type_code='$patta_type_code'
             ";

            $jamaCount = $this->db->query($queryj)->row()->c;

            $queryc = "select count(*) as c from    chitha_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no'  and patta_type_code='$patta_type_code'
             ";

            $chithaCount = $this->db->query($queryc)->row()->c;
            $data['jcount'] = $jamaCount;
            $data['ccount'] = $chithaCount;

            $queryj = "select pdar_id as jpid,pdar_name as jpname from    jama_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no'  and patta_type_code='$patta_type_code' order by cast(pdar_id as int)";

            $queryc = "select p.pdar_id as cpid,pdar_name as cpname,dag_no from    chitha_pattadar p,chitha_dag_pattadar d where p.dist_code='$dist_code' and
            p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no'  and p.patta_type_code='$patta_type_code' 
            and p.dist_code=d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code=d.cir_code and d.mouza_pargona_code = p.mouza_pargona_code
            and p.lot_no=d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.pdar_id = d.pdar_id and TRIM(p.patta_no) = TRIM(d.patta_no) and
            p.patta_type_code = d.patta_type_code
            order by p.pdar_id";

            $compareDataJ = $this->db->query($queryj)->result();
            $compareDataC = $this->db->query($queryc)->result();

            $data['comparesj'] = $compareDataJ;
            $data['comparesc'] = $compareDataC;
            $this->load->view('../views/header');
            $this->load->view('../views/compare/compareedit', $data);
            $this->load->view('../views/footer');
        } else {
            $jamas = $this->input->post('pattadar');
            $dist_code = $this->session->userdata('dist_code_ses');
            $subdiv_code = $this->session->userdata('subdiv_code_ses');
            $cir_code = $this->session->userdata('cir_code_ses');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code_ses');
            $lot_no = $this->session->userdata('lot_no_ses');
            $vill_townprt_code = $this->session->userdata('vill_code_ses');
            $patta_type_code = $this->session->userdata('patta_type_code');
            
            foreach ($jamas as $key => $value) {

                if (isset($value['jama'])) {
                    $pdar_id = trim($value['jama']['pdar_id']);
                    $pdar_name = trim($value['jama']['new_pdar_name']);
                    $new_pdar_id = trim($value['jama']['new_pdar_id']);
                    $queryJama = "update jama_pattadar  p set pdar_id='$new_pdar_id',pdar_name='$pdar_name' where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and"
                            . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                            . " and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no'  and patta_type_code='$patta_type_code' and pdar_id='$pdar_id'";

                    $this->db->query($queryJama);
                }
                if (isset($value['chitha'])) {
                    $pdar_id = trim($value['chitha']['pdar_id']);
                    $pdar_name = trim($value['chitha']['new_pdar_name']);
                    $new_pdar_id = trim($value['chitha']['new_pdar_id']);

                    // $queryChitha = "update chitha_pattadar p set pdar_id='$new_pdar_id',pdar_name='$pdar_name' where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and"
                    //         . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    //         . " and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no'  and patta_type_code='$patta_type_code' and pdar_id='$pdar_id'";
                    // $this->db->query($queryChitha);
                    $table = 'chitha_pattadar';

                    $params = [
                        'pdar_id'   => $new_pdar_id,
                        'pdar_name' => $pdar_name,
                    ];

                    $where = [
                        'dist_code'          => $dist_code,
                        'subdiv_code'        => $subdiv_code,
                        'cir_code'           => $cir_code,
                        'mouza_pargona_code' => $mouza_pargona_code,
                        'vill_townprt_code'  => $vill_townprt_code,
                        'lot_no'             => $lot_no,
                        'patta_no'           => trim($patta_no), // Because SQL used TRIM()
                        'patta_type_code'    => $patta_type_code,
                        'pdar_id'            => $pdar_id,
                    ];

                    // Call the model method
                    $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                    // $queryChitha = "update chitha_dag_pattadar p set pdar_id='$new_pdar_id' where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and"
                    //         . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    //         . " and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no'  and patta_type_code='$patta_type_code' and pdar_id='$pdar_id'";



                    // $this->db->query($queryChitha);
                    $table = 'chitha_dag_pattadar';

                    $params = [
                        'pdar_id' => $new_pdar_id,
                    ];

                    $where = [
                        'dist_code'          => $dist_code,
                        'subdiv_code'        => $subdiv_code,
                        'cir_code'           => $cir_code,
                        'mouza_pargona_code' => $mouza_pargona_code,
                        'vill_townprt_code'  => $vill_townprt_code,
                        'lot_no'             => $lot_no,
                        'patta_no'           => trim($patta_no),
                        'patta_type_code'    => $patta_type_code,
                        'pdar_id'            => $pdar_id,
                    ];

                    $this->Chitha_basic_model->update_table($table, $params, $where);

                }
            }
            redirect(base_url() . "index.php/ChithaJamaCompare/compareedit/$patta_no/$patta_type_code");
        }
    }

    public function compareAll() {
		  $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code_ses');
        $subdiv_code = $this->session->userdata('subdiv_code_ses');
        $cir_code = $this->session->userdata('cir_code_ses');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code_ses');
        $lot_no = $this->session->userdata('lot_no_ses');
        $vill_townprt_code = $this->session->userdata('vill_code_ses');
        $patta_type_code = $this->session->userdata('patta_type_code');
        $inconsistents = array();
        $patta_no = "select distinct patta_no,dist_code,subdiv_code,cir_code,mouza_pargona_code"
                . " ,lot_no,vill_townprt_code,patta_type_code from    chitha_basic p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code'"
                . " and p.cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and TRIM(p.patta_no)!='0' "
                . " and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and patta_type_code='$patta_type_code' order by patta_no ";

        $patta_nos = $this->db->query($patta_no)->result();

        foreach ($patta_nos as $j) {


            $queryJP = "select * from    jama_pattadar p where p.dist_code='$j->dist_code' and p.subdiv_code='$j->subdiv_code' and p.cir_code='$j->cir_code' and
            p.mouza_pargona_code='$j->mouza_pargona_code' and p.vill_townprt_code='$j->vill_townprt_code' and patta_type_code='$patta_type_code'
            and p.lot_no='$j->lot_no' and TRIM(p.patta_no)=trim('$j->patta_no') 
             ";
            
            $jamaPattadars = $this->db->query($queryJP)->result();

            $queryCP = "select * from    chitha_pattadar p where p.dist_code='$j->dist_code' and p.subdiv_code='$j->subdiv_code' and p.cir_code='$j->cir_code'
                and
            p.mouza_pargona_code='$j->mouza_pargona_code' and p.vill_townprt_code='$j->vill_townprt_code' and patta_type_code='$patta_type_code'
            and p.lot_no='$j->lot_no' and TRIM(p.patta_no)=trim('$j->patta_no') 
             ";

            $chitha_pattadars = $this->db->query($queryCP)->result();

            $data['jamaPattadars'] = $jamaPattadars;
            $data['chitha_pattadars'] = $chitha_pattadars;

            $queryj = "select count(*) as c from    jama_pattadar p where p.dist_code='$j->dist_code' and p.subdiv_code='$j->subdiv_code' and p.cir_code='$j->cir_code'
                and
            p.mouza_pargona_code='$j->mouza_pargona_code' and p.vill_townprt_code='$j->vill_townprt_code' and patta_type_code='$patta_type_code'
            and p.lot_no='$j->lot_no' and TRIM(p.patta_no)=trim('$j->patta_no') 
             ";

            $jamaCount = $this->db->query($queryj)->row()->c;

            $queryc = "select count(*) as c from    chitha_pattadar p where  p.dist_code='$j->dist_code' "
                    . "and p.subdiv_code='$j->subdiv_code' and p.cir_code='$j->cir_code' and patta_type_code='$patta_type_code'
                and
            p.mouza_pargona_code='$j->mouza_pargona_code' and p.vill_townprt_code='$j->vill_townprt_code' 
            and p.lot_no='$j->lot_no' and TRIM(p.patta_no)=trim('$j->patta_no') 
             ";
            $chithaCount = $this->db->query($queryc)->row()->c;
            if ($jamaCount != $chithaCount) {
                $inconsistents[] = array(
                    'patta_no' => trim($j->patta_no),
                    'jcount' => $jamaCount,
                    'ccount' => $chithaCount,
                    'dist' => $j->dist_code,
                    'sub' => $j->subdiv_code,
                    'cir' => $j->cir_code,
                    'mouza' => $j->mouza_pargona_code,
                    'lot' => $j->lot_no,
                    'village' => $j->vill_townprt_code,
                    'patta_type_code' => $j->patta_type_code
                );
            }
        }
        $data['values'] = $inconsistents;
        $this->load->view('../views/header');
        $this->load->view('../views/compare/compareall', $data);
        $this->load->view('../views/footer');
    }

}
