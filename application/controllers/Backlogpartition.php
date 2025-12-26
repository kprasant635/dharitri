<?php

class Backlogpartition extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mutation/mutationmodel');
        $this->load->model('patta/pattamodel');
        $this->load->library('form_validation');
        $this->load->model('basundhara/basundharamodel');
        $this->load->model('rtps/rtpsmodel');
        $this->load->model('AgriStackCaseHistory');
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
		  //$db=  $this->session->userdata('db');
             if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $mouza_code = $this->input->post('mouza_code');
            $lot_no = $this->input->post('lot_no');
            $vill_code = $this->input->post('vill_code');
            $dag_no = $this->input->post('dag_no');
            $patta_no = trim($this->input->post('patta_no'));
            $patta_type = $this->input->post('patta_type');
            $case_no = $this->input->post('case_no');
            $order_date = $this->input->post('order_date');
            $rev_p_bigha = $this->input->post('rev_p_bigha');
            $lm_code = $this->input->post('lm_code');
            $lmSign = $this->input->post('lmSign');
            $lm_date = $this->input->post('lm_date');
            $sk_code = $this->input->post('sk_code');
            $skSign = $this->input->post('skSign');
            $sk_date = $this->input->post('sk_date');
            $co_code = $this->input->post('co_code');
            $coSign = $this->input->post('coSign');
            $co_date = $this->input->post('co_date');
            $t_bigha = $this->input->post('t_bigha');
            $t_katha = $this->input->post('t_katha');
            $t_lessa = $this->input->post('t_lessa');
            $p_bigha = $this->input->post('p_bigha');
            $p_katha = $this->input->post('p_katha');
            $p_lessa = $this->input->post('p_lessa');
            $chitha_rmk_ordbasic = array(
                'mouza_pargona_code' => $mouza_code,
                'lot_no' => $lot_no,
                'vill_code' => $vill_code,
                'dag_no' => $dag_no,
                'ord_no' => $case_no . "/back",
                'ord_date' => $order_date,
                'lm_code' => $lm_code,
                'lm_sign_yn' => $lmSign,
                'lm_sign_date' => $lm_date,
                'sk_code' => $sk_code,
                'sk_sign_yn' => $skSign,
                'sk_sign_date' => $sk_date,
                'co_code' => $co_code,
                'co_sign_yn' => $coSign,
                'co_ord_date' => $co_date,
                'm_dag_area_b' => $p_bigha,
                'm_dag_area_k' => $p_katha,
                'm_dag_area_lc' => $p_lessa,
                'patta_no' => $patta_no,
                'patta_type' => $patta_type,
                'revenue' => $rev_p_bigha
            );
            $this->session->set_userdata($chitha_rmk_ordbasic);
            redirect(base_url() . "index.php/Backlogpartition/pattadardetails");
            // var_dump($chitha_rmk_ordbasic);
        } else {
            // $this->load->helper('html');
            // $this->load->view('../views/header');
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $dist_name = $this->utilityclass->getDistrictName($dist_code);
            $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
            $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
            $district['mouza'] = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);
            $district['datas'] = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'dist_name' => $dist_name,
                'sub_div_name' => $sub_div_name,
                'cir_name' => $cir_name
            );
            $query = "select lm_name,lm_code from    lm_code where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
            $district['lmname'] = $this->db->query($query)->result();
            $query = "select username,user_code from    users where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
                    . " user_desig_code='SK'";
            $district['skname'] = $this->db->query($query)->result();
            $query = "select username,user_code from    users where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
                    . " user_desig_code='CO'";
            $district['coname'] = $this->db->query($query)->result();
            $query = "select type_code,patta_type from    patta_code ";
            $district['pattatype'] = $this->db->query($query)->result();
            // $this->load->view('../views/backentrypartition/backentry', $district);
            // $this->load->view('../views/footer');

            $district['_view'] = 'backentrypartition/backentry';
            $this->load->view('layouts/main',$district);
        }
    }

    function pattadardetails() {
		//  $db=  $this->session->userdata('db');
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/backentrypartition/pattdar');
        // $this->load->view('../views/footer');
        //var_dump($this->session->all_userdata());
        if ($this->input->get('inc')) {
            if (!$this->session->userdata('start')) {
                $this->session->set_userdata(array('start' => 0));
            }
            $start = $this->session->userdata('start');
            $start++;
            $this->session->set_userdata(array('start' => $start));
        } else {
            
        }
        $dags = $this->session->userdata('dag_no');
        $in = array();
        $in[] = $dags;
        $pattadar_cron_no = 1;
        // var_dump($this->session->all_userdata());
        if ($this->input->get('cron_no') == null)
            $pattadar_cron_no = 1;
        else
            $pattadar_cron_no = $this->input->get('cron_no');
        $this->load->model('patta/PattaModel');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type = $this->session->userdata('patta_type');
        $data['mut_type'] = $this->session->userdata('mut_type');
        $size = 1;
        $data['dag'] = $in[$this->session->userdata('start')];
        $data['pattadars'] = $this->PattaModel->getPattadarFilteredForPartition()->result();
        $data['pattadar_cron_no'] = $pattadar_cron_no;
        $data['pattadar_next'] = $this->session->userdata('pattadar_next') ? true : false;
        if ($this->session->userdata('start') >= $size) {
            $data['dag'] = -1;
        } else {
            $data['dag'] = $in[$this->session->userdata('start')];
        }
        // $this->load->view('../views/header');
        // //$this->load->view('menu/menu4');
        // $this->load->view('../views/backentrypartition/pattadardetails', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'backentrypartition/pattadardetails';
        $this->load->view('layouts/main',$data);
    }

    public function savePattadarForPartition() {
		 // $db=  $this->session->userdata('db');
        $this->load->model('patta/pattamodel');
        $location = $this->utilityclass->getLocationFromSession();
        $case_no = $this->session->userdata('case_no');
        $dag_no = $this->session->userdata('dag_no');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type_code = $this->session->userdata('patta_type');
        // $petition_no = $this->session->userdata('petition_no');
        /* loop over post array to get data from    the form */
        foreach ($_POST as $k => $v) {
            $data[$k] = $v;
        }
        $dag = $this->session->userdata('dag_no');
        $cron_no = $data['pdar_cron_no'] + 1;
        $user_code = $this->user_code;
        $operation = 'E';
        $year = date('Y');
        $pdar_name = $this->pattamodel->getPattadarNameById($data['pdar_name'], $dag)->result();
        $data['pdar_id'] = $data['pdar_name'];
        $data['pdar_name'] = $pdar_name[0]->pdar_name;
        $other = array(
            'date_entry' => date('Y-m-d G:i:s'),
            'user_code' => $user_code,
            'operation' => $operation,
            'date_entry' => date('Y-m-d G:i:s'),
            'case_no' => $case_no,
            'patta_no' => $patta_no,
            'patta_type_code' => $patta_type_code,
            'petition_no' => $petition_no,
            'dag_no' => $dag_no,
            'year_no' => $year
        );
        $merged = array_merge($location, $data, $other);
        if (!$this->session->userdata('appdet')) {
            $this->session->set_userdata('appdet', array());
            $appdet = $this->session->userdata('appdet');
            $appdet[] = $merged;
            $this->session->set_userdata('appdet', $appdet);
            $this->session->set_userdata('pdaridarray', array());
            $pdararray = $this->session->userdata('pdaridarray');
            $pdararray[] = $data['pdar_id'];
            $this->session->set_userdata('pdaridarray', $pdararray);
        } else {
            $appdet = $this->session->userdata('appdet');
            $appdet[] = $merged;
            $this->session->set_userdata('appdet', $appdet);
            $pdararray = $this->session->userdata('pdaridarray');
            $pdararray[] = $data['pdar_id'];
            $this->session->set_userdata('pdaridarray', $pdararray);
        }

        //if ($this->db->insert('field_part_petitioner', $merged)) {
        $this->session->set_userdata(array('pattadar_next' => true));
        redirect(base_url() . "index.php/Backlogpartition/pattadardetails?cron_no=$cron_no");
        //}
    }

    function back_step_two() {
		  //$db=  $this->session->userdata('db');
        //if ($this->input->server('REQUEST_METHOD') == 'POST') {
        // $pdarid = $this->input->post('pdar_name');
        // $pdar_guardian = $this->input->post('pdar_guardian');
        // $pdar_rel_guar = $this->input->post('pdar_rel_guar');
        // $pdar_add1 = $this->input->post('pdar_add1');
        // $pdar_add2 = $this->input->post('pdar_add2');
        // $pattadar = array(
        // 'pdarid' => $pdarid,
        // 'pdar_guardian' => $pdar_guardian,
        // 'pdar_rel_guar' => $pdar_rel_guar,
        // 'pdar_add1' => $pdar_add1,
        // 'pdar_add2' => $pdar_add2
        // );
        // $this->session->set_userdata($pattadar);
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $sql = "Select dag_no from    chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
                . "and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no'";
        $dag_no = $data['oldDag'] = $this->db->query($sql)->result();
        $newDag = 0;
        foreach ($dag_no as $d) {
            $d = $d->dag_no;
            if ($newDag < $d) {
                $newDag = $d;
            }
        }
        $sql = "Select patta_no from    chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
                . "and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no'";
        $patta_no = $data['oldPatta'] = $this->db->query($sql)->result();
        $newpatta = 0;
        foreach ($patta_no as $p) {
            $p = trim($p->patta_no);
            $p = (int) ($p);
            if ($newpatta < $p) {
                $newpatta = $p;
                //echo "<br>";
            }
        }
        $data['dagpatta'] = array(
            'newdag' => $newDag + 1,
            'newpatta' => $newpatta + 1
        );
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/backentrypartition/newallotment', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'backentrypartition/newallotment';
        $this->load->view('layouts/main',$data);
        // }
    }

    function back_step_three() {
		 // $db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $newDag = $this->input->post('new_dag');
            $newpatta = trim($this->input->post('new_patta'));
            $pattaNo = trim($this->session->userdata('patta_no'));
            $pattaType = $this->session->userdata('patta_type');
            $dag_no = $this->session->userdata('dag_no');
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $lot_no = $this->session->userdata('lot_no');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $appplicant = $this->session->userdata('appdet');
            // $query = "select max(petition_no)+1 as num from    t_chitha_rmk_infavor_of";
            // $petition = $this->db->query($query)->row();
            $petition_num = $this->basundharamodel->genearteOfficePetitionNo();
            if ($petition_num == null) {
                $petition_num = 1;
            }
            foreach ($appplicant as $val) {
                $pdar_id = $val['pdar_id'];
                $infavor_of_id = $val['pdar_cron_no'];
                $infavor_of_name = $val['pdar_name'];
                $infavor_of_guardian = $val['pdar_guardian'];
                $infav_of_guar_relation = $val['pdar_rel_guar'];
                $infavor_of_add1 = $val['pdar_add1'];
                $infavor_of_add2 = $val['pdar_add2'];
                $insert = array(
                    'dist_code' => $this->session->userdata('dist_code'),
                    'subdiv_code' => $this->session->userdata('subdiv_code'),
                    'cir_code' => $this->session->userdata('cir_code'),
                    'mouza_pargona_code' => $this->session->userdata('mouza_pargona_code'),
                    'lot_no' => $this->session->userdata('lot_no'),
                    'vill_townprt_code' => $this->session->userdata('vill_code'),
                    'dag_no' => $this->session->userdata('dag_no'),
                    'year_no' => date('Y'),
                    'petition_no' => $petition_num,
                    'patta_type_code' => $this->session->userdata('patta_type'),
                    'patta_no' => trim($this->session->userdata('patta_no')),
                    'ord_no' => $this->session->userdata('ord_no'),
                    'ord_date' => $this->session->userdata('ord_date'),
                    'pdar_id' => $pdar_id,
                    'infavor_of_id' => $infavor_of_id,
                    'infavor_of_name' => $infavor_of_name,
                    'infavor_of_guardian' => $infavor_of_guardian,
                    'infav_of_guar_relation' => $infav_of_guar_relation,
                    'infavor_of_add1' => $infavor_of_add1,
                    'infavor_of_add2' => $infavor_of_add2,
                    'by_right_of' => '00',
                    'land_area_b' => $this->session->userdata('m_dag_area_b'),
                    'land_area_k' => $this->session->userdata('m_dag_area_k'),
                    'land_area_lc' => $this->session->userdata('m_dag_area_l'),
                    'land_area_g' => 0,
                    'land_area_kr' => 0,
                    'revenue' => $this->session->userdata('revenue'),
                    'reg_deal_no' => null,
                    'reg_date' => null,
                    'sub_reg_office' => null,
                    'new_dag_no' => $newDag,
                    'new_patta_no' => $newpatta,
                    'make_mdb' => 'Y',
                    'new_pattadar' => 'N',
                    'pdar_strike' => 'N',
                    'infavor_of_gender' => null,
                    'infavor_of_mother' => null,
                    'pdar_pan_no' => null,
                    'pdar_citizen_no' => null,
                    'pdar_aadharno' => null,
                    'pdar_mobile' => null,
                    'pdar_nrcno' => null
                );
                $this->db->insert('t_chitha_rmk_infavor_of', $insert);
                //var_dump($insert);
            }
            //	exit;
            //var_dump($petition);
            ///  var_dump($insert);

            $t_chitha_rmk_ordbasic = array(
                'dist_code' => $this->session->userdata('dist_code'),
                'subdiv_code' => $this->session->userdata('subdiv_code'),
                'cir_code' => $this->session->userdata('cir_code'),
                'mouza_pargona_code' => $this->session->userdata('mouza_pargona_code'),
                'lot_no' => $this->session->userdata('lot_no'),
                'vill_townprt_code' => $this->session->userdata('vill_code'),
                'dag_no' => $this->session->userdata('dag_no'),
                'year_no' => date('Y'),
                'petition_no' => $petition_num,
                'ord_no' => $this->session->userdata('ord_no'),
                'ord_date' => $this->session->userdata('ord_date'),
                'ord_type_code' => '04',
                'case_no' => $this->session->userdata('ord_no'),
                'ord_on_gl_type' => 'U',
                'ord_passby_sign_yn' => 'y',
                'ord_passby_desig' => $this->session->userdata('user_code'),
                'ord_ref_let_no' => null,
                'lm_code' => $this->session->userdata('lm_code'),
                'lm_sign_yn' => $this->session->userdata('lm_sign_yn'),
                'lm_sign_date' => $this->session->userdata('lm_sign_date'),
                'sk_code' => $this->session->userdata('sk_code'),
                'sk_sign_yn' => $this->session->userdata('sk_sign_yn'),
                'sk_sign_date' => $this->session->userdata('sk_sign_date'),
                'co_code' => $this->session->userdata('co_code'),
                'co_sign_yn' => $this->session->userdata('co_sign_yn'),
                'co_ord_date' => $this->session->userdata('co_ord_date'),
                'm_dag_area_b' => $this->session->userdata('m_dag_area_b'),
                'm_dag_area_k' => $this->session->userdata('m_dag_area_k'),
                'm_dag_area_lc' => $this->session->userdata('m_dag_area_lc'),
                'm_dag_area_g' => 0,
                'm_dag_area_kr' => 0,
                'area_left_b' => null,
                'area_left_k' => null,
                'area_left_lc' => null,
                'area_left_g' => null,
                'area_left_kr' => null,
                'wrt_order1' => null,
                'wrt_order2' => null,
                'wrt_order3' => null,
                'wrt_order4' => null,
                'wrt_order5' => null,
                'ord_impli_flag' => null,
                'ord_impli_date' => null,
                'iscorrected_inco' => null,
                'iscorrected_inco_date' => null,
                'iscorrected_rkg_record' => null,
                'iscorrected_rkg_date' => null,
                'isdataposted_torkg_db' => null,
                'isorder_cancelled' => null,
                'ifyes_reason1' => null,
                'ifyes_reason2' => null,
                'ifyes_reason3' => null,
                'make_mdb' => 'Y',
                'new_dag_no' => $newDag,
                'min_revenue' => $this->session->userdata('revenue'),
                'map_partition' => 'Y'
            );
            //var_dump($t_chitha_rmk_ordbasic);
            $this->db->insert('t_chitha_rmk_ordbasic', $t_chitha_rmk_ordbasic);
            redirect(base_url() . "index.php/utility/backentry_utilities");
            //exit;
        }
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/backentrypartition/Updatedata');
        // $this->load->view('../views/footer');

        $data['_view'] = 'backentrypartition/Updatedata';
        $this->load->view('layouts/main',$data);
    }

    function Col31entry() {
		  $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $dist_name = $this->utilityclass->getDistrictName($dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $district['mouza'] = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);
        $district['datas'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'dist_name' => $dist_name,
            'sub_div_name' => $sub_div_name,
            'cir_name' => $cir_name
        );
        $query = "select type_code,patta_type from    patta_code ";
        $district['pattatype'] = $this->db->query($query)->result();
        $this->form_validation->set_rules('dist_code', 'Required', 'required');
        $this->form_validation->set_rules('subdiv_code', 'Required', 'required');
        $this->form_validation->set_rules('circle_code', 'Required', 'required');
        $this->form_validation->set_rules('mouza_code', 'Mouza Name', 'required');
        $this->form_validation->set_rules('lot_no', 'Lot Number', 'required');
        $this->form_validation->set_rules('vill_code', 'Village Code', 'required');
        $this->form_validation->set_rules('patta_type', 'Patta Type', 'required');
        $this->form_validation->set_rules('patta_no', 'Patta Number', 'required');
        $this->form_validation->set_rules('dag_no', 'Dage Number', 'required');
        $this->form_validation->set_rules('case_no', 'Case Number', 'required');
        $this->form_validation->set_rules('order_date', 'Date', 'required');
        $this->form_validation->set_rules('rmk', 'Order', 'required');
        if ($this->form_validation->run() == FALSE) {
            // $this->load->helper('html');
            // $this->load->view('../views/header');
            // $this->load->view('../views/backentrypartition/col31order', $district);
            // $this->load->view('../views/footer');

            $district['_view'] = 'backentrypartition/col31order';
            $this->load->view('layouts/main',$district);
        } else {
            $insert = array(
                'dist_code' => $this->session->userdata('dist_code'),
                'subdiv_code' => $this->session->userdata('subdiv_code'),
                'cir_code' => $this->session->userdata('cir_code'),
                'mouza_pargona_code' => $this->input->post('mouza_code'),
                'lot_no' => $this->input->post('lot_no'),
                'vill_townprt_code' => $this->input->post('vill_code'),
                'patta_no' => $this->input->post('patta_no'),
                'patta_type_code' => $this->input->post('patta_type'),
                'dag_no' => $this->input->post('dag_no') / 100,
                'dag_no_int' => $this->input->post('dag_no'),
                'remark' => addslashes($this->input->post('rmk')),
                'category' => 2,
                'date_entry' => date('Y-m-d'),
                'user_code' => $this->session->userdata('user_code'),
            );
            $this->db->insert('backlog_orders', $insert);
            $q = $this->db->affected_rows();
            if ($q == 1) {
                $this->session->set_flashdata('message', 'Order Added Successfully !! Please Check in Chitha !!');
                redirect(base_url() . "index.php/utility/backentry_utilities");
            } else {
                $this->session->set_flashdata('message', 'Sorry !!! Error in Updating. Please Try Again  !!');
                redirect(base_url() . "index.php/utility/backentry_utilities");
            }
        }
    }

    function dagexist($d, $s, $c, $m, $l, $v, $nd) {
		  $db=  $this->session->userdata('db');
        $q = "Select count(*) as c from    chitha_basic where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and mouza_pargona_code='$m' and 
				lot_no='$l' and vill_townprt_code='$v' and dag_no='$nd' ";
        $data = $this->db->query($q)->row()->c;
        if ($data) {
            $dag = 1;
            $msg = 'Dag Number exist';
        } else {
            $dag = 0;
            $msg = 'Success';
        }
        $json = array(
            'exist' => $dag,
            'msg' => $msg
        );
        echo json_encode($json);
    }

    public function daglist($d, $s, $c, $m, $l, $v, $pp, $pno) {
		  $db=  $this->session->userdata('db');

        $pattano = $this->db->query("Select dag_no as dag from    chitha_basic where dist_code='$d' and subdiv_code = '$s' and cir_code='$c' and "
                . "mouza_pargona_code = '$m' and lot_no = '$l' and vill_townprt_code='$v' and "
                . "patta_type_code='$pp' and patta_no='$pno' "); //order by CAST(coalesce(patta_no, '0') AS varchar)");
        $data = $pattano->result();
        $json = array();
        foreach ($data as $object) {
            $json[] = array('dag' => trim($object->dag));
        }
        echo json_encode($json);
    }

    public function getLandArea($d, $s, $c, $m, $l, $v, $dag_no) {
		  $db=  $this->session->userdata('db');
        $data = $this->db->query("SElect * from    chitha_basic where trim(dag_no)='$dag_no' and  dist_code ='$d'  and "
                        . " subdiv_code='$s' and cir_code='$c' and mouza_pargona_code='$m' and "
                        . " vill_townprt_code='$v' and lot_no='$l' ")->result();
        echo json_encode($data);
    }

    function backlog_f_part() {
		 // $db=  $this->session->userdata('db');

        //var_dump($this->session->all_userdata());
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $dist_name = $this->utilityclass->getDistrictName($dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $mouza = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
        $lot = $this->utilityclass->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $district['vill'] = $this->mutationmodel->getVillageCodeJSON($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        $district['datas'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'dist_name' => $dist_name,
            'sub_div_name' => $sub_div_name,
            'cir_name' => $cir_name,
            'mouza_name' => $mouza,
            'mouza_code' => $mouza_pargona_code,
            'lot_no' => $lot,
            'lot_code' => $lot_no,
        );
        $query = "select lm_name,lm_code from    lm_code where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' ";
        $district['lmname'] = $this->db->query($query)->result();
        $query = "select username,user_code from    users where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
                . " user_desig_code='SK'";
        $district['skname'] = $this->db->query($query)->result();
        $query = "select username,user_code from    users where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
                . " user_desig_code='CO'";
        $district['coname'] = $this->db->query($query)->result();
        $query = "select type_code,patta_type from    patta_code where mutation='a' ";
        $district['pattatype'] = $this->db->query($query)->result();

        /////////////////
        $q = "select count(*) as c from    backlog_request where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and status='A'";
        $row = $this->db->query($q)->row()->c;
        if ($row == null) {
            redirect('/home');
        }
        ///validation///////////
        $this->form_validation->set_rules('vill_code', 'Village Code', 'trim|required|numeric');
        $this->form_validation->set_rules('dag_no', 'Old Dag No Required', 'trim|required|numeric');
        $this->form_validation->set_rules('rev_p_bigha', 'Enter Revenue', 'trim|required|numeric');
        $this->form_validation->set_rules('p_lessa', 'Land Area (Lessa)', 'trim|required|numeric');
        $this->form_validation->set_rules('p_katha', 'Land Area (Katha)', 'trim|required');
        $this->form_validation->set_rules('p_bigha', 'Land Area (Bigha)', 'trim|required');
        $this->form_validation->set_rules('co_date', 'Enter CO Sign Date', 'trim|required');
        $this->form_validation->set_rules('sk_date', 'Enter SK Sign Date', 'trim|required');
        $this->form_validation->set_rules('lm_date', 'Enter LM Sign Date', 'trim|required');
        $this->form_validation->set_rules('order_date', 'Enter Date of Order Passed', 'trim|required');
        $this->form_validation->set_rules('case_no', 'Enter Old Case Number', 'trim|required');
        $this->form_validation->set_rules('new_patta_no', 'Enter New Patta Number', 'trim|required|integer');
        $this->form_validation->set_rules('new_dag_no', 'Enter New Dag Number', 'trim|required|integer');
        $this->form_validation->set_rules('patta_no', 'Enter Old Patta Number', 'trim|required|integer');
        ///////////////////////
        if ($this->form_validation->run() == FALSE) {
            // $this->load->helper('html');
            // $this->load->view('../views/header');
            // $this->load->view('../views/backentrypartition/backlog_f_part', $district);
            // $this->load->view('../views/footer');

            $district['_view'] = 'backentrypartition/backlog_f_part';
            $this->load->view('layouts/main',$district);
        } else {
            //var_dump($_POST);
            $this->session->set_userdata('basic', $_POST);
            redirect('/Backlogpartition/pattadar');
        }
    }

    function pattadar() {
        $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata['basic']['vill_code'];
        $patta_type = $this->session->userdata['basic']['patta_type'];
        $new_patta_no = $this->session->userdata['basic']['new_patta_no'];
        $patta_no = $this->session->userdata['basic']['patta_no'];
        $old_dag = $this->session->userdata['basic']['dag_no'];

        ////////////////////////////
        $query = "Select pdar_id from    chitha_dag_pattadar where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and 
				lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$old_dag' and p_flag!='1' and patta_type_code='$patta_type' ";
        $q = "Select * from    chitha_pattadar where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and 
				lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_no='$patta_no' and pdar_id in ($query) and patta_type_code='$patta_type' ";
        $data['part'] = $this->db->query($q)->result();
        $q = "Select * from    jama_pattadar where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and 
				lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_no='$new_patta_no' and patta_type_code='$patta_type'  ";
        $data['oldpart'] = $this->db->query($q)->result();
        //var_dump($data);
        ////////////////////////////
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/backentrypartition/pattadar', $data);
        // $this->load->view('../views/footer');


        $data['_view'] = 'backentrypartition/pattadar';
        $this->load->view('layouts/main',$data);

        if ($_POST) {
            //var_dump($_POST);
            $pdar_count = $this->input->post('pdar_id');
            $pdar_name = $this->input->post('pdar_name');
            $pdar_father = $this->input->post('pdar_father');
            $pdar_guard_reln = $this->input->post('pdar_guard_reln');
            if ($pdar_count == null) {
                $this->session->set_flashdata('message', 'Select Pattadar Name !!');
                redirect('/Backlogpartition/pattadar');
            } else {
                //var_dump($pdar_count);
                foreach ($pdar_count as $k => $v) {
                    $pattdar[] = array(
                        'pdarid' => $k,
                        'name' => $pdar_name[$k],
                        'guard' => $pdar_father[$k],
                        'rel' => $pdar_guard_reln[$k],
                    );
                }
                $this->session->set_userdata('applicant', $pattdar);
                redirect('/Backlogpartition/FinalSave');
            }
        }
        //var_dump($this->session->all_userdata());
    }

    function FinalSave() {
		  // $db=  $this->session->userdata('db');
    //     $this->load->helper('html');
    //     $this->load->view('../views/header');
    //     $this->load->view('../views/backentrypartition/finalsave');
    //     $this->load->view('../views/footer');

        $data['_view'] = 'backentrypartition/finalsave';
        $this->load->view('layouts/main',$data);
    }

    function SaveLM() {
		  $db=  $this->session->userdata('db');
        //var_dump($this->session->all_userdata());
        $this->db->trans_begin();
        $user_code = $this->session->userdata('user_code');
        $basic = $this->session->userdata('basic');
        $applicant = $this->session->userdata('applicant');
        if ($basic) {
            //var_dump($basic);
            $year = date('Y', strtotime($basic['order_date']));
            ////////////////field partition 1
            if ($basic['type'] == 1) {
                //             $q = "SElect max(petition_no)+1 as p from    t_chitha_col8_order where dist_code='$basic[dist_code]' and subdiv_code='$basic[subdiv_code]' and cir_code='$basic[circle_code]' and mouza_pargona_code='$basic[mouza_code]' and lot_no='$basic[lot_no]' and 
            				// vill_townprt_code='$basic[vill_code]' and dag_no='$basic[dag_no]' and year_no='$year' ";
                //             $petition_no = $this->db->query($q)->row()->p;
                //             if ($petition_no == null) {
                //                 $petition = 1;
                //             } else {
                //                 $petition = $petition_no;
                //             }
               // $petition=$this->basundharamodel->genearteFieldPetitionNo();

                $seq_pet=year_no.'000';
                $petition=$seq_pet.$this->rtpsmodel->genearteFieldPetitionNo();
                //echo "dfgfdxg";
                $location = array(
                    'dist_code' => $basic['dist_code'],
                    'subdiv_code' => $basic['subdiv_code'],
                    'cir_code' => $basic['circle_code'],
                    'mouza_pargona_code' => $basic['mouza_code'],
                    'lot_no' => $basic['lot_no'],
                    'vill_townprt_code' => $basic['vill_code'],
                    'dag_no' => $basic['dag_no'],
                    'year_no' => $year,
                    'petition_no' => $petition,
                    'order_pass_yn' => 'y',
                    'order_type_code' => '02',
                    'nature_trans_code' => 0,
                    'lm_code' => $basic['lm_code'],
                    'lm_sign_yn' => $basic['lmSign'],
                    'lm_note_date' => $basic['lm_date'],
                    'co_code' => $basic['co_code'],
                    'co_sign_yn' => $basic['coSign'],
                    'co_ord_date' => $basic['co_date'],
                    'mut_land_area_b' => $basic['p_bigha'],
                    'mut_land_area_k' => $basic['p_katha'],
                    'mut_land_area_lc' => $basic['p_lessa'],
                    'mut_land_area_g' => 0,
                    'mut_land_area_kr' => 0,
                    'land_area_left_b' => $basic['t_bigha'],
                    'land_area_left_k' => $basic['t_katha'],
                    'land_area_left_lc' => $basic['t_lessa'],
                    'land_area_left_g' => 0,
                    'sk_code' => $basic['sk_code'],
                    'sk_sign_yn' => $basic['skSign'],
                    'sk_note_date' => $basic['sk_date'],
                    'case_no' => $basic['case_no'] . "-BL",
                    'date_of_order' => $basic['order_date'],
                    'min_revenue' => $basic['rev_p_bigha'],
                    'map_partition' => 'Y'
                );
                $this->db->insert('t_chitha_col8_order', $location);
                foreach ($applicant as $row) {
                    $pattadar = array(
                        'dist_code' => $basic['dist_code'],
                        'subdiv_code' => $basic['subdiv_code'],
                        'cir_code' => $basic['circle_code'],
                        'mouza_pargona_code' => $basic['mouza_code'],
                        'lot_no' => $basic['lot_no'],
                        'vill_townprt_code' => $basic['vill_code'],
                        'dag_no' => $basic['dag_no'],
                        'year_no' => $year,
                        'petition_no' => $petition,
                        'occupant_id' => $row['pdarid'],
                        'patta_type_code' => $basic['patta_type'],
                        'patta_no' => $basic['patta_no'],
                        'pdar_id' => $row['pdarid'],
                        'occupant_name' => $row['name'],
                        'occupant_fmh_name' => $row['guard'],
                        'occupant_fmh_flag' => $row['rel'],
                        'occupant_add3' => $this->session->userdata('user_code'),
                        'land_area_b' => 0,
                        'land_area_k' => 0,
                        'land_area_lc' => 0,
                        'land_area_g' => 0,
                        'land_area_kr' => 0,
                        'old_patta_no' => $basic['patta_no'],
                        'new_patta_no' => $basic['new_patta_no'],
                        'old_dag_no' => $basic['dag_no'],
                        'new_dag_no' => $basic['new_dag_no'],
                        'new_pattadar' => 'N'
                    );
                    $this->db->insert('t_chitha_col8_occup', $pattadar);
                }
            }
            ///////////// Office Partition 2
            else {
                //             $q = "Select max(petition_no)+1 as p from    t_chitha_rmk_ordbasic where dist_code='$basic[dist_code]' and subdiv_code='$basic[subdiv_code]' and cir_code='$basic[circle_code]' and mouza_pargona_code='$basic[mouza_code]' and lot_no='$basic[lot_no]' and 
            				// vill_townprt_code='$basic[vill_code]' and dag_no='$basic[dag_no]' and year_no='$year' ";
                //             $petition_no = $this->db->query($q)->row()->p;
                //             if ($petition_no == null) {
                //                 $petition = 1;
                //             } else {
                //                 $petition = $petition_no;
                //             }
                $petition =$this->basundharamodel->genearteOfficePetitionNo();
                foreach ($applicant as $row) {
                    $insert = array(
                        'dist_code' => $basic['dist_code'],
                        'subdiv_code' => $basic['subdiv_code'],
                        'cir_code' => $basic['circle_code'],
                        'mouza_pargona_code' => $basic['mouza_code'],
                        'lot_no' => $basic['lot_no'],
                        'vill_townprt_code' => $basic['vill_code'],
                        'dag_no' => $basic['dag_no'],
                        'year_no' => $year,
                        'petition_no' => $petition,
                        'patta_type_code' => $basic['patta_type'],
                        'patta_no' => $basic['patta_no'],
                        'ord_no' => $basic['case_no'] . "-BL",
                        'ord_date' => $basic['order_date'],
                        'pdar_id' => $row['pdarid'],
                        'infavor_of_id' => $row['pdarid'],
                        'infavor_of_name' => $row['name'],
                        'infavor_of_guardian' => $row['guard'],
                        'infav_of_guar_relation' => $row['rel'],
                        //'infavor_of_add1' => ,
                        //'infavor_of_add3' => ,
                        'by_right_of' => '00',
                        'land_area_b' => $basic['p_bigha'],
                        'land_area_k' => $basic['p_katha'],
                        'land_area_lc' => $basic['p_lessa'],
                        'land_area_g' => 0,
                        'land_area_kr' => 0,
                        'revenue' => $basic['rev_p_bigha'],
                        'new_dag_no' => $basic['new_dag_no'],
                        'new_patta_no' => $basic['new_patta_no'],
                        'make_mdb' => 'Y',
                        'new_pattadar' => 'N',
                    );
                    //var_dump($insert);
                    $this->db->insert('t_chitha_rmk_infavor_of', $insert);
                }
                $t_chitha_rmk_ordbasic = array(
                    'dist_code' => $basic['dist_code'],
                    'subdiv_code' => $basic['subdiv_code'],
                    'cir_code' => $basic['circle_code'],
                    'mouza_pargona_code' => $basic['mouza_code'],
                    'lot_no' => $basic['lot_no'],
                    'vill_townprt_code' => $basic['vill_code'],
                    'dag_no' => $basic['dag_no'],
                    'year_no' => $year,
                    'petition_no' => $petition,
                    'ord_no' => $basic['case_no'] . "-BL",
                    'ord_date' => $basic['order_date'],
                    'ord_type_code' => '04',
                    'case_no' => $basic['case_no'] . "-BL",
                    'ord_on_gl_type' => 'B',
                    'ord_passby_sign_yn' => 'y',
                    'ord_passby_desig' => $this->session->userdata('user_code'),
                    'ord_ref_let_no' => null,
                    'lm_code' => $basic['lm_code'],
                    'lm_sign_yn' => $basic['lmSign'],
                    'lm_sign_date' => $basic['lm_date'],
                    'co_code' => $basic['co_code'],
                    'co_sign_yn' => $basic['coSign'],
                    'co_ord_date' => $basic['co_date'],
                    'sk_code' => $basic['sk_code'],
                    'sk_sign_yn' => $basic['skSign'],
                    'sk_sign_date' => $basic['sk_date'],
                    'm_dag_area_b' => $basic['p_bigha'],
                    'm_dag_area_k' => $basic['p_katha'],
                    'm_dag_area_lc' => $basic['p_lessa'],
                    'area_left_b' => $basic['t_bigha'],
                    'area_left_k' => $basic['t_katha'],
                    'area_left_lc' => $basic['t_lessa'],
                    'm_dag_area_g' => 0,
                    'm_dag_area_kr' => 0,
                    'area_left_b' => null,
                    'area_left_k' => null,
                    'area_left_lc' => null,
                    'area_left_g' => null,
                    'area_left_kr' => null,
                    'wrt_order1' => null,
                    'wrt_order2' => null,
                    'wrt_order3' => null,
                    'wrt_order4' => null,
                    'wrt_order5' => null,
                    'ord_impli_flag' => null,
                    'ord_impli_date' => null,
                    'iscorrected_inco' => null,
                    'iscorrected_inco_date' => null,
                    'iscorrected_rkg_record' => null,
                    'iscorrected_rkg_date' => null,
                    'isdataposted_torkg_db' => null,
                    'isorder_cancelled' => null,
                    'ifyes_reason1' => null,
                    'ifyes_reason2' => null,
                    'ifyes_reason3' => null,
                    'make_mdb' => 'Y',
                    'new_dag_no' => $basic['new_dag_no'],
                    'min_revenue' => $basic['rev_p_bigha'],
                    'map_partition' => 'Y'
                );
                //var_dump($t_chitha_rmk_ordbasic);
                $this->db->insert('t_chitha_rmk_ordbasic', $t_chitha_rmk_ordbasic);
            }
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
                $this->session->set_flashdata('message', "Backlog Entry $basic[case_no] Successfully Submitted !!");
               redirect(base_url() . "index.php/utility/backentry_utilities");
            }
        } else {
           redirect(base_url() . "index.php/utility/backentry_utilities");
        }
    }

    function copending() {
		  $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $q = "Select * from    t_chitha_col8_order where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (iscorrected_inco is null or iscorrected_inco='') and case_no like '%-BL' ";
        $data['field'] = $this->db->query($q)->result();
        $q = "Select * from    t_chitha_rmk_ordbasic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (iscorrected_inco is null or iscorrected_inco='') and case_no like '%-BL' ";
        $data['office'] = $this->db->query($q)->result();
        //var_dump($data);
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/backentrypartition/copending', $data);
        // $this->load->view('../views/footer');

        
        $data['_view'] = 'backentrypartition/copending';
        $this->load->view('layouts/main',$data);

    }

    function viewcase() {
		 // $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $type = $this->input->get('type');
        $case = $this->input->get('case');
        $petition = $this->input->get('p');
        //////////field
        if ($type == 1) {
            $q = "Select * from    t_chitha_col8_order where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and 
			case_no='$case' and petition_no='$petition' ";
            $data['col8'] = $row = $this->db->query($q)->row();
            $q = "Select * from    t_chitha_col8_occup where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and 
			mouza_pargona_code='$row->mouza_pargona_code' and lot_no='$row->lot_no' and vill_townprt_code='$row->vill_townprt_code' and dag_no='$row->dag_no' and year_no='$row->year_no' and petition_no='$petition' ";
            $data['col8occ'] = $row = $this->db->query($q)->result();
            // $this->load->helper('html');
            // $this->load->view('../views/header');
            // $this->load->view('../views/backentrypartition/viewcase', $data);
            // $this->load->view('../views/footer');
            $data['_view'] = 'backentrypartition/viewcase';
            $this->load->view('layouts/main',$data);
        }
        /////////////office
        elseif ($type == 2) {
            $q = "Select * from    t_chitha_rmk_ordbasic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and 
			case_no='$case' and petition_no='$petition' ";
            $data['col8'] = $row = $this->db->query($q)->row();
            $q = "Select * from    t_chitha_rmk_infavor_of where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and 
			ord_no='$case' and petition_no='$petition' ";
            $data['col8occ'] = $row = $this->db->query($q)->result();
            // $this->load->helper('html');
            // $this->load->view('../views/header');
            // $this->load->view('../views/backentrypartition/viewocase', $data);
            // $this->load->view('../views/footer');

            $data['_view'] = 'backentrypartition/viewocase';
            $this->load->view('layouts/main',$data);
        }
    }

    function copassorder() {
		 // $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $type = $this->input->get('type');
        $case = $this->input->get('case');
        $petition = $this->input->get('p');
        $this->AgriStackCaseHistory->CreateLogFile($dist_code, $case);
        if ($type == 1) {
            $q = "Select * from    t_chitha_col8_order where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and 
			case_no='$case' and petition_no='$petition' ";
            $row = $this->db->query($q)->row();
            $q = "Select * from    t_chitha_col8_occup where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and 
			mouza_pargona_code='$row->mouza_pargona_code' and lot_no='$row->lot_no' and vill_townprt_code='$row->vill_townprt_code' and dag_no='$row->dag_no' and year_no='$row->year_no' and petition_no='$petition' ";
            $col8occ = $row = $this->db->query($q)->row();

        if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {

            $this->load->model('propChain/PropChainCommonModel');
            $block_status=$this->PropChainCommonModel->checkDagExistsInPropChain($row->dist_code,$row->subdiv_code,
            $row->cir_code,$row->mouza_pargona_code,$row->lot_no,$row->vill_townprt_code,$row->dag_no);

            if($block_status==true){

                $this->session->set_flashdata('message', "Backlog Entry cannot be passed for the given Dag as it is in Property chain!!");
                redirect(base_url() . "index.php/home");
                return;
            }

        }




            if ($row->dag_no == $col8occ->new_dag_no) {
                $ok = $this->autoUpdate_fulldag($row->dist_code, $row->subdiv_code, $row->cir_code, $row->mouza_pargona_code, $row->lot_no, $row->vill_townprt_code, $row->petition_no, $row->dag_no,$case);
            } else {
                $ok = $this->autoUpdate($row->dist_code, $row->subdiv_code, $row->cir_code, $row->mouza_pargona_code, $row->lot_no, $row->vill_townprt_code, $row->petition_no, $row->dag_no,$case);
            }
        } elseif ($type == 2) {
            $q = "Select * from    t_chitha_rmk_ordbasic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and 
			case_no='$case' and petition_no='$petition' ";
            $row = $this->db->query($q)->row();
            $ok = $this->autoUpdateOP($row->dist_code, $row->subdiv_code, $row->cir_code, $row->mouza_pargona_code, $row->lot_no, $row->vill_townprt_code, $row->petition_no, $row->dag_no, $row->case_no);
        }
    }

    ////////Field Full Dag Partition////////////
    public function autoUpdate_fulldag($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $petition_no, $dag_no,$case_no) {
        $db=  $this->session->userdata('db');
        $locationData = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'lot_no' => $lot_no,
            'vill_code' => $vill_code,
            'mouza_pargona_code' => $mouza_pargona_code,
        );

        $year_no = year_no;

        $col8order_cron_no = $this->db->query("select max(col8order_cron_no)+1 as cron_no from    chitha_col8_order where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                        . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                        . "vill_townprt_code='$vill_code' and dag_no='$dag_no'")->row()->cron_no;
        //echo "select max(col8order_cron_no)+1 as cron_no from    chitha_col8_order";

        if ($col8order_cron_no == null) {
            $col8order_cron_no = 1;
        }
        $t_order_data_query = "select * from    t_chitha_col8_order where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                . "vill_townprt_code='$vill_code' and petition_no=$petition_no and dag_no='$dag_no' and iscorrected_inco is null";
        //echo $t_order_data_query;

        $t_data_order = $this->db->query($t_order_data_query)->result();

        foreach ($t_data_order as $ord) {
            $data_order = array();
            foreach ($ord as $key => $value) {
                $data[$key] = $value;
            }
            //var_dump($data);
            $data['col8order_cron_no'] = $col8order_cron_no;
            $data['user_code'] = $ord->co_code;
            $data['co_code'] = $this->session->userdata('user_code');
            $data['date_entry'] = date('Y-m-d G:i:s');
            $data['operation'] = "B";
            unset($data['year_no']);
            unset($data['petition_no']);
            unset($data['iscorrected_inco']);
            unset($data['iscorrected_inco_date']);
            unset($data['isdataposted_torkg_db']);
            unset($data['iscorrected_rkg_record']);
            unset($data['iscorrected_rkg_date']);
            unset($data['order_passed']);
            unset($data['date_of_order']);
            unset($data['make_mdb']);
            unset($data['date_of_order']);
            unset($data['not_consistent']);
            $corrected = date('Y-m-d G:i:s');
            $dataNew = $data;
            //var_dump($data);
            $this->db->insert('chitha_col8_order', $data); //*************************
            $update_query = "update t_chitha_col8_order  set iscorrected_inco='Y',iscorrected_inco_date='$corrected' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                    . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                    . "vill_townprt_code='$vill_code' and petition_no=$petition_no and  dag_no='$dag_no' and iscorrected_inco is null";
            // $this->db->query($update_query); //************************
            $t_inplace_query = "select * from    t_chitha_col8_inplace where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                    . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                    . "vill_townprt_code='$vill_code' and dag_no='$dag_no' and iscorrected_inco is null";

            $t_inplace_data = $this->db->query($t_inplace_query)->result();
            //var_dump($t_inplace_data);

            $t_occup_query = "select * from    t_chitha_col8_occup where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                    . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                    . "vill_townprt_code='$vill_code' and petition_no=$petition_no and dag_no='$dag_no' "
                    . " and iscorrected_inco is null";
            //echo $t_occup_query;
            $t_occup_data = $this->db->query($t_occup_query)->result();
            //var_dump($t_occup_data);

            $chitha_basic_update = FALSE;
            foreach ($t_occup_data as $occ) {
                //var_dump($occ);
                // $sql = "update chitha_basic set jama_yn=null, patta_no = '$occ->new_patta_no', old_patta_no = '$occ->patta_no'"
                //         . " where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                //         . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                //         . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                //         . " and dag_no='$occ->dag_no' and TRIM(patta_no)=trim('$occ->patta_no') and"
                //         . " patta_type_code='$occ->patta_type_code' ";

                // $this->db->query($sql); //****************
                $table = 'chitha_basic';
                $params = [
                    'jama_yn'     => null,
                    'patta_no'    => $occ->new_patta_no,
                    'old_patta_no'=> $occ->patta_no,
                ];

                $where = [
                    'dist_code'          => $occ->dist_code,
                    'subdiv_code'        => $occ->subdiv_code,
                    'cir_code'           => $occ->cir_code,
                    'mouza_pargona_code' => $occ->mouza_pargona_code,
                    'lot_no'             => $occ->lot_no,
                    'vill_townprt_code'  => $occ->vill_townprt_code,
                    'dag_no'             => $occ->dag_no,
                    'patta_no'           => trim($occ->patta_no),
                    'patta_type_code'    => $occ->patta_type_code,
                ];

                $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                $this->db->trans_begin();
                $data = array();
                foreach ($occ as $key => $value) {
                    $data[$key] = $value;
                }

                unset($data['year_no']);
                unset($data['petition_no']);
                unset($data['iscorrected_inco']);
                unset($data['iscorrected_inco_date']);
                unset($data['isdataposted_torkg_db']);
                unset($data['iscorrected_rkg_record']);
                unset($data['iscorrected_rkg_date']);
                unset($data['order_passed']);
                unset($data['date_of_order']);
                unset($data['make_mdb']);
                unset($data['date_of_order']);
                unset($data['patta_type_code']);
                unset($data['patta_no']);
                unset($data['pdar_id']);
                unset($data['revenue']);
                unset($data['new_pattadar']);
                $data['col8order_cron_no'] = $col8order_cron_no;
                $data['user_code'] = $this->session->userdata('user_code');

                $data['date_entry'] = date('Y-m-d G:i:s');
                $data['operation'] = "B";
                $occupData = $data;
                //var_dump($data);
                $this->db->insert('chitha_col8_occup', $data); // ******************

                $dag_pattadar = array();
                $chitha_pattadar = array();

                $pdar_id = null;

                if ($ord->order_type_code == '02') {
                    echo $pdar_id = $this->db->query("select max(cast(pdar_id as int))+1 as pdar_id from    chitha_pattadar where dist_code='$dist_code' and "
                            . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and"
                            . " mouza_pargona_code='$mouza_pargona_code' and "
                            . " vill_townprt_code='$vill_code' and TRIM(patta_no)=trim('$occ->new_patta_no')  "
                            . " ")->row()->pdar_id;
                }
                
                if ($pdar_id == null) {
                    $pdar_id = 1;
                }
                $dag_pattadar['dist_code'] = $dist_code;
                $dag_pattadar['subdiv_code'] = $subdiv_code;
                $dag_pattadar['cir_code'] = $cir_code;
                $dag_pattadar['lot_no'] = $lot_no;
                $dag_pattadar['mouza_pargona_code'] = $mouza_pargona_code;
                $dag_pattadar['vill_townprt_code'] = $vill_code;
                if ($ord->order_type_code == '02') {
                    $dag_pattadar['dag_no '] = $occ->new_dag_no;
                } else {
                    $dag_pattadar['dag_no '] = $dag_no;
                }
                if (($occ->pdar_id) && (!($ord->order_type_code == '02'))) {
                    $dag_pattadar['pdar_id'] = $pdar_id;
                } else {
                    $dag_pattadar['pdar_id'] = $pdar_id;
                }
                if ($ord->order_type_code == '02') {
                    $dag_pattadar['patta_no'] = trim($occ->new_patta_no);
                    $chitha_pattadar['patta_no'] = trim($occ->new_patta_no);
                } else {
                    $dag_pattadar['patta_no'] = trim($occ->patta_no);
                    $chitha_pattadar['patta_no'] = trim($occ->patta_no);
                }
                $dag_pattadar['p_flag'] = '0';
                $dag_pattadar['patta_type_code'] = $occ->patta_type_code;
                $dag_pattadar['dag_por_b'] = $occ->land_area_b;
                $dag_pattadar['dag_por_k'] = $occ->land_area_k;
                $dag_pattadar['dag_por_lc'] = $occ->land_area_lc;
                $dag_pattadar['dag_por_g'] = $occ->land_area_g;
                $dag_pattadar['dag_por_kr'] = $occ->land_area_kr;

                $dag_pattadar['user_code'] = $this->session->userdata('user_code');
                ;
                $dag_pattadar['date_entry'] = date('Y-m-d G:i:s');
                $dag_pattadar['operation'] = "B";

                $chitha_pattadar['dist_code'] = $dist_code;
                $chitha_pattadar['subdiv_code'] = $subdiv_code;
                $chitha_pattadar['cir_code'] = $cir_code;
                $chitha_pattadar['lot_no'] = $lot_no;
                $chitha_pattadar['mouza_pargona_code'] = $mouza_pargona_code;
                $chitha_pattadar['vill_townprt_code'] = $vill_code;

                $chitha_pattadar['pdar_id'] = $pdar_id;
                $chitha_pattadar['new_pdar_name'] = $occ->new_pattadar;
                $chitha_pattadar['patta_type_code'] = $occ->patta_type_code;
                $chitha_pattadar['pdar_name'] = $occ->occupant_name;
                $chitha_pattadar['pdar_father'] = $occ->occupant_fmh_name;
                //$chitha_pattadar['pdar_add1'] = $occ->occupant_add1;
                //$chitha_pattadar['pdar_add2'] = $occ->occupant_add2;
                $chitha_pattadar['pdar_add3'] = null;
                $chitha_pattadar['pdar_name'] = $occ->occupant_name;
                $chitha_pattadar['pdar_name'] = $occ->occupant_name;
                $chitha_pattadar['pdar_name'] = $occ->occupant_name;
                $chitha_pattadar['pdar_guard_reln'] = $occ->occupant_fmh_flag;
                $chitha_pattadar['user_code'] = $this->session->userdata('user_code');
                ;
                $chitha_pattadar['date_entry'] = date('Y-m-d G:i:s');
                $chitha_pattadar['operation'] = "B";
                $chitha_pattadar['jama_yn'] = 'N';
                //var_dump($chitha_pattadar);
                // var_dump($dag_pattadar);
                $chitha_basic_query = "select land_class_code from    chitha_basic "
                        . "where dist_code='$dist_code' and subdiv_code='$subdiv_code' and"
                        . " cir_code='$cir_code' and lot_no='$lot_no' and"
                        . " mouza_pargona_code='$mouza_pargona_code' and TRIM(patta_no)=trim('$occ->new_patta_no') and"
                        . " patta_type_code='$occ->patta_type_code' and dag_no='$dag_no'";
                //echo($chitha_basic_query);
                $result = $this->db->query($chitha_basic_query)->row();
                //var_dump($ord);
                $chitha_basic = array();
                $chitha_basic['dist_code'] = $dist_code;
                $chitha_basic['subdiv_code'] = $subdiv_code;
                $chitha_basic['cir_code'] = $cir_code;
                $chitha_basic['mouza_pargona_code'] = $mouza_pargona_code;
                $chitha_basic['lot_no'] = $lot_no;
                $chitha_basic['vill_townprt_code'] = $vill_code;
                $chitha_basic['dag_area_b'] = $ord->mut_land_area_b;
                $chitha_basic['dag_area_k'] = $ord->mut_land_area_k;
                $chitha_basic['dag_area_lc'] = $ord->mut_land_area_lc;
                $chitha_basic['dag_area_g'] = $ord->mut_land_area_g;
                $chitha_basic['dag_area_kr'] = $ord->mut_land_area_kr;
                $chitha_basic['user_code'] = $this->session->userdata('user_code');
                ;
                $chitha_basic['date_entry'] = date('Y-m-d G:i:s');
                $chitha_basic['land_class_code'] = $result->land_class_code;

                //var_dump($chitha_basic);
                if ($ord->order_type_code == '02') {
                    $old_dag = $dag_no;

                    $chitha_basic['dag_no'] = $occ->new_dag_no;
                    $chitha_basic['dag_no_int'] = $occ->new_dag_no . '00';
                    $chitha_basic['old_dag_no '] = $dag_no;
                    $old_patta = trim($occ->patta_no);
                    $chitha_basic['patta_no'] = trim($occ->new_patta_no);
                    $q = "update chitha_col8_order set new_dag_no='$occ->new_dag_no' where "
                            . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                            . " mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and"
                            . " vill_townprt_code='$vill_code' and col8order_cron_no=$col8order_cron_no";
                    $this->db->query($q); //***********************
                } else {
                    $chitha_basic['dag_no'] = $dag_no;

                    $q = "select dag_no_int as dag_no_int from    chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'" .
                            " and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$occ->patta_type_code' and TRIM(patta_no)=trim('$occ->patta_no')";

                    $dag_no_int = $this->db->query($q)->row()->dag_no_int;

                    $chitha_basic['dag_no_int'] = $dag_no_int;
                    $chitha_basic['patta_no'] = trim($occ->patta_no);
                }
                $chitha_basic['patta_type_code'] = $occ->patta_type_code;

                $chitha_basic['operation'] = "B";
                //var_dump($chitha_basic);
                //var_dump($dag_pattadar);
                $corrected = date('Y-m-d G:i:s');
                if ((!$chitha_basic_update) && ($ord->order_type_code == '02')) {

                    $chitha_basic_update = TRUE;
                    // $update_for_old_jama = "Update chitha_basic set jama_yn=null where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                    //         . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                    //         . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                    //         . " and TRIM(patta_no)=trim('$occ->patta_no') and"
                    //         . " patta_type_code='$occ->patta_type_code' ";

                    // //echo $update_for_old_jama;
                    // $this->db->query($update_for_old_jama); //*******************

                    $table = 'chitha_basic';

                    $params = [
                        'jama_yn' => null,
                    ];

                    $where = [
                        'dist_code'          => $occ->dist_code,
                        'subdiv_code'        => $occ->subdiv_code,
                        'cir_code'           => $occ->cir_code,
                        'mouza_pargona_code' => $occ->mouza_pargona_code,
                        'lot_no'             => $occ->lot_no,
                        'vill_townprt_code'  => $occ->vill_townprt_code,
                        'patta_no'           => trim($occ->patta_no),
                        'patta_type_code'    => $occ->patta_type_code,
                    ];

                    $result = $this->Chitha_basic_model->update_table($table, $params, $where);


                    $sql = "select dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,dag_revenue from    chitha_basic where"
                            . "  dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                            . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                            . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                            . " and dag_no='$occ->dag_no' and TRIM(patta_no)=trim('$occ->new_patta_no') and"
                            . " patta_type_code='$occ->patta_type_code' ";
                    //echo $sql;
                    $data = $this->db->query($sql)->row();
                    $chitha_basic['dag_revenue'] = $ord->min_revenue * (($ord->mut_land_area_b * 100 + $ord->mut_land_area_k * 20 + $ord->mut_land_area_lc) / 100.0);
                    $chitha_basic['dag_local_tax'] = $chitha_basic['dag_revenue'] / 4.0;
                    //$this->db->insert('chitha_basic', $chitha_basic); //********************************* not required

                    $dataNew['dag_no'] = $chitha_basic['dag_no'];
                    //var_dump($dataNew);
                    //$this->db->insert('chitha_col8_order', $dataNew); //********************************* not required
                    //$occupData['dag_no'] = $chitha_basic['dag_no'];
                    //$occupData['old_dag_no'] = $old_dag;
                    //$occupData['old_patta_no'] = $old_patta;
                    //$occupData['new_dag_no'] = null;
                    //$occupData['new_patta_no'] = null;
        //                    /$this->db->insert('chitha_col8_occup', $occupData);
                    //var_dump($data);
                    $sourcelessa = $data->dag_area_b * 100 + $data->dag_area_k * 20 + $data->dag_area_lc;
                    $mutationlessa = $ord->mut_land_area_b * 100 + $ord->mut_land_area_k * 20 + $ord->mut_land_area_lc;
                    $sourcelessa;
                    $mutationlessa;
                    $remaining_lessa = $sourcelessa - $mutationlessa;

                    $left_b = floor($remaining_lessa / 100);
                    $left_k = floor(($remaining_lessa - $left_b * 100) / 20);
                    $left_lc = $remaining_lessa - $left_b * 100 - $left_k * 20;
                    $left_g = 0;
                    $left_kr = 0;
                    $d = date('Y-m-d G:i:s');

                    $dag_revenue_updates = $data->dag_revenue; //$ord->min_revenue; // * (($left_b * 100 + $left_k * 20 + $left_lc));
                    //$old_patta_no = $data->dag_revenue;
                    if ($dag_revenue_updates == null) {
                        $dag_revenue_updates = 0;
                    }
                    $dag_local_tax_update = $dag_revenue_updates / 4;
                    // $sql = "update chitha_basic set jama_yn=null,dag_revenue=$dag_revenue_updates,dag_local_tax=$dag_local_tax_update, "
                    //         . " dag_area_b='$ord->mut_land_area_b',dag_area_k='$ord->mut_land_area_k',dag_area_lc='$ord->mut_land_area_lc',"
                    //         . " dag_area_g=$left_g,dag_area_kr=$left_kr,date_entry='$d',operation='M' "
                    //         . " where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                    //         . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                    //         . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                    //         . " and dag_no='$occ->dag_no' and TRIM(patta_no)=trim('$occ->new_patta_no') and"
                    //         . " patta_type_code='$occ->patta_type_code' ";

                    // $this->db->query($sql); //*******************

                    $table = 'chitha_basic';

                    $params = [
                        'jama_yn'       => null,
                        'dag_revenue'   => $dag_revenue_updates,
                        'dag_local_tax' => $dag_local_tax_update,
                        'dag_area_b'    => $ord->mut_land_area_b,
                        'dag_area_k'    => $ord->mut_land_area_k,
                        'dag_area_lc'   => $ord->mut_land_area_lc,
                        'dag_area_g'    => $left_g,
                        'dag_area_kr'   => $left_kr,
                        'date_entry'    => $d,
                        'operation'     => 'M',
                    ];

                    $where = [
                        'dist_code'          => $occ->dist_code,
                        'subdiv_code'        => $occ->subdiv_code,
                        'cir_code'           => $occ->cir_code,
                        'mouza_pargona_code' => $occ->mouza_pargona_code,
                        'lot_no'             => $occ->lot_no,
                        'vill_townprt_code'  => $occ->vill_townprt_code,
                        'dag_no'             => $occ->dag_no,
                        'patta_no'           => trim($occ->new_patta_no),
                        'patta_type_code'    => $occ->patta_type_code,
                    ];

                    $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                }
                //$p_id = $occ->pdar_id; old quotes
                $p_id = $pdar_id;

                $q = "select count(*) as count from    chitha_dag_pattadar  where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                        . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                        . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                        . " and dag_no='$occ->dag_no' and TRIM(patta_no)=trim('$occ->patta_no') and"
                        . " patta_type_code='$occ->patta_type_code'"; // and pdar_id=$p_id";
                //echo $q;
                $cDagPattadarExists = $this->db->query($q)->row()->count;

                $q = "select count(*) as count from    chitha_pattadar  where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                        . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                        . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                        . " and TRIM(patta_no)=trim('$occ->new_patta_no') and"
                        . " patta_type_code='$occ->patta_type_code' and pdar_id=$p_id";
                //echo $q;
                $cPattadarExists = $this->db->query($q)->row()->count;

                $occ->new_pattadar;

                //update chitha_dag_pattadar
                // $update_pattadar = "Update chitha_dag_pattadar set patta_no='$occ->new_patta_no',pdar_id='$p_id', p_flag = null,jama_yn='n' where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                //         . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                //         . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                //         . " and dag_no='$occ->dag_no' and TRIM(patta_no)=trim('$occ->patta_no') and"
                //         . " patta_type_code='$occ->patta_type_code' and pdar_id='$occ->pdar_id' ";
                // //echo $update_pattadar;
                // $this->db->query($update_pattadar); //*******************
                $table = 'chitha_dag_pattadar';

                $params = [
                    'patta_no' => $occ->new_patta_no,
                    'pdar_id'  => $p_id,
                    'p_flag'   => null,
                    'jama_yn'  => 'n',
                ];

                $where = [
                    'dist_code'          => $occ->dist_code,
                    'subdiv_code'        => $occ->subdiv_code,
                    'cir_code'           => $occ->cir_code,
                    'mouza_pargona_code' => $occ->mouza_pargona_code,
                    'lot_no'             => $occ->lot_no,
                    'vill_townprt_code'  => $occ->vill_townprt_code,
                    'dag_no'             => $occ->dag_no,
                    'patta_no'           => trim($occ->patta_no),
                    'patta_type_code'    => $occ->patta_type_code,
                    'pdar_id'            => $occ->pdar_id,
                ];

                $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                //insert in chitha_pattadar

                if ($cPattadarExists == 0) {
                    // var_dump ($chitha_pattadar);
                    // $this->db->insert('chitha_pattadar', $chitha_pattadar); // ********************
                    $this->Chitha_basic_model->insert_table('chitha_pattadar',$chitha_pattadar);
                }
                // exit;
                $today = date('Y-m-d');
                $t_occup_query = "update t_chitha_col8_occup set iscorrected_inco='Y',iscorrected_inco_date='$corrected',order_passed='Y' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                . "vill_townprt_code='$vill_code' and petition_no=$petition_no and dag_no='$dag_no' ";
                $this->db->query($t_occup_query); // ********************
            }

            //            if ($ord->order_type_code == '02') {
            //                foreach ($t_occup_data as $occup) {
            //                    $sql = "update chitha_dag_pattadar set p_flag='o' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
            //                            . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
            //                            . "vill_townprt_code='$vill_code' and dag_no='$dag_no' and pdar_id=$occup->pdar_id";
            //                    $this->db->query($sql); // ********************
            //                }
            //            }

            if (($ord->order_type_code == '01') || ($ord->order_type_code == '02')) {
                foreach ($t_inplace_data as $inplace) {
                    $data = array();

                    foreach ($inplace as $key => $value) {
                        $data[$key] = $value;
                    }
                    unset($data['occupant_id']);
                    unset($data['year_no']);
                    unset($data['petition_no']);
                    unset($data['occupant_name']);
                    unset($data['occupant_fmh_name']);
                    unset($data['occupant_fmh_flag']);
                    unset($data['occupant_add1']);
                    unset($data['occupant_add2']);
                    unset($data['occupant_add3']);
                    unset($data['old_patta_no']);
                    unset($data['new_patta_no']);
                    unset($data['old_dag_no']);
                    unset($data['patta_type_code']);
                    unset($data['patta_no']);
                    unset($data['pdar_id']);
                    unset($data['iscorrected_inco']);
                    unset($data['iscorrected_inco_date']);
                    unset($data['isdataposted_torkg_db']);
                    unset($data['iscorrected_rkg_record']);
                    unset($data['new_dag_no']);
                    unset($data['order_passed']);
                    unset($data['date_of_order']);
                    unset($data['make_mdb']);
                    unset($data['iscorrected_rkg_date']);
                    unset($data['revenue']);
                    unset($data['new_pattadar']);
                    unset($data['hus_wife']);
                    unset($data['revenue']);


                    if ($data['fmute_strike_out'] == '1') {
                        $data['inplaceof_alongwith'] = 'i';
                    } else {
                        $data['inplaceof_alongwith'] = 'a';
                    }
                    unset($data['fmute_strike_out']);
                    $data['col8order_cron_no'] = $col8order_cron_no;
                    $data['user_code'] = $this->session->userdata('user_code');
                    ;
                    $data['date_entry'] = date('Y-m-d G:i:s');
                    $data['operation'] = "B";
                    // var_dump($data);
                    $key = array(
                        'dist_code' => $data['dist_code'],
                        'subdiv_code' => $data['subdiv_code'],
                        'cir_code' => $data['cir_code'],
                        'mouza_pargona_code' => $data['mouza_pargona_code'],
                        'lot_no' => $data['lot_no'],
                        'vill_townprt_code' => $data['vill_townprt_code'],
                        'dag_no' => $data['dag_no'],
                        'col8order_cron_no' => $data['col8order_cron_no'],
                        'inplace_of_id' => $data['inplace_of_id'],
                    );

                    $queryCheck = "select count(*) as c from    chitha_col8_inplace where dist_code='$data[dist_code]' and subdiv_code='$data[subdiv_code]' and cir_code='$data[cir_code]' and "
                            . " mouza_pargona_code='$data[mouza_pargona_code]' and lot_no='$data[lot_no]' and vill_townprt_code='$data[vill_townprt_code]' and dag_no='$data[dag_no]' and col8order_cron_no='$data[col8order_cron_no]' and "
                            . " inplace_of_id='$data[inplace_of_id]' ";
                    $count = $this->db->query($queryCheck)->row()->c;
                    if ($count <= 0)
                    //var_dump($data);
                        $this->db->insert('chitha_col8_inplace', $data);

                    $p_flag = '0';
                    if ($inplace->fmute_strike_out == '1')
                        $p_flag = '1';

                    // $update_query = "update chitha_dag_pattadar  set p_flag='$p_flag',jama_yn='n' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                    //         . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                    //         . "vill_townprt_code='$vill_code' and dag_no='$dag_no' and pdar_id=$inplace->pdar_id";
                    //echo $update_query;
                    $table = 'chitha_dag_pattadar';

                    $params = [
                        'p_flag'  => $p_flag,
                        'jama_yn' => 'n',
                    ];

                    $where = [
                        'dist_code'          => $dist_code,
                        'subdiv_code'        => $subdiv_code,
                        'cir_code'           => $cir_code,
                        'lot_no'             => $lot_no,
                        'mouza_pargona_code' => $mouza_pargona_code,
                        'vill_townprt_code'  => $vill_code,
                        'dag_no'             => $dag_no,
                        'pdar_id'            => $inplace->pdar_id,
                    ];

                    $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                    $corrected = date('Y-m-d G:i:s');
                    $t_inplace_query = "update t_chitha_col8_inplace set iscorrected_inco='Y',iscorrected_inco_date='$corrected',order_passed='Y' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                            . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                            . "vill_townprt_code='$vill_code' and dag_no='$dag_no'";

                    // $this->db->query($update_query);
                    $this->db->query($t_inplace_query);
                    $update_query = "update t_chitha_col8_order  set iscorrected_inco='Y',iscorrected_inco_date='$corrected' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                            . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                            . "vill_townprt_code='$vill_code' and petition_no=$petition_no and  dag_no='$dag_no' and iscorrected_inco is null";
                    $this->db->query($update_query); //*******************
                    // $order_update_query = "update field_mut_basic set order_passed='Y' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                    // . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                    // . "vill_townprt_code='$vill_code' and petition_no=$petition_no";
                    // $this->db->query($order_update_query);
                }
            }
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            $this->AgriStackCaseHistory->CreateLog($dist_code,$case_no);
            $this->session->set_flashdata('message', 'Chitha Updated Successfully. Please Update Jambandi Now. Update Old Patta First then update New Patta');
            redirect(base_url() . "index.php/utility/backentry_utilities");
            return true;
        }
    }

    /////////Field Partition/////////////
    public function autoUpdate($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $petition_no, $dag_no,$case_no) {
        $db=  $this->session->userdata('db');
        $locationData = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'lot_no' => $lot_no,
            'vill_code' => $vill_code,
            'mouza_pargona_code' => $mouza_pargona_code,
        );

        $year_no = year_no;

        $col8order_cron_no = $this->db->query("select max(col8order_cron_no)+1 as cron_no from    chitha_col8_order where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                        . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                        . "vill_townprt_code='$vill_code' and dag_no='$dag_no'")->row()->cron_no;
        if ($col8order_cron_no == null) {
            $col8order_cron_no = 1;
        }
        $t_order_data_query = "select * from    t_chitha_col8_order where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                . "vill_townprt_code='$vill_code' and petition_no=$petition_no and dag_no='$dag_no' and iscorrected_inco is null";
        //echo $t_order_data_query;
        $t_data_order = $this->db->query($t_order_data_query)->result();
        //var_dump ($t_data_order);

        foreach ($t_data_order as $ord) {
            $data_order = array();
            foreach ($ord as $key => $value) {
                $data[$key] = $value;
            }
            $data['user_code'] = $ord->co_code;
            //exit;
            $data['col8order_cron_no'] = $col8order_cron_no;
            $data['co_code'] = $this->session->userdata('user_code');
            $data['date_entry'] = date('Y-m-d G:i:s');
            $data['operation'] = "B";
            unset($data['year_no']);
            unset($data['petition_no']);
            unset($data['iscorrected_inco']);
            unset($data['iscorrected_inco_date']);
            unset($data['isdataposted_torkg_db']);
            unset($data['iscorrected_rkg_record']);
            unset($data['iscorrected_rkg_date']);
            unset($data['order_passed']);
            unset($data['date_of_order']);
            unset($data['make_mdb']);
            unset($data['date_of_order']);
            unset($data['not_consistent']);
            $corrected = date('Y-m-d G:i:s');
            $dataNew = $data;
            //var_dump($data);
            //exit;
            $this->db->insert('chitha_col8_order', $data); //*******************
            $update_query = "update t_chitha_col8_order  set iscorrected_inco='Y',iscorrected_inco_date='$corrected' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                    . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                    . "vill_townprt_code='$vill_code' and petition_no=$petition_no and  dag_no='$dag_no' and iscorrected_inco is null";
            $this->db->query($update_query); //*******************

            $t_inplace_query = "select * from    t_chitha_col8_inplace where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                    . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                    . "vill_townprt_code='$vill_code' and dag_no='$dag_no' and iscorrected_inco is null";
            $t_inplace_data = $this->db->query($t_inplace_query)->result();
            //var_dump($t_inplace_data);

            $t_occup_query = "select * from    t_chitha_col8_occup where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                    . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                    . "vill_townprt_code='$vill_code' and petition_no=$petition_no and dag_no='$dag_no' "
                    . " and iscorrected_inco is null";
            $t_occup_data = $this->db->query($t_occup_query)->result();
            //var_dump($t_occup_data);

            $chitha_basic_update = FALSE;
            foreach ($t_occup_data as $occ) {
                // $sql = "update chitha_basic set jama_yn=null"
                //         . " where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                //         . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                //         . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                //         . " and dag_no='$occ->dag_no' and TRIM(patta_no)=trim('$occ->patta_no') and"
                //         . " patta_type_code='$occ->patta_type_code' ";

                // $this->db->query($sql); //*********************
                $table = 'chitha_basic';

                $params = [
                    'jama_yn' => null,
                ];

                $where = [
                    'dist_code'          => $occ->dist_code,
                    'subdiv_code'        => $occ->subdiv_code,
                    'cir_code'           => $occ->cir_code,
                    'mouza_pargona_code' => $occ->mouza_pargona_code,
                    'lot_no'             => $occ->lot_no,
                    'vill_townprt_code'  => $occ->vill_townprt_code,
                    'dag_no'             => $occ->dag_no,
                    'patta_no'           => trim($occ->patta_no),
                    'patta_type_code'    => $occ->patta_type_code,
                ];

                $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                $this->db->trans_begin();
                $data = array();
                foreach ($occ as $key => $value) {
                    $data[$key] = $value;
                }
                unset($data['year_no']);
                unset($data['petition_no']);
                unset($data['iscorrected_inco']);
                unset($data['iscorrected_inco_date']);
                unset($data['isdataposted_torkg_db']);
                unset($data['iscorrected_rkg_record']);
                unset($data['iscorrected_rkg_date']);
                unset($data['order_passed']);
                unset($data['date_of_order']);
                unset($data['make_mdb']);
                unset($data['date_of_order']);
                unset($data['patta_type_code']);
                unset($data['patta_no']);
                unset($data['pdar_id']);
                unset($data['revenue']);
                unset($data['new_pattadar']);
                unset($data['occupant_add3']);
                $data['col8order_cron_no'] = $col8order_cron_no;
                $data['user_code'] = $this->session->userdata('user_code');
                $data['date_entry'] = date('Y-m-d G:i:s');
                $data['operation'] = 'B';
                $occupData = $data;
                //var_dump($data);
                $this->db->insert('chitha_col8_occup', $data); //*******************

                $dag_pattadar = array();
                $chitha_pattadar = array();

                $pdar_id = $occ->pdar_id;


                if ($ord->order_type_code == '02') {
                    // for partition
                    $pdar_id = $this->db->query("select max(cast(pdar_id as int))+1 as pdar_id from    chitha_pattadar where dist_code='$dist_code' and "
                                    . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and"
                                    . " mouza_pargona_code='$mouza_pargona_code' and "
                                    . " vill_townprt_code='$vill_code' and TRIM(patta_no)=trim('$occ->new_patta_no')  "
                                    . " ")->row()->pdar_id;
                }
                if ($pdar_id == null) {
                    $pdar_id = 1;
                }
                $dag_pattadar['dist_code'] = $dist_code;
                $dag_pattadar['subdiv_code'] = $subdiv_code;
                $dag_pattadar['cir_code'] = $cir_code;
                $dag_pattadar['lot_no'] = $lot_no;
                $dag_pattadar['mouza_pargona_code'] = $mouza_pargona_code;
                $dag_pattadar['vill_townprt_code'] = $vill_code;
                if ($ord->order_type_code == '02') {
                    $dag_pattadar['dag_no'] = $occ->new_dag_no;
                } else {
                    $dag_pattadar['dag_no'] = $dag_no;
                }
                if (($occ->pdar_id) && (!($ord->order_type_code == '02'))) {
                    $dag_pattadar['pdar_id'] = $occ->pdar_id;
                } else {
                    $dag_pattadar['pdar_id'] = $pdar_id;
                }
                //var_dump($dag_pattadar);

                if ($ord->order_type_code == '02') {
                    $dag_pattadar['patta_no'] = trim($occ->new_patta_no);
                    $chitha_pattadar['patta_no'] = trim($occ->new_patta_no);
                } else {
                    $dag_pattadar['patta_no'] = trim($occ->patta_no);
                    $chitha_pattadar['patta_no'] = trim($occ->patta_no);
                }
                $dag_pattadar['p_flag'] = '0';
                $dag_pattadar['patta_type_code'] = $occ->patta_type_code;
                $dag_pattadar['dag_por_b'] = $occ->land_area_b;
                $dag_pattadar['dag_por_k'] = $occ->land_area_k;
                $dag_pattadar['dag_por_lc'] = $occ->land_area_lc;
                $dag_pattadar['dag_por_g'] = $occ->land_area_g;
                $dag_pattadar['dag_por_kr'] = $occ->land_area_kr;

                $dag_pattadar['user_code'] = $this->session->userdata('user_code');
                $dag_pattadar['date_entry'] = date('Y-m-d G:i:s');
                $dag_pattadar['operation'] = 'B';

                $chitha_pattadar['dist_code'] = $dist_code;
                $chitha_pattadar['subdiv_code'] = $subdiv_code;
                $chitha_pattadar['cir_code'] = $cir_code;
                $chitha_pattadar['lot_no'] = $lot_no;
                $chitha_pattadar['mouza_pargona_code'] = $mouza_pargona_code;
                $chitha_pattadar['vill_townprt_code'] = $vill_code;

                $chitha_pattadar['pdar_id'] = $pdar_id;
                $chitha_pattadar['new_pdar_name'] = $occ->new_pattadar;
                $chitha_pattadar['patta_type_code'] = $occ->patta_type_code;
                $chitha_pattadar['pdar_name'] = $occ->occupant_name;
                $chitha_pattadar['pdar_father'] = $occ->occupant_fmh_name;
                $chitha_pattadar['pdar_add1'] = $occ->occupant_add1;
                $chitha_pattadar['pdar_add2'] = $occ->occupant_add2;
                $chitha_pattadar['pdar_add3'] = null;
                $chitha_pattadar['pdar_name'] = $occ->occupant_name;
                $chitha_pattadar['pdar_name'] = $occ->occupant_name;
                $chitha_pattadar['pdar_name'] = $occ->occupant_name;
                $chitha_pattadar['pdar_guard_reln'] = $occ->occupant_fmh_flag;
                $chitha_pattadar['user_code'] = $this->session->userdata('user_code');
                $chitha_pattadar['date_entry'] = date('Y-m-d G:i:s');
                $chitha_pattadar['operation'] = 'B';
                $chitha_pattadar['jama_yn'] = 'N';


                $chitha_basic_query = "select land_class_code from    chitha_basic "
                        . "where dist_code='$dist_code' and subdiv_code='$subdiv_code' and"
                        . " cir_code='$cir_code' and lot_no='$lot_no' and"
                        . " mouza_pargona_code='$mouza_pargona_code' and TRIM(patta_no)=trim('$occ->patta_no') and"
                        . " patta_type_code='$occ->patta_type_code' and dag_no='$dag_no'";

                $result = $this->db->query($chitha_basic_query)->row();
                //var_dump($result);

                $chitha_basic = array();
                $chitha_basic['dist_code'] = $dist_code;
                $chitha_basic['subdiv_code'] = $subdiv_code;
                $chitha_basic['cir_code'] = $cir_code;
                $chitha_basic['mouza_pargona_code'] = $mouza_pargona_code;
                $chitha_basic['lot_no'] = $lot_no;
                $chitha_basic['vill_townprt_code'] = $vill_code;
                $chitha_basic['dag_area_b'] = $ord->mut_land_area_b;
                $chitha_basic['dag_area_k'] = $ord->mut_land_area_k;
                $chitha_basic['dag_area_lc'] = $ord->mut_land_area_lc;
                $chitha_basic['dag_area_g'] = $ord->mut_land_area_g;
                $chitha_basic['dag_area_kr'] = $ord->mut_land_area_kr;
                $chitha_basic['user_code'] = $this->session->userdata('user_code');
                $chitha_basic['date_entry'] = date('Y-m-d G:i:s');
                $chitha_basic['land_class_code'] = $result->land_class_code;

                if ($ord->order_type_code == '02') {
                    $old_dag = $dag_no;

                    $chitha_basic['dag_no'] = $occ->new_dag_no;
                    $chitha_basic['dag_no_int'] = $occ->new_dag_no . '00';
                    $chitha_basic['old_dag_no '] = $dag_no;
                    $old_patta = trim($occ->old_patta_no);
                    $chitha_basic['patta_no'] = trim($occ->new_patta_no);
                    $q = "update chitha_col8_order set new_dag_no='$occ->new_dag_no' where "
                            . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                            . " mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and"
                            . " vill_townprt_code='$vill_code' and col8order_cron_no=$col8order_cron_no";
                    $this->db->query($q); //***************************
                } else {
                    $chitha_basic['dag_no'] = $dag_no;

                    $q = "select dag_no_int as dag_no_int from    chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'" .
                            " and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$occ->patta_type_code' and TRIM(patta_no)=trim('$occ->patta_no')";

                    $dag_no_int = $this->db->query($q)->row()->dag_no_int;

                    $chitha_basic['dag_no_int'] = $dag_no_int;
                    $chitha_basic['patta_no'] = trim($occ->patta_no);
                }
                $chitha_basic['patta_type_code'] = $occ->patta_type_code;

                $chitha_basic['operation'] = "B";
                $chitha_basic['user_code'] = $this->session->userdata('user_code');
                //$dag_pattadar['user_code'] = $this->session->userdata('user_code');
                // $chitha_pattadar['user_code'] = $this->session->userdata('user_code');
                //var_dump($chitha_basic);
                //var_dump($dag_pattadar);

                $corrected = date('Y-m-d G:i:s');
                if ((!$chitha_basic_update) && ($ord->order_type_code == '02')) {

                    $chitha_basic_update = TRUE;
                    $sql = "select dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,dag_revenue from    chitha_basic where"
                            . "  dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                            . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                            . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                            . " and dag_no='$occ->dag_no' and TRIM(patta_no)=trim('$occ->patta_no') and"
                            . " patta_type_code='$occ->patta_type_code' ";

                    $data = $this->db->query($sql)->row();

                    $chitha_basic['dag_revenue'] = $ord->min_revenue * (($ord->mut_land_area_b * 100 + $ord->mut_land_area_k * 20 + $ord->mut_land_area_lc) / 100.0);
                    $chitha_basic['dag_local_tax'] = $chitha_basic['dag_revenue'] / 4.0;
                    //var_dump($chitha_basic);
                    // $this->db->insert('chitha_basic', $chitha_basic); //************************
                    $this->Chitha_basic_model->insert_table('chitha_basic',$chitha_basic);

                    $dataNew['dag_no'] = $chitha_basic['dag_no'];
                    //var_dump($dataNew);
                    $this->db->insert('chitha_col8_order', $dataNew); //***********************


                    $sourcelessa = $data->dag_area_b * 100 + $data->dag_area_k * 20 + $data->dag_area_lc;
                    $mutationlessa = $ord->mut_land_area_b * 100 + $ord->mut_land_area_k * 20 + $ord->mut_land_area_lc;
                    $remaining_lessa = $sourcelessa - $mutationlessa;

                    $left_b = floor($remaining_lessa / 100);
                    $left_k = floor(($remaining_lessa - $left_b * 100) / 20);
                    $left_lc = $remaining_lessa - $left_b * 100 - $left_k * 20;
                    $left_g = 0;
                    $left_kr = 0;
                    $d = date('Y-m-d G:i:s');

                    $dag_revenue_updates = $data->dag_revenue;

                    if ($dag_revenue_updates == null) {
                        $dag_revenue_updates = 0;
                    }
                    $dag_local_tax_update = $dag_revenue_updates / 4;
                    // $sql = "update chitha_basic set jama_yn=null,dag_revenue=$dag_revenue_updates,dag_local_tax=$dag_local_tax_update, "
                    //         . " dag_area_b=$left_b,dag_area_k=$left_k,dag_area_lc=$left_lc,"
                    //         . " dag_area_g=$left_g,dag_area_kr=$left_kr,date_entry='$d',operation='M' "
                    //         . " where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                    //         . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                    //         . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                    //         . " and dag_no='$occ->dag_no' and TRIM(patta_no)=trim('$occ->patta_no') and"
                    //         . " patta_type_code='$occ->patta_type_code' ";

                    // $this->db->query($sql); //******************

                    $table = 'chitha_basic';

                    $params = [
                        'jama_yn'       => null,
                        'dag_revenue'   => $dag_revenue_updates,
                        'dag_local_tax' => $dag_local_tax_update,
                        'dag_area_b'    => $left_b,
                        'dag_area_k'    => $left_k,
                        'dag_area_lc'   => $left_lc,
                        'dag_area_g'    => $left_g,
                        'dag_area_kr'   => $left_kr,
                        'date_entry'    => $d,
                        'operation'     => 'M',
                    ];

                    $where = [
                        'dist_code'          => $occ->dist_code,
                        'subdiv_code'        => $occ->subdiv_code,
                        'cir_code'           => $occ->cir_code,
                        'mouza_pargona_code' => $occ->mouza_pargona_code,
                        'lot_no'             => $occ->lot_no,
                        'vill_townprt_code'  => $occ->vill_townprt_code,
                        'dag_no'             => $occ->dag_no,
                        'patta_no'           => trim($occ->patta_no),
                        'patta_type_code'    => $occ->patta_type_code,
                    ];

                    $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                }

                $p_id = $dag_pattadar['pdar_id'];

                if ($ord->order_type_code == '02') {
                    $q = "select count(*) as count from    chitha_dag_pattadar  where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                            . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                            . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                            . " and dag_no='$occ->dag_no' and TRIM(patta_no)=trim('$occ->new_patta_no') and"
                            . " patta_type_code='$occ->patta_type_code' and pdar_id='$p_id'";
                    //echo $q;
                    $cDagPattadarExists = $this->db->query($q)->row()->count;

                    $q = "select count(*) as count from    chitha_pattadar  where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                            . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                            . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                            . " and TRIM(patta_no)=trim('$occ->new_patta_no') and"
                            . " patta_type_code='$occ->patta_type_code' and pdar_id='$p_id'";
                    //echo $q;
                    $cPattadarExists = $this->db->query($q)->row()->count;
                } else {
                    $q = "select count(*) as count from    chitha_dag_pattadar  where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                            . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                            . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                            . " and dag_no='$occ->dag_no' and TRIM(patta_no)=trim('$occ->patta_no') and"
                            . " patta_type_code='$occ->patta_type_code' and pdar_id='$p_id'";
                    //echo $q;
                    $cDagPattadarExists = $this->db->query($q)->row()->count;

                    $q = "select count(*) as count from    chitha_pattadar  where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                            . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                            . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                            . " and TRIM(patta_no)=trim('$occ->patta_no') and"
                            . " patta_type_code='$occ->patta_type_code' and pdar_id='$p_id'";
                    //echo $q;
                    $cPattadarExists = $this->db->query($q)->row()->count;
                }


                $occ->new_pattadar; // for partition it will always be new pattadar
                if (($occ->new_pattadar == 'N')) {
                    //var_dump($dag_pattadar);
                    //var_dump($chitha_pattadar);
                    // $this->db->insert('chitha_dag_pattadar', $dag_pattadar); //**************
                    $this->Chitha_basic_model->insert_table('chitha_dag_pattadar',$dag_pattadar);
                    if (($cPattadarExists == 0)) {
                        // $this->db->insert('chitha_pattadar', $chitha_pattadar); //***************
                        $this->Chitha_basic_model->insert_table('chitha_pattadar',$chitha_pattadar);
                    }
                }

                $today = date('Y-m-d');
                $t_occup_query = "update t_chitha_col8_occup set iscorrected_inco='Y',iscorrected_inco_date='$corrected',order_passed='Y' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                        . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                        . "vill_townprt_code='$vill_code' and petition_no=$petition_no and dag_no='$dag_no' ";
                $this->db->query($t_occup_query); //*********************
            }

            if ($ord->order_type_code == '02') {
                foreach ($t_occup_data as $occup) {
                    // $sql = "update chitha_dag_pattadar set p_flag='1' where   dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                    //         . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                    //         . "vill_townprt_code='$vill_code' and dag_no='$dag_no' and pdar_id=$occup->pdar_id";
                    // $this->db->query($sql); //*********************
                    $table = 'chitha_dag_pattadar';

                    $params = [
                        'p_flag' => '1',
                    ];

                    $where = [
                        'dist_code'          => $dist_code,
                        'subdiv_code'        => $subdiv_code,
                        'cir_code'           => $cir_code,
                        'lot_no'             => $lot_no,
                        'mouza_pargona_code' => $mouza_pargona_code,
                        'vill_townprt_code'  => $vill_code,
                        'dag_no'             => $dag_no,
                        'pdar_id'            => $occup->pdar_id,
                    ];

                    $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                }
            }

            if (($ord->order_type_code == '01') || ($ord->order_type_code == '02')) {
                foreach ($t_inplace_data as $inplace) {
                    $data = array();

                    foreach ($inplace as $key => $value) {
                        $data[$key] = $value;
                    }
                    unset($data['occupant_id']);
                    unset($data['year_no']);
                    unset($data['petition_no']);
                    unset($data['occupant_name']);
                    unset($data['occupant_fmh_name']);
                    unset($data['occupant_fmh_flag']);
                    unset($data['occupant_add1']);
                    unset($data['occupant_add2']);
                    unset($data['occupant_add3']);
                    unset($data['old_patta_no']);
                    unset($data['new_patta_no']);
                    unset($data['old_dag_no']);
                    unset($data['patta_type_code']);
                    unset($data['patta_no']);
                    unset($data['pdar_id']);
                    unset($data['iscorrected_inco']);
                    unset($data['iscorrected_inco_date']);
                    unset($data['isdataposted_torkg_db']);
                    unset($data['iscorrected_rkg_record']);
                    unset($data['new_dag_no']);
                    unset($data['order_passed']);
                    unset($data['date_of_order']);
                    unset($data['make_mdb']);
                    unset($data['iscorrected_rkg_date']);
                    unset($data['revenue']);
                    unset($data['new_pattadar']);
                    unset($data['hus_wife']);
                    unset($data['revenue']);


                    if ($data['fmute_strike_out'] == '1') {
                        $data['inplaceof_alongwith'] = 'i';
                    } else {
                        $data['inplaceof_alongwith'] = 'a';
                    }
                    unset($data['fmute_strike_out']);
                    $data['col8order_cron_no'] = $col8order_cron_no;
                    $data['user_code'] = $this->user_code;
                    $data['date_entry'] = date('Y-m-d G:i:s');
                    $data['operation'] = date('E');
                    // var_dump($data);
                    $key = array(
                        'dist_code' => $data['dist_code'],
                        'subdiv_code' => $data['subdiv_code'],
                        'cir_code' => $data['cir_code'],
                        'mouza_pargona_code' => $data['mouza_pargona_code'],
                        'lot_no' => $data['lot_no'],
                        'vill_townprt_code' => $data['vill_townprt_code'],
                        'dag_no' => $data['dag_no'],
                        'col8order_cron_no' => $data['col8order_cron_no'],
                        'inplace_of_id' => $data['inplace_of_id'],
                    );

                    $queryCheck = "select count(*) as c from    chitha_col8_inplace where dist_code='$data[dist_code]' and subdiv_code='$data[subdiv_code]' and cir_code='$data[cir_code]' and "
                            . " mouza_pargona_code='$data[mouza_pargona_code]' and lot_no='$data[lot_no]' and vill_townprt_code='$data[vill_townprt_code]' and dag_no='$data[dag_no]' and col8order_cron_no='$data[col8order_cron_no]' and "
                            . " inplace_of_id='$data[inplace_of_id]' ";
                    $count = $this->db->query($queryCheck)->row()->c;
                    if ($count <= 0)
                    //var_dump($data);
                        $this->db->insert('chitha_col8_inplace', $data); //****************

                    $p_flag = '0';
                    if ($inplace->fmute_strike_out == '1')
                        $p_flag = '1';

                    // $update_query = "update chitha_dag_pattadar  set p_flag='$p_flag' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                    //         . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                    //         . "vill_townprt_code='$vill_code' and dag_no='$dag_no' and pdar_id=$inplace->pdar_id";
                    // echo $update_query;
                    $table = 'chitha_dag_pattadar';

                    $params = [
                        'p_flag' => $p_flag,
                    ];

                    $where = [
                        'dist_code'          => $dist_code,
                        'subdiv_code'        => $subdiv_code,
                        'cir_code'           => $cir_code,
                        'lot_no'             => $lot_no,
                        'mouza_pargona_code' => $mouza_pargona_code,
                        'vill_townprt_code'  => $vill_code,
                        'dag_no'             => $dag_no,
                        'pdar_id'            => $inplace->pdar_id,
                    ];

                    $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                    $corrected = date('Y-m-d G:i:s');
                    $t_inplace_query = "update t_chitha_col8_inplace set iscorrected_inco='Y',iscorrected_inco_date='$corrected',order_passed='Y' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                            . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                            . "vill_townprt_code='$vill_code' and dag_no='$dag_no'";

                    // $this->db->query($update_query); //*****************
                    $this->db->query($t_inplace_query); //*****************
                    // $order_update_query = "update field_mut_basic set order_passed='Y' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                    // . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                    // . "vill_townprt_code='$vill_code' and petition_no=$petition_no";
                    // $this->db->query($order_update_query); //***************
                }
            }
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            $this->AgriStackCaseHistory->CreateLog($dist_code,$case_no);
            // $order_update_query = "update field_mut_basic set order_passed='Y' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
            // . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
            // . "vill_townprt_code='$vill_code' and petition_no='$petition_no'";
            // $this->db->query($order_update_query);
            redirect('/home');
            return true;
        }
    }

    ///////////Office partition
    public function autoUpdateOP($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $petition_no, $dag_no, $case_no) {
        $db=  $this->session->userdata('db');
        $query = "select * from    t_chitha_rmk_ordbasic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
                . "and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and petition_no='$petition_no' and dag_no='$dag_no' and  "
                . " (iscorrected_inco is null or iscorrected_inco=' ') and ord_no='$case_no' and map_partition='Y' and ord_type_code='04'  ";
        $result = $this->db->query($query)->result();
        //exit;
        foreach ($result as $order) {
            $this->db->trans_begin();
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
            $infavQuery = "select * from    t_chitha_rmk_infavor_of where ord_no='$order->ord_no' "
                    . "and dist_code='$order->dist_code' and subdiv_code='$order->subdiv_code' and cir_code='$order->cir_code' and year_no='$order->year_no' and  iscorrected_inco is null ";
            $infavData = $this->db->query($infavQuery)->result();
            $pdar_id = 1;
            $chitha_basic_update = 0;
            foreach ($infavData as $d) {
                $landclass_query = "select land_class_code from    chitha_basic  where dist_code='$d->dist_code' and"
                        . " subdiv_code='$d->subdiv_code' and cir_code='$order->cir_code'"
                        . " and lot_no='$d->lot_no' and mouza_pargona_code='$d->mouza_pargona_code' and "
                        . " vill_townprt_code='$d->vill_townprt_code' and dag_no='$d->dag_no' "
                        . " and patta_type_code='$d->patta_type_code' and TRIM(patta_no)=trim('$d->patta_no')";
                // echo $landclass_query;
                $landclasscode = $this->db->query($landclass_query)->row()->land_class_code;
                // for chitha update
                if ($chitha_basic_update == 0) {
                    $chitha_basic = array(
                        'dist_code' => $d->dist_code,
                        'subdiv_code' => $d->subdiv_code,
                        'cir_code' => $d->cir_code,
                        'mouza_pargona_code' => $d->mouza_pargona_code,
                        'lot_no' => $d->lot_no,
                        'vill_townprt_code' => $d->vill_townprt_code,
                        'old_dag_no' => $d->dag_no,
                        'dag_no' => $d->new_dag_no,
                        'dag_no_int' => $d->new_dag_no . '00',
                        'patta_type_code' => $d->patta_type_code,
                        'patta_no' => trim($d->new_patta_no),
                        'land_class_code' => $landclasscode,
                        'dag_area_b' => $d->land_area_b,
                        'dag_area_k' => $d->land_area_k,
                        'dag_area_lc' => $d->land_area_lc,
                        'dag_area_g' => 0.0,
                        'dag_area_kr' => 0,
                        'dag_revenue' => $d->revenue,
                        'dag_local_tax' => ($d->revenue) / 4,
                        'user_code' => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d G:i:s'),
                        'operation' => 'B',
                        'jama_yn' => 'n',
                        'old_patta_no' => trim($d->patta_no)
                    );
                    // var_dump($chitha_basic);
                    if ($d->dag_no == $d->new_dag_no) {
                        // $chitha_update = "update chitha_basic set patta_no='$d->new_patta_no',jama_yn=null  where dist_code='$d->dist_code' and"
                        //         . " subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code'"
                        //         . " and lot_no='$d->lot_no' and mouza_pargona_code='$d->mouza_pargona_code' and "
                        //         . " vill_townprt_code='$d->vill_townprt_code' and dag_no='$d->dag_no'  "
                        //         . " and TRIM(patta_no)=trim('$d->patta_no') and patta_type_code='$d->patta_type_code'";
                        // //echo $chitha_update;
                        // $this->db->query($chitha_update);
                        $table = 'chitha_basic';

                        $params = [
                            'patta_no' => $d->new_patta_no,
                            'jama_yn'  => null,
                        ];

                        $where = [
                            'dist_code'          => $d->dist_code,
                            'subdiv_code'        => $d->subdiv_code,
                            'cir_code'           => $d->cir_code,
                            'lot_no'             => $d->lot_no,
                            'mouza_pargona_code' => $d->mouza_pargona_code,
                            'vill_townprt_code'  => $d->vill_townprt_code,
                            'dag_no'             => $d->dag_no,
                            'patta_no'           => trim($d->patta_no),
                            'patta_type_code'    => $d->patta_type_code,
                        ];

                        $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                    } else {
                        //var_dump($chitha_basic); 
                        $q = "SElect count(*) as c from    chitha_basic where dist_code='$d->dist_code' and"
                                . " subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code'"
                                . " and lot_no='$d->lot_no' and mouza_pargona_code='$d->mouza_pargona_code' and "
                                . " vill_townprt_code='$d->vill_townprt_code' and dag_no='$d->new_dag_no'  ";
                        $dcount = $this->db->query($q)->row()->c;
                        if ($dcount) {
                            redirect('/home');
                        }
                        // $this->db->insert('chitha_basic', $chitha_basic);
                        $this->Chitha_basic_model->insert_table('chitha_basic',$chitha_basic);
                        $landArea_query = "select dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,dag_revenue,dag_local_tax from    chitha_basic"
                                . "  where dist_code='$d->dist_code' and  "
                                . " subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code'"
                                . " and lot_no='$d->lot_no' and mouza_pargona_code='$d->mouza_pargona_code' and "
                                . " vill_townprt_code='$d->vill_townprt_code' and dag_no='$d->dag_no'  "
                                . " and TRIM(patta_no)=trim('$d->patta_no') and patta_type_code='$d->patta_type_code'";
                        $landArea_query . "<br>";
                        $sourceB = $this->db->query($landArea_query)->row()->dag_area_b;
                        $sourceK = $this->db->query($landArea_query)->row()->dag_area_k;
                        $sourceL = $this->db->query($landArea_query)->row()->dag_area_lc;
                        $sourceRev = $this->db->query($landArea_query)->row()->dag_revenue;
                        $sourceLTax = $this->db->query($landArea_query)->row()->dag_local_tax;
                        $sourceLessa = $sourceB * 100 + $sourceK * 20 + $sourceL;
                        $targetLessa = $d->land_area_b * 100 + $d->land_area_k * 20 + $d->land_area_lc;
                        $remLessa = $sourceLessa - $targetLessa;
                        $new_revenue = ($sourceRev / $sourceLessa) * $remLessa;
                        $new_local_tax = ($new_revenue / 4);
                        $b = floor($remLessa / 100.0);
                        $k = ($remLessa - $b * 100.0) / 20.0; //0
                        $k = floor($k);
                        $lc = ($remLessa - $b * 100.0 - $k * 20.0);
                        $g = 0.0;
                        $kr = 0.0;
                        $dag_no_int = $d->dag_no . "00";
                        // $chitha_update = "update chitha_basic set dag_area_b='$b',dag_area_k='$k',"
                        //         . " dag_area_lc='$lc',dag_area_g='$g',dag_area_kr='$kr',dag_revenue='$new_revenue',dag_local_tax='$new_local_tax',jama_yn='n'  where dist_code='$d->dist_code' and"
                        //         . " subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code'"
                        //         . " and lot_no='$d->lot_no' and mouza_pargona_code='$d->mouza_pargona_code' and "
                        //         . " vill_townprt_code='$d->vill_townprt_code' and dag_no='$d->dag_no' and dag_no_int=$dag_no_int  "
                        //         . " and TRIM(patta_no)=trim('$d->patta_no') and patta_type_code='$d->patta_type_code'";
                        // //echo $chitha_update;
                        // $this->db->query($chitha_update);
                        $table = 'chitha_basic';

                        $params = [
                            'dag_area_b'    => $b,
                            'dag_area_k'    => $k,
                            'dag_area_lc'   => $lc,
                            'dag_area_g'    => $g,
                            'dag_area_kr'   => $kr,
                            'dag_revenue'   => $new_revenue,
                            'dag_local_tax' => $new_local_tax,
                            'jama_yn'       => 'n',
                        ];

                        $where = [
                            'dist_code'          => $d->dist_code,
                            'subdiv_code'        => $d->subdiv_code,
                            'cir_code'           => $d->cir_code,
                            'lot_no'             => $d->lot_no,
                            'mouza_pargona_code' => $d->mouza_pargona_code,
                            'vill_townprt_code'  => $d->vill_townprt_code,
                            'dag_no'             => $d->dag_no,
                            'dag_no_int'         => $dag_no_int,
                            'patta_no'           => trim($d->patta_no),
                            'patta_type_code'    => $d->patta_type_code,
                        ];

                        $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                    }
                    $chitha_basic_update = 1;
                }
                // end chitha update

                $data = array(
                    'pdar_name' => $d->infavor_of_name,
                    'pdar_father' => $d->infavor_of_guardian,
                    'patta_no' => trim($d->new_patta_no),
                    'patta_type_code' => $d->patta_type_code,
                    'pdar_add1' => $d->infavor_of_add1,
                    'pdar_add2' => $d->infavor_of_add2,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d G:i:s'),
                    'operation' => 'B',
                    'pdar_guard_reln' => $d->infav_of_guar_relation,
                    'dist_code' => $d->dist_code,
                    'subdiv_code' => $d->subdiv_code,
                    'cir_code' => $d->cir_code,
                    'mouza_pargona_code' => $d->mouza_pargona_code,
                    'lot_no' => $d->lot_no,
                    'vill_townprt_code' => $d->vill_townprt_code,
                    'pdar_id' => $d->pdar_id,
                    'new_pdar_name' => 'N',
                    'jama_yn' => 'n',
                    'pdar_gender' => $d->infavor_of_gender,
                    'pdar_mother' => $d->infavor_of_mother
                );
                //var_dump($data);
                $dag_pattadar = array(
                    'dist_code' => $d->dist_code,
                    'subdiv_code' => $d->subdiv_code,
                    'cir_code' => $d->cir_code,
                    'mouza_pargona_code' => $d->mouza_pargona_code,
                    'lot_no' => $d->lot_no,
                    'vill_townprt_code' => $d->vill_townprt_code,
                    'pdar_id' => $d->pdar_id,
                    'patta_no' => trim($d->new_patta_no),
                    'dag_no' => $d->new_dag_no,
                    'patta_type_code' => $d->patta_type_code,
                    'dag_por_b' => 0, //$d->land_area_b,
                    'dag_por_k' => 0, //$d->land_area_k,
                    'dag_por_lc' => 0, //$d->land_area_lc,
                    'dag_por_g' => 0.0,
                    'dag_por_kr' => 0,
                    'pdar_land_revenue' => $d->revenue,
                    'pdar_land_localtax' => ($d->revenue) / 4,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d G:i:s'),
                    'operation' => 'B',
                    'p_flag' => '0',
                    'jama_yn' => 'n'
                );
                //var_dump($dag_pattadar);
                $pdar_id++;
                ////////Patta Exists or Not/////////
                $q = "SElect max(pdar_id)+1 as pdar_id from    chitha_pattadar  where dist_code='$d->dist_code' and"
                        . " subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code'"
                        . " and lot_no='$d->lot_no' and mouza_pargona_code='$d->mouza_pargona_code' and "
                        . " vill_townprt_code='$d->vill_townprt_code' "
                        . " and TRIM(patta_no)=trim('$d->new_patta_no') and patta_type_code='$d->patta_type_code' ";
                $pdar_id = $this->db->query($q)->row()->pdar_id;
                echo "<br>";
                if ($pdar_id == null) {
                    $pdar_id = 1;
                }
                //////////////////
                if (($d->dag_no == $d->new_dag_no)) {
                    // $chitha_update = "update chitha_dag_pattadar set patta_no='$d->new_patta_no',pdar_id='$pdar_id',jama_yn=null  where dist_code='$d->dist_code' and"
                    //         . " subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code'"
                    //         . " and lot_no='$d->lot_no' and mouza_pargona_code='$d->mouza_pargona_code' and "
                    //         . " vill_townprt_code='$d->vill_townprt_code' and dag_no='$d->dag_no'  "
                    //         . " and TRIM(patta_no)=trim('$d->patta_no') and patta_type_code='$d->patta_type_code' and pdar_id='$d->pdar_id'";
                    // //echo $chitha_update;
                    // echo $this->db->query($chitha_update);
                    $table = 'chitha_dag_pattadar';

                    $params = [
                        'patta_no' => $d->new_patta_no,
                        'pdar_id'  => $pdar_id,
                        'jama_yn'  => null,
                    ];

                    $where = [
                        'dist_code'          => $d->dist_code,
                        'subdiv_code'        => $d->subdiv_code,
                        'cir_code'           => $d->cir_code,
                        'lot_no'             => $d->lot_no,
                        'mouza_pargona_code' => $d->mouza_pargona_code,
                        'vill_townprt_code'  => $d->vill_townprt_code,
                        'dag_no'             => $d->dag_no,
                        'patta_no'           => trim($d->patta_no),
                        'patta_type_code'    => $d->patta_type_code,
                        'pdar_id'            => $d->pdar_id,
                    ];

                    $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                    $q = "SElect pdar_id from    chitha_pattadar  where dist_code='$d->dist_code' and"
                            . " subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code'"
                            . " and lot_no='$d->lot_no' and mouza_pargona_code='$d->mouza_pargona_code' and "
                            . " vill_townprt_code='$d->vill_townprt_code' "
                            . " and TRIM(patta_no)=trim('$d->new_patta_no') and patta_type_code='$d->patta_type_code' and pdar_id='$pdar_id' ";
                    $exist = $this->db->query($q)->row();
                    if ($exist == null) {
                        $data['pdar_id'] = $pdar_id;
                        //var_dump($data);
                        // $this->db->insert('chitha_pattadar', $data);
                        $this->Chitha_basic_model->insert_table('chitha_pattadar',$data);
                    }
                } else {
                    //var_dump($d);
                    $q = "SElect dag_no from    chitha_dag_pattadar  where dist_code='$d->dist_code' and"
                            . " subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code'"
                            . " and lot_no='$d->lot_no' and mouza_pargona_code='$d->mouza_pargona_code' and "
                            . " vill_townprt_code='$d->vill_townprt_code' "
                            . " and TRIM(patta_no)=trim('$d->new_patta_no') and patta_type_code='$d->patta_type_code' and dag_no='$d->new_dag_no' and pdar_id='$d->pdar_id' ";
                    $exist_dag = $this->db->query($q)->row();
                    if ($exist_dag == null) {
                        //$dag_pattadar['pdar_id']=$d->pdar_id;
                        //var_dump($dag_pattadar);
                        // $this->db->insert('chitha_dag_pattadar', $dag_pattadar);
                        $this->Chitha_basic_model->insert_table('chitha_dag_pattadar',$dag_pattadar);
                    }//else{
                    // $chitha_dag_pattadar['pdar_id']=$pdar_id;
                    // $this->db->insert('chitha_dag_pattadar', $dag_pattadar);
                    // }
                    $q = "SElect pdar_id from    chitha_pattadar  where dist_code='$d->dist_code' and"
                            . " subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code'"
                            . " and lot_no='$d->lot_no' and mouza_pargona_code='$d->mouza_pargona_code' and "
                            . " vill_townprt_code='$d->vill_townprt_code' "
                            . " and TRIM(patta_no)=trim('$d->new_patta_no') and patta_type_code='$d->patta_type_code' and pdar_id='$d->pdar_id' ";
                    $exist = $this->db->query($q)->row();
                    if ($exist == null) {
                        // $this->db->insert('chitha_pattadar', $data);
                        $this->Chitha_basic_model->insert_table('chitha_pattadar',$data);
                    } else {
                        $data['pdar_id'] = $pdar_id;
                        $chitha_dag_pattadar['pdar_id'] = $pdar_id;
                        // $this->db->insert('chitha_pattadar', $data);
                        // $this->db->insert('chitha_dag_pattadar', $dag_pattadar);
                        $this->Chitha_basic_model->insert_table('chitha_pattadar',$data);
                        $this->Chitha_basic_model->insert_table('chitha_dag_pattadar',$dag_pattadar);
                    }

                    if ($d->pdar_strike == 'Y') {
                        $p_flag = '0';
                    } else {
                        $p_flag = '1';
                    }
                    // $updateQuery = "update chitha_dag_pattadar set p_flag = '$p_flag' where dist_code='$d->dist_code' and"
                    //         . " subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code' and lot_no='$d->lot_no' and "
                    //         . " mouza_pargona_code = '$d->mouza_pargona_code' and vill_townprt_code='$d->vill_townprt_code' and"
                    //         . " dag_no ='$d->dag_no' and TRIM(patta_no)=trim('$d->patta_no') and patta_type_code='$d->patta_type_code' and pdar_id = '$d->pdar_id' ";
                    // // echo $updateQuery . "<br>";
                    // $this->db->query($updateQuery);
                    $table = 'chitha_dag_pattadar';

                    $params = [
                        'p_flag' => $p_flag,
                    ];

                    $where = [
                        'dist_code'          => $d->dist_code,
                        'subdiv_code'        => $d->subdiv_code,
                        'cir_code'           => $d->cir_code,
                        'lot_no'             => $d->lot_no,
                        'mouza_pargona_code' => $d->mouza_pargona_code,
                        'vill_townprt_code'  => $d->vill_townprt_code,
                        'dag_no'             => $d->dag_no,
                        'patta_no'           => trim($d->patta_no),
                        'patta_type_code'    => $d->patta_type_code,
                        'pdar_id'            => $d->pdar_id,
                    ];

                    $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                }
                //exit;	

                unset($d->year_no);
                unset($d->petition_no);
                unset($d->pdar_id);
                unset($d->revenue);
                unset($d->iscorrected_inco);
                unset($d->iscorrected_inco_date);
                unset($d->iscorrected_rkg_record);
                unset($d->iscorrected_rkg_date);
                unset($d->infavor_is_copdar);
                unset($d->make_mdb);
                unset($d->new_pattadar);
                unset($d->make_mdb);
                unset($d->make_mdb);
                unset($d->make_mdb);
                unset($d->make_mdb);
                $d->rmk_type_hist_no = $rmk_hist_no;
                $d->ord_cron_no = $ord_cron_no;
                $d->user_code = $this->session->userdata('user_code');
                $d->operation = 'B';
                $d->date_entry = date('Y-m-d G:i:s');
                unset($d->pdar_strike);
                unset($d->infavor_of_gender);
                unset($d->infavor_of_mother);
                $this->db->insert('chitha_rmk_infavor_of', $d);
            }

            unset($order->year_no);
            unset($order->petition_no);

            unset($order->petition_no);

            unset($order->iscorrected_inco);
            unset($order->iscorrected_inco_date);
            unset($order->iscorrected_rkg_record);
            unset($order->iscorrected_rkg_date);
            unset($order->pdar_id);
            unset($order->ord_onbehalf_guard);
            unset($order->ord_onbehalf_add1);
            unset($order->ord_onbehalf_add2);
            unset($order->make_mdb);
            unset($order->is_converted_pattadar);
            unset($order->patta_type_code);
            //unset($order->patta_no);
            unset($order->ord_onbehalf_id);
            unset($order->ord_onbehalf_of);
            unset($order->land_class_code);
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
            //$order->co_code = $order->co_code;
            $order->operation = 'B';
            $order->date_entry = date('Y-m-d G:i:s');
            $order->area_left_b = 0;
            $order->area_left_k = 0;
            $order->area_left_lc = 0;
            $order->area_left_g = 0;
            $order->area_left_kr = 0;


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
                'operation' => 'B',
                'date_entry' => date('Y-m-d G:i:s'),
                'jama_updated' => 'n',
                'new_dag_no' => $order->new_dag_no,
                'patta_no' => trim($d->new_patta_no)
            );
            //var_dump($rmk_gen);
            $this->db->insert('chitha_rmk_gen', $rmk_gen);
            $rmk_gen = array(
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
                'operation' => 'B',
                'date_entry' => date('Y-m-d G:i:s'),
                'jama_updated' => 'n',
                'new_dag_no' => $order->dag_no,
                'patta_no' => trim($d->patta_no)
            );
            //var_dump($rmk_gen);
            if (($d->dag_no != $d->new_dag_no)) {
                $this->db->insert('chitha_rmk_gen', $rmk_gen);
                $this->db->insert('chitha_rmk_ordbasic', $order);
            }
            //var_dump($order);

            unset($order->dag_no);
            $order->dag_no = $order->new_dag_no;
            $newDag = $order->new_dag_no;
            //var_dump($order);
            unset($order->new_dag_no);
            $this->db->insert('chitha_rmk_ordbasic', $order);
            //var_dump($order);
            $d = date('Y-m-d');

            $update_q = "update t_chitha_rmk_ordbasic set iscorrected_inco='Y',iscorrected_inco_date='$d'"
                    . " where ord_no='$order->ord_no' and dist_code='$order->dist_code' and subdiv_code='$order->subdiv_code' and cir_code='$order->cir_code' ";
            // $this->db->query($update_q);
            $update_q = "update t_chitha_rmk_infavor_of set iscorrected_inco='Y',iscorrected_inco_date='$d'"
                    . " where ord_no='$order->ord_no' and dist_code='$order->dist_code' and subdiv_code='$order->subdiv_code' and cir_code='$order->cir_code'  ";
            // $this->db->query($update_q);
            if ($this->db->trans_status() == FALSE) {
                $this->db->trans_rollback();
                echo "Error Occured";
            } else {
                //echo "wht";
                //$data['newdagno'] = array('newdag' => $newDag);
                $this->db->trans_commit();
                $this->AgriStackCaseHistory->CreateLog($dist_code,$case_no);
                redirect('/home');
                // $this->load->view('../views/header');
                // $this->load->view('../views/partition/chitha_update_complete2');
                // $this->load->view('../views/footer');
            }
        }
    }

    function corejectorder() {
		  $db=  $this->session->userdata('db');
        $tp = $this->input->get('type');
        $p = $this->input->get('p');
        $c = $this->input->get('case');
        if ($tp == 2) {
            $d = date('Y-m-d');
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $update_q = "update t_chitha_rmk_ordbasic set iscorrected_inco='Y',iscorrected_inco_date='$d'"
                    . " where ord_no='$c' and petition_no='$p' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
            $this->db->query($update_q);
            $update_q = "update t_chitha_rmk_infavor_of set iscorrected_inco='Y',iscorrected_inco_date='$d'"
                    . " where ord_no='$c' and petition_no='$p' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
            $this->db->query($update_q);
            redirect('/home');
        } elseif ($tp == 1) {
            $d = date('Y-m-d');
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $update_q = "update t_chitha_col8_order set iscorrected_inco='Y',iscorrected_inco_date='$d'"
                    . " where case_no='$c' and petition_no='$p' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
            $this->db->query($update_q);

            redirect('/home');
        }
    }

}
