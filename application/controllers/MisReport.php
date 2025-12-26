<?php

class MisReport extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mutation/mutationmodel');
        //$this->load->model('misreport/misreport');
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
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        $session = $this->session->userdata('username');
        // if ($session == 'lm') {
        //     $this->load->view('menu/menu1');
        // } elseif ($session == 'sk') {
        //     $this->load->view('menu/menu2');
        // } elseif ($session == 'oc') {
        //     $this->load->view('menu/menu3');
        // }
        // $this->load->view('../views/misreport/misreport');
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/misreport';
        $this->load->view('layouts/main',$data);
    }

    ////////////////
    public function Backentry() {
		// $db=  $this->session->userdata('db');
  //       $this->load->helper('html');
  //       $this->load->view('../views/header');
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

        //var_dump($district);
        // $this->load->view('../views/misreport/backentry', $district);
        // $this->load->view('../views/footer');
        $district['_view'] = 'misreport/backentry';
        $this->load->view('layouts/main',$district);
    }

    function back_step_one() {
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
            //var_dump($chitha_rmk_ordbasic);
            //var_dump($data);	 
        }
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/pattdar');
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/pattdar';
        $this->load->view('layouts/main',$data);
    }

    function back_step_two() {
		//$db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $pdarid = $this->input->post('pdar_name');
            $pdar_guardian = $this->input->post('pdar_guardian');
            $pdar_rel_guar = $this->input->post('pdar_rel_guar');
            $pdar_add1 = $this->input->post('pdar_add1');
            $pdar_add2 = $this->input->post('pdar_add2');

            $pattadar = array(
                'pdarid' => $pdarid,
                'pdar_guardian' => $pdar_guardian,
                'pdar_rel_guar' => $pdar_rel_guar,
                'pdar_add1' => $pdar_add1,
                'pdar_add2' => $pdar_add2
            );
            $this->session->set_userdata($pattadar);
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
                if ($newpatta < $p) {
                    $newpatta = $p;
                }
            }
            $data['dagpatta'] = array(
                'newdag' => $newDag + 1,
                'newpatta' => $newpatta + 1
            );
            // $this->load->helper('html');
            // $this->load->view('../views/header');
            // $this->load->view('../views/misreport/newallotment', $data);
            // $this->load->view('../views/footer');

            $data['_view'] = 'misreport/newallotment';
            $this->load->view('layouts/main',$data);
        }
    }

    function back_step_three() {
		//$db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $newDag = $this->input->post('new_dag');
            $newpatta = trim($this->input->post('new_patta'));
            //var_dump($this->session->all_userdata());
            //exit;

            $pattaNo = trim($this->session->userdata('patta_no'));
            $pattaType = $this->session->userdata('patta_type');
            $dag_no = $this->session->userdata('dag_no');
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $lot_no = $this->session->userdata('lot_no');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $pdarid = $this->session->userdata('pdarid');


            $q = "select p.pdar_id,p.pdar_name,p.pdar_father,p.pdar_add1,p.pdar_add2,p.pdar_add3,p.pdar_guard_reln from    chitha_pattadar p join 
            chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code 
            and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and
            p.pdar_id = d.pdar_id where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and d.lot_no='$lot_no' and d.dag_no='$dag_no' and TRIM(p.patta_no)='$pattaNo'  and (d.p_flag!='1' or d.p_flag is null)
            and p.patta_type_code='$pattaType' and p.pdar_id='$pdarid'";

            $pdarname = $this->db->query($q)->row();
            $p_name = $pdarname->pdar_name;
            $query = "select max(petition_no)+1 as num from    t_chitha_rmk_infavor_of";
            $petition = $this->db->query($query)->row();
            $petition_num = $petition->num;
            if ($petition_num == null) {
                $petition_num = 1;
            }
            //var_dump($petition);










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
                'pdar_id' => $this->session->userdata('pdarid'),
                'infavor_of_id' => 1,
                'infavor_of_name' => $p_name,
                'infavor_of_guardian' => $this->session->userdata('pdar_guardian'),
                'infav_of_guar_relation' => $this->session->userdata('pdar_rel_guar'),
                'infavor_of_add1' => $this->session->userdata('pdar_add1'),
                'infavor_of_add2' => $this->session->userdata('pdar_add2'),
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
                'new_patta_no' => trim($newpatta),
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

            //var_dump($insert);
            echo $this->db->insert('t_chitha_rmk_infavor_of', $insert);




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
            );
            //var_dump($t_chitha_rmk_ordbasic);
            echo $this->db->insert('t_chitha_rmk_ordbasic', $t_chitha_rmk_ordbasic);
            //exit;
            // $this->load->helper('html');
            // $this->load->view('../views/header');
            // $this->load->view('../views/misreport/Updatedata');
            // $this->load->view('../views/footer');

            $data['_view'] = 'misreport/Updatedata';
            $this->load->view('layouts/main',$data);
        }
    }

    // public function updatebackchitha() {
	// 	//$db=  $this->session->userdata('db');
    //     //var_dump($this->session->all_userdata());
    //     $case_no = $this->session->userdata('ord_no');
    //     echo $query = "select * from    t_chitha_rmk_ordbasic "
    //     . "where (iscorrected_inco is null or iscorrected_inco=' ') and ord_no='$case_no'   and ord_type_code='04'";
    //     $result = $this->db->query($query)->result();
    //     // exit;
    //     foreach ($result as $order) {
    //         $this->db->trans_begin();
    //         $query_rmk_hist = "select max(rmk_type_hist_no) as c from    chitha_rmk_gen where "
    //                 . "dist_code='$order->dist_code' and subdiv_code='$order->subdiv_code' and cir_code='$order->cir_code'"
    //                 . " and lot_no='$order->lot_no' and mouza_pargona_code='$order->mouza_pargona_code' and "
    //                 . " vill_townprt_code='$order->vill_townprt_code' and dag_no='$order->dag_no' ";
    //         $rmk_hist_no = $this->db->query($query_rmk_hist)->row()->c;
    //         if ($rmk_hist_no == null) {
    //             $rmk_hist_no = 1;
    //         } else
    //             $rmk_hist_no += 1;
    //         $q = "select max(ord_cron_no)+1 as c1,max(rmk_type_hist_no)+1 as c2 from    chitha_rmk_ordbasic where "
    //                 . "dist_code='$order->dist_code' and subdiv_code='$order->subdiv_code' and cir_code='$order->cir_code'"
    //                 . " and lot_no='$order->lot_no' and mouza_pargona_code='$order->mouza_pargona_code' and "
    //                 . " vill_townprt_code='$order->vill_townprt_code' and dag_no='$order->dag_no' ";
    //         $ord_cron_no = $this->db->query($q)->row()->c1;
    //         if ($ord_cron_no == null) {
    //             $ord_cron_no = 1;
    //         } else {
    //             $ord_cron_no+=1;
    //         }
    //         $infavQuery = "select * from    t_chitha_rmk_infavor_of where ord_no='$order->ord_no' and iscorrected_inco is null ";
    //         $infavData = $this->db->query($infavQuery)->result();
    //         $pdar_id = 1;
    //         $chitha_basic_update = 0;
    //         foreach ($infavData as $d) {
    //             $landclass_query = "select land_class_code from    chitha_basic  where dist_code='$d->dist_code' and"
    //                     . " subdiv_code='$d->subdiv_code' and cir_code='$order->cir_code'"
    //                     . " and lot_no='$d->lot_no' and mouza_pargona_code='$d->mouza_pargona_code' and "
    //                     . " vill_townprt_code='$d->vill_townprt_code' and dag_no='$d->dag_no' "
    //                     . " and patta_type_code='$d->patta_type_code' and TRIM(patta_no)=trim('$d->patta_no')";
    //             //$landclass_query;
    //             $landclasscode = $this->db->query($landclass_query)->row()->land_class_code;
    //             // for chitha update
    //             if ($chitha_basic_update == 0) {
    //                 $chitha_basic = array(
    //                     'dist_code' => $d->dist_code,
    //                     'subdiv_code' => $d->subdiv_code,
    //                     'cir_code' => $d->cir_code,
    //                     'mouza_pargona_code' => $d->mouza_pargona_code,
    //                     'lot_no' => $d->lot_no,
    //                     'vill_townprt_code' => $d->vill_townprt_code,
    //                     'old_dag_no' => $d->dag_no,
    //                     'dag_no' => $d->new_dag_no,
    //                     'dag_no_int' => $d->new_dag_no . '00',
    //                     'patta_type_code' => $d->patta_type_code,
    //                     'patta_no' => trim($d->new_patta_no),
    //                     'land_class_code' => $landclasscode,
    //                     'dag_area_b' => $d->land_area_b,
    //                     'dag_area_k' => $d->land_area_k,
    //                     'dag_area_lc' => $d->land_area_lc,
    //                     'dag_area_g' => 0.0,
    //                     'dag_area_kr' => 0,
    //                     'dag_revenue' => $d->revenue,
    //                     'dag_local_tax' => ($d->revenue) / 4,
    //                     'user_code' => $this->session->userdata('user_code'),
    //                     'date_entry' => date('Y-m-d G:i:s'),
    //                     'operation' => 'E',
    //                     'jama_yn' => 'n',
    //                     'old_patta_no' => trim($d->patta_no)
    //                 );
    //                 // var_dump($chitha_basic);
    //                 echo $this->db->insert('chitha_basic', $chitha_basic);
    //                 $chitha_basic_update = 1;

    //                 $landArea_query = "select dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,dag_revenue,dag_local_tax from    chitha_basic"
    //                         . "  where dist_code='$d->dist_code' and  "
    //                         . " subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code'"
    //                         . " and lot_no='$d->lot_no' and mouza_pargona_code='$d->mouza_pargona_code' and "
    //                         . " vill_townprt_code='$d->vill_townprt_code' and dag_no='$d->dag_no'  "
    //                         . " and TRIM(patta_no)=trim('$d->patta_no') and patta_type_code='$d->patta_type_code'";
    //                 $landArea_query . "<br>";
    //                 $sourceB = $this->db->query($landArea_query)->row()->dag_area_b;
    //                 $sourceK = $this->db->query($landArea_query)->row()->dag_area_k;
    //                 $sourceL = $this->db->query($landArea_query)->row()->dag_area_lc;
    //                 $sourceRev = $this->db->query($landArea_query)->row()->dag_revenue;
    //                 $sourceLTax = $this->db->query($landArea_query)->row()->dag_local_tax;
    //                 $sourceLessa = $sourceB * 100 + $sourceK * 20 + $sourceL;
    //                 $targetLessa = $d->land_area_b * 100 + $d->land_area_k * 20 + $d->land_area_lc;
    //                 $remLessa = $sourceLessa - $targetLessa;
    //                 $new_revenue = ($sourceRev / $sourceLessa) * $remLessa;
    //                 $new_local_tax = ($new_revenue / 4);
    //                 $b = floor($remLessa / 100.0);
    //                 $k = ($remLessa - $b * 100.0) / 20.0; //0
    //                 $k = floor($k);
    //                 $lc = ($remLessa - $b * 100.0 - $k * 20.0);
    //                 $g = 0.0;
    //                 $kr = 0.0;
    //                 $dag_no_int = $d->dag_no . "00";
    //                 $chitha_update = "update chitha_basic set dag_area_b='$b',dag_area_k='$k',"
    //                         . " dag_area_lc='$lc',dag_area_g='$g',dag_area_kr='$kr',dag_revenue='$new_revenue',dag_local_tax='$new_local_tax',jama_yn='n'  where dist_code='$d->dist_code' and"
    //                         . " subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code'"
    //                         . " and lot_no='$d->lot_no' and mouza_pargona_code='$d->mouza_pargona_code' and "
    //                         . " vill_townprt_code='$d->vill_townprt_code' and dag_no='$d->dag_no' and dag_no_int=$dag_no_int  "
    //                         . " and TRIM(patta_no)=trim('$d->patta_no') and patta_type_code='$d->patta_type_code'";
    //                 // echo $chitha_update;
    //                 $this->db->query($chitha_update);
    //             }
    //             // end chitha update

    //             $data = array(
    //                 'pdar_name' => $d->infavor_of_name,
    //                 'pdar_father' => $d->infavor_of_guardian,
    //                 'patta_no' => trim($d->new_patta_no),
    //                 'patta_type_code' => $d->patta_type_code,
    //                 'pdar_add1' => $d->infavor_of_add1,
    //                 'pdar_add2' => $d->infavor_of_add2,
    //                 'user_code' => $this->session->userdata('user_code'),
    //                 'date_entry' => date('Y-m-d G:i:s'),
    //                 'operation' => 'E',
    //                 'pdar_guard_reln' => $d->infav_of_guar_relation,
    //                 'dist_code' => $d->dist_code,
    //                 'subdiv_code' => $d->subdiv_code,
    //                 'cir_code' => $d->cir_code,
    //                 'mouza_pargona_code' => $d->mouza_pargona_code,
    //                 'lot_no' => $d->lot_no,
    //                 'vill_townprt_code' => $d->vill_townprt_code,
    //                 'pdar_id' => $d->pdar_id,
    //                 'new_pdar_name' => 'N',
    //                 'jama_yn' => 'n',
    //                 'pdar_gender' => $d->infavor_of_gender,
    //                 'pdar_mother' => $d->infavor_of_mother
    //             );
    //             //var_dump($data);
    //             $dag_pattadar = array(
    //                 'dist_code' => $d->dist_code,
    //                 'subdiv_code' => $d->subdiv_code,
    //                 'cir_code' => $d->cir_code,
    //                 'mouza_pargona_code' => $d->mouza_pargona_code,
    //                 'lot_no' => $d->lot_no,
    //                 'vill_townprt_code' => $d->vill_townprt_code,
    //                 'pdar_id' => $d->pdar_id,
    //                 'patta_no' => trim($d->new_patta_no),
    //                 'dag_no' => $d->new_dag_no,
    //                 'patta_type_code' => $d->patta_type_code,
    //                 'dag_por_b' => $d->land_area_b,
    //                 'dag_por_k' => $d->land_area_k,
    //                 'dag_por_lc' => $d->land_area_lc,
    //                 'dag_por_g' => 0.0,
    //                 'dag_por_kr' => 0,
    //                 'pdar_land_revenue' => $d->revenue,
    //                 'pdar_land_localtax' => ($d->revenue) / 4,
    //                 'user_code' => $this->session->userdata('user_code'),
    //                 'date_entry' => date('Y-m-d G:i:s'),
    //                 'operation' => 'E'
    //             );
    //             // var_dump($dag_pattadar);
    //             $pdar_id++;
    //             echo $this->db->insert('chitha_dag_pattadar', $dag_pattadar) . "<br>";
    //             echo $this->db->insert('chitha_pattadar', $data) . "cp";
    //             if ($d->pdar_strike == 'Y') {
    //                 $p_flag = '0';
    //             } else {
    //                 $p_flag = '1';
    //             }
    //             $updateQuery = "update chitha_dag_pattadar set p_flag = '$p_flag' where dist_code='$d->dist_code' and"
    //                     . " subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code' and lot_no='$d->lot_no' and "
    //                     . " mouza_pargona_code = '$d->mouza_pargona_code' and vill_townprt_code='$d->vill_townprt_code' and"
    //                     . " dag_no ='$d->dag_no' and TRIM(patta_no)=trim('$d->patta_no') and patta_type_code='$d->patta_type_code' and pdar_id = '$d->pdar_id' ";
    //             // echo $updateQuery . "<br>";
    //             echo $this->db->query($updateQuery) . "dp";


    //             unset($d->year_no);
    //             unset($d->petition_no);
    //             unset($d->pdar_id);
    //             unset($d->revenue);
    //             unset($d->iscorrected_inco);
    //             unset($d->iscorrected_inco_date);
    //             unset($d->iscorrected_rkg_record);
    //             unset($d->iscorrected_rkg_date);
    //             unset($d->infavor_is_copdar);
    //             unset($d->make_mdb);
    //             unset($d->new_pattadar);
    //             unset($d->make_mdb);
    //             unset($d->make_mdb);
    //             unset($d->make_mdb);
    //             unset($d->make_mdb);
    //             $d->rmk_type_hist_no = $rmk_hist_no;
    //             $d->ord_cron_no = $ord_cron_no;
    //             $d->user_code = $this->session->userdata('user_code');
    //             $d->operation = 'E';
    //             $d->date_entry = date('Y-m-d G:i:s');
    //             unset($d->pdar_strike);
    //             unset($d->infavor_of_gender);
    //             unset($d->infavor_of_mother);
    //             echo $this->db->insert('chitha_rmk_infavor_of', $d) . "up";
    //         }

    //         unset($order->year_no);
    //         unset($order->petition_no);

    //         unset($order->petition_no);

    //         unset($order->iscorrected_inco);
    //         unset($order->iscorrected_inco_date);
    //         unset($order->iscorrected_rkg_record);
    //         unset($order->iscorrected_rkg_date);
    //         unset($order->pdar_id);
    //         unset($order->ord_onbehalf_guard);
    //         unset($order->ord_onbehalf_add1);
    //         unset($order->ord_onbehalf_add2);
    //         unset($order->make_mdb);
    //         unset($order->is_converted_pattadar);
    //         unset($order->patta_type_code);
    //         unset($order->patta_no);
    //         unset($order->ord_onbehalf_id);
    //         unset($order->ord_onbehalf_of);
    //         unset($order->land_class_code);
    //         unset($order->land_area_b);
    //         unset($order->land_area_k);
    //         unset($order->land_area_lc);
    //         unset($order->min_revenue);
    //         unset($order->ifyes_reason3);
    //         unset($order->ifyes_reason2);
    //         unset($order->ifyes_reason1);
    //         unset($order->isorder_cancelled);
    //         unset($order->isdataposted_torkg_db);

    //         $order->ord_cron_no = $ord_cron_no;
    //         $order->rmk_type_hist_no = $rmk_hist_no;
    //         $order->user_code = $this->session->userdata('user_code');
    //         $order->operation = 'E';
    //         $order->date_entry = $ord->ord_date;
    //         $order->area_left_b = 0;
    //         $order->area_left_k = 0;
    //         $order->area_left_lc = 0;
    //         $order->area_left_g = 0;
    //         $order->area_left_kr = 0;


    //         $rmk_gen = array(
    //             'dist_code' => $order->dist_code,
    //             'subdiv_code' => $order->subdiv_code,
    //             'cir_code' => $order->cir_code,
    //             'mouza_pargona_code' => $order->mouza_pargona_code,
    //             'vill_townprt_code' => $order->vill_townprt_code,
    //             'lot_no' => $order->lot_no,
    //             'dag_no' => $order->dag_no,
    //             'rmk_type_code' => '01',
    //             'rmk_type_hist_no' => $rmk_hist_no,
    //             'user_code' => $this->session->userdata('user_code'),
    //             'operation' => 'E',
    //             'date_entry' => date('Y-m-d G:i:s'),
    //             'jama_updated' => 'n',
    //             'new_dag_no' => $order->new_dag_no
    //         );
    //         // $newDag=$order->new_dag_no;
    //         //var_dump($rmk_gen);
    //         // exit;
    //         echo $this->db->insert('chitha_rmk_gen', $rmk_gen) . "done";
    //         var_dump($order);
    //         echo $this->db->insert('chitha_rmk_ordbasic', $order);
    //         $d = date('Y-m-d');
    //         $update_q = "update t_chitha_rmk_ordbasic set iscorrected_inco='Y',iscorrected_inco_date='$d'"
    //                 . " where ord_no='$order->ord_no'  ";
    //         echo $this->db->query($update_q);
    //         $update_q = "update t_chitha_rmk_infavor_of set iscorrected_inco='Y',iscorrected_inco_date='$d'"
    //                 . " where ord_no='$order->ord_no'  ";
    //         echo $this->db->query($update_q) . "last";
    //         exit;
    //         if ($this->db->trans_status() == FALSE) {
    //             $this->db->trans_rollback();
    //             echo "Error Occured";
    //         } else {
    //             //echo "wht";
    //             //$data['newdagno'] = array('newdag' => $newDag);
    //             $this->session->set_flashdata('message', "New Case with Case number $case_no has Registered");
    //             redirect(base_url() . "index.php/home/index");
    //         }
    //     }
    // }

    ///////////////////
    public function MisTeaReport() {
		// $db=  $this->session->userdata('db');
  //       $this->load->helper('html');
  //       $this->load->view('../views/header');
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

        // $this->load->view('../views/misreport/misreportTeaEstate', $district);
        // $this->load->view('../views/footer');

        $district['_view'] = 'misreport/misreportTeaEstate';
        $this->load->view('layouts/main',$district);
    }

    public function saveTeaEstateReport() {
		// $db=  $this->session->userdata('db');
  //       $this->load->helper('html');
  //       $this->load->view('../views/header');
  //       $this->load->view('../views/misreport/saveteaestatereport');
  //       $this->load->view('../views/footer');

        $data['_view'] = 'misreport/saveteaestatereport';
        $this->load->view('layouts/main',$data);
    }

    public function LandRevenueTeaEstate() {
		// $db=  $this->session->userdata('db');
  //       $this->load->helper('html');
  //       $this->load->view('../views/header');
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
        // $this->load->view('../views/misreport/landrevenueteaestate', $district);
        // $this->load->view('../views/footer');

        $district['_view'] = 'misreport/landrevenueteaestate';
        $this->load->view('layouts/main',$district);
    }

    /*
      public  function DisplayReport() {
      $this->load->model('misreport/misreport');
      $this->data['posts'] = $this->misreport->getPosts();
      $this->load->view('../misreport/saveLandRevenueTeaEstateReport', $this->data);
      }
     */

    public function saveLandRevenueTeaEstateReport() {
		//$db=  $this->session->userdata('db');
        $this->load->model('misreport/misreport');
        $data1 = $this->misreport->getPosts();
        //print_r($data);
        if ($data1 != 0) {
            // $this->load->helper('html');
            // $this->load->view('../views/header');
            // $this->load->view('../misreport/savelandrevenueteaestatereport', $data1);
            // $this->load->view('../views/footer');

        $data1['_view'] = 'misreport/savelandrevenueteaestatereport';
        $this->load->view('layouts/main',$data1);
        }
    }

    public function LandRevenueNisKheEstate() {
		// $db=  $this->session->userdata('db');
  //       $this->load->helper('html');
  //       $this->load->view('../views/header');
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
        // $this->load->view('../views/misreport/landrevenuenisfikheraj', $district);
        // $this->load->view('../views/footer');

        $district['_view'] = 'misreport/landrevenuenisfikheraj';
        $this->load->view('layouts/main',$district);
    }

    public function savelandrevenuenisfikheraj() {
		// $db=  $this->session->userdata('db');
  //       $this->load->helper('html');
  //       $this->load->view('../views/header');
  //       $this->load->view('../views/misreport/savelandrevenuenisfikheraj');
  //       $this->load->view('../views/footer');

        $data['_view'] = 'misreport/savelandrevenuenisfikheraj';
        $this->load->view('layouts/main',$data);
    }

    public function LandRevenueLaKheEstate() {
		// $db=  $this->session->userdata('db');
  //       $this->load->helper('html');
  //       $this->load->view('../views/header');
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
        // $this->load->view('../views/misreport/landrevenuelakheraj', $district);
        // $this->load->view('../views/footer');

        $district['_view'] = 'misreport/landrevenuelakheraj';
        $this->load->view('layouts/main',$district);
    }

    public function savelandrevenuelakheraj() {
		// $db=  $this->session->userdata('db');
  //       $this->load->helper('html');
  //       $this->load->view('../views/header');
  //       $this->load->view('../views/misreport/savelandrevenuelakheraj');
  //       $this->load->view('../views/footer');

        $data['_view'] = 'misreport/landrevenuelakheraj';
        $this->load->view('layouts/main',$data);
    }

    public function LandRevenueEstimateRevenue() {
		//$db=  $this->session->userdata('db');
        $district[] = array();
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
        // $this->load->helper('html');
        // $this->load->view('../views/header');

        // $this->load->view('../views/misreport/landrevenueestimaterevenue', $district);
        // $this->load->view('../views/footer');

        $district['_view'] = 'misreport/landrevenueestimaterevenue';
        $this->load->view('layouts/main',$district);
    }

    public function saveestimaterevenue() {
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/saveestimaterevenue');
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/saveestimaterevenue';
        $this->load->view('layouts/main',$data);
    }

    //
    public function VillageLandScenario() {
		// $db=  $this->session->userdata('db');
  //       $this->load->helper('html');
  //       $this->load->view('../views/header');
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
        // $this->load->view('../views/misreport/villagelandscenario', $district);
        // $this->load->view('../views/footer');

        $district['_view'] = 'misreport/villagelandscenario';
        $this->load->view('layouts/main',$district);
    }

    public function savevillageland() {
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/savevillageland');
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/savevillageland';
        $this->load->view('layouts/main',$data); 
    }

    public function VillageLandScenarioOnLandClass() {
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
        // $this->load->view('../views/misreport/villagelandscenariolandclass', $district);
        // $this->load->view('../views/footer');
         $district['_view'] = 'misreport/villagelandscenariolandclass';
        $this->load->view('layouts/main',$district);
    }

    public function MonthlyAccMutPartConv() {
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        $data = $this->mutationmodel->getDistricts();
        $district['names'] = $data;
        // $this->load->view('../views/misreport/MonthlyAccMutPartConv', $district);
        // $this->load->view('../views/footer');

        $district['_view'] = 'misreport/MonthlyAccMutPartConv';
        $this->load->view('layouts/main',$district);
    }

    public function saveMonthlyMutPartConv() {
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/saveMonthlyMutPartConv');
        // $this->load->view('../views/footer');

         $data['_view'] = 'misreport/saveMonthlyMutPartConv';
        $this->load->view('layouts/main',$data); 
    }

    public function MonthlyReportConversion() {
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
        // $this->load->view('../views/misreport/MonthlyReportConversion', $district);
        // $this->load->view('../views/footer');

        $district['_view'] = 'misreport/MonthlyReportConversion';
        $this->load->view('layouts/main',$district);
    }

    public function ConversionArrearPremium() {
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
        // $this->load->view('../views/misreport/ConversionArrearPremium', $district);
        // $this->load->view('../views/footer');

        $district['_view'] = 'misreport/ConversionArrearPremium';
        $this->load->view('layouts/main',$district);
    }

    public function saveMonthlyReportConv() {
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/saveMonthlyReportConv');
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/saveMonthlyReportConv';
        $this->load->view('layouts/main',$data);
    }

    public function MonthlyCitizenCentricService() {
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
        // $this->load->view('../views/misreport/MonthlyCitizenCentricService', $district);
        // $this->load->view('../views/footer');

        $district['_view'] = 'misreport/MonthlyCitizenCentricService';
        $this->load->view('layouts/main',$district);
    }

    public function MonthlyCitizenCentricServiceYearly() {
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
        // $this->load->view('../views/misreport/MonthlyCitizenCentricServiceYearly', $district);
        // $this->load->view('../views/footer');

         $district['_view'] = 'misreport/MonthlyCitizenCentricServiceYearly';
        $this->load->view('layouts/main',$district);
    }

    public function saveCitizenCentricService() {
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/saveCitizenCentricService');
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/saveCitizenCentricService';
        $this->load->view('layouts/main',$data);
    }

    public function saveCitizenCentricServiceYearly() {
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/saveCitizenCentricServiceYearly');
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/saveCitizenCentricServiceYearly';
        $this->load->view('layouts/main',$data);
    }

    public function DoulReport() {
        $district = array();
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
        $data1 = $this->mutationmodel->getPattaType();
        $district['pattas'] = $data1;
        // $this->load->view('../views/misreport/DoulReport', $district);
        // $this->load->view('../views/footer');

         $district['_view'] = 'misreport/DoulReport';
        $this->load->view('layouts/main',$district);
    }

    public function VillWiseGovtLand() {
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
        // $this->load->view('../views/misreport/VillWiseGovtLand', $district);
        // $this->load->view('../views/footer');
        $district['_view'] = 'misreport/VillWiseGovtLand';
        $this->load->view('layouts/main',$district);
    }

    public function saveVillWiseGovtLand() {
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/saveVillWiseGovtLand');
        // $this->load->view('../views/footer');
        $data['_view'] = 'misreport/saveVillWiseGovtLand';
        $this->load->view('layouts/main',$data);
    }

    public function JamaWasil() {
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        $data = $this->mutationmodel->getDistricts();
        $district['names'] = $data;
        // $this->load->view('../views/misreport/JamaWasil', $district);
        // $this->load->view('../views/footer');

        $district['_view'] = 'misreport/JamaWasil';
        $this->load->view('layouts/main',$district);
    }

    public function saveJamaWasil() {
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/saveJamaWasil');
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/saveJamaWasil';
        $this->load->view('layouts/main',$data);
    }

    public function CropWiseLandArea() {
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
        // $this->load->view('../views/misreport/croplandarea', $district);
        // $this->load->view('../views/footer');

        $district['_view'] = 'misreport/croplandarea';
        $this->load->view('layouts/main',$district);
    }

    public function UnderConstruction() {
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/UnderConstruction');
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/UnderConstruction';
        $this->load->view('layouts/main',$data);
    }

    public function savecroplandarea() {
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/savecroplandarea');
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/savecroplandarea';
        $this->load->view('layouts/main',$data);
    }

    public function AreaAgriNonAgri() {
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        $data = $this->mutationmodel->getDistricts();
        $district['names'] = $data;
        // $this->load->view('../views/misreport/areaAgriNonagri', $district);
        // $this->load->view('../views/footer');

        $district['_view'] = 'misreport/areaAgriNonagri';
        $this->load->view('layouts/main',$district);
    }

    public function saveAreaAgriNonAgri() {
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/saveAreaAgriNonAgri');
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/saveAreaAgriNonAgri';
        $this->load->view('layouts/main',$data);
    }

    public function LandAreaNLR() {
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
        // $this->load->view('../views/misreport/LandAreaNLR', $district);
        // $this->load->view('../views/footer');

        $district['_view'] = 'misreport/LandAreaNLR';
        $this->load->view('layouts/main',$district);
    }

    public function ReportMISC() {
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
        // $this->load->view('../views/misreport/miscMothlyReport', $district);
        // $this->load->view('../views/footer');

        $district['_view'] = 'misreport/miscMothlyReport';
        $this->load->view('layouts/main',$district);
    }

    public function DisposeGalance() {
		$db=  $this->session->userdata('db');
        //var_dump($this->session->all_userdata());
        $data = array();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
		$date=define_date;
        $q = "SELECT * FROM  location WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code ='$cir_code'  and Mouza_Pargona_code = '00' and Lot_no= '00' and vill_townprt_code= '00000'";
        $data['loc'] = $values = $this->db->query($q)->row();
        //        Office Cases
        $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$values->cir_code' and mut_type='03' and date(date_entry)>='$date'	 and comp_serv_yn is null ";
        $data['omut'] = $this->db->query($q)->row();
        $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$values->cir_code' and mut_type='03' and (status='P' or status is null) and date(date_entry)>='$date'  and comp_serv_yn is null";
        $data['omutpen'] = $this->db->query($q)->row();
        $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$values->cir_code' and mut_type='03' and (status='D' or status='d' ) and date(date_entry)>='$date' and comp_serv_yn is null";
        $data['omutdev'] = $this->db->query($q)->row();
        $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$values->cir_code' and mut_type='03' and (status ='F' or status ='f') and date(date_entry)>='$date' and comp_serv_yn is null";
        $data['omutfinal'] = $this->db->query($q)->row();

        ////////////////
        $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$values->cir_code' and mut_type='01' and date(date_entry)>='$date' ";
        $data['ocon'] = $OPart = $this->db->query($q)->row();
        $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$values->cir_code' and mut_type='01' and (status='P' or status is null) and date(date_entry)>='$date' ";
        $data['oconpen'] = $this->db->query($q)->row();
        $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$values->cir_code' and mut_type='01' and (status='D' or status='d' ) and date(date_entry)>='$date' ";
        $data['ocondev'] = $this->db->query($q)->row();
        $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$values->cir_code' and mut_type='01' and (status ='F' or status ='f' ) and date(date_entry)>='$date' ";
        $data['oconfinal'] = $this->db->query($q)->row();
        ///////////////
        $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$values->cir_code' and mut_type='04' and date(date_entry)>='$date' and date(date_entry)>='$date' ";
        $data['opart'] = $OConv = $this->db->query($q)->row();
        $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$values->cir_code' and mut_type='04' and (status='P' or status is null) and date(date_entry)>='$date' ";
        $data['opartpen'] = $this->db->query($q)->row();
        $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$values->cir_code' and mut_type='04' and (status='D' or status='d' )  and date(date_entry)>='$date' ";
        $data['opartdev'] = $this->db->query($q)->row();
        $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$values->cir_code' and mut_type='04' and ( status ='F' or status ='f'   )  and date(date_entry)>='$date' ";
        $data['opartfinal'] = $this->db->query($q)->row();

        //        Field Cases
        $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$values->cir_code' and mut_type='01' and date(date_entry)>='$date' ";
        $data['ofcmut'] = $OConv = $this->db->query($q)->row();
        $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$values->cir_code' and mut_type='01' and (order_passed is null and is_dispose is null ) and date(date_entry)>='$date' ";
        $data['ofcmutpen'] = $this->db->query($q)->row();
        $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$values->cir_code' and mut_type='01' and (is_dispose='Y' or is_dispose='y'  ) and date(date_entry)>='$date'";
        $data['ofcmutdev'] = $this->db->query($q)->row();
        $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and  cir_code='$values->cir_code' and  mut_type='01' and (order_passed ='Y' or order_passed ='y'  ) and date(date_entry)>='$date' ";
        $data['ofcmutfinal'] = $this->db->query($q)->row();
        ///////////
        $q = "select count(*) as c from    Field_Mut_Basic where  dist_code='$dist_code' and date(date_entry)>='$date' and subdiv_code='$subdiv_code' and cir_code='$values->cir_code' and mut_type='02'";
        $data['fpart'] = $this->db->query($q)->row();
        $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$date' and subdiv_code='$subdiv_code' and cir_code='$values->cir_code' and mut_type='02' and (order_passed is Null and is_dispose is null) ";
        $data['fpartpen'] = $this->db->query($q)->row();
        $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$date' and subdiv_code='$subdiv_code' and cir_code='$values->cir_code' and mut_type='02' and (is_dispose='Y' or is_dispose='y' )";
        $data['fpartdev'] = $this->db->query($q)->row();
        $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$date' and subdiv_code='$subdiv_code' and cir_code='$values->cir_code' and mut_type='02' and (order_passed ='Y' or order_passed ='y'  )";
        $data['fpartfinal'] = $this->db->query($q)->row();
        //var_dump($data);
        // Reclassfication
        $q = "select count(*) as c from    t_reclassification where dist_code='$dist_code' and date(lm_date)>='$date' and subdiv_code='$subdiv_code' and cir_code='$values->cir_code' ";
        $data['t_reclass_tot'] = $this->db->query($q)->row();
        $q = "select count(*) as c from    t_reclassification where dist_code='$dist_code' and date(lm_date)>='$date' and subdiv_code='$subdiv_code' and cir_code='$values->cir_code' and  (rkg_chitha_updated_yn is null and co_chitha_updated_yn is null) and co_yn is null and dc_yn is null and (status != 'R' and status!='M' OR status is null OR status='C') ";
        $data['t_reclass_pen'] = $this->db->query($q)->row();
        $q = "select count(*) as c from    t_reclassification where dist_code='$dist_code' and date(lm_date)>='$date' and subdiv_code='$subdiv_code' and cir_code='$values->cir_code' and (rkg_chitha_updated_yn ='Y' and co_chitha_updated_yn ='Y')";
        $data['t_reclass_dev'] = $this->db->query($q)->row();
        $q = "select count(*) as c from    t_reclassification where dist_code='$dist_code' and date(lm_date)>='$date' and subdiv_code='$subdiv_code' and cir_code='$values->cir_code' and co_yn='N' ";
        $data['t_reclass_dispose'] = $this->db->query($q)->row();
        // End Reclassfication     
        // NR Case
        $q = "select count(*) as c from    apcancel_petition_basic where dist_code='$dist_code' and date(submission_date)>='$date' and subdiv_code='$subdiv_code' and cir_code='$values->cir_code' ";
        //echo $q;
        $data['nr_tot'] = $this->db->query($q)->row();
        $q = "select count(*) as c from    apcancel_petition_basic where dist_code='$dist_code' and date(submission_date)>='$date' and subdiv_code='$subdiv_code' and cir_code='$values->cir_code' and  status ='P' and order_passed is null  ";
        $data['nr_pen'] = $this->db->query($q)->row();
        $q = "select count(*) as c from    apcancel_petition_basic where dist_code='$dist_code' and date(submission_date)>='$date' and subdiv_code='$subdiv_code' and cir_code='$values->cir_code' and order_passed ='Y' ";
        $data['nr_dev'] = $this->db->query($q)->row();
        $q = "select count(*) as c from    apcancel_petition_basic where dist_code='$dist_code' and date(submission_date)>='$date' and subdiv_code='$subdiv_code' and cir_code='$values->cir_code' and status='X' ";
        $data['nr_dispose'] = $this->db->query($q)->row();
        // // End NR Case
        // Misc Case
        $q = "select count(*) as c from    misc_case_basic where dist_code='$dist_code' and date(submission_date)>='$date' and subdiv_code='$subdiv_code' and cir_code='$values->cir_code' ";
        $data['misccase_tot'] = $this->db->query($q)->row();
        $q = "select count(*) as c from    misc_case_basic where dist_code='$dist_code' and date(submission_date)>='$date' and subdiv_code='$subdiv_code' and cir_code='$values->cir_code' and  (status !='10'  or status ='11'  )  ";
        $data['misccase_pen'] = $this->db->query($q)->row();
        $q = "select count(*) as c from    misc_case_basic where dist_code='$dist_code' and date(submission_date)>='$date' and subdiv_code='$subdiv_code' and cir_code='$values->cir_code' and   status ='10'  ";
        $data['misccase_dev'] = $this->db->query($q)->row();
        $q = "select count(*) as c from    misc_case_basic where dist_code='$dist_code' and date(submission_date)>='$date' and subdiv_code='$subdiv_code' and cir_code='$values->cir_code' and   status ='11'   ";
        $data['misccase_dispose'] = $this->db->query($q)->row();
        log_message('error','001'.LQ);
        // End Misc Case


        // AC to PP Case
        $q = "select count(*) as c from    allotment_cert_basic where dist_code='$dist_code' and date(date_entry)>='$date' and subdiv_code='$subdiv_code' and circle_code='$values->cir_code' ";
        $data['acpp_tot'] = $this->db->query($q)->row();
        //log_message('error',LQ);
        $q = "select count(*) as c from    allotment_cert_basic where dist_code='$dist_code' and date(date_entry)>='$date' and subdiv_code='$subdiv_code' and circle_code='$values->cir_code' and  (status='P' OR status ='R' OR status is null)  ";
        $data['acpp_pen'] = $this->db->query($q)->row();
        $q = "select count(*) as c from    allotment_cert_basic where dist_code='$dist_code' and date(date_entry)>='$date' and subdiv_code='$subdiv_code' and circle_code='$values->cir_code' and   status ='F' and chitha_correct_yn is not null and dc_code is not null";
        $data['acpp_dev'] = $this->db->query($q)->row();
        $q = "select count(*) as c from    allotment_cert_basic where dist_code='$dist_code' and date(date_entry)>='$date' and subdiv_code='$subdiv_code' and circle_code='$values->cir_code' and status ='D'";
        $data['acpp_dispose'] = $this->db->query($q)->row();
        // End AC to PP Case
        ////////////////////Settlement/////////////////////////
        $q="SELECT
            (SELECT COUNT(*) FROM settlement_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  CAST(date_entry AS DATE) >= '$date') AS total,
            (SELECT COUNT(*) FROM settlement_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  status = 'F' and CAST(date_entry AS DATE) >= '$date') AS passed,
            (SELECT COUNT(*) FROM settlement_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  status = 'D' and CAST(date_entry AS DATE) >= '$date') AS rejected,
            (SELECT COUNT(*) FROM settlement_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  status NOT IN ('D', 'F') and CAST(date_entry AS DATE) >= '$date') AS pending";
        $data['settlement'] = $this->db->query($q)->row();
        //////////////////////Composite Service///////////////////////
        $sql="SELECT 
            count(*) FILTER (WHERE status = 'F') as delivered,
            count(*) FILTER (WHERE status = 'P') as pending,
            count(*) FILTER (WHERE status = 'D') as disposed,
            count(*) as total
        from petition_basic where comp_serv_yn='Y' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  CAST(submission_date AS DATE) >= '$date' 
        ";
        $data['composite'] = $this->db->query($sql)->row();
        /////////////////////////////////////////////
        //var_dump($data);
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/diposecase_01', $data);
        // $this->load->view('../views/footer');


        $data['_view'] = 'misreport/diposecase_01';
        $this->load->view('layouts/main',$data);
    }

    public function DisposeGalanceDCLAO() {
		//$db=  $this->session->userdata('db');
        //var_dump($this->session->all_userdata());
        $data = array();
        $dist_code = $this->session->userdata('dist_code');
		$define_date=define_date;
        //$subdiv_code=$this->session->userdata('subdiv_code');
        //$cir_code=$this->session->userdata('cir_code');
        $q = "SELECT * FROM location WHERE dist_code='$dist_code' and subdiv_code !='00' and cir_code !='00'  and Mouza_Pargona_code = '00' and Lot_no= '00' and vill_townprt_code= '00000'";
        $data['loc'] = $location = $this->db->query($q)->result();
        foreach ($location as $loc) {
            //   var_dump($loc);
            $subdiv_code = $loc->subdiv_code;
            $cir_code = $loc->cir_code;
            //        Office Cases
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='03'";
            $data['omut'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='03' and (status='P' or status is null) ";
            $data['omutpen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='03' and (status='D' or status='d' )";
            $data['omutdev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='03' and (status ='F' or status ='f') ";
            $data['omutfinal'][] = $this->db->query($q)->row();

            ////////////////
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='01'";
            $data['ocon'][] = $OPart = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='01' and (status='P' or status is null) ";
            $data['oconpen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='01' and (status='D' or status='d' ) ";
            $data['ocondev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='01' and (status ='F' or status ='f' )  ";
            $data['oconfinal'][] = $this->db->query($q)->row();
            ///////////////
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='04'";
            $data['opart'][] = $OConv = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='04' and (status='P' or status is null) ";
            $data['opartpen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='04' and (status='D' or status='d' ) ";
            $data['opartdev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='04' and ( status ='F' or status ='f'   )  ";
            $data['opartfinal'][] = $this->db->query($q)->row();

            //        Field Cases
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='01' ";
            $data['ofcmut'][] = $OConv = $this->db->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='01' and (order_passed is null and is_dispose is null ) ";
            $data['ofcmutpen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='01' and (is_dispose='Y' or is_dispose='y'  )";
            $data['ofcmutdev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and  cir_code='$cir_code' and  mut_type='01' and (order_passed ='Y' or order_passed ='y'  ) ";
            $data['ofcmutfinal'][] = $this->db->query($q)->row();
            ///////////
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='02'";
            $data['fpart'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='02' and (order_passed is Null and is_dispose is null) ";
            $data['fpartpen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='02' and (is_dispose='Y' or is_dispose='y' )";
            $data['fpartdev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='02' and (order_passed ='Y' or order_passed ='y'  )";
            $data['fpartfinal'][] = $this->db->query($q)->row();

            // Reclassfication
            $q = "select count(*) as c from    t_reclassification where dist_code='$dist_code' and date(lm_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
            $data['t_reclass_tot'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    t_reclassification where dist_code='$dist_code' and date(lm_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  (rkg_chitha_updated_yn is null and co_chitha_updated_yn is null) ";
            $data['t_reclass_pen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    t_reclassification where dist_code='$dist_code' and date(lm_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (rkg_chitha_updated_yn='Y' and co_chitha_updated_yn='Y')";
            $data['t_reclass_dev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    t_reclassification where dist_code='$dist_code' and subdiv_code='$subdiv_code' and date(lm_date)>='$define_date' and cir_code='$cir_code' and co_yn='N' ";
            $data['t_reclass_dispose'][] = $this->db->query($q)->row();
            // End Reclassfication     
            // NR Case
            $q = "select count(*) as c from    apcancel_petition_basic where dist_code='$dist_code' and date(submission_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
            $data['nr_tot'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    apcancel_petition_basic where dist_code='$dist_code' and date(submission_date)>='$define_date'  and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  status ='P' and order_passed is null  ";
            $data['nr_pen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    apcancel_petition_basic where dist_code='$dist_code' and date(submission_date)>='$define_date'  and subdiv_code='$subdiv_code' and cir_code='$cir_code' and order_passed ='Y' ";
            $data['nr_dev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    apcancel_petition_basic where dist_code='$dist_code' and date(submission_date)>='$define_date'  and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='X' ";
            $data['nr_dispose'][] = $this->db->query($q)->row();
            // // End NR Case
            // Misc Case
            $q = "select count(*) as c from    misc_case_basic where dist_code='$dist_code' and date(submission_date)>='$define_date'  and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
            $data['misccase_tot'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    misc_case_basic where dist_code='$dist_code' and date(submission_date)>='$define_date'  and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  (status !='10'  or status ='11'  )  ";
            $data['misccase_pen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    misc_case_basic where dist_code='$dist_code' and date(submission_date)>='$define_date'  and subdiv_code='$subdiv_code' and cir_code='$cir_code' and   status ='10'  ";
            $data['misccase_dev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    misc_case_basic where dist_code='$dist_code' and date(submission_date)>='$define_date'  and subdiv_code='$subdiv_code' and cir_code='$cir_code' and   status ='11'   ";
            $data['misccase_dispose'][] = $this->db->query($q)->row();
            // End Misc Case
        }
        //var_dump($data);
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/diposecase_dclao_01', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/diposecase_dclao_01';
        $this->load->view('layouts/main',$data);
    }

    public function DisposeMouzawise() {
		$db=  $this->session->userdata('db');
        $data = array();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $data['locdata'] = array(
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code
        );
		$define_date=define_date;
        $q = "SELECT * FROM  location WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code = '$cir_code' and Mouza_Pargona_code <> '00' and Lot_no= '00' and vill_townprt_code= '00000'";
        $data['loc'] = $values = $this->db->query($q)->result();
        foreach ($values as $v) {

            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and mut_type='03'";
            $data['omut'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and mut_type='03' and (status='P' or status is null) ";
            $data['omutpen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and mut_type='03' and (status='D' or status='d') ";
            $data['omutdev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and mut_type='03' and (status ='F' or status ='f') ";
            $data['omutfinal'][] = $this->db->query($q)->row();
            ///////////////
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and mut_type='01'";
            $data['ocon'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and mut_type='01' and (status='P' or status is null) ";
            $data['oconpen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and mut_type='01' and (status='D' or status='d') ";
            $data['ocondev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and mut_type='01' and (status ='F' or status ='f') ";
            $data['oconfinal'][] = $this->db->query($q)->row();
            ////////////////////
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and mut_type='04'";
            $data['opart'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and mut_type='04' and (status='P' or status is null) ";
            $data['opartpen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and mut_type='04' and (status='D' or status='d') ";
            $data['opartdev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and mut_type='04' and (status ='F' or status ='f') ";
            $data['opartfinal'][] = $this->db->query($q)->row();
            // field cases
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and mut_type='01'";
            $data['fmut'][] = $OConv = $this->db->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and mut_type='01' and (order_passed is null and is_dispose is null) ";
            $data['fmutpen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and mut_type='01' and (is_dispose='Y' or is_dispose='y' )";
            $data['fmutdev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and  cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and  mut_type='01' and (order_passed ='Y' or order_passed ='y'  ) ";
            $data['fieldmutfinal'][] = $this->db->query($q)->row();
            //////////////

            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and mut_type='02'";
            $data['fpart'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and mut_type='02' and (order_passed is null and is_dispose is null) ";
            $data['fpartpen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and mut_type='02' and (is_dispose='Y' or is_dispose='y' )";
            $data['fpartdev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and mut_type='02' and (order_passed ='Y' or order_passed ='y'  ) ";
            $data['fieldpartfinal'][] = $this->db->query($q)->row();


            // Reclassfication
            $q = "select count(*) as c from    t_reclassification where dist_code='$dist_code' and date(lm_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' ";
            $data['t_reclass_tot'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    t_reclassification where dist_code='$dist_code' and date(lm_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and  (rkg_chitha_updated_yn is null and co_chitha_updated_yn is null) ";
            $data['t_reclass_pen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    t_reclassification where dist_code='$dist_code' and date(lm_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and (rkg_chitha_updated_yn='Y' and co_chitha_updated_yn='Y')";
            $data['t_reclass_dev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    t_reclassification where dist_code='$dist_code' and date(lm_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and co_yn='N' ";
            $data['t_reclass_dispose'][] = $this->db->query($q)->row();
            // End Reclassfication     
            // NR Case
            $q = "select count(*) as c from    apcancel_petition_basic where dist_code='$dist_code' and date(submission_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' ";
            $data['nr_tot'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    apcancel_petition_basic where dist_code='$dist_code' and date(submission_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and  status ='P' and order_passed is null  ";
            $data['nr_pen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    apcancel_petition_basic where dist_code='$dist_code' and date(submission_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and order_passed ='Y' ";
            $data['nr_dev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    apcancel_petition_basic where dist_code='$dist_code' and date(submission_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and status='X' ";
            $data['nr_dispose'][] = $this->db->query($q)->row();
            // // End NR Case
            // Misc Case
            $q = "select count(*) as c from    misc_case_basic where dist_code='$dist_code' and date(submission_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' ";
            $data['misccase_tot'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    misc_case_basic where dist_code='$dist_code' and date(submission_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and  (status !='10'  or status ='11'  )  ";
            $data['misccase_pen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    misc_case_basic where dist_code='$dist_code' and date(submission_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and   status ='10'  ";
            $data['misccase_dev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    misc_case_basic where dist_code='$dist_code' and  date(submission_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and   status ='11'   ";
            $data['misccase_dispose'][] = $this->db->query($q)->row();
            // End Misc Case


            // AC to PP Case
            $q = "select count(*) as c from    allotment_cert_basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and mouza_pargona_code='$v->mouza_pargona_code' ";
            $data['actopp_tot'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    allotment_cert_basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and mouza_pargona_code='$v->mouza_pargona_code' and  (status ='P'  or status ='R' or status is null  )  ";
            $data['actopp_pen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    allotment_cert_basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and mouza_pargona_code='$v->mouza_pargona_code' and status ='F' and chitha_correct_yn is not null and dc_code is not null";
            $data['actopp_dev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    allotment_cert_basic where dist_code='$dist_code' and  date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and mouza_pargona_code='$v->mouza_pargona_code' and status ='D'";
            $data['actopp_dispose'][] = $this->db->query($q)->row();

            // End AC to PP Case
            ////////////////////Settlement/////////////////////////
            $q="SELECT
                (SELECT COUNT(*) FROM settlement_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$v->mouza_pargona_code' and  CAST(date_entry AS DATE) >= '$define_date') AS total,
                (SELECT COUNT(*) FROM settlement_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$v->mouza_pargona_code' and  status = 'F' and CAST(date_entry AS DATE) >= '$define_date') AS passed,
                (SELECT COUNT(*) FROM settlement_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$v->mouza_pargona_code' and  status = 'D' and CAST(date_entry AS DATE) >= '$define_date') AS rejected,
                (SELECT COUNT(*) FROM settlement_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$v->mouza_pargona_code' and  status NOT IN ('D', 'F') and CAST(date_entry AS DATE) >= '$define_date') AS pending";
            $data['settlement'][] = $this->db->query($q)->row();
            //////////////////////Composite Service///////////////////////
            $sql="SELECT 
                count(*) FILTER (WHERE status = 'F') as delivered,
                count(*) FILTER (WHERE status = 'P') as pending,
                count(*) FILTER (WHERE status = 'D') as disposed,
                count(*) as total
            from petition_basic where comp_serv_yn='Y' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$v->mouza_pargona_code' and  CAST(submission_date AS DATE) >= '$define_date' 
            ";
            $data['composite'][] = $this->db->query($sql)->row();
            /////////////////////////////////////////////
        }
        //var_dump($data);
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/diposecase_02', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/diposecase_02';
        $this->load->view('layouts/main',$data);
    }

    public function DisposeMouzawise_dclao() {
		//$db=  $this->session->userdata('db');
        $data = array();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $data['locdata'] = array(
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code
        );
		$define_date=define_date;
        $q = "SELECT * FROM  location WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code = '$cir_code' and Mouza_Pargona_code <> '00' and Lot_no= '00' and vill_townprt_code= '00000'";
        $data['loc'] = $values = $this->db->query($q)->result();
        foreach ($values as $v) {

            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and mut_type='03'";
            $data['omut'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and mut_type='03' and (status='P' or status is null) ";
            $data['omutpen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and mut_type='03' and (status='D' or status='d') ";
            $data['omutdev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and mut_type='03' and (status ='F' or status ='f') ";
            $data['omutfinal'][] = $this->db->query($q)->row();
            ///////////////
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and mut_type='01'";
            $data['ocon'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and mut_type='01' and (status='P' or status is null) ";
            $data['oconpen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and mut_type='01' and (status='D' or status='d') ";
            $data['ocondev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and mut_type='01' and (status ='F' or status ='f') ";
            $data['oconfinal'][] = $this->db->query($q)->row();
            ////////////////////
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and mut_type='04'";
            $data['opart'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and mut_type='04' and (status='P' or status is null) ";
            $data['opartpen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and mut_type='04' and (status='D' or status='d') ";
            $data['opartdev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and mut_type='04' and (status ='F' or status ='f') ";
            $data['opartfinal'][] = $this->db->query($q)->row();
            // field cases
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and mut_type='01'";
            $data['fmut'][] = $OConv = $this->db->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and mut_type='01' and (order_passed is null and is_dispose is null) ";
            $data['fmutpen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and mut_type='01' and (is_dispose='Y' or is_dispose='y' )";
            $data['fmutdev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and  cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and  mut_type='01' and (order_passed ='Y' or order_passed ='y'  ) ";
            $data['fieldmutfinal'][] = $this->db->query($q)->row();
            //////////////

            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code'  and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and mut_type='02'";
            $data['fpart'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and mut_type='02' and (order_passed is null and is_dispose is null) ";
            $data['fpartpen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and mut_type='02' and (is_dispose='Y' or is_dispose='y' )";
            $data['fpartdev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and mut_type='02' and (order_passed ='Y' or order_passed ='y'  ) ";
            $data['fieldpartfinal'][] = $this->db->query($q)->row();

            // Reclassfication
            $q = "select count(*) as c from    t_reclassification where dist_code='$dist_code' and date(lm_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' ";
            $data['t_reclass_tot'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    t_reclassification where dist_code='$dist_code' and date(lm_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and  (rkg_chitha_updated_yn is null and co_chitha_updated_yn is null) ";
            $data['t_reclass_pen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    t_reclassification where dist_code='$dist_code' and date(lm_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and (rkg_chitha_updated_yn='Y' and co_chitha_updated_yn='Y')";
            $data['t_reclass_dev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    t_reclassification where dist_code='$dist_code' and date(lm_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and co_yn='N' ";
            $data['t_reclass_dispose'][] = $this->db->query($q)->row();
            // End Reclassfication     
            // NR Case
            $q = "select count(*) as c from    apcancel_petition_basic where dist_code='$dist_code' and date(submission_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' ";
            $data['nr_tot'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    apcancel_petition_basic where dist_code='$dist_code' and date(submission_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and  status ='P' and order_passed is null  ";
            $data['nr_pen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    apcancel_petition_basic where dist_code='$dist_code' and date(submission_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and order_passed ='Y' ";
            $data['nr_dev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    apcancel_petition_basic where dist_code='$dist_code' and date(submission_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and status='X' ";
            $data['nr_dispose'][] = $this->db->query($q)->row();
            // // End NR Case
            // Misc Case
            $q = "select count(*) as c from    misc_case_basic where dist_code='$dist_code' and date(submission_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' ";
            $data['misccase_tot'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    misc_case_basic where dist_code='$dist_code' and date(submission_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and  (status !='10'  or status ='11'  )  ";
            $data['misccase_pen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    misc_case_basic where dist_code='$dist_code' and date(submission_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and   status ='10'  ";
            $data['misccase_dev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    misc_case_basic where dist_code='$dist_code' and date(submission_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$v->mouza_pargona_code' and   status ='11'   ";
            $data['misccase_dispose'][] = $this->db->query($q)->row();
            // End Misc Case
        }
        //var_dump($data);
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/diposecase_02', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/diposecase_02';
        $this->load->view('layouts/main',$data);
    }

    public function DisposeYearwise() {
		$db=  $this->session->userdata('db');
        $data = array();
        $loc = array();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $start_year = 2009;
        $end_year = date('Y');
        do {
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and year_no='$start_year' and mut_type='03'";
            $data['omut'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and year_no='$start_year' and mut_type='03' and (status='P' or status is null) ";
            $data['omutpen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and year_no='$start_year' and mut_type='03' and  (status='D' or status='d') ";
            $data['omutdev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and year_no='$start_year'  and mut_type='03' and (status ='F' or status ='f') ";
            $data['omutfinal'][] = $this->db->query($q)->row();

            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and year_no='$start_year' and mut_type='01'";
            $data['ocon'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and year_no='$start_year' and mut_type='01' and (status='P' or status is null) ";
            $data['oconpen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and year_no='$start_year' and mut_type='01' and (status='D' or status='d') ";
            $data['ocondev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and year_no='$start_year'  and mut_type='01' and (status ='F' or status ='f') ";
            $data['oconfinal'][] = $this->db->query($q)->row();

            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and year_no='$start_year' and mut_type='04'";
            $data['opart'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and year_no='$start_year' and mut_type='04' and (status='P' or status is null) ";
            $data['opartpen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and year_no='$start_year' and mut_type='04' and (status='D' or status='d') ";
            $data['opartdev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and year_no='$start_year'  and mut_type='04' and (status ='F' or status ='f') ";
            $data['opartfinal'][] = $this->db->query($q)->row();
            // field cases
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and year_no='$start_year' and mut_type='01'";
            $data['fmut'][] = $OConv = $this->db->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and year_no='$start_year' and mut_type='01' and (order_passed is null and is_dispose is null) ";
            $data['fmutpen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and year_no='$start_year' and mut_type='01' and (is_dispose='Y' or is_dispose='y' )";
            $data['fmutdev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and year_no='$start_year' and mut_type='01' and  (order_passed ='Y' or order_passed ='y'  ) ";
            $data['fieldmuttfinal'][] = $this->db->query($q)->row();

            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and year_no='$start_year' and mut_type='02'";
            $data['fpart'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and year_no='$start_year' and mut_type='02' and (order_passed is Null and is_dispose is null) ";
            $data['fpartpen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and year_no='$start_year' and mut_type='02' and (order_passed='d' or order_passed='D' )";
            $data['fpartdev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and year_no='$start_year' and mut_type='02' and  (order_passed ='Y' or order_passed ='y'  ) ";
            $data['fieldpartfinal'][] = $this->db->query($q)->row();

            $data['loc'][] = $start_year;
            $start_year = $start_year + 1;
        } while ($start_year <= $end_year);

        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/dispose_year', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/dispose_year';
        $this->load->view('layouts/main',$data);
    }

    public function DisposeYearwise_dclao() {
		$db=  $this->session->userdata('db');
        $data = array();
        $loc = array();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $start_year = 2009;
        $end_year = date('Y');
        do {
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and year_no='$start_year' and mut_type='03'";
            $data['omut'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and year_no='$start_year' and mut_type='03' and (status='P' or status is null) ";
            $data['omutpen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and year_no='$start_year' and mut_type='03' and  (status='D' or status='d') ";
            $data['omutdev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and year_no='$start_year'  and mut_type='03' and (status ='F' or status ='f') ";
            $data['omutfinal'][] = $this->db->query($q)->row();

            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and year_no='$start_year' and mut_type='01'";
            $data['ocon'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and year_no='$start_year' and mut_type='01' and (status='P' or status is null) ";
            $data['oconpen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and year_no='$start_year' and mut_type='01' and (status='D' or status='d') ";
            $data['ocondev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and year_no='$start_year'  and mut_type='01' and (status ='F' or status ='f') ";
            $data['oconfinal'][] = $this->db->query($q)->row();

            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and year_no='$start_year' and mut_type='04'";
            $data['opart'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and year_no='$start_year' and mut_type='04' and (status='P' or status is null) ";
            $data['opartpen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and year_no='$start_year' and mut_type='04' and (status='D' or status='d') ";
            $data['opartdev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and year_no='$start_year'  and mut_type='04' and (status ='F' or status ='f') ";
            $data['opartfinal'][] = $this->db->query($q)->row();
            // field cases
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and year_no='$start_year' and mut_type='01'";
            $data['fmut'][] = $OConv = $this->db->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and year_no='$start_year' and mut_type='01' and (order_passed is null and is_dispose is null) ";
            $data['fmutpen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and year_no='$start_year' and mut_type='01' and (is_dispose='Y' or is_dispose='y' )";
            $data['fmutdev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and year_no='$start_year' and mut_type='01' and  (order_passed ='Y' or order_passed ='y'  ) ";
            $data['fieldmuttfinal'][] = $this->db->query($q)->row();

            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and year_no='$start_year' and mut_type='02'";
            $data['fpart'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and year_no='$start_year' and mut_type='02' and (order_passed is Null and is_dispose is null) ";
            $data['fpartpen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and year_no='$start_year' and mut_type='02' and (order_passed='d' or order_passed='D' )";
            $data['fpartdev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and year_no='$start_year' and mut_type='02' and  (order_passed ='Y' or order_passed ='y'  ) ";
            $data['fieldpartfinal'][] = $this->db->query($q)->row();

            $data['loc'][] = $start_year;
            $start_year = $start_year + 1;
        } while ($start_year <= $end_year);

        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/dispose_year', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/dispose_year';
        $this->load->view('layouts/main',$data);
    }

    public function DisposeLotwise() {
		//$db=  $this->session->userdata('db');
        // var_dump($this->session->all_userdata());
        $data = array();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->input->get('sub');
        $cir_code = $this->input->get('cir');
        $mouza_pargona_code = $this->input->get('mouza_code');
        $data['locationData'] = array(
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code
        );
	$define_date=define_date;
        //$this->session->set_userdata($locationData);
        $q = "SELECT * FROM location WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code = '$cir_code' and Mouza_Pargona_code = '$mouza_pargona_code' and Lot_no<> '00' and vill_townprt_code= '00000'";
        $data['loc'] = $values = $this->db->query($q)->result();
        //var_dump($values);
        foreach ($values as $v) {
            //echo $v->mouza_pargona_code;
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and  lot_no='$v->lot_no' and mut_type='03'";
            $data['omut'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code'  and lot_no='$v->lot_no' and  mut_type='03' and (status='P' or status is null) ";
            $data['omutpen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$v->lot_no' and mut_type='03' and (status='D' or status='d') ";
            $data['omutdev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$v->lot_no'  and mut_type='03' and (status ='F' or status ='f') ";
            $data['omuttfinal'][] = $this->db->query($q)->row();

            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$v->lot_no' and  mut_type='01'";
            $data['ocon'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$v->lot_no' and  mut_type='01' and (status='P' or status is null) ";
            $data['oconpen'][] = $this->db->query($q)->row();

            $data['ocondev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$v->lot_no' and mut_type='01' and (status ='F' or status ='f') ";
            $data['oconfinal'][] = $this->db->query($q)->row();

            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$v->lot_no' and  mut_type='04'";
            $data['opart'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$v->lot_no' and  mut_type='04' and (status='P' or status is null) ";
            $data['opartpen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$v->lot_no' and  mut_type='04' and (status='D' or status='d') ";
            $data['opartdev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$v->lot_no' and mut_type='04' and (status ='F' or status ='f') ";
            $data['opartfinal'][] = $this->db->query($q)->row();
            // field cases
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$v->lot_no' and  mut_type='01'";
            $data['fmut'][] = $OConv = $this->db->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$v->lot_no' and  mut_type='01' and (order_passed is Null and is_dispose is null) ";
            $data['fmutpen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$v->lot_no' and  mut_type='01' and (is_dispose='Y' or is_dispose='y' )";
            $data['fmutdev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$v->lot_no' and mut_type='01' and (order_passed ='Y' or order_passed ='y'  ) ";
            $data['fieldmuttfinal'][] = $this->db->query($q)->row();

            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$v->lot_no' and  mut_type='02'";
            $data['fpart'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$v->lot_no' and  mut_type='02' and (order_passed is Null and is_dispose is null) ";
            $data['fpartpen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$v->lot_no' and  mut_type='02' and (is_dispose='Y' or is_dispose='y' )";
            $data['fpartdev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$v->lot_no' and mut_type='02' and (order_passed ='Y' or order_passed ='y'  ) ";
            $data['fieldpartfinal'][] = $this->db->query($q)->row();


            // Reclassfication
            $q = "select count(*) as c from    t_reclassification where dist_code='$dist_code' and date(lm_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$v->lot_no'  ";
            $data['t_reclass_tot'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    t_reclassification where dist_code='$dist_code' and date(lm_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$v->lot_no'  and  (rkg_chitha_updated_yn is null and co_chitha_updated_yn is null) ";
            $data['t_reclass_pen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    t_reclassification where dist_code='$dist_code' and date(lm_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$v->lot_no'  and (rkg_chitha_updated_yn='Y' and co_chitha_updated_yn='Y')";
            $data['t_reclass_dev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    t_reclassification where dist_code='$dist_code' and date(lm_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$v->lot_no'  and co_yn='N' ";
            $data['t_reclass_dispose'][] = $this->db->query($q)->row();
            // End Reclassfication     
            // NR Case
            $q = "select count(*) as c from    apcancel_petition_basic where dist_code='$dist_code' and date(submission_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$v->lot_no'  ";
            $data['nr_tot'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    apcancel_petition_basic where dist_code='$dist_code' and date(submission_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$v->lot_no'  and  status ='P' and order_passed is null  ";
            $data['nr_pen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    apcancel_petition_basic where dist_code='$dist_code' and date(submission_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$v->lot_no'  and order_passed ='Y' ";
            $data['nr_dev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    apcancel_petition_basic where dist_code='$dist_code' and date(submission_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$v->lot_no'  and status='X' ";
            $data['nr_dispose'][] = $this->db->query($q)->row();
            // // End NR Case
            // Misc Case
            $q = "select count(*) as c from    misc_case_basic where dist_code='$dist_code' and date(submission_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$v->lot_no'  ";
            $data['misccase_tot'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    misc_case_basic where dist_code='$dist_code' and date(submission_date)>='$define_date'  and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$v->lot_no'  and  (status !='10'  or status ='11'  )  ";
            $data['misccase_pen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    misc_case_basic where dist_code='$dist_code' and date(submission_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$v->lot_no'  and   status ='10'  ";
            $data['misccase_dev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    misc_case_basic where dist_code='$dist_code' and date(submission_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$v->lot_no'  and   status ='11'   ";
            $data['misccase_dispose'][] = $this->db->query($q)->row();
            // End Misc Case



            // AC to PP Case
            $q = "select count(*) as c from    allotment_cert_basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and mouza_pargona_code='$v->mouza_pargona_code' and lot_no='$v->lot_no'";
            $data['actopp_tot'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    allotment_cert_basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and mouza_pargona_code='$v->mouza_pargona_code' and lot_no='$v->lot_no' and  (status ='P'  or status ='R' or status is null  )  ";
            $data['actopp_pen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    allotment_cert_basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and mouza_pargona_code='$v->mouza_pargona_code' and lot_no='$v->lot_no' and status ='F' and chitha_correct_yn is not null and dc_code is not null";
            $data['actopp_dev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    allotment_cert_basic where dist_code='$dist_code' and  date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and mouza_pargona_code='$v->mouza_pargona_code' and lot_no='$v->lot_no' and status ='D'";
            $data['actopp_dispose'][] = $this->db->query($q)->row();
             ////////////////////Settlement/////////////////////////
            $q="SELECT
                (SELECT COUNT(*) FROM settlement_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$v->mouza_pargona_code' and lot_no='$v->lot_no' and  CAST(date_entry AS DATE) >= '$define_date') AS total,
                (SELECT COUNT(*) FROM settlement_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$v->mouza_pargona_code' and lot_no='$v->lot_no' and  status = 'F' and CAST(date_entry AS DATE) >= '$define_date') AS passed,
                (SELECT COUNT(*) FROM settlement_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$v->mouza_pargona_code' and lot_no='$v->lot_no' and  status = 'D' and CAST(date_entry AS DATE) >= '$define_date') AS rejected,
                (SELECT COUNT(*) FROM settlement_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$v->mouza_pargona_code' and lot_no='$v->lot_no' and  status NOT IN ('D', 'F') and CAST(date_entry AS DATE) >= '$define_date') AS pending";
            $data['settlement'][] = $this->db->query($q)->row();
            //////////////////////Composite Service///////////////////////
            $sql="SELECT 
                count(*) FILTER (WHERE status = 'F') as delivered,
                count(*) FILTER (WHERE status = 'P') as pending,
                count(*) FILTER (WHERE status = 'D') as disposed,
                count(*) as total
            from petition_basic where comp_serv_yn='Y' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$v->mouza_pargona_code' and lot_no='$v->lot_no' and  CAST(submission_date AS DATE) >= '$define_date' 
            ";
            $data['composite'][] = $this->db->query($sql)->row();

        }
        //var_dump($data);
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/diposecase_03', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/diposecase_03';
        $this->load->view('layouts/main',$data);
    }

    public function DisposeVillwise() {
		//$db=  $this->session->userdata('db');
        $data = array();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->input->get('sub');
        $cir_code = $this->input->get('cir');
        $mouza_pargona_code = $this->input->get('mouza');
        $lot_no = $this->input->get('lot');
		$define_date=define_date;
        $data['locationData'] = array(
            'lot_no' => $lot_no,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_code' => $mouza_pargona_code
        );
        // $this->session->set_userdata($locationData);
        $q = "SELECT * FROM location WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code = '$cir_code' and Mouza_Pargona_code = '$mouza_pargona_code' and Lot_no= '$lot_no' and vill_townprt_code <> '00000'";
        //echo $q;
        $data['loc'] = $values = $this->db->query($q)->result();
        //var_dump($values);
        foreach ($values as $v) {
            //echo $v->mouza_pargona_code;
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and  lot_no='$lot_no' and vill_townprt_code='$v->vill_townprt_code' and mut_type='03'";
            $data['omut'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code'  and lot_no='$lot_no' and vill_townprt_code='$v->vill_townprt_code' and  mut_type='03' and (status='P' or status is null) ";
            $data['omutpen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$v->vill_townprt_code' and mut_type='03' and status='D' ";
            $data['omutdev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$v->vill_townprt_code' and mut_type='03' and (status='F' or status='f' )";
            $data['omutfinal'][] = $this->db->query($q)->row();

            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and vill_townprt_code='$v->vill_townprt_code' and lot_no='$lot_no' and  mut_type='01'";
            $data['ocon'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$lot_no'  and  vill_townprt_code='$v->vill_townprt_code' and mut_type='01' and (status='P' or status is null) ";
            $data['oconpen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$v->vill_townprt_code' and mut_type='01' and status='D' ";
            $data['ocondev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$v->vill_townprt_code' and mut_type='01' and (status='F' or status='f' )";
            $data['oconfinal'][] = $this->db->query($q)->row();

            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$v->vill_townprt_code' and  mut_type='04'";
            $data['opart'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$v->vill_townprt_code' and mut_type='04' and (status='P' or status is null) ";
            $data['opartpen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$v->vill_townprt_code' and  mut_type='04' and status='D' ";
            $data['opartdev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$v->vill_townprt_code' and  mut_type='04' and (status='F' or status='f' )";
            $data['opartfinal'][] = $this->db->query($q)->row();
            // field cases
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$v->vill_townprt_code' and  mut_type='01'";
            $data['fmut'][] = $OConv = $this->db->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and  vill_townprt_code='$v->vill_townprt_code' and mut_type='01' and (order_passed is Null and is_dispose is null) ";
            $data['fmutpen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$v->vill_townprt_code' and  mut_type='01' and (is_dispose='Y' or is_dispose='y' )";
            $data['fmutdev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$v->vill_townprt_code'  and mut_type='01' and (order_passed ='Y' or order_passed ='y'  ) ";
            $data['fieldmutfinal'][] = $this->db->query($q)->row();
            //////////////
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$v->vill_townprt_code' and  mut_type='02'";
            $data['fpart'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and  vill_townprt_code='$v->vill_townprt_code' and mut_type='02' and (order_passed is Null and is_dispose is null) ";
            $data['fpartpen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$v->vill_townprt_code' and mut_type='02' and (is_dispose='Y' or is_dispose='y' )";
            $data['fpartdev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$v->vill_townprt_code'  and mut_type='02' and (order_passed ='Y' or order_passed ='y'  ) ";
            $data['fieldpartfinal'][] = $this->db->query($q)->row();


            // Reclassfication
            $q = "select count(*) as c from    t_reclassification where dist_code='$dist_code' and date(lm_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$v->vill_townprt_code' ";
            $data['t_reclass_tot'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    t_reclassification where dist_code='$dist_code' and date(lm_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$v->vill_townprt_code' and  (rkg_chitha_updated_yn is null and co_chitha_updated_yn is null) ";
            $data['t_reclass_pen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    t_reclassification where dist_code='$dist_code' and date(lm_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$v->vill_townprt_code' and (rkg_chitha_updated_yn ='Y' and co_chitha_updated_yn ='Y')";
            $data['t_reclass_dev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    t_reclassification where dist_code='$dist_code' and date(lm_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$v->vill_townprt_code' and co_yn='N' ";
            $data['t_reclass_dispose'][] = $this->db->query($q)->row();
            // End Reclassfication     
            // NR Case
            $q = "select count(*) as c from    apcancel_petition_basic where dist_code='$dist_code' and date(submission_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$v->vill_townprt_code' ";
            $data['nr_tot'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    apcancel_petition_basic where dist_code='$dist_code' and date(submission_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$v->vill_townprt_code' and  status ='P' and order_passed is null  ";
            $data['nr_pen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    apcancel_petition_basic where dist_code='$dist_code' and date(submission_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$v->vill_townprt_code' and order_passed ='Y' ";
            $data['nr_dev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    apcancel_petition_basic where dist_code='$dist_code' and date(submission_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$v->vill_townprt_code' and status='X' ";
            $data['nr_dispose'][] = $this->db->query($q)->row();
            // // End NR Case
            // Misc Case
            $q = "select count(*) as c from    misc_case_basic where dist_code='$dist_code' and date(submission_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$v->vill_townprt_code' ";
            $data['misccase_tot'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    misc_case_basic where dist_code='$dist_code' and date(submission_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$v->vill_townprt_code' and  (status !='10'  or status ='11'  )  ";
            $data['misccase_pen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    misc_case_basic where dist_code='$dist_code' and date(submission_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$v->vill_townprt_code' and   status ='10'  ";
            $data['misccase_dev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    misc_case_basic where dist_code='$dist_code' and date(submission_date)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Mouza_Pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$v->vill_townprt_code' and   status ='11'   ";
            $data['misccase_dispose'][] = $this->db->query($q)->row();
            // End Misc Case



            // AC to PP Case
            $q = "select count(*) as c from    allotment_cert_basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and mouza_pargona_code='$v->mouza_pargona_code' and lot_no='$v->lot_no' and vill_townprt_code='$v->vill_townprt_code'";
            $data['actopp_tot'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    allotment_cert_basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and mouza_pargona_code='$v->mouza_pargona_code' and lot_no='$v->lot_no' and vill_townprt_code='$v->vill_townprt_code' and   (status ='P'  or status ='R' or status is null  )  ";
            $data['actopp_pen'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    allotment_cert_basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and mouza_pargona_code='$v->mouza_pargona_code' and lot_no='$v->lot_no' and vill_townprt_code='$v->vill_townprt_code' and status ='F' and chitha_correct_yn is not null and dc_code is not null ";
            $data['actopp_dev'][] = $this->db->query($q)->row();
            $q = "select count(*) as c from    allotment_cert_basic where dist_code='$dist_code' and  date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and mouza_pargona_code='$v->mouza_pargona_code' and lot_no='$v->lot_no' and vill_townprt_code='$v->vill_townprt_code' and status ='D'";
            $data['actopp_dispose'][] = $this->db->query($q)->row();
             ////////////////////Settlement/////////////////////////
            $q="SELECT
                (SELECT COUNT(*) FROM settlement_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$v->mouza_pargona_code' and lot_no='$v->lot_no' and vill_townprt_code='$v->vill_townprt_code' and  CAST(date_entry AS DATE) >= '$define_date') AS total,
                (SELECT COUNT(*) FROM settlement_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$v->mouza_pargona_code' and lot_no='$v->lot_no' and vill_townprt_code='$v->vill_townprt_code' and  status = 'F' and CAST(date_entry AS DATE) >= '$define_date') AS passed,
                (SELECT COUNT(*) FROM settlement_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$v->mouza_pargona_code' and lot_no='$v->lot_no' and vill_townprt_code='$v->vill_townprt_code' and  status = 'D' and CAST(date_entry AS DATE) >= '$define_date') AS rejected,
                (SELECT COUNT(*) FROM settlement_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$v->mouza_pargona_code' and lot_no='$v->lot_no' and vill_townprt_code='$v->vill_townprt_code' and  status NOT IN ('D', 'F') and CAST(date_entry AS DATE) >= '$define_date') AS pending";
            $data['settlement'][] = $this->db->query($q)->row();
            //////////////////////Composite Service///////////////////////
            $sql="SELECT 
                count(*) FILTER (WHERE status = 'F') as delivered,
                count(*) FILTER (WHERE status = 'P') as pending,
                count(*) FILTER (WHERE status = 'D') as disposed,
                count(*) as total
            from petition_basic where comp_serv_yn='Y' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$v->mouza_pargona_code' and lot_no='$v->lot_no' and vill_townprt_code='$v->vill_townprt_code' and  CAST(submission_date AS DATE) >= '$define_date' 
            ";
            $data['composite'][] = $this->db->query($sql)->row();
            //end AC to PP----
        }
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/disposecase_04', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/disposecase_04';
        $this->load->view('layouts/main',$data);
    }

    public function YearwiseListPart() {
		//$db=  $this->session->userdata('db');
        $data = array();
        $data['petipart'] = array();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = $this->input->get('year');
        $mut_type = $this->input->get('mtype');
        $locationData = array(
            'year_no' => $year_no, 'mut_type' => $mut_type
        );
		$define_date=define_date;
        $this->session->set_userdata($locationData);
        $q = "Select * from    petition_basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status='P' or status is null) and year_no='$year_no' and mut_type='$mut_type' ";
        //echo $q;
        $data['pb'] = $pb = $this->db->query($q)->result();
        foreach ($pb as $d) {
            if ($d->mut_type == '03') {
                $q = "Select pet_name as n,guard_name as g from    petitioner where petition_no='$d->petition_no' ";
            } else {
                $q = "Select pdar_name as n,pdar_guardian as g from    petitioner_part where petition_no='$d->petition_no' ";
            }
            $data['petipart'][] = $this->db->query($q)->result();
        }
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/disposecase_yearpending', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/disposecase_yearpending';
        $this->load->view('layouts/main',$data);
    }

    public function YearwiseListField() {
		//$db=  $this->session->userdata('db');
        $data = array();
        $data['petipart'] = array();

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = $this->input->get('year');
        $mut_type = $this->input->get('mtype');
        $locationData = array(
            'year_no' => $year_no, 'mut_type' => $mut_type
        );
		$define_date=define_date;
        $this->session->set_userdata($locationData);
        $q = "Select * from    field_mut_basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (order_passed is null and is_dispose is null) and year_no='$year_no' and mut_type='$mut_type' ";
        //echo $q;
        $data['pb'] = $pb = $this->db->query($q)->result();
        foreach ($pb as $d) {
            if ($d->mut_type == '01') {
                $q = "Select pet_name as n,guard_name as g from    field_mut_petitioner where case_no='$d->case_no' and petition_no='$d->petition_no' ";
            } else {
                $q = "Select pdar_name as n,pdar_guardian as g from    field_part_petitioner where case_no='$d->case_no' and petition_no='$d->petition_no' ";
            }
            $data['petipart'][] = $this->db->query($q)->result();
        }
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/fieldpending_yearpending', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/fieldpending_yearpending';
        $this->load->view('layouts/main',$data);
    }

    public function DisposeForPP() {
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/disposecase_pp_1');
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/disposecase_pp_1';
        $this->load->view('layouts/main',$data);
    }

    public function DisposeForPPDCLAO() {
        $data['_view'] = 'misreport/disposecase_pp_dclao';
        $this->load->view('layouts/main',$data);
    }
    public function DisposeForPPSubmitdist() {
        ini_set('memory_limit', '-1');
        $data = array();
        //end field
        $dist_code = $this->session->userdata('dist_code');
        // $subdiv_code=$this->session->userdata('subdiv_code');
        // $cir_code=$this->session->userdata('cir_code');
        $define_date=define_date;
      
            $regOpart = 0;
            $disOpart = 0;
            $penOpart = 0;
            $regOmut = 0;
            $disOmut = 0;
            $penOmut = 0;
            $regOcon = 0;
            $disOcon = 0;
            $penOcon = 0;
            $deliverOpart = 0;
            $deliverOmut = 0;
            $deliverOcon = 0;
            $regOpart1 = 0;
            $disOpart1 = 0;
            $penOpart1 = 0;
            $regOmut1 = 0;
            $disOmut1 = 0;
            $penOmut1 = 0;
            $regOcon1 = 0;
            $disOcon1 = 0;
            $penOcon1 = 0;
            $deliverOpart1 = 0;
            $deliverOcon1 = 0;
            $deliverOmut1 = 0;
            
            //        end office
            $regFpart = 0;
            $disFpart = 0;
            $penFpart = 0;
            $deliverFpart = 0;
            $regFmut = 0;
            $disFmut = 0;
            $penFmut = 0;
            $deliverFmut = 0;
            $regFpart1 = 0;
            $disFpart1 = 0;
            $penFpart1 = 0;
            $deliverFpart1 = 0;
            $regFmut1 = 0;
            $disFmut1 = 0;
            $penFmut1 = 0;
            $deliverFmut1 = 0;
            ///////AP///////
            $apcancelReg=0;
            $apcancelPen=0;
            $apcancelRej=0;
            $apcancelDelv=0;
            
            $apcancelRegT=0;
            $apcancelPenT=0;
            $apcancelRejT=0;
            $apcancelDelvT=0;
            ////////Reclass///////////
            $reclassReg=0;
            $reclassPen=0;
            $reclassRej=0;
            $reclassDelv=0;
            
            $reclassRegT=0;
            $reclassPenT=0;
            $reclassRejT=0;
            $reclassDelvT=0;
            //////Jamabandi/////
            $certReg=0;
            $certPen=0;
            $certRej=0;
            $certDelv=0;
            
            $certRegT=0;
            $certPenT=0;
            $certRejT=0;
            $certDelvT=0;
            ///////////
            $sdate = $this->input->post('sdate');
            $sdate = date('Y-m-d', strtotime($sdate));
            $edate = $this->input->post('edate');
            $edate = date('Y-m-d', strtotime($edate));
            $locationData = array(
                'sdate' => $sdate,
                'edate' => $edate
            );
            $this->session->set_userdata($locationData);
            $q = "select mut_type,status from Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date'  and date(submission_date)>='$sdate' and date(submission_date)<='$edate' and (submission_date is not null)";
            $data['pb'] = $pb = $this->db->query($q)->result();
            foreach ($pb as $d) {
                //            partition cases
                if ($d->mut_type == '04') {
                    $regOpart = $regOpart + 1;
                    if (($d->status == 'P') or ( $d->status == null)) {
                        $penOpart = $penOpart + 1;
                    } elseif ($d->status == 'D' or $d->status == 'd') {
                        $disOpart = $disOpart + 1;
                    } elseif ($d->status == 'F' or $d->status == 'f') {
                        $deliverOpart = $deliverOpart + 1;
                    }
                }
                //            end here
                if ($d->mut_type == '03') {
                    $regOmut = $regOmut + 1;
                    if (($d->status === 'P') or ( $d->status == null)) {
                        $penOmut = $penOmut + 1;
                    }
                    if ($d->status == 'D' or $d->status == 'd') {
                        $disOmut = $disOmut + 1;
                    }
                    if ($d->status == 'F' or $d->status == 'f') {
                        $deliverOmut = $deliverOmut + 1;
                    }
                }
                //            mutation end here
                if ($d->mut_type == '01') {
                    $regOcon = $regOcon + 1;
                    if (($d->status === 'P') or ( $d->status == null)) {
                        $penOcon = $penOcon + 1;
                    }
                    if ($d->status == 'D' or $d->status == 'd') {
                        $disOcon = $disOcon + 1;
                    }
                    if ($d->status == 'F' or $d->status == 'f') {
                        $deliverOcon = $deliverOcon + 1;
                    }
                }
                //            conversion end here
            }

            //        without range
            $q = "select mut_type,status from Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date'  and date(date_entry)<='$edate' ";
            $data['pbb'] = $pbb = $this->db->query($q)->result();
            foreach ($pbb as $d) {
                //            partition cases
                if ($d->mut_type == '04') {
                    $regOpart1 = $regOpart1 + 1;
                    if (($d->status === 'P') or ( $d->status == null)) {
                        $penOpart1 = $penOpart1 + 1;
                    } elseif ($d->status == 'D') {
                        $disOpart1 = $disOpart1 + 1;
                    } elseif ($d->status == 'F') {
                        $deliverOpart1 = $deliverOpart1 + 1;
                    }
                }
                //            end here
                if ($d->mut_type == '03') {
                    $regOmut1 = $regOmut1 + 1;
                    if (($d->status === 'P') or ( $d->status == null)) {
                        $penOmut1 = $penOmut1 + 1;
                    } elseif ($d->status == 'D') {
                        $disOmut1 = $disOmut1 + 1;
                    } elseif ($d->status == 'F' or $d->status == 'f') {
                        $deliverOmut1 = $deliverOmut1 + 1;
                    }
                }
                //            mutation end here
                if ($d->mut_type == '01') {
                    $regOcon1 = $regOcon1 + 1;
                    if (($d->status === 'P') or ( $d->status == null)) {
                        $penOcon1 = $penOcon1 + 1;
                    } elseif ($d->status == 'D' or $d->status == 'd') {
                        $disOcon1 = $disOcon1 + 1;
                    } elseif ($d->status == 'F' or $d->status == 'f') {
                        $deliverOcon1 = $deliverOcon1 + 1;
                    }
                }
                //            conversion end here
            }
            //AP cancellation/////////////////
            $sql = "Select * from apcancel_petition_basic where dist_code ='$dist_code'   and date(submission_date)>='$sdate' and date(submission_date)<='$edate' ";
            $apcancellation['registercase'] = $this->db->query($sql)->result();
            //var_dump($apcancellation['registercase']);
            foreach($apcancellation['registercase'] as $ap){
                $apcancelReg = $apcancelReg + 1;
                if($ap->order_passed=='Y' or $ap->co_chitha_corrected_yn=='Y' or $ap->co_chitha_corrected_yn=='y' ){
                    $apcancelDelv=$apcancelDelv+1;
                }
                if($ap->order_passed!='Y'){
                    $apcancelPen=$apcancelPen+1;
                }
                if($ap->dc_approval_yn=='N'){
                    $apcancelRej=$apcancelRej+1;
                }
            }
            
            $sql = "Select * from apcancel_petition_basic where dist_code ='$dist_code'   and date(submission_date)<='$edate'  ";   
            $apcancellation['apTotal'] = $this->db->query($sql)->result();
            foreach($apcancellation['apTotal'] as $ap){
                $apcancelRegT = $apcancelRegT + 1;
                if($ap->order_passed=='Y' or $ap->co_chitha_corrected_yn=='Y' or $ap->co_chitha_corrected_yn=='y' ){
                    $apcancelDelvT=$apcancelDelvT+1;
                }
                if($ap->order_passed!='Y'){
                    $apcancelPenT=$apcancelPenT+1;
                }
                if($ap->dc_approval_yn=='N'){
                    $apcancelRejT=$apcancelRejT+1;
                }
            }
            ////////////End AP////////////////////
            ////////////Reclass/////////////////
            $sql = "Select * from t_reclassification where dist_code ='$dist_code'  and date(lm_date)>='$sdate' and date(lm_date)<='$edate' ";
            $apcancellation['registerR'] = $this->db->query($sql)->result();
            //var_dump($apcancellation['registercase']);
            foreach($apcancellation['registerR'] as $ap){
                $reclassReg = $reclassReg + 1;
                if($ap->rkg_chitha_updated_yn=='Y'){
                    $reclassDelv=$reclassDelv+1;
                }
                if($ap->status=='R'){
                    $reclassRej=$reclassRej+1;
                }
                if($ap->rkg_chitha_updated_yn!='Y' and $ap->status!='R'){
                    $reclassPen=$reclassPen+1;
                }
            }
            //$reclassPen=($reclassReg - ($reclassDelv+$reclassRej));
            
            $sql = "Select * from t_reclassification where dist_code ='$dist_code'  and date(lm_date)<='$edate'  "; 
            $apcancellation['reTotal'] = $this->db->query($sql)->result();
            foreach($apcancellation['reTotal'] as $ap){
                $reclassRegT = $reclassRegT + 1;
                if($ap->rkg_chitha_updated_yn=='Y'){
                    $reclassDelvT=$reclassDelvT+1;
                }
                if($ap->rkg_chitha_updated_yn!='Y' and $ap->status!='R'){
                    $reclassPenT=$reclassPenT+1;
                }
                if($ap->status=='R'){
                 $reclassRejT=$reclassRejT+1;
                }
            }
            ////////////End Reclass////////////////////
            ////////////Cert Application/////////////////
            $sql = "Select * from cert_application where dist_code ='$dist_code'  and date(date_entry)>='$sdate' and date(date_entry)<='$edate' ";
            $apcancellation['registerCert'] = $this->db->query($sql)->result();
            //var_dump($apcancellation['registercase']);
            foreach($apcancellation['registerCert'] as $ap){
                $certReg = $certReg + 1;
                if($ap->status=='D'){
                    $certDelv=$certDelv+1;
                }
                if($ap->status!='D'){
                    $certPen=$certPen+1;
                }
                if($ap->status=='F'){
                    $certRej=$certRej+1;
                }
            }
            
            $sql = "Select * from cert_application where dist_code ='$dist_code' and date(date_entry)<='$edate'  "; 
            $apcancellation['reTotal'] = $this->db->query($sql)->result();
            foreach($apcancellation['reTotal'] as $ap){
                $certRegT = $certRegT + 1;
                if($ap->status=='D'){
                    $certDelvT=$certDelvT+1;
                }
                if($ap->status!='D'){
                    $certPenT=$certPenT+1;
                }
                if($ap->status=='F'){
                    $certRejT=$certRejT+1;
                }
            }
            ////////////End Reclass////////////////////
            ////////////Misc Case/////////////////
            $regmName=0;$regmNameD=0;
            $regmNamePen=0;$regmNameDPen=0;
            $regmNameDel=0;$regmNameDDel=0;
            $regmNameRej=0;$regmNameDRej=0;
            
            $regmNameT=0;$regmNameDT=0;
            $regmNamePenT=0;$regmNameDPenT=0;
            $regmNameDelT=0;$regmNameDDelT=0;
            $regmNameRejT=0;$regmNameDRejT=0;
            $sql = "Select * from misc_case_basic where dist_code ='$dist_code'  and date(submission_date)>='$sdate' and date(submission_date)<='$edate' ";
            $apcancellation['registerMisc'] = $this->db->query($sql)->result();
            //var_dump($apcancellation['registercase']);
            foreach($apcancellation['registerMisc'] as $d){
                if ($d->misc_case_type == '06') {
                    $regmName= $regmName + 1;
                    if (($d->status == '18') ) {
                        $regmNameDel = $regmNameDel + 1;
                    } elseif ($d->status == 'F') {
                        $regmNameRej = $regmNameRej + 1;
                    } elseif ($d->status != '18' or $d->status != 'F') {
                        $regmNamePen = $regmNamePen + 1;
                    }
                }
                if ($d->misc_case_type == '07') {
                    $regmNameD= $regmNameD + 1;
                    if (($d->status == '18') ) {
                        $regmNameDDel = $regmNameDDel + 1;
                    } elseif ($d->status == 'F') {
                        $regmNameDRej = $regmNameDRej + 1;
                    } elseif ($d->status != '18' or $d->status != 'F') {
                        $regmNameDPen = $regmNameDPen + 1;
                    }
                }
            }
            
            $sql = "Select * from misc_case_basic where dist_code ='$dist_code'  and date(submission_date)<='$edate'  ";    
            $apcancellation['registerMiscT'] = $this->db->query($sql)->result();
            foreach($apcancellation['registerMiscT'] as $d){
                if ($d->misc_case_type == '06') {
                    $regmNameT= $regmNameT + 1;
                    if (($d->status == '18') ) {
                        $regmNameDelT = $regmNameDelT + 1;
                    } elseif ($d->status == 'F') {
                        $regmNameRejT = $regmNameRejT + 1;
                    } elseif ($d->status != '18' or $d->status != 'F') {
                        $regmNamePenT = $regmNamePenT + 1;
                    }
                }
                if ($d->misc_case_type == '07') {
                    $regmNameDT= $regmNameDT + 1;
                    if (($d->status == '18') ) {
                        $regmNameDDelT = $regmNameDDelT + 1;
                    } elseif ($d->status == 'F') {
                        $regmNameDRejT = $regmNameDRejT + 1;
                    } elseif ($d->status != '18' or $d->status != 'F') {
                        $regmNameDPenT = $regmNameDPenT + 1;
                    }
                }
            }
            ////////////End Reclass////////////////////
            $data['officepart'][] = array('regopart' => $regOpart, 'penopart' => $penOpart, 'disopart' => $disOpart, 'deliverpart' => $deliverOpart);
            $data['officemut'][] = array('regomut' => $regOmut, 'penomut' => $penOmut, 'disomut' => $disOmut, 'delivermut' => $deliverOmut);
            $data['officecon'][] = array('regocon' => $regOcon, 'penocon' => $penOcon, 'disocon' => $disOcon, 'delivercon' => $deliverOcon);
            $data['officeAP'][] = array('regap' => $apcancelRegT, 'penap' => $apcancelPenT, 'disap' => $apcancelRejT, 'deliverap' => $apcancelDelvT);
            $data['officeReclass'][] = array('regap' => $reclassRegT, 'penap' => $reclassPenT, 'disap' => $reclassRejT, 'deliverap' => $reclassDelvT);
            $data['officeCert'][] = array('regap' => $certRegT, 'penap' => $certPenT, 'disap' => $certRejT, 'deliverap' => $certDelvT);
            $data['officeMiscN'][] = array('regap' => $regmNameT, 'penap' => $regmNamePenT, 'disap' => $regmNameRejT, 'deliverap' => $regmNameDelT);
            $data['officeMiscD'][] = array('regap' => $regmNameDT, 'penap' => $regmNameDPenT, 'disap' => $regmNameDRejT, 'deliverap' => $regmNameDDelT);

            $data['officepart1'][] = array('regopart1' => $regOpart1, 'penopart1' => $penOpart1, 'disopart1' => $disOpart1, 'deliverpart1' => $deliverOpart1);
            $data['officemut1'][] = array('regomut1' => $regOmut1, 'penomut1' => $penOmut1, 'disomut1' => $disOmut1, 'delivermut1' => $deliverOmut1);
            $data['officecon1'][] = array('regocon1' => $regOcon1, 'penocon1' => $penOcon1, 'disocon1' => $disOcon1, 'delivercon1' => $deliverOcon1);
            $data['officeAP1'][] = array('regap' => $apcancelReg, 'penap' => $apcancelPen, 'disap' => $apcancelRej, 'deliverap' => $apcancelDelv);
            $data['officeReclass1'][] = array('regap' => $reclassReg, 'penap' => $reclassPen, 'disap' => $reclassRej, 'deliverap' => $reclassDelv);
            $data['officeCert1'][] = array('regap' => $certReg, 'penap' => $certPen, 'disap' => $certRej, 'deliverap' => $certDelv);
            $data['officeMiscN1'][] = array('regap' => $regmName, 'penap' => $regmNamePen, 'disap' => $regmNameRej, 'deliverap' => $regmNameDel);
            $data['officeMiscD1'][] = array('regap' => $regmNameD, 'penap' => $regmNameDPen, 'disap' => $regmNameDRej, 'deliverap' => $regmNameDDel);
            //var_dump($data);
            // field start
            $q = "select mut_type,order_passed,is_dispose from Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and date(date_entry)<='$edate'  ";
            $Fb = $this->db->query($q)->result();
            foreach ($Fb as $d) {
                if ($d->mut_type == '01') {
                    $regFmut1 = $regFmut1 + 1;
                    if (($d->order_passed == null) and ( $d->is_dispose == null)) {
                        $penFmut1 = $penFmut1 + 1;
                    }
                    if ($d->is_dispose == 'Y' or $d->is_dispose == 'y') {
                        $disFmut1 = $disFmut1 + 1;
                    }elseif ($d->order_passed == 'Y' or $d->order_passed == 'y') {
                        $deliverFmut1 = $deliverFmut1 + 1;
                    }
                }
                if ($d->mut_type == '02') {
                    $regFpart1 = $regFpart1 + 1;
                    if (($d->order_passed == null) and ( $d->is_dispose == null)) {
                        $penFpart1 = $penFpart1 + 1;
                    }

                    if ($d->is_dispose == 'Y' or $d->is_dispose == 'y') {
                        $disFpart1 = $disFpart1 + 1;
                    }elseif ($d->order_passed == 'Y' or $d->order_passed == 'y') {
                        $deliverFpart1 = $deliverFpart1 + 1;
                    }
                }
            }
            $q = "select mut_type,order_passed,is_dispose from Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and date(date_entry) >='$sdate' and date(date_entry) <='$edate' ";
            //echo $q;
            $Fb = $this->db->query($q)->result();
            foreach ($Fb as $d) {
                if ($d->mut_type == '01') {
                    $regFmut = $regFmut + 1;
                    if (($d->order_passed == null) and ( $d->is_dispose == null)) {
                        $penFmut = $penFmut + 1;
                    }
                    if ($d->is_dispose == 'Y' or $d->is_dispose == 'y') {
                        $disFmut = $disFmut + 1;
                    }
                    if ($d->order_passed == 'Y' or $d->order_passed == 'y') {
                        $deliverFmut = $deliverFmut + 1;
                    }
                }
                if ($d->mut_type == '02') {
                    $regFpart = $regFpart + 1;
                    if (($d->order_passed == null) and ( $d->is_dispose == null)) {
                        $penFpart = $penFpart + 1;
                    }
                    if ($d->is_dispose == 'Y' or $d->is_dispose == 'y') {
                        $disFpart = $disFpart + 1;
                    }
                    if ($d->order_passed == 'Y' or $d->order_passed == 'y') {
                        $deliverFpart = $deliverFpart + 1;
                    }
                }
            }
            $data['fieldpart1'][] = array('regopart1' => $regFpart1, 'penopart1' => $penFpart1, 'disopart1' => $disFpart1, 'deliverfpart1' => $deliverFpart1);
            $data['fieldmut1'][] = array('regomut1' => $regFmut1, 'penomut1' => $penFmut1, 'disomut1' => $disFmut1, 'deliverfmut1' => $deliverFmut1);

            $data['fieldpart'][] = array('regopart' => $regFpart, 'penopart' => $penFpart, 'disopart' => $disFpart, 'deliverfpart' => $deliverFpart);
            $data['fieldmut'][] = array('regomut' => $regFmut, 'penomut' => $penFmut, 'disomut' => $disFmut, 'deliverfmut' => $deliverFmut);
       
        // var_dump($data);
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/disposecase_pp_2_dist', $data);
        // $this->load->view('../views/footer');
        $data['_view'] = 'misreport/disposecase_pp_2_dist';
        $this->load->view('layouts/main',$data);
    
    }
    public function DisposeForPPSubmit() {
		$db=  $this->session->userdata('db');
        $data = array();
        $regOpart = 0;
        $disOpart = 0;
        $penOpart = 0;
        $regOmut = 0;
        $disOmut = 0;
        $penOmut = 0;
        $regOcon = 0;
        $disOcon = 0;
        $penOcon = 0;
        $deliverOpart = 0;
        $deliverOmut = 0;
        $deliverOcon = 0;
        $regOpart1 = 0;
        $disOpart1 = 0;
        $penOpart1 = 0;
        $regOmut1 = 0;
        $disOmut1 = 0;
        $penOmut1 = 0;
        $regOcon1 = 0;
        $disOcon1 = 0;
        $penOcon1 = 0;
        $deliverOpart1 = 0;
        $deliverOcon1 = 0;
        $deliverOmut1 = 0;
        //        end office
        $regFpart = 0;
        $disFpart = 0;
        $penFpart = 0;
        $deliverFpart = 0;
        $regFmut = 0;
        $disFmut = 0;
        $penFmut = 0;
        $deliverFmut = 0;
        $regFpart1 = 0;
        $disFpart1 = 0;
        $penFpart1 = 0;
        $deliverFpart1 = 0;
        $regFmut1 = 0;
        $disFmut1 = 0;
        $penFmut1 = 0;
        $deliverFmut1 = 0;
        //        end field
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $sdate = $this->input->post('sdate');
        $sdate = date('Y-m-d', strtotime($sdate));
        $edate = $this->input->post('edate');
        $edate = date('Y-m-d', strtotime($edate));
        $locationData = array(
            'sdate' => $sdate,
            'edate' => $edate
        );
		$define_date=define_date;
        $this->session->set_userdata($locationData);
        $q = "select * from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and submission_date>='$sdate' and submission_date<='$edate' and (submission_date is not null)";
        $data['pb'] = $pb = $this->db->query($q)->result();
        foreach ($pb as $d) {
            //            partition cases
            if ($d->mut_type == '04') {
                $regOpart = $regOpart + 1;
                if (($d->status == 'P') or ( $d->status == null)) {
                    $penOpart = $penOpart + 1;
                } elseif ($d->status == 'D' or $d->status == 'd') {
                    $disOpart = $disOpart + 1;
                } elseif ($d->status == 'F' or $d->status == 'f') {
                    $deliverOpart = $deliverOpart + 1;
                }
            }
            //            end here
            if ($d->mut_type == '03') {
                $regOmut = $regOmut + 1;
                if (($d->status === 'P') or ( $d->status == null)) {
                    $penOmut = $penOmut + 1;
                }
                if ($d->status == 'D' or $d->status == 'd') {
                    $disOmut = $disOmut + 1;
                }
                if ($d->status == 'F' or $d->status == 'f') {
                    $deliverOmut = $deliverOmut + 1;
                }
            }
            //            mutation end here
            if ($d->mut_type == '01') {
                $regOcon = $regOcon + 1;
                if (($d->status === 'P') or ( $d->status == null)) {
                    $penOcon = $penOcon + 1;
                }
                if ($d->status == 'D' or $d->status == 'd') {
                    $disOcon = $disOcon + 1;
                }
                if ($d->status == 'F' or $d->status == 'f') {
                    $deliverOcon = $deliverOcon + 1;
                }
            }
            //            conversion end here
        }

        //        without range
        $q = "select * from    Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
        $data['pbb'] = $pbb = $this->db->query($q)->result();
        foreach ($pbb as $d) {
            //            partition cases
            if ($d->mut_type == '04') {
                $regOpart1 = $regOpart1 + 1;
                if (($d->status === 'P') or ( $d->status == null)) {
                    $penOpart1 = $penOpart1 + 1;
                } elseif ($d->status == 'D') {
                    $disOpart1 = $disOpart1 + 1;
                } elseif ($d->status == 'F') {
                    $deliverOpart1 = $deliverOpart1 + 1;
                }
            }
            //            end here
            if ($d->mut_type == '03') {
                $regOmut1 = $regOmut1 + 1;
                if (($d->status === 'P') or ( $d->status == null)) {
                    $penOmut1 = $penOmut1 + 1;
                } elseif ($d->status == 'D') {
                    $disOmut1 = $disOmut1 + 1;
                } elseif ($d->status == 'F' or $d->status == 'f') {
                    $deliverOmut1 = $deliverOmut1 + 1;
                }
            }
            //            mutation end here
            if ($d->mut_type == '01') {
                $regOcon1 = $regOcon1 + 1;
                if (($d->status === 'P') or ( $d->status == null)) {
                    $penOcon1 = $penOcon1 + 1;
                } elseif ($d->status == 'D' or $d->status == 'd') {
                    $disOcon1 = $disOcon1 + 1;
                } elseif ($d->status == 'F' or $d->status == 'f') {
                    $deliverOcon1 = $deliverOcon1 + 1;
                }
            }
            //            conversion end here
        }


        $data['officepart'] = array('regopart' => $regOpart, 'penopart' => $penOpart, 'disopart' => $disOpart, 'deliverpart' => $deliverOpart);
        $data['officemut'] = array('regomut' => $regOmut, 'penomut' => $penOmut, 'disomut' => $disOmut, 'delivermut' => $deliverOmut);
        $data['officecon'] = array('regocon' => $regOcon, 'penocon' => $penOcon, 'disocon' => $disOcon, 'delivercon' => $deliverOcon);

        $data['officepart1'] = array('regopart1' => $regOpart1, 'penopart1' => $penOpart1, 'disopart1' => $disOpart1, 'deliverpart1' => $deliverOpart1);
        $data['officemut1'] = array('regomut1' => $regOmut1, 'penomut1' => $penOmut1, 'disomut1' => $disOmut1, 'delivermut1' => $deliverOmut1);
        $data['officecon1'] = array('regocon1' => $regOcon1, 'penocon1' => $penOcon1, 'disocon1' => $disOcon1, 'delivercon1' => $deliverOcon1);
        // var_dump($data);
        // field start
        $q = "select * from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
        $Fb = $this->db->query($q)->result();
        foreach ($Fb as $d) {
            if ($d->mut_type == '01') {
                $regFmut1 = $regFmut1 + 1;
                if (($d->order_passed == null) and ( $d->is_dispose == null)) {
                    $penFmut1 = $penFmut1 + 1;
                }
                if ($d->is_dispose == 'Y' or $d->is_dispose == 'y') {
                    $disFmut1 = $disFmut1 + 1;
                }
                if ($d->order_passed == 'Y' or $d->order_passed == 'y') {
                    $deliverFmut1 = $deliverFmut1 + 1;
                }
            }
            if ($d->mut_type == '02') {
                $regFpart1 = $regFpart1 + 1;
                if (($d->order_passed == null) and ( $d->is_dispose == null)) {
                    $penFpart1 = $penFpart1 + 1;
                }

                if ($d->is_dispose == 'Y' or $d->is_dispose == 'y') {
                    $disFpart1 = $disFpart1 + 1;
                }
                if ($d->order_passed == 'Y' or $d->order_passed == 'y') {
                    $deliverFpart1 = $deliverFpart1 + 1;
                }
            }
        }
        $q = "select * from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and Report_date >='$sdate' and Report_date <='$edate' and (Report_date is not null)";
        //echo $q;
        $Fb = $this->db->query($q)->result();
        foreach ($Fb as $d) {
            if ($d->mut_type == '01') {
                $regFmut = $regFmut + 1;
                if (($d->order_passed == null) and ( $d->is_dispose == null)) {
                    $penFmut = $penFmut + 1;
                }
                if ($d->is_dispose == 'Y' or $d->is_dispose == 'y') {
                    $disFmut = $disFmut + 1;
                }
                if ($d->order_passed == 'Y' or $d->order_passed == 'y') {
                    $deliverFmut = $deliverFmut + 1;
                }
            }
            if ($d->mut_type == '02') {
                $regFpart = $regFpart + 1;
                if (($d->order_passed == null) and ( $d->is_dispose == null)) {
                    $penFpart = $penFpart + 1;
                }
                if ($d->is_dispose == 'Y' or $d->is_dispose == 'y') {
                    $disFpart = $disFpart + 1;
                }
                if ($d->order_passed == 'Y' or $d->order_passed == 'y') {
                    $deliverFpart = $deliverFpart + 1;
                }
            }
        }
        $data['fieldpart1'] = array('regopart1' => $regFpart1, 'penopart1' => $penFpart1, 'disopart1' => $disFpart1, 'deliverfpart1' => $deliverFpart1);
        $data['fieldmut1'] = array('regomut1' => $regFmut1, 'penomut1' => $penFmut1, 'disomut1' => $disFmut1, 'deliverfmut1' => $deliverFmut1);

        $data['fieldpart'] = array('regopart' => $regFpart, 'penopart' => $penFpart, 'disopart' => $disFpart, 'deliverfpart' => $deliverFpart);
        $data['fieldmut'] = array('regomut' => $regFmut, 'penomut' => $penFmut, 'disomut' => $disFmut, 'deliverfmut' => $deliverFmut);
        //var_dump($pb);
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/disposecase_pp_2', $data);
        // $this->load->view('../views/footer');
        $data['_view'] = 'misreport/disposecase_pp_2';
        $this->load->view('layouts/main',$data);
    }

    public function DisposeForPPSubmitDCLAO() {
		$data = array();
        //end field
        $dist_code = $this->session->userdata('dist_code');
        // $subdiv_code=$this->session->userdata('subdiv_code');
        // $cir_code=$this->session->userdata('cir_code');
        $sdate = $this->session->userdata('sdate');
        $sdate = date('Y-m-d', strtotime($sdate));
        $edate = $this->session->userdata('edate');
        $edate = date('Y-m-d', strtotime($edate));
        // $locationData = array(
            // 'sdate' => $sdate,
            // 'edate' => $edate
        // );
        // $this->session->set_userdata($locationData);
        
        $define_date=define_date;
        $q = "SELECT * FROM location WHERE dist_code='$dist_code' and subdiv_code!='00' and cir_code != '00' and Mouza_Pargona_code = '00' and Lot_no= '00' and vill_townprt_code = '00000'";
        //echo $q;
        $data['loc'] = $values = $this->db->query($q)->result();
        //var_dump($values);
        foreach ($values as $v) {
            $regOpart = 0;
            $disOpart = 0;
            $penOpart = 0;
            $regOmut = 0;
            $disOmut = 0;
            $penOmut = 0;
            $regOcon = 0;
            $disOcon = 0;
            $penOcon = 0;
            $deliverOpart = 0;
            $deliverOmut = 0;
            $deliverOcon = 0;
            $regOpart1 = 0;
            $disOpart1 = 0;
            $penOpart1 = 0;
            $regOmut1 = 0;
            $disOmut1 = 0;
            $penOmut1 = 0;
            $regOcon1 = 0;
            $disOcon1 = 0;
            $penOcon1 = 0;
            $deliverOpart1 = 0;
            $deliverOcon1 = 0;
            $deliverOmut1 = 0;
            
            //        end office
            $regFpart = 0;
            $disFpart = 0;
            $penFpart = 0;
            $deliverFpart = 0;
            $regFmut = 0;
            $disFmut = 0;
            $penFmut = 0;
            $deliverFmut = 0;
            $regFpart1 = 0;
            $disFpart1 = 0;
            $penFpart1 = 0;
            $deliverFpart1 = 0;
            $regFmut1 = 0;
            $disFmut1 = 0;
            $penFmut1 = 0;
            $deliverFmut1 = 0;
            ///////AP///////
            $apcancelReg=0;
            $apcancelPen=0;
            $apcancelRej=0;
            $apcancelDelv=0;
            
            $apcancelRegT=0;
            $apcancelPenT=0;
            $apcancelRejT=0;
            $apcancelDelvT=0;
            ////////Reclass///////////
            $reclassReg=0;
            $reclassPen=0;
            $reclassRej=0;
            $reclassDelv=0;
            
            $reclassRegT=0;
            $reclassPenT=0;
            $reclassRejT=0;
            $reclassDelvT=0;
            //////Jamabandi/////
            $certReg=0;
            $certPen=0;
            $certRej=0;
            $certDelv=0;
            
            $certRegT=0;
            $certPenT=0;
            $certRejT=0;
            $certDelvT=0;
            ///////////
            
            $q = "select mut_type,status from Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$v->subdiv_code' and cir_code='$v->cir_code' and date(submission_date)>='$sdate' and date(submission_date)<='$edate' and (submission_date is not null)";
            $data['pb'] = $pb = $this->db->query($q)->result();
            foreach ($pb as $d) {
                //            partition cases
                if ($d->mut_type == '04') {
                    $regOpart = $regOpart + 1;
                    if (($d->status == 'P') or ( $d->status == null)) {
                        $penOpart = $penOpart + 1;
                    } elseif ($d->status == 'D' or $d->status == 'd') {
                        $disOpart = $disOpart + 1;
                    } elseif ($d->status == 'F' or $d->status == 'f') {
                        $deliverOpart = $deliverOpart + 1;
                    }
                }
                //            end here
                if ($d->mut_type == '03') {
                    $regOmut = $regOmut + 1;
                    if (($d->status === 'P') or ( $d->status == null)) {
                        $penOmut = $penOmut + 1;
                    }
                    if ($d->status == 'D' or $d->status == 'd') {
                        $disOmut = $disOmut + 1;
                    }
                    if ($d->status == 'F' or $d->status == 'f') {
                        $deliverOmut = $deliverOmut + 1;
                    }
                }
                //            mutation end here
                if ($d->mut_type == '01') {
                    $regOcon = $regOcon + 1;
                    if (($d->status === 'P') or ( $d->status == null)) {
                        $penOcon = $penOcon + 1;
                    }
                    if ($d->status == 'D' or $d->status == 'd') {
                        $disOcon = $disOcon + 1;
                    }
                    if ($d->status == 'F' or $d->status == 'f') {
                        $deliverOcon = $deliverOcon + 1;
                    }
                }
                //            conversion end here
            }

            //        without range
            $q = "select mut_type,status from Petition_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$v->subdiv_code' and cir_code='$v->cir_code' and date(date_entry)<='$edate' ";
            $data['pbb'] = $pbb = $this->db->query($q)->result();
            foreach ($pbb as $d) {
                //            partition cases
                if ($d->mut_type == '04') {
                    $regOpart1 = $regOpart1 + 1;
                    if (($d->status === 'P') or ( $d->status == null)) {
                        $penOpart1 = $penOpart1 + 1;
                    } elseif ($d->status == 'D') {
                        $disOpart1 = $disOpart1 + 1;
                    } elseif ($d->status == 'F') {
                        $deliverOpart1 = $deliverOpart1 + 1;
                    }
                }
                //            end here
                if ($d->mut_type == '03') {
                    $regOmut1 = $regOmut1 + 1;
                    if (($d->status === 'P') or ( $d->status == null)) {
                        $penOmut1 = $penOmut1 + 1;
                    } elseif ($d->status == 'D') {
                        $disOmut1 = $disOmut1 + 1;
                    } elseif ($d->status == 'F' or $d->status == 'f') {
                        $deliverOmut1 = $deliverOmut1 + 1;
                    }
                }
                //            mutation end here
                if ($d->mut_type == '01') {
                    $regOcon1 = $regOcon1 + 1;
                    if (($d->status === 'P') or ( $d->status == null)) {
                        $penOcon1 = $penOcon1 + 1;
                    } elseif ($d->status == 'D' or $d->status == 'd') {
                        $disOcon1 = $disOcon1 + 1;
                    } elseif ($d->status == 'F' or $d->status == 'f') {
                        $deliverOcon1 = $deliverOcon1 + 1;
                    }
                }
                //            conversion end here
            }
            //AP cancellation/////////////////
            $sql = "Select * from apcancel_petition_basic where dist_code ='$dist_code'  and subdiv_code='$v->subdiv_code' and cir_code='$v->cir_code' and date(submission_date)>='$sdate' and date(submission_date)<='$edate' ";
            $apcancellation['registercase'] = $this->db->query($sql)->result();
            //var_dump($apcancellation['registercase']);
            foreach($apcancellation['registercase'] as $ap){
                $apcancelReg = $apcancelReg + 1;
                if($ap->order_passed=='Y' or $ap->co_chitha_corrected_yn=='Y' or $ap->co_chitha_corrected_yn=='y' ){
                    $apcancelDelv=$apcancelDelv+1;
                }
                if($ap->order_passed!='Y'){
                    $apcancelPen=$apcancelPen+1;
                }
                if($ap->dc_approval_yn=='N'){
                    $apcancelRej=$apcancelRej+1;
                }
            }
            
            $sql = "Select * from apcancel_petition_basic where dist_code ='$dist_code'  and subdiv_code='$v->subdiv_code' and cir_code='$v->cir_code' and date(submission_date)<='$edate'  ";  
            $apcancellation['apTotal'] = $this->db->query($sql)->result();
            foreach($apcancellation['apTotal'] as $ap){
                $apcancelRegT = $apcancelRegT + 1;
                if($ap->order_passed=='Y' or $ap->co_chitha_corrected_yn=='Y' or $ap->co_chitha_corrected_yn=='y' ){
                    $apcancelDelvT=$apcancelDelvT+1;
                }
                if($ap->order_passed!='Y'){
                    $apcancelPenT=$apcancelPenT+1;
                }
                if($ap->dc_approval_yn=='N'){
                    $apcancelRejT=$apcancelRejT+1;
                }
            }
            ////////////End AP////////////////////
            ////////////Reclass/////////////////
            $sql = "Select * from t_reclassification where dist_code ='$dist_code'  and subdiv_code='$v->subdiv_code' and cir_code='$v->cir_code' and date(lm_date)>='$sdate' and date(lm_date)<='$edate' ";
            $apcancellation['registerR'] = $this->db->query($sql)->result();
            //var_dump($apcancellation['registercase']);
            foreach($apcancellation['registerR'] as $ap){
                $reclassReg = $reclassReg + 1;
                if($ap->rkg_chitha_updated_yn=='Y'){
                    $reclassDelv=$reclassDelv+1;
                }
                if($ap->rkg_chitha_updated_yn!='Y' and $ap->status!='R'){
                    $reclassPen=$reclassPen+1;
                }
                if($ap->status=='R'){
                    $reclassRej=$reclassRej+1;
                }
            }
            
            $sql = "Select * from t_reclassification where dist_code ='$dist_code'  and subdiv_code='$v->subdiv_code' and cir_code='$v->cir_code' and date(lm_date)<='$edate'  ";   
            $apcancellation['reTotal'] = $this->db->query($sql)->result();
            foreach($apcancellation['reTotal'] as $ap){
                $reclassRegT = $reclassRegT + 1;
                if($ap->rkg_chitha_updated_yn=='Y'){
                    $reclassDelvT=$reclassDelvT+1;
                }
                if($ap->rkg_chitha_updated_yn!='Y' and $ap->status!='R'){
                    $reclassPenT=$reclassPenT+1;
                }
                if($ap->status=='R'){
                    $reclassRejT=$reclassRejT+1;
                }
            }
            ////////////End Reclass////////////////////
            ////////////Cert Application/////////////////
            $sql = "Select * from cert_application where dist_code ='$dist_code'  and subdiv_code='$v->subdiv_code' and cir_code='$v->cir_code' and date_entry>='$sdate' and date_entry<='$edate' ";
            $apcancellation['registerCert'] = $this->db->query($sql)->result();
            //var_dump($apcancellation['registercase']);
            foreach($apcancellation['registerCert'] as $ap){
                $certReg = $certReg + 1;
                if($ap->status=='D'){
                    $certDelv=$certDelv+1;
                }
                if($ap->status!='D'){
                    $certPen=$certPen+1;
                }
                if($ap->status=='F'){
                    $certRej=$certRej+1;
                }
            }
            
            $sql = "Select * from cert_application where dist_code ='$dist_code'  and subdiv_code='$v->subdiv_code' and cir_code='$v->cir_code' and date_entry<='$edate'  ";    
            $apcancellation['reTotal'] = $this->db->query($sql)->result();
            foreach($apcancellation['reTotal'] as $ap){
                $certRegT = $certRegT + 1;
                if($ap->status=='D'){
                    $certDelvT=$certDelvT+1;
                }
                if($ap->status!='D'){
                    $certPenT=$certPenT+1;
                }
                if($ap->status=='F'){
                    $certRejT=$certRejT+1;
                }
            }
            ////////////End Reclass////////////////////
            ////////////Misc Case/////////////////
            $regmName=0;$regmNameD=0;
            $regmNamePen=0;$regmNameDPen=0;
            $regmNameDel=0;$regmNameDDel=0;
            $regmNameRej=0;$regmNameDRej=0;
            
            $regmNameT=0;$regmNameDT=0;
            $regmNamePenT=0;$regmNameDPenT=0;
            $regmNameDelT=0;$regmNameDDelT=0;
            $regmNameRejT=0;$regmNameDRejT=0;
            $sql = "Select * from misc_case_basic where dist_code ='$dist_code'  and subdiv_code='$v->subdiv_code' and cir_code='$v->cir_code' and date(submission_date)>='$sdate' and date(submission_date)<='$edate' ";
            $apcancellation['registerMisc'] = $this->db->query($sql)->result();
            //var_dump($apcancellation['registercase']);
            foreach($apcancellation['registerMisc'] as $d){
                if ($d->misc_case_type == '06') {
                    $regmName= $regmName + 1;
                    if (($d->status == '18') ) {
                        $regmNameDel = $regmNameDel + 1;
                    } elseif ($d->status == 'F') {
                        $regmNameRej = $regmNameRej + 1;
                    } elseif ($d->status != '18' or $d->status != 'F') {
                        $regmNamePen = $regmNamePen + 1;
                    }
                }
                if ($d->misc_case_type == '07') {
                    $regmNameD= $regmNameD + 1;
                    if (($d->status == '18') ) {
                        $regmNameDDel = $regmNameDDel + 1;
                    } elseif ($d->status == 'F') {
                        $regmNameDRej = $regmNameDRej + 1;
                    } elseif ($d->status != '18' or $d->status != 'F') {
                        $regmNameDPen = $regmNameDPen + 1;
                    }
                }
            }
            
            $sql = "Select * from misc_case_basic where dist_code ='$dist_code'  and subdiv_code='$v->subdiv_code' and cir_code='$v->cir_code' and date(submission_date)<='$edate'  ";  
            $apcancellation['registerMiscT'] = $this->db->query($sql)->result();
            foreach($apcancellation['registerMiscT'] as $d){
                if ($d->misc_case_type == '06') {
                    $regmNameT= $regmNameT + 1;
                    if (($d->status == '18') ) {
                        $regmNameDelT = $regmNameDelT + 1;
                    } elseif ($d->status == 'F') {
                        $regmNameRejT = $regmNameRejT + 1;
                    } elseif ($d->status != '18' or $d->status != 'F') {
                        $regmNamePenT = $regmNamePenT + 1;
                    }
                }
                if ($d->misc_case_type == '07') {
                    $regmNameDT= $regmNameDT + 1;
                    if (($d->status == '18') ) {
                        $regmNameDDelT = $regmNameDDelT + 1;
                    } elseif ($d->status == 'F') {
                        $regmNameDRejT = $regmNameDRejT + 1;
                    } elseif ($d->status != '18' or $d->status != 'F') {
                        $regmNameDPenT = $regmNameDPenT + 1;
                    }
                }
            }
            ////////////End Reclass////////////////////
            $data['officepart'][] = array('regopart' => $regOpart, 'penopart' => $penOpart, 'disopart' => $disOpart, 'deliverpart' => $deliverOpart);
            $data['officemut'][] = array('regomut' => $regOmut, 'penomut' => $penOmut, 'disomut' => $disOmut, 'delivermut' => $deliverOmut);
            $data['officecon'][] = array('regocon' => $regOcon, 'penocon' => $penOcon, 'disocon' => $disOcon, 'delivercon' => $deliverOcon);
            $data['officeAP'][] = array('regap' => $apcancelRegT, 'penap' => $apcancelPenT, 'disap' => $apcancelRejT, 'deliverap' => $apcancelDelvT);
            $data['officeReclass'][] = array('regap' => $reclassRegT, 'penap' => $reclassPenT, 'disap' => $reclassRejT, 'deliverap' => $reclassDelvT);
            $data['officeCert'][] = array('regap' => $certRegT, 'penap' => $certPenT, 'disap' => $certRejT, 'deliverap' => $certDelvT);
            $data['officeMiscN'][] = array('regap' => $regmNameT, 'penap' => $regmNamePenT, 'disap' => $regmNameRejT, 'deliverap' => $regmNameDelT);
            $data['officeMiscD'][] = array('regap' => $regmNameDT, 'penap' => $regmNameDPenT, 'disap' => $regmNameDRejT, 'deliverap' => $regmNameDDelT);

            $data['officepart1'][] = array('regopart1' => $regOpart1, 'penopart1' => $penOpart1, 'disopart1' => $disOpart1, 'deliverpart1' => $deliverOpart1);
            $data['officemut1'][] = array('regomut1' => $regOmut1, 'penomut1' => $penOmut1, 'disomut1' => $disOmut1, 'delivermut1' => $deliverOmut1);
            $data['officecon1'][] = array('regocon1' => $regOcon1, 'penocon1' => $penOcon1, 'disocon1' => $disOcon1, 'delivercon1' => $deliverOcon1);
            $data['officeAP1'][] = array('regap' => $apcancelReg, 'penap' => $apcancelPen, 'disap' => $apcancelRej, 'deliverap' => $apcancelDelv);
            $data['officeReclass1'][] = array('regap' => $reclassReg, 'penap' => $reclassPen, 'disap' => $reclassRej, 'deliverap' => $reclassDelv);
            $data['officeCert1'][] = array('regap' => $certReg, 'penap' => $certPen, 'disap' => $certRej, 'deliverap' => $certDelv);
            $data['officeMiscN1'][] = array('regap' => $regmName, 'penap' => $regmNamePen, 'disap' => $regmNameRej, 'deliverap' => $regmNameDel);
            $data['officeMiscD1'][] = array('regap' => $regmNameD, 'penap' => $regmNameDPen, 'disap' => $regmNameDRej, 'deliverap' => $regmNameDDel);
            //var_dump($data);
            // field start
            $q = "select mut_type,order_passed,is_dispose from Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and date(date_entry)<='$edate' and subdiv_code='$v->subdiv_code' and cir_code='$v->cir_code' ";
            $Fb = $this->db->query($q)->result();
            foreach ($Fb as $d) {
                if ($d->mut_type == '01') {
                    $regFmut1 = $regFmut1 + 1;
                    if (($d->order_passed == null) and ( $d->is_dispose == null)) {
                        $penFmut1 = $penFmut1 + 1;
                    }
                    if ($d->is_dispose == 'Y' or $d->is_dispose == 'y') {
                        $disFmut1 = $disFmut1 + 1;
                    }elseif ($d->order_passed == 'Y' or $d->order_passed == 'y') {
                        $deliverFmut1 = $deliverFmut1 + 1;
                    }
                }
                if ($d->mut_type == '02') {
                    $regFpart1 = $regFpart1 + 1;
                    if (($d->order_passed == null) and ( $d->is_dispose == null)) {
                        $penFpart1 = $penFpart1 + 1;
                    }

                    if ($d->is_dispose == 'Y' or $d->is_dispose == 'y') {
                        $disFpart1 = $disFpart1 + 1;
                    }elseif ($d->order_passed == 'Y' or $d->order_passed == 'y') {
                        $deliverFpart1 = $deliverFpart1 + 1;
                    }
                }
            }
            $q = "select mut_type,order_passed,is_dispose from Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$v->subdiv_code' and cir_code='$v->cir_code' and date(date_entry) >='$sdate' and date(date_entry) <='$edate' ";
            //echo $q;
            $Fb = $this->db->query($q)->result();
            foreach ($Fb as $d) {
                if ($d->mut_type == '01') {
                    $regFmut = $regFmut + 1;
                    if (($d->order_passed == null) and ( $d->is_dispose == null)) {
                        $penFmut = $penFmut + 1;
                    }
                    if ($d->is_dispose == 'Y' or $d->is_dispose == 'y') {
                        $disFmut = $disFmut + 1;
                    }
                    if ($d->order_passed == 'Y' or $d->order_passed == 'y') {
                        $deliverFmut = $deliverFmut + 1;
                    }
                }
                if ($d->mut_type == '02') {
                    $regFpart = $regFpart + 1;
                    if (($d->order_passed == null) and ( $d->is_dispose == null)) {
                        $penFpart = $penFpart + 1;
                    }
                    if ($d->is_dispose == 'Y' or $d->is_dispose == 'y') {
                        $disFpart = $disFpart + 1;
                    }
                    if ($d->order_passed == 'Y' or $d->order_passed == 'y') {
                        $deliverFpart = $deliverFpart + 1;
                    }
                }
            }
            $data['fieldpart1'][] = array('regopart1' => $regFpart1, 'penopart1' => $penFpart1, 'disopart1' => $disFpart1, 'deliverfpart1' => $deliverFpart1);
            $data['fieldmut1'][] = array('regomut1' => $regFmut1, 'penomut1' => $penFmut1, 'disomut1' => $disFmut1, 'deliverfmut1' => $deliverFmut1);

            $data['fieldpart'][] = array('regopart' => $regFpart, 'penopart' => $penFpart, 'disopart' => $disFpart, 'deliverfpart' => $deliverFpart);
            $data['fieldmut'][] = array('regomut' => $regFmut, 'penomut' => $penFmut, 'disomut' => $disFmut, 'deliverfmut' => $deliverFmut);
        }
        $data['_view'] = 'misreport/disposecase_pp_2_dclao';
        $this->load->view('layouts/main',$data);
    }

    public function DisposeForMonths() {
		$db=  $this->session->userdata('db');
        $data = array();
        $disOpart_1 = 0;
        $penOpart_1 = 0;
        $disOpart_2 = 0;
        $penOpart_2 = 0;
        $disOmut_1 = 0;
        $disOmut_2 = 0;
        $penOmut_1 = 0;
        $penOmut_2 = 0;
        $disOcon_1 = 0;
        $penOcon_1 = 0;
        $disOcon_2 = 0;
        $penOcon_2 = 0;

        $disFpart_1 = 0;
        $penFpart_1 = 0;
        $disFpart_2 = 0;
        $penFpart_2 = 0;
        $disFmut_1 = 0;
        $penFmut_1 = 0;
        $disFmut_2 = 0;
        $penFmut_2 = 0;
        $deliverFpart_1 = 0;
        $deliverFpart_2 = 0;
        $deliverOmut_2 = 0;
        $deliverOmut_1 = 0;
        $deliverOpart_1 = 0;
        $deliverOpart_2 = 0;
        $deliverOcon_2 = 0;
        $deliverOcon_1 = 0;
        $deliverFmut_2 = 0;
        $deliverFmut_1 = 0;
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
		$define_date=define_date;

        $q = "Select * from    petition_basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
        //echo $q;
        $pb = $this->db->query($q)->result();
        foreach ($pb as $d) {
            $st_date = date('Y-m-d', strtotime($d->submission_date));
            //  $st_date='2015-11-03';
            $en_date = date('Y-m-d', strtotime($d->date_entry));
            $cur_date = date('Y-m-d');
            $diff = abs(strtotime($en_date) - strtotime($st_date));
            $days = floor(($diff ) / (60 * 60 * 24));
            $curdiff = abs(strtotime($cur_date) - strtotime($st_date));
            $pendays = floor(($curdiff) / (60 * 60 * 24));
            //exit;
            if ($d->mut_type == '03') {
                if ($d->status == 'P' or $d->status == null) {
                    if ($pendays < 60) {
                        $penOmut_1 = $penOmut_1 + 1;
                    } elseif ($pendays > 60 and $pendays <= 90) {
                        $penOmut_2 = $penOmut_2 + 1;
                    }
                }
                if ($d->status == 'D') {
                    if ($days < 60) {
                        $disOmut_1 = $disOmut_1 + 1;
                    } elseif ($days > 60 and $days <= 90) {
                        $disOmut_2 = $disOmut_2 + 1;
                    }
                }
                if ($d->status == 'F' or $d->status == 'f') {
                    if ($days < 60) {
                        $deliverOmut_1 = $deliverOmut_1 + 1;
                    } elseif ($days > 90 and $pendays <= 90) {
                        $deliverOmut_2 = $deliverOmut_2 + 1;
                    }
                }
            }
            //mutation end
            if ($d->mut_type == '04') {
                if ($d->status == 'P' or $d->status == null) {
                    // echo $pendays."day<br>";
                    if ($pendays < 60) {
                        $penOpart_1 = $penOpart_1 + 1;
                    } elseif ($pendays >= 90) {
                        $penOpart_2 = $penOpart_2 + 1;
                    }
                }
                if ($d->status == 'D') {
                    if ($days < 60) {
                        $disOpart_1 = $disOpart_1 + 1;
                    } elseif ($days > 60 and $days <= 90) {
                        $disOpart_2 = $disOpart_2 + 1;
                    }
                }
                if ($d->status == 'F') {
                    if ($days < 60) {
                        $deliverOpart_1 = $deliverOpart_1 + 1;
                    } elseif ($days > 60 and $days <= 90) {
                        $deliverOpart_2 = $deliverOpart_2 + 1;
                    }
                }
            }
            //partition end
            if ($d->mut_type == '01') {
                if ($d->status == 'P' or $d->status == null) {
                    if ($pendays < 60) {
                        $penOcon_1 = $penOcon_1 + 1;
                    } elseif ($pendays > 60 and $pendays <= 90) {
                        $penOcon_2 = $penOcon_2 + 1;
                    }
                }
                if ($d->status == 'D') {
                    if ($days < 60) {
                        $disOcon_1 = $disOcon_1 + 1;
                    } elseif ($days > 60 and $days <= 90) {
                        $disOcon_2 = $disOcon_2 + 1;
                    }
                }
                if ($d->status == 'F') {
                    if ($days < 60) {
                        $deliverOcon_1 = $deliverOcon_1 + 1;
                    } elseif ($days > 60 and $days <= 90) {
                        $deliverOcon_2 = $deliverOcon_2 + 1;
                    }
                }
            }
            //conversion end
        }

        //var_dump($pb);
        $q = "Select * from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  ";
        $fb = $this->db->query($q)->result();
        foreach ($fb as $d) {
            $st_date = (date('Y-m-d', strtotime($d->report_date)));
            $en_date = (date('Y-m-d', strtotime($d->date_of_order)));
            $cur_date = (date('Y-m-d', time()));
            //date_diff($en_date,$st_date,absolute);
            $diff = abs(strtotime($en_date) - strtotime($st_date));
            $days = floor(($diff) / (60 * 60 * 24));
            // echo "/";
            $curdiff = abs(strtotime($cur_date) - strtotime($st_date));

            $pendays = floor(($curdiff ) / (60 * 60 * 24));

            if ($d->mut_type == '01') {
                if ($d->order_passed == null and $d->is_dispose == null) {
                    if ($pendays <= 90) {
                        $penFmut_1 = $penFmut_1 + 1;
                    }
                    if ($pendays > '90') {
                        $penFmut_2 = $penFmut_2 + 1;
                    }
                }
                if ($d->is_dispose == 'Y') {
                    if ($days <= '90') {
                        $disFmut_1 = $disFmut_1 + 1;
                    }
                    if ($days > '90') {
                        $disFmut_2 = $disFmut_2 + 1;
                    }
                }
                if ($d->order_passed == 'Y' or $d->order_passed == 'y') {
                    if ($days <= '90') {
                        $deliverFmut_1 = $deliverFmut_1 + 1;
                    }
                    if ($days > '90') {
                        $deliverFmut_2 = $deliverFmut_2 + 1;
                    }
                }
            }
            if ($d->mut_type == '02') {
                if ($d->order_passed == null and $d->is_dispose == null) {
                    if ($pendays <= '90') {
                        $penFpart_1 = $penFpart_1 + 1;
                    }
                    if ($pendays > '90') {
                        $penFpart_2 = $penFpart_2 + 1;
                    }
                }
                if ($d->is_dispose == 'Y') {
                    if ($days <= '90') {
                        $disFpart_1 = $disFpart_1 + 1;
                    }
                    if ($days > '90') {
                        $disFpart_2 = $disFpart_2 + 1;
                    }
                }
                if ($d->order_passed == 'Y' or $d->order_passed == 'y') {
                    if ($days <= '90') {
                        $deliverFpart_1 = $deliverFpart_1 + 1;
                    }
                    if ($days > '90') {
                        $deliverFpart_2 = $deliverFpart_2 + 1;
                    }
                }
            }
        }
        // echo $disOpart_2;
        $data['Opart'] = array('dispo_2' => $disOpart_1, 'dispo_3' => $disOpart_2, 'pen_2' => $penOpart_1, 'pen_3' => $penOpart_2, 'deliver_2' => $deliverOpart_1, 'deliver_3' => $deliverOpart_2);
        $data['Omut'] = array('dispo_2' => $disOmut_1, 'dispo_3' => $disOmut_2, 'pen_2' => $penOmut_1, 'pen_3' => $penOmut_2, 'deliver_2' => $deliverOmut_1, 'deliver_3' => $deliverOmut_2);
        $data['Ocon'] = array('dispo_2' => $disOcon_1, 'dispo_3' => $disOcon_2, 'pen_2' => $penOcon_1, 'pen_3' => $penOcon_2, 'deliver_2' => $deliverOcon_1, 'deliver_3' => $deliverOcon_2);

        $data['Fpart'] = array('dispo_2' => $disFpart_1, 'dispo_3' => $disFpart_2, 'pen_2' => $penFpart_1, 'pen_3' => $penFpart_2, 'deliver_2' => $deliverFpart_1, 'deliver_3' => $deliverFpart_2);
        $data['Fmut'] = array('dispo_2' => $disFmut_1, 'dispo_3' => $disFmut_2, 'pen_2' => $penFmut_1, 'pen_3' => $penFmut_2, 'deliver_2' => $deliverFmut_1, 'deliver_3' => $deliverFmut_2);
        //var_dump($data);
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/disposecase_fm_1', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/disposecase_fm_1';
        $this->load->view('layouts/main',$data);
    }

    public function DisposeForMonthsDCLAO() {
		$db=  $this->session->userdata('db');
        $data = array();

        $dist_code = $this->session->userdata('dist_code');
		$define_date=define_date;
        //$subdiv_code=$this->session->userdata('subdiv_code');
        //$cir_code=$this->session->userdata('cir_code');
        $q = "SELECT * FROM location WHERE dist_code='$dist_code' and subdiv_code!='00' and cir_code != '00' and Mouza_Pargona_code = '00' and Lot_no= '00' and vill_townprt_code = '00000'";
        $data['loc'] = $values = $this->db->query($q)->result();
        foreach ($values as $v) {
            $disOpart_1 = 0;
            $penOpart_1 = 0;
            $disOpart_2 = 0;
            $penOpart_2 = 0;
            $disOmut_1 = 0;
            $disOmut_2 = 0;
            $penOmut_1 = 0;
            $penOmut_2 = 0;
            $disOcon_1 = 0;
            $penOcon_1 = 0;
            $disOcon_2 = 0;
            $penOcon_2 = 0;

            $disFpart_1 = 0;
            $penFpart_1 = 0;
            $disFpart_2 = 0;
            $penFpart_2 = 0;
            $disFmut_1 = 0;
            $penFmut_1 = 0;
            $disFmut_2 = 0;
            $penFmut_2 = 0;
            $deliverFpart_1 = 0;
            $deliverFpart_2 = 0;
            $deliverOmut_2 = 0;
            $deliverOmut_1 = 0;
            $deliverOpart_1 = 0;
            $deliverOpart_2 = 0;
            $deliverOcon_2 = 0;
            $deliverOcon_1 = 0;
            $deliverFmut_2 = 0;
            $deliverFmut_1 = 0;
            $q = "Select * from    petition_basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$v->subdiv_code' and cir_code='$v->cir_code'";
            $pb = $this->db->query($q)->result();
            foreach ($pb as $d) {
                $st_date = date('Y-m-d', strtotime($d->submission_date));
                $en_date = date('Y-m-d', strtotime($d->date_entry));
                $cur_date = date('Y-m-d');
                $diff = abs(strtotime($en_date) - strtotime($st_date));
                $days = floor(($diff ) / (60 * 60 * 24));
                $curdiff = abs(strtotime($cur_date) - strtotime($st_date));
                $pendays = floor(($curdiff) / (60 * 60 * 24));
                //exit;
                if ($d->mut_type == '03') {
                    if ($d->status == 'P' or $d->status == null) {
                        if ($pendays < 60) {
                            $penOmut_1 = $penOmut_1 + 1;
                        } elseif ($pendays >= 90) {
                            $penOmut_2 = $penOmut_2 + 1;
                        }
                    }
                    if ($d->status == 'D') {
                        if ($days < 60) {
                            $disOmut_1 = $disOmut_1 + 1;
                        } elseif ($days >= 90) {
                            $disOmut_2 = $disOmut_2 + 1;
                        }
                    }
                    if ($d->status == 'F' or $d->status == 'f') {
                        if ($days < 60) {
                            $deliverOmut_1 = $deliverOmut_1 + 1;
                        } elseif ($days >= 90) {
                            $deliverOmut_2 = $deliverOmut_2 + 1;
                        }
                    }
                }
                //mutation end
                if ($d->mut_type == '04') {
                    if ($d->status == 'P' or $d->status == null) {
                        // echo $pendays."day<br>";
                        if ($pendays < 60) {
                            $penOpart_1 = $penOpart_1 + 1;
                        } elseif ($pendays >= 90) {
                            $penOpart_2 = $penOpart_2 + 1;
                        }
                    }
                    if ($d->status == 'D') {
                        if ($days < 60) {
                            $disOpart_1 = $disOpart_1 + 1;
                        } elseif ($days >= 90) {
                            $disOpart_2 = $disOpart_2 + 1;
                        }
                    }
                    if ($d->status == 'F') {
                        if ($days < 60) {
                            $deliverOpart_1 = $deliverOpart_1 + 1;
                        } elseif ($days >= 90) {
                            $deliverOpart_2 = $deliverOpart_2 + 1;
                        }
                    }
                }
                //partition end
                if ($d->mut_type == '01') {
                    if ($d->status == 'P' or $d->status == null) {
                        if ($pendays < 60) {
                            $penOcon_1 = $penOcon_1 + 1;
                        } elseif ($pendays >= 90) {
                            $penOcon_2 = $penOcon_2 + 1;
                        }
                    }
                    if ($d->status == 'D') {
                        if ($days < 60) {
                            $disOcon_1 = $disOcon_1 + 1;
                        } elseif ($days >= 90) {
                            $disOcon_2 = $disOcon_2 + 1;
                        }
                    }
                    if ($d->status == 'F') {
                        if ($days < 60) {
                            $deliverOcon_1 = $deliverOcon_1 + 1;
                        } elseif ($days >= 90) {
                            $deliverOcon_2 = $deliverOcon_2 + 1;
                        }
                    }
                }
                //conversion end
            }

            //var_dump($pb);
            $q = "Select * from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$v->subdiv_code' and cir_code='$v->cir_code'  ";
            $fb = $this->db->query($q)->result();
            foreach ($fb as $d) {
                $st_date = (date('Y-m-d', strtotime($d->report_date)));
                $en_date = (date('Y-m-d', strtotime($d->date_of_order)));
                $cur_date = (date('Y-m-d', time()));
                //date_diff($en_date,$st_date,absolute);
                $diff = abs(strtotime($en_date) - strtotime($st_date));
                $days = floor(($diff) / (60 * 60 * 24));
                // echo "/";
                $curdiff = abs(strtotime($cur_date) - strtotime($st_date));

                $pendays = floor(($curdiff ) / (60 * 60 * 24));

                if ($d->mut_type == '01') {
                    if ($d->order_passed == null and $d->is_dispose == null) {
                        if ($pendays < 60) {
                            $penFmut_1 = $penFmut_1 + 1;
                        }
                        if ($pendays >= 90) {
                            $penFmut_2 = $penFmut_2 + 1;
                        }
                    }
                    if ($d->is_dispose == 'Y') {
                        if ($days < 60) {
                            $disFmut_1 = $disFmut_1 + 1;
                        }
                        if ($days >= 90) {
                            $disFmut_2 = $disFmut_2 + 1;
                        }
                    }
                    if ($d->order_passed == 'Y' or $d->order_passed == 'y') {
                        if ($days < 60) {
                            $deliverFmut_1 = $deliverFmut_1 + 1;
                        }
                        if ($days >= 90) {
                            $deliverFmut_2 = $deliverFmut_2 + 1;
                        }
                    }
                }
                if ($d->mut_type == '02') {
                    if ($d->order_passed == null and $d->is_dispose == null) {
                        if ($pendays < '60') {
                            $penFpart_1 = $penFpart_1 + 1;
                        }
                        if ($pendays >= '90') {
                            $penFpart_2 = $penFpart_2 + 1;
                        }
                    }
                    if ($d->is_dispose == 'Y') {
                        if ($days < '60') {
                            $disFpart_1 = $disFpart_1 + 1;
                        }
                        if ($days >= '90') {
                            $disFpart_2 = $disFpart_2 + 1;
                        }
                    }
                    if ($d->order_passed == 'Y' or $d->order_passed == 'y') {
                        if ($days < '60') {
                            $deliverFpart_1 = $deliverFpart_1 + 1;
                        }
                        if ($days > '90') {
                            $deliverFpart_2 = $deliverFpart_2 + 1;
                        }
                    }
                }
            }
            // echo $disOpart_2;
            $data['Opart'][] = array('dispo_2' => $disOpart_1, 'dispo_3' => $disOpart_2, 'pen_2' => $penOpart_1, 'pen_3' => $penOpart_2, 'deliver_2' => $deliverOpart_1, 'deliver_3' => $deliverOpart_2);
            $data['Omut'][] = array('dispo_2' => $disOmut_1, 'dispo_3' => $disOmut_2, 'pen_2' => $penOmut_1, 'pen_3' => $penOmut_2, 'deliver_2' => $deliverOmut_1, 'deliver_3' => $deliverOmut_2);
            $data['Ocon'][] = array('dispo_2' => $disOcon_1, 'dispo_3' => $disOcon_2, 'pen_2' => $penOcon_1, 'pen_3' => $penOcon_2, 'deliver_2' => $deliverOcon_1, 'deliver_3' => $deliverOcon_2);

            $data['Fpart'][] = array('dispo_2' => $disFpart_1, 'dispo_3' => $disFpart_2, 'pen_2' => $penFpart_1, 'pen_3' => $penFpart_2, 'deliver_2' => $deliverFpart_1, 'deliver_3' => $deliverFpart_2);
            $data['Fmut'][] = array('dispo_2' => $disFmut_1, 'dispo_3' => $disFmut_2, 'pen_2' => $penFmut_1, 'pen_3' => $penFmut_2, 'deliver_2' => $deliverFmut_1, 'deliver_3' => $deliverFmut_2);
        }
        //  var_dump($data);
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/disposecase_fm_1_dclao', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/disposecase_fm_1_dclao';
        $this->load->view('layouts/main',$data);
    }

    public function PendingCasePP() {
		$db=  $this->session->userdata('db');
        $data = array();
        $data['ActionTaken'] = array();
        $data['copatta'] = array();
        $data['Byayprak'] = array();
        $data['skcomment'] = array();
        $user_code = $this->session->userdata('user_desig_code');
        $dist_code = $this->session->userdata('dist_code');
        if ($user_code == 'LAO' or $user_code == 'DC') {
            $subdiv_code = $this->input->get('sub');
            $cir_code = $this->input->get('cir');
        } else {
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
        }
        $stdate = $this->session->userdata('sdate');
        $endate = $this->session->userdata('edate');
        $mut_type = $this->input->get('type');
        $storedata = array('mut_type' => $mut_type);
        $this->session->set_userdata($storedata);
		$define_date=define_date;
        //var_dump($this->session->all_userdata());
        $q = "Select * from    petition_basic where dist_code='$dist_code'  and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status='P' or status is null) and mut_type='$mut_type' and submission_date>='$stdate' and submission_date<='$endate'  ";
        $data['pb'] = $pb = $this->db->query($q)->result();
        foreach ($pb as $d) {
            if ($d->mut_type == '03') {
                $q = "Select pet_name as n,guard_name as g, guard_rel as r  from    petitioner where petition_no='$d->petition_no'   and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                        . "mouza_pargona_code='$d->mouza_pargona_code' and lot_no='$d->lot_no' and vill_townprt_code='$d->vill_townprt_code'  ";
            } elseif ($d->mut_type == '01') {
                $q = "Select pdar_name as n,pdar_guardian as g ,pdar_rel_guar as r from    petitioner_part where petition_no='$d->petition_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                        . "mouza_pargona_code='$d->mouza_pargona_code' and lot_no='$d->lot_no' and vill_townprt_code='$d->vill_townprt_code'  and patta_type_code ='0202'  ";
            } else {
                $q = "Select pdar_name as n,pdar_guardian as g ,pdar_rel_guar as r from    petitioner_part where petition_no='$d->petition_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                        . "mouza_pargona_code='$d->mouza_pargona_code' and lot_no='$d->lot_no' and vill_townprt_code='$d->vill_townprt_code'  and patta_type_code !='0202'  ";
            }
            $data['petipart'][] = $this->db->query($q)->result();
            $st_date = date('Y-m-d', strtotime($d->submission_date));
            $cur_date = date('Y-m-d');
            $curdiff = abs(strtotime($cur_date) - strtotime($st_date));
            $data['day'][] = floor(($curdiff) / (60 * 60 * 24));
        }
        //var_dump($data);
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/pendingcasepartition_pp', $data);
        // $this->load->view('../views/footer');


        $data['_view'] = 'misreport/pendingcasepartition_pp';
        $this->load->view('layouts/main',$data);
    }

    public function PendingCasePPEdate() {
		//$db=  $this->session->userdata('db');
        $data = array();
        $data['ActionTaken'] = array();
        $data['copatta'] = array();
        $data['Byayprak'] = array();
        $data['skcomment'] = array();
        $user_code = $this->session->userdata('user_desig_code');
        $dist_code = $this->session->userdata('dist_code');
        if ($user_code == 'LAO' or $user_code == 'DC') {
            $subdiv_code = $this->input->get('sub');
            $cir_code = $this->input->get('cir');
        } else {
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
        }
        $stdate = $this->session->userdata('sdate');
        $endate = $this->session->userdata('edate');
        $mut_type = $this->input->get('type');
        $storedata = array('mut_type' => $mut_type);
        $this->session->set_userdata($storedata);
		$define_date=define_date;
        //var_dump($this->session->all_userdata());
        $q = "Select * from    petition_basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status='P' or status is null) and mut_type='$mut_type' and  submission_date<='$endate'  ";
        $data['pb'] = $pb = $this->db->query($q)->result();
        foreach ($pb as $d) {
            if ($d->mut_type == '03') {
                $q = "Select pet_name as n,guard_name as g, guard_rel as r  from    petitioner where petition_no='$d->petition_no'   and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                        . "mouza_pargona_code='$d->mouza_pargona_code' and lot_no='$d->lot_no' and vill_townprt_code='$d->vill_townprt_code'    ";
            }
            if ($d->mut_type == '01') {
                $q = "Select pdar_name as n,pdar_guardian as g ,pdar_rel_guar as r from    petitioner_part where petition_no='$d->petition_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                        . "mouza_pargona_code='$d->mouza_pargona_code' and lot_no='$d->lot_no' and vill_townprt_code='$d->vill_townprt_code'  and patta_type_code ='0202'  ";
            }
            if ($d->mut_type == '04') {
                $q = "Select pdar_name as n,pdar_guardian as g ,pdar_rel_guar as r from    petitioner_part where petition_no='$d->petition_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                        . "mouza_pargona_code='$d->mouza_pargona_code' and lot_no='$d->lot_no' and vill_townprt_code='$d->vill_townprt_code'  and patta_type_code !='0202'  ";
            }
            $data['petipart'][] = $this->db->query($q)->result();
            $st_date = date('Y-m-d', strtotime($d->submission_date));
            $cur_date = date('Y-m-d');
            $curdiff = abs(strtotime($cur_date) - strtotime($st_date));
            $data['day'][] = floor(($curdiff) / (60 * 60 * 24));
        }
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/pendingcasepartition_pp_edate', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/pendingcasepartition_pp_edate';
        $this->load->view('layouts/main',$data);
    }

    public function PendingCaseOP_lot() {
		//$db=  $this->session->userdata('db');
        $data = array();
        $data['ActionTaken'] = array();
        $data['copatta'] = array();
        $data['Byayprak'] = array();
        $data['skcomment'] = array();
        $data['Noticegen'] = array();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->input->get('sub');
        $cir_code = $this->input->get('cir');
        $lot_no = $this->input->get('lot');
        $mut_type = $this->input->get('type');
        $mouza_pargona_code = $this->input->get('mouza');
        $data['newdata'] = array(
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'mut_type' => $mut_type);
		$define_date=define_date;
        $q = "Select * from    petition_basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and (status='P' or status is null) and lot_no='$lot_no' and mut_type='$mut_type' ";
        $data['pb'] = $pb = $this->db->query($q)->result();
        foreach ($pb as $d) {

            if ($d->mut_type == '03') {
                $q = "Select pet_name as n,guard_name as g, guard_rel as r  from    petitioner where petition_no='$d->petition_no'   and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                        . "mouza_pargona_code='$d->mouza_pargona_code' and lot_no='$d->lot_no' and vill_townprt_code='$d->vill_townprt_code'    ";
            }
            if ($d->mut_type == '01') {
                $q = "Select pdar_name as n,pdar_guardian as g ,pdar_rel_guar as r from    petitioner_part where petition_no='$d->petition_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                        . "mouza_pargona_code='$d->mouza_pargona_code' and lot_no='$d->lot_no' and vill_townprt_code='$d->vill_townprt_code'  and patta_type_code ='0202'  ";
            }
            if ($d->mut_type == '04') {
                $q = "Select pdar_name as n,pdar_guardian as g ,pdar_rel_guar as r from    petitioner_part where petition_no='$d->petition_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                        . "mouza_pargona_code='$d->mouza_pargona_code' and lot_no='$d->lot_no' and vill_townprt_code='$d->vill_townprt_code'  and patta_type_code !='0202'  ";
            }
            // echo $q;
            $data['petipart'][] = $this->db->query($q)->result();
            $st_date = date('Y-m-d', strtotime($d->submission_date));
            $cur_date = date('Y-m-d');
            $curdiff = abs(strtotime($cur_date) - strtotime($st_date));
            $data['day'][] = floor(($curdiff) / (60 * 60 * 24));
        }
        //var_dump($data);
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/pendingcasepartition_lotwise', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/pendingcasepartition_lotwise';
        $this->load->view('layouts/main',$data);
    }

    public function PendingCaseVill() {
		//$db=  $this->session->userdata('db');
        $data = array();
        $data['ActionTaken'] = array();
        $data['copatta'] = array();
        $data['Byayprak'] = array();
        $data['skcomment'] = array();
        $data['Noticegen'] = array();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->input->get('sub');
        $cir_code = $this->input->get('cir');
        $mouza_pargona_code = $this->input->get('mouza');
        $lot_no = $this->input->get('lot');
        $vill_townprt_code = $this->input->get('vill');
        $mut_type = $this->input->get('type');
        $data['newdata'] = array(
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_code' => $vill_townprt_code, 'mut_type' => $mut_type);
        // $this->session->set_userdata($newdata);
        //var_dump($this->session->all_userdata());
		$define_date=define_date;
        $q = "Select * from    petition_basic where mouza_pargona_code='$mouza_pargona_code' and date(date_entry)>='$define_date' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status='P' or status is null)and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and mut_type='$mut_type' ";
        //echo $q;
        $data['pb'] = $pb = $this->db->query($q)->result();
        foreach ($pb as $d) {

            if ($d->mut_type == '03') {
                $q = "Select pet_name as n,guard_name as g, guard_rel as r  from    petitioner where petition_no='$d->petition_no'   and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                        . "mouza_pargona_code='$d->mouza_pargona_code' and lot_no='$d->lot_no' and vill_townprt_code='$d->vill_townprt_code'    ";
            }
            if ($d->mut_type == '01') {
                $q = "Select pdar_name as n,pdar_guardian as g ,pdar_rel_guar as r from    petitioner_part where petition_no='$d->petition_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                        . "mouza_pargona_code='$d->mouza_pargona_code' and lot_no='$d->lot_no' and vill_townprt_code='$d->vill_townprt_code'  and patta_type_code ='0202'  ";
            }
            if ($d->mut_type == '04') {
                $q = "Select pdar_name as n,pdar_guardian as g ,pdar_rel_guar as r from    petitioner_part where petition_no='$d->petition_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                        . "mouza_pargona_code='$d->mouza_pargona_code' and lot_no='$d->lot_no' and vill_townprt_code='$d->vill_townprt_code'  and patta_type_code !='0202'  ";
            }
            $data['petipart'][] = $this->db->query($q)->result();
            $st_date = date('Y-m-d', strtotime($d->submission_date));
            $cur_date = date('Y-m-d');
            $curdiff = abs(strtotime($cur_date) - strtotime($st_date));
            $data['day'][] = floor(($curdiff) / (60 * 60 * 24));
        }
        // var_dump($data);
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/pendingcasepartition_villwise', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/pendingcasepartition_villwise';
        $this->load->view('layouts/main',$data);
    }

    public function DispoCases() {
		$db=  $this->session->userdata('db');
        $data = array();
        $data['day'] = array();
        $data['petipart'] = array();
        $data['tc'] = array();

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $stdate = $this->session->userdata('sdate');
        $endate = $this->session->userdata('edate');
        $mut_type = $this->input->get('type');
        $storedata = array('mut_type' => $mut_type);
        $this->session->set_userdata($storedata);
		$define_date=define_date;
        //var_dump($this->session->all_userdata());
        $q = "Select * from    petition_basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='F'  and mut_type='$mut_type' and  submission_date<='$endate' and submission_date>='$stdate'  ";
        $data['pb'] = $pb = $this->db->query($q)->result();
        foreach ($pb as $d) {
            if ($d->mut_type == '03') {
                $q = "Select pet_name as n,guard_name as g ,guard_rel as r  from    petitioner where petition_no='$d->petition_no' ";
            } else {
                $q = "Select pdar_name as n,pdar_guardian as g ,pdar_rel_guar as r from    petitioner_part where petition_no='$d->petition_no' ";
            }
            //echo $q;
            $data['petipart'][] = $this->db->query($q)->result();
            $st_date = date('Y-m-d', strtotime($d->submission_date));

            $cur_date = $d->date_of_order;
            $curdiff = abs(strtotime($cur_date) - strtotime($st_date));
            $data['day'][] = floor(($curdiff) / (60 * 60 * 24));
            $q = "SELECT * from    t_Chitha_Rmk_Ordbasic where case_no='$d->case_no' and Year_no='$d->year_no' and Petition_no='$d->petition_no' ";
            $data['tc'][] = $this->db->query($q)->row();
        }


        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/disposecase_pp', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/disposecase_pp';
        $this->load->view('layouts/main',$data);
    }

    public function PendingCaseMnthtwo() {
		$db=  $this->session->userdata('db');
        $data = array();
        $data['day'] = array();
        $data['petipart'] = array();
        $data['tc'] = array();

        $user_code = $this->session->userdata('user_desig_code');
        $dist_code = $this->session->userdata('dist_code');
        if ($user_code == 'LAO' or $user_code == 'DC') {
            $subdiv_code = $this->input->get('sub');
            $cir_code = $this->input->get('cir');
        } else {
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
        }


        $mut_type = $this->input->get('type');
        $data['sdata'] = array('mut_type' => $mut_type,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code
        );
		$define_date=define_date;
        //$this->session->set_userdata($storedata);
        //var_dump($this->session->all_userdata());
        $q = "Select * from    petition_basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status='P' or status is null)   and mut_type='$mut_type'   ";
        $data['pb'] = $pb = $this->db->query($q)->result();
        foreach ($pb as $d) {
            if ($d->mut_type == '03') {
                $q = "Select pet_name as n,guard_name as g,guard_rel as r  from    petitioner where petition_no='$d->petition_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' "
                        . "and cir_code='$cir_code' and mouza_pargona_code='$d->mouza_pargona_code' and lot_no='$d->lot_no' and vill_townprt_code='$d->vill_townprt_code'   ";
            }
            if ($d->mut_type == '04') {
                $q = "Select pdar_name as n,pdar_guardian as g ,pdar_rel_guar as r from    petitioner_part where petition_no='$d->petition_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' "
                        . "and cir_code='$cir_code' and mouza_pargona_code='$d->mouza_pargona_code' and lot_no='$d->lot_no' and vill_townprt_code='$d->vill_townprt_code' and patta_type_code !='0202'  ";
            }
            if ($d->mut_type == '01') {
                $q = "Select pdar_name as n,pdar_guardian as g ,pdar_rel_guar as r from    petitioner_part where petition_no='$d->petition_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' "
                        . "and cir_code='$cir_code' and mouza_pargona_code='$d->mouza_pargona_code' and lot_no='$d->lot_no' and vill_townprt_code='$d->vill_townprt_code' and patta_type_code ='0202'  ";
            }
            //echo $q;
            $data['petipart'][] = $this->db->query($q)->result();
            $st_date = date('Y-m-d', strtotime($d->submission_date));
            $cur_date = date('Y-m-d');
            $curdiff = abs(strtotime($cur_date) - strtotime($st_date));

            $data['day'][] = floor(($curdiff) / (60 * 60 * 24));
        }
        //var_dump($data);
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/pendingcasesmonthwise', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/pendingcasesmonthwise';
        $this->load->view('layouts/main',$data);
    }

    public function PendingCaseMnththree() {
		//$db=  $this->session->userdata('db');
        $data = array();
        $data['day'] = array();
        $data['petipart'] = array();
        $data['tc'] = array();

        $user_code = $this->session->userdata('user_desig_code');
        $dist_code = $this->session->userdata('dist_code');
        if ($user_code == 'LAO' or $user_code == 'DC') {
            $subdiv_code = $this->input->get('sub');
            $cir_code = $this->input->get('cir');
        } else {
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
        }
        $mut_type = $this->input->get('type');
        $data['sdata'] = array(
            'mut_type' => $mut_type,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code);
		$define_date=define_date;
        //$this->session->set_userdata($storedata);
        //var_dump($this->session->all_userdata());
        $q = "Select * from    petition_basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status='P' or status is null) and mut_type='$mut_type' ";
        $data['pb'] = $pb = $this->db->query($q)->result();
        foreach ($pb as $d) {
            if ($d->mut_type == '03') {
                $q = "Select pet_name as n,guard_name as g,guard_rel as r  from    petitioner where petition_no='$d->petition_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' "
                        . "and cir_code='$cir_code' and mouza_pargona_code='$d->mouza_pargona_code' and lot_no='$d->lot_no' and vill_townprt_code='$d->vill_townprt_code'   ";
            }
            if ($d->mut_type == '04') {
                $q = "Select pdar_name as n,pdar_guardian as g ,pdar_rel_guar as r from    petitioner_part where petition_no='$d->petition_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' "
                        . "and cir_code='$cir_code' and mouza_pargona_code='$d->mouza_pargona_code' and lot_no='$d->lot_no' and vill_townprt_code='$d->vill_townprt_code' and patta_type_code !='0202'  ";
            }
            if ($d->mut_type == '01') {
                $q = "Select pdar_name as n,pdar_guardian as g ,pdar_rel_guar as r from    petitioner_part where petition_no='$d->petition_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' "
                        . "and cir_code='$cir_code' and mouza_pargona_code='$d->mouza_pargona_code' and lot_no='$d->lot_no' and vill_townprt_code='$d->vill_townprt_code' and patta_type_code ='0202'  ";
            }
            //echo $q;
            $data['petipart'][] = $this->db->query($q)->result();
            $st_date = date('Y-m-d', strtotime($d->submission_date));
            $cur_date = date('Y-m-d');
            $curdiff = abs(strtotime($cur_date) - strtotime($st_date));
            $data['day'][] = floor(($curdiff) / (60 * 60 * 24));
        }
        //var_dump($data['petipart']);
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/pendingcasesmonthwisethree', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/pendingcasesmonthwisethree';
        $this->load->view('layouts/main',$data);
    }

    public function PendingcaseFieldPartTWO() {
		//$db=  $this->session->userdata('db');
        $data = array();
        $data['day'] = array();
        $data['petipart'] = array();
        $data['tc'] = array();

        $dist_code = $this->session->userdata('dist_code');
        //$subdiv_code=$this->input->get('sub');
        //$cir_code=$this->input->get('cir');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

		$define_date=define_date;
        $mut_type = $this->input->get('type');
        $data['sdata'] = array('mut_type' => $mut_type,
            'cir_code' => $cir_code,
            'subdiv_code' => $subdiv_code
        );
        //  $this->session->set_userdata($storedata);
        $q = "Select * from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='$mut_type' and (Report_date is not null) and (order_passed is Null) and (is_dispose is Null)   ";

        $data['pb'] = $pb = $this->db->query($q)->result();
        foreach ($pb as $d) {
            if ($d->mut_type == '01') {
                $q = "Select pet_name as n,guard_name as g,guard_rel as r from    Field_Mut_petitioner where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and petition_no='$d->petition_no' and case_no='$d->case_no'";
            } else {
                $q = "Select pdar_name as n,pdar_guardian as g,pdar_rel_guar as r  from    Field_Part_petitioner where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and petition_no='$d->petition_no' and case_no='$d->case_no' ";
            }
            //echo $q;
            $data['petipart'][] = $this->db->query($q)->result();
            $st_date = date('Y-m-d', strtotime($d->report_date));
            // $st_date=$d->report_date;
            $cur_date = date('Y-m-d');
            $curdiff = abs(strtotime($cur_date) - strtotime($st_date));
            $data['day'][] = floor(($curdiff) / (60 * 60 * 24));
        }
        //var_dump($data);
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/pendingFieldmonthwisetwo', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/pendingFieldmonthwisetwo';
        $this->load->view('layouts/main',$data);
    }

    public function PendingcaseFieldPart() {
		//$db=  $this->session->userdata('db');
        $data = array();
        $data['day'] = array();
        $data['petipart'] = array();
        $data['tc'] = array();

        $dist_code = $this->session->userdata('dist_code');
        //$subdiv_code=$this->input->get('sub');
        //	$cir_code=$this->input->get('cir');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $mut_type = $this->input->get('type');
        $data['sdata'] = array(
            'cir_code' => $cir_code,
            'subdiv_code' => $subdiv_code,
            'mut_type' => $mut_type);
        //$this->session->set_userdata($storedata);
		$define_date=define_date;
        $q = "Select * from    Field_Mut_Basic where dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='$mut_type' and (order_passed is Null) and (is_dispose is Null)   ";
        //DisposeForMonthsDCLAO echo $q;
        $data['pb'] = $pb = $this->db->query($q)->result();
        foreach ($pb as $d) {
            if ($d->mut_type == '01') {
                $q = "Select pet_name as n,guard_name as g,guard_rel as r from    Field_Mut_petitioner where petition_no='$d->petition_no' and case_no='$d->case_no'";
            } else {
                $q = "Select pdar_name as n,pdar_guardian as g,pdar_rel_guar as r  from    Field_Part_petitioner where petition_no='$d->petition_no' and case_no='$d->case_no' ";
            }
            //echo $q;
            $data['petipart'][] = $this->db->query($q)->result();
            $st_date = date('Y-m-d', strtotime($d->report_date));
            $cur_date = date('Y-m-d');
            $curdiff = abs(strtotime($cur_date) - strtotime($st_date));
            $data['day'][] = floor(($curdiff) / (60 * 60 * 24));
        }
        //var_dump($data);
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/pendingFieldmonthwisethree', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/pendingFieldmonthwisethree';
        $this->load->view('layouts/main',$data);
    }

    public function PendingcaseOfc_lot() {
		//$db=  $this->session->userdata('db');
        $data = array();
        $data['petipart'] = array();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->input->get('sub');
        $cir_code = $this->input->get('cir');
        $mouza_pargona_code = $this->input->get('mouza');
        $lot_no = $this->input->get('lot');
        $mut_type = $this->input->get('mtype');
        $data['varadata'] = array(
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza' => $mouza_pargona_code,
            'mut_type' => $mut_type, 'lot_no' => $lot_no);
		$define_date=define_date;
        //$this->session->set_userdata($varadata);
        //var_dump($this->session->all_userdata());
        $q = "Select * from    field_mut_basic where  dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and mut_type='$mut_type' and lot_no='$lot_no' and order_passed is null and is_dispose is null   ";
        //echo $q;
        $data['fb'] = $fb = $this->db->query($q)->result();
        foreach ($fb as $p) {
            if ($mut_type == 01) {
                $q = "Select pet_name as n,guard_name as g,guard_rel as r  from    field_mut_petitioner where case_no='$p->case_no' and petition_no='$p->petition_no' ";
            } else {
                $q = "Select pdar_name as n,pdar_guardian as g,pdar_rel_guar as r  from    field_part_petitioner where case_no='$p->case_no' and petition_no='$p->petition_no' ";
            }
            $data['petipart'][] = $this->db->query($q)->result();
        }
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/officependingcase_lot', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/officependingcase_lot';
        $this->load->view('layouts/main',$data);
    }

    public function PendingCaseVillField() {
		//$db=  $this->session->userdata('db');
        $data = array();
        $data['petipart'] = array();
        //var_dump($this->session->all_userdata());
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->input->get('sub');
        $cir_code = $this->input->get('cir');
        $mouza_pargona_code = $this->input->get('mouza');
        $lot_no = $this->input->get('lot');
        $mut_type = $this->input->get('type');
        $vill_townprt_code = $this->input->get('vill');
        $data['varadata'] = array(
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'mut_type' => $mut_type, 'vill_townprt_code' => $vill_townprt_code);
		$define_date=define_date;
        $q = "Select * from    field_mut_basic where  dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' "
                . "and vill_townprt_code='$vill_townprt_code' and mut_type='$mut_type' and lot_no='$lot_no' and order_passed is null and is_dispose is null   ";
        //echo $q;
        $data['fb'] = $fb = $this->db->query($q)->result();
        foreach ($fb as $p) {
            if ($mut_type == 01) {
                $q = "Select pet_name as n,guard_name as g,guard_rel as r from    field_mut_petitioner where case_no='$p->case_no' and petition_no='$p->petition_no' ";
            } else {
                $q = "Select pdar_name as n,pdar_guardian as g,pdar_rel_guar as r from    field_part_petitioner where case_no='$p->case_no' and petition_no='$p->petition_no' ";
            }
            $data['petipart'][] = $this->db->query($q)->result();
        }
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/fieldpendingcase_vill', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/fieldpendingcase_vill';
        $this->load->view('layouts/main',$data);
    }

    public function FieldPendingCasePPEdate() {
		//$db=  $this->session->userdata('db');
        //var_dump($this->session->all_userdata());
        $data = array();
        $data['petipart'] = array();
        $dist_code = $this->session->userdata('dist_code');
        $user_code = $this->session->userdata('user_desig_code');
        if ($user_code == 'LAO' or $user_code == 'DC') {
            $subdiv_code = $this->input->get('sub');
            $cir_code = $this->input->get('cir');
        } else {
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
        }
        $sdate = $this->session->userdata('sdate');
        $edate = $this->session->userdata('edate');
        $mut_type = $this->input->get('type');
        $vardata = array('mut_type' => $mut_type);
		$define_date=define_date;
        $this->session->set_userdata($vardata);
        $q = "Select * from    field_mut_basic where  dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='$mut_type' and report_date >='$sdate' and report_date<='$edate' and order_passed is null and is_dispose is null   ";
        //echo $q;
        $data['fb'] = $fb = $this->db->query($q)->result();
        foreach ($fb as $p) {
            if ($mut_type == 01) {
                $q = "Select pet_name as n,guard_name as g, guard_rel as r from    field_mut_petitioner where case_no='$p->case_no' and petition_no='$p->petition_no' ";
            } else {
                $q = "Select pdar_name as n,pdar_guardian as g, pdar_rel_guar as r from    field_part_petitioner where case_no='$p->case_no' and petition_no='$p->petition_no' ";
            }
            $data['petipart'][] = $this->db->query($q)->result();
        }
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/fieldpendingcase_datewise', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/fieldpendingcase_datewise';
        $this->load->view('layouts/main',$data);
    }

    public function FieldPendingCase() {
		//$db=  $this->session->userdata('db');
        // var_dump($this->session->all_userdata());
        $user_code = $this->session->userdata('user_desig_code');
        $data = array();
        $data['petipart'] = array();
        $dist_code = $this->session->userdata('dist_code');
        if ($user_code == 'LAO' or $user_code == 'DC') {
            $subdiv_code = $this->input->get('sub');
            $cir_code = $this->input->get('cir');
        } else {
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
        }
        $sdate = $this->session->userdata('sdate');
        $edate = $this->session->userdata('edate');
        $mut_type = $this->input->get('type');
		$define_date=define_date;
        $vardata = array('mut_type' => $mut_type);
        $this->session->set_userdata($vardata);
        $q = "Select * from    field_mut_basic where  dist_code='$dist_code' and date(date_entry)>='$define_date' and subdiv_code='$subdiv_code' "
                . "and cir_code='$cir_code' and mut_type='$mut_type'  and order_passed is null and is_dispose is null   ";
        $data['fb'] = $fb = $this->db->query($q)->result();
        foreach ($fb as $p) {
            if ($mut_type == 01) {
                $q = "Select pet_name as n,guard_name as g,guard_rel as r from    field_mut_petitioner where case_no='$p->case_no' and petition_no='$p->petition_no' ";
            } else {
                $q = "Select pdar_name as n,pdar_guardian as g ,pdar_rel_guar as r  from    field_part_petitioner where case_no='$p->case_no' and petition_no='$p->petition_no' ";
            }
            $data['petipart'][] = $this->db->query($q)->result();
        }
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/fieldpendingcase_totalwise', $data);
        // $this->load->view('../views/footer');
        $data['_view'] = 'misreport/fieldpendingcase_totalwise';
        $this->load->view('layouts/main',$data);
    }

    public function FieldDispoCasePPEdate() {
		//$db=  $this->session->userdata('db');
        //var_dump($this->session->all_userdata());
        $user_code = $this->session->userdata('user_desig_code');
        $data = array();
        $data['petipart'] = array();
        $data['day'] = array();
        $dist_code = $this->session->userdata('dist_code');
        if ($user_code == 'LAO' or $user_code == 'DC') {
            $subdiv_code = $this->input->get('sub');
            $cir_code = $this->input->get('cir');
        } else {
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
        }
        $sdate = $this->session->userdata('sdate');
        $edate = $this->session->userdata('edate');
        $mut_type = $this->input->get('type');
        $vardata = array('mut_type' => $mut_type);
        $this->session->set_userdata($vardata);
        $q = "Select * from    field_mut_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='$mut_type' and report_date >='$sdate' and report_date<='$edate' and order_passed='Y'  ";
        //echo $q;
        $data['fb'] = $fb = $this->db->query($q)->result();
        foreach ($fb as $d) {
            if ($mut_type == 01) {
                $q = "Select pet_name as n,guard_name as g from    field_mut_petitioner where case_no='$d->case_no' and petition_no='$d->petition_no' ";
            } else {
                $q = "Select pdar_name as n,pdar_guardian as g from    field_part_petitioner where case_no='$d->case_no' and petition_no='$d->petition_no' ";
            }
            $data['petipart'][] = $this->db->query($q)->result();
            $st_date = $d->report_date;
            $cur_date = $d->date_of_order;
            $curdiff = abs(strtotime($cur_date) - strtotime($st_date));
            $data['day'][] = floor(($curdiff) / (60 * 60 * 24));
        }
        // var_dump($data['day']);
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/fielddispocase_datewise', $data);
        // $this->load->view('../views/footer');

         $data['_view'] = 'misreport/fielddispocase_datewise';
        $this->load->view('layouts/main',$data);
    }

    public function ProceedingDetails() {
		//$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->input->get('sub');
        $cir_code = $this->input->get('cir');
        $mut_type = $this->input->get('case_type');
        $case_no = $this->input->get('case_no');
        $petition_no = $this->input->get('petition_no');
        $data['case_no'] = array('case_no' => $case_no);
        $data = array();
        $sql = "SELECT MIN(date_of_hearing) as stdate FROM Petition_Proceeding Where case_no='$case_no'";
        //echo $sql;
        $data['stdate'] = $this->db->query($sql)->row();

        $sql = "SELECT MAX(date_of_hearing) as endate FROM Petition_Proceeding Where case_no='$case_no'";
        $data['endate'] = $this->db->query($sql)->row();
        $q = "Select * from    petition_proceeding where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and case_no='$case_no' order by proceeding_id asc ";
        // echo $q;
        $data['pd'] = $this->db->query($q)->result();
        // var_dump($data);
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/proceeding_order_dtls', $data);
        // $this->load->view('../views/footer');


        $data['_view'] = 'misreport/proceeding_order_dtls';
        $this->load->view('layouts/main',$data);
    }

    public function landareaannualPatta() {
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/UnderConstruction');
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/UnderConstruction';
        $this->load->view('layouts/main',$data);
    }

    public function saledeed() {
		$db=  $this->session->userdata('db');
        echo "daaa";
        $data['dist'] = $databsearray = array(
            array('kamrupM', '24'),
            array('kamrup', '07'),
        );
        $size = sizeof($databsearray);
        for ($i = 0; $i < $size; $i++) {
            $name = $databsearray[$i][0];
            $code = $databsearray[$i][1];
            $db = $this->load->database($code, TRUE);
            $this->dbb = $db;
            $sql = "Select count(*) as c from    sro_note";
            $data['reg'][$code]['sro_note'] = $this->dbb->query($sql)->row();
            $sql = "Select count(*) as co from    sro_note where status='1'";
            $data['reg'][$code]['sro_note_co'] = $this->dbb->query($sql)->row();
            $this->db->close();
            $this->dbb->close();
        }
        // var_dump($data);
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/saledeed', $data);
        // $this->load->view('../views/footer');


        $data['_view'] = 'misreport/saledeed';
        $this->load->view('layouts/main',$data);
    }

    public function saledeedcircle() {
		//$db=  $this->session->userdata('db');
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        $dist_name = $this->input->get('d');
        $data['dist'] = $databsearray = array(
            array('kamrupM', '24'),
            array('kamrup', '07'),
        );
        $size = sizeof($databsearray);
        for ($i = 0; $i < $size; $i++) {
            $name = $databsearray[$i][0];
            $code = $databsearray[$i][1];
            $db = $this->load->database($code, TRUE);
            $this->dbb = $db;
            if ($name == $dist_name) {
                $q = "SELECT * FROM location WHERE dist_code='$code' and subdiv_code !='00' and cir_code !='00'  and Mouza_Pargona_code = '00' and Lot_no= '00' and vill_townprt_code= '00000'";
                $data['loc'] = $location = $this->dbb->query($q)->result();
                foreach ($location as $loc) {
                    $sql = "Select count(*) as c from    sro_note where cir_code='$loc->cir_code'";
                    $data['circle'][$loc->loc_name]['sro_note'] = $this->dbb->query($sql)->row();

                    $sql = "Select count(*) as co from    sro_note where cir_code='$loc->cir_code' and status='1'";
                    $data['circle'][$loc->loc_name]['sro_note_co'] = $this->dbb->query($sql)->row();
                }
            }
        }
        // $this->load->view('../views/misreport/saledeedcircle', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/saledeedcircle';
        $this->load->view('layouts/main',$data);
    }

    public function districtwiselist() {
		// $db=  $this->session->userdata('db');
  //       $this->load->helper('html');
  //       $this->load->view('../views/header');
        $data['dist'] = $databsearray = array(
            array('kamrupM', '24'),
            array('kamrup', '07'),
        );
        $size = sizeof($databsearray);
        for ($i = 0; $i < $size; $i++) {
            $name = $databsearray[$i][0];
            $code = $databsearray[$i][1];
            $db = $this->load->database($code, TRUE);
            $this->dbb = $db;

            //        Office Cases
            $q = "select count(*) as c from    Petition_Basic where  mut_type='03'";
            $data['mis'][$name]['omut'] = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where  mut_type='03' and (status='P' or status is null) ";
            $data['mis'][$name]['omutpen'] = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where  mut_type='03' and (status='D' or status='d' )";
            $data['mis'][$name]['omutdev'] = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where  mut_type='03' and (status ='F' or status ='f') ";
            $data['mis'][$name]['omutfinal'] = $this->dbb->query($q)->row();

            ////////////////
            $q = "select count(*) as c from    Petition_Basic where  mut_type='01'";
            $data['mis'][$name]['ocon'] = $OPart = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where  mut_type='01' and (status='P' or status is null) ";
            $data['mis'][$name]['oconpen'] = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where  mut_type='01' and (status='D' or status='d' ) ";
            $data['mis'][$name]['ocondev'] = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where  mut_type='01' and (status ='F' or status ='f' )  ";
            $data['mis'][$name]['oconfinal'] = $this->dbb->query($q)->row();
            ///////////////
            $q = "select count(*) as c from    Petition_Basic where  mut_type='04'";
            $data['mis'][$name]['opart'] = $OConv = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where mut_type='04' and (status='P' or status is null) ";
            $data['mis'][$name]['opartpen'] = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where  mut_type='04' and (status='D' or status='d' ) ";
            $data['mis'][$name]['opartdev'] = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where  mut_type='04' and ( status ='F' or status ='f'   )  ";
            $data['mis'][$name]['opartfinal'] = $this->dbb->query($q)->row();

            //        Field Cases
            $q = "select count(*) as c from    Field_Mut_Basic where  mut_type='01' ";
            $data['mis'][$name]['ofcmut'] = $OConv = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where  mut_type='01' and (order_passed is null and is_dispose is null ) ";
            $data['mis'][$name]['ofcmutpen'] = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where  mut_type='01' and (is_dispose='Y' or is_dispose='y'  )";
            $data['mis'][$name]['ofcmutdev'] = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where  mut_type='01' and (order_passed ='Y' or order_passed ='y'  ) ";
            $data['mis'][$name]['ofcmutfinal'] = $this->dbb->query($q)->row();
            ///////////
            $q = "select count(*) as c from    Field_Mut_Basic where  mut_type='02'";
            $data['mis'][$name]['fpart'] = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where  mut_type='02' and (order_passed is Null and is_dispose is null) ";
            $data['mis'][$name]['fpartpen'] = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where  mut_type='02' and (is_dispose='Y' or is_dispose='y' )";
            $data['mis'][$name]['fpartdev'] = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where  mut_type='02' and (order_passed ='Y' or order_passed ='y'  )";
            $data['mis'][$name]['fpartfinal'] = $this->dbb->query($q)->row();

            // Reclassfication
            $q = "select count(*) as c from    t_reclassification  ";
            $data['mis'][$name]['t_reclass_tot'] = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    t_reclassification where   (rkg_chitha_updated_yn !='Y' and co_chitha_updated_yn !='Y') ";
            $data['mis'][$name]['t_reclass_pen'] = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    t_reclassification where (rkg_chitha_updated_yn ='Y' and co_chitha_updated_yn ='Y')";
            $data['mis'][$name]['t_reclass_dev'] = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    t_reclassification where  co_yn='N' ";
            $data['mis'][$name]['t_reclass_dispose'] = $this->dbb->query($q)->row();
            // End Reclassfication     
            // NR Case
            $q = "select count(*) as c from    apcancel_petition_basic ";
            $data['mis'][$name]['nr_tot'] = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    apcancel_petition_basic where   status ='P' and order_passed is null  ";
            $data['mis'][$name]['nr_pen'] = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    apcancel_petition_basic where  order_passed ='Y' ";
            $data['mis'][$name]['nr_dev'] = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    apcancel_petition_basic where  status='X' ";
            $data['mis'][$name]['nr_dispose'] = $this->dbb->query($q)->row();
            // // End NR Case
            // Misc Case
            $q = "select count(*) as c from    misc_case_basic ";
            $data['mis'][$name]['misccase_tot'] = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    misc_case_basic where   (status !='10'  or status ='11'  )  ";
            $data['mis'][$name]['misccase_pen'] = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    misc_case_basic where   status ='10'  ";
            $data['mis'][$name]['misccase_dev'] = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    misc_case_basic where    status ='11'   ";
            $data['mis'][$name]['misccase_dispose'] = $this->dbb->query($q)->row();
            // End Misc Case
        }
        // $this->load->view('../views/misreport/districtwiselist', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/districtwiselist';
        $this->load->view('layouts/main',$data);
    }

    public function DisposeGalanceCircle() {
		//$db=  $this->session->userdata('db');
        //var_dump($this->session->all_userdata());
        $data = array();
        $distname = $this->input->get('d');
        $data['dist'] = $databsearray = array(
            array('kamrupM', '24'),
            array('kamrup', '07'),
        );
        $size = sizeof($databsearray);
        for ($i = 0; $i < $size; $i++) {
            $name = $databsearray[$i][0];
            $dist_code = $databsearray[$i][1];
            $db = $this->load->database($dist_code, TRUE);
            $this->dbb = $db;
            if ($name == $distname) {

                $q = "SELECT * FROM location WHERE dist_code='$dist_code' and subdiv_code !='00' and cir_code !='00'  and Mouza_Pargona_code = '00' and Lot_no= '00' and vill_townprt_code= '00000'";
                $data['loc'] = $location = $this->dbb->query($q)->result();
                foreach ($location as $loc) {
                    $subdiv_code = $loc->subdiv_code;
                    $cir_code = $loc->cir_code;
                    //        Office Cases
                    $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='03'";
                    $data['circle'][$loc->loc_name]['omut'] = $this->dbb->query($q)->row();
                    $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='03' and (status='P' or status is null) ";
                    $data['circle'][$loc->loc_name]['omutpen'] = $this->dbb->query($q)->row();
                    $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='03' and (status='D' or status='d' )";
                    $data['circle'][$loc->loc_name]['omutdev'] = $this->dbb->query($q)->row();
                    $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='03' and (status ='F' or status ='f') ";
                    $data['circle'][$loc->loc_name]['omutfinal'] = $this->dbb->query($q)->row();

                    ////////////////
                    $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='01'";
                    $data['circle'][$loc->loc_name]['ocon'] = $OPart = $this->dbb->query($q)->row();
                    $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='01' and (status='P' or status is null) ";
                    $data['circle'][$loc->loc_name]['oconpen'] = $this->dbb->query($q)->row();
                    $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='01' and (status='D' or status='d' ) ";
                    $data['circle'][$loc->loc_name]['ocondev'] = $this->dbb->query($q)->row();
                    $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='01' and (status ='F' or status ='f' )  ";
                    $data['circle'][$loc->loc_name]['oconfinal'] = $this->dbb->query($q)->row();
                    ///////////////
                    $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='04'";
                    $data['circle'][$loc->loc_name]['opart'] = $OConv = $this->dbb->query($q)->row();
                    $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='04' and (status='P' or status is null) ";
                    $data['circle'][$loc->loc_name]['opartpen'] = $this->dbb->query($q)->row();
                    $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='04' and (status='D' or status='d' ) ";
                    $data['circle'][$loc->loc_name]['opartdev'] = $this->dbb->query($q)->row();
                    $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='04' and ( status ='F' or status ='f'   )  ";
                    $data['circle'][$loc->loc_name]['opartfinal'] = $this->dbb->query($q)->row();

                    //        Field Cases
                    $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='01' ";
                    $data['circle'][$loc->loc_name]['ofcmut'] = $OConv = $this->dbb->query($q)->row();
                    $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='01' and (order_passed is null and is_dispose is null ) ";
                    $data['circle'][$loc->loc_name]['ofcmutpen'] = $this->dbb->query($q)->row();
                    $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='01' and (is_dispose='Y' or is_dispose='y'  )";
                    $data['circle'][$loc->loc_name]['ofcmutdev'] = $this->dbb->query($q)->row();
                    $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and  cir_code='$cir_code' and  mut_type='01' and (order_passed ='Y' or order_passed ='y'  ) ";
                    $data['circle'][$loc->loc_name]['ofcmutfinal'] = $this->dbb->query($q)->row();
                    ///////////
                    $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='02'";
                    $data['circle'][$loc->loc_name]['fpart'] = $this->dbb->query($q)->row();
                    $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='02' and (order_passed is Null and is_dispose is null) ";
                    $data['circle'][$loc->loc_name]['fpartpen'] = $this->dbb->query($q)->row();
                    $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='02' and (is_dispose='Y' or is_dispose='y' )";
                    $data['circle'][$loc->loc_name]['fpartdev'] = $this->dbb->query($q)->row();
                    $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='02' and (order_passed ='Y' or order_passed ='y'  )";
                    $data['circle'][$loc->loc_name]['fpartfinal'] = $this->dbb->query($q)->row();

                    // Reclassfication
                    $q = "select count(*) as c from    t_reclassification where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
                    $data['circle'][$loc->loc_name]['t_reclass_tot'] = $this->dbb->query($q)->row();
                    $q = "select count(*) as c from    t_reclassification where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  (rkg_chitha_updated_yn !='Y' and co_chitha_updated_yn !='Y') ";
                    $data['circle'][$loc->loc_name]['t_reclass_pen'] = $this->dbb->query($q)->row();
                    $q = "select count(*) as c from    t_reclassification where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (rkg_chitha_updated_yn ='Y' and co_chitha_updated_yn ='Y')";
                    $data['circle'][$loc->loc_name]['t_reclass_dev'] = $this->dbb->query($q)->row();
                    $q = "select count(*) as c from    t_reclassification where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and co_yn='N' ";
                    $data['circle'][$loc->loc_name]['t_reclass_dispose'] = $this->dbb->query($q)->row();
                    // End Reclassfication     
                    // NR Case
                    $q = "select count(*) as c from    apcancel_petition_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
                    $data['circle'][$loc->loc_name]['nr_tot'] = $this->dbb->query($q)->row();
                    $q = "select count(*) as c from    apcancel_petition_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  status ='P' and order_passed is null  ";
                    $data['circle'][$loc->loc_name]['nr_pen'] = $this->dbb->query($q)->row();
                    $q = "select count(*) as c from    apcancel_petition_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and order_passed ='Y' ";
                    $data['circle'][$loc->loc_name]['nr_dev'] = $this->dbb->query($q)->row();
                    $q = "select count(*) as c from    apcancel_petition_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='X' ";
                    $data['circle'][$loc->loc_name]['nr_dispose'] = $this->dbb->query($q)->row();
                    // // End NR Case
                    // Misc Case
                    $q = "select count(*) as c from    misc_case_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
                    $data['circle'][$loc->loc_name]['misccase_tot'] = $this->dbb->query($q)->row();
                    $q = "select count(*) as c from    misc_case_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  (status !='10'  or status ='11'  )  ";
                    $data['circle'][$loc->loc_name]['misccase_pen'] = $this->dbb->query($q)->row();
                    $q = "select count(*) as c from    misc_case_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and   status ='10'  ";
                    $data['circle'][$loc->loc_name]['misccase_dev'] = $this->dbb->query($q)->row();
                    $q = "select count(*) as c from    misc_case_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and   status ='11'   ";
                    $data['circle'][$loc->loc_name]['misccase_dispose'] = $this->dbb->query($q)->row();
                    // End Misc Case
                }
            }
        }
        // var_dump($data);
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/diposecase_circlewise_list', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/diposecase_circlewise_list';
        $this->load->view('layouts/main',$data);
    }

    function croplanddist() {
		// $db=  $this->session->userdata('db');
  //       $this->load->helper('html');
  //       $this->load->view('../views/header');
        $data['dist'] = $databsearray = array(
            array('kamrupM', '24'),
            array('kamrup', '07'),
        );
        $size = sizeof($databsearray);
        for ($i = 0; $i < $size; $i++) {
            $name = $databsearray[$i][0];
            $code = $databsearray[$i][1];
            $db = $this->load->database($code, TRUE);
            $this->dbb = $db;
            //croplanddist
            //for normal - Ravi - irrigated
            $q = "Select sum (crop_land_area_b  ) as b,sum(crop_land_area_k) as k,sum(crop_land_area_lc) as l from    chitha_mcrop where   crop_season='01' and source_of_water='01' and (crop_categ_code='n' or crop_categ_code is null)";
            $data['distname'][$name]['ravinormalirrg'] = $this->dbb->query($q)->row();
            //for normal - Ravi - non-irrigated
            $q = "Select sum (crop_land_area_b  ) as b,sum(crop_land_area_k) as k,sum(crop_land_area_lc) as l from    chitha_mcrop where  crop_season='01' and source_of_water='03' and (crop_categ_code='n' or crop_categ_code is null)";
            $data['distname'][$name]['ravinormalnonirrg'] = $this->dbb->query($q)->row();
            //for normal - kharif - irrigated
            $q = "Select sum (crop_land_area_b  ) as b,sum(crop_land_area_k) as k,sum(crop_land_area_lc) as l from    chitha_mcrop where  crop_season='02' and source_of_water='01' and (crop_categ_code='n' or crop_categ_code is null)";
            $data['distname'][$name]['kharifnormalirrg'] = $this->dbb->query($q)->row();
            //for normal - kharif - nonirrigated
            $q = "Select sum (crop_land_area_b  ) as b,sum(crop_land_area_k) as k,sum(crop_land_area_lc) as l from    chitha_mcrop where  crop_season='02' and source_of_water='03' and (crop_categ_code='n' or crop_categ_code is null)";
            $data['distname'][$name]['kharifnormalnonirrg'] = $this->dbb->query($q)->row();
            //for rich - Ravi - irrigated
            $q = "Select sum (crop_land_area_b  ) as b,sum(crop_land_area_k) as k,sum(crop_land_area_lc) as l from    chitha_mcrop where  crop_season='01' and source_of_water='01' and crop_categ_code='r' ";
            $data['distname'][$name]['ravirichirrg'] = $this->dbb->query($q)->row();
            //for rich - Ravi - non-irrigated
            $q = "Select sum (crop_land_area_b  ) as b,sum(crop_land_area_k) as k,sum(crop_land_area_lc) as l from    chitha_mcrop where  crop_season='01' and source_of_water='03' and crop_categ_code='r'";
            $data['distname'][$name]['ravirichnonirrg'] = $this->dbb->query($q)->row();
            //for rich - kharif - irrigated
            $q = "Select sum (crop_land_area_b  ) as b,sum(crop_land_area_k) as k,sum(crop_land_area_lc) as l from    chitha_mcrop where  crop_season='02' and source_of_water='01' and crop_categ_code='r'";
            $data['distname'][$name]['kharifrichirrg'] = $this->dbb->query($q)->row();
            //for rich - kharif - nonirrigated
            $q = "Select sum (crop_land_area_b  ) as b,sum(crop_land_area_k) as k,sum(crop_land_area_lc) as l from    chitha_mcrop where crop_season='02' and source_of_water='03' and crop_categ_code='r' ";
            $data['distname'][$name]['kharifrichnonirrg'] = $this->dbb->query($q)->row();
            // var_dump($data);
        }
        //var_dump($data);
        // $this->load->view('../views/misreport/croplanddist', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/croplanddist';
        $this->load->view('layouts/main',$data);
    }

    function croplandcircle() {
		// $db=  $this->session->userdata('db');
  //       $this->load->helper('html');
  //       $this->load->view('../views/header');
        $distname = $this->input->get('key');
        $data['dist'] = $databsearray = array(
            array('kamrupM', '24'),
            array('kamrup', '07'),
        );
        $size = sizeof($databsearray);
        for ($i = 0; $i < $size; $i++) {
            $name = $databsearray[$i][0];
            $code = $databsearray[$i][1];
            $db = $this->load->database($code, TRUE);
            $this->dbb = $db;
            if ($name == $distname) {

                $q = "SELECT * FROM  location WHERE dist_code='$code' and subdiv_code !='00' and cir_code !='00'  and Mouza_Pargona_code = '00' and Lot_no= '00' and vill_townprt_code= '00000'";
                $data['loc'] = $location = $this->dbb->query($q)->result();
                foreach ($location as $loc) {
                    $dist_code = $loc->dist_code;
                    $subdiv_code = $loc->subdiv_code;
                    $cir_code = $loc->cir_code;
                    $mergecode = $loc->loc_name;
                    //for normal - Ravi - irrigated
                    $q = "Select sum (crop_land_area_b  ) as b,sum(crop_land_area_k) as k,sum(crop_land_area_lc) as l from    chitha_mcrop where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and crop_season='01' and source_of_water='01' and (crop_categ_code='n' or crop_categ_code is null)";
                    $data['circle'][$mergecode]['ravinormalirrg'] = $this->dbb->query($q)->row();
                    //for normal - Ravi - non-irrigated
                    $q = "Select sum (crop_land_area_b  ) as b,sum(crop_land_area_k) as k,sum(crop_land_area_lc) as l from    chitha_mcrop where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and crop_season='01' and source_of_water='03' and (crop_categ_code='n' or crop_categ_code is null)";
                    $data['circle'][$mergecode]['ravinormalnonirrg'] = $this->dbb->query($q)->row();
                    //for normal - kharif - irrigated
                    $q = "Select sum (crop_land_area_b  ) as b,sum(crop_land_area_k) as k,sum(crop_land_area_lc) as l from    chitha_mcrop where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and crop_season='02' and source_of_water='01' and (crop_categ_code='n' or crop_categ_code is null)";
                    $data['circle'][$mergecode]['kharifnormalirrg'] = $this->dbb->query($q)->row();
                    //for normal - kharif - nonirrigated
                    $q = "Select sum (crop_land_area_b  ) as b,sum(crop_land_area_k) as k,sum(crop_land_area_lc) as l from    chitha_mcrop where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and crop_season='02' and source_of_water='03' and (crop_categ_code='n' or crop_categ_code is null)";
                    $data['circle'][$mergecode]['kharifnormalnonirrg'] = $this->dbb->query($q)->row();
                    //for rich - Ravi - irrigated
                    $q = "Select sum (crop_land_area_b  ) as b,sum(crop_land_area_k) as k,sum(crop_land_area_lc) as l from    chitha_mcrop where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and crop_season='01' and source_of_water='01' and crop_categ_code='r' ";
                    $data['circle'][$mergecode]['ravirichirrg'] = $this->dbb->query($q)->row();
                    //for rich - Ravi - non-irrigated
                    $q = "Select sum (crop_land_area_b  ) as b,sum(crop_land_area_k) as k,sum(crop_land_area_lc) as l from     chitha_mcrop where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and crop_season='01' and source_of_water='03' and crop_categ_code='r'";
                    $data['circle'][$mergecode]['ravirichnonirrg'] = $this->dbb->query($q)->row();
                    //for rich - kharif - irrigated
                    $q = "Select sum (crop_land_area_b  ) as b,sum(crop_land_area_k) as k,sum(crop_land_area_lc) as l from     chitha_mcrop where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and crop_season='02' and source_of_water='01' and crop_categ_code='r'";
                    $data['circle'][$mergecode]['kharifrichirrg'] = $this->dbb->query($q)->row();
                    //for rich - kharif - nonirrigated
                    $q = "Select sum (crop_land_area_b  ) as b,sum(crop_land_area_k) as k,sum(crop_land_area_lc) as l from     chitha_mcrop where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and crop_season='02' and source_of_water='03' and crop_categ_code='r' ";
                    $data['circle'][$mergecode]['kharifrichnonirrg'] = $this->dbb->query($q)->row();
                }
            }
        }
        //       var_dump($data);
        // $this->load->view('../views/misreport/croplandcircle', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/croplandcircle';
        $this->load->view('layouts/main',$data);
    }

    function fruitdist() {
        $data['dist'] = $databsearray = array(
            array('kamrupM', '24'),
            array('kamrup', '07'),
        );
        $size = sizeof($databsearray);
        for ($i = 0; $i < $size; $i++) {
            $name = $databsearray[$i][0];
            $code = $databsearray[$i][1];
            $db = $this->load->database($code, TRUE);
            $this->dbb = $db;
            $q = "Select * from    fruit_tree_code";
            $tcode = $this->dbb->query($q)->result();
            foreach ($tcode as $t) {
                $tcode = $t->fruit_code;
                $q = "Select sum(no_of_plants) as no_of_fruit_plants from    chitha_fruit where fruit_plants_name='$tcode' ";
                // echo $q."<br>";
                $val[$code][$tcode] = $this->dbb->query($q)->row();
            }
            $data['name'] = $val;
        }

        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/fruitdist', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/fruitdist';
        $this->load->view('layouts/main',$data);
    }

    function fruitlistcircle() {
		$db=  $this->session->userdata('db');
        $data['dist'] = $databsearray = array(
            array('kamrupM', '24'),
            array('kamrup', '07'),
        );
        $datbase = $this->input->get('d');
        $getcode = $this->input->get('c');
        $size = sizeof($databsearray);
        for ($i = 0; $i < $size; $i++) {
            $name = $databsearray[$i][0];
            $code = $databsearray[$i][1];
            if ($name == $datbase and $code == $getcode) {

                $db = $this->load->database($code, TRUE);
                $this->dbb = $db;
                $q = "SELECT * FROM  location WHERE dist_code='$code' and subdiv_code !='00' and cir_code !='00' "
                        . " and Mouza_Pargona_code = '00' and Lot_no= '00' and vill_townprt_code= '00000'";
                $data['loc'] = $location = $this->dbb->query($q)->result();
                foreach ($location as $loc) {
                    $subdiv_code = $loc->subdiv_code;
                    $cir_code = $loc->cir_code;

                    $q = "Select * from    fruit_tree_code";
                    $tcode = $this->dbb->query($q)->result();
                    foreach ($tcode as $t) {
                        $tcode = $t->fruit_code;
                        $tname = $t->fruit_name;
                        $q = "Select sum(no_of_plants) as no_of_fruit_plants from    chitha_fruit where fruit_plants_name='$tcode' and cir_code='$cir_code' ";
                        $val[$tname] = $this->dbb->query($q)->row();
                    }
                    $circlewise[$cir_code] = $val;
                }
                $data['circle'] = $circlewise;
            }
        }
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/fruitcirclelist', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/fruitcirclelist';
        $this->load->view('layouts/main',$data);
    }
    ////////////////Modified 21/07/2021////////////////////

    function citizenBreakup($subdiv_code,$cir_code){
        $data = array();
        //var_dump(expression)
        //$app_date=date('Y-m-d',strtotime(CHANGE_DATE));
           
        $dist_code = $this->session->userdata('dist_code');
        //$subdiv_code=$this->session->userdata('subdiv_code');
        //$cir_code=$this->session->userdata('cir_code');
        $sdate = $this->session->userdata('sdate');
        $sdate = date('Y-m-d', strtotime($sdate));
        $edate = $this->session->userdata('edate');
        $edate = date('Y-m-d', strtotime($edate));
        $define_date=define_date;
        $sql="Select cert_type,cert_code from cert_type";
        $cert=$this->db->query($sql)->result();
        foreach($cert as $c){
            $certReg=0;
            $certPen=0;
            $certRej=0;
            $certDelv=0;
            
            $certRegT=0;
            $certPenT=0;
            $certRejT=0;
            $certDelvT=0;
            ///////////
            ////////////Cert Application/////////////////
            $sql = "Select * from cert_application where dist_code ='$dist_code'  and subdiv_code='$subdiv_code' and cir_code='$cir_code' and date_entry>='$sdate' and date_entry<='$edate' and cert_type='$c->cert_code' ";
            $apcancellation['registerCert'] = $this->db->query($sql)->result();
            //var_dump($apcancellation['registercase']);
            foreach($apcancellation['registerCert'] as $ap){
                $certReg = $certReg + 1;
                if($ap->status=='D'){
                    $certDelv=$certDelv+1;
                }
                if($ap->status!='D'){
                    $certPen=$certPen+1;
                }
                if($ap->status=='F'){
                    $certRej=$certRej+1;
                }
            }
            
            $sql = "Select * from cert_application where dist_code ='$dist_code'  and subdiv_code='$subdiv_code' and cir_code='$cir_code' and date_entry<='$edate'  and cert_type='$c->cert_code' and date_entry>='$define_date' ";    
            $apcancellation['reTotal'] = $this->db->query($sql)->result();
            foreach($apcancellation['reTotal'] as $ap){
                $certRegT = $certRegT + 1;
                if($ap->status=='D'){
                    $certDelvT=$certDelvT+1;
                }
                if($ap->status!='D'){
                    $certPenT=$certPenT+1;
                }
                if($ap->status=='F'){
                    $certRejT=$certRejT+1;
                }
            }
            $arrayName['data'][] = array(
                'type' => $c->cert_type,
                'certReg'=>$certReg,
                'certDelv'=>$certDelv,
                'certPen'=>$certPen,
                'certRej'=>$certRej,
                'certRegT'=>$certRegT,
                'certDelvT'=>$certDelvT,
                'certPenT'=>$certPenT,
                'certRejT'=>$certRejT,

            );

        }
        $arrayName['location']=array(
            'dist_code'=>$dist_code,
            'subdiv_code'=>$subdiv_code,
            'cir_code'=>$cir_code
        );
        $arrayName['_view'] = 'misreport/citizen_break_down';
        $this->load->view('layouts/main',$arrayName);
         // $this->load->view('../views/header');
         // $this->load->view('../views/misreport/citizen_break_down', $arrayName);
         // $this->load->view('../views/footer');
     }
     function pendingCert($subdiv_code,$cir_code){
        $dist_code = $this->session->userdata('dist_code');
        //$subdiv_code=$this->session->userdata('subdiv_code');
        //$cir_code=$this->session->userdata('cir_code');
        $sdate = $this->session->userdata('sdate');
        $sdate = date('Y-m-d', strtotime($sdate));
        $edate = $this->session->userdata('edate');
        $edate = date('Y-m-d', strtotime($edate));
        $define_date=define_date;
        $sql = "Select cert_no,date_entry,appln_name,
        CASE
            WHEN status ='M' THEN 'Pending With LM'
            WHEN status ='C' THEN 'Pending with CO'
            WHEN status ='R' THEN 'Pending with AST'
            WHEN status='' THEN 'Offline Registered' 
        END AS status
        from cert_application where dist_code ='$dist_code'  and subdiv_code='$subdiv_code' and cir_code='$cir_code' and date_entry>='$sdate' and date_entry<='$edate' and status!='D' ";
        $data['cert'] = $this->db->query($sql)->result_array();
        //var_dump($data);
        $data['_view'] = 'misreport/citizen_pendinglist';
        $this->load->view('layouts/main',$data);
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/citizen_pendinglist', $data);
        // $this->load->view('../views/footer');
     }
    ////////////////End Modified 21/07/2021////////////////////
    function lmStateCadre(){
        if($this->session->userdata('user_desig_code')!='CO')
        { 
            echo json_encode('You Not Allowed !'); 
            return;
        }
        $dist_code=$this->session->userdata('dist_code');
        $subdiv_code=$this->session->userdata('subdiv_code');
        $cir_code=$this->session->userdata('cir_code');
        $sql="Select t.name,t.confirm_y_n,
            (select loc_name from location where dist_code=t.dist_code and subdiv_code=t.subdiv_code and cir_code=t.cir_code and mouza_pargona_code=t.mouza_pargona_code and lot_no='00') mouza,
            (select loc_name from location where dist_code=t.dist_code and subdiv_code=t.subdiv_code and cir_code=t.cir_code and mouza_pargona_code=t.mouza_pargona_code and lot_no=t.lot_no and vill_townprt_code='00000') village
             from lm_state_cadre_y_n t where t.dist_code=? and t.subdiv_code=? and t.cir_code=?
        ";
        $data['lmstatecadre']=$this->db->query($sql,array($dist_code,$subdiv_code,$cir_code))->result_array();
        //log_message('error',$this->db->last_query());
        $data['_view'] = 'misreport/lmstatecadre';
        $this->load->view('layouts/main',$data);
    }

}
