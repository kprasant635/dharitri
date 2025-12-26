<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
ini_set('max_execution_time', 0);

class BackLogConversion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mutation/mutationmodel');
        $this->load->model('conversion/ASTofficeConversionModel');
        $this->load->model('conversion/CoofficeConversionModel');
        $this->load->model('basundhara/basundharamodel');
        $this->load->model('rtps/rtpsmodel');
        $this->load->helper(array('form', 'url'));
    }

    public function BackEntryConversion() {
		  $db=  $this->session->userdata('db');
        
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $this->session->set_userdata(array('end' => false));

        $data = $this->mutationmodel->getVillageCodeJSON($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $district['villages'] = $data;

        $patt_type = "select type_code,patta_type from    patta_code where conversion = 'y'";
        $district['patta_type_only_aksona'] = $this->db->query($patt_type)->result();

        $query = "select lm_name,lm_code from    lm_code where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
        $district['lmname'] = $this->db->query($query)->result();

        $query = "select username,user_code from    users where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
                . " user_desig_code='SK'";
        $district['skname'] = $this->db->query($query)->result();

        $query = "select username,user_code from    users where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
                . " user_desig_code='CO'";
        $district['coname'] = $this->db->query($query)->result();
        $district['_view'] = 'BackEntryConversion/BackEntryLandConversion';
        $this->load->view('layouts/main',$district);
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/BackEntryConversion/BackEntryLandConversion', $district);
        // $this->load->view('../views/footer');
    }

    public function check_case_no_exist() {
		  $db=  $this->session->userdata('db');
        $case_no = $_GET['case_no'];
        $suffix = '/CONV-BL';
        $case_no = $case_no . $suffix;
        $check_case = $this->db->query("select count(*) as cb from    petition_basic where case_no='$case_no'")->row()->cb;
        echo json_encode($check_case);
    }

    public function chech_if_already_registered($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $old_patta_no, $old_dag_no_int, $patta_type_code) {
          $db=  $this->session->userdata('db');
		$sqldag = "Select dag_no as c from    chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
                . "and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' and patta_type_code= '$patta_type_code' and dag_no_int = '$old_dag_no_int'"; // and dag_no_int = '$dag_no_int'

        $actual_dag_no = $this->db->query($sqldag)->row()->c;

        $check_dag = $this->db->query("select count(*) as cd from    petition_basic p join petition_dag_details d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code 
            and p.mouza_pargona_code = d.mouza_pargona_code and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.petition_no = d.petition_no where 
            p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and p.mouza_pargona_code='$mouza_pargona_code' and d.lot_no='$lot_no' and "
                        . "p.vill_townprt_code='$vill_townprt_code' and d.dag_no='$actual_dag_no' and d.patta_no ='$old_patta_no' and p.order_passed != 'Y'")->row()->cd; // and patta_type_code = '$new_patta_type'

        echo json_encode($check_dag);
    }

    public function chech_existing_dag($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $new_dag_no) {
       
  $db=  $this->session->userdata('db');
	   $check_dag = $this->db->query("Select count(*) as cd from    chitha_basic where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and "
                        . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code' and dag_no = '$new_dag_no'")->row()->cd; // and patta_type_code = '$new_patta_type'
        //if $check_dag is 1 then the dag exist
        echo json_encode($check_dag);
    }

    function BackLogRegister() {
		  $db=  $this->session->userdata('db');
        $define_date = define_date;
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            //var_dump($this->input->post());
            $dist_code = $this->input->post('dist_code');
            $subdiv_code = $this->input->post('subdiv_code');
            $circle_code = $this->input->post('circle_code');
            $mouza_code = $this->input->post('mouza_code');
            $lot_no = $this->input->post('lot_no');
            $vill_code = $this->input->post('vill_code');
            $patta_code = $this->input->post('patta_type');
            $patta_no = trim($this->input->post('patta_no'));
            $dag_no_int = $this->input->post('dag_no');
            $year_no = $this->input->post('year_no');

            $transfer_type = $this->input->post('transfer_type');
            $reg_deed_no = $this->input->post('reg_deed_no');
            $deed_value = $this->input->post('reg_deed_value');
            $reg_deed_date = date('Y-m-d', strtotime($this->input->post('reg_deed_date')));

            $dag_area_b = $this->input->post('dag_area_b');
            $dag_area_k = $this->input->post('dag_area_k');
            $dag_area_lc = $this->input->post('dag_area_lc');

            $m_dag_area_b = $this->input->post('m_dag_area_b');
            $m_dag_area_k = $this->input->post('m_dag_area_k');
            $m_dag_area_lc = $this->input->post('m_dag_area_lc');

            $l_dag_area_b_P = $this->input->post('l_dag_area_b_P');
            $l_dag_area_k_P = $this->input->post('l_dag_area_k_P');
            $l_dag_area_lc_P = $this->input->post('l_dag_area_lc_P');

            $case_no = $this->input->post('case_no');
            $FullOrPartial = $this->input->post('FullOrPartial');

            $converted_to_lessa_old = ($dag_area_b) * 100 + ($dag_area_k) * 20 + ($dag_area_lc);
            $converted_to_lessa_new = ($m_dag_area_b) * 100 + ($m_dag_area_k) * 20 + ($m_dag_area_lc);
            //left land portion
            $remaining_lessa = $converted_to_lessa_old - $converted_to_lessa_new;

            if ($remaining_lessa > 0) {
                $FullOrPartial = 'P';
            } else {
                $FullOrPartial = 'F';
            }

            $suffix = '/CONV-BL';
            // $petition_no = $this->db->query("select max(petition_no) as petition_no from    petition_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' "
            //                 . "and date_entry>='$define_date' and petition_no is not null limit 1")->row()->petition_no;

            // if ($petition_no == null) {
            //     $petition_no = 1;
            // } else {
            //     $petition_no+=1;
            // }

           // $petition_no=$this->basundharamodel->genearteOfficePetitionNo();

            $seq_pet=year_no.'00';
            $petition_no=$seq_pet.$this->rtpsmodel->genearteOfficePetitionNo();

            $pitition_no = $petition_no;
            $order_date = $this->input->post('order_date');

            $conversion_data_backdate = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'circle_code' => $circle_code,
                'mouza_pargona_code' => $mouza_code,
                'lot_no' => $lot_no,
                'vill_code' => $vill_code,
                'patta_type_code' => $patta_code,
                'patta_no' => $patta_no,
                'dag_no_int' => $dag_no_int,
                'dag_area_b' => $dag_area_b,
                'dag_area_k' => $dag_area_k,
                'dag_area_lc' => $dag_area_lc,
                'l_dag_area_b_P' => $l_dag_area_b_P,
                'l_dag_area_k_P' => $l_dag_area_k_P,
                'l_dag_area_lc_P' => $l_dag_area_lc_P,
                'm_dag_area_b' => $m_dag_area_b,
                'm_dag_area_k' => $m_dag_area_k,
                'm_dag_area_lc' => $m_dag_area_lc,
                'case_no' => $case_no . $suffix,
                'pitition_no' => $pitition_no, // exploded on / of the case no
                'ord_date' => $order_date,
                'FullOrPartial' => $FullOrPartial,
                'year_no' => $year_no,
                'reg_deed_no' => $reg_deed_no,
                'deed_value' => $deed_value,
                'reg_deed_date' => $reg_deed_date,
                'mut_type' => '01',
            );
            //var_dump($conversion_data_backdate);
            $this->session->set_userdata($conversion_data_backdate);

            $only_land_share = array(
                'bigha' => $m_dag_area_b,
                'kotha' => $m_dag_area_k,
                'lessa' => $m_dag_area_lc,
            );

            $this->session->set_userdata($only_land_share);

            redirect(base_url() . "index.php/BackLogConversion/BackLogConversionDetails");
        }
    }

    public function BackLogConversionDetails() {
		  $db=  $this->session->userdata('db');
        //var_dump($this->session->all_userdata());
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

        $PartialOrFull = $this->session->userdata('FullOrPartial');

        $patta_no = trim($this->session->userdata('patta_no'));
        $dag_no_int = $this->session->userdata('dag_no_int');
        $patta_type_code = $this->session->userdata('patta_type_code');

        $patta_name = $this->db->query("select patta_type from    patta_code where type_code='$patta_type_code'")->row();

        $bigha = $this->session->userdata('bigha');
        $kotha = $this->session->userdata('kotha');
        $lessa = $this->session->userdata('lessa');

        $rev_and_tax = "Select * from    chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
                . "and mouza_pargona_code='$mouza_pargona_code' and dag_no_int='$dag_no_int' and TRIM(patta_no) = '$patta_no' "
                . "and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' and patta_type_code= '$patta_type_code'";

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
            $b = round(floor($remaining_lessa / 100));
            $remainder = $remaining_lessa % 100;
            $k = round(floor($remainder / 20));
            $lc = round(floor($remainder % 20));
            $g = 0.0;
            $kr = 0.0;
            $saperating_bigha = $remaining_lessa - ($b * 100);
            $cal_new_rev = round($onelessa * $remaining_lessa, 2);
            $new_dag_local_tax = round($cal_new_rev / 4, 2);
        }

        $sqldag = "Select dag_no as c from    chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
                . "and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' and patta_type_code= '$patta_type_code' and dag_no_int = '$dag_no_int'"; // and dag_no_int = '$dag_no_int'

        $actual_dag_no = $this->db->query($sqldag)->row()->c;

        $data['datas'] = array(
            'patta_no' => $patta_no,
            'patta_type' => $patta_name->patta_type,
            'bigha' => $bigha,
            'kotha' => $kotha,
            'lessa' => round($lessa, 2),
            'dag_no' => $dag_no_int,
            'revenue' => $cal_new_rev,
            'local_tax' => $new_dag_local_tax,
            'PartialOrFull' => $PartialOrFull,
            'actual_dag_no' => $actual_dag_no
        );

        $data['type'] = $this->db->query("SELECT * FROM  patta_code")->result();

        $data['pattadar_details'] = $this->db->query("select p.pdar_id,p.pdar_name,p.pdar_father,p.pdar_add1,p.pdar_add2,p.pdar_add3,p.pdar_guard_reln,d.p_flag from    chitha_pattadar p join 
            chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code 
            and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and
            p.pdar_id = d.pdar_id and trim(p.patta_no) = trim(d.patta_no) where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and d.lot_no='$lot_no' and d.dag_no='$actual_dag_no' and trim(p.patta_no)='$patta_no' and p.patta_type_code='$patta_type_code'")->result(); //

        $data['payment_type'] = $this->db->query("Select * from    premium_chalan_receipt")->result();

        $query1 = "select lm_name,lm_code from    lm_code where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no'";
        $data['lmname'] = $this->db->query($query1)->result();

        $query2 = "select username,user_code from    users where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and user_desig_code='SK'";
        $data['skname'] = $this->db->query($query2)->result();

        $query3 = "select username,user_code from    users where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and user_desig_code='CO'";
        $data['coname'] = $this->db->query($query3)->result();

        $data['payment_type'] = $this->db->query("Select * from    premium_chalan_receipt")->result();

        $patt_type = $this->mutationmodel->getPattaTypeExcludingAksona();
        $data['patta_type_excluding_aksona'] = $patt_type;

        $this->load->model('patta/PattaModel');
        // $this->load->view('../views/header');
        // $this->load->view('../views/BackEntryConversion/RegisterOfficeConversion', $data);
        // $this->load->view('../views/footer');
        $data['_view'] = 'BackEntryConversion/RegisterOfficeConversion';
        $this->load->view('layouts/main',$data);
    }

    public function RegisterOConversion() {
		  $db=  $this->session->userdata('db');
        $this->db->trans_begin();

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_code');

        $patta_type_code = $this->session->userdata('patta_type_code');
        $patta_no = $this->session->userdata('patta_no');
        $dag_no_int = $this->session->userdata('dag_no_int');

        $dag_no = $this->db->query("Select dag_no as dag_no from    chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                        . "cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and patta_type_code= '$patta_type_code' "
                        . "and dag_no_int='$dag_no_int' and TRIM(patta_no) = '$patta_no'")->row()->dag_no;

        $mut_type = $this->session->userdata('FieldOrOffice');
        $case_no = $this->session->userdata('case_no');
        $report_date = $this->session->userdata('ord_date');
        $date_entry = $timestamp = date('Y-m-d G:i:s');
        $user_code = $this->input->post('co_code');

        $year_no = $this->session->userdata('year_no');
        $define_date = define_date;

        $coname = $this->db->query("select username from    users where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
                        . " user_desig_code='CO' and user_code ='$user_code' ")->row()->username;

        // $petition_no_new = $this->db->query("select max(petition_no) as petition_no from    petition_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
        //                 . "and petition_no is not null limit 1")->row()->petition_no;

        // if ($petition_no_new == null) {
        //     $petition_no_new = 1;
        // } else {
        //     $petition_no_new += 1;
        // }
        $petition_no_new=$this->basundharamodel->genearteOfficePetitionNo();
        $type_of_conversion = $this->session->userdata('FullOrPartial');

        $dag_area_b = $this->session->userdata('dag_area_b');
        $dag_area_k = $this->session->userdata('dag_area_k');
        $dag_area_lc = $this->session->userdata('dag_area_lc');
        $m_dag_area_b = $this->session->userdata('m_dag_area_b');
        $m_dag_area_k = $this->session->userdata('m_dag_area_k');
        $m_dag_area_lc = $this->session->userdata('m_dag_area_lc');

        $converted_to_lessa_old = ($dag_area_b) * 100 + ($dag_area_k) * 20 + ($dag_area_lc);
        $converted_to_lessa_new = ($m_dag_area_b) * 100 + ($m_dag_area_k) * 20 + ($m_dag_area_lc);
        //left land portion
        $remaining_lessa = $converted_to_lessa_old - $converted_to_lessa_new;

        if ($remaining_lessa > 0) {
            $type_of_conversion = 'P';
        } else {
            $type_of_conversion = 'F';
        }

        $petition_basic = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code,
            'year_no' => $this->session->userdata('year_no'),
            'petition_no' => $petition_no_new,
            'case_no' => $case_no,
            'submission_date' => $report_date,
            'mut_type' => '01',
            'trans_code' => $type_of_conversion,
            'user_code' => $this->input->post('lm_code'),
            'date_entry' => date('Y-m-d G:i:s'),
            'operation' => 'E',
            'deed_no' => $this->session->userdata('reg_deed_no'),
            'deed_value' => $this->session->userdata('deed_value'),
            'deed_date' => date('Y-m-d', strtotime($this->session->userdata('deed_date'))),
            'order_passed' => 'B',
            'status' => 'B',
            'add_off_name' => $coname,
            'co_user_code' => $this->input->post('co_code'),
            'date_of_order' => $this->input->post('co_date'),
        );
        //var_dump($petition_basic);
        $this->db->insert('petition_basic', $petition_basic); //******************************************************************

        $dags_data = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code,
            'year_no' => $this->session->userdata('year_no'),
            'petition_no' => $petition_no_new,
            'm_dag_area_b' => $this->session->userdata('m_dag_area_b'),
            'm_dag_area_k' => $this->session->userdata('m_dag_area_k'),
            'm_dag_area_lc' => $this->session->userdata('m_dag_area_lc'),
            'm_dag_area_g' => '0.0000',
            'm_dag_area_kr' => '0',
            'dag_area_b' => $this->session->userdata('dag_area_b'),
            'dag_area_k' => $this->session->userdata('dag_area_k'),
            'dag_area_lc' => $this->session->userdata('dag_area_lc'),
            'dag_area_g' => '0.0000',
            'dag_area_kr' => '0',
            'patta_no' => $patta_no,
            'patta_type_code' => $patta_type_code,
            'user_code' => $this->input->post('lm_code'),
            'date_entry' => $report_date,
            'operation' => 'E',
            'dag_no' => $dag_no
        );
        //var_dump($dags_data);
        $this->db->insert('petition_dag_details', $dags_data); //******************************************************************
        $i = 1;
        $query = "select * from    chitha_pattadar p join 
                    chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code 
                    and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and
                    p.pdar_id = d.pdar_id and TRIM(p.patta_no) = TRIM(d.patta_no) and p.patta_type_code = d.patta_type_code where 
                    d.dist_code='$dist_code' and d.subdiv_code='$subdiv_code' and d.cir_code='$cir_code' and d.mouza_pargona_code='$mouza_pargona_code' and "
                . "d.vill_townprt_code='$vill_townprt_code' and d.lot_no='$lot_no' and d.dag_no='$dag_no' and TRIM(d.patta_no)='$patta_no' 
                    and d.patta_type_code='$patta_type_code'";

        $data = $this->db->query($query)->result();

        $values = array();

        foreach ($data as $value) {
            $gurdian_relation = trim($value->pdar_guard_reln);
            if (($gurdian_relation == '') || ($gurdian_relation == null)) {
                $pdar_guard_reln = 'u';
            } else {
                $pdar_guard_reln = $value->pdar_guard_reln;
            }

            if ($value->p_flag == '1') {
                $pdar_strikeout = 'Y';
            } else {
                $pdar_strikeout = '';
            }

            $other_data = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'year_no' => $year_no,
                'petition_no' => $petition_no_new,
                'dag_no' => $dag_no,
                'patta_no' => $patta_no,
                'patta_type_code' => $patta_type_code,
                'pdar_id' => $value->pdar_id,
                'pdar_cron_no' => $i++,
                'pdar_name' => $value->pdar_name,
                'pdar_guardian' => $value->pdar_father,
                'pdar_rel_guar' => $pdar_guard_reln,
                'pdar_add1' => $value->pdar_add1,
                'pdar_add2' => $value->pdar_add2,
                'user_code' => 'AST',
                'date_entry' => $report_date,
                'operation' => 'E',
                'pdar_gender' => $value->pdar_gender,
                'pdar_mother' => $value->pdar_mother,
                'pdar_pan_no' => $value->pdar_pan_no,
                'pdar_citizen_no' => $value->pdar_citizen_no,
                'pdar_aadharno' => $value->pdar_aadharno,
                'pdar_mobile' => $value->pdar_mobile,
                'pdar_nrcno' => $value->pdar_nrcno
            );
            //var_dump($other_data);
            $this->db->insert('petitioner_part', $other_data); //******************************************************************

            $chitha_rmk_convorder = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'dag_no' => $dag_no,
                'year_no' => $year_no,
                'petition_no' => $petition_no_new,
                'ord_no' => $case_no,
                'ord_date' => $report_date,
                'patta_type_code' => $patta_type_code,
                'patta_no' => trim($patta_no),
                'ord_onbehalf_id' => $i++,
                'ord_onbehalf_of' => $value->pdar_name,
                'premium' => $this->input->post('total_premium'),
                'premi_chal_recpt' => $this->input->post('payment_type'),
                'premi_chal_recpt_no' => $this->input->post('chalan_no'),
                'land_area_b' => $this->session->userdata('m_dag_area_b'),
                'land_area_k' => $this->session->userdata('m_dag_area_k'),
                'land_area_lc' => $this->session->userdata('m_dag_area_lc'),
                'land_area_g' => '0.0000',
                'land_area_kr' => '0',
                'new_patta_type' => $this->input->post('new_patta_type'),
                'new_patta_no' => $this->input->post('sugg_patta_no'),
                'new_dag_no' => $this->input->post('sugg_dag_no'),
                'pdar_id' => $value->pdar_id,
                'pdar_strike' => $pdar_strikeout,
                'ord_onbehalf_guard' => $value->pdar_father,
                'ord_onbehalf_add1' => $value->pdar_add1,
                'ord_onbehalf_add2' => $value->pdar_add2,
                'pdar_gender' => $value->pdar_gender,
                'pdar_mother' => $value->pdar_mother,
                'pdar_guard_reln' => $pdar_guard_reln
            );
            //var_dump($chitha_rmk_convorder);
            $this->db->insert('t_chitha_rmk_convorder', $chitha_rmk_convorder); //****************************************************************
        }

        $chitha_rmk_ordbasic = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code,
            'dag_no' => $dag_no,
            'year_no' => $year_no,
            'petition_no' => $petition_no_new,
            'ord_no' => $case_no,
            'ord_date' => $report_date,
            'ord_type_code' => '01',
            'case_no' => $case_no,
            'ord_on_gl_type' => '',
            'ord_passby_sign_yn' => 'Y',
            'ord_passby_desig' => 'CO', //$order_passed_by,
            'ord_ref_let_no' => '',
            'lm_code' => $this->input->post('lm_code'),
            'lm_sign_yn' => $this->input->post('lmSign'),
            'lm_sign_date' => $this->input->post('lm_date'),
            'sk_code' => $this->input->post('sk_code'),
            'sk_sign_yn' => $this->input->post('skSign'),
            'sk_sign_date' => $this->input->post('sk_date'),
            'co_code' => $this->input->post('co_code'),
            'co_sign_yn' => $this->input->post('coSign'),
            'co_ord_date' => $this->input->post('co_date'),
            'm_dag_area_b' => $this->session->userdata('m_dag_area_b'),
            'm_dag_area_k' => $this->session->userdata('m_dag_area_k'),
            'm_dag_area_lc' => $this->session->userdata('m_dag_area_lc'),
            'm_dag_area_g' => '0.0000',
            'm_dag_area_kr' => '0',
            'make_mdb' => $type_of_conversion, //full conversion or partial
            'new_dag_no' => $this->input->post('sugg_dag_no'),
            'min_revenue' => $this->input->post('dag_revenue'),
        );
        //var_dump($chitha_rmk_ordbasic);
        $this->db->insert('t_chitha_rmk_ordbasic', $chitha_rmk_ordbasic); //****************************************************************

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->session->set_flashdata("message", "Case Cannot Be Registered. Contact Help Desk with Location Details");
            redirect(base_url() . "index.php/utility/backentry_utilities");
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata("message", "Back Log Office Conversion Case " . $case_no . " Registered Successfully.");
            redirect(base_url() . "index.php/utility/backentry_utilities");
        }
    }

    //----------------------------------------------------------------------------------- All Pending Case display for Conversion cases

    public function PendingCases() {
		  $db=  $this->session->userdata('db');
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $qP = "select count(*) as count from    petition_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and order_passed = 'B' and status = 'B' and "
                . "mut_type = '01'";
        $qP = $this->db->query($qP)->row()->count;

        $config['total_rows'] = $qP;

        $q1 = "select * from    petition_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type = '01' and order_passed = 'B' and status = 'B' "
                . "ORDER BY petition_no asc";
        $cases1 = $this->db->query($q1)->result();

        $cases['cases'] = $cases1;

        $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/BackEntryConversion/ConversionCases', $cases);
        // $this->load->view('../views/footer');
        $cases['_view'] = 'BackEntryConversion/ConversionCases';
            $this->load->view('layouts/main',$cases);
    }

    public function FinalOOrder() {
		  $db=  $this->session->userdata('db');
        $data = array();
        $case_no = $this->input->get('case_no');
        $dist_code1 = $this->session->userdata('dist_code');
        $subdiv_code1 = $this->session->userdata('subdiv_code');
        $cir_code1 = $this->session->userdata('cir_code');
        $mouza_pargona_code1 = $this->input->get('mouza_pargona_code');
        $lot_no1 = $this->input->get('lot_no');
        $vill_townprt_code1 = $this->input->get('vill_townprt_code');
        $mutation_type = $this->input->get('mut_type');

        $case_details = $this->db->query("select * from    petition_basic d where d.case_no='$case_no' and dist_code='$dist_code1' and subdiv_code='$subdiv_code1' and cir_code='$cir_code1' "
                        . "and mouza_pargona_code = '$mouza_pargona_code1' and lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1'")->result();
        $data['case_details'] = $case_details;

        $change_details = $this->db->query("select * from    t_chitha_rmk_convorder d where d.ord_no='$case_no' and dist_code='$dist_code1' and subdiv_code='$subdiv_code1' and cir_code='$cir_code1' "
                        . "and mouza_pargona_code = '$mouza_pargona_code1' and lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1' limit 1")->result();
        $data['change_details'] = $change_details;

        $petition_no = $case_details[0]->petition_no;
        $details = array(
            'case_no' => $case_details[0]->case_no, 'petition_no' => $case_details[0]->petition_no
        );
        $this->session->set_userdata($details);

        $dag_details = $this->db->query("select * from    petition_dag_details d where d.petition_no='$petition_no' and dist_code='$dist_code1' and subdiv_code='$subdiv_code1' and cir_code='$cir_code1' "
                        . "and mouza_pargona_code = '$mouza_pargona_code1' and lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1'")->result();
        $data['dag_details'] = $dag_details;

        $data['case_no'] = $case_no;
        $data['dist_code'] = $dist_code1;
        $data['subdiv_code'] = $subdiv_code1;
        $data['cir_code'] = $cir_code1;
        $data['mouza_pargona_code'] = $mouza_pargona_code1;
        $data['lot_no'] = $lot_no1;
        $data['vill_townprt_code'] = $vill_townprt_code1;

        $conversion_petitioner = $this->db->query("select * from    petitioner_part d where d.petition_no='$petition_no' and dist_code='$dist_code1' and subdiv_code='$subdiv_code1' and "
                        . "cir_code='$cir_code1' and mouza_pargona_code = '$mouza_pargona_code1' and lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1' and petition_no = '$petition_no'")->result();
        $data['conversion_petitioner'] = $conversion_petitioner;


        $dist_code = $this->utilityclass->getDistrictName($dist_code1);
        $subdiv_code = $this->utilityclass->getSubDivName($dist_code1, $subdiv_code1);
        $cir_code = $this->utilityclass->getCircleName($dist_code1, $subdiv_code1, $cir_code1);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($dist_code1, $subdiv_code1, $cir_code1, $mouza_pargona_code1);
        $lot_no = $this->utilityclass->getLotName($dist_code1, $subdiv_code1, $cir_code1, $mouza_pargona_code1, $lot_no1);
        $vill_townprt_code = $this->utilityclass->getVillageName($dist_code1, $subdiv_code1, $cir_code1, $mouza_pargona_code1, $lot_no1, $vill_townprt_code1);
        $data['location'] = array(
            'dist' => $dist_code,
            'sub' => $subdiv_code,
            'cir' => $cir_code,
            'mouza' => $mouza_pargona_code,
            'lot' => $lot_no,
            'vill' => $vill_townprt_code,
            'mutation_type' => $mutation_type,
        );
        //var_dump($data);
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/BackEntryConversion/CaseDetails', $data);
        // $this->load->view('../views/footer');
        $data['_view'] = 'BackEntryConversion/CaseDetails';
        $this->load->view('layouts/main',$data);
    }

    // public function UpdateFConv() {
	// 	  $db=  $this->session->userdata('db');
    //     $this->db->trans_begin();

    //     $petition_no = $this->session->userdata('petition_no');
    //     $dist_code = $this->session->userdata('dist_code');
    //     $subdiv_code = $this->session->userdata('subdiv_code');
    //     $cir_code = $this->session->userdata('cir_code');
    //     $case_no = $this->session->userdata('case_no');

    //     $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row();

    //     $query = "select * from    t_chitha_rmk_ordbasic where ord_no = '$case_no' and dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
    //             . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and "
    //             . "mouza_pargona_code='$petition_basic->mouza_pargona_code'";
    //     $result = $this->db->query($query)->result();

    //     foreach ($result as $order) {

    //         $query_rmk_hist = "select max(rmk_type_hist_no) as c from    chitha_rmk_gen where dist_code='$order->dist_code' and subdiv_code='$order->subdiv_code' and "
    //                 . "cir_code='$order->cir_code' and lot_no='$order->lot_no' and mouza_pargona_code='$order->mouza_pargona_code' and vill_townprt_code='$order->vill_townprt_code' "
    //                 . "and dag_no='$order->dag_no' ";

    //         $rmk_hist_no = $this->db->query($query_rmk_hist)->row()->c;

    //         if ($rmk_hist_no == null) {
    //             $rmk_hist_no = 1;
    //         } else
    //             $rmk_hist_no += 1;

    //         $q = "select max(ord_cron_no)+1 as c1,max(rmk_type_hist_no)+1 as c2 from    chitha_rmk_ordbasic where dist_code='$order->dist_code' and subdiv_code='$order->subdiv_code' "
    //                 . "and cir_code='$order->cir_code' and lot_no='$order->lot_no' and mouza_pargona_code='$order->mouza_pargona_code' and vill_townprt_code='$order->vill_townprt_code' "
    //                 . "and dag_no='$order->dag_no' ";

    //         $ord_cron_no = $this->db->query($q)->row()->c1;
    //         if ($ord_cron_no == null) {
    //             $ord_cron_no = 1;
    //         } else {
    //             $ord_cron_no+=1;
    //         }

    //         $chitha_basic_update = FALSE;
    //         $query = "select * from    t_chitha_rmk_convorder where ord_no='$order->ord_no' and iscorrected_inco is null ";
    //         $pattdars = $this->db->query($query)->result();

    //         foreach ($pattdars as $p) {
    //             $c = $p;
    //             $ord = clone $p;
    //             unset($c->year_no);
    //             unset($c->petition_no);
    //             unset($c->ord_no);
    //             unset($c->petition_no);
    //             unset($c->ord_date);
    //             unset($c->ord_date);
    //             unset($c->iscorrected_inco);
    //             unset($c->iscorrected_inco_date);
    //             unset($c->iscorrected_rkg_record);
    //             unset($c->iscorrected_rkg_date);
    //             unset($c->pdar_id);
    //             unset($c->pdar_strike);
    //             unset($c->ord_onbehalf_guard);
    //             unset($c->ord_onbehalf_add1);
    //             unset($c->ord_onbehalf_add2);
    //             unset($c->make_mdb);
    //             unset($c->is_converted_pattadar);
    //             unset($c->is_converted_pattadar);
    //             $c->rmk_type_hist_no = $rmk_hist_no;
    //             $c->ord_cron_no = $rmk_hist_no;
    //             $c->user_code = $this->session->userdata('user_code');
    //             $c->date_entry = date('Y-m-d G:i:s');
    //             $c->operation = 'E';
    //             //var_dump($c);
    //             $this->db->insert('chitha_rmk_convorder', $c); //****************************************************
    //             $d = date('Y-m-d');
    //             $update_conv_order_q = "update t_chitha_rmk_convorder set iscorrected_inco='Y',iscorrected_inco_date='$d' where ord_no='$order->ord_no'";
    //             $this->db->query($update_conv_order_q); //***********************************************
    //             //var_dump($ord);
    //             $data = array(
    //                 'pdar_name' => $ord->ord_onbehalf_of,
    //                 'pdar_father' => $ord->ord_onbehalf_guard,
    //                 'patta_no' => trim($ord->new_patta_no),
    //                 'patta_type_code' => $ord->new_patta_type,
    //                 'pdar_add1' => $ord->ord_onbehalf_add1,
    //                 'pdar_add2' => $ord->ord_onbehalf_add2,
    //                 'user_code' => $this->session->userdata('user_code'),
    //                 'date_entry' => date('Y-m-d G:i:s'),
    //                 'operation' => 'E',
    //                 'dist_code' => $ord->dist_code,
    //                 'subdiv_code' => $ord->subdiv_code,
    //                 'cir_code' => $ord->cir_code,
    //                 'mouza_pargona_code' => $ord->mouza_pargona_code,
    //                 'lot_no' => $ord->lot_no,
    //                 'vill_townprt_code' => $ord->vill_townprt_code,
    //                 'pdar_id' => $ord->pdar_id,
    //                 'new_pdar_name' => 'N',
    //                 'jama_yn' => ' ',
    //                 'pdar_gender' => $ord->pdar_gender,
    //                 'pdar_mother' => $ord->pdar_mother,
    //                 'pdar_guard_reln' => $ord->pdar_guard_reln
    //             );

    //             $chech_existance = $this->db->query("select count(*) as c from    chitha_pattadar where dist_code = '$ord->dist_code' and subdiv_code = '$ord->subdiv_code' and "
    //                             . "cir_code = '$ord->cir_code' and mouza_pargona_code = '$ord->mouza_pargona_code' "
    //                             . "and lot_no = '$ord->lot_no' and vill_townprt_code = '$ord->vill_townprt_code' and pdar_id = '$ord->pdar_id' "
    //                             . "and TRIM(patta_no) = trim('$ord->new_patta_no') and patta_type_code = '$ord->new_patta_type'")->row()->c;

    //             if ($chech_existance == 0) {
    //                 //var_dump($data);
    //                 $this->db->insert('chitha_pattadar', $data); //***********************************************
    //             }

    //             $landArea_query = "select dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr from    chitha_basic where dist_code='$ord->dist_code' and "
    //                     . "subdiv_code='$ord->subdiv_code' and cir_code='$ord->cir_code' and lot_no='$ord->lot_no' and mouza_pargona_code='$ord->mouza_pargona_code' and "
    //                     . "vill_townprt_code='$ord->vill_townprt_code' and dag_no='$ord->dag_no' and TRIM(patta_no)=trim('$ord->patta_no') and patta_type_code='$ord->patta_type_code'";

    //             if ($chitha_basic_update == FALSE) {

    //                 $landclass_query = "select land_class_code from    chitha_basic  where dist_code='$ord->dist_code' and subdiv_code='$ord->subdiv_code' and cir_code='$ord->cir_code'"
    //                         . " and lot_no='$ord->lot_no' and mouza_pargona_code='$ord->mouza_pargona_code' and vill_townprt_code='$ord->vill_townprt_code' and dag_no='$ord->dag_no' limit 1";

    //                 $landclasscode = $this->db->query($landclass_query)->row()->land_class_code;
    //                 $user_code = $this->session->userdata('user_code');
    //                 $date_entry = date('Y-m-d G:i:s');
    //                 $new_revenue = $order->min_revenue;
    //                 $dag_local_tax = round($new_revenue / 4, 2);

    //                 $chitha_update = "update chitha_basic set patta_no=trim('$ord->new_patta_no'), old_patta_no=trim('$ord->patta_no'),dag_no='$ord->new_dag_no',"
    //                         . "patta_type_code='$ord->new_patta_type',user_code='$user_code', date_entry='$date_entry', operation='E',jama_yn=' ', land_class_code='$landclasscode', "
    //                         . "dag_revenue = '$new_revenue', dag_local_tax = '$dag_local_tax' where dist_code='$ord->dist_code' and subdiv_code='$ord->subdiv_code' and cir_code='$ord->cir_code'"
    //                         . " and lot_no='$ord->lot_no' and mouza_pargona_code='$ord->mouza_pargona_code' and vill_townprt_code='$ord->vill_townprt_code' and dag_no='$ord->dag_no'  "
    //                         . " and TRIM(patta_no)=trim('$ord->patta_no') and patta_type_code='$ord->patta_type_code'";

    //                 $this->db->query($chitha_update);  //***********************************************
    //                 $chitha_basic_update = TRUE;
    //             }

    //             $update_query = "update chitha_dag_pattadar set operation='M' where dist_code='$ord->dist_code' and subdiv_code='$ord->subdiv_code' and cir_code='$ord->cir_code'"
    //                     . " and lot_no='$ord->lot_no' and mouza_pargona_code='$ord->mouza_pargona_code' and vill_townprt_code='$ord->vill_townprt_code' and dag_no='$ord->dag_no' "
    //                     . " and pdar_id=$ord->pdar_id and patta_type_code='$ord->patta_type_code' and TRIM(patta_no)=trim('$ord->patta_no')";

    //             $this->db->query($update_query);  //***********************************************

    //             if ($ord->pdar_strike == 'Y') {
    //                 $p_flag = '1';
    //             } else {
    //                 $p_flag = '';
    //             }
    //             $dag_pattadar = array(
    //                 'dist_code' => $ord->dist_code,
    //                 'subdiv_code' => $ord->subdiv_code,
    //                 'cir_code' => $ord->cir_code,
    //                 'mouza_pargona_code' => $ord->mouza_pargona_code,
    //                 'lot_no' => $ord->lot_no,
    //                 'vill_townprt_code' => $ord->vill_townprt_code,
    //                 'pdar_id' => $ord->pdar_id,
    //                 'patta_no' => trim($ord->new_patta_no),
    //                 'dag_no' => $ord->new_dag_no,
    //                 'patta_type_code' => $ord->new_patta_type,
    //                 'dag_por_b' => $ord->land_area_b,
    //                 'dag_por_k' => $ord->land_area_k,
    //                 'dag_por_lc' => $ord->land_area_lc,
    //                 'dag_por_g' => 0.0,
    //                 'dag_por_kr' => 0,
    //                 'user_code' => $this->session->userdata('user_code'),
    //                 'date_entry' => date('Y-m-d G:i:s'),
    //                 'operation' => 'E',
    //                 'p_flag' => $p_flag,
    //             );
    //             //var_dump($dag_pattadar);
    //             $this->db->insert('chitha_dag_pattadar', $dag_pattadar);  //***********************************************
    //         }

    //         unset($order->year_no);
    //         unset($order->petition_no);
    //         unset($order->petition_no);
    //         unset($order->iscorrected_inco);
    //         unset($order->iscorrected_inco_date);
    //         unset($order->iscorrected_rkg_record);
    //         unset($order->iscorrected_rkg_date);
    //         unset($order->pdar_id);
    //         unset($order->pdar_strike);
    //         unset($order->ord_onbehalf_guard);
    //         unset($order->ord_onbehalf_add1);
    //         unset($order->ord_onbehalf_add2);
    //         unset($order->make_mdb);
    //         unset($order->is_converted_pattadar);
    //         unset($order->patta_type_code);
    //         unset($order->ord_onbehalf_id);
    //         unset($order->ord_onbehalf_of);
    //         unset($order->premium);
    //         unset($order->premi_chal_recpt);
    //         unset($order->premi_chal_recpt_no);
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
    //         $order->operation = 'B';
    //         $order->date_entry = date('Y-m-d G:i:s');
    //         $order->area_left_b = 0;
    //         $order->area_left_k = 0;
    //         $order->area_left_lc = 0;
    //         $order->area_left_g = 0;
    //         $order->area_left_kr = 0;

    //         $get_patta_no = $this->db->query("select distinct(new_patta_no) as new_patta_no from    t_chitha_rmk_convorder where ord_no='$order->ord_no'")->row()->new_patta_no;

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
    //             'jama_updated' => ' ',
    //             'new_dag_no' => $order->new_dag_no,
    //             'patta_no' => trim($get_patta_no)
    //         );
    //         //var_dump($rmk_gen);
    //         $this->db->insert('chitha_rmk_gen', $rmk_gen); //***********************************************
    //         //var_dump($order);
    //         $this->db->insert('chitha_rmk_ordbasic', $order); //***********************************************
    //         $d = date('Y-m-d');
    //         $update_q = "update t_chitha_rmk_ordbasic set iscorrected_inco='Y',iscorrected_inco_date='$d' where ord_no='$order->ord_no' and dist_code='$petition_basic->dist_code' "
    //                 . "and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code'";
    //         $this->db->query($update_q); //***********************************************

    //         if ($this->db->trans_status() === FALSE) {
    //             $this->db->trans_rollback();
    //             echo "Error Occured";
    //         } else {
    //             $this->db->trans_commit();

    //             $order_update_query = "update petition_basic set order_passed='Y' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                     . "petition_no='$petition_no' and case_no = '$case_no'";
    //             $this->db->query($order_update_query);

    //             $this->session->set_flashdata("message", "Back Log Office Conversion Case " . $case_no . " Passed Successfully.");
    //             redirect(base_url() . "index.php/utility/backentry_utilities");
    //         }
    //     }
    // }

    // public function UpdatePConv() {
	// 	  $db=  $this->session->userdata('db');
    //     $this->db->trans_begin();

    //     $petition_no = $this->session->userdata('petition_no');
    //     $dist_code = $this->session->userdata('dist_code');
    //     $subdiv_code = $this->session->userdata('subdiv_code');
    //     $cir_code = $this->session->userdata('cir_code');
    //     $case_no = $this->session->userdata('case_no');

    //     $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row();


    //     $query = "select * from    t_chitha_rmk_ordbasic where ord_no = '$case_no' and dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
    //             . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and "
    //             . "mouza_pargona_code='$petition_basic->mouza_pargona_code'";

    //     $result = $this->db->query($query)->result();

    //     foreach ($result as $order) {

    //         $query_rmk_hist = "select max(rmk_type_hist_no) as c from    chitha_rmk_gen where dist_code='$order->dist_code' and subdiv_code='$order->subdiv_code' "
    //                 . "and cir_code='$order->cir_code' and lot_no='$order->lot_no' and mouza_pargona_code='$order->mouza_pargona_code' and vill_townprt_code='$order->vill_townprt_code' "
    //                 . "and dag_no='$order->dag_no' ";

    //         $rmk_hist_no = $this->db->query($query_rmk_hist)->row()->c;

    //         if ($rmk_hist_no == null) {
    //             $rmk_hist_no = 1;
    //         } else
    //             $rmk_hist_no += 1;

    //         $q = "select max(ord_cron_no)+1 as c1,max(rmk_type_hist_no)+1 as c2 from    chitha_rmk_ordbasic where dist_code='$order->dist_code' and subdiv_code='$order->subdiv_code' "
    //                 . "and cir_code='$order->cir_code' and lot_no='$order->lot_no' and mouza_pargona_code='$order->mouza_pargona_code' and vill_townprt_code='$order->vill_townprt_code' "
    //                 . "and dag_no='$order->dag_no' ";

    //         $ord_cron_no = $this->db->query($q)->row()->c1;
    //         if ($ord_cron_no == null) {
    //             $ord_cron_no = 1;
    //         } else {
    //             $ord_cron_no+=1;
    //         }

    //         $chitha_basic_update = FALSE;
    //         $query = "select * from    t_chitha_rmk_convorder where ord_no='$order->ord_no' and iscorrected_inco is null ";
    //         $pattdars = $this->db->query($query)->result();
    //         foreach ($pattdars as $p) {
    //             $c = $p;
    //             $ord = clone $p;
    //             unset($c->year_no);
    //             unset($c->petition_no);
    //             unset($c->ord_no);
    //             unset($c->petition_no);
    //             unset($c->ord_date);
    //             unset($c->iscorrected_inco);
    //             unset($c->iscorrected_inco_date);
    //             unset($c->iscorrected_rkg_record);
    //             unset($c->iscorrected_rkg_date);
    //             unset($c->pdar_id);
    //             unset($c->pdar_strike);
    //             unset($c->ord_onbehalf_guard);
    //             unset($c->ord_onbehalf_add1);
    //             unset($c->ord_onbehalf_add2);
    //             unset($c->make_mdb);
    //             unset($c->is_converted_pattadar);
    //             unset($c->is_converted_pattadar);
    //             $c->rmk_type_hist_no = $rmk_hist_no;
    //             $c->ord_cron_no = $rmk_hist_no;
    //             $c->user_code = $this->session->userdata('user_code');
    //             $c->date_entry = date('Y-m-d G:i:s');
    //             $c->operation = 'E';
    //             //var_dump($c);
    //             $this->db->insert('chitha_rmk_convorder', $c); //****************************************************
    //             $d = date('Y-m-d');
    //             $update_conv_order_q = "update t_chitha_rmk_convorder set iscorrected_inco='Y',iscorrected_inco_date='$d'  where ord_no='$order->ord_no'";
    //             $this->db->query($update_conv_order_q); //******************************************

    //             $data = array(
    //                 'pdar_name' => $ord->ord_onbehalf_of,
    //                 'pdar_father' => $ord->ord_onbehalf_guard,
    //                 'patta_no' => trim($ord->new_patta_no),
    //                 'patta_type_code' => $ord->new_patta_type,
    //                 'pdar_add1' => $ord->ord_onbehalf_add1,
    //                 'pdar_add2' => $ord->ord_onbehalf_add2,
    //                 'user_code' => $this->session->userdata('user_code'),
    //                 'date_entry' => date('Y-m-d G:i:s'),
    //                 'operation' => 'E',
    //                 'dist_code' => $ord->dist_code,
    //                 'subdiv_code' => $ord->subdiv_code,
    //                 'cir_code' => $ord->cir_code,
    //                 'mouza_pargona_code' => $ord->mouza_pargona_code,
    //                 'lot_no' => $ord->lot_no,
    //                 'vill_townprt_code' => $ord->vill_townprt_code,
    //                 'pdar_id' => $ord->pdar_id,
    //                 'new_pdar_name' => 'N',
    //                 'jama_yn' => '',
    //                 'pdar_gender' => $ord->pdar_gender,
    //                 'pdar_mother' => $ord->pdar_mother,
    //                 'pdar_guard_reln' => $ord->pdar_guard_reln
    //             );

    //             $chech_existance = $this->db->query("select count(*) as c from    chitha_pattadar where dist_code = '$ord->dist_code' and subdiv_code = '$ord->subdiv_code' and "
    //                             . "cir_code = '$ord->cir_code' and mouza_pargona_code = '$ord->mouza_pargona_code' and lot_no = '$ord->lot_no' and vill_townprt_code = '$ord->vill_townprt_code' "
    //                             . "and pdar_id = '$ord->pdar_id' and TRIM(patta_no) = trim('$ord->new_patta_no') and patta_type_code = '$ord->new_patta_type'")->row()->c;

    //             if ($chech_existance == 0) {
    //                 //var_dump($data);
    //                 $this->db->insert('chitha_pattadar', $data); //******************************************
    //             }

    //             $landArea_query = "select dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,dag_revenue from    chitha_basic where dist_code='$ord->dist_code' and "
    //                     . "subdiv_code='$ord->subdiv_code' and cir_code='$ord->cir_code' and lot_no='$ord->lot_no' and mouza_pargona_code='$ord->mouza_pargona_code' and "
    //                     . " vill_townprt_code='$ord->vill_townprt_code' and dag_no='$ord->dag_no' and TRIM(patta_no)=trim('$ord->patta_no') and patta_type_code='$ord->patta_type_code'";

    //             $b = '0';
    //             $k = '0';
    //             $lc = '0';
    //             $g = '0.0';
    //             $kr = '0.0';

    //             $old_b = $this->db->query($landArea_query)->row()->dag_area_b;
    //             $old_k = $this->db->query($landArea_query)->row()->dag_area_k;
    //             $old_lc = $this->db->query($landArea_query)->row()->dag_area_lc;
    //             $old_dag_revenue = $this->db->query($landArea_query)->row()->dag_revenue;
    //             $old_g = 0.0;
    //             $old_kr = 0.0;
    //             $converted_to_lessa_old = ($old_b) * 100 + ($old_k) * 20 + ($old_lc);
    //             //to be converted land portion
    //             $converted_b = $ord->land_area_b;
    //             $converted_k = $ord->land_area_k;
    //             $converted_lc = $ord->land_area_lc;
    //             $converted_g = 0.0;
    //             $converted_kr = 0.0;
    //             $converted_to_lessa_new = ($converted_b) * 100 + ($converted_k) * 20 + ($converted_lc);
    //             //left land portion
    //             $remaining_lessa = $converted_to_lessa_old - $converted_to_lessa_new;
    //             $b = round(floor($remaining_lessa / 100));
    //             $remainder = $remaining_lessa % 100;
    //             $k = round(floor($remainder / 20));
    //             $lc = round(floor($remainder % 20));
    //             $g = 0.0;
    //             $kr = 0.0;
    //             //revenue
    //             $new_revenue = $order->min_revenue;
    //             $dag_local_tax = round($new_revenue / 4, 2);


    //             if ($chitha_basic_update == FALSE) {
    //                 // dag rev to be changed  ***************************************  dag_revenue = '0.0', dag_local_tax = '0.00'  
    //                 $chitha_update = "update chitha_basic set dag_area_b='$b',dag_area_k='$k',dag_area_lc='$lc',dag_area_g='$g',dag_area_kr='$kr',jama_yn='' "
    //                         . "where dist_code='$ord->dist_code' and subdiv_code='$ord->subdiv_code' and cir_code='$ord->cir_code' "
    //                         . "and lot_no='$ord->lot_no' and mouza_pargona_code='$ord->mouza_pargona_code' and vill_townprt_code='$ord->vill_townprt_code' and dag_no='$ord->dag_no' "
    //                         . "and TRIM(patta_no)=trim('$ord->patta_no') and patta_type_code='$ord->patta_type_code'";

    //                 $this->db->query($chitha_update);  //******************************************

    //                 $landclass_query = "select land_class_code from    chitha_basic  where dist_code='$ord->dist_code' and subdiv_code='$ord->subdiv_code' and cir_code='$ord->cir_code'"
    //                         . " and lot_no='$ord->lot_no' and mouza_pargona_code='$ord->mouza_pargona_code' and vill_townprt_code='$ord->vill_townprt_code' and dag_no='$ord->dag_no' limit 1";

    //                 $landclasscode = $this->db->query($landclass_query)->row()->land_class_code;
    //                 $dag_no_int = $ord->new_dag_no . "00";
    //                 $chitha_basic = array(
    //                     'dist_code' => $ord->dist_code,
    //                     'subdiv_code' => $ord->subdiv_code,
    //                     'cir_code' => $ord->cir_code,
    //                     'mouza_pargona_code' => $ord->mouza_pargona_code,
    //                     'lot_no' => $ord->lot_no,
    //                     'vill_townprt_code' => $ord->vill_townprt_code,
    //                     'patta_no' => trim($ord->new_patta_no),
    //                     'old_patta_no' => trim($ord->patta_no),
    //                     'old_dag_no' => $ord->dag_no,
    //                     'dag_no' => $ord->new_dag_no,
    //                     'dag_no_int' => $dag_no_int,
    //                     'patta_type_code' => $ord->new_patta_type,
    //                     'dag_area_b' => $ord->land_area_b,
    //                     'dag_area_k' => $ord->land_area_k,
    //                     'dag_area_lc' => $ord->land_area_lc,
    //                     'dag_area_g' => 0.0,
    //                     'dag_area_kr' => 0,
    //                     'dag_revenue' => $new_revenue,
    //                     'dag_local_tax' => $dag_local_tax,
    //                     'user_code' => $this->session->userdata('user_code'),
    //                     'date_entry' => date('Y-m-d G:i:s'),
    //                     'operation' => 'E',
    //                     'jama_yn' => ' ',
    //                     'land_class_code' => $landclasscode
    //                 );
    //                 //var_dump($chitha_basic);
    //                 $this->db->insert('chitha_basic', $chitha_basic);  //******************************************
    //                 $chitha_basic_update = TRUE;
    //             }

    //             if ($ord->pdar_strike == 'Y') {
    //                 $p_flag = '1';
    //             } else {
    //                 $p_flag = '0';
    //             }

    //             $update_query = "update chitha_dag_pattadar set p_flag='$p_flag',operation='M' where dist_code='$ord->dist_code' and subdiv_code='$ord->subdiv_code' and "
    //                     . "cir_code='$ord->cir_code' and lot_no='$ord->lot_no' and mouza_pargona_code='$ord->mouza_pargona_code' and vill_townprt_code='$ord->vill_townprt_code' "
    //                     . "and dag_no='$ord->dag_no' and pdar_id='$ord->pdar_id' and patta_type_code='$ord->patta_type_code'";

    //             $this->db->query($update_query);  //******************************************

    //             $dag_pattadar = array(
    //                 'dist_code' => $ord->dist_code,
    //                 'subdiv_code' => $ord->subdiv_code,
    //                 'cir_code' => $ord->cir_code,
    //                 'mouza_pargona_code' => $ord->mouza_pargona_code,
    //                 'lot_no' => $ord->lot_no,
    //                 'vill_townprt_code' => $ord->vill_townprt_code,
    //                 'pdar_id' => $ord->pdar_id,
    //                 'patta_no' => trim($ord->new_patta_no),
    //                 'dag_no' => $ord->new_dag_no,
    //                 'patta_type_code' => $ord->new_patta_type,
    //                 'dag_por_b' => $ord->land_area_b,
    //                 'dag_por_k' => $ord->land_area_k,
    //                 'dag_por_lc' => $ord->land_area_lc,
    //                 'dag_por_g' => 0.0,
    //                 'dag_por_kr' => 0,
    //                 'user_code' => $this->session->userdata('user_code'),
    //                 'date_entry' => date('Y-m-d G:i:s'),
    //                 'operation' => 'E',
    //                 'p_flag' => $p_flag,
    //             );
    //             //var_dump($dag_pattadar);
    //             $this->db->insert('chitha_dag_pattadar', $dag_pattadar);  //*********************
    //         }

    //         unset($order->year_no);
    //         unset($order->petition_no);
    //         unset($order->petition_no);
    //         unset($order->iscorrected_inco);
    //         unset($order->iscorrected_inco_date);
    //         unset($order->iscorrected_rkg_record);
    //         unset($order->iscorrected_rkg_date);
    //         unset($order->pdar_id);
    //         unset($order->pdar_strike);
    //         unset($order->ord_onbehalf_guard);
    //         unset($order->ord_onbehalf_add1);
    //         unset($order->ord_onbehalf_add2);
    //         unset($order->make_mdb);
    //         unset($order->is_converted_pattadar);
    //         unset($order->patta_type_code);
    //         unset($order->ord_onbehalf_id);
    //         unset($order->ord_onbehalf_of);
    //         unset($order->premium);
    //         unset($order->premi_chal_recpt);
    //         unset($order->premi_chal_recpt_no);
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
    //         $order->operation = 'B';
    //         $order->date_entry = date('Y-m-d G:i:s');
    //         $order->area_left_b = 0;
    //         $order->area_left_k = 0;
    //         $order->area_left_lc = 0;
    //         $order->area_left_g = 0;
    //         $order->area_left_kr = 0;

    //         $get_new_patta_no = $this->db->query("select distinct(new_patta_no) as new_patta_no from    t_chitha_rmk_convorder where ord_no='$order->ord_no'")->row()->new_patta_no;
    //         $get_old_patta_no = $this->db->query("select distinct(patta_no) as patta_no from    t_chitha_rmk_convorder where ord_no='$order->ord_no'")->row()->patta_no;
    //         //this is for the old one
    //         $rmk_gen_for_old = array(
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
    //             'jama_updated' => ' ',
    //             'new_dag_no' => $order->new_dag_no,
    //             'patta_no' => trim($get_old_patta_no)
    //         );
    //         //var_dump($rmk_gen_for_old);
    //         $this->db->insert('chitha_rmk_gen', $rmk_gen_for_old); //******************************************
    //         //this is for the new one
    //         $rmk_gen_for_new = array(
    //             'dist_code' => $order->dist_code,
    //             'subdiv_code' => $order->subdiv_code,
    //             'cir_code' => $order->cir_code,
    //             'mouza_pargona_code' => $order->mouza_pargona_code,
    //             'vill_townprt_code' => $order->vill_townprt_code,
    //             'lot_no' => $order->lot_no,
    //             'dag_no' => $order->new_dag_no,
    //             'rmk_type_code' => '01',
    //             'rmk_type_hist_no' => $rmk_hist_no,
    //             'user_code' => $this->session->userdata('user_code'),
    //             'operation' => 'E',
    //             'date_entry' => date('Y-m-d G:i:s'),
    //             'jama_updated' => ' ',
    //             'new_dag_no' => null,
    //             'patta_no' => trim($get_new_patta_no)
    //         );
    //         //var_dump($rmk_gen_for_new);
    //         $this->db->insert('chitha_rmk_gen', $rmk_gen_for_new); //******************************************
    //         //var_dump($order);
    //         $this->db->insert('chitha_rmk_ordbasic', $order); //******************************************
    //         unset($order->dag_no);
    //         $order->dag_no = $order->new_dag_no;
    //         $newDag = $order->new_dag_no;
    //         unset($order->new_dag_no);
    //         //var_dump($order);
    //         $this->db->insert('chitha_rmk_ordbasic', $order);  //******************************************
    //         $d = date('Y-m-d');
    //         $update_q = "update t_chitha_rmk_ordbasic set iscorrected_inco='Y',iscorrected_inco_date='$d' where ord_no='$order->ord_no' and dist_code='$petition_basic->dist_code' "
    //                 . "and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and "
    //                 . "vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code'";

    //         $this->db->query($update_q); //******************************************

    //         if ($this->db->trans_status() === FALSE) {
    //             $this->db->trans_rollback();
    //             echo "Error Occured";
    //         } else {
    //             $this->db->trans_commit();

    //             $order_update_query = "update petition_basic set order_passed='Y' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                     . "petition_no='$petition_no' and case_no = '$case_no'";
    //             $this->db->query($order_update_query);

    //             $this->session->set_flashdata("message", "Back Log Office Conversion Case " . $case_no . " Passed Successfully.");
    //             redirect(base_url() . "index.php/utility/backentry_utilities");
    //         }
    //     }
    // }

    //----------------------------------------------------------------------------------------------- Report for CO starts here.
    public function Report() {
		  $db=  $this->session->userdata('db');
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $q1 = "select * from    chitha_rmk_ordbasic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and ord_type_code = '01' and "
                . "operation = 'B' ORDER BY date_entry asc";
        $cases1 = $this->db->query($q1)->result();

        $cases['cases'] = array_merge($cases1);

        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/BackEntryConversion/GenerateReport', $cases);
        // $this->load->view('../views/footer');
        $cases['_view'] = 'BackEntryConversion/CaseDetails';
        $this->load->view('layouts/main',$cases);
    }

    //----------------------------------------------------------------------------------------------- Report for DC/ADC starts here.
    
    public function MaxReport() {
		  $db=  $this->session->userdata('db');
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');

        $location = "select * from    location where cir_code != '00' and mouza_pargona_code = '00'";
        $location = $this->db->query($location)->result();

        foreach ($location as $loc) {
            $total_count_Fmutation = '';
            $total_count_Omutation = '';
            $total_count_Fpartition = '';
            $total_count_Opartition = '';
            $order_type_code = '';
            $districtdata = $this->utilityclass->getDistrictName($dist_code);
            $subdivdata = $this->utilityclass->getSubDivName($dist_code, $loc->subdiv_code);
            $circledata = $this->utilityclass->getCircleName($dist_code, $loc->subdiv_code, $loc->cir_code);
            $q = "select count(*) as count from    chitha_col8_order where dist_code='$dist_code' and subdiv_code='$loc->subdiv_code' and cir_code='$loc->cir_code' and order_type_code = '01' "
                    . "and operation = 'B'";
            $cases1 = $this->db->query($q)->row()->count;
            if ($cases1 > 0) {
                $total_count_Fmutation = $cases1;
            }

            $q1 = "select count(*) as count from    chitha_rmk_ordbasic where dist_code='$dist_code' and subdiv_code='$loc->subdiv_code' and cir_code='$loc->cir_code' and ord_type_code = '03' and "
                    . "operation = 'B'";
            $cases2 = $this->db->query($q1)->row()->count;
            if ($cases2 > 0) {
                $total_count_Omutation = $cases2;
            }
            $main = array
                (
                'dist_code' => $dist_code,
                'subdiv_code' => $loc->subdiv_code,
                'cir_code' => $loc->cir_code,
                'dist_name' => $districtdata,
                'subdiv_name' => $subdivdata,
                'cir_name' => $circledata,
                'total_count_Fmutation' => $total_count_Fmutation,
                'total_count_Omutation' => $total_count_Omutation,
                'total_count_Fpartition' => $total_count_Fpartition,
                'total_count_Opartition' => $total_count_Opartition,
            );
            $result[] = $main;
        }
        $data['result'] = $result;

        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/BackEntryConversion/GenerateMaxReport', $data);
        // $this->load->view('../views/footer');
        $data['_view'] = 'BackEntryConversion/GenerateMaxReport';
        $this->load->view('layouts/main',$data);
    }

    public function MaxReportVill() {
		  $db=  $this->session->userdata('db');
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $circle_code = $this->input->get('cir_code');
        $order_type_code = $this->input->get('order_type');

        if ($order_type_code == 'FM') {
            $data['report_lebel'] = 'Field Mutation';
        } elseif ($order_type_code == 'OM') {
            $data['report_lebel'] = 'Office Mutation';
        } elseif ($order_type_code == 'FP') {
            $data['report_lebel'] = 'Field Partition';
        } elseif ($order_type_code == 'OP') {
            $data['report_lebel'] = 'Office Partition';
        }

        $location = "select * from    location where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$circle_code' and mouza_pargona_code != '00' and lot_no != '00' "
                . "and vill_townprt_code != '00000'";
        $location = $this->db->query($location)->result();

        foreach ($location as $loc) {
            $districtdata = $this->utilityclass->getDistrictName($dist_code);
            $subdivdata = $this->utilityclass->getSubDivName($dist_code, $loc->subdiv_code);
            $circledata = $this->utilityclass->getCircleName($dist_code, $loc->subdiv_code, $loc->cir_code);
            $mouzadata = $this->utilityclass->getMouzaName($dist_code, $loc->subdiv_code, $loc->cir_code, $loc->mouza_pargona_code);
            $lotdata = $this->utilityclass->getLotName($dist_code, $loc->subdiv_code, $loc->cir_code, $loc->mouza_pargona_code, $loc->lot_no);
            $villdata = $this->utilityclass->getVillageName($dist_code, $loc->subdiv_code, $loc->cir_code, $loc->mouza_pargona_code, $loc->lot_no, $loc->vill_townprt_code);

            if ($order_type_code == 'FM') {
                $q = "select count(*) as count from    chitha_col8_order where dist_code='$dist_code' and subdiv_code='$loc->subdiv_code' and cir_code='$loc->cir_code' and "
                        . "mouza_pargona_code='$loc->mouza_pargona_code' and lot_no = '$loc->lot_no' and vill_townprt_code = '$loc->vill_townprt_code' and  order_type_code = '01' "
                        . "and operation = 'B'";
                $cases1 = $this->db->query($q)->row()->count;
            } elseif ($order_type_code == 'OM') {
                $q = "select count(*) as count from    chitha_rmk_ordbasic where dist_code='$dist_code' and subdiv_code='$loc->subdiv_code' and cir_code='$loc->cir_code' and "
                        . "mouza_pargona_code='$loc->mouza_pargona_code' and lot_no = '$loc->lot_no' and vill_townprt_code = '$loc->vill_townprt_code' and ord_type_code = '03' and "
                        . "operation = 'B'";
                $cases1 = $this->db->query($q)->row()->count;
            } elseif ($order_type_code == 'FP') {
                
            } elseif ($order_type_code == 'OP') {
                
            }

            if ($cases1 > 0) {
                $main = array
                    (
                    'dist_code' => $dist_code,
                    'subdiv_code' => $loc->subdiv_code,
                    'cir_code' => $loc->cir_code,
                    'mouza_pargona_code' => $loc->mouza_pargona_code,
                    'lot_no' => $loc->lot_no,
                    'vill_townprt_code' => $loc->vill_townprt_code,
                    'dist_name' => $districtdata,
                    'subdiv_name' => $subdivdata,
                    'cir_name' => $circledata,
                    'mouza_pargona_name' => $mouzadata,
                    'lot_name' => $lotdata,
                    'vill_townprt_name' => $villdata,
                    'order_type_code' => $order_type_code,
                    'total_count' => $cases1,
                        //$report_label = 'Field Mutation';
                );
                $result[] = $main;
            }
        }
        $data['result'] = $result;

        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/BackEntryConversion/GenerateMaxReportVill', $data);
        // $this->load->view('../views/footer');
        $data['_view'] = 'BackEntryConversion/GenerateMaxReportVill';
        $this->load->view('layouts/main',$data);

    }

    public function FinalReport() {
		  $db=  $this->session->userdata('db');
        $user_code = $this->session->userdata('user_code');
        $district_code = $this->input->get('dist_code');
        $subdivision_code = $this->input->get('subdiv_code');
        $circlecode = $this->input->get('cir_code');
        $mouzacode = $this->input->get('mouza_pargona_code');
        $lot_code = $this->input->get('lot_no');
        $village_code = $this->input->get('vill_townprt_code');
        $order_type_code = $this->input->get('order_type');

        $this->load->helper('html');
        $this->load->view('../views/header');
        if ($order_type_code == 'FM') {
            $chithainfo1['data'] = $this->getCol8($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code);
            $this->load->view('../views/BackEntryConversion/Reportcol8', $chithainfo1);
        } elseif ($order_type_code == 'OM') {
            $chithainfo1['data'] = $this->getCol31Remarks($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code);
            $this->load->view('../views/BackEntryConversion/Reportcol31', $chithainfo1);
        }
        $this->load->view('../views/footer');
    }

    public function getCol8($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code) {
		  $db=  $this->session->userdata('db');
        $user_code = $this->session->userdata('user_code');

        $innerquery4 = "select col8order_cron_no,order_type_code,nature_trans_code,mut_land_area_b,mut_land_area_k,mut_land_area_lc,user_code,rajah_adalat,lm_code,case_no,"
                . "co_ord_date,deed_reg_no,deed_value,deed_date,operation,co_code,dag_no from    Chitha_col8_order where dist_code='$district_code' and subdiv_code='$subdivision_code' "
                . "and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (operation='B' ) ";

        $innerdata4 = $this->db->query($innerquery4)->result();
        //var_dump($innerdata4);
        // this is the start to col8 order details
        foreach ($innerdata4 as $col8OrderDetails) {
            $col8order_cron_no = $col8OrderDetails->col8order_cron_no;
            $order_type_code = $col8OrderDetails->order_type_code;
            $nature_trans_code = $col8OrderDetails->nature_trans_code;
            $mut_land_area_b = $col8OrderDetails->mut_land_area_b;
            $mut_land_area_k = $col8OrderDetails->mut_land_area_k;
            $mut_land_area_lc = $col8OrderDetails->mut_land_area_lc;
            $user_code = $col8OrderDetails->user_code;
            $rajah_adalat = $col8OrderDetails->rajah_adalat;
            $lm_code = $col8OrderDetails->lm_code;
            $case_no = $col8OrderDetails->case_no;
            $co_ord_date = $col8OrderDetails->co_ord_date;
            $deed_value = $col8OrderDetails->deed_value;
            $deed_reg_no = $col8OrderDetails->deed_reg_no;
            $deed_date = $col8OrderDetails->deed_date;
            $co_code = $col8OrderDetails->co_code;
            $operation = $col8OrderDetails->operation;
            $dag_no = $col8OrderDetails->dag_no;

            $inplace_of_name = "";
            $inplaceof_alongwith = "";
            $occupant_name = "";
            $occupant_fmh_name = "";
            $occupant_fmh_flag = "";
            $new_patta_no = "";
            $new_dag_no = "";
            $hus_wife = "";
            $nature_trans_desc = "";
            $lm_name = "";
            $innerquery5 = "select order_type from    master_field_mut_type where  order_type_code = '$order_type_code' ";
            //////echo $innerquery5;
            $innerdata5 = $this->db->query($innerquery5)->row();
            $ordertype = $innerdata5->order_type;


            $innerquery6 = "select inplace_of_name,inplaceof_alongwith from    chitha_col8_inplace where dist_code='$district_code' and subdiv_code='$subdivision_code' and "
                    . "cir_code='$circlecode' and  mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and Dag_no='$dag_no' and "
                    . "Col8Order_cron_no='$col8order_cron_no' ORDER BY inplace_of_id";

            $innerdata6 = $this->db->query($innerquery6)->result();
            $inplace_data = array();

            $innerquery7 = "select trans_desc_as from    nature_trans_code where trans_code = '$nature_trans_code'";
            foreach ($innerdata6 as $inplace) {
                $inplace_data[] = array(
                    'inplace_of_name' => $inplace->inplace_of_name,
                    'inplaceof_alongwith' => $inplace->inplaceof_alongwith,
                );
            }

            $occup_data = array();
            $innerquery8 = "select occupant_name,occupant_fmh_name,occupant_fmh_flag,new_patta_no,new_dag_no,hus_wife from    chitha_col8_occup where dist_code='$district_code' "
                    . "and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
                    . "and (dag_no='$dag_no' or new_dag_no='$dag_no')  and Col8Order_cron_no='$col8order_cron_no'   ORDER BY occupant_id";
            $innerdata8 = $this->db->query($innerquery8)->result();

            foreach ($innerdata8 as $occupant) {
                $occupant_name = $occupant->occupant_name;
                $occupant_fmh_name = $occupant->occupant_fmh_name;
                $occupant_fmh_flag = $occupant->occupant_fmh_flag;
                $new_patta_no = trim($occupant->new_patta_no);
                $new_dag_no = $occupant->new_dag_no;
                $hus_wife = $occupant->hus_wife;

                $innerquery9 = "select guard_rel_desc_as from    master_guard_rel where guard_rel = '$occupant_fmh_flag'";
                $innerdata9 = $this->db->query($innerquery9)->result();
                $guard_rel_desc_as = "";
                foreach ($innerdata9 as $guard_rel) {
                    $guard_rel_desc_as = $guard_rel->guard_rel_desc_as;
                }
                $occup_data[] = array(
                    'occupant_name' => $occupant->occupant_name,
                    'occupant_fmh_name' => $occupant->occupant_fmh_name,
                    'occupant_fmh_flag' => $occupant->occupant_fmh_flag,
                    'new_patta_no' => trim($occupant->new_patta_no),
                    'new_dag_no' => $occupant->new_dag_no,
                    'hus_wife' => $occupant->hus_wife,
                    'guard_rel_desc_as' => $guard_rel_desc_as
                );
            }

            $innerquery10 = "select lm_name from    lm_code  where dist_code='$district_code' "
                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                    . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code = '$lm_code' ";
            //echo $innerquery10;
            $innerdata10 = $this->db->query($innerquery10)->result();


            foreach ($innerdata10 as $lm) {
                $lm_name = $lm->lm_name;
            }

            $innerquery11 = "select username,status from    users where dist_code='$district_code' "
                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code='$user_code'";

            $innerdata11 = $this->db->query($innerquery11)->result();
            foreach ($innerdata11 as $users) {
                $username = $users->username;
                $status = $users->status;
            }

            if ($order_type_code == '03') {
                $innerquery12 = "select * from    field_mut_objection where objection_case_no='$case_no' "; //and  obj_flag is not null and chitha_correct_yn='1' ";
                $innerdata12 = $this->db->query($innerquery12)->result();

                foreach ($innerdata12 as $objection) {
                    //var_dump($objection);
                    $q = "select col8order_cron_no,dag_no from    chitha_col8_order where case_no='$objection->prev_fm_ca_no' ";
                    $col8_cronNo = $this->db->query($q)->row();
                    $q = "select occupant_name from    chitha_col8_occup where dist_code='$district_code' and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                            . "mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and col8order_cron_no='$col8_cronNo->col8order_cron_no' "
                            . "and dag_no='$col8_cronNo->dag_no'  ";
                    $result = $this->db->query($q)->result();
                    $fname = "";
                    foreach ($result as $name) {
                        $fname = $fname . $name->occupant_name . ",";
                    }
                    $data1[$dag_no]['objection'][] = array(
                        'mut_type' => $objection->mut_type,
                        'regist_date' => $objection->regist_date,
                        'objection_case_no' => $objection->objection_case_no,
                        'prev_fm_ca_no' => $objection->prev_fm_ca_no,
                        'submission_date' => $objection->entry_date,
                        'obj_name' => $objection->obj_name,
                        'co_id' => $objection->co_id,
                        'occupant' => $fname
                    );
                }
            }
            $innerquery13 = "select * from    field_mut_petitioner where case_no='$case_no' ";
            $innerdata13 = $this->db->query($innerquery13)->result();

            if ($order_type_code == '01') {

                $innerquery14 = " select deed_reg_no,deed_value,deed_date from    chitha_col8_order
                      where Order_type_code='$order_type_code' and dag_no='$dag_no' and case_no='$case_no'";
                //echo $innerquery14;	
                $innerdata14 = $this->db->query($innerquery14)->result();
                foreach ($innerdata14 as $deedinf) {
                    $deed_reg_no = $deedinf->deed_reg_no;
                    $deed_value = $deedinf->deed_value;
                    $deed_date = $deedinf->deed_date;
                }
            }

            $co_name = "select username from    users where dist_code='$district_code' and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code='$user_code'";
            $co_name = $this->db->query($co_name)->result();
            foreach ($co_name as $co) {
                $co_username = $co->username;
            }

            ////echo $col8OrderDetails->co_ord_date;
            if ($order_type_code != '03') {
                $data1[$dag_no]['col8'][] = array(
                    'dist_code' => $district_code,
                    'subdiv_code' => $subdivision_code,
                    'cir_code' => $circlecode,
                    'mouza_pargona_code' => $mouzacode,
                    'lot_no' => $lot_code,
                    'vill_townprt_code' => $village_code,
                    'dag_no' => $col8OrderDetails->dag_no,
                    'co_ord_date' => $col8OrderDetails->co_ord_date,
                    'order_type_code' => $col8OrderDetails->order_type_code,
                    'case_no' => $col8OrderDetails->case_no,
                    'col8order_cron_no' => $col8OrderDetails->col8order_cron_no,
                    'order_type' => $ordertype,
                    'nature_trans_code' => $col8OrderDetails->nature_trans_code,
                    'mut_land_area_b' => $col8OrderDetails->mut_land_area_b,
                    'mut_land_area_k' => $col8OrderDetails->mut_land_area_k,
                    'mut_land_area_lc' => $col8OrderDetails->mut_land_area_lc,
                    'inplace' => $inplace_data,
                    'occup' => $occup_data,
                    'rajah' => $rajah_adalat,
                    'deed_value' => $deed_value,
                    'deed_reg_no' => $deed_reg_no,
                    'deed_date' => $deed_date,
                    'lm_name' => $lm_name,
                    'username' => $username,
                    'co_name' => $co_username,
                    'operation' => $operation
                );
            }
        }
        return $data1;
    }

    public function getCol31Remarks($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code) {
		  $db=  $this->session->userdata('db');
        $data1 = array();
        $remark_type_code = '01';

        $district = $this->db->query("select dag_no,rmk_type_hist_no from    chitha_rmk_ordbasic where  dist_code='$district_code' and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                . "mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (operation='B' ) order by ord_cron_no");
        $outerdata = $district->result();

        foreach ($outerdata as $chithadetails) {
            $d = $this->getCol31($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $chithadetails->dag_no, $remark_type_code, $chithadetails->rmk_type_hist_no);
            $data1[$chithadetails->dag_no]['col31'][] = $d;
        }
        return $data1;
    }

    public function getCol31($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no, $rmk_type_code, $rmk_type_hist_no) {
        $db=  $this->session->userdata('db');
	  $data[] = array();
        $innerquery26 = "select  dag_no,rmk_type_code,rmk_type_hist_no from    chitha_rmk_gen where dist_code='$district_code' and subdiv_code='$subdivision_code' and "
                . "cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no ='$dag_no') and "
                . "rmk_type_hist_no = '$rmk_type_hist_no' order by rmk_type_hist_no";

        $innerdata26 = $this->db->query($innerquery26)->result();

        foreach ($innerdata26 as $rmkGen) {
            $dagnoRemarkgen = $rmkGen->dag_no;
            $rmk_type_code = $rmkGen->rmk_type_code;
            $rmk_type_hist_no = $rmkGen->rmk_type_hist_no;

            if ($rmk_type_code == "01") {

                $innerquery27 = " select dag_no,ord_date,ord_no,case_no,ord_passby_desig,lm_code,co_code,ord_type_code,"
                        . " ord_ref_let_no,co_ord_date,new_dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,user_code,operation  "
                        . " from    chitha_rmk_ordbasic where  dist_code='$district_code' "
                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                        . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code'"
                        . " and (dag_no ='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no' order by ord_cron_no ";

                $innerdata27 = $this->db->query($innerquery27)->result();

                foreach ($innerdata27 as $chitharmk_ord_basic) {
                    $dag_no_orderbasic = $chitharmk_ord_basic->ord_date;
                    $order_date = $chitharmk_ord_basic->ord_date;
                    $ord_no = $chitharmk_ord_basic->ord_no;
                    $case_no = $chitharmk_ord_basic->case_no;
                    $ord_passby_desig = $chitharmk_ord_basic->ord_passby_desig;
                    $lm_code = $chitharmk_ord_basic->lm_code;
                    $co_code = $chitharmk_ord_basic->co_code;
                    $user_code = $chitharmk_ord_basic->user_code;
                    $operation = $chitharmk_ord_basic->operation;
                    $order_passby_designation = $chitharmk_ord_basic->ord_passby_desig;
                    $ord_type_code = $chitharmk_ord_basic->ord_type_code;
                    $ord_ref_let_no = $chitharmk_ord_basic->ord_ref_let_no;
                    $co_ord_date = $chitharmk_ord_basic->co_ord_date;
                    $new_dag_no = $chitharmk_ord_basic->new_dag_no;
                    $m_dag_area_b = $chitharmk_ord_basic->m_dag_area_b;
                    $m_dag_area_k = $chitharmk_ord_basic->m_dag_area_k;
                    $m_dag_area_lc = $chitharmk_ord_basic->m_dag_area_lc;


                    $get_designation = $this->db->query("select user_desig_as as designation from    master_user_designation where user_desig_code = '$order_passby_designation'")->row()->designation;

                    if ($ord_type_code == "03") {

                        $innerquery40 = "SELECT inplace_of_name FROM chitha_rmk_inplace_of  where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no'  ";

                        $innerdata40 = $this->db->query($innerquery40)->result();


                        $by_right_of = "";
                        $infavor_of_corrected_name = "";
                        $infavor_of_name = "";
                        $reg_deal_no = "";
                        $reg_date = "";
                        $new_dag_no = "";
                        $new_patta_no = "";
                        $inplace_of_name = "";
                        $alongwithname = "";
                        $lm_name = "";
                        $status = "";
                        $username = "";
                        foreach ($innerdata40 as $inplace) {
                            $inplace_of_name = $inplace->inplace_of_name;
                        }

                        $innerquery41 = "select alongwith_name  FROM chitha_rmk_alongwith where  dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no'  ";

                        $innerdata41 = $this->db->query($innerquery41)->result();
                        $alongwitharray = array();
                        foreach ($innerdata41 as $alongwith) {

                            $alongwithname = $alongwith->alongwith_name;
                            $alongwitharray[] = array(
                                'alongwithname' => $alongwithname
                            );
                        }

                        $innerquery41 = "select inplace_of_name  FROM chitha_rmk_inplace_of where  dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no'  ";

                        $innerdata46 = $this->db->query($innerquery41)->result();
                        $inplaceofarray = array();
                        foreach ($innerdata46 as $inplace) {

                            $inplace_of_name = $inplace->inplace_of_name;
                            $inplaceofarray[] = array(
                                'inplace_of_name' => $inplace_of_name
                            );
                        }


                        $innerquery42 = "select by_right_of,infavor_of_corrected_name,infavor_of_name,reg_deal_no,reg_date,new_dag_no,"
                                . " new_patta_no  from    chitha_rmk_infavor_of where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and "
                                . " vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' "
                                . " and rmk_type_hist_no='$rmk_type_hist_no'"
                                . " and ord_no= '$ord_no' ";
                        //echo $innerquery42;
                        $innerdata42 = $this->db->query($innerquery42)->result();
                        $infav = array();
                        foreach ($innerdata42 as $infav_of) {
                            $by_right_of = $infav_of->by_right_of;
                            $infavor_of_corrected_name = $infav_of->infavor_of_corrected_name;
                            $infavor_of_name = $infav_of->infavor_of_name;
                            $reg_deal_no = $infav_of->reg_deal_no;
                            $reg_date = $infav_of->reg_date;

                            $new_dag_no = $infav_of->new_dag_no;
                            $new_patta_no = trim($infav_of->new_patta_no);
                            $infav[] = array(
                                'infavor_of_corrected_name' => $infav_of->infavor_of_corrected_name,
                                'infavor_of_name' => $infav_of->infavor_of_name
                            );
                        }

                        //infav query bracket

                        $innerquery43 = "select lm_name FROM lm_code where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$chitharmk_ord_basic->lm_code'";
                        $innerdata43 = $this->db->query($innerquery43)->result();

                        foreach ($innerdata43 as $lminfo) {
                            $lm_name = $lminfo->lm_name;
                        }

                        $innerquery44 = " select username,status FROM users where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";
                        $innerdata44 = $this->db->query($innerquery44)->result();
                        foreach ($innerdata44 as $userinfo) {
                            $username = $userinfo->username;
                            $status = $userinfo->status;
                        }

                        $innerquery45 = "select m_dag_area_b,m_dag_area_k,m_dag_area_lc from    chitha_rmk_ordbasic "
                                . " where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and ord_no='$ord_no'";
                        $m_area = $this->db->query($innerquery45)->row();
                        $m_area_b = $m_area->m_dag_area_b;
                        $m_area_k = $m_area->m_dag_area_k;
                        $m_area_lc = $m_area->m_dag_area_lc;

                        $co_name = "select username from    users where dist_code='$district_code' and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code='$user_code'";
                        $co_name = $this->db->query($co_name)->result();
                        foreach ($co_name as $co) {
                            $co_username = $co->username;
                        }

                        $data[] = array(
                            'dist_code' => $district_code,
                            'subdiv_code' => $subdivision_code,
                            'cir_code' => $circlecode,
                            'mouza_pargona_code' => $mouzacode,
                            'lot_no' => $lot_code,
                            'vill_townprt_code' => $village_code,
                            'dag_no' => $dag_no,
                            'by_right_of' => $by_right_of,
                            'infav' => $infav,
                            'reg_deal_no' => $reg_deal_no,
                            'reg_date' => $reg_date,
                            'new_dag_no' => $new_dag_no,
                            'new_patta_no' => $new_patta_no,
                            'username' => $username,
                            'status' => $status,
                            'lm_name' => $lm_name,
                            'alongwith_name' => $alongwitharray,
                            'inplace_of_name' => $inplaceofarray,
                            'bigha' => $m_area_b,
                            'katha' => $m_area_k,
                            'lessa' => $m_area_lc,
                            'remark_type_code' => $rmk_type_code,
                            'ord_type_code' => $ord_type_code,
                            'ord_no' => $ord_no,
                            'order_date' => $order_date,
                            'co_name' => $co_username,
                            'operation' => $operation
                        );
                    }
                }
            }
        }
        return $data;
    }

}
