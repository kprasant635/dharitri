<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MutationBacklog extends CI_Controller {

    var $user_code;
    var $config = array(
    );
    var $language;

    public function recordOrder() {
		$db=  $this->session->userdata('db');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $new_dag = $this->input->post('new_dag');
            $new_patta = $this->input->post('new_patta');
            $order = $this->input->post('order');
            //echo $new_dag;
            //echo $new_patta;
            $this->session->set_userdata(array(
                'new_dag' => $new_dag,
                'new_patta' => $new_patta,
                'order' => $order,
            ));
            redirect(base_url() . "index.php/mutationbacklog/saveall");
        } else {
            $fmb = $this->session->userdata('fmb');
            $dag_det = $this->session->userdata('dag_det');

            $appdet = $this->session->userdata('appdet');
            $patdet = $this->session->userdata('patdet');
            $mut = $this->session->userdata('mut_type');
            $dist_code = $fmb['dist_code'];
            $subdiv_code = $fmb['subdiv_code'];
            $cir_code = $fmb['cir_code'];
            $mouza_pargona_code = $fmb['mouza_pargona_code'];
            $lot_no = $fmb['lot_no'];
            $vill_townprt_code = $fmb['vill_townprt_code'];
            $patta_no = trim($dag_det[0]['patta_no']);
            $patta_type_code = $dag_det[0]['patta_type_code'];
            $query = "select dag_no as dag from    chitha_basic  where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? "
                    . " and lot_no=? and  vill_townprt_code=? and patta_type_code=? order by dag_no_int desc";
            $new_dag = $this->db->query($query, array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_type_code))->row()->dag + 1;
            $patta_nos = $this->db->query("select patta_no from    chitha_basic where dist_code = '$dist_code'"
                            . " and subdiv_code='$subdiv_code' and cir_code = '$cir_code'"
                            . " and mouza_pargona_code='$mouza_pargona_code'"
                            . " and lot_no='$lot_no' and vill_townprt_code = '$vill_townprt_code'")->result();

            $pattas = array();

            foreach ($patta_nos as $p) {
                $pattas[] = trim($p->patta_no);
            }
            $new_patta = max($pattas) + 1;
            $data['new_dag'] = $new_dag;
            $data['new_patta'] = $new_patta;


            $this->load->view('../views/header');
            $this->load->view('../views/mutationbacklog/order', $data);
            $this->load->view('../views/footer');
        }
    }

    public function __construct() {
        parent::__construct();
        $this->user_code = $this->session->userdata('user_code');
        $this->load->model('mutation/mutationmodel');
        $this->load->helper(array('form', 'url', 'Language'));

        $this->load->library('form_validation');
    }

    public function index() {
        $this->load->helper('html');
        $this->load->view('../views/header');
        $this->load->view('../views/lm_mutation');
        $this->load->view('../views/footer');
    }

    public function mutation($category) {
		$db=  $this->session->userdata('db');
        $this->session->set_userdata(array('order_category' => $category));
        $this->load->helper('html');
        $this->load->view('../views/header');
        //$this->load->view('menu/menu4');
        $this->session->unset_userdata('appdet');
        $this->session->unset_userdata('patdet');
        $this->session->unset_userdata('fmb');

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $this->session->set_userdata(array('end' => false));
        $district['d'] = $dist_code;
        $district['s'] = $subdiv_code;
        $district['c'] = $cir_code;
        $mouzas = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);
        $district['mouzas'] = $mouzas;


        $this->load->view('../views/mutationbacklog/select_location', $district);
        $this->load->view('../views/footer');
    }

    public function getUserDesignation($user_code) {
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $q = "select user_desig_code from    users where user_code='$user_code'";
        $result = $this->db->query($q)->row()->user_desig_code;
        $assamese = $this->db->query("select user_desig_as from    master_user_designation where user_desig_code='$result'")->row()->user_desig_as;
        $json = array(
            'user_desig_code' => $assamese,
            'user_code' => $result
        );
        echo json_encode($json);
    }

    public function isMultiple() {
        $this->load->helper('html');
        $this->load->view('../views/header');
        //$this->load->view('menu/menu4');
        $this->load->view('../views/MutationBacklog/ismultiple');
        $this->load->view('../views/footer');
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $ismultiple = false;
            if ($this->input->post('ismultiple') == 'true') {
                $ismultiple = true;
            }
            $this->session->set_userdata(array('ismultiple' => $ismultiple));
            $mutType = $this->session->userdata('fmb');
            //var_dump($mutType);
            $mutType = $mutType['mut_type'];
            // echo $mutType;
            if ($mutType == '02') {
                redirect(base_url() . "index.php/MutationBacklog/mutationlandarea?mut_type=02");
            } else {
                redirect(base_url() . "index.php/MutationBacklog/applicantdetails");
            }
        }
    }

    public function mutationType() {
		$db=  $this->session->userdata('db');
        //var_dump($this->session->all_userdata());
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('circle_code');
        $lot_no = $this->input->post('lot_no');
        $vill_code = $this->input->post('vill_code');
        $mouza_pargona_code = $this->input->post('mouza_code');
        $this->form_validation->set_rules('vill_code', 'Username', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->mutation();
            return;
        }

        ////var_dump($mouza_pargona_code);
        $locationData = array(
            'vill_code' => $vill_code,
			'dist_code' => $this->input->post('dist_code'),
			'subdiv_code' => $this->input->post('subdiv_code'),
			'cir_code' => $this->input->post('circle_code'),
			'lot_no' => $this->input->post('lot_no'),
			'mouza_pargona_code' => $this->input->post('mouza_code')
       
        );
        ////var_dump($locationData);
        $this->session->set_userdata($locationData);

        $mutation['type'] = $this->mutationmodel->getMutationType();

        $q = "select * from    loginuser_table where dist_code = '$dist_code' and subdiv_code='$subdiv_code' and  cir_code='$cir_code' and dis_enb_option='E' and priv='adm' ";
        $users = $this->db->query($q)->result();
        foreach ($users as $u) {
            $query_string = "dist_code = '$dist_code' and subdiv_code='$subdiv_code' and"
                    . " cir_code = '$cir_code' and user_code='$u->user_code' ";
            $mutation['user'] = $this->db->query("select * from    users where " . $query_string)->result();
        }
        $this->load->view('../views/header');
        //$this->load->view('menu/menu4');
        $this->load->view('../views/MutationBacklog/mutationtype', $mutation);
        $this->load->view('../views/footer');
    }

    public function mutationLandArea() {
        //var_dump($this->session->all_userdata());
        $this->load->model('patta/PattaModel');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type = $this->session->userdata('patta_type');
        $case_no = $this->session->userdata('case_no');
        ////var_dump($this->utilityclass->getLocationFromSession());

        $dags['dags'] = $this->PattaModel->getDagsByPattaNoPattaType($patta_no, $patta_type, $case_no)->result();
        //var_dump($dags);
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
        $this->load->view('../views/header');
        //$this->load->view('menu/menu4');
        $this->load->view('../views/MutationBacklog/mutationlandarea', $dags);
        $this->load->view('../views/footer');
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

    public function getDagsByPattaNoJSON() {
        $this->load->model('patta/PattaModel');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type = $this->session->userdata('patta_type');
        //$case_no = $this->session->userdata('case_no');

        $dags = $this->PattaModel->getDagsByPattaNo($patta_no, $patta_type)->result();
        $json = array();
        foreach ($dags as $object) {
            $json[] = array('dag_no' => $object->dag_no);
        }
        echo json_encode($json);
    }

    public function getPattadarFilteredJSON() {
        $this->load->model('patta/PattaModel');
        $this->PattaModel->getPattadarFiltered();
    }

    public function getSubdivJson($distcode) {
        $data = $this->mutationmodel->getSubDivJSON($distcode);
        $json = array();
        foreach ($data as $object) {
            $json[] = array('loc_name' => $object->loc_name, 'subdiv_code' => $object->subdiv_code);
        }
        echo json_encode($json);
    }

    public function getCirCodeJson($distcode, $subdivcode) {
        $data = $this->mutationmodel->getCirCodeJSON($distcode, $subdivcode);

        $json = array();
        foreach ($data as $object) {

            $json[] = array('loc_name' => $object->loc_name, 'cir_code' => $object->cir_code);
        }
        echo json_encode($json);
    }

    public function getMouzaJson($distcode, $subdivcode, $circode) {
        $data = $this->mutationmodel->getMouzaJSON($distcode, $subdivcode, $circode);

        $json = array();
        foreach ($data as $object) {

            $json[] = array('loc_name' => $object->loc_name, 'mouza_pargona_code' => $object->mouza_pargona_code);
        }
        echo json_encode($json);
    }

    public function getLotNoJson($distcode, $subdivcode, $circode, $mouzacode) {
        $data = $this->mutationmodel->getLotNoJson($distcode, $subdivcode, $circode, $mouzacode);
        $json = array();

        foreach ($data as $object) {
            $json[] = array('loc_name' => $object->lot_no, 'lot_no' => $object->lot_no);
        }
        echo json_encode($json);
    }

    public function getVillageCodeJSON($distcode, $subdivcode, $circode, $mouzacode, $lotno) {
        $data = $this->mutationmodel->getVillageCodeJSON($distcode, $subdivcode, $circode, $mouzacode, $lotno);
        $json = array();

        foreach ($data as $object) {
            $json[] = array('loc_name' => $object->loc_name, 'vill_townprt_code' => $object->vill_townprt_code);
        }
        echo json_encode($json);
    }

    public function getPattanoJSON($distCode, $subdivcode, $circode, $mouzacode, $lotno, $villagecode, $patta_code) {
        $data = $this->mutationmodel->getPattanoJSON($distCode, $subdivcode, $circode, $mouzacode, $lotno, $villagecode, $patta_code);
        $json = array();

        foreach ($data as $object) {
            $json[] = array('patta_code' => trim($object->patta_no), 'patta_no' => trim($object->patta_no));
        }
        echo json_encode($json);
    }

    public function getMutationTypeJSON() {
        $data = $this->mutationmodel->getMutationType();
        $json = array();
        foreach ($data as $object) {
            $json[] = array('order_type_code' => $object->order_type_code, 'order_type' => $object->order_type);
        }
        echo json_encode($json);
    }

    public function getTransferTypeJSON() {
        $data = $this->mutationmodel->getTransferType();
        $json = array();
        foreach ($data as $object) {
            $json[] = array('trans_code' => $object->trans_code, 'trans_desc_as' => $object->trans_desc_as);
        }
        echo json_encode($json);
    }

    public function getLandAreaJSON($dag_no) {
        $landarea = $this->mutationmodel->getLandArea($dag_no);
        echo json_encode($landarea);
    }

    public function getMutatedLandAreaJSON() {
        $case_no = $this->session->userdata('case_no');
        $mutatedlandArea = array(
            'bigha' => 0,
            'katha' => 0,
            'lessa' => 0
        );


        echo json_encode($mutatedlandArea);
    }

    public function saveFieldMutatonBasic() {
       $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');

        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');

        $mut_type = $this->input->post('mutation_type');
        $patta_no = trim($this->input->post('patta_no'));
        $this->session->set_userdata(array('patta_no' => $patta_no));

        $this->session->set_userdata(array('mut_type' => $mut_type));

        $rajah_adalat = $this->input->post('rajah_adalat');
        $trans_code = $this->input->post('transfer_type');
        $add_of_name = $this->input->post('add_of_name');
        $possesion_yn = $this->input->post('possession_yn');
        $dispute_yn = $this->input->post('dispute_yn');
        $operation = $this->input->post('operation');
        $deed_value = $this->input->post('reg_deed_value');
        $reg_deed_date = date('Y-m-d', strtotime($this->input->post('reg_deed_date')));
        $add_of_desig = $this->input->post('add_of_desig');
        $reg_deed_no = $this->input->post('reg_deed_no');

        $patta_type = $this->input->post('patta_type');

        date_default_timezone_set('Asia/Kolkata');

        $report_date = $timestamp = date('Y-m-d G:i:s');
        $date_entry = $timestamp = date('Y-m-d G:i:s');

        $petition_no = $this->db->query('select max(petition_no) as petition_no from    field_mut_basic where petition_no is not null limit 1')->row()->petition_no;

        if ($petition_no == null) {
            $petition_no = 1;
        } else {
            $petition_no+=1;
        }
        $financialyeardate = (date('m') < '04') ? date('Y', strtotime('-1 year')) . "-" . date('Y') : date('Y') . "-" . date('Y', strtotime('+1 year'));
        if ($mut_type == '01')
            $case_no = $petition_no . "/" . $financialyeardate . "/FMUT";
        else if ($mut_type == '02')
            $case_no = $petition_no . "/" . $financialyeardate . "/FPART";

        $this->session->set_userdata(array('case_no' => $case_no));
        $this->session->set_userdata(array('petition_no' => $petition_no));
        if ($deed_value == null) {
            $deed_value = 0;
        }
        $this->session->set_userdata(array('patta_no' => $patta_no, 'patta_type' => $patta_type,
            'deed_reg_no' => $reg_deed_no, 'deed_value' => $deed_value, 'deed_date' => $reg_deed_date));

        $data = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'mut_type' => $mut_type,
            'rajah_adalat' => $rajah_adalat,
            'trans_code' => $trans_code,
            'add_off_name' => $add_of_name,
            'add_off_desig' => $add_of_desig,
            'possession_yn' => $possesion_yn,
            'dispute_yn' => $dispute_yn,
            'operation' => $operation,
            'deed_value' => $deed_value,
            'reg_deed_date' => $reg_deed_date,
            'add_off_desig' => $add_of_desig,
            'report_date' => $report_date,
            'date_entry' => $date_entry,
            'reg_deed_no' => $reg_deed_no,
            'year_no' => date('Y'),
            'petition_no' => $petition_no,
            'case_no' => $case_no,
            'user_code' => $this->user_code,
            'operation' => 'E'
        );
        ////var_dump($data);
        $this->session->set_userdata('fmb', $data);
//        if ($this->db->insert('field_mut_basic', $data)) {
//            $this->db->trans_complete();

        redirect(base_url() . "index.php/MutationBacklog/isMultiple");
//        }
    }

    public function applicantDetails() {
        ////var_dump($this->session->all_userdata());
        $this->load->view('../views/header');
        //$this->load->view('menu/menu4');
        $this->load->model('relation/relationmodel');
        $this->load->model('patta/pattamodel');
        //  var_dump($this->session->userdata('ismultiple'));
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

        $this->load->view('../views/MutationBacklog/applicantdetails', $data);
        $this->load->view('../views/footer');
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
        $location = $this->utilityclass->getLocationFromSession();
        $merged = array_merge($data, $location);

        $case_no = $this->session->userdata('case_no');
        $petition_no = $this->session->userdata('petition_no');

        $petition = $this->db->query("select  count(pet_id) as pet_id from    field_mut_petitioner where pet_id is not null "
                        . " and case_no='$case_no' limit 1")->result();
        $pet_id = $petition[0]->pet_id + 1;

        $report_date = $timestamp = date('Y-m-d G:i:s');
        $date_entry = $timestamp = date('Y-m-d G:i:s');

        $otherdata = array(
            'case_no' => $case_no,
            'petition_no' => $petition_no,
            'year_no' => date('Y'),
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


        //if ($this->db->insert('field_mut_petitioner', $merged)) {
        //$this->db->trans_complete();
        if ($husband_wife == true)
            redirect(base_url() . "index.php/MutationBacklog/applicantdetails?hus_wife=$husband_wife");
        else
        // redirect(base_url() . "index.php/MutationBacklog/applicantdetails?next=true");
            redirect(base_url() . "index.php/MutationBacklog/addmoreapplicat");
        //}
    }

    public function addmoreapplicat() {
        $this->load->view('../views/header');
        //$this->load->view('menu/menu4');
        $this->load->view('../views/MutationBacklog/addmoreapplicant');
        $this->load->view('../views/footer');
    }

    public function saveMutationDagDetails() {
        $location = $this->utilityclass->getLocationFromSession();
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
        $year_no = date('Y');


        $data = array();
        foreach ($_POST as $k => $v) {
            $data[$k] = $v;
        }

        $dag_no = $data['dag_no'];
        $this->session->set_userdata(array('dag_no' => $dag_no));

        $other = array('case_no' => $case_no, 'petition_no' => $petition_no,
            'patta_no' => $patta_no, 'patta_type_code' => $patta_type_code,
            'user_code' => $user_code, 'date_entry' => $date_entry, 'operation' => $operation,
            'deed_date' => $deed_date, 'deed_value' => $deed_value, 'deed_reg_no' => $deed_reg_no, 'year_no' => $year_no
        );
        $merged = array_merge($other, $location, $data);
        if (!$this->session->userdata('dag_det')) {
            $this->session->set_userdata('dag_det', array());
            $dagdet = $this->session->userdata('dag_det');
            $dagdet[] = $merged;

            $this->session->set_userdata('dag_det', $dagdet);
        } else {
            $dagdet = $this->session->userdata('dag_det');
            $dagdet[] = $merged;
            $this->session->set_userdata('dag_det', $dagdet);
        }
        redirect(base_url() . "index.php/MutationBacklog/pattadardetails");
    }

    public function pattadarDetails() {
$db=  $this->session->userdata('db');
        if ($this->input->get('inc')) {
            if (!$this->session->userdata('start')) {
                $this->session->set_userdata(array('start' => 0));
            }
            $start = $this->session->userdata('start');
            $start++;
            $this->session->set_userdata(array('start' => $start));
        } else {
            
        }
        $dags = $this->session->userdata('dag_det');

        $in = array();
        foreach ($dags as $d) {
            $in[] = $d['dag_no'];
        }
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
        $size = sizeof($this->session->userdata('dag_det'));
        if ($this->session->userdata('start') >= $size) {
            $data['dag'] = -1;
            $this->load->view('../views/header');
            $fmb = $this->session->userdata('fmb');
            $dag_det = $this->session->userdata('dag_det');

            $appdet = $this->session->userdata('appdet');
            $patdet = $this->session->userdata('patdet');
            $mut = $this->session->userdata('mut_type');
            $dist_code = $fmb['dist_code'];
            $subdiv_code = $fmb['subdiv_code'];
            $cir_code = $fmb['cir_code'];
            $mouza_pargona_code = $fmb['mouza_pargona_code'];
            $lot_no = $fmb['lot_no'];
            $vill_townprt_code = $fmb['vill_townprt_code'];
            $patta_no = trim($dag_det[0]['patta_no']);
            $patta_type_code = $dag_det[0]['patta_type_code'];
            $query = "select dag_no as dag from    chitha_basic  where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? "
                    . " and lot_no=? and  vill_townprt_code=? and patta_type_code=? order by dag_no_int desc";
            $new_dag = $this->db->query($query, array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_type_code))->row()->dag + 1;
            $patta_nos = $this->db->query("select patta_no from    chitha_basic where dist_code = '$dist_code'"
                            . " and subdiv_code='$subdiv_code' and cir_code = '$cir_code'"
                            . " and mouza_pargona_code='$mouza_pargona_code'"
                            . " and lot_no='$lot_no' and vill_townprt_code = '$vill_townprt_code'")->result();

            $pattas = array();

            foreach ($patta_nos as $p) {
                $pattas[] = trim($p->patta_no);
            }
            $new_patta = max($pattas) + 1;
            $data['new_dag'] = $new_dag;
            $data['new_patta'] = $new_patta;
            $this->load->view('../views/header');
            $this->load->view('../views/mutationbacklog/recordorder', $data);
            $this->load->view('../views/footer');
            return;
        } else {
            $data['dag'] = $in[$this->session->userdata('start')];
        }



        if ($data['mut_type'] == '01') {
            $data['pattadars'] = $this->PattaModel->getPattadarFiltered($pattadar_cron_no, $in[$this->session->userdata('start')])->result();
        } else if ($data['mut_type'] == '02') {
            $data['pattadars'] = $this->PattaModel->getPattadarFilteredForPartition()->result();
        }

        $data['pattadar_cron_no'] = $pattadar_cron_no;
        $data['pattadar_next'] = $this->session->userdata('pattadar_next') ? true : false;


        if ($this->session->userdata('start') >= $size) {
            $data['dag'] = -1;
        } else {
            $data['dag'] = $in[$this->session->userdata('start')];
        }

        $this->load->view('../views/header');
        //$this->load->view('menu/menu4');
        $this->load->view('../views/MutationBacklog/pattadardetails', $data);
        $this->load->view('../views/footer');
    }

    public function savePattadarDetails() {
$db=  $this->session->userdata('db');
        $this->load->model('patta/pattamodel');
        $location = $this->utilityclass->getLocationFromSession();
        $case_no = $this->session->userdata('case_no');
        $dag_no = $this->input->post('current_dag');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type_code = $this->session->userdata('patta_type');
        $petition_no = $this->session->userdata('petition_no');
        $inc = $this->input->post('inc');
        foreach ($_POST as $k => $v) {
            $data[$k] = $v;
        }
        unset($data['inc']);
        $cron_no = $data['pdar_cron_no'] + 1;

        $date_entry = date('Y-m-d G:i:s');

        $user_code = $this->user_code;
        $operation = 'E';
        $striked_out = $this->input->post('striked_out');
        $year = date('Y');

        $pdar_name = $this->pattamodel->getPattadarNameById($data['pdar_name'], $dag_no)->result();

        $data['pdar_id'] = $data['pdar_name'];
        $data['pdar_name'] = $pdar_name[0]->pdar_name;

        ////var_dump($pdar_name);

        $other = array(
            'date_entry' => $date_entry,
            'user_code' => $user_code,
            'operation' => $operation,
            'striked_out' => $striked_out,
            'case_no' => $case_no,
            'patta_no' => $patta_no,
            'patta_type_code' => $patta_type_code,
            'petition_no' => $petition_no,
            'dag_no' => $dag_no,
            'year_no' => $year
        );

        $merged = array_merge($location, $data, $other);
        if (!$this->session->userdata('patdet')) {
            $this->session->set_userdata('patdet', array());
            $appdet = $this->session->userdata('patdet');
            $appdet[] = $merged;
            $this->session->set_userdata('patdet', $appdet);
        } else {
            $appdet = $this->session->userdata('patdet');
            $appdet[] = $merged;
            $this->session->set_userdata('patdet', $appdet);
        }
        $this->session->userdata('patdet');
        //if ($this->db->insert('field_mut_pattadar', $merged)) {

        $this->session->set_userdata(array('pattadar_next' => true));
        $size = sizeof($this->session->userdata('dag_det'));
        if ($this->session->userdata('start') >= $size) {
            redirect(base_url() . "index.php/MutationBacklog/pattadardetails?cron_no=$cron_no&e=true");
        } else {
            redirect(base_url() . "index.php/MutationBacklog/pattadardetails?cron_no=$cron_no");
        }
        //$this->db->trans_complete();
        //}
    }

    public function savePattadarDetails1() {

        $this->load->model('patta/pattamodel');
        $location = $this->utilityclass->getLocationFromSession();
        $case_no = $this->session->userdata('case_no');
        $dag_no = $this->input->post('current_dag');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type_code = $this->session->userdata('patta_type');
        $petition_no = $this->session->userdata('petition_no');

        foreach ($_POST as $k => $v) {
            $data[$k] = $v;
        }

        $cron_no = $data['pdar_cron_no'] + 1;
        echo $cron_no;
        $date_entry = date('Y-m-d G:i:s');

        $user_code = $this->user_code;
        $operation = 'E';
        $striked_out = $this->input->post('striked_out');
        $year = date('Y');

        $pdar_name = $this->pattamodel->getPattadarNameById($data['pdar_name'], $dag_no)->result();

        $data['pdar_id'] = $data['pdar_name'];
        $data['pdar_name'] = $pdar_name[0]->pdar_name;

        ////var_dump($pdar_name);

        $other = array(
            'date_entry' => $date_entry,
            'user_code' => $user_code,
            'operation' => $operation,
            'striked_out' => $striked_out,
            'case_no' => $case_no,
            'patta_no' => $patta_no,
            'patta_type_code' => $patta_type_code,
            'petition_no' => $petition_no,
            'dag_no' => $dag_no,
            'year_no' => $year
        );

        $merged = array_merge($location, $data, $other);
        if (!$this->session->userdata('patdet')) {
            $this->session->set_userdata('patdet', array());
            $appdet = $this->session->userdata('patdet');
            $appdet[] = $merged;
            $this->session->set_userdata('patdet', $appdet);
        } else {
            $appdet = $this->session->userdata('patdet');
            $appdet[] = $merged;
            $this->session->set_userdata('patdet', $appdet);
        }
        $this->session->userdata('patdet');
        //if ($this->db->insert('field_mut_pattadar', $merged)) {

        $this->session->set_userdata(array('pattadar_next' => true));
        $size = sizeof($this->session->userdata('dag_det'));
        if ($this->session->userdata('start') > ($size - 1)) {
            redirect(base_url() . "index.php/MutationBacklog/pattadardetails?cron_no=$cron_no&e=true");
        } else {
            redirect(base_url() . "index.php/MutationBacklog/pattadardetails?cron_no=$cron_no");
        }
        //$this->db->trans_complete();
        //}
    }

    public function getPattatypeJSON() {
        $data = $this->mutationmodel->getPattatypeJSON();

        $json = array();

        foreach ($data as $object) {

            $json[] = array('type_code' => $object->type_code, 'patta_type' => $object->patta_type);
        }
        echo json_encode($json);
    }

    public function getPattatypeByNoJSON($patta_no) {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $json = array();
        $data = $this->mutationmodel->getPattatypeByNoJSON($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no);
        foreach ($data as $object) {

            $json[] = array('type_code' => $object->type_code, 'patta_type' => $object->patta_type);
        }
        echo json_encode($json);
    }

    public function savePattadarForPartition() {
        $this->load->model('patta/pattamodel');
        $location = $this->utilityclass->getLocationFromSession();
        $case_no = $this->session->userdata('case_no');
        $dag_no = $this->session->userdata('dag_no');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type_code = $this->session->userdata('patta_type');
        $petition_no = $this->session->userdata('petition_no');
        /* loop over post array to get data from    the form */
        foreach ($_POST as $k => $v) {
            $data[$k] = $v;
        }
        $dag = $this->session->userdata('dag_det');
        $cron_no = $data['pdar_cron_no'] + 1;
        $user_code = $this->user_code;
        $operation = 'E';
        $year = date('Y');
        $pdar_name = $this->pattamodel->getPattadarNameById($data['pdar_name'], $dag[0]['dag_no'])->result();

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
        redirect(base_url() . "index.php/MutationBacklog/pattadardetails?cron_no=$cron_no");
        //}
    }

    public function copattaddarConsent() {
$db=  $this->session->userdata('db');
        $this->load->library('pagination');

        $config['base_url'] = base_url() . '/index.php/lmmutation/copattaddarConsent/';

        $count_query = "select count(*) as c from    field_mut_basic where order_passed is null and "
                . "mut_type='02'";
        $config['total_rows'] = $this->db->query($count_query)->row()->c;
        $config['per_page'] = 10;

        $config['full_tag_open'] = '<ul class="tsc_pagination tsc_paginationA tsc_paginationA01">';
        $config['full_tag_close'] = '</ul>';
        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="current"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['first_link'] = '&lt;&lt;';
        $config['last_link'] = '&gt;&gt;';
        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $patitioncases['cases'] = $this->db->query("select * from    field_mut_basic "
                        . "where mut_type='02' and order_passed is null limit $config[per_page] offset $page")->result();
        $this->load->view('../views/header');
        //$this->load->view('menu/menu4');
        $this->load->view('../views/lmmutation/copattadarconsent', $patitioncases);
        $this->load->view('../views/footer');
    }

    public function takeconsent() {
		$db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data = $_POST;
            print_r($data);

            $consent_pattadar = array();
            foreach ($data['pdar']['consentid'] as $consent) {

                $temp = array(
                    'id' => $consent,
                    'name' => $data['pdar']['id'][$consent],
                    'comment' => $data['pdar']['comment'][$consent],
                );

                array_push($consent_pattadar, $temp);
            }
            ////var_dump($consent_pattadar);

            foreach ($consent_pattadar as $pattadar) {

                $data = array(
                    'dist_code' => $data['dist_code'],
                    'subdiv_code' => $data['subdiv_code'],
                    'cir_code' => $data['cir_code'],
                    'mouza_pargona_code' => $data['mouza_pargona_code'],
                    'lot_no' => $data['lot_no'],
                    'vill_townprt_code' => $data['vill_townprt_code'],
                    'patta_no' => trim($data['patta_no']),
                    'patta_type_code' => $data['patta_type_code'],
                    'case_no' => $data['case_no'],
                    'copattadar_id' => $pattadar['id'],
                    'copattadar_name' => $pattadar['name'],
                    'copattadar_comment' => $pattadar['comment'],
                    'mut_type' => '02',
                    'entry_date' => date('Y-m-d G:i:s'),
                    'date_of_order' => date('Y-m-d G:i:s'),
                    'consent' => 'y'
                );
                ////var_dump($data);
                $this->db->insert('copattadar_consent', $data);
                redirect(base_url() . "index.php/home");
            }
        } else if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $case_no = base64_decode($this->input->get('case_no'));

            $location = $this->db->query("select * from    field_part_petitioner where case_no='$case_no'")->row();
            $q = "select * from    chitha_pattadar p join 
            chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code 
            and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and
            p.pdar_id = d.pdar_id where p.dist_code='$location->dist_code' and p.subdiv_code='$location->subdiv_code' and p.cir_code='$location->cir_code' and
            p.mouza_pargona_code='$location->mouza_pargona_code' and p.vill_townprt_code='$location->vill_townprt_code' 
            and d.lot_no='$location->lot_no' and d.dag_no='$location->dag_no' and TRIM(p.patta_no)=trim('$location->patta_no') 
            and p.patta_type_code='$location->patta_type_code' and p.pdar_id not in"
                    . " (select pdar_id from    field_part_petitioner where "
                    . "dist_code='$location->dist_code' and subdiv_code='$location->subdiv_code' and cir_code='$location->cir_code' and
                         mouza_pargona_code='$location->mouza_pargona_code' and vill_townprt_code='$location->vill_townprt_code' 
                        and lot_no='$location->lot_no' and dag_no='$location->dag_no' and TRIM(patta_no)=trim('$location->patta_no') 
                        and patta_type_code='$location->patta_type_code')";

            $data = $this->db->query($q)->result();

            $this->load->view('../views/header');
            //$this->load->view('menu/menu4');
            $d['pdars'] = $data;
            $d['case_no'] = $case_no;
            $d['location'] = $location;
            $this->load->view('../views/lmmutation/takeconsent', $d);
            $this->load->view('../views/footer');
        }
    }

    public function getPendingOfficeMutationCases() {
		$db=  $this->session->userdata('db');
        $this->load->library('pagination');
        $config['base_url'] = base_url() . 'index.php/coofficemutation/'
                . 'getPendingOfficeMutationCases';

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $lot_no = $this->session->userdata('lot_no');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $c_q = "SELECT count(*) as c FROM  Petition_basic WHERE lm_note_date is null and  not_fresh='Y'"
                . " and sk_comment is null and order_passed is"
                . " null and mut_type='03' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                . " cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code'";
        //echo $c_q;
        $cases = $this->db->query("SELECT * FROM  Petition_basic WHERE lm_note_date is null and  "
                        . " not_fresh='Y' and sk_comment is null and order_passed is"
                        . " null and mut_type='03' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                        . " cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' "
                        . "order by mut_type,Year_no,Petition_no ")->result();
        $data['cases'] = $cases;
        $this->load->view('../views/header');
        //$this->load->view('menu/menu4');
        $this->load->view('../views/lmmutation/pendingofficecases', $data);
        $this->load->view('../views/footer');
    }

    public function getPendingOfficePartitionCases() {
$db=  $this->session->userdata('db');
        //$this->load->library('pagination');
        ////var_dump($this->session->all_userdata());

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_townprt_code');

        $cases = $this->db->query("SELECT * FROM  Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                        . "cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and mut_type='04'"
                        . " and not_fresh='Y' and status='P'  and (lm_note_yn is null ) and (lm_note_date is null) order by year_no,petition_no ")->result();

        //echo $c_q;
        //$cases = $this->db->query($c_q)->result();

        $data['cases'] = $cases;
        $this->load->view('../views/header');
        //$this->load->view('menu/menu4');
        $this->load->view('../views/partition/pendingofficecases', $data);
        $this->load->view('../views/footer');
    }

    // edited on 17/9/2015 
    public function getPendingOfficeByayPrakCases() {
$db=  $this->session->userdata('db');
        //$this->load->library('pagination');
        ////var_dump($this->session->all_userdata());

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_townprt_code');

        $c_q = "SELECT * FROM  Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and mut_type='04' and status='P'  and not_fresh='Y' "
                . "and byayprak_yn is null ";
        $cases = $this->db->query($c_q)->result();

        $data['cases'] = $cases;
        $this->load->view('../views/header');
        //$this->load->view('menu/menu4');
        $this->load->view('../views/partition/pendingofficebyayprkcases', $data);
        $this->load->view('../views/footer');
    }

    // edited on 17/9/2015  bhrigu

    public function getPendingOfficeConversionCases() {
$db=  $this->session->userdata('db');
        $this->load->library('pagination');

        $config['base_url'] = base_url() . 'index.php/lmmutation/'
                . 'getPendingOfficeConversionCases';
        $c_q = "SELECT count(*) as c FROM  Petition_basic WHERE lm_note_date is null and  not_fresh='Y'"
                . " and sk_comment is null and order_passed is"
                . " null and mut_type='01' ";
        $config['total_rows'] = $this->db->query($c_q)->row()->c;
        $config['per_page'] = 5;

        $config['full_tag_open'] = '<ul class="tsc_pagination tsc_paginationA tsc_paginationA01">';
        $config['full_tag_close'] = '</ul>';
        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="current"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['first_link'] = '&lt;&lt;';
        $config['last_link'] = '&gt;&gt;';
        $config['page_query_string'] = TRUE;

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $this->pagination->initialize($config);

        $cases = $this->db->query("SELECT * FROM  Petition_basic WHERE lm_note_date is null and  "
                        . " not_fresh='Y' and sk_comment is null and order_passed is"
                        . " null and mut_type='01' "
                        . "order by mut_type,Year_no,Petition_no  limit $config[per_page] offset $page")->result();
        $data['cases'] = $cases;
        $this->load->view('../views/header');
        //$this->load->view('menu/menu4');
        $this->load->view('../views/lmmutation/pendingofficecases', $data);
        $this->load->view('../views/footer');
    }

    public function writeOfficeReport() {
$db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data = array();
//            ///var_dump($_POST);
            foreach ($_POST as $key => $value) {
                $data[$key] = $value;
            }
            unset($data['case_no']);
            $m_dag_area_b = $this->input->post('mut_b');
            $m_dag_area_k = $this->input->post('mut_k');
            $m_dag_area_lc = $this->input->post('mut_lc');
            $m_dag_area_g = $this->input->post('mut_g');
            $m_dag_area_kr = $this->input->post('mut_kr');



            $petition_no = $this->input->post('petition_no');

            $q = "update petition_dag_details set m_dag_area_b='$m_dag_area_b', m_dag_area_k=$m_dag_area_k,"
                    . " m_dag_area_lc=$m_dag_area_lc, m_dag_area_g=$m_dag_area_g,m_dag_area_kr=$m_dag_area_kr where"
                    . " petition_no = $petition_no";
            $this->db->query($q);

            $data['lm_code'] = $this->session->userdata('user_code');
            $data['user_code'] = $this->session->userdata('user_code');
            $data['lm_sign_yn'] = 'Y';
            $data['operation'] = 'E';
            $data['date_entry'] = date('Y-m-d G:i:s');
            $data['year_no'] = date('Y');



            $note_no = $this->db->query("select count(note_no)+1 as note_no from    petition_lm_note where "
                            . " petition_no=$petition_no")->row()->note_no;
            $data['note_no'] = $note_no;
            $data['lm_sign_date'] = date('Y-m-d G:i:s');

            ////var_dump($data);

            $this->db->insert('petition_lm_note', $data);

            $updateLmNote = "update petition_basic set lm_note_yn='Y',lm_note_date='" . date('Y-m-d G:i:s') . "' "
                    . " where petition_no = $petition_no";
            $this->db->query($updateLmNote);
            $case_no = $this->input->post('case_no');
            redirect(base_url() . "index.php/lmmutation/showInplaceAlongwith?case_no=$case_no");
        } else if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $case_no = $this->input->get('case_no');
            $data['case_no'] = $case_no;
            $query = "select * from    petition_basic where case_no='$case_no'";

            $petition = $this->db->query($query)->row();
            $petition_no = $petition->petition_no;
            $dags_query = "select * from    petition_dag_details where petition_no=$petition_no";

            $dags = $this->db->query($dags_query)->row();
            $data['dags'] = $dags;

            $data['petition'] = $petition;
            //var_dump($data);
            $this->load->view('../views/header');
            //$this->load->view('menu/menu4');
            $this->load->view('../views/lmmutation/officereport', $data);
            $this->load->view('../views/footer');
        }
    }

    public function freshReportAll() {
		$db=  $this->session->userdata('db');
        $this->load->library('pagination');
        $query = "select * from    field_mut_basic where co_flag_for_fresh_mut='Y'";
        $cases = $this->db->query($query)->result();
        $data['cases'] = $cases;
        $this->load->view('../views/header');
        //$this->load->view('menu/menu4');
        $this->load->view('../views/lmmutation/freshreportcases', $data);
        $this->load->view('../views/footer');
    }

    public function freshReportStep1() {
		$db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data = array();
            foreach ($_POST as $key => $v) {
                $data[$key] = $v;
            }

            $this->session->set_userdata($data);
            redirect(base_url() . "index.php/lmmutation/freshReportStep2");
        } else if ($this->input->server('REQUEST_METHOD') == 'GET') {

            $case_no = $this->input->get('case_no');
            $this->session->set_userdata(array('case_no' => $case_no));
            $mutation['type'] = $this->mutationmodel->getMutatedLandAreaJSONType();
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $query_string = "dist_code = '$dist_code' and subdiv_code='$subdiv_code' and cir_code = '$cir_code' ";
            $mutation['user'] = $this->db->query("select * from    users where " . $query_string)->result();

            $existingMutation = "select mut_type from    field_mut_basic where case_no='$case_no'";

            $existingAddressedTo = "select add_off_name from    field_mut_basic where case_no='$case_no'";
            $existingTransferType = "select trans_code from    field_mut_basic where case_no='$case_no'";
            $existingPattaType = "select patta_type_code from    field_mut_dag_details where case_no='$case_no'";
            $existingDesignation = "select add_off_desig from    field_mut_basic where case_no='$case_no'";
            $existingRegistration = "select deed_reg_no from    field_mut_dag_details where case_no='$case_no'";

            $existingDeedValue = "select deed_value from    field_mut_dag_details where case_no='$case_no'";
            $existingDeedDate = "select deed_date from    field_mut_dag_details where case_no='$case_no'";
            $existingReportDate = "select date_entry from    field_mut_basic where case_no='$case_no'";
            $existingPattaNo = "select patta_no from    field_mut_dag_details where case_no='$case_no'";

            $existingRajah = "select rajah_adalat from    field_mut_basic where case_no='$case_no'";
            $existingPossesion = "select possession_yn from    field_mut_basic where case_no='$case_no'";
            $existingDispute = "select dispute_yn from    field_mut_basic where case_no='$case_no'";

            $existingVillQ = "select vill_townprt_code from    field_mut_dag_details where case_no='$case_no'";
            $existingPattaNoQ = "select patta_no from    field_mut_dag_details where case_no='$case_no'";
            $existingDagQ = "select dag_no from    field_mut_dag_details where case_no='$case_no'";
            $existingPattaTypeQ = "select patta_type_code from    field_mut_dag_details where case_no='$case_no'";



            $mutation['emuttype'] = $this->db->query($existingMutation)->row()->mut_type;
            $mutation['eAddressedTo'] = $this->db->query($existingAddressedTo)->row()->add_off_name;
            $mutation['eTransferType'] = $this->db->query($existingTransferType)->row()->trans_code;
            $mutation['ePattaType'] = $this->db->query($existingPattaType)->row()->patta_type_code;
            $mutation['eDesignation'] = $this->db->query($existingDesignation)->row()->add_off_desig;
            $mutation['eRegistration'] = $this->db->query($existingRegistration)->row()->deed_reg_no;
            $mutation['eDeedValue'] = $this->db->query($existingDeedValue)->row()->deed_value;
            $mutation['eDeedDate'] = $this->db->query($existingDeedDate)->row()->deed_date;
            $mutation['eReportDate'] = $this->db->query($existingReportDate)->row()->date_entry;
            $mutation['ePattaNo'] = $this->db->query($existingPattaNo)->row()->patta_no;

            $mutation['eRajah'] = $this->db->query($existingRajah)->row()->rajah_adalat;
            $mutation['ePossesion'] = $this->db->query($existingPossesion)->row()->possession_yn;
            $mutation['eDispute'] = $this->db->query($existingDispute)->row()->dispute_yn;

            $existingVill = $this->db->query($existingVillQ)->row()->vill_townprt_code;
            $existingPattaNo = $this->db->query($existingPattaNoQ)->row()->patta_no;
            $existingDag = $this->db->query($existingDagQ)->row()->dag_no;
            $existingPattaType = $this->db->query($existingPattaTypeQ)->row()->patta_type_code;

            $this->session->set_userdata(array('vill_code' => $existingVill));
            $this->session->set_userdata(array('patta_no' => trim($existingPattaNo)));
            $this->session->set_userdata(array('patta_type_code' => trim($existingPattaNo)));
            $this->session->set_userdata(array('dag_no' => $existingDag));
            $this->session->set_userdata(array('mutation_type' => $mutation['emuttype']));

            $this->load->view('../views/header');
            //$this->load->view('menu/menu4');
            $this->load->view('../views/lmmutation/mutationtypefresh', $mutation);
            $this->load->view('../views/footer');
        }
    }

    public function freshReportStep2() {
$db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $case_no = $this->session->userdata('case_no');

            $apps = "select * from    field_mut_petitioner where case_no='$case_no'";
            $applicants = $this->db->query($apps)->result();
            $data['applicants'] = $applicants;
            $this->load->view('../views/header');
            //$this->load->view('menu/menu4');
            $this->load->view('../views/lmmutation/applicantsfresh', $data);
            $this->load->view('../views/footer');
        }
    }

    public function saveFreshApplicants() {
		$db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $main = $this->input->post('applicant');
            $applicants = array();
            $total_b = 0;
            $total_k = 0;
            $total_lc = 0;
            foreach ($main as $m) {

                $applicants[] = array(
                    'pet_name' => $m['name'],
                    'guard_name' => $m['g'],
                    'guard_rel' => $m['r'],
                    'add1' => $m['a1'],
                    'add2' => $m['a2'],
                    'applied_b' => $m['b'],
                    'applied_k' => $m['k'],
                    'applied_lc' => $m['lc'],
                    'pet_id' => $m['pet_id'],
                );
                $total_b+=$m['b'];
                $total_k+=$m['k'];
                $total_lc+=$m['lc'];
            }

            $this->session->set_userdata(array('applicants' => $applicants));
            $this->session->set_userdata(array('total_b' => $total_b, 'total_k' => $total_k, 'total_lc' => $total_lc));
            redirect(base_url() . "index.php/lmmutation/landareafresh");
        }
    }

    public function landAreaFresh() {
		$db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $case_no = $this->session->userdata('case_no');

            $q = "select * from    field_mut_dag_details where case_no='$case_no'";

            $dags = $this->db->query($q)->row();

            $data['dag'] = $dags;

            $this->load->view('../views/header');
            //$this->load->view('menu/menu4');
            $this->load->view('../views/lmmutation/mutationlandareafreshtest', $data);
            $this->load->view('../views/footer');
        } else if ($this->input->server('REQUEST_METHOD') == 'POST') {
            foreach ($_POST as $key => $v) {
                $data[$key] = $v;
            }

            $this->session->set_userdata(array('dag' => $data));
            redirect(base_url() . "index.php/lmmutation/pattadarDetailsFresh");
        }
    }

    public function pattadarDetailsFresh() {
		$db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data = array();
            foreach ($_POST as $key => $value) {
                $data[$key] = $value;
            }
            if ($this->session->userdata('pat_det')) {
                $pat_det = $this->session->userdata('pat_det');
                $pat_det[] = $data;
                $this->session->set_userdata(array('pat_det' => $pat_det));
            } else {
                $temp = array();
                $temp[] = $data;

                $this->session->set_userdata(array('pat_det' => $temp));
            }
            $case_no = $this->session->userdata('case_no');
            //var_dump($this->session->all_userdata());
            if ($this->input->post('pdar_cron_no') == null)
                $pattadar_cron_no = 1;
            else
                $pattadar_cron_no = $this->input->post('pdar_cron_no') + 1;

            $data['mut_type'] = $this->session->userdata('mutation_type');

            if ($data['mut_type'] == '01') {
                $q = "select * from    field_mut_pattadar where case_no='$case_no' offset $pattadar_cron_no-1";

                $num = $this->db->query("select * from    field_mut_pattadar where case_no='$case_no' offset $pattadar_cron_no-1")->num_rows();
                if ($num <= 0) {
                    echo 'finished';
                } else {
                    $data['pattadars'] = $this->db->query("select * from    field_mut_pattadar where case_no='$case_no' offset $pattadar_cron_no-1")->result();
                }
            } else if ($data['mut_type'] == '02') {
                $data['pattadars'] = $this->db->query("select * from    field_mut_pattadar where case_no='$case_no'")->result();
            }


            $data['pattadar_cron_no'] = $pattadar_cron_no;
            $data['pattadar_next'] = $this->session->userdata('pattadar_next') ? true : false;
            // //var_dump($data['pattadars']);
            $this->load->view('../views/header');
            //$this->load->view('menu/menu4');
            $this->load->view('../views/lmmutation/pattadardetailsfresh', $data);
            $this->load->view('../views/footer');
        } else if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $pattadar_cron_no = 1;

            $case_no = $this->session->userdata('case_no');

            if ($this->input->get('cron_no') == null)
                $pattadar_cron_no = 1;
            else
                $pattadar_cron_no = $this->input->get('cron_no');


            $data['mut_type'] = $this->session->userdata('mutation_type');

            if ($data['mut_type'] == '01') {
                $data['pattadars'] = $this->db->query("select * from    field_mut_pattadar where case_no='$case_no' offset $pattadar_cron_no -1")->result();
            } else if ($data['mut_type'] == '02') {
                $data['pattadars'] = $this->db->query("select * from    field_mut_pattadar where case_no='$case_no'")->result();
            }


            $data['pattadar_cron_no'] = $pattadar_cron_no;
            $data['pattadar_next'] = $this->session->userdata('pattadar_next') ? true : false;
            // //var_dump($data['pattadars']);
            $this->load->view('../views/header');
            //$this->load->view('menu/menu4');
            $this->load->view('../views/lmmutation/pattadardetailsfresh', $data);
            $this->load->view('../views/footer');
        }
    }

    public function savelAllFresh() {
		$db=  $this->session->userdata('db');
        //var_dump($this->session->all_userdata());
        $basic_data = array(
            'user_code' => $this->session->userdata('user_code'),
            'case_no' => $this->session->userdata('case_no'),
            'trans_code' => $this->session->userdata('transfer_type'),
            'add_off_name' => $this->session->userdata('add_of_name'),
            'add_off_desig' => $this->session->userdata('add_of_desig'),
            'reg_deed_no' => $this->session->userdata('reg_deed_no'),
            'deed_value' => $this->session->userdata('reg_deed_value'),
            'reg_deed_date' => $this->session->userdata('reg_deed_date'),
            'report_date' => $this->session->userdata('report_date'),
            'rajah_adalat' => $this->session->userdata('rajah_adalat'),
            'possession_yn' => $this->session->userdata('possession_yn'),
            'mut_type' => $this->session->userdata('mutation_type'),
            ''
        );

        $this->db->where('case_no', $this->session->userdata('case_no'));
        $this->db->update('field_mut_basic', $basic_data);

        $pet_data = $this->session->userdata('applicants');
        foreach ($pet_data as $pet) {
            $petD = array(
                'pet_name' => $pet['pet_name'],
                'guard_name' => $pet['guard_name'],
                'guard_rel' => $pet['guard_rel'],
                'add1' => $pet['add1'],
                'add2' => $pet['add2'],
                'applied_b' => $pet['applied_b'],
                'applied_k' => $pet['applied_k'],
                'applied_lc' => $pet['applied_lc'],
                'pet_id' => $pet['pet_id']
            );

            $this->db->where('case_no', $this->session->userdata('case_no'));
            $this->db->update('field_mut_petitioner', $petD);
        }
        $pat_data = $this->session->userdata('pat_det');

        foreach ($pat_data as $pat) {
            //var_dump($pat);
            $patD = array(
                'pdar_cron_no' => $pat['pdar_cron_no'],
                'pdar_id' => $pat['pdar_id'],
                'pdar_name' => $pat['pdar_name'],
                'striked_out' => $pat['striked_out'],
                'pdar_guardian' => $pat['pdar_guardian'],
                'pdar_rel_guar' => $pat['pdar_rel_guar'],
                'pdar_add1' => $pat['pdar_add1'],
                'pdar_add2' => $pat['pdar_add2'],
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d'),
                'operation' => 'E'
            );

            $this->db->where(array('case_no' => $this->session->userdata('case_no'), 'pdar_id' => $pat['pdar_id'], 'pdar_cron_no' => $pat['pdar_cron_no']));

            $this->db->update('field_mut_pattadar', $patD);
        }

        $dat_det = $this->session->userdata('dag');
        $dagData = array(
            'dag_no' => $dat_det['dag_no'],
            'dag_area_b' => $dat_det['dag_area_b'],
            'dag_area_k' => $dat_det['dag_area_k'],
            'dag_area_lc' => $dat_det['dag_area_lc'],
            'dag_area_g' => $dat_det['dag_area_g'],
            'dag_area_kr' => $dat_det['dag_area_kr'],
            'm_dag_area_b' => $dat_det['m_dag_area_b'],
            'm_dag_area_k' => $dat_det['m_dag_area_k'],
            'm_dag_area_lc' => $dat_det['m_dag_area_lc'],
            'm_dag_area_g' => $dat_det['m_dag_area_lc'],
            'm_dag_area_kr' => $dat_det['m_dag_area_kr'],
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d'),
            'operation' => 'E'
        );
        $this->db->where(array('case_no' => $this->session->userdata('case_no'), 'dag_no' => $dat_det['dag_no']));
        $this->db->update('field_mut_dag_details', $dagData);
    }

//     public function saveAll() {
// $db=  $this->session->userdata('db');
//         $fmb = $this->session->userdata('fmb');
//         $dag_det = $this->session->userdata('dag_det');

//         $appdet = $this->session->userdata('appdet');
//         $patdet = $this->session->userdata('patdet');
//         $mut = $this->session->userdata('mut_type');
//         $dist_code = $fmb['dist_code'];
//         $subdiv_code = $fmb['subdiv_code'];
//         $cir_code = $fmb['cir_code'];
//         $mouza_pargona_code = $fmb['mouza_pargona_code'];
//         $lot_no = $fmb['lot_no'];
//         $vill_townprt_code = $fmb['vill_townprt_code'];
//         $patta_no = trim($dag_det[0]['patta_no']);
//         $patta_type_code = $dag_det[0]['patta_type_code'];
//         $dag_no = $dag_det[0]['dag_no'];
//         $query = "select land_class_code as lc from    chitha_basic  where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? "
//                 . " and lot_no=? and vill_townprt_code=? and TRIM(patta_no)=? and patta_type_code=?";
//         $landclasscode = $this->db->query($query, array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $patta_type_code))->row()->lc;

//         $data = array(
//             'dist_code' => $dist_code,
//             'subdiv_code' => $subdiv_code,
//             'cir_code' => $cir_code,
//             'mouza_pargona_code' => $mouza_pargona_code,
//             'lot_no' => $lot_no,
//             'vill_townprt_code' => $vill_townprt_code,
//             'patta_no' => $patta_no,
//             'patta_type_code' => $patta_type_code,
//             'user_code' => $this->session->userdata('user_code'),
//             'entry_date' => date('Y-m-d'),
//             'entry_mode' => 'E'
//         );
//         $q = "select count(*) as count from    jama_patta where dist_code='$dist_code' and subdiv_code='$subdiv_code' "
//                 . "and cir_code='$cir_code' and"
//                 . " mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' "
//                 . " and patta_type_code='$patta_type_code' and TRIM(patta_no)='$patta_no'"
//                 . " ";

//         $count = $this->db->query($q)->row()->count;

//         if ($count == 0) {
//             $this->db->insert('jama_patta', $data);
//         }

//         $dagData = array(
//             'dist_code' => $dist_code,
//             'subdiv_code' => $subdiv_code,
//             'cir_code' => $cir_code,
//             'mouza_pargona_code' => $mouza_pargona_code,
//             'lot_no' => $lot_no,
//             'vill_townprt_code' => $vill_townprt_code,
//             'patta_no' => $patta_no,
//             'patta_type_code' => $patta_type_code,
//             'user_code' => $this->session->userdata('user_code'),
//             'entry_date' => date('Y-m-d'),
//             'dag_class_code' => $landclasscode,
//             'entry_mode' => 'E',
//             'dag_area_b' => $dag_det[0]['m_dag_area_b'],
//             'dag_area_k' => $dag_det[0]['m_dag_area_k'],
//             'dag_area_lc' => $dag_det[0]['m_dag_area_lc'],
//             'dag_area_g' => 0,
//             'dag_area_kr' => 0,
//             'dag_no' => $dag_no
//         );

//         $qe = "select count(*) as count from    jama_dag where" . "  dist_code='$dist_code' and subdiv_code='$subdiv_code' and"
//                 . " cir_code='$cir_code' and"
//                 . " mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code'  and "
//                 . " dag_no='$dag_no' and TRIM(patta_no) ='$patta_no' and patta_type_code='$patta_type_code'"
//                 . " ";
//         $count = $this->db->query($qe)->row()->count;

//         if ($count == 0) {
//             $this->db->insert('jama_dag', $dagData);
//         }
//         $lineNo = "select max(rmk_line_no)+1 as max from    jama_remark where dist_code='$dist_code' and"
//                 . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and "
//                 . "  lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and patta_type_code='$patta_type_code' and "
//                 . " TRIM(patta_no)='$patta_no'";
//         $line_no = $this->db->query($lineNo)->row()->max;
//         if ($line_no == null) {
//             $line_no = 1;
//         }

//         $remarkData = array(
//             'dist_code' => $dist_code,
//             'subdiv_code' => $subdiv_code,
//             'cir_code' => $cir_code,
//             'mouza_pargona_code' => $mouza_pargona_code,
//             'lot_no' => $lot_no,
//             'vill_townprt_code' => $vill_townprt_code,
//             'patta_no' => $patta_no,
//             'patta_type_code' => $patta_type_code,
//             'rmk_line_no' => $line_no++,
//             'remark' => $this->session->userdata('order'),
//             'user_code' => $this->session->userdata('user_code'),
//             'entry_date' => date('Y-m-d'),
//             'entry_mode' => 'U'
//         );

//         $orders = array(
//             'dist_code' => $dist_code,
//             'subdiv_code' => $subdiv_code,
//             'cir_code' => $cir_code,
//             'mouza_pargona_code' => $mouza_pargona_code,
//             'lot_no' => $lot_no,
//             'vill_townprt_code' => $vill_townprt_code,
//             'patta_no' => $patta_no,
//             'patta_type_code' => $patta_type_code,
//             'remark' => $this->session->userdata('order'),
//             'user_code' => $this->session->userdata('user_code'),
//             'date_entry' => date('Y-m-d'),
//             'category' => $this->session->userdata('order_category'),
//             'dag_no' => $dag_no
//         );

//         $this->db->insert('backlog_orders', $orders);

//         $this->db->insert('jama_remark', $remarkData);

//         if ($mut === '01') {
//             foreach ($appdet as $app) {
//                 $query = "select max(pdar_id)+1 as pdar_id from    chitha_pattadar where dist_code=? and subdiv_code=? and cir_code=? and "
//                         . "mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and TRIM(patta_no)=? and patta_type_code=?";
//                 $pdar_id = $this->db->query($query, array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $patta_type_code))->row()->pdar_id;
//                 $pattadar = array(
//                     'dist_code' => $fmb['dist_code'],
//                     'subdiv_code' => $fmb['subdiv_code'],
//                     'cir_code' => $fmb['cir_code'],
//                     'mouza_pargona_code' => $fmb['mouza_pargona_code'],
//                     'lot_no' => $fmb['lot_no'],
//                     'vill_townprt_code' => $fmb['vill_townprt_code'],
//                     'patta_no' => $patta_no,
//                     'patta_type_code' => $patta_type_code,
//                     'pdar_name' => $app['pet_name'],
//                     'pdar_father' => $app['guard_name'],
//                     'pdar_id' => $pdar_id,
//                     'user_code' => $this->session->userdata('user_code'),
//                     'date_entry' => date('Y-m-d'),
//                     'operation' => 'E',
//                     'jama_yn' => 'N',
//                     'new_pdar_name' => 'N'
//                 );
//                 $this->db->insert('chitha_pattadar', $pattadar);

//                 $dagPattadar = array(
//                     'dist_code' => $fmb['dist_code'],
//                     'subdiv_code' => $fmb['subdiv_code'],
//                     'cir_code' => $fmb['cir_code'],
//                     'mouza_pargona_code' => $fmb['mouza_pargona_code'],
//                     'lot_no' => $fmb['lot_no'],
//                     'vill_townprt_code' => $fmb['vill_townprt_code'],
//                     'patta_no' => $patta_no,
//                     'patta_type_code' => $patta_type_code,
//                     'pdar_id' => $pdar_id,
//                     'user_code' => $this->session->userdata('user_code'),
//                     'date_entry' => date('Y-m-d'),
//                     'operation' => 'E',
//                     'jama_yn' => 'N',
//                     'dag_no' => $dag_det[0]['dag_no'],
//                     'dag_por_b' => 0,
//                     'dag_por_k' => 0,
//                     'dag_por_lc' => 0,
//                     'dag_por_g' => 0,
//                     'dag_por_kr' => 0,
//                     'p_flag' => '0'
//                 );
//                 $this->db->insert('chitha_dag_pattadar', $dagPattadar);
//             }

//             foreach ($patdet as $p) {
//                 $p_flag = $p['striked_out'];
//                 $pid = $p['pdar_id'];

//                 if ($p_flag == 1) {
//                     $query = "update chitha_dag_pattadar set p_flag='1' where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? "
//                             . " and lot_no=? and vill_townprt_code=? and TRIM(patta_no)=? and patta_type_code='$patta_type_code'  and pdar_id=$pid";
//                 } else {
//                     $query = "update chitha_dag_pattadar set p_flag='0' where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? "
//                             . " and lot_no=? and vill_townprt_code=? and TRIM(patta_no)=? and patta_type_code='$patta_type_code' and pdar_id=$pid";
//                 }
//                 $this->db->query($query, array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no));
//             }

//             $query_pattadars = "select * from    chitha_pattadar as cp,chitha_dag_pattadar as dp"
//                     . " where TRIM(cp.patta_no) = TRIM(dp.patta_no) and cp.pdar_id = dp.pdar_id and cp.patta_type_code = dp.patta_type_code"
//                     . " and cp.dist_code = dp.dist_code and cp.subdiv_code = dp.subdiv_code and cp.cir_code = dp.cir_code "
//                     . " and cp.mouza_pargona_code = dp.mouza_pargona_code and cp.lot_no = dp.lot_no and "
//                     . " cp.vill_townprt_code = dp.vill_townprt_code and "
//                     . " cp.dist_code='$dist_code' and cp.subdiv_code='$subdiv_code' and cp.cir_code='$cir_code' and"
//                     . " cp.mouza_pargona_code='$mouza_pargona_code' and cp.lot_no='$lot_no' and cp.vill_townprt_code='$vill_townprt_code'  "
//                     . " and TRIM(cp.patta_no)='$patta_no' and cp.patta_type_code='$patta_type_code' and dag_no='$dag_no'";

//             $pattadars = $this->db->query($query_pattadars)->result();
//             foreach ($pattadars as $p) {

//                 $pdar_id = $p->pdar_id;
//                 $count_q = "select count(*) as count from    chitha_dag_pattadar where dist_code='$dist_code' and"
//                         . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and "
//                         . "  lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and patta_type_code='$patta_type_code' and "
//                         . " TRIM(patta_no)='$patta_no' and pdar_id=$pdar_id and p_flag='1'";

//                 $p_flagCount = $this->db->query($count_q)->row()->count;
//                 $count_dag_q = "select count(*) as count from    chitha_dag_pattadar where dist_code='$dist_code' and"
//                         . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and "
//                         . "  lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and patta_type_code='$patta_type_code' and "
//                         . " TRIM(patta_no)='$patta_no' and pdar_id = $pdar_id";

//                 $dag_presentCount = $this->db->query($count_dag_q)->row()->count;

//                 if ($p_flagCount == $dag_presentCount) {
//                     $p->p_flag = '1';
//                 } else {
//                     $p->p_flag = '0';
//                 }

//                 $p->pdar_land_b = $p->dag_por_b;
//                 $p->pdar_land_k = $p->dag_por_k;
//                 $p->pdar_land_lc = $p->dag_por_lc;
//                 $p->pdar_land_g = $p->dag_por_g;
//                 $p->pdar_land_kr = $p->dag_por_kr;
//                 $p->entry_date = $p->date_entry;
//                 $p->entry_mode = 'U';
//                 $p->pdar_id = $p->pdar_id;
//                 unset($p->dag_por_b);
//                 unset($p->dag_por_k);
//                 unset($p->dag_por_lc);
//                 unset($p->dag_por_g);
//                 unset($p->dag_por_kr);

//                 unset($p->date_entry);
//                 unset($p->operation);
//                 unset($p->jama_yn);
//                 unset($p->pdar_guard_reln);
//                 unset($p->f1_case_no);
//                 unset($p->f2_case_no);
//                 unset($p->o1_case_no);
//                 unset($p->o2_case_no);
//                 unset($p->dag_no);
//                 $query = "select count(*) as count from    jama_pattadar where dist_code='$p->dist_code' and subdiv_code='$p->subdiv_code' and 
// 			cir_code='$p->cir_code' and lot_no='$p->lot_no' and vill_townprt_code='$p->vill_townprt_code' and 
// 			mouza_pargona_code='$p->mouza_pargona_code' and TRIM(patta_no)=trim('$p->patta_no') and patta_type_code='$p->patta_type_code' and pdar_id='$p->pdar_id'";

//                 $count = $this->db->query($query)->row()->count;
//                 if ($count == 0) {
//                     $this->db->insert('jama_pattadar', $p);
//                 } else {
//                     $query = "update jama_pattadar set p_flag='$p->p_flag' where  dist_code='$p->dist_code' and subdiv_code='$p->subdiv_code' and 
//                     cir_code='$p->cir_code' and lot_no='$p->lot_no' and vill_townprt_code='$p->vill_townprt_code' and 
//                     mouza_pargona_code='$p->mouza_pargona_code' and TRIM(patta_no)=trim('$p->patta_no') and patta_type_code='$p->patta_type_code' and pdar_id='$p->pdar_id'";
//                     $this->db->query($query);
//                 }
//                 $count++;
//             }
//         }
//         if ($mut === '02') {

//             $patta_no = trim($this->session->userdata('new_patta'));
//             $dag_no = $this->session->userdata('new_dag');

//             $data = array(
//                 'dist_code' => $dist_code,
//                 'subdiv_code' => $subdiv_code,
//                 'cir_code' => $cir_code,
//                 'mouza_pargona_code' => $mouza_pargona_code,
//                 'lot_no' => $lot_no,
//                 'vill_townprt_code' => $vill_townprt_code,
//                 'patta_no' => $patta_no,
//                 'patta_type_code' => $patta_type_code,
//                 'user_code' => $this->session->userdata('user_code'),
//                 'entry_date' => date('Y-m-d'),
//                 'entry_mode' => 'E'
//             );
//             $q = "select count(*) as count from    jama_patta where dist_code='$dist_code' and subdiv_code='$subdiv_code' "
//                     . "and cir_code='$cir_code' and"
//                     . " mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' "
//                     . " and patta_type_code='$patta_type_code' and TRIM(patta_no)='$patta_no'"
//                     . " ";

//             $count = $this->db->query($q)->row()->count;
// 			//var_dump($data);
//             if ($count == 0) {
//                 echo $this->db->insert('jama_patta', $data);
// 				echo "jama_patta";
//             }
			
//             $dagData = array(
//                 'dist_code' => $dist_code,
//                 'subdiv_code' => $subdiv_code,
//                 'cir_code' => $cir_code,
//                 'mouza_pargona_code' => $mouza_pargona_code,
//                 'lot_no' => $lot_no,
//                 'vill_townprt_code' => $vill_townprt_code,
//                 'patta_no' => $patta_no,
//                 'patta_type_code' => $patta_type_code,
//                 'user_code' => $this->session->userdata('user_code'),
//                 'entry_date' => date('Y-m-d'),
//                 'dag_class_code' => $landclasscode,
//                 'entry_mode' => 'E',
//                 'dag_area_b' => $dag_det[0]['m_dag_area_b'],
//                 'dag_area_k' => $dag_det[0]['m_dag_area_k'],
//                 'dag_area_lc' => $dag_det[0]['m_dag_area_lc'],
//                 'dag_area_g' => 0,
//                 'dag_area_kr' => 0,
//                 'dag_no' => $dag_no
//             );

//             echo $qe = "select count(*) as count from    jama_dag where" . "  dist_code='$dist_code' and subdiv_code='$subdiv_code' and"
//                     . " cir_code='$cir_code' and"
//                     . " mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code'  and "
//                     . " dag_no='$dag_no' and TRIM(patta_no) ='$patta_no' and patta_type_code='$patta_type_code'"
//                     . " ";
//             $count = $this->db->query($qe)->row()->count;
// 			//var_dump($dagData);
// 			//exit;
//             if ($count == 0) {
//                 echo $this->db->insert('jama_dag', $dagData);
// 				echo "jama_dag";
//             }
//             $lineNo = "select max(rmk_line_no)+1 as max from    jama_remark where dist_code='$dist_code' and"
//                     . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and "
//                     . "  lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and patta_type_code='$patta_type_code' and "
//                     . " TRIM(patta_no)='$patta_no'";
//             $line_no = $this->db->query($lineNo)->row()->max;
//             if ($line_no == null) {
//                 $line_no = 1;
//             }

//             $remarkData = array(
//                 'dist_code' => $dist_code,
//                 'subdiv_code' => $subdiv_code,
//                 'cir_code' => $cir_code,
//                 'mouza_pargona_code' => $mouza_pargona_code,
//                 'lot_no' => $lot_no,
//                 'vill_townprt_code' => $vill_townprt_code,
//                 'patta_no' => $patta_no,
//                 'patta_type_code' => $patta_type_code,
//                 'rmk_line_no' => $line_no++,
//                 'remark' => $this->session->userdata('order'),
//                 'user_code' => $this->session->userdata('user_code'),
//                 'entry_date' => date('Y-m-d'),
//                 'entry_mode' => 'U'
//             );

//             $this->db->insert('jama_remark', $remarkData);

//             $query = "select dag_no as dag from    chitha_basic  where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? "
//                     . " and lot_no=? and  vill_townprt_code=? and patta_type_code=? order by dag_no_int desc";
//             $new_dag = $this->db->query($query, array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_type_code))->row()->dag + 1;

//             $query = "select CAST((COALESCE(patta_no,'0')) AS INTEGER) +1 as patta from    chitha_basic  where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? "
//                     . " and lot_no=? and vill_townprt_code=?  and patta_type_code=?";
//             $patta_nos = $this->db->query("select patta_no from    chitha_basic where dist_code = '$dist_code'"
//                             . " and subdiv_code='$subdiv_code' and cir_code = '$cir_code'"
//                             . " and mouza_pargona_code='$mouza_pargona_code'"
//                             . " and lot_no='$lot_no' and vill_townprt_code = '$vill_townprt_code'")->result();

//             $pattas = array();

//             foreach ($patta_nos as $p) {
//                 $pattas[] = trim($p->patta_no);
//             }
//             $new_patta = max($pattas) + 1;

//             $data = array(
//                 'dist_code' => $fmb['dist_code'],
//                 'subdiv_code' => $fmb['subdiv_code'],
//                 'cir_code' => $fmb['cir_code'],
//                 'mouza_pargona_code' => $fmb['mouza_pargona_code'],
//                 'lot_no' => $fmb['lot_no'],
//                 'vill_townprt_code' => $fmb['vill_townprt_code'],
//                 'dag_no' => $this->session->userdata('new_dag'),
//                 'patta_no' => trim($this->session->userdata('new_patta')),
//                 'dag_no_int' => $this->session->userdata('new_dag') . "00",
//                 'patta_type_code' => $patta_type_code,
//                 'land_class_code' => $landclasscode,
//                 'dag_area_b' => $dag_det[0]['m_dag_area_b'],
//                 'dag_area_k' => $dag_det[0]['m_dag_area_k'],
//                 'dag_area_lc' => $dag_det[0]['m_dag_area_lc'],
//                 'dag_area_g' => $dag_det[0]['m_dag_area_g'],
//                 'dag_area_kr' => $dag_det[0]['m_dag_area_kr'],
//                 'user_code' => $this->session->userdata('user_code'),
//                 'date_entry' => date('Y-m-d'),
//                 'operation' => 'E'
//             );

//             $orders = array(
//                 'dist_code' => $dist_code,
//                 'subdiv_code' => $subdiv_code,
//                 'cir_code' => $cir_code,
//                 'mouza_pargona_code' => $mouza_pargona_code,
//                 'lot_no' => $lot_no,
//                 'vill_townprt_code' => $vill_townprt_code,
//                 'patta_type_code' => $patta_type_code,
//                 'remark' => $this->session->userdata('order'),
//                 'user_code' => $this->session->userdata('user_code'),
//                 'date_entry' => date('Y-m-d'),
//                 'category' => $this->session->userdata('order_category'),
//                 'dag_no' => $this->session->userdata('new_dag'),
//                 'patta_no' => trim($this->session->userdata('new_patta')),
//                 'dag_no_int' => $this->session->userdata('new_dag') . "00",
//             );

//             $this->db->insert('backlog_orders', $orders);

//             $this->db->insert('chitha_basic', $data);
//             $pdar_id = 1;
//             var_dump($appdet);
//             foreach ($appdet as $app) {
//                 $pattadar = array(
//                     'dist_code' => $fmb['dist_code'],
//                     'subdiv_code' => $fmb['subdiv_code'],
//                     'cir_code' => $fmb['cir_code'],
//                     'mouza_pargona_code' => $fmb['mouza_pargona_code'],
//                     'lot_no' => $fmb['lot_no'],
//                     'vill_townprt_code' => $fmb['vill_townprt_code'],
//                     'patta_no' => trim($this->session->userdata('new_patta')),
//                     'patta_type_code' => $patta_type_code,
//                     'pdar_name' => $app['pdar_name'],
//                     'pdar_father' => $app['pdar_guardian'],
//                     'pdar_id' => $pdar_id,
//                     'user_code' => $this->session->userdata('user_code'),
//                     'date_entry' => date('Y-m-d'),
//                     'operation' => 'E',
//                     'jama_yn' => 'N',
//                     'new_pdar_name' => 'N'
//                 );
//                 $this->db->insert('chitha_pattadar', $pattadar);

//                 $dagPattadar = array(
//                     'dist_code' => $fmb['dist_code'],
//                     'subdiv_code' => $fmb['subdiv_code'],
//                     'cir_code' => $fmb['cir_code'],
//                     'mouza_pargona_code' => $fmb['mouza_pargona_code'],
//                     'lot_no' => $fmb['lot_no'],
//                     'vill_townprt_code' => $fmb['vill_townprt_code'],
//                     'patta_no' => trim($this->session->userdata('new_patta')),
//                     'patta_type_code' => $patta_type_code,
//                     'pdar_id' => $pdar_id,
//                     'user_code' => $this->session->userdata('user_code'),
//                     'date_entry' => date('Y-m-d'),
//                     'operation' => 'E',
//                     'jama_yn' => 'N',
//                     'dag_no' => $this->session->userdata('new_dag'),
//                     'dag_por_b' => 0,
//                     'dag_por_k' => 0,
//                     'dag_por_lc' => 0,
//                     'dag_por_g' => 0,
//                     'dag_por_kr' => 0,
//                     'p_flag' => '0'
//                 );
//                 $this->db->insert('chitha_dag_pattadar', $dagPattadar);
//                 $pdar_id++;

//                 $pdarid = $app['pdar_id'];
//                 $old_p_no = trim($app['patta_no']);
//                 $query = "update chitha_dag_pattadar set p_flag='1' where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? "
//                         . " and lot_no=? and vill_townprt_code=? and TRIM(patta_no)=? and patta_type_code=? and pdar_id=$pdarid";

//                 $this->db->query($query, array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $old_p_no, $patta_type_code));
//                 $query = "update jama_pattadar set p_flag='1',new_pdar_name=null where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? "
//                         . " and lot_no=? and vill_townprt_code=? and TRIM(patta_no)=? and patta_type_code=? and pdar_id='$pdarid'";

//                 $this->db->query($query, array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $old_p_no, $patta_type_code));
//             }
//             $mb = $dag_det[0]['m_dag_area_b'];
//             $mk = $dag_det[0]['m_dag_area_k'];
//             $mlc = $dag_det[0]['m_dag_area_lc'];

//             $sb = $dag_det[0]['dag_area_b'];
//             $sk = $dag_det[0]['dag_area_k'];
//             $slc = $dag_det[0]['dag_area_lc'];

//             $sourcelessa = $sb * 100 + $sk * 20 + $slc;
//             $mutationlessa = $mb * 100 + $mk * 20 + $mlc;

//             $remaining_lessa = $sourcelessa - $mutationlessa;

//             $left_b = floor($remaining_lessa / 100);
//             $left_k = floor(($remaining_lessa - $left_b * 100) / 20);
//             $left_lc = $remaining_lessa - $left_b * 100 - $left_k * 20;
//             $query = "update chitha_basic set dag_area_b=$left_b, dag_area_k=$left_k,dag_area_lc=$left_lc,dag_area_g=0,dag_area_kr=0 "
//                     . " where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'"
//                     . "  and mouza_pargona_code='$mouza_pargona_code' "
//                     . " and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and "
//                     . " TRIM(patta_no)='$patta_no' and patta_type_code='$patta_type_code'";

//             $this->db->query($query);

//             $query_pattadars = "select * from    chitha_pattadar as cp,chitha_dag_pattadar as dp"
//                     . " where TRIM(cp.patta_no) = TRIM(dp.patta_no) and cp.pdar_id = dp.pdar_id and cp.patta_type_code = dp.patta_type_code"
//                     . " and cp.dist_code = dp.dist_code and cp.subdiv_code = dp.subdiv_code and cp.cir_code = dp.cir_code "
//                     . " and cp.mouza_pargona_code = dp.mouza_pargona_code and cp.lot_no = dp.lot_no and "
//                     . " cp.vill_townprt_code = dp.vill_townprt_code and "
//                     . " cp.dist_code='$dist_code' and cp.subdiv_code='$subdiv_code' and cp.cir_code='$cir_code' and"
//                     . " cp.mouza_pargona_code='$mouza_pargona_code' and cp.lot_no='$lot_no' and cp.vill_townprt_code='$vill_townprt_code'  "
//                     . " and TRIM(cp.patta_no)='$patta_no' and cp.patta_type_code='$patta_type_code' and dag_no='$dag_no'";

//             $pattadars = $this->db->query($query_pattadars)->result();
//             foreach ($pattadars as $p) {

//                 $pdar_id = $p->pdar_id;
//                 $count_q = "select count(*) as count from    chitha_dag_pattadar where dist_code='$dist_code' and"
//                         . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and "
//                         . "  lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and patta_type_code='$patta_type_code' and "
//                         . " TRIM(patta_no)='$patta_no' and pdar_id=$pdar_id and p_flag='1'";

//                 $p_flagCount = $this->db->query($count_q)->row()->count;
//                 $count_dag_q = "select count(*) as count from    chitha_dag_pattadar where dist_code='$dist_code' and"
//                         . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and "
//                         . "  lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and patta_type_code='$patta_type_code' and "
//                         . " TRIM(patta_no)='$patta_no' and pdar_id = $pdar_id";

//                 $dag_presentCount = $this->db->query($count_dag_q)->row()->count;

//                 if ($p_flagCount == $dag_presentCount) {
//                     $p->p_flag = '1';
//                 } else {
//                     $p->p_flag = '0';
//                 }

//                 $p->pdar_land_b = $p->dag_por_b;
//                 $p->pdar_land_k = $p->dag_por_k;
//                 $p->pdar_land_lc = $p->dag_por_lc;
//                 $p->pdar_land_g = $p->dag_por_g;
//                 $p->pdar_land_kr = $p->dag_por_kr;
//                 $p->entry_date = $p->date_entry;
//                 $p->entry_mode = 'U';
//                 $p->pdar_id = $p->pdar_id;
//                 unset($p->dag_por_b);
//                 unset($p->dag_por_k);
//                 unset($p->dag_por_lc);
//                 unset($p->dag_por_g);
//                 unset($p->dag_por_kr);

//                 unset($p->date_entry);
//                 unset($p->operation);
//                 unset($p->jama_yn);
//                 unset($p->pdar_guard_reln);
//                 unset($p->f1_case_no);
//                 unset($p->f2_case_no);
//                 unset($p->o1_case_no);
//                 unset($p->o2_case_no);
//                 unset($p->dag_no);
//                 $query = "select count(*) as count from    jama_pattadar where dist_code='$p->dist_code' and subdiv_code='$p->subdiv_code' and 
// 			cir_code='$p->cir_code' and lot_no='$p->lot_no' and vill_townprt_code='$p->vill_townprt_code' and 
// 			mouza_pargona_code='$p->mouza_pargona_code' and TRIM(patta_no)=trim('$p->patta_no') and patta_type_code='$p->patta_type_code' and pdar_id='$p->pdar_id'";

//                 $count = $this->db->query($query)->row()->count;
//                 if ($count == 0) {
//                     $this->db->insert('jama_pattadar', $p);
//                 } else {
//                     $query = "update jama_pattadar set p_flag='$p->p_flag' where  dist_code='$p->dist_code' and subdiv_code='$p->subdiv_code' and 
//                     cir_code='$p->cir_code' and lot_no='$p->lot_no' and vill_townprt_code='$p->vill_townprt_code' and 
//                     mouza_pargona_code='$p->mouza_pargona_code' and TRIM(patta_no)=trim('$p->patta_no') and patta_type_code='$p->patta_type_code' and pdar_id='$p->pdar_id'";
//                     $this->db->query($query);
//                 }
//                 $count++;
//             }
//         }
//         $this->session->set_flashdata("message", "The Chitha Jamabandi Has been Updated");
//         redirect(base_url() . "index.php/home");
//     }

    public function canClose() {
        if (($this->session->userdata('end') != null) || ($this->session->userdata('end') != true)) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    public function showInplaceAlongwith() {
		$db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $pattadar_cron_no = 1;

            $case_no = $this->input->get('case_no');
            // //var_dump($this->session->all_userdata());
            if ($this->input->get('cron_no') == null)
                $pattadar_cron_no = 0;
            else
                $pattadar_cron_no = $this->input->get('cron_no');

            $this->load->model('patta/PattaModel');

            $data['pattadars'] = $this->PattaModel->getPattadarOffice($case_no, $pattadar_cron_no)->result();
            if (sizeof($data['pattadars']) <= 0) {
                $this->session->set_flashdata("message", "LM Report for Office Mutation Case No." . $case_no . " recorded");
                redirect(base_url() . "index.php/home");
            }
            $data['pattadar_cron_no'] = $pattadar_cron_no;
            $data['pattadar_next'] = $this->session->userdata('pattadar_next') ? true : false;
            $data['case_no'] = $case_no;
            //var_dump($data);
            $this->load->view('../views/header');
            //$this->load->view('menu/menu4');
            $this->load->view('../views/lmmutation/pattadardetailsoffice', $data);
            $this->load->view('../views/footer');
        } else if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $pattadar_cron_no = $this->input->post('pdar_cron_no');
            $pattadar_cron_no++;
            $case_no = $this->input->post('case_no');
            $pdar_id = $this->input->post('pdar_name');
            $petition_no = $this->db->query("select petition_no from    petition_basic where case_no='$case_no'")->row()->petition_no;
            $striked_out = $this->input->post('striked_out');
            if ($striked_out == '1') {
                $query = "update petition_pattadar set striked_out ='1' where"
                        . " petition_no=$petition_no and pdar_id=$pdar_id";
            } else if ($striked_out == '0') {
                $query = "update petition_pattadar set striked_out ='0' "
                        . "where petition_no=$petition_no and pdar_id=$pdar_id";
            }
            $this->db->query($query);
            $this->session->set_flashdata("message", "LM Report for Office Mutation Case No." . $case_no . " recorded");
            // //var_dump($_POST);
            redirect(base_url() . "index.php/lmmutation/showInplaceAlongwith?case_no=$case_no&cron_no=$pattadar_cron_no");
        }
    }

    public function getPattadarInformaton($pid) {
		$db=  $this->session->userdata('db');
        $pattaNo = trim($this->session->userdata('patta_no'));
        $pattaType = $this->session->userdata('patta_type');

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $lot_no = $this->session->userdata('lot_no');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');

        $query = "select  pdar_name, pdar_father,pdar_add1,pdar_add2,pdar_gender,pdar_mother,pdar_minor_yn,pdar_minor_dob,pdar_guard_reln "
                . "from    chitha_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and p.lot_no='$lot_no'  and TRIM(p.patta_no)='$pattaNo' and p.pdar_id='$pid' 
            and p.patta_type_code='$pattaType'";

        $data = $this->db->query($query)->row();
        echo json_encode($data);
    }

}
